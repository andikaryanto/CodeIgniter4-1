<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Controllers\Base_Controller;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;
use App\Eloquents\M_districts;

class M_district extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        if ($this->hasPermission('m_district', 'Read')) {
            // $districts = new M_districts();

            // $result = $districts->findAll();
            // $data['model'] = $result;
            $this->loadView('m_district/index', lang('Form.district'));
        }
    }

    public function add()
    {
        if ($this->hasPermission('m_district', 'Write')) {
            $districts = new M_districts();
            $data = setPageData_paging($districts);
            $this->loadView('m_district/add', lang('Form.district'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_district', 'Write')) {

            $districts = new M_districts();
            $districts->parseFromRequest();

            try {
                $districts->validate();

                $districts->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('mdistrict/add')->with($districts)->go();
            } catch (EloquentException $e) {
                Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
                return Redirect::redirect('mdistrict/add')->with($districts)->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('m_district', 'Write')) {

            $districts = M_districts::find($id);
            $data['model'] = $districts;
            $this->loadView('m_district/edit', lang('Form.district'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('m_district', 'Write')) {
            $id = $this->request->getPost('Id');

            $districts = M_districts::find($id);
            $oldmodel = clone $districts;

            $districts->parseFromRequest();

            try {
                $districts->validate($oldmodel);
                $districts->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('mdistrict')->go();
            } catch (EloquentException $e) {
                Session::setFlash('edit_warning_msg', array(0 => $e->getMessages()));
                return Redirect::redirect("mdistrict/edit/{$id}")->with($districts)->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('m_district', 'Delete')) {
            $model = M_districts::find($id);
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

        if ($this->hasPermission('m_district', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_districts');
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
                                "href" => baseUrl('mdistrict/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    '',
                    null,
                    function ($row) {
                        return $row->get_M_Province()->Name;
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
        $datatable->eloquent('App\\Eloquents\\M_districts');
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
                    return $row->get_M_Province()->Name;
                },
                false
            );

        echo json_encode($datatable->populate());
    }
}
