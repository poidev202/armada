<style type="text/css">

    /*.ct-series-b .ct-bar {
        stroke: #26dad2;
    }*/
    .ct-bar {
        fill: none;
        stroke-width: 20px;
    }

    #pendapatanArmadaPerTahun, .ct-series-a .ct-bar, .ct-series-a .ct-line, .ct-series-a .ct-point, .ct-series-a .ct-slice-donut {
        /*stroke: #1976d2;*/
        stroke: #26dad2;
    }

    .ct-label, .ct-vertical, .ct-start {
        color: black;
    }

    .el-element-overlay .el-card-item {
        position: relative;
        padding-bottom: 12px;
    }

    h5 {
        line-height: 0px;
        font-size: 15px;
        font-weight: 400;
    }

</style>

    <div class="progress">
        <div class="progress-bar bg-success" role="progressbar" style="width: 100%; height: 2px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="row page-titles">
        <div class="col-md-5">
            <h3 class="text-themecolor m-b-0 m-t-0">
                Pendapatan Armada
            </h3>
        </div>
        <div class="col-md-7">
            <div class="row ">
                <div class="col-md-6">
                    <div class="chart-text pull-right">
                        <h6 class="m-b-0"><small><u>TOTAL PER TAHUN</u></small></h6>
                        <h4 class="m-t-0 text-info" id="totalPerTahun">Rp. 0</h4>
                    </div>
                </div>
                <!-- <div class="col-md-6">
                    <div class="chart-text pull-right">
                        <h6 class="m-b-0"><small><u>TOTAL KESELURUHAN</u></small></h6>
                        <h4 class="m-t-0 text-primary">Rp. 1.248.233.356</h4>
                    </div>
                </div> -->
            </div>
        </div>
    </div>

    <div class="card">
        <div class="progress">
            <div class="progress-bar bg-success" role="progressbar" style="width: 100%; height: 2px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="card-body">
            <form action="#" class="form-horizontal">
                <div class="form-body">
                    <div class="form-group row">
                        <label class="control-label col-md-4"><b>Chart Pendapatan Armada Per Tahun</b></label>
                        <div class="col-md-2">
                            <select class="form-control custom-select" name="tahunChart" id="tahunChart" style="display: none;">
                                <!-- <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option> -->
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            
            <div class="m-t-40" id="pendapatanArmadaPerTahun" style="height: 335px;"></div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="progress">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; height: 2px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="card-body">
                    <h5 class="">Expired STNK Armada</h5>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; height: 2px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="card-body">
                    <a href="javascript:void(0);" id="stnk_1bulan">
                        <h6>Sisa 1 bulan : <b><span class="label label-light-primary" id="value_stnk_1bulan">0</span></b> Armada</h6>
                    </a>
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%; height: 1px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <br>
                    <a href="javascript:void(0);" id="stnk_2bulan">
                        <h6>Sisa 2 bulan : <b><span class="label label-light-primary" id="value_stnk_2bulan">0</span></b> Armada</h6>
                    </a>
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%; height: 1px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <br>
                    <a href="javascript:void(0);" id="stnk_3bulan">
                        <h6>Sisa 3 bulan : <b><span class="label label-light-primary" id="value_stnk_3bulan">0</span></b> Armada</h6>
                    </a>
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%; height: 1px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <br>
                    <a href="javascript:void(0);" id="stnk_expire">
                        <h6>Expire STNK : <b><span class="label label-light-warning" id="value_stnk_expire">0</span></b> Armada</h6>
                    </a>
                </div>
            </div>

            <?php echo modalDetailOpen("stnkExpireModal","lg","primary"); ?>

                <table id="tblExpireSTNKArmada" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
                    <thead class="thead-success">
                        <tr>
                            <th>No</th>
                            <th>Tanggal STNK</th>
                            <th>Photo</th>
                            <th>Nama Armada</th>
                            <th>No BK / Plat</th>
                        </tr>
                    </thead>
                </table>

            <?php echo modalDetailClose(); ?>

        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="progress">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%; height: 2px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="card-body">
                    <h5 class="">Expired SIM Supir</h5>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%; height: 2px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="card-body">
                    <a href="javascript:void(0);" id="sim_1bulan">
                        <h6>Sisa 1 bulan : <b><span class="label label-light-danger" id="value_sim_1bulan">0</span></b> Supir</h6>
                    </a>
                    <div class="progress">
                        <div class="progress-bar bg-warning role="progressbar" style="width: 100%; height: 1px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <br>
                    <a href="javascript:void(0);" id="sim_2bulan">
                        <h6>Sisa 2 bulan : <b><span class="label label-light-danger" id="value_sim_2bulan">0</span></b> Supir</h6>
                    </a>
                    <div class="progress">
                        <div class="progress-bar bg-warning role="progressbar" style="width: 100%; height: 1px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <br>
                    <a href="javascript:void(0);" id="sim_3bulan">
                        <h6>Sisa 3 bulan : <b><span class="label label-light-danger" id="value_sim_3bulan">0</span></b> Supir</h6>
                    </a>
                    <div class="progress">
                        <div class="progress-bar bg-warning role="progressbar" style="width: 100%; height: 1px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <br>
                    <a href="javascript:void(0);" id="sim_expire">
                        <h6>Expire SIM : <b><span class="label label-light-warning" id="value_sim_expire">0</span></b> Supir</h6>
                    </a>
                </div>
            </div>

            <?php echo modalDetailOpen("simExpireModal","lg","danger"); ?>

                <table id="tblExpireSIM" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
                    <thead class="thead-success">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Jatuh Tempo</th>
                            <th>Photo</th>
                            <th>Kode Karyawan</th>
                            <th>Nama Supir</th>
                        </tr>
                    </thead>
                </table>

            <?php echo modalDetailClose(); ?>

        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="progress">
                    <div class="progress-bar bg-inverse" role="progressbar" style="width: 100%; height: 2px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="card-body">
                    <h5 class="">Expired Kontrak Karyawan</h5>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-inverse" role="progressbar" style="width: 100%; height: 2px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="card-body">
                    <a href="javascript:void(0);" id="kontrak_1bulan">
                        <h6>Sisa 1 bulan : <b><span class="label label-light-inverse" id="value_kontrak_1bulan">0</span></b> Orang</h6>
                    </a>
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%; height: 1px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <br>
                    <a href="javascript:void(0);" id="kontrak_2bulan">
                        <h6>Sisa 2 bulan : <b><span class="label label-light-inverse" id="value_kontrak_2bulan">0</span></b> Orang</h6>
                    </a>
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%; height: 1px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <br>
                    <a href="javascript:void(0);" id="kontrak_3bulan">
                        <h6>Sisa 3 bulan : <b><span class="label label-light-inverse" id="value_kontrak_3bulan">0</span></b> Orang</h6>
                    </a>
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%; height: 1px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <br>
                    <a href="javascript:void(0);" id="kontrak_expire">
                        <h6>Expire kontrak : <b><span class="label label-light-warning" id="value_kontrak_expire">0</span></b> Orang</h6>
                    </a>
                </div>
            </div>
            <?php echo modalDetailOpen("kontrakExpireModal","lg"); ?>

                <table id="tblExpireKontrak" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
                    <thead class="thead-success">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Akhir Kontrak</th>
                            <th>Photo</th>
                            <th>Kode Karyawan</th>
                            <th>Nama Supir</th>
                        </tr>
                    </thead>
                </table>

            <?php echo modalDetailClose(); ?>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="progress">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%; height: 2px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="card-body">
                    <h5 class="">Ulang Tahun Karyawan</h5>
                </div>
                <div class="progress m-b-30">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%; height: 2px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div id="showAllUltah"></div>

            </div> 
        </div>
    </div>
            
    <?php assets_script_dashboard("pendapatan_armada.js"); ?>
    <?php assets_script_dashboard("modal_dashboard.js"); ?>