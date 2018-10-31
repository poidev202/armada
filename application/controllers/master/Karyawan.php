<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('master/Karyawan_model',"karyawanModel");
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		parent::headerTitle("Master Karyawan","Master Karyawan","Karyawan");

		$breadcrumbs = array(
								"Master Karyawan"	=>	site_url('master/karyawan'),
								"Karyawan"	=>	"",
						);
		parent::breadcrumbs($breadcrumbs);

		parent::viewMaster();
	}

	public function ajax_list()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$select = array("master_karyawan.*","master_jabatan.nama_jabatan",);
			$columns = array(null,null,'nama','kode','tempat_lahir','tanggal_lahir','no_telp','nama_jabatan','status_kerja','alamat');

			$search = array('nama','kode','alamat','tempat_lahir','tanggal_lahir','no_telp','nama_jabatan','status_kerja');

			$join = array(
							array("master_jabatan","master_jabatan.id = master_karyawan.jabatan_id","LEFT"),
						);

			$result = $this->karyawanModel->findDataTable(false,$select,$columns,$search,$join);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";
				$item->tanggal_lahir = date_ind("d M Y", $item->tanggal_lahir);

				if($item->foto_karyawan != ""){
					$item->foto_karyawan = base_url()."uploads/admin/master/karyawan/orang/".$item->foto_karyawan;
				} else {
					$item->foto_karyawan = base_url()."assets/images/default/user_image.png";
				}

				$item->foto_karyawan = '<div class="img-thumbnail"><center><img src="'.$item->foto_karyawan.'" class="img img-responsive" style="width:60px; height:60px;"></center></div>';

				$btnAction = '<button type="button" onclick="detailKaryawan('.$item->id.')" class="btn btn btn-outline-info btn-xs m-b-10" title="Detail"><i class="fa fa-info-circle"></i> </button> &nbsp;'; // update

				$btnAction .= '<button type="button" onclick="editKaryawan('.$item->id.')" class="btn btn btn-outline-warning btn-xs m-b-10" title="Edit"><i class="fa fa-pencil-square-o"></i> </button> &nbsp;'; // update
				
				$btnAction .='<button type="button" onclick="btnDelete('.$item->id.')" class="btn btn-outline-danger btn-xs m-b-10" title="Hapus"><i class="fa fa-trash-o"></i> </button>'; // delete

				$item->button_action = $btnAction;

				$data[] = $item;
			}
			return $this->karyawanModel->findDataTableOutput($data,false,$search,$join);
		}
		parent::json();
	}

	public function _do_upload($path)
	{
		$config['upload_path']      = 	'uploads/admin/master/karyawan/'.$path.'/';
        $config['allowed_types']    = 	'gif|jpg|jpeg|png';
        $config['max_size']         = 	1024; // 1mb
        $config['max_width']        = 	2700;
        $config['max_height']       =	1700;
        $config['encrypt_name']		=	true;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
	}

	public function inputValidate()
	{
		$this->form_validation->set_rules('nama_karyawan', 'Nama Karyawan', 'trim|required');
		$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
		$this->form_validation->set_rules('kelamin', 'Jenis Kelamin', 'trim|required');
		$this->form_validation->set_rules('no_telp', 'No Telp', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('pendidikan', 'Pindidikan', 'trim|required');
		$this->form_validation->set_rules('kewarganegaraan', 'Kewarganegaraan', 'trim|required');
		$this->form_validation->set_rules('agama', 'Agama', 'trim|required');
		$this->form_validation->set_rules('status_nikah', 'Status nikah', 'trim|required');
		$this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
		$this->form_validation->set_rules('status_kerja', 'Status kerja', 'trim|required');
		$this->form_validation->set_rules('bank', 'Bank', 'trim|required');
		$this->form_validation->set_rules('atas_nama', 'Atas nama', 'trim|required');
		$this->form_validation->set_rules('no_rekening', 'No Rekening', 'trim|required');
		$this->form_validation->set_rules('npwp', 'NPWP', 'trim');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
		$this->form_validation->set_rules('periode_gaji', 'Periode gaji', 'trim|required');
		$this->form_validation->set_rules('gaji', 'Gaji', 'trim|required');
		$this->form_validation->set_rules('tgl_masuk_kerja', 'Tanggal masuk kerja', 'trim|required');
		$this->form_validation->set_rules('status_kontrak', 'Status kontrak', 'trim|required');
		// $this->form_validation->set_rules('tgl_awal_kontrak', 'Tanggal awal kontrak', 'trim|required');
		// $this->form_validation->set_rules('tgl_akhir_kontrak', 'Tanggal akhir kontrak', 'trim|required');
		$this->form_validation->set_rules('no_ktp', 'No KTP', 'trim|required');
		$this->form_validation->set_rules('bagian_supir', 'Bagian Dari Supir', 'trim|required');
		$this->form_validation->set_rules('tgl_jatuh_tempo_sim', 'Tanggal Jatuh Tempo SIM', 'trim');
	}

	public function add()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$nama_karyawan = $this->input->post("nama_karyawan");
			$tempat_lahir = $this->input->post("tempat_lahir");
			$tanggal_lahir = $this->input->post("tanggal_lahir");
			$kelamin = $this->input->post("kelamin");
			$no_telp = $this->input->post("no_telp");
			$email = $this->input->post("email");
			$pendidikan = $this->input->post("pendidikan");
			$kewarganegaraan = $this->input->post("kewarganegaraan");
			$agama = $this->input->post("agama");
			$status_nikah = $this->input->post("status_nikah");
			$jabatan = $this->input->post("jabatan");
			$status_kerja = $this->input->post("status_kerja");
			$bank = $this->input->post("bank");
			$atas_nama = $this->input->post("atas_nama");
			$no_rekening = $this->input->post("no_rekening");
			$npwp = $this->input->post("npwp");
			$alamat = $this->input->post("alamat");
			$periode_gaji = $this->input->post("periode_gaji");
			$gaji = $this->input->post("gaji");
			$tgl_masuk_kerja = $this->input->post("tgl_masuk_kerja");
			$status_kontrak = $this->input->post("status_kontrak");
			$tgl_awal_kontrak = $this->input->post("tgl_awal_kontrak");
			$tgl_akhir_kontrak = $this->input->post("tgl_akhir_kontrak");
			$no_ktp = $this->input->post("no_ktp");
			$no_sim = $this->input->post("no_sim");
			$tgl_jatuh_tempo_sim = $this->input->post("tgl_jatuh_tempo_sim");
			$bagian_supir = $this->input->post("bagian_supir");

			// validate form input
			self::inputValidate();

			if ($status_kontrak == "aktif") {
				$this->form_validation->set_rules('tgl_awal_kontrak', 'Tanggal awal kontrak', 'trim|required');
				$this->form_validation->set_rules('tgl_akhir_kontrak', 'Tanggal akhir kontrak', 'trim|required');
			}

			if ($bagian_supir == "ya") {
				$this->form_validation->set_rules('no_sim', 'No SIM', 'trim|required');
				$this->form_validation->set_rules('tgl_jatuh_tempo_sim', 'Tanggal Jatuh Tempo SIM', 'trim|required');
			}

			if ($this->form_validation->run() == true) {

				$kode_akhir = $this->karyawanModel->getAll(false,array("kode"),array("LPAD(lower(kode), 10,0) DESC"));
				if ($kode_akhir == null) {
					$kodeKaryawan = 'KRY-1';
				} else {
			        $kodeUrut = (int) substr($kode_akhir[0]->kode, strpos($kode_akhir[0]->kode, '-') + 1); 
			        $kodeKaryawan = 'KRY-'.($kodeUrut + 1); 
			    }
				
				$data = array(
							"kode"				=>	$kodeKaryawan,
							"nama"				=>	ucfirst($nama_karyawan),
							"tempat_lahir"		=>	$tempat_lahir,
							"tanggal_lahir"		=>	$tanggal_lahir,
							"kelamin"			=>	$kelamin,
							"no_telp"			=>	$no_telp,
							"email"				=>	$email,
							"pendidikan"		=>	$pendidikan,
							"kewarganegaraan"	=>	$kewarganegaraan,
							"agama"				=>	$agama,
							"status_nikah"		=>	$status_nikah,
							"jabatan_id"		=>	$jabatan,
							"status_kerja"		=>	$status_kerja,
							"bank_id"			=>	$bank,
							"atas_nama"			=>	$atas_nama,
							"no_rekening"		=>	$no_rekening,
							"npwp"				=>	$npwp,
							"alamat"			=>	$alamat,
							"periode_gaji"		=>	$periode_gaji,
							"gaji"				=>	$gaji,
							"tgl_masuk_kerja"	=>	$tgl_masuk_kerja,
							"status_kontrak"	=>	$status_kontrak,
							"no_ktp"			=>	$no_ktp,
							"no_sim"			=>	$no_sim,
							"bagian_supir"		=>	$bagian_supir
						);
				if ($status_kontrak == "aktif") {
					$data["tgl_awal_kontrak"]	=	$tgl_awal_kontrak;
					$data["tgl_akhir_kontrak"]	=	$tgl_akhir_kontrak;
				} else {
					$data["tgl_awal_kontrak"]	=	NULL;
					$data["tgl_akhir_kontrak"]	=	NULL;
				}

				if (!empty(trim($no_sim))) {
					$data["tgl_jatuh_tempo_sim"]	=	$tgl_jatuh_tempo_sim;
				} else {
					$data["tgl_jatuh_tempo_sim"]	=	NULL;
				}

				/*variabel error photo berkas*/
				$error_foto_karyawan = "";
				$error_foto_kk = "";
				$error_foto_lamaran = "";
				$error_foto_urine = "";
				$error_foto_ktp = "";
				$error_foto_sim = "";

				/*for foto karyawan*/
				if (!empty($_FILES["foto_karyawan"]["name"])) {
					// config upload
					self::_do_upload("orang");
					if ($error_foto_lamaran != "" || $error_foto_urine != "" || $error_foto_kk != "" || $error_foto_ktp != "" || $error_foto_sim != "") {
					} else {
						if (!$this->upload->do_upload("foto_karyawan")) {
							$this->response->message = "error_foto";
							$error_foto_karyawan = $this->upload->display_errors('<small style="color:red;">', '</small>');
							$this->response->error = $error_foto_karyawan;
						} else {
							$foto_karyawan = $this->upload->data();
							$data["foto_karyawan"]	= $foto_karyawan["file_name"];
						}
					}
				} else {
					$data["foto_karyawan"]	= "";
				}

				/*for foto kk*/
				if (!empty($_FILES["foto_kk"]["name"])) {
					// config upload
					self::_do_upload("kk");
					if ($error_foto_karyawan != "" || $error_foto_lamaran != "" || $error_foto_urine != "" || $error_foto_ktp != "" || $error_foto_sim != "") {
					} else {
						if (!$this->upload->do_upload("foto_kk")) {
							$this->response->message = "error_foto";
							$error_foto_kk = $this->upload->display_errors('<small style="color:red;">', '</small>');
							$this->response->error = $error_foto_kk;
						} else {
							$foto_kk = $this->upload->data();
							$data["foto_kk"]	= $foto_kk["file_name"];
						}
					}
				} else {
					$data["foto_kk"]	= "";
				}

				/*for foto surat_lamaran*/
				if (!empty($_FILES["foto_surat_lamaran"]["name"])) {
					// config upload
					self::_do_upload("lamaran");
					if ($error_foto_karyawan != "" || $error_foto_urine != "" || $error_foto_kk != "" || $error_foto_ktp != "" || $error_foto_sim != "") {
					} else {
						if (!$this->upload->do_upload("foto_surat_lamaran")) {
							$this->response->message = "error_foto";
							$error_foto_lamaran = $this->upload->display_errors('<small style="color:red;">', '</small>');
							$this->response->error = $error_foto_lamaran;
						} else {
							$foto_surat_lamaran = $this->upload->data();
							$data["foto_surat_lamaran"]	= $foto_surat_lamaran["file_name"];
						}
					}
				} else {
					$data["foto_surat_lamaran"]	= "";
				}

				/*for foto test_urine*/
				if (!empty($_FILES["foto_test_urine"]["name"])) {
					// config upload
					self::_do_upload("urine");
					if ($error_foto_karyawan != "" || $error_foto_lamaran != "" || $error_foto_kk != "" || $error_foto_ktp != "" || $error_foto_sim != "") {
					} else {
						if (!$this->upload->do_upload("foto_test_urine")) {
							$this->response->message = "error_foto";
							$error_foto_urine = $this->upload->display_errors('<small style="color:red;">', '</small>');
							$this->response->error = $error_foto_urine;
						} else {
							$foto_test_urine = $this->upload->data();
							$data["foto_test_urine"]	= $foto_test_urine["file_name"];
						}
					}
				} else {
					$data["foto_test_urine"]	= "";
				}

				/*for foto ktp*/
				if (!empty($_FILES["foto_ktp"]["name"])) {
					// config upload
					self::_do_upload("ktp");
					if ($error_foto_karyawan != "" || $error_foto_lamaran != "" || $error_foto_urine != "" || $error_foto_kk != "" || $error_foto_sim != "") {
					} else {
						if (!$this->upload->do_upload("foto_ktp")) {
							$this->response->message = "error_foto";
							$error_foto_ktp = $this->upload->display_errors('<small style="color:red;">', '</small>');
							$this->response->error = $error_foto_ktp;
						} else {
							$foto_ktp = $this->upload->data();
							$data["foto_ktp"]	= $foto_ktp["file_name"];
						}
					}
				} else {
					$data["foto_ktp"]	= "";
				}

				/*for foto sim*/
				if (!empty($_FILES["foto_sim"]["name"])) {
					// config upload
					self::_do_upload("sim");

					if ($error_foto_karyawan != "" || $error_foto_lamaran != "" || $error_foto_urine != "" || $error_foto_kk != "" || $error_foto_ktp != "") {
					} else {
						if (!$this->upload->do_upload("foto_sim")) {
							$this->response->message = "error_foto";
							$error_foto_sim = $this->upload->display_errors('<small style="color:red;">', '</small>');
							$this->response->error = $error_foto_sim;
						} else {
							$foto_sim = $this->upload->data();
							$data["foto_sim"]	= $foto_sim["file_name"];
						}
					}
				} else {
					$data["foto_sim"]	= "";
				}

				if ($error_foto_karyawan != "" || $error_foto_lamaran != "" || $error_foto_urine != "" || $error_foto_kk != "" || $error_foto_ktp != "" || $error_foto_sim != "") {
					
					$this->response->message = "error_foto";
					$this->response->error = array(
														"foto_karyawan"	=>	$error_foto_karyawan,
														"foto_kk"	=>	$error_foto_kk,
														"foto_surat_lamaran"	=>	$error_foto_lamaran,
														"foto_urine"	=>	$error_foto_urine,
														"foto_ktp"	=>	$error_foto_ktp,
														"foto_sim"	=>	$error_foto_sim,
													);
				} else {
					$insert = $this->karyawanModel->insert($data);
					// $insert = true;
					if ($insert) {
						$this->response->status = true;
						$this->response->message = alertSuccess("Data berhasil di tambah..");
						$this->response->data = $data;
					} else {
						$this->response->message = alertDanger("Gagal tambah data karyawan..");
					}
				}
				
			} else {
				$formValidate = $this->response->message = validation_errors('<li class="pull-left"><span class="text-danger">', '</span></li><br>');
				$this->response->message = $formValidate;
			}
		}
		parent::json();
	}

	public function getId($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$select = array("master_karyawan.*","master_jabatan.nama_jabatan","master_bank.nama_bank");
			$join = array(
							array("master_jabatan","master_jabatan.id = master_karyawan.jabatan_id","LEFT"),
							array("master_bank","master_bank.id = master_karyawan.bank_id","LEFT"),
						);
			$data = $this->karyawanModel->getByWhere(array("master_karyawan.id" => $id),$select,$join);
			if ($data) {
				$data->gaji_rp = "Rp.".number_format($data->gaji,0,',','.');
				$data->tanggal_lahir_indo = date_ind("d M Y", $data->tanggal_lahir);
				$data->tgl_masuk_kerja_indo = date_ind("d M Y", $data->tgl_masuk_kerja);
				$data->tgl_awal_kontrak_indo = date_ind("d M Y", $data->tgl_awal_kontrak);
				$data->tgl_akhir_kontrak_indo = date_ind("d M Y", $data->tgl_akhir_kontrak);
				if ($data->tgl_jatuh_tempo_sim != NULL) {
					$data->tgl_jatuh_tempo_sim_indo = date_ind("d M Y", $data->tgl_jatuh_tempo_sim);
				} else {
					$data->tgl_jatuh_tempo_sim_indo = "";
				}

				$data->status_nikah_ = str_replace("_", " ", $data->status_nikah);

				$this->response->status = true;
				$this->response->message = "data get By Id";
				$this->response->data = $data;
			} else {
				$this->response->message = alertDanger("Data tidak ada.");
			}
		}
		parent::json();
	}

	public function getAll()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$select = array("master_karyawan.*","master_jabatan.nama_jabatan","master_bank.nama_bank");
			$join = array(
							array("master_jabatan","master_jabatan.id = master_karyawan.jabatan_id","LEFT"),
							array("master_bank","master_bank.id = master_karyawan.bank_id","LEFT"),
						);
			$data = $this->karyawanModel->getAll(array("master_karyawan.status_kerja" => "aktif"),$select,array("nama ASC"),$join);
			if ($data) {
				foreach ($data as $item) {
					$item->gaji_rp = "Rp.".number_format($data->gaji,0,',','.');
				}

				$this->response->status = true;
				$this->response->message = "data get All";
				$this->response->data = $data;
			} else {
				$this->response->message = alertDanger("Data tidak ada.");
			}
		}
		parent::json();
	}

	public function getAllSupir()	// for supir di surat jalan / memo
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$where = array(
							"status_kerja" 	=> 	"aktif",
							"bagian_supir"	=>	"ya"
						);
			$select = array("id","nama","status_kerja","bagian_supir");
			$data = $this->karyawanModel->getAll($where,$select,array("nama ASC"));
			if ($data) {
				foreach ($data as $item) {
					$item->nama = ucfirst($item->nama);
				}

				$this->response->status = true;
				$this->response->message = "data get All just supir";
				$this->response->data = $data;
			} else {
				$this->response->message = spanRed("Data tidak ada.");
			}
		}
		parent::json();
	}

	public function getAllSupirAjax($supir)	// for supir di surat jalan / memo
	{
		parent::checkLoginUser(); // user login autentic checking

		if ($this->isPost()) {
			$orderBy = array("nama ASC");
			if (!isset($_POST["searchTerm"])) {
				$dataKaryawan = $this->karyawanModel->getAllSelect2(false,false,false,false,$orderBy);
			} else {
				$searchTerm = $this->input->post("searchTerm");
				$dataKaryawan = $this->karyawanModel->getAllSelect2(10,array("nama"=>$searchTerm),false,false,$orderBy);
			}
			// $data = array();
			if($dataKaryawan) {
				foreach ($dataKaryawan as $val) {
					// $data[] = array("id"=>$val->id, "text"=>$val->nama);
					if($val->foto_karyawan != ""){
						$val->foto_karyawan = base_url()."uploads/admin/master/karyawan/orang/".$val->foto_karyawan;
					} else {
						$val->foto_karyawan = base_url()."assets/images/default/user_image.png";
					}
					if ($supir == "supir1") {
						$val->text = "<img src='".$val->foto_karyawan."' style='height: 30px; width: 30px;'> <small>".$val->kode."</small><b> - ".$val->nama."</b> ";
					} else {
						$val->text = "<small>".$val->kode."</small><b> - ".$val->nama."</b> <img src='".$val->foto_karyawan."' style='height: 30px; width: 30px;'>";
					}
					$val->tanggal_lahir_indo = date_ind("d M Y", $val->tanggal_lahir);
				}	
				$this->response->status = true;
				$this->response->message = "Data Supir";
				$this->response->data = $dataKaryawan;
			} else {
				$this->response->message = "Data Supir tidak ada";
			}
		}
		parent::json();
	}

	public function getSupir($id)	
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$where = array(
							"id"			=>	$id,
							"status_kerja" 	=> 	"aktif",
							"bagian_supir"	=>	"ya"
						);
			$select = array("id","kode","nama","foto_karyawan");
			$data = $this->karyawanModel->getByWhere($where,$select);
			if ($data) {
				if($data->foto_karyawan != ""){
					$data->foto_karyawan = base_url()."uploads/admin/master/karyawan/orang/".$data->foto_karyawan;
				} else {
					$data->foto_karyawan = base_url()."assets/images/default/user_image.png";
				}
				$this->response->status = true;
				$this->response->message = "data get All just supir";
				$this->response->data = $data;
			} else {
				$this->response->message = alertDanger("Data tidak ada.");
			}
		}
		parent::json();
	}

	public function getByWhereSupir($kode)	
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {

			$where = array(
							"kode"	=>	$kode,
							// "nama" 	=> 	$nama,
						);
			$select = array("master_karyawan.id","kode","nama","foto_karyawan","tempat_lahir","tanggal_lahir","no_telp","alamat","nama_jabatan");
			$join = array(
							array("master_jabatan","master_jabatan.id = master_karyawan.jabatan_id","LEFT"),
						);

			$data = $this->karyawanModel->getByWhere($where,$select,$join);
			if ($data) {
				if($data->foto_karyawan != ""){
					$data->foto_karyawan = base_url()."uploads/admin/master/karyawan/orang/".$data->foto_karyawan;
				} else {
					$data->foto_karyawan = base_url()."assets/images/default/user_image.png";
				}
				$data->tanggal_lahir_indo = date_ind("d M Y", $data->tanggal_lahir);
				$this->response->status = true;
				$this->response->message = "data get All just supir";
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

			$getById = $this->karyawanModel->getById($id);

			if ($getById) {
				$nama_karyawan = $this->input->post("nama_karyawan");
				$tempat_lahir = $this->input->post("tempat_lahir");
				$tanggal_lahir = $this->input->post("tanggal_lahir");
				$kelamin = $this->input->post("kelamin");
				$no_telp = $this->input->post("no_telp");
				$email = $this->input->post("email");
				$pendidikan = $this->input->post("pendidikan");
				$kewarganegaraan = $this->input->post("kewarganegaraan");
				$agama = $this->input->post("agama");
				$status_nikah = $this->input->post("status_nikah");
				$jabatan = $this->input->post("jabatan");
				$status_kerja = $this->input->post("status_kerja");
				$bank = $this->input->post("bank");
				$atas_nama = $this->input->post("atas_nama");
				$no_rekening = $this->input->post("no_rekening");
				$npwp = $this->input->post("npwp");
				$alamat = $this->input->post("alamat");
				$periode_gaji = $this->input->post("periode_gaji");
				$gaji = $this->input->post("gaji");
				$tgl_masuk_kerja = $this->input->post("tgl_masuk_kerja");
				$status_kontrak = $this->input->post("status_kontrak");
				$tgl_awal_kontrak = $this->input->post("tgl_awal_kontrak");
				$tgl_akhir_kontrak = $this->input->post("tgl_akhir_kontrak");
				$no_ktp = $this->input->post("no_ktp");
				$no_sim = $this->input->post("no_sim");
				$tgl_jatuh_tempo_sim = $this->input->post("tgl_jatuh_tempo_sim");
				$bagian_supir = $this->input->post("bagian_supir");

				// validate form input
				self::inputValidate();

				if ($status_kontrak == "aktif") {
					$this->form_validation->set_rules('tgl_awal_kontrak', 'Tanggal awal kontrak', 'trim|required');
					$this->form_validation->set_rules('tgl_akhir_kontrak', 'Tanggal akhir kontrak', 'trim|required');
				}

				if ($bagian_supir == "ya") {
					$this->form_validation->set_rules('no_sim', 'No SIM', 'trim|required');
					$this->form_validation->set_rules('tgl_jatuh_tempo_sim', 'Tanggal Jatuh Tempo SIM', 'trim|required');
				}

				if ($this->form_validation->run() == true) {

					$data = array(
								"id"				=>	$id,
								"nama"				=>	ucfirst($nama_karyawan),
								"tempat_lahir"		=>	$tempat_lahir,
								"tanggal_lahir"		=>	$tanggal_lahir,
								"kelamin"			=>	$kelamin,
								"no_telp"			=>	$no_telp,
								"email"				=>	$email,
								"pendidikan"		=>	$pendidikan,
								"kewarganegaraan"	=>	$kewarganegaraan,
								"agama"				=>	$agama,
								"status_nikah"		=>	$status_nikah,
								"jabatan_id"		=>	$jabatan,
								"status_kerja"		=>	$status_kerja,
								"bank_id"			=>	$bank,
								"atas_nama"			=>	$atas_nama,
								"no_rekening"		=>	$no_rekening,
								"npwp"				=>	$npwp,
								"alamat"			=>	$alamat,
								"periode_gaji"		=>	$periode_gaji,
								"gaji"				=>	$gaji,
								"tgl_masuk_kerja"	=>	$tgl_masuk_kerja,
								"status_kontrak"	=>	$status_kontrak,
								"no_ktp"			=>	$no_ktp,
								"no_sim"			=>	$no_sim,
								"bagian_supir"		=>	$bagian_supir,
								"updated_at"		=>	date("Y-m-d H:i:s"),
							);
					if ($status_kontrak == "aktif") {
						$data["tgl_awal_kontrak"]	=	$tgl_awal_kontrak;
						$data["tgl_akhir_kontrak"]	=	$tgl_akhir_kontrak;
					} else {
						$data["tgl_awal_kontrak"]	=	NULL;
						$data["tgl_akhir_kontrak"]	=	NULL;
					}

					if (!empty(trim($no_sim))) {
						$data["tgl_jatuh_tempo_sim"]	=	$tgl_jatuh_tempo_sim;
					} else {
						$data["tgl_jatuh_tempo_sim"]	=	NULL;
					}

					/*variabel error photo berkas*/
					$error_foto_karyawan = "";
					$error_foto_kk = "";
					$error_foto_lamaran = "";
					$error_foto_urine = "";
					$error_foto_ktp = "";
					$error_foto_sim = "";

					/*for foto karyawan*/
					if (!empty($_FILES["foto_karyawan"]["name"])) {
						// config upload
						self::_do_upload("orang");
						if ($error_foto_lamaran != "" || $error_foto_urine != "" || $error_foto_kk != "" || $error_foto_ktp != "" || $error_foto_sim != "") {
						} else {
							if (!$this->upload->do_upload("foto_karyawan")) {
								$this->response->message = "error_foto";
								$error_foto_karyawan = $this->upload->display_errors('<small style="color:red;">', '</small>');
								$this->response->error = $error_foto_karyawan;
							} else {
								$foto_karyawan = $this->upload->data();
								$data["foto_karyawan"]	= $foto_karyawan["file_name"];

								if (file_exists("uploads/admin/master/karyawan/orang/".$getById->foto_karyawan) && $getById->foto_karyawan) {
									unlink("uploads/admin/master/karyawan/orang/".$getById->foto_karyawan);
								}
							}
						}
					} else {
						if ($this->input->post("is_delete_karyawan") == 1) {
							$data["foto_karyawan"]	= "";
							if (file_exists("uploads/admin/master/karyawan/orang/".$getById->foto_karyawan) && $getById->foto_karyawan) {
								unlink("uploads/admin/master/karyawan/orang/".$getById->foto_karyawan);
							}
						}
					}

					/*for foto kk*/
					if (!empty($_FILES["foto_kk"]["name"])) {
						// config upload
						self::_do_upload("kk");
						if ($error_foto_karyawan != "" || $error_foto_lamaran != "" || $error_foto_urine != "" || $error_foto_ktp != "" || $error_foto_sim != "") {
						} else {
							if (!$this->upload->do_upload("foto_kk")) {
								$this->response->message = "error_foto";
								$error_foto_kk = $this->upload->display_errors('<small style="color:red;">', '</small>');
								$this->response->error = $error_foto_kk;
							} else {
								$foto_kk = $this->upload->data();
								$data["foto_kk"]	= $foto_kk["file_name"];

							if (file_exists("uploads/admin/master/karyawan/kk/".$getById->foto_kk) && $getById->foto_kk) {
									unlink("uploads/admin/master/karyawan/kk/".$getById->foto_kk);
								}
							}
						}
					} else {
						if ($this->input->post("is_delete_kk") == 1) {
							$data["foto_kk"]	= "";
							if (file_exists("uploads/admin/master/karyawan/kk/".$getById->foto_kk) && $getById->foto_kk) {
								unlink("uploads/admin/master/karyawan/kk/".$getById->foto_kk);
							}
						}
					}

					/*for foto surat_lamaran*/
					if (!empty($_FILES["foto_surat_lamaran"]["name"])) {
						// config upload
						self::_do_upload("lamaran");
						if ($error_foto_karyawan != "" || $error_foto_urine != "" || $error_foto_kk != "" || $error_foto_ktp != "" || $error_foto_sim != "") {
						} else {
							if (!$this->upload->do_upload("foto_surat_lamaran")) {
								$this->response->message = "error_foto";
								$error_foto_lamaran = $this->upload->display_errors('<small style="color:red;">', '</small>');
								$this->response->error = $error_foto_lamaran;
							} else {
								$foto_surat_lamaran = $this->upload->data();
								$data["foto_surat_lamaran"]	= $foto_surat_lamaran["file_name"];

							if (file_exists("uploads/admin/master/karyawan/lamaran/".$getById->foto_surat_lamaran) && $getById->foto_surat_lamaran) {
									unlink("uploads/admin/master/karyawan/lamaran/".$getById->foto_surat_lamaran);
								}
							}
						}
					} else {
						if ($this->input->post("is_delete_surat_lamaran") == 1) {
							$data["foto_surat_lamaran"]	= "";
							if (file_exists("uploads/admin/master/karyawan/lamaran/".$getById->foto_surat_lamaran) && $getById->foto_surat_lamaran) {
								unlink("uploads/admin/master/karyawan/lamaran/".$getById->foto_surat_lamaran);
							}
						}
					}

					/*for foto test_urine*/
					if (!empty($_FILES["foto_test_urine"]["name"])) {
						// config upload
						self::_do_upload("urine");
						if ($error_foto_karyawan != "" || $error_foto_lamaran != "" || $error_foto_kk != "" || $error_foto_ktp != "" || $error_foto_sim != "") {
						} else {
							if (!$this->upload->do_upload("foto_test_urine")) {
								$this->response->message = "error_foto";
								$error_foto_urine = $this->upload->display_errors('<small style="color:red;">', '</small>');
								$this->response->error = $error_foto_urine;
							} else {
								$foto_test_urine = $this->upload->data();
								$data["foto_test_urine"]	= $foto_test_urine["file_name"];

								if (file_exists("uploads/admin/master/karyawan/urine/".$getById->foto_test_urine) && $getById->foto_test_urine) {
									unlink("uploads/admin/master/karyawan/urine/".$getById->foto_test_urine);
								}
							}
						}
					} else {
						if ($this->input->post("is_delete_test_urine") == 1) {
							$data["foto_test_urine"]	= "";
							if (file_exists("uploads/admin/master/karyawan/urine/".$getById->foto_test_urine) && $getById->foto_test_urine) {
								unlink("uploads/admin/master/karyawan/urine/".$getById->foto_test_urine);
							}
						}
					}

					/*for foto ktp*/
					if (!empty($_FILES["foto_ktp"]["name"])) {
						// config upload
						self::_do_upload("ktp");
						if ($error_foto_karyawan != "" || $error_foto_lamaran != "" || $error_foto_urine != "" || $error_foto_kk != "" || $error_foto_sim != "") {
						} else {
							if (!$this->upload->do_upload("foto_ktp")) {
								$this->response->message = "error_foto";
								$error_foto_ktp = $this->upload->display_errors('<small style="color:red;">', '</small>');
								$this->response->error = $error_foto_ktp;
							} else {
								$foto_ktp = $this->upload->data();
								$data["foto_ktp"]	= $foto_ktp["file_name"];

							if (file_exists("uploads/admin/master/karyawan/ktp/".$getById->foto_ktp) && $getById->foto_ktp) {
									unlink("uploads/admin/master/karyawan/ktp/".$getById->foto_ktp);
								}
							}
						}
					} else {
						if ($this->input->post("is_delete_ktp") == 1) {
							$data["foto_ktp"]	= "";
							if (file_exists("uploads/admin/master/karyawan/ktp/".$getById->foto_ktp) && $getById->foto_ktp) {
								unlink("uploads/admin/master/karyawan/ktp/".$getById->foto_ktp);
							}
						}
					}

					/*for foto sim*/
					if (!empty($_FILES["foto_sim"]["name"])) {
						// config upload
						self::_do_upload("sim");

						if ($error_foto_karyawan != "" || $error_foto_lamaran != "" || $error_foto_urine != "" || $error_foto_kk != "" || $error_foto_ktp != "") {
						} else {
							if (!$this->upload->do_upload("foto_sim")) {
								$this->response->message = "error_foto";
								$error_foto_sim = $this->upload->display_errors('<small style="color:red;">', '</small>');
								$this->response->error = $error_foto_sim;
							} else {
								$foto_sim = $this->upload->data();
								$data["foto_sim"]	= $foto_sim["file_name"];

							if (file_exists("uploads/admin/master/karyawan/sim/".$getById->foto_sim) && $getById->foto_sim) {
									unlink("uploads/admin/master/karyawan/sim/".$getById->foto_sim);
								}
							}
						}
					} else {
						if ($this->input->post("is_delete_sim") == 1) {
							$data["foto_sim"]	= "";
							if (file_exists("uploads/admin/master/karyawan/sim/".$getById->foto_sim) && $getById->foto_sim) {
								unlink("uploads/admin/master/karyawan/sim/".$getById->foto_sim);
							}
						}
					}

					if ($error_foto_karyawan != "" || $error_foto_lamaran != "" || $error_foto_urine != "" || $error_foto_kk != "" || $error_foto_ktp != "" || $error_foto_sim != "") {
						
						$this->response->message = "error_foto";
						$this->response->error = array(
															"foto_karyawan"	=>	$error_foto_karyawan,
															"foto_kk"	=>	$error_foto_kk,
															"foto_surat_lamaran"	=>	$error_foto_lamaran,
															"foto_urine"	=>	$error_foto_urine,
															"foto_ktp"	=>	$error_foto_ktp,
															"foto_sim"	=>	$error_foto_sim,
														);
					} else {
						$update = $this->karyawanModel->update($data);
						if ($update) {
							$this->response->status = true;
							$this->response->message = alertSuccess("Data berhasil di update..");
							$this->response->data = $data;
						} else {
							$this->response->message = alertDanger("Gagal update data karyawan..");
						}
					}
					
				} else {
					$formValidate = $this->response->message = validation_errors('<li class="pull-left"><span class="text-danger">', '</span></li><br>');
					$this->response->message = $formValidate;
				}
			} else {
				$this->response->message = spanRed("Data sudah tidak ada..!");
			}
		}
		parent::json();
	}

	public function delete($id)
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$getById = $this->karyawanModel->getById($id);
			if ($getById) {

				$delete = $this->karyawanModel->delete($id);
				if ($delete) {
					$this->response->status = true;
					$this->response->message = spanGreen("Data berhasil di hapus.");

					if (file_exists("uploads/admin/master/karyawan/orang/".$getById->foto_karyawan) && $getById->foto_karyawan) {
						unlink("uploads/admin/master/karyawan/orang/".$getById->foto_karyawan);
					}

					if (file_exists("uploads/admin/master/karyawan/kk/".$getById->foto_kk) && $getById->foto_kk) {
						unlink("uploads/admin/master/karyawan/kk/".$getById->foto_kk);
					}

					if (file_exists("uploads/admin/master/karyawan/lamaran/".$getById->foto_surat_lamaran) && $getById->foto_surat_lamaran) {
						unlink("uploads/admin/master/karyawan/lamaran/".$getById->foto_surat_lamaran);
					}

					if (file_exists("uploads/admin/master/karyawan/urine/".$getById->foto_test_urine) && $getById->foto_test_urine) {
						unlink("uploads/admin/master/karyawan/urine/".$getById->foto_test_urine);
					}

					if (file_exists("uploads/admin/master/karyawan/ktp/".$getById->foto_ktp) && $getById->foto_ktp) {
						unlink("uploads/admin/master/karyawan/ktp/".$getById->foto_ktp);
					}

					if (file_exists("uploads/admin/master/karyawan/sim/".$getById->foto_sim) && $getById->foto_sim) {
						unlink("uploads/admin/master/karyawan/sim/".$getById->foto_sim);
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
}

/* End of file Karyawan.php */
/* Location: ./application/controllers/master/Karyawan.php */