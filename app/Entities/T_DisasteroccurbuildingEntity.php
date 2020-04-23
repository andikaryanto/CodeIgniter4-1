<?php  
namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Libraries\ResponseCode;

class T_DisasteroccurbuildingEntity extends BaseEntity {

	public $Id;
	public $Name;
	public $T_Disasteroccur_Id;
	public $M_Familycard_Id;
	public $DamageDescription;
	public $Damage;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	public function validate(self $oldmodel = null){

		$nameexist = false;
		$warning = array();
		$params = [
			"T_Disasteroccur_Id" => $this->T_Disasteroccur_Id,
			"M_Familycard_Id" => $this->M_Familycard_Id
		];
		$nameexist = $this->isDataExist($params);

		if($nameexist)
			throw new EntityException("Kartu Keluarga Sudah Ada", $this, ResponseCode::DATA_EXIST);

		if($this->T_Disasteroccur_Id == 0 || is_null($this->T_Disasteroccur_Id))
			throw new EntityException("Data Kejadian Belum Ada", $this, ResponseCode::INVALID_DATA);

		return $warning;
	}

}