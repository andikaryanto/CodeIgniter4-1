<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\T_disasteroccurs;
use App\Controllers\Base_Controller;
use App\Enums\T_disasteroccursStatus;
use App\Eloquents\T_disasteroccurvictims;
use App\Eloquents\M_enumdetails;
use App\Eloquents\M_familycards;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class T_disasteroccurvictim extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index($iddisasteroccur)
    {
        $res = $this->hasPermission('t_disasteroccur', 'Read');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $result = T_disasteroccurs::find($iddisasteroccur);
        $data['model'] = $result;

        $this->loadView('t_disasteroccurvictim/index', lang('Form.disasterimpact'), $data);
    
    }

    public function add($iddisasteroccur)
    {
        $res = $this->hasPermission('t_disasteroccur', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $result = T_disasteroccurs::find($iddisasteroccur);

        if($result->Status == T_disasteroccursStatus::DONE){
            $status = M_enumdetails::findEnumName("DisasterOccurStatus", $result->Status);
            Session::setFlash('edit_warning_msg', array(0 => "Transaksi $result->TransNo tidak bisa ditambah korban, Status : {$status}"));
            return Redirect::redirect("tdisasteroccurvictim/{$result->Id}")->go();
        } 
        $disasteroccurvictims = new T_disasteroccurvictims();

        $data = setPageData_paging($disasteroccurvictims);

        $data['disasteroccur'] = $result;
        $this->loadView('t_disasteroccurvictim/add', lang('Form.disasterimpact'), $data);
        
    }

    public function addsave()
    {
        $res = $this->hasPermission('t_disasteroccur', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $usefamilycard = $this->request->getPost("usefamilycard");

        $disasteroccurvictims = new T_disasteroccurvictims();
        
        $result = T_disasteroccurs::find($disasteroccurvictims->T_Disasteroccur_Id);
        if($result->Status == T_disasteroccursStatus::DONE){
            $status = M_enumdetails::findEnumName("DisasterOccurStatus", $result->Status);
            Session::setFlash('edit_warning_msg', array(0 => "Transaksi $result->TransNo tidak bisa ditambah korban, Status : {$status}"));
            return Redirect::redirect("tdisasteroccurvictim/{$result->Id}")->go();
        } 

        $disasteroccurvictims->parseFromRequest();
        try {
            if ($usefamilycard) {
                $familycard = M_familycards::find($disasteroccurvictims->M_Familycard_Id);
                if ($familycard) {
                    foreach ($familycard->get_list_M_Familycardmember() as $detail) {
                        $newdetail = new T_disasteroccurvictims();
                        $newdetail->M_Familycard_Id = $disasteroccurvictims->M_Familycard_Id;
                        $newdetail->M_Familycardmember_Id = $detail->Id;
                        $newdetail->T_Disasteroccur_Id = $disasteroccurvictims->T_Disasteroccur_Id;
                        $newdetail->Name = $detail->CompleteName;
                        $newdetail->NIK = $detail->NIK;
                        $newdetail->Gender = $detail->Gender;
                        $newdetail->BirthPlace = $detail->BirthPlace;
                        $newdetail->BirthDate = $detail->BirthDate;
                        $newdetail->Relgion = $detail->Relgion;
                        $newdetail->save();
                    }

                    Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                    return Redirect::redirect("tdisasteroccurvictim/add/{$disasteroccurvictims->T_Disasteroccur_Id}")->go();
                } else { }
            } else {
                $disasteroccurvictims->validate();

                $disasteroccurvictims->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect("tdisasteroccurvictim/add/{$disasteroccurvictims->T_Disasteroccur_Id}")->go();
            }
        } catch (EloquentException $e) {

            Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("tdisasteroccurvictim/add/{$disasteroccurvictims->T_Disasteroccur_Id}")->with($e->getEntity())->go();
        }
        
    }

    public function edit($id)
    {
        $res = $this->hasPermission('t_disasteroccur', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $disasteroccurvictims = T_disasteroccurvictims::find($id);

        $result = T_disasteroccurs::find($disasteroccurvictims->T_Disasteroccur_Id);
        if($result->Status == T_disasteroccursStatus::DONE){
            $status = M_enumdetails::findEnumName("DisasterOccurStatus", $result->Status);
            Session::setFlash('edit_warning_msg', array(0 => "Transaksi $result->TransNo tidak bisa diubah korban, Status : {$status}"));
            return Redirect::redirect("tdisasteroccurvictim/{$result->Id}")->go();
        } 
        // echo json_encode($disasteroccurvictims);

        $data['model'] = $disasteroccurvictims;
        $data['disasteroccur'] = $result;
        $this->loadView('t_disasteroccurvictim/edit', lang('Form.disasterimpact'), $data);
        
    }

    public function editsave()
    {
        $res = $this->hasPermission('t_disasteroccur', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $id = $this->request->getPost('Id');

        $disasteroccurvictims = T_disasteroccurvictims::find($id);

        $result = T_disasteroccurs::find($disasteroccurvictims->T_Disasteroccur_Id);
        if($result->Status == T_disasteroccursStatus::DONE){
            $status = M_enumdetails::findEnumName("DisasterOccurStatus", $result->Status);
            Session::setFlash('edit_warning_msg', array(0 => "Transaksi $result->TransNo tidak bisa diubah korban, Status : {$status}"));
            return Redirect::redirect("tdisasteroccurvictim/{$result->Id}")->go();
        } 
        
        $oldmodel = clone $disasteroccurvictims;

        $disasteroccurvictims->parseFromRequest();

        try {
            $disasteroccurvictims->validate($oldmodel);
            $disasteroccurvictims->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect("tdisasteroccurvictim/{$disasteroccurvictims->T_Disasteroccur_Id}")->go();
        } catch (EloquentException $e) {

            Session::setFlash('edit_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("tdisasteroccurvictim/edit/{$id}")->with($e->getEntity())->go();
        }
        
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        $res = $this->hasPermission('t_disasteroccur', 'Delete');

        if(!$res){
            echo json_encode(deleteStatus(lang("Info.no_access_delete"), FALSE, TRUE));
        } else {

            $model = T_disasteroccurvictims::find($id);
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

    public function getAllData($iddisasteroccur)
    {

        if ($this->hasPermission('t_disasteroccur', 'Read')) {

            $params = [
                'where' => [
                    'T_Disasteroccur_Id' => $iddisasteroccur
                ]
            ];
            $datatable = new Datatables($params);
            $datatable->eloquent('App\\Eloquents\\T_disasteroccurvictims');
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
                                "href" => baseUrl("tdisasteroccurvictim/edit/$row->Id"),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'NIK',
                    null,
                    function ($row) {
                        return $row->NIK;
                    }
                )->addColumn(
                    'Gender',
                    null,
                    function ($row) {
                        return M_enumdetails::findEnumName("Gender", $row->Gender);
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
        $datatable->eloquent('App\\Eloquents\\T_disasteroccurvictims');
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
