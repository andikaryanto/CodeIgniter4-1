<?php namespace App\Controllers;

use App\Classes\Exception\DbException;
use App\Entities\M_GroupuserEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;
use App\Controllers\BaseController;
use App\Eloquents\M_Groupusers;
use App\Eloquents\M_Villages;
use App\Entities\M_ProvinceEntity;

class Home extends BaseController
{
	public function __construct()
	{
		
	}

	public function insert()
	{
		$ent = new M_Groupusers();
		$ent->GroupName = "Asw";
		$ent->Description = "Njing";
		$ent->save();
		return view('test');
	}

	public function edit()
	{
		$ent = M_Groupusers::find(29);
		$ent->GroupName = "Uwu";
		$ent->Description = "Uwu";
		$ent->save();
		return view('test');
	}

	public function find(){
		try{
			$result = M_Villages::findOrFail(1);
			echo "<br>";
			$params = [
				'where' => [
					'Id' => 1
				]
			];
			$he = $result->hasMany('App\Eloquents\M_Subvillages', 'M_Village_Id', $params);
			$result->Phone = '11111';
			$result->save();
			// echo get_class($result);
			echo json_encode($result);
			echo json_encode($he);
			
			
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

	public function builder(){
		
	}



}
