<?php  
namespace App\Eloquents;

use App\Classes\Exception\EloquentException;
use App\Eloquents\BaseEloquent;
use App\Libraries\ResponseCode;

class M_pocketbooks extends BaseEloquent {

	public $Id;
	public $Title;
	public $FileUrl;
	public $Description;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $table = "m_pocketbooks";
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	public function validate(self $oldmodel = null)
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
                throw new EloquentException(lang('Error.name_can_not_null'), $this, ResponseCode::INVALID_DATA);
            }
        }
        if ($nameexist) {
            throw new EloquentException(lang('Error.name_exist'), $this, ResponseCode::DATA_EXIST);
        }

        return $warning;
    }

}