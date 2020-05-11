<?php

namespace App\Controllers\Rests;

use App\Controllers\Rests\Base_Rest;
use App\Libraries\ResponseCode;
use App\Models\G_transactionnumbers;
use App\Models\M_enumdetails;
use App\Models\M_forms;
use App\Models\T_disasteroccurs;
use App\Models\T_disasterreports;
use Core\Nayo_Exception;
use Exception;
use Firebase\JWT\JWT;

class DisasterOccur extends Base_Rest
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getDisasterOccurs()
    {

        if ($this->isGranted('t_disasteroccur', 'Read')) {

            $showImage = $this->request->get("showimage");
            $page = $this->request->get("page");
            $size = $this->request->get("size");
            $params = [
                'order' => [
                    'Created' => 'DESC'
                ],
                'limit' => [
                    'page' => $page,
                    'size' => $size
                ]
            ];

            $disasters = T_disasteroccurs::getAll($params);
            $occurs = [];

            foreach ($disasters as $disaster) {
                $subvillage = $disaster->get_M_Subvillage();
                $village = $subvillage->get_M_Village();
                $subdistrict = $village->get_M_Subdistrict();
                $district = $subdistrict->get_M_District();
                $province = $district->get_M_Province();
                $disaster->Noref = $disaster->get_T_Disasterreport()->ReportNo;
                $disaster->StatusName = M_enumdetails::getEnumName("DisasterOccurStatus", $disaster->Status);
                $disaster->DisasterName = $disaster->get_M_Disaster()->Name;
                $disaster->Address = "{$subvillage->Name} {$disaster->RT}/{$disaster->RW}, {$village->Name}, {$subdistrict->Name}, {$district->Name}, {$province->Name}";
                if($showImage == "true"){
                    $disaster->Photo = "data:image/*;charset=utf-8;base64,".$disaster->Photo64;
                } else {
                    
                    $disaster->Photo64 = null;
                }
                $mdisaster = $disaster->get_M_Disaster();
                $disaster->Disaster = $mdisaster;
                $disaster->Icon = baseUrl($mdisaster->Icon);
                $disaster->Subvillage = $subvillage;
                $disaster->Subvillage->Village = $village;
                $disaster->Subvillage->Village->Subdistrict =  $subdistrict;
                $disaster->Subvillage->Village->Subdistrict->District =  $district;
                $disaster->Subvillage->Village->Subdistrict->District->Province = $province;
            }

            $occurs = $disasters;

            $result = [
                'Message' => lang('Form.success'),
                'Result' => $occurs,
                'Status' => ResponseCode::OK
            ];

            // echo json_encode(sss);
            $this->response->json($result, 200);
        } else {
            $result = [
                'Message' => 'Tidak ada akses untuk user anda',
                'Status' => ResponseCode::NO_ACCESS_USER_MODULE
            ];

            // echo json_encode(sss);
            $this->response->json($result, 400);
        }
    }

    public function getDisasteOccurById($id)
    {

        if ($this->isGranted('t_disasteroccur', 'Read')) {

            $disaster = T_disasteroccurs::get($id);

            $subvillage = $disaster->get_M_Subvillage();
            $village = $subvillage->get_M_Village();
            $subdistrict = $village->get_M_Subdistrict();
            $district = $subdistrict->get_M_District();
            $province = $district->get_M_Province();
            $disaster->NeedLogistic = $disaster->IsNeedLogistic == 1 ? "Ya" : "Tidak";
            $disaster->Noref = $disaster->get_T_Disasterreport()->ReportNo;
            $disaster->StatusName = M_enumdetails::getEnumName("DisasterOccurStatus", $disaster->Status);
            $disaster->DisasterName = $disaster->get_M_Disaster()->Name;
            $disaster->Address = "{$subvillage->Name} {$disaster->RT}/{$disaster->RW}, {$village->Name}, {$subdistrict->Name}, {$district->Name}, {$province->Name}";
            // $disaster->Photo64 = base64_decode($disaster->Photo64);

            $result = [
                'Message' => lang('Form.success'),
                'Result' => $disaster,
                'Status' => ResponseCode::OK
            ];

            // echo json_encode(sss);
            $this->response->json($result, 200);
        } else {
            $result = [
                'Message' => 'Tidak ada akses untuk user anda',
                'Status' => ResponseCode::NO_ACCESS_USER_MODULE
            ];

            // echo json_encode(sss);
            $this->response->json($result, 400);
        }
    }

    public function postDisasterOccur()
    {

        try{
            if ($this->isGranted('t_disasterreport', 'Write')) {
                
                $token = $this->response->getHeader('authorization');
                $jwt = JWT::decode($token, getSecretKey(), array('HS256'));
                $disasteroccur = null;
                $raw = $this->restrequest->getRawBody();
                // $disasteroccur->setMobile();
    
                $body = json_decode($raw);
    
                if ($body->Id != 0)
                    $disasteroccur = T_disasteroccurs::get($body->Id);
                else 
                    $disasteroccur = new T_disasteroccurs();
    
                // $value = [];
                foreach ($body as $k => $v) {
                    if(!empty($v)){
                        if($k == "Photo64"){
                            // $disasteroccur->$k = base64_decode($v);
                            $disasteroccur->$k = $v;
                        } else {
                            $disasteroccur->$k = $v;
                        }
                    }
                }
                
                $disasteroccur->ReporterName = $jwt->Username;
                $disasteroccur->Phone = "-";
                $disasteroccur->DateOccur = get_formated_date($body->DateOccur, "Y-m-d H:i:s");
                $disasteroccur->Status = 1;
                $disasteroccur->validate();
    
                if ($body->Id == 0 || is_null($body->Id)) {
                    $formid = M_forms::getDataByName('t_disasteroccurs')->Id;
                    $disasteroccur->Id = null;
                    $disasteroccur->TransNo = G_transactionnumbers::getLastNumberByFormId($formid, date('Y'), date("m"));


                    $id = $disasteroccur->save();
                    $disasteroccur->Id = $id;
                    $disasteroccur->Photo64 = null;
                    G_transactionnumbers::updateLastNumber($formid, date('Y'), date("m"));
                    $result = [
                        'Message' => lang('Form.success'),
                        'Result' => [$disasteroccur],
                        'Status' => ResponseCode::OK
                    ];
                    $this->response->json($result, 200);
                } else {

                    // if(!empty($disasteroccur->Photo64))
                    //     $disasteroccur->Photo64 = $disasteroccur->Photo64;

                    $id = $disasteroccur->save();
                    $disasteroccur->Photo64 = null;
                    $result = [
                        'Message' => lang('Form.success'),
                        'Result' => [$disasteroccur], // cant store back much data
                        'Status' => ResponseCode::OK
                    ];
                    $this->response->json($result, 200);
                }
            }
        } catch(Nayo_Exception $e){
            $result = [
                'Message' => $e->messages,
                'Status' => ResponseCode::INVALID_DATA
            ];
            $this->response->json($result, 400);
        }
        
    }

    public function handle()
    {
        try {
            
            $userid = null;
            $token = $this->response->getHeader('Authorization');
            $jwt = JWT::decode($token, getSecretKey(), array('HS256'));
            if ($jwt) {
                $userid = $jwt->Id;
            }

            $raw = $this->restrequest->getRawBody();
            $body = json_decode($raw);

            $report = T_disasteroccurs::get($body->Id);

            if ($report) {
                $report->M_User_Id = $userid;
                $report->Modified = get_current_date("Y-m-d H:i:s");
                $report->save();

                $result = [
                    'Message' => lang('Form.success'),
                    'Status' => ResponseCode::OK
                ];

                // echo json_encode(sss);
                $this->response->json($result, 200);
            } else {
                Nayo_Exception::throw("Data Tidak Ditemukan", null, ResponseCode::DATA_NOT_FOUND);
            }
        } catch (Nayo_Exception $e) {
            $result = [
                'Message' => $e->messages,
                'Status' => $e->status
            ];

            // echo json_encode(sss);
            $this->response->json($result, 400);
        }
    }
}
