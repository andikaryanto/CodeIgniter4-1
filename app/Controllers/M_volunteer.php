<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_volunteers;
use App\Eloquents\M_accessroles;
use App\Controllers\Base_Controller;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class M_volunteer extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        if ($this->hasPermission('m_volunteer', 'Read')) {

            $this->loadView('m_volunteer/index', lang('Form.volunteer'));
        }
    }

    public function add()
    {
        if ($this->hasPermission('m_volunteer', 'Write')) {
            $volunteers = new M_volunteers();
            $volunteers->BirthDate = get_formated_date(null, "d-m-Y");
            $data = setPageData_paging($volunteers);
            $this->loadView('m_volunteer/add', lang('Form.volunteer'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_volunteer', 'Write')) {

            $volunteers = new M_volunteers();
            $volunteers->parseFromRequest();
            try {
                $volunteers->validate();


                $volunteers->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('mvolunteer/add')->go();
            } catch (EloquentException $e) {

                Session::setFlash('add_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("mvolunteer/add")->with($e->data)->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('m_volunteer', 'Write')) {

            $volunteers = M_volunteers::find($id);
            $volunteers->BirthDate = get_formated_date($volunteers->BirthDate, "d-m-Y");
            $data['model'] = $volunteers;
            $this->loadView('m_volunteer/edit', lang('Form.volunteer'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('m_volunteer', 'Write')) {

            $id = $this->request->getPost('Id');

            $volunteers = M_volunteers::find($id);
            $oldmodel = clone $volunteers;

            $volunteers->parseFromRequest();

            try{
                $volunteers->validate($oldmodel);
                $volunteers->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('mvolunteer')->go();
            } catch (EloquentException $e) {

                Session::setFlash('edit_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("mvolunteer/edit/{$id}")->with($e->data)->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('m_volunteer', 'Delete')) {

            $model = M_volunteers::find($id);

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

        if ($this->hasPermission('m_volunteer', 'Read')) {
            $params = [
                'join' => [
                    'm_communities' => [
                        [
                            'key' => 'm_volunteers.M_Community_Id = m_communities.Id',
                            'type' => 'left',
                        ]
                    ],
                    'm_capabilities' => [
                        [
                            'column' => 'm_volunteers.M_Capability_Id = m_capabilities.Id',
                            'type' => 'left',
                        ]
                    ]
                ]
            ];
            $datatable = new Datatables($params);
            $datatable->eloquent('App\\Eloquents\\M_volunteers');
            $datatable
                ->addDtRowClass("rowdetail")
                ->addColumn(
                    'm_volunteers.Id',
                    null,
                    function ($row) {
                        return $row->Id;
                    },
                    false,
                    false
                )->addColumn(
                    'm_volunteers.Name',
                    null,
                    function ($row) {
                        return
                            formLink($row->Name, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl('mvolunteer/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'm_volunteers.NRR',
                    null,
                    function ($row) {
                        return $row->NRR;
                    }
                )->addColumn(
                    'm_volunteers.NIK',
                    null,
                    function ($row) {
                        return $row->NIK;
                    }
                )->addColumn(
                    'm_capabilities.Name',
                    null,
                    function ($row) {
                        return $row->get_M_Capability()->Name;
                    }
                )->addColumn(
                    'm_communities.Name',
                    null,
                    function ($row) {
                        return $row->get_M_Community()->Name;
                    }
                )->addColumn(
                    'm_volunteers.Created',
                    null,
                    function ($row) {
                        return $row->Created;
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
        $datatable->eloquent('App\\Eloquents\\M_volunteers');
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
