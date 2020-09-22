<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Penjadwalan Kuliah
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="#">Tables</a></li>
        <li class="breadcrumb-item active">Data tables</li>
      </ol>
    </section> 

    <!-- Main content -->
    <section class="content">
		<div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Select Elements</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Peringatan!</h4>
            Note : Mulai Tahun Akademik 20191 :
            <br><li>Cetak DPNA bisa di cetak melalui Menu -> AdmAkd -> Absensi.
            <br><li>Penginputan Nilai Mahasiswa di Sesuaikan dengan Priode Aktif di Forlap dan Akan Tertutup dengan Sendirinya.
            <br><li>Tidak Ada Perpindahan Kelas yang Dilakukan penjadawalan, Jika ingin Melakukan Perpindahan Kelas di Sistem, Silahkan Menghapus KRS Mahasiswa dan Memprogram KRS Kembali.
          </div>
          <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-info"></i> User Guide!</h4>
            Note :
            <br><li>Untuk Merubah Nama Matakuliah, Dosen, Kapasistas Kelas, Kelas dan lain-lain, bisa menggunakan tombol ( <img src='<?=base_url()?>assets/images/edit.png' border=0> ).
            <br><li>Untuk Mengirim Nilai ke Feeder Silahkan Tekan Tombol ( <img src='<?=base_url()?>assets/images/edit.png' border=0> ) dan Tekan Tombol Save Changes, secara otomatis Jadwal Matakliah Akan Terkirim ke Feeder.
            <br><li>( <button type='button' class='btn btn-primary'><img src='<?=base_url()?>assets/images/edit.png' border=0></button> ) Untuk Keterangan Jadwal Sudah Terkirim ke Feeder
              <br><li>( <button type='button' class='btn btn-warning'><img src='<?=base_url()?>assets/images/edit.png' border=0></button> ) Untuk Keterangan Jadwal Belum Terkirim ke Feeder
          </div>
          <div class="row">
            <div class="col-md-2 col-12">
              <div class="form-group">
                <label>TahunAkademik</label>
					      <input style="width: 100%;" type="text" class="form-control" id="tahunakademik" value="<?php if (!empty($tahunakademik)){ echo $tahunakademik; } ?>" name="tahunakademik" placeholder="Tahun Akademik">
                <!--<select class="form-control select1" style="width: 100%;">
                  <option selected="selected">Alabama</option>
                  <option>Alaska</option>
                  <option>California</option>
                  <option>Delaware</option>
                  <option>Tennessee</option>
                  <option>Texas</option>
                  <option>Washington</option>
                </select>-->
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-2 col-12">
              <div class="form-group">
                <label>Program</label>
                <select class="form-control select2" style="width: 100%;" id="program" name="program">
                  <option selected="selected" value="REG">REG - Progragram Reguler</option>
                  <option value="NONREG">RESO - Program Non Reguler</option>
                  <!--<option>Delaware</option>
                  <option>Tennessee</option>
                  <option>Texas</option>
                  <option>Washington</option>-->
                </select>
              </div>
			</div>
			<div class="col-md-3 col-12">
              <div class="form-group">
                <label>Jurusan</label>
                <select class="form-control select2" style="width: 100%;" id="jurusan" name="jurusan">
					<?php
						if (!empty($kodejurusan)){
							echo "<option selected='selected' value='".$kodejurusan."'>".$kodejurusan."</option>";
						} else {
							echo "<option selected='selected'>Silahkan Pilih</option>";
						}

						foreach ($r as $w) {
							echo "<option value=".$w[Kode].">".$w[Kode]." -- ".$w[Nama_Indonesia]."</option>";
						}
					?>
				  <!--<option selected="selected">Alabama</option>
                  <option>Alaska</option>
                  <option>Delaware</option>
                  <option>Tennessee</option>
                  <option>Texas</option>
                  <option>Washington</option>-->
                </select>
              </div>
			</div>
			<div class="col-md-2 col-12">
						<div class="form-group">
							<label for="">Hari</label>
							<select class="form-control select2" id="haris" name="haris">
								<option value="1">Minggu</option>
								<option value="2">Senin</option>
								<option value="3">Selasa</option>
								<option value="4">Rabu</option>
								<option value="5">Kamis</option>
								<option value="6">Jum'at</option>
								<option value="7">Sabtu</option>
							</select>
						</div>
			</div>
			<div class="col-md-3 col-12">
              <div class="form-group">
                <label>Tekan Tombol Go Merefresh</label>
                <span class="input-group-btn">
                      <button type="button" onClick="go()" class="btn btn-info btn-flat">Go!</button>
                </span>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>

	  <div class='col-md-12' id="menu" hidden="true">
		<div class='row'>
			<div class='col-md-2'><button type='button' onClick="action()" class='btn btn-block btn-info' data-toggle='modal' data-target='#modal-add-jadwal'>Tambah Jadwal</button></div>
			<div class='col-md-2'><a id="cetakjadwal" class='btn btn-block btn-warning' target='_blank'>Cetak Jadwal</a></div>
			<div class='col-md-2'><button type='button' class='btn btn-block btn-success' data-toggle='modal' data-target='#modal-import'>Import</button></div>
		</div>
	  </div>

	  <!-- Awal Table -->
	  <div class="box">
			<div class='tabelHari'>
				<div class="box-header">
					<h3 class="box-title"></h3>
				</div>
				<div class="box-body">
					<table style="font-size:10px" id="tblJadwal" class="table table-bordered table-striped table-responsive">
						<thead>
							<tr>
								<th>Jam</th>
								<th>Ruang</th>
								<th>KodeMK<br>Mata Kuliah</th>
								<th>Program</th>
								<th>Smster</th>
								<th>Dosen</th>
								<th>Kelas</th>
								<th>Kaps</th>
								<th>Mhsw</th>
								<th>Cetak<br>Absen</th>
								<th>Input<br>Absen</th>
								<th>Daftar Nilai<br>Mahasiswa</th>
								<th>Input Nilai</th>
								<th>KRS/ Nilai</th>
											<th>Ajar Dosen <br> Ke Feeder></th>

							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Jam</th>
								<th>Ruang</th>
								<th>KodeMK<br>Mata Kuliah</th>
								<th>Program</th>
								<th>Smster</th>
								<th>Dosen</th>
								<th>Kelas</th>
								<th>Kaps</th>
								<th>Mhsw</th>
								<th>Cetak<br>Absen</th>
								<th>Input<br>Absen</th>
								<th>Daftar Nilai<br>Mahasiswa</th>
								<th>Input Nilai</th>
								<th>KRS/ Nilai</th>
								<th>Ajar Dosen <br> Ke Feeder></th>

							</tr>
						</tfoot>
						<tbody id="isitabel">
							<?php
								if(!empty($minggu)){
									echo $minggu;
								}
							?>
						</tbody>
					</table>
				</div>
			</div>

			<!-- Minggu 
        <div class='Minggu' style="display: none;">
					<div class="box-header">
						<h3 class="box-title">MINGGU</h3>
					</div>
          <div class="box-body">
            <table style="font-size:10px" id="example1" class="table table-bordered table-striped table-responsive">
							<thead>
								<tr>
									<th>Jam</th>
									<th>Ruang</th>
									<th>KodeMK<br>Mata Kuliah</th>
									<th>Program</th>
									<th>Smster</th>
									<th>Dosen</th>
									<th>Kelas</th>
									<th>Kaps</th>
									<th>Mhsw</th>
									<th>Cetak<br>Absen</th>
									<th>Input<br>Absen</th>
									<th>Daftar Nilai<br>Mahasiswa</th>
									<th>Input Nilai</th>
									<th>KRS/ Nilai</th>
												<th>Ajar Dosen <br> Ke Feeder></th>

								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Jam</th>
									<th>Ruang</th>
									<th>KodeMK<br>Mata Kuliah</th>
									<th>Program</th>
									<th>Smster</th>
									<th>Dosen</th>
									<th>Kelas</th>
									<th>Kaps</th>
									<th>Mhsw</th>
									<th>Cetak<br>Absen</th>
									<th>Input<br>Absen</th>
									<th>Daftar Nilai<br>Mahasiswa</th>
									<th>Input Nilai</th>
									<th>KRS/ Nilai</th>
									<th>Ajar Dosen <br> Ke Feeder></th>

								</tr>
							</tfoot>
							<tbody id="isitab">
								<?php
									if(!empty($minggu)){
										echo $minggu;
									}
								?>
							</tbody>
						</table>
          </div>
        </div>-->

			<!-- Senin
        <div class='Senin' style="display: none;">
					<div class="box-header">
						<h3 class="box-title">SENIN</h3>
					</div>
					<div class="box-body">
						<table style="font-size:10px" id="example2" class="table table-bordered table-striped table-responsive">
							<thead>
								<tr>
									<th>Jam</th>
									<th>Ruang</th>
									<th>KodeMK<br>Mata Kuliah</th>
									<th>Program</th>
									<th>Smster</th>
									<th>Dosen</th>
									<th>Kelas</th>
									<th>Kaps</th>
									<th>Mhsw</th>
									<th>Cetak<br>Absen</th>
									<th>Input<br>Absen</th>
									<th>Daftar Nilai<br>Mahasiswa</th>
									<th>Input Nilai</th>
									<th>KRS/ Nilai</th>
									<th>Ajar Dosen <br> Ke Feeder></th>

								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Jam</th>
									<th>Ruang</th>
									<th>KodeMK<br>Mata Kuliah</th>
									<th>Program</th>
									<th>Smster</th>
									<th>Dosen</th>
									<th>Kelas</th>
									<th>Kaps</th>
									<th>Mhsw</th>
									<th>Cetak<br>Absen</th>
									<th>Input<br>Absen</th>
									<th>Daftar Nilai<br>Mahasiswa</th>
									<th>Input Nilai</th>
									<th>KRS/ Nilai</th>
									<th>Ajar Dosen <br> Ke Feeder></th>

								</tr>
							</tfoot>
							<tbody id="isitab_senin">
								<?php
									if(!empty($senin)){
										echo $senin;
									}
								?>
							</tbody>
						</table>
					</div>
        </div> -->

			<!-- Selasa
        <div class='Selasa' style="display: none;">
					<div class="box-header">
						<h3 class="box-title">SELASA</h3>
					</div>
					<div class="box-body">
						<table style="font-size:10px" id="example3" class="table table-bordered table-striped table-responsive">
							<thead>
								<tr>
									<th>Jam</th>
									<th>Ruang</th>
									<th>KodeMK<br>Mata Kuliah</th>
									<th>Program</th>
									<th>Smster</th>
									<th>Dosen</th>
									<th>Kelas</th>
									<th>Kaps</th>
									<th>Mhsw</th>
									<th>Cetak<br>Absen</th>
									<th>Input<br>Absen</th>
									<th>Daftar Nilai<br>Mahasiswa</th>
									<th>Input Nilai</th>
									<th>KRS/ Nilai</th>
									<th>Ajar Dosen <br> Ke Feeder></th>

								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Jam</th>
									<th>Ruang</th>
									<th>KodeMK<br>Mata Kuliah</th>
									<th>Program</th>
									<th>Smster</th>
									<th>Dosen</th>
									<th>Kelas</th>
									<th>Kaps</th>
									<th>Mhsw</th>
									<th>Cetak<br>Absen</th>
									<th>Input<br>Absen</th>
									<th>Daftar Nilai<br>Mahasiswa</th>
									<th>Input Nilai</th>
									<th>KRS/ Nilai</th>
									<th>Ajar Dosen <br> Ke Feeder></th>

								</tr>
							</tfoot>
							<tbody id="isitab_selasa">
								<?php
									if(!empty($selasa)){
										echo $selasa;
									}
								?>
							</tbody>
						</table>
					</div>
        </div> -->

			<!-- Rabu
        <div class='Rabu' style="display: none;">
					<div class="box-header">
						<h3 class="box-title">RABU</h3>
					</div>
					<div class="box-body">
						<table style="font-size:10px" id="example4" class="table table-bordered table-striped table-responsive">
							<thead>
								<tr>
									<th>Jam</th>
									<th>Ruang</th>
									<th>KodeMK<br>Mata Kuliah</th>
									<th>Program</th>
									<th>Smster</th>
									<th>Dosen</th>
									<th>Kelas</th>
									<th>Kaps</th>
									<th>Mhsw</th>
									<th>Cetak<br>Absen</th>
									<th>Input<br>Absen</th>
									<th>Daftar Nilai<br>Mahasiswa</th>
									<th>Input Nilai</th>
									<th>KRS/ Nilai</th>
									<th>Ajar Dosen <br> Ke Feeder></th>

								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Jam</th>
									<th>Ruang</th>
									<th>KodeMK<br>Mata Kuliah</th>
									<th>Program</th>
									<th>Smster</th>
									<th>Dosen</th>
									<th>Kelas</th>
									<th>Kaps</th>
									<th>Mhsw</th>
									<th>Cetak<br>Absen</th>
									<th>Input<br>Absen</th>
									<th>Daftar Nilai<br>Mahasiswa</th>
									<th>Input Nilai</th>
									<th>KRS/ Nilai</th>
									<th>Ajar Dosen <br> Ke Feeder></th>

								</tr>
							</tfoot>
							<tbody id="isitab_rabu">
								<?php
									if(!empty($rabu)){
										echo $rabu;
									}
								?>
							</tbody>
						</table>
          </div>
        </div> -->

			<!-- Kamis
        <div class='Kamis' style="display: none;">
					<div class="box-header">
						<h3 class="box-title">KAMIS</h3>
					</div>
					<div class="box-body">
						<table style="font-size:10px" id="example5" class="table table-bordered table-striped table-responsive">
							<thead>
								<tr>
									<th>Jam</th>
									<th>Ruang</th>
									<th>KodeMK<br>Mata Kuliah</th>
									<th>Program</th>
									<th>Smster</th>
									<th>Dosen</th>
									<th>Kelas</th>
									<th>Kaps</th>
									<th>Mhsw</th>
									<th>Cetak<br>Absen</th>
									<th>Input<br>Absen</th>
									<th>Daftar Nilai<br>Mahasiswa</th>
									<th>Input Nilai</th>
									<th>KRS/ Nilai</th>
									<th>Ajar Dosen <br> Ke Feeder></th>

								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Jam</th>
									<th>Ruang</th>
									<th>KodeMK<br>Mata Kuliah</th>
									<th>Program</th>
									<th>Smster</th>
									<th>Dosen</th>
									<th>Kelas</th>
									<th>Kaps</th>
									<th>Mhsw</th>
									<th>Cetak<br>Absen</th>
									<th>Input<br>Absen</th>
									<th>Daftar Nilai<br>Mahasiswa</th>
									<th>Input Nilai</th>
									<th>KRS/ Nilai</th>
									<th>Ajar Dosen <br> Ke Feeder></th>

								</tr>
							</tfoot>
							<tbody id="isitab_kamis">
								<?php
									if(!empty($kamis)){
										echo $kamis;
									}
								?>
							</tbody>
						</table>
          </div>
        </div> -->

			<!-- Jumat
        <div class='Jumat' style="display: none;">
					<div class="box-header">
						<h3 class="box-title">JUM'AT</h3>
					</div>
					<div class="box-body">
						<table style="font-size:10px" id="example6" class="table table-bordered table-striped table-responsive">
							<thead>
								<tr>
									<th>Jam</th>
									<th>Ruang</th>
									<th>KodeMK<br>Mata Kuliah</th>
									<th>Program</th>
									<th>Smster</th>
									<th>Dosen</th>
									<th>Kelas</th>
									<th>Kaps</th>
									<th>Mhsw</th>
									<th>Cetak<br>Absen</th>
									<th>Input<br>Absen</th>
									<th>Daftar Nilai<br>Mahasiswa</th>
									<th>Input Nilai</th>
									<th>KRS/ Nilai</th>
									<th>Ajar Dosen <br> Ke Feeder></th>

								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Jam</th>
									<th>Ruang</th>
									<th>KodeMK<br>Mata Kuliah</th>
									<th>Program</th>
									<th>Smster</th>
									<th>Dosen</th>
									<th>Kelas</th>
									<th>Kaps</th>
									<th>Mhsw</th>
									<th>Cetak<br>Absen</th>
									<th>Input<br>Absen</th>
									<th>Daftar Nilai<br>Mahasiswa</th>
									<th>Input Nilai</th>
									<th>KRS/ Nilai</th>
									<th>Ajar Dosen <br> Ke Feeder></th>

								</tr>
							</tfoot>
							<tbody id="isitab_jumat">
								<?php
									if(!empty($jumat)){
										echo $jumat;
									}
								?>
							</tbody>
						</table>
					</div>
        </div> -->

			<!-- Sabtu
        <div class='Sabtu' style="display: none;">
					<div class="box-header">
						<h3 class="box-title">SABTU</h3>
					</div>
					<div class="box-body">
						<table style="font-size:10px" id="example7" class="table table-bordered table-striped table-responsive">
							<thead>
								<tr>
									<th>Jam</th>
									<th>Ruang</th>
									<th>KodeMK<br>Mata Kuliah</th>
									<th>Program</th>
									<th>Smster</th>
									<th>Dosen</th>
									<th>Kelas</th>
									<th>Kaps</th>
									<th>Mhsw</th>
									<th>Cetak<br>Absen</th>
									<th>Input<br>Absen</th>
									<th>Daftar Nilai<br>Mahasiswa</th>
									<th>Input Nilai</th>
									<th>KRS/ Nilai</th>
									<th>Ajar Dosen <br> Ke Feeder></th>

								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Jam</th>
									<th>Ruang</th>
									<th>KodeMK<br>Mata Kuliah</th>
									<th>Program</th>
									<th>Smster</th>
									<th>Dosen</th>
									<th>Kelas</th>
									<th>Kaps</th>
									<th>Mhsw</th>
									<th>Cetak<br>Absen</th>
									<th>Input<br>Absen</th>
									<th>Daftar Nilai<br>Mahasiswa</th>
									<th>Input Nilai</th>
									<th>KRS/ Nilai</th>
												<th>Ajar Dosen <br> Ke Feeder></th>

								</tr>
							</tfoot>
							<tbody id="isitab_sabtu">
								<?php
									if(!empty($sabtu)){
										echo $sabtu;
									}
								?>
							</tbody>
						</table>
          </div>
        </div> -->
    </div>
	  <!-- Akhir Table -->

      <!-- /.box -->
    </section>
    <!-- /.content -->
