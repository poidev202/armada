
$.post("/umum/getIdUmum", function(json) {
	if (json.status == true) {
		$("#logo_perusahaan").attr("src",json.data.logo_icon);
		$("#nama_perusahaan").val(json.data.nama_perusahaan);
		$("#telephone").val(json.data.telephone);
		$("#email").val(json.data.email);
		$("#alamat").val(json.data.alamat);
	}
});

$("#nama_perusahaan").keyup(function() {
	$("#logoName").html($(this).val());
});

$("#btnUpdateUmum").click(function() {
	var formData = new FormData($("#formData")[0]);
	$.ajax({
		url: "/umum/updatePengaturan",
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
					/*untuk perubahan nama dan photo logo icon*/
					loadLogoIcon();
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
function readURLUmum(input,targetID,targetIdSide,targetIdIconTitle) {
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
		       $('#'+targetIdSide).attr('src',e.target.result);
		       $('#'+targetIdIconTitle).attr('href',e.target.result);
		    };
		    reader.readAsDataURL(input.files[0]);
	   	}
	}
}

/* prosessing foto karyawan change*/
	$("#ganti_photo_logo").click(function() {
		$("#photo_logo").click();
	});

	$("#photo_logo").change(function(event){
		readURLUmum(document.getElementById('photo_logo'),"logo_perusahaan","imgLogoIcon","titleLogoIcon");
		$('#is_delete').val(0);
	});

	$("#hapus_photo_logo").click(function() {
	   $('#titleLogoIcon').attr('href','/assets/images/default/no_image.jpg');
	   $('#logo_perusahaan').attr('src','/assets/images/default/no_image.jpg');
	   $("#imgLogoIcon").attr("src",'/assets/images/default/no_image.jpg');
	   $("#photo_logo").val("");
	   $('#is_delete').val(1);	
	});
/* end foto karyawan change*/