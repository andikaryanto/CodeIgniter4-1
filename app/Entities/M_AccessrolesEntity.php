<?php  
namespace App\Entities;
use App\Entities\BaseEntity;

class M_AccessroleEntity extends BaseEntity {

    public $Id;
    public $M_Form_Id;
    public $M_Groupuser_Id;
    public $Read;
    public $Write;
    public $Delete;
    public $Print;

    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
    }

}