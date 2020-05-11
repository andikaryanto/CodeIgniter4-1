<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_accessroles;
use App\Controllers\Base_Controller;
use App\Eloquents\R_reportaccessroles;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;
use App\Eloquents\M_groupusers;

class M_groupuser extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {

        if ($this->hasPermission('m_groupuser', 'Read')) {
            $this->loadView('m_groupuser/index', lang('Form.groupuser'));
        }
    }

    public function add()
    {

        if ($this->hasPermission('m_groupuser', 'Write')) {
            $groupusers = new M_groupusers();
            $data = setPageData_paging($groupusers);
            $this->loadView('m_groupuser/add', lang('Form.groupuser'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_groupuser', 'Write')) {

            $groupusers = new M_groupusers();
            $groupusers->parseFromRequest();

            try {
                $groupusers->validate();
                $groupusers->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('mgroupuser/add')->go();
            } catch (EloquentException $e) {

                Session::setFlash('add_warning_msg', array(0 => $e->messages));
                return Redirect::redirect('mgroupuser/add')->with($groupusers)->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('m_groupuser', 'Write')) {
            $groupusers = M_groupusers::find($id);
            $data['model'] = $groupusers;
            $this->loadView('m_groupuser/edit', lang('Form.groupuser'), $data);
        }
    }

    public function editsave()
    {
        if ($this->hasPermission('m_groupuser', 'Write')) {
            $id = $this->request->getPost('Id');

            $groupusers = M_groupusers::find($id);
            $oldmodel = clone $groupusers;

            $groupusers->parseFromRequest();

            try {
                $groupusers->validate($oldmodel);

                $groupusers->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('mgroupuser')->go();
            } catch (EloquentException $e) {

                Session::setFlash('edit_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("mgroupuser/edit/{$id}")->with($groupusers)->go();
            }
        }
    }

    public function editrole($groupid)
    {
        if ($this->hasPermission('m_groupuser', 'Write')) {
            $groupuser = new M_groupusers();
            $groups = $groupuser->find($groupid);
            //$modeldetail = $modelheader->View_m_accessrole();

            //$data =  $this->paging->set_data_page_index($modeldetail, null, null, null, $modelheader);
            $data['model'] = $groups;
            $this->loadView('m_groupuser/roles', lang('Form.groupuser'), $data);
        }
    }

    public function editreportrole($groupid)
    {

        if ($this->hasPermission('m_groupuser', 'Write')) {
            $groupuser = new M_groupusers();
            $modelheader = $groupuser->find($groupid);
            //$modeldetail = $modelheader->View_m_accessrole();

            //$data =  $this->paging->set_data_page_index($modeldetail, null, null, null, $modelheader);
            $data['model'] = $modelheader;
            $this->loadView('m_groupuser/reportRoles', lang('Form.groupuser'), $data);
        }
    }

    public function saverole()
    {
        if ($this->hasPermission('m_groupuser', 'Write')) {
            $formid = $this->request->getPost("formid");
            $groupid = $this->request->getPost("groupid");
            $read = $this->request->getPost("read");
            $write = $this->request->getPost("write");
            $delete = $this->request->getPost("delete");
            $print = $this->request->getPost("print");

            $params = array(
                'where' => array(
                    'M_Form_Id' => $formid,
                    'M_Groupuser_Id' => $groupid
                )
            );
            $maccessroles = new M_accessroles();
            $roles = $maccessroles->findOne($params);
            if ($roles) {
                $roles->Read = $read;
                $roles->Write = $write;
                $roles->Delete = $delete;
                $roles->Print = $print;
                $roles->save();
                echo json_encode($roles);
            } else {
                $maccessroles->M_Form_Id = $formid;
                $maccessroles->M_Groupuser_Id = $groupid;
                $maccessroles->Read = $read;
                $maccessroles->Write = $write;
                $maccessroles->Delete = $delete;
                $maccessroles->Print = $print;
                $maccessroles->save();
                echo json_encode($maccessroles);
            }
        }
    }

    public function savereportrole()
    {
        if ($this->hasPermission('m_groupuser', 'Write')) {
            $reportid = $this->request->getPost("reportid");
            $groupid = $this->request->getPost("groupid");
            $read = $this->request->getPost("read");

            $params = array(
                'where' => array(
                    'R_Report_Id' => $reportid,
                    'M_Groupuser_Id' => $groupid
                )
            );

            $new_roles = new R_reportaccessroles();
            $roles = $new_roles->findOne($params);
            if ($roles) {
                $roles->Read = $read;
                $roles->Write = 0;
                $roles->Delete = 0;
                $roles->Print = 0;
                $roles->save();
                echo json_encode($roles);
            } else {
                $new_roles->R_Report_Id = $reportid;
                $new_roles->M_Groupuser_Id = $groupid;
                $new_roles->Read = $read;
                $new_roles->Write = 0;
                $new_roles->Delete = 0;
                $new_roles->Print = 0;
                $new_roles->save();
                echo json_encode($new_roles);
            }
        }
    }

    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('m_groupuser', 'Delete')) {
            $model = M_groupusers::find($id);
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

        if ($this->hasPermission('m_groupuser', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_groupusers');
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
                    'GroupName',
                    null,
                    function ($row) {
                        return
                            formLink($row->GroupName, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl('mgroupuser/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'Description',
                    null,
                )->addColumn(
                    'Created',
                    null,
                    null,
                    false
                )->addColumn(
                    'Action',
                    null,
                    function ($row) {
                        return
                            formLink("<i class='fa fa-user'></i>", array(
                                "href" => "#",
                                "class" => "btn-just-icon link-action role",
                                "rel" => "tooltip",
                                "title" => lang('Form.role')
                            )) .
                            formLink("<i class='fa fa-list'></i>", array(
                                "href" => "#",
                                "class" => "btn-just-icon link-action reportrole",
                                "rel" => "tooltip",
                                "title" => lang('Form.reportrole')
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
        $datatable->eloquent('App\\Eloquents\\M_groupusers');
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
                'GroupName',
                null,
                function ($row) {
                    return $row->GroupName;
                }
            );

        echo json_encode($datatable->populate());
    }
}
