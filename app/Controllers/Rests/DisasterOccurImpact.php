<?php

namespace App\Controllers\Rests;

use App\Controllers\Rests\Base_Rest;
use App\Libraries\ResponseCode;
use App\Models\G_transactionnumbers;
use App\Models\M_enumdetails;
use App\Models\M_familycards;
use App\Models\M_forms;
use App\Models\T_disasteroccurs;
use App\Models\T_disasteroccurimpacts;
use App\Models\T_disasterreports;
use Core\Database\DbTrans;
use Core\Nayo_Exception;
use Exception;
use Firebase\JWT\JWT;

class DisasterOccurImpact extends Base_Rest
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getDisasterOccurImpacts($occurId)
    {

        if ($this->isGranted('t_disasteroccur', 'Read')) {
            try {
                $occur = T_disasteroccurs::get($occurId);
                if ($occur) {
                    if (count($occur->get_list_T_Disasteroccurimpact()) > 0) {
                        $impacts = [];
                        foreach ($occur->get_list_T_Disasteroccurimpact() as $impact) {

                            $impact->ImpactName = $impact->get_M_Impact()->Name;
                           
                            $impacts[] = $impact;
                        }

                        $result = [
                            'Message' => lang('Form.success'),
                            'Result' => $impacts,
                            'Status' => ResponseCode::OK
                        ];

                        // echo json_encode(sss);
                        $this->response->json($result, 200);
                    } else {
                        Nayo_Exception::throw("Tidak Ada Data", null,  ResponseCode::DATA_NOT_FOUND);
                    }
                } else {
                    Nayo_Exception::throw("Tidak Ada Data", null,  ResponseCode::DATA_NOT_FOUND);
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

    public function postDisasterOccurImpact()
    {
        if ($this->isGranted('t_disasteroccur', 'Write')) {
            try {
                DbTrans::beginTransaction();
                $raw = $this->restrequest->getRawBody();

                $body = json_decode($raw);

                $disasteroccurimpacts = new T_disasteroccurimpacts();
                $disasteroccurimpacts->M_Impact_Id = $body->M_Impact_Id;
                $disasteroccurimpacts->T_Disasteroccur_Id = $body->T_Disasteroccur_Id;
                $disasteroccurimpacts->Quantity = $body->Quantity;
                $validate = $disasteroccurimpacts->validate();
                if($validate){
                    Nayo_Exception::throw($validate[0], $disasteroccurimpacts, ResponseCode::INVALID_DATA);
                }
                $disasteroccurimpacts->save();

                DbTrans::commit();

                $result = [
                    'Message' => lang('Form.success'),
                    'Result' => $disasteroccurimpacts,
                    'Status' => ResponseCode::OK
                ];

                $this->response->json($result, 200);
            } catch (Nayo_Exception $e) {
                DbTrans::rollback();
                $result = [
                    'Message' => $e->messages,
                    'Result' => $e->data,
                    'Status' => $e->status
                ];

                // echo json_encode(sss);
                $this->response->json($result, 400);
            }
        }
    }

    public function deleteImpact($id){
        try{

            $impact = T_disasteroccurimpacts::get($id);
            if(!$impact){
                Nayo_Exception::throw("Data Tidak Ada", null, ResponseCode::DATA_NOT_FOUND);
            }

            $impact->delete();
            $result = [
                'Message' => lang('Form.success'),
                'Result' => $impact,
                'Status' => ResponseCode::OK
            ];

            $this->response->json($result, 200);
        } catch (Nayo_Exception $e){

            $results = [
                'Message' => $e->messages,
                'Result' => $e->data,
                'Status' => $e->status
            ];

            $this->response->json($results, 400);
        }
    }
}
