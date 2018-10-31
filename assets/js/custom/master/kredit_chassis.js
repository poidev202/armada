$(document).ready(function() {
	
	$("#tblMasterKreditChassis").DataTable({
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
			url: '/master/kreditchassis/ajax_list',
			type: 'POST',
		},

		order:[[1,'DESC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'tanggal_bayar' },
			{ data:'nama' },
			{ data:'nama_vendor' },
			{ data:'merk' },
			{ data:'no_bk' },
			{ data:'angsuran_pokok' },
			{ data:'angsuran_bunga' },
			{ data:'jumlah_bayar' },
			{
				data:'button_action',
				searchable:false,
				orderable:false,
			}
		],
	});


	$("#tblStatusArmada").DataTable({
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
			url: '/master/kreditchassis/ajax_list_status_armada',
			type: 'POST',
		},

		order:[[1,'ASC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'nama' },
			{
				data:'photo',
				searchable:false,
				orderable:false,
			},
			{ data:'nama_vendor' },
			{ data:'merk' },
			{ data:'no_bk' },
			{ data:'lunas_chassis_rp' },
			{ data:'dp_chassis_rp' },
			{
				data:'total_bayar',
				searchable:false,
				orderable:false,
			},
			{
				data:'sisa_hutang',
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

	$("#tblRekapKreditChassis").DataTable({
		serverSide:true,
		responsive:true,
		processing:true,
		retrieve: true,
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
			url: '/master/kreditchassis/ajax_list/'+null,
			type: 'POST',
		},

		order:[[1,'DESC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'tanggal_bayar' },
			{ data:'angsuran_pokok' },
			{ data:'angsuran_bunga' },
			{ data:'jumlah_bayar' },
		],
		/*dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]*/

	});

});

function reloadTable() {
	$("#tblMasterKreditChassis").DataTable().ajax.reload(null,false);
	$("#tblStatusArmada").DataTable().ajax.reload(null,false);
}

/*Rekap kredit chassis*/
function rekapKredit(id) {
	idData = id;

	$("#modalDetail").modal("show");

	$.post("/master/armada/getId/"+idData,function (json) {

		if (json.status == true) {
			$("#namaArmadaRekap").html(json.data.nama);
			$("#noBkRekap").html(json.data.no_bk);
			$("#merkChassisRekap").html(json.data.merk);
			$("#vendorRekap").html(json.data.vendor_chassis);

			$("#totalRekapJumlahBayar").text(json.data.jumlah_bayar_chassis_rp);
			$("#totalRekapBayarDp").text(json.data.dp_chassis_rp);
			$("#totalRekapBayar").text(json.data.total_bayar_chassis_rp);

			var tableRekapKreditChassis = $("#tblRekapKreditChassis").DataTable();
			tableRekapKreditChassis.ajax.url("/master/kreditchassis/ajax_list/"+idData).load();
		} else {
			$("#namaArmadaRekap").html("");
			$("#noBkRekap").html("");
			$("#merkChassisRekap").html("");
			$("#vendorRekap").html("");

			$("#totalRekapJumlahBayar").text("");
			$("#totalRekapBayarDp").text("");
			$("#totalRekapBayar").text("");
		}

	});

}

$("#dataTable").show();
$("#formProses").hide();

$(".close-form").click(function() {
	$("#dataTable").show();
	$("#formProses").hide();
});

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
	
	$("#formData")[0].reset();
	$("#titleForm").text("Tambah Master Cicilan / Kredit Chassis");
	$("#ribbonTitle").removeClass("ribbon-success");
	$("#ribbonTitle").addClass("ribbon-info");

	$("#iconForm").addClass("fa-plus");
	$("#iconForm").removeClass("fa-pencil-square-o");

	$('#nama_armada').val("").trigger('change');
	$('#vendor_chassis').val("").trigger('change');
	$("#imgArmada").attr("src","/assets/images/default/no_image.jpg");

	$("#dataTable").hide();
	$("#formProses").show();

	$("#id_kredit").val("");

	$('#hasil_matauang_pokok').html("");
	$('#hasil_matauang_bunga').html("");
	$('#jumlah_bayar_int').val(0);

	idData = 0;
	save_method = "add";
});

$.post("/master/armada/getAll/chassis",function (json) {
	option = '<option value="">--Pilih Armada--</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.nama+'</option>';
	});

	$("#nama_armada").html(option);
});

/* master vendor */
$.post("/master/vendor/getAll",function(json) {
	var option;

	option = '<option value="">-- Pilih Vendor --</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.nama_vendor+'</option>';
	});

	$("#vendor_chassis").html(option);
});