</div>

				<!-- UNTUK TAMBAH JADWAL-->
				<div class="modal fade" id="modal-add-jadwal">
					<form action="<?=base_url()?>ademik/Jdwlkuliah1/PrcJdwl" method="POST">
					  <div class="modal-dialog modal-lg">
						<div class="modal-content">
						  <div class="modal-header">
							<h4 class="modal-title" id="modul-title">Tambah Jadwal</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span></button>
						  </div>
						  <div class="modal-body">
							<div class="form-group">
								<input type="hidden" class="form-control" style="width: 100%;" id="tahun" name="tahun" readonly />
							</div>
							<div class="form-group">
								<input type="hidden" class="form-control" style="width: 100%;" id="kdj" name="kdj" readonly />
							</div>
							<div class="form-group">
								<input type="hidden" class="form-control" style="width: 100%;" id="md" name="md" readonly />
							</div>
							<div class="form-group">
								<input type="hidden" class="form-control" style="width: 100%;" id="IDJADWAL" name="IDJADWAL" readonly />
							</div>

							<div class="form-group">
								Mata Kuliah
								<select class="form-control select2" style="width: 100%;" id="idmk" name="IDMK"><option> - </option></select>
							</div>

							<div class="demo-checkbox">
								Terjadwal
								<input type="checkbox" id="basic_checkbox_2" name="Terjadwal" value='Y' checked />
								<label for="basic_checkbox_2">Dijadwalkan untuk kuliah. Kosongkan jika tidak dijadwalkan</label>
							</div>

							<div class="form-group">
								Kapasitas Kelas
								<input class="form-control" id='kaps' name='kaps'  placeholder="Kapasitas Kelas">
							</div>

							<div class="form-group">
								Ruang
								<select class="form-control select2" style="width: 100%;" id="ruang" name="KodeRuang"><option value=""> - </option></select>
							</div>

							<div class="form-group">
								Program
								<select class="form-control select2" style="width: 100%;" id="program" name="Program">
									<option selected="selected" value="REG">REG - Progragram Reguler</option>
									<option value="NONREG">RESO - Program Non Reguler</option>>
								</select>
							</div>

							<div class="form-group">
								Hari
								<select class="form-control select2" style="width: 100%;" id="hari" name="Hari"><option> - </option></select>
							</div>

							<div class="form-group">
								Jam Mulai
								<input class="form-control"  id='jammulai' name='JamMulai' size=6 maxlength=5 placeholder="Jam : Menit Exp. (08:00)">
							</div>

							<div class="form-group">
								Jam Selesai
								<input class="form-control" id='jamselesai' name='JamSelesai' size=6 maxlength=5 placeholder="Jam : Menit Exp. (08:40)">
							</div>

							<div class="form-group">
								Rencana Tatap Muka
								<input class="form-control" id='rencana' name='Rencana' size=3 maxlength=3>
							</div>

							<div class="form-group">
								Realisasi Tatap Muka
								<input class="form-control" id='realisasi' name='Realisasi' size=3 maxlength=3>
							</div>

							<div class="form-group">
								<label>Kelas</label>
								<select class="form-control select2" style="width: 100%;" id="keterangan" name="Keterangan"></select>
							</div>

							<div class="form-group">
								<label>Keterangan</label>
								<input type="text" class="form-control" id="ket" name="ket" size=20 maxlength=19>
							</div>

							<div class="form-group">
								<label>PAKET</label>
								<select class="form-control select2" style="width: 100%;" id="idpaket" name="IDPAKET">
									<option></option>
								</select>
							</div>

              <?php
              $daftardsn = "";
              foreach ($dsn as $dosen) {
                $daftardsn .= "<option value=".$dosen['NIP'].">".$dosen['nm_dosen']."</option>";
              }
              ?>

							<div class="form-group">
								<label>Dosen Pengampu</label>
								<select class="form-control select2" style="width: 100%;" id="dosenpengampu" name="dosenpengampu">
									<option></option>
									<?php
									/*foreach ($dsn as $dosen) {
										echo "<option value=".$dosen[NIP].">".$dosen[nm_dosen]."</option>";
									}*/
                  echo $daftardsn;
									?>
								</select>
							</div>

							<div class="form-group">
								<label>Dosen lainnya</label>
								<select class="form-control select2" style="width: 100%;" id="dosenlainnya" name="dosenlainnya[]">
									<option></option>
									<?php
									/*foreach ($dsn as $dosen) {
										echo "<option value=".$dosen[NIP].">".$dosen[nm_dosen]."</option>";
									}*/
                  					echo $daftardsn;
									?>
								</select>
							</div>

							<div class="form-group">
								<label>Dosen lainnya</label>
								<select class="form-control select2" style="width: 100%;" id="dosenlainnya" name="dosenlainnya[]">
									<option></option>
									<?php
									/*foreach ($dsn as $dosen) {
										echo "<option value=".$dosen[NIP].">".$dosen[nm_dosen]."</option>";
									}*/
                  					echo $daftardsn;
									?>
								</select>
							</div>

							<div class="form-group">
								<label>Dosen lainnya</label>
								<select class="form-control select2" style="width: 100%;" id="dosenlainnya" name="dosenlainnya[]">
									<option></option>
									<?php
									/*foreach ($dsn as $dosen) {
										echo "<option value=".$dosen[NIP].">".$dosen[nm_dosen]."</option>";
									}*/
                  					echo $daftardsn;
									?>
								</select>
							</div>

							<div class="form-group">
								<label>Dosen lainnya</label>
								<select class="form-control select2" style="width: 100%;" id="dosenlainnya" name="dosenlainnya[]">
									<option></option>
									<?php
									/*foreach ($dsn as $dosen) {
										echo "<option value=".$dosen[NIP].">".$dosen[nm_dosen]."</option>";
									}*/
                  					echo $daftardsn;
									?>
								</select>
								<button type="button" class="btn btn-success" onClick="adddosen()"> + </button> Tambah Dosen Lainnya
							</div>

							<div class="form-group" id="assdsn">

							</div>

						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
							<input type="submit" class="btn btn-info" name="submitPrcJdwl" value="Save changes">
							<button type="button" class="btn btn-info" id="deleteJadwal">Delete</button>
						  </div>
						</div>
						<!-- /.modal-content -->
					  </div>
					</form>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->

				<!--
				<div class="modal modal-primary fade" id="modal-primary-jadwal">
				  <div class="modal-dialog">
				  <form action="ademik/module/module/addmodul" method="POST"/>
					<div class="modal-content">
					  <div class="modal-header">
						<h4 class="modal-title">Input Nilai</h4><input id="groupmodulid" type="hidden" name="groupmodulid" readonly="readonly"/>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span></button>
					  </div>
					  <div class="modal-body">
				-->

				<!-- Input Nilai -->
				<div class="modal fade" id="modal-primary-jadwal">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" id="myLargeModalLabel">Input Nilai Mahasiswa</h4>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							</div>
							<div class="modal-body">
								<!-- Main content untuk isi data kliring -->
									<section class="content">
										<div class="row">
											<div class="col-12">
												<div class="box">
													<div class="box-header">
														<h3 id="nameheaderinnilai" class="box-title">Pastikan Nilai Mahasiswa Sudah Benar</h3>
													</div>
													<!-- /.box-header -->
                          <?php
                          //if ($this->session->userdata("ulevel") == 1){
                          ?>
                            <div class="box-body">
  														<form id="form-kirimnilaidikti">
  															<input type="hidden" class="form-control" id="idjadwalinnilai" name="idjadwalinnilai" readonly>
  															<input type="hidden" class="form-control" id="tahunvalidasi" name="tahunvalidasi" readonly>
  															<input type="hidden" class="form-control" id="programvalidasi" name="programvalidasi" readonly>
  															<input type="hidden" class="form-control" id="kdjvalidasi" name="kdjvalidasi" readonly>
                                <div class="form-group row">
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" id="tahunangkatannilai" name="tahunangkatannilai">
                                  </div>
  																<div class="col-md-3">
                                    <Button type="button" onclick='daftarmhsnil()' class='btn btn-info btn-flat'>Go Angkatan</Button>
                                  </div>
  															</div>
                                <div id="tampilnilai" hidden="true" >
                                  <div id="divdaftarnil"></div>
                                  <div class="form-group row">
    																<div class="col-md-12" style="text-align: center;">
    																	<Button type="button" onclick='kirimnilaidikti()' class='btn bg-olive'>Validasi Nilai dan Kirim ke DIKTI</Button>
                                    </div>
    															</div>
                                </div>
  														</form>
  													</div>
                          <?php // } else { ?>
                            <!--<div class="box-body">
  														<form action="<?=base_url()?>ademik/Jdwlkuliah1/kirimnilaidikti" method="POST">
  															<input type="hidden" class="form-control" id="idjadwalinnilai" name="idjadwalinnilai" readOnly>
  															<input type="hidden" class="form-control" id="tahunvalidasi" name="tahunvalidasi" readOnly>
  															<input type="hidden" class="form-control" id="programvalidasi" name="programvalidasi" readOnly>
  															<input type="hidden" class="form-control" id="kdjvalidasi" name="kdjvalidasi" readOnly>
  															<div id="divdaftarnil"></div>
  															<div class="form-group row">
  																<div class="col-md-12" style="text-align: center;">
  																	<input type="submit" name="simpan" id="simpan" value="Validasi Nilai dan Kirim ke DIKTI" class="btn bg-olive">
  																</div>
  															</div>
  														</form>
  													</div> -->
                          <?php
                          // }
                          ?>
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


				<!-- Input Nilai --!>
				<div class="modal fade" id="modal-primary-dikti">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" id="myLargeModalLabel">Kirim Nilai Mahasiswa Ke Dikti</h4>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							</div>
							<div class="modal-body">

									<section class="content">
										<div class="row">
											<div class="col-12">
												<div class="box">
													<div class="box-header">
														<h3 class="box-title">Pastikan Nilai Mahasiswa Sudah Benar</h3>
													</div>

													<div class="box-body">
														<form action="<?=base_url()?>ademik/Jdwlkuliah1/kirimnilaidikti" method="POST">
															<input type="hidden" class="form-control" id="idjadwaldikti" name="idjadwaldikti" readOnly>
															<input type="hidden" class="form-control" id="tahundikti" name="tahundikti" readOnly>
															<input type="hidden" class="form-control" id="programdikti" name="programdikti" readOnly>
															<input type="hidden" class="form-control" id="kdjdikti" name="kdjdikti" readOnly>
															<div id="divdaftarnildikti"></div>
															<div class="form-group row">
																<div class="col-md-12" style="text-align: center;">
																	<input type="submit" name="simpan" id="simpandikti" value="Validasi Nilai" class="btn bg-olive">
																</div>
															</div>
														</form>
													</div>

												</div>

											</div>

										</div>

									</section>

							</div>
							<div class="modal-footer">
									<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
							</div>
						</div>
						<!-- /.modal-content --1>
					</div>
					<!-- /.modal-dialog --!>
				</div>
				<!-- /.modal -->

				<!-- UNTUK TAMBAH JADWAL-->
				<div class="modal fade" id="modal-import">

					<form action="<?=base_url()?>ademik/jdwlkuliah1/import_excel" method="POST" enctype="multipart/form-data">
					  <div class="modal-dialog modal-lg">
						<div class="modal-content">
						  <div class="modal-header">
							<h4 class="modal-title" id="modul-title">Import Jadwal</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span></button>
						  </div>
						  <div class="modal-body">
							<h5>Pastikan sebelum mengupload, file yang di import berformat <strong>.xls/.xlsx</strong></h5>
							<div class="form-group">
								Masukkan File
								<input type="file" style="width: 100%;" id="userfile" name="userfile" />
							</div>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
							<input type="submit" class="btn btn-info" name="runimport" value="Run Import">
						  </div>
						</div>
						<!-- /.modal-content -->
					  </div>
					</form>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->



