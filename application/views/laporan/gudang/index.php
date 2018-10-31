	<div class="card">
        <div class="card-body p-b-0">
            <h4 class="card-title">
            	Table Laporan Gudang 	
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-success btn-sm' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button>
            </h4>
            <hr>
            <!-- <h6 class="card-subtitle">Use default tab with class <code>customtab</code></h6> -->
            <!-- Nav tabs -->
            <ul class="nav nav-tabs customtab2" role="tablist">
                <li class="nav-item"> 
                	<a class="nav-link active" data-toggle="tab" href="#logAll" role="tab" aria-expanded="true">
                		Semua Transaksi
                	</a> 
                </li>
                <li class="nav-item">
                	<a class="nav-link" data-toggle="tab" href="#logMasuk" role="tab" aria-expanded="false">
                		Transaksi Masuk
                	</a> 
                </li>
                <li class="nav-item"> 
                	<a class="nav-link" data-toggle="tab" href="#logKeluar" role="tab" aria-expanded="false">
                		Transaksi Keluar
                	</a> 
                </li>
                <!-- <li class="nav-item"> 
                	<a class="nav-link" data-toggle="tab" href="#logProduk" role="tab" aria-expanded="false">
                		Log Produk
                	</a> 
                </li> -->
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="logAll" role="tabpanel" aria-expanded="true">
                	<!-- Filter searching -->
		        	<div class="card" style="margin-bottom: -10px; margin-top: 10px;">
	                    <div class="card-header">
	                        Filter Pencarian Semua Transaksi
	                        <div class="card-actions">
	                            <a class="" data-action="collapse"><i class="ti-plus"></i></a>
	                        </div>
	                    </div>
	                    <div class="card-body collapse" style="">
	                        <div class="row">
	                        	<div class="col-md-6">
	                        		<div class="form-group">
		                                <label for="">Tanggal dan Akhir :</label>
		                                <div class="input-daterange input-group date-range" id="">
		                                    <input type="text" class="form-control" data-column="0" id="tgl_awal_all" placeholder="Tanggal Awal">
		                                    <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
		                                    <input type="text" class="form-control" data-column="1" id="tgl_akhir_all" placeholder="Tanggal Akhir">
		                                </div>
		                            </div>
	                        	</div>
	                        	<div class="col-md-3">
	                        		<div class="form-group">
						                <label for="">Gudang</label>
						                <select id="gudang_cari_all" data-column="2" class="form-control select2" style="width: 100%">
						                </select>
						            </div>
	                        	</div>
	                        	<div class="col-md-3">
	                        		<div class="form-group">
						                <label for="">Kategori :</label>
						                <select id="kategori_cari_all" data-column="3" class="form-control select2" style="width: 100%">
						                </select>
						            </div>
	                        	</div>
	                        </div>
	                    </div>
	                </div>
		        	<!-- End filter searching -->
                    <div class="p-10 table-responsive">
                        <table id="tblLaporanGudang" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
		                    <thead class="thead-success">
		                        <tr>
		                            <th>No</th>
		                            <th>Tanggal</th>
		                            <th>Gudang</th>
		                            <th>Kode Produk</th>
		                            <th>Nama Produk</th>
		                            <th>Kategori</th>
		                            <th>Unit</th>
		                            <th>Harga Unit</th>
		                            <th>Masuk</th>
		                            <th>Keluar</th>
		                            <th>Status</th>
		                            <th>Keterangan</th>
		                        </tr>
		                    </thead>
                        	
		                </table>
                    </div>
                </div>
                <div class="tab-pane" id="logMasuk" role="tabpanel" aria-expanded="false">
                	<!-- Filter searching -->
		        	<div class="card" style="margin-bottom: -10px; margin-top: 10px;">
	                    <div class="card-header">
	                        Filter Pencarian Transaksi Masuk
	                        <div class="card-actions">
	                            <a class="" data-action="collapse"><i class="ti-plus"></i></a>
	                        </div>
	                    </div>
	                    <div class="card-body collapse" style="">
	                        <div class="row">
	                        	<div class="col-md-6">
	                        		<div class="form-group">
		                                <label for="">Tanggal dan Akhir :</label>
		                                <div class="input-daterange input-group date-range" id="">
		                                    <input type="text" class="form-control" data-column="0" id="tgl_awal_masuk" placeholder="Tanggal Awal">
		                                    <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
		                                    <input type="text" class="form-control" data-column="1" id="tgl_akhir_masuk" placeholder="Tanggal Akhir">
		                                </div>
		                            </div>
	                        	</div>
	                        	<div class="col-md-3">
	                        		<div class="form-group">
						                <label for="">Gudang</label>
						                <select id="gudang_cari_masuk" data-column="2" class="form-control select2" style="width: 100%">
						                </select>
						            </div>
	                        	</div>
	                        	<div class="col-md-3">
	                        		<div class="form-group">
						                <label for="">Kategori :</label>
						                <select id="kategori_cari_masuk" data-column="3" class="form-control select2" style="width: 100%">
						                </select>
						            </div>
	                        	</div>
	                        </div>
	                    </div>
	                </div>
		        	<!-- End filter searching -->
                	<div class="p-10 table-responsive">
                        <table id="tblLaporanGudangMasuk" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
		                    <thead class="thead-green">
		                        <tr>
		                            <th>No</th>
		                            <th>Tanggal</th>
		                            <th>Gudang</th>
		                            <th>Vendor</th>
		                            <th>Kode Produk</th>
		                            <th>Nama Produk</th>
		                            <th>Kategori</th>
		                            <th>Unit</th>
		                            <th>Harga Unit</th>
		                            <th>Masuk</th>
		                            <th>Total Harga Beli</th>
		                            <th>Keterangan</th>
		                        </tr>
		                    </thead>
		                </table>
                    </div>
                </div>
                <div class="tab-pane" id="logKeluar" role="tabpanel" aria-expanded="false">
                	<!-- Filter searching -->
		        	<div class="card" style="margin-bottom: -10px; margin-top: 10px;">
	                    <div class="card-header">
	                        Filter Pencarian Transaksi Keluar
	                        <div class="card-actions">
	                            <a class="" data-action="collapse"><i class="ti-plus"></i></a>
	                        </div>
	                    </div>
	                    <div class="card-body collapse" style="">
	                        <div class="row">
	                        	<div class="col-md-6">
	                        		<div class="form-group">
		                                <label for="">Tanggal dan Akhir :</label>
		                                <div class="input-daterange input-group date-range" id="">
		                                    <input type="text" class="form-control" data-column="0" id="tgl_awal_keluar" placeholder="Tanggal Awal">
		                                    <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
		                                    <input type="text" class="form-control" data-column="1" id="tgl_akhir_keluar" placeholder="Tanggal Akhir">
		                                </div>
		                            </div>
	                        	</div>
	                        	<div class="col-md-3">
	                        		<div class="form-group">
						                <label for="">Gudang</label>
						                <select id="gudang_cari_keluar" data-column="2" class="form-control select2" style="width: 100%">
						                </select>
						            </div>
	                        	</div>
	                        	<div class="col-md-3">
	                        		<div class="form-group">
						                <label for="">Kategori :</label>
						                <select id="kategori_cari_keluar" data-column="3" class="form-control select2" style="width: 100%">
						                </select>
						            </div>
	                        	</div>
	                        </div>
	                    </div>
	                </div>
		        	<!-- End filter searching -->
                	<div class="p-10 table-responsive">
                        <table id="tblLaporanGudangKeluar" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
		                    <thead class="thead-maroon">
		                        <tr>
		                            <th>No</th>
		                            <th>Tanggal</th>
		                            <th>Gudang</th>
		                            <th>Armada</th>
		                            <th>Kode Produk</th>
		                            <th>Nama Produk</th>
		                            <th>Kategori</th>
		                            <th>Unit</th>
		                            <th>Harga Unit</th>
		                            <th>Keluar</th>
		                            <th>Total Harga Keluar</th>
		                            <th>Keterangan</th>
		                        </tr>
		                    </thead>
		                </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php assets_script_laporan("gudang.js"); ?>

<!-- datatable rekap produk -->
<?php $this->load->view('master/produk/rekap_produk'); ?>
<?php assets_script_master("produk_rekap.js"); ?>

<!-- datatable rekap kategori produk -->
<?php $this->load->view('master/produkkategori/rekap_kategori'); ?>
<?php assets_script_master("produk_kategori_rekap.js"); ?>

<!-- datatable rekap gudang produk -->
<?php $this->load->view('master/gudang/rekap_gudang'); ?> 
<?php assets_script_master("gudang_rekap.js"); ?>   

<!-- datatable rekap vendor produk -->
<?php $this->load->view('master/vendor/rekap_vendor'); ?>
<?php assets_script_master("vendor_rekap.js"); ?>
    