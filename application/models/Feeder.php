<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feeder extends CI_Model{

	public function getToken_feeder(){
		$url = $this->config->item('url_feeder'); // gunakan live bila sudah yakin

		$client = new nusoap_client($url, true);

		// Mendapatkan Token

		$username = $this->config->item('user_feeder');
		$password = $this->config->item('password_feeder');

		$temp_proxy = $client->getProxy();
        $temp_error = $client->getError();
        if ($temp_proxy == NULL) {
			echo "Error GetProxy $temp_error<br>";
        } else {
            $temp_token = $temp_proxy->GetToken($username, $password);
			if ($temp_token == 'ERROR: username/password salah') {
				echo "Error User/Password Salah $temp_token<br>";
			} else {
				$array = array(
					"temp_proxy" => $temp_proxy,
					"temp_token" => $temp_token
				);
				return $array;
			}
		}
	}

	public function action_feeder($temp_token,$temp_proxy,$action,$table,$record){
		$resultb = $temp_proxy->$action($temp_token, $table, json_encode($record));
		return $resultb['result'];
	}

	public function action_feeder_getRecord($temp_token,$temp_proxy,$action,$table,$record){
		$resultb = $temp_proxy->$action($temp_token, $table, $record);
		return $resultb['result'];
	}

	public function getData($tbl,$par,$val,$select) {

		$query = $this->db->query("SELECT $select FROM $tbl WHERE $par = '$val'");

	    return $query->row();

	}

	//restfull
	public function gettoken_restfull(){
		$user_feeder = $this->config->item('user_feeder');
		$password_feeder = $this->config->item('password_feeder');
		$url = 'http://103.245.72.97:8082/ws/live2.php';

		$data = array (
			'act' => 'GetToken',
			'username' => $user_feeder,
			'password' => $password_feeder
		);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_POST, 1);

		$headers = array();

		$headers[] = 'Content-Type: application/json';

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		if ($data){
			$data = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		$obj = json_decode($result);
		return $obj->{'data'}->{'token'}; // mendapatkan tokennya
	}

	//mendapatkan detail biodata dosen dengan id_dosen
	public function id_reg_dosen_detailbiodatadosen($Filter){

		$token = $this->gettoken_restfull();
		$url = 'http://103.245.72.97:8082/ws/live2.php';

		/*$data = array (
			'act' => 'GetListMahasiswa',
			'token' => $token,
			'filter' => $Filter
		);*/

		$data = array (
			'act' => 'DetailBiodataDosen',
			'token' => $token,
			'filter' => $Filter
		);

		//$data = json_encode($data);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_POST, 1);

		$headers = array();

		$headers[] = 'Content-Type: application/json';

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		if ($data){
			$data = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		echo "$result<br>";

	}

	//insert semua restfull ke feeder
	public function insertfeeder($namerest,$value){

		$token = $this->gettoken_restfull();
		$url = 'http://103.245.72.97:8082/ws/live2.php';

		/*$edit = array();
		$edit['id_registrasi_dosen'] = 'bbe897c1-3997-4008-8c98-90ba40110a38';
		//$edit['id_dosen'] = '87221cd4-9045-458b-897b-107fbf0cd921';
		$edit['id_kelas_kuliah'] = 'ea43f5af-b0d8-4228-a473-7b93df63c87f';
		$edit['sks_substansi_total'] = '2';
		$edit['rencana_tatap_muka'] = '15';
		$edit['realisasi_tatap_muka'] = '13';
		$edit['id_jenis_evaluasi'] = '1';
		//26c776cf-92fe-4a42-b826-f750410d0804
		$data = array (
			'act' => 'InsertDosenPengajarKelasKuliah',
			'token' => $token,
			'record' => $edit
		);*/


		$data = array (
			'act' => $namerest,
			'token' => $token,
			'record' => $value
		);

		//$data = json_encode($data);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_POST, 1);

		$headers = array();

		$headers[] = 'Content-Type: application/json';

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		if ($data){
			$data = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;

	}

	//cek semua data restfull ke feeder
	public function cekdatafeeder($act, $Filter){

		$token = $this->gettoken_restfull();
		$url = 'http://103.245.72.97:8082/ws/live2.php';

		$data = array (
			'act' => $act,
			'token' => $token,
			'filter' => $Filter,
			'order' => '',
			'limit' => '',
			'offset' => ''
		);

		//$data = json_encode($data);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_POST, 1);

		$headers = array();

		$headers[] = 'Content-Type: application/json';

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		if ($data){
			$data = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;

	}

	//insert semua restfull ke feeder
	public function deletefeeder($namerest,$value){

		$token = $this->gettoken_restfull();
		$url = 'http://103.245.72.97:8082/ws/live2.php';

		$data = array (
			'act' => $namerest,
			'token' => $token,
			'key' =>  $value
		);
		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_POST, 1);

		$headers = array();

		$headers[] = 'Content-Type: application/json';

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		if ($data){
			$data = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;

	}

}
