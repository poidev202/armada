<!-- modal save open -->
    <?php echo modalDetailOpen("modalRekapProduk","lg","info"); ?>
    	
    	<div class="row">
            <div class="col-md-3 col-xs-6 b-r"> <strong>Kode Produk :</strong>
                <br>
                <span class="text-muted" id="headerKodeProduk"></span>
            </div>
            <div class="col-md-9 col-xs-6 b-r"> <strong>Nama Produk :</strong>
                <br>
                <span class="text-muted" id="headerNamaProduk"></span>
            </div>
        </div>
        <hr style="margin-bottom: -10px; margin-top: 0px;">
        <div class="table-responsive">
            <table id="tblRekapProduk" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
                <thead class="thead-navy">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <!-- <th>Harga_Unit</th> -->
                        <th>Gudang</th>
                        <th>Sisa Saldo</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody style="size: 5px;"></tbody>
            </table>
        </div>
	        
    <?php echo modalDetailClose(); ?>