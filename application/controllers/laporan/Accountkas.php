<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accountkas extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('laporan/Accountkas_model',"lPkasModel");
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function

		parent::headerTitle("Laporan Account Kas","Laporan","Account Kas");

		$breadcrumbs = array(
								"Laporan"	=> 	site_url('laporan/accountkas'),
								"Account Kas"	=>	"",
							);

		parent::breadcrumbs($breadcrumbs);

		parent::viewLaporan();
	}

	public function ajax_list() // for datatable laporan kas all
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$requestData = $_REQUEST;
			$tanggalAwal = $requestData['columns'][0]['search']['value'];
			$tanggalAkhir = $requestData['columns'][1]['search']['value'];
			
			$select = array("laporan_account_kas.*","master_kas.nama_kas");
			$orderBy = array(null,"tanggal","nama_kas","masuk","keluar","status","info_input","laporan_account_kas.keterangan");
			$search = array("nama_kas","masuk","keluar","status","info_input","laporan_account_kas.keterangan");
			$join = array(
							array("master_kas","master_kas.id = laporan_account_kas.kas_id","LEFT")
						);
			$where = array(
							"data" => array(),
							"tanggal" => null,
						);
			if (!empty($tanggalAwal) && !empty($tanggalAkhir)) {
				$where["tanggal"] = array("laporan_account_kas.tanggal >=" => $tanggalAwal, "laporan_account_kas.tanggal <=" => $tanggalAkhir);
			} else {
				$search[] = "laporan_account_kas.tanggal";
			}
			$result = $this->lPkasModel->findDataTableLpKas($where,$select,$orderBy,$search,$join);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";

				if ($item->masuk > 0) {
					$masuk = "Rp.".number_format($item->masuk,0,",",".");
					$item->masuk = "<span style='color:#0bde43;'>".$masuk."</span>";
				}
				if ($item->keluar > 0) {
					$keluar = "Rp.".number_format($item->keluar,0,",",".");
					$item->keluar = "<span style='color:red;'>".$keluar."</span>";
				}

				if ($item->status == "keluar") {
					$item->status = "<span style='color:red;'>".$item->status."</span>";
				} else {
					$item->status = "<span style='color:#0bde43;'>".$item->status."</span>";
				}

				if ($item->info_input == "penjualan") {
					$item->info_input = "<span style='color:#ca195a;'>".$item->info_input."</span>";
				} else if ($item->info_input == "pembelian") {
					$item->info_input = "<span style='color:#1b732a;'>".$item->info_input."</span>";
				} else {
					$item->info_input = "<span style='color:#1976d2;'>".$item->info_input."</span>";
				}

				$data[] = $item;
			}
			return $this->lPkasModel->findDataTableOutputLpKas($data,$where,$select,$search,$join);
		}
		parent::json();
	}

	public function ajax_list_masuk() // for datatable laporan kas masuk
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$requestData = $_REQUEST;
			$tanggalAwal = $requestData['columns'][0]['search']['value'];
			$tanggalAkhir = $requestData['columns'][1]['search']['value'];

			$select = array("laporan_account_kas.*","master_kas.nama_kas","master_armada.nama","master_armada.no_bk","performa_surat_jalan.tanggal AS tanggal_jadwal","master_jadwal.hari","master_jadwal.jam","master_jadwal.tujuan_awal","master_jadwal.tujuan_akhir");
			$orderBy = array(null,"laporan_account_kas.tanggal","nama_kas","masuk","nama","no_bk","performa_surat_jalan.tanggal","hari","jam","tujuan_awal","tujuan_akhir","laporan_account_kas.keterangan");
			$search = array("nama_kas","masuk","nama","no_bk","performa_surat_jalan.tanggal","hari","jam","tujuan_awal","tujuan_akhir","laporan_account_kas.keterangan");
			$join = array(
							array("master_kas","master_kas.id = laporan_account_kas.kas_id","LEFT"),
							array("pendapatan_armada","pendapatan_armada.id = laporan_account_kas.pendpt_armada_id","LEFT"),
							array("performa_surat_jalan","performa_surat_jalan.id = pendapatan_armada.surat_jalan_id","LEFT"),
							array("master_armada","master_armada.id = performa_surat_jalan.armada_id","LEFT"),
							array("master_jadwal","master_jadwal.id = performa_surat_jalan.jadwal_id","LEFT"),
						);
			$where = array(
							"data" => array(),
							"tanggal" => null,
						);
			$where["data"] = array("laporan_account_kas.status" => "masuk");
			if (!empty($tanggalAwal) && !empty($tanggalAkhir)) {
				$where["tanggal"] = array("laporan_account_kas.tanggal >=" => $tanggalAwal, "laporan_account_kas.tanggal <=" => $tanggalAkhir);
			} else {
				$search[] = "laporan_account_kas.tanggal";
			}
			$result = $this->lPkasModel->findDataTableLpKas($where,$select,$orderBy,$search,$join);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";

				if ($item->masuk > 0) {
					$masuk = "Rp.".number_format($item->masuk,0,",",".");
					$item->masuk = "<span style='color:#0bde43;'>".$masuk."</span>";
				}

				$data[] = $item;
			}
			return $this->lPkasModel->findDataTableOutputLpKas($data,$where,$select,$search,$join);
		}
		parent::json();
	}

	public function ajax_list_keluar_pembelian() // for datatable laporan kas keluar pembelian
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$requestData = $_REQUEST;
			$tanggalAwal = $requestData['columns'][0]['search']['value'];
			$tanggalAkhir = $requestData['columns'][1]['search']['value'];
			$gudang = $requestData['columns'][2]['search']['value'];
			$kategori = $requestData['columns'][3]['search']['value'];

			$select = array("laporan_account_kas.*","master_kas.nama_kas","master_produk.kode","master_produk.nama_produk","master_produk.kategori_id","master_produk_kategori.kategori","transaksi_pembelian.harga_beli_unit","transaksi_pembelian.jumlah","transaksi_pembelian.gudang_id","transaksi_pembelian.produk_id","transaksi_pembelian.vendor_id","master_gudang.nama_gudang","master_vendor.nama_vendor");

			$orderBy = array(null,"tanggal","nama_kas","keluar","kode","nama_produk","kategori","harga_beli_unit","jumlah","nama_gudang","nama_vendor","laporan_account_kas.keterangan");
			$search = array("nama_kas","keluar","kode","nama_produk","harga_beli_unit","jumlah","nama_vendor","laporan_account_kas.keterangan");
			$join = array(
							array("master_kas","master_kas.id = laporan_account_kas.kas_id","LEFT"),
							array("transaksi_pembelian","transaksi_pembelian.id = laporan_account_kas.pembelian_id","LEFT"),
							array("master_produk","master_produk.id = transaksi_pembelian.produk_id","LEFT"),
							array("master_produk_kategori","master_produk_kategori.id = master_produk.kategori_id","LEFT"),
							array("master_gudang","master_gudang.id = transaksi_pembelian.gudang_id","LEFT"),
							array("master_vendor","master_vendor.id = transaksi_pembelian.vendor_id","LEFT"),
						);
			$where = array(
							"data" => array(),
							"tanggal" => null,
						);
			$where["data"]["laporan_account_kas.status"] = "keluar";
			$where["data"]["laporan_account_kas.info_input"] = "pembelian";
			if (!empty($tanggalAwal) && !empty($tanggalAkhir)) {
				$where["tanggal"] = array("laporan_account_kas.tanggal >=" => $tanggalAwal, "laporan_account_kas.tanggal <=" => $tanggalAkhir);
			} else {
				$search[] = "laporan_account_kas.tanggal";
			}
			if (!empty($gudang)) {
				$where["data"]["transaksi_pembelian.gudang_id"] = $gudang;
			} else {
				$search[] = "nama_gudang";
			}
			if (!empty($kategori)) {
				$where["data"]["kategori_id"] = $kategori;
			} else {
				$search[] = "kategori";
			}

			$result = $this->lPkasModel->findDataTableLpKas($where,$select,$orderBy,$search,$join);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";

				if ($item->keluar > 0) {
					$keluar = "Rp.".number_format($item->keluar,0,",",".");
					$item->keluar = "<span style='color:red;'>".$keluar."</span>";
				}

				$item->kode = '<a href="javasript:void();" title="Datatable rekap produk" onclick="rekapProduk('.$item->produk_id.')">'.$item->kode.'</a>';
				$item->nama_produk = '<a href="javasript:void();" title="Datatable rekap produk" onclick="rekapProduk('.$item->produk_id.')">'.$item->nama_produk.'</a>';
				$item->kategori = '<a href="javasript:void();" title="Datatable rekap kategori produk" onclick="rekapKategoriProduk('.$item->kategori_id.')">'.$item->kategori.'</a>';
				$item->nama_gudang = '<a href="javasript:void();" title="Datatable rekap gudang produk" onclick="rekapGudangProduk('.$item->gudang_id.')">'.$item->nama_gudang.'</a>';
				$item->nama_vendor = '<a href="javasript:void();" title="Datatable rekap gudang produk" onclick="rekapVendorProduk('.$item->vendor_id.')">'.$item->nama_vendor.'</a>';

				$data[] = $item;
			}
			return $this->lPkasModel->findDataTableOutputLpKas($data,$where,$select,$search,$join);
		}
		parent::json();
	}

	public function ajax_list_keluar_penjualan() // for datatable laporan kas keluar penjualan
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$requestData = $_REQUEST;
			$tanggalAwal = $requestData['columns'][0]['search']['value'];
			$tanggalAkhir = $requestData['columns'][1]['search']['value'];
			$gudang = $requestData['columns'][2]['search']['value'];
			$kategori = $requestData['columns'][3]['search']['value'];

			$select = array("laporan_account_kas.*","master_kas.nama_kas","master_armada.nama","master_armada.no_bk","master_produk.kode","master_produk.nama_produk","master_produk.kategori_id","master_produk_kategori.kategori","transaksi_penjualan.harga_jual_unit","transaksi_penjualan.gudang_id","transaksi_penjualan.produk_id","transaksi_penjualan.jumlah","master_gudang.nama_gudang");

			$orderBy = array(null,"tanggal","nama_kas","keluar","nama","no_bk","kode","nama_produk","kategori","harga_jual_unit","jumlah","nama_gudang","laporan_account_kas.keterangan");
			$search = array("nama_kas","keluar","nama","no_bk","kode","nama_produk","harga_jual_unit","jumlah","laporan_account_kas.keterangan");

			$join = array(
							array("master_kas","master_kas.id = laporan_account_kas.kas_id","LEFT"),
							array("transaksi_penjualan","transaksi_penjualan.id = laporan_account_kas.penjualan_id","LEFT"),
							array("master_armada","master_armada.id = transaksi_penjualan.armada_id","LEFT"),
							array("master_produk","master_produk.id = transaksi_penjualan.produk_id","LEFT"),
							array("master_produk_kategori","master_produk_kategori.id = master_produk.kategori_id","LEFT"),
							array("master_gudang","master_gudang.id = transaksi_penjualan.gudang_id","LEFT"),
						);

			$where = array(
							"data" => array(),
							"tanggal" => null,
						);
			$where["data"]["laporan_account_kas.status"] = "keluar";
			$where["data"]["laporan_account_kas.info_input"] = "penjualan";
			if (!empty($tanggalAwal) && !empty($tanggalAkhir)) {
				$where["tanggal"] = array("laporan_account_kas.tanggal >=" => $tanggalAwal, "laporan_account_kas.tanggal <=" => $tanggalAkhir);
			} else {
				$search[] = "laporan_account_kas.tanggal";
			}
			if (!empty($gudang)) {
				$where["data"]["transaksi_penjualan.gudang_id"] = $gudang;
			} else {
				$search[] = "nama_gudang";
			}
			if (!empty($kategori)) {
				$where["data"]["kategori_id"] = $kategori;
			} else {
				$search[] = "kategori";
			}
			$result = $this->lPkasModel->findDataTableLpKas($where,$select,$orderBy,$search,$join);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";

				if ($item->keluar > 0) {
					$keluar = "Rp.".number_format($item->keluar,0,",",".");
					$item->keluar = "<span style='color:red;'>".$keluar."</span>";
				}

				$item->kode = '<a href="javasript:void();" title="Datatable rekap produk" onclick="rekapProduk('.$item->produk_id.')">'.$item->kode.'</a>';
				$item->nama_produk = '<a href="javasript:void();" title="Datatable rekap produk" onclick="rekapProduk('.$item->produk_id.')">'.$item->nama_produk.'</a>';
				$item->kategori = '<a href="javasript:void();" title="Datatable rekap kategori produk" onclick="rekapKategoriProduk('.$item->kategori_id.')">'.$item->kategori.'</a>';
				$item->nama_gudang = '<a href="javasript:void();" title="Datatable rekap gudang produk" onclick="rekapGudangProduk('.$item->gudang_id.')">'.$item->nama_gudang.'</a>';

				$data[] = $item;
			}
			return $this->lPkasModel->findDataTableOutputLpKas($data,$where,$select,$search,$join);
		}
		parent::json();
	}
}

/* End of file Accountkas.php */
/* Location: ./application/controllers/laporan/Accountkas.php */