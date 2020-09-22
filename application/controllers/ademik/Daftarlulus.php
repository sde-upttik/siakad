<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

class Daftarlulus extends CI_Controller {

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

	public function formTambahLulusDO() {

		$data['jenis_keluar'] =  $this->additional_model->getListJenisKeluar();

		$this->load->view('dashbord',$data);

	}

	public function formPrcLulusDO() {

		$this->load->view('dashbord');

	}

	public function prcLulusDOjs() {

		$data = $this->additional_model->getListKeluarPrc();

		echo json_encode($data);

	}

	public function prcdataupdateJs() {

		$data = $this->additional_model->getListKeluarUpdatePrc();

		echo json_encode($data);

	}

	public function prcjs() {

		$dataToken = array (
			'act' => 'GetToken',
			'username' => '001028e1',
			'password' => 'az18^^'
		);

		$tokenFeeder = $this->runWS($dataToken);
		$obj = json_decode($tokenFeeder);
		$token = $obj->data->token;

		$mhswKeluar = array();
		$mhswKeluar['id_registrasi_mahasiswa'] = $this->input->post('id_reg');
		$mhswKeluar['id_jenis_keluar'] = $this->input->post('id_keluar');
		$mhswKeluar['tanggal_keluar'] = $this->input->post('tgl_keluar');

		$dataInsert = array(
			'act' => 'InsertMahasiswaLulusDO',
			'token' => $token,
			'record' => $mhswKeluar
		);;

		$dataMhswKeluar = $this->runWS($dataInsert);
	 	$objMhswKeluar = json_decode($dataMhswKeluar);
	 	$error_codeMhswKeluar = $objMhswKeluar->{'error_code'};
	 	$error_descMhswKeluar = $objMhswKeluar->{'error_desc'};
		

	 	if ($error_codeMhswKeluar == 0) {

	 		$simpan = $this->additional_model->updateDataMhswKeluarPrc($this->input->post('nim'));

	 		if ( $simpan ) {

	 			$data = array(
					'ket' => 'Berhasil',
					'nim' => $this->input->post('nim'),
					'nama' => $this->input->post('nama')

				);

	 			echo json_encode($data);

	 		} else {

	 			$data = array(
					'ket' => 'Gagal Tersimpan di database',
					'nim' => $this->input->post('nim'),
					'nama' => $this->input->post('nama')

				);

	 			echo json_encode($data);
	 			

	 		}

	 	} else {

	 		$simpan = $this->additional_model->updateErrorMhswKeluar($this->input->post('nim'), $error_codeMhswKeluar, $error_descMhswKeluar);

	 		if ( $simpan ) {

	 			$data = array(
					'ket' => 'error '. $error_descMhswKeluar,
					'nim' => $this->input->post('nim'),
					'nama' => $this->input->post('nama')

				);

	 			echo json_encode($data);

	 		} else {

	 			$data = array(
					'ket' => 'Gagal Tersimpan di Database',
					'nim' => $this->input->post('nim'),
					'nama' => $this->input->post('nama')

				);

	 			echo json_encode($data);

	 		}

	 	}

	}

	public function prcupdatejs() {

		$dataToken = array (
			'act' => 'GetToken',
			'username' => '001028e1',
			'password' => 'az18^^'
		);

		$tokenFeeder = $this->runWS($dataToken);
		$obj = json_decode($tokenFeeder);
		$token = $obj->data->token;

		$mhswKeluar = array();
		$mhswKeluar['id_jenis_keluar'] = $this->input->post('id_keluar');
		$mhswKeluar['tanggal_keluar'] = $this->input->post('tgl_keluar');

		$key = array(
			'id_registrasi_mahasiswa' => $this->input->post('id_reg')
		);

		$dataInsert = array(
			'act' => 'UpdateMahasiswaLulusDO',
			'token' => $token,
			'key' => $key,
			'record' => $mhswKeluar
		);

		$dataMhswKeluar = $this->runWS($dataInsert);
	 	$objMhswKeluar = json_decode($dataMhswKeluar);
	 	$error_codeMhswKeluar = $objMhswKeluar->{'error_code'};
	 	$error_descMhswKeluar = $objMhswKeluar->{'error_desc'};
		

	 	if ($error_codeMhswKeluar == 0) {

	 		$simpan = $this->additional_model->updateDataMhswKeluarPrc2($this->input->post('nim'));

	 		if ( $simpan ) {

	 			$data = array(
					'ket' => 'Berhasil',
					'nim' => $this->input->post('nim'),
					'nama' => $this->input->post('nama')

				);

	 			echo json_encode($data);

	 		} else {

	 			$data = array(
					'ket' => 'Gagal Tersimpan di database',
					'nim' => $this->input->post('nim'),
					'nama' => $this->input->post('nama')

				);

	 			echo json_encode($data);
	 			

	 		}

	 	} else {

	 		$simpan = $this->additional_model->updateErrorMhswKeluar($this->input->post('nim'), $error_codeMhswKeluar, $error_descMhswKeluar);

	 		if ( $simpan ) {

	 			$data = array(
					'ket' => 'error '. $error_descMhswKeluar,
					'nim' => $this->input->post('nim'),
					'nama' => $this->input->post('nama')

				);

	 			echo json_encode($data);

	 		} else {

	 			$data = array(
					'ket' => 'Gagal Tersimpan di Database',
					'nim' => $this->input->post('nim'),
					'nama' => $this->input->post('nama')

				);

	 			echo json_encode($data);

	 		}

	 	}

	}

