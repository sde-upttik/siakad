<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_bobot_krs extends CI_Controller {


	function __construct() {
	    parent::__construct();
		$this->load->model('Krs_model');
	}

	public function index()
	{
		$cari="N10118";
		$nilaiGradeChange='C';
		$bobot = '2.5';
		//echo "string";
		
		for ($i=2015; $i < 2019; $i++) {  
				$dataLama1 = $this->Krs_model->updateDataKrs($cari,$nilaiGradeChange,$bobot,$i.'1');
				print_r($dataLama1);
				echo $i.'1'."<br><br>";
			
				$dataLama2 = $this->Krs_model->updateDataKrs($cari,$nilaiGradeChange,$bobot,$i.'2');
				print_r($dataLama2);
				echo $i.'2'."<br><br>";
			
				$dataLama3 = $this->Krs_model->updateDataKrs($cari,$nilaiGradeChange,$bobot,$i.'3');
				print_r($dataLama3);
				echo $i.'3'."<br><br>";
			
				$dataLama4 = $this->Krs_model->updateDataKrs($cari,$nilaiGradeChange,$bobot,$i.'4');
				print_r($dataLama4);
				echo $i.'4'."<br><br>";

		}
		
	}
}
