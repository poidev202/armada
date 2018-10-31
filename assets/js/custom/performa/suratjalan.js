/* INGAT YA BATAS HAPUS:*/
/* for armada */
armadaAll(); // show armada all in select2
function armadaAll() {
	$.post("/performa/armadastatus/armadaStandBy",function (json) {
		option = '<option value="">--Pilih Armada--</option>';
		$.each(json.data,function(i,v) {
			option += '<option value="'+v.armada_id+'">'+v.nama+'</option>';
		});
		$("#nama_armada").html(option);
	});
}

$("#btnRefreshArmada").click(function() {
	$("#btnRefreshArmada").children().addClass("fa-spin");
	setTimeout(function(){
		armadaAll();
	  	$("#btnRefreshArmada").children().removeClass("fa-spin");
	  	$("#imgArmada").attr("src","/assets/images/default/no_image.jpg");
		$("#imgArmadaPopup").attr("href","/assets/images/default/no_image.jpg");
		$("#no_bk").val("");
		$("#tahun").val("");
	}, 800);
});

var idArmada;
$("#nama_armada").change(function () {
	id_val = $("#nama_armada").val();
	if (id_val != "") {
		idArmada = id_val;
		$.post("/master/armada/getId/"+idArmada,function (json) {
			if (json.status == true) {
				$("#imgArmada").attr("src",json.data.photo);
				$("#imgArmadaPopup").attr("href",json.data.photo);
				$("#no_bk").val(json.data.no_bk);
				$("#tahun").val(json.data.tahun);
			} else {
				$("#errorNamaArmada").html(json.message);
			}
		});		
	} else {
		$("#imgArmada").attr("src","/assets/images/default/no_image.jpg");
		$("#imgArmadaPopup").attr("href","/assets/images/default/no_image.jpg");
		$("#no_bk").val("");
		$("#tahun").val("");
	}
});

/* for Supir  */
$.post("/master/karyawan/getAllSupir",function (json) {
	option = '<option value="">--Pilih Supir 1--</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.nama+'</option>';
	});

	$("#supir1").html(option);
});

$("#supir1").change(function() {
	idSupir1 = $(this).val();
	if (idSupir1 != "") {
		$.post("/master/karyawan/getSupir/"+idSupir1,function (json) {
			$("#imgSupir1").attr("src",json.data.foto_karyawan);
			$("#imgSupir1Popup").attr("href",json.data.foto_karyawan);
			$("#nama_supir1").val(json.data.nama);
			$("#kode_supir1").val(json.data.kode);
		});
	} else {
		$("#imgSupir1").attr("src","/assets/images/default/user_image.png");
		$("#imgSupir1Popup").attr("href","/assets/images/default/user_image.png");
		$("#nama_supir1").val("");
		$("#kode_supir1").val("");
	}
});

$.post("/master/karyawan/getAllSupir",function (json) {
	option = '<option value="">--Pilih Supir 2--</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.nama+'</option>';
	});

	$("#supir2").html(option);
});

$("#supir2").change(function() {
	idSupir2 = $(this).val();
	if (idSupir2 != "") {
		$.post("/master/karyawan/getSupir/"+idSupir2,function (json) {
			$("#imgSupir2").attr("src",json.data.foto_karyawan);
			$("#imgSupir2Popup").attr("href",json.data.foto_karyawan);
			$("#nama_supir2").val(json.data.nama);
			$("#kode_supir2").val(json.data.kode);
		});
	} else {
		$("#imgSupir2").attr("src","/assets/images/default/user_image.png");
		$("#imgSupir2Popup").attr("href","/assets/images/default/user_image.png");
		$("#nama_supir2").val("");
		$("#kode_supir2").val("");
	}
});

$("#supir1, #supir2").change(function() {
	supir1 = $("#supir1").val();
	supir2 = $("#supir2").val();

	if (supir1 != "" && supir2 != "") {
		if (supir1 == supir2) {
			// alert("duplicate supir");
			swal({   
		            title: "Duplicate Data Supir.!",   
		            html: "Supir 1 dan Supir 2 .!!",
		            type: "warning",
		        });
		}
	}
})

/*end for supir*/

/* for Hari jadwal */
$.post("/master/jadwal/hariAll",function (json) {
	option = '<option value="">--Pilih Hari--</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.hari+'">'+v.hari_b+'</option>';
	});

	$("#hari").html(option);
});

