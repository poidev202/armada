<div class="row">
    <!-- Column -->
    <div class="col-lg-4 col-xlg-3 col-md-5">
        <div class="card">
            <div class="card-body">
                <center class="m-t-30">
                    <img src="../assets/images/users/5.jpg" class="img-circle" id="img_photo_profile" style="width: 150px; height: 150px;">
                    <h4 class="card-title m-t-10 " id="nama_lengkap_profile_photo">Nama Lengkap</h4>
                    <h6 class="card-subtitle" id="role_profile">Level / Role</h6>
                    <hr>
                    <div class="row text-center justify-content-md-center">
                        <div class="col-4">
                            <button type="button" id="ganti_photo_profile" class="btn btn-flat btn-outline-info" title="pilih photo profile">
                                <i class="fa fa-upload"></i>
                            </button>
                        </div>
                        <div class="col-4">
                            <button type="button" id="hapus_photo_profile" class="btn btn-flat btn-outline-danger" title="hapus photo profile">
                                <i class="fa fa-times-circle"></i>
                            </button>
                        </div>
                    </div>
                    <hr>
                </center>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-8 col-xlg-9 col-md-7">
        <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs profile-tab" role="tablist">
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#settings" role="tab" aria-expanded="true">Settings</a> </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="settings" role="tabpanel" aria-expanded="true">
                    <div class="card-body">
                    <?php echo form_open("",array("id" => "formDataProfile","class" => "form-horizontal form-material")); ?>
                        <!-- <form class="form-horizontal form-material"> -->
                            <input name="photo" id="photo_profile" type="file" style="display: none;">
                            <input type="hidden" name="is_delete_profile" id="is_delete_profile" value="0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-email" class="col-md-12">Username :</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control form-control-line" name="username" id="username_profile" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-12">Nama Lengkap :</label>
                                        <div class="col-md-12">
                                            <input type="text" name="nama_lengkap" id="nama_lengkap_profile" class=" form-control form-control-line">
                                        </div>
                                    </div>
                                </div>
                            </div>   
                            <div class="form-group">
                                <label class="col-md-12">Password Lama :</label>
                                <div class="col-md-12">
                                    <input type="password" name="password_lama" id="password_lama_profile" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Password Baru :</label>
                                <div class="col-md-12">
                                    <input type="password" name="password_baru" id="password_baru_profile" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Confirm Password :</label>
                                <div class="col-md-12">
                                    <input type="password" name="confirm_password" id="confirm_password_profile" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="button" id="btnUpdateProfile" class="btn btn-success">Update Profile</button>
                                </div>
                            </div>
                        <!-- </form> -->
                    <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>

<?php assets_script_umum("profile.js"); ?>