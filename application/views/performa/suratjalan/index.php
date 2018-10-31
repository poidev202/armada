<div class="ribbon-wrapper card">
    <div class="ribbon ribbon-bookmark  ribbon-default">
    	Surat Jalan / Trip
    </div>
    <div class="ribbon-content">

    	<div id="formulirTable">
	        <ul class="nav nav-tabs m-t-20" id="myTab" role="tablist">
	            <li class="nav-item"> 
	            	<a class="nav-link active" id="form-tab" data-toggle="tab" href="#form" role="tab" aria-controls="form" aria-expanded="true">
	            		Formulir
	            	</a> 
	            </li>
	            <li class="nav-item"> 
	            	<a class="nav-link" id="table-tab" data-toggle="tab" href="#table" role="tab" aria-controls="table">
	            		Table Log Surat Jalan / Trip
	            	</a>
	            </li>
	            <li class="nav-item"> 
	            	<a class="nav-link" id="print-tab" data-toggle="tab" href="#printTab" role="tab" aria-controls="printTab">
	            		Print Surat Jalan / Trip
	            	</a>
	            </li>
	        </ul>
	        <div class="tab-content tabcontent-border p-20" id="myTabContent">
	            <div role="tabpanel" class="tab-pane fade show active" id="form" aria-labelledby="form-tab">
	            	<div id="dataFormulir">
			            <?php echo form_open("",array("id" => "formData","class" => "m-t-0")); ?>
			            	<div class="row">
			            		<div class="col-md-6">
			            			<div class="form-group m-b-5 focused">
									    <label>Tanggal Jadwal Trip :</label>
							            <input type="text" id="tgl_hari_jadwal" name="tgl_hari_jadwal" class="form-control tanggal">
									    <span class="help-block"><small id="errorJadwalTrip"></small></span>
									</div>
			            		</div>	
			            		<div class="col-md-2">
			            			<label>&nbsp;</label>
			            			<button class="btn btn-success" type="button" title="Proses Check Data Jadwal Trip" id="btnCheckJadwal">
				  						<i class='fa fa-check-square-o'></i> Check Jadwal
				  					</button>
			            		</div>
			            	</div>
			            	<br>
			            	<div id="errorTableTrip"></div>
			            	<div id="dataTableTrip" style="display: none;">
				            	<label><b><u>Trip : <span id="hariTglTrip"></span></u></b></label>
				            	<div class="table-responsive">
					            	<table class="table table-bordered table-sm table-striped">
		                                <thead class="">
		                                    <tr>
		                                    	<th>No</th>
		                                        <th>Jam</th>
		                                        <th>Tujuan</th>
		                                        <th width="30%">Armada</th>
		                                        <th width="30%">Supir 1</th>
		                                        <th width="30%">Supir 2</th>
		                                    </tr>
		                                </thead>
		                                <tbody id="trTrip">
		                                </tbody>
		                            </table>
				            	</div>
	                            <div class="text-left">
					                <button id="btnSimpanTrip" class="btn btn-outline-primary" type="button"> <span><i class="fa fa-save"></i> Simpan</span> </button>
					                &nbsp;&nbsp;&nbsp;&nbsp;
					                <button class="btn btn-outline-danger" id="btnCloseTrip" type="button"><i class="fa fa fa-window-close-o"></i> Batal</button>
					            </div>
			            	</div>
						<?php echo form_close(); ?>
			        </div>
	            </div>
	            <div class="tab-pane fade" id="table" role="tabpanel" aria-labelledby="table-tab">
	                <div class="table-responsive">
		                <table id="tblSuratJalan" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
		                    <thead class="thead-primary">
		                        <tr>
		                            <th>No</th>
		                            <th>Tanggal</th>
		                            <th>Nama Armada</th>
		                            <th>No Plat</th>
		                            <!-- <th>Kode Supir 1</th> -->
		                            <th>Nama Supir 1</th>
		                            <!-- <th>Kode Supir 2</th> -->
		                            <th>Nama Supir 2</th>
		                            <th>Hari</th>
		                            <th>Jam</th>
		                            <th>Berangkat</th>
		                            <th>Tujuan Akhir</th>
		                            <!-- <th>Action</th> -->
		                        </tr>
		                    </thead>
		                </table>
		            </div>
	            </div>
	            <div class="tab-pane fade" id="printTab" role="tabpanel" aria-labelledby="table-tab">
	            	<div class="row">
	            		<div class="col-md-4">
	            			<div class="form-group m-b-5 focused">
							    <label>Tanggal Trip :</label>
					            <input type="text" id="tgl_trip_print" name="tgl_trip_print" class="form-control tanggal">
							    <span class="help-block"><small id="errorTglTrip"></small></span>
							</div>
	            		</div>	
	            		<div class="col-md-2">
	            			<label>&nbsp;</label>
	            			<button class="btn btn-primary" type="button" title="Proses Check Data Jadwal Trip" id="btnCheckDataPrint">
		  						<i class='fa fa-check-square-o'></i> Check data
		  					</button>
	            		</div>
	            	</div>
	            	<br>
	            	<div id="errorPrintTrip"></div>
	            	<div id="dataPrintTrip" style="display: none;">
	            		<div class="card card-body printableAreaTrip">
			            	<label><b><u>Trip : <span id="hariPrintTglTrip"></span></u></b></label>
			            	<div class="table-responsive">
				            	<table class="table table-bordered table-sm table-striped">
	                                <thead class="">
	                                    <tr>
	                                    	<th>No</th>
	                                        <th>Jam</th>
	                                        <th>Tujuan</th>
	                                        <th>Armada</th>
	                                        <th>Supir 1</th>
	                                        <th>Supir 2</th>
	                                    </tr>
	                                </thead>
	                                <tbody id="trPrintTrip">
	                                </tbody>
	                            </table>
			            	</div>
	            		</div>
                        <div class="text-left">
			                <button id="btnPrintTrip" class="btn btn-outline-primary btn-print-trip" type="button"> <span><i class="fa fa-save"></i> Print</span> </button>
			                &nbsp;&nbsp;&nbsp;&nbsp;
			                <button class="btn btn-outline-danger" id="btnPrintCloseTrip" type="button"><i class="fa fa fa-window-close-o"></i> Batal</button>
			            </div>
	            	</div>
	            </div>
	        </div>
        </div>
        <!-- Print Surat jalan -->
        <div id="formulirPrintSurat" style="display: none;">
        	<div class="card card-body printableArea">
                <div class="row">
                    <div class="col-md-12">
                        <div class="">
                            <address>
                                <h3> &nbsp;<b class="text-danger">Surat Jalan Armada <span class="nama-perusahaan">PT. Rapi BUS</span></b></h3>
                                <p class="text-muted m-l-5">
                                	<table class="pull-right table-sm">
                                		<tr>
                                			<th id="printTanggal">09 July 2018</th>
                                		</tr>
                                	</table>
                                	<table class=" table-sm">
                                		<tr>
                                			<th>Nama Armada</th>
                                			<td>:</td>
                                			<td id="printNamaArmada">Fantter</td>
                                		</tr>
                                		<tr>
                                			<th>No Plat</th>
                                			<td>:</td>
                                			<td id="printNoPlat">BK3490JKL</td>
                                		</tr>
                                	</table>
                                	<hr>
                        			<div class="row">
                        				<div class="col-md-8">
                        					<table class="pull-left table-sm">
		                                		<tr>
		                                			<td><small>Kode Supir 1</small></td>
		                                			<td>:</td>
		                                			<td><small id="printKodeSupir1">KRY-12</small></td>
		                                		</tr>
		                                		<tr>
		                                			<td><small>Nama Supir 1</small></td>
		                                			<td>:</td>
		                                			<td><small id="printNamaSupir1">Cutno Manto</small></td>
		                                		</tr>
		                                	</table>
                        					<table class="pull-right table-sm">
		                                		<tr>
		                                			<td><small>Kode Supir 2</small></td>
		                                			<td>:</td>
		                                			<td><small id="printKodeSupir1">KRY-5</small></td>
		                                		</tr>
		                                		<tr>
		                                			<td><small>Nama Supir 2</small></td>
		                                			<td>:</td>
		                                			<td><small id="printNamaSupir2">Katmen Siregar</small></td>
		                                		</tr>
		                                	</table>
                        				</div>
                        			</div>
                                	<br>
				                    <div class="row">
				                    	<div class="col-md-4">
						                    &nbsp;<b><u>Jadwal Keberangkatan</u></b>
						                    <small>
							                    <br>&nbsp;&nbsp;&nbsp;Hari = <span id="printHari">Senin</span>
							                    <br>&nbsp;&nbsp;&nbsp;Jam  = <span id="printJam">09:00  </span>
					                    		<table class=" table-sm">
							                    	<tr>
							                    		<th><b>Berangkat</b></th>
							                    		<th>-></th>
							                    		<th><b>Tujuan Akhir</b></th>
							                    	</tr>
							                    	<tr>
							                    		<td id="printBerangkat">Medan</td>
							                    		<td>-></td>
							                    		<td id="printTujuanAkhir">Bengkulu</td>
							                    	</tr>
							                    </table>  
							                </small>
				                    	</div>
				                    </div>          
                                </p>
                            </address>
                        </div>
                        <div class="pull-right">
                            <address>
                            	<center>
                            		__________,___________________
                            		<br>
	                                Tanda Tangan 
	                                <br><br><br>
	                                ( <span id="printPenanggungJawab">Benjamin Setiawan</span> )
                            	</center>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-left">
                <button class="btn btn-outline-danger close-surat" type="button"><i class="fa fa fa-window-close-o"></i> Tutup </button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button id="print" class="btn btn-outline-primary btn-print" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
            </div>
        </div>
    </div>
</div>

<?php assets_script_performa("suratjalan.js"); ?>