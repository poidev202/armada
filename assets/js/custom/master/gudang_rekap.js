$(document).ready(function () {
	 btnRefresh = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-success btn-sm' id='btnRefreshRekapGudang'><i class='fa fa-refresh'></i> Refresh</button>";

	$("#tblRekapGudang").DataTable({
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
			url: '/master/gudang/ajax_list_rekap',
			type: 'POST',
		},

		order:[[2,'ASC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'kode' },
			{ data:'nama_produk' },
			{
				data:'sisa_saldo',
				searchable:false,
				orderable:false,
			},
			{ data:'saldo_min' },
			{ data:'keterangan' },
		],
	});
});

$(document).on('click', '#btnRefreshRekapGudang', function(e) {
	e.preventDefault();
	reloadTable();
	$("#btnRefreshRekapGudang").children().addClass("fa-spin");
	setTimeout(function(){
	  $("#btnRefreshRekapGudang").children().removeClass("fa-spin");
	}, 1000);
});

function rekapGudangProduk(id) {
	idData = id;
	$("#modalRekapGudang").modal("show");
	$(".modal-title").text("Rekap data produk per gudang");

	$.post("/master/gudang/getId/"+idData,function(json) {
		if (json.status == true) {
			$('#headerNamaGudang').html(json.data.nama_gudang);
			$("#headerTelpGudang").html(json.data.no_telp);
		    $("#headerAlamatGudang").html(json.data.alamat);
		} else {
			$('#headerNamaGudang').html("");
			$("#headerTelpGudang").html("");
		    $("#headerAlamatGudang").html("");

		    swal({    
		            title: json.message,
		            type: "error",
		            timer: 2000,   
		            showConfirmButton: false 
		        });
			setTimeout(function() {
				$("#modalRekapGudang").modal("hide");
			},1000);
		}
	});

	var tableRekapGudang = $("#tblRekapGudang").DataTable();
	tableRekapGudang.ajax.url("/master/gudang/ajax_list_rekap/"+idData).load();
}