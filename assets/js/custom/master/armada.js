$(document).ready(function() {
	
	btnTambah = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-primary btn-sm' id='btnTambah'><i class='fa fa-plus'></i> Tambah</button>";
   	
    btnRefresh = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-success btn-sm' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button>";

	$("#tblMasterArmada").DataTable({
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
			url: '/master/armada/ajax_list',
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
				data:'photo',
				searchable:false,
				orderable:false,
			},
			{ data:'nama' },
			{ data:'tahun' },
			{ data:'merk' },
			{ data:'nama_karoseri' },
			{ data:'tgl_beli' },
			{ data:'no_bk' },
			{ data:'tgl_stnk' },
			{
				data:'button_action',
				searchable:false,
				orderable:false,
			}
		],
	});

});


function reloadTable() {
	$("#tblMasterArmada").DataTable().ajax.reload(null,false);
}

$("#dataTable").show(1000);
$("#formProses").hide(1000);

var save_method;
var idData;

$(document).on('click', '#btnRefresh', function(e) {
	e.preventDefault();
	reloadTable();
	$("#btnRefresh").children().addClass("fa-spin");
	setTimeout(function(){
	  $("#btnRefresh").children().removeClass("fa-spin");
	}, 1000);
});

$(document).on('click', '#btnTambah', function (e) {
	e.preventDefault();
	
	$("#formProses").children().removeClass("card-fullscreen");
	$("#formData")[0].reset();
	$("#titleForm").text("Tambah Master Armada");
	$("#formProses").children().removeClass("card-outline-warning");
	$("#formProses").children().addClass("card-outline-primary");

	$("#iconForm").addClass("fa-plus");
	$("#iconForm").removeClass("fa-pencil-square-o");

	$('#merk_chassis').val("").trigger('change');
	$('#tipe_chassis').val("").trigger('change');
	$("#nama_karoseri").val("").trigger('change');
	$("#tipe_karoseri").val("").trigger('change');

	$('#status_beli_chassis').val("").trigger('change');
	$('#status_beli_karoseri').val("").trigger('change');

	$('#vendor_chassis').val("").trigger('change');
	$('#vendor_karoseri').val("").trigger('change');

	$('#matauang_lunas_chassis').html("");
	$('#matauang_dp_chassis').html("");

	$('#matauang_lunas_karoseri').html("");
	$('#matauang_dp_karoseri').html("");

	var drEvent = $('#photo').dropify();
	drEvent = drEvent.data('dropify');
	drEvent.resetPreview();
	drEvent.clearElement();

	$("#dataTable").hide(1000);
	$("#formProses").show(1000);

	$("#photoPreview").hide(1000);
	$("#btnPhoto").hide(1000);
	$("#photoDev").show(1000);

	$("#btnSimpan").attr("disabled",false);
	$("#btnSimpan").html('<i class="fa fa-save"></i> Simpan');

	save_method = "add";
});

$("#form_dp_chassis").hide(1000);
$("#status_beli_chassis").change(function() {
	if($("#status_beli_chassis").val() == 2){
		$("#form_dp_chassis").show(1000);
	} else {
		$("#form_dp_chassis").hide(1000);
	}
});

$("#form_dp_karoseri").hide(1000);
$("#status_beli_karoseri").change(function() {
	if($("#status_beli_karoseri").val() == 2){
		$("#form_dp_karoseri").show(1000);
	} else {
		$("#form_dp_karoseri").hide(1000);
	}
});

$("#lunas_chassis, #lunas_karoseri").keyup(function() {
	var chassis = $("#lunas_chassis").val();
	var karoseri = $("#lunas_karoseri").val();

	chassis = chassis == false ? 0 : chassis;
	karoseri = karoseri == false ? 0 : karoseri;

	var total_cash = parseInt(chassis) + parseInt(karoseri);

	$('#total_cash').val( moneyFormat.to( parseInt( total_cash)) );

});

