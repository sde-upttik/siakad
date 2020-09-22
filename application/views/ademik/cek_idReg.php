<style type="text/css">
	.modal-fullscreen {
	  padding: 0 !important;
	}
	.modal-fullscreen .modal-dialog {
	  width: 100%;
	  height: 100%;
	  margin: 0;
	  padding: 0;
	  max-width: 100%;
	}
	.modal-fullscreen .modal-content {
	  height: auto;
	  min-height: 100%;
	  border: 0 none;
	  border-radius: 0;
	}
</style>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Cek ID Registrasi Mahasiswa
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="breadcrumb-item"><a href="<?= $_SESSION['tamplate'] ?>">Cek ID Registrasi Mahasiswa</a></li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Daftar Mahasiswa Lulus/DO</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<form action="" method="POST">
			            	<div class="form-group row">
							  	<label for="example-text-input" class="col-sm-2 col-form-label">No. Stambuk</label>
							  	<div class="col-sm-3">
							  		<input class="form-control" type="text" name="nim" id="nim" value="" placeholder="Input Nomor Stambuk">
							  	</div>
							</div>
							<div style="margin: 50px 0px 10px 218px">
								<button type="button" onclick="cari()" class="btn btn btn-success"> Cari</button>
							</div>
						</form>
						<div id='hasil'></div>
					</div>
					<!-- /.box-body -->
				</div>

			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>

