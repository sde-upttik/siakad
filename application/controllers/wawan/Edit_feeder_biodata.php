<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_feeder_biodata extends CI_Controller {


	function __construct() {
	    parent::__construct();
		$this->load->library('encryption');
		$this->load->model('Prc');
	}

	public function tes()
	{

		/*$dataEncrypt = $this->encryption->encrypt("E28112177|DUM014|20182|B");
		
		echo $dataEncrypt;*/
		
		$dataDecrypt = $this->encryption->decrypt('429243e0bdf23fba84af48abc4cf4428fdf6f129be44c5d42f273f987a1d78105d9ad9643891b92e71f0666b63c38d31cab1e7c6b87957e197752f0fd6140c58JxJhT8lVLMn533AMVFvGz98E0JHSeohMnMpBFqlSphTVfQ9BRq39f+D+Xm4ZXCuv');
		echo $dataDecrypt;
	}

	public function index()
	{
		echo "
			<!DOCTYPE html>
			<html>
			<head>
				<title>Ubah Biodata</title>
			</head>
			<body>
				<form method='POST' action='".base_url('wawan/edit_feeder_biodata/ubah')."'>
					<label>Id PD</label>
					<input type='text' name='id_pd'><br>
					<label>Nama</label>
					<input type='text' name='nama'>
					<input type='submit' name='kirim'>
				</form>
			</body>
			</html>
		";
	}

	private function runWS($data){

		$url = 'http://103.245.72.97:8082/ws/live2.php';
		$ch = curl_init();
			
		curl_setopt($ch, CURLOPT_POST, 1);
		
		$headers = array();
		
		$headers[] = 'Content-Type: application/json';
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$data = json_encode($data);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}

	public function ubah()
	{
		$username = '001028e1';
		$password = 'az18^^';

		$dataToken = array (
			'act' => 'GetToken',
			'username' => $username,
			'password' => $password
		);

		$tokenFeeder = $this->runWS($dataToken);
		$obj = json_decode($tokenFeeder);
		$token = $obj->{'data'}->{'token'};

		echo $token;
		echo "<br><br>";
		
		$id_pd = $_POST['id_pd'];
		$nama = $_POST['nama'];

		//print_r($show);
		$dataMhsw = array();
		$dataMhsw['id_mahasiswa'] = $id_pd;

		$edit = array();
		$edit['nama_mahasiswa'] = $nama;	

		$dataBiodataTransfer = array(
			'act' => 'UpdateBiodataMahasiswa',
			'token' => $token,
			'key' => $dataMhsw,
			'record' => $edit
	 	);

	 	$dataBiodataFeeder = $this->runWS($dataBiodataTransfer);
	 	$obj = json_decode($dataBiodataFeeder);
	 	$error_code = $obj->{'error_code'};
	 	$error_desc = $obj->{'error_desc'};
	 	$id_BiodataDikti = $obj->{'data'};

 		echo $error_code." ".$error_desc;
 		echo $id_BiodataDikti;
	}

}
