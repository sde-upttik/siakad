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
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			INDEX PRESTASI KUMULATIF
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="breadcrumb-item"><a href="<?= $_SESSION['tamplate'] ?>">Cetak KHS 2</a></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">INDEX PRESTASI KUMULATIF</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<form class="form-horizontal" action="<?= base_url('ademik/mhswipk/search'); ?>">
							<div class="form-group row">
								<label class="col-sm-2 control-label">NIM</label>
								<div class="col-sm-4">
									<?php
										if($_SESSION['ulevel']==4){
											$readonly='readonly value="'.$_SESSION['unip'].'"';
										}else{
											$readonly='';
										}	
									?>
									<input type="text" class="form-control" id='nim' name="nim" placeholder="NIM" <?= $readonly; ?>>
								</div>
								<div class="col-sm-2">
									<input class="btn btn-flat btn-info" type="button" id="search" name="search" value="Search">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label">NAMA</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id='nama' name="nama" readonly placeholder="NAMA">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label">FAKULTAS</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id='fakultas' name="fakultas" readonly placeholder="FAKULTAS">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label">JURUSAN</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id='jurusan' name="jurusan" readonly placeholder="JURUSAN">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label">JENJANG</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id='jenjang' name="jenjang" readonly placeholder="JENJANG">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label">DOSEN PENASEHAT</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id='dosenPenasehat' name="dosen" readonly placeholder="DOSEN">
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

		<div class="row" id="isiContent">
			<div class="col-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Index Prestasi Kumulatif</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body" id='boxContent'>
						
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


<div class="modal fade modal-fullscreen" id="modal-addKrs">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-color:#389af0;">
				<h5 class="modal-title" style="color:#FFF;">Tambah KRS</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" id='isiAddKrs'>
				
			</div>
		</div>
	</div>
</div>
<!-- MODAL ADD -->


<div class="modal fade modal-fullscreen" id="modal-addPaket">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-color:#389af0;">
				<h5 class="modal-title" style="color:#FFF;">Tambah PAKET</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" id='isiAddPaket'>
				
			</div>
		</div>
	</div>
</div>
<!-- MODAL PAKET -->

<div class="modal fade modal-fullscreen" id="modal-registrasiUlang">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-color:#389af0;">
				<h5 class="modal-title" style="color:#FFF;">Registrasi Ulang Mahasiswa</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" id='isiRegistrasiUlang'>
				
			</div>
		</div>
	</div>
</div>
<!-- MODAL REGISTRASI ULANG -->

