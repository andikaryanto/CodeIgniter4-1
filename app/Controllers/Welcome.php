<?php

namespace App\Controllers;

use App\Eloquents\M_disasters;
use App\Eloquents\T_disasteroccurs;

class Welcome extends Base_Controller
{

    public function index()
    {
        // return redirect()->route("login");
        $datefrom = get_formated_date($this->request->getGet("DateFrom"), "Y-m-d") . " 00:00:00";
        $dateto = get_formated_date($this->request->getGet("DateTo"), "Y-m-d") . " 23:59:59";
        
        $disaster = $this->request->getGet("Disaster");
        $status = $this->request->getGet("Status");
        $params = [
            'where' => [
                'DateOccur >=' => $datefrom,
                'DateOccur <=' => $dateto,
                'Latitude' => 'not null' ,
                'Longitude' => 'not null' ,
                'Latitude >=' => -90,
                'Latitude <=' => 90 
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
        $data['disaster'] = M_disasters::findAll();
        echo view("shared/headerpublic", $title);
        echo view("welcome/welcome", $data);
        echo view("shared/footerpublic");
    }

    public function filter()
    {

        $datefrom = get_formated_date($this->request->getGet("DateFrom"), "Y-m-d") . " 00:00:00";
        $dateto = get_formated_date($this->request->getGet("DateTo"), "Y-m-d") . " 23:59:59";
        $params = [
            'where' => [
                'DateOccur >' => $datefrom,
                'DateOccur <' => $dateto,
            ],
            'whereIn' => [
                'M_Disaster_Id' => $this->request->getGet("Disaster"),

            ]
        ];
        $model = T_disasteroccurs::findAll($params);
        // echo json_encode($model);
        $title['title'] = lang('Form.welcome');
        $data['model'] = $model;
        $data['disaster'] = M_disasters::findAll();
        // echo json_encode($data['model']);
        echo view("shared/headerpublic", $title);
        echo view("welcome/welcome", $data);
        echo view("shared/footerpublic");
    }
}
