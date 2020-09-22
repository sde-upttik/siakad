<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			RULES SIAKAD SETIAP TAHUN
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="breadcrumb-item"><a href="<?= $_SESSION['tamplate'] ?>">Rules</a></li>
		</ol>
	</section>

	<div class="pad margin no-print">
      <div class="callout callout-success" style="margin-bottom: 0!important;">
        <h4><i class="fa fa-info"></i> Note:</h4>
        Halaman ini hanya digunakan oleh admin superuser, untuk membuat rule pada setiap tahun semester berjalan.
      </div>
    </div>

		<div class="pad margin no-print">
			<?php if (!empty($this->session->flashdata('status'))) { ?>
				<div class="callout callout-success" style="margin-bottom: 0!important;">
	        <h4><i class="fa fa-info"></i> <?= $this->session->flashdata('status') ?></h4>
	      </div>
			<?php } ?>
	  </div>

    <!-- Main content -->
    <section class="invoice printableArea">
      <!-- title row -->
      <div class="row">
        <div class="col-12">
          <h2 class="page-header">
            List Kerja Admin Superuser Pada Tahun..........
            <small class="pull-right">Date: ............... </small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-6 invoice-col">
          Username :
          <address>
            <strong class="text-red">Nama Lengkap : </strong><br>
            Email : <br>
            Alamat : <br>
            Telp
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-6 invoice-col text-right">
          <?=$this->session->userdata('uname')?>
          <address>
            <strong class="text-blue">.............</strong><br>
            ................<br>
            ................<br>
            ................
		  </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-12 invoice-col">
			<div class="invoice-details row no-margin">
			  <div class="col-md-6 col-lg-3"><b>Proses </b>Pada Awal Tahun Akademik</div>
			</div>
		</div>
      <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-12 table-responsive">
			<p id="tagprogressbar"></p>
            <div class="progress">
				<div class="progress-bar progress-bar-danger progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
				  <span class="sr-only">60% Complete (warning)</span>
				</div>
			</div>
          <table class="table table-striped">
            <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Image Action</th>
              <th class="text-right">Action</th>
              <th class="text-right">Keterangan</th>
			  <th class="text-right">User Proses</th>
			  <th class="text-right">Tanggal Proses</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>1</td>
              <td>Buka Periode Aktif</td>
              <td>Image</td>
              <td class="text-right"><a href="#"><button data-toggle="modal" data-target="#modal-priodeaktif" class="btn btn-social-icon btn-circle btn-bitbucket"><i class="fa fa-bitbucket"></i></button></a></td>
			  <td class="text-right">Berfungsi untuk membuka periode aktif pada setiap tahun akademik baru dan bertujan untuk melakukan proses rekap mahasiswa aktif, cuti atau tidak aktif pada tahun akdemik baru</td>
              <td class="text-right"> - </td>
              <td class="text-right"> - </td>
            </tr>
			<?php
				if (!empty($detailperiodeaktif->periode_aktif)){
					$link = $detailperiodeaktif->periode_aktif;
				}
			?>
            <tr>
              <td>2</td>
              <td>Set 0 (nol) Status Bayar (Tbl Mahasiswa)</td>
              <td>Image</td>
              <td class="text-right"><a href="<?=base_url('ademik/siakad_years/prcstatbayar/'.$link)?>"><button class="btn btn-social-icon btn-circle btn-bitbucket"><i class="fa fa-bitbucket"></i></button></a></td>
              <td class="text-right">Berfungsi untuk mengupdate semua statusbayar pada tabel mahasiswa menjadi 0 (nol), ini bertujuan untuk misahkan mahasiswa yang membayar dan belum membayar, kecuali mahasiswa yang sudah LULUUS</td>
              <td class="text-right"><?=$detailperiodeaktif->point2_user;?></td>
              <td class="text-right"><?=$detailperiodeaktif->point2_tgl;?></td>
            </tr>
            <tr>
              <td>3</td>
              <td>Proses SPC to SIAKAD</td>
              <td>Image</td>
              <td class="text-right"><button onclick="updstatbayar()"  class="btn btn-social-icon btn-circle btn-bitbucket"><i class="fa fa-bitbucket"></i></button></td>
              <td class="text-right">Berfungsi untuk mengambil data mahasiswa yang telah membayar uang kuliah tungggal (UKT) pada aplikasi SPC</td>
              <td class="text-right"><?=$detailperiodeaktif->point3_user;?></td>
              <td class="text-right"><?=$detailperiodeaktif->point3_tgl;?></td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- info row -->
      <div class="row invoice-info">
        <!-- /.col -->
        <div class="col-sm-12 invoice-col">
			<div class="invoice-details row no-margin">
			  <div class="col-md-6 col-lg-3"><b>Proses </b>Jika Waktu KRS Berakhir</div>
			</div>
		</div>
      <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
			  <th>#</th>
              <th>Name</th>
              <th>Image Action</th>
              <th class="text-right">Action</th>
              <th class="text-right">Keterangan</th>
			  <th class="text-right">User Proses</th>
			  <th class="text-right">Tanggal Proses</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>4</td>
              <td>Mahasiswa Bayar UKT dan Tidak KRS (BTK)</td>
              <td>Image</td>
              <td class="text-right"><a href="<?=base_url('ademik/siakad_years/update_statbayar')?>"><button class="btn btn-social-icon btn-circle btn-bitbucket"><i class="fa fa-bitbucket"></i></button></a></td>
              <td class="text-right">Berfungsi memproses dan mengetahui mahasiswa yang membayar tapi tidak ber KRS pada Tahun Akademik Aktif</td>
              <td class="text-right"><?=$detailperiodeaktif->point4_user;?></td>
              <td class="text-right"><?=$detailperiodeaktif->point4_tgl;?></td>
            </tr>
            <tr>
              <td>5</td>
              <td>Mahasiswa Tidak Bayar UKT dan ber KRS (BBSK)</td>
              <td>Image</td>
              <td class="text-right"><a href="<?=base_url('ademik/siakad_years/update_statkrs')?>"><button class="btn btn-social-icon btn-circle btn-bitbucket"><i class="fa fa-bitbucket"></i></button></a></td>
              <td class="text-right">Berfungsi memproses dan mengetahui mahasiswa yang tidak membayar tapi ber KRS pada Tahun Akademik Aktif, bisa jadi mahasiswa mendapatkan BIDIKMISI atau BEASISWA</td>
              <td class="text-right"><?=$detailperiodeaktif->point5_user;?></td>
              <td class="text-right"><?=$detailperiodeaktif->point5_tgl;?></td>
            </tr>
            <tr>
              <td>6</td>
              <td>Proses Mahasiswa Drop Out</td>
              <td>Image</td>
              <td class="text-right"><button class="btn btn-social-icon btn-circle btn-bitbucket"><i class="fa fa-bitbucket"></i></button></td>
              <td class="text-right">Berfungsi memproses dan mengetahui mahasiswa yang terkena Drop Out Pada Tahun Akdemik Aktif</td>
              <td class="text-right"> - </td>
              <td class="text-right"> - </td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


      <!-- WAWAN -->
      <!-- info row -->
      <div class="row invoice-info">
        <!-- /.col -->
        <div class="col-sm-12 invoice-col">
			<div class="invoice-details row no-margin">
			  <div class="col-md-6 col-lg-3"><b>Proses </b>Feeder DIKTI</div>
			</div>
		</div>
      <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
			  <th>#</th>
              <th>Name</th>
              <th>Image Action</th>
              <th class="text-right">Action</th>
              <th class="text-right">Keterangan</th>
			  <th class="text-right">User Proses</th>
			  <th class="text-right">Tanggal Proses</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>7</td>
              <td>Proses Kirim Data mahasiswa ke dikti</td>
              <td>Image</td>
              <td class="text-right"><a href="<?=base_url('ademik/siakad_years/feeder_mhsw/'.$link)?>"><button class="btn btn-social-icon btn-circle btn-bitbucket"><i class="fa fa-bitbucket"></i></button></a></td>
              <td class="text-right">Berfungsi memproses data mahasiswa agar terkirim ke feeder dikti pada Tahun Akademik Aktif</td>
              <td class="text-right"><!-- <?=$detailperiodeaktif->point7_user;?> --></td>
              <td class="text-right"><!-- <?=$detailperiodeaktif->point7_tgl;?> --></td>
            </tr>
            <tr>
              <td>8</td>
              <td>Proses Kirim Data KRS ke dikti</td>
              <td>Image</td>
              <td class="text-right"><a href="<?=base_url('ademik/siakad_years/feeder_krs/'.$link)?>"><button class="btn btn-social-icon btn-circle btn-bitbucket"><i class="fa fa-bitbucket"></i></button></a></td>
              <td class="text-right">Berfungsi memproses data KRS agar terkirim ke feeder dikti pada semester Akademik Aktif</td>
              <td class="text-right"><!-- <?=$detailperiodeaktif->point8_user;?> --></td>
              <td class="text-right"><!-- <?=$detailperiodeaktif->point8_tgl;?> --></td>
            </tr>
            <tr>
              <td>9</td>
              <td>Proses Kirim Data KHS ke dikti</td>
              <td>Image</td>
              <td class="text-right"><a href="<?=base_url('ademik/siakad_years/feeder_khs/'.$link)?>"><button class="btn btn-social-icon btn-circle btn-bitbucket"><i class="fa fa-bitbucket"></i></button></a></td>
              <td class="text-right">Berfungsi memproses data KHS agar terkirim ke feeder dikti pada semester Akademik Aktif</td>
              <td class="text-right"><!-- <?=$detailperiodeaktif->point9_user;?> --></td>
              <td class="text-right"><!-- <?=$detailperiodeaktif->point9_tgl;?> --></td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- /WAWAN -->

    </section>
    <!-- /.content -->
    <div class="clearfix"></div>

