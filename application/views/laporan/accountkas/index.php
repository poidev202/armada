<div class="card">
    <div class="card-body p-b-0">
        <h4 class="card-title">
        	Table Laporan Account Kas	
        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-success btn-sm' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button>
        </h4>
        <hr>
        <!-- <h6 class="card-subtitle">Use default tab with class <code>customtab</code></h6> -->
        <!-- Nav tabs -->
        <ul class="nav nav-tabs customtab2" role="tablist">
            <li class="nav-item"> 
            	<a class="nav-link active" data-toggle="tab" href="#logAll" role="tab" aria-expanded="true">
            		Semua Kas
            	</a> 
            </li>
            <li class="nav-item">
            	<a class="nav-link" data-toggle="tab" href="#logMasuk" role="tab" aria-expanded="false">
            		Kas Masuk
            	</a> 
            </li>
            <li class="nav-item"> 
            	<a class="nav-link" data-toggle="tab" href="#logKeluar" role="tab" aria-expanded="false">
            		Kas Keluar
            	</a> 
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="logAll" role="tabpanel" aria-expanded="true">
            	<!-- Filter searching -->
	        	<div class="card" style="margin-bottom: -10px; margin-top: 10px;">
                    <div class="card-header">
                        Filter Pencarian Semua Account Kas
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
                        </div>
                    </div>
                </div>
	        	<!-- End filter searching -->
                <div class="p-10 table-responsive">
                    <table id="tblLaporanKasAll" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
	                    <thead class="thead-dark">
	                        <tr>
	                            <th>No</th>
	                            <th>Tanggal</th>
	                            <th>Nama_Kas</th>
	                            <th>Masuk</th>
	                            <th>Keluar</th>
	                            <th>Status</th>
	                            <th>Info Input</th>
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
                        Filter Pencarian Kas Masuk
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
                        </div>
                    </div>
                </div>
	        	<!-- End filter searching -->
            	<div class="p-10 table-responsive">
                    <table id="tblLaporanKasMasuk" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
	                    <thead class="thead-primary">
	                        <tr>
	                            <th>No</th>
	                            <th>Tanggal</th>
	                            <th>Nama Kas</th>
	                            <th>Masuk</th>
	                            <th>Armada</th>
	                            <th>No Plat</th>
	                            <th>Tgl surat jalan</th>
	                            <th>Hari</th>
	                            <th>Jam</th>
	                            <th>Berangkat</th>
	                            <th>Tujuan</th>
	                            <th>Keterangan</th>
	                        </tr>
	                    </thead>
	                </table>
                </div>
            </div>
            <div class="tab-pane" id="logKeluar" role="tabpanel" aria-expanded="false">

            	<div class="card">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"> 
                            	<a class="nav-link active" data-toggle="tab" href="#pembelianTab" role="tab" aria-expanded="true">
                            		Transaksi Pembelian
                            	</a> 
                            </li>
                            <li class="nav-item"> 
                            	<a class="nav-link" data-toggle="tab" href="#penjualanTab" role="tab" aria-expanded="false">
                            		Transaksi Penjualan/Pengeluaran
                            	</a> 
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                        	<!-- Tab Pembelian -->
                            <div class="tab-pane active" id="pembelianTab" role="tabpanel" aria-expanded="true">
                                <!-- Filter searching -->
					        	<div class="card" style="margin-bottom: -10px; margin-top: 10px;">
				                    <div class="card-header">
				                        Filter Pencarian Kas Keluar
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
					                                    <input type="text" class="form-control" data-column="0" id="tgl_awal_keluar_pembelian" placeholder="Tanggal Awal">
					                                    <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
					                                    <input type="text" class="form-control" data-column="1" id="tgl_akhir_keluar_pembelian" placeholder="Tanggal Akhir">
					                                </div>
					                            </div>
				                        	</div>
				                        	<div class="col-md-3">
				                        		<div class="form-group">
									                <label for="">Gudang</label>
									                <select id="gudang_cari_keluar_pembelian" data-column="2" class="form-control select2" style="width: 100%">
									                </select>
									            </div>
				                        	</div>
				                        	<div class="col-md-3">
				                        		<div class="form-group">
									                <label for="">Kategori :</label>
									                <select id="kategori_cari_keluar_pembelian" data-column="3" class="form-control select2" style="width: 100%">
									                </select>
									            </div>
				                        	</div>
				                        </div>
				                    </div>
				                </div>
					        	<!-- End filter searching -->
				            	<div class="p-10 table-responsive">
				                    <table id="tblLaporanKasKeluarPembelian" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
					                    <thead class="thead-success">
					                        <tr>
					                            <th>No</th>
					                            <th>Tanggal</th>
					                            <th>Nama Kas</th>
					                            <th>Keluar</th>
					                            <th>Kode Produk</th>
					                            <th>Nama Produk</th>
					                            <th>Kategori</th>
					                            <th>Harga unit</th>
					                            <th>Jumlah</th>
					                            <th>Gudang</th>
					                            <th>Vendor</th>
					                            <th>Keterangan</th>
					                        </tr>
					                    </thead>
					                </table>
				                </div>
                            </div>
                            <!-- End Tab Pembelian -->

                            <!-- Tab Penjualan -->
                            <div class="tab-pane" id="penjualanTab" role="tabpanel" aria-expanded="false">
                            	<!-- Filter searching -->
					        	<div class="card" style="margin-bottom: -10px; margin-top: 10px;">
				                    <div class="card-header">
				                        Filter Pencarian Kas Keluar
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
					                                    <input type="text" class="form-control" data-column="0" id="tgl_awal_keluar_penjualan" placeholder="Tanggal Awal">
					                                    <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
					                                    <input type="text" class="form-control" data-column="1" id="tgl_akhir_keluar_penjualan" placeholder="Tanggal Akhir">
					                                </div>
					                            </div>
				                        	</div>
				                        	<div class="col-md-3">
				                        		<div class="form-group">
									                <label for="">Gudang</label>
									                <select id="gudang_cari_keluar_penjualan" data-column="2" class="form-control select2" style="width: 100%">
									                </select>
									            </div>
				                        	</div>
				                        	<div class="col-md-3">
				                        		<div class="form-group">
									                <label for="">Kategori :</label>
									                <select id="kategori_cari_keluar_penjualan" data-column="3" class="form-control select2" style="width: 100%">
									                </select>
									            </div>
				                        	</div>
				                        </div>
				                    </div>
				                </div>
					        	<!-- End filter searching -->
				            	<div class="p-10 table-responsive">
				                    <table id="tblLaporanKasKeluarPenjualan" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
					                    <thead class="thead-maroon">
					                        <tr>
					                            <th>No</th>
					                            <th>Tanggal</th>
					                            <th>Nama Kas</th>
					                            <th>Keluar</th>
					                            <th>Armada</th>
					                            <th>No Plat</th>
					                            <th>Kode Produk</th>
					                            <th>Nama Produk</th>
					                            <th>Kategori</th>
					                            <th>Harga unit</th>
					                            <th>Jumlah</th>
					                            <th>Gudang</th>
					                            <th>Keterangan</th>
					                        </tr>
					                    </thead>
					                </table>
				                </div>
                            </div>
                            <!-- End Tab Penjualan -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php assets_script_laporan("accountkas.js"); ?>

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
