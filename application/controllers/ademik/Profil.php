<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

class Profil extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->helper('security');
	    $this->load->model('profil_model');
	}


	public function index() {

		$userLogin = $this->session->userdata('unip');
		$level = $this->session->userdata('ulevel');
		$user = $this->getUser($level); // pendeklarasian tabel
		$kodeJur = $this->session->userdata("kdj");
		$kodeFakultas = substr($kodeJur,0,1);
		
		if ( $level == 4 ) {	
			$data['level'] = $level;
			$data['dataProfil'] = $this->profil_model->getDataTabelJoinMhsw($user,$userLogin);
			$data['dataAgama'] = $this->profil_model->getDataAgama();
			$data['dataNegara'] = $this->profil_model->getDataNegara();
			$data['dataAlat'] = $this->profil_model->getDataAlat();
			$data['dataTinggal'] =$this->profil_model->getDataTinggal();
			$data['dataDosen'] = $this->profil_model->getDataDosen('kodeFakultas',$kodeFakultas);

			$this->load->view('temp/head');
			$this->load->view('ademik/profil',$data);
			$this->load->view('temp/footers');

		} elseif ( $level == 5 || $level == 7 || $level == 3  ) {
			
			$data['level'] = $level;
			$data['dataProfil'] = $this->profil_model->getDataTabelJoinAdm($user,$userLogin);
			$data['dataAgama'] = $this->profil_model->getDataAgama();

			$this->load->view('temp/head');
			$this->load->view('ademik/profil',$data);
			$this->load->view('temp/footers');

		} elseif ( $level == 1 || $level == 6 ) {
			
			$data['level'] = $level;
			$data['dataProfil'] = $this->profil_model->getDataTabel($user,$userLogin);

			$this->load->view('temp/head');
			$this->load->view('ademik/profil',$data);
			$this->load->view('temp/footers');

		}

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

	private function rubahFormatTanggal($date) {

		$data = str_replace("/", "-", $date);
		$tgl = explode("-", $data);

		return $tgl[2]."-".$tgl[1]."-".$tgl[0];

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

	public function validasiDataMhsw() {

		$config = array(
			array(
				'field' => 'id',
				'label' => 'ID Mahasiswa',
				'rules' => 'required|max_length[10]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 10 Karakter',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'nama',
				'label' => 'Nama',
				'rules' => 'required|max_length[100]|trim',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 100 Karakter',
				)
			),
			array(
				'field' => 'tmpLahir',
				'label' => 'Tempat Lahir',
				'rules' => 'required|max_length[32]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 32 Karakter',
				)
			),
			array(
				'field' => 'sex',
				'label' => 'Jenis Kelamin',
				'rules' => 'required|max_length[1]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 1 Karakter',
				)
			),
			array(
				'field' => 'agama',
				'label' => 'Agama',
				'rules' => 'required|max_length[2]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 2 Karakter',
				)
			),
			array(
				'field' => 'ibu',
				'label' => 'Nama Ibu',
				'rules' => 'required|max_length[100]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 100 Karakter',
				)
			),
			array(
				'field' => 'nik',
				'label' => 'NIK',
				'rules' => 'required|max_length[16]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 16 Karakter',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'nisn',
				'label' => 'NISN',
				'rules' => 'max_length[10]',
				'errors' => array(
					'max_length' => '%s Maksimal 10 Karakter',
				)
			),
			array(
				'field' => 'npwp',
				'label' => 'NPWP',
				'rules' => 'max_length[15]',
				'errors' => array(
					'max_length' => '%s Maksimal 15 Karakter',
				)
			),
			array(
				'field' => 'alamat',
				'label' => 'Alamat',
				'rules' => 'required|max_length[80]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 80 Karakter',				
				)
			),
			array(
				'field' => 'negara',
				'label' => 'Kewarganegaraan',
				'rules' => 'required|max_length[2]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 2 Karakter',
				)
			),
			array(
				'field' => 'dusun',
				'label' => 'Dusun',
				'rules' => 'max_length[60]',
				'errors' => array(
					'max_length' => '%s Maxsimal 60 Karakter',
				)
			),
			array(
				'field' => 'rt',
				'label' => 'RT',
				'rules' => 'max_length[3]',
				'errors' => array(
					'max_length' => '%s Maxsimal 3 Angka',
				)
			),
			array(
				'field' => 'rw',
				'label' => 'RW',
				'rules' => 'max_length[3]',
				'errors' => array(
					'max_length' => '%s Maxsimal 3 Angka',
				)
			),
			array(
				'field' => 'kodepos',
				'label' => 'Kodepos',
				'rules' => 'max_length[6]',
				'errors' => array(
					'max_length' => '%s Maxsimal 6 Angka',
				)
			),
			array(
				'field' => 'kelurahan',
				'label' => 'Kelurahan',
				'rules' => 'required|max_length[60]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 60 Karakter',
				)
			),
			array(
				'field' => 'kecamatan',
				'label' => 'Kecamatan',
				'rules' => 'required|max_length[8]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 8 Karakter',
				)
			),
			array(
				'field' => 'jnsTinggal',
				'label' => 'Jenis Tinggal',
				'rules' => 'max_length[2]|numeric',
				'errors' => array(
					'max_length' => '%s Maxsimal 2 Angka',
					'numeric' => '%s Tidak Boleh diisi dengan angka',
				)
			),
			array(
				'field' => 'alatTrans',
				'label' => 'Alat Transportasi',
				'rules' => 'max_length[2]|numeric',
				'errors' => array(
					'max_length' => '%s Maxsimal 2 Angka',
					'numeric' => '%s Tidak Boleh diisi dengan angka',
				)
			),
			array(
				'field' => 'telepon',
				'label' => 'Telepon',
				'rules' => 'max_length[12]|numeric',
				'errors' => array(
					'max_length' => '%s Maxsimal 12 Angka',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'hp',
				'label' => 'HP',
				'rules' => 'required|max_length[12]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 12 Angka',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'valid_email',
				'errors' => array(
					'valid_email' => '%s Anda Tidak Valid',
				)
			),
			array(
				'field' => 'kps',
				'label' => 'KPS',
				'rules' => 'required|max_length[1]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 1 Angka',
					'numeric' => '%s Tidak Boleh diisi dengan angka',
				)
			),
			array(
				'field' => 'noKPS',
				'label' => 'Nomor KPS',
				'rules' => 'max_length[80]',
				'errors' => array(
					'max_length' => '%s Maxsimal 100 Karakter',
				)
			),
			array(
				'field' => 'awalMasuk',
				'label' => 'Periode Awal Masuk',
				'rules' => 'required|exact_length[5]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'exact_length' => '%s Harus 5 Angka',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'bayarSPP',
				'label' => 'Tipe Pembayaran',
				'rules' => 'required|max_length[50]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 50 Karakter',
				)
			),
			array(
				'field' => 'ketSPP',
				'label' => 'Keterangan Pembayaran SPP',
				'rules' => 'max_length[50]',
				'errors' => array(
					'max_length' => '%s Tidak Melebihi 50 Karakter',
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
				'pd' => $this->input->post('pd'),
				'regpd' => $this->input->post('regpd'),
				'nama' => $this->input->post('nama'),
				'fakultas' => $this->input->post('fakultas'),
				'tmpLahir' => $this->input->post('tmpLahir'),
				'tglLahir' => $this->rubahFormatTanggal( $this->input->post('tglLahir') ),
				'sex' => $this->input->post('sex'),
				'agama' => $this->input->post('agama'),
				'ibu' => $this->input->post('ibu'),
				'nik' => $this->input->post('nik'),
				'nisn' => $this->input->post('nisn'),
				'npwp' => $this->input->post('npwp'),
				'alamat' => $this->input->post('alamat'),
				'negara' => $this->input->post('negara'),
				'dusun' => ucwords( strtolower( $this->input->post('dusun') ) ),
				'rt' => $this->input->post('rt'),
				'rw' => $this->input->post('rw'),
				'kodepos' => $this->input->post('kodepos'),
				'kelurahan' => ucwords( strtolower( $this->input->post('kelurahan') ) ),
				'kecamatan' => $this->input->post('kecamatan'),
				'jnsTinggal' => $this->input->post('jnsTinggal'),
				'alatTrans' => $this->input->post('alatTrans'),
				'telepon' => $this->input->post('telepon'),
				'hp' => $this->input->post('hp'),
				'email' => strtolower($this->input->post('email')),
				'kps' => $this->input->post('kps'),
				'noKPS' => $this->input->post('noKPS'),
				'awalMasuk' => $this->input->post('awalMasuk'),
				'bayarSPP' => $this->input->post('bayarSPP'),
				'ketSPP' => $this->input->post('ketSPP')
			);

			$dataClean = $this->security->xss_clean($dataSukses);

			if ( $this->input->post('fakultas') == 'N' AND $this->session->userdata('ulevel') == 4 ) {

				$simpan = $this->profil_model->updateData($dataClean,'dataMhsw','_v2_mhsw');

				if ( $simpan == TRUE ) {

					$dataSukses = array(
						'ket' => 'sukses',
						'pesan' => "Data Berhasil diupdate, Silakan Melapor Ke Admin Fakultas Untuk Pengiriman Data Ke DIKTI"
					);

					echo json_encode($dataSukses);

				} else {

					$dataError = array(
						'ket' => 'error',
						'pesan' => 'Data Gagal Terupdate Silakan Melapor Ke Admin'
					);

					echo json_encode($dataError);

				}

			} else {

				$dataFeeder = $this->kirimDataMhswFeeder($dataClean);

				if ( $dataFeeder['error_code'] == 0 ) {

					$this->profil_model->updateData($dataClean,'dataMhsw','_v2_mhsw');

					if ( $this->session->userdata('ulevel') == 4 ) {

						$namaLengkap = ucwords($this->input->post('nama')); // tambahkan tanggal 08-08-2018
						$sex = $this->input->post('sex'); // tambahkan tanggal 08-08-2018
						$this->ubahprofil($namaLengkap, $sex); // tambahkan tanggal 08-08-2018

						$dataSukses = array(
							'ket' => 'sukses',
							'pesan' => "Data Berhasil diupdate dan Terkirim Ke Dikti"
						);

						echo json_encode($dataSukses);

					} else {

						$dataSukses = array(
							'ket' => 'sukses',
							'pesan' => "Data Berhasil diupdate dan Terkirim Ke Dikti"
						);

						echo json_encode($dataSukses);
						
					}

				} elseif ( $dataFeeder['error_code'] == 1 ) {
					
					$this->profil_model->updateData($dataClean,'dataMhsw','_v2_mhsw');

					if ( $this->session->userdata('ulevel') == 4 ) {

						$namaLengkap = ucwords($this->input->post('nama')); // tambahkan tanggal 08-08-2018
						$sex = $this->input->post('sex'); // tambahkan tanggal 08-08-2018
						$this->ubahprofil($namaLengkap, $sex); // tambahkan tanggal 08-08-2018

						$dataError = array(
							'ket' => 'error',
							'pesan' => $dataFeeder['error_code'].' '.$dataFeeder['error_desc'].', Silakan Melapor Ke Admin Feeder Fakultas'
						);

						echo json_encode($dataError);

					} else {

						$dataError = array(
							'ket' => 'error',
							'pesan' => $dataFeeder['error_code'].' '.$dataFeeder['error_desc']
						);

						echo json_encode($dataError);
						
					}

				} else {

					if ( $this->session->userdata('ulevel') == 4 ) {

						$dataError = array(
							'ket' => 'error',
							'pesan' => $dataFeeder['error_code'].' '.$dataFeeder['error_desc'].', Silakan Melapor Ke Admin Feeder Fakultas'
						);

						echo json_encode($dataError);

					} else {

						$dataError = array(
							'ket' => 'error',
							'pesan' => $dataFeeder['error_code'].' '.$dataFeeder['error_desc']
						);

						echo json_encode($dataError);
						
					}

				}

			}

		}

	}

	public function validasiDataOrtuMhsw() {

		$config = array(
			array(
				'field' => 'id',
				'label' => 'ID Mahasiswa',
				'rules' => 'required|max_length[10]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 10 Karakter',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'bapak',
				'label' => 'Nama Bapak',
				'rules' => 'required|max_length[100]|trim',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 100 Karakter',
				)
			),
			array(
				'field' => 'ibu',
				'label' => 'Nama Ibu',
				'rules' => 'required|max_length[100]|trim',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 100 Karakter',
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
				'bapak' => ucwords( strtolower( $this->input->post('bapak') ) ),
				'ibu' => ucwords($this->input->post('ibu'))
			);

			$dataClean = $this->security->xss_clean($dataSukses);

			$this->profil_model->updateData($dataClean,'dataOrtuMhsw','_v2_mhsw');

			$dataSukses = array(
				'ket' => 'sukses',
				'pesan' => "Data Berhasil diupdate"
			);

			echo json_encode($dataSukses);

		}

	}

	public function validasiDataAkademik() {

		$config = array(
			array(
				'field' => 'id',
				'label' => 'ID Mahasiswa',
				'rules' => 'required|max_length[10]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 10 Karakter',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'dosenWali',
				'label' => 'Nama Dosen Wali',
				'rules' => 'required|max_length[100]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 100 Karakter',
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
				'dosenWali' => $this->input->post('dosenWali')
			);

			$dataClean = $this->security->xss_clean($dataSukses);

			$this->profil_model->updateData($dataClean,'dataAkademik','_v2_mhsw');

			$dataSukses = array(
				'ket' => 'sukses',
				'pesan' => "Data Berhasil diupdate"
			);

			echo json_encode($dataSukses);

		}

	}

	public function validasiDataDosen() {

		$config = array(
			array(
				'field' => 'id',
				'label' => 'ID Dosen',
				'rules' => 'required|max_length[10]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 10 Karakter',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'nik',
				'label' => 'NIK',
				'rules' => 'required|max_length[20]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 20 Karakter',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'npwp',
				'label' => 'NPWP',
				'rules' => 'required|max_length[20]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 20 Karakter',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'namaAsli',
				'label' => 'Nama',
				'rules' => 'required|max_length[100]|trim',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 100 Karakter',
				)
			),
			array(
				'field' => 'gelarDpn',
				'label' => 'Gelar Depan',
				'rules' => 'max_length[20]|trim',
				'errors' => array(
					'max_length' => '%s Maksimal 20 Karakter',
				)
			),
			array(
				'field' => 'gelarBlk',
				'label' => 'Gelar Belakang',
				'rules' => 'max_length[20]|trim',
				'errors' => array(
					'max_length' => '%s Maksimal 20 Karakter',
				)
			),
			array(
				'field' => 'tmpLahir',
				'label' => 'Tempat Lahir',
				'rules' => 'required|max_length[150]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 150 Karakter',
				)
			),
			array(
				'field' => 'agama',
				'label' => 'Agama',
				'rules' => 'required|max_length[25]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 25 Karakter',
				)
			),
			array(
				'field' => 'rt',
				'label' => 'RT',
				'rules' => 'required|max_length[6]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 6 Angka',
				)
			),
			array(
				'field' => 'rw',
				'label' => 'RW',
				'rules' => 'required|max_length[6]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 6 Angka',
				)
			),
			array(
				'field' => 'kelurahan',
				'label' => 'Kelurahan',
				'rules' => 'required|max_length[150]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 150 Karakter',
				)
			),
			array(
				'field' => 'kecamatan',
				'label' => 'Kecamatan',
				'rules' => 'required|max_length[150]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 150 Angka',
				)
			),
			array(
				'field' => 'telepon',
				'label' => 'Telepon',
				'rules' => 'max_length[12]|numeric',
				'errors' => array(
					'max_length' => '%s Maxsimal 12 Angka',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'hp',
				'label' => 'HP',
				'rules' => 'required|max_length[12]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 12 Angka',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'valid_email',
				'errors' => array(
					'valid_email' => '%s Anda Tidak Valid',
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
				'nik' => $this->input->post('nik'),
				'npwp' => $this->input->post('npwp'),
				'namaAsli' => ucwords($this->input->post('namaAsli')),
				'gelarDpn' => $this->input->post('gelarDpn'),
				'gelarBlk' => $this->input->post('gelarBlk'),
				'tmpLahir' => ucwords($this->input->post('tmpLahir')),
				'tglLahir' => $this->rubahFormatTanggal($this->input->post('tglLahir')),
				'agama' => $this->input->post('agama'),
				'alamat' => ucwords($this->input->post('alamat')),
				'rt' => $this->input->post('rt'),
				'rw' => $this->input->post('rw'),
				'kelurahan' => ucwords($this->input->post('kelurahan')),
				'kecamatan' => ucwords($this->input->post('kecamatan')),
				'telepon' => $this->input->post('telepon'),
				'hp' => $this->input->post('hp'),
				'email' => strtolower($this->input->post('email')),
				'sex' => $this->input->post('sex')
			);

			$dataClean = $this->security->xss_clean($dataSukses);

			$this->profil_model->updateData($dataClean,'dataDosen','_v2_dosen');

			$namaLengkap = $this->input->post('gelarDpn')." ".ucwords($this->input->post('namaAsli')). " ".$this->input->post('gelarBlk'); // tambahkan tanggal 08-08-2018
			$sex = $this->input->post('sex'); // tambahkan tanggal 08-08-2018
			$this->ubahprofil($namaLengkap, $sex); // tambahkan tanggal 08-08-2018

			$dataSukses = array(
				'ket' => 'sukses',
				'pesan' => "Data Berhasil diupdate"
			);

			echo json_encode($dataSukses);

		}

	}

	public function validasiDataDosenPegawai() {

		$config = array(
			array(
				'field' => 'id',
				'label' => 'ID Dosen',
				'rules' => 'required|max_length[10]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 10 Karakter',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'nip',
				'label' => 'NIP',
				'rules' => 'required|max_length[20]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 20 Karakter',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			/*array(
				'field' => 'nidn',
				'label' => 'NIDN/NUP/NIDK',
				'rules' => 'required|max_length[20]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 20 Karakter',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),*/
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
				'nip' => $this->input->post('nip'),
				'nidn' => $this->input->post('nidn')
			);

			$dataClean = $this->security->xss_clean($dataSukses);

			$this->profil_model->updateData($dataClean,'dataDosenPegawai','_v2_dosen');

			$dataSukses = array(
				'ket' => 'sukses',
				'pesan' => "Data Berhasil diupdate"
			);

			echo json_encode($dataSukses);

		}

	}

	public function validasiDataOrtuDosen() {

		$config = array(
			array(
				'field' => 'id',
				'label' => 'ID Dosen',
				'rules' => 'required|max_length[10]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 10 Karakter',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'bapak',
				'label' => 'Nama Bapak',
				'rules' => 'required|max_length[100]|trim',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 100 Karakter',
				)
			),
			array(
				'field' => 'ibu',
				'label' => 'Nama Ibu',
				'rules' => 'required|max_length[100]|trim',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 100 Karakter',
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
				'bapak' => ucwords($this->input->post('bapak')),
				'ibu' => ucwords($this->input->post('ibu'))
			);

			$dataClean = $this->security->xss_clean($dataSukses);

			$this->profil_model->updateData($dataClean,'dataOrtuDosen','_v2_dosen');

			$dataSukses = array(
				'ket' => 'sukses',
				'pesan' => "Data Berhasil diupdate"
			);

			echo json_encode($dataSukses);

		}

	}

	public function validasiDataAdmJurusan() {

		$config = array(
			array(
				'field' => 'id',
				'label' => 'ID Admin',
				'rules' => 'required|max_length[10]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 10 Karakter',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'nama',
				'label' => 'Nama',
				'rules' => 'required|max_length[100]|trim',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 100 Karakter',
				)
			),
			array(
				'field' => 'tmpLahir',
				'label' => 'Tempat Lahir',
				'rules' => 'required|max_length[150]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 150 Karakter',
				)
			),
			array(
				'field' => 'agama',
				'label' => 'Agama',
				'rules' => 'required|max_length[25]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 25 Karakter',
				)
			),
			array(
				'field' => 'telepon',
				'label' => 'Telepon',
				'rules' => 'max_length[12]|numeric',
				'errors' => array(
					'max_length' => '%s Maxsimal 12 Angka',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'hp',
				'label' => 'HP',
				'rules' => 'required|max_length[12]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 12 Angka',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'valid_email',
				'errors' => array(
					'valid_email' => '%s Anda Tidak Valid',
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
				'nama' => ucwords($this->input->post('nama')),
				'tmpLahir' => ucwords($this->input->post('tmpLahir')),
				'tglLahir' => $this->rubahFormatTanggal($this->input->post('tglLahir')),
				'agama' => $this->input->post('agama'),
				'alamat' => ucwords($this->input->post('alamat')),
				'telepon' => $this->input->post('telepon'),
				'hp' => $this->input->post('hp'),
				'email' => strtolower($this->input->post('email')),
				'sex' => $this->input->post('sex')
			);

			$dataClean = $this->security->xss_clean($dataSukses);

			$this->profil_model->updateData($dataClean,'dataAdmJurusan','_v2_adm_jur');

			$namaLengkap = ucwords($this->input->post('nama')); // tambahkan tanggal 08-08-2018
			$sex = $this->input->post('sex'); // tambahkan tanggal 08-08-2018
			$this->ubahprofil($namaLengkap, $sex); // tambahkan tanggal 08-08-2018

			$dataSukses = array(
				'ket' => 'sukses',
				'pesan' => "Data Berhasil diupdate"
			);

			echo json_encode($dataSukses);

		}

	}

	public function validasiDataAdmFakultas() {

		$config = array(
			array(
				'field' => 'id',
				'label' => 'ID Admin',
				'rules' => 'required|max_length[10]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 10 Karakter',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'nama',
				'label' => 'Nama',
				'rules' => 'required|max_length[100]|trim',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 100 Karakter',
				)
			),
			array(
				'field' => 'tmpLahir',
				'label' => 'Tempat Lahir',
				'rules' => 'required|max_length[150]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 150 Karakter',
				)
			),
			array(
				'field' => 'agama',
				'label' => 'Agama',
				'rules' => 'required|max_length[25]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 25 Karakter',
				)
			),
			array(
				'field' => 'telepon',
				'label' => 'Telepon',
				'rules' => 'max_length[12]|numeric',
				'errors' => array(
					'max_length' => '%s Maxsimal 12 Angka',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'hp',
				'label' => 'HP',
				'rules' => 'required|max_length[12]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 12 Angka',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'valid_email',
				'errors' => array(
					'valid_email' => '%s Anda Tidak Valid',
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
				'nama' => ucwords($this->input->post('nama')),
				'tmpLahir' => ucwords($this->input->post('tmpLahir')),
				'tglLahir' => $this->rubahFormatTanggal($this->input->post('tglLahir')),
				'agama' => $this->input->post('agama'),
				'alamat' => ucwords($this->input->post('alamat')),
				'telepon' => $this->input->post('telepon'),
				'hp' => $this->input->post('hp'),
				'email' => strtolower($this->input->post('email')),
				'sex' => $this->input->post('sex')
			);

			$dataClean = $this->security->xss_clean($dataSukses);

			$this->profil_model->updateData($dataClean,'dataAdmFakultas','_v2_adm_fak');

			$namaLengkap = ucwords($this->input->post('nama')); // tambahkan tanggal 08-08-2018
			$sex = $this->input->post('sex'); // tambahkan tanggal 08-08-2018
			$this->ubahprofil($namaLengkap, $sex); // tambahkan tanggal 08-08-2018

			$dataSukses = array(
				'ket' => 'sukses',
				'pesan' => "Data Berhasil diupdate"
			);

			echo json_encode($dataSukses);

		}

	}

	public function validasiDataAdmSuperuser() {

		$config = array(
			array(
				'field' => 'id',
				'label' => 'ID Admin',
				'rules' => 'required|max_length[10]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 10 Karakter',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'nama',
				'label' => 'Nama',
				'rules' => 'required|max_length[100]|trim',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 100 Karakter',
				)
			),
			array(
				'field' => 'telepon',
				'label' => 'Telepon',
				'rules' => 'max_length[12]|numeric',
				'errors' => array(
					'max_length' => '%s Maxsimal 12 Angka',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'valid_email',
				'errors' => array(
					'valid_email' => '%s Anda Tidak Valid',
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
				'nama' => ucwords($this->input->post('nama')),
				'telepon' => $this->input->post('telepon'),
				'email' => strtolower($this->input->post('email')),
				'sex' => $this->input->post('sex')
			);

			$dataClean = $this->security->xss_clean($dataSukses);

			$this->profil_model->updateData($dataClean,'dataAdmSuperuser','_v2_adm');

			$namaLengkap = ucwords($this->input->post('nama')); // tambahkan tanggal 08-08-2018
			$sex = $this->input->post('sex'); // tambahkan tanggal 08-08-2018
			$this->ubahprofil($namaLengkap, $sex); // tambahkan tanggal 08-08-2018

			$dataSukses = array(
				'ket' => 'sukses',
				'pesan' => "Data Berhasil diupdate"
			);

			echo json_encode($dataSukses);

		}

	}

	public function validasiDataPass() {

		$config = array(
			array(
				'field' => 'id',
				'label' => 'ID Mahasiswa',
				'rules' => 'required|max_length[10]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 10 Karakter',
					'numeric' => '%s Harus diisi dengan angka',
				)
			),
			array(
				'field' => 'passLama',
				'label' => 'Password Lama',
				'rules' => 'required|max_length[50]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 50 Karakter',
				)
			),
			array(
				'field' => 'passBaru',
				'label' => 'Password Baru',
				'rules' => 'required|max_length[50]|min_length[8]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 50 Karakter',
					'min_length' => '%s Minimal 8 Karakter',
				)
			),
			array(
				'field' => 'ulangPass',
				'label' => 'Pengulangan Password Baru',
				'rules' => 'required|max_length[50]|matches[passBaru]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 50 Karakter',
					'matches' => '%s Tidak Sesuai Dengan Password Baru',
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

			$level = $this->session->userdata('ulevel');
			$user = $this->getUser($level);
			$pass_lama = $this->profil_model->cekPass($this->input->post('id'),$this->input->post('passLama'),$user);

			if ( $pass_lama == 0 ) {

				$dataError = array(
					'ket' => 'error',
					'pesan' => 'Password Lama Anda Tidak Sesuai'
				);

				echo json_encode($dataError);

			} else {

				$dataSukses = array(
					'id' => $this->input->post('id'),
					'passBaru' => $this->input->post('passBaru')
				);

				$dataClean = $this->security->xss_clean($dataSukses);

				$savePass = $this->profil_model->updatePass($dataClean,$user);

				if ($savePass == TRUE) {
					$this->session->set_userdata('jumlahlogin','1');

					$dataSukses = array(
						'ket' => 'sukses',
						'pesan' => "Data Berhasil diupdate"
					);

					echo json_encode($dataSukses);
				} else {

					$dataError = array(
						'ket' => 'error',
						'pesan' => "Data Gagal Terupdate"
					);

					echo json_encode($dataError);
				}

			}

		}

	}

	private function ubahprofil($namaLengkap, $sex){
		$this->session->unset_userdata('uname');
		$this->session->unset_userdata('sex');

		$user=array(
			"uname"=>$namaLengkap,
			"sex"=>$sex,
		);
		$this->session->set_userdata($user);
	}

	/*public function validasiUploadFoto(){*/

		/*$status = "";
		$pesan = "";
		$filename = $this->input->post('user');

		if ( empty($this->input->post('foto')) ) {

			$status = "error";
			$pesan = "Anda Belum Memilih Foto, Silakan Pilih Fotonya";

		} else {

			$config['upload_path'] = base_url()'assets/images/mhsw';
		    $config['allowed_types'] = 'jpg|png';
		    $config['max_size'] = '1024';
		    $config['max_width']  = '1024';
		    $config['max_height']  = '768';
		    $config['file_name'] = $filename;

		    $this->load->library('upload', $config);

		    /*$status = "error";
			$pesan = $this->input->post('foto');*/

		/*}

		echo json_encode(array('ket' => $status, 'pesan' => $pesan));

	}*/

	private function kirimDataMhswFeeder($data) {

		$dataNIM = $this->profil_model->getDataNIM($data['id']);

		$dataToken = array (
			'act' => 'GetToken',
			'username' => '001028e1',
			'password' => 'az18^^'
		);

		$tokenFeeder = $this->runWS($dataToken);
		$obj = json_decode($tokenFeeder);
		$token = $obj->data->token;

		$dataMhsw = array();
		$dataMhsw['nama_mahasiswa'] = $data['nama'];
		$dataMhsw['tempat_lahir'] = $data['tmpLahir'];
		$dataMhsw['tanggal_lahir'] = $data['tglLahir'];
		$dataMhsw['jenis_kelamin'] = $data['sex'];
		$dataMhsw['id_agama'] = $data['agama'];
		$dataMhsw['nama_ibu_kandung'] = $data['ibu'];
		$dataMhsw['nik'] = $data['nik'];
		$dataMhsw['nisn'] = $data['nisn'];
		$dataMhsw['npwp'] = $data['npwp'];
		$dataMhsw['jalan'] = $data['alamat'];
		$dataMhsw['kewarganegaraan'] = $data['negara'];
		$dataMhsw['dusun'] = $data['dusun'];
		$dataMhsw['rt'] = $data['rt'];
		$dataMhsw['rw'] = $data['rw'];
		$dataMhsw['kode_pos'] = $data['kodepos'];
		$dataMhsw['kelurahan'] = $data['kelurahan'];
		$dataMhsw['id_wilayah'] = $data['kecamatan'];
		$dataMhsw['id_jenis_tinggal'] = $data['jnsTinggal'];
		$dataMhsw['id_alat_transportasi'] = $data['alatTrans'];
		$dataMhsw['handphone'] = $data['hp'];
		$dataMhsw['telepon'] = $data['telepon'];
		$dataMhsw['email'] = $data['email'];
		$dataMhsw['penerima_kps'] = $data['kps'];
		$dataMhsw['nomor_kps'] = $data['noKPS'];
		$dataMhsw['id_kebutuhan_khusus_ayah'] = 0;
		$dataMhsw['id_kebutuhan_khusus_ibu'] = 0;
		$dataMhsw['id_kebutuhan_khusus_mahasiswa'] = 0;

		$dataMhswUpdate = array();
		$dataMhswUpdate['jenis_kelamin'] = $data['sex'];
		$dataMhswUpdate['id_agama'] = $data['agama'];
		$dataMhswUpdate['nik'] = $data['nik'];
		$dataMhswUpdate['nisn'] = $data['nisn'];
		$dataMhswUpdate['npwp'] = $data['npwp'];
		$dataMhswUpdate['jalan'] = $data['alamat'];
		$dataMhswUpdate['kewarganegaraan'] = $data['negara'];
		$dataMhswUpdate['dusun'] = $data['dusun'];
		$dataMhswUpdate['rt'] = $data['rt'];
		$dataMhswUpdate['rw'] = $data['rw'];
		$dataMhswUpdate['kode_pos'] = $data['kodepos'];
		$dataMhswUpdate['kelurahan'] = $data['kelurahan'];
		$dataMhswUpdate['id_wilayah'] = $data['kecamatan'];
		$dataMhswUpdate['id_jenis_tinggal'] = $data['jnsTinggal'];
		$dataMhswUpdate['id_alat_transportasi'] = $data['alatTrans'];
		$dataMhswUpdate['handphone'] = $data['hp'];
		$dataMhswUpdate['telepon'] = $data['telepon'];
		$dataMhswUpdate['email'] = $data['email'];
		$dataMhswUpdate['penerima_kps'] = $data['kps'];
		$dataMhswUpdate['nomor_kps'] = $data['noKPS'];
		$dataMhswUpdate['id_kebutuhan_khusus_ayah'] = 0;
		$dataMhswUpdate['id_kebutuhan_khusus_ibu'] = 0;
		$dataMhswUpdate['id_kebutuhan_khusus_mahasiswa'] = 0;


		if ( empty($data['pd']) ) {

			$dataInsertMhsw = array(
				'act' => 'InsertBiodataMahasiswa',
				'token' => $token,
				'record' => $dataMhsw
			);

			$dataMhswFeeder = $this->runWS($dataInsertMhsw);
		 	$objMhs = json_decode($dataMhswFeeder);
		 	$error_codeMhs = $objMhs->{'error_code'};
		 	$error_descMhs = $objMhs->{'error_desc'};

		 	if ( $error_codeMhs == 0 ) {

		 		$id_mahasiswa = $objMhs->{'data'}->{'id_mahasiswa'};
		 		$simpan_pd = $this->profil_model->updateIdPD($data['id'],$id_mahasiswa,'_v2_mhsw');

		 		if ( $simpan_pd == TRUE ) {

			 		if ( $dataNIM->StatusAwal == 'B' ) {

			 			$dataNIMforFeeder = array();
						$dataNIMforFeeder['id_mahasiswa'] = $id_mahasiswa;
						$dataNIMforFeeder['nim'] = $dataNIM->NIM;
						$dataNIMforFeeder['id_jenis_daftar'] = 1;
						$dataNIMforFeeder['id_periode_masuk'] = $data['awalMasuk'];
						$dataNIMforFeeder['tanggal_daftar'] = $dataNIM->Tanggal;
						$dataNIMforFeeder['id_perguruan_tinggi'] = '8e5d195a-0035-41aa-afef-db715a37b8da';
						$dataNIMforFeeder['id_prodi'] = $dataNIM->id_sms;
						$dataNIMforFeeder['biaya_masuk'] = '250000';

			 			$dataInsertNIM = array(
			 				'act' => 'InsertRiwayatPendidikanMahasiswa',
			 				'token' => $token,
				 			'record'=> $dataNIMforFeeder

				 		);


				 		$dataNIMFeeder = $this->runWS($dataInsertNIM);
					 	$objNIM = json_decode($dataNIMFeeder);
					 	$error_codeNIM = $objNIM->{'error_code'};
					 	$error_descNIM = $objNIM->{'error_desc'};

					 	if ( $error_codeNIM == 0 ) {

					 		$reg_mahasiswa = $objNIM->{'data'}->{'id_registrasi_mahasiswa'};
					 		$this->profil_model->updateIdREG($data['id'],$reg_mahasiswa,'_v2_mhsw');

					 		$dataFeeder = array(
					 			'error_code' => $error_codeNIM
					 		);

					 		return $dataFeeder;

					 	} else {

					 		$dataFeeder = array(
					 			'error_code' => $error_codeNIM,
					 			'error_desc' => $error_descNIM
					 		);

					 		return $dataFeeder;

					 	}

			 		} else {

						$dataFeeder = array(
							'id_pd' => $id_mahasiswa,
					 		'error_code' => 1,
					 		'error_desc' => 'NIM Mahasiswa ini tidak dapat dikirim'
					 		);

					 	return $dataFeeder;			 		

				 	}

				} else {

					$dataFeeder = array(
						'id_pd' => $id_mahasiswa,
				 		'error_code' => 2,
				 		'error_desc' => 'Gagal Tersimpan'
				 		);

				 	return $dataFeeder;

				}

		 	} elseif ( $error_codeMhs == 200 ) {

			 	$siakad_pd = $this->profil_model->get_idpd_siakad($data['nama'],$data['sex'],$data['tmpLahir'],$data['tglLahir'],$data['ibu'],$data['agama']);

			 	if (empty($siakad_pd->id_pd)) {

			 		$dataFeeder = array(
			 			'error_code' => '3',
			 			'error_desc' => 'Data Sudah Ada Di Feeder, Tapi Tidak Ditemukan Disiakad'
			 		);

			 		return $dataFeeder;

			 	} else {

			 		$key = array(
						'id_mahasiswa' => $siakad_pd->id_pd 
					);

					$dataUpdateMhsw = array(
						'act' => 'UpdateBiodataMahasiswa',
						'token' => $token,
						'key' => $key,
						'record' => $dataMhswUpdate
					);

					//print_r($dataMhswUpdate);

					$dataMhswFeeder = $this->runWS($dataUpdateMhsw);
				 	$objMhs = json_decode($dataMhswFeeder);
				 	$error_codeMhs = $objMhs->{'error_code'};
				 	$error_descMhs = $objMhs->{'error_desc'};

				 	if ( $error_codeMhs == 0 ) {

					 	$id_mahasiswa = $siakad_pd->id_pd;
				 		$simpan_pd = $this->profil_model->updateIdPD($data['id'],$id_mahasiswa,'_v2_mhsw');

				 		if ( $simpan_pd == TRUE ) {

					 		if ( $dataNIM->StatusAwal == 'B' ) {

					 			$dataNIMforFeeder = array();
								$dataNIMforFeeder['id_mahasiswa'] = $id_mahasiswa;
								$dataNIMforFeeder['nim'] = $dataNIM->NIM;
								$dataNIMforFeeder['id_jenis_daftar'] = 1;
								$dataNIMforFeeder['id_periode_masuk'] = $data['awalMasuk'];
								$dataNIMforFeeder['tanggal_daftar'] = $dataNIM->Tanggal;
								$dataNIMforFeeder['id_perguruan_tinggi'] = '8e5d195a-0035-41aa-afef-db715a37b8da';
								$dataNIMforFeeder['id_prodi'] = $dataNIM->id_sms;
								$dataNIMforFeeder['biaya_masuk'] = '250000';

					 			$dataInsertNIM = array(
					 				'act' => 'InsertRiwayatPendidikanMahasiswa',
					 				'token' => $token,
						 			'record'=> $dataNIMforFeeder

						 		);


						 		$dataNIMFeeder = $this->runWS($dataInsertNIM);
							 	$objNIM = json_decode($dataNIMFeeder);
							 	$error_codeNIM = $objNIM->{'error_code'};
							 	$error_descNIM = $objNIM->{'error_desc'};

							 	if ( $error_codeNIM == 0 ) {

							 		$reg_mahasiswa = $objNIM->{'data'}->{'id_registrasi_mahasiswa'};
							 		$this->profil_model->updateIdREG($data['id'],$reg_mahasiswa,'_v2_mhsw');

							 		$dataFeeder = array(
							 			'error_code' => $error_codeNIM
							 		);

							 		return $dataFeeder;

							 	} else {

							 		$dataFeeder = array(
							 			'error_code' => $error_codeNIM,
							 			'error_desc' => $error_descNIM
							 		);

							 		return $dataFeeder;

							 	}

					 		} else {

								$dataFeeder = array(
									'id_pd' => $id_mahasiswa,
							 		'error_code' => 1,
							 		'error_desc' => 'NIM Mahasiswa ini tidak dapat dikirim'
							 		);

							 	return $dataFeeder;			 		

						 	}

						} else {

							$dataFeeder = array(
								'id_pd' => $id_mahasiswa,
						 		'error_code' => 2,
						 		'error_desc' => 'Gagal Tersimpan'
						 		);

						 	return $dataFeeder;

						}

					}
					
				}

		 	} else {

		 		$dataFeeder = array(
		 			'error_code' => $error_codeMhs,
		 			'error_desc' => $error_descMhs
		 		);

		 		return $dataFeeder;

		 	}

		} else {

			if ( empty($data['regpd'])) {

				$key = array(
					'id_mahasiswa' => $data['pd'] 
				);

				$dataUpdateMhsw = array(
					'act' => 'UpdateBiodataMahasiswa',
					'token' => $token,
					'key' => $key,
					'record' => $dataMhswUpdate
				);

				//print_r($dataUpdateMhsw);

				$dataMhswFeeder = $this->runWS($dataUpdateMhsw);
			 	$objMhs = json_decode($dataMhswFeeder);
			 	$error_codeMhs = $objMhs->{'error_code'};
			 	$error_descMhs = $objMhs->{'error_desc'};

			 	if ( $error_codeMhs == 0 ) {

			 		if ( $dataNIM->StatusAwal == 'B' ) {

						$dataNIMforFeeder = array();
						$dataNIMforFeeder['id_mahasiswa'] = $data['pd'];
						$dataNIMforFeeder['nim'] = $dataNIM->NIM;
						$dataNIMforFeeder['id_jenis_daftar'] = 1;
						$dataNIMforFeeder['id_periode_masuk'] = $data['awalMasuk'];
						$dataNIMforFeeder['tanggal_daftar'] = $dataNIM->Tanggal;
						$dataNIMforFeeder['id_perguruan_tinggi'] = '8e5d195a-0035-41aa-afef-db715a37b8da';
						$dataNIMforFeeder['id_prodi'] = $dataNIM->id_sms;
						$dataNIMforFeeder['biaya_masuk'] = '250000';

			 			$dataInsertNIM = array(
			 				'act' => 'InsertRiwayatPendidikanMahasiswa',
			 				'token' => $token,
				 			'record'=> $dataNIMforFeeder

				 		);

				 		//print_r($dataInsertNIM);

				 		$dataNIMFeeder = $this->runWS($dataInsertNIM);
					 	$objNIM = json_decode($dataNIMFeeder);
					 	$error_codeNIM = $objNIM->{'error_code'};
					 	$error_descNIM = $objNIM->{'error_desc'};

					 	if ( $error_codeNIM == 0 ) {

					 		$reg_mahasiswa = $objNIM->{'data'}->{'id_registrasi_mahasiswa'};
					 		$this->profil_model->updateIdREG($data['id'],$reg_mahasiswa,'_v2_mhsw');

					 		$dataFeeder = array(
					 			'error_code' => $error_codeNIM
					 		);

					 		return $dataFeeder;

					 	} else {

					 		$dataFeeder = array(
					 			'error_code' => $error_codeNIM,
					 			'error_desc' => $error_descNIM
					 		);

					 		return $dataFeeder;

					 	}

			 		} else {

						$dataFeeder = array(
					 		'error_code' => 1,
					 		'error_desc' => 'NIM Mahasiswa ini tidak dapat dikirim'
					 		);

					 	return $dataFeeder;			 		

				 	}

				} else {

					$dataFeeder = array(
				 		'error_code' => $error_codeMhs,
				 		'error_desc' => $error_descMhs
				 	);

				 	return $dataFeeder;

				}

			} else {

				$key = array(
					'id_mahasiswa' => $data['pd'] 
				);

				$dataUpdateMhsw = array(
					'act' => 'UpdateBiodataMahasiswa',
					'token' => $token,
					'key' => $key,
					'record' => $dataMhswUpdate
				);

				$dataMhswFeeder = $this->runWS($dataUpdateMhsw);
			 	$objMhs = json_decode($dataMhswFeeder);
			 	$error_codeMhs = $objMhs->{'error_code'};
			 	$error_descMhs = $objMhs->{'error_desc'};

			 	if ( $error_codeMhs == 0 ) {

			 		$dataFeeder = array(
			 			'error_code' => $error_codeMhs
			 		);

			 		return $dataFeeder;

			 	} else {

			 		$dataFeeder = array(
			 			'error_code' => $error_codeMhs,
			 			'error_desc' => $error_descMhs
			 		);

			 		return $dataFeeder;

			 	}


			}

		}

	}

}
