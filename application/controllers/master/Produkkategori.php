<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produkkategori extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('master/Produk_kategori_model',"kategoriModel");
		$this->load->model('master/Produk_unit_model',"unitModel");
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		parent::headerTitle("Master Kategori & Unit Produk","Master Inventori","Kategori & Unit Produk");

		$breadcrumbs = array(
								"Master Inventori"	=> 	site_url('master/produkkategori'),
								"Kategori & Unit Produk"	=>	"",
							);
		parent::breadcrumbs($breadcrumbs);

		parent::viewMaster();
	}

	public function ajax_list_kategori()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$columns = array(null,'kategori');
			$search = array("kategori");
			$result = $this->kategoriModel->findDataTable(false,false,$columns,$search);
			$data = array();
			foreach ($result as $item) {
				
				/* show button action */
				$btnAction = '<button type="button" onclick="editKategori('.$item->id.')" class="btn btn btn-outline-warning btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</button> &nbsp;&nbsp;'; // update
			
				$btnAction .='<button type="button" onclick="btnDeleteKategori('.$item->id.')" class="btn btn-outline-danger btn-xs"><i class="fa fa-trash-o"></i> Hapus</button>'; // delete

				$item->button_action = $btnAction;
				/* end button action */

				$data[] = $item;
			}
			return $this->kategoriModel->findDataTableOutput($data,false,$search);
		}
		parent::json();
	}

	public function ajax_list_unit()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$columns = array(null,'unit');
			$search = array("unit");
			$result = $this->unitModel->findDataTable(false,false,$columns,$search);
			$data = array();
			foreach ($result as $item) {
				
				/* show button action */
				$btnAction = '<button type="button" onclick="editUnit('.$item->id.')" class="btn btn btn-outline-warning btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</button> &nbsp;&nbsp;'; // update
			
				$btnAction .='<button type="button" onclick="btnDeleteUnit('.$item->id.')" class="btn btn-outline-danger btn-xs"><i class="fa fa-trash-o"></i> Hapus</button>'; // delete

				$item->button_action = $btnAction;
				/* end button action */

				$data[] = $item;
			}
			return $this->unitModel->findDataTableOutput($data,false,$search);
		}
		parent::json();
	}

	public function addKategori()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$kategori = $this->input->post("kategori");

			$this->form_validation->set_rules("kategori","Nama Kategori","trim|required|is_unique[master_produk_kategori.kategori]");

			if ($this->form_validation->run() == true) {
				
				$data = array(
							"kategori"	=>	$kategori,
						);

				$insert = $this->kategoriModel->insert($data);
				if ($insert) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di tambah..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = "error validate form";
				$this->response->error = array(
									"kategori"	=> form_error("kategori",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function getIdKategori($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$data = $this->kategoriModel->getById($id);
			if ($data) {				
				$this->response->status = true;
				$this->response->message = "data get By Id";
				$this->response->data = $data;
			} else {
				$this->response->message = alertDanger("Data not found.");
			}
		}
		parent::json();
	}

	public function updateKategori($id)
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$kategori = $this->input->post("kategori");

			$this->form_validation->set_rules("kategori","Nama kategori","trim|required");

			if ($this->form_validation->run() == true) {
				
				$data = array(
							"id"	=>	$id,
							"kategori"	=>	$kategori,
							"updated_at"	=>	date("Y-m-d H:i:s")
						);

				$update = $this->kategoriModel->update($data);
				if ($update) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di update..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = "error validate form";
				$this->response->error = array(
									"kategori"	=> form_error("kategori",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function deleteKategori($id)
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$delete = $this->kategoriModel->delete($id);
			if ($delete) {
				$this->response->status = true;
				$this->response->message = "<div class='alert alert-success'><i class='fa fa-check'></i>Berhasil di delete.</div>";
			} else {
				$this->response->status = false;
				$this->response->message = "<div class='alert alert-danger'><i class='fa fa-ban'></i> Opps, terjadi kesalahan.<br>Mungkin sudah dihapus pengguna lain.</div>";
			}
		}
		parent::json();
	}


	public function addUnit()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$unit = $this->input->post("unit");

			$this->form_validation->set_rules("unit","Nama Unit / Satuan","trim|required|is_unique[master_produk_unit.unit]");

			if ($this->form_validation->run() == true) {
				
				$data = array(
							"unit"	=>	$unit,
						);

				$insert = $this->unitModel->insert($data);
				if ($insert) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di tambah..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = "error validate form";
				$this->response->error = array(
									"unit"	=> form_error("unit",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function getIdUnit($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$data = $this->unitModel->getById($id);
			if ($data) {				
				$this->response->status = true;
				$this->response->message = "data get By Id";
				$this->response->data = $data;
			} else {
				$this->response->message = alertDanger("Data not found.");
			}
		}
		parent::json();
	}

	public function updateUnit($id)
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$unit = $this->input->post("unit");

			$this->form_validation->set_rules("unit","Nama Unit / Satuan","trim|required");

			if ($this->form_validation->run() == true) {
				
				$data = array(
							"id"	=>	$id,
							"unit"	=>	$unit,
							"updated_at"	=>	date("Y-m-d H:i:s")
						);

				$update = $this->unitModel->update($data);
				if ($update) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di update..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = "error validate form";
				$this->response->error = array(
									"unit"	=> form_error("unit",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function deleteUnit($id)
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$delete = $this->unitModel->delete($id);
			if ($delete) {
				$this->response->status = true;
				$this->response->message = "<div class='alert alert-success'><i class='fa fa-check'></i>Berhasil di delete.</div>";
			} else {
				$this->response->status = false;
				$this->response->message = "<div class='alert alert-danger'><i class='fa fa-ban'></i> Opps, terjadi kesalahan.<br>Mungkin sudah dihapus pengguna lain.</div>";
			}
		}
		parent::json();
	}


	public function getAllKategori()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$getAll = $this->kategoriModel->getAll(false,false,array("kategori ASC"));
			if ($getAll) {
				$this->response->status = true;
				$this->response->message = "Data tersedia";
				$this->response->data = $getAll;
			} else {
				$this->response->message = "Data tidak ada.";
			}
		}
		parent::json();
	}

	public function getAllUnit()
	{
		parent::checkLoginUser(); // otoritas authentic function
		
		if ($this->isPost()) {
			$getAll = $this->unitModel->getAll(false,false,array("unit ASC"));
			if ($getAll) {
				$this->response->status = true;
				$this->response->message = "Data tersedia";
				$this->response->data = $getAll;
			} else {
				$this->response->message = "Data tidak ada.";
			}
		}
		parent::json();
	}

}

/* End of file Produkkategori.php */
/* Location: ./application/controllers/master/Produkkategori.php */