</div>

<div class="modal fade" id="modal-priodeaktif">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myLargeModalLabel">Data Priode Aktif</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
					<!-- Main content untuk isi data kliring -->
							<div class="row">
								<div class="col-12">
									<div class="box">
										<div class="box-header">
											<h3 class="box-title">Silahkan isi priode aktif dengan benar</h3>
										</div>
										<!-- /.box-header -->
										<div class="box-body">
											<form action="<?= base_url('ademik/siakad_years/edit_periodeaktif'); ?>" method="POST">
											<div class="form-group row">
												  <label for="nim" class="col-md-2 col-form-label">Kode Priode</label>
												  <div class="col-md-6">
													<select class="form-control select2" style="width: 100%;" id="kode_periode" name="kode_periode">
														<?php
															if (!empty($detailperiodeaktif)){
																echo "<option selected='selected' value='".$detailperiodeaktif->periode_aktif."'>".$detailperiodeaktif->nama_periode." (Aktif)</option>";
															} else {
																echo "<option selected='selected'>Silahkan Pilih</option>";
															}

															foreach ($periodeaktif as $w) {
																echo "<option value='".$w->periode_aktif."'>".$w->nama_periode."</option>";
															}
														?>
													</select>
												  </div>
												  <div class="col-md-4" style="text-align: center;">
														<input type="submit" name="edit" value="Ganti Periode" class="btn bg-olive">
												  </div>
											</div>
											</form>
										</div>
										<!-- /.box-body -->
									</div>
									<!-- /.box -->
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->
					
							<div class="row">
								<div class="col-12">
									<div class="box">
										<div class="box-header">
											<h3 class="box-title">Silahkan isi priode aktif dengan benar</h3>
										</div>
										<!-- /.box-header -->
										<div class="box-body">
											<form action="<?= base_url('ademik/siakad_years/simpan_periodeaktif'); ?>" method="POST">
											<div class="form-group row">
												  <label for="nim" class="col-md-2 col-form-label">Kode Priode</label>
												  <div class="col-md-6">
													<input class="form-control" type="number" id="kdperiode" name="kdperiode">
												  </div>
												  <div class="col-md-4" style="text-align: center;">
														<input type="submit" name="simpan" value="Save Priode" class="btn bg-olive">
												  </div>
											</div>
											<div class="form-group row">
												  <label for="nim" class="col-md-2 col-form-label">Nama Priode</label>
												  <div class="col-md-6">
													<input class="form-control" type="text" id="nmperiode" name="nmperiode">
												  </div>
											</div>
											</form>
										</div>
										<!-- /.box-body -->
									</div>
									<!-- /.box -->
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->
				</div>
				<div class="modal-footer">
						<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

<script>
function updstatbayar(){
	var a = 1;
	console.log('fandu masuk = '+a);

	//for (var i = 0; i <= 100; i++) {
		//setInterval(css($a), 50);
	if (a <= 100){
		console.log('fandu masuk 1');
		setInterval(function(){
			//$('#tagprogressbar').html('Processing Query');
			$('.progress-bar').css('width', a+'%');
			a++;
		}, 5000);
	} else {
		console.log('fandu masuk 2');
		//$('#tagprogressbar').html('Complated Query');
		$('.progress-bar').css('width', '0%');
	}

		//setInterval(function(){ alert("Hello"); }, 3000);
    //}

	console.log('fandu masuk');
	
	$.ajax({
	  type: 'POST',
	  url: "<?=base_url('ademik/siakad_years/prc_spctosiakad')?>",
	  data: 'tahun='+<?=$link?>,
	  dataType: 'json',
	  cache : false,
	  success: function(data){
		//Do something success-ish
		console.log(data);
		if (data.ket = "success"){
			$('.progress-bar').css('width', '100%');
			a = 100;
		}
	  }
	});
}

/*
function css (a){
	console.log('fandu 111 '+a);
	$('.progress-bar').css('width', a+'%');
	a++;
}*/
</script>
