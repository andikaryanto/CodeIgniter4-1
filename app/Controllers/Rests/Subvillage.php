<?php

namespace App\Controllers\Rests;

use App\Controllers\M_village;
use App\Controllers\Rests\Base_Rest;
use App\Libraries\ResponseCode;
use App\Models\M_disasters;
use App\Models\M_enumdetails;
use App\Models\M_subvillages;
use App\Models\T_disasteroccurs;
use Core\Nayo_Exception;
use Exception;
use Firebase\JWT\JWT;

class Subvillage extends Base_Rest
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getSubvillages()
    {

        // if ($this->isGranted('t_disasteroccur', 'Read')) {

            $subvillages = M_subvillages::getAll();
            $occurs = [];

            foreach ($subvillages as $subvillage) {
                $village = $subvillage->get_M_Village();
                $subdistrict = $village->get_M_Subdistrict();
                $district = $subdistrict->get_M_District();
                $province = $district->get_M_Province();
                $subvillage->Village =  $village;
                $subvillage->Village->Subdistrict =  $subdistrict;
                $subvillage->Village->Subdistrict->District =  $district;
                $subvillage->Village->Subdistrict->District->Province = $province;
            }

            $occurs = $subvillages;

            $result = [
                'Message' => lang('Form.success'),
                'Result' => $occurs,
                'Status' => ResponseCode::OK
            ];   

            $this->response->json($result, 200);
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
