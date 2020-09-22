<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

class Berita extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->helper('security');
	    $this->load->model('additional_model');
	    $this->load->helper('file');
	}

	public function index() {

		$data['berita'] = $this->additional_model->getListBerita();
		$data['kategori'] = $this->additional_model->getListBeritaKategori();
		$data['footerSection'] = "<script type='text/javascript'>
 				$('#berita').dataTable( {
    				'order': [2,'desc']
				} );	
		    </script>";

		$this->load->view('dashbord',$data);

	}

	private function rubahFormatTanggal($date) {

		$data = str_replace("/", "-", $date);
		$tgl = explode("-", $data);

		return $tgl[2]."-".$tgl[1]."-".$tgl[0];

	}

	public function halaman_berita($id) {

		$data ['berita'] = $this->additional_model->getBacaBerita($id);

		$this->load->view('temp/head');
		$this->load->view('hal_berita', $data);
		$this->load->view('temp/footers');

	}

	public function formTambahBerita() {

		$data['kategori'] = $this->additional_model->getListBeritaKategori();

		$this->load->view('dashbord',$data);

	}

	public function formEditBerita($id) {

		$data['kategori'] = $this->additional_model->getListBeritaKategori();
		$data['edit'] = $this->additional_model->getEditDataBerita($id);
		$data['TglExp'] = $this->rubahFormatTanggal($data['edit']->TglExp);

		$this->load->view('dashbord',$data);

	}

	public function validasiFormTambah() {
			
		$config = array(
			array(
				'field' => 'id',
				'label' => 'ID Berita',
				'rules' => 'required|is_natural|max_length[10]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'is_natural' => '%s Tidak Boleh Huruf',
					'max_length' => '%s Maksimal 10 Angka',
				)
			),
			array(
				'field' => 'judul',
				'label' => 'Judul Berita',
				'rules' => 'required|max_length[150]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 150 Karakter',
				)
			),
			array(
				'field' => 'kategori',
				'label' => 'Tujuan Berita',
				'rules' => 'required|max_length[100]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 100 Karakter',
				)
			),
			array(
				'field' => 'konten',
				'label' => 'Konten Berita',
				'rules' => 'required',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
				)
			),
		);

		$this->form_validation->set_rules($config);

		if ( $this->form_validation->run() == FALSE ) {
			$dataError = validation_errors();
			$pesan = json_encode($dataError);

			$data['error'] = $pesan;
			$data['kategori'] = $this->additional_model->getListBeritaKategori();

			$this->load->view('dashbord',$data);

		} else {

			$config['upload_path'] = './assets/images/Berita/';
			$config['file_name'] = $this->input->post('judul');
    		$config['allowed_types'] = 'jpg|png|jpeg';
    		$config['max_size']  = '2048';
    		$config['overwrite'] = TRUE;
    		$config['remove_space'] = TRUE;

    		$this->load->library('upload', $config);
    		$cek = $this->upload->do_upload('foto');
    		$images = $this->upload->data('is_image');
    		$images_name = $this->upload->data('file_name');

    		if ( $this->input->post('aktif') == 'on' ) {
    			$aktif = 'N';
    		} else {
    			$aktif = 'Y';
    		}

    		if ( $this->input->post('tglExp') == '' ) {
    			$tglExp = '00-00-0000';
    		} else {
    			$tglExp = $this->input->post('tglExp');
    		}

    		if( $cek ) { // Lakukan upload dan Cek jika proses upload berhasil
		      // Jika berhasil :
		    	$idBerita = $this->input->post('id');

				$dataSukses = array(
					'Judul' => $this->additional_model->db->escape_str(ucwords($this->input->post('judul'))),
					'Kategori' => $this->additional_model->db->escape_str($this->input->post('kategori')),
					'TglExp' => $this->rubahFormatTanggal($tglExp),
					'Konten' => $this->input->post('konten'),
					'NotActive' => $this->additional_model->db->escape_str($aktif),
					'foto_berita' => $this->additional_model->db->escape_str($images_name),
					'Author' => $this->additional_model->db->escape_str($this->session->userdata('uname')),
					'Tgl' => date('Y-m-d')
				);

				$dataClean = $this->security->xss_clean($dataSukses);
				$simpan = $this->additional_model->insertBerita($dataClean);

				if ( $simpan == TRUE ) {

					$data['success'] = 'Data Berhasil Tersimpan';
					$data['kategori'] = $this->additional_model->getListBeritaKategori();

					$this->load->view('dashbord',$data);

				} else {

					$data['error'] = 'Data Gagal Tersimpan';
					$data['kategori'] = $this->additional_model->getListBeritaKategori();

					$this->load->view('dashbord',$data);

				}	

		    }else{
		      // Jika gagal :

		    	if ( $images == 1 ) {

		    		$dataError = $images_name;
					$pesan = json_encode($dataError);

					$data['error'] = $pesan;
					$data['kategori'] = $this->additional_model->getListBeritaKategori();

					$this->load->view('dashbord',$data);

		    	} else {

			    	$idBerita = $this->input->post('id');

			    	$dataSukses = array(
						'Judul' => $this->additional_model->db->escape_str(ucwords($this->input->post('judul'))),
						'Kategori' => $this->additional_model->db->escape_str($this->input->post('kategori')),
						'TglExp' => $this->rubahFormatTanggal($tglExp),
						'Konten' => $this->input->post('konten'),
						'NotActive' => $this->additional_model->db->escape_str($aktif),
						'Author' => $this->additional_model->db->escape_str($this->session->userdata('uname')),
						'Tgl' => date('Y-m-d')
					);

					$dataClean = $this->security->xss_clean($dataSukses);
					$simpan = $this->additional_model->insertBerita($dataClean);

					if ( $simpan == TRUE ) {

						$data['success'] = 'Data Berhasil Tersimpan';
						$data['kategori'] = $this->additional_model->getListBeritaKategori();

						$this->load->view('dashbord',$data);

					} else {

						$data['error'] = 'Data Gagal Tersimpan';
						$data['kategori'] = $this->additional_model->getListBeritaKategori();

						$this->load->view('dashbord',$data);

					}

		    	}

		    }
			
		}

	}

	public function validasiFormEdit() {

		$idBerita = $this->input->post('idEdit');
			
		$config = array(
			array(
				'field' => 'idEdit',
				'label' => 'ID Berita',
				'rules' => 'required|is_natural|max_length[10]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'is_natural' => '%s Tidak Boleh Huruf',
					'max_length' => '%s Maksimal 10 Angka',
				)
			),
			array(
				'field' => 'judulEdit',
				'label' => 'Judul Berita',
				'rules' => 'required|max_length[150]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 150 Karakter',
				)
			),
			array(
				'field' => 'kategoriEdit',
				'label' => 'Tujuan Berita',
				'rules' => 'required|max_length[100]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 100 Karakter',
				)
			),
			array(
				'field' => 'kontenEdit',
				'label' => 'Konten Berita',
				'rules' => 'required',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
				)
			),
		);

		$this->form_validation->set_rules($config);

		if ( $this->form_validation->run() == FALSE ) {
			$dataError = validation_errors();
			$pesan = json_encode($dataError);

			$data['error'] = $pesan;
			$data['edit'] = $this->additional_model->getEditDataBerita($idBerita);
			$data['TglExp'] = $this->rubahFormatTanggal($data['edit']->TglExp);
			$data['kategori'] = $this->additional_model->getListBeritaKategori();

			$this->load->view('dashbord',$data);

		} else {

			$config['upload_path'] = './assets/images/Berita/';
			$config['file_name'] = $this->input->post('judulEdit');
    		$config['allowed_types'] = 'jpg|png|jpeg';
    		$config['max_size']  = '2048';	
    		$config['overwrite'] = TRUE;
    		$config['remove_space'] = TRUE;

    		$this->load->library('upload', $config);
    		$cek = $this->upload->do_upload('fotoEdit');	
    		$images = $this->upload->data('is_image');
    		$images_name = $this->upload->data('file_name');

    		if ( $this->input->post('aktifEdit') == 'on' ) {
    			$aktif = 'N';
    		} else {
    			$aktif = 'Y';
    		}

    		if ( $this->input->post('tglExpEdit') == '' ) {
    			$tglExp = '00-00-0000';
    		} else {
    			$tglExp = $this->input->post('tglExpEdit');
    		}

    		if( $cek ) { // Lakukan upload dan Cek jika proses upload berhasil
		      // Jika berhasil :

		    	$dataSukses = array(
					'Judul' => $this->additional_model->db->escape_str(ucwords($this->input->post('judulEdit'))),
					'Kategori' => $this->additional_model->db->escape_str($this->input->post('kategoriEdit')),
					'TglExp' => $this->rubahFormatTanggal($tglExp),
					'Konten' => $this->input->post('kontenEdit'),
					'NotActive' => $this->additional_model->db->escape_str($aktif),
					'foto_berita' => $this->additional_model->db->escape_str($images_name),
					'Author' => $this->additional_model->db->escape_str($this->session->userdata('uname')),
					'Tgl' => date('Y-m-d')
				);

				$dataClean = $dataSukses;
				$simpan = $this->additional_model->updateBerita($dataClean,$idBerita);

				if ( $simpan == TRUE ) {

					$data['success'] = 'Data Berhasil dirubah';
					$data['edit'] = $this->additional_model->getEditDataBerita($idBerita);
					$data['TglExp'] = $this->rubahFormatTanggal($data['edit']->TglExp);
					$data['kategori'] = $this->additional_model->getListBeritaKategori();

					$this->load->view('dashbord',$data);

				} else {

					$data['error'] = 'Data Gagal Tersimpan';
					$data['edit'] = $this->additional_model->getEditDataBerita($idBerita);
					$data['TglExp'] = $this->rubahFormatTanggal($data['edit']->TglExp);
					$data['kategori'] = $this->additional_model->getListBeritaKategori();

					$this->load->view('dashbord',$data);

				}

		    }else{
		      // Jika gagal :
		    	if ( $images == 1 ) {

		    		$dataError = $this->upload->display_errors();
					$pesan = json_encode($dataError);

					$data['error'] = $pesan;					
					$data['edit'] = $this->additional_model->getEditDataBerita($idBerita);
					$data['TglExp'] = $this->rubahFormatTanggal($data['edit']->TglExp);
					$data['kategori'] = $this->additional_model->getListBeritaKategori();

					$this->load->view('dashbord',$data);

		    	} else {

			    	$dataSukses = array(
						'Judul' => $this->additional_model->db->escape_str(ucwords($this->input->post('judulEdit'))),
						'Kategori' => $this->additional_model->db->escape_str($this->input->post('kategoriEdit')),
						'TglExp' => $this->rubahFormatTanggal($tglExp),
						'Konten' => $this->input->post('kontenEdit'),
						'NotActive' => $this->additional_model->db->escape_str($aktif),
						'Author' => $this->additional_model->db->escape_str($this->session->userdata('uname')),
						'Tgl' => date('Y-m-d')
					);

					$dataClean = $dataSukses;
					$simpan = $this->additional_model->updateBerita($dataClean,$idBerita);

					if ( $simpan == TRUE ) {

						$data['success'] = 'Data Berhasil Diubah';		
						$data['edit'] = $this->additional_model->getEditDataBerita($idBerita);
						$data['TglExp'] = $this->rubahFormatTanggal($data['edit']->TglExp);
						$data['kategori'] = $this->additional_model->getListBeritaKategori();

						$this->load->view('dashbord',$data);

					} else {

						$data['error'] = 'Data Gagal Diubah';
						$data['edit'] = $this->additional_model->getEditDataBerita($idBerita);
						$data['TglExp'] = $this->rubahFormatTanggal($data['edit']->TglExp);
						$data['kategori'] = $this->additional_model->getListBeritaKategori();

						$this->load->view('dashbord',$data);

					}

		    	}

		    }

		}

	}

	function setHapusDataBerita($id) {

		$namaFoto = $this->additional_model->getNamaFotoBerita($id);
		$aksi = $this->additional_model->hapusDataBerita($id);
		$file = realpath(APPPATH . '../assets/images/Berita/'.$namaFoto->foto_berita);

		if ( $aksi == TRUE ) {

			if(is_file($file))
			unlink($file); //delete file

			$dataSukses = array(
				'ket' => 'sukses',
				'pesan' => 'Berita ini Berhasil Dihapus'
			);

			echo json_encode($dataSukses);

		} else {

			$dataError = array(
				'ket' => 'error',
				'pesan' => 'Tidak Berhasil Dihapus'
			);

			echo json_encode($dataError);

		}

	}

}