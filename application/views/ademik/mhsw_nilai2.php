<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Input Nilai Mahasiswa
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="#">Dosen</a></li>
        <li class="breadcrumb-item active">Nilai Mahasiswa 2</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="box box-default">
        	<div class="box-header with-border">
          		<h3 class="box-title"></h3>
		        <div class="box-tools pull-right">
		        	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		        	<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
		        </div>
        	</div>

	        <!-- /.box-header -->
			<form id="form_validation">
		        <div class="box-body">
		        	<div class="row">
		        		<!-- Semester Akademik -->
		            	<div class="col-md-3 col-sm-12 col-xs-12">
		              		<div class="form-group">
		                		<label for="semesterAkademik">Semester Akademik</label>
								<input type="number" maxlength="6" minlength="5" min="20051"  class="form-control" id="semesterAkademik" name="semesterAkademik" placeholder="Semester Akademik"  required />
		              		</div>
		            	</div>

			            <!-- Program -->
						<div class="col-md-4 col-sm-12 col-xs-12">
			            	<div class="form-group">
			            		<label for="program">Program</label>
			            			<select class="form-control select2" style="width: 100%;" id="program" name="program" required>
										<option selected="selected" value="">--- Pilih Program ---</option>
										<option value="REG">REG - REGULER</option>
										<option value="NONREG">NON REG - NON REGULER</option>
			                		</select>
			            	</div>
						</div>			            

						<!-- Jurusan  -->
						<div class="col-md-5 col-sm-12 col-xs-12">
			            	<div class="form-group">
			            		<label for="jurusan">Jurusan</label>
			            			<select class="form-control select2" style="width: 100%;" id="jurusan" name="jurusan" required>
										<option selected="selected" value="">--- Pilih Jurusan ---</option>
										<?php foreach ($data_jurusan as $jurusan) { ?>
											<option value="<?php echo $jurusan['Kode'] ?>"> <?php echo$jurusan['Kode']." - ".$jurusan['Nama_Indonesia'] ?></option>
										<?php } ?>
			                		</select>
			            	</div>
						</div>
		          	</div>

		         	<div class="row">
		         		<div class="col-md-12 col-12">
			           		<div class="form-group">
			                    <button class="btn btn-primary flat-btn float-right" id="btn_kirim">Cari</button>
			            	</div>
			            </div>
		         	</div>
		        
		        </div>
			</form>
    	</div>
    </section>
    
    <section id="load_content" class="content" style="padding-top: 0"></section>
</div>

