<?php
namespace App\Controllers\Rests;

use App\Controllers\Base_Controller;
use App\Eloquents\M_users;
use \Firebase\JWT\JWT;

class Authentication extends Base_Controller {

    public function __construct()
    {
    }

    public function login(){

        $username = $this->request->getGet('username');
        $password = $this->request->getGet('password');

        if($username && $password){
            $user = new M_users();

            $params = array(
                'where' => array(
                    'password' => encryptMd5(get_variable().$username.$password)
                )
            );
            $query = $user->findOne($params);
            
            $jwt = JWT::encode($query, getSecretKey());
    
            $return = [
                'message' => lang('Info.successfuly_logged_in'),
                'token' => $jwt
            ];
            
            $this->response->setStatusCode(200)->setJSON($return)->sendBody();
        } else {
            $return = [
                'message' => lang('Info.failed_logged_in')
            ]; 
            
            $this->response->setStatusCode(400)->setJSON($return)->sendBody();
        }
        
    }
}