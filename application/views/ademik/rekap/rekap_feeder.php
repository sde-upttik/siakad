<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Rekap Feeder
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
						<h3 class="box-title">Rekap Feeder</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">				
						<form class="form-horizontal" action="<?= base_url('ademik/rekap_data/searchFeeder'); ?>" method="POST">
							<div class="form-group row">
								<label class="col-sm-2 control-label">Semester Akademik (5 digit dengan Semesternya ex: 20181)</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="semesterAkademik" name="semesterAkademik" placeholder="Semester Akademik">
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
			</div>
			<!-- /.col -->
		</div>
		<?php 
			if (isset($dataTable)) {
		?>
			<div class="row">
				<div class="col-6">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Data Yang belum Terkirim</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<table id="table_feeder" class="table table-bordered table-striped table-responsive">
	                			<thead>
									<tr>
										<th style="vertical-align: middle;"><b>No</b></th>
										<th style="vertical-align: middle;"><b>Fakultas</b></th>
										<th style="vertical-align: middle;"><b>KRS Belum dikirim</b></th>
										<th style="vertical-align: middle;"><b>KHS Belum dikirim</b></th>
									</tr>
								</thead>
								<tbody>
									<?php
										$i=1;
										foreach ($dataTable as $show) {
									?>
										<tr>
											<td><?= $i ?></td>
											<td><a href="<?= base_url('ademik/rekap_data/rekapFeederJur/'.$tahun.'/'.$show->KodeFakultas); ?>"><?= $show->Singkatan." (".$show->KodeFakultas.")" ?></a></td>
											<td><?= $show->belumKrs ?></td>
											<td><?= $show->belumKirim ?></td>
										</tr>
									<?php
										$i++;
										}
									?>
								</tbody>
	             			</table>

						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->   
				</div>
				<!-- /.col -->
				<div class="col-6">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Data terkirim Feeder</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<table id="table_feeder2" class="table table-bordered table-striped table-responsive">
	                			<thead>
									<tr>
										<th style="vertical-align: middle;"><b>No</b></th>
										<th style="vertical-align: middle;"><b>Fakultas</b></th>
										<th style="vertical-align: middle;"><b>KRS Sudah dikirim</b></th>
										<th style="vertical-align: middle;"><b>KHS Sudah dikirim</b></th>
									</tr>
								</thead>
								<tbody>
									<?php
										$i=1;
										foreach ($dataTable2 as $show) {
									?>
										<tr>
											<td><?= $i ?></td>
											<td><a href="<?= base_url('ademik/rekap_data/rekapFeederJur/'.$tahun.'/'.$show->KodeFakultas); ?>"><?= $show->Singkatan." (".$show->KodeFakultas.")" ?></a></td>
											<td><?= $show->sudahKrs ?></td>
											<td><?= $show->sudahKirim ?></td>
										</tr>
									<?php
										$i++;
										}
									?>
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
		<?php 
			}
		?>
	</section>
	<!-- /.content -->
</div>