$(document).ready(function () {

    $('#lunas_chassis').on('input', function() {
        $('#matauang_lunas_chassis').html( moneyFormat.to( parseInt($(this).val()) ) );
    });

    $('#dp_chassis').on('input', function() {
        $('#matauang_dp_chassis').html( moneyFormat.to( parseInt($(this).val()) ) );
    });

    $('#lunas_karoseri').on('input', function() {
        $('#matauang_lunas_karoseri').html( moneyFormat.to( parseInt($(this).val()) ) );
    });

    $('#dp_karoseri').on('input', function() {
        $('#matauang_dp_karoseri').html( moneyFormat.to( parseInt($(this).val()) ) );
    });
}); 

function detailArmada(id) {
	idData = id;
	$("#modalDetail").modal("show");
	$.post("/master/armada/getById/"+idData,function (json) {
		if (json.status == true) {
			$("#detailNamaArmada").html(json.data.nama);
			if (json.data.photo != "") {
				srcPhotoArmada = "/uploads/admin/master/armada/"+json.data.photo;
				$("#detailPhoto").attr("src",srcPhotoArmada);
			} else {
				srcPhotoArmada = "/assets/images/default/no_image.jpg";
				$("#detailPhoto").attr("src",srcPhotoArmada);
			}
			$("#detailNoBk").html(json.data.no_bk);
			$("#detailTglStnk").html(json.data.tgl_stnk);
			$("#detailTglBeli").html(json.data.tgl_beli);
			$("#detailThnArmada").html(json.data.tahun);
			$("#detailNoBpkb").html(json.data.no_bpkb);
			$("#detailNoMesin").html(json.data.no_mesin);
			$("#detailLokasiBpkb").html(json.data.lokasi_bpkb);
			$("#detailNotes").html(json.data.notes);
			$("#detailNoChassis").html(json.data.no_chassis);
			$("#detailTglChassis").html(json.data.tgl_chassis);

			$("#detailMerkChassis").html(json.data.merk);
			$("#detailTipeChassis").html(json.data.tipe);
			$("#detailVendorChassis").html(json.data.vendor_chassis);
			$("#detailStatusBeliChassis").html(json.data.status_beli_chassis_text);
			$("#detailLunasChassis").html(json.data.lunas_chassis_rp);
			$("#detail_form_dp_chassis").hide(1000);
			if (json.data.status_beli_chassis == 2) {
				$("#detail_form_dp_chassis").show(1000);
				$("#detailDPChassis").html(json.data.dp_chassis_rp);
			}

			$("#detailKaroseri").html(json.data.nama_karoseri);
			$("#detailTipeKaroseri").html(json.data.tipe_karoseri);
			$("#detailVendorKaroseri").html(json.data.vendor_karoseri);
			$("#detailStatusBeliKaroseri").html(json.data.status_beli_karoseri_text);
			$("#detailLunasKaroseri").html(json.data.lunas_karoseri_rp);
			$("#detail_form_dp_karoseri").hide(1000);
			if (json.data.status_beli_karoseri == 2) {
				$("#detail_form_dp_karoseri").show(1000);
				$("#detailDPKaroseri").html(json.data.dp_karoseri_rp);
			}
			$("#detailTotalBayarLunas").html(json.data.total_lunas_rp);
			$("#detailAC").html(json.data.ac_icon);
			$("#detailWIFI").html(json.data.wifi_icon);
					
		} else {
			$("#inputMessage").html(json.message);

			setTimeout(function() {
				$("#inputMessage").html("");
				$("#modalDetail").modal("show");
				reloadTable();
			},1000);
		}
	});
}

$("#photoPreview").hide(1000);
$("#btnPhoto").hide(1000);
$("#photo").show(1000);

var srcPhotoArmada;

