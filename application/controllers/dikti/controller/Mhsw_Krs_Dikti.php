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
class Mhsw_Krs_Dikti extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->db2 = $this->load->database('siakadweb', TRUE);

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
		
		$this->methods['krs_dikti_get']['limit'] = 500; // 500 requests per hour per user/key
		$this->methods['krs_dikti_post']['limit'] = 100; // 100 requests per hour per user/key
		
		$this->methods['abaikan_get']['limit'] = 500; // 500 requests per hour per user/key
		$this->methods['abaikan_post']['limit'] = 100; // 100 requests per hour per user/key
    }
	
	/*public function krs_dikti_get()
    {
    	$ID_KRS = "5104";
		$thn = "20172";
		
		if (!empty($nim))
        {
			$rows = $this->import_krs_feeder($ID_KRS, $thn);
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
	
	public function krs_dikti_post()
    {
        $ID_KRS = $this->post('id_krs');
		$thn = $this->post('Tahun');
			
		$rows = $this->import_krs_feeder($ID_KRS, $thn);
		$data = array("tampil" => $rows);
		$this->set_response($data, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }
	
	/*public function abaikan_get()
    {
    	$nim = "F55116123";
		$thn = "20172";
				
		if (!empty($nim))
        {
			$rows = $this->abaikan_krs($thn,$nim);
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
	
	public function abaikan_post()
    {
        $nim = $this->post('NIM');
		$thn = $this->post('Tahun');
					
		$rows = $this->abaikan_krs($nim, $thn);
		$data = array("tampil" => $rows);
		$this->set_response($data, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }
	
	
	function import_krs_feeder($ID_KRS, $thn){
		/*$ID_KRS = "5104";
		$thn = "20171";*/
		
		$thn1=substr($thn, 0,4);
		$thn2=substr($thn, 4,1);

		if($thn2==2){
			$thn2=$thn2-1;
			$thn=$thn1.$thn2;
		}elseif($thn2==1){
			$thn1=$thn1-1;
			$thn=$thn1.'2';
		}
		
		$feeder = $this->feeder->getToken_feeder();
		$temp_token = $feeder['temp_token'];
		$temp_proxy = $feeder['temp_proxy'];
	
		if($thn != '20161'){
			$tbl = "krs$thn";
		} else {
			$tbl = "krs";
		}
		
		$query = "select j.id_kelas_kuliah as id_kls,j.IDJADWAL,m.id_reg_pd,m.NIM,n.ID as IDKRS,n.nilai as nilai_angka,n.GradeNilai as nilai_huruf,n.Bobot as nilai_indeks from jadwal j, mhsw m,$tbl n where j.IDJADWAL=n.IDJADWAL and n.ID='$ID_KRS' and n.NIM=m.NIM order by n.NIM";
		
		//echo $query;
		
		$row = $this->db2->query($query)->result();

		foreach ($row as $w){
			$IDKRS = $w->IDKRS;
			$id_kls = $w->id_kls;
			$id_reg_pd = $w->id_reg_pd;
			$NIM = $w->NIM;
			$nil_ang = $w->nilai_angka;
			$nil_huruf = $w->nilai_huruf;
			$nil_indeks = $w->nilai_indeks;
			
			//echo $id_reg_pd;
			
			$record = new stdClass();
			$record->id_kls = $id_kls;
			$record->id_reg_pd = $id_reg_pd;
			$record->asal_data = "9";
			$record->nilai_angka = $nil_ang;
			$record->nilai_huruf = $nil_huruf;
			$record->nilai_indeks = $nil_indeks;

			$table = 'nilai';
		
			// action insert ke feeder
			$action = 'InsertRecord';
			
			// insert tabel mahasiswa ke feeder
			//$resultb = $temp_proxy->InsertRecord($temp_token, "nilai", json_encode($record));
			$datb = $this->feeder->action_feeder($temp_token,$temp_proxy,$action,$table,$record); 
			
			//var_dump($datb);
			
			$error_code = $datb['error_code'];
			$error_desc = $datb['error_desc'];
			
			//echo "- $error_code dan $error_desc -";
			
			if($error_code == 0){
				$qupdate = "update $tbl set st_feeder=3 where ID='$IDKRS'";
				$this->db2->query($qupdate);
				echo "Berhasil Diinput";
			}else if($error_code == 800){
				$recordup = array(
					'key' => array('id_kls' => $id_kls,'id_reg_pd' => $id_reg_pd),
					'data' => array('asal_data' => "9",'nilai_angka' => $nil_ang,'nilai_huruf' => $nil_huruf,'nilai_indeks' => $nil_indeks)
				);
				
				$table = 'nilai';
		
				// action insert ke feeder
				$action = 'UpdateRecord';
			
				// insert tabel mahasiswa ke feeder
				$datarec = $this->feeder->action_feeder($temp_token,$temp_proxy,$action,$table,$recordup); 

				$error_code1 = $datarec['error_code'];
				$error_desc1 = $datarec['error_desc'];

				if($error_code1 == 0){
					$qupdate = "update $tbl set st_feeder=4 where ID='$IDKRS'";
					$this->db2->query($qupdate);
					echo "Data Sudah Pernah Terinput";
				}else{
					echo "Data gagal Update ".$error_code1." ".$error_desc1;
				}
			} else {
				print_r($datb);
				$qupdate = "update $tbl set st_feeder=-3 where ID='$IDKRS'";
				$this->db2->query($qupdate);
				echo "Gagal ".$error_code." - ".$error_desc;
			}
		}
	}
	
	function abaikan_krs($id, $thn){

		if($thn!='20161'){
			$tbl = "krs$thn";
		} else {
			$tbl = "krs";
		}

		$qupdate_krs = "update $tbl set st_abaikan='1' where ID='$ID_KRS'";

		$update_krs=mysql_query($qupdate_krs);
		if($update_krs){
			echo "Data berhasil dirubah";
		}
	}
	
}
