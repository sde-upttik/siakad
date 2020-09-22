<div class="content-wrapper">

    <section class="content-header">
      <h1>
        Monitoring Skripsi
      </h1>

      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('/menu/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="#">Kliring</a></li>
        <li class="breadcrumb-item active">Kliring nilai mhsw 2</li>
      </ol>
    </section>

    <section class="content" style="padding-bottom: 0; height: 100%">
        
        <!-- Form Pecarian Jadwal -->
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-book"></i> Form Pengajuan Skripsi </h3>
          </div>

          <div class="box-body">
            <form>
                <div class="form-group ">
                  <label>Judul Skripsi </label>
                  <input type="text" name="judulTA" class="form-control">
                </div>


                <div class="form-group ">
                  <label>Pembimbing 1  </label>
                  <input type="text" name="pembimbing1" class="form-control">
                </div>


                <div class="form-group ">
                  <label>pembimbing 2 </label>
                  <input type="text" name="pembimbing1" class="form-control">
                </div>


                <div class="form-group ">
                  <label>Tanggal Disetujui </label>
                  <input type="date" name="tglDisetujui" class="form-control">
                </div>

                <div class="form-group ">
                  <label>No SK Pembimbing </label>
                  <input type="text" name="pembimbing1" class="form-control">
                </div>


                <div class="form-group ">
                  <label>Tanggal SK Pembimbing</label>
                  <input type="date" name="pembimbing1" class="form-control">
                </div>

                <div class="form-group ">
                  <button class="btn btn-primary"> <i class="fa fa-print"></i> Cetak SK Pembimbing</button>
                  <a href="<?= base_url('ademik/Skripsi/seminarSkripsi')?>" class="btn btn-primary"> <i class="fa fa-print"></i> Seminar Skripsi</a>
                </div>

            </form>
          </div>
    </section>

</div>

