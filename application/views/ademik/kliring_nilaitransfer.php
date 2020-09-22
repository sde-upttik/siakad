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
			Kliring Nilai Transfer
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="breadcrumb-item"><a href="<?= $_SESSION['tamplate'] ?>">Kliring Nilai</a></li>
		</ol>
	</section>

	<!-- Main content untuk awal daftar kliring -->
	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Kliring dan Managemen Nilai Mahasiswa</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<form class="form-horizontal" action="<?=base_url();?>ademik/kliring_nilaitransfer/getDataMahasiswa" method="POST">
							<div class="form-group row">
								<label class="col-sm-2 control-label">NIM Mahasiswa</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="dataSearch" value="" name="dataSearch" placeholder="Silahkan Input" />
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

				<?php if ( empty($detailmhsw) ) { ?>

				<?php } else { ?>
					<!-- Awal Table -->
		  			<div class="box">
			            <!-- Minggu -->
			            <div class="box-header">
			              <h3 class="box-title">Kliring Nilai Mahasiswa</h3>
			            </div>
			            <div class="box-body">
		              		<dl class="dl-horizontal">
		                		<dt>NIM</dt>
		                		<dd><?= $detailmhsw->NIM ?></dd>
		                		<dt>Nama Mahasiswa</dt>
		                		<dd><?= $detailmhsw->Name ?></dd>
		                		<dt>Jurusan</dt>
		                		<dd><?= $detailmhsw->KodeJurusan ?>--<?= $detailmhsw->Nama_Indonesia ?></dd>
								<dt>Status Awal</dt>
		                		<dd>

		                			<?php if ( $detailmhsw->StatusAwal == 'P' ) {
		                				echo "Pindahan";
		                			} elseif ( $detailmhsw->StatusAwal == 'J' ) {
		                				echo "Alih Jenjang";
		                			} elseif ( $detailmhsw->StatusAwal == 'B' ) {
		                				echo "Peserta Didik Baru";
		                			} ?>
		                				
		                		</dd>
		              		</dl>
			            </div>
						<hr>

						<?php if ( empty($detailmhsw->id_reg_pd) or empty($detailmhsw->id_pd) ){ ?>

							<div style="margin-left: 75px;">Mahasiswa Tidak Dapat Kliring Data karena Mahasiswa belum terdaftar di PDDIKTI</div>

						<?php } elseif ( $detailmhsw->StatusAwal != 'P' AND $detailmhsw->StatusAwal != 'J' ) { ?>
							
							<div style="margin-left: 75px;">Mahasiswa ini Bukan Mahasiswa Pindahan dan Alih Jenjang </div>

						<?php } else { ?>

				            <div style="margin-left: 75px;">
				            	<button type="button" data-toggle="modal" data-target="#modal-nilai-transfer" class="btn btn btn-success fa fa-print"> Tambah Nilai Transfer</button>
							</div>

				            <div class="row col-md-12">	
					            <div class="col-md-12">
					            	<div class="box-header">
					              		<h3 class="box-title">Daftar Nilai</h3>
					            	</div>
							        <div class="box-body">
								        <table id="matakuliah" class="table table-bordered table-striped table-responsive dataTable">
							                <thead>
												<tr>
													<th>Kode MK Asal</th>
													<th>Nama MK Asal</th>
													<th>Bobot SKS Asal</th>
													<th>Nilai Asal</th>
													<th>Kode MK diakui</th>
													<th>Nama MK diakui</th>
													<th>Bobot MK</th>
													<th>Nilai diakui</th>
													<th>Nilai index</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>

												<?php if ( empty($record) ) { ?>

												<?php } else { 

													foreach ($record as $tampil ) { ?>

														<tr>
															<td><?= $tampil->KodeMK_asal ?></td>
															<td><?= $tampil->NamaMK_asal ?></td>
															<td><?= $tampil->SKS_asal ?></td>
															<td><?= $tampil->GradeNilai_asal ?></td>
															<td><?= $tampil->KodeMK ?></td>
															<td><?= $tampil->NamaMK ?></td>
															<td><?= $tampil->SKS ?></td>
															<td><?= $tampil->GradeNilai ?></td>
															<td><?= $tampil->Bobot ?></td>
															<td>
																
																<?php if ( empty($tampil->id_transfer) ) { ?>

																	<button type="button" data-toggle="modal" class="btn btn-xs btn-warning" onclick="getEdit('<?= $tampil->ID ?>')">Kirim</button>
																	<button type="button" class="btn btn-xs btn-danger" onclick="actDelete('<?= $tampil->id_transfer ?>','<?=$tampil->ID ?>')">Hapus</button>

																<?php } else { ?>

																	<button type="button" data-toggle="modal" onclick="getEdit('<?= $tampil->ID ?>')" class="btn btn-xs btn-success" onclick="">Edit</button>
																	<button type="button" class="btn btn-xs btn-danger" onclick="actDelete('<?= $tampil->id_transfer ?>','<?=$tampil->ID ?>')">Hapus</button>

																<?php } ?>

															</td>
														</tr>

												<?php }

												} ?>

											</tbody>
											<tfoot>
												<tr>
													<th>Kode MK Asal</th>
													<th>Nama MK Asal</th>
													<th>Bobot SKS Asal</th>
													<th>Nilai Asal</th>
													<th>Kode MK diakui</th>
													<th>Nama MK diakui</th>
													<th>Bobot MK</th>
													<th>Nilai diakui</th>
													<th>Nilai index</th>
													<th>Action</th>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
					      	<div class="keterangan" style="margin: 5px 0px 15px 27px">
					      		<b style="color: blue;">Keterangan :</b> <br />
					      		<span class='glyphicon glyphicon-asterisk' style='color: orange;'></span> Mata Kuliah di Input dari Kliring <br />
					      		<!--<span class='glyphicon glyphicon-remove' style='color: red;'></span> Mata Kuliah Tidak Aktif-->
					      	</div>

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

	<!-- modal tambah -->
	<div class="modal fade" id="modal-nilai-transfer">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myLargeModalLabel">Tambah Nilai Transfer</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
					<!-- Main content untuk isi data kliring -->
					<section class="content">
						<div class="row">
							<div class="col-12">
								<div class="box">
									<div class="box-header">
										<h3 class="box-title">Input Dengan Benar Nilai Transfer</h3>
									</div>
									<!-- /.box-header -->
									<div class="box-body">
										<form action="" method="POST">
											<div class="form-group row">
											  	<label for="nim" class="col-md-3 col-form-label">NIM</label>
												<div class="col-md-3">
													<input class="form-control" type="text" id="nim" name="nim" value="<?=$detailmhsw->NIM?>" readonly>
													<input class="form-control" type="hidden" id="id_reg" name="id_reg" value="<?=$detailmhsw->id_reg_pd?>" readonly>
													<input class="form-control" type="hidden" id="program" name="program" value="<?=$detailmhsw->KodeProgram?>" readonly>
												</div>
											</div>
											<div class="form-group row">
												<label for="name" class="col-md-3 col-form-label">Nama Mahasiswa</label>
												<div class="col-md-6">
													<input class="form-control" type="text" id="nama" name="nama" value="<?=$detailmhsw->Name?>" readonly>
												</div>
											</div>
											<div class="form-group row">
												<label for="name" class="col-md-3 col-form-label">Kode MK Asal</label>
												<div class="col-md-4">
													<input class="form-control" type="text" id="kodeMKasal" name="kodeMKasal" value="" >
												</div>
											</div>
											<div class="form-group row">
												<label for="name" class="col-md-3 col-form-label">Nama MK Asal</label>
												<div class="col-md-6">
													<input class="form-control" type="text" id="namaMKasal" name="namaMKasal" value="" >
												</div>
											</div>
											<div class="form-group row">
												<label for="name" class="col-md-3 col-form-label">SKS Asal</label>
												<div class="col-md-2">
													<input class="form-control" type="text" id="SKSasal" name="SKSasal" value="" >
												</div>
											</div>
											<div class="form-group row">
												<label for="name" class="col-md-3 col-form-label">Nilai Huruf Asal</label>
												<div class="col-md-2">
													<input class="form-control" type="text" id="grade_asal" name="grade_asal" value="" >
												</div>
											</div>
											<div class="form-group row">
												<label for="tugasakhir1" class="col-md-3 col-form-label">Mata Kuliah</label>
												<div class="col-md-9">
												  	<select class="form-control select2" style="width: 100%;" id="id_mk" name="id_mk">
												  		<option>-- PILIH MATAKULIAH --</option>

													  	<?php foreach ($matakuliah as $tampil) { ?>
													  		
													  		<option value="<?= $tampil->id_mk.' - '.$tampil->SKS.' - '.$tampil->Kode.' - '.$tampil->Nama_Indonesia.' - '.$tampil->IDMK ?>" ><?= $tampil->mk ?></option>

													  	<?php } ?>

													</select>
												</div>
											</div>
											<div class="form-group row">
												<label for="predikat" class="col-md-3 col-form-label">Nilai Huruf diakui</label>
												<div class="col-md-3">
													<select class="form-control select2" style="width: 100%;" id="grade" name="grade">
														<option>-- PILIH NILAI --</option>

													  	<?php foreach ($nilai as $tampil) { ?>
													  		
													  		<option value="<?= $tampil->Nilai.' - '.$tampil->Bobot ?>" ><?= $tampil->nilaitampil ?></option>

													  	<?php } ?>

													</select>
												</div>
											</div>
											<!-- <div class="form-group row">
												<label for="name" class="col-md-3 col-form-label">Nilai Angka diakui</label>
												<div class="col-md-2">
													<input class="form-control" type="text" id="nilai_diakui" name="nilai_diakui" value="" >
												</div>
											</div> -->
											<div class="form-group row">
										    	<label for="example-text-input" class="col-sm-3 col-form-label">NotActive</label>
										    	<div class="col-sm-9">
										      		<input type="checkbox" id="md_checkbox_23" class="filled-in chk-col-red" name="notactive" />
										      		<label for="md_checkbox_23">Kosongkan jika ingin mengaktifkan matakuliah</label>
										      	</div>
										    </div>
											<div class="form-group row">
												<div class="col-md-12" style="text-align: center;">
													<input type="button" onclick="simpan('add')" class="btn bg-olive" name="addmodul_btn" value="Simpan Nilai Transfer"/>
												</div>
											</div>
										</form>
									</div>
									<!-- /.box-body -->
								</div>
								<!-- /.box -->
								<div class="modal-footer">
									<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
								</div>
							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->
					</section>
					<!-- /.content -->
				</div>

			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

	<!-- modal edit -->
	<div class="modal fade" id="modal-edit-transfer">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myLargeModalLabel">Edit Nilai Transfer</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
					<!-- Main content untuk isi data kliring -->
					<section class="content">
						<div class="row">
							<div class="col-12">
								<div class="box">
									<div class="box-header">
										<h3 class="box-title">Input Dengan Benar Nilai Transfer</h3>
									</div>
									<!-- /.box-header -->
									<div class="box-body">
										<form action="" method="POST">
											<div class="form-group row">
											  	<label for="nim" class="col-md-3 col-form-label">NIM</label>
												<div class="col-md-3">
													<input class="form-control" type="text" id="nim_edit" name="nim_edit" value="<?=$detailmhsw->NIM?>" readonly>
													<input class="form-control" type="hidden" id="id_transfer" name="id_transfer" value="" readonly>
													<input class="form-control" type="hidden" id="id_reg_edit" name="id_reg_edit" value="<?=$detailmhsw->id_reg_pd?>">
													<input class="form-control" type="hidden" id="id" name="id" value="">
													<input class="form-control" type="hidden" id="program_edit" name="program_edit" value="<?=$detailmhsw->KodeProgram?>">
												</div>
											</div>
											<div class="form-group row">
												<label for="name" class="col-md-3 col-form-label">Nama Mahasiswa</label>
												<div class="col-md-6">
													<input class="form-control" type="text" id="nama_edit" name="nama_edit" value="<?=$detailmhsw->Name?>" readonly>
												</div>
											</div>
											<div class="form-group row">
												<label for="name" class="col-md-3 col-form-label">Kode MK Asal</label>
												<div class="col-md-4">
													<input class="form-control" type="text" id="kodeMKasal_edit" name="kodeMKasal_edit" value="" >
												</div>
											</div>
											<div class="form-group row">
												<label for="name" class="col-md-3 col-form-label">Nama MK Asal</label>
												<div class="col-md-6">
													<input class="form-control" type="text" id="namaMKasal_edit" name="namaMKasal_edit" value="" >
												</div>
											</div>
											<div class="form-group row">
												<label for="name" class="col-md-3 col-form-label">SKS Asal</label>
												<div class="col-md-2">
													<input class="form-control" type="text" id="SKSasal_edit" name="SKSasal_edit" value="" >
												</div>
											</div>
											<div class="form-group row">
												<label for="name" class="col-md-3 col-form-label">Nilai Huruf Asal</label>
												<div class="col-md-2">
													<input class="form-control" type="text" id="grade_asal_edit" name="grade_asal_edit" value="" >
												</div>
											</div>
											<div class="form-group row">
												<label for="tugasakhir1" class="col-md-3 col-form-label">Mata Kuliah</label>
												<div class="col-md-9">
												  	<select class="form-control select2" style="width: 100%;" id="id_mk_edit" name="id_mk_edit">

													</select>
												</div>
											</div>
											<div class="form-group row">
												<label for="predikat" class="col-md-3 col-form-label">Nilai Huruf diakui</label>
												<div class="col-md-3">
													<select class="form-control select2" style="width: 100%;" id="grade_edit" name="grade_edit">

													</select>
												</div>
											</div>
											<div class="form-group row">
										    	<label for="example-text-input" class="col-sm-3 col-form-label">NotActive</label>
										    	<div class="col-sm-9">
										      		<input type="checkbox" id="md_checkbox_22" class="filled-in chk-col-red" name="notactive" />
										      		<label for="md_checkbox_22">Kosongkan jika ingin mengaktifkan matakuliah</label>
										      	</div>
										    </div>
											<div class="form-group row">
												<div class="col-md-12" style="text-align: center;">
													<input type="button" onclick="simpan('update')" class="btn bg-olive" name="addmodul_btn" value="Simpan Nilai Transfer"/>
												</div>
											</div>
										</form>
									</div>
									<!-- /.box-body -->
								</div>
								<!-- /.box -->
								<div class="modal-footer">
									<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
								</div>
							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->
					</section>
					<!-- /.content -->
				</div>

			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

</div>

<script type="text/javascript">

	function simpan(act) {


		var nim, id_reg, kodeMKasal, namaMKasal, SKSasal, grade_asal, id_mk, grade, nilai_diakui, program, id_transfer, id;

		if ( act == 'add' ) {

			nim = $('#nim').val();
			id_reg = $('#id_reg').val();
			kodeMKasal = $('#kodeMKasal').val();
			namaMKasal = $('#namaMKasal').val();
			SKSasal = $('#SKSasal').val();
			grade_asal = $('#grade_asal').val();
			id_mk = $('#id_mk').val();
			grade = $('#grade').val();
			program = $('#program').val();

			if ($('#md_checkbox_23').is(":checked")){
				notactive = 'Y';
			}else{
				notactive = 'N';
			}

		} else if ( act == 'update' ) {

			id = $('#id').val();
			nim = $('#nim_edit').val();
			id_reg = $('#id_reg_edit').val();
			id_transfer = $('#id_transfer').val();
			kodeMKasal = $('#kodeMKasal_edit').val();
			namaMKasal = $('#namaMKasal_edit').val();
			SKSasal = $('#SKSasal_edit').val();
			grade_asal = $('#grade_asal_edit').val();
			id_mk = $('#id_mk_edit').val();
			grade = $('#grade_edit').val();
			program = $('#program_edit').val();

			if ($('#md_checkbox_22').is(":checked")){
				notactive = 'Y';
			}else{
				notactive = 'N';
			}

		}

		var data = 'act='+act+'&nim='+nim+'&id_reg='+id_reg+'&kodeMKasal='+kodeMKasal+'&namaMKasal='+namaMKasal+'&SKSasal='+SKSasal+'&grade_asal='+grade_asal+'&id_mk='+id_mk+'&grade='+grade+'&program='+program+'&id_transfer='+id_transfer+'&id='+id+'&notactive='+notactive;


		$body = $("body");
		$body.addClass("loading");

		$.ajax({
			url: "<?= base_url('ademik/kliring_nilaitransfer/validasiform'); ?>",
			data: data,
			type: 'POST',
			dataType: 'json',
			cache : false,
			success: function(respon){
				$body.removeClass("loading");
				console.log(respon);
				if ( respon.ket == 'error' ) {
					//console.log(respon.pesan);
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


	function getEdit(id) {

		$body = $("body");
		$body.addClass("loading");

	  	$.ajax({
	    	url : "<?= base_url('ademik/kliring_nilaitransfer/getDataEdit'); ?>/" +id,
	    	type: "GET",
	    	dataType: "JSON",
	    	success: function(data) {
	    		$body.removeClass("loading");

	    		console.log(data);

	    		$('#id').val(data.ID);
	    		$('#id_transfer').val(data.id_transfer);
	        	$('#kodeMKasal_edit').val(data.KodeMK_asal);
	        	$('#namaMKasal_edit').val(data.NamaMK_asal);
				$('#SKSasal_edit').val(data.SKS_asal);
				$('#grade_asal_edit').val(data.GradeNilai_asal);
				$('#id_mk_edit')
			        .append($("<option></option>")
			        .attr("value",data.mk_value)
			        .attr('selected','selected')
			        .text(data.mk_tampil));

			    $('#grade_edit')
			        .append($("<option></option>")
			        .attr("value",data.nilaivalue)
			        .attr('selected','selected')
			        .text(data.nilaitampil));

				if ( data.NotActive == 'N' ) {
					$('#md_checkbox_21').attr('checked','checked');
				} else {
					$('#md_checkbox_21').removeAttr('checked');
				}

	        	$('#modal-edit-transfer').modal('show'); // show bootstrap modal when complete loaded
	    	},
	    	error: function (err) {
	        	console.log(err);
	    	}
		});

	}

	function actDelete(id_transfer, id) {

		swal({
        title: "Peringatan",
        text: "Anda Yakin Untuk Menghapus Nilai Transfer ini?",
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

				var dataHapus = 'id='+id+'&id_transfer='+id_transfer;

		    	$.ajax({
					url : "<?= base_url('ademik/kliring_nilaitransfer/setHapusData'); ?>",
					type: "POST",
					data: dataHapus,
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

	/*function edit_tr(e,act,id) {

		var nim = $('#dataSearch').val();
		var data = 'act='+act+'&nim='+nim+'&id='+id;
		//alert(data);
		$body = $("body");
		$body.addClass("loading");

		$.ajax({
			url: "<?= base_url('ademik/kliring_nilaitransfer/changestatus'); ?>",
			data: data,
			type: 'POST',
			dataType: 'json',
			cache : false,
			success: function(respon){
				console.log('fandu '+respon);
				$body.removeClass("loading");

				if ( respon.ket == 'error' ) {
					//console.log(respon.pesan);
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
						//location.reload();
						//console.log("fandu "+ e);
						if (act == 1){
							e.setAttribute("class", "btn btn-sm btn-primary fa fa-edit");
							e.setAttribute("onclick", "edit_tr(this,2,"+id+")");
						} else if (act == 2){
							e.setAttribute("class", "btn btn-sm btn-danger fa fa-trash");
							e.setAttribute("onclick", "edit_tr(this,1,"+id+")");
						}
						//var div1 = document.getElementById("d1");
						//div1.nodeName.setAttribute("class", "democlass");
					});
				}
			},
			error: function (err) {
						console.log(err);
				}
		});
	}

	function nilaitransfer (){
		var nim = $('#dataSearch').val();
		var data = 'nim='+nim;

		$.ajax({
			url: "<?= base_url('ademik/kliring_nilaitransfer/nilaitransfer'); ?>",
			data: data,
			type: 'POST',
			dataType: 'json',
			cache : false,
			success: function(respon){
				//console.log("fandu console = "+respon.NIM);
				//$body.removeClass("loading");

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
					//alert(respon.TglLahir);
					$('#nim').val(respon.NIM);
					$('#name').val(respon.Name);
					$('#daftarmatakuliah').html(respon.options);
					$('#grade').html(respon.grade);
					$('#tahuntr').html(respon.tahun);
				}
			},
			error: function (err) {
	        	console.log(err);
	    	}
		});
	}*/
</script>
