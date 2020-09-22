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
						<table id="table_admin" class="table table-bordered table-striped table-responsive">
                			<thead>
								<tr>
									<th rowspan="2" style="vertical-align: middle;"><b>No</b></th>
									<th rowspan="2" style="vertical-align: middle;"><b>Fakultas</b></th>
									<th rowspan="2" style="vertical-align: middle;"><b>Jumlah</b></th>
									<?php
										foreach($dataTahun as $showTahun){
											echo "<th colspan='2'><b>".$showTahun->TahunAkademik."</b></th>";
										}
									?>
								</tr>
								<tr>
									<th><b>P</b></th>
									<th><b>L+P</b></th>
									<th><b>P</b></th>
									<th><b>L+P</b></th>
									<th><b>P</b></th>
									<th><b>L+P</b></th>
									<th><b>P</b></th>
									<th><b>L+P</b></th>
									<th><b>P</b></th>
									<th><b>L+P</b></th>
									<th><b>P</b></th>
									<th><b>L+P</b></th>
									<th><b>P</b></th>
									<th><b>L+P</b></th>
									<th><b>P</b></th>
									<th><b>L+P</b></th>
								</tr>
							</thead>
							<tbody>
								<?= $body; ?>
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
