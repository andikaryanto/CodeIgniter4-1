<?php  
namespace App\Eloquents;

use App\Classes\Exception\EloquentException;
use App\Libraries\ResponseCode;
use App\Eloquents\BaseEloquent;
use Core\Nayo_Exception;

class M_familycards extends BaseEloquent {

	public $Id;
	public $FamilyCardNo;
	public $M_Subvillage_Id;
	public $RT;
	public $RW;
	public $Description;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $table = "m_familycards";
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	public function validate(self $oldmodel = null){

		$nameexist = false;
        $warning = array();

        if(!empty($oldmodel))
        {
            if($this->FamilyCardNo != $oldmodel->FamilyCardNo)
			{
				$params = [
					"FamilyCardNo" => $this->FamilyCardNo
				];
                $nameexist = $this->isDataExist($params);
            }
        }
        else{
            if(!empty($this->FamilyCardNo))
            {
				$params = [
					"FamilyCardNo" => $this->FamilyCardNo
				];
                $nameexist = $this->isDataExist($params);
            }
            else{
                throw new EloquentException(lang('Error.name_can_not_null'),$this, ResponseCode::INVALID_DATA);
            }
        }
        if($nameexist)
        {
            throw new EloquentException(lang('Error.name_exist'),$this, ResponseCode::DATA_EXIST);
        }
        
        // return $warning;
    }
    
    public function getHeadFamily(){
        $params = [
            'where' => [
                "M_Familycard_Id" => $this->Id
            ],
            'order' => [
                'IsHeadFamily' => "DESC"
            ]
        ];

        return $this->get_first_M_Familycardmember($params)->CompleteName;
    }

}