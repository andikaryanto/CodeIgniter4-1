<?php

namespace App\Eloquents;

use App\Classes\Exception\EloquentException;
use App\Libraries\ResponseCode;
use App\Eloquents\BaseEloquent;
use Core\Nayo_Exception;

class M_villagedisasters extends BaseEloquent
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


	protected $table = "m_villagedisasters";
    static $primaryKey = "Id";

	public function __construct()
	{
		parent::__construct();
	}

	public function validate(self $oldmodel = null)
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
				throw new EloquentException(lang('Error.name_can_not_null'), $this, ResponseCode::INVALID_DATA);
			}
		}
		if ($nameexist) {
			throw new EloquentException(lang('Error.name_exist'), $this, ResponseCode::DATA_EXIST);
		}

		if (empty($this->PersonInCharge))
			throw new EloquentException(lang('Error.personincharge_can_not_null'), $this, ResponseCode::INVALID_DATA);

		if (empty($this->Phone))
			throw new EloquentException(lang('Error.phone_can_not_null'), $this, ResponseCode::INVALID_DATA);

		if (empty($this->Latitude))
			throw new EloquentException(lang('Error.latitude_can_not_null'), $this, ResponseCode::INVALID_DATA);

		if (empty($this->Longitude))
			throw new EloquentException(lang('Error.longitude_can_not_null'), $this, ResponseCode::INVALID_DATA);

		return $warning;
	}
}
