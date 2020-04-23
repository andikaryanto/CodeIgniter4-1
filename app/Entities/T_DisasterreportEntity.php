<?php

namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Libraries\ResponseCode;

class T_DisasterreportEntity extends BaseEntity
{

	public $Id;
	public $ReportNo;
	public $NIR;
	public $ReporterName;
	public $Phone;
	public $M_Subvillage_Id;
	public $RT;
	public $RW;
	public $M_Disaster_Id;
	public $Cronology;
	public $DateOccur;
	public $Latitude;
	public $Longitude;
	public $Photo;
	public $Video;
	public $Photo64;
	public $Video64;
	public $M_User_Id;
	public $M_Community_Id;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;


    protected $primaryKey = "Id";

	public function __construct()
	{
		parent::__construct();
		$this->DateOccur = get_current_date('d-m-Y H:i');
	}

	public function validate(T_DisasterreportEntity $oldmodel = null)
	{

		$nameexist = false;
		$warning = array();

		if(empty($this->ReporterName))
			throw new EntityException("Reporter Tidak Boleh Kosong", $this, ResponseCode::DATA_EXIST);

		if(empty($this->Phone))
        {
            throw new EntityException("Telepon Tidak Boleh Kosong", $this, ResponseCode::DATA_EXIST);
		}
		if(empty($this->M_Subvillage_Id))
        {
            throw new EntityException("Dusun Tidak Boleh Kosong", $this, ResponseCode::DATA_EXIST);
		}
		if(empty($this->M_Disaster_Id))
        {
            throw new EntityException("Bencana Tidak Boleh Kosong", $this, ResponseCode::DATA_EXIST);
		}
		if(empty($this->DateOccur))
        {
            throw new EntityException("Tanggal Tidak Boleh Kosong", $this, ResponseCode::DATA_EXIST);
		}
		if(empty($this->Latitude))
        {
            throw new EntityException("Latitude Tidak Boleh Kosong", $this, ResponseCode::DATA_EXIST);
		}
		if(empty($this->Longitude))
        {
            throw new EntityException("Longitude Tidak Boleh Kosong", $this, ResponseCode::DATA_EXIST);
		}
		return $warning;
	}

	public function isConverted()
	{
		if($this->getConverted())
			return true;
		return false;
	}

	public function isAssessed(){
		$p = [
			'where' => [
				'T_Disasterreport_Id' => $this->Id
			]
		];

		$ass = T_DisasterassessmentEntity::getOne($p);
		if($ass)
			return true;
		return false;
	}

	public function getConverted(){

		$params = [
			'where' => [
				'T_Disasterreport_Id' => $this->Id
			]
		];

		$occur = T_DisasteroccurEntity::getOne($params);
		return $occur;
	}
}
