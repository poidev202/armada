<!-- modal save open -->
<?php echo modalDetailOpen("modalRekapKategoriProduk","lg","info"); ?>
	
    <strong>Kategori : </strong><span class="text-muted" id="headerKategoriProduk"></span>
    <hr style="margin-bottom: -10px; margin-top: 0px;">
    <div class="table-responsive">
        <table id="tblRekapKategoriProduk" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
            <thead class="thead-maroon">
                <tr>
                    <th>No</th>
                    <th>Kode Produk</th>
                    <th>Produk</th>
                    <th>Gudang</th>
                    <th>Saldo Saat Ini</th>
                </tr>
            </thead>
            <tbody style="size: 5px;"></tbody>
        </table>
    </div>
        
<?php echo modalDetailClose(); ?>