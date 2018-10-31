<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accountkas extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('master/Account_kas_model',"accountkasModel");
		$this->load->model('laporan/Accountkas_model',"lPkasModel");
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		parent::headerTitle("Master Account Kas","Master Account Kas");

		$breadcrumbs = array(
								"Master Account Kas"	=> 	site_url('master/accountkas'),
							);
		parent::breadcrumbs($breadcrumbs);

		parent::viewMaster();
	}

	public function ajax_list()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {

			$columns = array(null,'nama_kas','no_telp','email','alamat','keterangan');

			$search = array('nama_kas','no_telp','email','alamat','keterangan');

			$result = $this->accountkasModel->findDataTable(false,false,$columns,$search);
			$data = array();
			foreach ($result as $item) {
				$item->no = "<b style='color:black;'>".$item->no."</b>";
				
				$item->saldo = "Rp.0";
				$selectLpKas = array(
										"SUM(masuk) AS total_masuk","SUM(keluar) AS total_keluar"
									);
				$lpKas = $this->lPkasModel->getByWhere(array("kas_id"=>$item->id),$selectLpKas);
				if ($lpKas) {
					$sisa_saldo = ($lpKas->total_masuk - $lpKas->total_keluar);
					$item->saldo = 	"Rp.".number_format($sisa_saldo,0,",",".");
				}

				$item->button_opsi = '<button type="button" onclick="rekapAccountKas('.$item->id.')" class="btn btn btn-outline-info btn-xs m-b-10" title="Rekap data Account kas"><i class="fa fa-list-alt"></i> Rekap</button>'; // rekap saldo account kas
				$btnAction = '<button type="button" onclick="btnEdit('.$item->id.')" class="btn btn btn-outline-warning btn-xs m-b-10" title="Edit"><i class="fa fa-pencil-square-o"></i> </button> &nbsp;'; // update
				$btnAction .='<button type="button" onclick="btnDelete('.$item->id.')" class="btn btn-outline-danger btn-xs m-b-10" title="Hapus"><i class="fa fa-trash-o"></i> </button>'; // delete

				$item->button_action = $btnAction;

				$data[] = $item;
			}
			return $this->accountkasModel->findDataTableOutput($data,false,$search);
		}
		parent::json();
	}

	public function ajax_list_rekap($idKas=null) //ingat kerjakan ini ya kalo udah ingat
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$where = array("kas_id" => $idKas);
			$orderBy = array(null,"tanggal","masuk","keluar","status","info_input","keterangan");
			$search = array("tanggal","masuk","keluar","status","info_input","keterangan");

			$result = $this->lPkasModel->findDataTable($where,false,$orderBy,$search);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";

				if ($item->masuk > 0) {
					$masuk = "Rp.".number_format($item->masuk,0,",",".");
					$item->masuk = "<span style='color:#0bde43;'>".$masuk."</span>";
				}
				if ($item->keluar > 0) {
					$keluar = "Rp.".number_format($item->keluar,0,",",".");
					$item->keluar = "<span style='color:red;'>".$keluar."</span>";
				}

				if ($item->status == "keluar") {
					$item->status = "<span style='color:red;'>".$item->status."</span>";
				} else {
					$item->status = "<span style='color:#0bde43;'>".$item->status."</span>";
				}

				if ($item->info_input == "penjualan") {
					$item->info_input = "<span style='color:#ca195a;'>".$item->info_input."</span>";
				} else if ($item->info_input == "pembelian") {
					$item->info_input = "<span style='color:#1b732a;'>".$item->info_input."</span>";
				} else {
					$item->info_input = "<span style='color:#1976d2;'>".$item->info_input."</span>";
				}

				$data[] = $item;
			}
			return $this->lPkasModel->findDataTableOutput($data,$where,$search);
		}
		parent::json();
	}

	public function inputValidate()
	{
		$this->form_validation->set_rules("no_telp","No Telp","trim|required");
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules("alamat","Alamat","trim|required");
		$this->form_validation->set_rules("keterangan","Keterangan","trim|required");
	}

	public function add()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$nama_kas = $this->input->post("nama_kas");
			$no_telp = $this->input->post("no_telp");
			$email = $this->input->post("email");
			$alamat = $this->input->post("alamat");
			$keterangan = $this->input->post("keterangan");

			$this->form_validation->set_rules("nama_kas","Nama Account Kas","trim|required|is_unique[master_kas.nama_kas]");
			// form validate
			self::inputValidate();

			if ($this->form_validation->run() == true) {

				$data = array(
							"nama_kas"		=>	$nama_kas,
							"no_telp"		=>	$no_telp,
							"email"			=>	$email,
							"alamat"		=>	$alamat,
							"keterangan"	=>	$keterangan
						);

				$insert = $this->accountkasModel->insert($data);
				if ($insert) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di tambah..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
				$this->response->error = array(
									"nama_kas"	=> form_error("nama_kas",'<span style="color:red;">','</span>'),
									"no_telp"	=> form_error("no_telp",'<span style="color:red;">','</span>'),
									"email"	=> form_error("email",'<span style="color:red;">','</span>'),
									"alamat"	=> form_error("alamat",'<span style="color:red;">','</span>'),
									"keterangan"	=> form_error("keterangan",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function getId($id)
	{
		parent::checkLoginUser(); // otoritas authentic function
		// parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			
			$data = $this->accountkasModel->getById($id);
			if ($data) {	

				$data->saldo = "Rp.0";
				$selectLpKas = array(
										"SUM(masuk) AS total_masuk","SUM(keluar) AS total_keluar"
									);
				$lpKas = $this->lPkasModel->getByWhere(array("kas_id"=>$data->id),$selectLpKas);
				if ($lpKas) {
					$sisa_saldo = ($lpKas->total_masuk - $lpKas->total_keluar);
					$data->saldo = $sisa_saldo;
					$data->saldo_rp = 	"Rp.".number_format($sisa_saldo,0,",",".");
				}

				$this->response->status = true;
				$this->response->message = "data get By Id";
				$this->response->data = $data;
			} else {
				$this->response->message = alertDanger("Data tidak ada.");
			}
		}
		parent::json();
	}

	public function getAll()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleKasir(); // check role atau level function

		if ($this->isPost()) {
			$data = $this->accountkasModel->getAll(false,false,array("nama_kas ASC"));
			if ($data) {	
				$this->response->status = true;
				$this->response->message = "data get all";
				$this->response->data = $data;
			} else {
				$this->response->message = alertDanger("Data tidak ada.");
			}
		}
		parent::json();
	}

	public function update($id)
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$nama_kas = $this->input->post("nama_kas");
			$no_telp = $this->input->post("no_telp");
			$email = $this->input->post("email");
			$alamat = $this->input->post("alamat");
			$keterangan = $this->input->post("keterangan");

			$this->form_validation->set_rules("nama_kas","Nama Account Kas","trim|required");
			// form validate
			self::inputValidate();

			if ($this->form_validation->run() == true) {

				$data = array(
							"id"			=>	$id,
							"nama_kas"		=>	$nama_kas,
							"no_telp"		=>	$no_telp,
							"email"			=>	$email,
							"alamat"		=>	$alamat,
							"keterangan"	=>	$keterangan,
							"updated_at" 	=>	date("Y-m-d H:i:s")
						);

				$update = $this->accountkasModel->update($data);
				if ($update) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di update..");
					$this->response->data = $data;
				}
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
				$this->response->error = array(
									"nama_kas"	=> form_error("nama_kas",'<span style="color:red;">','</span>'),
									"no_telp"	=> form_error("no_telp",'<span style="color:red;">','</span>'),
									"email"	=> form_error("email",'<span style="color:red;">','</span>'),
									"alamat"	=> form_error("alamat",'<span style="color:red;">','</span>'),
									"keterangan"	=> form_error("keterangan",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function delete($id)
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$getData = $this->accountkasModel->getById($id);
			if($getData) {
				$delete = $this->accountkasModel->delete($id);
				if ($delete) {
					$this->response->status = true;
					$this->response->message = "<div class='alert alert-success'><i class='fa fa-check'></i>Berhasil hapus data.</div>";
				} else {
					$this->response->message = "<div class='alert alert-danger'><i class='fa fa-ban'></i> Opps, terjadi kesalahan.<br>Mungkin data sudah dihapus pengguna lain.</div>";
				}
			} else {
				$this->response->message = alertDanger("Data tidak ada..!");
			}
		}
		parent::json();
	}

}

/* End of file Accountkas.php */
/* Location: ./application/controllers/master/Accountkas.php */