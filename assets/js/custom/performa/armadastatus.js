
$(document).ready(function() {
	$("#tblArmadaStatus").DataTable({
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
			url: '/performa/armadastatus/ajax_list',
			type: 'POST',
		},

		order:[[2,'DESC']],
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
			{ data:'warna_merah' },
			{ data:'warna_kuning' },
			{ data:'warna_hijau' },
			{ data:'warna_ungu' },
			{ data:'warna_biru' },
		],
	});

});

function reloadTable() {
	$("#tblArmadaStatus").DataTable().ajax.reload(null,false);
}

setInterval(() => {
  reloadTable();
}, 10000);