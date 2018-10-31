<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perjalananarmada extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('performa/Armadastatus_model',"statusArmadaModel");
		parent::checkUserRoleSupervisor(); // check role atau level function
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function

		parent::headerTitle("Performa > Perjalanan Armada","Performa","Perjalanan Armada");

		$breadcrumbs = array(
								"Performa"	=> 	site_url('performa/perjalananarmada'),
								"Perjalanan Armada"	=>	"",
							);

		parent::breadcrumbs($breadcrumbs);

		parent::viewPerforma();
	}

	public function ajax_list($status=null)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$select = array("performa_status_armada.*","master_armada.nama","master_armada.photo","master_armada.no_bk");
			$columns = array(null,null,'nama','no_bk');
			$search = array('nama','no_bk');

			$where = false;
			if ($status == "dijalan") {
				$columns[] = "warna_kuning";
				$where = array("performa_status_armada.warna_kuning" => "kuning");
			} elseif ($status == "rusakdijalan") {
				$columns[] = "warna_biru";
				$where = array("performa_status_armada.warna_biru" => "biru");
			}

			$join = array(
							array("master_armada","master_armada.id = performa_status_armada.armada_id","LEFT"),
						);

			$result = $this->statusArmadaModel->findDataTable($where,$select,$columns,$search,$join);
			$data = array();
			foreach ($result as $item) {
				$item->no = "<b style='color:black;'>".$item->no."</b>";
				if($item->photo != ""){
					$item->photo = base_url()."uploads/admin/master/armada/".$item->photo;
				} else {
					$item->photo = base_url()."assets/images/default/no_image.jpg";
				}

				$item->photo = '<div class="img-thumbnail"><center><img src="'.$item->photo.'" class="img img-responsive" style="width:50px; height:50px;"></center></div>';
				
				if ($item->warna_kuning != "") {
					$item->warna_kuning = '<i class="fa fa-check-square-o" style="color:#f3bf06;"></i>';
				} else {
					$item->warna_kuning = '<i class="fa fa-square-o"></i>';
				} 

				if ($item->warna_biru != "") {
					$item->warna_biru = '<i class="fa fa-check-square-o" style="color:blue;"></i>';
				} else {
					$item->warna_biru = '<i class="fa fa-square-o"></i>';
				} 

				if ($status == "dijalan") {
					$btnAction ='<button type="button" onclick="btnCheck('.$item->armada_id.')" class="btn btn-outline-info btn-xs m-b-10" title="Detail"><i class="fa fa-info-circle"></i> Rusak Dijalan</button>'; // checklist
					$item->button_action = $btnAction;
				}

				$data[] = $item;
			}
			return $this->statusArmadaModel->findDataTableOutput($data,$where,$search,$join);
		}
		parent::json();
	}

	public function getId($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$select = array("performa_status_armada.*","master_armada.nama","master_armada.photo","master_armada.no_bk");
			$join = array(
							array("master_armada","master_armada.id = performa_status_armada.armada_id","LEFT"),
						);
			$data = $this->statusArmadaModel->getByWhere(array("performa_status_armada.id" => $id),$select,$join);
			if ($data) {
				$this->response->status = true;
				$this->response->message = "data surat jalan by id";
				$this->response->data = $data;
			} else {
				$this->response->message = alertDanger("Data tidak ada.!");
			}
		}
		parent::json();
	}

	public function getDijalan($armada_id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			
			$checkStatusArmada = $this->statusArmadaModel->getByWhere(array("armada_id"=>$armada_id));
			$statusWarna = "";
			if($checkStatusArmada){
				if ($checkStatusArmada->warna_merah == "merah") {
					$statusWarna = "merah";
				} else if ($checkStatusArmada->warna_kuning == "kuning") {
					$statusWarna = "kuning";
				} else if ($checkStatusArmada->warna_hijau == "hijau") {
					$statusWarna = "hijau";
				} else if ($checkStatusArmada->warna_ungu == "ungu") {
					$statusWarna = "ungu";
				} else if ($checkStatusArmada->warna_biru == "biru") {
					$statusWarna = "biru";
				}
			}

			if($statusWarna == "kuning") { // check werna kuning dari perjalanan armada dan di update menjadi warna biru
				$where = array("armada_id"=>$armada_id,"warna_kuning"=>"kuning");
				$data = array(
								"warna_merah"	=>	"",
								"warna_hijau"	=>	"",
								"warna_ungu"	=>	"",
								"warna_kuning"	=>	"",
								"warna_biru"	=>	"biru",
							);
				$update = $this->statusArmadaModel->updateWhere($where,$data);
				if ($update) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Berhasil pindah Armada");
				} else {
					$this->response->message = alertDanger("Gagal, pindah Armada");
				}	
			} else {
				if ($statusWarna == "merah") {
					$this->response->message = alertWarning("Opps, Maaf Armada yang anda pilih masih berstatus warna merah / sedang stand by.!");
				} else if ($statusWarna == "kuning") {
					$this->response->message = alert("Opps, Maaf Armada yang anda pilih masih berstatus warna kuning / sedang dalam perjalanan.!");
				} else if ($statusWarna == "ungu") {
					$this->response->message = alertInfo("Opps, Maaf Armada yang anda pilih masih berstatus warna ungu / sedang dalam perawatan di bengkel dan belum bisa stand by.!");
				} else if ($statusWarna == "biru") {
					$this->response->message = alertInfo("Opps, Maaf Armada yang anda pilih masih berstatus warna biru / sedang dalam kerusakan di jalan.!");
				}
			}
		}
		parent::json();
	}


}

/* End of file Perjalananarmada.php */
/* Location: ./application/controllers/performa/Perjalananarmada.php */