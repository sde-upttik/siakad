 <?php
	$jumlahPertemuan = 0;
	for ($i=1; $i <= 36 ; $i++) { 
		if ($data_cpna[0]['abd_'.$i] != null && $data_cpna[0]['abd_'.$i] != '0000-00-00') {
			$jumlahPertemuan = $jumlahPertemuan + 1;
		}
	} 


	if($data_asdos == null){
		$data_asdos = "-";
	}else{
		$data_asdos = $data_asdos;
	}

?>



<!DOCTYPE html>
<html>
<head>
	<title>DPNA</title>

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
                                    <h3>KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN</h3>
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
									elseif ($semester == "2") {
										echo "<th align=center>SEMESTER GENAP ".$tahun_semester_1." - ".$tahun_semester_2."</th>";
									}
									else{
										echo "<th align=center>SEMESTER PENDEK ".$tahun_semester_1." - ".$tahun_semester_2."</th>";
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
					<td style="width: 300px" align="left"><?php echo $data_cpna[0]['nama_jurusan']; ?> (<?= $data_cpna[0]['Program'] ?>)</td>
				</tr>
				<tr>
					<th align="left" >Dosen Penanggung Jawab</th>
					<td width="2px">:</td>
					<td><?php echo $data_cpna[0]['nama_dosen']; ?></td>
					<th align="left" >Kelas</th>
					<td>:</td>
					<td><?php echo $data_cpna[0]['Keterangan']; ?></td>
				</tr>
                <tr>
                    <th align="left">Dosen </th>
                    <td>:</td>
                    <td>
                    	<table>
                    		<?php foreach( $data_asdos as $asdos){?>
                    		<tr>
                    			<td><?= $asdos['nama_assdosen'] ?></td>
                    		</tr>
                			<?php } ?>
                    	</table>
                    </td>
                </tr>
			</table>	
		<?php echo ""; ?>
		<table id="table_absen" style="font-size: 14px;margin-bottom: 10px; border:1px solid black; border-collapse: collapse; " border="1" class="table-bordered">
			<thead>
				<tr>
					<th rowspan="2">No.</th>
					<th rowspan="2">NIM</th>
					<th rowspan="2">Nama Mahasiswa</th>
					<th rowspan="2">Kehadiran</th>
					<th colspan="3">Unsur Penilaian</th>
					<th rowspan="2">Nilai Akhir</th>
					
					<?php if($this->session->userdata("kdf") == "D"){ ?>
						<th rowspan="2" colspan="12" width="150px;">Nilai</th>
					<?php }else if($this->session->userdata("kdf") == "C"){ ?>
						<th rowspan="2" colspan="8" width="150px;">Nilai</th>
					<?php }else if($this->session->userdata("kdf") == "K2M" || $this->session->userdata("kdf") == "O"){ ?>
						<th rowspan="2" colspan="9" width="150px;">Nilai</th>
					<?php }else if($this->session->userdata("kdf") == "P"||$this->session->userdata("kdf") == "E"){ ?>
						<th rowspan="2" colspan="10" width="150px;">Nilai</th>
					<?php }else if($this->session->userdata("kdf") == "A" || $this->session->userdata("kdf") == "F"){ ?>
						<th rowspan="2" colspan="8" width="150px;">Nilai</th>
					<?php }else{ ?>
						<th rowspan="2" colspan="11" width="150px;">Nilai</th>
					<?php } ?>
					
					<th rowspan="2" colspan="2" width="200px;">Tanda Tangan</th>
				</tr>
				<tr>
					<th >Tugas(...)%</th>
					<th >UTS(...)%</th>
					<th >UAS(...)%</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$no= 1; 
					foreach ($data_cpna as $cpna) { 
                ?>
					<tr >
						<td height="50px" width="30px"><?php echo $no; ?></td>
						<td><?php echo $cpna['NIM']; ?></td>
						<td width="200px;"><?= ucwords(strtolower($cpna['nama_mahasiswa'])) ?></td>			
						<td align="center" width="100px;" >
							<?php 
			            		$kehadiran = 0;
			                    for ($i=1; $i <= 36 ; $i++) { 
			                        if($cpna['hr_'.$i] == 'H' || $cpna['hr_'.$i] == 'S' || $cpna['hr_'.$i] == 'I' ){
			                            $kehadiran = $kehadiran + 1;
			                        }
			                    }
			                    $persenKhehadiran 		= @($kehadiran / $jumlahPertemuan) * 100;    
			                    echo number_format((float)$persenKhehadiran, 2, '.', '')."%";
							 ?>
						</td>
						<td align="center" width="70px"></td>
						<td align="center" width="70px"></td>
						<td align="center" width="70px"></td>
						<td align="center" width="70px"></td>
						
						<?php 
							$column=0;
				        	foreach ($data_range as $range) {
				        		if ( $cpna['TahunAkademik'] >= $range['AngkatanKebawah'] && $cpna['TahunAkademik'] <= $range['AngkatanKeatas'] ) {
 									echo "<td align='center' width='30px'>".$range['Nilai']."</td>" ;
 									$column++;
				        		}else{
				        			// echo "<td align='center' width='30px'>".$range['Nilai']."</td>" ;
				        		}
				        	}

				        	If($this->session->userdata("kdf") == "C"){
					        	$coloumNilai = 8;
					        }
					        elseif($this->session->userdata("kdf") == "K2M" || $this->session->userdata("kdf") == "E" || $this->session->userdata("kdf") == "O"){
					        	$coloumNilai = 9;

					        }
					   		 elseif($this->session->userdata("kdf") == "P" ){
					        	$coloumNilai = 10;

					        }
					        elseif($this->session->userdata("kdf") == "A" || $this->session->userdata("kdf") == "F"){
					        	$coloumNilai = 8;
					        }
					        else{
					        	$coloumNilai = 11;
					        }


				        	for ($i=1; $i <= ($coloumNilai - $column) ; $i++) { 
 								echo "<td align='center' width='30px'></td>" ;
				        	}
						 ?>
						
						<?php if ($no % 2 != 0) { ?>
							<td width="100px"><?php echo $no."."; ?></td>
							<td width="100px"></td>	
						<?php }else{ ?>
							<td width="100px"></td>
							<td  width="100px"><?php echo $no."."; ?></td>
						<?php } ?>
					</tr>
                <?php
            		$no++; }
                ?>

<!-- 				<?php 
					$no= 1; 
 					if($this->session->userdata("kdf") == "D" || $this->session->userdata("ulevel") == 1){
						foreach ($data_cpna as $cpna) { 
										            		$kehadiran = 0;
		                    for ($i=1; $i <= 36 ; $i++) { 
		                        if($cpna['hr_'.$i] == 'H' || $cpna['hr_'.$i] == 'S' || $cpna['hr_'.$i] == 'I' ){
		                            $kehadiran = $kehadiran + 1;
		                        }
		                    }
		                    $persenKhehadiran 		= @($kehadiran / $jumlahPertemuan) * 100;    

				            if ($persenKhehadiran>=75) {
                ?>
					<tr >
						<td height="50px" width="30px"><?php echo $no; ?></td>
						<td><?php echo $cpna['NIM']; ?></td>
						<td width="200px;"><?= ucwords(strtolower($cpna['nama_mahasiswa'])) ?></td>			
						<td align="center" width="100px;" >
							<?php 
			            		$kehadiran = 0;
			                    for ($i=1; $i <= 36 ; $i++) { 
			                        if($cpna['hr_'.$i] == 'H' || $cpna['hr_'.$i] == 'S' || $cpna['hr_'.$i] == 'I' ){
			                            $kehadiran = $kehadiran + 1;
			                        }
			                    }
			                    $persenKhehadiran 		= @($kehadiran / $jumlahPertemuan) * 100;    
			                    echo $cpna['kehadiranTotal'] = $persenKhehadiran."%";
							 ?>
						</td>
						<td align="center" width="70px"></td>
						<td align="center" width="70px"></td>
						<td align="center" width="70px"></td>
						<td align="center" width="70px"></td>
						
						<?php 
							$column=0;
				        	foreach ($data_range as $range) {
				        		if ( $cpna['TahunAkademik'] >= $range['AngkatanKebawah'] && $cpna['TahunAkademik'] <= $range['AngkatanKeatas'] ) {
 									echo "<td align='center' width='30px'>".$range['Nilai']."</td>" ;
 									$column++;
				        		}else{
				        			// echo "<td align='center' width='30px'>".$range['Nilai']."</td>" ;
				        		}
				        	}

				        	If($this->session->userdata("kdf") == "C"){
					        	$coloumNilai = 8;
					        }
					        elseif($this->session->userdata("kdf") == "K2M"){
					        	$coloumNilai = 9;

					        }
					        elseif($this->session->userdata("kdf") == "A" || $this->session->userdata("kdf") == "F"){
					        	$coloumNilai = 8;
					        }
					        else{
					        	$coloumNilai = 11;
					        }


				        	for ($i=1; $i <= ($coloumNilai - $column) ; $i++) { 
 								echo "<td align='center' width='30px'></td>" ;
				        	}
						 ?>
						
						<?php if ($no % 2 != 0) { ?>
							<td width="100px"><?php echo $no."."; ?></td>
							<td width="100px"></td>	
						<?php }else{ ?>
							<td width="100px"></td>
							<td  width="100px"><?php echo $no."."; ?></td>
						<?php } ?>
					</tr>
                <?php   	
                   } $no++; }}
                   else{ 
 						foreach ($data_cpna as $cpna) { 
										            		$kehadiran = 0;
		                    for ($i=1; $i <= 36 ; $i++) { 
		                        if($cpna['hr_'.$i] == 'H' || $cpna['hr_'.$i] == 'S' || $cpna['hr_'.$i] == 'I' ){
		                            $kehadiran = $kehadiran + 1;
		                        }
		                    }
		                    $persenKhehadiran 		= @($kehadiran / $jumlahPertemuan) * 100;    
                ?>
					<tr >
						<td height="50px" width="30px"><?php echo $no; ?></td>
						<td><?php echo $cpna['NIM']; ?></td>
						<td width="200px;"><?= ucwords(strtolower($cpna['nama_mahasiswa'])) ?></td>			
						<td align="center" width="100px;" >
							<?php 
			            		$kehadiran = 0;
			                    for ($i=1; $i <= 36 ; $i++) { 
			                        if($cpna['hr_'.$i] == 'H' || $cpna['hr_'.$i] == 'S' || $cpna['hr_'.$i] == 'I' ){
			                            $kehadiran = $kehadiran + 1;
			                        }
			                    }
			                    $persenKhehadiran 		= @($kehadiran / $jumlahPertemuan) * 100;    
			                    echo $cpna['kehadiranTotal'] = $persenKhehadiran."%";
							 ?>
						</td>
						<td align="center" width="70px"></td>
						<td align="center" width="70px"></td>
						<td align="center" width="70px"></td>
						<td align="center" width="70px"></td>
						
						<?php 
							$column=0;
				        	foreach ($data_range as $range) {
				        		if ( $cpna['TahunAkademik'] >= $range['AngkatanKebawah'] && $cpna['TahunAkademik'] <= $range['AngkatanKeatas'] ) {
 									echo "<td align='center' width='30px'>".$range['Nilai']."</td>" ;
 									$column++;
				        		}else{
				        			// echo "<td align='center' width='30px'>".$range['Nilai']."</td>" ;
				        		}
				        	}

				        	If($this->session->userdata("kdf") == "C"){
					        	$coloumNilai = 8;
					        }
					        elseif($this->session->userdata("kdf") == "K2M" ){
					        	$coloumNilai = 9;
					        }
					        elseif($this->session->userdata("kdf") == "P" ){
					        	$coloumNilai = 9;
					        }
					        elseif($this->session->userdata("kdf") == "A" || $this->session->userdata("kdf") == "F"){
					        	$coloumNilai = 8;
					        }
					        else{
					        	$coloumNilai = 11;
					        }


				        	for ($i=1; $i <= ($coloumNilai - $column) ; $i++) { 
 								echo "<td align='center' width='30px'></td>" ;
				        	}
						 ?>
						
						<?php if ($no % 2 != 0) { ?>
							<td width="100px"><?php echo $no."."; ?></td>
							<td width="100px"></td>	
						<?php }else{ ?>
							<td width="100px"></td>
							<td  width="100px"><?php echo $no."."; ?></td>
						<?php } ?>
					</tr>               
                <?php
            		$no++; }}
                ?>		 -->
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