var idArmada;
$("#nama_armada").change(function () {
	id_val = $("#nama_armada").val();
	if (id_val != "") {

		idArmada = id_val;
		id_kredit = $("#id_kredit").val();
		$.post("/master/armada/getId/"+idArmada+"/"+idData,function (json) {
			if (json.status == true) {

				$("#imgArmada").attr("src",json.data.photo);
				$("#no_bk").val(json.data.no_bk);
				$("#tahun").val(json.data.tahun);
				$("#merk").val(json.data.merk);
				$("#tipe").val(json.data.tipe);
				$("#bayar_lunas").val(json.data.lunas_chassis_rp);
				$("#bayar_dp").val(json.data.dp_chassis_rp);
				$("#total_bayar").val(json.data.total_bayar_chassis_rp);
				$("#sisa_hutang_rp").val(json.data.sisa_hutang_chassis_rp);
				$("#sisa_hutang").val(json.data.sisa_hutang_chassis);

				$("#bayar_lunas_int").val(json.data.lunas_chassis);
				$("#total_bayar_int").val(json.data.total_bayar_chassis);

				var total_bayar_int = $("#total_bayar_int").val();
				var bayar_lunas_int = $("#bayar_lunas_int").val();

				total_bayar_int = total_bayar_int == false ? 0 : total_bayar_int;
				bayar_lunas_int = bayar_lunas_int == false ? 0 : bayar_lunas_int;

				var estimasi_total_bayar = parseInt($('#jumlah_bayar_int').val()) + parseInt(total_bayar_int);
				var estimasi_sisa_hutang = parseInt(bayar_lunas_int) - estimasi_total_bayar; 

				if ($("#jumlah_bayar_int").val() != 0) {
					$("#estimasi_total_bayar").val(moneyFormat.to( parseInt( estimasi_total_bayar)) );
					$("#estimasi_sisa_hutang").val(moneyFormat.to( parseInt( estimasi_sisa_hutang)) );
				} else {
					$("#estimasi_total_bayar").val("");
					$("#estimasi_sisa_hutang").val("");
				}
			} else {
				$("#errorNamaArmada").html(json.message);
			}

		});
	} else {

		$("#imgArmada").attr("src","/assets/images/default/no_image.jpg");
		$("#no_bk").val("");
		$("#tahun").val("");
		$("#merk").val("");
		$("#tipe").val("");
		$("#bayar_lunas").val("");
		$("#bayar_dp").val("");
		$("#total_bayar").val("");
		$("#sisa_hutang_rp").val("");
		$("#sisa_hutang").val("");

		$("#bayar_lunas_int").val("");
		$("#total_bayar_int").val("");

		$("#estimasi_total_bayar").val("");
		$("#estimasi_sisa_hutang").val("");
	}
});

$(document).ready(function () {

	var pokok = $("#angsuran_pokok").val();
	var bunga = $("#angsuran_bunga").val();

	var jumlah_bayar = (pokok + bunga);

    $('#angsuran_pokok').on('input', function() {
        $('#hasil_matauang_pokok').html( moneyFormat.to( parseInt($(this).val()) ) );
    });

    $('#angsuran_bunga').on('input', function() {
        $('#hasil_matauang_bunga').html( moneyFormat.to( parseInt($(this).val()) ) );
    });
}); 

$("#angsuran_pokok, #angsuran_bunga").keyup(function() {
	var pokok = $("#angsuran_pokok").val();
	var bunga = $("#angsuran_bunga").val();

	pokok = pokok == false ? 0 : pokok;
	bunga = bunga == false ? 0 : bunga;

	var jumlah_bayar = parseInt(pokok) + parseInt(bunga);

	$('#jumlah_bayar').val( moneyFormat.to( parseInt( jumlah_bayar)) );
	$('#jumlah_bayar_int').val(jumlah_bayar);

	var total_bayar_int = $("#total_bayar_int").val();
	var bayar_lunas_int = $("#bayar_lunas_int").val();

	total_bayar_int = total_bayar_int == false ? 0 : total_bayar_int;
	bayar_lunas_int = bayar_lunas_int == false ? 0 : bayar_lunas_int;

	var estimasi_total_bayar = jumlah_bayar + parseInt(total_bayar_int);
	var estimasi_sisa_hutang = parseInt(bayar_lunas_int) - estimasi_total_bayar; 

	if ($("#jumlah_bayar_int").val() != 0) {
		$("#estimasi_total_bayar").val(moneyFormat.to( parseInt( estimasi_total_bayar)) );
		$("#estimasi_sisa_hutang").val(moneyFormat.to( parseInt( estimasi_sisa_hutang)) );
	} else {
		$("#estimasi_total_bayar").val("");
		$("#estimasi_sisa_hutang").val("");
	}

	if (jumlah_bayar > $("#sisa_hutang").val()) {
		swal({   
	            title: "Error Form.!",   
	            html: "<span style='color:red;'>Sisa hutang tidak boleh minus. <br> "+$("#estimasi_sisa_hutang").val()+"</span>",
	            type: "warning",
	        });

		$("#angsuran_pokok").val("");
		$("#angsuran_bunga").val("");
	}
});

