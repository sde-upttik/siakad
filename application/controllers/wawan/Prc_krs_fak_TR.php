<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prc_krs_fak_TR extends CI_Controller {


	function __construct() {
	    parent::__construct();
		$this->load->library('encryption');
		$this->load->model('Prc');
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
				<form method='POST' action='".base_url('wawan/prc_krs_fak_TR/prc_krs')."'>
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

	public function prc_krs()
	{
		$dataLama = $this->Prc->krsLamaFakTR($this->input->post('fakultas'));
		$dataKrsLama = array();
		foreach ($dataLama as $show) {
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
		//print_r($dataKrsLama);
		//echo $i;
		$i=1;
		foreach ($dataKrsLama as $show) {
			$tahun=$show['Tahun'];
			if($tahun=='TR' || $tahun=='tr'){
				echo $i." ";
				print_r($show)." ";


				$check_krs=$this->Prc->check_krstr($show['NIM'],$show['Tahun'],$show['IDJadwal'],$show['KodeMK']);

				if($check_krs==0){
					if($show['prckkn']==""){
						$prckkn=0;
					}else{
						$prckkn=$show['prckkn'];
					}

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
						'prckkn' => $prckkn,
						'st_abaikan' => '0',
						'enkripsi' => '',
						'enkripsi_mhs'  => '',
						'unip_wali' => ''
					);

					$data2 = array(
				        'pindah_siakad_baru' => '1'
				    );

				    //print_r($data);
					$cek_simpan=$this->Prc->addDataTR($data,$show['Tahun']);
			        if($cek_simpan=='0'){
			        	echo "Tabel ".$show['Tahun']." Tidak ada";
			        	echo "<br>";
			        }elseif($cek_simpan){
			        	echo "Berhasil tersimpan di tabel ".$show['Tahun'];
			        	echo "<br>";

			        	$data2 = array(
					        'pindah_siakad_baru' => '1'
					    );

				        $cek_edit =$this->Prc->updateDataFak($show['ID'], $data2, $this->input->post('fakultas'));
			        }
				}else{
					$data2 = array(
				        'pindah_siakad_baru' => '2'
				    );

			        $cek_edit =$this->Prc->updateDataFak($show['ID'], $data2, $this->input->post('fakultas'));
				}
				print_r($data2);

		        
				echo "<br><br><br>";
				$i++;
			}			
		}
	}

}
