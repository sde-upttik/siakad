 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      	<h1>
        	Data Mahasiswa
      	</h1>
      	<ol class="breadcrumb">
        	<li class="breadcrumb-item"><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        	<li class="breadcrumb-item"><a href="">Mahasiswa</a></li>
        	<li class="breadcrumb-item active">Data Mahasiswa</li>
      	</ol>
    </section>

	<?php if ($webpage == 'dataMhsw') { ?>
		<!-- Main content -->
		<section class="content">
		  	<div class="row">
		    	<div class="col-12">
		     
		     		<div class="box">
		        		<div class="box-header">
		          			<h3 class="box-title">Tabel Data Mahasiswa</h3>
		        		</div>
		        		<!-- /.box-header -->
		        		<div class="box-body">
							<form class="form-horizontal" action="<?=base_url();?>ademik/Mhsw/dataTabelMhsw" method="POST">
								<div class="form-group row">
									<label class="col-sm-1 control-label">Pilih Jurusan</label>
									<div class="col-sm-4">
										<select class="form-control select2" name="dataSearch" id="dataSearch">
											<option value="">--Pilih Jurusan--</option>
											<?php
												foreach ($jurusan as $pilih) {
													echo "<option value='".$pilih['Kode']."'>".$pilih['Kode']." -- ".$pilih['Nama_Indonesia']."</option>";
												}
											?>
										</select>
									</div>
									<label class="col-sm-1 control-label">Tahun Angkatan</label>
									<div class="col-sm-3">
										<input class="form-control" type="text" name="tahunakademik" id="tahunakademik" placeholder="Input Tahun Angkatan" />
									</div>
									<div class="col-sm-2">
										<input class="btn btn-flat btn-info" type="submit" id="search" name="search" value="Search">
									</div>
								</div>
							</form>
						</div>

						<?php if ( $this->uri->segment(3) == 'dataTabelMhsw' ) { 

							if ( isset($dataTabel) ) { ?>

			            		<div class="box-body">
			              			<table id="example1" class="table table-bordered table-striped table-responsive">
			                			<thead>
											<tr>
												<th>No</th>
												<th>NIM</th>
												<th>Nama Mahasiswa</th>
												<th>Nama Ibu</th>
												<th>Tanggal Lahir</th>
												<th>Status</th>
												<th>Dosen PA</th>
												<th>Program</th>
												<th>Jurusan/Prodi</th>
												<th>Status PDDIKTI</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$no=1; 
												foreach ($dataTabel as $tampil) { ?>

												<tr>
													<th><?= $no++ ?></th>
													<th><a href="<?=base_url();?>ademik/mhsw/biodataMhsw/<?= $tampil->NIM ?>" style="color: red;"><?= $tampil->NIM ?></a></th>
													<th><?= $tampil->Name ?></th>
													<th><?= $tampil->NamaIbu ?></th>
													<th><?= date('d-m-Y',strtotime($tampil->TglLahir)) ?></th>
													<th><?= $tampil->statusMhsw ?></th>
													<th><?= $tampil->dosen ?></th>
													<th><?= $tampil->namaProgram ?></th>
													<th><?= $tampil->namaJurusan ?></th>
													<th>
														<?php if ( empty($tampil->id_reg_pd) ) { ?>
															<button type="button" onclick="" class="btn btn btn-danger fa fa-mail-forward"> Kirim Ke PDPT</button>
														<?php } else { ?>
															<span class='glyphicon glyphicon-ok' style='color: green;'></span>
														<?php } ?>
													</th>
												</tr>

											<?php } ?>

										</tbody>
										<tfoot>
											<tr>
												<th>No</th>
												<th>NIM</th>
												<th>Nama Mahasiswa</th>
												<th>Nama Ibu</th>
												<th>Tanggal Lahir</th>
												<th>Status</th>
												<th>Dosen PA</th>
												<th>Program</th>
												<th>Jurusan/Prodi</th>
												<th>Status PDDIKTI</th>
											</tr>
										</tfoot>
			              			</table>
			            		</div>
			            		<!-- /.box-body -->
			            	<?php } else {} ?>
			            		
		            	<?php } else {} ?>

		      		</div>
		      		<!-- /.box -->       
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</section>
		<!-- /.content -->

	<?php } elseif ( $webpage == 'biodataMhsw') { ?>

		<section class="content">
	    	<div class="row">
	      		<div class="col-xl-4 col-lg-5">
	        		<!-- Profile Image -->
	        		<div class="box box-primary">
	          			<div class="box-body box-profile">

	          				<?php if ( $dataProfil->Sex == 'P') { ?>
	          					<img class="profile-user-img rounded-circle img-fluid mx-auto d-block" src="<?=base_url()?>assets/images/puan.png" alt="User profile picture">
	          				<?php } else { ?>
	            				<img class="profile-user-img rounded-circle img-fluid mx-auto d-block" src="<?=base_url()?>assets/images/laki.png" alt="User profile picture">
	            			<?php } ?>

	            			<!-- <button type="button" class="btn btn-sm btn-success fa fa-file-image-o" style="margin-left: 157px" data-toggle="modal" data-target="#modalUploadFoto"> Replace</button> -->
		                    <!-- <button type="button" class="btn btn-sm btn-danger fa fa-eye"> View</button> -->

	            			<h3 class="profile-username text-center"><?= $dataProfil->Name ?></h3>
	            			<h5 class="profile-username text-center"><?= $dataProfil->NIM ?></h5>
	            			<p class="text-muted text-center"><?= $dataProfil->jurusan ?></p>
	              
	            			<div class="row">
	              				<div class="col-12">
	              					<div class="profile-user-info">
							      		<p>Email</p>
							      		<h6 class="margin-bottom"><?= ( empty($dataProfil->Email) ) ? '-' : $dataProfil->Email ?></h6>
							      		<p>No. Telepon</p>
							      		<h6 class="margin-bottom"><?= ( empty($dataProfil->Phone) ) ? '-' : $dataProfil->Phone ?></h6>
							      		<p>No. HP</p>
							      		<h6 class="margin-bottom"><?= ( empty($dataProfil->HP) ) ? '-' : $dataProfil->HP ?></h6> 
							      		<p>Alamat</p>
							      		<h6 class="margin-bottom"><?= ( empty($dataProfil->Alamat) ) ? '-' : $dataProfil->Alamat ?></h6>
	                				</div>
	             				</div>
	            			</div>
	          			</div>
	          			<!-- /.box-body -->
	        		</div>
	        		<!-- /.box -->
	      		</div>
	      		<!-- /.col -->
		      	<div class="col-xl-8 col-lg-7">
		        	<div class="nav-tabs-custom">
		          		<ul class="nav nav-tabs">    
		            		<li><a class="active" href="#dataMhsw" data-toggle="tab">Data Pribadi</a></li>
		            		<li><a href="#dataOrtuMhsw" data-toggle="tab">Data Orang Tua</a></li>
		            		<!-- <li><a href="#settings" data-toggle="tab">Data Orang Tua Wali</a></li>
		            		<li><a href="#settings" data-toggle="tab">Akademik</a></li>
		            		<li><a href="#settings" data-toggle="tab">Asal Sekolah</a></li>
		            		<li><a href="#gantiPassMhsw" data-toggle="tab">Ganti Password</a></li> -->
		          		</ul>              
		          		<div class="tab-content">

		          			<form class="form-horizontal" action="<?=base_url();?>ademik/Mhsw/dataTabelMhsw" method="POST">
		          				<input class="form-control" type="hidden" name="dataSearch" id="dataSearch" value="<?= $dataProfil->KodeJurusan ?>" />
								<input class="form-control" type="hidden" name="tahunakademik" id="tahunakademik" value="<?= $dataProfil->TahunAkademik ?>" />
								<input class="btn btn-flat btn-info" type="submit" id="search" name="search" value="Kembali Ke Data Mahasiswa">
							</form>
		       
		            		<div class="active tab-pane" id="dataMhsw">
		            			<div class="box-body">
		                			<div class="row">
		                  				<div class="col-12">
		                    				<form action="" method="POST">
		                    					<div class="form-group row">
		  				              				<label for="example-text-input" class="col-sm-2 col-form-label">Nama</label>
		  				              				<div class="col-sm-5">
		                          						<input class="form-control" type="text" name="nama" value="<?= $dataProfil->Name ?>" id="nama" <?= ( empty($dataProfil->id_pd) ) ? '' : 'readonly'; ?> />
		  				              				</div>
		  				              				<div class="col-sm-5">
		                        						<span style="font-size: 11px;"><i>*( Nama disesuai dengan Nama di Ijazah Terakhir )</i></span>
		                        					</div>
		  				            			</div>
		    				          			<div class="form-group row">
		    				            			<label for="example-text-input" class="col-sm-2 col-form-label">Tempat Lahir</label>
		    				            			<div class="col-sm-5">
		                         						<input class="form-control" type="text" name="tmpLahir" value="<?= $dataProfil->TempatLahir ?>" id="tmpLahir" <?= ( empty($dataProfil->id_pd) ) ? '' : 'readonly'; ?> />
		    				            			</div>
		    				            			<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Lahir</label>
		    				            			<div class="col-sm-3">
		    				              				<div class="input-group">
		                            						<div class="input-group-addon">
		                              							<i class="fa fa-calendar"></i>
		                            						</div>
		                            						<input type="text" name="tglLahir" id="tglLahir" value="<?= date('d-m-Y',strtotime( $dataProfil->TglLahir )) ?>" class="form-control datepicker" <?= ( empty($dataProfil->id_pd) ) ? '' : 'readonly'; ?> />
		                          						</div>
		    				            			</div>
		    				          			</div>
		    				          			<div class="form-group row">
		    				            			<label class="col-sm-2 col-form-label"></label>
		    				            			<div class="col-sm-10">
		                          						<input name="sex" type="radio" id="radio_1" value="L" <?= ($dataProfil->Sex == 'L') ? 'checked' : '' ?> />
		                          						<label for="radio_1">Laki-Laki</label>
		                          						<input name="sex" type="radio" id="radio_2" value="P" <?= ($dataProfil->Sex == 'P') ? 'checked' : '' ?> />
		                          						<label for="radio_2">Perempuan</label>
		                        					</div>
		                      					</div>
		    				          			<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">Agama</label>
		                        					<div class="col-sm-10">
		                    		  					<select class="form-control select2" name="agama" style="width: 100%;" id="agama" />

		                            						<?php if ( empty($dataProfil->AgamaID) ) { ?>

		                              							<option value="">--Pilih Agama--</option>

		                            						<?php } else { ?>

		                              							<option value="<?= $dataProfil->AgamaID ?>"><?= $dataProfil->Agama ?></option>

		                            						<?php } foreach ($dataAgama as $pilih) {

		                              							echo "<option value='".$pilih->AgamaID."'>".$pilih->Agama."</option>";

		                            						} ?>

		                          						</select>
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-2 col-form-label">Nama Ibu</label>
		                      						<div class="col-sm-5">
		                        						<input class="form-control" type="text" name="ibu" value="<?= $dataProfil->NamaIbu ?>" id="ibu" <?= ( empty($dataProfil->id_pd) ) ? '' : 'readonly'; ?> />
		                      						</div>
		                    					</div>
		                      					<hr>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">NIK</label>
		                        					<div class="col-sm-3">
		                        						<input class="form-control" type="hidden" name="id" value="<?= $dataProfil->ID ?>" id="id" readonly />
		                        						<input class="form-control" type="hidden" name="pd" value="<?= $dataProfil->id_pd ?>" id="pd" readonly />
		                        						<input class="form-control" type="hidden" name="regpd" value="<?= $dataProfil->id_reg_pd ?>" id="regpd" readonly />
		                          						<input class="form-control" type="text" name="nik" value="<?= $dataProfil->NIK ?>" id="nik" />
		                        					</div>
		                        					<div class="col-sm-7">
		                        						<span style="font-size: 11px;"><i>*( Nomor KTP tanpa tanda baca, Isikan Nomor Paspor untuk Warga Negara Asing )</i></span>
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">NISN</label>
		                        					<div class="col-sm-4">
		                          						<input class="form-control" type="text" name="nisn" value="<?= $dataProfil->NISN ?>" id="nisn" />
		                        					</div>
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">NPWP</label>
		                        					<div class="col-sm-4">
		                          						<input class="form-control" type="text" name="npwp" value="<?= $dataProfil->NPWP ?>" id="npwp" />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">Kewarganegaraan</label>
		                        					<div class="col-sm-10">
		                    		  					<select class="form-control select2" name="negara" style="width: 100%;" id="negara" onchange="aktif_kecamatan()" >

		                            						<?php if ( empty($dataProfil->Kewarganegaraan) ) { ?>

		                              							<option value="">--Pilih Negara--</option>

		                            						<?php } else { ?>

		                              							<option value="<?= $dataProfil->Kewarganegaraan ?>"><?= $dataProfil->Nama_Negara ?></option>

		                            						<?php } foreach ($dataNegara as $pilih) {

		                              							echo "<option value='".$pilih->Kode_Negara."'>".$pilih->Nama_Negara."</option>";

		                            						} ?>

		                          						</select>
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">Alamat</label>
		                        					<div class="col-sm-10">
		                          						<input class="form-control" type="textarea" name="alamat" value="<?= $dataProfil->Alamat ?>" id="alamat" />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-2 col-form-label">Dusun</label>
		                        					<div class="col-sm-4">
		                          						<input class="form-control" type="text" name="dusun" value="<?= $dataProfil->Dusun ?>" id="dusun" />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">RT</label>
		                        					<div class="col-sm-2">
		                          						<input class="form-control" type="text" name="rt" value="<?= $dataProfil->RT ?>" id="rt" />
		                        					</div>
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">RW</label>
		                        					<div class="col-sm-2">
		                          						<input class="form-control" type="text" name="rw" value="<?= $dataProfil->RW ?>" id="rw" />
		                        					</div>
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">Kodepos</label>
		                        					<div class="col-sm-2">
		                          						<input class="form-control" type="text" name="kodepos" value="<?= $dataProfil->KodePos ?>" id="kodepos" />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">Kelurahan</label>
		                        					<div class="col-sm-6">
		                          						<input class="form-control" type="text" name="kelurahan" value="<?= $dataProfil->Kelurahan ?>" id="kelurahan" />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">Kecamatan</label>
		                        					<div class="col-sm-10">
		                    		  					<select class="form-control select2" name="kecamatan" style="width: 100%;" id="kecamatan" />

		                    		  						<?php if ( empty($dataProfil->Kecamatan) ) { ?>

		                              							<option value="">--Pilih Terlebih Dahulu Kewarganegaraannya--</option>

		                            						<?php } else { ?>

		                              							<option value="<?= $dataProfil->Kecamatan ?>"><?= $dataProfil->nama_wilayah ?></option>

		                            						<?php }

		                            						 if(isset($dataWilayah)){
		                            						 	foreach ($dataWilayah as $pilih) {

		                              							echo "<option value='".$pilih->id."'>".$pilih->nama_wilayah."</option>";

		                            							}
		                            						 }
		                            						  ?>

		                          						</select>
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">Jenis Tinggal</label>
		                        					<div class="col-sm-5">
		                    		  					<select class="form-control select2" name="jnsTinggal" style="width: 100%;" id="jnsTinggal" />

		                    		  						<?php if ( empty($dataProfil->JenisTinggal) ) { ?>

		                              							<option value="">--Pilih Jenis Tinggal--</option>

		                            						<?php } else { ?>

		                              							<option value="<?= $dataProfil->JenisTinggal ?>"><?= $dataProfil->nama_jenis_tinggal ?></option>

		                            						<?php } foreach ($dataTinggal as $pilih) {

		                              							echo "<option value='".$pilih->id."'>".$pilih->nama_jenis_tinggal."</option>";

		                            						} ?>

		                          						</select>
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">Alat Transportasi</label>
		                        					<div class="col-sm-5">
		                    		  					<select class="form-control select2" name="alatTrans" style="width: 100%;" id="alatTrans" />

		                    		  						<?php if ( empty($dataProfil->AlatTransportasi) ) { ?>

		                              							<option value="">--Pilih Alat Transportasi--</option>

		                            						<?php } else { ?>

		                              							<option value="<?= $dataProfil->AlatTransportasi ?>"><?= $dataProfil->nama_transportasi ?></option>

		                            						<?php } foreach ($dataAlat as $pilih) {

		                              							echo "<option value='".$pilih->id."'>".$pilih->nama_transportasi."</option>";

		                            						} ?>

		                          						</select>
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-tel-input" class="col-sm-2 col-form-label">Telepon</label>
		                        					<div class="col-sm-4">
		                          						<input class="form-control" type="tel" name="telepon" value="<?= $dataProfil->Phone ?>" id="telepon" />
		                        					</div>
		                        					<label for="example-tel-input" class="col-sm-2 col-form-label">HP</label>
		                        					<div class="col-sm-4">
		                          						<input class="form-control" type="tel" name="hp" value="<?= $dataProfil->HP ?>" id="hp" />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
		                        					<div class="col-sm-10">
		                          						<input class="form-control" type="email" name="email" value="<?= $dataProfil->Email ?>" id="email" />
		                        					</div>
		                     					</div>
		                     					<div class="form-group row">
		    				            			<label class="col-sm-2 col-form-label">Penerima KPS?</label>
		    				            			<div class="col-sm-4">
		                          						<input name="kps" type="radio" id="radio_3" onclick="open_noKPS()" value="0" <?= ($dataProfil->penerimaKPS == '0') ? 'checked' : '' ?> />
		                          						<label for="radio_3">Tidak</label>
		                          						<input name="kps" type="radio" id="radio_4" onclick="open_noKPS()" value="1" <?= ($dataProfil->penerimaKPS == '1') ? 'checked' : '' ?> />
		                          						<label for="radio_4">Ya</label>
		                        					</div>
		                        					<label for="example-tel-input" class="col-sm-2 col-form-label">Nomor KPS</label>
		                        					<div class="col-sm-4">
		                          						<input class="form-control" type="text" name="noKPS" value="<?= $dataProfil->nomorKPS ?>" id="noKPS" disabled />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-tel-input" class="col-sm-4 col-form-label">Tipe Pembayaran SPP/UKT</label>
		                        					<div class="col-sm-4">
														<select class="form-control select2" name="bayarSPP" id="bayarSPP" onchange="delete_disable()">
															<option value="Reguler" <?= ($dataProfil->TipePembayaran == 'Reguler' || $dataProfil->TipePembayaran == '') ? 'selected' : ''; ?> >Reguler</option>
															<option value="Beasiswa" <?= ($dataProfil->TipePembayaran == 'Beasiswa') ? 'selected' : ''; ?> >Beasiswa</option>
															<option value="Potongan UKT" <?= ($dataProfil->TipePembayaran == 'Potongan UKT') ? 'selected' : ''; ?> >Potongan UKT</option>
															<option value="Lain-Lain" <?= ($dataProfil->TipePembayaran == 'Lain-Lain') ? 'selected' : ''; ?> >Lain-Lain</option>
														</select>
													</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-4 col-form-label">Keterangan Beasiswa,Potongan UKT,dll</label>
												  	<div class="col-sm-6">
														<input class="form-control" type="text" name="ketSPP" id="ketSPP" value="<?= $dataProfil->KetPembayaran ?>" placeholder="Input Keterangan" disabled>
												  	</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label"></label>
		                        					<div class="col-sm-10">
		                          						<button type="button" onclick="simpan('dataMhsw')" class="btn btn btn-success fa fa-save"> Simpan</button>
		                          						<button type="reset" class="btn btn btn-danger fa fa-refresh"> Reset</button>
		                        					</div>
		                      					</div>
		                    				</form>
		                  				</div>
		                  				<!-- /.col -->
		                			</div>
		                			<!-- /.row -->
		              			</div>
		            		</div>    
		            		<!-- /.tab-pane -->

		            		<div class="tab-pane" id="dataOrtuMhsw">
		              			<div class="box-body">
		                			<div class="row">
		                  				<div class="col-12">
		                  					<form action="" method="POST">
				                    			<div class="form-group row">
				                      				<label for="example-text-input" class="col-sm-2 col-form-label">Nama Bapak</label>
				                      				<div class="col-sm-10">
				                        				<input class="form-control" type="text" name="bapak" value="<?= $dataProfil->NamaOT ?>" id="bapak" />
				                      				</div>
				                    			</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-2 col-form-label">Nama Ibu</label>
		                      						<div class="col-sm-10">
		                        						<input class="form-control" type="text" name="ibu" value="<?= $dataProfil->NamaIbu ?>" id="ibu" / readonly>
		                      						</div>
		                    					</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-2 col-form-label"></label>
		                      						<div class="col-sm-10">
		                       	 						<button type="button" onclick="simpan('dataOrtu')" class="btn btn btn-success fa fa-save"> Simpan</button>
		                        						<button type="reset" class="btn btn btn-danger fa fa-refresh"> Reset</button>
		                      						</div>
		                    					</div>
		                    				</form>
		                  				</div>
		                  				<!-- /.col -->
		                			</div>
		                			<!-- /.row -->
		              			</div>
		            		</div>    
		            		<!-- /.tab-pane -->
		          		</div>
		          		<!-- /.tab-content -->
		        	</div>
		        	<!-- /.nav-tabs-custom -->
		      	</div>
		      	<!-- /.col -->
		    </div>
		    <!-- /.row -->

		</section>
	  	<!-- /.content -->
	<?php } ?>  	

