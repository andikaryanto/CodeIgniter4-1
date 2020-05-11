<?php

namespace App\Controllers;

use App\Eloquents\M_employees;
use App\Eloquents\M_accessroles;
use App\Controllers\Base_Controller;
use App\Libraries\Session;
use App\Eloquents\M_enumdetails;
use App\Libraries\Redirect;
use AndikAryanto11\Datatables;

class M_employee extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        if ($this->hasPermission('m_employee', 'Read')) {
            $this->loadView('m_employee/index', lang('Form.employee'));
        }
    }

    public function add()
    {
        if ($this->hasPermission('m_employee', 'Write')) {
            $employees = new M_employees();
            $data = setPageData_paging($employees);
            $this->loadView('m_employee/add', lang('Form.employee'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_employee', 'Write')) {
            $employees = new M_employees();
            $employees->parseFromRequest();

            $validate = $employees->validate();
            if ($validate) {

                Session::setFlash('add_warning_msg', $validate);
                return Redirect::redirect('memployee/add')->with($employees)->go();
            } else {

                $employees->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('memployee/add')->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('m_employee', 'Write')) {

            $employees = M_employees::find($id);
            $data['model'] = $employees;
            $this->loadView('m_employee/edit', lang('Form.employee'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('m_employee', 'Write')) {
            $id = $this->request->getPost('Id');


            $employees = M_employees::find($id);
            $oldmodel = clone $employees;

            $employees->parseFromRequest();

            $validate = $employees->validate($oldmodel);
            if ($validate) {

                Session::setFlash('edit_warning_msg', $validate);
                return Redirect::redirect("memployee/edit/{$id}")->with($employees)->go();
            } else {

                $employees->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect("memployee")->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('m_employee', 'Delete')) {
            $model = M_employees::find($id);
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

        if ($this->hasPermission('m_employee', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_employees');
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
                                "href" => baseUrl('memployee/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'Phone',
                    null,
                    function ($row) {
                        return $row->Phone;
                    }
                )->addColumn(
                    'Address',
                    null,
                    function ($row) {
                        return $row->Address;
                    }
                )->addColumn(
                    'NIP',
                    null,
                    function ($row) {
                        return $row->NIP;
                    }
                )->addColumn(
                    'M_Occupation_Id',
                    null,
                    function ($row) {
                        return $row->get_M_Occupation()->Name;
                    },
                    false,
                    true
                )->addColumn(
                    'EmployeeDepartment',
                    null,
                    function ($row) {
                        return M_enumdetails::findEnumName("EmployeeDepartment", $row->EmployeeDepartment);
                    }
                )->addColumn(
                    'EmployeeStatus',
                    null,
                    function ($row) {
                        return M_enumdetails::findEnumName("EmployeeStatus", $row->EmployeeStatus);
                    }
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
        $datatable->eloquent('App\\Eloquents\\M_employees');
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
