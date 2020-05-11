<?php  
namespace App\Eloquents;

use App\Classes\Exception\EloquentException;
use App\Libraries\ResponseCode;
use App\Eloquents\BaseEloquent;

class M_subdistricts extends BaseEloquent {

	public $Id;
	public $M_District_Id;
	public $Name;
	public $Description;
	public $Headman;
	public $Phone;
	public $Latitude;
	public $Longitude;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $table = "m_subdistricts";
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	public function validate(self $oldmodel = null){

		$nameexist = false;
        $warning = array();

        if(!empty($oldmodel))
        {
            if($this->Name != $oldmodel->Name)
            {
				$params = [
					"Name" => $this->Name,
					"M_District_Id" => $this->M_District_Id
				];
                $nameexist = $this->isDataExist($params);
            }
        }
        else{
            if(!empty($this->Name))
            {
				$params = [
					"Name" => $this->Name,
					"M_District_Id" => $this->M_District_Id
				];
                $nameexist = $this->isDataExist($params);
            }
            else{
                throw new EloquentException(lang('Error.name_can_not_null'), $this, ResponseCode::INVALID_DATA);
            }
        }
        if($nameexist)
        {
            throw new EloquentException(lang('Error.name_exist'), $this, ResponseCode::DATA_EXIST);
        }
        
        return $warning;
	}

}