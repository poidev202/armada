	
	<div id="dataTable">
		<div class="card">
	        <div class="card-body">
	        	<h4 class="card-title">Table Master Produk</h4>
	        	<hr class="card-subtitle">
	            <div class="table-responsive">
	                <table id="tblMasterProduk" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
	                    <thead class="thead-info">
	                        <tr>
	                            <th>No</th>
	                            <th>Kode</th>
	                            <th>Nama Produk</th>
	                            <th>Kategori</th>
	                            <th>Unit</th>
	                            <th>Gudang</th>
	                            <th>Vendor</th>
	                            <th>Harga Unit</th>
	                            <th>Saldo Awal</th>
	                            <th>Saldo Min</th>
	                            <th>Action</th>
	                        </tr>
	                    </thead>
	                </table>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- modal save open -->
    <?php echo modalSaveOpen(false,"lg","info"); ?>
        <div id="inputMessage"></div>
    	<?php echo form_open("",array("id" => "formData","class" => "m-t-5")); ?>
    		<div class="row">
    			<div class="col-md-6">
		            <div class="form-group m-b-5 m-t-10" id="infoKodeProduk" style="display: none;">
		                <label>Kode Produk :</label>
		                <span class="help-block"><b id="kodeProduk"></b></span>
		                <hr>
		            </div>
		            <div class="form-group m-b-5 m-t-10 focused">
		                <label for="nama_produk">Nama Produk :</label>
		                <input type="text" class="form-control" name="nama_produk" id="nama_produk">
		                <span class="help-block"><small id="errorNamaProduk"></small></span>
		            </div>
		    		<!-- <div class="row"> -->
		            	<!-- <div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10">
				                <label for="">Tanggal Beli</label>
		                		<input type="text" class="form-control tanggal" name="tanggal_beli" id="tanggal_beli">
				                <span class="help-block"><small id="errorTanggalBeli"></small></span>
				            </div>
		            	</div> -->
		            	<!-- <div class="col-md-6"> -->
		            		<div class="form-group m-b-5 m-t-10">
				                <label for="">Gudang</label>
				                <select id="gudang" name="gudang" class="form-control select2" style="width: 100%">
				                </select>
				                <span class="help-block"><small id="errorGudang"></small></span>
				            </div>
		            	<!-- </div> -->
		    		<!-- </div> -->
		            <div class="form-group m-b-5 m-t-10">
		                <label for="vendor">Vendor :</label>
				        <select id="vendor" name="vendor" class="form-control select2" style="width: 100%">
				        </select>
		                <span class="help-block"><small id="errorVendor"></small></span>
		            </div>
		            <div class="row">
		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10">
				                <label for="kategori">Kategori :</label>
				                <select id="kategori" name="kategori" class="form-control select2" style="width: 100%">
				                </select>
				                <span class="help-block"><small id="errorKategori"></small></span>
				            </div>
		            	</div>
		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10">
				                <label for="unit">Unit / Satuan :</label>
				                <select id="unit" name="unit" class="form-control select2" style="width: 100%">
				                </select>
				                <span class="help-block"><small id="errorUnit"></small></span>
				            </div>
		            	</div>
		            </div>
    			</div>
    			<div class="col-md-6">
            		<div class="form-group m-b-5 m-t-10">
		                <label>Harga Unit :</label>
                		<input type="number" min="0" class="form-control" name="harga_unit" id="harga_unit">
                        <span class="help-block"><small id="mata_uang_harga_unit"></small></span>
		            </div>
		            <div class="row">
		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10">
				                <label>Saldo :</label>
		                		<input type="number" min="0" class="form-control" name="saldo" id="saldo">
				                <span class="help-block"><small id="errorSaldo"></small></span>
				            </div>
		            	</div>
		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10">
				                <label>Saldo Minimal :</label>
		                		<input type="number" min="0" class="form-control" name="saldo_minimal" id="saldo_minimal">
				                <span class="help-block"><small id="errorSaldoMinimal"></small></span>
				            </div>
		            	</div>
		            </div>
		            <div class="form-group m-b-5 m-t-10" id="infoTotalHargaBeli" style="display: none;">
		                <label>Total Harga Unit :</label>
		                <input type="text" id="totalHargaBeli" class="form-control" readonly>
		                <span class="help-block"><small>Harga Unit (*) saldo</small></span>
		            </div>
					<div class="form-group m-b-5 m-t-10">
		                <label for="keterangan">Keterangan :</label>
		                <textarea class="form-control" name="keterangan" id="keterangan" rows="3" ></textarea>
		                <span class="help-block"><small id="errorKeterangan"></small></span>
		            </div>
    			</div>
    		</div>
		<?php echo form_close(); ?>
    <?php echo modalSaveClose(); ?>
    <!-- modal save close -->

    <!-- modal detail open -->
    <?php echo modalDetailOpen(false,"lg","black","Detail Produk"); ?>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group m-b-5 m-t-10">
	                <label>Kode Produk :</label><br>
	                <span class="help-block"><b id="detailKodeProduk"></b></span>
	                <hr>
	            </div>
	            <div class="form-group m-b-5 m-t-10 focused">
	                <label for="nama_produk">Nama Produk :</label><br>
	                <span class="help-block"><small id="detailNamaProduk"></small></span>
	                <hr>
	            </div>
	    		<!-- <div class="row"> -->
	            	<!-- <div class="col-md-6">
	            		<div class="form-group m-b-5 m-t-10">
			                <label for="">Tanggal Beli</label><br>
			                <span class="help-block"><small id="detailTanggalBeli"></small></span>
			                <hr>
			            </div>
	            	</div> -->
	            	<!-- <div class="col-md-6"> -->
	            		<div class="form-group m-b-5 m-t-10">
			                <label for="">Gudang</label><br>
			                <span class="help-block"><small id="detailGudang"></small></span>
			                <hr>
			            </div>
	            	<!-- </div> -->
	    		<!-- </div> -->
	            <div class="form-group m-b-5 m-t-10">
	                <label for="vendor">Vendor :</label><br>
	                <span class="help-block"><small id="detailVendor"></small></span>
	                <hr>
	            </div>
	            <div class="row">
	            	<div class="col-md-6">
	            		<div class="form-group m-b-5 m-t-10">
			                <label for="kategori">Kategori :</label><br>
			                <span class="help-block"><small id="detailKategori"></small></span>
			                <hr>
			            </div>
	            	</div>
	            	<div class="col-md-6">
	            		<div class="form-group m-b-5 m-t-10">
			                <label for="unit">Unit / Satuan :</label><br>
			                <span class="help-block"><small id="detailUnit"></small></span>
			                <hr>
			            </div>
	            	</div>
	            </div>
			</div>
			<div class="col-md-6">
        		<div class="form-group m-b-5 m-t-10">
	                <label>Harga Unit :</label><br>
                    <span class="help-block"><small id="detailHargaUnit"></small></span>
                    <hr>
	            </div>
	            <div class="row">
	            	<div class="col-md-6">
	            		<div class="form-group m-b-5 m-t-8">
			                <label>Saldo :</label><br>
			                <span class="help-block"><small id="detailSaldo"></small></span>
			                <hr>
			            </div>
	            	</div>
	            	<div class="col-md-6">
	            		<div class="form-group m-b-5 m-t-8">
			                <label>Saldo Minimal :</label><br>
			                <span class="help-block"><small id="detailSaldoMinimal"></small></span>
			                <hr>
			            </div>
	            	</div>
	            </div>
	            <div class="form-group m-b-5 m-t-8" id="detailInfoTotalHarga" style="display: none;">
	                <label>Total Harga Unit : </label>
	                <span class="help-block"><small>Harga Unit (*) saldo</small></span>
	                <br>
			        <span class="help-block"><small id="detailTotalHarga"></small></span>
			        <hr>
	            </div>
				<div class="form-group m-b-5 m-t-10">
	                <label for="keterangan">Keterangan :</label><br>
	                <span class="help-block"><small id="detailKeterangan"></small></span>
	                <hr>
	            </div>
			</div>
		</div>
    <?php echo modalDetailClose(); ?>
    <!-- modal detail close -->

<?php assets_script_master("produk.js"); ?>

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