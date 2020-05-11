<?php  
namespace App\Eloquents;

use App\Classes\Exception\EloquentException;
use App\Libraries\ResponseCode;
use App\Eloquents\BaseEloquent;
use Core\Nayo_Exception;

class T_disasterassessmentimpacts extends BaseEloquent {

	public $Id;
	public $M_Impact_Id;
	public $T_Disasterassessment_Id;
	public $Quantity;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $table = "t_disasterassessmentimpacts";
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	public function validate(self $oldmodel = null){

		$nameexist = false;
        $warning = array();

        if(!empty($oldmodel))
        {
            if($this->M_Impact_Id != $oldmodel->M_Impact_Id)
			{
				$params = [
					"T_Disasterassessment_Id" => $this->T_Disasterassessment_Id,
					"M_Impact_Id" => $this->M_Impact_Id
				];
                $nameexist = $this->isDataExist($params);
            }
        }
        else{
            if(!empty($this->M_Impact_Id))
            {
				$params = [
					"T_Disasterassessment_Id" => $this->T_Disasterassessment_Id,
					"M_Impact_Id" => $this->M_Impact_Id
				];
                $nameexist = $this->isDataExist($params);
            }
            else{
				
				throw new EloquentException(lang('Error.impact_can_not_null'), $this, ResponseCode::INVALID_DATA);
            }
		}
		
        if($nameexist)
        {
			throw new EloquentException(lang('Error.impact_exist'), $this, ResponseCode::DATA_EXIST);
		}
		
		return $warning;
	}
}