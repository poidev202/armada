$(document).ready(function() {
	
	btnTambah = "&nbsp;&nbsp;&nbsp;&nbsp; <button type='button' class='btn btn-outline-success btn-sm' id='btnTambah'><i class='fa fa-plus'></i> Tambah</button>";

	btnRefresh = "&nbsp;&nbsp;&nbsp;&nbsp; <button type='button' class='btn waves-effect waves-light btn-secondary btn-sm' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button>";

	$("#tblMasterKaryawan").DataTable({
		serverSide:true,
		responsive:true,
		processing:false,
		oLanguage: {
            sZeroRecords: "<center>Data tidak ditemukan</center>",
            sLengthMenu: "Tampilkan _MENU_ data   "+btnTambah+btnRefresh,
            sSearch: "Cari data:",
            sInfo: "Menampilkan: _START_ - _END_ dari total: _TOTAL_ data",                                   
            oPaginate: {
                sFirst: "Awal", "sPrevious": "Sebelumnya",
                sNext: "Selanjutnya", "sLast": "Akhir"
            },
        },
		//load data
		ajax: {
			url: '/master/karyawan/ajax_list',
			type: 'POST',
		},

		order:[[2,'ASC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{
				data:'foto_karyawan',
				searchable:false,
				orderable:false,
			},
			{ data:'nama' },
			{ data:'kode' },
			{ data:'tempat_lahir' },
			{ data:'tanggal_lahir' },
			{ data:'no_telp' },
			{ data:'nama_jabatan' },
			{ data:'status_kerja' },
			{ data:'alamat' },
			{
				data:'button_action',
				searchable:false,
				orderable:false,
			}
		],
	});

});

function reloadTable() {
	$("#tblMasterKaryawan").DataTable().ajax.reload(null,false);
}

$("#dataTable").show(800);
$("#formProses").hide(800);
$("#formDetail").hide(800);

var save_method;
var idData;

$(document).on('click', '#btnTambah', function (e) {
	e.preventDefault();
	
	$("#formProses").children().removeClass("card-fullscreen");
	$("#formData")[0].reset();
	$("#titleForm").text("Tambah Master Karyawan");

	$("#ribbonTitle").removeClass("ribbon-warning");
	$("#ribbonTitle").addClass("ribbon-success");

	$("#iconForm").addClass("fa-plus");
	$("#iconForm").removeClass("fa-pencil-square-o");
	
	$("#dataTable").hide(800);
	$("#formProses").show(800);

	$("#btnSimpan").attr("disabled",false);
	$("#btnSimpan").html('<i class="fa fa-save"></i> Simpan');

	$("#wni").attr("checked",false);
	$("#wna").attr("checked",false);

	$("#sudah_nikah").attr("checked",false);
	$("#belum_nikah").attr("checked",false);

	$("#aktif").attr("checked",false);
	$("#tidak_aktif").attr("checked",false);

	$("#aktif_kontrak").attr("checked",false);
	$("#tidak_kontrak").attr("checked",false);

	$("#ya_supir").attr("checked",false);
	$("#tidak_supir").attr("checked",false);

	$("#kelamin").val("").trigger("change");
	$("#pendidikan").val("").trigger("change");
	$("#agama").val("").trigger("change");
	$("#jabatan").val("").trigger("change");
	$("#bank").val("").trigger("change");
	$("#periode_gaji").val("").trigger("change");
	$("#hasil_matauang_gaji").html("");

	no_image = '/assets/images/default/no_image.jpg';
   	$('#imgKaryawan').attr('src','/assets/images/default/user_image.png');
	$('#imgKaryawanPopup').attr('href','/assets/images/default/user_image.png');
	$('#imgKK').attr('src',no_image);
	$('#imgKKpopup').attr('href',no_image);
	$('#imgSuratLamaran').attr('src',no_image);
	$('#imgSuratLamaranPopup').attr('href',no_image);
	$('#imgTestUrine').attr('src',no_image);
	$('#imgTestUrinePopup').attr('href',no_image);
	$('#imgKtp').attr('src',no_image);
	$('#imgKtpPopup').attr('href',no_image);
	$('#imgSim').attr('src',no_image);
	$('#imgSimPopup').attr('href',no_image);

	save_method = "add";
});

