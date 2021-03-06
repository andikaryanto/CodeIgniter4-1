<?php  
namespace App\Eloquents;

use App\Classes\Exception\EloquentException;
use App\Libraries\ResponseCode;
use App\Eloquents\BaseEloquent;
use Core\Nayo_Exception;

class T_disasteroccurlogistics extends BaseEloquent {

	public $Id;
	public $M_Item_Id;
	public $M_Warehouse_Id;
	public $T_Disasteroccur_Id;
	public $Qty;
	public $Recipient;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $table = "t_disasteroccurlogistics";
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	public function validate(self $oldmodel = null){

		$nameexist = false;
        $warning = array();

        if(!empty($oldmodel))
        {
            if($this->M_Item_Id != $oldmodel->M_Item_Id)
			{
				$params = [
					"T_Disasteroccur_Id" => $this->T_Disasteroccur_Id,
					"M_Item_Id" => $this->M_Item_Id,
					"M_Warehouse_Id" => $this->M_Warehouse_Id,
					"Recipient" => $this->Recipient
				];
                $nameexist = $this->isDataExist($params);
            }
        }
        else{
            if(!empty($this->M_Item_Id))
            {
				$params = [
					"T_Disasteroccur_Id" => $this->T_Disasteroccur_Id,
					"M_Item_Id" => $this->M_Item_Id,
					"M_Warehouse_Id" => $this->M_Warehouse_Id,
					"Recipient" => $this->Recipient
				];
                $nameexist = $this->isDataExist($params);
            }
            else{
                throw new EloquentException(lang('Error.item_can_not_null'), $this, ResponseCode::INVALID_DATA);
            }
		}
		
        if($nameexist)
        {
            throw new EloquentException(lang('Error.item_exist'), $this,ResponseCode::DATA_EXIST );
		}
		
		return $warning;
	}

}