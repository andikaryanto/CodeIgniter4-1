<?php  
namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Entities\BaseEntity;
use App\Libraries\ResponseCode;

class M_ImpactEntity extends BaseEntity {

	public $Id;
	public $M_Impactcategory_Id;
	public $Name;
	public $UoM;
	public $Description;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	public function validate(M_ImpactEntity $oldmodel = null){

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
               throw new EntityException(lang('Error.name_can_not_null'), $this, ResponseCode::INVALID_DATA);
            }
        }
        if($nameexist)
        {
           throw new EntityException(lang('Error.name_exist'), $this, ResponseCode::DATA_EXIST);
        }

        if(empty($this->M_Impactcategory_Id))
           throw new EntityException('Kategori Tidak BOleh Kosong', $this, ResponseCode::INVALID_DATA);
        
        // return $warning;
	}

}