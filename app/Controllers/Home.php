<?php namespace App\Controllers;

use App\Classes\Exception\DbException;
use App\Entities\M_GroupuserEntity;
use App\Entities\M_SubvillageEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;
use App\Controllers\BaseController;
use App\Entities\M_ProvinceEntity;
use App\Entities\M_VillageEntity;
use App\Entities\T_DisasteroccurEntity;
use App\Entities\T_DisasterreportEntity;

class Home extends BaseController
{
	public function __construct()
	{
		
	}
	public function insert()
	{
		$ent = new M_GroupuserEntity();
		$ent->GroupName = "Hehe";
		$ent->Description = "Hehe";
		$ent->save();
		return view('test');
	}

	public function edit()
	{
		$ent = M_GroupuserEntity::get(20);
		$ent->GroupName = "AWKAOWKOAWk";
		$ent->Description = "AWKAOWKOAWk";
		$ent->save();
		return view('test');
	}

	public function find(){
		try{
			$result = M_VillageEntity::getOrFail(1);
				// echo get_class($result);
				echo json_encode($result->get_list_M_Subvillage());
			
		} catch(DbException $e){
			echo $e->getMessage();
		}
	}
	public function findAll(){
		try{
			// $params = [
			// 	'limit' => [
			// 		'page' => 1,
			// 		'size' => 2
			// 	]
			// ];
			$result = M_ProvinceEntity::getAll();
			echo json_encode($result);
 
			// foreach($result as $r){
			// 	echo $r->get_M_Village()->Name. "<br>";
			// 	echo $r->get_M_Village()->get_M_Subdistrict()->Name. "<br>";
			// }
		} catch(DatabaseException $e){
			echo $e->getMessage();
		}
	}


}
