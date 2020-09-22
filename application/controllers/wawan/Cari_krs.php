<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cari_krs extends CI_Controller {


	function __construct() {
	    parent::__construct();
		$this->load->model('Krs_model');
	}

	public function index()
	{
		$nim="N20115038";
		//echo "string";
		for ($i=2010; $i < 2019; $i++) { 
			$cekKrs1 = $this->Krs_model->cekCariKrsNIM($nim,$i.'1');
			$cekKrs2 = $this->Krs_model->cekCariKrsNIM($nim,$i.'2');
			$cekKrs3 = $this->Krs_model->cekCariKrsNIM($nim,$i.'3');
			$cekKrs4 = $this->Krs_model->cekCariKrsNIM($nim,$i.'4');

			if($cekKrs1>=1){
				$dataLama = $this->Krs_model->cariKrsNIM($nim,$i.'1');
				print_r($dataLama);
				echo $i.'1'."<br><br>";
			}
			if($cekKrs2>=1){
				$dataLama = $this->Krs_model->cariKrsNIM($nim,$i.'2');
				print_r($dataLama);
				echo $i.'2'."<br><br>";
			}
			if($cekKrs3>=1){
				$dataLama = $this->Krs_model->cariKrsNIM($nim,$i.'3');
				print_r($dataLama);
				echo $i.'3'."<br><br>";
			}
			if($cekKrs4>=1){
				$dataLama = $this->Krs_model->cariKrsNIM($nim,$i.'4');
				print_r($dataLama);
				echo $i.'4'."<br><br>";
			}
		}
		
	}
}
