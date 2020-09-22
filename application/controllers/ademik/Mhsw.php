<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

class Mhsw extends CI_Controller {

	private $limit;

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->helper('security');
	    $this->load->model('mhsw_model');
	    $this->load->model('profil_model');
	}

	public function index() {

		$level = $this->session->userdata('ulevel');
		$dataKode = $this->userKode();

		$data['jurusan'] = $this->mhsw_model->get_dataSearch($level,$dataKode);
		$data['webpage'] = 'dataMhsw';

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
	
	public function dataTabelMhsw() {

		$config = array(
			array(
				'field' => 'dataSearch',
				'label' => 'Jurusan',
				'rules' => 'required|max_length[100]',
				'errors' => array(
					'required' => ' Anda Belum Memilih %s, Silakan Pilih %s yang Anda Ingin Tampilkan',
					'max_length' => '%s Maksimal 100 Karakter',
				)
			),
			array(
				'field' => 'tahunakademik',
				'label' => 'Tahun Angkatan',
				'rules' => 'required|exact_length[4]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'exact_length' => '%s Harus 4 Angka',
				)
			),
		);

		$this->form_validation->set_rules($config);

		$level = $this->session->userdata('ulevel');
		$dataKode = $this->userKode();
		$kodeJurusan = $this->security->xss_clean($this->input->post('dataSearch'));
		$tahunAkademik = $this->security->xss_clean($this->input->post('tahunakademik'));

		if ( $this->form_validation->run() == FALSE ) {

			$dataError = validation_errors();
			$pesan = json_encode($dataError);

			$data['error'] = $pesan;
			$data['jurusan'] = $this->mhsw_model->get_dataSearch($level,$dataKode);
			$data['webpage'] = 'dataMhsw';

			$this->load->view('dashbord',$data);

		} else {

			$aksi = $this->mhsw_model->get_dataTabelMhsw($kodeJurusan,$tahunAkademik);

			if ( $aksi == TRUE ) {

				$data['dataTabel'] = $aksi;
				$data['jurusan'] = $this->mhsw_model->get_dataSearch($level,$dataKode);
				$data['webpage'] = 'dataMhsw';

				$this->load->view('dashbord',$data);

			} else {

				$data['jurusan'] = $this->mhsw_model->get_dataSearch($level,$dataKode);
				$data['webpage'] = 'dataMhsw';
				$data['footerSection'] = "<script type='text/javascript'>
	 				swal({   
						title: 'Pemberitahuan',   
						type: 'warning',    
						html: true, 
						text: 'Data Mahasiswa Tidak Ditemukan',
						confirmButtonColor: '#f7cb3b',   
					});
			    </script>";

				$this->load->view('dashbord',$data);

			}

		}

	}

	public function biodataMhsw($nim) {

		$kode = $this->userKode();

		if ( $this->session->userdata('ulevel') == 5 ) {
			$data['dataDosen'] = $this->profil_model->getDataDosen('kodeFakultas',$kode);
		} elseif ( $this->session->userdata('ulevel') == 7 ) {
			$data['dataDosen'] = $this->profil_model->getDataDosen('kodeJurusan',$kode);
		} else {
			$data['dataDosen'] = $this->profil_model->getDataDosen('kodeJurusan',$kode);
		}

		$data['dataProfil'] = $this->profil_model->getDataTabelJoinMhsw('_v2_mhsw',$nim);
		$data['dataAgama'] = $this->profil_model->getDataAgama();
		$data['dataNegara'] = $this->profil_model->getDataNegara();
		$data['dataAlat'] = $this->profil_model->getDataAlat();
		$data['dataTinggal'] = $this->profil_model->getDataTinggal();
		$data['webpage'] = 'biodataMhsw';
		$data['kodeFakultas'] = substr($nim, 0, 3);
		if( !empty($data['dataProfil']->Kewarganegaraan) ) {
			$data['dataWilayah'] = $this->profil_model->getDataWilayah($data['dataProfil']->Kewarganegaraan);
		}

		$this->load->view('dashbord',$data);

		/*$this->load->view('temp/head');
		$this->load->view('ademik/profil',$data);
		$this->load->view('temp/footers');*/

	}

	public function get_wilayah() {
		
		$kode_negara = $this->input->post('kode');
		$data=$this->profil_model->getDataWilayah($kode_negara);

        echo json_encode($data);

	}

	public function kirimBiodata() {
		$feeder = $this->feeder->getToken_feeder();
		$temp_token = $feeder['temp_token'];
		$temp_proxy = $feeder['temp_proxy'];

		$nim=$this->input->post('nim');
		$NIM=str_replace(" ","",$nim);

		$dataFeeder = $this->mhsw_model->getMhswFeeder($NIM);
		$usrid = $dataFeeder->ID;

		$nama = $dataFeeder->Name;
		$NIK = $dataFeeder->NIK;

		$jenis_pendaftaran = $dataFeeder->StatusAwal;
		if($jenis_pendaftaran=="P") $jenis_pendaftaran=2;
		else $jenis_pendaftaran=1;

		$tgl_daftar = $dataFeeder->Tanggal;
		$prodi = $dataFeeder->id_sms;
		$periode_daftar = $dataFeeder->Semester;
		$Status = $dataFeeder->Status;
		if($Status=="U") $Status="A";

		$SKSditerima = round($dataFeeder->SKSditerima);

		$UniversitasAsal = $dataFeeder->UniversitasAsal;
		$StatusAwal = $dataFeeder->StatusAwal;
		$id_sms = $dataFeeder->id_sms;

		$NamaOT = $dataFeeder->NamaOT;
		$NamaIbu = $dataFeeder->NamaIbu;
		$jk = $dataFeeder->Sex;
		$tempat = $dataFeeder->TempatLahir;
		$tgl_lhr = $dataFeeder->TglLahir;

		$agama = $dataFeeder->AgamaID;
		$nimd = $NIM;

		$record = new stdClass();
		$record->nm_pd = $nama;
		$record->jk = $jk;
		$record->tmpt_lahir = $tempat;
		$record->tgl_lahir = $tgl_lhr;
		$record->nik = $NIK;
		$record->id_wil = "186000";
		$record->ds_kel = "Tondo";
		$record->nm_ibu_kandung = $NamaIbu;
		$record->nm_ayah = $NamaOT;
		$record->id_agama = $agama;
		$record->id_kk = 0;
		$record->id_sp = "8e5d195a-0035-41aa-afef-db715a37b8da";
		$record->id_wil = "186000";
		$record->a_terima_kps = "0";
		$record->stat_pd = $Status;
		$record->id_kebutuhan_khusus_ayah = "0";
		$record->id_kebutuhan_khusus_ibu = "0";
		$record->kewarganegaraan = "ID";

		$table = 'mahasiswa';

		// action insert ke feeder
		$action = 'InsertRecord';

		// insert tabel mahasiswa ke feeder
		$datb = $this->feeder->action_feeder($temp_token,$temp_proxy,$action,$table,$record);

		//$id_pd = null;
		//print_r($datb);
		if(isset($datb['id_pd'])) {
			$id_pd = $datb['id_pd'];
		}else{
			$id_pd = null;
		}
		$error_code = $datb['error_code'];
		$error_desc = $datb['error_desc'];

		if ($id_pd != null) {
			$this->mhsw_model->updateIdPd($id_pd, $nim);

			if ($periode_daftar < '20091') $periode_daftar = '20161';

			// Mahasiswa PT

			$record_pt = new stdClass();
			$record_pt->nipd = $nim;
			$record_pt->id_pd = $id_pd;
			$record_pt->tgl_masuk_sp = $tgl_daftar;
			$record_pt->id_jns_daftar = $jenis_pendaftaran;
			$record_pt->mulai_smt = $periode_daftar;
			$record_pt->id_sp = "8e5d195a-0035-41aa-afef-db715a37b8da";
			$record_pt->id_sms = $id_sms;
			$record_pt->a_pernah_paud = 0;
			$record_pt->a_pernah_tk = 0;

			$table1 = 'mahasiswa_pt';

			// action insert ke feeder
			$action1 = 'InsertRecord';

			// insert tabel mahasiswa ke feeder
			$resultb_pt = $this->feeder->action_feeder($temp_token,$temp_proxy,$action1,$table1,$record_pt);

			$datb_pt = $resultb_pt['result'];
			$id_reg_pd = $datb_pt['id_reg_pd'];
			if ($id_reg_pd != null) {
				$data = array('id_reg_pd' => $id_reg_pd, 'st_feeder' => "1", 'nimd' => $nimd);
				$update_mhsw=$this->mhsw_model->save_mhsw_reg_pd($data);

				if($update_mhsw){
					$data['status']="feeder";
					$data['msg']="Data Berhasil di update";

					echo json_encode($data);
				}
			}else{
				$data['status']="error_feeder";
				$data['msg']="Belum ada REG PD";
				
				echo json_encode($data);
			}
		}elseif ($error_code == '200'){
			$record_pt = new stdClass();
			$record_pt->nipd = $nimd;

			$qId_pd = $this->mhsw_model->getIdPd($NIM);

			$record_pt->id_pd = $qId_pd->id_pd;

			$record_pt->tgl_masuk_sp = $tgl_daftar;
			$record_pt->id_jns_daftar = $jenis_pendaftaran;
			$record_pt->mulai_smt = $periode_daftar;
			$record_pt->id_sp = "8e5d195a-0035-41aa-afef-db715a37b8da";
			$record_pt->id_sms = $id_sms;
			$record_pt->a_pernah_paud = 0;
			$record_pt->a_pernah_tk = 0;

			//echo json_encode($record_pt);

			$table = 'mahasiswa_pt';

			// action insert ke feeder
			$action = 'InsertRecord';

			// insert tabel mahasiswa ke feeder
			$datb_pt = $this->feeder->action_feeder($temp_token,$temp_proxy,$action,$table,$record_pt);

			$error_code1 = $datb_pt['error_code'];
			$error_desc1 = $datb_pt['error_desc'];

			$id_reg_pd = null;

			// error 211 desc : Mahasiswa ini sudah terdaftar (panjang string 29)
			if ($error_code1 != 211) $id_reg_pd = $datb_pt['id_reg_pd'];

			if ($id_reg_pd != null)
			{
				$data = array('id_reg_pd' => $id_reg_pd, 'st_feeder' => "1", 'nimd' => $nimd);
				$update_mhsw=$this->mhsw_model->save_mhsw_reg_pd($data);

				if($update_mhsw){
					$data['status']="feeder";
					$data['msg']="Data Berhasil di update";

					echo json_encode($data);
				}
			} else {
				$data['status']="error_feeder";
				$data['msg']="Belum ada REG PD";
				
				echo json_encode($data);
			}
		}else{
			$data['status']="error_feeder";
			$data['msg']="Data Error ".$error_code." ".$error_desc;
			
			echo json_encode($data);
		}
	}

}