$(document).on('click', '#btnRefresh', function(e) {
	e.preventDefault();
	reloadTable();
	$("#btnRefresh").children().addClass("fa-spin");
	setTimeout(function(){
	  $("#btnRefresh").children().removeClass("fa-spin");
	}, 1000);
});

$(".close-form").click(function() {
	$("#dataTable").show(800);
	$("#formProses").hide(800);
	$("#formDetail").hide(800);
});

$("#nama_karyawan").keyup(function() {
	$("#atas_nama").val($(this).val());
});

$(document).ready(function () {
    $('#gaji').on('input', function() {
        $('#hasil_matauang_gaji').html( moneyFormat.to( parseInt($(this).val()) ) );
    });
}); 

/* master Jabatan */
$.post("/master/jabatan/getAll",function(json) {
	var option;

	option = '<option value="">-- Pilih Jabatan --</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.nama_jabatan+'</option>';
	});

	$("#jabatan").html(option);
});

/* master Bank */
$.post("/master/bank/getAll",function(json) {
	var option;
	
	option = '<option value="">-- Pilih Bank --</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.nama_bank+'</option>';
	});

	$("#bank").html(option);
});

$("#tgl_awal_kontrak").attr("disabled",true);
$("#tgl_akhir_kontrak").attr("disabled",true);

$("input[name='status_kontrak']").change(function() {
	status_kontrak = $(this).val();
	if (status_kontrak == "aktif") {
		$("#tgl_awal_kontrak").attr("disabled",false);
		$("#tgl_akhir_kontrak").attr("disabled",false);
	} else {
		$("#tgl_awal_kontrak").attr("disabled",true);
		$("#tgl_akhir_kontrak").attr("disabled",true);
		$("#tgl_awal_kontrak").val("");
		$("#tgl_akhir_kontrak").val("");
	}
});

