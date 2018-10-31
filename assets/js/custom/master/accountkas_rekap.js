$(document).ready(function () {
	 btnRefresh = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-warning btn-sm' id='btnRefreshRekapAccountKas'><i class='fa fa-refresh'></i> Refresh</button>";

	$("#tblRekapAccountKas").DataTable({
		serverSide:true,
		responsive:true,
		processing:true,
		oLanguage: {
            sZeroRecords: "<center>Data tidak ditemukan</center>",
            sLengthMenu: "Tampilkan _MENU_ data   "+btnRefresh,
            sSearch: "Cari data:",
            sInfo: "Menampilkan: _START_ - _END_ dari total: _TOTAL_ data",                                   
            oPaginate: {
                sFirst: "Awal", "sPrevious": "Sebelumnya",
                sNext: "Selanjutnya", "sLast": "Akhir"
            },
        },
		//load data
		ajax: {
			url: '/master/accountkas/ajax_list_rekap',
			type: 'POST',
		},

		order:[[1,'ASC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'tanggal' },
			{ data:'masuk' },
			{ data:'keluar' },
			{ data:'status' },
			{ data:'info_input' },
			{ data:'keterangan' },
		],
	});
});

$(document).on('click', '#btnRefreshRekapAccountKas', function(e) {
	e.preventDefault();
	reloadTable();
	$("#btnRefreshRekapAccountKas").children().addClass("fa-spin");
	setTimeout(function(){
	  $("#btnRefreshRekapAccountKas").children().removeClass("fa-spin");
	}, 1000);
});

function rekapAccountKas(id) {
	idData = id;
	$("#modalRekapAccountKas").modal("show");
	$(".modal-title").text("Rekap Data Account Kas");

	$.post("/master/accountkas/getId/"+idData,function(json) {
		if (json.status == true) {
			$('#headerNamaAccountKas').html(json.data.nama_kas);
			$("#headerTelpAccountKas").html(json.data.no_telp);
		    $("#headerAlamatAccountKas").html(json.data.alamat);
		    $("#headerSaldoAccountKas").html(json.data.saldo_rp);
		    if (json.data.saldo > 0) {
		    	$("#headerSaldoAccountKas").removeClass("text-danger");
		    	$("#headerSaldoAccountKas").addClass("text-success");
		    } else {
		    	$("#headerSaldoAccountKas").removeClass("text-success");
		    	$("#headerSaldoAccountKas").addClass("text-danger");
		    }
		} else {
			$('#headerNamaAccountKas').html("");
			$("#headerTelpAccountKas").html("");
		    $("#headerAlamatAccountKas").html("");
		    $("#headerSaldoAccountKas").html("");
		    swal({    
		            title: json.message,
		            type: "error",
		            timer: 2000,   
		            showConfirmButton: false 
		        });
			setTimeout(function() {
				$("#modalRekapAccountKas").modal("hide");
			},1000);
		}
	});

	var tableRekapGudang = $("#tblRekapAccountKas").DataTable();
	tableRekapGudang.ajax.url("/master/accountkas/ajax_list_rekap/"+idData).load();
}