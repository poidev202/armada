<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Armada extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('performa/suratjalan_model',"suratjalanModel");
		$this->load->model('pendapatan/Armada_model',"armadaModel");
		parent::checkUserRoleKasir(); // check role atau level function
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function

		parent::headerTitle("Laporan Armada","Laporan","Armada");

		$breadcrumbs = array(
								"Laporan"	=> 	site_url('laporan/armada'),
								"Armada"	=>	"",
							);

		parent::breadcrumbs($breadcrumbs);

		parent::viewLaporan();
	}

	public function ajax_list()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$select = array("armada_id","photo","nama","no_bk","tahun","merk","nama_karoseri");
			$where = false;

			$groupBy = array("armada_id");

			$columns = array(null,null,"nama","no_bk","tahun","merk","nama_karoseri");
			$search = array("nama","no_bk","tahun","merk","nama_karoseri");

			$join = array(
							array("master_armada","master_armada.id = performa_surat_jalan.armada_id","LEFT"),
							array("master_merk_chassis","master_merk_chassis.id = master_armada.merk_chassis_id","LEFT"),
							array("master_karoseri","master_karoseri.id = master_armada.karoseri_id","LEFT"),
						);

			$result = $this->suratjalanModel->findDataTable($where,$select,$columns,$search,$join,false,$groupBy);
			$data = array();
			foreach ($result as $item) {
				$item->no = "<b style='color:black;'>".$item->no."</b>";

				if($item->photo != ""){
					$item->photo = base_url()."uploads/admin/master/armada/".$item->photo;
				} else {
					$item->photo = base_url()."assets/images/default/no_image.jpg";
				}

				$item->photo = '<div class="img-thumbnail"><center><img src="'.$item->photo.'" class="img img-responsive" style="width:60px; height:60px;"></center></div>';

				$btnAction ='<button type="button" onclick="btnRekapPendapatan('.$item->armada_id.')" class="btn btn-outline-success btn-xs m-b-10" title="Rekap Pendapatan Armada"><i class="fa fa-list-alt"></i> Pendapatan</button>'; //

				$btnAction .='&nbsp;&nbsp;<button type="button" onclick="btnRekapPemakaian('.$item->armada_id.')" class="btn btn-outline-inverse btn-xs m-b-10" title="Rekap Pemakaian Barang Armada"><i class="fa fa-list-alt"></i> Pemakaian</button>'; //
				
				$item->button_action = $btnAction;

				$data[] = $item;
			}
			return $this->suratjalanModel->findDataTableOutput($data,$where,$search,$join,false,$groupBy,$select);
		}
		parent::json();
	}

	public function ajax_list_rekap($armada_id=null)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$select = array("tanggal_input","hari","jam","tujuan_awal","tujuan_akhir","tanggal","uang_pendapatan","nama_kas");
			
			$where = false;
			if ($armada_id) {
				$where = array("performa_surat_jalan.armada_id"=>$armada_id);
			}
			$columns = array(null,"tanggal_input","hari","jam","tujuan_awal","tujuan_akhir","tanggal","uang_pendapatan","nama_kas");
			$search = array("tanggal_input","hari","jam","tujuan_awal","tujuan_akhir","tanggal","uang_pendapatan","nama_kas");
			$join = array(
							array("performa_surat_jalan","performa_surat_jalan.id = pendapatan_armada.surat_jalan_id","LEFT"),
							array("master_armada","master_armada.id = performa_surat_jalan.armada_id","LEFT"),
							array("master_jadwal","master_jadwal.id = performa_surat_jalan.jadwal_id","LEFT"),
							array("master_kas","master_kas.id = pendapatan_armada.kas_id","LEFT"),
						);

			$data = array();
			if($armada_id != null) {
				$result = $this->armadaModel->findDataTable($where,$select,$columns,$search,$join);
				foreach ($result as $item) {
					$item->no = "<b style='color:black;'>".$item->no."</b>";
					$jam = explode(":", $item->jam);
					$item->jam = $jam[0].":".$jam[1];
					$item->uang_pendapatan = "Rp.".number_format($item->uang_pendapatan,0,",",".");
					
					$data[] = $item;
				}
			}
			return $this->armadaModel->findDataTableOutput($data,$where,$search,$join);
		}
		parent::json();
	}

	public function ajax_list_rekap_armada($id)
	{
		return self::ajax_list_rekap($id);
	}

	public function ajax_list_pemakaian($armada_id=null)
	{
		$this->load->model('transaksi/Penjualan_model',"penjualanModel");
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {

			$select = array("transaksi_penjualan.*","master_produk.kode","master_produk.nama_produk","master_produk_unit.unit","master_gudang.nama_gudang");

			$columns = array(null,'tanggal_jual','kode','nama_produk','nama_gudang','unit','harga_jual_unit','jumlah','harga_jual_total');
			$search = array('transaksi_penjualan.tanggal_jual','kode','nama_produk','nama_gudang','unit','harga_jual_unit','jumlah','harga_jual_total');

			$where = false;
			if ($armada_id) {
				$where = array("transaksi_penjualan.armada_id"=>$armada_id);
			}

			$join = array(
							array("master_produk","master_produk.id = transaksi_penjualan.produk_id","LEFT"),
							array("master_produk_unit","master_produk_unit.id = master_produk.unit_id","LEFT"),
							array("master_armada","master_armada.id = transaksi_penjualan.armada_id","LEFT"),
							array("master_gudang","master_gudang.id = transaksi_penjualan.gudang_id","LEFT"),
						);

			$result = $this->penjualanModel->findDataTable($where,$select,$columns,$search,$join);
			$data = array();
			if($armada_id != null) {
				foreach ($result as $item) {
					
					$item->no = "<b style='color:black;'>".$item->no."</b>";

					// $item->tanggal_jual = date_ind("d M Y", $item->tanggal_jual);

					$item->harga_jual_unit = "Rp.".number_format($item->harga_jual_unit,0,',','.');
					$item->harga_jual_total = "Rp.".number_format($item->harga_jual_total,0,',','.');

					$data[] = $item;
				}
			}
			return $this->penjualanModel->findDataTableOutput($data,$where,$search,$join);
		}
		parent::json();
	}

	public function ajax_list_pemakaian_armada($id)
	{
		return self::ajax_list_pemakaian($id);
	}
}

/* End of file Armada.php */
/* Location: ./application/controllers/laporan/Armada.php */