	
	<div id="dataTable">
    	<div class="ribbon-wrapper card">
        	<div class="ribbon ribbon-bookmark  ribbon-primary">Table Master Karyawan, Karyawan</div>
	        <hr class="card-subtitle">
	        <br>
            <div class="table-responsive">
                <table id="tblMasterKaryawan" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                    <thead class="thead-navy">
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Kode</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Telepon</th>
                            <th>Jabatan</th>
                            <th>Status Kerja</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
	    </div>
	</div>

    <div id="formProses" style="display: none;">
        <div class="ribbon-wrapper card">
            <div class="ribbon ribbon-primary" id="ribbonTitle">
                <i id="iconForm" class='fa fa-plus'></i> <span id="titleForm">Empty title form</span>
            </div>
            <div class="ribbon ribbon-corner ribbon-right ribbon-danger">
                <div class="card-actions pull-right">
                    <a class="btn-close close-form"><i class="ti-close"></i></a>
                </div>
            </div>
            <div class="ribbon-content">

                <?php echo form_open("",array("id" => "formData","class" => "m-t-20")); ?>

                    <div id="inputMessage"></div>
                    <input type="hidden" name="id_kredit" id="id_kredit">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-b-5 m-t-10 focused">
                                <label for="nama_karyawan">Nama Karyawan :</label>
                                <input type="text" class="form-control" name="nama_karyawan" id="nama_karyawan">
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Foto Karyawan :</label>
                                        <div class="el-element-overlay">
                                            <div class="card">
                                                <div class="el-card-item">
                                                    <input name="foto_karyawan" id="foto_karyawan" type="file" style="display: none;">
                                                    <input type="hidden" name="is_delete_karyawan" id="is_delete_karyawan" value="0">

                                                    <div class="el-card-avatar el-overlay-1">
                                                        <img id="imgKaryawan" src="/assets/images/default/user_image.png" style="height: 160px;" class="img img-responsive" alt="Karyawan Photo" >
                                                        <div class="el-overlay scrl-dwn">
                                                            <ul class="el-info">
                                                                <li>
                                                                    <a class="btn default btn-sm btn-outline image-popup-vertical-fit" id="imgKaryawanPopup" href="/assets/images/default/user_image.png"><i class="icon-magnifier"></i></a>
                                                                </li>
                                                                <br><br>
                                                                <li>
                                                                    <a class="btn default btn-sm btn-outline" id="ganti_foto_karyawan" href="javascript:void(0);"><i class="icon-arrow-up-circle"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a class="btn default btn-sm btn-outline-danger" id="hapus_foto_karyawan" href="javascript:void(0);"><i class="icon-close"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="tempat_lahir">Tempat Lahir :</label><br>
                                        <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir">
                                    </div>
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="tanggal_lahir">Tanggal Lahir :</label><br>
                                        <input type="text" class="form-control tanggal" name="tanggal_lahir" id="tanggal_lahir">
                                    </div>
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="kelamin">Jenis Kelamin :</label><br>
                                        <select class="form-control selectpicker" data-style="form-control btn-secondary" name="kelamin" style="width: 100%;" id="kelamin" >
                                            <option value="">--Pilih Jenis Kelamin--</option>
                                            <option value="laki-laki">Laki-laki</option>
                                            <option value="perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">No Telp / HP :</label>
                                        <input type="text" class="form-control" name="no_telp" id="no_telp">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                         <label for="">Email :</label>
                                        <input type="text" class="form-control" name="email" id="email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="pendidikan">Pendidikan :</label><br>
                                        <select class="form-control selectpicker" data-style="form-control btn-secondary" name="pendidikan" style="width: 100%;" id="pendidikan" >
                                            <option value="">--Pilih Pendidikan--</option>
                                            <option value="s1">S1</option>
                                            <option value="d3">D3</option>
                                            <option value="d1">D1</option>
                                            <option value="sma">SMA</option>
                                            <option value="smp">SMP</option>
                                            <option value="sd">SD</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Kewarganegaraan :</label><br>
                                        <div class="demo-radio-button">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input name="kewarganegaraan" type="radio" value="wni" id="wni" class="with-gap radio-col-brown">
                                                    <label for="wni">WNI</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input name="kewarganegaraan" type="radio" value="wna" id="wna" class="with-gap radio-col-orange">
                                                    <label for="wna">WNA</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="agama">Agama :</label><br>
                                        <select class="form-control selectpicker" data-style="form-control btn-secondary" name="agama" style="width: 100%;" id="agama" >
                                            <option value="">--Pilih Agama--</option>
                                            <option value="islam">Islam</option>
                                            <option value="kristen_protestan">Kristen Protestan</option>
                                            <option value="kristen_katolik">Kristen Katolik</option>
                                            <option value="hindu">Hindu</option>
                                            <option value="buddha">Buddha</option>
                                            <option value="khonghucu">Khonghucu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Status Nikah :</label><br>
                                        <div class="demo-radio-button">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input name="status_nikah" type="radio" value="sudah_nikah" id="sudah_nikah" class="with-gap radio-col-red">
                                                    <label for="sudah_nikah">Sudah</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input name="status_nikah" type="radio" value="belum_nikah" id="belum_nikah" class="with-gap radio-col-light-blue">
                                                    <label for="belum_nikah">Belum</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="jabatan">Jabatan :</label><br>
                                        <select class="form-control select2" data-style="form-control btn-secondary" name="jabatan" style="width: 100%;" id="jabatan" >
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Status Kerja :</label><br>
                                        <div class="demo-radio-button">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input name="status_kerja" type="radio" value="aktif" id="aktif" class="with-gap radio-col-light-green">
                                                    <label for="aktif">Aktif</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input name="status_kerja" type="radio" value="tidak" id="tidak_aktif" class="with-gap radio-col-blue-grey">
                                                    <label for="tidak_aktif">Tidak Aktif</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Bank :</label>
                                        <select class="form-control select2" data-style="form-control btn-secondary" name="bank" style="width: 100%;" id="bank" >
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Atas Nama :</label>
                                        <input type="text" class="form-control" name="atas_nama" id="atas_nama">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                         <label for="">No Rekening :</label>
                                        <input type="number" min="0" class="form-control" name="no_rekening" id="no_rekening">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">NPWP :</label>
                                        <input type="number" min="0" class="form-control" name="npwp" id="npwp">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group m-b-5 m-t-10">
                                <label for="alamat">Alamat :</label>
                                <textarea class="form-control" name="alamat" id="alamat" rows="3" ></textarea>
                                <span class="help-block"><small id="errorAlamat"></small></span>
                            </div>
                        </div>

                        <!-- Tengah -->

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Periode Gaji :</label>
                                        <select class="form-control selectpicker" data-style="form-control btn-secondary" name="periode_gaji" style="width: 100%;" id="periode_gaji" >
                                            <option value="">--Pilih Periode--</option>
                                            <option value="bulanan">Bulanan</option>
                                            <option value="harian">harian</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Gaji :</label>
                                        <input type="number" min="0" class="form-control" name="gaji" id="gaji">
                                        <span class="help-block"><small id="hasil_matauang_gaji"></small></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Tanggal Masuk Kerja :</label>
                                        <input type="text" class="form-control tanggal" name="tgl_masuk_kerja" id="tgl_masuk_kerja">
                                        <span class="help-block"><small id="errorTglMasukKerja"></small></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Status Kontrak :</label>
                                        <div class="demo-radio-button">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input name="status_kontrak" type="radio" value="aktif" id="aktif_kontrak" class="with-gap radio-col-lime">
                                                    <label for="aktif_kontrak">Aktif</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input name="status_kontrak" type="radio" value="tidak" id="tidak_kontrak" class="with-gap radio-col-deep-purple">
                                                    <label for="tidak_kontrak">Tidak Kontrak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group m-b-5 m-t-10">
                                <label for="">Tanggal Awal dan Akhir Kontrak :</label>
                                <div class="input-daterange input-group m-b-5 m-t-10 date-range" id="">
                                    <input type="text" class="form-control" name="tgl_awal_kontrak" id="tgl_awal_kontrak" placeholder="Tanggal Awal">
                                    <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                    <input type="text" class="form-control" name="tgl_akhir_kontrak" id="tgl_akhir_kontrak" placeholder="Tanggal Akhir">
                                </div>
                            </div>
                            <hr>

                            <div class="form-group m-b-5 m-t-10">
                                <label>Foto Berkas Karyawan :</label>
                                <br>

                                <div class="row el-element-overlay">
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="el-card-item">
                                                <input name="foto_kk" id="foto_kk" type="file" style="display: none;">
                                                <input type="hidden" name="is_delete_kk" id="is_delete_kk" value="0">

                                                <div class="el-card-avatar el-overlay-1">
                                                    <img src="/assets/images/default/no_image.jpg" id="imgKK" alt="Kartu Keluarga" style="height: 160px;" />
                                                    <div class="el-overlay scrl-dwn">
                                                        <ul class="el-info">
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline image-popup-vertical-fit" id="imgKKpopup" href="/assets/images/default/no_image.jpg"><i class="icon-magnifier"></i></a>
                                                            </li>
                                                            <br><br>
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline" id="ganti_foto_kk" href="javascript:void(0);"><i class="icon-arrow-up-circle"></i></a>
                                                            </li>
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline-danger" id="hapus_foto_kk" href="javascript:void(0);"><i class="icon-close"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="el-card-content">
                                                    <b class="box-title">Kartu Keluarga</b> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="el-card-item">
                                                <input name="foto_surat_lamaran" id="foto_surat_lamaran" type="file" style="display: none;">
                                                <input type="hidden" name="is_delete_surat_lamaran" id="is_delete_surat_lamaran" value="0">

                                                <div class="el-card-avatar el-overlay-1">
                                                    <img src="/assets/images/default/no_image.jpg" id="imgSuratLamaran" alt="Kartu Keluarga" style="height: 160px;" />
                                                    <div class="el-overlay scrl-dwn">
                                                        <ul class="el-info">
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline image-popup-vertical-fit" id="imgSuratLamaranPopup" href="/assets/images/default/no_image.jpg"><i class="icon-magnifier"></i></a>
                                                            </li>
                                                            <br><br>
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline" id="ganti_foto_surat_lamaran" href="javascript:void(0);"><i class="icon-arrow-up-circle"></i></a>
                                                            </li>
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline-danger" id="hapus_foto_surat_lamaran" href="javascript:void(0);"><i class="icon-close"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="el-card-content">
                                                    <b class="box-title">Surat Lamaran</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="el-card-item">
                                                <input name="foto_test_urine" id="foto_test_urine" type="file" style="display: none;">
                                                <input type="hidden" name="is_delete_test_urine" id="is_delete_test_urine" value="0">

                                                <div class="el-card-avatar el-overlay-1">
                                                    <img src="/assets/images/default/no_image.jpg" id="imgTestUrine" alt="Kartu Keluarga" style="height: 160px;" />
                                                    <div class="el-overlay scrl-dwn">
                                                        <ul class="el-info">
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline image-popup-vertical-fit" id="imgTestUrinePopup" href="/assets/images/default/no_image.jpg"><i class="icon-magnifier"></i></a>
                                                            </li>
                                                            <br><br>
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline" id="ganti_foto_test_urine" href="javascript:void(0);"><i class="icon-arrow-up-circle"></i></a>
                                                            </li>
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline-danger" id="hapus_foto_test_urine" href="javascript:void(0);"><i class="icon-close"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="el-card-content">
                                                    <b class="box-title">Test Urine</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="el-element-overlay">
                                        <div class="card">
                                            <div class="el-card-item">
                                                <input name="foto_ktp" id="foto_ktp" type="file" style="display: none;">
                                                <input type="hidden" name="is_delete_ktp" id="is_delete_ktp" value="0">

                                                <div class="el-card-avatar el-overlay-1">
                                                    <img src="/assets/images/default/no_image.jpg" id="imgKtp" alt="Kartu Keluarga" style="height: 160px;" />
                                                    <div class="el-overlay scrl-dwn">
                                                        <ul class="el-info">
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline image-popup-vertical-fit" id="imgKtpPopup" href="/assets/images/default/no_image.jpg"><i class="icon-magnifier"></i></a>
                                                            </li>
                                                            <br><br>
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline" id="ganti_foto_ktp" href="javascript:void(0);"><i class="icon-arrow-up-circle"></i></a>
                                                            </li>
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline-danger" id="hapus_foto_ktp" href="javascript:void(0);"><i class="icon-close"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="el-card-content">
                                                    <b class="box-title">Foto KTP</b> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">No KTP :</label>
                                        <input type="number" min="0" class="form-control" name="no_ktp" id="no_ktp">
                                    </div>
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Bagian Dari Supir :</label><br>
                                        <div class="demo-radio-button">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input name="bagian_supir" type="radio" value="ya" id="ya_supir" class="with-gap radio-col-light-green">
                                                    <label for="ya_supir">Ya</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input name="bagian_supir" type="radio" value="tidak" id="tidak_supir" class="with-gap radio-col-blue-grey">
                                                    <label for="tidak_supir">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="el-element-overlay">
                                        <div class="card">
                                            <div class="el-card-item">
                                                <input name="foto_sim" id="foto_sim" type="file" style="display: none;">
                                                <input type="hidden" name="is_delete_sim" id="is_delete_sim" value="0">

                                                <div class="el-card-avatar el-overlay-1">
                                                    <img src="/assets/images/default/no_image.jpg" id="imgSim" alt="Kartu Keluarga" style="height: 160px;" />
                                                    <div class="el-overlay scrl-dwn">
                                                        <ul class="el-info">
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline image-popup-vertical-fit" id="imgSimPopup" href="/assets/images/default/no_image.jpg"><i class="icon-magnifier"></i></a>
                                                            </li>
                                                            <br><br>
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline" id="ganti_foto_sim" href="javascript:void(0);"><i class="icon-arrow-up-circle"></i></a>
                                                            </li>
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline-danger" id="hapus_foto_sim" href="javascript:void(0);"><i class="icon-close"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="el-card-content">
                                                    <b class="box-title">Foto SIM</b> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">No SIM :</label>
                                        <input type="number" min="0" class="form-control" name="no_sim" id="no_sim">
                                    </div>
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Jatuh Tempo SIM :</label>
                                        <input type="text" class="form-control tanggal" name="tgl_jatuh_tempo_sim" id="tgl_jatuh_tempo_sim">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="form-group m-b-5 m-t-10">
                        <button type="button" id="btnSimpan" class="btn btn-outline-info"><i class="fa fa-save"></i> Simpan</button>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-outline-danger close-form"><i class="fa fa-window-close"></i> Tutup</button>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <!-- modal detail -->
    <div id="formDetail" style="display: none;">
        <div class="card card-outline-info">
            <div class="card-header m-b-0 text-white">
                <i id="iconForm" class='fa fa-info'></i> <span id="titleForm">Detail Master Karyawan</span>  
                <div class="card-actions">
                    <a class="btn-close close-form"><i class="ti-close"></i></a>
                </div>
            </div>

            <div class="card-body collapse show">
                <form class="" role="form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10 focused">
                                        <label>Nama Karyawan :</label><br>
                                        <span class="help-block"><small id="detailNamaKaryawan"></small></span>
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10 focused">
                                        <label>Kode Karyawan :</label><br>
                                        <span class="help-block"><small id="detailKodeKaryawan"></small></span>
                                        <hr>
                                    </div>
                                </div>
                            </div>

                                    

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Foto Karyawan :</label>
                                        <div class="el-element-overlay">
                                            <div class="card">
                                                <div class="el-card-item">
                                                    <div class="el-card-avatar el-overlay-1">
                                                        <img id="detailImgKaryawan" src="/assets/images/default/user_image.png" style="height: 160px;" class="img img-responsive" alt="Karyawan Photo" >
                                                        <div class="el-overlay scrl-dwn">
                                                            <ul class="el-info">
                                                                <li>
                                                                    <a class="btn default btn-sm btn-outline image-popup-vertical-fit" id="detailImgKaryawanPopup" href="/assets/images/default/user_image.png"><i class="icon-magnifier"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label>Tempat Lahir :</label><br>
                                        <span class="help-block"><small id="detailTempatLahir"></small></span>
                                        <hr>
                                    </div>
                                    <div class="form-group m-b-5 m-t-10">
                                        <label>Tanggal Lahir :</label><br>
                                        <span class="help-block"><small id="detailTanggalLahir"></small></span>
                                        <hr>
                                    </div>
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="kelamin">Jenis Kelamin :</label><br>
                                        <span class="help-block"><small id="detailKelamin"></small></span>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">No Telp / HP :</label><br>
                                        <span class="help-block"><small id="detailNoTelp"></small></span>
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Email :</label><br>
                                        <span class="help-block"><small id="detailEmail"></small></span>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="pendidikan">Pendidikan :</label><br>
                                        <span class="help-block"><small id="detailPendidikan"></small></span>
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Kewarganegaraan :</label><br>
                                        <span class="help-block"><small id="detailKewarganegaraan"></small></span>
                                        <hr>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="agama">Agama :</label><br>
                                        <span class="help-block"><small id="detailAgama"></small></span>
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Status Nikah :</label><br>
                                        <span class="help-block"><small id="detailStatusNikah"></small></span>
                                        <hr>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="jabatan">Jabatan :</label><br>
                                        <span class="help-block"><small id="detailJabatan"></small></span>
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Status Kerja :</label><br>
                                        <span class="help-block"><small id="detailStatusKerja"></small></span>
                                        <hr>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Bank :</label><br>
                                        <span class="help-block"><small id="detailBank"></small></span>
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Atas Nama :</label><br>
                                        <span class="help-block"><small id="detailAtasNama"></small></span>
                                        <hr>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">No Rekening :</label><br>
                                        <span class="help-block"><small id="detailNoRekening"></small></span>
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">NPWP :</label><br>
                                        <span class="help-block"><small id="detailNPWP"></small></span>
                                        <hr>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group m-b-5 m-t-10">
                                <label>Alamat :</label><br>
                                <span class="help-block"><small id="detailAlamat"></small></span>
                                <hr>
                            </div>
                        </div>
                        <!-- Tengah -->
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Periode Gaji :</label><br>
                                        <span class="help-block"><small id="detailPeriodeGaji"></small></span>
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Gaji :</label><br>
                                        <span class="help-block"><small id="detailGaji"></small></span>
                                        <hr>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Tanggal Masuk Kerja :</label><br>
                                        <span class="help-block"><small id="detailTanggalMasuk"></small></span>
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Status Kontrak :</label><br>
                                        <span class="help-block"><small id="detailStatusKontrak"></small></span>
                                        <hr>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group m-b-5 m-t-10">
                                <label for="">Tanggal Awal dan Akhir Kontrak :</label>
                                <div class="input-daterange input-group m-b-5 m-t-10 date-range" id="">
                                    <span class="help-block"><small id="detailTglAwalKontrak"></small></span>
                                    &nbsp;&nbsp;
                                    <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                    &nbsp;&nbsp;
                                    <span class="help-block"><small id="detailTglAkhirKontrak"></small></span>
                                </div>
                            </div>
                            <hr>

                            <div class="form-group m-b-5 m-t-10">
                                <label>Foto Berkas Karyawan :</label>
                                <br>

                                <div class="row el-element-overlay">
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="el-card-item">
                                                <div class="el-card-avatar el-overlay-1">
                                                    <img src="/assets/images/default/no_image.jpg" id="detailImgKK" alt="Kartu Keluarga" style="height: 160px;" />
                                                    <div class="el-overlay scrl-dwn">
                                                        <ul class="el-info">
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline image-popup-vertical-fit" id="detailImgKKpopup" href="/assets/images/default/no_image.jpg"><i class="icon-magnifier"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="el-card-content">
                                                    <b class="box-title">Kartu Keluarga</b> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="el-card-item">
                                                <div class="el-card-avatar el-overlay-1">
                                                    <img src="/assets/images/default/no_image.jpg" id="detailImgLamaran" alt="Kartu Keluarga" style="height: 160px;" />
                                                    <div class="el-overlay scrl-dwn">
                                                        <ul class="el-info">
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline image-popup-vertical-fit" id="detailImgLamaranPopup" href="/assets/images/default/no_image.jpg"><i class="icon-magnifier"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="el-card-content">
                                                    <b class="box-title">Surat Lamaran</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="el-card-item">
                                                <div class="el-card-avatar el-overlay-1">
                                                    <img src="/assets/images/default/no_image.jpg" id="detailImgTestUrine" alt="Kartu Keluarga" style="height: 160px;" />
                                                    <div class="el-overlay scrl-dwn">
                                                        <ul class="el-info">
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline image-popup-vertical-fit" id="detailImgTestUrinePopup" href="/assets/images/default/no_image.jpg"><i class="icon-magnifier"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="el-card-content">
                                                    <b class="box-title">Test Urine</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="el-element-overlay">
                                        <div class="card">
                                            <div class="el-card-item">
                                                <div class="el-card-avatar el-overlay-1">
                                                    <img src="/assets/images/default/no_image.jpg" id="detailImgKtp" alt="Kartu Keluarga" style="height: 160px;" />
                                                    <div class="el-overlay scrl-dwn">
                                                        <ul class="el-info">
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline image-popup-vertical-fit" id="detailImgKtpPopup" href="/assets/images/default/no_image.jpg"><i class="icon-magnifier"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="el-card-content">
                                                    <b class="box-title">Foto KTP</b> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">No KTP :</label><br>
                                        <span class="help-block"><small id="detailNoKtp"></small></span>
                                        <hr>
                                    </div>
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Bagian Dari Supir :</label><br>
                                        <span class="help-block"><small id="detailBagianSupir"></small></span>
                                        <hr>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="el-element-overlay">
                                        <div class="card">
                                            <div class="el-card-item">
                                                <div class="el-card-avatar el-overlay-1">
                                                    <img src="/assets/images/default/no_image.jpg" id="detailImgSim" alt="Kartu Keluarga" style="height: 160px;" />
                                                    <div class="el-overlay scrl-dwn">
                                                        <ul class="el-info">
                                                            <li>
                                                                <a class="btn default btn-sm btn-outline image-popup-vertical-fit" id="detailImgSimPopup" href="/assets/images/default/no_image.jpg"><i class="icon-magnifier"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="el-card-content">
                                                    <b class="box-title">Foto SIM</b> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">No SIM :</label><br>
                                        <span class="help-block"><small id="detailNoSim"></small></span>
                                        <hr>
                                    </div>
                                    <div class="form-group m-b-5 m-t-10">
                                        <label for="">Jatuh Tempo SIM :</label><br>
                                        <span class="help-block"><small id="detailJatuhTempoSim"></small></span>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group m-b-5 m-t-10">
                        <button type="button" class="btn btn-outline-danger close-form"><i class="fa fa-window-close"></i> Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php assets_script_master("karyawan.js"); ?>   