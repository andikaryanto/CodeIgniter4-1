<?php  
namespace App\Eloquents;

use App\Classes\Exception\EloquentException;
use App\Libraries\ResponseCode;
use Core\Nayo_Exception;
use App\Eloquents\BaseEloquent;

class T_disasterassessments extends BaseEloquent {

	public $Id;
	public $T_Disasterreport_Id;
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
	public $IsNeedLogistic;
	public $Photo;
	public $Video;
	public $Photo64;
	public $Video64;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $table = "t_disasterassessments";
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
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
		$this->Photo64 = $report->Photo64;
		$this->Video64 = $report->Video64;
	}

}