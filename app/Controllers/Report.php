<?php

namespace App\Controllers;
use App\Controllers\Base_Controller;
use AndikAryanto11\Datatables;

class Report extends Base_Controller{

    public function index(){
            $this->loadView('reports/index' , lang('Form.report'));
    }

    public function getAllData(){

            
            $datatable = new Datatables('R_reports');
            $datatable
            ->addDtRowClass("rowdetail")
            ->addColumn(
                'Id', 
                function($row){
                    return $row->Id;
                },
                false,
                false
            )->addColumn(
                'Name', 
                function($row){
                    return 
                        formLink($row->Name, array("id" => $row->Id."~a",
                                                    "href" => baseUrl($row->Url),
                                                    "class" => "text-primary"));
                }
            )->addColumn(
                'Description', 
                function($row){
                    return $row->Description;
                }
            );

            echo json_encode($datatable->populate());
    }
}