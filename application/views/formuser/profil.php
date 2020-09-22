<div class="container" style="padding-top: 60px;">
  <h1 class="page-header"></h1>
  <div class="row">
    <!-- left column -->
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="text-center">
        <span class="ks-avatar">
            <img src="<?php echo base_url();?>FScript/assets/img/avatars/avatar-2.jpg" width="200" height="200">
        </span>
    <form enctype="multipart/form-data" action="<?=base_url();?>menu/upload" method="post">
        <h6>Upload a different photo...</h6>
        <input type="file" class="text-center center-block well well-sm" name="imgpro" id="imgpro">
        <div>
        <input type="submit"  id="wp-submit" name="uploadpro" class="btn btn-primary-outline" value="Upload" />
      </div>
      </div>
    </form>
    </div>
    <!-- edit form column -->
    <div class="col-md-6 col-sm-6 col-xs-12 personal-info">
      <h3>Personal info</h3>
      <br />    
<?php 
foreach ($profil as $a){
    ?>
      <form class="form-horizontal" role="form">
        <div class="form-group">
          <label class="col-lg-3 control-label"><strong>NIM</strong></label>
          <label class="col-lg-8">: <?=$a->NIM?></label>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label"><strong>Nama Lengkap</strong></label>
          <label class="col-lg-8">: <?=$a->Name?></label>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label"><strong>T.T.L</strong></label>
          <label class="col-lg-5">: Palu, 12 Desember 1989</label>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label"><strong>Agama</strong></label>
          <label class="col-lg-5">: Kong wu chu</label>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label"><strong>Jenis Kelamin</strong></label>
          <label class="col-lg-8">: Laki-Laki</label>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label"><strong>Jurusan</strong></label>
          <label class="col-lg-5">: Hukum Perdata</label>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label"><strong>Angkatan</strong></label>
          <label class="col-lg-5">: 2011</label>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label"><strong>Alamat</strong></label>
          <label class="col-lg-5">: Jalan Kangkung no. xx</label>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label"><strong>Email</strong></label>
          <label class="col-lg-5">: aaaaaaa@gmail.com</label>
        </div>
        </form>
 <?php
  }
  ?>
    </div>
  </div>
</div>