<?php  
namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Entities\BaseEntity;
use App\Libraries\ResponseCode;

class M_FamilycardmemberEntity extends BaseEntity {

	public $Id;
	public $M_Familycard_Id;
	public $CompleteName;
	public $NIK;
	public $Gender;
	public $BirthPlace;
	public $BirthDate;
	public $Religion;
	public $Education;
	public $Job;
	public $MarriageStatus;
	public $Relation;
	public $Citizenship;
	public $Description;
	public $IsDisable;
	public $IsHeadFamily;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	public function validate(M_FamilycardmemberEntity $oldmodel = null){

		$nameexist = false;
        $warning = array();

        if(!empty($oldmodel))
        {
            if($this->NIK != $oldmodel->NIK)
			{
				$params = [
					"NIK" => $this->NIK
				];
                $nameexist = $this->isDataExist($params);
            }
        }
        else{
            if(!empty($this->NIK))
            {
				$params = [
					"NIK" => $this->NIK
				];
                $nameexist = $this->isDataExist($params);
            }
            else{
               throw new EntityException(lang('Error.nik_can_not_null'), $this, ResponseCode::INVALID_DATA);
            }
        }
        if($nameexist)
        {
			throw new EntityException(lang('Error.nik_exist'), $this, ResponseCode::DATA_EXIST);
		}

		if(empty($this->BirthPlace))
			throw new EntityException(lang('Error.placeofbirth_cannot_null'), $this, ResponseCode::INVALID_DATA);

		if(empty($this->BirthDate))
			throw new EntityException(lang('Error.dateofbirth_cannot_null'), $this, ResponseCode::INVALID_DATA);

	}

}