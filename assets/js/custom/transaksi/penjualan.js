$(document).ready(function() {
	
	btnTambah = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-primary btn-sm' id='btnTambah'><i class='fa fa-plus'></i> Tambah</button>";
   	
    btnRefresh = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-success btn-sm' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button>";

	var tbl = $("#tblTransaksiPenjualan").DataTable({
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
			url: '/transaksi/penjualan/ajax_list',
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
			{ data:'tanggal_jual' },
			{ data:'kode' },
			{ data:'nama_produk' },
			{ data:'nama' },
			{ data:'nama_gudang' },
			{ data:'kategori' },
			{ data:'unit' },
			{ data:'harga_jual_unit' },
			{ data:'jumlah' },
			{ data:'harga_jual_total' },
			{ data:'nama_kas' },
		],
	});

	$('#tgl_awal_jual, #tgl_akhir_jual').on( 'change', function () {   // for text boxes

		var awal = $("#tgl_awal_jual").attr('data-column');  // getting column index
		var akhir = $("#tgl_akhir_jual").attr('data-column');  // getting column index
		var valAwal = $("#tgl_awal_jual").val();  // getting search input value
		var valAkhir = $("#tgl_akhir_jual").val();  // getting search input value

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
	$("#tblTransaksiPenjualan").DataTable().ajax.reload(null,false);
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
	$("#detailPenjualan").hide(800);
});

$(document).on('click', '#btnTambah', function (e) {
	e.preventDefault();
	
	$("#formData")[0].reset();
	$("#titleForm").text("Tambah Transaksi Penjualan / Pemakaian");
	$("#ribbonTitle").removeClass("ribbon-warning");
	$("#ribbonTitle").addClass("ribbon-primary");

	$("#iconForm").addClass("fa-plus");
	$("#iconForm").removeClass("fa-pencil-square-o");

	$('#mata_uang_harga_jual').html("");
	$("#infoTotalHargaJual").hide();
	$("#totalHargaJual").val("");

	$("#nama_produk").val("").trigger("change");
	$("#gudang").html("");
	$("#gudang").val("").trigger("change");
	$("#nama_armada").val("").trigger("change");
	$("#account_kas").val("").trigger("change");
	
	$("#dataTable").hide(800);
	$("#formProses").show(800);

	save_method = "add";
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
	$("#detailPenjualan").show(800);

	$.post("/transaksi/penjualan/getId/"+idData,function(json) {
		if (json.status == true) {
			$("#detailNamaProduk").html(json.data.nama_produk);
			$("#detailTanggalJual").html(json.data.tanggal_jual_indo);

			$.post("/master/produk/getId/"+json.data.produk_id,function(json) {
				if (json.status == true) {
					$("#detailKategoriProduk").html(json.data.kategori);
					$("#detailUnitProduk").html(json.data.unit);
				} else {
					$("#detailKategoriProduk").html("");
					$("#detailUnitProduk").html("");
				}
			});
			$("#detailGudang").html(json.data.nama_gudang);
			$("#detailNamaArmada").html(json.data.nama);
			$("#detailHargaJual").html(json.data.harga_jual_unit_rp);
			$("#detailJumlah").html(json.data.jumlah);
			$("#detailAccountKas").html(json.data.nama_kas);
			$("#detailKeterangan").html(json.data.keterangan);
			$("#detailTotalHargaJual").html(json.data.harga_jual_total_rp);
			$("#detailTanggalBeli").html(json.data.tanggal_beli_indo);
			$("#detailHargaBeliUnit").html(json.data.harga_unit_beli_rp);

			$.post("/master/armada/getId/"+json.data.armada_id,function (json) {
				if (json.status == true) {
					$("#detailImgArmada").attr("src",json.data.photo);
					$("#detailNoBK").html(json.data.no_bk);
					$("#detailTahun").html(json.data.tahun);
					$("#detailKaroseri").html(json.data.nama_karoseri);
					$("#detailTipeKaroseri").html(json.data.tipe_karoseri);
					$("#detailMerkChassis").html(json.data.merk);
					$("#detailTipeChassis").html(json.data.tipe);
				} else {
					$("#detailImgArmada").attr("src","/assets/images/default/no_image.jpg");
					$("#detailNoBK").html("");
					$("#detailTahun").html("");
					$("#detailKaroseri").html("");
					$("#detailTipeKaroseri").html("");
					$("#detailMerkChassis").html("");
					$("#detailTipeChassis").html("");
				}
			});

		} else {
			$("#inputMessageDetail").html(json.message);
			$("#detailNamaProduk").html("");
			$("#detailTanggalJual").html("");
			$("#detailGudang").html("");
			$("#detailNamaArmada").html("");
			$("#detailHargaJual").html("");
			$("#detailJumlah").html("");
			$("#detailKeterangan").html("");
			$("#detailTanggalBeli").html("");
			$("#detailHargaBeliUnit").html("");

			setTimeout(function() {
				$("#inputMessage").html("");
				$("#dataTable").show(800);
				$("#formProses").hide(800);
			},800);
		}
	});

}

$(document).ready(function () {
    $('#harga_jual').on('input', function() {
        $('#mata_uang_harga_jual').html( moneyFormat.to( parseInt($(this).val()) ) );
    });
}); 

$("#harga_jual, #jumlah").keyup(function() {
	var harga_jual = $("#harga_jual").val();
	var jumlah = $("#jumlah").val();

	harga_jual = harga_jual == false ? 0 : harga_jual;
	jumlah = jumlah == false ? 0 : jumlah;

	var totalHargaJual = ( parseInt(harga_jual) * parseInt(jumlah));

	if (totalHargaJual != 0 ) {
		$("#infoTotalHargaJual").show(500);
	} else {
		$("#infoTotalHargaJual").hide(500);
	}
	// console.log(totalHargaJual);
	$("#totalHargaJual").val( moneyFormat.to(parseInt(totalHargaJual)) );
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
			} else {
				$("#kategori_produk").val("");
				$("#unit_produk").val("");
			}
		});

		$.post("/laporan/gudang/produkSaldo/"+$(this).val(),function(json) {
			if (json.status == true) {
				$("#infoSaldoProduk").show(800);
				$("#errorSaldo").html("");

				$("#saldo_minimal").val(json.data.saldo_min);
				// $("#total_saldo").val(json.data.total_saldo);
				$("#sisa_saldo").val(json.data.sisa_saldo);
			} else {
				$("#infoSaldoProduk").hide(800);
				$("#errorSaldo").html(json.message);

				$("#saldo_minimal").val("");
				// $("#total_saldo").val("");
				$("#sisa_saldo").val("");
			}
		});

		if (save_method == "add") {
			// gudang per produk id dari laporan gudang
			$.post("/laporan/gudang/gudangPerProduk/"+$(this).val(),function(json) {
				var option = "";
				if (json.status == true) {
					option = '<option value="">-- Pilih Gudang --</option>';
					$.each(json.data,function(i,v) {
						option += '<option value="'+v.gudang_id+'">'+v.nama_gudang+'</option>';
					});
				}
				$("#gudang").html(option);
			});
		}

		$("#hargaUnitProdukGudang").html("");
		$("#infoHargaSaldoGudang").hide(800);

		// hide harga beli unit, saldo dan sisa saldo
		saldoHargaBeliUnit();
	} else {
		$("#infoSaldoProduk").hide(800);
		$("#errorSaldo").html("");
		$("#kategori_produk").val("");
		$("#unit_produk").val("");
		$("#saldo_minimal").val("");
		// $("#total_saldo").val("");
		$("#sisa_saldo").val("");
		// $("#gudang").html("");
		$("#hargaUnitProdukGudang").html("");
		$("#infoHargaSaldoGudang").hide(800);

		// hide harga beli unit, saldo dan sisa saldo
		saldoHargaBeliUnit();
	}
});

