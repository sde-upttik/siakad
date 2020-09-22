<?php 
	$ci =& get_instance();
?>
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
	<?php foreach($detailmhsw as $row) { ?>
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
				<b style="font-size: 15">FAKULTAS</b><br>
				<b style="font-size: 12">KARTU UJIAN</b><br>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-12" style="font-size: 12px;">
				<table style="width: 100%">
					<tr>
						<td colspan="4"><?=$nama?></td>
					</tr>
					<tr>
						<td>NIM</td>
						<td>: <?=$row->nim?></td>
						<td>Fakultas</td>
						<td>: <?=$kodefakultas?> - <?=$namafakultas?></td>
					</tr>
					<tr>
						<td>Nama</td>
						<td>: <?=$row->Name?></td>
						<td>Program Studi</td>
						<td>: <?=$kodejurusan?> - <?=$namajurusan?></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" style="font-size: 12px;">
				<table border="1" style="width: 100%">
					<tr>
						<th rowspan="1" style="text-align: center;width: 1px">No.</th>
						<th rowspan="1" style="text-align: center;width: 100px">Kode Matakuliah</th>
						<th rowspan="1" style="text-align: center;width: 200px">Nama Matakuliah</th>
						<th rowspan="1" style="text-align: center;width: 40px">SKS</th>
						<th rowspan="1" style="text-align: center;width: 60px">Presentasi Kehadiran</th>
						<th rowspan="1" style="text-align: center;width: 40px">Keterangan</th>
					</tr>
					<?php
					$no = 1;
					foreach ($detailKrs as $detail) { 
						if($detail->Hadir>=75){
					?>
							<tr>
								<td><?=$no++?></td>
								<td><?=$detail->KodeMK?></td>
								<td><?=$detail->NamaMK?></td>
								<td><?=$detail->SKS?></td>
								<td align="center"><?= $detail->Hadir ?> %</td>
								<td></td>
							</tr>
					<?php
						}
					 } 
					?>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-10" style="display: block;">
			</div>
			<div class="col-md-2 text-center">
				<br>Palu, <?=$tglnow?><br>
				<br><br><br>
				( ............................ )
			</div>
		</div>
	</div>

	<!--<div style="page-break-after: always;"></div>-->

<?php } ?>

	<script type="text/javascript" src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>
