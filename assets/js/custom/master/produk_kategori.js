$(document).ready(function() {

	$("#tblKategori").DataTable({
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
			url: '/master/produkkategori/ajax_list_kategori',
			type: 'POST',
		},

		order:[[1,'ASC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'kategori' },
			{
				data:'button_action',
				searchable:false,
				orderable:false,
			}
		],
	});

	$("#tblUnit").DataTable({
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
			url: '/master/produkkategori/ajax_list_Unit',
			type: 'POST',
		},

		order:[[1,'ASC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'unit' },
			{
				data:'button_action',
				searchable:false,
				orderable:false,
			}
		],
	});
});

function reloadTableKategori() {
	$("#tblKategori").DataTable().ajax.reload(null,false);
}

function reloadTableUnit() {
	$("#tblUnit").DataTable().ajax.reload(null,false);
}

var save_method;
var idData;

/*untuk kategori*/
$(document).on('click', '#btnRefreshKategori', function(e) {
	e.preventDefault();
	reloadTableKategori();
	$("#btnRefreshKategori").children().addClass("fa-spin");
	setTimeout(function(){
	  $("#btnRefreshKategori").children().removeClass("fa-spin");
	}, 1000);
});

$(document).on('click', '#btnTambahKategori', function (e) {
	e.preventDefault();
	// alert("test data tambah");
	$("#modalFormKategori").modal("show");
	$("#formDataKategori")[0].reset();
	$(".modal-title").text("Tambah Kategori");
	save_method = "add";
});

function editKategori(id) {
	$("#modalFormKategori").modal("show");
	$(".modal-title").text("Edit Kategori");
	save_method = "update";
	idData = id;
	$.post('/master/produkkategori/getIdKategori/'+idData,function(json) {
		if (json.status == true) {
			$("#kategori").val(json.data.kategori);
		} else {
			$("#kategori").val("");
			$("#inputMessageKategori").html(json.message);
			reloadTableKategori();
			setTimeout(function() {
				$("#inputMessageKategori").html("");
				$("#modalFormKategori").modal("hide");
			},1000);
		}
	});
}


$("#modalBtnKategori").click(function() {
	var url;
	if (save_method == "add") {
		url = '/master/produkkategori/addKategori';
	} else {
		url = '/master/produkkategori/updateKategori/'+idData;
	}

	$.ajax({
		url: url,
		type:'POST',
		data:$("#formDataKategori").serialize(),
		dataType:'JSON',
		success: function(json) {
			if (json.status == true) {
				$("#inputMessageKategori").html(json.message);
				setTimeout(function() {
					$("#formDataKategori")[0].reset();
					$("#modalFormKategori").modal("hide");
					$("#inputMessageKategori").html("");
					reloadTableKategori();
				}, 1500);
			} else {
				$("#errorKategori").html(json.error.kategori);

				setTimeout(function() {
					$("#errorKategori").html("");
				}, 4000);
			}
		}
	});
});

function btnDeleteKategori(id) {
	idData = id;
	$("#modalDeleteKategori").modal("show");
	$("#modalTitleDelete").text("Hapus Kategori");

	$.post("/master/produkkategori/getIdKategori/"+idData,function(json) {
		if (json.status == true) {
			$(".inputData").html( 'Nama Kategori : '+json.data.kategori );
		} else {
			$(".contentDelete").hide();
			$(".inputData").hide();
			$(".inputMessageDelete").html(json.message);
			setTimeout(function() {
				$("#modalDeleteKategori").modal("hide");
				$(".inputMessageDelete").html("");
				$(".contentDelete").show();
				$(".inputData").show();
				reloadTableKategori();
			},1000);
		}
	});
}

