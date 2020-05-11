<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_warehouses;
use App\Controllers\Base_Controller;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class M_warehouse extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        if ($this->hasPermission('m_warehouse', 'Read')) {
            // $warehouses = new M_warehouses();

            // $result = $warehouses->findAll();
            // $data['model'] = $result;
            $this->loadView('m_warehouse/index', lang('Form.warehouse'));
        }
    }

    public function add()
    {
        if ($this->hasPermission('m_warehouse', 'Write')) {
            $warehouses = new M_warehouses();
            $data = setPageData_paging($warehouses);
            $this->loadView('m_warehouse/add', lang('Form.warehouse'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_warehouse', 'Write')) {

            $warehouses = new M_warehouses();
            $warehouses->parseFromRequest();

            try {
                $warehouses->validate();


                $warehouses->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('mwarehouse/add')->go();
            } catch (EloquentException $e) {

                Session::setFlash('add_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("mwarehouse/add")->with($e->data)->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('m_warehouse', 'Write')) {

            $warehouses = M_warehouses::find($id);
            $data['model'] = $warehouses;
            $this->loadView('m_warehouse/edit', lang('Form.warehouse'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('m_warehouse', 'Write')) {
            $id = $this->request->getPost('Id');

            $warehouses = M_warehouses::find($id);
            $oldmodel = clone $warehouses;

            $warehouses->parseFromRequest();
            // echo json_encode($warehouses);

            try {
                $warehouses->validate($oldmodel);
                $warehouses->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('mwarehouse')->go();
            } catch (EloquentException $e) {

                Session::setFlash('edit_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("mwarehouse/edit/{$id}")->with($e->data)->go();
            }
        }
    }

    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('m_warehouse', 'Delete')) {
            $model = M_warehouses::find($id);
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

        if ($this->hasPermission('m_warehouse', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_warehouses');
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
                                "href" => baseUrl('mwarehouse/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    '',
                    null,
                    function ($row) {
                        return $row->get_M_Subvillage()->Name;
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
        $datatable->eloquent('App\\Eloquents\\M_warehouses');
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
                    return $row->get_M_Subvillage()->Name;
                },
                false
            );

        echo json_encode($datatable->populate());
    }
}