function editKredit(id) {
	idData = id;
	$("#titleForm").text("Update Master Cicilan / Kredit Chassis");
	$("#ribbonTitle").removeClass("ribbon-info");
	$("#ribbonTitle").addClass("ribbon-success");

	$("#iconForm").removeClass("fa-plus");
	$("#iconForm").addClass("fa-pencil-square-o");

	$("#dataTable").hide();
	$("#formProses").show();
	var total_bayar_int = $("#total_bayar_int").val();

	$.post("/master/kreditchassis/getId/"+idData,function(json) {
		if (json.status == true) {
			$('#nama_armada').val(json.data.master_armada_id).trigger('change');
			$("#imgArmada").attr("src",json.data.photo);

			$('#vendor_chassis').val(json.data.master_vendor_id).trigger('change');
			$("#tanggal_bayar").val(json.data.tanggal_bayar);
			$("#angsuran_pokok").val(json.data.angsuran_pokok);
			$("#angsuran_bunga").val(json.data.angsuran_bunga);
			$("#hasil_matauang_pokok").html(json.data.angsuran_pokok_rp);
			$("#hasil_matauang_bunga").html(json.data.angsuran_bunga_rp);
			$('#jumlah_bayar').val(json.data.jumlah_bayar_rp);
			$('#jumlah_bayar_int').val(0);

			$("#total_bayar_int").val(json.data.jumlah_bayar);

			$("#id_kredit").val(idData);

		} else {
			$("#inputMessage").html(json.message);
			$("#imgArmada").attr("src","/assets/images/default/no_image.jpg");
			$('#nama_armada').val("").trigger('change');
			$('#vendor_chassis').val("").trigger('change');
			$("#tanggal_bayar").val("");
			$("#angsuran_pokok").val("");
			$("#angsuran_bunga").val("");
			$('#jumlah_bayar').val("");
			$('#jumlah_bayar_int').val(0);

			$("#id_kredit").val("");

			setTimeout(function() {
				reloadTable();
				$("#dataTable").show();
				$("#formProses").hide();
				$("#inputMessage").html("");
			},1000);
		}
	});

	save_method = "update";
}

$("#btnSimpan").click(function() {
	var url;
	if (save_method == "add") {
		url = '/master/kreditchassis/add';
	} else {
		url = '/master/kreditchassis/update/'+idData;
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
			            // html: true,
			            timer: 2000,   
			            showConfirmButton: false 
			        });

				setTimeout(function() {
					$("#formData")[0].reset();
					$("#dataTable").show();
					$("#formProses").hide();
					$('#jumlah_bayar_int').val(0);
					
					$("#inputMessage").html("");
					reloadTable();
				}, 1500);
			} else {
				$("#errorNamaArmada").html(json.error.nama_armada);
				$("#errorTanggalBayar").html(json.error.tanggal_bayar);
				$("#errorAngsuranPokok").html(json.error.angsuran_pokok);
				$("#errorAngsuranBunga").html(json.error.angsuran_bunga);

				swal({   
			            title: "Error Form.!",   
			            html: json.message,
			            type: "error",
			            // html: true
			        });

				setTimeout(function() {
					$("#errorNamaArmada").html("");
					$("#errorTanggalBayar").html("");
					$("#errorAngsuranPokok").html("");
					$("#errorAngsuranBunga").html("");
				},3000);
			}
		}
	});
});

function btnDelete(id) {
	idData = id;

	$.post("/master/kreditchassis/getId/"+idData,function(json) {
		if (json.status == true) {
			var pesan = "<hr> <div class='row'>";
				pesan += "<div class='col-md-8'>";
				pesan += "<li class='pull-left'><small>Tanggal Bayar : <i>"+json.data.tanggal_bayar_indo+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Nama Armada : <i>"+json.data.nama+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Merk : <i>"+json.data.merk+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>No BK / Plat : <i>"+json.data.no_bk+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Angsuran Pokok : <i>"+json.data.angsuran_pokok_rp+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Angsuran Bunga : <i>"+json.data.angsuran_bunga_rp+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Jumlah Bayar : <i>"+json.data.jumlah_bayar_rp+"</small></i></li><br>";
				pesan += "</div>";
				pesan += "<div class='col-md-4'>";
				pesan += "<label>Photo Armada :</label><br>";
				pesan += "<img src='"+json.data.photo+"' alt='Photo Armada' class='img img-responsive' style='width:100px; height:80px;'><br>";
				pesan += "</div>";
				pesan += "</div>";
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
			    	$.post("/master/kreditchassis/delete/"+idData,function(json) {
						if (json.status == true) {
							swal({    
						            title: json.message,
						            type: "success",
						            // html: true,
						            timer: 2000,   
						            showConfirmButton: false 
						        });
							reloadTable();
						} else {
							swal({    
						            title: json.message,
						            type: "error",
						            // html: true,
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
		            // html: true,
		            timer: 1000,   
		            showConfirmButton: false 
		        });
		}
	});
}

