$(document).ready(function() {
	
	var tblAll = $("#tblLaporanGudang").DataTable({	// for semua transaksi
		serverSide:true,
		responsive:true,
		processing:false,
		oLanguage: {
            sZeroRecords: "<center>Data tidak ditemukan</center>",
            sLengthMenu: "Tampilkan _MENU_ data",
            sSearch: "Cari data:",
            sInfo: "Menampilkan: _START_ - _END_ dari total: _TOTAL_ data",                                   
            oPaginate: {
                sFirst: "Awal", "sPrevious": "Sebelumnya",
                sNext: "Selanjutnya", "sLast": "Akhir"
            },
        },
		//load data
		ajax: {
			url: '/laporan/gudang/ajax_list',
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
			{ data:'nama_gudang' },
			{ data:'kode' },
			{ data:'nama_produk' },
			{ data:'kategori' },
			{ data:'unit' },
			{ data:'harga_unit' },
			{ data:'masuk' },
			{ data:'keluar' },
			{ data:'status' },
			{ data:'keterangan' },
		],
	});

	$('#tgl_awal_all, #tgl_akhir_all').on( 'change', function () {   // for text boxes

		var awal = $("#tgl_awal_all").attr('data-column');  // getting column index
		var akhir = $("#tgl_akhir_all").attr('data-column');  // getting column index
		var valAwal = $("#tgl_awal_all").val();  // getting search input value
		var valAkhir = $("#tgl_akhir_all").val();  // getting search input value

		if (valAwal != "" && valAkhir != "") {
			if (valAkhir < valAwal) {
				alert("tanggal awal tidak boleh lebih besar dari tanggal akhir");
			} else {
				tblAll.columns(awal).search(valAwal).draw();
				tblAll.columns(akhir).search(valAkhir).draw();
			}
		} else {
			tblAll.columns(awal).search("").draw();
			tblAll.columns(akhir).search("").draw();
		}
	});

	$('#gudang_cari_all').on( 'change', function () {   // for select box
		var i =$(this).attr('data-column');  
		var v =$(this).val();  
		tblAll.columns(i).search(v).draw();
	});
	$('#kategori_cari_all').on( 'change', function () {   // for select box
		var i =$(this).attr('data-column');  
		var v =$(this).val();  
		tblAll.columns(i).search(v).draw();
	});

	var tblMasuk = $("#tblLaporanGudangMasuk").DataTable({	// for transaksi masuk aja
		serverSide:true,
		responsive:true,
		processing:false,
		oLanguage: {
            sZeroRecords: "<center>Data tidak ditemukan</center>",
            sLengthMenu: "Tampilkan _MENU_ data",
            sSearch: "Cari data:",
            sInfo: "Menampilkan: _START_ - _END_ dari total: _TOTAL_ data",                                   
            oPaginate: {
                sFirst: "Awal", "sPrevious": "Sebelumnya",
                sNext: "Selanjutnya", "sLast": "Akhir"
            },
        },
		//load data
		ajax: {
			url: '/laporan/gudang/ajax_list/masuk',
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
			{ data:'nama_gudang' },
			{ data:'nama_vendor' },
			{ data:'kode' },
			{ data:'nama_produk' },
			{ data:'kategori' },
			{ data:'unit' },
			{ data:'harga_unit' },
			{ data:'masuk' },
			{ data:'beli' },
			{ data:'keterangan' },
		],
	});

	$('#tgl_awal_masuk, #tgl_akhir_masuk').on( 'change', function () {   // for text boxes

		var awal = $("#tgl_awal_masuk").attr('data-column');  // getting column index
		var akhir = $("#tgl_akhir_masuk").attr('data-column');  // getting column index
		var valAwal = $("#tgl_awal_masuk").val();  // getting search input value
		var valAkhir = $("#tgl_akhir_masuk").val();  // getting search input value

		if (valAwal != "" && valAkhir != "") {
			if (valAkhir < valAwal) {
				alert("tanggal awal tidak boleh lebih besar dari tanggal akhir");
			} else {
				tblMasuk.columns(awal).search(valAwal).draw();
				tblMasuk.columns(akhir).search(valAkhir).draw();
			}
		} else {
			tblMasuk.columns(awal).search("").draw();
			tblMasuk.columns(akhir).search("").draw();
		}
	});

	$('#gudang_cari_masuk').on( 'change', function () {   // for select box
		var i =$(this).attr('data-column');  
		var v =$(this).val();  
		tblMasuk.columns(i).search(v).draw();
	});
	$('#kategori_cari_masuk').on( 'change', function () {   // for select box
		var i =$(this).attr('data-column');  
		var v =$(this).val();  
		tblMasuk.columns(i).search(v).draw();
	});

	var tblKeluar = $("#tblLaporanGudangKeluar").DataTable({	// for transaksi keluar aja
		serverSide:true,
		responsive:true,
		processing:false,
		oLanguage: {
            sZeroRecords: "<center>Data tidak ditemukan</center>",
            sLengthMenu: "Tampilkan _MENU_ data",
            sSearch: "Cari data:",
            sInfo: "Menampilkan: _START_ - _END_ dari total: _TOTAL_ data",                                   
            oPaginate: {
                sFirst: "Awal", "sPrevious": "Sebelumnya",
                sNext: "Selanjutnya", "sLast": "Akhir"
            },
        },
		//load data
		ajax: {
			url: '/laporan/gudang/ajax_list/keluar',
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
			{ data:'nama_gudang' },
			{ data:'nama' },
			{ data:'kode' },
			{ data:'nama_produk' },
			{ data:'kategori' },
			{ data:'unit' },
			{ data:'harga_unit' },
			{ data:'keluar' },
			{ data:'jual' },
			{ data:'keterangan' },
		],
	});

	$('#tgl_awal_keluar, #tgl_akhir_keluar').on( 'change', function () {   // for text boxes

		var awal = $("#tgl_awal_keluar").attr('data-column');  // getting column index
		var akhir = $("#tgl_akhir_keluar").attr('data-column');  // getting column index
		var valAwal = $("#tgl_awal_keluar").val();  // getting search input value
		var valAkhir = $("#tgl_akhir_keluar").val();  // getting search input value

		if (valAwal != "" && valAkhir != "") {
			if (valAkhir < valAwal) {
				alert("tanggal awal tidak boleh lebih besar dari tanggal akhir");
			} else {
				tblKeluar.columns(awal).search(valAwal).draw();
				tblKeluar.columns(akhir).search(valAkhir).draw();
			}
		} else {
			tblKeluar.columns(awal).search("").draw();
			tblKeluar.columns(akhir).search("").draw();
		}
	});

	$('#gudang_cari_keluar').on( 'change', function () {   // for select box
		var i =$(this).attr('data-column');  
		var v =$(this).val();  
		tblKeluar.columns(i).search(v).draw();
	});
	$('#kategori_cari_keluar').on( 'change', function () {   // for select box
		var i =$(this).attr('data-column');  
		var v =$(this).val();  
		tblKeluar.columns(i).search(v).draw();
	});

});

function reloadTable() {
	$("#tblLaporanGudang").DataTable().ajax.reload(null,false);
	$("#tblLaporanGudangMasuk").DataTable().ajax.reload(null,false);
	$("#tblLaporanGudangKeluar").DataTable().ajax.reload(null,false);
}

var idData;

$(document).on('click', '#btnRefresh', function(e) {
	e.preventDefault();
	reloadTable();
	$("#btnRefresh").children().addClass("fa-spin");
	setTimeout(function(){
	  $("#btnRefresh").children().removeClass("fa-spin");
	}, 800);
});

/*Filter searching*/
/* master gudang */
$.post("/master/gudang/getAll",function(json) {
	var option;
	option = '<option value="">-- Pilih Gudang --</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.nama_gudang+'</option>';
	});

	$("#gudang_cari_all").html(option);
	$("#gudang_cari_masuk").html(option);
	$("#gudang_cari_keluar").html(option);
});

/* kategori */
$.post("/master/produkkategori/getAllKategori",function(json) {
	var option;
	option = '<option value="">--Pilih Kategori--</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.kategori+'</option>';
	});

	$("#kategori_cari_all").html(option);
	$("#kategori_cari_masuk").html(option);
	$("#kategori_cari_keluar").html(option);
});