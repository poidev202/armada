$(document).ready(function() {
	
	btnTambah = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-primary btn-sm' id='btnTambah'><i class='fa fa-plus'></i> Tambah</button>";
   	
    btnRefresh = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-success btn-sm' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button>";

	$("#tblMasterProduk").DataTable({
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
			url: '/master/produk/ajax_list',
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
			{ data:'kategori' },
			{ data:'unit' },
			{ data:'nama_gudang' },
			{ data:'nama_vendor' },
			{ data:'harga_unit' },
			{ data:'saldo' },
			{ data:'saldo_min' },
			{
				data:'button_action',
				searchable:false,
				orderable:false,
			},
		],
	});

});

function reloadTable() {
	$("#tblMasterProduk").DataTable().ajax.reload(null,false);
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
	$("#gudang").val("").trigger('change');
	$("#kategori").val("").trigger('change');
    $("#unit").val("").trigger('change');
    $("#vendor").val("").trigger('change');
    $("#mata_uang_harga_unit").html("");
	$("#infoKodeProduk").hide();
	$("#infoTotalHargaBeli").hide();

	$(".modal-title").text("Tambah Master Produk");
	save_method = "add";
});

$(document).ready(function () {
    $('#harga_unit').on('input', function() {
        $('#mata_uang_harga_unit').html( moneyFormat.to( parseInt($(this).val()) ) );
    });
}); 

/* master vendor */
$.post("/master/vendor/getAll",function(json) {
	var option;

	option = '<option value="">-- Pilih Vendor --</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.nama_vendor+'</option>';
	});

	$("#vendor").html(option);
});

/* master gudang */
$.post("/master/gudang/getAll",function(json) {
	var option;

	option = '<option value="">-- Pilih Gudang --</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.nama_gudang+'</option>';
	});

	$("#gudang").html(option);
});

/* kategori */
$.post("/master/produkkategori/getAllKategori",function(json) {
	var option;

	option = '<option value="">--Pilih Kategori--</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.kategori+'</option>';
	});

	$("#kategori").html(option);
});

/*unit*/
$.post("/master/produkkategori/getAllUnit",function(json) {
	var option;

	option = '<option value="">--Pilih Unit--</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.unit+'</option>';
	});

	$("#unit").html(option);
});

$("#harga_unit, #saldo").keyup(function() {
	var harga_unit = $("#harga_unit").val();
	var saldo = $("#saldo").val();

	harga_unit = harga_unit == false ? 0 : harga_unit;
	saldo = saldo == false ? 0 : saldo;

	var totalHargaBeli = ( parseInt(harga_unit) * parseInt(saldo));

	if (totalHargaBeli != 0 ) {
		$("#infoTotalHargaBeli").show(500);
	} else {
		$("#infoTotalHargaBeli").hide(500);
	}
	// console.log(totalHargaBeli);
	$("#totalHargaBeli").val( moneyFormat.to(parseInt(totalHargaBeli)) );
});

function detailProduk(id) {
	idData = id;
	$.post("/master/produk/getId/"+idData,function(json) {
		if (json.status == true) {
			$("#modalDetail").modal("show");

			$("#detailKodeProduk").html(json.data.kode);
			$('#detailNamaProduk').html(json.data.nama_produk);
			// $('#detailTanggalBeli').html(json.data.tanggal_beli);
			$("#detailGudang").html(json.data.nama_gudang);
			$("#detailKategori").html(json.data.kategori);
		    $("#detailUnit").html(json.data.unit);
		    $("#detailVendor").html(json.data.nama_vendor);
			$('#detailSaldo').html(json.data.saldo);
			$('#detailHargaUnit').html(json.data.harga_unit_rp);
			$('#detailSaldoMinimal').html(json.data.saldo_min);
		    $("#detailKeterangan").html(json.data.keterangan);
			
			$("#detailInfoTotalHarga").show();
			$('#detailTotalHarga').html(json.data.harga_unit_total_rp);
		} else {
			reloadTable();
			swal({    
		            title: json.message,
		            type: "error",
		            timer: 1500,   
		            showConfirmButton: false 
		        });
		}
	});

}

