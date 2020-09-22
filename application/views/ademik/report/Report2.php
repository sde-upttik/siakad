<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report2 extends CI_Controller {
	// Report 2 ini merupakan Teknik ke 2 untuk membuat pdf

	function __construct() {
	    parent::__construct();
	    $this->load->helper('security');
		date_default_timezone_set('Asia/Makassar');
		$this->load->library('encryption');
	}

	public function index(){
		$this->load->view('report');
	}

	// Fandu Report
	public function cetak_kujian(){

		$nim = $this->uri->segment(5);
		$a['identitas'] = $nim;
	  	$this->load->library('pdf');

	  	$html=$this->load->view('report', "", TRUE);
	  	$filename = "Report";
        $this->pdf->create($html, $filename, 'lendscape');

	}
}