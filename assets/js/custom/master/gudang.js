$(document).ready(function() {
	
	btnTambah = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-primary btn-sm' id='btnTambah'><i class='fa fa-plus'></i> Tambah</button>";
   	
    btnRefresh = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-success btn-sm' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button>";

	$("#tblMasterGudang").DataTable({
		serverSide:true,
		responsive:true,
		processing:false,
		oLanguage: {
            sZeroRecords: "<center>Data tidak ditemukan</center>",
            sLengthMenu: "Tampilkan _MENU_ data   "+btnTambah+btnRefresh,
            sSearch: "Cari data:",
            sInfo: "Menampilkan: _START_ - _END_ dari total: _TOTAL_ data",                                   
            oPaginate: {
                sFirst: "Awal", "sPrevious": "Sebelumnya",
                sNext: "Selanjutnya", "sLast": "Akhir"
            },
        },
		//load data
		ajax: {
			url: '/master/gudang/ajax_list',
			type: 'POST',
		},

		order:[[1,'ASC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'nama_gudang' },
			{ data:'no_telp' },
			{ data:'alamat' },
			{ data:'keterangan' },
			{
				data:'button_opsi',
				searchable:false,
				orderable:false,
			},
			{
				data:'button_action',
				searchable:false,
				orderable:false,
			}
		],
	});

});

function reloadTable() {
	$("#tblMasterGudang").DataTable().ajax.reload(null,false);
}

var save_method;
var idData;

$(document).on('click', '#btnRefresh', function(e) {
	e.preventDefault();
	reloadTable();
	$("#btnRefresh").children().addClass("fa-spin");
	setTimeout(function(){
	  $("#btnRefresh").children().removeClass("fa-spin");
	}, 1000);
});

$(document).on('click', '#btnTambah', function (e) {
	e.preventDefault();
	$("#modalForm").modal("show");
	$("#formData")[0].reset();
	$(".modal-title").text("Tambah Master Gudang");
	save_method = "add";
});

function editGudang(id) {
	idData = id;
	$("#modalForm").modal("show");
	$(".modal-title").text("Update Master Gudang");
	save_method = "update";

	$.post("/master/gudang/getId/"+idData,function(json) {
		if (json.status == true) {
			$('#nama_gudang').val(json.data.nama_gudang);
			$("#no_telp").val(json.data.no_telp);
		    $("#alamat").val(json.data.alamat);
		    $("#keterangan").val(json.data.keterangan);
		} else {
			$("#inputMessage").html(json.message);

			$('#nama_gudang').val("");
			$("#no_telp").val("");
		    $("#alamat").val("");
		    $("#keterangan").val("");
			setTimeout(function() {
				reloadTable();
				$("#modalForm").modal("hide");
			},1000);
		}
	});

}

$("#modalButtonSave").click(function() {
	var url;
	if (save_method == "add") {
		url = '/master/gudang/add';
	} else {
		url = '/master/gudang/update/'+idData;
	}

	$.ajax({
		url: url,
		type:'POST',
		data:$("#formData").serialize(),
		dataType:'JSON',
		success: function(json) {
			if (json.status == true) {
				$("#inputMessage").html(json.message);

				swal({    
			            title: json.message,
			            type: "success",
			            timer: 2000,   
			            showConfirmButton: false 
			        });

				setTimeout(function() {
					$("#formData")[0].reset();
					$("#modalForm").modal("hide");
					$("#inputMessage").html("");
					reloadTable();
				}, 1500);
			} else {
				$("#errorNamaGudang").html(json.error.nama_gudang);
				$("#errorNoTelp").html(json.error.no_telp);
				$("#errorAlamat").html(json.error.alamat);
				$("#errorKeterangan").html(json.error.keterangan);

				swal({   
			            title: "Error Form.!",   
			            html: json.message,
			            type: "error",
			        });

				setTimeout(function() {
					$("#errorNamaGudang").html("");
					$("#errorNoTelp").html("");
					$("#errorAlamat").html("");
					$("#errorKeterangan").html("");
				},3000);
			}
		}
	});
});

function btnDelete(id) {
	idData = id;

	$.post("/master/gudang/getId/"+idData,function(json) {
		if (json.status == true) {

			var pesan = "<hr>";
				pesan += "<li class='pull-left'><small>Nama Gudang : <i>"+json.data.nama_gudang+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>No Telp: <i>"+json.data.no_telp+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Alamat: <i>"+json.data.alamat+"</i></small></li><br>";
		    swal({   
		        title: "Apakah anda yakin.?",   
		        html: "<span style='color:red;'>Data yang di <b>Hapus</b> tidak bisa dikembalikan lagi.</span>"+pesan,
		        type: "warning",
  				showCloseButton: true,
		        showCancelButton: true,   
		        confirmButtonColor: "#DD6B55",   
		        confirmButtonText: "Iya, Hapus",   
		        closeOnConfirm: false 
		    }).then((result) => {
		    	if (result.value) {
		    		$.post("/master/gudang/delete/"+idData,function(json) {
						if (json.status == true) {
							swal({    
						            title: json.message,
						            type: "success",
						            timer: 2000,   
						            showConfirmButton: false 
						        });
							reloadTable();
						} else {
							swal({    
						            title: json.message,
						            type: "error",
						            timer: 1000,   
						            showConfirmButton: false 
						        });
							reloadTable();
						}
					});
		    	}
		    });
		} else {
			reloadTable();
			swal({    
		            title: json.message,
		            type: "error",
		            timer: 1000,   
		            showConfirmButton: false 
		        });
		}
	});
}