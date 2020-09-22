<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

class prc extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct() {
	    parent::__construct();
		$this->load->library('encryption');
	}

	public function index()
	{
		$this->load->view('login');
	}

	public function prc_login(){
		$username=$this->db->escape($this->input->post('username'));
		$password=$this->db->escape($this->input->post('password'));
		$loguser=$this->input->post('loguser');
		//$komentar=strip_tags($komentar, '<a><b><i>').
		//$nama=htmlspecialchars($nama, ENT_QUOTES);
		//htmlentities($string);
		//$id = filter_var($_POST['id'], FILTER_VALIDATE_INT); // Filter ini berguna untuk mefilter tipe data integer
		//$nama = filter_var($_POST['nama'], FILTER_SANITIZE_STRING);//untuk tipe string
		//$username="adminsuperuser";
		//$password="adminsuperuser";

		$ip_address=$_SERVER['REMOTE_ADDR'];
		$info=$_SERVER['HTTP_USER_AGENT'];
		$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

		$stat = "";
		$loguser=$this->encryption->decrypt($loguser);

		// pembagian login ganjil dan genap (by Rocky)
		$tgl = date('d');
		$mod = $tgl % 2;
		if ( $mod == 1 ) {
			$fak = "and m.KodeFakultas in ('A','H','P')";
		} else {
			$fak = "and m.KodeFakultas in ('B','C','D','E','F','L','N','O','K2M','K2T')";
		}

		if(empty($loguser)) $where=" and usr in ('_v2_adm','_v2_adm_fak','_v2_adm_jur','_v2_adm_pusat')"; // untuk selain mahasiswa dan dosen jika loguser kosong
		else $where=" and usr='$loguser'";

		$tab_lev = $this->db->query("Select usr,Level FROM level WHERE NotActive='N'$where")->result();

		foreach ($tab_lev as $a){
			$use [] = $a->usr;
			$lev [] = $a->Level;
			//echo $a->Name;
		}

		for ($a=0; $a<count($use); $a++){
			//echo "fandu -- $use[$a] <br>";
			if ($use[$a]=="_v2_adm"){
				$val=",m.KodeUnit as kdf,m.KodeSubunit  as kdj,m.Login, m.Sex, m.Foto, m.count_edit_password";
				$par="AND m.NotActive='N'";
				$join="m";
			} else if ($use[$a]=="_v2_adm_fak"  or $use[$a]=="_v2_dosen"){
				$val=",m.KodeFakultas as kdf,f.Nama_Indonesia as nmf,m.KodeJurusan  as kdj, j.Nama_Indonesia as nmj,m.Login, m.Sex, m.Foto, m.Name, m.count_edit_password";
				$par="AND m.KodeFakultas != '' AND m.NotActive='N'";
				$join="m left join fakultas f on m.KodeFakultas=f.Kode left join _v2_jurusan j on m.KodeJurusan=j.Kode";
			} else if ($use[$a]=="_v2_adm_jur"){
				$val=",m.KodeFakultas as kdf,f.Nama_Indonesia as nmf,m.KodeJurusan as kdj, j.Nama_Indonesia as nmj,m.Login, m.Sex, m.Foto, m.Name, m.count_edit_password";
				$par="AND m.KodeFakultas != '' AND m.KodeJurusan != '' AND m.NotActive='N' ";
				$join="m left join fakultas f on m.KodeFakultas=f.Kode left join _v2_jurusan j on m.KodeJurusan=j.Kode";
			} else if ($use[$a]=="_v2_mhsw"){
				$val=",m.KodeFakultas as kdf,f.Nama_Indonesia as nmf,m.KodeJurusan as kdj, j.Nama_Indonesia as nmj,m.Login, m.Sex, m.fotoktm as Foto, m.Name, m.count_edit_password";
				$par="AND m.KodeFakultas != '' AND m.KodeJurusan != '' AND m.status='A' AND m.NotActive='N' $fak";
				$join="m left join fakultas f on m.KodeFakultas=f.Kode left join _v2_jurusan j on m.KodeJurusan=j.Kode";
			} else {
				$val=",m.KodeUnit as kdf,m.KodeSubunit  as kdj,m.Login, m.Sex, m.Foto, m.Name, m.count_edit_password";
				$par="AND m.NotActive='N'";
				$join="m";
			}

			//echo "SELECT m.ID,m.Name$val FROM $use[$a] $join WHERE m.Login='$username' AND m.Password=left(password('$password'),10) $par";
			$query=$this->db->query("SELECT m.ID,m.Name$val FROM $use[$a] $join WHERE m.Login=$username AND m.Password=left(password($password),10) $par");
			//echo $query->num_rows();

			if($query->num_rows()>0){
				$stat = $use[$a];
				$usr_lev = $lev[$a];
				break;
			}
		}

		if($stat == ""){
			// fandu tambahkan untuk mengecek dimana kesalahannya
			if ($loguser=="_v2_dosen"){
				$val=",m.KodeFakultas as kdf,f.Nama_Indonesia as nmf,m.KodeJurusan  as kdj, j.Nama_Indonesia as nmj,m.Login,m.NotActive as NA";
				//$par="AND m.KodeFakultas != '' AND m.NotActive='N'";
				$join="m left join fakultas f on m.KodeFakultas=f.Kode left join _v2_jurusan j on m.KodeJurusan=j.Kode";
			} else if ($loguser=="_v2_mhsw"){
				$val=",m.KodeFakultas as kdf,f.Nama_Indonesia as nmf,m.KodeJurusan as kdj, j.Nama_Indonesia as nmj,m.Login,m.status,m.NotActive as NA";
				//$par="AND m.KodeFakultas != '' AND m.KodeJurusan != '' AND m.status='A'";
				$join="m left join fakultas f on m.KodeFakultas=f.Kode left join _v2_jurusan j on m.KodeJurusan=j.Kode";
			}

			if ($loguser=="_v2_dosen" or $loguser=="_v2_mhsw"){
				$query_cek=$this->db->query("SELECT m.ID,m.Name$val FROM $loguser $join WHERE m.Login=$username AND m.Password=left(password($password),10)");

				if ($query_cek->num_rows() >= 1){

				  $row_cek=$query_cek->result_array();

				  $pesantambahan = "Terdapat Kesalahan Pada Akun Anda. Silahkan Cek ";

				  if ($loguser == "_v2_dosen"){
						if($row_cek[0]["kdf"] == '') $pesantambahan .= "Fakultas Anda"; // Mahasiswa dan Dosen
						if($row_cek[0]["NA"] != 'N') $pesantambahan .= "Status Anda Tidak Aktif"; // Dosen
				  } else if ($loguser == "_v2_mhsw"){
						if($row_cek[0]["kdf"] == '') $pesantambahan .= "Fakultas Anda"; // Mahasiswa dan Dosen
						if($row_cek[0]["kdj"] == '') $pesantambahan .= "Jurusan Anda"; // Mahasiswa
						if($row_cek[0]["status"] != 'A') {
							$statmhsw=$this->db->query("SELECT * FROM _v2_statusmhsw where Kode='".$row_cek[0]["status"]."'")->row();

							$pesantambahan .= "Status Mahasiswa Anda, Karena Anda Berstatus <b>".$statmhsw->Nama."</b>";// Nama Status Mahasiswa
						}
				  }

				} else {

				  $pesantambahan = "Username/Password Anda Salah / Tidak Terdaftar";

				}

				/* fandu perbaiki saat cek di untad mobile 09-12-2018
				$row_cek=$query_cek->result_array();

				$pesantambahan = "";

				if ($loguser == "_v2_dosen"){
					if($row_cek[0]["kdf"] == '') $pesantambahan .= "/Fakultas"; // Mahasiswa dan Dosen
					if($row_cek[0]["NA"] != 'N') $pesantambahan .= "/Tidak Aktif"; // Dosen
				} else if ($loguser == "_v2_mhsw"){
					if($row_cek[0]["kdf"] == '') $pesantambahan .= "/Fakultas"; // Mahasiswa dan Dosen
					if($row_cek[0]["kdj"] == '') $pesantambahan .= "/Jurusan"; // Mahasiswa
					if($row_cek[0]["status"] != 'A') $pesantambahan .= "/Status";// Mahasiswa
				}*/
			}

			$this->session->set_flashdata('konfirmasi',"$pesantambahan. Silahkan Cek Kembali dengan Benar Akun Anda");
			$log_in = "N";
		} else {
			$this->rem_menu();

			$row=$query->result_array();
			$id=$row[0]["ID"];
			$ulogin=$row[0]["Login"];
			$name=$row[0]["Name"];
			$kdf=$row[0]["kdf"];
			$kdj=$row[0]["kdj"];
			$foto=$row[0]["Foto"];
			$sex=$row[0]["Sex"];
			$nama=$row[0]["Name"];
			$count_edit_password=$row[0]["count_edit_password"];
			if ($count_edit_password == 0){
				$count_edit_password = "editpassword";
			}
			$level = $usr_lev;

			$user=array(
				"id"=>$id,
				"uname"=>$name,
				"ulevel"=>$level,
				"unip"=>$ulogin,
				"kdf"=>$kdf,
				"kdj"=>$kdj,
				"foto"=>$foto,
				"sex"=>$sex,
				"nama"=>$nama,
				"jumlahlogin"=>$count_edit_password,
				"stat"=>1
			);
			$this->session->set_userdata($user); // untuk session

			$this->session->set_flashdata('ubahpassword',"$count_edit_password"); // untuk flash session
		//	echo "$stat -- $usr_lev<br>";
		//	echo "success";
			$log_in = "Y";
		}

		echo "Anda terdeteksi telah melanggar sistem, <br> Dengan segera anda mendapat Amplop cokelat dari kepolisian";
		$this->db->query("INSERT INTO _v2_log_login (id, log_user, log_pass, time, str, ip_address, info, hostname, sign_in) VALUES ('', $username, $password, NOW(), UNIX_TIMESTAMP(NOW()), '$ip_address', '$info', '$hostname', '$log_in')");
		redirect(base_url('menu'));
	}

	public function logout (){
		$this->session->sess_destroy();
		redirect(base_url('menu'));
	}

	public function rem_menu(){
		$int = $this->session->userdata('int');
		for ($a=0; $a<$int; $a++){
			$this->session->unset_userdata($a.'T');
			$this->session->unset_userdata($a.'G');
			$this->session->unset_userdata($a.'GI');
			$this->session->unset_userdata($a.'M');
			$this->session->unset_userdata($a.'A');
		}
		$this->session->unset_userdata('uname');
		$this->session->unset_userdata('ulevel');
		$this->session->unset_userdata('stat');
	}

	// =================//
	// fikri titip prc	//
	// =================//
	private function print_pre($data)
	{
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
	public function form($method='form')
	{
		$act = base_url('prc/').$method;
		$form ='<form action="'.$act.'" method="POST">
				<label>Nim</label>
					<input type="text" name="NIM">
					<button type="submit">Go</button>
				</form><br>';
		echo $form;
		if ($_POST) {
			# code...
			print_r($_POST);
		}
	}
	private function runWS($data)
	{

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
	private	function getToken()
	{

		$dataToken = array (
			'act' => 'GetToken',
			'username' => '001028e1',
			'password' => 'az18^^'
		);		
		$tokenFeeder = $this->runWS($dataToken);
		$obj = json_decode($tokenFeeder);
		$token = $obj->data->token;
		return $token;
	}
	function getBiodata($nim='')
	{
		$token = $this->getToken();
		$required = array(
			'act'		=> 'GetDataLengkapMahasiswaProdi',
			'token'		=> $token,
			'filter'	=> "nim like '".$nim."'",
			'limit'		=> 1,
			'offset'	=> 0
		);

		return $respons = ($this->runWS($required));
	}
	public function hapus_history_pendidikan($value='')
	{
		if ($this->input->post()) {
			$token = $this->getToken();
			$nims = $this->input->post('NIM');
 			if ($_POST['NIM']!='') {
				$nims = explode(',', $_POST['NIM']);
				foreach ($nims as $nim) {
					$sql = "SELECT * FROM _v2_mhsw WHERE NIM like '".$nim."'";
					$data = $this->db->query($sql)->result_array()[0];
					$id_reg_pd = $data['id_reg_pd'];

					$dataMhsw = array();
					$dataMhsw['id_registrasi_mahasiswa'] = $id_reg_pd;

					$dataBiodataTransfer = array(
						'act' => 'DeleteRiwayatPendidikanMahasiswa',
						'token' => $token,
						'key' => $dataMhsw
				 	);

				 	$dataBiodataFeeder = $this->runWS($dataBiodataTransfer);
				 	$obj = json_decode($dataBiodataFeeder);
				 	$error_code = $obj->{'error_code'};
				 	$error_desc = $obj->{'error_desc'};
				 	$id_BiodataDikti = $obj->{'data'};

			 		echo $error_code." | ".$error_desc." | ".$id_BiodataDikti;
			 		if ($error_code==0) {
			 			$sql = "UPDATE _v2_mhsw SET id_reg_pd = null, st_feeder =0 WHERE NIM ='".$nim."'";
			 			$result = $this->db->query($sql);
			 			print_r($result);
			 		}
			 		echo "<hr/>";
				}
			}
		}
	}
	public function GetListMahasiswa($value='')
	{
		$id_reg_pd = $value;
		$nim['nim'] = 'A40119002';
		$input = array(
			'act'		=> 'GetListMahasiswa',
			'token'		=> $this->getToken(),
			'filter'	=> json_encode($nim),
			'limit'		=> 3,
			'offset'	=> 0
		);
		$res = $this->runWS($input);
		print_r($res);
	}
// ============================================================================== //
	function updateIdFdr($a='0',$b='50')
	{
		$c = $a+$b;
		$page= $c.'/'.$b;
		echo "<a href='https://siakad2.untad.ac.id/prc/updateIdFdr/".$page."'>next<a/><br>";
		
	  	$quer = "SELECT ID,id_pd,id_reg_pd,login,NIM,Name,Sex,NIK,NamaOT,NamaIbu,TempatLahir,TglLahir,AgamaID FROM _v2_mhsw WHERE tahunAkademik='2019' and st_feeder=0 limit $a,$b";
		$res = $this->db->query($quer)->result_array();
		// echo '<pre>';
		// print_r($res);
		// echo '<pre/>';
		
		foreach ($res as $input) {
			$res =$this->getBiodata($input['login']);
			$tes = json_decode($res);
			if ($tes->data) {
				$d = $tes->data;

				foreach ($d as $data) {
					$set = array (
						'st_feeder'	=> '1',
						'id_pd' 	=> $data->id_mahasiswa,
						'id_reg_pd'	=> $data->id_registrasi_mahasiswa
					);
					// if($input['nim']==$data->nim){
						$where = array('login' => $data->nim);
						$this->db->set($set);
						$this->db->where($where);
						$ress = $this->db->update('_v2_mhsw');
						echo $ress.' - '.$input['login'].'-'.$data->nim.'-'.$data->id_mahasiswa.' dan '.$data->id_registrasi_mahasiswa;

						// echo 'nim cocok '.$input['login'].'=='.$data->nim;
					// }else{
					// 	echo 'nim tidak cocok '.$input['login'].'=='.$data->nim;
					// }
				}
			}else{
				echo $input['login'].": Tidah ada di feeder";
			}
			echo "<hr/>";
		}
	}

	function tes()
	{
		$token = $this->getToken();
		$filter=array(
			'id_mahasiswa'=>'ca54dacc-ca4b-45d2-bfe4-d4f8fcf95276'
		);
		$required = array(
			'act'		=> 'GetBiodataMahasiswa',
			'token'		=> $token,
			'filter'	=> "nama_mahasiswa = 'RAHMAN'",
			'limit'		=> 0,
			'offset'	=> 0
		);
		$res = $this->runWS($required);
		$this->print_pre($res);
	}

}
