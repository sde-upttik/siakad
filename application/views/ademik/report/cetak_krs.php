<!DOCTYPE html>
<html>
<head>
	<title>Cetak KRS</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/components/bootstrap/dist/css/bootstrap.min.css'); ?>">
	<style type="text/css">
		body{
			font-family: calibri;
		}
		h2, h3{
			margin: 0px;
			padding: 0px;
		}
		table.table-mk, .table-mk td, .table-mk th{border: 1px solid black; border-collapse: collapse;}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<table style="width: 100%">
				<tr>
					<td rowspan="3" width="100px;"><img style="width: 80px" src="./assets/images/Logo_untad.png" /></td>
					<td style="font-size: 13px; margin-bottom: 0; padding-bottom: 0;  left: -80px; text-align: center;">
						<b>KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN</b>
					</td>
				</tr>
				<tr>
					<td style="font-size: 15; margin-top: 0; padding-top: 0; margin-bottom: 0; padding-bottom: 0;  left: -80px; text-align: center;">
						<b>UNIVERSITAS TADULAKO</b>
					</td>
				</tr>
				<tr>
					<td style="font-size: 15px; text-align: center; left: -80px;"><b><?= $controller->getFak($nim); ?></b></td>
				</tr>
			</table>
		</div>
		<hr>
		<div class="row">
			<div style="font-size: 14px; text-align: center; width: 100%;">
				KARTU RENCANA STUDI ( K.R.S. )<br>
				Semester <?= $controller->getTahun($nim, $semesterAkademik); ?>
			</div>
		</div><br><br>
		<div class="row">
			<div class="col-md-12" style="font-size: 14px;">
				<table style="width: 100%">
					<tr>
						<td>NIM</td>
						<td>: <?= $nim ?></td>
						<td>Program Studi</td>
						<td>: <?= $ajur->JUR." (".$ajur->JEN.")"; ?></td>
					</tr>
					<tr>
						<td>Nama Mahasiswa</td>
						<td>: <?= strtoupper($amhsw->Name); ?></td>
						<td></td>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table-mk" style="width: 100%">
					<tr>
						<th style="text-align: center;width: 1px">No.</th>
						<th style="text-align: center;width: 1px">KMK</th>
						<th style="text-align: center;">Mata Kuliah</th>
						<th style="text-align: center;width: 60px">SKS(N)</th>
						<th style="text-align: center;width: 60px">Kelas</th>
						<th style="text-align: center;width: 60px">Ruang</th>
						<th style="text-align: center;width: 60px">Keterangan</th>
					</tr>
					<?php
						$n = 0;
						$TSKS = 0; 
						$TNK = 0;
						foreach ($detailKrs as $show) {
							$n++;
							//if ($show->Tunda == 'Y') $strtnd = "T : ".$show->AlasanTunda; else $strtnd = '&nbsp;';
         					//$bobot = 0;
         					//$bobot = $show->Bobot;
         					//$NK = $bobot * $show->SKS;

         					/*if($show->GradeNilai=="A"||$show->GradeNilai=="A-" ||$show->GradeNilai=="B+" ||$show->GradeNilai=="B" ||$show->GradeNilai=="B-"||$show->GradeNilai=="C+" ||$show->GradeNilai=="C"||$show->GradeNilai=="C-"||$show->GradeNilai=="D"||$show->GradeNilai=="E"||$show->GradeNilai=="K"||$show->GradeNilai=="T" ||$show->GradeNilai=="" ||$show->GradeNilai==" "){
								$TNK += $NK;*/
					        //}
							$KodeMK=$show->KodeMK;
							$MK=$show->NamaMK;
							$SKS = $show->SKS;
							$Kls = $show->Keterangan;
							$Ruang = $show->KodeRuang;
							$TSKS = $TSKS+$show->SKS;
					?>
						<tr>
							<td align="center"><?= $n; ?></td>
							<td><?= $KodeMK; ?></td>
							<td><?= $MK ?></td>
							<td align="center"><?= $SKS ?></td>
							<td align="center"><?= $Kls ?></td>
							<td align="center"><?= $Ruang ?></td>
							<td align="center"></td>
						</tr>
					<?php
						}
					?>
					<tr>
						<td align="right" colspan="3">Total :</td>
						<td align="center"><?= $TSKS; ?></td>
						<td colspan="2" align="center"></td>
						<td></td>
					</tr>
				</table>
			</div>
		</div><br><br>
		<div class="row">
			<?php
				$TTP1=$ttd->TTPejabat1;
				$TTP2=$ttd->TTPejabat2;
				$TTP3=$ttd->TTPejabat3;
				$TTJ1=$ttd->TTJabatan1;
				$TTJ2=$ttd->TTJabatan2;
				$TTJ3=$ttd->TTJabatan3;
				$TTNP1=$ttd->TTnippejabat1;
				$TTNP2=$ttd->TTnippejabat2;
				$TTNP3=$ttd->TTnippejabat3;
				$Name= $amhsw->Name;
				$NameD= $amhsw->DName;
				$kdf= $amhsw->KodeFakultas;
				$kdj= $amhsw->KodeJurusan;
				$kdp= $amhsw->KodeProgram;
				$NIPD= $amhsw->DosenID;
				$tgl = date('d-m-Y');

				if($kdf=='H'){
			?>
					<table width="100%">
						<tbody>
							<tr>
								<td style="width: 40%"></td>
								<td style="width: 30%"></td>
								<td style="width: 30%">Palu, <?= $tgl; ?></td>
							</tr>
							<tr>
								<td><?= $TTJ1; ?></td>
								<td></td>
								<td>Mahasiswa</td>
							</tr>
							<tr >
								<td><br><br><br></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><?= $TTP1 ?></td>
								<td></td>
								<td><?= $Name ?></td>
							</tr>
							<tr>
								<td><?= $TTNP1 ?></td>
								<td></td>
								<td><?= $nim ?></td>
							</tr>
						</tbody>
					</table>	
			<?php		
				}else if($kdj=="C301" && ($kdp=="RESO" || $kdp=="NONREG")){
			?>
					<table width="100%">
						<tbody>
							<tr>
								<td style="width: 40%"></td>
								<td style="width: 30%"></td>
								<td style="width: 30%">Palu, <?= $tgl; ?></td>
							</tr>
							<tr>
								<td><?= $TTJ1; ?></td>
								<td>Dosen Wali</td>
								<td>Mahasiswa</td>
							</tr>
							<tr >
								<td><br><br><br></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><?= $TTP1 ?></td>
								<td><?= $NameD ?></td>
								<td><?= $Name ?></td>
							</tr>
							<tr>
								<td><?= $TTNP1 ?></td>
								<td><?= $NIPD ?></td>
								<td><?= $nim ?></td>
							</tr>
						</tbody>
					</table>
			<?php
				}else if($kdf=="E"){
			?>
					<table width="100%">
						<tbody>
							<tr>
								<td style="width: 40%"></td>
								<td style="width: 30%"></td>
								<td style="width: 30%">Palu, <?= $tgl; ?></td>
							</tr>
							<tr>
								<td><?= $TTJ2; ?></td>
								<td>Dosen Wali</td>
								<td>Mahasiswa</td>
							</tr>
							<tr >
								<td><br><br><br></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><?= $TTP2 ?></td>
								<td><?= $NameD ?></td>
								<td><?= $Name ?></td>
							</tr>
							<tr>
								<td><?= $TTNP2 ?></td>
								<td><?= $NIPD ?></td>
								<td><?= $nim ?></td>
							</tr>
						</tbody>
					</table>	
			<?php
				}else{
			?>
					<table width="100%">
						<tbody>
							<tr>
								<td style="width: 40%"></td>
								<td style="width: 30%"></td>
								<td style="width: 30%">Palu, <?= $tgl; ?></td>
							</tr>
							<tr>
								<td><?= $TTJ1; ?></td>
								<td>Dosen Wali</td>
								<td>Mahasiswa</td>
							</tr>
							<tr >
								<td><br><br><br></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><?= $TTP1 ?></td>
								<td><?= $NameD ?></td>
								<td><?= $Name ?></td>
							</tr>
							<tr>
								<td><?= $TTNP1 ?></td>
								<td><?= $NIPD ?></td>
								<td><?= $nim ?></td>
							</tr>
						</tbody>
					</table>		
			<?php
				}
			?>
		</div>
	</div>

	<script type="text/javascript" src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>