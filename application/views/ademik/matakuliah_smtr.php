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
			Mata Kuliah Per-Semester
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="breadcrumb-item"><a href="<?= $_SESSION['tamplate'] ?>">Matakuliah Per-Semester</a></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Mata Kuliah Per-Semester
							<br>
							<span style="font-size: 11px; color: red;"><i>(*Penting : Menu ini digunakan untuk mendaftarkan Mata Kuliah ke Kurikulumnya, baik untuk ke Feeder Dikti maupun Siakad)</i></span>
						</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<form class="form-horizontal" action="<?=base_url();?>ademik/Matakuliah_smtr/getDataTabel" method="POST">
							<div class="form-group row">
								<label class="col-sm-1 control-label">Pilih Jurusan</label>
								<div class="col-sm-4">
									<select class="form-control select2" name="dataSearch" id="dataSearch">
										<option value="">--Pilih Jurusan--</option>
										<?php
											foreach ($jurusan as $pilih) {
												echo "<option value='".$pilih['Kode']."-".$pilih['Nama_Indonesia']."'>".$pilih['Kode']." -- ".$pilih['Nama_Indonesia']."</option>";
											}
										?>
									</select>
								</div>
								<div class="col-sm-2">
									<input class="btn btn-flat btn-info" type="submit" id="search" name="search" value="Search">
								</div>
							</div>
						</form>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
				<?php if ( empty($namaJurusan) ) {

				} else { ?>
					<!-- Awal Table -->
		  			<div class="box">
			            <!-- Minggu -->
			            <div class="box-header">
			              <h3 class="box-title">KURIKULUM</h3>
			            </div>
			            <!-- /.box-header -->
			            <div class="box-body">
		              		<dl class="dl-horizontal">
		                		<dt>Jurusan</dt>
		                		<dd><?= $namaJurusan ?></dd>
		                		<dt>Nama Kurikulum</dt>
		                		<dd><?= $kurikulum->Nama ?></dd>
		                		<dt>Tahun</dt>
		                		<dd><?= $kurikulum->Tahun ?></dd>
		                		<dt>Nama Semester</dt>
		                		<dd><?= $kurikulum->Sesi ?></dd>
		                		<dt>Jumlah Semester</dt>
		                		<dd><?= $kurikulum->JmlSesi ?></dd>
		                		<dt>ID Kurikulum</dt>
		                		<dd><?= $kurikulum->IdKurikulum ?></dd>
		                		<dt>Status Dikti</dt>
		                		
		                		<?php if ( empty($kurikulum->id_kurikulum) ) { ?>
		                			<dd><span style="color: red;">Belum Terdaftar di PDDIKTI </span><span style="font-size: 10px;"><i>(*Silakan Menggirim Kurikulum ini ke PDDIKTI Melalui Menu Kurikulum)</i></span></dd>
		                		<?php } else { ?>
		                			<dd><img src="<?=base_url();?>assets/images/ristekdikti.png"></dd>
		                		<?php } ?>

		              		</dl>
			            </div>
			            <hr>

			            <?php if ( $this->uri->segment(3) == 'getDataTabel' ) { ?>

				            <div style="margin: 0px 0px 30px 25px;">
				            	<div>
									<div class="form-group row" style="margin: 0px 0px 0px 0px">
						            	<form method="POST" action="<?=base_url();?>ademik/report/Report/cetak_matkul_per_semester">
											<input type="hidden" name="idKurikulum" value="<?= $kurikulum->IdKurikulum ?>">
											<input type="hidden" name="namaJurusan" value="<?= $namaJurusan ?>">
											<button style="margin-right: 5px;" type="submit" class="btn btn btn-success fa fa-print"> Print</button>
										</form>
					                	<a href="<?=base_url();?>ademik/Matakuliah_smtr/formTambah/<?= $kurikulum->KodeJurusan ?>" class="btn btn btn-primary fa fa-plus"> Tambah Daftar Mata Kuliah ke Kurikulum</a>
					                	<!-- <button style="margin: 0px 5px 0px 5px; type="button" class="btn btn btn-default fa fa-file-excel-o"> Download Excel</button>
					                	<button type="button" class="btn btn btn-danger fa fa-mail-forward"> Import Data</button> -->
			                		</div>
			            		</div>
				            </div>

				            <div class="row col-md-12">

				            	<?php
				            		$a=1;
				            		for ( $i=1; $i<=$tabel->JmlTabel; $i++ ) { ?>

					            	<div class="col-md-6">
					            		<div class="box-header">
					              			<h3 class="box-title">SEMESTER <?=$i?></h3>
					            		</div>
							            <div class="box-body">
								            <table id="matakuliah<?=$a++;?>" class="table table-bordered table-striped table-responsive dataTable">
								                <thead>
													<tr>
														<th>Kode MK</th>
														<th>Nama MK</th>
														<th>SKS</th>
														<th>Wajib</th>
														<th>Terdaftar</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>

													<?php foreach ($detailTabel[$i] as $tampil) { ?>

														<tr>
															<th><?= $tampil->Kode ?></th>
															<th><?= $tampil->Nama_Indonesia ?></th>
															<th><?= $tampil->SKS ?></th>
															<th>
																<?php if ( $tampil->Wajib == 'N' ) {} else { echo "<span class='glyphicon glyphicon-ok' style='color: green;'></span>"; } ?>
															</th>
															<th>
																<?php if ( $tampil->st_feeder != 3 or empty($kurikulum->id_kurikulum) ) { ?>
																	<span class='glyphicon glyphicon-remove' style='color: red;'></span>
																<?php } else { ?>
																	<img src="<?=base_url();?>assets/images/ristekdikti.png" width="25px;">
																<?php } ?>
															</th>
															<th>
																<?php if ( $tampil->st_feeder != 3 or empty($kurikulum->id_kurikulum) ) { ?>
																	
																	<button type="button" onclick="hapus('<?= $tampil->ID ?>','1')" class="btn btn-sm btn-danger fa fa-trash" title="Menghapus Mata Kuliah dari Kurikulum"></button>

																	<button type="button" onclick="update('<?= $tampil->ID ?>')" class="btn btn-sm btn-info fa fa-refresh" title="Mengirim Kembali Mata Kuliah Ke Kurikulum"></button>

																<?php } else { ?>

																	<button type="button" onclick="hapus('<?= $tampil->ID ?>','2')" class="btn btn-sm btn-danger fa fa-trash" title="Menghapus Mata Kuliah dari Kurikulum"></button>

																<?php } ?>
															</th>
														</tr>

													<?php } ?>

												</tbody>
												<tfoot>
													<tr>
														<th>Kode MK</th>
														<th>Nama MK</th>
														<th>SKS</th>
														<th>Wajib</th>
														<th>Terdaftar</th>
														<th>Action</th>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>

								<?php } ?>

							</div>
					      	<div class="keterangan" style="margin: 5px 0px 15px 27px">
					      		<b style="color: blue;">Keterangan :</b> <br />
					      		<span class='glyphicon glyphicon-asterisk' style='color: orange;'></span> Mata Kuliah Wajib <br />
					      		<span class='glyphicon glyphicon-remove' style='color: red;'></span> Mata Kuliah Tidak Aktif
					      	</div>

					    <?php } elseif ( $this->uri->segment(3) == 'formTambah' ) { ?>

					    	<div class="box-header">
			              		<h3 class="box-title">DAFTARKAN MATA KULIAH KE KURIKULUM</h3>
			            	</div>

			            	<div class="box-body">
      							<div class="row">
        							<div class="col-12">
            							<form action="" method="">
							            	<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Mata Kuliah</label>
											  	<div class="col-sm-4">
											  		<select class="form-control select2" name="id" id="id">
														<option value="">--Pilih Mata Kuliah--</option>

														<?php 
															foreach ($matakuliah as $mk) {
																echo "<option value='".$mk['ID']." ".$mk['id_mk']."'>".$mk['Kode']." -- ".$mk['Nama_Indonesia']." (".$mk['SKS']." SKS)</option>";
															}
														?>

													</select>
											  	</div>
											</div>
											<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Urutan di Transkip</label>
											  	<div class="col-sm-1">
													<input class="form-control" type="number" value="0" min="0" max="999" name="urutan" id="urutan">
											  	</div>
											</div>
											<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Semester</label>
											  	<div class="col-sm-1">
													<input class="form-control" type="number" value="1" min="1" max="99" name="semester" id="semester">
											  	</div>
											</div>
											<div class="form-group row">
											  	<div class="demo-checkbox" style="margin: 15px 0px 0px 235px">
											      	<input type="checkbox" id="md_checkbox_21" class="filled-in chk-col-red" name="wajib" />
											      	<label for="md_checkbox_21">Wajib</label>
											    </div>
											</div>
											<div class="form-group row">
											  	<label class="col-sm-2 control-label">Ubah Kurikulum</label>
												<div class="col-sm-4">
													<select class="form-control select2" name="kurikulum" id="kurikulum">
														<option value="<?= $kurikulum->IdKurikulum ?> <?= $kurikulum->id_kurikulum ?>"><?=$kurikulum->IdKurikulum?> -- <?= $kurikulum->Nama ?></option>

														<?php
															foreach ($dataKurikulum as $kurikulum) {
																echo "<option value='".$kurikulum['IdKurikulum']." ".$kurikulum['id_kurikulum']."'>".$kurikulum['IdKurikulum']." -- ".$kurikulum['Nama']."</option>";
															}
														?>

													</select>
												</div>
											</div>
											<div style="margin: 50px 0px 10px 218px">
												<button type="button" onclick="simpan()" class="btn btn btn-success fa fa-save"> Simpan</button>
							                	<button type="reset" class="btn btn btn-danger fa fa-refresh"> Reset</button>
							                	<!-- <button type="button" class="btn btn btn-default fa fa-tag"> Prasyarat</button> -->
											</div>
										</form>
										<form method="POST" action="<?= base_url('ademik/matakuliah_smtr/getDataTabel'); ?>">
											<input type="hidden" name="kodeJur" value="<?= $kodeJurusan ?>">
											<input type="hidden" name="namaJurusan" value="<?= $namaJurusan ?>">
											<button type="submit" class="btn btn btn-warning fa fa-mail-reply"> Kembali</button>
										</form>
            						</div>
            							<!-- /.col -->
          						</div>
          							<!-- /.row -->
        					</div>

						<?php } elseif(isset($pageweb) and $pageweb=='formEdit'){ ?>

        				<?php } elseif ( $this->uri->segment(3) == 'formPrasyarat' ) { ?>

						<?php } ?>

				    </div>
		  			<!-- Akhir Table -->
		  		<?php } ?> 

			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>

