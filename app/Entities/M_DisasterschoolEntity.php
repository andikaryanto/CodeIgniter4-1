<?php  
namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Entities\BaseEntity;
use App\Libraries\ResponseCode;

class M_DisasterschoolEntity extends BaseEntity {

	public $Id;
	public $Name;
	public $M_Subvillage_Id;
	public $Address;
	public $MaleStudent;
	public $FemaleStudent;
	public $Phone;
	public $PersonInCharge;
	public $PhonePerson;
	public $Capacity;
	public $Category;
	public $Latitude;
	public $Longitude;
	public $PhotoUrl;
	public $IsActive;
	public $Facility;
	public $Description;
	public $DisasterPotency;
	public $IsSSB;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}

	/**
     * @param M_DisasterschoolEntity 
     * @throws EntityException
     * validate the data of the entity 
     */
	public function validate(M_DisasterschoolEntity $oldmodel = null){

		$nameexist = false;
        $warning = array();

        if(!empty($oldmodel))
        {
            if($this->Name != $oldmodel->Name)
			{
				$params = [
					"Name" => $this->Name
				];
                $nameexist = $this->isDataExist($params);
            }
        }
        else{
            if(!empty($this->Name))
            {
				$params = [
					"Name" => $this->Name
				];
                $nameexist = $this->isDataExist($params);
            }
            else{
				throw new EntityException(lang('Error.name_can_not_null'), $this, ResponseCode::INVALID_DATA);
            }
        }
        if($nameexist)
        {
			throw new EntityException(lang('Error.name_exist'), $this, ResponseCode::DATA_EXIST);
		}
		
		if(empty($this->PersonInCharge))
			throw new EntityException(lang('Error.personincharge_can_not_null'), $this, ResponseCode::INVALID_DATA);
		
		if(empty($this->Phone))
			throw new EntityException(lang('Error.phone_can_not_null'), $this, ResponseCode::INVALID_DATA);
		
		if(empty($this->Latitude))
			throw new EntityException(lang('Error.latitude_can_not_null'), $this, ResponseCode::INVALID_DATA);

		if(empty($this->Longitude))
			throw new EntityException(lang('Error.longitude_can_not_null'), $this, ResponseCode::INVALID_DATA);

		if(empty($this->MaleStudent))
			throw new EntityException(lang('Error.malestudent_can_not_null'), $this, ResponseCode::INVALID_DATA);

		if(empty($this->FemaleStudent))
			throw new EntityException(lang('Error.femalestudent_can_not_null'), $this, ResponseCode::INVALID_DATA);
        
        // return $warning;
	}

}