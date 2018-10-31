$(document).ready(function() {
	
	btnTambah = "";
   	if(user_role == "owner" || user_role == "dev" ) {
    	btnTambah = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-primary btn-sm' id='btnTambahUser'><i class='fa fa-plus'></i> Tambah</button>";
   	}

    btnRefresh = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-outline-secondary btn-sm' id='btnRefresh'><i class='fa fa-refresh'></i> Refresh</button>";

	$("#tblUsers").DataTable({
		serverSide:true,
		responsive:true,
		processing:false,
		oLanguage: {
            // sProcessing: "<center><img src='img/denya/ajax-loader.gif' class='ajax-loader'></center>",
            // sProcessing : '<center><span class="fa fa-refresh fa-spin" style="font-size: 100px;"></span></center>',
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
			url: '/master/users/ajax_list',
			type: 'POST',
		},

		order:[[3,'ASC']],
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
			{ data:'full_name' },
			{ data:'username' },
			{ data:'role' },
			{
				data:'status'
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
	$("#tblUsers").DataTable().ajax.reload(null,false);
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

$(document).on('click', '#btnTambahUser', function (e) {
	e.preventDefault();
	// alert("test data tambah");
	$("#modalForm").modal("show");
	$("#formData")[0].reset();
	$("#img_photo").attr("src","/assets/images/default/user_image.png");
	$(".modal-title").text("Tambah Pengguna");
	$("#username").attr("readonly",false);
	save_method = "add";
});

function btnStatus(id) {
	$.post("/master/users/status/"+id, function(json) {
		if (json.status == true) {
			reloadTable();
		}
	});
}

function edit(id) {
	$("#modalForm").modal("show");
	$(".modal-title").text("Edit Pengguna");
	$("#username").attr("readonly",true);
	save_method = "update";
	idData = id;
	$.post('/master/users/getbyid/'+idData,function(json) {
		if (json.status == true) {
			$("#full_name").val(json.data.full_name);
			$("#username").val(json.data.username);
			$("#role").val(json.data.user_role_id);
			srcPhoto = json.data.photo == "" ? '/assets/images/default/user_image.png' : '/uploads/admin/users/'+json.data.photo;
			$("#img_photo").attr("src",srcPhoto);
		} else {
			$("#full_name").val("");
			$("#username").val("");
			$("#role").val("");
			srcPhoto = '/assets/images/default/user_image.png';
			$("#img_photo").attr("src",srcPhoto);
			$("#inputMessage").html(json.message);
			reloadTable();
			setTimeout(function() {
				$("#inputMessage").html("");
				$("#modalForm").modal("hide");
			},1000);
		}
	});
}


$("#modalButtonSave").click(function() {
	var url;
	if (save_method == "add") {
		url = '/master/users/add';
	} else {
		url = '/master/users/update/'+idData;
	}

	var formData = new FormData($("#formData")[0]);
	$.ajax({
		url: url,
		type:'POST',
		data:formData,
		contentType:false,
		processData:false,
		dataType:'JSON',
		success: function(json) {
			if (json.status == true) {
				$("#inputMessage").html(json.message);
				setTimeout(function() {
					$("#formData")[0].reset();
					$("#modalForm").modal("hide");
					$("#inputMessage").html("");
					reloadTable();
					/*untuk perubahan nama dan photo user login*/
					profilePhoto();
					
				}, 1500);
			} else {
				$("#errorFullName").html(json.error.full_name);
				$("#errorUsername").html(json.error.username);
				$("#errorPassword").html(json.error.password);
				$("#errorConfirmPassword").html(json.error.confirm_password);
				$("#errorRole").html(json.error.role);
				

				if (json.error.photo) {
					$("#errorUpload").html(json.error.photo);
					setTimeout(function() {
						$("#errorUpload").html("");
					}, 10000);
				}

				setTimeout(function() {
					$("#errorFullName").html("");
					$("#errorUsername").html("");
					$("#errorPassword").html("");
					$("#errorConfirmPassword").html("");
					$("#errorRole").html("");
				}, 4000);
			}
		}
	});
});

function btnDelete(id) {
	
	idData = id;
	$.post("/master/users/getbyid/"+idData,function(json) {
		if (json.status == true) {

			srcPhoto = json.data.photo == "" ? '/assets/images/default/user_image.png' : '/uploads/admin/users/'+json.data.photo;

			var pesan =	"<hr>";
				// pesan += "<hr> <div class='row'>";
				pesan += "<div class='pull-left'>";
				pesan += "<label><small>Photo Pengguna :</small></label><br>";
				pesan += "<img src='"+srcPhoto+"' alt='Photo Pengguna' class='img img-responsive' style='width:100px; height:80px;'>";
				pesan += "</div><br><br><br><br><br>";
				// pesan += "<div class='col-md-8'>";
				pesan += "<li class='pull-left'><small>Nama : <i>"+json.data.full_name+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Username : <i>"+json.data.username+"</small></i></li><br>";
				pesan += "<li class='pull-left'><small>Role : <i>"+json.data.role+"</small></i></li><br>";
				// pesan += "</div>";
				// pesan += "</div>";
		    swal({   
		        title: "Apakah anda yakin.?",
		        type: "warning",    
		        html: "<span style='color:red;'>Data yang di <b><u>Hapus</u></b> tidak bisa dikembalikan lagi.</span>"+pesan,
  				showCloseButton: true,
		        showCancelButton: true,   
		        confirmButtonColor: "#DD6B55",   
		        confirmButtonText: "Iya, Hapus",   
		        closeOnConfirm: false 
		    }).then((result) => {  
		    	if (result.value) {
		    		$.post("/master/users/delete/"+idData,function(json) {
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

$.post("/master/users/userRoles",function(json) {
	if (json.status == true) {
		var option;
		option = '<option value=""></option>';
		$.each(json.data,function(i,v) {
			option += '<option value="'+v.id+'">'+v.role+'</option>';
		});
		$("#role").html(option);
	}
});

/* prosessing photo change*/
	$("#ganti_photo").click(function() {
		$("#photo_user").click();
	});

	$("#photo_user").change(function(event){
		readURL(document.getElementById('photo_user'));
		$('#id_delete').val(0);
	});

	$("#hapus_photo").click(function() {
	   $('#img_photo').attr('src','/assets/images/default/user_image.png');
	   $("#photo_user").val("");
	   $('#id_delete').val(1);	
	});

	function readURL(input)
	{
	   if (input.files && input.files[0])
	   {
	     var reader = new FileReader();
	     reader.onload = function (e)
	     {
	       $('#img_photo').attr('src',e.target.result);
	     };
	     reader.readAsDataURL(input.files[0]);
	   }
	}
/* end photo change*/