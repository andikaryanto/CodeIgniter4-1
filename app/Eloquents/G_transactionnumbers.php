<?php  
namespace App\Eloquents;
use App\Eloquents\BaseEloquent;
use Core\Session;

class G_transactionnumbers extends BaseEloquent {

	public $Id;
	public $Format;
	public $Year;
	public $Month;
	public $LastNumber;
	public $M_Form_Id;
	public $TypeTrans;

    
    protected $table = "g_transactionnumbers";
    static $primaryKey = "Id";

    public function __construct(){
        parent::__construct();
	}
	
	public static function findLastNumberByFormId($formId, $year = null, $month = null, $type = null){
        if(is_null($year))
            $year  = get_current_date('Y');
        
        if(is_null($month))
            $month  = get_current_date('m');

        
        // $branch =  isset(Session::get(get_variable() . 'userdata')['M_Shop_Id']) ? Session::get(get_variable() . 'userdata')['M_Shop_Id'] : null;
		$params = [
			'where' => [
				"M_Form_Id" => $formId,
				"Year" => $year,
                "Month" => (int)$month
			]
        ];
        
        $query = self::findOne($params);
        if(is_null($query)){
            // echo "a";
            $insert = self::insertNewFormNumber($formId, $year, $month, $type);
            if($insert > 0)
                return self::getLastNumberByFormId($formId, $year, $month, $type);
        }

        $result = $query;
        $formatedNumber = $result->Format;
        $code = explode("/",$formatedNumber);
        $newNumber = str_replace("#","0",$code[2]);
        $newNumberLen = strlen($newNumber);
        $newNumber = $newNumber . (string)($result->LastNumber + 1);
        $newNumber = substr($newNumber, strlen($newNumber)-$newNumberLen,$newNumberLen);

        
        $formatedNumber = str_replace("{YY}",(string)$year, $formatedNumber);
        $formatedNumber = str_replace("{MM}",(string)$month, $formatedNumber);
        $formatedNumber = str_replace("######",$newNumber, $formatedNumber);

        return $code[0]."/".(string)$year.(string)$month."/".$newNumber;
    }

    public static function insertNewFormNumber($formId, $year, $month, $type = null){
        // $branch =  isset(Session::get(get_variable() . 'userdata')['M_Shop_Id']) ? Session::get(get_variable() . 'userdata')['M_Shop_Id'] : null;
		
        $params = array(
            'where' => array(
                'M_Form_Id' => $formId,
                'TypeTrans' => $type
            )
        );

        $form = M_formsettings::findOne($params);

        // $model = static::getOne($params);
        // echo json_encode($model);
        $id = null;
        if($form){
            $arr = explode("/", $form->StringValue);
            $newmodel = new static;
            $newmodel->Format = $arr[0]."/".$arr[1]."/".str_repeat("#", $arr[2]);
            $newmodel->Year = $year;
            $newmodel->Month = (int)$month;
            $newmodel->LastNumber = 1;
            $newmodel->M_Form_Id = $formId;
            $newmodel->TypeTrans = $type;
            $id = $newmodel->save();
            // echo json_encode($newmodel);
        }

        return $id;
    }

    public static function updateLastNumber($formId, $year = null, $month = null, $type = null){
		if(is_null($year))
            $year  = get_current_date('Y');
        
        if(is_null($month))
            $month  = get_current_date('m');

        // $branch =  isset(Session::get(get_variable() . 'userdata')['M_Shop_Id']) ? Session::get(get_variable() . 'userdata')['M_Shop_Id'] : null;
		
		$params = array(
            'where' => array(
				'M_Form_Id' => $formId,
				'Year' => $year,
				'Month' => (int)$month,
				'TypeTrans' => $type,
                'Branch' => null
            )
        );


		$model = self::findOne($params);
		$model->LastNumber += 1;
		$model->save();

    }

    public static function getByFormId($formId){
        $params = [
            'where' => [
                'M_Form_Id' => $formId
            ]
        ];

        return static::findOne($params);
    }

}