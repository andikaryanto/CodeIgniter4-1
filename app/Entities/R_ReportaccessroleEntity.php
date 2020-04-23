<?php  
namespace App\Entities;
use Core\Nayo_Model;

class R_ReportaccessroleEntity extends Nayo_Model {

	public $Id;
	public $R_Report_Id;
	public $M_Groupuser_Id;
	public $Read;
	public $Write;
	public $Delete;
	public $Print;

    
    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
    }

}