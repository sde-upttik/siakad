<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

class Menu extends CI_Controller {

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

	public function __construct()
	{
		parent::__construct();
		$this->load->library('encryption');
		$this->Front = & get_instance();
		$this->load->model('additional_model');
		$this->load->model('krs_model');
	}

	public function index()
	{
		$uname=$this->session->userdata('uname');
		$ulevel=$this->session->userdata('ulevel');
		if (!empty($uname) and !empty($ulevel)){

			$data['berita'] = $this->additional_model->getTampilBerita();

			$urutan = 0;
			$urutantgl = 0;

			for ($i=1; $i<=count($data['berita']); $i++){
				$data['konten'][$urutan] = $this->limit_words($data['berita'][$urutan++]->Konten,40);
				$data['tgl'][$urutantgl] = $this->tanggal_indonesia(date('d-m-Y',strtotime($data['berita'][$urutantgl++]->Tgl)));
			}

			$this->tmenu($ulevel);
			$this->load->view('dashbord',$data);

		} else {
			$this->load->view('login');
		}
	}

	public function dashboard()
	{
		$uname=$this->session->userdata('uname');
		$ulevel=$this->session->userdata('ulevel');
		$tamp = $this->session->userdata('sess_tamplate');
		if (!empty($uname) and !empty($ulevel)  and !empty($tamp)){

			$data['berita'] = $this->additional_model->getTampilBerita();

			$urutan = 0;
			$urutantgl = 0;

			for ($i=1; $i<=count($data['berita']); $i++){
				$data['konten'][$urutan] = $this->limit_words($data['berita'][$urutan++]->Konten,40);
				$data['tgl'][$urutantgl] = $this->tanggal_indonesia(date('d-m-Y',strtotime($data['berita'][$urutantgl++]->Tgl)));
			}

			$this->load->view('temp/head');
			$this->load->view('temp/index',$data);
			$this->load->view('temp/footers');
		} else {
			$this->load->view('login');
		}
	}

	public function tes (){
		$ulevel = 4;
		$nim = "N21016058";
		$fed = $this->fedeer($ulevel,$nim);

		echo $fed['terkirim']."<br>";
		echo $fed['gagal']."<br>";
		echo $fed['notaction']."<br>";
		echo $fed['terkirimkhs']."<br>";
		echo $fed['gagalkhs']."<br>";
		echo $fed['notactionkhs']."<br>";
	}

	private function fedeer($ulevel,$nim) {
		$getpriodeaktif= $this->krs_model->getSemesterAkademikAktif();
		$priodeaktif = $getpriodeaktif->periode_aktif;
		$tahunx = "";
		if(substr($priodeaktif,4,1)==1){
			$tahunx=$priodeaktif-9;
		}else if(substr($priodeaktif,4,1)==2){
			$tahunx = $priodeaktif-1;
		}

		$terkirim = 0;
		$gagal = 0;
		$notaction = 0;
		$terkirimkhs = 0;
		$gagalkhs = 0;
		$notactionkhs = 0;

		if ($ulevel == 1){
				$row = $this->db->query("SELECT st_feeder, count(st_feeder) FROM _v2_krs$tahunx WHERE NIM='$nim' and Tahun='$tahunx' and NotActive_KRS='N' group by st_feeder")->result();
				$rowkhs = $this->db->query("SELECT st_feeder FROM _v2_khs WHERE NIM='$nim' and Tahun='$tahunx' and NotActive='N'")->result();
		} else if ($ulevel == 4){
				$row = $this->db->query("SELECT st_feeder, count(st_feeder) FROM _v2_krs$tahunx WHERE NIM='$nim' and Tahun='$tahunx' and NotActive_KRS='N' group by st_feeder")->result();
				$rowkhs = $this->db->query("SELECT st_feeder FROM _v2_khs WHERE NIM='$nim' and Tahun='$tahunx' and NotActive='N'")->result();
		} else if ($ulevel == 5){
				$row = $this->db->query("SELECT st_feeder, count(st_feeder) FROM _v2_krs$tahunx WHERE NIM='$nim' and Tahun='$tahunx' and NotActive_KRS='N' group by st_feeder")->result();
				$rowkhs = $this->db->query("SELECT st_feeder FROM _v2_khs WHERE NIM='$nim' and Tahun='$tahunx' and NotActive='N'")->result();
		} else if ($ulevel == 4){
				$row = $this->db->query("SELECT st_feeder, count(st_feeder) FROM _v2_krs$tahunx WHERE NIM='$nim' and Tahun='$tahunx' and NotActive_KRS='N' group by st_feeder")->result();
				$rowkhs = $this->db->query("SELECT st_feeder FROM _v2_khs WHERE NIM='$nim' and Tahun='$tahunx' and NotActive='N'")->result();
		}

		foreach ($row as $value) {
			if ($value->st_feeder == 3 or $value->st_feeder == 4){
				$terkirim += $value->st_feeder;
			} else if ($value->st_feeder == -3){
				$gagal = $value->st_feeder;
			} else {
				$notaction = $value->st_feeder;
			}
		}

		foreach ($rowkhs as $valuekhs) {
			if ($valuekhs->st_feeder == 3 or $valuekhs->st_feeder == 4){
				$terkirimkhs += $valuekhs->st_feeder;
			} else if ($valuekhs->st_feeder == -3){
				$gagalkhs = $valuekhs->st_feeder;
			} else {
				$notactionkhs = $valuekhs->st_feeder;
			}
		}

		$data = array(
			'terkirim' => $terkirim,
			'gagal' => $gagal,
			'notaction' => $notaction,
			'terkirimkhs' => $terkirimkhs,
			'gagalkhs' => $gagalkhs,
			'notactionkhs' => $notactionkhs
		);

		return $data;

	}

