<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RangkumanIpk extends CI_Controller {
	
	public function index(){

		$this->load->view('temp/head');
		//echo "string rangkuman RangkumanIpk";
		$this->load->view('ademik/rangkuman_ipk');
		$this->load->view('temp/footers');
	}
}	