<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

class Matakuliah_smtr extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->helper('security');
	    $this->load->model('matakuliah_smtr_model');
	}

	public function index() {

		$level = $this->session->userdata('ulevel');
		$dataKode = $this->userKode();

		$data['jurusan'] = $this->matakuliah_smtr_model->get_dataSearch($level,$dataKode);

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

	public function getDataTabel() {

		$dataSearch = $this->security->xss_clean($this->input->post('dataSearch'));
		$kodeJur = $this->security->xss_clean($this->input->post('kodeJur'));
		$namaJurusan = $this->security->xss_clean($this->input->post('namaJurusan'));
		$level = $this->session->userdata('ulevel');
		$dataKode = $this->userKode();

		if ( empty($dataSearch) && empty($kodeJur) ) {

			$data['jurusan'] = $this->matakuliah_smtr_model->get_dataSearch($level,$dataKode);

			$data['footerSection'] = "<script type='text/javascript'>
 				swal({   
					title: 'Pemberitahuan',   
					type: 'warning',    
					html: true, 
					text: 'Anda Belum Memilih Jurusan, Silikan Memilih Jurusan yang Anda Ingin Tampilkan',
					confirmButtonColor: '#f7cb3b',   
				});
		    </script>";

			$this->load->view('dashbord',$data);

		} else {

			if ( empty($dataSearch) ) {

				$nmJurusan = $namaJurusan;
				$kode = $kodeJur;

			} else {

				$array = explode("-",$dataSearch);
				$nmJurusan = $array[1];
				$kode = $array[0];

			}

			$urutan = 1;

			$data['namaJurusan'] = $nmJurusan;
			$data['kurikulum'] = $this->matakuliah_smtr_model->getDetailKurikulum($kode,'N');
			$data['jurusan'] = $this->matakuliah_smtr_model->get_dataSearch($level,$dataKode);
			$data['tabel'] = $this->matakuliah_smtr_model->getMaxTabel($data['kurikulum']->IdKurikulum);

			for ($i=1; $i<=$data['tabel']->JmlTabel; $i++){
				$data['detailTabel'][$urutan++] = $this->matakuliah_smtr_model->getDetailTabel($data['kurikulum']->IdKurikulum,$i);
			}

			$data['footerSection'] = "<script type='text/javascript'>
 				$('#matakuliah1').DataTable();
				$('#matakuliah2').DataTable();
				$('#matakuliah3').DataTable();
				$('#matakuliah4').DataTable();
				$('#matakuliah5').DataTable();
				$('#matakuliah6').DataTable();
				$('#matakuliah7').DataTable();
				$('#matakuliah8').DataTable();
				$('#matakuliah9').DataTable();
				$('#matakuliah10').DataTable();
		    </script>";

			$this->load->view('dashbord',$data);
			
		}
		
	}

	public function formTambah($kodejur) {

		$kodefakul = substr($kodejur, 0, 1);
		$level = $this->session->userdata('ulevel');
		$dataKode = $this->userKode();

		$data['namaJurusan'] = /*str_replace("%20", " ", $namajurusan);*/
		$data['kodeJurusan'] = $kodejur;
		$data['matakuliah'] = $this->matakuliah_smtr_model->get_matakuliah($kodejur);
		$data['jurusan'] = $this->matakuliah_smtr_model->get_dataSearch($level,$dataKode);
		$data['dataKurikulum'] = $this->matakuliah_smtr_model->get_dataKurikulum($kodejur);
		$data['kurikulum'] = $this->matakuliah_smtr_model->getDetailKurikulum($kodejur,'N');

		$this->load->view('dashbord',$data);

	}

	public function validasiForm() {

		$matakuliah = explode(" ", $this->input->post('id'));
		$kurikulum = explode(" ", $this->input->post('kurikulum'));

		$data = $this->delete_spaces($matakuliah[0]);

		if ( $data == FALSE ) {

			$dataError = array(
				'ket' => 'error',
				'pesan' => 'Kode Mata Kuliah Tidak Boleh Menggunakan Spasi'
			);

			echo json_encode($dataError);

		} else {

			if ( $kurikulum[1] == '' ) {

				$dataError = array(
					'ket' => 'error',
					'pesan' => 'Kurikulum dengan Kode '.$kurikulum[0].' Belum Terdaftar di PDDIKTI, Silakan Anda Mengirim Kurikulum ini ke PDDIKTI Melalui Menu Kurikulum'
				);

				echo json_encode($dataError);

			} else {
		
				$config = array(
					array(
						'field' => 'id',
						'label' => 'ID Mata Kuliah',
						'rules' => 'required|max_length[100]',
						'errors' => array(
							'required' => '%s Tidak Boleh Kosong',
							'max_length' => '%s Maksimal 100 Karakter',
						)
					),
					array(
						'field' => 'urutan',
						'label' => 'Urutan ditranskip',
						'rules' => 'required|max_length[3]|is_natural',
						'errors' => array(
							'required' => '%s Tidak Boleh Kosong',
							'max_length' => '%s Maxsimal 3 Angka',
							'is_natural' => '%s Harus diisi dengan angka',
						)
					),
					array(
						'field' => 'semester',
						'label' => 'Semester',
						'rules' => 'required|max_length[2]|numeric',
						'errors' => array(
							'required' => '%s Tidak Boleh Kosong',
							'max_length' => '%s Harus diisi dengan 2 Angka',
							'numeric' => '%s Harus diisi dengan angka',
						)
					),
					array(
						'field' => 'kurikulum',
						'label' => 'Kurikulum',
						'rules' => 'required|max_length[100]',
						'errors' => array(
							'required' => '%s Tidak Boleh Kosong',
							'max_length' => 'Maxsimal Id %s 100 Karakter',
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
						'id' => $this->input->post('id'),
						'urutan' => $this->input->post('urutan'),
						'semester' => $this->input->post('semester'),
						'wajib' => $this->input->post('wajib'),
						'kurikulum' => $this->input->post('kurikulum')
					);

					$dataClean = $this->security->xss_clean($dataSukses);

					$this->kirimPDDIKTI($dataClean,'insert');
					
				}

			}

		}

	}

	private function delete_spaces($data) {

		return ( ! preg_match("~\s~", $data)) ? TRUE : FALSE;

	}
	

	public function setUpdate() {

		$dataMK = $this->matakuliah_smtr_model->getdataUpdate($this->input->post('id'));

		$this->kirimPDDIKTI($dataMK,'update');

	}

	public function setDeleteData() {

		$level = $this->input->post('level');

		if ( $level == 1 ) {

			$simpan = $this->matakuliah_smtr_model->deleteData($this->input->post('id'));

			if ( $simpan ) {

		 			$dataSukses = array(
						'ket' => 'sukses',
						'pesan' => 'Matakuliah Berhasil Terhapus di Kurikulum ini'
					);

					echo json_encode($dataSukses);

		 		} else {

		 			$dataError = array(
						'ket' => 'error',
						'pesan' => 'Matakuliah Gagal Terhapus di Siakad'
					);

					echo json_encode($dataError);

		 		}

		} else {

			$dataMK = $this->matakuliah_smtr_model->getdataUpdate($this->input->post('id'));

			$this->kirimPDDIKTI($dataMK,'delete');

		}

	}

	private function kirimPDDIKTI($data,$act) {

		$dataToken = array (
			'act' => 'GetToken',
			'username' => '001028e1',
			'password' => 'az18^^'
		);

		$tokenFeeder = $this->runWS($dataToken);
		$obj = json_decode($tokenFeeder);
		$token = $obj->data->token;

		if ( $act == 'insert' ) {

			$matakuliah = explode(' ', $data['id']);
			$kurikulum = explode(' ', $data['kurikulum']);

			if ( $data['wajib'] == 'Y' ) {

				$wajib = 1;

			} else {

				$wajib = 0;

			}

			$dataMKK = array();
			$dataMKK['id_kurikulum'] = $kurikulum[1];
			$dataMKK['id_matkul'] = $matakuliah[1];
			$dataMKK['semester'] = $data['semester'];
			$dataMKK['apakah_wajib'] = $wajib;

			$dataInsertMKK = array(
				'act' => 'InsertMatkulKurikulum',
				'token' => $token,
				'record' => $dataMKK
			);

			$dataMKKFeeder = $this->runWS($dataInsertMKK);
		 	$objMKK = json_decode($dataMKKFeeder);
		 	$error_codeMKK = $objMKK->{'error_code'};
		 	$error_descMKK = $objMKK->{'error_desc'};

		 	if ($error_codeMKK == 0) {

		 		$simpan = $this->matakuliah_smtr_model->updateData($data);

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
					'pesan' => $error_codeMKK."-".$error_descMKK
				);

				echo json_encode($dataError);

		 	}

		} elseif ( $act == 'update' ) {

			if ( $data[0]['Wajib'] == 'Y' ) {

				$wajib = 1;

			} else {

				$wajib = 0;

			}
			
			$dataMKK = array();
			$dataMKK['id_kurikulum'] = $data[0]['id_kurikulum'];
			$dataMKK['id_matkul'] = $data[0]['id_mk'];
			$dataMKK['semester'] = $data[0]['Sesi'];
			$dataMKK['apakah_wajib'] = $wajib;

			$dataInsertMKK = array(
				'act' => 'InsertMatkulKurikulum',
				'token' => $token,
				'record' => $dataMKK
			);

			$dataMKKFeeder = $this->runWS($dataInsertMKK);
		 	$objMKK = json_decode($dataMKKFeeder);
		 	$error_codeMKK = $objMKK->{'error_code'};
		 	$error_descMKK = $objMKK->{'error_desc'};

		 	if ($error_codeMKK == 0) {

		 		$simpan = $this->matakuliah_smtr_model->updateDatast_feeder($data);

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

		 	}

		} elseif ( $act == 'delete' ) {

			$key = array(
				'id_kurikulum' => $data[0]['id_kurikulum'],
				'id_matkul' => $data[0]['id_mk']
			);
			
			$dataDeleteMKK = array(
				'act' => 'DeleteMatkulKurikulum',
				'token' => $token,
				'key' => $key
	 		);


	 		$dataMKKFeeder = $this->runWS($dataDeleteMKK);
		 	$objMKK = json_decode($dataMKKFeeder);
		 	$error_codeMKK = $objMKK->{'error_code'};
		 	$error_descMKK = $objMKK->{'error_desc'};

		 	if ($error_codeMKK == 0) {
		 		
		 		$simpan = $this->matakuliah_smtr_model->deleteData($this->input->post('id'));

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
					'pesan' => $error_codeMKK."-".$error_descMKK
				);

				echo json_encode($dataError);

		 	}

		}

	}

}