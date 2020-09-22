<!DOCTYPE html>
<html>
<head>
	<title>Cetak KHS</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/components/bootstrap/dist/css/bootstrap.min.css'); ?>">
	<style type="text/css">
		body{
			font-family: Arial, Helvetica, sans-serif;
		}
		h2, h3{
			margin: 0px;
			padding: 0px;
		}
		.page-break {
			display: block;
			page-break-before: always;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row" style="margin-bottom: -95px">
			<div class="col-md-1">
				<img style="width: 80px" src="./assets/images/Logo_untad.png" >
			</div>
			<div class="col-md-11 text-center">
				<b style="font-size: 13">
					KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN
				</b><br>
				<b style="font-size: 15">UNIVERSITAS TADULAKO</b><br>
				<b style="font-size: 11"><?= $detailJadwal->nmf ?></b>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-12" style="font-size: 12px;">
				<table class="text-center" style="width: 100%">
					<tr>
						<td>DAFTAR PESERTA DAN NILAI AKHIR</td>
					</tr>
					<tr>
						<td>Semester <?= $detailJadwal->namatahun ?></td>
					</tr>
				</table>
				<table style="width: 100%">
					<tr>
						<td>Mata Kuliah</td>
						<td>: <?= $detailJadwal->KodeMK." - ".$detailJadwal->MK."(".$detailJadwal->SKS.")" ?></td>
						<td>Program Studi</td>
						<td>: <?= $detailJadwal->nmj ?></td>
					</tr>
					<tr>
						<td>Dosen</td>
						<td>: <?= $detailJadwal->Dosen ?></td>
						<td>Kelas</td>
						<td>: <?= $detailJadwal->Keterangan ?></td>
					</tr>
					<?php foreach ($getAssDsn->result() as $AssDsn) { ?>
						<tr>
							<td></td>
							<td>: <?= $AssDsn->Name ?></td>
							<td></td>
							<td></td>
						</tr>
					<?php } ?>
				</table>
			</div>
		</div><br><br>
		<div class="row">
			<div class="col-md-12" style="font-size: 12px;">

					<!--<tr>
						<th style="vertical-align: middle;text-align: center;" align="center">Angka</th>
						<th style="vertical-align: middle;text-align: center;" align="center">Huruf</th>
					</tr>-->
					<?php
					$a = 1;
					foreach ($detailMahasiswa as $mhsw){

						if ($a == 1 or $a == 31){

						?>

						<table border="1" style="width: 100%">
							<tr>
								<th style="vertical-align: middle;text-align: center; width: 10px" align="center" rowspan="1">No.</th>
								<th style="vertical-align: middle;text-align: center; width: 80px" align="center" rowspan="1">NIM</th>
								<th style="vertical-align: middle;text-align: center;" align="center" rowspan="1">Nama Mahasiswa</th>
								<th style="vertical-align: middle;text-align: center; width: 60px" align="center" colspan="1">Kehadiran</th>
								<!--<th style="vertical-align: middle;text-align: center; width: 130px" align="center" colspan="2">Nilai</th>-->
								<th style="vertical-align: middle;text-align: center; width: 130px" align="center" colspan="1">Nilai Huruf</th>
								<th style="vertical-align: middle;text-align: center; width: 120px" align="center" rowspan="1" colspan="2">TANDA TANGAN</th>
							</tr>

						<?php

						}

						$sum_kehadiran = 16;
						$kehadiran = 0;

						for ($int = 1; $int <= $sum_kehadiran; $int++){
							$hr_ke = "hr_".$int;
							if ($mhsw->$hr_ke == 'H'){
								$kehadiran++;
							}
						}

						$kehadiran = ($kehadiran/$sum_kehadiran) * 100;

						$y = 2;
						$result = fmod($a,$y);
						//echo $result."<br>";
						if($result == 1){
					?>
						<tr>
							<td align="center"><?= $a ?></td>
							<td><?= $mhsw->NIM ?></td>
							<td><?= $mhsw->Name ?></td>
							<td align="center"><?= $kehadiran ?> %</td>
							<td align="center">A  A-  B+  B  B-  C  D  E</td>
							<!-- <td align="center"><?= $mhsw->GradeNilai ?></td> -->
							<!--<td align="center"><?= $mhsw->Bobot ?></td>-->
							<td align="left"><?= $a ?>.</td>
							<td align="center"></td>
						</tr>
					<?php
						} else {
					?>
						<tr>
							<td align="center"><?= $a ?></td>
							<td><?= $mhsw->NIM ?></td>
							<td><?= $mhsw->Name ?></td>
							<td align="center"><?= $kehadiran ?> %</td>
							<td align="center">A   A-   B+   B   B-   C   D   E</td>
							<!-- <td align="center"><?= $mhsw->GradeNilai ?></td> -->
							<!--<td align="center"><?= $mhsw->Bobot ?></td>-->
							<td align="left"></td>
							<td align="left"><?= $a ?>.</td>
						</tr>
					<?php
						}

						if ($a == 30 or $a == 60){

						echo "</table><div class='page-break'></div>";

						}

						$a++;
						/*if ($a >= 26 and $a <= 50){
							echo '<div class="page-break"></div>';
						}*/
					}
					?>
					</table>
			</div>
		</div><br><br>
		<div class="row">
			<div class="col-md-8" style="display: block;">

			</div>
			<div class="col-md-4" style="display: block;">
				<?= $tempat.", ".$tglnow ?><br>
				Yang membuat,<br><br><br><br>
				<?php
				if (!empty($detailJadwal->Dosen)){
				?>
					<?= $detailJadwal->Dosen ?><br><?= $detailJadwal->nipdosen ?>
				<?php
				} else {
				?>
					( ............................ )
				<?php
				}
				?>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="<?= base_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
</body>
</html>
