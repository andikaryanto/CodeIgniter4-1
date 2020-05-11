<?php

namespace App\Eloquents;

use App\Classes\Exception\EloquentException;
use App\Libraries\ResponseCode;
use App\Eloquents\T_disasteroccurs;
use App\Eloquents\BaseEloquent;
use Core\Nayo_Exception;

class T_disasterreports extends BaseEloquent
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


	protected $table = "t_disasterreports";
    static $primaryKey = "Id";

	public function __construct()
	{
		parent::__construct();
		$this->DateOccur = get_current_date('d-m-Y H:i');
	}

	public function validate(self $oldmodel = null)
	{

		$nameexist = false;
		$warning = array();

		if(empty($this->ReporterName))
			throw new EloquentException("Reporter Tidak Boleh Kosong", $this, ResponseCode::DATA_EXIST);

		if(empty($this->Phone))
        {
            throw new EloquentException("Telepon Tidak Boleh Kosong", $this, ResponseCode::DATA_EXIST);
		}
		if(empty($this->M_Subvillage_Id))
        {
            throw new EloquentException("Dusun Tidak Boleh Kosong", $this, ResponseCode::DATA_EXIST);
		}
		if(empty($this->M_Disaster_Id))
        {
            throw new EloquentException("Bencana Tidak Boleh Kosong", $this, ResponseCode::DATA_EXIST);
		}
		if(empty($this->DateOccur))
        {
            throw new EloquentException("Tanggal Tidak Boleh Kosong", $this, ResponseCode::DATA_EXIST);
		}
		if(empty($this->Latitude))
        {
            throw new EloquentException("Latitude Tidak Boleh Kosong", $this, ResponseCode::DATA_EXIST);
		}
		if(empty($this->Longitude))
        {
            throw new EloquentException("Longitude Tidak Boleh Kosong", $this, ResponseCode::DATA_EXIST);
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

		$ass = T_disasterassessments::findOne($p);
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

		$occur = T_disasteroccurs::findOne($params);
		return $occur;
	}
}
