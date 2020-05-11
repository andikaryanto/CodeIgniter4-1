<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_earlywarnings;
use App\Eloquents\M_accessroles;
use App\Controllers\Base_Controller;
use App\Eloquents\M_enumdetails;
use App\Libraries\Redirect;
use App\Libraries\Session;
use App\Libraries\File;
use Curl\Curl;
use AndikAryanto11\Datatables;

class M_earlywarning extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        if ($this->hasPermission('m_earlywarning', 'Read')) {
            $this->loadView('m_earlywarning/index', lang('Form.earlywarning'));
        }
    }

    public function add()
    {
        if ($this->hasPermission('m_earlywarning', 'Write')) {
            $earlywarnings = new M_earlywarnings();
            $data = setPageData_paging($earlywarnings);
            $this->loadView('m_earlywarning/add', lang('Form.earlywarning'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_earlywarning', 'Write')) {
            $earlywarnings = new M_earlywarnings();
            $earlywarnings->parseFromRequest();
            $earlywarnings->DateEnd = get_formated_date($earlywarnings->Date . " " . $earlywarnings->TimeEnd, "Y-m-d H:i:s");
            try {
                $earlywarnings->validate();
                $photourl = null;

                $file = $this->request->getFiles('photo');
                if ($file['name']) {
                    $photo = new File("assets/upload/earlywarning", ["jpg", "jpeg"]);
                    $result = $photo->upload($file);
                    $photourl = $photo->getFileUrl();
                    $earlywarnings->PhotoUrl = $photourl;
                }
                // echo $photourl;

                $id = $earlywarnings->save();
                if ($id) {
                    $this->sendNotification($earlywarnings->TypeWarning, $earlywarnings->Description);
                }
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('mearlywarning/add')->go();
            } catch (EloquentException $e) {
                Session::setFlash('add_warning_msg', array(0 => $e->message));
                return Redirect::redirect('mearlywarning/add')->with($earlywarnings)->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('m_earlywarning', 'Write')) {

            $earlywarnings = M_earlywarnings::find($id);
            $earlywarnings->Date = get_formated_date($earlywarnings->Date, "d-m-Y");
            $data['model'] = $earlywarnings;
            $this->loadView('m_earlywarning/edit', lang('Form.earlywarning'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('m_earlywarning', 'Write')) {
            $id = $this->request->getPost('Id');

            $earlywarnings = M_earlywarnings::find($id);
            $oldmodel = clone $earlywarnings;

            $earlywarnings->parseFromRequest();

            try {
                $earlywarnings->validate($oldmodel);
                $earlywarnings->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('mearlywarning')->go();
            } catch (EloquentException $e) {
                Session::setFlash('edit_warning_msg', $e->message);
                return Redirect::redirect("mearlywarning/edit/{$id}")->with($earlywarnings)->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('m_earlywarning', 'Delete')) {
            $model = M_earlywarnings::find($id);
            $result = $model->delete();
            if (!is_bool($result)) {
                $deletemsg = getDeleteErrorMessage();
                echo json_encode(deleteStatus($deletemsg, FALSE));
            } else {
                if ($result) {
                    $deletemsg = getDeleteMessage();
                    echo json_encode(deleteStatus($deletemsg));
                }
            }
        } else {
            echo json_encode(deleteStatus("", FALSE, TRUE));
        }
    }

    public function getAllData()
    {

        if ($this->hasPermission('m_earlywarning', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_earlywarnings');
            $datatable
                ->addDtRowClass("rowdetail")
                ->addColumn(
                    'Id',
                    null,
                    function ($row) {
                        return $row->Id;
                    },
                    false,
                    false
                )->addColumn(
                    'Title',
                    null,
                    function ($row) {
                        return
                            formLink($row->Title, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl('mearlywarning/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'Date',
                    null,
                    function ($row) {
                        return get_formated_date($row->Date, "d-m-Y");
                    }
                )->addColumn(
                    'Description',
                    null,
                    function ($row) {
                        return $row->Description;
                    }
                )->addColumn(
                    'Created',
                    null,
                    function ($row) {
                        return $row->Created;
                    },
                    false
                )->addColumn(
                    'Action',
                    null,
                    function ($row) {
                        return
                            formLink("<i class='fa fa-trash'></i>", array(
                                "href" => "#",
                                "class" => "btn-just-icon link-action delete",
                                "rel" => "tooltip",
                                "title" => lang('Form.delete')
                            ));
                    },
                    false,
                    false
                );

            echo json_encode($datatable->populate());
        }
    }

    public function getDataModal()
    {

        $datatable = new Datatables();
        $datatable->eloquent('App\\Eloquents\\M_earlywarnings');
        $datatable
            ->addDtRowClass("rowdetail")
            ->addColumn(
                'Id',
                null,
                function ($row) {
                    return $row->Id;
                },
                false,
                false
            )->addColumn(
                'Title',
                null,
                function ($row) {
                    return $row->Title;
                }
            );

        echo json_encode($datatable->populate());
    }

    public function sendNotification($type, $message)
    {
        $topic = "";

        if ($type == 1 || $type == 3) {
            $topic = "'report' in topics || 'public' in topics";
        } else if ($type == 2) {
            $topic = "'report' in topics";
        }

        // $curl = new Curl();
        $body = [
            "notification" => [
                "title" => M_enumdetails::findEnumName("WarningType", $type),
                "body" => strip_tags($message),
                "sound" => "default",
                "click_action" => "FCM_PLUGIN_ACTIVITY",
                "icon" => "fcm_push_icon"
            ],
            // "to" => "/topics/{$topic}",
            "condition" => $topic,
            "additionalData" => [
                "content-available" =>  "1",
                "priority" => "high"
            ],
            "restricted_package_name" => ""
        ];

        $ch = curl_init('https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        // Set HTTP Header for POST request 
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Authorization : key=AAAAORJPWc8:APA91bH7-jppQ33oBCu8b06C42gMMxfxK-lKV8vssFFL6vOQcvQ-DXroNeA42sw5cINVH_dDHdsO-2OU81dV4nbZpOwgq1JQMmUuZFhcxD_zLBNXJUbUDP-k1IuBPAV7hVzqmvKYtabB'
            )
        );

        // Submit the POST request
        $result = curl_exec($ch);
        echo json_encode($result);
        // Close cURL session handle
        curl_close($ch);

        // $curl->setHeader('Content-Type', 'application/json');
        // $curl->setHeader('Authorization', 'key=AAAAORJPWc8:APA91bH7-jppQ33oBCu8b06C42gMMxfxK-lKV8vssFFL6vOQcvQ-DXroNeA42sw5cINVH_dDHdsO-2OU81dV4nbZpOwgq1JQMmUuZFhcxD_zLBNXJUbUDP-k1IuBPAV7hVzqmvKYtabB');
        // $curl->post('https://fcm.googleapis.com/fcm/send', $body);
    }
}
