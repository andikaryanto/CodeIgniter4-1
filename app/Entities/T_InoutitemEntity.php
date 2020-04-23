<?php

namespace App\Entities;

use App\Classes\Exception\EntityException;
use App\Enums\T_inoutitemsStatus;
use App\Enums\T_inoutitemsType;
use App\Libraries\ResponseCode;
use App\Models\M_forms;
use App\Models\G_transactionnumbers;

class T_InoutitemEntity extends BaseEntity
{

	public $Id;
	public $T_Disasteroccur_Id;
	public $TransNo;
	public $Date;
	public $TransType;
	public $Status;
	public $Description;
	public $CreatedBy;
	public $ModifiedBy;
	public $Created;
	public $Modified;

	protected $table = "t_inoutitems";

	public function __construct()
	{
		parent::__construct();
		$this->Status = T_inoutitemsStatus::NEW;
		$this->Date = get_current_date('d-m-Y H:i');
	}

	public function validate($oldmodel = null)
	{

		$nameexist = false;
		$warning = array();
		return $warning;
	}

	public static function copy(T_InoutitemEntity $model)
	{

		$formid = M_forms::getDataByName('t_inoutitems')->Id;
		$data = new static;
		$data->T_Disasteroccur_Id = $model->T_Disasteroccur_Id;
		$data->TransNo = G_transactionnumbers::getLastNumberByFormId($formid, date('Y'), date("m"));
		$data->Date = get_current_date("Y-m-d");
		$data->TransType = $model->TransType;
		$data->Status = 1;
		$data->Description = $model->Description;
		$id = $data->save();
		$data->Id = $id;
		G_transactionnumbers::updateLastNumber($formid, date('Y'), date("m"));

		foreach ($model->get_list_T_inoutitemdetail() as $detail) {
			$newdetail = new T_inoutitemdetails();
			$newdetail->T_Disasteroccurlogistic_Id = $detail->T_Disasteroccurlogistic_Id;
			$newdetail->T_Inoutitem_Id = $id;
			$newdetail->M_Warehouse_Id = $detail->M_Warehouse_Id;
			$newdetail->M_Item_Id = $detail->M_Item_Id;
			$newdetail->Qty = $detail->Qty;
			$newdetail->Recipient = $detail->Recipient;
			$newdetail->Description = $detail->Description;
			$newdetail->save();
		}

		return $data;
	}

	public function savenew()
	{
		$return = false;
		$formid = M_forms::getDataByName('t_inoutitems')->Id;
		$this->TransNo = G_transactionnumbers::getLastNumberByFormId($formid, date('Y'), date("m"));
		if ($this->TransType == T_inoutitemsType::IN) {
			$this->T_Disasteroccur_Id = null;
		}

		$id = $this->save();

		if ($this->TransType ==  T_inoutitemsType::OUT) {
			if ($this->T_Disasteroccur_Id) {
				$disasteroccur = T_DisasteroccurEntity::get($this->T_Disasteroccur_Id);
				foreach ($disasteroccur->get_list_T_Disasteroccurlogistic() as $logistic) {
					$inoutdetails = new T_inoutitemdetails();
					$inoutdetails->T_Disasteroccurlogistic_Id = $logistic->Id;
					$inoutdetails->T_Inoutitem_Id = $id;
					$inoutdetails->M_Warehouse_Id = $logistic->M_warehouse_Id;
					$inoutdetails->M_Item_Id =  $logistic->M_Item_Id;
					$inoutdetails->Qty = $logistic->Qty;
					$inoutdetails->Recipient = $logistic->Recipient;
					$inoutdetails->save();

					if ($this->Status == T_inoutitemsStatus::RELEASE) {
						$params = [
							'where' => [
								'M_Item_Id' => $logistic->M_Item_Id,
								'M_Warehouse_Id' => $logistic->M_Warehouse_Id,
							]
						];
						$warehouseitem = M_ItemstockEntity::getOne($params);
						if ($warehouseitem) {
							if ($warehouseitem->Qty < $logistic->Qty) {

								throw new EntityException(array(0 => "Qty {$logistic->get_M_Item()->Name} Tidak Cukup"), $this, ResponseCode::INVALID_DATA);
							}

							$warehouseitem->Qty -= $logistic->Qty;
							$warehouseitem->save();
						} else {
							// DbTrans::rollback();
							throw new EntityException(array(0 => "Qty {$logistic->get_M_Item()->Name} Tidak Tersedia"), $this, ResponseCode::INVALID_DATA);
							// break;
						}
					}
				}
			}
		}
		G_transactionnumbers::updateLastNumber($formid, date('Y'), date("m"));
		$return = true;
		return $return;
	}