	public function cek_session(){
		$uname=$this->session->userdata('uname');
		$ulevel=$this->session->userdata('ulevel');
		if (empty($uname) and empty($ulevel)){
			$this->load->view('login');
		}
	}

	//untuk url
	public function mn(){
		$this->cek_session();
		//$nim = $this->session->userdata('user');
		$uri3 = $this->uri->segment(3);//T1KFaW4R0uPtM4l
		$uri3 = substr($uri3,15);
		//$uri3=str_replace("'","",$uri3);
		//echo $uri3;
		// from controller $val = $this->check($uri3);
		$val = $this->app->check($uri3);
		//echo "$val";

		$cek_maint = $this->db->query("SELECT stat_maintenance FROM modul WHERE Link='$val' and stat_maintenance=0")->num_rows();
		//$row_main = $cek_maint->stat_maintenance;

		if ($cek_maint or ($this->session->userdata('ulevel') == 1)){

			if ($val){
				$uri3=str_replace('-','/',$val);
				$content = 'ademik/'.$uri3;
				//echo $content;
			} else {
				echo "tidak ada - ".$uri3;
			}

			/* fandu matikan $result = $this->db->query("SELECT m.Modul, g.GroupModul  FROM modul m inner join groupmodul g on m.GroupModul=g.GroupModulID WHERE Link='$val'")->row();
			$row = $result->GroupModul;
			$rowmodul = $result->Modul;
			"active_tamplate"=>$row,
			"activemodul_tamplate"=>$rowmodul, */

			$user=array(
					"sess_tamplate"=>$content,
					"tamplate"=>$uri3
				);

			//$a['controller']=$this;
			$this->session->set_userdata($user);

			// untuk yang tidak mau direct
			//$this->load->view('temp/head');
			//$this->load->view($content);
			//$this->load->view('temp/footers');

			//echo $break[0].$uri3;

			// log database menu
			$this->log_siakad->log_menu($content);
			redirect(base_url($content));
			//echo "a";
			//$this->load->file('controllers/ademik/module/module',false);
			//require_once(APPPATH.'controllers/ademik/module/module.php');
			//$obj = new Module();
			//$obj->index();
		} else {
			$this->load->view('temp/head');
			$this->load->view("error_page/maintenance");
			$this->load->view('temp/footers');
		}
	}

	// untuk ajax
	public function cm(){
		$cont = $this->input->post('content');//T1KFaW4R0uPtM4l
		$cont = substr($cont,15);
		// from controller $val = $this->check($cont);
		$val = $this->app->check($cont);

		$cek_maint = $this->db->query("SELECT stat_maintenance FROM modul WHERE Link='$val' and stat_maintenance=0")->num_rows();
		//$row_main = $cek_maint->stat_maintenance;

		if ($cek_maint or ($this->session->userdata('ulevel') == 1)){
			if($val){
			if (empty($val)) $content = '';
			else { $cont=str_replace('-','/',$val); $content = 'ademik/'.$cont; }
			$user=array(
					"sess_tamplate"=>$content,
					"tamplate"=>$cont
				);
			$this->session->set_userdata($user);
			$this->log_siakad->log_menu($content);
			$this->load->view($content);
			}
		} else {
			$user=array(
					"sess_tamplate"=> "error_page/maintenance",
					"tamplate"=> "error_page/maintenance"
				);
			$this->session->set_userdata($user);
			$this->load->view("error_page/maintenance");
		}

	}

