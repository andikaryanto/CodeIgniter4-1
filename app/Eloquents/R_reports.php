<?php  
namespace App\Eloquents;
use App\Eloquents\BaseEloquent;

class R_reports extends BaseEloquent {

	public $Id;
	public $Name;
	public $Description;
	public $Url;
	public $Resource;

    
    protected $table = "r_reports";
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
    }

}