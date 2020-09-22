<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spp2 extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->helper('security');
	    $this->load->model('additional_model');
		date_default_timezone_set("Asia/Makassar");
	}

	public function index() {

		$data['tab'] = $this->app->all_val('groupmodul')->result();
		$this->load->view('dashbord',$data);
		
	}

	public function mencariDataMhsw($nim) {

		$data = $this->additional_model->getDataMhsw($nim);

		echo json_encode($data);

	}

	public function validasiDataSPP2() {

		$config = array(
			array(
				'field' => 'nim',
				'label' => 'Stambuk Mahasiswa',
				'rules' => 'required|max_length[10]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 10 Karakter',
				)
			),
			array(
				'field' => 'nama',
				'label' => 'Nama Mahasiswa',
				'rules' => 'required|max_length[150]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 150 Karakter',
				)
			),
			array(
				'field' => 'sex',
				'label' => 'Jenis Kelamin Mahasiswa',
				'rules' => 'required|max_length[1]|trim',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 1 Karakter',
				)
			),
			array(
				'field' => 'tahun',
				'label' => 'Tahun Semester Akademik',
				'rules' => 'required|max_length[5]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 150 Karakter',
					'numeric' => '%s Harus Angka',
				)
			),
			array(
				'field' => 'jurusan',
				'label' => 'Jurusan',
				'rules' => 'required|max_length[150]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 150 Karakter',
				)
			),
			array(
				'field' => 'bayar',
				'label' => 'Tipe Pembayaran',
				'rules' => 'required|max_length[1]|numeric',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 1 Angka',
					'numeric' => '%s Harus Angka',
				)
			),
			array(
				'field' => 'kodeStatus',
				'label' => 'Status Mahasiswa',
				'rules' => 'required|max_length[1]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 1 Huruf',
				)
			),
			array(
				'field' => 'ket',
				'label' => 'Keterangan',
				'rules' => 'max_length[150]',
				'errors' => array(
					'max_length' => '%s Maxsimal 150 Karakter',
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

			$check = $this->additional_model->getCheckMhswSPP2($this->input->post('nim'),$this->input->post('tahun'));

			if ( $check == TRUE ) {

				$dataError = array(
					'ket' => 'error',
					'pesan' => 'Data Mahasiswa dengan No Stambuk '.$this->input->post('nim').' dan Tahun Akademik '.$this->input->post('tahun').' Sudah Ada'
				);

				echo json_encode($dataError);

			} else {

				$checkPeriodeAktif = $this->additional_model->getCheckPeriodeAktifSPP2();

				$kodeJurusan = substr($this->input->post('nim'), 0, 4);
				$kodeFakultas = substr($this->input->post('nim'), 0, 1);

				if ( $checkPeriodeAktif->periode_aktif == $this->input->post('tahun') ) {
					$status = 1;
				} else {
					$status = 0;
				}

				$dataSPP2 = array(
					'status' => $status,
					'nim' => $this->input->post('nim'),
					'sex' => $this->input->post('sex'),
					'tahun' => $this->input->post('tahun'),
					'kodeFakultas' => $kodeFakultas,
					'kodeJurusan' => $kodeJurusan,
					'bayar' => $this->input->post('bayar'),
					'kodeStatus' => $this->input->post('kodeStatus'),
					'keterangan' => $this->input->post('ket'),
					'rp' => $this->input->post('rp'),
					'tgl' => $this->rubahFormatTanggal($this->input->post('tgl')).' '.$this->input->post('jam')
				);

				$dataCleanSPP2 = $this->security->xss_clean($dataSPP2);

				$sukses = $this->additional_model->insertDataSPP2($dataCleanSPP2);

				if ( $sukses == FALSE ) {

					$dataError = array(
						'ket' => 'error',
						'pesan' => "Data Tidak Tersimpan"
					);

					echo json_encode($dataError);

				} else {

					$dataSukses = array(
						'ket' => 'sukses',
						'pesan' => "Data Berhasil Simpan"
					);

					echo json_encode($dataSukses);

				}

			}
			
		}

	}

	private function rubahFormatTanggal($date) {

		if ( $date == '' ) {
			$format = 0000-00-00;
		} else {

			$data = str_replace("/", "-", $date);
			$tgl = explode("-", $data);
			
			$format = $tgl[2]."-".$tgl[1]."-".$tgl[0];
		}

		return $format;

	}
	
	/*public function tes() {
		$this->load->model('sync_spp');
		echo $this->sync_spp->tes();
	}*/
	
}