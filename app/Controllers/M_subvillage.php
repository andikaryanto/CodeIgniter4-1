<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_subvillages;
use App\Eloquents\M_accessroles;
use App\Controllers\Base_Controller;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class M_subvillage extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        if ($this->hasPermission('m_subvillage', 'Read')) {


            $this->loadView('m_subvillage/index', lang('Form.subvillage'));
        }
    }

    public function add()
    {
        if ($this->hasPermission('m_subvillage', 'Write')) {
            $subvillages = new M_subvillages();
            $data = setPageData_paging($subvillages);
            $this->loadView('m_subvillage/add', lang('Form.subvillage'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_subvillage', 'Write')) {

            $subvillages = new M_subvillages();
            $subvillages->parseFromRequest();
            try {
                $subvillages->validate();

                $subvillages->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('msubvillage/add')->with($subvillages)->go();
            } catch (EloquentException $e) {

                Session::setFlash('add_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("msubvillage/add")->with($e->data)->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('m_subvillage', 'Write')) {

            $subvillages = M_subvillages::find($id);
            $data['model'] = $subvillages;
            $this->loadView('m_subvillage/edit', lang('Form.subvillage'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('m_subvillage', 'Write')) {
            $id = $this->request->getPost('Id');


            $subvillages = M_subvillages::find($id);
            $oldmodel = clone $subvillages;

            $subvillages->parseFromRequest();

            try {
                $subvillages->validate($oldmodel);


                $subvillages->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('msubvillage')->go();
            } catch (EloquentException $e) {

                Session::setFlash('edit_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("msubvillage/edit/{$id}")->with($e->data)->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('m_subvillage', 'Delete')) {

            $model = M_subvillages::find($id);
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

        if ($this->hasPermission('m_subvillage', 'Read')) {

            $params = [
                'join' => [
                    "m_villages" => [
                        [
                           
                            'key' => 'm_subvillages.M_Village_Id = m_villages.Id',
                            'type' => 'Left'
                        ]
                    ],
                    "m_subdistricts" => [
                        [
                            'key' => 'm_villages.M_Subdistrict_Id = m_subdistricts.Id',
                            'type' => 'Left'
                        ]
                    ],
                    "m_districts" => [
                        [
                            'key' => 'm_subdistricts.M_District_Id = m_districts.Id',
                            'type' => 'Left'
                        ]
                    ],
                    "m_provinces" => [
                        [
                            'key' => 'm_districts.M_Province_Id = m_provinces.Id',
                            'type' => 'Left'
                        ]
                    ]
                ]
            ];

            $datatable = new Datatables($params);
            $datatable->eloquent('App\\Eloquents\\M_subvillages');
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
                    'm_subvillages.Name',
                    null,
                    function ($row) {
                        return
                            formLink($row->Name, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl('msubvillage/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'm_villages.Name',
                    null,
                    function ($row) {
                        return $row->get_M_Village()->Name;
                    }
                )->addColumn(
                    'm_subdistricts.Name',
                    null,
                    function ($row) {
                        return $row->get_M_Village()->get_M_Subdistrict()->Name;
                    }
                )->addColumn(
                    'm_districts.Name',
                    null,
                    function ($row) {
                        return $row->get_M_Village()->get_M_Subdistrict()->get_M_District()->Name;
                    }
                )->addColumn(
                    'm_provinces.Name',
                    null,
                    function ($row) {
                        return $row->get_M_Village()->get_M_Subdistrict()->get_M_District()->get_M_Province()->Name;
                    }
                )->addColumn(
                    'm_subvillages.IsDestana',
                    null,
                    function ($row) {
                        if ($row->IsDestana)
                            return "<i class = 'fa fa-check'></i>";

                        return "<i class = 'fa fa-times'></i>";
                    },
                    true,
                    true
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
        $datatable->eloquent('App\\Eloquents\\M_subvillages');
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
                    return $row->get_M_Village()->Name;
                },
                false,
                false
            )->addColumn(
                '',
                null,
                function ($row) {
                    return $row->get_M_Village()->get_M_Subdistrict()->Name;
                },
                false,
                false
            )->addColumn(
                '',
                null,
                function ($row) {
                    return $row->get_M_Village()->get_M_Subdistrict()->get_M_District()->Name;
                },
                false,
                false
            )->addColumn(
                '',
                function ($row) {
                    return $row->get_M_Village()->get_M_Subdistrict()->get_M_District()->get_M_Province()->Name;
                },
                false,
                false
            );

        echo json_encode($datatable->populate());
    }
}
