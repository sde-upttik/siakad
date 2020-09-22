<!DOCTYPE html>
<html>
<head>
	<title>Cetak KHS</title>
	<link rel="stylesheet" type="text/css" href="./assets/components/bootstrap/dist/css/bootstrap.min.css">
	<style type="text/css">
		body{
			font-family: times;
		}
		h2, h3{
			margin: 0px;
			padding: 0px;
		}
		.page-break {
			display: block;
			page-break-before: always;
		}
	</style>
</head>
<body>
	<?php
		foreach ($mhsw as $show) {
			$st_feederkrs = $controller->cekFeederKrs($show->NIM,$semester);
			if($show->st_feeder<=0 AND $st_feederkrs<=0 AND $semester>=20181){ // Fandu Tambahkan Tahun Semester 20181
				
			}else{
	?>
			<div class="container-fluid">
				<div class="row" style="font-size: 12px; padding-bottom: 12px">
					<div class="col-md-12" style="font-size: 14px;">
						<table style="width: 100%">
							<tr>
								<th style="vertical-align:middle; text-align: center;width: 5px">
									<img style="width: 100px" src="./assets/images/Logo_untad.png">
								</th>
								<th style="vertical-align:middle; text-align: center;" class="col-md-11 text-center">
									<h4><b>
										KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN
									</b></h4>
									<h3><b>
										UNIVERSITAS TADULAKO
									</b></h3>
									<h4>
										<?= $controller->getFak($show->NIM); ?>
									</h4>
								</th>
							</tr>
						</table>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12 text-center" style="font-size: 17px; font-weight: bold;">
						KARTU HASIL STUDI
						<br>Semester <?= $controller->getTahun($show->NIM, $semester); ?>
					</div>
				</div><br><br>
				<div class="row" style="margin-bottom: 13px;">
					<div class="col-md-12" style="font-size: 15px;">
						<table style="width: 100%">
							<tr>
								<td>NIM</td>
								<td>: <?= $show->NIM ?></td>
								<td>Program Studi</td>
								<td>:
									<?php
										$jur =$controller->getJur($jurusan);
										echo $jur->JUR."(".$jur->JEN.")";
									?>
								</td>
							</tr>
							<tr>
								<td>Nama Mahasiswa</td>
								<td>: <?= $show->Name ?></td>
								<td></td>
								<td></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" style="font-size: 13px;">
						<table border="1" style="border: 1px solid black; width: 100%; height: 100%" >
							<tr>
								<th style="width: 1px; text-align: center;" align="center">No.</th>
								<th style="width: 1px; text-align: center;" align="center">KMK</th>
								<th style="text-align: center;" align="center">Mata Kuliah</th>
								<th style="width: 1px; text-align: center;" align="center">Nilai</th>
								<th style="width: 1px; text-align: center;" align="center">Bobot(K)</th>
								<th style="width: 1px; text-align: center;" align="center">SKS(N)</th>
								<th style="width: 1px; text-align: center;" align="center">NxK</th>
								<th style="width: 1px; text-align: center;" align="center">ket</th>
							</tr>
							<?php
								$n = 0;
								$TSKS = 0;
								$TNK = 0;
								$TSKSLulus = 0;
								foreach ($controller->detailKhs($semester, $show->NIM) as $show1) {
									$n++;
									if ($show1->Tunda == 'Y') $strtnd = "T : $show1->AlasanTunda"; else $strtnd = '&nbsp;';
									$bobot = 0;
									$bobot = $show1->Bobot;
									$NK = $bobot * $show1->SKS;

									if($show1->GradeNilai=="A"||$show1->GradeNilai=="A-" ||$show1->GradeNilai=="B+" ||$show1->GradeNilai=="B" ||$show1->GradeNilai=="B-"||$show1->GradeNilai=="C+" ||$show1->GradeNilai=="C"||$show1->GradeNilai=="C-"||$show1->GradeNilai=="D"||$show1->GradeNilai=="E"||$show1->GradeNilai=="K"||$show1->GradeNilai=="T" ||$show1->GradeNilai=="" ||$show1->GradeNilai==" "){

										if(($show1->NamaMK=="Skripsi" || $show1->NamaMK=="Ko-Kurukuler" || $show1->NamaMK=="Kuliah Kerja Profesi (KKP) / KKN") && $show1->Bobot==0){ }
								    	else{
											$TNK += $NK;
											$TSKS += $show1->SKS;
								    		if($bobot>0) $TSKSLulus += $show1->SKS;
								     	}
								  	}
									$hdr = ceil($show1->Hadir);
									$mid = ceil($show1->NilaiMID);
									$tg1 = ceil($show1->Tugas1);
									$tg2 = ceil($show1->Tugas2);
									$tg3 = ceil($show1->Tugas3);
									$tg4 = ceil($show1->Tugas4);
									$ujn = ceil($show1->NilaiUjian);
									$nil = ceil($show1->Nilai);
									$KodeMK=$show1->KodeMK;
									$MK=$show1->NamaMK;
							?>
									<tr>
										<td align="center"><?= $n; ?></td>
										<td><?= $KodeMK; ?></td>
										<td>
											<?php 
												if (empty($MK)){
													echo $MK = $controller->getMatakuliah($KodeMK,$jurusan);
													// echo $controller->getMatakuliahQuery($KodeMK,$kdj);
												}else{
													echo $MK;  
												};
											?>
												
										</td>
										<td align="center"><?= $show1->GradeNilai; ?></td>
										<td align="center"><?= $bobot; ?></td>
										<td align="center"><?= $show1->SKS; ?></td>
										<td align="center"><?= $NK; ?></td>
										<td><?= $strtnd; ?></td>
									</tr>
							<?php
								}
							?>
							<tr>
								<td align="right" colspan="5">Total :</td>
								<td align="center"><?= $TSKS ?></td>
								<td align="center"><?= $TNK ?></td>
								<td></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="row" style="margin-top: 10px">
					<div class="col-md-12">
						<?php
							$total = $controller->getTotal($show->NIM,$jurusan,$semester,$fakultas);

							$IPS = $total->IPS;
							$IPK = $total->IPK;
							if ($fakultas == "B") $TotalSKS = $total->TotalSKSLulus;
							else $TotalSKS = $total->TotalSKS;
							$MaxSKS = $total->MaxSKS2;
							$TSKSLulus = $total->SKSLulus;
						?>
						IP Semester: <b><?= $IPS ?></b><br>
						SKS Lulus : <b><?= $TSKSLulus ?></b><br>
						IP Kumulatif : <b><?= $IPK ?></b><br>
						<?php
							if ($fakultas == "B") echo "Jml. SKS Kumulatif Lulus : <b>$TotalSKS</b><br>";
							else echo "Jml. SKS Kumulatif : <b>$TotalSKS</b><br>";
						?>
						Semester Berikutnya, Anda boleh mengambil mata kuliah maksimal : <b><?= $MaxSKS ?></b> SKS
					</div>
				</div>
				<div class="row" style="margin-top: 10px">
					<?php
						$ttd=$controller->getTtd($jurusan);
						$tgl = date('d-m-Y');
						if($fakultas=='O'){
							?>
							<div class="col-md-12">
								<div class="col-md-6" style="display: block;">
									Mengetahui<br>
									<?= $ttd->TTJabatanKHS2; ?><br>
									<br><br>
									<u><?= $ttd->TTPejabatKHS2 ?></u><br>
									<?= $ttd->TTnippejabatKHS2 ?>	
								</div>
								<div class="col-md-6" style="display: block;">
									Palu, <?= $tgl ?><br>
									<?= $ttd->TTJabatanKHS; ?><br>
									<br><br>
									<u><?= $ttd->TTPejabatKHS ?></u><br>
									<?= $ttd->TTnippejabatKHS ?>
								</div>
							</div>						
							<?php  
						}else{
					?>
							<div class="col-md-8" style="display: block;">

							</div>
							<div class="col-md-4" style="display: block;margin-left: 400px;">
							<?php
								if($fakultas=='K2M') {
							?>
									Bungku, <?= $tgl ?><br>
									<?= $ttd->TTJabatanKHS; ?><br>
									<br><br>
									<u><?= $ttd->TTPejabatKHS ?></u><br>
									<?= $ttd->TTnippejabatKHS ?>
							<?php  
								}else{
							?>
									Palu, <?= $tgl ?><br>
									<?= $ttd->TTJabatanKHS; ?><br>
									<br><br>
									<u><?= $ttd->TTPejabatKHS ?></u><br>
									<?= $ttd->TTnippejabatKHS ?>
							<?php
								}
							?>	
							</div>
						<?php
							}
						?>
				</div>
			</div>
			<pagebreak></pagebreak>
	<?php
			}
		}
	?>
	<script type="text/javascript" src="./assets/js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="./assets/components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
