<?php

namespace App\Controllers;

use App\Controllers\Base_Controller;
use App\Libraries\Session;
use AndikAryanto11\Datatables;
use App\Eloquents\M_userlocations;

class M_userlocation extends Base_Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        if ($this->hasPermission('m_userlocation', 'Read')) {

            $locations = M_userlocations::findAll();
            $model = [];
            foreach($locations as $location){
                $model[] = [
                    'geometry' => [
                        "type" => "Point",
                        "coordinates" => [
                            (double)$location->Longitude,
                            (double)$location->Latitude,
                        ]
                    ],
                    "type" => "Feature", 
                    "properties" => ""
                ];
            }

            $data = setPageData_paging($model);
            $this->loadView('m_userlocation/index', lang('Form.userlocation'), $data);
        }
    }
}