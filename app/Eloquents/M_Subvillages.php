<?php  
namespace App\Eloquents;

use App\Classes\Exception\EloquentException;
use App\Libraries\ResponseCode;
use App\Eloquents\BaseEloquent;
use Core\Nayo_Exception;

class M_subvillages extends BaseEloquent {

	public $Id;
	public $M_Village_Id;
	public $Name;
	public $KRB;
	public $FromMerapi;
	public $Address;
	public $Description;
	public $Leader;
	public $Phone;
	public $Latitude;
	public $Longitude;
	public $IsDestana;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $table = "m_subvillages";
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
					"M_Village_Id" => $this->M_Village_Id
				];
                $nameexist = $this->isDataExist($params);
            }
        }
        else{
            if(!empty($this->Name))
            {
				$params = [
					"Name" => $this->Name,
					"M_Village_Id" => $this->M_Village_Id
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