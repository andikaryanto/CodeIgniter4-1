<?php

namespace App\Controllers;

use App\Eloquents\M_users;
use App\Libraries\Redirect;
use App\Libraries\Session;

class Login extends Base_Controller
{

    public function __construct()
    {
        // parent::__construct();
    }

    public function index()
    {
        // new Sqlsrv();
        $userSession = Session::get(get_variable() . 'userdata');
        if (!isset($userSession))
            echo view('login/login');
        else
            return Redirect::redirect('home')->go();
    }
    
    public function dologin()
    {
        $username = $this->request->getPost('loginUsername');
        $password = $this->request->getPost('loginPassword');

        $query = M_users::login($username, $password);
        
        if ($query) {
            if ($query->IsActive == 1) {
                Session::set(get_variable() . 'userdata', get_object_vars($query));
                Session::set(get_variable() . 'language', $query->Language);
                return Redirect::redirect('home')->go();
                // return redirect()->route("home");
            } else {
                return Redirect::redirect('welcome')->go();
            }
        } else {
            return Redirect::redirect('welcome')->go();  
        }
    }

    public function dologout()
    {
        Session::destroy();
        // Session::stop();
        return Redirect::redirect('welcome')->go();
    }
}
