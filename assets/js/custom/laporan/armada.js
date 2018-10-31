$(document).ready(function() {
	
    btnRefresh = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-success btn-sm' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button>";

	$("#tblArmada").DataTable({
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
			url: '/laporan/armada/ajax_list',
			type: 'POST',
		},

		order:[[2,'ASC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{
				data:'photo',
				searchable:false,
				orderable:false,
			},
			{ data:'nama' },
			{ data:'no_bk' },
			{ data:'tahun' },
			{ data:'merk' },
			{ data:'nama_karoseri' },
			{
				data:'button_action',
				searchable:false,
				orderable:false,
			}
		],
	});

	$("#tblPendapatan").DataTable({
		serverSide:true,
		responsive:true,
		processing:false,
		oLanguage: {
            sZeroRecords: "<center>Data tidak ditemukan</center>",
            sLengthMenu: "Tampilkan _MENU_ data   ",
            sSearch: "Cari data:",
            sInfo: "Menampilkan: _START_ - _END_ dari total: _TOTAL_ data",                                   
            oPaginate: {
                sFirst: "Awal", "sPrevious": "Sebelumnya",
                sNext: "Selanjutnya", "sLast": "Akhir"
            },
        },
		//load data
		ajax: {
			url: '/laporan/armada/ajax_list_rekap',
			type: 'POST',
		},

		order:[[1,'DESC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'tanggal_input' },
			{ data:'hari' },
			{ data:'jam' },
			{ data:'tujuan_awal' },
			{ data:'tujuan_akhir' },
			{ data:'tanggal' },
			{ data:'uang_pendapatan' },
			{ data:'nama_kas' },
		],
	});

	$("#tblPemakaian").DataTable({
		serverSide:true,
		responsive:true,
		processing:false,
		oLanguage: {
            sZeroRecords: "<center>Data tidak ditemukan</center>",
            sLengthMenu: "Tampilkan _MENU_ data   ",
            sSearch: "Cari data:",
            sInfo: "Menampilkan: _START_ - _END_ dari total: _TOTAL_ data",                                   
            oPaginate: {
                sFirst: "Awal", "sPrevious": "Sebelumnya",
                sNext: "Selanjutnya", "sLast": "Akhir"
            },
        },
		//load data
		ajax: {
			url: '/laporan/armada/ajax_list_pemakaian',
			type: 'POST',
		},

		order:[[1,'DESC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'tanggal_jual' },
			{ data:'kode' },
			{ data:'nama_produk' },
			{ data:'nama_gudang' },
			{ data:'unit' },
			{ data:'harga_jual_unit' },
			{ data:'jumlah' },
			{ data:'harga_jual_total' },
		],
	});
});

function reloadTable() {
	$("#tblArmada").DataTable().ajax.reload(null,false);
}

var idData;
$(document).on('click', '#btnRefresh', function(e) {
	e.preventDefault();
	reloadTable();
	$("#btnRefresh").children().addClass("fa-spin");
	setTimeout(function(){
	  $("#btnRefresh").children().removeClass("fa-spin");
	}, 1000);
});

function btnRekapPendapatan(id) {
	idData = id;
	$("#dataTable").hide(800);
	$("#rekapProses").show(800);

	$.post("/master/armada/getById/"+idData,function (json) {
		if (json.status == true) {
			if (json.data.photo != "") {
				srcPhotoArmada = "/uploads/admin/master/armada/"+json.data.photo;
				$("#photoRekapArmada").attr("src",srcPhotoArmada);
				$("#photoPopupRekapArmada").attr("href",srcPhotoArmada);
			} else {
				srcPhotoArmada = "/assets/images/default/no_image.jpg";
				$("#photoRekapArmada").attr("src",srcPhotoArmada);
				$("#photoPopupRekapArmada").attr("href",srcPhotoArmada);
			}
			$("#namaArmadaRekap").html(json.data.nama);
			$("#noBkRekap").html(json.data.no_bk);
			$("#tahunArmadaRekap").html(json.data.tahun);
			$("#merkChassisRekap").html(json.data.merk);
			$("#karoseriRekap").html(json.data.nama_karoseri);

			var tableArmadaRekap = $("#tblPendapatan").DataTable();
			tableArmadaRekap.ajax.url("/laporan/armada/ajax_list_rekap_armada/"+idData).load();
		} else {
			reloadTable();
			srcPhotoArmada = "/assets/images/default/no_image.jpg";
			$("#photoRekapArmada").attr("src",srcPhotoArmada);
			$("#photoPopupRekapArmada").attr("src",srcPhotoArmada);
			$("#namaArmadaRekap").html("");
			$("#noBkRekap").html("");
			$("#tahunArmadaRekap").html("");
			$("#merkChassisRekap").html("");
			$("#karoseriRekap").html("");
		}
	});
}

function btnRekapPemakaian(id) {
	idData = id;
	$("#dataTable").hide(800);
	$("#rekapPemakaian").show(800);

	$.post("/master/armada/getById/"+idData,function (json) {
		if (json.status == true) {
			if (json.data.photo != "") {
				srcPhotoArmada = "/uploads/admin/master/armada/"+json.data.photo;
				$("#photoPemakaianArmada").attr("src",srcPhotoArmada);
				$("#photoPopupPemakaianArmada").attr("href",srcPhotoArmada);
			} else {
				srcPhotoArmada = "/assets/images/default/no_image.jpg";
				$("#photoPemakaianArmada").attr("src",srcPhotoArmada);
				$("#photoPopupPemakaianArmada").attr("href",srcPhotoArmada);
			}
			$("#namaArmadaPemakaian").html(json.data.nama);
			$("#noBkPemakaian").html(json.data.no_bk);
			$("#tahunArmadaPemakaian").html(json.data.tahun);
			$("#merkChassisPemakaian").html(json.data.merk);
			$("#karoseriPemakaian").html(json.data.nama_karoseri);

			var tableArmadaPemakaian = $("#tblPemakaian").DataTable();
			tableArmadaPemakaian.ajax.url("/laporan/armada/ajax_list_pemakaian_armada/"+idData).load();
		} else {
			reloadTable();
			srcPhotoArmada = "/assets/images/default/no_image.jpg";
			$("#photoPemakaianArmada").attr("src",srcPhotoArmada);
			$("#photoPopupPemakaianArmada").attr("src",srcPhotoArmada);
			$("#namaArmadaPemakaian").html("");
			$("#noBkPemakaian").html("");
			$("#tahunArmadaPemakaian").html("");
			$("#merkChassisPemakaian").html("");
			$("#karoseriPemakaian").html("");
		}
	});
}

$(".close-rekap").click(function() {
	$("#rekapProses").hide(800);
	$("#rekapPemakaian").hide(800);
	$("#dataTable").show(800);
});