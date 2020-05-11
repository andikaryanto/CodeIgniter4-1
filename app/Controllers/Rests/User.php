<?php

namespace App\Controllers\Rests;

use App\Controllers\Rests\Base_Rest;
use App\Libraries\ResponseCode;
use App\Models\M_formsettings;
use App\Models\M_userlocations;
use App\Models\M_users;
use App\Models\T_disasteroccurs;
use App\Models\T_disasterreports;
use Core\Nayo_Exception;
use Firebase\JWT\JWT;

class User extends Base_Rest
{

    public function __construct()
    {
        parent::__construct();
    }

    public function login($username, $password)
    {

        try {

            $query = M_users::login($username, $password);
            if (!$query) {
                Nayo_Exception::throw(array(0 => lang('Error.failed_login')), null, ResponseCode::INVALID_LOGIN);
            }

            $jwt = JWT::encode($query, getSecretKey());
            $result = [
                'Message' => lang('Info.login_success'),
                'SessionToken' => $jwt,
                'Status' => ResponseCode::OK
            ];
            // $decoded = JWT::decode($jwt, $key, array('HS256')); 
            $this->response->json($result, 200);
        } catch (Nayo_Exception $e) {
            $result = [
                'Message' => $e->messages[0],
                'Status' => $e->status
            ];
            $this->response->json($result, 400);
        }
    }

    public function postUserLocation()
    {
        $userid = null;
        $token = $this->response->getHeader('Authorization');
        $jwt = JWT::decode($token, getSecretKey(), array('HS256'));
        if ($jwt) {
            $userid = $jwt->Id;
        }

        $raw = $this->restrequest->getRawBody();
        $body = json_decode($raw);

        $params = [
            'where' => [
                'M_User_Id' => $userid
            ]
        ];

        $latestlocation = null;;
        $location = M_userlocations::getOne($params);

        if ($location) {
            $location->Latitude = $body->Latitude;
            $location->Longitude = $body->Longitude;
            $location->save();
            $latestlocation = $location;
        } else {
            $userlocatoion = new M_userlocations();
            $userlocatoion->M_User_Id = $userid;
            $userlocatoion->Latitude = $body->Latitude;
            $userlocatoion->Longitude = $body->Longitude;
            $userlocatoion->save();
            $latestlocation = $userlocatoion;
        }

        $result = [
            'Message' => "Sukses Update",
            'Data' => $latestlocation,
            'Status' => ResponseCode::OK
        ];

        $this->response->json($result, 200);
    }

    public function getUserLocation()
    {
        try {

            $userid = $this->request->get("userid");

            $tracklocation = M_formsettings::getMUserLocation();

            if ($tracklocation->BooleanValue == 0)
                Nayo_Exception::throw("Pengaturan Telusur User Tidak Aktif", null, ResponseCode::FAILED_TRACK_LOCATION);

            $params = [
                "join" => [
                    "m_users" => [
                        'table' => 'm_userlocations',
                        'column' => 'M_User_Id'
                    ]
                ],
                'where' => [
                    'm_users.IsStartMoving' => 1,
                    'm_users.Id' => $userid
                ]

            ];
            $locations = M_userlocations::getAll($params);

            if (count($locations) > 0) {
                $data = [];
                foreach ($locations as $location) {

                    $user = M_users::get($location->M_User_Id);
                    $params = [
                        'order' => [
                            "Modified" => "DESC"
                        ]
                    ];
                    $reportno = "";
                    $lastActivity = "";
                    $activityType = "";

                    $params = [
                        'where' => [
                            'M_User_Id' => $location->M_User_Id
                        ],
                        'order' => [
                            'Modified' => 'DESC'
                        ]
                        ];

                    $occur = T_disasteroccurs::getOne($params);
                    $report = T_disasterreports::getOne($params);
                    if($occur && $report){
                        $occurdate = get_date($occur->Modified);
                        $reportdate = get_date($report->Modified);

                        if ($occurdate > $reportdate) {
                            $reportno = $occur->TransNo;
                            $activityType = "Kejadian Bencana";
                            $lastActivity = $occur->Modified;
                        }else{
                            $reportno = $report->ReportNo;
                            $activityType = "Laporan Bencana";
                            $lastActivity = $report->Modified;
                        }
                    } else if($occur && $report = null){
                        $reportno = $occur->TransNo;
                        $activityType = "Kejadian Bencana";
                        $lastActivity = $occur->Modified;
                    } else if ($occur = null && $report){
                        $reportno = $report->ReportNo;
                        $activityType = "Laporan Bencana";
                        $lastActivity = $report->Modified;
                    } 

                    $html = "<h3>{$user->Username}</h3><div>Terakhir Aktifitas : {$lastActivity}</div><div>No : {$reportno}</div><div>Tipe Aktifitas : {$activityType}</div>"; 
                    $data[] = [
                        "Id" => $location->M_User_Id,
                        "Data" => [
                            'geometry' => [
                                "type" => "Point",
                                "coordinates" => [
                                    (float) $location->Longitude,
                                    (float) $location->Latitude,
                                ]
                            ],
                            "type" => "Feature",
                            "properties" => [
                                "description" => "{$html}"]
                        ]
                    ];
                }

                $result = [
                    'Message' => lang('Form.success'),
                    'Result' => $data,
                    'Status' => ResponseCode::OK
                ];

                $this->response->json($result, 200);
            } else {
                Nayo_Exception::throw("Tidak Ada Data Untuk Ditampilkan", null, ResponseCode::NO_DATA_FOUND);
            }
        } catch (Nayo_Exception $e) {

            $result = [
                'Message' => $e->messages,
                'Status' => $e->status
            ];

            $this->response->json($result, 400);
        }
    }

    public function startMoving(){

        $raw = $this->restrequest->getRawBody();
        $body = json_decode($raw);

        $userid = null;
        $token = $this->response->getHeader('Authorization');
        $jwt = JWT::decode($token, getSecretKey(), array('HS256'));
        if ($jwt) {
            $userid = $jwt->Id;
        }

        $users = M_users::get($userid);
        $users->IsStartMoving = $body->StartMoving;
        $users->save();

        $result = [
            'Message' => lang('Form.success'),
            'Status' => ResponseCode::OK
        ];

        $this->response->json($result, 200);
    }
}
