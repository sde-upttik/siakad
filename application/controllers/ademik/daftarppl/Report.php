<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	function __construct(){
		parent::__construct();
	    $this->load->model('Ppl_model');
	}

	public function index(){
		$a['tab'] = $this->app->all_val('groupmodul')->result();
		$this->load->view('dashbord',$a);
	}

}