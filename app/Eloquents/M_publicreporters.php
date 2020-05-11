<?php  
namespace App\Eloquents;
use App\Eloquents\BaseEloquent;

class M_publicreporters extends BaseEloquent {

	public $Id;
	public $PhoneNumber;
	public $Code;

    
    protected $table = "m_publicreporters";
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
    }

}