<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function index(){
		$this->load->view('dashbord');
	}
	
	public function tes(){
		echo "fandu1111111 ".$this->input->post('test') ;
	}
	
}