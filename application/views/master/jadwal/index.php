
<style type="text/css">

    .popover {
        z-index: 9999;
    }

</style>

    <div class="ribbon-wrapper card">
        <div class="ribbon ribbon-bookmark  ribbon-default">Table Jadwal</div>
        <hr>
        <div class="vtabs">
            <ul class="nav nav-tabs tabs-vertical" role="tablist">
                <li class="nav-item"> 
                    <a class="nav-link active" data-toggle="tab" href="#senin" role="tab" aria-expanded="true">
                        Senin
                    </a> 
                </li>
                <li class="nav-item"> 
                    <a class="nav-link" data-toggle="tab" href="#selasa" role="tab" aria-expanded="false">
                        Selasa
                    </a> 
                </li>
                <li class="nav-item"> 
                    <a class="nav-link" data-toggle="tab" href="#rabu" role="tab" aria-expanded="false">
                        Rabu
                    </a> 
                </li>
                <li class="nav-item"> 
                    <a class="nav-link" data-toggle="tab" href="#kamis" role="tab" aria-expanded="false">
                        Kamis
                    </a> 
                </li>
                <li class="nav-item"> 
                    <a class="nav-link" data-toggle="tab" href="#jumat" role="tab" aria-expanded="false">
                        Jumat
                    </a> 
                </li>
                <li class="nav-item"> 
                    <a class="nav-link" data-toggle="tab" href="#sabtu" role="tab" aria-expanded="false">
                        Sabtu
                    </a> 
                </li>
                <li class="nav-item"> 
                    <a class="nav-link" data-toggle="tab" href="#minggu" role="tab" aria-expanded="false">
                        Minggu
                    </a> 
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content" style="padding-top: 0px;">

                <button type='button' class='btn btn-outline-info' id='btnTambah'><i class='fa fa-plus'></i> Tambah</button> &nbsp; &nbsp;
                <button type='button' class='btn btn-outline-success' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button>
                <hr>
                <div class="tab-pane active" id="senin" role="tabpanel" aria-expanded="true">
                    <div class="table-responsive">
                        <table id="tblSenin" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                            <thead class="thead-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Tujuan Awal</th>
                                    <th>Tujuan Akhir</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="selasa" role="tabpanel" aria-expanded="false">
                    <div class="table-responsive">
                        <table id="tblSelasa" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                            <thead class="thead-green">
                                <tr>
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Tujuan Awal</th>
                                    <th>Tujuan Akhir</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="rabu" role="tabpanel" aria-expanded="false">
                    <div class="table-responsive">
                        <table id="tblRabu" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                            <thead class="thead-success">
                                <tr>
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Tujuan Awal</th>
                                    <th>Tujuan Akhir</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="kamis" role="tabpanel" aria-expanded="false">
                    <div class="table-responsive">
                        <table id="tblKamis" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                            <thead class="thead-warning">
                                <tr>
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Tujuan Awal</th>
                                    <th>Tujuan Akhir</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="jumat" role="tabpanel" aria-expanded="false">
                    <div class="table-responsive">
                        <table id="tblJumat" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                            <thead class="thead-navy">
                                <tr>
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Tujuan Awal</th>
                                    <th>Tujuan Akhir</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="sabtu" role="tabpanel" aria-expanded="false">
                    <div class="table-responsive">
                        <table id="tblSabtu" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                            <thead class="thead-brown">
                                <tr>
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Tujuan Awal</th>
                                    <th>Tujuan Akhir</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="minggu" role="tabpanel" aria-expanded="false">
                    <div class="table-responsive">
                        <table id="tblMinggu" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                            <thead class="thead-danger">
                                <tr>
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Tujuan Awal</th>
                                    <th>Tujuan Akhir</th>
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
    </div>

        <!-- modal save open -->
    <?php echo modalSaveOpen(false,"","info"); ?>
        <div id="inputMessage"></div>
        <?php echo form_open("",array("id" => "formData","class" => "m-t-20")); ?>

            <div id="inputMessage"></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group m-b-5 m-t-10">
                        <label for="">Hari</label>
                        <select id="hari" name="hari" class="form-control select2" style="width: 100%">
                            <option value="">--Pilih Hari--</option>
                            <option value="senin">Senin</option>
                            <option value="selasa">Selasa</option>
                            <option value="rabu">Rabu</option>
                            <option value="kamis">Kamis</option>
                            <option value="jumat">Jumat</option>
                            <option value="sabtu">Sabtu</option>
                            <option value="minggu">Minggu</option>
                        </select>
                        <span class="help-block"><small id="errorHari"></small></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group m-b-5 m-t-10">
                        <label for="">Jam</label>

                        <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                            <input type="text" name="jam" id="jam" class="form-control" placeholder="Jam"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                        </div>

                        <span class="help-block"><small id="errorJam"></small></span>
                    </div>
                </div>
            </div>
            
            <div class="form-group m-b-5 m-t-10 focused">
                <label for="">Tujuan Awal :</label>
                <input type="text" class="form-control" name="tujuan_awal" id="tujuan_awal" placeholder="Tujuan Awal">
                <span class="help-block"><small id="errorTujuanAwal"></small></span>
            </div>

            <div class="form-group m-b-5 m-t-10">
                <label for="">Tujuan Akhir :</label>
                <input type="text" class="form-control" name="tujuan_akhir" id="tujuan_akhir" placeholder="Tujuan Akhir">
                <span class="help-block"><small id="errorTujuanAkhir"></small></span>
            </div>
                
                
        <?php echo form_close(); ?>
    <?php echo modalSaveClose(); ?>
    <!-- modal save close -->
            
<?php assets_script_master("jadwal.js"); ?>   