<style type="text/css">
  
  img {
    width: 500px;
    height: 500px;
  }

  .judul {
    font-size: 16px;
    font-weight: 600;
  }

  .ket {
    color: #999;
    font-size: 13px;
  }

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
        Dashboard
        <!-- <small>Control panel</small> -->
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url()?>/menu"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- boxes (Stat box) -->
      <div class="row">
        <div class="col-xl-3 col-md-6 col">
          <div class="info-box bg-blue">
            <!-- <span class="info-box-icon push-bottom"><i class="ion ion-ios-pricetag-outline"></i></span> -->

            <div class="info-box-content">
              <!-- <span class="info-box-text">New Clients</span>
              <span class="info-box-number">450</span>

              <div class="progress">
                <div class="progress-bar" style="width: 45%"></div>
              </div>
              <span class="progress-description">
                    45% Increase in 28 Days
              </span> -->
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-xl-3 col-md-6 col">
          <div class="info-box bg-green">
            <!-- <span class="info-box-icon push-bottom"><i class="ion ion-ios-eye-outline"></i></span> -->

            <div class="info-box-content">
              <!-- <span class="info-box-text">Total Visits</span>
              <span class="info-box-number">15,489</span>

              <div class="progress">
                <div class="progress-bar" style="width: 40%"></div>
              </div>
              <span class="progress-description">
                    40% Increase in 28 Days
                  </span> -->
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-xl-3 col-md-6 col">
          <div class="info-box bg-purple">
            <!-- <span class="info-box-icon push-bottom"><i class="ion ion-ios-cloud-download-outline"></i></span> -->

            <div class="info-box-content">
              <!-- <span class="info-box-text">Downloads</span>
              <span class="info-box-number">55,005</span>

              <div class="progress">
                <div class="progress-bar" style="width: 85%"></div>
              </div>
              <span class="progress-description">
                    85% Increase in 28 Days
                  </span> -->
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-xl-3 col-md-6 col">
          <div class="info-box bg-red">
            <!-- <span class="info-box-icon push-bottom"><i class="ion-ios-chatbubble-outline"></i></span> -->

            <div class="info-box-content">
              <!-- <span class="info-box-text">Direct Chat</span>
              <span class="info-box-number">13,921</span>

              <div class="progress">
                <div class="progress-bar" style="width: 50%"></div>
              </div>
              <span class="progress-description">
                    50% Increase in 28 Days
                  </span> -->
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-xl-6 connectedSortable">
          <div class="box">
            <div class="box-header">
                <div class="box-body">
                  	<div>
                    	<span class="judul"><?= $berita->Judul; ?></span><br>
                    	<span class="ket">Posting By <?= $berita->Author; ?> | <?= $berita->Tgl; ?></span>
                  	</div>
                  	<div class="box-body">
                      <div class="text-center">
                    		<?php if ( empty($berita->foto_berita) ) { ?>
  	                      <img class="img-fluid pad" src="<?=base_url();?>assets/images/Berita/notimages.jpg" alt="Photo">
  	                    <?php } else  { ?>
  	                      <img class="img-fluid pad" src="<?=base_url();?>assets/images/Berita/<?= $berita->foto_berita; ?>" alt="Photo">
  	                    <?php } ?>
                      </div>
		              	<p><?= $berita->Konten ;?></p>
		              	<!-- <button type="button" class="btn btn-default btn-sm bg-blue-active"><i class="fa fa-share"></i> Share</button>
		              	<button type="button" class="btn btn-default btn-sm bg-green-active"><i class="fa fa-thumbs-o-up"></i> Like</button> -->
		              	<span class="pull-right text-muted"><i class="fa fa-reply" style="color: red;"></i><a title="Kembali" href="<?=base_url();?>menu"><span style="color: red;"> Kembali</span></a></span>
		            </div>
                </div>
            </div>

        </section>
        <!-- /.Left col -->
        
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-xl-6 connectedSortable">
          <div class="box box-info">
            <div class="box-header">
          	</div>
          </div>

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
