
<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col">
        <div class="box box-solid">
          <div class="box-header with-border">
            <i class="fa fa-check-square-o text-black"></i>
            <h3 class="box-title">Matakuliah tanpa jadwal</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row" id="form">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Prodi</label>
                  <!-- <select id='prodi' class="form-control select2" multiple="multiple" name[]='prodi' data-placeholder="Pilih Prodi" style="width: 100%;"> -->
                  <select id='prodi' class="form-control select2" name[]='prodi' data-placeholder="Pilih Prodi"
                          style="width: 100%;">
                      <!-- <option value=""></option> -->
                    <?php foreach ($select['prodi'] as $prodi) {
                      echo "<option value='$prodi->kode'>$prodi->kode - $prodi->nama</option>";
                    } ?>
                  </select>
                </div>
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
              <div class="col-md-3">
                <div class="form-group">
                  <label>Program</label>
                  <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" id="program" name="program" tabindex="-1" aria-hidden="true">
                    <option selected="selected" value="REG">REG - Progragram Reguler</option>
                    <option value="RESO">RESO - Program Non Reguler</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <br>
                <button id='cari' onclick="cari()" type="button" class="btn bg-navy btn-flat margin">Cari</button>
              </div>
            </div>
            <hr/>
            <div class="row" id="tabel">
              <div class="col">
                <table id="data" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Prodi</th>
                      <th>Tahun</th>
                      <th>Id Jadwal</th>
                      <th>Nama MK</th>
                      <th>Kode MK</th>
                      <th>Peserta</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="tbody">

                  </tbody>
                </table>
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

<div id="peserta" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="mySmallModalLabel">Mahasiswa</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body mhsw">
        
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div id="pindahkan" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myLargeModalLabel">Jadwal</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
      <!--
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Tahun Akademik</label>
              <select id='tahunj' class="form-control select2"  data-placeholder="Pilih Tahun akademik"
                      style="width: 100%;">
                      <option value=""></option>
                <?php foreach ($select['tahun'] as $tahun) {
                  echo "<option value='$tahun->kode'>$tahun->kode - $tahun->Nama</option>";
                } ?>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Program</label>
              <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" id="programj" name="program" tabindex="-1" aria-hidden="true">
                <option selected="selected" value="REG">REG - Progragram Reguler</option>
                <option value="NONREG">RESO - Program Non Reguler</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Prodi</label>
              <select id='prodij' class="form-control select2" name='prodi' data-placeholder="Pilih Prodi"
                      style="width: 100%;">
                <?php foreach ($select['prodi'] as $prodi) {
                  echo "<option value='$prodi->kode'>$prodi->kode - $prodi->nama</option>";
                } ?>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <br>
            <button onclick="jadwal()" type="button" class="btn btn-warning" >Jadwal</button>
          </div>
        </div>  
        <div class="row">
        -->
          <div class="col-md-12" id="tabelJadwal">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger waves-effect text-right" id="simpan" data-dismiss="modal">Simpan</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>