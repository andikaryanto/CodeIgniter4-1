<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_infrastructures;
use App\Eloquents\M_accessroles;
use App\Controllers\Base_Controller;
use App\Libraries\File;
use App\Eloquents\M_enumdetails;
use App\Eloquents\M_infrastructurecategories;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class M_infrastructure extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        if ($this->hasPermission('m_infrastructure', 'Read')) {

            $disaster = $this->request->getGet("Category");

            $params = [
                'join' => [
                    'm_infrastructurecategories' => [
                        [
                            'table' => 'm_infrastructures',
                            'column' => 'M_Infrastructurecategory_Id',
                            'type' => 'left'
                        ]
                    ]
                ],
                'whereIn' => [
                    "m_infrastructurecategories.Id" => $disaster
                ]
            ];
            $infra = M_infrastructures::findAll($params);

            $data['input'] = [
                "Category" => $disaster ? "[" . implode(",", $disaster) . "]" : array()
            ];
            $data['model'] = $infra;
            $this->loadView('m_infrastructure/index', lang('Form.infrastructure'),  $data);
        }
    }

    public function add()
    {
        if ($this->hasPermission('m_infrastructure', 'Write')) {
            $infrastructures = new M_infrastructures();
            $data = setPageData_paging($infrastructures);
            $this->loadView('m_infrastructure/add', lang('Form.infrastructure'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_infrastructure', 'Write')) {
            // echo json_encode($this->request->request());

            $infrastructures = new M_infrastructures();
            $infrastructures->parseFromRequest();
            $infrastructures->IsActive = 1;

            try {
                $infrastructures->validate();

                $file = $this->request->getFiles('photo');
                $fileCls = new File("assets/upload/infrastructure", ["jpg", "jpeg"]);
                if ($fileCls->upload($file)) {
                    $infrastructures->PhotoUrl = $fileCls->getFileUrl();
                    $infrastructures->save();
                    Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                    return Redirect::redirect('minfrastructure/add')->go();
                    // echo json_encode($infrastructures);
                } else {

                    throw new EloquentException($fileCls->getErrorMessage(), $infrastructures);
                }
            } catch (EloquentException $e) {

                Session::setFlash('add_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("minfrastructure/add")->with($e->data)->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('m_infrastructure', 'Write')) {
            $infrastructures = M_infrastructures::find($id);
            $data['model'] = $infrastructures;
            $this->loadView('m_infrastructure/edit', lang('Form.infrastructure'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('m_infrastructure', 'Write')) {
            $id = $this->request->getPost('Id');

            $infrastructures = M_infrastructures::find($id);
            $oldmodel = clone $infrastructures;

            $infrastructures->parseFromRequest();

            $validate = $infrastructures->validate($oldmodel);
            if ($validate) {

                Session::setFlash('edit_warning_msg', $validate);
                return Redirect::redirect("minfrastructure/edit/{$id}")->with($infrastructures)->go();
            } else {

                $file = $this->request->getFiles('photo');
                // echo json_encode($file);
                if ($file['name']) {
                    // echo json_encode($this->request->getFiles('photo'));
                    $fileCls = new File("assets/upload/infrastructure", ["jpg", "jpeg"]);
                    if ($fileCls->upload($file)) {

                        unlink(FCPATH  . $oldmodel->PhotoUrl);
                        $infrastructures->PhotoUrl = $fileCls->getFileUrl();
                        $infrastructures->save();
                        Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                        return Redirect::redirect('minfrastructure')->go();
                    } else {

                        Session::setFlash('edit_warning_msg', array(0 => $fileCls->getErrorMessage()));
                        return Redirect::redirect("minfrastructure/edit/{$id}")->with($infrastructures)->go();
                    }
                } else {
                    $infrastructures->save();
                }
            }

            return Redirect::redirect('minfrastructure')->go();
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('m_infrastructure', 'Delete')) {
            $model = M_infrastructures::find($id);
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

        if ($this->hasPermission('m_infrastructure', 'Read')) {

            $params = [
                'join' => [
                    'm_infrastructurecategories' => [
                        [
                        'table' => 'm_infrastructures',
                        'column' => 'M_Infrastructurecategory_Id',
                        'type' => 'left']
                    ]
                ]
            ];

            $datatable = new Datatables('M_infrastructures', $params);
            $datatable
                ->addDtRowClass("rowdetail")
                ->addColumn(
                    'm_infrastructures.Id',
                    null,
                    function ($row) {
                        return $row->Id;
                    },
                    false,
                    false
                )->addColumn(
                    'm_infrastructures.Name',
                    null,
                    function ($row) {
                        return
                            formLink($row->Name, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl('minfrastructure/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'm_infrastructures.Address',
                    null,
                    function ($row) {
                        return $row->Address;
                    }
                )->addColumn(
                    'm_infrastructures.PersonInCharge',
                    null,
                    function ($row) {
                        return $row->PersonInCharge;
                    }
                )->addColumn(
                    'm_infrastructures.Phone',
                    null,
                    function ($row) {
                        return $row->Phone;
                    }
                )->addColumn(
                    'm_infrastructures.Capacity',
                    null,
                    function ($row) {
                        return $row->Capacity;
                    }
                )->addColumn(
                    'm_infrastructurecategories.Name',
                    null,
                    function ($row) {
                        return $row->get_M_Infrastructurecategory()->Name;
                    }
                )->addColumn(
                    'm_infrastructures.IsActive',
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
                        return
                            formLink("<i class='fa fa-image'></i>", array(
                                "href" => "#modalBarrack",
                                "data-toggle" => "modal",
                                "class" => "btn-just-icon link-action image",
                                "rel" => "tooltip",
                                "title" => lang('Form.picture')
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
        $datatable->eloquent('App\\Eloquents\\M_infrastructures');
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

    public function getData()
    {

        $id = $this->request->getPost("id");
        $infra = new M_infrastructures();
        $model = $infra->find($id);

        echo json_encode($model);
    }

    public function map()
    {
        if ($this->hasPermission('m_infrastructure', 'Read')) {

            $datas['category'] = M_infrastructurecategories::findAll();

            $category = $this->request->getGet("Category");
            $params = array();
            if ($category)
                $params = [
                    'whereIn' => [
                        "M_Infrastructurecategory_Id" => $category
                    ]
                ];

            $datas['model'] = M_infrastructures::findAll($params);
            $this->loadView('m_infrastructure/map', lang('Form.map'), $datas);
        }
    }
}
