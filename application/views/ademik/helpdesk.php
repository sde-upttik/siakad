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
<script>tinymce.init({ selector:'textarea' });</script>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Help Desk
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="breadcrumb-item"><a href="<?= $_SESSION['tamplate'] ?>">Help Desk</a></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
			<div class="row">
			<?php
			$ulevel = $this->session->userdata('ulevel');
		
			if($ulevel == 1){
			?>
				<!-- atas level admin superuser -->
				<div class="col-lg-3 col-12">
				  <!--<a href="compose.html" class="btn btn-success btn-block btn-shadow margin-bottom">Compose</a>-->
				  <div class="box box-solid">
					<div class="box-header with-border">
					  <h3 class="box-title">Folders</h3>

					  <div class="box-tools">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					  </div>
					</div>
					<div class="box-body no-padding mailbox-nav">
					  <ul class="nav nav-pills flex-column">
						<li class="nav-item"><a class="nav-link active" onClick="inbox()" href="#"><i class="ion ion-ios-email-outline"></i> Inbox
						  <span class="label label-success pull-right">12</span></a>
						</li>
					  </ul>
					</div>
					<!-- /.box-body -->
				  </div>
				  <!-- /. box -->
				  <!-- /.box -->
				</div>
				<!-- /.col -->
				<div class="col-lg-9 col-12" id="divmail">
							<?php
							if (!empty($subjecthelpdesk)){
								echo $subjecthelpdesk;
							}
							?>

							
				  <!-- /. box -->
				</div>
				<!-- /.col -->
				<!-- bawah level admin superuser -->
				
				<?php
			} else if($ulevel == 5){ // form pesan masuk
				if(!empty($id_telegram)) {
				?>

				<!-- left column -->
				<div class='col-xl-6 col-lg-12'>
					<!-- Box Comment -->
					<div class='box box-widget'>
							<div id="detailpesan">
								<div class='box-header with-border'>
									<div class='user-block'>
										<span class='username'><a href='#'>User</a></span>
										<span class='description'>Detail User</span>
									</div>
								</div>
							</div>
					</div>
					<!-- /.box -->
				</div>
				<!-- /.col -->
				<!-- right column -->
				<div class="col-xl-6 col-lg-12">

					<div class="box box-info">
							<div class="box-header with-border">
									<h3 class="box-title">SUBJECT PESAN</h3>
							</div>
					<!-- /.box-header -->
							<div class="box-body">
									<table id="example1" class="table table-bordered table-striped table-responsive">
										<thead>
							<tr>
								<th>Pengirim</th>
								<th>From</th>
								<th>Pesan</th>
								<th>Status</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Pengirim</th>
								<th>From</th>
								<th>Pesan</th>
								<th>Status</th>
							</tr>
						</tfoot>
						<tbody>
							<?php foreach ($subjecthelpdesk as $tampil) { ?>
								<tr>
									<td><a onClick="lihat(<?= $tampil->id ?>)" href="#" style="color: red;"><?= $tampil->user_pengirim ?></a></td>
									<td><?php if (empty($tampil->user_balasan)){ echo "Belum Ada Balasan"; } else { echo $tampil->user_balasan; } ?></td>
									<td><?= $tampil->pesan ?></td>
									<td><?= $tampil->status_error ?></td>
								</tr>
							<?php } ?>
						</tbody>
								</table>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
				</div>
				<!-- /.col -->
			<?php 
				} else {
					if (empty($this->session->flashdata('codeverivikasi'))){
			?>
				<div class='col-xl-12 col-lg-12'>
					<!-- Box Comment -->
					<div class='box box-widget'>
							<div id="detailpesan">
								<div class='box-header with-border'>
									<div class='user-block'>
										<span class='description'>Silahkan Registrasi User Anda</span>
										<form action='<?=base_url()?>ademik/helpdesk/getverivikasicode' method='post'>
											<!--<img class='img-fluid rounded img-sm' src='' alt='Alt Text'>-->
											<!-- .img-push is used to add margin to elements next to floating images -->
											<div class='img-push'>
												<input type='text' name='idtelegram' class='form-control input-sm' placeholder='Masukkan ID Telegram Anda'>
											</div>
										</form>
									</div>
								</div>
							</div>
					</div>
					<!-- /.box -->
				</div>
			<?php
					} else { ?>
				<div class='col-xl-12 col-lg-12'>
					<!-- Box Comment -->
					<div class='box box-widget'>
							<div id="detailpesan">
								<div class='box-header with-border'>
									<div class='user-block'>
										<span class='description'>Silahkan Masukkan Verivikasi Code</span>
										<form action='<?=base_url()?>ademik/helpdesk/verivikasicode' method='post'>
											<!--<img class='img-fluid rounded img-sm' src='' alt='Alt Text'>-->
											<!-- .img-push is used to add margin to elements next to floating images -->
											<div class='img-push'>
												<input type='hidden' name='idtelegram' value="<?=$this->session->flashdata('codeverivikasi')?>" class='form-control input-sm' placeholder='Masukkan ID Telegram Anda'>
												<input type='text' name='codeverivikasi' class='form-control input-sm' placeholder='Masukkan ID Telegram Anda'>
											</div>
										</form>
									</div>
								</div>
							</div>
					</div>
					<!-- /.box -->
				</div>
			
			<?php
					}
				}
			} 
			?>
			</div>
			<!-- /.row -->
	</section>
	<!-- /.content -->
	
	<?php
	if($ulevel == 5){ // form laporan untuk fakultas
		if(!empty($id_telegram)) {
	?>

	<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Form Laporan</h3>
							<label class="col-sm-2 control-label">
										<span class="login-box-msg" style='color:red'><?=$this->session->flashdata('message_text')?></span>
									</label>
									<label class="col-sm-2 control-label">
										<span class="login-box-msg" style='color:red'><?=$this->session->flashdata('message_foto')?></span>
									</label>
							<hr size="10px">
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<form enctype="multipart/form-data" name="form_data" id="form_data"  method="post" action="<?= base_url('ademik/helpdesk/kirim_text'); ?>" >
								<div class="form-group row">
									<label class="col-sm-2 control-label">Kategori Keluhan</label>
									<div class="col-sm-8">
										<select class="form-control select2" name="kategori" id="kategori" style="width: 250px;">
											<option value="">--Pilih Kategori Keluhan--</option>
												<option value='mahasiswa'>Mahasiswa</option>
												<option value='siakad'>Siakad</option>
												<option value='feeder'>Feeder</option>
												<option value='lainnya'>Lainnya</option>
										</select>
									</div>
								</div>
								<div class="form-group row">
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Subject</label>
								  	<div class="col-sm-5">
								  		<input class="form-control" type="text" name="subject" id="subject" value="" placeholder="Subject">
								  	</div>
								</div>
								<!--<div class="form-group row">
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Exp</label>
				        			<div class="col-sm-2">
				          				<div class="input-group">
				    						<div class="input-group-addon">
				      							<i class="fa fa-calendar"></i>
				    						</div>
				    						<input type="text" name="tglExp" id="tglExp" value="" class="form-control datepicker" />
				  						</div>
				        			</div>
								</div>-->
								<div class="form-group row">
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Uraian Laporan <br><br> * pada uraian berisi tentang uraian keluhan yang memuat stambuk/nama/identitas lengkap yang di laporkan dan melaporkan, agar memperudah dalam melakukan analisa</label>
								  	<div class="col-sm-10">
								  		<textarea class="form-control" name="uraian" id="uraian" value="" style="height: 300px;"></textarea>
								  	</div>
								</div>
								<div class="form-group row">
								  	<label for="example-text-input" class="col-sm-2 col-form-label">Foto<br>* size foto maksimal 500 KB</label>
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
									<a href="<?=base_url();?>ademik/helpdesk" class="btn btn btn-warning fa fa-mail-reply"> Kembali</a>
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
	<?php
		}
	}
	?>

	<!-- /.content -->
