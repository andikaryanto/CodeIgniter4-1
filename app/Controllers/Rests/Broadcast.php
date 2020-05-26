<?php

namespace App\Controllers\Rests;

use App\Controllers\Rests\Base_Rest;
use App\Libraries\ResponseCode;
use App\Eloquents\M_earlywarnings;
use App\Eloquents\M_enumdetails;
use App\Eloquents\T_broadcastoccurs;
use Core\Nayo_Exception;
use Exception;
use Firebase\JWT\JWT;

class Broadcast extends Base_Rest
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getBroadcasts()
    {

        $type = [];
        $usertype = $this->request->getGet("usertype");
        if ($usertype == "public") {
            $type = [1, 3];
        } else if ($usertype == "user") {
            $type = [1, 2, 3];
        }

        if ($usertype) {
            $params = [
                'whereIn' => [
                    'TypeWarning' => $type
                ],
                'where' => [
                    'DateEnd >' => get_current_date("Y-m-d H:i:s")
                ],
                'order' => [
                    'DateEnd' => 'DESC'
                ]
            ];

            $broadcasts = M_earlywarnings::findAll($params);
            foreach ($broadcasts as $broadcast) {
                $broadcast->TypeString = M_enumdetails::findEnumName("WarningType", $broadcast->TypeWarning);
                // $broadcast->StrippedDescription = strip_tags($broadcast->Description);
                $broadcast->StrippedDescription = strip_tags(html_entity_decode($broadcast->Description));
                // $broadcast->Description = htmlspecialchars($broadcast->Description;
                $broadcast->DateMonth = get_formated_date($broadcast->DateEnd, "d M");
            }

            $result = [
                'Message' => lang('Form.success'),
                'Result' => $broadcasts,
                'Status' => ResponseCode::OK
            ];

            $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
        }

        // } else {
        // $result = [
        //     'Message' => 'Tidak ada akses untuk user anda',
        //     'Status' => ResponseCode::NO_ACCESS_USER_MODULE
        // ];   

        // // echo json_encode(sss);
        // $this->response->json($result, 400);
        // }
    }

    public function getBroadcastById($id)
    {


        $params = [
            'where' => [
                'Id' => $id
            ]
        ];

        $broadcasts = M_earlywarnings::findOne($params);
        // foreach ($broadcasts as $broadcast) {
            $broadcasts->TypeString = M_enumdetails::findEnumName("WarningType", $broadcasts->TypeWarning);
            $broadcasts->StrippedDescription = strip_tags($broadcasts->Description);
            $broadcasts->DateMonth = get_formated_date($broadcasts->DateEnd, "d M");
            $broadcasts->DateEndStr = get_formated_date($broadcasts->DateEnd, "d M Y H:i");
            $broadcasts->Created = get_formated_date($broadcasts->Created, "d M Y");
            $broadcasts->ImgUrl = baseUrl($broadcasts->PhotoUrl);
        // }

        $result = [
            'Message' => lang('Form.success'),
            'Result' => $broadcasts,
            'Status' => ResponseCode::OK
        ];

        $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
    }
}
