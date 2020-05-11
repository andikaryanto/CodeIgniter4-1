<?php  
namespace App\Eloquents;

use App\Classes\Exception\EloquentException;
use App\Libraries\ResponseCode;
use App\Eloquents\BaseEloquent;
use Core\Nayo_Exception;

class T_disasteroccurvictims extends BaseEloquent {

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

    
    protected $table = "t_disasteroccurvictims";
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	public function validate(self $oldmodel = null){

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
            throw new EloquentException(lang('Error.nik_exist'), $this, ResponseCode::DATA_EXIST);
		}
		
		return $warning;
	}

}