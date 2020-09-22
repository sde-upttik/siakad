<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prc_notkrs extends CI_Controller {


	function __construct() {
	    parent::__construct();
		$this->load->library('encryption');
		$this->load->model('Krs_model');
	}

	public function index()
	{
		$dataLama = $this->Krs_model->krsNotFak('20101');
		//$dataBaru = $this->tabel_spp_sync->spp_baru();
		//print_r($dataLama);
		$i=1;
		foreach ($dataLama as $show) {
			echo $i." ";
			print_r($show);
			echo "<br><br>";
			
			echo $show->NIM." - ".$show->IDJadwal;
			
		    $i++;

		    //print_r($data)."<br>";
			
			$delete=$this->Krs_model->deleteData($show->ID,'20101');
	        //$cek_simpan=$this->Krs_model->addData($data,$show->Tahun);
	        if($delete){
	        	echo "SUCCESS";
	        	echo "<br><br>";
	        }else{
	        	echo "ERROR";
	        	echo "<br><br>";
	        }

	        /*$data1 = array(
		        'pindah_siakad' => '1'
		    );

	        $cek_edit =$this->Krs_model->updateData($show->ID, $data1,'krsN');*/
		}
		echo $i;


		/*foreach ($dataBaru as $show) {
			print_r($show);
		}*/
	}
}
