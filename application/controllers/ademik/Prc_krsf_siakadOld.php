<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

class Prc_krsf_siakadOld extends CI_Controller {
	private $siakadOld;

	public function __construct(){
		parent::__construct();

		$this->siakadOld = $this->load->database('siakad', TRUE);
		$this->load->model('Krsf_model');
	}

	public function index()
	{
		$this->load->view('ademik/v_prcKrsf');
	}

	public function prcRun()
	{
		$tahun				= $this->input->post('tahun',true);
		$data_mhs 			= $this->Krsf_model->getDataNimMahasiswa(substr($tahun,0,4));

		echo "<h1 align='center'>Angkatan {$tahun}</h1>";
		foreach ($data_mhs as $mhsw ) {
			$where['NIM'] 		= $mhsw['NIM'];
			$where['Tahun'] 	= $tahun;
			$this->processKrs($where, $tahun);
		}
		echo "<h1>Proses Selesai <a href=".base_url('ademik/Prc_krsf_siakadOld').">Back to Menu<a></h1>";
	}

	// Compare fileds betwin filed krsf and krs snew siakad2 
	public function compareFieldKrs()
	{
		$list_field_krs_siakad1		= $this->Krsf_model->getListFieldkrs(1);
		$list_field_krs_siakad2		= $this->Krsf_model->getListFieldkrs(2);

		$fileds_compare = array();
		for ($i=1; $i <= 87 ; $i++) { 
			if (in_array($list_field_krs_siakad2[$i], $list_field_krs_siakad1, true)) {
				array_push($fileds_compare,  $list_field_krs_siakad2[$i]);
			}
		}

		return $fileds_compare;
	}

	public function processKrs($where, $tahun)
	{
		$data_krs_siakad1 	= $this->Krsf_model->getDataKrsSiakad1($where, $tahun);

		echo "<h4> {$where['NIM']} = </h4>";
		$no=0;
		foreach ($data_krs_siakad1 as $krs_siakad1) {
			$where['KodeMk'] 		= $krs_siakad1['KodeMk'];
			$where['Tahun']			= $tahun;
			$check_krs_siakad1 		=  $this->Krsf_model->checkAvailabelkrs($where, $tahun);
			
			if ($check_krs_siakad1 < 1 ) {
				$this->insertKrstoSiakad2($where['NIM'], $tahun, $where['KodeMk'] );
			}
			else{
				echo "<pre>";
				echo "{$where['KodeMk'] } <b>Krs Available</b> -";
				$this->updateStatusMigration($where['NIM'], $tahun, $where['KodeMk'] );
				echo "<pre>";
			}
			$no++;
		}
		echo $no;
		$updateMhswF = $this->Krsf_model->updateMhswF(array('NIM' => $where['NIM']));
		if ($updateMhswF == 1) {
			echo "<br> Update MhswF siakad 2 success ! <br>";
		}
		echo "<hr>";
		echo "<br>";
	}

	public function insertKrstoSiakad2($nim, $tahun, $KodeMk)
	{	
		$fields 			= $this->compareFieldKrs();

		$where['NIM']		= $nim;
		$where['Tahun']		= $tahun;
		$where['KodeMk']	= $KodeMk;
		
		$data 				= $this->Krsf_model->getDatakrsf($fields, $where);

		if (empty($data)) {
			echo "Kosong<br>";
		}else{
			$insertKrs = $this->Krsf_model->insertDataKrsToSiakad2(array('NIM' => $nim), $data[0], $tahun);
					
			if ($insertKrs == 1) {
				echo "<br>Insert Data KRS NIM {$nim} dengan id Jadwal = {$KodeMk} <b>success !</b>";
				$this->updateStatusMigration($nim, $tahun, $KodeMk);
			}
			else{
				echo "<br>Gagal Insert Krs NIM = {$nim} dengan id Jadwal = {$KodeMk} <br>";
			}
		}

	}

	public function updateStatusMigration($nim, $tahun, $KodeMk)
	{
		$where['NIM']		= $nim;
		$where['Tahun']		= $tahun;
		$where['KodeMk']	= $KodeMk;

		$updateKrsf = $this->Krsf_model->updateKrsf($where);
		if ($updateKrsf == 1) {
			echo "<br>Update krsF success ! <br>";
			$updateMhswF = $this->Krsf_model->updateMhswF(array('NIM' => $nim));
			if ($updateMhswF == 1) {
				echo "Update MhswF siakad 2 success ! <br><br>";
			}
		}
		else{
			$updateMhswF = $this->Krsf_model->updateMhswF(array('NIM' => $nim));
			if ($updateMhswF == 1) {
				echo "Update MhswF siakad 2 success ! <br><br>";
			}
		}
	}

	public function reset_mhswf()
	{
		$this->Krsf_model->updateMhswFReset();
	}
}
