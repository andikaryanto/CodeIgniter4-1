<?php  
namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Libraries\ResponseCode;
use App\Models\Base_Model;
use Core\Nayo_Exception;

class T_DisasteroccurimpactEntity extends BaseEntity {

	public $Id;
	public $M_Impact_Id;
	public $T_Disasteroccur_Id;
	public $Quantity;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	public function validate(T_DisasteroccurimpactEntity $oldmodel = null){

		$nameexist = false;
        $warning = array();

        if(!empty($oldmodel))
        {
            if($this->M_Impact_Id != $oldmodel->M_Impact_Id)
			{
				$params = [
					"T_Disasteroccur_Id" => $this->T_Disasteroccur_Id,
					"M_Impact_Id" => $this->M_Impact_Id
				];
                $nameexist = $this->isDataExist($params);
            }
        }
        else{
            if(!empty($this->M_Impact_Id))
            {
				$params = [
					"T_Disasteroccur_Id" => $this->T_Disasteroccur_Id,
					"M_Impact_Id" => $this->M_Impact_Id
				];
                $nameexist = $this->isDataExist($params);
            }
            else{
				
				throw new EntityException(lang('Error.impact_can_not_null'), $this, ResponseCode::INVALID_DATA);
            }
		}
		
        if($nameexist)
        {
			throw new EntityException(lang('Error.impact_exist'), $this, ResponseCode::DATA_EXIST);
		}
		
		return $warning;
	}
}