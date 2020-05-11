<?php  
namespace App\Eloquents;
use App\Eloquents\BaseEloquent;

class M_accessroles extends BaseEloquent {

    public $Id;
    public $M_Form_Id;
    public $M_Groupuser_Id;
    public $Read;
    public $Write;
    public $Delete;
    public $Print;

    
    protected $table = "m_accessroles";
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
    }

}