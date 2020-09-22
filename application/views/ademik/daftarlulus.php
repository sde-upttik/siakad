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
			Daftar Mahasiswa Lulus dan Drop Out
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="breadcrumb-item"><a href="<?= $_SESSION['tamplate'] ?>">Daftar Mahasiswa Lulus dan Drop Out</a></li>
		</ol>
	</section>

	<!-- Main content -->
	<?php if ( $this->uri->segment(3) == '' ) { ?>

		<section class="content">
			<div class="row">
				<div class="col-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Daftar Mahasiswa Lulus/DO</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<a href="<?=base_url();?>ademik/Daftarlulus/formTambahLulusDO" class="btn btn btn-primary fa fa-plus"> Tambah Daftar Mahasiswa</a>
							<a href="<?=base_url();?>ademik/Daftarlulus/formPrcLulusDO" class="btn btn btn-primary fa fa-plus"> Pengiriman ALL</a>
							<table id="berita" class="table table-bordered table-striped table-responsive dataTable">
				                <thead>
									<tr>
				                		<th>NIM</th>
										<th>NAMA</th>
										<th>Tahun Angkatan</th>
										<th>Jenis Keluar</th>
										<th>Tanggal Keluar</th>
										<th>Keterangan</th>
										<th>Feeder</th>
										<th>Error Feeder</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>

									<?php

										foreach ($mhsw as $list) { ?>

											<tr>
												<th><?= $list->NIM ?></th>
												<th><?= $list->Name ?></th>
												<th><?= $list->TahunAkademik ?></th>
												<th><?= $list->ket_jenis_keluar ?></th>
												<th><?= date('d-m-Y',strtotime($list->tgl_keluar)) ?></th>
												<th><?= $list->ket ?></th>
												<th style="text-align: center;">
													<?php if ( $list->st_feeder <= 0 ) { ?>
														<span class='glyphicon glyphicon-remove' style='color: red;'></span>
													<?php } else { ?>
														<img src="<?=base_url();?>assets/images/ristekdikti.png" width="30px;">
													<?php } ?>
												</th>
												<th><?= $list->error_desc ?></th>
												<th>
													<a href="<?=base_url();?>ademik/daftarlulus/formEditLulusDO/<?=$list->NIM?>" class="btn btn btn-success fa fa-edit"> Edit</a>
													<!-- <button type="button" onclick="hapus(<?=$list->NIM?>)" class="btn btn btn-danger fa fa-trash">  Hapus</button> -->
												</th>
											</tr>

									<?php } ?>

								</tbody>
								<tfoot>
									<tr>
				                		<th>NIM</th>
										<th>NAMA</th>
										<th>Tahun Angkatan</th>
										<th>Jenis Keluar</th>
										<th>Tanggal Keluar</th>
										<th>Keterangan</th>
										<th>Feeder</th>
										<th>Error Feeder</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>
						<!-- /.box-body -->
					</div>

				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</section>

	<?php } elseif ( $this->uri->segment(3) == 'formTambahLulusDO' || $this->uri->segment(3) == 'validasiFormTambah' ) { ?>

		<section class="content">
			<div class="row">
				<div class="col-12">
					<div class="box">
			    	<div class="box-header">
	              		<h3 class="box-title">Form Input Data Mahasiswa Lulus/DO</h3>
	              		<hr size="10px">
	            	</div>

	            	<div class="box-body">
						<div class="row">
							<div class="col-12">
								<form action="" method="POST">
					            	<div class="form-group row">
									  	<label for="example-text-input" class="col-sm-2 col-form-label">No. Stambuk</label>
									  	<div class="col-sm-3">
									  		<input class="form-control" type="text" name="nim" id="nim" value="" placeholder="Input Nomor Stambuk">
									  		<input class="form-control" type="hidden" name="id_reg" id="id_reg" value="" placeholder="Input Nomor Stambuk">
									  	</div>
									  	<div class="col-sm-1">
									  		<button type="button" onclick="mencari()" class="btn btn btn-primary fa fa-search"> Search</button>
									  	</div>
									  	<label for="example-text-input" class="col-sm-2 col-form-label">Nama Mahasiswa</label>
									  	<div class="col-sm-4">
									  		<input class="form-control" type="text" name="nama" id="nama" value="" readonly>
									  	</div>
									</div>
									<div class="form-group row">
									  	<label class="col-sm-2 control-label">Jenis Keluar</label>
										<div class="col-sm-3">
											<select class="form-control select2" name="keluar" id="keluar">
												<option value="">--Pilih Jenis Keluar--</option>

	                    						<?php foreach ($jenis_keluar as $pilih) {

	                      							echo "<option value='".$pilih->ID."'>".$pilih->ket_jenis_keluar."</option>";

	                    						} ?>

											</select>
										</div>
									  	<div class="col-sm-1">
									  	</div>
									  	<label for="example-text-input" class="col-sm-2 col-form-label">Jurusan</label>
									  	<div class="col-sm-4">
									  		<input class="form-control" type="text" name="jurusan" id="jurusan" value="" readonly>
									  	</div>
									</div>
									<div class="form-group row">
										<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Keluar</label>
				            			<div class="col-sm-3">
				              				<div class="input-group">
	                    						<div class="input-group-addon">
	                      							<i class="fa fa-calendar"></i>
	                    						</div>
	                    						<input type="text" name="tgl_keluar" id="tgl_keluar" value="" class="form-control datepicker" />
	                  						</div>
				            			</div>
									  	<div class="col-sm-1">
									  	</div>
									  	<!-- <label for="example-text-input" class="col-sm-2 col-form-label">Status Mahasiswa</label>
									  	<div class="col-sm-4">
									  		<input class="form-control" type="text" name="status" id="status" value="" readonly>
									  		<input class="form-control" type="hidden" name="kodeStatus" id="kodeStatus" value="" readonly>
									  	</div> -->
									</div>
									<div class="form-group row">
									  	<label for="example-text-input" class="col-sm-2 col-form-label">Keterangan</label>
									  	<div class="col-sm-3">
											<textarea class="form-control" rows="3" name="ket" id="ket"></textarea>
									  	</div>
									</div>
									<div class="form-group row">
									  	<label for="example-text-input" class="col-sm-2 col-form-label">Nomor SK Yudisium</label>
				            			<div class="col-sm-3">
	                    					<input type="text" name="no_sk" id="no_sk" value="" class="form-control" />
				            			</div>
									</div>
									<div class="form-group row">
									  	<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal SK Yudisium</label>
				            			<div class="col-sm-3">
				              				<div class="input-group">
	                    						<div class="input-group-addon">
	                      							<i class="fa fa-calendar"></i>
	                    						</div>
	                    						<input type="text" name="tgl_sk" id="tgl_sk" value="" class="form-control datepicker" />
	                  						</div>
				            			</div>
									</div>
									<div class="form-group row bootstrap-timepicker">
									  	<label for="example-text-input" class="col-sm-2 col-form-label">IPK</label>
									  	<div class="col-sm-1">
	                    					<input type="text" name="ipk" id="ipk" value="" class="form-control" />
	                  					</div>
									</div>
									<div class="form-group row bootstrap-timepicker">
									  	<label for="example-text-input" class="col-sm-2 col-form-label">No Ijazah/No Sertifikat Profesi</label>
									  	<div class="col-sm-3">
	                    					<input type="text" name="no_ijazah" id="no_ijazah" value="" class="form-control" />
	                  					</div>
									</div>
									<div style="margin: 50px 0px 10px 218px">
										<button type="button" onclick="simpan('insert')" class="btn btn btn-success fa fa-save"> Simpan</button>
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

<?php } elseif ( $this->uri->segment(3) == 'formEditLulusDO' || $this->uri->segment(3) == 'validasiFormEdit' ) { ?>

		<section class="content">
			<div class="row">
				<div class="col-12">
					<div class="box">
			    	<div class="box-header">
	              		<h3 class="box-title">Form Input Data Mahasiswa Lulus/DO</h3>
	              		<hr size="10px">
	            	</div>

	            	<div class="box-body">
						<div class="row">
							<div class="col-12">
								<form action="" method="POST">
					            	<div class="form-group row">
									  	<label for="example-text-input" class="col-sm-2 col-form-label">No. Stambuk</label>
									  	<div class="col-sm-3">
									  		<input class="form-control" type="text" name="nim" id="nim" value="<?= $keluar->NIM ?>" placeholder="Input Nomor Stambuk">
									  		<input class="form-control" type="hidden" name="id_reg" id="id_reg" value="<?= $keluar->id_reg_pd ?>" placeholder="Input Nomor Stambuk">
									  	</div>
									  	<div class="col-sm-1">
									  	</div>
									  	<label for="example-text-input" class="col-sm-2 col-form-label">Nama Mahasiswa</label>
									  	<div class="col-sm-4">
									  		<input class="form-control" type="text" name="nama" id="nama" value="<?= $keluar->Name ?>" readonly>
									  	</div>
									</div>
									<div class="form-group row">
									  	<label class="col-sm-2 control-label">Jenis Keluar</label>
										<div class="col-sm-3">
											<select class="form-control select2" name="keluar" id="keluar">

												<?php if ( empty($keluar->ket_jenis_keluar) ) { ?>

	                              					<option value="">--Pilih Jenis Keluar--</option>

	                            				<?php } else { ?>

													<option value="<?= $keluar->id_jenis_keluar ?>"><?= $keluar->ket_jenis_keluar ?></option>

	                    						<?php }

	                    						foreach ($jenis_keluar as $pilih) {

	                      							echo "<option value='".$pilih->ID."'>".$pilih->ket_jenis_keluar."</option>";

	                    						} ?>

											</select>
										</div>
									  	<div class="col-sm-1">
									  	</div>
									  	<label for="example-text-input" class="col-sm-2 col-form-label">Jurusan</label>
									  	<div class="col-sm-4">
									  		<input class="form-control" type="text" name="jurusan" id="jurusan" value="<?= $keluar->Nama_Indonesia ?>" readonly>
									  	</div>
									</div>
									<div class="form-group row">
										<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Keluar</label>
				            			<div class="col-sm-3">
				              				<div class="input-group">
	                    						<div class="input-group-addon">
	                      							<i class="fa fa-calendar"></i>
	                    						</div>
	                    						<input type="text" name="tgl_keluar" id="tgl_keluar" value="<?= date('d-m-Y', strtotime($keluar->tgl_keluar)) ?>" class="form-control datepicker" />
	                  						</div>
				            			</div>
									  	<div class="col-sm-1">
									  	</div>
									  	<!-- <label for="example-text-input" class="col-sm-2 col-form-label">Status Mahasiswa</label>
									  	<div class="col-sm-4">
									  		<input class="form-control" type="text" name="status" id="status" value="" readonly>
									  		<input class="form-control" type="hidden" name="kodeStatus" id="kodeStatus" value="" readonly>
									  	</div> -->
									</div>
									<div class="form-group row">
									  	<label for="example-text-input" class="col-sm-2 col-form-label">Keterangan</label>
									  	<div class="col-sm-3">
											<textarea class="form-control" rows="3" name="ket" id="ket"><?= $keluar->ket ?></textarea>
									  	</div>
									</div>
									<div class="form-group row">
									  	<label for="example-text-input" class="col-sm-2 col-form-label">Nomor SK Yudisium</label>
				            			<div class="col-sm-3">
	                    					<input type="text" name="no_sk" id="no_sk" value="<?= $keluar->no_sk_yudisium ?>" class="form-control" />
				            			</div>
									</div>
									<div class="form-group row">
									  	<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal SK Yudisium</label>
				            			<div class="col-sm-3">
				              				<div class="input-group">
	                    						<div class="input-group-addon">
	                      							<i class="fa fa-calendar"></i>
	                    						</div>
	                    						<input type="text" name="tgl_sk" id="tgl_sk" value="<?= date('d-m-Y', strtotime($keluar->tgl_sk_yudisium)) ?>" class="form-control datepicker" />
	                  						</div>
				            			</div>
									</div>
									<div class="form-group row bootstrap-timepicker">
									  	<label for="example-text-input" class="col-sm-2 col-form-label">IPK</label>
									  	<div class="col-sm-1">
	                    					<input type="text" name="ipk" id="ipk" value="<?= $keluar->ipk ?>" class="form-control" />
	                  					</div>
									</div>
									<div class="form-group row bootstrap-timepicker">
									  	<label for="example-text-input" class="col-sm-2 col-form-label">No Ijazah/No Sertifikat Profesi</label>
									  	<div class="col-sm-3">
	                    					<input type="text" name="no_ijazah" id="no_ijazah" value="<?= $keluar->nomor_ijazah ?>" class="form-control" />
	                  					</div>
									</div>
									<div style="margin: 50px 0px 10px 218px">
										<button type="button" onclick="simpan('update')" class="btn btn btn-success fa fa-save"> Simpan</button>
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

	<?php } elseif ( $this->uri->segment(3) == 'formPrcLulusDO' || $this->uri->segment(3) == 'prcLulusDO' || $this->uri->segment(3) == 'tampilPrcLulusDO' ) { ?>

		<section class="content">
			<div class="row">
				<div class="col-12">
					<div class="box">
			    	<div class="box-header">
	              		<h3 class="box-title">PRC Data Mahasiswa Lulus/DO</h3>
	              		<hr size="10px">
	            	</div>
	            	<div class="box-body">
						<div class="row">
							<div class="col-12" id="pesan">
								<!-- <a href="<?=base_url();?>ademik/Daftarlulus/prcLulusDO" class="btn btn btn-primary fa fa-plus"> Proses</a>
								<br /> -->
								<button type="button" onclick="proses()" class="btn btn btn-success fa fa-save"> Proses Insert</button>
								<button type="button" onclick="prcupdate()" class="btn btn btn-success fa fa-save"> Proses Update</button>
								<br />

								<div id=hasil style="margin-top: 15px">
									
								</div>

								<!-- <table>
									<tr>

										<?php
										if ( empty($hasil) ) {

										} else {

											$jumlah = count($hasil);

											for ($i=0; $i < $jumlah ; $i++) {

												echo $hasil[$i].'<br/>';
											}

										} ?>

									</tr>
								</table> -->
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

	<?php } ?>
	<!-- /.content -->

</div>

<script type="text/javascript">

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
			    url: "<?= base_url('ademik/daftarlulus/mencariDataMhsw'); ?>/"+nim,
			    type: 'POST',
			    dataType: 'json',
			    cache : false,
			    success: function(data){
			      	$body.removeClass("loading");

					if ( data=='' ) {

						swal({   
							title: 'Peringatan',   
							type: 'warning',    
							html: true, 
							text: 'Stambuk yang Anda Masukan Tidak Sesuai',
							confirmButtonColor: '#f7cb3b',   
						});

					} else {

						$('#nama').val(data['mhsw'].Name);
						$('#id_reg').val(data['mhsw'].id_reg_pd);
						$('#jurusan').val(data['mhsw'].Nama_Indonesia);
						$('#ipk').val(data['mhsw'].IPK);
						$('#tgl_sk').val(data['tgl_yudisium']);
						$('#no_sk').val(data['mhsw'].NomorSKYudisium);
						$('#no_ijazah').val(data['mhsw'].NomerIjazah);

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