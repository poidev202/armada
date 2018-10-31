	
	<div id="dataTable">
		<div class="card">
	        <div class="card-body">
	        	<h4 class="card-title">Table Master Account Kas</h4>
	        	<hr class="card-subtitle">
	            <div class="table-responsive">
	                <table id="tblMasterAccountKas" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
	                    <thead class="thead-success">
	                        <tr>
	                            <th>No</th>
	                            <th>Nama Account</th>
	                            <th>No Telp</th>
	                            <th>Email</th>
	                            <th>Alamat</th>
	                            <th>Keterangan</th>
	                            <th>Saldo</th>
	                            <th>Opsi</th>
	                            <th>Action</th>
	                        </tr>
	                    </thead>
	                </table>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- modal save open -->
    <?php echo modalSaveOpen(); ?>
        <div id="inputMessage"></div>
    	<?php echo form_open("",array("id" => "formData","class" => "m-t-20")); ?>

        	<div id="inputMessage"></div>
            <div class="form-group m-b-5 m-t-10 focused">
                <label for="nama_kas">Nama Account Kas :</label>
                <input type="text" class="form-control" name="nama_kas" id="nama_kas">
                <span class="help-block"><small id="errorNamaKas"></small></span>
            </div>

            <div class="row">
            	<div class="col-md-6">
            		<div class="form-group m-b-5 m-t-10">
		                <label for="no_telp">No Telp :</label>
		                <input type="text" class="form-control" name="no_telp" id="no_telp">
		                <span class="help-block"><small id="errorNoTelp"></small></span>
		            </div>
            	</div>
            	<div class="col-md-6">
            		<div class="form-group m-b-5 m-t-10">
		                <label for="email">Email :</label>
		                <input type="text" class="form-control" name="email" id="email">
		                <span class="help-block"><small id="errorEmail"></small></span>
		            </div>
            	</div>
            </div>
            
			<div class="form-group m-b-5 m-t-10">
                <label for="alamat">Alamat :</label>
                <textarea class="form-control" name="alamat" id="alamat" rows="3" ></textarea>
                <span class="help-block"><small id="errorAlamat"></small></span>
            </div>
		
			<div class="form-group m-b-5 m-t-10">
                <label for="keterangan">Keterangan :</label>
                <textarea class="form-control" name="keterangan" id="keterangan" rows="3" ></textarea>
                <span class="help-block"><small id="errorKeterangan"></small></span>
            </div>
    			
            	
		<?php echo form_close(); ?>
    <?php echo modalSaveClose(); ?>
    <!-- modal save close -->
	        
<?php assets_script_master("accountkas.js"); ?>   

<!-- Load Rekap Account kas -->
<?php $this->load->view('master/accountkas/rekap_account_kas'); ?>
<?php assets_script_master("accountkas_rekap.js"); ?> 