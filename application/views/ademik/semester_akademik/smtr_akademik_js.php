<script src="/assets/plugins/jquery_validation/jquery.form.js"></script>
<script src="/assets/plugins/jquery_validation/jquery.validate.js"></script>

<script type="text/javascript">
	jQuery.extend(jQuery.validator.messages, {
		required: "<b>Mohon isi dulu kolom yang disediakan <b>"
	});

	$("#form_validation").validate({

		submitHandler: function(form){
			var program  = $('#input_program').val();
			var	jurusan  = $('#input_jurusan').val();
			
			//alert("Berhasil Validasi"+program+"  "+jurusan);

			$('#load_content').load("<?php echo base_url('index.php/ademik/Smtr_akademik/get_semester_akademik/')?>"+program+"/"+jurusan);
		}
	});
</script>