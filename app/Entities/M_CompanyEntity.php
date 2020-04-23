<?php  
namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Entities\BaseEntity;
use App\Libraries\ResponseCode;

class M_CompanyEntity extends BaseEntity {

	public $Id;
	public $CompanyName;
	public $Address;
	public $PostCode;
	public $Email;
	public $Phone;
	public $Fax;
	public $UrlPhoto;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	/**
     * @param M_CompanyEntity 
     * @throws EntityException
     * validate the data of the entity 
     */
	
	public function validate(M_CompanyEntity $oldmodel = null){

		$nameexist = false;
        $warning = array();

        if(!empty($oldmodel))
        {
            if($this->CompanyName != $oldmodel->CompanyName)
			{
				$params = [
					"CompanyName" => $this->CompanyName
				];
                $nameexist = $this->isDataExist($params);
            }
        }
        else{
            if(!empty($this->CompanyName))
            {
				$params = [
					"CompanyName" => $this->CompanyName
				];
                $nameexist = $this->isDataExist($params);
            }
            else{
				throw new EntityException(lang('Error.name_can_not_null'), $this, ResponseCode::INVALID_DATA);
            }
        }
        if($nameexist)
        {
			throw new EntityException(lang('Error.name_exist'), $this, ResponseCode::DATA_EXIST);
		}
		
		if(empty($this->Phone))
			throw new EntityException(lang('Error.phone_can_not_null'), $this, ResponseCode::INVALID_DATA);
        
	}

}