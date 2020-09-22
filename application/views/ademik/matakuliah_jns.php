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
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Mata Kuliah Per-Jenis
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="breadcrumb-item"><a href="<?= $_SESSION['tamplate'] ?>">Mata Kuliah Per-Jenis</a></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Mata Kuliah Per-Jenis <span style="font-size: 11px; color: red;"><i>(*Penting : Menu ini digunakan untuk data-data Mata Kuliah, baik di Feeder Dikti maupun di Siakad)</i></span></h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<form class="form-horizontal" action="<?=base_url();?>ademik/Matakuliah_jns/getDataTabel" method="POST">
							<div class="form-group row">
								<label class="col-sm-1 control-label">Pilih Jurusan</label>
								<div class="col-sm-4">
									<select class="form-control select2" name="dataSearch" id="dataSearch">
										<option value="">--Pilih Jurusan--</option>
										<?php
											foreach ($jurusan as $pilih) {
												echo "<option value='".$pilih['Kode']."-".$pilih['Nama_Indonesia']."'>".$pilih['Kode']." -- ".$pilih['Nama_Indonesia']."</option>";
											}
										?>
									</select>
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
				<?php if ( empty($namaJurusan) ) {

				} else { ?>
					<!-- Awal Table -->
		  			<div class="box">
			            <!-- <div class="box-header">
			              <h3 class="box-title">KURIKULUM AKTIF</h3>
			            </div>
			            <div class="box-body">
		              		<dl class="dl-horizontal">
		                		<dt>Jurusan</dt>
		                		<dd><?= $namaJurusan ?></dd>
		                		<dt>Nama Kurikulum</dt>
		                		<dd><?= $kurikulum->Nama ?></dd>
		                		<dt>Tahun</dt>
		                		<dd><?= $kurikulum->Tahun ?></dd>
		                		<dt>Nama Semester</dt>
		                		<dd><?= $kurikulum->Sesi ?></dd>
		                		<dt>Jumlah Semester</dt>
		                		<dd><?= $kurikulum->JmlSesi ?></dd>
		                		<dt>ID Kurikulum</dt>
		                		<dd><?= $kurikulum->IdKurikulum ?></dd>
		              		</dl>
			            </div> -->

			            <?php if ( $this->uri->segment(3) == 'getDataTabel' ) { ?>

				            
				            <div class="row col-md-12">
				            	<div class="col-md-12">
				            		<div class="box-header">
				              			<h3 class="box-title">DAFTAR SEMUA MATA KULIAH</h3>
				              			<div style="margin: 15px 0px 0px 10px">
											<div class="form-group row">
								            	<form method="POST" action="<?=base_url();?>ademik/report/Report/cetak_matkul_per_jenis">
													<input type="hidden" name="idKurikulum" value="<?= $kurikulum->IdKurikulum ?>">
													<input type="hidden" name="namaJurusan" value="<?= $namaJurusan ?>">
													<button style="margin-right: 5px;" type="submit" class="btn btn btn-success fa fa-print"> Print</button>
												</form>
							                	<a href="<?=base_url();?>ademik/Matakuliah_jns/formTambah/<?= $kurikulum->KodeJurusan ?>/<?= $namaJurusan ?>" class="btn btn btn-primary fa fa-plus"> Tambah Mata Kuliah</a>
							                	<!-- <button style="margin: 0px 5px 0px 5px; type="button" class="btn btn btn-default fa fa-file-excel-o"> Download Excel</button>
							                	<button type="button" class="btn btn btn-danger fa fa-mail-forward"> Import Data</button> -->
					                		</div>
					            		</div>
				            		</div>
						            <div class="box-body">
							            <table id="example1" class="table table-bordered table-striped table-responsive dataTable">
							                <thead>
							                	<tr>
							                		<th colspan="8" style="text-align: center;">Data Siakad</th>
							                		<th colspan="3" style="text-align: center;">Data PDPT</th>
													<!-- <th rowspan="2">Action</th> -->
							                	</tr>
												<tr>
													<th>No</th>
							                		<th>Kode</th>
							                		<th>Id_Feeder</th>
													<th>Nama Indonesia</th>
													<th>Nama English</th>
													<th>Nama Kurikulum</th>
													<th>SKS</th>
													<th>Jenis Mata Kuliah</th>
													<th>Aktif</th>
													<th>Mata Kuliah</th>
													<th>Kurikulum</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>

												<?php $no = 1; foreach ($detailTabel as $tampil) { 
													$nmJurusan = str_replace($namaJurusan, ',', ' ') ?>

													<tr>
														<th><?= $no++; ?></th>
														<th><?= $tampil->Kode ?></th>
														<th><?= $tampil->id_mk ?></th>
														<th>
															<?= $tampil->Nama_Indonesia ?>
														</th>
														<th><?= $tampil->Nama_English ?></th>
														<th><?= $tampil->Nama?></th>
														<th><?= $tampil->SKS ?></th>
														<th>
															<?= ($tampil->KodeJenisMK == 'A') ? 'Wajib' : '' ?>
															<?= ($tampil->KodeJenisMK == 'B') ? 'Pilihan' : '' ?>
															<?= ($tampil->KodeJenisMK == 'C') ? 'Wajib Peminatan' : '' ?>
															<?= ($tampil->KodeJenisMK == 'D') ? 'Pilihan Peminatan' : '' ?>
															<?= ($tampil->KodeJenisMK == 'S') ? 'Tugas akhir/Skripsi/Tesis/Disertasi' : '' ?>
														</th>
														<th>
															<?php if ( $tampil->NotActive == 'Y' ) { echo "<span class='glyphicon glyphicon-remove' style='color: red;'></span>"; } else { echo "<span class='glyphicon glyphicon-ok' style='color: green;'></span>"; } ?>
														</th>
														<th>
															<?php if ( empty($tampil->id_mk) ) { ?>
																<span class='glyphicon glyphicon-remove' style='color: red;'></span>
															<?php } else { ?>
																<img src="<?=base_url();?>assets/images/ristekdikti.png" width="30px;">
															<?php } ?>
														</th>
														<th>
															<?php if ( empty($tampil->id_kurikulum) ) { ?>
																<span class='glyphicon glyphicon-remove' style='color: red;'></span>
															<?php } else { ?>
																<img src="<?=base_url();?>assets/images/ristekdikti.png" width="30px;">
															<?php } ?>
														</th>
														<th>
															<a href="<?=base_url();?>ademik/Matakuliah_jns/formEdit/<?= $kurikulum->KodeJurusan ?>/<?= $nmJurusan ?> /<?= $tampil->ID ?>" class="<?= ( empty($tampil->id_mk) ) ? 'btn btn btn-danger fa fa-save' : 'btn btn btn-success fa fa-edit' ?>"> <?= ( empty($tampil->id_mk) ) ? 'Kirim' : 'Update' ?>
															</a>
														</th>
													</tr>

												<?php } ?>

											</tbody>
											<tfoot>
												<tr>
													<th>No</th>
													<th>Kode</th>
													<th>Id_Feeder</th>
													<th>Nama Indonesia</th>
													<th>Nama English</th>
													<th>Nama Kurikulum</th>
													<th>SKS</th>
													<th>Jenis Mata Kuliah</th>
													<th>Aktif</th>
													<th>Mata Kuliah</th>
													<th>Kurikulum</th>
													<th>Action</th>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
					      	<div class="keterangan" style="margin: 5px 0px 15px 27px">
					      		<b style="color: blue;">Keterangan :</b> <br />
					      		<span class='glyphicon glyphicon-asterisk' style='color: orange;'></span> Mata Kuliah Wajib <br />
					      		<span class='glyphicon glyphicon-remove' style='color: red;'></span> Mata Kuliah Tidak Aktif
					      	</div>

					    <?php } elseif ( $this->uri->segment(3) == 'formTambah' ) { ?>

					    	<div class="box-header">
			              		<h3 class="box-title">TAMBAH DATA MATA KULIAH</h3>
			            	</div>

			            	<div class="box-body">
      							<div class="row">
        							<div class="col-12">
            							<form action="" method="">
							            	<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Kode Mata Kuliah</label>
											  	<div class="col-sm-4">
											  		<input class="form-control" type="hidden" name="jurusan" id="addjurusan" value="<?= $kodeJurusan ?>-<?= $namaJurusan ?>" >
											  		<input class="form-control" type="hidden" name="id_mk" id="addid_mk" value="">
													<input class="form-control" type="text" name="kodeMK" id="addkodeMK" placeholder="Input Kode Mata Kuliah">
											  	</div>
											</div>
											<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Nama Indonesia</label>
											  	<div class="col-sm-4">
													<input class="form-control" type="text" name="namaIndo" id="addnamaIndo" placeholder="Input Nama Indonesia">
											  	</div>
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Nama English</label>
											  	<div class="col-sm-4">
													<input class="form-control" type="text" name="namaEng" id="addnamaEng" placeholder="Input Nama English">
											  	</div>
											</div>
											<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Bobot Mata Kuliah (SKS)</label>
											  	<div class="col-sm-1">
													<input class="form-control" type="number" name="sksMK" id="addsksMK" value="0" min="0" max="9" id="sksMK" readonly>
											  	</div>
											  	<span id="spin" style="visibility: hidden;"><i class="fa fa-spinner fa-spin" style="font-size: 35px;"></i></span>
											</div>
											<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Bobot Tatap Muka (SKS)</label>
											  	<div class="col-sm-1">
													<input class="form-control" type="number" name="sksTM" value="0" min="0" max="99" id="addsksTM" onchange="jumlahSKS()">
											  	</div>
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Bobot Praktikum (SKS)</label>
											  	<div class="col-sm-1">
													<input class="form-control" type="number" name="sksP" value="0" min="0" max="9" id="addsksP" onchange="jumlahSKS()">
											  	</div>
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Bobot Prak. Lapangan (SKS)</label>
											  	<div class="col-sm-1">
													<input class="form-control" type="number" name="sksPL" value="0" min="0" max="9" id="addsksPL" onchange="jumlahSKS()"> 
											  	</div>
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Bobot Simulasi (SKS)</label>
											  	<div class="col-sm-1">
													<input class="form-control" type="number" name="sksS" value="0" min="0" max="9" id="addsksS" onchange="jumlahSKS()">
											  	</div>
											</div>
											<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Metode Pembelajaran</label>
											  	<div class="col-sm-8">
													<input class="form-control" type="text" value="" name="metode_belajar" id="addmetode_belajar">
											  	</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-2 control-label">Jenis Mata Kuliah</label>
												<div class="col-sm-4">
													<select class="form-control select2" name="datajenisMK" id="addjenisMK">
														<option value="A">Wajib</option>
														<option value="B">Pilihan</option>
														<option value="C">Wajib Peminatan</option>
														<option value="D">Pilihan Peminatan</option>
														<option value="S">Tugas akhir/Skripsi/Tesis/Disertasi</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-2 control-label">Kelompok Mata Kuliah</label>
												<div class="col-sm-4">
													<select class="form-control select2" name="datajenisMK" id="addkelompokMK">
														<option value="">--Pilih Kelompok Mata Kuliah--</option>

														<?php
															foreach ($jenisMK as $jenis) {
																echo "<option value='".$jenis['Kode']."'>".$jenis['Kode']." -- ".$jenis['Nama']."</option>";
															}
														?>

													</select>
												</div>
											</div>
											<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Mulai Efektif</label>
	    				            			<div class="col-sm-2">
	    				              				<div class="input-group">
	                            						<div class="input-group-addon">
	                              							<i class="fa fa-calendar"></i>
	                            						</div>
	                            						<input type="text" name="tgl_mulai" id="addtgl_mulai" value="" class="form-control datepicker" readonly />
	                          						</div>
	    				            			</div>
											</div>
											<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Akhir Efektif</label>
	    				            			<div class="col-sm-2">
	    				              				<div class="input-group">
	                            						<div class="input-group-addon">
	                              							<i class="fa fa-calendar"></i>
	                            						</div>
	                            						<input type="text" name="tgl_akhir" id="addtgl_akhir" value="" class="form-control datepicker" readonly />
	                          						</div>
	    				            			</div>
											</div>
											<div class="form-group row">
											  	<div class="demo-checkbox" style="margin: 10px 0px 10px 235px">
											      	<input type="checkbox" id="md_checkbox_22" class="filled-in chk-col-red" name="addnotactive" />
											      	<label for="md_checkbox_22">Tidak Aktif</label>
											    </div>
											</div>
											<div style="margin: 0px 0px 10px 218px">
												<button type="button" onclick="simpan('add')" class="btn btn btn-success fa fa-save"> Simpan</button>
							                	<button type="reset" class="btn btn btn-danger fa fa-refresh"> Reset</button>
							                	<button type="button" class="btn btn btn-default fa fa-tag"> Prasyarat</button>
											</div>
										</form>
										<form method="POST" action="<?= base_url('ademik/matakuliah_jns/getDataTabel'); ?>">
											<input type="hidden" name="kodeJur" value="<?= $kodeJurusan ?>">
											<input type="hidden" name="namaJurusan" value="<?= $namaJurusan ?>">
											<button type="submit" class="btn btn btn-warning fa fa-mail-reply"> Kembali</button>
										</form>
            						</div>
            							<!-- /.col -->
          						</div>
          							<!-- /.row -->
        					</div>

						<?php } elseif(isset($pageweb) and $pageweb=='formEdit'){ ?>

					    	<div class="box-header">
			              		<h3 class="box-title">EDIT DATA MATA KULIAH</h3>
			            	</div>

			            	<div class="box-body">
      							<div class="row">
        							<div class="col-12">
            							<form action="" method="">
							            	<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Kode Mata Kuliah</label>
											  	<div class="col-sm-4">
											  		<input class="form-control" type="hidden" name="jurusan" id="jurusan" value="<?= $kodeJurusan ?>">
											  		<input class="form-control" type="hidden" name="id_mk" id="id_mk" value="<?= $detailEdit->id_mk ?>">
											  		<input class="form-control" type="hidden" name="id" id="id" value="<?= $detailEdit->ID ?>">
													<input class="form-control" type="text" name="kodeMK" id="kodeMK" value="<?= $detailEdit->Kode ?>" placeholder="Input Kode Mata Kuliah">
											  	</div>
											</div>
											<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Nama Indonesia</label>
											  	<div class="col-sm-4">
													<input class="form-control" type="text" name="namaIndo" id="namaIndo" value="<?= $detailEdit->Nama_Indonesia ?>" placeholder="Input Nama Indonesia">
											  	</div>
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Nama English</label>
											  	<div class="col-sm-4">
													<input class="form-control" type="text" name="namaEng" id="namaEng" value="<?= $detailEdit->Nama_English ?>" placeholder="Input Nama English">
											  	</div>
											</div>
											<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Bobot Mata Kuliah (SKS)</label>
											  	<div class="col-sm-1">
													<input class="form-control" type="number" name="sksMK" id="sksMK" value="<?= $detailEdit->SKS ?>" min="0" max="9" id="sksMK" readonly>
											  	</div>
											  	<span id="spin" style="visibility: hidden;"><i class="fa fa-spinner fa-spin" style="font-size: 35px;"></i></span>
											</div>
											<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Bobot Tatap Muka (SKS)</label>
											  	<div class="col-sm-1">
													<input class="form-control" type="number" name="sksTM" value="<?= $detailEdit->SKSTatapMuka ?>" min="0" max="99" id="sksTM" onchange="jumlahSKSedit()">
											  	</div>
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Bobot Praktikum (SKS)</label>
											  	<div class="col-sm-1">
													<input class="form-control" type="number" name="sksP" value="<?= $detailEdit->SKSPraktikum ?>" min="0" max="9" id="sksP" onchange="jumlahSKSedit()">
											  	</div>
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Bobot Prak. Lapangan (SKS)</label>
											  	<div class="col-sm-1">
													<input class="form-control" type="number" name="sksPL" value="<?= $detailEdit->SKSPraktekLap ?>" min="0" max="9" id="sksPL" onchange="jumlahSKSedit()"> 
											  	</div>
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Bobot Simulasi (SKS)</label>
											  	<div class="col-sm-1">
													<input class="form-control" type="number" name="sksS" value="<?= $detailEdit->SKSSimulasi ?>" min="0" max="9" id="sksS" onchange="jumlahSKSedit()">
											  	</div>
											</div>
											<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Metode Pembelajaran</label>
											  	<div class="col-sm-8">
													<input class="form-control" type="text" value="<?= $detailEdit->metode_belajar ?>" name="metode_belajar" id="metode_belajar">
											  	</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-2 control-label">Jenis Mata Kuliah</label>
												<div class="col-sm-4">
													<select class="form-control select2" name="jenisMK" id="jenisMK">
														<option value="A" <?= ($detailEdit->KodeJenisMK == 'A') ? 'selected' : '' ?> >Wajib</option>
														<option value="B" <?= ($detailEdit->KodeJenisMK == 'B') ? 'selected' : '' ?> >Pilihan</option>
														<option value="C" <?= ($detailEdit->KodeJenisMK == 'C') ? 'selected' : '' ?> >Wajib Peminatan</option>
														<option value="D" <?= ($detailEdit->KodeJenisMK == 'D') ? 'selected' : '' ?> >Pilihan Peminatan</option>
														<option value="S" <?= ($detailEdit->KodeJenisMK == 'S') ? 'selected' : '' ?> >Tugas akhir/Skripsi/Tesis/Disertasi</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-2 control-label">Kelompok Mata Kuliah</label>
												<div class="col-sm-4">
													<select class="form-control select2" name="kelompokMK" id="kelompokMK">

														<?php if ( empty($detailEdit->KodeKelompokMK) ) { ?>

	                              							<option value="">--Pilih Kelompok Mata Kuliah--</option>

	                            						<?php } else { ?>

	                              							<option value="<?= $detailEdit->KodeKelompokMK ?>"><?= $detailEdit->KodeKelompokMK ?></option>

	                            						<?php }

															foreach ($jenisMK as $jenis) {
																echo "<option value='".$jenis['Kode']."'>".$jenis['Kode']." -- ".$jenis['Nama']."</option>";
															}

														?>

													</select>
												</div>
											</div>
											<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Mulai Efektif</label>
	    				            			<div class="col-sm-2">
	    				              				<div class="input-group">
	                            						<div class="input-group-addon">
	                              							<i class="fa fa-calendar"></i>
	                            						</div>
	                            						<input type="text" name="tgl_mulai" id="tgl_mulai" value="<?= ( $detailEdit->tgl_mulai == '0000-00-00' ) ? '' : date('d-m-Y',strtotime( $detailEdit->tgl_mulai )); ?>" class="form-control datepicker" readonly />
	                          						</div>
	    				            			</div>
											</div>
											<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Akhir Efektif</label>
	    				            			<div class="col-sm-2">
	    				              				<div class="input-group">
	                            						<div class="input-group-addon">
	                              							<i class="fa fa-calendar"></i>
	                            						</div>
	                            						<input type="text" name="tgl_akhir" id="tgl_akhir" value="<?= ( $detailEdit->tgl_akhir == '0000-00-00' ) ? '' : date('d-m-Y',strtotime( $detailEdit->tgl_akhir )); ?>" class="form-control datepicker" readonly />
	                          						</div>
	    				            			</div>
											</div>
											<div class="form-group row">
											  	<div class="demo-checkbox" style="margin: 10px 0px 10px 235px">
											      	<input type="checkbox" id="md_checkbox_23" class="filled-in chk-col-red" name="addnotactive" <?= ($detailEdit->NotActive == 'Y') ? 'checked' : '' ?> />
											      	<label for="md_checkbox_23">Tidak Aktif</label>
											    </div>
											</div>
											<div style="margin: 50px 0px 10px 218px">
												<button type="button" onclick="simpan('update')" class="btn btn btn-success fa fa-save"> Simpan</button>
												<button type="reset" class="btn btn btn-danger fa fa-refresh"> Reset</button>
							                	<button type="button" class="btn btn btn-default fa fa-tag"> Prasyarat</button>
							                </div>
										</form>
					                	<form method="POST" action="<?= base_url('ademik/matakuliah_jns/getDataTabel'); ?>">
											<input type="hidden" name="kodeJur" value="<?= $kodeJurusan ?>">
											<input type="hidden" name="namaJurusan" value="<?= $namaJurusan ?>">
											<button type="submit" class="btn btn btn-warning fa fa-mail-reply"> Kembali</button>
										</form>
            						</div>
            							<!-- /.col -->
          						</div>
          							<!-- /.row -->
        					</div>

						<?php } ?>

				    </div>
		  			<!-- Akhir Table -->
		  		<?php } ?> 

			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>

