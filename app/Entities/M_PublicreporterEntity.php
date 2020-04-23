<?php  
namespace App\Entities;
use Core\Nayo_Model;

class M_PublicreporterEntity extends Nayo_Model {

	public $Id;
	public $PhoneNumber;
	public $Code;

    
    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
    }

}