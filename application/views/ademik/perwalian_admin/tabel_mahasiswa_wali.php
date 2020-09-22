<div class="content-wrapper">

  <section class="content-header">
    <h4 class="box-title"><i class="fa fa-users"></i> Mahasiswa Wali</h4>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="breadcrumb-item"><a href="#">Mahasiswa</a></li>
      <li class="breadcrumb-item active">Perwalian Mahasiswa</li>
    </ol>
  </section>

  <section class="content row " style="padding-bottom: 0;">
    <div class="box box-default tabel_mahasiswa">
      <div class="box-header">
        <h5> Daftar Mahasiswa wali semester aktif ( <?= semester_aktif() ?> ) </h5>
      </div>

      <div class="box-body">

        <div class="row">
          <div class="col-md-12 col-xs-12 ">

            <table id="table_mahasiswa_wali" class="table table-striped table-responsive nowrap">
              <thead>
                <tr>
                  <th class="fixed-column">#</th>
                  <th class="fixed-column">NIM</th>
                  <th class="fixed-column">Angkatan</th>
                  <th class="fixed-column">Nama</th>
                  <th class="fixed-column">Status</th>
                  <th class="fixed-column">SKS</th>
                  <th class="fixed-column">MK diterima</th>
                  <th class="fixed-column">MK ditolak</th>
                  <th class="fixed-column">validasi</th>
                </tr>
              </thead>

              <tbody>
                <?php $no=1; foreach ($mahasiswa_wali as $mhsw) { ?>
                <tr>
                  <td><?= $no?></td>
                  <td><?= $mhsw['NIM']?></td>
                  <td><?= $mhsw['TahunAkademik']?></td>
                  <td><?= $mhsw['Name']?></td>
                  <td><?= status($mhsw['Status'])?></td>
                  <td><?= $mhsw['sks']?></td>
                  <td><?= $mhsw['mk_diterima']?></td>
                  <td><?= $mhsw['mk_ditolak']?></td>
                  <td>
                    <button class="btn btn-warning"><i class="fa fa-copy"></i> Lihat Matakuliah</button>
                  </td>
                </tr>
                <?php $no++;} ?>
              </tbody>

            </table>
          </div>
        </div>
      </div>

      <form id="myform">
        <div class="modal fade bs-example-modal-lg form_mahasiswa_wali" tabindex="-1" role="dialog"
          aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
          <div class="modal-dialog modal-lg">

            <div class="modal-content">

              <div class="modal-header" style="margin: 0px">
                <h5 class="modal-title" id="myLargeModalLabel"> <i class="fa fa-book"></i>  Detail Matakuliah yang diambil</h5>
              </div>

              <div class="modal-body" style="padding-top: 0px">
                <div id="modal_mahasiswa_wali"></div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect text-center pull-right col-md-12"
                  data-dismiss="modal" onclick="load_tabel_mahasiswa_wali()"><i class="fa fa-save"></i>
                  Simpan</button>
              </div>

            </div>
          </div>
        </div>
      </form>

    </div>

  </section>


</div>
