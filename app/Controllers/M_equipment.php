<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_equipments;
use App\Eloquents\M_accessroles;
use App\Controllers\Base_Controller;
use App\Libraries\Session;
use App\Eloquents\M_equipmentowners;
use App\Libraries\Redirect;
use AndikAryanto11\Datatables;

class M_equipment extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        $res = $this->hasPermission('m_equipment', 'Read');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
            
        $this->loadView('m_equipment/index', lang('Form.equipment'));
        
    }

    public function add()
    {
        $res = $this->hasPermission('m_equipment', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $equipments = new M_equipments();
        $data = setPageData_paging($equipments);
        $this->loadView('m_equipment/add', lang('Form.equipment'), $data);
    
    }

    public function addsave()
    {

        $res = $this->hasPermission('m_equipment', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $equipments = new M_equipments();
        $equipments->parseFromRequest();

        try {
            $equipments->validate();

            $equipments->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect('mequipment/add')->go();
        } catch (EloquentException $e) {
            Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect('mequipment/add')->with($equipments)->go();
        }
    
    }

    public function edit($id)
    {
        $res = $this->hasPermission('m_equipment', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $equipments = M_equipments::find($id);
        $equipmentownwer = new M_equipmentowners();

        $data['model'] = $equipments;
        $data['equipmentownwer'] = $equipmentownwer;
        $this->loadView('m_equipment/edit', lang('Form.equipment'), $data);
        
    }

    public function editsave()
    {

        $res = $this->hasPermission('m_equipment', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $id = $this->request->getPost('Id');

        $equipments = M_equipments::find($id);
        $oldmodel = clone $equipments;

        $equipments->parseFromRequest();

        try {
            $equipments->validate($oldmodel);

            $equipments->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect('mequipment')->go();
        } catch (EloquentException $e) {
            Session::setFlash('edit_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("mequipment/edit/{$id}")->with($equipments)->go();
        }
        
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        $res = $this->hasPermission('m_equipment', 'Delete');

        if(!$res){
            echo json_encode(deleteStatus(lang("Info.no_access_delete"), FALSE, TRUE));
        } else {

            $model = M_equipments::find($id);
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

        if ($this->hasPermission('m_equipment', 'Read')) {

            $datatable = new Datatables();
            
            $datatable->eloquent('App\\Eloquents\\M_equipments');
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
                                "href" => baseUrl('mequipment/edit/' . $row->Id),
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
                            formLink("<i class='fa fa-user-plus'></i>", array(
                                "href" => "#",
                                "class" => "btn-just-icon link-action owner",
                                "rel" => "tooltip",
                                "title" => lang('Form.owner')
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

    public function getOwner($idequipment)
    {
        $params = [
            'where' => [
                'M_Equipment_Id' => $idequipment
            ]
        ];
        $datatable = new Datatables($params);
        $datatable->eloquent('App\\Eloquents\\M_equipmentowners');
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
                'OwnerName',
                null,
                function ($row) {

                    return $row->OwnerName;
                }
            )->addColumn(
                'Address',
                null,
                function ($row) {
                    return $row->Address;
                }
            )->addColumn(
                'GoodQty',
                null,
                function ($row) {
                    return $row->GoodQty;
                },
                false
            )->addColumn(
                'DamagedQty',
                null,
                function ($row) {
                    return $row->DamagedQty;
                },
                false
            )->addColumn(
                'Phone',
                null,
                function ($row) {
                    return $row->Phone;
                }
            )->addColumn(
                'Action',
                null,
                function ($row) {
                    return
                        formLink("<i class='fa fa-edit'></i>", array(
                            "href" => "#",
                            "class" => "btn-just-icon link-action edit",
                            "rel" => "tooltip",
                            "title" => lang('Form.owner')
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

    public function getDataModal()
    {

        $datatable = new Datatables();
        $datatable->eloquent('App\\Eloquents\\M_equipments');
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