<script>
	var i = setInterval(function() {
		if ($) {
			clearInterval(i);

			$(function(){
				$('#isiContent').hide();
				$('#search').click(function(){
					var nim = $('#nim').val();
					var dataku = 'nim='+nim;
					$body = $("body");
					$body.addClass("loading");
					$.ajax({
						url: "<?= base_url('ademik/mhswipk/search'); ?>",
						data: dataku,
						type: 'POST',
						dataType: 'json',
						cache : false,
						success: function(msg){ 
							$body.removeClass("loading");
								$('#nim').val(msg.data[0].NIM);
								$('#nama').val(msg.data[0].Name);
								$('#fakultas').val(msg.data[0].KodeFakultas+" - "+msg.data[0].FAK);
								$('#jurusan').val(msg.data[0].KodeJurusan+" - "+msg.data[0].JUR);
								$('#jenjang').val(msg.data[0].JEN);
								$('#dosenPenasehat').val(msg.data[0].DSN);
								//console.log(msg.view);

								$('#isiContent').show();
								document.getElementById("boxContent").innerHTML = msg.view;

								var button = document.querySelector('#prcaddssi');
								$display = $("#isiTable");
								button.addEventListener('click', function (event) {
									event.preventDefault();
									$body = $("body");
									$body.addClass("loading");
									//alert($('#formPrcKrs').serialize());
									$.ajax({
										url: "<?= base_url('ademik/mhswipk/PrcAddSesi'); ?>",
										data: $('#formAddSesi').serialize(),
										type: 'POST',
										dataType: 'json',
										cache : false,
										success: function(msg){ 
											$body.removeClass("loading");
											//alert(msg.isi+" "+msg.nim+" "+msg.semesterAkademik);
											//alert(msg);	
											swal({   
												title: 'Informasi',   
												type: 'info',    
												html: true, 
												text: msg.message,
												confirmButtonColor: '#f7cb3b',   
											});		
											$($display).fadeOut(800, function(){
												$display.html(msg.displayIpk).fadeIn().delay(2000);
											});
										},
										error: function(err){
											console.log(err);
										}
									});
								});

								/*var button = document.querySelectors('.ubah');
								$display = $("#isiTable");
								button.addEventListener('click', function (event) {*/		
								$(".ubah").click(function(event){		
									event.preventDefault();
									var thn = $(this).data('thn');
									var nim = $(this).data('nim');
									var uniqueId = $(this).data('unique');
									var ssi = $('#ssi'+uniqueId).val();
									var maxsks = $('#maxsks'+uniqueId).val();

									var dataku = 'thn='+thn+'&nim='+nim+'&ssi='+ssi+'&maxsks='+maxsks;
									$body = $("body");
									$body.addClass("loading");
									//alert($('#formPrcKrs').serialize());
									$.ajax({
										url: "<?= base_url('ademik/mhswipk/PrcSesi'); ?>",
										data: dataku,
										type: 'POST',
										dataType: 'json',
										cache : false,
										success: function(msg){ 
											$body.removeClass("loading");
											//alert(msg.isi+" "+msg.nim+" "+msg.semesterAkademik);
											//alert(msg);	
											swal({   
												title: 'Informasi',   
												type: 'info',    
												html: true, 
												text: msg.message,
												confirmButtonColor: '#f7cb3b',   
											});		
											$($display).fadeOut(800, function(){
												$display.html(msg.displayIpk).fadeIn().delay(2000);
											});
										},
										error: function(err){
											console.log(err);
										}
									});
								});

								$(".cuti").click(function(event){		
									event.preventDefault();
									var thn = $(this).data('thn');
									var nim = $(this).data('nim');
									var cuti = $(this).data('cuti');

									var dataku = 'thn='+thn+'&nim='+nim+'&cuti='+cuti;
									$body = $("body");
									$body.addClass("loading");
									//alert($('#formPrcKrs').serialize());
									$.ajax({
										url: "<?= base_url('ademik/mhswipk/RefreshCuti'); ?>",
										data: dataku,
										type: 'POST',
										dataType: 'json',
										cache : false,
										success: function(msg){ 
											$body.removeClass("loading");
											//alert(msg.isi+" "+msg.nim+" "+msg.semesterAkademik);
											//alert(msg);	
											swal({   
												title: 'Informasi',   
												type: 'info',    
												html: true, 
												text: msg.message,
												confirmButtonColor: '#f7cb3b',   
											});		
											$($display).fadeOut(800, function(){
												$display.html(msg.displayIpk).fadeIn().delay(2000);
											});
										},
										error: function(err){
											console.log(err);
										}
									});
								});

								$(".sks_max").click(function(event){		
									event.preventDefault();
									var thn = $(this).data('thn');
									var nim = $(this).data('nim');
									var kdf = $(this).data('kdf');
									var kdj = $(this).data('kdj');

									var dataku = 'thn='+thn+'&nim='+nim+'&kdf='+kdf+'&kdj='+kdj;
									$body = $("body");
									$body.addClass("loading");
									//alert($('#formPrcKrs').serialize());
									$.ajax({
										url: "<?= base_url('ademik/mhswipk/RefreshMaxSks2'); ?>",
										data: dataku,
										type: 'POST',
										dataType: 'json',
										cache : false,
										success: function(msg){ 
											$body.removeClass("loading");
											//alert(msg.isi+" "+msg.nim+" "+msg.semesterAkademik);
											//alert(msg);	
											swal({   
												title: 'Informasi',   
												type: 'info',    
												html: true, 
												text: msg.message,
												confirmButtonColor: '#f7cb3b',   
											});		
											$($display).fadeOut(800, function(){
												$display.html(msg.displayIpk).fadeIn().delay(2000);
											});
										},
										error: function(err){
											console.log(err);
										}
									});
								});

								$(".prc_ips").click(function(event){
									event.preventDefault();
									var thn = $(this).data('thn');
									var nim = $(this).data('nim');
									var kdf = $(this).data('kdf');
									var kdj = $(this).data('kdj');

									var dataku = 'thn='+thn+'&nim='+nim+'&kdf='+kdf+'&kdj='+kdj;
									$body = $("body");
									$body.addClass("loading");
									//alert($('#formPrcKrs').serialize());
									$.ajax({
										url: "<?= base_url('ademik/mhswipk/prosesIps'); ?>",
										data: dataku,
										type: 'POST',
										dataType: 'json',
										cache : false,
										success: function(msg){ 
											$body.removeClass("loading");
											//alert(msg.isi+" "+msg.nim+" "+msg.semesterAkademik);
											//alert(msg);	
											swal({   
												title: 'Informasi',   
												type: 'info',    
												html: true, 
												text: msg.message,
												confirmButtonColor: '#f7cb3b',   
											});		
											$($display).fadeOut(800, function(){
												$display.html(msg.displayIpk).fadeIn().delay(2000);
											});
										},
										error: function(err){
											console.log(err);
										}
									});
								})
								
								$(".prc_ipk").click(function(event){
									event.preventDefault();
									var thn = $(this).data('thn');
									var nim = $(this).data('nim');
									var kdf = $(this).data('kdf');
									var kdj = $(this).data('kdj');

									var dataku = 'thn='+thn+'&nim='+nim+'&kdf='+kdf+'&kdj='+kdj;
									$body = $("body");
									$body.addClass("loading");
									//alert($('#formPrcKrs').serialize());
									$.ajax({
										url: "<?= base_url('ademik/mhswipk/prosesIpk'); ?>",
										data: dataku,
										type: 'POST',
										dataType: 'json',
										cache : false,
										success: function(msg){ 
											$body.removeClass("loading");
											//alert(msg.isi+" "+msg.nim+" "+msg.semesterAkademik);
											//alert(msg);	
											swal({   
												title: 'Informasi',   
												type: 'info',    
												html: true, 
												text: msg.message,
												confirmButtonColor: '#f7cb3b',   
											});		
											$($display).fadeOut(800, function(){
												$display.html(msg.displayIpk).fadeIn().delay(2000);
											});
										},
										error: function(err){
											console.log(err);
										}
									});
								})

								/*$(".hps_ipk").click(function(event){
									event.preventDefault();
									var KHSId = $(this).data('KHSId');
									var nim = $(this).data('nim');
									var thn = $(this).data('thn');

									var dataku = 'thn='+thn+'&nim='+nim+'&KHSId='+KHSId;
									$body = $("body");
									$body.addClass("loading");
									//alert($('#formPrcKrs').serialize());
									$.ajax({
										url: "<?= base_url('ademik/mhswipk/hapusIpk'); ?>",
										data: dataku,
										type: 'POST',
										dataType: 'json',
										cache : false,
										success: function(msg){ 
											$body.removeClass("loading");
											//alert(msg.isi+" "+msg.nim+" "+msg.semesterAkademik);
											//alert(msg);	
											swal({   
												title: 'Informasi',   
												type: 'info',    
												html: true, 
												text: msg.message,
												confirmButtonColor: '#f7cb3b',   
											});		
											$($display).fadeOut(800, function(){
												$display.html(msg.displayIpk).fadeIn().delay(2000);
											});
										},
										error: function(err){
											console.log(err);
										}
									});
								})*/
								
						},
						error: function(err){
							console.log(err);
						}
					});
				});

				function clearView(){
					/*$('#semesterAkademik').val('');
					$('#nim').val('');
					$('#nama').val('');
					$('#jurusan').val('');
					$('#program').val('');
					$('#dosen').val('');*/
				}
			});

			$(document).on("click", ".hps_ipk", function () {
				var KHSId = $(this).data('khsid');
				var nim = $(this).data('nim');
				var thn = $(this).data('thn');

				var dataku = 'thn='+thn+'&nim='+nim+'&KHSId='+KHSId;
				//alert($('#formPrcKrs').serialize());
				swal({
					title: "Peringatan",
					text: "Yakin data ingin dihapus..?",
					type: "warning",
					showCancelButton: true,   
					html: true, 
					confirmButtonColor: '#DD6B55',
					confirmButtonText: 'Iya',
					cancelButtonText: "Batal",
					closeOnConfirm: false,
					closeOnCancel: false
				},
				function(isConfirm) {
					if (isConfirm) {	
						$body = $("body");
						$body.addClass("loading");
						$.ajax({
							url: "<?= base_url('ademik/mhswipk/hapusIpk'); ?>",
							data: dataku,
							type: 'POST',
							dataType: 'json',
							cache : false,
							success: function(msg){ 
								$body.removeClass("loading");
								swal({   
									title: 'Success !',   
									type: 'success',    
									html: true, 
									text: msg.message,
									confirmButtonColor: '#f7cb3b',   
								});		
								$("#row_"+msg.id).fadeOut(800);
							},
							error: function(err){
								console.log(err);
							}
						});
					}else{
						swal("Batal", "Proses hapus dibatalkan", "error");
					}
				});	
			})








			$(document).on("click", "#refreshIPK", function () {
				var nim = $(this).data('nim');
				var semesterAkademik = $(this).data('thn');
				var dataku = 'nim='+nim+'&semesterAkademik='+semesterAkademik;
				$body = $("body");
				$body.addClass("loading");
				$display = $("#boxContent");
				$.ajax({
					url: "<?= base_url('ademik/mhswkrs/refreshIpk'); ?>",
					data: dataku,
					type: 'POST',
					dataType: 'json',
					cache : false,
					success: function(msg){ 
						$body.removeClass("loading");

						swal({   
							title: 'Informasi',   
							type: 'info',    
							html: true, 
							text: msg.message,
							confirmButtonColor: '#f7cb3b',   
						});
						$($display).fadeOut(800, function(){
							$display.html(msg.tampil).fadeIn().delay(2000);
						});						
					},
					error: function(err){
						console.log(err);
					}
				});				
			});
			

			$(document).on("click", "#openModalKrs", function () {
				var id = $(this).data('id');
				var name = $(this).data('name');
				var kdj = $(this).data('kdj');
				var kdp = $(this).data('kdp');
				var nim = $(this).data('nim');
				var semesterAkademik = $(this).data('semester-akademik');
				var dataku = 'id='+id+'&name='+name+'&kdj='+kdj+'&kdp='+kdp+'&nim='+nim+'&semesterAkademik='+semesterAkademik;
				$body = $("body");
				$body.addClass("loading");
				$.ajax({
					url: "<?= base_url('ademik/mhswkrs/addKrs'); ?>",
					data: dataku,
					type: 'POST',
					dataType: 'json',
					cache : false,
					success: function(msg){ 
						$body.removeClass("loading");
						document.getElementById("isiAddKrs").innerHTML = msg.isi;

						var button = document.querySelector('#prckrs');
						button.addEventListener('click', function (event) {
							event.preventDefault();
							$body = $("body");
							$body.addClass("loading");
							//alert($('#formPrcKrs').serialize());
							$.ajax({
								url: "<?= base_url('ademik/mhswkrs/saveKrs'); ?>",
								data: $('#formPrcKrs').serialize(),
								type: 'POST',
								dataType: 'json',
								cache : false,
								success: function(msg){ 
									$body.removeClass("loading");
									//alert(msg.isi+" "+msg.nim+" "+msg.semesterAkademik);
									//alert(msg);	
									if(msg.error){
										swal({   
											title: 'Peringatan',   
											type: 'warning',    
											html: true, 
											text: msg.error,
											confirmButtonColor: '#f7cb3b',   
										});		
									}else{
										swal({
											title: "Success !",
											text: msg.msg,
											icon: "success",
											button: "Ok",  
											html: true, 
										});						
									}			
											
								},
								error: function(err){
									console.log(err);
								}
							});
						});
					},
					error: function(err){
						console.log(err);
					}
				});
			});

			$(document).on("click", "#openModalRegistrasiUlang", function () {
				var nim = $(this).data('nim');
				var semesterAkademik = $(this).data('semester-akademik');
				var dataku = 'nim='+nim+'&semesterAkademik='+semesterAkademik;
				$body = $("body");
				$body.addClass("loading");
				$.ajax({
					url: "<?= base_url('ademik/mhswkrs/registrasiUlang'); ?>",
					data: dataku,
					type: 'POST',
					dataType: 'json',
					cache : false,
					success: function(msg){ 
						$body.removeClass("loading");

						if(msg.isi==""){
							swal({   
								title: 'Peringatan',   
								type: 'warning',    
								html: true, 
								text: msg.error,
								confirmButtonColor: '#f7cb3b',   
							});		
						}else{
							document.getElementById("isiRegistrasiUlang").innerHTML = msg.isi;

							var button = document.querySelector('#prcaddssi');
							$display = $("#displayMhsw");
							button.addEventListener('click', function (event) {
								event.preventDefault();
								$body = $("body");
								$body.addClass("loading");
								//alert($('#formPrcKrs').serialize());
								$.ajax({
									url: "<?= base_url('ademik/mhswkrs/prcAddSsi'); ?>",
									data: $('#formRegUlang').serialize(),
									type: 'POST',
									dataType: 'json',
									cache : false,
									success: function(msg){ 
										$body.removeClass("loading");
										//alert(msg.isi+" "+msg.nim+" "+msg.semesterAkademik);
										//alert(msg);	
										swal({   
											title: 'Informasi',   
											type: 'info',    
											html: true, 
											text: msg.message,
											confirmButtonColor: '#f7cb3b',   
										});		
										$($display).fadeOut(800, function(){
											$display.html(msg.displayMhs).fadeIn().delay(2000);
										});
									},
									error: function(err){
										console.log(err);
									}
								});
							});

							var button1 = document.querySelector('#displayConfirmReg');
							button1.addEventListener('click', function (event) {
								var nim = $(this).data('nim');
								var thn = $(this).data('thn');
								var dataku = 'nim='+nim+'&thn='+thn;
								$body = $("body");
								$body.addClass("loading");
								$.ajax({
									url: "<?= base_url('ademik/mhswkrs/DispConfirmReg'); ?>",
									data: dataku,
									type: 'POST',
									dataType: 'json',
									cache : false,
									success: function(msg){ 
										$body.removeClass("loading");
										swal({
											title: msg.title,
											text: msg.message,
											type: "warning",
											showCancelButton: true,   
											html: true, 
											confirmButtonColor: '#DD6B55',
											confirmButtonText: 'Registrasi Ulang',
											cancelButtonText: "Batalkan",
											closeOnConfirm: false,
											closeOnCancel: false
										},
										function(isConfirm) {
											if (isConfirm) {							
												$display = $("#displayMhsw");
												$body = $("body");
												$body.addClass("loading");
												$.ajax({
													url: "<?= base_url('ademik/mhswkrs/prcRegUlang'); ?>",
													data: dataku,
													type: 'POST',
													dataType: 'json',
													cache : false,
													success: function(msg){ 
														$body.removeClass("loading");
														swal({
															title: 'Sukses',
															text: msg.success,
															type: 'info',
															html: true, 
														});
														$($display).fadeOut(800, function(){
															$display.html(msg.displayMhs).fadeIn().delay(2000);
														});
													},
													error: function(err){
														console.log(err);
													}
												});
											} else {
												swal("Batal", "Registrasi Ulang Batal", "error");
											}
										});
									},
									error: function(err){
										console.log(err);
									}
								});
							})
						}
					},
					error: function(err){
						console.log(err);
					}
				});
			});

			$(document).on("click", "#openModalPaket", function () {
				var id = $(this).data('id');
				var name = $(this).data('name');
				var kdj = $(this).data('kdj');
				var kdp = $(this).data('kdp');
				var nim = $(this).data('nim');
				var semesterAkademik = $(this).data('semester-akademik');
				var dataku = 'id='+id+'&name='+name+'&kdj='+kdj+'&kdp='+kdp+'&nim='+nim+'&semesterAkademik='+semesterAkademik;
				$body = $("body");
				$body.addClass("loading");
				$.ajax({
					url: "<?= base_url('ademik/mhswkrs/KRSForm2'); ?>",
					data: dataku,
					type: 'POST',
					dataType: 'json',
					cache : false,
					success: function(msg){ 
						$body.removeClass("loading");
						document.getElementById("isiAddPaket").innerHTML = msg.isi;

						var button = document.querySelector('#prcPaket');
						button.addEventListener('click', function (event) {
							event.preventDefault();
							$body = $("body");
							$body.addClass("loading");
							//alert($('#formPrcKrs').serialize());
							$.ajax({
								url: "<?= base_url('ademik/mhswkrs/saveKrs'); ?>",
								data: $('#formPrcKrs').serialize(),
								type: 'POST',
								dataType: 'json',
								cache : false,
								success: function(msg){ 
									$body.removeClass("loading");
									//alert(msg.isi+" "+msg.nim+" "+msg.semesterAkademik);
									//alert(msg);	
									if(msg.error){
										swal({   
											title: 'Peringatan',   
											type: 'warning',    
											html: true, 
											text: msg.error,
											confirmButtonColor: '#f7cb3b',   
										});		
									}else{
										swal({
											title: "Success !",
											text: msg.msg,
											icon: "success",
											button: "Ok",  
											html: true, 
										});						
									}			
											
								},
								error: function(err){
									console.log(err);
								}
							});
						});
					},
					error: function(err){
						console.log(err);
					}
				});
			});
		}
	}, 100);
</script>  
