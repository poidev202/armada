$(document).ready(function () {
	btnRefresh = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-success btn-sm' id='btnRefreshRekapVendorProduk'><i class='fa fa-refresh'></i> Refresh</button>";

	$("#tblRekapVendorProduk").DataTable({
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
			url: '/master/produk/ajax_list_rekap_vendor',
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
			{ data:'nama_gudang' },
			{
				data:'saldo_saat_ini',
				searchable:false,
				orderable:false,
			}
		],
	});
});

$(document).on('click', '#btnRefreshRekapVendorProduk', function(e) {
	e.preventDefault();
	$("#tblRekapVendorProduk").DataTable().ajax.reload(null,false);

	$("#btnRefreshRekapVendorProduk").children().addClass("fa-spin");
	setTimeout(function(){
	  $("#btnRefreshRekapVendorProduk").children().removeClass("fa-spin");
	}, 1000);
});

function rekapVendorProduk(id) {
	idData = id;
	$("#modalRekapVendorProduk").modal("show");
	$(".modal-title").text("Rekap data Vendor produk");

	$.post("/master/vendor/getId/"+idData,function(json) {
		if (json.status == true) {
			$('#headerVendorProduk').html(json.data.nama_vendor);
		} else {
			$('#headerVendorProduk').html("");

		    swal({    
		            title: json.message,
		            type: "error",
		            timer: 2000,   
		            showConfirmButton: false 
		        });
			setTimeout(function() {
				$("#modalRekapVendorProduk").modal("hide");
			},1000);
		}
	});

	var tableRekapProduk = $("#tblRekapVendorProduk").DataTable();
	tableRekapProduk.ajax.url("/master/produk/ajax_list_rekap_vendor/"+idData).load();
}