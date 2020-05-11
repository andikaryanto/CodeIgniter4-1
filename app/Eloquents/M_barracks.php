<?php  
namespace App\Eloquents;
use App\Eloquents\BaseEloquent;

class M_barracks extends BaseEloquent {

	public $Id;
	public $Name;
	public $Address;
	public $PersonInCharge;
	public $Phone;
	public $Capacity;
	public $Latitude;
	public $Longitude;
	public $PhotoUrl;
	public $Description;
	public $IsActive;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $table = "m_barracks";
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
                $warning = array_merge($warning, array(0 => lang('Error.name_can_not_null')));
            }
        }
        if($nameexist)
        {
            $warning = array_merge($warning, array(0 => lang('Error.name_exist')));
        }
        
        return $warning;
	}

}