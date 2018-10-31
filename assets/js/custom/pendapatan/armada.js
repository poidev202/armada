$(document).ready(function() {
	// btnTambah = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-primary btn-sm' id='btnTambah'><i class='fa fa-plus'></i> Input Pendapatan Armada</button>";
	btnRefresh = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-success btn-sm' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button>";

	$("#tblPendapatanArmada").DataTable({
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
			url: '/pendapatan/armada/ajax_list',
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
			{ data:'nama' },
			{ data:'no_bk' },
			{ data:'hari' },
			{ data:'jam' },
			{ data:'tujuan_awal' },
			{ data:'tujuan_akhir' },
			{ data:'uang_pendapatan' },
			{ data:'nama_kas' },
			/*{
				data:'button_action',
				searchable:false,
				orderable:false,
			},*/
		],
	});

	$("#tblArmadaStatus").DataTable({
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
			url: '/pendapatan/armada/ajax_list_status_armada',
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

});

setInterval(() => {
  	$("#tblArmadaStatus").DataTable().ajax.reload(null,false);
}, 15000);

function reloadTable() {
	$("#tblPendapatanArmada").DataTable().ajax.reload(null,false);
	$("#tblArmadaStatus").DataTable().ajax.reload(null,false);
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

$(document).on('click', '#btnTambah', function(e) {
	e.preventDefault();
	$("#dataTable").hide(500);
	$("#formProses").show(500);
	$("#formData")[0].reset();

	$("#nama_armada").val("").trigger("change");
	$("#imgArmada").attr("src","/assets/images/default/no_image.jpg");
	$("#imgArmadaPopup").attr("href","/assets/images/default/no_image.jpg");
	$("#tgl_surat_jalan").val("").trigger("change");
	$("#mata_uang_pendapatan").html("");
});

function btnCheck(id) {
	idData = id;
	$("#dataTable").hide(500);
	$("#formProses").show(500);
	$("#formData")[0].reset();

	$.post("/master/armada/getId/"+idData,function (json) {
		if (json.status == true) {
			$("#armada_id").val(json.data.id);
			$("#nama_armada").val(json.data.nama);
			$("#imgArmada").attr("src",json.data.photo);
			$("#imgArmadaPopup").attr("href",json.data.photo);
			$("#no_bk").val(json.data.no_bk);
			$("#tahun").val(json.data.tahun);
		} else {
			$("#errorNamaArmada").html(json.message);
		}
	});

	$.post("/performa/suratjalan/getAllJadwalTanggalArmada/"+idData,function(json) {
		var option = '<option value="">--Pilih Tanggal Surat Jalan--</option>';
		$.each(json.data,function(i,v) {
			var seeVal = v.tanggal_indo+", hari="+v.hari+", jam="+v.jam;
			option += '<option value="'+v.id+'">'+seeVal+'</option>';
		});
		$("#tgl_surat_jalan").html(option);
	});

	$("#tgl_surat_jalan").val("").trigger("change");
	$("#mata_uang_pendapatan").html("");
}

$(".close-form").click(function() {
	$("#formProses").hide(500);
	$("#dataTable").show(500);
});

var option = ""; // master account kas
$.post("/master/accountkas/getAll",function (json) {
	option = '<option value="">--Pilih Account Kas--</option>';
	$.each(json.data,function(i,v) {
		option += '<option value="'+v.id+'">'+v.nama_kas+'</option>';
	});
	$("#account_kas").html(option);
});

$("#tgl_surat_jalan").change(function() { //untuk jadwal keberangkatan
	var val = $(this).val();
	if (val != "") {
		$.post("/performa/suratjalan/getId/"+val, function(json) {
			$("#berangkat").val(json.data.tujuan_awal);
			$("#tujuan").val(json.data.tujuan_akhir);
			$("#penanggung_jawab").val(json.data.penanggung_jawab);
		});
	} else {
		$("#berangkat").val("");
		$("#tujuan").val("");
		$("#penanggung_jawab").val("");
	}
});

$("#uang_pendapatan").keyup(function() {
	$("#mata_uang_pendapatan").html( moneyFormat.to(parseInt($(this).val())) );
});

$("#btnInput").click(function () {
	
	$.ajax({
		url: '/pendapatan/armada/inputForm',
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
			    	if (result.value) {
			    		$.ajax({
							url: '/pendapatan/armada/insertPendapatanArmada',
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

									setTimeout(function() {
										$("#formData")[0].reset();
										$("#formProses").hide(800);
										$("#dataTable").show(800);
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
