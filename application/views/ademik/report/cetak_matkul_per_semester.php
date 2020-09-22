<!DOCTYPE html>
<html>
<head>
	<title>Mata Kuliah Per Semester</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
	<style type="text/css">
		body{
			font-family: times;
		}
		h2, h3{
			margin: 0px;
			padding: 0px;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 text-center">
				<h4><b>Mata Kuliah Per Semester</b></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" style="font-size: 14px;">
				<table class="table-bordered">
					<tr>
						<td>Jurusan</td>
						<td>: <?= $namaJurusan ?></td>
					</tr>
					<tr>
						<td>Kurikulum</td>
						<td>: <?= $kurikulum->Nama ?></td>
					</tr>
					<tr>
						<td>Tahun</td>
						<td>: <?= $kurikulum->Tahun ?></td>
					</tr>
					<tr>
						<td>Nama Semester</td>
						<td>: <?= $kurikulum->Sesi ?></td>
					</tr>
					<tr>
						<td>Jml Semester/tahun</td>
						<td>: <?= $kurikulum->JmlSesi ?></td>
					</tr>
					<tr>
						<td>ID Kurikulum</td>
						<td>: <?= $kurikulum->IdKurikulum ?></td>
					</tr>
				</table>
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="col-md-12">

				<?php for ($i=1; $i<=$tabel->JmlTabel; $i++ ) { ?>

					<table style="font-size: 14px; width: 100%; margin-bottom: 10px;" border="1">
						<tr>
							<th style="text-align: center;" colspan="3"><?= $kurikulum->Sesi ?> <?=$i?></th>
						</tr>
						<tr>
							<th align="center" style="width: 80px; text-align: center">Kode</th>
							<th align="center" >Nama</th>
							<th align="center" style="width: 60px; text-align: center">SKS</th>
						</tr>

						<?php
						$jmlSKS = 0;
						foreach ($detailTabel[$i] as $tampil) { ?>

							<tr>
								<th><?= $tampil->Kode ?></th>
								<th align="left">
									<?= $tampil->Nama_Indonesia ?>
									<?php if ( $tampil->Wajib == 'Y' ) { echo "<font color='red'>*</font>"; } ?>
									<?php if ( $tampil->NotActive == 'Y' ) { echo "<font color='red'>x</font>"; } ?>	
								</th>
								<th><?= $tampil->SKS ?></th>
							</tr>

						<?php $jmlSKS+=$tampil->SKS; } ?>
						<tr>
							<td colspan="2" align="right">Jumlah SKS</td>
							<td align="center"><b><?= $jmlSKS ?></b></td>
						</tr>
					</table>

				<?php } ?>

			</div>
		</div>
	</div>

	<script type="text/javascript" src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>