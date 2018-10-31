    
    <div class="card card-outline-inverse">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Table Pengguna</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tblUsers" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                    <thead class="thead-primary">
                        <tr>
                            <th>No</th>
                            <th>Photo</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- modal save open -->
    <?php echo modalSaveOpen(false,"","primary"); ?>
        <div id="inputMessage"></div>
        <!-- <form class="floating-labels m-t-40"> -->
        <?php echo form_open("",array("id" => "formData","class" => "form-material m-t-20")); ?>

            <div id="inputMessage"></div>
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-outline-inverse">
                                    <div class="card-header">
                                        <h4 class="m-b-0 text-white">Photo</h4>
                                    </div>
                                    <div class="panel-body">
                                        <center>
                                            <img src="/assets/images/default/user_image.png" id="img_photo" class="img-responsive img-thumbnail" style="width:124px; height:100px; margin-top: 10px; margin-bottom: 6px;">
                                            <input name="photo" id="photo_user" type="file" style="display: none;">
                                            <input type="hidden" name="is_delete" id="id_delete" value="0">
                                            <br>
                                            <button type="button" id="ganti_photo" class="btn btn-sm btn-flat btn-info" title="pilih photo">
                                                <i class="fa fa-upload"></i>
                                            </button>
                                            <button type="button" id="hapus_photo" class="btn btn-sm btn-flat btn-danger" title="hapus photo">
                                                <i class="fa fa-times-circle"></i>
                                            </button>
                                        </center>
                                    </div>
                                    <span class="help-block"><small id="errorUpload"></small></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-b-20">
                        <label for="role">Role :</label>
                        <select class="form-control" name="role" id="role">
                        </select>
                        <span class="help-block"><small id="errorRole"></small></span>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group m-b-20 focused">
                        <label for="full_name">Nama Lengkap :</label>
                        <input type="text" class="form-control" name="full_name" id="full_name">
                        <span class="help-block"><small id="errorFullName"></small></span>
                    </div>
                    <div class="form-group m-b-20">
                        <label for="username">Username :</label>
                        <input type="text" class="form-control" name="username" id="username">
                        <span class="help-block"><small id="errorUsername"></small></span>
                    </div>
                    <div class="form-group m-b-20">
                        <label for="password">Password :</label>
                        <input type="password" class="form-control" name="password" id="password">
                        <span class="help-block"><small id="errorPassword"></small></span>
                    </div>
                    <div class="form-group m-b-20">
                        <label for="confirm_password">Confirm Password :</label>
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                        <span class="help-block"><small id="errorConfirmPassword"></small></span>
                    </div>
                </div>
            </div>
        <?php echo form_close(); ?>
    <!-- </form> -->
    <?php echo modalSaveClose(); ?>
    <!-- modal save close -->

    <!-- modal Delete -->
    <?php echo modalDeleteShow(); ?>
    <!-- end modal Delete -->

<?php assets_script_master("users.js"); ?>    
