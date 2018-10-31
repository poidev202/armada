<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chassis extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('master/Merk_chassis_model',"merkModel");
		$this->load->model('master/Tipe_chassis_model',"tipeModel");
		parent::checkUserRoleMaster(); // check role atau level function
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function

		parent::headerTitle("Master Merk Chassis dan tipe","Master Armada","Merk Chassis dan tipe");

		$breadcrumbs = array(
								"Master Armada"	=> 	site_url('master/chassis'),
								"merk chassis dan tipe"	=>	"",
							);
		parent::breadcrumbs($breadcrumbs);

		parent::viewMaster();
	}

	public function ajax_list_merk()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$columns = array(null,'merk');
			$search = array("merk");
			$result = $this->merkModel->findDataTable(false,false,$columns,$search);
			$data = array();
			foreach ($result as $item) {
				
				/* show button action */
				$btnAction = '<button type="button" onclick="editMerk('.$item->id.')" class="btn btn btn-outline-warning btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</button> &nbsp;&nbsp;'; // update
			
				$btnAction .='<button type="button" onclick="btnDeleteMerk('.$item->id.')" class="btn btn-outline-danger btn-xs"><i class="fa fa-trash-o"></i> Hapus</button>'; // delete

				$item->button_action = $btnAction;
				/* end button action */

				$data[] = $item;
			}
			return $this->merkModel->findDataTableOutput($data,false,$search);
		}
		parent::json();
	}

	public function ajax_list_tipe()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$columns = array(null,'tipe');
			$search = array("tipe");
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

	public function addMerk()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$merk = $this->input->post("nama_merk");

			$this->form_validation->set_rules("nama_merk","Nama Merk","trim|required|is_unique[master_merk_chassis.merk]");

			if ($this->form_validation->run() == true) {
				
				$data = array(
							"merk"	=>	$merk,
						);

				$insert = $this->merkModel->insert($data);
				if ($insert) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di tambah..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = "error validate form";
				$this->response->error = array(
									"merk"	=> form_error("nama_merk",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function getIdMerk($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$data = $this->merkModel->getById($id);
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

	public function updateMerk($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$merk = $this->input->post("nama_merk");

			$this->form_validation->set_rules("nama_merk","Nama Merk","trim|required");

			if ($this->form_validation->run() == true) {
				
				$data = array(
							"id"	=>	$id,
							"merk"	=>	$merk,
							"updated_at" =>	date("Y-m-d H:i:s")
						);

				$update = $this->merkModel->update($data);
				if ($update) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di update..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = "error validate form";
				$this->response->error = array(
									"merk"	=> form_error("merk",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function deleteMerk($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$delete = $this->merkModel->delete($id);
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
			$tipe = $this->input->post("nama_tipe");

			$this->form_validation->set_rules("nama_tipe","Nama Tipe","trim|required|is_unique[master_tipe_chassis.tipe]");

			if ($this->form_validation->run() == true) {
				
				$data = array(
							"tipe"	=>	$tipe,
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
									"tipe"	=> form_error("nama_tipe",'<span style="color:red;">','</span>'),
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
			$tipe = $this->input->post("nama_tipe");

			$this->form_validation->set_rules("nama_tipe","Nama Tipe","trim|required");

			if ($this->form_validation->run() == true) {
				
				$data = array(
							"id"	=>	$id,
							"tipe"	=>	$tipe,
							"updated_at" =>	date("Y-m-d H:i:s")
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
									"tipe"	=> form_error("tipe",'<span style="color:red;">','</span>'),
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


	public function getAllMerk()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$getAll = $this->merkModel->getAll(false,false,array("merk ASC"));
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
			$getAll = $this->tipeModel->getAll(false,false,array("tipe ASC"));
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

/* End of file Chassis.php */
/* Location: ./application/controllers/master/Chassis.php */