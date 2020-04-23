<?php  
namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Entities\BaseEntity;
use App\Libraries\ResponseCode;

class M_EquipmentownerEnitty extends BaseEntity {

	public $Id;
	public $OwnerName;
	public $M_Subvillage_Id;
	public $Address;
	public $M_Equipment_Id;
	public $DamagedQty;
	public $GoodQty;
	public $Phone;
	public $Latitude;
	public $Longitude;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}

	public function validate(M_EquipmentownerEnitty $oldmodel = null){

		$nameexist = false;
        $warning = array();

        if(!empty($oldmodel))
        {
            if($this->OwnerName != $oldmodel->OwnerName)
			{
				$params = [
					"OwnerName" => $this->OwnerName,
					"M_Equipment_Id" => $this->M_Equipment_Id,
					"M_Subvillage_Id" => $this->M_Subvillage_Id
				];
                $nameexist = $this->isDataExist($params);
            }
        }
        else{
            if(!empty($this->OwnerName))
            {
				$params = [
					"OwnerName" => $this->OwnerName,
					"M_Equipment_Id" => $this->M_Equipment_Id,
					"M_Subvillage_Id" => $this->M_Subvillage_Id
				];
                $nameexist = $this->isDataExist($params);
            }
            else{
               throw new EntityException(lang('Error.name_can_not_null'),$this, ResponseCode::INVALID_DATA);
            }
        }
        if($nameexist)
        {
           throw new EntityException(lang('Error.name_exist'), $this, ResponseCode::DATA_EXIST);
        }
        
        // return $warning;
	}
	


}