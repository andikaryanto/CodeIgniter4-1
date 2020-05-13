<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_disasterschools;
use App\Eloquents\M_accessroles;
use App\Controllers\Base_Controller;
use App\Libraries\Session;
use App\Libraries\File;
use App\Eloquents\M_enumdetails;
use App\Libraries\Redirect;
use AndikAryanto11\Datatables;

class M_disasterschool extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        $res = $this->hasPermission('m_disasterschool', 'Read');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $this->loadView('m_disasterschool/index', lang('Form.villageresistdisaster'));
        
    }

    public function add()
    {
        $res = $this->hasPermission('m_disasterschool', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $disasterschools = new M_disasterschools();
        $data = setPageData_paging($disasterschools);
        $this->loadView('m_disasterschool/add', lang('Form.villageresistdisaster'), $data);
        
    }

    public function addsave()
    {

        $res = $this->hasPermission('m_disasterschool', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $disasterschools = new M_disasterschools();
        $disasterschools->parseFromRequest();
        $disasterschools->IsActive = 1;

        try {
            $disasterschools->validate();

            $file = $this->request->getFileMultiple('photo');
            $fileCls = new File("assets/upload/disasterschool", ["jpg", "jpeg"]);
            if ($fileCls->upload($file)) {
                $disasterschools->PhotoUrl = $fileCls->getFileUrl();
                $disasterschools->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('mdisasterschool/add')->go();
                // echo json_encode($disasterschools);
            } else {

                Session::setFlash('add_warning_msg', array(0 => $fileCls->getErrorMessage()));
                return Redirect::redirect('mdisasterschool/add')->with($disasterschools)->go();
            }
        } catch (EloquentException $e) {

            Session::setFlash('add_warning_msg',  array(0 => $e->getMessages()));
            return Redirect::redirect('mdisasterschool/add')->with($disasterschools)->go();
        }
    
    }

    public function edit($id)
    {
        $res = $this->hasPermission('m_disasterschool', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $disasterschools = M_disasterschools::find($id);
        $data['model'] = $disasterschools;
        $this->loadView('m_disasterschool/edit', lang('Form.villageresistdisaster'), $data);
       
    }

    public function editsave()
    {

        $res = $this->hasPermission('m_disasterschool', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $id = $this->request->getPost('Id');


        $disasterschools = M_disasterschools::find($id);
        $oldmodel = clone $disasterschools;

        $disasterschools->parseFromRequest();

        try {
            $disasterschools->validate($oldmodel);


            $file = $this->request->getFileMultiple('photo');
            // echo json_encode($file);
            if ($file['name']) {
                // echo json_encode($this->request->getFileMultiple('photo'));
                $fileCls = new File("assets/upload/disasterschool", ["jpg", "jpeg"]);
                if ($fileCls->upload($file)) {

                    unlink(FCPATH  . $oldmodel->PhotoUrl);
                    $disasterschools->PhotoUrl = $fileCls->getFileUrl();
                    $disasterschools->save();
                    Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                    return Redirect::redirect('mdisasterschool');
                } else {
                    throw new EloquentException($fileCls->getErrorMessage(), $disasterschools);
                }
            } else {
                $disasterschools->save();
                return Redirect::redirect('mdisasterschool');
            }
        } catch (EloquentException $e) {

            Session::setFlash('edit_warning_msg',  array(0 => $e->getMessages()));
            return Redirect::redirect("mdisasterschool/edit/{$id}")->with($disasterschools)->go();
        }
    
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        $res = $this->hasPermission('m_disasterschool', 'Delete');

        if(!$res){
            echo json_encode(deleteStatus(lang("Info.no_access_delete"), FALSE, TRUE));
        } else {
            $model = M_disasterschools::find($id);
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

        if ($this->hasPermission('m_disasterschool', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_disasterschools');
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
                    'Name',
                    null,
                    function ($row) {
                        return
                            formLink($row->Name, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl('mdisasterschool/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'Address',
                    null,
                    function ($row) {
                        return $row->Address;
                    }
                )->addColumn(
                    'PersonInCharge',
                    null,
                    function ($row) {
                        return $row->PersonInCharge;
                    }
                )->addColumn(
                    'Phone',
                    null,
                    function ($row) {
                        return $row->Phone;
                    }
                )->addColumn(
                    'Capacity',
                    null,
                    function ($row) {
                        return $row->Capacity;
                    }
                )->addColumn(
                    'Facility',
                    null,
                    function ($row) {
                        return $row->Facility;
                    },
                    false,
                    false
                )->addColumn(
                    'IsActive',
                    null,
                    function ($row) {
                        if ($row->IsActive)
                            return "<td><a><i class='fa fa-check'></i></a></td>";
                        else
                            return "<td><a><i class='fa fa-close'></i></a></td>";
                    },
                    false,
                    false
                )->addColumn(
                    'Action',
                    null,
                    function ($row) {
                        return
                            formLink("<i class='fa fa-picture-o'></i>", array(
                                "href" => "#modalVillageDisaster",
                                "data-toggle" => "modal",
                                "class" => "btn-just-icon link-action image",
                                "rel" => "tooltip",
                                "title" => lang('Form.picture')
                            )) .
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
        $datatable->eloquent('App\\Eloquents\\M_disasterschools');
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
                'Name',
                null,
                function ($row) {
                    return $row->Name;
                }
            );

        echo json_encode($datatable->populate());
    }

    public function getData()
    {

        $id = $this->request->getPost("id");
        $infra = new M_disasterschools();
        $model = $infra->find($id);

        echo json_encode($model);
    }
}