<script type="text/javascript">

	function simpan(act) {

		var id = $('#id').val();
		var urutan = $('#urutan').val();
		var semester = $('#semester').val();
		var kurikulum = $('#kurikulum').val();

		if ( $('#md_checkbox_21').is(':checked') ) {
			var wajib = 'Y';
		} else {
			var wajib = 'N';
		}

		var data = 'act='+act+'&id='+id+'&urutan='+urutan+'&semester='+semester+'&wajib='+wajib+'&kurikulum='+kurikulum;

		$body = $("body");
		$body.addClass("loading");

		$.ajax({
			url: "<?= base_url('ademik/matakuliah_smtr/validasiForm'); ?>",
			data: data,
			type: 'POST',
			dataType: 'json',
			cache : false,
			success: function(respon){
				$body.removeClass("loading");

				if ( respon.ket == 'error' ) {
					console.log(respon.pesan);
					swal({   
						title: 'Peringatan',   
						type: 'warning',    
						html: true, 
						text: respon.pesan,
						confirmButtonColor: '#f7cb3b',   
					});

				} else if (respon.ket == 'sukses') {
					swal({   
						title: 'Pesan',   
						type: 'success',    
						html: true, 
						text: respon.pesan,
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

	function update(id){
		swal({
	        title: "Peringatan",
	        text: "Anda Yakin Untuk Mengirim Mata Kuliah ini ke Kurikulum yang Aktif?",
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

				var dataUpdate = 'id='+id;

		    	$.ajax({
					url : "<?= base_url('ademik/matakuliah_smtr/setUpdate'); ?>",
					type: "POST",
					data: dataUpdate,
					dataType: "JSON",
					success: function(hasil) {
						$body.removeClass("loading");

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

	function hapus(id,level){
		swal({
	        title: "Peringatan",
	        text: "Anda Yakin Untuk Menghapus Mata Kuliah ini dari Kurikulum?",
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

				var dataHapus = 'id='+id+'&level='+level;

		    	$.ajax({
					url : "<?= base_url('ademik/matakuliah_smtr/setDeleteData'); ?>",
					type: "POST",
					data: dataHapus,
					dataType: "JSON",
					success: function(hasil) {
						$body.removeClass("loading");

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