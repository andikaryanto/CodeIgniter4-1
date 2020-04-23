<?php  
namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Entities\BaseEntity;
use App\Libraries\ResponseCode;
use App\Models\Base_Model;
use Core\Nayo_Exception;

class M_DisasterEntity extends BaseEntity {

	public $Id;
	public $Name;
	public $Description;
	public $Icon;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;
    
    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	/**
     * @param M_DisasterEntity 
     * @throws EntityException
     * validate the data of the entity 
     */
	public function validate(M_DisasterEntity $oldmodel = null){

		$nameexist = false;
        $warning = array();

        if(!empty($oldmodel))
        {
            if($this->Name != $oldmodel->Name)
			{
				$params = [
					"Name" => $this->Name
				];
                $nameexist = $this->isDataExist($params);
            }
        }
        else{
            if(!empty($this->Name))
            {
				$params = [
					"Name" => $this->Name
				];
                $nameexist = $this->isDataExist($params);
            }
            else{
                throw new EntityException(lang('Error.name_can_not_null'),$this, ResponseCode::INVALID_DATA);
            }
        }
        if($nameexist)
        {
            throw new EntityException(lang('Error.name_exist'),$this, ResponseCode::DATA_EXIST);
        }
        
        // return $warning;
	}

}