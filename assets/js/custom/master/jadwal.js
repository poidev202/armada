$(document).ready(function() {
	// table Senin
	tableAll("tblSenin","/master/jadwal/ajax_list/senin");

	// table Selasa
	tableAll("tblSelasa","/master/jadwal/ajax_list/selasa");

	// table Rabu
	tableAll("tblRabu","/master/jadwal/ajax_list/rabu");

	// table Kamis
	tableAll("tblKamis","/master/jadwal/ajax_list/kamis");

	// table Jumat
	tableAll("tblJumat","/master/jadwal/ajax_list/jumat");

	// table Sabtu
	tableAll("tblSabtu","/master/jadwal/ajax_list/sabtu");

	// table Minggu
	tableAll("tblMinggu","/master/jadwal/ajax_list/minggu");
});

function tableAll(idTable,urlTable) {

	$("#"+idTable).DataTable({
		serverSide:true,
		processing:false,
		ordering: true,
		oLanguage: {
            sProcessing: "<center><img src='img/denya/ajax-loader.gif' class='ajax-loader'></center>",
            sZeroRecords: "<center>Data tidak ditemukan</center>",
            sLengthMenu: "Tampilkan _MENU_ data",
            sSearch: "Cari data:",
            sInfo: "Menampilkan: _START_ - _END_ dari total: _TOTAL_ data",                                   
            oPaginate: {
                sFirst: "Awal", "sPrevious": "Sebelumnya",
                sNext: "Selanjutnya", "sLast": "Akhir"
            },
        },
		ajax:{
			url:urlTable,
			type:'POST',
		},
		order:[[2, 'ASC']],
		columns:[
			{
				data:'no',
				orderable:false,
				searchable:false,
			},
			{
				data:'hari',
				orderable:false,
				searchable:false,
			},
			{ data:'jam_menit' },
			{ data:'tujuan_awal' },
			{ data:'tujuan_akhir' },
			{
				data:'button_action',
				orderable:false,
				searchable:false,
			},

		],
	});
}

function reloadTable() {
	$("#tblSenin").DataTable().ajax.reload(null,false);
	$("#tblSelasa").DataTable().ajax.reload(null,false);
	$("#tblRabu").DataTable().ajax.reload(null,false);
	$("#tblKamis").DataTable().ajax.reload(null,false);
	$("#tblJumat").DataTable().ajax.reload(null,false);
	$("#tblSabtu").DataTable().ajax.reload(null,false);
	$("#tblMinggu").DataTable().ajax.reload(null,false);
}

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
	$("#modalForm").modal("show");
	$("#formData")[0].reset();
	$("#hari").val("").trigger('change');

	$(".modal-title").text("Tambah Master Jadwal");
	save_method = "add";
});


function editJadwal(id) {
	idData = id;
	$("#modalForm").modal("show");
	$(".modal-title").text("Update Master Jadwal");
	save_method = "update";

	$.post("/master/jadwal/getId/"+idData,function(json) {
		if (json.status == true) {
			$("#hari").val(json.data.hari).trigger('change');
			$('#jam').val(json.data.jam_menit);
			$('#tujuan_awal').val(json.data.tujuan_awal);
		    $("#tujuan_akhir").val(json.data.tujuan_akhir);
		} else {
			$("#inputMessage").html(json.message);

			$("#hari").val("").trigger('change');
			$("#jam").val("");
			$("#tujuan_awal").val("");
		    $("#tujuan_akhir").val("");

			setTimeout(function() {
				reloadTable();
				$("#modalForm").modal("hide");
			},1000);
		}
	});

}

$("#modalButtonSave").click(function() {
	var url;
	if (save_method == "add") {
		url = '/master/jadwal/add';
	} else {
		url = '/master/jadwal/update/'+idData;
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
			            timer: 2000,   
			            showConfirmButton: false 
			        });

				setTimeout(function() {
					$("#formData")[0].reset();
					$("#modalForm").modal("hide");
					$("#inputMessage").html("");
					reloadTable();
				}, 1500);
			} else {
		
				if (json.error.duplicate == true) {
					$("#inputMessage").html(json.message);

					var pesan = "";
					pesan += "<li class='pull-left'><small>Hari : <i>"+json.data.hari+"</i></small></li><br>";
					pesan += "<li class='pull-left'><small>Jam: <i>"+json.data.jam_menit+"</i></small></li><br>";
					pesan += "<li class='pull-left'><small>Tujuan Awal: <i>"+json.data.tujuan_awal+"</i></small></li><br>";
					pesan += "<li class='pull-left'><small>Tujuan Akhir: <i>"+json.data.tujuan_akhir+"</i></small></li><br>";

					swal({   
			            title: json.message,   
			            html: pesan,
			            type: "error",
			        });

				} else {
					$("#errorHari").html(json.error.hari);
					$("#errorJam").html(json.error.jam);
					$("#errorTujuanAwal").html(json.error.tujuan_awal);
					$("#errorTujuanAkhir").html(json.error.tujuan_akhir);
					swal({   
			            title: "Error Form.!",   
			            html: json.message,
			            type: "error",
			        });
				}

				setTimeout(function() {
					$("#inputMessage").html("");
					$("#errorHari").html("");
					$("#errorJam").html("");
					$("#errorTujuanAwal").html("");
					$("#errorTujuanAkhir").html("");
				},3000);
			}
		}
	});
});

function btnDelete(id) {
	idData = id;

	$.post("/master/jadwal/getId/"+idData,function(json) {
		if (json.status == true) {

			var pesan = "<hr>";
				pesan += "<li class='pull-left'><small>Hari : <i>"+json.data.hari+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Jam: <i>"+json.data.jam_menit+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Tujuan Awal: <i>"+json.data.tujuan_awal+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Tujuan Akhir: <i>"+json.data.tujuan_akhir+"</i></small></li><br>";

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
		    		$.post("/master/jadwal/delete/"+idData,function(json) {
						if (json.status == true) {
							swal({    
						            title: json.message,
						            type: "success",
						            timer: 2000,   
						            showConfirmButton: false 
						        });
							reloadTable();
						} else {
							swal({    
						            title: json.message,
						            type: "error",
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
		            timer: 1000,   
		            showConfirmButton: false 
		        });
		}
	});
}