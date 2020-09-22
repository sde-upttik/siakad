<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

class Siakad_years extends CI_Controller {

	private $db2;

	public function __construct(){
		parent::__construct();
		$this->db2 = $this->load->database('spc', TRUE);
	}

	public function index() {
		//$data['jurusan'] = $this->matakuliah_smtr_model->get_dataSearch();
		$data['detailperiodeaktif'] = $this->db->query(" SELECT * FROM _v2_periode_aktif where status='aktif'")->row();
		$data['periodeaktif'] = $this->db->query("SELECT nama_periode, periode_aktif, status FROM _v2_periode_aktif")->result();
		//$this->app->checksession(); // untuk pengecekan session
		$this->load->view('dashbord', $data);
	}

	// update setiap awal semester dan mengupdate statusbayar dan statuskrs menjadi 0
	public function prcstatbayar($tahunaktif) {
		$this->app->checksession(); // untuk pengecekan session
		$this->app->check_modul(); // untuk pengecekan session
		$user_proses = $this->session->userdata('unip');

		// update semua status bayar mahasiswa menjadi 0 kecuali mahasiswa lulus
		$data = array(
			'StatusBayar' => 0,
			'StatusKRS' => 0
		);

		$this->db->where('Status !=', 'L');
		$this->db->update('_v2_mhsw', $data);

		// update point2 pada tabel _v2_periode_aktif

		$dataupdate = array(
			'point2' => 1,
			'point2_user' => "$user_proses"
		);
		
		$this->db->set('point2_tgl', 'NOW()', FALSE);
		
		$this->db->where('periode_aktif', $tahunaktif);
		//$this->db->where('point2', 0);
		$this->db->update('_v2_periode_aktif', $dataupdate);

		redirect(base_url('ademik/siakad_years'));

	}

