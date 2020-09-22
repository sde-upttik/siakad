  <dl class="row mt-2">
      <dt class="col-3">Waktu</dt>
      <dd class="col-9"><?= ": ". date("Y-m-d h:i:sa")?></dd>
      <dt class="col-3">Mata Kuliah</dt>
      <dd class="col-9"><?= ": ".$data_absen_mahasiswa[0]['NamaMK'] ?></dd>
      <dt class="col-3">Jumlah Pertemuan</dt>
      <dd class="col-9">
          <div class="row pl-3">
              <input type="number" name="jumlahPertemuan" class="col-2 form-control" id="jumlahPertemuan" max="36" min="1" required onkeyup="controlerJp()" onchange="controlerJp()">
              <span id="alertJumlahPertemuan" class="ml-2 badge badge-danger pt-3">  Jumlah pertemuan belum ditentukan ! </span>
          </div>
        <small><i>*Isi Jumlah Pertemuan lebih dulu</i></small>
      </dd>
  </dl>

  <hr>

  <table id="tabel_mahasiswaKumulatif" class="table_absen_mahasiswa table table-bordered table-hover display nowrap margin-top-10 table-responsive" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th align="center" >No</th>
        <th align="center" >NIM</th>
        <th align="center" >Nama Mahasiwa</th>
        <th align="center" >Jumlah Hadir</th>
        <th align="center" >Presentase</th>
      </tr>
    </thead>
    <tbody>
      <?php $no=1; foreach ($data_absen_mahasiswa as $mahasiswa ) {   ?>
      <tr>
        <td align="center"><?php echo $no?></td>
        <td><?php echo $mahasiswa['NIM']?></td>
        <td><?php echo $mahasiswa['nama_mahasiswa']?></td>

        <div class="form-group">
          <td>
              <input type="number" name="<?= $mahasiswa['NIM'] ?>" class="form-control inputJh" placeholder="Jumlah Hadir" max="36" min="0" id="jh_<?= $no ?>" onkeyup="calculating('<?= $no ?>')" disabled onchange="calculating('<?= $no ?>')">
          </td>
        </div>
        <td><font id="presentase_<?= $no ?>">Belum Terisi</font></td>
      </tr>
      <?php $no++; } ?>
    </tbody>
  </table>
  <input type="hidden"  name="IDJadwal" value="<?= $data_absen_mahasiswa[0]['IDJadwal'] ?>" >	
  <input type="hidden"  name="dateAbsen" value="<?= date("Y-m-d") ?>" >	
  <input type="hidden"  name="semester" value="<?= $semester ?>" >	
  <input type="hidden"  name="IDDosen" value="<?= $data_absen_mahasiswa[0]['IDDosen'] ?>" >	
<script>
	// $("#tabel_mahasiswaKumulatif").DataTable();
  $('#alertJumlahPertemuan').hide();

    function calculating(no){
        let jp = $('#jumlahPertemuan').val();
        let jh = $('#jh_'+no).val()

        if($('#jumlahPertemuan').val( ).length == 0){
            $('#alertJumlahPertemuan').show();
        }
        else{
            let presentase = (jh/jp)*100;

            var num           = Number(presentase); 
            var roundedString = num.toFixed(2);
            var rounded       = Number(roundedString);

            $('#presentase_'+no).html(rounded+"%")            
        }
    }

    function controlerJp() {
      if($('#jumlahPertemuan').val().length != 0){
            $('#alertJumlahPertemuan').hide();
            $('.inputJh').prop("disabled", false);
        }else{
            $('#alertJumlahPertemuan').show();
        }
    }

</script>