<script>
	
	let week = ['','MINGGU','SENIN','SELASA','RABU','KAMIS','JUM\'AT','SABTU'];
function action(id){
	var actval = $('#act_value'+id).val();
	if (id !== undefined){
		actval = (actval).replace("+", "_").replace("+", "_");
		var mhswInKelas = $('#mhsw'+id).html();
		if (mhswInKelas !== "0"){
			swal({
				title: 'Peringatan',
				type: 'warning',
				html: true,
				text: mhswInKelas+" Mahasiswa sudah ada dalam kelas ini. Jangan Merubah Matakuliah, Ruang dan Keterangan, menyebabkan mahasiswa di kelas ini hilang",
				confirmButtonColor: '#f7cb3b',
			});
			$('#ket').attr("readOnly",true);
		}
	}
	var tahunakademik = $('#tahunakademik').val();
	var program = $('#program').val();
	var jurusan = $('#jurusan').val();

  	$body = $("body");
	$body.addClass("loading");
	//alert(actval + " - " + tahunakademik + " - " + program + " - " + jurusan)

	if (id != undefined){
		$('#modul-title').html("Edit Jadwal");
	} else {
		$('#modul-title').html("Tambah Jadwal");
	}

	//alert(tahunakademik+' dan '+program+' dan '+jurusan+' dan '+id+' dan '+actval);

	$.ajax({
		type: 'POST',
		url: '<?=base_url()?>ademik/jdwlkuliah1/action',
		data: 'tahunakademik=' + tahunakademik + '&program='+ program + '&jurusan='+ jurusan +'&id='+id +'&actval='+actval,
		dataType: "JSON",
		success: function(response){
      		$body.removeClass("loading");
			// console.log(response);
			//alert(response);
			//console.log(response);
			$('#idmk').html(response[0].idmk);
			$('#ruang').html(response[0].ruang);
			$('#hari').html(response[0].hari);
			$('#keterangan').html(response[0].kelas);
			$('#idpaket').html(response[0].paket);
			$('#tahun').val(response[0].tahun);
			$('#kdj').val(response[0].kdj);
			$('#md').val(response[0].md);
			$('#IDJADWAL').val(actval);
			$('#jammulai').val(response[0].jmmulai);
			$('#jamselesai').val(response[0].jamselesai);
			$('#rencana').val(response[0].rencana);
			$('#realisasi').val(response[0].realisasi);
			$('#kaps').val(response[0].kaps);
			$('#ket').val(response[0].keterangan);
			$('#dosenpengampu').prepend(response[0].dosen);
			$('#assdsn').html(response[0].ass);
			$('#deleteJadwal').attr('onclick', "window.location.href='<?=base_url()?>ademik/Jdwlkuliah1/deleteJadwal/"+actval+"'");
		}
	})
	.fail(function(err){
		console.log(err);
	});
	//alert('fandu');
}

