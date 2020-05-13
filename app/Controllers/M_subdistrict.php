<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_subdistricts;
use App\Eloquents\M_accessroles;
use App\Controllers\Base_Controller;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class M_subdistrict extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        $res = $this->hasPermission('m_subdistrict', 'Read');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $this->loadView('m_subdistrict/index', lang('Form.subdistrict'));
        
    }

    public function add()
    {
        $res = $this->hasPermission('m_subdistrict', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $subdistricts = new M_subdistricts();
        $data = setPageData_paging($subdistricts);
        $this->loadView('m_subdistrict/add', lang('Form.subdistrict'), $data);
        
    }

    public function addsave()
    {

        $res = $this->hasPermission('m_subdistrict', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $subdistricts = new M_subdistricts();
        $subdistricts->parseFromRequest();

        try {
            $subdistricts->validate();

            $subdistricts->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect('msubdistrict/add')->with($subdistricts)->go();
        } catch (EloquentException $e) {

            Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("msubdistrict/add")->with($e->getEntity())->go();
        }
        
    }

    public function edit($id)
    {
        
        $res = $this->hasPermission('m_subdistrict', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $subdistricts = M_subdistricts::find($id);
        $data['model'] = $subdistricts;
        $this->loadView('m_subdistrict/edit', lang('Form.subdistrict'), $data);
        
    }

    public function editsave()
    {
        $res = $this->hasPermission('m_subdistrict', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $id = $this->request->getPost('Id');

        $subdistricts = M_subdistricts::find($id);
        $oldmodel = clone $subdistricts;

        $subdistricts->parseFromRequest();

        try {
            $subdistricts->validate($oldmodel);

            $subdistricts->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect('msubdistrict')->go();
        } catch (EloquentException $e) {

            Session::setFlash('edit_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("msubdistrict/edit/{$id}")->with($e->getEntity())->go();
        }
        
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        $res = $this->hasPermission('m_subdistrict', 'Delete');

        if(!$res){
            echo json_encode(deleteStatus(lang("Info.no_access_delete"), FALSE, TRUE));
        } else {
            $model = M_subdistricts::find($id);
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

        if ($this->hasPermission('m_subdistrict', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_subdistricts');
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
                                "href" => baseUrl('msubdistrict/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    '',
                    null,
                    function ($row) {
                        return $row->get_M_District()->Name;
                    },
                    false,
                    false
                )->addColumn(
                    '',
                    null,
                    function ($row) {
                        return $row->get_M_District()->get_M_Province()->Name;
                    },
                    false,
                    false
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
        $datatable->eloquent('App\\Eloquents\\M_subdistricts');
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
            )->addColumn(
                '',
                null,
                function ($row) {
                    return $row->get_M_District()->Name;
                },
                false,
                false
            )->addColumn(
                '',
                null,
                function ($row) {
                    return $row->get_M_District()->get_M_Province()->Name;
                },
                false,
                false
            );

        echo json_encode($datatable->populate());
    }
}
