<?php

namespace App\Controllers;

use AndikAryanto11\Datatables;
use App\Classes\Exception\EloquentException;
use App\Eloquents\M_users;
use App\Eloquents\M_groupusers;
use App\Controllers\Base_Controller;
use App\Libraries\Redirect;
use App\Libraries\Session;

class M_user extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {

        if ($this->hasPermission('m_user', 'Read')) {

            $this->loadView('m_user/index', lang('Form.user'));
        }
    }

    public function add()
    {

        if ($this->hasPermission('m_user', 'Write')) {
            $users = new M_users();
            $data['model'] = $users;
            $this->loadView('m_user/add', lang('Form.groupuser'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_user', 'Write')) {
            $model = new M_users();
            $model->parseFromRequest();

            try {
                $model->validate();
                $model->setPassword($model->Password);
                $model->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('muser/add')->go();
            } catch (EloquentException $e) {

                Session::setFlash('add_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("muser/add")->with($e->data)->go();
            }
        }
    }

    public function edit($id)
    {

        if ($this->hasPermission('m_user', 'Write')) {
            $users = M_users::find($id);
            $data['model'] = $users;
            $this->loadView('m_user/edit', lang('Form.groupuser'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('m_user', 'Write')) {
            $userid    = $this->request->getGetPost('userid');
            $groupid    = $this->request->getGetPost('groupid');
            $username   = $this->request->getGetPost('named');
            $password   = $this->request->getGetPost('password');

            $model = M_users::find($userid);
            $oldmodel = clone $model;

            $model->M_Groupuser_Id = $groupid;
            $model->Username = $username;
            $model->CreatedBy = $_SESSION[get_variable() . 'userdata']['Username'];

            $validate = $model->validate($oldmodel);
            if ($validate) {

                $data = setPageData_paging($model);
                Session::setFlash('edit_warning_msg', $validate);
                $this->loadView('m_user/edit', $data);
            } else {

                $model->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('muser');
            }
        }
    }

    public function getAllData()
    {

        if ($this->hasPermission('m_user', 'Read')) {
            $params = [
                'whereNotIn' => [
                    'Username' => ["superadmin"]
                ],
                'join' => [
                    'm_groupusers' => [
                        [
                            'key' => 'm_users.M_Groupuser_Id = m_groupusers.Id',
                            'type' => 'left'
                        ]
                    ]
                ]
            ];

            $datatable = new Datatables($params);
            $datatable->eloquent('App\\Eloquents\\M_users');
            $datatable
                ->addColumn(
                    'm_users.Id',
                    null,
                    function ($row) {
                        return $row->Id;
                    },
                    false,
                    false
                )->addColumn(
                    'm_users.Username',
                    null,
                    function ($row) {
                        return "<td>" .
                            formLink($row->Username, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl('mgroupuser/edit/' . $row->Id),
                                "class" => "text-muted"
                            ))
                            . "</td>";
                    }
                )->addColumn(
                    'm_groupusers.GroupName',
                    'M_Groupuser_Id',
                    null,
                    false
                )->addColumn(
                    'm_users.IsActive',
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
                        $class = "";
                        if (!$row->IsActive)
                            $class = "text-danger";

                        return "<td class = 'td-actions text-right'>" .
                            formLink("<i class='fa fa-plug'>", array(
                                "href" => "#",
                                "class" => $class . "btn-just-icon link-action activate"
                            ))
                            . "</td>";
                    },
                    false,
                    false
                );

            echo json_encode($datatable->populate());
        } else {

            return Redirect::redirect("Forbidden");
        }
    }

    public function changelanguage()
    {
        $session = Session::get(get_variable() . 'userdata');
        $user = M_users::find($session['Id']);
        $user->language = $this->request->getGet('language');
        $user->save();
        Session::set(get_variable() . 'userdata', get_object_vars($user));
        Session::set(get_variable() . 'language', $user->language);
        // echo json_encode();
        return Redirect::redirect('home')->go();
    }
}
