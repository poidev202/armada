	
	<div id="dataTable">
		<div class="card">
	        <div class="card-body">
	        	<h4 class="card-title">Table Transaksi Penjualan / Pemakaian</h4>
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
	                                <label for="">Tanggal Awal dan Akhir Jual :</label>
	                                <div class="input-daterange input-group date-range" id="">
	                                    <input type="text" class="form-control" data-column="0" name="tgl_awal_jual" id="tgl_awal_jual" placeholder="Tanggal Awal">
	                                    <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
	                                    <input type="text" class="form-control" data-column="1" name="tgl_akhir_jual" id="tgl_akhir_jual" placeholder="Tanggal Akhir">
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
	                <table id="tblTransaksiPenjualan" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
	                    <thead class="thead-maroon">
	                        <tr>
	                            <th>No</th>
	                            <th>Action</th>
	                            <th>Tanggal Jual</th>
	                            <th>Kode Produk</th>
	                            <th>Nama Produk</th>
	                            <th>Armada</th>
	                            <th>Gudang</th>
	                            <th>Kategori</th>
	                            <th>Unit</th>
	                            <th>Harga Jual</th>
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
						                <label for="">Kategori Produk :</label>
				                		<input type="text" class="form-control" readonly id="kategori_produk">
						            </div>
				            	</div>
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="">Unit Produk :</label>
				                		<input type="text" class="form-control" readonly id="unit_produk">
						            </div>
				            	</div>
				    		</div>
				    		<div id="errorSaldo"></div>
				    		<div class="row" id="infoSaldoProduk" style="display: none;">
				            	<div class="col-md-4">
				            		<div class="form-group m-b-5 m-t-10">
						                <label>Saldo Minimal :</label>
				                		<input type="number" min="0" class="form-control" readonly id="saldo_minimal">
						            </div>
				            	</div>
				            	<!-- <div class="col-md-4">
				            		<div class="form-group m-b-5 m-t-10">
						                <label>Total Saldo :</label>
				                		<input type="number" min="0" class="form-control" readonly id="total_saldo">
						            </div>
				            	</div> -->
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label title="Sisa saldo keseluruhan">Sisa Saldo Keseluruhan:</label>
				                		<input type="number" min="0" title="Sisa saldo keseluruhan" class="form-control" readonly id="sisa_saldo">
						            </div>
				            	</div>
				            </div>

				            <div class="form-group m-b-5 m-t-10 focused">
				                <label for="nama_armada">Nama Armada Pemakai :</label>
				                <select class="form-control select2" name="nama_armada" style="width: 100%;"  id="nama_armada">
				                </select>
				                <span class="help-block"><small id="errorNamaArmada"></small></span>
				            </div>
				            <div class="row">
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						            	<label for="">Photo Armada :</label>
					            		<center>
				            				<div class="el-card-avatar el-overlay-1">
				                                <img id="imgArmada" src="/assets/images/default/no_image.jpg" style="height: 120px; width: 120px;" class="img img-responsive" alt="Armada Photo" >
				                            </div>
					            		</center>
		                            </div>
						            <div class="form-group m-b-5 m-t-10">
						                <label for="karoseri">Karoseri :</label><br>
						                <input type="text" class="form-control" readonly id="karoseri">
						            </div>
						            <div class="form-group m-b-5 m-t-10">
						                <label for="tipe_karoseri">Tipe Karoseri :</label><br>
						                <input type="text" class="form-control" readonly id="tipe_karoseri">
						            </div>
				            	</div>
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="no_bk">No BK / Plat :</label><br>
						                <input type="text" class="form-control" readonly id="no_bk">
						            </div>
						            <div class="form-group m-b-5 m-t-10">
						                <label for="tahun">Tahun :</label><br>
						                <input type="text" class="form-control" readonly id="tahun">
						            </div>
						            <div class="form-group m-b-5 m-t-10">
						                <label for="merk_chassis">Merk Chassis :</label><br>
						                <input type="text" class="form-control" readonly id="merk_chassis">
						            </div>
						            <div class="form-group m-b-5 m-t-10">
						                <label for="tipe_chassis">Tipe Chassis :</label><br>
						                <input type="text" class="form-control" readonly id="tipe_chassis">
						            </div>
				            	</div>
				            </div>
		    			</div>
		    			<div class="col-md-6">
				            <div class="row">
				            	<div class="col-md-8">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="">Gudang : </label> <i><span id="NamaGudangProduk"></span></i>
						                <select id="gudang" name="gudang" class="form-control select2" style="width: 100%">
						                </select>
						                <span class="help-block"><small id="errorGudang"></small></span>
						            </div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="">Tanggal Jual :</label>
				                		<input type="text" class="form-control tanggal" name="tanggal_jual" id="tanggal_jual">
						                <span class="help-block"><small id="errorTanggal"></small></span>
						            </div>
				            	</div>
				    		</div>
				    		<div class="row" id="infoHargaSaldoGudang" style="display: none;">
				            	<div class="col-md-7">
						            <label class="m-t-10 m-b-2">Harga Beli Unit : </label>
					            	<select id="hargaUnitProdukGudangPerTanggal" name="tgl_harga_beli" class="form-control select2" style="width: 100%">
					            		
					            	</select>

					            	<div class="card card-inverse m-t-10" id="showHargaBeliUnit" style="display: none;">
			                            <div class="card-header">
			                                <h4 class="m-b-0"><span><u id="statusProduk"></u></span> | <span id="tglBeli"></span></h4></div>
			                            <div class="card-body">
								            <div class="row">
								            	<div class="col-md-6">
								            		<div class="form-group m-t-7">
										                <label>Saldo Masuk:</label>
								                		<input type="number" min="0" class="form-control" readonly id="saldoMasukHargaTanggal">
										            </div>
								            	</div>
								            	<div class="col-md-6">
								            		<div class="form-group m-t-7">
										                <label>Sisa Saldo:</label>
								                		<input type="number" min="0" class="form-control" readonly id="saldoSisaHargaTanggal" name="saldoSisaHargaTanggal">
										            </div>
								            	</div>
								            </div>
			                            </div>
			                        </div>

									<!-- <div class="card-body" id="hargaUnitProdukGudang">
					            	</div> -->
				            	</div>
				            	<div class="col-md-5">
		            				<!-- <div class="form-group m-b-5 m-t-10">
						                <label>Saldo Gudang :</label>
				                		<input type="number" min="0" class="form-control" readonly id="saldo_gudang">
						            </div> -->
		            				<div class="form-group m-t-10">
						                <label>Sisa Saldo Gudang :</label>
				                		<input type="number" min="0" class="form-control" readonly id="sisa_saldo_gudang">
						            </div>
				            	</div>
				            </div>

				    		<div class="row">
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label>Harga Jual Unit :</label>
				                		<input type="number" min="0" class="form-control" name="harga_jual" id="harga_jual">
				                        <span class="help-block"><small id="mata_uang_harga_jual"></small></span>
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
				            <div class="form-group m-b-5 m-t-10" id="infoTotalHargaJual" style="display: none;">
				                <label>Total Harga Jual :</label>
				                <input type="text" id="totalHargaJual" class="form-control" readonly>
				                <span class="help-block"><small>Harga Jual Unit (*) jumlah</small></span>
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

	<div id="detailPenjualan" style="display: none;">
		<div class="ribbon-wrapper card">
			<div class="ribbon ribbon-info">
                <i class='fa fa-info-circle'></i> <span>Detail Transaksi Penjualan / Pemakaian</span>
            </div>
            <div class="ribbon ribbon-corner ribbon-right ribbon-danger">
            	<div class="card-actions pull-right">
                    <a class="btn-close close-form"><i class="ti-close"></i></a>
                </div>
            </div>
	        <div class="ribbon-content">
		        <div id="inputMessageDetail"></div>
		        <form>
		    		<div class="row">
		    			<div class="col-md-6">
				            <div class="form-group m-b-5 m-t-10 focused">
				                <label class="text-black">Nama Produk :</label><br>
				                <span class="help-block"><small id="detailNamaProduk"></small></span>
				                <hr>
				            </div>
				    		<div class="row">
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label class="text-black">Kategori Produk :</label><br>
				                		<span class="help-block"><small id="detailKategoriProduk"></small></span>
				                		<hr>
						            </div>
				            	</div>
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label class="text-black">Unit Produk :</label><br>
				                		<span class="help-block"><small id="detailUnitProduk"></small></span>
				                		<hr>
						            </div>
				            	</div>
				    		</div>

				            <div class="form-group m-b-5 m-t-10 focused">
				                <label for="nama_armada">Nama Armada Pemakai :</label><br>
				                <span class="help-block"><small id="detailNamaArmada"></small></span>
				                <hr>
				            </div>
				            <div class="row">
				            	<div class="col-md-6">
				            		<div class="form-group m-b-0 m-t-10">
						            	<label class="text-black">Photo Armada :</label>
					            		<center>
				            				<div class="el-card-avatar el-overlay-1">
				                                <img id="detailImgArmada" src="/assets/images/default/no_image.jpg" style="height: 120px; width: 120px;" class="img img-responsive" alt="Armada Photo" >
				                            </div>
					            		</center>
		                            </div>
						            <div class="form-group m-b-5 m-t-30">
						                <label for="">Karoseri :</label><br>
				                		<span class="help-block"><small id="detailKaroseri"></small></span>
				                		<hr>
						            </div>
						            <div class="form-group m-b-5 m-t-10">
						                <label for="">Tipe Karoseri :</label><br>
				                		<span class="help-block"><small id="detailTipeKaroseri"></small></span>
				                		<hr>
						            </div>
				            	</div>
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="">No BK / Plat :</label><br>
				                		<span class="help-block"><small id="detailNoBK"></small></span>
				                		<hr>
						            </div>
						            <div class="form-group m-b-5 m-t-10">
						                <label for="">Tahun :</label><br>
				                		<span class="help-block"><small id="detailTahun"></small></span>
				                		<hr>
						            </div>
						            <div class="form-group m-b-5 m-t-10">
						                <label for="">Merk Chassis :</label><br>
				                		<span class="help-block"><small id="detailMerkChassis"></small></span>
				                		<hr>
						            </div>
						            <div class="form-group m-b-5 m-t-10">
						                <label for="">Tipe Chassis :</label><br>
				                		<span class="help-block"><small id="detailTipeChassis"></small></span>
				                		<hr>
						            </div>
				            	</div>
				            </div>
		    			</div>
		    			<div class="col-md-6">
				            <div class="row">
				            	<div class="col-md-8">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="">Gudang : </label><br>
						                <span class="help-block"><small id="detailGudang"></small></span>
						                <hr>
						            </div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="">Tanggal Jual :</label><br>
						                <span class="help-block"><small id="detailTanggalJual"></small></span>
						                <hr>
						            </div>
				            	</div>
				    		</div>

							<div class="form-group m-b-5 m-t-10">
				                <label>Tanggal beli dan harga beli unit produk :</label><br>
				                <small>
			                        Tanggal : <span class="help-block" id="detailTanggalBeli"></span> 
			                        &nbsp;&nbsp; || &nbsp;&nbsp;
			                        Harga : <span class="help-block" id="detailHargaBeliUnit"></span>
		                        </small>
		                        <hr>
				            </div>

				    		<div class="row">
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label>Harga Jual Unit :</label><br>
				                        <span class="help-block"><small id="detailHargaJual"></small></span>
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
				                <label>Total Harga Jual :</label>
								<span class="help-block"><small>Harga Jual Unit (*) jumlah</small></span>
				                <br>
				                <span class="help-block"><small id="detailTotalHargaJual"></small></span>
				                <hr>
				            </div>
							<div class="form-group m-b-5 m-t-10">
				                <label>Account Kas :</label><br>
				                <span class="help-block"><small id="detailAccountKas"></small></span>
				                <hr>
				            </div>
							<div class="form-group m-b-5 m-t-10">
				                <label>Keterangan :</label><br>
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

<?php assets_script_transaksi("penjualan.js"); ?>  

<!-- datatable rekap produk -->
<?php $this->load->view('master/produk/rekap_produk'); ?>
<?php assets_script_master("produk_rekap.js"); ?>

<!-- datatable rekap kategori produk -->
<?php $this->load->view('master/produkkategori/rekap_kategori'); ?>
<?php assets_script_master("produk_kategori_rekap.js"); ?>

<!-- datatable rekap gudang produk -->
<?php $this->load->view('master/gudang/rekap_gudang'); ?> 
<?php assets_script_master("gudang_rekap.js"); ?>

<!-- Load Rekap Account kas -->
<?php $this->load->view('master/accountkas/rekap_account_kas'); ?>
<?php assets_script_master("accountkas_rekap.js"); ?> 