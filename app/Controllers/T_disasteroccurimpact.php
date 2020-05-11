<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\T_disasteroccurs;
use App\Controllers\Base_Controller;
use App\Libraries\Session;
use App\Eloquents\T_disasteroccurimpacts;
use App\Eloquents\M_enumdetails;
use App\Libraries\Redirect;
use AndikAryanto11\Datatables;

class T_disasteroccurimpact extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index($iddisasteroccur)
    {
        if ($this->hasPermission('t_disasteroccur', 'Read')) {
            $result = T_disasteroccurs::find($iddisasteroccur);
            $data['model'] = $result;

            $this->loadView('t_disasteroccurimpact/index', lang('Form.disasterimpact'), $data);
        }
    }

    public function add($iddisasteroccur)
    {
        if ($this->hasPermission('t_disasteroccur', 'Write')) {

            $result = T_disasteroccurs::find($iddisasteroccur);

            $disasteroccurimpacts = new T_disasteroccurimpacts();

            $data = setPageData_paging($disasteroccurimpacts);

            $data['disasteroccur'] = $result;
            $this->loadView('t_disasteroccurimpact/add', lang('Form.disasterimpact'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('t_disasteroccur', 'Write')) {


            $disasteroccurimpacts = new T_disasteroccurimpacts();
            $disasteroccurimpacts->parseFromRequest();

            try {
                $disasteroccurimpacts->validate();

                $disasteroccurimpacts->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect("tdisasteroccurimpact/add/{$disasteroccurimpacts->T_Disasteroccur_Id}")->go();
            } catch (EloquentException $e) {

                Session::setFlash('add_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("tdisasteroccurimpact/add/{$disasteroccurimpacts->T_Disasteroccur_Id}")->with($e->data)->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('t_disasteroccur', 'Write')) {


            $disasteroccurimpacts = T_disasteroccurimpacts::find($id);

            $result = T_disasteroccurs::find($disasteroccurimpacts->T_Disasteroccur_Id);

            $data['model'] = $disasteroccurimpacts;
            $data['disasteroccur'] = $result;
            $this->loadView('t_disasteroccurimpact/edit', lang('Form.disasterimpact'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('t_disasteroccur', 'Write')) {

            $id = $this->request->getPost('Id');

            $disasteroccurimpacts = T_disasteroccurimpacts::find($id);
            $oldmodel = clone $disasteroccurimpacts;

            $disasteroccurimpacts->parseFromRequest();

            try {
                $disasteroccurimpacts->validate($oldmodel);

                $disasteroccurimpacts->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect("tdisasteroccurimpact/{$disasteroccurimpacts->T_Disasteroccur_Id}")->go();
            } catch (EloquentException $e) {

                Session::setFlash('edit_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("tdisasteroccurimpact/edit/{$id}")->with($e->data)->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('t_disasteroccur', 'Delete')) {

            $model = T_disasteroccurimpacts::find($id);
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
            $datatable = new Datatables($params);
            $datatable->eloquent('App\\Eloquents\\T_disasteroccurimpacts');
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
                                "href" => baseUrl("tdisasteroccurimpact/edit/$row->Id"),
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
        $datatable->eloquent('App\\Eloquents\\T_disasteroccurimpacts');
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
