<?php  
namespace App\Eloquents;

use App\Classes\Exception\EloquentException;
use App\Libraries\ResponseCode;
use App\Eloquents\BaseEloquent;
use Core\Nayo_Exception;

class M_familycardlivestocks extends BaseEloquent {

	public $Id;
	public $M_Familycard_Id;
	public $M_Livestock_Id;
	public $Qty;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $table = "m_familycardlivestocks";
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	public function validate(self $oldmodel = null){

		$nameexist = false;
        $warning = array();

        if(!empty($oldmodel))
        {
            if($this->M_Livestock_Id != $oldmodel->M_Livestock_Id)
			{
				$params = [
					"M_Familycard_Id" => $this->M_Familycard_Id,
					"M_Livestock_Id" => $this->M_Livestock_Id
				];
                $nameexist = $this->isDataExist($params);
            }
        }
        else{
            if(!empty($this->M_Livestock_Id))
            {
				$params = [
					"M_Familycard_Id" => $this->M_Familycard_Id,
					"M_Livestock_Id" => $this->M_Livestock_Id
				];
                $nameexist = $this->isDataExist($params);
            }
            else{
                throw new EloquentException(lang('Error.livestock_can_not_null'), $this, ResponseCode::INVALID_DATA);
            }
        }
        if($nameexist)
        {
            throw new EloquentException(lang('Error.livestock_exist'), $this, ResponseCode::DATA_EXIST);
		}
        
        // return $warning;
	}

}