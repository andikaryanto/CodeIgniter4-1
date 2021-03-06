<?php

namespace App\Controllers\Rests;

use App\Controllers\Rests\Base_Rest;
use App\Libraries\ResponseCode;
use App\Eloquents\M_impacts;

class Impact extends Base_Rest
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getImpacts()
    {

        // if ($this->isGranted('t_impactoccur', 'Read')) {

            $impacts = M_impacts::findAll();
            foreach($impacts as $impact){
                $impact->value = $impact->Id;
            }

            $result = [
                'Message' => lang('Form.success'),
                'Result' => $impacts,
                'Status' => ResponseCode::OK
            ];   

            $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
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
