<?php
namespace App\Controllers\Rests;
use Core\Nayo_Controller;
use App\Models\M_users;
use \Firebase\JWT\JWT;

class Authentication extends Nayo_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function login(){

        $username = $this->request->get('username');
        $password = $this->request->get('password');

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
            
            echo json_encode($return);
        } else {
            $return = [
                'message' => lang('Info.failed_logged_in')
            ];
            
            echo json_encode($return);
        }
        
    }
}