<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Rekap Mahasiswa Teregistrasi Berdasarkan Pembayaran
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
						<h3 class="box-title">Rekap Mahasiswa Teregistrasi Berdasarkan Pembayaran</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="example1" class="table table-bordered table-striped table-responsive">
              <thead>
								<tr>
                  <th>No.</th>
                  <th>NIM</th>
                  <th>Nama</th>
                  <th>Tahun Masuk/Angkatan</th>
                  <th>Status Bayar</th>
								</tr>
							</thead>
							<tbody>
								<?= $body; ?>
							</tbody>
            </table>

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
