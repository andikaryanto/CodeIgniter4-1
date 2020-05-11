<?php  
namespace App\Eloquents;
use App\Eloquents\BaseEloquent;

class M_userlocations extends BaseEloquent {

	public $Id;
	public $M_User_Id;
	public $Latitude;
	public $Longitude;

    
    protected $table = "m_userlocations";
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
    }

}