<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kps extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('master/Kps_model',"kpsModel");
		parent::checkUserRoleMaster(); // check role atau level function
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function

		// parent::halamanTitle("Master Armada, KPS");

		parent::headerTitle("Master Armada, KPS","Master Armada","KPS");

		$breadcrumbs = array(
								"Master Armada"	=> site_url('master/kps'),
								"KPS"	=>	"",
							);
		parent::breadcrumbs($breadcrumbs);

		parent::viewMaster();
	}

	public function ajax_list()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$select = array("master_kps.*","master_kps.id AS id_kps","master_armada.*","master_tipe_chassis.tipe");
			$columns = array(null,"no_kps",'nama',null,'tahun','tipe','no_bk','tgl_jatuh_tempo','tujuan_awal','tujuan_akhir');

			$search = array("no_kps",'nama','tahun','tipe','no_bk','tgl_jatuh_tempo','tujuan_awal','tujuan_akhir');

			$join = array(
							array("master_armada","master_armada.id = master_kps.master_armada_id","LEFT"),
							array("master_tipe_chassis","master_tipe_chassis.id = master_armada.tipe_chassis_id","LEFT"),
						);

			$result = $this->kpsModel->findDataTable(false,$select,$columns,$search,$join);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";
				$item->tgl_jatuh_tempo = date_ind("d M Y", $item->tgl_jatuh_tempo);

				if($item->photo != ""){
					$item->photo = base_url()."uploads/admin/master/armada/".$item->photo;
				} else {
					$item->photo = base_url()."assets/images/default/no_image.jpg";
				}

				$item->photo = '<div class="img-thumbnail"><center><img src="'.$item->photo.'" class="img img-responsive" style="width:60px; height:60px;"></center></div>';

				$btnAction = '<button type="button" onclick="detailKPS('.$item->id_kps.')" class="btn btn btn-outline-info btn-xs m-b-10" title="Detail"><i class="fa fa-info-circle"></i> </button> &nbsp;'; // update

				$btnAction .= '<button type="button" onclick="editKPS('.$item->id_kps.')" class="btn btn btn-outline-warning btn-xs m-b-10" title="Edit"><i class="fa fa-pencil-square-o"></i> </button> &nbsp;'; // update
				
				$btnAction .='<button type="button" onclick="btnDelete('.$item->id_kps.')" class="btn btn-outline-danger btn-xs m-b-10" title="Hapus"><i class="fa fa-trash-o"></i> </button>'; // delete

				$item->button_action = $btnAction;

				$data[] = $item;
			}
			return $this->kpsModel->findDataTableOutput($data,false,$search,$join);
		}
		parent::json();
	}

	public function inputValidate()
	{
		$this->form_validation->set_rules("nama_armada","Nama Armada","trim|required");
		$this->form_validation->set_rules("tgl_jatuh_tempo","Tanggal Jatuh Tempo","trim|required");
		$this->form_validation->set_rules("trayek","Trayek Tujuan","trim|required");
	}

	public function add()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$nama_armada = $this->input->post("nama_armada");
			$no_kps = $this->input->post("no_kps");
			$tgl_jatuh_tempo = $this->input->post("tgl_jatuh_tempo");
			$trayek = $this->input->post("trayek");

			// form validate
			self::inputValidate();
			$this->form_validation->set_rules("no_kps","No KPS","trim|required|is_unique[master_kps.no_kps]");

			if ($this->form_validation->run() == true) {
				
				$trayek_data = explode(",", $trayek);

				$tujuan_awal = current($trayek_data);
				$tujuan_akhir = end($trayek_data);

				$trayek = str_replace(",", " => ", $trayek);

				$data = array(
							"master_armada_id"	=>	$nama_armada,
							"no_kps"	=>	$no_kps,
							"tgl_jatuh_tempo"	=>	$tgl_jatuh_tempo,
							"trayek"	=>	$trayek,
							"tujuan_awal"	=>	$tujuan_awal,
							"tujuan_akhir"	=>	$tujuan_akhir
						);

				$insert = $this->kpsModel->insert($data);
				if ($insert) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di tambah..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
				$this->response->error = array(
									"nama_armada"	=> form_error("nama_armada",'<span style="color:red;">','</span>'),
									"no_kps"	=> form_error("no_kps",'<span style="color:red;">','</span>'),
									"tgl_jatuh_tempo"	=> form_error("tgl_jatuh_tempo",'<span style="color:red;">','</span>'),
									"trayek"	=> form_error("trayek",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function getId($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$select = array("master_kps.*","master_kps.id AS id_kps","master_armada.*","master_merk_chassis.merk","master_tipe_chassis.tipe","master_karoseri.nama_karoseri","master_karoseri_tipe.tipe_karoseri");
			$join = array(
							array("master_armada","master_armada.id = master_kps.master_armada_id","LEFT"),
							array("master_merk_chassis","master_merk_chassis.id = master_armada.merk_chassis_id","LEFT"),
							array("master_tipe_chassis","master_tipe_chassis.id = master_armada.tipe_chassis_id","LEFT"),
							array("master_karoseri","master_karoseri.id = master_armada.karoseri_id","LEFT"),
							array("master_karoseri_tipe","master_karoseri_tipe.id = master_armada.tipe_karoseri_id","LEFT"),
						);
			$data = $this->kpsModel->getByWhere(array("master_kps.id"=>$id),$select,$join);
			if ($data) {	
			    $data->trayek_tags = str_replace(" => ", ",", $data->trayek);
				$data->tgl_jatuh_tempo_indo = date_ind("d M Y", $data->tgl_jatuh_tempo);

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
			$no_kps = $this->input->post("no_kps");
			$tgl_jatuh_tempo = $this->input->post("tgl_jatuh_tempo");
			$trayek = $this->input->post("trayek");

			// form validate
			self::inputValidate();
			$this->form_validation->set_rules("no_kps","No KPS","trim|required");

			if ($this->form_validation->run() == true) {
				
				$trayek_data = explode(",", $trayek);
				$tujuan_awal = current($trayek_data);
				$tujuan_akhir = end($trayek_data);

				$trayek = str_replace(",", " => ", $trayek);

				$data = array(
							"id"	=>	$id,
							"master_armada_id"	=>	$nama_armada,
							"no_kps"	=>	$no_kps,
							"tgl_jatuh_tempo"	=>	$tgl_jatuh_tempo,
							"trayek"	=>	$trayek,
							"tujuan_awal"	=>	$tujuan_awal,
							"tujuan_akhir"	=>	$tujuan_akhir,
							"updated_at"	=>	date("Y-m-d H:i:s")
						);

				$update = $this->kpsModel->update($data);
				if ($update) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di update..");
					$this->response->data = $data;
				}
				
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
				$this->response->error = array(
									"nama_armada"	=> form_error("nama_armada",'<span style="color:red;">','</span>'),
									"no_kps"	=> form_error("no_kps",'<span style="color:red;">','</span>'),
									"tgl_jatuh_tempo"	=> form_error("tgl_jatuh_tempo",'<span style="color:red;">','</span>'),
									"trayek"	=> form_error("trayek",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function delete($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$getData = $this->kpsModel->getById($id);
			if($getData) {
				$delete = $this->kpsModel->delete($id);
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

/* End of file Kps.php */
/* Location: ./application/controllers/master/Kps.php */