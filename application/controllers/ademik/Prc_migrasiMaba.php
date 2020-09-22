<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prc_migrasiMaba extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('M_prcSiakad2');
	}

	public function MigrationStart()
	{
		
		$data_mhsw = $this->M_prcSiakad2->getDaftarulang();
		echo 'Jumlah '.$data_mhsw->num_rows().' <br>';
		
		if ($this->db->insert_batch('_v2_tempMaba',$data_mhsw->result())) {
			$i=0;
			foreach ($data_mhsw->result() as $maba) {
				$noujian[$i] = $maba->PMBID;
				$i++;
			}
			$up = $this->M_prcSiakad2->updateStatusMigrasi($noujian);
			
			echo 'insert '.$this->db->affected_rows().' '.$up;
		}

	}

	private function insertMhsw($mhsw)
	{

	}

	private function getStatusProgram($ket)
	{
		$program = "";

		if ($ket == 0) {
			$program = "REG";
		}
		elseif($ket == 1){
			$program = "NONREG";
		}
		elseif($ket == 2){
			$program = "Kampus Touna";
		}
		elseif($ket == 3){
			$program = "kampus Morowali";
		}
		else{
			$program = "-";
		}

		return $program;
	}

	public function getStatusKampus2($ket, $kode)
	{
		$kodefakultas = "";
		
		if($ket == 2){
			$kodefakultas = "K2T";
		}
		elseif($ket == 3){
			$kodefakultas = "K2T";
		}else{
			$kodefakultas = $kode;
		}

		return $kodefakultas;
	}

}