$("#modalBtnDeleteKategori").click(function() {
	$.post("/master/produkkategori/deleteKategori/"+idData,function(json) {
		if (json.status == true) {
			$(".inputData").hide();
			$(".contentDelete").hide();
			$(".inputMessageDelete").html(json.message);
			setTimeout(function() {
				$(".contentDelete").show();
				$(".inputData").show();
				$("#modalDeleteKategori").modal("hide");
				$(".inputMessageDelete").html("");
				reloadTableKategori();
			},1500);
		} else {
			$(".contentDelete").hide();
			$("inputMessageDelete").html(json.message);
			reloadTableKategori();
			setTimeout(function() {
				$(".contentDelete").show();
				$("#modalDeleteKategori").modal("hide");
				$(".inputMessageDelete").html("");
			},1000);
		}
	});
});


/*Untuk Unit*/
$(document).on('click', '#btnRefreshUnit', function(e) {
	e.preventDefault();
	reloadTableUnit();
	$("#btnRefreshUnit").children().addClass("fa-spin");
	setTimeout(function(){
	  $("#btnRefreshUnit").children().removeClass("fa-spin");
	}, 1000);
});

$(document).on('click', '#btnTambahUnit', function (e) {
	e.preventDefault();
	// alert("test data tambah");
	$("#modalFormUnit").modal("show");
	$("#formDataUnit")[0].reset();
	$(".modal-title").text("Tambah Unit");
	save_method = "add";
});

function editUnit(id) {
	$("#modalFormUnit").modal("show");
	$(".modal-title").text("Edit Unit");
	save_method = "update";
	idData = id;
	$.post('/master/produkkategori/getIdUnit/'+idData,function(json) {
		if (json.status == true) {
			$("#unit").val(json.data.unit);
		} else {
			$("#unit").val("");
			$("#inputMessageUnit").html(json.message);
			reloadTableUnit();
			setTimeout(function() {
				$("#inputMessageUnit").html("");
				$("#modalFormUnit").modal("hide");
			},1000);
		}
	});
}


$("#modalBtnUnit").click(function() {
	var url;
	if (save_method == "add") {
		url = '/master/produkkategori/addUnit';
	} else {
		url = '/master/produkkategori/updateUnit/'+idData;
	}

	$.ajax({
		url: url,
		type:'POST',
		data:$("#formDataUnit").serialize(),
		dataType:'JSON',
		success: function(json) {
			if (json.status == true) {
				$("#inputMessageUnit").html(json.message);
				setTimeout(function() {
					$("#formDataUnit")[0].reset();
					$("#modalFormUnit").modal("hide");
					$("#inputMessageUnit").html("");
					reloadTableUnit();
				}, 1500);
			} else {
				$("#errorUnit").html(json.error.unit);

				setTimeout(function() {
					$("#errorUnit").html("");
				}, 4000);
			}
		}
	});
});

function btnDeleteUnit(id) {
	idData = id;
	$("#modalDeleteUnit").modal("show");
	$("#modalTitleDelete").text("Hapus Unit");

	$.post("/master/produkkategori/getIdUnit/"+idData,function(json) {
		if (json.status == true) {
			$(".inputData").html( 'Nama Unit : '+json.data.unit );
		} else {
			$(".contentDelete").hide();
			$(".inputData").hide();
			$(".inputMessageDelete").html(json.message);
			setTimeout(function() {
				$("#modalDeleteUnit").modal("hide");
				$(".inputMessageDelete").html("");
				$(".contentDelete").show();
				$(".inputData").show();
				reloadTableUnit();
			},1000);
		}
	});
}

$("#modalBtnDeleteUnit").click(function() {
	$.post("/master/produkkategori/deleteUnit/"+idData,function(json) {
		if (json.status == true) {
			$(".inputData").hide();
			$(".contentDelete").hide();
			$(".inputMessageDelete").html(json.message);
			setTimeout(function() {
				$(".contentDelete").show();
				$(".inputData").show();
				$("#modalDeleteUnit").modal("hide");
				$(".inputMessageDelete").html("");
				reloadTableUnit();
			},1500);
		} else {
			$(".contentDelete").hide();
			$("inputMessageDelete").html(json.message);
			reloadTableUnit();
			setTimeout(function() {
				$(".contentDelete").show();
				$("#modalDeleteUnit").modal("hide");
				$(".inputMessageDelete").html("");
			},1000);
		}
	});
});
