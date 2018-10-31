<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('master/Jabatan_model',"jabatanModel");
		parent::checkUserRoleMaster(); // check role atau level function
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function

		parent::headerTitle("Master Jabatan","Master Karyawan","Jabatan");

		$breadcrumbs = array(
								"Master Karyawan"	=>	site_url('master/jabatan'),
								"Jabatan"	=>	"",
						);
		parent::breadcrumbs($breadcrumbs);

		parent::viewMaster();
	}

	public function ajax_list()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$columns = array(null,'nama_jabatan');
			$search = array("nama_jabatan");
			$result = $this->jabatanModel->findDataTable(false,false,$columns,$search);
			$data = array();
			foreach ($result as $item) {
				
				/* show button action */
				$btnAction = '<button type="button" onclick="editJabatan('.$item->id.')" class="btn btn btn-outline-warning btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</button> &nbsp;&nbsp;'; // update
			
				$btnAction .='<button type="button" onclick="btnDelete('.$item->id.')" class="btn btn-outline-danger btn-xs"><i class="fa fa-trash-o"></i> Hapus</button>'; // delete

				$item->button_action = $btnAction;
				/* end button action */

				$data[] = $item;
			}
			return $this->jabatanModel->findDataTableOutput($data,false,$search);
		}
		parent::json();
	}

	public function add()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$nama_jabatan = $this->input->post("nama_jabatan");

			$this->form_validation->set_rules("nama_jabatan","Nama Jabatan","trim|required|is_unique[master_jabatan.nama_jabatan]");

			if ($this->form_validation->run() == true) {
				
				$data = array(
							"nama_jabatan"	=>	$nama_jabatan,
						);

				$insert = $this->jabatanModel->insert($data);
				if ($insert) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di tambah..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = "error validate form";
				$this->response->error = array(
									"nama_jabatan"	=> form_error("nama_jabatan",'<span style="color:red;">','</span>')
								);
			}
		}
		parent::json();
	}

	public function getId($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$data = $this->jabatanModel->getById($id);
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
			$nama_jabatan = $this->input->post("nama_jabatan");

			$this->form_validation->set_rules("nama_jabatan","Nama Jabatan","trim|required");

			if ($this->form_validation->run() == true) {
				
				$data = array(
							"id"	=>	$id,
							"nama_jabatan"	=>	$nama_jabatan,
							"updated_at"	=>	date("Y-m-d H:i:s")
						);

				$update = $this->jabatanModel->update($data);
				if ($update) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di update..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = "error validate form";
				$this->response->error = array(
									"nama_jabatan"	=> form_error("nama_jabatan",'<span style="color:red;">','</span>')
								);
			}
		}
		parent::json();
	}

	public function delete($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$delete = $this->jabatanModel->delete($id);
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
			$data = $this->jabatanModel->getAll(false,false,array("nama_jabatan ASC"));
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

/* End of file Jabatan.php */
/* Location: ./application/controllers/master/Jabatan.php */