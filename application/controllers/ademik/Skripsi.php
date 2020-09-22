<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Skripsi extends CI_Controller {

//Memanggil model dan library tambahan
	function __construct(){
		parent::__construct();
	    
	    // Mengambil Skripsi Model
		$this->load->model('Skripsi_model');
		
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

	public function viewPage($page='ademik/skripsi/form_skripsi', $data_bind="")
	{
		$this->load->view('temp/head');
		$this->load->view($page, $data_bind);
		$this->load->view('temp/footers');
		$this->load->view("{$page}_js");
	}

	public function index()
	{
		$this->viewPage();
	}

	public function seminarSkripsi()
	{
		$this->viewPage('ademik/skripsi/form_seminar_skripsi');		
	}

}