<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('master/Vendor_model',"vendorModel");
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		parent::headerTitle("Master vendor","Master vendor");

		$breadcrumbs = array(
								"Master Vendor"	=> 	site_url('master/vendor'),
							);
		parent::breadcrumbs($breadcrumbs);

		parent::viewMaster();
	}

	public function ajax_list()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {

			$columns = array(null,'nama_vendor','no_telp','email','penyedia','jasa','alamat','keterangan');

			$search = array('nama_vendor','no_telp','email','penyedia','jasa','alamat','keterangan');

			$result = $this->vendorModel->findDataTable(false,false,$columns,$search);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";

				if ($item->penyedia != 0) {
					$item->penyedia = '<i style="color:#ff5722;" class="mdi mdi-checkbox-marked"></i>';
				} else {
					$item->penyedia = '<i class="mdi mdi-checkbox-blank-outline"></i>';
				}

				if ($item->jasa != 0) {
					$item->jasa = '<i style="color:#00bcd4;" class="mdi mdi-checkbox-marked"></i>';
				} else {
					$item->jasa = '<i class="mdi mdi-checkbox-blank-outline"></i>';
				}

				$btnAction = '<button type="button" onclick="editVendor('.$item->id.')" class="btn btn btn-outline-warning btn-xs m-b-10" title="Edit"><i class="fa fa-pencil-square-o"></i> </button> &nbsp;'; // update
				
				$btnAction .='<button type="button" onclick="btnDelete('.$item->id.')" class="btn btn-outline-danger btn-xs m-b-10" title="Hapus"><i class="fa fa-trash-o"></i> </button>'; // delete

				$item->button_action = $btnAction;

				$data[] = $item;
			}
			return $this->vendorModel->findDataTableOutput($data,false,$search);
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
			$nama_vendor = $this->input->post("nama_vendor");
			$no_telp = $this->input->post("no_telp");
			$email = $this->input->post("email");
			$penyedia = $this->input->post("penyedia");
			$jasa = $this->input->post("jasa");
			$alamat = $this->input->post("alamat");
			$keterangan = $this->input->post("keterangan");

			$this->form_validation->set_rules("nama_vendor","Nama Vendor","trim|required|is_unique[master_vendor.nama_vendor]");
			// form validate
			self::inputValidate();

			if ($this->form_validation->run() == true) {

				$data = array(
							"nama_vendor"	=>	$nama_vendor,
							"no_telp"		=>	$no_telp,
							"email"			=>	$email,
							"alamat"		=>	$alamat,
							"keterangan"	=>	$keterangan
						);

				if (!empty($penyedia)) {
					$data["penyedia"]	=	$penyedia;
				}

				if (!empty($jasa)) {
					$data["jasa"]	=	$jasa;
				}

				$insert = $this->vendorModel->insert($data);
				if ($insert) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di tambah..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
				$this->response->error = array(
									"nama_vendor"	=> form_error("nama_vendor",'<span style="color:red;">','</span>'),
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

		if ($this->isPost()) {
			
			$data = $this->vendorModel->getById($id);
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
			
			$data = $this->vendorModel->getAll(false,false,array("nama_vendor ASC"));
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
			$nama_vendor = $this->input->post("nama_vendor");
			$no_telp = $this->input->post("no_telp");
			$email = $this->input->post("email");
			$penyedia = $this->input->post("penyedia");
			$jasa = $this->input->post("jasa");
			$alamat = $this->input->post("alamat");
			$keterangan = $this->input->post("keterangan");

			$this->form_validation->set_rules("nama_vendor","Nama Vendor","trim|required");
			// form validate
			self::inputValidate();

			if ($this->form_validation->run() == true) {

				$data = array(
							"id"			=>	$id,
							"nama_vendor"	=>	$nama_vendor,
							"no_telp"		=>	$no_telp,
							"email"			=>	$email,
							"alamat"		=>	$alamat,
							"keterangan"	=>	$keterangan,
							"updated_at" 	=>	date("Y-m-d H:i:s")
						);

				if (!empty($penyedia)) {
					$data["penyedia"]	=	$penyedia;
				} else {
					$data["penyedia"]	=	0;
				}

				if (!empty($jasa)) {
					$data["jasa"]	=	$jasa;
				} else {
					$data["jasa"]	=	0;
				}

				$update = $this->vendorModel->update($data);
				if ($update) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di update..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
				$this->response->error = array(
									"nama_vendor"	=> form_error("nama_vendor",'<span style="color:red;">','</span>'),
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
			$getData = $this->vendorModel->getById($id);
			if($getData) {
				$delete = $this->vendorModel->delete($id);
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

/* End of file Vendor.php */
/* Location: ./application/controllers/master/Vendor.php */