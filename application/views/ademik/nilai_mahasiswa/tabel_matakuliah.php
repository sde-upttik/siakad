<div class="box box-default tabel_mahasiswa">
  <div class="box-header with-border">
    <h3 class="box-title">DAFTAR MATAKULIAH</h3>
  </div>

  <div class="box-body">
    <div class="row">

      <div class="col-md-12 col-xs-12">

        <table id="tabel_jadwal" class="table table-bordered table-striped table-responsive nowrap">
          <thead>
            <tr>
              <th class="fixed-column">ID JADWAL</th>
              <th class="fixed-column">Kode Mata Kuliah</th>
              <th class="fixed-column">Nama Mata KUliah</th>
              <th class="fixed-column">Nama Dosen</th>
              <th class="fixed-column">Keterangan</th>
              <th class="fixed-column">Lihat Nilai</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data_jadwal as $jadwal) { ?>
                <tr>
                  <td><?php echo $jadwal['IDJADWAL']; ?></td>
                  <td><?php echo $jadwal['KodeMK']; ?></td>
                  <td><?php echo $jadwal['NamaMK']; ?></td>
                  <td><?php echo $jadwal['NamaDosen']; ?></td>
                  <td><?php echo $jadwal['Keterangan']; ?></td>
                  <td>
                    <button class="btn btn-primary" onclick='load_nilai_mahasiswa("<?php echo $jadwal['IDJADWAL']; ?>","<?php echo $jadwal['Tahun']; ?>")'>
                      <i class="fa fa-eye"></i>
                      Lihat Nilai Mahasiswa
                    </button>
                  </td>
                </tr>
            <?php } ?>
          </tbody>

        </table>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-lg modal_nilai_mahasiswa" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" >
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header" style="margin: 0px">
        <h5 class="modal-title" id="myLargeModalLabel">Nilai Mahasiswa</h5>
      </div>

      <div class="modal-body" style="padding-top: 0px" >
        <div id="tabel_nilai_mahasiswa"></div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-success waves-effect text-right pull-right" data-dismiss="modal">Kembali</button>
      </div>

    </div>
  </div>
</div>

<script>
  $("#tabel_jadwal").DataTable();
  

  function load_nilai_mahasiswa(IDJADWAL, tahun) {
    var url =  "<?php echo base_url('ademik/Mhsw_nilai2/get_nilai_mahasiswa')?>" ;

    $.post(
        url,
        {
          idjadwal : IDJADWAL,
          tahun    : tahun
        }
      ).done(function (data) {
        $(".modal_nilai_mahasiswa").modal('toggle');
        $("#tabel_nilai_mahasiswa").html(data);
      });

  }
</script>