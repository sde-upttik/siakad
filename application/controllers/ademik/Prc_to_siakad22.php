<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prc_to_siakad22 extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('M_prcSiakad22');
	}

	public function getToken()
	{
		// persiapkan curl
	    $ch = curl_init(); 
		
		$username = "m@5i4k4d";
		$password = "Un74dF4n";
		
		$data = array(
	        "username" => "fadli",
	        "password" => "fadli123",
	        "aplikasi" => "daftarulang"
	    );
		
		$url = 'http://m.siakad.untad.ac.id/daftarulang/InsertSiakad/getToken';
		 
		//Initiate cURL.
		$ch = curl_init($url);
		
		if ($data){
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		
		curl_setopt($ch, CURLOPT_URL, $url);
		 
		//Specify the username and password using the CURLOPT_USERPWD option.
		curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);  
		 
		//Tell cURL to return the output as a string instead
		//of dumping it to the browser.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 
		//Execute the cURL request.
		$response = curl_exec($ch);
		 
		//Check for errors.
		if(curl_errno($ch)){
			//If an error occured, throw an Exception.
			throw new Exception(curl_error($ch));
		}
		 
		//Print out the response.
		echo $response;
		// echo $this->db->last_query();
	}

	public function MigrationStart()
	{
		header ('Refresh: 5; URL=https://siakad2.untad.ac.id/ademik/Prc_to_siakad22/MigrationStart');

		//get data mahasiswa
		$data_mhsw 	= $this->M_prcSiakad22->getDataMhsw();
		// print_r($data_mhsw);
		$bayar 		="";

		foreach ($data_mhsw as $mhsw ) {
			$bayar 		= $this->M_prcSiakad22->getDataBayar($mhsw['noujian']);
			if (empty($bayar)) {
				$bayar[0]['nilai_tagihan'] 		= "";
				$bayar[0]['noujian'] 			= "";
				$bayar[0]['waktu_transaksi']	= "";
			}

			$this->insertMhsw($mhsw, $bayar);

		}
	}


	public function serviceTransfer($nim)
	{
		//get data mahasiswa
		$data_mhsw 	= $this->M_prcSiakad22->getDataMhsWhere($nim);
		$bayar 		= "";

		foreach ($data_mhsw as $mhsw ) {
			$bayar 		= $this->M_prcSiakad22->getDataBayar($mhsw['noujian']);
			if (empty($bayar)) {
				$bayar[0]['nilai_tagihan'] 		= "";
				$bayar[0]['noujian'] 			= "";
				$bayar[0]['waktu_transaksi']	= "";
			}

			$this->insertMhsw($mhsw, $bayar);

		}
	}


	private function insertMhsw($mhsw, $bayar)
	{
  
		// // persiapkan curl
	    $ch = curl_init(); 

		// Token
		$token = "2b3797cc44fcce722cff5122681d887081178285b71adf7a90c696a8a2db6b1e577cda4cb154472a2acd79a74d090c0c28fa003b6f9c30e189d57bba29b7d302FibdK8cjoQHgDkBIYqRHYN3yy0ryrY6ESjCO+lmXoTlE53IRPJNHWhtdVxhss1Nt";

		$username = "m@5i4k4d";
		$password = "Un74dF4n";
		
					$data = array(
							'idpd' 				=>"delay", 
							'idregpd' 			=>"delay", 
							'hoby' 				=>"delay", 
							'stambuk' 			=>$mhsw['st_nim'], 
							'jalurlulus' 		=>$mhsw['Jalur'], 
							'kodefakultas' 		=>$this->getStatusKampus2($mhsw['ket'], $mhsw['jurusan']), 
							'kodejurusan' 		=>$mhsw['jurusan'],
							'kodeprogram' 		=>$this->getStatusProgram($mhsw['ket']), 
							'namamhsw' 			=>$mhsw['nama'], 
							'emailmhsw' 		=>$mhsw['EMail'], 
							'jeniskelamin' 		=>$mhsw['JK'], 
							'tempatlahir' 		=>$mhsw['TmptLhr'], 
							'tanggallahir' 		=>$mhsw['TglLhr'], 
							'alamatmhsw' 		=>$mhsw['Alamat1'], 
							'telpmhsw' 			=>$mhsw['Telp'], 
							'nikmhsw' 			=>$mhsw['nik'], 
							'agama' 			=>$mhsw['Agama'], 
							'namaayah' 			=>$mhsw['NmAyah'], 
							'namaibu' 			=>$mhsw['NmIbu'], 
							'noujian' 			=>$mhsw['noujian'], 
							'bayar' 			=>$bayar[0]['nilai_tagihan'],
							'idrecordtagihan' 	=>$bayar[0]['noujian'],
							'tanggalbayar' 		=>$bayar[0]['waktu_transaksi'],
							'token'				=> $token
		    );	


		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";

		$url = 'http://m.siakad.untad.ac.id/daftarulang/InsertSiakad/insert';
		 
		//Initiate cURL.
		$ch = curl_init($url);
		
		if ($data){
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		
		curl_setopt($ch, CURLOPT_URL, $url);
		 
		//Specify the username and password using the CURLOPT_USERPWD option.
		curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);  
		 
		//Tell cURL to return the output as a string instead
		//of dumping it to the browser.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 
		//Execute the cURL request.
		$response = curl_exec($ch);
		 
		//Check for errors.
		if(curl_errno($ch)){
			//If an error occured, throw an Exception.
			throw new Exception(curl_error($ch));
		}
		 
		//Print out the response.
		$data = json_decode($response, true);

		// print_r($data);
		if ($data['data']['status'] != 'failed') {
			echo $this->M_prcSiakad22->updateStSiakadInDaftarUlang($data);
		}else{
			echo $this->M_prcSiakad22->updateStSiakadInDaftarUlang($data);
			echo "Proses Update tidak dijalankan ! - status <b>{$data['data']['message']} - {$data['data']['stambuk']} </b><br>";
		}

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
			$kodefakultas1 = $this->M_prcSiakad22->getKodeFakultas($kode);
			$kodefakultas  = $kodefakultas1[0]['KodeFakultas'];
		}

		return $kodefakultas;
	}

}