function go(){

	setCookie('history',0,1);
	setCookie('ta',$('#tahunakademik').val(),1);
	setCookie('kp',$('#program').val(),1);
	setCookie('kj',$('#jurusan').val(),1);
	setCookie('kh',$('#haris').val(),1);
		
	$('.Minggu').hide()
	$('.Senin').hide();
	$('.Selasa').hide();
	$('.Rabu').hide();
	$('.Kamis').hide();
	$('.Jumat').hide();
	$('.Sabtu').hide();
	//var tahunakademik = document.getElementById("tahunakademik").value;
	//var program = document.getElementById("program").options[document.getElementById("program").selectedIndex].value;
	//var jurusan = document.getElementById("jurusan").options[document.getElementById("jurusan").selectedIndex].value;

	var tahunakademik = $('#tahunakademik').val();
	var program = $('#program').val();
	var jurusan = $('#jurusan').val();
	var hari = $('#haris').val()
	$('div.tabelHari>div.box-header>h3.box-title').html(week[hari])
	$('#hari').val(hari).select2()
	$body = $("body");
	$body.addClass("loading");

	//alert($('#tes').val()+" dan "+id);
	//alert(tahunakademik+" - "+program+" - "+jurusan);
	// if (program == 'NONREG') {
	// 	program = 'RESO';
	// }
	let input = {
		'tahunakademik' : tahunakademik , 
		'program': program , 
		'jurusan':jurusan , 
		'hari':hari
	}

	// console.log(input);
	$.ajax({
		type: 'POST',
		url: '<?=base_url()?>ademik/jdwlkuliah1/jadwal',
		'data': input,
		dataType: "JSON",
		timeout: 300000,
		success: function(response){
			// console.log(response);
			//console.log("fandu "+response.ket);
			//console.log("fandu "+response.minggu);
			//console.log("fandu "+response.senin);
			//console.log("fandu "+response.selasa);
			$body.removeClass("loading");
			if ( response.ket == 'error' ) {
				//console.log(response.pesan);
				swal({
					title: 'Peringatan',
					type: 'warning',
					html: true,
					text: response.pesan,
					confirmButtonColor: '#f7cb3b',
				});
			} else if (response.ket == 'sukses') {
				$('#menu').attr("hidden",false);
				
				switch (hari) {
					case '1':
						$('#isitabel').html(response.minggu);
						break;
					case '2':
						$('#isitabel').html(response.senin);
						break;
					case '3':
						$('#isitabel').html(response.selasa);
						break;
					case '4':
						$('#isitabel').html(response.rabu);
						break;
					case '5':
						$('#isitabel').html(response.kamis);
						break;
					case '6':
						$('#isitabel').html(response.jumat);
						break;
					case '7':
						$('#isitabel').html(response.sabtu);
						break;
				
					default:
						$('#isitabel').html('')
						break;
				}

				$('#cetakjadwal').attr('href', '<?=base_url()?>ademik/report/report2/cetak_jadwal/'+tahunakademik+'/'+program+'/'+jurusan);
				//$('#groupmodulid').val(id);

				swal({
					title: 'Pesan',
					type: 'success',
					html: true,
					text: response.pesan,
					confirmButtonColor: 'green',
				}, function() {
					//location.reload();
					//console.log(e.parent());
				});
			}
		},
		error: function (err) {
	       	// console.log(err);
	    }
	}).always(function() {
		$body.removeClass("loading");
  });
	//alert('fandu');
}

