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
        if ($this->hasPermission('t_disasterassessment', 'Read')) {
            $result = T_disasterassessments::find($iddisasterassessment);
            $data['model'] = $result;

            $this->loadView('t_disasterassessmentimpact/index', lang('Form.disasterimpact'), $data);
        }
    }

    public function add($iddisasterassessment)
    {
        if ($this->hasPermission('t_disasterassessment', 'Write')) {

            $result = T_disasterassessments::find($iddisasterassessment);

            $disasterassessmentimpacts = new T_disasterassessmentimpacts();

            $data = setPageData_paging($disasterassessmentimpacts);

            $data['disasterassessment'] = $result;
            $this->loadView('t_disasterassessmentimpact/add', lang('Form.disasterimpact'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('t_disasterassessment', 'Write')) {


            $disasterassessmentimpacts = new T_disasterassessmentimpacts();
            $disasterassessmentimpacts->parseFromRequest();

            try {
                $disasterassessmentimpacts->validate();

                $disasterassessmentimpacts->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect("tdisasterassessmentimpact/add/{$disasterassessmentimpacts->T_Disasterassessment_Id}")->go();
            } catch (EloquentException $e) {

                Session::setFlash('add_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("tdisasterassessmentimpact/add/{$disasterassessmentimpacts->T_Disasterassessment_Id}")->with($e->data)->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('t_disasterassessment', 'Write')) {



            $disasterassessmentimpacts = T_disasterassessmentimpacts::find($id);

            $result = T_disasterassessments::find($disasterassessmentimpacts->T_Disasterassessment_Id);

            $data['model'] = $disasterassessmentimpacts;
            $data['disasterassessment'] = $result;
            $this->loadView('t_disasterassessmentimpact/edit', lang('Form.disasterimpact'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('t_disasterassessment', 'Write')) {

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

                Session::setFlash('edit_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("tdisasterassessmentimpact/edit/{$id}")->with($e->data)->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('t_disasterassessment', 'Delete')) {

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
        } else {
            echo json_encode(deleteStatus("", FALSE, TRUE));
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
