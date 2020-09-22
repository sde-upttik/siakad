<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tambah_nilai_kliring extends CI_Controller {

	function __construct(){
		parent::__construct();

		    $this->load->model('Tambah_nilai_kliringmodel');
		    $this->load->helper(array('form', 'url'));
		    $this->load->helper('security');
		    date_default_timezone_set("Asia/Makassar");
		    $this->load->helper('file');
			if ($this->session->userdata("unip") == null) {
				redirect("https://siakad2.untad.ac.id");
			}
	}

	public function index(){

		//$a['tab'] = $this->app->all_val('groupmodul')->result();
		$a['cekAdmin'] = $this->Tambah_nilai_kliringmodel->getBelum();
		$a['dsn'] = $this->Tambah_nilai_kliringmodel->getDosen();
		$this->load->view('dashbord',$a);


	}

	//Daftar Mhsw
	public function daftar(){

  		$searchData = $this->input->post('searchData');
        $data = $this->Tambah_nilai_kliringmodel->search($searchData);
		$nim = strtoupper($this->input->post('searchData'));

      	if($searchData == ''){
      		
      		$data1['footerSection'] = "<script type='text/javascript'>
 				swal({
					title: 'Pemberitahuan',
					type: 'warning',
					html: true,
					text: 'Silahkan mengisi terlebih dahulu NIM pada Text Input',
					confirmButtonColor: '#f7cb3b',
				});
		    </script>";
			$data1['nim'] 	= "";

			$this->load->view('temp/head');
			$this->load->view('ademik/tambah_nilai_kliring', $data1);
			$this->load->view('temp/footers');

      	}else{

	  		$qNmMhsw 	= "select * from _v2_mhsw where NIM='$nim'";
	  		$nmMhsw 	= $this->Tambah_nilai_kliringmodel->getQuery($qNmMhsw);

	  		if (!empty($nmMhsw) ) {
	  			$data1['nim'] 	= $nmMhsw->NIM;
		  		$data1['name'] 	= $nmMhsw->Name;

	  		}else
	  		{
	  			$data1['footerSection'] = "<script type='text/javascript'>
 				swal({
					title: 'Pemberitahuan',
					type: 'warning',
					html: true,
					text: 'Nim Tidak ditemukan',
					confirmButtonColor: '#f7cb3b',
				});
		    </script>";
	  		}
      		 // $data['sql'] = $this->db->get_where('_v2_mhsw' array('nim'=>$nim))->row();
      		$this->load->view('temp/head');
			$this->load->view('ademik/tambah_nilai_kliring', $data1);
			$this->load->view('temp/footers');
       	}

	}

	 	
	 	//Upload File
		public function aksi_upload(){

		$config['upload_path']          = './assets/images/TambahNilaiKliring/';//save directory
		$config['allowed_types']        = 'pdf|jpg|png';	//save format
		$config['max_size']             = '2048';
		$config['file_name']			= $_FILES['nmfile']['name'];
 
		$this->load->library('upload', $config);
		$images_name = $this->upload->data('file_name');
 
		if ( $this->upload->do_upload('nmfile')){

			return TRUE;

		}else{

			return FALSE;

		}
	}

	public function simpan(){

		$nim = $this->input->post('nim');
		$nama = $this->input->post('nama');
		$tsks = $this->input->post('tsks');
		$jmlArray = sizeof($this->input->post('nim'));
		$cekUpload = $this->aksi_upload(); // panggil function upload file

		if ($cekUpload){
				for($i=0;$i<$jmlArray;$i++){	//perulangan nim nama tsks nomor surat
				
				$datasimpan = array(
					'NIM' =>	$nim[$i],
					'Nama' =>	$nama[$i],
					'Total_SKS'	=>	$tsks[$i],
					'Nomor_surat' => $this->input->post('nsurat'),
					'pimpinan_penanggung_jawab' => $this->input->post('dospen'),
					'Alasan'	=>	$this->input->post('keterangan'),
					'Datetime'	=> date('Y-m-d H:i:s'),
					'filename'	=> $_FILES['nmfile']['name'], //simpan pake nama default file
					'User_usulkan' => $this->session->userdata('uname') //upload nama user yg sedang login di current session
				);
				$cleansimpan = $this->security->xss_clean($datasimpan);
				$sukses = $this->Tambah_nilai_kliringmodel->simpanan($cleansimpan); //run query yg ada di model		
			}

				if ($sukses == FALSE) {
					
					$data1['footerSection'] = "<script type='text/javascript'>
		 				swal({
							title: 'Pemberitahuan',
							type: 'warning',
							html: true,
							text: 'Data Tidak Tersimpan',
							confirmButtonColor: '#f7cb3b',
						});
				    </script>";
					$data1['nim'] 	= "";
					$data1['dsn'] = $this->Tambah_nilai_kliringmodel->getDosen();
					$this->load->view('temp/head');
					$this->load->view('ademik/tambah_nilai_kliring', $data1);
					$this->load->view('temp/footers');
				}else{

					$data1['footerSection'] = "<script type='text/javascript'>
		 				swal({
							title: 'Pemberitahuan',
							type: 'success',
							html: true,
							text: 'Data Berhasil Tersimpan',
							confirmButtonColor: '#f7cb3b',
						},function() {
            				window.location = '".base_url()."ademik/tambah_nilai_kliring';
        				});
				    </script>";
					$data1['nim'] 	= "";

					$this->load->view('temp/head');
					$this->load->view('ademik/tambah_nilai_kliring', $data1);
					$this->load->view('temp/footers');
				}
		}else{

					$data1['footerSection'] = "<script type='text/javascript'>
		 				swal({
							title: 'Pemberitahuan',
							type: 'warning',
							html: true,
							text: 'Silahkan Gunakan Format .PDF/.JPG/.PNG (max size : 2048Kb)',
							confirmButtonColor: '#f7cb3b',
						},function() {
            				window.location = '".base_url()."ademik/tambah_nilai_kliring';
        				});
				    </script>";
					$data1['nim'] 	= "";

					$this->load->view('temp/head');
					$this->load->view('ademik/tambah_nilai_kliring', $data1);
					$this->load->view('temp/footers');
		}
		
			
	}
	public function getNama(){

		$nim = $this->input->post('nim');
		$getNama = $this->Tambah_nilai_kliringmodel->getNama($nim);

		echo json_encode($getNama);
	}

	public function getBelum(){

		$nim = $this->input->post('nim');
		$getBelum = $this->Tambah_nilai_kliringmodel->getBelum($nim);

	}

	public function accept() {
		$ted = $this->input->post('ted');
		for ($i=0; $i < sizeof($ted) ; $i++) { 
			$accept = $this->Tambah_nilai_kliringmodel->accept($ted[$i]);
		}
		
			$data1['footerSection'] = "<script type='text/javascript'>
		 				swal({
							title: 'Pemberitahuan',
							type: 'success',
							html: true,
							text: 'Accepted',
							confirmButtonColor: '#f7cb3b',
						},function() {
            				window.location = '".base_url()."ademik/tambah_nilai_kliring';
        				});
				    </script>";
					$data1['nim'] 	= "";

					$this->load->view('temp/head');
					$this->load->view('ademik/tambah_nilai_kliring', $data1);
					$this->load->view('temp/footers');
		
	}

}
