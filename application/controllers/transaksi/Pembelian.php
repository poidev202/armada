<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('transaksi/pembelian_model',"pembelianModel");
		parent::checkUserRoleKasir(); // check role atau level function
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function

		parent::headerTitle("Transaksi Pembelian","Transaksi","Pembelian");

		$breadcrumbs = array(
								"Transaksi"	=> 	site_url('transaksi/pembelian'),
								"Pembelian"	=>	"",
							);

		parent::breadcrumbs($breadcrumbs);

		parent::viewTransaksi();
	}

	public function arrayTest()
	{
		$data1 = array("id"=>1,"nama"=>"bambang");
		$data2 = array(
						array("id"=>2,"nama"=>"bambang"), // array normal
						"group_start", // status group_start and or_group_start
						array(
								"or_group_start",
								array("id"=>3,"data"=>"ada"),
							),
					);

		$data3 = array(
						"id" => 'S_id',
						"age" => 'S_age',
						// array("id" => 4, 'nama'=>"gomblo"),
						"group_start" => array(
												"id_start"=>1,
												"jeneng"=>"kulo",
												"group_start" => array("id_start_dalam"=>1,"jeneng_dalam"=>"apa juga"),
											),
						// "or_group_start" => array("id"=>2,"jeneng"=>"siapa"),
					);
		// echo json_encode($data1);
		// echo json_encode($data2);
		var_dump($data3);
	}

	public function ajax_list()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {

			$requestData = $_REQUEST;
			$tanggalAwal = $requestData['columns'][0]['search']['value'];
			$tanggalAkhir = $requestData['columns'][1]['search']['value'];
			$gudang = $requestData['columns'][2]['search']['value'];
			$kategori = $requestData['columns'][3]['search']['value'];

			$select = array("transaksi_pembelian.*","master_produk.kode","master_produk.nama_produk","master_produk.kategori_id","master_produk_kategori.kategori","master_produk_unit.unit","master_vendor.nama_vendor","master_gudang.nama_gudang","laporan_account_kas.kas_id","master_kas.nama_kas");

			$columns = array(null,null,'tanggal_beli','kode','nama_produk','nama_gudang','nama_vendor','kategori','unit','harga_beli_unit','jumlah','harga_beli_total','nama_kas');

			$where = array(
							"data" => array(),
							"tanggal" => null,
						);

			$search = array('kode','nama_produk','nama_vendor','unit','harga_beli_unit','jumlah','harga_beli_total','nama_kas');

			if (!empty($tanggalAwal) && !empty($tanggalAkhir)) {
				$where["tanggal"] = array("tanggal_beli >=" => $tanggalAwal, "tanggal_beli <=" => $tanggalAkhir);
			} else {
				$search[] = "tanggal_beli";
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

			$join = array(
							array("master_produk","master_produk.id = transaksi_pembelian.produk_id","LEFT"),
							array("master_vendor","master_vendor.id = master_produk.vendor_id","LEFT"),
							array("master_produk_kategori","master_produk_kategori.id = master_produk.kategori_id","LEFT"),
							array("master_produk_unit","master_produk_unit.id = master_produk.unit_id","LEFT"),
							array("master_gudang","master_gudang.id = transaksi_pembelian.gudang_id","LEFT"),
							array("laporan_account_kas","laporan_account_kas.pembelian_id = transaksi_pembelian.id","LEFT"),
							array("master_kas","master_kas.id = laporan_account_kas.kas_id","LEFT"),
						);

			$result = $this->pembelianModel->findDataTablePembelian($where,$select,$columns,$search,$join);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";

				// $item->tanggal_beli = date_ind("d M Y", $item->tanggal_beli);

				$item->harga_beli_unit = "Rp.".number_format($item->harga_beli_unit,0,',','.');
				$item->harga_beli_total = "Rp.".number_format($item->harga_beli_total,0,',','.');

				$item->kode = '<a href="javasript:void();" title="Datatable rekap produk" onclick="rekapProduk('.$item->produk_id.')">'.$item->kode.'</a>';
				$item->nama_produk = '<a href="javasript:void();" title="Datatable rekap produk" onclick="rekapProduk('.$item->produk_id.')">'.$item->nama_produk.'</a>';
				$item->kategori = '<a href="javasript:void();" title="Datatable rekap kategori produk" onclick="rekapKategoriProduk('.$item->kategori_id.')">'.$item->kategori.'</a>';
				$item->nama_gudang = '<a href="javasript:void();" title="Datatable rekap gudang produk" onclick="rekapGudangProduk('.$item->gudang_id.')">'.$item->nama_gudang.'</a>';
				$item->nama_vendor = '<a href="javasript:void();" title="Datatable rekap nama vendor produk" onclick="rekapVendorProduk('.$item->vendor_id.')">'.$item->nama_vendor.'</a>';

				$btnAction = '<button type="button" onclick="btnDetail('.$item->id.')" class="btn btn btn-outline-info btn-xs m-b-10" title="Detail"><i class="fa fa-info-circle"></i> </button> '; // detail
				// $btnAction .= '<button type="button" onclick="btnEdit('.$item->id.')" class="btn btn btn-outline-warning btn-xs m-b-10" title="Edit"><i class="fa fa-pencil-square-o"></i> </button> '; // update
				$btnAction .='<button type="button" onclick="btnDelete('.$item->id.')" class="btn btn-outline-danger btn-xs m-b-10" title="Hapus"><i class="fa fa-trash-o"></i> </button>'; // delete
				
				$item->nama_kas = '<a href="javasript:void();" title="Datatable rekap account kas" onclick="rekapAccountKas('.$item->kas_id.')">'.$item->nama_kas.'</a>';// rekap saldo account kas

				$item->button_action = $btnAction;

				$data[] = $item;
			}
			return $this->pembelianModel->findDataTableOutputPembelian($data,$where,$select,$search,$join);
		}
		parent::json();
	}

	public function inputValidate()
	{
		$this->form_validation->set_rules("nama_produk","Nama Produk","trim|required");
		$this->form_validation->set_rules("tanggal_beli","Tanggal Beli","trim|required");
		$this->form_validation->set_rules('gudang', 'Gudang', 'trim|required');
		$this->form_validation->set_rules("vendor","Vendor","trim|required");
		$this->form_validation->set_rules("harga_unit","Harga Beli Unit","trim|required");
		$this->form_validation->set_rules("jumlah","Jumlah","trim|required");
		$this->form_validation->set_rules("keterangan","Keterangan","trim");
	}

	public function inputForm()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$nama_produk = $this->input->post("nama_produk");
			$tanggal_beli = $this->input->post("tanggal_beli");
			$gudang = $this->input->post("gudang");
			$vendor = $this->input->post("vendor");
			$harga_unit = $this->input->post("harga_unit");
			$jumlah = $this->input->post("jumlah");
			$keterangan = $this->input->post("keterangan");

			// form validate
			self::inputValidate();

			if ($this->form_validation->run() == true) {
				$this->response->status = true;
				$this->response->message = spanRed("Data pembelian yang di <b><u>Input</u></b> tidak bisa di edit/update lagi.<br>Pastikan anda menginput dengan benar.!");
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
				$this->response->error = array(
									"tanggal_beli"	=> form_error("tanggal_beli",'<span style="color:red;">','</span>'),
									"nama_produk"	=> form_error("nama_produk",'<span style="color:red;">','</span>'),
									"gudang"	=> form_error("gudang",'<span style="color:red;">','</span>'),
									"vendor"	=> form_error("vendor",'<span style="color:red;">','</span>'),
									"harga_unit"	=> form_error("harga_unit",'<span style="color:red;">','</span>'),
									"jumlah"	=> form_error("jumlah",'<span style="color:red;">','</span>'),
									"keterangan"	=> form_error("keterangan",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function add()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$nama_produk = $this->input->post("nama_produk");
			$tanggal_beli = $this->input->post("tanggal_beli");
			$gudang = $this->input->post("gudang");
			$vendor = $this->input->post("vendor");
			$harga_unit = $this->input->post("harga_unit");
			$jumlah = $this->input->post("jumlah");
			$kas_id = $this->input->post("account_kas");
			$keterangan = $this->input->post("keterangan");

			// form validate
			self::inputValidate();

			if ($this->form_validation->run() == true) {

				$data = array(
							"tanggal_beli"	=>	$tanggal_beli,
							"produk_id"		=>	$nama_produk,
							"gudang_id"		=>	$gudang,
							"vendor_id"		=>	$vendor,
							"harga_beli_unit"	=>	$harga_unit,
							"jumlah"		=>	$jumlah,
							"harga_beli_total"	=>	($harga_unit * $jumlah),
							"keterangan"	=>	$keterangan
						);

				$where = array("transaksi_pembelian.tanggal_beli" => $tanggal_beli,"transaksi_pembelian.produk_id" => $nama_produk,"transaksi_pembelian.gudang_id"=>$gudang);
				$select = array("tanggal_beli","master_produk.nama_produk","master_gudang.nama_gudang");
				$join = array(
								array("master_produk","master_produk.id = transaksi_pembelian.produk_id","LEFT"),
								array("master_gudang","master_gudang.id = transaksi_pembelian.gudang_id","LEFT"),
							);
				$checkTglProduk = $this->pembelianModel->getByWhere($where,$select,$join);
				if ($checkTglProduk) {
					$this->response->error = array("nama_produk" => spanRed("Tanggal Beli <b><u>".$tanggal_beli."</u></b> , Nama produk <b><u>".$checkTglProduk->nama_produk."</u></b> dan Gudang <b><u>".$checkTglProduk->nama_gudang."</u></b> yang akan anda input sudah ada."));
				} else {
					// $this->load->model('laporan/gudang_model',"laporanGudangModel");
					$this->load->model('master/vendor_model',"vendorModel");

					$dataVendor = $this->vendorModel->getById($vendor);
					$ketLaporan = $dataVendor == true ? "Masuk dari ".$dataVendor->nama_vendor : "";

					$dataLaporanGudang = array(
												"gudang_id"	=>	$gudang,
												"produk_id"	=>	$nama_produk,
												"tanggal"	=>	$tanggal_beli,
												"keterangan"=>	$ketLaporan,
												"masuk"		=>	$jumlah,
												"harga_unit"=>	$harga_unit,
												"beli"		=>	($jumlah * $harga_unit),
												"status"	=>	"masuk",
												"vendor_id"	=>	$vendor,
										);
					$dataLpKas = array(
										"tanggal"	=>	$tanggal_beli,
										"keluar"	=>	($jumlah * $harga_unit),
										"status"	=>	"keluar",
										"info_input"=>	"pembelian",
										"kas_id"	=>	$kas_id,
										"keterangan"=>	$keterangan,
									);

					$insertTransaction = $this->pembelianModel->transactionInsert($dataLaporanGudang,$data,$dataLpKas);
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
				$this->response->error = array(
									"tanggal_beli"	=> form_error("tanggal_beli",'<span style="color:red;">','</span>'),
									"nama_produk"	=> form_error("nama_produk",'<span style="color:red;">','</span>'),
									"gudang"	=> form_error("gudang",'<span style="color:red;">','</span>'),
									"vendor"	=> form_error("vendor",'<span style="color:red;">','</span>'),
									"harga_unit"	=> form_error("harga_unit",'<span style="color:red;">','</span>'),
									"jumlah"	=> form_error("jumlah",'<span style="color:red;">','</span>'),
									"keterangan"	=> form_error("keterangan",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function getId($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$select = array("transaksi_pembelian.*","master_produk.kode","master_produk.nama_produk","master_produk.harga_unit","master_produk_kategori.kategori","master_produk_unit.unit","master_vendor.nama_vendor","master_gudang.nama_gudang","master_kas.nama_kas");

			$join = array(
							array("master_produk","master_produk.id = transaksi_pembelian.produk_id","LEFT"),
							array("master_produk_kategori","master_produk_kategori.id = master_produk.kategori_id","LEFT"),
							array("master_produk_unit","master_produk_unit.id = master_produk.unit_id","LEFT"),
							array("master_vendor","master_vendor.id = master_produk.vendor_id","LEFT"),
							array("master_gudang","master_gudang.id = transaksi_pembelian.gudang_id","LEFT"),
							array("laporan_account_kas","laporan_account_kas.pembelian_id = transaksi_pembelian.id","LEFT"),
							array("master_kas","master_kas.id = laporan_account_kas.kas_id","LEFT"),
						);
			$data = $this->pembelianModel->getByWhere(array("transaksi_pembelian.id"=>$id),$select,$join);
			if ($data) {
				$data->tanggal_beli_indo = date_ind("d M Y", $data->tanggal_beli);

				$data->harga_beli_unit_rp = "Rp.".number_format($data->harga_beli_unit,0,',','.');
				$data->harga_unit_rp = "Rp.".number_format($data->harga_unit,0,',','.');
				$data->harga_beli_total_rp = "Rp.".number_format($data->harga_beli_total,0,',','.');

				$this->response->status = true;
				$this->response->message = "data get By Id";
				$this->response->data = $data;
			} else {
				$this->response->message = alertDanger("Data tidak ada.");
			}
		}
		parent::json();
	}

	/*public function getAll()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			
			$data = $this->pembelianModel->getAll(false,false,array("nama_produk ASC"));
			if ($data) {	
				$this->response->status = true;
				$this->response->message = "data get By Id";
				$this->response->data = $data;
			} else {
				$this->response->message = alertDanger("Data tidak ada.");
			}
		}
		parent::json();
	}*/

	/*public function update($id)
	{
		parent::checkLoginUser(); // otoritas authentic function
		if ($this->isPost()) {
			$nama_produk = $this->input->post("nama_produk");
			$tanggal_beli = $this->input->post("tanggal_beli");
			$gudang = $this->input->post("gudang");
			$vendor = $this->input->post("vendor");
			$harga_unit = $this->input->post("harga_unit");
			$jumlah = $this->input->post("jumlah");
			$keterangan = $this->input->post("keterangan");

			// form validate
			self::inputValidate();

			if ($this->form_validation->run() == true) {

				$data = array(
							"id"			=>	$id,
							"tanggal_beli"	=>	$tanggal_beli,
							"produk_id"		=>	$nama_produk,
							"gudang_id"		=>	$gudang,
							"vendor_id"		=>	$vendor,
							"harga_beli_unit"	=>	$harga_unit,
							"jumlah"		=>	$jumlah,
							"harga_beli_total"	=>	($harga_unit * $jumlah),
							"keterangan"	=>	$keterangan
						);

				
				// $this->load->model('laporan/gudang_model',"laporanGudangModel");
				$this->load->model('master/vendor_model',"vendorModel");

				$dataVendor = $this->vendorModel->getById($vendor);
				$ketLaporan = $dataVendor == true ? "Masuk dari ".$dataVendor->nama_vendor : "";

				$dataPembelian = $this->pembelianModel->getById($id);

				$dataLaporanGudang = array(
											"id"		=>	$dataPembelian->laporan_gudang_id,
											"gudang_id"	=>	$gudang,
											"produk_id"	=>	$nama_produk,
											"tanggal"	=>	$tanggal_beli,
											"keterangan"=>	$ketLaporan,
											"masuk"		=>	$jumlah,
											"harga_unit"=>	$harga_unit,
											"beli"		=>	($jumlah * $harga_unit),
											"status"	=>	"masuk",
											"vendor_id"	=>	$vendor,
									);

				$updateTransaction = $this->pembelianModel->transactionUpdate($data,$dataLaporanGudang);
				if ($updateTransaction) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di update..");
					$this->response->data = $data;
				} else {
					$this->response->message = alertDanger("Data gagal di update..");
				}
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
			}
		}
		parent::json();
	}*/

	public function delete($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$getData = $this->pembelianModel->getById($id);
			if($getData) {

				// $this->load->model('laporan/gudang_model',"laporanGudangModel");

				$deleteTransaction = $this->pembelianModel->transactionDelete($id,$getData->laporan_gudang_id);
				// $delete = $this->pembelianModel->delete($id);
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

/* End of file Pembelian.php */
/* Location: ./application/controllers/transaksi/Pembelian.php */