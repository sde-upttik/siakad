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

<?php if ( $level == 4 ) { 
	$nama= str_replace("\'", "'", $dataProfil->Name);
	$ibu= str_replace("\'", "'", $dataProfil->NamaIbu);
?>

	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
	  	<section class="content-header">
	    	<h1>
	      		Profil Mahasiswa
	    	</h1>
	    	<ol class="breadcrumb">
	      		<li class="breadcrumb-item"><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
	      		<li class="breadcrumb-item active">Profil Mahasiswa</li>
	    	</ol>
	  	</section>

	  	<!-- Main content -->
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

	            			<h3 class="profile-username text-center"><?= $nama ?></h3>
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
		            		<li><a href="#akademik" data-toggle="tab">Akademik</a></li>
		            		<!-- <li><a href="#settings" data-toggle="tab">Data Orang Tua Wali</a></li>
		            		<li><a href="#settings" data-toggle="tab">Akademik</a></li>
		            		<li><a href="#settings" data-toggle="tab">Asal Sekolah</a></li>
		            		 -->
		            		 <li><a href="#gantiPassMhsw" data-toggle="tab">Ganti Password</a></li>
		          		</ul>              
		          		<div class="tab-content">
		            		<div class="active tab-pane" id="dataMhsw">
		            			<div class="box-body">
		                			<div class="row">
		                  				<div class="col-12">
		                    				<form action="" method="POST">
		                    					<div class="form-group row">
		  				              				<label for="example-text-input" class="col-sm-2 col-form-label">Nama</label>
		  				              				<div class="col-sm-5">
		                          						<input class="form-control" type="text" name="nama" value="<?= $nama ?>" id="nama" readonly />
		                          						<input class="form-control" type="hidden" name="fakultas" value="<?= $dataProfil->KodeFakultas ?>" id="fakultas" readonly />
		  				              				</div>
		  				              				<div class="col-sm-5">
		                        						<span style="font-size: 11px;"><i>*( Nama disesuai dengan Nama di Ijazah Terakhir, Jika Nama Salah Silakan Melapor Ke Admin Fakultas )</i></span>
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
		                            						<input type="text" name="tglLahir" id="tglLahir" value="<?= date('d-m-Y',strtotime( $dataProfil->TglLahir )) ?>" class="form-control datepicker" readonly />
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
		                        						<input class="form-control" type="text" name="ibu" value="<?= $ibu ?>" id="ibu" <?= ( empty($dataProfil->id_pd) ) ? '' : 'readonly'; ?> />
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
		                    		  					<select class="form-control select2" name="negara" style="width: 100%;" id="negara" onchange="aktif_kecamatan()" />

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

		                            						<?php } foreach ($dataWilayah as $pilih) {

		                              							echo "<option value='".$pilih->id."'>".$pilih->nama_wilayah."</option>";

		                            						} ?>

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
		                      						<label for="example-text-input" class="col-sm-4 col-form-label">Periode Awal Masuk</label>
		                        					<div class="col-sm-2">
		                          						<input class="form-control" type="hidden" name="awalMasuk" value="<?= $dataProfil->Semester ?>" id="awalMasuk" />
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
		                        						<input class="form-control" type="text" name="ibu" value="<?= $ibu ?>" id="ibu" / readonly>
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

		            		<div class="tab-pane" id="akademik">
		              			<div class="box-body">
		                			<div class="row">
		                  				<div class="col-12">
		                  					<form action="" method="POST">
		                  						<div class="form-group row">
				                      				<label for="example-text-input" class="col-sm-2 col-form-label">Angkatan</label>
				                      				<div class="col-sm-2">
				                        				<input class="form-control" type="text" value="<?= $dataProfil->TahunAkademik ?>" readonly />
				                      				</div>
				                    			</div>

				                  				<?php if ( $dataProfil->KodeFakultas == 'A') { ?>

				                  					<div class="form-group row">
					                      				<label for="example-text-input" class="col-sm-2 col-form-label">Dosen Wali</label>
					                      				<div class="col-sm-9">
					                        				<select class="form-control select2" name="dosenWali" style="width: 100%;" id="dosenWali" />

			                    		  						<?php if ( empty($dataProfil->DosenID) ) { ?>

			                              							<option value="">--Pilih Dosen Wali--</option>

			                            						<?php } else { ?>

			                              							<option value="<?= $dataProfil->nip ?>"><?= $dataProfil->nip ?> -- <?= $dataProfil->dosen ?></option>

			                            						<?php } foreach ($dataDosen as $pilih) {

			                              							echo "<option value='".$pilih->nip."'>".$pilih->nip." -- ".$pilih->Name."</option>";

			                            						} ?>

			                          						</select>
					                      				</div>
					                    			</div>
					                    			<div class="form-group row">
			                      						<label for="example-text-input" class="col-sm-2 col-form-label"></label>
			                      						<div class="col-sm-10">
			                       	 						<button type="button" onclick="simpan('dataAkademik')" class="btn btn btn-success fa fa-save"> Simpan</button>
			                        						<button type="reset" class="btn btn btn-danger fa fa-refresh"> Reset</button>
			                      						</div>
			                    					</div>

				                  				<?php } else { ?>

					                    			<div class="form-group row">
					                      				<label for="example-text-input" class="col-sm-2 col-form-label">Dosen Wali</label>
					                      				<div class="col-sm-9">
					                      					<input class="form-control" type="text" value="<?= $dataProfil->nip ?> -- <?= $dataProfil->dosen ?>" readonly />
					                      				</div>
					                    			</div>

					                    		<?php } ?>

		                    				</form>
		                  				</div>
		                  				<!-- /.col -->
		                			</div>
		                			<!-- /.row -->
		              			</div>
		            		</div>    
		            		<!-- /.tab-pane -->

		            		<div class="tab-pane" id="gantiPassMhsw">
		              			<div class="box-body">
		                			<div class="row">
		                  				<div class="col-12">
		                  					<form action="" method="POST">
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label">Password Lama</label>
		                      						<div class="col-sm-9">
		                        						<input class="form-control" type="Password" name="passLama" value="" id="passLama" />
		                      						</div>
		                    					</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label">Password Baru</label>
		                      						<div class="col-sm-9">
		                        						<input class="form-control" type="Password" name="passBaru" value="" id="passBaru" />
		                      						</div>
		                    					</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label">Ulang Password Baru</label>
		                      						<div class="col-sm-9">
		                        						<input class="form-control" type="Password" name="ulangPass" value="" id="ulangPass" />
		                      						</div>
		                    					</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label"></label>
		                      						<div class="col-sm-9">
		                        						<button type="button" onclick="simpan('dataPass')" class="btn btn btn-success fa fa-save"> Simpan</button>
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
	</div>
	<!-- /.content-wrapper -->

