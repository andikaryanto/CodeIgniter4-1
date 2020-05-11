<?php

namespace App\Controllers;

use App\Eloquents\M_capabilities;
use App\Libraries\Nexmo;
use App\Libraries\ResponseCode;
use Core\Libraries\File;
use Core\Database\DBBuilder;
use Core\Libraries\ClsList;
use App\Models\M_users;
use Core\Nayo_Controller;
use Core\Libraries\Dictionary;
use \Firebase\JWT\JWT;
use App\Models\M_groupusers;
use App\Models\M_foods;
use Core\Libraries\Datatables;
// use Core\Libraries\Datatablesnet;
use Core\Database\Table;
use App\Models\M_vendors;
use App\Models\M_enumdetails;
use DateTimeZone;
use App\Models\M_familycards;
use App\Models\M_infrastructures;
use App\Models\M_provinces;
use App\Models\TestModel;
use Core\CLI;
use Core\Database\DbTrans;
use Core\Libraries\Cart;
use Core\Nayo_Exception;
use Core\Session;

class Test extends Base_Controller
{

    public function index()
    {

        // $params = [
        //     'join' => [
        //         'm_infrastructurecategories' => [
        //             'table' => 'm_infrastructures',
        //             'column' => 'M_Infrastructurecategory_Id',
        //             'type' => 'left'
        //         ]
        //     ],
        //     'whereIn' => [
        //         "m_infrastructurecategories.Id" => [1]
        //     ]
        // ];
        // $infra = M_infrastructures::findAll($params);
        // echo json_encode($infra);
        // echo json_encode($_SESSION);

        // $sms = new Nexmo();
        // $sms->to = "6289674392721";
        // $sms->from = "Test";
        // $sms->message = "Test Cuwwkkk";
        // $sms->send();
        // $searchdata = [
        //     [
        //         "Value" => "Name",
        //         "Name" => "Nama"
        //     ],
        //     [
        //         "Value" => "M_Village_Id",
        //         "Name" => "Kelurahan"
        //     ],
        //     [
        //         "Value" => "M_Subdistrict_Id",
        //         "Name" => "Kecamatan"
        //     ],
        //     [
        //         "Value" => "M_District_Id",
        //         "Name" => "Kabupaten"
        //     ],
        //     [
        //         "Value" => "M_Province_Id",
        //         "Name" => "Provinsi"
        //     ]
        // ];
        // // echo json_encode($searchdata);

        // echo formSelect(
        //     M_enumdetails::findEnums("Gender"),
        //     "Value",
        //     "EnumName",
        //     array(
        //       "id" => "Gender",
        //       "class" => "selectpicker form-control",
        //       "name" => "Gender"
        //     )
        // );
        // echo base64_decode('MQ==');
        // echo "a";
        // $cli = new CLI();
        // $cli->migrate();
        // $cli->seed();
        // $g = M_groupusers::find(1);
        // $g->GroupName = "aa";
        // $g->Description = "wjiawjiajwij";
        // echo \json_encode($g);
        // echo \json_encode($g->setToOriginal());
        // $this->view("test/test");
        // echo ResponseCode::class;
        // $test = new ResponseCode();
        // $cart = new Cart();
        // Cart::clear();
        // Cart::add(
        //     [
        //         'id' => 1, 
        //         "qty" => 1, 
        //         "price" => 170000, 
        //         'options' => [
        //             'size' => "XL"
        //         ]
        //      ]
        // );
        // // echo json_encode(Session::find(appKey_config() . "cart"));
        // Cart::add(
        //     [
        //         'id' => 1, 
        //         "qty" => 1, 
        //         "price" => 150000, 
        //         'options' => [
        //             'size' => "L"
        //         ]
        //      ]
        // );
        // Cart::add(
        //     [
        //         'id' => 1, 
        //         "qty" => 1, 
        //         "price" => 170000, 
        //         'options' => [
        //             'size' => "XL"
        //         ]
        //      ]
        // );
        // Cart::add(
        //     [
        //         'id' => 1, 
        //         "qty" => 1, 
        //         "price" => 170000, 
        //         'options' => [
        //             'size' => "XL"
        //         ]
        //      ]
        // );
        // Cart::add(
        //     [
        //         'id' => 1, 
        //         "qty" => 1, 
        //         "price" => 170000, 
        //         'options' => [
        //             'size' => "XL"
        //         ]
        //      ]
        // );
        // Cart::add(
        //     [
        //         'id' => 2, 
        //         "qty" => 1, 
        //         "price" => 90000, 
        //         'options' => [
        //             'size' => "S"
        //         ]
        //      ]
        // );
        // Cart::add(
        //     [
        //         'id' => 2, 
        //         "qty" => 1, 
        //         "price" => 90000, 
        //         'options' => [
        //             'size' => "S"
        //         ]
        //      ]
        // );
        // // Cart::seed();
        // echo json_encode(Cart::collect());
        // echo Cart::total();
        $model = M_capabilities::find(14);

        $result = $model->delete();
        echo $result;

        if (!is_bool($result)) {
            $deletemsg = getDeleteErrorMessage();
            echo json_encode(deleteStatus($deletemsg, FALSE));
        } else {
            if ($result) {
                $deletemsg = getDeleteMessage();
                echo json_encode(deleteStatus($deletemsg));
            }
        }
        
    }

