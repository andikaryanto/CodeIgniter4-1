<?php  
namespace App\Eloquents;
use App\Eloquents\BaseEloquent;

class R_reportaccessroles extends BaseEloquent {

	public $Id;
	public $R_Report_Id;
	public $M_Groupuser_Id;
	public $Read;
	public $Write;
	public $Delete;
	public $Print;

    
    protected $table = "r_reportaccessroles";
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
    }

}