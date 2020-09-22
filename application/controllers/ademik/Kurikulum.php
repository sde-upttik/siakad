<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

class Kurikulum extends CI_Controller {

	private $id;
	private $oldIdKurikulum;
	private $tgl, $namaKurikulum;
	private $newIdKurikulum;
	private $status;
	private $usernameFeeder = '001028e1';
	private $passwordFeeder = 'az18^^';

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->helper('security');
	    $this->load->model('kurikulum_model');
	}

	public function index() {

		$a['uri'] = $this->uri->segment(3);
		$a['data_jurusan'] = $this->getDataTabelJurusan();

		$this->load->view('dashbord',$a);

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

	public function detailKurikulum($parm) {

		$a['uri'] = $this->uri->segment(3);
		$a['detail_jurusan'] = $this->kurikulum_model->getDetailJurusan($parm);
		$a['detail_kurikulum'] = $this->kurikulum_model->getKurikulum($parm);
		$a['tabel_kurikulum'] = $this->kurikulum_model->getTabelKurikulum($parm);
		$a['data_jurusan'] = $this->getDataTabelJurusan();

		$this->load->view('dashbord',$a);

	}

	public function getDataEdit($id) {

		$data = $this->kurikulum_model->getKurikulumById($id);

		echo json_encode($data);
		
	}

	private function getUserKode() {

		if ( $this->session->userdata('ulevel') == 5 ) {
			return $dataKode = $this->session->userdata("kdf");
		} elseif ( $this->session->userdata('ulevel') == 7 ) {
			return $dataKode = $this->session->userdata("kdj");
		} else {
			return $dataKode = 0;
		}

	}

	private function getDataTabelJurusan() {

		$userLogin = $this->session->userdata('uname');
		$level = $this->session->userdata('ulevel');
		$user = $this->getUserKode();

		if ( $level == 5 ) {

			$listJurusan = $this->kurikulum_model->getTabelJurusan($user,'');
			return $listJurusan;

		} elseif ( ($level == 2) || ($level == 7) ) {

			$listJurusan = $this->kurikulum_model->getTabelJurusan($user,'');
			return $listJurusan;

		} else {

			$listJurusan = $this->kurikulum_model->getTabelJurusan('','Q');
			return $listJurusan;

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

	private function tglstmp($kodeFakul,$kodeJur2) {

		switch ($kodeFakul) {
			case 'A' : $dtbs='aisecon';$this->tgl="2003-01-05 07:30:15";break;
			case 'B' : $dtbs='aishukum';$this->tgl="2003-05-10 07:30:15";break;
			case 'C' : $dtbs='aismed';$this->tgl="2003-09-15 07:30:15";break;
			case 'D' : $dtbs='aistek';$this->tgl="2004-01-05 07:30:15";break;//20 Dec 2004
			case 'E' : $dtbs='aisss2006';$this->tgl="2004-05-10 07:30:15";break;//Komunikasi
			case 'F' : $dtbs='aissastra';$this->tgl="2004-09-15 07:30:15";break;
			case 'G' : $dtbs='aistani';$this->tgl="2005-01-05 07:30:15";break;
			case 'H' : {
				if ($kodeJur2=='H1') $dtbs='aismath';
				else if ($kodeJur2=='H2') $dtbs='aisfisika';
				else if ($kodeJur2=='H3') $dtbs='aiskimia';
				else $dtbs='aismipa';
				$this->tgl="2005-05-10 07:30:15";//$TGL="17 Dec 2006 07:30:15";
				}
				break;
			case 'I' : $dtbs='aisternak';$this->tgl="2005-09-15 07:30:15";break;
			case 'J' : $dtbs='aisgigi';$this->tgl="2006-01-05 07:30:15";break;
			case 'K' : $dtbs='aisfkm';$this->tgl="2006-05-10 07:30:15";break;
			case 'L' : $dtbs='aisfkip';$this->tgl="2006-09-15 07:30:15";break;
			case 'P' : $dtbs='aispasca';$this->tgl="2007-01-05 07:30:15";break;
		}

		return ($this->tgl);

	}

	private function createIdKurikulum($kodeJur,$tahun) {

		$kodeFakul = substr($kodeJur, 0,1);
		$kodeJur2 = substr($kodeJur, 0,2);

		$this->tglstmp($kodeFakul,$kodeJur2);
		
		$tmStmp = strtotime($this->tgl);
		$idKurikulumMax = $this->kurikulum_model->getMaxIdKurikulum($kodeFakul);

		if ( empty($idKurikulumMax) ) {

			$newIdKurikulum = $tmStmp;

		} else {

			$tmStmpMax = substr('$idKurikulumMax', -10,10);
			$newIdKurikulum = $tmStmpMax+1;

		}

		$this->newIdKurikulum = $kodeJur.$tahun.$newIdKurikulum;

	}
	
	private function getDataActive($kode) {

		$kurikulum = $this->kurikulum_model->getKurikulumActive($kode,'N');
		
		if ( !empty($kurikulum) ) {

			$this->status = $kurikulum->NotActive;
			$this->id = $kurikulum->ID;

		} else {

			$this->status = 'Y';
			$this->id = null;

		}

	}

	private function getOldIdKurikulum($kode,$tahun) {

		$idKurikulum = $this->kurikulum_model->getIdKurikulum($kode,$tahun);

		if ( !empty($idKurikulum) ) {

			$this->oldIdKurikulum = $idKurikulum->IdKurikulum;
			$this->namaKurikulum = $idKurikulum->Nama;

		} else {

			$this->oldIdKurikulum = null;

		}

	}

	public function validasiForm() {

		$sksLulus = $this->input->post('skslulus');
		$sksTotal = $this->input->post('skswajib') + $this->input->post('skspilihan');

		if ( $sksLulus != $sksTotal ) {

			$dataError = array(
				'ket' => 'error',
				'pesan' => 'SKS Lulus tidak sama jumlahnya dengan Total SKS Wajib ditambahkan dengan SKS Pilihan'
			);

			echo json_encode($dataError);

		} else {

			$config = array(
				array(
					'field' => 'tahun',
					'label' => 'Tahun',
					'rules' => 'required|exact_length[4]|is_natural',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'exact_length' => '%s Harus diisi dengan 4 Angka',
						'is_natural' => '%s Harus diisi dengan angka',
					)
				),
				array(
					'field' => 'nama',
					'label' => 'Nama Kurikulum',
					'rules' => 'required|max_length[50]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maxsimal 50 Karakter',
					)
				),
				array(
					'field' => 'sesi',
					'label' => 'Sesi',
					'rules' => 'required|max_length[50]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maxsimal 50 Karakter',
					)
				),
				array(
					'field' => 'jmlsesi',
					'label' => 'Jumlah Sesi',
					'rules' => 'required|max_length[2]|is_natural',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maxsimal 2 Angka',
						'is_natural' => '%s Harus diisi dengan angka',
					)
				),
				array(
					'field' => 'skslulus',
					'label' => 'Jumlah SKS Lulus',
					'rules' => 'required|max_length[3]|is_natural',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maxsimal 3 Angka',
						'is_natural' => '%s Harus diisi dengan angka',
					)
				),
				array(
					'field' => 'skswajib',
					'label' => 'Jumlah SKS Wajib',
					'rules' => 'required|max_length[3]|is_natural',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maxsimal 2 Angka',
						'is_natural' => '%s Harus diisi dengan angka',
					)
				),
				array(
					'field' => 'skspilihan',
					'label' => 'Jumlah SKS Pilihan',
					'rules' => 'required|max_length[3]|is_natural',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maxsimal 3 Angka',
						'is_natural' => '%s Harus diisi dengan angka',
					)
				),
				array(
					'field' => 'smtberlaku',
					'label' => 'Tahun Semester Berlaku',
					'rules' => 'required|exact_length[5]|is_natural',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'exact_length' => '%s Harus diisi dengan 5 Angka',
						'is_natural' => '%s Harus diisi dengan angka',
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
					'kode' => explode(" - ",$this->input->post('kode')),
					'id' => $this->input->post('id'),
					'notactive' => $this->input->post('notactive'),
					'nama' => $this->input->post('nama'),
					'tahun' => $this->input->post('tahun'),
					'sesi' => $this->input->post('sesi'),
					'jmlsesi' => $this->input->post('jmlsesi'),
					'skslulus' => $this->input->post('skslulus'),
					'skswajib' => $this->input->post('skswajib'),
					'skspilihan' => $this->input->post('skspilihan'),
					'smtberlaku' => $this->input->post('smtberlaku'),
					'user' => $this->session->userdata('uname'),
					'tglnow' => date('Y-m-d H:i:s')
				);

				$dataClean = $this->security->xss_clean($dataSukses);

				if ( ($this->input->post('act') == 'add') || ($this->input->post('act') == 'addnew') ) {

					$this->kirimPDDIKTI($dataClean,'insert');

				} else {

					$dataClean['id_kurikulum'] = $this->input->post('id_kurikulum');

					$this->kirimPDDIKTI($dataClean,'update');

				}
				
			}

		}

	}

	private function setTambah($data) {

		$kodeJur = $data['kode'][0];
		$tahun = $data['tahun'];
		$notactive = $data['notactive'];
		
		$this->getOldIdKurikulum($kodeJur,$tahun);
		$this->getDataActive($kodeJur);
		$this->createIdKurikulum($kodeJur,$tahun);

		if ( ( $this->oldIdKurikulum == $this->newIdKurikulum ) ) {

			$dataError = array(
				'ket' => 'error',
				'pesan' => 'Kurikulum Tahun '.$tahun.' Sudah Ada dengan Nama '.$this->namaKurikulum
			);

			echo json_encode($dataError);

		} elseif ( ( $this->oldIdKurikulum != $this->newIdKurikulum ) && ( $this->status == $notactive ) ) {

			if ( $this->status == 'N' ) {

				$data['idKurikulum'] = $this->newIdKurikulum;
				$dataConfirm = array(
					'ket' => 'konfirmasi',
					'pesan' => 'Anda Yakin Menambahkan Sekaligus Mengaktifkan Kurikulum Ini dan Menonaktifkan Kurikulum yang Aktif?',
					'act' => 'add',
					'data' => $data,
					'idaktif' => $this->id
				);

				echo json_encode($dataConfirm);

			} else {

				$data['idKurikulum'] = $this->newIdKurikulum;
				$dataInsert = $data;
				$idaktif = 'aktif';

				$this->kurikulum_model->insertData($dataInsert,$idaktif);

				$dataSukses = array(
					'ket' => 'sukses',
					'pesan' => 'Kurikulum ini Berhasil Ditambahkan dan Diaktifkan'
				);

				echo json_encode($dataSukses);

			}

		} elseif ( ( $this->oldIdKurikulum != $this->newIdKurikulum ) && ( $this->status != $notactive ) ) {

			if ( $this->status == 'N' ) {

				$data['idKurikulum'] = $this->newIdKurikulum;
				$dataInsert = $data;
				$idaktif = '';

				$this->kurikulum_model->insertData($dataInsert,$idaktif);

				$dataSukses = array(
					'ket' => 'sukses',
					'pesan' => 'Kurikulum ini Berhasil Ditambahkan'
				);

				echo json_encode($dataSukses);

			} else {

				$data['idKurikulum'] = $this->newIdKurikulum;
				$dataInsert = $data;
				$idaktif = 'aktif';

				$this->kurikulum_model->insertData($dataInsert,$idaktif);

				$dataSukses = array(
					'ket' => 'sukses',
					'pesan' => 'Kurikulum ini Berhasil Ditambahkan dan Diaktifkan'
				);

				echo json_encode($dataSukses);

			}

		}

	}

	public function setTambahAktif() {

		$idAktif = $this->input->post('idAktif');

		$dataTambah = array(
			'idKurikulum' => $this->input->post('idKurikulum'),
			'kode' => explode(",",$this->input->post('kode')),
			'id' => $this->input->post('id'),
			'notactive' => $this->input->post('notactive'),
			'nama' => $this->input->post('nama'),
			'tahun' => $this->input->post('tahun'),
			'sesi' => $this->input->post('sesi'),
			'jmlsesi' => $this->input->post('jmlsesi'),
			'skslulus' => $this->input->post('skslulus'),
			'skswajib' => $this->input->post('skswajib'),
			'skspilihan' => $this->input->post('skspilihan'),
			'smtberlaku' => $this->input->post('smtberlaku'),
			'user' => $this->input->post('user'),
			'tglnow' => $this->input->post('tglnow'),
			'id_kurikulum' => $this->input->post('id_kurikulum')
		);

		$this->kurikulum_model->insertData($dataTambah,$idAktif);

		$dataSukses = array(
			'ket' => 'sukses',
			'pesan' => 'Kurikulum ini Berhasil Ditambahkan dan Diaktifkan'
		);

		echo json_encode($dataSukses);

	}

	private function setEdit($data) {

		$kode = $data['kode'][0];
		$id = $data['id'];
		$notactive = $data['notactive'];

		$this->getDataActive($kode);

		if ( $this->id == null ) {

			$dataUpdata = $data;
			$idaktif = 'aktif';

			$this->kurikulum_model->updateData($dataUpdata,$idaktif);

			$dataSukses = array(
				'ket' => 'sukses',
				'pesan' => 'Data Kurikulum Berhasil Diupdate dan Diaktifkan'
			);

			echo json_encode($dataSukses);

		} else {

			if ( ( $this->id == $id ) && ( $this->status == $notactive ) ) {

				$dataUpdata = $data;
				$idaktif = '';

				$this->kurikulum_model->updateData($dataUpdata,$idaktif);

				$dataSukses = array(
					'ket' => 'sukses',
					'pesan' => 'Data Kurikulum Berhasil Diupdate'
				);

				echo json_encode($dataSukses);

			} elseif ( ( $this->id != $id ) && ( $this->status != $notactive ) ) {

				$dataUpdata = $data;
				$idaktif = '';

				$this->kurikulum_model->updateData($dataUpdata,$idaktif);

				$dataSukses = array(
					'ket' => 'sukses',
					'pesan' => 'Data Kurikulum Berhasil Diupdate'
				);

				echo json_encode($dataSukses);

			} elseif ( ( $this->id == $id ) && ( $this->status != $notactive ) ) {

				$dataError = array(
					'ket' => 'error',
					'pesan' => 'Kurikulum ini tidak bisa dinonaktifkan Karena Kurikulum harus ada yang aktif'
				);

				echo json_encode($dataError);

			} elseif ( ( $this->id != $id ) && ( $this->status == $notactive ) ) {

				$dataConfirm = array(
					'ket' => 'konfirmasi',
					'pesan' => 'Anda Yakin Mengaktifkan Kurikulum Ini dan Menonaktifkan Kurikulum yang Aktif?',
					'act' => 'update',
					'data' => $data,
					'idaktif' => $this->id
				);

				echo json_encode($dataConfirm);

			}
			
		}
		
	}

	public function setEditAktif() {

		$idAktif = $this->input->post('idAktif');

		$dataEdit = array(
			'kode' => explode(",",$this->input->post('kode')),
			'id' => $this->input->post('id'),
			'notactive' => $this->input->post('notactive'),
			'nama' => $this->input->post('nama'),
			'tahun' => $this->input->post('tahun'),
			'sesi' => $this->input->post('sesi'),
			'jmlsesi' => $this->input->post('jmlsesi'),
			'skslulus' => $this->input->post('skslulus'),
			'skswajib' => $this->input->post('skswajib'),
			'skspilihan' => $this->input->post('skspilihan'),
			'smtberlaku' => $this->input->post('smtberlaku'),
			'user' => $this->input->post('user'),
			'tglnow' => $this->input->post('tglnow')
		);

		$this->kurikulum_model->updateData($dataEdit,$idAktif);

		$dataSukses = array(
			'ket' => 'sukses',
			'pesan' => 'Data Kurikulum Berhasil Diupdate dan Diaktifkan'
		);

		echo json_encode($dataSukses);

	}

	public function setHapusData() {

		$id = $this->input->post('id');
		$kode = explode(" - ", $this->input->post('kode'));
		$kodeJur = $kode[0];
		$id_kurikulum = $this->input->post('id_kurikulum');

		$dataHapusFeeder = array(
			'id' => $id,
			'id_kurikulum' => $id_kurikulum 
		);

		$this->getDataActive($kodeJur);

		if ( $this->id == null ) {

			$this->kirimPDDIKTI($dataHapusFeeder,'delete');

		} else {

			if ( $this->id == $id ) {

				$dataError = array(
					'ket' => 'error',
					'pesan' => 'Kurikulum ini Tidak Bisa Dihapus Karena Berstatus Aktif'
				);

				echo json_encode($dataError);

			} else {

				$this->kirimPDDIKTI($dataHapusFeeder,'delete');

			}

		}

	}

	private function kirimPDDIKTI ($data,$act) {

		$dataToken = array (
			'act' => 'GetToken',
			'username' => '001028e1',
			'password' => 'az18^^'
		);

		$tokenFeeder = $this->runWS($dataToken);
		$obj = json_decode($tokenFeeder);
		$token = $obj->data->token;

		if ( $act == 'insert' ) {

			$dataProdi = $this->kurikulum_model->getDetailJurusan($data['kode'][0]);

			$dataKurikulum = array();
			$dataKurikulum['nama_kurikulum'] = $data['nama'];
			$dataKurikulum['id_prodi'] = $dataProdi->id_sms;
			$dataKurikulum['id_semester'] = $data['smtberlaku'];
			$dataKurikulum['jumlah_sks_lulus'] = $data['skslulus'];
			$dataKurikulum['jumlah_sks_wajib'] = $data['skswajib'];
			$dataKurikulum['jumlah_sks_pilihan'] = $data['skspilihan'];

			$dataInsertKurikulum = array(
				'act' => 'InsertKurikulum',
				'token' => $token,
	 			'record'=> $dataKurikulum

	 		);

	 		$dataKurikulumFeeder = $this->runWS($dataInsertKurikulum);
		 	$objKurikulum = json_decode($dataKurikulumFeeder);
		 	$error_codeKurikulum = $objKurikulum->{'error_code'};
		 	$error_descKurikulum = $objKurikulum->{'error_desc'};

		 	if ($error_codeKurikulum == 0) {

		 		$id_kurikulum = $objKurikulum->{'data'}->{'id_kurikulum'};

		 		$data['id_kurikulum'] = $id_kurikulum;
		 		
		 		$this->setTambah($data);

		 	} else {

		 		$dataError = array(
					'ket' => 'error',
					'pesan' => $error_codeKurikulum."-".$error_descKurikulum
				);

				echo json_encode($dataError);

		 	}

		} elseif ( $act == 'update' ) {

			$dataProdi = $this->kurikulum_model->getDetailJurusan($data['kode'][0]);

			$dataKurikulum = array();
			$dataKurikulum['nama_kurikulum'] = $data['nama'];
			$dataKurikulum['id_prodi'] = $dataProdi->id_sms;
			$dataKurikulum['id_semester'] = $data['smtberlaku'];
			$dataKurikulum['jumlah_sks_lulus'] = $data['skslulus'];
			$dataKurikulum['jumlah_sks_wajib'] = $data['skswajib'];
			$dataKurikulum['jumlah_sks_pilihan'] = $data['skspilihan'];

			$key = array(
				'id_kurikulum' => $data['id_kurikulum'] 
			);
			
			$dataUpdateKurikulum = array(
				'act' => 'UpdateKurikulum',
				'token' => $token,
				'key' => $key,
	 			'record' => $dataKurikulum
	 		);


	 		$dataKurikulumFeeder = $this->runWS($dataUpdateKurikulum);
		 	$objKurikulum = json_decode($dataKurikulumFeeder);
		 	$error_codeKurikulum = $objKurikulum->{'error_code'};
		 	$error_descKurikulum = $objKurikulum->{'error_desc'};

		 	if ( $error_codeKurikulum == 0 ) {

		 		$data['id_kurikulum'] = '';
		 		
		 		$this->setEdit($data);

		 	} elseif ( $error_codeKurikulum == 111 ) {

		 		$dataProdi = $this->kurikulum_model->getDetailJurusan($data['kode'][0]);

				$dataKurikulum = array();
				$dataKurikulum['nama_kurikulum'] = $data['nama'];
				$dataKurikulum['id_prodi'] = $dataProdi->id_sms;
				$dataKurikulum['id_semester'] = $data['smtberlaku'];
				$dataKurikulum['jumlah_sks_lulus'] = $data['skslulus'];
				$dataKurikulum['jumlah_sks_wajib'] = $data['skswajib'];
				$dataKurikulum['jumlah_sks_pilihan'] = $data['skspilihan'];

				$dataInsertKurikulum = array(
					'act' => 'InsertKurikulum',
					'token' => $token,
		 			'record'=> $dataKurikulum
		 		);

		 		$dataKurikulumFeeder = $this->runWS($dataInsertKurikulum);
			 	$objKurikulum = json_decode($dataKurikulumFeeder);
			 	$error_codeKurikulum = $objKurikulum->{'error_code'};
			 	$error_descKurikulum = $objKurikulum->{'error_desc'};

			 	if ($error_codeKurikulum == 0) {

			 		$id_kurikulum = $objKurikulum->{'data'}->{'id_kurikulum'};

			 		$data['id_kurikulum'] = $id_kurikulum;
			 		
			 		$this->setEdit($data);

			 	} else {

			 		$dataError = array(
						'ket' => 'error',
						'pesan' => $error_codeKurikulum."-".$error_descKurikulum
					);

					echo json_encode($dataError);

			 	}

		 	} else {

		 		$dataError = array(
					'ket' => 'error',
					'pesan' => $error_codeKurikulum."-".$error_descKurikulum
				);

				echo json_encode($dataError);

		 	}

		} elseif ( $act == 'delete' ) {
			
			$key = array(
				'id_kurikulum' => $data['id_kurikulum']
			);
			
			$dataDeleteKurikulum = array(
				'act' => 'DeleteKurikulum',
				'token' => $token,
				'key' => $key
	 		);


	 		$dataKurikulumFeeder = $this->runWS($dataDeleteKurikulum);
		 	$objKurikulum = json_decode($dataKurikulumFeeder);
		 	$error_codeKurikulum = $objKurikulum->{'error_code'};
		 	$error_descKurikulum = $objKurikulum->{'error_desc'};

		 	if ($error_codeKurikulum == 0) {
		 		
		 		$this->kurikulum_model->hapusData($data['id']);

		 		$dataSukses = array(
					'ket' => 'sukses',
					'pesan' => 'Kurikulum ini Berhasil Dihapus'
				);

				echo json_encode($dataSukses);

		 	} else {

		 		$dataError = array(
					'ket' => 'error',
					'pesan' => $error_codeKurikulum."-".$error_descKurikulum
				);

				echo json_encode($dataError);

		 	}

		}

	}

}