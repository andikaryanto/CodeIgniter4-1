<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\T_disasterassessments;
use App\Controllers\Base_Controller;
use App\Libraries\Session;
use App\Eloquents\T_disasterassessmentimpacts;
use App\Eloquents\M_enumdetails;
use App\Libraries\Redirect;
use AndikAryanto11\Datatables;

class T_disasterassessmentimpact extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index($iddisasterassessment)
    {
        
        $res = $this->hasPermission('t_disasterassessment', 'Read');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        
        $result = T_disasterassessments::find($iddisasterassessment);
        $data['model'] = $result;

        $this->loadView('t_disasterassessmentimpact/index', lang('Form.disasterimpact'), $data);
        
    }

    public function add($iddisasterassessment)
    {
        $res = $this->hasPermission('t_disasterassessment', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $result = T_disasterassessments::find($iddisasterassessment);

        $disasterassessmentimpacts = new T_disasterassessmentimpacts();

        $data = setPageData_paging($disasterassessmentimpacts);

        $data['disasterassessment'] = $result;
        $this->loadView('t_disasterassessmentimpact/add', lang('Form.disasterimpact'), $data);
        
    }

    public function addsave()
    {
        $res = $this->hasPermission('t_disasterassessment', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $disasterassessmentimpacts = new T_disasterassessmentimpacts();
        $disasterassessmentimpacts->parseFromRequest();

        try {
            $disasterassessmentimpacts->validate();

            $disasterassessmentimpacts->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect("tdisasterassessmentimpact/add/{$disasterassessmentimpacts->T_Disasterassessment_Id}")->go();
        } catch (EloquentException $e) {

            Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("tdisasterassessmentimpact/add/{$disasterassessmentimpacts->T_Disasterassessment_Id}")->with($e->getEntity())->go();
        }
        
    }

    public function edit($id)
    {
        $res = $this->hasPermission('t_disasterassessment', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $disasterassessmentimpacts = T_disasterassessmentimpacts::find($id);

        $result = T_disasterassessments::find($disasterassessmentimpacts->T_Disasterassessment_Id);

        $data['model'] = $disasterassessmentimpacts;
        $data['disasterassessment'] = $result;
        $this->loadView('t_disasterassessmentimpact/edit', lang('Form.disasterimpact'), $data);
    
    }

    public function editsave()
    {
        $res = $this->hasPermission('t_disasterassessment', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $id = $this->request->getPost('Id');

        $disasterassessmentimpacts = T_disasterassessmentimpacts::find($id);
        $oldmodel = clone $disasterassessmentimpacts;

        $disasterassessmentimpacts->parseFromRequest();

        try {
            $disasterassessmentimpacts->validate($oldmodel);

            $disasterassessmentimpacts->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect("tdisasterassessmentimpact/{$disasterassessmentimpacts->T_Disasterassessment_Id}")->go();
        } catch (EloquentException $e) {

            Session::setFlash('edit_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("tdisasterassessmentimpact/edit/{$id}")->with($e->getEntity())->go();
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        $res = $this->hasPermission('t_disasterassessment', 'Delete');

        if(!$res){
            echo json_encode(deleteStatus(lang("Info.no_access_delete"), FALSE, TRUE));
        } else {

            $model = T_disasterassessmentimpacts::find($id);
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

    public function getAllData($iddisasterassessment)
    {

        if ($this->hasPermission('t_disasterassessment', 'Read')) {

            $params = [
                'where' => [
                    'T_Disasterassessment_Id' => $iddisasterassessment
                ]
            ];
            $datatable = new Datatables($params);
            $datatable->eloquent('App\\Eloquents\\T_disasterassessmentimpacts');
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
                    'M_Impact_Id',
                    null,
                    function ($row) {
                        return
                            formLink($row->get_M_Impact()->Name, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl("tdisasterassessmentimpact/edit/$row->Id"),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'Quantity',
                    null,
                    function ($row) {
                        return $row->Quantity;
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
        $datatable->eloquent('App\\Eloquents\\T_disasterassessmentimpacts');
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
