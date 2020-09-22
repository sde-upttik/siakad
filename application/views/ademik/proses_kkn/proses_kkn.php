 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kuliah Kerja Nyata (KKN)
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="#">KKN</a></li>
        <li class="breadcrumb-item active">Proses KKN</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
         
         <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar KKN</h3>
            </div>
            

            <!-- /.box-header -->
            <div class="box-body">
              <form class="form-horizontal" action="<?php echo base_url().'ademik/proses_kkn/proses_kkn/daftar' ?>" method="POST">
               <div class="form-group row">
                <label class="col-sm-1 control-lebel">Masukkan NIM :</label>
                    <div class="col-sm-2">
                       <input class="form-control input-sm" type="text" name="searchData" id="searchData">
                    </div>
                    <div class="col-sm-2">
                      <input class="btn btn-flat btn-info" type="submit" id="search" name="search" value="Search">
                    </div>
                </div>
              </form>
             </div>

             <?php
             if(isset($data)){
             ?>
                <div class="row" id="isiContent">
                <div class="col-12">
                  <div class="box">
                    <div class="box-header">
                      <h3 class="box-title">Proses KKN</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" id='boxContent' style="background-color: ;">
                      <?= $data; ?>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->   
                </div>
                <!-- /.col -->
              </div>
             <?php
              }
             ?>
          
          </div>
         </div>
        </div>
      </div>
     </section>       
            
  
  <!-- maximum_admin for Data Table -->
  <script src="<?=base_url()?>assets/js/pages/data-table.js"> </script>
 