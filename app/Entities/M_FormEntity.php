<?php  
namespace App\Entities;

class M_FormEntity extends BaseEntity {

    public $Id;
    public $FormName;
    public $AliasName;
    public $LocalName;
    public $ClassName;
    public $Resource;
    public $IndexRoute;

    
    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
    }

    public static function getDataByName($name){
        $params = [
            'where' => [
                'FormName' => $name
            ]
        ];

        $result = self::getOne($params);
        return $result;
    }

}