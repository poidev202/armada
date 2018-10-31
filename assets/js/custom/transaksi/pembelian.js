$(document).ready(function() {
	
	btnTambah = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-info btn-sm' id='btnTambah'><i class='fa fa-plus'></i> Tambah</button>";
   	
    btnRefresh = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-success btn-sm' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button>";

	var tbl = $("#tblTransaksiPembelian").DataTable({
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
			url: '/transaksi/pembelian/ajax_list',
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
				data:'button_action',
				searchable:false,
				orderable:false,
			},
			{ data:'tanggal_beli' },
			{ data:'kode' },
			{ data:'nama_produk' },
			{ data:'nama_gudang' },
			{ data:'nama_vendor' },
			{ data:'kategori' },
			{ data:'unit' },
			{ data:'harga_beli_unit' },
			{ data:'jumlah' },
			{ data:'harga_beli_total' },
			{ data:'nama_kas' },
		],
	});

	$('#tgl_awal_beli, #tgl_akhir_beli').on( 'change', function () {   // for text boxes

		var awal = $("#tgl_awal_beli").attr('data-column');  // getting column index
		var akhir = $("#tgl_akhir_beli").attr('data-column');  // getting column index
		var valAwal = $("#tgl_awal_beli").val();  // getting search input value
		var valAkhir = $("#tgl_akhir_beli").val();  // getting search input value

		if (valAwal != "" && valAkhir != "") {
			if (valAkhir < valAwal) {
				alert("tanggal awal tidak boleh lebih besar dari tanggal akhir");
			} else {
				tbl.columns(awal).search(valAwal).draw();
				tbl.columns(akhir).search(valAkhir).draw();
			}
		} else {
			tbl.columns(awal).search("").draw();
			tbl.columns(akhir).search("").draw();
		}
	});

	$('#gudang_cari').on( 'change', function () {   // for select box
		var i =$(this).attr('data-column');  
		var v =$(this).val();  
		tbl.columns(i).search(v).draw();
	});
	$('#kategori_cari').on( 'change', function () {   // for select box
		var i =$(this).attr('data-column');  
		var v =$(this).val();  
		tbl.columns(i).search(v).draw();
	});

});

function reloadTable() {
	$("#tblTransaksiPembelian").DataTable().ajax.reload(null,false);
}

var save_method;
var idData;

$(document).on('click', '#btnRefresh', function(e) {
	e.preventDefault();
	reloadTable();
	$("#btnRefresh").children().addClass("fa-spin");
	setTimeout(function(){
	  $("#btnRefresh").children().removeClass("fa-spin");
	}, 800);
});

$(".close-form").click(function() {
	$("#dataTable").show(800);
	$("#formProses").hide(800);
	$("#detailPembelian").hide(800);
});

$(document).on('click', '#btnTambah', function (e) {
	e.preventDefault();
	
	$("#formData")[0].reset();
	$("#titleForm").text("Tambah Transaksi Pembelian");
	$("#ribbonTitle").removeClass("ribbon-warning");
	$("#ribbonTitle").addClass("ribbon-info");

	$("#iconForm").addClass("fa-plus");
	$("#iconForm").removeClass("fa-pencil-square-o");

	$('#mata_uang_harga_unit').html("");
	$("#infoTotalHargaBeli").hide();
	$("#totalHargaBeli").val("");

	$("#nama_produk").val("").trigger("change");
	$("#gudang").val("").trigger("change");
	$("#vendor").val("").trigger("change");
	$("#account_kas").val("").trigger("change");

	$("#dataTable").hide(800);
	$("#formProses").show(800);

	save_method = "add";
});

$(document).ready(function () {
    $('#harga_unit').on('input', function() {
        $('#mata_uang_harga_unit').html( moneyFormat.to( parseInt($(this).val()) ) );
    });
}); 

/* master produk */
$.post("/master/produk/getAll",function(json) {
	var option;

	option = '<option value="">-- Pilih Produk --</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">kode = '+v.kode+'  &nbsp;&nbsp;||&nbsp;&nbsp;  nama = '+v.nama_produk+'</option>';
	});

	$("#nama_produk").html(option);
});

