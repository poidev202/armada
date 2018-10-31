	
	<div class="card card-outline-primary">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Table Master Karyawan, Jabatan</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <div class="table-responsive">
                        <table id="tblMasterJabatan" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Jabatan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
    	</div>
    </div>


	<!-- modal save open -->
    <?php echo modalSaveOpen(false,"sm","primary"); ?>
        <div id="inputMessage"></div>
        <!-- <form class="floating-labels m-t-40"> -->
        <?php echo form_open("",array("id" => "formData","class" => "form-material m-t-20")); ?>

            <div id="inputMessage"></div>
            
            <div class="form-group m-b-20 focused">
                <label for="nama_jabatan">Nama Jabatan :</label>
                <input type="text" class="form-control" name="nama_jabatan" id="nama_jabatan">
                <span class="help-block"><small id="errorNamaJabatan"></small></span>
            </div>
                
        <?php echo form_close(); ?>
    <!-- </form> -->
    <?php echo modalSaveClose(); ?>
    <!-- modal save close -->

    <!-- modal Delete -->
    <?php echo modalDeleteShow(); ?>
    <!-- end modal Delete -->

    <?php assets_script_master("jabatan.js"); ?>    