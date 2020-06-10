<?php

namespace App\Controllers\Rests;
// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

use App\Controllers\Base_Controller;
use App\Libraries\ResponseCode;
use \Firebase\JWT\JWT;
use Core\Rest\Response;
use yidas\http\Request;

class Base_Rest extends Base_Controller
{


    public function __construct()
    {
        
    }

    public function isGranted($form = "", $role = "")
    {

        $token = $this->request->getHeader('Authorization');
        $jwt = JWT::decode($token->getValue(), getSecretKey(), array('HS256'));
        if($jwt){
            $currenttime =  set_date(get_current_date("Y-m-d H:i:s"));
            if($currenttime->getTimestamp() > $jwt->ExpiredAt){
                $result = [
                    'Message' => "Sesi Anda Telah Habis",
                    'Result' => null,
                    'Status' => ResponseCode::SESSION_EXPIRED
                ];
                $this->response->setStatusCode(400)->setJSON($result)->sendBody();
                exit;
            }

            if (isPermittedMobile_paging($jwt->User->Username, $jwt->User->M_Groupuser_Id, form_paging()[$form], $role)) {
                return true;
                // $this->response->json($jwt, 200);
            }
        }
        // $this->response->json($token, 200);

        $result = [
            'Message' => "Tidak Ada Hak Akses Untuk Melihat Data",
            'Result' => null,
            'Status' => ResponseCode::NO_ACCESS_USER_MODULE
        ];   

        $this->response->setStatusCode(400)->setJSON($result)->sendBody();
        exit;
    }
}