	/*public function check($uri3){
		$this->cek_session();
		$int = $this->session->userdata('int');
		for ($a=0; $a<$int; $a++){
			$break[]=md5($this->session->userdata($a.'T'));
		}
		if (in_array($uri3, $break)) {
			$key = array_search($uri3, $break);
			$module=$this->session->userdata($key.'T');
			//echo " fandu ada $key $module";
			return $module;
		} else {
			return false;
		}
	}*/

	function tmenu($ulevel){
		$this->cek_session();
		$res=$this->db->query("SELECT g.GroupModulID, g.GroupModul, m.Modul, m.Link, m.ImgLink, m.ajx FROM groupmodul as g, modul as m WHERE g.Level like '%-$ulevel-%' and m.Level like '%-$ulevel-%' and g.GroupModulID=m.GroupModul and m.NotActive='N' and g.NotActive='N' order by g.GroupModulID, m.ModulID ASC");
			$int = 0;
			foreach ($res->result_array() as $data){
				$user=array(
					"$int"."T" => $data['Link'],
					"$int"."G" => $data['GroupModul'],
					"$int"."GI" => $data['GroupModulID'],
					"$int"."M" => $data['Modul'],
					"$int"."A" => $data['ajx']
				);
				$this->session->set_userdata($user);
				$int++;
				$break[]=md5($data['Link']);
			}

			$menu = array(
				"menu" => $break
			);
			$this->session->set_userdata($menu);

			$user=array(
					"int" => $int
				);
			$this->session->set_userdata($user);

			return $res->result();

	}

	public function fotoProfil() {

		$userLogin = $this->session->userdata('unip');
		$level = $this->session->userdata('ulevel');
		$user = $this->getUser($level);
		$kodeJur = substr($userLogin, 0, 4);

		$data = $this->db->query(" SELECT Sex, Name FROM $user WHERE Login='$userLogin' ")->row();

		$data_profil = array(
			'Sex' => $data->Sex,
			'Name' => $data->Name
		);

		$this->session->set_userdata($data_profil);

	}


	private function getUser($lvl){

		switch($lvl){
			case 1:
				$user='_v2_adm'; //Administrator
				break;
			case 2:
				$user='_v2_pegawai';
				break;
			case 3:
				$user='_v2_dosen';
				break;
			case 4:
				$user='_v2_mhsw';
				break;
			case 5:
				$user='_v2_adm_fak';
				break;
			case 6:
				$user='_v2_adm_pusat';
				break;
			case 7:
				$user='_v2_adm_jur';
				break;
		}

		return($user);

	}

	private function limit_words($string, $word_limit){

	    $words = explode(" ",$string);

	    return implode(" ",array_splice($words,0,$word_limit));

	}

