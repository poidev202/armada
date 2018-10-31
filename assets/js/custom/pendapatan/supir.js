$(document).ready(function() {
	btnTambah1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-primary btn-sm' id='btnTambah1'><i class='fa fa-plus'></i> Input Pendapatan Supir 1</button>";

	$("#tblSupir1").DataTable({
		serverSide:true,
		responsive:true,
		processing:false,
		oLanguage: {
            sZeroRecords: "<center>Data tidak ditemukan</center>",
            sLengthMenu: "Tampilkan _MENU_ data   "+btnTambah1,
            sSearch: "Cari data:",
            sInfo: "Menampilkan: _START_ - _END_ dari total: _TOTAL_ data",                                   
            oPaginate: {
                sFirst: "Awal", "sPrevious": "Sebelumnya",
                sNext: "Selanjutnya", "sLast": "Akhir"
            },
        },
		//load data
		ajax: {
			url: '/pendapatan/supir/ajax_list/1',
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
			{ data:'kode_supir1' },
			{ data:'nama_supir1' },
			{ data:'nama' },
			{ data:'no_bk' },
			{ data:'tanggal' },
			{ data:'hari' },
			{ data:'jam' },
			{ data:'tujuan_awal' },
			{ data:'tujuan_akhir' },
			{ data:'uang_pendapatan' },
			/*{
				data:'button_action',
				searchable:false,
				orderable:false,
			},*/
		],
	});
});

