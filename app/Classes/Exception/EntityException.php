<?php

namespace App\Classes\Exception;
use App\Classes\Exception\BaseException;
use Throwable;

class EntityException extends BaseException{

    private $entity;
    private $responseCode;
    public function __construct($message, $entity, array $responseCode = null, $code = 0, ?Throwable $previous = null)
    {
        $this->entity = $entity;
        $this->responseCode = $responseCode;
        parent::__construct($message, $code, $previous);
    }

    public function getEntity(){
        return $this->entity;
    }

    public function getReponseCode(){
        return $this->responseCode;
    }
}