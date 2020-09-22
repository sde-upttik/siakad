<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coba extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->library('datatables');
	    $this->load->model('user_model');
		date_default_timezone_set("Asia/Makassar");
	}

	public function index(){
		//echo "fandu 12344 fandu ini<br>";
		//echo $this->uri->segment(4);
	// cara pertama
		//	$content = $this->session->userdata('sess_tamplate');
		//	$this->load->view('temp/head');
		//	$this->load->view($content);
		//	$this->load->view('temp/footers');
	
	// cara kedua
		$a['tab'] = $this->app->all_val('groupmodul')->result();
		$this->load->view('dashbord',$a);
		
	// cara ke tiga
		//$this->load->view('dashbord');
	}
	
}