$("#nama_produk").change(function() {
	if ($(this).val() != "") {
		$.post("/master/produk/getId/"+$(this).val(),function(json) {
			if (json.status == true) {
				$("#kategori_produk").val(json.data.kategori);
				$("#unit_produk").val(json.data.unit);
				$("#infoHargaPerUnit").show(800);
				$("#harga_terendah").val(json.data.harga_unit_min);
				$("#harga_terendah").attr("title",json.data.harga_unit_min);
				$("#harga_rata2").val(json.data.harga_unit_rata2);
				$("#harga_rata2").attr("title",json.data.harga_unit_rata2);
				$("#harga_tertinggi").val(json.data.harga_unit_max);
				$("#harga_tertinggi").attr("title",json.data.harga_unit_max);
				$("#harga_terakhir").val(json.data.harga_terakhir);
				$("#harga_terakhir").attr("title",json.data.harga_terakhir);
			} else {
				$("#kategori_produk").val("");
				$("#unit_produk").val("");
				$("#infoHargaPerUnit").hide(800);
				$("#harga_terendah").val("");
				$("#harga_rata2").val("");
				$("#harga_tertinggi").val("");
				$("#harga_terakhir").val("");
			}
		});
	} else {
		$("#infoHargaPerUnit").hide(800);
		$("#harga_terendah").val("");
		$("#kategori_produk").val("");
		$("#unit_produk").val("");
		$("#harga_rata2").val("");
		$("#harga_tertinggi").val("");
		$("#harga_terakhir").val("");
	}
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

/* master vendor */
$.post("/master/vendor/getAll",function(json) {
	var option;

	option = '<option value="">-- Pilih Vendor --</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.nama_vendor+'</option>';
	});

	$("#vendor").html(option);
});

var option = ""; // master account kas
$.post("/master/accountkas/getAll",function (json) {
	option = '<option value="">--Pilih Account Kas--</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.nama_kas+'</option>';
	});
	$("#account_kas").html(option);
});

function btnDetail(id) {
	idData = id;
	$("#dataTable").hide(800);
	$("#detailPembelian").show(800);

	$.post("/transaksi/pembelian/getId/"+idData,function(json) {
		if (json.status == true) {
			$("#detailNamaProduk").html(json.data.nama_produk);
			$("#detailTanggalBeli").html(json.data.tanggal_beli_indo);
			$("#detailKategori").html(json.data.kategori);
			$("#detailUnit").html(json.data.unit);
			$("#detailGudang").html(json.data.nama_gudang);
			$("#detailVendor").html(json.data.nama_vendor);
			$("#detailHargaBeliUnit").html(json.data.harga_beli_unit_rp);
			$("#detailJumlah").html(json.data.jumlah);
			$("#detailAccountKas").html(json.data.nama_kas);
			$("#detailKeterangan").html(json.data.keterangan);
			$("#detailTotalHargaBeli").html( moneyFormat.to(parseInt(json.data.harga_beli_total)) );
			$("#detailHargaUnit").html(json.data.harga_unit_rp);
		} else {
			$("#inputMessage").html(json.message);
			setTimeout(function() {
				$("#inputMessage").html("");
				$("#dataTable").show(800);
				$("#formProses").hide(800);
			},800);
		}
	});
}

$("#harga_unit, #jumlah").keyup(function() {
	var harga_unit = $("#harga_unit").val();
	var jumlah = $("#jumlah").val();

	harga_unit = harga_unit == false ? 0 : harga_unit;
	jumlah = jumlah == false ? 0 : jumlah;

	var totalHargaBeli = ( parseInt(harga_unit) * parseInt(jumlah));

	if (totalHargaBeli != 0 ) {
		$("#infoTotalHargaBeli").show(500);
	} else {
		$("#infoTotalHargaBeli").hide(500);
	}
	// console.log(totalHargaBeli);
	$("#totalHargaBeli").val( moneyFormat.to(parseInt(totalHargaBeli)) );
});

