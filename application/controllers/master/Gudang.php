<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gudang extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('master/Gudang_model',"gudangModel");
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		parent::headerTitle("Master gudang","Master Inventori","Gudang");

		$breadcrumbs = array(
								"Master Inventori"	=> 	site_url('master/gudang'),
								"Gudang"	=>	"",
							);

		parent::breadcrumbs($breadcrumbs);

		parent::viewMaster();
	}

	public function ajax_list()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {

			$columns = array(null,'nama_gudang','no_telp','alamat','keterangan');

			$search = array('nama_gudang','no_telp','alamat','keterangan');

			$result = $this->gudangModel->findDataTable(false,false,$columns,$search);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";

				$item->button_opsi = '<button type="button" onclick="rekapGudangProduk('.$item->id.')" class="btn btn btn-outline-info btn-xs m-b-10" title="Rekap produk per gudang"><i class="fa fa-list-alt"></i> Rekap</button>'; // rekap produk

				$btnAction = '<button type="button" onclick="editGudang('.$item->id.')" class="btn btn btn-outline-warning btn-xs m-b-10" title="Edit"><i class="fa fa-pencil-square-o"></i> </button> &nbsp;'; // update
				
				$btnAction .='<button type="button" onclick="btnDelete('.$item->id.')" class="btn btn-outline-danger btn-xs m-b-10" title="Hapus"><i class="fa fa-trash-o"></i> </button>'; // delete

				$item->button_action = $btnAction;

				$data[] = $item;
			}
			return $this->gudangModel->findDataTableOutput($data,false,$search);
		}
		parent::json();
	}

	public function ajax_list_rekap($gudangId=null) // datatable untuk produk per gudang
	{
		parent::checkLoginUser(); // otoritas authentic function
		$this->load->model('master/Produk_model',"produkModel");

		if ($this->isPost()) {

			$where = array("gudang_id" => $gudangId);

			$columns = array(null,'kode','nama_produk',null,'saldo_min','keterangan');
			$search = array('kode','nama_produk','saldo_min','keterangan');

			$result = $this->produkModel->findDataTable($where,false,$columns,$search);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";

				$selectLpGudang = array("laporan_gudang.*","SUM(masuk) AS total_saldo","SUM(keluar) AS saldo_keluar");
				$dataProduk = $this->gudangModel->getSaldoLpGudang(array("produk_id" => $item->id),$selectLpGudang);
				$item->sisa_saldo = "";
				if ($dataProduk) {
					$item->sisa_saldo = ($dataProduk->total_saldo - $dataProduk->saldo_keluar);
				}
				$data[] = $item;
			}
			return $this->produkModel->findDataTableOutput($data,$where,$search);
		}
		parent::json();
	}

	public function inputValidate()
	{
		$this->form_validation->set_rules("no_telp","No Telp","trim|required");
		$this->form_validation->set_rules("alamat","Alamat","trim|required");
		$this->form_validation->set_rules("keterangan","Keterangan","trim|required");
	}

	public function add()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$nama_gudang = $this->input->post("nama_gudang");
			$no_telp = $this->input->post("no_telp");
			$alamat = $this->input->post("alamat");
			$keterangan = $this->input->post("keterangan");

			$this->form_validation->set_rules("nama_gudang","Nama Gudang","trim|required|is_unique[master_gudang.nama_gudang]");
			// form validate
			self::inputValidate();

			if ($this->form_validation->run() == true) {

				$data = array(
							"nama_gudang"	=>	$nama_gudang,
							"no_telp"		=>	$no_telp,
							"alamat"		=>	$alamat,
							"keterangan"	=>	$keterangan
						);

				$insert = $this->gudangModel->insert($data);
				if ($insert) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di tambah..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
				$this->response->error = array(
									"nama_gudang"	=> form_error("nama_gudang",'<span style="color:red;">','</span>'),
									"no_telp"	=> form_error("no_telp",'<span style="color:red;">','</span>'),
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

		if ($this->isPost()) {
			
			$data = $this->gudangModel->getById($id);
			if ($data) {	
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

		if ($this->isPost()) {
			
			$data = $this->gudangModel->getAll(false,false,array("nama_gudang ASC"));
			if ($data) {	
				$this->response->status = true;
				$this->response->message = "data get By Id";
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
			$nama_gudang = $this->input->post("nama_gudang");
			$no_telp = $this->input->post("no_telp");
			$alamat = $this->input->post("alamat");
			$keterangan = $this->input->post("keterangan");

			$this->form_validation->set_rules("nama_gudang","Nama Gudang","trim|required");
			// form validate
			self::inputValidate();

			if ($this->form_validation->run() == true) {

				$data = array(
							"id"			=>	$id,
							"nama_gudang"	=>	$nama_gudang,
							"no_telp"		=>	$no_telp,
							"alamat"		=>	$alamat,
							"keterangan"	=>	$keterangan,
							"updated_at" 	=>	date("Y-m-d H:i:s")
						);

				$update = $this->gudangModel->update($data);
				if ($update) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di update..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
				$this->response->error = array(
									"nama_gudang"	=> form_error("nama_gudang",'<span style="color:red;">','</span>'),
									"no_telp"	=> form_error("no_telp",'<span style="color:red;">','</span>'),
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
			$getData = $this->gudangModel->getById($id);
			if($getData) {
				$delete = $this->gudangModel->delete($id);
				if ($delete) {
					$this->response->status = true;
					$this->response->message = "<div class='alert alert-success'><i class='fa fa-check'></i>Berhasil hapus data.</div>";
				} else {
					$this->response->message = "<div class='alert alert-danger'><i class='fa fa-ban'></i> Opps, terjadi kesalahan.<br>Mungkin sudah dihapus pengguna lain.</div>";
				}
			} else {
				$this->response->message = alertDanger("Data tidak ada..!");
			}
		}
		parent::json();
	}

}

/* End of file Gudang.php */
/* Location: ./application/controllers/master/Gudang.php */