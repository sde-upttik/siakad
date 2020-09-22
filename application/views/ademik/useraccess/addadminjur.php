<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Add Admin Jurusan
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<!-- <li class="breadcrumb-item"><a href="<?= $_SESSION['tamplate'] ?>">KRS</a></li> -->
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Add Admin Jurusan</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<?php
							if($this->session->flashdata('error')!=null||$this->session->flashdata('error')!=""){
								echo $this->session->flashdata('error');
							}
						?>
						<form action="<?= base_url('ademik/useraccess/storeAdminJurusan'); ?>" method="POST">
							<div class="form-group row">
							  <label for="Login" class="col-md-2 col-form-label">Nama Login</label>
							  <div class="col-md-6">
								<input class="form-control" type="text" id="Login" name="Login">
							  </div>
							</div>
							<div class="form-group row">
							  <label for="name" class="col-md-2 col-form-label">Nama Lengkap</label>
							  <div class="col-md-6">
								<input class="form-control" type="text" id="name" name="full_name">
							  </div>
							</div>
							<div class="form-group row">
							  <label for="email" class="col-md-2 col-form-label">Email</label>
							  <div class="col-md-6">
								<input class="form-control" type="email" id="email" name="Email">
							  </div>
							</div>
							<div class="form-group row">
							  <label for="password" class="col-md-2 col-form-label">Password</label>
							  <div class="col-md-6">
								<input class="form-control" type="password" id="password" name="Password">
							  </div>
							</div>		
							<div class="form-group row">
							  <label for="phone" class="col-md-2 col-form-label">Telepon</label>
							  <div class="col-md-6">
								<input class="form-control" type="text" id="phone" name="Phone">
							  </div>
							</div>		
							
							<?php
								if($this->session->ulevel== '1'){
							?>
									<div class="form-group row">
									  <label for="phone" class="col-md-2 col-form-label">Kode Fakultas</label>
									  <div class="col-md-6">
										<select class="form-control" id="KodeFakultas" name="KodeFakultas">
											<?php
												foreach ($fakultas as $show) {
											?>
												<option value="<?= $show->Kode; ?>"><?= $show->Kode." - ".$show->Singkatan; ?></option>
											<?php
												}
											?>
										</select>
									  </div>
									</div>		
									<div class="form-group row">
									  <label for="phone" class="col-md-2 col-form-label">Kode Jurusan</label>
									  <div class="col-md-6">
										<select class="form-control" id="KodeJurusan" name="KodeJurusan">
										
										</select>
									  </div>
									</div>		
					        <?php		
								}else{
							?>
									<div class="form-group row">
									  <label for="phone" class="col-md-2 col-form-label">Kode Fakultas</label>
									  <div class="col-md-6">
										<input class="form-control" type="text" readonly name="KodeFakultas" id="KodeFakultas" value="<?= $this->session->kdf; ?>">
									  </div>
									</div>		
									<div class="form-group row">
									  <label for="phone" class="col-md-2 col-form-label">Kode Jurusan</label>
									  <div class="col-md-6">
										<select class="form-control" id="KodeJurusan" name="KodeJurusan">
										
										</select>
									  </div>
									</div>
							<?php
								}
							?>
							<div class="form-group row">
			                  <label for="description" class="col-md-2 col-form-label">Keterangan</label>
			                  <div class="col-md-10">
			                	<textarea class="form-control" rows="3" id="description" name="Description" placeholder=""></textarea>
			                  </div>
			                </div>
							<div class="form-group row">
								<div class="col-md-12" style="text-align: center;">
									<input type="submit" name="simpan" value="Simpan" class="btn bg-olive">
									<input type="reset" value="Reset" class="btn bg-orange">
									<a href="<?= base_url('ademik/useraccess/adminjur'); ?>" class="btn btn-danger">Kembali</a>
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
	</section>
	<!-- /.content -->
</div>

<script type="text/javascript">
	var i = setInterval(function() {
        if ($) {
            clearInterval(i);
            $(function(){
            	var kdf = $('#KodeFakultas').val();
        		var dataku = 'KodeFakultas='+kdf;
                $.ajax({
					url: "<?= base_url('ademik/useraccess/getJurusan'); ?>",
					data: dataku,
					type: 'POST',
					dataType: 'json',
					cache : false,
					success: function(msg){ 
						var data = msg.data.split("+");
						var count = data[1];
						var row = data[0].split("=");
						for (var i = 0; i <= count; i++) {
							var isi = row[i].split("|");
							var kode = isi[0];
							var nama = isi[1];
							
							//console.log(kode+" "+nama);
							$("#KodeJurusan").append("<option value='"+kode+"'>"+kode+" - "+nama+" </option>");
						}
						//console.log(msg.data);
					},
					error: function(err){
						//console.log(err);
					}
				});
            	$('#KodeFakultas').change(function(){
            		var kdf = $('#KodeFakultas').val();
            		var dataku = 'KodeFakultas='+kdf;
            		$("#KodeJurusan").find('option').remove();
                    $.ajax({
						url: "<?= base_url('ademik/useraccess/getJurusan'); ?>",
						data: dataku,
						type: 'POST',
						dataType: 'json',
						cache : false,
						success: function(msg){ 
							var data = msg.data.split("+");
							var count = data[1];
							var row = data[0].split("=");
							for (var i = 0; i <= count; i++) {
								var isi = row[i].split("|");
								var kode = isi[0];
								var nama = isi[1];
								
								//console.log(kode+" "+nama);
								$("#KodeJurusan").append("<option value='"+kode+"'>"+kode+" - "+nama+" </option>");
							}
							//console.log(msg.data);
						},
						error: function(err){
							//console.log(err);
						}
					});
                });
           	})
        }
    }, 100);    
</script>