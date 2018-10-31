$(document).ready(function() {

	$("#tblSupir1").DataTable({
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
			url: '/laporan/supir/ajax_list/1',
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
				data:'foto_karyawan',
				searchable:false,
				orderable:false,
			},
			{ data:'kode_supir1' },
			{ data:'nama_supir1' },
			{ data:'no_telp' },
			{ data:'alamat' },
			{
				data:'button_action',
				searchable:false,
				orderable:false,
			}
		],
	});

	$("#tblSupir2").DataTable({
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
			url: '/laporan/supir/ajax_list/2',
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
				data:'foto_karyawan',
				searchable:false,
				orderable:false,
			},
			{ data:'kode_supir2' },
			{ data:'nama_supir2' },
			{ data:'no_telp' },
			{ data:'alamat' },
			{
				data:'button_action',
				searchable:false,
				orderable:false,
			}
		],
	});

});

function reloadTable() {
	$("#tblSupir1").DataTable().ajax.reload(null,false);
	$("#tblSupir2").DataTable().ajax.reload(null,false);
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

$("#tabClickSupir1").on("click", function(e) {
	e.preventDefault();
	$("#dataTableSupir2").hide();
	$("#rekapProsesSupir2").hide();
	$("#dataTableSupir1").show();
});

$("#tabClickSupir2").on("click", function(e) {
	e.preventDefault();
	$("#dataTableSupir1").hide();
	$("#rekapProsesSupir1").hide();
	$("#dataTableSupir2").show();
});

$(document).ready(function() {
	
	/*supir 1*/
	dataTableSupir("tblPendapatanSupir1","/laporan/supir/ajax_list_rekap");

	/*supir 2*/
	dataTableSupir("tblPendapatanSupir2","/laporan/supir/ajax_list_rekap");

});

function dataTableSupir(idTable,urlTable) {
	$("#"+idTable).DataTable({
		serverSide:true,
		responsive:true,
		processing:true,
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
			url: urlTable,
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
			{ data:'nama' },
			{ data:'no_bk' },
			{ data:'hari' },
			{ data:'jam' },
			{ data:'tujuan_awal' },
			{ data:'tujuan_akhir' },
			{ data:'uang_pendapatan' },
		],
	});
}

var kode;
function btnRekap1(kode_supir1) {
	kode = kode_supir1;

	$("#dataTableSupir1").hide(800);
	$("#rekapProsesSupir1").show(800);

	$.post("/master/karyawan/getByWhereSupir/"+kode,function(json) {
		if (json.status == true) {
			$("#photoRekapSupir1").attr("src",json.data.foto_karyawan);
			$("#photoPopupRekapSupir1").attr("href",json.data.foto_karyawan);
			$("#kodeRekapSupir1").html(json.data.kode);
			$("#namaRekapSupir1").html(json.data.nama);
			$("#tempatLahirRekapSupir1").html(json.data.tempat_lahir);
			$("#tanggalLahirRekapSupir1").html(json.data.tanggal_lahir_indo);
			$("#jabatanRekapSupir1").html(json.data.nama_jabatan);
			$("#noTelpRekapSupir1").html(json.data.no_telp);
			$("#alamatRekapSupir1").html(json.data.alamat);

			var tableSupir1 = $("#tblPendapatanSupir1").DataTable();
			tableSupir1.ajax.url("/laporan/supir/ajax_list_rekap_supir1/"+kode).load();

		} else {
			reloadTable();
			$("#photoRekapSupir1").attr("src","/assets/images/default/user_image.png");
			$("#photoPopupRekapSupir1").attr("href","/assets/images/default/user_image.png");
			$("#kodeRekapSupir1").html("");
			$("#namaRekapSupir1").html("");
			$("#tempatLahirRekapSupir1").html("");
			$("#tanggalLahirRekapSupir1").html("");
			$("#jabatanRekapSupir1").html("");
			$("#noTelpRekapSupir1").html("");
			$("#alamatRekapSupir1").html("");
		}
	});
}

$(".close-rekap-supir1").click(function() {
	$("#dataTableSupir1").show(800);
	$("#rekapProsesSupir1").hide(800);
});

function btnRekap2(kode_supir2) {
	kode = kode_supir2;

	$("#dataTableSupir2").hide(800);
	$("#rekapProsesSupir2").show(800);

	$.post("/master/karyawan/getByWhereSupir/"+kode,function(json) {
		if (json.status == true) {
			$("#photoRekapSupir2").attr("src",json.data.foto_karyawan);
			$("#photoPopupRekapSupir2").attr("href",json.data.foto_karyawan);
			$("#kodeRekapSupir2").html(json.data.kode);
			$("#namaRekapSupir2").html(json.data.nama);
			$("#tempatLahirRekapSupir2").html(json.data.tempat_lahir);
			$("#tanggalLahirRekapSupir2").html(json.data.tanggal_lahir_indo);
			$("#jabatanRekapSupir2").html(json.data.nama_jabatan);
			$("#noTelpRekapSupir2").html(json.data.no_telp);
			$("#alamatRekapSupir2").html(json.data.alamat);

			var tableSupir2 = $("#tblPendapatanSupir2").DataTable();
			tableSupir2.ajax.url("/laporan/supir/ajax_list_rekap_supir2/"+kode).load();

		} else {
			reloadTable();
			$("#photoRekapSupir2").attr("src","/assets/images/default/user_image.png");
			$("#photoPopupRekapSupir2").attr("href","/assets/images/default/user_image.png");
			$("#kodeRekapSupir2").html("");
			$("#namaRekapSupir2").html("");
			$("#tempatLahirRekapSupir2").html("");
			$("#tanggalLahirRekapSupir2").html("");
			$("#jabatanRekapSupir2").html("");
			$("#noTelpRekapSupir2").html("");
			$("#alamatRekapSupir2").html("");
		}
	});
}

$(".close-rekap-supir2").click(function() {
	$("#dataTableSupir2").show(800);
	$("#rekapProsesSupir2").hide(800);
});