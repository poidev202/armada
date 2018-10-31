$(document).ready(function() {
	$("#tblDijalan").DataTable({
		serverSide:true,
		responsive:true,
		processing:false,
		oLanguage: {
            sZeroRecords: "<center>Data tidak ditemukan</center>",
            sLengthMenu: "Tampilkan _MENU_",
            sSearch: "Cari:",
            sInfo: "Menampilkan: _START_ - _END_ dari total: _TOTAL_ data",                                   
            oPaginate: {
                sFirst: "Awal", "sPrevious": "Sebelumnya",
                sNext: "Selanjutnya", "sLast": "Akhir"
            },
        },
		//load data
		ajax: {
			url: '/performa/perjalananarmada/ajax_list/dijalan',
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
			{ data:'warna_kuning' },
			{
				data:'button_action',
				searchable:false,
				orderable:false,
			},
		],
	});

	$("#tblRusakDijalan").DataTable({
		serverSide:true,
		responsive:true,
		processing:false,
		oLanguage: {
            sZeroRecords: "<center>Data tidak ditemukan</center>",
            sLengthMenu: "Tampilkan _MENU_",
            sSearch: "Cari:",
            sInfo: "Menampilkan: _START_ - _END_ dari total: _TOTAL_ data",                                   
            oPaginate: {
                sFirst: "Awal", "sPrevious": "Sebelumnya",
                sNext: "Selanjutnya", "sLast": "Akhir"
            },
        },
		//load data
		ajax: {
			url: '/performa/perjalananarmada/ajax_list/rusakdijalan',
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
			{ data:'warna_biru' },
		],
	});
});

setInterval(() => {
  	$("#tblDijalan").DataTable().ajax.reload(null,false);
}, 15000);

function reloadTable() {
  	$("#tblDijalan").DataTable().ajax.reload(null,false);
  	$("#tblRusakDijalan").DataTable().ajax.reload(null,false);
}

var idData;
function btnCheck(id) {
	idData = id;

	$.post("/master/armada/getId/"+idData,function (json) {
		if (json.status == true) {
			var pesan =	"<hr>";
				pesan += "<div class='row'>";
				pesan += "<div class='col-md-4'>";
				pesan += "<small>Foto Armada :</small><br>";
				pesan += "<img src='"+json.data.photo+"' alt='Photo Armada' class='img img-responsive' style='width:80px; height:60px;'>";
				pesan += "</div>";
				pesan += "<div class='col-md-8'>";
				pesan += "<li class='pull-left'><small>Nama: <i>"+json.data.nama+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>No Plat / BK : <i>"+json.data.no_bk+"</small></i></li><br>";
				pesan += "</div>";
				pesan += "</div>";

			swal({   
		        title: "Apakah anda yakin.?",   
		        html: pesan+"<hr><small style='color:red;'>Pastikan armada yang anda pilih <u>sedang ada dijalan</u>. <br> data tidak bisa di edit/update lagi.<br>Pastikan anda melihat dengan benar.!</small>",
		        type: "info", 
				showCloseButton: true,
		        showCancelButton: true,   
		        confirmButtonColor: "#1976d2",   
		        confirmButtonText: "Iya, Rusak",
		    }).then((result) => {
		    	if (result.value) {
		    		$.post("/performa/perjalananarmada/getDijalan/"+idData,function(json) {
		    			if (json.status == true) {
								swal({    
							            title: json.message,
							            type: "success",
							            timer: 2000,   
							            showConfirmButton: false 
							        });

								setTimeout(function() {
									reloadTable();
								}, 1500);
							} else {
								swal({   
							            title: "Error Form.!",   
							            html: json.message,
							            type: "error",
							        });
							}
		    		});
		    	}
		    });
		} else {
			swal({    
		            title: json.message,
		            type: "error",
		            timer: 1000,   
		            showConfirmButton: false 
		        });
		}
	});		
}