    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Table Kategori</h4>
                    <hr class="card-subtitle">
                    <div class="table-responsive">
                        <button type='button' class='btn btn-outline-primary btn-sm' id='btnTambahKategori'><i class='fa fa-plus'></i> Tambah</button>
                        <button type='button' class='btn waves-effect waves-light btn-secondary btn-sm' id='btnRefreshKategori'><i class='fa fa-refresh'></i> Refresh</button>

                        <table id="tblKategori" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                            <thead class="thead-success">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
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
                    <h4 class="card-title">Table Unit / Satuan</h4>
                    <hr class="card-subtitle">

                    <div class="table-responsive">
                        <button type='button' class='btn btn-outline-info btn-sm' id='btnTambahUnit'><i class='fa fa-plus'></i> Tambah</button>
                        <button type='button' class='btn waves-effect waves-light btn-secondary btn-sm' id='btnRefreshUnit'><i class='fa fa-refresh'></i> Refresh</button>

                        <table id="tblUnit" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                            <thead class="thead-warning">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Unit / Satuan</th>
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
    <?php echo modalSaveOpen("modalFormKategori","sm","success"); ?>
        <div id="inputMessage"></div>
        <!-- <form class="floating-labels m-t-40"> -->
        <?php echo form_open("",array("id" => "formDataKategori","class" => "form-material m-t-20")); ?>

            <div id="inputMessageKategori"></div>
            
            <div class="form-group m-b-20 focused">
                <label for="kategori">Nama Kategori :</label>
                <input type="text" class="form-control" name="kategori" id="kategori">
                <span class="help-block"><small id="errorKategori"></small></span>
            </div>
                
        <?php echo form_close(); ?>
    <!-- </form> -->
    <?php echo modalSaveClose("Simpan Kategori","modalBtnKategori"); ?>
    <!-- modal save close -->

    <!-- modal Delete -->
    <?php echo modalDeleteShow("modalDeleteKategori","Hapus Kategori","modalBtnDeleteKategori"); ?>
    <!-- end modal Delete -->

    <!-- modal save open -->
    <?php echo modalSaveOpen("modalFormUnit","sm","warning"); ?>
        <div id="inputMessage"></div>
        <!-- <form class="floating-labels m-t-40"> -->
        <?php echo form_open("",array("id" => "formDataUnit","class" => "form-material m-t-20")); ?>

            <div id="inputMessageUnit"></div>
            
            <div class="form-group m-b-20 focused">
                <label for="unit">Nama Unit / Satuan :</label>
                <input type="text" class="form-control" name="unit" id="unit">
                <span class="help-block"><small id="errorUnit"></small></span>
            </div>
                
        <?php echo form_close(); ?>
    <!-- </form> -->
    <?php echo modalSaveClose("Simpan Unit","modalBtnUnit"); ?>
    <!-- modal save close -->

    <!-- modal Delete -->
    <?php echo modalDeleteShow("modalDeleteUnit","Hapus Unit","modalBtnDeleteUnit"); ?>
    <!-- end modal Delete -->

<?php assets_script_master("produk_kategori.js"); ?>    