function btnEdit(id) {
	$("#titleForm").text("Update Transaksi Pembelian");
	$("#ribbonTitle").removeClass("ribbon-info");
	$("#ribbonTitle").addClass("ribbon-warning");

	$("#iconForm").addClass("fa-pencil-square-o");
	$("#iconForm").removeClass("fa-plus");
	$("#totalHargaBeli").val("");
	
	$("#dataTable").hide(800);
	$("#formProses").show(800);

	save_method = "update";
	idData = id;

	$.post("/transaksi/pembelian/getId/"+idData,function(json) {
		if (json.status == true) {
			$("#nama_produk").val(json.data.produk_id).trigger("change");
			$("#tanggal_beli").val(json.data.tanggal_beli);
			$("#gudang").val(json.data.gudang_id).trigger("change");
			$("#vendor").val(json.data.vendor_id).trigger("change");
			$("#kategori_produk").val(json.data.kategori);
			$("#unit_produk").val(json.data.unit);
			$("#harga_unit").val(json.data.harga_beli_unit);
			$('#mata_uang_harga_unit').html(json.data.harga_beli_unit_rp);
			$("#jumlah").val(json.data.jumlah);
			$("#keterangan").val(json.data.keterangan);
			$("#infoTotalHargaBeli").show(800);
			$("#totalHargaBeli").val( moneyFormat.to(parseInt(json.data.harga_beli_total)) );

		} else {
			$("#inputMessage").html(json.message);
			$("#nama_produk").val("").trigger("change");
			$("#tanggal_beli").val("");
			$("#gudang").val("").trigger("change");
			$("#vendor").val("").trigger("change");
			$("#kategori_produk").val("");
			$("#unit_produk").val("");
			$("#harga_unit").val("");
			$('#mata_uang_harga_unit').html("");
			$("#jumlah").val("");
			$("#keterangan").val("");
			setTimeout(function() {
				$("#inputMessage").html("");
				$("#dataTable").show(800);
				$("#formProses").hide(800);
			},800);
		}
	});
}

$("#btnSimpan").click(function() {
	$.ajax({
		url: '/transaksi/pembelian/inputForm',
		type:'POST',
		data:$("#formData").serialize(),
		dataType:'JSON',
		success: function(json) {
			if (json.status == true) {
				swal({   
			        title: "Apakah anda yakin.?",   
			        html: json.message,
			        type: "info", 
					showCloseButton: true,
			        showCancelButton: true,   
			        confirmButtonColor: "#1976d2",   
			        confirmButtonText: "Iya, Simpan",   
			        // closeOnConfirm: false
			    }).then((result) => {
			    	/*var url;
					if (save_method == "add") {
						url = '/transaksi/pembelian/add';
					} else {
						url = '/transaksi/pembelian/update/'+idData;
					}*/
			    	if (result.value) {
				    	$.ajax({
								url: '/transaksi/pembelian/add',
								type:'POST',
								data:$("#formData").serialize(),
								dataType:'JSON',
								success: function(resp) {
									if (resp.status == true) {
										$("#inputMessage").html(resp.message);
										swal({    
									            title: resp.message,
									            type: "success",
									            timer: 2000,   
									            showConfirmButton: false 
									        });

										setTimeout(function() {
											$("#formData")[0].reset();
											$("#dataTable").show(800);
											$("#formProses").hide(800);
											$("#inputMessage").html("");
											reloadTable();
										}, 1500);
									} else {
										var pesanError = resp.message;
										if (resp.message == "") {
											pesanError = resp.error.nama_produk;
										}
										swal({   
									            title: "Error Form.!",   
									            html: pesanError,
									            type: "error",
									        });
									}
								}
							});
				    }
				});
			} else {
				swal({   
			            title: "Error Form.!",   
			            html: json.message,
			            type: "error",
			        });
			}
		}
	});
});

function btnDelete(id) {
	idData = id;

	$.post("/transaksi/pembelian/getId/"+idData,function(json) {
		if (json.status == true) {

			var pesan = "<hr>";
				pesan += "<small style='color:orange'>Note: Menghapus data ini juga akan Menghapus data laporan gudang yang berhubungan dengan data yang anda pilih ini.!</small><hr>";
				pesan += "<li class='pull-left'><small>Tanggal Beli : <i>"+json.data.tanggal_beli_indo+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Kode Produk : <i>"+json.data.kode+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Nama Produk : <i>"+json.data.nama_produk+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Gudang : <i>"+json.data.nama_gudang+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Vendor : <i>"+json.data.nama_vendor+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Kategori : <i>"+json.data.kategori+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Unit : <i>"+json.data.unit+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Harga Unit : <i>"+json.data.harga_beli_unit_rp+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Jumlah : <i>"+json.data.jumlah+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Harga Total : <i>"+json.data.harga_beli_total_rp+"</i></small></li><br>";

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
		    		$.post("/transaksi/pembelian/delete/"+idData,function(json) {
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
						            timer: 800,   
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
		            timer: 800,   
		            showConfirmButton: false 
		        });
		}
	});
}

/*Filter searching*/
/* master gudang */
$.post("/master/gudang/getAll",function(json) {
	var option;
	option = '<option value="">-- Pilih Gudang --</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.nama_gudang+'</option>';
	});

	$("#gudang_cari").html(option);
});

/* kategori */
$.post("/master/produkkategori/getAllKategori",function(json) {
	var option;
	option = '<option value="">--Pilih Kategori--</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.kategori+'</option>';
	});

	$("#kategori_cari").html(option);
});
