<?php  
namespace App\Eloquents;
use App\Eloquents\BaseEloquent;

class M_earlywarnings extends BaseEloquent {

	public $Id;
	public $Title;
	public $Description;
	public $Date;
	public $TimeEnd;
	public $DateEnd;
	public $TypeWarning;
	public $PhotoUrl;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    
    protected $table = "m_earlywarnings";
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}

	
    public function validate($oldmodel = null)
    {

        $nameexist = false;
        $warning = array();
        return $warning;
    }


}