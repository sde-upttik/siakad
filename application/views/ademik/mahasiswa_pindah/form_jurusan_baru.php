<div class="box col-md-8 col-xs-12" style="margin: auto">
  <div class="box-header" style="background-color: #2c3e50; color: white ">
    <h3 class="box-title" >Form Pindah Jurusan Baru</h3>
  </div>
  <div class="box-body">

  <h6>IDENTITAS DIRI PRODI LAMA</h6>
  <table class="table">
    <tr>
      <th>NIM</th>
      <td>: <?php echo $data_mahasiswa[0]['NIM']; ?></td>
      <th>Kode Fakultas</th>
      <td>: <?php echo $data_mahasiswa[0]['KodeFakultas']; ?></td>  
    </tr>        
    <tr>
      <th>Nama Mahasiswa</th>
      <td>: <?php echo $data_mahasiswa[0]['Name']; ?></td>
      <th>Kode Jurusan </th>
      <td>: <?php echo $data_mahasiswa[0]['KodeJurusan']; ?></td>  
    </tr>
  </table>
  <br>
 
  <h6>IDENTITAS DIRI PRODI BARU</h6>

  <form class="ml-5">
<!-- NIM BARU -->
      <div class="form-group row">
        <label class="col-form-label col-md-4" for="NIM_baru">NIM Baru</label>
        <div class="col-md-7 col-xs-12">
          <input type="text" name="NIM_baru" id="NIM_baru" class="form-control" required disabled value="<?php echo $nim_baru ?>">
        </div>
      </div>

<!-- NAMA BARU -->
      <div class="form-group row">
        <label class="col-form-label col-md-4" for="nama_baru">Nama Baru</label>
        <div class="col-md-7 col-xs-12">
          <input type="text" name="nama_baru" id="nama_baru" class="form-control" required value="<?php echo $data_mahasiswa[0]['Name']; ?>">
        </div>
      </div>

<!-- TEMPAT LAHIR -->
      <div class="form-group row">
        <label class="col-form-label col-md-4" for="tempat_lahir">Tempat Lahir</label>
        <div class="col-md-7 col-xs-12">
          <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required value="<?php echo $data_mahasiswa[0]['TempatLahir']; ?>">
        </div>
      </div>

<!-- TANGGAL LAHIR -->
      <div class="form-group row">
        <label class="col-form-label col-md-4" for="tanggal_lahir">Tanggal Lahir</label>
        <div class="col-md-7 col-xs-12">
          <input type="date" name="tanggal_lahir" id="example-date-input" class="form-control" required value="<?php echo $data_mahasiswa[0]['TglLahir']; ?>">
        </div>
      </div>

<!-- NAMA IBU KANDUNG -->
      <div class="form-group row">
        <label class="col-form-label col-md-4" for="nama_ibu_kandung">Nama Ibu Kandung</label>
        <div class="col-md-7 col-xs-12">
          <input type="text" name="nama_ibu_kandung" id="nama_ibu_kandung" class="form-control" required value="<?php echo $data_mahasiswa[0]['NamaIbu']; ?>">
        </div>
      </div>

<!-- Email Baru -->
      <div class="form-group row">
        <label class="col-form-label col-md-4" for="Email">Email Baru</label>
        <div class="col-md-7 col-xs-12">
          <input type="email" name="Email" id="Email" class="form-control" required value="<?php echo $data_mahasiswa[0]['Email']; ?>">
        </div>
      </div>

<!-- Telp Baru -->
      <div class="form-group row">
        <label class="col-form-label col-md-4" for="telp_baru">Telp Baru</label>
        <div class="col-md-7 col-xs-12">
          <input type="text" name="telp_baru" id="telp_baru" class="form-control" required value="<?php echo $data_mahasiswa[0]['Phone']; ?>">
        </div>
      </div>

<!-- SKS yang diterima -->
      <div class="form-group row">
        <label class="col-form-label col-md-4" for="SKSditerima">SKS yang diterima</label>
        <div class="col-md-3 col-xs-12">
          <input type="number" name="SKSditerima" id="SKSditerima" class="form-control" required value="<?php echo $data_mahasiswa[0]['SKSditerima']; ?>">
        </div>
      </div>

