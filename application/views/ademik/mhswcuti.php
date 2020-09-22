 <!-- <?php
if(isset($data[0])){
  echo "<pre>";
  print_r($data1);
  print_r($dosen);
  echo "</pre>";
} ?>  -->
 


<div class="content-wrapper">

    <section class="content-header">
      <h1>
        DAFTAR MAHASISWA CUTI
      </h1>
    </section>

    <section class="content" style="padding-bottom: 0;">
        <!-- Form Pecarian Jadwal -->
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Mahasiswa Cuti</h3>
          </div>

          <div class="box-body">
            <div class="row">
              <div class="col-12">
                <form id="cari1" action="<?php echo base_url().'ademik/Mhswcuti/search' ?>" method="POST">

                  <!-- INPUT  -->
                  <div class="form-group row">
                    <label for="input_semester" class="col-md-2 col-form-label">NIM</label>
                    <div class="col-sm-4">
                      <input class="form-control" type="text" id="nim" name="nim" required value="<?php if(isset($data[0])){ echo $data[0]['NIM'];}  ?>">
                    </div>
                  </div>

                  <!-- INPUT  -->
                  <div class="form-group row">
                    <label for="example-search-input" class="col-md-2 col-form-label col-xs-12">Nama Mahasiswa</label>
                    <div class="col-sm-4">
                      <input class="form-control" type="text" name="nama" readonly placeholder="Nama Mahasiswa" value="<?php if(isset($data[0])){ echo $data[0]['Name'];}  ?>">
                    </div>
                  </div>                

                  <!-- INPUT   -->
                  <div class="form-group row">
                    <label for="example-search-input" class="col-md-2 col-form-label col-xs-12">Fakultas</label>
                    <div class="col-sm-4">
                      <input class="form-control" type="text" name="fakultas" readonly placeholder="Fakultas" value="<?php if(isset($data[0])){ echo $data[0]['KodeFakultas']." - ".$data[0]['FAK'];}  ?>">
                    </div>
                  </div>

                  <!-- INPUT   -->
                  <div class="form-group row">
                    <label for="example-search-input" class="col-md-2 col-form-label col-xs-12">Jurusan</label>
                    <div class="col-sm-4">
                      <input class="form-control" type="text" name="jurusan" readonly placeholder="Jurusan" value="<?php if(isset($data[0])){ echo $data[0]['KodeJurusan']." - ". $data[0]['JUR'];}  ?>">
                    </div>
                  </div>

                  <!-- INPUT   -->
                  <div class="form-group row">
                    <label for="example-search-input" class="col-md-2 col-form-label col-xs-12">Jenjang</label>
                    <div class="col-sm-4">
                      <input class="form-control" type="text" name="jenjang" readonly placeholder="Jenjang" value="<?php if(isset($data[0])){ echo $data[0]['JEN'];}  ?>">
                    </div>
                  </div>

                  <!-- INPUT   -->
                  <div class="form-group row">
                    <label for="example-search-input" class="col-md-2 col-form-label col-xs-12">Dosen Penasehat</label>
                    <div class="col-sm-4">
                      <input class="form-control" type="text" name="desen_penasehat" readonly placeholder="Dosen Penasehat" value="<?php if(isset($data[0])){ echo $data[0]['DSN'];}  ?>">
                    </div>            
                  </div>

                  <!-- Tombol Submit validasi -->
                  <div class="form-group row">
                     
                     <div class="col-sm-2">
                        <a href="" class="btn btn-info btn-flat" data-toggle="modal" data-target="#daftar" >
                          <i class="fa fa"></i> Daftar Untuk Cuti</a>
                      </div>

                      <div class="col-sm-2" style="padding-right: 16%;">
                        <a href="<?=base_url();?>ademik/Mhswcuti/daftar_mhsw_cuti/" class="btn btn-info btn-flat">
                          <i class=""></i> Lihat Daftar Mahasiswa Cuti</a>
                      </div>
                      
                     <div class="col-sm-1" style="padding-right: 0%;">
                      <input type="submit" value="Cari Mahasiswa" class="btn btn-info btn-flat" >
                    </div>
                  </div>

                  
              </div>
            </form>

                <div class="modal fade" id="daftar">
                    <div class="modal-dialog">
                      <div class="modal-content">
                          <?php 
                            $this->load->view('ademik/mhswcuti_mendaftar',$data1, $dosen);
                           ?>
                      </div>
                    </div>
                  </div>

              </div>
            </div>
          </div>
    </section>




</div>
  
  <script src="<?=base_url()?>assets/js/pages/data-table.js"></script>

  <script src="/assets/plugins/jquery_validation/jquery.form.js"></script>
  <script src="/assets/plugins/jquery_validation/jquery.validate.js"></script>
  <script type="text/javascript">
    
    function daftar(){

    }


   /* function hapus_semster(kode, jurusan, program) {
    $("#delet_semster").load("<?php echo base_url('index.php/ademik/Smtr_akademik/delete_data/')?>"+jurusan+"/"+program+"/"+kode, function (response, status, xhr) {
      if ( status == "error" ) {
        alert("gagal menghapus");
      }
      else{
        //alert("Data Berhasil Dihapus");
        load_tabel_semster();
      }
    });
  } 

  if(isset($data)){ echo $data[0]['NIM'];}  ?>
  
  */
// $(document).ready(function() {
//   cari();
// }  
// <?php echo base_url().'ademik/Mhswcuti/search' ?>

  function cari(){
  
  var $data = 'NIM';

  var nim = document.getElementById('nim');
    alert($data[0]['NIM']);
    if (($data[0]['NIM'] == nim )){
      //swal("Good job!","Data Telah Ditemukan", "Terimakasi");
    }else{
      swal("Oops...","Data Tidak Ditemukan", "error");
    } 

    // if (($data[0]['NIM'] == null ) {
    //   alert("sdflkj");
    //   $("#cari").load("<?php echo base_url('index.php/ademik/Smtr_akademik/delete_data/')?>");
    // }else{
    //   alert("tesss");
    // }

   }


  </script>