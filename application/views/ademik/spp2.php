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
			SPP-2
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="breadcrumb-item"><a href="<?= $_SESSION['tamplate'] ?>">SPP-2</a></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="box">
		    	<div class="box-header">
              		<h3 class="box-title">Input Data SPP-2</h3>
            	</div>

            	<div class="box-body">
					<div class="row">
						<div class="col-12">
							<form action="" method="POST">
				            	<div class="form-group row">
								  	<label for="example-text-input" class="col-sm-2 col-form-label">No. Stambuk</label>
								  	<div class="col-sm-3">
								  		<input class="form-control" type="text" name="nim" id="nim" value="" placeholder="Input Nomor Stambuk">
								  	</div>
								  	<div class="col-sm-1">
								  		<button type="button" onclick="mencari()" class="btn btn btn-primary fa fa-search"> Search</button>
								  	</div>
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Nama Mahasiswa</label>
								  	<div class="col-sm-4">
								  		<input class="form-control" type="text" name="nama" id="nama" value="" readonly>
								  		<input class="form-control" type="hidden" name="sex" id="sex" value="" readonly>
								  	</div>
								</div>
								<div class="form-group row">
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Tahun Semester Akademik</label>
								  	<div class="col-sm-3">
										<input class="form-control" type="text" name="tahun" id="tahun" placeholder="Input Tahun Semester Akademik">
								  	</div>
								  	<div class="col-sm-1">
								  	</div>
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Jurusan</label>
								  	<div class="col-sm-4">
								  		<input class="form-control" type="text" name="jurusan" id="jurusan" value="" readonly>
								  	</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label">Tipe Bayar</label>
									<div class="col-sm-3">
										<select class="form-control select2" name="bayar" id="bayar" onchange="open_ket()">
											<option value="">--Pilih Tipe Bayar--</option>
											<option value="1">Reguler</option>
											<option value="2">Beasiswa</option>
											<option value="3">Potongan UKT</option>
											<option value="4">Lain-Lain</option>
										</select>
									</div>
								  	<div class="col-sm-1">
								  	</div>
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Status Mahasiswa</label>
								  	<div class="col-sm-4">
								  		<input class="form-control" type="text" name="status" id="status" value="" readonly>
								  		<input class="form-control" type="hidden" name="kodeStatus" id="kodeStatus" value="" readonly>
								  	</div>
								</div>
								<div class="form-group row">
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Keterangan Beasiswa,Potongan UKT,dll</label>
								  	<div class="col-sm-3">
										<input class="form-control" type="text" name="ket" id="ket" placeholder="Input Keterangan" disabled>
								  	</div>
								</div>
								<div class="form-group row">
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Total Pembayaran</label>
			            			<div class="col-sm-3">
			              				<div class="input-group">
                    						<div class="input-group-addon">
                      							<i>Rp.</i>
                    						</div>
                    						<input type="text" name="rp" id="rp" value="" class="form-control" />
                  						</div>
			            			</div>
								</div>
								<div class="form-group row">
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal SPC</label>
			            			<div class="col-sm-3">
			              				<div class="input-group">
                    						<div class="input-group-addon">
                      							<i class="fa fa-calendar"></i>
                    						</div>
                    						<input type="text" name="tgl" id="tgl" value="" class="form-control datepicker" />
                  						</div>
			            			</div>
								</div>
								<div class="form-group row bootstrap-timepicker">
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Jam SPC</label>
								  	<div class="col-sm-3">
										<div class="input-group">
											<div class="input-group-addon">
                      							<i class="fa fa-clock-o"></i>
                    						</div>
                    						<input type="time" name="jam" id="jam" value="" class="form-control" />
                  						</div>
                  					</div>
								</div>
								<div style="margin: 50px 0px 10px 218px">
									<button type="button" onclick="simpan()" class="btn btn btn-success fa fa-save"> Simpan</button>
				                	<button type="reset" class="btn btn btn-danger fa fa-refresh"> Reset</button>
								</div>
							</form>
						</div>
							<!-- /.col -->
					</div>
						<!-- /.row -->
				</div>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>

<script type="text/javascript">

	function open_ket() {

		if ( $('#bayar').val() > 1 ) {

			$('#ket').removeAttr('disabled');

		} else {

			$('#ket').attr('disabled', true);

		}

	}

	function mencari() {

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

			$.ajax({
			    url: "<?= base_url('ademik/spp2/mencariDataMhsw'); ?>/"+nim,
			    type: 'POST',
			    dataType: 'json',
			    cache : false,
			    success: function(data){
			      	$body.removeClass("loading");

					if ( data==null ) {

						swal({   
							title: 'Peringatan',   
							type: 'warning',    
							html: true, 
							text: 'Stambuk yang Anda Masukan Tidak Sesuai',
							confirmButtonColor: '#f7cb3b',   
						});

					} else {

						$('#nama').val(data.Name);
						$('#sex').val(data.Sex);	
						$('#jurusan').val(data.Nama_Indonesia);
						$('#status').val(data.Nama);
						$('#kodeStatus').val(data.Kode);

					}

			    },
			    error: function (err) {
			      	console.log(err);
			    }
			});

		}

		

	}


	function simpan() {

		var nim = $('#nim').val();
		var nama = $('#nama').val();
		var sex = $('#sex').val();
		var tahun = $('#tahun').val();
		var jurusan = $('#jurusan').val();
		var bayar = $('#bayar').val();
		var kodeStatus = $('#kodeStatus').val();
		var ket = $('#ket').val();
		var rp = convertToAngka($('#rp').val());
		var tgl = $('#tgl').val();
		var jam = $('#jam').val();

		var data = 'nim='+nim+'&nama='+nama+'&sex='+sex+'&tahun='+tahun+'&jurusan='+jurusan+'&bayar='+bayar+'&kodeStatus='+kodeStatus+'&ket='+ket+'&rp='+rp+'&tgl='+tgl+'&jam='+jam;

		$body = $("body");
		$body.addClass("loading");

		$.ajax({
		    url: "<?= base_url('ademik/spp2/validasiDataSPP2'); ?>",
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

	function convertToAngka(rupiah) {

		return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);

	}

	var rupiah = document.getElementById('rp');
    rupiah.addEventListener('keyup', function(e) {
        rupiah.value = formatRupiah(this.value, 'Rp. ');
    });
    
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
    }

</script>