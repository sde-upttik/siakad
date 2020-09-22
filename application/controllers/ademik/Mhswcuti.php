<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mhswcuti extends CI_Controller {

	function __construct(){
		parent::__construct();
	    $this->load->model('Mhswcuti_model');
	}

	public function index(){
		$this->load->view('dashbord');
	}

	public function search(){
		$nim 	= $this->input->post('nim');
		$data   = $this->Mhswcuti_model->caridata($nim);
		$data1	= $this->Mhswcuti_model->datadaftar($nim);
		$dosen 	= $this->Mhswcuti_model->datadosen();
		$paket 	= array('data'=>$data, 'data1'=>$data1, 'dosen'=>$dosen);
		
			$this->load->view('temp/head');
			$this->load->view('ademik/mhswcuti',$paket);
			$this->load->view('temp/footers');
			
	}

	public function daftar_mhsw_cuti(){
		$data 	= $this->Mhswcuti_model->get_mhsw_cuti();
		$paket  = array('data'=>$data);

				$this->load->view('temp/head');
				$this->load->view('ademik/mhswcuti_lihat_daftar', $paket);
				$this->load->view('temp/footers');
		
	}

	public function simpan(){

		$nim 				= $_POST['nim'];
		$nama 				= $_POST['nama'];
		$priode_cuti 		= $_POST['priode_cuti'];
		$jml_smtr_cuti 		= $_POST['jml_smtr_cuti'];
		$tgl_mulai_cuti 	= $_POST['tgl_mulai_cuti'];
		$tgl_selesai_cuti	= $_POST['tgl_selesai_cuti'];
		$pejabat_ttp 		= $_POST['pejabat_ttp'];
		$alasan 			= $_POST['alasan'];
		$pngung_jwb_akdmik 	= $_POST['pngung_jwb_akdmik'];

		
		$aray = array ('20151','20152','20161','20162','20171','20172','20181','20182');
		for ($a=0; $a<sizeof($aray); $a++){
			if ($aray[$a]=="$priode_cuti"){
				break;
			} 
		}
		
		if ($jml_smtr_cuti== 0 ){
			$jml_smtr_cuti=1;
		}
		$akhir = $a+$jml_smtr_cuti-1;
		//echo "<br>awal $a dan akhir $akhir";

		$string="";
		for ($a=$a; $a <= $akhir; $a++){
			$qr = "select * from _v2_khs where NIM = '$nim' and Tahun='$aray[$a]'";
			$nums = $this->Mhswcuti_model->getNumRows($qr);
			if ($nums == 0){
				$ins_khs = "INSERT INTO `_v2_khs` (`ID`, `NIM`, `Tahun`, `Sesi`, `Status`, `Registrasi`, `TglRegistrasi`) VALUES (NULL, '$nim', '$aray[$a]', '0', 'C', 'Y', NOW())";
				$this->Mhswcuti_model->insertquery($ins_khs);
				
			} else {
				$ins_khs = "Update `_v2_khs` set `Status` = 'C' where NIM='$nim' and Tahun='$aray[$a]'";
				$this->Mhswcuti_model->insertquery($ins_khs);
			
			}
			
			if ($ins_khs){
			$up_mhsw = "Update _v2_mhsw set status='C' where NIM='$nim'";
			$this->Mhswcuti_model->insertquery($up_mhsw);
			
			$unip=$this->session->unip;
			$string = "INSERT INTO _v2_riwayat_cuti (`NIM`,`periode`, `j_cuti` , `smt_mulai_cuti`, `smt_akhir_cuti`, `pej_tetap` , `alasan`, `pen_akademik`, `user_input`, `tgl_input`) values ('$nim','$aray[$a]','$jml_smtr_cuti','$tgl_mulai_cuti','$tgl_selesai_cuti','$pejabat_ttp','$alasan','$pngung_jwb_akdmik','$unip',NOW())";

			$this->Mhswcuti_model->insertquery($string);
			
			}

			
			
		}
		$this->daftar_mhsw_cuti();


		
	}
}