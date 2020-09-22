 <!--  sweetalert2 -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/sweetalert2/dist/sweetalert2.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/plugins/sweetalert2/dist/sweetalert2.min.js') ?>"></script>

<script>
  let base_url = "<?= base_url() ?>";
	//Inisialisasi Sweetaler2
	function alert_success() {
		return Swal({
		  type					: 'success',
		  title					: 'Data berhasil disimpan',
		  showConfirmButton		: false,
		  timer					: 1000
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

	//inisialisasi datepicker
    $('#TglLahir').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    });	

    //inisialisasi select2
    $('.select2').select2();
		$('.selectPT').select2({
           	minimumInputLength: 5,
           	allowClear: true,
           	placeholder: 'masukkan nama Perguruan tinggi',
           	ajax: {
              dataType: 'json',
              url: base_url+'ademik/Mhswpindah/GetAllPT',
							method :'POST',
              delay: 800,
              data: function(params) {
                return {
                  search: params.term
                }
              },
              processResults: function (data, page) {
              return {
                results: data
              };
            },
          }
      }).on('selectPT:select', function (evt) {
         let data = $(".selectPT option:selected").text();
         alert("Data yang dipilih adalah "+data);
      });
    //Serverside Select Jurusan
    $('#KodeFakultas').change(function () {
    	$('option', '#select_jurusan').remove();

    	let KodeFakultas = $('#KodeFakultas').val();

        $.post(
	    	"<?php echo site_url('ademik/Mhswpindah/getDataJurusanWhere') ?>",
	    	{
	    		KodeFakultas : KodeFakultas
	    	},
	    	function (data) {
				$.each(JSON.parse(data), function(index, value ) {
					$('#select_jurusan_option').append('<option value="'+value.Kode+'">'+value.Nama_Indonesia+' ('+value.Kode+')'+'</option>');
				});
	    	}
	    )
    });

    //Showing Password
	$("#btn_show").on("click", function() {
		var type = $("#Password").attr("type");
		if (type == "text"){ 
		  $("#Password").prop('type','password');}
		else{ 
		  $("#Password").prop('type','text'); }
	});

	//Send Data to Controller 
	function submit_data(event) {
		event.preventDefault();

		let fields 		= $('#form_pindahkeuntad').serialize();

		let file_data1 	= $('#sk_1').prop('files')[0]; 
		let file_data2 	= $('#sk_2').prop('files')[0]; 
		
		let form_data 	= new FormData();    
		form_data.append('file1', file_data1);
		form_data.append('file2', file_data2);

		$.ajax({
	        type  		: "POST",
	        url 		: "<?php echo site_url('ademik/Mhswpindah/insert_pindah_untad') ?>",
	        data 		: fields,
	    })
	    .done(function (data) {
	    	if (data==1) {	    		
				uploadFilePdf(form_data);
	    		$('#form_pindah_untad').load("<?php echo site_url('ademik/Mhswpindah/view_response_pindah_untad') ?>")
	    	}
	    	else{
				alert_error();			
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
	    	}
	    	else{
				console.log(data);
	    		alert_error();
	    	}
	    })
	    .fail(function () {
	    	alert_error('Gagal menyambungkan ke server1');
	    });
	}	

	$("#UniversitasAsal").change(function(){
		$('#ProdiAsal').html('');
		$("#UniversitasAsal").attr('disabled', true);
		$.post({
			url: base_url+'ademik/mhswpindah/getProdiAsal',
			data: {
				"id_perguruan_tinggi":$("#UniversitasAsal").val()
			},
			method : "POST"
		}).done(function(res) {
			let listProdi = JSON.parse(res).data;
			for (let i = 0; i < listProdi.length; i++) {
				const prodi = listProdi[i];
				$('#ProdiAsal').append("<option value='"+prodi.id_prodi+"'>"+prodi.nama_jenjang_pendidikan+" - "+prodi.nama_program_studi+"</option>");

			}
			$('.select2').select2();
		}).always(function(){
			$("#UniversitasAsal").attr('disabled', false);
		});
		
	});
</script>