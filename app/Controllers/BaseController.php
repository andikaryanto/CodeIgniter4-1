<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use App\Entities\M_FormEntity;
use App\Libraries\Helper;
use CodeIgniter\Config\Services;
use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
		helper(['date','helper','paging','config','inflector','url']);
	}

	public function loadView($url,  $title = "", $datas = array())
    {

        // menu
        $params = array(
            'whereNotIn' => array(
                'FormName' => ['m_companies', 'm_villagedisasters', 'm_livestocks']
            )
        );


        $allmenu = M_FormEntity::getAll($params);
        $master = Helper::arr_filter($allmenu, "ClassName", "Master");
        $setting = Helper::arr_filter($allmenu, "ClassName", "Setting");
        $area = Helper::arr_filter($allmenu, "ClassName", "Master Area");
        $user = Helper::arr_filter($allmenu, "ClassName", "Master User");
        $general = Helper::arr_filter($allmenu, "ClassName", "Master General");
        $infrastructur = Helper::arr_filter($allmenu, "ClassName", "Master Infrastructur");
        $volunteer = Helper::arr_filter($allmenu, "ClassName", "Master Volunteer");
        $item = Helper::arr_filter($allmenu, "ClassName", "Master Item");
        $transaction = Helper::arr_filter($allmenu, "ClassName", "Transaction");
        $broadcast = Helper::arr_filter($allmenu, "ClassName", "Master Broadcast");



        $expandfound = "";
        $usermenu = "";
        foreach ($user as $menu) {
            if (lang($menu->Resource) == $title) {
                $expandfound = "userexpand";
                $usermenu .= "<li class = 'active'><a href='" . base_url($menu->IndexRoute) . "'>" . lang($menu->Resource) . "</a></li>";
            } else {
                $usermenu .= "<li><a href='" . base_url($menu->IndexRoute) . "'>" . lang($menu->Resource) . "</a></li>";
            }
        }

        $generalmenu = "";
        foreach ($general as $menu) {
            if (lang($menu->Resource) == $title) {
                $expandfound = "generalexpand";
                $generalmenu .= "<li class = 'active'><a href='" . base_url($menu->IndexRoute) . "'>" . lang($menu->Resource) . "</a></li>";
            } else {
                $generalmenu .= "<li><a href='" . base_url($menu->IndexRoute) . "'>" . lang($menu->Resource) . "</a></li>";
            }
        }

        $areamenu = "";
        foreach ($area as $menu) {
            if (lang($menu->Resource) == $title) {
                $expandfound = "areaexpand";
                $areamenu .= "<li class = 'active'><a href='" . base_url($menu->IndexRoute) . "'>" . lang($menu->Resource) . "</a></li>";
            } else {
                $areamenu .= "<li><a href='" . base_url($menu->IndexRoute) . "'>" . lang($menu->Resource) . "</a></li>";
            }
        }

        $broadcastmenu = "";
        foreach ($broadcast as $menu) {
            if (lang($menu->Resource) == $title) {
                $expandfound = "broadcastexpand";
                $broadcastmenu .= "<li class = 'active'><a href='" . base_url($menu->IndexRoute) . "'>" . lang($menu->Resource) . "</a></li>";
            } else {
                $broadcastmenu .= "<li><a href='" . base_url($menu->IndexRoute) . "'>" . lang($menu->Resource) . "</a></li>";
            }
        }

        $volunteermenu = "";
        foreach ($volunteer as $menu) {
            if (lang($menu->Resource) == $title) {
                $expandfound = "volunteerexpand";
                $volunteermenu .= "<li class = 'active'><a href='" . base_url($menu->IndexRoute) . "'>" . lang($menu->Resource) . "</a></li>";
            } else {
                $volunteermenu .= "<li><a href='" . base_url($menu->IndexRoute) . "'>" . lang($menu->Resource) . "</a></li>";
            }
        }

        $itemmenu = "";
        foreach ($item as $menu) {
            if (lang($menu->Resource) == $title) {
                $expandfound = "itemexpand";
                $itemmenu .= "<li class = 'active'><a href='" . base_url($menu->IndexRoute) . "'>" . lang($menu->Resource) . "</a></li>";
            } else {
                $itemmenu .= "<li><a href='" . base_url($menu->IndexRoute) . "'>" . lang($menu->Resource) . "</a></li>";
            }
        }

        $transactionmenu = "";
        foreach ($transaction as $menu) {
            if (lang($menu->Resource) == $title) {
                $expandfound = "transactionexpand";
                $transactionmenu .= "<li class = 'active'><a href='" . base_url($menu->IndexRoute) . "'>" . lang($menu->Resource) . "</a></li>";
            } else {
                $transactionmenu .= "<li><a href='" . base_url($menu->IndexRoute) . "'>" . lang($menu->Resource) . "</a></li>";
            }
        }

        $expndas = [
            "userexpand" =>  [$usermenu, "fa fa-user", lang('Form.masteruser')],
            "generalexpand" =>  [$generalmenu, "fa fa-archive", lang('Form.mastergeneral')],
            "areaexpand" =>  [$areamenu, "fa fa-archive", lang('Form.masterarea')],
            "broadcastexpand" =>  [$broadcastmenu, "fa fa-archive", "Master Broadcast"],
            "volunteerexpand" =>  [$volunteermenu, "fa fa-archive", lang('Form.mastervolunteer')],
            "itemexpand" =>  [$itemmenu, "fa fa-archive", lang('Form.masteritem')],
            "transactionexpand" =>  [$transactionmenu, "fa fa-archive", lang('Form.transaction')],
        ];


        $menudata["menu"] = "<div class='main-menu'>
          <h5 class='sidenav-heading'>Main</h5>
          <ul id='side-main-menu' class='side-menu list-unstyled'>                  
            <li><a href='" . base_url('welcome') . "'> <i class='fa fa-map-marked-alt'></i>" . lang('Form.map') . "</a></li>
            <li><a href='#exampledropdownDropdownGeneral' aria-expanded='false' data-toggle='collapse'> <i class='fa fa-cog'></i>" . lang('Form.setting') . "</a>
              <ul id='exampledropdownDropdownGeneral' class='collapse list-unstyled '>
                <li><a href='" . base_url('setting') . "'>" . lang('Form.setting') . "</a></li>
                <li><a href='" . base_url('mcompany') . "'>" . lang('Form.company') . "</a></li>
                <li><a href='" . base_url('msafedistance') . "'>" . lang('Form.safedistance') . "</a></li>
              </ul>
            </li>";

        $menuend = "</ul>
        </div>
        <div class='admin-menu'>
          <h5 class='sidenav-heading'>" . lang('Form.report') . "</h5>
          <ul id='side-admin-menu' class='side-menu list-unstyled'> 
            <li><a href='" . base_url('reports') . "'><i class='icon-interface-windows'></i>" . lang('Form.report') . "</a></li>
          </ul>
        </div>";

        foreach ($expndas as $key => $ex) {
            if ($key == $expandfound) {
                $menudata["menu"] .= "<li class = 'active'><a href='#{$key}' aria-expanded='true' data-toggle='collapse'> <i class='{$ex[1]}'></i>{$ex[2]}</a>
                <ul id='$key' class='collapse list-unstyled show'>
                    $ex[0]
                </ul>
                </li>";
            } else {
                $menudata["menu"] .= "<li ><a href='#{$key}' aria-expanded='false' data-toggle='collapse'> <i class='{$ex[1]}'></i>{$ex[2]}</a>
                <ul id='$key' class='collapse list-unstyled'>
                    $ex[0]
                </ul>
                </li>";
            }
            // $menudata['menu'] = str_replace($key, $ex, $menudata['menu']);
        }
        $menudata['menu'] .= $menuend;
        $menudata['title'] = $title;

        // $session = Session::getInstance();
        $data = array();
        // if($session->get('data')){
        //     $sesdata = $session->get('data');
        //     foreach($datas['model'] as $key => $model){
        //         $datas['model']->$key = $sesdata[$key];
        //     }

        //     $data = $datas;
        // } else {
        //     $data = $datas;
        // }
        view('shared/header', $menudata);
        view($url, $data);
        view('shared/footer', array());
    }

	public function hasPermission($form, $role)
    {
		
        if (empty(Services::session()->get(get_variable() . 'userdata'))) {
            redirect('welcome')->go();
        }

        if (isPermitted_paging($_SESSION[get_variable() . 'userdata']['M_Groupuser_Id'], form_paging()[$form], $role)) {
            return true;
        }
        redirect("Forbidden")->go();
    }

}
