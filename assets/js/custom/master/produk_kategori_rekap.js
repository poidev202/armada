$(document).ready(function () {
	btnRefresh = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-success btn-sm' id='btnRefreshRekapKategoriProduk'><i class='fa fa-refresh'></i> Refresh</button>";

	$("#tblRekapKategoriProduk").DataTable({
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
			url: '/master/produk/ajax_list_rekap_kategori',
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

$(document).on('click', '#btnRefreshRekapKategoriProduk', function(e) {
	e.preventDefault();
	$("#tblRekapKategoriProduk").DataTable().ajax.reload(null,false);

	$("#btnRefreshRekapKategoriProduk").children().addClass("fa-spin");
	setTimeout(function(){
	  $("#btnRefreshRekapKategoriProduk").children().removeClass("fa-spin");
	}, 1000);
});

function rekapKategoriProduk(id) {
	idData = id;
	$("#modalRekapKategoriProduk").modal("show");
	$(".modal-title").text("Rekap data Kategori produk");

	$.post("/master/produkkategori/getIdKategori/"+idData,function(json) {
		if (json.status == true) {
			$('#headerKategoriProduk').html(json.data.kategori);
		} else {
			$('#headerKategoriProduk').html("");

		    swal({    
		            title: json.message,
		            type: "error",
		            timer: 2000,   
		            showConfirmButton: false 
		        });
			setTimeout(function() {
				$("#modalRekapKategoriProduk").modal("hide");
			},1000);
		}
	});

	var tableRekapProduk = $("#tblRekapKategoriProduk").DataTable();
	tableRekapProduk.ajax.url("/master/produk/ajax_list_rekap_kategori/"+idData).load();
}