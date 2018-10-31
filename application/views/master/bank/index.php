	
	<div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Table Master Karyawan, Bank</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <div class="table-responsive">
                        <table id="tblMasterBank" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                            <thead class="thead-navy">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Bank</th>
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
                <label for="nama_bank">Nama Bank :</label>
                <input type="text" class="form-control" name="nama_bank" id="nama_bank">
                <span class="help-block"><small id="errorNamaBank"></small></span>
            </div>
                
        <?php echo form_close(); ?>
    <!-- </form> -->
    <?php echo modalSaveClose(); ?>
    <!-- modal save close -->

    <!-- modal Delete -->
    <?php echo modalDeleteShow(); ?>
    <!-- end modal Delete -->

    <?php assets_script_master("bank.js"); ?>    