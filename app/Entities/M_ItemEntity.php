<?php

namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Entities\BaseEntity;
use App\Libraries\ResponseCode;

class M_ItemEntity extends BaseEntity
{

    public $Id;
    public $Name;
    public $M_Uom_Id;
    public $Description;
    public $CreatedBy;
    public $ModifiedBy;
    public $Created;
    public $Modified;


    protected $primaryKey = "Id";

    public function __construct()
    {
        parent::__construct();
    }

    public function validate(M_ItemEntity $oldmodel = null)
    {

        $nameexist = false;
        $warning = array();

        if (!empty($oldmodel)) {
            if ($this->Name != $oldmodel->Name) {
                $params = [
                    "Name" => $this->Name,
                    "M_Uom_Id" => $this->M_Uom_Id
                ];
                $nameexist = $this->isDataExist($params);
            }
        } else {
            if (!empty($this->Name)) {
                $params = [
                    "Name" => $this->Name,
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
    }
}
