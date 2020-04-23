<?php  
namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Libraries\ResponseCode;
use App\Models\BaseModel;

class T_DisasteroccurvictimEntity extends BaseModel {

	public $Id;
	public $M_Familycard_Id;
	public $M_Familycardmember_Id;
	public $T_Disasteroccur_Id;
	public $Name;
	public $NIK;
	public $Gender;
	public $BirthPlace;
	public $BirthDate;
	public $Religion;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	public function validate(T_DisasteroccurvictimEntity $oldmodel = null){

		$nameexist = false;
        $warning = array();

        if(!empty($oldmodel))
        {
            if($this->NIK != $oldmodel->NIK)
			{
				$params = [
					"T_Disasteroccur_Id" => $this->T_Disasteroccur_Id,
					"NIK" => $this->NIK
				];
                $nameexist = $this->isDataExist($params);
            }
        }
        else{
            if(!empty($this->NIK))
            {
				$params = [
					"T_Disasteroccur_Id" => $this->T_Disasteroccur_Id,
					"NIK" => $this->NIK
				];
                $nameexist = $this->isDataExist($params);
            }
		}
		
        if($nameexist)
        {
            throw new EntityException(lang('Error.nik_exist'), $this, ResponseCode::DATA_EXIST);
		}
	}

}