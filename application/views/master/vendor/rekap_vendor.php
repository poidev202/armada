<!-- modal save open -->
<?php echo modalDetailOpen("modalRekapVendorProduk","lg","primary"); ?>
	
    <strong>Vendor : </strong><span class="text-muted" id="headerVendorProduk"></span>
    <hr style="margin-bottom: -10px; margin-top: 0px;">
    <div class="table-responsive">
        <table id="tblRekapVendorProduk" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
            <thead class="thead-brown">
                <tr>
                    <th>No</th>
                    <th>Kode Produk</th>
                    <th>Produk</th>
                    <th>Gudang</th>
                    <th>Sisa Saat Ini</th>
                </tr>
            </thead>
            <tbody style="size: 5px;"></tbody>
        </table>
    </div>
        
<?php echo modalDetailClose(); ?>