	// proses pembayaran dari spc ke siakad
	public function prc_spctosiakad() {
		//$this->app->checksession(); // untuk pengecekan session
		//$this->app->check_modul(); // untuk pengecekan session
		/*
		SELECT p.id_record_tagihan,p.key_val_2 as key_val_2,t.nama,p.waktu_transaksi,p.total_nilai_pembayaran, dt.kode_jenis_biaya FROM pembayaran AS p, tagihan AS t, detil_tagihan as dt WHERE t.id_record_tagihan=p.id_record_tagihan and p.waktu_transaksi >= '2018-08-01' and kode_periode >='20181' and t.id_record_tagihan=dt.id_record_tagihan and dt.kode_jenis_biaya='UKT' order by p.waktu_transaksi ASC;
		*/
		// fandu matikan sementara $tahun = $this->input->post('tahun');
		$user_proses = $this->session->userdata('unip');
		// $tahun = "20183";
		$tahun = "20191";
		// proses pengambilan tagihan dari spc ke siakad
		// echo $tahun;

		if (!empty($user_proses)){
			$id = $this->cek_log();
			// $id = "2019-06-01";
			$qrspc="SELECT p.id_record_tagihan,p.key_val_2 as key_val_2,t.nama,t.kode_fakultas,t.kode_prodi,p.waktu_transaksi,p.total_nilai_pembayaran, dt.kode_jenis_biaya FROM pembayaran AS p, tagihan AS t, detil_tagihan as dt WHERE t.id_record_tagihan=p.id_record_tagihan and p.waktu_transaksi > '$id' and kode_periode >='$tahun' and t.id_record_tagihan=dt.id_record_tagihan and ( dt.kode_jenis_biaya like '%SPP%' or dt.kode_jenis_biaya like '%UKT%' or dt.kode_jenis_biaya like '%COA%' or dt.kode_jenis_biaya like '%SP%' or dt.kode_jenis_biaya like '%RMD%' or dt.kode_jenis_biaya like '%REMEDIAL%' or dt.kode_jenis_biaya like '%P3S%') order by p.waktu_transaksi ASC limit 1000";
			$wspc1 = $this->db2->query($qrspc);
			echo "$qrspc";
		}
		
		foreach ($wspc1->result() as $wspc) {

			$key_val_2 = $wspc->key_val_2;
			$id_record_tagihan_spc = $wspc->id_record_tagihan;
			$waktu_transaksi = $wspc->waktu_transaksi;
			$nama_mhs = $this->db->escape($wspc->nama);
			$kodefakultas = $wspc->kode_fakultas;
			$kodejurusan = $wspc->kode_prodi;

			$ins="select * from `_v2_spp2` where  id_record_tagihan='$id_record_tagihan_spc'";
			$count = $this->db->query($ins)->num_rows();

			if ($count == 0){

					$dataSPP2 = array(
						'StatusMhs' => 'A',
						'nim' => $key_val_2,
						'tahun' => $tahun,
						'KodeFakultas' => $kodefakultas,
						'KodeJurusan' => $kodejurusan,
						'bayar' => '1',
						'TotalBayar' => '',
						'id_record_tagihan' => $id_record_tagihan_spc,
						'tgl' => $waktu_transaksi
					);

					$this->db->insert('_v2_spp2',$dataSPP2);

					$timespc = array(
						'nim' => $key_val_2,
						'tahun' => $tahun,
						'waktu_transaksi' => $waktu_transaksi,
						'user_proses' => $user_proses
					);

					$this->db->insert('_v2_waktu_spc',$timespc);

					// update tabel _v2_mhsw status bayar dan tahun status
					$upd="UPDATE `_v2_mhsw` set StatusBayar=1, TahunStatus='$tahun', Status='A' where NIM='$key_val_2'";
					$this->db->query($upd);

					// $dataError = array(
					// 	'ket' => 'success',
					// 	'pesan' => 'Data berhasil terkirim',
					// 	'nim' => $key_val_2
					// );
					echo "data berhasil dikirim - $key_val_2 <br>";
			} else {
				// matikan sementara echo "Data Sudah Ada - $key_val_2<br>";
				// $dataError = array(
				// 	'ket' => 'Error',
				// 	'pesan' => 'Data Sudah Ada',
				// 	'nim' => $key_val_2
				// );

				$timespc = array(
					'waktu_transaksi' => $waktu_transaksi,
					'user_proses' => $user_proses
				);

				$this->db->where('nim',$key_val_2);
				$this->db->where('tahun',$tahun);
				$this->db->update('_v2_waktu_spc',$timespc);

				echo "data sudah ada - $key_val_2 <br>";
			}
		}
		
		$dataupdate = array(
			'point3' => 1,
			'point3_user' => "$user_proses"
		);
		$this->db->set('point3_tgl', 'NOW()', FALSE);
		
		$this->db->where('periode_aktif', $tahun);
		//$this->db->where('point2', 0);
		$this->db->update('_v2_periode_aktif', $dataupdate);

		echo json_encode($dataError);
	}

	// log waktu pada pembayaran spc
	private function cek_log(){
		$id = 0;
		$qr = "SELECT max(waktu_transaksi) as waktu_transaksi FROM _v2_waktu_spc limit 1";
		$r = $this->db->query($qr);
			foreach ($r->result() as $w) {
			{
				$id = $w->waktu_transaksi;
			}
			return $id;
		}
	}

	// proses mahasiswa yang membayar tapi tidak ber KRS pada Tahun Akademik Aktif
	public function update_statbayar() {
		$user_proses = $this->session->userdata('unip');

		$select = "SELECT m.* FROM _v2_mhsw m join _v2_periode_aktif pa on m.TahunStatus=pa.periode_aktif WHERE pa.status='aktif' and m.StatusBayar='1' and m.StatusKRS='0'";
		$count = $this->db->query($select)->num_rows();

		$qrupdt="UPDATE _v2_periode_aktif set point4='1', point4_count='$count', point4_tgl=NOW(),point4_user='$user_proses' WHERE status='aktif'";
		$wspc1 = $this->db->query($qrupdt);

		$this->session->set_flashdata('status', 'Proses Mahasiswa Membayar dan Tidak KRS Berhasil');

		redirect(base_url('ademik/siakad_years'));
	}