<!-- Program -->
      <div class="form-group row">
        <label class="col-form-label col-md-4" for="program">Program</label>
        <div class="col-md-7 col-xs-12">
          <select class="form-control select1" required id="program">
            <option value="REG" <?php if ($data_mahasiswa[0]['KodeProgram']=="REG") {echo "selected";} ?>> REGULER</option>
            <option value="NONREG" <?php if ($data_mahasiswa[0]['KodeProgram']=="NONREG") {echo "selected";} ?>>NON REGULER</option>
          </select>
        </div>
      </div>

<!-- Tahun Pindah -->
      <div class="form-group row">
        <label class="col-form-label col-md-4" for="tahun_pindah">Tahun Pindah</label>
        <div class="col-md-7 col-xs-12">
          <select class="form-control select1" required id="tahun_pindah">
            <!-- <?php  
              // date_default_timezone_set("Asia/Bangkok");
              // for ($i=DATE("Y"); $i >= 2017; $i--) { 
            ?>-->
              <!-- <option value="<?php echo $i."1"; ?>"><?php echo $i."1"; ?></option>
              <option value="<?php echo $i."2"; ?>"><?php echo $i."2"; ?></option> -->
            <?php foreach($periode_feeder as $periode) { ?>
              <option value="<?= $periode->periode_pelaporan ?>"><?= $periode->periode_pelaporan ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

<!-- Biaya Pindah -->
      <div class="form-group row">
        <label class="col-form-label col-md-4" for="tahun_pindah">Biaya Pindah</label>
        <div class="col-md-7 col-xs-12">
          <input type="text"  class="form-control" required id="biaya_masuk_kuliah" name="biaya_masuk_kuliah" placeholder="Rp.">
        </div>
      </div>

<!-- Tombol submit -->
      <div class="form-group row">
        <label class="col-form-label col-md-4" for="tahun_pindah"></label>
        <div class="col-md-7 col-xs-12">
          <button class="btn btn-default col-md-5" type="reset">Batal</button> 
          <button class="btn btn-primary col-md-5 float-right" id="btn_simpan">Save</button>
        </div>
      </div>

    </form>
  </div>
</div>


<script src="/assets/plugins/jquery_validation/jquery.form.js"></script>
<script src="/assets/plugins/jquery_validation/jquery.validate.js"></script>
<script type="text/javascript">
// console.log(<?= json_encode($periode_feeder) ?>)
    $("#btn_simpan").click(function(event) {

      $body = $("body");
      $body.addClass("loading");
      let data ={
                  nim_lama          : $('input[name=NIM_mahasiswa]').val(),
                  id_pd             : "<?php echo $data_mahasiswa[0]['id_pd'] ?>",
                  kode_jurusan_lama : "<?php echo $data_mahasiswa[0]['KodeJurusan'] ?>",
                  nimbaru           : "<?php echo $nim_baru ?>",
                  password          : "<?php echo $data_mahasiswa[0]['Password'] ?>",
                  Sex               : "<?php echo $data_mahasiswa[0]['Sex'] ?>",
                  namabaru          : $("#nama_baru").val(),
                  tempatlahir       : $("#tempat_lahir").val(),
                  tgllahir          : $("#example-date-input").val(),
                  namaibu           : $("#nama_ibu_kandung").val(),
                  emailbaru         : $("#Email").val(),
                  telpbaru          : $("#telp_baru").val(),
                  fakultas          : "<?php echo $KodeFakultas ?>",
                  jurusan           : "<?php echo $KodeJurusan_baru?>",
                  program           : $("#program option:selected").val(),
                  tahun_akademik    : "<?php echo $data_mahasiswa[0]['TahunAkademik'] ?>",
                  tahun_pindah      : $("#tahun_pindah option:selected").val(),
                  SKSditerima       : $("#SKSditerima").val(),
                  biaya_masuk_kuliah: $("#biaya_masuk_kuliah").val()
                }

    event.preventDefault();
      $.post(
          "<?php echo base_url('index.php/ademik/Mhswpindah/simpan_mahasiswa_pindah') ?>",data

        )
       .done(function (res) {
          $body.removeClass("loading");
          alert("Berhasil");
        //  console.log(res);
         // $("#load_content").hide();
        //  window.location.href = "<?php echo site_url('ademik/Mhswpindah') ?>";
       })
       .fail(function (err) {
        $body.removeClass("loading");
        alert("gagal");
        console.log(data);
        console.log(err);
         
         // $("#load_content").hide();
        //  window.location.href = "<?php echo site_url('ademik/Mhswpindah') ?>";
       })
    })
</script>