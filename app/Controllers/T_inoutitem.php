<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\T_inoutitems;
use App\Controllers\Base_Controller;
use App\Eloquents\G_transactionnumbers;
use App\Eloquents\M_forms;
use Core\Libraries\File;
use App\Eloquents\T_disasterreports;
use App\Eloquents\M_enumdetails;
use App\Eloquents\M_itemstocks;
use App\Eloquents\T_disasteroccurs;
use App\Eloquents\T_inoutitemdetails;
use App\Libraries\Redirect;
use Exception;
use App\Libraries\Session;
use AndikAryanto11\Datatables;
use App\Libraries\DbTrans;

class T_inoutitem extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        $res = $this->hasPermission('t_inoutitem', 'Read');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $this->loadView('t_inoutitem/index', lang('Form.inoutitem'));
        
    }

    public function add()
    {
        $res = $this->hasPermission('t_inoutitem', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $inoutitems = new T_inoutitems();
        $data = setPageData_paging($inoutitems);
        $this->loadView('t_inoutitem/add', lang('Form.inoutitem'), $data);
        
    }

    public function addsave()
    {
        $res = $this->hasPermission('t_inoutitem', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $inoutitems = new T_inoutitems();
        $inoutitems->parseFromRequest();

        try {

            DbTrans::beginTransaction();
            $inoutitems->validate();

            if($inoutitems->savenew()){
                DbTrans::commit();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('tinoutitem')->go();
            }
        } catch (EloquentException $e) {

            DbTrans::rollback();
            $e->getEntity()->Date = get_formated_date($e->getEntity()->Date, 'd-m-Y');
            Session::setFlash('add_success_msg', $e->getMessages());
            return Redirect::redirect("tinoutitem/add")->with($e->getEntity())->go();
        }
        
    }

    public function edit($id)
    {
        $res = $this->hasPermission('t_inoutitem', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $inoutitems = T_inoutitems::find($id);
        $inoutitems->Date = get_formated_date($inoutitems->Date, "d-m-Y");
        $data['model'] = $inoutitems;
        $this->loadView('t_inoutitem/edit', lang('Form.inoutitem'), $data);
        
    }

    public function editsave()
    {

        $res = $this->hasPermission('t_inoutitem', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $id = $this->request->getPost('Id');

        $inoutitems = T_inoutitems::find($id);
        $oldmodel = clone $inoutitems;

        $inoutitems->parseFromRequest();


        try {

            DbTrans::beginTransaction();
            $inoutitems->validate($oldmodel);

            if($inoutitems->saveedit($oldmodel)){
                DbTrans::commit();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('tinoutitem')->go();
            }

        } catch (EloquentException $e) {
            DbTrans::rollback();
            $e->getEntity()->Date = get_formated_date($e->getEntity()->Date, 'd-m-Y');
            Session::setFlash('edit_warning_msg', $e->getMessages());
            return Redirect::redirect("tinoutitem/edit/{$id}")->with($e->getEntity())->go();
        }
        
    }

    public function copy($id)
    {

        $res = $this->hasPermission('t_inoutitem', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $copied = T_inoutitems::find($id);
        $newdata = T_inoutitems::copy($copied);
        Session::setFlash('success_msg', array(0 => "Data Baru Terbuat Dengan Nomor : {$newdata->TransNo}"));
        return Redirect::redirect("tinoutitem/edit/{$newdata->Id}")->go();
        
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        $res = $this->hasPermission('t_inoutitem', 'Delete');

        if(!$res){
            echo json_encode(deleteStatus(lang("Info.no_access_delete"), FALSE, TRUE));
        } else {

            $model = T_inoutitems::find($id);

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

        if ($this->hasPermission('t_inoutitem', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\T_inoutitems');
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
                    'TransNo',
                    null,
                    function ($row) {
                        return
                            formLink($row->TransNo, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl('tinoutitem/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }

                )->addColumn(
                    'Status',
                    null,
                    function ($row) {
                        return M_enumdetails::findEnumName("InoutitemStatus", $row->Status);
                    }
                )->addColumn(
                    'Date',
                    null,
                    function ($row) {
                        return get_formated_date($row->Date, "d-m-Y");
                    }
                )->addColumn(
                    'TransType',
                    null,
                    function ($row) {
                        return M_enumdetails::findEnumName("InOutItemType", $row->TransType);
                    },
                    false
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

                            formLink("<i class='fa fa-object-group'></i>", array(
                                "href" => baseUrl("tinoutitemdetail/{$row->Id}"),
                                "class" => "btn-just-icon link-action item",
                                "rel" => "tooltip",
                                "title" => lang('Form.item')
                            )) .
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
        $datatable->eloquent('App\\Eloquents\\T_inoutitems');
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

    public function getDataById()
    {
        if ($this->hasPermission('t_inoutitem', 'Read')) {

            $id = $this->request->getPost("id");
            $model = T_inoutitems::find($id);
            $model->Disaster = $model->get_M_Disaster();
            $datas['model'] = $model;
            echo json_encode($datas);
        }
    }
}
