<?php
namespace App\Controllers\Rests;

use App\Controllers\Rests\Base_Rest;
use App\Models\M_provinces;
use Core\Nayo_Exception;

class ApiMProvince extends Base_Rest {

    public function __construct()
    {
        parent::__construct();
    }

    public function getProvince(){
        $province = M_provinces::getAll();
        $result = [
            'status' => "success",
            'results' => $province
        ];

        // echo json_encode($result);
        $this->response->json($result, 200);
    }

    public function postProvince(){
        $raw = $this->restrequest->getRawBody();
        $province = new M_provinces();

        $body = json_decode($raw);
        foreach($body as $k => $v){
            $province->$k = $v;
        }
        
        try{
            $province->validate();
            $province->save();
            $result = [
                'status' => 'success',
                'result' => lang('Form.datasaved')
            ];

            $this->response->json($result, 200);
        } catch (Nayo_Exception $e){

            $results = [
                'status' => 'failed',
                'error' => 'INVALID_DATA_TO_SAVE',
                'message' => $e->messages
            ];

            $this->response->json($results, 400);
        }
    }

    public function putProvince(){
        $raw = $this->restrequest->getRawBody();
        try{

            $body = json_decode($raw);

            if(!isset($body->Id))
                Nayo_Exception::throw(array(0=>'Data Not Found'), $body);

            $province = M_provinces::get($body->Id);
            if(!$province){
                Nayo_Exception::throw(array(0=>'Data Not Found'), $body);
            }

            foreach($body as $k => $v){
                $province->$k = $v;
            }

            $province->validate();
            $province->save();
            $result = [
                'status' => 'success',
                'result' => lang('Form.datasaved')
            ];

            $this->response->json($result, 200);
        } catch (Nayo_Exception $e){

            $results = [
                'status' => 'failed',
                'error' => 'INVALID_DATA_TO_UPDATE',
                'message' => $e->messages
            ];

            $this->response->json($results, 400);
        }
    }

    public function deleteProvince($id){
        try{

            $province = M_provinces::get($id);
            if(!$province){
                Nayo_Exception::throw(array(0=>'Data Not Found'), $province);
            }

            $province->delete();
            $result = [
                'status' => 'success',
                'result' => lang('Form.datadeleted')
            ];

            $this->response->json($result, 200);
        } catch (Nayo_Exception $e){

            $results = [
                'status' => 'failed',
                'error' => 'INVALID_DATA_TO_DELETE',
                'message' => $e->messages
            ];

            $this->response->json($results, 400);
        }
    }
}