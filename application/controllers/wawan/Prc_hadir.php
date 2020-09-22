<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prc_hadir extends CI_Controller {


	function __construct() {
	    parent::__construct();
		$this->load->model('Krs_model');
	}

	public function index()
	{
		$thn='20182';
		$tabel='_v2_krs'.$thn;
		$data_krs= $this->Krs_model->showDataKrs($tabel);

		foreach ($data_krs as $show) {
			echo $show->NIM." ".$show->IDJadwal;
			$kehadiran=0;
			if($show->hr_1=='H'){
				$kehadiran++;
			}
			if($show->hr_2=='H'){
				$kehadiran++;
			}
			if($show->hr_3=='H'){
				$kehadiran++;
			}
			if($show->hr_4=='H'){
				$kehadiran++;
			}
			if($show->hr_5=='H'){
				$kehadiran++;
			}
			if($show->hr_6=='H'){
				$kehadiran++;
			}
			if($show->hr_7=='H'){
				$kehadiran++;
			}
			if($show->hr_8=='H'){
				$kehadiran++;
			}
			if($show->hr_9=='H'){
				$kehadiran++;
			}
			if($show->hr_10=='H'){
				$kehadiran++;
			}
			if($show->hr_11=='H'){
				$kehadiran++;
			}
			if($show->hr_12=='H'){
				$kehadiran++;
			}
			if($show->hr_13=='H'){
				$kehadiran++;
			}
			if($show->hr_14=='H'){
				$kehadiran++;
			}
			if($show->hr_15=='H'){
				$kehadiran++;
			}
			if($show->hr_16=='H'){
				$kehadiran++;
			}

			$persentase=($kehadiran/16)*100;
			$update = $this->Krs_model->updateHadir($show->NIM, $show->IDJadwal, $persentase, $tabel);
			if($update){
				echo "Berhasil";
			}else{
				echo "Gagal";
			}
			echo $persentase."<br>";
		}

	}
}
