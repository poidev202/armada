$(document).ready(function() {
	
    btnTambahMerk = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-primary btn-sm' id='btnTambahMerk'><i class='fa fa-plus'></i> Tambah</button>";
   	
    btnRefreshMerk = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-secondary btn-sm' id='btnRefreshMerk'><i class='fa fa-refresh'></i> Refresh</button>";

	$("#tblMerk").DataTable({
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
			url: '/master/chassis/ajax_list_merk',
			type: 'POST',
		},

		order:[[1,'ASC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'merk' },
			{
				data:'button_action',
				searchable:false,
				orderable:false,
			}
		],
	});


	btnTambahTipe = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-primary btn-sm' id='btnTambahTipe'><i class='fa fa-plus'></i> Tambah</button>";
   	
    btnRefreshTipe = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-secondary btn-sm' id='btnRefreshTipe'><i class='fa fa-refresh'></i> Refresh</button>";

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
			url: '/master/chassis/ajax_list_tipe',
			type: 'POST',
		},

		order:[[1,'ASC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'tipe' },
			{
				data:'button_action',
				searchable:false,
				orderable:false,
			}
		],
	});
});

function reloadTableMerk() {
	$("#tblMerk").DataTable().ajax.reload(null,false);
}

function reloadTableTipe() {
	$("#tblTipe").DataTable().ajax.reload(null,false);
}

var save_method;
var idData;

/*untuk merk*/
$(document).on('click', '#btnRefreshMerk', function(e) {
	e.preventDefault();
	reloadTableMerk();
	$("#btnRefreshMerk").children().addClass("fa-spin");
	setTimeout(function(){
	  $("#btnRefreshMerk").children().removeClass("fa-spin");
	}, 1000);
});

$(document).on('click', '#btnTambahMerk', function (e) {
	e.preventDefault();
	// alert("test data tambah");
	$("#modalFormMerk").modal("show");
	$("#formDataMerk")[0].reset();
	$(".modal-title").text("Tambah Merk");
	save_method = "add";
});

function editMerk(id) {
	$("#modalFormMerk").modal("show");
	$(".modal-title").text("Edit Merk");
	save_method = "update";
	idData = id;
	$.post('/master/chassis/getIdMerk/'+idData,function(json) {
		if (json.status == true) {
			$("#nama_merk").val(json.data.merk);
		} else {
			$("#nama_merk").val("");
			$("#inputMessageMerk").html(json.message);
			reloadTableMerk();
			setTimeout(function() {
				$("#inputMessageMerk").html("");
				$("#modalFormMerk").modal("hide");
			},1000);
		}
	});
}


$("#modalBtnMerk").click(function() {
	var url;
	if (save_method == "add") {
		url = '/master/chassis/addMerk';
	} else {
		url = '/master/chassis/updateMerk/'+idData;
	}

	$.ajax({
		url: url,
		type:'POST',
		data:$("#formDataMerk").serialize(),
		dataType:'JSON',
		success: function(json) {
			if (json.status == true) {
				$("#inputMessageMerk").html(json.message);
				setTimeout(function() {
					$("#formDataMerk")[0].reset();
					$("#modalFormMerk").modal("hide");
					$("#inputMessageMerk").html("");
					reloadTableMerk();
				}, 1500);
			} else {
				$("#errorMerk").html(json.error.merk);

				setTimeout(function() {
					$("#errorMerk").html("");
				}, 4000);
			}
		}
	});
});

function btnDeleteMerk(id) {
	idData = id;
	$("#modalDeleteMerk").modal("show");
	$("#modalTitleDelete").text("Hapus Merk");

	$.post("/master/chassis/getIdMerk/"+idData,function(json) {
		if (json.status == true) {
			$(".inputData").html( 'Nama Merk : '+json.data.merk );
		} else {
			$(".contentDelete").hide();
			$(".inputData").hide();
			$(".inputMessageDelete").html(json.message);
			setTimeout(function() {
				$("#modalDeleteMerk").modal("hide");
				$(".inputMessageDelete").html("");
				$(".contentDelete").show();
				$(".inputData").show();
				reloadTableMerk();
			},1000);
		}
	});
}

$("#modalBtnDeleteMerk").click(function() {
	$.post("/master/chassis/deleteMerk/"+idData,function(json) {
		if (json.status == true) {
			$(".inputData").hide();
			$(".contentDelete").hide();
			$(".inputMessageDelete").html(json.message);
			setTimeout(function() {
				$(".contentDelete").show();
				$(".inputData").show();
				$("#modalDeleteMerk").modal("hide");
				$(".inputMessageDelete").html("");
				reloadTableMerk();
			},1500);
		} else {
			$(".contentDelete").hide();
			$("inputMessageDelete").html(json.message);
			reloadTableMerk();
			setTimeout(function() {
				$(".contentDelete").show();
				$("#modalDeleteMerk").modal("hide");
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
	$.post('/master/chassis/getIdTipe/'+idData,function(json) {
		if (json.status == true) {
			$("#nama_tipe").val(json.data.tipe);
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
		url = '/master/chassis/addTipe';
	} else {
		url = '/master/chassis/updateTipe/'+idData;
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
				$("#errorTipe").html(json.error.tipe);

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

	$.post("/master/chassis/getIdTipe/"+idData,function(json) {
		if (json.status == true) {
			$(".inputData").html( 'Nama Tipe : '+json.data.tipe );
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
	$.post("/master/chassis/deleteTipe/"+idData,function(json) {
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
