<div class="card">
    <?php echo form_open("",array("id" => "formData","class" => "form-horizontal form-material")); ?>
    <div class="card-body">
        <h3 class="box-title m-b-0">Pengaturan Umum</h3>
        <div><hr></div>
        <div class="row m-t-40">
            <div class="col b-r text-center">
                <div class="card card-body">
                    <h4 class="box-title m-b-0">Logo Perusahaan</h4>
                    <div><hr></div>
                    <center>
                        <img src="../assets/images/users/4.jpg" alt="user" id="logo_perusahaan" class=" img-responsive" style="width: 100px; height: 100px;">
                    </center>
                    <div><hr></div>
                    <div class="row text-center justify-content-md-center">
                        <div class="col-4">
                            <button type="button" id="ganti_photo_logo" class="btn btn-flat btn-outline-info" title="pilih photo logo">
                                <i class="fa fa-upload"></i>
                            </button>
                        </div>
                        <div class="col-4">
                            <button type="button" id="hapus_photo_logo" class="btn btn-flat btn-outline-danger" title="hapus photo logo">
                                <i class="fa fa-times-circle"></i>
                            </button>
                        </div>
                    </div>
                    <div><hr></div>
                </div>
            </div>
            <div class="col b-r">
                <input name="logo" id="photo_logo" type="file" style="display: none;">
                <input type="hidden" name="is_delete" id="is_delete" value="0">
                <div class="form-group">
                    <label class="col-md-12">Nama perusahaan :</label>
                    <div class="col-md-12">
                        <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12">Telephone :</label>
                    <div class="col-md-12">
                        <input type="text" name="telephone" id="telephone" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12">Email :</label>
                    <div class="col-md-12">
                        <input type="email" name="email" id="email" class="form-control form-control-line">
                    </div>
                </div>
            </div>
            <div class="col ">
                <div class="form-group">
                    <label class="col-md-12">Alamat :</label>
                    <div class="col-md-12 m-t-20">
                        <textarea rows="3" name="alamat" id="alamat" class="form-control form-control-line"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <hr>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <button type="button" id="btnUpdateUmum" class="btn btn-primary">Update Umum</button>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?php assets_script_umum("index.js"); ?>