<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Armada extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('pendapatan/Armada_model',"armadaModel");
		parent::checkUserRoleKasir(); // check role atau level function
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function

		parent::headerTitle("Pendapatan Armada","Pendapatan","Armada");

		$breadcrumbs = array(
								"Pendapatan"	=> 	site_url('pendapatan/armada'),
								"Armada"		=>	"",
							);

		parent::breadcrumbs($breadcrumbs);

		parent::viewPendapatan();
	}

	public function ajax_list_status_armada()
	{
		$this->load->model('performa/Armadastatus_model',"statusArmadaModel");
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$select = array("performa_status_armada.*","master_armada.nama","master_armada.photo","master_armada.no_bk");
			$columns = array(null,null,'nama','no_bk','warna_kuning');
			$search = array('nama','no_bk','warna_kuning');
			$where = array("performa_status_armada.warna_kuning" => "kuning");

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

				$btnAction ='<button type="button" onclick="btnCheck('.$item->armada_id.')" class="btn btn-outline-info btn-xs m-b-10" title="Detail"><i class="fa fa-info-circle"></i> Check</button>'; // checklist
				$item->button_action = $btnAction;
				
				$data[] = $item;
			}
			return $this->statusArmadaModel->findDataTableOutput($data,$where,$search,$join);
		}
		parent::json();
	}

	public function ajax_list()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$select = array("pendapatan_armada.*","master_armada.nama","master_armada.no_bk","master_jadwal.hari","master_jadwal.jam","master_jadwal.tujuan_awal","master_jadwal.tujuan_akhir","master_kas.nama_kas");

			$orderBy = array(null,'pendapatan_armada.tanggal_input','nama','no_bk','hari','jam','tujuan_awal','tujuan_akhir','uang_pendapatan','nama_kas');
			$search = array('pendapatan_armada.tanggal_input','nama','no_bk','hari','jam','tujuan_awal','tujuan_akhir','uang_pendapatan','nama_kas');

			$join = array(
							array("performa_surat_jalan","performa_surat_jalan.id = pendapatan_armada.surat_jalan_id","LEFT"),
							array("master_armada","master_armada.id = performa_surat_jalan.armada_id","LEFT"),
							array("master_jadwal","master_jadwal.id = performa_surat_jalan.jadwal_id","LEFT"),
							array("master_kas","master_kas.id = pendapatan_armada.kas_id","LEFT"),
						);

			$result = $this->armadaModel->findDataTable(false,$select,$orderBy,$search,$join);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";

				$item->tanggal_input = date_ind("d M Y", $item->tanggal_input);

				$item->jam = explode(":", $item->jam);
				$item->jam = $item->jam[0].":".$item->jam[1];

				$item->uang_pendapatan = "Rp.".number_format($item->uang_pendapatan,0,",",".");
				
				/*$btnAction ='<button type="button" onclick="btnDetail('.$item->id.')" class="btn btn-outline-info btn-xs m-b-10" title="Detail"><i class="fa fa-info-circle"></i> Detai</button>'; // delete

				$item->button_action = $btnAction;*/

				$item->nama_kas = '<a href="javasript:void();" title="Datatable rekap account kas" onclick="rekapAccountKas('.$item->kas_id.')">'.$item->nama_kas.'</a>';// rekap saldo account kas

				$data[] = $item;
			}
			return $this->armadaModel->findDataTableOutput($data,false,$search,$join);
		}
		parent::json();
	}


	public function inputForm()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {

			$this->form_validation->set_rules('tgl_surat_jalan', 'Tanggal Surat Jalan', 'trim|required');
			$this->form_validation->set_rules('tanggal_input', 'Tanggal Input', 'trim|required');
			$this->form_validation->set_rules('uang_pendapatan', 'Uang Pendapatan', 'trim|required');
			$this->form_validation->set_rules('account_kas', 'Account Kas', 'trim|required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim');

			$armada_id = $this->input->post('armada_id');
			$tanggal_input = $this->input->post('tanggal_input');
			$surat_jalan_id = $this->input->post('tgl_surat_jalan');
			// $uang_pendapatan = $this->input->post('uang_pendapatan');
			$account_kas = $this->input->post('account_kas');
			// $keterangan = $this->input->post('keterangan');

			if ($this->form_validation->run() == TRUE) {
				$this->load->model('performa/suratjalan_model',"suratjalanModel");
				$checkStatusArmada = $this->suratjalanModel->checkStatusArmada($armada_id);
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
					}
				}

				if($statusWarna == "" || $statusWarna == "kuning") {
					$data = array(
							"tanggal_input"		=>	$tanggal_input,
							"surat_jalan_id"	=>	$surat_jalan_id,
							// "uang_pendapatan"	=>	$uang_pendapatan,
							"kas_id"			=>	$account_kas,
							// "keterangan"		=>	$keterangan,
						);
					$checkDuplicate = $this->armadaModel->getByWhere($data);
					if ($checkDuplicate) {
						$this->response->message = alertDanger("Data yang akan di input sudah ada.!");
					} else {
						$this->response->status = true;
						$this->response->message = spanRed("Data yang di <b><u>Input</u></b> tidak bisa di edit/update lagi.<br>Pastikan anda menginput dengan benar.!");
					}
				} else {
					if ($statusWarna == "merah") {
						$this->response->message = alertWarning("Opps, Maaf Armada yang anda pilih masih berstatus warna merah / sedang stand by.!");
					} else if ($statusWarna == "hijau") {
						$this->response->message = alertSuccess("Opps, Maaf Armada yang anda pilih masih berstatus warna hijau / sedang dalam proses menuju ke bengkel untuk perawatan.!");
					} else if ($statusWarna == "ungu") {
						$this->response->message = alertInfo("Opps, Maaf Armada yang anda pilih masih berstatus warna ungu / sedang dalam perawatan di bengkel dan belum bisa stand by.!");
					}
				}
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
			}	
		}
		parent::json();
	}

	public function insertPendapatanArmada()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$armada_id = $this->input->post('armada_id');
			$tanggal_input = $this->input->post('tanggal_input');
			$surat_jalan_id = $this->input->post('tgl_surat_jalan');
			$uang_pendapatan = $this->input->post('uang_pendapatan');
			$account_kas = $this->input->post('account_kas');
			$keterangan = $this->input->post('keterangan');

			$this->load->model('performa/suratjalan_model',"suratjalanModel");
			$checkStatusArmada = $this->suratjalanModel->checkStatusArmada($armada_id);
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
				}
			}

			if($statusWarna == "" || $statusWarna == "kuning") {
				$data = array(
							"armada_id"			=>	$armada_id,
							"tanggal_input"		=>	$tanggal_input,
							"surat_jalan_id"	=>	$surat_jalan_id,
							"uang_pendapatan"	=>	$uang_pendapatan,
							"kas_id"			=>	$account_kas,
							"keterangan"		=>	$keterangan,
						);

				$dataLpKas = array(
										"tanggal"	=>	$tanggal_input,
										"masuk"		=>	$uang_pendapatan,
										"status"	=>	"masuk",
										"info_input"=>	"pendapatan armada",
										"kas_id"	=>	$account_kas,
										"keterangan"=>	$keterangan,
									);

				$insert = $this->armadaModel->transactionInsert($data,$dataLpKas);
				if ($insert) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Berhasil input pendapatan Armada");
				} else {
					$this->response->message = alertDanger("Gagal, input pendapatan Armada");
				}	
			} else {
				if ($statusWarna == "merah") {
					$this->response->message = alertWarning("Opps, Maaf Armada yang anda pilih masih berstatus warna merah / sedang stand by.!");
				} else if ($statusWarna == "hijau") {
					$this->response->message = alertSuccess("Opps, Maaf Armada yang anda pilih masih berstatus warna hijau / sedang dalam proses menuju ke bengkel untuk perawatan.!");
				} else if ($statusWarna == "ungu") {
					$this->response->message = alertInfo("Opps, Maaf Armada yang anda pilih masih berstatus warna ungu / sedang dalam perawatan di bengkel dan belum bisa stand by.!");
				}
			}
		}
		parent::json();
	}
}

/* End of file Armada.php */
/* Location: ./application/controllers/pendapatan/Armada.php */