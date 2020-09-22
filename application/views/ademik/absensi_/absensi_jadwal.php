        <?php 
            if (empty($data_jadwal)) {
              $Tahun          = "";
              $Program        = "";
              $KodeJurusan    = "";
              $status         = "0";
            }else{
              $Tahun          = $data_jadwal[0]['Tahun'];
              $Program        = $data_jadwal[0]['Program'];
              $KodeJurusan    = $data_jadwal[0]['KodeJurusan'];
              $status         = "1";
            }
         ?>
        
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Semester Akademik</h3>
            </div>

            <div class="box-body">
              <div class="row">

                <div class="col-md-12 col-xs-12">

                  <table id="tableJadwal_2" class="table table-bordered table-striped table-responsive nowrap dt-head-right ">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>ID jadwal</th>
                        <th>Kode MK</th>
                        <th>Mata Kuliah</th>
                        <th>kelas</th>
                        <th>Dosen</th>
                        <th>Tahun</th>
                        <th>Mahasiswa</th>
                        <th>Absen</th>
                        <th>Validasi</th>
                        <th>Tanggal Validasi</th>   
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no=1; foreach ($data_jadwal as $jadwal) { ?>
                      <tr>
                        <td><?php echo $no; ?></td> 
                        <td><?php echo $jadwal['IDJADWAL'] ?></td>   
                        <td>
                          <a href="#" style="color: red" onclick="absen_dosen_1('<?= $jadwal['IDJADWAL']; ?>', '<?= $Tahun; ?>')">
                            <?php echo $jadwal['KodeMK']; ?>
                          </a>
                        </td>
                        <td><?php echo $jadwal['NamaMK']; ?></td>
                        <td><?php echo $jadwal['keterangan']; ?></td>
                        <td>
                          <?php 
                            echo $jadwal['Name'];
                          ?>
                        </td>
                        <td><?php echo $jadwal['Tahun']; ?></td>
                        <td><?php echo $jadwal['jumlah_mahasiswa']; ?></td>
                        <td>
                          <?php if ($jadwal['IDJADWAL'] != null): ?>
                            <button class="btn btn-primary" id="absen_dosen" onclick="absen_dosen_1('<?= $jadwal['IDJADWAL']; ?>', '<?= $Tahun; ?>')">Isi Absen</button>
                          <?php endif ?>
                        </td>
                        <td>
                          <?php if ($jadwal['IDJADWAL'] != null){
                              if ($jadwal['validasi']=="1") {
                          ?>
                            Sudah Divalidasi 
                          <?php }else{ ?>
                            <button class="btn btn-warning" onclick="validasi_jadwal('<?php echo $jadwal['IDJADWAL']; ?>')">Validasi</button>
                          <?php }} ?>
                        </td>
                        <td><?php echo $jadwal['TglVal']; ?></td>
                      </tr>
                      <?php $no++; } ?>
                    </tbody>
                  </table>

              </div>
            </div>
          </div>
      

<script type="text/javascript">

  $('#tableJadwal_2').DataTable();
  var status = <?php echo $status ?>;

  if (status == 0) {
    Swal({
      type  : 'error',
      title : 'Oops...',
      text  : 'Data tidak ditemukan !',
    })  
  }else{
    Swal({
      type  : 'success',
      title : 'Success',
      text  : 'Data ditemukan !',
      showConfirmButton: false,
      timer: 1000
    }) 
  }

  function validasi_jadwal(IDJadwal) {
    var url         = "<?php echo base_url('index.php/ademik/Absensi/validasi_jadwal')?>";
    var Tahun       = "<?php echo $Tahun ?>";
    var Program     = "<?php echo $Program ?>";
    var KodeJurusan = "<?php echo $KodeJurusan ?>";

    loading_alert();
      $.post(
        url,
        {
          IDJADWAL    : IDJadwal,
          Tahun       : Tahun,
          Program     : Program,
          KodeJurusan : KodeJurusan,
      })
      .done(function (data) {
        swal.closeModal();
        success_alert();
        $("#jadwal_matakuliah").html(data);
      });
  }
</script>