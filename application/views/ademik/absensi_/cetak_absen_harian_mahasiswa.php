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

	<title>ABSEN HARIAN MAHASISWA</title>
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
									$tahun 				= $data_absen[0]['Tahun'];
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
					<td style="width: 300px" align="left"><?php echo $data_absen[0]['NamaMK'];?></td>
					<th align="left" width="150px">Program Studi</th>
					<td>:</td>
					<td style="width: 300px" align="left"><?php echo $data_absen[0]['nama_jurusan'];?></td>
				</tr>
				<tr>
					<th align="left" >Dosen</th>
					<td width="2px">:</td>
					<td><?php echo $data_absen[0]['nama_dosen'];?></td>
					<th align="left" >Kelas</th>
					<td>:</td>
					<td><?php echo $data_absen[0]['Kelas'];?></td>
				</tr>
				<tr>
					<th align="left" >Ruang</th>
					<td>:</td>
					<td><?php echo $data_absen[0]['fakultas'].'-'.$data_absen[0]['KodeRuang'];?></td>
				</tr>
			</table>	

		<b>Pertemuan ke :</b> 
		<br>
		<table id="table_absen" style="font-size: 14px; width: 100%; margin-bottom: 10px; border:1px solid black; border-collapse: collapse; " border="1" class="table-bordered">
			<thead>
				<tr>
					<th>No.</th>
					<th>NIM</th>
					<th class="col-md-3">Nama Mahasiswa</th>
					<th colspan="2" width="200px;">Tanda Tangan</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=1; foreach ($data_absen as $absen) { ?>
					<tr>
						<td align="center" height="30px"><?php echo $i; ?></td>
						<td><?php echo $absen['NIM']; ?></td>
						<td><?php echo $absen['nama_mahasiswa']; ?></td>
						<?php if ($i % 2 != 0) { ?>
							<td width="100px;"><?php echo $i."."; ?></td>
							<td width="100px;"></td>	
						<?php }else{ ?>
							<td width="100px;"></td>
							<td width="100px;"><?php echo $i."."; ?></td>
						<?php } ?>
					</tr>	
                <?php 
                    if($i == 20){
                        echo '
                                    </tbody>
                                </table>
                                <pagebreak>
                                <table id="table_absen" style="font-size: 14px; width: 100%; margin-bottom: 10px; border:1px solid black; border-collapse: collapse; " border="1" class="table-bordered">
                                    <tbody>
                            ';
                    }
                                
                    $i++;} 
                ?>
			</tbody>
		</table>
		<div class="row" style="padding-left: 70%">
			<dl>
				<dt>Palu,<?php echo date("d-m-Y"); ?></dt>
				<dt>Dosen Pengasuh,</dd>
				<br><br><br>
				<dt><?php echo $absen['nama_dosen']; ?></dd>
				<dt>NIP.<?php echo $absen['IDDosen']; ?></dd>
			</dl>
		</div>
	</div>
<body>
</html>

