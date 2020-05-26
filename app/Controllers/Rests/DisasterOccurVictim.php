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
use App\Eloquents\T_disasteroccurvictims;
use App\Eloquents\T_disasterreports;
use App\Libraries\DbTrans;
use Exception;
use Firebase\JWT\JWT;

class DisasterOccurVictim extends Base_Rest
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getDisasterOccurVictims($occurId)
    {

        if ($this->isGranted('t_disasteroccur', 'Read')) {
            try {
                $occur = T_disasteroccurs::find($occurId);
                if ($occur) {
                    if (count($occur->get_list_T_Disasteroccurvictim()) > 0) {
                        $victims = [];
                        foreach ($occur->get_list_T_Disasteroccurvictim() as $victim) {


                            $famcard = $victim->get_M_Familycard();
                            $subvillage = $famcard->get_M_Subvillage();
                            $village = $subvillage->get_M_Village();
                            $subdistrict = $village->get_M_Subdistrict();
                            $district = $subdistrict->get_M_District();
                            $province = $district->get_M_Province();
                            $victim->HeadFamily = $famcard->getHeadFamily();
                            $victim->FamilyCardNo = $famcard->FamilyCardNo;
                            $victim->Address = "{$subvillage->Name} {$famcard->RT}/{$famcard->RW}, {$village->Name}, {$subdistrict->Name}, {$district->Name}, {$province->Name}";

                            $victims[] = $victim;
                        }

                        $result = [
                            'Message' => lang('Form.success'),
                            'Result' => $victims,
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

    public function postDisasterOccurVictim()
    {
        if ($this->isGranted('t_disasteroccur', 'Write')) {
            try {
                DbTrans::beginTransaction();
                $body = $this->restrequest->getJSON();

                


                if ($body->UseFamilyCard) {
                    $familycard = M_familycards::find($body->M_Familycard_Id);
                    if ($familycard) {
                        foreach ($familycard->get_list_M_Familycardmember() as $detail) {
                            $newdetail = new T_disasteroccurvictims();
                            $newdetail->M_Familycard_Id = $detail->M_Familycard_Id;
                            $newdetail->M_Familycardmember_Id = $detail->Id;
                            $newdetail->T_Disasteroccur_Id = $body->T_Disasteroccur_Id;
                            $newdetail->Name = $detail->CompleteName;
                            $newdetail->NIK = $detail->NIK;
                            $newdetail->Gender = $detail->Gender;
                            $newdetail->BirthPlace = $detail->BirthPlace;
                            $newdetail->BirthDate = $detail->BirthDate;
                            $newdetail->Religion = $detail->Religion;

                            $validate = $newdetail->validate();
                            if ($validate) {
                                throw new EloquentException("Data Sudah Ada", $newdetail, ResponseCode::DATA_EXIST);
                            }

                            $newdetail->save();
                        }
                        
                        
                        DbTrans::commit();
                        $result = [
                            'Message' => lang('Form.success'),
                            // "Result" => $body->FamilycardId,
                            'Status' => ResponseCode::OK
                        ];
                        
                        $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
                    } else { }
                } else {

                    $disasteroccurvictims = new T_disasteroccurvictims();
                    $disasteroccurvictims->M_Familycard_Id = $body->M_Familycard_Id;
                    $disasteroccurvictims->M_Familycardmember_Id = $body->M_Familycardmember_Id;
                    $disasteroccurvictims->T_Disasteroccur_Id = $body->T_Disasteroccur_Id;
                    $disasteroccurvictims->Name = $body->Name;
                    $disasteroccurvictims->NIK = $body->NIK;
                    $disasteroccurvictims->Gender = $body->Gender;
                    $disasteroccurvictims->BirthPlace = $body->BirthPlace;
                    $disasteroccurvictims->BirthDate = $body->BirthDate;
                    $disasteroccurvictims->Religion = $body->Religion;
                    $validate = $disasteroccurvictims->validate();
                    if ($validate) {

                        throw new EloquentException("Data Sudah Ada", $newdetail, ResponseCode::DATA_EXIST);
                    } else {


                        $disasteroccurvictims->save();
                        
                        DbTrans::commit();

                        $result = [
                            'Message' => lang('Form.success'),
                            'Result' => $disasteroccurvictims,
                            'Status' => ResponseCode::OK
                        ];

                        
                        $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
                    }
                }
            } catch (EloquentException $e) {
                DbTrans::rollback();
                $result = [
                    'Message' => $e->messages,
                    'Result' => $e->data,
                    'Status' => $e->status
                ];

                $this->response->setStatusCode(400)->setJSON($result)->sendBody();;
             }
        }
    }

    public function deleteVictim($id){
        try{

            $victim = T_disasteroccurvictims::find($id);
            if(!$victim){
                throw new EloquentException("Data Tidak Ada", null, ResponseCode::DATA_NOT_FOUND);
            }

            $victim->delete();
            $result = [
                'Message' => lang('Form.success'),
                'Result' => $victim,
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
