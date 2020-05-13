<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_equipmentowners;
use App\Controllers\Base_Controller;
use App\Libraries\Session;
use App\Eloquents\M_equipments;
use App\Libraries\Redirect;
use AndikAryanto11\Datatables;

class M_equipmentowner extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index($idequipment)
    {
        $res = $this->hasPermission('m_equipment', 'Read');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }


        $result = M_equipments::find($idequipment);
        $data['model'] = $result;

        $this->loadView('m_equipmentowner/index', lang('Form.equipmentowner'), $data);
        
    }

    public function add($idequipment)
    {
        $res = $this->hasPermission('m_equipment', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $result = M_equipments::find($idequipment);

        $equipmentowners = new M_equipmentowners();

        $data = setPageData_paging($equipmentowners);

        $data['equipment'] = $result;
        $this->loadView('m_equipmentowner/add', lang('Form.equipmentowner'), $data);
    
    }

    public function addsave()
    {

        $res = $this->hasPermission('m_equipment', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $equipmentowners = new M_equipmentowners();
        $equipmentowners->parseFromRequest();

        try {
            $equipmentowners->validate();

            $equipmentowners->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect("mequipmentowner/add/{$equipmentowners->M_Equipment_Id}")->go();
        } catch (EloquentException $e) {
            Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("mequipmentowner/add/{$equipmentowners->M_Equipment_Id}")->with($equipmentowners)->go();
        }
    
    }

    public function edit($id)
    {
        $res = $this->hasPermission('m_equipment', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $equipmentowners = M_equipmentowners::find($id);

        $result = M_equipments::find($equipmentowners->M_Equipment_Id);

        $data['model'] = $equipmentowners;
        $data['equipment'] = $result;
        $this->loadView('m_equipmentowner/edit', lang('Form.equipmentowner'), $data);
        
    }

    public function editsave()
    {

        $res = $this->hasPermission('m_equipment', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $id = $this->request->getPost('Id');

        $equipmentowners = M_equipmentowners::find($id);
        $oldmodel = clone $equipmentowners;

        $equipmentowners->parseFromRequest();

        try {
            $equipmentowners->validate($oldmodel);

            $equipmentowners->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect("mequipmentowner/$equipmentowners->M_Equipment_Id")->go();
        } catch (EloquentException $e) {
            Session::setFlash('edit_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("mequipmentowner/edit/{$id}")->with($equipmentowners)->go();
        }
        
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        $res = $this->hasPermission('m_equipment', 'Delete');

        if(!$res){
            echo json_encode(deleteStatus(lang("Info.no_access_delete"), FALSE, TRUE));
        } else {

            $model = M_equipmentowners::find($id);
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

    public function getAllData($idequipment)
    {


        if ($this->hasPermission('m_equipment', 'Read')) {

            $params = [
                'where' => [
                    'M_Equipment_Id' => $idequipment
                ],
                'join' => [
                    'm_subvillages' => [
                        [
                            'table' => 'm_equipmentowners',
                            'column' => 'M_Subvillage_Id',
                            'type' => 'left',
                        ]
                    ]
                ]
            ];
            $datatable = new Datatables('M_equipmentowners', $params);
            $datatable
                ->addDtRowClass("rowdetail")
                ->addColumn(
                    'm_equipmentowners.Id',
                    null,
                    function ($row) {
                        return $row->Id;
                    },
                    false,
                    false
                )->addColumn(
                    'm_equipmentowners.OwnerName',
                    null,
                    function ($row) {
                        return
                            formLink($row->OwnerName, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl("mequipmentowner/edit/$row->Id"),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'm_equipmentowners.Address',
                    null,
                    function ($row) {
                        return $row->Address;
                    }
                )->addColumn(
                    'm_equipmentowners.GoodQty',
                    null,
                    function ($row) {
                        return $row->GoodQty;
                    },
                    false
                )->addColumn(
                    'm_equipmentowners.DamagedQty',
                    null,
                    function ($row) {
                        return $row->DamagedQty;
                    },
                    false
                )->addColumn(
                    'm_equipmentowners.Phone',
                    null,
                    function ($row) {
                        return $row->Phone;
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
                'Name',
                null,
                function ($row) {
                    return $row->Name;
                }
            );

        echo json_encode($datatable->populate());
    }
}
