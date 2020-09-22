<div class="content-wrapper">

    <section class="content-header">
      <h1>
        Perwalian Mahasiswa
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="breadcrumb-item"><a href="#">Mahasiswa</a></li>
        <li class="breadcrumb-item active">Perwalian Mahasiswa</li>
      </ol>
    </section>

    <section class="content row " style="padding-bottom: 0;">
       
        <!-- Form Pecarian Jadwal -->
        <div class="box box-default col-md-3 col-xs-12">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-search"></i> Form Pencarian</h3>
          </div>

          <div class="box-body">
            <div class="row">
              <div class="col-12">
                <form id="form_validation">

                  <!-- INPUT SEMESTER AKADEMIK -->
                  <div class="form-group">
                    <label for="input_semester" class="col-form-label">Semester Akademik</label>
                    <select class="form-control select2" style="width: 100%;" id="input_semester" name="semester" required>
                      <?php for ($i=date('Y'); $i >= 2013  ; $i--) { 
                        for ($j=3; $j >=1 ; $j--) { 
                          $k = $i.$j;
                      ?>
                       <option value="<?php echo $k; ?>"><?php echo $k; ?></option>
                      <?php     
                        }
                      }?>
                    </select>
                  </div>

                  <!-- INPUT PROGRAM -->
                  <div class="form-group">
                    <label for="example-search-input" class="col-form-label">Program</label>
                    <select class="form-control select2" style="width: 100%;" id="input_program" name="program" required>
                      <option value="REG">Program Reguler (REG)</option>
                      <option value="RESO">Program Non Reguler (RESO)</option>
                    </select>
                  </div>                

                  <!-- INPUT JURUSAN  -->
                  <div class="form-group">
                    <label for="example-search-input" class="col-form-label">Jurusan</label>
                      <select class="form-control select2" style="width: 100%;" id="input_jurusan" name="jurusan" required>
                        <?php  foreach ($data_jurusan as $jurusan) { ?>
                          <option value="<?php echo $jurusan['kode'] ?>">
                            <?php echo "<b>".$jurusan['kode']."</b> ---".$jurusan['Nama_Indonesia'] ?>    
                          </option>
                        <?php } ?>
                      </select>
                  </div>

                  <!-- Tombol Submit validasi -->
                  <button type="submit" class="btn btn-primary col-12">Mulai Pencarian</button>

                </form>
              </div> 
            </div>
          </div>
        </div>

        <div class="col-xs-12 ml-2 " id="load_content" style="padding-top: 0;  width: 74%;  background-size: 45%; background-repeat: no-repeat; background-position: center;  background-image: url(<?= base_url('assets/undraw/usearch.svg')?>);"></div>
    </section>


</div>
  
<script src="<?=base_url()?>assets/js/pages/data-table.js"></script>