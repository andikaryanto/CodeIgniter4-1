<?php  
namespace App\Entities;

use App\Entities\BaseEntity;

class M_EnumEntity extends BaseEntity {

    public $Id;
    public $Name;

    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
    }

}