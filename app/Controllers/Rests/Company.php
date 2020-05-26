<?php

namespace App\Controllers\Rests;

use App\Controllers\Rests\Base_Rest;
use App\Libraries\ResponseCode;
use App\Eloquents\M_companies;
use App\Eloquents\M_earlywarnings;
use App\Eloquents\M_enumdetails;
use App\Eloquents\T_broadcastoccurs;
use Core\Nayo_Exception;
use Exception;
use Firebase\JWT\JWT;

class Company extends Base_Rest
{
    public function getCompany()
    {
        $company = M_companies::findOne();
        $result = [
            'Message' => lang('Form.success'),
            'Result' => $company,
            'Status' => ResponseCode::OK
        ];

        $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
    }
}
