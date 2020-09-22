<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Halaman Management User
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="breadcrumb-item"><a href="<?= $_SESSION['tamplate'] ?>">KRS</a></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Management User</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<?php
							if($this->session->ulevel==1){
						?>
								<a href="<?= base_url('ademik/useraccess/adminpage'); ?>" class="btn btn-app bg-purple" style="margin-bottom: 20px;">Management <br>Admin SU</a>
								<a href="<?= base_url('ademik/useraccess/adminpusat'); ?>" class="btn btn-app bg-green" style="margin-bottom: 20px;">Management <br>Admin Pusat</a>
								<!-- <a href="<?= base_url('ademik/useraccess/pegawai'); ?>" class="btn btn-app bg-blue" style="margin-bottom: 20px;">Management <br>Pegawai</a> -->
								<a href="<?= base_url('ademik/useraccess/adminfak'); ?>" class="btn btn-app bg-olive" style="margin-bottom: 20px;">Management <br>Admin Fakultas</a>
								<a href="<?= base_url('ademik/useraccess/adminjur'); ?>" class="btn btn-app bg-purple" style="margin-bottom: 20px;">Management <br>Admin Jurusan</a>
								<a href="<?= base_url('ademik/useraccess/dosen'); ?>" class="btn btn-app bg-green" style="margin-bottom: 20px;">Management <br>Dosen</a>
								<a href="<?= base_url('ademik/useraccess/mahasiswa'); ?>" class="btn btn-app bg-blue" style="margin-bottom: 20px;">Management <br>Mahasiswa</a>
						<?php
							}
						?>

						<?php
							if($this->session->ulevel==6){
						?>
								<a href="<?= base_url('ademik/useraccess/adminpusat'); ?>" class="btn btn-app bg-green" style="margin-bottom: 20px;">Management <br>Admin Pusat</a>
								<!-- <a href="<?= base_url('ademik/useraccess/pegawai'); ?>" class="btn btn-app bg-blue" style="margin-bottom: 20px;">Management <br>Pegawai</a> -->
								<a href="<?= base_url('ademik/useraccess/adminfak'); ?>" class="btn btn-app bg-olive" style="margin-bottom: 20px;">Management <br>Admin Fakultas</a>
								<a href="<?= base_url('ademik/useraccess/adminjur'); ?>" class="btn btn-app bg-purple" style="margin-bottom: 20px;">Management <br>Admin Jurusan</a>
								<a href="<?= base_url('ademik/useraccess/dosen'); ?>" class="btn btn-app bg-green" style="margin-bottom: 20px;">Management <br>Dosen</a>
								<a href="<?= base_url('ademik/useraccess/mahasiswa'); ?>" class="btn btn-app bg-blue" style="margin-bottom: 20px;">Management <br>Mahasiswa</a>
						<?php
							}
						?>
						<?php
							if($this->session->ulevel==5){
						?>
								<!-- <a href="<?= base_url('ademik/useraccess/pegawai'); ?>" class="btn btn-app bg-blue" style="margin-bottom: 20px;">Management <br>Pegawai</a> -->
								<a href="<?= base_url('ademik/useraccess/adminfak'); ?>" class="btn btn-app bg-olive" style="margin-bottom: 20px;">Management <br>Admin Fakultas</a>
								<a href="<?= base_url('ademik/useraccess/adminjur'); ?>" class="btn btn-app bg-purple" style="margin-bottom: 20px;">Management <br>Admin Jurusan</a>
								<a href="<?= base_url('ademik/useraccess/dosen'); ?>" class="btn btn-app bg-green" style="margin-bottom: 20px;">Management <br>Dosen</a>
								<a href="<?= base_url('ademik/useraccess/mahasiswa'); ?>" class="btn btn-app bg-blue" style="margin-bottom: 20px;">Management <br>Mahasiswa</a>
						<?php
							}
						?>
						<?php
							if($this->session->ulevel==7){
						?>
								<a href="<?= base_url('ademik/useraccess/adminjur'); ?>" class="btn btn-app bg-purple" style="margin-bottom: 20px;">Management <br>Admin Jurusan</a>
								<a href="<?= base_url('ademik/useraccess/dosen'); ?>" class="btn btn-app bg-green" style="margin-bottom: 20px;">Management <br>Dosen</a>
								<a href="<?= base_url('ademik/useraccess/mahasiswa'); ?>" class="btn btn-app bg-blue" style="margin-bottom: 20px;">Management <br>Mahasiswa</a>
						<?php
							}
						?>
						<?php
							if($this->session->ulevel==3){
						?>
								<a href="<?= base_url('ademik/useraccess/dosen'); ?>" class="btn btn-app bg-green" style="margin-bottom: 20px;">Management <br>Dosen</a>
						<?php
							}
						?>
						<?php
							if($this->session->ulevel==4){
						?>
								<a href="<?= base_url('ademik/useraccess/mahasiswa'); ?>" class="btn btn-app bg-blue" style="margin-bottom: 20px;">Management <br>Mahasiswa</a>
						<?php
							}
						?>

						
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
