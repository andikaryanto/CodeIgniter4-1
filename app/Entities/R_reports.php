<?php  
namespace App\Entities;

use App\Entities\BaseEntity;

class R_reports extends BaseEntity {

	public $Id;
	public $Name;
	public $Description;
	public $Url;
	public $Resource;

    
    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
    }

}