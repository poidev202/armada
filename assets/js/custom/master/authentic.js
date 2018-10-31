$(document).ready(function() {
	$("#btnLogin").click(function() {
		$("#btnLogin").attr("disabled",true);
		$("#btnLogin").html("Loading...<i class='fa fa-spinner fa-spin'></i>");
		$.ajax({
			url: '/auth/login_ajax',
			type:'POST',
			dataType:'json',
			data:$("#formLogin").serialize(),
			success:function(json) {
				if (json.status == true) {

					$("#btnLogin").attr("disabled",true);
					$("#btnLogin").html("Harap menunggu...<i class='fa fa-spinner fa-spin'></i>");

					setTimeout(function() {
						$("#btnLogin").attr("disabled",false);
						$("#btnLogin").html(' Login System');
						window.location.href = "/";
					},2000);
				} else {
					$("#errorUsername").html(json.error.username);
					$("#errorPassword").html(json.error.password);

					if (json.error.account) {
						// $("#inputMessage").html(json.error.account);
						swal({   
				            title: "Error Login System",   
				            html: json.error.account,
				            type: "error",
				        });
					}

					setTimeout(function() {
						$("#inputMessage").html("");

						$("#errorUsername").html("");
						$("#errorPassword").html("");
						// $("#inputMessage").html("");
						$("#btnLogin").attr("disabled",false);
						$("#btnLogin").html('<span class="mdi mdi-sign-in"></span> Login System');
					},3000);
				}
			}
		});
	});
});

$(document).keypress(function(e) {
    if(e.which == 13) {
        $("#btnLogin").click();
    }
});

setInterval(() => {
  	$.post("/auth/logoutAuto",function (json) {
        if (json.status == false) {
             const toast = swal.mixin({
              toast: true,
              position: 'center',
              showConfirmButton: false,
              timer: 4000
            });

            toast({
              type: 'success',
              title: 'Anda sudah Login!'
            });

            setTimeout(function() {
                window.location.href = "/";
            },3000);
        }
    });
}, 20000);