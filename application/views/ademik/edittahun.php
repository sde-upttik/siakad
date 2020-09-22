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
			Edit Tahun Akademik
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">EDIT TAHUN AKADEMIK</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<form class="form-horizontal" action="<?= base_url('ademik/mhswipk/updatetahunakademik'); ?>" method="POST">
							<div class="form-group row">
								<label class="col-sm-2 control-label">NIM</label>
								<div class="col-sm-4">
									<input type="hidden" name="id" value="<?= $id; ?>">
									<input type="text" class="form-control" name="nim" readonly placeholder="NIM" value="<?= $nim; ?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label">SEMESTER</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="semester" placeholder="SEMESTER" value="<?= $semester; ?>">
								</div>
							</div>
							<input type="submit" name="ubah" value="ubah" class="btn btn-primary">
							<a href="<?= base_url('ademik/mhswipk'); ?>" class="btn btn-warning">Kembali</a>							
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