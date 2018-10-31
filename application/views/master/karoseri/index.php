    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Table Karoseri</h4>
                    <hr class="card-subtitle">
                    <div class="table-responsive">
                        <button type='button' class='btn btn-outline-info btn-sm' id='btnTambahKaroseri'><i class='fa fa-plus'></i> Tambah</button>
                        <button type='button' class='btn waves-effect waves-light btn-secondary btn-sm' id='btnRefreshKaroseri'><i class='fa fa-refresh'></i> Refresh</button>

                        <table id="tblKaroseri" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                            <thead class="thead-info">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karoseri</th>
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
                    <h4 class="card-title">Table Tipe Karoseri</h4>
                    <hr class="card-subtitle">

                    <div class="table-responsive">
                        <button type='button' class='btn btn-outline-success btn-sm' id='btnTambahTipe'><i class='fa fa-plus'></i> Tambah</button>
                        <button type='button' class='btn waves-effect waves-light btn-secondary btn-sm' id='btnRefreshTipe'><i class='fa fa-refresh'></i> Refresh</button>

                        <table id="tblTipe" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                            <thead class="thead-warning">
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
    <?php echo modalSaveOpen("modalFormKaroseri","sm","info"); ?>
        <div id="inputMessage"></div>
        <!-- <form class="floating-labels m-t-40"> -->
        <?php echo form_open("",array("id" => "formDataKaroseri","class" => "form-material m-t-20")); ?>

            <div id="inputMessageKaroseri"></div>
            
            <div class="form-group m-b-20 focused">
                <label for="nama_karoseri">Nama Karoseri :</label>
                <input type="text" class="form-control" name="nama_karoseri" id="nama_karoseri">
                <span class="help-block"><small id="errorKaroseri"></small></span>
            </div>
                
        <?php echo form_close(); ?>
    <!-- </form> -->
    <?php echo modalSaveClose("Simpan Karoseri","modalBtnKaroseri"); ?>
    <!-- modal save close -->

    <!-- modal Delete -->
    <?php echo modalDeleteShow("modalDeleteKaroseri","Hapus Karoseri","modalBtnDeleteKaroseri"); ?>
    <!-- end modal Delete -->


    <!-- modal save open -->
    <?php echo modalSaveOpen("modalFormTipe","sm","warning"); ?>
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
    <?php echo modalSaveClose("Simpan Tipe","modalBtnTipe"); ?>
    <!-- modal save close -->

    <!-- modal Delete -->
    <?php echo modalDeleteShow("modalDeleteTipe","Hapus Tipe","modalBtnDeleteTipe"); ?>
    <!-- end modal Delete -->

<?php assets_script_master("karoseri.js"); ?>    
