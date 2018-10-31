<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suratjalan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('performa/suratjalan_model',"suratjalanModel");
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleSupervisor(); // check role atau level function

		parent::headerTitle("Surat Jalan / Trip","Performa","Surat Jalan / Trip");

		$breadcrumbs = array(
								"Performa"	=> 	site_url('performa/suratjalan'),
								"Surat jalan/trip"	=>	"",
							);

		parent::breadcrumbs($breadcrumbs);

		parent::viewPerforma();
	}

	public function ajax_list()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleSupervisor(); // check role atau level function

		if ($this->isPost()) {

			$select = array("performa_surat_jalan.*","master_armada.nama","master_armada.no_bk","master_jadwal.hari","master_jadwal.jam","master_jadwal.tujuan_awal","master_jadwal.tujuan_akhir");

			$columns = array(null,'performa_surat_jalan.tanggal','nama','no_bk','nama_supir1','nama_supir2','hari','jam','tujuan_awal','tujuan_akhir');

			$search = array('performa_surat_jalan.tanggal','nama','no_bk','kode_supir1','nama_supir1','kode_supir2','nama_supir2','hari','jam','tujuan_awal','tujuan_akhir');

			$join = array(
							array("master_armada","master_armada.id = performa_surat_jalan.armada_id","LEFT"),
							array("master_jadwal","master_jadwal.id = performa_surat_jalan.jadwal_id","LEFT"),
						);

			$result = $this->suratjalanModel->findDataTable(false,$select,$columns,$search,$join);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";

				$item->tanggal = date_ind("d M Y", $item->tanggal);

				$item->jam = explode(":", $item->jam);
				$item->jam = $item->jam[0].":".$item->jam[1];
				
				$btnAction ='<button type="button" onclick="btnDetail('.$item->id.')" class="btn btn-outline-info btn-xs m-b-10" title="Detail"><i class="fa fa-info-circle"></i> Print</button>'; // delete

				$item->button_action = $btnAction;

				$data[] = $item;
			}
			return $this->suratjalanModel->findDataTableOutput($data,false,$search,$join);
		}
		parent::json();
	}

	public function convertTglHari($tgl)
	{
		$tgl = date("D", strtotime($tgl));
		if ($tgl == "Sun") {
			$hari = "minggu";
		} else if ($tgl == "Mon") {
			$hari = "senin";
		} else if ($tgl == "Tue") {
			$hari = "selasa";
		} else if ($tgl == "Wed") {
			$hari = "rabu";
		} else if ($tgl == "Thu") {
			$hari = "kamis";
		} else if ($tgl == "Fri") {
			$hari = "jumat";
		} else if ($tgl == "Sat") {
			$hari = "sabtu";
		}
		return $hari;
	}

	public function checkHariPerTanggal($tgl=false)
	{
		$this->load->model('master/Jadwal_model',"jadwalModel");
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			if ($tgl) {
				$hari = self::convertTglHari($tgl);
			} else {
				$tgl = date("Y-m-d");
				$hari = self::convertTglHari($tgl);
			}	

			$checkTglTrip = $this->suratjalanModel->getByWhere(array("tanggal"=>$tgl));
			if(!$checkTglTrip) {
				$dataJadwal = $this->jadwalModel->getAll(array("hari"=>$hari),false,array("jam ASC"));
				if ($dataJadwal) {
					$result = "";
					$no = 0;
					foreach ($dataJadwal as $item) {
						$no++;
						$item->jam = explode(":",$item->jam);
						$item->jam = $item->jam[0].":".$item->jam[1];
						$result .= '<tr><td>'.$no.'</td><td>'.$item->jam.'</td><td>'.$item->tujuan_akhir.'<input type="hidden" name="jadwal_id[]" value="'.$item->id.'"></td><td><select id="nama_armada'.$no.'" name="nama_armada[]" class="form-control " style="width: 100%"></select></td><td class="text-nowrap"><select id="supir1_'.$no.'" name="supir1[]" class="form-control select2" style="width: 100%"></select></td><td class="text-nowrap"><select id="supir2_'.$no.'" name="supir2[]" class="form-control select2" style="width: 100%"></select></td></tr>';
					}

					$this->response->status = true;
					$this->response->message = "Data jadwal hari ".$hari;
					$this->response->hari_tgl = date_ind("l, d M Y", $tgl);
					$this->response->tanggal = $tgl;
					$this->response->data = $result;
					$this->response->count_data = count($dataJadwal);
				} else {
					$this->response->message = alertDanger("Tidak ada Data jadwal hari ".$hari);
				}
			} else {
				$this->response->message = alertDanger("Opps, Maaf Tanggal yang anda pilih sudah ada.!<br>Silahkan check Table Log Surat Jalan / Trip");
			}
		}
		parent::json();
	}

	public function checkProses()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleSupervisor(); // check role atau level function

		if ($this->isPost()) {
			$armada_id = $this->input->post("nama_armada");
			$tanggal = $this->input->post("tanggal");
			$kode_supir1 = $this->input->post("kode_supir1");
			$nama_supir1 = $this->input->post("nama_supir1");
			$kode_supir2 = $this->input->post("kode_supir2");
			$nama_supir2 = $this->input->post("nama_supir2");
			$jadwal_id = $this->input->post("id_jadwal_jam");
			$penanggung_jawab = $this->input->post("penanggung_jawab");

			$this->form_validation->set_rules('nama_armada', 'Nama Armada', 'trim|required');
			$this->form_validation->set_rules('nama_supir1', 'Supir 1', 'trim|required');
			$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
			$this->form_validation->set_rules('id_jadwal_jam', 'Jadwal Keberangkatan', 'trim|required');
			$this->form_validation->set_rules('penanggung_jawab', 'Penanggung Jawab', 'trim|required');

			if ($this->form_validation->run() == TRUE) {
				$data = array(
								"tanggal"		=>	$tanggal,
								"armada_id"		=>	$armada_id,
								"kode_supir1"	=>	$kode_supir1,
								"nama_supir1"	=>	$nama_supir1,
								"kode_supir2"	=>	$kode_supir2,
								"nama_supir2"	=>	$nama_supir2,
								"jadwal_id"		=>	$jadwal_id,
								"penanggung_jawab"	=>	ucfirst($penanggung_jawab),
							);
				$checkStatusArmada = $this->suratjalanModel->checkStatusArmada($armada_id);
				$statusWarna = "";
				if($checkStatusArmada){
					if ($checkStatusArmada->warna_merah == "merah") {
						$statusWarna = "merah";
					} else if ($checkStatusArmada->warna_kuning == "kuning") {
						$statusWarna = "kuning";
					} else if ($checkStatusArmada->warna_hijau == "hijau") {
						$statusWarna = "hijau";
					} else if ($checkStatusArmada->warna_ungu == "ungu") {
						$statusWarna = "ungu";
					} else if ($checkStatusArmada->warna_ungu == "biru") {
						$statusWarna = "biru";
					}
				}

				if($statusWarna == "" || $statusWarna == "merah") {
					$checkDataSuratjalan = $this->suratjalanModel->getByWhere($data);
					if($checkDataSuratjalan) {
						$this->response->message = alertWarning("Opps, Maaf data yang anda input sudah terdaftar di Table Log Surat jalan.");
					} else {
						$this->response->status = true;
						$this->response->message = "Validate Surat Jalan / Memo true";
					}
				} else {
					if ($statusWarna == "kuning") {
						$this->response->message = alertWarning("Opps, Maaf Armada yang anda pilih masih berstatus warna kuning / sedang dijalan.!");
					} else if ($statusWarna == "hijau") {
						$this->response->message = alertSuccess("Opps, Maaf Armada yang anda pilih masih berstatus warna hijau / sedang dalam proses menuju ke bengkel untuk perawatan.!");
					} else if ($statusWarna == "ungu") {
						$this->response->message = alertInfo("Opps, Maaf Armada yang anda pilih masih berstatus warna ungu / sedang dalam perawatan di bengkel dan belum bisa stand by.!");
					} else if ($statusWarna == "biru") {
						$this->response->message = alertInfo("Opps, Maaf Armada yang anda pilih masih berstatus warna biru / sedang rusak di jalan.!");
					}
				}
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
			}
		}
		parent::json();
	}

	public function inputSuratJalan()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleSupervisor(); // check role atau level function

		if ($this->isPost()) {
			$armada_id = $this->input->post("nama_armada");
			$tanggal = $this->input->post("tanggal");
			$kode_supir1 = $this->input->post("kode_supir1");
			$nama_supir1 = $this->input->post("nama_supir1");
			$kode_supir2 = $this->input->post("kode_supir2");
			$nama_supir2 = $this->input->post("nama_supir2");
			$jadwal_id = $this->input->post("id_jadwal_jam");
			$penanggung_jawab = $this->input->post("penanggung_jawab");

			$data = array(
							"tanggal"		=>	$tanggal,
							"armada_id"		=>	$armada_id,
							"kode_supir1"	=>	$kode_supir1,
							"nama_supir1"	=>	$nama_supir1,
							"kode_supir2"	=>	$kode_supir2,
							"nama_supir2"	=>	$nama_supir2,
							"jadwal_id"		=>	$jadwal_id,
							"penanggung_jawab"	=>	ucfirst($penanggung_jawab),
						);
			$checkStatusArmada = $this->suratjalanModel->checkStatusArmada($armada_id);
			$statusWarna = "";
			if($checkStatusArmada){
				if ($checkStatusArmada->warna_merah == "merah") {
					$statusWarna = "merah";
				} else if ($checkStatusArmada->warna_kuning == "kuning") {
					$statusWarna = "kuning";
				} else if ($checkStatusArmada->warna_hijau == "hijau") {
					$statusWarna = "hijau";
				} else if ($checkStatusArmada->warna_ungu == "ungu") {
					$statusWarna = "ungu";
				} else if ($checkStatusArmada->warna_ungu == "biru") {
					$statusWarna = "biru";
				}
			}

			if($statusWarna == "" || $statusWarna == "merah") {
				$checkDataSuratjalan = $this->suratjalanModel->getByWhere($data);
				if($checkDataSuratjalan) {
					$this->response->message = alertWarning("Opps, Maaf data yang anda input sudah terdaftar di Table Log Surat jalan.");
				} else {
					$insert = $this->suratjalanModel->transactionInsert($data);
					if ($insert) {
						$this->response->status = true;
						$this->response->message = alertSuccess("Berhasil Memproses Surat Jalan / Memo");
						$this->response->data = array("id" => $insert);
					} else {
						$this->response->message = alertDanger("Opps, Gagal Memproses Surat Jalan / Memo");
					}
				}
			} else {
				if ($statusWarna == "kuning") {
					$this->response->message = alertWarning("Opps, Maaf Armada yang anda pilih masih berstatus warna kuning / sedang dijalan.!");
				} else if ($statusWarna == "hijau") {
					$this->response->message = alertSuccess("Opps, Maaf Armada yang anda pilih masih berstatus warna hijau / sedang dalam proses menuju ke bengkel untuk perawatan.!");
				} else if ($statusWarna == "ungu") {
					$this->response->message = alertInfo("Opps, Maaf Armada yang anda pilih masih berstatus warna ungu / sedang dalam perawatan di bengkel dan belum bisa stand by.!");
				} else if ($statusWarna == "biru") {
					$this->response->message = alertInfo("Opps, Maaf Armada yang anda pilih masih berstatus warna biru / sedang rusak di jalan.!");
				}
			}
		}
		parent::json();
	}

	/*baru revisi ya*/
	public function checkTrip()
	{
		parent::checkLoginUser(); // otoritas authentic function
		$tgl_hari_jadwal = $this->input->post('tgl_hari_jadwal');
		$jadwal_id = $this->input->post('jadwal_id');
		$nama_armada = $this->input->post('nama_armada');
		$supir1 = $this->input->post('supir1');
		$supir2 = $this->input->post('supir2');

		$this->form_validation->set_rules('tgl_hari_jadwal', 'Tanggal Jadwal Trip', 'trim|required');
		for ($i=0; $i < count($jadwal_id); $i++) { 
			$this->form_validation->set_rules("jadwal_id[".$i."]","No. ".($i + 1)." - Jadwal ","trim|required");
			$this->form_validation->set_rules("nama_armada[".$i."]","No. ".($i + 1)." - Armada ","trim|required");
			$this->form_validation->set_rules("supir1[".$i."]","No. ".($i + 1)." - Supir 1 ","trim|required");
			$this->form_validation->set_rules("supir2[".$i."]","No. ".($i + 1)." - Supir 2 ","trim|required");
		}

		if ($this->form_validation->run() == TRUE) {
			$this->response->status = true;
			$this->response->message = "Validate check input trip";
		} else {
			$this->response->message = validation_errors('<span class="pull-left" style="color:red;">', '</span><br>');
		}
		parent::json();
	}

	public function saveTrip()
	{
		parent::checkLoginUser(); // otoritas authentic function
		$this->load->model('master/Karyawan_model',"karyawanModel");

		$tgl_hari_jadwal = $this->input->post('tgl_hari_jadwal');
		$jadwal_id = $this->input->post('jadwal_id');
		$nama_armada = $this->input->post('nama_armada');
		$supir1 = $this->input->post('supir1');
		$supir2 = $this->input->post('supir2');

		$this->form_validation->set_rules('tgl_hari_jadwal', 'Tanggal Jadwal Trip', 'trim|required');
		$no = 0;
		foreach ($jadwal_id as $item) {
			$this->form_validation->set_rules("jadwal_id[".$no."]","No. ".($no + 1)." - Jadwal ","trim|required");
			$this->form_validation->set_rules("nama_armada[".$no."]","No. ".($no + 1)." - Armada ","trim|required");
			$this->form_validation->set_rules("supir1[".$no."]","No. ".($no + 1)." - Supir 1 ","trim|required");
			$this->form_validation->set_rules("supir2[".$no."]","No. ".($no + 1)." - Supir 2 ","trim|required");
			$no++;
		}

		if ($this->form_validation->run() == TRUE) {
			$data = array();
			$armadaId = array();
			for ($i=0; $i < count($jadwal_id); $i++) { 
				$kode_supir1 = "";
				$nama_supir1 = "";
				$dataSupir1 = $this->karyawanModel->getById($supir1[$i]);
				if ($dataSupir1) {
					$kode_supir1 = $dataSupir1->kode;
					$nama_supir1 = $dataSupir1->nama;
				}

				$kode_supir2 = "";
				$nama_supir2 = "";
				$dataSupir2 = $this->karyawanModel->getById($supir2[$i]);
				if ($dataSupir2) {
					$kode_supir2 = $dataSupir2->kode;
					$nama_supir2 = $dataSupir2->nama;
				}

				$row = array(
								"tanggal"		=>	$tgl_hari_jadwal,
								"jadwal_id"		=>	$jadwal_id[$i],
								"armada_id"		=>	$nama_armada[$i],
								"kode_supir1"	=>	$kode_supir1,
								"nama_supir1"	=>	$nama_supir1,
								"kode_supir2"	=>	$kode_supir2,
								"nama_supir2"	=>	$nama_supir2,
							);
				$data[] = $row;
				$armadaId[] = $nama_armada[$i];
			}
			$insert = $this->suratjalanModel->insertTransaction($data,$armadaId);
			if ($insert) {
				$this->response->status = true;
				$this->response->message = alertSuccess("Berhasil Simpan data trip / surat jalan");
				// $this->response->data = $data;
				// $this->response->armadaId = $armadaId;
			} else {
				$this->response->message = alertDanger("Opps, Gagal Simpan data trip / surat jalan");
			}
		} else {
			$this->response->message = validation_errors('<span class="pull-left" style="color:red;">', '</span><br>');
		}
		parent::json();
	}

	public function dataPrintTrip($tglTrip=false)
	{	
		parent::checkLoginUser(); // otoritas authentic function
		if ($this->isPost()) {
			if (!$tglTrip) {
				$tglTrip = date("Y-m-d");
			}
			$select = array("performa_surat_jalan.*","master_armada.nama","master_armada.no_bk","master_jadwal.jam","master_jadwal.tujuan_akhir");
			$orderBy = array("jam ASC");
			$join = array(
							array("master_armada","master_armada.id = performa_surat_jalan.armada_id","LEFT"),
							array("master_jadwal","master_jadwal.id = performa_surat_jalan.jadwal_id","LEFT"),
						);
			$dataTrip = $this->suratjalanModel->getAll(array("performa_surat_jalan.tanggal"=>$tglTrip),$select,$orderBy,$join);
			if ($dataTrip) {
				$result = "";
				$no = 0;
				foreach ($dataTrip as $item) {
					$no++;
					$item->jam = explode(":",$item->jam);
					$item->jam = $item->jam[0].":".$item->jam[1];
					$result .= '<tr><td>'.$no.'</td><td>'.$item->jam.'</td><td>'.$item->tujuan_akhir.'</td><td><small>'.$item->no_bk."</small> - ".$item->nama.'</td><td class="text-nowrap">'.$item->nama_supir1.'</td><td class="text-nowrap">'.$item->nama_supir2.'</td></tr>';
				}
				$this->response->status = true;
				$this->response->message = "Data trip per tanggal";
				$this->response->data = $result;
				$this->response->hari_tglTrip = date_ind("l, d M Y", $tglTrip);
			} else {
				$this->response->message = alertDanger("Data Surat jalan / Trip tida ada.!");
			}
		}
		parent::json();
	}
	/*end baru revisi ya*/

	public function getId($id)
	{
		parent::checkLoginUser(); // otoritas authentic function
		// parent::checkUserRoleSupervisor(); // check role atau level function

		if ($this->isPost()) {
			$select = array("performa_surat_jalan.*","master_armada.nama","master_armada.no_bk","master_jadwal.hari","master_jadwal.jam","master_jadwal.tujuan_awal","master_jadwal.tujuan_akhir");

			$join = array(
							array("master_armada","master_armada.id = performa_surat_jalan.armada_id","LEFT"),
							array("master_jadwal","master_jadwal.id = performa_surat_jalan.jadwal_id","LEFT"),
						);

			$dataPrint = $this->suratjalanModel->getByWhere(array("performa_surat_jalan.id" => $id),$select,$join);
			if ($dataPrint) {

				$dataPrint->tanggal = date_ind("d M Y", $dataPrint->tanggal);
				$dataPrint->jam = explode(":", $dataPrint->jam);
				$dataPrint->jam = $dataPrint->jam[0].":".$dataPrint->jam[1];

				$this->response->status = true;
				$this->response->message = "data surat jalan by id";
				$this->response->data = $dataPrint;
			} else {
				$this->response->message = alertDanger("Data tidak ada.!");
			}
		}
		parent::json();
	}

	/*for armada di surat jalan*/
	public function getAllArmada() // for combo box armada bus supir 1 dan supir 2
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			
				$where = false;
				
				$select = array("performa_surat_jalan.armada_id","master_armada.nama","master_armada.tahun","master_armada.no_bk","master_armada.photo");
				$join = array(
								array("master_armada","master_armada.id = performa_surat_jalan.armada_id","LEFT"),
							);
				$data = $this->suratjalanModel->getAll($where,$select,array("master_armada.nama ASC"),$join,false,array("performa_surat_jalan.armada_id"));
				if ($data) {
					$this->response->status = true;
					$this->response->message = "Data armada supir";
					$this->response->data = $data;
				}
			
		}
		parent::json();
	}

	public function getAllJadwalTanggalArmada($armada_id=null) // for combo box tanggal per armada
	{
		parent::checkLoginUser(); // otoritas authentic function
		$this->load->model('pendapatan/Armada_model',"pendapatanArmadaModel");

		if ($this->isPost()) {
			if ($armada_id != null) {
				// ingat ya untuk yang di tampilkan tanggal surat jalan per armada harus tampil bulan lalu dan bulan saat ini
				$where = array(
								"performa_surat_jalan.armada_id" => $armada_id,
								// "YEAR(performa_surat_jalan.tanggal)"	=>	date("Y"),
								// "MONTH(performa_surat_jalan.tanggal) >="	=>	date("m", strtotime('- 1 months')),
							);
				$joins = array(
								array("performa_surat_jalan","performa_surat_jalan.id = pendapatan_armada.surat_jalan_id","LEFT"),
							);
				$pendapatanData = $this->pendapatanArmadaModel->getAll($where,false,false,$joins);

				$select = array("performa_surat_jalan.*","hari","jam");
				$join = array(
								array("master_jadwal","master_jadwal.id = performa_surat_jalan.jadwal_id","LEFT"),
							);
				$data = $this->suratjalanModel->getAll($where,$select,array("tanggal DESC"),$join);
				if ($data) {
					$result = array();
					foreach ($data as $item) {
						$item->tanggal_indo = date_ind("d M Y", $item->tanggal);
						$jam = explode(":", $item->jam);
						$item->jam = $jam[0].":".$jam[1];
						if ($pendapatanData) {
							foreach ($pendapatanData as $val) {
								if ($item->id != $val->surat_jalan_id) {
									$result[] = $item;
								}
							}
						} else {
							$result[] = $item;
						}
					}
					$this->response->status = true;
					$this->response->message = "Data tanggal hari jam per armada";
					$this->response->data = $result;
				}
			}
		}
		parent::json();
	}
	/*End for armada di surat jalan.*/

	/* For Pendapatan Supir */
	public function getAllSupir1() // for combo box supir 1
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$field = array("kode_supir1","nama_supir1");
			$data = $this->suratjalanModel->getAll(false,$field,false,false,false,$field);
			if ($data) {
				$this->response->status = true;
				$this->response->message = "Data supir";
				$this->response->data = $data;
			}
		}
		parent::json();
	}

	public function getAllSupir2() // for combo box supir 2
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$field = array("kode_supir2","nama_supir2");
			$data = $this->suratjalanModel->getAll(false,$field,false,false,false,$field);
			if ($data) {
				$this->response->status = true;
				$this->response->message = "Data supir";
				$this->response->data = $data;
			}
		}
		parent::json();
	}

	public function getAllArmadaSupir($kode_supir=null,$status_supir=null) // for combo box armada bus supir 1 dan supir 2
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			if ($kode_supir != null && $status_supir != null) {
				$where = false;
				if ($status_supir == "supir1") {
					$where = array("performa_surat_jalan.kode_supir1" => $kode_supir);
				} else if($status_supir == "supir2") {
					$where = array("performa_surat_jalan.kode_supir2" => $kode_supir);
				}
				
				$select = array("performa_surat_jalan.armada_id","master_armada.nama","master_armada.tahun","master_armada.no_bk","master_armada.photo");
				$join = array(
								array("master_armada","master_armada.id = performa_surat_jalan.armada_id","LEFT"),
							);
				$data = $this->suratjalanModel->getAll($where,$select,array("master_armada.nama ASC"),$join,false,array("performa_surat_jalan.armada_id"));
				if ($data) {
					$this->response->status = true;
					$this->response->message = "Data armada supir";
					$this->response->data = $data;
				}
			}
		}
		parent::json();
	}

	public function getAllJadwalTanggalArmadaSupir($armada_id=null,$kode_supir=null,$status_supir=null) // for combo box tanggal per armada bus supir 1 and armada 2
	{
		parent::checkLoginUser(); // otoritas authentic function
		$this->load->model('pendapatan/Supir_model',"pendapatanSupirModel");

		if ($this->isPost()) {
			if ($armada_id != null && $kode_supir != null) {
				$where = array(
								"performa_surat_jalan.armada_id" => $armada_id,
								// "YEAR(performa_surat_jalan.tanggal)"	=>	date("Y"),
								// "MONTH(performa_surat_jalan.tanggal) >="	=>	date("m", strtotime('- 1 months')),
								// "performa_surat_jalan.kode_supir1"	=>	$kode_supir,
							);

				if ($status_supir != null) {
					if ($status_supir == "supir1") {
						$where["performa_surat_jalan.kode_supir1"]	=	$kode_supir;
						$wherePendapatan = array(
													"performa_surat_jalan.armada_id"	=>	$armada_id,
													"performa_surat_jalan.kode_supir1"	=>	$kode_supir,
													"status_supir"	=>	1,
											);
					} else if ($status_supir == "supir2") {
						$where["performa_surat_jalan.kode_supir2"]	=	$kode_supir;
						$wherePendapatan = array(
													"performa_surat_jalan.armada_id"	=>	$armada_id,
													"performa_surat_jalan.kode_supir1"	=>	$kode_supir,
													"status_supir"	=>	2,
											);
					}
				}
				$joins = array(
								array("performa_surat_jalan","performa_surat_jalan.id = pendapatan_supir.surat_jalan_id","LEFT"),
							);
				$pendapatanData = $this->pendapatanSupirModel->getAll($wherePendapatan,array("pendapatan_supir.*"),false,$joins);

				$select = array("performa_surat_jalan.*","hari","jam");
				$join = array(
								array("master_jadwal","master_jadwal.id = performa_surat_jalan.jadwal_id","LEFT"),
							);
				$data = $this->suratjalanModel->getAll($where,$select,array("tanggal DESC"),$join);
				if ($data) {
					$result = array();
					foreach ($data as $item) {
						$item->tanggal_indo = date_ind("d M Y", $item->tanggal);
						$jam = explode(":", $item->jam);
						$item->jam = $jam[0].":".$jam[1];
						if ($pendapatanData) {
							foreach ($pendapatanData as $val) {
								if ($item->id != $val->surat_jalan_id) {
									$result[] = $item;
								}
							}
						} else {
							$result[] = $item;
						}
					}
					$this->response->status = true;
					$this->response->message = "Data tanggal hari jam per armada supir";
					$this->response->data = $result;
					$this->response->dataSuratJalan = $data;
					$this->response->pendapatanSupir = $pendapatanData;
				}
			}
		}
		parent::json();
	}
	/* End For Pendapatan Supir*/
}

/* End of file Suratjalan.php */
/* Location: ./application/controllers/performa/Suratjalan.php */