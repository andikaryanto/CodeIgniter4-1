<?php  
namespace App\Eloquents;
use App\Eloquents\BaseEloquent;

class M_forms extends BaseEloquent {

    public $Id;
    public $FormName;
    public $AliasName;
    public $LocalName;
    public $ClassName;
    public $Resource;
    public $IndexRoute;

    
    protected $table = "m_forms";
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
    }

    public static function findDataByName($name){
        $params = [
            'where' => [
                'FormName' => $name
            ]
        ];

        $result = self::findOne($params);
        return $result;
    }

}