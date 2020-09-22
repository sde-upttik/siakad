<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mhswpindah extends CI_Controller {

//Memanggil model dan library tambahan
	function __construct(){
		parent::__construct();
			date_default_timezone_set("Asia/Makassar");
	    $this->load->model('Model_mahasiswa_pindah');
			$this->load->library(['form_validation', 'feeder_untad']);
			// $this->load->library();
			// $this->load->helper(array('form', 'url'));
	    $this->load->helper(['file','form', 'url']);
			$this->load->helper('security');
			
		$this->load->library('csrf');
	}

//Default View  
	private function default_view($path_view, $data_bind="")
	{
		$this->load->view('temp/head');
		$this->load->view($path_view, $data_bind);
		$this->load->view('temp/footers');
	}
 
//Mengambil data dari database untuk menampilkan di select Bar
	public function index(){
		
		$data_bind['univLs'] = $this->feeder_untad->get('GetAllPT')->data;
		$this->default_view('ademik/mahasiswa_pindah/menu_mahasiswa_pindah',$data_bind);
		$this->load->view("ademik/mahasiswa_pindah/menu_mahasiswa_pindah_js");
	}

//view file Controller
	public function view_pindah_jurusan()
	{
		$data_jurusan 	= $this->Model_mahasiswa_pindah->jurusan();
		$data_bind 		= array('data_jurusan' => $data_jurusan);

		$this->load->view(
							'ademik/mahasiswa_pindah/form_pemindahan_mahasiswa',
							$data_bind
							);

		$this->load->view("ademik/mahasiswa_pindah/form_pemindahan_mahasiswa_js");
	}	

	public function view_pindah_keluar()
	{
		$data_jurusan 	= $this->Model_mahasiswa_pindah->jurusan();
		$data_fakultas 	= $this->Model_mahasiswa_pindah->fakultas();
		
		$data_bind 		= array(
								'data_jurusan' => $data_jurusan,
								'data_fakultas' => $data_fakultas,
								);

		$this->load->view(
							'ademik/mahasiswa_pindah/form_pindah_keluar',
							$data_bind
							);

		$this->load->view("ademik/mahasiswa_pindah/form_pindah_keluar_js");
	}

	public function viewPindahReg()
	{
		$this->load->view("ademik/mahasiswa_pindah/formPindahReg");
		$this->load->view("ademik/mahasiswa_pindah/formPindahReg_js");
	}

	public function get_data_mahasiswa($nim)
	{
		$table			= "_v2_mhsw";

		$fields 		= array(
								"SID",
		        				"id_pd",
		        				"Login",
		        				"Password",
		        				"Description",
		        				"Sex",
		        				"NIM",
		        				"Name",
		        				"TempatLahir",
		        				"TglLahir",
		        				"NamaIbu",
		        				"Email",
		        				"Phone",
		        				"KodeFakultas",
		        				"KodeJurusan",
		        				"KodeProgram",
		        				"StatusAwal",
		        				"Status",
		        				"TahunAkademik",
		        				"Semester",
		        				"SKSditerima",
								);

		$where 			= array(
								"NIM" => $nim
								);

		$data_mahasiswa = $this->Model_mahasiswa_pindah->select_fields_where($table, $fields, $where);

		return $data_mahasiswa;
	}

	public function dataMhswKeluar($nim)
	{
		$data = $this->Model_mahasiswa_pindah->getDataMhswKeluar($nim);

		echo json_encode($data);
	}

	public function get_kode_fakultas($jurusan)
	{
		$table			= "_v2_jurusan";

		$fields 		= array(
			        			"KodeFakultas"
								);

		$where 			= array(
								"Kode" => $jurusan
								);

		$data_jurusan	= $this->Model_mahasiswa_pindah->select_fields_where($table, $fields, $where);

		return $data_jurusan;
	}

	public function get_nim_baru($jurusan, $tahun_akademik,$nim='',$dump=FALSE)
	{
		$jurs = str_replace(['K2T','K2t','k2T','k2t','K2M','K2m','k2M','k2m'],'',$jurusan);
		$table				= "_v2_mhsw";

		$fields 			= array(
				        			"NIM",
				        			"KodeJurusan",
				        			"KodeFakultas",
									);

		$where 				= array(
									"KodeJurusan" 	=> $jurs,
									"TahunAkademik" => $tahun_akademik
									);

		$order				= "NIM";
		$tahun_akademik   	= substr($tahun_akademik, 2,2);

		if ($nim) {
			$nims = $jurusan.$tahun_akademik;
			$data_mahasiswa		= $this->Model_mahasiswa_pindah->select_nim_akhir($table, $fields, $nims, $order);
		}else{
			$data_mahasiswa		= $this->Model_mahasiswa_pindah->select_fields_where_order($table, $fields, $where, $order);
		}

		if (empty($data_mahasiswa)) {
			$data_nim 	     = $jurusan.$tahun_akademik."001";
			$kode_dakultas   = $this->get_kode_fakultas($jurusan);
			$data_fakultas   = $kode_dakultas[0]['KodeFakultas']; 	
		}else{
			$nim_terakhir  = 	str_pad(
													(substr($data_mahasiswa[0]["NIM"], 6, 3)) + 1,
													3, "0", STR_PAD_LEFT
												);

			// $nim_terakhir = str_pad($this->lastNim($jurusan,$tahun_akademik),3,'0',STR_PAD_LEFT);
			$data_nim	   = $jurusan.$tahun_akademik.$nim_terakhir;
			$data_fakultas = $data_mahasiswa[0]["KodeFakultas"];
			
		}

		$data_bind =	array(
										'nim_baru' 		=> $data_nim,
										'KodeFakultas'	=> $data_fakultas,
									);

		if ($dump) {
			$data_bind['query'] = $this->db->last_query();
			echo "<pre>";
			print_r($data_bind);
			echo "</pre>";
		}else{
			return $data_bind;
		}
	}

	public function data_mahasiswa_baru($nim, $jurusan)
	{
		$jurusan = str_replace(['K2T','K2t','k2T','k2t','K2M','K2m','k2M','k2m'],'',$jurusan);
		$data_mahasiswa 	 = $this->get_data_mahasiswa($nim);
		$data_kode_mahasiswa = $this->get_nim_baru($jurusan, $data_mahasiswa[0]["TahunAkademik"],true);
		$id_prodi = $this->db->get_where('_v2_jurusan',['kode'=>$jurusan])->row()->id_sms;
		$periode_feeder = $this->feeder_untad->get('GetPeriode',"id_prodi ='$id_prodi'")->data;

		$data_bind 		= array(
								"data_mahasiswa"   	=> $data_mahasiswa,
								"nim_baru" 		   		=> $data_kode_mahasiswa["nim_baru"],
								"KodeFakultas" 	   	=> $data_kode_mahasiswa["KodeFakultas"],
								"KodeJurusan_baru" 	=> $jurusan,
								"periode_feeder" 		=> $periode_feeder
								);

		$this->load->view("ademik/mahasiswa_pindah/form_jurusan_baru.php", $data_bind);

	} 

	public function simpan_mahasiswa_pindah()
	{
		$res = array(
			'insert'	=> FALSE,
			'update'	=> FALSE,
			'inFeeder'	=> [],
			'outFeeder'	=> []
		);
		
		$table 		  = "_v2_mhsw";

		$data_insert  =  array(
								'SID' 				=> $this->input->post('nimbaru'),
								'id_pd' 			=> $this->input->post('id_pd'),
								'Login' 			=> $this->input->post('nimbaru'),
								'Password' 			=> $this->input->post('password'),
								'Sex' 				=> $this->input->post('Sex'),
								'Description' 		=> 'Mahasiswa',
								'NIM' 				=> $this->input->post('nimbaru'),
								'Name' 				=> $this->input->post('namabaru'),
								'TempatLahir' 		=> $this->input->post('tempatlahir'),
								'TglLahir' 			=> $this->input->post('tgllahir'),
								'NamaIbu' 			=> $this->input->post('namaibu'),
								'Email' 			=> $this->input->post('emailbaru'),
								'Phone' 			=> $this->input->post('telpbaru'),
								'KodeFakultas' 		=> $this->input->post('fakultas'),
								'KodeJurusan' 		=> $this->input->post('jurusan'),
								'KodeProgram' 		=> $this->input->post('program'),
								'StatusAwal' 		=> 'P',
								'Status' 			=> 'A',
								'TahunAkademik' 	=> $this->input->post('tahun_akademik'),
								'SKSditerima' 		=> $this->input->post('SKSditerima'),
								'PMBID'						=> $this->input->post('nim_lama')
								); 

		$data_update = array('Status' => 'P');
		
		$where 		 = array('NIM' => $this->input->post('nim_lama') );
		

		$insert_feeder = array(
			'id_mahasiswa'							=> $this->input->post('id_pd'),
			'nim'												=> $this->input->post('nimbaru'),
			'id_jenis_daftar'						=> '2',
			'id_jalur_daftar'						=> '',
			'id_periode_masuk'					=> $this->input->post('TahunAkademik'),
			'tanggal_daftar'						=> date("Y-m-d"),
			'id_perguruan_tinggi'				=> '8e5d195a-0035-41aa-afef-db715a37b8da',
			'id_prodi'									=> $this->Model_mahasiswa_pindah->getIdJurusan($this->input->post('jurusan')),
			'sks_diakui'								=> $this->input->post('SKSditerima'),
			'id_perguruan_tinggi_asal'	=> '8e5d195a-0035-41aa-afef-db715a37b8da',
			'id_prodi_asal'							=> $this->Model_mahasiswa_pindah->getIdJurusan($this->input->post('kode_jurusan_lama')),
			'id_pembiayaan'							=> '',
			'biaya_masuk				'				=> $this->input->post('biaya_masuk_kuliah'),
		);
		
		$update_feeder = array(
			'id_registrasi_mahasiswa' => $this->input->post('id_reg_pd'),
			'id_jenis_keluar' => '2',
			'tanggal_keluar' => date("Y-m-d"),
			'id_periode_keluar' => $this->input->post('tahun_akademik')
		);

		$nim  = $this->input->post('nimbaru');
		$xnim = $this->input->post('nim_lama');
		$count = $this->Model_mahasiswa_pindah->count_nim($this->input->post('nimbaru'));
		if ($count == 0) {
			# code...
			$insert_data = $this->Model_mahasiswa_pindah->insert($table, $data_insert);
			$res['inset'] = $insert_data;
		}
		
		$update_data = $this->Model_mahasiswa_pindah->update($table, $data_update, $where);
		$res['update'] = $update_data;

		// if ($insert_data && $update_data) {
					
			$filter1 = "nim='$nim'";
			$filter2 = "nim='$xnim'";
			
			$cek1 = $this->feeder_untad->get('GetListRiwayatPendidikanMahasiswa',$filter1); // cek riwayar pendidikan yg baru
			$cek2 = $this->feeder_untad->get('GetDetailMahasiswaLulusDO',$filter2); // cek mhsw lulus do nim lama
			$res['cek1'] = $cek1;
			$res['cek2'] = $cek2;
			 
			if (!$cek1->data) {
				# jika nim baru belum ada di feeder
				$res['inFeeder'] = $this->InsertRiwayatPendidikanMahasiswa($nim);
			}
			if (!$cek2->data) {
				# jika nim lama belum berstatus pindah
				$res['outFeeder']	= $this->InsertMahasiswaLulusDO($xnim);
			}
		echo json_encode($res);
	}

	public function prosesMhswKeluar() {

		$config = array(
			array(
				'field' => 'nim',
				'label' => 'Nomor Stambuk',
				'rules' => 'required|max_length[9]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 9 Angka',
				)
			),
			array(
				'field' => 'alamatS',
				'label' => 'Alamat Sekarang',
				'rules' => 'required|max_length[250]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 250 Karakter',
				)
			),
			array(
				'field' => 'alamatSP',
				'label' => 'Alamat Setelah Pindah',
				'rules' => 'required|max_length[250]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 250 Karakter',
				)
			),
			array(
				'field' => 'pindah',
				'label' => 'Pindah',
				'rules' => 'required|max_length[250]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 250 Karakter',
				)
			),
			array(
				'field' => 'alasan_keluar',
				'label' => 'Alasan',
				'rules' => 'required|max_length[250]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 250 Karakter',
				)
			),
		);

		$this->form_validation->set_rules($config);

		if ( $this->form_validation->run() == FALSE ) {

			$data = array(
				'pesan' =>  validation_errors(),
				'respon' => 0
			);

			echo json_encode($data);

		} else {

			$nim = $this->input->post('nim');
			$where 	= array('NIM' => $nim);

			$dataSukses = array(
				'Alamat' => $this->input->post('alamatS'),
				'AlamatSP' => $this->input->post('alamatSP'),
				'AlasanPindah' => $this->input->post('alasan_keluar'),
				'UniversitasPindah' => $this->input->post('pindah'),
				'Status' => 'P'
			);

			$session_name = array(
				'NIM_tmp' 		=> $nim,
				'model_pindah'  => 'mhsw_keluar'
			);

			$this->session->set_userdata($session_name);

			$dataClean = $this->security->xss_clean($dataSukses);
			$simpan = $this->Model_mahasiswa_pindah->update('_v2_mhsw',$dataClean,$where);

			if ( $simpan == 1 ) {
				$this->InsertMahasiswaLulusDO($nim);
				$data = array(
					'respon' => 1
				);

				echo json_encode($data);

			} else {

				$data = array(
					'pesan' =>  'Data Gagal Tersimpan',
					'respon' => 0
				);

				echo json_encode($data);

			}
			
		}

	}

	public function view_response_pindah_keluar() {

		$data_mahasiswa 	= $this->Model_mahasiswa_pindah->getProsesDataMhswKeluar($this->session->userdata('NIM_tmp'));
		
		$data_bind 	= array(
			'data_mahasiswa_pindahan' => $data_mahasiswa,
		);

		$this->load->view('ademik/mahasiswa_pindah/response_pindah_keluar',$data_bind);

		$this->load->view("ademik/mahasiswa_pindah/response_pindah_keluar_js");

	}

	public function cek_status_mahasiswa()
	{
		$nim 			= $_POST["nim"];
		$jurusan 		= $_POST["jurusan"];

		$table			= "_v2_mhsw";

		$fields 		= array(
			        			"Status",
			        			"KodeJurusan",
								);

		$where 			= array(
								"NIM" => $nim
								);

		$data_status	= $this->Model_mahasiswa_pindah->select_fields_where($table, $fields, $where);

		if ($data_status[0]['Status']== "A") {
			$respon = 1;
			if ($data_status[0]['KodeJurusan'] == $jurusan) {
				$respon = 2;
			}
			echo $respon;
		}
		else{
			echo 0;
		}
	}


