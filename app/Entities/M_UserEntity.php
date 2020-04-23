<?php
namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Entities\BaseEntity;
use App\Libraries\ResponseCode;

class M_UserEntity extends BaseEntity {
    public $Id;
    public $M_Groupuser_Id;
    public $Username;
    public $Password;
    public $IsLoggedIn;
    public $IsActive;
    public $Language;
    public $IsStartMoving;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
    }

    public function setPassword($password){
        $this->Password = encryptMd5(get_variable().$this->Username.$password);
        return $this->Password;
    }

    public function getByPassword($password){

        $params = array(
            'where' => array(
                'password' => $password
            )
        );
        // print_r($user);
        $query = static::getOne($params);
        return $query;
    }

    public function validate(M_UserEntity $oldmodel = null){
        $nameexist = false;
        $warning = array();

        if(!empty($oldmodel))
        {
            if($this->Username != $oldmodel->Username)
            {
                
				$params = [
					"Username" => $this->Username
				];
                $nameexist = $this->isDataExist($params);
            }
        }
        else{
            if(!empty($this->Username))
            {
				$params = [
					"Username" => $this->Username
				];
                $nameexist = $this->isDataExist($params);
            }
            else{
                throw new EntityException(lang('Error.name_can_not_null'), $this, ResponseCode::INVALID_DATA);
            }
        }
        if($nameexist)
        {
            throw new EntityException(lang('Error.name_exist'), $this, ResponseCode::DATA_EXIST);
        }

        if(empty($this->Password)){
            throw new EntityException(lang('Error.password_can_not_null'), $this, ResponseCode::INVALID_DATA);
        }
        
    }

    public static function login($username, $password){

        $params = array(
            'where' => array(
                'password' => encryptMd5(get_variable() . $username . $password)
            )
        );
        $query = static::getOne($params);
        return $query;
    }

}
