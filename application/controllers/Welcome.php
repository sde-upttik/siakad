<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function cetak_khs(){
		$this->load->library('pdf');

	  	$html=$this->load->view('cetak_khs', '',TRUE);

	  	$filename = "KHS";
        $this->pdf->create($html, $filename, 'potrait');
		// $this->load->view('cetak_khs');
	}

	public function cetak_krs(){
		$this->load->library('pdf');

	  	$html=$this->load->view('cetak_krs', '',TRUE);

	  	$filename = "KRS";
        $this->pdf->create($html, $filename, 'potrait');
		// $this->load->view('cetak_krs');
	}

	public function cetak_kujian(){
		$this->load->library('pdf');

	  	$html=$this->load->view('cetak_kujian', '',TRUE);

	  	$filename = "Kartu_Ujian";
        $this->pdf->create($html, $filename, 'potrait');
		// $this->load->view('cetak_kujian');
	}

	public function cetak_daftar_hadir(){
		$this->load->library('pdf');

	  	$html=$this->load->view('cetak_daftar_hadir', '',TRUE);

	  	$filename = "Daftar_Hadir";

        $this->pdf->create($html, $filename, 'landscape');
		// $this->load->view('cetak_daftar_hadir');
	}

	public function cetak_matkul_per_jenis(){
		$this->load->library('pdf');

	  	$html=$this->load->view('cetak_matkul_per_jenis', '',TRUE);

	  	$filename = "Matkul_Perjenis";
	  	
        $this->pdf->create($html, $filename, 'potrait');

		// $this->load->view('cetak_matkul_per_jenis');
	}

	public function cetak_matkul_per_semester(){
		$this->load->library('pdf');

	  	$html=$this->load->view('cetak_matkul_per_semester', '',TRUE);

	  	$filename = "Matkul_PerSemester";
	  	
        $this->pdf->create($html, $filename, 'potrait');

		// $this->load->view('cetak_matkul_per_semester');
	}

	public function cetak_transkrip(){
		$this->load->library('pdf');

	  	$html=$this->load->view('cetak_transkrip', '',TRUE);

	  	$filename = "Transkrip";
	  	
        $this->pdf->create($html, $filename, 'potrait', 'legal');

		// $this->load->view('cetak_transkrip');
	}

	public function cetak_jadwal(){
		$this->load->library('pdf');

	  	$html=$this->load->view('cetak_jadwal', '',TRUE);

	  	$filename = "Jadwal";
	  	
        $this->pdf->create($html, $filename, 'potrait');

		// $this->load->view('cetak_jadwal');
	}

	public function cetak_dpna(){
		$this->load->library('pdf');

	  	$html=$this->load->view('cetak_dpna', '',TRUE);

	  	$filename = "DPNA";
	  	
        $this->pdf->create($html, $filename, 'potrait');

		$this->load->view('cetak_dpna');
	}
}
