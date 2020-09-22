<!-- <?php  
echo "<pre>";
print_r($data);
echo "<pre>";
?> -->

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      	LIHAT DAFTAR MAHASISWA CUTI
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="">Tables</a></li>
        <li class="breadcrumb-item active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
         
         <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Mahasiswa Cuti</h3>
            </div>

            	<div class="box-header">
              		<a href="<?=base_url();?>ademik/Mhswcuti/" class="btn btn-info btn-flat" >
                  		<i class="fa fa-hand-o-left"></i> Kembali </a>
            	</div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped table-responsive">
                <thead>
        					<tr>
                    	<th>NIM</th>
      								<th>Nama</th>
      								<th>Program</th>
      								<th>Fakultas</th>
      								<th>Jurusan</th>
      								<th>Tahun Cuti</th>
        					</tr>
        				</thead>
        				<tbody>
        					<?php foreach ($data as $da) { ?>
                    	<tr>  
          						<td><?php echo $da['NIM']; ?></td>
          						<th><?php echo $da['Name']; ?></th>
      								<th><?php echo $da['KodeProgram']; ?></th>
      								<th><?php echo $da['nmf']; ?></th>
      								<th><?php echo $da['nmj']; ?></th>
      								<th><?php echo $da['periode']; ?></th>
          					</tr>
                  			<?php } ?>
        				</tbody>
              </table>
            </div>
          </div>         
       
        </div>
      </div>
    </section>
  </div>
  
  
  
  <script src="<?=base_url()?>assets/js/pages/data-table.js"></script>