</div>

<script>
function lihat(act){

	$body = $("body");
	$body.addClass("loading");

	$.ajax({
		url: "<?= base_url('ademik/helpdesk/detailpesan'); ?>",
		data: 'act='+act,
		type: 'POST',
		success: function(respon){
			$body.removeClass("loading");

			$('#detailpesan').html(respon)

			/*if ( respon.ket == 'error' ) {
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

			}*/
		},
		error: function (err) {
        	console.log(err);
    	}
	});
}

function inbox(){

	var act = 1;

	$body = $("body");
	$body.addClass("loading");

	$.ajax({
		url: "<?= base_url('ademik/helpdesk/inbox'); ?>",
		data: 'act='+act,
		type: 'POST',
		success: function(respon){
			$body.removeClass("loading");

			$('#divmail').html(respon)

		},
		error: function (err) {
        	console.log(err);
    	}
	});
}

function readmessage(act){

	$body = $("body");
	$body.addClass("loading");

	$.ajax({
		url: "<?= base_url('ademik/helpdesk/readmessage'); ?>",
		data: 'act='+act,
		type: 'POST',
		success: function(respon){
			$body.removeClass("loading");

			$('#divmail').html(respon)

		},
		error: function (err) {
        	console.log(err);
    	}
	});
}
</script>
