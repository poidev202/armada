<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supir extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('performa/suratjalan_model',"suratjalanModel");
		$this->load->model('pendapatan/supir_model',"supirModel");
		parent::checkUserRoleKasir(); // check role atau level function
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function

		parent::headerTitle("Laporan Supir","Laporan","Supir");

		$breadcrumbs = array(
								"Laporan"	=> 	site_url('laporan/supir'),
								"Supir"		=>	"",
							);

		parent::breadcrumbs($breadcrumbs);

		parent::viewLaporan();
	}

	public function ajax_list($supir = 0)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$select = array("master_karyawan.foto_karyawan","master_karyawan.no_telp","master_karyawan.alamat");
			$where = false;
			if ($supir == 1) {
				$select[] = "kode_supir1";
				$select[] = "nama_supir1";
				$groupBy = array("kode_supir1","nama_supir1");

				$columns = array(null,null,'kode_supir1','nama_supir1','no_telp','alamat');
				$search = array('kode_supir1','nama_supir1','no_telp','alamat');

				$join = array(
								array("master_karyawan","master_karyawan.kode = performa_surat_jalan.kode_supir1","LEFT"),
							);

			} else if ($supir == 2) {
				$select[] = "kode_supir2";
				$select[] = "nama_supir2";
				$groupBy = array("kode_supir2","nama_supir2");

				$columns = array(null,null,'kode_supir2','nama_supir2','no_telp','alamat');
				$search = array('kode_supir2','nama_supir2','no_telp','alamat');

				$join = array(
								array("master_karyawan","master_karyawan.kode = performa_surat_jalan.kode_supir2","LEFT"),
							);
			}

			$result = $this->suratjalanModel->findDataTable($where,$select,$columns,$search,$join,false,$groupBy);
			$data = array();
			foreach ($result as $item) {
				$item->no = "<b style='color:black;'>".$item->no."</b>";

				if($item->foto_karyawan != ""){
					$item->foto_karyawan = base_url()."uploads/admin/master/karyawan/orang/".$item->foto_karyawan;
				} else {
					$item->foto_karyawan = base_url()."assets/images/default/user_image.png";
				}
				$item->foto_karyawan = '<div class="img-thumbnail"><center><img src="'.$item->foto_karyawan.'" class="img img-responsive" style="width:60px; height:60px;"></center></div>';

				if ($supir == 1) {
					$kode_supir1 = "'".$item->kode_supir1."'";
					$btnAction ='<button type="button" onclick="btnRekap1('.$kode_supir1.')" class="btn btn-outline-info btn-xs m-b-10" title="Detail"><i class="fa fa-info-circle"></i> Detail Rekap</button>'; //
				} else if ($supir == 2) {
					$kode_supir2 = "'".$item->kode_supir2."'";
					$btnAction ='<button type="button" onclick="btnRekap2('.$kode_supir2.')" class="btn btn-outline-info btn-xs m-b-10" title="Detail"><i class="fa fa-info-circle"></i> Detail Rekap</button>'; //
				}
				
				$item->button_action = $btnAction;

				$data[] = $item;
			}
			return $this->suratjalanModel->findDataTableOutput($data,$where,$search,$join,false,$groupBy,$select);
		}
		parent::json();
	}

	public function ajax_list_rekap($statusSupir=null,$kode=null)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$select = array("tanggal_input","nama","no_bk","hari","jam","tujuan_awal","tujuan_akhir","uang_pendapatan");
			
			$where = false;
			// $kode = $this->input->post("kode_supir");
			if ($statusSupir == 1) {
				$where = array("pendapatan_supir.status_supir" => 1, "performa_surat_jalan.kode_supir1"=>$kode);
			} else if ($statusSupir == 2) {
				$where = array("pendapatan_supir.status_supir" => 2, "performa_surat_jalan.kode_supir2"=>$kode);
			}

			$columns = array(null,"tanggal_input","nama","no_bk","hari","jam","tujuan_awal","tujuan_akhir","uang_pendapatan");
			$search = array("tanggal_input","nama","no_bk","hari","jam","tujuan_awal","tujuan_akhir","uang_pendapatan");

			$join = array(
							array("performa_surat_jalan","performa_surat_jalan.id = pendapatan_supir.surat_jalan_id","LEFT"),
							array("master_armada","master_armada.id = performa_surat_jalan.armada_id","LEFT"),
							array("master_jadwal","master_jadwal.id = performa_surat_jalan.jadwal_id","LEFT"),
						);

			$data = array();
			if($statusSupir != null) {
				$result = $this->supirModel->findDataTable($where,$select,$columns,$search,$join);
				foreach ($result as $item) {
					$item->no = "<b style='color:black;'>".$item->no."</b>";
					$jam = explode(":", $item->jam);
					$item->jam = $jam[0].":".$jam[1];
					$item->uang_pendapatan = "Rp.".number_format($item->uang_pendapatan,0,",",".");
					
					$data[] = $item;
				}
			}
			return $this->supirModel->findDataTableOutput($data,$where,$search,$join);
		}
		parent::json();
	}

	public function ajax_list_rekap_supir1($kode)
	{
		return self::ajax_list_rekap(1,$kode);
	}

	public function ajax_list_rekap_supir2($kode)
	{
		return self::ajax_list_rekap(2,$kode);
	}
}

/* End of file Supir.php */
/* Location: ./application/controllers/laporan/Supir.php */