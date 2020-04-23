<?php  
namespace App\Entities;
use Core\Nayo_Model;

class M_enumdetailEntity extends Nayo_Model {

    public $Id;
    public $M_Enum_Id;
    public $Value;
    public $EnumName;
    public $Ordering;
    public $Resource;

    protected $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
    }

    public static function getEnumName($enumName, $value){
        $params = [
            'where' => [
                'Name' => $enumName
            ]
        ];

        $enums = M_EnumEntity::getOne($params)->get_list_M_Enumdetail(['where' => ['Value' => $value]]);
        if($enums){
            if($enums[0]->Resource)
                return lang($enums[0]->Resource);
            else 
                return $enums[0]->EnumName;
        }
        return null;
    }

    public static function getEnums($enumName, $except = array()){

        $params = [
            'where' => [
                'Name' => $enumName
            ]
        ];

        $detailParams = [
            'whereNotIn' => [
                'Value' => $except
            ]
            ];

        $enums = M_EnumEntity::getOne($params)->get_list_M_Enumdetail($detailParams);
        if($enums){
            foreach($enums as $e){
                if($e->Resource)
                    $e->EnumName = lang($e->Resource);
            }
            return $enums;
        }
        return array();
    }

}