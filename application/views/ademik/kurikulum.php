<style type="text/css">
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

<?php if(empty($data_jurusan)){
	//$this->session('sess_tamplate');
	}else{ ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			Data Tables Kurikulum
		</h1>
      	<ol class="breadcrumb">
        	<li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        	<li class="breadcrumb-item"><a href="#">Tables</a></li>
        	<li class="breadcrumb-item active">Data tables</li>
      	</ol>
    </section>

    <!-- Main content -->
    <section class="content">
      	<div class="row">
        	<!-- left column -->
        	<div class="col-xl-6 col-lg-12">
          		<!-- general form elements -->
          		<div class="box box-primary">
            		<div class="box-header with-border">
              			<h3 class="box-title">DETAIL KURIKULUM</h3>
            		</div>
            		<!-- /.box-header -->
            		<div class="box-body">
            			<?php 
            			if ( ( empty($detail_kurikulum) ) && ($uri == 'detailKurikulum') ) { ?>
            				<dt>Jurusan</dt>
	                		<dd><?= $detail_jurusan->Kode ?> - <?= $detail_jurusan->Nama_Indonesia ?></dd>
            				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahBaru">Buat Kurikulum Baru</button>
            			<?php } else {
            				if ($uri == 'detailKurikulum'){?>
			              		<dl class="dl-horizontal">
			                		<dt>Jurusan</dt>
			                		<dd><?= $detail_kurikulum->KodeJurusan ?> - <?= $detail_kurikulum->Nama_Indonesia ?></dd>
			                		<dt>Tahun</dt>
			                		<dd><?= $detail_kurikulum->Tahun ?></dd>
			                		<dt>Kurikulum</dt>
			                		<dd><?= $detail_kurikulum->Nama ?> | 
			                			<!-- <button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#modalEdit">Edit</button> -->
			                			<button type="button" class="btn btn-xs btn-success" onclick="edit('<?=$detail_kurikulum->ID?>')">Edit</button>
			                			<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalTambah">Tambah</button>
			                		</dd>
			                		<dt>Nama Semester</dt>
			                		<dd><?= $detail_kurikulum->Sesi ?></dd>
			                		<dt>Jumlah Semester</dt>
			                		<dd><?= $detail_kurikulum->JmlSesi ?></dd>
			                		<dt>ID Semester</dt>
			                		<dd><?= $detail_kurikulum->IdKurikulum ?></dd>
			                		<dt>Status PDDIKTI</dt>
			                		<dd>
			                			<?php if (empty($detail_kurikulum->id_kurikulum)) { ?>
			                				<span style="color: red;">Belum Terdaftar di PDDIKTI</span>
			                			<?php } else { ?>
			                				<img src="<?=base_url();?>assets/images/ristekdikti.png">
			                			<?php } ?>	
			                		</dd>
			              		</dl>
		              			<div class="box box-info">
		                			<div class="box-header with-border">
		                  				<h3 class="box-title">HISTORY KURIKULUM</h3>
		                			</div>
					                <!-- /.box-header -->
					                <div class="box-body">
		                  				<table id="example2" class="table table-bordered table-striped table-responsive">
		                  					<thead>
		                    					<tr>
		                      						<th>No</th>
		                      						<th>Nama Kurikulum</th>
		                      						<th>Tahun</th>
		                      						<th>Status</th>
		                      						<th>Status DIKTI</th>
		                    					</tr>
		                  					</thead>
		                  					<tfoot>
		                    					<tr>
		                      						<th>No</th>
		                      						<th>Nama Kurikulum</th>
		                      						<th>Tahun</th>
		                      						<th>Status</th>
		                      						<th>Status DIKTI</th>
		                    					</tr>
		                  					</tfoot>
		                  					<tbody>
							                  	<?php
							                  		$no=1;
							                  	 	foreach ($tabel_kurikulum as $data) { ?>
							                    	<tr>
		                      							<td><?=$no++?></td>
		                      							<td><a href="javascript:;" onclick="edit('<?=$data->ID?>')"><?=$data->Nama?></a></td>
		                      							<td><?=$data->Tahun?></td>
		                      							<td>

		                      								<?php if ( $data->NotActive == 'N' ) {
		                      									echo "<span style='color:blue; font-weight:bold;'>Aktif</span>";
		                      								} else {
		                      									echo "Tidak Aktif";
		                      								} ?>
		                      									
		                      							</td>
		                      							<td>
		                      								
		                      								<?php if ( empty($data->id_kurikulum) ) { ?>
																	<span class='glyphicon glyphicon-remove' style='color: red;'></span>
															<?php } else { ?>
																	<img src="<?=base_url();?>assets/images/ristekdikti.png" width="25px;">
															<?php } ?>

		                      							</td>
		                    						</tr>
		                    					<?php } ?>
		                  					</tbody>
		                  				</table>
		                			</div>
		            				<!-- /.box-body -->
		              			</div>
	              			<?php } ?>
              			<?php } ?>
            		</div>
          		</div>
          		<!-- /.box -->
        	</div>
          	<!-- right column -->
        	<div class="col-xl-6 col-lg-12">
         
         		<div class="box box-info">
            		<div class="box-header with-border">
              			<h3 class="box-title">TABEL JURUSAN</h3>
            		</div>
            <!-- /.box-header -->
            		<div class="box-body">
              			<table id="example1" class="table table-bordered table-striped table-responsive">
                			<thead>
								<tr>
									<th>Kode</th>
									<th>Nama Jurusan</th>
									<th>Jenjang</th>
									<th>Nilai</th>
									<th>Status</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Kode</th>
						            <th>Nama Jurusan</th>
						            <th>Jenjang</th>
						            <th>Nilai</th>
						            <th>Status</th>
								</tr>
							</tfoot>
							<tbody>
								<?php foreach ($data_jurusan as $tampil) { ?>
									<tr>
										<!--<td><a href="javascript:;" onclick="klik('<?= $tampil->Kode ?>')" style="color: red;"><?= $tampil->Kode ?></td>-->
										<td><a href="<?=base_url();?>ademik/kurikulum/detailKurikulum/<?= $tampil->Kode ?>" style="color: red;"><?= $tampil->Kode ?></a></td>
										<td><?= $tampil->Nama_Indonesia ?></td>
							            <td><?= $tampil->JenjangPS ?></td>
							            <td><?= $tampil->Ket_Jenjang ?></td>
							            <td>

              								<?php if ( $tampil->NotActive == 'N' ) {
              									echo "<span style='color:blue; font-weight:bold;'>Aktif</span>";
              								} else {
              									echo "Tidak Aktif";
              								} ?>
              									
              							</td>
									</tr>
								<?php } ?>
							</tbody>
             			</table>
            		</div>
            		<!-- /.box-body -->
          		</div>
          		<!-- /.box -->          
        	</div>
        	<!-- /.col -->
      	</div>
      	<!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<?php if(empty($detail_kurikulum)){ ?>
<!--modalNew-->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="modalTambahBaru">
  	<div class="modal-dialog modal-lg">
	  	<form action="#" method="POST"/>
		  	<div class="modal-content">
			    <div class="modal-header">
				    <h4 class="modal-title">Buat Kurikulum</h4>
				    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				      <span aria-hidden="true">&times;</span></button>
			    </div>
			    <div class="modal-body">
			    <!--<p>One fine body&hellip;</p>-->
			    	<input type="hidden" class="form-control" name="id" id="idaddnew" value="">
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-3 col-form-label">Jurusan</label>
				    	<div class="col-sm-9">
				      		<input class="form-control" name="kode" id="kodeaddnew" readonly value="<?= $detail_jurusan->Kode ?> - <?= $detail_jurusan->Nama_Indonesia ?>">
				      	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-3 col-form-label">Tahun Kurikulum</label>
				    	<div class="col-sm-4">
				      		<input class="form-control" name="tahun" id="tahunaddnew" placeholder="Input Tahun Kurikulum" value="">
				      	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-3 col-form-label">Nama Kurikulum</label>
				    	<div class="col-sm-9">
				      		<input class="form-control" name="nama" id="namaaddnew" placeholder="Input Nama Kurikulum" value="">
				      	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-3 col-form-label">Nama Semester</label>
				    	<div class="col-sm-9">
				      		<input class="form-control" name="sesi" id="sesiaddnew" placeholder="Input Nama Semester yang Berlaku" value="">
				      	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-3 col-form-label">Jumlah Semester</label>
				    	<div class="col-sm-2">
				      		<input class="form-control" type="number" name="jmlsesi" id="jmlsesiaddnew" value="0" min="0" max="99">
				      	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-3 col-form-label">Tahun Semester Berlaku</label>
				    	<div class="col-sm-4">
				      		<input class="form-control" name="smtberlaku" id="smt_berlakunew" placeholder="Input Semester Berlaku" value="">
				      	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-2 col-form-label">Jumlah SKS Lulus</label>
				    	<div class="col-sm-2">
				      		<input class="form-control" type="number" name="skslulus" id="sks_lulusnew" value="0" min="0" max="999" >
				      	</div>
				      	<label for="example-text-input" class="col-sm-2 col-form-label">Jumlah SKS Wajib</label>
				    	<div class="col-sm-2">
				    		<input class="form-control" type="number" name="skswajib" id="sks_wajibnew" value="0" min="0" max="999">
				    	</div>
				    	<label for="example-text-input" class="col-sm-2 col-form-label">Jumlah SKS Pilihan</label>
				    	<div class="col-sm-2">
				    		<input class="form-control" type="number" name="skspilihan" id="sks_pilihannew" value="" min="0" max="999">
				    	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-2 col-form-label"></label>
				    	<div class="col-sm-4">
				      		<input type="checkbox" id="md_checkbox_23" class="filled-in chk-col-red" name="notactive" />
				      		<label for="md_checkbox_23">Aktif</label>
				      	</div>
				    </div>
				</div>
			    <div class="modal-footer">
				    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				    <input type="button" onclick="simpan('addnew')" class="btn btn-primary float-right" name="addmodul_btn" value="Save"/>
				    <input type="reset" class="btn btn-warning float-right" name="addmodul_btn" value="Reset"/>
			    </div>
		  	</div>
	  	</form>
  		<!-- /.modal-content -->
  	</div>
  	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php }else{ ?>

<!--modalTambah-->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="modalTambah">
  	<div class="modal-dialog modal-lg">
	  	<form action="#" method="POST"/>
		  	<div class="modal-content">
			    <div class="modal-header">
				    <h4 class="modal-title">Tambah Kurikulum</h4>
				    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				      <span aria-hidden="true">&times;</span></button>
			    </div>
			    <div class="modal-body">
			    <!--<p>One fine body&hellip;</p>-->
			    	<input type="hidden" class="form-control" name="id" id="idadd" value="">
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-3 col-form-label">Jurusan</label>
				    	<div class="col-sm-9">
				      		<input class="form-control" name="kode" id="kodeadd" readonly value="<?= $detail_kurikulum->KodeJurusan ?> - <?= $detail_kurikulum->Nama_Indonesia ?>">
				      	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-3 col-form-label">Tahun Kurikulum</label>
				    	<div class="col-sm-4">
				      		<input class="form-control" name="tahun" id="tahunadd" placeholder="Input Tahun Kurikulum" value="">
				      	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-3 col-form-label">Nama Kurikulum</label>
				    	<div class="col-sm-9">
				      		<input class="form-control" name="nama" id="namaadd" placeholder="Input Nama Kurikulum" value="">
				      	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-3 col-form-label">Nama Semester</label>
				    	<div class="col-sm-9">
				      		<input class="form-control" name="sesi" id="sesiadd" placeholder="Input Nama Semester yang Berlaku" value="">
				      	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-3 col-form-label">Jumlah Semester</label>
				    	<div class="col-sm-2">
				      		<input type="number" class="form-control" name="jmlsesi" id="jmlsesiadd" value="0" min="0" max="99">
				      	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-3 col-form-label">Tahun Semester Berlaku</label>
				    	<div class="col-sm-4">
				      		<input class="form-control" name="smtberlaku" id="smt_berlakuadd" placeholder="Input Semester Berlaku" value="">
				      	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-2 col-form-label">Jumlah SKS Lulus</label>
				    	<div class="col-sm-2">
				      		<input type="number" class="form-control" name="skslulus" id="sks_lulusadd" value="0" min="0" max="999">
				      	</div>
				      	<label for="example-text-input" class="col-sm-2 col-form-label">Jumlah SKS Wajib</label>
				    	<div class="col-sm-2">
				      		<input type="number" class="form-control" name="skswajib" id="sks_wajibadd" value="0" min="0" max="999">
				      	</div>
				      	<label for="example-text-input" class="col-sm-2 col-form-label">Jumlah SKS Pilihan</label>
				    	<div class="col-sm-2">
				      		<input class="form-control" type="number" name="skspilihan" id="sks_pilihanadd" value="0" min="0" max="999">
				      	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-2 col-form-label"></label>
				    	<div class="col-sm-4">
				      		<input type="checkbox" id="md_checkbox_22" class="filled-in chk-col-red" name="notactive" />
				      		<label for="md_checkbox_22">Aktif</label>
				      	</div>
				    </div>
				</div>
			    <div class="modal-footer">
				    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				    <input type="button" onclick="simpan('add')" class="btn btn-primary float-right" name="addmodul_btn" value="Save"/>
				    <input type="reset" class="btn btn-warning float-right" name="addmodul_btn" value="Reset"/>
			    </div>
		  	</div>
	  	</form>
  		<!-- /.modal-content -->
  	</div>
  	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!--modalEdit-->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="modalEdit">
  	<div class="modal-dialog modal-lg">
	  	<form action="#" method="POST"/>
		  	<div class="modal-content">
			    <div class="modal-header">
				    <h4 class="modal-title">Edit Kurikulum</h4>
				    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				      <span aria-hidden="true">&times;</span>
				 	</button>
			    </div>
			    <div class="modal-body">
			    	<input type="hidden" class="form-control" name="id" id="id" value="">
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-3 col-form-label">Jurusan</label>
				    	<div class="col-sm-9">
				      		<input class="form-control" name="kode" id="kode" readonly value="<?= $detail_kurikulum->KodeJurusan ?> - <?= $detail_kurikulum->Nama_Indonesia ?>">
				      		<input type="hidden" class="form-control" name="id_kurikulum" id="id_kurikulum" value="">
				      	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-3 col-form-label">Tahun Kurikulum</label>
				    	<div class="col-sm-4">
				      		<input class="form-control" name="tahun" id="tahun" placeholder="Input Tahun Kurikulum" value="">
				      	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-3 col-form-label">Nama Kurikulum</label>
				    	<div class="col-sm-9">
				      		<input class="form-control" name="nama" id="nama" placeholder="Input Nama Kurikulum" value="">
				      	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-3 col-form-label">Nama Semester</label>
				    	<div class="col-sm-2">
				      		<input class="form-control" name="sesi" id="sesi" placeholder="Input Nama Semester yang Berlaku" value="">
				      	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-3 col-form-label">Jumlah Semester</label>
				    	<div class="col-sm-2">
				      		<input class="form-control" type="number" name="jmlsesi" id="jmlsesi" value="0" min="0" max="99">
				      	</div>
				    </div>
				   	<div class="form-group row">
				    	<label for="example-text-input" class="col-sm-3 col-form-label">Tahun Semester Berlaku</label>
				    	<div class="col-sm-4">
				      		<input class="form-control" name="smtberlaku" id="smt_berlaku" placeholder="Input Tahun Semester Berlaku" value="">
				      	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-2 col-form-label">Jumlah SKS Lulus</label>
				    	<div class="col-sm-2">
				      		<input class="form-control" type="number" name="skslulus" id="sks_lulus" value="0" min="0" max="999">
				      	</div>
				      	<label for="example-text-input" class="col-sm-2 col-form-label">Jumlah SKS Wajib</label>
				    	<div class="col-sm-2">
				    		<input class="form-control" type="number" name="skswajib" id="sks_wajib" value="0" min="0" max="999">
				    	</div>
				    	<label for="example-text-input" class="col-sm-2 col-form-label">Jumlah SKS Pilihan</label>
				    	<div class="col-sm-2">
				    		<input class="form-control" type="number" name="skspilihan" id="sks_pilihan" value="0" min="0" max="99">
				    	</div>
				    </div>
				    <div class="form-group row">
				    	<label for="example-text-input" class="col-sm-2 col-form-label"></label>
				    	<div class="col-sm-4">
				      		<input type="checkbox" id="md_checkbox_21" class="filled-in chk-col-red" name="notactive" />
				      		<label for="md_checkbox_21">Aktif</label>
				      	</div>
				    </div>
				</div>
			    <div class="modal-footer">
				    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				    <input type="button" onclick="simpan('update')" class="btn btn-primary float-right" name="addmodul_btn" value="Update"/>
				    <!-- <input type="button" onclick="hapus()" class="btn btn-warning float-right" name="addmodul_btn" value="Dalate"/> -->
			    </div>
		  	</div>
	  	</form>
  		<!-- /.modal-content -->
  	</div>
  	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php } ?>


<script>
function simpan(act){

	var notactive, id, kode, tahun, nama, jmlsesi, sesi, skswajib, skslulus, skspilihan, smtberlaku, id_kurikulum;

	if ( act == 'addnew' ) {
		id = $('#idaddnew').val();
		kode = $('#kodeaddnew').val();
		tahun = $('#tahunaddnew').val();
		nama = $('#namaaddnew').val();
		sesi = $('#sesiaddnew').val();
		jmlsesi = $('#jmlsesiaddnew').val();
		skswajib = $('#sks_wajibnew').val();
		skslulus = $('#sks_lulusnew').val();
		skspilihan = $('#sks_pilihannew').val();
		smtberlaku = $('#smt_berlakunew').val();

		if ($('#md_checkbox_23').is(":checked")){
			notactive = 'N';
		}else{
			notactive = 'Y';
		}

	} else if ( act == 'add' ) {
		id = $('#idadd').val();
		kode = $('#kodeadd').val();
		tahun = $('#tahunadd').val();
		nama = $('#namaadd').val();
		sesi = $('#sesiadd').val();
		jmlsesi = $('#jmlsesiadd').val();
		skswajib = $('#sks_wajibadd').val();
		skslulus = $('#sks_lulusadd').val();
		skspilihan = $('#sks_pilihanadd').val();
		smtberlaku = $('#smt_berlakuadd').val();

		if ($('#md_checkbox_22').is(":checked")){
			notactive = 'N';
		}else{
			notactive = 'Y';
		}

	} else {
		id = $('#id').val();
		kode = $('#kode').val();
		tahun = $('#tahun').val();
		nama = $('#nama').val();
		sesi = $('#sesi').val();
		jmlsesi = $('#jmlsesi').val();
		skswajib = $('#sks_wajib').val();
		skslulus = $('#sks_lulus').val();
		skspilihan = $('#sks_pilihan').val();
		smtberlaku = $('#smt_berlaku').val();
		id_kurikulum = $('#id_kurikulum').val();

		if ($('#md_checkbox_21').is(":checked")){
			notactive = 'N';
		}else{
			notactive = 'Y';
		}

	}

	var data = 'act='+act+'&id='+id+'&kode='+kode+'&tahun='+tahun+'&nama='+nama+'&sesi='+sesi+'&jmlsesi='+jmlsesi+'&notactive='+notactive+'&skswajib='+skswajib+'&skslulus='+skslulus+'&skspilihan='+skspilihan+'&smtberlaku='+smtberlaku+'&id_kurikulum='+id_kurikulum;

	$body = $("body");
	$body.addClass("loading");

	$.ajax({
		url: "<?= base_url('ademik/kurikulum/validasiForm'); ?>",
		data: data,
		type: 'POST',
		dataType: 'json',
		cache : false,
		success: function(respon){
			$body.removeClass("loading");

			if ( respon.ket == 'error' ) {
				console.log(respon.pesan);
				swal({   
					title: 'Peringatan',   
					type: 'warning',    
					html: true, 
					text: respon.pesan,
					confirmButtonColor: '#f7cb3b',   
				});

			} else if (respon.ket == 'sukses') {
				swal({   
					title: 'Pesan',   
					type: 'success',    
					html: true, 
					text: respon.pesan,
					confirmButtonColor: 'green',   
				}, function() {
					location.reload();
				});

			} else if ( respon.ket == 'konfirmasi' ) {
				swal({
			        title: "Peringatan",
			        text: respon.pesan,
			        type: "warning",
			        showCancelButton: true,
			        confirmButtonColor: '#DD6B55',
			        confirmButtonText: 'Ya',
			        cancelButtonText: "Tidak",
			        closeOnConfirm: false,
			        closeOnCancel: false
    			},
			    function(isConfirm) {	
			        if (isConfirm) {
			            $body = $("body");
						$body.addClass("loading");

						var url

						if ( respon.act == 'update' ) {
							url = "<?= base_url('ademik/kurikulum/setEditAktif'); ?>";

							var dataEdit = 'id='+respon.data['id']+'&kode='+respon.data['kode']+'&tahun='+respon.data['tahun']+'&nama='+respon.data['nama']+'&sesi='+respon.data['sesi']+'&jmlsesi='+respon.data['jmlsesi']+'&notactive='+respon.data['notactive']+'&skslulus='+respon.data['skslulus']+'&skswajib='+respon.data['skswajib']+'&skspilihan='+respon.data['skspilihan']+'&smtberlaku='+respon.data['smtberlaku']+'&user='+respon.data['user']+'&tglnow='+respon.data['tglnow']+'&idAktif='+respon.idaktif;
						} else {
							url = "<?= base_url('ademik/kurikulum/setTambahAktif'); ?>";

							var dataEdit = 'id='+respon.data['id']+'&kode='+respon.data['kode']+'&tahun='+respon.data['tahun']+'&nama='+respon.data['nama']+'&sesi='+respon.data['sesi']+'&jmlsesi='+respon.data['jmlsesi']+'&notactive='+respon.data['notactive']+'&skslulus='+respon.data['skslulus']+'&skswajib='+respon.data['skswajib']+'&skspilihan='+respon.data['skspilihan']+'&smtberlaku='+respon.data['smtberlaku']+'&user='+respon.data['user']+'&tglnow='+respon.data['tglnow']+'&idKurikulum='+respon.data['idKurikulum']+'&id_kurikulum='+respon.data['id_kurikulum']+'&idAktif='+respon.idaktif;
						}

						console.log(dataEdit);


				    	$.ajax({
							url : url,
							type: "POST",
							data: dataEdit,
							dataType: "JSON",
							success: function(hasil) {
								$body.removeClass("loading");

								swal({   
									title: 'Pesan',   
									type: 'success',    
									html: true, 
									text: hasil.pesan,
									confirmButtonColor: 'green',   
								}, function() {
									location.reload();
								});
							},
							error: function (err) {
						    	console.log(err);
							}
						});

			        } else {
			            swal("Batal", "Data Kurikulum ini Tidak Berubah", "error");
			        }
			    });

			} else {
				console.log(respon);
			}
		},
		error: function (err) {
        	console.log(err);
    	}
	});
}

function edit(id){
	$body = $("body");
	$body.addClass("loading");

  	$.ajax({
    	url : "<?= base_url('ademik/kurikulum/getDataEdit'); ?>/" +id,
    	type: "GET",
    	dataType: "JSON",
    	success: function(data) {
    		$body.removeClass("loading");

        	$('#id').val(data.ID);
        	$('#id_kurikulum').val(data.id_kurikulum);
			$('#tahun').val(data.Tahun);
			$('#nama').val(data.Nama);
			$('#sesi').val(data.Sesi);
			$('#jmlsesi').val(data.JmlSesi);
			$('#sks_wajib').val(data.jml_sks_wajib);
			$('#sks_lulus').val(data.jml_sks_lulus);
			$('#sks_pilihan').val(data.jml_sks_pilihan);
			$('#smt_berlaku').val(data.id_smt_berlaku);

			if ( data.NotActive == 'N' ) {
				$('#md_checkbox_21').attr('checked','checked');
			} else {
				$('#md_checkbox_21').removeAttr('checked');
			}

        	$('#modalEdit').modal('show'); // show bootstrap modal when complete loaded
    	},
    	error: function (err) {
        	console.log(err);
    	}
	});
}

function hapus(){
	swal({
        title: "Peringatan",
        text: "Anda Yakin Untuk Menghapus Kurikulum ini?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Ya',
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: false
	},
    function(isConfirm) {	
        if (isConfirm) {
            $body = $("body");
			$body.addClass("loading");

			var id = $('#id').val();
			var kode = $('#kode').val();
			var id_kurikulum = $('#id_kurikulum').val();

			var dataHapus = 'id='+id+'&kode='+kode+'&id_kurikulum='+id_kurikulum;

	    	$.ajax({
				url : "<?= base_url('ademik/kurikulum/setHapusData'); ?>",
				type: "POST",
				data: dataHapus,
				dataType: "JSON",
				success: function(hasil) {
					$body.removeClass("loading");

					if ( hasil.ket == 'error' ) {
						//console.log(respon.pesan);
						swal({   
							title: 'Peringatan',   
							type: 'warning',    
							html: true, 
							text: hasil.pesan,
							confirmButtonColor: '#f7cb3b',   
						});

					} else if (hasil.ket == 'sukses') {
						swal({   
							title: 'Pesan',   
							type: 'success',    
							html: true, 
							text: hasil.pesan,
							confirmButtonColor: 'green',   
						}, function() {
							location.reload();
						});

					}
				},
				error: function (err) {
			    	console.log(err);
				}
			});

        } else {
            swal("Batal","", "error");
        }
    });
}

</script>

<?php } ?>
