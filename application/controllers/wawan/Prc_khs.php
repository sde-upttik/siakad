<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prc_khs extends CI_Controller {


	function __construct() {
	    parent::__construct();
		$this->load->library('encryption');
		$this->load->model('Prc');
	}

	public function tes()
	{

		/*$dataEncrypt = $this->encryption->encrypt("E28112177|DUM014|20182|B");
		
		echo $dataEncrypt;*/
		
		$dataDecrypt = $this->encryption->decrypt('429243e0bdf23fba84af48abc4cf4428fdf6f129be44c5d42f273f987a1d78105d9ad9643891b92e71f0666b63c38d31cab1e7c6b87957e197752f0fd6140c58JxJhT8lVLMn533AMVFvGz98E0JHSeohMnMpBFqlSphTVfQ9BRq39f+D+Xm4ZXCuv');
		echo $dataDecrypt;
	}

	public function index()
	{
		echo "
			<!DOCTYPE html>
			<html>
			<head>
				<title>PRC KHS</title>
			</head>
			<body>
				<form method='POST' action='".base_url('wawan/prc_khs/prc_khs')."'>
					<select name='fakultas'>
						<option value='A'>FKIP    </option>
						<option value='B'>FISIP   </option>
						<option value='C'>FEKON   </option>
						<option value='D'>FAKUM   </option>
						<option value='E'>FAPERTA </option>
						<option value='F'>FATEK   </option>
						<option value='G'>FMIPA   </option>
						<option value='H'>PASCA   </option>
						<option value='K2T'>Kampus 2 Touna</option>
						<option value='L'>FAHUT   </option>
						<option value='O'>FAPETKAN</option>
						<option value='P'>FKM     </option>
					</select>
					<input type='submit' name='kirim'>
				</form>
			</body>
			</html>
		";
	}

	public function prc_khs()
	{
		$dataLama = $this->Prc->khsLama($this->input->post('fakultas'));
		$dataKhsLama = array();
		foreach ($dataLama as $show) {
			$data1 = array(
				 'NIM' => $show->NIM,
				 'Tahun' => $show->Tahun,
				 'Sesi' => $show->Sesi,
				 'Status' => $show->Status,
				 'Registrasi' => $show->Registrasi,
				 'TglRegistrasi' => $show->TglRegistrasi,
				 'Nilai' => $show->Nilai,
				 'GradeNilai' => $show->GradeNilai,
				 'Bobot' => $show->Bobot,
				 'SKS' => $show->SKS,
				 'MaxSKS' => $show->MaxSKS,
				 'MaxSKS2' => $show->MaxSKS2,
				 'IPS' => $show->IPS,
				 'SKSLulus' => $show->SKSLulus,
				 'IPK' => $show->IPK,
				 'TotalSKS' => $show->TotalSKS,
				 'TotalSKSLulus' => $show->TotalSKSLulus,
				 'TglUbah' => $show->TglUbah,
				 'CekUbah' => $show->CekUbah,
				 'NotActive' => $show->NotActive,
				 'st_feeder' => $show->st_feeder,
				 'st_val' => $show->st_val,
				 'tgl_val' => $show->tgl_val,
				 'stprc' => $show->stprc,
				 'st_abaikan' => $show->st_abaikan
		    );

		    array_push($dataKhsLama, $data1);			   
			   
		}
		//print_r($dataKhsLama);
		//echo $i;
		$i=1;
		foreach ($dataKhsLama as $show) {
			echo $i." ";
			print_r($show)." ";

			$data = array(
				'NIM' => $show['NIM'],
				 'Tahun' => $show['Tahun'],
				 'Sesi' => $show['Sesi'],
				 'Status' => $show['Status'],
				 'Registrasi' => $show['Registrasi'],
				 'TglRegistrasi' => $show['TglRegistrasi'],
				 'Nilai' => $show['Nilai'],
				 'GradeNilai' => $show['GradeNilai'],
				 'Bobot' => $show['Bobot'],
				 'SKS' => $show['SKS'],
				 'MaxSKS' => $show['MaxSKS'],
				 'MaxSKS2' => $show['MaxSKS2'],
				 'IPS' => $show['IPS'],
				 'SKSLulus' => $show['SKSLulus'],
				 'IPK' => $show['IPK'],
				 'TotalSKS' => $show['TotalSKS'],
				 'TotalSKSLulus' => $show['TotalSKSLulus'],
				 'TglUbah' => $show['TglUbah'],
				 'CekUbah' => $show['CekUbah'],
				 'NotActive' => $show['NotActive'],
				 'st_feeder' => $show['st_feeder'],
				 'st_val_ganti' => $show['st_val'],
				 'tgl_val' => $show['tgl_val'],
				 'stprc' => $show['stprc'],
				 'st_abaikan' => $show['st_abaikan'],
				 'cluster_siakad' => 'Cluster 1'
			);

			$cek_simpan=$this->Prc->addData1($data,'_v2_khs');
	        if($cek_simpan=='0'){
	        	echo "Tabel KHS Tidak ada";
	        	echo "<br>";
	        }elseif($cek_simpan){
	        	echo "Berhasil tersimpan di tabel KHS";
				$stPindah = $this->Prc->khsStPindah($show);
				if ($stPindah) {
					echo " update St_pindah <b>SUKSES</b>";
				}else {
					echo " update St_pindah <b style='color:red;'>GAGAL</b>";
				}
	        	echo "<br>";
	        }

	        
			echo "<br><br><br>";
			$i++;
		}
	}

}