function adddosen(){
	$.ajax({
		type: 'POST',
		url: '<?=base_url()?>ademik/jdwlkuliah1/addassdosen',
		success: function(response){
			//alert(response);
			$('#assdsn').append(response);
		}
	});
	//alert('fandu');

}

function deldosen(iddosen){
	var idjadwal = $('#IDJADWAL').val();
	//alert(idjadwal+" dan "+iddosen);
	$.ajax({
		type: 'POST',
		url: '<?=base_url()?>ademik/jdwlkuliah1/deldosen',
		data: 'idjadwal=' + idjadwal + '&iddosen='+ iddosen,
		success: function(response){
			if (response == "Success") {
				//alert("Berhasi Menghapus Dosen");
				$('#'+iddosen).remove();
			} else {
				alert("Gagal Menghapus Dosen");
			}
		}
	});
}

function hapus (e){
	var del = $(e.target).parent();
	del.remove();
}

function nilai(nil, i, e){
	var idjad = $('#idjadwalinnilai').val();
	var nim = $('#nim'+i).val();
	var tahunakademik = $('#tahunakademik').val();

	$.ajax({
		type: 'POST',
		url: '<?=base_url()?>ademik/jdwlkuliah1/innilai',
		data: 'idjadwal=' + idjad + '&tahun='+ tahunakademik + '&nim='+ nim + '&nil='+ nil,
		dataType: "JSON",
		success: function(response){
			//alert(response.detailnil);
			//console.log(e);
      if (response.ket == "sukses"){
        $(e).attr("class","btn btn-flat btn-danger");
      } else {
        alert(response.pesan);
      }
		}
	});
}

