<?php 
	if($data_asdos == null){
		$data_asdos = "-";
	}else{
		$data_asdos = $data_asdos[0]['nama_assdosen'];
	}
?>


<!DOCTYPE html>
<html>
<head>

	<title>REKAP ABSEN MAHASISWA</title>
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
				<img id="logo_untad" src="./assets/images/Logo_untad.png" width="100px" style="float:left" >
				<div>
					<table width="100%">
						<tr>
							<th align="center">
								<h3>KEMENTRIAN RISET, TEKNOLOGI, DAN PENDIDIKAN TINGGI</h3>
							</th>
						</tr>
						<tr>
							<th align="center">UNIVERSITAS TADULAKO</th>
						</tr>
						<tr>
							<th align="center">DAFTAR HADIR KULIAH</th>
						</tr>
						<tr>
							<?php
								$tahun 				= $data_rekap[0]['Tahun'];
								$semester 			= substr($tahun, -1 );
								$tahun_semester_1 	= substr($tahun, 0, 4); 
								$tahun_semester_2 	= $tahun_semester_1 + 1; 

								if (semester == "1") {
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

			<table style="margin-bottom: 10px" >
				<tr>
					<th align="left" width="150">Mata Kuliah </th>
					<td width="2px">:</td>
					<td style="width: 300px" align="left"><?php echo $data_rekap[0]['NamaMK']; ?></td>
					<th align="left" width="150px">Program Studi</th>
					<td>:</td>
					<td style="width: 300px" align="left"><?php echo $data_rekap[0]['nama_jurusan']; ?></td>
				</tr>
				<tr>
					<th align="left" >Dosen Penanggung Jawab</th>
					<td width="2px">:</td>
					<td><?php echo $data_rekap[0]['nama_dosen']; ?></td>
					<th align="left" >Kelas</th>
					<td>:</td>
					<td><?php echo $data_rekap[0]['Kelas']; ?></td>
				</tr>
				<tr>
				<tr>
					<th align="left">Dosen </th>
					<td>:</td>
					<td  ><?php echo $data_asdos;?></td>
					<th align="left" >Ruang</th>
					<td>:</td>
					<td><?php echo $data_rekap[0]['KodeRuang']; ?></td>
				</tr>
			</table>


		Jumlah Tatap Muka =  <?php echo $tatap_muka; ?>
		<table id="table_absen" style="font-size: 14px; width: 100%; margin-bottom: 10px; border:1px solid black; border-collapse: collapse; " border="1" class="table-bordered">
			<thead>
				<tr>
					<th>No.</th>
					<th>NIM</th>
					<th class="col-md-3">Nama Mahasiswa</th>
					<th>Kehadiran</th>
				</tr>
			</thead>
			<tbody>
				<?php $no= 1; foreach ($data_rekap as $rekap) { ?>
					<tr>
						<td height="30px;" width="40px"><?php echo $no; ?></td>
						<td width="200px"><?php echo $rekap['NIM']; ?></td>
						<td><?php echo $rekap['nama_mahasiswa']; ?></td>
						<td align="center" width="200px"><?php echo $rekap['Hadir']; ?></td>
					</tr>
                <?php 
                 if($no == 15){
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
		<div class="row" style="padding-left: 70%">
			<dl>
				<dd>Palu, <?php echo date("d m Y"); ?></dd>
				<dd>Yang Membuat,</dd>
				<br><br><br>
				<dd><?php echo $data_rekap[0]['nama_dosen']; ?></dd>
				<dd>NIP.<?php echo $data_rekap[0]['IDDosen']; ?></dd>
			</dl>
		</div>
	</div>
<body>
</html>