</div>


<script src="<?=base_url()?>assets/js/pages/data-table.js"></script>

<script type='text/javascript'>
 	var i = setInterval(function() {
	if ($) {
		clearInterval(i);

		$(function(){
			<?php
				if(isset($success)){
					echo "
						swal({   
								title: 'Success !',   
								type: 'success',    
								html: true, 
								text: '".$success."',
								confirmButtonColor: 'green',   
							});
					";
				}
				if(isset($error)){
					echo "
						swal({   
								title: 'Error !',   
								type: 'error',    
								html: true, 
								text: ".$error.",
								confirmButtonColor: '#f7cb3b',   
							});
					";
				}
			?>

			function aktif_kecamatan() {

				var kode = $('#negara').val();
				$("#kecamatan").find('option').remove();
				$.ajax({
		            url : "<?php echo base_url();?>ademik/Mhsw/get_wilayah",
		            method : "POST",
		            data : {kode: kode},
		            async : false,
		            dataType : 'json',
		            success: function(data){ 
						for (var i = 0; i <= data.length; i++) {
							var kode = data[i].id;
							var nama = data[i].nama_wilayah;
							
							//console.log(kode+" "+nama);
							$("#kecamatan").append("<option value='"+kode+"'>"+nama+" </option>");
						}
						//console.log(msg.data);
					},
					error: function(err){
						//console.log(err);
					}
		        });

			}
	        $('#negara').change(function(){
	            var kode=$(this).val();
	            $.ajax({
	                url : "<?php echo base_url();?>ademik/Mhsw/get_wilayah",
	                method : "POST",
	                data : {kode: kode},
	                async : false,
	                dataType : 'json',
	                success: function(data){
	                	console.log(data);
	                    var html = '';
	                    var i;
	                    for(i=0; i<data.length; i++){
	                        html += '<option value="'+data[i].id+'">'+data[i].nama_wilayah+'</option>';
	                    }
	                    $('.kecamatan').html(html);
	                     
	                }
	            });
	        });
 
 			function simpan(act) { 

				var id = $('#id').val();

				if ( act == 'dataMhsw' ) {

					var pd = $(#pd).val();
					var regpd = $(#regpd).val();
					var nama = $('#nama').val();
				    var tmpLahir = $('#tmpLahir').val();
				    var tglLahir = $('#tglLahir').val();
				    var agama = $('#agama').val();
				    var ibu = $('#ibu').val();
				    var nik = $('#nik').val();
				    var nisn = $('#nisn').val();
				    var npwp = $('#npwp').val();
				    var alamat = $('#alamat').val();
				    var negara = $('#negara').val();
				    var dusun = $('#dusun').val();
				    var rt = $('#rt').val();
				    var rw = $('#rw').val();
				    var kodepos = $('#kodepos').val();
				    var kelurahan = $('#kelurahan').val();
				    var kecamatan = $('#kecamatan').val();
				    var jnsTinggal = $('#jnsTinggal').val();
				    var alatTrans = $('#alatTrans').val();
				    var telepon = $('#telepon').val();
				    var hp = $('#hp').val();
				    var email = $('#email').val();
				    var noKPS = $('#noKPS').val();
				    var bayarSPP = $('#bayarSPP').val();
				    var ketSPP = $('#ketSPP').val();

				    var radiosSex = document.getElementsByName('sex');

				    for ( var i=0, length = radiosSex.length; i<length; i++ ) {
				    	if (radiosSex[i].checked) {
				        	var sex = radiosSex[i].value;
				        	break;
				      	}
				    }

				    var radiosKPS = document.getElementsByName('kps');

				    for ( var i=0, length = radiosKPS.length; i<length; i++ ) {
				    	if (radiosKPS[i].checked) {
				        	var kps = radiosKPS[i].value;
				        	break;
				      	}
				    }

				    var data = 'id='+id+'&pd='+pd+'&regpd='+regpd+'&nama='+nama+'&tmpLahir='+tmpLahir+'&tglLahir='+tglLahir+'&sex='+sex+'&agama='+agama+'&ibu='+ibu+'&nik='+nik+'&nisn='+nisn+'&npwp='+npwp+'&alamat='+alamat+'&negara='+negara+'&dusun='+dusun+'&rt='+rt+'&rw='+rw+'&kodepos='+kodepos+'&kelurahan='+kelurahan+'&kecamatan='+kecamatan+'&jnsTinggal='+jnsTinggal+'&alatTrans='+alatTrans+'&telepon='+telepon+'&hp='+hp+'&email='+email+'&kps='+kps+'&noKPS='+noKPS+'&bayarSPP='+bayarSPP+'&ketSPP='+ketSPP;

				    alert(data);

				    var url = "<?= base_url('ademik/profil/validasiDataMhsw'); ?>";

				} else if ( act == 'dataOrtu' ) {

				  	var bapak = $('#bapak').val();
				  	var ibu = $('#ibu').val();

				  	var data = 'id='+id+'&bapak='+bapak+'&ibu='+ibu;

				  	var url = "<?= base_url('ademik/profil/validasiDataOrtuMhsw'); ?>";

				} else if ( act == 'dataPass' ) {

				  	var passLama = $('#passLama').val();
				  	var passBaru = $('#passBaru').val();
				  	var ulangPass = $('#ulangPass').val();

				  	var data = 'id='+id+'&passLama='+passLama+'&passBaru='+passBaru+'&ulangPass='+ulangPass;

				  	var url = "<?= base_url('ademik/profil/validasiDataPass'); ?>";

				} else if ( act == 'dataDosen' ) {

					var nik = $('#nik').val();
					var npwp = $('#npwp').val();
					var namaAsli = $('#namaAsli').val();
					var gelarDpn = $('#gelarDpn').val();
					var gelarBlk = $('#gelarBlk').val();
				    var tmpLahir = $('#tmpLahir').val();
				    var tglLahir = $('#tglLahir').val();
				    var agama = $('#agama').val();
				    var alamat = $('#alamat').val();
				    var rt = $('#rt').val();
				    var rw = $('#rw').val();
				    var kelurahan = $('#kelurahan').val();
				    var kecamatan = $('#kecamatan').val();
				    var telepon = $('#telepon').val();
				    var hp = $('#hp').val();
				    var email = $('#email').val();

				    var radiosSex = document.getElementsByName('sex');

				    for ( var i=0, length = radiosSex.length; i<length; i++ ) {
				    	if (radiosSex[i].checked) {
				        	var sex = radiosSex[i].value;
				        	break;
				      	}
				    }

				    var data = 'id='+id+'&nik='+nik+'&npwp='+npwp+'&namaAsli='+namaAsli+'&gelarDpn='+gelarDpn+'&gelarBlk='+gelarBlk+'&tmpLahir='+tmpLahir+'&tglLahir='+tglLahir+'&agama='+agama+'&alamat='+alamat+'&rt='+rt+'&rw='+rw+'&kelurahan='+kelurahan+'&kecamatan='+kecamatan+'&telepon='+telepon+'&hp='+hp+'&email='+email+'&warga='+warga+'&sex='+sex;

				    var url = "<?= base_url('ademik/profil/validasiDataDosen'); ?>";

				} else if ( act == 'dataDosenPegawai' ) {

					var nip = $('#nip').val();
				  	var nidn = $('#nidn').val();

				  	var data = 'id='+id+'&nip='+nip+'&nidn='+nidn;

				  	var url = "<?= base_url('ademik/profil/validasiDataDosenPegawai'); ?>";

				} else if ( act == 'dataOrtuDosen' ) {

				  	var bapak = $('#bapak').val();
				  	var ibu = $('#ibu').val();

				  	var data = 'id='+id+'&bapak='+bapak+'&ibu='+ibu;

				  	var url = "<?= base_url('ademik/profil/validasiDataOrtuDosen'); ?>";

				} else if ( act == 'dataAdmJurusan' ) {

					var nama = $('#nama').val();
				    var tmpLahir = $('#tmpLahir').val();
				    var tglLahir = $('#tglLahir').val();
				    var agama = $('#agama').val();
				    var alamat = $('#alamat').val();
				    var telepon = $('#telepon').val();
				    var hp = $('#hp').val();
				    var email = $('#email').val();

				    var radiosSex = document.getElementsByName('sex');

				    for ( var i=0, length = radiosSex.length; i<length; i++ ) {
				    	if (radiosSex[i].checked) {
				        	var sex = radiosSex[i].value;
				        	break;
				      	}
				    }

				    var data = 'id='+id+'&nama='+nama+'&tmpLahir='+tmpLahir+'&tglLahir='+tglLahir+'&agama='+agama+'&alamat='+alamat+'&telepon='+telepon+'&hp='+hp+'&email='+email+'&sex='+sex;

				    var url = "<?= base_url('ademik/profil/validasiDataAdmJurusan'); ?>";

				} else if ( act == 'dataAdmFakultas' ) {

					var nama = $('#nama').val();
				    var tmpLahir = $('#tmpLahir').val();
				    var tglLahir = $('#tglLahir').val();
				    var agama = $('#agama').val();
				    var alamat = $('#alamat').val();
				    var telepon = $('#telepon').val();
				    var hp = $('#hp').val();
				    var email = $('#email').val();

				    var radiosSex = document.getElementsByName('sex');

				    for ( var i=0, length = radiosSex.length; i<length; i++ ) {
				    	if (radiosSex[i].checked) {
				        	var sex = radiosSex[i].value;
				        	break;
				      	}
				    }

				    var data = 'id='+id+'&nama='+nama+'&tmpLahir='+tmpLahir+'&tglLahir='+tglLahir+'&agama='+agama+'&alamat='+alamat+'&telepon='+telepon+'&hp='+hp+'&email='+email+'&sex='+sex;

				    var url = "<?= base_url('ademik/profil/validasiDataAdmFakultas'); ?>";

				} else if ( act == 'dataAdmSuperuser' ) {

					var nama = $('#nama').val();
				    var telepon = $('#telepon').val();
				    var email = $('#email').val();

				    var radiosSex = document.getElementsByName('sex');

				    for ( var i=0, length = radiosSex.length; i<length; i++ ) {
				    	if (radiosSex[i].checked) {
				        	var sex = radiosSex[i].value;
				        	break;
				      	}
				    }

				    var data = 'id='+id+'&nama='+nama+'&telepon='+telepon+'&email='+email+'&sex='+sex;

				    var url = "<?= base_url('ademik/profil/validasiDataAdmSuperuser'); ?>";

				}

				$body = $("body");
				$body.addClass("loading");

				$.ajax({
				    url: url,
				    data: data,
				    type: 'POST',
				    dataType: 'json',
				    cache : false,
				    success: function(respon){
				      	$body.removeClass("loading");

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

			function delete_disable() {

				if ( $('#bayarSPP').val() != 'Reguler' ) {

					$('#ketSPP').removeAttr('disabled');

				} else {

					$('#ketSPP').attr('disabled', true);

				}

			}

			function open_noKPS() {

				var radiosKPS = document.getElementsByName('kps');

			    for ( var i=0, length = radiosKPS.length; i<length; i++ ) {
			    	if (radiosKPS[i].checked) {
			        	var kps = radiosKPS[i].value;
			        	break;
			      	}
			    }

			    if ( kps > 0 ) {

					$('#noKPS').removeAttr('disabled');

				} else {

					$('#noKPS').attr('disabled', true);

				}

			}

		}
	}, 100);

</script>