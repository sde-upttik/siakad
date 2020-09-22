<?php $this->load->view('temp/head'); ?> 
  <!-- Content Wrapper. Contains page content -->
  <div id="template">
  <?php $tamp = $this->session->userdata('sess_tamplate');
    // echo $temp;
    // echo "fandu1111 ".$tamp;	
    if (!empty($tamp) ) $tamplate = $tamp;
    else if ($tamp == "ademik/") $tamplate = 'temp/index'; 
    else $tamplate = 'temp/index'; //untuk halaman awal setelah proses login selesai
  	$uri3 = md5(str_replace('/','-',$this->session->userdata('tamplate')));
  	//echo "fandu -- $uri3 -- $tamplate";
  	$val = $this->app->check($uri3);
  	if ($val or $uri3=='d41d8cd98f00b204e9800998ecf8427e') $this->load->view($tamplate);
    ?>
  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view('temp/footers'); ?>
