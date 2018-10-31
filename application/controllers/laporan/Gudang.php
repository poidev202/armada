<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gudang extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('laporan/Gudang_model',"lpGudangModel");
		parent::checkUserRoleKasir(); // check role atau level function
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function

		parent::headerTitle("Laporan Gudang","Laporan","Gudang");

		$breadcrumbs = array(
								"Laporan"	=> 	site_url('laporan/gudang'),
								"Gudang"	=>	"",
							);

		parent::breadcrumbs($breadcrumbs);

		parent::viewLaporan();
	}

	public function ajax_list($tab=false) //untuk semua transaksi, masuk dan keluar
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {

			$requestData = $_REQUEST;
			$tanggalAwal = $requestData['columns'][0]['search']['value'];
			$tanggalAkhir = $requestData['columns'][1]['search']['value'];
			$gudang = $requestData['columns'][2]['search']['value'];
			$kategori = $requestData['columns'][3]['search']['value'];

			$select = array("laporan_gudang.*","master_gudang.nama_gudang","master_produk.kode","master_produk.nama_produk","master_produk_kategori.kategori","master_produk.kategori_id","master_produk_unit.unit");

			$columns = array(null,'laporan_gudang.tanggal','nama_gudang','kode','nama_produk','kategori','unit','laporan_gudang.harga_unit','masuk','keluar','laporan_gudang.status','laporan_gudang.keterangan');

			$search = array('kode','nama_produk','unit','laporan_gudang.harga_unit','masuk','keluar','laporan_gudang.status','laporan_gudang.keterangan');

			$join = array(
							array("master_produk","master_produk.id = laporan_gudang.produk_id","LEFT"),
							array("master_produk_kategori","master_produk_kategori.id = master_produk.kategori_id","LEFT"),
							array("master_produk_unit","master_produk_unit.id = master_produk.unit_id","LEFT"),
							array("master_gudang","master_gudang.id = laporan_gudang.gudang_id","LEFT"),
						);

			$where = array(
							"data" => array(),
							"tanggal" => null,
						);
			if (!empty($tanggalAwal) && !empty($tanggalAkhir)) {
				$where["tanggal"] = array("laporan_gudang.tanggal >=" => $tanggalAwal, "laporan_gudang.tanggal <=" => $tanggalAkhir);
			} else {
				$search[] = "laporan_gudang.tanggal";
			}
			if (!empty($gudang)) {
				$where["data"]["laporan_gudang.gudang_id"] = $gudang;
			} else {
				$search[] = "nama_gudang";
			}
			if (!empty($kategori)) {
				$where["data"]["kategori_id"] = $kategori;
			} else {
				$search[] = "kategori";
			}

			if ($tab == "masuk") {	// for transaksi masuk / saldo awal dan beli barang
				$where["data"]["laporan_gudang.status != "] = "keluar";
				$select = array("laporan_gudang.*","master_gudang.nama_gudang","master_vendor.nama_vendor","master_produk.kode","master_produk.nama_produk","master_produk.kategori_id","master_produk_kategori.kategori","master_produk_unit.unit");

				$columns = array(null,'laporan_gudang.tanggal','nama_gudang','nama_vendor','kode','nama_produk','kategori','unit','laporan_gudang.harga_unit','masuk','keluar','laporan_gudang.beli','laporan_gudang.keterangan');

				$search = array('laporan_gudang.tanggal','nama_gudang','nama_vendor','kode','nama_produk','kategori','unit','laporan_gudang.harga_unit','masuk','keluar','laporan_gudang.beli','laporan_gudang.keterangan');

				$join[] = array("master_vendor","master_vendor.id = laporan_gudang.vendor_id","LEFT");

			} else if ($tab == "keluar") {	// for transaksi keluar / penjualan / pemakaian untuk armada
				$where["data"]["laporan_gudang.status"] = "keluar";
				$select = array("laporan_gudang.*","master_gudang.nama_gudang","master_armada.nama","master_produk.kode","master_produk.nama_produk","master_produk.kategori_id","master_produk_kategori.kategori","master_produk_unit.unit");

				$columns = array(null,'laporan_gudang.tanggal','nama_gudang','nama','kode','nama_produk','kategori','unit','laporan_gudang.harga_unit','masuk','keluar','laporan_gudang.jual','laporan_gudang.keterangan');

				$search = array('laporan_gudang.tanggal','nama_gudang','nama','kode','nama_produk','kategori','unit','laporan_gudang.harga_unit','masuk','keluar','laporan_gudang.jual','laporan_gudang.keterangan');

				$join[] = array("master_armada","master_armada.id = laporan_gudang.armada_id","LEFT");

			}

			$result = $this->lpGudangModel->findDataTableLpGudang($where,$select,$columns,$search,$join);
			$data = array();
			foreach ($result as $item) {
				$item->no = "<b style='color:black;'>".$item->no."</b>";
				// $item->tanggal = date_ind("d M Y", $item->tanggal);
				$item->harga_unit = "Rp.".number_format($item->harga_unit,0,',','.');
				$item->beli = "Rp.".number_format($item->beli,0,',','.');
				$item->jual = "Rp.".number_format($item->jual,0,',','.');

				$item->kode = '<a href="javasript:void();" title="Datatable rekap produk" onclick="rekapProduk('.$item->produk_id.')">'.$item->kode.'</a>';
				$item->nama_produk = '<a href="javasript:void();" title="Datatable rekap produk" onclick="rekapProduk('.$item->produk_id.')">'.$item->nama_produk.'</a>';
				$item->kategori = '<a href="javasript:void();" title="Datatable rekap kategori produk" onclick="rekapKategoriProduk('.$item->kategori_id.')">'.$item->kategori.'</a>';
				$item->nama_gudang = '<a href="javasript:void();" title="Datatable rekap gudang produk" onclick="rekapGudangProduk('.$item->gudang_id.')">'.$item->nama_gudang.'</a>';
				if ($tab == "masuk") {
					$item->nama_vendor = '<a href="javasript:void();" title="Datatable rekap nama vendor produk" onclick="rekapVendorProduk('.$item->vendor_id.')">'.$item->nama_vendor.'</a>';
				}
				
				$data[] = $item;
			}
			return $this->lpGudangModel->findDataTableOutputLpGudang($data,$where,$select,$search,$join);
		}
		parent::json();
	}

	public function log_produk_ajax_list($tab=false) //untuk produk per gudang
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$where = false;
			$select = array("laporan_gudang.*","master_produk.kode","master_produk.nama_produk","master_produk_kategori.kategori","master_produk_unit.unit","master_produk.saldo_min");

			$columns = array(null,'kode','nama_produk','kategori','unit',null,'saldo_min');
			$search = array('kode','nama_produk','kategori','unit','saldo_min');

			$join = array(
							array("master_produk","master_produk.id = laporan_gudang.produk_id","LEFT"),
							array("master_produk_kategori","master_produk_kategori.id = master_produk.kategori_id","LEFT"),
							array("master_produk_unit","master_produk_unit.id = master_produk.unit_id","LEFT"),
						);
			$groupBy = array("laporan_gudang.produk_id");
			// $groupBy = false;
			if ($tab=="pergudang") {
				$select = array("laporan_gudang.*","master_produk.kode","master_produk.nama_produk","master_produk_kategori.kategori","master_produk_unit.unit","master_produk.saldo_min","master_gudang.nama_gudang");
				$columns = array(null,'kode','nama_produk','nama_gudang','kategori','unit');
				$search = array('kode','nama_produk','nama_gudang','kategori','unit');

				$join[] = array("master_gudang","master_gudang.id = laporan_gudang.gudang_id","LEFT");
				$groupBy = array("laporan_gudang.produk_id","laporan_gudang.gudang_id");
			} else {
				$join[] = array("master_vendor","master_vendor.id = laporan_gudang.vendor_id","LEFT");
			}

			$result = $this->lpGudangModel->findDataTable($where,$select,$columns,$search,$join,false,$groupBy);
			$data = array();
			foreach ($result as $item) {
				$item->no = "<b style='color:black;'>".$item->no."</b>";

				$total_saldo = $this->lpGudangModel->getSelectSum("masuk",array("produk_id" => $item->produk_id));
				$item->total_saldo = $total_saldo->masuk;
				$saldo_keluar = $this->lpGudangModel->getSelectSum("keluar",array("produk_id" => $item->produk_id));
				$item->saldo_keluar = $saldo_keluar->keluar;
				$item->sisa_saldo = ($total_saldo->masuk - $saldo_keluar->keluar);

				$btnAction = '<button type="button" onclick="btnRekapMasukProduk('.$item->produk_id.')" class="btn btn btn-outline-success btn-xs m-b-10" title="Rekap Transaksi Masuk Produk"><i class="fa fa-list-alt"></i> Masuk</button> &nbsp;&nbsp;&nbsp;'; // rekap masuk

				$btnAction .= '<button type="button" onclick="btnRekapKeluarProduk('.$item->produk_id.')" class="btn btn btn-outline-danger btn-xs m-b-10" title="Rekap Transaksi Keluar Produk"><i class="fa fa-list-alt"></i> Keluar</button>'; // rekap Keluar
				if ($tab == "pergudang") {
					$total_saldo = $this->lpGudangModel->getSelectSum("masuk",array("produk_id" => $item->produk_id,"gudang_id" => $item->gudang_id));
					$item->total_saldo = $total_saldo->masuk;
					$saldo_keluar = $this->lpGudangModel->getSelectSum("keluar",array("produk_id" => $item->produk_id,"gudang_id" => $item->gudang_id));
					$item->saldo_keluar = $saldo_keluar->keluar;
					$item->sisa_saldo = ($total_saldo->masuk - $saldo_keluar->keluar);

					$btnAction = '<button type="button" onclick="btnRekapMasukProdukGudang('.$item->produk_id.','.$item->gudang_id.')" class="btn btn btn-outline-success btn-xs m-b-10" title="Rekap Transaksi Masuk Produk per gudang"><i class="fa fa-list-alt"></i> Masuk</button> &nbsp;&nbsp;&nbsp;'; // rekap masuk per gudang

					$btnAction .= '<button type="button" onclick="btnRekapKeluarProdukGudang('.$item->produk_id.','.$item->gudang_id.')" class="btn btn btn-outline-danger btn-xs m-b-10" title="Rekap Transaksi Keluar Produk per gudang"><i class="fa fa-list-alt"></i> Keluar</button>'; // rekap Keluar per gudang
				}

				$item->button_action = $btnAction;
				$data[] = $item;
			}
			return $this->lpGudangModel->findDataTableOutput($data,$where,$search,$join,false,$groupBy,$select);
		}
		parent::json();
	}

	/*untuk rekap produk*/
	public function totalSumProduk($statusProduk,$idProduk,$idGudang=false)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$where = array("laporan_gudang.produk_id" => $idProduk);
			$select = array("laporan_gudang.*","SUM(laporan_gudang.masuk) AS total_saldo","SUM(laporan_gudang.keluar) AS saldo_keluar","SUM(laporan_gudang.beli) AS total_beli","SUM(laporan_gudang.jual) AS total_jual","master_produk.saldo_min");

			if ($statusProduk == "masuk") {
				$where["laporan_gudang.status !="] = "keluar";

				$select = array("laporan_gudang.produk_id","SUM(laporan_gudang.masuk) AS total_saldo_masuk","SUM(laporan_gudang.beli) AS total_beli","master_produk.kode","master_produk.nama_produk","master_produk_kategori.kategori","master_produk_unit.unit");
			} else if ($statusProduk == "keluar") {
				$where["laporan_gudang.status"] = "keluar";

				$select = array("laporan_gudang.produk_id","SUM(laporan_gudang.keluar) AS total_saldo_keluar","SUM(laporan_gudang.jual) AS total_jual","master_produk.kode","master_produk.nama_produk","master_produk_kategori.kategori","master_produk_unit.unit");
			}

			if ($idGudang) {
				$where["laporan_gudang.gudang_id"]	= $idGudang;
			}

			$join = array(
							array("master_produk","master_produk.id = laporan_gudang.produk_id","LEFT"),
							array("master_produk_kategori","master_produk_kategori.id = master_produk.kategori_id","LEFT"),
							array("master_produk_unit","master_produk_unit.id = master_produk.unit_id","LEFT"),
						);
			$dataProduk = $this->lpGudangModel->getByWhere($where,$select,$join);
			if ($dataProduk) {
				if ($dataProduk->produk_id != NULL) {

					if ($statusProduk == "masuk") {
						$dataProduk->total_beli_rp = "Rp.".number_format($dataProduk->total_beli,0,",",".");
					} elseif ($statusProduk == "keluar") {
						$dataProduk->total_jual_rp = "Rp.".number_format($dataProduk->total_jual,0,",",".");
					}

					$this->response->status = true;
					$this->response->message = "detail rekap produk masuk dan keluar";
					$this->response->data = $dataProduk;
				} else {
					$this->response->message = alertDanger("Data Produk tidak ada.!");
				}
			} else {
				$this->response->message = alertDanger("Data Produk tidak ada.!");
			}
		}
		parent::json();
	}

	public function detail_rekap_produk_masuk($idProduk,$idGudang=false)	// for datatable datail rekap masuk produk dan per gudang
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			/*data table rekap masuk produk*/
			$where = array(
							"laporan_gudang.produk_id" => $idProduk,
							"laporan_gudang.status !=" => "keluar",
						);
			if ($idGudang) {
				$where["laporan_gudang.gudang_id"]	= $idGudang;
			}

			$select = array("laporan_gudang.tanggal","laporan_gudang.harga_unit","laporan_gudang.masuk","laporan_gudang.beli","master_gudang.nama_gudang","master_vendor.nama_vendor");
			$columns = array(null,'laporan_gudang.tanggal','nama_gudang','nama_vendor','laporan_gudang.masuk','laporan_gudang.harga_unit','beli');
			$search = array('laporan_gudang.tanggal','nama_gudang','nama_vendor','laporan_gudang.masuk','laporan_gudang.harga_unit','beli');
			$join = array(
							array("master_gudang","master_gudang.id = laporan_gudang.gudang_id","LEFT"),
							array("master_vendor","master_vendor.id = laporan_gudang.vendor_id","LEFT")
					);
			$result = $this->lpGudangModel->findDataTable($where,$select,$columns,$search,$join);
			$data = array();
			foreach ($result as $item) {
				$item->no = "<b style='color:black;'>".$item->no."</b>";
				$item->tanggal = date_ind("d M Y", $item->tanggal);
				$item->harga_unit = "Rp.".number_format($item->harga_unit,0,",",".");
				$item->beli = "Rp.".number_format($item->beli,0,",",".");

				$data[] = $item;
			}
			return $this->lpGudangModel->findDataTableOutput($data,$where,$search,$join);
		}
	}

	public function detail_rekap_produk_keluar($idProduk,$idGudang=false)	// for datatable datail rekap keluar produk dan per gudang
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			/*data table rekap keluar produk*/
			$where = array(
							"laporan_gudang.produk_id" => $idProduk,
							"laporan_gudang.status" => "keluar",
						);
			if ($idGudang) {
				$where["laporan_gudang.gudang_id"]	= $idGudang;
			}

			$select = array("laporan_gudang.tanggal","laporan_gudang.harga_unit","laporan_gudang.keluar","laporan_gudang.jual","master_gudang.nama_gudang","master_armada.nama");
			$columns = array(null,'laporan_gudang.tanggal','nama_gudang','nama','laporan_gudang.keluar','laporan_gudang.harga_unit','jual');
			$search = array('laporan_gudang.tanggal','nama_gudang','nama','laporan_gudang.keluar','laporan_gudang.harga_unit','jual');
			$join = array(
							array("master_gudang","master_gudang.id = laporan_gudang.gudang_id","LEFT"),
							array("master_armada","master_armada.id = laporan_gudang.armada_id","LEFT")
					);
			$result = $this->lpGudangModel->findDataTable($where,$select,$columns,$search,$join);
			$data = array();
			foreach ($result as $item) {
				$item->no = "<b style='color:black;'>".$item->no."</b>";
				$item->tanggal = date_ind("d M Y", $item->tanggal);
				$item->harga_unit = "Rp.".number_format($item->harga_unit,0,",",".");
				$item->jual = "Rp.".number_format($item->jual,0,",",".");

				$data[] = $item;
			}
			return $this->lpGudangModel->findDataTableOutput($data,$where,$search,$join);
		}
	}
	/* end rekap produk*/

	public function produkSaldo($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$where = array("laporan_gudang.produk_id" => $id);
			$select = array("laporan_gudang.*","SUM(laporan_gudang.masuk) AS total_saldo","SUM(laporan_gudang.keluar) AS saldo_keluar","master_produk.saldo_min");
			$join = array(
							array("master_produk","master_produk.id = laporan_gudang.produk_id","LEFT"),
						);
			$dataProduk = $this->lpGudangModel->getByWhere($where,$select,$join);
			if ($dataProduk) {
				if ($dataProduk->produk_id != NULL) {
					$dataProduk->sisa_saldo = ($dataProduk->total_saldo - $dataProduk->saldo_keluar);

					$this->response->status = true;
					$this->response->message = "Data saldo ada.";
					$this->response->data = $dataProduk;
				} else {
					$this->response->message = spanRed("Data Saldo tidak ada.!");
				}
			} else {
				$this->response->message = spanRed("Data Saldo tidak ada.!");
			}
		}
		parent::json();
	}

	public function gudangPerProduk($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$where = array(
							"laporan_gudang.produk_id" 	=> $id,
							"laporan_gudang.status !="	=>	"keluar",
						);
			$select = array("laporan_gudang.*","master_gudang.nama_gudang");
			$join = array(
							array("master_gudang","master_gudang.id = laporan_gudang.gudang_id","LEFT"),
						);
			$dataProduk = $this->lpGudangModel->getAll($where,$select,false,$join,false,array("laporan_gudang.gudang_id"));
			if ($dataProduk) {
				$this->response->status = true;
				$this->response->message = "Data saldo ada.";
				$this->response->data = $dataProduk;
			} else {
				$this->response->message = spanRed("Data Saldo tidak ada.!");
			}
		}
		parent::json();
	}

	public function gudangHargaUnitProduk($idProduk,$idGudang)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$where = array(
							"produk_id" 	=> $idProduk,
							"gudang_id" 	=> $idGudang,
							"status !="		=>	"keluar",
						);
			$dataProduk = $this->lpGudangModel->getAll($where,false,array("tanggal ASC"));
			if ($dataProduk) {
				foreach ($dataProduk as $item) {
					$item->tanggal_indo = date_ind("d M Y", $item->tanggal);
					$item->harga_unit_rp = "Rp.".number_format($item->harga_unit,0,',','.');
				}
				$this->response->status = true;
				$this->response->message = "Data harga unit ada.";
				$this->response->data = $dataProduk;
			} else {
				$this->response->message = spanRed("Data harga unit tidak ada.!<br> Silahkan pilih gudang yang lain.");
			}
		}
		parent::json();
	}

	public function gudangProdukBeliTanggal($idProduk,$idGudang)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$where = array(
							"produk_id" 	=> $idProduk,
							"gudang_id" 	=> $idGudang,
							"status !="		=>	"keluar",
						);
			$dataProduk = $this->lpGudangModel->getAll($where,false,array("tanggal ASC"),false,false,array("tanggal"));
			if ($dataProduk) {
				foreach ($dataProduk as $item) {
					$item->tanggal_beli_indo = date_ind("d M Y", $item->tanggal);
					$item->harga_unit_tgl_rp = "Rp.".number_format($item->harga_unit,0,',','.');
				}
				$this->response->status = true;
				$this->response->message = "Data tanggal beli harga unit";
				$this->response->data = $dataProduk;
			} else {
				$this->response->message = spanRed("Data harga unit tidak ada.!<br> Silahkan pilih gudang yang lain.");
			}
		}
		parent::json();
	}

	public function gudangHargaUnitProdukTanggal($idProduk,$idGudang)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {

			$where = array(
							"produk_id" 	=> $idProduk,
							"gudang_id" 	=> $idGudang,
							"status !="		=>	"keluar",
						);
			// data harga yang sisa saldo nya 0 tidak boleh muncul lagi ya.
			$dataProduk = $this->lpGudangModel->getAll($where,false,array("tanggal ASC"),false,false,array("tanggal"));
			if ($dataProduk) {
				$this->load->model('transaksi/Penjualan_model',"penjualanModel");

					$dataHargaGudang = "<option value=''>--Pilih Harga--</option>";
					foreach ($dataProduk as $item) {
						$item->tanggal_beli_indo = date_ind("d M Y", $item->tanggal);

						$hargaTanggal = "";
						$where["tanggal"] = $item->tanggal;
			// data harga yang sisa saldo nya 0 tidak boleh muncul lagi ya.
						$dataharga = $this->lpGudangModel->getAll($where,false,array("tanggal ASC"));
						foreach ($dataharga as $val) {

							$whereJual = array(
											"tanggal_beli"		=>	$val->tanggal,
											"produk_id" 		=> 	$val->produk_id,
											"gudang_id" 		=> 	$val->gudang_id,
											"harga_unit_beli"	=>	$val->harga_unit,
										);
							$selectJual = array("SUM(jumlah) AS total_jumlah");
							$produkJual = $this->penjualanModel->getByWhere($whereJual,$selectJual);
							if ($produkJual && ($val->masuk > $produkJual->total_jumlah)) {
								$harga_unit_tgl_rp = "Rp.".number_format($val->harga_unit,0,',','.');
								$hargaTanggal .= '<option value="'.$val->tanggal.'||'.$val->harga_unit.'">'.$harga_unit_tgl_rp.'</option>';
							}
						}

						$whereJual1 = array(
											"tanggal_beli"		=>	$item->tanggal,
											"produk_id" 		=> 	$item->produk_id,
											"gudang_id" 		=> 	$item->gudang_id,
											// "harga_unit_beli"	=>	$item->harga_unit,
										);
						$selectJual1 = array("SUM(jumlah) AS total_jumlah");
						$produkJual1 = $this->penjualanModel->getByWhere($whereJual1,$selectJual1);
						if ($produkJual1 && ($item->masuk > $produkJual1->total_jumlah)) {
							$statusBeli = $item->status == "saldo_awal" ? "Saldo awal" : "Beli";
							$dataHargaGudang .= '<optgroup label="-<u>'.$statusBeli.' : </u>'.$item->tanggal_beli_indo.'">'.$hargaTanggal.'</optgroup>';
						}

					}
				$this->response->status = true;
				$this->response->message = "Data tanggal beli harga unit";
				$this->response->data = $dataHargaGudang;
			} else {
				$this->response->message = spanRed("Data harga unit tidak ada.!<br> Silahkan pilih gudang yang lain.");
			}
		}
		parent::json();
	}

	public function saldoHargaProdukTanggal($tgl,$idProduk,$idGudang,$hargaUnit)
	{
		parent::checkLoginUser(); // otoritas authentic function
		if ($this->isPost()) {
			$where = array(
							"tanggal"		=>	$tgl,
							"produk_id" 	=> 	$idProduk,
							"gudang_id" 	=> 	$idGudang,
							"harga_unit"	=>	$hargaUnit,
							"status !="		=>	"keluar",
						);
			$select = array("tanggal","SUM(laporan_gudang.masuk) AS total_saldo_masuk","status");
			$produkMasuk = $this->lpGudangModel->getByWhere($where,$select);
			if ($produkMasuk) {
				$this->load->model('transaksi/Penjualan_model',"penjualanModel");
				$whereJual = array(
								"tanggal_beli"		=>	$tgl,
								"produk_id" 		=> 	$idProduk,
								"gudang_id" 		=> 	$idGudang,
								"harga_unit_beli"	=>	$hargaUnit,
							);
				$selectJual = array("SUM(jumlah) AS total_jumlah");
				$produkJual = $this->penjualanModel->getByWhere($whereJual,$selectJual);

				$data = array(
								"tanggal_indo"				=>	date_ind("d M Y", $produkMasuk->tanggal),
								"total_saldo_masuk_hrg_tgl" => 	$produkMasuk->total_saldo_masuk,
								"sisa_saldo_hrg_tgl"		=>	($produkMasuk->total_saldo_masuk - $produkJual->total_jumlah),
								"status_produk"				=>	$produkMasuk->status,
							);
				$this->response->status = true;
				$this->response->message = "data masuk saldo dan sisa saldo";
				$this->response->data = $data;
			} else {
				$this->response->message = spanRed("Data harga unit tidak ada.!");
			}
		}
		parent::json();
	}

	public function gudangSumSaldoPerProduk($idProduk,$idGudang)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$where = array(
							"produk_id" => 	$idProduk,
							"gudang_id"	=>	$idGudang,
						);
			$select = array("laporan_gudang.*","SUM(laporan_gudang.masuk) AS total_saldo","SUM(laporan_gudang.keluar) AS saldo_keluar");
			$dataProduk = $this->lpGudangModel->getByWhere($where,$select);
			if ($dataProduk) {
				if ($dataProduk->produk_id != NULL) {
					$dataProduk->sisa_saldo_gudang = ($dataProduk->total_saldo - $dataProduk->saldo_keluar);

					$this->response->status = true;
					$this->response->message = "Data saldo gudang ada.";
					$this->response->data = $dataProduk;
				} else {
					$this->response->message = spanRed("Data saldo gudang tidak ada.!");
				}
			} else {
				$this->response->message = spanRed("Data saldo gudang tidak ada.!");
			}
		}
		parent::json();
	}

}

/* End of file Gudang.php */
/* Location: ./application/controllers/laporan/Gudang.php */