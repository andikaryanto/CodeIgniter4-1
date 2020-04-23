<?php  
namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Entities\BaseEntity;
use App\Libraries\ResponseCode;

class M_CommunityEntity extends BaseEntity {

	public $Id;
	public $Name;
	public $M_Subvillage_Id;
	public $Address;
	public $ServicePeriod;
	public $NumberOfAdmin;
	public $NumberOfMember;
	public $EndService;
	public $Adart;
	public $Phone;
	public $AlternatePhone;
	public $Capability;
	public $RoutinMeeting;
	public $FoundOn;
	public $SignedPlaceman;
	public $FreeRx;
	public $FreeTx;
	public $Tone;
	public $OwnedEquipment;
	public $Description;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $table = "m_communities";

    public function __construct(){
        parent::__construct();
	}
	
	/**
     * @param M_CommunityEntity 
     * @throws EntityException
     * validate the data of the entity 
     */
	public function validate(M_CommunityEntity $oldmodel = null){

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
		
		if(empty($this->Phone))
			throw new EntityException(lang('Error.phone_can_not_null'), $this, ResponseCode::INVALID_DATA);
        
	}

}