<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Program Pengalaman Lapangan (PPL)
      </h1>
      <!-- <br><h3>
        PERINGATAN !!!
        <small style="color: red">jangan dulu dikore Lagi perbaikan</small>
      </h3> -->
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="#">Tables</a></li>
        <li class="breadcrumb-item active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
         
         <div class="box">
            <div class="box-header">
              <!-- <h3 class="box-title" style="color: red;">Daftar PPL Lagi maintenance</h3> -->
              <h3 class="box-title" >Daftar PPL</h3>
            </div>
            

          <!-- /.Table header -->
          <div class="box-body">
            <form class="form-horizontal" action="<?php echo base_url().'ademik/daftarppl/Daftarppl/search_data' ?>" method="POST">
              <div class="form-group row">
                <label class="col-sm-1 control-lebel">Masukkan NIM :</label>
                <div class="col-sm-2">
                   <input class="form-control input-sm" type="text" name="nim" id="nim"> 
                </div>
                <div class="col-sm-2">
                   <input class="btn btn-flat btn-info" type="submit" id="search" name="search" value="Search"> 

                </div>
              </div>
            </form>
          </div> 
        </div>
        
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> Data Mahasiswa </h3>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <?php
              if(isset($alert)){
                  echo $alert;
              }else{
            ?>

            <?php
                }
            ?>                
          </div>
        </div>
    </div>
   </div>
  </div>
</div>
</section>       
            
  
  <!-- maximum_admin for Data Table -->
  <script> 

    function cari() {
      alert('tes');  
    }


  </script>
 