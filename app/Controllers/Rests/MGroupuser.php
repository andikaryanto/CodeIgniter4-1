<?php

namespace App\Controllers\Rests;

use App\Classes\Exception\EloquentException;
use App\Controllers\Rests\Base_Rest;
use App\Eloquents\M_groupusers;
use App\Libraries\ResponseCode;
use App\Eloquents\M_pocketbooks;
use App\Libraries\DtTables;

class MGroupuser extends Base_Rest
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getGroupusers()
    {
        $page = !is_null($this->request->getGet("page")) ? $this->request->getGet("page") : 1;
        $size = !is_null($this->request->getGet("size")) ? $this->request->getGet("size") : 5;
        $params = [
            'limit' => [
                'page' => $page,
                'size' => $size
            ]
        ];

        $datatable = new DtTables($params);
        $datatable->eloquent('App\\Eloquents\\M_groupusers');
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
                'GroupName',
                null,
                function ($row) {
                    return $row->GroupName;
                }
            )->addColumn(
                'Description',
                null,
            )->addColumn(
                'Created',
                null,
                null,
                false
            );

        $result = [
            'Message' => lang('Form.success'),
            'Result' => $datatable->populate(),
            'Status' => ResponseCode::OK
        ];   

        $this->response->setStatusCode(200)->setJSON($result)->sendBody();
    }

    

    public function getDataById($id){
        $groupuser = M_groupusers::find($id);

        $result = [
            'Message' => lang('Form.success'),
            'Result' => $groupuser,
            'Status' => ResponseCode::OK
        ];  
        
        $this->response->setStatusCode(200)->setJSON($result)->sendBody();

    }

    public function postData(){
        $groupuser = new M_groupusers();
        $groupuser->parseFromRequest(true);
        try{
            $groupuser->validate();
            $groupuser->save();

            $result = [
                'Message' => "Data Tersimpan",
                'Result' => $groupuser,
                'Status' => ResponseCode::OK
            ];  
            $this->response->setStatusCode(200)->setJSON($result)->sendBody();
    
        } catch (EloquentException $e){
            $result = [
                'Message' => $e->getMessages(),
                'Result' => $groupuser,
                'Status' => $e->getReponseCode()
            ];  

            $this->response->setStatusCode(400)->setJSON($result)->sendBody();
        }
        
    }

    public function putData($id){
        $groupuser = M_groupusers::find($id);
        $oldmodel = clone $groupuser;
        $groupuser->parseFromRequest(true);
        try{
            $groupuser->validate($oldmodel);
            $groupuser->save();

            $result = [
                'Message' => "Data Diubah",
                'Result' => $groupuser,
                'Status' => ResponseCode::OK
            ];  
            $this->response->setStatusCode(200)->setJSON($result)->sendBody();
    
        } catch (EloquentException $e){
            $result = [
                'Message' => $e->getMessages(),
                'Result' => $groupuser,
                'Status' => $e->getReponseCode()
            ];  

            $this->response->setStatusCode(400)->setJSON($result)->sendBody();
        }
    }
}