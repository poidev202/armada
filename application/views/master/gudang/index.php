	
	<div id="dataTable">
		<div class="card">
	        <div class="card-body">
	        	<h4 class="card-title">Table Master Gudang</h4>
	        	<hr class="card-subtitle">
	            <div class="table-responsive">
	                <table id="tblMasterGudang" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
	                    <thead class="thead-primary">
	                        <tr>
	                            <th>No</th>
	                            <th>Nama Gudang</th>
	                            <th>No Telp</th>
	                            <th>Alamat</th>
	                            <th>Keterangan</th>
	                            <th>Opsi</th>
	                            <th>Action</th>
	                        </tr>
	                    </thead>
	                    <tbody style="size: 5px;"></tbody>
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
                <label for="nama_gudang">Nama Gudang :</label>
                <input type="text" class="form-control" name="nama_gudang" id="nama_gudang">
                <span class="help-block"><small id="errorNamaGudang"></small></span>
            </div>
    		<div class="form-group m-b-5 m-t-10">
                <label for="no_telp">No Telp :</label>
                <input type="text" class="form-control" name="no_telp" id="no_telp">
                <span class="help-block"><small id="errorNoTelp"></small></span>
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

<?php assets_script_master("gudang.js"); ?>   

<!-- datatable rekap gudang produk -->
<?php $this->load->view('master/gudang/rekap_gudang'); ?>
<?php assets_script_master("gudang_rekap.js"); ?>   