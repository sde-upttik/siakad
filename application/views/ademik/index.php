<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>UNTAD
        <small>Selamat Datang di Sistem Informasi Akademik</small>
      </h1>
      <!-- <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url()?>#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-xl-6 connectedSortable">
          <!-- interactive chart -->
          <!-- TO DO List -->
          <div class="box">
            <div class="box-header">
              <i class="fa fa-user-circle-o"></i>

              <h3 class="box-title">Login Page</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="login-box">
                <div class="login-logo">
                  <b>Login</b>
                </div>
                <!-- /.login-logo -->
                <div class="login-box-body">
                  <p class="login-box-msg">Sign in</p>
                <span class="login-box-msg" style='color:red'><?=$this->session->flashdata('konfirmasi')?></span>
                  
                  <form action="<?=base_url()?>prc/prc_login" method="post" class="form-element" id="frm-login">
                    <div class="form-group has-feedback">
                      <input type="text" name="username" id="username" class="form-control" placeholder="Username" maxlength="20" size="15" class="required">
                      <span class="ion ion-email form-control-feedback"></span><span id="confirm_username"></span>
                    </div>
                    <div class="form-group has-feedback">
                      <input type="password" name="password" id="password" class="form-control" placeholder="Password" maxlength="20" size="15" class="required">
                      <span class="ion ion-locked form-control-feedback"></span><span id="confirm_password"></span>
                    </div>
                  <div class="form-group text-center">
                      <label>Login Sebagai : </label>
                      <select name="loguser" class="form-control">
                    <option value="">---- Silahkan Pilih ----</option>
                          <option value="<?= $this->encryption->encrypt('_v2_dosen'); ?>">Dosen</option>
                    <option value="<?= $this->encryption->encrypt('_v2_mhsw'); ?>">Mahasiswa</option>
                      </select>
                    </div>
                    <!-- <div class="row">
                      <div class="col-6">
                        <div class="checkbox">
                          <input type="checkbox" id="basic_checkbox_1" >
                    <label for="basic_checkbox_1">Remember Me</label>
                        </div>
                      </div> -->
                      <!-- /.col -->
                      <!-- <div class="col-6">
                      <div class="fog-pwd">
                          <a href="javascript:void(0)"><i class="ion ion-locked"></i> Forgot pwd?</a><br>
                        </div>
                      </div> -->
                      <!-- /.col -->
                      <div class="col-12 text-center">
                        <button type="submit" class="btn btn-info btn-block btn-flat margin-top-10">SIGN IN</button>
                      </div>
                      <!-- /.col -->
                    </div>
                  </form>

                  <!-- <div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-social-icon btn-circle btn-facebook"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="btn btn-social-icon btn-circle btn-google"><i class="fa fa-google-plus"></i></a>
                  </div> -->
                  <!-- /.social-auth-links -->

                  <!-- <div class="margin-top-30 text-center">
                    <p>Don't have an account? <a href="register.html" class="text-info m-l-5">Sign Up</a></p>
                  </div> -->

                </div>
                <!-- /.login-box-body -->
              </div>
              <!-- /.login-box -->

            </div>
            <!-- /.box-body -->
          <!-- </div> -->
          <!-- /.box -->

        </section>
        <section class="col-xl-6 connectedSortable">
        
          <div class="box">
            <div class="box-header">
              <i class="fa fa-bullhorn"></i>

              <h3 class="box-title">Pengumuman</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div>
                <h6 class="text-center">Kuota Internet Gratis</h6>
                <div style="display: block; margin: 0 auto; text-align: center;">
                  <img src="https://lh3.googleusercontent.com/ktg7dfCgLcdUJ5X7GqN2cD69KDI6T0AoG1Z7Nt22BPoTZFohS-aP1vjbFrxaWEN43A" width="70" style="margin: 0 auto;" alt="Telkomsel">
                  <img src="https://upload.wikimedia.org/wikipedia/id/thumb/c/c0/Indosat_Ooredoo_logo.svg/1200px-Indosat_Ooredoo_logo.svg.png" width="70" style="margin: 0 auto;" alt="Indosat">
                  <img src="https://upload.wikimedia.org/wikipedia/id/thumb/6/68/3-brand.svg/1200px-3-brand.svg.png" width="70" style="margin: 0 auto;" alt="Tri Indonesia">
                  <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/83/Axis_logo_2015.svg/1200px-Axis_logo_2015.svg.png" width="70" style="margin: 0 auto;" alt="Axis">
                  <img src="https://d17e22l2uh4h4n.cloudfront.net/corpweb/pub-xlaxiata/2019-03/xl-logo.png" width="70" style="margin: 0 auto;" alt="XL">
                  <img src="https://asset.kompas.com/crops/Cr1FCyYAQAkE7HgP_1B4k4iNJGc=/24x16:1192x795/750x500/data/photo/2019/03/25/1528754582.png" width="70" style="margin: 0 auto;" alt="Smartfren">
                </div>
                <br>
                <p>
                  Diharapkan seluruh Mahasiswa memperbarui Biodata yang Valid terutama NIK dan Nomor HP.<br>Nomor HP yang diperbarui di SIAKAD harus teregistrasi sesuai dengan NIK (Nomor Induk Kependudukan) yang didaftar di SIAKAD untuk mendapatkan Kuota Internet gratis dari KEMDIKBUD
                </p>
              </div>
              <hr>
              <div>
                <h6 class=" text-center">Login Ganjil Genap</h6>
                <p>Sehubungan dengan pelaksanaan penginputan nilai dan krs mahasiswa Universitas Tadulako tahun ajaran genap 2019/2020 maka diinformasikan untuk melakukan sistem login ganjil / genap dengan jadwal sebagai berikut : </p>
                <ul>
                
                  <li>Tanggal <b>Ganjil</b> : <span class="<?= (date('d')%2)==0? "text-red":"text-green" ?>">FKIP, PASCASARJANA, KESMAS. </span> </li>
                  <li>Tanggal <b>Genap</b>  : <span class="<?= (date('d')%2)==1? "text-red":"text-green" ?>">FISIP, FEKON, FAKUM, FAHUT, FAPERTA, FATEK, KAMPUS 2 MOROWALI, KAMPUS 2 TOUNA, KEDOKTERAN, FAPETKAN </span> </li>
                </ul>
              </div>
            </div>
          </div>
        </section>
        <!-- /.Left col -->

        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <!-- <section class="col-xl-6 connectedSortable"> -->
          <!-- Calendar -->
          <!-- <div class="box box-solid bg-blue">
            <div class="box-header">
              <i class="fa fa-calendar"></i>

              <h3 class="box-title">Calendar</h3> -->
              <!-- tools box -->
              <!-- <div class="pull-right box-tools"> -->
                <!-- button with a dropdown -->
                <!-- <div class="btn-group">
                  <button type="button" class="btn btn-white btn-sm dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bars"></i></button>
                  <ul class="dropdown-menu pull-right" role="menu">
                    <li><a href="<?=base_url()?>#">Add new event</a></li>
                    <li><a href="<?=base_url()?>#">Clear events</a></li>
                    <li class="divider"></li>
                    <li><a href="<?=base_url()?>#">View calendar</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-white btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-white btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div> -->
              <!-- /. tools -->
            <!-- </div> -->
            <!-- /.box-header -->
            <!-- <div class="box-body no-padding"> -->
              <!--The calendar -->
              <!-- <div id="calendar" style="width: 100%"></div>
            </div> -->
            <!-- /.box-body -->
            <!-- <div class="box-footer text-black">
              <div class="row">
                <div class="col-sm-6">
                  Progress bars
                  <div class="clearfix">
                    <span class="pull-left">Task #1</span>
                    <small class="pull-right">30%</small>
                  </div>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-blue" style="width: 30%;"></div>
                  </div>

                  <div class="clearfix">
                    <span class="pull-left">Task #2</span>
                    <small class="pull-right">90%</small>
                  </div>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-blue" style="width: 90%;"></div>
                  </div>
                </div> -->
                <!-- /.col -->
                <!-- <div class="col-sm-6">
                  <div class="clearfix">
                    <span class="pull-left">Task #3</span>
                    <small class="pull-right">40%</small>
                  </div>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-blue" style="width: 40%;"></div>
                  </div>

                  <div class="clearfix">
                    <span class="pull-left">Task #4</span>
                    <small class="pull-right">60%</small>
                  </div>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-blue" style="width: 60%;"></div>
                  </div>
                </div> -->
                <!-- /.col -->
              <!-- </div> -->
              <!-- /.row -->
           <!--  </div>
          </div> -->
          <!-- /.box -->

        <!-- </section> -->
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
