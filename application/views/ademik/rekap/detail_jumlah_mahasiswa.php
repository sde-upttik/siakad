<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Rekap Jumlah Mahasiswa
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
						<h3 class="box-title">Rekap Jumlah Mahasiswa</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="table_admin" class="table table-bordered table-striped table-responsive">
                			<thead>
								<tr>
									<th rowspan="2" style="vertical-align: middle;"><b>No</b></th>
									<th rowspan="2" style="vertical-align: middle;"><b>Jurusan</b></th>
									<th rowspan="2" style="vertical-align: middle;"><b>Jumlah</b></th>
									<th colspan="2"><b>2010</b></th>
									<th colspan="2"><b>2011</b></th>
									<th colspan="2"><b>2012</b></th>
									<th colspan="2"><b>2013</b></th>
									<th colspan="2"><b>2014</b></th>
									<th colspan="2"><b>2015</b></th>
									<th colspan="2"><b>2016</b></th>
									<th colspan="2"><b>2017</b></th>
								</tr>
								<tr>
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
									<th><b>P</b></th>
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
