<!DOCTYPE html>
<html>
<head>
	<title>Jadwal Kuliah</title>
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

<!-- 	<pre>
		<?php 
			echo $this->db->last_query();
		 ?>
	</pre> -->

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 text-center">
				<h4><b>Jadwal Kuliah</b></h4><br><br>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table-bordered">
					<tr>
						<td style="text-align: center;" colspan="2"><b>Semester Akademik</b></td>
					</tr>
					<tr>
						<td>Semester Akademik</td>
						<td>: <b><?=$kodetahun." - ".$nama?></b></td>
					</tr>
					<tr>
						<td>Program</td>
						<td>: <b><?=$kdprogram?></b></td>
					</tr>
					<tr>
						<td>Jurusan</td>
						<td>: <b><?=$kodejurusan." - ".$namajurusan?></b></td>
					</tr>
				</table>
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="col-md-12">
				<table border="1" style="width: 100%; font-size: 14px;">
					<?php
						$no=1;
						$hari = ""; // minggu
						foreach($detailJadwal as $detail){
							if ($hari != $detail->HR){ // "" != "minggu"
								echo "<tr>
									<th colspan='11' class='text-center' style='font-size: 20px'><b>".$detail->HR."</b></th>
								</tr>
								<tr>
									<th style='text-align: center'>No</th>
									<th style='text-align: center'>Jam</th>
									<th style='text-align: center'>Ruangan</th>
									<th style='text-align: center'>KodeMK</th>
									<th style='text-align: center'>Mata Kuliah</th>
									<th style='text-align: center'>Program</th>
									<th style='text-align: center'>Smster</th>
									<th style='text-align: center'>SKS</th>
									<th style='text-align: center'>Dosen</th>
									<th style='text-align: center'>Kelas</th>
									<th style='text-align: center'>Mahasiswa</th>
								</tr>"; 
							?>
								<tr>
									<td style="text-align: center;"><?=$no++; ?></td>
									<td style="text-align: center;"><?=$detail->jm." - ".$detail->js?></td>
									<td style="text-align: center;"><?=$detail->KodeRuang?></td>
									<td style="text-align: center;"><?=$detail->KodeMK?></td>
									<td><?=$detail->MK?></td>
									<td style="text-align: center;"><?=$detail->PRG?></td>
									<td style="text-align: center;"><?=$detail->Sesi?></td>
									<td style="text-align: center;"><?=$detail->SKS?></td>
									<td ><?=$detail->Dosen?></td>
									<td style="text-align: center;"><?=$detail->Keterangan?></td>
									<td style="text-align: center;"><?=$detail->jml_mhsw?></td>
								</tr>
					<?php
						$hari = $detail->HR;
							} else { ?>
								<tr>
									<td style="text-align: center;"><?=$no++; ?></td>
									<td style="text-align: center;"><?=$detail->jm." - ".$detail->js?></td>
									<td style="text-align: center;"><?=$detail->KodeRuang?></td>
									<td style="text-align: center;"><?=$detail->KodeMK?></td>
									<td><?=$detail->MK?></td>
									<td style="text-align: center;"><?=$detail->PRG?></td>
									<td style="text-align: center;"><?=$detail->Sesi?></td>
									<td style="text-align: center;"><?=$detail->SKS?></td>
									<td><?=$detail->Dosen?></td>
									<td style="text-align: center;"><?=$detail->Keterangan?></td>
									<td style="text-align: center;"><?=$detail->Kapasitas?></td>
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