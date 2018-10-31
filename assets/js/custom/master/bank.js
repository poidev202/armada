$(document).ready(function() {
	
		btnTambah = "&nbsp;&nbsp;&nbsp;&nbsp; <button type='button' class='btn btn-outline-primary btn-sm' id='btnTambah'><i class='fa fa-plus'></i> Tambah</button>";

		btnRefresh = "&nbsp;&nbsp;&nbsp;&nbsp; <button type='button' class='btn btn-outline-success btn-sm' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button>";

	$("#tblMasterBank").DataTable({
		serverSide:true,
		responsive:true,
		processing:false,
		oLanguage: {
            sZeroRecords: "<center>Data tidak ditemukan</center>",
            sLengthMenu: "Tampil _MENU_ data   "+btnTambah+btnRefresh,
            sSearch: "Cari data:",
            sInfo: "Menampilkan: _START_ - _END_ dari total: _TOTAL_ data",                                   
            oPaginate: {
                sFirst: "Awal", "sPrevious": "Sebelumnya",
                sNext: "Selanjutnya", "sLast": "Akhir"
            },
        },
		//load data
		ajax: {
			url: '/master/bank/ajax_list',
			type: 'POST',
		},

		order:[[1,'ASC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'nama_bank' },
			{
				data:'button_action',
				searchable:false,
				orderable:false,
			}
		],
	});

});

function reloadTable() {
	$("#tblMasterBank").DataTable().ajax.reload(null,false);
}

var save_method;
var idData;

/*untuk merk*/
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
	// alert("test data tambah");
	$("#modalForm").modal("show");
	$("#formData")[0].reset();
	$(".modal-title").text("Tambah Bank");
	save_method = "add";
});

function editBank(id) {
	$("#modalForm").modal("show");
	$(".modal-title").text("Edit Bank");
	save_method = "update";
	idData = id;
	$.post('/master/bank/getId/'+idData,function(json) {
		if (json.status == true) {
			$("#nama_bank").val(json.data.nama_bank);
		} else {
			$("#nama_bank").val("");
			$("#inputMessage").html(json.message);
			reloadTable();
			setTimeout(function() {
				$("#inputMessage").html("");
				$("#modalForm").modal("hide");
			},1000);
		}
	});
}


$("#modalButtonSave").click(function() {
	var url;
	if (save_method == "add") {
		url = '/master/bank/add';
	} else {
		url = '/master/bank/update/'+idData;
	}

	$.ajax({
		url: url,
		type:'POST',
		data:$("#formData").serialize(),
		dataType:'JSON',
		success: function(json) {
			if (json.status == true) {
				$("#inputMessage").html(json.message);
				setTimeout(function() {
					$("#formData")[0].reset();
					$("#modalForm").modal("hide");
					$("#inputMessage").html("");
					reloadTable();
				}, 1500);
			} else {
				$("#errorNamaBank").html(json.error.nama_bank);

				setTimeout(function() {
					$("#errorNamaBank").html("");
				}, 4000);
			}
		}
	});
});

function btnDelete(id) {
	idData = id;
	$("#modalDelete").modal("show");
	$("#modalTitleDelete").text("Hapus Bank");

	$.post("/master/bank/getId/"+idData,function(json) {
		if (json.status == true) {
			$(".inputData").html( 'Nama Bank : '+json.data.nama_bank );
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
	$.post("/master/bank/delete/"+idData,function(json) {
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
			$("inputMessageDelete").html(json.message);
			reloadTable();
			setTimeout(function() {
				$(".contentDelete").show();
				$("#modalDelete").modal("hide");
				$(".inputMessageDelete").html("");
			},1000);
		}
	});
});