function detailKaryawan(id) {

	idData = id;
	$.post("/master/karyawan/getId/"+idData,function(json) {
		if (json.status == true) {

			$("#dataTable").hide(800);
			$("#formDetail").show(800);

			$("#detailNamaKaryawan").html(json.data.nama);
			$("#detailKodeKaryawan").html(json.data.kode);
			var srcFotoKaryawan = '/assets/images/default/user_image.png';
			if (json.data.foto_karyawan != "") {
				srcFotoKaryawan = '/uploads/admin/master/karyawan/orang/'+json.data.foto_karyawan;
			}
		   	$('#detailImgKaryawan').attr('src',srcFotoKaryawan);
			$('#detailImgKaryawanPopup').attr('href',srcFotoKaryawan);

			$("#detailTempatLahir").html(json.data.tempat_lahir);
			$("#detailTanggalLahir").html(json.data.tanggal_lahir_indo);
			$("#detailKelamin").html(json.data.kelamin);
			$("#detailNoTelp").html(json.data.no_telp);
			$("#detailEmail").html(json.data.email);
			$("#detailPendidikan").html(json.data.pendidikan);
			$("#detailKewarganegaraan").html(json.data.kewarganegaraan);
			$("#detailAgama").html(json.data.agama);
			$("#detailStatusNikah").html(json.data.status_nikah_);
			$("#detailJabatan").html(json.data.nama_jabatan);
			$("#detailStatusKerja").html(json.data.status_kerja);
			$("#detailBank").html(json.data.nama_bank);
			$("#detailAtasNama").html(json.data.atas_nama);
			$("#detailNoRekening").html(json.data.no_rekening);
			$("#detailNPWP").html(json.data.npwp);
			$("#detailAlamat").html(json.data.alamat);
			$("#detailPeriodeGaji").html(json.data.periode_gaji);
			$("#detailGaji").html(json.data.gaji_rp);
			$("#detailTanggalMasuk").html(json.data.tgl_masuk_kerja_indo);
			$("#detailStatusKontrak").html(json.data.status_kontrak);

			if (json.data.status_kontrak == "aktif") {
				$("#detailTglAwalKontrak").html(json.data.tgl_awal_kontrak_indo);
				$("#detailTglAkhirKontrak").html(json.data.tgl_akhir_kontrak_indo);
			} else if (json.data.status_kontrak == "tidak") {
				$("#detailTglAwalKontrak").html("Kosong");
				$("#detailTglAkhirKontrak").html("Kosong");
			}

			no_image = '/assets/images/default/no_image.jpg';
			var srcFotoKK = no_image;
			if (json.data.foto_kk != "") {
				srcFotoKK = '/uploads/admin/master/karyawan/kk/'+json.data.foto_kk;
			}
			$('#detailImgKK').attr('src',srcFotoKK);
			$('#detailImgKKpopup').attr('href',srcFotoKK);

			var srcFotoLamaran = no_image;
			if (json.data.foto_surat_lamaran != "") {
				srcFotoLamaran = '/uploads/admin/master/karyawan/lamaran/'+json.data.foto_surat_lamaran;
			}
			$('#detailImgLamaran').attr('src',srcFotoLamaran);
			$('#detailImgLamaranPopup').attr('href',srcFotoLamaran);

			var srcFotoUrine = no_image;
			if (json.data.foto_test_urine != "") {
				srcFotoUrine = '/uploads/admin/master/karyawan/urine/'+json.data.foto_test_urine;
			}
			$('#detailImgTestUrine').attr('src',srcFotoUrine);
			$('#detailImgTestUrinePopup').attr('href',srcFotoUrine);

			var srcFotoKtp = no_image;
			if (json.data.foto_ktp != "") {
				srcFotoKtp = '/uploads/admin/master/karyawan/ktp/'+json.data.foto_ktp;
			}
			$('#detailImgKtp').attr('src',srcFotoKtp);
			$('#detailImgKtpPopup').attr('href',srcFotoKtp);
			$("#detailNoKtp").html(json.data.no_ktp);
			$("#detailBagianSupir").html(json.data.bagian_supir);

			var srcFotoSim = no_image;
			if (json.data.foto_sim != "") {
				srcFotoSim = '/uploads/admin/master/karyawan/sim/'+json.data.foto_sim;
			}
			$('#detailImgSim').attr('src',srcFotoSim);
			$('#detailImgSimPopup').attr('href',srcFotoSim);
			$("#detailNoSim").html(json.data.no_sim);
			$("#detailJatuhTempoSim").html(json.data.tgl_jatuh_tempo_sim_indo);

		} else {
			swal({    
		            title: json.message,
		            type: "error",
		            timer: 2000,   
		            showConfirmButton: false 
		        });
		}
	});
}

