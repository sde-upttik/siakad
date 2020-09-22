<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

class Cek_idReg extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->helper('security');
	    $this->load->model('additional_model');
	    $this->load->helper('file');
	}

	public function index() {

		$level = $this->session->userdata('ulevel');
		$dataKode = $this->userKode();

		$data['mhsw'] = $this->additional_model->getListMhswLulus($level,$dataKode);
		$data['footerSection'] = "<script type='text/javascript'>
 				$('#berita').dataTable( {
    				'order': [2,'desc']
				} );	
		    </script>";

		$this->load->view('dashbord',$data);

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

	private function userKode() {

		if ( $this->session->userdata('ulevel') == 5 ) {
			return $dataKode = $this->session->userdata("kdf");
		} elseif ( $this->session->userdata('ulevel') == 7 ) {
			return $dataKode = $this->session->userdata("kdj");
		} else {
			return $dataKode = 0;
		}

	}

	private function getUser($lvl){
		switch($lvl){
			case 1:
				$user='_v2_adm'; //Administrator
				break;
			case 2:
				$user='_v2_pegawai';
				break;
			case 3:
				$user='_v2_dosen';
				break;
			case 4:
				$user='_v2_mhsw';
				break;
			case 5:
				$user='_v2_adm_fak';
				break;
			case 6:
				$user='_v2_adm_pusat';
				break;
			case 7:
				$user='_v2_adm_jur';
				break;
		}
		return($user);
	}

	public function mencariDataFeeder(){

		$nim = $this->input->post('nim');
		//$id_PD = $this->additional_model->get_pd($nim);

		$dataToken = array (
			'act' => 'GetToken',
			'username' => '001028e1',
			'password' => 'az18^^'
		);

		$tokenFeeder = $this->runWS($dataToken);
		$obj = json_decode($tokenFeeder);
		$token = $obj->data->token;

		/*$filter = array();
		$filter['id_mahasiswa'] = '78e8981b-2818-4fc3-be0a-2a7cae2e4d57';*/

		$filter = "nim='$nim'";

		$dataInsertMhsw = array(
			'act' => 'GetListRiwayatPendidikanMahasiswa',
			'token' => $token,
			'filter' => $filter/*"nim = 'F23119138'" "id_mahasiswa = '78e8981b-2818-4fc3-be0a-2a7cae2e4d57'"*/,
			'limit' => 1
		);

		//print_r($dataInsertMhsw);

		$dataMhswFeeder = $this->runWS($dataInsertMhsw);
	 	$objMhs = json_decode($dataMhswFeeder);
	 	$error_codeMhs = $objMhs->{'error_code'};
	 	$error_descMhs = $objMhs->{'error_desc'};

	 	//print_r($dataMhswFeeder);

	 	if ( $error_codeMhs == 0 AND $objMhs->data[0]->{'nim'} != null ) {

	 		$dataFeeder = array(
	 			'ket' => 'sukses',
	 			'nim' => $objMhs->data[0]->{'nim'},
	 			'nama' => $objMhs->data[0]->{'nama_mahasiswa'},
	 			'pd' => $objMhs->data[0]->{'id_mahasiswa'},
	 			'reg' => $objMhs->data[0]->{'id_registrasi_mahasiswa'},
	 			'status' => $objMhs->data[0]->{'nama_jenis_daftar'}
	 		);

	 		//print_r($dataFeeder);

	 		echo json_encode($dataFeeder);

	 	} else {

	 		$dataFeeder = array(
	 			'ket' => 'error',
	 			'error_code' => $error_codeMhs,
	 			'error_desc' => $error_descMhs
	 		);

	 		echo json_encode($dataFeeder);

	 	}

	}

}