$(document).ready(function() {
	
	btnTambah = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-primary btn-sm' id='btnTambah'><i class='fa fa-plus'></i> Tambah</button>";
   	
    btnRefresh = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-success btn-sm' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button>";

	$("#tblMasterKPS").DataTable({
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
			url: '/master/kps/ajax_list',
			type: 'POST',
		},

		order:[[1,'ASC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'no_kps' },
			{ data:'nama' },
			{
				data:'photo',
				searchable:false,
				orderable:false,
			},
			{ data:'tahun' },
			{ data:'tipe' },
			{ data:'no_bk' },
			{ data:'tgl_jatuh_tempo' },
			{ data:'tujuan_awal' },
			{ data:'tujuan_akhir' },
			{
				data:'button_action',
				searchable:false,
				orderable:false,
			}
		],
	});

});

function reloadTable() {
	$("#tblMasterKPS").DataTable().ajax.reload(null,false);
}

$("#dataTable").show();
$("#formProses").hide();

$(".close-form").click(function() {
	$("#dataTable").show();
	$("#formProses").hide();

    $("#tags_trayek").tagsinput('removeAll'); 
});

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
	
	$("#formData")[0].reset();
	$("#titleForm").text("Tambah Master KPS");
	$("#ribbonTitle").removeClass("ribbon-warning");
	$("#ribbonTitle").addClass("ribbon-primary");

	$("#iconForm").addClass("fa-plus");
	$("#iconForm").removeClass("fa-pencil-square-o");

	$('#nama_armada').val("").trigger('change');
	$("#imgArmada").attr("src","/assets/images/default/no_image.jpg");

	$("#dataTable").hide();
	$("#formProses").show();

	$("#tags_trayek").tagsinput('refresh'); 

	save_method = "add";
});

$.post("/master/armada/getAll",function (json) {
	option = '<option value="">--Pilih Armada--</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.nama+'</option>';
	});

	$("#nama_armada").html(option);
});

var idArmada;
$("#nama_armada").change(function () {

	id_val = $("#nama_armada").val();
	if (id_val != "") {

		idArmada = id_val;
		$.post("/master/armada/getId/"+idArmada,function (json) {
			if (json.status == true) {
				$("#imgArmada").attr("src",json.data.photo);
				$("#no_bk").val(json.data.no_bk);
				$("#tahun").val(json.data.tahun);
				$("#karoseri").val(json.data.nama_karoseri);
				$("#tipe_karoseri").val(json.data.tipe_karoseri);
				$("#merk_chassis").val(json.data.merk);
				$("#tipe_chassis").val(json.data.tipe);
			} else {
				$("#errorNamaArmada").html(json.message);
			}
		});
	} else {

		$("#imgArmada").attr("src","/assets/images/default/no_image.jpg");
		$("#no_bk").val("");
		$("#tahun").val("");
		$("#karoseri").val("");
		$("#tipe_karoseri").val("");
		$("#merk_chassis").val("");
		$("#tipe_chassis").val("");
	}
});

function detailKPS(id) {
	idData = id;
	$("#modalDetail").modal("show");

	$.post("/master/kps/getId/"+idData,function(json) {
		if (json.status == true) {
			$("#detailNamaArmada").html(json.data.nama);
			$("#imgDetailArmada").attr("src",json.data.photo);
			$("#detailNoBK").html(json.data.no_bk);
			$("#detailTahun").html(json.data.tahun);
			$("#detailMerkChassis").html(json.data.merk);
			$("#detailTipeChassis").html(json.data.tipe);
			$("#detailKaroseri").html(json.data.nama_karoseri);
			$("#detailTipeKaroseri").html(json.data.tipe_karoseri);

			$("#detailNoKPS").html(json.data.no_kps);
			$("#detailTglJatuhTempo").html(json.data.tgl_jatuh_tempo_indo);
			$("#detailTrayek").html(json.data.trayek);
			$("#detailTujuanAwal").html(json.data.tujuan_awal);
			$("#detailTujuanAkhir").html(json.data.tujuan_akhir);

			/*if (json.restrict_session == true) {
				// window.location.href = "/auth";
				window.location.reload();
			}*/

		} else {
			$("#inputMessageDetail").html(json.message);

			$("#detailNamaArmada").html("");
			$("#imgDetailArmada").attr("src","/assets/images/default/no_image.jpg");
			$("#detailNoBK").html("");
			$("#detailTahun").html("");
			$("#detailMerkChassis").html("");
			$("#detailTipeChassis").html("");
			$("#detailKaroseri").html("");
			$("#detailTipeKaroseri").html("");

			$("#detailNoKPS").html("");
			$("#detailTglJatuhTempo").html("");
			$("#detailTrayek").html("");
			$("#detailTujuanAwal").html("");
			$("#detailTujuanAkhir").html("");

			setTimeout(function() {
				$("#inputMessageDetail").html("");
				reloadTable();
				$("#modalDetail").modal("hide");
			},1000);
		}
	});
}

function editKPS(id) {
	idData = id;
	$("#titleForm").text("Update Master KPS");
	$("#ribbonTitle").removeClass("ribbon-primary");
	$("#ribbonTitle").addClass("ribbon-warning");

	$("#iconForm").removeClass("fa-plus");
	$("#iconForm").addClass("fa-pencil-square-o");

	$("#dataTable").hide();
	$("#formProses").show();

	$.post("/master/kps/getId/"+idData,function(json) {
		if (json.status == true) {
			$('#nama_armada').val(json.data.master_armada_id).trigger('change');
			$("#no_kps").val(json.data.no_kps);
			$("#tgl_jatuh_tempo").val(json.data.tgl_jatuh_tempo);

		    $("#tags_trayek").val(json.data.trayek_tags);
		    $("#tags_trayek").tagsinput('add',json.data.trayek_tags); 
		} else {
			$("#inputMessage").html(json.message);
			$("#imgArmada").attr("src","/assets/images/default/no_image.jpg");
			$("#no_kps").val("");
			$("#tgl_jatuh_tempo").val("");

			setTimeout(function() {
				reloadTable();
				$("#dataTable").show();
				$("#formProses").hide();
				$("#inputMessage").html("");
			},1000);
		}
	});

	save_method = "update";
}

