<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mhsw_nilai2 extends CI_Controller {

//Mengambil Model 
	function __construct(){
		parent::__construct();

		$session_user = $ulevel = $this->session->userdata("ulevel");
		if ($session_user == null) {
			 redirect('https://siakad2.untad.ac.id/menu', 'refresh');
		}

	    $this->load->model('Model_nilai_mahasiswa');
	}

//*********************************Private Controler********************************* 

//Menagmbil data jadwal berdasarkan nilai yang dinputkan dari form pencarian
	private function get_data_jadwal($semesterAkademik, $program, $jurusan)
	{
		$table 	= "_v2_jadwal";

		$fields = array(
						'_v2_jadwal.KodeMK',
						'_v2_jadwal.NamaMK',						
						'_v2_jadwal.Keterangan',
						'_v2_jadwal.IDDosen',
						'_v2_jadwal.IDJADWAL',
						'_v2_jadwal.Tahun',
						'(SELECT _v2_dosen.Name FROM _v2_dosen WHERE _v2_dosen.nip = _v2_jadwal.IDDosen) as NamaDosen'
						); 

		$where  = array(
						'_v2_jadwal.Tahun' 		=> $semesterAkademik,
						'_v2_jadwal.Program' 	=> $program,
						'_v2_jadwal.KodeJurusan'=> $jurusan,
						);

		$respon = $this->Model_nilai_mahasiswa->select_fields_where($table, $fields, $where);

		return $respon;
	}


//Mengambil semua data jurusan  
	private function get_data_jurusan()
	{
		$fields 	 = array(
							 "Kode",
							 "Nama_Indonesia"
							);

		$table 		 = "_v2_jurusan";

		$respon = $this->Model_nilai_mahasiswa->select_fields($fields, $table);

		return $respon;
	}


//*********************************Public Controler********************************* 

//Controler Default form pencarian 
	public function index() {	
		$data_jurusan 	= $this->get_data_jurusan();
		
		$data_bind  	= array(
								"data_jurusan" => $data_jurusan
								); 
		
		$this->load->view('dashbord', $data_bind);
		$this->load->view('ademik/nilai_mahasiswa/mhsw_nilai_js');
	}

//Controler untuk mengoper data jadwal untuk menampilkan tabel jadwal
	public function data_form_pencarian($semesterAkademik, $program, $jurusan)
	{

		$data_jadwal = $this->get_data_jadwal($semesterAkademik, $program, $jurusan);
		
		$data_bind   = array(
							'data_jadwal' => $data_jadwal,
							);

		$this->load->view('ademik/nilai_mahasiswa/tabel_matakuliah', $data_bind);
	}

//Controler Menampilkan data nilai mahasiswa berdasarkan jadwal matakuliah 
	public function get_nilai_mahasiswa()
	{
		$idjadwal 	= $_POST['idjadwal'];  
		$tahun 	  	= $_POST['tahun'];  

		$tabel 		= "_v2_krs".$tahun;

		$fields 	= array(
							$tabel.".NIM",
							$tabel.".Hadir",
							$tabel.".Bobot",
							$tabel.".GradeNilai",
							$tabel.".useredt",
							$tabel.".tgledt",
							'(SELECT _v2_mhsw.Name FROM _v2_mhsw WHERE _v2_mhsw.NIM ='.$tabel.'.NIM) as NamaMahasiswa'
							); 

		$where 		= array(
							'IDJADWAL' => $idjadwal
							);

		$data_nilai_mahasiswa = $this->Model_nilai_mahasiswa->select_fields_where($tabel, $fields, $where);

		$data_bind 	= array(
							'data_nilai_mahasiswa' => $data_nilai_mahasiswa 
						   );

		$data = $this->load->view('ademik/nilai_mahasiswa/tabel_nilai_mahasiswa', $data_bind, TRUE);

		$this->output->set_output($data); 
	}
	
}