<?php } elseif ( $level == 3 ) { ?>

	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
	  	<section class="content-header">
	    	<h1>
	      		Profil Dosen
	    	</h1>
	    	<ol class="breadcrumb">
	      		<li class="breadcrumb-item"><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
	      		<li class="breadcrumb-item active">Profil Dosen</li>
	    	</ol>
	  	</section>

	  	<!-- Main content -->
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

	            			<h3 class="profile-username text-center"><?= $dataProfil->Name ?></h3>
	            			<h5 class="profile-username text-center"><?= $dataProfil->nip ?></h5>
	            			<p class="text-muted text-center"><?= $dataProfil->jurusan ?></p>

	            			<div class="row">
	              				<div class="col-12">
	              					<div class="profile-user-info">
							      		<p>Email</p>
							      		<h6 class="margin-bottom"><?= ( empty($dataProfil->Email) ) ? '-' : $dataProfil->Email ?></h6>
							      		<p>No. Telepon</p>
							      		<h6 class="margin-bottom"><?= ( empty($dataProfil->Phone) ) ? '-' : $dataProfil->Phone ?></h6>
							      		<p>No. HP</p>
							      		<h6 class="margin-bottom"><?= ( empty($dataProfil->Hp) ) ? '-' : $dataProfil->Hp ?></h6>
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
		            		<li><a class="active" href="#dataDosen" data-toggle="tab">Data Pribadi</a></li>
		            		<li><a href="#dataPegawaiDosen" data-toggle="tab">Data Pegawai</a></li>
		            		<li><a href="#dataOrtuDosen" data-toggle="tab">Data Orang Tua</a></li><!--
		            		<li><a href="#settings" data-toggle="tab">Data Keluarga</a></li>
		            		<li><a href="#settings" data-toggle="tab">Akademik</a></li>
		            		<li><a href="#settings" data-toggle="tab">Asal Sekolah</a></li> -->
		            		<li><a href="#gantiPassDosen" data-toggle="tab">Ganti Password</a></li>
		          		</ul>
		          		<div class="tab-content">

		            		<div class="active tab-pane" id="dataDosen">
		            			<div class="box-body">
		                			<div class="row">
		                  				<div class="col-12">
		                    				<form action="" method="POST">
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">NIK</label>
		                        					<div class="col-sm-10">
		                        						<input class="form-control" type="hidden" name="id" value="<?= $dataProfil->ID ?>" id="id" readonly />
		                          						<input class="form-control" type="text" name="nik" value="<?= $dataProfil->NIK ?>" id="nik" />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">NPWP</label>
		                        					<div class="col-sm-10">
		                          						<input class="form-control" type="text" name="npwp" value="<?= $dataProfil->NPWP ?>" id="npwp" />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		  				              				<label for="example-text-input" class="col-sm-2 col-form-label">Nama Tanpa Gelar</label>
		  				              				<div class="col-sm-10">
		                          						<input class="form-control" type="text" name="namaAsli" value="<?= $dataProfil->nama_asli ?>" id="namaAsli" />
		  				              				</div>
		  				            			</div>
		  				            			<div class="form-group row">
		  				              				<label for="example-text-input" class="col-sm-2 col-form-label">Gelar Depan</label>
		  				              				<div class="col-sm-4">
		                          						<input class="form-control" type="text" name="gelarDpn" value="<?= $dataProfil->glr_depan ?>" id="gelarDpn" />
		  				              				</div>
		  				              				<label for="example-text-input" class="col-sm-2 col-form-label">Gelar Belakang</label>
		  				              				<div class="col-sm-4">
		                          						<input class="form-control" type="text" name="gelarBlk" value="<?= $dataProfil->glr_belakang ?>" id="gelarBlk" />
		  				              				</div>
		  				            			</div>
		    				          			<div class="form-group row">
		    				            			<label for="example-text-input" class="col-sm-2 col-form-label">Tempat Lahir</label>
		    				            			<div class="col-sm-5">
		                         						<input class="form-control" type="text" name="tmpLahir" value="<?= $dataProfil->TempatLahir ?>" id="tmpLahir" />
		    				            			</div>
		    				            			<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Lahir</label>
		    				            			<div class="col-sm-3">
		    				              				<div class="input-group">
		                            						<div class="input-group-addon">
		                              							<i class="fa fa-calendar"></i>
		                            						</div>
		                            						<input type="text" name="tglLahir" id="tglLahir" value="<?= date('d-m-Y',strtotime( $dataProfil->TglLahir )) ?>" class="form-control datepicker" />
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
		                    		  					<select class="form-control select2" name="agama" style="width: 30%;" id="agama" />

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
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">Alamat</label>
		                        					<div class="col-sm-10">
		                          						<input class="form-control" type="textarea" name="alamat" value="<?= $dataProfil->Alamat ?>" id="alamat" />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">RT</label>
		                        					<div class="col-sm-4">
		                          						<input class="form-control" type="text" name="rt" value="<?= $dataProfil->RT ?>" id="rt" />
		                        					</div>
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">RW</label>
		                        					<div class="col-sm-4">
		                          						<input class="form-control" type="text" name="rw" value="<?= $dataProfil->RW ?>" id="rw" />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">Kelurahan</label>
		                        					<div class="col-sm-10">
		                          						<input class="form-control" type="text" name="kelurahan" value="<?= $dataProfil->Kelurahan ?>" id="kelurahan" />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">Kecamatan</label>
		                        					<div class="col-sm-10">
		                          						<input class="form-control" type="text" name="kecamatan" value="<?= $dataProfil->Kecamatan ?>" id="kecamatan" />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-tel-input" class="col-sm-2 col-form-label">Telepon</label>
		                        					<div class="col-sm-4">
		                          						<input class="form-control" type="tel" name="telepon" value="<?= $dataProfil->Phone ?>" id="telepon" />
		                        					</div>
		                        					<label for="example-tel-input" class="col-sm-2 col-form-label">HP</label>
		                        					<div class="col-sm-4">
		                          						<input class="form-control" type="tel" name="hp" value="<?= $dataProfil->Hp ?>" id="hp" />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
		                        					<div class="col-sm-10">
		                          						<input class="form-control" type="email" name="email" value="<?= $dataProfil->Email ?>" id="email" />
		                        					</div>
		                     					</div>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label"></label>
		                        					<div class="col-sm-10">
		                          						<button type="button" onclick="simpan('dataDosen')" class="btn btn btn-success fa fa-save"> Simpan</button>
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

		            		<div class="tab-pane" id="dataPegawaiDosen">
		              			<div class="box-body">
		                			<div class="row">
		                  				<div class="col-12">
		                  					<form action="" method="POST">
				                    			<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">NIP/NIDN/NUP/NIDK</label>
		                        					<div class="col-sm-10">
		                          						<input class="form-control" type="text" name="nip" value="<?= $dataProfil->nip ?>" id="nip" />
		                        					</div>
		                      					</div>
		                    					<div class="form-group row">
		                        					<!-- <label for="example-text-input" class="col-sm-2 col-form-label">NIDN/NUP/NIDK</label> -->
		                        					<div class="col-sm-10">
		                          						<input class="form-control" type="hidden" name="nidn" value="<?= $dataProfil->NIDN_NUP_NIDK ?>" id="nidn" />
		                        					</div>
		                      					</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-2 col-form-label"></label>
		                      						<div class="col-sm-10">
		                       	 						<button type="button" onclick="simpan('dataDosenPegawai')" class="btn btn btn-success fa fa-save"> Simpan</button>
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

		            		<div class="tab-pane" id="dataOrtuDosen">
		              			<div class="box-body">
		                			<div class="row">
		                  				<div class="col-12">
		                  					<form action="" method="POST">
				                    			<div class="form-group row">
				                      				<label for="example-text-input" class="col-sm-2 col-form-label">Nama Bapak</label>
				                      				<div class="col-sm-10">
				                        				<input class="form-control" type="text" name="bapak" value="<?= $dataProfil->NamaBapak ?>" id="bapak" />
				                      				</div>
				                    			</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-2 col-form-label">Nama Ibu</label>
		                      						<div class="col-sm-10">
		                        						<input class="form-control" type="text" name="ibu" value="<?= $dataProfil->NamaIbu ?>" id="ibu" />
		                      						</div>
		                    					</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-2 col-form-label"></label>
		                      						<div class="col-sm-10">
		                       	 						<button type="button" onclick="simpan('dataOrtuDosen')" class="btn btn btn-success fa fa-save"> Simpan</button>
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

		            		<div class="tab-pane" id="gantiPassDosen">
		              			<div class="box-body">
		                			<div class="row">
		                  				<div class="col-12">
		                  					<form action="" method="POST">
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label">Password Lama</label>
		                      						<div class="col-sm-9">
		                        						<input class="form-control" type="Password" name="passLama" value="" id="passLama" />
		                      						</div>
		                    					</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label">Password Baru</label>
		                      						<div class="col-sm-9">
		                        						<input class="form-control" type="Password" name="passBaru" value="" id="passBaru" />
		                      						</div>
		                    					</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label">Ulang Password Baru</label>
		                      						<div class="col-sm-9">
		                        						<input class="form-control" type="Password" name="ulangPass" value="" id="ulangPass" />
		                      						</div>
		                    					</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label"></label>
		                      						<div class="col-sm-9">
		                        						<button type="button" onclick="simpan('dataPass')" class="btn btn btn-success fa fa-save"> Simpan</button>
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
	</div>
	<!-- /.content-wrapper -->
<?php } elseif ( $level == 7 ) { ?>

	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
	  	<section class="content-header">
	    	<h1>
	      		Profil Admin Jurusan
	    	</h1>
	    	<ol class="breadcrumb">
	      		<li class="breadcrumb-item"><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
	      		<li class="breadcrumb-item active">Profil Admin Jurusan</li>
	    	</ol>
	  	</section>

	  	<!-- Main content -->
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

	            			<h3 class="profile-username text-center"><?= $dataProfil->Name ?></h3>
	            			<h5 class="profile-username text-center"><?= $dataProfil->fakultas ?></h5>
	            			<p class="text-muted text-center"><?= $dataProfil->jurusan ?></p>

	            			<div class="row">
	              				<div class="col-12">
	              					<div class="profile-user-info">
							      		<p>Email</p>
							      		<h6 class="margin-bottom"><?= ( empty($dataProfil->Email) ) ? '-' : $dataProfil->Email ?></h6>
							      		<p>No. Telepon</p>
							      		<h6 class="margin-bottom"><?= ( empty($dataProfil->Phone) ) ? '-' : $dataProfil->Phone ?></h6>
							      		<p>No. HP</p>
							      		<h6 class="margin-bottom"><?= ( empty($dataProfil->Hp) ) ? '-' : $dataProfil->Hp ?></h6>
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
		            		<li><a class="active" href="#dataAdmJurusan" data-toggle="tab">Data Pribadi</a></li>
		            		<li><a href="#gantiPassAdmJurusan" data-toggle="tab">Ganti Password</a></li>
		          		</ul>
		          		<div class="tab-content">

		            		<div class="active tab-pane" id="dataAdmJurusan">
		            			<div class="box-body">
		                			<div class="row">
		                  				<div class="col-12">
		                    				<form action="" method="POST">
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">Nama Lengkap</label>
		                        					<div class="col-sm-10">
		                        						<input class="form-control" type="hidden" name="id" value="<?= $dataProfil->ID ?>" id="id" readonly />
		                          						<input class="form-control" type="text" name="nama" value="<?= $dataProfil->Name ?>" id="nama" />
		                        					</div>
		                      					</div>
		    				          			<div class="form-group row">
		    				            			<label for="example-text-input" class="col-sm-2 col-form-label">Tempat Lahir</label>
		    				            			<div class="col-sm-5">
		                         						<input class="form-control" type="text" name="tmpLahir" value="<?= $dataProfil->TempatLahir ?>" id="tmpLahir" />
		    				            			</div>
		    				            			<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Lahir</label>
		    				            			<div class="col-sm-3">
		    				              				<div class="input-group">
		                            						<div class="input-group-addon">
		                              							<i class="fa fa-calendar"></i>
		                            						</div>
		                            						<input type="text" name="tglLahir" id="tglLahir" value="<?= date('d-m-Y',strtotime( $dataProfil->TglLahir )) ?>" class="form-control datepicker" />
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
		                    		  					<select class="form-control select2" name="agama" style="width: 30%;" id="agama" />

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
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">Alamat</label>
		                        					<div class="col-sm-10">
		                          						<input class="form-control" type="textarea" name="alamat" value="<?= $dataProfil->Alamat ?>" id="alamat" />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-tel-input" class="col-sm-2 col-form-label">Telepon</label>
		                        					<div class="col-sm-4">
		                          						<input class="form-control" type="tel" name="telepon" value="<?= $dataProfil->Phone ?>" id="telepon" />
		                        					</div>
		                        					<label for="example-tel-input" class="col-sm-2 col-form-label">HP</label>
		                        					<div class="col-sm-4">
		                          						<input class="form-control" type="tel" name="hp" value="<?= $dataProfil->Hp ?>" id="hp" />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
		                        					<div class="col-sm-10">
		                          						<input class="form-control" type="email" name="email" value="<?= $dataProfil->Email ?>" id="email" />
		                        					</div>
		                     					</div>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label"></label>
		                        					<div class="col-sm-10">
		                          						<button type="button" onclick="simpan('dataAdmJurusan')" class="btn btn btn-success fa fa-save"> Simpan</button>
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

		            		<div class="tab-pane" id="gantiPassAdmJurusan">
		              			<div class="box-body">
		                			<div class="row">
		                  				<div class="col-12">
		                  					<form action="" method="POST">
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label">Password Lama</label>
		                      						<div class="col-sm-9">
		                        						<input class="form-control" type="Password" name="passLama" value="" id="passLama" />
		                      						</div>
		                    					</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label">Password Baru</label>
		                      						<div class="col-sm-9">
		                        						<input class="form-control" type="Password" name="passBaru" value="" id="passBaru" />
		                      						</div>
		                    					</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label">Ulang Password Baru</label>
		                      						<div class="col-sm-9">
		                        						<input class="form-control" type="Password" name="ulangPass" value="" id="ulangPass" />
		                      						</div>
		                    					</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label"></label>
		                      						<div class="col-sm-9">
		                        						<button type="button" onclick="simpan('dataPass')" class="btn btn btn-success fa fa-save"> Simpan</button>
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
	</div>
	<!-- /.content-wrapper -->

<?php } elseif ( $level == 5 ) { ?>

	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
	  	<section class="content-header">
	    	<h1>
	      		Profil Admin Fakultas
	    	</h1>
	    	<ol class="breadcrumb">
	      		<li class="breadcrumb-item"><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
	      		<li class="breadcrumb-item active">Profil Admin Fakultas</li>
	    	</ol>
	  	</section>

	  	<!-- Main content -->
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

	            			<h3 class="profile-username text-center"><?= $dataProfil->Name ?></h3>
	            			<p class="text-muted text-center"><?= $dataProfil->fakultas ?></p>

	            			<div class="row">
	              				<div class="col-12">
	              					<div class="profile-user-info">
							      		<p>Email</p>
							      		<h6 class="margin-bottom"><?= ( empty($dataProfil->Email) ) ? '-' : $dataProfil->Email ?></h6>
							      		<p>No. Telepon</p>
							      		<h6 class="margin-bottom"><?= ( empty($dataProfil->Phone) ) ? '-' : $dataProfil->Phone ?></h6>
							      		<p>No. HP</p>
							      		<h6 class="margin-bottom"><?= ( empty($dataProfil->Hp) ) ? '-' : $dataProfil->Hp ?></h6>
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
		            		<li><a class="active" href="#dataAdmFakultas" data-toggle="tab">Data Pribadi</a></li>
		            		<li><a href="#gantiPassAdmFakultas" data-toggle="tab">Ganti Password</a></li>
		          		</ul>
		          		<div class="tab-content">

		            		<div class="active tab-pane" id="dataAdmFakultas">
		            			<div class="box-body">
		                			<div class="row">
		                  				<div class="col-12">
		                    				<form action="" method="POST">
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">Nama Lengkap</label>
		                        					<div class="col-sm-10">
		                        						<input class="form-control" type="hidden" name="id" value="<?= $dataProfil->ID ?>" id="id" readonly />
		                          						<input class="form-control" type="text" name="nama" value="<?= $dataProfil->Name ?>" id="nama" />
		                        					</div>
		                      					</div>
		    				          			<div class="form-group row">
		    				            			<label for="example-text-input" class="col-sm-2 col-form-label">Tempat Lahir</label>
		    				            			<div class="col-sm-5">
		                         						<input class="form-control" type="text" name="tmpLahir" value="<?= $dataProfil->TempatLahir ?>" id="tmpLahir" />
		    				            			</div>
		    				            			<label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Lahir</label>
		    				            			<div class="col-sm-3">
		    				              				<div class="input-group">
		                            						<div class="input-group-addon">
		                              							<i class="fa fa-calendar"></i>
		                            						</div>
		                            						<input type="text" name="tglLahir" id="tglLahir" value="<?= date('d-m-Y',strtotime( $dataProfil->TglLahir )) ?>" class="form-control datepicker" />
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
		                    		  					<select class="form-control select2" name="agama" style="width: 30%;" id="agama" />

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
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">Alamat</label>
		                        					<div class="col-sm-10">
		                          						<input class="form-control" type="textarea" name="alamat" value="<?= $dataProfil->Alamat ?>" id="alamat" />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-tel-input" class="col-sm-2 col-form-label">Telepon</label>
		                        					<div class="col-sm-4">
		                          						<input class="form-control" type="tel" name="telepon" value="<?= $dataProfil->Phone ?>" id="telepon" />
		                        					</div>
		                        					<label for="example-tel-input" class="col-sm-2 col-form-label">HP</label>
		                        					<div class="col-sm-4">
		                          						<input class="form-control" type="tel" name="hp" value="<?= $dataProfil->Hp ?>" id="hp" />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
		                        					<div class="col-sm-10">
		                          						<input class="form-control" type="email" name="email" value="<?= $dataProfil->Email ?>" id="email" />
		                        					</div>
		                     					</div>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label"></label>
		                        					<div class="col-sm-10">
		                          						<button type="button" onclick="simpan('dataAdmFakultas')" class="btn btn btn-success fa fa-save"> Simpan</button>
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

		            		<div class="tab-pane" id="gantiPassAdmFakultas">
		              			<div class="box-body">
		                			<div class="row">
		                  				<div class="col-12">
		                  					<form action="" method="POST">
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label">Password Lama</label>
		                      						<div class="col-sm-9">
		                        						<input class="form-control" type="Password" name="passLama" value="" id="passLama" />
		                      						</div>
		                    					</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label">Password Baru</label>
		                      						<div class="col-sm-9">
		                        						<input class="form-control" type="Password" name="passBaru" value="" id="passBaru" />
		                      						</div>
		                    					</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label">Ulang Password Baru</label>
		                      						<div class="col-sm-9">
		                        						<input class="form-control" type="Password" name="ulangPass" value="" id="ulangPass" />
		                      						</div>
		                    					</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label"></label>
		                      						<div class="col-sm-9">
		                        						<button type="button" onclick="simpan('dataPass')" class="btn btn btn-success fa fa-save"> Simpan</button>
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
	</div>
	<!-- /.content-wrapper -->

<?php } elseif ( $level == 1 or $level == 6 ) { ?>

	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
	  	<section class="content-header">
	    	<h1>
	      		Profil Admin Superuser
	    	</h1>
	    	<ol class="breadcrumb">
	      		<li class="breadcrumb-item"><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
	      		<li class="breadcrumb-item active">Profil Admin Superuser</li>
	    	</ol>
	  	</section>

	  	<!-- Main content -->
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

	            			<button type="button" class="btn btn-sm btn-success fa fa-file-image-o" style="margin-left: 157px" data-toggle="modal" data-target="#modalUploadFoto"> Ganti</button>

	            			<h3 class="profile-username text-center"><?= $dataProfil->Name ?></h3>

	            			<div class="row">
	              				<div class="col-12">
	              					<div class="profile-user-info">
							      		<p>Email</p>
							      		<h6 class="margin-bottom"><?= ( empty($dataProfil->Email) ) ? '-' : $dataProfil->Email ?></h6>
							      		<p>No. Telepon</p>
							      		<h6 class="margin-bottom"><?= ( empty($dataProfil->Phone) ) ? '-' : $dataProfil->Phone ?></h6>
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
		            		<li><a class="active" href="#dataAdmSuperuser" data-toggle="tab">Data Pribadi</a></li>
		            		<li><a href="#gantiPassAdmSuperuser" data-toggle="tab">Ganti Password</a></li>
		          		</ul>
		          		<div class="tab-content">

		            		<div class="active tab-pane" id="dataAdmSuperuser">
		            			<div class="box-body">
		                			<div class="row">
		                  				<div class="col-12">
		                    				<form action="" method="POST">
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label">Nama Lengkap</label>
		                        					<div class="col-sm-10">
		                        						<input class="form-control" type="hidden" name="id" value="<?= $dataProfil->ID ?>" id="id" readonly />
		                          						<input class="form-control" type="text" name="nama" value="<?= $dataProfil->Name ?>" id="nama" />
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
		                        					<label for="example-tel-input" class="col-sm-2 col-form-label">Telepon</label>
		                        					<div class="col-sm-4">
		                          						<input class="form-control" type="tel" name="telepon" value="<?= $dataProfil->Phone ?>" id="telepon" />
		                        					</div>
		                      					</div>
		                      					<div class="form-group row">
		                        					<label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
		                        					<div class="col-sm-10">
		                          						<input class="form-control" type="email" name="email" value="<?= $dataProfil->Email ?>" id="email" />
		                        					</div>
		                     					</div>
		                      					<div class="form-group row">
		                        					<label for="example-text-input" class="col-sm-2 col-form-label"></label>
		                        					<div class="col-sm-10">
		                          						<button type="button" onclick="simpan('dataAdmSuperuser')" class="btn btn btn-success fa fa-save"> Simpan</button>
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

		            		<div class="tab-pane" id="gantiPassAdmSuperuser">
		              			<div class="box-body">
		                			<div class="row">
		                  				<div class="col-12">
		                  					<form action="" method="POST">
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label">Password Lama</label>
		                      						<div class="col-sm-9">
		                        						<input class="form-control" type="Password" name="passLama" value="" id="passLama" />
		                      						</div>
		                    					</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label">Password Baru</label>
		                      						<div class="col-sm-9">
		                        						<input class="form-control" type="Password" name="passBaru" value="" id="passBaru" />
		                      						</div>
		                    					</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label">Ulang Password Baru</label>
		                      						<div class="col-sm-9">
		                        						<input class="form-control" type="Password" name="ulangPass" value="" id="ulangPass" />
		                      						</div>
		                    					</div>
		                    					<div class="form-group row">
		                      						<label for="example-text-input" class="col-sm-3 col-form-label"></label>
		                      						<div class="col-sm-9">
		                        						<button type="button" onclick="simpan('dataPass')" class="btn btn btn-success fa fa-save"> Simpan</button>
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
	</div>
	<!-- /.content-wrapper -->

<?php } ?>

