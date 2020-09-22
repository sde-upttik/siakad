<script type="text/javascript">

	function mencari() {

		var nim = $('#nim').val();

		if ( nim == '' ) {

			swal({   
				title: 'Peringatan',   
				type: 'warning',
				text: 'Silakan Masukan Stambuk',
				confirmButtonColor: '#f7cb3b',   
			});

		} else {

			$body = $("body");
			$body.addClass("loading");

			$.ajax({
			    url: "<?= base_url('ademik/mhswpindah/dataMhswKeluar'); ?>/"+nim,
			    type: 'POST',
			    dataType: 'json',
			    cache : false,
			    success: function(data){
			      	$body.removeClass("loading");

					if ( data == null ) {

						swal({   
							title: 'Peringatan',   
							type: 'warning',
							text: 'Stambuk yang Anda Masukan Tidak Sesuai',
							confirmButtonColor: '#f7cb3b',   
						});

					} else {

						$('#nama').val(data.Name);
						$('#fakultas').val(data.Singkatan);
						$('#jurusan').val(data.Nama_Indonesia);
						$('#alamatS').val(data.Alamat);

					}

			    },
			    error: function (err) {
			      	console.log(err);
			    }
			});

		}

	}

	function proses_pindah(event) {

		event.preventDefault();

		let fields 			= $('#formPindahKeluar').serialize();

		let file_transkrip 	= $('#transkrip').prop('files')[0]; 
		let file_blangko 	= $('#blangko').prop('files')[0]; 
		
		let form_data1 	= new FormData();    
		form_data1.append('file1', file_transkrip);
		form_data1.append('file2', file_blangko);

		$body = $("body");
		$body.addClass("loading");

		$.ajax({
	        type  		: "POST",
	        url 		: "<?php echo base_url('ademik/Mhswpindah/prosesMhswKeluar') ?>",
	        data 		: fields,
	        dataType	: 'json'
	    })
	    .done(function (data) {
	    	//console.log(data);
	    	if (data.respon==1) {
	    		    		
	    		uploadFilePdf(form_data1);

	    		$body.removeClass("loading");

	    		$('#form_pindah_keluar').load("<?php echo site_url('ademik/Mhswpindah/view_response_pindah_keluar') ?>")

	    	} else {
	    		$body.removeClass("loading");
	    		alert_peringatan(data.pesan);
	    		
	    	}

	    })
	    .fail(function () {
	    	alert_error('Gagal menyambungkan ke server');
	    });

	}

	function uploadFilePdf(form_data) {
		$.ajax({
	        type  		: "POST",
	        url 		: "<?php echo site_url('ademik/Mhswpindah/uploadFilePdf') ?>",
	        data 		: form_data,
			contentType : false,
			cache		: false,
			processData	: false,
			dataType 	: 'json'
	    })
	    .done(function (data) {
	    	
	    	if (data==1) {

	    		alert_success();

	    	} else {

	    		alert_error();

	    	}
	    })
	    .fail(function () {
	    	alert_error('Gagal menyambungkan ke server1');
	    });
	}	

	// inisialisasi sweetalert2
	function alert_success() {
		return Swal({
		  type					: 'success',
		  title					: 'Data berhasil disimpan',
		  showConfirmButton		: false,
		  timer					: 1000
		})
	}	

	function alert_peringatan(msg) {
		return swal({   
			title: 'Peringatan',   
			type: 'warning',
			html: msg,
			confirmButtonColor: '#f7cb3b', 
		})
	}	

	function alert_error(text) {
		if (text!=null) {
			return Swal({
			  type					: 'error',
			  title					: text,
			  showConfirmButton		: false,
			  timer					: 1000
			})
		}
		else{
			return Swal({
			  type					: 'error',
			  title					: 'Data gagal disimpan',
			  showConfirmButton		: false,
			  timer					: 1000
			})
		}

	}

</script>