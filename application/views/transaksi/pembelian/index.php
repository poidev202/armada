	
	<div id="dataTable">
		<div class="card">
	        <div class="card-body">
	        	<h4 class="card-title">Table Transaksi Pembelian</h4>
	        	<hr class="card-subtitle">

	        	<!-- Filter searching -->
	        	<div class="card" style="margin-bottom: inherit;">
                    <div class="card-header">
                        Filter Pencarian
                        <div class="card-actions">
                            <a class="" data-action="collapse"><i class="ti-plus"></i></a>
                        </div>
                    </div>
                    <div class="card-body collapse" style="">
                        <div class="row">
                        	<div class="col-md-6">
                        		<div class="form-group">
	                                <label for="">Tanggal Awal dan Akhir Beli :</label>
	                                <div class="input-daterange input-group date-range" id="">
	                                    <input type="text" class="form-control" data-column="0" name="tgl_awal_beli" id="tgl_awal_beli" placeholder="Tanggal Awal">
	                                    <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
	                                    <input type="text" class="form-control" data-column="1" name="tgl_akhir_beli" id="tgl_akhir_beli" placeholder="Tanggal Akhir">
	                                </div>
	                            </div>
                        	</div>
                        	<div class="col-md-3">
                        		<div class="form-group">
					                <label for="">Gudang</label>
					                <select id="gudang_cari" data-column="2" name="gudang_cari" class="form-control select2" style="width: 100%">
					                </select>
					            </div>
                        	</div>
                        	<div class="col-md-3">
                        		<div class="form-group">
					                <label for="">Kategori :</label>
					                <select id="kategori_cari" data-column="3" name="kategori_cari" class="form-control select2" style="width: 100%">
					                </select>
					            </div>
                        	</div>
                        </div>
                    </div>
                </div>
	        	<!-- End filter searching -->

	            <div class="table-responsive">
	                <table id="tblTransaksiPembelian" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
	                    <thead class="thead-green">
	                        <tr>
	                            <th>No</th>
	                            <th>Action</th>
	                            <th>Tanggal Beli</th>
	                            <th>Kode Produk</th>
	                            <th>Nama Produk</th>
	                            <th>Gudang</th>
	                            <th>Vendor</th>
	                            <th>Kategori</th>
	                            <th>Unit</th>
	                            <th>Harga Unit</th>
	                            <th>Jumlah</th>
	                            <th>Harga Total</th>
	                            <th>Account Kas</th>
	                        </tr>
	                    </thead>
	                </table>
	            </div>
	        </div>
	    </div>
	</div>

	<div id="formProses" style="display: none;">
		<div class="ribbon-wrapper card">
			<div class="ribbon ribbon-primary" id="ribbonTitle">
                <i id="iconForm" class='fa fa-plus'></i> <span id="titleForm">Empty title form</span>
            </div>
            <div class="ribbon ribbon-corner ribbon-right ribbon-danger">
            	<div class="card-actions pull-right">
                    <a class="btn-close close-form"><i class="ti-close"></i></a>
                </div>
            </div>
	        <div class="ribbon-content">
		        <div id="inputMessage"></div>
		    	<?php echo form_open("",array("id" => "formData","class" => "m-t-20")); ?>
		    		<div class="row">
		    			<div class="col-md-6">
				            <div class="form-group m-b-5 m-t-10 focused">
				                <label for="nama_produk">Nama Produk :</label>
						        <select id="nama_produk" name="nama_produk" class="form-control select2" style="width: 100%">
						        </select>
				                <span class="help-block"><small id="errorNamaProduk"></small></span>
				            </div>
				    		<div class="row">
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="">Kategori Produk</label>
				                		<input type="text" class="form-control" readonly id="kategori_produk">
						            </div>
				            	</div>
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="">Unit Produk</label>
				                		<input type="text" class="form-control" readonly id="unit_produk">
						            </div>
				            	</div>
				    		</div>
		            		<div class="form-group m-b-5 m-t-10" id="infoHargaPerUnit" style="display: none;">
		                		<div class="row">
		                			<div class="col-md-6">
		                				<label for="harga_terendah">Harga Terendah</label>
				                		<input type="text" class="form-control" readonly id="harga_terendah" title="">
		                			</div>
		                			<div class="col-md-6">
		                				<label for="">Harga Tetinggi</label>
				                		<input type="text" class="form-control" readonly id="harga_tertinggi" title="">
		                			</div>
		                		</div>
		                		<div class="row m-t-10">
		                			<div class="col-md-6">
		                				<label for="">Harga Rata-rata</label>
				                		<input type="text" class="form-control" readonly id="harga_rata2" title="">
		                			</div>
		                			<div class="col-md-6">
		                				<label for="">Harga Terakhir</label>
				                		<input type="text" class="form-control" readonly id="harga_terakhir" title="">
		                			</div>
		                		</div>
				            </div>

				    		<div class="row">
				            	<div class="col-md-4">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="">Tanggal Beli</label>
				                		<input type="text" class="form-control tanggal" name="tanggal_beli" id="tanggal_beli">
						                <span class="help-block"><small id="errorTanggalBeli"></small></span>
						            </div>
				            	</div>
				            	<div class="col-md-8">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="">Gudang</label>
						                <select id="gudang" name="gudang" class="form-control select2" style="width: 100%">
						                </select>
						                <span class="help-block"><small id="errorGudang"></small></span>
						            </div>
				            	</div>
				    		</div>
		    			</div>
		    			<div class="col-md-6">
				            <div class="form-group m-b-5 m-t-10">
				                <label for="vendor">Vendor :</label>
						        <select id="vendor" name="vendor" class="form-control select2" style="width: 100%">
						        </select>
				                <span class="help-block"><small id="errorVendor"></small></span>
				            </div>
				            <div class="row">
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label>Harga Beli Unit :</label>
				                		<input type="number" min="0" class="form-control" name="harga_unit" id="harga_unit">
				                        <span class="help-block"><small id="mata_uang_harga_unit"></small></span>
						            </div>
				            	</div>
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label>Jumlah :</label>
				                		<input type="number" min="0" class="form-control" name="jumlah" id="jumlah">
						                <span class="help-block"><small id="errorJumlah"></small></span>
						            </div>
				            	</div>
				            </div>
				            <div class="form-group m-b-5 m-t-10" id="infoTotalHargaBeli" style="display: none;">
				                <label>Total Harga Beli :</label>
				                <input type="text" id="totalHargaBeli" class="form-control" readonly>
				                <span class="help-block"><small>Harga Beli Unit (*) jumlah</small></span>
				            </div>
				            <div class="form-group m-b-5 m-t-10">
							    <label for="account_kas">Account Kas :</label>
                                <select id="account_kas" name="account_kas" class="form-control select2" style="width: 100%"></select>
							    <span class="help-block"><small id="errorAccountKas"></small></span>
		    				</div>
							<div class="form-group m-b-5 m-t-10">
				                <label for="keterangan">Keterangan :</label>
				                <textarea class="form-control" name="keterangan" id="keterangan" rows="3" ></textarea>
				                <span class="help-block"><small id="errorKeterangan"></small></span>
				            </div>
		    			</div>
		    		</div>
		    		
		            <hr>
		            <div class="form-group m-b-5 m-t-10">
		                <button type="button" id="btnSimpan" class="btn btn-outline-info"><i class="fa fa-save"></i> Simpan</button>
		                &nbsp;&nbsp;&nbsp;&nbsp;
		                <button type="button" class="btn btn-outline-danger close-form"><i class="fa fa-window-close"></i> Tutup</button>
		            </div>
				<?php echo form_close(); ?>
			</div>
	    </div>
	</div>

	<div id="detailPembelian" style="display: none;">
		<div class="ribbon-wrapper card">
			<div class="ribbon ribbon-success">
                <i id="iconForm" class='fa fa-info-circle'></i> <span>Detail Transaksi Pembelian</span>
            </div>
            <div class="ribbon ribbon-corner ribbon-right ribbon-danger">
            	<div class="card-actions pull-right">
                    <a class="btn-close close-form"><i class="ti-close"></i></a>
                </div>
            </div>
	        <div class="ribbon-content">
		        <div id="inputMessage"></div>
		    	<form class="m-t-20">
		    		<div class="row">
		    			<div class="col-md-6">
				            <div class="form-group m-b-5 m-t-8 focused">
				                <label for="nama_produk">Nama Produk :</label><br>
				                <span class="help-block"><small id="detailNamaProduk"></small></span>
				                <hr>
				            </div>
				            <div class="row">
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="">Kategori Produk</label><br>
						                <span class="help-block"><small id="detailKategori"></small></span>
						                <hr>
						            </div>
				            	</div>
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="">Unit Produk</label><br>
						                <span class="help-block"><small id="detailUnit"></small></span>
						                <hr>
						            </div>
				            	</div>
				    		</div>
		            		<div class="form-group m-b-5 m-t-10">
				                <label for="">Harga Unit</label><br>
						        <span class="help-block"><small id="detailHargaUnit"></small></span>
						        <hr>
				            </div>
				    		<div class="row">
				            	<div class="col-md-4">
				            		<div class="form-group m-b-5 m-t-8">
						                <label for="">Tanggal Beli</label><br>
						                <span class="help-block"><small id="detailTanggalBeli"></small></span>
						                <hr>
						            </div>
				            	</div>
				            	<div class="col-md-8">
				            		<div class="form-group m-b-5 m-t-8">
						                <label for="">Gudang</label><br>
						                <span class="help-block"><small id="detailGudang"></small></span>
						                <hr>
						            </div>
				            	</div>
				    		</div>
		    			</div>
		    			<div class="col-md-6">
				            <div class="form-group m-b-5 m-t-8">
				                <label for="vendor">Vendor :</label><br>
				                <span class="help-block"><small id="detailVendor"></small></span>
				                <hr>
				            </div>
				            <div class="row">
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label>Harga Beli Unit :</label><br>
				                        <span class="help-block"><small id="detailHargaBeliUnit"></small></span>
				                        <hr>
						            </div>
				            	</div>
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label>Jumlah :</label><br>
						                <span class="help-block"><small id="detailJumlah"></small></span>
						                <hr>
						            </div>
				            	</div>
				            </div>
				            <div class="form-group m-b-5 m-t-10">
				                <label>Total Harga Beli :</label>
								<span class="help-block"><small>Harga Beli Unit (*) jumlah</small></span>
				                <br>
				                <span class="help-block"><small id="detailTotalHargaBeli"></small></span>
				                <hr>
				            </div>
							<div class="form-group m-b-5 m-t-10">
				                <label for="">Account Kas :</label><br>
				                <span class="help-block"><small id="detailAccountKas"></small></span>
				                <hr>
				            </div>
							<div class="form-group m-b-5 m-t-10">
				                <label for="keterangan">Keterangan :</label><br>
				                <span class="help-block"><small id="detailKeterangan"></small></span>
				                <hr>
				            </div>
		    			</div>
		    		</div>
		    		
		            <hr>
		            <div class="form-group m-b-5 m-t-10">
		                <button type="button" class="btn btn-outline-danger close-form"><i class="fa fa-window-close"></i> Tutup</button>
		            </div>
		        </form>
			</div>
	    </div>
	</div>

<?php assets_script_transaksi("pembelian.js"); ?>   

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

<!-- Load Rekap Account kas -->
<?php $this->load->view('master/accountkas/rekap_account_kas'); ?>
<?php assets_script_master("accountkas_rekap.js"); ?> 