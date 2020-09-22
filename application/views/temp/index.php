<style type="text/css">

  img {
    width: 500px;
    height: 500px;
  }

  .judul {
    font-size: 16px;
    font-weight: 600;
  }

  .ket {
    color: #999;
    font-size: 13px;
  }

  .modal-fullscreen {
    padding: 0 !important;
  }
  .modal-fullscreen .modal-dialog {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    max-width: 100%;
  }
  .modal-fullscreen .modal-content {
    height: auto;
    min-height: 100%;
    border: 0 none;
    border-radius: 0;
  }

</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <!-- <small>Control panel</small> -->
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url()?>/menu"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- boxes (Stat box) -->
	  <?php $jumlahlogin  = $this->session->userdata('jumlahlogin'); if ((!empty($this->session->flashdata('ubahpassword')) and $this->session->flashdata('ubahpassword') == "editpassword" ) or (!empty($jumlahlogin) and $jumlahlogin == "editpassword") ) { ?>
      <!-- <div class="modal fade bs-example-modal-lg infoNoHP" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true"> -->
      <div class="modal fade bs-example-modal-lg show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: block; padding-right: 17px;">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="myLargeModalLabel"><i class="fa fa-bullhorn"></i> Informasi</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div class="callout callout-success">
                <h4>PENGUMUMAN</h4>
                <p>Diharapkan seluruh Mahasiswa Aktif di Universitas Tadulako untuk mengisi biodata lengkap di SIAKAD, Terutama Nomor HP yang digunakan saat ini </p>
                
              </div>
            </div>
            <div class="modal-footer">  
              <a href="https://siakad2.untad.ac.id/ademik/Profil" class="btn btn-danger text-left"> Profile</a>
            </div>
          </div>
        </div>
      </div>

	  <div class="row">
        <div class="col">
          <div class="box">
            <div class="box-body">
              <div class="row">
                <div class="col-md-12 col-lg-12">
                  <!-- <h2 class="text-center">
                    <strong>Anda Masih Menggunakan Password Default, Silahkan Ganti Password Anda <a href="https://siakad2.untad.ac.id/ademik/Profil" style="color: blue;">Klik Disini</a></strong>
                  </h2> -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
	  <?php $data['status']=1;} ?>

      <div class="row">
        <div class="col-xl-3 col-md-6 col">
          <div class="info-box bg-blue">
            <span class="info-box-icon push-bottom"><i class="ion ion-ios-pricetag-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Tahun Akademik 20181</span>
              <span class="info-box-number">45 MK Terkirim</span>

              <div class="progress">
                <div class="progress-bar" style="width: 45%"></div>
              </div>
              <span class="progress-description">
                    Matakuliah Terkirim Ke DIKTI
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-xl-3 col-md-6 col">
          <div class="info-box bg-green">
            <span class="info-box-icon push-bottom"><i class="ion ion-ios-eye-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Tahun Akademik 20181</span>
              <span class="info-box-number">40 MK Gagal Terkirim </span>

              <div class="progress">
                <div class="progress-bar" style="width: 40%"></div>
              </div>
              <span class="progress-description">
                    Matakuliah Gagal Terkirim Ke DIKTI
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-xl-3 col-md-6 col">
          <div class="info-box bg-purple">
            <span class="info-box-icon push-bottom"><i class="ion ion-ios-cloud-download-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Tahun Akademik 20181</span>
              <span class="info-box-number">40 MK Belum Terkirim</span>

              <div class="progress">
                <div class="progress-bar" style="width: 40%"></div>
              </div>
              <span class="progress-description">
                    Matakuliah Belum di Kirim Ke DIKTI
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-xl-3 col-md-6 col">
          <div class="info-box bg-red">
            <span class="info-box-icon push-bottom"><i class="ion-ios-chatbubble-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Tahun Akademik 20181</span>
              <span class="info-box-number">KHS Terkirim</span>

              <div class="progress">
                <div class="progress-bar" style="width: 40%"></div>
              </div>
              <span class="progress-description">
                    KHS Terkirim Ke DIKTI
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col">
          <div class="box">
            <div class="box-body">
              <div class="row">
                <div class="col-md-7 col-lg-7">
                  <h2 class="text-center">
                    <strong>VISI & MISI UNIVERSITAS TADULAKO</strong>
                  </h2>
                  <h4 class="text-center">
                  	<strong>Visi</strong>
                  </h4>
                  <p style="padding: 0px 75px 0px 75px">“Pada tahun 2020 Universitas Tadulako unggul dalam pengabdian kepada masyarakat melalui pengembangan pendidikan dan penelitian.”</p>
                  <p style="padding: 0px 75px 0px 75px; color: red;">PERSEPSI VISI UNTAD</p>
                  	<ol type= "1" style="margin: 0px 200px 0px 75px;">
                  		<li><b>Unggul</b> yang bermakna memberikan layanan yang terbaik kepada Stakeholder dan mereka memperoleh kepuasan.</li>
                  		<li><b>Pengabdian</b> yang mengandung roh atau hakikat bukan sebagai aktifitas melainkan sebagai layanan yang dipersembahkan dimana Tri Dharma Perguruan Tinggi sebagai dimensinya.</li>
                  		<li><b>Masyarakat</b> adalah siapapun yang menjadi Stakeholder Universitas Tadulako.</li>
                  	</ol>
                  <p style="padding: 25px 75px 0px 75px;"><b>Unggul Dalam Pengabdian</b> adalah kepuasan pelanggan atas layanan Tri Dharma Perguruan Tinggi yang diberikan kepada Stakeholder Universitas Tadulako.</p>
                  <h4 class="text-center">
                  	<strong>Misi</strong>
                  </h4>
                  <p style="padding: 0px 75px 0px 75px;">Misi Universitas Tadulako sebagai berikut :</p>
                  <ol type= "1" style="margin: 0px 200px 0px 75px;">
                  	<li>Menyelenggarakan penidikan tinggi yang bermutu, modern, dan relevan dengan kebutuhan pembangunan bangsa;</li>
                  	<li>Menyelenggarakan penelitian yang bermutu untuk pengembangan ilmu pengetahuan, teknologi, dan/atau seni yang diabdikan bagi kesejahteraan masyarakat, bangsa, dan negara secara berkesinambungan;</li>
                  	<li>Menyelenggarakan pengabdian kepada masyarakat sebagai pemanfaatan hasil pendidikan dan hasil penelitian yang dibutuhkan dalam pembangunan masyarakat; dan</li>
                  	<li>Menyelenggarakan kerja sama dengan pihak lain yang saling menguntungkan, tanpa adanya ikatan oleh haluan politik, kepercayaan, dan agama.</li>
                </div>


                <?php
                  if ( $this->session->userdata('ulevel') == 1 OR $this->session->userdata('ulevel') == 5 ) {
                ?>

                <div class="col-md-5 col-lg-5">
                  <h4 class="text-center">
                    <strong>Admin Penanggung Jawab SIAKAD Baru</strong>
                  </h4>
                  <div class="row">
                    <div class="col-sm-6">
                      <!-- Progress bars -->
                      <p><b>Rocky (Penanggung Jawab SIAKAD)</b><br><i class="fa fa-fw fa-whatsapp"></i>0852-9888-2009</p>
                      <li>Matakuliah Perjenis</li>
                      <li>Matakuliah Persemester</li>
                      <li>Kurikulum</li>
                      <li>KRS Mahasiswa</li>
                      <li>Biodata Mahasiswa</li><br>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                      <p><b>Fadly</b><br><i class="fa fa-fw fa-whatsapp"></i>0822-6015-9013</p>
                      <li>Absensi</li>
                      <li>Mahasiswa Cuti</li>
                      <li>Mahasiswa Pindah</li>
                      <li>Master TTD</li><br>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <!-- Progress bars -->
                      <p><b>Michael</b><br><i class="fa fa-fw fa-whatsapp"></i>0822-5937-1558</p>
                      <li>KKN</li>
                      <li>Verifikasi Nilai Kliring (P3S)</li>
                      <li>Kliring Nilai Mahasiswa</li>
                      <li>Nilai Transfer</li><br>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                      <p><b>Inal</b><br><i class="fa fa-fw fa-whatsapp"></i>0822-3782-7550</p>
                      <li>Semester Akademik</li>
                      <li>Aktivitas Mahasiswa</li>
                      <li>Cetah KHS Perprodi 2</li>
                      <li>Ruang Kelas</li><br>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <!-- Progress bars -->
                      <p><b>Ezra</b><br><i class="fa fa-fw fa-whatsapp"></i>0852-4276-9992</p>
                      <li>Translate Matakuliah</li>
                      <li>Proses Pembayaran (SPP2)</li>
                      <li>Merubah Bobot</li>
                      <li>Penjadwalan</li>
                      <li>Batas KRS</li><br>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                      <p><b>Jam Kerja : </b></p>
                      <li>Senin - Kamis : 08:00 - 16:00</li>
                      <li>Jumat : 08:00 - 16:30</li>
                      Kami Hanya Melayani Admin Fakultas dan Admin Prodi, untuk panduan Teknis, Trimakasih
                    </div>
                  </div>
                </div>

                <?php
                }
                ?>

                <!-- /.row -->
              </div>
              <!-- ./box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
      </div>



      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-xl-6 connectedSortable">
          <!-- interactive chart -->
          <!-- TO DO List -->
          <div class="box">
            <div class="box-header">

              <?php
                $urutan = 1;
                $urutantgl = 1;
                foreach ($berita as $tampil) { ?>

                <div class="box-body">
                  <div>
                    <span class="judul"><?= $tampil->Judul; ?></span><br>
                    <span class="ket">Posting By <?= $tampil->Author; ?> | <?= $tgl[$urutantgl++] ?></span>
                  </div>
                  <div class="attachment-block clearfix">
                    <?php if ( empty($tampil->foto_berita) ) { ?>
                      <img class="attachment-img" src="<?=base_url();?>assets/images/Berita/notimages.jpg" alt="Attachment Image">
                    <?php } else  { ?>
                      <img class="attachment-img" src="<?=base_url();?>assets/images/Berita/<?= $tampil->foto_berita; ?>" alt="Attachment Image">
                    <?php } ?>

                    <div class="attachment-pushed">
                      <div class="attachment-text">
                        <?= $konten[$urutan++] ;?>...
                        <a title="Klik untuk Membaca Berita" href="<?=base_url();?>ademik/Berita/halaman_berita/<?= $tampil->ID ?>"><span style="color: red;">more</span></a>
                      </div>
                    </div>
                  </div>
                </div>

              <?php } ?>

            </div>
          </div>
        </section>
        <!-- /.Left col -->

        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-xl-6 connectedSortable">

            <div class="box box-info">
              <?php
                if ( $this->session->userdata('ulevel') == "" ) {
              ?>
              <div class="box-header">
              	<h5 class="text-center">
                      <strong>PENGUMUMAN</strong>
                </h5>
                <div class="attachment-block clearfix">
                    
                </div>
              </div>
              <?php
                } else if ( $this->session->userdata('ulevel') == 1 OR $this->session->userdata('ulevel') == 4 OR $this->session->userdata('ulevel') == 5 OR $this->session->userdata('ulevel') == 7) { ?>
              <div class="box-header">
              	<h4 class="text-center">
                  <strong>TUTORIAL PENGGUNAAN SIAKAD</strong>
                </h4>
                <h3 class="text-center">
                  <strong>Mahasiswa Harus Mandiri Ber KRS<br><i>say to no for GAPTEK</i></strong>
                </h3>
                <div class="attachment-block clearfix" align="center">
                  Cara Reset Password
                  <iframe width="690" height="388" src="https://www.youtube.com/embed/47z0v-J1uTM" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="attachment-block clearfix" align="center">
                  <a title="See All Video" href="https://www.youtube.com/channel/UClHMdi-O34cHoG8sTK1tuZA/videos?view_as=subscriber"><span style="color: red;">See All Video from Youtube</span></a>
                </div>
                <!-- <div class="attachment-block clearfix" align="center">
                  KRS Mahasiswa - Error Import KHS ke DIKTI
                  <iframe width="690" height="388" src="https://www.youtube.com/embed/PcZTBKYxuc8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="attachment-block clearfix" align="center">
                  Untuk Mahasiswa Baru
                  <iframe width="690" height="388" src="https://www.youtube.com/embed/VhHP0rcwc7k" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="attachment-block clearfix" align="center">
                  KRS Mahasiswa - Message Error Pada Saat Ber KRS
                  <iframe width="690" height="388" src="https://www.youtube.com/embed/6mw3Pn1KOX8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div> -->
              </div>
              <?php 
                } 
              ?>
              <!-- right col -->
            </div>

          </section>
        <!-- /.content -->
      </div>
