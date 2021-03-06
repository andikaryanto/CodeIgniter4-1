<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_impactcategories;
use App\Controllers\Base_Controller;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class M_impactcategory extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        $res = $this->hasPermission('m_impact', 'Read');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $this->loadView('m_impactcategory/index', lang('Form.impactcategory'));
        
    }

    public function add()
    {
        $res = $this->hasPermission('m_impact', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $impactcategories = new M_impactcategories();
        $data = setPageData_paging($impactcategories);
        $this->loadView('m_impactcategory/add', lang('Form.impactcategory'), $data);
        
    }

    public function addsave()
    {

        $res = $this->hasPermission('m_impact', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $impactcategories = new M_impactcategories();
        $impactcategories->parseFromRequest();

        try {
            $impactcategories->validate();

            $impactcategories->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect('mimpactcategory/add')->go();
        } catch (EloquentException $e) {

            Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("mimpactcategory/add")->with($impactcategories)->go();
        }
        
    }

    public function edit($id)
    {
        $res = $this->hasPermission('m_impact', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $impactcategories = M_impactcategories::find($id);

        $data['model'] = $impactcategories;
        $this->loadView('m_impactcategory/edit', lang('Form.impactcategory'), $data);
    
    }

    public function editsave()
    {
        $res = $this->hasPermission('m_impact', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $id = $this->request->getPost('Id');

        $impactcategories = M_impactcategories::find($id);
        $oldmodel = clone $impactcategories;

        $impactcategories->parseFromRequest();

        try {
            $impactcategories->validate($oldmodel);

            $impactcategories->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect('mimpactcategory')->go();
        } catch (EloquentException $e) {

            Session::setFlash('edit_warning_msg', array(0 => $e->message));
            return Redirect::redirect("mimpactcategoryedit/edit/{$id}")->with($impactcategories)->go();
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        $res = $this->hasPermission('m_impact', 'Delete');

        if(!$res){
            echo json_encode(deleteStatus(lang("Info.no_access_delete"), FALSE, TRUE));
        } else {
            $model = M_impactcategories::find($id);

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

        if ($this->hasPermission('m_impact', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_impactcategories');
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
                                "href" => baseUrl('mimpactcategory/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
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
        $datatable->eloquent('App\\Eloquents\\M_impactcategories');
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
