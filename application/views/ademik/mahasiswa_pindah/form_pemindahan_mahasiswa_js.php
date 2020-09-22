<script src="/assets/plugins/jquery_validation/jquery.form.js"></script>
<script src="/assets/plugins/jquery_validation/jquery.validate.js"></script>

<script type="text/javascript">

	$body = $("body");
	// deklarasi plugins
	$(document).ready(function() {
    	$('#input_jurusan').select2();
	});

	jQuery.extend(jQuery.validator.messages, {
		required: "<b>Mohon isi dulu kolom yang disediakan <b>"
	});

	$("#form_validation").validate({
		
		submitHandler: function(form){
			var nim  		= $('#NIM_mahasiswa').val();
			var	jurusan  	= $('#input_jurusan').val();
			
	      $body.addClass("loading");
		    $.post(
		        "<?php echo base_url('index.php/ademik/Mhswpindah/cek_status_mahasiswa') ?>",
		        {
		         nim 	 : nim,
		         jurusan : jurusan
		        }
		      )
		     .done(function (data) {
					 
          $body.removeClass("loading");
		     	if (data == "1") {
		     		// alert("Mahasiswa Berstatus Aktif");
		      		 $('#load_content').load("<?php echo base_url('index.php/ademik/Mhswpindah/data_mahasiswa_baru/')?>"+nim+"/"+jurusan);
		     	}
		     	else if (data == "2"){
		     		alert("Mahasiswa Sudah ada di jurusan yang dipilih");
		     	}
		     	else{
		     		alert("Mahasiswa Sudah Pindah / NIM yang dimasukkan salah ");
		     	}

		       
		     })
		     .fail(function () {
					 
          $body.removeClass("loading");
		       alert("Mahasiswa Tidak DItemukan");
		     })
		}
	});

</script>