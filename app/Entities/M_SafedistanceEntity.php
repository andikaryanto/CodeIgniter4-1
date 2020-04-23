<?php

namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Entities\BaseEntity;
use App\Libraries\ResponseCode;
use App\Models\Base_Model;
use Core\Nayo_Exception;

class M_SafedistanceEntity extends BaseEntity
{

	public $Id;
	public $Distance;
	public $StatusLevel;
	public $Recommend;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;


    protected $primaryKey = "Id";

	public function __construct()
	{
		parent::__construct();
	}

	public function validate(M_SafedistanceEntity $oldmodel = null)
	{

		if (empty($this->Distance))
			throw new EntityException(lang('Error.distance_can_not_null'), $this, ResponseCode::INVALID_DATA);
		if (empty($this->StatusLevel))
			throw new EntityException(lang('Error.statuslevel_can_not_null'), $this, ResponseCode::INVALID_DATA);
		if (empty($this->Recommend))
			throw new EntityException(lang('Error.recommend_can_not_null'), $this, ResponseCode::INVALID_DATA);

	}
}