$(document).ready(function() {
	btnTambah2 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-inverse btn-sm' id='btnTambah2'><i class='fa fa-plus'></i> Input Pendapatan Supir 2</button>";

	$("#tblSupir2").DataTable({
		serverSide:true,
		responsive:true,
		processing:false,
		oLanguage: {
            sZeroRecords: "<center>Data tidak ditemukan</center>",
            sLengthMenu: "Tampilkan _MENU_ data   "+btnTambah2,
            sSearch: "Cari data:",
            sInfo: "Menampilkan: _START_ - _END_ dari total: _TOTAL_ data",                                   
            oPaginate: {
                sFirst: "Awal", "sPrevious": "Sebelumnya",
                sNext: "Selanjutnya", "sLast": "Akhir"
            },
        },
		//load data
		ajax: {
			url: '/pendapatan/supir/ajax_list/2',
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
			{ data:'kode_supir2' },
			{ data:'nama_supir2' },
			{ data:'nama' },
			{ data:'no_bk' },
			{ data:'tanggal' },
			{ data:'hari' },
			{ data:'jam' },
			{ data:'tujuan_awal' },
			{ data:'tujuan_akhir' },
			{ data:'uang_pendapatan' },
			/*{
				data:'button_action',
				searchable:false,
				orderable:false,
			},*/
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

$(document).on('click', '#btnTambah1', function(e) {
	e.preventDefault();
	$("#dataTableSupir1").hide(500);
	$("#formProsesSupir1").show(500);
	$("#formData1")[0].reset();

	$("#supir1").val("").trigger("change");
	$("#imgSupir1").attr("src","/assets/images/default/user_image.png");
	$("#imgSupir1Popup").attr("href","/assets/images/default/user_image.png");
	$("#nama_armada1").val("").trigger("change");
	$("#imgArmada1").attr("src","/assets/images/default/no_image.jpg");
	$("#imgArmada1Popup").attr("href","/assets/images/default/no_image.jpg");
	$("#tgl_surat_jalan1").val("").trigger("change");
	$("#mata_uang_pendapatan1").html("");
});

$(".close-form-supir1").click(function() {
	$("#formProsesSupir1").hide(500);
	$("#dataTableSupir1").show(500);
});

/* for proses form input pendapatan supir 1 */
$.post("/performa/suratjalan/getAllSupir1",function(json) {
	if (json.status == true) {
		var option = "<option value=''>--Pilih Supir 1--</option>";
		$.each(json.data,function(i,v) {

			var value = v.kode_supir1+"||"+v.nama_supir1;
			option += "<option value='"+value+"'>"+v.nama_supir1+"</option>";
		});
		$("#supir1").html(option);
	}
});

$("#supir1").change(function() {
	valueSupir1 = $(this).val();
	if (valueSupir1 != "") {
		var valArr = valueSupir1.split("||");
		// alert(valArr[0]);
		$.post("/master/karyawan/getByWhereSupir/"+valArr[0],function(json) {
			if (json.status == true) {
				$("#kode_supir1").val(json.data.kode);
				$("#imgSupir1").attr("src",json.data.foto_karyawan);
				$("#imgSupir1Popup").attr("href",json.data.foto_karyawan);
			} else {
				$("#kode_supir1").val("");
				$("#imgSupir1").attr("src","/assets/images/default/user_image.png");
				$("#imgSupir1Popup").attr("href","/assets/images/default/user_image.png");
			}
		});

		var option = "";
		$.post("/performa/suratjalan/getAllArmadaSupir/"+valArr[0]+"/supir1",function (json) {
			option = '<option value="">--Pilih Armada--</option>';
			$.each(json.data,function(i,v) {
				option += '<option value="'+v.armada_id+'">'+v.nama+'</option>';
			});
			$("#nama_armada1").html(option);
		});
		/*clear armada attribut*/
		clearArmadaAttr();
		$("#tgl_surat_jalan1").html("");
		$("#berangkat1").val("");
		$("#tujuan1").val("");
		$("#penanggung_jawab1").val("");
	} else {
		$("#kode_supir1").val("");
		$("#imgSupir1").attr("src","/assets/images/default/user_image.png");
		$("#imgSupir1Popup").attr("href","/assets/images/default/user_image.png");
		$("#nama_armada1").html("");
		/*clear armada attribut*/
		clearArmadaAttr();
		$("#tgl_surat_jalan1").html("");
		$("#berangkat1").val("");
		$("#tujuan1").val("");
		$("#penanggung_jawab1").val("");
	}
});

$("#nama_armada1").change(function () {
	id_val = $(this).val();
	if ($("#nama_armada1").val() != null) {
		$.post("/master/armada/getId/"+id_val,function (json) {
			if (json.status == true) {
				$("#imgArmada1").attr("src",json.data.photo);
				$("#imgArmada1Popup").attr("href",json.data.photo);
				$("#no_bk1").val(json.data.no_bk);
				$("#tahun1").val(json.data.tahun);
			} else {
				$("#errorNamaArmada").html(json.message);
			}
		});
		valueSupir1 = $("#supir1").val();
		var valArr = valueSupir1.split("||");
		$.post("/performa/suratjalan/getAllJadwalTanggalArmadaSupir/"+id_val+"/"+valArr[0]+"/supir1",function(json) {
			var option = '<option value="">--Pilih Tanggal Surat Jalan--</option>';
			if (json.data.length > 0) {
				// alert(json.data+" ada data");
				$.each(json.data,function(i,v) {
					// var val = v.id+"||"+v.jadwal_id;
					var seeVal = v.tanggal_indo+", hari="+v.hari+", jam="+v.jam;
					option += '<option value="'+v.id+'">'+seeVal+'</option>';
				});
				$("#errorTglSuratJalan1").html("");
			} else {
				// alert(json.data+" Gak ada data");
				option = "";
				$("#errorTglSuratJalan1").html("<span style='color:red'>Tidak ada jadwal keberangkatan</span>");
			}
			$("#tgl_surat_jalan1").html(option);
		});
		$("#berangkat1").val("");
		$("#tujuan1").val("");
		$("#penanggung_jawab1").val("");
	} else {
		/*clear armada attribut*/
		clearArmadaAttr();
		$("#tgl_surat_jalan1").html("");
		$("#berangkat1").val("");
		$("#tujuan1").val("");
		$("#penanggung_jawab1").val("");
	}
});

function clearArmadaAttr() {
	$("#imgArmada1").attr("src","/assets/images/default/no_image.jpg");
	$("#imgArmada1Popup").attr("href","/assets/images/default/no_image.jpg");
	$("#no_bk1").val("");
	$("#tahun1").val("");
}

$("#tgl_surat_jalan1").change(function() {
	var val = $(this).val();
	if (val != "") {
		$.post("/performa/suratjalan/getId/"+val, function(json) {
			$("#berangkat1").val(json.data.tujuan_awal);
			$("#tujuan1").val(json.data.tujuan_akhir);
			$("#penanggung_jawab1").val(json.data.penanggung_jawab);
		});
	} else {
		$("#berangkat1").val("");
		$("#tujuan1").val("");
		$("#penanggung_jawab1").val("");
	}
});

$("#uang_pendapatan1").keyup(function() {
	$("#mata_uang_pendapatan1").html( moneyFormat.to(parseInt($(this).val())) );
});

$("#btnInput1").click(function () {
	
	$.ajax({
		url: '/pendapatan/supir/inputFormSupir1',
		type:'POST',
		data:$("#formData1").serialize(),
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
			        closeOnConfirm: false 
			    }).then((result) => {
			    	if (result.value) {
			    		$.ajax({
							url: '/pendapatan/supir/insertPendapatanSupir1',
							type:'POST',
							data:$("#formData1").serialize(),
							dataType:'JSON',
							success: function(json) {
								if (json.status == true) {
									swal({    
								            title: json.message,
								            type: "success",
								            timer: 2000,   
								            showConfirmButton: false 
								        });

									setTimeout(function() {
										$("#formData1")[0].reset();
										$("#formProsesSupir1").hide(800);
										$("#dataTableSupir1").show(800);
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
/* end for proses form input pendapatan supir 1 */


$(document).on('click', '#btnTambah2', function(e) {
	e.preventDefault();
	$("#dataTableSupir2").hide(500);
	$("#formProsesSupir2").show(500);
	$("#formData2")[0].reset();

	$("#supir2").val("").trigger("change");
	$("#imgSupir2").attr("src","/assets/images/default/user_image.png");
	$("#imgSupir2Popup").attr("href","/assets/images/default/user_image.png");
	$("#nama_armada2").val("").trigger("change");
	$("#imgArmada2").attr("src","/assets/images/default/no_image.jpg");
	$("#imgArmada2Popup").attr("href","/assets/images/default/no_image.jpg");
	$("#tgl_surat_jalan2").val("").trigger("change");
	$("#mata_uang_pendapatan2").html("");
});

$(".close-form-supir2").click(function() {
	$("#formProsesSupir2").hide(500);
	$("#dataTableSupir2").show(500);
});

/* for proses form input pendapatan supir 2 */
$.post("/performa/suratjalan/getAllSupir2",function(json) {
	if (json.status == true) {
		var option = "<option value=''>--Pilih Supir 2--</option>";
		$.each(json.data,function(i,v) {

			var value = v.kode_supir2;
			option += "<option value='"+value+"'>"+v.nama_supir2+"</option>";
		});
		$("#supir2").html(option);
	}
});

$("#supir2").change(function() {
	valueSupir2 = $(this).val();
	if (valueSupir2 != "") {

		$.post("/master/karyawan/getByWhereSupir/"+valueSupir2,function(json) {
			if (json.status == true) {
				$("#kode_supir2").val(json.data.kode);
				$("#imgSupir2").attr("src",json.data.foto_karyawan);
				$("#imgSupir2Popup").attr("href",json.data.foto_karyawan);
			} else {
				$("#kode_supir2").val("");
				$("#imgSupir2").attr("src","/assets/images/default/user_image.png");
				$("#imgSupir2Popup").attr("href","/assets/images/default/user_image.png");
			}
		});

		var option = "";
		$.post("/performa/suratjalan/getAllArmadaSupir/"+valueSupir2+"/supir2",function (json) {
			option = '<option value="">--Pilih Armada--</option>';
			$.each(json.data,function(i,v) {
				option += '<option value="'+v.armada_id+'">'+v.nama+'</option>';
			});
			$("#nama_armada2").html(option);
		});
		/*clear armada attribut*/
		clearArmadaAttr2();
		$("#tgl_surat_jalan2").html("");
		$("#berangkat2").val("");
		$("#tujuan2").val("");
		$("#penanggung_jawab2").val("");
	} else {
		$("#kode_supir2").val("");
		$("#imgSupir2").attr("src","/assets/images/default/user_image.png");
		$("#imgSupir2Popup").attr("href","/assets/images/default/user_image.png");
		$("#nama_armada2").html("");
		/*clear armada attribut*/
		clearArmadaAttr2();
		$("#tgl_surat_jalan2").html("");
		$("#berangkat2").val("");
		$("#tujuan2").val("");
		$("#penanggung_jawab2").val("");
	}
});

$("#nama_armada2").change(function () {
	id_val = $(this).val();
	if ($("#nama_armada2").val() != null) {
		$.post("/master/armada/getId/"+id_val,function (json) {
			if (json.status == true) {
				$("#imgArmada2").attr("src",json.data.photo);
				$("#imgArmada2Popup").attr("href",json.data.photo);
				$("#no_bk2").val(json.data.no_bk);
				$("#tahun2").val(json.data.tahun);
			} else {
				$("#errorNamaArmada").html(json.message);
			}
		});
		valueSupir2 = $("#supir2").val();
		var valArr = valueSupir2.split("||");
		$.post("/performa/suratjalan/getAllJadwalTanggalArmadaSupir/"+id_val+"/"+valArr[0]+"/supir2",function(json) {
			var option = '<option value="">--Pilih Tanggal Surat Jalan--</option>';
			$.each(json.data,function(i,v) {
				// var val = v.id+"||"+v.jadwal_id;
				var seeVal = v.tanggal_indo+", hari="+v.hari+", jam="+v.jam;
				option += '<option value="'+v.id+'">'+seeVal+'</option>';
			});
			$("#tgl_surat_jalan2").html(option);
		});
		$("#berangkat2").val("");
		$("#tujuan2").val("");
		$("#penanggung_jawab2").val("");
	} else {
		/*clear armada attribut*/
		clearArmadaAttr2();
		$("#tgl_surat_jalan2").html("");
		$("#berangkat2").val("");
		$("#tujuan2").val("");
		$("#penanggung_jawab2").val("");
	}
});

function clearArmadaAttr2() {
	$("#imgArmada2").attr("src","/assets/images/default/no_image.jpg");
	$("#imgArmada2Popup").attr("href","/assets/images/default/no_image.jpg");
	$("#no_bk2").val("");
	$("#tahun2").val("");
}

$("#tgl_surat_jalan2").change(function() {
	var val = $(this).val();
	if (val != "") {
		$.post("/performa/suratjalan/getId/"+val, function(json) {
			$("#berangkat2").val(json.data.tujuan_awal);
			$("#tujuan2").val(json.data.tujuan_akhir);
			$("#penanggung_jawab2").val(json.data.penanggung_jawab);
		});
	} else {
		$("#berangkat2").val("");
		$("#tujuan2").val("");
		$("#penanggung_jawab2").val("");
	}
});

$("#uang_pendapatan2").keyup(function() {
	$("#mata_uang_pendapatan2").html( moneyFormat.to(parseInt($(this).val())) );
});

$("#btnInput2").click(function () {
	
	$.ajax({
		url: '/pendapatan/supir/inputFormSupir2',
		type:'POST',
		data:$("#formData2").serialize(),
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
			        closeOnConfirm: false 
			    }).then((result) => {
			    	if (result.value) {
			    		$.ajax({
							url: '/pendapatan/supir/insertPendapatanSupir2',
							type:'POST',
							data:$("#formData2").serialize(),
							dataType:'JSON',
							success: function(json) {
								if (json.status == true) {
									swal({    
								            title: json.message,
								            type: "success",
								            timer: 2000,   
								            showConfirmButton: false 
								        });

									setTimeout(function() {
										$("#formData2")[0].reset();
										$("#formProsesSupir2").hide(800);
										$("#dataTableSupir2").show(800);
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
/* end for proses form input pendapatan supir 1 */