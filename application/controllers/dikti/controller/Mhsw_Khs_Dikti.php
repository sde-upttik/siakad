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
class Mhsw_Khs_Dikti extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
		
		$this->methods['khs_dikti_get']['limit'] = 500; // 500 requests per hour per user/key
		$this->methods['khs_dikti_post']['limit'] = 100; // 100 requests per hour per user/key
		
		$this->methods['abaikan_get']['limit'] = 500; // 500 requests per hour per user/key
		$this->methods['abaikan_post']['limit'] = 100; // 100 requests per hour per user/key
    }
	
	/*public function khs_dikti_get()
    {
    	$nim = "F55116123";
		$thn = "20172";
		
		if (!empty($nim))
        {
			$rows = $this->import_khs($nim, $thn);
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
	
	public function khs_dikti_post()
    {
        $nim = $this->post('NIM');
		$thn = $this->post('Tahun');
			
		$rows = $this->import_khs($nim, $thn);
		$data = array("tampil" => $rows);
		$this->set_response($data, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }
	
	/*public function abaikan_get()
    {
    	$nim = "F55116123";
		$thn = "20172";
		
		if (!empty($nim))
        {
			$rows = $this->abaikan_khs($thn,$nim);
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
			
		$rows = $this->abaikan_khs($nim, $thn);
		$data = array("tampil" => $rows);
		$this->set_response($data, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }
	
	
	function import_khs($nim, $thn){
		
		/*$nim = "F55116123";
		$tahun = "20171";*/
		
		$thn1=substr($thn, 0,4);
		$thn2=substr($thn, 4,1);

		if($thn2==2){
			$thn2=$thn2-1;
			$thn=$thn1.$thn2;
		}elseif($thn2==1){
			$thn1=$thn1-1;
			$thn=$thn1.'2';
		}
		
		$tahun = $thn;
		
		$feeder = $this->feeder->getToken_feeder();
		$temp_token = $feeder['temp_token'];
		$temp_proxy = $feeder['temp_proxy'];
	
		$qkm = "select k.ID,k.Tahun,k.NIM,m.Name,m.id_reg_pd,k.Status,k.st_feeder,k.IPS,k.SKS,k.IPK,k.TotalSKS from khs k, mhsw m where k.NIM=m.NIM and k.NIM='$nim' and k.Tahun='$tahun' limit 1";
		
		$data = $this->db2->query($qkm)->row();

		if($data->IPK != 0){
			$NIM = ucfirst($data->NIM);

			$record = new stdClass();
			$record->id_smt = $data->Tahun;
			$record->id_reg_pd = $data->id_reg_pd;
			$record->id_stat_mhs = $data->Status;
			$record->ips = $data->IPS;
			$record->sks_smt = $data->SKS;
			$record->ipk = $data->IPK;
			$record->sks_total = $data->TotalSKS;

			$ID = $data->ID;
			
			$table = 'kuliah_mahasiswa';
		
			// action insert ke feeder
			$action = 'InsertRecord';
			
			// insert tabel mahasiswa ke feeder
			$rdikti = $this->feeder->action_feeder($temp_token,$temp_proxy,$action,$table,$record); 

			$error_code = $rdikti['error_code'];
			if($error_code==730){
				
				$recordup = array(
					'key' => array('id_smt' => $data->Tahun,'id_reg_pd' => $data->id_reg_pd,'id_stat_mhs' => $data->Status),
					'data' => array('ips' => $data->SKS,'sks_smt' => $data->SKS,'ipk' => $data->IPK,'sks_total' => $data->TotalSKS)
				);

				$table = 'kelas_kuliah';
		
				// action insert ke feeder
				$action = 'UpdateRecord';
			
				// insert tabel mahasiswa ke feeder
				$rdiktiup = $this->feeder->action_feeder($temp_token,$temp_proxy,$action,$table,$recordup); 
				
				echo $rdiktiup['error_code']." ".$rdiktiup['error_desc'];
				
				$sql = $this->db2->query("UPDATE khs SET st_feeder='1' WHERE ID='$ID'");
				if($sql){
					echo "Data Berhasil Di import";	
				}else{
					echo "Data Berhasil di import tapi gagal di st_feeder gagal diupdate di khs";	
				}
			} elseif ($error_code!=0){
				$error_desc = $rdikti['error_desc'];
				echo $error_code."-".$error_desc." - ".json_encode($record);	
			}else{
				$sql = $this->db2->query("UPDATE khs SET st_feeder='1' WHERE ID='$ID'");
				if($sql){
					echo "Data Berhasil Di import";	
				}else{
					echo "Data Berhasil di import tapi gagal di st_feeder gagal diupdate di khs";	
				}
			}
		}else{
			echo "IPK bernilai 0 tidak dapat di import ke feeder";
		}
	}
	
	function abaikan_khs($nim, $tahun){

		$qupdate_khs = "update khs set st_abaikan='1' where NIM='$nim' and Tahun='$tahun'";

		$update_khs=mysql_query($qupdate_khs);
		if($update_khs){
			echo "Data berhasil dirubah";
		}
	}
	
}
