$(document).ready(function() {
	var tblAll = $("#tblLaporanKasAll").DataTable({	// for semua transaksi
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
			url: '/laporan/accountkas/ajax_list',
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
			{ data:'nama_kas' },
			{ data:'masuk' },
			{ data:'keluar' },
			{ data:'status' },
			{ data:'info_input' },
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
	/*End Table kas All*/

	/*Start Table kas Masuk*/
	var tblMasuk = $("#tblLaporanKasMasuk").DataTable({	// for semua transaksi
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
			url: '/laporan/accountkas/ajax_list_masuk',
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
			{ data:'nama_kas' },
			{ data:'masuk' },
			{ data:'nama' },
			{ data:'no_bk' },
			{ data:'tanggal_jadwal' },
			{ data:'hari' },
			{ data:'jam' },
			{ data:'tujuan_awal' },
			{ data:'tujuan_akhir' },
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
	/*End Table kas Masuk*/

	/*Start Table kas Keluar pembelian*/
	var tblKeluarPembelian = $("#tblLaporanKasKeluarPembelian").DataTable({	// for semua transaksi
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
			url: '/laporan/accountkas/ajax_list_keluar_pembelian',
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
			{ data:'nama_kas' },
			{ data:'keluar' },
			{ data:'kode' },
			{ data:'nama_produk' },
			{ data:'kategori' },
			{ data:'harga_beli_unit' },
			{ data:'jumlah' },
			{ data:'nama_gudang' },
			{ data:'nama_vendor' },
			{ data:'keterangan' },
		],
	});
	$('#tgl_awal_keluar_pembelian, #tgl_akhir_keluar_pembelian').on( 'change', function () {   // for text boxes

		var awal = $("#tgl_awal_keluar_pembelian").attr('data-column');  // getting column index
		var akhir = $("#tgl_akhir_keluar_pembelian").attr('data-column');  // getting column index
		var valAwal = $("#tgl_awal_keluar_pembelian").val();  // getting search input value
		var valAkhir = $("#tgl_akhir_keluar_pembelian").val();  // getting search input value

		if (valAwal != "" && valAkhir != "") {
			if (valAkhir < valAwal) {
				alert("tanggal awal tidak boleh lebih besar dari tanggal akhir");
			} else {
				tblKeluarPembelian.columns(awal).search(valAwal).draw();
				tblKeluarPembelian.columns(akhir).search(valAkhir).draw();
			}
		} else {
			tblKeluarPembelian.columns(awal).search("").draw();
			tblKeluarPembelian.columns(akhir).search("").draw();
		}
	});

	$('#gudang_cari_keluar_pembelian').on( 'change', function () {   // for select box
		var i =$(this).attr('data-column');  
		var v =$(this).val();  
		tblKeluarPembelian.columns(i).search(v).draw();
	});
	$('#kategori_cari_keluar_pembelian').on( 'change', function () {   // for select box
		var i =$(this).attr('data-column');  
		var v =$(this).val();  
		tblKeluarPembelian.columns(i).search(v).draw();
	});
	/*End Table kas Keluar Pembelian*/

	/*Start Table kas Keluar pembelian*/
	var tblKeluarPenjualan = $("#tblLaporanKasKeluarPenjualan").DataTable({	// for semua transaksi
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
			url: '/laporan/accountkas/ajax_list_keluar_penjualan',
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
			{ data:'nama_kas' },
			{ data:'keluar' },
			{ data:'nama' },
			{ data:'no_bk' },
			{ data:'kode' },
			{ data:'nama_produk' },
			{ data:'kategori' },
			{ data:'harga_jual_unit' },
			{ data:'jumlah' },
			{ data:'nama_gudang' },
			{ data:'keterangan' },
		],
	});
	$('#tgl_awal_keluar_penjualan, #tgl_akhir_keluar_penjualan').on( 'change', function () {   // for text boxes

		var awal = $("#tgl_awal_keluar_penjualan").attr('data-column');  // getting column index
		var akhir = $("#tgl_akhir_keluar_penjualan").attr('data-column');  // getting column index
		var valAwal = $("#tgl_awal_keluar_penjualan").val();  // getting search input value
		var valAkhir = $("#tgl_akhir_keluar_penjualan").val();  // getting search input value

		if (valAwal != "" && valAkhir != "") {
			if (valAkhir < valAwal) {
				alert("tanggal awal tidak boleh lebih besar dari tanggal akhir");
			} else {
				tblKeluarPenjualan.columns(awal).search(valAwal).draw();
				tblKeluarPenjualan.columns(akhir).search(valAkhir).draw();
			}
		} else {
			tblKeluarPenjualan.columns(awal).search("").draw();
			tblKeluarPenjualan.columns(akhir).search("").draw();
		}
	});

	$('#gudang_cari_keluar_penjualan').on( 'change', function () {   // for select box
		var i =$(this).attr('data-column');  
		var v =$(this).val();  
		tblKeluarPenjualan.columns(i).search(v).draw();
	});
	$('#kategori_cari_keluar_penjualan').on( 'change', function () {   // for select box
		var i =$(this).attr('data-column');  
		var v =$(this).val();  
		tblKeluarPenjualan.columns(i).search(v).draw();
	});
	/*End Table kas Keluar Pembelian*/
});

function reloadTable() {
	$("#tblLaporanKasAll").DataTable().ajax.reload(null,false);
	$("#tblLaporanKasMasuk").DataTable().ajax.reload(null,false);
	$("#tblLaporanKasKeluarPembelian").DataTable().ajax.reload(null,false);
	$("#tblLaporanKasKeluarPenjualan").DataTable().ajax.reload(null,false);
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

	$("#gudang_cari_keluar_pembelian").html(option);
	$("#gudang_cari_keluar_penjualan").html(option);
});

/* kategori */
$.post("/master/produkkategori/getAllKategori",function(json) {
	var option;
	option = '<option value="">--Pilih Kategori--</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.kategori+'</option>';
	});

	$("#kategori_cari_keluar_pembelian").html(option);
	$("#kategori_cari_keluar_penjualan").html(option);
});