function editArmada(id) {
	idData = id;
	$("#formProses").children().removeClass("card-fullscreen");
	
	$("#titleForm").text("Update Master Armada");
	$("#formProses").children().addClass("card-outline-warning");
	$("#formProses").children().removeClass("card-outline-primary");

	$("#iconForm").addClass("fa-pencil-square-o");
	$("#iconForm").removeClass("fa-plus");

	$("#dataTable").hide(1000);
	$("#formProses").show(1000);

	$("#photoDev").hide(1000);
	$("#photoPreview").show(1000);
	$("#btnPhoto").show(1000);

	$("#gantiPhoto").show(1000);
	$("#batalGanti").hide(1000);
	$("#hapusPhoto").show(1000);
	$("#is_delete").val(1);
	$("#hapusPhoto").text("Hapus photo");

	var drEvent = $('#photo').dropify();
	drEvent = drEvent.data('dropify');
	drEvent.resetPreview();
	drEvent.clearElement();

	$("#btnSimpan").attr("disabled",false);
	$("#btnSimpan").html('<i class="fa fa-save"></i> Simpan');

	$.post("/master/armada/getById/"+idData,function (json) {
		if (json.status == true) {
			$("#id_armada").val(json.data.id);
			$("#nama_armada").val(json.data.nama);

			$("#merk_chassis").val(json.data.merk_chassis_id).trigger('change');
			$("#tipe_chassis").val(json.data.tipe_chassis_id).trigger('change');
			$("#nama_karoseri").val(json.data.karoseri_id).trigger('change');
			$("#tipe_karoseri").val(json.data.tipe_karoseri_id).trigger('change');

			$("#thn_armada").val(json.data.tahun);
			$("#tgl_beli").val(json.data.tgl_beli);
			$("#tgl_chassis").val(json.data.tgl_chassis);
			$("#notes").val(json.data.notes);
			$("#no_chassis").val(json.data.no_chassis);
			$("#no_mesin").val(json.data.no_mesin);
			$("#no_bpkb").val(json.data.no_bpkb);
			$("#lokasi_bpkb").val(json.data.lokasi_bpkb);
			$("#no_bk").val(json.data.no_bk);
			$("#tgl_stnk").val(json.data.tgl_stnk);

			$("#status_beli_chassis").val(json.data.status_beli_chassis).trigger("change");
			$("#vendor_chassis").val(json.data.vendor_chassis_id).trigger("change");
			$("#lunas_chassis").val(json.data.lunas_chassis);
			$('#matauang_lunas_chassis').html(json.data.lunas_chassis_rp);

			$("#status_beli_karoseri").val(json.data.status_beli_karoseri).trigger("change");
			$("#vendor_karoseri").val(json.data.vendor_karoseri_id).trigger("change");
			$("#lunas_karoseri").val(json.data.lunas_karoseri);
			$('#matauang_lunas_karoseri').html(json.data.lunas_karoseri_rp);

			$("#total_cash").val(json.data.total_lunas_rp);

			if (json.data.dp_chassis == 0 && json.data.status_beli_chassis == 1) {
				$("#dp_chassis").val("");
				$("#form_dp").hide(1000);
				$('#matauang_dp_chassis').html("");
			} else {
				$("#dp_chassis").val(json.data.dp_chassis);
				$("#form_dp").show(1000);
				$('#matauang_dp_chassis').html(json.data.dp_chassis_rp);
			}

			if (json.data.dp_karoseri == 0 && json.data.status_beli_karoseri == 1) {
				$("#dp_karoseri").val("");
				$("#form_dp_karoseri").hide(1000);
				$('#matauang_dp_karoseri').html("");
			} else {
				$("#dp_karoseri").val(json.data.dp_karoseri);
				$("#form_dp_karoseri").show(1000);
				$('#matauang_dp_karoseri').html(json.data.dp_karoseri_rp);
			}
			
			if (json.data.photo != "") {
				$("#hapusPhoto").show(1000);
				srcPhotoArmada = "/uploads/admin/master/armada/"+json.data.photo;
				$("#imgArmada").attr("src",srcPhotoArmada);
			} else {
				$("#hapusPhoto").hide(1000);
				srcPhotoArmada = "/assets/images/default/no_image.jpg";
				$("#imgArmada").attr("src",srcPhotoArmada);
			}

			if (json.data.ac != 0) {
				$("#ac").prop("checked",true);
			} else {
				$("#ac").prop("checked",false);
			}

			if (json.data.wifi != 0) {
				$("#wifi").prop("checked",true);
			} else {
				$("#wifi").prop("checked",false);
			}

		} else {
			$("#inputMessage").html(json.message);

			setTimeout(function() {
				$("#inputMessage").html("");
				$("#dataTable").show(1000);
				$("#formProses").hide(1000);
			},1000);
		}
	});

	save_method = "update";
}