$("#hari").change(function() {
	hari = $(this).val();
	if (hari != "") {
		$.post("/master/jadwal/jamPerHari/"+hari,function (json) {
			option = '<option value="">--Pilih Jam--</option>';
			$.each(json.data,function(i,v) {
				option += '<option value="'+v.id+'">'+v.jam+'</option>';
			});

			$("#jam").html(option);
			$("#berangkat").val("");
			$("#tujuan").val("");
		});
	} else {
		$("#jam").html("");
		$("#berangkat").val("");
		$("#tujuan").val("");
	}
});

$("#jam").change(function() {
	idJam = $(this).val();
	if (idJam != "") {
		$.post("/master/jadwal/tujuanPerJam/"+idJam,function (json) {
			$("#berangkat").val(json.data.tujuan_awal);
			$("#tujuan").val(json.data.tujuan_akhir);
		});
	} else {
		$("#berangkat").val("");
		$("#tujuan").val("");
	}
});
/* INGAT YA BATAS HAPUS:*/

$(document).ready(function() {
	btnRefresh = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-success btn-sm' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button>";

	$("#tblSuratJalan").DataTable({
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
			url: '/performa/suratjalan/ajax_list',
			type: 'POST',
		},

		order:[[1,'DESC']],
		columns:[
			{
				data:'no',
				searchable:false,
				orderable:false,
			},
			{ data:'tanggal' },
			{ data:'nama' },
			{ data:'no_bk' },
			// { data:'kode_supir1' },
			{ data:'nama_supir1' },
			// { data:'kode_supir2' },
			{ data:'nama_supir2' },
			{ data:'hari' },
			{ data:'jam' },
			{ data:'tujuan_awal' },
			{ data:'tujuan_akhir' },
			/*{
				data:'button_action',
				searchable:false,
				orderable:false,
			},*/
		],
	});
});

