<?php  
namespace App\Entities;
use Core\Nayo_Model;

class M_UserlocationEntity extends Nayo_Model {

	public $Id;
	public $M_User_Id;
	public $Latitude;
	public $Longitude;

    
    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
    }

}