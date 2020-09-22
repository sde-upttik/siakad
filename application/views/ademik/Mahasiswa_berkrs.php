<?php

?>


<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col">
        <div class="box box-solid">
          <div class="box-header with-border">
            <i class="fa fa-check-square-o text-black"></i>
            <h3 class="box-title">Daftar Mahasiswa Berkrs</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row" id="form">
              <div class="col-md-7">
                <div class="form-group" id='selectProdi'>
                  <label>Prodi</label>
                  <select id='prodi' class="form-control select2" multiple="multiple" name[]='prodi' data-placeholder="Pilih Prodi"
                          style="width: 100%;">
                    <?php foreach ($select['prodi'] as $prodi) {
                      echo "<option value='$prodi->kode'>$prodi->kode - $prodi->nama</option>";
                    } ?>
                  </select>
                </div>
                  <input type="checkbox" id="all" name="all" onclick="pilihAll()">
                  <label for="all">Pilih Semua</label>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tahun Akademik</label>
                  <select id='tahun' class="form-control select2"  data-placeholder="Pilih Tahun akademik"
                          style="width: 100%;">
                          <option value=""></option>
                    <?php foreach ($select['tahun'] as $tahun) {
                      echo "<option value='$tahun->kode'>$tahun->kode - $tahun->Nama</option>";
                    } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <br>
                <button id='cari' onclick="cari()" type="button" class="btn bg-navy btn-flat margin">Cari</button>
              </div>
            </div>
            <hr/>
            <div class="row" id="result">
              <div class="col-md-3" id="history">

              </div>
              <div class="col-md-9" id="tabel">

              </div>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- ./col -->
    </div>
  </section>
</div>
