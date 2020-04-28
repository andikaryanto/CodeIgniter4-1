<?php
namespace App\Eloquents;

use CodeIgniter\Eloquent;

class M_Groupusers extends Eloquent{

    public $Id;
    public $GroupName;
    public $Description;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
    public $Modified;
    
    protected $table = "m_groupusers";
    protected $primaryKey = "Id";

    public function __construct()
    {
        parent::__construct();
    }

}