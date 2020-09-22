<div class="row">
	<div class="col-12">
		<div style="margin: 10px 0 30px 0px">
			<h4>Data Mahasiswa Pindah Ke Universitas Lain</h4>
		</div>
		<form enctype="multipart/form-data" id="formPindahKeluar">
        	<div class="form-group row">
			  	<label for="example-text-input" class="col-sm-2 col-form-label">No. Stambuk</label>
			  	<div class="col-sm-3">
			  		<input class="form-control" type="text" name="nim" id="nim" value="" placeholder="Input Nomor Stambuk">
			  	</div>
			  	<div class="col-sm-1">
			  		<button type="button" onclick="mencari()" class="btn btn btn-primary fa fa-search"> Search</button>
			  	</div>
			</div>
			<div class="form-group row">
			  	<label for="example-text-input" class="col-sm-2 col-form-label">Nama Mahasiswa</label>
			  	<div class="col-sm-5">
					<input class="form-control" type="text" name="nama" id="nama" readonly>
			  	</div>
			</div>
			<div class="form-group row">
			  	<label for="example-text-input" class="col-sm-2 col-form-label">Fakultas</label>
			  	<div class="col-sm-5">
					<input class="form-control" type="text" name="fakultas" id="fakultas" readonly>
			  	</div>
			  	<div class="col-sm-1">
			  	</div>
			</div>
			<div class="form-group row">
			  	<label for="example-text-input" class="col-sm-2 col-form-label">Jurusan/Program Studi</label>
			  	<div class="col-sm-5">
					<input class="form-control" type="text" name="jurusan" id="jurusan" readonly>
			  	</div>
			</div>
			<div class="form-group row">
			  	<label for="example-text-input" class="col-sm-2 col-form-label">Alamat Sekarang</label>
			  	<div class="col-sm-8">
					<input class="form-control" type="text" name="alamatS" id="alamatS" placeholder="Input Alamat Mahasiswa Sekarang">
			  	</div>
			</div>
			<div class="form-group row">
			  	<label for="example-text-input" class="col-sm-2 col-form-label">Alamat Setelah Pindah</label>
			  	<div class="col-sm-8">
					<input class="form-control" type="text" name="alamatSP" id="alamatSP" placeholder="Input Alamat Mahasiswa Setelah Pindah">
			  	</div>
			</div>
			<div class="form-group row">
			  	<label for="example-text-input" class="col-sm-2 col-form-label">Pindah Ke</label>
			  	<div class="col-sm-5">
					<input class="form-control" type="text" name="pindah" id="pindah" placeholder="Input Universitas atau Sekolah Tinggi Tempat Pindah">
			  	</div>
			</div>
			<div class="form-group row">
			  	<label for="example-text-input" class="col-sm-2 col-form-label">Alasan</label>
			  	<div class="col-sm-3">
					<textarea name="alasan_keluar" id="alasan_keluar"  rows="3" cols="146"></textarea>
			  	</div>
			</div>
			<hr>
			<div style="margin: 10px 0 30px 0px">
				<h4>Lampiran / Berkas Pendukung</h4>
			</div>
			<p style="font-size: 12px"><i>*File berkas yang  diupload haruslah berekstensi .pdf dan kapasitas minimal dibawah 1 MegaByte (MB)</i></p>
			<div class="form-group row">
			  <label for="alasan_pindah" class="col-sm-2 col-form-label">File Transkrip Nilai</label>
			  <div class="col-sm-10">
				<input type="file" accept=".pdf" required name="transkrip" id="transkrip">
			  </div>
			</div>		

			<div class="form-group row">
			  <label for="alasan_pindah" class="col-sm-2 col-form-label">File Blangko Pindah</label>
			  <div class="col-sm-10">
				<input type="file" accept=".pdf" required name="blangko" id="blangko">
			  </div>
			</div>
			<div style="margin: 50px 0px 10px 218px">
				<button type="submit" class="btn btn btn-success fa fa-save" onclick="proses_pindah(event)"> Proses Pindah</button>
            	<button type="reset" class="btn btn btn-danger fa fa-refresh"> Reset</button>
			</div>
		</form>
	</div>
		<!-- /.col -->
</div>
<!-- /.row -->