<?php

namespace App\Controllers\Rests;

use App\Classes\Exception\EloquentException;
use App\Controllers\Rests\Base_Rest;
use App\Libraries\ResponseCode;
use App\Eloquents\M_familycardmembers;
use App\Eloquents\M_familycards;
use App\Eloquents\T_disasteroccurs;

class FamilyCard extends Base_Rest
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getFamilyCard()
    {
        $famcard = [];
        foreach (M_familycards::findAll() as $card) {
            $card->HeadFamilyName = $card->getHeadFamily();
            $famcard[] = $card;
        }


        $result = [
            'Message' => lang('Form.success'),
            'Result' => $famcard,
            'Status' => ResponseCode::OK
        ];

        $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
    }

    public function getFamilyCardMember()
    {
        try {
            $familycarid = $this->request->getGet("familycardid");
            $params = [
                'where' => [
                    'M_Familycard_Id' => $familycarid
                ]
            ];
            $member = M_familycardmembers::findAll($params);
            if ($member) {

                $result = [
                    'Message' => lang('Form.success'),
                    'Result' => $member,
                    'Status' => ResponseCode::OK
                ];

                $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
            } else {
                throw new EloquentException("Data Tidak Ditemukan", null,  ResponseCode::DATA_NOT_FOUND);
            }
        } catch (EloquentException $e) {
            $result = [
                'Message' => $e->messages,
                'Status' => $e->status
            ];

            $this->response->setStatusCode(400)->setJSON($result)->sendBody();;
        }
    }

    public function getFamilyCardMemberById($id)
    {
        try {
            $member = M_familycardmembers::find($id);
            if ($member) {

                $result = [
                    'Message' => lang('Form.success'),
                    'Result' => $member,
                    'Status' => ResponseCode::OK
                ];

                $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
            } else {
                throw new EloquentException("Data Tidak Ditemukan", null,  ResponseCode::DATA_NOT_FOUND);
            }
        } catch (EloquentException $e) {
            $result = [
                'Message' => $e->messages,
                'Status' => $e->status
            ];

            $this->response->setStatusCode(400)->setJSON($result)->sendBody();;
        }
    }

    public function getFamilyCardInOccur($occurId)
    {
        $existcardid = [];
        $famcardmodel = [];
        // $occurId = $this->request->get('occurid');

        if ($occurId > 0) {
            $occur = T_disasteroccurs::find($occurId);
            $victims = $occur->get_list_T_Disasteroccurvictim();
            foreach ($victims as $victim) {
                if (!in_array($victim->M_Familycard_Id, $existcardid)) {
                    $existcardid[] = (int)$victim->M_Familycard_Id;
                }
            }
        }

        $params = [
            'whereIn' => [
                'Id' => $existcardid
            ]
        ];

        foreach (M_familycards::findAll($params) as $fam) {
            // if (!in_array($fam->Id, $existcardid)) {
                $fam->HeadFamilyName = $fam->getHeadFamily();
                $famcardmodel[] = $fam;
            // }
        }

        $result = [
            'Message' => lang('Form.success'),
            'Result' => $famcardmodel,
            'Status' => ResponseCode::OK
        ];

        $this->response->setStatusCode(200)->setJSON($result)->sendBody();;
    }
}