$("#batalGanti").hide(1000);
$("#gantiPhoto").click(function() {
	$("#batalGanti").show(1000);
	$("#gantiPhoto").hide(1000);
	$("#photoDev").show(1000);
	$("#photoPreview").hide(1000);
	$("#hapusPhoto").hide(1000);
});

$("#batalGanti").click(function() {
	$("#gantiPhoto").show(1000);
	$("#batalGanti").hide(1000);
	$("#photoDev").hide(1000);
	$("#photoPreview").show(1000);
	$("#hapusPhoto").show(1000);
	var drEvent = $('#photo').dropify();
	drEvent = drEvent.data('dropify');
	drEvent.resetPreview();
	drEvent.clearElement();
});

$("#hapusPhoto").click(function() {

	if ($("#is_delete").val() == 1) {
		$("#is_delete").val(0);
		$("#hapusPhoto").text("Batal Hapus photo");
		$("#imgArmada").attr("src","/assets/images/default/no_image.jpg");
	} else {
		$("#is_delete").val(1);
		$("#hapusPhoto").text("Hapus photo");
		$("#imgArmada").attr("src",srcPhotoArmada);
	}
	
});

$(".close-form").click(function() {
	$("#dataTable").show(1000);
	$("#formProses").hide(1000);
});


$.post("/master/chassis/getAllMerk",function(json) {
	var option;

	option = '<option value="">--Pilih Merk Chassis--</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.merk+'</option>';
	});

	$("#merk_chassis").html(option);
});

$.post("/master/chassis/getAllTipe",function(json) {
	var option;

	option = '<option value="">--Pilih Tipe Chassis--</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.tipe+'</option>';
	});

	$("#tipe_chassis").html(option);
});

/* master vendor */
$.post("/master/vendor/getAll",function(json) {
	var option;

	option = '<option value="">-- Pilih Vendor --</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.nama_vendor+'</option>';
	});

	$("#vendor_chassis").html(option);
	$("#vendor_karoseri").html(option);
});


$.post("/master/karoseri/getAllKaroseri",function(json) {
	var option;

	option = '<option value="">--Pilih Karoseri--</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.nama_karoseri+'</option>';
	});

	$("#nama_karoseri").html(option);
});

$.post("/master/karoseri/getAllTipe",function(json) {
	var option;

	option = '<option value="">--Pilih Tipe Karoseri--</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.tipe_karoseri+'</option>';
	});

	$("#tipe_karoseri").html(option);
});

