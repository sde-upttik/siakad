<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

class Batas_krs extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->helper('security');
	    $this->load->model('additional_model');
	}

	public function index() {

		$level = $this->session->userdata('ulevel');
		$dataKode = $this->userKode();

		$data['jurusan'] = $this->additional_model->get_dataSearchBatas($level,$dataKode);

		$this->load->view('dashbord',$data);

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

	private function rubahFormatTanggal($date) {

		$data = str_replace("/", "-", $date);
		$tgl = explode("-", $data);

		return $tgl[2]."-".$tgl[1]."-".$tgl[0];
		
	}

	private function tampilDataBatasKRS($kodeJurusan,$nmJurusan) {

		$namaJurusan = str_replace(',', '', $nmJurusan);
		$namaJurusan = str_replace('&', 'dan', $nmJurusan);

		$krs1 = $this->additional_model->getBatasKRSAktif($kodeJurusan,'N','REG');
		$krs2 = $this->additional_model->getBatasKRSAktif($kodeJurusan,'N','RESO');

		if ( $krs1 == TRUE && $krs2 == FALSE ) {

			$arrayDetail = array(
				'detail' => 1, /*jurusan hanya aktif program studi reguler*/
				'id' => $krs1->ID,
				'namaJurusan' => str_replace('%20', ' ', $namaJurusan),
				'tahun' => $krs1->Tahun,
				'kodeJurusan' => $kodeJurusan,
				'program' => $krs1->KodeProgram,
				'krsm' => $this->rubahFormatTanggal($krs1->krsm),
				'krss' => $this->rubahFormatTanggal($krs1->krss),
				'ukrsm' => $this->rubahFormatTanggal($krs1->ukrsm),
				'ukrss' => $this->rubahFormatTanggal($krs1->ukrss),

			);

			return $arrayDetail;

		} elseif ( $krs1 == FALSE && $krs2 == FALSE ) {

			$arrayDetail = array(
				'detail' => 0, /*jurusan tidak aktif program studi reguler dan nonreguler*/
				'id' => 0,
				'namaJurusan' => str_replace('%20', ' ', $namaJurusan),
				'kodeJurusan' => $kodeJurusan
			);

			return $arrayDetail;

		} elseif ( $krs1 == TRUE && $krs2 == TRUE ) {

			$arrayDetail = array(
				'detail' => 2, /*jurusan aktif program studi reguler dan nonreguler*/
				'id1' => $krs1->ID,
				'id2' => $krs2->ID,
				'namaJurusan' => str_replace('%20', ' ', $namaJurusan),
				'tahun1' => $krs1->Tahun,
				'tahun2' => $krs2->Tahun,
				'kodeJurusan' => $kodeJurusan,
				'program1' => $krs1->KodeProgram,
				'krsm1' => $this->rubahFormatTanggal($krs1->krsm),
				'krss1' => $this->rubahFormatTanggal($krs1->krss),
				'ukrsm1' => $this->rubahFormatTanggal($krs1->ukrsm),
				'ukrss1' => $this->rubahFormatTanggal($krs1->ukrss),
				'program2' => $krs2->KodeProgram,
				'krsm2' => $this->rubahFormatTanggal($krs2->krsm),
				'krss2' => $this->rubahFormatTanggal($krs2->krss),
				'ukrsm2' => $this->rubahFormatTanggal($krs2->ukrsm),
				'ukrss2' => $this->rubahFormatTanggal($krs2->ukrss)
			);

			return $arrayDetail;
		} elseif ( $krs1 == FALSE && $krs2 == TRUE ) {

			$arrayDetail = array(
				'detail' => 3, /*jurusan hanya aktif program studi nonreguler*/
				'id' => $krs2->ID,
				'namaJurusan' => str_replace('%20', ' ', $namaJurusan),
				'tahun' => $krs2->Tahun,
				'kodeJurusan' => $kodeJurusan,
				'program' => $krs2->KodeProgram,
				'krsm' => $this->rubahFormatTanggal($krs2->krsm),
				'krss' => $this->rubahFormatTanggal($krs2->krss),
				'ukrsm' => $this->rubahFormatTanggal($krs2->ukrsm),
				'ukrss' => $this->rubahFormatTanggal($krs2->ukrss)
			);

			return $arrayDetail;
		}

	}

	private function tampilEditDataBatasKRS($id) {

		$editKRS = $this->additional_model->getEditBatasKRS($id);

		$arrayDetail = array(
			'id' => $editKRS->ID,
			'tahun' => $editKRS->Tahun,
			'kodeJurusan' => $editKRS->KodeJurusan,
			'program' => $editKRS->KodeProgram,
			'krsm' => $this->rubahFormatTanggal($editKRS->krsm),
			'krss' => $this->rubahFormatTanggal($editKRS->krss),
			'ukrsm' => $this->rubahFormatTanggal($editKRS->ukrsm),
			'ukrss' => $this->rubahFormatTanggal($editKRS->ukrss),
			'user' => $this->session->userdata('uname'),
			'tglnow' => date('Y-m-d H:i:s'),
			/*'mulaiBayar1' => $this->rubahFormatTanggal($editKRS->MulaiBayar1),
			'akhirBayar1' => $this->rubahFormatTanggal($editKRS->AkhirBayar1),
			'mulaiBayar2' => $this->rubahFormatTanggal($editKRS->MulaiBayar2),
			'akhirBayar2' => $this->rubahFormatTanggal($editKRS->AkhirBayar2),
			'denda' => $editKRS->Denda,
			'hargaDenda' => $editKRS->HargaDenda,*/
			'notactive' => $editKRS->NotActive/*,
			'absen' => $this->rubahFormatTanggal($editKRS->Absen),
			'tugas' => $this->rubahFormatTanggal($editKRS->Tugas),
			'uts' => $this->rubahFormatTanggal($editKRS->UTS),
			'uas' => $this->rubahFormatTanggal($editKRS->UAS),
			'ss' => $this->rubahFormatTanggal($editKRS->SS)*/
		);

		return $arrayDetail;		

	}

	public function dataBatasKRS() {

		if ( empty($this->input->post('dataSearch')) ) {

			$level = $this->session->userdata('ulevel');
			$dataKode = $this->userKode();

			$data['jurusan'] = $this->additional_model->get_dataSearchBatas($level,$dataKode);
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

			$jurusan = explode("-", $this->input->post('dataSearch'));
			$kodeJurusan = $jurusan[0];
			$namaJurusan = str_replace(',', ' ', $jurusan[1]);
			$level = $this->session->userdata('ulevel');
			$dataKode = $this->userKode();

			$data['form'] = 'active';
			$data['jurusan'] = $this->additional_model->get_dataSearchBatas($level,$dataKode);
			$data['detail'] = $this->tampilDataBatasKRS($kodeJurusan,$namaJurusan);

			$this->load->view('dashbord',$data);

		}

	}

	public function formListBatasKRS($kodeJurusan,$nmJurusan,$limit) {

		$namaJurusan = str_replace(',',' ', $nmJurusan);

		$level = $this->session->userdata('ulevel');
		$dataKode = $this->userKode();

		$data['form'] = 'list';
		$data['jurusan'] = $this->additional_model->get_dataSearchBatas($level,$dataKode);
		$data['detail'] = $this->tampilDataBatasKRS($kodeJurusan,$namaJurusan);
		$data['detailTabel'] = $this->additional_model->getListBatasKRS($kodeJurusan,$limit);
		$data['tglnow'] = date('d-m-Y');

		$this->load->view('dashbord',$data);

	}

	public function formTambahBatasKRS($kodeJurusan,$nmJurusan) {

		$namaJurusan = str_replace(',', ' ', $nmJurusan);

		$level = $this->session->userdata('ulevel');
		$dataKode = $this->userKode();

		$data['form'] = 'tambah';
		$data['jurusan'] = $this->additional_model->get_dataSearchBatas($level,$dataKode);
		$data['detail'] = $this->tampilDataBatasKRS($kodeJurusan,$namaJurusan);
		$data['tglnow'] = date('d-m-Y'); 

		$this->load->view('dashbord',$data);

	}

	public function formEditBatasKRS($id,$kodeJurusan,$nmJurusan) {
		$namaJurusan = str_replace(',', ' ', $nmJurusan);

		$level = $this->session->userdata('ulevel');
		$dataKode = $this->userKode();

		$data['form'] = 'edit';
		$data['jurusan'] = $this->additional_model->get_dataSearchBatas($level,$dataKode);
		$data['detail'] = $this->tampilDataBatasKRS($kodeJurusan,$namaJurusan);
		$data['detailEdit'] = $this->tampilEditDataBatasKRS($id);
		$data['tglnow'] = date('d-m-Y');

		$this->load->view('dashbord',$data);

	}

	public function aktifBatasKRS() {

		$data = array(
			'NotActive' => 'N',
			'user_update' => $this->session->userdata('uname'),
			'tgl_update' => date('Y-m-d H:i:s')
		);

		$update = $this->additional_model->aktifkanBatasKRS($this->input->post('id'),$data);

		if ( $update == TRUE ) {

			$dataSukses = array(
				'ket' => 'sukses',
				'pesan' => 'Batas KRS Berhasil Diaktifkan'
			);

			echo json_encode($dataSukses);

		} else {

			$dataError = array(
				'ket' => 'error',
				'pesan' => 'Batas KRS Gagal Diaktifkan'
			);

			echo json_encode($dataError);

		}

	}

	public function tdkAktifBatasKRS() {

		$data = array(
			'NotActive' => 'Y',
			'user_update' => $this->session->userdata('uname'),
			'tgl_update' => date('Y-m-d H:i:s')
		);

		$update = $this->additional_model->aktifkanBatasKRS($this->input->post('id'),$data);

		if ( $update == TRUE ) {

			$dataSukses = array(
				'ket' => 'sukses',
				'pesan' => 'Batas KRS Berhasil Dinonaktifkan'
			);

			echo json_encode($dataSukses);

		} else {

			$dataError = array(
				'ket' => 'error',
				'pesan' => 'Batas KRS Gagal Dinonaktifkan'
			);

			echo json_encode($dataError);

		}

	}

	public function validasiForm() {

		$jurusan = explode('-', $this->input->post('jurusan'));
		$kodeJurusan = $jurusan[0];
		$namaJurusan = $jurusan[1];
		$tahun = $this->input->post('tahun');
		$program = $this->input->post('program');
		$namaProgram = ( $program == 'REG' ) ? 'Reguler' : 'Non Reguler';

		$checkKRSAktif = $this->additional_model->getCheckKRSAktif($kodeJurusan,$tahun,$program);

		if ( ($checkKRSAktif == TRUE) && ($this->input->post('act') == 'tambah') ) {

			$dataError = array(
				'ket' => 'error',
				'pesan' => 'Tahun Akademik '.$tahun.' dan Program Studi '.$namaProgram.' Sudah Pernah Digunakan'
			);

			echo json_encode($dataError);

		} else {

			$config = array(
				array(
					'field' => 'idAktifReg',
					'label' => 'ID Aktif Reguler',
					'rules' => 'max_length[10]|numeric',
					'errors' => array(
						'max_length' => '%s Maksimal 10 Angka',
						'numeric' => '%s Harus diisi Angka',
					)
				),
				array(
					'field' => 'idAktifReso',
					'label' => 'ID Aktif NonReguler',
					'rules' => 'max_length[10]|numeric',
					'errors' => array(
						'max_length' => '%s Maksimal 10 Angka',
						'numeric' => '%s Harus diisi Angka',
					)
				),
				array(
					'field' => 'jurusan',
					'label' => 'Jurusan',
					'rules' => 'required|max_length[250]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maksimal 250 Karakter',
					)
				),
				array(
					'field' => 'tahun',
					'label' => 'Tahun Akademik',
					'rules' => 'required|exact_length[5]|numeric',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'exact_length' => '%s Harus diisi dengan 5 Angka',
						'numeric' => '%s Harus diisi Angka',
					)
				),
				array(
					'field' => 'program',
					'label' => 'Program Studi',
					'rules' => 'required|max_length[25]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maxsimal 25 Karakter',
					)
				),
				array(
					'field' => 'isiKrs',
					'label' => 'Tanggal Pengisian KRS',
					'rules' => 'required|max_length[24]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maxsimal 24 Karakter',
					)
				),
				array(
					'field' => 'ubahKrs',
					'label' => 'Tanggal Perubahan KRS',
					'rules' => 'required|max_length[24]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maxsimal 24 Karakter',
					)
				),
				/*array(
					'field' => 'bayar1',
					'label' => 'Tanggal Pembayaran Pertama',
					'rules' => 'max_length[24]',
					'errors' => array(
						'max_length' => '%s Maxsimal 24 Angka',
					)
				),
				array(
					'field' => 'bayar2',
					'label' => 'Tanggal Pembayaran Kedua',
					'rules' => 'max_length[24]',
					'errors' => array(
						'max_length' => '%s Maxsimal 24 Angka',
					)
				),
				array(
					'field' => 'denda',
					'label' => 'Pengaktifan Denda',
					'rules' => 'required|max_length[1]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maxsimal 1 Angka',
					)
				),
				array(
					'field' => 'hrg',
					'label' => 'Harga Denda',
					'rules' => 'required|max_length[10]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maxsimal 10 Angka',
					)
				),
				array(
					'field' => 'absen',
					'label' => 'Tanggal Absen',
					'rules' => 'max_length[11]',
					'errors' => array(
						'max_length' => '%s Maxsimal 11 Karakter',
					)
				),
				array(
					'field' => 'tugas',
					'label' => 'Tanggal Tugas',
					'rules' => 'max_length[11]',
					'errors' => array(
						'max_length' => '%s Maxsimal 11 Karakter',
					)
				),
				array(
					'field' => 'uts',
					'label' => 'Tanggal UTS',
					'rules' => 'max_length[11]',
					'errors' => array(
						'max_length' => '%s Maxsimal 11 Karakter',
					)
				),
				array(
					'field' => 'uas',
					'label' => 'Tanggal UAS',
					'rules' => 'max_length[11]',
					'errors' => array(
						'max_length' => '%s Maxsimal 11 Karakter',
					)
				),
				array(
					'field' => 'ss',
					'label' => 'Tanggal SS',
					'rules' => 'max_length[11]',
					'errors' => array(
						'max_length' => '%s Maxsimal 11 Karakter',
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

				$isiKrs = explode(' - ', $this->input->post('isiKrs'));
				$ubahKrs = explode(' - ', $this->input->post('ubahKrs'));
				$bayar1 = explode(' - ', $this->input->post('bayar1'));
				$bayar2 = explode(' - ', $this->input->post('bayar2'));

				if ( !empty($this->input->post('idAktifReso')) ) {
					$id = $this->input->post('idAktifReso');
				} elseif ( !empty($this->input->post('idAktifReg')) ) {
					$id = $this->input->post('idAktifReg');
				} else {
					$id = '';
				}

				$dataSukses = array(
					'id' => $id,
					'act' => $this->input->post('act'),
					'tahun' => $this->input->post('tahun'),
					'jurusan' => $kodeJurusan,
					'kodeProgram' => $this->input->post('program'),
					'krsm' => $isiKrs[0],
					'krss' => $isiKrs[1],
					'ukrsm' => $ubahKrs[0],
					'ukrss' => $ubahKrs[1],
					'user' => $this->session->userdata('uname'),
					'tglnow' => date('Y-m-d H:i:s'),
					'notactive' => 'N'
					/*'mulaiBayar1' => $bayar1[0],
					'akhirBayar1' => $bayar1[1],
					'mulaiBayar2' => $bayar2[0],
					'akhirBayar2' => $bayar2[1],
					'denda' => $this->input->post('denda'),
					'hargaDenda' => $this->input->post('hrg'),
					'absen' => $this->input->post('absen'),
					'tugas' => $this->input->post('tugas'),
					'uts' => $this->input->post('uts'),
					'uas' => $this->input->post('uas'),
					'ss' => $this->input->post('ss'),*/
				);


				$dataClean = $this->security->xss_clean($dataSukses);

				if ( $this->input->post('act') == 'tambah' ) {

					if ( empty($id) ) {

						$dataArray = array(
							'ket' => 'konfirmasi',
							'data' => $dataClean,
							'pesan' => 'Anda Yakin Mengaktifkan KRS Baru?'
						);

						echo json_encode($dataArray);

					} else {
						$dataArray = array(
							'ket' => 'konfirmasi',
							'data' => $dataClean,
							'pesan' => 'Anda Yakin Menonaktifkan KRS Yang Lama dan Mengaktifkan KRS Baru?'
						);

						echo json_encode($dataArray);
					}

				} elseif ( $this->input->post('act') == 'edit' ) {

					$this->setEditKRS($dataClean);

				}
				
			}

		}

	}

	public function setTambahKRS() {

		$dataSukses = array(
			'id' => $this->input->post('id'),
			'tahun' => $this->input->post('tahun'),
			'jurusan' => $this->input->post('jurusan'),
			'kodeProgram' => $this->input->post('kodeProgram'),
			'krsm' => $this->rubahFormatTanggal($this->input->post('krsm')),
			'krss' => $this->rubahFormatTanggal($this->input->post('krss')),
			'ukrsm' => $this->rubahFormatTanggal($this->input->post('ukrsm')),
			'ukrss' => $this->rubahFormatTanggal($this->input->post('ukrss')),
			'user' => $this->session->userdata('uname'),
			'tglnow' => date('Y-m-d H:i:s'),
			/*'mulaiBayar1' => $this->rubahFormatTanggal($this->input->post('mulaiBayar1')),
			'akhirBayar1' => $this->rubahFormatTanggal($this->input->post('akhirBayar1')),
			'mulaiBayar2' => $this->rubahFormatTanggal($this->input->post('mulaiBayar2')),
			'akhirBayar2' => $this->rubahFormatTanggal($this->input->post('akhirBayar2')),
			'denda' => $this->input->post('denda'),
			'hargaDenda' => $this->input->post('hargaDenda'),*/
			'notactive' => $this->input->post('notactive')/*,
			'absen' => $this->rubahFormatTanggal($this->input->post('absen')),
			'tugas' => $this->rubahFormatTanggal($this->input->post('tugas')),
			'uts' => $this->rubahFormatTanggal($this->input->post('uts')),
			'uas' => $this->rubahFormatTanggal($this->input->post('uas')),
			'ss' => $this->rubahFormatTanggal($this->input->post('ss')),
			'login' => $this->session->userdata('uname')*/
		);

		$query = $this->additional_model->insertDataKRS($dataSukses);

		if ( $query == TRUE ) {

			$dataSukses = array(
					'ket' => 'sukses',
					'pesan' => 'Data KRS Berhasil Disimpan dan Diaktifkan'
				);

			echo json_encode($dataSukses);

		} else {

			$dataError = array(
					'ket' => 'error',
					'pesan' => 'Data Gagal Tersimpan'
				);

			echo json_encode($dataError);

		}

	}

	public function setEditKRS($data) {

		$dataSukses = array(
			'tahun' => $data['tahun'],
			'jurusan' => $data['jurusan'],
			'kodeProgram' => $data['kodeProgram'],
			'krsm' => $this->rubahFormatTanggal($data['krsm']),
			'krss' => $this->rubahFormatTanggal($data['krss']),
			'ukrsm' => $this->rubahFormatTanggal($data['ukrsm']),
			'ukrss' => $this->rubahFormatTanggal($data['ukrss']),
			'user' => $this->session->userdata('uname'),
			'tglnow' => date('Y-m-d H:i:s'),
			/*'mulaiBayar1' => $this->rubahFormatTanggal($data['mulaiBayar1']),
			'akhirBayar1' => $this->rubahFormatTanggal($data['akhirBayar1']),
			'mulaiBayar2' => $this->rubahFormatTanggal($data['mulaiBayar2']),
			'akhirBayar2' => $this->rubahFormatTanggal($data['akhirBayar2']),
			'denda' => $data['denda'],
			'hargaDenda' => $data['hargaDenda'],*/
			'notactive' => $data['notactive']/*,
			'absen' => $this->rubahFormatTanggal($data['absen']),
			'tugas' => $this->rubahFormatTanggal($data['tugas']),
			'uts' => $this->rubahFormatTanggal($data['uts']),
			'uas' => $this->rubahFormatTanggal($data['uas']),
			'ss' => $this->rubahFormatTanggal($data['ss']),
			'login' => $this->session->userdata('uname')*/
		);

		$query = $this->additional_model->updateDataKRS($dataSukses,$data['id']);

		if ( $query == TRUE ) {

			$dataSukses = array(
					'ket' => 'sukses',
					'pesan' => 'Data KRS Berhasil Diupdate'
				);

			echo json_encode($dataSukses);

		} else {

			$dataError = array(
					'ket' => 'error',
					'pesan' => 'Data Gagal Terupdate'
				);

			echo json_encode($dataError);

		}

	}

}