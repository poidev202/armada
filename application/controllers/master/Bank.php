<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('master/Bank_model',"bankModel");
		parent::checkUserRoleMaster(); // check role atau level function
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function

		parent::headerTitle("Master Bank","Master Karyawan","Bank");

		$breadcrumbs = array(
								"Master Karyawan"	=>	site_url('master/bank'),
								"Bank"	=>	"",
						);
		parent::breadcrumbs($breadcrumbs);

		parent::viewMaster();
	}

	public function ajax_list()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$columns = array(null,'nama_bank');
			$search = array("nama_bank");
			$result = $this->bankModel->findDataTable(false,false,$columns,$search);
			$data = array();
			foreach ($result as $item) {
				
				/* show button action */
				$btnAction = '<button type="button" onclick="editBank('.$item->id.')" class="btn btn btn-outline-warning btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</button> &nbsp;&nbsp;'; // update
			
				$btnAction .='<button type="button" onclick="btnDelete('.$item->id.')" class="btn btn-outline-danger btn-xs"><i class="fa fa-trash-o"></i> Hapus</button>'; // delete

				$item->button_action = $btnAction;
				/* end button action */

				$data[] = $item;
			}
			return $this->bankModel->findDataTableOutput($data,false,$search);
		}
		parent::json();
	}

	public function add()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$nama_bank = $this->input->post("nama_bank");

			$this->form_validation->set_rules("nama_bank","Nama Bank","trim|required|is_unique[master_bank.nama_bank]");

			if ($this->form_validation->run() == true) {
				
				$data = array(
							"nama_bank"	=>	strtoupper($nama_bank),
						);

				$insert = $this->bankModel->insert($data);
				if ($insert) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di tambah..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = "error validate form";
				$this->response->error = array(
									"nama_bank"	=> form_error("nama_bank",'<span style="color:red;">','</span>')
								);
			}
		}
		parent::json();
	}

	public function getId($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$data = $this->bankModel->getById($id);
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

		if ($this->isPost()) {
			$nama_bank = $this->input->post("nama_bank");

			$this->form_validation->set_rules("nama_bank","Nama Bank","trim|required");

			if ($this->form_validation->run() == true) {
				
				$data = array(
							"id"	=>	$id,
							"nama_bank"	=>	strtoupper($nama_bank),
							"updated_at"	=>	date("Y-m-d H:i:s")
						);

				$update = $this->bankModel->update($data);
				if ($update) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di update..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = "error validate form";
				$this->response->error = array(
									"nama_bank"	=> form_error("nama_bank",'<span style="color:red;">','</span>')
								);
			}
		}
		parent::json();
	}

	public function delete($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$delete = $this->bankModel->delete($id);
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

	public function getAll()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$data = $this->bankModel->getAll(false,false,array("nama_bank ASC"));
			if ($data) {				
				$this->response->status = true;
				$this->response->message = "data get all";
				$this->response->data = $data;
			} else {
				$this->response->message = spanRed("Data tidak ada.");
			}
		}
		parent::json();
	}

}

/* End of file Bank.php */
/* Location: ./application/controllers/master/Bank.php */