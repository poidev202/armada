$(document).ready(function() {
	/*for STNK*/
	$("#tblExpireSTNKArmada").DataTable({
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
			url: '/dashboard/ajax_list_expired_stnk/null',
			type: 'POST',
		},

		order:[[1,'ASC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'tgl_stnk' },
			{
				data:'photo',
				searchable:false,
				orderable:false,
			},
			{ data:'nama' },
			{ data:'no_bk' },
		],
	});

	/*for SIM Supir*/
	$("#tblExpireSIM").DataTable({
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
			url: '/dashboard/ajax_list_expired_sim/null',
			type: 'POST',
		},

		order:[[1,'ASC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'tgl_jatuh_tempo_sim' },
			{
				data:'foto_karyawan',
				searchable:false,
				orderable:false,
			},
			{ data:'kode' },
			{ data:'nama' },
		],
	});

	/*for Kontrak Karyawan*/
	$("#tblExpireKontrak").DataTable({
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
			url: '/dashboard/ajax_list_expired_kontrak/null',
			type: 'POST',
		},

		order:[[1,'ASC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'tgl_akhir_kontrak' },
			{
				data:'foto_karyawan',
				searchable:false,
				orderable:false,
			},
			{ data:'kode' },
			{ data:'nama' },
		],
	});


});

/*for STNK*/
$.post("/dashboard/countExpireSTNK",function(json) {
	$("#value_stnk_1bulan").text(json.sisa_1bulan);
	$("#value_stnk_2bulan").text(json.sisa_2bulan);
	$("#value_stnk_3bulan").text(json.sisa_3bulan);
	$("#value_stnk_expire").text(json.expire_stnk);
});

function reloadCountExpireSTNK() {
	$.post("/dashboard/countExpireSTNK",function(json) {
		$("#value_stnk_1bulan").text(json.sisa_1bulan);
		$("#value_stnk_2bulan").text(json.sisa_2bulan);
		$("#value_stnk_3bulan").text(json.sisa_3bulan);
		$("#value_stnk_expire").text(json.expire_stnk);
	});
}

$("#stnk_1bulan").click(function() {
	$("#stnkExpireModal").modal("show");
	$(".modal-title").text("STNK Sisa 1 Bulan");
	var tableExpire = $("#tblExpireSTNKArmada").DataTable();
	tableExpire.ajax.url("/dashboard/ajax_list_expired_stnk/1").load();
	reloadCountExpireSTNK();
});

$("#stnk_2bulan").click(function() {
	$("#stnkExpireModal").modal("show");
	$(".modal-title").text("STNK Sisa 2 Bulan");
	var tableExpire = $("#tblExpireSTNKArmada").DataTable();
	tableExpire.ajax.url("/dashboard/ajax_list_expired_stnk/2").load();
	reloadCountExpireSTNK();
});

$("#stnk_3bulan").click(function() {
	$("#stnkExpireModal").modal("show");
	$(".modal-title").text("STNK Sisa 3 Bulan");
	var tableExpire = $("#tblExpireSTNKArmada").DataTable();
	tableExpire.ajax.url("/dashboard/ajax_list_expired_stnk/3").load();
	reloadCountExpireSTNK();
});

$("#stnk_expire").click(function() {
	$("#stnkExpireModal").modal("show");
	$(".modal-title").text("STNK Lewat Jatuh Tempo Bayar Pajak");
	var tableExpire = $("#tblExpireSTNKArmada").DataTable();
	tableExpire.ajax.url("/dashboard/ajax_list_expired_stnk/due").load();
	reloadCountExpireSTNK();
});
/*end for STNK*/

/*for SIM*/
$.post("/dashboard/countExpireSIM",function(json) {
	$("#value_sim_1bulan").text(json.sisa_1bulan);
	$("#value_sim_2bulan").text(json.sisa_2bulan);
	$("#value_sim_3bulan").text(json.sisa_3bulan);
	$("#value_sim_expire").text(json.expire_sim);
});

function reloadCountExpireSIM() {
	$.post("/dashboard/countExpireSIM",function(json) {
		$("#value_sim_1bulan").text(json.sisa_1bulan);
		$("#value_sim_2bulan").text(json.sisa_2bulan);
		$("#value_sim_3bulan").text(json.sisa_3bulan);
		$("#value_sim_expire").text(json.expire_sim);
	});
}

$("#sim_1bulan").click(function() {
	$("#simExpireModal").modal("show");
	$(".modal-title").text("SIM Sisa 1 Bulan");
	var tableExpire = $("#tblExpireSIM").DataTable();
	tableExpire.ajax.url("/dashboard/ajax_list_expired_sim/1").load();
	reloadCountExpireSIM();
});

$("#sim_2bulan").click(function() {
	$("#simExpireModal").modal("show");
	$(".modal-title").text("SIM Sisa 2 Bulan");
	var tableExpire = $("#tblExpireSIM").DataTable();
	tableExpire.ajax.url("/dashboard/ajax_list_expired_sim/2").load();
	reloadCountExpireSIM();
});

$("#sim_3bulan").click(function() {
	$("#simExpireModal").modal("show");
	$(".modal-title").text("SIM Sisa 3 Bulan");
	var tableExpire = $("#tblExpireSIM").DataTable();
	tableExpire.ajax.url("/dashboard/ajax_list_expired_sim/3").load();
	reloadCountExpireSIM();
});

