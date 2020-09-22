<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

class Matakuliah_jns extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->helper('security');
	    $this->load->model('matakuliah_jns_model');
	}

	public function index() {

		$level = $this->session->userdata('ulevel');
		$dataKode = $this->userKode();

		$data['jurusan'] = $this->matakuliah_jns_model->get_dataSearch($level,$dataKode);

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

	public function getDataTabel() {

		$dataSearch = $this->security->xss_clean($this->input->post('dataSearch'));
		$kodeJur = $this->security->xss_clean($this->input->post('kodeJur'));
		$namaJurusan = $this->security->xss_clean($this->input->post('namaJurusan'));
		$level = $this->session->userdata('ulevel');
		$dataKode = $this->userKode();

		if ( empty($dataSearch) && empty($kodeJur) ) {

			$data['jurusan'] = $this->matakuliah_jns_model->get_dataSearch($level,$dataKode);

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

				$nmJurusan = str_replace(",", " ", $namaJurusan);
				$kode = $kodeJur;

			} else {

				$array = explode("-",$dataSearch);
				$nmJurusan = str_replace(",", " ", $array[1]);
				$kode = $array[0];

			}

			$data['namaJurusan'] = $nmJurusan;
			$data['kurikulum'] = $this->matakuliah_jns_model->getDetailKurikulum($kode,'N');
			$data['jurusan'] = $this->matakuliah_jns_model->get_dataSearch($level,$dataKode);
			$data['detailTabel'] = $this->matakuliah_jns_model->getDetailTabel($kode);

			$this->load->view('dashbord',$data);
			
		}
		
	}

	public function formTambah($kodejur,$namajurusan) {

		$level = $this->session->userdata('ulevel');
		$dataKode = $this->userKode();
		$kodefakul= $this->matakuliah_jns_model->get_kodefakul($kodejur);

		$data['namaJurusan'] = str_replace("%20", " ", $namajurusan);
		$data['kodeJurusan'] = $kodejur;
		$data['jenisMK'] = $this->matakuliah_jns_model->get_dataJenisMK($kodefakul->KodeFakultas);
		$data['jurusan'] = $this->matakuliah_jns_model->get_dataSearch($level,$dataKode);
		$data['dataKurikulum'] = $this->matakuliah_jns_model->get_dataKurikulum();
		$data['kurikulum'] = $this->matakuliah_jns_model->getDetailKurikulum($kodejur,'N');
		$data['user'] = $this->getUser($this->session->userdata('ulevel'));

		$this->load->view('dashbord',$data);

	}

	public function formEdit($kodeJur,$namaJurusan,$id) {

		$level = $this->session->userdata('ulevel');
		$dataKode = $this->userKode();

		if($this->input->post('namaJurusan')!=null or $this->input->post('namaJurusan')!=''){

			$namaJurusan = $this->security->xss_clean($this->input->post('namaJurusan'));
			$kodeJur = $this->security->xss_clean($this->input->post('kodeJur'));
			$kodefakul= $this->matakuliah_jns_model->get_kodefakul($kodeJur);

			$data['pageweb'] = 'formEdit';
			$data['namaJurusan'] = $namaJurusan;
			$data['kodeJurusan'] = $kodeJur;
			$data['jenisMK'] = $this->matakuliah_jns_model->get_dataJenisMK($kodefakul->KodeFakultas);
			$data['jurusan'] = $this->matakuliah_jns_model->get_dataSearch($level,$dataKode);
			$data['dataKurikulum'] = $this->matakuliah_jns_model->get_dataKurikulum();
			$data['kurikulum'] = $this->matakuliah_jns_model->getDetailKurikulum($kodeJur,'N');
			$data['detailEdit'] = $this->matakuliah_jns_model->getDataEdit($this->security->xss_clean($this->input->post('id')));
			$data['user'] = $this->getUser($this->session->userdata('ulevel'));

			/*$this->load->view('dashbord',$data);*/

			echo $kodefakul;

		}else{

			$namaJurusan = str_replace('%20', ' ', $this->security->xss_clean($namaJurusan));
			$kodeJur = $this->security->xss_clean($kodeJur);
			$kodefakul= $this->matakuliah_jns_model->get_kodefakul($kodeJur);

			$data['pageweb'] = 'formEdit';
			$data['namaJurusan'] = $namaJurusan;
			$data['kodeJurusan'] = $kodeJur;
			$data['jenisMK'] = $this->matakuliah_jns_model->get_dataJenisMK($kodefakul->KodeFakultas);
			$data['jurusan'] = $this->matakuliah_jns_model->get_dataSearch($level,$dataKode);
			$data['dataKurikulum'] = $this->matakuliah_jns_model->get_dataKurikulum();
			$data['kurikulum'] = $this->matakuliah_jns_model->getDetailKurikulum($kodeJur,'N');
			$data['detailEdit'] = $this->matakuliah_jns_model->getDataEdit($this->security->xss_clean($id));
			$data['user'] = $this->getUser($this->session->userdata('ulevel'));

			$this->load->view('dashbord',$data);

		}
	}

	public function validasiForm() {

		$data = $this->delete_spaces($this->input->post('kodeMK'));

		if ( $data == FALSE ) {

				$dataError = array(
				'ket' => 'error',
				'pesan' => 'Kode Mata Kuliah Tidak Boleh Menggunakan Spasi'
			);

			echo json_encode($dataError);

		} else {
		
			$config = array(
				array(
					'field' => 'jurusan',
					'label' => 'Jurusan',
					'rules' => 'required|max_length[100]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maksimal 100 Karakter',
					)
				),
				array(
					'field' => 'kodeMK',
					'label' => 'Kode Mata Kuliah',
					'rules' => 'required|max_length[15]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maksimal 15 Karakter',
					)
				),
				array(
					'field' => 'namaIndo',
					'label' => 'Nama Indonesia',
					'rules' => 'required|max_length[100]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maxsimal 100 Karakter',
					)
				),
				array(
					'field' => 'namaEng',
					'label' => 'Nama English',
					'rules' => 'required|max_length[100]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maxsimal 100 Karakter',
					)
				),
				array(
					'field' => 'sksMK',
					'label' => 'SKS Mata Kuliah',
					'rules' => 'required|max_length[3]|numeric',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maxsimal 3 Angka',
						'numeric' => '%s Harus diisi dengan angka',
					)
				),
				array(
					'field' => 'sksTM',
					'label' => 'SKS Tatap Muka',
					'rules' => 'required|max_length[2]|numeric',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maxsimal 2 Angka',
						'numeric' => '%s Harus diisi dengan angka',
					)
				),
				array(
					'field' => 'sksP',
					'label' => 'SKS Praktikum',
					'rules' => 'required|max_length[1]|numeric',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maxsimal 1 Angka',
						'numeric' => '%s Harus diisi dengan angka',
					)
				),
				array(
					'field' => 'sksPL',
					'label' => 'SKS Praktikum Lapangan',
					'rules' => 'required|max_length[1]|numeric',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maxsimal 1 Angka',
						'numeric' => '%s Harus diisi dengan angka',
					)
				),
				array(
					'field' => 'sksS',
					'label' => 'SKS Simulasi',
					'rules' => 'required|max_length[1]|numeric',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maxsimal 1 Angka',
						'numeric' => '%s Harus diisi dengan angka',
					)
				),
				array(
					'field' => 'metode_belajar',
					'label' => 'Metode Pembelajaran',
					'rules' => 'max_length[50]',
					'errors' => array(
						'max_length' => '%s Maxsimal 50 Karakter',
					)
				),
				array(
					'field' => 'jenisMK',
					'label' => 'Jenis Mata Kuliah',
					'rules' => 'required|max_length[2]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => 'Maksimal Kode %s 2 Karakter',
					)
				),
				array(
					'field' => 'kelompokMK',
					'label' => 'Kelompok Mata Kuliah',
					'rules' => 'max_length[10]',
					'errors' => array(
						'max_length' => 'Maxsimal Id %s 10 Karakter',
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
					'id' =>$this->input->post('id'),
					'id_mk' => $this->input->post('id_mk'),
					'jurusan' => $this->input->post('jurusan'),
					'kodeMK' => $this->input->post('kodeMK'),
					'namaIndo' => $this->input->post('namaIndo'),
					'namaEng' => $this->input->post('namaEng'),
					'sksMK' => $this->input->post('sksMK'),
					'sksTM' => $this->input->post('sksTM'),
					'sksP' => $this->input->post('sksP'),
					'sksPL' => $this->input->post('sksPL'),
					'sksS' => $this->input->post('sksS'),
					'metode_belajar' => $this->input->post('metode_belajar'),
					'jenisMK' => $this->input->post('jenisMK'),
					'kelompokMK' => $this->input->post('kelompokMK'),
					'tgl_mulai' => $this->input->post('tgl_mulai'),
					'tgl_akhir' => $this->input->post('tgl_akhir'),
					'notactive' => $this->input->post('notactive'),
					'user' => $this->session->userdata('uname'),
					'tglnow' => date('Y-m-d H:i:s')
				);

				$dataClean = $this->security->xss_clean($dataSukses);

				if ( ($this->input->post('act') == 'add') ) {

					$this->kirimPDDIKTI($dataClean,'insert');
					//$this->setAdd($dataClean);

				} else {

					$this->kirimPDDIKTI($dataClean,'update');

				}
				
			}

		}

	}

	private function delete_spaces($data) {

		return ( ! preg_match("~\s~", $data)) ? TRUE : FALSE;

	}

	private function setAdd($data) {

		$arrayJurusan = explode('-', $data['jurusan']);
		$idMK = $data['kodeMK'].$arrayJurusan[0];
		$dataDB = $this->matakuliah_jns_model->checkData($idMK);

		if ( empty($dataDB) ) {

			$this->matakuliah_jns_model->insertData($data,$idMK);

			$dataSukses = array(
				'ket' => 'sukses',
				'pesan' => 'Matakuliah Berhasil Disimpan'
			);

			echo json_encode($dataSukses);

		} else {

			$dataError = array(
				'ket' => 'error',
				'pesan' => 'Kode Mata Kuliah yang Anda Masukan Sudah Ada'
			);

			echo json_encode($dataError);

		}

	}

	public function setDeleteData() {

		$this->matakuliah_jns_model->deleteData($this->input->post('id'));

		$dataSukses = array(
			'ket' => 'sukses',
			'pesan' => 'Mata Kuliah Berhasil Dihapus'
		);

		echo json_encode($dataSukses);

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

	private function setKodeKelompokMK($kelompokMK) {

		if ( $kelompokMK == 'MPK' ) {

			return $kode = 'A';

		} elseif ( $kelompokMK == 'MKK' ) {

			return $kode = 'B';

		} elseif ( $kelompokMK == 'MKB' ) {

			return $kode = 'C';

		} elseif ( $kelompokMK == 'MPB' ) {

			return $kode = 'D';

		} elseif ( $kelompokMK == 'MBB' ) {

			return $kode = 'E';

		} elseif ( $kelompokMK == 'MKU' or $kelompokMK == 'MKDU' ) {

			return $kode = 'F';
			
		} elseif ( $kelompokMK == 'MKDK' ) {

			return $kode = 'G';

		} elseif ( $kelompokMK == 'MKK' ) {
			
			return $kode = 'H';

		} else {

			return $kode = '';

		}

	}

	private function kirimPDDIKTI($data,$act) {

		$prodi = explode('-', $data['jurusan']);
		$id_prodi = $this->matakuliah_jns_model->getId_sms($prodi[0]);
		$kodeKelompokMK = $this->setKodeKelompokMK($data['kelompokMK']);

		if ( empty($data['tgl_mulai']) ) {

			$date_mulai = '';

		} else {

			$date_mulai = date('Y-m-d', strtotime($data['tgl_mulai']));

		}

		if ( empty($data['tgl_akhir']) ) {

			$date_akhir = '';

		} else {

			$date_akhir = date('Y-m-d', strtotime($data['tgl_akhir']));

		}

		$dataToken = array (
			'act' => 'GetToken',
			'username' => '001028e1',
			'password' => 'az18^^'
		);

		$tokenFeeder = $this->runWS($dataToken);
		$obj = json_decode($tokenFeeder);
		$token = $obj->data->token;

		if ( $act == 'insert' ) {

			$dataMK = array();
			$dataMK['id_prodi'] = $id_prodi->id_sms;
			$dataMK['kode_mata_kuliah'] = $data['kodeMK'];
			$dataMK['nama_mata_kuliah'] = $data['namaIndo'];
			$dataMK['sks_mata_kuliah'] = $data['sksMK'];
			$dataMK['sks_tatap_muka'] = $data['sksTM'];
			$dataMK['sks_praktek'] = $data['sksP'];
			$dataMK['sks_praktek_lapangan'] = $data['sksPL'];
			$dataMK['sks_simulasi'] = $data['sksS'];
			$dataMK['metode_kuliah'] = $data['metode_belajar'];
			$dataMK['id_jenis_mata_kuliah'] = $data['jenisMK'] ;
			$dataMK['id_kelompok_mata_kuliah'] = $kodeKelompokMK;
			$dataMK['tanggal_mulai_efektif'] = $date_mulai;
			$dataMK['tanggal_akhir_efektif'] = $date_akhir;

			$dataInsertMK = array(
				'act' => 'InsertMataKuliah',
				'token' => $token,
				'record' => $dataMK
			);

			$dataMKFeeder = $this->runWS($dataInsertMK);
		 	$objMK = json_decode($dataMKFeeder);
		 	$error_codeMK = $objMK->{'error_code'};
		 	$error_descMK = $objMK->{'error_desc'};

		 	if ($error_codeMK == 0) {

		 		$id_matkul = $objMK->{'data'}->{'id_matkul'};

		 		$data['id_matkul'] = $id_matkul;
		 		
		 		$this->setAdd($data);

		 	} else {

		 		$dataError = array(
					'ket' => 'error',
					'pesan' => $error_codeMK."-".$error_descMK
				);

				echo json_encode($dataError);

		 	}

		} elseif ( $act == 'update' ) {

			if ( empty($data['id_mk']) ) {

				$dataMK = array();
				$dataMK['id_prodi'] = $id_prodi->id_sms;
				$dataMK['kode_mata_kuliah'] = $data['kodeMK'];
				$dataMK['nama_mata_kuliah'] = $data['namaIndo'];
				$dataMK['sks_mata_kuliah'] = $data['sksMK'];
				$dataMK['sks_tatap_muka'] = $data['sksTM'];
				$dataMK['sks_praktek'] = $data['sksP'];
				$dataMK['sks_praktek_lapangan'] = $data['sksPL'];
				$dataMK['sks_simulasi'] = $data['sksS'];
				$dataMK['metode_kuliah'] = $data['metode_belajar'];
				$dataMK['id_jenis_mata_kuliah'] = $data['jenisMK'] ;
				$dataMK['id_kelompok_mata_kuliah'] = $kodeKelompokMK;
				$dataMK['tanggal_mulai_efektif'] = $date_mulai;
				$dataMK['tanggal_akhir_efektif'] = $date_akhir;

				$dataInsertMK = array(
					'act' => 'InsertMataKuliah',
					'token' => $token,
					'record' => $dataMK
				);

				$dataMKFeeder = $this->runWS($dataInsertMK);
			 	$objMK = json_decode($dataMKFeeder);
			 	$error_codeMK = $objMK->{'error_code'};
			 	$error_descMK = $objMK->{'error_desc'};

			 	if ($error_codeMK == 0) {

			 		$id_matkul = $objMK->{'data'}->{'id_matkul'};

			 		$data['id_mk'] = $id_matkul;
			 		$data['feeder'] = 1;
			 		
			 		$simpan = $this->matakuliah_jns_model->updateData($data);

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
						'pesan' => $error_codeMK."-".$error_descMK
					);

					echo json_encode($dataError);

			 	}

			} else {

				$key = array(
					'id_matkul' => $data['id_mk']
				);

				$dataMK = array();
				$dataMK['kode_mata_kuliah'] = $data['kodeMK'];
				$dataMK['nama_mata_kuliah'] = $data['namaIndo'];
				$dataMK['sks_mata_kuliah'] = $data['sksMK'];
				$dataMK['sks_tatap_muka'] = $data['sksTM'];
				$dataMK['sks_praktek'] = $data['sksP'];
				$dataMK['sks_praktek_lapangan'] = $data['sksPL'];
				$dataMK['sks_simulasi'] = $data['sksS'];
				$dataMK['metode_kuliah'] = $data['metode_belajar'];
				$dataMK['id_jenis_mata_kuliah'] = $data['jenisMK'] ;
				$dataMK['id_kelompok_mata_kuliah'] = $kodeKelompokMK;
				$dataMK['tanggal_mulai_efektif'] = $date_mulai;
				$dataMK['tanggal_akhir_efektif'] = $date_akhir;

				//print_r($key);
				//print_r($dataMK);

				$dataUpdateMK = array(
					'act' => 'UpdateMataKuliah',
					'token' => $token,
					'key' => $key,
					'record' => $dataMK
				);

				$dataMKFeeder = $this->runWS($dataUpdateMK);
			 	$objMK = json_decode($dataMKFeeder);
			 	$error_codeMK = $objMK->{'error_code'};
			 	$error_descMK = $objMK->{'error_desc'};

			 	if ($error_codeMK == 0) {
			 		
			 		$simpan = $this->matakuliah_jns_model->updateData2($data);

			 		if ( $simpan ) {

			 			$dataSukses = array(
							'ket' => 'sukses',
							'pesan' => 'Berhasil Terupdate Ke PDDIKTI dan Tersimpan'
						);

						echo json_encode($dataSukses);

			 		} else {

			 			$dataError = array(
							'ket' => 'error',
							'pesan' => 'Berhasil Terupdate Ke PDDIKTI, Gagal Tersimpan di Server Siakad'
						);

						echo json_encode($dataError);

			 		}

			 	} else {

			 		$dataError = array(
						'ket' => 'error',
						'pesan' => $error_codeMK."-".$error_descMK
					);

					echo json_encode($dataError);

			 	}

			}

		} elseif ( $act == 'delete' ) {

			# code...

		}

	}

}