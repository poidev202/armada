
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Table Armada Masuk ke Kasir </h4>
                <hr class="card-subtitle">
                <div class="table-responsive">
                    <table id="tblMasukBengkel" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
                        <thead class="thead-green">
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>No Plat/BK</th>
                                <th>Hijau</th>
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
                <h4 class="card-title">Table Armada Rusak Di jalan</h4>
                <hr class="card-subtitle">

                <div class="table-responsive">
                    <table id="tblRusakDijalan" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
                        <thead class="thead-info">
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>No Plat/BK</th>
                                <th>Biru</th>
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

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Table Armada Masuk ke Bengkel</h4>
            <hr class="card-subtitle">

            <div class="table-responsive">
                <table id="tblStandBy" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
                    <thead class="thead-primary">
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>No Plat/BK</th>
                            <th>Ungu</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
<?php assets_script_performa("bengkel.js"); ?>