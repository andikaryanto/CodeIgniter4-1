<?php

namespace App\Controllers\Rests;

use App\Controllers\M_user;
use App\Controllers\Rests\Base_Rest;
use App\Libraries\ResponseCode;
use App\Models\G_transactionnumbers;
use App\Models\M_enumdetails;
use App\Models\M_forms;
use App\Models\M_users;
use App\Models\T_disasteroccurs;
use App\Models\T_disasterreports;
use Core\Nayo_Exception;
use Exception;
use Firebase\JWT\JWT;

class DisasterReport extends Base_Rest
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getDisasterReports()
    {

        if ($this->isGranted('t_disasterreport', 'Read')) {

            $params = [
                'order' => [
                    'Created' => 'DESC'
                ]
            ];

            $userid = null;
            $token = $this->response->getHeader('authorization');
            $jwt = JWT::decode($token, getSecretKey(), array('HS256'));
            if ($jwt) {
                $userid = $jwt->Id;
            }

            $disasters = T_disasterreports::getAll($params);
            $occurs = [];

            foreach ($disasters as $disaster) {
                if (!$disaster->isConverted()) {
                    $mdisaster = $disaster->get_M_Disaster();
                    $subvillage = $disaster->get_M_Subvillage();
                    $village = $subvillage->get_M_Village();
                    $subdistrict = $village->get_M_Subdistrict();
                    $district = $subdistrict->get_M_District();
                    $province = $district->get_M_Province();
                    // $disaster->Latitude = (double)$disaster->Latitude;
                    // $disaster->Longitude = (double)$disaster->Longitude;
                    $disaster->ReporterName = $disaster->ReporterName . " - " . $disaster->Phone;
                    $disaster->DisasterName = $mdisaster->Name;
                    $disaster->Address = "{$subvillage->Name} {$disaster->RT}/{$disaster->RW}, {$village->Name}, {$subdistrict->Name}, {$district->Name}, {$province->Name}";
                    if ($userid == $disaster->M_User_Id || $disaster->M_User_Id == null)
                        $disaster->Editable = 1;

                    else {
                        $disaster->Editable = 0;
                    }
                    if ($disaster->M_User_Id) {
                        $disaster->HandledBy = M_users::get($disaster->M_User_Id)->Username;
                    } else {
                        $disaster->HandledBy = "";
                    }
                    $disaster->Photo64 = null;
                    $disaster->Disaster = $disaster->get_M_Disaster();
                    $occurs[] = $disaster;
                }
            }


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

    public function getDisasterReportsByPhone($phone)
    {
        $page = $this->request->get("page");
        $size = $this->request->get("size");
        $where = [
            'where' => [
                'Phone' => $phone
            ],
            "order" => [
                "Created" => "DESC"
            ],
            'limit' => [
                'page' => $page,
                'size' => $size
            ]
        ];
        $disasters = T_disasterreports::getAll($where);
        $occurs = [];

        foreach ($disasters as $disaster) {
            $mdisaster = $disaster->get_M_Disaster();
            $disaster->Disaster = $mdisaster;
            $subvillage = $disaster->get_M_Subvillage();
            $village = $subvillage->get_M_Village();
            $subdistrict = $village->get_M_Subdistrict();
            $district = $subdistrict->get_M_District();
            $province = $district->get_M_Province();
            $disaster->ReporterName = $disaster->ReporterName . " - " . $disaster->Phone;
            $disaster->DisasterName = $mdisaster->Name;
            $disaster->Address = "{$subvillage->Name} {$disaster->RT}/{$disaster->RW}, {$village->Name}, {$subdistrict->Name}, {$district->Name}, {$province->Name}";
            $disaster->Photo64 = null;
            $occurs[] = $disaster;
        }


        $result = [
            'Message' => lang('Form.success'),
            'Result' => $occurs,
            'Status' => ResponseCode::OK
        ];

        // echo json_encode(sss);
        $this->response->json($result, 200);
    }

    public function postDisasterReport()
    {

        // if ($this->isGranted('t_disasterreport', 'Write')) {

        $raw = $this->restrequest->getRawBody();
        $disasterreport = new T_disasterreports();
        // $disasterreport->setMobile();

        $body = json_decode($raw);


        foreach ($body as $k => $v) {
            $disasterreport->$k = $v;
        }

        $disasterreport->DateOccur = get_formated_date($body->DateOccur, "Y-m-d H:i:s");

        // $disasterreport->DateOccur = get_date($disasterreport->DateOccur, "7 hours");

        // $disasterreport->Photo64 = base64_encode($disasterreport->Photo64);
        // $this->response->json($disasterreport, 200);
        $validate = null;
        if(!$this->request->get("public"))
            $validate = $disasterreport->validate();
        if ($validate) {
            $result = [
                'Message' => $validate[0],
                'Status' => ResponseCode::FAILED_SAVE_DATA
            ];
            $this->response->json($result, 400);
        } else {

            $formid = M_forms::getDataByName('t_disasterreports')->Id;

            $disasterreport->ReportNo = G_transactionnumbers::getLastNumberByFormId($formid, date('Y'), date("m"));
            $id = $disasterreport->save();
            if ($id) {
                $disasterreport->Id = $id;
                G_transactionnumbers::updateLastNumber($formid, date('Y'), date("m"));
                $disasterreport->Photo64 = null;
                $result = [
                    'Message' => lang('Form.success'),
                    'Result' => [$disasterreport],
                    'Status' => ResponseCode::OK
                ];
                $this->response->json($result, 200);
            } else {
                $disasterreport->Photo64 = null;
                $result = [
                    'Message' => $validate[0],
                    'Result' => [$disasterreport],
                    'Status' => ResponseCode::FAILED_SAVE_DATA
                ];
                $this->response->json($result, 400);
            }
        }
        // } else {
        //     $result = [
        //         'Message' => 'Tidak ada akses untuk user anda',
        //         'Status' => ResponseCode::NO_ACCESS_USER_MODULE
        //     ];

        //     // echo json_encode(sss);
        //     $this->response->json($result, 400);
        // }
    }

    public function postActualReport()
    {
        $status = array();
        try {
            if ($this->isGranted('t_disasteroccur', 'Write')) {
                $raw = $this->restrequest->getRawBody();
                $body = json_decode($raw);
                if (isset($body->Id)) {
                    $disasterreport = T_disasterreports::get($body->Id);
                    if ($disasterreport) {
                        $disasteroccurs = new T_disasteroccurs();
                        $disasteroccurs->copyFromReport($disasterreport);
                        $formid = M_forms::getDataByName('t_disasteroccurs')->Id;
                        $disasteroccurs->TransNo = G_transactionnumbers::getLastNumberByFormId($formid, date('Y'), date("m"));
                        $disasteroccurs->save();
                        G_transactionnumbers::updateLastNumber($formid, date('Y'), date("m"));

                        $result = [
                            'Message' => lang('Form.success'),
                            'Result' => $disasteroccurs,
                            'Status' => ResponseCode::OK
                        ];
                        $this->response->json($result, 200);
                    } else {
                        Nayo_Exception::throw(array(0 => "Tidak dapat diubah menjadi aktual. Data tidak ada"));
                    }
                } else {
                    Nayo_Exception::throw(array(0 => "Tidak dapat diubah menjadi aktual. Data tidak ada"));
                }
            } else {
                $result = [
                    'Message' => 'Tidak ada akses untuk user anda',
                    'Status' => ResponseCode::NO_ACCESS_USER_MODULE
                ];

                // echo json_encode(sss);
                $this->response->json($result, 400);
            }
        } catch (Nayo_Exception $e) {
            $result = [
                'Message' => $e->messages[0],
                'Status' => ResponseCode::DATA_NOT_FOUND
            ];

            $this->response->json($result, 400);
        }
    }

    public function deleteDisasterReport($id)
    {

        try {
            if ($this->isGranted('t_disasterreport', 'Write')) {

                $disasterreport = T_disasterreports::get($id);
                // $disasterreport->setMobile();

                if (!$disasterreport) {
                    Nayo_Exception::throw(array(0 => 'Data tidak ada'), $disasterreport);
                }

                $disasterreport->delete();
                $result = [
                    'Message' => "Terhapus",
                    'Result' => $disasterreport,
                    'Status' => ResponseCode::OK
                ];
                $this->response->json($result, 200);
            } else {
                $result = [
                    'Message' => 'Tidak ada akses untuk user anda',
                    'Status' => ResponseCode::NO_ACCESS_USER_MODULE
                ];

                // echo json_encode(sss);
                $this->response->json($result, 400);
            }
        } catch (Nayo_Exception $e) {

            $results = [
                'Message' => $e->messages[0],
                'Status' => ResponseCode::DATA_NOT_FOUND
            ];

            $this->response->json($results, 400);
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

            $report = T_disasterreports::get($body->ReportId);

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

    public function getDisasterReportsByNo($reportno)
    {
        $where = [
            'where' => [
                'ReportNo' => str_replace("_", "/", $reportno)
            ]
        ];
        $disasters = T_disasterreports::getOne($where);

        foreach ($disasters as $disaster) {
            $disaster->Photo64 = null;
            $mdisaster = $disaster->get_M_Disaster();
            $subvillage = $disaster->get_M_Subvillage();
            $village = $subvillage->get_M_Village();
            $subdistrict = $village->get_M_Subdistrict();
            $district = $subdistrict->get_M_District();
            $province = $district->get_M_Province();
            $disaster->ReporterName = $disaster->ReporterName . " - " . $disaster->Phone;
            $disaster->DisasterName = $mdisaster->Name;
            $disaster->Address = "{$subvillage->Name} {$disaster->RT}/{$disaster->RW}, {$village->Name}, {$subdistrict->Name}, {$district->Name}, {$province->Name}";
            $occurs[] = $disaster;
        }


        $result = [
            'Message' => lang('Form.success'),
            'Result' => $disasters,
            'Status' => ResponseCode::OK
        ];

        // echo json_encode(sss);
        $this->response->json($result, 200);
    }

    public function getDisasterReportById($id)
    {

        // if ($this->isGranted('t_disasterreport', 'Read')) {

            $disaster = T_disasterreports::get($id);

            $subvillage = $disaster->get_M_Subvillage();
            $village = $subvillage->get_M_Village();
            $subdistrict = $village->get_M_Subdistrict();
            $district = $subdistrict->get_M_District();
            $province = $district->get_M_Province();
            $mdisaster = $disaster->get_M_Disaster();
            $disaster->Disaster = $mdisaster;
            $disaster->DisasterName = $mdisaster->Name;
            $disaster->Address = "{$subvillage->Name} {$disaster->RT}/{$disaster->RW}, {$village->Name}, {$subdistrict->Name}, {$district->Name}, {$province->Name}";
            // $disaster->Photo64 = $disaster->Photo64;

            $result = [
                'Message' => lang('Form.success'),
                'Result' => [$disaster],
                'Status' => ResponseCode::OK
            ];

            // echo json_encode(sss);
            $this->response->json($result, 200);
        // } else {
        //     $result = [
        //         'Message' => 'Tidak ada akses untuk user anda',
        //         'Status' => ResponseCode::NO_ACCESS_USER_MODULE
        //     ];

        //     // echo json_encode(sss);
        //     $this->response->json($result, 400);
        // }
    }
}
