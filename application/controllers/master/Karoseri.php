<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karoseri extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('master/Karoseri_model',"karoseriModel");
		$this->load->model('master/Karoseri_tipe_model',"tipeModel");
		parent::checkUserRoleMaster(); // check role atau level function
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function

		parent::headerTitle("Master Karoseri dan tipe","Master Armada","Karoseri dan tipe");

		$breadcrumbs = array(
								"Master Armada"	=> 	site_url('master/karoseri'),
								"Karoseri dan tipe"	=>	"",
							);
		parent::breadcrumbs($breadcrumbs);

		parent::viewMaster();
	}

	public function ajax_list_karoseri()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$columns = array(null,'nama_karoseri');
			$search = array("nama_karoseri");
			$result = $this->karoseriModel->findDataTable(false,false,$columns,$search);
			$data = array();
			foreach ($result as $item) {
				
				/* show button action */
				$btnAction = '<button type="button" onclick="editKaroseri('.$item->id.')" class="btn btn btn-outline-warning btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</button> &nbsp;&nbsp;'; // update
			
				$btnAction .='<button type="button" onclick="btnDeleteKaroseri('.$item->id.')" class="btn btn-outline-danger btn-xs"><i class="fa fa-trash-o"></i> Hapus</button>'; // delete

				$item->button_action = $btnAction;
				/* end button action */

				$data[] = $item;
			}
			return $this->karoseriModel->findDataTableOutput($data,false,$search);
		}
		parent::json();
	}

	public function ajax_list_tipe()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$columns = array(null,'tipe_karoseri');
			$search = array("tipe_karoseri");
			$result = $this->tipeModel->findDataTable(false,false,$columns,$search);
			$data = array();
			foreach ($result as $item) {
				
				/* show button action */
				$btnAction = '<button type="button" onclick="editTipe('.$item->id.')" class="btn btn btn-outline-warning btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</button> &nbsp;&nbsp;'; // update
			
				$btnAction .='<button type="button" onclick="btnDeleteTipe('.$item->id.')" class="btn btn-outline-danger btn-xs"><i class="fa fa-trash-o"></i> Hapus</button>'; // delete

				$item->button_action = $btnAction;
				/* end button action */

				$data[] = $item;
			}
			return $this->tipeModel->findDataTableOutput($data,false,$search);
		}
		parent::json();
	}

	public function addKaroseri()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$nama_karoseri = $this->input->post("nama_karoseri");

			$this->form_validation->set_rules("nama_karoseri","Nama Karoseri","trim|required|is_unique[master_karoseri.nama_karoseri]");

			if ($this->form_validation->run() == true) {
				
				$data = array(
							"nama_karoseri"	=>	$nama_karoseri,
						);

				$insert = $this->karoseriModel->insert($data);
				if ($insert) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di tambah..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = "error validate form";
				$this->response->error = array(
									"nama_karoseri"	=> form_error("nama_karoseri",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function getIdKaroseri($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$data = $this->karoseriModel->getById($id);
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

	public function updateKaroseri($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$nama_karoseri = $this->input->post("nama_karoseri");

			$this->form_validation->set_rules("nama_karoseri","Nama karoseri","trim|required");

			if ($this->form_validation->run() == true) {
				
				$data = array(
							"id"	=>	$id,
							"nama_karoseri"	=>	$nama_karoseri,
							"updated_at"	=>	date("Y-m-d H:i:s")
						);

				$update = $this->karoseriModel->update($data);
				if ($update) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di update..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = "error validate form";
				$this->response->error = array(
									"nama_karoseri"	=> form_error("nama_karoseri",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function deleteKaroseri($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$delete = $this->karoseriModel->delete($id);
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


	public function addTipe()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$nama_tipe = $this->input->post("nama_tipe");

			$this->form_validation->set_rules("nama_tipe","Nama Tipe Karoseri","trim|required|is_unique[master_karoseri_tipe.tipe_karoseri]");

			if ($this->form_validation->run() == true) {
				
				$data = array(
							"tipe_karoseri"	=>	$nama_tipe,
						);

				$insert = $this->tipeModel->insert($data);
				if ($insert) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di tambah..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = "error validate form";
				$this->response->error = array(
									"nama_tipe"	=> form_error("nama_tipe",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function getIdTipe($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$data = $this->tipeModel->getById($id);
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

	public function updateTipe($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$nama_tipe = $this->input->post("nama_tipe");

			$this->form_validation->set_rules("nama_tipe","Nama Tipe Karoseri","trim|required");

			if ($this->form_validation->run() == true) {
				
				$data = array(
							"id"	=>	$id,
							"tipe_karoseri"	=>	$nama_tipe,
							"updated_at"	=>	date("Y-m-d H:i:s")
						);

				$update = $this->tipeModel->update($data);
				if ($update) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di update..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = "error validate form";
				$this->response->error = array(
									"nama_tipe"	=> form_error("nama_tipe",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function deleteTipe($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$delete = $this->tipeModel->delete($id);
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


	public function getAllKaroseri()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$getAll = $this->karoseriModel->getAll(false,false,array("nama_karoseri ASC"));
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

	public function getAllTipe()
	{
		parent::checkLoginUser(); // otoritas authentic function
		
		if ($this->isPost()) {
			$getAll = $this->tipeModel->getAll(false,false,array("tipe_karoseri ASC"));
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

/* End of file Karoseri.php */
/* Location: ./application/controllers/master/Karoseri.php */