	// proses mahasiswa yang tidak membayar tapi ber KRS pada Tahun Akademik Aktif, bisa jadi mahasiswa mendapatkan BIDIKMISI atau BEASISWA
	public function update_statkrs() {
		$user_proses = $this->session->userdata('unip');

		$select = "SELECT m.* FROM _v2_mhsw m join _v2_periode_aktif pa on m.TahunStatus=pa.periode_aktif WHERE pa.status='aktif' and m.StatusBayar='0' and m.StatusKRS='1'";
		$count = $this->db->query($select)->num_rows();

		$qrupdt="UPDATE _v2_periode_aktif set point5='1', point5_count='$count', point5_tgl=NOW(), point5_user='$user_proses' WHERE status='aktif'";
		$wspc1 = $this->db->query($qrupdt);

		$this->session->set_flashdata('status', 'Proses Mahasiswa Tidak Membayar dan Tidak Berhasil');

		redirect(base_url('ademik/siakad_years'));
	}
	
	public function simpan_periodeaktif(){
		$this->app->checksession(); // untuk pengecekan session
		$this->app->check_modul(); // untuk pengecekan session
		$user_proses = $this->session->userdata('unip');

		$kdpriode = $this->input->post('kdperiode');
		$nmpriode = $this->input->post('nmperiode');
		
		// insert semua priode aktif
		
		$data = array(
			'nama_periode' => $nmpriode,
			'periode_aktif' => $kdpriode,
			'user_buka_periode' => $user_proses,
			'status' => 'tidak',
		);
		
		$this->db->insert('_v2_periode_aktif', $data);

		redirect(base_url('ademik/siakad_years'));		
	}
	
	public function edit_periodeaktif(){
		$this->app->checksession(); // untuk pengecekan session
		$this->app->check_modul(); // untuk pengecekan session
		$user_proses = $this->session->userdata('unip');

		// update semua priode aktif
		$data = array(
			'status' => 'tidak'
		);
		$this->db->update('_v2_periode_aktif', $data);

		
		// update aktif pada tabel _v2_periode_aktif
		
		$tahunaktif = $this->input->post('kode_periode');
		
		$dataupdate = array(
			'status' => 'aktif'
		);
		
		$this->db->where('periode_aktif', $tahunaktif);
		$this->db->update('_v2_periode_aktif', $dataupdate);

		redirect(base_url('ademik/siakad_years'));		
	}

