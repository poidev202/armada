<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('master/Produk_model',"produkModel");
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		parent::headerTitle("Master Produk","Master Inventori","Produk");

		$breadcrumbs = array(
								"Master Inventori"	=> 	site_url('master/produk'),
								"Produk"	=>	"",
							);

		parent::breadcrumbs($breadcrumbs);

		parent::viewMaster();
	}

	public function ajax_list()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function
		if ($this->isPost()) {
			$select = array("master_produk.*","master_produk_kategori.kategori","master_produk_unit.unit","master_vendor.nama_vendor","master_gudang.nama_gudang");
			$columns = array(null,'kode','nama_produk','kategori','unit','nama_gudang','nama_vendor','harga_unit','saldo','saldo_min');
			$search = array('kode','nama_produk','nama_gudang','kategori','unit','harga_unit','saldo','saldo_min');
			$join = array(
							array("master_produk_kategori","master_produk_kategori.id = master_produk.kategori_id","LEFT"),
							array("master_produk_unit","master_produk_unit.id = master_produk.unit_id","LEFT"),
							array("master_vendor","master_vendor.id = master_produk.vendor_id","LEFT"),
							array("master_gudang","master_gudang.id = master_produk.gudang_id","LEFT"),
						);

			$result = $this->produkModel->findDataTable(false,$select,$columns,$search,$join);
			$data = array();
			foreach ($result as $item) {
				$item->no = "<b style='color:black;'>".$item->no."</b>";
				// $item->tanggal_beli = date_ind("d M Y", $item->tanggal_beli);
				$cekNama = $this->produkModel->getAll(array("nama_produk" => $item->nama_produk, "gudang_id" => $item->gudang_id));
				if (count($cekNama) > 1) {
					if ($item->nama_produk == $cekNama[0]->nama_produk) {
						$item->nama_produk = "<strike style='color:red;'>".$item->nama_produk."</strike>";
						$item->nama_produk .= "<br><i><small>duplicate data</small></i>";
					}
					if ($item->gudang_id == $cekNama[0]->gudang_id) {
						$item->nama_gudang = "<strike style='color:red;'>".$item->nama_gudang."</strike>";
						$item->nama_gudang .= "<br><i><small>duplicate data</small></i>";
					}
				}

				$item->harga_unit = "Rp.".number_format($item->harga_unit,0,',','.');
				$item->kode = '<a href="javasript:void();" title="Datatable rekap produk" onclick="rekapProduk('.$item->id.')">'.$item->kode.'</a>';
				$item->nama_produk = '<a href="javasript:void();" title="Datatable rekap produk" onclick="rekapProduk('.$item->id.')">'.$item->nama_produk.'</a>';
				$item->kategori = '<a href="javasript:void();" title="Datatable rekap kategori produk" onclick="rekapKategoriProduk('.$item->kategori_id.')">'.$item->kategori.'</a>';
				$item->nama_gudang = '<a href="javasript:void();" title="Datatable rekap gudang produk" onclick="rekapGudangProduk('.$item->gudang_id.')">'.$item->nama_gudang.'</a>';
				$item->nama_vendor = '<a href="javasript:void();" title="Datatable rekap nama vendor produk" onclick="rekapVendorProduk('.$item->vendor_id.')">'.$item->nama_vendor.'</a>';

				$btnAction = '<button type="button" onclick="detailProduk('.$item->id.')" class="btn btn btn-outline-info btn-xs m-b-10" title="Detail"><i class="fa fa-info-circle"></i> </button> '; // detail

				$btnAction .= '<button type="button" onclick="editProduk('.$item->id.')" class="btn btn btn-outline-warning btn-xs m-b-10" title="Edit"><i class="fa fa-pencil-square-o"></i> </button> '; // update
				
				$btnAction .='<button type="button" onclick="btnDelete('.$item->id.')" class="btn btn-outline-danger btn-xs m-b-10" title="Hapus"><i class="fa fa-trash-o"></i> </button>'; // delete

				$item->button_action = $btnAction;

				$data[] = $item;
			}
			return $this->produkModel->findDataTableOutput($data,false,$search,$join);
		}
		parent::json();
	}

	public function ajax_list_rekap($idProduk=null) // for rekap datatable produk
	{
		$this->load->model('laporan/Gudang_model',"lpGudangModel");
		$this->load->model('transaksi/Penjualan_model',"penjualanModel");
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {

			$where = array("produk_id" => $idProduk);
			$select = array("laporan_gudang.*","master_gudang.nama_gudang");
			$columns = array(null,'tanggal','masuk','keluar','harga_unit',"nama_gudang",null,"status");
			$search = array('tanggal','masuk','keluar','harga_unit',"nama_gudang","status");
			$join = array(
							array("master_gudang","master_gudang.id = laporan_gudang.gudang_id","LEFT"),
						);

			$result = $this->lpGudangModel->findDataTable($where,$select,$columns,$search,$join);
			$data = array();
			foreach ($result as $item) {
				
				$item->saldo_saat_ini = "-";
				if ($item->masuk > 0) {
					$whereMasuk = array(
							"tanggal"		=>	$item->tanggal,
							"produk_id" 	=> 	$item->produk_id,
							"gudang_id" 	=> 	$item->gudang_id,
							"harga_unit"	=>	$item->harga_unit,
							"status !="		=>	"keluar",
						);
					$selectMasuk = array("SUM(laporan_gudang.masuk) AS total_saldo_masuk");
					$produkMasuk = $this->lpGudangModel->getByWhere($whereMasuk,$selectMasuk);

					$whereJual = array(
									"tanggal_beli"		=>	$item->tanggal,
									"produk_id" 		=> 	$item->produk_id,
									"gudang_id" 		=> 	$item->gudang_id,
									"harga_unit_beli"	=>	$item->harga_unit,
								);
					$selectJual = array("SUM(jumlah) AS total_jumlah");
					$produkJual = $this->penjualanModel->getByWhere($whereJual,$selectJual);
					$item->saldo_saat_ini = ($produkMasuk->total_saldo_masuk - $produkJual->total_jumlah);
				}

				if ($item->saldo_saat_ini === 0) {
					$item->saldo_saat_ini = "<span title='Saldo sudah habis' style='color:red;'>".$item->saldo_saat_ini."</span>";
				} else if ($item->saldo_saat_ini > 0) {
					$item->saldo_saat_ini = "<span title='Saldo sudah habis' style='color:#1976d2;'>".$item->saldo_saat_ini."</span>";
				}
					
				$item->no = "<b style='color:black;'>".$item->no."</b>";
				// $item->tanggal_beli = date_ind("d M Y", $item->tanggal_beli);
				$item->harga_unit = "Rp.".number_format($item->harga_unit,0,',','.');
				if ($item->masuk > 0) {
					$item->masuk = "<span style='color:#0bde43;'>".$item->masuk."</span>";
				}
				if ($item->keluar > 0) {
					$item->keluar = "<span style='color:red;'>".$item->keluar."</span>";
				}

				if ($item->status == "keluar") {
					$item->status = "<span style='color:red;'>".$item->status."</span>";
				} else {
					$item->status = "<span style='color:#0bde43;'>".$item->status."</span>";
				}

				$data[] = $item;
			}
			return $this->lpGudangModel->findDataTableOutput($data,$where,$search,$join);
		}
		parent::json();
	}

	public function ajax_list_rekap_kategori($idKategori=null) // for rekap datatable kategori produk
	{
		$this->load->model('laporan/Gudang_model',"lpGudangModel");
		$this->load->model('transaksi/Penjualan_model',"penjualanModel");
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$where = array("master_produk.kategori_id" => $idKategori);
			$select = array("laporan_gudang.*","master_produk.kode","master_produk.nama_produk","master_gudang.nama_gudang");
			$columns = array(null,'kode','nama_produk',"nama_gudang");
			$search = array('kode','nama_produk',"nama_gudang");
			$join = array(
							array("master_produk","master_produk.id = laporan_gudang.produk_id","LEFT"),
							array("master_gudang","master_gudang.id = laporan_gudang.gudang_id","LEFT"),
						);
			$groupBy = array("master_produk.kode","master_produk.nama_produk","laporan_gudang.gudang_id");
			$result = $this->lpGudangModel->findDataTable($where,$select,$columns,$search,$join,false,$groupBy);
			$data = array();
			foreach ($result as $item) {
				
				$whereMasuk = array(
						"produk_id" 	=> 	$item->produk_id,
						"gudang_id" 	=> 	$item->gudang_id,
						"status !="		=>	"keluar",
					);
				$selectMasuk = array("SUM(laporan_gudang.masuk) AS total_saldo_masuk");
				$produkMasuk = $this->lpGudangModel->getByWhere($whereMasuk,$selectMasuk);

				$whereKeluar = array(
						"produk_id" 	=> 	$item->produk_id,
						"gudang_id" 	=> 	$item->gudang_id,
						"status"		=>	"keluar",
					);
				$selectKeluar = array("SUM(laporan_gudang.keluar) AS total_saldo_keluar");
				$produkKeluar = $this->lpGudangModel->getByWhere($whereKeluar,$selectKeluar);

				$item->saldo_saat_ini = ($produkMasuk->total_saldo_masuk - $produkKeluar->total_saldo_keluar);
					
				$item->no = "<b style='color:black;'>".$item->no."</b>";
				$item->harga_unit = "Rp.".number_format($item->harga_unit,0,',','.');
				$data[] = $item;
			}
			return $this->lpGudangModel->findDataTableOutput($data,$where,$search,$join,false,$groupBy,$select);
		}
		parent::json();
	}

	public function ajax_list_rekap_vendor($idVendor=null) // for rekap datatable vendor produk
	{
		$this->load->model('laporan/Gudang_model',"lpGudangModel");
		$this->load->model('transaksi/Penjualan_model',"penjualanModel");
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$where = array("master_produk.vendor_id" => $idVendor);
			$select = array("laporan_gudang.*","master_produk.kode","master_produk.nama_produk","master_gudang.nama_gudang");
			$columns = array(null,'kode','nama_produk',"nama_gudang");
			$search = array('kode','nama_produk',"nama_gudang");
			$join = array(
							array("master_produk","master_produk.id = laporan_gudang.produk_id","LEFT"),
							array("master_gudang","master_gudang.id = laporan_gudang.gudang_id","LEFT"),
							array("master_vendor","master_vendor.id = master_produk.vendor_id","LEFT"),
						);
			$groupBy = array("master_produk.kode","master_produk.nama_produk","laporan_gudang.gudang_id");
			$result = $this->lpGudangModel->findDataTable($where,$select,$columns,$search,$join,false,$groupBy);
			$data = array();
			foreach ($result as $item) {
				
				$whereMasuk = array(
						"produk_id" 	=> 	$item->produk_id,
						"gudang_id" 	=> 	$item->gudang_id,
						"status !="		=>	"keluar",
					);
				$selectMasuk = array("SUM(laporan_gudang.masuk) AS total_saldo_masuk");
				$produkMasuk = $this->lpGudangModel->getByWhere($whereMasuk,$selectMasuk);

				$whereKeluar = array(
						"produk_id" 	=> 	$item->produk_id,
						"gudang_id" 	=> 	$item->gudang_id,
						"status"		=>	"keluar",
					);
				$selectKeluar = array("SUM(laporan_gudang.keluar) AS total_saldo_keluar");
				$produkKeluar = $this->lpGudangModel->getByWhere($whereKeluar,$selectKeluar);

				$item->saldo_saat_ini = ($produkMasuk->total_saldo_masuk - $produkKeluar->total_saldo_keluar);
					
				$item->no = "<b style='color:black;'>".$item->no."</b>";
				$item->harga_unit = "Rp.".number_format($item->harga_unit,0,',','.');
				$data[] = $item;
			}
			return $this->lpGudangModel->findDataTableOutput($data,$where,$search,$join,false,$groupBy,$select);
		}
		parent::json();
	}

	public function inputValidate()
	{
		$this->form_validation->set_rules("nama_produk","Nama Produk","trim|required");
		// $this->form_validation->set_rules("tanggal_beli","Tanggal Beli","trim|required");
		$this->form_validation->set_rules('gudang', 'Gudang', 'trim|required');
		$this->form_validation->set_rules("kategori","Kategori","trim|required");
		$this->form_validation->set_rules("unit","Unit / Satuan","trim|required");
		$this->form_validation->set_rules("vendor","Vendor","trim|required");
		$this->form_validation->set_rules("harga_unit","Harga Unit","trim|required");
		$this->form_validation->set_rules("saldo","Saldo","trim|required");
		$this->form_validation->set_rules("saldo_minimal","Saldo Minimal","trim|required");
		$this->form_validation->set_rules("keterangan","Keterangan","trim");
	}

	public function add()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$nama_produk = $this->input->post("nama_produk");
			// $tanggal_beli = $this->input->post("tanggal_beli");
			$gudang = $this->input->post("gudang");
			$kategori = $this->input->post("kategori");
			$unit = $this->input->post("unit");
			$vendor = $this->input->post("vendor");
			$harga_unit = $this->input->post("harga_unit");
			$saldo = $this->input->post("saldo");
			$saldo_minimal = $this->input->post("saldo_minimal");
			$keterangan = $this->input->post("keterangan");

			// form validate
			self::inputValidate();

			if ($this->form_validation->run() == true) {

				$kode_akhir = $this->produkModel->getAll(false,array("kode"),array("LPAD(lower(kode), 10,0) DESC"));
				if ($kode_akhir == null) {
					$kodeProduk = 'PDK-1';
				} else {
			        $kodeUrut = (int) substr($kode_akhir[0]->kode, strpos($kode_akhir[0]->kode, '-') + 1); 
			        $kodeProduk = 'PDK-'.($kodeUrut + 1); 
			    }

				$data = array(
							"kode"			=>	$kodeProduk,
							// "tanggal_beli"	=>	date("Y-m-d"),
							"nama_produk"	=>	$nama_produk,
							"gudang_id"		=>	$gudang,
							"kategori_id"	=>	$kategori,
							"unit_id"		=>	$unit,
							"vendor_id"		=>	$vendor,
							"harga_unit"	=>	$harga_unit,
							"saldo"			=>	$saldo,
							"harga_unit_total"	=>	($saldo * $harga_unit),
							"saldo_min"		=>	$saldo_minimal,
							"keterangan"	=>	$keterangan
						);

				$where = array("nama_produk" => $nama_produk,"gudang_id" => $gudang);
				$select = array("master_produk.*","master_gudang.nama_gudang");
				$join = array(
								array("master_gudang","master_gudang.id = master_produk.gudang_id","LEFT"),
							);
				$checkProdukGudang = $this->produkModel->getByWhere($where,$select,$join);
				if ($checkProdukGudang) {
					$this->response->error = array("nama_produk" => spanRed("Nama produk <u>".$nama_produk."</u> sudah ada di gudang <u>".$checkProdukGudang->nama_gudang."</u>"));
				} else {
					$this->load->model('laporan/gudang_model',"laporanGudangModel");

					// $insertProduk = $this->produkModel->insert($data);
					$dataLaporanGudang = array(
												"gudang_id"	=>	$gudang,
												"tanggal"	=>	date("Y-m-d"),
												"keterangan"=>	"Saldo awal",
												// "saldo"		=>	$saldo,
												"masuk"		=>	$saldo,
												"harga_unit"=>	$harga_unit,
												"beli"		=>	($saldo * $harga_unit),
												"status"	=>	"saldo_awal",
												"vendor_id"	=>	$vendor,
										);
					// $insertLaporanGudang = $this->laporanGudangModel->insert($dataLaporanGudang);

					// $insertTransaction = $this->produkModel->transactionBeginMerge(array($insertProduk,$insertLaporanGudang));
					$insertTransaction = $this->produkModel->transactionInsert($data,$dataLaporanGudang);
					if ($insertTransaction) {
						$this->response->status = true;
						$this->response->message = alertSuccess("Data berhasil di tambah..");
						$this->response->data = $data;
					} else {
						$this->response->message = alertDanger("Data gagal di tambah..");
					}
				}
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
				/*$this->response->error = array(
									// "tanggal_beli"	=> form_error("tanggal_beli",'<span style="color:red;">','</span>'),
									"nama_produk"	=> form_error("nama_produk",'<span style="color:red;">','</span>'),
									"gudang"	=> form_error("gudang",'<span style="color:red;">','</span>'),
									"kategori"	=> form_error("kategori",'<span style="color:red;">','</span>'),
									"unit"	=> form_error("unit",'<span style="color:red;">','</span>'),
									"vendor"	=> form_error("vendor",'<span style="color:red;">','</span>'),
									"keterangan"	=> form_error("keterangan",'<span style="color:red;">','</span>'),
								);*/
			}
		}
		parent::json();
	}

	public function getId($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$select = array("master_produk.*","master_produk_kategori.kategori","master_produk_unit.unit","master_vendor.nama_vendor","master_gudang.nama_gudang");

			$join = array(
							array("master_produk_kategori","master_produk_kategori.id = master_produk.kategori_id","LEFT"),
							array("master_produk_unit","master_produk_unit.id = master_produk.unit_id","LEFT"),
							array("master_vendor","master_vendor.id = master_produk.vendor_id","LEFT"),
							array("master_gudang","master_gudang.id = master_produk.gudang_id","LEFT"),
						);
			$data = $this->produkModel->getByWhere(array("master_produk.id"=>$id),$select,$join);
			if ($data) {
				$this->load->model('transaksi/pembelian_model',"pembelianModel");
				$harga_beli_unit = $this->pembelianModel->getAll(array("produk_id"=>$id),array("harga_beli_unit"),array("harga_beli_unit DESC"));
				$harga_unit_All = array();
				foreach ($harga_beli_unit as $val) {
					$harga_unit_All[] = intval($val->harga_beli_unit);
				}
				$harga_unit_All[] = intval($data->harga_unit);
				if(count($harga_unit_All)) {
					$harga_unit_All = array_filter($harga_unit_All);
					$harga_unit_rata2 = array_sum($harga_unit_All)/count($harga_unit_All);
				} else {
					$harga_unit_rata2 = 0;
				} 
				$harga_unit_min = min($harga_unit_All);
				$harga_unit_max = max($harga_unit_All);

				// $data->harga_unit_all = $harga_unit_All; 
				$data->harga_unit_min = "Rp.".number_format($harga_unit_min,0,',','.');
				$data->harga_unit_rata2 = "Rp.".number_format($harga_unit_rata2,0,',','.');
				$data->harga_unit_max = "Rp.".number_format($harga_unit_max,0,',','.');
				$data->harga_terakhir = 0;
				if ($harga_beli_unit) {
					$data->harga_terakhir = "Rp.".number_format($harga_beli_unit[0]->harga_beli_unit,0,',','.');
				}
				
				// $data->tanggal_beli_indo = date_ind("d M Y", $data->tanggal_beli);

				$data->harga_unit_rp = "Rp.".number_format($data->harga_unit,0,',','.');
				$data->harga_unit_total_rp = "Rp.".number_format($data->harga_unit_total,0,',','.');

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
			
			$data = $this->produkModel->getAll(false,false,array("nama_produk ASC"));
			if ($data) {	
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
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$nama_produk = $this->input->post("nama_produk");
			// $tanggal_beli = $this->input->post("tanggal_beli");
			$gudang = $this->input->post("gudang");
			$kategori = $this->input->post("kategori");
			$unit = $this->input->post("unit");
			$vendor = $this->input->post("vendor");
			$harga_unit = $this->input->post("harga_unit");
			$saldo = $this->input->post("saldo");
			$saldo_minimal = $this->input->post("saldo_minimal");
			$keterangan = $this->input->post("keterangan");

			// form validate
			self::inputValidate();

			if ($this->form_validation->run() == true) {

				$data = array(
							"id"			=>	$id,
							// "tanggal_beli"	=>	$tanggal_beli,
							"nama_produk"	=>	$nama_produk,
							"gudang_id"		=>	$gudang,
							"kategori_id"	=>	$kategori,
							"unit_id"		=>	$unit,
							"vendor_id"		=>	$vendor,
							"harga_unit"	=>	$harga_unit,
							"saldo"			=>	$saldo,
							"harga_unit_total"	=>	($saldo * $harga_unit),
							"saldo_min"		=>	$saldo_minimal,
							"keterangan"	=>	$keterangan,
							"updated_at"	=>	date("Y-m-d H:i:s"),
						);

				$this->load->model('laporan/gudang_model',"laporanGudangModel");

				$dataLaporanGudang = array(
											"produk_id"	=>	$id,
											"gudang_id"	=>	$gudang,
											"masuk"		=>	$saldo,
											"harga_unit"=>	$harga_unit,
											"beli"		=>	($saldo * $harga_unit),
											"status"	=>	"saldo_awal",
											"vendor_id"	=>	$vendor,
											"updated_at"=>	date("Y-m-d H:i:s"),
									);

				$updateTransaction = $this->produkModel->transactionUpdate($data,$dataLaporanGudang);
				// $update = $this->produkModel->update($data);
				if ($updateTransaction) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di Update..");
					$this->response->data = $data;
				} else {
					$this->response->message = alertDanger("Data gagal di Update..");
				}
				
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
				$this->response->error = array(
									// "tanggal_beli"	=> form_error("tanggal_beli",'<span style="color:red;">','</span>'),
									"nama_produk"	=> form_error("nama_produk",'<span style="color:red;">','</span>'),
									"gudang"	=> form_error("gudang",'<span style="color:red;">','</span>'),
									"kategori"	=> form_error("kategori",'<span style="color:red;">','</span>'),
									"unit"	=> form_error("unit",'<span style="color:red;">','</span>'),
									"vendor"	=> form_error("vendor",'<span style="color:red;">','</span>'),
									"keterangan"	=> form_error("keterangan",'<span style="color:red;">','</span>'),
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
			$getData = $this->produkModel->getById($id);
			if($getData) {

				$this->load->model('laporan/gudang_model',"laporanGudangModel");

				$deleteTransaction = $this->produkModel->transactionDelete($id);
				// $delete = $this->produkModel->delete($id);
				if ($deleteTransaction) {
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

/* End of file Produk.php */
/* Location: ./application/controllers/master/Produk.php */