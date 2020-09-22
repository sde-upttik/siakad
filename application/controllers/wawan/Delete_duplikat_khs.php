<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class delete_duplikat_khs extends CI_Controller {


	function __construct() {
	    parent::__construct();
		$this->load->library('encryption');
		$this->load->model('Prc');
	}

	public function tes()
	{

		/*$dataEncrypt = $this->encryption->encrypt("E28112177|DUM014|20182|B");
		
		echo $dataEncrypt;*/
		
		//$dataDecrypt = $this->encryption->decrypt('429243e0bdf23fba84af48abc4cf4428fdf6f129be44c5d42f273f987a1d78105d9ad9643891b92e71f0666b63c38d31cab1e7c6b87957e197752f0fd6140c58JxJhT8lVLMn533AMVFvGz98E0JHSeohMnMpBFqlSphTVfQ9BRq39f+D+Xm4ZXCuv');
		//echo $dataDecrypt;
	}

	public function index()
	{
		echo "
			<!DOCTYPE html>
			<html>
			<head>
				<title>PRC duplikat KHS</title>
			</head>
			<body>
				<form method='POST' action='".base_url('wawan/delete_duplikat_khs/prc_khs')."'>
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
						<option value='K2M'>Kampus 2 Morowali</option>
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
		$dataLama = $this->Prc->cek_duplikat_khs($this->input->post('fakultas'));
		$dataKhsLama = array();
		foreach ($dataLama as $show) {
			$data1 = array(
				'ID' => $show->ID,
				 'NIM' => $show->NIM,
				 'Tahun' => $show->Tahun,
				 'Jml_Kembar' => $show->Jml_Kembar,
				 'KodeFakultas' => $show->KodeFakultas,
				 'KodeJurusan' => $show->KodeJurusan
		    );

		    array_push($dataKhsLama, $data1);			   
			   
		}
		//print_r($dataKhsLama);
		//echo $i;
		$i=1;
		foreach ($dataKhsLama as $show) {
			//echo $i." ";
			//print_r($show)." ";

			$data = array(
				'ID' => $show['ID'],
				'NIM' => $show['NIM'],
				 'Tahun' => $show['Tahun'],
				 'Jml_Kembar' => $show['Jml_Kembar'],
				 'KodeFakultas' => $show['KodeFakultas'],
				 'KodeJurusan' => $show['KodeJurusan']
			);

			$dataPrc = $this->Prc->limit_desc_nim($show['NIM'], $show['Tahun']);
		
			foreach ($dataPrc as $show1) {
				print_r($show1);	
				$cek_hapus =$this->Prc->deleteData1($show1->ID);
			    if($cek_hapus){
		            echo $status_hapus="Sukses";
		        }else{
		        	echo $status_hapus="Gagal";
		        }
				echo "<br><br><br>";
			}

			/*$cek_simpan=$this->Prc->addData1($data,'_v2_khs');
	        if($cek_simpan=='0'){
	        	echo "Tabel KHS Tidak ada";
	        	echo "<br>";
	        }elseif($cek_simpan){
	        	echo "Berhasil tersimpan di tabel KHS";
	        	echo "<br>";
	        }*/

	        
			$i++;
		}
	}

}
