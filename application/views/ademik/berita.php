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

<script src="<?= base_url();?>assets/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
<script>
	tinymce.init({ 
		selector:'textarea',
		plugins: "link",
	    default_link_target: "_blank"
	});
</script>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Berita
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="breadcrumb-item"><a href="<?= $_SESSION['tamplate'] ?>">Berita</a></li>
		</ol>
	</section>

	<!-- Main content -->
	<?php if ( $this->uri->segment(3) == '' ) { ?>

		<section class="content">
			<div class="row">
				<div class="col-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">List Berita</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<a href="<?=base_url();?>ademik/Berita/formTambahBerita" class="btn btn btn-primary fa fa-plus"> Tambah Berita</a>
							<table id="berita" class="table table-bordered table-striped table-responsive dataTable">
				                <thead>
									<tr>
				                		<th>Judul Berita</th>
										<th>Kategori</th>
										<th>Tanggal Upload</th>
										<th>Tanggal Exp</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>

									<?php

										foreach ($berita as $list) { ?>

											<tr>
												<th><?= $list->Judul ?></th>
												<th><?= $list->Kategori ?></th>
												<th><?= date('d-m-Y',strtotime($list->Tgl)) ?></th>
												<th>
													<?php if ( $list->TglExp == '0000-00-00' ) {
														echo "Tidak Ada Tanggal Expired";
													} else {
														echo date('d-m-Y',strtotime($list->TglExp));
													}?>
												</th>
												<th>
													<a href="<?=base_url();?>ademik/Berita/formEditBerita/<?=$list->ID?>" class="btn btn btn-success fa fa-edit"> Edit</a>
													<button type="button" onclick="hapus(<?=$list->ID?>)" class="btn btn btn-danger fa fa-trash">  Hapus</button>
												</th>
											</tr>

										<?php } ?>

								</tbody>
								<tfoot>
									<tr>
										<th>Judul Berita</th>
										<th>Kategori</th>
										<th>Tanggal Upload</th>
										<th>Tanggal Exp</th>
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

	<?php } elseif ( $this->uri->segment(3) == 'formTambahBerita' || $this->uri->segment(3) == 'validasiFormTambah' ) { ?>

		<section class="content">
			<div class="row">
				<div class="col-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Form Tambah Berita</h3>
							<hr size="10px">
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<form enctype="multipart/form-data" name="form_data" id="form_data"  method="post" action="<?= base_url('ademik/berita/validasiFormTambah'); ?>" >
								<div class="form-group row">
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Judul Berita</label>
								  	<div class="col-sm-5">
								  		<input class="form-control" type="hidden" name="id" id="id" value="0" placeholder="Input Judul Berita">
								  		<input class="form-control" type="text" name="judul" id="judul" value="" placeholder="Input Judul Berita">
								  	</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label">Tujuan Berita</label>
									<div class="col-sm-8">
										<select class="form-control select2" name="kategori" id="kategori" style="width: 250px;">
											<option value="">--Pilih Kategori Berita--</option>
											<?php foreach ( $kategori as $katalog ) {
												echo "<option value='".$katalog->Kategori."'>".$katalog->Kategori."</option>";
											}

											?>
										</select>
									</div>
								</div>
								<div class="form-group row">
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Exp</label>
				        			<div class="col-sm-2">
				          				<div class="input-group">
				    						<div class="input-group-addon">
				      							<i class="fa fa-calendar"></i>
				    						</div>
				    						<input type="text" name="tglExp" id="tglExp" value="" class="form-control datepicker" />
				  						</div>
				        			</div>
								</div>
								<div class="form-group row">
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Konten Berita</label>
								  	<div class="col-sm-10">
								  		<textarea class="form-control" name="konten" id="konten" value="" style="height: 300px;"></textarea>
								  	</div>
								</div>
								<div class="form-group row">
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Foto</label>
								  	<div class="col-sm-10">
								  		<div class="fileinput fileinput-new" data-provides="fileinput">
						                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; border: 1px solid;"></div>
						                    <div>
						                    <span class="btn btn-default btn-file">
						                        <span class="fileinput-new">Select Foto</span>
						                        <span class="fileinput-exists">Change</span>
					                            <input type="file" name="foto">
						                    </span>
						                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
						                    </div>
						                </div>
								  	</div>
								</div>
								<div class="form-group row">
				        			<label class="col-sm-2 control-label"></label>
									<div class="col-sm-3">
								      	<input type="checkbox" id="md_checkbox_21" class="filled-in chk-col-red" name="aktif" checked />
								      	<label for="md_checkbox_21">Active</label>
								    </div>
								</div>
								<div style="margin: 50px 0px 10px 218px">
									<button type="submit" class="btn btn btn-success fa fa-save"> Simpan</button>
									<button type="reset" class="btn btn btn-danger fa fa-refresh"> Reset</button>
									<a href="<?=base_url();?>ademik/Berita" class="btn btn btn-warning fa fa-mail-reply"> Kembali</a>
				                </div>
				            </form>
						</div>
						<!-- /.box-body -->
					</div>

				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</section>

<?php } elseif ( $this->uri->segment(3) == 'formEditBerita' || $this->uri->segment(3) == 'validasiFormEdit' ) { ?>

		<section class="content">
			<div class="row">
				<div class="col-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Form Edit Berita</h3>
							<hr size="10px">
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<form enctype="multipart/form-data" name="form_data" id="form_data"  method="post" action="<?= base_url('ademik/berita/validasiFormEdit'); ?>" >
								<div class="form-group row">
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Judul Berita</label>
								  	<div class="col-sm-5">
								  		<input class="form-control" type="hidden" name="idEdit" id="idEdit" value="<?= $edit->ID ?>" placeholder="Input Judul Berita">
								  		<input class="form-control" type="text" name="judulEdit" id="judulEdit" value="<?= $edit->Judul ?>" placeholder="Input Judul Berita">
								  	</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label">Tujuan Berita</label>
									<div class="col-sm-8">
										<select class="form-control select2" name="kategoriEdit" id="kategoriEdit" style="width: 250px;">
											<option value="<?= $edit->Kategori ?>"><?= $edit->Kategori ?></option>
											<?php foreach ( $kategori as $katalog ) {
												echo "<option value='".$katalog->Kategori."'>".$katalog->Kategori."</option>";
											}

											?>
										</select>
									</div>
								</div>
								<div class="form-group row">
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Exp</label>
				        			<div class="col-sm-2">
				          				<div class="input-group">
				    						<div class="input-group-addon">
				      							<i class="fa fa-calendar"></i>
				    						</div>
				    						<input type="text" name="tglExpEdit" id="tglExpEdit" value="<?= $TglExp ?>" class="form-control datepicker" />
				  						</div>
				        			</div>
								</div>
								<div class="form-group row">
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Konten Berita</label>
								  	<div class="col-sm-10">
								  		<textarea class="form-control" name="kontenEdit" id="kontenEdit" style="height: 300px;"><?= $edit->Konten ?></textarea>
								  	</div>
								</div>
								<div class="form-group row">
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Foto</label>
								  	<div class="col-sm-10">
								  		<div class="fileinput fileinput-new" data-provides="fileinput">
						                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; border: 1px solid;">
						                    	<?php if ( $edit->foto_berita == '' ) { ?>
						                    		<img src="<?=base_url().'assets/images/Berita/notimages.jpg'; ?>" />
						                    	<?php } else { ?>
						                    		<img src="<?=base_url().'assets/images/Berita/'.$edit->foto_berita ?>" />
						                    	<?php } ?>
						                    </div>
						                    <div>
						                    <span class="btn btn-default btn-file">
						                        <span class="fileinput-new">Select Foto</span>
						                        <span class="fileinput-exists">Change</span>
					                            <input type="file" name="fotoEdit">
						                    </span>
						                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
						                    </div>
						                </div>
								  	</div>
								</div>
								<div class="form-group row">
				        			<label class="col-sm-2 control-label"></label>
									<div class="col-sm-3">
								      	<input type="checkbox" id="md_checkbox_22" class="filled-in chk-col-red" name="aktifEdit" <?= ($edit->NotActive == 'N') ? 'checked' : ''; ?> />
								      	<label for="md_checkbox_22">Active</label>
								    </div>
								</div>
								<div style="margin: 50px 0px 10px 218px">
									<button type="submit" class="btn btn btn-success fa fa-save"> Simpan</button>
									<button type="reset" class="btn btn btn-danger fa fa-refresh"> Reset</button>
									<a href="<?=base_url();?>ademik/Berita" class="btn btn btn-warning fa fa-mail-reply"> Kembali</a>
				                </div>
				            </form>
						</div>
						<!-- /.box-body -->
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

	var i = setInterval(function() {
		if ($) {
			clearInterval(i);

			$(function(){
				<?php
					if(isset($success)){
						echo "
							swal({   
									title: 'Success !',   
									type: 'success',    
									html: true, 
									text: '".$success."',
									confirmButtonColor: 'green',   
								});
						";
					}
					if(isset($error)){
						echo "
							swal({   
									title: 'Error !',   
									type: 'error',    
									html: true, 
									text: ".$error.",
									confirmButtonColor: '#f7cb3b',   
								});
						";
					}
				?>
			});
		}
	}, 100);

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
					url : "<?= base_url('ademik/berita/setHapusDataBerita'); ?>/" +id,
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