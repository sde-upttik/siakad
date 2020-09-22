<div class="content-wrapper">

  <section class="content-header" style="padding-top: 5px; padding-bottom: 5px; ">
    <h4 >
      Semester Akademik
    </h4>
  </section>

  <section class="content" style="padding-bottom: 0;">
    <!-- Form Pecarian Jadwal -->
    <div class="box" style="margin-bottom: 0; padding: 30px;">

      <div class="box-header with-border">
        <h3 class="box-title">Form Pencarian Semester Akademik</h3>
      </div>  
      
        <div class="box-body">
          <form id="form_validation">
            <div class="row">

            <div class="col-md-4">
              <!-- INPUT PROGRAM -->
              <div class="form-group">
                <label class="col-md-1 col-form-label col-xs-12">Program</label>
                <div class="col-md-12 col-xs-12">
                  <select class="form-control select2" style="width: 100%;" id="input_program" name="program" required>
                    <option value="">--Pilih Program--</option>
                    <option value="REG">Program Reguler (REG)</option>
                    <option value="RESO">Program Non Reguler (RESO)</option>
                  </select>
                </div>
              </div>                
            </div>

            <div class="col-md-4">
              <!-- INPUT JURUSAN  -->
              <div class="form-group">
                <label class="col-md-1 col-form-label col-xs-12">Jurusan</label>
                <div class="col-md-12 col-xs-12">
                  <select class="form-control select2" style="width: 100%;" id="input_jurusan" name="jurusan" required>
                    <option value="">--Jurusan--</option>
                    <?php foreach ($terserah_jurusan as $d) { ?>
                      <option value="<?php echo $d['Kode']?> "> 
                        <?php echo "<b>".$d['Kode']."</b> --- ".$d['Nama_Indonesia'] ?> 
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>              

            <div class="col-md-4">
              <!-- Tombol submit validasi  -->
              <div class="form-group">
                <label for="example-search-input" class="col-md-12 col-form-label col-xs-12">Lakukan Pencarian</label>
                <div class="col-md-12 col-xs-12">
                  <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search"></i>
                    Cari Semester 
                  </button>                    
                </div>
              </div>
            </div>

            </div>
          </form> 
        </div>
        <!-- End Box-Body  -->
    </div>
  </section>

  <section class="content" id="load_content" style="padding-top: 0;"></section>

<script src="<?=base_url()?>assets/js/pages/data-table.js"></script>