    public function testsave()
    {
        // $str = "http://komputer-pc:8889/Resto/mfoodcategory/getAllData?draw=1&columns%5B0%5D%5Bdata%5D=0&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=1&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B2%5D%5Bdata%5D=2&columns%5B2%5D%5Bname%5D=&columns%5B2%5D%5Bsearchable%5D=true&columns%5B2%5D%5Borderable%5D=true&columns%5B2%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B2%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B3%5D%5Bdata%5D=3&columns%5B3%5D%5Bname%5D=&columns%5B3%5D%5Bsearchable%5D=true&columns%5B3%5D%5Borderable%5D=true&columns%5B3%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B3%5D%5Bsearch%5D%5Bregex%5D=false&order%5B0%5D%5Bcolumn%5D=0&order%5B0%5D%5Bdir%5D=asc&start=0&length=10&search%5Bvalue%5D=&search%5Bregex%5D=false&_=1560223206201";
        // $var = preg_replace('/\/+/', '/', str_replace(['..', './'], ['', '/'], $str));
        // echo $var;
        // $food = new M_foods();
        // foreach($food->findAll() as $all){
        //     echo $all->get_M_Foodcategory()->Name;
        // }
        $params = [
            'where' => [
                'Name' => 'Makanan'
            ]
        ];
        $datatable = new Datatables('M_foodcategories', $params);
        $datatable
            ->addColumn(
                'Id',
                function ($row) {
                    return $row->Id;
                },
                false,
                false
            )
            ->addColumn(
                'Name',
                function ($row) {
                    return "<td><a id =" . $row->Id . " href=" . baseUrl('mfoodcategory/edit/' . $row->Id) . " class = 'text-muted'>$row->Name</a></td>";
                    // return $row->Name;
                }
            )
            ->addColumn(
                'Description',
                function ($row) {
                    return $row->Description;
                }
            )->addColumn(
                'Created',
                function ($row) {
                    return $row->Created;
                }
            )->addColumn(
                'Action',
                function ($row) {
                    return "<td class = 'td-actions text-right'>
                    <a href='#' rel='tooltip' title='" . lang('Form.delete') . "' class='btn-just-icon link-action delete'><i class='fa fa-trash'></i></a>
                  </td>";
                },
                false,
                false
            );

        echo json_encode($datatable->populate());
    }

    public function datatableGet()
    {
        // echo json_encode($_GET);
        $columns = array(

            array('db' => 'Id',  'dt' => 0),
            array(
                'db' => 'Name',
                'dt' => 1,
                'formatter' => function ($d, $row) {
                    return $row->Name;
                    // return "<td><a id =".$row->Id." href=".baseUrl('mfoodcategory/edit/'.$row->Id)." class = 'text-muted'>$d</a></td>";
                }
            ),
            array('db' => 'Description',  'dt' => 2),
            array('db' => 'Created',   'dt' => 3),
            array(
                'db'        => 'Name',
                'dt'        => 4,
                'formatter' => function () {
                    //     return "<td class = 'td-actions text-right'>
                    //     <a href='#' rel='tooltip' title='".lang('Form.delete')."' class='btn-just-icon link-action delete'><i class='fa fa-trash'></i></a>
                    //   </td>";
                    return "";
                }
            )
        );

        $where = array(
            "limit" => [
                'page' => 1,
                'size' => 5
            ]
        );

        // $datatable = new Datatables('m_vendors', $where);
        $vendor = new M_vendors;
        echo json_encode($vendor->findAll($where));
        // echo json_encode($_GET);
        // echo json_encode($datatable->populate($columns));
        // echo json_encode($datatable->collect($model, $columns));

    }

    public function gettest()
    {

        // $db = new M_foodcategories(); 
        // $cat = $db->find(1);
        // $params = [ 
        //     'whereNotIn' => [ 
        //         'Name' => ['Makaroni', 'Indomie']
        //     ],
        //     'order' => [
        //         'Name' => 'ASC'
        //     ]
        // ];
        // foreach($cat->get_list_M_Food($params) as $food){

        //     echo $food->Name;
        // }



    }
}
