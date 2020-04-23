<?php  
namespace App\Entities;

use App\Entities\BaseEntity;

class M_EarlywarningEntity extends BaseEntity {

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

    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	/**
     * @param M_EarlywarningEntity 
     * @throws EntityException
     * validate the data of the entity 
     */
    public function validate(M_EarlywarningEntity $oldmodel = null)
    {

        $nameexist = false;
        $warning = array();
        return $warning;
    }


}