<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_familycards;
use App\Controllers\Base_Controller;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class M_familycard extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        if ($this->hasPermission('m_familycard', 'Read')) {

            $this->loadView('m_familycard/index', lang('Form.familycard'));
        }
    }

    public function add()
    {
        if ($this->hasPermission('m_familycard', 'Write')) {
            $familycards = new M_familycards();
            $data = setPageData_paging($familycards);
            $this->loadView('m_familycard/add', lang('Form.familycard'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_familycard', 'Write')) {

            $familycards = new M_familycards();
            $familycards->parseFromRequest();

            try {
                $familycards->validate();

                $familycards->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('mfamilycard/add')->go();
            } catch (EloquentException $e) {

                Session::setFlash('add_warning_msg', array(0 => $e->messages));
                return Redirect::redirect('mfamilycard/add')->with($familycards)->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('m_familycard', 'Write')) {

            $familycards = M_familycards::find($id);

            $data['model'] = $familycards;
            $this->loadView('m_familycard/edit', lang('Form.familycard'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('m_familycard', 'Write')) {
            $id = $this->request->getPost('Id');

            $familycards = M_familycards::find($id);
            $oldmodel = clone $familycards;

            $familycards->parseFromRequest();

            try {
                $familycards->validate($oldmodel);
                $familycards->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('mfamilycard')->go();
            } catch (EloquentException $e) {

                Session::setFlash('edit_warning_msg', array(0 => $e->messages));
                return Redirect::redirect('mfamilycard')->with($familycards)->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('m_familycard', 'Delete')) {

            $model = M_familycards::find($id);
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

    public function getAllData()
    {

        if ($this->hasPermission('m_familycard', 'Read')) {

            $params = [
                'join' => [
                    'm_subvillages' => [
                        [
                            'key' => 'm_familycards.M_Subvillage_Id = m_subvillages.Id',
                            'type' => 'left',
                        ]
                    ]
                ]
            ];
            $datatable = new Datatables($params);
            $datatable->eloquent('App\\Eloquents\\M_familycards');
            $datatable
                ->addDtRowClass("rowdetail")
                ->addColumn(
                    'm_familycards.Id',
                    null,
                    function ($row) {
                        return $row->Id;
                    },
                    false,
                    false
                )->addColumn(
                    'm_familycards.FamilyCardNo',
                    null,
                    function ($row) {
                        return
                            formLink($row->FamilyCardNo, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl('mfamilycard/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    '',
                    null,
                    function ($row) {
                        return $row->getHeadFamily();
                    },
                    false,
                    false
                )->addColumn(
                    'm_subvillages.Name',
                    null,
                    function ($row) {
                        return $row->get_M_Subvillage()->Name;
                    }
                )->addColumn(
                    'm_familycards.RT',
                    null,
                    function ($row) {
                        return $row->RT;
                    }
                )->addColumn(
                    'm_familycards.RW',
                    null,
                    function ($row) {
                        return $row->RW;
                    }
                )->addColumn(
                    'm_familycards.Created',
                    null,
                    function ($row) {
                        return $row->Created;
                    },
                    false
                )->addColumn(
                    'Action',
                    null,
                    function ($row) {
                        return
                            formLink("<i class='fa fa-user-plus'></i>", array(
                                "href" => "#",
                                "class" => "btn-just-icon link-action member",
                                "rel" => "tooltip",
                                "title" => lang('Form.member')
                            )) .
                            // formLink("<i class='fa fa-paw'></i>", array(
                            //     "href" => baseUrl("mfamilycardlivestock/{$row->Id}"),
                            //     "class" => "btn-just-icon link-action livestock",
                            //     "rel" => "tooltip",
                            //     "title" => lang('Form.livestock')
                            // )) .
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
        } else {

            return Redirect::redirect("Forbidden");
        }
    }
    public function getDataModal($idfamilycard)
    {
        // echo $idfamilycard;
        $familyid = $idfamilycard;
        if ($idfamilycard != '0') {
            $familyid = explode(",", $idfamilycard);
        }

        $params = [
            'whereIn' => [
                'Id' => $familyid
            ]
        ];
        // echo  json_encode($params);
        $datatable = new Datatables($params);
        $datatable->eloquent('App\\Eloquents\\M_familycards');
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
                'FamilyCardNo',
                null,
                function ($row) {
                    return $row->FamilyCardNo;
                }
            )->addColumn(
                '',
                null,
                function ($row) {

                    return $row->getHeadFamily();
                }
            );

        echo json_encode($datatable->populate());
    }
}
