<?php
namespace App\Eloquents;

use App\Classes\Exception\EloquentException;
use App\Eloquents\BaseEloquent;
use App\Eloquents\M_accessroles;
use App\Eloquents\M_forms;
use App\Eloquents\R_reportaccessroles;
use App\Eloquents\R_reports;
use App\Libraries\ResponseCode;
use Core\Database\DBBuilder;

class M_groupusers extends BaseEloquent {
    public $Id;
    public $GroupName;
    public $Description;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    protected $table = 'm_groupusers';
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct($this->table);
    }

    public function validate(self $oldmodel = null){
        $nameexist = false;
        $warning = array();

        if(!empty($oldmodel))
        {
            if($this->GroupName != $oldmodel->GroupName)
            {
                $nameexist = $this->isDataExist(["GroupName" => $this->GroupName]);
            }
        }
        else{
            if(!empty($this->GroupName))
            {
                $nameexist = $this->isDataExist(["GroupName" => $this->GroupName]);
            }
            else{
                throw new EloquentException(lang('Error.group_name_can_not_null'), $this, ResponseCode::INVALID_DATA);
            }
        }
        if($nameexist)
        {
            throw new EloquentException(lang('Error.name_exist'), $this, ResponseCode::DATA_EXIST);
        }
        
        return $warning;
    }

    public function isPermitted($groupid = null, $form = null, $role = null, $isreport = false)
    {
        if(!$isreport){
            $formid = $form;
            if(isset($form)){
                $params = array(
                    'where' => array(
                        'FormName' => $form
                    )
                );

                $dataform = M_forms::findOne($params);
                $formid = $dataform->Id;
            }
            
            $permitted = false;
            if($_SESSION[get_variable().'userdata']['Username'] == "superadmin"
                ||  $this->hasRole($groupid,$formid,$role)
            )
            {
                $permitted = true;
            }
            // echo $permitted;
            return $permitted;
        } else {
            return $this->isReportPermitted($groupid, $form, $role);
        }
    }

    public function isMoblePermitted($username, $groupid = null, $form = null, $role = null, $isreport = false){
        if(!$isreport){
            $formid = $form;
            if(isset($form)){
                $params = array(
                    'where' => array(
                        'FormName' => $form
                    )
                );

                $dataform = M_forms::findOne($params);
                $formid = $dataform->Id;
            }
            
            $permitted = false;
            if($username == "superadmin"
                ||  $this->hasRole($groupid,$formid,$role)
            )
            {
                $permitted = true;
            }
            // echo $permitted;
            return $permitted;
        } else {
            return $this->isReportPermitted($groupid, $form, $role);
        }
    }

    public function isReportPermitted($groupid = null, $form = null, $role = null){

        $formid = $form;
        if(isset($form)){
            $params = array(
                'where' => array(
                    'Name' => $form
                )
            );

            $dataform = R_reports::findOne($params);
            $formid = $dataform->Id;
        }
        
        $permitted = false;
        if($_SESSION[get_variable().'userdata']['Username'] == "superadmin"
            ||  $this->hasReportRole($groupid,$formid,$role)
        )
        {
            $permitted = true;
        }
        // echo $permitted;
        return $permitted;
    }

    public function hasReportRole($groupid, $reportid, $role){

        $permitted = false;
        $accesrole = new R_reportaccessroles();
        $params = array(
            'where' => array(
                'M_Groupuser_Id' => $groupid,
                'R_Report_Id' => $reportid,
                $role => 1
            )
        );

        $result = $accesrole->findOne($params);
        // echo json_encode($params);
        if($result)
        {
            $permitted = true;
        }

        return $permitted;
    }

    public function hasRole($groupid, $formid, $role)
    {
        $permitted = false;
        $accesrole = new M_accessroles();
        $params = array(
            'where' => array(
                'M_Groupuser_Id' => $groupid,
                'M_Form_Id' => $formid,
                $role => 1
            )
        );

        $result = $accesrole->findOne($params);
        // echo json_encode($params);
        if($result)
        {
            $permitted = true;
        }

        return $permitted;
    }

    public function view_m_accessrole(){
        $result = $this->db->query("
            SELECT * 
            FROM view_m_accessroles
            WHERE (M_Groupuser_Id = '{$this->Id}') OR M_Groupuser_Id IS NULL
            ORDER BY ClassName ASC, Header DESC, FormName ASC 
        ")->getResult();

        return $result;
    }

    public function view_r_reportaccessrole(){
        
        $result = $this->db->query("
            SELECT * 
            FROM view_r_reportaccessroles
            WHERE (GroupId = '{$this->Id}') OR GroupId IS NULL
            ORDER BY ReportName ASC 
        ")->getResult();

        return $result;
    }

    

}
