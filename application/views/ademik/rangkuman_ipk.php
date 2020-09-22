<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Rangkuman IPK
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		</ol>
	</section>

	<section class="content">
		  	<div class="row">
		    	<div class="col-12">
		     
		     		<div class="box">
		        		<div class="box-header">
		          			<h3 class="box-title">Rangkuman Ipk Mahasiswa</h3>
		        		</div>

						<div class="box-body">
							<form class="form-horizontal" action="">
								<div class="form-group row">
									<label class="col-sm-2 control-label">NIM</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" id="nim" name="nim" placeholder="NIM">
									</div>

									<div class="col-sm-2">
										<input class="btn btn-flat btn-info" type="button" id="search" name="search" value="Search">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-2 control-label">NAMA</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" id="nama" name="nama" readonly="" placeholder="NAMA">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label">JURUSAN</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" id="jurusan" name="jurusan" readonly="" placeholder="JURUSAN">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label">PROGRAM</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" id="program" name="program" readonly="" placeholder="PROGRAM">
									</div>
								</div>
							</form>
						</div>
					</div>
		      		<!-- /.box -->       
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
	</section>
</div>