	
	<div id="dataTable">
		<div class="card">
	        <div class="card-body">
	        	<h4 class="card-title">Table Master Vendor</h4>
	        	<hr class="card-subtitle">
	            <div class="table-responsive">
	                <table id="tblMasterVendor" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
	                    <thead class="thead-dark">
	                        <tr>
	                            <th>No</th>
	                            <th>Nama Vendor</th>
	                            <th>No Telp</th>
	                            <th>Email</th>
	                            <th>Penyedia</th>
	                            <th>Jasa</th>
	                            <th>Alamat</th>
	                            <th>Keterangan</th>
	                            <th>Action</th>
	                        </tr>
	                    </thead>
	                </table>
	            </div>
	        </div>
	    </div>
	</div>


	<!-- modal save open -->
    <?php echo modalSaveOpen(false,"lg"); ?>
        <div id="inputMessage"></div>
    	<?php echo form_open("",array("id" => "formData","class" => "m-t-20")); ?>

        	<div id="inputMessage"></div>
            <div class="form-group m-b-5 m-t-10 focused">
                <label for="nama_vendor">Nama Vendor :</label>
                <input type="text" class="form-control" name="nama_vendor" id="nama_vendor">
                <span class="help-block"><small id="errorNamaVendor"></small></span>
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
    		
    		<label class="m-b-5 m-t-10">Status :</label>
    		<div class="row">
            	<div class="col-md-2">
            		<div class="form-group m-b-5 m-t-10">
		    			<input type="checkbox" id="penyedia" value="1" name="penyedia" class="filled-in chk-col-deep-orange" />
		                <label for="penyedia">Penyedia</label>
		            </div>  
		               
            	</div>
            	<div class="col-md-2">
            		<div class="form-group m-b-5 m-t-10">
            		 	<input type="checkbox" id="jasa" value="1" name="jasa" class="filled-in chk-col-deep-cyan" />
		                <label for="jasa">Jasa</label>
		            </div>
            	</div>
    		</div>

    		<div class="row">
    			<div class="col-md-6">
    				<div class="form-group m-b-5 m-t-10">
		                <label for="alamat">Alamat :</label>
		                <textarea class="form-control" name="alamat" id="alamat" rows="3" ></textarea>
		                <span class="help-block"><small id="errorAlamat"></small></span>
		            </div>
    			</div>
    			<div class="col-md-6">
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
	        
<?php assets_script_master("vendor.js"); ?>   