function getdaftarmhsnil(id){

	var actval = $('#act_value'+id).val();
  var namamk = $('#act_name'+id).val();
	var tahunakademik = $('#tahunakademik').val();
	var program = $('#program').val();
	var jurusan = $('#jurusan').val();

  $('#idjadwalinnilai').val(actval);
  $('#nameheaderinnilai').html("Pastikan Nilai Mahasiswa Sudah Benar<br>pada matakuliah<br>"+namamk);
  $('#tahunvalidasi').val(tahunakademik);
  $('#programvalidasi').val(program);
  $('#kdjvalidasi').val(jurusan);

  $('#divdaftarnil').html("");
  $('#tampilnilai').attr("hidden",true);

}

function daftarmhsnil(){
  $body = $("body");
  $body.addClass("loading");

	$('#divdaftarnil').html("");

	var actval = $('#idjadwalinnilai').val();
	var tahunakademik = $('#tahunakademik').val();
  var tahunangkatannilai = $('#tahunangkatannilai').val();

	/*var program = $('#program').val();
	var jurusan = $('#jurusan').val();*/

  // alert(actval+" - "+tahunakademik+" - "+tahunangkatannilai);

	$.ajax({
		type: 'POST',
		url: '<?=base_url()?>ademik/jdwlkuliah1/daftarmhsnil',
		data: 'idjadwal=' + actval + '&tahun='+ tahunakademik + '&angkatan='+ tahunangkatannilai,
		dataType: "JSON",
		success: function(response){
			$('#divdaftarnil').html(response.daftarnil);
			/*$('#idjadwalinnilai').val(actval);
			$('#tahunvalidasi').val(tahunakademik);
			$('#programvalidasi').val(program);
			$('#kdjvalidasi').val(jurusan);*/
      $('#tampilnilai').attr("hidden",false);
      $body.removeClass("loading");
		}
	})
	.fail(function(res){
		// console.log(res);
		// console.log(actval);
	});
}

