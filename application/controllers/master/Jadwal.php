<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('master/Jadwal_model',"jadwalModel");
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		parent::headerTitle("Master Jadwal","Master Jadwal","Jadwal & Jalan");

		$breadcrumbs = array(
								"Master Jadwal"		=> 	site_url('master/jadwal'),
								"Jadwal & Jalan"	=>	"",
							);

		parent::breadcrumbs($breadcrumbs);

		parent::viewMaster();
	}

	public function ajax_list($hari=false)
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {

			$where = false;
			if ($hari) {
				$where = array("hari" => $hari);
			}

			$columns = array(null,'hari','jam','tujuan_awal','tujuan_akhir');

			$search = array('hari','jam','tujuan_awal','tujuan_akhir');

			$result = $this->jadwalModel->findDataTable($where,false,$columns,$search);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";

				$item->hari = ucfirst($item->hari);

				$jam = explode(":", $item->jam);
				$item->jam_menit = $jam[0].":".$jam[1];

				$btnAction = '<button type="button" onclick="editJadwal('.$item->id.')" class="btn btn btn-outline-warning btn-xs m-b-10" title="Edit"><i class="fa fa-pencil-square-o"></i> </button> &nbsp;'; // update
				
				$btnAction .='<button type="button" onclick="btnDelete('.$item->id.')" class="btn btn-outline-danger btn-xs m-b-10" title="Hapus"><i class="fa fa-trash-o"></i> </button>'; // delete

				$item->button_action = $btnAction;

				$data[] = $item;
			}
			return $this->jadwalModel->findDataTableOutput($data,$where,$search);
		}
		parent::json();
	}

	public function inputValidate()
	{
		$this->form_validation->set_rules('hari', 'Hari', 'trim|required');
		$this->form_validation->set_rules("jam","Jam","trim|required");
		$this->form_validation->set_rules("tujuan_awal","Tujuan Awal","trim|required");
		$this->form_validation->set_rules("tujuan_akhir","Tujuan Akhir","trim|required");
	}

	public function add()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$hari = $this->input->post("hari");
			$jam = $this->input->post("jam");
			$tujuan_awal = $this->input->post("tujuan_awal");
			$tujuan_akhir = $this->input->post("tujuan_akhir");
			// form validate
			self::inputValidate();

			if ($this->form_validation->run() == true) {

				$where = array(
							"hari"			=>	$hari,
							"jam"			=>	$jam,
							"tujuan_awal"	=>	ucfirst($tujuan_awal),
							"tujuan_akhir"	=>	ucfirst($tujuan_akhir),
						);
				$checkData = $this->jadwalModel->getByWhere($where);
				if($checkData) {
					$jam = explode(":", $checkData->jam);
					$checkData->jam_menit = $jam[0].":".$jam[1];

					$this->response->message = alertDanger("Data jadwal sudah terdaftar.!");
					$this->response->data = $checkData;
					$this->response->error = array("duplicate" => true);
				} else {
					$data = array(
								"hari"			=>	$hari,
								"jam"			=>	$jam,
								"tujuan_awal"	=>	ucfirst($tujuan_awal),
								"tujuan_akhir"	=>	ucfirst($tujuan_akhir),
							);

					$insert = $this->jadwalModel->insert($data);
					if ($insert) {
						$this->response->status = true;
						$this->response->message = alertSuccess("Data berhasil di tambah..");
						$this->response->data = $data;
					}
				}
				
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
				$this->response->error = array(
									"hari"	=> form_error("hari",'<span style="color:red;">','</span>'),
									"jam"	=> form_error("jam",'<span style="color:red;">','</span>'),
									"tujuan_awal"	=> form_error("tujuan_awal",'<span style="color:red;">','</span>'),
									"tujuan_akhir"	=> form_error("tujuan_akhir",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function getId($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			
			$data = $this->jadwalModel->getById($id);
			if ($data) {	

				$jam = explode(":", $data->jam);
				$data->jam_menit = $jam[0].":".$jam[1];

				$this->response->status = true;
				$this->response->message = "data get By Id";
				$this->response->data = $data;
			} else {
				$this->response->message = alertDanger("Data tidak ada.");
			}
		}
		parent::json();
	}

	public function getAll($hari=false)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			
			$where = false;
			$orderBy = false;
			if ($hari) {
				$where = array("hari" => $hari);
				$orderBy = array("jam ASC");
			}

			$data = $this->jadwalModel->getAll($where,false,$orderBy);
			if ($data) {	
				$jam = explode(":", $data->jam);
				$data->jam_menit = $jam[0].":".$jam[1];
				
				$this->response->status = true;
				$this->response->message = "data get All";
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
			$hari = $this->input->post("hari");
			$jam = $this->input->post("jam");
			$tujuan_awal = $this->input->post("tujuan_awal");
			$tujuan_akhir = $this->input->post("tujuan_akhir");
			// form validate
			self::inputValidate();

			if ($this->form_validation->run() == true) {

				$data = array(
							"id"			=>	$id,
							"hari"			=>	$hari,
							"jam"			=>	$jam,
							"tujuan_awal"	=>	ucfirst($tujuan_awal),
							"tujuan_akhir"	=>	ucfirst($tujuan_akhir),
							"updated_at"	=>	date("Y-m-d H:i:s"),
						);

				$update = $this->jadwalModel->update($data);
				if ($update) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di update..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
				$this->response->error = array(
									"hari"	=> form_error("hari",'<span style="color:red;">','</span>'),
									"jam"	=> form_error("jam",'<span style="color:red;">','</span>'),
									"tujuan_awal"	=> form_error("tujuan_awal",'<span style="color:red;">','</span>'),
									"tujuan_akhir"	=> form_error("tujuan_akhir",'<span style="color:red;">','</span>'),
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
			$getData = $this->jadwalModel->getById($id);
			if($getData) {
				$delete = $this->jadwalModel->delete($id);
				if ($delete) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Berhasil hapus data");
				} else {
					$this->response->message = alertDanger("Opps, terjadi kesalahan.<br>Mungkin sudah dihapus pengguna lain.");
				}
			} else {
				$this->response->message = alertDanger("Data tidak ada..!");
			}
		}
		parent::json();
	}

	public function hariAll()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$hari = array("hari");
			$dataHari = $this->jadwalModel->getAll(false,$hari,false,false,false,$hari);
			if($dataHari) {
				foreach ($dataHari as $item) {
					$item->hari_b = ucfirst($item->hari);
				}
				$this->response->status = true;
				$this->response->message = "data hari";
				$this->response->data = $dataHari;
			} else {
				$this->response->message = "Data tidak ada..!";
			}
		}
		parent::json();
	}

	public function jamPerHari($hari)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$where = array("hari" => $hari);
			$dataJam = $this->jadwalModel->getAll($where);
			if($dataJam) {
				foreach ($dataJam as $item) {
					$jam = explode(":",$item->jam);
					$item->jam = $jam[0].":".$jam[1];
				}
				$this->response->status = true;
				$this->response->message = "data jam per hari";
				$this->response->data = $dataJam;
			} else {
				$this->response->message = "Data tidak ada..!";
			}
		}
		parent::json();
	}

	public function tujuanPerJam($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$where = array("id" => $id);
			$select = array("tujuan_awal","tujuan_akhir");
			$dataTujuanJam = $this->jadwalModel->getByWhere($where,$select);
			if($dataTujuanJam) {
				$this->response->status = true;
				$this->response->message = "data jam per hari";
				$this->response->data = $dataTujuanJam;
			} else {
				$this->response->message = "Data tidak ada..!";
			}
		}
		parent::json();
	}

}

/* End of file Jadwal.php */
/* Location: ./application/controllers/master/Jadwal.php */