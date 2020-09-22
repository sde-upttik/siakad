/*
fandu scripts
	$(document).ready(function() {
		alert('masuk');
		$('#frm-login').validate({
	rules: {
		username : {
			digits: true,
			minlength:10,
			maxlength:10
		}
	}
		alert('masuk');
	});*/
	
	$("#username").keyup(function(){
            var username = $("#username").val();
            var jumlahkarakter = username.length;
            if(jumlahkarakter < 6){
                //$("#confirm_username").html("<span style='color:red'>Jumlah karakter username anda tidak mencukupi</span>");
				$("#confirm_username").html("");
            }
            else if(jumlahkarakter > 20){
                $("#confirm_username").html("<span style='color:red'>Jumlah karakter username anda terlalu banyak. Maksimal 20 Karakter</span>");
            }
            else{
                if(username.match(/[^a-zA-Z0-9]/i))
                    $("#confirm_username").html("<span style='color:red'>Anda memasukkan karakter yang tidak diijinkan</span>");
                else
                    $("#confirm_username").html("<span style='color:green'>Jumlah karakter Maksimal 20 karakter</span>");
            }
      });
	  
	  $("#password").keyup(function(){
            var password = $("#username").val();
            var jumlahkarakter = password.length;
            if(jumlahkarakter < 6){
				$("#confirm_password").html("");
            }
            else if(jumlahkarakter > 20){
                $("#confirm_password").html("<span style='color:red'>Jumlah karakter password anda terlalu banyak. Maksimal 20 Karakter</span>");
            }
            else{
                if(password.match(/[^a-zA-Z0-9]/i))
                    $("#confirm_password").html("<span style='color:red'>Anda memasukkan karakter yang tidak diijinkan</span>");
                else
                    $("#confirm_password").html("<span style='color:green'>Jumlah karakter Maksimal 20 karakter</span>");
            }
      });