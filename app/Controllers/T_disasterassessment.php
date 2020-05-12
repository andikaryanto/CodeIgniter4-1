<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\T_disasterassessments;
use App\Controllers\Base_Controller;
use App\Eloquents\G_transactionnumbers;
use App\Eloquents\M_forms;
use App\Libraries\File;
use App\Eloquents\T_disasterreports;
use App\Eloquents\M_enumdetails;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class T_disasterassessment extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        if ($this->hasPermission('t_disasterassessment', 'Read')) {

            $this->loadView('t_disasterassessment/index', lang('Form.disasterassessment'));
        }
    }

    public function add()
    {
        if ($this->hasPermission('t_disasterassessment', 'Write')) {
            $ref = $this->request->getGet("Ref");

            $disasterassessments = new T_disasterassessments();
            if ($ref) {

                $report  = T_disasterreports::find($ref);
                $disasterassessments->copyFromReport($report);
                $disasterassessments->DateOccur = get_formated_date($disasterassessments->DateOccur, 'd-m-Y H:i');
                // echo json_encode($disasterassessments);
            }

            $data = setPageData_paging($disasterassessments);
            $this->loadView('t_disasterassessment/add', lang('Form.disasterassessment'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('t_disasterassessment', 'Write')) {

            $disasterassessments = new T_disasterassessments();
            $disasterassessments->parseFromRequest();
            try {
                $disasterassessments->validate();

                $video = null;
                $photo = null;
                $photourl = null;
                $videourl = null;
                $result = true;
                $resultvideo = true;
                $file = $this->request->getFiles('photo');
                $filevideo = $this->request->getFiles('video');
                if (empty($disasterassessments->T_Disasterreport_Id)) {
                    if ($file['name']) {
                        $photo = new File("assets/upload/disasterassessment/photo", ["jpg", "jpeg"]);
                        $result = $photo->upload($file);
                        $photourl = $photo->getFileUrl();
                    }

                    if ($filevideo['name']) {
                        $video = new File("assets/upload/disasterassessment/video");
                        $resultvideo = $video->upload($filevideo);
                        $videourl = $video->getFileUrl();
                    }
                } else {
                    $report = T_disasterreports::find($disasterassessments->T_Disasterreport_Id);
                    $photourl = $report->Photo;
                    $videourl = $report->Video;

                    if ($file['name']) {
                        $photo = new File("assets/upload/disasterassessment/photo", ["jpg", "jpeg"]);
                        $result = $photo->upload($file);
                        $photourl = $photo->getFileUrl();
                    }

                    if ($filevideo['name']) {
                        $video = new File("assets/upload/disasterassessment/video");
                        $resultvideo = $video->upload($filevideo);
                        $videourl = $video->getFileUrl();
                    }
                }

                if ($resultvideo && $result) {
                    $disasterassessments->Photo = $photourl;
                    $disasterassessments->Video = $videourl;
                    // $disasterassessments->TransNo = G_transactionnumbers::findLastNumberByFormId($formid, date('Y'), date("m"));
                    $disasterassessments->save();
                    // G_transactionnumbers::updateLastNumber($formid, date('Y'), date("m"));
                    Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                    return Redirect::redirect('tdisasterassessment/add')->go();
                } else {
                    if ($photo)
                        throw new EloquentException($photo->getErrorMessage(), $disasterassessments);
                    if ($video)
                        throw new EloquentException($video->getErrorMessage(), $disasterassessments);
                }
            } catch (EloquentException $e) {
                $e->getEntity()->DateOccur = get_formated_date($e->getEntity()->DateOccur, 'd-m-Y H:i');
                Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
                return Redirect::redirect("tdisasterassessment/add")->with($e->getEntity())->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('t_disasterassessment', 'Write')) {

            $disasterassessments = T_disasterassessments::find($id);
            $disasterassessments->DateOccur = get_formated_date($disasterassessments->DateOccur, "d-m-Y H:i");
            $data['model'] = $disasterassessments;
            $this->loadView('t_disasterassessment/edit', lang('Form.disasterassessment'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('t_disasterassessment', 'Write')) {

            $id = $this->request->getPost('Id');

            $disasterassessments = T_disasterassessments::find($id);
            $oldmodel = clone $disasterassessments;

            $disasterassessments->parseFromRequest();
            // echo json_encode($disasterassessments);

            try {
                $disasterassessments->validate($oldmodel);

                $photo = null;
                $video = null;
                $photourl = null;
                $videourl = null;
                $result = true;
                $resultvideo = true;
                $file = $this->request->getFiles('photo');
                $filevideo = $this->request->getFiles('video');

                $report = false;
                if ($disasterassessments->T_Disasterreport_Id)
                    $report = T_disasterreports::find($disasterassessments->T_Disasterreport_Id);

                if ($file['name']) {
                    $photo = new File("assets/upload/disasterassessment/photo", ["jpg", "jpeg"]);
                    $result = $photo->upload($file);
                    unlink(FCPATH . $disasterassessments->Photo);
                    $photourl = $photo->getFileUrl();
                } else {
                    $photourl = $disasterassessments->Photo;
                }

                if ($filevideo['name']) {
                    $video = new File("assets/upload/disasterassessment/video");
                    $resultvideo = $video->upload($filevideo);
                    unlink(FCPATH . $disasterassessments->Video);
                    $videourl = $video->getFileUrl();
                } else {
                    $videourl = $disasterassessments->Video;
                }

                if ($resultvideo && $result) {
                    $formid = M_forms::findDataByName('t_disasterassessments')->Id;
                    $disasterassessments->Photo = $photourl;
                    $disasterassessments->Video = $videourl;
                    $disasterassessments->save();
                    Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                    return Redirect::redirect('tdisasterassessment')->go();
                } else {
                    if ($photo)
                        throw new EloquentException($photo->getErrorMessage(), $disasterassessments);
                    if ($video)
                        throw new EloquentException($video->getErrorMessage(), $disasterassessments);
                }
            } catch (EloquentException $e) {

                $e->getEntity()->DateOccur = get_formated_date($e->getEntity()->DateOccur, 'd-m-Y H:i');
                Session::setFlash('edit_warning_msg', array(0 => $e->getMessages()));
                return Redirect::redirect("tdisasterassessment/edit/{$id}")->with($e->getEntity())->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('t_disasterassessment', 'Delete')) {

            $model = T_disasterassessments::find($id);

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

        if ($this->hasPermission('t_disasterassessment', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\T_disasterassessments');
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
                            formLink($row->get_T_Disasterreport()->ReportNo, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl('tdisasterassessment/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
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
                    'Action',
                    null,
                    function ($row) {
                        $append = "";
                        $report = $row->get_T_Disasterreport();
                        if (!$report->isConverted())
                            $append .= formLink("<i class='fa fa-exchange-alt'></i>", array(
                                "href" => baseUrl('tdisasteroccur/add?Ref='.$report->Id),
                                "class" => "btn-just-icon link-action convert",
                                "rel" => "tooltip",
                                "title" => lang('Form.convert')
                            ));
                        else {
                            $append .= formLink("<i class='fa fa-eye'></i>", array(
                                "href" => baseUrl("tdisasteroccur/edit/{$row->get_T_Disasterreport()->getConverted()->Id}"),
                                "class" => "btn-just-icon link-action",
                                "rel" => "tooltip",
                                "title" => lang('Form.see')
                            ));
                        };
                        $item = "";
                        // if ($row->IsNeedLogistic) {
                        //     $item =
                        //         formLink("<i class='fa fa-object-group'></i>", array(
                        //             "href" => baseUrl("tdisasterassessmentlogistic/{$row->Id}"),
                        //             "class" => "btn-just-icon link-action logistic",
                        //             "rel" => "tooltip",
                        //             "title" => lang('Form.logistic')
                        //         ));
                        // }
                        $item =
                                formLink("<i class='fa fa-user-check'></i>", array(
                                    "href" => baseUrl("tdisasterassessmentimpact/{$row->Id}"),
                                    "class" => "btn-just-icon link-action logistic",
                                    "rel" => "tooltip",
                                    "title" => lang('Form.impact')
                                ));
                        return $item . $append;
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
        $datatable->eloquent('App\\Eloquents\\T_disasterassessments');
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
        if ($this->hasPermission('t_disasterassessment', 'Read')) {

            $id = $this->request->getPost("id");
            $model = T_disasterassessments::find($id);
            $model->Disaster = $model->get_M_Disaster();
            $model->PhotoUrl = empty($model->Photo) ? (empty($model->Photo64) ? null : "data:image/jpg;base64, ".$model->Photo64) : baseUrl($model->Photo);
            $datas['model'] = $model;
            echo json_encode($datas);
        }
    }
}
