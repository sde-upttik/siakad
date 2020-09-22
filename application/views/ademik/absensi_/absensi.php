<div class="content-wrapper">

    <section class="content-header">
      <h1>
        Absensi Dosen dan Mahasiswa
      </h1>

      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('/menu/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="#">Admakd</a></li>
        <li class="breadcrumb-item active">Absensi</li>
      </ol>
    </section>

    <section class="content" style="padding-bottom: 0; height: 100%">
        
        <!-- Form Pecarian Jadwal -->
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Form Pencarian Jadwal</h3>
          </div>

          <div class="box-body">
            <form id="form_validation">
              <div class="box-body form-element">
                <div class="row">
                  
                    <!-- INPUT SEMESTER AKADEMIK -->
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="input_semester" class="col-form-label">Semester</label>
                        <div class="">
                          <select class="form-control select2" style="width: 100%;" id="input_semester" name="semester" required>
                            <option value="">--Pilih Semester--</option>
                            <?php for ($i=date('Y'); $i >= 2000  ; $i--) { 
                              for ($j=3; $j >=1 ; $j--) { 
                                $k = $i.$j;
                            ?>
                             <option value="<?php echo $k; ?>"><?php echo $k; ?></option>
                            <?php     
                              }
                            }?>
                          </select>
                        </div>
                      </div>
                    </div>

                    <!-- INPUT PROGRAM -->
                    <div class="col-sm-3">
                      <div class="form-group" >
                        <label for="input_program" class="col-form-label">Program</label>
                        <div class="">
                          <select class="form-control select2" style="width: 100%;" id="input_program" name="program" required>
                            <option value="">--Pilih Program--</option>
                            <option value="REG">Program Reguler (REG)</option>
                            <option value="NONREG">Program Non Reguler (NONREG)</option>
                          </select>
                        </div>
                      </div> 
                    </div>

                    <!-- INPUT JURUSAN  -->
                    <div class="col-sm-3">
                      <div class="form-group ">
                        <label for="input_jurusan" class="col-form-label">Jurusan</label>
                        <div class="">
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
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="input_jurusan" class="col-form-label">Proses</label>
                        <div>
                          <input type="submit" value="Cari Jadwal" class="btn btn-primary">                  
                        </div>
                      </div>
                    </div>

                </div>
              </div>
            </form>
          </div>
    </section>
    <section class="content" style="padding-bottom: 0; padding-top: 0; height: 100%">
         <div  id="jadwal_matakuliah"></div>
    </section>
</div>

