<?php  
namespace App\Entities;

use App\Entities\BaseEntity;

class M_EmployeeEntity extends BaseEntity {

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

    public function __construct(){
        parent::__construct();
	}
	
	/**
     * @param M_EmployeeEntity 
     * @throws EntityException
     * validate the data of the entity 
     */
	public function validate(M_EmployeeEntity $oldmodel = null)
    {

        $nameexist = false;
        $warning = array();
        return $warning;
    }

}