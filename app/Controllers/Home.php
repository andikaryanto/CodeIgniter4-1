<?php
namespace App\Controllers;
use App\Controllers\Base_Controller;
use App\Eloquents\M_disasters;
use App\Eloquents\T_disasteroccurs;
use App\Libraries\Redirect;
use App\Libraries\Session;
use Core\Database\DBBuilder;

class Home extends Base_Controller{
    
    public function index(){
        if(empty(Session::get(get_variable().'userdata'))){
            Redirect::redirect('welcome')->go();
        }

        $currentyear= get_current_date("Y");
        $datacurrentyear = $this->db->query("SELECT COUNT(b.id) Jumlah, b.`Name`
        FROM t_disasteroccurs a
        INNER JOIN m_disasters b ON b.`Id` = a.`M_Disaster_Id`
        WHERE YEAR(a.`DateOccur`) = {$currentyear} 
        GROUP BY b.`Name`")->getResult();

        $datefrom = get_formated_date($this->request->getGet("DateFrom"), "Y-m-d") . " 00:00:00";
        $dateto = get_formated_date($this->request->getGet("DateTo"), "Y-m-d") . " 23:59:59";
        
        $disaster = $this->request->getGet("Disaster");
        $status = $this->request->getGet("Status");
        $params = [
            'where' => [
                'DateOccur >=' => $datefrom,
                'DateOccur <=' => $dateto
            ],
            'whereIn' => [
                'M_Disaster_Id' => $disaster,
                'Status' => $status

            ]
        ];
        $model = T_disasteroccurs::findAll($params);
        $title['title'] = lang('Form.welcome');
        $data['input'] = [
            "DateFrom" => get_formated_date($datefrom, "d-m-Y"),
            "DateTo" => get_formated_date($dateto, "d-m-Y"),
            "Disaster" => $disaster ? "[".implode(",", $disaster)."]" : array(),
            "Status" => $status ? "[".implode(",", $status)."]" : array(),
        ];
        // echo \json_encode($data['input']);
        $data['model'] = $model;
        $data['datacurrentyear'] = $datacurrentyear;
        $data['disaster'] = M_disasters::findAll();
        // echo json_encode($data['model']);
        
        $this->loadView('home/home', "Home", $data);
    }
}