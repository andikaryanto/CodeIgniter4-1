<?php

namespace App\Controllers\Rests;

use App\Controllers\Rests\Base_Rest;
use App\Libraries\ResponseCode;
use App\Models\M_pocketbooks;
use App\Models\M_enumdetails;
use App\Models\T_pocketbookoccurs;
use Core\Nayo_Exception;
use Exception;
use Firebase\JWT\JWT;

class PocketBook extends Base_Rest
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getPocketBooks()
    {


            $pocketbooks = M_pocketbooks::getAll();
            foreach($pocketbooks as $p){
                $p->Url = baseUrl($p->FileUrl);
            }

            $result = [
                'Message' => lang('Form.success'),
                'Result' => $pocketbooks,
                'Status' => ResponseCode::OK
            ];   

            $this->response->json($result, 200);
    }
}
