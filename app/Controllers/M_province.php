<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_provinces;
use App\Eloquents\M_accessroles;
use App\Controllers\Base_Controller;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;
use App\Libraries\DbTrans;

class M_province extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {

        $res = $this->hasPermission('m_province', 'Read');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $this->loadView('m_province/index', lang('Form.province'));
        
    }

    public function add()
    {
        $res = $this->hasPermission('m_province', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $provinces = new M_provinces();
        $data = setPageData_paging($provinces);
        $this->loadView('m_province/add', lang('Form.province'), $data);
        
    }

    public function addsave()
    {

        $res = $this->hasPermission('m_province', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $provinces = new M_provinces();
        $provinces->parseFromRequest();
        try {

            $provinces->validate();
            
            $provinces->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect('mprovince/add')->go();
            
        } catch (EloquentException $e) { 
            Session::setFlash('add_warning_msg', $e->getMessages());
            return Redirect::redirect('mprovince/add')->with($e->getEntity())->go();
        }
        
    }

    public function edit($id)
    {
        $res = $this->hasPermission('m_province', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $provinces = M_provinces::find($id);
        $data['model'] = $provinces;
        $this->loadView('m_province/edit', lang('Form.province'), $data);
        
    }

    public function editsave()
    {

        $res = $this->hasPermission('m_province', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $id = $this->request->getPost('Id');

        $provinces = M_provinces::find($id);
        $oldmodel = clone $provinces;

        $provinces->parseFromRequest();

        try {

            $validate = $provinces->validate($oldmodel);

            DbTrans::beginTransaction();
            $provinces->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            DbTrans::commit();
            return Redirect::redirect('mprovince')->go();
        } catch (EloquentException $e) {
            Session::setFlash('edit_warning_msg', $e->getMessages());
            return Redirect::redirect("mprovince/edit/{$id}")->with($e->getEntity())->go();
        }
        
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        $res = $this->hasPermission('m_province', 'Delete');

        if(!$res){
            echo json_encode(deleteStatus(lang("Info.no_access_delete"), FALSE, TRUE));
        } else {
            $model = M_provinces::find($id);
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

        if ($this->hasPermission('m_province', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_provinces');
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
                                "href" => baseUrl('mprovince/edit/' . $row->Id),
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
        $datatable->eloquent('App\\Eloquents\\M_provinces');
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
