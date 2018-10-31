<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kreditchassis extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('master/Kredit_chassis_model',"kreditModel");
		parent::checkUserRoleMaster(); // check role atau level function
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function

		parent::headerTitle("Master Armada, Cicilan / Kredit Chassis","Master Armada","Cicilan / Kredit Chassis");

		$breadcrumbs = array(
								"Master Armada"	=> site_url('master/kreditchassis'),
								"Cicilan / Kredit Chassis"	=>	"",
							);
		parent::breadcrumbs($breadcrumbs);

		parent::viewMaster();
	}

	public function ajax_list($id_armada=false)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {

			$where = false;

			$select = array("master_kredit_chassis.*","master_kredit_chassis.id AS id_kredit","master_armada.*","master_merk_chassis.merk","master_vendor.nama_vendor");
			$columns = array(null,'tanggal_bayar','nama','nama_vendor','merk','no_bk','angsuran_pokok','angsuran_bunga','jumlah_bayar');
			$search = array('tanggal_bayar','nama','nama_vendor','merk','no_bk','angsuran_pokok','angsuran_bunga','jumlah_bayar');

			if ($id_armada) {
				$where = array("master_kredit_chassis.master_armada_id" => $id_armada);
				$columns = array(null,'tanggal_bayar','angsuran_pokok','angsuran_bunga','jumlah_bayar');
				$search = array('tanggal_bayar','angsuran_pokok','angsuran_bunga','jumlah_bayar');
			}

			$join = array(
							array("master_armada","master_armada.id = master_kredit_chassis.master_armada_id","LEFT"),
							array("master_vendor","master_vendor.id = master_kredit_chassis.master_vendor_id","LEFT"),
							array("master_merk_chassis","master_merk_chassis.id = master_armada.merk_chassis_id","LEFT"),
						);

			$result = $this->kreditModel->findDataTable($where,$select,$columns,$search,$join);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";
				$item->tanggal_bayar = date_ind("d M Y", $item->tanggal_bayar);

				$item->angsuran_pokok = "Rp.".number_format($item->angsuran_pokok,0,",",".");
				$item->angsuran_bunga = "Rp.".number_format($item->angsuran_bunga,0,",",".");
				$item->jumlah_bayar = "Rp.".number_format($item->jumlah_bayar,0,",",".");

				/*if($item->photo != ""){
					$item->photo = base_url()."uploads/admin/master/armada/".$item->photo;
				} else {
					$item->photo = base_url()."assets/images/default/no_image.jpg";
				}

				$item->photo = '<div class="img-thumbnail"><center><img src="'.$item->photo.'" class="img img-responsive" style="width:60px; height:60px;"></center></div>';*/

				$btnAction = '<button type="button" onclick="editKredit('.$item->id_kredit.')" class="btn btn btn-outline-warning btn-xs m-b-10" title="Edit"><i class="fa fa-pencil-square-o"></i> </button> &nbsp;'; // update
				
				$btnAction .='<button type="button" onclick="btnDelete('.$item->id_kredit.')" class="btn btn-outline-danger btn-xs m-b-10" title="Hapus"><i class="fa fa-trash-o"></i> </button>'; // delete

				$item->button_action = $btnAction;

				$data[] = $item;
			}
			return $this->kreditModel->findDataTableOutput($data,$where,$search,$join);
		}
		parent::json();
	}

	public function ajax_list_status_armada()
	{
		$this->load->model('master/Armada_model','armadaModel');

		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$where = array(
							"master_armada.status_beli_chassis" => 2,
						);
			$select = array("master_armada.*","master_armada.id AS id_armada","master_merk_chassis.merk","master_tipe_chassis.tipe","master_vendor.nama_vendor");
			$columns = array(null,'nama',null,'nama_vendor','merk','no_bk','lunas_chassis','dp_chassis');

			$search = array('nama','nama_vendor','merk','no_bk','lunas_chassis','dp_chassis');

			$join = array(
							array("master_vendor","master_vendor.id = master_armada.vendor_chassis_id","LEFT"),
							array("master_merk_chassis","master_merk_chassis.id = master_armada.merk_chassis_id","LEFT"),
							array("master_tipe_chassis","master_tipe_chassis.id = master_armada.tipe_chassis_id","LEFT"),
						);

			$result = $this->armadaModel->findDataTable($where,$select,$columns,$search,$join);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";

				$item->dp_chassis_rp = "Rp.".number_format($item->dp_chassis,0,",",".");
				$item->lunas_chassis_rp = "Rp.".number_format($item->lunas_chassis,0,",",".");

				/*variabel SUM(jumlah_bayar) kredit armada*/
				$total_bayar = $this->kreditModel->getSelectSum("jumlah_bayar",array("master_armada_id" => $item->id_armada));

				$total_bayar = ($total_bayar->jumlah_bayar + $item->dp_chassis);
				// $total_bayar = ($total_bayar - $item->jumlah_bayar);
				
				$sisa_hutang = ($item->lunas_chassis - $total_bayar);

				$item->total_bayar = "<b>Rp.".number_format($total_bayar,0,",",".")."</b>";
				$item->sisa_hutang = "<b>Rp.".number_format($sisa_hutang,0,",",".")."</b>";

				if($item->photo != ""){
					$item->photo = base_url()."uploads/admin/master/armada/".$item->photo;
				} else {
					$item->photo = base_url()."assets/images/default/no_image.jpg";
				}

				$item->photo = '<div class="img-thumbnail"><center><img src="'.$item->photo.'" class="img img-responsive" style="width:60px; height:60px;"></center></div>';

				$btnAction = '<button type="button" onclick="rekapKredit('.$item->id.')" class="btn btn btn-outline-info btn-xs m-b-10" title="Rekap Kredit Chassis"><i class="fa fa-list-alt"></i> Rekap</button> &nbsp;&nbsp;&nbsp;'; // rekap kredit chassis
				
				$item->button_action = $btnAction;

				$data[] = $item;
			}
			return $this->armadaModel->findDataTableOutput($data,$where,$search,$join);
		}
		parent::json();
	}

	public function inputValidate()
	{
		$this->form_validation->set_rules("nama_armada","Nama Armada","trim|required");
		$this->form_validation->set_rules("vendor_chassis","Vendor","trim|required");
		$this->form_validation->set_rules("tanggal_bayar","Tanggal Bayar","trim|required");
		$this->form_validation->set_rules("angsuran_pokok","Angsuran Pokok","trim|required");
		$this->form_validation->set_rules("angsuran_bunga","Angsuran Bunga","trim|required");
	}

	public function add()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$nama_armada = $this->input->post("nama_armada");
			$vendor_chassis = $this->input->post("vendor_chassis");
			$tanggal_bayar = $this->input->post("tanggal_bayar");
			$angsuran_pokok = $this->input->post("angsuran_pokok");
			$angsuran_bunga = $this->input->post("angsuran_bunga");

			// form validate
			self::inputValidate();

			if ($this->form_validation->run() == true) {
				
				$jumlah_bayar = $angsuran_pokok + $angsuran_bunga;
				$data = array(
							"master_armada_id"	=>	$nama_armada,
							"master_vendor_id"	=>	$vendor_chassis,
							"tanggal_bayar"	=>	$tanggal_bayar,
							"angsuran_pokok"	=>	$angsuran_pokok,
							"angsuran_bunga"	=>	$angsuran_bunga,
							"jumlah_bayar"	=>	$jumlah_bayar,
						);

				$insert = $this->kreditModel->insert($data);
				if ($insert) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di tambah..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
				$this->response->error = array(
									"nama_armada"	=> form_error("nama_armada",'<span style="color:red;">','</span>'),
									"tanggal_bayar"	=> form_error("tanggal_bayar",'<span style="color:red;">','</span>'),
									"angsuran_pokok"	=> form_error("angsuran_pokok",'<span style="color:red;">','</span>'),
									"angsuran_bunga"	=> form_error("angsuran_bunga",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function getId($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$select = array("master_kredit_chassis.*","master_kredit_chassis.id AS id_kredit","master_armada.*","master_merk_chassis.merk");
			$join = array(
							array("master_armada","master_armada.id = master_kredit_chassis.master_armada_id","LEFT"),
							array("master_merk_chassis","master_merk_chassis.id = master_armada.merk_chassis_id","LEFT"),
						);
			$data = $this->kreditModel->getByWhere(array("master_kredit_chassis.id"=>$id),$select,$join);
			if ($data) {	
				$data->tanggal_bayar_indo = date_ind("d M Y", $data->tanggal_bayar);

				$data->angsuran_pokok_rp = "Rp.".number_format($data->angsuran_pokok,0,",",".");
				$data->angsuran_bunga_rp = "Rp.".number_format($data->angsuran_bunga,0,",",".");
				$data->jumlah_bayar_rp = "Rp.".number_format($data->jumlah_bayar,0,",",".");

				if($data->photo != ""){
					$data->photo = base_url()."uploads/admin/master/armada/".$data->photo;
				} else {
					$data->photo = base_url()."assets/images/default/no_image.jpg";
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

	public function update($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$nama_armada = $this->input->post("nama_armada");
			$vendor_chassis = $this->input->post("vendor_chassis");
			$tanggal_bayar = $this->input->post("tanggal_bayar");
			$angsuran_pokok = $this->input->post("angsuran_pokok");
			$angsuran_bunga = $this->input->post("angsuran_bunga");

			// form validate
			self::inputValidate();

			if ($this->form_validation->run() == true) {
				
				$jumlah_bayar = $angsuran_pokok + $angsuran_bunga;
				$data = array(
							"id"	=>	$id,
							"master_armada_id"	=>	$nama_armada,
							"master_vendor_id"	=>	$vendor_chassis,
							"tanggal_bayar"		=>	$tanggal_bayar,
							"angsuran_pokok"	=>	$angsuran_pokok,
							"angsuran_bunga"	=>	$angsuran_bunga,
							"jumlah_bayar"		=>	$jumlah_bayar,
							"updated_at" 		=>	date("Y-m-d H:i:s")
						);

				$update = $this->kreditModel->update($data);
				if ($update) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di update..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
				$this->response->error = array(
									"nama_armada"	=> form_error("nama_armada",'<span style="color:red;">','</span>'),
									"tanggal_bayar"	=> form_error("tanggal_bayar",'<span style="color:red;">','</span>'),
									"angsuran_pokok"	=> form_error("angsuran_pokok",'<span style="color:red;">','</span>'),
									"angsuran_bunga"	=> form_error("angsuran_bunga",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function delete($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$getData = $this->kreditModel->getById($id);
			if($getData) {
				$delete = $this->kreditModel->delete($id);
				// $delete = true;
				if ($delete) {
					$this->response->status = true;
					$this->response->message = "<div class='alert alert-success'><i class='fa fa-check'></i> Berhasil hapus data.</div>";
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

/* End of file Kreditchassis.php */
/* Location: ./application/controllers/admin/Kreditchassis.php */