// if(save_method === "update"){
	 // master gudang 
	/*$.post("/master/gudang/getAll/",function(json) {
		var optionGudang = "";
		// if (json.status == true) {
			optionGudang = '<option value="">-- Pilih Gudang --</option>';
			$.each(json.data,function(i,v) {
				optionGudang += '<option value="'+v.id+'">'+v.nama_gudang+'</option>';
			});
		// }
		$("#gudang").html(optionGudang);
	});*/
// }

$("#gudang").change(function() {
	var hargaUnit = "";
	var produkId = $("#nama_produk").val();

	if ($(this).val() != "" && produkId != "") {
		$("#infoHargaSaldoGudang").show(800);
		// for harga unit produk
		$.post("/laporan/gudang/gudangHargaUnitProduk/"+produkId+"/"+$(this).val(),function(json) {
			if (json.status == true) {
				$.each(json.data,function(i,v) {
					var statusHarga = v.status == "saldo_awal" ? "Saldo Awal" : "Beli";

					hargaUnit += '<div class="form-group m-b-5 m-t-7">';
					hargaUnit +=	'<label><span><u>- '+statusHarga+'</u></span> | <span>'+v.tanggal_indo+'</span> :</label>';
					hargaUnit +=	'<input type="text" class="form-control" value='+v.harga_unit_rp+' readonly>';
					hargaUnit += '</div>';
				});
				$("#hargaUnitProdukGudang").html(hargaUnit);
			} else {
				$("#hargaUnitProdukGudang").html(json.message);
			}
		});

		$.post("/laporan/gudang/gudangHargaUnitProdukTanggal/"+produkId+"/"+$(this).val(),function(resp) {
			if (resp.status == true) {
				$("#hargaUnitProdukGudangPerTanggal").html(resp.data);
			} else {
				$("#hargaUnitProdukGudangPerTanggal").html(resp.message);
			}
		});

		// for saldo per gudang di laporan
		$.post("/laporan/gudang/gudangSumSaldoPerProduk/"+produkId+"/"+$(this).val(),function(json) {
			if (json.status == true) {
				// $("#saldo_gudang").val(json.data.total_saldo);
				$("#sisa_saldo_gudang").val(json.data.sisa_saldo_gudang);
			} else {
				// $("#saldo_gudang").val(json.message);
				$("#sisa_saldo_gudang").val("");
			}
		});
		// hide harga beli unit, saldo dan sisa saldo
		saldoHargaBeliUnit();
	} else {
		$("#infoHargaSaldoGudang").hide(800);
		$("#hargaUnitProdukGudang").html(hargaUnit);
		$("#saldo_gudang").val("");
		$("#sisa_saldo_gudang").val("");

		// hide harga beli unit, saldo dan sisa saldo
		saldoHargaBeliUnit();
	}
});

