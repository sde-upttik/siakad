
<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-10">
        <div class="box box-solid">
          <div class="box-header with-border">
            <i class="fa fa-check-square-o text-black"></i>
            <h3 class="box-title">Formulir Dipensasi Pembyaran UKT</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">

            <div class="row">
              <!-- Mahasiswa -->
              <div class="col-md-6">
              <h5>data Mahasiswa</h5>
                <div class="form-group row">
                  <label for="name" class="col-sm-3 col-form-label">Nama</label>
                  <div class="col-md-8">
                    <input class="form-control" type="text" value="" id="name" name="name" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="nim" class="col-sm-3 col-form-label">Nim</label>
                  <div class="col-md-8">
                    <input class="form-control" type="text" value="" id="nim" name="nim" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="fakultas" class="col-sm-3 col-form-label">Fakultas</label>
                  <div class="col-md-8">
                    <input class="form-control" type="text" value="" id="fakultas" name="fakultas" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="prodi" class="col-sm-3 col-form-label">Prodi</label>
                  <div class="col-md-8">
                    <input class="form-control" type="text" value="" id="prodi" name="prodi" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="Semester" class="col-sm-3 col-form-label">Semester</label>
                  <div class="col-md-8">
                    <input class="form-control" type="text" value="" id="Semester" name="Semester" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="ukt" class="col-sm-3 col-form-label">Kelompok/BEsaran UKT</label>
                  <div class="col-md-4">
                    <input class="form-control" type="text" value="" id="ukt" name="kategori_ukt" placeholder="K ....">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="text" value="" id="ukt" name="nominal_ukt" placeholder="Rp. ....">
                  </div>
                </div>

              </div>
              <!-- orang tua -->
              <div class="col-md-6">
                <h5> Data Orang tua</h5>
                <div class="form-group row">
                  <label for="ayah" class="col-sm-3 col-form-label">Nama Orang tua/wali</label>
                  <div class="col-md-8">
                    <input class="form-control" type="text" value="" id="ayah" name="ayah">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="ttl" class="col-sm-3 col-form-label">Tempat/Tgl Lahir</label>
                  <div class="col-md-4">
                    <input class="form-control" type="text" value="" id="ttl" name="tempat">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="text" value="" id="ttl" name="tgl">
                  </div> 
                </div>
                <div class="form-group row">
                  <label for="nik" class="col-sm-3 col-form-label">NIK</label>
                  <div class="col-md-8">
                    <input class="form-control" type="text" value="" id="nik" name="nik">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="pekerjaanot" class="col-sm-3 col-form-label">Pekerjaan/Jenis Usaka</label>
                  <div class="col-md-8">
                    <input class="form-control" type="text" value="" id="pekerjaanot" name="pekerjaanot">
                  </div>
                </div>

              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                <label>Dengan ini mengajukan permohonan, kiranya dami dapat diberikan kebijakan  :</label>
                  <div class="checkbox">
                      <input type="radio" id="Checkbox_1" name="jKebijakan" value="1">
					            <label for="Checkbox_1">Pembebasan Sementara / Penundaan Pembayaran UKT</label>
                  </div>
                  <div class="checkbox">
                      <input type="radio" id="Checkbox_2" name="jKebijakan" value="2">
					            <label for="Checkbox_2">Pengurangan UKT</label>
                  </div>
                  <div class="checkbox">
                     <input type="radio" id="Checkbox_3" name="jKebijakan" value="3">
					          <label for="Checkbox_3">Perubahan Kelompok UKT</label>                      
                  </div>
                  <div class="checkbox">
                     <input type="radio" id="Checkbox_4" name="jKebijakan" value="4">
					          <label for="Checkbox_4">PEngangsuran UKT</label>                      
                  </div>

                </div>
                <div class="form-group">
                  <label>Alasan pengajuan kebijakan pembayaran uang kuliah tunggal</label>
                  <textarea class="form-control" rows="3" placeholder="Ketikkan alasan ..."></textarea>
                </div>
                <div class="form-group row">
                  <label for="slip" class="col-sm-4 col-form-label">Slip pembayaran ukt yang terakhir</label>
                  <div class="col-md-4">
                    <input class="form-control-file" type="file" value="" id="slip" name="slip">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="slip" class="col-sm-4 col-form-label">KTP Kepala keluarga</label>
                  <div class="col-md-4">
                    <input class="form-control-file" type="file" value="" id="slip" name="slip">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="slip" class="col-sm-4 col-form-label">Kartu keluarga</label>
                  <div class="col-md-4">
                    <input class="form-control-file" type="file" value="" id="slip" name="slip">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="slip" class="col-sm-4 col-form-label">Surat pernyataan Terdampak COVID-19 diketahui oleh orang tua</label>
                  <div class="col-md-4">
                    <input class="form-control-file" type="file" value="" id="slip" name="slip">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="slip" class="col-sm-4 col-form-label">Surat keterangan Terdampak COVID-19 dari desa atau kelurahan</label>
                  <div class="col-md-4">
                    <input class="form-control-file" type="file" value="" id="slip" name="slip">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="slip" class="col-sm-4 col-form-label">surat keterangan usaha atau keterangan pemberhentian hubungan kerja</label>
                  <div class="col-md-4">
                    <input class="form-control-file" type="file" value="" id="slip" name="slip">
                  </div>
                </div>
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

<script>
// let res;
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
       // Typical action to be performed when the document is ready:
      //  document.getElementById("demo").innerHTML = xhttp.responseText;
      console.log(xhttp.responseText);
    }
};
xhttp.open("GET", "<?= base_url('ademik/form_dispensasi_ukt/getData') ?>", true);
xhttp.send();

// console.log(res);
</script>