<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function
		
		parent::headerTitle("Dashboard","Dashboard");

		$breadcrumbs = array(
								"Dashboard"	=> 	site_url('dashboard'),
							);
		parent::breadcrumbs($breadcrumbs);

		parent::view();
	}

	public function pendapatanArmada($tahun=null)
	{
		$this->load->model('pendapatan/Armada_model',"armadaModel");

		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$tahun = $tahun == null ? date("Y") : $tahun;
			$MONTH = "MONTH(tanggal_input)";
			$YEAR  = "YEAR(tanggal_input)";
			$select = "uang_pendapatan";
			$jan = $this->armadaModel->getSelectSum($select,array($MONTH=>1,$YEAR=>$tahun))->uang_pendapatan;
			$jan = ($jan) ? intval($jan) : 0;
			$feb = $this->armadaModel->getSelectSum($select,array($MONTH=>2,$YEAR=>$tahun))->uang_pendapatan;
			$feb = ($feb) ? intval($feb) : 0;
			$mar = $this->armadaModel->getSelectSum($select,array($MONTH=>3,$YEAR=>$tahun))->uang_pendapatan;
			$mar = ($mar) ? intval($mar) : 0;
			$apr = $this->armadaModel->getSelectSum($select,array($MONTH=>4,$YEAR=>$tahun))->uang_pendapatan;
			$apr = ($apr) ? intval($apr) : 0;
			$mei = $this->armadaModel->getSelectSum($select,array($MONTH=>5,$YEAR=>$tahun))->uang_pendapatan;
			$mei = ($mei) ? intval($mei) : 0;
			$jun = $this->armadaModel->getSelectSum($select,array($MONTH=>6,$YEAR=>$tahun))->uang_pendapatan;
			$jun = ($jun) ? intval($jun) : 0;
			$jul = $this->armadaModel->getSelectSum($select,array($MONTH=>7,$YEAR=>$tahun))->uang_pendapatan;
			$jul = ($jul) ? intval($jul) : 0;
			$aug = $this->armadaModel->getSelectSum($select,array($MONTH=>8,$YEAR=>$tahun))->uang_pendapatan;
			$aug = ($aug) ? intval($aug) : 0;
			$sep = $this->armadaModel->getSelectSum($select,array($MONTH=>9,$YEAR=>$tahun))->uang_pendapatan;
			$sep = ($sep) ? intval($sep) : 0;
			$okt = $this->armadaModel->getSelectSum($select,array($MONTH=>10,$YEAR=>$tahun))->uang_pendapatan;
			$okt = ($okt) ? intval($okt) : 0;
			$nov = $this->armadaModel->getSelectSum($select,array($MONTH=>11,$YEAR=>$tahun))->uang_pendapatan;
			$nov = ($nov) ? intval($nov) : 0;
			$dec = $this->armadaModel->getSelectSum($select,array($MONTH=>12,$YEAR=>$tahun))->uang_pendapatan;
			$dec = ($dec) ? intval($dec) : 0;

			$series_value = [$jan,$feb,$mar,$apr,$mei,$jun,$jul,$aug,$sep,$okt,$nov,$dec];
			$total_per_tahun = array_sum($series_value);
			$total_per_tahun = "Rp.".number_format($total_per_tahun,0,",",".");
			$data = array(
							"series_value"		=>	$series_value,
							"total_per_tahun"	=>	$total_per_tahun
						);
			sort($series_value);
			$high_value = end($series_value);
			$data["high_value"] = "$high_value";

			$this->response->status = true;
			$this->response->message = "Dashboard pendapatan armada";
			$this->response->data = $data;
		}
		parent::json();
	}

	public function groupByTahunChart()
	{
		$this->load->model('pendapatan/Armada_model',"armadaModel");

		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {

			$data = $this->armadaModel->getAll(false,array("YEAR(tanggal_input) AS tahun"),false,false,false,array("YEAR(tanggal_input)"));
			$data = count($data) > 1 ? $data : null; 

			$this->response->status = true;
			$this->response->message = "Dashboard pendapatan armada";
			$this->response->data = $data;
		}
		parent::json();
	}

	public function countExpireSTNK()
	{
		parent::checkLoginUser(); // otoritas authentic function
		$this->load->model('master/Armada_model',"armadaModel");

		if ($this->isPost()) {

			$where = array(
							"tgl_stnk > " => date("Y-m-d"),
							"MONTH(tgl_stnk)" => date("m"),
							"YEAR(tgl_stnk)" => date("Y"),
						);
			$sisa_1bulan = $this->armadaModel->getCount($where);

			$where["MONTH(tgl_stnk)"] = date("m", strtotime(" + 1 months"));
			$sisa_2bulan = $this->armadaModel->getCount($where);

			$where["MONTH(tgl_stnk)"] = date("m", strtotime(" + 2 months"));
			$sisa_3bulan = $this->armadaModel->getCount($where);

			$expire_stnk = $this->armadaModel->getCount(array("tgl_stnk <=" => date("Y-m-d")));
			$data = array(
							"sisa_1bulan"	=>	$sisa_1bulan,
							"sisa_2bulan"	=>	$sisa_2bulan,
							"sisa_3bulan"	=>	$sisa_3bulan,
							"expire_stnk"	=>	$expire_stnk
						);
			parent::json($data);
		}
	}

	public function ajax_list_expired_stnk($expired=null)
	{
		parent::checkLoginUser(); // otoritas authentic function
		$this->load->model('master/Armada_model',"armadaModel");

		if ($this->isPost()) {

			// $where = array("tgl_stnk" => null);
			if ($expired == 1) {
				$where = array(
							"tgl_stnk > " => date("Y-m-d"),
							"MONTH(tgl_stnk)" => date("m"),
							"YEAR(tgl_stnk)" => date("Y"),
						);
			} else if ($expired == 2) {
				$where = array(
							"tgl_stnk > " => date("Y-m-d"),
							"MONTH(tgl_stnk)" => date("m", strtotime(" + 1 months")),
							"YEAR(tgl_stnk)" => date("Y"),
						);
			} else if ($expired == 3) {
				$where = array(
							"tgl_stnk > " => date("Y-m-d"),
							"MONTH(tgl_stnk)" => date("m", strtotime(" + 2 months")),
							"YEAR(tgl_stnk)" => date("Y"),
						);
			} else if ($expired == "due") {
				$where = array("tgl_stnk <=" => date("Y-m-d"));
			} else {
				$where = array("tgl_stnk" => null);
			}

			$columns = array(null,'tgl_stnk',null,'nama','no_bk');
			$search = array('nama','no_bk','tgl_stnk');

			$result = $this->armadaModel->findDataTable($where,false,$columns,$search);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";
				$item->tgl_stnk = date_ind("d M Y", $item->tgl_stnk);

				if($item->photo != ""){
					$item->photo = base_url()."uploads/admin/master/armada/".$item->photo;
				} else {
					$item->photo = base_url()."assets/images/default/no_image.jpg";
				}

				$item->photo = '<div class="img-thumbnail"><center><img src="'.$item->photo.'" class="img img-responsive" style="width:60px; height:60px;"></center></div>';

				$data[] = $item;
			}
			return $this->armadaModel->findDataTableOutput($data,$where,$search);
		}
		parent::json();
	}

	public function countExpireSIM()
	{
		parent::checkLoginUser(); // otoritas authentic function
		$this->load->model('master/Karyawan_model',"karyawanModel");

		if ($this->isPost()) {

			$where = array(
							"tgl_jatuh_tempo_sim > " => date("Y-m-d"),
							"MONTH(tgl_jatuh_tempo_sim)" => date("m"),
							"YEAR(tgl_jatuh_tempo_sim)" => date("Y"),
						);
			$sisa_1bulan = $this->karyawanModel->getCount($where);

			$where["MONTH(tgl_jatuh_tempo_sim)"] = date("m", strtotime(" + 1 months"));
			$sisa_2bulan = $this->karyawanModel->getCount($where);

			$where["MONTH(tgl_jatuh_tempo_sim)"] = date("m", strtotime(" + 2 months"));
			$sisa_3bulan = $this->karyawanModel->getCount($where);

			$expire_sim = $this->karyawanModel->getCount(array("tgl_jatuh_tempo_sim <=" => date("Y-m-d")));
			$data = array(
							"sisa_1bulan"	=>	$sisa_1bulan,
							"sisa_2bulan"	=>	$sisa_2bulan,
							"sisa_3bulan"	=>	$sisa_3bulan,
							"expire_sim"	=>	$expire_sim
						);
			parent::json($data);
		}
	}

	public function ajax_list_expired_sim($expired=null)
	{
		parent::checkLoginUser(); // otoritas authentic function
		$this->load->model('master/Karyawan_model',"karyawanModel");

		if ($this->isPost()) {

			if ($expired == 1) {
				$where = array(
							"tgl_jatuh_tempo_sim > " => date("Y-m-d"),
							"MONTH(tgl_jatuh_tempo_sim)" => date("m"),
							"YEAR(tgl_jatuh_tempo_sim)" => date("Y"),
							"bagian_supir"	=>	"ya",
							"status_kerja"	=>	"aktif",
						);
			} else if ($expired == 2) {
				$where = array(
							"tgl_jatuh_tempo_sim > " => date("Y-m-d"),
							"MONTH(tgl_jatuh_tempo_sim)" => date("m", strtotime(" + 1 months")),
							"YEAR(tgl_jatuh_tempo_sim)" => date("Y"),
							"bagian_supir"	=>	"ya",
							"status_kerja"	=>	"aktif",
						);
			} else if ($expired == 3) {
				$where = array(
							"tgl_jatuh_tempo_sim > " => date("Y-m-d"),
							"MONTH(tgl_jatuh_tempo_sim)" => date("m", strtotime(" + 2 months")),
							"YEAR(tgl_jatuh_tempo_sim)" => date("Y"),
							"bagian_supir"	=>	"ya",
							"status_kerja"	=>	"aktif",
						);
			} else if ($expired == "due") {
				$where = array(
								"tgl_jatuh_tempo_sim <=" => date("Y-m-d"),
								"bagian_supir"	=>	"ya",
								"status_kerja"	=>	"aktif",
							);
			} else {
				$where = array(
								"tgl_jatuh_tempo_sim" => null,
								"bagian_supir"	=>	"ya",
								"status_kerja"	=>	"aktif",
							);
			}

			$columns = array(null,'tgl_jatuh_tempo_sim',null,'kode','nama');
			$search = array('nama','kode','tgl_jatuh_tempo_sim');

			$result = $this->karyawanModel->findDataTable($where,false,$columns,$search);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";
				$item->tgl_jatuh_tempo_sim = date_ind("d M Y", $item->tgl_jatuh_tempo_sim);

				if($item->foto_karyawan != ""){
					$item->foto_karyawan = base_url()."uploads/admin/master/karyawan/orang/".$item->foto_karyawan;
				} else {
					$item->foto_karyawan = base_url()."assets/images/default/user_image.png";
				}

				$item->foto_karyawan = '<div class="img-thumbnail"><center><img src="'.$item->foto_karyawan.'" class="img img-responsive" style="width:60px; height:60px;"></center></div>';

				$data[] = $item;
			}
			return $this->karyawanModel->findDataTableOutput($data,$where,$search);
		}
		parent::json();
	}

	public function countExpireKontrak()
	{
		parent::checkLoginUser(); // otoritas authentic function
		$this->load->model('master/Karyawan_model',"karyawanModel");

		if ($this->isPost()) {

			$where = array(
							"tgl_akhir_kontrak > " => date("Y-m-d"),
							"MONTH(tgl_akhir_kontrak)" => date("m"),
							"YEAR(tgl_akhir_kontrak)" => date("Y"),
							"status_kontrak"	=>	"aktif",
							"status_kerja"		=>	"aktif"
						);
			$sisa_1bulan = $this->karyawanModel->getCount($where);

			$where["MONTH(tgl_akhir_kontrak)"] = date("m", strtotime(" + 1 months"));
			$sisa_2bulan = $this->karyawanModel->getCount($where);

			$where["MONTH(tgl_akhir_kontrak)"] = date("m", strtotime(" + 2 months"));
			$sisa_3bulan = $this->karyawanModel->getCount($where);

			$expire_kontrak = $this->karyawanModel->getCount(array("tgl_akhir_kontrak <=" => date("Y-m-d")));
			$data = array(
							"sisa_1bulan"	=>	$sisa_1bulan,
							"sisa_2bulan"	=>	$sisa_2bulan,
							"sisa_3bulan"	=>	$sisa_3bulan,
							"expire_kontrak"=>	$expire_kontrak
						);
			parent::json($data);
		}
	}

	public function ajax_list_expired_kontrak($expired=null)
	{
		parent::checkLoginUser(); // otoritas authentic function
		$this->load->model('master/Karyawan_model',"karyawanModel");

		if ($this->isPost()) {

			if ($expired == 1) {
				$where = array(
							"tgl_akhir_kontrak > " => date("Y-m-d"),
							"MONTH(tgl_akhir_kontrak)" => date("m"),
							"YEAR(tgl_akhir_kontrak)" => date("Y"),
							"status_kontrak"	=>	"aktif",
							"status_kerja"		=>	"aktif"
						);
			} else if ($expired == 2) {
				$where = array(
							"tgl_akhir_kontrak > " => date("Y-m-d"),
							"MONTH(tgl_akhir_kontrak)" => date("m", strtotime(" + 1 months")),
							"YEAR(tgl_akhir_kontrak)" => date("Y"),
							"status_kontrak"	=>	"aktif",
							"status_kerja"		=>	"aktif"
						);
			} else if ($expired == 3) {
				$where = array(
							"tgl_akhir_kontrak > " => date("Y-m-d"),
							"MONTH(tgl_akhir_kontrak)" => date("m", strtotime(" + 2 months")),
							"YEAR(tgl_akhir_kontrak)" => date("Y"),
							"status_kontrak"	=>	"aktif",
							"status_kerja"		=>	"aktif"
						);
			} else if ($expired == "due") {
				$where = array(
								"tgl_akhir_kontrak <=" => date("Y-m-d"),
								"status_kontrak"	=>	"aktif",
								"status_kerja"		=>	"aktif"
							);
			} else {
				$where = array(
								"tgl_akhir_kontrak" => null,
								"status_kontrak"	=>	"aktif",
								"status_kerja"		=>	"aktif"
							);
			}

			$columns = array(null,'tgl_akhir_kontrak',null,'kode','nama');
			$search = array('nama','kode','tgl_akhir_kontrak');

			$result = $this->karyawanModel->findDataTable($where,false,$columns,$search);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";
				$item->tgl_akhir_kontrak = date_ind("d M Y", $item->tgl_akhir_kontrak);

				if($item->foto_karyawan != ""){
					$item->foto_karyawan = base_url()."uploads/admin/master/karyawan/orang/".$item->foto_karyawan;
				} else {
					$item->foto_karyawan = base_url()."assets/images/default/user_image.png";
				}

				$item->foto_karyawan = '<div class="img-thumbnail"><center><img src="'.$item->foto_karyawan.'" class="img img-responsive" style="width:60px; height:60px;"></center></div>';

				$data[] = $item;
			}
			return $this->karyawanModel->findDataTableOutput($data,$where,$search);
		}
		parent::json();
	}

	public function ajax_list_ulang_tahun()
	{
		parent::checkLoginUser(); // otoritas authentic function
		$this->load->model('master/Karyawan_model',"karyawanModel");

		if ($this->isPost()) {
			$select = array("foto_karyawan","nama","tanggal_lahir","tempat_lahir","kelamin","master_jabatan.nama_jabatan");
			$where = array(
							"MONTH(tanggal_lahir)"	=>	date("m"),
							"DAY(tanggal_lahir)"	=>	date("d")
						);
			$orderBy = array("nama ASC");
			$join = array(
							array("master_jabatan","master_jabatan.id = master_karyawan.jabatan_id","LEFT"),
						);
			$result  = $this->karyawanModel->getAll($where,$select,$orderBy,$join);
			if ($result) {
				foreach ($result as $item) {
					if($item->foto_karyawan != ""){
						$item->foto_karyawan = base_url()."uploads/admin/master/karyawan/orang/".$item->foto_karyawan;
					} else {
						$item->foto_karyawan = base_url()."assets/images/default/user_image.png";
					}

					$item->tanggal_lahir_indo = date_ind("d M Y", $item->tanggal_lahir);
					$item->kelamin = ucfirst($item->kelamin);

					/*check hari ulang tahun*/
					$tgl_lahir = explode("-", $item->tanggal_lahir);
					if (date("m") == $tgl_lahir["1"] && date("d") == $tgl_lahir["2"]) {
						$tanggal = new DateTime($item->tanggal_lahir);
						$today = new DateTime(date("Y-m-d"));

				    	$item->umur = $today->diff($tanggal)->y;
					}
				}
			}
			$this->response->status = true;
			$this->response->message = "Data ulang tahun karyawan";
			$this->response->data = $result;
		}
		parent::json();
	}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/admin/Dashboard.php */