function editKaryawan(id) {

	idData = id;
	save_method = "update";

	$("#formProses").children().removeClass("card-fullscreen");
	$("#formData")[0].reset();
	$("#titleForm").text("Update Master Karyawan");

	$("#ribbonTitle").removeClass("ribbon-success");
	$("#ribbonTitle").addClass("ribbon-warning");

	$("#iconForm").addClass("fa-pencil-square-o");
	$("#iconForm").removeClass("fa-plus");
	
	$("#dataTable").hide(800);
	$("#formProses").show(800);

	$("#btnSimpan").attr("disabled",false);
	$("#btnSimpan").html('<i class="fa fa-save"></i> Simpan');

	$.post("/master/karyawan/getId/"+idData,function(json) {
		if (json.status == true) {

			$("#nama_karyawan").val(json.data.nama);
			var srcFotoKaryawan = '/assets/images/default/user_image.png';
			if (json.data.foto_karyawan != "") {
				srcFotoKaryawan = '/uploads/admin/master/karyawan/orang/'+json.data.foto_karyawan;
			}
		   	$('#imgKaryawan').attr('src',srcFotoKaryawan);
			$('#imgKaryawanPopup').attr('href',srcFotoKaryawan);

			$("#tempat_lahir").val(json.data.tempat_lahir);
			$("#tanggal_lahir").val(json.data.tanggal_lahir);
			$("#kelamin").val(json.data.kelamin).trigger("change");
			$("#no_telp").val(json.data.no_telp);
			$("#email").val(json.data.email);
			$("#pendidikan").val(json.data.pendidikan).trigger("change");

			if (json.data.kewarganegaraan == "wni") {
				$("#wni").attr("checked",true);
				$("#wna").attr("checked",false);
			} else if (json.data.kewarganegaraan == "wna") {
				$("#wni").attr("checked",false);
				$("#wna").attr("checked",true);
			}

			$("#agama").val(json.data.agama).trigger("change");

			if (json.data.status_nikah == "sudah_nikah") {
				$("#sudah_nikah").attr("checked",true);
				$("#belum_nikah").attr("checked",false);
			} else if (json.data.status_nikah == "belum_nikah") {
				$("#sudah_nikah").attr("checked",false);
				$("#belum_nikah").attr("checked",true);
			}

			$("#jabatan").val(json.data.jabatan_id).trigger("change");

			if (json.data.status_kerja == "aktif") {
				$("#aktif").attr("checked",true);
				$("#tidak_aktif").attr("checked",false);
			} else if (json.data.status_kerja == "tidak") {
				$("#aktif").attr("checked",false);
				$("#tidak_aktif").attr("checked",true);
			}
			$("#bank").val(json.data.bank_id).trigger("change");
			$("#atas_nama").val(json.data.atas_nama);
			$("#no_rekening").val(json.data.no_rekening);
			$("#npwp").val(json.data.npwp);
			$("#alamat").val(json.data.alamat);
			$("#periode_gaji").val(json.data.periode_gaji).trigger("change");
			$("#gaji").val(json.data.gaji);
			$("#hasil_matauang_gaji").html(json.data.gaji_rp);
			$("#tgl_masuk_kerja").val(json.data.tgl_masuk_kerja);
			if (json.data.status_kontrak == "aktif") {
				$("#aktif_kontrak").attr("checked",true);
				$("#tidak_kontrak").attr("checked",false);

				$("#tgl_awal_kontrak").val(json.data.tgl_awal_kontrak);
				$("#tgl_akhir_kontrak").val(json.data.tgl_akhir_kontrak);
				$("#tgl_awal_kontrak").attr("disabled",false);
				$("#tgl_akhir_kontrak").attr("disabled",false);

			} else if (json.data.status_kontrak == "tidak") {
				$("#aktif_kontrak").attr("checked",false);
				$("#tidak_kontrak").attr("checked",true);

				$("#tgl_awal_kontrak").attr("disabled",true);
				$("#tgl_akhir_kontrak").attr("disabled",true);
			}

			no_image = '/assets/images/default/no_image.jpg';
			var srcFotoKK = no_image;
			if (json.data.foto_kk != "") {
				srcFotoKK = '/uploads/admin/master/karyawan/kk/'+json.data.foto_kk;
			}
			$('#imgKK').attr('src',srcFotoKK);
			$('#imgKKpopup').attr('href',srcFotoKK);

			var srcFotoLamaran = no_image;
			if (json.data.foto_surat_lamaran != "") {
				srcFotoLamaran = '/uploads/admin/master/karyawan/lamaran/'+json.data.foto_surat_lamaran;
			}
			$('#imgSuratLamaran').attr('src',srcFotoLamaran);
			$('#imgSuratLamaranPopup').attr('href',srcFotoLamaran);

			var srcFotoUrine = no_image;
			if (json.data.foto_test_urine != "") {
				srcFotoUrine = '/uploads/admin/master/karyawan/urine/'+json.data.foto_test_urine;
			}
			$('#imgTestUrine').attr('src',srcFotoUrine);
			$('#imgTestUrinePopup').attr('href',srcFotoUrine);

			var srcFotoKtp = no_image;
			if (json.data.foto_ktp != "") {
				srcFotoKtp = '/uploads/admin/master/karyawan/ktp/'+json.data.foto_ktp;
			}
			$('#imgKtp').attr('src',srcFotoKtp);
			$('#imgKtpPopup').attr('href',srcFotoKtp);
			$("#no_ktp").val(json.data.no_ktp);

			if (json.data.bagian_supir == "ya") {
				$("#ya_supir").attr("checked",true);
				$("#tidak_supir").attr("checked",false);
			} else if (json.data.bagian_supir == "tidak") {
				$("#ya_supir").attr("checked",false);
				$("#tidak_supir").attr("checked",true);
			}

			var srcFotoSim = no_image;
			if (json.data.foto_sim != "") {
				srcFotoSim = '/uploads/admin/master/karyawan/sim/'+json.data.foto_sim;
			}
			$('#imgSim').attr('src',srcFotoSim);
			$('#imgSimPopup').attr('href',srcFotoSim);
			$("#no_sim").val(json.data.no_sim);
			$("#tgl_jatuh_tempo_sim").val(json.data.tgl_jatuh_tempo_sim);

		} else {

			$("#dataTable").hide(800);
			$("#formProses").show(800);

			swal({    
		            title: json.message,
		            type: "error",
		            timer: 2000,   
		            showConfirmButton: false 
		        });
		}
	});
}

