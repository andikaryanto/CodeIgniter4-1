<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_instances;
use App\Eloquents\M_accessroles;
use App\Controllers\Base_Controller;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class M_instance extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        if ($this->hasPermission('m_instance', 'Read')) {

            $this->loadView('m_instance/index', lang('Form.instance'));
        }
    }

    public function add()
    {
        if ($this->hasPermission('m_instance', 'Write')) {
            $instances = new M_instances();
            $data = setPageData_paging($instances);
            $this->loadView('m_instance/add', lang('Form.instance'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_instance', 'Write')) {

            $instances = new M_instances();
            $instances->parseFromRequest();
            try {
                $instances->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('minstance/add')->go();
            } catch (EloquentException $e) {

                Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
                return Redirect::redirect("minstance/add")->with($e->getEntity())->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('m_instance', 'Write')) {

            $instances = M_instances::find($id);
            $data['model'] = $instances;
            $this->loadView('m_instance/edit', lang('Form.instance'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('m_instance', 'Write')) {

            $id = $this->request->getPost('Id');

            $instances = M_instances::find($id);
            $oldmodel = clone $instances;

            $instances->parseFromRequest();

            try {
                $instances->validate($oldmodel);
                $instances->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('minstance')->go();
            } catch (EloquentException $e) {

                Session::setFlash('edit_warning_msg', array(0 => $e->getMessages()));
                return Redirect::redirect("minstance/edit/{$id}")->with($e->getEntity())->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('m_instance', 'Delete')) {

            $model = M_instances::find($id);

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

        if ($this->hasPermission('m_instance', 'Delete')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_instances');
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
                                "href" => baseUrl('minstance/edit/' . $row->Id),
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
        $datatable->eloquent('App\\Eloquents\\M_instances');
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
