<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Armada extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('master/Armada_model',"armadaModel");
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		parent::headerTitle("Master Armada, Armada","Master Armada","Armada");

		$breadcrumbs = array(
								"Master Armada"	=> site_url('master/armada'),
								"Armada"	=>	"",
							);
		parent::viewContent(array("user_role" => $this->user_role));
		parent::breadcrumbs($breadcrumbs);

		parent::viewMaster();
	}

	public function ajax_list()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$select = array("master_armada.*","master_merk_chassis.merk","master_tipe_chassis.tipe","master_karoseri.nama_karoseri","master_karoseri_tipe.tipe_karoseri");
			$columns = array(null,null,'nama','tahun','merk','nama_karoseri','tgl_beli','no_bk','tgl_stnk');

			$search = array('nama','tahun','merk','nama_karoseri','tgl_beli','no_bk','tgl_stnk');

			$join = array(
							array("master_merk_chassis","master_merk_chassis.id = master_armada.merk_chassis_id","LEFT"),
							array("master_tipe_chassis","master_tipe_chassis.id = master_armada.tipe_chassis_id","LEFT"),
							array("master_karoseri","master_karoseri.id = master_armada.karoseri_id","LEFT"),
							array("master_karoseri_tipe","master_karoseri_tipe.id = master_armada.tipe_karoseri_id","LEFT"),
						);

			$result = $this->armadaModel->findDataTable(false,$select,$columns,$search,$join);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";
				$item->tgl_beli = date_ind("d M Y", $item->tgl_beli);
				$item->tgl_stnk = date_ind("d M Y", $item->tgl_stnk);

				if($item->photo != ""){
					$item->photo = base_url()."uploads/admin/master/armada/".$item->photo;
				} else {
					$item->photo = base_url()."assets/images/default/no_image.jpg";
				}

				$item->photo = '<div class="img-thumbnail"><center><img src="'.$item->photo.'" class="img img-responsive" style="width:60px; height:60px;"></center></div>';

				$btnAction = '<button type="button" onclick="detailArmada('.$item->id.')" class="btn btn btn-outline-info btn-xs m-b-10" title="Detail"><i class="fa fa-info-circle"></i> </button> &nbsp;'; // detail

				$btnAction .= '<button type="button" onclick="editArmada('.$item->id.')" class="btn btn btn-outline-warning btn-xs m-b-10" title="Edit"><i class="fa fa-pencil-square-o"></i> </button> &nbsp;'; // update
				
				$btnAction .='<button type="button" onclick="btnDelete('.$item->id.')" class="btn btn-outline-danger btn-xs m-b-10" title="Hapus"><i class="fa fa-trash-o"></i> </button>'; // delete

				$item->button_action = $btnAction;

				$data[] = $item;
			}
			return $this->armadaModel->findDataTableOutput($data,false,$search,$join);
		}
		parent::json();
	}

	public function inputValidate()
	{
		$this->form_validation->set_rules('no_bk', 'No BK / Plat', 'trim|required');
		$this->form_validation->set_rules('tgl_stnk', 'Tanggal STNK', 'trim|required');
		$this->form_validation->set_rules('tgl_beli', 'Tanggal beli', 'trim|required');
		$this->form_validation->set_rules('thn_armada', 'Tahun armada', 'trim|required');
		$this->form_validation->set_rules('no_bpkb', 'No BPKB', 'trim|required');
		$this->form_validation->set_rules('no_mesin', 'No mesin', 'trim|required');
		$this->form_validation->set_rules('lokasi_bpkb', 'Lokasi BPKB', 'trim|required');
		$this->form_validation->set_rules('notes', 'Notes', 'trim');
		$this->form_validation->set_rules('no_chassis', 'No chassis', 'trim|required');
		$this->form_validation->set_rules('tgl_chassis', 'Tanggal chassis', 'trim|required');
		$this->form_validation->set_rules('merk_chassis', 'Merk Chassis', 'trim|required');
		$this->form_validation->set_rules('tipe_chassis', 'Tipe Chassis', 'trim|required');
		$this->form_validation->set_rules('vendor_chassis', 'Vendor Chassis', 'trim|required');
		$this->form_validation->set_rules('status_beli_chassis', 'Status beli chassis', 'trim|required');
		$this->form_validation->set_rules('lunas_chassis', 'Bayar Lunas Chassis', 'trim|required');
		$this->form_validation->set_rules('nama_karoseri', 'Nama Karoseri', 'trim|required');
		$this->form_validation->set_rules('tipe_karoseri', 'Tipe Karoseri', 'trim|required');
		$this->form_validation->set_rules('vendor_karoseri', 'Vendor Karoseri', 'trim|required');
		$this->form_validation->set_rules('status_beli_karoseri', 'Status beli karoseri', 'trim|required');
		$this->form_validation->set_rules('lunas_karoseri', 'Bayar Lunas Karoseri', 'trim|required');
	}
	
	public function add()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$nama_armada = $this->input->post("nama_armada");
			$merk_chassis = $this->input->post("merk_chassis");
			$tipe_chassis = $this->input->post("tipe_chassis");
			$nama_karoseri = $this->input->post("nama_karoseri");
			$tipe_karoseri = $this->input->post("tipe_karoseri");
			$karoseri = $this->input->post("karoseri");
			$thn_armada = $this->input->post("thn_armada");
			$tgl_beli = $this->input->post("tgl_beli");
			$tgl_chassis = $this->input->post("tgl_chassis");
			$notes = $this->input->post("notes");
			$no_chassis = $this->input->post("no_chassis");
			$no_mesin = $this->input->post("no_mesin");
			$lokasi_bpkb = $this->input->post("lokasi_bpkb");
			$no_bpkb = $this->input->post("no_bpkb");
			$tgl_stnk = $this->input->post("tgl_stnk");
			$no_bk = $this->input->post("no_bk");
			$status_beli_chassis = $this->input->post("status_beli_chassis");
			$lunas_chassis = $this->input->post("lunas_chassis");
			$dp_chassis = $this->input->post("dp_chassis");
			$vendor_chassis	= $this->input->post("vendor_chassis");
			$status_beli_karoseri = $this->input->post("status_beli_karoseri");
			$lunas_karoseri = $this->input->post("lunas_karoseri");
			$dp_karoseri = $this->input->post("dp_karoseri");
			$vendor_karoseri	= $this->input->post("vendor_karoseri");
			$ac	= $this->input->post("ac");
			$wifi	= $this->input->post("wifi");

			$this->form_validation->set_rules('nama_armada', 'Nama Armada', 'trim|required|is_unique[master_armada.nama]');
			self::inputValidate();

			if ($this->form_validation->run() == true) {
				
				// config upload photo
				self::_do_upload();
				$data = array(
							"nama"				=>	$nama_armada,
							"merk_chassis_id"	=>	$merk_chassis,
							"tipe_chassis_id"	=>	$tipe_chassis,
							"karoseri_id"		=>	$nama_karoseri,
							"tipe_karoseri_id"	=>	$tipe_karoseri,
							"tahun"				=>	$thn_armada,
							"tgl_beli" 			=> 	$tgl_beli,
							"tgl_chassis" 		=> 	$tgl_chassis,
							"notes" 			=> 	$notes,
							"no_chassis" 		=> 	strtoupper($no_chassis),
							"no_mesin" 			=> 	strtoupper($no_mesin),
							"lokasi_bpkb" 		=> 	$lokasi_bpkb,
							"no_bpkb" 			=> 	strtoupper($no_bpkb),
							"no_bk"				=>	strtoupper($no_bk),
							"tgl_stnk" 			=> $tgl_stnk,
							"status_beli_chassis"	=>	$status_beli_chassis,
							"lunas_chassis"		=>	$lunas_chassis,
							"vendor_chassis_id"	=>	$vendor_chassis,
							"status_beli_karoseri"	=>	$status_beli_karoseri,
							"lunas_karoseri"	=>	$lunas_karoseri,
							"vendor_karoseri_id"	=>	$vendor_karoseri,
							"total_lunas"		=>	$lunas_chassis + $lunas_karoseri,
						);

				if ($status_beli_chassis == 2) {
					$data["dp_chassis"]	=	$dp_chassis;
				}

				if ($status_beli_karoseri == 2) {
					$data["dp_karoseri"]	=	$dp_karoseri;
				}

				if (!empty($ac)) {
					$data["ac"]	=	$ac;
				}

				if (!empty($wifi)) {
					$data["wifi"]	=	$wifi;
				}
				
				if (!empty($_FILES["photo"]["name"])) {
					if (!$this->upload->do_upload("photo")) {
						$this->response->message = "";
						$this->response->error = ["photo" => $this->upload->display_errors('<p style="color:red;">', '</p>')];
					} else {
						$photoArmada = $this->upload->data();
						$data["photo"]	= $photoArmada["file_name"];
					}
				} else {
					$data["photo"]	= "";
				}

				$insert = $this->armadaModel->insertTransaction($data); // insert juga ke table performa_status_armada
				if ($insert) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di tambah..");
					$this->response->data = $data;
				}
			} else {

				$this->response->message = validation_errors('<li class="pull-left"><span class="text-danger">', '</span></li><br>');
				$this->response->error = array(
									"nama_armada"	=> form_error("nama_armada",'<span style="color:red;">','</span>'),
									"merk"	=> form_error("merk",'<span style="color:red;">','</span>'),
									"tipe"	=> form_error("tipe",'<span style="color:red;">','</span>'),
									"thn_armada"	=> form_error("thn_armada",'<span style="color:red;">','</span>'),
									"karoseri"	=> form_error("karoseri",'<span style="color:red;">','</span>'),
									"tgl_beli"	=> form_error("tgl_beli",'<span style="color:red;">','</span>'),
									"tgl_chassis"	=> form_error("tgl_chassis",'<span style="color:red;">','</span>'),
									"notes"	=> form_error("notes",'<span style="color:red;">','</span>'),
									"no_chassis"	=> form_error("no_chassis",'<span style="color:red;">','</span>'),
									"no_mesin"	=> form_error("no_mesin",'<span style="color:red;">','</span>'),
									"lokasi_bpkb"	=> form_error("lokasi_bpkb",'<span style="color:red;">','</span>'),
									"no_bpkb"	=> form_error("no_bpkb",'<span style="color:red;">','</span>'),
									"tgl_stnk"	=> form_error("tgl_stnk",'<span style="color:red;">','</span>'),
									"no_bk"	=> form_error("no_bk",'<span style="color:red;">','</span>'),
									"status_beli_chassis"	=> form_error("status_beli_chassis",'<span style="color:red;">','</span>'),
									"lunas_chassis"	=> form_error("lunas_chassis",'<span style="color:red;">','</span>'),
									"status_beli_karoseri"	=> form_error("status_beli_karoseri",'<span style="color:red;">','</span>'),
									"lunas_karoseri"	=> form_error("lunas_karoseri",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function _do_upload()
	{
		$config['upload_path']      = 	'uploads/admin/master/armada/';
        $config['allowed_types']    = 	'gif|jpg|jpeg|png';
        $config['max_size']         = 	2048; // 2mb
       /* $config['max_width']        = 	2000;
        $config['max_height']       =	1500;*/
        $config['encrypt_name']		=	true;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
	}

	public function getById($id)
	{
		parent::checkLoginUser(); // otoritas authentic function
		// parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$select = array("master_armada.*","master_merk_chassis.merk","master_tipe_chassis.tipe","master_karoseri.nama_karoseri","master_karoseri_tipe.tipe_karoseri");
			$join = array(
						array("master_merk_chassis","master_merk_chassis.id = master_armada.merk_chassis_id","LEFT"),
						array("master_tipe_chassis","master_tipe_chassis.id = master_armada.tipe_chassis_id","LEFT"),
						array("master_karoseri","master_karoseri.id = master_armada.karoseri_id","LEFT"),
						array("master_karoseri_tipe","master_karoseri_tipe.id = master_armada.tipe_karoseri_id","LEFT"),
					);
			$getDataById = $this->armadaModel->getByWhere(array("master_armada.id" => $id),$select,$join);
			if ($getDataById) {
				$getDataById->lunas_chassis_rp = "Rp.".number_format($getDataById->lunas_chassis,0,",",".");
				$getDataById->dp_chassis_rp = "Rp.".number_format($getDataById->dp_chassis,0,",",".");
				$getDataById->lunas_karoseri_rp = "Rp.".number_format($getDataById->lunas_karoseri,0,",",".");
				$getDataById->dp_karoseri_rp = "Rp.".number_format($getDataById->dp_karoseri,0,",",".");
				$getDataById->total_lunas_rp = "Rp.".number_format($getDataById->total_lunas,0,",",".");

				if ($getDataById->status_beli_chassis == 2) {
					$getDataById->status_beli_chassis_text = "Cicilan / Kredit";
				} else {
					$getDataById->status_beli_chassis_text = "Cash";
				}

				$this->load->model('master/Vendor_model',"vendorModel");

				if ($getDataById->vendor_chassis_id != NULL) {
					$vendor_chassis = $this->vendorModel->getById($getDataById->vendor_chassis_id);
					$getDataById->vendor_chassis = $vendor_chassis->nama_vendor;
				} else {
					$getDataById->vendor_chassis = "Tidak Ada Vendor Chassis";
				}

				if ($getDataById->status_beli_karoseri == 2) {
					$getDataById->status_beli_karoseri_text = "Cicilan / Kredit";
				} else {
					$getDataById->status_beli_karoseri_text = "Cash";
				}

				if ($getDataById->vendor_karoseri_id != NULL) {
					$vendor_karoseri = $this->vendorModel->getById($getDataById->vendor_karoseri_id);
					$getDataById->vendor_karoseri = $vendor_karoseri->nama_vendor;
				} else {
					$getDataById->vendor_karoseri = "Tidak Ada Vendor Karoseri";
				}

				if ($getDataById->ac != 0) {
					$getDataById->ac_icon = '<i style="color:#8bc34a;" class="mdi mdi-checkbox-marked"></i>';
				} else {
					$getDataById->ac_icon = '<i class="mdi mdi-checkbox-blank-outline"></i>';
				}

				if ($getDataById->wifi != 0) {
					$getDataById->wifi_icon = '<i style="color:#03a9f4;" class="mdi mdi-checkbox-marked"></i>';
				} else {
					$getDataById->wifi_icon = '<i class="mdi mdi-checkbox-blank-outline"></i>';
				}

				$this->response->status = true;
				$this->response->message = "Data by id master armada";
				$this->response->data = $getDataById;
			} else {
				$this->response->message = spanRed("Data tidak ada..!");
			}
		}
		parent::json();
	}

	public function update($id)
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$id_armada = $this->input->post("id_armada");
			$nama_armada = $this->input->post("nama_armada");
			$merk_chassis = $this->input->post("merk_chassis");
			$tipe_chassis = $this->input->post("tipe_chassis");
			$nama_karoseri = $this->input->post("nama_karoseri");
			$tipe_karoseri = $this->input->post("tipe_karoseri");
			$karoseri = $this->input->post("karoseri");
			$thn_armada = $this->input->post("thn_armada");
			$tgl_beli = $this->input->post("tgl_beli");
			$tgl_chassis = $this->input->post("tgl_chassis");
			$notes = $this->input->post("notes");
			$no_chassis = $this->input->post("no_chassis");
			$no_mesin = $this->input->post("no_mesin");
			$lokasi_bpkb = $this->input->post("lokasi_bpkb");
			$no_bpkb = $this->input->post("no_bpkb");
			$tgl_stnk = $this->input->post("tgl_stnk");
			$no_bk = $this->input->post("no_bk");
			$status_beli_chassis = $this->input->post("status_beli_chassis");
			$lunas_chassis = $this->input->post("lunas_chassis");
			$dp_chassis = $this->input->post("dp_chassis");
			$vendor_chassis	= $this->input->post("vendor_chassis");
			$status_beli_karoseri = $this->input->post("status_beli_karoseri");
			$lunas_karoseri = $this->input->post("lunas_karoseri");
			$dp_karoseri = $this->input->post("dp_karoseri");
			$vendor_karoseri	= $this->input->post("vendor_karoseri");
			$ac	= $this->input->post("ac");
			$wifi	= $this->input->post("wifi");

			$this->form_validation->set_rules('nama_armada', 'Nama Armada', 'trim|required');
			self::inputValidate();

			if ($this->form_validation->run() == true) {
				
				// config upload photo
				self::_do_upload();

				$getById = $this->armadaModel->getById($id); 
				if($getById) {
					$data = array(
							"id"				=>	$id,
							"nama"				=>	$nama_armada,
							"merk_chassis_id"	=>	$merk_chassis,
							"tipe_chassis_id"	=>	$tipe_chassis,
							"karoseri_id"		=>	$nama_karoseri,
							"tipe_karoseri_id"	=>	$tipe_karoseri,
							"tahun"				=>	$thn_armada,
							"tgl_beli" 			=> 	$tgl_beli,
							"tgl_chassis" 		=> 	$tgl_chassis,
							"notes" 			=> 	$notes,
							"no_chassis" 		=> 	strtoupper($no_chassis),
							"no_mesin" 			=> 	strtoupper($no_mesin),
							"lokasi_bpkb" 		=> 	$lokasi_bpkb,
							"no_bpkb" 			=> 	strtoupper($no_bpkb),
							"no_bk"				=>	strtoupper($no_bk),
							"tgl_stnk" 			=> 	$tgl_stnk,
							"status_beli_chassis"	=>	$status_beli_chassis,
							"lunas_chassis"		=>	$lunas_chassis,
							"vendor_chassis_id"	=>	$vendor_chassis,
							"status_beli_karoseri"	=>	$status_beli_karoseri,
							"lunas_karoseri"	=>	$lunas_karoseri,
							"vendor_karoseri_id"	=>	$vendor_karoseri,
							"total_lunas"		=>	$lunas_chassis + $lunas_karoseri,
							"updated_at"		=>	date("Y-m-d H:i:s")
						);

					if ($status_beli_chassis == 2) {
						$data["dp_chassis"]	= $dp_chassis;
					}

					if ($status_beli_karoseri == 2) {
						$data["dp_karoseri"] = $dp_karoseri;
					}

					if (!empty($ac)) {
						$data["ac"]	=	$ac;
					}

					if (!empty($wifi)) {
						$data["wifi"]	=	$wifi;
					}

					if (!empty($_FILES["photo"]["name"])) {
						if (!$this->upload->do_upload("photo")) {
							$this->response->message = "Error photo";
							$this->response->error = ["photo" => $this->upload->display_errors('<p style="color:red;">', '</p>')];
						} else {
							$photoArmada = $this->upload->data();
							$data["photo"]	= $photoArmada["file_name"];

							if (file_exists("uploads/admin/master/armada/".$getById->photo) && $getById->photo) {
								unlink("uploads/admin/master/armada/".$getById->photo);
							}
						}
					} else {
						if ($this->input->post("is_delete") == 0) {
							$data["photo"]	= "";
							if (file_exists("uploads/admin/master/armada/".$getById->photo) && $getById->photo) {
								unlink("uploads/admin/master/armada/".$getById->photo);
							}
						}
					}

					$update = $this->armadaModel->update($data);
					if ($update) {
						$this->response->status = true;
						$this->response->message = alertSuccess("Data berhasil di update..");
						$this->response->data = $data;
					}
				} else {
					$this->response->message = spanRed("Data sudah tidak ada..!");
				}
				
			} else {
				$this->response->message = validation_errors('<li class="pull-left"><span class="text-danger">', '</span></li><br>');
				$this->response->error = array(
									"nama_armada"	=> form_error("nama_armada",'<span style="color:red;">','</span>'),
									"merk"	=> form_error("merk",'<span style="color:red;">','</span>'),
									"tipe"	=> form_error("tipe",'<span style="color:red;">','</span>'),
									"thn_armada"	=> form_error("thn_armada",'<span style="color:red;">','</span>'),
									"karoseri"	=> form_error("karoseri",'<span style="color:red;">','</span>'),
									"tgl_beli"	=> form_error("tgl_beli",'<span style="color:red;">','</span>'),
									"tgl_chassis"	=> form_error("tgl_chassis",'<span style="color:red;">','</span>'),
									"notes"	=> form_error("notes",'<span style="color:red;">','</span>'),
									"no_chassis"	=> form_error("no_chassis",'<span style="color:red;">','</span>'),
									"no_mesin"	=> form_error("no_mesin",'<span style="color:red;">','</span>'),
									"lokasi_bpkb"	=> form_error("lokasi_bpkb",'<span style="color:red;">','</span>'),
									"no_bpkb"	=> form_error("no_bpkb",'<span style="color:red;">','</span>'),
									"tgl_stnk"	=> form_error("tgl_stnk",'<span style="color:red;">','</span>'),
									"no_bk"	=> form_error("no_bk",'<span style="color:red;">','</span>'),
									"status_beli_chassis"	=> form_error("status_beli_chassis",'<span style="color:red;">','</span>'),
									"lunas_chassis"	=> form_error("lunas_chassis",'<span style="color:red;">','</span>'),
									"status_beli_karoseri"	=> form_error("status_beli_karoseri",'<span style="color:red;">','</span>'),
									"lunas_karoseri"	=> form_error("lunas_karoseri",'<span style="color:red;">','</span>'),
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
			$getById = $this->armadaModel->getById($id);
			if ($getById) {

				$delete = $this->armadaModel->delete($id);
				if ($delete) {
					$this->response->status = true;
					$this->response->message = spanGreen("Data berhasil di hapus.");

					if (file_exists("uploads/admin/master/armada/".$getById->photo) && $getById->photo) {
						unlink("uploads/admin/master/armada/".$getById->photo);
					}
				} else {
					$this->response->status = false;
					$this->response->message = spanRed("Opps, terjadi kesalahan.<br>Mungkin sudah dihapus pengguna lain");
				}
			} else {
				$this->response->message = spanRed("Data tidak ada..!");
			}
		}
		parent::json();
	}

	public function getAll($status_beli=false)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {

			$where = false;
			if ($status_beli == "chassis") {
				$where = array(
							"master_armada.status_beli_chassis"	=>	2,
						);
			} else if ($status_beli == "karoseri") {
				$where = array(
							"master_armada.status_beli_karoseri" => 2,
						);
			}
			
			$select = array("master_armada.*","master_merk_chassis.merk","master_tipe_chassis.tipe");
			$join = array(
							array("master_merk_chassis","master_merk_chassis.id = master_armada.merk_chassis_id","LEFT"),
							array("master_tipe_chassis","master_tipe_chassis.id = master_armada.tipe_chassis_id","LEFT"),
						);

			$result = $this->armadaModel->getAll($where,$select,array("nama ASC"),$join);
			if($result) {
				foreach ($result as $item) {
					
					$item->tgl_beli = date_ind("d M Y", $item->tgl_beli);
					$item->tgl_stnk = date_ind("d M Y", $item->tgl_stnk);

					if($item->photo != ""){
						$item->photo = base_url()."uploads/admin/master/armada/".$item->photo;
					} else {
						$item->photo = base_url()."assets/images/default/no_image.jpg";
					}
				}

				$this->response->status = true;
				$this->response->data = $result;
			} else {
				$this->response->message = spanRed("Data tidak ada.");
			}
		}
		parent::json();
	}

	public function getId($id,$idKredit=false)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$where = array("master_armada.id" => $id);

			$select = array("master_armada.*","master_merk_chassis.merk","master_tipe_chassis.tipe","master_karoseri.nama_karoseri","master_karoseri_tipe.tipe_karoseri");
			$join = array(
							array("master_merk_chassis","master_merk_chassis.id = master_armada.merk_chassis_id","LEFT"),
							array("master_tipe_chassis","master_tipe_chassis.id = master_armada.tipe_chassis_id","LEFT"),
							array("master_karoseri","master_karoseri.id = master_armada.karoseri_id","LEFT"),
							array("master_karoseri_tipe","master_karoseri_tipe.id = master_armada.tipe_karoseri_id","LEFT"),
						);

			$result = $this->armadaModel->getByWhere($where,$select,$join);
			if($result) {
					
				$result->tgl_beli = date_ind("d M Y", $result->tgl_beli);
				$result->tgl_stnk = date_ind("d M Y", $result->tgl_stnk);

				$result->lunas_chassis_rp = "Rp.".number_format($result->lunas_chassis,0,",",".");
				$result->dp_chassis_rp = "Rp.".number_format($result->dp_chassis,0,",",".");

				$result->lunas_karoseri_rp = "Rp.".number_format($result->lunas_karoseri,0,",",".");
				$result->dp_karoseri_rp = "Rp.".number_format($result->dp_karoseri,0,",",".");

				if ($result->status_beli_chassis == 2) {
					$this->load->model('master/Kredit_chassis_model',"kreditChassisModel");
					// variabel SUM(jumlah_bayar) kredit armada
					$bayar_chassis = $this->kreditChassisModel->getSelectSum("jumlah_bayar",array("master_armada_id" => $id));

					if ($idKredit) { //ngambil data dari master cicilan / kredit
						$dataKreditChassis = $this->kreditChassisModel->getById($idKredit);
						if ($dataKreditChassis) {
							// $result->jumlah_bayar_kredit_chassis = $dataKreditChassis->jumlah_bayar;
							$total_bayar_chassis = ($bayar_chassis->jumlah_bayar + $result->dp_chassis);
							$total_bayar_chassis = ($total_bayar_chassis - $dataKreditChassis->jumlah_bayar);
							$sisa_hutang_chassis = ($result->lunas_chassis - $total_bayar_chassis);
						} else {
							$total_bayar_chassis = 0;
							$sisa_hutang_chassis = 0;
						}
					} else {
						$total_bayar_chassis = ($bayar_chassis->jumlah_bayar + $result->dp_chassis);
						$sisa_hutang_chassis = ($result->lunas_chassis - $total_bayar_chassis);
					}

					$result->jumlah_bayar_chassis = $bayar_chassis->jumlah_bayar;
					$result->total_bayar_chassis = $total_bayar_chassis;
					$result->sisa_hutang_chassis = $sisa_hutang_chassis;

					$result->jumlah_bayar_chassis_rp = "Rp.".number_format($result->jumlah_bayar_chassis,0,",",".");
					$result->total_bayar_chassis_rp = "Rp.".number_format($total_bayar_chassis,0,",",".");
					$result->sisa_hutang_chassis_rp = "Rp.".number_format($sisa_hutang_chassis,0,",",".");
				}

				if ($result->vendor_chassis_id != NULL) { 	// vendor chassis
					$this->load->model('master/Vendor_model',"vendorModel");
					$vendor_chassis = $this->vendorModel->getById($result->vendor_chassis_id);
					$result->vendor_chassis = $vendor_chassis->nama_vendor;
				} else {
					$result->vendor_chassis = "Tidak Ada Vendor Chassis";
				}

				if ($result->vendor_karoseri_id != NULL) { // vendor karoseri
					$this->load->model('master/Vendor_model',"vendorModel");
					$vendor_karoseri = $this->vendorModel->getById($result->vendor_karoseri_id);
					$result->vendor_karoseri = $vendor_karoseri->nama_vendor;
				} else {
					$result->vendor_karoseri = "Tidak Ada Vendor Karoseri";
				}

				if ($result->status_beli_karoseri == 2) {
					$this->load->model('master/Kredit_karoseri_model',"kreditKaroseriModel");

					// variabel SUM(jumlah_bayar) kredit armada
					$bayar_karoseri = $this->kreditKaroseriModel->getSelectSum("jumlah_bayar",array("master_armada_id" => $id));

					if ($idKredit) { //ngambil data dari master cicilan / kredit
						$dataKreditKaroseri = $this->kreditKaroseriModel->getById($idKredit);
						if ($dataKreditKaroseri) {
							$total_bayar_karoseri = ($bayar_karoseri->jumlah_bayar + $result->dp_karoseri);
							$total_bayar_karoseri = ($total_bayar_karoseri - $dataKreditKaroseri->jumlah_bayar);
							$sisa_hutang_karoseri = ($result->lunas_karoseri - $total_bayar_karoseri);
						} else {
							$total_bayar_karoseri = 0;
							$sisa_hutang_karoseri = 0;
						}
					} else {
						$total_bayar_karoseri = ($bayar_karoseri->jumlah_bayar + $result->dp_karoseri);
						$sisa_hutang_karoseri = ($result->lunas_karoseri - $total_bayar_karoseri);
					}

					$result->jumlah_bayar_karoseri = $bayar_karoseri->jumlah_bayar;
					$result->total_bayar_karoseri = $total_bayar_karoseri;
					$result->sisa_hutang_karoseri = $sisa_hutang_karoseri;

					$result->jumlah_bayar_karoseri_rp = "Rp.".number_format($result->jumlah_bayar_karoseri,0,",",".");
					$result->total_bayar_karoseri_rp = "Rp.".number_format($total_bayar_karoseri,0,",",".");
					$result->sisa_hutang_karoseri_rp = "Rp.".number_format($sisa_hutang_karoseri,0,",",".");
				}

				if($result->photo != ""){
					$result->photo = base_url()."uploads/admin/master/armada/".$result->photo;
				} else {
					$result->photo = base_url()."assets/images/default/no_image.jpg";
				}

				if ($result->ac != 0) {
					$result->ac_icon = '<i style="color:#8bc34a;" class="mdi mdi-checkbox-marked"></i>';
				} else {
					$result->ac_icon = '<i class="mdi mdi-checkbox-blank-outline"></i>';
				}

				if ($result->wifi != 0) {
					$result->wifi_icon = '<i style="color:#03a9f4;" class="mdi mdi-checkbox-marked"></i>';
				} else {
					$result->wifi_icon = '<i class="mdi mdi-checkbox-blank-outline"></i>';
				}
				
				$this->response->status = true;
				$this->response->data = $result;
			} else {
				$this->response->message = spanRed("Data tidak ada.");
			}
		}
		parent::json();
	}
}

/* End of file Armada.php */
/* Location: ./application/controllers/master/Armada.php */