	//WAWAN
	public function feeder_mhsw($tahunaktif){
		$tahunaktif = substr($tahunaktif, 0, 4);
		$username = '001028e1';
		$password = 'az18^^';


		function runWS($data){

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

		$dataToken = array (
			'act' => 'GetToken',
			'username' => $username,
			'password' => $password
		);

		$tokenFeeder = runWS($dataToken);
		$obj = json_decode($tokenFeeder);
		$token = $obj->{'data'}->{'token'};

		echo $token;
		echo "<br><br>";
		echo "<b>===========PROSES MENDAPATKAN ID PD===========</b>";
		echo "<br><br>";

		$_sql = "SELECT ID,id_pd,id_reg_pd,NIM,Name,Sex,NIK,NamaOT,NamaIbu,TempatLahir,TglLahir,AgamaID,KodeJurusan FROM _v2_mhsw WHERE TahunAkademik='$tahunaktif' AND (NamaIbu!='' OR NamaIbu!='ibu') AND TempatLahir!='' AND TglLahir!='0000-00-00' AND id_pd is NULL AND AgamaID!='' AND error_code='' LIMIT 500";

		$_res = $this->db->query($_sql)->result();
		
		$mhsw = array();
		foreach ($_res as $show) {
			array_push($mhsw, $show);
		}
		//print_r($mhsw);
		$i=0;
		foreach ($mhsw as $show) {
			//print_r($show);
			$dataMhsw = array(
				'nama_mahasiswa'=>$show->Name, 
				'jenis_kelamin' => $show->Sex,
				'tempat_lahir' => $show->TempatLahir,
				'tanggal_lahir' => $show->TglLahir,
				'id_agama' => $show->AgamaID,
				'nik' => $show->NIK,
				'kewarganegaraan' => 'ID',
				'kelurahan' => 'Tondo',
				'id_wilayah' => '186000',
				'penerima_kps' => '0',
				'nama_ibu_kandung' => $show->NamaIbu,
				'id_kebutuhan_khusus_mahasiswa' => '0',
				'id_kebutuhan_khusus_ayah' => '0',
				'id_kebutuhan_khusus_ibu' => '0'	
			);
			
			$dataBiodataTransfer = array(
				'act' => 'InsertBiodataMahasiswa',
				'token' => $token,
				'record' => $dataMhsw
		 	);

		 	$dataBiodataFeeder = runWS($dataBiodataTransfer);
		 	$obj = json_decode($dataBiodataFeeder);
		 	print_r($obj);
		 	$error_code = $this->db->escape_str( $obj->{'error_code'});
		 	$error_desc = $this->db->escape_str($obj->{'error_desc'});

		 	if ( $error_code == 0 ) {
		 		$id_BiodataDikti = $obj->{'data'}->{'id_mahasiswa'};
		 		$qrupdt="UPDATE _v2_mhsw SET id_pd='$id_BiodataDikti' WHERE ID='$show->ID'";
				$this->db->query($qrupdt);

		 		echo $error_code;
		 	} else {
		 		$qrupdt="UPDATE _v2_mhsw SET error_code='$error_code', error_desc='$error_desc' WHERE ID='$show->ID'";
				$this->db->query($qrupdt);
		 		echo $error_code;
		 		echo $error_desc;
		 	}
		 	$i++;

			echo $show->NIM." ".$show->KodeJurusan." ".$show->Name." ";
		 	echo $i."<br><br>";
		}


		echo "<b>===========PROSES MENDAPATKAN ID REG PD===========</b>";
		echo "<br><br>";

		$_sql = "SELECT m.ID,m.id_pd,m.id_reg_pd,m.NIM,m.Name,m.Tanggal,m.StatusAwal,m.Semester,j.id_sms,m.KodeJurusan FROM _v2_mhsw m LEFT JOIN _v2_jurusan j ON m.KodeJurusan=j.Kode WHERE m.TahunAkademik='$tahunaktif' AND (m.id_pd IS NOT NULL AND m.id_pd!='') AND (m.id_reg_pd IS NULL OR m.id_reg_pd =  '') AND StatusAwal='B' AND m.error_code='' LIMIT 500";
	
		$_res = $this->db->query($_sql)->result();
		
		$mhsw = array();
		foreach ($_res as $show) {
			array_push($mhsw, $show);
		}

		$i=0;
		foreach ($mhsw as $show) {
			//print_r($show);
			echo $show->NIM." ".$show->KodeJurusan." ".$show->Name;
			if($show->Tanggal=='0000-00-00'){
				$Tanggal='2018-08-01';
			}else{
				$Tanggal=$show->Tanggal;
			}
			if($show->Semester=='0'){
				$Semester='20181';
			}else{
				$Semester=$show->Semester;
			}
			$dataMhsw = array();
			$dataMhsw['id_mahasiswa'] = $show->id_pd;
			$dataMhsw['nim'] = $show->NIM;
			$dataMhsw['id_jenis_daftar'] = "1";
			$dataMhsw['id_periode_masuk'] = $Semester;
			$dataMhsw['tanggal_daftar'] = $Tanggal;
			$dataMhsw['id_perguruan_tinggi'] = '8e5d195a-0035-41aa-afef-db715a37b8da';
			$dataMhsw['id_prodi'] = $show->id_sms;

			$dataBiodataTransfer = array(
				'act' => 'InsertRiwayatPendidikanMahasiswa',
				'token' => $token,
				'record' => $dataMhsw
		 	);

		 	$dataBiodataFeeder = runWS($dataBiodataTransfer);
		 	$obj = json_decode($dataBiodataFeeder);
		 	$error_code = $this->db->escape_str($obj->{'error_code'});
		 	$error_desc = $this->db->escape_str($obj->{'error_desc'});

		 	if ( $error_code == 0 ) {
		 		$id_BiodataDikti = $obj->{'data'}->{'id_registrasi_mahasiswa'};
		 		$qrupdt="UPDATE _v2_mhsw SET id_reg_pd='$id_BiodataDikti',Semester='$Semester',st_feeder='1' WHERE ID='$show->ID'";
				$this->db->query($qrupdt);
				echo $error_code;
		 	} else {
		 		$qrupdt="UPDATE _v2_mhsw SET error_code='$error_code', error_desc='$error_desc' WHERE ID='$show->ID'";
				$this->db->query($qrupdt);echo $error_code;
		 		echo $error_desc;
		 	}
		 	$i++;
		 	echo $i."<br><br>";
		}

	}

}
