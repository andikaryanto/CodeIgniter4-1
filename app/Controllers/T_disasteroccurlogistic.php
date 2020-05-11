<?php

namespace App\Controllers;

use AndikAryanto11\Datatables;
use App\Classes\Exception\EloquentException;
use App\Eloquents\T_disasteroccurs;
use App\Controllers\Base_Controller;
use App\Eloquents\T_disasteroccurlogistics;
use App\Eloquents\M_enumdetails;
use App\Eloquents\M_familycards;
use App\Libraries\Redirect;
use App\Libraries\Session;

class T_disasteroccurlogistic extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index($iddisasteroccur)
    {
        if ($this->hasPermission('t_disasteroccur', 'Read')) {
            $result = T_disasteroccurs::find($iddisasteroccur);
            $data['model'] = $result;

            $this->loadView('t_disasteroccurlogistic/index', lang('Form.disasterlogistic'), $data);
        }
    }

    public function add($iddisasteroccur)
    {
        if ($this->hasPermission('t_disasteroccur', 'Write')) {

            $result = T_disasteroccurs::find($iddisasteroccur);

            $disasteroccurlogistics = new T_disasteroccurlogistics();

            $data = setPageData_paging($disasteroccurlogistics);

            $data['disasteroccur'] = $result;
            $this->loadView('t_disasteroccurlogistic/add', lang('Form.disasterlogistic'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('t_disasteroccur', 'Write')) {

            $disasteroccurlogistics = new T_disasteroccurlogistics();
            $disasteroccurlogistics->parseFromRequest();

            $result = T_disasteroccurs::find($disasteroccurlogistics->T_Disasteroccur_Id);

            try {
                $disasteroccurlogistics->validate();

                $disasteroccurlogistics->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect("tdisasteroccurlogistic/add/{$disasteroccurlogistics->T_Disasteroccur_Id}")->go();
            } catch (EloquentException $e) {

                Session::setFlash('add_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("tdisasteroccurlogistic/add/{$disasteroccurlogistics->T_Disasteroccur_Id}")->with($e->data)->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('t_disasteroccur', 'Write')) {


            $disasteroccurlogistics = T_disasteroccurlogistics::find($id);

            $result = T_disasteroccurs::find($disasteroccurlogistics->T_Disasteroccur_Id);
            // echo json_encode($disasteroccurlogistics);

            $data['model'] = $disasteroccurlogistics;
            $data['disasteroccur'] = $result;
            $this->loadView('t_disasteroccurlogistic/edit', lang('Form.disasterlogistic'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('t_disasteroccur', 'Write')) {

            $id = $this->request->getPost('Id');

            $disasteroccurlogistics = T_disasteroccurlogistics::find($id);
            $oldmodel = clone $disasteroccurlogistics;

            $disasteroccurlogistics->parseFromRequest();

            try {
                $disasteroccurlogistics->validate($oldmodel);

                $disasteroccurlogistics->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect("tdisasteroccurlogistic/{$disasteroccurlogistics->T_Disasteroccur_Id}")->go();
            } catch (EloquentException $e) {

                Session::setFlash('edit_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("tdisasteroccurlogistic/edit/{$id}")->with($e->data)->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('t_disasteroccur', 'Delete')) {

            $model = T_disasteroccurlogistics::find($id);
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
            $datatable->eloquent('App\\Eloquents\\T_disasteroccurlogistics');
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
                                "href" => baseUrl("tdisasteroccurlogistic/edit/$row->Id"),
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
                    }
                )->addColumn(
                    'UoM',
                    null,
                    function ($row) {
                        return $row->get_M_Item()->get_M_Uom()->Name;
                    },
                    false,
                    false
                )->addColumn(
                    'Recipient',
                    null,
                    function ($row) {
                        return $row->Recipient;
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
        $datatable->eloquent('App\\Eloquents\\T_disasteroccurlogistics');
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
