<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perwalian_admin extends CI_Controller {

	private $page = "ademik/perwalian_admin/";

//setup library or helper 
	function __construct(){
		parent::__construct();
	    
	    $this->load->model('Perwalian_admin_model');
		$this->load->helper('addtional');
		$this->load->library('authenticate');
		$this->load->library('counter'); 

		date_default_timezone_set("Asia/Makassar");

		$this->authenticate->checkSession();
	}

//controler untuk halaman utama Perwalian Admin 
	public function index(){

		$view  		= $this->page."tabel_mahasiswa_wali";
		$unip 		= $this->session->userdata("unip");

		$data['mahasiswa_wali']  = $this->Perwalian_admin_model->getMahasiswaWali(semester_aktif(),$unip);

		call_view(false, $view ,$data, true);
	}

 
// Menampilkan detail Matakuliah Mahasiswa Wali
	public function form_mahasiswa_wali()
	{
		$nim 	  		= $this->input->post('NIM', true);
		$tahun 	  		= $this->input->post('Tahun');
		$name 	  		= $this->input->post('Name');
		$semester_khs 	= $this->khs_semester_sebelumnya($tahun);

		$data_khs 		= $this->Perwalian_admin_model->getKhs($nim, $semester_khs);
		$data_krs 		= $this->Perwalian_admin_model->getKrs($nim, $tahun);

		$limitKrs 		= limitKrs(getMajorCollege($nim), $tahun);

		$batas_krs 		= $limitKrs[0]['krsm']." Sampai ".$limitKrs[0]['krss'];
		$batas_ubah_krs = $limitKrs[0]['ukrsm']." Sampai ".$limitKrs[0]['ukrss'];

		$data_bind = array(
							'data_khs'			  => $data_khs,
							'data_krs' 			  => $data_krs,
							'data_nama_mahasiswa' => $name,
							'Tahun'  			  => $tahun,
							'batas_krs'  		  => $batas_krs,
							'batas_ubah_krs'  	  => $batas_ubah_krs
						   );

		return $this->load->view('ademik/perwalian_admin/form_mahasiswa_wali', $data_bind);
	}


	public function validasi_mk()
	{
		$tahun 			= $this->input->post('tahun', true);
		$nim 			= $this->input->post('nim', true);
		$KodeMK 		= $this->input->post('KodeMK', true);
		$idJadwal 		= $this->input->post('idjadwal', true);
		$st_wali 		= $this->input->post('st_wali', true);
		$unip_wali 		= $this->session->userdata("unip", true );

		if($st_wali && $this->counter->checkCapacityClass($idJadwal,$tahun)=="full"){
			debug($this->counter->checkCapacityClass($idJadwal,$tahun));
		}
		else{
			$response 		= $this->Perwalian_admin_model->validasiMK($tahun, $nim, $KodeMK, $st_wali, $unip_wali);
		}
	} 


	private function khs_semester_sebelumnya($Tahun)
	{
		$tahun_sebelumnya 	=  substr($Tahun, 0, 4);
		$semester 			=  substr($Tahun, 4, 5);

		if ($semester == 1) {
			$semester = 2; 
		}
		elseif($semester == 2){
			$semester = 1;
		}


		// echo $tahun_sebelumnya . "<br>";
		return ($tahun_sebelumnya - 1).$semester;
	} 

}