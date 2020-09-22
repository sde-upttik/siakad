<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Cek Data Feeder</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						

						<?php /*print_r($error);*/
							if($kategori=="khs"){
						?>
								<table class='box' cellspacing='1' cellpadding='2' align='center' width='60%'>
										<thead>
											<tr>
												<th colspan=2 class=ttl style='background:#f9a927; width:80%;'>Data Belum Terdapat di PDPT</th>
											</tr>
										</thead>
								<?php
								if($_SESSION['ulevel']==4){
								?>	
										<form action='<?= base_url("ademik/mhswkrs/action_feeder"); ?>' method='post'>
											<tbody>
												<tr>
													<td>
														NIM
													</td>
													<td>
														: <?= $nim ?><input type='hidden' name='nim_khs' value='<?= $nim ?>' readonly>
														<input type='hidden' name='id_reg_pd' value='<?= $cekKhs->id_reg_pd ?>' readonly>
														<input type='hidden' name='status' value='<?= $cekKhs->Status ?>' readonly>
													</td>
												</tr>
												<tr>
													<td>
														Nama
													</td>
													<td>
														: <?= $cekKhs->Name ?><input type='hidden' name='nama_khs' value='<?= $cekKhs->Name ?>' readonly>
													</td>
												</tr>
												<tr>
													<td>
														PROG
													</td>
													<td>
														: <?= $cekKhs->KodeProgram ?><input type='hidden' name='kodeprogram_khs' value='<?= $cekKhs->KodeProgram ?>' readonly> 
													</td>
												</tr>
												<tr>
													<td>
														Tahun
													</td>
													<td>
														: <?= $cekKhs->Tahun ?><input type='hidden' name='tahun_khs' value='<?= $cekKhs->Tahun ?>' readonly>
													</td>
												</tr>
												<tr>
													<td>
														SKS
													</td>
													<td>
														: <?= $cekKhs->SKS ?><input type='hidden' name='sks_khs' value='<?= $cekKhs->SKS ?>' readonly>
													</td>
												</tr>
												<tr>
													<td>
														SKS Lulus
													</td>
													<td>
														: <?= $cekKhs->SKSLulus ?><input type='hidden' name='skslulus_khs' value='<?= $cekKhs->SKSLulus ?>' readonly>
													</td>
												</tr>
												<tr>
													<td>
														IPS
													</td>
													<td>
														: <?= $cekKhs->IPS ?><input type='hidden' name='ips_khs' value='<?= $cekKhs->IPS ?>' readonly>
													</td>
												</tr>
												<tr>
													<td>
														Total SKS
													</td>
													<td>
														: <?= $cekKhs->TotalSKS ?><input type='hidden' name='totalsks_khs' value='<?= $cekKhs->TotalSKS ?>' readonly>
													</td>
												</tr>
												<tr>
													<td>
														Total SKS Lulus
													</td>
													<td>
														: <?= $cekKhs->TotalSKSLulus ?><input type='hidden' name='totalskslulus_khs' value='<?= $cekKhs->TotalSKSLulus ?>' readonly>
													</td>
												</tr>
												<tr>
													<td>
														IPK
													</td>
													<td>
														: <?= $cekKhs->IPK ?><input type='hidden' name='ipk_khs' value='<?= $cekKhs->IPK ?>' readonly>
													</td>
												</tr>
												<tr>
													<td></td>
													<td>
											<?php
											if($cekKhs->stprc==0){
												$ips_act="";
												$ipk_act="disabled";
												$import_act1="disabled";
											}elseif($cekKhs->stprc==1 || $cekKhs->IPK==0){
												$ips_act="";
												$ipk_act="";
												$import_act1="disabled";
											}elseif($cekKhs->stprc==2){
												$ips_act="";
												$ipk_act="";
												$import_act1="";
											}

											if($cekKhs->KodeFakultas=='N'){
												echo "<span style='color:orange;'>Hub. Adm. Fakultas untuk Kirim data</span>";
											}else{
												echo "<input style='float:right;' type='submit' name='import_khs' value='Kirim ke Dikti' ".$import_act1.">";		    		
											}
											?>
											<input style='float:right;' type='submit' name='import_khs' value='Kirim ke Dikti' <?= $import_act1 ?>>
											<a href='<?= base_url("ademik/mhswkrs/prcipk/".$cekKhs->NIM."/".$cekKhs->KodeFakultas."/".$cekKhs->KodeJurusan."/".$cekKhs->Tahun)?>'><input style='float:right;' type='button' value='Prc IPK' <?= $ipk_act ?>>
											<a href='<?= base_url("ademik/mhswkrs/prcips/".$cekKhs->NIM."/".$cekKhs->KodeFakultas."/".$cekKhs->KodeJurusan."/".$cekKhs->Tahun)?>'><input style='float:right;' type='button' value='Prc IPS' <?= $ips_act ?>>


												<!-- <input style='float:right;' type='submit' name='abaikan_khs' value='abaikan'>"; -->
												
													</td>
												</tr>
												<tr>
													<td>
														<span><i>* Tombol Kirim ke Dikti Aktif jika telah di Prc IPK dan IPS</i></span>
													</td>
												</tr>
											</tbody>

										</form>
								<?php
								}else{
								?>	
									<form action='<?= base_url("ademik/mhswkrs/action_feeder"); ?>' method='post' >

										<tbody>
											<tr>
												<td>
													NIM
												</td>
												<td>
													: <?= $nim ?><input type='hidden' name='nim_khs' value='<?= $nim ?>' readonly>
													<input type='hidden' name='id_reg_pd' value='<?= $cekKhs->id_reg_pd ?>' readonly>
													<input type='hidden' name='status' value='<?= $cekKhs->Status ?>' readonly>
												</td>
											</tr>
											<tr>
												<td>
													Nama
												</td>
												<td>
													: <?= $cekKhs->Name ?><input type='hidden' name='nama_khs' value='<?= $cekKhs->Name ?>' readonly>
												</td>
											</tr>
											<tr>
												<td>
													PROG
												</td>
												<td>
													: <?= $cekKhs->KodeProgram ?><input type='hidden' name='kodeprogram_khs' value='<?= $cekKhs->KodeProgram ?>' readonly> 
												</td>
											</tr>
											<tr>
												<td>
													Tahun
												</td>
												<td>
													: <?= $cekKhs->Tahun ?><input type='hidden' name='tahun_khs' value='<?= $cekKhs->Tahun ?>' readonly>
												</td>
											</tr>
											<tr>
												<td>
													SKS
												</td>
												<td>
													: <input type='text' name='sks_khs' value='<?= $cekKhs->SKS ?>'>
												</td>
											</tr>
											<tr>
												<td>
													SKS Lulus
												</td>
												<td>
													: <input type='text' name='skslulus_khs' value='<?= $cekKhs->SKSLulus ?>'>
												</td>
											</tr>
											<tr>
												<td>
													IPS
												</td>
												<td>
													: <input type='text' name='ips_khs' value='<?= $cekKhs->IPS ?>'>
												</td>
											</tr>
											<tr>
												<td>
													Total SKS
												</td>
												<td>
													: <input type='text' name='totalsks_khs' value='<?= $cekKhs->TotalSKS ?>'>
												</td>
											</tr>
											<tr>
												<td>
													Total SKS Lulus
												</td>
												<td>
													: <input type='text' name='totalskslulus_khs' value='<?= $cekKhs->TotalSKSLulus ?>'>
												</td>
											</tr>
											<tr>
												<td>
													IPK
												</td>
												<td>
													: <input type='text' name='ipk_khs' value='<?= $cekKhs->IPK ?>'>
												</td>
											</tr>
											<tr>
												<td></td>
												<td>
											
											<?php
											if($cekKhs->stprc==0){
												$ips_act="";
												$ipk_act="disabled";
												$import_act1="disabled";
											}elseif($cekKhs->stprc==1){
												$ips_act="";
												$ipk_act="";
												$import_act1="disabled";
											}elseif($cekKhs->stprc==2){
												$ips_act="";
												$ipk_act="";
												$import_act1="";
											}
											?>
											<input style='float:right;' type='submit' name='import_khs' value='Kirim ke Dikti' <?= $import_act1 ?>>
											<a href='<?= base_url("ademik/mhswkrs/prcipk/".$cekKhs->NIM."/".$cekKhs->KodeFakultas."/".$cekKhs->KodeJurusan."/".$cekKhs->Tahun)?>'><input style='float:right;' type='button' value='Prc IPK' <?= $ipk_act ?>>
											<a href='<?= base_url("ademik/mhswkrs/prcips/".$cekKhs->NIM."/".$cekKhs->KodeFakultas."/".$cekKhs->KodeJurusan."/".$cekKhs->Tahun)?>'><input style='float:right;' type='button' value='Prc IPS' <?= $ips_act ?>>
											
											<input style='float:right;' type='submit' name='abaikan_khs' value='abaikan'>
											
											<input style='float:right; margin-right:5px;' type='submit' name='save_khs' value='Save'>
											
											<?php
											$thn1=substr($thn, 0,4);
											$thn2=substr($thn, 4,1);

											if($thn2==2){
												$thn1=$thn1+1;
												$thn2=$thn2-1;
												$thn3=$thn1.$thn2;
											}elseif($thn2==1){
												$thn2=$thn2+1;
												$thn3=$thn1.$thn2;
											}

											?>
											
												</td>
											</tr>
												<tr>
													<td>
														<span><i>* Tombol Kirim ke Dikti Aktif jika telah di Prc IPK dan IPS</i></span>
													</td>
													<!-- <td>
														<a href='ademik.php?syxec=mhswkrs&thn=".$thn3."&nim=".$nim."&GO=Refresh'><input type='button'  value='Kembali'></a>
													</td> -->
												</tr>
										</tbody>
										</form>
								<?php
								}
								?>
								</table>
						<?php
							}elseif($kategori=="krs"){
						?>
								<table class=basic cellspacing=0 cellpadding=4 align='center'>
									<thead>
										<tr>
											<th class=ttl>#</th>
											<th class=ttl>KodeMK</th>
											<th class=ttl>Mata Kuliah</th>
											<th class=ttl>SKS</th>
											<th class=ttl>Dosen</th>
											<th class=ttl>Nilai</th>
											<th class=ttl>Grade Nilai</th>
											<th class=ttl>Bobot</th>
											<th class=ttl>Kelas</th>
											<th class=ttl>Pernah diambil</th>
											<th class=ttl>Kehadiran(%)</th>
											<th class=ttl>Tgl Input</th>
											<th class=ttl>Status</th>
											<th class=ttl colspan=2>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
										$i=1;
										foreach ($cekKrs as $show) {
											$pernah=$controller->CekPernahAmbil($show->NIM, $show->Tahun, $show->KodeMK);
									?>
										<tr>
											<td><?= $i ?></td>
											<td><?= $show->KodeMK ?></td>
											<td><?= $show->MK ?></td>
											<td><?= $show->SKS ?></td>
											<td><?= $show->Dosen ?></td>
											<td><?= $show->Nilai ?></td>
											<td><?= $show->GradeNilai ?></td>
											<td><?= $show->Bobot ?></td>
											<td><?= $show->Keterangan ?></td>
											<td><?= $pernah ?></td>
											<td><?= $show->Hadir ?></td>
											<td><?= $show->Tanggal ?></td>
											<?php
												if($show->st_feeder>0){
													echo "<td style='background:Green; text-align:center; color:#fff;'>Valid</td>";
												}elseif($show->st_abaikan==1){
													echo "<td style='background:orange; text-align:center; color:#fff;'>Data diabaikan</td>";
												}elseif($show->st_feeder==0){
													echo "<td style='background:red; text-align:center; color:#fff;'>Invalid</td>";
												}elseif($show->st_feeder==-3){
													echo "<td style='background:red; text-align:center; color:#fff;'>Gagal Import</td>";
												}

												if($show->st_feeder>0){
													echo "<td></td>";
													echo "<td>
															<form action='".base_url("ademik/mhswkrs/action_feeder")."' method='post'>
																<input type='hidden' name='id_KRS' value='$show->ID'>
																<input type='hidden' name='thn' value='$show->Tahun'>
																<input style='float:right;' type='submit' name='import_krs' value='Setujui'>
															</form>
														</td>
													";
												}elseif($show->st_abaikan==1){
													echo "<td></td>";
													echo "<td>
															<form action='".base_url("ademik/mhswkrs/action_feeder")."' method='post'>
																<input type='hidden' name='id_KRS' value='$show->ID'>
																<input type='hidden' name='thn' value='$show->Tahun'>
																<input style='float:right;' type='submit' name='import_krs' value='Setujui'>
															</form>
														</td>
													";
												}elseif($show->st_feeder==0){
													if($this->session->ulevel==1 OR $this->session->ulevel==5){
														echo "<td>
															<form action='".base_url("ademik/mhswkrs/action_feeder")."' method='post'>
																	<input type='hidden' name='id_KRS' value='$show->ID'>
																	<input type='hidden' name='nim' value='$show->NIM'>
																	<input type='hidden' name='thn' value='$show->Tahun'>
																	<input style='float:right;' type='submit' name='abaikan_krs' value='abaikan'>
																</form>
														</td>";
													}
													echo "
														
														<td>
															<form action='".base_url("ademik/mhswkrs/action_feeder")."' method='post'>
																<input type='hidden' name='id_KRS' value='$show->ID'>
																<input type='hidden' name='thn' value='$show->Tahun'>
																<input style='float:right;' type='submit' name='import_krs' value='Setujui'>
															</form>
														</td>
													";
												}elseif($show->st_feeder==-3){
													if($this->session->ulevel==1 OR $this->session->ulevel==5){
														echo "<td>
															<form action='".base_url("ademik/mhswkrs/action_feeder")."' method='post'>
																	<input type='hidden' name='id_KRS' value='$show->ID'>
																	<input type='hidden' name='nim' value='$show->NIM'>
																	<input type='hidden' name='thn' value='$show->Tahun'>
																	<input style='float:right;' type='submit' name='abaikan_krs' value='abaikan'>
																</form>
														</td>";
													}									
													echo "
														<td>
															<form action='".base_url("ademik/mhswkrs/action_feeder")."' method='post'>
																<input type='hidden' name='id_KRS' value='$show->ID'>
																<input type='hidden' name='thn' value='$show->Tahun'>
																<input style='float:right;' type='submit' name='import_krs' value='Setujui'>
															</form>
														</td>
													";
												}
											?>
										</tr>
									<?php
										$i++;
										}
									?>
									</tbody>
								</table>
						<?php
							}elseif($kategori=="mhsw"){
								$nama=$cekMhsw->Name;
								$sex=$cekMhsw->Sex;								
						?>
								<form action='<?= base_url("ademik/mhswkrs/action_feeder"); ?>' method='post'>
									<table class='box' cellspacing='1' cellpadding='4' align='center' width='100%'>
							   	    	<thead>
								    		<tr>
								    			<th colspan=2 class=ttl style='background:#f9a927;'>Data Belum Terdapat di PDPT</th>
								    		</tr>
								    	</thead>
								    	<tbody>
								    		<tr>
								    			<td style="width: 45%">NIM</td>
								    			<td>
								    				: <?= $nim ?><input type='hidden' name='nim' value='<?= $nim ?>' readonly>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td>Nama</td>
								    			<td>
								    				: <?= $nama ?><input type='hidden' name='nama' value='<?= $nama ?>' readonly>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td>Jenis Kelamin</td>
								    			<td>
								    				: <select name='jk'>
								    					<option value='<?= $sex ?>'><?= $sex ?></option>
								    					<option value='L'>L</option>
								    					<option value='P'>P</option>
								    				</select>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td>Tempat Lahir</td>
								    			<td>
								    				: <input type='text' name='TempatLahir' value='<?= $cekMhsw->TempatLahir; ?>'>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td>Tanggal Lahir</td>
								    			<td>
								    				: <input type='text' name='TglLahir' id='Datepicker' value='<?= $cekMhsw->TglLahir; ?>'>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td>Nama Ayah</td>
								    			<td>
								    				: <input type='text' name='NamaOT' style='width:200px' id='Datepicker' value='<?= $cekMhsw->NamaOT; ?>'>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td>Nama Ibu</td>
								    			<td>
								    				: <input type='text' name='NamaIbu' style='width:200px' id='Datepicker' value='<?= $cekMhsw->NamaIbu; ?>'>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td>Nomor Induk Kependudukan ( No KTP/KK )</td>
								    			<td>
								    				: <input type='text' name='NIK' style='width:200px' id='Datepicker' value='<?= $cekMhsw->NIK; ?>'>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td>Agama</td>
								    			<td>
								    				: <select name='Agama'>
								    					<option value='<?= $cekMhsw->AgamaID; ?>'><?= $cekMhsw->Agama; ?></option>
								    					<?php
								    						$data=$controller->getAgama();
									    					foreach ($data as $show) {
									    						echo "<option value='".$show->AgamaID."'>".$show->Agama."</option>";
									    					}
								    					?>
								    				</select>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td></td>
								    			<td>
							               			<?php
							               				if($this->session->ulevel!=4){
							               			?>
							               				<input style='float:right;' type='submit' name='import_mhs' value='Kirim ke Dikti'>
									    			<?php
									    				}
									    			?>
													<input style='float:right; margin-right:5px;' type='submit' name='save_mhs' value='Save'>
								    			</td>
								    		</tr>
								    	</tbody>
									</table>
								</form>
						<?php
							}
						?>

					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<script type="text/javascript">
	var i = setInterval(function() {
		if ($) {
			clearInterval(i);
			$(function(){
				<?php
					if(isset($status)){
						if($status=="sukses"){
				?>
							swal({
								title: "Success !",
								text: "Data berhasil dirubah",
								icon: "success",
								button: "Ok",  
								html: true, 
							});
				<?php				
						}elseif ($status=="sukses_ips") {
				?>
							swal({
								title: "Success !",
								text: "Berhasil proses IPS",
								icon: "success",
								button: "Ok",  
								html: true, 
							});
				<?php			
						}elseif ($status=="sukses_ipk") {
				?>
							swal({
								title: "Success !",
								text: "Berhasil proses IPK",
								icon: "success",
								button: "Ok",  
								html: true, 
							});
				<?php			
						}elseif ($status=="feeder") {
				?>
							swal({
								title: "Success !",
								text: "<?= $msg ?>",
								icon: "success",
								button: "Ok",  
								html: true, 
							});
				<?php			
						}elseif ($status=="error_feeder") {
				?>
							swal({
								title: "Error !",
								text: '<?= $msg ?>',
								icon: "error",
								button: "Ok",  
								html: true, 
							});
				<?php			
						}
					}
				?>
			})
		}
	}, 100);			
</script>