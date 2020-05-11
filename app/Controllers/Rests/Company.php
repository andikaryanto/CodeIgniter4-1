<?php

namespace App\Controllers\Rests;

use App\Controllers\Rests\Base_Rest;
use App\Libraries\ResponseCode;
use App\Models\M_companies;
use App\Models\M_earlywarnings;
use App\Models\M_enumdetails;
use App\Models\T_broadcastoccurs;
use Core\Nayo_Exception;
use Exception;
use Firebase\JWT\JWT;

class Company extends Base_Rest
{
    public function getCompany()
    {
        $company = M_companies::getOne();
        $result = [
            'Message' => lang('Form.success'),
            'Result' => $company,
            'Status' => ResponseCode::OK
        ];

        $this->response->json($result, 200);
    }
}
