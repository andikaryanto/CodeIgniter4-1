<?php  
namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Libraries\ResponseCode;
use Core\Nayo_Exception;
use App\Models\Base_Model;

class T_DisasterassessmentEntity extends BaseEntity {

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

    
    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}

	public function validate(T_DisasterassessmentEntity $oldmodel = null)
	{

		if(empty($this->ReporterName))
        {
            throw new EntityException("Reporter Tidak Boleh Kosong", $this, ResponseCode::DATA_EXIST);
		}
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