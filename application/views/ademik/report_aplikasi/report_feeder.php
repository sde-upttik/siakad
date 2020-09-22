<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Report View Dari Feeder
		</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="col-md-12 col-lg-12">
		 <div class="row">
			 <div class="col-12">
				 <div class="box">
					 <div class="box-header with-border">
						 <h3 class="box-title"><i class="fa fa-info"></i> Catatan : Message Import.</h3>
					 </div>
					 <!-- /.box-header -->
					 <div class="box-body">
						 <table class="table table-bordered table-responsive">
							 <tr>
								 <th style="width: 10px">#</th>
								 <th>Kategori</th>
								 <th>Keterangan</th>
							 </tr>
							 <tr>
								 <td>1.</td>
								 <td>Prodi</td>
								 <td><?=$nama_program_studi?></td>
							 </tr>
							 <tr>
								 <td>2.</td>
								 <td>Tahun</td>
								 <td><?=$id_semester." - ".$nama_semester?><br></td>
							 </tr>
							 <tr>
								 <td>3.</td>
								 <td>Nama Matakuliah</td>
								 <td><?=$kode_mata_kuliah." - ".$nama_mata_kuliah?></td>
							 </tr>
							 <tr>
								 <td>4.</td>
								 <td>Kelas</td>
								 <td><?=$nama_kelas_kuliah?></td>
							 </tr>
							 <tr>
								 <td>5.</td>
								 <td>SKS</td>
								 <td><?=$sks?></td>
							 </tr>
							 <tr>
								 <td>6.</td>
								 <td>Jumlah Mahasiswa</td>
								 <td><?=$jumlah_mahasiswa?></td>
							 </tr>

							 <?php
			 					foreach ($nama_dosen as $row){
			 							echo "
										<tr>
		 								 <td>#</td>
		 								 <td>Dosen</td>
		 								 <td>$row</td>
		 							 </tr>";
			 					}
			 				?>


						 </table>
					 </div>

				 </div>
				 <!-- /.box -->
				</div>
			 <!-- /.col -->
		 </div>
	 </div>
	</section>
</div>