<script type="text/javascript">
	
	function jumlahSKS() {

		document.getElementById('spin').style.visibility = "visible";

		var sksTM = document.getElementById('addsksTM').value;
		var sksP = document.getElementById('addsksP').value;
		var sksPL = document.getElementById('addsksPL').value;
		var sksS = document.getElementById('addsksS').value;

		var result = parseInt(sksTM) + parseInt(sksP) + parseInt(sksPL) + parseInt(sksS);
	    
	    if (!isNaN(result)) {

	        document.getElementById('addsksMK').value = result;

	        setTimeout(function(){
		    	document.getElementById('spin').style.visibility = "hidden";
		    },750);

	    }

	}

	function jumlahSKSedit() {

		document.getElementById('spin').style.visibility = "visible";

		var sksTM = document.getElementById('sksTM').value;
		var sksP = document.getElementById('sksP').value;
		var sksPL = document.getElementById('sksPL').value;
		var sksS = document.getElementById('sksS').value;

		var result = parseInt(sksTM) + parseInt(sksP) + parseInt(sksPL) + parseInt(sksS);
	    
	    if (!isNaN(result)) {

	        document.getElementById('sksMK').value = result;

	        setTimeout(function(){
		    	document.getElementById('spin').style.visibility = "hidden";
		    },750);

	    }

	}

	function simpan(act) {

		var id, jurusan, id_mk, kodeMK, namaIndo, namaEng, sksMK, sksTM, sksP, sksPL, sksS, notactive, jenisMK, kelompokMK, tgl_mulai, tgl_akhir, metode_belajar;

		if ( act == 'add' ) {

			id = '';
			jurusan = $('#addjurusan').val();
			id_mk = $('#addid_mk').val();
			kodeMK = $('#addkodeMK').val();
			namaIndo = $('#addnamaIndo').val();
			namaEng = $('#addnamaEng').val();
			sksMK = $('#addsksMK').val();
			sksTM = $('#addsksTM').val();
			sksP = $('#addsksP').val();
			sksPL = $('#addsksPL').val();
			sksS = $('#addsksS').val();
			metode_belajar = $('#addmetode_belajar').val();
			jenisMK = $('#addjenisMK').val();
			kelompokMK = $('#addkelompokMK').val();
			tgl_mulai = $('#addtgl_mulai').val();
			tgl_akhir = $('#addtgl_akhir').val();

			if ( $('#md_checkbox_22').is(':checked') ) {
				notactive = 'Y';
			} else {
				notactive = 'N';
			}

		} else {

			id = $('#id').val();
			jurusan = $('#jurusan').val();
			id_mk = $('#id_mk').val();
			kodeMK = $('#kodeMK').val();
			namaIndo = $('#namaIndo').val();
			namaEng = $('#namaEng').val();
			sksMK = $('#sksMK').val();
			sksTM = $('#sksTM').val();
			sksP = $('#sksP').val();
			sksPL = $('#sksPL').val();
			sksS = $('#sksS').val();
			metode_belajar = $('#metode_belajar').val();
			jenisMK = $('#jenisMK').val();
			kelompokMK = $('#kelompokMK').val();
			tgl_mulai = $('#tgl_mulai').val();
			tgl_akhir = $('#tgl_akhir').val();

			if ( $('#md_checkbox_22').is(':checked') ) {
				notactive = 'Y';
			} else {
				notactive = 'N';
			}

		}

		var data = 'act='+act+'&id='+id+'&jurusan='+jurusan+'&id_mk='+id_mk+'&kodeMK='+kodeMK+'&namaIndo='+namaIndo+'&namaEng='+namaEng+'&sksMK='+sksMK+'&sksTM='+sksTM+'&sksP='+sksP+'&sksPL='+sksPL+'&sksS='+sksS+'&metode_belajar='+metode_belajar+'&notactive='+notactive+'&jenisMK='+jenisMK+'&kelompokMK='+kelompokMK+'&tgl_mulai='+tgl_mulai+'&tgl_akhir='+tgl_akhir;

		$body = $("body");
		$body.addClass("loading");

		$.ajax({
			url: "<?= base_url('ademik/matakuliah_jns/validasiForm'); ?>",
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
						location.reload();
					});

				}

			},
			error: function (err) {
	        	console.log(err);
	    	}
		});

	}

	function hapus(id){
		swal({
	        title: "Peringatan",
	        text: "Anda Yakin Untuk Menghapus Mata Kuliah ini?",
	        type: "warning",
	        showCancelButton: true,
	        confirmButtonColor: '#DD6B55',
	        confirmButtonText: 'Ya',
	        cancelButtonText: "Tidak",
	        closeOnConfirm: false,
	        closeOnCancel: false
		},
	    function(isConfirm) {	
	        if (isConfirm) {
	            $body = $("body");
				$body.addClass("loading");

				var dataHapus = 'id='+id;

		    	$.ajax({
					url : "<?= base_url('ademik/matakuliah_jns/setDeleteData'); ?>",
					type: "POST",
					data: dataHapus,
					dataType: "JSON",
					success: function(hasil) {
						$body.removeClass("loading");

						if ( hasil.ket == 'error' ) {
							//console.log(respon.pesan);
							swal({   
								title: 'Peringatan',   
								type: 'warning',    
								html: true, 
								text: hasil.pesan,
								confirmButtonColor: '#f7cb3b',   
							});

						} else if (hasil.ket == 'sukses') {
							swal({   
								title: 'Pesan',   
								type: 'success',    
								html: true, 
								text: hasil.pesan,
								confirmButtonColor: 'green',   
							}, function() {
								location.reload();
							});

						}
					},
					error: function (err) {
				    	console.log(err);
					}
				});

	        } else {
	            swal("Batal","", "error");
	        }
	    });
	}

</script>