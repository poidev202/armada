	<div class="ribbon-wrapper card">
    	<div class="ribbon ribbon-bookmark  ribbon-default">Table Armada Status</div>
        <center>
            <!-- merah -->
            <i class="fa fa-check-square-o text-danger"></i> Stand By
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <!-- kuning -->
            <i class="fa fa-check-square-o" style="color:#f3bf06;"></i> Dijalan
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <!-- hijau -->
            <i class="fa fa-check-square-o" style="color:#32ef03;"></i> Kasir
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <!-- ungu -->
            <i class="fa fa-check-square-o" style="color:#9f07ec;"></i> Bengkel
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <!-- biru -->
            <i class="fa fa-check-square-o" style="color:blue;"></i> Rusak dijalan
        </center>

        <div class="table-responsive">
            <table id="tblArmadaStatus" class="table table-bordered table-striped table-hover" style="width: 100%">
                <thead class="thead-success">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>No Plat/BK</th>
                        <th>Merah</th>
                        <th>Kuning</th>
                        <th>Hijau</th>
                        <th>Ungu</th>
                        <th>Biru</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
<?php assets_script_performa("armadastatus.js"); ?>