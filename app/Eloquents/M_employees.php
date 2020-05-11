<?php  
namespace App\Eloquents;
use App\Eloquents\BaseEloquent;

class M_employees extends BaseEloquent {

	public $Id;
	public $Name;
	public $Phone;
	public $Address;
	public $NIP;
	public $M_Occupation_Id;
	public $EmployeeDepartment;
	public $EmployeeStatus;
	public $Description;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $table = "m_employees";
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	public function validate($oldmodel = null)
    {

        $nameexist = false;
        $warning = array();
        return $warning;
    }

}