<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prc_spp2 extends CI_Controller {


	function __construct() {
	    parent::__construct();
		$this->load->library('encryption');
		$this->load->model('Sync_spp');
	}

	public function index()
	{
		$dataLama = $this->Sync_spp->sppLama();
		//$dataBaru = $this->tabel_spp_sync->spp_baru();
		//print_r($dataLama);
		foreach ($dataLama as $show) {
			print_r($show);
			echo "<br>";
			$data = array(
		        'tahun' => $show->tahun,
		        'nim' => $show->nim,
		        'Sex' => $show->Sex,
		        'bayar' => $show->bayar,
		        'StatusMhs' => $show->StatusMhs,
		        'StatusMhsKul' => $show->StatusMhsKul,
		        'KodeFakultas' => $show->KodeFakultas,
		        'KodeJurusan' => $show->KodeJurusan,
		        'STBBYR' => $show->STBBYR,
		        'TotalBayar' => $show->TotalBayar,
		        'id_record_tagihan' => $show->id_record_tagihan,
		        'reg' => $show->reg,
		        'tgl' => $show->tgl
		    );
			
	        $cek_simpan=$this->Sync_spp->addData($data,'_v2_spp2');
	        if($cek_simpan){
	        	echo "SUCCESS";
	        	echo "<br><br>";
	        }else{
	        	echo "SUCCESS";
	        	echo "<br><br>";
	        }

	        $data1 = array(
		        'pindah_siakad_baru' => '1'
		    );

	        $cek_edit =$this->Sync_spp->updateData($show->id, $data1,'spp2');
		}

		/*foreach ($dataBaru as $show) {
			print_r($show);
		}*/
	}
}
