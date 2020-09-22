<?php
if(! defined("BASEPATH")) exit("Akses langsung tidak diperkenankan");

class ujicoba2 extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Makassar");
	}
	
	//Mahasiswa KHS
	public function nusoap2(){
		
		$nim = "F55116123";
		$tahun = "20171";
		
		$feeder = $this->feeder->getToken_feeder();
		$temp_token = $feeder['temp_token'];
		$temp_proxy = $feeder['temp_proxy'];
	
		$qkm = "select k.ID,k.Tahun,k.NIM,m.Name,m.id_reg_pd,k.Status,k.st_feeder,k.IPS,k.SKS,k.IPK,k.TotalSKS from _v2_khs k, _v2_mhsw m where k.NIM=m.NIM and k.NIM='$nim' and k.Tahun='$tahun' limit 1";
		
		$data = $this->db->query($qkm)->row();

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
				
				$sql = $this->db->query("UPDATE khs SET st_feeder='1' WHERE ID='$ID'");
				if($sql){
					echo "Data Berhasil Di import";	
				}else{
					echo "Data Berhasil di import tapi gagal di st_feeder gagal diupdate di khs";	
				}
			} elseif ($error_code!=0){
				$error_desc = $rdikti['error_desc'];
				echo $error_code."-".$error_desc." - ".json_encode($record);	
			}else{
				$sql = $this->db->query("UPDATE khs SET st_feeder='1' WHERE ID='$ID'");
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
}
?>