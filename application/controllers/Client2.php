<?php
if(! defined("BASEPATH")) exit("Akses langsung tidak diperkenankan");

class Client2 extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Makassar");
	}
	
	public function nusoap(){		
		$url = $this->config->item('url_feeder'); // gunakan live bila sudah yakin

		$client = new nusoap_client($url, true);

		// Mendapatkan Token

		$username = $this->config->item('user_feeder');
		$password = $this->config->item('password_feeder');
		
		$temp_proxy = $client->getProxy();
        $temp_error = $client->getError();
        if ($temp_proxy == NULL) {
			echo "Null Fandu $temp_error<br>";
        } else {
            $temp_token = $temp_proxy->GetToken($username, $password);
			if ($temp_token == 'ERROR: username/password salah') {
				echo "Error Fandu $temp_token<br>";
			} else {
				//$this->db->query("SELECT k.NIM, k.Tahun, k.Sesi, m.KodeFakultas, m.KodeJurusan, m.KodeProgram, m.TahunAkademik, k.SKS, k.IPS, k.IPK, k.TotalSKS, k.Status, k.stprc, m.Name, m.id_reg_pd, k.SKSLulus, k.TotalSKSLulus FROM khs k, mhsw m WHERE k.NIM = m.NIM AND k.NIM =  'O27116095' AND k.Tahun =  '20162' AND k.st_feeder =  '0'");
				//$this->import_khs_feeder('O27116095','20162',$temp_proxy);
				
				//////////////////// batas atas
				
				
				$qkm = $this->db->query("select k.ID,k.Tahun,k.NIM,m.Name,m.id_reg_pd,k.Status,k.st_feeder,k.IPS,k.SKS,k.IPK,k.TotalSKS from _v2_khs k,_v2_mhsw m where k.NIM=m.NIM and k.NIM='O27116095' and k.Tahun='20162' limit 1")->row();
		if($qkm->IPK != 0){
			$NIM = ucfirst($qkm->NIM);

			$record = new stdClass();
			$record->id_smt=$qkm->Tahun;
			$record->id_reg_pd=$qkm->id_reg_pd;
			$record->id_stat_mhs=$qkm->Status;
			$record->ips=$qkm->IPS;
			$record->sks_smt= $qkm->SKS;
			$record->ipk=$qkm->IPK;
			$record->sks_total=$qkm->TotalSKS;
		
			$table = 'kuliah_mahasiswa';
			echo "fandu json1 -- ".json_encode($record)."<br>";

			$ID = $qkm->ID;
			$result = $temp_proxy->InsertRecord($temp_token, $table, json_encode($record));
        
			//var_dump($result);
			$rdikti = $result['result'];

			$error_code = $rdikti['error_code'];
			if($error_code==730){
				$recordup = array(
					'key' => array('id_smt' => "$qkm->Tahun",'id_reg_pd' => "$qkm->id_reg_pd",'id_stat_mhs' => "$qkm->Status"),
					'data' => array('ips' => "$qkm->SKS",'sks_smt' => "$qkm->SKS",'ipk' => "$qkm->IPK",'sks_total' => "$qkm->TotalSKS")
				);
				echo "fandu json2 -- ".json_encode($recordup);

				$resultup = $temp_proxy->UpdateRecord($temp_token, 'kelas_kuliah', json_encode($recordup));
				$rdiktiup = $resultup['result'];
				echo "fandu json3 -- ".$rdiktiup['error_code']." ".$rdiktiup['error_desc'];
			
				$sql = $this->db->query("UPDATE _v2_khs SET st_feeder='1' WHERE ID='$ID'");
				if($sql){
					echo "Data Berhasil Di import";	
				}else{
					echo "Data Berhasil di import tapi gagal di st_feeder gagal diupdate di khs";	
				}
			} elseif($error_code!=0){
				$error_desc = $rdikti['error_desc'];
				echo $error_code."-".$error_desc." - ".json_encode($record);	
			} else{
				$sql = $this->db->query("UPDATE _v2_khs SET st_feeder='1' WHERE ID='$ID'");
				if($sql){
					echo "Data Berhasil Di import";	
				}else{
					echo "Data Berhasil di import tapi gagal di st_feeder gagal diupdate di khs";	
				}
			}
		}else{
			echo "IPK bernilai 0 tidak dapat di import ke feeder";
		}
		
		///////////////////////// batas bawah
				
				
				//echo "Msasuk Fandu $temp_token<br>";
			}
		}
	}
	
	/* fandu pindahkan function import_khs_feeder($nim, $tahun, $token){
		$qkm = $this->db->query("select k.ID,k.Tahun,k.NIM,m.Name,m.id_reg_pd,k.Status,k.st_feeder,k.IPS,k.SKS,k.IPK,k.TotalSKS from _v2_khs k,_v2_mhsw m where k.NIM=m.NIM and k.NIM='O27116095' and k.Tahun='20162' limit 1")->row();
		if($qkm->IPK != 0){
			$NIM = ucfirst($qkm->NIM);

			$record = array();
			$record['id_smt']=$qkm->Tahun;
			$record['id_reg_pd']=$qkm->id_reg_pd;
			$record['id_stat_mhs']=$qkm->Status;
			$record['ips']=$qkm->IPS;
			$record['sks_smt']= $qkm->SKS;
			$record['ipk']=$qkm->IPK;
			$record['sks_total']=$qkm->TotalSKS;

			$table = 'kuliah_mahasiswa';
			echo "fandu json1 -- ".json_encode($record)."<br>";

			$ID = $qkm->ID;
			$result = $proxy->InsertRecord($token, $table, json_encode($record));
        
			//var_dump($result);
			$rdikti = $result['result'];

			$error_code = $rdikti['error_code'];
			if($error_code==730){
				$recordup = array(
					'key' => array('id_smt' => "$qkm->Tahun",'id_reg_pd' => "$qkm->id_reg_pd",'id_stat_mhs' => "$qkm->Status"),
					'data' => array('ips' => "$qkm->SKS",'sks_smt' => "$qkm->SKS",'ipk' => "$qkm->IPK",'sks_total' => "$qkm->TotalSKS")
				);
				echo "fandu json2 -- ".json_encode($recordup);

				$resultup = $proxy->UpdateRecord($token, 'kelas_kuliah', json_encode($recordup));
				$rdiktiup = $resultup['result'];
				echo "fandu json3 -- ".$rdiktiup['error_code']." ".$rdiktiup['error_desc'];
			
				$sql = $this->db->query("UPDATE _v2_khs SET st_feeder='1' WHERE ID='$ID'");
				if($sql){
					echo "Data Berhasil Di import";	
				}else{
					echo "Data Berhasil di import tapi gagal di st_feeder gagal diupdate di khs";	
				}
			} elseif($error_code!=0){
				$error_desc = $rdikti['error_desc'];
				echo $error_code."-".$error_desc." - ".json_encode($record);	
			} else{
				$sql = $this->db->query("UPDATE _v2_khs SET st_feeder='1' WHERE ID='$ID'");
				if($sql){
					echo "Data Berhasil Di import";	
				}else{
					echo "Data Berhasil di import tapi gagal di st_feeder gagal diupdate di khs";	
				}
			}
		}else{
			echo "IPK bernilai 0 tidak dapat di import ke feeder";
		}
	}*/
}
?>