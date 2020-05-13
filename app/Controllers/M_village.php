<?php

namespace App\Controllers;

use AndikAryanto11\Datatables;
use App\Classes\Exception\EloquentException;
use App\Eloquents\M_villages;
use App\Eloquents\M_accessroles;
use App\Controllers\Base_Controller;
use App\Libraries\Redirect;
use App\Libraries\Session;

class M_village extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        $res = $this->hasPermission('m_village', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $this->loadView('m_village/index', lang('Form.village'));
        
    }

    public function add()
    {
        $res = $this->hasPermission('m_village', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $villages = new M_villages();
        $data = setPageData_paging($villages);
        $this->loadView('m_village/add', lang('Form.village'), $data);
        
    }

    public function addsave()
    {

        $res = $this->hasPermission('m_village', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $villages = new M_villages();
        $villages->parseFromRequest();

        try {
            $villages->validate();
            $villages->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect('mvillage/add')->with($villages)->go();
        } catch (EloquentException $e) {

            Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("mvillage/add")->with($e->getEntity())->go();
        
        }
    }

    public function edit($id)
    {
        $res = $this->hasPermission('m_village', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $villages = M_villages::find($id);
        $data['model'] = $villages;
        $this->loadView('m_village/edit', lang('Form.village'), $data);
        
    }

    public function editsave()
    {

        $res = $this->hasPermission('m_village', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $id = $this->request->getPost('Id');


        $villages = M_villages::find($id);
        $oldmodel = clone $villages;

        $villages->parseFromRequest();

        try {
            $villages->validate($oldmodel);
            $villages->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect('mvillage')->go();
        } catch (EloquentException $e) {

            Session::setFlash('edit_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("mvillage/edit/{$id}")->with($e->getEntity())->go();
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        $res = $this->hasPermission('m_village', 'Delete');

        if(!$res){
            echo json_encode(deleteStatus(lang("Info.no_access_delete"), FALSE, TRUE));
        } else {

            $model = M_villages::find($id);
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

    public function getAllData()
    {

        if ($this->hasPermission('m_village', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_villages');
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
                                "href" => baseUrl('mvillage/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    '',
                    null,
                    function ($row) {
                        return $row->get_M_Subdistrict()->Name;
                    },
                    false,
                    false
                )->addColumn(
                    '',
                    null,
                    function ($row) {
                        return $row->get_M_Subdistrict()->get_M_District()->Name;
                    },
                    false,
                    false
                )->addColumn(
                    '',
                    null,
                    function ($row) {
                        return $row->get_M_Subdistrict()->get_M_District()->get_M_Province()->Name;
                    },
                    false,
                    false
                )->addColumn(
                    'Description',
                    null,
                    function ($row) {
                        return $row->Description;
                    }
                )->addColumn(
                    'Created',
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
        $datatable->eloquent('App\\Eloquents\\M_villages');
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
            )->addColumn(
                '',
                null,
                function ($row) {
                    return $row->get_M_Subdistrict()->Name;
                },
                false,
                false
            )->addColumn(
                '',
                null,
                function ($row) {
                    return $row->get_M_Subdistrict()->get_M_District()->Name;
                },
                false,
                false
            )->addColumn(
                '',
                null,
                function ($row) {
                    return $row->get_M_Subdistrict()->get_M_District()->get_M_Province()->Name;
                },
                false,
                false
            );

        echo json_encode($datatable->populate());
    }
}
