$(document).ready(function () {
	btnRefresh = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-success btn-sm' id='btnRefreshRekapProduk'><i class='fa fa-refresh'></i> Refresh</button>";

	$("#tblRekapProduk").DataTable({
		serverSide:true,
		responsive:true,
		processing:false,
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
			url: '/master/produk/ajax_list_rekap',
			type: 'POST',
		},

		order:[[1,'DESC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'tanggal' },
			{ data:'masuk' },
			{ data:'keluar' },
			// { data:'harga_unit' },
			{ data:'nama_gudang' },
			{
				data:'saldo_saat_ini',
				searchable:false,
				orderable:false,
			},
			{ data:'status' },
		],
	});
});

$(document).on('click', '#btnRefreshRekapProduk', function(e) {
	e.preventDefault();
	$("#tblRekapProduk").DataTable().ajax.reload(null,false);

	$("#btnRefreshRekapProduk").children().addClass("fa-spin");
	setTimeout(function(){
	  $("#btnRefreshRekapProduk").children().removeClass("fa-spin");
	}, 1000);
});

function rekapProduk(id) {
	idData = id;
	$("#modalRekapProduk").modal("show");
	$(".modal-title").text("Rekap data produk");

	$.post("/master/produk/getId/"+idData,function(json) {
		if (json.status == true) {
			$('#headerNamaProduk').html(json.data.nama_produk);
			$("#headerKodeProduk").html(json.data.kode);
		} else {
			$('#headerNamaProduk').html("");
			$("#headerKodeProduk").html("");

		    swal({    
		            title: json.message,
		            type: "error",
		            timer: 2000,   
		            showConfirmButton: false 
		        });
			setTimeout(function() {
				$("#modalRekapProduk").modal("hide");
			},1000);
		}
	});

	var tableRekapProduk = $("#tblRekapProduk").DataTable();
	tableRekapProduk.ajax.url("/master/produk/ajax_list_rekap/"+idData).load();
}