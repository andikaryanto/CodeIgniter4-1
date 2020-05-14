<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_infrastructurecategories;
use App\Eloquents\M_accessroles;
use App\Controllers\Base_Controller;
use App\Libraries\Redirect;
use App\Libraries\File;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class M_infrastructurecategory extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        $res = $this->hasPermission('m_infrastructurecategory', 'Read');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $this->loadView('m_infrastructurecategory/index', lang('Form.infrastructurecategory'));
     
    }

    public function add()
    {
        $res = $this->hasPermission('m_infrastructurecategory', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $infrastructurecategories = new M_infrastructurecategories();
        $data = setPageData_paging($infrastructurecategories);
        $this->loadView('m_infrastructurecategory/add', lang('Form.infrastructurecategory'), $data);
        
    }

    public function addsave()
    {

        $res = $this->hasPermission('m_infrastructurecategory', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $infrastructurecategories = new M_infrastructurecategories();
        $infrastructurecategories->parseFromRequest();

        try {
            $infrastructurecategories->validate();
            $file = $this->request->getFile('photo');
            $photo = new File("assets/upload/infrastructurecategory/icon", ["jpg", "jpeg", "png"]);
            $result = $photo->upload($file);
            if ($result) {
                $infrastructurecategories->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('minfrastructurecategory/add')->go();
            } else {
                throw new EloquentException($result->getErrorMessage(), $infrastructurecategories);
            }
        } catch (EloquentException $e) {

            Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("minfrastructurecategory/add")->with($e->getEntity())->go();
        }
        
    }

    public function edit($id)
    {
        $res = $this->hasPermission('m_infrastructurecategory', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $infrastructurecategories = M_infrastructurecategories::find($id);
        $data['model'] = $infrastructurecategories;
        $this->loadView('m_infrastructurecategory/edit', lang('Form.infrastructurecategory'), $data);
        
    }

    public function editsave()
    {

        $res = $this->hasPermission('m_infrastructurecategory', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $id = $this->request->getPost('Id');

        $infrastructurecategories = M_infrastructurecategories::find($id);
        $oldmodel = clone $infrastructurecategories;

        $infrastructurecategories->parseFromRequest();

        try {
            $infrastructurecategories->validate($oldmodel);
            $file = $this->request->getFile('photo');
            $photo = new File("assets/upload/infrastructurecategory/icon", ["jpg", "jpeg", "png"]);
            $result = $photo->upload($file);
            if ($result) {
                if ($infrastructurecategories->Icon)
                    unlink(FCPATH  . $oldmodel->Icon);
                $infrastructurecategories->Icon = $photo->getFileUrl();
                $infrastructurecategories->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('minfrastructurecategory')->go();
            } else {
                throw new EloquentException($photo->getErrorMessage(), $infrastructurecategories);
            }
        } catch (EloquentException $e) {

            Session::setFlash('edit_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("minfrastructurecategory/edit/{$id}")->with($e->getEntity())->go();
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        $res = $this->hasPermission('m_infrastructurecategory', 'Delete');

        if(!$res){
            echo json_encode(deleteStatus(lang("Info.no_access_delete"), FALSE, TRUE));
        } else {
            $model = M_infrastructurecategories::find($id);
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

        if ($this->hasPermission('m_infrastructurecategory', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_infrastructurecategories');
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
                                "href" => baseUrl('minfrastructurecategory/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
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
        $datatable->eloquent('App\\Eloquents\\M_infrastructurecategories');
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
}
