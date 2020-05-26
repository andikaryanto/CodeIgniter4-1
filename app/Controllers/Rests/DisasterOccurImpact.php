<?php

namespace App\Controllers\Rests;

use App\Classes\Exception\EloquentException;
use App\Controllers\Rests\Base_Rest;
use App\Libraries\ResponseCode;
use App\Eloquents\G_transactionnumbers;
use App\Eloquents\M_enumdetails;
use App\Eloquents\M_familycards;
use App\Eloquents\M_forms;
use App\Eloquents\T_disasteroccurs;
use App\Eloquents\T_disasteroccurimpacts;
use App\Eloquents\T_disasterreports;
use App\Libraries\DbTrans;
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
                $occur = T_disasteroccurs::find($occurId);
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
                        $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
                    } else {
                        throw new EloquentException("Tidak Ada Data", null,  ResponseCode::DATA_NOT_FOUND);
                    }
                } else {
                    throw new EloquentException("Tidak Ada Data", null,  ResponseCode::DATA_NOT_FOUND);
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

    public function postDisasterOccurImpact()
    {
        if ($this->isGranted('t_disasteroccur', 'Write')) {
            try {
                DbTrans::beginTransaction();
                $body = $this->restrequest->getJSON();

                

                $disasteroccurimpacts = new T_disasteroccurimpacts();
                $disasteroccurimpacts->M_Impact_Id = $body->M_Impact_Id;
                $disasteroccurimpacts->T_Disasteroccur_Id = $body->T_Disasteroccur_Id;
                $disasteroccurimpacts->Quantity = $body->Quantity;
                $validate = $disasteroccurimpacts->validate();
                if($validate){
                    throw new EloquentException($validate[0], $disasteroccurimpacts, ResponseCode::INVALID_DATA);
                }
                $disasteroccurimpacts->save();

                DbTrans::commit();

                $result = [
                    'Message' => lang('Form.success'),
                    'Result' => $disasteroccurimpacts,
                    'Status' => ResponseCode::OK
                ];

                $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
            } catch (EloquentException $e) {
                DbTrans::rollback();
                $result = [
                    'Message' => $e->messages,
                    'Result' => $e->data,
                    'Status' => $e->status
                ];

                // echo json_encode(sss);
                $this->response->setStatusCode(400)->setJSON($result)->sendBody();;
            }
        }
    }

    public function deleteImpact($id){
        try{

            $impact = T_disasteroccurimpacts::find($id);
            if(!$impact){
                throw new EloquentException("Data Tidak Ada", null, ResponseCode::DATA_NOT_FOUND);
            }

            $impact->delete();
            $result = [
                'Message' => lang('Form.success'),
                'Result' => $impact,
                'Status' => ResponseCode::OK
            ];

            $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
        } catch (EloquentException $e){

            $results = [
                'Message' => $e->messages,
                'Result' => $e->data,
                'Status' => $e->status
            ];

            $this->response->setStatusCode(400)->setJSON($result)->sendBody();;
        }
    }
}
