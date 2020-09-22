<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Halaman Rekap Data
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="breadcrumb-item"><a href="<?= $_SESSION['tamplate'] ?>">Rekap_Data</a></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Rekap Data</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<!-- <a href="<?= base_url('ademik/rekap_data/rekapJumlahMahasiswa'); ?>" class="btn btn-app bg-olive" style="margin-bottom: 20px;">Rekap Jumlah<br>Mahasiswa</a> -->
						<a href="<?= base_url('ademik/rekap_data/rekapAktifBayar'); ?>" class="btn btn-app bg-green" style="margin-bottom: 20px;">Rekap Mahasiswa<br>Aktif Pembayaran</a>
						<a href="<?= base_url('ademik/rekap_data/rekapFeeder'); ?>" class="btn btn-app bg-orange" style="margin-bottom: 20px;">Rekap<br>Feeder</a>
						
						<!-- tambahan rekap inal -->
						<a href="<?= base_url('ademik/rekap_data/RekapPelaksanaanKuliah'); ?>" class="btn btn-app bg-red" style="margin-bottom: 20px;">Rekap Pelaksanaan <br> Kuliah</a>

						<!-- tambahan rekap inal -->
						<a href="<?= base_url('ademik/rekap_data/RangkumanIpk'); ?>" class="btn btn-app bg-aqua" style="margin-bottom: 20px;">Rangkuman<br> IPK</a>
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
