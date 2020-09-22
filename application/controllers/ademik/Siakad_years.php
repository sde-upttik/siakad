<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

class Siakad_years extends CI_Controller {

	private $db2;

	public function __construct(){
		parent::__construct();
		$this->db2 = $this->load->database('spc', TRUE);
		$this->load->library('encryption');
		$this->load->model('ipk_model');
	    $this->load->model('krs_model');
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
			// $id = "2019-06-01"
			$qrspc="SELECT p.id_record_tagihan,p.key_val_2 as key_val_2,t.nama,t.kode_fakultas,t.kode_prodi,p.waktu_transaksi,p.total_nilai_pembayaran, dt.kode_jenis_biaya FROM pembayaran AS p, tagihan AS t, detil_tagihan as dt WHERE t.id_record_tagihan=p.id_record_tagihan and p.waktu_transaksi > '$id' and kode_periode >='$tahun' and t.id_record_tagihan=dt.id_record_tagihan and ( dt.kode_jenis_biaya like '%SPP%' or dt.kode_jenis_biaya like '%UKT%' or dt.kode_jenis_biaya like '%COA%' or dt.kode_jenis_biaya like '%SP%' or dt.kode_jenis_biaya like '%RMD%' or dt.kode_jenis_biaya like '%REMEDIAL%' or dt.kode_jenis_biaya like '%P3S%') order by p.waktu_transaksi ASC limit 100";
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

					$dataError = array(
						'ket' => 'success',
						'pesan' => 'Data berhasil terkirim',
						'nim' => $key_val_2
					);
			} else {
				// matikan sementara echo "Data Sudah Ada - $key_val_2<br>";
				$dataError = array(
					'ket' => 'Error',
					'pesan' => 'Data Sudah Ada',
					'nim' => $key_val_2
				);
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

	//fandu modifikasi proses nya wawan 11 september 2019
	public function feeder_mhsw(){
		$tahunaktif = "2019";
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

		$_sql = "SELECT ID,id_pd,id_reg_pd,NIM,Name,Sex,NIK,NamaOT,NamaIbu,TempatLahir,TglLahir,AgamaID,KodeJurusan FROM _v2_mhsw WHERE TahunAkademik='$tahunaktif' AND (NamaIbu!='' OR NamaIbu!='ibu') AND TempatLahir!='' AND TglLahir!='0000-00-00' AND id_pd is NULL AND AgamaID!='' AND KodeFakultas NOT IN ('G','N') AND error_code is not NULL LIMIT 500"; // error_code=''
		// $sqlIDRegPD = "SELECT m.ID,m.id_pd,m.id_reg_pd,m.NIM,m.Name,m.Tanggal,m.StatusAwal,m.Semester,j.id_sms,m.KodeJurusan FROM _v2_mhsw m LEFT JOIN _v2_jurusan j ON m.KodeJurusan=j.Kode WHERE m.TahunAkademik='$tahunaktif' AND (m.id_pd IS NOT NULL AND m.id_pd!='') AND (m.id_reg_pd IS NULL OR m.id_reg_pd =  '') AND StatusAwal='B' AND ( m.error_code is NULL ) and m.KodeFakultas NOT IN ('G','N') LIMIT 500"; //m.error_code=''
		$sqlIDRegPD = "SELECT m.ID,m.id_pd,m.id_reg_pd,m.NIM,m.Name,m.Tanggal,m.StatusAwal,m.Semester,j.id_sms,m.KodeJurusan FROM _v2_mhsw m LEFT JOIN _v2_jurusan j ON m.KodeJurusan=j.Kode WHERE m.TahunAkademik='$tahunaktif' AND (m.id_pd IS NOT NULL AND m.id_pd!='') AND (m.id_reg_pd IS NULL OR m.id_reg_pd =  '') AND StatusAwal='B' AND  m.KodeFakultas NOT IN ('G','N') and m.error_code='' LIMIT 500"; //


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
			// fandu matikan 
			print_r($obj);
		 	$error_code = $this->db->escape_str( $obj->{'error_code'});
		 	$error_desc = $this->db->escape_str($obj->{'error_desc'});

		 	if ( $error_code == 0 ) {
		 		$id_BiodataDikti = $obj->{'data'}->{'id_mahasiswa'};
		 		$qrupdt="UPDATE _v2_mhsw SET id_pd='$id_BiodataDikti' WHERE ID='$show->ID'";
				$this->db->query($qrupdt);

		 		echo " - Error Code : ".$error_code;
		 	}elseif ( $error_code == 200 ) {
				$input = array(
					'act'		=> 'GetListMahasiswa',
					'token'		=> $token,
					// 'filter'	=> '',
					'filter'	=> "nim = '".$show->NIM."'",
					'limit'		=> 0,
					'offset'	=> 0
				);
				$res = runWS($input);
				$respon = json_decode($res);
				$data = $respon->data;
				if ($respon->error_code == 0) {
					if (count($data)>1) {
						echo json_encode($data);
					}else{
						echo "Duplikat data di feeder";
						echo json_encode($data);
					}
				}else{
					echo $show->NIM.' = '.$respon->error_code.'-'.$error_desc;
				}

		 	}elseif ($error_code == 993 ) {
		 		# code...
		 	} else {
		 		$qrupdt="UPDATE _v2_mhsw SET error_code='$error_code', error_desc='$error_desc' WHERE ID='$show->ID'";
				$this->db->query($qrupdt);
		 		echo " - Error Code : ".$error_code;
		 		echo " - Error Code : ".$error_desc;
		 	}
		 	$i++;

			echo " - Keterangan : ".$show->NIM." ".$show->KodeJurusan." ".$show->Name." ";
		 	echo "<br><br>";
		}

		echo "<b>GET ID REG PD</b>";
		echo "<br><br>";
	
		$_res = $this->db->query($sqlIDRegPD)->result();
		
		$mhsw = array();
		foreach ($_res as $show) {
			array_push($mhsw, $show);
		}

		$i=0;
		foreach ($mhsw as $show) {
			//print_r($show);
			echo $show->NIM." ".$show->KodeJurusan." ".$show->Name;
			if($show->Tanggal=='0000-00-00'){
				$Tanggal='2019-08-01';
			}else{
				$Tanggal=$show->Tanggal;
			}
			if($show->Semester=='0'){
				$Semester='20191';
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
			// fandu matikan 
			print_r($obj);
		 	$error_code = $this->db->escape_str($obj->{'error_code'});
		 	$error_desc = $this->db->escape_str($obj->{'error_desc'});

		 	if ( $error_code == 0 ) {
		 		$id_BiodataDikti = $obj->{'data'}->{'id_registrasi_mahasiswa'};
		 		$qrupdt="UPDATE _v2_mhsw SET id_reg_pd='$id_BiodataDikti',Semester='$Semester',st_feeder='1' WHERE ID='$show->ID'";
				$this->db->query($qrupdt);
				echo " - Error Code : ".$error_code;
		 	} else {
		 		$qrupdt="UPDATE _v2_mhsw SET error_code='$error_code', error_desc='$error_desc' WHERE ID='$show->ID'";
				$this->db->query($qrupdt);
				echo " - Error Code : ".$error_code;
		 		echo " - Error Desc : ".$error_desc;
		 	}
		 	$i++;
		 	echo "<br><br>";
		}

	}

	// Fandu Kirim Semua Mahasiswa KRS ke feeder kecuali kedokteran
	public function feeder_krs_all_mhsw(){
		

		header ('Refresh: 5; URL=https://siakad2.untad.ac.id/ademik/siakad_years/feeder_krs_all_mhsw');
		$tahunaktif = "20182";

		echo "<br><br>";
		echo "<b>=========== GET KRS Mahasiswa Tahun $tahunaktif===========</b>";
		echo "<br><br>";

		$feeder = $this->feeder->getToken_feeder();
		$temp_token = $feeder['temp_token'];
		$temp_proxy = $feeder['temp_proxy'];

		$tbl = "_v2_krs$tahunaktif";

		$query = $this->db->query("SELECT j.id_kelas_kuliah as id_kls, j.IDJADWAL, m.id_reg_pd, m.NIM, m.KodeFakultas, n.ID as IDKRS, n.KodeMK, n.Tahun, n.nilai as nilai_angka, n.GradeNilai as nilai_huruf, n.Bobot as nilai_indeks from _v2_jadwal j,_v2_mhsw m,$tbl n where n.st_feeder NOT IN ('1','3','4') and (n.GradeNilai != '' or n.GradeNilai != 'E') and n.error_code = '' and j.IDJADWAL=n.IDJADWAL and n.NIM=m.NIM and m.KodeFakultas NOT IN ('B','G','L','O','N') order by n.NIM limit 1000");	

		// $query = $this->db->query("SELECT j.id_kelas_kuliah as id_kls, j.IDJADWAL, m.id_reg_pd, m.NIM, m.KodeFakultas, n.ID as IDKRS, n.KodeMK, n.Tahun, n.nilai as nilai_angka, n.GradeNilai as nilai_huruf, n.Bobot as nilai_indeks from _v2_jadwal j,_v2_mhsw m,$tbl n where n.st_feeder NOT IN ('1','3','4') and (n.GradeNilai != '' or n.GradeNilai != 'E') and n.error_code = '' and j.IDJADWAL=n.IDJADWAL and n.NIM=m.NIM and m.KodeFakultas IN ('A') order by n.NIM limit 1");

        $qKrsFeeder = $query->result();

		foreach ($qKrsFeeder as $show) {
			$IDKRS = $show->IDKRS;
			$id_kls = $show->id_kls;
			$id_reg_pd = $show->id_reg_pd;
			$NIM = $show->NIM;
			$kdf = $show->KodeFakultas;
			$nil_ang = $show->nilai_angka;
			$nil_huruf = $show->nilai_huruf;
			$nil_indeks = $show->nilai_indeks;
			$kode_mk = $show->KodeMK;
			$idjadwal = $show->IDJADWAL;
			$tahun = $show->Tahun;
			$nilai_huruf = $show->nilai_huruf;

			if($tahun >= 20182){
				$getEncrypt = $this->krs_model->get_encrypt($IDKRS,$tbl);
				$krsEncrypt = $getEncrypt->enkripsi;
				$dataDecrypt = $this->encryption->decrypt($krsEncrypt);

				$decrypt=explode('|', $dataDecrypt);

				if((($kdf == "D" or $kdf == "F" or $kdf == "A" or $kdf == "H") and $tahunaktif == "20182") or $decrypt[0]==$NIM AND $decrypt[1]==$idjadwal AND $decrypt[2]==$tahun AND $decrypt[3]==$nilai_huruf AND $decrypt[4]==$nil_indeks){
					if(!($kdf == "D" or $kdf == "F" or $kdf == "H" or $kdf == "A") and $tahun >= 20182){
						$encrypt = $this->encryption->encrypt($decrypt[0]."|".$decrypt[1]."|".$decrypt[2]."|".$decrypt[3]."|".$decrypt[4]);

						$this->krs_model->save_encrypt($NIM,$tahunaktif,$kode_mk,$encrypt,$tbl);
					}

					$record = new stdClass();
					$record->id_kls= $id_kls;
					$record->id_reg_pd= $id_reg_pd;
					$record->asal_data="9";
					$record->nilai_angka=$nil_ang;
					$record->nilai_huruf=$nil_huruf;
					$record->nilai_indeks=$nil_indeks;

					$table = 'nilai';

					// action insert ke feeder
					$action = 'InsertRecord';

					// insert tabel mahasiswa ke feeder
					$datb = $this->feeder->action_feeder($temp_token,$temp_proxy,$action,$table,$record);

					//$datb = $resultb['result'];

					$error_code = $datb['error_code'];
					$error_desc = $datb['error_desc'];

					if($error_code == 0){
						$sql = $this->krs_model->updateKrsFeeder($IDKRS, $tbl, "3");
						if($sql){
							echo "Data Berhasil di input $NIM<br>";
						}else{
							echo "Data Gagal di input $NIM<br>";
						}
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


						//$datarec = $resultup['result'];

						$error_code1 = $datarec['error_code'];
						$error_desc1 = $datarec['error_desc'];

						if($error_code1 == 0){
							$sql = $this->krs_model->updateKrsFeeder($IDKRS, $tbl, "4");
							if($sql){
								echo "Data Berhasil di input $NIM<br>";
							}else{
								echo "Data Gagal di input $NIM<br>";
							}
						}else{
							$this->db->query("update $tbl set error_code = '$error_code1', error_desc = '$error_desc1' where ID=$IDKRS");
							echo "Data gagal Update ".$error_code1." ".$error_desc1." - $NIM<br>";
						}


					}else{
						$sql = $this->krs_model->updateKrsFeeder($IDKRS, $tbl, "-3");
						if($sql){
							$this->db->query("update $tbl set error_code = '$error_code', error_desc = '$error_desc' where ID=$IDKRS");
							echo "Proses Gagal ".$error_code."-".$error_desc." - $NIM<br>";
						}else{
							echo "Data Gagal di input $NIM<br>";
						}
					}
				}else{
					$messageEnkripsi = $decrypt[0]."==".$NIM." DAN ".$decrypt[1]."==".$idjadwal." DAN ".$decrypt[2]."==".$tahun." DAN ".$decrypt[3]."==".$nilai_huruf." DAN ".$decrypt[4]."==".$nil_indeks;
					$this->db->query("update $tbl set error_code = 'NILAIBERMALAH', error_desc = 'ENKRIPSI NILAI TIDAK SESUAI $messageEnkripsi' where ID=$IDKRS");
					echo "Data bermasalah hubungi UPT TIK $NIM $messageEnkripsi<br>";
				}
			}else{
				$record = new stdClass();
				$record->id_kls= $id_kls;
				$record->id_reg_pd= $id_reg_pd;
				$record->asal_data="9";
				$record->nilai_angka=$nil_ang;
				$record->nilai_huruf=$nil_huruf;
				$record->nilai_indeks=$nil_indeks;

				$table = 'nilai';

				// action insert ke feeder
				$action = 'InsertRecord';

				// insert tabel mahasiswa ke feeder
				$datb = $this->feeder->action_feeder($temp_token,$temp_proxy,$action,$table,$record);

				//$datb = $resultb['result'];

				$error_code = $datb['error_code'];
				$error_desc = $datb['error_desc'];

				if($error_code == 0){
					$sql = $this->krs_model->updateKrsFeeder($IDKRS, $tbl, "3");
					if($sql){
						echo "Data Berhasil di input $NIM<br>";
					}else{
						echo "Data Gagal di input $NIM<br>";
					}
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


					//$datarec = $resultup['result'];

					$error_code1 = $datarec['error_code'];
					$error_desc1 = $datarec['error_desc'];

					if($error_code1 == 0){
						$sql = $this->krs_model->updateKrsFeeder($IDKRS, $tbl, "4");
						if($sql){
							echo "Data Berhasil di input $NIM<br>";
						}else{
							echo "Data Gagal di input $NIM<br>";
						}
					}else{
						$this->db->query("update $tbl set error_code = '$error_code1', error_desc = '$error_desc1' where ID=$IDKRS");
						echo "Data gagal Update ".$error_code1." ".$error_desc1." $NIM<br>";
					}
				}else{
					$sql = $this->krs_model->updateKrsFeeder($IDKRS, $tbl, "-3");
					if($sql){
						$this->db->query("update $tbl set error_code = '$error_code', error_desc = '$error_desc' where ID=$IDKRS");
						echo "Proses Gagal ".$error_code."-".$error_desc." $NIM<br>";
					}else{
						echo "Data Gagal di input $NIM<br>";
					}
				}
			}
		}
	}

	// langkah 3 untuk kirim ke dikti KHS
	// Fandu Kirim Semua Mahasiswa KHS ke feeder kecuali kedokteran
	public function feeder_khs_all_mhsw(){

		header ('Refresh: 5; URL=https://siakad2.untad.ac.id/ademik/siakad_years/feeder_khs_all_mhsw');

		$tahun = "20182";

		$feeder = $this->feeder->getToken_feeder();
		$temp_token = $feeder['temp_token'];
		$temp_proxy = $feeder['temp_proxy'];

		$query = $this->db->query("SELECT k.ID,k.Tahun,k.NIM,m.Name,m.id_reg_pd,k.Status,k.st_feeder,k.IPS,k.SKS,k.IPK,k.TotalSKS from _v2_khs k,_v2_mhsw m where k.st_feeder NOT IN ('1','3','4') and k.NIM=m.NIM and k.Tahun='$tahun' and m.KodeFakultas != 'N' and k.stprc='2' and k.error_code = '' limit 100")->result();

		foreach ($query as $data) {

			$ID = $data->ID;

			$NIM = ucfirst($data->NIM);

			if($data->IPK != 0){

				$record = new stdClass();
				$record->id_smt = $data->Tahun;
				$record->id_reg_pd = $data->id_reg_pd;
				$record->id_stat_mhs = $data->Status;
				$record->ips = $data->IPS;
				$record->sks_smt = $data->SKS;
				$record->ipk = $data->IPK;
				$record->sks_total = $data->TotalSKS;

				$table = 'kuliah_mahasiswa';

				// action insert ke feeder
				$action = 'InsertRecord';

				// insert tabel mahasiswa ke feeder
				$rdikti = $this->feeder->action_feeder($temp_token,$temp_proxy,$action,$table,$record);

				$error_code = $rdikti['error_code'];
				$error_desc = $rdikti['error_desc'];

				if($error_code==730){

					$recordup = array(
						'key' => array('id_smt' => $data->Tahun,'id_reg_pd' => $data->id_reg_pd,'id_stat_mhs' => $data->Status),
						'data' => array('ips' => $data->SKS,'sks_smt' => $data->SKS,'ipk' => $data->IPK,'sks_total' => $data->TotalSKS)
					);

					$table = 'kelas_kuliah';

					// action insert ke feeder
					$action = 'UpdateRecord';

					// insert tabel mahasiswa ke feeder
					$rdiktiup = $this->feeder->action_feeder($temp_token,$temp_proxy,$action,$table,$recordup);

					$sql = $this->krs_model->updateKhsFeeder($ID);
					if($sql){
						echo "Data Berhasil Di import $NIM<br>";
					}else{
						echo "Data Berhasil di import tapi st_feeder gagal diupdate di khs $NIM<br>";
					}

				} elseif ($error_code != 0) {

					$this->db->query("update _v2_khs set error_code = '$error_code', error_desc = '$error_desc' where ID=$ID");
					echo $error_code."-".$error_desc." - ".json_encode($record)." - $NIM<br>";
				
				} else {

					$sql = $this->krs_model->updateKhsFeeder($ID);
					if($sql){
						echo "Data Berhasil di import $NIM<br>";
					}else{
						echo "Data Berhasil di import tapi st_feeder gagal diupdate di khs $NIM<br>";
					}

				}
			}else{
				$this->db->query("update _v2_khs set error_code = 'IPKKOSONG', error_desc = 'IPK KOSONG SIAKAD' where ID=$ID");
				echo "IPK bernilai 0 tidak dapat di import ke feeder $NIM<br>";
			}
		}
	}

	// langkah 1 untuk kirim ke dikti KHS (Proses IPS)
	// fandu proses ips auto kecuali kedokteran
	public function prcIps(){
		header ('Refresh: 5; URL=https://siakad2.untad.ac.id/ademik/Siakad_years/prcIps');

		$semesterAkademik = "20182";
		$str = "and k.stprc='0' and m.KodeFakultas NOT IN ('B','G','L','O','N') order by k.NIM asc limit 500";

 		$getDataIps = $this->db->query("SELECT k.NIM from _v2_khs k left join _v2_mhsw m on k.NIM=m.NIM where k.Tahun='$semesterAkademik' $str")->result();
		
		echo "SELECT k.NIM from _v2_khs k left join _v2_mhsw m on k.NIM=m.NIM where k.Tahun='$semesterAkademik' $str <br>";

		// print_r($getDataIps);

 		foreach ($getDataIps as $show) {
 			$nim1 = $show->NIM;
			$this->prosesIPS($semesterAkademik, $nim1);
 		} 
	}

	// proses perhitungan IPS Mahasiswa dari prs IPS per orang
	public function prosesIPS($thn, $nim) {
		
		$n = 0;
		$TSKS = 0; $TNK = 0;
		$TSKSLulus = 0;
		$tabel = "_v2_krs".$thn;

		$qKrs = $this->ipk_model->getDataKrsPeriode($nim,$thn,$tabel);

		foreach ($qKrs as $show1) {
			$n++;

			$bobot = 0;

			$bobot = $show1->Bobot;

			$NK = $bobot * $show1->SKS;
			if($show1->GradeNilai=="A"||$show1->GradeNilai=="A-" ||$show1->GradeNilai=="B+" ||$show1->GradeNilai=="B" ||$show1->GradeNilai=="B-"||$show1->GradeNilai=="C+" ||$show1->GradeNilai=="C"||$show1->GradeNilai=="C-"||$show1->GradeNilai=="D"||$show1->GradeNilai=="E"||$show1->GradeNilai=="K"||$show1->GradeNilai=="T" ||$show1->GradeNilai=="" ||$show1->GradeNilai==" "){
				if(($show1->NamaMK=="Seminar Proposal" || $show1->NamaMK=="Praktik Lapangan (Magang)" || $show1->NamaMK=="Skripsi" || $show1->NamaMK=="Ko-Kurikuler" || $show1->NamaMK=="Kuliah Kerja Profesi (KKP) / KKN") && $show1->Bobot==0){ 
				}else{ 
					$TNK += $NK;
					$TSKS += $show1->SKS;
					if($bobot>0) $TSKSLulus += $show1->SKS;
				}
			}
		}
	
		if ($TSKS == 0) $IPS = 0;
		else $IPS = number_format($TNK/$TSKS, 2, ',', '.');

		$IPS = str_replace(',','.',$IPS);

		$qwsks = $this->ipk_model->getMaxSksMax($IPS,$nim);

		$maxsks = $qwsks->SKSMax;

		$data = array("IPS"=>$IPS, "SKSLulus"=>$TSKSLulus, "SKS"=>$TSKS, "MaxSKS2"=>$maxsks, "NIM"=>$nim, "Tahun"=>$thn);

		$qwupdtkhs = $this->ipk_model->updateKhsMax($data);

		if($qwupdtkhs){
	 		// $msg = "PRC IPS berhasil $data <br>";
	 	}else{
	 		$msg = "PRC IPS gagal";
		 }
		 
		//  echo $msg;
	}

	// langkah 2 untuk kirim ke dikti KHS s(Proses IPK)
	// fandu proses ipk auto kecuali kedokteran
	public function prcIpk(){
		header ('Refresh: 5; URL=https://siakad2.untad.ac.id/ademik/Siakad_years/prcIpk');

		$semesterAkademik = "20182";
		$str="and k.stprc='1' and m.KodeFakultas NOT IN ('B','G','L','O','N') and k.NIM NOT LIKE 'N%' limit 50";
		
		$getDataIpk = $this->db->query("SELECT k.NIM, m.KodeFakultas, m.KodeJurusan from _v2_khs k left join _v2_mhsw m on k.NIM=m.NIM where k.Tahun='$semesterAkademik' $str")->result();
		
		foreach ($getDataIpk as $show) {
 			$nim1 = $show->NIM;
		    $kdf = $show->KodeFakultas;
		    $kdj = $show->KodeJurusan;
			$this->prosesipk($semesterAkademik, $nim1, $kdf,$kdj);
		 }
	}

	// proses perhitungan IPK Mahasiswa dari prc IPK per orang
	public function prosesipk($thn, $nim, $kdf, $kdj){
		$qAngkatan = $this->ipk_model->getMhswTahunAkademik($nim);
		$angkatan = $qAngkatan->TahunAkademik;
		$ang = substr($thn,0,4);
		$semesterAwal = 0;
		if($angkatan==$ang){
			$semesterAwal = 1;
		}

		$TotSKS=0;
		$TotSKSLulus=0;
		$TotNil=0;

		$qKhs = $this->ipk_model->getKhsPeriode($nim,$thn);	

		foreach ($qKhs as $show1) {
			$tabel = '_v2_krs'.$show1->Tahun;
			if($semesterAwal==0){
				$qw = $this->db->query("SELECT Min(GradeNilai) as GdNilai,SKS as nSks,Max(Bobot) as bbt from ".$tabel." where NIM='$nim' and Tahun<='$thn' and GradeNilai!='K' and NotActive='N' group by NamaMK")->result();	
			}else{
				$qw = $this->db->query("SELECT GradeNilai as GdNilai,SKS as nSks,Bobot as bbt from ".$tabel." where NIM='$nim' and Tahun<='$thn' and NotActive='N' group by NamaMK")->result();
			}

			foreach ($qw as $show) {
				$bobot = $show->bbt;

				if($show->GdNilai=="A" || $show->GdNilai=="B" || $show->GdNilai=="C" || $show->GdNilai=="D" || $show->GdNilai=="E" || $show->GdNilai=="A-" || $show->GdNilai=="B+" || $show->GdNilai=="B-" || $show->GdNilai=="C+"|| $show->GdNilai=="C-"|| $show->GdNilai=="K" || $show->GdNilai=="T" || $show->GdNilai=="" || $show->GdNilai==" ") {
					/*if(($w['NamaMK']=="Seminar Proposal" || $w['NamaMK']=="Praktik Lapangan (Magang)" || $w['NamaMK']=="Skripsi" || $w['NamaMK']=="Ko-Kurikuler" || $w['NamaMK']=="Kuliah Kerja Profesi (KKP) / KKN") && $w['Bobot']==0) { 
					}else{*/ 
						$TotSKS +=$show->nSks;
						$TotNil +=$show->bbt*$show->nSks;
						$bobot = $show->bbt;
						if($bobot>0){ 
							$TotSKSLulus+=$show->nSks;
						}
					//}
				}
			}
		
		}

		$qw = $this->ipk_model->getKrsFakTR($nim);
		
		foreach ($qw as $show) {
			$bobot = $show->bbt;

			if($show->GdNilai=="A" || $show->GdNilai=="B" || $show->GdNilai=="C" || $show->GdNilai=="D" || $show->GdNilai=="E" || $show->GdNilai=="A-" || $show->GdNilai=="B+" || $show->GdNilai=="B-" || $show->GdNilai=="C+"|| $show->GdNilai=="C-"|| $show->GdNilai=="K" || $show->GdNilai=="T" || $show->GdNilai=="" || $show->GdNilai==" ") {
				/*if(($w['NamaMK']=="Seminar Proposal" || $w['NamaMK']=="Praktik Lapangan (Magang)" || $w['NamaMK']=="Skripsi" || $w['NamaMK']=="Ko-Kurikuler" || $w['NamaMK']=="Kuliah Kerja Profesi (KKP) / KKN") && $w['Bobot']==0) { 
				}else{*/ 
					$TotSKS +=$show->nSks;
					$TotNil +=$show->bbt*$show->nSks;
					$bobot = $show->bbt;
					if($bobot>0){ 
						$TotSKSLulus+=$show->nSks;
					}
				//}
			}
		}

		if($TotNil>0 or $TotSKS>0){
			$TotIPK = round($TotNil/$TotSKS,2);
			$TotIPK = number_format($TotNil/$TotSKS, 2, ',', '.');

			$TotIPK = str_replace(',','.',$TotIPK);
		}else{
			$TotIPK = 0;
		}

		$data = array("IPK"=>$TotIPK, "TotalSKS"=>$TotSKS, "TotalSKSLulus"=>$TotSKSLulus, "NIM"=>$nim, "Tahun"=>$thn);

		$qwupdtkhsipk = $this->ipk_model->updateKhsIPK($data);

		$qwupdtkhsipkmhsw = $this->ipk_model->updateIpkMhsw($TotSKS,$TotIPK,$nim,$TotSKSLulus);

		// print_r($data);
		// print_r($qwupdtkhsipk);
		if($qwupdtkhsipk){
	 		$msg = "PRC IPK berhasil<br>";
	 	}else{
	 		$msg = "PRC IPK gagal";
		}
		 
		 echo $msg;

	}

}