function saldoHargaBeliUnit() {
	$("#showHargaBeliUnit").hide(800);
	$("#tglBeli").html("");
	$("#statusProduk").html("");
	$("#saldoMasukHargaTanggal").val("");
	$("#saldoSisaHargaTanggal").val("");
}

$("#hargaUnitProdukGudangPerTanggal").change(function() {
	if ($(this).val() != "") {
		var produkId = $("#nama_produk").val();
		var gudang = $("#gudang").val();
		var valArr = $(this).val().split("||");

		if ($(this).val() != "" && produkId != "" && gudang != "") {
			// for saldo per harga tanggal produk gudang di laporan
			$.post("/laporan/gudang/saldoHargaProdukTanggal/"+valArr[0]+"/"+produkId+"/"+gudang+"/"+valArr[1],function(json) {
				if (json.status == true) {
					$("#showHargaBeliUnit").show(800);
					var statusProduk = json.data.status_produk == "saldo_awal" ? "- Saldo Awal" : "- Beli";
					$("#statusProduk").html(statusProduk);
					$("#tglBeli").html(json.data.tanggal_indo);
					$("#saldoMasukHargaTanggal").val(json.data.total_saldo_masuk_hrg_tgl);
					$("#saldoSisaHargaTanggal").val(json.data.sisa_saldo_hrg_tgl);
				} else {
					// hide harga beli unit, saldo dan sisa saldo
					saldoHargaBeliUnit();
				}
			});
		} else {
			// hide harga beli unit, saldo dan sisa saldo
			saldoHargaBeliUnit();
		}
	} else {
		// hide harga beli unit, saldo dan sisa saldo
		saldoHargaBeliUnit();
	}
});

/* for armada */
$.post("/master/armada/getAll",function (json) {
	option = '<option value="">--Pilih Armada--</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.nama+'</option>';
	});

	$("#nama_armada").html(option);
});

