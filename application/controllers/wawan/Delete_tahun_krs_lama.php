<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_tahun_krs_lama extends CI_Controller {


	function __construct() {
	    parent::__construct();
		$this->load->library('encryption');
		$this->load->model('Prc');
	}

	public function tes()
	{
		$tahun = $this->input->post('tahun');
		$data = $this->Prc->checkTahunKrs($tahun);

		foreach ($data as $show) {
			print_r($show);
			$cek_hapus =$this->Prc->deleteData($show->ID,$tahun);
		    if($cek_hapus){
	            echo $status_hapus="Sukses";
	        }else{
	        	echo $status_hapus="Gagal";
	        }
			echo "<br>";

		}
	}

	public function index()
	{
		echo "<!DOCTYPE html>
			<html>
			<head>
			    <title></title>
			</head>
			<body>
			    <form method='POST' action='".base_url('wawan/Delete_tahun_krs_lama/tes')."'>
			        <input type='text' name='tahun'>
			        <input type='submit' name='prc'>
			    </form>
			</body>
			</html>";
	}
}
