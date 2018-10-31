$(document).ready(function() {

	$("#tblKaroseri").DataTable({
		serverSide:true,
		responsive:true,
		processing:false,
		oLanguage: {
            sZeroRecords: "<center>Data tidak ditemukan</center>",
            sLengthMenu: "Tampil _MENU_",
            sSearch: "Cari:",
            sInfo: "Menampilkan: _START_ - _END_ dari total: _TOTAL_ data",                                   
            oPaginate: {
                sFirst: "Awal", "sPrevious": "Sebelumnya",
                sNext: "Selanjutnya", "sLast": "Akhir"
            },
        },
		//load data
		ajax: {
			url: '/master/karoseri/ajax_list_karoseri',
			type: 'POST',
		},

		order:[[1,'ASC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'nama_karoseri' },
			{
				data:'button_action',
				searchable:false,
				orderable:false,
			}
		],
	});

	$("#tblTipe").DataTable({
		serverSide:true,
		responsive:true,
		processing:false,
		oLanguage: {
            sZeroRecords: "<center>Data tidak ditemukan</center>",
            sLengthMenu: "Tampil _MENU_",
            sSearch: "Cari:",
            sInfo: "Menampilkan: _START_ - _END_ dari total: _TOTAL_ data",                                   
            oPaginate: {
                sFirst: "Awal", "sPrevious": "Sebelumnya",
                sNext: "Selanjutnya", "sLast": "Akhir"
            },
        },
		//load data
		ajax: {
			url: '/master/karoseri/ajax_list_tipe',
			type: 'POST',
		},

		order:[[1,'ASC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'tipe_karoseri' },
			{
				data:'button_action',
				searchable:false,
				orderable:false,
			}
		],
	});
});

function reloadTableKaroseri() {
	$("#tblKaroseri").DataTable().ajax.reload(null,false);
}

function reloadTableTipe() {
	$("#tblTipe").DataTable().ajax.reload(null,false);
}

var save_method;
var idData;

/*untuk karoseri*/
$(document).on('click', '#btnRefreshKaroseri', function(e) {
	e.preventDefault();
	reloadTableKaroseri();
	$("#btnRefreshKaroseri").children().addClass("fa-spin");
	setTimeout(function(){
	  $("#btnRefreshKaroseri").children().removeClass("fa-spin");
	}, 1000);
});

$(document).on('click', '#btnTambahKaroseri', function (e) {
	e.preventDefault();
	// alert("test data tambah");
	$("#modalFormKaroseri").modal("show");
	$("#formDataKaroseri")[0].reset();
	$(".modal-title").text("Tambah Karoseri");
	save_method = "add";
});

function editKaroseri(id) {
	$("#modalFormKaroseri").modal("show");
	$(".modal-title").text("Edit Karoseri");
	save_method = "update";
	idData = id;
	$.post('/master/karoseri/getIdKaroseri/'+idData,function(json) {
		if (json.status == true) {
			$("#nama_karoseri").val(json.data.nama_karoseri);
		} else {
			$("#nama_karoseri").val("");
			$("#inputMessageKaroseri").html(json.message);
			reloadTableKaroseri();
			setTimeout(function() {
				$("#inputMessageKaroseri").html("");
				$("#modalFormKaroseri").modal("hide");
			},1000);
		}
	});
}


$("#modalBtnKaroseri").click(function() {
	var url;
	if (save_method == "add") {
		url = '/master/karoseri/addKaroseri';
	} else {
		url = '/master/karoseri/updateKaroseri/'+idData;
	}

	$.ajax({
		url: url,
		type:'POST',
		data:$("#formDataKaroseri").serialize(),
		dataType:'JSON',
		success: function(json) {
			if (json.status == true) {
				$("#inputMessageKaroseri").html(json.message);
				setTimeout(function() {
					$("#formDataKaroseri")[0].reset();
					$("#modalFormKaroseri").modal("hide");
					$("#inputMessageKaroseri").html("");
					reloadTableKaroseri();
				}, 1500);
			} else {
				$("#errorKaroseri").html(json.error.nama_karoseri);

				setTimeout(function() {
					$("#errorKaroseri").html("");
				}, 4000);
			}
		}
	});
});

function btnDeleteKaroseri(id) {
	idData = id;
	$("#modalDeleteKaroseri").modal("show");
	$("#modalTitleDelete").text("Hapus Karoseri");

	$.post("/master/karoseri/getIdKaroseri/"+idData,function(json) {
		if (json.status == true) {
			$(".inputData").html( 'Nama Karoseri : '+json.data.nama_karoseri );
		} else {
			$(".contentDelete").hide();
			$(".inputData").hide();
			$(".inputMessageDelete").html(json.message);
			setTimeout(function() {
				$("#modalDeleteKaroseri").modal("hide");
				$(".inputMessageDelete").html("");
				$(".contentDelete").show();
				$(".inputData").show();
				reloadTableKaroseri();
			},1000);
		}
	});
}

$("#modalBtnDeleteKaroseri").click(function() {
	$.post("/master/karoseri/deleteKaroseri/"+idData,function(json) {
		if (json.status == true) {
			$(".inputData").hide();
			$(".contentDelete").hide();
			$(".inputMessageDelete").html(json.message);
			setTimeout(function() {
				$(".contentDelete").show();
				$(".inputData").show();
				$("#modalDeleteKaroseri").modal("hide");
				$(".inputMessageDelete").html("");
				reloadTableKaroseri();
			},1500);
		} else {
			$(".contentDelete").hide();
			$("inputMessageDelete").html(json.message);
			reloadTableKaroseri();
			setTimeout(function() {
				$(".contentDelete").show();
				$("#modalDeleteKaroseri").modal("hide");
				$(".inputMessageDelete").html("");
			},1000);
		}
	});
});


/*Untuk tipe*/
$(document).on('click', '#btnRefreshTipe', function(e) {
	e.preventDefault();
	reloadTableTipe();
	$("#btnRefreshTipe").children().addClass("fa-spin");
	setTimeout(function(){
	  $("#btnRefreshTipe").children().removeClass("fa-spin");
	}, 1000);
});

$(document).on('click', '#btnTambahTipe', function (e) {
	e.preventDefault();
	// alert("test data tambah");
	$("#modalFormTipe").modal("show");
	$("#formDataTipe")[0].reset();
	$(".modal-title").text("Tambah Tipe");
	save_method = "add";
});

function editTipe(id) {
	$("#modalFormTipe").modal("show");
	$(".modal-title").text("Edit Tipe");
	save_method = "update";
	idData = id;
	$.post('/master/karoseri/getIdTipe/'+idData,function(json) {
		if (json.status == true) {
			$("#nama_tipe").val(json.data.tipe_karoseri);
		} else {
			$("#nama_tipe").val("");
			$("#inputMessageTipe").html(json.message);
			reloadTableTipe();
			setTimeout(function() {
				$("#inputMessageTipe").html("");
				$("#modalFormTipe").modal("hide");
			},1000);
		}
	});
}


$("#modalBtnTipe").click(function() {
	var url;
	if (save_method == "add") {
		url = '/master/karoseri/addTipe';
	} else {
		url = '/master/karoseri/updateTipe/'+idData;
	}

	$.ajax({
		url: url,
		type:'POST',
		data:$("#formDataTipe").serialize(),
		dataType:'JSON',
		success: function(json) {
			if (json.status == true) {
				$("#inputMessageTipe").html(json.message);
				setTimeout(function() {
					$("#formDataTipe")[0].reset();
					$("#modalFormTipe").modal("hide");
					$("#inputMessageTipe").html("");
					reloadTableTipe();
				}, 1500);
			} else {
				$("#errorTipe").html(json.error.nama_tipe);

				setTimeout(function() {
					$("#errorTipe").html("");
				}, 4000);
			}
		}
	});
});

function btnDeleteTipe(id) {
	idData = id;
	$("#modalDeleteTipe").modal("show");
	$("#modalTitleDelete").text("Hapus Tipe");

	$.post("/master/karoseri/getIdTipe/"+idData,function(json) {
		if (json.status == true) {
			$(".inputData").html( 'Nama Tipe : '+json.data.tipe_karoseri );
		} else {
			$(".contentDelete").hide();
			$(".inputData").hide();
			$(".inputMessageDelete").html(json.message);
			setTimeout(function() {
				$("#modalDeleteTipe").modal("hide");
				$(".inputMessageDelete").html("");
				$(".contentDelete").show();
				$(".inputData").show();
				reloadTableTipe();
			},1000);
		}
	});
}

$("#modalBtnDeleteTipe").click(function() {
	$.post("/master/karoseri/deleteTipe/"+idData,function(json) {
		if (json.status == true) {
			$(".inputData").hide();
			$(".contentDelete").hide();
			$(".inputMessageDelete").html(json.message);
			setTimeout(function() {
				$(".contentDelete").show();
				$(".inputData").show();
				$("#modalDeleteTipe").modal("hide");
				$(".inputMessageDelete").html("");
				reloadTableTipe();
			},1500);
		} else {
			$(".contentDelete").hide();
			$("inputMessageDelete").html(json.message);
			reloadTableTipe();
			setTimeout(function() {
				$(".contentDelete").show();
				$("#modalDeleteTipe").modal("hide");
				$(".inputMessageDelete").html("");
			},1000);
		}
	});
});