<!--modalNew-->
<div class="modal modal-primary fade" id="modalUploadFoto">
  	<div class="modal-dialog">
	  	<form action="#" method="POST"/>
		  	<div class="modal-content">
			    <div class="modal-header">
				    <h4 class="modal-title">Upload Foto</h4>
				    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				      <span aria-hidden="true">&times;</span></button>
			    </div>
			    <div class="modal-body">
			    <!--<p>One fine body&hellip;</p>-->
				    <label style="margin-bottom: 0px;">Pilih Foto</label>
				    <div class="form-group">
				    	<input class="form-control" type="hidden" name="user" value="<?= $this->session->userdata('unip') ?>" id="user" readonly />
				      	<input type="file" class="form-control" name="namaFoto" id="namaFoto" placeholder="Input Tahun Kurikulum" value="">
				    </div>
			    <div class="modal-footer">
				    <button type="button" class="btn btn-outline" data-dismiss="modal">Tutup</button>
				    <input type="button" onclick="uploadFoto('mhsw')" class="btn btn-outline float-right" name="addmodul_btn" value="Simpan"/>
				    <input type="reset" class="btn btn-outline float-right" name="addmodul_btn" value="Reset"/>
			    </div>
		  	</div>
	  	</form>
  		<!-- /.modal-content -->
  	</div>
  	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">

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

				$('#negara').change(function(){
	                var kode=$(this).val();
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
	            });

			});
		}
	}, 100);

	function simpan(act) { 

		var id = $('#id').val();

		if ( act == 'dataMhsw' ) {

			var pd = $('#pd').val();
			var regpd = $('#regpd').val();
			var nama = $('#nama').val();
			var fakultas = $('#fakultas');
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
		    var awalMasuk = $('#awalMasuk').val();
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

		    var data = 'id='+id+'&pd='+pd+'&regpd='+regpd+'&nama='+nama+'&fakultas='+fakultas+'&tmpLahir='+tmpLahir+'&tglLahir='+tglLahir+'&sex='+sex+'&agama='+agama+'&ibu='+ibu+'&nik='+nik+'&nisn='+nisn+'&npwp='+npwp+'&alamat='+alamat+'&negara='+negara+'&dusun='+dusun+'&rt='+rt+'&rw='+rw+'&kodepos='+kodepos+'&kelurahan='+kelurahan+'&kecamatan='+kecamatan+'&jnsTinggal='+jnsTinggal+'&alatTrans='+alatTrans+'&telepon='+telepon+'&hp='+hp+'&email='+email+'&kps='+kps+'&noKPS='+noKPS+'&awalMasuk='+awalMasuk+'&bayarSPP='+bayarSPP+'&ketSPP='+ketSPP;

		    var url = "<?= base_url('ademik/profil/validasiDataMhsw'); ?>";

		} else if ( act == 'dataOrtu' ) {

		  	var bapak = $('#bapak').val();
		  	var ibu = $('#ibu').val();

		  	var data = 'id='+id+'&bapak='+bapak+'&ibu='+ibu;

		  	var url = "<?= base_url('ademik/profil/validasiDataOrtuMhsw'); ?>";

		} else if ( act == 'dataAkademik' ) {

		  	var dosenWali = $('#dosenWali').val();

		  	var data = 'id='+id+'&dosenWali='+dosenWali;

		  	var url = "<?= base_url('ademik/profil/validasiDataAkademik'); ?>";

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

		    var data = 'id='+id+'&nik='+nik+'&npwp='+npwp+'&namaAsli='+namaAsli+'&gelarDpn='+gelarDpn+'&gelarBlk='+gelarBlk+'&tmpLahir='+tmpLahir+'&tglLahir='+tglLahir+'&agama='+agama+'&alamat='+alamat+'&rt='+rt+'&rw='+rw+'&kelurahan='+kelurahan+'&kecamatan='+kecamatan+'&telepon='+telepon+'&hp='+hp+'&email='+email+'&sex='+sex;

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


	function delete_disable() {

		if ( $('#bayarSPP').val() != 'Reguler' ) {

			$('#ketSPP').removeAttr('disabled');

		} else {

			$('#ketSPP').attr('disabled', true);

		}

	}

function uploadFoto(act) {

	var foto = $('#namaFoto').val();
	var user = $('#user').val();

	var data = 'act='+act+'&foto='+foto+'&user='+user;

	alert(data);

	/*$body = $("body");
	$body.addClass("loading");*/

	/*$.ajax({
	    url: "<?= base_url('ademik/profil/validasiUploadFoto'); ?>",
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
	});*/

}

</script>
