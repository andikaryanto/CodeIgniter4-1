<?php

namespace App\Eloquents;

use App\Classes\Exception\EloquentException;
use App\Libraries\ResponseCode;
use App\Eloquents\BaseEloquent;
use Core\Nayo_Exception;

class M_volunteers extends BaseEloquent
{

	public $Id;
	public $NRR;
	public $NIK;
	public $Name;
	public $Gender;
	public $M_Subvillage_Id;
	public $BirthPlace;
	public $BirthDate;
	public $M_Capability_Id;
	public $M_Community_Id;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;


	protected $table = "m_volunteers";
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
			if ($this->NRR != $oldmodel->NRR) {
				$params = [
					"NRR" => $this->NRR
				];
				$nameexist = $this->isDataExist($params);
			}
		} else {
			if (!empty($this->NRR)) {
				$params = [
					"NRR" => $this->NRR
				];
				$nameexist = $this->isDataExist($params);
			} else {
				throw new EloquentException(lang('Error.nrr_can_not_null'), $this, ResponseCode::INVALID_DATA);
			}
		}
		if ($nameexist) {
			throw new EloquentException(lang('Error.nrr_exist'), $this, ResponseCode::DATA_EXIST);
		}

		if (empty($this->Name))
			throw new EloquentException(lang('Error.name_can_not_null'), $this, ResponseCode::INVALID_DATA);

		return $warning;
	}
}