/*function daftarmhsdikti(id){
	$('#divdaftarnildikti').html("");
	var actval = $('#act_value'+id).val();
	var tahunakademik = $('#tahunakademik').val();
	var program = $('#program').val();
	var jurusan = $('#jurusan').val();
	//alert(actval);

	$.ajax({
		type: 'POST',
		url: '<?=base_url()?>ademik/jdwlkuliah1/daftardikti',
		data: 'idjadwal=' + actval + '&tahun='+ tahunakademik,
		dataType: "JSON",
		success: function(response){
			//alert(response.daftarnil);
			$('#divdaftarnildikti').html(response.daftarnil);
			$('#idjadwaldikti').val(actval);
			$('#tahundikti').val(tahunakademik);
			$('#programdikti').val(program);
			$('#kdjdikti').val(jurusan);
		}
	});
}*/

function batalvalidasi(kode, i, e){
  var idjad = $('#idjadwalinnilai').val();
	var nim = $('#nim'+i).val();
	var tahunakademik = $('#tahunakademik').val();
  //alert(idjad + " - "+ nim  + " - "+ tahunakademik);

	$.ajax({
		type: 'POST',
		url: '<?=base_url()?>ademik/jdwlkuliah1/batalvalidasi',
		data: 'idjadwal=' + idjad + '&tahun='+ tahunakademik + '&nim='+ nim,
		dataType: "JSON",
		success: function(response){
			//alert(response.detailnil);
			console.log(response);
			$(e).attr("class","btn btn-block btn-social").html('Proses Pembatalan Berhasil');
		}
	});
}

