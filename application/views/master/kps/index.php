	
	<div id="dataTable">
		<div class="card">
	        <div class="card-body">
	        	<h4 class="card-title">Table Master KPS</h4>
	        	<hr class="card-subtitle">
	            <div class="table-responsive">
	                <table id="tblMasterKPS" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
	                    <thead class="thead-primary">
	                        <tr>
	                            <th>No</th>
	                            <th>No KPS</th>
	                            <th>Nama</th>
	                            <th>Photo</th>
	                            <th>Tahun</th>
	                            <th>Tipe</th>
	                            <th>No BK / Plat</th>
	                            <th>Tgl Jatuh Tempo</th>
	                            <th>Tujuan Awal</th>
	                            <th>Tujuan Akhir</th>
	                            <th>Action</th>
	                        </tr>
	                    </thead>
	                    <tbody style="size: 5px;"></tbody>
	                </table>
	            </div>
	        </div>
	    </div>
	</div>

	<div id="formProses" style="display: none;">
		<div class="ribbon-wrapper card">
			<div class="ribbon ribbon-primary" id="ribbonTitle">
                <i id="iconForm" class='fa fa-plus'></i> <span id="titleForm">Empty title form</span>
            </div>
            <div class="ribbon ribbon-corner ribbon-right ribbon-danger">
            	<div class="card-actions pull-right">
                    <a class="btn-close close-form"><i class="ti-close"></i></a>
                </div>
            </div>
	        <div class="ribbon-content">

	        	<?php echo form_open("",array("id" => "formData","class" => "m-t-20")); ?>

	            	<div id="inputMessage"></div>
	            	<input type="hidden" name="id_armada" id="id_armada">
		            <div class="row">
		            	<div class="col-md-6">
				            <div class="form-group m-b-5 m-t-10 focused">
				                <label for="nama_armada">Nama Armada :</label>
				                <select class="form-control select2" name="nama_armada" style="width: 100%;"  id="nama_armada">
				                </select>
				                <span class="help-block"><small id="errorNamaArmada"></small></span>
				            </div>

				            <div class="row">
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						            	<label for="">Photo Armada</label>
					            		<center>
				            				<div class="el-card-avatar el-overlay-1">
				                                <img id="imgArmada" src="/assets/images/default/no_image.jpg" style="height: 120px; width: 120px;" class="img img-responsive" alt="Armada Photo" >
				                            </div>
					            		</center>
		                            </div>
						            <div class="form-group m-b-5 m-t-10">
						                <label for="karoseri">Karoseri :</label><br>
						                <input type="text" class="form-control" readonly id="karoseri">
						            </div>
						            <div class="form-group m-b-5 m-t-10">
						                <label for="tipe_karoseri">Tipe Karoseri :</label><br>
						                <input type="text" class="form-control" readonly id="tipe_karoseri">
						            </div>
				            	</div>
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="no_bk">No BK / Plat :</label><br>
						                <input type="text" class="form-control" readonly id="no_bk">
						            </div>
						            <div class="form-group m-b-5 m-t-10">
						                <label for="tahun">Tahun :</label><br>
						                <input type="text" class="form-control" readonly id="tahun">
						            </div>
						            <div class="form-group m-b-5 m-t-10">
						                <label for="merk_chassis">Merk Chassis :</label><br>
						                <input type="text" class="form-control" readonly id="merk_chassis">
						            </div>
						            <div class="form-group m-b-5 m-t-10">
						                <label for="tipe_chassis">Tipe Chassis :</label><br>
						                <input type="text" class="form-control" readonly id="tipe_chassis">
						            </div>
				            	</div>
				            </div>
		            	</div>
		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10 focused">
				                <label for="no_kps">Nomor KPS :</label>
				                <input type="text" class="form-control" name="no_kps" id="no_kps">
				                <span class="help-block"><small id="errorNoKPS"></small></span>
				            </div>
		            		<div class="form-group m-b-5 m-t-10">
				                <label for="tgl_jatuh_tempo">Tanggal Jatuh Tempo :</label>
				                <input type="text" class="form-control tanggal" name="tgl_jatuh_tempo" id="tgl_jatuh_tempo">
				                <span class="help-block"><small id="errorTglJatuhTempo"></small></span>
				            </div>

				            <div class="form-group m-b-5 m-t-10">
				                <label for="trayek">Trayek tujuan: </label>
				                
				                <div class="tags-default">
                                    <input type="text" id="tags_trayek" name="trayek" value="" class="form-control" placeholder=" + Add trayek " style="width: 300px" /> 
								</div>
				                <span class="help-block"><small id="errorTrayek"></small></span>
				            </div>

		            	</div>
		            </div>
	            	
		            <hr>
		            <div class="form-group m-b-5 m-t-10">
		                <button type="button" id="btnSimpan" class="btn btn-outline-info"><i class="fa fa-save"></i> Simpan</button>
		                &nbsp;&nbsp;&nbsp;&nbsp;
		                <button type="button" class="btn btn-outline-danger close-form"><i class="fa fa-window-close"></i> Tutup</button>
		            </div>
        		<?php echo form_close(); ?>
	        </div>
	    </div>
	</div>

	<!-- modal detail -->
	<?php echo modalDetailOpen(false,"lg","info","Detail Master KPS"); ?>
        <div class="row">
        	<div id="inputMessageDeetail"></div>
        	<div class="col-md-6">
	            <div class="form-group m-b-5 m-t-10 focused">
	                <label for="">Nama Armada :</label><br>
	                <span class="help-block"><small id="detailNamaArmada"></small></span>
	            </div>
	            <hr>
	            <div class="row">
	            	<div class="col-md-6">
	            		<div class="form-group m-b-5 m-t-10">
			            	<label for="">Photo Armada</label>
		            		<center>
	            				<div class="el-card-avatar el-overlay-1">
	                                <img id="imgDetailArmada" src="/assets/images/default/no_image.jpg" style="height: 112px; width: 112px;" class="img img-responsive" alt="Armada Photo" >
	                            </div>
		            		</center>
                        </div>
			            <hr>
			            <div class="form-group m-b-5 m-t-10">
			                <label for="detailKaroseri">Karoseri:</label><br>
	                		<span class="help-block"><small id="detailKaroseri"></small></span>
			            </div>
			            <hr>
			            <div class="form-group m-b-5 m-t-10">
			                <label for="detailTipeKaroseri">Tipe Karoseri :</label><br>
	                		<span class="help-block"><small id="detailTipeKaroseri"></small></span>
			            </div>
			            <hr>
	            	</div>
	            	
	            	<div class="col-md-6">
	            		<div class="form-group m-b-5 m-t-10">
			                <label for="">No BK / Plat :</label><br>
	                		<span class="help-block"><small id="detailNoBK"></small></span>
			            </div>
			            <hr>
			            <div class="form-group m-b-5 m-t-10">
			                <label for="">Tahun :</label><br>
	                		<span class="help-block"><small id="detailTahun"></small></span>
			            </div>
			            <hr>
			            <div class="form-group m-b-5 m-t-10">
			                <label for="detailMerkChassis">Merk Chassis :</label><br>
	                		<span class="help-block"><small id="detailMerkChassis"></small></span>
			            </div>
			            <hr>
			            <div class="form-group m-b-5 m-t-10">
			                <label for="detailTipeChassis">Tipe Chassis :</label><br>
	                		<span class="help-block"><small id="detailTipeChassis"></small></span>
			            </div>
			            <hr>
	            	</div>
	            </div>
        	</div>
        	<div class="col-md-6">
        		<div class="form-group m-b-5 m-t-10 focused">
	                <label for="">Nomor KPS :</label><br>
	                <span class="help-block"><small id="detailNoKPS"></small></span>
	            </div>
	            <hr>
        		<div class="form-group m-b-5 m-t-10">
	                <label for="">Tanggal Jatuh Tempo :</label><br>
	                <span class="help-block"><small id="detailTglJatuhTempo"></small></span>
	            </div>
	            <hr>
	            <div class="form-group m-b-5 m-t-10">
	                <label for="">Trayek tujuan: </label><br>
	                <span class="help-block"><small id="detailTrayek"></small></span>
	            </div>
	            <hr>
	            <div class="row">
	            	<div class="col-md-6">
	            		<div class="form-group m-b-5 m-t-10">
			                <label for="">Tujuan Awal: </label><br>
			                <span class="help-block"><small id="detailTujuanAwal"></small></span>
			            </div>
			            <hr>
	            	</div>
	            	
	            	<div class="col-md-6">
	            		<div class="form-group m-b-5 m-t-10">
			                <label for="">Tujuan Akhir: </label><br>
			                <span class="help-block"><small id="detailTujuanAkhir"></small></span>
			            </div>
			            <hr>
	            	</div>
	            	
	            </div>
        	</div>
        </div>
	<?php echo modalDetailClose(); ?>

<?php assets_script_master("kps.js"); ?>   