<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Armadastatus extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('performa/Armadastatus_model',"statusArmadaModel");
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function

		parent::headerTitle("Performa > Armada","Performa","Status Armada");

		$breadcrumbs = array(
								"Performa"	=> 	site_url('performa/armadastatus'),
								"Armada status"	=>	"",
							);

		parent::breadcrumbs($breadcrumbs);

		parent::viewPerforma();
	}

	public function ajax_list()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$select = array("performa_status_armada.*","master_armada.nama","master_armada.photo","master_armada.no_bk");
			$columns = array(null,null,'nama','no_bk','warna_merah','warna_hijau','warna_ungu','warna_kuning','warna_biru');
			$search = array('nama','no_bk','warna_merah','warna_hijau','warna_ungu','warna_kuning','warna_biru');
			$join = array(
							array("master_armada","master_armada.id = performa_status_armada.armada_id","LEFT"),
						);

			$result = $this->statusArmadaModel->findDataTable(false,$select,$columns,$search,$join);
			$data = array();
			foreach ($result as $item) {
				$item->no = "<b style='color:black;'>".$item->no."</b>";
				if($item->photo != ""){
					$item->photo = base_url()."uploads/admin/master/armada/".$item->photo;
				} else {
					$item->photo = base_url()."assets/images/default/no_image.jpg";
				}

				$item->photo = '<div class="img-thumbnail"><center><img src="'.$item->photo.'" class="img img-responsive" style="width:60px; height:60px;"></center></div>';
				
				if ($item->warna_merah != "") {
					$item->warna_merah = '<i class="fa fa-check-square-o text-danger"></i>';
				} else {
					$item->warna_merah = '<i class="fa fa-square-o"></i>';
				} 

				if ($item->warna_hijau != "") {
					$item->warna_hijau = '<i class="fa fa-check-square-o" style="color:#32ef03;"></i>';
				} else {
					$item->warna_hijau = '<i class="fa fa-square-o"></i>';
				} 

				if ($item->warna_ungu != "") {
					$item->warna_ungu = '<i class="fa fa-check-square-o" style="color:#9f07ec;"></i>';
				} else {
					$item->warna_ungu = '<i class="fa fa-square-o"></i>';
				} 

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

				$data[] = $item;
			}
			return $this->statusArmadaModel->findDataTableOutput($data,false,$search,$join);
		}
		parent::json();
	}

	public function armadaStandBy()
	{
		parent::checkLoginUser(); // authtentic login user session
		if (parent::isPost()) {
			$select = array("performa_status_armada.*","master_armada.nama");
			$join = array(
							array("master_armada","master_armada.id = performa_status_armada.armada_id", "LEFT"),
						);
			$armadaStandBy = $this->statusArmadaModel->getAll(array("warna_merah" => "merah"),$select,false,$join);
			if ($armadaStandBy) {
				$this->response->status = true;
				$this->response->message = "Status armada warna merah";
				$this->response->data = $armadaStandBy;
			} else {
				$this->response->message = alertDanger("Opps Maaf, Armada Stand By tidak ada.!");
			}
		}
		parent::json();
	}

	public function allArmadaStandByAjax()
	{
		parent::checkLoginUser(); // user login autentic checking

		if ($this->isPost()) {
			$orderBy = array("nama ASC");
			$where = array("warna_merah" => "merah");
			$select = array("performa_status_armada.*","master_armada.nama","master_armada.no_bk","master_armada.photo");
			$join = array(
							array("master_armada","master_armada.id = performa_status_armada.armada_id", "LEFT"),
						);
			if (!isset($_POST["searchTerm"]) || !empty($_POST["searchTerm"])) {
				$dataArmadaStandBy = $this->statusArmadaModel->getAllSelect2(false,false,$where,$select,$orderBy,$join);
			} else {
				$searchTerm = $this->input->post("searchTerm");
				$dataArmadaStandBy = $this->statusArmadaModel->getAllSelect2(10,array("nama"=>$searchTerm),$where,$select,$orderBy,$join);
			}
			if ($dataArmadaStandBy) {
				$data = array();
				foreach ($dataArmadaStandBy as $val) {
					if($val->photo != ""){
						$val->photo = base_url()."uploads/admin/master/armada/".$val->photo;
					} else {
						$val->photo = base_url()."assets/images/default/no_image.jpg";
					}
					$val->id = $val->armada_id;
					$val->text = "<small>".$val->no_bk."</small><b> - ".$val->nama."</b> <img src='".$val->photo."' style='height: 30px; width: 30px;'>";
				}
				$this->response->status = true;
				$this->response->message = "Data Armada Stand by";
				$this->response->data = $dataArmadaStandBy;
			} else {
				$this->response->message = "Data Armada tidak ada yang stand by";
			}
					
			parent::json();
		}
	}
}

/* End of file Armadastatus.php */
/* Location: ./application/controllers/performa/Armadastatus.php */