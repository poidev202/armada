<div class="card">
    <div class="card-body p-b-0">
        <h4 class="card-title">
            Table Laporan Armada
        </h4>
        <hr>

        <div id="dataTable" class="table-responsive">
            <table id="tblArmada" class="table table-bordered table-striped table-hover" style="width: 100%">
                <thead class="thead-primary">
                    <tr>
                        <th>No</th>
                        <th>Photo</th>
                        <th>Nama Armada</th>
                        <th>No BK / Plat</th>
                        <th>Tahun</th>
                        <th>Merk Chassis</th>
                        <th>Karoseri</th>
                        <th>Rekap</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div id="rekapProses" style="display: none;">
            <div class="ribbon-wrapper card">
                <div class="ribbon ribbon-success">
                    <i class='fa fa-list-alt'></i><span> Rekap Pendapatan Armada</span>
                </div>
                <div class="ribbon ribbon-corner ribbon-right ribbon-danger close-rekap">
                    <div class="card-actions pull-right">
                        <a class="btn-close close-rekap"><i class="ti-close"></i></a>
                    </div>
                </div>
                <div class="ribbon-content">

                    <div class="card m-t-15">
                        <div class="row">
                            <div class="col-xlg-2 col-lg-3 col-md-4">
                                <div class="card-body inbox-panel">
                                    <div class="el-element-overlay">
                                        <div class="el-card-item">
                                            <div class="el-card-avatar el-overlay-1"> 
                                                <img src="/assets/images/default/no_image.jpg" style="height: 150px;" id="photoRekapArmada" alt="Armada photo">
                                                <div class="el-overlay">
                                                    <ul class="el-info">
                                                        <li>
                                                            <a class="btn default btn-outline image-popup-vertical-fit" href="/assets/images/default/no_image.jpg" id="photoPopupRekapArmada">
                                                                <i class="icon-magnifier"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- <hr> -->
                                            <small class="text-muted">Nama Armada :</small>
                                            <h6 id="namaArmadaRekap"></h6> 

                                            <small class="text-muted">No Plat / BK :</small>
                                            <h6 id="noBkRekap"></h6> 

                                            <small class="text-muted">Tahun :</small>
                                            <h6 id="tahunArmadaRekap"></h6> 

                                            <small class="text-muted">Merk Chassis :</small>
                                            <h6 id="merkChassisRekap"></h6> 

                                            <small class="text-muted">Karoseri :</small>
                                            <h6 id="karoseriRekap"></h6>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xlg-10 col-lg-9 col-md-8 bg-success b-1">
                                <div class="card m-t-20">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tblPendapatan" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
                                                <thead class="thead-primary">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tgl Input</th>
                                                        <th>Hari</th>
                                                        <th>Jam</th>
                                                        <th>Berangkat</th>
                                                        <th>Tujuan Akhir</th>
                                                        <th>Tgl surat jalan </th>
                                                        <th>Uang Pendapatan</th>
                                                        <th>Account Kas</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <hr>
                    <div class="form-group">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-outline-danger close-rekap"><i class="fa fa-window-close"></i> Tutup</button>
                    </div>

                </div>
            </div>
        </div>

        <div id="rekapPemakaian" style="display: none;">
            <div class="ribbon-wrapper card">
                <div class="ribbon ribbon-default">
                    <i class='fa fa-list-alt'></i><span> Rekap Pemakaian Armada</span>
                </div>
                <div class="ribbon ribbon-corner ribbon-right ribbon-danger close-rekap">
                    <div class="card-actions pull-right">
                        <a class="btn-close close-rekap"><i class="ti-close"></i></a>
                    </div>
                </div>
                <div class="ribbon-content">

                    <div class="card m-t-15">
                        <div class="row">
                            <div class="col-xlg-2 col-lg-3 col-md-4">
                                <div class="card-body inbox-panel">
                                    <div class="el-element-overlay">
                                        <div class="el-card-item">
                                            <div class="el-card-avatar el-overlay-1"> 
                                                <img src="/assets/images/default/no_image.jpg" style="height: 150px;" id="photoPemakaianArmada" alt="Armada photo">
                                                <div class="el-overlay">
                                                    <ul class="el-info">
                                                        <li>
                                                            <a class="btn default btn-outline image-popup-vertical-fit" href="/assets/images/default/no_image.jpg" id="photoPopupPemakaianArmada">
                                                                <i class="icon-magnifier"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- <hr> -->
                                            <small class="text-muted">Nama Armada :</small>
                                            <h6 id="namaArmadaPemakaian"></h6> 

                                            <small class="text-muted">No Plat / BK :</small>
                                            <h6 id="noBkPemakaian"></h6> 

                                            <small class="text-muted">Tahun :</small>
                                            <h6 id="tahunArmadaPemakaian"></h6> 

                                            <small class="text-muted">Merk Chassis :</small>
                                            <h6 id="merkChassisPemakaian"></h6> 

                                            <small class="text-muted">Karoseri :</small>
                                            <h6 id="karoseriPemakaian"></h6>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xlg-10 col-lg-9 col-md-8 bg-inverse b-1">
                                <div class="card m-t-20">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tblPemakaian" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
                                                <thead class="thead-primary">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Kode Produk</th>
                                                        <th>Nama Produk</th>
                                                        <th>Gudang</th>
                                                        <th>Unit</th>
                                                        <th>Harga Jual</th>
                                                        <th>Jumlah</th>
                                                        <th>Harga Total</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <hr>
                    <div class="form-group">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-outline-danger close-rekap"><i class="fa fa-window-close"></i> Tutup</button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<?php assets_script_laporan("armada.js"); ?>