<script type="text/javascript">

	function cari() {

		var nim = $('#nim').val();

		if ( nim == '' ) {

			swal({   
				title: 'Peringatan',   
				type: 'warning',    
				html: true, 
				text: 'Silakan Masukan Stambuk',
				confirmButtonColor: '#f7cb3b',   
			});

		} else {

			$body = $("body");
			$body.addClass("loading");

			var data = 'nim='+nim;

			$.ajax({
			    url: "<?= base_url('ademik/cek_idReg/mencariDataFeeder'); ?>",
			    type: 'POST',
			    data: data,
			    dataType: 'json',
			    cache : false,
			    success: function(data){
			      	$body.removeClass("loading");
			      	console.log(data);


			      	if ( data.ket == 'error' ) {
	        	
			        	swal({   
			          		title: 'Peringatan',   
			          		type: 'warning',    
			          		html: true, 
			          		text: data.error_code+' '+data.error_desc,
			          		confirmButtonColor: '#f7cb3b',   
			        	});

			      	} else if (data.ket == 'sukses') {



			        	$("#hasil").append("<p> NIM :  "+data.nim+"</p>");
			        	$("#hasil").append("<p> Nama :  "+data.nama+"</p>");
			        	$("#hasil").append("<p> id_reg :  "+data.reg+"</p>");
			        	$("#hasil").append("<p> id_pd :  "+data.pd+"</p>");
			        	$("#hasil").append("<p> status :  "+data.status+"</p>");
			        	
			     	}

					

			    },
			    error: function (err) {
			      	console.log(err);
			    }
			});

		}

	}

	function simpan(act) {

		var nim = $('#nim').val();
		var id_reg = $('#id_reg').val();
		var keluar = $('#keluar').val();
		var tgl_keluar = $('#tgl_keluar').val();
		var ket = $('#ket').val();
		var no_sk = $('#no_sk').val();
		var tgl_sk = $('#tgl_sk').val();
		var ipk = $('#ipk').val();
		var no_ijazah = $('#no_ijazah').val();

		var data = 'act='+act+'&nim='+nim+'&id_reg='+id_reg+'&keluar='+keluar+'&tgl_keluar='+tgl_keluar+'&ket='+ket+'&no_sk='+no_sk+'&tgl_sk='+tgl_sk+'&ipk='+ipk+'&no_ijazah='+no_ijazah;

		//alert(data);

		$body = $("body");
		$body.addClass("loading");

		$.ajax({
		    url: "<?= base_url('ademik/daftarlulus/validasiDataLulusDO'); ?>",
		    type: 'POST',
		    data: data,
		    dataType: 'json',
		    cache : false,
		    success: function(data){
		      	$body.removeClass("loading");

		      	if ( data.ket == 'error' ) {
	        	
		        	swal({   
		          		title: 'Peringatan',   
		          		type: 'warning',    
		          		html: true, 
		          		text: data.pesan,
		          		confirmButtonColor: '#f7cb3b',   
		        	});

		      	} else if (data.ket == 'sukses') {

		        	swal({   
		          		title: 'Pesan',
		          		type: 'success',    
		          		html: true, 
		          		text: data.pesan,
		          		confirmButtonColor: 'green',   
		        	}, function() {
		          		location.reload();
		        	});
		        	
		     	}

		    },
		    error: function (err) {
		      	console.log(err);
		    }
		});

	}

	function proses() {

		$('p').remove();

		$body = $("body");
		$body.addClass("loading");

		$.ajax({
		    url: "<?= base_url('ademik/daftarlulus/prcLulusDOjs'); ?>",
		    dataType: 'json',
		    cache : false,
		    success: function(data){

		      	console.log(data);
		      	var j =1;
		      	$.each(data, function(i, item) {
				    var nim = data[i].NIM;
				    var nama = data[i].Name;
				    var id_reg = data[i].id_reg_pd;
				    var id_keluar = data[i].id_jenis_keluar;
				    var tgl_keluar = data[i].tgl_keluar;

				    var dataKeluar = '&nim='+nim+'&nama='+nama+'&id_reg='+id_reg+'&id_keluar='+id_keluar+'&tgl_keluar='+tgl_keluar;

				    //alert(dataKeluar);

				    $.ajax({
					    url: "<?= base_url('ademik/daftarlulus/prcjs'); ?>",
					    type: 'POST',
					    data: dataKeluar,
					    dataType: 'json',
					    cache : false,
					    success: function(data){

					      	$("#hasil").append("<p>"+j+". "+data.nim+" "+data.nama+" "+data.ket+"</p>");

							j++;

					    },
					    error: function (err) {
					      	console.log(err);
					    }
					});
				});

		      $body.removeClass("loading");
		    },
		    error: function (err) {
		      	console.log(err);
		    }
		});

	}

	function prcupdate() {

		$('p').remove();

		$body = $("body");
		$body.addClass("loading");

		$.ajax({
		    url: "<?= base_url('ademik/daftarlulus/prcdataupdateJs'); ?>",
		    dataType: 'json',
		    cache : false,
		    success: function(data){

		      	//console.log(data);
		      	var j =1;
		      	$.each(data, function(i, item) {
				    var nim = data[i].NIM;
				    var nama = data[i].Name;
				    var id_reg = data[i].id_reg_pd;
				    var id_keluar = data[i].id_jenis_keluar;
				    var tgl_keluar = data[i].tgl_keluar;

				    var dataKeluar = '&nim='+nim+'&nama='+nama+'&id_reg='+id_reg+'&id_keluar='+id_keluar+'&tgl_keluar='+tgl_keluar;

				    //alert(dataKeluar);

				    $.ajax({
					    url: "<?= base_url('ademik/daftarlulus/prcupdatejs'); ?>",
					    type: 'POST',
					    data: dataKeluar,
					    dataType: 'json',
					    cache : false,
					    success: function(data){

					      	$("#hasil").append("<p>"+j+". "+data.nim+" "+data.nama+" "+data.ket+"</p>");

							j++;

					    },
					    error: function (err) {
					      	console.log(err);
					    }
					});
				});

		      $body.removeClass("loading");
		    },
		    error: function (err) {
		      	console.log(err);
		    }
		});

	}

	function hapus(id){
		swal({
	        title: "Peringatan",
	        text: "Anda Yakin Untuk Menghapus Berita ini?",
	        type: "warning",
	        showCancelButton: true,
	        confirmButtonColor: '#DD6B55',
	        confirmButtonText: 'Ya',
	        cancelButtonText: "Tidak",
	        closeOnConfirm: false,
	        closeOnCancel: false
		},
	    function(isConfirm) {	
	        if (isConfirm) {
	            $body = $("body");
				$body.addClass("loading");

		    	$.ajax({
					url : "<?= base_url(''); ?>/" +id,
					type: "GET",
					dataType: "JSON",
					success: function(hasil) {
						$body.removeClass("loading");

						console.log(hasil);

						if ( hasil.ket == 'error' ) {
							//console.log(respon.pesan);
							swal({   
								title: 'Peringatan',   
								type: 'warning',    
								html: true, 
								text: hasil.pesan,
								confirmButtonColor: '#f7cb3b',   
							});

						} else if (hasil.ket == 'sukses') {
							swal({   
								title: 'Pesan',   
								type: 'success',    
								html: true, 
								text: hasil.pesan,
								confirmButtonColor: 'green',   
							}, function() {
								location.reload();
							});

						}
					},
					error: function (err) {
				    	console.log(err);
					}
				});

	        } else {
	            swal("Batal","", "error");
	        }
	    });
	}

</script>