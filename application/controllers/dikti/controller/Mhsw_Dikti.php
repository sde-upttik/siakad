<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Mhsw_Dikti extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		date_default_timezone_set("Asia/Makassar");
		//$this->load->library('Nusoap_library');

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
		
		$this->methods['import_mhs_get']['limit'] = 500; // 500 requests per hour per user/key
		$this->methods['import_mhs_post']['limit'] = 100; // 100 requests per hour per user/key
    }
	
	/*public function import_mhs_get()
    {
    	$nim = "F55116123";
		
		if (!empty($nim))
        {
			$rows = $this->import_mhsw_feeder($nim);
			$data = array("tampil" => $rows);
			$this->set_response($data, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }*/
	
	public function import_mhs_post()
    {
        $nim = $this->post('NIM');
			
		$rows = $this->import_mhsw_feeder($nim);
		$data = array("tampil" => $rows);
		$this->set_response($data, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }
	
	function import_mhsw_feeder($nim){
		
		//$nim = "O27116095";
	
		$feeder = $this->feeder->getToken_feeder();
		$temp_token = $feeder['temp_token'];
		$temp_proxy = $feeder['temp_proxy'];

		$NIM=str_replace(" ","",$nim);

		$_sql = "select m.*,p.id_sms from mhsw m,jurusan p where m.KodeJurusan=p.Kode and m.NIM='$NIM'";
		$w = $this->db2->query($_sql)->row();
	
		$usrid = $w->ID;
		$nama = $w->Name;
		$NIK = $w->NIK;
		$jenis_pendaftaran = $w->StatusAwal;
	
		if($jenis_pendaftaran=="P") $jenis_pendaftaran=2;
		else $jenis_pendaftaran=1;

		$tgl_daftar = $w->Tanggal;
		$prodi = $w->id_sms;
		$periode_daftar = $w->Semester;
		$Status = $w->Status;
		
		$NamaOT = $w->NamaOT;
		$NamaIbu = $w->NamaIbu;
		$jk = $w->Sex;
		$tempat = $w->TempatLahir;
		$tgl_lhr = $w->TglLahir;
		$agama = $w->Agama;
		
		if($Status=="U") $Status="A";

		$SKSditerima = round($w->SKSditerima);
		$ProdiAsal = $w->ProdiAsal;
		$UniversitasAsal = $w->UniversitasAsal;
		$StatusAwal = $w->StatusAwal;
		$id_sms = $w->id_sms;
		
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
		
		//echo json_encode($record);
		
		$table = 'mahasiswa';
		
		// action insert ke feeder
		$action = 'InsertRecord';
		
		// insert tabel mahasiswa ke feeder
		$datb = $this->feeder->action_feeder($temp_token,$temp_proxy,$action,$table,$record); 
		
		//var_dump($datb); // kegunaan untuk memunculkan tampilan error, tanpa mengendintifikasi nilai bolean, string, integer atau lain-lain
		$id_pd = null;
		//$datb = $resultb['result'];
		
		
		$error_code = $datb['error_code'];
		$error_desc = $datb['error_desc'];
		
		// error 200 desc : Mahasiswa dengan nama, tempat, tanggal lahir dan ibu kandung yang sama sudah ada (panjang string 80)
		if ($error_code != 200) $id_pd = $datb['id_pd'];
		
		if ($id_pd != null){
			$qupdate = "update mhsw set id_pd='$id_pd' where NIM='$nim'";
			$this->db2->query($qupdate);
			
			if ($periode_daftar < '20091') $periode_daftar = '20161';

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
			
			//echo json_encode($record_pt);
			
			$resultb_pt = $proxy->InsertRecord($token, "mahasiswa_pt", json_encode($record_pt));
			var_dump($resultb_pt);
			$datb_pt = $resultb_pt['result'];
			
			$id_reg_pd = $datb_pt['id_reg_pd'];
			if ($id_reg_pd != null)
			{
				$qupdate = "update mhsw set id_reg_pd='$id_reg_pd',st_feeder=1 where NIM='$nimd'";
				$this->db2->query($qupdate);
				echo "db -> Success";
			} else {
				echo "belum ada REG PD 11111111";
			}
		} else {
			if ($error_code == '200'){
				/* sepertinya ini tidak berfungsi karena hanya mengambil id reg pd dari feeder, seharusnya id reg pd di ambil dari data base siakad
				$resultcek = $temp_proxy->GetRecord($temp_token, "mahasiswa", "nm_pd like '%$nim%' and tgl_lahir='$tgl_lhr' and tmpt_lahir like '%$tempat%'");
				var_dump($resultcek);
				$datcek = $resultcek['result'];
				$id_pd = $datcek['id_pd'];*/
				
				$record_pt = new stdClass();
				$record_pt->nipd = $nimd;
				
				$id_pd = $this->feeder->getData('mhsw', 'NIM', $NIM, 'id_pd');
				
				$record_pt->id_pd = $id_pd->id_pd;
				
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
				
				//var_dump($datb_pt); // kegunaan untuk memunculkan tampilan error, tanpa mengendintifikasi nilai bolean, string, integer atau lain-lain
				
				$error_code1 = $datb_pt['error_code'];
				$error_desc1 = $datb_pt['error_desc'];
				
				$id_reg_pd = null;
				
				// error 211 desc : Mahasiswa ini sudah terdaftar (panjang string 29)
				if ($error_code1 != 211) $id_reg_pd = $datb_pt['id_reg_pd'];
				
				if ($id_reg_pd != null)
				{
					$qupdate = "update mhsw set id_reg_pd='$id_reg_pd',st_feeder=1 where NIM='$nimd'";
					$this->db2->query($qupdate);
					echo "db -> Success";
				} else {
					echo "belum ada REG PD 22222222".$error_code1." deskripsi ".$error_desc1;
				}
			} else {
				echo $error_code." ".$error_desc;
			}
		}
	}
	
}
