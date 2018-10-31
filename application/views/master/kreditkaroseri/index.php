	<div id="dataTable">
		<div class="card">
	        <div class="card-body">
	        	<h4 class="card-title">Table Master Cicilan / Kredit Karoseri</h4>
	        	<hr class="card-subtitle">
			            
	            <!-- Nav tabs -->
                <ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tblProses" role="tab">Table Proses</a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tblStatus" role="tab">Table Status Armada</a> </li>
                    <li class="nav-item"> 
                    	<a class="nav-link" data-toggle="tab" href="" role="tab">
                    		<button type='button' class='btn btn-outline-primary btn-sm' id='btnTambah'><i class='fa fa-plus'></i> Tambah</button>
                		</a> 
                	</li>
                    <li class="nav-item"> 
                    	<a class="nav-link" data-toggle="tab" href="" role="tab">
                    		<button type='button' class='btn btn-outline-success btn-sm' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button>
                		</a> 
                	</li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="tblProses" role="tabpanel">
                        <div class="table-responsive">
			                <table id="tblMasterKreditKaroseri" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
			                    <thead class="thead-primary">
			                        <tr>
			                            <th>No</th>
			                            <th>Tanggal Bayar</th>
			                            <th>Nama Armada</th>
			                            <th>Vendor</th>
			                            <th>Karoseri</th>
			                            <th>No BK / Plat</th>
			                            <th>Angsuran Pokok</th>
			                            <th>Angsuran Bunga</th>
			                            <th>Jumlah Bayar</th>
			                            <th>Action</th>
			                        </tr>
			                    </thead>
			                    <tbody style="size: 5px;"></tbody>
			                </table>
			            </div>
                    </div>
                    <div class="tab-pane  p-20" id="tblStatus" role="tabpanel">
                    	<div class="table-responsive">
			                <table id="tblStatusArmada" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
			                    <thead class="thead-warning">
			                        <tr>
			                            <th>No</th>
			                            <th>Nama</th>
			                            <th>Photo</th>
			                            <th>Vendor</th>
			                            <th>Karoseri</th>
			                            <th>No BK / Plat</th>
			                            <th>Bayar Lunas</th>
			                            <th>Bayar DP</th>
			                            <th>Total Bayar</th>
			                            <th>Sisa Hutang</th>
			                            <th>Action</th>
			                        </tr>
			                    </thead>
			                    <tbody style="size: 5px;"></tbody>
			                </table>
			            </div>
                    </div>
                </div>

	        </div>
	    </div>
	</div>
	
	<!-- modal detail -->
	<?php echo modalDetailOpen(false,"lg","primary","Rekap Pembayaran Kredit Karoseri"); ?>

		<small class="text-muted">Nama Armada : <u id="namaArmadaRekap"></u> </small>
		<br>
        <small class="text-muted">No Plat / BK : <u id="noBkRekap"></u></small>
        <br>
        <small class="text-muted">Karoseri : <u id="karoseriRekap"></u></small>
        <br>
        <small class="text-muted">Vendor : <u id="vendorRekap"></u></small>

		<div class="table-responsive">
            <table id="tblRekapKreditKaroseri" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
                <thead class="thead-info">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Bayar</th>
                        <th>Angsuran Pokok</th>
                        <th>Angsuran Bunga</th>
                        <th>Jumlah Bayar</th>
                    </tr>
                </thead>
                <tbody style="size: 5px;"></tbody>
                <tfoot class="tfoot-sm">
                	<tr>
                		<th colspan="4" style="text-align: right;" >Jumlah Bayar</th>
                		<th id="totalRekapJumlahBayar"></th>
                	</tr>
                	<tr>
                		<th colspan="4" style="text-align: right;">Bayar DP</th>
                		<th id="totalRekapBayarDp"></th>
                	</tr>
                	<tr>
                		<th colspan="4" style="text-align: right;">Total Bayar</th>
                		<th id="totalRekapBayar"></th>
                	</tr>
                </tfoot>
            </table>
            <table>
            	
            </table>
        </div>
	<?php echo modalDetailClose(); ?>

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

	        	<?php echo form_open("",array("id" => "formData","class" => "m-t-20")); ?>

	            	<div id="inputMessage"></div>
	            	<input type="hidden" name="id_kredit" id="id_kredit">
		            <div class="row">
		            	<div class="col-md-6">
				            <div class="form-group m-b-5 m-t-10 focused">
				                <label for="nama_armada">Nama Armada :</label>
				                <select class="form-control select2" name="nama_armada" style="width: 100%;"  id="nama_armada">
				                </select>
				                <span class="help-block"><small id="errorNamaArmada"></small></span>
				            </div>

				            <div class="row">
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						            	<label for="">Photo Armada</label>
					            		<center>
				            				<div class="el-card-avatar el-overlay-1">
				                                <img id="imgArmada" src="/assets/images/default/no_image.jpg" style="height: 150px; width: 150px;" class="img img-responsive" alt="Armada Photo" >
				                            </div>
					            		</center>
		                            </div>
				            	</div>
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="no_bk">No BK / Plat :</label><br>
						                <input type="text" class="form-control" readonly id="no_bk">
						            </div>
						            <div class="form-group m-b-5 m-t-10">
						                <label for="karoseri">Karoseri:</label><br>
						                <input type="text" class="form-control" readonly id="karoseri">
						            </div>
						            <div class="form-group m-b-5 m-t-10">
						                <label for="tipe">Tipe Karoseri:</label><br>
						                <input type="text" class="form-control" readonly id="tipe">
						            </div>
						            <div class="form-group m-b-5 m-t-10">
						                <label for="tahun">Tahun :</label><br>
						                <input type="text" class="form-control" readonly id="tahun">
						            </div>
				            	</div>
				            </div>
		            	</div>
		            	<div class="col-md-6">

		            		<div class="row">
		            			<div class="col-md-6">
		            				<div class="form-group has-success m-b-5 m-t-10">
						                <label for="">Bayar Lunas :</label>
						                <input type="text" class="form-control" readonly id="bayar_lunas">
						                <input type="hidden" class="form-control" readonly id="bayar_lunas_int">
						            </div>
		            			</div>
		            			<div class="col-md-6">
		            				<div class="form-group has-success m-b-5 m-t-10">
						                 <label for="">Bayar DP :</label>
						                <input type="text" class="form-control" readonly id="bayar_dp">
						            </div>
		            			</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-md-6">
						            <div class="form-group has-warning m-b-5 m-t-10">
						                <label for="total_bayar">Total Sudah Bayar :</label><br>
						                <input type="text" class="form-control" readonly id="total_bayar">
						                <input type="hidden" class="form-control" readonly id="total_bayar_int">
						            </div>
		            			</div>
		            			<div class="col-md-6">
						            <div class="form-group has-danger m-b-5 m-t-10">
						                <label for="sisa_hutang">Sisa Hutang :</label><br>
						                <input type="text" class="form-control" readonly id="sisa_hutang_rp">
						                <input type="hidden" class="form-control" readonly id="sisa_hutang">
						            </div>
		            			</div>
		            		</div>

				            <div class="form-group m-b-5 m-t-10">
				                <label for="vendor_karoseri">Vendor :</label>
				                <select class="form-control select2" name="vendor_karoseri" style="width: 100%;"  id="vendor_karoseri">
				                </select>
				                <span class="help-block"><small id="errorVendorChassis"></small></span>
				            </div>

				            <div class="row">
		            			<div class="col-md-6">
		            				<div class="form-group m-b-5 m-t-10">
						                <label for="">Tanggal Bayar:</label>
						                <input type="text" class="form-control tanggal" name="tanggal_bayar" id="tanggal_bayar">
						                <span class="help-block"><small id="errorTanggalBayar"></small></span>
						            </div>
						            <div class="form-group has-warning m-b-5 m-t-10">
						                <label for="estimasi_total_bayar">Estimasi Total Bayar :</label><br>
						                <input type="text" class="form-control" readonly id="estimasi_total_bayar">
						            </div>
						            <div class="form-group has-danger m-b-5 m-t-10">
						                <label for="estimasi_sisa_hutang">Estimasi Sisa Hutang :</label><br>
						                <input type="text" class="form-control" readonly id="estimasi_sisa_hutang">
						            </div>
		            			</div>
		            			<div class="col-md-6">
		            				<div class="form-group m-b-5 m-t-10">
						                <label for="">Angsuran Pokok :</label>
						                <input type="number" name="angsuran_pokok" min="0" class="form-control" id="angsuran_pokok">
						                <span class="help-block"><small id="hasil_matauang_pokok"></small></span>
						                <span class="help-block"><small id="errorAngsuranPokok"></small></span>
						            </div>
		            				<div class="form-group m-b-5 m-t-10">
						                <label for="">Angsuran Bunga:</label>
						                <input type="number" name="angsuran_bunga" min="0" class="form-control" id="angsuran_bunga">
						                <span class="help-block"><small id="hasil_matauang_bunga"></small></span>
						                <span class="help-block"><small id="errorAngsuranBunga"></small></span>
						            </div>
						            <div class="form-group m-b-5 m-t-10">
						                <label for="">Jumlah Bayar: </label>
						                <input type="text" class="form-control" readonly id="jumlah_bayar">
						                <input type="hidden" class="form-control" min="0" readonly id="jumlah_bayar_int">
						            </div>
		            			</div>
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

<?php assets_script_master("kredit_karoseri.js"); ?>   