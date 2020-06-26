<?php

namespace App\Controllers\Rests;

use App\Classes\Exception\EloquentException;
use App\Controllers\Rests\Base_Rest;
use App\Libraries\ResponseCode;
use App\Eloquents\G_transactionnumbers;
use App\Eloquents\M_enumdetails;
use App\Eloquents\M_forms;
use App\Eloquents\T_disasteroccurs;
use App\Eloquents\T_disasterreports;
use App\Libraries\DtTables;
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

            $showImage = $this->request->getGet("showimage");
            $page = $this->request->getGet("page");
            $size = $this->request->getGet("size");
            $params = [
                'order' => [
                    't_disasteroccurs.Created' => 'DESC'
                ],
                'limit' => [
                    'page' => $page,
                    'size' => $size
                ],
                'join' => [
                    'm_subvillages' => [
                        [
                            'key' => 't_disasteroccurs.M_Subvillage_Id = m_subvillages.Id',
                            'type' => 'left'
                        ]
                    ],
                    't_disasterreports' => [
                        [
                            'key' => 't_disasteroccurs.T_Disasterreport_Id = t_disasterreports.Id',
                            'type' => 'left'
                        ]
                    ]
                ]
            ];

            // $disasters = T_disasteroccurs::findAll($params);
            // $occurs = [];

            // foreach ($disasters as $disaster) {
            //     $subvillage = $disaster->get_M_Subvillage();
            //     $village = $subvillage->get_M_Village();
            //     $subdistrict = $village->get_M_Subdistrict();
            //     $district = $subdistrict->get_M_District();
            //     $province = $district->get_M_Province();
            //     $disaster->Noref = $disaster->get_T_Disasterreport()->ReportNo;
            //     $disaster->StatusName = M_enumdetails::findEnumName("DisasterOccurStatus", $disaster->Status);
            //     $disaster->DisasterName = $disaster->get_M_Disaster()->Name;
            //     $disaster->Address = "{$subvillage->Name} {$disaster->RT}/{$disaster->RW}, {$village->Name}, {$subdistrict->Name}, {$district->Name}, {$province->Name}";
            //     if($showImage == "true"){
            //         $disaster->Photo = "data:image/*;charset=utf-8;base64,".$disaster->Photo64;
            //     } else {
                    
            //         $disaster->Photo64 = null;
            //     }
            //     $mdisaster = $disaster->get_M_Disaster();
            //     $disaster->Disaster = $mdisaster;
            //     $disaster->Icon = baseUrl($mdisaster->Icon);
            //     $disaster->Subvillage = $subvillage;
            //     $disaster->Subvillage->Village = $village;
            //     $disaster->Subvillage->Village->Subdistrict =  $subdistrict;
            //     $disaster->Subvillage->Village->Subdistrict->District =  $district;
            //     $disaster->Subvillage->Village->Subdistrict->District->Province = $province;
            // }

            // $occurs = $disasters;

            $datatable = new DtTables($params, false);
            $datatable->eloquent("App\\Eloquents\\T_disasteroccurs");
            $datatable->addColumn("t_disasteroccurs.Id",
                        null,
                        function ($row) {
                            return $row->Id;
                        },
                        false,
                        false)
            ->addColumn('t_disasteroccurs.TransNo',
                        null,
                        function ($row) {
                            return $row->TransNo;
                        })
            ->addColumn('t_disasteroccurs.ReporterName',
                        null,
                        function ($row) {
                            return $row->ReporterName;
                        })
            ->addColumn('t_disasteroccurs.Phone',
                        null,
                        function ($row) {
                            return $row->Phone;
                        })
            
            ->addColumn('m_subvillages.Name.Subvillage',
                        'M_Subvillage_Id',
                        null,
                        function ($row) {
                            return $row->Phone;
                        })
            ->addColumn('t_disasterreports.ReportNo',
                        'T_Disasterreport_Id',
                        null,
                        null,
                        null)
            ->addColumn(
                        't_disasteroccurs.Created',
                        null,
                        null,
                        false
                    );
            ;


            $result = [
                'Message' => lang('Form.success'),
                'Result' => $datatable->populate(),
                'Status' => ResponseCode::OK
            ];

            // echo json_encode(sss);
            
            $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
        } else {
            $result = [
                'Message' => 'Tidak ada akses untuk user anda',
                'Status' => ResponseCode::NO_ACCESS_USER_MODULE
            ];
            
            $this->response->setStatusCode(400)->setJSON($result)->sendBody();;
        }
    }

    public function getDisasteOccurById($id)
    {

        if ($this->isGranted('t_disasteroccur', 'Read')) {

            $disaster = T_disasteroccurs::find($id);

            $subvillage = $disaster->get_M_Subvillage();
            $village = $subvillage->get_M_Village();
            $subdistrict = $village->get_M_Subdistrict();
            $district = $subdistrict->get_M_District();
            $province = $district->get_M_Province();
            $disaster->NeedLogistic = $disaster->IsNeedLogistic == 1 ? "Ya" : "Tidak";
            $disaster->Noref = $disaster->get_T_Disasterreport()->ReportNo;
            $disaster->StatusName = M_enumdetails::findEnumName("DisasterOccurStatus", $disaster->Status);
            $disaster->DisasterName = $disaster->get_M_Disaster()->Name;
            $disaster->Address = "{$subvillage->Name} {$disaster->RT}/{$disaster->RW}, {$village->Name}, {$subdistrict->Name}, {$district->Name}, {$province->Name}";
            // $disaster->Photo64 = base64_decode($disaster->Photo64);

            $result = [
                'Message' => lang('Form.success'),
                'Result' => $disaster,
                'Status' => ResponseCode::OK
            ];

            // echo json_encode(sss);
            
            $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
        } else {
            $result = [
                'Message' => 'Tidak ada akses untuk user anda',
                'Status' => ResponseCode::NO_ACCESS_USER_MODULE
            ];

            // echo json_encode(sss);
            
            $this->response->setStatusCode(400)->setJSON($result)->sendBody();;
        }
    }

    public function postDisasterOccur()
    {

        try{
            if ($this->isGranted('t_disasterreport', 'Write')) {
                
                $token = $this->response->getHeader('authorization');
                $jwt = JWT::decode($token, getSecretKey(), array('HS256'));
                $disasteroccur = null;
                $body = $this->request->getJSON();
    
                if ($body->Id != 0)
                    $disasteroccur = T_disasteroccurs::find($body->Id);
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
                    $formid = M_forms::findDataByName('t_disasteroccurs')->Id;
                    $disasteroccur->Id = null;
                    $disasteroccur->TransNo = G_transactionnumbers::findLastNumberByFormId($formid, date('Y'), date("m"));


                    $id = $disasteroccur->save();
                    $disasteroccur->Id = $id;
                    $disasteroccur->Photo64 = null;
                    G_transactionnumbers::updateLastNumber($formid, date('Y'), date("m"));
                    $result = [
                        'Message' => lang('Form.success'),
                        'Result' => [$disasteroccur],
                        'Status' => ResponseCode::OK
                    ];
                    
                    $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
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
                    $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
                }
            }
        } catch(EloquentException $e){
            $result = [
                'Message' => $e->messages,
                'Status' => ResponseCode::INVALID_DATA
            ];
            $this->response->setStatusCode(400)->setJSON($result)->sendBody();;
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

            $body = $this->request->getJSON();
            

            $report = T_disasteroccurs::find($body->Id);

            if ($report) {
                $report->M_User_Id = $userid;
                $report->Modified = get_current_date("Y-m-d H:i:s");
                $report->save();

                $result = [
                    'Message' => lang('Form.success'),
                    'Status' => ResponseCode::OK
                ];

                // echo json_encode(sss);
                $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
            } else {
                throw new EloquentException("Data Tidak Ditemukan", null, ResponseCode::DATA_NOT_FOUND);
            }
        } catch (EloquentException $e) {
            $result = [
                'Message' => $e->messages,
                'Status' => $e->status
            ];

            // echo json_encode(sss);
            $this->response->setStatusCode(400)->setJSON($result)->sendBody();;
        }
    }
}
