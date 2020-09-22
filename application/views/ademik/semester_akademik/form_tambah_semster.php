<div class="form-group">
 		<label>Jurusan</label></br>
  	<SELECT name="Jurusan" id="jurusan" class="form-control select2" required>
    		<option value="">--- Pilih Jurusan ---</option>
    		<?php foreach ($data_jurusan as $d) { ?>
          <option value="<?php echo $d['Kode'] ?>"> 
            <?php echo "<b>".$d['Kode']."</b>---".$d['Nama_Indonesia'] ?> 
          </option>
        <?php } ?>
  	</SELECT>
</div>

<div class="form-group">
    <label>Program</label></br>
    <SELECT name="Program" id="program" class="form-control select2" required>
        <option value="">--- Pilih Program ---</option>
        <option value="REG">REG - Program Reguler</option>
        <option value="RESO">RESO - Program Non Reguler</option>
    </SELECT>
</div>
  
<div class="form-group">
	<label>Tahun Akademik</label></br>
   	<input class="form-control" type="text" name="Kode" maxlength="5" minlength="5"  required id="kode" >
</div>

<div class="form-group">
	<div >
  	<label>Nama Sem. Akademik</label></br>
     	<input class="form-control" type="text" name="Nama_Sem_Akademik" required id="nama" >
  </div> 	  
</div>

<!-- <div class="form-group">
  <div class="checkbox">
    <input type="checkbox" name="status_semester" value="Y" id="status_semester_1">
    <label for="status_semester_1">Semester tidak aktif</label>
  </div>
</div> -->