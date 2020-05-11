<?php

namespace App\Libraries;

class Session {
    private $session = false;

    private function __construct(){
        if(!$this->session)
            $this->session = session();
        return $this->session;
    }

    public static function get($name){
        $ses = new static();
        return $ses->session->get($name);
    }

    public static function set($name, $value){
        $ses = new static();
        $ses->session->set($name, $value);
    }

    public static function has($name){
        $ses = new static();
        return $ses->session->has($name);
    }

    public static function push($name, $newValue){
        $ses = new static();
        return $ses->session->push($name, $newValue);
    }

    public static function remove($name){
        $ses = new static();
        return $ses->session->remove($name);
    }

    public static function setFlash($name, $value){
        $ses = new static();
        return $ses->session->setFlashdata($name, $value);
    }
    public static function getFlash($name){
        $ses = new static();
        return $ses->session->getFlashdata($name);
    }

    public static function destroy(){
        $ses = new static();
        return $ses->session->destroy();
    }
}