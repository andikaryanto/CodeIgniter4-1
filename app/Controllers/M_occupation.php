<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_occupations;
use App\Eloquents\M_accessroles;
use App\Controllers\Base_Controller;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class M_occupation extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        if ($this->hasPermission('m_occupation', 'Read')) {
            $this->loadView('m_occupation/index', lang('Form.occupation'));
        }
    }

    public function add()
    {
        if ($this->hasPermission('m_occupation', 'Write')) {
            $occupations = new M_occupations();
            $data = setPageData_paging($occupations);
            $this->loadView('m_occupation/add', lang('Form.occupation'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_occupation', 'Write')) {
            $occupations = new M_occupations();
            $occupations->parseFromRequest();

            try {
                $occupations->validate();

                $occupations->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('moccupation/add')->go();
            } catch (EloquentException $e) {

                Session::setFlash('add_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("moccupation/add")->with($e->data)->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('m_occupation', 'Write')) {

            $occupations = M_occupations::find($id);
            $data['model'] = $occupations;
            $this->loadView('m_occupation/edit', lang('Form.occupation'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('m_occupation', 'Write')) {
            $id = $this->request->getPost('Id');


            $occupations = M_occupations::find($id);
            $oldmodel = clone $occupations;

            $occupations->parseFromRequest();

            try {
                $occupations->validate($oldmodel);

                $occupations->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('moccupation')->go();
            } catch (EloquentException $e) {

                Session::setFlash('edit_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("moccupation/edit/{$id}")->with($e->data)->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('m_occupation', 'Delete')) {
            $model = M_occupations::find($id);
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

        if ($this->hasPermission('m_occupation', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_occupations');
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
                                "href" => baseUrl('moccupation/edit/' . $row->Id),
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
        $datatable->eloquent('App\\Eloquents\\M_occupations');
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
