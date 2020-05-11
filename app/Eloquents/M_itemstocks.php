<?php  
namespace App\Eloquents;
use App\Eloquents\BaseEloquent;

class M_itemstocks extends BaseEloquent {

	public $Id;
	public $M_Item_Id;
	public $M_Warehouse_Id;
	public $Qty;

    
    protected $table = "m_itemstocks";
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	

}