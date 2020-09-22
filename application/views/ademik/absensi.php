<div class="content-wrapper">

    <section class="content-header">
      <h1>
        Absensi Dosen dan Mahasiswas
      </h1>
<!--       <?php 
          $kd_fakultas  = $this->session->userdata("kdf");
          $kd_jurusan   = $this->session->userdata("kdj");

          print_r($kd_fakultas);
          echo "<br>";
          print_r($kd_jurusan);
       ?> -->
    </section>
    <section class="content" style="padding-bottom: 0;">
        <!-- Form Pecarian Jadwal -->
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Form Pencarian Jadwal</h3>
          </div>

          <div class="box-body">
            <div class="row">
              <div class="col-12">
                <form id="form_validation">

                  <!-- INPUT SEMESTER AKADEMIK -->
                  <div class="form-group row">
                    <label for="input_semester" class="col-md-2 col-sm-12 col-xs-12 col-form-label">Semester AKademik</label>
                    <div class="col-md-2 col-sm-12 col-xs-12 ">
                      <input class="form-control" type="number" id="input_semester" maxlength="5" minlength="5" min="20051" required >
                    </div>
                  </div>

                  <!-- INPUT PROGRAM -->
                  <div class="form-group row">
                    <label for="input_program" class="col-md-2 col-form-label col-xs-12">Program</label>
                    <div class="col-md-3 col-xs-12">
                      <select class="form-control select2" style="width: 100%;" id="input_program" name="program" required>
                        <option value="">--Pilih Program--</option>
                        <option value="REG">Program Reguler (REG)</option>
                        <!-- <option value="RESO">Program Non Reguler (RESO)</option> -->
                        <option value="NONREG">Program Non Reguler (NONREG)</option>
                      </select>
                    </div>
                  </div>                

                  <!-- INPUT JURUSAN  -->
                  <div class="form-group row">
                    <label for="input_jurusan" class="col-md-2 col-form-label col-xs-12">Jurusan</label>
                    <div class="col-md-4 col-xs-12">
                      <select class="form-control select2" style="width: 100%;" id="input_jurusan" name="jurusan" required>
                        <option value="">--Jurusan--</option>
                        <?php foreach ($data_jurusan as $jurusan) { ?>
                          <option value="<?php echo $jurusan['kode'] ?>">
                            <?php echo "<b>".$jurusan['kode']."</b> ---".$jurusan['Nama_Indonesia'] ?>    
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
             
                  <!-- Tombol Submit validasi -->
                  <div class="col-md-3 col-xs-12" style="padding-left: 25%;">
                    <input type="submit" value="Cari Jadwal" class="btn btn-primary pull-right">
                  </div>

                </form>
              </div>
            </div>
          </div>
    </section>

    <section class="content" id="jadwal_matakuliah" style="padding-top: 0;"></section>

</div>

