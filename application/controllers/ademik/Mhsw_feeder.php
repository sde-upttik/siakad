<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mhsw_feeder extends CI_Controller {

	function __construct() {
		parent::__construct();
	    $this->load->model('sinkron_db');
	}

	public function index(){
		$this->tampil();
	}

	//_____________________________________________________________________________________//
	
	public function get_data(){
		$data = $this->sinkron_db->sykn_siakad_lama();
		return $data;
	}

	public function tampil(){
		$terserah_tampil 			= $this->get_data();
		$data 						= array('terserah_tampil' => $terserah_tampil);
			
					$content 		= $this->session->userdata('sess_tamplate');
								   	  $this->load->view('temp/head');
								   	  $this->load->view($content, $data);
								      $this->load->view('temp/footers');

	}

	public function insert_data(){
		$id_akt_mhs 		= $_POST['id_akt_mhs'];
    	$id_smt 	 		= $_POST['id_smt'];
	    $judul_akt_mhs 		= $_POST['jdl_akt_mhs'];
	    $lokasi_kegiatan	= $_POST['lks_kgt'];
	    $sk_tugas 			= $_POST['sk_tgs'];
	    $tgl_sk_tugas 		= $_POST['tgl_sk_tgs']; 
	    $ket_akt 			= $_POST['ket_akt']; 
	    $a_komunal 			= $_POST['a_komunal'];
	    $id_jns_akt_mhs 	= $_POST['id_jns_akt_mhs']; 
	    $id_sms 			= $_POST['id_sms'];

	    $data_insert = array(

	    					'id_akt_mhs' 		=> $id_akt_mhs,
	    					'id_smt'			=> $id_smt,
	    					'judul_akt_mhs' 	=> $judul_akt_mhs,
	    					'lokasi_kegiatan'	=> $lokasi_kegiatan,
	    					'sk_tugas' 			=> $sk_tugas,
	    					'tgl_sk_tgs' 		=> $tgl_sk_tugas,
	    					'ket_akt' 			=> $ket_akt,
	    					'a_komunal'			=> $a_komunal,
	    					'id_jns_akt_mhs'	=> $id_jns_akt_mhs,
	    					'id_sms'			=> $id_sms

	    );

	    $res = $this->sinkron_db->simpan_data('aktivitas_mahasiswa',$data_insert);
    	if($res >= 1) {
    		echo "Berhasil";
    	}else{
    		echo "Data Tidak Tersimpan";
    	}

	}

	

}