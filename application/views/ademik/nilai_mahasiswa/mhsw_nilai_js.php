<script src="/assets/plugins/jquery_validation/jquery.form.js"></script>
<script src="/assets/plugins/jquery_validation/jquery.validate.js"></script>
<script src="/assets/plugins/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="/assets/plugins/sweetalert2/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="/assets/plugins/sweetalert2/dist/sweetalert2.min.css">

<script type="text/javascript">
	jQuery.extend(jQuery.validator.messages, {
		required: "<b style ='color:red'>Mohon isi dulu kolom yang disediakan <b>"
	});

	function loading_alert() {
		swal({
		  title		: 'Mohon Tunggu Sebentar',
		  html  	: 'Sedang Mengambil Data',
		  onOpen	: () => {
		    swal.showLoading()
		  }
		})
	}

	$("#form_validation").validate({
		submitHandler: function(form, event){
			event.preventDefault();
			var semester = $("#semesterAkademik").val();
			var program  = $("#program").val();
			var jurusan  = $("#jurusan").val();

			var url_form  = "ademik/mhsw_nilai2/data_form_pencarian/"+semester+"/"+program+"/"+jurusan;

			loading_alert();
			$('#load_content').load("<?php echo base_url()?>"+url_form,function () {
				swal.closeModal();
			})
		}
	});


</script>
