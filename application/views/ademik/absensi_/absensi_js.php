<script src="<?=base_url()?>assets/plugins/jquery_validation/jquery.form.js"></script>
<script src="<?=base_url()?>assets/plugins/jquery_validation/jquery.validate.js"></script>
<script src="<?=base_url()?>assets/plugins/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?=base_url()?>assets/plugins/sweetalert2/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert2/dist/sweetalert2.min.css">

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

	function success_alert() {
		swal({
		  type	: 'success',
		  title	: 'Data Tersimpan',
		  showConfirmButton: false,
		  timer	: 1000,
		})
	}

	function error_alert() {
		swal({
			type: 'error',
			title: 'Data Belum Tersimpan',
			text: 'Mohon tentukan dosen dan tanggal sebelum menyimpan'
		})
	}


	$("#form_validation").validate({
		submitHandler: function(form){
			let c_url 	= "<?= site_url('ademik/Absensi/data_jadwal');?>";
			let fields 	= $("#form_validation").serializeArray();
			
			loading_alert();
			
			$.ajax({
				method 	: "POST",
				url 	: c_url,
				data 	: fields
			})
			.done(function( dataResposnse ) {
				swal.closeModal();
				if (dataResposnse == null) {
					Swal.fire({
					  type	: 'error',
					  title	: 'Oops...',
					  text	: 'Data tidak ditemukan !',
					})		
				}
				$('#jadwal_matakuliah').html(dataResposnse);
			})
			.fail(function ( dataResposnse) {
				Swal.fire({
				  type	: 'error',
				  title	: 'Oops...',
				  text	: 'Gagal menghubungkan ke server',
				})
			});
		}	
	});


    function absen_dosen_1(IDJadwal, semester) {
      var url = "<?= base_url('index.php/ademik/Absensi/absen_dosen')?>";
      
      loading_alert()
        $.post(
          url,
          {
            IDJadwal : IDJadwal,
            semester : semester
          }
        )
        .done(function (data) {
          $("#jadwal_matakuliah").html(data);
          swal.closeModal();
        });
    }

	function success_alert_load(IDJadwal) {
		swal({
		  type	: 'success',
		  title	: 'Data Tersimpan',
		  showConfirmButton: false,
		  timer	: 1500,
		  onClose :() =>{
		  	absen_dosen_1(IDJadwal);
		  }
		})
	}	

</script>