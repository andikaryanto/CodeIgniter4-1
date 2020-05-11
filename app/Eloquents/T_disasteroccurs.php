<?php

namespace App\Eloquents;

use App\Classes\Exception\EloquentException;
use App\Enums\T_disasteroccursStatus;
use App\Libraries\ResponseCode;
use App\Eloquents\BaseEloquent;
use Core\Nayo_Exception;

class T_disasteroccurs extends BaseEloquent
{

	public $Id;
	public $TransNo;
	public $NIR;
	public $ReporterName;
	public $Phone;
	public $M_Subvillage_Id;
	public $T_Disasterreport_Id;
	public $RT;
	public $RW;
	public $M_Disaster_Id;
	public $Cronology;
	public $DateOccur;
	public $Latitude;
	public $Longitude;
	public $Photo;
	public $Video;
	public $IsNeedLogistic;
	public $Status;
	public $Photo64;
	public $Video64;
	public $M_Community_Id;
	public $M_User_Id;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;


	protected $table = "t_disasteroccurs";
    static $primaryKey = "Id";

	public function __construct()
	{
		parent::__construct();
		$this->DateOccur = get_current_date('d-m-Y H:i');
	}
	public function validate(self $oldmodel = null)
	{

		if(empty($this->ReporterName))
        {
            throw new EloquentException("Reporter Tidak Boleh Kosong", $this, ResponseCode::DATA_EXIST);
		}
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
	}

	public function copyFromReport($report){
		$this->NIR = $report->NIR;
		$this->ReporterName = $report->ReporterName;
		$this->Phone = $report->Phone;
		$this->M_Subvillage_Id = $report->M_Subvillage_Id;
		$this->M_Disaster_Id = $report->M_Disaster_Id;
		$this->DateOccur = $report->DateOccur;
		$this->Latitude = $report->Latitude;
		$this->Longitude = $report->Longitude;
		$this->RT = $report->RT;
		$this->RW = $report->RW;
		$this->T_Disasterreport_Id = $report->Id;
		$this->Cronology = $report->Cronology;
		$this->Status = T_disasteroccursStatus::NOTHANDLED;
		$this->Photo64 = $report->Photo64;
		$this->Video64 = $report->Video64;
	}

	public function copyFromAssessment($assessment){
		$this->NIR = $assessment->NIR;
		$this->ReporterName = $assessment->ReporterName;
		$this->Phone = $assessment->Phone;
		$this->M_Subvillage_Id = $assessment->M_Subvillage_Id;
		$this->M_Disaster_Id = $assessment->M_Disaster_Id;
		$this->DateOccur = $assessment->DateOccur;
		$this->Latitude = $assessment->Latitude;
		$this->Longitude = $assessment->Longitude;
		$this->RT = $assessment->RT;
		$this->RW = $assessment->RW;
		$this->T_Disasterreport_Id = $assessment->T_Disasterreport_Id;
		$this->Cronology = $assessment->Cronology;
		$this->Status = T_disasteroccursStatus::NOTHANDLED;
		$this->Photo64 = $assessment->Photo64;
		$this->Video64 = $assessment->Video64;
	}

	public function copyFromExisting($report){
		$this->Id = $report->Id;
		$this->NIR = $report->NIR;
		$this->TransNo = $report->TransNo;
		$this->ReporterName = $report->ReporterName;
		$this->Phone = $report->Phone;
		$this->M_Subvillage_Id = $report->M_Subvillage_Id;
		$this->M_Disaster_Id = $report->M_Disaster_Id;
		$this->DateOccur = $report->DateOccur;
		$this->Latitude = $report->Latitude;
		$this->Longitude = $report->Longitude;
		$this->RT = $report->RT;
		$this->RW = $report->RW;
		$this->T_Disasterreport_Id = $report->Id;
		$this->Cronology = $report->Cronology;
		$this->Status = T_disasteroccursStatus::NOTHANDLED;
		$this->Photo64 = $report->Photo64;
		$this->Video64 = $report->Video64;
	}
}
