<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Armadakaryawan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('master/Armada_model',"armadaModel");
	}

	public function getById($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$select = array("master_armada.*","master_merk_chassis.merk","master_tipe_chassis.tipe","master_karoseri.nama_karoseri","master_karoseri_tipe.tipe_karoseri");
			$join = array(
						array("master_merk_chassis","master_merk_chassis.id = master_armada.merk_chassis_id","LEFT"),
						array("master_tipe_chassis","master_tipe_chassis.id = master_armada.tipe_chassis_id","LEFT"),
						array("master_karoseri","master_karoseri.id = master_armada.karoseri_id","LEFT"),
						array("master_karoseri_tipe","master_karoseri_tipe.id = master_armada.tipe_karoseri_id","LEFT"),
					);
			$getDataById = $this->armadaModel->getByWhere(array("master_armada.id" => $id),$select,$join);
			if ($getDataById) {
				$getDataById->lunas_chassis_rp = "Rp.".number_format($getDataById->lunas_chassis,0,",",".");
				$getDataById->dp_chassis_rp = "Rp.".number_format($getDataById->dp_chassis,0,",",".");
				$getDataById->lunas_karoseri_rp = "Rp.".number_format($getDataById->lunas_karoseri,0,",",".");
				$getDataById->dp_karoseri_rp = "Rp.".number_format($getDataById->dp_karoseri,0,",",".");
				$getDataById->total_lunas_rp = "Rp.".number_format($getDataById->total_lunas,0,",",".");

				if ($getDataById->status_beli_chassis == 2) {
					$getDataById->status_beli_chassis_text = "Cicilan / Kredit";
				} else {
					$getDataById->status_beli_chassis_text = "Cash";
				}

				$this->load->model('master/Vendor_model',"vendorModel");

				if ($getDataById->vendor_chassis_id != NULL) {
					$vendor_chassis = $this->vendorModel->getById($getDataById->vendor_chassis_id);
					$getDataById->vendor_chassis = $vendor_chassis->nama_vendor;
				} else {
					$getDataById->vendor_chassis = "Tidak Ada Vendor Chassis";
				}

				if ($getDataById->status_beli_karoseri == 2) {
					$getDataById->status_beli_karoseri_text = "Cicilan / Kredit";
				} else {
					$getDataById->status_beli_karoseri_text = "Cash";
				}

				if ($getDataById->vendor_karoseri_id != NULL) {
					$vendor_karoseri = $this->vendorModel->getById($getDataById->vendor_karoseri_id);
					$getDataById->vendor_karoseri = $vendor_karoseri->nama_vendor;
				} else {
					$getDataById->vendor_karoseri = "Tidak Ada Vendor Karoseri";
				}

				if ($getDataById->ac != 0) {
					$getDataById->ac_icon = '<i style="color:#8bc34a;" class="mdi mdi-checkbox-marked"></i>';
				} else {
					$getDataById->ac_icon = '<i class="mdi mdi-checkbox-blank-outline"></i>';
				}

				if ($getDataById->wifi != 0) {
					$getDataById->wifi_icon = '<i style="color:#03a9f4;" class="mdi mdi-checkbox-marked"></i>';
				} else {
					$getDataById->wifi_icon = '<i class="mdi mdi-checkbox-blank-outline"></i>';
				}

				$this->response->status = true;
				$this->response->message = "Data by id master armada";
				$this->response->data = $getDataById;
			} else {
				$this->response->message = spanRed("Data tidak ada..!");
			}
		}
		parent::json();
	}
}

/* End of file Armadakaryawan.php */
/* Location: ./application/controllers/master/Armadakaryawan.php */