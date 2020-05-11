<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_villagedisasters;
use App\Eloquents\M_accessroles;
use App\Controllers\Base_Controller;
use App\Libraries\Session;
use App\Libraries\File;
use App\Eloquents\M_enumdetails;
use App\Libraries\Redirect;
use AndikAryanto11\Datatables;

class M_villagedisaster extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        if ($this->hasPermission('m_villagedisaster', 'Read')) {

            $this->loadView('m_villagedisaster/index', lang('Form.villageresistdisaster'));
        }
    }

    public function add()
    {
        if ($this->hasPermission('m_villagedisaster', 'Write')) {
            $villagedisasters = new M_villagedisasters();
            $data = setPageData_paging($villagedisasters);
            $this->loadView('m_villagedisaster/add', lang('Form.villageresistdisaster'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_villagedisaster', 'Write')) {

            $villagedisasters = new M_villagedisasters();
            $villagedisasters->parseFromRequest();
            $villagedisasters->IsActive = 1;

            try {
                $villagedisasters->validate();
                $file = $this->request->getFiles('photo');
                $fileCls = new File("assets/upload/villagedisaster", ["jpg", "jpeg"]);
                if ($fileCls->upload($file)) {
                    $villagedisasters->PhotoUrl = $fileCls->getFileUrl();
                    $villagedisasters->save();
                    Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                    return Redirect::redirect('mvillagedisaster/add')->go();
                    // echo json_encode($villagedisasters);
                } else {

                    throw new EloquentException($fileCls->getErrorMessage(), $villagedisasters);
                }
            } catch (EloquentException $e) {

                Session::setFlash('add_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("mvillagedisaster/add")->with($e->data)->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('m_villagedisaster', 'Write')) {

            $villagedisasters = M_villagedisasters::find($id);
            $data['model'] = $villagedisasters;
            $this->loadView('m_villagedisaster/edit', lang('Form.villageresistdisaster'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('m_villagedisaster', 'Write')) {
            $id = $this->request->getPost('Id');


            $villagedisasters = M_villagedisasters::find($id);
            $oldmodel = clone $villagedisasters;

            $villagedisasters->parseFromRequest();

            try {
                $villagedisasters->validate($oldmodel);
                $file = $this->request->getFiles('photo');
                if ($file['name']) {
                    $fileCls = new File("assets/upload/villagedisaster", ["jpg", "jpeg"]);
                    if ($fileCls->upload($file)) {

                        unlink(APPPATH . $oldmodel->PhotoUrl);
                        $villagedisasters->PhotoUrl = $fileCls->getFileUrl();
                        $villagedisasters->save();
                        Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                        return Redirect::redirect('mvillagedisaster');
                    } else {
                        throw new EloquentException($fileCls->getErrorMessage(), $villagedisasters);
                    }
                } else {
                    $villagedisasters->save();
                    return Redirect::redirect('mvillagedisaster');
                }
            } catch (EloquentException $e) {

                Session::setFlash('edit_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("m_villagedisaster/edit/{$id}")->with($e->data)->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('m_villagedisaster', 'Delete')) {
            $model = M_villagedisasters::find($id);
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

        if ($this->hasPermission('m_villagedisaster', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_villagedisasters');
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
                                "href" => baseUrl('mvillagedisaster/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'Address',
                    null,
                    function ($row) {
                        return $row->Address;
                    }
                )->addColumn(
                    'PersonInCharge',
                    null,
                    function ($row) {
                        return $row->PersonInCharge;
                    }
                )->addColumn(
                    'Phone',
                    null,
                    function ($row) {
                        return $row->Phone;
                    }
                )->addColumn(
                    'Capacity',
                    null,
                    function ($row) {
                        return $row->Capacity;
                    }
                )->addColumn(
                    'Facility',
                    null,
                    function ($row) {
                        return $row->Facility;
                    },
                    false,
                    false
                )->addColumn(
                    'IsActive',
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
                            formLink("<i class='fa fa-picture-o'></i>", array(
                                "href" => "#modalVillageDisaster",
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
        $datatable->eloquent('App\\Eloquents\\M_villagedisasters');
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
        $infra = new M_villagedisasters();
        $model = $infra->find($id);

        echo json_encode($model);
    }
}