var idArmada;
$("#nama_armada").change(function () {
	id_val = $("#nama_armada").val();
	if (id_val != "") {
		idArmada = id_val;
		$.post("/master/armada/getId/"+idArmada,function (json) {
			if (json.status == true) {
				$("#imgArmada").attr("src",json.data.photo);
				$("#no_bk").val(json.data.no_bk);
				$("#tahun").val(json.data.tahun);
				$("#karoseri").val(json.data.nama_karoseri);
				$("#tipe_karoseri").val(json.data.tipe_karoseri);
				$("#merk_chassis").val(json.data.merk);
				$("#tipe_chassis").val(json.data.tipe);
			} else {
				$("#errorNamaArmada").html(json.message);
			}
		});
	} else {

		$("#imgArmada").attr("src","/assets/images/default/no_image.jpg");
		$("#no_bk").val("");
		$("#tahun").val("");
		$("#karoseri").val("");
		$("#tipe_karoseri").val("");
		$("#merk_chassis").val("");
		$("#tipe_chassis").val("");
	}
});

function btnEdit(id) {
	$("#titleForm").text("Update Transaksi Penjualan");
	$("#ribbonTitle").removeClass("ribbon-info");
	$("#ribbonTitle").addClass("ribbon-warning");

	$("#iconForm").addClass("fa-pencil-square-o");
	$("#iconForm").removeClass("fa-plus");
	$("#totalHargaJual").val("");
	
	$("#dataTable").hide(800);
	$("#formProses").show(800);

	save_method = "update";
	idData = id;

	var gudangProduk_id;

	$.post("/transaksi/penjualan/getId/"+idData,function(json) {
		if (json.status == true) {
			$("#nama_produk").val(json.data.produk_id).trigger("change");
			$("#nama_armada").val(json.data.armada_id).trigger("change");
			$("#tanggal_jual").val(json.data.tanggal_jual);
			$("#gudang").val(json.data.gudang_id).trigger("change");

			$("#kategori_produk").val(json.data.kategori);
			$("#unit_produk").val(json.data.unit);
			$("#harga_jual").val(json.data.harga_jual_unit);
			$('#mata_uang_harga_jual').html(json.data.harga_jual_unit_rp);
			$("#jumlah").val(json.data.jumlah);
			$("#keterangan").val(json.data.keterangan);
			$("#infoTotalHargaJual").show(800);
			$("#totalHargaJual").val(json.data.harga_jual_total_rp);

		} else {
			$("#inputMessage").html(json.message);
			$("#nama_produk").val("").trigger("change");
			$("#nama_armada").val("").trigger("change");
			$("#tanggal_jual").val("");
			$("#gudang").val("").trigger("change");
			$("#kategori_produk").val("");
			$("#unit_produk").val("");
			$("#harga_jual").val("");
			$('#mata_uang_harga_jual').html("");
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
		url: '/transaksi/penjualan/inputForm',
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
						url = '/transaksi/penjualan/add';
					} else {
						url = '/transaksi/penjualan/update/'+idData;
					}*/
			    	if (result.value) {
				    	$.ajax({
								url: '/transaksi/penjualan/add',
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

	$.post("/transaksi/penjualan/getId/"+idData,function(json) {
		if (json.status == true) {

			var pesan = "<hr>";
				pesan += "<small style='color:orange'>Note: Menghapus data ini juga akan Menghapus data laporan gudang yang berhubungan dengan data yang anda pilih ini.!</small><hr>";
				pesan += "<li class='pull-left'><small>Tanggal Beli : <i>"+json.data.tanggal_jual_indo+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Kode Produk : <i>"+json.data.kode+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Nama Produk : <i>"+json.data.nama_produk+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Nama Armada : <i>"+json.data.nama+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Gudang : <i>"+json.data.nama_gudang+"</i></small></li><br>";
				// pesan += "<li class='pull-left'><small>Kategori : <i>"+json.data.kategori+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Unit : <i>"+json.data.unit+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Harga Jual : <i>"+json.data.harga_jual_unit_rp+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Jumlah : <i>"+json.data.jumlah+"</i></small></li><br>";
				pesan += "<li class='pull-left'><small>Harga Total : <i>"+json.data.harga_jual_total_rp+"</i></small></li><br>";

		    swal({   
		        title: "Apakah anda yakin.?",   
		        html: "<span style='color:red;'>Data yang di <b><u>Hapus</u></b> tidak bisa dikembalikan lagi.</span>"+pesan,
		        type: "warning", 
				// html: true,
  				showCloseButton: true,
		        showCancelButton: true,   
		        confirmButtonColor: "#DD6B55",   
		        confirmButtonText: "Iya, Hapus",
		    }).then((result) => {
		    	if (result.value) {
		    		$.post("/transaksi/penjualan/delete/"+idData,function(json) {
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