$("#btnSimpan").click(function() {
	var url;
	if (save_method == "add") {
		url = '/master/armada/add';
	} else {
		url = '/master/armada/update/'+idData;
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
			            // html: true,
			            timer: 2000,   
			            showConfirmButton: false 
			        });

				setTimeout(function() {
					$("#formData")[0].reset();
					$("#inputMessage").html("");
					$("#dataTable").show(1000);
					$("#formProses").hide(1000);
					reloadTable();

					var drEvent = $('#photo').dropify();
					drEvent = drEvent.data('dropify');
					drEvent.resetPreview();
					drEvent.clearElement();

					$("#btnSimpan").attr("disabled",false);
					$("#btnSimpan").html('<i class="fa fa-save"></i> Simpan');

				}, 1500);
			} else {
				// $("#inputMessage").html(json.message);

				$("#errorNamaArmada").html(json.error.nama_armada);
				$("#errorMerk").html(json.error.merk);
				$("#errorTipe").html(json.error.tipe);
				$("#errorKaroseri").html(json.error.karoseri);
				$("#errorThnArmada").html(json.error.thn_armada);
				$("#errorTglBeli").html(json.error.tgl_beli);
				$("#errorTglChassis").html(json.error.tgl_chassis);
				$("#errorNoChassis").html(json.error.no_chassis);
				$("#errorNoMesin").html(json.error.no_mesin);
				$("#errorNoBpkb").html(json.error.no_bpkb);
				$("#errorLokasiBpkb").html(json.error.lokasi_bpkb);
				$("#errorNotes").html(json.error.notes);
				$("#errorNoBk").html(json.error.no_bk);
				$("#errorTglStnk").html(json.error.tgl_stnk);
				$("#errorStatusBeli").html(json.error.status_beli_chassis);
				$("#errorBayarLunas").html(json.error.lunas_chassis);

				if (json.error.photo) {
					$("#errorPhoto").html(json.error.photo);
					swal({   
			            title: "Error photo!",   
			            html: json.error.photo,
			            type: "error",
			        });

					setTimeout(function() {
						$("#errorPhoto").html("");

						$("#btnSimpan").attr("disabled",false);
						$("#btnSimpan").html('<i class="fa fa-save"></i> Simpan');

					}, 5000);
				} else {
					swal({   
			            title: "Error Form",   
			            html: json.message,
			            type: "error",
			        });
				}

				setTimeout(function() {
					$("#btnSimpan").attr("disabled",false);
					$("#btnSimpan").html('<i class="fa fa-save"></i> Simpan');

					$("#inputMessage").html("");

					$("#errorNamaArmada").html("");
					$("#errorMerk").html("");
					$("#errorTipe").html("");
					$("#errorKaroseri").html("");
					$("#errorThnArmada").html("");
					$("#errorTglBeli").html("");
					$("#errorTglChassis").html("");
					$("#errorNoChassis").html("");
					$("#errorNoMesin").html("");
					$("#errorNoBpkb").html("");
					$("#errorLokasiBpkb").html("");
					$("#errorNotes").html("");
					$("#errorNoBk").html("");
					$("#errorTglStnk").html("");
					$("#errorStatusBeli").html("");
					$("#errorBayarLunas").html("");
				}, 4000);
			}
		}
	});
});

function btnDelete(id) {
	idData = id;

	$.post("/master/armada/getId/"+idData,function(json) {
		if (json.status == true) {
			var kredit = "";
			if (json.data.status_beli_chassis == 2 || json.data.status_beli_karoseri == 2) {
				kredit = "dan master cicilan / kredit";
			}
			var pesan =	"<br>";
				pesan += "<small style='color:orange'>Note: Menghapus data ini juga akan Menghapus data master kps "+kredit+" yang berhubungan dengan data yang anda pilih ini.!</small>";
				pesan += "<hr> <div class='row'>";
				pesan += "<div class='col-md-4'>";
				pesan += "<label>Photo Armada :</label><br>";
				pesan += "<img src='"+json.data.photo+"' alt='Photo Armada' class='img img-responsive' style='width:100px; height:80px;'>";
				pesan += "</div>";
				pesan += "<div class='col-md-8'>";
				pesan += "<li class='pull-left'><small>Nama Armada : <i>"+json.data.nama+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Tahun : <i>"+json.data.tahun+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Merk chassis: <i>"+json.data.merk+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Tipe Chassis: <i>"+json.data.tipe+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Karoseri : <i>"+json.data.nama_karoseri+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Tipe Karoseri : <i>"+json.data.tipe_karoseri+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Tanggal Beli : <i>"+json.data.tgl_beli+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>No BK / Plat : <i>"+json.data.no_bk+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Tanggal STNK : <i>"+json.data.tgl_stnk+"</small></i></li><br>";
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
		    		$.post("/master/armada/delete/"+idData,function(json) {
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
