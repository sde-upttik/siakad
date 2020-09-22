<div class="form-group">
    <label>Jurusan</label></br>
    <input class="form-control" type="text" name="Jurusan" id="Jurusan" value="<?php echo $data_semester[0]['KodeJurusan'] ?>" readonly>

    <!-- <SELECT name="Jurusan_edit" id="jurusan" class="form-control select2" readonly>
        <option value="">--- Pilih Jurusan ---</option>
        <?php foreach ($data_jurusan as $d) { 
          if ($d['Kode']==$data_semester[0]['KodeJurusan']) {
        ?>
          <option value="<?php echo $d['Kode'] ?>" selected> 
            <?php echo "<b>".$d['Kode']."</b>---".$d['Nama_Indonesia'] ?> 
          </option>
        <?php
          }else{
        ?>
          <option value="<?php echo $d['Kode'] ?>"> 
            <?php echo "<b>".$d['Kode']."</b>---".$d['Nama_Indonesia'] ?> 
          </option>
        <?php }} ?>
    </SELECT> -->
</div>

<div class="form-group">
    <label>Program</label></br>
    <input class="form-control" type="text" name="Program" id="Program" value="<?php echo $data_semester[0]['KodeProgram'] ?>" readonly>
    
    <!-- <SELECT name="Program_edit" id="program" class="form-control select2" readonly>
        <option>--- Pilih Program ---</option>
        <?php 
          if ($data_semester[0]['KodeProgram']=="REG") { 
        ?>
          <option value="REG" selected>REG - Program Reguler</option>
          <option value="RESO">RESO - Program Non Reguler</option>
        <?php  
          }else{ 
        ?>
          <option value="REG" >REG - Program Reguler</option>
          <option value="RESO" selected>RESO - Program Non Reguler</option>
        <?php } ?>
    </SELECT> -->
</div>
  
<div class="form-group">
  <label>Tahun Akademik</label></br>
    <input class="form-control" name="Kode" maxlength="5" minlength="5" id="kode_edit" value="<?php echo $data_semester[0]['kode'] ?>" readonly>
</div>

<div class="form-group">
  <div >
    <label>Nama Sem. Akademik</label></br>
      <input class="form-control" type="text" name="Nama_Sem_Akademik" required id="nama_edit" value="<?php echo $data_semester[0]['Nama'] ?>">
  </div>    
</div> 

<!-- <div class="form-group">
  <div class="checkbox">
    <input type="checkbox" name="status_semester" value="Y" id="status_semester_1_edit">
    <label for="status_semester_1">Semester tidak aktif</label>
  </div>
</div> -->