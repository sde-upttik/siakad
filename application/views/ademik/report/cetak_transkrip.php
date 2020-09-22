<!DOCTYPE html>
<html>
<head>
	<title>Cetak KHS</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
	<style type="text/css">
		body{
			font-family: times;
		}
		h2, h3{
			margin: 0px;
			padding: 0px;
		}
		.count td{
			padding-right: 20px;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row" style="font-size: 12px; ">
			<div class="col-md-1">
				<img style="width: 70px" src="./assets/images/Untad.jpg'">
			</div>
			<div class="col-md-11 text-center">
				<h3><b>
					KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN
				</b></h3>
				<h2><b>
					UNIVERSITAS TADULAKO
				</b></h2>
				<h3><u>
					TRANSKRIP AKADEMIK (<i>ACADEMIC TRANSCRIPT</i>)</u>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" style="font-size: 14px;">
				<table border="0">
					<tr>
						<td>Nama/<i>Name</i></td>
						<td style="width: 10px" align="right">:</td>
						<td style="width: 210px;"><b>Maulana Syamsuri</b></td>

						<td>Tempat Lahir/ <i>Place Of Birth</i></td>
						<td align="right">:</td>
						<td><b>Palu</b></td>
					</tr>
					<tr>
						<td>No. Stambuk/ <i>Student Number</i></td>
						<td align="right">:</td>
						<td><b>F55116123</b></td>

						<td">Tanggal Lahir/ <i>Date Of Birth</i></td>
						<td style="width: 10px" align="right">:</td>
						<td"><b>24-09-1998/<br><i>(September, 24<sup>th</sup> 1998)</i></b></td>
					</tr>
					<tr>
						<td>Fakultas/<i>Faculty</i></td>
						<td align="right">:</td>
						<td><b>
								TEKNIK/<i>(Engineering)</i>
						</b></td>
						<td>Program Studi/ <i>Study Program</i></td>
						<td align="right">:</td>
						<td><b>
							TEKNIK INFORMATIKA/<i>(Informatics Engineering)</i>
						</b></td>
					</tr>
				</table>
			</div>
		</div><br><br>
		<div class="row">
			<div class="col-md-12" style="font-size: 14px;">
				<table border="1" style="width: 100%">
					<tr>
						<th style="vertical-align:middle; text-align: center;width: 5px" rowspan="2">No</th>
						<th style="vertical-align:middle; text-align: center;" rowspan="2">Mata Kuliah/<i>Courses</i></th>
						<th style="vertical-align:middle; text-align: center;width: 60px" rowspan="2">SKS/<br><i>Credit</i></th>
						<th style="vertical-align:middle; text-align: center;width: 60px" colspan="2">Nilai/<i>Grade</i></th>
						<th style="vertical-align:middle; text-align: center;width: 60px" rowspan="2">K x N/<br><i>C x G</i></th>
						<th style="vertical-align:middle; text-align: center;width: 60px" rowspan="2">Keterangan/<br><i>Remarks</i></th>
					</tr>
					<tr>
						<th style="vertical-align:middle; text-align: center;">Angka/<br><i>Number</i></th>
						<th style="vertical-align:middle; text-align: center;">Huruf/<br><i>Letter</i></th>
					</tr>
					<tr>
						<th style="vertical-align:middle; text-align: center;">1</th>
						<th style="vertical-align:middle; text-align: center;">2</th>
						<th style="vertical-align:middle; text-align: center;">3</th>
						<th style="vertical-align:middle; text-align: center;">4</th>
						<th style="vertical-align:middle; text-align: center;">5</th>
						<th style="vertical-align:middle; text-align: center;">6</th>
						<th style="vertical-align:middle; text-align: center;">7</th>
					</tr>

					<!-- Data Pertama -->
					<tr>
						<td align="center" style="border-bottom: 0px solid black;">1</td>
						<td style="border-bottom: 0px solid black;">PENDIDIKAN AGAMA / <i>RELIGIOUS EDUCATION</i></td>
						<td align="center" style="border-bottom: 0px solid black;">3.0</td>
						<td align="center" style="border-bottom: 0px solid black;">3.00</td>
						<td align="center" style="border-bottom: 0px solid black;">B</td>
						<td align="center" style="border-bottom: 0px solid black;">9</td>
						<td style="border-bottom: 0px solid black;"></td>
					</tr>

					<!-- Data Selajutnya Di Foreach -->
					<tr>
						<td align="center" style="border-bottom: 0px;border-top: 0px;">2</td>
						<td style="border-bottom: 0px;border-top: 0px;">PENDIDIKAN AGAMA / <i>RELIGIOUS EDUCATION</i></td>
						<td align="center" style="border-bottom: 0px;border-top: 0px;">3.0</td>
						<td align="center" style="border-bottom: 0px;border-top: 0px;">3.00</td>
						<td align="center" style="border-bottom: 0px;border-top: 0px;">B</td>
						<td align="center" style="border-bottom: 0px;border-top: 0px;">9</td>
						<td style="border-bottom: 0px;border-top: 0px;"></td>
					</tr>

					<!-- Data Terkhir -->
					<tr>
						<td align="center" style="border-top: 0px solid black;">3</td>
						<td style="border-top: 0px solid black;">PENDIDIKAN AGAMA / <i>RELIGIOUS EDUCATION</i></td>
						<td align="center" style="border-top: 0px solid black;">3.0</td>
						<td align="center" style="border-top: 0px solid black;">3.00</td>
						<td align="center" style="border-top: 0px solid black;">B</td>
						<td align="center" style="border-top: 0px solid black;">9</td>
						<td style="border-top: 0px solid black;"></td>
					</tr>
				</table>
			</div>
		</div><br><br>
		<div class="row">
			<div class="col-md-12" style="font-size: 12px">
				DENGAN JUDUL PROPOSAL :
			</div>
		</div>
		<div class="row" style="margin-top: 10px; font-size: 12px">
			<div class="col-md-12">
				<table class="count">
					<tr>
						<td>INDEKS PRESTASI<br><i>Grade Point of Academic</i></td>
						<td>=</td>
						<td align="center"><u>Jumlah (K x N)</u><br>Jumlah SKS</td>
						<td style="width: 130px" align="center" style="font-weight: bold;"><i><u>Total (K x N)</u><br>Total SKS</i></td>
						<td style="font-weight: Bold;">= 3,73</td>
						<td>ATAU YUDISIUM<br><i>Yudicium</i></td>
						<td><b>Cumlaude</b><br><i>Cumlaude</i></td>
					</tr>
				</table>
			</div>
		</div><br><br>
		<div class="row">
			<div class="col-md-8">
				<br>
				Ketua Jurusan
				<br><br><br><br><br>
				Yusuf Anshori, S.T.,M.T<br>
				19801027 200604 1 00 1
			</div>
			<div class="col-md-4" style="margin-left: 500px">
				Palu, 11 April 2018<br>
				Ketua Program Studi
				<br><br><br><br><br>
				Yusuf Anshori, S.T.,M.T<br>
				19801027 200604 1 00 1
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center" style="margin-top: -100px">
				<br>
				an. Dekan Wakil Dekan Bidang Akademik
				<br><br><br><br><br>
				Dr. Andi Rusdin, ST,MT,MSc<br>
				19710303 199803 1 003
			</div>
		</div>
	</div>

	<script type="text/javascript" src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>