function reloadTable() {
	$("#tblSuratJalan").DataTable().ajax.reload(null,false);
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

$("#btnSimpanTrip").click(function() {
	$.ajax({
		url: '/performa/suratjalan/checkTrip',
		type:'POST',
		data:$("#formData").serialize(),
		dataType:'JSON',
		success: function(json) {
			if (json.status == true) {
				swal({   
			        title: "Apakah anda yakin.?",   
			        html: "<span style='color:red;'>Data yang di <b><u>Input</u></b> tidak bisa di edit/update lagi.<br>Pastikan anda menginput dengan benar.!</span>",
			        type: "info", 
					showCloseButton: true,
			        showCancelButton: true,   
			        confirmButtonColor: "#1976d2",   
			        confirmButtonText: "Iya, Simpan", 
			    }).then((result) => {
			    	if (result.value) {
			    		$.ajax({
							url: '/performa/suratjalan/saveTrip',
							type:'POST',
							data:$("#formData").serialize(),
							dataType:'JSON',
							success: function(json) {
								if (json.status == true) {
									swal({    
								            title: json.message,
								            type: "success",
								            timer: 3000,   
								            showConfirmButton: false 
								        });
									// btnDetail(json.data.id);

									setTimeout(function() {
										$("#formData")[0].reset();
										$("#dataTableTrip").hide(800);
										reloadTable();
									}, 2000);
									
								} else {
									swal({   
								            title: "Error Form.!",   
								            html: json.message,
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

/* INGAT YA BATAS HAPUS:*/
$("#btnProses").click(function() {
	/*buat peringatan input seperti input pendapatan armada dan supir*/
	$.ajax({
		url: '/performa/suratjalan/checkProses',
		type:'POST',
		data:$("#formData").serialize(),
		dataType:'JSON',
		success: function(json) {
			if (json.status == true) {
				swal({   
			        title: "Apakah anda yakin.?",   
			        html: "<span style='color:red;'>Data yang di <b><u>Input</u></b> tidak bisa di edit/update lagi.<br>Pastikan anda menginput dengan benar.!</span>",
			        type: "info", 
					showCloseButton: true,
			        showCancelButton: true,   
			        confirmButtonColor: "#1976d2",   
			        confirmButtonText: "Iya, Simpan", 
			    }).then((result) => {
			    	if (result.value) {
			    		$.ajax({
							url: '/performa/suratjalan/inputSuratJalan',
							type:'POST',
							data:$("#formData").serialize(),
							dataType:'JSON',
							success: function(json) {
								if (json.status == true) {
									swal({    
								            title: json.message,
								            type: "success",
								            timer: 2000,   
								            showConfirmButton: false 
								        });
									btnDetail(json.data.id);

									setTimeout(function() {
										$("#formData")[0].reset();
										$("#nama_armada").val("").trigger("change");
										$("#imgArmada").attr("src","/assets/images/default/no_image.jpg");
										$("#imgArmadaPopup").attr("href","/assets/images/default/no_image.jpg");

										$("#supir1").val("").trigger("change");
										$("#imgSupir1").attr("src","/assets/images/default/user_image.png");
										$("#imgSupir1Popup").attr("href","/assets/images/default/user_image.png");

										$("#supir2").val("").trigger("change");
										$("#imgSupir2").attr("src","/assets/images/default/user_image.png");
										$("#imgSupir2Popup").attr("href","/assets/images/default/user_image.png");

										$("#hari").val("").trigger("change");
										$("#jam").val("").trigger("change");

										reloadTable();
									}, 1500);
									
								} else {
									swal({   
								            title: "Error Form.!",   
								            html: json.message,
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
/* INGAT YA BATAS HAPUS:*/

$(".close-surat").click(function() {
	$("#formulirTable").show(800);
	$("#formulirPrintSurat").hide(800);
});

function getNamaPerusahaan() {
	$.post("/umum/getIdUmum",function(json) {
	    if (json.status == true) {
	        $(".nama-perusahaan").html(json.data.nama_perusahaan);
	    }
	});
}
	
function btnDetail(id) {
	idData = id;
	$.post("/performa/suratjalan/getId/"+idData,function(json) {
		if (json.status == true) {

			getNamaPerusahaan();

			$("#formulirTable").hide(800);
			$("#formulirPrintSurat").show(800);

			$("#printTanggal").html(json.data.tanggal);
			$("#printNamaArmada").html(json.data.nama);
			$("#printNoPlat").html(json.data.no_bk);
			$("#printKodeSupir1").html(json.data.kode_supir1);
			$("#printNamaSupir1").html(json.data.nama_supir1);
			$("#printKodeSupir2").html(json.data.kode_supir2);
			$("#printNamaSupir2").html(json.data.nama_supir2);
			$("#printHari").html(json.data.hari);
			$("#printJam").html(json.data.jam);
			$("#printBerangkat").html(json.data.tujuan_awal);
			$("#printTujuanAkhir").html(json.data.tujuan_akhir);
			$("#printPenanggungJawab").html(json.data.penanggung_jawab);
		} else {
			swal({    
		            title: json.message,
		            type: "error",
		            timer: 2000,   
		            showConfirmButton: false 
		        });
		}
	});
}

$("#tgl_hari_jadwal").change(function() {
	$("#dataTableTrip").hide(800);
});

$("#btnCloseTrip").click(function() {
	$("#tgl_hari_jadwal").val("");
	$("#dataTableTrip").hide(800);
});

/*for print*/
$("#btnCheckDataPrint").click(function() {
	var valTgl = $("#tgl_trip_print").val();
    var url = "";
    if (valTgl != "") {
        url = "/performa/suratjalan/dataPrintTrip/"+valTgl;
    } else {
        url = "/performa/suratjalan/dataPrintTrip";
    }
	$.post(url,function(resp) {
		if (resp.status == true) {
			$("#hariPrintTglTrip").html(resp.hari_tglTrip);
			$("#trPrintTrip").html(resp.data);
			$("#dataPrintTrip").show(700);
			$("#errorPrintTrip").html("");
		} else {
			$("#dataPrintTrip").hide(700);
			$("#errorPrintTrip").html(resp.message);
			setTimeout(() => {
			 	$("#errorPrintTrip").html("");
			}, 4000);

			/*swal({   
		            title: "Error Form.!",   
		            html: json.message,
		            type: "error",
		        });*/
		}
	});
});

$("#tgl_trip_print").change(function() {
	$("#dataPrintTrip").hide(800);
});

$(document).ready(function() {
    $(".btn-print-trip").click(function() {
        var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = {
            mode: mode,
            popClose: close
        };
        $("div.printableAreaTrip").printArea(options);
    });
});

$("#btnPrintCloseTrip").click(function() {
	$("#tgl_trip_print").val("");
	$("#dataPrintTrip").hide(800);
});

