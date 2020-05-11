<?php  
namespace App\Eloquents;

use App\Classes\Exception\EloquentException;
use App\Libraries\ResponseCode;
use App\Eloquents\BaseEloquent;
use Core\Nayo_Exception;

class M_impacts extends BaseEloquent {

	public $Id;
	public $M_Impactcategory_Id;
	public $Name;
	public $UoM;
	public $Description;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $table = "m_impacts";
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
                throw new EloquentException(lang('Error.name_can_not_null'), $this, ResponseCode::INVALID_DATA);
            }
        }
        if($nameexist)
        {
            throw new EloquentException(lang('Error.name_exist'), $this, ResponseCode::DATA_EXIST);
        }

        if(empty($this->M_Impactcategory_Id))
            throw new EloquentException('Kategori Tidak BOleh Kosong', $this, ResponseCode::INVALID_DATA);
        
        // return $warning;
	}

}