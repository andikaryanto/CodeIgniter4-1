<?php

namespace App\Controllers\Rests;

use App\Controllers\Rests\Base_Rest;
use App\Eloquents\M_Users;
use App\Libraries\ResponseCode;
use App\Eloquents\M_pocketbooks;
use App\Libraries\DtTables;

class MUser extends Base_Rest
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUsers()
    {
        $page = !is_null($this->request->getGet("page")) ? $this->request->getGet("page") : 1;
        $size = !is_null($this->request->getGet("size")) ? $this->request->getGet("size") : 5;
        $limit = [];
        if($size > 0){
            $limit = [
                    'page' => $page,
                    'size' => $size
            ];
        }

       
        $params = [
            'whereNotIn' => [
                'Username' => ["superadmin"]
            ],
            'join' => [
                'm_groupusers' => [
                    [
                        'key' => 'm_users.M_Groupuser_Id = m_groupusers.Id',
                        'type' => 'left'
                    ]
                ]
            ],
            'limit' => $limit


        ];

        $datatable = new DtTables($params);
        $datatable->eloquent('App\\Eloquents\\M_users');
        $datatable
            ->addColumn(
                'm_users.Id',
                null,
                function ($row) {
                    return $row->Id;
                },
                false,
                false
            )->addColumn(
                'm_users.Username',
                null,
                function ($row) {
                    return $row->Username;
                }
            )->addColumn(
                'm_groupusers.GroupName',
                'M_Groupuser_Id',
                null
            )->addColumn(
                'm_users.Created',
                null,
                null,
                false
            );

        $result = [
            'Message' => lang('Form.success'),
            'Result' =>  $datatable->populate(),
            'Status' => ResponseCode::OK
        ];   

        $this->response->setStatusCode(200)->setJSON($result)->sendBody();
    }
}