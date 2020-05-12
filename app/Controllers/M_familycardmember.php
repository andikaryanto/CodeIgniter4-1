<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_familycardmembers;
use App\Controllers\Base_Controller;
use App\Libraries\Redirect;
use App\Libraries\Session;
use App\Eloquents\M_familycards;
use App\Eloquents\M_enumdetails;
use AndikAryanto11\Datatables;

class M_familycardmember extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index($idfamilycard)
    {
        if ($this->hasPermission('m_familycard', 'Read')) {

            $result = M_familycards::find($idfamilycard);
            $data['model'] = $result;

            $this->loadView('m_familycardmember/index', lang('Form.familycardmember'), $data);
        }
    }

    public function add($idfamilycard)
    {
        if ($this->hasPermission('m_familycard', 'Write')) {

            $result = M_familycards::find($idfamilycard);

            $familycardmembers = new M_familycardmembers();

            $data = setPageData_paging($familycardmembers);

            $data['familycard'] = $result;
            $this->loadView('m_familycardmember/add', lang('Form.familycardmember'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_familycard', 'Write')) {


            $familycardmembers = new M_familycardmembers();
            $familycardmembers->parseFromRequest();

            try {
                $familycardmembers->validate();

                $familycardmembers->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect("mfamilycardmember/add/{$familycardmembers->M_Familycard_Id}")->go();
            } catch (EloquentException $e) {

                Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
                return Redirect::redirect("mfamilycardmember/add/{$familycardmembers->M_Familycard_Id}")->with($familycardmembers)->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('m_familycard', 'Write')) {


            $familycardmembers = M_familycardmembers::find($id);

            $familycards = new M_familycards();
            $result = M_familycards::find($familycardmembers->M_Familycard_Id);

            $data['model'] = $familycardmembers;
            $data['familycard'] = $result;
            $this->loadView('m_familycardmember/edit', lang('Form.familycardmember'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('m_familycard', 'Write')) {

            $id = $this->request->getPost('Id');

            $familycardmembers = M_familycardmembers::find($id);
            $oldmodel = clone $familycardmembers;

            $familycardmembers->parseFromRequest();

            try {
                $familycardmembers->validate($oldmodel);
                $familycardmembers->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect("mfamilycardmember/$familycardmembers->M_Familycard_Id")->go();
            } catch (EloquentException $e) {

                Session::setFlash('edit_warning_msg', array(0 => $e->getMessages()));
                return Redirect::redirect("mfamilycardmember/edit/$id")->with($e->getEntity())->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('m_familycard', 'Delete')) {

            $model = M_familycardmembers::find($id);
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
            $datatable = new Datatables('M_familycardmembers', $params);
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
                    'CompleteName',
                    null,
                    function ($row) {
                        return
                            formLink($row->CompleteName, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl("mfamilycardmember/edit/$row->Id"),
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
                    },
                    false
                )->addColumn(
                    'Relation',
                    null,
                    function ($row) {
                        return M_enumdetails::findEnumName("FamilyRelation", $row->Relation);
                    },
                    false
                )->addColumn(
                    'BirthPlace',
                    null,
                    function ($row) {
                        return $row->BirthPlace;
                    },
                    false
                )->addColumn(
                    'BirthDate',
                    null,
                    function ($row) {
                        return $row->BirthDate;
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
        $datatable->eloquent('App\\Eloquents\\M_familycardmembers');
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
                'M_Familycard_Id',
                null,
                function ($row) {
                    return $row->get_M_Familycard()->getHeadFamily();
                }
            )->addColumn(
                'CompleteName',
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

            $model = M_familycardmembers::find($id);
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
