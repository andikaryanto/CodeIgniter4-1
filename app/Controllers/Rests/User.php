<?php

namespace App\Controllers\Rests;

use App\Classes\Exception\EloquentException;
use App\Controllers\Rests\Base_Rest;
use App\Libraries\ResponseCode;
use App\Eloquents\M_formsettings;
use App\Eloquents\M_userlocations;
use App\Eloquents\M_users;
use App\Eloquents\T_disasteroccurs;
use App\Eloquents\T_disasterreports;
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
                throw new EloquentException(array(0 => lang('Error.failed_login')), null, ResponseCode::INVALID_LOGIN);
            }

            $jwt = JWT::encode($query, getSecretKey());
            $result = [
                'Message' => lang('Info.login_success'),
                'SessionToken' => $jwt,
                'Status' => ResponseCode::OK
            ];
            // $decoded = JWT::decode($jwt, $key, array('HS256')); 
            $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
        } catch (EloquentException $e) {
            $result = [
                'Message' => $e->messages[0],
                'Status' => $e->status
            ];
            $this->response->setStatusCode(400)->setJSON($result)->sendBody();;
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

        $body = $this->restrequest->getJSON();
        

        $params = [
            'where' => [
                'M_User_Id' => $userid
            ]
        ];

        $latestlocation = null;;
        $location = M_userlocations::findOne($params);

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

        $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
    }

    public function getUserLocation()
    {
        try {

            $userid = $this->request->getGet("userid");

            $tracklocation = M_formsettings::getMUserLocation();

            if ($tracklocation->BooleanValue == 0)
                throw new EloquentException("Pengaturan Telusur User Tidak Aktif", null, ResponseCode::FAILED_TRACK_LOCATION);

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
            $locations = M_userlocations::findAll($params);

            if (count($locations) > 0) {
                $data = [];
                foreach ($locations as $location) {

                    $user = M_users::find($location->M_User_Id);
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

                    $occur = T_disasteroccurs::findOne($params);
                    $report = T_disasterreports::findOne($params);
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

                $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
            } else {
                throw new EloquentException("Tidak Ada Data Untuk Ditampilkan", null, ResponseCode::NO_DATA_FOUND);
            }
        } catch (EloquentException $e) {

            $result = [
                'Message' => $e->messages,
                'Status' => $e->status
            ];

            $this->response->setStatusCode(400)->setJSON($result)->sendBody();;
        }
    }

    public function startMoving(){

        $body = $this->restrequest->getJSON();
        

        $userid = null;
        $token = $this->response->getHeader('Authorization');
        $jwt = JWT::decode($token, getSecretKey(), array('HS256'));
        if ($jwt) {
            $userid = $jwt->Id;
        }

        $users = M_users::find($userid);
        $users->IsStartMoving = $body->StartMoving;
        $users->save();

        $result = [
            'Message' => lang('Form.success'),
            'Status' => ResponseCode::OK
        ];

        $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
    }
}
