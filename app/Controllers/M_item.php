<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_items;
use App\Controllers\Base_Controller;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class M_item extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        $res = $this->hasPermission('m_item', 'Read');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $this->loadView('m_item/index', lang('Form.item'));
        
    }

    public function add()
    {
        $res = $this->hasPermission('m_item', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $items = new M_items();
        $data = setPageData_paging($items);
        $this->loadView('m_item/add', lang('Form.item'), $data);
        
    }

    public function addsave()
    {

        $res = $this->hasPermission('m_item', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $items = new M_items();
        $items->parseFromRequest();

        try {
            $items->validate();
            $items->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect('mitem/add')->go();
        } catch (EloquentException $e) {

            Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect('mitem/add')->with($e->getEntity())->go();
        
        }
    }

    public function edit($id)
    {
        $res = $this->hasPermission('m_item', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $items = M_items::find($id);
        $data['model'] = $items;
        $this->loadView('m_item/edit', lang('Form.item'), $data);
        
    }

    public function editsave()
    {

        $res = $this->hasPermission('m_item', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $id = $this->request->getPost('Id');

        $items = M_items::find($id);
        $oldmodel = clone $items;

        $items->parseFromRequest();
        // echo json_encode($items);

        try {
            $items->validate($oldmodel);
            $items->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect('mitem')->go();
        } catch (EloquentException $e) {

            Session::setFlash('edit_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("mitem/edit/{$id}")->with($e->getEntity())->go();
        }
    
    }

    public function itemstock($itemid)
    {

        $res = $this->hasPermission('m_item', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $items = M_items::find($itemid);
        $data['model'] = $items;
        $this->loadView('m_item/stock', lang('Form.item'), $data);
        
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        $res = $this->hasPermission('m_item', 'Delete');

        if(!$res){
            echo json_encode(deleteStatus(lang("Info.no_access_delete"), FALSE, TRUE));
        } else {
            $model = M_items::find($id);
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

        if ($this->hasPermission('m_item', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_items');
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
                                "href" => baseUrl('mitem/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    '',
                    null,
                    function ($row) {
                        return $row->get_M_Uom()->Name;
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
                            formLink("<i class='fa fa-object-group'></i>", array(
                                "href" => baseUrl("mitem/itemstock/{$row->Id}"),
                                "class" => "btn-just-icon link-action",
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

    public function getStock($itemid)
    {

        if ($this->hasPermission('m_item', 'Read')) {
            $params = [
                'where' => [
                    'M_Item_Id' => $itemid
                ]
            ];

            $datatable = new Datatables($params);
            $datatable->eloquent('App\\Eloquents\\M_itemstocks');
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
                    'M_Warehouse_Id',
                    null,
                    function ($row) {
                        return $row->get_M_Warehouse()->Name;
                    },
                    false
                )->addColumn(
                    'Qty',
                    null,
                    function ($row) {
                        return $row->Qty;
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
        $datatable->eloquent('App\\Eloquents\\M_items');
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
                function ($row) {
                    return $row->get_M_Uom()->Name;
                },
                false,
                false
            );

        echo json_encode($datatable->populate());
    }
}
