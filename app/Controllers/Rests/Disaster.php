<?php

namespace App\Controllers\Rests;

use App\Controllers\Rests\Base_Rest;
use App\Libraries\ResponseCode;
use App\Eloquents\M_disasters;
use App\Eloquents\M_enumdetails;
use App\Eloquents\T_disasteroccurs;
use Core\Nayo_Exception;
use Exception;
use Firebase\JWT\JWT;

class Disaster extends Base_Rest
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getDisasters()
    {

        // if ($this->isGranted('t_disasteroccur', 'Read')) {

            $disasters = M_disasters::findAll();
            foreach($disasters as $disaster){
                $disaster->value = $disaster->Id;
                $disaster->display = $disaster->Name;
            }

            $result = [
                'Message' => lang('Form.success'),
                'Result' => $disasters,
                'Status' => ResponseCode::OK
            ];   

            $this->response->setStatusCode(200)->setJSON($result)->sendBody();
        // } else {
            // $result = [
            //     'Message' => 'Tidak ada akses untuk user anda',
            //     'Status' => ResponseCode::NO_ACCESS_USER_MODULE
            // ];   

            // // echo json_encode(sss);
            // $this->response->json($result, 400);
        // }
    }
}
