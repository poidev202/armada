<div class="ribbon-wrapper card">
    <div class="ribbon ribbon-bookmark ribbon-default">
    	Table Pendapatan Supir
    </div>
    <div class="ribbon-content">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs customtab m-t-20" role="tablist">
            <li class="nav-item"> 
            	<a class="nav-link active" data-toggle="tab" href="#tabSupir1" id="tabClickSupir1" role="tab" aria-expanded="true">
            		Supir 1
            	</a> 
            </li>
            <li class="nav-item"> 
            	<a class="nav-link" data-toggle="tab" href="#tabSupir2" id="tabClickSupir2" role="tab" aria-expanded="false">
            		Supir 2
            	</a> 
            </li>
            <li class="nav-item">
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-success m-t-15' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="tabSupir1" role="tabpanel" aria-expanded="true">
               
            	<div id="dataTableSupir1" class="table-responsive">
	                <table id="tblSupir1" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
	                    <thead class="thead-primary">
	                        <tr>
	                            <th>No</th>
	                            <th>Photo</th>
	                            <th>Kode Supir 1</th>
	                            <th>Nama Supir 1</th>
	                            <th>No Telp/HP</th>
	                            <th>Alamat</th>
	                            <th>Action</th>
	                        </tr>
	                    </thead>
	                </table>
	            </div>

	            <div id="rekapProsesSupir1" style="display: none;">
	            	<div class="ribbon-wrapper card">
						<div class="ribbon ribbon-primary">
			                <i class='fa fa-list-alt'></i><span> Rekap Pendapatan Supir 1</span>
			            </div>
			            <div class="ribbon ribbon-corner ribbon-right ribbon-danger close-rekap-supir1">
			            	<div class="card-actions pull-right">
			                    <a class="btn-close close-rekap-supir1"><i class="ti-close"></i></a>
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
					                                	<img src="/assets/images/default/user_image.png" style="height: 150px;" id="photoRekapSupir1" alt="supir1 photo">
					                                    <div class="el-overlay">
					                                        <ul class="el-info">
					                                            <li>
					                                            	<a class="btn default btn-outline image-popup-vertical-fit" href="/assets/images/default/user_image.png" id="photoPopupRekapSupir1">
					                                            		<i class="icon-magnifier"></i>
					                                            	</a>
					                                            </li>
					                                        </ul>
					                                    </div>
					                                </div>
					                                <!-- <hr> -->
						                        	<small class="text-muted">Kode karyawan :</small>
					                                <h6 id="kodeRekapSupir1"></h6> 

						                        	<small class="text-muted">Nama karyawan :</small>
					                                <h6 id="namaRekapSupir1"></h6> 

					                                <small class="text-muted">Tempat Lahir :</small>
					                                <h6 id="tempatLahirRekapSupir1"></h6> 

					                                <small class="text-muted">Tanggal Lahir :</small>
					                                <h6 id="tanggalLahirRekapSupir1"></h6> 

					                                <small class="text-muted">Jabatan :</small>
					                                <h6 id="jabatanRekapSupir1"></h6> 

					                                <small class="text-muted">Telephon / HP :</small>
					                                <h6 id="noTelpRekapSupir1"></h6> 

					                                <small class="text-muted">Alamat :</small>
					                                <h6 id="alamatRekapSupir1"></h6>

					                            </div>
					                        </div>
					                    </div>
							        </div>
							        <div class="col-xlg-10 col-lg-9 col-md-8 bg-inverse b-1">
						                <div class="card m-t-20">
						                    <div class="card-body">
						                    	<div class="table-responsive">
									                <table id="tblPendapatanSupir1" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
									                    <thead class="thead-primary">
									                        <tr>
									                            <th>No</th>
									                            <th>Tanggal</th>
									                            <th>Nama Armada</th>
									                            <th>No Plat</th>
									                            <th>Hari</th>
									                            <th>Jam</th>
									                            <th>Berangkat</th>
									                            <th>Tujuan Akhir</th>
									                            <th>Uang Pendapatan</th>
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
		               			<button type="button" class="btn btn-outline-danger close-rekap-supir1"><i class="fa fa-window-close"></i> Tutup</button>
				            </div>
	             		</div>
					</div>
	            </div>

            </div>

            <div class="tab-pane" id="tabSupir2" role="tabpanel" aria-expanded="false">

            	<div id="dataTableSupir2" class="table-responsive">
	                <table id="tblSupir2" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
	                    <thead class="thead-success">
	                        <tr>
	                            <th>No</th>
	                            <th>Photo</th>
	                            <th>Kode Supir 2</th>
	                            <th>Nama Supir 2</th>
	                            <th>No Telp/HP</th>
	                            <th>Alamat</th>
	                            <th>Action</th>
	                        </tr>
	                    </thead>
	                </table>
	            </div>

	            <div id="rekapProsesSupir2" style="display: none;">
	            	<div class="ribbon-wrapper card">
						<div class="ribbon ribbon-success">
			                <i class='fa fa-list-alt'></i><span> Rekap Pendapatan Supir 2</span>
			            </div>
			            <div class="ribbon ribbon-corner ribbon-right ribbon-danger close-rekap-supir2">
			            	<div class="card-actions pull-right">
			                    <a class="btn-close close-rekap-supir2"><i class="ti-close"></i></a>
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
					                                	<img src="/assets/images/default/user_image.png" style="height: 150px;" id="photoRekapSupir2" alt="supir2 photo">
					                                    <div class="el-overlay">
					                                        <ul class="el-info">
					                                            <li>
					                                            	<a class="btn default btn-outline image-popup-vertical-fit" href="/assets/images/default/user_image.png" id="photoPopupRekapSupir2">
					                                            		<i class="icon-magnifier"></i>
					                                            	</a>
					                                            </li>
					                                        </ul>
					                                    </div>
					                                </div>
					                                <!-- <hr> -->
						                        	<small class="text-muted">Kode karyawan :</small>
					                                <h6 id="kodeRekapSupir2"></h6> 

						                        	<small class="text-muted">Nama karyawan :</small>
					                                <h6 id="namaRekapSupir2"></h6> 

					                                <small class="text-muted">Tempat Lahir :</small>
					                                <h6 id="tempatLahirRekapSupir2"></h6> 

					                                <small class="text-muted">Tanggal Lahir :</small>
					                                <h6 id="tanggalLahirRekapSupir2"></h6> 

					                                <small class="text-muted">Jabatan :</small>
					                                <h6 id="jabatanRekapSupir2"></h6> 

					                                <small class="text-muted">Telephon / HP :</small>
					                                <h6 id="noTelpRekapSupir2"></h6> 

					                                <small class="text-muted">Alamat :</small>
					                                <h6 id="alamatRekapSupir2"></h6>

					                            </div>
					                        </div>
					                    </div>
							        </div>
							        <div class="col-xlg-10 col-lg-9 col-md-8 bg-inverse b-1">
						                <div class="card m-t-20">
						                    <div class="card-body">
						                    	<div class="table-responsive">
									                <table id="tblPendapatanSupir2" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
									                    <thead class="thead-success">
									                        <tr>
									                            <th>No</th>
									                            <th>Tanggal</th>
									                            <th>Nama Armada</th>
									                            <th>No Plat</th>
									                            <th>Hari</th>
									                            <th>Jam</th>
									                            <th>Berangkat</th>
									                            <th>Tujuan Akhir</th>
									                            <th>Uang Pendapatan</th>
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
		               			<button type="button" class="btn btn-outline-danger close-rekap-supir2"><i class="fa fa-window-close"></i> Tutup</button>
				            </div>

	             		</div>
					</div>
	            </div>

        	</div>

        </div>

    </div>
</div>

<?php assets_script_laporan("supir.js"); ?>