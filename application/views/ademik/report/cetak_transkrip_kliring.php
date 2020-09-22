<!DOCTYPE html>
<html>
<head>
	<title>Cetak Transkrip Nilai Kliring</title>
	<!-- <link rel="stylesheet" type="text/css" href="<?= base_url('assets/components/bootstrap/dist/css/bootstrap.min.css'); ?>"> -->
	<!-- <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
	<style type="text/css">
		body{
			font-family: times;
		}
		h4, h3, h2 {
			margin: 0px;
			padding: 0px;
		}
		.count td{
			padding-right: 20px;
		}
		#logo_untad{
		    position: absolute;
		    left: 0px;
		    top: 0px;
		    z-index: -1;
		    float: left;
		}
		.page-break {
			display: block;
			page-break-before: always;
		}
		table.table-mk, .table-mk td, .table-mk th{border: 1px solid black; border-collapse: collapse;}
	</style>
</head>
<body>
	<div style="display: block;">
		<div style="font-size: 12px;" style="display: block;">
			<?php
				$this->load->view('ademik/report/kop_surat');
			?>
			<table>
				<?php $Nama = str_replace("\'", "'", $name);?>
				<tr>
					<td style="color: white">/</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Nama/<i>Name</i></td>
					<td style="width: 10px" align="right">:</td>
					<td style="width: 210px;"><b><?=$Nama?></b></td>

					<td>Tempat Lahir/ <i>Place Of Birth</i></td>
					<td align="right">:</td>
					<td><b><?=$tmptlahir?></b></td>
				</tr>
				<tr>
					<td>No. Stambuk/ <i>Student Number</i></td>
					<td align="right">:</td>
					<td><b><?=$nim?></b></td>

					<td">Tanggal Lahir/ <i>Date Of Birth</i></td>
					<td style="width: 10px" align="right">:</td>
					<td"><b><?=$tgllahir?>/<br><i><?=$tgllahir_ing?></i></b></td>
				</tr>
				<tr>
					<td>Fakultas/<i>Faculty</i></td>
					<td align="right">:</td>
					<td><b>
							<?=$nama_fak?>/<i>(<?=$nama_fak_ing?>)</i>
					</b></td>
					<td> Studi/ <i>Study Program</i></td>
					<td align="right">:</td>
					<td><b>
						<?=$nama_prodi?>/<i>(<?=$nama_prodi_ing?>)</i>
					</b></td>
				</tr>
				<?php if ( empty($tgllulus) or $tgllulus == '1 Januari 1970' ) {

					} else { ?>

						<tr>
							<td>Tanggal Lulus Program Sarjana</i></td>
							<td align="right">:</td>
							<td><b>
									<?=$tgllulus?>
							</b></td>
							<td><i>Date Degree Conferred</i></td>
							<td align="right">:</td>
							<td><b>
								<i><?=$tgllulus_ing?></i>
							</b></td>
						</tr>

				<?php } ?>
			</table>
		</div>
		<br>
		<div class="row">
			<div class="col-md-12" style="font-size: 11px;">
				<table class="table-mk" style="width: 100%">
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

					<?=$detailnilai?>

					<?php
					if (empty($detailnilai1)){ ?>
						<tr>
							<th style="vertical-align:middle; text-align: center;"></th>
							<th style="vertical-align:middle; text-align: center;">Jumlah</th>
							<th style="vertical-align:middle; text-align: center;"><?=$tskslulus?></th>
							<th style="vertical-align:middle; text-align: center;"></th>
							<th style="vertical-align:middle; text-align: center;"></th>
							<th style="vertical-align:middle; text-align: center;"><?=$t_k_n?></th>
							<th style="vertical-align:middle; text-align: center;"></th>
						</tr>
					<?php } ?>
				</table>

				<?php if (!empty($detailnilai1)){ ?>
				<div class="page-break"></div>
				<table class="table-mk" style="width: 100%;">
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

					<?=$detailnilai1?>

						<tr>
							<th style="vertical-align:middle; text-align: center;"></th>
							<th style="vertical-align:middle; text-align: center;">Jumlah</th>
							<th style="vertical-align:middle; text-align: center;"><?=$tskslulus?></th>
							<th style="vertical-align:middle; text-align: center;"></th>
							<th style="vertical-align:middle; text-align: center;"></th>
							<th style="vertical-align:middle; text-align: center;"><?=$t_k_n?></th>
							<th style="vertical-align:middle; text-align: center;"></th>
						</tr>

				</table>
				<?php } ?>
			</div>
		</div>
		<br>
		<br>
		<div class="row" style="font-size: 11px">
			<div class="col-md-12">
				<table>
					<tr>
						<?php if (empty($judulTA2)){ ?>
							<td align="right" valign="top" style="width: 150px;">DENGAN JUDUL PROPOSAL : </td>
						<?php } else { ?>
							<td align="right" valign="top" style="width: 150px;">DENGAN JUDUL SKRIPSI : </td>
						<?php } ?> 
							<td><?=$judulTA."/".$judulTA2?></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row" style="margin-top: 15px; font-size: 11px">
			<div class="col-md-12">
				<table class="count">
					<tr>
						<td>INDEKS PRESTASI<br><i>Grade Point of Academic</i></td>
						<td>=</td>
						<td align="center" style="font-weight: bold;"><u>Jumlah (K x N)</u><br>Total SKS</td>
						<td style="width: 130px" align="center" style="font-weight: bold;"><i><u>Total (K x N)</u><br>Total SKS</i></td>
						<!--<td style="font-weight: bold;">= <?=$ipk?></td> -->
						<td style="font-weight: bold;">= <?=number_format($t_k_n/$tskslulus,2)?></td>
						<?php
						if ($keterangan != ""){ ?>
							<td>ATAU YUDISIUM<br><i>Yudicium</i></td>
							<td><b><?=$keterangan?></b><br><i><?=$keterangane?></i></td>
						<?php }
						?>
					</tr>
				</table>
			</div>
		</div>
		<br>
		<br>
		<?php // kondisi unuk mahasiswa yang sudah skripsi
		// if ($kode_fak == "C"){ 
		?>
		<?php
			if ($countRow == 40) {
				echo '<div class="page-break"></div>';
			}
		?>

		<div style="font-size: 11px;">
			<table style="width: 100%">
				<tr>
					<td></td>
					<td style="color: white;">teeeeeeeeeeeeeeeeeeeeeeeeeeeeeees</td>
					<td style="text-align: left; font-size: 13px;">Palu, <?=$tglnow?></td>
				</tr>
				<tr>
					<td style="text-align: left; font-size: 13px;"><?=$TTJabatanTn1?></td>
					<td></td>
					<td style="text-align: left; font-size: 13px;"><?=$TTJabatanTn2?></td>
				</tr>
				<tr>
					<td style="color: white">/</td>
					<td></td>
					<td style="color: white">/</td>				
				</tr>
				<tr>
					<td style="color: white">/</td>
					<td></td>
					<td style="color: white">/</td>				
				</tr>
				<tr>
					<td style="color: white">/</td>
					<td></td>
					<td style="color: white">/</td>				
				</tr>
				<tr>
					<td style="text-align: left; font-size: 13px;"><?=$TTPejabatTn1?></td>
					<td></td>
					<td style="text-align: left; font-size: 13px;"><?=$TTPejabatTn2?></td>
				</tr>
				<tr>
					<td style="text-align: left; font-size: 13px;"><?=$TTnippejabatTn1?><br></td>
					<td></td>
					<td style="text-align: left; font-size: 13px;"><?=$TTnippejabatTn2?></td>
				</tr>
			</table>
			<br />
			<br />
			<br />
			<table style="width: 100%">
				<tr>
					<td style="text-align: center; font-size: 13px;"><?=$TTJabatanTn3?></td>
				</tr>
				<tr>
					<td style="color: white">/</td>
				</tr>
				<tr>
					<td style="color: white">/</td>
				</tr>
				<tr>
					<td style="color: white">/</td>
				</tr>
				<tr>
					<td style="text-align: center; font-size: 13px;"><?=$TTPejabatTn3?></td>
				</tr>
				<tr>
					<td style="text-align: center; font-size: 13px;"><?=$TTnippejabatTn3?></td>
				</tr>
			</table>
		</div>
		<br>
		<?php
		if ($this->session->userdata('ulevel') == 1 or $this->session->userdata('ulevel') == 5 or $this->session->userdata('ulevel') == 7){
		?>
		<div class="row" style="margin-top: 15px; font-size: 11px">
			<div class="col-md-12">
				<!-- <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=<?=$enkripsi?>"/> -->
				<img style="width: 150px" src="./assets/images/qrcode/<?= $nim.".png" ?>"/>
			</div>
		</div>
		<?php
		}
		?>

		<?php /* } else {

			if ($keterangan != "") { */
				?>
				<!-- <div class="row" style="font-size: 11px;">
					<div class="col-md-8">
						<br>
						<?=$nmpejabat3?>
						<br><br><br><br>
						<?=$ttjabatan3?><br>
						<?=$nippejabat3?>
					</div>
					<div class="col-md-4" style="margin-left: 500px">
						Palu, <?=$tglnow?><br>
						<?=$nmpejabat1?>
						<br><br><br>
						<?=$ttjabatan1?><br>
						<?=$nippejabat1?>
					</div>
				</div>
				<div class="row" style="font-size: 11px;">
					<div class="col-md-12 text-center">
						<?=$nmpejabat2?>
						<br><br><br>
						<?=$ttjabatan2?><br>
						<?=$nippejabat2?>
					</div>
				</div> -->
			<?php // } else { // kondisi unuk mahasiswa yang belum skripsi (proposal) ?>
				<!-- <div class="row" style="font-size: 11px;">
					<div class="col-md-8">
						<br>
						<?=$nmpejabat3?>
						<br><br><br>
						<?=$ttjabatan3?><br>
						<?=$nippejabat3?>
					</div>
					<div class="col-md-4" style="margin-left: 500px">
						Palu, <?=$tglnow?><br>
						<?=$nmpejabat1?>
						<br><br><br>
						<?=$ttjabatan1?><br>
						<?=$nippejabat1?>
					</div>
				</div> -->
			<?php /*}

		} */ ?>

	</div>
	<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script> -->
	<script type="text/javascript" src="<?= base_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
	<!-- <script type="text/javascript" src="<?= base_url('assets/components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script> -->
</body>
</html>
