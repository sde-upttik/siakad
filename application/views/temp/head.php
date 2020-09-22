<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view('temp/head_css'); ?>

</head>

<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?=base_url()?>menu" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="<?=base_url()?>assets/images/mpt.png" class="img-fluid" alt="logo" /></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SIAKAD</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top top-navbar navbar-expand-md">

      <!-- Sidebar toggle button-->
      <a href="<?=base_url()?>#" class="sidebar-toggle d-block d-lg-none" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <ul class="navbar-nav mr-auto mt-md-0">
		<!-- .Megamenu -->
		<!-- <li class="nav-item dropdown mega-dropdown"> <a class="nav-link dropdown-toggle" href="<?=base_url()?>#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-th-large"></i></a>
			<div class="dropdown-menu scale-up-left">
				<ul class="mega-dropdown-menu row">
					<li class="col-lg-3 col-md-3 col-12 m-b-30">
						<h5 class="m-b-20">List style</h5> -->
						<!-- List style -->
						<!-- <ul class="list-style-none">
							<li><a href="<?=base_url()?>javascript:void(0)">You can give link</a></li>
							<li><a href="<?=base_url()?>javascript:void(0)">Give link</a></li>
							<li><a href="<?=base_url()?>javascript:void(0)">Another Give link</a></li>
							<li><a href="<?=base_url()?>javascript:void(0)">Forth link</a></li>
						</ul>
					</li>
					<li class="col-lg-3 col-md-3 col-12 m-b-30">
						<h5 class="m-b-20">List style</h5> -->
						<!-- List style -->
						<!-- <ul class="list-style-none">
							<li><a href="<?=base_url()?>javascript:void(0)">You can give link</a></li>
							<li><a href="<?=base_url()?>javascript:void(0)">Give link</a></li>
							<li><a href="<?=base_url()?>javascript:void(0)">Another Give link</a></li>
							<li><a href="<?=base_url()?>javascript:void(0)">Forth link</a></li>
						</ul>
					</li>
					<li class="col-lg-3 col-md-3 col-12 m-b-30">
						<h5 class="m-b-20">List style</h5> -->
						<!-- List style -->
						<!-- <ul class="list-style-none">
							<li><a href="<?=base_url()?>javascript:void(0)">You can give link</a></li>
							<li><a href="<?=base_url()?>javascript:void(0)">Give link</a></li>
							<li><a href="<?=base_url()?>javascript:void(0)">Another Give link</a></li>
							<li><a href="<?=base_url()?>javascript:void(0)">Forth link</a></li>
						</ul>
					</li>
					<li class="col-lg-3 col-md-3 col-12 m-b-30">
						<h5 class="m-b-20">List style</h5> -->
						<!-- List style -->
						<!-- <ul class="list-style-none">
							<li><a href="<?=base_url()?>javascript:void(0)">You can give link</a></li>
							<li><a href="<?=base_url()?>javascript:void(0)">Give link</a></li>
							<li><a href="<?=base_url()?>javascript:void(0)">Another Give link</a></li>
							<li><a href="<?=base_url()?>javascript:void(0)">Forth link</a></li>
						</ul>
					</li>
				</ul>
			</div>
                        </li> -->
		<!-- /.Megamenu -->
	</ul>
	<?php $ulevel  = $this->session->userdata('ulevel'); if (!empty($ulevel)){
		/*$CI=&get_instance();
		$data = $CI->fotoProfil();*/
		 ?>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <!--<li class="dropdown messages-menu">
            <a href="<?=base_url()?>#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope"></i>
              <span class="label label-success">5</span>
            </a>
            <ul class="dropdown-menu scale-up">
              <li class="header">You have 5 messages</li>
              <li>
                <!-- inner menu: contains the actual data -1->
                <ul class="menu inner-content-div">
                  <li><!-- start message -1->
                    <a href="<?=base_url()?>#">
                      <div class="pull-left">
                        <img src="<?=base_url()?>assets/images/user2-160x160.jpg" class="rounded-circle" alt="User Image">
                      </div>
                      <div class="mail-contnet">
                         <h4>
                          Lorem Ipsum
                          <small><i class="fa fa-clock-o"></i> 15 mins</small>
                         </h4>
                         <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                      </div>
                    </a>
                  </li>
                  <!-- end message -1->
                </ul>
              </li>
              <li class="footer"><a href="<?=base_url()?>#">See all e-Mails</a></li>
            </ul>
          </li>-->
		  <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="<?=base_url()?>#" class="dropdown-toggle" data-toggle="dropdown">
            	<?php if ( $this->session->userdata('sex') == 'P') { ?>
					<img class="user-image rounded-circle" src="<?=base_url()?>assets/images/puan.png" alt="User Image">
				<?php } else { ?>
					<img class="user-image rounded-circle" src="<?=base_url()?>assets/images/laki.png" alt="User Image">
				<?php } ?>
              <span class="d-none d-sm-inline-block"><?= $this->session->userdata('uname'); ?></span>
            </a>
            <ul class="dropdown-menu scale-up">
              <!-- User image -->
              <li class="user-header">
              	<?php if ( $this->session->userdata('sex') == 'P') { ?>
					<img src="<?=base_url()?>assets/images/puan.png" class="user-image rounded-circle" style="width: 100px; height: 100px;" alt="User Image">
				<?php } else { ?>
					<img src="<?=base_url()?>assets/images/laki.png" class="user-image rounded-circle" style="width: 100px; height: 100px;" alt="User Image">
				<?php } ?>

                <p>
                  <?= $this->session->userdata('uname'); ?>
                  <!-- <small>Member since April . 2016</small> -->
                </p>
              </li>
              <!-- Menu Footer-->
              <div class="user-footer">
                <div class="pull-left">
                  <a href="<?=base_url()?>ademik/Profil" class="btn btn-default btn-flat">Profil</a>
                </div>
                <div class="pull-right">
                  <a href="<?=base_url()?>prc/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </div>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <!-- <li class="dropdown notifications-menu">
            <a href="<?=base_url()?>#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell"></i>
              <span class="label label-warning">7</span>
            </a>
            <ul class="dropdown-menu scale-up">
              <li class="header">You have 7 notifications</li>
              <li> -->
                <!-- inner menu: contains the actual data -->
                <!-- <ul class="menu inner-content-div">
                  <li>
                    <a href="<?=base_url()?>#">
                      <i class="fa fa-users text-aqua"></i> Curabitur id eros quis nunc suscipit blandit.
                    </a>
                  </li>
                  <li>
                    <a href="<?=base_url()?>#">
                      <i class="fa fa-warning text-yellow"></i> Duis malesuada justo eu sapien elementum, in semper diam posuere.
                    </a>
                  </li>
                  <li>
                    <a href="<?=base_url()?>#">
                      <i class="fa fa-users text-red"></i> Donec at nisi sit amet tortor commodo porttitor pretium a erat.
                    </a>
                  </li>
                  <li>
                    <a href="<?=base_url()?>#">
                      <i class="fa fa-shopping-cart text-green"></i> In gravida mauris et nisi
                    </a>
                  </li>
                  <li>
                    <a href="<?=base_url()?>#">
                      <i class="fa fa-user text-red"></i> Praesent eu lacus in libero dictum fermentum.
                    </a>
                  </li>
                  <li>
                    <a href="<?=base_url()?>#">
                      <i class="fa fa-user text-red"></i> Nunc fringilla lorem
                    </a>
                  </li>
                  <li>
                    <a href="<?=base_url()?>#">
                      <i class="fa fa-user text-red"></i> Nullam euismod dolor ut quam interdum, at scelerisque ipsum imperdiet.
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="<?=base_url()?>#">View all</a></li>
            </ul>
          </li> -->
          <!-- Tasks: style can be found in dropdown.less -->
          <!-- <li class="dropdown tasks-menu">
            <a href="<?=base_url()?>#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag"></i>
              <span class="label label-danger">6</span>
            </a>
            <ul class="dropdown-menu scale-up">
              <li class="header">You have 6 tasks</li>
              <li> -->
                <!-- inner menu: contains the actual data -->
                <!-- <ul class="menu inner-content-div">
                  <li> --><!-- Task item -->
                    <!-- <a href="<?=base_url()?>#">
                      <h3>
                        Lorem ipsum dolor sit amet
                        <small class="pull-right">30%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 30%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">30% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li> -->
                  <!-- end task item -->
                  <!-- <li> --><!-- Task item -->
                   <!--  <a href="<?=base_url()?>#">
                      <h3>
                        Vestibulum nec ligula
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-danger" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li> -->
                  <!-- end task item -->
                  <!-- <li> --><!-- Task item -->
                    <!-- <a href="<?=base_url()?>#">
                      <h3>
                        Donec id leo ut ipsum
                        <small class="pull-right">70%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-light-blue" style="width: 70%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">70% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li> -->
                  <!-- end task item -->
                  <!-- <li> --><!-- Task item -->
                    <!-- <a href="<?=base_url()?>#">
                      <h3>
                        Praesent vitae tellus
                        <small class="pull-right">40%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-yellow" style="width: 40%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li> -->
                  <!-- end task item -->
                  <!-- <li> --><!-- Task item -->
                    <!-- <a href="<?=base_url()?>#">
                      <h3>
                        Nam varius sapien
                        <small class="pull-right">80%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width: 80%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">80% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li> -->
                  <!-- end task item -->
                  <!-- <li> --><!-- Task item -->
                    <!-- <a href="<?=base_url()?>#">
                      <h3>
                        Nunc fringilla
                        <small class="pull-right">90%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-primary" style="width: 90%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">90% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li> -->
                  <!-- end task item -->
                <!-- </ul>
              </li>
              <li class="footer">
                <a href="<?=base_url()?>#">View all tasks</a>
              </li>
            </ul>
          </li>    -->
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="<?=base_url()?>#" data-toggle="control-sidebar"><i class="fa fa-cog fa-spin"></i></a>
          </li>
        </ul>
      </div> -->
    <?php } ?>
	</nav>
  </header>

  <!-- Left side column. contains the logo and sidebar -->

  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="font-size: 80%;">

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">

    <!-- fandu matikan <li class="active treeview"> -->
	  <li class="active">
          <a href="<?=base_url()?>menu/dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
    </li>
		<?php $ulevel  = $this->session->userdata('ulevel'); $jumlahlogin  = $this->session->userdata('jumlahlogin'); if (!empty($ulevel) and (!empty($jumlahlogin) and $jumlahlogin != "editpassword")){
		/*echo $this->session->userdata('id')."<br>".$this->session->userdata('name')."<br>".$this->session->userdata('user')."<br>".$this->session->userdata('suser')."<br>".$this->session->userdata('kdfak')."<br>".$this->session->userdata('stat');*/
		$suser = $this->session->userdata('suser');
		$nim = $this->session->userdata('user');
		$int = $this->session->userdata('int');
		$first = 0;
		//$loncat = false;
		$title = "";
		$lama = "";
		$menuactive = "";
		$submenuactive = "";
		for ($a=0; $a<$int; $a++){
			// group modul select active
			/*if ($this->session->userdata('active_tamplate') == $this->session->userdata($a."G")){
				$menuactive = " style='color: blue;'";
			} else {
				$menuactive = "";
			}*/

			// group modul select active
			/* fandu matikan if ($this->session->userdata('activemodul_tamplate') == $this->session->userdata($a."M")){
				$submenuactive = " style='color: blue;'";
			} else {
				$submenuactive = "";
			}*/

			if ($this->session->userdata($a.'A') == 'Y'){
				$ajx = "href='#' onclick=tampilkan('"."T1KFaW4R0uPtM4l".md5($this->session->userdata($a."T"))."')";
			} else {
				//$ajx = "href='".base_url()."menu/mn/".$this->encryption->encrypt($this->session->userdata($a."T"))."'";
				$ajx = "href='".base_url()."menu/mn/"."T1KFaW4R0uPtM4l".md5($this->session->userdata($a."T"))."'";
			}

			if ($first == 0){ // pertama - 0 == 0 // 1 == 0 // 1 == 0 // 1 == 0
				//echo "fandu pratama - ".$this->session->userdata('ulevel')."<br>-".$this->session->userdata("tamplate")."<br> - ".$this->session->userdata("uname")."<br> - ".$this->session->userdata("ulevel")."<br> - ".$this->session->userdata("unip");
				echo "<li class='treeview'>
          <a href='#'>
            <i class='fa fa-laptop'></i>
            <span $menuactive>".$this->session->userdata($a."G")."</span>
            <span class='pull-right-container'>
              <i class='fa fa-angle-left pull-right'></i>
            </span>
          </a>
          <ul class='treeview-menu'>
            <li><a $submenuactive $ajx><i class='fa fa-circle-o'></i>".$this->session->userdata($a."M")."</a></li>";
				/*echo "<li class='nav-item dropdown'>
					<a class='nav-link dropdown-toggle' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='false'>
						<span class='ks-icon fa fa-dashboard'></span>
						<span class='ks-text'>".$tes->GroupModul."</span>
					</a>
					<div class='dropdown-menu'>";
				echo "<a class='dropdown-item' href='mail-empty.html'>".$tes->Modul."</a>";*/
				$first++; // 1
				$title = $this->session->userdata($a.'GI'); // 5
			} else { // 1
				//echo $tes->Modul;
				// ke - dua - jika masih sama 5 - 5 // 5 - 5
				if ($this->session->userdata($a."GI") == $title){
					echo "<li><a $submenuactive $ajx><i class='fa fa-circle-o'></i>".$this->session->userdata($a."M")."</a></li>";
				} else {
					echo "</ul>";
					//echo $tes->Modul;
					echo "<li class='treeview'>
          <a href='#'>
            <i class='fa fa-laptop'></i>
            <span $menuactive>".$this->session->userdata($a."G")."</span>
            <span class='pull-right-container'>
              <i class='fa fa-angle-left pull-right'></i>
            </span>
          </a>
          <ul class='treeview-menu'>";
				echo "<li><a $submenuactive $ajx><i class='fa fa-circle-o'></i>".$this->session->userdata($a."M")."</a></li>";
				$first++; // 2
				$title = $this->session->userdata($a.'GI');
				}
			}
		}
		echo "</ul></li>"; }
		?>
      </ul>
    </section>
  </aside>
 <div id="template">
