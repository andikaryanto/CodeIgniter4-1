<?php

namespace App\Controllers;

use AndikAryanto11\Datatables;
use App\Classes\Exception\EloquentException;
use App\Controllers\Base_Controller;
use App\Eloquents\M_capabilities;
use App\Libraries\DbTrans;
use App\Libraries\Redirect;
use App\Libraries\Session;

class M_capability extends Base_Controller
{

    public function __construct()
    {
        // parent::__construct();
    }

    public function index()
    {
        $res = $this->hasPermission('m_capability', 'Read');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        
    
        $this->loadView('m_capability/index', lang('Form.capability'));
       
    }

    public function add()
    {
        $res = $this->hasPermission('m_capability', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $capabilities = new M_capabilities();
        $data = setPageData_paging($capabilities);
        $this->loadView('m_capability/add', lang('Form.capability'), $data);
        
    }

    public function addsave()
    {

        $res = $this->hasPermission('m_capability', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $capabilities = new M_capabilities();
        $capabilities->parseFromRequest();

        DbTrans::beginTransaction();
        try {
            $capabilities->validate();
            $capabilities->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            DbTrans::commit();
            return Redirect::redirect('mcapability/add')->go();
            // }
        } catch (EloquentException $e) {
            DbTrans::rollback();
            Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect('mcapability/add')->with($e->getEntity())->go();
            }
    }

    public function edit($id)
    {
        $res = $this->hasPermission('m_capability', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $capabilities = M_capabilities::find($id);
        $data['model'] = $capabilities;
        $this->loadView('m_capability/edit', lang('Form.capability'), $data);
        
    }

    public function editsave()
    {

        $res = $this->hasPermission('m_capability', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $id = $this->request->getPost('Id');

        $capabilities = M_capabilities::find($id);
        $oldmodel = clone $capabilities;

        $capabilities->parseFromRequest();

        try {
            $capabilities->validate($oldmodel);

            $capabilities->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect("mcapability")->go();
            
        } catch (EloquentException $e) {
            Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("mcapability/edit/$id")->with($capabilities)->go();
        }
        
    }


    public function delete()
    {
        $res = $this->hasPermission('m_capability', 'Delete');

        if(!$res){
            echo json_encode(deleteStatus(lang("Info.no_access_delete"), FALSE, TRUE));
        } else {

            $id = $this->request->getPost("id");
            $model = M_capabilities::find($id);

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

        if ($this->hasPermission('m_capability', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_capabilities');
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
                                "href" => baseUrl('mcapability/edit/' . $row->Id),
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
        $datatable->eloquent('App\\Eloquents\\M_capabilities');
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
