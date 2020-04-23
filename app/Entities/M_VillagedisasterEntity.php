<?php

namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Entities\BaseEntity;
use App\Libraries\ResponseCode;

class M_VillagedisasterEntity extends BaseEntity
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
	public $IsActive;
	public $Facility;
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

	public function validate(M_VillagedisasterEntity $oldmodel = null)
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

		if (empty($this->PersonInCharge))
			throw new EntityException(lang('Error.personincharge_can_not_null'), $this, ResponseCode::INVALID_DATA);

		if (empty($this->Phone))
			throw new EntityException(lang('Error.phone_can_not_null'), $this, ResponseCode::INVALID_DATA);

		if (empty($this->Latitude))
			throw new EntityException(lang('Error.latitude_can_not_null'), $this, ResponseCode::INVALID_DATA);

		if (empty($this->Longitude))
			throw new EntityException(lang('Error.longitude_can_not_null'), $this, ResponseCode::INVALID_DATA);

		return $warning;
	}
}
