<?php

namespace App\Controllers\Rests;
// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

use Core\Nayo_Controller;
use App\Models\M_users;
use \Firebase\JWT\JWT;
use Core\Rest\Response;
use yidas\http\Request;

class Base_Rest extends Nayo_Controller
{

    protected $response = false;
    protected $restrequest = false;

    public function __construct()
    {
        

        if (!$this->response) {
            $this->response = new Response();
        }

        if (!$this->restrequest)
            $this->restrequest = new Request();

        parent::__construct();
    }

    public function isGranted($form = "", $role = "")
    {

        $token = $this->response->getHeader('authorization');
        $jwt = JWT::decode($token, getSecretKey(), array('HS256'));
        if($jwt){
            if (isPermittedMobile_paging($jwt->Username, $jwt->M_Groupuser_Id, form_paging()[$form], $role)) {
                return true;
                // $this->response->json($jwt, 200);
            }
        }
        // $this->response->json($token, 200);

        return false;
    }
}
