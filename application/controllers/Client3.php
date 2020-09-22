<?php
if(! defined("BASEPATH")) exit("Akses langsung tidak diperkenankan");

class Client3 extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Makassar");
	}

	public function nusoap(){
		// mendapatkan token
		$feeder = $this->feeder->getToken_feeder();
		$temp_token = $feeder['temp_token'];
		$temp_proxy = $feeder['temp_proxy'];

		// tabel krs siakad
		$tbl = '_v2_krs20162';

		//query jadwal,mahasiswa,krs di siakad
		$qkm = $this->db->query("select j.id_kelas_kuliah as id_kls,j.IDJADWAL,m.id_reg_pd,m.NIM,n.ID as IDKRS,n.nilai as nilai_angka,n.GradeNilai as nilai_huruf,n.Bobot as nilai_indeks from _v2_jadwal j,_v2_mhsw m,_v2_krs20162 n where j.IDJADWAL=n.IDJADWAL and n.ID='80' and n.NIM=m.NIM order by n.NIM")->row();

		// pendeklarasian variabel
		$IDKRS = $qkm->IDKRS;
		$id_kls = $qkm->id_kls;
		$id_reg_pd = $qkm->id_reg_pd;
		$NIM = $qkm->NIM;
		$nil_ang = $qkm->nilai_angka;
		$nil_huruf = $qkm->nilai_huruf;
		$nil_indeks = $qkm->nilai_indeks;

		// pendeklarasi variabel class
		$record = new stdClass();
		$record->id_kls= $id_kls;
		$record->id_reg_pd= $id_reg_pd;
		$record->asal_data="9";
		$record->nilai_angka=$nil_ang;
		$record->nilai_huruf=$nil_huruf;
		$record->nilai_indeks=$nil_indeks;

		// tabel pada feeder
		$table = 'nilai';

		// action insert ke feeder
		$action = 'InsertRecord';

		// insert tabel mahasiswa ke feeder
		$datb = $this->feeder->action_feeder($temp_token,$temp_proxy,$action,$table,$record);
		/* fungsi untuk upload ke feeder (action_feeder) dengan parameter :
		$temp_token : callback token yang diberikan feeder
		$temp_proxy : callback proxy yang diberikan feeder
		$action : Aksi yang di berikan ke feeder. Ex : InsertRecord, UpdateRecord
		$table : tabel yang ingin di akses oleh feeder
		$record : parameter yang ingin di insert atau update pada feeder
		*/

		// deklarasi variabel error dari feeder
		$error_code = $datb['error_code'];
		$error_desc = $datb['error_desc'];

		if($error_code == 0){
			// jika berhasil di input dengan code error 0
			echo "Berhasil Diinput";
			$qupdate = "update $tbl set st_feeder=3 where ID='$IDKRS'";
			$this->db->query($qupdate);
		} else if($error_code == 800){
					$recordup = array(
						'key' => array('id_kls' => $id_kls,'id_reg_pd' => $id_reg_pd),
						'data' => array('asal_data' => "9",'nilai_angka' => $nil_ang,'nilai_huruf' => $nil_huruf,'nilai_indeks' => $nil_indeks)
					);
					// action insert ke feeder
					$actionup = 'UpdateRecord';

					// update tabel mahasiswa ke feeder
					$datarec = $this->feeder->action_feeder($temp_token,$temp_proxy,$actionup,$table,$recordup);

					// deklarasi variabel error dari feeder
					$error_code1 = $datarec['error_code'];
					$error_desc1 = $datarec['error_desc'];

					if($error_code1 == 0){
						// jika Data Sudah Pernah Terinput dan Berhasil di Update dengan error code == 0
						echo "Data Sudah Pernah Terinput dan Berhasil di Update";
						$qupdate = "update $tbl set st_feeder=4 where ID='$IDKRS'";
						$this->db->query($qupdate);
					}else{
						// Jika Data gagal Update
						echo "Data gagal Update dengan error code : ".$error_code1." ".$error_desc1;
					}
		}else{
					print_r($datb);
					echo "<td>-".$error_code."-".$error_desc."</td>";
					echo "<td>Proses <a href='?reg=$NIM' target='_blank'>$NIM</a> Gagal</td></tr>";
					$qupdate = "update $tbl set st_feeder=-3 where ID='$IDKRS'";
					$this->db->query($qupdate);
		}
	}

	//restfull
	public function nusoap1(){
		$user_feeder = '001028p1';
		$password_feeder = 'bauk2015';
		$url = 'http://103.245.72.97:8082/ws/live2.php';

		$data = array (
			'act' => 'GetToken',
			'username' => $user_feeder,
			'password' => $password_feeder
		);

		//$data = json_encode($data);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_POST, 1);

		$headers = array();

		$headers[] = 'Content-Type: application/json';

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		if ($data){
			$data = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		// json echo "$result<br>";
		$obj = json_decode($result);
		return $obj->{'data'}->{'token'}; // mendapatkan tokennya
	}

	//restfull
	public function nusoap2(){

		$token = $this->nusoap1();
		$Filter = "id_mahasiswa='17844c8f-c260-44a2-80d9-8b440f72acb5'";
		$url = 'http://103.245.72.97:8082/ws/live2.php';

		$data = array (
			'act' => 'GetListMahasiswa',
			'token' => $token,
			'filter' => $Filter
		);

		//$data = json_encode($data);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_POST, 1);

		$headers = array();

		$headers[] = 'Content-Type: application/json';

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		if ($data){
			$data = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		echo "$result<br>";
		//$obj = json_decode($result);
		//print $obj; // mendapatkan tokennya*/
	}

	// mendapatkan aktivitas mengajar dosen
	public function id_reg_dosen_mengajar(){

		$token = $this->nusoap1();
		$Filter = "id_registrasi_dosen='16b3c62f-9437-4796-b8bd-f4619a3930b3'";
		$url = 'http://103.245.72.97:8082/ws/live2.php';

		/*$data = array (
			'act' => 'GetListMahasiswa',
			'token' => $token,
			'filter' => $Filter
		);*/

		$data = array (
			'act' => 'GetAktivitasMengajarDosen',
			'token' => $token,
			'filter' => $Filter
		);

		//$data = json_encode($data);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_POST, 1);

		$headers = array();

		$headers[] = 'Content-Type: application/json';

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		if ($data){
			$data = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		echo "$result<br>";

	}

	// mendapatkan detail penugasan dosen dengan id_dosen
	public function id_reg_dosen_getlistpenugasansemuadosen(){

		$token = $this->nusoap1();
		$Filter = "id_dosen='bae06faf-c9bf-44ab-a3fe-e830feec1c16'";
		$url = 'http://103.245.72.97:8082/ws/live2.php';

		/*$data = array (
			'act' => 'GetListMahasiswa',
			'token' => $token,
			'filter' => $Filter
		);*/

		$data = array (
			'act' => 'GetListPenugasanSemuaDosen',
			'token' => $token,
			'filter' => $Filter
		);

		//$data = json_encode($data);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_POST, 1);

		$headers = array();

		$headers[] = 'Content-Type: application/json';

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		if ($data){
			$data = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		echo "$result<br>";

	}

	//mendapatkan detail biodata dosen dengan id_dosen
	public function id_reg_dosen_detailbiodatadosen(){

		$token = $this->nusoap1();
		$Filter = "id_dosen='bae06faf-c9bf-44ab-a3fe-e830feec1c16'";
		$url = 'http://103.245.72.97:8082/ws/live2.php';

		/*$data = array (
			'act' => 'GetListMahasiswa',
			'token' => $token,
			'filter' => $Filter
		);*/

		$data = array (
			'act' => 'DetailBiodataDosen',
			'token' => $token,
			'filter' => $Filter
		);

		//$data = json_encode($data);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_POST, 1);

		$headers = array();

		$headers[] = 'Content-Type: application/json';

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		if ($data){
			$data = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		echo "$result<br>";

	}

}
?>
