<style type="text/css">
	.modal-fullscreen {
	  padding: 0 !important;
	}
	.modal-fullscreen .modal-dialog {
	  width: 100%;
	  height: 100%;
	  margin: 0;
	  padding: 0;
	  max-width: 100%;
	}
	.modal-fullscreen .modal-content {
	  height: auto;
	  min-height: 100%;
	  border: 0 none;
	  border-radius: 0;
	}
</style>

<style>
.democlass {
    color: red;
}
</style>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Kliring Nilai
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="breadcrumb-item"><a href="<?= $_SESSION['tamplate'] ?>">Kliring Nilai</a></li>
		</ol>
	</section>


	<!-- Main content untuk awal daftar kliring -->
	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title"> Kliring dan Managemen Nilai Mahasiswa</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<?php if ($this->session->userdata('uname') == "mohamad fadli") { ?>
							<div class="row p-3">
								<a href="<?= base_url('ademik/Skripsi')?>" class="btn btn-warning"> 
									<i class="fa fa-book"></i> Monitoring Skripsi 
								</a>
							</div>
						<?php } ?>

						<div class="alert alert-danger alert-dismissible">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	            <h4><i class="icon fa fa-ban"></i> Peringatan!</h4>
	            <br><li>Tidak Ada Penginputan Nilai dari Menu Kliring Nilai Mahasiswa, Jika Terdapat Matakuliahyang Ingin di Input, Silahkan melakukan Pengajuan dari Menu Kliring -> Tambah Nilai Kliring Mhsw.
	          </div>
	          <div class="alert alert-info alert-dismissible">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	            <h4><i class="icon fa fa-info"></i> User Guide!</h4>
							<br><li>Silahkan Aktifkan/Non Aktifkan <b>Action KRS</b>, Untuk Menampilkan Daftar Matakuliah Pada KRS dan KHS, Agar Proses Perhitungan IPS Mahasiswa Benar.
	            <br><li>Silahkan Aktifkan/Non Aktifkan <b>Action Transkrip</b>, Untuk Menampilkan Daftar Matakuliah Pada Transkrip Nilai, Agar Proses Perhitungan IPK Mahasiswa Benar.
	          </div>
						<form class="form-horizontal" action="<?=base_url();?>ademik/kliring_mhsw/getDataMahasiswa" method="POST">
							<div class="form-group row">
								<label class="col-sm-1 control-label">NIM Mahasiswa</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="dataSearch" value="<?php if (!empty($nim)) echo $nim; ?>" name="dataSearch" placeholder="Silahkan Input" />
								</div>
								<div class="col-sm-2">
									<input class="btn btn-flat btn-info" type="submit" id="search" name="search" value="Search">
								</div>
							</div>
						</form>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->

					<!-- Awal Table -->
		  			<div class="box">
			            <!-- Minggu -->
			            <div class="box-header">
			              <h3 class="box-title">Kliring Nilai Mahasiswa</h3>
			            </div>
			            <!-- /.box-header -->
						<?php
						$nim = "";
						$name = "";
						$kdf = "";
						$nmf = "";
						$kdj = "";
						$nmj = "";
						$jenjang = "";
						$status = "";
						$statusawal = "";
						$stkliring = "";
						$id_reg_pd = "";
						if (!empty($detailmhsw)){
							foreach ($detailmhsw as $detail){
								$nim = $detail->NIM;
								$name = str_replace("\'", "'", $detail->Name);
								$kdf = $detail->kdf;
								$nmf = $detail->nmf;
								$kdj = $detail->kdj;
								$nmj = $detail->nmj;
								$jenjang = $detail->jenjang;
								$status = $detail->status;
								$statusawal = $detail->StatusAwal;
								$stkliring = $detail->st_kliring;
								$id_reg_pd = $detail->id_reg_pd;
								$totalSKS = $detail->TotalSKS;
								$totalSKSLulus = $detail->TotalSKSLulus;
								$ipk = $detail->IPK;
							}
						}
						?>
			            <div class="box-body">
		              		<dl class="dl-horizontal">
		                		<dt>NIM</dt>
		                		<dd><?=$nim?></dd>
		                		<dt>Nama Mahasiswa</dt>
		                		<dd><?=$name?></dd>
		                		<dt>Fakultas</dt>
		                		<dd><?=$kdf." - ".$nmf?></dd>
		                		<dt>Jurusan</dt>
		                		<dd><?=$kdj." - ".$nmj?></dd>
		                		<dt>Jenjang</dt>
		                		<dd><?=$jenjang?></dd>
		                		<dt>Status</dt>
		                		<dd><?=$status?></dd>
								<dt>Status Awal</dt>
		                		<dd><?=$statusawal?></dd>
		              		</dl>
			            </div>

						<?php
							if (empty($id_reg_pd)){ ?>

							<div style="margin-left: 75px;">
				            	Mahasiswa Tidak dapat Kliring Data karena Mahasiswa blum trdftar di PDDIKTI
				            </div>

						<?php
							} else {
						?>

				            <div style="margin-left: 75px;">
								<?php if ($this->session->userdata("ulevel") == 1 or $this->session->userdata("ulevel") == 5){
										if ( !empty($tambahnilai->Setujui_admin) and ($tambahnilai->Setujui_admin == "Setujui") ){
								?>

									<button type="button" data-toggle="modal" data-target="#modal-nilai-mahasiswa" onClick="tambahnilai()" class="btn btn btn-success fa fa-print"> Tambah Nilai Matakuliah</button>

								<?php
										}
									}
								?>

			                	<a href="<?=base_url();?>ademik/kliring_mhsw/nonactive_nol_e/<?=$nim?>" class="btn btn btn-primary fa fa-plus"> Non Aktifkan Semua Nilai Nol dan Nilai E</a>
												<a href="<?=base_url();?>ademik/report/report2/cetak_transkrip_nilai_kliring/<?=$nim?>" class="btn btn btn-default fa fa-file-excel-o"> Cetak Transkrip Nilai</a>
			                	<!--<button type="button" class="btn btn btn-danger fa fa-mail-forward"> Kirim Sapta</button>-->
				            </div>

							<div style="margin-left: 75px; margin-top: 25px;">
								<?php if ($stkliring <= 3){?>
				            	<!--<button type="button" data-toggle="modal" data-target="#bs-example-modal-lg" class="btn btn btn-success fa fa-print" onclick="isidatakliring()"> Isi Data Kliring</button>-->
				            	<button type="button" data-toggle="modal" data-target="#modal-isidatakliring" class="btn btn btn-success fa fa-print" onclick="isidatakliring()"> Isi Data Kliring</button>
								<?php }

								if ($stkliring <= 3 and $stkliring != "" ){

									if ($stkliring == 1){ // kodisi jika isi data kliring sudah di simpan?>
				                	<button type="button" data-toggle="modal" data-target="#modal-usulkliring-skripsi" class="btn btn btn-primary fa fa-plus" onclick="usulkliringskripsi()"> Usul Kliring Skripsi</button>
				         	<?php }

									if ($stkliring == 2){ // kodisi jika usul kliring skripsi selesai ?>
				                	<button type="button" data-toggle="modal" data-target="#modal-usulkliring-wisuda" class="btn btn btn-default fa fa-file-excel-o" onclick="usulkliringwisuda()"> Usul Kliring Wisuda</button>
									<?php }

								}

								if ($stkliring == 1 or $stkliring == 2 or $stkliring == 3){
									echo '<a href="'.base_url().'ademik/kliring_mhsw/batal_valwis/'.$nim.'" class="btn btn btn-danger fa fa-mail-forward"> Batal Validsi Wisuda</a>';
								}

								/*if ($stkliring == 3){ // kodisi jika usul kliring wisuda selesai dan membatal validasi wisuda ?>
								<a href="<?=base_url();?>ademik/kliring_mhsw/batal_valwis/<?=$nim?>" class="btn btn btn-danger fa fa-mail-forward"> Batal Validsi Wisuda</a>
								<?php } */ 

								if ($kdf == 'D' OR $kdf == 'C' ) { ?>
									<button type="button" onclick="kirim_sapta('<?= $nim ?>')" class="btn btn btn-default fa fa-mail-forward" title="Mengirim Data Mahasiswa Ke Aplikasi SAPTA"> Kirim SAPTA</button>
									<!-- echo '<a href="'.base_url().'ademik/kliring_mhsw/kirim_sapta/'.$nim.'" class="btn btn btn-success fa fa-mail-forward"> Kirim Ke SAPTA</a>'; -->
								<?php }

								?>

							</div>

				            <div class="row col-md-12">

					            	<div class="col-md-12">
					            		<div class="box-header">
					              			<h3 class="box-title">Daftar Nilai</h3>
					            		</div>
							            <div class="box-body">
								            <table id="matakuliah" class="table table-bordered table-striped table-responsive dataTable">
								                <thead>
													<tr>
														<th>No</th>
														<th>Kode MK</th>
														<th>Mata Kuliah</th>
														<?php if ($this->session->userdata("ulevel") == 1) echo "<th>Penyetaraan</th>" ?>
														<th>SKS</th>
														<th>Nilai Angka</th>
														<th>Nilai Huruf</th>
														<th>Bobot</th>
														<th>Tahun</th>
														<th>Smt</th>
														<th>Active/<br>NotActive KRS</th>
														<th>Action KRS</th>
														<th>Active/<br>NotActive<br>Transkrip</th>
														<th>Action Transkrip</th>
													</tr>
												</thead>
												<tbody>
												<?php

													$nim_khs = "";
													$tahun_khs = "";
													$no = 1;
													if (!empty($jumlah_array)){
													for ($ab=0; $ab < $jumlah_array; $ab++){
														//echo "<script>console.log('fandu ".$ab."');</script>";
														if (!empty($detail_tahun[$ab])){
															foreach ($detail_tahun[$ab] as $khs){

																if ($khs->IDJadwal == ""){ // Jika Nilai di Input dari Kliring Nilai Mahasiswa
																	$tanda = "<span class='glyphicon glyphicon-asterisk' style='color: orange;'></span>";
																} else {
																	$tanda = "";
																}

																if ($khs->NotActive == "N"){ // Jika Nilai di Input dari Kliring Nilai Mahasiswa

																} else {

																}
												?>
														<tr>
															<th>
																<?php
																	if ($khs->NotActive == "N") echo $no.$tanda;
																?>
															</th>
															<th>
																<?=$khs->KodeMK.$tanda?> <!-- <span class='glyphicon glyphicon-asterisk' style='color: orange;'></span> -->
															</th>
															<th><?=$khs->NamaMK.$tanda?></th>
															<?php 
																if ($this->session->userdata("ulevel") == 1) { ?>
																<th>
																	<div>
																		<div>
																			<div class="form-group row" style="margin: 0px 0px 0px 0px">
																				<button type="button" data-toggle="modal" data-target="#modal-penyetaraan-nilai" class="btn btn-sm btn-danger fa fa-edit" onclick=""></button>
																			</div>
																		</div>
																	</div>
																</th>
															<?php
																} 
															?>
															<th>
																<?=$khs->SKS.$tanda?> <!-- <span class='glyphicon glyphicon-asterisk' style='color: orange;'></span> -->
															</th>
															<th><?=$khs->GradeNilai.$tanda?></th>
															<th><?=$khs->GradeNilai.$tanda?></th>
															<th>
																<?=$khs->Bobot.$tanda?> <!-- <span class='glyphicon glyphicon-asterisk' style='color: orange;'></span> -->
															</th>
															<th><?=$khs->Tahun.$tanda?></th>
															<th><?=$khs->Sesi.$tanda?></th>

															<th><?php
																if ($khs->NotActive_KRS == "N") echo "Aktif".$tanda;
																else echo "Tidak Aktif".$tanda;
																?>
															</th>
															<th>
																<?php
																//Kondisi menentukan nilai Transfer atau Tidak
																if ($khs->Tahun == "TR") $tahunclick = $khs->tahun_tabel;
																else $tahunclick = $khs->Tahun;
																//echo "fandu tahun click - $khs->Tahun - $khs->tahun_tabel";

																// kondisi menentikan Active atau Tidak
																if ($khs->NotActive_KRS == "N") { ?>
																<div>
																	<div>
																		<div class="form-group row" style="margin: 0px 0px 0px 0px">
																			<button type="submit" class="btn btn-sm btn-danger fa fa-edit" onclick="simpan_krs(this,1,<?=$tahunclick?>,<?=$khs->ID?>)"></button>
																		</div>
																	</div>
																</div>
																<?php } else { ?>
																<div>
																	<div>
																		<div class="form-group row" style="margin: 0px 0px 0px 0px">
																			<button type="submit" class="btn btn-sm btn-primary fa fa-edit" onclick="simpan_krs(this,2,<?=$tahunclick?>,<?=$khs->ID?>)"></button>
																		</div>
																	</div>
																</div>
																<?php
																}
																?>
															</th>

															<th><?php
																if ($khs->NotActive == "N") echo "Aktif".$tanda;
																else echo "Tidak Aktif".$tanda;
																?>
															</th>
															<th>
																<?php
																//Kondisi menentukan nilai Transfer atau Tidak
																if ($khs->Tahun == "TR") $tahunclick = $khs->tahun_tabel;
																else $tahunclick = $khs->Tahun;
																//echo "fandu tahun click - $khs->Tahun - $khs->tahun_tabel";

																// kondisi menentikan Active atau Tidak
																if ($khs->NotActive == "N") { ?>
																<div>
																	<div>
																		<div class="form-group row" style="margin: 0px 0px 0px 0px">
																			<button type="submit" class="btn btn-sm btn-danger fa fa-edit" onclick="simpan(this,1,<?=$tahunclick?>,<?=$khs->ID?>)"></button>
																		</div>
																	</div>
																</div>
																<?php } else { ?>
																<div>
																	<div>
																		<div class="form-group row" style="margin: 0px 0px 0px 0px">
																			<button type="submit" class="btn btn-sm btn-primary fa fa-edit" onclick="simpan(this,2,<?=$tahunclick?>,<?=$khs->ID?>)"></button>
																		</div>
																	</div>
																</div>
																<?php
																}
																?>


															</th>
														</tr>
												<?php
															if ($khs->NotActive == "N") $no++;

															}
														}
													}
													} else { ?>
														<tr>
															<th></th>
															<th>
																 <!-- <span class='glyphicon glyphicon-asterisk' style='color: orange;'></span> -->
															</th>
															<th></th>
															<th>
																<!-- <span class='glyphicon glyphicon-asterisk' style='color: orange;'></span> -->
															</th>
															<th></th>
															<th></th>
															<th>
																 <!-- <span class='glyphicon glyphicon-asterisk' style='color: orange;'></span> -->
															</th>
															<th></th>
															<th></th>
															<th></th>
															<th></th>
															<th></th>
															<th></th>
														</tr>
												<?php
													}
													//echo "<script>console.log('fandu ".$detail_tahun."');</script>";
												?>
												</tbody>
												<tfoot>
													<tr>
													<th>No</th>
													<th>Kode MK</th>
													<th>Mata Kuliah</th>
													<?php if ($this->session->userdata("ulevel") == 1) echo "<th>Penyetaraan</th>" ?>
													<th>SKS</th>
													<th>Nilai Angka</th>
													<th>Nilai Huruf</th>
													<th>Bobot</th>
													<th>Tahun</th>
													<th>Smt</th>
													<th>Active/<br>NotActive KRS</th>
													<th>Action KRS</th>
													<th>Active/<br>NotActive<br>Transkrip</th>
													<th>Action Transkrip</th>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>

							</div>

							<div class="keterangan" style="margin: 5px 0px 15px 27px">
								<b>Total SKS : <?=$totalSKS?> SKS</b> <br />
								<b>Total SKS ( Tidak Termasuk Nilai E ) : <?=$totalSKSLulus?> SKS</b> <br />
								<b>Indeks Prestasi Komulatif : <?=$ipk?></b>
							</div>

					    <div class="keterangan" style="margin: 5px 0px 15px 27px">
					    		<b style="color: blue;">Keterangan :</b> <br />
					     		<span class='glyphicon glyphicon-asterisk' style='color: orange;'></span> Mata Kuliah di Input dari Kliring <br /> <br />
					     		<!--<span class='glyphicon glyphicon-remove' style='color: red;'></span> Mata Kuliah Tidak Aktif-->
									<span><button type="submit" class="btn btn-sm btn-danger fa fa-trash"></button></span> Click Jika Tidak Mengaktifkan Mata Kuliah <br /> <br />
									<button type="submit" class="btn btn-sm btn-primary fa fa-edit"></button> Click Jika Mengaktifkan Mata Kuliah
					     </div>

							<?php } ?>

				    </div>
		  			<!-- Akhir Table -->

			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->

	<div class="modal fade" id="modal-isidatakliring">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myLargeModalLabel">Isi Data Kliring</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
					<!-- Main content untuk isi data kliring -->
						<section class="content">
							<div class="row">
								<div class="col-12">
									<div class="box">
										<div class="box-header">
											<h3 class="box-title">Silahkan isi dengan benar</h3>
										</div>
										<!-- /.box-header -->
										<div class="box-body">
											<form action="<?= base_url('ademik/kliring_mhsw/simpan_isikliring'); ?>" method="POST">
												<div class="form-group row">
												  <label for="nim" class="col-md-2 col-form-label">NIM</label>
												  <div class="col-md-6">
													<input class="form-control" type="text" id="nim" name="nim" readonly>
												  </div>
												</div>
												<div class="form-group row">
												  <label for="name" class="col-md-2 col-form-label">Nama Mahasiswa</label>
												  <div class="col-md-6">
													<input class="form-control" type="text" id="name" name="name">
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tgllahir" class="col-md-2 col-form-label">Tanggal Lahir Ijazah</label>
												  <div class="col-md-6">
													<input id="tgllahir" type="text" name="tgllahir" class="tanggal col-xs-12 col-md-12">
													<!--<input class="form-control" type="text" id="tgllahir" name="tgllahir">-->
												  </div>
												</div>
												<!-- untuk di input di tabel khs
												<div class="form-group row">
												  <label for="semester" class="col-md-2 col-form-label">Semester</label>
												  <div class="col-md-6">
													<input class="form-control" type="text" id="semester" name="semester">
												  </div>
												</div>
												<div class="form-group row">
												  <label for="ips" class="col-md-2 col-form-label">IPS Semester Terakhir</label>
												  <div class="col-md-6">
													<input class="form-control" type="text" id="ips" name="ips">
												  </div>
												</div>
												<div class="form-group row">
												  <label for="sks" class="col-md-2 col-form-label">SKS Terakhir</label>
												  <div class="col-md-10">
													<input class="form-control" type="text" id="sks" name="sks" placeholder="SKS Semester Terakhir">
												  </div>
												</div>-->
												<div class="form-group row">
												  <label for="ipk" class="col-md-2 col-form-label">IPK</label>
												  <div class="col-md-10">
													<input class="form-control" type="text" id="ipk" name="ipk" placeholder="IPK">
												  </div>
												</div>
												<div class="form-group row">
												  <label for="totsks" class="col-md-2 col-form-label">Total SKS</label>
												  <div class="col-md-10">
													<input class="form-control" type="text" id="totsks" name="totsks" placeholder="Total SKS">
												  </div>
												</div>
												<div class="form-group row">
												  <label for="skyudisium" class="col-md-2 col-form-label">SK Yudisium</label>
												  <div class="col-md-10">
													<input class="form-control" type="text" id="skyudisium" name="skyudisium" placeholder="SKS Yudisium">
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tglyudisium" class="col-md-2 col-form-label">Tanggal Yudisium</label>
												  <div class="col-md-10">
													<input class="form-control" type="text" id="tglyudisium" name="tglyudisium" placeholder="Tanggal Yudisium">
												  </div>
												</div>
												<div class="form-group row">
												  <label for="predikat" class="col-md-2 col-form-label">Predikat</label>
												  <div class="col-md-10">
													<select class="form-control select2" style="width: 100%;" id="predikat" name="predikat">
														<option value="M">Memuaskan</option>
														<option value="SM">Sangat Memuaskan</option>
														<option value="P">Pujian</option>
														<option value="">No Predikat</option>
													</select>
												  </div>
												</div>
												<div class="form-group row">
												  <label for="masastudi" class="col-md-2 col-form-label">Masa Studi</label>
												  <div class="col-md-10">
													<input class="col-md-2 col-form-label" type="text" id="masastudi_tahun" name="masastudi_tahun" placeholder="Tahun">
													<input class="col-md-2 col-form-label" type="text" id="masastudi_bulan" name="masastudi_bulan" placeholder="Bulan">
													<input class="col-md-2 col-form-label" type="text" id="masastudi_hari" name="masastudi_hari" placeholder="Hari">
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tugasakhir1" class="col-md-2 col-form-label">Ketua Penguji TA</label>
												  <div class="col-md-10">
													<select class="form-control select2" style="width: 100%;" id="tugasakhir1" name="tugasakhir1">
													</select>
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tugasakhir2" class="col-md-2 col-form-label">Sekertaris Penguji TA</label>
												  <div class="col-md-10">
													<select class="form-control select2" style="width: 100%;" id="tugasakhir2" name="tugasakhir2">
													</select>
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tugasakhir3" class="col-md-2 col-form-label">Penguji Utama TA</label>
												  <div class="col-md-10">
													<select class="form-control select2" style="width: 100%;" id="tugasakhir3" name="tugasakhir3">
													</select>
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tugasakhir4" class="col-md-2 col-form-label">Penguji IV/Pembimbing I</label>
												  <div class="col-md-10">
													<select class="form-control select2" style="width: 100%;" id="tugasakhir4" name="tugasakhir4">
													</select>
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tugasakhir5" class="col-md-2 col-form-label">Penguji V/Pembimbing II</label>
												  <div class="col-md-10">
													<select class="form-control select2" style="width: 100%;" id="tugasakhir5" name="tugasakhir5">
													</select>
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tugasakhir6" class="col-md-2 col-form-label">Penguji VI</label>
												  <div class="col-md-10">
													<select class="form-control select2" style="width: 100%;" id="tugasakhir6" name="tugasakhir6">
													</select>
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tugasakhir7" class="col-md-2 col-form-label">Penguji VII</label>
												  <div class="col-md-10">
													<select class="form-control select2" style="width: 100%;" id="tugasakhir7" name="tugasakhir7">
													</select>
												  </div>
												</div>
												<div class="form-group row">
												  <label for="jdlskripsi_indonesi" class="col-md-2 col-form-label">Judul Bahasa Indonesia</label>
												  <div class="col-md-10">
														<label id="jdlskripsi_indonesi_tampil" class="col-md-12 col-form-label"></label>
														<textarea class="form-control textarea" rows="3" id="jdlskripsi_indonesi" name="jdlskripsi_indonesi" placeholder="Silahkan isi kembali jika ingin merubah judul"></textarea>
												  </div>
												</div>
												<div class="form-group row">
												  <label for="jdlskripsi_inggris textarea" class="col-md-2 col-form-label">Judul Bahasa Inggris</label>
												  <div class="col-md-10">
														<label id="jdlskripsi_inggris_tampil" class="col-md-12 col-form-label"></label>
														<textarea class="form-control textarea" rows="3" id="jdlskripsi_inggris" name="jdlskripsi_inggris" placeholder="Silahkan isi kembali jika ingin merubah judul"></textarea>
												  </div>
												</div>
												<div class="form-group row">
													<div class="col-md-12" style="text-align: center;">
														<input type="submit" name="simpan" value="Simpan" class="btn bg-olive">
													</div>
												</div>
											</form>
										</div>
										<!-- /.box-body -->
									</div>
									<!-- /.box -->
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->
						</section>
						<!-- /.content -->
				</div>
				<div class="modal-footer">
						<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

	<div class="modal fade" id="modal-usulkliring-skripsi">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myLargeModalLabel">Usul Kliring Skripsi</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
					<!-- Main content untuk isi data kliring -->
						<section class="content">
							<div class="row">
								<div class="col-12">
									<div class="box">
										<div class="box-header">
											<h3 class="box-title">Semua biodata dan nilai Mahasiswa akan terkirim ke APLIKASI WISUDA, pastikan semua data mahasiswa sudah BENAR sebelum anda mengirim</h3>
										</div>
										<!-- /.box-header -->
										<div class="box-body">
											<form action="<?= base_url('ademik/kliring_mhsw/daftarnilai'); ?>" method="POST">
												<div class="form-group row">
												  <label for="nim" class="col-md-3 col-form-label">NIM</label>
												  <div class="col-md-6">
													<input class="form-control" type="text" id="nimkliring" name="nimkliring" readonly>
													<input class="form-control" type="hidden" name="act" value="2" readonly>
												  </div>
												</div>
												<div class="form-group row">
												  <label for="name" class="col-md-3 col-form-label">Nama Mahasiswa</label>
												  <div class="col-md-6" id="namekliring">
													 : Nama
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tgllahir" class="col-md-3 col-form-label">Tempat Tanggal Lahir</label>
												  <div class="col-md-6" id="ttlkliring">
													 : TTL
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tgllahir" class="col-md-3 col-form-label">Judul Skripsi Bahasa Indonesia</label>
												  <div class="col-md-6" id="TAkliring">
													 : Bahasa Indonesia
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tgllahir" class="col-md-3 col-form-label">Judul Skripsi Bahasa Inggris</label>
												  <div class="col-md-8" id="TA2kliring">
													 : Bahasa Inggris
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tgllahir" class="col-md-3 col-form-label">Totak SKS Lulus</label>
												  <div class="col-md-8" id="SKSkliring">
													 : SKS Lulus
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tgllahir" class="col-md-3 col-form-label">IPK</label>
												  <div class="col-md-6" id="IPKkliring">
													 : IPK
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tgllahir" class="col-md-12 col-form-label">Dengan Daftar Nilai Sebagai Berikut : </label>
												</div>
												<div class="form-group row">
												  <div class="col-md-1">
													 NO
												  </div>
												  <div class="col-md-3">
													 NamaMK
												  </div>
												  <div class="col-md-3">
													 NamaMK Eng
												  </div>
												  <div class="col-md-1">
													 SKS
												  </div>
												  <div class="col-md-1">
													 Nilai
												  </div>
												  <div class="col-md-1">
													 Bobot
												  </div>
												  <div class="col-md-2">
													 Keterangan
												  </div>
												</div>
												<div id="daftarnilai_kliring">
													<div class="form-group row">
													  <div class="col-md-1">
														 NO
													  </div>
													  <div class="col-md-3">
														 NamaMK
													  </div>
													  <div class="col-md-3">
														 NamaMK Eng
													  </div>
													  <div class="col-md-1">
														 SKS
													  </div>
													  <div class="col-md-1">
														 Nilai
													  </div>
													  <div class="col-md-1">
														 Bobot
													  </div>
													  <div class="col-md-2">
														 Keterangan
													  </div>
													</div>
												</div>
												<div class="form-group row">
													<div class="col-md-12" style="text-align: center;">
														<input type="submit" name="simpan" id="usulkliring" value="Usul Kliring Skripsi" class="btn bg-olive">
													</div>
												</div>
											</form>
										</div>
										<!-- /.box-body -->
									</div>
									<!-- /.box -->
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->
						</section>
						<!-- /.content -->
				</div>
				<div class="modal-footer">
						<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

	<div class="modal fade" id="modal-usulkliring-wisuda">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myLargeModalLabel">Usul Kliring Wisuda</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
					<!-- Main content untuk isi data kliring -->
						<section class="content">
							<div class="row">
								<div class="col-12">
									<div class="box">
										<div class="box-header">
											<h3 class="box-title">Semua biodata dan nilai Mahasiswa akan terkirim ke APLIKASI WISUDA, pastikan semua data mahasiswa sudah BENAR sebelum anda mengirim</h3>
										</div>
										<!-- /.box-header -->
										<div class="box-body">
											<form action="<?= base_url('ademik/kliring_mhsw/daftarnilai_wisuda'); ?>" method="POST">
												<div class="form-group row">
												  <label for="nim" class="col-md-3 col-form-label">NIM</label>
												  <div class="col-md-6">
													<input class="form-control" type="text" id="nimwisuda" name="nimwisuda" readonly>
													<input class="form-control" type="hidden" name="act" value="2" readonly>
												  </div>
												</div>
												<div class="form-group row">
												  <label for="name" class="col-md-3 col-form-label">Nama Mahasiswa</label>
												  <div class="col-md-6" id="namewisuda">
													 : Nama
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tgllahir" class="col-md-3 col-form-label">Tempat Tanggal Lahir</label>
												  <div class="col-md-6" id="ttlwisuda">
													 : TTL
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tgllahir" class="col-md-3 col-form-label">Judul Skripsi Bahasa Indonesia</label>
												  <div class="col-md-6" id="TAwisuda">
													 : Bahasa Indonesia
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tgllahir" class="col-md-3 col-form-label">Judul Skripsi Bahasa Inggris</label>
												  <div class="col-md-8" id="TA2wisuda">
													 : Bahasa Inggris
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tgllahir" class="col-md-3 col-form-label">Totak SKS Lulus</label>
												  <div class="col-md-8" id="SKSwisuda">
													 : SKS Lulus
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tgllahir" class="col-md-3 col-form-label">IPK</label>
												  <div class="col-md-6" id="IPKwisuda">
													 : IPK
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tgllahir" class="col-md-3 col-form-label">No SK Yudisium</label>
												  <div class="col-md-8" id="nosk">
													 : No SK Yudisium
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tgllahir" class="col-md-3 col-form-label">Tanggal SK Yudisium</label>
												  <div class="col-md-6" id="tglsk">
													 : Tanggal SK Yudisium
												  </div>
												</div>
												<div class="form-group row">
												  <label for="tgllahir" class="col-md-12 col-form-label">Dengan Daftar Nilai Sebagai Berikut : </label>
												</div>
												<div class="form-group row">
												  <div class="col-md-1">
													 NO
												  </div>
												  <div class="col-md-3">
													 NamaMK
												  </div>
												  <div class="col-md-3">
													 NamaMK Eng
												  </div>
												  <div class="col-md-1">
													 SKS
												  </div>
												  <div class="col-md-1">
													 Nilai
												  </div>
												  <div class="col-md-1">
													 Bobot
												  </div>
												  <div class="col-md-2">
													 Keterangan
												  </div>
												</div>
												<div id="daftarnilai_wisuda">
													<div class="form-group row">
													  <div class="col-md-1">
														 NO
													  </div>
													  <div class="col-md-3">
														 NamaMK
													  </div>
													  <div class="col-md-3">
														 NamaMK Eng
													  </div>
													  <div class="col-md-1">
														 SKS
													  </div>
													  <div class="col-md-1">
														 Nilai
													  </div>
													  <div class="col-md-1">
														 Bobot
													  </div>
													  <div class="col-md-2">
														 Keterangan
													  </div>
													</div>
												</div>
												<div class="form-group row">
													<div class="col-md-12" style="text-align: center;">
														<input type="submit" name="simpan" id="usulwisuda" value="Usul Kliring Wisuda" class="btn bg-olive">
													</div>
												</div>
											</form>
										</div>
										<!-- /.box-body -->
									</div>
									<!-- /.box -->
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->
						</section>
						<!-- /.content -->
				</div>
				<div class="modal-footer">
						<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

	<div class="modal fade" id="modal-nilai-mahasiswa">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myLargeModalLabel">Tambah Nilai Mahasiswa</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
					<!-- Main content untuk isi data kliring -->
						<section class="content">
							<div class="row">
								<div class="col-12">
									<div class="box">
										<div class="box-header">
											<h3 class="box-title">Silahkan Pilih Matakuliah</h3>
										</div>
										<!-- /.box-header -->
										<div class="box-body">
												<div class="form-group row">
												  <label for="tugasakhir1" class="col-md-2 col-form-label">Mata Kuliah</label>
												  <div class="col-md-10">
													<select class="form-control select2 daftarmatakuliah" style="width: 100%;" id="daftarmatakuliah" name="daftarmatakuliah">
													</select>
												  </div>
												</div>
												<div class="form-group row">
												  <label for="predikat" class="col-md-2 col-form-label">Grade Nilai</label>
												  <div class="col-md-10">
														<select class="form-control select2 gradematakuliah" style="width: 100%;" id="grade" name="grade">
														</select>
												  </div>
												</div>
												<div class="form-group row">
													<div class="col-md-12" style="text-align: center;">
														<input type="submit" onclick="addnilai()" value="Add Matakuliah" class="btn bg-olive">
													</div>
												</div>
										</div>
										<!-- /.box-body -->
									</div>
									<!-- /.box -->

									<div class="box">
										<div class="box-header">
											<h3 class="box-title">Input Dengan Benar Nilai Transfer</h3>
										</div>
										<!-- /.box-header -->
										<div class="box-body">
											<!--<form action="<?= base_url('ademik/kliring_mhsw/simpan_nilai_mhsw'); ?>" method="POST">-->
												<div class="form-group row">
												  <label for="nim" class="col-md-2 col-form-label">NIM</label>
												  <div class="col-md-6">
													<input class="form-control" type="text" id="nimtambahnilai" name="nim" readonly>
												  </div>
												</div>
												<div class="form-group row">
												  <label for="name" class="col-md-2 col-form-label">Nama Mahasiswa</label>
												  <div class="col-md-6">
													<input class="form-control" type="text" id="nametambahnilai" name="name">
													<input class="form-control" type="hidden" id="totalsksp3s" name="totalsksp3s" readonly>
												  </div>
												</div>
												<div class="form-group row">
													<table class="table table-bordered table-striped table-responsive dataTable">
															<thead>
																<tr>
																	<th>Kode MK</th>
																	<th>Matakuliah</th>
																	<th>SKS</th>
																	<th>GradeNilai - Bobot</th>
																</tr>
															</thead>
															<tbody id="tabeltambahnilai">
															</tbody>
															<tfoot>
																<tr>
																	<th>Kode MK</th>
																	<th>Matakuliah</th>
																	<th>SKS</th>
																	<th>GradeNilai - Bobot</th>
																</tr>
															</tfoot>
														</table>
												</div>
												<div class="form-group row">
													<div class="col-md-12" style="text-align: center;">
														<!--<input type="submit" name="simpan" value="Simpan Nilai" class="btn bg-olive">-->
														<button onclick="simpannilai()">Simpan</button>
													</div>
												</div>
											<!--</form>-->
										</div>
										<!-- /.box-body -->
									</div>
									<!-- /.box -->
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->
						</section>
						<!-- /.content -->
				</div>
				<div class="modal-footer">
						<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

	<div class="modal fade" id="modal-penyetaraan-nilai">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myLargeModalLabel">Penyetaraan Nilai Mahasiswa</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
					<!-- Main content untuk isi data kliring -->
						<section class="content">
							<div class="row">
								<div class="col-12">
									<div class="box">
										<div class="box-header">
											<h3 class="box-title">Silahkan Pilih Matakuliah</h3>
										</div>
										<!-- /.box-header -->
										<div class="box-body">
												<div class="form-group row">
												  <label for="tugasakhir1" class="col-md-2 col-form-label">Mata Kuliah</label>
												  <div class="col-md-10">
													<select class="form-control select2 daftarmatakuliah" style="width: 100%;" id="daftarmatakuliah" name="daftarmatakuliah">
													</select>
												  </div>
												</div>
												<div class="form-group row">
												  <label for="predikat" class="col-md-2 col-form-label">Grade Nilai</label>
												  <div class="col-md-10">
														<select class="form-control select2 gradematakuliah" style="width: 100%;" id="grade" name="grade">
														</select>
												  </div>
												</div>
												<div class="form-group row">
													<div class="col-md-12" style="text-align: center;">
														<input type="submit" onclick="addnilai()" value="Add Matakuliah" class="btn bg-olive">
													</div>
												</div>
										</div>
										<!-- /.box-body -->
									</div>
									<!-- /.box -->

									<div class="box">
										<div class="box-header">
											<h3 class="box-title">Input Dengan Benar Nilai Transfer</h3>
										</div>
										<!-- /.box-header -->
										<div class="box-body">
											<!--<form action="<?= base_url('ademik/kliring_mhsw/simpan_nilai_mhsw'); ?>" method="POST">-->
												<div class="form-group row">
												  <label for="nim" class="col-md-2 col-form-label">NIM</label>
												  <div class="col-md-6">
													<input class="form-control" type="text" id="nimtambahnilai" name="nim" readonly>
												  </div>
												</div>
												<div class="form-group row">
												  <label for="name" class="col-md-2 col-form-label">Nama Mahasiswa</label>
												  <div class="col-md-6">
													<input class="form-control" type="text" id="nametambahnilai" name="name">
													<input class="form-control" type="hidden" id="totalsksp3s" name="totalsksp3s" readonly>
												  </div>
												</div>
												<div class="form-group row">
													<table class="table table-bordered table-striped table-responsive dataTable">
															<thead>
																<tr>
																	<th>Kode MK</th>
																	<th>Matakuliah</th>
																	<th>SKS</th>
																	<th>GradeNilai - Bobot</th>
																</tr>
															</thead>
															<tbody id="tabeltambahnilai">
															</tbody>
															<tfoot>
																<tr>
																	<th>Kode MK</th>
																	<th>Matakuliah</th>
																	<th>SKS</th>
																	<th>GradeNilai - Bobot</th>
																</tr>
															</tfoot>
														</table>
												</div>
												<div class="form-group row">
													<div class="col-md-12" style="text-align: center;">
														<!--<input type="submit" name="simpan" value="Simpan Nilai" class="btn bg-olive">-->
														<button onclick="simpannilai()">Simpan</button>
													</div>
												</div>
											<!--</form>-->
										</div>
										<!-- /.box-body -->
									</div>
									<!-- /.box -->
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->
						</section>
						<!-- /.content -->
				</div>
				<div class="modal-footer">
						<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

