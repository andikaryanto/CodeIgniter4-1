<?php
namespace App\Controllers\Rests;
use App\Controllers\Rests;
use App\Models\M_users;
use Core\Rest\Response;
use App\Models\M_foods;

class ApiFoods extends Base_Rest {

    public function __construct()
    {
        parent::__construct();
    }

    public function getfoods(){
        
        $page = $this->request->get('page');
        $result = $this->request->get('result');


        if($this->isGranted()){
            
            $entity = new M_foods();
            
                $params = [
                    'order' => [
                        'M_Foodcategory_Id' => 'ASC',
                        'Name' => 'ASC'
                    ]
                ];

                if($page && $result){

                    $params['limit'] = [
                        'page' => $page,
                        'size' => $result
                    ];
                }

                $foods = $entity->findAll($params);
                // echo json_encode($model);
                foreach($foods as $food){
                    $food->Price = money_currency($food->Price);
                    $food->Photos = $food->get_list_M_Foodphoto();
                    $food->Vendor = $food->get_M_Vendor();
                }

            $result = [
                'results' => $foods
            ];

            // echo json_encode($result);
            $this->response->json($result, 200);
           
        } else {
            $return = [
                'message' => lang('Info.failed_logged_in')
            ];
            
            echo json_encode($return);
        }
        
    }

    public function getfoodbyid($id){

        if($this->isGranted()){
            
            $entity = new M_foods();
            
            $foods = $entity->find($id);


            $result = [
                'results' => $foods
            ];

            $this->response->json($result, 200);
           
        } else {
            $return = [
                'message' => lang('Info.failed_logged_in')
            ];
            
            echo json_encode($return);
        }
        
    }
}