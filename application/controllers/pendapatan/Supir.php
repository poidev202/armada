<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supir extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('pendapatan/Supir_model',"supirModel");
		parent::checkUserRoleKasir(); // check role atau level function
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function

		parent::headerTitle("Pendapatan Supir","Pendapatan","Supir");

		$breadcrumbs = array(
								"Pendapatan"	=> 	site_url('pendapatan/supir'),
								"Supir"	=>	"",
							);

		parent::breadcrumbs($breadcrumbs);

		parent::viewPendapatan();
	}

	public function ajax_list($status = 0)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$where = array("pendapatan_supir.status_supir" => $status);
			$select = array("pendapatan_supir.*","master_armada.nama","master_armada.no_bk","master_jadwal.hari","master_jadwal.jam","master_jadwal.tujuan_awal","master_jadwal.tujuan_akhir","performa_surat_jalan.tanggal");

			if ($status == 1) {
				$select[]	=	"performa_surat_jalan.kode_supir1";
				$select[]	=	"performa_surat_jalan.nama_supir1";

				$columns = array(null,'pendapatan_supir.tanggal_input','kode_supir1','nama_supir1','nama','no_bk','tanggal','hari','jam','tujuan_awal','tujuan_akhir','uang_pendapatan');
				$search = array('pendapatan_supir.tanggal_input','nama','no_bk','kode_supir1','nama_supir1','tanggal','hari','jam','tujuan_awal','tujuan_akhir','uang_pendapatan');
			} else if ($status == 2) {
				$select[]	=	"performa_surat_jalan.kode_supir2";
				$select[]	=	"performa_surat_jalan.nama_supir2";

				$columns = array(null,'pendapatan_supir.tanggal_input','kode_supir2','nama_supir2','nama','no_bk','tanggal','hari','jam','tujuan_awal','tujuan_akhir','uang_pendapatan');
				$search = array('pendapatan_supir.tanggal_input','nama','no_bk','kode_supir2','nama_supir2','tanggal','hari','jam','tujuan_awal','tujuan_akhir','uang_pendapatan');
			}

			$join = array(
							array("performa_surat_jalan","performa_surat_jalan.id = pendapatan_supir.surat_jalan_id","LEFT"),
							array("master_armada","master_armada.id = performa_surat_jalan.armada_id","LEFT"),
							array("master_jadwal","master_jadwal.id = performa_surat_jalan.jadwal_id","LEFT"),
						);

			$result = $this->supirModel->findDataTable($where,$select,$columns,$search,$join);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";

				// $item->tanggal_input = date_ind("d M Y", $item->tanggal_input);

				$item->jam = explode(":", $item->jam);
				$item->jam = $item->jam[0].":".$item->jam[1];

				$item->uang_pendapatan = "Rp.".number_format($item->uang_pendapatan,0,",",".");
				
				$btnAction ='<button type="button" onclick="btnDetail('.$item->id.')" class="btn btn-outline-info btn-xs m-b-10" title="Detail"><i class="fa fa-info-circle"></i> Detail</button>';

				$item->button_action = $btnAction;

				$data[] = $item;
			}
			return $this->supirModel->findDataTableOutput($data,$where,$search,$join);
		}
		parent::json();
	}

	public function inputFormSupir1()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {

			$this->form_validation->set_rules('supir1', 'Nama Supir 1', 'trim|required');
			$this->form_validation->set_rules('nama_armada1', 'Nama Armada', 'trim|required');
			$this->form_validation->set_rules('tgl_surat_jalan1', 'Tanggal Surat Jalan', 'trim|required');
			$this->form_validation->set_rules('tanggal_input1', 'Tanggal Input', 'trim|required');
			$this->form_validation->set_rules('uang_pendapatan1', 'Uang Pendapatan supir 1', 'trim|required');

			$tanggal_input = $this->input->post('tanggal_input1');
			$surat_jalan_id = $this->input->post('tgl_surat_jalan1');
			$uang_pendapatan = $this->input->post('uang_pendapatan1');
			// $keterangan = $this->input->post('keterangan');

			if ($this->form_validation->run() == TRUE) {

				$data = array(
						"tanggal_input"		=>	$tanggal_input,
						"status_supir"		=>	1,
						"surat_jalan_id"	=>	$surat_jalan_id,
						// "uang_pendapatan"	=>	$uang_pendapatan,
						// "keterangan"		=>	$keterangan,
					);
				$checkDuplicate = $this->supirModel->getByWhere($data);
				if ($checkDuplicate) {
					$this->response->message = alertDanger("Data yang akan di input sudah ada.!");
				} else {
					$this->response->status = true;
					$this->response->message = "validate form supir 1 true";
				}
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
			}	
		}
		parent::json();
	}

	public function insertPendapatanSupir1()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$tanggal_input = $this->input->post('tanggal_input1');
			$surat_jalan_id = $this->input->post('tgl_surat_jalan1');
			$uang_pendapatan = $this->input->post('uang_pendapatan1');
			// $keterangan = $this->input->post('keterangan');

			$data = array(
						"tanggal_input"		=>	$tanggal_input,
						"status_supir"		=>	1,
						"surat_jalan_id"	=>	$surat_jalan_id,
						"uang_pendapatan"	=>	$uang_pendapatan,
						// "keterangan"		=>	$keterangan,
					);
			$insert = $this->supirModel->insert($data);
			if ($insert) {
				$this->response->status = true;
				$this->response->message = alertSuccess("Berhasil input pendapatan supir 1");
			} else {
				$this->response->message = alertDanger("Gagal, input pendapatan supir 1");
			}	
		}
		parent::json();
	}

	public function inputFormSupir2()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {

			$this->form_validation->set_rules('supir2', 'Nama Supir 2', 'trim|required');
			$this->form_validation->set_rules('nama_armada2', 'Nama Armada', 'trim|required');
			$this->form_validation->set_rules('tgl_surat_jalan2', 'Tanggal Surat Jalan', 'trim|required');
			$this->form_validation->set_rules('tanggal_input2', 'Tanggal Input', 'trim|required');
			$this->form_validation->set_rules('uang_pendapatan2', 'Uang Pendapatan supir 2', 'trim|required');

			$tanggal_input = $this->input->post('tanggal_input2');
			$surat_jalan_id = $this->input->post('tgl_surat_jalan2');
			$uang_pendapatan = $this->input->post('uang_pendapatan2');
			// $keterangan = $this->input->post('keterangan');

			if ($this->form_validation->run() == TRUE) {

				$data = array(
						"tanggal_input"		=>	$tanggal_input,
						"status_supir"		=>	2,
						"surat_jalan_id"	=>	$surat_jalan_id,
						// "uang_pendapatan"	=>	$uang_pendapatan,
						// "keterangan"		=>	$keterangan,
					);
				$checkDuplicate = $this->supirModel->getByWhere($data);
				if ($checkDuplicate) {
					$this->response->message = alertDanger("Data yang akan di input sudah ada.!");
				} else {
					$this->response->status = true;
					$this->response->message = "validate form supir 2 true";
				}
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
			}	
		}
		parent::json();
	}

	public function insertPendapatanSupir2()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$tanggal_input = $this->input->post('tanggal_input2');
			$surat_jalan_id = $this->input->post('tgl_surat_jalan2');
			$uang_pendapatan = $this->input->post('uang_pendapatan2');
			// $keterangan = $this->input->post('keterangan');

			$data = array(
						"tanggal_input"		=>	$tanggal_input,
						"status_supir"		=>	2,
						"surat_jalan_id"	=>	$surat_jalan_id,
						"uang_pendapatan"	=>	$uang_pendapatan,
						// "keterangan"		=>	$keterangan,
					);
			$insert = $this->supirModel->insert($data);
			if ($insert) {
				$this->response->status = true;
				$this->response->message = alertSuccess("Berhasil input pendapatan supir 2");
			} else {
				$this->response->message = alertDanger("Gagal, input pendapatan supir 2");
			}	
		}
		parent::json();
	}
}

/* End of file Supir.php */
/* Location: ./application/controllers/pendapatan/Supir.php */