</div>

<script type="text/javascript">

	function delete_disable() {

		if ( $('#addsksMK').val() <= 0 || $('#addsksMK').val() <= 0 ) {

			$('#addsksTM').attr('disabled', true);
			$('#addsksP').attr('disabled', true);
			$('#addsksPL').attr('disabled', true);

		} else {

			$('#addsksTM').removeAttr('disabled');
			$('#addsksP').removeAttr('disabled');
			$('#addsksPL').removeAttr('disabled');

		}

	}


	function simpan(e,act,tahun,id) {

		var nim = $('#dataSearch').val();
		var data = 'act='+act+'&nim='+nim+'&tahun='+tahun+'&id='+id;
		//alert(data);
		$body = $("body");
		$body.addClass("loading");

		$.ajax({
			url: "<?= base_url('ademik/kliring_mhsw/changestatus'); ?>",
			data: data,
			type: 'POST',
			dataType: 'json',
			cache : false,
			success: function(respon){
				console.log('fandu '+respon);
				$body.removeClass("loading");

				if ( respon.ket == 'error' ) {
					console.log(respon.pesan);
					swal({
						title: 'Peringatan',
						type: 'warning',
						html: true,
						text: respon.pesan,
						confirmButtonColor: '#f7cb3b',
					});

				} else if (respon.ket == 'sukses') {
					swal({
						title: 'Pesan',
						type: 'success',
						html: true,
						text: respon.pesan,
						confirmButtonColor: 'green',
					}, function() {
						//location.reload();
						//console.log("fandu "+ e);
						if (act == 1){
							e.setAttribute("class", "btn btn-sm btn-primary fa fa-edit");
							e.setAttribute("onclick", "simpan(this,2,"+tahun+","+id+")");
						} else if (act == 2){
							e.setAttribute("class", "btn btn-sm btn-danger fa fa-trash");
							e.setAttribute("onclick", "simpan(this,1,"+tahun+","+id+")");
						}
						//var div1 = document.getElementById("d1");
						//div1.nodeName.setAttribute("class", "democlass");
					});
				}
			},
			error: function (err) {
	        	console.log(err);
	    	}
		});
	}

	function simpan_krs(e,act,tahun,id) {

		var nim = $('#dataSearch').val();
		var data = 'act='+act+'&nim='+nim+'&tahun='+tahun+'&id='+id;
		//alert(data);
		$body = $("body");
		$body.addClass("loading");

		$.ajax({
			url: "<?= base_url('ademik/kliring_mhsw/changestatus_krs'); ?>",
			data: data,
			type: 'POST',
			dataType: 'json',
			cache : false,
			success: function(respon){
				$body.removeClass("loading");

				if ( respon.ket == 'error' ) {
					console.log(respon.pesan);
					swal({
						title: 'Peringatan',
						type: 'warning',
						html: true,
						text: respon.pesan,
						confirmButtonColor: '#f7cb3b',
					});

				} else if (respon.ket == 'sukses') {
					swal({
						title: 'Pesan',
						type: 'success',
						html: true,
						text: respon.pesan,
						confirmButtonColor: 'green',
					}, function() {
						//location.reload();
						//console.log("fandu "+ e);
						if (act == 1){
							e.setAttribute("class", "btn btn-sm btn-primary fa fa-edit");
							e.setAttribute("onclick", "simpan_krs(this,2,"+tahun+","+id+")");
						} else if (act == 2){
							e.setAttribute("class", "btn btn-sm btn-danger fa fa-trash");
							e.setAttribute("onclick", "simpan_krs(this,1,"+tahun+","+id+")");
						}
						//var div1 = document.getElementById("d1");
						//div1.nodeName.setAttribute("class", "democlass");
					});
				}
			},
			error: function (err) {
	        	console.log(err);
	    	}
		});
	}

	function isidatakliring (){
		//alert('masuk isidatakliring');
		var nim = $('#dataSearch').val();
		var data = 'nim='+nim;

		// memunculkan kelender pada isi data kliring
		//alert("masuk");
		$("#tgllahir" ).datepicker({
			format: "yyyy-mm-dd",
			language: "fr",
			changeMonth: true,
			changeYear: true
		});
		//alert("masuk");

		//alert(data);
		$body = $("body");
		$body.addClass("loading");

		$.ajax({
			url: "<?= base_url('ademik/kliring_mhsw/isikliring'); ?>",
			data: data,
			type: 'POST',
			dataType: 'json',
			cache : false,
			success: function(respon){
				//console.log("fandu console = "+respon.NIM);
				$body.removeClass("loading");

				if ( respon.ket == 'error' ) {
					console.log(respon.pesan);
					swal({
						title: 'Peringatan',
						type: 'warning',
						html: true,
						text: respon.pesan,
						confirmButtonColor: '#f7cb3b',
					});

				} else if (respon.ket == 'sukses') {
					//alert(respon.TglLahir);
					$('#nim').val(respon.NIM);
					$('#name').val(respon.Name);
					$('#tgllahir').val(respon.TglLahir);
					$('#ipk').val(respon.IPK);
					$('#totsks').val(respon.TotalSKS);
					$('#skyudisium').val(respon.NomorSKYudisium);
					$('#tglyudisium').val(respon.TglSKYudisium);
					$('#predikat').prepend(respon.Predikat);
					$('#masastudi_tahun').val(respon.LamaStudiThn);
					$('#masastudi_bulan').val(respon.LamaStudiBln);
					$('#masastudi_hari').val(respon.LamaStudiHari);
					$('#tugasakhir1').html(respon.PengujiTA1);
					$('#tugasakhir2').html(respon.PengujiTA2);
					$('#tugasakhir3').html(respon.PengujiTA3);
					$('#tugasakhir4').html(respon.PengujiTA4);
					$('#tugasakhir5').html(respon.PengujiTA5);
					$('#tugasakhir6').html(respon.PengujiTA6);
					$('#tugasakhir7').html(respon.PengujiTA7);
					//$('#jdlskripsi_indonesi').val(respon.JudulTA);
					//$('#jdlskripsi_inggris').val(respon.JudulTA2);
					$('#jdlskripsi_indonesi_tampil').html(respon.JudulTA);
					$('#jdlskripsi_inggris_tampil').html(respon.JudulTA2);
					/*swal({
						title: 'Pesan',
						type: 'success',
						html: true,
						text: respon.pesan,
						confirmButtonColor: 'green',
					}, function() {
						console.log("fandu console = "+respon.ket);
					});
					console.log("fandu console = "+respon.ket);*/

				}
			},
			error: function (err) {
	        	console.log(err);
	    	}
		});
	}

	function usulkliringskripsi(){
		var nim = $('#dataSearch').val();
		var data = 'act=1&nimkliring='+nim;

		$body = $("body");
		$body.addClass("loading");

		$.ajax({
			url: "<?= base_url('ademik/kliring_mhsw/daftarnilai'); ?>",
			data: data,
			type: 'POST',
			dataType: 'json',
			cache : false,
			success: function(respon){
				//console.log(respon.pesan);
				$body.removeClass("loading");
				if ( respon.ket == 'error' ) {
					console.log(respon.pesan);
					swal({
						title: 'Peringatan',
						type: 'warning',
						html: true,
						text: respon.pesan,
						confirmButtonColor: '#f7cb3b',
					});
					$('#usulkliring').attr('type', 'hidden');
				} else if (respon.ket == 'sukses') {
					$('#nimkliring').val(respon.nim);
					$('#namekliring').html(respon.name);
					$('#ttlkliring').html(respon.ttl);
					$('#TAkliring').html(respon.judulTA);
					$('#TA2kliring').html(respon.judulTA2);
					$('#SKSkliring').html(respon.totsks);
					$('#IPKkliring').html(respon.ipk);
					$('#daftarnilai_kliring').html(respon.daftarnilai);
					$('#usulkliring').attr('type', 'submit');
				}
			},
			error: function (err) {
	        	console.log(err);
	    	}
		});
	}

	function usulkliringwisuda(){
		var nim = $('#dataSearch').val();
		var data = 'act=1&nimwisuda='+nim;

		$body = $("body");
		$body.addClass("loading");
		//alert(data);

		$.ajax({
			url: "<?= base_url('ademik/kliring_mhsw/daftarnilai_wisuda'); ?>",
			data: data,
			type: 'POST',
			dataType: 'json',
			cache : false,
			success: function(respon){
				//console.log(respon.pesan);

				$body.removeClass("loading");

				if ( respon.ket == 'error' ) {
					console.log(respon.pesan);
					swal({
						title: 'Peringatan',
						type: 'warning',
						html: true,
						text: respon.pesan,
						confirmButtonColor: '#f7cb3b',
					});
					$('#usulwisuda').attr('type', 'hidden');
				} else if (respon.ket == 'sukses') {
					console.log(respon.judulTA);
					$('#nimwisuda').val(respon.nim);
					$('#namewisuda').html(respon.name);
					$('#ttlwisuda').html(respon.ttl);
					$('#TAwisuda').html(respon.judulTA);
					$('#TA2wisuda').html(respon.judulTA2);
					$('#SKSwisuda').html(respon.totsks);
					$('#IPKwisuda').html(respon.ipk);
					$('#nosk').html(respon.noskyudisium);
					$('#tglsk').html(respon.tglskyudisium);
					$('#daftarnilai_wisuda').html(respon.daftarnilai);
					$('#usulwisuda').attr('type', 'submit');
				}
			},
			error: function (err) {
	        	console.log(err);
	    }
		});
	}

	function tambahnilai(){
		var nim = $('#dataSearch').val();
		var data = 'nim='+nim;
		$('#tabeltambahnilai').html("");

		$body = $("body");
		$body.addClass("loading");


		$.ajax({
			url: "<?= base_url('ademik/kliring_mhsw/tambahnilai'); ?>",
			data: data,
			type: 'POST',
			dataType: 'json',
			cache : false,
			success: function(respon){
				//console.log("fandu console = "+respon.NIM);
				//$body.removeClass("loading");

				$body.removeClass("loading");

				if ( respon.ket == 'error' ) {
					console.log(respon.pesan);
					swal({
						title: 'Peringatan',
						type: 'warning',
						html: true,
						text: respon.pesan,
						confirmButtonColor: '#f7cb3b',
					});

				} else if (respon.ket == 'sukses') {
					//alert(respon.TglLahir);
					$('#nimtambahnilai').val(respon.NIM);
					$('#nametambahnilai').val(respon.Name);
					$('#daftarmatakuliah').html(respon.options);
					$('#grade').html(respon.grade);
					$('#totalsksp3s').val(respon.totalsksp3s);
					//$('#tahuntr').html(respon.tahun);
				}
			},
			error: function (err) {
	        	console.log(err);
	    	}
		});
	}

	function addnilai(){
		//console.log($('.daftarmatakuliah').children("option:selected").text());
		//console.log($('.daftarmatakuliah').children("option:selected").html());
		//alert("masuk "+$('#daftarmatakuliah').children("option:selected").text());
		var string = ($('.daftarmatakuliah').children("option:selected").text());
		var stringgrade = ($('.gradematakuliah').children("option:selected").text());
		var indexArray = string.split(" -- ");
		var indexArraygrade = stringgrade.split(" -- ");
		var tr = "";

		indexArray.forEach(function(item, index){
			var str = "<th><div><div><div class='form-group row' style='margin: 0px 0px 0px 0px'>"+item+"</div></div></div></th>";
			tr = tr + str;
		});

		var strgrade = "<th><div><div><div class='form-group row' style='margin: 0px 0px 0px 0px'>"+stringgrade+"</div></div></div></th>";

		var pengurang = $('#totalsksp3s').val();

		var hasil = pengurang - indexArray[2];

		console.log(hasil);

		if((0 <= hasil) && (hasil <= pengurang)){
			$('#totalsksp3s').val(hasil);
			$('#tabeltambahnilai').append("<tr>"+tr+strgrade+"</tr>");
		} else {
			alert("anda melewati batas pengajuan penginputan nilai");
		}



		//console.log(string.charAt(0));
	}

	function simpannilai(){
		var nim = $('#dataSearch').val();
		var kodemk = [];
		var namamk = [];
		var sksmk = [];
		var gradenilai = [];
		var bobot = [];

		$body = $("body");
		$body.addClass("loading");

		$('#tabeltambahnilai tr').each(function() {
			var tds = $(this).find('th');
			console.log(tds);
			if(tds.length != 0) {
				var currText = tds.eq(0).text();
				var nmmk = tds.eq(1).text().replace(/,/g,"/");
				var skmk = tds.eq(2).text();
				var split = tds.eq(3).text();
				var splitgrade = split.split(" (");

				//console.log(nmmk);

				kodemk.push(currText);
				namamk.push(nmmk);
				sksmk.push(skmk);
				gradenilai.push(splitgrade[0]);
				bobot.push(splitgrade[1].split(")"));
			}
		});
		//console.log(kodemk);
		//console.log(namamk);
		//console.log(sksmk);
		//console.log(gradenilai);
		//console.log(bobot);

		$.ajax({
			url: "<?= base_url('ademik/kliring_mhsw/nilaip3s'); ?>",
			data: 'nim='+nim+'&kodemk='+kodemk+'&gradenilai='+gradenilai+'&bobot='+bobot+'&namamk='+namamk+'&sksmk='+sksmk,
			type: 'POST',
			dataType: 'json',
			cache : false,
			success: function(respon){
				if ( respon.ket == 'error' ) {
					swal({
						title: 'Peringatan',
						type: 'warning',
						html: true,
						text: respon.pesan,
						confirmButtonColor: '#f7cb3b',
					});

				} else if (respon.ket == 'sukses') {
					swal({
						title: 'Peringatan',
						type: 'success',
						html: true,
						text: respon.pesan,
						confirmButtonColor: '#f7cb3b',
					});
				}
				$('#daftarmatakuliah').html("");
				$('#grade').html("");
				$('#totalsksp3s').val("");
				$body.removeClass("loading");
				console.log(respon);
			},
			error: function (err) {
	        	console.log(err);
	    	}
		});
	}

	function kirim_sapta(nim){

		//alert(nim);

		$body = $("body");
		$body.addClass("loading");

		$.ajax({
			url: "<?= base_url('ademik/kliring_mhsw/kirim_sapta/'); ?>"+nim,
			type: 'POST',
			dataType: 'json',
			cache : false,
			success: function(respon){

				$body.removeClass("loading");

				if ( respon.ket == 'error' ) {
					console.log(respon.pesan);
					swal({
						title: 'Peringatan',
						type: 'warning',
						html: true,
						text: respon.pesan,
						confirmButtonColor: '#f7cb3b',
					});
				} else if (respon.ket == 'sukses') {
					swal({
						title: 'Berhasil Terkirim Ke Aplikasi SAPTA',
						type: 'success',
						html: true,
						text: respon.pesan,
						confirmButtonColor: 'green',
					});
				}
			},
			error: function (err) {
	        	console.log(err);
	    	}
		});
	}

</script>

<script src="<?=base_url()?>assets/wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
<script src="<?=base_url()?>assets/wysihtml5/lib/js/jquery-1.7.2.min.js"></script>
<script src="<?=base_url()?>assets/wysihtml5/src/bootstrap-wysihtml5.js"></script>

<script>
	$('.textarea').wysihtml5();
</script>
