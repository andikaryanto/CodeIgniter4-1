<?php

namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Entities\BaseEntity;
use App\Libraries\ResponseCode;
use App\Models\Base_Model;
use Core\Nayo_Exception;

class M_InstanceEntity extends BaseEntity
{

	public $Id;
	public $Name;
	public $Phone;
	public $Address;
	public $Description;
	public $Latitude;
	public $Longitude;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;


    protected $primaryKey = "Id";

	public function __construct()
	{
		parent::__construct();
	}

	public function validate(M_InstanceEntity $oldmodel = null)
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
			throw new EntityException(lang('Error.name_exist'), $this, ResponseCode::DATA_EXIST );
		}

		if (empty($this->Phone))
			throw new EntityException(lang('Error.telephone_can_not_null'), $this, ResponseCode::INVALID_DATA);

		if (empty($this->Address))
			throw new EntityException(lang('Error.address_can_not_null'), $this, ResponseCode::INVALID_DATA);

		// return $warning;
	}
}