//Controller Fadli ______________________________________________________________________________________________

	public function view_pindah_untad()
	{
		$data_fakultas 	= $this->Model_mahasiswa_pindah->fakultas();
		
		$data_bind 		= array(
								'data_fakultas' => $data_fakultas,
								'univLs'	=> $this->feeder_untad->get('GetAllPT')->data
								);

		$this->load->view(
							'ademik/mahasiswa_pindah/form_pindah_untad', 
							$data_bind
							);

		$this->load->view("ademik/mahasiswa_pindah/form_pindah_untad_js");
	}	

	public function view_response_pindah_untad()
	{
		$where 				= array('NIM' => $this->session->userdata('NIM_tmp') );

		$data_mahasiswa 	= $this->Model_mahasiswa_pindah->getMahasiswaPindahUntad($where);
		
		$data_bind 			= array(
								'data_mahasiswa_pindahan' => $data_mahasiswa,

								);

		$this->load->view(
							'ademik/mahasiswa_pindah/response_pindah_untad',
							$data_bind
							);

		$this->load->view("ademik/mahasiswa_pindah/response_pindah_untad_js");
	}

	// Controller GetData 
	public function getDataJurusanWhere()
	{
		$where 			= array('KodeFakultas' => $_POST['KodeFakultas']);
		$data_result 	= $this->Model_mahasiswa_pindah->jurusan($where);
		print_r(json_encode($data_result));
	}

	//Controller CRUD
	public function insert_pindah_untad()
	{	
		$nim_baru 				= $this->get_nim_baru($_POST['KodeJurusan'], $_POST['TahunAkademik']);
		
		$_POST['NIM']					= $nim_baru['nim_baru'];
		$_POST['Status'] 			= 'A';
		$_POST['StatusAwal'] 	= 'P';
		$_POST['Login']				= $nim_baru['nim_baru'];
		$_POST['Password']		= $nim_baru['nim_baru'].'$';

		$session_name 			= array(
										'NIM_tmp' 		=> $nim_baru['nim_baru'],
										'model_pindah'  => 'mhsw_masuk'
										);

		$this->session->set_userdata($session_name);
		
		$data_result  = $this->Model_mahasiswa_pindah->insert('_v2_mhsw',$_POST);

		echo $data_result;
	}

	//Control Upload
	public function uploadFilePdf()
	{
		if (isset($_FILES)) {
			
			$upload1 		= $_FILES['file1']['tmp_name'];
			$upload2 		= $_FILES['file2']['tmp_name'];

			$name 			= $this->session->userdata('NIM_tmp');
			$nameFolder 	= $this->session->userdata('model_pindah');

			$fileTranskrip  = './assets/data/berkas_pindah/'.$nameFolder.'/'.$name.'_file_transkip.pdf';
			$fileBalangko  	= './assets/data/berkas_pindah/'.$nameFolder.'/'.$name.'_file_blangko_pindah.pdf';

			//Porses Upload Ke server versi native
			move_uploaded_file($upload1, $fileTranskrip);
			move_uploaded_file($upload2, $fileBalangko);

			if (file_exists($fileTranskrip)) {
				$data 	= array('file_transkip' => $fileTranskrip);
				$where 	= array('Nim' => $name);

				$this->Model_mahasiswa_pindah->update('_v2_mhsw', $data, $where);
				
				if (file_exists($fileBalangko)) {
				
					$data 	= array('file_blangko_pindah' => $fileBalangko);
					$where 	= array('Nim' => $name);
	
					$this->Model_mahasiswa_pindah->update('_v2_mhsw', $data, $where);
	
					echo "1";
				}
				else{
					echo "0";
				}
			}
			else{
				echo "0";
			}
		}else{
			echo "0";
		}	
	}

	// Cari Mahasiswa
	public function cariMahasiswa()
	{
		$key = $this->input->post($this->csrf->ajax_token('name'));
		if ($_SESSION['hash']!=$key) {
			echo 'You are forbidden!';
			header('HTTP/1.0 403 Forbidden');
			exit(403);
		}else{
			unset($_SESSION['hash']);
			unset($_POST[$this->csrf->ajax_token('name')]);
			return true;
		}
		// $this->csrf->token_check();
		$return['hash'] = $_SESSION['hash'];
		$return['post']	= $this->input->post();
		echo json_encode($return);
	}

	// fungsi feeder
	public function GetAllPT()
	{
		
		$search = $_POST['search'];
		$listPT = $this->feeder_untad->get("GetAllPT","nama_perguruan_tinggi like '%$search%'");
		// echo json_encode($listPT->data);

		$list = array();
		$key=0;
		foreach ($listPT->data as $row) {
			$list[$key]['id'] = $row->id_perguruan_tinggi;
			$list[$key]['text'] = $row->nama_perguruan_tinggi; 
			$key++;
		}
		echo json_encode($list);
	}

	public function getProdiAsal()
	{
		// echo json_encode($this->input->post());
		$id_univ = $this->input->post('id_perguruan_tinggi');
		$listProdi = $this->feeder_untad->get("GetAllProdi","id_perguruan_tinggi='$id_univ'");

		echo json_encode($listProdi);
	}

	public function InsertRiwayatPendidikanMahasiswa($nim,$manual=FALSE)
	{
		if ($manual) {
			$tahun_pindah = '20201';
			$biaya_masuk_kuliah = '175000';
		}else{
			$tahun_pindah = $this->input->post('tahun_pindah');
			$biaya_masuk_kuliah = $this->input->post('biaya_masuk_kuliah');
		}

		$mhsw = $this->db->get_where('_v2_mhsw',['nim'=>$nim])->row();
		$mhswLama = $this->db->get_where('_v2_mhsw',['nim'=>$mhsw->PMBID])->row();

		if (!$mhswLama) {
			$mhswfeeder = $this->feeder_untad->get('GetDataLengkapMahasiswaProdi',"nim='$mhsw->PMBID'")->data[0];
			$idProdiFeeder = $mhswfeeder->id_prodi;
		}else {
			$idProdiFeeder = $this->Model_mahasiswa_pindah->getIdJurusan($mhswLama->KodeJurusan);
		}
		$insert_feeder = array(
			'id_mahasiswa'							=> $mhsw->id_pd,
			'nim'												=> $mhsw->NIM,
			'id_jenis_daftar'						=> '2',
			'id_jalur_daftar'						=> '',
			'id_periode_masuk'					=> $tahun_pindah,
			'tanggal_daftar'						=> date("Y-m-d"),
			'id_perguruan_tinggi'				=> '8e5d195a-0035-41aa-afef-db715a37b8da',
			'id_prodi'									=> $this->Model_mahasiswa_pindah->getIdJurusan($mhsw->KodeJurusan),
			'sks_diakui'								=> floatval($mhsw->SKSditerima),
			'id_perguruan_tinggi_asal'	=> '8e5d195a-0035-41aa-afef-db715a37b8da',
			'id_prodi_asal'							=> $idProdiFeeder,
			'id_pembiayaan'							=> '',
			'biaya_masuk'								=> $biaya_masuk_kuliah,
		);
		
		$res = $this->feeder_untad->insert('InsertRiwayatPendidikanMahasiswa',$insert_feeder);
			
		if (!empty($res->data)) {
			$this->db->where(['nim'=>$nim])->set(['id_reg_pd'=>$res->data->id_registrasi_mahasiswa,'st_feeder'=>'1'])->update('_v2_mhsw');
		}

		if ($manual) {
			$ress = $this->InsertMahasiswaLulusDO($mhsw->PMBID,$manual);
			echo "<pre>";
			print_r($res);
			echo "<hr/>";
			print_r($ress);
			echo "</pre>";
		}
		return $res;
	}

	public function insertRiwayatFeeder($nim='A40119214')
	{
		// echo "oke";
		$this->db->select("ID, id_pd, id_reg_pd, NIM, Name,SKSditerima, Semester, tahunAkademik,StatusAwal,UniversitasAsal,ProdiAsal");
		$data =	$this->db->get_where('_v2_mhsw', [ 'Login' => $nim ] );
		$mhsw = $data->row();
		$count = $data->num_rows();

		print_r($mhsw);
	}

	public function InsertMahasiswaLulusDO($nim,$manual=FALSE)
	{
		if ($manual) {
			$tahun_pindah = '20201';
		}else{
			$tahun_pindah = $this->input->post('tahun_pindah');
		}
		$mhsw = $this->db->get_where('_v2_mhsw',['nim'=>$nim])->row();
		if ($mhsw) {
			$id_reg_pd =$mhsw->id_reg_pd;
		}else { 
			$id_reg_pd = $this->feeder_untad->get('GetDataLengkapMahasiswaProdi',"nim='$nim'")->data[0]->id_registrasi_mahasiswa;
		}

		$update_feeder = array(
			'id_registrasi_mahasiswa' => $id_reg_pd,
			'id_jenis_keluar' => '2',
			'tanggal_keluar' => date("Y-m-d"),
			'id_periode_keluar' => $tahun_pindah
		);
		$res = $this->feeder_untad->insert('InsertMahasiswaLulusDO',$update_feeder);
		return $res;
	}

	// function feeder_manual(){
	// 	print_r($this->InsertRiwayatPendidikanMahasiswa());
	// 	echo "<br>";
	// 	print_r($this->InsertMahasiswaLulusDO());
	// }

	public function verify()
	{
		$this->db->select("ID, id_pd, id_reg_pd, NIM, Name,SKSditerima, Semester, tahunAkademik");
		// $this->db->limit('2');
		$data =	$this->db->get_where('_v2_mhsw',['StatusAwal'=>'P','id_reg_pd'=>NULL])->result();
		// $i = 0;
		foreach ($data as $mhsw) {
			$fdr = $this->feeder_untad->get('GetDataLengkapMahasiswaProdi',"nim='$mhsw->NIM'");
			echo $mhsw->NIM.' ';
			echo json_encode($fdr->data);
			echo " count : ".count($fdr->data);

			if (count($fdr->data)==1) {
				$fdrMhs = $fdr->data[0];
				if ($fdrMhs->sks_diakui) {
					$set = array(
						'id_reg_pd'	=> $fdrMhs->id_registrasi_mahasiswa,
						'SKSditerima'	=> $fdrMhs->sks_diakui
					); 
				}else{
					$set = array(
						'id_reg_pd'	=> $fdrMhs->id_registrasi_mahasiswa
					);
				}

				$whr = ['ID' => $mhsw->ID];
				$this->db->where($whr);
				$this->db->set($set);
				$st =	$this->db->update('_v2_mhsw');
				echo "<br>".$st;
			}
			// $data[$i]->Update = $st;
			echo "<hr/>";
			// $i++;
		}
		// echo json_encode($data);
	}
	
	/*
	public function reSendHistory($nim,$tahun_pindah)
	{
		if ($nim) {

			$mhsw = $this->db->get_where('_v2_mhsw',['nim'=>$nim])->row();

			$insert_feeder = array(
				'id_mahasiswa'							=> $mhsw->id_pd,
				'nim'												=> $mhsw->NIM,
				'id_jenis_daftar'						=> '2',
				'id_jalur_daftar'						=> '',
				'id_periode_masuk'					=> $tahun_pindah,
				'tanggal_daftar'						=> date("Y-m-d"),
				'id_perguruan_tinggi'				=> '8e5d195a-0035-41aa-afef-db715a37b8da',
				'id_prodi'									=> $this->Model_mahasiswa_pindah->getIdJurusan($mhsw->KodeJurusan),
				'sks_diakui'								=> floatval($mhsw->SKSditerima),
				'id_perguruan_tinggi_asal'	=> $mhsw->UniversitasAsal,
				'id_prodi_asal'							=> '',
				'id_pembiayaan'							=> '',
				'biaya_masuk'								=> '175000'
			);
			
			$res = $this->feeder_untad->insert('InsertRiwayatPendidikanMahasiswa',$insert_feeder);
			
			echo json_encode($res);
		}
	}
	*/
}