$("#btnSimpan").click(function() {
	var url;
	if (save_method == "add") {
		url = '/master/karyawan/add';
	} else {
		url = '/master/karyawan/update/'+idData;
	}

	$("#btnSimpan").attr("disabled",true);
	$("#btnSimpan").html("Loading...<i class='fa fa-spinner fa-spin'></i>");

	var formData = new FormData($("#formData")[0]);
	$.ajax({
		url: url,
		type:'POST',
		data:formData,
		contentType:false,
		processData:false,
		dataType:'JSON',
		success: function(json) {
			if (json.status == true) {
				$("#inputMessage").html(json.message);
				swal({    
			            title: json.message,
			            type: "success",
			            timer: 2000,   
			            showConfirmButton: false 
			        });

				setTimeout(function() {
					$("#formData")[0].reset();
					$("#inputMessage").html("");
					$("#dataTable").show(800);
					$("#formProses").hide(800);
					reloadTable();

					$("#btnSimpan").attr("disabled",false);
					$("#btnSimpan").html('<i class="fa fa-save"></i> Simpan');

				}, 1500);
			} else {

				if (json.message == "error_foto") {

					var fotoError = "";

					if (json.error.foto_karyawan) {
						fotoError += "<u>Foto Karyawan : </u>"+json.error.foto_karyawan+"<br>";
					}
					if (json.error.foto_kk) {
						fotoError += "<u>Foto KK : </u>"+json.error.foto_kk+"<br>";
					}
					if (json.error.foto_surat_lamaran) {
						fotoError += "<u>Foto Surat Lamaran : </u>"+json.error.foto_surat_lamaran+"<br>";
					}
					if (json.error.foto_test_urine) {
						fotoError += "<u>Foto Test Urine : </u>"+json.error.foto_test_urine+"<br>";
					}
					if (json.error.foto_ktp) {
						fotoError += "<u>Foto KTP : </u>"+json.error.foto_ktp+"<br>";
					}
					if (json.error.foto_sim) {
						fotoError += "<u>Foto SIM : </u>"+json.error.foto_sim+"<br>";
					}

					swal({   
			            title: "<h2 style='color:red;'>Error Foto!</h2>",   
			            html: fotoError,
			            type: "error",
			        });

					setTimeout(function() {

						$("#btnSimpan").attr("disabled",false);
						$("#btnSimpan").html('<i class="fa fa-save"></i> Simpan');

					}, 3000);
				} else {
					swal({   
			            title: "Error Form",   
			            html: json.message,
			            type: "error",
			        });

					setTimeout(function() {

						$("#btnSimpan").attr("disabled",false);
						$("#btnSimpan").html('<i class="fa fa-save"></i> Simpan');

					}, 3000);
				}
			}
		}
	});
});