$("#btnSimpan").click(function() {
	var url;
	if (save_method == "add") {
		url = '/master/kps/add';
	} else {
		url = '/master/kps/update/'+idData;
	}

	$.ajax({
		url: url,
		type:'POST',
		data:$("#formData").serialize(),
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
					$("#dataTable").show();
					$("#formProses").hide();
					
					$("#inputMessage").html("");
					reloadTable();
				}, 1500);
			} else {
				$("#errorNamaArmada").html(json.error.nama_armada);
				$("#errorNoKPS").html(json.error.no_kps);
				$("#errorTglJatuhTempo").html(json.error.tgl_jatuh_tempo);
				$("#errorTrayek").html(json.error.trayek);

				// swal("Form ada yang belum di isi.!", json.message, "error");

				swal({   
			            title: "Error Form.!",   
			            html: json.message,
			            type: "error",
			            // html: true
			        });

				setTimeout(function() {
					$("#errorNamaArmada").html("");
					$("#errorNoKPS").html("");
					$("#errorTglJatuhTempo").html("");
					$("#errorTrayek").html("");
				},3000);
			}
		}
	});
});

function btnDelete(id) {
	idData = id;

	$.post("/master/kps/getId/"+idData,function(json) {
		if (json.status == true) {

			var pesan = "<hr> <div class='row'>";
				pesan += "<div class='col-md-4'>";
				pesan += "<label>Photo Armada :</label><br>";
				pesan += "<img src='"+json.data.photo+"' alt='Photo Armada' class='img img-responsive' style='width:100px; height:80px;'><br>";
				pesan += "</div>";
				pesan += "<div class='col-md-8'>";
				pesan += "<li class='pull-left'><small>No KPS : <i>"+json.data.no_kps+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Nama Armada : <i>"+json.data.nama+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Tahun : <i>"+json.data.tahun+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>No BK / Plat : <i>"+json.data.no_bk+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Tgl Jatuh Tempo : <i>"+json.data.tgl_jatuh_tempo_indo+"</i></small></li><br>";
				pesan += "</div>";
				pesan += "</div><br>";
				pesan += "<div class='row'>";
				pesan += "<div class='col-md-7'>";
				pesan += "<li class='pull-left'><small>Karoseri : <i>"+json.data.nama_karoseri+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Tipe Karoseri: <i>"+json.data.tipe_karoseri+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Merk Chassis : <i>"+json.data.merk+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Tipe Chassis: <i>"+json.data.tipe+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Tujuan Awal : <i>"+json.data.tujuan_awal+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Tujuan Akhir : <i>"+json.data.tujuan_akhir+"</i></small></li><br>";
				pesan += "</div>";
				pesan += "<div class='col-md-5'>";
				pesan += "<small>Trayek Tujuan : <br> <i>"+json.data.trayek+"</i></small><br>";
				pesan += "</div>";
				pesan += "</div>";

		    swal({   
		        title: "Apakah anda yakin.?",   
		        html: "<span style='color:red;'>Data yang di <b>Hapus</b> tidak bisa dikembalikan lagi.</span>"+pesan,
		        type: "warning", 
				// html: true,
  				showCloseButton: true,
		        showCancelButton: true,   
		        confirmButtonColor: "#DD6B55",   
		        confirmButtonText: "Iya, Hapus",   
		        closeOnConfirm: false 
		    }).then((result) => {
		    	if (result.value) {
		    		$.post("/master/kps/delete/"+idData,function(json) {
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


function btnDeleteOld(id) {
	idData = id;
	$("#modalDelete").modal("show");
	$("#modalTitleDelete").text("Hapus Trayek");

	$.post("/master/kps/getId/"+idData,function(json) {
		if (json.status == true) {
			infoData =	'<b> No KPS : </b> <i>'+json.data.no_kps+'</i> <br>';
			infoData += '<b> Nama Armada : </b> <i>'+json.data.nama+'</i> <br> ';
			infoData += '<b> No BK / Plat : </b> <i>'+json.data.no_bk+'</i> <br> ';

			$(".inputData").html(infoData);
		} else {
			$(".contentDelete").hide();
			$(".inputData").hide();
			$(".inputMessageDelete").html(json.message);
			setTimeout(function() {
				$("#modalDelete").modal("hide");
				$(".inputMessageDelete").html("");
				$(".contentDelete").show();
				$(".inputData").show();
				reloadTable();
			},1000);
		}
	});
}

$("#modalButtonDelete").click(function() {
	$.post("/master/kps/delete/"+idData,function(json) {
		if (json.status == true) {
			$(".inputData").hide();
			$(".contentDelete").hide();
			$(".inputMessageDelete").html(json.message);
			setTimeout(function() {
				$(".contentDelete").show();
				$(".inputData").show();
				$("#modalDelete").modal("hide");
				$(".inputMessageDelete").html("");
				reloadTable();
			},1500);
		} else {
			$(".contentDelete").hide();
			$(".inputMessageDelete").html(json.message);
			reloadTable();
			setTimeout(function() {
				$(".contentDelete").show();
				$("#modalDelete").modal("hide");
				$(".inputMessageDelete").html("");
			},1000);
		}
	});
});
