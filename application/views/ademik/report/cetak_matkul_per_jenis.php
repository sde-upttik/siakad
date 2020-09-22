<!DOCTYPE html>
<html>
<head>
	<title>Matakuliah Per Jenis</title>
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
				<h4><b>Mata Kuliah Per Jenis</b></h4>
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
			<div class="col-md-12" style="font-size: 14px;">
				<table border="1" style="width: 100%">
					<tr>
                		<th colspan="7" style="text-align: center;">Data Siakad</th>
                		<th colspan="2" style="text-align: center;">Data PDPT</th>
                	</tr>
					<tr>
						<th>No</th>
						<th>Kode</th>
						<th>Nama Indonesia</th>
						<th>Nama English</th>
						<th>Urutan Di Transkrip</th>
						<th>Semester</th>
						<th>SKS</th>
						<th>Matakuliah</th>
						<th>Kurikulum</th>
					</tr>

					<?php 
						$no = 1;
						$jmlSKS = 0; 
						foreach ($tabel as $tampil) { ?>

							<tr>
								<th><?= $no++; ?></th>
								<th><?= $tampil->Kode ?></th>
								<th align="left">
									<?= $tampil->Nama_Indonesia ?>
									<?php if ( $tampil->Wajib == 'Y' ) { echo "<font color='red'>*</font>"; } ?>
									<?php if ( $tampil->NotActive == 'Y' ) { echo "<font color='red'>x</font>"; } ?>
								</th>
								<th align="left"><?= $tampil->Nama_English ?></th>
								<th><?= $tampil->urutan ?></th>
								<th><?= $tampil->Sesi ?></th>
								<th><?= $tampil->SKS ?></th>
								<th>
									<?php if ( empty($tampil->id_mk) ) { ?>
										<font style='color: red;'>Belum Terdaftar di PDDIKTI</font>
									<?php } else { ?>
										<font style='color: green;'>Terdaftar di PDDIKTI</font>
									<?php } ?>
								</th>
								<th>
									<?php if ( empty($tampil->id_kurikulum) ) { ?>
										<font style='color: red;'>Belum Terdaftar di PDDIKTI</font>
									<?php } else { ?>
										<font style='color: green;'>Terdaftar di PDDIKTI</font>
									<?php } ?>
								</th>
							</tr>

					<?php $jmlSKS+=$tampil->SKS; } ?>

					<tr>
						<td colspan="6" align="right">Jumlah SKS</td>
						<td align="text-center"><b><?= $jmlSKS ?></b></td>
						<td colspan="2"></td>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>