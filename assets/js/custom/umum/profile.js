
$.post("/umum/getIdUser", function(json) {
	if (json.status == true) {
		$("#img_photo_profile").attr("src",json.data.photo);
		$("#nama_lengkap_profile_photo").html(json.data.full_name);
		$("#role_profile").html(json.data.role);
		$("#username_profile").val(json.data.username);
		$("#nama_lengkap_profile").val(json.data.full_name);
	} else {
		window.location.href = "/auth/logout1";
	}
});

$("#btnUpdateProfile").click(function() {
	var formData = new FormData($("#formDataProfile")[0]);
	$.ajax({
		url: "/umum/updateProfile",
		type:'POST',
		data:formData,
		contentType:false,
		processData:false,
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
					/*untuk perubahan nama dan photo user login*/
					profilePhoto();
				}, 1500);
			} else {
				if (json.message == "error_photo") {
					swal({   
			            title: "<h2 style='color:red;'>Error Foto!</h2>",   
			            html: fotoError,
			            type: "error",
			        });
				} else {
					swal({   
				            title: "Error Form",   
				            html: json.message,
				            type: "error",
				        });
				}
			}
		}
	});
});

/*function untuk baca target src file image dan validate nya juga*/
function readURLProfile(input,targetID,targetIdSide) {
	var filePath = input.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if(!allowedExtensions.exec(filePath)){ // validate format extension file
        // alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
        swal({   
	            title: "<h2 style='color:red;'>Error Foto!</h2>",   
	            html: "<u>Foto Profile : </u>  <small><span style='color:red;'> Jenis file yang Anda upload tidak diperbolehkan.</span> <br> Harap hanya upload file yang memiliki ekstensi <br> .jpeg | .jpg | .png | .gif </small>",
	            type: "error",
	        });

        input.value = '';
        return false;

    } else if (input.files[0].size > 1048576) { // validate size file 1 mb
		// alert("file size lebih besar dari 1 mb, file size yang di upload = "+input.files[0].size);
		swal({   
	            title: "<h2 style='color:red;'>Error Foto!</h2>",   
	            html: "<u>Foto Profile : </u>  <small style='color:red;'>File yang diupload melebihi ukuran maksimal diperbolehkan yaitu 1 mb.</small>",
	            type: "error",
	        });
        input.value = '';
		return false;

	} else {
	   	if (input.files && input.files[0])
	   	{
		    var reader = new FileReader();
		    reader.onload = function (e)
		    {
		       $('#'+targetID).attr('src',e.target.result);
		       $('.'+targetIdSide).attr('src',e.target.result);
		    };
		    reader.readAsDataURL(input.files[0]);
	   	}
	}
}

/* prosessing foto karyawan change*/
	$("#ganti_photo_profile").click(function() {
		$("#photo_profile").click();
	});

	$("#photo_profile").change(function(event){
		readURLProfile(document.getElementById('photo_profile'),"img_photo_profile","img-user-login");
		$('#is_delete_profile').val(0);
	});

	$("#hapus_photo_profile").click(function() {
	   $('#img_photo_profile').attr('src','/assets/images/default/user_image.png');
	   $('.img-user-login').attr('src','/assets/images/default/user_image.png');
	   $("#photo_profile").val("");
	   $('#is_delete_profile').val(1);	
	});
/* end foto karyawan change*/