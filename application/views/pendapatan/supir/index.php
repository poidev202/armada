<div class="ribbon-wrapper card">
    <div class="ribbon ribbon-bookmark  ribbon-primary">
    	Pendapatan Supir
    </div>
    <div class="ribbon-content">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs customtab m-t-20" role="tablist">
            <li class="nav-item"> 
            	<a class="nav-link active" data-toggle="tab" href="#home2" role="tab" aria-expanded="true">
            		Supir 1
            	</a> 
            </li>
            <li class="nav-item"> 
            	<a class="nav-link" data-toggle="tab" href="#profile2" role="tab" aria-expanded="false">
            		Supir 2
            	</a> 
            </li>
            <li class="nav-item">
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-success m-t-15' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="home2" role="tabpanel" aria-expanded="true">
                <div id="dataTableSupir1" class="table-responsive">
	                <table id="tblSupir1" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
	                    <thead class="thead-info">
	                        <tr>
	                            <th>No</th>
	                            <th>Tgl Input</th>
	                            <th>Kode Supir 1</th>
	                            <th>Nama Supir 1</th>
	                            <th>Nama Armada</th>
	                            <th>No Plat</th>
	                            <th>Tgl surat jalan</th>
	                            <th>Hari</th>
	                            <th>Jam</th>
	                            <th>Berangkat</th>
	                            <th>Tujuan Akhir</th>
	                            <th>Uang pendapatan</th>
	                            <!-- <th>Action</th> -->
	                        </tr>
	                    </thead>
	                </table>
	            </div>

	            <div id="formProsesSupir1" style="display: none;">
	            	<div class="ribbon-wrapper card">
						<div class="ribbon ribbon-primary">
			                <i class='fa fa-list-alt'></i><span> Input Pendapatan Supir 1</span>
			            </div>
			            <div class="ribbon ribbon-corner ribbon-right ribbon-danger">
			            	<div class="card-actions pull-right">
			                    <a class="btn-close close-form-supir1"><i class="ti-close"></i></a>
			                </div>
			            </div>
						<div class="ribbon-content">
							<?php echo form_open("",array("id" => "formData1","class" => "m-t-10")); ?>
					    		<div class="row">
					    			<div class="col-md-6">
					    				<div class="row">
					    					<div class="col-md-7">
					    						<div class="form-group m-b-5 m-t-10">
									                <label for="supir1">Nama Supir 1 :</label>
											        <select id="supir1" name="supir1" class="form-control select2" style="width: 100%">
											        </select>
									                <span class="help-block"><small id="errorSupir1"></small></span>
									            </div>
									            <div class="form-group m-b-5 m-t-10">
									            	<label>Kode karyawan : </label>
											        <input type="text" id="kode_supir1" readonly class="form-control">
									            </div>
					    					</div>
					    					<div class="col-md-5">
					    						<div class="form-group m-b-5 m-t-0">
									                <label for="">Photo Supir 1 :</label>
				                                    <div class="el-element-overlay">
				                                        <div class="card">
				                                            <div class="el-card-item">
				                                                <div class="el-card-avatar el-overlay-1">
				                                                	<center>
				                                                		<img id="imgSupir1" src="/assets/images/default/user_image.png" style="height: 90px; width: 120px;" class="img img-responsive" alt="Karyawan Supir 1 Photo" >
				                                                	</center>
				                                                    <div class="el-overlay scrl-dwn">
				                                                        <ul class="el-info">
				                                                            <li>
				                                                                <a class="btn default btn-sm btn-outline image-popup-vertical-fit" id="imgSupir1Popup" href="/assets/images/default/user_image.png"><i class="icon-magnifier"></i></a>
				                                                            </li>
				                                                        </ul>
				                                                    </div>
				                                                </div>
				                                                
				                                            </div>
				                                        </div>
				                                    </div>
						                        </div>
					    					</div>
					    				</div>
							    				
					    				<div class="form-group m-b-5 focused">
										    <label for="nama_armada1">Nama Armada :</label>
			                                <select id="nama_armada1" name="nama_armada1" class="form-control select2" style="width: 100%"></select>
										    <span class="help-block"><small id="errorNamaArmada1"></small></span>
					    				</div>
							            <div class="row">
							            	<div class="col-md-5">
							            		<div class="form-group m-b-5 m-t-10">
									            	<label for="">Photo Armada :</label>
						                            <div class="el-element-overlay">
				                                        <div class="card">
				                                            <div class="el-card-item">
				                                                <div class="el-card-avatar el-overlay-1">
				                                                	<center>
				                                                		<img id="imgArmada1" src="/assets/images/default/no_image.jpg" style="height: 120px; width: 120px;" class="img img-responsive" alt="Armada Photo" >
				                                                	</center>
				                                                    <div class="el-overlay scrl-dwn">
				                                                        <ul class="el-info">
				                                                            <li>
				                                                                <a class="btn default btn-sm btn-outline image-popup-vertical-fit" id="imgArmada1Popup" href="/assets/images/default/no_image.jpg"><i class="icon-magnifier"></i></a>
				                                                            </li>
				                                                        </ul>
				                                                    </div>
				                                                </div>
				                                            </div>
				                                        </div>
				                                    </div>
					                            </div>
							            	</div>
							            	<div class="col-md-7">
							            		<div class="form-group m-b-5 m-t-10">
									                <label for="no_bk1">No BK / Plat :</label><br>
									                <input type="text" class="form-control" readonly id="no_bk1">
									            </div>
									            <div class="form-group m-b-5 m-t-10">
									                <label for="tahun1">Tahun :</label><br>
									                <input type="text" class="form-control" readonly id="tahun1">
									            </div>
							            	</div>
							            </div>
					    			</div>
					    			<div class="col-md-6">
					    				
			    						<div class="form-group m-b-5">
							                <label for="">Tanggal Surat jalan :</label>
					                		<select id="tgl_surat_jalan1" name="tgl_surat_jalan1" class="form-control select2" style="width: 100%"></select>
							                <span class="help-block"><small id="errorTglSuratJalan1"></small></span>
							            </div>
					    				
										<br>	
					    				<div class="card">
				                            <div class="card-header">
				                                Jadwal Keberangkatan :
				                            </div>
				                            <div class="card-body">
									    		<div class="row">
									            	<div class="col-md-6">
									            		<div class="form-group m-b-5 ">
											                <label for="berangkat1">Berangkat :</label>
													        <input type="text" id="berangkat1" class="form-control" readonly>
											            </div>
									            	</div>
									            	<div class="col-md-6">
									            		<div class="form-group m-b-5 ">
											                <label for="tujuan1">Tujuan :</label>
													        <input type="text" id="tujuan1" class="form-control" readonly>
											            </div>
									            	</div>
									            </div>
									            <div class="form-group m-b-5">
									                <label for="">Nama Penanggung jawab :</label>
							                		<input type="text" class="form-control" readonly id="penanggung_jawab1">
									            </div>
				                            </div>
				                        </div>  
										<div class="row">
					    					<div class="col-md-5">
					    						<div class="form-group m-b-5">
									                <label for="">Tanggal Input :</label>
									                <input type="text" class="form-control tanggal" name="tanggal_input1" id="tanggal_input1">
									            </div>
					    					</div>
					    					<div class="col-md-7">
					    						<div class="form-group m-b-5">
									                <label for="">Jumlah uang pendapatan :</label>
							                		<input type="number" class="form-control" min="0" name="uang_pendapatan1" id="uang_pendapatan1">
									                <span class="help-block"><small id="mata_uang_pendapatan1"></small></span>
									            </div>
					    					</div>
					    				</div>
					    			</div>
					    		</div>
							<?php echo form_close(); ?>
				            <hr>
				            <div class="form-group">
				                <button type="button" id="btnInput1" class="btn btn-outline-primary"><i class="fa fa-save"></i> Simpan</button>
				                &nbsp;&nbsp;&nbsp;&nbsp;
		               			<button type="button" class="btn btn-outline-danger close-form-supir1"><i class="fa fa-window-close"></i> Tutup</button>
				            </div>
	             		</div>
					</div>
	            </div>
            </div>
            <div class="tab-pane" id="profile2" role="tabpanel" aria-expanded="false">
            	<div id="dataTableSupir2" class="table-responsive">
	                <table id="tblSupir2" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
	                    <thead class="thead-warning">
	                        <tr>
	                            <th>No</th>
	                            <th>Tgl Input</th>
	                            <th>Kode Supir 2</th>
	                            <th>Nama Supir 2</th>
	                            <th>Nama Armada</th>
	                            <th>No Plat</th>
	                            <th>Tgl surat jalan</th>
	                            <th>Hari</th>
	                            <th>Jam</th>
	                            <th>Berangkat</th>
	                            <th>Tujuan Akhir</th>
	                            <th>Uang pendapatan</th>
	                            <!-- <th>Action</th> -->
	                        </tr>
	                    </thead>
	                </table>
	            </div>

	            <div id="formProsesSupir2" style="display: none;">
	            	<div class="ribbon-wrapper card">
						<div class="ribbon ribbon-default">
			                <i class='fa fa-list-alt'></i><span> Input Pendapatan Supir 2</span>
			            </div>
			            <div class="ribbon ribbon-corner ribbon-right ribbon-danger">
			            	<div class="card-actions pull-right">
			                    <a class="btn-close close-form-supir2"><i class="ti-close"></i></a>
			                </div>
			            </div>
						<div class="ribbon-content">

							<?php echo form_open("",array("id" => "formData2","class" => "m-t-10")); ?>
					    		<div class="row">
					    			<div class="col-md-6">
					    				<div class="row">
					    					<div class="col-md-5">
					    						<div class="form-group m-b-5 m-t-0">
									                <label for="">Photo Supir 2 :</label>
				                                    <div class="el-element-overlay">
				                                        <div class="card">
				                                            <div class="el-card-item">
				                                                <div class="el-card-avatar el-overlay-1">
				                                                	<center>
				                                                		<img id="imgSupir2" src="/assets/images/default/user_image.png" style="height: 90px; width: 120px;" class="img img-responsive" alt="Karyawan Supir 2 Photo" >
				                                                	</center>
				                                                    <div class="el-overlay scrl-dwn">
				                                                        <ul class="el-info">
				                                                            <li>
				                                                                <a class="btn default btn-sm btn-outline image-popup-vertical-fit" id="imgSupir2Popup" href="/assets/images/default/user_image.png"><i class="icon-magnifier"></i></a>
				                                                            </li>
				                                                        </ul>
				                                                    </div>
				                                                </div>
				                                                
				                                            </div>
				                                        </div>
				                                    </div>
						                        </div>
					    					</div>
					    					<div class="col-md-7">
					    						<div class="form-group m-b-5 m-t-10">
									                <label for="supir2">Nama Supir 2 :</label>
											        <select id="supir2" name="supir2" class="form-control select2" style="width: 100%">
											        </select>
									                <span class="help-block"><small id="errorSupir2"></small></span>
									            </div>
									            <div class="form-group m-b-5 m-t-10">
									            	<label>Kode karyawan : </label>
											        <input type="text" id="kode_supir2" readonly class="form-control">
									            </div>
					    					</div>
					    				</div>
							    				
					    				<div class="form-group m-b-5 focused">
										    <label for="nama_armada2">Nama Armada :</label>
			                                <select id="nama_armada2" name="nama_armada2" class="form-control select2" style="width: 100%"></select>
										    <span class="help-block"><small id="errorNamaArmada2"></small></span>
					    				</div>
							            <div class="row">
							            	<div class="col-md-7">
							            		<div class="form-group m-b-5 m-t-10">
									                <label for="no_bk2">No BK / Plat :</label><br>
									                <input type="text" class="form-control" readonly id="no_bk2">
									            </div>
									            <div class="form-group m-b-5 m-t-10">
									                <label for="tahun2">Tahun :</label><br>
									                <input type="text" class="form-control" readonly id="tahun2">
									            </div>
							            	</div>
							            	<div class="col-md-5">
							            		<div class="form-group m-b-5 m-t-10">
									            	<label for="">Photo Armada :</label>
						                            <div class="el-element-overlay">
				                                        <div class="card">
				                                            <div class="el-card-item">
				                                                <div class="el-card-avatar el-overlay-1">
				                                                	<center>
				                                                		<img id="imgArmada2" src="/assets/images/default/no_image.jpg" style="height: 120px; width: 120px;" class="img img-responsive" alt="Armada Photo" >
				                                                	</center>
				                                                    <div class="el-overlay scrl-dwn">
				                                                        <ul class="el-info">
				                                                            <li>
				                                                                <a class="btn default btn-sm btn-outline image-popup-vertical-fit" id="imgArmada2Popup" href="/assets/images/default/no_image.jpg"><i class="icon-magnifier"></i></a>
				                                                            </li>
				                                                        </ul>
				                                                    </div>
				                                                </div>
				                                            </div>
				                                        </div>
				                                    </div>
					                            </div>
							            	</div>
							            </div>
					    			</div>
					    			<div class="col-md-6">
					    				
			    						<div class="form-group m-b-5">
							                <label for="">Tanggal Surat jalan :</label>
					                		<select id="tgl_surat_jalan2" name="tgl_surat_jalan2" class="form-control select2" style="width: 100%"></select>
							                <span class="help-block"><small id="errorTglSuratJalan2"></small></span>
							            </div>
					    				
										<br>	
					    				<div class="card">
				                            <div class="card-header">
				                                Jadwal Keberangkatan :
				                            </div>
				                            <div class="card-body">
									    		<div class="row">
									            	<div class="col-md-6">
									            		<div class="form-group m-b-5 ">
											                <label for="berangkat2">Berangkat :</label>
													        <input type="text" id="berangkat2" class="form-control" readonly>
											            </div>
									            	</div>
									            	<div class="col-md-6">
									            		<div class="form-group m-b-5 ">
											                <label for="tujuan2">Tujuan :</label>
													        <input type="text" id="tujuan2" class="form-control" readonly>
											            </div>
									            	</div>
									            </div>
									            <div class="form-group m-b-5">
									                <label for="">Nama Penanggung jawab :</label>
							                		<input type="text" class="form-control" readonly id="penanggung_jawab2">
									            </div>
				                            </div>
				                        </div>  
										<div class="row">
					    					<div class="col-md-5">
					    						<div class="form-group m-b-5">
									                <label for="">Tanggal Input :</label>
									                <input type="text" class="form-control tanggal" name="tanggal_input2" id="tanggal_input2">
									            </div>
					    					</div>
					    					<div class="col-md-7">
					    						<div class="form-group m-b-5">
									                <label for="">Jumlah uang pendapatan :</label>
							                		<input type="number" class="form-control" min="0" name="uang_pendapatan2" id="uang_pendapatan2">
									                <span class="help-block"><small id="mata_uang_pendapatan2"></small></span>
									            </div>
					    					</div>
					    				</div>
					    			</div>
					    		</div>
							<?php echo form_close(); ?>
				            <hr>
				            <div class="form-group">
				                <button type="button" id="btnInput2" class="btn btn-outline-inverse"><i class="fa fa-save"></i> Simpan</button>
				                &nbsp;&nbsp;&nbsp;&nbsp;
		               			<button type="button" class="btn btn-outline-danger close-form-supir2"><i class="fa fa-window-close"></i> Tutup</button>
				            </div>

	             		</div>
					</div>
	            </div>

        	</div>
        </div>
    </div>
</div>

<?php assets_script_pendapatan("supir.js"); ?>