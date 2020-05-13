<?php
namespace App\Controllers;
use App\Controllers\Base_Controller;

class Error extends Base_Controller{

    public function forbidden(){
        echo view('errors/forbidden');
    }

    public function pagenotfound(){
       echo view('errors/error404');
    }

}