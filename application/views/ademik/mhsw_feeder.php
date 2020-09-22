 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Tables Aktivitas Mahasiswa
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="">Tables</a></li>
        <li class="breadcrumb-item active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
         
         <div class="box">
            <div class="box-header">
              <h3 class="box-title">AKTIVITAS MAHASISWA</h3>
            </div>

            	<div class="box-header">
              	<a href="" class="btn btn-info btn-flat" data-toggle="modal" data-target="#tambahdata">
                  <i class="fa fa-plus-circle"></i> Aktivitas Mahasiswa </a>
            	</div>

              <!-- <div class="modal fade" id="tambahdata">
                <div class="modal-dialog">
                  <div class="modal-content">
                      <?php 
                        $this->load->view('ademik/mhsw_feeder_tmb');
                       ?>
                  </div>
                </div>
              </div> -->
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped table-responsive">
                <thead>
        					<tr>
                    <th>ID Aktivitas Mahasiswa</th>
        						<th>ID Smt</th>
        						<th>Judul Aktivitas Mahasiswa</th>
        						<th>Lokasi Kegiatan</th>
        						<th>SK Tugas</th>
        						<th>TGL SK tugas</th>
        						<th>KET Aktivitas</th>
        						<th>A Komunal</th>
        						<th>ID JENIS AKTIVITAS MAHASISWA</th>
        						<th>ID SMS</th>
        					</tr>
        				</thead>
        				<tbody>
        					<?php foreach ($terserah_tampil as $da) { ?>
                    <tr>  
          						<td><?php echo $da['id_akt_mhs']; ?></td>
          						<td><?php echo $da['id_smt']; ?></td>
          						<td><?php echo $da['judul_akt_mhs']; ?></td>
          						<td><?php echo $da['lokasi_kegiatan']; ?></td>
          						<td><?php echo $da['sk_tugas']; ?></td>
          						<td><?php echo $da['tgl_sk_tugas']; ?></td>
          						<td><?php echo $da['ket_akt']; ?></td>
          						<td><?php echo $da['a_komunal']; ?></td>
          						<td><?php echo $da['id_jns_akt_mhs']; ?></td>
          						<td><?php echo $da['id_sms']; ?></td>
          					</tr>
                  <?php } ?>
        				</tbody>
              </table>
            </div>
          </div>         
       
        </div>
      </div>
    </section>

    <div class="modal fade" id="tambahdata" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Tambah Aktivitas Mahasiswa</h4>
        </div>

        <form action="<?php echo base_url().'ademik/mhsw_feeder/insert_data' ?>" method="POST">
          <div class="modal-body">    
          <label style="margin-bottom: 0px;">ID AKTIVITAS MAHASISWA</label>
            <div class="form-group">
                <input class="form-control" name="id_akt_mhs" value="" placeholder="Id Aktivitas Mahasiswa">
            </div>

            <label style="margin-bottom: 0px;">ID SEMESTER</label>
            <div class="form-group">
                <input class="form-control" name="id_smt" value="" placeholder="Id Semester">
            </div>

            <label style="margin-bottom: 0px;">JUDUL AKTIVITAS MAHASISWA</label>
            <div class="form-group">
                <input class="form-control" name="jdl_akt_mhs" value="" placeholder="Judul Aktivasi Mahasiswa">
            </div>

            <label style="margin-bottom: 0px;">LOKASI KEGIATAN</label>
            <div class="form-group">
                <input class="form-control" name="lks_kgt" value="" placeholder="Lokasi Kegiatan">
            </div>

            <label style="margin-bottom: 0px;">SK TUGAS</label>
            <div class="form-group">
                <input class="form-control" name="sk_tgs" value="" placeholder="SK Tugas">
            </div>

            <label style="margin-bottom: 0px;">TGL SK TUGAS</label>
            <div class="form-group">
                <input class="form-control" type="date" name="tgl_sk_tgs" value="" placeholder="Tgl SK Tugas">
            </div>

            <label style="margin-bottom: 0px;">KETERANGAN AKTIVITAS</label>
            <div class="form-group">
                <input class="form-control" name="ket_akt" value="" placeholder="Ket Aktivitas">
            </div>

            <label style="margin-bottom: 0px;">A KOMUNAL</label>
            <div class="form-group">
                <input class="form-control" name="a_komunal" value="" placeholder="A Komunal">
            </div>

            <label style="margin-bottom: 0px;">ID JENIS AKTIVITAS MAHASISWA</label>
            <div class="form-group">
                <input class="form-control" name="id_jns_akt_mhs" value="" placeholder="Id Jenis Aktivitas Mahasiswa">
            </div>

            <label style="margin-bottom: 0px;">ID SMS</label>
            <div class="form-group">
                <input class="form-control" name="id_sms" value="" placeholder="Id Sms">
            </div>
          
        <div class="modal-footer">
            <button class="btn btn-danger" type="submit"> Simpan&nbsp;</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"> Batal</button>
        </div>
        </form>
        </div>
      </div>
      </div>

  </div>
  
  
  
  <script src="<?=base_url()?>assets/js/pages/data-table.js"></script>