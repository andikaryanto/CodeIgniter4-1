<?php
namespace App\Controllers;
use Core\Nayo_Controller;

class Error extends Nayo_Controller{

    public function forbidden(){
        $this->view('error/forbidden');
    }

}