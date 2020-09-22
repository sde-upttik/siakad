<div class="row">
	<div class="col-6">
		<form enctype="multipart/form-data" id="form_pindahkeuntad" >
		
			<div class="row">
				<h5>Biodata Mahasiswa</h5>
			</div>
			
			<div class="form-group row has-feedback">
				<label for="ptAsal" class="col-md-2 col-xs-12 col-form-label">PT Asal</label>
				<div class="col-md-10">
					<select class="form-control selectPT" style="width: 100%" name="UniversitasAsal" id="UniversitasAsal">
						<!-- <option value="">- Pilih Perguruan Tinggi Asal -</option>
						<?php if($univLs) : ?>
							<?php foreach($univLs as $pt){ ?>
								<option value="<?= $pt->id_perguruan_tinggi ?>"><?= $pt->nama_perguruan_tinggi ?></option>
							<?php } ?>
						<?php endif; ?> -->
					</select>
				</div>				
			</div>
			
			<div class="form-group row has-feedback">
				<label for="ptAsal" class="col-md-2 col-xs-12 col-form-label">Prodi Asal</label>
				<div class="col-md-10">
					<select class="form-control select2" style="width: 100%" name="ProdiAsal" id="ProdiAsal">
					</select>
				</div>				
			</div>
			 
			<div class="form-group row has-feedback">
				<label for="Name" class="col-md-2 col-xs-12 col-form-label">Nama Mahasiswa</label>
				<div class="col-md-10">
					<input class="form-control col-md-12 col-xs-12" type="text" id="Name" name="Name" required >
				</div>				
			</div>				

			<div class="form-group row">
				<label for="NamaIbu" class="col-md-2 col-xs-12 col-form-label">Nama Ibu Kandung</label>
				<div class="col-md-10">
					<input class="form-control col-md-12 col-xs-12" type="text" id="NamaIbu" name="NamaIbu" required >
				</div>				
			</div>		

			<div class="form-group row">
				<div class="col-md-7 row">
					<label for="TempatLahir" class="col-md-3 col-xs-12 col-form-label">Tempat Lahir</label>
					<div class="col-md-8 col-xs-12" style="margin-left: 32px;">
						<input class="form-control" type="search" id="TempatLahir" name="TempatLahir" required="">
					</div>
				</div>
				<div class="col-md-5 row">
					<label for="TglLahir" class="col-md-4 col-xs-12 col-form-label">Tanggal Lahir</label>
					<div class="col-md-8 col-xs-12">
						<div class="input-group date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control pull-right" id="TglLahir" name="TglLahir" placeholder="Tahun-Bulan-Tanggal" required>
						</div>
					</div>
				</div>
			</div>		

			<div class="form-group row">
				<div class="col-md-6 row">
					<label for="tahun_masuk" class="col-md-4 col-xs-12 col-form-label" >Tahun Masuk</label>
					<div class="col-md-6 col-xs-12" style="margin-left: 15px;">
						<select class="form-control select2" style="width: 100%;" id="TahunStatus" name="TahunStatus" required>
							<option value="">--Pilih--</option>
							<?php for ($i=2015; $i <= date("Y") ; $i++) { 
								for ($j=1; $j <= 2; $j++) { 
							?>
								<option value="<?php echo $i.$j ?>"><?php echo $i.$j ?></option>
							<?php		
								}
							} ?>
						</select>
					</div>
				</div>
				<div class="col-md-6 row">
					<label for="tahun_masuk" class="col-md-4
					 col-xs-12 col-form-label">Tahun Angkatan</label>
					<div class="col-md-6 col-xs-12">
						<select class="form-control select2" style="width: 100%;" id="TahunAkademik" name="TahunAkademik" required>
							<option value="">--Pilih--</option>
							<?php for ($i=2015; $i <= date("Y") ; $i++) {
							?>
								<option value="<?php echo $i ?>"><?php echo $i ?></option>
							<?php		
								}
							?>
			        	</select>
				  	</div>
				</div>
			</div>

			<div class="form-group row">
			  <label for="KodeFakultas" class="col-md-2 col-xs-12 col-form-label">Pilih Fakultas</label>
			  <div class="col-md-10 col-xs-12">
		          <select class="form-control select2" style="width: 100%" id="KodeFakultas" name="KodeFakultas" required ">
		            <option value="">--Fakultas--</option>
		            <?php foreach ($data_fakultas as $d) { ?>
		              <option value="<?php echo $d['Kode']?>"> 
		                <?php echo "<b>".$d['Kode']."</b> --- ".$d['Nama_Indonesia'] ?> 
		              </option>
		            <?php } ?>
		          </select>
			  </div>
			</div>      

			<div class="form-group row">
				<label for="KodeJurusan" class="col-md-2 col-xs-12 col-form-label">Pilih Jurusan</label>
				<div class="col-md-10 col-xs-12" id="select_jurusan">
					<select class="form-control select2" style="width: 100%;"  id="select_jurusan_option" required name="KodeJurusan"></select>
				</div>
			</div>		

			<div class="form-group row">
				<label for="KodeProgram" class="col-md-2 col-xs-12 col-form-label">Pilih Program</label>
				<div class="col-md-10 col-xs-12" id="select_program">
					<select class="form-control select2" style="width: 100%;"  id="select_program_option" required name="KodeProgram">
									<option value="REG">Reguler</option>
									<option value="RESO">Non Reguler</option>
					</select>
				</div>
			</div>		

			<div class="form-group row">
			  <label for="AlasanPindah" class="col-md-2 col-xs-12 col-form-label">Alasan Pindah</label>
			  <div class="col-md-10 col-xs-12">
				<textarea name="AlasanPindah" id="AlasanPindah"  rows="3" cols="60" required></textarea>
			  </div>
			</div>	
			<hr>
			
			<div class="form-group row has-feedback">
				<label for="Name" class="col-md-2 col-xs-12 col-form-label">SKS diterima</label>
				<div class="col-md-10">
					<input class="form-control col-md-12 col-xs-12" type="text" id="SKSditerima" name="SKSditerima" required >
				</div>				
			</div>				

			<!-- <hr>
			<div class="row">
				<h5>Akun Mahasiswa</h5>
			</div>

			<div class="form-group row">
			  <label for="Login" class="col-md-2 col-xs-12 col-form-label">Username</label>
			  <div class="col-md-4 col-xs-12">
				<input class="form-control" type="text" id="Login" name="Login" required>
			  </div>
			</div>		

			<div class="form-group row">
			  <label for="Password" class="col-md-2 col-xs-12 col-form-label">Password</label>
			  <div class="col-md-4 col-xs-12">
				<div class="input-group input-group-md">
					<input type="Password" class="form-control" id="Password" required="">
					<span class="input-group-btn">
						<button type="button" class="btn btn-info btn-flat" id="btn_show"><i class="fa fa-eye"></i></button>
					</span>
				</div>
			  </div>
			</div> -->
			<hr>
			<div class="row">
				<h5>Lampiran / Berkas Pendukung</h5>
			</div>
			<p style="font-size: 12px"><i>*File berkas yang  diupload haruslah berekstensi .pdf dan kapasitas minimal dibawan 1 MegaByte (MB)</i></p>
			<div class="form-group row">
			  <label for="alasan_pindah" class="col-md-2 col-xs-12 col-form-label">Input Transkrip Nilai</label>
			  <div class="col-md-10 col-xs-12">
				<input type="file" accept=".pdf" required name="sk_1" id="sk_1">
			  </div>
			</div>		

			<div class="form-group row">
			  <label for="alasan_pindah" class="col-md-2 col-xs-12 col-form-label">Input Sertifikat/SK akreditasi program studi</label>
			  <div class="col-md-10 col-xs-12">
				<input type="file" accept=".pdf" required name="sk_2" id="sk_2">
			  </div>
			</div>
			<hr>
			<button type="submit" class="float-right btn btn-info" style="margin-left: 10px;" onclick="submit_data(event)">
				<i class="fa fa-user"></i> Proses Pindahan
			</button>
			<button type="reset" class="float-left btn btn-warning">Reset</button>
		</form>
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->