function btnDelete(id) {
	idData = id;

	$.post("/master/karyawan/getId/"+idData,function(json) {
		if (json.status == true) {
			
			var srcFotoKaryawan = '/assets/images/default/user_image.png';
			if (json.data.foto_karyawan != "") {
				srcFotoKaryawan = '/uploads/admin/master/karyawan/orang/'+json.data.foto_karyawan;
			}

			var pesan =	"<br>";
				/*pesan += "<small style='color:orange'>Note: Menghapus data ini juga akan Menghapus data master kps "+kredit+" yang berhubungan dengan data yang anda pilih ini.!</small>";*/
				pesan += "<hr> <div class='row'>";
				pesan += "<div class='col-md-4'>";
				pesan += "<label>Foto:</label><br>";
				pesan += "<img src='"+srcFotoKaryawan+"' alt='Foto Karyawan' class='img img-responsive' style='width:100px; height:80px;'>";
				pesan += "</div>";
				pesan += "<div class='col-md-8'>";
				pesan += "<li class='pull-left'><small>Nama : <i>"+json.data.nama+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Kode : <i>"+json.data.kode+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Tempat lahir: <i>"+json.data.tempat_lahir+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Tanggal lahir : <i>"+json.data.tanggal_lahir_indo+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Telepon : <i>"+json.data.no_telp+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Jabatan : <i>"+json.data.nama_jabatan+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Status kerja : <i>"+json.data.status_kerja+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Alamat: <i>"+json.data.alamat+"</small></i></li><br>";
				pesan += "</div>";
				pesan += "</div>";
		    swal({   
		        title: "Apakah anda yakin.?",
		        type: "warning",    
		        html: "<span style='color:red;'>Data yang di <b><u>Hapus</u></b> tidak bisa dikembalikan lagi.</span>"+pesan,
  				showCloseButton: true,
		        showCancelButton: true,   
		        confirmButtonColor: "#DD6B55",   
		        confirmButtonText: "Iya, Hapus",   
		        closeOnConfirm: false 
		    }).then((result) => {  
		    	if (result.value) {
		    		$.post("/master/karyawan/delete/"+idData,function(json) {
						if (json.status == true) {
							swal({    
						            title: json.message,
						            type: "success",
						            // html: true,
						            timer: 2000,   
						            showConfirmButton: false 
						        });
							reloadTable();
						} else {
							swal({    
						            title: json.message,
						            type: "error",
						            // html: true,
						            timer: 1000,   
						            showConfirmButton: false 
						        });
							reloadTable();
						}
					});
		    	}
		    });
		} else {
			reloadTable();
			swal({    
		            title: json.message,
		            type: "error",
		            // html: true,
		            timer: 1000,   
		            showConfirmButton: false 
		        });
		}
	});
}

/*function untuk baca target src file image dan validate nya juga*/
function readURL(input,targetID,targetIdPopup) {
	var filePath = input.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if(!allowedExtensions.exec(filePath)){ // validate format extension file
        // alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
        swal({   
	            title: "<h2 style='color:red;'>Error Foto!</h2>",   
	            html: "<u>Foto Karyawan : </u>  <small><span style='color:red;'> Jenis file yang Anda upload tidak diperbolehkan.</span> <br> Harap hanya upload file yang memiliki ekstensi <br> .jpeg | .jpg | .png | .gif </small>",
	            type: "error",
	        });

        input.value = '';
        return false;

    } else if (input.files[0].size > 1048576) { // validate size file 1 mb
		// alert("file size lebih besar dari 1 mb, file size yang di upload = "+input.files[0].size);
		swal({   
	            title: "<h2 style='color:red;'>Error Foto!</h2>",   
	            html: "<u>Foto Karyawan : </u>  <small style='color:red;'>File yang diupload melebihi ukuran maksimal diperbolehkan yaitu 1 mb.</small>",
	            type: "error",
	        });
        input.value = '';
		return false;

	} else {
	   	if (input.files && input.files[0])
	   	{
		    var reader = new FileReader();
		    reader.onload = function (e)
		    {
		       $('#'+targetID).attr('src',e.target.result);
		       $('#'+targetIdPopup).attr('href',e.target.result);
		    };
		    reader.readAsDataURL(input.files[0]);
	   	}
	}
}

