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
	  width: 100%;
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
			 Tambah Nilai Kliring Mahasiswa
		 </h1>
		 <ol class="breadcrumb">
			 <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			 <li class="breadcrumb-item"><a href="#">Kliring</a></li>
			 <li class="breadcrumb-item active">Tambah Nilai Kliring</li>
		 </ol>
	 </section>

	 <!-- Main content -->
	 <section class="content">
		 <div class="row">
			 <div class="col-6">

				<div class="box">
					 <div class="box-header">
						 <h3 class="box-title">Tambah Nilai Kliring</h3>
					 </div>


					 <!-- box-header -->
					<div class="box-body">
						 	<div class="form-group row">
							 <label class="col-sm-2 control-lebel">Insert NIM :</label>
									 <div class="col-sm-4">
											<input class="form-control input-sm" type="text" name="searchData" id="searchData">
									 </div>
									 <div class="col-sm-4">
										 	<input class="btn btn-flat btn-info" type="button" id="search" name="search" value="Search">
									 </div>
							 </div>
						 
					</div>

					<!-- table content -->
					<form enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url().'ademik/tambah_nilai_kliring/simpan' ?>" method="POST">	
					<div class="row col-md-12">

					            	<div class="col-md-12">
					            		<div class="box-header">
					              			<h3 class="box-title">Tambah Nilai</h3>
					            		</div>
							            <div class="box-body">
								            <table id="matakuliah" class="table table-bordered table-striped table-responsive dataTable">
								                <thead>
													<tr>
														<th>No</th>
														<th>NIM</th>
														<th>Nama</th>
														<th>Total SKS</th>
													</tr>
												</thead>
												<tbody id="bodyData">
													
													<!-- <?php
													if(!empty($nim) and !empty($name)){
													?>
													<tr>
														<th>1</th>
														<th><?=$nim?></th>
														<th><?=$name?></th>
														<th>
															<div class="col-sm-5">
															
		                									<input class="form-control" type="text" name="tsks"  id="tsks" />
		                									
		                									</div>
														</th>
													</tr>
													<?php
													}else{
													?>
														<th></th>
														<th></th>
														<th></th>
														<th></th>
													<?php
													}
													?> -->
												</tbody>
												<tfoot>
													<tr>
														<th>No</th>
														<th>NIM</th>
														<th>Nama</th>
														<th>Total SKS</th>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>

					</div>
					<!-- bottom menu -->
					<div class="box-body">
						
		              		<dl class="dl-horizontal">
		                		<dt>No. Surat</dt>
		                		<div class="row">
		                		<div class="col-sm-10">
		                		<input class="form-control" type="hidden" name="test" id="tes">
		                		<input class="form-control" type="text" name="nsurat"  id="nsurat" />
		                		</div></div><br>
		                		<dt>Dosen Penanggung<br>
		                			Jawab</dt>
		                		<div class="row">
		                		<div class="col-sm-10">
		                			<select class="form-control select2" style="width: 100%;" id="dospen" name="dospen">
										<?php
											foreach ($dsn as $dosen) {
												echo "<option value=".$dosen->nip.">".$dosen->nip." - ".$dosen->Name."</option>";
											}
										?>
									</select>
								</div>
								</div><br>
		                		<dt>Keterangan</dt>
		                		<div class="row">
		                		<div class="col-sm-10">
		                		<input class="form-control" type="text" name="keterangan"  id="keterangan" />
		                		</div></div><br>
		                		<dt>Upload File</dt>
		                		<div class="row">
		                		&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" name="nmfile">
		                		<input class="btn btn-flat btn-info" type="submit" id="simpan" name="simpan" value="Simpan">
		                		&nbsp;&nbsp;&nbsp;
	                			<?php 
									if ( $this->session->userdata('ulevel') == 1) {
								?> 
									<!-- Button Validasi Admin -->
						    		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Validasi Admin</button>
								<?php
									}
								?>
		                		</div>
		                	</dl>
		            </div>

		            	</form>
				 </div>
				</div>
			 </div>
		 </div>
		</section>

		<?php 
			if ( $this->session->userdata('ulevel') == 1) {
		?> 

		<form enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url().'ademik/tambah_nilai_kliring/accept' ?>" method="POST">
			<!-- Modal -->
			<div id="myModal" class="modal fade modal-fullscreen" role="dialog">
			  <div class="modal-dialog modal-lg">

			    <!-- Modal content-->
			    <div class="modal-content"> 
			      <div class="modal-header">
			        <h4 class="modal-title">Admin Validation Form</h4>
			      </div>
			      <div class="modal-body">

                		<!-- test -->
						<div class="row col-md-12">
							<div class="col-md-6">
				            		<div class="box-body">
							            <table id="stujui" class="table table-bordered table-striped table-responsive dataTable">
							                <thead>
												<tr>
													<th>No</th>
													<th>NIM</th>
													<th>Nama</th>
													<th>Total SKS</th>
													<th>ID Dosen Penanggung Jawab</th>
													<th>No. Surat</th>
													<th>Alasan</th>
													<th>User</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody id="bodyData">
												<?php
												$i = 1 ;

												foreach ($cekAdmin as $show) {?>
													
													<tr>
														<th><?=$i?></th>
														<th><?=$show->NIM?></th>
														<th><?=$show->Nama?></th>
														<th><?=$show->Total_SKS?></th>
														<th><?=$show->pimpinan_penanggung_jawab?></th>
														<th><?=$show->Nomor_surat?></th>
														<th><?=$show->Alasan?></th>
														<th><?=$show->User_usulkan?></th>
														<th><input type="checkbox" id="md_checkbox_<?= $i; ?>" class="filled-in chk-col-blue" name="ted[]" value="<?=$show->ID?>">
															<label for="md_checkbox_<?= $i; ?>">Disetujui</label>
														</th>
													</tr>

												<?php 
												$i++;
												}  
												?>	
												
											</tbody>
										</table>
									</div>
							</div>
						</div>
                		<!-- test -->
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        &nbsp;&nbsp;
			        <input type="submit" name="accept" class="btn btn-info" value="Accept">
			      </div>
			    </div>
			  </div>
			</div>
		</form>
			<!-- End Button -->
		<?php
			}
		?>
		                							

 <!-- maximum_admin for Data Table -->
 	<script type="text/javascript">
		var i = setInterval(function() {
			if ($) {
				clearInterval(i);

					$(function(){

						var $totsks = $('#tsks');
						var $totsks1 = $('#tes');
						function onChange(){
							$totsks1.val($totsks.val());
						};
						$('#tsks')
							.change(onChange)
							.keyup(onChange);

						var i = 1;
						$("#search").click(function(){
							var nim = $('#searchData').val();
							var data = 'nim='+nim;
							var nama = "";

							$body = $("body");
							$body.addClass("loading");

							$.ajax({
							    url: "<?= base_url('ademik/Tambah_nilai_kliring/getNama'); ?>",
							    type: 'POST',
							    data: data,
							    dataType: 'json',
							    cache : false,
							    success: function(data){
							      	$body.removeClass("loading");
							      	nama = data;
							      	//console.log(data);
							      	$('#bodyData').append("<tr>"+
														"<th>"+i+"</th>"+
														"<th>"+nim+
														"<input class='form-control' type='hidden' name='nim[]' value ='"+nim+"'/>"+
														"</th>"+
														"<th>"+nama+
														"<input class='form-control' type='hidden' name='nama[]' value ='"+nama+"'/>"+
														"</th>"+
														"<th>"+
															"<div class='col-sm-5'>"+
		                									"<input class='form-control' type='text' name='tsks[]'  id='tsks' />"+
		                									"</div>"+
														"</th>"+
													"</tr>");
									i++;

							    },
							    error: function (err) {
							      	console.log(err);
							    }
							});	

						});
					});
			}
		}, 100);
	</script>