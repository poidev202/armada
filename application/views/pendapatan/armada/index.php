<div class="ribbon-wrapper card">
    <div class="ribbon ribbon-bookmark  ribbon-default">
    	Pendapatan Armada
    </div>
    <div class="ribbon-content">

    	<!-- nav tabs -->
    	<ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item">
            	<a class="nav-link active" data-toggle="tab" href="#armadaStatus" role="tab" aria-expanded="true">
            		Table Status Armada
            	</a> 
            </li>
            <li class="nav-item"> 
            	<a class="nav-link" data-toggle="tab" href="#logArmada" role="tab" aria-expanded="false">
            		Table Log Pendapatan Armada
            	</a> 
            </li>
        </ul>

        <!-- content tabs -->
        <div class="tab-content">
            <div class="tab-pane p-20 active" id="armadaStatus" role="tabpanel" aria-expanded="true">

            	<div class="table-responsive" id="dataTable">
                    <table id="tblArmadaStatus" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
                        <thead class="thead-success">
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>No Plat/BK</th>
                                <th>Kuning</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div id="formProses" style="display: none;">
		        	<div class="ribbon-wrapper card">
						<div class="ribbon ribbon-primary">
			                <i class='fa fa-list-alt'></i><span> Input Pendapatan Armada</span>
			            </div>
			            <div class="ribbon ribbon-corner ribbon-right ribbon-danger">
			            	<div class="card-actions pull-right">
			                    <a class="btn-close close-form"><i class="ti-close"></i></a>
			                </div>
			            </div>
						<div class="ribbon-content">
							<?php echo form_open("",array("id" => "formData","class" => "m-t-10")); ?>
					    		<div class="row">
					    			<div class="col-md-6">
					    				<div class="form-group m-b-5 focused">
										    <label for="nama_armada">Nama Armada :</label>
			                                <!-- <select id="nama_armada" name="nama_armada" class="form-control select2" style="width: 100%"></select> -->
			                                <input type="text" name="nama_armada" id="nama_armada" class="form-control" disabled>
			                                <input type="hidden" name="armada_id" id="armada_id" class="form-control">
										    <span class="help-block"><small id="errorNamaArmada"></small></span>
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
				                                                		<img id="imgArmada" src="/assets/images/default/no_image.jpg" style="height: 120px; width: 120px;" class="img img-responsive" alt="Armada Photo" >
				                                                	</center>
				                                                    <div class="el-overlay scrl-dwn">
				                                                        <ul class="el-info">
				                                                            <li>
				                                                                <a class="btn default btn-sm btn-outline image-popup-vertical-fit" id="imgArmadaPopup" href="/assets/images/default/no_image.jpg"><i class="icon-magnifier"></i></a>
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
									                <label for="no_bk">No BK / Plat :</label><br>
									                <input type="text" class="form-control" readonly id="no_bk">
									            </div>
									            <div class="form-group m-b-5 m-t-10">
									                <label for="tahun">Tahun :</label><br>
									                <input type="text" class="form-control" readonly id="tahun">
									            </div>
							            	</div>
							            </div>
										<div class="row">
					    					<div class="col-md-5">
					    						<div class="form-group m-b-5">
									                <label for="">Tanggal Input :</label>
									                <input type="text" class="form-control tanggal" name="tanggal_input" id="tanggal_input">
									            </div>
					    					</div>
					    					<div class="col-md-7">
					    						<div class="form-group m-b-5">
									                <label for="">Jumlah uang pendapatan :</label>
							                		<input type="number" class="form-control" min="0" name="uang_pendapatan" id="uang_pendapatan">
									                <span class="help-block"><small id="mata_uang_pendapatan"></small></span>
									            </div>
					    					</div>
					    				</div>
				                        <div class="form-group m-t-5 focused">
										    <label for="account_kas">Account Kas :</label>
			                                <select id="account_kas" name="account_kas" class="form-control select2" style="width: 100%"></select>
										    <span class="help-block"><small id="errorAccountKas"></small></span>
					    				</div>
					    			</div>
					    			<div class="col-md-6">
			    						<div class="form-group m-b-5">
							                <label for="">Tanggal Surat jalan :</label>
					                		<select id="tgl_surat_jalan" name="tgl_surat_jalan" class="form-control select2" style="width: 100%"></select>
							                <span class="help-block"><small id="errorTglSuratJalan"></small></span>
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
											                <label for="berangkat">Berangkat :</label>
													        <input type="text" id="berangkat" class="form-control" readonly>
											            </div>
									            	</div>
									            	<div class="col-md-6">
									            		<div class="form-group m-b-5 ">
											                <label for="tujuan">Tujuan :</label>
													        <input type="text" id="tujuan" class="form-control" readonly>
											            </div>
									            	</div>
									            </div>
									            <div class="form-group m-b-5">
									                <label for="">Nama Penanggung jawab :</label>
							                		<input type="text" class="form-control" readonly id="penanggung_jawab">
									            </div>
				                            </div>
				                        </div> 
				                        <div class="form-group m-t-5">
							                <label for="">Keterangan :</label>
							                <textarea class="form-control" name="keterangan" id="keterangan" style="resize: vertical;"></textarea>
							            </div>
					    			</div>
					    		</div>
							<?php echo form_close(); ?>
				            <hr>
				            <div class="form-group">
				                <button type="button" id="btnInput" class="btn btn-outline-primary"><i class="fa fa-save"></i> Simpan</button>
				                &nbsp;&nbsp;&nbsp;&nbsp;
		               			<button type="button" class="btn btn-outline-danger close-form"><i class="fa fa-window-close"></i> Tutup</button>
				            </div>
		         		</div>
					</div>
		        </div>

        	</div>
            <div class="tab-pane" id="logArmada" role="tabpanel" aria-expanded="false">

            	<div class="table-responsive m-t-20">
		            <table id="tblPendapatanArmada" class="table table-bordered table-striped table-hover table-sm" style="width: 100%">
		                <thead class="thead-info">
		                    <tr>
		                        <th>No</th>
		                        <th>Tanggal Input</th>
		                        <th>Nama Armada</th>
		                        <th>No Plat</th>
		                        <th>Hari</th>
		                        <th>Jam</th>
		                        <th>Berangkat</th>
		                        <th>Tujuan Akhir</th>
		                        <th>uang pendapatan</th>
		                        <th>Account Kas</th>
		                    </tr>
		                </thead>
		            </table>
		        </div>

            </div>
        </div>

    </div>
</div>

<?php assets_script_pendapatan("armada.js"); ?>

<!-- Load Rekap Account kas -->
<?php $this->load->view('master/accountkas/rekap_account_kas'); ?>
<?php assets_script_master("accountkas_rekap.js"); ?>