 	private function tanggal_indonesia($formattes){
		$id=array("Januari","Pebruari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

		$tgl = substr($formattes, 0, 2); // memisahkan format tahun menggunakan substring
		$i = substr($formattes, 0, 1);
		if($i=='0') $tgl = substr($formattes, 1, 1);

		$bulan = substr($formattes, 3, 4); // memisahkan format bulan menggunakan substring
		$tahun   = substr($formattes, 6, 9); // memisahkan format tanggal menggunakan substring

		$result = $tgl." ".$id[(int)$bulan-1]." ".$tahun;
		return($result);
	}

	public function setBacaBerita($id) {

		$data = $this->additional_model->getBacaBerita($id);

		$data['berita'] = $this->additional_model->getTampilBerita();

		$urutan = 0;
		$urutantgl = 0;

		for ($i=1; $i<=count($data['berita']); $i++){
			$data['konten'][$urutan] = $this->limit_words($data['berita'][$urutan++]->Konten,30);
			$data['tgl'][$urutantgl] = $this->tanggal_indonesia(date('d-m-Y',strtotime($data['berita'][$urutantgl++]->Tgl)));
		}

		$this->load->view('temp/head');
		$this->load->view('temp/index',$data);
		$this->load->view('temp/footers');

	}

	/*public function simpanform(){
		//unim == nim
		$this->mhsw();
		$unim = $this->session->userdata('user');
		$formaktif = $this->input->post('form');
		if ($formaktif=="form1"){
			$judul1 = $this->input->post('judul1');
			$judul2 = $this->input->post('judul2');
			$judul3 = $this->input->post('judul3');
			$this->db->query("UPDATE proposal SET formstat = 'form2',judul1 = '".$judul1."',judul2 = '".$judul2."',judul3 = '".$judul3."',formactive = '1' WHERE NIM = '$unim'");
		} else if ($formaktif=="form2"){
			$nama = $this->input->post('nama');
			$nip = $this->input->post('nip');
			$acc = $this->input->post('acc');
			$jabatan = $this->input->post('jabatan');
			// agar nantinya bisa untuk upload di tabel proposal
			$this->db->query("UPDATE proposal SET formstat = 'upload',upload = '1',judul_ver = '".$acc."',formactive = '2' WHERE NIM = '$unim'");
			$this->db->query("UPDATE hasil SET judul_lama = '".$acc."' WHERE NIM = '$unim'");
			// untuk surat pernyataan
			$this->db->query("UPDATE surat_pernyataan SET nama_lengkap='$nama',NIP='$nip',jabatan='$jabatan',TIME=now() WHERE NIM='$unim'");
			// agar nantinya bisa upload di tabel upload
			$this->db->query("UPDATE upload SET upload_active='upload1',upload1='1' WHERE NIM='$unim'");
			//$this->index();
		} else if ($formaktif=="form3"){
			// kedua queri agar mahasiswa nantinya dapat mengupload
			$this->db->query("UPDATE proposal SET formstat = 'upload',upload = '1',formactive = '3' WHERE NIM = '$unim'");
			$this->db->query("UPDATE upload SET upload_active='upload2',upload2='1' WHERE NIM='$unim'");
			//$this->index();
		} else if ($formaktif=="form4"){
			$nosk = $this->input->post('nosk');
			$nrj = $this->input->post('nrj');
			$p1 = $this->input->post('p1');
			$p2 = $this->input->post('p2');
			// kedua queri agar mahasiswa nantinya dapat mengupload
			// dibawah tidak perlu di rubah, hanya di tambahhkan update no sk
			$this->db->query("UPDATE proposal SET formstat = 'upload',upload = '1',nosk='$nosk',norek_sk='$nrj', formactive = '4' WHERE NIM = '$unim'");
			$this->db->query("UPDATE pem_penguji SET nip_p1 = '$p1',nip_p2 = '$p2' WHERE NIM = '$unim'");
			// di rubah untuk upload berikutnya
			$this->db->query("UPDATE upload SET upload_active='upload3',upload3='1' WHERE NIM='$unim'");
			//$this->index();
		} else if ($formaktif=="form5"){
			// kedua queri agar mahasiswa nantinya dapat mengupload
			$this->db->query("UPDATE proposal SET formstat = 'upload',upload = '1',formactive = '5' WHERE NIM = '$unim'");
			$this->db->query("UPDATE upload SET upload_active='upload4',upload4='1' WHERE NIM='$unim'");
			//$this->index();
		} else if ($formaktif=="form6"){
			$nokon = $this->input->post('nokon');
			$penguji1 = $this->input->post('penguji1');
			$penguji2 = $this->input->post('penguji2');
			$penguji3 = $this->input->post('penguji3');
			$penguji4 = $this->input->post('penguji4');
			$penguji5 = $this->input->post('penguji5');
			// kedua queri agar mahasiswa nantinya dapat mengupload
			// dibawah tidak perlu di rubah, hanya di tambahhkan update no sk
			$this->db->query("UPDATE proposal SET formstat = 'upload',upload = '1',no_konfirmasi='$nokon',formactive = '6' WHERE NIM = '$unim'");
			$this->db->query("UPDATE pem_penguji SET nip_peng1 = '$penguji1',nip_peng2 = '$penguji2',nip_peng3 = '$penguji3',nip_peng4 = '$penguji4',nip_peng5 = '$penguji5' WHERE NIM = '$unim'");
			// di rubah untuk upload berikutnya
			$this->db->query("UPDATE upload SET upload_active='upload5',upload5='1' WHERE NIM='$unim'");
			//$this->index();
		} else if ($formaktif=="form7"){
			$noundangan = $this->input->post('noundangan');
			$nopenunjuk = $this->input->post('nopenunjukan');
			$nobap = $this->input->post('nobap');
			// kedua queri agar mahasiswa nantinya dapat mengupload
			// dibawah tidak perlu di rubah, hanya di tambahhkan update no sk
			$this->db->query("UPDATE proposal SET formstat = 'upload',upload = '1',no_undangan='$noundangan',no_penunjukan='$nopenunjuk',no_bap='$nobap',formactive = '7' WHERE NIM = '$unim'");
			// di rubah untuk upload berikutnya
			$this->db->query("UPDATE upload SET upload_active='upload6',upload6='1' WHERE NIM='$unim'");
			//$this->index();
		} else if ($formaktif=="form8"){
			$judulperbaikan = $this->input->post('judulperbaikan');
			// kedua queri agar mahasiswa nantinya dapat mengupload
			// dibawah tidak perlu di rubah, hanya di tambahhkan update no sk
			$this->db->query("UPDATE proposal SET formstat = 'upload',upload = '1',formactive = '8' WHERE NIM = '$unim'");
			// di rubah untuk upload berikutnya
			$this->db->query("UPDATE upload SET upload_active='upload7',upload7='1' WHERE NIM='$unim'");
			// untuk menjadi judul lama di skripsi nantinya
			$this->db->query("UPDATE hasil SET judul_ver='$judulperbaikan' WHERE NIM = '$unim'");
			$this->db->query("UPDATE skripsi SET judul_lama = '".$judulperbaikan."' WHERE NIM = '$unim'");
			//$this->index();
		}
		//redirect('menu/mn/pr');
		redirect(base_url());
		//redirect('../'.$tamp);

	}

	public function upload(){
		$unim = $this->session->userdata('user');
		$kdfak = $this->session->userdata('kdfak');
		$this->mhsw();
		//echo "$judul1 $judul2 $judul3";
		// kategori tombol dan banyak upload
		$jupload=$this->input->post('jum_upload');
		if (isset($_POST['upload1'])) {
				//file
			$file_name=$_FILES['inputform1']['name'];
			$t=explode('.',$file_name);
			$file_type=strtolower(end($t));
			$file_size=$_FILES['inputform1']['size'];
			$file_tmpr=$_FILES['inputform1']['tmp_name'];
			$form = "form1";

			$file_name2=$_FILES['inputform2']['name'];
			$t2=explode('.',$file_name2);
			$file_type2=strtolower(end($t2));
			$file_size2=$_FILES['inputform2']['size'];
			$file_tmpr2=$_FILES['inputform2']['tmp_name'];
			$form1 = "form2";
		} else if (isset($_POST['upload2'])) {
			//file
			$file_name=$_FILES['inputform3']['name'];
			$t=explode('.',$file_name);
			$file_type=strtolower(end($t));
			$file_size=$_FILES['inputform3']['size'];
			$file_tmpr=$_FILES['inputform3']['tmp_name'];
			$form = "form3";
		} else if (isset($_POST['upload3'])) {
			//file
			$file_name=$_FILES['inputform4']['name'];
			$t=explode('.',$file_name);
			$file_type=strtolower(end($t));
			$file_size=$_FILES['inputform4']['size'];
			$file_tmpr=$_FILES['inputform4']['tmp_name'];
			$form = "form4";
		} else if (isset($_POST['upload4'])) {
			//file
			$file_name=$_FILES['inputform5']['name'];
			$t=explode('.',$file_name);
			$file_type=strtolower(end($t));
			$file_size=$_FILES['inputform5']['size'];
			$file_tmpr=$_FILES['inputform5']['tmp_name'];
			$form = "form5";
		} else if (isset($_POST['upload5'])) {
			//file
			$file_name=$_FILES['inputform6']['name'];
			$t=explode('.',$file_name);
			$file_type=strtolower(end($t));
			$file_size=$_FILES['inputform6']['size'];
			$file_tmpr=$_FILES['inputform6']['tmp_name'];
			$form = "form6";
		} else if (isset($_POST['upload6'])) {
			//file
			$file_name=$_FILES['inputform7']['name'];
			$t=explode('.',$file_name);
			$file_type=strtolower(end($t));
			$file_size=$_FILES['inputform7']['size'];
			$file_tmpr=$_FILES['inputform7']['tmp_name'];
			$form = "form7";
		} else if (isset($_POST['upload7'])) {
			//file
			$file_name=$_FILES['inputform8']['name'];
			$t=explode('.',$file_name);
			$file_type=strtolower(end($t));
			$file_size=$_FILES['inputform8']['size'];
			$file_tmpr=$_FILES['inputform8']['tmp_name'];
			$form = "form8";
		}


		// kategori uplad ke server file banyak upload
		if ($jupload=="1"){
		$allow_type=array("png","pdf","jpg","jpeg");
		$tmpasli="./data/download$kdfak/";
		if(empty($file_name)){
			$file="";
		}else{
			$typedf=strtolower(strrchr($file_name, "."));
			$file= "$unim - $form".$typedf;
		}
		$check_allowed=in_array($file_type,$allow_type);

		if($check_allowed===true || empty($file_type)){
				//25MB
			if($file_size<=500000 || empty($file_type)){
				$kirimstatus=$this->db->query("UPDATE proposal set $form='$file' where NIM='$unim'");
				if($kirimstatus==true){
					move_uploaded_file($file_tmpr ,$tmpasli.$file);
					$this->db->query("UPDATE proposal SET verivikasi_stat = '1',stat_tunggu = '1' WHERE NIM = '$unim'");
					echo "berhasil";
				}else{
					echo "gagal1";
				}
			}else{
				echo "gagal2";
			}
		}else if($check_allowed===false){
			echo "gagal3";
		}else{
		echo "gagal4";
		}
		} else if ($jupload=="2"){
			$allow_type=array("png","pdf","jpg","jpeg");
			$tmpasli="./data/download$kdfak/";
			//checking file empty
			if(empty($file_name)){
				$file="";
			}else{
				//$randomname=microtime()."_".time();
				$typedf=strtolower(strrchr($file_name, "."));
				$file= "$unim - $form".$typedf;
				$file2= "$unim - $form1".$typedf;
			}
			$check_allowed=in_array($file_type,$allow_type);

			if($check_allowed===true || empty($file_type)){
				//25MB
				if($file_size<=500000 || empty($file_type)){

					$kirimstatus=$this->db->query("UPDATE proposal set $form='$file',$form1='$file2' where NIM='$unim'");
					if($kirimstatus==true){
						move_uploaded_file($file_tmpr ,$tmpasli.$file);
						move_uploaded_file($file_tmpr2 ,$tmpasli.$file2);
						$this->db->query("UPDATE proposal SET verivikasi_stat = '1',stat_tunggu = '1' WHERE NIM = '$unim'");
						//echo "berhasil";
						//$this->session->set_flashdata('pesan','Report Berhasil Tersimpan');
						//redirect(base_url('help'));
					}else{
						//$this->session->set_flashdata('pesan','Report Gagal Tersimpan');
						//redirect(base_url('help'));
						echo "gagal1";
					}
				}else{
					//$this->session->set_flashdata('pesan','Size File Terlalu Besar, Usahakan Kurang dari sama dengan 25 MB');
					//redirect(base_url('help'));
					echo "gagal2";
				}
			}else if($check_allowed===false){
				//$this->session->set_flashdata('pesan','File Harus JPG, PNG, Dan PDF');
				//redirect(base_url('help'));
				echo "gagal3";
			}else{
				//$this->session->set_flashdata('pesan','Ada Yang Error!');
				//redirect(base_url('help'));
				echo "gagal4";
			}
			}else{
				//redirect(base_url('help'));
				echo "Tidak Terpakai";
			}
			redirect('menu/mn/pr');
		//$this->index();
	}


	public function upload1(){
		// fandu rubah hari sabtu
		$this->mhsw();
		$kdfak = $this->session->userdata('kdfak');
		$unim = $this->session->userdata('user');
		$jupload=$this->input->post('jum_upload');
		if (isset($_POST['upload8'])) {
			//file
			$file_name=$_FILES['inputform9']['name'];
			$t=explode('.',$file_name);
			$file_type=strtolower(end($t));
			$file_size=$_FILES['inputform9']['size'];
			$file_tmpr=$_FILES['inputform9']['tmp_name'];
			$form = "form9";
		} else if (isset($_POST['upload9'])) {
			//file
			$file_name=$_FILES['inputform10']['name'];
			$t=explode('.',$file_name);
			$file_type=strtolower(end($t));
			$file_size=$_FILES['inputform10']['size'];
			$file_tmpr=$_FILES['inputform10']['tmp_name'];
			$form = "form10";
		} else if (isset($_POST['upload10'])) {
			//file
			$file_name=$_FILES['inputform11']['name'];
			$t=explode('.',$file_name);
			$file_type=strtolower(end($t));
			$file_size=$_FILES['inputform11']['size'];
			$file_tmpr=$_FILES['inputform11']['tmp_name'];
			$form = "form11";
		} else if (isset($_POST['upload11'])) {
			//file
			$file_name=$_FILES['inputform12']['name'];
			$t=explode('.',$file_name);
			$file_type=strtolower(end($t));
			$file_size=$_FILES['inputform12']['size'];
			$file_tmpr=$_FILES['inputform12']['tmp_name'];
			$form = "form12";
		}


		// kategori uplad ke server file banyak upload
		if ($jupload=="1"){
		$allow_type=array("png","pdf","jpg","jpeg");
		$tmpasli="./data/download$kdfak/";
		if(empty($file_name)){
			$file="";
		}else{
			$typedf=strtolower(strrchr($file_name, "."));
			$file= "$unim - $form".$typedf;
		}
		$check_allowed=in_array($file_type,$allow_type);

		if($check_allowed===true || empty($file_type)){
				//25MB
			if($file_size<=500000 || empty($file_type)){
				$kirimstatus=$this->db->query("UPDATE hasil set $form='$file' where NIM='$unim'");
				if($kirimstatus==true){
					move_uploaded_file($file_tmpr ,$tmpasli.$file);
					$this->db->query("UPDATE hasil SET verivikasi_stat = '1',stat_tunggu = '1' WHERE NIM = '$unim'");
					echo "berhasil";
				}else{
					echo "gagal1";
				}
			}else{
				echo "gagal2";
			}
		}else if($check_allowed===false){
			echo "gagal3";
		}else{
		echo "gagal4";
		}
		} else if ($jupload=="2"){
			$allow_type=array("png","pdf","jpg","jpeg");
			$tmpasli="./data/download$kdfak/";
			//checking file empty
			if(empty($file_name)){
				$file="";
			}else{
				//$randomname=microtime()."_".time();
				$typedf=strtolower(strrchr($file_name, "."));
				$file= "$unim - $form".$typedf;
				$file2= "$unim - $form1".$typedf;
			}
			$check_allowed=in_array($file_type,$allow_type);

			if($check_allowed===true || empty($file_type)){
				//25MB
				if($file_size<=500000 || empty($file_type)){

					$kirimstatus=$this->db->query("UPDATE hasil set $form='$file',$form1='$file2' where NIM='$unim'");
					if($kirimstatus==true){
						move_uploaded_file($file_tmpr ,$tmpasli.$file);
						move_uploaded_file($file_tmpr2 ,$tmpasli.$file2);
						$this->db->query("UPDATE hasil SET verivikasi_stat = '1',stat_tunggu = '1' WHERE NIM = '$unim'");
						//echo "berhasil";
						//$this->session->set_flashdata('pesan','Report Berhasil Tersimpan');
						//redirect(base_url('help'));
					}else{
						//$this->session->set_flashdata('pesan','Report Gagal Tersimpan');
						//redirect(base_url('help'));
						echo "gagal1";
					}
				}else{
					//$this->session->set_flashdata('pesan','Size File Terlalu Besar, Usahakan Kurang dari sama dengan 25 MB');
					//redirect(base_url('help'));
					echo "gagal2";
				}
			}else if($check_allowed===false){
				//$this->session->set_flashdata('pesan','File Harus JPG, PNG, Dan PDF');
				//redirect(base_url('help'));
				echo "gagal3";
			}else{
				//$this->session->set_flashdata('pesan','Ada Yang Error!');
				//redirect(base_url('help'));
				echo "gagal4";
			}
			}else{
				//redirect(base_url('help'));
				echo "Tidak Terpakai";
			}
			redirect('menu/mn/hs');
		//$this->index();
	}

	public function upload2(){
		$kdfak = $this->session->userdata('kdfak');
		$unim = $this->session->userdata('user');
		$jupload=$this->input->post('jum_upload');
		if (isset($_POST['upload12'])) {
			//file
			$file_name=$_FILES['inputform13']['name'];
			$t=explode('.',$file_name);
			$file_type=strtolower(end($t));
			$file_size=$_FILES['inputform13']['size'];
			$file_tmpr=$_FILES['inputform13']['tmp_name'];
			$form = "form13";
		} else if (isset($_POST['upload13'])) {
			//file
			$file_name=$_FILES['inputform14']['name'];
			$t=explode('.',$file_name);
			$file_type=strtolower(end($t));
			$file_size=$_FILES['inputform14']['size'];
			$file_tmpr=$_FILES['inputform14']['tmp_name'];
			$form = "form14";
		} else if (isset($_POST['upload14'])) {
			//file
			$file_name=$_FILES['inputform15']['name'];
			$t=explode('.',$file_name);
			$file_type=strtolower(end($t));
			$file_size=$_FILES['inputform15']['size'];
			$file_tmpr=$_FILES['inputform15']['tmp_name'];
			$form = "form15";
		} else if (isset($_POST['upload15'])) {
			//file
			$file_name=$_FILES['inputform16']['name'];
			$t=explode('.',$file_name);
			$file_type=strtolower(end($t));
			$file_size=$_FILES['inputform16']['size'];
			$file_tmpr=$_FILES['inputform16']['tmp_name'];
			$form = "form16";
		}


		// kategori uplad ke server file banyak upload
		if ($jupload=="1"){
		$allow_type=array("png","pdf","jpg","jpeg");
		$tmpasli="./data/download$kdfak/";
		if(empty($file_name)){
			$file="";
		}else{
			$typedf=strtolower(strrchr($file_name, "."));
			$file= "$unim - $form".$typedf;
		}
		$check_allowed=in_array($file_type,$allow_type);

		if($check_allowed===true || empty($file_type)){
				//25MB
			if($file_size<=500000 || empty($file_type)){
				$kirimstatus=$this->db->query("UPDATE skripsi set $form='$file_name' where NIM='$unim'");
				if($kirimstatus==true){
					move_uploaded_file($file_tmpr ,$tmpasli.$file);
					$this->db->query("UPDATE skripsi SET verivikasi_stat = '1',stat_tunggu = '1' WHERE NIM = '$unim'");
					echo "berhasil";
				}else{
					echo "gagal1";
				}
			}else{
				echo "gagal2";
			}
		}else if($check_allowed===false){
			echo "gagal3";
		}else{
		echo "gagal4";
		}
		} else if ($jupload=="2"){
			$allow_type=array("png","pdf","jpg","jpeg");
			$tmpasli="./data/download$kdfak/";
			//checking file empty
			if(empty($file_name)){
				$file="";
			}else{
				//$randomname=microtime()."_".time();
				$typedf=strtolower(strrchr($file_name, "."));
				$file= "$unim - $form".$typedf;
				$file2= "$unim - $form1".$typedf;
			}
			$check_allowed=in_array($file_type,$allow_type);

			if($check_allowed===true || empty($file_type)){
				//25MB
				if($file_size<=500000 || empty($file_type)){

					$kirimstatus=$this->db->query("UPDATE proposal set $form='$file_name',$form1='$file_name2' where NIM='$unim'");
					if($kirimstatus==true){
						move_uploaded_file($file_tmpr ,$tmpasli.$file);
						move_uploaded_file($file_tmpr2 ,$tmpasli.$file2);
						$this->db->query("UPDATE proposal SET verivikasi_stat = '1',stat_tunggu = '1' WHERE NIM = '$unim'");
						//echo "berhasil";
						//$this->session->set_flashdata('pesan','Report Berhasil Tersimpan');
						//redirect(base_url('help'));
					}else{
						//$this->session->set_flashdata('pesan','Report Gagal Tersimpan');
						//redirect(base_url('help'));
						echo "gagal1";
					}
				}else{
					//$this->session->set_flashdata('pesan','Size File Terlalu Besar, Usahakan Kurang dari sama dengan 25 MB');
					//redirect(base_url('help'));
					echo "gagal2";
				}
			}else if($check_allowed===false){
				//$this->session->set_flashdata('pesan','File Harus JPG, PNG, Dan PDF');
				//redirect(base_url('help'));
				echo "gagal3";
			}else{
				//$this->session->set_flashdata('pesan','Ada Yang Error!');
				//redirect(base_url('help'));
				echo "gagal4";
			}
			}else{
				//redirect(base_url('help'));
				echo "Tidak Terpakai";
			}
			redirect('menu/mn/sk');
		//$this->index();
	}


	public function tgl_ind($data){
/*		$data=$this->session->userdata('tanggal');
		$format=date("l-d-F-Y",strtotime($data));
		$arr=explode("-", $format);
		$tgl=$arr[1];
		$thn=$arr[3];

		if($arr[0]=="Sunday"){
			$hari = "Minggu";
		}elseif($arr[0]=="Monday"){
			$hari = "Senin";
		}elseif ($arr[0]=="Tuesday") {
			$hari ="Selasa";
		}elseif ($arr[0]=="Wednesday") {
			$hari = "Rabu";
		}elseif ($arr[0]=="Thursday") {
			$hari = "Kamis";
		}elseif ($arr[0]=="Friday") {
			$hari = "Jumat";
		}elseif ($arr[0]=="Saturday") {
			$hari = "Sabtu";
		}

		switch ($arr[2]) {
			case 'January':
				$bln="Januari";
				break;
			case 'February':
				$bln="Februari";
				break;
			case 'March':
				$bln="Maret";
				break;
			case 'April':
				$bln="April";
				break;
			case 'May':
				$bln="Mei";
				break;
			case 'June':
				$bln="Juni";
				break;
			case 'July':
				$bln="Juli";
				break;
			case 'August':
				$bln="Agustus";
				break;
			case 'September':
				$bln="September";
				break;
			case 'October':
				$bln="Oktober";
				break;
			case 'November':
				$bln="November";
				break;
			case 'December':
				$bln="Desember";
				break;
		}
	return $hari.', '.$tgl.' '.$bln.' '.$thn;
	}*/

}
