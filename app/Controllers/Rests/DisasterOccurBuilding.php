<?php

namespace App\Controllers\Rests;

use AndikAryanto11\Eloquent;
use App\Classes\Exception\EloquentException;
use App\Controllers\Rests\Base_Rest;
use App\Libraries\ResponseCode;
use App\Eloquents\G_transactionnumbers;
use App\Eloquents\M_enumdetails;
use App\Eloquents\M_familycards;
use App\Eloquents\M_forms;
use App\Eloquents\T_disasteroccurs;
use App\Eloquents\T_disasteroccurbuildings;
use App\Eloquents\T_disasterreports;
use App\Libraries\DbTrans;
use Exception;
use Firebase\JWT\JWT;

class DisasterOccurBuilding extends Base_Rest
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getDisasterOccurBuildings($occurId)
    {

        if ($this->isGranted('t_disasteroccur', 'Read')) {
            try {
                $occur = T_disasteroccurs::find($occurId);
                if ($occur) {
                    if (count($occur->get_list_T_Disasteroccurbuilding()) > 0) {
                        $buildings = [];
                        foreach ($occur->get_list_T_Disasteroccurbuilding() as $building) {


                            $famcard = $building->get_M_Familycard();
                            $subvillage = $famcard->get_M_Subvillage();
                            $village = $subvillage->get_M_Village();
                            $subdistrict = $village->get_M_Subdistrict();
                            $district = $subdistrict->get_M_District();
                            $province = $district->get_M_Province();
                            $building->HeadFamily = $famcard->getHeadFamily();
                            $building->FamilyCardNo = $famcard->FamilyCardNo;
                            $building->Address = "{$subvillage->Name} {$famcard->RT}/{$famcard->RW}, {$village->Name}, {$subdistrict->Name}, {$district->Name}, {$province->Name}";

                            $buildings[] = $building;
                        }

                        $result = [
                            'Message' => lang('Form.success'),
                            'Result' => $buildings,
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
            } catch (Eloquent $e) {
                $result = [
                    'Message' => $e->messages,
                    'Status' => $e->status
                ];

                // echo json_encode(sss);
                $this->response->setStatusCode(400)->setJSON($result)->sendBody();;
            }
        }
    }

    public function postDisasterOccurBuilding()
    {
        if ($this->isGranted('t_disasteroccur', 'Write')) {
            try {
                DbTrans::beginTransaction();
                $body = $this->restrequest->getJSON();

                

                $disasteroccurbuildings = new T_disasteroccurbuildings();
                $disasteroccurbuildings->M_Familycard_Id = $body->M_Familycard_Id;
                $disasteroccurbuildings->T_Disasteroccur_Id = $body->T_Disasteroccur_Id;
                $disasteroccurbuildings->Damage = $body->Damage;
                $disasteroccurbuildings->DamageDescription = $body->DamageDescription;
                $validate = $disasteroccurbuildings->validate();

                $disasteroccurbuildings->save();

                DbTrans::commit();

                $result = [
                    'Message' => lang('Form.success'),
                    'Result' => $disasteroccurbuildings,
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

    public function deleteBuilding($id){
        try{

            $building = T_disasteroccurbuildings::find($id);
            if(!$building){
                throw new EloquentException("Data Tidak Ada", null, ResponseCode::DATA_NOT_FOUND);
            }

            $building->delete();
            $result = [
                'Message' => lang('Form.success'),
                'Result' => $building,
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
