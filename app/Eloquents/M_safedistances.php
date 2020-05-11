<?php

namespace App\Eloquents;

use App\Classes\Exception\EloquentException;
use App\Libraries\ResponseCode;
use App\Eloquents\BaseEloquent;
use Core\Nayo_Exception;

class M_safedistances extends BaseEloquent
{

	public $Id;
	public $Distance;
	public $StatusLevel;
	public $Recommend;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;


	protected $table = "m_safedistances";
    static $primaryKey = "Id";

	public function __construct()
	{
		parent::__construct();
	}

	public function validate(self $oldmodel = null)
	{

		$nameexist = false;
		$warning = array();

		if (empty($this->Distance))
			throw new EloquentException(lang('Error.distance_can_not_null'), $this, ResponseCode::INVALID_DATA);
		if (empty($this->StatusLevel))
			throw new EloquentException(lang('Error.statuslevel_can_not_null'), $this, ResponseCode::INVALID_DATA);
		if (empty($this->Recommend))
			throw new EloquentException(lang('Error.recommend_can_not_null'), $this, ResponseCode::INVALID_DATA);

		// return $warning;
	}
}
