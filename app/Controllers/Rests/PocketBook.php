<?php

namespace App\Controllers\Rests;

use App\Controllers\Rests\Base_Rest;
use App\Libraries\ResponseCode;
use App\Eloquents\M_pocketbooks;

class PocketBook extends Base_Rest
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getPocketBooks()
    {


            $pocketbooks = M_pocketbooks::findAll();
            foreach($pocketbooks as $p){
                $p->Url = baseUrl($p->FileUrl);
            }

            $result = [
                'Message' => lang('Form.success'),
                'Result' => $pocketbooks,
                'Status' => ResponseCode::OK
            ];   

            $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
    }
}
