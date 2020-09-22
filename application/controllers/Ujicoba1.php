<?php
if(! defined("BASEPATH")) exit("Akses langsung tidak diperkenankan");

class ujicoba1 extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Makassar");
	}
	
	//Mahasiswa KRS
	public function nusoap1(){
		
		$ID_KRS = "5104";
		$thn = "20171";
		
		/*$ID_KRS=$_POST['id_KRS'];
		$thn=$_GET['thn'];*/
		
		$feeder = $this->feeder->getToken_feeder();
		$temp_token = $feeder['temp_token'];
		$temp_proxy = $feeder['temp_proxy'];
	
		if($thn != '20161'){
			$tbl = "_v2_krs$thn";
		} else {
			$tbl = "_v2_krs";
		}
		
		$query = "select j.id_kelas_kuliah as id_kls,j.IDJADWAL,m.id_reg_pd,m.NIM,n.ID as IDKRS,n.nilai as nilai_angka,n.GradeNilai as nilai_huruf,n.Bobot as nilai_indeks from _v2_jadwal j, _v2_mhsw m,$tbl n where j.IDJADWAL=n.IDJADWAL and n.ID='$ID_KRS' and n.NIM=m.NIM order by n.NIM";
		
		//echo $query;
		
		$row = $this->db->query($query)->result();

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
				$this->db->query($qupdate);
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
					$this->db->query($qupdate);
					echo "Data Sudah Pernah Terinput";
				}else{
					echo "Data gagal Update ".$error_code1." ".$error_desc1;
				}
			} else {
				print_r($datb);
				$qupdate = "update $tbl set st_feeder=-3 where ID='$IDKRS'";
				$this->db->query($qupdate);
				echo "Gagal ".$error_code." - ".$error_desc;
			}
		}
	}
	
	
	
	/*include 'nusoap/nusoap.php';
    include 'nusoap/class.wsdlcache.php';

	//$url = 'http://103.245.72.97:8082/ws/sandbox.php?wsdl'; // gunakan sandbox untuk coba-coba
	$url = 'http://103.245.72.97:8082/ws/live.php?wsdl'; // gunakan live bila sudah yakin

	$client = new nusoap_client($url, true);
	//echo "Include Berhasil <br/>";
	$proxy = $client->getProxy();

	// Mendapatkan Token

	$username = '001028e1';
	$password = 'hil2006';

	$result = $proxy->GetToken($username, $password);
	$token = $result;

	$ID_KRS=$_POST['id_KRS'];
	$thn=$_GET['thn'];
	if($thn!='20161'){
		$tbl = "krs$thn";
	} else {
		$tbl = "krs";
	}
	 echo "Proses Nilai MAhasiswa $ID_KRS";
	 $query = "select j.id_kelas_kuliah as id_kls,j.IDJADWAL,m.id_reg_pd,m.NIM,n.ID as IDKRS,n.nilai as nilai_angka,n.GradeNilai as nilai_huruf,n.Bobot as nilai_indeks from jadwal j,mhsw m,$tbl n where j.IDJADWAL=n.IDJADWAL and n.ID='$ID_KRS' and n.NIM=m.NIM order by n.NIM";
	 echo $query;


	$r = mysql_query($query);
	$no=1;



	while($w = mysql_fetch_array($r)){
		$IDKRS = $w['IDKRS'];
		$id_kls = $w['id_kls'];
		$id_reg_pd = $w['id_reg_pd'];
		$NIM = $w['NIM'];
		$nil_ang = $w['nilai_angka'];
		$nil_huruf = $w['nilai_huruf'];
		$nil_indeks = $w['nilai_indeks'];

		$record = array();
		$record['id_kls']= $id_kls;
		$record['id_reg_pd']= $id_reg_pd;
		$record['asal_data']="9";
		$record['nilai_angka']=$nil_ang;
		$record['nilai_huruf']=$nil_huruf;
		$record['nilai_indeks']=$nil_indeks;

		$table = 'kelas_kuliah';

		echo "<br>";
		echo json_encode($record);
		//insert tabel mahasiswa
		$resultb = $proxy->InsertRecord($token, "nilai", json_encode($record));
		//var_dump($resultb);
		//$id_kls = null;
		$datb = $resultb['result'];


		//$id_kls = $datb['id_kls'];
		$error_code = $datb['error_code'];
		$error_desc = $datb['error_desc'];
		//$id_reg_pd = $datb['id_reg_pd'];
		echo "<tr><td>".$no. "</td>";
		echo "<td>".$w['kode_mk']."</td>";
		echo "<td>".$id_mk."</td>";
		echo "<td>".$w['id_sms']."</td>";
		//echo "<td>".$id_reg_pd."</td>";

		  /// var_dump($result2);
		 if($error_code == 0){
		   $df = $datb['result'];
		    $qupdate = "update $tbl set st_feeder=3 where ID='$IDKRS'";
			echo "<td>Berhasil Diinput</td>";
			mysql_query($qupdate);
			
		  }else if($error_code == 800){
		  	$recordup = array(
				'key' => array('id_kls' => $id_kls,'id_reg_pd' => $id_reg_pd),
				'data' => array('asal_data' => "9",'nilai_angka' => $nil_ang,'nilai_huruf' => $nil_huruf,'nilai_indeks' => $nil_indeks)
			);

			echo json_encode($recordup);

			$resultup = $proxy->UpdateRecord($token, 'nilai', json_encode($recordup));

			$datarec = $resultup['result'];

			$error_code1 = $datarec['error_code'];
			$error_desc1 = $datarec['error_desc'];


			if($error_code1 == 0){
				$df = $datb['result'];
			    $qupdate = "update $tbl set st_feeder=4 where ID='$IDKRS'";
				echo "<td>Data Sudah Pernah Terinput</td>";
				mysql_query($qupdate);
			}else{
				echo "<br />";
				echo $error_code1." ".$error_desc1;
				echo "<br />";
				echo "Data gagal Update";
			}
		   
			
		  }else{
		  	print_r($datb);
		    echo "<td>-".$error_code."-".$error_desc."</td>";
			echo "<td>Proses <a href='?reg=$NIM' target='_blank'>$NIM</a> Gagal</td></tr>";
			$qupdate = "update $tbl set st_feeder=-3 where ID='$IDKRS'";
			mysql_query($qupdate);
		  }
		$no++;

	}*/
	
	//prc krs
	/* pengiriman dari krs k2m ke krs tahunan public function prckrs(){
		
		$query = "SELECT *  FROM krsK2M WHERE Tahun IN ('20181','20182') ORDER BY NIM ASC";
		
		$row = $this->db->query($query)->result();

		foreach ($row as $w){
			$NIM = $w->NIM;
			$IDJadwal = $w->IDJadwal;
			$IDMK = $w->IDMK;
			$Tahun = $w->Tahun;
			
			$querycek = "SELECT * FROM _v2_krs$Tahun WHERE NIM = '$NIM' and IDJadwal = '$IDJadwal' and IDMK = '$IDMK' and Tahun = '$Tahun' ORDER BY NIM ASC";
			
			$queryinsert = "SELECT null as ID, st_feeder, NIM, Tahun, SMT, Sesi, IDJadwal, IDPAKET, IDMK00, IDMK, KodeMK, NamaMK, null as NamaMK_Inggris, SKS, Status, Program, IDDosen, unip, Tanggal, hr_1, hr_2, hr_3, hr_4, hr_5, hr_6, hr_7, hr_8, hr_9, hr_10, hr_11, hr_12, hr_13, hr_14, hr_15, hr_16, hr_17, hr_18, hr_19, hr_20, hr_21, hr_22, hr_23, hr_24, hr_25, hr_26, hr_27, hr_28, hr_29, hr_30, hr_31, hr_32, hr_33, hr_34, hr_35, hr_36, jmlHadir, Hadir , Tugas1 , Tugas2 , Tugas3 , Tugas4 , Tugas5 , NilaiPraktek, NilaiMID, NilaiUjian, Nilai, GradeNilai, Bobot, useredt, tgledt, rowedt, Tunda, AlasanTunda, Setara, MKSetara, KodeSetara, SKSSetara, GradeSetara, NotActive, unipupd, angkatan, prckkn, 0 as st_abaikan, 0 as enkripsi, 0 as enkripsi_mhs, 0 as unip_wali FROM krsK2M WHERE NIM = '$NIM' and IDJadwal = '$IDJadwal' and IDMK = '$IDMK' and Tahun = '$Tahun' and pindah_siakad='0' ORDER BY NIM ASC";
			
			$cek = $this->db->query($querycek)->num_rows();
			
			if ($cek == 0){
				//echo $querycek."<br>";
				$insert = "INSERT INTO _v2_krs$Tahun $queryinsert";
				echo $insert."<br><br>";
				$this->db->query($insert);
				
				$update = "UPDATE krsK2M set pindah_siakad='1' WHERE NIM = '$NIM' and IDJadwal = '$IDJadwal' and IDMK = '$IDMK' and Tahun = '$Tahun' ORDER BY NIM ASC";
				$this->db->query($update);
				echo $update."<br><br>";
			}
		}
		
		
	}*/
	
}
?>