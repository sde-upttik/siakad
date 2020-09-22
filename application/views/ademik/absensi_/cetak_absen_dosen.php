<!DOCTYPE html>
<html>
<head>

	<title>ABSEN DOSEN</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/components/bootstrap/dist/css/bootstrap.min.css
'); ?>">

	<style type="text/css">
		#logo_untad{
		    position: absolute;
		    left: 0px;
		    top: 0px;
		    z-index: -1;
		    float: left;
		}
	</style>
</head>
<body>
	<div id="pdf">
		<div class="col-md-12">
			<div class="row">
					<img id="logo_untad" src="./assets/images/Logo_untad.png" width="80px" style="float:left" >
					<div>
						<table width="100%">
							<tr>
								<th align="center"><h3>KEMENTRIAN RISET, TEKNOLOGI, DAN PENDIDIKAN TINGGI</h3></th>
							</tr>
							<tr>
								<th align="center"><h3>UNIVERSITAS TADULAKO</h3></th>
							</tr>
							<tr>
								<th align="center"><h3>DAFTAR HADIR DOSEN</h3></th>
							</tr>
						</table>			
					</div>			
			</div>
		</div>
		<hr style="margin-top: 5px; background: black; height: 5px;">

		<table style="margin-bottom: 10px">
			<tr>
				<th align="left" width="100px">Program</th>
				<td width="2px">:</td>
				<td style="width: 300px" align="left"><?php echo $data_jadwal[0]['Program']; ?></td>
				<th align="left" width="80px">Hari</th>
				<td>:</td>
				<td><?php echo $data_jadwal[0]['Hari']; ?></td>
			</tr>
			<tr>
				<th align="left" >Semester</th>
				<td width="2px">:</td>
				<td>
					<?php
						$tahun 				= $data_jadwal[0]['Tahun'];
						$semester_ 			= substr($tahun, -1 );
						$tahun_semester_1 	= substr($tahun, 0, 4); 
						$tahun_semester_2 	= $tahun_semester_1 + 1; 

						if ($semester_ == '1') {
							echo "GASAL ".$tahun_semester_1." - ".$tahun_semester_2;
						}
						else{
							echo "GENAP ".$tahun_semester_1." - ".$tahun_semester_2;
						}
					 ?>
				</td>
				<th align="left" >Waktu</th>
				<td>:</td>
				<td><?php echo $data_jadwal[0]['JamMulai'].'-'.$data_jadwal[0]['JamSelesai']?></td>
			</tr>
			<tr>
				<th align="left" >Jurusan</th>
				<td>:</td>
				<td><?php echo $data_jadwal[0]['nama_jurusan']; ?></td>
				<th align="left" >Ruang</th>
				<td>:</td>
				<td><?php echo $data_jadwal[0]['KodeRuang']; ?></td>
			</tr>
			<tr>
				<th align="left" >Mata Kuliah</th>
				<td>:</td>
				<td style="width: 500px" align="left">
					<?php echo $data_jadwal[0]['KodeMK'].'-'.$data_jadwal[0]['NamaMK'].'-('.$data_jadwal[0]['SKS'].')'; ?>
				</td>
			</tr>
		</table>	

		<table id="table_absen" style="font-size: 14px; width: 100%; margin-bottom: 10px; border:1px solid black; border-collapse: collapse; " border="1" class="table-bordered">
			<thead>
				<tr>
					<th rowspan="2">No.</th>
					<th rowspan="2">Nama Dosen</th>
					<th colspan="16">Pertemuan ke </th>
					<th rowspan="2">Keterangan</th>
				</tr>
				<tr>
					<?php for ($i=1; $i <=16 ; $i++) { ?>
						<th><?php echo $i; ?></th>
					<?php }; ?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td align="center">1</td>
					<td><?php echo $data_jadwal[0]['nama_dosen'] ?></td>
					<?php for ($i=1; $i <=16 ; $i++) { ?>
						<td width="40"></td>
					<?php }; ?>
					<td> </td>
				</tr>
				<?php $u = 2;  foreach ($data_asisten_dosen as $asisten_dosen) { ?>
					<tr>
						<td align="center"><?php echo $u; ?></td>
						<td><?php echo $asisten_dosen['nama_assdosen']; ?></td>
							<?php for ($i=1; $i <=16 ; $i++) { ?>
								<td width="40"></td>
							<?php }; ?>
						<td></td>
					</tr>
				<?php $u++; } ?>		
			</tbody>
		</table>
		<div class="row" style="padding-left: 80%">
			<dl>
				<dt>Palu, <?php echo date("d-m-Y"); ?></dt>
				<dt>Dosen Penanggung Jawab,</dt>
				<br><br><br>
				<dt><?php echo $data_jadwal[0]['nama_dosen']; ?></dt>
				<dt>NIP.<?php echo $data_jadwal[0]['IDDosen']; ?></dt>
			</dl>
		</div>
		<?php 
			if($this->session->userdata('kdf') == "D" || $this->session->userdata('ulevel') == "1" ){
		 ?>
		<pagebreak></pagebreak>
		<div id="subAbsen">
			<div class="col-md-12">
				<div class="row">
						<img id="logo_untad" src="./assets/images/Logo_untad.png" width="80px" style="float:left" >
						<div>
							<table width="100%">
								<tr>
									<th align="center"><h3>KEMENTRIAN RISET, TEKNOLOGI, DAN PENDIDIKAN TINGGI</h3></th>
								</tr>
								<tr>
									<th align="center"><h3>UNIVERSITAS TADULAKO</h3></th>
								</tr>
								<tr>
									<th align="center"><h3>DAFTAR HADIR DOSEN</h3></th>
								</tr>
							</table>			
						</div>			
				</div>
			</div>

			<hr style="margin-top: 5px; background: black; height: 5px;">

			<table style="margin-bottom: 10px">
				<tr>
					<th align="left" width="100px">Program</th>
					<td width="2px">:</td>
					<td style="width: 300px" align="left"><?php echo $data_jadwal[0]['Program']; ?></td>
					<th align="left" width="80px">Hari</th>
					<td>:</td>
					<td><?php echo $data_jadwal[0]['Hari']; ?></td>
				</tr>
				<tr>
					<th align="left" >Semester</th>
					<td width="2px">:</td>
					<td>
						<?php
							$tahun 				= $data_jadwal[0]['Tahun'];
							$semester_ 			= substr($tahun, -1 );
							$tahun_semester_1 	= substr($tahun, 0, 4); 
							$tahun_semester_2 	= $tahun_semester_1 + 1; 

							if ($semester_ == '1') {
								echo "GASAL ".$tahun_semester_1." - ".$tahun_semester_2;
							}
							else{
								echo "GENAP ".$tahun_semester_1." - ".$tahun_semester_2;
							}
						 ?>
					</td>
					<th align="left" >Waktu</th>
					<td>:</td>
					<td><?php echo $data_jadwal[0]['JamMulai'].'-'.$data_jadwal[0]['JamSelesai']?></td>
				</tr>
				<tr>
					<th align="left" >Jurusan</th>
					<td>:</td>
					<td><?php echo $data_jadwal[0]['nama_jurusan']; ?></td>
					<th align="left" >Ruang</th>
					<td>:</td>
					<td><?php echo $data_jadwal[0]['KodeRuang']; ?></td>
				</tr>
				<tr>
					<th align="left" >Mata Kuliah</th>
					<td>:</td>
					<td style="width: 500px" align="left">
						<?php echo $data_jadwal[0]['KodeMK'].'-'.$data_jadwal[0]['NamaMK'].'-('.$data_jadwal[0]['SKS'].')'; ?>
					</td>
				</tr>
			</table>	

			<table  id="table_absen2" style="font-size: 14px; width: 100%; margin-bottom: 10px; border:1px solid black; border-collapse: collapse; " border="1" class="table-bordered">
				<thead>
					<tr>
						<th>No.</th>
						<th>Tanggal</th>
						<th>Pokok Bahasan</th>
						<th>Dosen Pengasuh</th>
						<th>Tanda Tangan</th>
					</tr>
				</thead>
				<tbody>
					<tr >
						<td style="height: 60px; width: 10px">1.</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr >
						<td style="height: 60px; width: 10px">2.</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td style="height: 60px; width: 10px">3.</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td style="height: 60px; width: 10px">4.</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>
			<div class="row" style="padding-left: 80%">
				<dl>
					<dt>Palu, <?php echo date("d-m-Y"); ?></dt>
					<dt>Dosen Penanggung Jawab,</dt>
					<br><br><br>
					<dt><?php echo $data_jadwal[0]['nama_dosen']; ?></dt>
					<dt>NIP.<?php echo $data_jadwal[0]['IDDosen']; ?></dt>
				</dl>
			</div>
		</div>
		<?php } ?>

	</div>

<body>
</html>