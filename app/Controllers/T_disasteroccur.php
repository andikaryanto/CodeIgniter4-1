<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\T_disasteroccurs;
use App\Controllers\Base_Controller;
use App\Eloquents\G_transactionnumbers;
use App\Eloquents\M_forms;
use App\Libraries\File;
use App\Eloquents\T_disasterreports;
use App\Eloquents\M_enumdetails;
use App\Eloquents\T_disasterassessments;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class T_disasteroccur extends Base_Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        if ($this->hasPermission('t_disasteroccur', 'Read')) {

            $this->loadView('t_disasteroccur/index', lang('Form.disasteroccur'));
        }
    }

    public function add()
    {
        if ($this->hasPermission('t_disasteroccur', 'Write')) {
            $ref = $this->request->getGet("Ref");

            $disasteroccurs = new T_disasteroccurs();
            if ($ref) {

                $report  = T_disasterreports::find($ref);
                $p = [
                    'where' => [
                        'T_Disasterreport_Id' => $ref
                    ]
                ];
                $ass = T_disasterassessments::findOne($p);
                if($ass)
                    $disasteroccurs->copyFromAssessment($ass);
                else 
                    $disasteroccurs->copyFromReport($report);
                $disasteroccurs->DateOccur = get_formated_date($disasteroccurs->DateOccur, 'd-m-Y H:i');
                // echo json_encode($disasteroccurs);
            }

            $data = setPageData_paging($disasteroccurs);
            $this->loadView('t_disasteroccur/add', lang('Form.disasteroccur'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('t_disasteroccur', 'Write')) {

            $disasteroccurs = new T_disasteroccurs();
            $disasteroccurs->parseFromRequest();
            try {
                $disasteroccurs->validate();

                $video = null;
                $photo = null;
                $photourl = null;
                $videourl = null;
                $result = true;
                $resultvideo = true;
                $file = $this->request->getFileMultiple('photo');
                $filevideo = $this->request->getFileMultiple('video');
                if (empty($disasteroccurs->T_Disasterreport_Id)) {
                    if ($file['name']) {
                        $photo = new File("assets/upload/disasteroccur/photo", ["jpg", "jpeg"]);
                        $result = $photo->upload($file);
                        $photourl = $photo->getFileUrl();
                    }

                    if ($filevideo['name']) {
                        $video = new File("assets/upload/disasteroccur/video");
                        $resultvideo = $video->upload($filevideo);
                        $videourl = $video->getFileUrl();
                    }
                } else {
                    $report = T_disasterreports::find($disasteroccurs->T_Disasterreport_Id);
                    $photourl = $report->Photo;
                    $videourl = $report->Video;

                    if ($file['name']) {
                        $photo = new File("assets/upload/disasteroccur/photo", ["jpg", "jpeg"]);
                        $result = $photo->upload($file);
                        $photourl = $photo->getFileUrl();
                    }

                    if ($filevideo['name']) {
                        $video = new File("assets/upload/disasteroccur/video");
                        $resultvideo = $video->upload($filevideo);
                        $videourl = $video->getFileUrl();
                    }
                }

                if ($resultvideo && $result) {
                    $formid = M_forms::findDataByName('t_disasteroccurs')->Id;
                    $disasteroccurs->Photo = $photourl;
                    $disasteroccurs->Video = $videourl;
                    $disasteroccurs->TransNo = G_transactionnumbers::findLastNumberByFormId($formid, date('Y'), date("m"));
                    $disasteroccurs->save();
                    G_transactionnumbers::updateLastNumber($formid, date('Y'), date("m"));
                    Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                    return Redirect::redirect('tdisasteroccur/add')->go();
                } else {
                    if ($photo)
                        throw new EloquentException($photo->getErrorMessage(), $disasteroccurs);
                    if ($video)
                        throw new EloquentException($video->getErrorMessage(), $disasteroccurs);
                }
            } catch (EloquentException $e) {
                $e->data->DateOccur = get_formated_date($e->data->DateOccur, 'd-m-Y H:i');
                Session::setFlash('add_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("tdisasteroccur/add")->with($e->data)->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('t_disasteroccur', 'Write')) {

            $disasteroccurs = T_disasteroccurs::find($id);
            $disasteroccurs->DateOccur = get_formated_date($disasteroccurs->DateOccur, "d-m-Y H:i");
            $data['model'] = $disasteroccurs;
            $this->loadView('t_disasteroccur/edit', lang('Form.disasteroccur'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('t_disasteroccur', 'Write')) {

            $id = $this->request->getPost('Id');

            $disasteroccurs = T_disasteroccurs::find($id);
            $oldmodel = clone $disasteroccurs;

            $disasteroccurs->parseFromRequest();
            // echo json_encode($disasteroccurs);

            try {
                $disasteroccurs->validate($oldmodel);

                $photo = null;
                $video = null;
                $photourl = null;
                $videourl = null;
                $result = true;
                $resultvideo = true;
                $file = $this->request->getFileMultiple('photo');
                $filevideo = $this->request->getFileMultiple('video');

                $report = false;
                if ($disasteroccurs->T_Disasterreport_Id)
                    $report = T_disasterreports::find($disasteroccurs->T_Disasterreport_Id);

                if ($file['name']) {
                    $photo = new File("assets/upload/disasteroccur/photo", ["jpg", "jpeg"]);
                    $result = $photo->upload($file);
                    unlink(FCPATH . $disasteroccurs->Photo);
                    $photourl = $photo->getFileUrl();
                } else {
                    $photourl = $disasteroccurs->Photo;
                }

                if ($filevideo['name']) {
                    $video = new File("assets/upload/disasteroccur/video");
                    $resultvideo = $video->upload($filevideo);
                    unlink(FCPATH . $disasteroccurs->Video);
                    $videourl = $video->getFileUrl();
                } else {
                    $videourl = $disasteroccurs->Video;
                }

                if ($resultvideo && $result) {
                    $formid = M_forms::findDataByName('t_disasteroccurs')->Id;
                    $disasteroccurs->Photo = $photourl;
                    $disasteroccurs->Video = $videourl;
                    $disasteroccurs->save();
                    Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                    return Redirect::redirect('tdisasteroccur')->go();
                } else {
                    if ($photo)
                        throw new EloquentException($photo->getErrorMessage(), $disasteroccurs);
                    if ($video)
                        throw new EloquentException($video->getErrorMessage(), $disasteroccurs);
                }
            } catch (EloquentException $e) {

                $e->data->DateOccur = get_formated_date($e->data->DateOccur, 'd-m-Y H:i');
                Session::setFlash('edit_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("tdisasteroccur/edit/{$id}")->with($e->data)->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('t_disasteroccur', 'Delete')) {

            $model = T_disasteroccurs::find($id);

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
        }
    }

    public function getAllData()
    {

        if ($this->hasPermission('t_disasteroccur', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\T_disasteroccurs');
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
                    'TransNo',
                    null,
                    function ($row) {
                        return
                            formLink($row->TransNo, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl('tdisasteroccur/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                // )->addColumn(
                //     'M_Community_Id',
                //     function ($row) {
                //         return $row->get_M_Community()->Name;
                //     }
                )->addColumn(
                    'ReporterName',
                    null,
                    function ($row) {
                        return $row->ReporterName;
                    },
                    false
                )->addColumn(
                    'Phone',
                    null,
                    function ($row) {
                        return $row->Phone;
                    },
                    false
                )->addColumn(
                    'M_Subvillage_Id',
                    null,
                    function ($row) {
                        return $row->get_M_Subvillage()->Name;
                    },
                    false
                )->addColumn(
                    'M_Disaster_Id',
                    null,
                    function ($row) {
                        return $row->get_M_Disaster()->Name;
                    },
                    false
                )->addColumn(
                    'DateOccur',
                    null,
                    function ($row) {
                        return get_formated_date($row->DateOccur, "d-m-Y");
                    },
                    false
                )->addColumn(
                    'Status',
                    null,
                    function ($row) {
                        return M_enumdetails::findEnumName("DisasterOccurStatus", $row->Status);
                    },
                    false
                )->addColumn(
                    'Action',
                    null,
                    function ($row) {
                        $link = "";

                        $link .=  formLink("<i class='fa fa-skull'></i>", array(
                                "href" => baseUrl("tdisasteroccurvictim/{$row->Id}"),
                                "class" => "btn-just-icon link-action victim",
                                "rel" => "tooltip",
                                "title" => lang('Form.victim')
                            )) .
                            formLink("<i class='fa fa-house-damage'></i>", array(
                                "href" => baseUrl("tdisasteroccurbuilding/{$row->Id}"),
                                "class" => "btn-just-icon link-action impact",
                                "rel" => "tooltip",
                                "title" => lang('Form.impact')
                            )) .
                            formLink("<i class='fa fa-syringe'></i>", array(
                                "href" =>  baseUrl("tdisasteroccurimpact/{$row->Id}"),
                                "class" => "btn-just-icon link-action impact",
                                "rel" => "tooltip",
                                "title" => lang('Form.impact')
                            )) .
                            formLink("<i class='fa fa-image'></i>", array(
                                "href" => "#",
                                "class" => "btn-just-icon link-action picture",
                                "rel" => "tooltip",
                                "title" => lang('Form.picture')
                            )) .
                            formLink("<i class='fa fa-video'></i>", array(
                                "href" => "#",
                                "class" => "btn-just-icon link-action video",
                                "rel" => "tooltip",
                                "title" => lang('Form.video')
                            )) .
                            formLink("<i class='fa fa-map-marked'></i>", array(
                                "href" => "#",
                                "class" => "btn-just-icon link-action maps",
                                "rel" => "tooltip",
                                "title" => lang('Form.map')
                            )) .
                            formLink("<i class='fa fa-trash'></i>", array(
                                "href" => "#",
                                "class" => "btn-just-icon link-action delete",
                                "rel" => "tooltip",
                                "title" => lang('Form.delete')
                            ));
                        $item = "";
                        if ($row->IsNeedLogistic) {
                            $item =
                                formLink("<i class='fa fa-object-group'></i>", array(
                                    "href" => baseUrl("tdisasteroccurlogistic/{$row->Id}"),
                                    "class" => "btn-just-icon link-action logistic",
                                    "rel" => "tooltip",
                                    "title" => lang('Form.logistic')
                                ));
                        }
                        return $item . $link;
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
        $datatable->eloquent('App\\Eloquents\\T_disasteroccurs');
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
                'TransNo',
                null,
                function ($row) {
                    return $row->TransNo;
                }
            )->addColumn(
                'M_Disaster_Id',
                null,
                function ($row) {
                    return $row->get_M_Disaster()->Name;
                }
            );

        echo json_encode($datatable->populate());
    }

    public function getDataById()
    {
        if ($this->hasPermission('t_disasteroccur', 'Read')) {

            $id = $this->request->getPost("id");
            $model = T_disasteroccurs::find($id);
            $model->Disaster = $model->get_M_Disaster();
            $model->PhotoUrl = empty($model->Photo) ? (empty($model->Photo64) ? null : "data:image/jpg;base64, ".$model->Photo64) : baseUrl($model->Photo);
            $datas['model'] = $model;
            echo json_encode($datas);
        }
    }
}
