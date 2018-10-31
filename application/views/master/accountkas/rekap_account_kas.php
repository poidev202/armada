<!-- modal save open -->
<?php echo modalDetailOpen("modalRekapAccountKas","lg"); ?>
	
    <div class="row">
        <div class="col-md-3 col-xs-6 b-r"> <strong>Nama Account Kas :</strong>
            <br>
            <span class="text-muted" id="headerNamaAccountKas"></span>
        </div>
        <div class="col-md-3 col-xs-6 b-r"> <strong>No Telp :</strong>
            <br>
            <span class="text-muted" id="headerTelpAccountKas"></span>
        </div>
        <div class="col-md-6 col-xs-6 b-r"> <strong>Alamat :</strong>
            <br>
            <span class="text-muted" id="headerAlamatAccountKas"></span>
        </div>
    </div>
    <hr style="margin-bottom: -10px; margin-top: 0px;">
    <br>
    <strong>Saldo : </strong><span class="text-danger" id="headerSaldoAccountKas"></span>
    <hr style="margin-bottom: -10px; margin-top: 0px;">
    <div class="table-responsive">
        <table id="tblRekapAccountKas" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
            <thead class="thead-primary">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Status</th>
                    <th>Info Input</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody style="size: 5px;"></tbody>
        </table>
    </div>
        
<?php echo modalDetailClose(); ?>