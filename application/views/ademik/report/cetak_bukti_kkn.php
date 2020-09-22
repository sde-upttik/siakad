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
	
	<?php 	$harga = "Rp. 630.000,-"; 
			//$angkatan_kkn = "90";
			//$tahun_kkn = "20182";
	?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 text-center">
				<table width=95% style='border-bottom:1px solid; margin-left:2.5%;'>
	    			<tr>
	    				<td style='text-align:center; font-size:16;'><b>SURAT PENGANTAR PEMBAYARAN KE BANK BNI</b></td>
	    			</tr>
	    			<tr>
	    				<td style='text-align:center; font-size:15;'><b>UNIVERSITAS TADULAKO</b></td>
	    			</tr>
	    		</table>
	    		<br>
			<table class=basic cellspacing=0 cellpadding=2 width=100%>
		<tr><td valign=top>
		  <table class=basic cellspacing=0 cellpadding=2>
		  <tr><td>STAMBUK</td><td>: <?= $nim ?></td></tr>
		  <tr><td>Nama Mahasiswa</td><td>: <?= $nama ?></td></tr>
		  <tr><td>Nominal</td><td>: <?= $harga ?></td></tr>
		  <tr><td>Keterangan</td><td>: Untuk Pembayaran KKN Semester Ganjil 20201</td></tr>
		  <tr><td colspan=2>Setelah selesai pembayaran, silahkan Login di kkn.untad.ac.id</td></tr>
		  </table>
		</td>
		</tr>
		</table>
		<table class=basic width=100%>
			<tr>
				<br>
				<td width=32%></td>
				<td width=32%></td>
				<td style='text-align:center'>TTD</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td><br><br><br><br></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<br>
				<td style='text-align:center'><b><u><?= $nama ?></u></b><br><?= $nim ?></td>
			</tr>
		</table>
	</div>

	<script type="text/javascript" src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>