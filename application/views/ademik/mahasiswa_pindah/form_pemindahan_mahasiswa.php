<form id="form_validation" style="margin-top: 30px;">
  <div class="row">

    <div class="col-md-4">
      <!-- INPUT NIM MAHASISWA-->
      <div class="form-group">
        <label class="col-md-12 col-form-label col-xs-12" for="NIM_mahasiswa">NIM Mahasiswa</label>
        <div class="col-md-12 col-xs-12">
          <input type="text" name="NIM_mahasiswa" id="NIM_mahasiswa" class="form-control" required>
        </div>
      </div>                
    </div>

    <div class="col-md-4">
      
      <!-- INPUT JURUSAN  -->
      <div class="form-group">
        <label class="col-md-12 col-form-label col-xs-12" for="jurusan">Pilih Pindah Jurusan</label>
        <div class="col-md-12 col-xs-12">
          <select class="form-control select2" style="width: 100%;" id="input_jurusan" name="jurusan" required>
            <option value="">--Jurusan--</option>
            <?php foreach ($data_jurusan as $d) { ?>
              <option value="<?php echo $d['Kode']?>"> 
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
        <label class="col-md-12 col-form-label col-xs-12">Lakukan Pemindahan</label>
        <div class="col-md-12 col-xs-12">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-share"></i>
            Pindah Mahsiswa
          </button>                    
        </div>
      </div>
    </div>

  </div>
</form> 

<section id="load_content" style="padding-top: 0;"></section>