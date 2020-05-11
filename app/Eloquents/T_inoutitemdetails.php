<?php  
namespace App\Eloquents;

use App\Classes\Exception\EloquentException;
use App\Libraries\ResponseCode;
use App\Eloquents\BaseEloquent;
use Core\Nayo_Exception;

class T_inoutitemdetails extends BaseEloquent {

	public $Id;
	public $T_Disasteroccurlogistic_Id;
	public $T_Inoutitem_Id;
	public $M_Warehouse_Id;
	public $M_Item_Id;
	public $Qty;
	public $Description;
	public $Recipient;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $table = "t_inoutitemdetails";
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
					"T_Inoutitem_Id" => $this->T_Inoutitem_Id,
					"M_Item_Id" => $this->M_Item_Id,
					"M_Warehouse_Id" => $this->M_Warehouse_Id
				];
                $nameexist = $this->isDataExist($params);
            }
        }
        else{
            if(!empty($this->M_Item_Id))
            {
				$params = [
					"T_Inoutitem_Id" => $this->T_Inoutitem_Id,
					"M_Item_Id" => $this->M_Item_Id,
					"M_Warehouse_Id" => $this->M_Warehouse_Id
				];
                $nameexist = $this->isDataExist($params);
            }
            else{
               throw new EloquentException(array(0=>lang('Error.item_can_not_null')), $this, ResponseCode::INVALID_DATA);
            }
        }
        if($nameexist)
        {
			throw new EloquentException(array(0=>lang('Error.item_exist')), $this, ResponseCode::DATA_EXIST);
		}

		if(empty($this->M_Warehouse_Id)){
			throw new EloquentException(array(0=>lang('Error.warehouse_can_not_null')), $this, ResponseCode::INVALID_DATA);
		}

        
        return $warning;
	}

}