function kirimnilaidikti(){
  //alert("masuk");
  var data = $('#form-kirimnilaidikti').serialize();
  console.log(data);

	$.ajax({
		type: 'POST',
		url: '<?=base_url()?>ademik/Jdwlkuliah1/kirimnilaidikti',
		data: data,
		dataType: "JSON",
		success: function(response){
			alert(response.ket);
			if ( response.ket == 'sukses' ) {
				//console.log(response.pesan);
				$('#divdaftarnil').html(response.pesan);
			} else {
				$('#divdaftarnil').html(response.pesan);
			}
			//console.log(response);
			//$(e).attr("class","btn btn-block btn-social").html('Proses Pembatalan Berhasil');
		}
	});
}

function kirimidajar(e,id,jns){
  console.log(e);
  var actval = $('#act_value'+id).val();
	var tahunakademik = $('#tahunakademik').val();
	var program = $('#program').val();
	var jurusan = $('#jurusan').val();

  $body = $("body");
	$body.addClass("loading");

	$.ajax({
		type: 'POST',
		url: '<?=base_url()?>ademik/jdwlkuliah1/InsertDosenPengajarKelasKuliah',
		data: 'tahunakademik=' + tahunakademik + '&program='+ program + '&jurusan='+ jurusan +'&id='+id +'&actval='+actval+'&jenis_dosen='+jns,
		dataType: "JSON",
		success: function(response){
      $body.removeClass("loading");

			console.log(response);

      var error_code = response.error_code;
      var error_desc = response.error_desc;

      if ( error_code != 0 ) {
				swal({
					title: 'Peringatan',
					type: 'warning',
					html: true,
					text: error_desc,
					confirmButtonColor: '#f7cb3b',
				});
			} else if (error_code == 0) {
				swal({
					title: 'Pesan',
					type: 'success',
					html: true,
					text: "ID Ajar Dosen Berhasil Terkirim ke Feeder",
					confirmButtonColor: 'green',
				});
			}

		}
	});
}


function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=<?= $_SERVER['REQUEST_URI']?>";
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

</script>

<!--  fandu export start - This is for export functionality only --A>
    <script src="<?=base_url()?>assets/plugins/DataTables-1.10.15/extensions/Buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.flash.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/DataTables-1.10.15/ex-js/jszip.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/DataTables-1.10.15/ex-js/pdfmake.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/DataTables-1.10.15/ex-js/vfs_fonts.js"></script>
    <script src="<?=base_url()?>assets/plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.html5.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->
<?php
	// $this->load->view('fikri.js/jdwlkuliah1');
?>