$("#sim_expire").click(function() {
	$("#simExpireModal").modal("show");
	$(".modal-title").text("SIM Lewat Jatuh Tempo");
	var tableExpire = $("#tblExpireSIM").DataTable();
	tableExpire.ajax.url("/dashboard/ajax_list_expired_sim/due").load();
	reloadCountExpireSIM();
});
/*end for SIM*/

/*for Kontrak*/
$.post("/dashboard/countExpireKontrak",function(json) {
	$("#value_kontrak_1bulan").text(json.sisa_1bulan);
	$("#value_kontrak_2bulan").text(json.sisa_2bulan);
	$("#value_kontrak_3bulan").text(json.sisa_3bulan);
	$("#value_kontrak_expire").text(json.expire_kontrak);
});

function reloadCountExpireKontrak() {
	$.post("/dashboard/countExpireKontrak",function(json) {
		$("#value_kontrak_1bulan").text(json.sisa_1bulan);
		$("#value_kontrak_2bulan").text(json.sisa_2bulan);
		$("#value_kontrak_3bulan").text(json.sisa_3bulan);
		$("#value_kontrak_expire").text(json.expire_kontrak);
	});
}

$("#kontrak_1bulan").click(function() {
	$("#kontrakExpireModal").modal("show");
	$(".modal-title").text("Kontrak Karyawan Sisa 1 Bulan");
	var tableExpire = $("#tblExpireKontrak").DataTable();
	tableExpire.ajax.url("/dashboard/ajax_list_expired_kontrak/1").load();
	reloadCountExpireSIM();
});

$("#kontrak_2bulan").click(function() {
	$("#kontrakExpireModal").modal("show");
	$(".modal-title").text("Kontrak Karyawan Sisa 2 Bulan");
	var tableExpire = $("#tblExpireKontrak").DataTable();
	tableExpire.ajax.url("/dashboard/ajax_list_expired_kontrak/2").load();
	reloadCountExpireSIM();
});

$("#kontrak_3bulan").click(function() {
	$("#kontrakExpireModal").modal("show");
	$(".modal-title").text("Kontrak Karyawan Sisa 3 Bulan");
	var tableExpire = $("#tblExpireKontrak").DataTable();
	tableExpire.ajax.url("/dashboard/ajax_list_expired_kontrak/3").load();
	reloadCountExpireSIM();
});

$("#kontrak_expire").click(function() {
	$("#kontrakExpireModal").modal("show");
	$(".modal-title").text("Kontrak Karyawan Lewat Jatuh Tempo");
	var tableExpire = $("#tblExpireKontrak").DataTable();
	tableExpire.ajax.url("/dashboard/ajax_list_expired_kontrak/due").load();
	reloadCountExpireSIM();
});
/*end for Kontrak*/

/*ulang Tahun*/
$.post("/dashboard/ajax_list_ulang_tahun",function(json) {
	if (json.status == true) {
		$("#showAllUltah").show();
		var progressSuccess = '<div class="progress"><div class="progress-bar bg-success" role="progressbar" style="width: 100%; height: 1px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div></div>';
		var progressInfo = '<div class="progress"><div class="progress-bar bg-info" role="progressbar" style="width: 100%; height: 1px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div></div>';
		var progressInverse = '<div class="progress"><div class="progress-bar bg-inverse" role="progressbar" style="width: 100%; height: 1px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div></div>';

		var ultahHTML = "";

		$.each(json.data,function(i,v) {
			ultahHTML += '<div class="card card-default">';
			ultahHTML += progressSuccess;
			ultahHTML += '	<div class="card-header">';
			ultahHTML += '		<div class="card-actions"><a class="" data-action="collapse"><i class="ti-plus"></i></a></div>';
			ultahHTML += '		<img class=" img-user-login" src="'+v.foto_karyawan+'" style="height: 30px; width: 30px;" alt="user">';
			ultahHTML += '		<b class="card-title m-b-0" >Umur <b>'+v.umur+'</b> Tahun</b>';
			ultahHTML += '	</div>';
			ultahHTML += progressSuccess;
			ultahHTML += '	<div class="card-body collapse">';
			ultahHTML += '		<div class="el-element-overlay">';
			ultahHTML += '			<div class="el-card-item">';
			ultahHTML += '				<div class="el-card-avatar el-overlay-1">';
			ultahHTML += '					<img src="'+v.foto_karyawan+'" style="height: 120px;" class="img img-responsive" alt="Karyawan Photo">';
			ultahHTML += '					<div class="el-overlay scrl-dwn"><ul class="el-info"><li><a class="btn default btn-sm btn-outline image-popup-vertical-fit" href="'+v.foto_karyawan+'"><i class="icon-magnifier"></i></a></li></ul></div>';
			ultahHTML += '				</div>';
			ultahHTML += '				<div class="el-card-content"><h5 class="box-title">'+v.nama+'</h5><small>'+v.nama_jabatan+'</small></div>';
			ultahHTML += '			</div>';
			ultahHTML += progressInfo;
			ultahHTML += '		</div>';
			ultahHTML += '		<small class=" m-t-0">Ulang Tahun Ke : '+v.umur+' Tahun</small>'+progressInverse;
			ultahHTML += '		<small>Tanggal Lahir : '+v.tanggal_lahir_indo+'</small>'+progressInverse;
			ultahHTML += '		<small>Tempat Lahir : '+v.tempat_lahir+'</small>'+progressInverse;
			ultahHTML += '		<small>Jenis Kelamin: '+v.kelamin+'</small>'+progressInverse;
			ultahHTML += '	</div>';
			ultahHTML += '</div>';

			$("#showAllUltah").html(ultahHTML);
		});
		
	}
});