	public function formEditLulusDO($nim) {

		$this->load->view('dashbord',$data);

	}

	private function rubahFormatTanggal($date) {

		$data = date('d-m-Y', strtotime($date));

		return $data;

	}

	public function mencariDataMhsw($nim) {

		$datamhsw = $this->additional_model->getDataMhsw($nim);

		if ( empty($datamhsw) ) {

			$data = '';

			echo json_encode($data);

		} else {

			$data = array(
				'mhsw' => $datamhsw,
				'tgl_lulus' => $this->rubahFormatTanggal($datamhsw->TglLulus),
				'tgl_yudisium' => $this->rubahFormatTanggal($datamhsw->TglSKYudisium)
			);

			echo json_encode($data);

		}

	}

	public function validasiDataLulusDO() {

		$config = array(
			array(
				'field' => 'nim',
				'label' => 'Stambuk Mahasiswa',
				'rules' => 'required|max_length[11]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 11 Karakter',
				)
			),
			array(
				'field' => 'id_reg',
				'label' => 'Mahasiswa',
				'rules' => 'required|max_length[200]',
				'errors' => array(
					'required' => 'Stambuk %s Belum Terdaftar di Feeder',
					'max_length' => '%s Maksimal 200 Karakter',
				)
			),
			array(
				'field' => 'keluar',
				'label' => 'Jenis keluar',
				'rules' => 'required|max_length[1]|trim',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 1 Karakter',
				)
			),
			array(
				'field' => 'ket',
				'label' => 'Keterangan',
				'rules' => 'max_length[128]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 128 Karakter',
				)
			),
			array(
				'field' => 'no_sk',
				'label' => 'Tipe Pembayaran',
				'rules' => 'max_length[80]',
				'errors' => array(
					'max_length' => '%s Maxsimal 80 Karakter',
				)
			),
			array(
				'field' => 'ipk',
				'label' => 'Keterangan',
				'rules' => 'numeric',
				'errors' => array(
					'numeric' => '%s Harus Angka',
				)
			),
			array(
				'field' => 'no_ijazah',
				'label' => 'Keterangan',
				'rules' => 'max_length[80]',
				'errors' => array(
					'max_length' => '%s Maxsimal 80 Karakter',
				)
			),
		);

		$this->form_validation->set_rules($config);

		if ( $this->form_validation->run() == FALSE ) {

			$dataError = array(
				'ket' => 'error',
				'pesan' => validation_errors()
			);

			echo json_encode($dataError);

		} else {

			$dataSukses = array(
				'nim' => $this->input->post('nim'),
				'id_reg' => $this->input->post('id_reg'),
				'keluar' => $this->input->post('keluar'),
				'tgl_keluar' => date('Y-m-d', strtotime($this->input->post('tgl_keluar'))),
				'ket' => $this->input->post('ket'),
				'no_sk' => $this->input->post('no_sk'),
				'tgl_sk' => date('Y-m-d', strtotime($this->input->post('tgl_sk'))),
				'ipk' => $this->input->post('ipk'),
				'no_ijazah' => $this->input->post('no_ijazah')
			);

			$dataClean = $this->security->xss_clean($dataSukses);

			$cek = $this->additional_model->cekMhswKeluar($this->input->post('nim'));

			if ( $cek == FALSE ) {

				$this->kirimPDDIKTI($dataClean, $this->input->post('act'),'-1');

			} elseif ( $cek == TRUE ) {

				$this->kirimPDDIKTI($dataClean, $this->input->post('act'), $cek->st_feeder);

			}

		}

	}

	private function kirimPDDIKTI($data,$act,$feeder) {

		$dataToken = array (
			'act' => 'GetToken',
			'username' => '001028e1',
			'password' => 'az18^^'
		);

		$tokenFeeder = $this->runWS($dataToken);
		$obj = json_decode($tokenFeeder);
		$token = $obj->data->token;

		if ( $act == 'insert' ) {

			$mhswKeluar = array();
			$mhswKeluar['id_registrasi_mahasiswa'] = $data['id_reg'];
			$mhswKeluar['id_jenis_keluar'] = $data['keluar'];
			$mhswKeluar['tanggal_keluar'] = $data['tgl_keluar'];
			$mhswKeluar['keterangan'] = $data['ket'];
			$mhswKeluar['nomor_sk_yudisium'] = $data['no_sk'];
			$mhswKeluar['tanggal_sk_yudisium'] = $data['tgl_sk'];
			$mhswKeluar['ipk'] = $data['ipk'];
			$mhswKeluar['nomor_ijazah'] = $data['no_ijazah'];

			$dataInsert = array(
				'act' => 'InsertMahasiswaLulusDO',
				'token' => $token,
				'record' => $mhswKeluar
			);

			$dataMhswKeluar = $this->runWS($dataInsert);
		 	$objMhswKeluar = json_decode($dataMhswKeluar);
		 	$error_codeMhswKeluar = $objMhswKeluar->{'error_code'};
		 	$error_descMhswKeluar = $objMhswKeluar->{'error_desc'};

		 	if ($error_codeMhswKeluar == 0) {

		 		if ( $feeder == -1 ) {

		 			$simpan = $this->additional_model->insertDataMhswKeluar($data);

		 		} elseif ( $feeder >= 0 ){

		 			$simpan = $this->additional_model->updateDataMhswKeluar($data);

		 		}

		 		if ( $simpan ) {

		 			$dataSukses = array(
						'ket' => 'sukses',
						'pesan' => 'Berhasil Terkirim Ke PDDIKTI dan Tersimpan'
					);

					echo json_encode($dataSukses);

		 		} else {

		 			$dataError = array(
						'ket' => 'error',
						'pesan' => 'Berhasil Terkirim Ke PDDIKTI, Gagal Tersimpan di Server Siakad'
					);

					echo json_encode($dataError);

		 		}

		 	} else {

		 		$dataError = array(
					'ket' => 'error',
					'pesan' => $error_codeMhswKeluar."-".$error_descMhswKeluar
				);

				echo json_encode($dataError);

		 	}

		} elseif ( $act == 'update' ) {

			$mhswKeluar = array();
			$mhswKeluar['id_jenis_keluar'] = $data['keluar'];
			$mhswKeluar['tanggal_keluar'] = $data['tgl_keluar'];
			$mhswKeluar['keterangan'] = $data['ket'];
			$mhswKeluar['nomor_sk_yudisium'] = $data['no_sk'];
			$mhswKeluar['tanggal_sk_yudisium'] = $data['tgl_sk'];
			$mhswKeluar['ipk'] = $data['ipk'];
			$mhswKeluar['nomor_ijazah'] = $data['no_ijazah'];

			$key = array(
				'id_registrasi_mahasiswa' => $data['id_reg']
			);

			$dataInsert = array(
				'act' => 'UpdateMahasiswaLulusDO',
				'token' => $token,
				'key' => $key,
				'record' => $mhswKeluar
			);

			$dataMhswKeluar = $this->runWS($dataInsert);
		 	$objMhswKeluar = json_decode($dataMhswKeluar);
		 	$error_codeMhswKeluar = $objMhswKeluar->{'error_code'};
		 	$error_descMhswKeluar = $objMhswKeluar->{'error_desc'};

		 	if ($error_codeMhswKeluar == 0) {

		 		if ( $feeder == -1 ) {

		 			$simpan = $this->additional_model->insertDataMhswKeluar($data);

		 		} elseif ( $feeder >= 0 ){

		 			$simpan = $this->additional_model->updateDataMhswKeluar($data);

		 		}

		 		if ( $simpan ) {

		 			$dataSukses = array(
						'ket' => 'sukses',
						'pesan' => 'Berhasil Terkirim Ke PDDIKTI dan Tersimpan'
					);

					echo json_encode($dataSukses);

		 		} else {

		 			$dataError = array(
						'ket' => 'error',
						'pesan' => 'Berhasil Terkirim Ke PDDIKTI, Gagal Tersimpan di Server Siakad'
					);

					echo json_encode($dataError);

		 		}

		 	} else {

		 		$dataError = array(
					'ket' => 'error',
					'pesan' => $error_codeMhswKeluar."-".$error_descMhswKeluar
				);

				echo json_encode($dataError);

		 	}

		} elseif ( $act == 'prc' ) {

		}

	}

}