	public function saveedit($oldmodel){

		$return = false;
		if ($oldmodel->Status == T_inoutitemsStatus::CANCEL) {
			if ($oldmodel->Status == $this->Status) {
				redirect('tinoutitem')->go();
			}
			throw new EntityException([0 => "Status Tidak Bisa Di Ubah"], $oldmodel);
			exit;
		} else {
			if ($this->Status == T_inoutitemsStatus::RELEASE) {
				foreach ($this->get_list_T_Inoutitemdetail() as $detail) {
					$params = [
						'where' => [
							'M_Item_Id' => $detail->M_Item_Id,
							'M_Warehouse_Id' => $detail->M_Warehouse_Id,
						]
					];
					$warehouseitem = M_ItemstockEntity::getOne($params);
					// echo json_encode($warehouseitem);
					if ($this->TransType == T_inoutitemsType::IN) {
						if ($warehouseitem) {
							$warehouseitem->Qty += $detail->Qty;
							$warehouseitem->save();
						} else {
							$newwarehousitem = new M_ItemstockEntity();
							$newwarehousitem->M_Item_Id = $detail->M_Item_Id;
							$newwarehousitem->M_Warehouse_Id = $detail->M_Warehouse_Id;
							$newwarehousitem->Qty += $detail->Qty;
							$newwarehousitem->save();
						}
					} else {
						if ($warehouseitem) {
							if ($warehouseitem->Qty < $detail->Qty) {
								throw new EntityException(array(0 => "Qty {$detail->get_M_Item()->Name} Tidak Cukup"), $this, ResponseCode::INVALID_DATA);
							}

							$warehouseitem->Qty -= $detail->Qty;
							$warehouseitem->save();
						} else {

							throw new EntityException(array(0 => "Qty {$detail->get_M_Item()->Name} Tidak Tersedia"), $oldmodel, ResponseCode::INVALID_DATA);
							exit;
						}
					}
				}

				$this->save();
			} else if ($this->Status == T_inoutitemsStatus::CANCEL) {
				if ($oldmodel->Status == T_inoutitemsStatus::RELEASE) {
					foreach ($this->get_list_T_Inoutitemdetail() as $detail) {
						$params = [
							'where' => [
								'M_Item_Id' => $detail->M_Item_Id,
								'M_Warehouse_Id' => $detail->M_Warehouse_Id,
							]
						];
						$warehouseitem = M_itemstocks::getOne($params);
						if ($this->TransType == T_inoutitemsType::IN) {
							if ($warehouseitem) {
								if ($warehouseitem->Qty < $detail->Qty) {
									throw new EntityException([0 => "Qty {$detail->get_M_Item()->Name} Tidak Cukup Untuk Dibatalkan"], $oldmodel, ResponseCode::INVALID_DATA);
								}

								$warehouseitem->Qty -= $detail->Qty;
								$warehouseitem->save();
							}
						} else {
							if ($warehouseitem) {
								$warehouseitem->Qty += $detail->Qty;
								$warehouseitem->save();
							}
						}
					}
				}
				$oldmodel->Status = T_inoutitemsStatus::CANCEL;
				$oldmodel->save();
			} else {
				$this->save();
			}


			$return = true;
			return $return;
		}
	}

	public function getEnumStatus(){
		if($this->Status == T_inoutitemsStatus::NEW || is_null($this->Status)){
			return M_enumdetailEntity::getEnums("InoutItemStatus");
		} else if ($this->Status == T_inoutitemsStatus::RELEASE) {
			return M_enumdetailEntity::getEnums("InoutItemStatus",[1]);
		}

		return M_enumdetailEntity::getEnums("InoutItemStatus",[1, 2]);
	}
}
