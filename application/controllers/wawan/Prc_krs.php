<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prc_krs extends CI_Controller {


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
				<title>PRC KRS</title>
			</head>
			<body>
				<form method='POST' action='".base_url('wawan/prc_krs/prc_krs')."'>
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
					<select name='tahun'>
						<option value='20101'>20101</option>
						<option value='20102'>20102</option>
						<option value='20103'>20103</option>
						<option value='20104'>20104</option>
						<option value='20111'>20111</option>
						<option value='20112'>20112</option>
						<option value='20113'>20113</option>
						<option value='20114'>20114</option>
						<option value='20121'>20121</option>
						<option value='20122'>20122</option>
						<option value='20123'>20123</option>
						<option value='20124'>20124</option>
						<option value='20131'>20131</option>
						<option value='20132'>20132</option>
						<option value='20133'>20133</option>
						<option value='20134'>20134</option>
						<option value='20141'>20141</option>
						<option value='20142'>20142</option>
						<option value='20143'>20143</option>
						<option value='20144'>20144</option>
						<option value='20151'>20151</option>
						<option value='20152'>20152</option>
						<option value='20153'>20153</option>
						<option value='20154'>20154</option>
						<option value='20161'>20161</option>
						<option value='20162'>20162</option>
						<option value='20163'>20163</option>
						<option value='20164'>20164</option>
						<option value='20171'>20171</option>
						<option value='20172'>20172</option>
						<option value='20173'>20173</option>
						<option value='20174'>20174</option>
						<option value='20181'>20181</option>
						<option value='20182'>20182</option>
						<option value='20183'>20183</option>
						<option value='20184'>20184</option>
						<option value='20191'>20191</option>
					</select>
					<input type='submit' name='kirim'>
				</form>
			</body>
			</html>
		";
	}

	public function prc_krs()
	{
		$dataLama = $this->Prc->krsLama($this->input->post('tahun'),$this->input->post('fakultas'));
		$dataKrsLama = array();
		foreach ($dataLama as $show) {
			if($show->IDMK!=null) {
				$data1 = array(
					'ID' => $show->ID,
			        'st_feeder' => $show->st_feeder,
					'NIM'  => $show->NIM,
					'Tahun' => $show->Tahun,
					'SMT' => $show->SMT,
					'Sesi' => $show->Sesi,
					'IDJadwal' => $show->IDJadwal,
					'IDPAKET' => $show->IDPAKET,
					'IDMK00' => $show->IDMK00,
					'IDMK' => $show->IDMK,
					'KodeMK' => $show->KodeMK,
					'NamaMK' => $show->NamaMK,
					'NamaMK_Inggris' => '',
					'SKS' => $show->SKS,
					'Status' => $show->Status,
					'Program'  => $show->Program ,
					'IDDosen' => $show->IDDosen,
					'unip' => $show->unip,
					'Tanggal' => $show->Tanggal,
					'hr_1'  => $show->hr_1 ,
					'hr_2'  => $show->hr_2 ,
					'hr_3'  => $show->hr_3 ,
					'hr_4'  => $show->hr_4 ,
					'hr_5'  => $show->hr_5 ,
					'hr_6'  => $show->hr_6 ,
					'hr_7'  => $show->hr_7 ,
					'hr_8'  => $show->hr_8 ,
					'hr_9'  => $show->hr_9 ,
					'hr_10'  => $show->hr_10 ,
					'hr_11'  => $show->hr_11 ,
					'hr_12'  => $show->hr_12 ,
					'hr_13'  => $show->hr_13 ,
					'hr_14'  => $show->hr_14 ,
					'hr_15'  => $show->hr_15 ,
					'hr_16'  => $show->hr_16 ,
					'hr_17'  => $show->hr_17 ,
					'hr_18'  => $show->hr_18 ,
					'hr_19'  => $show->hr_19 ,
					'hr_20'  => $show->hr_20 ,
					'hr_21'  => $show->hr_21 ,
					'hr_22'  => $show->hr_22 ,
					'hr_23'  => $show->hr_23 ,
					'hr_24'  => $show->hr_24 ,
					'hr_25'  => $show->hr_25 ,
					'hr_26'  => $show->hr_26 ,
					'hr_27'  => $show->hr_27 ,
					'hr_28'  => $show->hr_28 ,
					'hr_29'  => $show->hr_29 ,
					'hr_30'  => $show->hr_30 ,
					'hr_31'  => $show->hr_31 ,
					'hr_32'  => $show->hr_32 ,
					'hr_33'  => $show->hr_33 ,
					'hr_34'  => $show->hr_34 ,
					'hr_35'  => $show->hr_35 ,
					'hr_36'  => $show->hr_36 ,
					'jmlHadir' => $show->jmlHadir,
					'Hadir' => $show->Hadir,
					'Tugas1' => $show->Tugas1,
					'Tugas2' => $show->Tugas2,
					'Tugas3' => $show->Tugas3,
					'Tugas4' => $show->Tugas4,
					'Tugas5' => $show->Tugas5,
					'NilaiPraktek' => $show->NilaiPraktek,
					'NilaiMID' => $show->NilaiMID,
					'NilaiUjian' => $show->NilaiUjian,
					'Nilai'  => $show->Nilai ,
					'GradeNilai' => $show->GradeNilai,
					'Bobot' => $show->Bobot,
					'useredt'  => $show->useredt ,
					'tgledt' => $show->tgledt,
					'rowedt' => $show->rowedt,
					'Tunda'  => $show->Tunda ,
					'AlasanTunda'  => $show->AlasanTunda ,
					'Setara'  => $show->Setara ,
					'MKSetara'  => $show->MKSetara ,
					'KodeSetara'  => $show->KodeSetara ,
					'SKSSetara'  => $show->SKSSetara ,
					'GradeSetara'  => $show->GradeSetara ,
					'NotActive'  => $show->NotActive ,
					'NotActive_krs'  => $show->NotActive ,
					'unipupd'  => $show->unipupd ,
					'angkatan'  => $show->angkatan ,
					'prckkn' => $show->prckkn,
					'st_abaikan' => '0',
					'enkripsi' => '',
					'enkripsi_mhs'  => '',
					'unip_wali' => ''
			    );

			    array_push($dataKrsLama, $data1);	
			}
			
			   
			   /* echo $i." ";
				print_r($data);
				echo "<br><br>";*/

				/*$cek_simpan=$this->Krs_model->addData($data);
		        if($cek_simpan){
		        	echo "SUCCESS";
		        	echo "<br><br>";
		        }else{
		        	echo "ERROR";
		        	echo "<br><br>";
		        }*/

			   // $i++;
			//}
			

		    //print_r($data)."<br>";
			
	        

	        /*$data1 = array(
		        'pindah_siakad' => '1'
		    );

	        $cek_edit =$this->Krs_model->updateData($show->ID, $data1,'krsK2M');*/
		}
		//print_r($dataKrsLama);
		//echo $i;
		$i=1;
		foreach ($dataKrsLama as $show) {
			echo $i." ";
			print_r($show)." ";

			$data = array(
				'st_feeder' => $show['st_feeder'],
				'NIM'  => $show['NIM'],
				'Tahun' => $show['Tahun'],
				'SMT' => $show['SMT'],
				'Sesi' => $show['Sesi'],
				'IDJadwal' => $show['IDJadwal'],
				'IDPAKET' => $show['IDPAKET'],
				'IDMK00' => $show['IDMK00'],
				'IDMK' => $show['IDMK'],
				'KodeMK' => $show['KodeMK'],
				'NamaMK' => $show['NamaMK'],
				'NamaMK_Inggris' => '',
				'SKS' => $show['SKS'],
				'Status' => $show['Status'],
				'Program'  => $show['Program'],
				'IDDosen' => $show['IDDosen'],
				'unip' => $show['unip'],
				'Tanggal' => $show['Tanggal'],
				'hr_1'  => $show['hr_1'],
				'hr_2'  => $show['hr_2'],
				'hr_3'  => $show['hr_3'],
				'hr_4'  => $show['hr_4'],
				'hr_5'  => $show['hr_5'],
				'hr_6'  => $show['hr_6'],
				'hr_7'  => $show['hr_7'],
				'hr_8'  => $show['hr_8'],
				'hr_9'  => $show['hr_9'],
				'hr_10'  => $show['hr_10'],
				'hr_11'  => $show['hr_11'],
				'hr_12'  => $show['hr_12'],
				'hr_13'  => $show['hr_13'],
				'hr_14'  => $show['hr_14'],
				'hr_15'  => $show['hr_15'],
				'hr_16'  => $show['hr_16'],
				'hr_17'  => $show['hr_17'],
				'hr_18'  => $show['hr_18'],
				'hr_19'  => $show['hr_19'],
				'hr_20'  => $show['hr_20'],
				'hr_21'  => $show['hr_21'],
				'hr_22'  => $show['hr_22'],
				'hr_23'  => $show['hr_23'],
				'hr_24'  => $show['hr_24'],
				'hr_25'  => $show['hr_25'],
				'hr_26'  => $show['hr_26'],
				'hr_27'  => $show['hr_27'],
				'hr_28'  => $show['hr_28'],
				'hr_29'  => $show['hr_29'],
				'hr_30'  => $show['hr_30'],
				'hr_31'  => $show['hr_31'],
				'hr_32'  => $show['hr_32'],
				'hr_33'  => $show['hr_33'],
				'hr_34'  => $show['hr_34'],
				'hr_35'  => $show['hr_35'],
				'hr_36'  => $show['hr_36'],
				'jmlHadir' => $show['jmlHadir'],
				'Hadir' => $show['Hadir'],
				'Tugas1' => $show['Tugas1'],
				'Tugas2' => $show['Tugas2'],
				'Tugas3' => $show['Tugas3'],
				'Tugas4' => $show['Tugas4'],
				'Tugas5' => $show['Tugas5'],
				'NilaiPraktek' => $show['NilaiPraktek'],
				'NilaiMID' => $show['NilaiMID'],
				'NilaiUjian' => $show['NilaiUjian'],
				'Nilai'  => $show['Nilai'],
				'GradeNilai' => $show['GradeNilai'],
				'Bobot' => $show['Bobot'],
				'useredt'  => $show['useredt'],
				'tgledt' => $show['tgledt'],
				'rowedt' => $show['rowedt'],
				'Tunda'  => $show['Tunda'],
				'AlasanTunda'  => $show['AlasanTunda'],
				'Setara'  => $show['Setara'],
				'MKSetara'  => $show['MKSetara'],
				'KodeSetara'  => $show['KodeSetara'],
				'SKSSetara'  => $show['SKSSetara'],
				'GradeSetara'  => $show['GradeSetara'],
				'NotActive'  => $show['NotActive'],
				'NotActive_krs'  => $show['NotActive'],
				'unipupd'  => $show['unipupd'],
				'angkatan'  => $show['angkatan'],
				'prckkn' => $show['prckkn'],
				'st_abaikan' => '0',
				'enkripsi' => '',
				'enkripsi_mhs'  => '',
				'unip_wali' => '',
				'cluster_siakad' => 'Cluster 1'
			);

			$cek_simpan=$this->Prc->addData($data,$this->input->post('tahun'));
	        if($cek_simpan=='0'){
	        	echo "Tabel ".$this->input->post('tahun')." Tidak ada";
	        	echo "<br>";
	        }elseif($cek_simpan){
	        	echo "Berhasil tersimpan di tabel ".$this->input->post('tahun');
	        	echo "<br>";

	        	$data2 = array(
			        'pindah_siakad_baru' => '1'
			    );

		        $cek_edit =$this->Prc->updateData($show['ID'], $data2, $this->input->post('tahun'));

	        }

	        
			echo "<br><br><br>";
			$i++;
		}
	}

}
