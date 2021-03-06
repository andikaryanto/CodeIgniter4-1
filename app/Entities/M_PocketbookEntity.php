<?php  
namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Entities\BaseEntity;
use App\Libraries\ResponseCode;

class M_PocketbookEntity extends BaseEntity {

	public $Id;
	public $Title;
	public $FileUrl;
	public $Description;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	public function validate(M_PocketbookEntity $oldmodel = null)
    {

        $nameexist = false;
        $warning = array();

        if (!empty($oldmodel)) {
            if ($this->Title != $oldmodel->Title) {
                $params = [
                    "Title" => $this->Title,
                    "M_Uom_Id" => $this->M_Uom_Id
                ];
                $nameexist = $this->isDataExist($params);
            }
        } else {
            if (!empty($this->Title)) {
                $params = [
                    "Title" => $this->Title,
                    "M_Uom_Id" => $this->M_Uom_Id
                ];
                $nameexist = $this->isDataExist($params);
            } else {
                throw new EntityException(lang('Error.name_can_not_null'), $this, ResponseCode::INVALID_DATA);
            }
        }
        if ($nameexist) {
            throw new EntityException(lang('Error.name_exist'), $this, ResponseCode::DATA_EXIST);
        }

        return $warning;
    }

}