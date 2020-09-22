<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Edit Admin Jurusan
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<!-- <li class="breadcrumb-item"><a href="<?= $_SESSION['tamplate'] ?>">KRS</a></li> -->
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Edit Admin Jurusan</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<?php
							if($this->session->flashdata('error')!=null||$this->session->flashdata('error')!=""){
								echo $this->session->flashdata('error');
							}
						?>
						<form action="<?= base_url('ademik/useraccess/updateAdminDosen/'.$edit->ID); ?>" method="POST">
							<div class="form-group row">
							  <label for="Login" class="col-md-2 col-form-label">Nama Login</label>
							  <div class="col-md-6">
								<input class="form-control" type="text" id="Login" name="Login" value="<?= $edit->Login; ?>" readonly>
							  </div>
							</div>
							<div class="form-group row">
							  <label for="nip" class="col-md-2 col-form-label">NIP</label>
							  <div class="col-md-6">
								<input class="form-control" type="text" id="nip" name="nip" value="<?= $edit->nip; ?>" readonly>
							  </div>
							</div>
							<div class="form-group row">
							  <label for="name" class="col-md-2 col-form-label">Nama Lengkap</label>
							  <div class="col-md-6">
								<input class="form-control" type="text" id="name" name="full_name" value="<?= $edit->Name; ?>">
							  </div>
							</div>
							<div class="form-group row">
							  <label for="email" class="col-md-2 col-form-label">Email</label>
							  <div class="col-md-6">
								<input class="form-control" type="email" id="email" name="Email" value="<?= $edit->Email; ?>">
							  </div>
							</div>
							<div class="form-group row">
							  <label for="password" class="col-md-2 col-form-label">Password</label>
							  <div class="col-md-6">
								<input class="form-control" type="password" id="password" name="Password"> * Kosongkan jika tidak diganti
							  </div>
							</div>		
							<div class="form-group row">
							  <label for="phone" class="col-md-2 col-form-label">Telepon</label>
							  <div class="col-md-6">
								<input class="form-control" type="text" id="phone" name="Phone" value="<?= $edit->Phone; ?>">
							  </div>
							</div>		
			                <div class="form-group row">
			                  <label for="description" class="col-md-2 col-form-label">Keterangan</label>
			                  <div class="col-md-10">
			                	<textarea class="form-control" rows="3" id="description" name="Description" placeholder=""><?= $edit->Description; ?></textarea>
			                  </div>
			                </div>
			                <div class="form-group row">
			                  <label for="description" class="col-md-2 col-form-label">NotActive</label>
			                  <div class="col-md-2">
			                  	<select class="form-control" name="NotActive">
			                  		<option value="N" <?php if($edit->NotActive=="N"){echo "selected";} ?>>N</option>
			                  		<option value="Y" <?php if($edit->NotActive=="Y"){echo "selected";} ?>>Y</option>
			                  	</select>
			                  </div>
			                </div>
							<div class="form-group row">
								<div class="col-md-12" style="text-align: center;">
									<input type="submit" name="simpan" value="Simpan" class="btn bg-olive">
									<input type="reset" value="Reset" class="btn bg-orange">
									<a href="<?= base_url('ademik/useraccess/dosen'); ?>" class="btn btn-danger">Kembali</a>
								</div>
							</div>	
						</form>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->   
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>
