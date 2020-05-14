<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\T_disasterreports;
use App\Controllers\Base_Controller;
use App\Eloquents\G_transactionnumbers;
use App\Eloquents\M_forms;
use App\Libraries\Redirect;
use App\Libraries\File;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class T_disasterreport extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        $res = $this->hasPermission('t_disasterreport', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $this->loadView('t_disasterreport/index', lang('Form.disasterreport'));
        
    }

    public function add()
    {
        $res = $this->hasPermission('t_disasterreport', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $disasterreports = new T_disasterreports();
        $data = setPageData_paging($disasterreports);
        $this->loadView('t_disasterreport/add', lang('Form.disasterreport'), $data);
        
    }

    public function addpublic()
    {
        $disasterreports = new T_disasterreports();
        $data = setPageData_paging($disasterreports);
        $title['title'] = lang('Form.disasterreport');
        echo view("shared/headerpublic", $title);
        echo view('t_disasterreport/addpublic', $data);
        echo view("shared/footerpublic", array());
    }

    public function savepublic()
    {
        $disasterreports = new T_disasterreports();
        $disasterreports->parseFromRequest();
        try {
            $disasterreports->validate();

            $video = null;
            $photo = null;
            $photourl = null;
            $videourl = null;
            $result = true;
            $resultvideo = true;
            $file = $this->request->getFile('photo');
            if ($file['name']) {
                $photo = new File("assets/upload/disasterreport/photo", ["jpg", "jpeg"]);
                $result = $photo->upload($file);
                $photourl = $photo->getFileUrl();
            }

            $filevideo = $this->request->getFile('video');
            if ($filevideo['name']) {
                $video = new File("assets/upload/disasterreport/video");
                $resultvideo = $video->upload($filevideo);
                $videourl = $video->getFileUrl();
            }

            if ($resultvideo && $result) {
                $formid = M_forms::findDataByName('t_disasterreports')->Id;
                $disasterreports->Photo = $photourl;
                $disasterreports->Video = $videourl;
                $disasterreports->ReportNo = G_transactionnumbers::findLastNumberByFormId($formid, date('Y'), date("m"));
                $disasterreports->save();
                G_transactionnumbers::updateLastNumber($formid, date('Y'), date("m"));
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('disasterreport')->go();
            } else {
                if($photo)
                    Session::setFlash('add_warning_msg', array(0 => $photo->getErrorMessage()));
                if($video)
                    Session::setFlash('add_warning_msg', array(0 => $video->getErrorMessage()));
                return Redirect::redirect("disasterreport")->with($disasterreports)->go();
            }
        } catch (EloquentException $e) {

            $e->getEntity()->DateOccur = get_formated_date($e->getEntity()->DateOccur, 'd-m-Y H:i');
            Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("disasterreport")->with($e->getEntity())->go();
        }
    }

    public function addsave()
    {
        $res = $this->hasPermission('t_disasterreport', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $disasterreports = new T_disasterreports();
        $disasterreports->parseFromRequest();
        try {
            $disasterreports->validate();


            $video = null;
            $photo = null;
            $photourl = null;
            $videourl = null;
            $result = true;
            $resultvideo = true;
            $file = $this->request->getFile('photo');
            if ($file['name']) {
                $photo = new File("assets/upload/disasterreport/photo", ["jpg", "jpeg"]);
                $result = $photo->upload($file);
                $photourl = $photo->getFileUrl();
            }

            $filevideo = $this->request->getFile('video');
            if ($filevideo['name']) {
                $video = new File("assets/upload/disasterreport/video");
                $resultvideo = $video->upload($filevideo);
                $videourl = $video->getFileUrl();
            }

            if ($resultvideo && $result) {
                $formid = M_forms::findDataByName('t_disasterreports')->Id;
                $disasterreports->Photo = $photourl;
                $disasterreports->Video = $videourl;
                $disasterreports->ReportNo = G_transactionnumbers::findLastNumberByFormId($formid, date('Y'), date("m"));
                $disasterreports->save();
                G_transactionnumbers::updateLastNumber($formid, date('Y'), date("m"));
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('tdisasterreport/add')->go();
            } else {
                if($photo)
                    Session::setFlash('add_warning_msg', array(0 => $photo->getErrorMessage()));
                if($video)
                    Session::setFlash('add_warning_msg', array(0 => $video->getErrorMessage()));
                return Redirect::redirect('tdisasterreport/add')->with($disasterreports)->go();
            }
        } catch (EloquentException $e) {

            $e->getEntity()->DateOccur = get_formated_date($e->getEntity()->DateOccur, 'd-m-Y H:i');
            Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("tdisasterreport/add")->with($e->getEntity())->go();
        }
        
    }

    public function edit($id)
    {
        $res = $this->hasPermission('t_disasterreport', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $disasterreports = T_disasterreports::find($id);
        $disasterreports->DateOccur = get_formated_date($disasterreports->DateOccur, "d-m-Y H:i");
        $data['model'] = $disasterreports;
        $this->loadView('t_disasterreport/edit', lang('Form.disasterreport'), $data);
        
    }

    public function editsave()
    {

        $res = $this->hasPermission('t_disasterreport', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $id = $this->request->getGetPost('Id');

        $disasterreports = T_disasterreports::find($id);
        $oldmodel = clone $disasterreports;

        $disasterreports->parseFromRequest();

        try {
            $disasterreports->validate($oldmodel);

            $video = null;
            $photo = null;
            $photourl = null;
            $videourl = null;
            $result = true;
            $resultvideo = true;
            $file = $this->request->getFile('photo');
            if ($file['name']) {
                $photo = new File("assets/upload/disasterreport/photo", ["jpg", "jpeg"]);
                $result = $photo->upload($file);
                $photourl = $photo->getFileUrl();
            }

            $filevideo = $this->request->getFile('video');
            if ($filevideo['name']) {
                $video = new File("assets/upload/disasterreport/video");
                $resultvideo = $video->upload($filevideo);
                $videourl = $video->getFileUrl();
            }
            if ($resultvideo && $result) {
                if($photourl && $disasterreports->Photo){
                    unlink($disasterreports->Photo);
                    $disasterreports->Photo = $photourl;
                }
                
                if($videourl && $disasterreports->Photo){
                    unlink($disasterreports->Photo);
                    $disasterreports->Video = $videourl;
                }

                $disasterreports->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('tdisasterreport/add')->go();
            } else {
                if($photo)
                    Session::setFlash('add_warning_msg', array(0 => $photo->getErrorMessage()));
                if($video)
                    Session::setFlash('add_warning_msg', array(0 => $video->getErrorMessage()));
                    
                return Redirect::redirect('tdisasterreport/add')->with($disasterreports)->go();
            }
        } catch (EloquentException $e) {

            Session::setFlash('edit_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("tdisasterreport/edit/{$id}")->with($e->getEntity())->go();
        }
        
    }


    public function delete()
    {

        $id = $this->request->getGetPost("id");
        $res = $this->hasPermission('t_disasterreport', 'Delete');

        if(!$res){
            echo json_encode(deleteStatus(lang("Info.no_access_delete"), FALSE, TRUE));
        } else {

            $model = T_disasterreports::find($id);

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

        if ($this->hasPermission('t_disasterreport', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\T_disasterreports');
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
                    'ReportNo',
                    null,
                    function ($row) {
                        return
                            formLink($row->ReportNo, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl('tdisasterreport/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'M_Community_Id',
                    null,
                    function ($row) {
                        return $row->get_M_Community()->Name;
                    },
                    false
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
                        return get_formated_date($row->DateOccur, "d-m-Y H:i");
                    },
                    false
                )->addColumn(
                    'Action',
                    null,
                    function ($row) {
                        $append = "";
                        if(!$row->isAssessed()){
                            $append .= formLink("<i class='fa fa-user-check'></i>", array(
                                "href" => baseUrl('tdisasterassessment/add?Ref='.$row->Id),
                                "class" => "btn-just-icon link-action",
                                "rel" => "tooltip",
                                "title" => lang('Form.convert')
                            ));
                        }
                        if (!$row->isConverted())
                            $append .= formLink("<i class='fa fa-exchange-alt'></i>", array(
                                "href" => "#",
                                "class" => "btn-just-icon link-action convert",
                                "rel" => "tooltip",
                                "title" => lang('Form.convert')
                            ));
                        else {
                            $append .= formLink("<i class='fa fa-eye'></i>", array(
                                "href" => baseUrl("tdisasteroccur/edit/{$row->getConverted()->Id}"),
                                "class" => "btn-just-icon link-action",
                                "rel" => "tooltip",
                                "title" => lang('Form.see')
                            ));
                        }

                        $append .= formLink("<i class='fa fa-image'></i>", array(
                            "href" => "#",
                            "class" => "btn-just-icon link-action picture",
                            "rel" => "tooltip",
                            "title" => lang('Form.picture')
                        ));
                        $append .= formLink("<i class='fa fa-video'></i>", array(
                            "href" => "#",
                            "class" => "btn-just-icon link-action video",
                            "rel" => "tooltip",
                            "title" => lang('Form.video')
                        ));

                        $append .=  formLink("<i class='fa fa-trash'></i>", array(
                            "href" => "#",
                            "class" => "btn-just-icon link-action delete",
                            "rel" => "tooltip",
                            "title" => lang('Form.delete')
                        ));

                        return $append;
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
        $datatable->eloquent('App\\Eloquents\\T_disasterreports');
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
                'ReportNo',
                null,
                function ($row) {
                    return $row->ReportNo;
                }
            )->addColumn(
                'ReporterName',
                null,
                function ($row) {
                    return $row->ReporterName;
                }
            )->addColumn(
                'DateOccur',
                null,
                function ($row) {
                    return get_formated_date($row->DateOccur, "d-m-Y");
                }
            )->addColumn(
                'M_Disaster_Id',
                null,
                function ($row) {
                    return $row->get_M_Disaster()->Name;
                },
                false
            );

        echo json_encode($datatable->populate());
    }

    public function getDataById()
    {
        if ($this->hasPermission('t_disasteroccur', 'Read')) {

            $id = $this->request->getGetPost("id");
            $model = T_disasterreports::find($id);
            $model->Disaster = $model->get_M_Disaster();
            
            $model->PhotoUrl = empty($model->Photo) ? (empty($model->Photo64) ? null : "data:image/jpg;base64, ".$model->Photo64) : baseUrl($model->Photo);
            $datas['model'] = $model;
            echo json_encode($datas);
        }
    }
}
