<!-- modal save open -->
    <?php echo modalDetailOpen("modalRekapGudang","lg","info"); ?>
    	
    	<div class="row">
            <div class="col-md-3 col-xs-6 b-r"> <strong>Nama Gudang :</strong>
                <br>
                <span class="text-muted" id="headerNamaGudang">Gudang B</span>
            </div>
            <div class="col-md-3 col-xs-6 b-r"> <strong>No Telp :</strong>
                <br>
                <span class="text-muted" id="headerTelpGudang">(123) 456 7890</span>
            </div>
            <div class="col-md-6 col-xs-6 b-r"> <strong>Alamat :</strong>
                <br>
                <span class="text-muted" id="headerAlamatGudang">Jalan Sm Raja no 45</span>
            </div>
        </div>
        <hr style="margin-bottom: -10px; margin-top: 0px;">
        <div class="table-responsive">
            <table id="tblRekapGudang" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                <thead class="thead-success">
                    <tr>
                        <th>No</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Saldo Saat Ini</th>
                        <th>Saldo min</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody style="size: 5px;"></tbody>
            </table>
        </div>
	        
    <?php echo modalDetailClose(); ?>