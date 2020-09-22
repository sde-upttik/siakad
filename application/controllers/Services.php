<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

/**
 * 
 */
class Services extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function index($value='')
	{
		/*
		$data['webpage']='services';

		$this->load->view('dashbord',$data);
		*/
	}

	function Hapushistory($value='')
	{
		echo '
		<form method="POST" action="'.base_url("Services/Hapushistory").'">
			<label>NIM IN </label>
			<input type="text" name="nim"><br>
			<input type="submit" name="prc">
		</form>
		';


		if ($this->input->post()) {
			$Token = $this->Token();

			$nims = explode(',', $this->input->post('nim'));
			foreach ($nims as $nim) {
				echo "<hr/>";

				if ($nim!='') {
					$where = array('nim'=>$nim);
					$result = $this->db->get_where('_v2_mhsw',$where);

					if ($result->num_rows()==1 ) {
						$res = $result->result()[0];
						$dataMhsw = array(
							'id_registrasi_mahasiswa'	=> $res->id_reg_pd
						);

						$required = array(
							'act' => 'DeleteRiwayatPendidikanMahasiswa',
							'token' => $Token,
							'key' => $dataMhsw
					 	);
					 	$dataBiodataFeeder = $this->runWS($required);
					 	$obj = json_decode($dataBiodataFeeder);
					 	$error_code = $obj->error_code;
					 	$error_desc = $obj->error_desc;
					 	$id_BiodataDikti = $obj->data;

				 		echo $nim." = ".$required['act']." = ".$error_code." | ".$error_desc." | ".$id_BiodataDikti."<br>";
				 		if ($error_code==0) {
				 			$set = array('st_feeder'=>0,'id_reg_pd'=>null);
				 			$this->db->set($set);
				 			$this->db->where('nim',$nim);
				 			$sql = $this->db->update('_v2_mhsw');
				 			// echo $sql."<br>";
				 			$dataMhsw = array('id_mahasiswa'=>$res->id_pd);
				 			$required = array(
				 				'act'	=> 'DeleteBiodataMahasiswa',
								'token' => $Token,
								'key' => $dataMhsw
				 			);
				 			$biodata = json_decode($this->runWS($required));
					 		echo $nim." = ".$required['act']." = ".$biodata->error_code." | ".$biodata->error_desc." | ".$biodata->data."<br>";
					 		if ($biodata->error_code==0) {
					 			$set = array('st_feeder'=>0,'id_pd'=>null);
					 			$this->db->set($set);
					 			$this->db->where('nim',$nim);
					 			$sql = $this->db->update('_v2_mhsw');
					 			// echo $sql."<br>";
					 		}
				 		}
					}else{
						echo "NIM :".$nim." ditemukan Lebih dari satu record";
					} 
				}else{
					echo "NIM kosong/tidak diinput";
				}
			}
		}
	}
 	private function Token()
	{
		$username = '001028e1';
		$password = 'az18^^';
		$dataToken = array (
			'act' => 'GetToken',
			'username' => $username,
			'password' => $password
		);

		return	json_decode($this->runWS($dataToken))->data->token;
	}

	private function runWS($data){
		$url = 'http://103.245.72.97:8082/ws/live2.php';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$data = json_encode($data);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

}
 ?>