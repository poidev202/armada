    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Table Merk Chassis</h4>
                    <hr class="card-subtitle">
                    <div class="table-responsive">
                        <button type='button' class='btn btn-outline-primary btn-sm' id='btnTambahMerk'><i class='fa fa-plus'></i> Tambah</button>
                        <button type='button' class='btn waves-effect waves-light btn-secondary btn-sm' id='btnRefreshMerk'><i class='fa fa-refresh'></i> Refresh</button>

                        <table id="tblMerk" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                            <thead class="thead-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Merk</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Table Tipe Chassis</h4>
                    <hr class="card-subtitle">

                    <div class="table-responsive">
                        <button type='button' class='btn btn-outline-success btn-sm' id='btnTambahTipe'><i class='fa fa-plus'></i> Tambah</button>
                        <button type='button' class='btn waves-effect waves-light btn-secondary btn-sm' id='btnRefreshTipe'><i class='fa fa-refresh'></i> Refresh</button>

                        <table id="tblTipe" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                            <thead class="thead-success">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Tipe</th>
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
    <?php echo modalSaveOpen("modalFormMerk","sm","primary"); ?>
        <div id="inputMessage"></div>
        <!-- <form class="floating-labels m-t-40"> -->
        <?php echo form_open("",array("id" => "formDataMerk","class" => "form-material m-t-20")); ?>

            <div id="inputMessageMerk"></div>
            
            <div class="form-group m-b-20 focused">
                <label for="nama_merk">Nama Merk :</label>
                <input type="text" class="form-control" name="nama_merk" id="nama_merk">
                <span class="help-block"><small id="errorMerk"></small></span>
            </div>
                
        <?php echo form_close(); ?>
    <!-- </form> -->
    <?php echo modalSaveClose("Save Merk","modalBtnMerk"); ?>
    <!-- modal save close -->

    <!-- modal Delete -->
    <?php echo modalDeleteShow("modalDeleteMerk","Hapus Merk","modalBtnDeleteMerk"); ?>
    <!-- end modal Delete -->


    <!-- modal save open -->
    <?php echo modalSaveOpen("modalFormTipe","sm","success"); ?>
        <div id="inputMessage"></div>
        <!-- <form class="floating-labels m-t-40"> -->
        <?php echo form_open("",array("id" => "formDataTipe","class" => "form-material m-t-20")); ?>

            <div id="inputMessageTipe"></div>
            
            <div class="form-group m-b-20 focused">
                <label for="nama_tipe">Nama Tipe :</label>
                <input type="text" class="form-control" name="nama_tipe" id="nama_tipe">
                <span class="help-block"><small id="errorTipe"></small></span>
            </div>
                
        <?php echo form_close(); ?>
    <!-- </form> -->
    <?php echo modalSaveClose("Save Tipe","modalBtnTipe"); ?>
    <!-- modal save close -->

    <!-- modal Delete -->
    <?php echo modalDeleteShow("modalDeleteTipe","Hapus Tipe","modalBtnDeleteTipe"); ?>
    <!-- end modal Delete -->

<?php assets_script_master("chassis.js"); ?>    
