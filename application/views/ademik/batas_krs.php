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
			Batas KRS
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="breadcrumb-item"><a href="<?= $_SESSION['tamplate'] ?>">Batas KRS</a></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Batas KRS</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<form class="form-horizontal" action="<?=base_url();?>ademik/batas_krs/dataBatasKRS" method="POST">
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
				<?php if ( !empty($form) ) { ?>
					<!-- Awal Table -->
		  			<div class="box">
			            <!-- Minggu -->
			            <div class="box-header">
			              <h3 class="box-title">DATA KRS</h3>
			            </div>
			            <!-- /.box-header -->
			            <div class="box-body">
		              		<dl class="dl-horizontal">
		              			<?php if ( $detail['detail'] == 1 || $detail['detail'] == 3 ) { ?>

		              				<dt>Jurusan</dt>
			                		<dd><?= $detail['kodeJurusan'].'-'.$detail['namaJurusan'] ?></dd>
			                		<dt>Tahun</dt>
			                		<dd><?= $detail['tahun'] ?></dd>
			                		<dt>Program</dt>
			                		<dd><?= ( $detail['program'] == 'REG' ) ? 'Reguler' : 'Non Reguler' ?></dd>
			                		<dt>Tanggal KRS</dt>
			                		<dd><?= $detail['krsm'].' <b>Sampai Dengan</b> '.$detail['krss'] ?></dd>
			                		<dt>Tanggal Ubah KRS</dt>
			                		<dd><?= $detail['ukrsm'].' <b>Sampai Dengan</b> '.$detail['ukrss'] ?></dd>

		              			<?php } elseif ( $detail['detail'] == 2 ) { ?>

		              				<dt>Jurusan</dt>
			                		<dd><?= $detail['kodeJurusan'].'-'.$detail['namaJurusan'] ?></dd>
			                		<dt>Program</dt>
			                		<dd><?= ( $detail['program1'] == 'REG' ) ? 'Reguler' : 'Non Reguler' ?></dd>
			                		<dt>Tahun</dt>
			                		<dd><?= $detail['tahun1'] ?></dd>
			                		<dt>Tanggal KRS</dt>
			                		<dd><?= $detail['krsm1'].' <b>Sampai Dengan</b> '.$detail['krss1'] ?></dd>
			                		<dt>Tanggal Ubah KRS</dt>
			                		<dd><?= $detail['ukrsm1'].' <b>Sampai Dengan</b> '.$detail['ukrss1'] ?></dd>
			                		<dt>Program</dt>
			                		<dd><?= ( $detail['program2'] == 'REG' ) ? 'Reguler' : 'Non Reguler' ?></dd>
			                		<dt>Tahun</dt>
			                		<dd><?= $detail['tahun2'] ?></dd>
			                		<dt>Tanggal KRS</dt>
			                		<dd><?= $detail['krsm2'].' <b>Sampai Dengan</b> '.$detail['krss2'] ?></dd>
			                		<dt>Tanggal Ubah KRS</dt>
			                		<dd><?= $detail['ukrsm2'].' <b>Sampai Dengan</b> '.$detail['ukrss2'] ?></dd>
			             
		                		<?php } elseif ( $detail['detail'] == 0 ) { ?>

		                			<dt>Jurusan</dt>
			                		<dd><?= $detail['kodeJurusan'].'-'.$detail['namaJurusan'] ?></dd>
			                		<h5 style="text-align: center;">KRS Tidak Ada yang Aktif, Silakan Menambahkan KRS Aktif yang baru</h5>

		                		<?php } ?>
		              		</dl>
		              		<?php if ( $detail['detail'] == 1 ) { ?>

		              			<div style="margin-left: 180px;">
			              			<a href="<?=base_url();?>ademik/batas_krs/formTambahBatasKRS/<?= $detail['kodeJurusan'] ?>/<?= $detail['namaJurusan'] ?>" class="btn btn btn-primary fa fa-plus"> Tambah KRS Baru</a>
						        	<!-- <a href="<?=base_url();?>ademik/batas_krs/formEditBatasKRS/<?= $detail['id'] ?>/<?= $detail['kodeJurusan'] ?>/<?= $detail['namaJurusan'] ?>" class="btn btn btn-success fa fa-edit"> Edit Batas KRS Reguler</a> -->
						        	<a href="<?=base_url();?>ademik/batas_krs/formListBatasKRS/<?= $detail['kodeJurusan'] ?>/<?= $detail['namaJurusan'] ?>/2" class="btn btn btn-warning fa fa-list"> List Batas KRS </a>
						        </div>

		              		<?php } elseif ( $detail['detail'] == 2 ) { ?>

		              			<div style="margin-left: 180px;">
			              			<a href="<?=base_url();?>ademik/batas_krs/formTambahBatasKRS/<?= $detail['kodeJurusan'] ?>/<?= $detail['namaJurusan'] ?>" class="btn btn btn-primary fa fa-plus"> Tambah KRS Baru</a>
						        	<!-- <a href="<?=base_url();?>ademik/batas_krs/formEditBatasKRS/<?= $detail['id1'] ?>/<?= $detail['kodeJurusan'] ?>/<?= $detail['namaJurusan'] ?> ?>" class="btn btn btn-success fa fa-edit"> Edit Batas KRS Reguler</a>
						        	<a href="<?=base_url();?>ademik/batas_krs/formEditBatasKRS/<?= $detail['id2'] ?>/<?= $detail['kodeJurusan'] ?>/<?= $detail['namaJurusan'] ?>" class="btn btn btn-success fa fa-edit"> Edit Batas KRS Non Reguler</a> -->
						        	<a href="<?=base_url();?>ademik/batas_krs/formListBatasKRS/<?= $detail['kodeJurusan'] ?>/<?= $detail['namaJurusan'] ?>/4" class="btn btn btn-warning fa fa-list"> List Batas KRS </a>
						        </div>

		              		<?php } elseif ( $detail['detail'] == 0 ) { ?>

		              			<div style="margin-left: 180px;">
			              			<a href="<?=base_url();?>ademik/batas_krs/formTambahBatasKRS/<?= $detail['kodeJurusan'] ?>/<?= $detail['namaJurusan'] ?>" class="btn btn btn-primary fa fa-plus"> Tambah KRS Baru</a>
			              			<a href="<?=base_url();?>ademik/batas_krs/formListBatasKRS/<?= $detail['kodeJurusan'] ?>/<?= $detail['namaJurusan'] ?>/2" class="btn btn btn-warning fa fa-list"> List Batas KRS </a>
						        </div>

		              		<?php } elseif ( $detail['detail'] == 3 ) { ?>

		              			<div style="margin-left: 180px;">
			              			<a href="<?=base_url();?>ademik/batas_krs/formTambahBatasKRS/<?= $detail['kodeJurusan'] ?>/<?= $detail['namaJurusan'] ?>" class="btn btn btn-primary fa fa-plus"> Tambah KRS Baru</a>
						        	<!-- <a href="<?=base_url();?>ademik/batas_krs/formEditBatasKRS/<?= $detail['id'] ?>/<?= $detail['kodeJurusan'] ?>/<?= $detail['namaJurusan'] ?>" class="btn btn btn-success fa fa-edit"> Edit Batas KRS Non Reguler</a> -->
						        	<a href="<?=base_url();?>ademik/batas_krs/formListBatasKRS/<?= $detail['kodeJurusan'] ?>/<?= $detail['namaJurusan'] ?>/2" class="btn btn btn-warning fa fa-list"> List Batas KRS </a>
						        </div>

		              		<?php } ?>
		              	
			            </div>

			            <?php if ( $form == 'list' ) { ?>
				            
					    	<hr width="100%">
					    	<div class="box-header">
			              		<h3 class="box-title">LIST DATA BATAS KRS</h3>
			            	</div>

			            	<div class="box-body">
					            <table id="example1" class="table table-bordered table-striped table-responsive dataTable">
					                <thead>
										<tr>
					                		<th>Tahun</th>
											<th>Program</th>
											<th>Tgl KRS Mulai</th>
											<th>Tgl KRS Berakhir</th>
											<th>Tgl Perubahan KRS Mulai</th>
											<th>Tgl Perubahan KRS Berakhir</th>
											<th>Status</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>

										<?php $no = 1; foreach ($detailTabel as $tampil) { ?>

											<tr>
												<th><?= $tampil->Tahun; ?></th>
												<th>
													<?php if ($tampil->KodeProgram == 'REG') {
														echo "REGULER";
													} else {
														echo "NON REGULER";
													} ?>
													
												</th>
												<th><?= date('d-m-Y',strtotime($tampil->krsm)) ?></th>
												<th><?= date('d-m-Y',strtotime($tampil->krss)) ?></th>
												<th><?= date('d-m-Y',strtotime($tampil->ukrsm)) ?></th>
												<th><?= date('d-m-Y',strtotime($tampil->ukrss)) ?></th>
												<th>
													<?php if ($tampil->NotActive == 'N') { 
														echo "Aktif";
													} else {
														echo 'Tidak Aktif';
													} ?>
												</th>
												<th>
													<?php if ($tampil->NotActive == 'N') { ?>
														<button type="button" title="Klik Untuk Menonaktifkan" onclick="tdkAktif('<?= $tampil->ID ?>')" class="btn btn btn-warning fa fa-power-off"></button>

														<a href="<?=base_url();?>ademik/batas_krs/formEditBatasKRS/<?= $tampil->ID ?>/<?= $detail['kodeJurusan'] ?>/<?= $detail['namaJurusan'] ?>" title="Edit Batas KRS" class="btn btn btn-success fa fa-edit"></a>

														<!-- <a href="<?=base_url();?>ademik/batas_krs/formEditBatasKRS/<?= $tampil->ID ?>/<?= $detail['kodeJurusan'] ?>/<?= $tampil->KodeProgram ?>" class="btn btn btn-success fa fa-power-off"></a>  AKTIF -->
													<?php } else { ?>
														<button type="button" title="Klik Untuk Mengaktifkan" onclick="aktif('<?= $tampil->ID ?>')" class="btn btn btn-info fa fa-play"></button>

														<!-- <a href="<?=base_url();?>ademik/batas_krs/formEditBatasKRS/<?= $tampil->ID ?>/<?= $detail['kodeJurusan'] ?>/<?= $tampil->KodeProgram ?>" class="btn btn btn-danger fa fa-play"></a>  TIDAK AKTIF -->
													<?php } ?>
												</th>
											</tr>

										<?php } ?>

									</tbody>
									<tfoot>
										<tr>
					                		<th>Tahun</th>
											<th>Program</th>
											<th>Tgl KRS Mulai</th>
											<th>Tgl KRS Berakhir</th>
											<th>Tgl Perubahan KRS Mulai</th>
											<th>Tgl Perubahan KRS Berakhir</th>
											<th>Status</th>
											<th>Aksi</th>
										</tr>
									</tfoot>
								</table>
							</div>

        				<?php } elseif ( $form == 'tambah' ) { ?>
				            
					    	<hr width="100%">
					    	<div class="box-header">
			              		<h3 class="box-title">TAMBAH DATA KRS</h3>
			            	</div>

			            	<div class="box-body">
      							<div class="row">
        							<div class="col-12">
            							<form action="" method="">
							            	<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Jurusan</label>
											  	<div class="col-sm-4">

											  		<?php if ( $detail['detail'] == 1 ) { ?>

											  			<input class="form-control" type="hidden" name="idAktifReg" id="idAktifReg" value="<?= $detail['id'] ?>" readonly />
											  			<input class="form-control" type="hidden" name="detail" id="detail" value="<?= $detail['detail'] ?>" readonly />

											  		<?php } elseif ( $detail['detail'] == 2 ) { ?>

											  			<input class="form-control" type="hidden" name="idAktifReg" id="idAktifReg" value="<?= $detail['id1'] ?>" readonly />
											  			<input class="form-control" type="hidden" name="idAktifReso" id="idAktifReso" value="<?= $detail['id2'] ?>" readonly />
											  			<input class="form-control" type="hidden" name="detail" id="detail" value="<?= $detail['detail'] ?>" readonly />

											  		<?php } elseif ( $detail['detail'] == 3 ) { ?>

											  			<input class="form-control" type="hidden" name="idAktifReso" id="idAktifReso" value="<?= $detail['id'] ?>" readonly />
											  			<input class="form-control" type="hidden" name="detail" id="detail" value="<?= $detail['detail'] ?>" readonly />

											  		<?php } elseif ( $detail['detail'] == 0 ) { ?>

											  			<input class="form-control" type="hidden" name="idAktifReso" id="idAktifReg" value="<?= $detail['id'] ?>" readonly />
											  			<input class="form-control" type="hidden" name="detail" id="detail" value="<?= $detail['detail'] ?>" readonly />

											  		<?php } ?>

											  		<input class="form-control" type="text" name="jurusan" id="jurusan" value="<?= $detail['kodeJurusan'].'-'.$detail['namaJurusan'] ?>" readonly />
											  	</div>
											</div>
											<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Tahun Akademik</label>
											  	<div class="col-sm-4">
													<input class="form-control" type="text" name="tahun" id="tahun" placeholder="Input Tahun Akademik" />
											  	</div>
											</div>
											<div class="form-group row">
											  	<label class="col-sm-2 control-label">Program Studi</label>
												<div class="col-sm-3">
													<select class="form-control select2" name="program" id="program">
														<option value="REG">Reguler</option>
														<option value="RESO">Non Reguler</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Pengisian KRS</label>
						            			<div class="col-sm-3">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i class="fa fa-calendar"></i>
			                    						</div>
			                    						<input type="text" name="isiKrs" id="isiKrs" value="" class="form-control reservation" />
			                  						</div>
						            			</div>
						            			<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Perubahan KRS</label>
						            			<div class="col-sm-3">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i class="fa fa-calendar"></i>
			                    						</div>
			                    						<input type="text" name="ubahKrs" id="ubahKrs" value="" class="form-control reservation" />
			                  						</div>
						            			</div>
											</div>
											<!-- <div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Pembayaran 1</label>
						            			<div class="col-sm-3">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i class="fa fa-calendar"></i>
			                    						</div>
			                    						<input type="text" name="bayar1" id="bayar1" value="" class="form-control reservation" />
			                  						</div>
						            			</div>
						            			<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Pembayaran 2</label>
						            			<div class="col-sm-3">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i class="fa fa-calendar"></i>
			                    						</div>
			                    						<input type="text" name="bayar2" id="bayar2" value="" class="form-control reservation" />
			                  						</div>
						            			</div>
											</div>
											<div class="form-group row">
	    				            			<label class="col-sm-2 control-label">Denda</label>
												<div class="col-sm-3">
											      	<input type="checkbox" id="md_checkbox_21" class="filled-in chk-col-red" onchange="delete_disable('#md_checkbox_21')" name="denda" />
											      	<label for="md_checkbox_21">Active</label>
											    </div>
	                      					</div>
	                      					<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Harga Denda</label>
						            			<div class="col-sm-3">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i>Rp.</i>
			                    						</div>
			                    						<input type="text" name="hrg" id="hrg" value="0" class="form-control hrg" disabled />
			                  						</div>
						            			</div>
											</div>
											<div class="form-group row">
						            			<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Absen</label>
						            			<div class="col-sm-2">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i class="fa fa-calendar"></i>
			                    						</div>
			                    						<input type="text" name="absen" id="absen" value="<?= $tglnow ?>" class="form-control datepicker" />
			                  						</div>
						            			</div>
						            			<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Tugas</label>
						            			<div class="col-sm-2">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i class="fa fa-calendar"></i>
			                    						</div>
			                    						<input type="text" name="tugas" id="tugas" value="<?= $tglnow ?>" class="form-control datepicker" />
			                  						</div>
						            			</div>
											</div>
											<div class="form-group row">
						            			<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal UTS</label>
						            			<div class="col-sm-2">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i class="fa fa-calendar"></i>
			                    						</div>
			                    						<input type="text" name="uts" id="uts" value="<?= $tglnow ?>" class="form-control datepicker" />
			                  						</div>
						            			</div>
						            			<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal UAS</label>
						            			<div class="col-sm-2">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i class="fa fa-calendar"></i>
			                    						</div>
			                    						<input type="text" name="uas" id="uas" value="<?= $tglnow ?>" class="form-control datepicker" />
			                  						</div>
						            			</div>
						            			<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal SS</label>
						            			<div class="col-sm-2">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i class="fa fa-calendar"></i>
			                    						</div>
			                    						<input type="text" name="ss" id="ss" value="<?= $tglnow ?>" class="form-control datepicker" />
			                  						</div>
						            			</div>
											</div> -->
											<div style="margin: 50px 0px 10px 218px">
												<button type="button" onclick="simpan('tambah')" class="btn btn btn-success fa fa-save"> Simpan</button>
							                	<button type="reset" class="btn btn btn-danger fa fa-refresh"> Reset</button>
											</div>
										</form>
            						</div>
            							<!-- /.col -->
          						</div>
          							<!-- /.row -->
        					</div>

        				<?php } elseif ( $form == 'edit' ) { ?>

        					<hr width="100%">
        					<div class="box-header">
			              		<h3 class="box-title">EDIT DATA KRS <?= ( $detailEdit['program'] == 'REG' ) ? 'REGULER' : 'NON REGULER' ?></h3>
			            	</div>

			            	<div class="box-body">
      							<div class="row">
        							<div class="col-12">
            							<form action="" method="">
							            	<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Jurusan</label>
											  	<div class="col-sm-4">
											  		<input class="form-control" type="hidden" name="idEdit" id="idEdit" value="<?= $detailEdit['id'] ?>" readonly />
											  		<input class="form-control" type="text" name="jurusanEdit" id="jurusanEdit" value="<?= $detail['kodeJurusan'].'-'.$detail['namaJurusan'] ?>" readonly />
											  	</div>
											</div>
											<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Tahun Akademik</label>
											  	<div class="col-sm-4">
													<input class="form-control" type="text" name="tahunEdit" id="tahunEdit" value="<?= $detailEdit['tahun'] ?>" placeholder="Input Tahun Akademik" readonly />
											  	</div>
											</div>
											<div class="form-group row">
											  	<label class="col-sm-2 control-label">Program Studi</label>
												<div class="col-sm-3">
													<select class="form-control select2" name="programEdit" id="programEdit">
														<option value="<?= $detailEdit['program'] ?>"><?= ( $detailEdit['program'] == 'REG' ) ? 'Reguler' : 'Non Reguler' ?></option>
													</select>
												</div>
											</div>
											<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Pengisian KRS</label>
						            			<div class="col-sm-3">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i class="fa fa-calendar"></i>
			                    						</div>
			                    						<input type="text" name="isiKrsEdit" id="isiKrsEdit" value="<?= $detailEdit['krsm'].' - '.$detailEdit['krss'] ?>" class="form-control reservation" />
			                  						</div>
						            			</div>
						            			<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Perubahan KRS</label>
						            			<div class="col-sm-3">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i class="fa fa-calendar"></i>
			                    						</div>
			                    						<input type="text" name="ubahKrsEdit" id="ubahKrsEdit" value="<?= $detailEdit['ukrsm'].' - '.$detailEdit['ukrss'] ?>" class="form-control reservation" />
			                  						</div>
						            			</div>
											</div>
											<!-- <div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Pembayaran 1</label>
						            			<div class="col-sm-3">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i class="fa fa-calendar"></i>
			                    						</div>
			                    						<input type="text" name="bayar1Edit" id="bayar1Edit" value="<?= $detailEdit['mulaiBayar1'].' - '.$detailEdit['akhirBayar1'] ?>" class="form-control reservation" />
			                  						</div>
						            			</div>
						            			<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Pembayaran 2</label>
						            			<div class="col-sm-3">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i class="fa fa-calendar"></i>
			                    						</div>
			                    						<input type="text" name="bayar2Edit" id="bayar2Edit" value="<?= $detailEdit['mulaiBayar2'].' - '.$detailEdit['akhirBayar2'] ?>" class="form-control reservation" />
			                  						</div>
						            			</div>
											</div>
											<div class="form-group row">
	    				            			<label class="col-sm-2 control-label">Denda</label>
												<div class="col-sm-3">
											      	<input type="checkbox" id="md_checkbox_22" class="filled-in chk-col-red" onchange="delete_disable('#md_checkbox_22')" name="denda" <?= ( $detailEdit['denda'] == 'N' ) ? '' : 'checked' ?>" />
											      	<label for="md_checkbox_22">Active</label>
											    </div>
	                      					</div>
	                      					<div class="form-group row">
											  	<label for="example-text-input" class="col-sm-2 col-form-label">Harga Denda</label>
						            			<div class="col-sm-3">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i>Rp.</i>
			                    						</div>
			                    						<input type="text" name="hrgEdit" id="hrg" value="<?= $detailEdit['hargaDenda'] ?>" class="form-control hrg" disabled />
			                  						</div>
						            			</div>
											</div>
											<div class="form-group row">
						            			<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Absen</label>
						            			<div class="col-sm-2">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i class="fa fa-calendar"></i>
			                    						</div>
			                    						<input type="text" name="absenEdit" id="absenEdit" value="<?= ( $detailEdit['absen'] == '00-00-0000' ) ? $tglnow : $detailEdit['absen'] ?>" class="form-control datepicker" />
			                  						</div>
						            			</div>
						            			<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Tugas</label>
						            			<div class="col-sm-2">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i class="fa fa-calendar"></i>
			                    						</div>
			                    						<input type="text" name="tugasEdit" id="tugasEdit" value="<?= ( $detailEdit['tugas'] == '00-00-0000' ) ? $tglnow : $detailEdit['tugas'] ?>" class="form-control datepicker" />
			                  						</div>
						            			</div>
											</div>
											<div class="form-group row">
						            			<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal UTS</label>
						            			<div class="col-sm-2">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i class="fa fa-calendar"></i>
			                    						</div>
			                    						<input type="text" name="utsEdit" id="utsEdit" value="<?= ( $detailEdit['uts'] == '00-00-0000' ) ? $tglnow : $detailEdit['uts'] ?>" class="form-control datepicker" />
			                  						</div>
						            			</div>
						            			<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal UAS</label>
						            			<div class="col-sm-2">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i class="fa fa-calendar"></i>
			                    						</div>
			                    						<input type="text" name="uasEdit" id="uasEdit" value="<?= ( $detailEdit['uas'] == '00-00-0000' ) ? $tglnow : $detailEdit['uas'] ?>" class="form-control datepicker" />
			                  						</div>
						            			</div>
						            			<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal SS</label>
						            			<div class="col-sm-2">
						              				<div class="input-group">
			                    						<div class="input-group-addon">
			                      							<i class="fa fa-calendar"></i>
			                    						</div>
			                    						<input type="text" name="ssEdit" id="ssEdit" value="<?= ( $detailEdit['ss'] == '00-00-0000' ) ? $tglnow : $detailEdit['ss'] ?>" class="form-control datepicker" />
			                  						</div>
						            			</div>
											</div> -->
											<div style="margin: 50px 0px 10px 218px">
												<button type="button" onclick="simpan('edit')" class="btn btn btn-success fa fa-save"> Simpan</button>
							                	<button type="reset" class="btn btn btn-danger fa fa-refresh"> Reset</button>
											</div>
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

	var rupiah1 = document.getElementById('hrg');
    rupiah1.addEventListener('keyup', function(e) {
        rupiah1.value = formatRupiah(this.value, 'Rp. ');
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
    }

    function convertToAngka(rupiah) {

		return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);

	}

	function delete_disable(id) {

		if ( $(id).is(":checked") ) {

			$('.hrg').removeAttr('disabled');

		} else {

			$('.hrg').attr('disabled', true);
			document.getElementByClass("hrg").value = 0;

		}

	}

	function simpan(act) {

		var detail, idAktifReg, idAktifReso, jurusan, tahun, program, isiKrs, ubahKrs, bayar1, bayar2, denda, hrg, absen, tugas, uts, uas, ss;

		if ( act == 'tambah' ) {

			detail = $('#detail').val();
			program = $('#program').val();
			jurusan = $('#jurusan').val();
			tahun = $('#tahun').val();
			isiKrs = $('#isiKrs').val();
			ubahKrs = $('#ubahKrs').val();
			/*bayar1 = $('#bayar1').val();
			bayar2 = $('#bayar2').val();
			hrg = convertToAngka($('#hrg').val());
			absen = $('#absen').val();
			tugas = $('#tugas').val();
			uts = $('#uts').val();
			uas = $('#uas').val();
			ss = $('#ss').val();*/

			if ( detail == 1 ) {
				if ( program == 'REG' ) {
					idAktifReg = $('#idAktifReg').val();
					idAktifReso = '';
				} else {
					idAktifReg = '';
					idAktifReso = '';
				}
			} else if ( detail == 2 ) {
				if ( program == 'REG' ) {
					idAktifReg = $('#idAktifReg').val();
					idAktifReso = '';
				} else {
					idAktifReg = '';
					idAktifReso = $('#idAktifReso').val();
				}
			} else if ( detail == 3 ) {
				if ( program == 'REG' ) {
					idAktifReg = '';
					idAktifReso = '';
				} else {
					idAktifReg = '';
					idAktifReso = $('#idAktifReso').val();
				}
			} else if ( detail == 0 ) {
				if ( program == 'REG' ) {
					idAktifReg = '';
					idAktifReso = '';
				} else {
					idAktifReg = '';
					idAktifReso = '';
				}
			}


			if ($('#md_checkbox_21').is(":checked")){
				denda = 'Y';
			}else{
				denda = 'N';
			}

		} else if ( act == 'edit' ) {

			program = $('#programEdit').val();
			jurusan = $('#jurusanEdit').val();
			tahun = $('#tahunEdit').val();
			isiKrs = $('#isiKrsEdit').val();
			ubahKrs = $('#ubahKrsEdit').val();
			/*bayar1 = $('#bayar1Edit').val();
			bayar2 = $('#bayar2Edit').val();
			hrg = convertToAngka($('#hrg').val());
			absen = $('#absenEdit').val();
			tugas = $('#tugasEdit').val();
			uts = $('#utsEdit').val();
			uas = $('#uasEdit').val();
			ss = $('#ssEdit').val();*/

			if ( program == 'REG' ) {
				idAktifReg = $('#idEdit').val();
				idAktifReso = '';
			} else if ( program == 'RESO' ) {
				idAktifReg = '';
				idAktifReso = $('#idEdit').val();
			}
			

			if ($('#md_checkbox_22').is(":checked")){
				denda = 'Y';
			}else{
				denda = 'N';
			}

		}

		var data = 'act='+act+'&idAktifReg='+idAktifReg+'&idAktifReso='+idAktifReso+'&jurusan='+jurusan+'&tahun='+tahun+'&program='+program+'&isiKrs='+isiKrs+'&ubahKrs='+ubahKrs/*+'&bayar1='+bayar1+'&bayar2='+bayar2+'&denda='+denda+'&hrg='+hrg+'&absen='+absen+'&tugas='+tugas+'&uts='+uts+'&uas='+uas+'&ss='+ss*/;

		//alert(data);

		$body = $("body");
		$body.addClass("loading");

		$.ajax({
			url: "<?= base_url('ademik/batas_krs/validasiForm'); ?>",
			data: data,
			type: 'POST',
			dataType: 'json',
			cache : false,
			success: function(respon){
				$body.removeClass("loading");
				console.log(respon.pesan);

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

				} else if ( respon.ket == 'konfirmasi' ) {
					swal({
				        title: "Peringatan",
				        text: respon.pesan,
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

							var data = 'id='+respon.data['id']+'&jurusan='+respon.data['jurusan']+'&tahun='+respon.data['tahun']+'&kodeProgram='+respon.data['kodeProgram']+'&krsm='+respon.data['krsm']+'&krss='+respon.data['krss']+'&ukrsm='+respon.data['ukrsm']+'&ukrss='+respon.data['ukrss']+/*'&mulaiBayar1='+respon.data['mulaiBayar1']+'&akhirBayar1='+respon.data['akhirBayar1']+'&mulaiBayar2='+respon.data['mulaiBayar2']+'&akhirBayar2='+respon.data['akhirBayar2']+'&denda='+respon.data['denda']+'&hargaDenda='+respon.data['hargaDenda']+*/'&notactive='+respon.data['notactive']/*+'&absen='+respon.data['absen']+'&tugas='+respon.data['tugas']+'&uts='+respon.data['uts']+'&uas='+respon.data['uas']+'&ss='+respon.data['ss']*/;

							if ( respon.data['act'] == 'tambah' ) {
								var url = "<?= base_url('ademik/batas_krs/setTambahKRS'); ?>";
							} else {
								var url = "<?= base_url('ademik/batas_krs/setEditKRS'); ?>";
							}


					    	$.ajax({
								url : "<?= base_url('ademik/batas_krs/setTambahKRS'); ?>",
								type: "POST",
								data: data,
								dataType: "JSON",
								success: function(hasil) {
									$body.removeClass("loading");

									if ( hasil.ket == 'error' ) {
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
				            swal("Batal", "KRS Tidak Tersimpan", "error");
				        }
				    });

				} else {
					console.log(respon);
				}
			},
			error: function (err) {
	        	console.log(err);
	    	}
		});
	}


	function aktif(id){
		swal({
	        title: "Peringatan",
	        text: "Anda Yakin Mengaktifkan Batas KRS ini?",
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

				var data = 'id='+id;

		    	$.ajax({
					url : "<?= base_url('ademik/batas_krs/aktifBatasKRS'); ?>",
					type: "POST",
					data: data,
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

	function tdkAktif(id){
		swal({
	        title: "Peringatan",
	        text: "Anda Yakin Menonaktifkan Batas KRS ini?",
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
					url : "<?= base_url('ademik/batas_krs/tdkAktifBatasKRS'); ?>",
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