<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_ttd extends CI_Controller {

	function __construct(){
		parent::__construct();
        
        // Set variable
		$unip	= $this->session->userdata("unip");
		
	    // Get Model 
        $this->load->model('MasterTtd_model');
        
        // set lib
	    $this->load->library('form_validation');
        
        // Mengatur Time Zone ke area Asian atau Bangkok
	    date_default_timezone_set("Asia/Bangkok");

	    // Mengatur sesession jika belum login
	    if ($unip == null) {
	    	redirect(base_url('home'));
		}
    }

    public function index()
    {
		$ulevel = $this->session->userdata("ulevel");

		// Filter hak Akses
		if($ulevel != 1 ){
			$this->page();
		}
		elseif($ulevel != 5){
			$this->page();
		}
		else{
			redirect(base_url('home'));
		}
	}
	
	public function page()
	{
		$data['dataTtd'] = $this->MasterTtd_model->getDataJurusuan();

        $this->load->view('temp/head');
        $this->load->view('ademik/masterTtd/tableTtd', $data);
		$this->load->view('temp/footers');
        $this->load->view('ademik/masterTtd/tableTtd_js');
	}

	public function formEditTtd()
	{
		$cleanData 		 = htmlspecialchars($this->input->post('Kode',true));
		$data['dataTtd'] = $this->MasterTtd_model->getDataJurusuan($cleanData);

		$view = $this->load->view('ademik/masterTtd/formEditTtd', $data, true);
		
		echo $view;
	}

	public function updateTtd()
	{
		$cleanData 	 = $this->input->post(null,true);
		$response	 = $this->MasterTtd_model->updateTtd($cleanData);

		echo $response;
	}

}