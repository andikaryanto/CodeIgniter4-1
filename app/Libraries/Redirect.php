<?php

namespace App\Libraries;

class Redirect {

    private $route;
    private function __constrcut(){
        
    }

    public static function redirect($route){
        $redirect = new static;
        $redirect->route = $route;
        return $redirect;
    }

    public function with($data){
        Session::set('data', get_object_vars($data));
        return $this;
    }

    public function go(){
        return redirect()->route($this->route);
    }
}