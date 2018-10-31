	
	<div id="dataTable" style="display: none;">
		<div class="card">
	        <div class="card-body">
	        	<h4 class="card-title">Table Master Armada</h4>
	        	<hr class="card-subtitle">
	            <div class="table-responsive">
	            	<!-- <button type='button' class='btn btn-outline-primary btn-sm' id='btnTambah'><i class='fa fa-plus'></i> Tambah</button>
	            	<button type='button' class='btn btn-outline-secondary btn-sm' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button> -->

	                <table id="tblMasterArmada" class="table table-bordered table-striped table-hover table-condensed" style="width: 100%">
	                    <thead class="thead-info">
	                        <tr>
	                            <th>No</th>
	                            <th>Photo</th>
	                            <th>Nama</th>
	                            <th>Tahun</th>
	                            <th>Merk Chassis</th>
	                            <th>Karoseri</th>
	                            <th width="25%">Tgl Beli</th>
	                            <th width="25%">No BK</th>
	                            <th width="25%">Tgl STNK</th>
	                            <th width="50%">Action</th>
	                        </tr>
	                    </thead>
	                    <tbody style="size: 5px;"></tbody>
	                </table>
	            </div>
	        </div>
	    </div>
	</div>

	<div id="formProses">
		<div class="card card-outline-primary">
			<div class="card-header m-b-0 text-white">
                <i id="iconForm" class='fa fa-plus'></i> <span id="titleForm">Empty title form</span>  
                <div class="card-actions">
                    <!-- <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a> -->
                    <a class="btn-close close-form"><i class="ti-close"></i></a>
                </div>
            </div>

	        <div class="card-body collapse show">

	        	<?php echo form_open("",array("id" => "formData","class" => "m-t-20")); ?>

	            	<div id="inputMessage"></div>
	            	<input type="hidden" name="id_armada" id="id_armada">
		            <div class="row">
		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10 focused">
				                <label for="nama_armada">Nama Armada :</label>
				                <input type="text" class="form-control" name="nama_armada" id="nama_armada">
				                <span class="help-block"><small id="errorNamaArmada"></small></span>
				            </div>

				            <div class="form-group m-b-5 m-t-10">
				            	<input type="hidden" name="is_delete" id="is_delete" value="1">
				            	<label for="">
				            		Photo Armada &nbsp; &nbsp;
				            		<span id="btnPhoto">
					            		<button type="button" id="gantiPhoto" class="btn btn-outline-success btn-sm">Ganti Photo</button>
					            		&nbsp; &nbsp;
					            		<button type="button" id="hapusPhoto" class="btn btn-outline-danger btn-sm">Hapus Photo</button>
					            		&nbsp; &nbsp;
	                                    <button type="button" id="batalGanti" class="btn btn-outline-warning btn-sm">Batal Ganti</button>
				            		</span>
									
				            	</label>

				            	<div id="photoPreview">
				            		<div class="row">
				            			<div class="col-md-3">
				            			</div>
				            			<div class="col-md-6">
				            				<div class="el-card-avatar el-overlay-1">
				                                <img id="imgArmada" src="#" style="height: 200px;" class="img-responsive" alt="Armada Photo" >
				                            </div>
				            			</div>
				            		</div>	
				            	</div>
				            	<br>
				            	<div id="photoDev">
                                	<input type="file" id="photo" name="photo" class="dropify-indo" data-max-file-size="2 M" data-allowed-file-extensions="jpg jpeg png gif" data-default-file="" />
				            	</div> 
                            	<span class="help-block"><small id="errorPhoto"></small></span>
                            </div>

                            <label class="m-b-5 m-t-10">Fasilitas :</label>
				    		<div class="row">
				            	<div class="col-md-2">
				            		<div class="form-group m-b-5 m-t-10">
						    			<input type="checkbox" id="ac" value="1" name="ac" class="filled-in chk-col-light-green" />
						                <label for="ac">AC</label>
						            </div>
				            	</div>
				            	<div class="col-md-2">
				            		<div class="form-group m-b-5 m-t-10">
				            		 	<input type="checkbox" id="wifi" value="1" name="wifi" class="filled-in chk-col-light-blue" />
						                <label for="wifi">WIFI</label>
						            </div>
				            	</div>
				    		</div>

				            <div class="row">
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="no_bk">No BK / Plat :</label>
						                <input type="text" class="form-control" name="no_bk" id="no_bk">
						                <span class="help-block"><small id="errorNoBk"></small></span>
						            </div>
				            	</div>
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="tgl_stnk">Tanggal STNK :</label>
						                <input type="text" class="form-control tanggal" name="tgl_stnk" id="tgl_stnk">
						                <span class="help-block"><small id="errorTglStnk"></small></span>
						            </div>
				            	</div>
				            </div> 

				            <div class="row">
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="tgl_beli">Tanggal Beli :</label>
						                <input type="text" class="form-control tanggal" name="tgl_beli" id="tgl_beli">
						                <span class="help-block"><small id="errorTglBeli"></small></span>
						            </div>
				            	</div>
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="thn_armada">Tahun Armada:</label>
						                <input type="text" class="form-control tahun" name="thn_armada" id="thn_armada">
						                <span class="help-block"><small id="errorThnArmada"></small></span>
						            </div>
				            	</div>
				            </div> 
				            <div class="row">
				            	<div class="col-md-6">     
						            <div class="form-group m-b-5 m-t-10">
						                <label for="no_bpkb">No BPKB :</label>
						                <input type="text" class="form-control" name="no_bpkb" id="no_bpkb">
						                <span class="help-block"><small id="errorNoBpkb"></small></span>
						            </div>
						        </div>
						        <div class="col-md-6"> 
						            <div class="form-group m-b-5 m-t-10">
						                <label for="no_mesin">No Mesin :</label>
						                <input type="text" class="form-control" name="no_mesin" id="no_mesin">
						                <span class="help-block"><small id="errorNoMesin"></small></span>
						            </div>
						        </div>
						    </div>

						    <div class="form-group m-b-5 m-t-10">
				                <label for="lokasi_bpkb">Lokasi BPKB :</label>
				                <input type="text" class="form-control" name="lokasi_bpkb" id="lokasi_bpkb">
				                <span class="help-block"><small id="errorLokasiBpkb"></small></span>
				            </div>

				            <div class="form-group m-b-5 m-t-10">
				                <label for="notes">Notes :</label>
				                <textarea class="form-control" name="notes" id="notes" rows="5" ></textarea>
				                <span class="help-block"><small id="errorNotes"></small></span>
				            </div>
		            	</div>
		            	<div class="col-md-6">
		            		<div class="row">
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="no_chassis">No Chassis :</label>
						                <input type="text" class="form-control" name="no_chassis" id="no_chassis">
						                <span class="help-block"><small id="errorNoChassis"></small></span>
						            </div>
				            	</div>
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="tgl_chassis">Tanggal Chassis :</label>
						                <input type="text" class="form-control tanggal" name="tgl_chassis" id="tgl_chassis">
						                <span class="help-block"><small id="errorTglChassis"></small></span>
						            </div>
				            	</div>
				            </div> 

				            <!-- Merk Chassis -->
				            <div class="row">
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="merk_chassis">Merk Chassis :</label><br>
						                <select class="form-control select2" name="merk_chassis" style="width: 100%;" id="merk_chassis" >
						                </select>
						                <span class="help-block"><small id="errorMerkChassis"></small></span>
						            </div>
				            	</div>
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="tipe_chassis">Tipe Chassis :</label><br>
						                <select class="form-control select2" name="tipe_chassis" style="width: 100%;"  id="tipe_chassis">
						                </select>
						                <span class="help-block"><small id="errorTipe"></small></span>
						            </div>
				            	</div>
				            </div>

		            		<div class="form-group m-b-5 m-t-10">
				                <label for="vendor_chassis">Vendor Chassis:</label><br>
				                <select class="form-control select2" name="vendor_chassis" style="width: 100%;" id="vendor_chassis" >
				                </select>
				                <span class="help-block"><small id="errorVendorChassis"></small></span>
				            </div>
				            	
				            <div class="row">
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="status_beli_chassis">Status Beli Chassis:</label><br>
						                <select class="form-control selectpicker" data-style="form-control btn-secondary" name="status_beli_chassis" style="width: 100%;" id="status_beli_chassis" >
						                	<option value="">--Pilih Status Chassis--</option>
						                	<option value="1">Cash</option>
						                	<option value="2">Cicilan / Kredit</option>
						                </select>
						                <span class="help-block"><small id="errorStatusBeliChassis"></small></span>
						            </div>
				            	</div>
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="lunas_chassis">Bayar Cash Chassis :</label><br>
						                <input type="number" class="form-control" min="0" name="lunas_chassis" id="lunas_chassis">
						                <span class="help-block"><small id="matauang_lunas_chassis"></small></span>
						                <span class="help-block"><small id="errorLunasChassis"></small></span>
						            </div>
				            		<div id="form_dp_chassis" class="form-group m-b-5 m-t-10">
						                <label for="dp_chassis">Bayar DP Chassis:</label><br>
						                <input type="number" class="form-control" min="0" name="dp_chassis" id="dp_chassis">
						                <span class="help-block"><small id="matauang_dp_chassis"></small></span>
						                <span class="help-block"><small id="errorDPChassis"></small></span>
						            </div>
				            	</div>
				            </div>
				            <!-- End Merk Chassis -->
				            <hr>
				            <!-- Karoseri -->
						    <div class="row">
				            	<div class="col-md-6">
				            		 <div class="form-group m-b-5 m-t-10">
						                <label for="nama_karoseri">Karoseri :</label><br>
						                <select class="form-control select2" name="nama_karoseri" style="width: 100%;" id="nama_karoseri" >
						                </select>
						                <span class="help-block"><small id="errorKaroseri"></small></span>
						            </div>
				            	</div>
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="tipe_karoseri">Tipe Karoseri :</label><br>
						                <select class="form-control select2" name="tipe_karoseri" style="width: 100%;"  id="tipe_karoseri">
						                </select>
						                <span class="help-block"><small id="errorTipeKaroseri"></small></span>
						            </div>
				            	</div>
				            </div>
				            <div class="form-group m-b-5 m-t-10">
				                <label for="vendor_karoseri">Vendor Karoseri:</label><br>
				                <select class="form-control select2" name="vendor_karoseri" style="width: 100%;" id="vendor_karoseri" >
				                </select>
				                <span class="help-block"><small id="errorVendorKaroseri"></small></span>
				            </div>
				            <div class="row">
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="status_beli_karoseri">Status Beli Karoseri :</label><br>
						                <select class="form-control selectpicker" data-style="form-control btn-secondary" name="status_beli_karoseri" style="width: 100%;" id="status_beli_karoseri" >
						                	<option value="">--Pilih Status Karoseri--</option>
						                	<option value="1">Cash</option>
						                	<option value="2">Cicilan / Kredit</option>
						                </select>
						                <span class="help-block"><small id="errorStatusBeliKaroseri"></small></span>
						            </div>
				            	</div>
				            	<div class="col-md-6">
				            		<div class="form-group m-b-5 m-t-10">
						                <label for="lunas_karoseri">Bayar Cash Karoseri :</label><br>
						                <input type="number" class="form-control" min="0" name="lunas_karoseri" id="lunas_karoseri">
						                <span class="help-block"><small id="matauang_lunas_karoseri"></small></span>
						                <span class="help-block"><small id="errorLunasKaroseri"></small></span>
						            </div>
						            <div id="form_dp_karoseri" class="form-group m-b-5 m-t-10">
						                <label for="dp_karoseri">Bayar DP Karoseri :</label><br>
						                <input type="number" class="form-control" min="0" name="dp_karoseri" id="dp_karoseri">
						                <span class="help-block"><small id="matauang_dp_karoseri"></small></span>
						                <span class="help-block"><small id="errorDPKaroseri"></small></span>
						            </div>
				            	</div>
				            </div>
				            <!-- End Karoseri -->
				            <hr>
				            <div class="form-group m-b-5 m-t-10">
				                <label for="total_cash">Total Bayar Cash Armada:</label>
				                <input type="text" class="form-control" readonly name="total_cash" id="total_cash">
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
	<?php echo modalDetailOpen(false,"lg","info","Detail master armada"); ?>
        <form class="" role="form">
            <div class="row">
            	<div class="col-md-6">
            		<div class="form-group m-b-5 m-t-10 focused">
		                <label>Nama Armada :</label><br>
		                <span class="help-block"><small id="detailNamaArmada"></small></span>
		            	<hr>
		            </div>

		            <div class="form-group m-b-5 m-t-10">
		            	<label for="">Photo Armada</label>
						<br>
        				<div class="el-card-avatar el-overlay-1">
                            <img id="detailPhoto" src="#" style="height: 150px; width: 250px;" class="img-responsive" alt="Armada Photo" >
                        </div>
                    	<hr>
                    </div>

                    <label class="m-b-5 m-t-10">Fasilitas :</label>
		    		<div class="row">
		            	<div class="col-md-4">
		            		<div class="form-group m-b-5 m-t-10">
				                <span class="help-block"><small id="detailAC"></small></span>
				                <label for="ac">AC</label>
				                <hr>
				            </div>
		            	</div>
		            	<div class="col-md-4">
		            		<div class="form-group m-b-5 m-t-10">
				                <span class="help-block"><small id="detailWIFI"></small></span>
				                <label for="wifi">WIFI</label>
				                <hr>
				            </div>
		            	</div>
		    		</div>

		            <div class="row">
		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10">
				                <label>No BK / Plat :</label><br>
				                <span class="help-block"><small id="detailNoBk"></small></span>
				            </div>
		            		<hr>
		            	</div>
		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10">
				                <label>Tanggal STNK :</label><br>
				                <span class="help-block"><small id="detailTglStnk"></small></span>
				            </div>
		            		<hr>
		            	</div>
		            </div> 

		            <div class="row">
		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10">
				                <label>Tanggal Beli :</label><br>
				                <span class="help-block"><small id="detailTglBeli"></small></span>
				            </div>
		            		<hr>
		            	</div>

		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10">
				                <label>Tahun Armada:</label><br>
				                <span class="help-block"><small id="detailThnArmada"></small></span>
				            </div>
		            		<hr>
		            	</div>
		            </div> 
		            <div class="row">
		            	<div class="col-md-6">     
				            <div class="form-group m-b-5 m-t-10">
				                <label>No BPKB :</label><br>
				                <span class="help-block"><small id="detailNoBpkb"></small></span>
				            </div>
				            <hr>
				        </div>

				        <div class="col-md-6"> 
				            <div class="form-group m-b-5 m-t-10">
				                <label>No Mesin :</label><br>
				                <span class="help-block"><small id="detailNoMesin"></small></span>
				            </div>
				            <hr>
				        </div>
				    </div>

				    <div class="form-group m-b-5 m-t-10">
		                <label>Lokasi BPKB :</label><br>
		                <span class="help-block"><small id="detailLokasiBpkb"></small></span>
		                <hr>
		            </div>

		            <div class="form-group m-b-5 m-t-10">
		                <label>Notes :</label><br>
		                <span class="help-block"><small id="detailNotes"></small></span>
		                <hr>
		            </div>
            	</div>
            	<div class="col-md-6">
            		<div class="row">
		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10">
				                <label>No Chassis :</label><br>
				                <span class="help-block"><small id="detailNoChassis"></small></span>
				                <hr>
				            </div>
		            	</div>

		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10">
				                <label>Tanggal Chassis :</label><br>
				                <span class="help-block"><small id="detailTglChassis"></small></span>
				                <hr>
				            </div>
		            	</div>
		            </div> 

		            <!-- Merk Chassis -->
		            <div class="row">
		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10">
				                <label>Merk Chassis :</label><br>
				                <span class="help-block"><small id="detailMerkChassis"></small></span>
				                <hr>
				            </div>
		            	</div>
		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10">
				                <label>Tipe Chassis :</label><br>
				                <span class="help-block"><small id="detailTipeChassis"></small></span>
				                <hr>
				            </div>
		            	</div>
		            </div>

            		<div class="form-group m-b-5 m-t-10">
		                <label>Vendor Chassis:</label><br>
		                <span class="help-block"><small id="detailVendorChassis"></small></span>
		                <hr>
		            </div>
		            	
		            <div class="row">
		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10">
				                <label>Status Beli Chassis:</label><br>
				                <span class="help-block"><small id="detailStatusBeliChassis"></small></span>
				                <hr>
				            </div>
		            	</div>
		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10">
				                <label>Bayar Cash Chassis :</label><br>
				                <span class="help-block"><small id="detailLunasChassis"></small></span>
				                <hr>
				            </div>
		            		<div id="detail_form_dp_chassis" class="form-group m-b-5 m-t-10">
				                <label>Bayar DP Chassis:</label><br>
				                <span class="help-block"><small id="detailDPChassis"></small></span>
				                <hr>
				            </div>
		            	</div>
		            </div>
		            <!-- End Merk Chassis -->
		            
		            <!-- Karoseri -->
				    <div class="row">
		            	<div class="col-md-6">
		            		 <div class="form-group m-b-5 m-t-10">
				                <label>Karoseri :</label><br>
				                <span class="help-block"><small id="detailKaroseri"></small></span>
				                <hr>
				            </div>
		            	</div>
		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10">
				                <label>Tipe Karoseri :</label><br>
				                <span class="help-block"><small id="detailTipeKaroseri"></small></span>
				                <hr>
				            </div>
		            	</div>
		            </div>
		            <div class="form-group m-b-5 m-t-10">
		                <label>Vendor Karoseri:</label><br>
		                <span class="help-block"><small id="detailVendorKaroseri"></small></span>
		                <hr>
		            </div>
		            <div class="row">
		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10">
				                <label>Status Beli Karoseri :</label><br>
				                <span class="help-block"><small id="detailStatusBeliKaroseri"></small></span>
				                <hr>
				            </div>
		            	</div>
		            	<div class="col-md-6">
		            		<div class="form-group m-b-5 m-t-10">
				                <label>Bayar Cash Karoseri :</label><br>
				                <span class="help-block"><small id="detailLunasKaroseri"></small></span>
				                <hr>
				            </div>
				            <div id="detail_form_dp_karoseri" class="form-group m-b-5 m-t-10">
				                <label>Bayar DP Karoseri :</label><br>
				                <span class="help-block"><small id="detailDPKaroseri"></small></span>
				                <hr>
				            </div>
		            	</div>
		            </div>
		            <!-- End Karoseri -->
		            
		            <div class="form-group m-b-5 m-t-10">
		                <label>Total Bayar Cash Armada:</label><br>
				        <span class="help-block"><small id="detailTotalBayarLunas"></small></span>
				        <hr>
		            </div>
            	</div>
            </div>
        </form>
	<?php echo modalDetailClose(); ?>

<?php assets_script_master("armada.js"); ?>   