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

	<title>DPNA</title>
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
		th{
			padding: 5px;
		}
	</style>
</head>
<body>
	<div id="pdf">
		<div class="col-md-12">
			<div class="row">
					<img id="logo_untad" src="./assets/images/Logo_untad.png" width="100px" style="float: left;" >
					<div>
						<table width="100%" >
							<tr>
								<th align="center">
                                    <h3>KEMENTRIAN RISET, TEKNOLOGI, DAN PENDIDIKAN TINGGI</h3>
                                </th>
							</tr>
							<tr>
								<th align="center">UNIVERSITAS TADULAKO</th>
							</tr>
							<tr id="cel">
								<th align="center">DAFTAR PESERTA DAN NILAI AKHIR</th>
							</tr>
							<tr>
								<?php
									$tahun 				= $data_cpna[0]['Tahun'];
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

			<table style="margin-bottom: 10px" >
				<tr>
					<th align="left" width="150">Mata Kuliah </th>
					<td width="2px">:</td>
					<td style="width: 300px" align="left"><?php echo $data_cpna[0]['NamaMK']; ?></td>
					<th align="left" width="150px">Program Studi</th>
					<td>:</td>
					<td style="width: 300px" align="left"><?php echo $data_cpna[0]['nama_jurusan']; ?></td>
				</tr>
				<tr>
					<th align="left" >Dosen</th>
					<td width="2px">:</td>
					<td><?php echo $data_cpna[0]['nama_dosen']; ?></td>
					<th align="left" >Kelas</th>
					<td>:</td>
					<td><?php echo $data_cpna[0]['Kelas']; ?></td>
				</tr>
				<tr>
					<th align="left">Asisten Dosen</th>
					<td>:</td>
					<td  ><?php echo $data_asdos;?></td>
					<th align="left" >Ruang</th>
					<td>:</td>
					<td><?php echo $data_cpna[0]['KodeRuang']; ?></td>
				</tr>
			</table>	

		<table id="table_absen" style="font-size: 14px;margin-bottom: 10px; border:1px solid black; border-collapse: collapse; " border="1" class="table-bordered">
			<thead>
				<tr>
					<th rowspan="2">No.</th>
					<th rowspan="2">NIM</th>
					<th rowspan="2" >Nama Mahasiswa</th>
					<th rowspan="2">Kehadiran</th>
					<th colspan="3">Unsur Penilaian</th>
					<th rowspan="2">Nilai Akhir</th>
					<th rowspan="2" colspan="8" width="150px;">Nilai</th>
					<th rowspan="2" colspan="2" width="200px;">Tanda Tangan</th>
				</tr>
				<tr>
					<th>Tugas(...)%</th>
					<th>UTS(...)%</th>
					<th>UAS(...)%</th>
				</tr>
			</thead>
			<tbody>
				<?php $no= 1; foreach ($data_cpna as $cpna) { 
                    $kehadiran = 0;
                    for ($i=1; $i <= 16 ; $i++) { 
                        if($cpna['hr_'.$i] == 'H' || $cpna['hr_'.$i] == 'S' || $cpna['hr_'.$i] == 'I' ){
                            $kehadiran = $kehadiran + 1;
                        }
                    }
        
                    $persenKhehadiran = ($kehadiran / 16) * 100; 
                    
                    $cpna['kehadiranTotal'] = $persenKhehadiran."%";
                    
                ?>
					<tr >
						<td height="40px" width="30px"><?php echo $no; ?></td>
						<td><?php echo $cpna['NIM']; ?></td>
						<td width="200px;"><?php echo $cpna['nama_mahasiswa']; ?></td>			
						<td width="100px;" align="center"><?php echo $cpna['kehadiranTotal']; ?></td>
						<td align="center" width="70px"></td>
						<td align="center" width="70px"></td>
						<td align="center" width="70px"></td>
						<td align="center" width="70px"></td>
						<td align="center" width="30px">A</td>
						<td align="center" width="30px">A-</td>
						<td align="center" width="30px">B+</td>
						<td align="center" width="30px">B</td>
						<td align="center" width="30px">B-</td>
						<td align="center" width="30px">C</td>
						<td align="center" width="30px">D</td>
						<td align="center" width="30px">E</td>
						<?php if ($no % 2 != 0) { ?>
							<td width="100px"><?php echo $no."."; ?></td>
							<td width="100px"></td>	
						<?php }else{ ?>
							<td width="100px"></td>
							<td  width="100px"><?php echo $no."."; ?></td>
						<?php } ?>
					</tr>
            <?php 
                            if($no == 11){
                                echo '
                                            </tbody>
                                        </table>
                                        <pagebreak>
                                        <table id="table_absen" style="font-size: 14px;margin-bottom: 10px; border:1px solid black; border-collapse: collapse; " border="1" class="table-bordered">
                                        <tbody>
                                    ';
                            }
                    $no++; } 
                ?>		
            </tbody>
        </table>
		<div class="row" style="padding-left: 70%">
			<dl>
				<dd>Palu, <?php echo date("d-m-Y"); ?></dd>
				<dd>Yang Membuat,</dd>
				<br><br><br>
				<dd><?php echo $data_cpna[0]['nama_dosen']; ?></dd>
				<dd>NIP.<?php echo $data_cpna[0]['IDDosen']; ?></dd>
			</dl>
		</div>
	</div>
<body>
</html>

