<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_familycardlivestocks;
use App\Controllers\Base_Controller;
use App\Eloquents\M_familycards;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class M_familycardlivestock extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index($idfamilycard)
    {
        if ($this->hasPermission('m_familycard', 'Read')) {

            $result = M_familycards::find($idfamilycard);
            $data['model'] = $result;

            $this->loadView('m_familycardlivestock/index', lang('Form.familycardlivestock'), $data);
        }
    }

    public function add($idfamilycard)
    {
        if ($this->hasPermission('m_familycard', 'Write')) {

            $result = M_familycards::find($idfamilycard);

            $familycardlivestocks = new M_familycardlivestocks();

            $data = setPageData_paging($familycardlivestocks);

            $data['familycard'] = $result;
            $this->loadView('m_familycardlivestock/add', lang('Form.familycardlivestock'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_familycard', 'Write')) {


            $familycardlivestocks = new M_familycardlivestocks();
            $familycardlivestocks->parseFromRequest();

            try {
                $familycardlivestocks->validate();

                $familycardlivestocks->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect("mfamilycardlivestock/add/{$familycardlivestocks->M_Familycard_Id}")->go();
            } catch (EloquentException $e) {

                Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
                return Redirect::redirect("mfamilycardlivestock/add/{$familycardlivestocks->M_Familycard_Id}")->with($familycardlivestocks)->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('m_familycard', 'Write')) {


            $familycardlivestocks = M_familycardlivestocks::find($id);

            $result = M_familycards::find($familycardlivestocks->M_Familycard_Id);

            $data['model'] = $familycardlivestocks;
            $data['familycard'] = $result;
            $this->loadView('m_familycardlivestock/edit', lang('Form.familycardlivestock'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('m_familycard', 'Write')) {

            $id = $this->request->getPost('Id');

            $familycardlivestocks = M_familycardlivestocks::find($id);
            $oldmodel = clone $familycardlivestocks;

            $familycardlivestocks->parseFromRequest();
            try {
                $familycardlivestocks->validate($oldmodel);
                $familycardlivestocks->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect("mfamilycardlivestock/$familycardlivestocks->M_Familycard_Id")->go();
            } catch (EloquentException $e) {

                Session::setFlash('edit_warning_msg', array(0 => $e->getMessages()));
                return Redirect::redirect("mfamilycardlivestock/edit/$id")->with($familycardlivestocks)->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('m_familycard', 'Delete')) {

            $model = M_familycardlivestocks::find($id);
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

    public function getAllData($idfamilycard)
    {

        if ($this->hasPermission('m_familycard', 'Read')) {

            $params = [
                'where' => [
                    'M_Familycard_Id' => $idfamilycard
                ]
            ];
            $datatable = new Datatables($params);
            $datatable->eloquent('App\\Eloquents\\M_familycardlivestocks');
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
                    'M_Livestock_Id',
                    null,
                    function ($row) {
                        return
                            formLink($row->get_M_Livestock()->Name, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl("mfamilycardlivestock/edit/$row->Id"),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'Qty',
                    null,
                    function ($row) {
                        return $row->Qty;
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

    public function getDataModal($idfamilycard)
    {
        $params = array();
        if ($idfamilycard > 0)
            $params = [
                'where' => [
                    'M_Familycard_Id' => $idfamilycard
                ]
            ];
        $datatable = new Datatables($params);
        $datatable->eloquent('App\\Eloquents\\M_familycardlivestocks');
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

    public function getDataById()
    {

        $id = $this->request->getPost("id");
        $role = $this->request->getPost("role");
        if ($this->hasPermission($role, 'Write')) {

            $model = M_familycardlivestocks::find($id);
            if ($model) {
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
