<!DOCTYPE html>
<html>
<head>
	<title>Matakuliah Per Jenis</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/components/bootstrap/dist/css/bootstrap.min.css'); ?>">
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
				<h4><b>Jadwal Kuliah</b></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table-bordered">
					<tr>
						<td colspan="2"><b>Semester Akademik</b></td>
					</tr>
					<tr>
						<td>Semester Akademik</td>
						<td>: <b>20172 Genap 2017-2018</b></td>
					</tr>
					<tr>
						<td>Program</td>
						<td>: <b>REG - Program Reguler</b></td>
					</tr>
					<tr>
						<td>Jurusan</td>
						<td>: <b>A321 - Pendidikan Pancasila & Kewarganegaraan</b></td>
					</tr>
				</table>
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="col-md-12">
				<table border="1" style="width: 100%; font-size: 14px;">
					<?php
						$hari = ""; // minggu
						foreach($detailJadwal as $detail){
							if ($hari != $detail->HR){ // "" != "minggu"
								echo "<tr>
									<th colspan='9' class='text-center' style='font-size: 20px'><b>".$detail->HR."</b></th>
								</tr>
								<tr>
									<th style='text-align: center'>Jam</th>
									<th style='text-align: center'>Ruangan</th>
									<th style='text-align: center'>KodeMK</th>
									<th style='text-align: center'>Mata Kuliah</th>
									<th style='text-align: center'>Program</th>
									<th style='text-align: center'>SKS</th>
									<th style='text-align: center'>Dosen</th>
									<th style='text-align: center'>Kelas</th>
									<th style='text-align: center'>Kapasitas</th>
								</tr>";
								$hari = $detail->HR;
							} else {
						?>
							<tr>
								<td><?=$detail->jm." - ".$detail->HR?></td>
								<td style="text-align: center;"><?=$detail->KodeRuang?></td>
								<td><?=$detail->KodeMK?></td>
								<td><?=$detail->MK?></td>
								<td><?=$detail->PRG?></td>
								<td><?=$detail->SKS?></td>
								<td><?=$detail->Dosen?></td>
								<td><?=$detail->Keterangan?></td>
								<td><?=$detail->Kapasitas?></td>
							</tr>
					<?php
								$hari = $detail->HR;
							}
						}
					?>
				</table>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>