<?php

namespace App\Controllers;

use AndikAryanto11\Datatables;
use App\Classes\Exception\EloquentException;
use App\Eloquents\T_inoutitemdetails;
use App\Controllers\Base_Controller;
use App\Enums\T_inoutitemsStatus;
use App\Eloquents\M_enumdetails;
use App\Eloquents\M_itemstocks;
use App\Eloquents\T_inoutitems;
use App\Libraries\Redirect;
use App\Libraries\Session;

class T_inoutitemdetail extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index($idinoutitem)
    {
        if ($this->hasPermission('t_inoutitem','Read')) {

            $result = T_inoutitems::find($idinoutitem);
            $data['model'] = $result;

            $this->loadView('t_inoutitemdetail/index', lang('Form.inoutitemdetail'), $data);
        }
    }

    public function add($idinoutitem)
    {
        if ($this->hasPermission('t_inoutitem','Write')) {

            $result = T_inoutitems::find($idinoutitem);;

            if($result->Status == T_inoutitemsStatus::RELEASE || $result->Status == T_inoutitemsStatus::CANCEL){
                $status = M_enumdetails::findEnumName("InoutitemStatus", $result->Status);
                Session::setFlash('edit_warning_msg', array(0 => "Transaksi $result->TransNo tidak bisa ditambah barang, Status : {$status}"));
                return Redirect::redirect("tinoutitemdetail/{$result->Id}")->go();
            } 

            $inoutitemdetails = new T_inoutitemdetails();

            $data = setPageData_paging($inoutitemdetails);

            $data['inoutitem'] = $result;
            $this->loadView('t_inoutitemdetail/add', lang('Form.inoutitemdetail'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('t_inoutitem','Write')) {


            $inoutitemdetails = new T_inoutitemdetails();
            $inoutitemdetails->parseFromRequest();
            try {

                $inoutitemdetails->validate();
                $inoutitemdetails->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect("tinoutitemdetail/add/{$inoutitemdetails->T_Inoutitem_Id}")->go();
            } catch (EloquentException $e){
                
                Session::setFlash('add_warning_msg', $e->getMessages());
                return Redirect::redirect("tinoutitemdetail/add/{$inoutitemdetails->T_Inoutitem_Id}")->with($e->getEntity())->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('t_inoutitem','Write')) {

            $inoutitemdetails = T_inoutitemdetails::find($id);
            $result = $inoutitemdetails->get_T_Inoutitem();
            if($result->Status == T_inoutitemsStatus::RELEASE || $result->Status == T_inoutitemsStatus::CANCEL){
                $status = M_enumdetails::findEnumName("InoutitemStatus", $result->Status);
                Session::setFlash('edit_warning_msg', array(0 => "Transaksi $result->TransNo tidak bisa edit barang, Status : {$status}"));
                return Redirect::redirect("tinoutitemdetail/{$result->Id}")->go();
            } 
            $result = T_inoutitems::find($inoutitemdetails->T_Inoutitem_Id);

            $data['model'] = $inoutitemdetails;
            $data['inoutitem'] = $result;
            $this->loadView('t_inoutitemdetail/edit', lang('Form.inoutitemdetail'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('t_inoutitem','Write')) {

            $id = $this->request->getPost('Id');
            
            $inoutitemdetails = T_inoutitemdetails::find($id);
            $inoutitemdetails->parseFromRequest();
            $result = $inoutitemdetails->get_T_Inoutitem();
            if($result->Status == T_inoutitemsStatus::RELEASE || $result->Status == T_inoutitemsStatus::CANCEL){
                $status = M_enumdetails::findEnumName("InoutitemStatus", $result->Status);
                Session::setFlash('edit_warning_msg', array(0 => "Transaksi $result->TransNo tidak bisa edit barang, Status : {$status}"));
                return Redirect::redirect("tinoutitemdetail/{$result->Id}")->go();
            } 

            $oldmodel = clone $inoutitemdetails;
            try{
                $inoutitemdetails->validate($oldmodel);
                $inoutitemdetails->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect("tinoutitemdetail/$inoutitemdetails->T_Inoutitem_Id")->go();
            }catch (EloquentException $e){
                
                Session::setFlash('edit_warning_msg', $e->getMessages());
                return Redirect::redirect("tinoutitemdetail/edit/{$id}")->with($e->getEntity())->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('t_inoutitem','Delete')) {
            
            $model = T_inoutitemdetails::find($id);
            $result = $model->get_T_Inoutitem();
            if($result->Status == T_inoutitemsStatus::RELEASE || $result->Status == T_inoutitemsStatus::CANCEL){
                $status = M_enumdetails::findEnumName("InoutitemStatus", $result->Status);
                echo json_encode(deleteStatus(array(0=>"Transaksi $result->TransNo tidak bisa hapus barang, Status : {$status}"), FALSE));
                exit;
            } 

            $delete = $model->delete();
            if (!is_bool($delete)) {
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

    public function getAllData($idinoutitem)
    {

        if ($this->hasPermission('t_inoutitem','Read')) {

            $params = [
                'where' => [
                    'T_Inoutitem_Id' => $idinoutitem
                ]
            ];

            $datatable = new Datatables($params);
            $datatable->eloquent('App\\Eloquents\\T_inoutitemdetails');
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
                    'M_Item_Id',
                    null,
                    function ($row) {
                        return
                            formLink($row->get_M_Item()->Name, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl("tinoutitemdetail/edit/$row->Id"),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'M_Warehouse_Id',
                    null,
                    function ($row) {
                        return $row->get_M_Warehouse()->Name;
                    }
                )->addColumn(
                    'Qty',
                    null,
                    function ($row) {
                        return $row->Qty;
                    },
                    false
                )->addColumn(
                    'Recipient',
                    null,
                    function ($row) {
                        return $row->Recipient;
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

    public function getDataModal($idinoutitem)
    {
        $params = array();
        if($idinoutitem > 0)
            $params = [
                'where' => [
                    'T_Inoutitem_Id' => $idinoutitem
                ]
            ];
        $datatable = new Datatables($params);
        $datatable->eloquent('App\\Eloquents\\T_inoutitemdetails');
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
                'NIK',
                null,
                function ($row) {
                    return $row->NIK;
                }
            )->addColumn(
                'CompleteName',
                null,
                function ($row) {
                    return $row->CompleteName;
                }
            );

        echo json_encode($datatable->populate());
    }

    public function getDataById(){

        $id = $this->request->getPost("id");
        $role = $this->request->getPost("role");
        if ($this->hasPermission($role, 'Write')) {
            
            $model = T_inoutitemdetails::find($id);
            if($model){
                $data = [
                    'data' => $model
                ];

                echo json_encode($data);
            
            } else {
                echo json_encode(deleteStatus("", FALSE, TRUE));
            }
        }
    }
}
