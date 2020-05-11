<?php

namespace App\Controllers\Rests;

use App\Controllers\Rests\Base_Rest;
use App\Libraries\ResponseCode;
use App\Models\G_transactionnumbers;
use App\Models\M_enumdetails;
use App\Models\M_familycardmembers;
use App\Models\M_familycards;
use App\Models\M_forms;
use App\Models\T_disasteroccurs;
use App\Models\T_disasterreports;
use Core\Nayo_Exception;
use Exception;
use Firebase\JWT\JWT;

class FamilyCard extends Base_Rest
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getFamilyCard()
    {
        $famcard = [];
        foreach (M_familycards::getAll() as $card) {
            $card->HeadFamilyName = $card->getHeadFamily();
            $famcard[] = $card;
        }


        $result = [
            'Message' => lang('Form.success'),
            'Result' => $famcard,
            'Status' => ResponseCode::OK
        ];

        $this->response->json($result, 200);
    }

    public function getFamilyCardMember()
    {
        try {
            $familycarid = $this->request->get("familycardid");
            $params = [
                'where' => [
                    'M_Familycard_Id' => $familycarid
                ]
            ];
            $member = M_familycardmembers::getAll($params);
            if ($member) {

                $result = [
                    'Message' => lang('Form.success'),
                    'Result' => $member,
                    'Status' => ResponseCode::OK
                ];

                // echo json_encode(sss);
                $this->response->json($result, 200);
            } else {
                Nayo_Exception::throw("Data Tidak Ditemukan", null,  ResponseCode::DATA_NOT_FOUND);
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

    public function getFamilyCardMemberById($id)
    {
        try {
            $member = M_familycardmembers::get($id);
            if ($member) {

                $result = [
                    'Message' => lang('Form.success'),
                    'Result' => $member,
                    'Status' => ResponseCode::OK
                ];

                // echo json_encode(sss);
                $this->response->json($result, 200);
            } else {
                Nayo_Exception::throw("Data Tidak Ditemukan", null,  ResponseCode::DATA_NOT_FOUND);
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

    public function getFamilyCardInOccur($occurId)
    {
        $existcardid = [];
        $famcardmodel = [];
        // $occurId = $this->request->get('occurid');

        if ($occurId > 0) {
            $occur = T_disasteroccurs::get($occurId);
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

        foreach (M_familycards::getAll($params) as $fam) {
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

        // echo json_encode(sss);
        $this->response->json($result, 200);
    }
}
