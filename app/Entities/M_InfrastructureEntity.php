<?php

namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Entities\BaseEntity;
use App\Libraries\ResponseCode;

class M_InfrastructureEntity extends BaseEntity
{

	public $Id;
	public $Name;
	public $M_Subvillage_Id;
	public $Address;
	public $PersonInCharge;
	public $Phone;
	public $Capacity;
	public $Latitude;
	public $Longitude;
	public $PhotoUrl;
	public $M_Infrastructurecategory_Id;
	public $IsActive;
	public $Description;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;


    protected $primaryKey = "Id";

	public function __construct()
	{
		parent::__construct();
	}

	public function validate(M_InfrastructureEntity $oldmodel = null)
	{

		$nameexist = false;
		$warning = array();

		if (!empty($oldmodel)) {
			if ($this->Name != $oldmodel->Name) {
				$params = [
					"Name" => $this->Name
				];
				$nameexist = $this->isDataExist($params);
			}
		} else {
			if (!empty($this->Name)) {
				$params = [
					"Name" => $this->Name
				];
				$nameexist = $this->isDataExist($params);
			} else {
				throw new EntityException(lang('Error.name_can_not_null'), $this, ResponseCode::INVALID_DATA);
			}
		}

		if ($nameexist) {
			throw new EntityException(lang('Error.name_exist'), $this, ResponseCode::DATA_EXIST);
		}

		if (!$this->Address)
			throw new EntityException(lang('Error.address_can_not_null'), $this, ResponseCode::INVALID_DATA);

		if (!$this->PersonInCharge)
			throw new EntityException(lang('Error.personincharge_can_not_null'), $this, ResponseCode::INVALID_DATA);

		if (!$this->Phone)
			throw new EntityException(lang('Error.phone_can_not_null'), $this, ResponseCode::INVALID_DATA);

		if (!$this->Latitude)
			throw new EntityException(lang('Error.latitude_can_not_null'), $this, ResponseCode::INVALID_DATA);

		if (!$this->Longitude)
			throw new EntityException(lang('Error.longitude_can_not_null'), $this, ResponseCode::INVALID_DATA);

		if (!$this->M_Infrastructurecategory_Id)
			throw new EntityException(lang('Error.category_can_not_null'), $this, ResponseCode::INVALID_DATA);

		return $warning;
	}
}
