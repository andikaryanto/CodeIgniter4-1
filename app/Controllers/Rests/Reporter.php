<?php

namespace App\Controllers\Rests;

use App\Controllers\Rests\Base_Rest;
use App\Libraries\Nexmo;
use App\Libraries\ResponseCode;
use App\Models\M_publicreporters;
use Core\Rest\Curl;

class Reporter extends Base_Rest
{

    public function __construct()
    {
        parent::__construct();
    }

    public function registerPhone($phonenumber){

        $phone = $phonenumber;
        $params = [
            'where' => [
                'PhoneNumber' => $phone
            ]
        ];

        $rand = randomnumber();
        $reporter = M_publicreporters::getOne($params);
        if($reporter){
            $reporter->PhoneNumber = $phone;
            $reporter->Code = $rand;
            $reporter->save();
        } else {
            $new = new M_publicreporters();
            $new->PhoneNumber = $phone;
            $new->Code = $rand;
            $new->save();
        }

        // $this->sendCode($phone, $rand);

        // $message = "BPBD Sleman, Kode Verifikasi anda : {$rand}";
        // $senddata = array( 
        //     'apikey' => 'de98f78ccbeb3fe6c74a6ca0542203cd',  
        //     'callbackurl' => "",
        //     'datapacket'=>array()
        // );

        // array_push($senddata['datapacket'],array( 'number' => trim($phone), 'message' => $message ));


        // $data=json_encode($senddata);
        // $curl = new Curl("https://sms241.xyz/sms/api_sms_otp_send_json.php");
        // // $curl->url();
        // // $curl->httpVersion();
        // $curl->method("POST");
        // $curl->addHeader('Content-Type', 'application/json');
        // $curl->body($senddata);
        // $res = json_decode($curl->exec(), true);
        // $curl->close();
        // echo \json_encode($senddata);

        // $globalvalid = false;
        // $sendingvalid = false;
        // if(isset($res['sending_respon'])){
        //     foreach($res['sending_respon'] as $key => $v){
        //         if($key == "globalstatus" && $v == 10){
        //             $globalvalid = true;
        //         }
                
        //         if(isset($v['$k'])){
        //             if($key == "datapacket"){
        //                 foreach($v['datapacket'] as $k => $vv){
        //                     if($vv[$k]['sendingstatus'] == 10){
        //                         $sendingvalid  = true;
                                
        //                     }
        //                     break;
        //                 }
        //             }
        //         }
        //     }
        // }

        // if($globalvalid && $sendingvalid){
        //     // echo json_encode($res->glob);
        //     $result = [
        //         'Message' => lang('Form.success'),
        //         'Result' => $phone,
        //         'Status' => ResponseCode::OK
        //     ];
        //     $this->response->json($result, 200);
        // } else {
        //     $result = [
        //         'Message' => "Coba Lagi",
        //         'Result' => $phone,
        //         'Status' => ResponseCode::FAILED_TO_VERIFY
        //     ];
        //     $this->response->json($result, 400);
        // }

        // $nexmo = new Nexmo();
        // $nexmo->to = $phone;
        // $nexmo->from = "BPBD SLEMAN";
        // $nexmo->message = "Kode Verifikasi anda : {$rand} ";
        // $nexmo->send();

        

    }

    private function sendCode($number, $rand){
        ob_start();
        // setting 
        $apikey      = 'de98f78ccbeb3fe6c74a6ca0542203cd'; // api key 
        $urlendpoint = 'https://sms241.xyz/sms/api_sms_otp_send_json.php'; // url endpoint api
        $callbackurl = ''; // url callback get status sms 

        // create header json  
        $senddata = array(
            'apikey' => $apikey,  
            'callbackurl' => $callbackurl, 
            'datapacket'=>array()
        );

        // create detail data json 
        // data 1
        $message="BPBD Sleman, Kode Verifikasi anda : {$rand}";
        array_push($senddata['datapacket'],array(
            'number' => trim($number),
            'message' => $message
        ));
        // sending  
        $data=json_encode($senddata);
        $curlHandle = curl_init($urlendpoint);
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data))
        );
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 30);
        $respon = curl_exec($curlHandle);
        curl_close($curlHandle);

        // $res = json_decode($respon, true);
        // echo \json_encode($res);

        // $globalvalid = false;
        // $sendingvalid = false;
        // if(isset($res['sending_respon'])){
        //     foreach($res['sending_respon'] as $key => $v){
        //         if($key == "globalstatus" && $v == 10){
        //             $globalvalid = true;
        //         }
                
        //         if(isset($v['$k'])){
        //             if($key == "datapacket"){
        //                 foreach($v['datapacket'] as $k => $vv){
        //                     if($vv[$k]['sendingstatus'] == 10){
        //                         $sendingvalid  = true;
                                
        //                     }
        //                     break;
        //                 }
        //             }
        //         }
        //     }
        // }

        // if($globalvalid && $sendingvalid){
            // echo json_encode($res->glob);
            $result = [
                'Message' => lang('Form.success'),
                'Result' => $number,
                'Status' => ResponseCode::OK
            ];
            $this->response->json($result, 200);
        // } else {
        //     $result = [
        //         'Message' => "Coba Lagi",
        //         'Result' => $number,
        //         'Status' => ResponseCode::FAILED_TO_VERIFY
        //     ];
        //     $this->response->json($result, 400);
        // }

    }

    public function verify(){

        $raw = $this->restrequest->getRawBody();
        $body = json_decode($raw);

        $params = [
            'where' => [
                'PhoneNumber' => $body->PhoneNumber,
                'Code' => $body->Code
            ]
        ];

        $reporter = M_publicreporters::getOne($params);
        if($reporter){
            $result = [
                'Message' => lang('Form.success'),
                'Result' => $body->PhoneNumber,
                'Status' => ResponseCode::OK
            ];

            // echo json_encode(sss);
            $this->response->json($result, 200);
        } else {
            $results = [
                'Message' => "Gagal Verifikasi",
                'Status' => ResponseCode::FAILED_TO_VERIFY
            ];

            // echo json_encode(sss);
            $this->response->json($results, 400);
        }

    }

}