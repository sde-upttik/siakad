<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KrsSetting extends CI_Controller {

//Memanggil model dan library tambahan
	function __construct(){
		parent::__construct();
	    
	    // Mengambil Absensi Model
		// $this->load->model('');
		
		// Mengambil App Model 
	    $this->load->model('app');
		
		//Mengambil Library tambahan
		$this->load->library('form_validation');
		
	    // Mengatur Time Zone ke area Asian atau Bangkok
	    date_default_timezone_set("Asia/Bangkok");

	    // Mengatur sesession jika belum login
		$unip 	= $this->session->userdata("unip");
		$uname	= $this->session->userdata('uname');
		$ulevel	= $this->session->userdata('ulevel');
		if (empty($uname) and empty($ulevel) and empty($unip) ){
	    	redirect("https://siakad2.untad.ac.id");			
		}
	}

}