/* prosessing foto karyawan change*/
	$("#ganti_foto_karyawan").click(function() {
		$("#foto_karyawan").click();
	});

	$("#foto_karyawan").change(function(event){
		readURL(document.getElementById('foto_karyawan'),"imgKaryawan","imgKaryawanPopup");
		$('#is_delete_karyawan').val(0);
	});

	$("#hapus_foto_karyawan").click(function() {
	   $('#imgKaryawan').attr('src','/assets/images/default/user_image.png');
	   $('#imgKaryawanPopup').attr('href','/assets/images/default/user_image.png');
	   $("#foto_karyawan").val("");
	   $('#is_delete_karyawan').val(1);	
	});
/* end foto karyawan change*/

/* prosessing foto KK change*/
	$("#ganti_foto_kk").click(function() {
		$("#foto_kk").click();
	});

	$("#foto_kk").change(function(event){
		readURL(document.getElementById('foto_kk'),"imgKK","imgKKpopup");
		$('#is_delete_kk').val(0);
	});

	$("#hapus_foto_kk").click(function() {
	   $('#imgKK').attr('src','/assets/images/default/no_image.jpg');
	   $('#imgKKpopup').attr('href','/assets/images/default/no_image.jpg');
	   $("#foto_kk").val("");
	   $('#is_delete_kk').val(1);	
	});
/* end foto KK change*/

/* prosessing foto surat lamaran change*/
	$("#ganti_foto_surat_lamaran").click(function() {
		$("#foto_surat_lamaran").click();
	});

	$("#foto_surat_lamaran").change(function(event){
		readURL(document.getElementById('foto_surat_lamaran'),"imgSuratLamaran","imgSuratLamaranPopup");
		$('#is_delete_surat_lamaran').val(0);
	});

	$("#hapus_foto_surat_lamaran").click(function() {
	   $('#imgSuratLamaran').attr('src','/assets/images/default/no_image.jpg');
	   $('#imgSuratLamaranPopup').attr('href','/assets/images/default/no_image.jpg');
	   $("#foto_surat_lamaran").val("");
	   $('#is_delete_surat_lamaran').val(1);	
	});
/* end foto surat lamaran change*/

/* prosessing foto test urine change*/
	$("#ganti_foto_test_urine").click(function() {
		$("#foto_test_urine").click();
	});

	$("#foto_test_urine").change(function(event){
		readURL(document.getElementById('foto_test_urine'),"imgTestUrine","imgTestUrinePopup");
		$('#is_delete_test_urine').val(0);
	});

	$("#hapus_foto_test_urine").click(function() {
	   $('#imgTestUrine').attr('src','/assets/images/default/no_image.jpg');
	   $('#imgTestUrinePopup').attr('href','/assets/images/default/no_image.jpg');
	   $("#foto_test_urine").val("");
	   $('#is_delete_test_urine').val(1);	
	});
/* end foto test urine change*/

/* prosessing foto ktp change*/
	$("#ganti_foto_ktp").click(function() {
		$("#foto_ktp").click();
	});

	$("#foto_ktp").change(function(event){
		readURL(document.getElementById('foto_ktp'),"imgKtp","imgKtpPopup");
		$('#is_delete_ktp').val(0);
	});

	$("#hapus_foto_ktp").click(function() {
	   $('#imgKtp').attr('src','/assets/images/default/no_image.jpg');
	   $('#imgKtpPopup').attr('href','/assets/images/default/no_image.jpg');
	   $("#foto_ktp").val("");
	   $('#is_delete_ktp').val(1);	
	});
/* end foto ktp change*/

/* prosessing foto sim change*/
	$("#ganti_foto_sim").click(function() {
		$("#foto_sim").click();
	});

	$("#foto_sim").change(function(event){
		readURL(document.getElementById('foto_sim'),"imgSim","imgSimPopup");
		$('#is_delete_sim').val(0);
	});

	$("#hapus_foto_sim").click(function() {
	   $('#imgSim').attr('src','/assets/images/default/no_image.jpg');
	   $('#imgSimPopup').attr('href','/assets/images/default/no_image.jpg');
	   $("#foto_sim").val("");
	   $('#is_delete_sim').val(1);	
	});
/* end foto sim change*/