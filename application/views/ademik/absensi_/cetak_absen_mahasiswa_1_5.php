<!DOCTYPE html>
<html>
<head>
	<title>ABSEN MAHASISWA PERTEMUAN</title>
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

        .text {
                display: block;
                width: 200px;
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
        }
	</style>
</head>
<body>
<div class="row">
	<div class="col-md-12 text-center">
		<h1 align="center">
			<b>
				DAFTAR HADIR KULIAH <br>
				<?php
					$tahun 				= $data_jadwal[0]['Tahun'];
					$semester 			= substr($tahun, -1 );
					$tahun_semester_1 	= substr($tahun, 0, 4); 
					$tahun_semester_2 	= $tahun_semester_1 + 1; 

					if ($semester == "1") {
						echo "<th align=center>SEMESTER GASAL ".$tahun_semester_1." - ".$tahun_semester_2."</th>";
					}
					else{
						echo "<th align=center>SEMESTER GENAP ".$tahun_semester_1." - ".$tahun_semester_2."</th>";
					}
				?>
			</b>
		</h1>
		<h2 align="center"><b>
			<?php 
				echo $data_jadwal[0]['nama_fakultas'];
			 ?>
		</b></h2><br><br>
        <div align="center">
    		<img style="width: 120px;" src="<?= './assets/images/Logo_untad.png' ?>"><br><br><br>                
        </div>
		<h3 align="center"><b>
			<?php echo $data_jadwal[0]['nama_jurusan']; ?>
			<br>
			<?php echo $data_jadwal[0]['NamaMK']; ?>
			<br><br><br>
			<small>DOSEN :</small></b><br>
			<?php echo $data_jadwal[0]['nama_dosen']; ?>
		</h3>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table align="center" style="font-size: 23px; font-weight: bold;">
			<tr>
				<td>Hari</td>
				<td>: <?php echo $data_jadwal[0]['Hari']; ?></td>
			</tr>
			<tr>
				<td>Jam</td>
				<td>: <?php echo $data_jadwal[0]['JamMulai']."-".$data_jadwal[0]['JamSelesai']; ?> </td>
			</tr>
			<tr>
				<td>Ruang</td>
				<td>: <?php echo $data_jadwal[0]['KodeRuang'] ?></td>
			</tr>
			<tr>
				<td>Kelas</td>
				<td>: <?php echo $data_jadwal[0]['Kelas'] ?></td>
			</tr>
		</table>
	</div>
</div>

<div style="page-break-after: always;"></div>

	<div id="pdf">
		<div class="col-md-12">
			<div class="row">
					<img id="logo_untad" src="./assets/images/Logo_untad.png" width="100px" style="float:left;">
					<div>
						<table width="100%">
							<tr>
								<th align="center"><h3>KEMENTRIAN RISET, TEKNOLOGI, DAN PENDIDIKAN TINGGI</h3></th>
							</tr>
							<tr>
								<th align="center">UNIVERSITAS TADULAKO</th>
							</tr>
							<tr>
								<th align="center">DAFTAR HADIR KULIAH</th>
							</tr>
							<tr>
								<?php
									$tahun 				= $data_jadwal[0]['Tahun'];
									$semester 			= substr($tahun, -1 );
									$tahun_semester_1 	= substr($tahun, 0, 4); 
									$tahun_semester_2 	= $tahun_semester_1 + 1; 

									if ($semester == "1") {
										echo "<th align=center>SEMESTER GASAL ".$tahun_semester_1." - ".$tahun_semester_2."</th>";
									}
									else{
										echo "<th align=center>SEMESTER GENAP ".$tahun_semester_1." - ".$tahun_semester_2."</th>";
									}
								?>
							</tr>
						</table>			
					</div>			
			</div>
		</div>

		<hr style="margin-top: 5px; background: black; height: 5px;">

			<table style="margin-bottom: 10px">
				<tr>
					<th align="left" width="100px">Mata Kuliah </th>
					<td width="2px">:</td>
					<td style="width: 300px" align="left"><?php echo $data_jadwal[0]['NamaMK']; ?></td>
					<th align="left" width="150px">Program Studi</th>
					<td>:</td>
					<td style="width: 300px" align="left"><?php echo $data_jadwal[0]['nama_jurusan']; ?></td>
				</tr>
				<tr>
					<th align="left" >Dosen</th>
					<td width="2px">:</td>
					<td><?php echo $data_jadwal[0]['nama_dosen']; ?></td>
					<th align="left" >Kelas</th>
					<td>:</td>
					<td><?php echo $data_jadwal[0]['Kelas']; ?></td>
				</tr>
				<tr>
					<th align="left" >Ruang</th>
					<td>:</td>
					<td><?php echo $data_jadwal[0]['KodeRuang']; ?></td>
					<th align="left" >Hari</th>
					<td>:</td>
					<td><?php echo $data_jadwal[0]['Hari']; ?></td>
				</tr>
				<tr>
					<th align="left" ></th>
					<td></td>
					<td></td>
					<th align="left" >Waktu</th>
					<td>:</td>
					<td><?php echo $data_jadwal[0]['JamMulai']."-".$data_jadwal[0]['JamSelesai']; ?></td>
				</tr>
			</table>	

		<table id="table_absen" style="font-size: 14px; width: 100%; margin-bottom: 10px; border:1px solid black; border-collapse: collapse; " border="1" class="table-bordered">
			<thead>
				<tr>
					<th rowspan="2">No.</th>
					<th rowspan="2">NIM</th>
					<th rowspan="2" class="col-md-3">Nama Mahasiswa</th>
					<th colspan="5">Pertemuan ke </th>
					<th rowspan="2">Keterangan</th>
				</tr>
				<tr>
					<?php for ($i=$start; $i <= $end ; $i++) { 
						echo "<th>".$i."</th>";
					} ?>
				</tr>
			</thead>
			<tbody>
				<?php $no=1; foreach ($data_jadwal as $mahasiswa) { ?>
				<tr>
					<td height="25px;" width="20px;"><?php echo $no; ?></td>
					<td width="100px;" height="35px;"><?php echo $mahasiswa['NIM']; ?></td>
					<td class="text"><?php echo $mahasiswa['nama_mahasiswa']; ?></td>
					<td width="100px;"> </td>
					<td width="100px;"> </td>
					<td width="100px;"> </td>
					<td width="100px;"> </td>
					<td width="100px;"> </td>
					<td> </td>
				</tr>
                <?php
                    if(count($data_jadwal) < 15 && $no == 10 ){
                        echo '
                                    </tbody>
                                </table>
                                <pagebreak>
                                <table id="table_absen" style="font-size: 14px; width: 100%; margin-bottom: 10px; border:1px solid black; border-collapse: collapse; " border="1" class="table-bordered">
                                    <tbody>
                            ';
                    }
                
                    $no++; } 
                ?>
			</tbody>
		</table>
		<div class="row" style="padding-left: 65%">
			<dl>
				<dd>Palu, <?php echo date("d-m-Y"); ?></dd>
				<dd>Yang Membuat,</dd>
				<br><br><br>
				<dd><?php echo $data_jadwal[0]['nama_dosen']; ?></dd>
				<dd>NIP.<?php echo $data_jadwal[0]['IDDosen']; ?></dd>
			</dl>
		</div>
	</div>
<body>
</html>

