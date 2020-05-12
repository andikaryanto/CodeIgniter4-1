<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\T_disasteroccurs;
use App\Controllers\Base_Controller;
use App\Enums\T_disasteroccursStatus;
use App\Libraries\ResponseCode;
use App\Eloquents\T_disasteroccurbuildings;
use App\Eloquents\M_enumdetails;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class T_disasteroccurbuilding extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index($iddisasteroccur)
    {
        if ($this->hasPermission('t_disasteroccur', 'Read')) {
            $result = T_disasteroccurs::find($iddisasteroccur);
            $data['model'] = $result;

            $this->loadView('t_disasteroccurbuilding/index', lang('Form.disasterbuilding'), $data);
        }
    }

    public function add($iddisasteroccur)
    {
        if ($this->hasPermission('t_disasteroccur', 'Write')) {

            $result = T_disasteroccurs::find($iddisasteroccur);
            // if($result->Status == T_disasteroccursStatus::DONE){
            //     $status = M_enumdetails::findEnumName("DisasterOccurStatus", $result->Status);
            //     Session::setFlash('edit_warning_msg', array(0 => "Dampak bangunan Transaksi $result->TransNo tidak bisa diubah, Status : {$status}"));
            //     return Redirect::redirect("tdisasteroccurbuilding/{$result->Id}")->go();
            // }

            $disasteroccurbuildings = new T_disasteroccurbuildings();

            $data = setPageData_paging($disasteroccurbuildings);

            $data['disasteroccur'] = $result;
            $this->loadView('t_disasteroccurbuilding/add', lang('Form.disasterbuilding'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('t_disasteroccur', 'Write')) {


            $disasteroccurbuildings = new T_disasteroccurbuildings();
            $disasteroccurbuildings->parseFromRequest();
            
            
            try {
                $disasteroccurbuildings->validate();

                $result = T_disasteroccurs::find($disasteroccurbuildings->T_Disasteroccur_Id);
                if($result->Status == T_disasteroccursStatus::DONE){
                    $status = M_enumdetails::findEnumName("DisasterOccurStatus", $result->Status);
                    throw new EloquentException("Dampak bangunan Transaksi $result->TransNo tidak bisa ditambah, Status : {$status}", $disasteroccurbuildings, ResponseCode::INVALID_DATA);
                    // echo json_encode($disasteroccurbuildings->get_M_Familycard()->FamilyCardNo);
                    // exit;
                }

                $disasteroccurbuildings->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect("tdisasteroccurbuilding/add/{$disasteroccurbuildings->T_Disasteroccur_Id}")->go();
            } catch (EloquentException $e) {

                Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
                return Redirect::redirect("tdisasteroccurbuilding/add/{$disasteroccurbuildings->T_Disasteroccur_Id}")->with($e->getEntity())->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('t_disasteroccur', 'Write')) {


            // $disasteroccurbuildings = T_disasteroccurs::find($id);
            $disasteroccurbuildings = T_disasteroccurbuildings::find($id);
            $result = T_disasteroccurs::find($disasteroccurbuildings->T_Disasteroccur_Id);
            if($result->Status == T_disasteroccursStatus::DONE){
                $status = M_enumdetails::findEnumName("DisasterOccurStatus", $result->Status);
                Session::setFlash('edit_warning_msg', array(0 => "Transaksi $result->TransNo tidak bisa diubah korban, Status : {$status}"));
                return Redirect::redirect("tdisasteroccurbuilding/{$result->Id}")->go();
            } 


            $data['model'] = $disasteroccurbuildings;
            $data['disasteroccur'] = $result;
            $this->loadView('t_disasteroccurbuilding/edit', lang('Form.disasterbuilding'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('t_disasteroccur', 'Write')) {

            $id = $this->request->getPost('Id');

            $disasteroccurbuildings = T_disasteroccurbuildings::find($id);
            $result = T_disasteroccurs::find($disasteroccurbuildings->T_Disasteroccur_Id);
            if($result->Status == T_disasteroccursStatus::DONE){
                $status = M_enumdetails::findEnumName("DisasterOccurStatus", $result->Status);
                Session::setFlash('edit_warning_msg', array(0 => "Transaksi $result->TransNo tidak bisa diubah korban, Status : {$status}"));
                return Redirect::redirect("tdisasteroccurbuilding/{$result->Id}")->go();
            }

            $oldmodel = clone $disasteroccurbuildings;

            $disasteroccurbuildings->parseFromRequest();

            try {
                $disasteroccurbuildings->validate($oldmodel);

                $disasteroccurbuildings->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect("tdisasteroccurbuilding/{$disasteroccurbuildings->T_Disasteroccur_Id}")->go();
            } catch (EloquentException $e) {

                Session::setFlash('edit_warning_msg', array(0 => $e->getMessages()));
                return Redirect::redirect("tdisasteroccurbuilding/edit/{$id}")->with($e->getEntity())->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('t_disasteroccur', 'Delete')) {

            $model = T_disasteroccurbuildings::find($id);
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

    public function getAllData($iddisasteroccur)
    {

        if ($this->hasPermission('t_disasteroccur', 'Read')) {

            $params = [
                'where' => [
                    'T_Disasteroccur_Id' => $iddisasteroccur
                ]
            ];
            $datatable = new Datatables('T_disasteroccurbuildings', $params);
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
                    'DamageDescription',
                    null,
                    function ($row) {
                        return
                            formLink($row->DamageDescription, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl("tdisasteroccurbuilding/edit/$row->Id"),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'M_Familycard_Id',
                    null,
                    function ($row) {
                        $famcard = $row->get_M_Familycard();
                        return $famcard->FamilyCardNo . "~" . $famcard->getHeadFamily();
                    }
                )->addColumn(
                    'Damage',
                    null,
                    function ($row) {
                        return $row->Damage;
                    }
                )->addColumn(
                    'Created',
                    null,
                    function ($row) {
                        return $row->Created;
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
        $datatable->eloquent('App\\Eloquents\\T_disasteroccurbuildings');
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
