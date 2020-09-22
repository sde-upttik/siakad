<!DOCTYPE html>
<html>
<head>
	<title>Kartu Ujian</title>
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
				<h1><b>
					DAFTAR HADIR KULIAH <br><?= $detailJadwal->Tahun ?>
				</b></h1>
				<h2><b>
					Fakultas <?= $detailJadwal->nmf ?>
				</b></h2><br><br>
				<img style="width: 120px" src="./assets/images/Logo_untad.png" ><br><br><br>
				<h3><b>
					<?= $detailJadwal->nmj ?><br>
					<?= $detailJadwal->MK ?><br><br><br>
					<?php 
						if($this->session->userdata('ulevel')=='1'){ 
							$i = 1;
							foreach ($dosen as $nm) {
								echo "<b><small>DOSEN $i : $nm </small></b><br>";
								$i++;
							}
						}else{
							echo "<b><small>DOSEN : <?= $detailJadwal->Dosen ?></small></b>";
						}
					?>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table align="center" style="font-size: 23px; font-weight: bold;">
					<tr>
						<td>Hari</td>
						<td>: <?= $detailJadwal->HR ?></td>
					</tr>
					<tr>
						<td>Jam</td>
						<td>: <?= $detailJadwal->jm." s/d ".$detailJadwal->js ?></td>
					</tr>
					<tr>
						<td>Ruang</td>
						<td>: <?= $detailJadwal->KodeRuang ?></td>
					</tr>
					<tr>
						<td>Kelas</td>
						<td>: <?= $detailJadwal->Keterangan ?></td>
					</tr>
				</table>
			</div>
		</div>

		<div style="page-break-after: always;"></div>

		<div class="row" style="margin-bottom: -95px">
			<div class="col-md-1">
				<img style="width: 80px" src="./assets/images/Logo_untad.png" >
			</div>
			<div class="col-md-11 text-center">
				<b style="font-size: 13">
				KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN
				</b><br>
				<b style="font-size: 15">UNIVERSITAS TADULAKO</b><br>
				<b style="font-size: 15">FAKULTAS <?= $detailJadwal->nmf ?></b>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-12" style="font-size: 12px;">
				<table style="width: 100%">
					<tr>
						<td>PROGRAM</td>
						<td>: <?= $detailJadwal->PRG." (".$detailJadwal->Program.")" ?></td>
						<td>Hari</td>
						<td>: <?= $detailJadwal->HR ?></td>
					</tr>
					<tr>
						<td>Semester</td>
						<td>: <?= $detailJadwal->Tahun ?></td>
						<td>Waktu</td>
						<td>: <?= $detailJadwal->jm." - ".$detailJadwal->js ?></td>
					</tr>
					<tr>
						<td>Jurusan</td>
						<td>: <?= $detailJadwal->KodeJurusan." - ".$detailJadwal->nmj ?></td>
						<td>Ruang</td>
						<td>: <?= $detailJadwal->KodeRuang ?></td>
					</tr>
					<tr>
						<td>Matakuliah</td>
						<td>: <?= $detailJadwal->KodeMK." - ".$detailJadwal->MK."(".$detailJadwal->SKS.")" ?></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>Dosen</td>
						<td>: <?= $detailJadwal->Dosen ?></td>
						<td></td>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" style="font-size: 12px;">
				<table border="1" style="width: 100%">
					<tr>
						<th rowspan="2" style="text-align: center;width: 1px">No.</th>
						<th rowspan="2" style="text-align: center;width: 60px">NIM</th>
						<th rowspan="2" style="text-align: center;">Nama Mahasiswa</th>
						<th colspan="16" style="text-align: center;">Pertemuan Ke</th>
						<th rowspan="2" style="text-align: center;width: 60px">Keteraangan</th>
					</tr>
					<tr>
						<td align="center" style="width: 25px">1</td>
						<td align="center" style="width: 25px">2</td>
						<td align="center" style="width: 25px">3</td>
						<td align="center" style="width: 25px">4</td>
						<td align="center" style="width: 25px">5</td>
						<td align="center" style="width: 25px">6</td>
						<td align="center" style="width: 25px">7</td>
						<td align="center" style="width: 25px">8</td>
						<td align="center" style="width: 25px">9</td>
						<td align="center" style="width: 25px">10</td>
						<td align="center" style="width: 25px">11</td>
						<td align="center" style="width: 25px">12</td>
						<td align="center" style="width: 25px">13</td>
						<td align="center" style="width: 25px">14</td>
						<td align="center" style="width: 25px">15</td>
						<td align="center" style="width: 25px">16</td>
					</tr>
					<?php 
					$a = 1;
					foreach ($detailMahasiswa as $mhsw){
					?>
					<tr>
						<td><?= $a ?></td>
						<td><?= $mhsw->NIM ?></td>
						<td><?= $mhsw->Name ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td align="center">0.00 %</td>
					</tr>
					<?php 
						$a++;
					}
					?>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-10" style="display: block;">
			</div>
			<div class="col-md-2 text-center">
				Palu, <?= $tglnow ?><br>
				Yang membuat,<br><br><br><br>
				( ............................ )
			</div>
		</div>
	</div>

	<script type="text/javascript" src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>