function editProduk(id) {
	idData = id;
	$("#modalForm").modal("show");
	$(".modal-title").text("Update Master Produk");
	$("#totalHargaBeli").val("");
	save_method = "update";

	$.post("/master/produk/getId/"+idData,function(json) {
		if (json.status == true) {
			$("#infoKodeProduk").show();
			$("#kodeProduk").html(json.data.kode);

			$('#nama_produk').val(json.data.nama_produk);
			// $('#tanggal_beli').val(json.data.tanggal_beli);
			$("#gudang").val(json.data.gudang_id).trigger('change');
			$("#kategori").val(json.data.kategori_id).trigger('change');
		    $("#unit").val(json.data.unit_id).trigger('change');
		    $("#vendor").val(json.data.vendor_id).trigger('change');
			$('#saldo').val(json.data.saldo);
			$('#harga_unit').val(json.data.harga_unit);
			$("#infoTotalHargaBeli").show();
			$("#totalHargaBeli").val(json.data.harga_unit_total_rp);
			$('#mata_uang_harga_unit').html(json.data.harga_unit_rp);
			$('#saldo_minimal').val(json.data.saldo_min);
		    $("#keterangan").val(json.data.keterangan);
		} else {
			$("#inputMessage").html(json.message);
			$("#infoKodeProduk").hide();
			$("#kodeProduk").html("");

			$('#nama_produk').val("");
			// $("#tanggal_beli").val("");
			$("#gudang").val("").trigger('change');
			$("#kategori").val("").trigger('change');
		    $("#unit").val("").trigger('change');
		    $("#vendor").val("").trigger('change');
			$('#harga_unit').val("");
			$("#infoTotalHargaBeli").show();
			$("#totalHargaBeli").val("");
			$('#mata_uang_harga_unit').html("");
			$('#saldo').val("");
			$('#saldo_minimal').val("");
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
		url = '/master/produk/add';
	} else {
		url = '/master/produk/update/'+idData;
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
				var pesanError = json.message;
				if (json.message == "") {
					pesanError = json.error.nama_produk;
				}

				swal({   
			            title: "Error Form.!",   
			            html: pesanError,
			            type: "error",
			        });
			}
		}
	});
});

function btnDelete(id) {
	idData = id;

	$.post("/master/produk/getId/"+idData,function(json) {
		if (json.status == true) {

			var pesan = "<hr>";
				pesan += "<small style='color:orange'>Note: Menghapus data ini juga akan Menghapus data transaksi pembelian / penjualan dan laporan gudang yang berhubungan dengan data yang anda pilih ini.!</small><hr>";
				pesan += "<li class='pull-left'><small>Kode : <i>"+json.data.kode+"</i></small></li><br>";
				// pesan += "<li class='pull-left'><small>Tanggal Beli : <i>"+json.data.tanggal_beli+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Nama Produk : <i>"+json.data.nama_produk+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Kategori : <i>"+json.data.kategori+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Vendor : <i>"+json.data.nama_vendor+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Gudang : <i>"+json.data.nama_gudang+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Unit : <i>"+json.data.unit+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Harga Unit : <i>"+json.data.harga_unit_rp+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Saldo : <i>"+json.data.saldo+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Saldo Minimal : <i>"+json.data.saldo_min+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Keterangan : <i>"+json.data.keterangan+"</i></small></li><br>";

		    swal({   
		        title: "Apakah anda yakin.?",   
		        html: "<span style='color:red;'>Data yang di <b><u>Hapus</u></b> tidak bisa dikembalikan lagi.</span>"+pesan,
		        type: "warning", 
				// html: true,
  				showCloseButton: true,
		        showCancelButton: true,   
		        confirmButtonColor: "#DD6B55",   
		        confirmButtonText: "Iya, Hapus",   
		        closeOnConfirm: false 
		    }).then((result) => {
		    	if (result.value) {
		    		$.post("/master/produk/delete/"+idData,function(json) {
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