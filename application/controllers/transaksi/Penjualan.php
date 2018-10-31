<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('transaksi/Penjualan_model',"penjualanModel");
		parent::checkUserRoleKasir(); // check role atau level function
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function

		parent::headerTitle("Transaksi Penjualan","Transaksi","Penjualan");

		$breadcrumbs = array(
								"Transaksi"	=> 	site_url('transaksi/penjualan'),
								"Penjualan"	=>	"",
							);

		parent::breadcrumbs($breadcrumbs);

		parent::viewTransaksi();
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

			$select = array("transaksi_penjualan.*","master_produk.kode","master_produk.nama_produk","master_produk.kategori_id","master_produk_kategori.kategori","master_produk_unit.unit","master_armada.nama","master_armada.photo","master_gudang.nama_gudang","laporan_account_kas.kas_id","master_kas.nama_kas");

			$columns = array(null,null,'tanggal_jual','kode','nama_produk','nama','nama_gudang','kategori','unit','harga_jual_unit','jumlah','harga_jual_total','nama_kas');

			$search = array('transaksi_penjualan.tanggal_jual','kode','nama_produk','nama','unit','jumlah','harga_jual_unit','harga_jual_total','nama_kas');

			$where = array(
							"data" => array(),
							"tanggal" => null,
						);
			if (!empty($tanggalAwal) && !empty($tanggalAkhir)) {
				$where["tanggal"] = array("tanggal_jual >=" => $tanggalAwal, "tanggal_jual <=" => $tanggalAkhir);
			} else {
				$search[] = "tanggal_jual";
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

			$join = array(
							array("master_produk","master_produk.id = transaksi_penjualan.produk_id","LEFT"),
							array("master_produk_kategori","master_produk_kategori.id = master_produk.kategori_id","LEFT"),
							array("master_produk_unit","master_produk_unit.id = master_produk.unit_id","LEFT"),
							array("master_armada","master_armada.id = transaksi_penjualan.armada_id","LEFT"),
							array("master_gudang","master_gudang.id = transaksi_penjualan.gudang_id","LEFT"),
							array("laporan_account_kas","laporan_account_kas.penjualan_id = transaksi_penjualan.id","LEFT"),
							array("master_kas","master_kas.id = laporan_account_kas.kas_id","LEFT"),
						);

			$result = $this->penjualanModel->findDataTablePenjualan($where,$select,$columns,$search,$join);
			$data = array();
			foreach ($result as $item) {
				
				$item->no = "<b style='color:black;'>".$item->no."</b>";

				// $item->tanggal_jual = date_ind("d M Y", $item->tanggal_jual);

				$item->harga_jual_unit = "Rp.".number_format($item->harga_jual_unit,0,',','.');
				$item->harga_jual_total = "Rp.".number_format($item->harga_jual_total,0,',','.');

				$item->kode = '<a href="javasript:void();" title="Datatable rekap produk" onclick="rekapProduk('.$item->produk_id.')">'.$item->kode.'</a>';
				$item->nama_produk = '<a href="javasript:void();" title="Datatable rekap produk" onclick="rekapProduk('.$item->produk_id.')">'.$item->nama_produk.'</a>';
				$item->kategori = '<a href="javasript:void();" title="Datatable rekap kategori produk" onclick="rekapKategoriProduk('.$item->kategori_id.')">'.$item->kategori.'</a>';
				$item->nama_gudang = '<a href="javasript:void();" title="Datatable rekap gudang produk" onclick="rekapGudangProduk('.$item->gudang_id.')">'.$item->nama_gudang.'</a>';

				$btnAction = '<button type="button" onclick="btnDetail('.$item->id.')" class="btn btn btn-outline-info btn-xs m-b-10" title="Detail"><i class="fa fa-info-circle"></i> </button> '; // detail
				// $btnAction .= '<button type="button" onclick="btnEdit('.$item->id.')" class="btn btn btn-outline-warning btn-xs m-b-10" title="Edit"><i class="fa fa-pencil-square-o"></i> </button> '; // update
				$btnAction .='<button type="button" onclick="btnDelete('.$item->id.')" class="btn btn-outline-danger btn-xs m-b-10" title="Hapus"><i class="fa fa-trash-o"></i> </button>'; // delete
				
				$item->nama_kas = '<a href="javasript:void();" title="Datatable rekap account kas" onclick="rekapAccountKas('.$item->kas_id.')">'.$item->nama_kas.'</a>';// rekap saldo account kas

				$item->button_action = $btnAction;

				$data[] = $item;
			}
			return $this->penjualanModel->findDataTableOutputPenjualan($data,$where,$select,$search,$join);
		}
		parent::json();
	}

	public function inputValidate()
	{
		$this->form_validation->set_rules("nama_produk","Nama Produk","trim|required");
		$this->form_validation->set_rules('nama_armada', 'Nama Armada', 'trim|required');
		$this->form_validation->set_rules("tanggal_jual","Tanggal Jual","trim|required");
		$this->form_validation->set_rules("harga_jual","Harga Jual Unit","trim|required");
		$this->form_validation->set_rules("jumlah","Jumlah","trim|required");
		$this->form_validation->set_rules("keterangan","Keterangan","trim");
	}

	public function inputForm()
	{
		parent::checkLoginUser(); // otoritas authentic function
		if ($this->isPost()) {
			// form validate
			self::inputValidate();
			$this->form_validation->set_rules('gudang', 'Gudang', 'trim|required');
			$this->form_validation->set_rules('tgl_harga_beli', 'Harga Beli Unit', 'trim|required');
			if ($this->form_validation->run() == true) {
				$this->response->status = true;
				$this->response->message = spanRed("Data penjualan/pemakaian yang di <b><u>Input</u></b> tidak bisa di edit/update lagi.<br>Pastikan anda menginput dengan benar.!");
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
			}
		}
		parent::json();
	}

	public function add()
	{
		parent::checkLoginUser(); // otoritas authentic function
		if ($this->isPost()) {
			// form validate
			self::inputValidate();
			$this->form_validation->set_rules('gudang', 'Gudang', 'trim|required');
			$this->form_validation->set_rules('tgl_harga_beli', 'Harga Beli Unit', 'trim|required');

			$nama_produk = $this->input->post("nama_produk");
			$nama_armada = $this->input->post("nama_armada");
			$gudang = $this->input->post("gudang");
			$tanggal_jual = $this->input->post("tanggal_jual");
			$harga_jual = $this->input->post("harga_jual");
			$jumlah = $this->input->post("jumlah");
			$kas_id = $this->input->post("account_kas");
			$keterangan = $this->input->post("keterangan");
			$tgl_harga_beli = $this->input->post("tgl_harga_beli");
			$tgl_harga_beli = explode("||", $tgl_harga_beli);

			$saldoSisaHargaTanggal = $this->input->post('saldoSisaHargaTanggal');

			if ($this->form_validation->run() == true) {

				$data = array(
							"produk_id"		=>	$nama_produk,
							"armada_id"		=>	$nama_armada,
							"gudang_id"		=>	$gudang,
							"tanggal_beli"	=>	$tgl_harga_beli[0],
							"harga_unit_beli"	=>	$tgl_harga_beli[1],
							"tanggal_jual"	=>	$tanggal_jual,
							"harga_jual_unit"	=>	$harga_jual,
							"jumlah"		=>	$jumlah,
							"harga_jual_total"	=>	($jumlah * $harga_jual),
							"keterangan"	=>	$keterangan
						);

				$where = array(
								"tanggal_jual" 	=> 	$tanggal_jual,
								"produk_id" 	=> 	$nama_produk,
								"armada_id"		=>	$nama_armada,
							);
				$select = array("transaksi_penjualan.tanggal_jual","master_produk.nama_produk","master_armada.nama");
				$join = array(
								array("master_produk","master_produk.id = transaksi_penjualan.produk_id","LEFT"),
								array("master_armada","master_armada.id = transaksi_penjualan.armada_id","LEFT"),
							);
				$checkTglProduk = $this->penjualanModel->getByWhere($where,$select,$join);
				if ($checkTglProduk) {
					$this->response->error = array("nama_produk" => spanRed("Tanggal Jual <u>".$tanggal_jual."</u>, Nama produk <u>".$checkTglProduk->nama_produk."</u> dan Armada <u>".$checkTglProduk->nama."</u> sudah ada."));
				} else {
					$this->load->model('laporan/gudang_model',"laporanGudangModel");
					$this->load->model('master/armada_model',"armadaModel");

					$dataArmada = $this->armadaModel->getById($nama_armada);
					$ketLaporan = $dataArmada == true ? "Pemakaian Untuk Armada, ".$dataArmada->nama : "";

					$dataLaporanGudang = array(
												"gudang_id"	=>	$gudang,
												"produk_id"	=>	$nama_produk,
												"armada_id"	=>	$nama_armada,
												"tanggal"	=>	$tanggal_jual,
												"keterangan"=>	$ketLaporan,
												"keluar"	=>	$jumlah,
												"harga_unit"=>	$harga_jual,
												"jual"		=>	($jumlah * $harga_jual),
												"status"	=>	"keluar",
										);
					$dataLpKas = array(
										"tanggal"	=>	$tanggal_jual,
										"keluar"	=>	($jumlah * $harga_jual),
										"status"	=>	"keluar",
										"info_input"=>	"penjualan",
										"kas_id"	=>	$kas_id,
										"keterangan"=>	$keterangan,
									);

					if ($saldoSisaHargaTanggal < $jumlah) {
						$this->response->message = alertDanger("Jumlah, Harga jual unit tidak boleh lebih besar dari sisa saldo harga beli unit atau minus.");
					} else {
						$insertTransaction = $this->penjualanModel->transactionInsert($dataLaporanGudang,$data,$dataLpKas);
						if ($insertTransaction) {
							$this->response->status = true;
							$this->response->message = alertSuccess("Data berhasil di tambah..");
							$this->response->data = $data;
						} else {
							$this->response->message = alertDanger("Data gagal di tambah..");
						}
					}
				}
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
			}
		}
		parent::json();
	}

	public function getId($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$select = array("transaksi_penjualan.*","master_produk.kode","master_produk.nama_produk","master_produk_kategori.kategori","master_produk_unit.unit","master_armada.nama","master_gudang.nama_gudang","master_kas.nama_kas");

			$join = array(
							array("master_produk","master_produk.id = transaksi_penjualan.produk_id","LEFT"),
							array("master_produk_kategori","master_produk_kategori.id = master_produk.kategori_id","LEFT"),
							array("master_produk_unit","master_produk_unit.id = master_produk.unit_id","LEFT"),
							array("master_armada","master_armada.id = transaksi_penjualan.armada_id","LEFT"),
							array("master_gudang","master_gudang.id = transaksi_penjualan.gudang_id","LEFT"),
							array("laporan_account_kas","laporan_account_kas.penjualan_id = transaksi_penjualan.id","LEFT"),
							array("master_kas","master_kas.id = laporan_account_kas.kas_id","LEFT"),
						);
			$data = $this->penjualanModel->getByWhere(array("transaksi_penjualan.id"=>$id),$select,$join);
			if ($data) {
				$data->tanggal_jual_indo = date_ind("d M Y", $data->tanggal_jual);
				$data->harga_jual_unit_rp = "Rp.".number_format($data->harga_jual_unit,0,',','.');
				$data->harga_jual_total_rp = "Rp.".number_format($data->harga_jual_total,0,',','.');
				$data->tanggal_beli_indo = date_ind("d M Y", $data->tanggal_beli);
				$data->harga_unit_beli_rp = "Rp.".number_format($data->harga_unit_beli,0,',','.');

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
		if ($this->isPost()) {
			$nama_produk = $this->input->post("nama_produk");
			$nama_armada = $this->input->post("nama_armada");
			$gudang = $this->input->post("gudang");
			$tanggal_jual = $this->input->post("tanggal_jual");
			$harga_jual = $this->input->post("harga_jual");
			$jumlah = $this->input->post("jumlah");
			$keterangan = $this->input->post("keterangan");

			// form validate
			self::inputValidate();
			$this->form_validation->set_rules('gudang', 'Gudang', 'trim|required');

			if ($this->form_validation->run() == true) {

				$this->load->model('laporan/gudang_model',"laporanGudangModel");
				$this->load->model('master/armada_model',"armadaModel");

				$data = array(
							"id"			=>	$id,
							"produk_id"		=>	$nama_produk,
							"armada_id"		=>	$nama_armada,
							// "gudang_id"		=>	$gudang,
							"tanggal_jual"	=>	$tanggal_jual,
							"harga_jual_unit"	=>	$harga_jual,
							"jumlah"		=>	$jumlah,
							"harga_jual_total"	=>	($jumlah * $harga_jual),
							"keterangan"	=>	$keterangan
						);

				$where = array(
								"produk_id" 	=> 	$nama_produk,
								"gudang_id"		=>	$gudang,
							);
				$checkGudangProduk = $this->laporanGudangModel->getByWhere($where);
				if (!$checkGudangProduk) {
					$this->response->error = array("nama_produk" => spanRed("Gudang yang anda pilih tidak memiliki produk yang anda pilih.<br> Silahkan pilih gudang yang lain atau pilih produk yang lain.!"));
				} else {
					$data["gudang_id"] = $gudang;

					$dataArmada = $this->armadaModel->getById($nama_armada);
					$ketLaporan = $dataArmada == true ? "Pemakaian Untuk Armada, ".$dataArmada->nama : "";


					$dataPenjualan = $this->penjualanModel->getById($id);

					$dataLaporanGudang = array(
												"id"		=>	$dataPenjualan->laporan_gudang_id,
												"gudang_id"	=>	$gudang,
												"produk_id"	=>	$nama_produk,
												"armada_id"	=>	$nama_armada,
												"tanggal"	=>	$tanggal_jual,
												"keterangan"=>	$ketLaporan,
												"keluar"	=>	$jumlah,
												"harga_unit"=>	$harga_jual,
												"jual"		=>	($jumlah * $harga_jual),
												"status"	=>	"keluar",
										);

					$updateTransaction = $this->penjualanModel->transactionUpdate($data,$dataLaporanGudang);
					if ($updateTransaction) {
						$this->response->status = true;
						$this->response->message = alertSuccess("Data berhasil di update..");
						$this->response->data = $data;
					} else {
						$this->response->message = alertDanger("Data gagal di update..");
					}
				}
			} else {
				$this->response->message = validation_errors('<span style="color:red;">', '</span><br>');
			}
		}
		parent::json();
	}

	public function delete($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$getData = $this->penjualanModel->getById($id);
			if($getData) {

				$this->load->model('laporan/gudang_model',"laporanGudangModel");

				$deleteTransaction = $this->penjualanModel->transactionDelete($id,$getData->laporan_gudang_id);
				// $delete = $this->penjualanModel->delete($id);
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

/* End of file Penjualan.php */
/* Location: ./application/controllers/transaksi/Penjualan.php */