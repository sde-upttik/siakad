<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cek_kembar_idjadwal extends CI_Controller {


	function __construct() {
	    parent::__construct();
		$this->load->library('encryption');
		$this->load->model('Prc');
	}

	public function tes()
	{
		$tahun = $this->input->post('tahun');
		$na = $this->input->post('na');
		$data = $this->Prc->checkKembarKrs($tahun);

		foreach ($data as $show) {
			/*print_r($show);
			echo "<br>";*/
			$dataNilai = $this->Prc->checkKembarNilaiKrs($show->IDJadwal,$show->NIM,$show->NamaMK,$tahun,$na);
			foreach ($dataNilai as $show1) {
				print_r($show1);
				echo "<br>";
				$cek_hapus =$this->Prc->deleteData($show1->ID,$tahun);
			    if($cek_hapus){
		            echo $status_hapus="Sukses";
		        }else{
		        	echo $status_hapus="Gagal";
		        }
			}
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
			    <form method='POST' action='".base_url('wawan/Cek_kembar_idjadwal/tes')."'>
			        <input type='text' name='tahun'>
			        <select name='na'>
			            <option value='Y'>Y</option>
			            <option value='N'>N</option>
			        </select>
			        <input type='submit' name='prc'>
			    </form>
			</body>
			</html>";
	}
}
