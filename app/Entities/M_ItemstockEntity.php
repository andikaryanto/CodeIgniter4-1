<?php  
namespace App\Entities;
use Core\Nayo_Model;

class M_ItemstockEntity extends Nayo_Model {

	public $Id;
	public $M_Item_Id;
	public $M_Warehouse_Id;
	public $Qty;

    
    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	

}