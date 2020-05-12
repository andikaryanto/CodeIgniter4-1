<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_safedistances;
use App\Eloquents\M_accessroles;
use App\Controllers\Base_Controller;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class M_safedistance extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        if ($this->hasPermission('m_safedistance', 'Read')) {

            $this->loadView('m_safedistance/index', lang('Form.safedistance'));
        }
    }

    public function add()
    {
        if ($this->hasPermission('m_safedistance', 'Write')) {
            $safedistances = new M_safedistances();
            $data = setPageData_paging($safedistances);
            $this->loadView('m_safedistance/add', lang('Form.safedistance'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_safedistance', 'Write')) {

            $safedistances = new M_safedistances();
            $safedistances->parseFromRequest();
            try {
                $safedistances->validate();

                $safedistances->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('msafedistance/add')->go();
            } catch (EloquentException $e) {

                Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
                return Redirect::redirect("msafedistance/add")->with($e->getEntity())->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('m_safedistance', 'Write')) {

            $safedistances = M_safedistances::find($id);
            $data['model'] = $safedistances;
            $this->loadView('m_safedistance/edit', lang('Form.safedistance'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('m_safedistance', 'Write')) {

            $id = $this->request->getPost('Id');

            $safedistances = M_safedistances::find($id);
            $oldmodel = clone $safedistances;

            $safedistances->parseFromRequest();

            try {
                $safedistances->validate($oldmodel);

                $safedistances->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('msafedistance')->go();
            } catch (EloquentException $e) {

                Session::setFlash('edit_warning_msg', array(0 => $e->getMessages()));
                return Redirect::redirect("msafedistance/edit/{$id}")->with($e->getEntity())->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('m_safedistance', 'Delete')) {

            $model = M_safedistances::find($id);

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

        if ($this->hasPermission('m_safedistance', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_safedistances');
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
                    'Distance',
                    null,
                    function ($row) {
                        return
                            formLink($row->Distance, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl('msafedistance/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'StatusLevel',
                    null,
                    function ($row) {
                        return $row->StatusLevel;
                    }
                )->addColumn(
                    'Recommend',
                    null,
                    function ($row) {
                        return $row->Recommend;
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
        $datatable->eloquent('App\\Eloquents\\M_safedistances');
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
                'Distance',
                null,
                function ($row) {
                    return $row->Distance;
                }
            );

        echo json_encode($datatable->populate());
    }
}
