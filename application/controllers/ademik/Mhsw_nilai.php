<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mhsw_nilai extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->helper('security');
		$this->load->model('mhsw_model');
		$this->load->model('krs_model');
		date_default_timezone_set("Asia/Makassar");

		if ($this->session->userdata("unip") == null) {
			redirect("https://siakad2.untad.ac.id");
		}
		//$this->app->checksession(); // untuk check session
		$this->app->check_modul(); // untuk pengecekan modul

	}

	public function index() {
		//echo "fandu pratama";

		$GetField = $this->daftar_dosen();

    $res['dsn'] = $GetField;

    $res['typedosen'] = "default";

		$this->load->view('dashbord',$res);
	}

	private function daftar_dosen (){
		$ulevel = $this->session->userdata("ulevel");
		$unip = $this->session->userdata("unip");
		$kdf = $this->session->userdata("kdf");
		$kdj = $this->session->userdata("kdj");

		//echo "$ulevel -- $unip --";

		if ($ulevel == 1){
			$kondisi_dosen = "NotActive='N'";
		} else if ($ulevel == 3){ // untuk dosen
			$kondisi_dosen = "nip='$unip' and NotActive='N' limit 1";
		} else if ($ulevel == 5){ // untuk admin fakultas
			$kondisi_dosen = "KodeFakultas='$kdf' and NotActive='N'";
		}

		$GetField = $this->app->GetField("NIP, concat(Name, ' ' , Gelar, ' - ', NIP) as nm_dosen", "_v2_dosen", "$kondisi_dosen", "")->result_array(); // untuk dosen pengampu dan asisten dosen

		return $GetField;

	}

	public function jadwaldosen() {
		$thn = $this->input->post('tahunakademik');
		$typedosen = $this->input->post('typedosen');
		$nipdosen = $this->input->post('nipdosen');

		$asisten = "_v2_jadwal jd";
		$wheredosen = "jd.IDDosen='$nipdosen'";
    $type = "utama"; 
    $iddosen = "jd.IDDosen";

		if ($typedosen == "asstDosen"){
			$asisten = "_v2_jadwalassdsn jadass left outer join _v2_jadwal jd on jadass.IDJadwal=jd.IDJADWAL";
			$wheredosen = "jadass.IDDosen='$nipdosen'";
      $type = "assisten"; 
      $iddosen = "jadass.IDDosen";
		}

		$tjdwl = ' and jd.Terjadwal="Y" ';

		$s = "select count(k.NIM) as jummhs, $iddosen, jd.id_kelas_kuliah, jd.ID, jd.kap, jd.IDJADWAL, jd.KodeRuang, jd.Kelas, jd.Tahun, jd.Terjadwal, jd.KodeFakultas, jd.KodeJurusan,
		jd.IDMK, jd.KodeMK, jd.SKS, jd.Program, jd.JamMulai, jd.JamSelesai, jd.KodeKampus, jd.KodeRuang, TIME_FORMAT(JamMulai, '%H:%i') as jm,
		TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, jd.IDMK as MKID, jd.KodeMK as KodeMK, jd.NamaMK as MK, jd.SKS, concat(d.Name, ', ', d.Gelar) as Dosen,
		pr.Nama_Indonesia as PRG, jd.Keterangan, r.Kapasitas, jd.StatusVal as stv from $asisten left outer join _v2_hari h on jd.Hari=h.ID left outer join _v2_dosen d on jd.IDDosen=d.nip
		left outer join _v2_program pr on jd.Program=pr.Kode left outer join _v2_ruang r on jd.KodeRuang=r.Kode left join _v2_krs$thn k on jd.IDJADWAL=k.IDJADWAL where jd.Tahun='$thn' $tjdwl and $wheredosen group by jd.IDJADWAL";

		$r = $this->db->query($s)->result();

    $res['ajardosen'] = $r;
    
    $res['typedosen'] = $type;

		$GetField = $this->daftar_dosen();

		$res['dsn'] = $GetField;
		$res['tahunakademik'] = $thn;

		$this->load->view('dashbord',$res);
	}

	function daftarmhsnil() {
		//$idjadwal = "F55120171F09171011REGD";
		$ulevel = $this->session->userdata("ulevel");
		$unip = $this->session->userdata("unip");
		$idjadwal = $this->input->post('idjadwal');
		//$thn = "20171";
		$thn = $this->input->post('tahun');
		$iddosen = $this->input->post('iddos');

		if ($ulevel == 1){
			$daftar = $this->daftar_angkatan_mhsw($idjadwal,$thn);
		} else if ($ulevel == 3){
			if ($iddosen == $unip){
				$daftar = $this->daftar_angkatan_mhsw($idjadwal,$thn);
			}
		} else if ($ulevel == 5){
			$optmk1 = $this->app->two_val("_v2_jadwal", "IDJADWAL", $idjadwal, "NotActive", "N")->row();
			$kodefakultas = $optmk1->KodeFakultas;
			if($kodefakultas == $this->session->userdata('kdf')){
				$daftar = $this->daftar_angkatan_mhsw($idjadwal,$thn);
			}
    }
    
		$string = "";

		foreach ($daftar as $row){
			$string .= "<option value='".$row->TahunAkademik."'>".$row->TahunAkademik."</option>";
		}

		$result = array(
			"ket" => "sukses",
			"pesan" => "Berhasil Mengambil Jadwal",
			"daftarnil" => $string
		);

		echo json_encode($result);
	}

	function daftarmhsnil_dosen() {
		//$idjadwal = "C30120181EKA5802REGAAk";
		$idjadwal = $this->input->post('idjadwal');
		//$thn = "20181";
		$thn = $this->input->post('tahun');

		$angkatan = $this->input->post('angkatan');
		//$angkatan = "2015";
		
		$iddosen = $this->input->post('iddos');

		$daftar = $this->daftar_mhsw($idjadwal,$thn,$angkatan);

		$string = "";
		$nopeserta = 1;
		$tahunakademik = 1;
		$pesan = false;
		
		$ulevel = $this->session->userdata('ulevel');
		$sessionjurusan = $this->session->userdata('kdj');
		$sessionfakultas = $this->session->userdata('kdf');
		$sessionunip = $this->session->userdata('unip');
		
		if ($ulevel == 7){
			// $this->db->from('_v2_rule_siakad');
			// $this->db->where('ulevel',$ulevel);
			// $this->db->where('user',$sessionunip);
			// $this->db->where('Kodejurusan',$sessionjurusan);
			// $this->db->where('Kodefakultas',$sessionfakultas);
			// $this->db->where('form', 'mhsw_nilai');
			// $this->db->where('status_user', 'A');
			// $hasil = $this->db->get();
			// $status = $hasil->row();
			// $cekdata = $hasil->num_rows();
			$cekdata = true; // di berikan status true, agar masuk masuk ke pengecekan user
			$status = true; // di berikan status true, agar masuk masuk ke pengecekan user
		} else if ($ulevel == 5 or $ulevel == 1){
			// $this->db->from('_v2_rule_siakad');
			// $this->db->where('ulevel',$ulevel);
			// $this->db->where('user',$sessionunip);
			// $this->db->where('Kodefakultas',$sessionfakultas);
			// $this->db->where('form', 'mhsw_nilai');
			// $this->db->where('status_user', 'A');
			// $hasil = $this->db->get();
			// $status = $hasil->row();
			// $cekdata = $hasil->num_rows();
			$cekdata = true; // di berikan status true, agar masuk masuk ke pengecekan user
			$status = true; // di berikan status true, agar masuk masuk ke pengecekan user
		} else if ($ulevel == 3){
			$cekdata = false; // di berikan status false, agar tidak masuk ke pengecekan user
			$status = false; // di berikan status false, agar tidak masuk ke pengecekan user
		}
			
		// kondisi untuk admin jurusan
		if(($cekdata == 0) and $ulevel == 7){
			// kondisi jika tidak ada di rule, maka tidak bisa akan memvalidasi
			// maaf anda tidak di berikan akses untuk memvalidasi nilai
			$message = "maaf anda tidak di berikan akses untuk input/edit nilai";
		} else if (($cekdata > 0) and $ulevel == 7) {
			if ($status->user == $sessionunip and $status->Kodejurusan == $sessionjurusan and $status->point_4 == 1 and $ulevel == 7){
				// kondisi jika ada di rule, denagan kondisi di atas maka akan divalidasi				
				//bisa melakukan validasi nilai
				// $pesan = true; di tutup akses untuk penginputan nilai oleh admin jurusan
				$message = "maaf admin jurusan tidak di berikan akses untuk input/edit nilai";
			} else if ($status->user == $sessionunip and $status->Kodejurusan == $sessionjurusan and $status->point_4 == 0 and $ulevel == 7){
				// tidak akan divalidasi
				// maaf anda tidak di berikan akses untuk memvalidasi nilai
				$message = "maaf anda tidak di berikan akses untuk input/edit nilai";
			}
		}

		// kondisi untuk admin fakultas
		if(($cekdata == 0) and $ulevel == 5){
			// kondisi jika tidak ada di rule, maka akan divalidasi
			//$pesan = true;
			$message = "maaf admin fakultas tidak di berikan akses untuk input/edit nilai";
		} else if (($cekdata > 0) and $ulevel == 5){
			if ($status->user == $sessionunip and $status->Kodefakultas == $sessionfakultas and $status->point_4 == 1 and $ulevel == 5){
				// kondisi jika ada di rule, denagan kondisi di atas maka akan divalidasi
				// $pesan = true; di tutup akses untuk penginputan nilai oleh admin fakultas
				//$pesan = true;
				$message = "maaf admin fakultas tidak di berikan akses untuk input/edit nilai";
			} else if ($status->user == $sessionunip and $status->Kodefakultas == $sessionfakultas and $status->point_4 == 0 and $ulevel == 5){
				// tidak tampil dan tidak akan di validasi
				// maaf anda tidak di berikan akses untuk memvalidasi nilai
				$message = "maaf anda tidak di berikan akses untuk input/edit nilai";
			}
		}

		if($ulevel == 1){
			// maaf adminsuperuser tidak di berikan akses untuk memvalidasi nilai
			$message = "maaf admin superuser tidak di berikan akses untuk input/edit nilai";
			$pesan = false;
		} else if($ulevel == 3){
			// kondisi pengecekan session apakah sesuai dengan dosen yang di input dan session yang tersimpan
			if ($iddosen == $sessionunip){	
				$pesan = true;
				$message = "";
			} else {	
				$pesan = false;
				$message = "maaf anda tidak di berikan akses untuk input/edit nilai";
			}
		}
			
		// kondisi jika user di berikan akses untuk input/edit nilai
		if ($pesan){
		
			$jur = "select jad.KodeJurusan, j.Ket_Jenjang from _v2_jadwal jad, _v2_jurusan j where IDJADWAL='$idjadwal' and Tahun='$thn' and jad.KodeJurusan=j.Kode";
			$row_jur = $this->db->query($jur)->row();

			// penyebab di berikan kondisi i kedok karena hanya untuk kedokteran yang kriteria penilaiannya yang ada di tabel _v2_nilai, dan yang lainnya itu masi umum kriteria penilaian gradenilai dan bobot
			$jur = $row_jur->KodeJurusan;

			if ($jur == "N210" or $jur == "N101" or $jur == "N111" or $jur == "P101" or $jur == "K2MF111" or $jur == "K2MC201" or $jur == "K2ME281" or $jur == "E321" or $jur == "E281" or $jur == "D101" or $jur == "C101" or $jur == "C201" or $jur == "C301" or $jur == "C200" or $jur == "C300" or $jur == "F111" or $jur == "F121" or $jur == "F210" or $jur == "F221" or $jur == "F230" or $jur == "F231" or $jur == "F240" or $jur == "F331" or $jur == "F441" or $jur == "F551" or $jur == "F131" or
					$jur == "A111" or
					$jur == "A121" or
					$jur == "A221" or
					$jur == "A231" or
					$jur == "A241" or
					$jur == "A251" or
					$jur == "A311" or
					$jur == "A321" or
					$jur == "A351" or
					$jur == "A401" or
					$jur == "A411" or
					$jur == "A421" or
					$jur == "A441" or
					$jur == "A451" or
					$jur == "A461" or
					$jur == "A471" or
					$jur == "A481" or
					$jur == "A491" or
					$jur == "A501" or
					$jur == "A611" or
					$jur == "B101" or
					$jur == "B201" or
					$jur == "B301" or
					$jur == "B401" or
					$jur == "B501" or
					$jur == "O121" or
					$jur == "O271" or
					$jur == "L131"

				){
				$ket_jenjang = $row_jur->Ket_Jenjang;
				$kdj = $row_jur->KodeJurusan;
			} else {
				$ket_jenjang = "Umum";
				$kdj = "All";
			}

			$resultnilai = $this->app->GetField("ID, Nilai, Bobot, AngkatanKebawah, AngkatanKeatas", "_v2_nilai", "Kode = '$ket_jenjang' and KodeJurusan='$kdj' HAVING ($angkatan >= AngkatanKebawah and $angkatan <= AngkatanKeatas)", "")->result();

		}
		
		foreach ($daftar as $row){
			
			// kondisi jika user di berikan akses untuk input/edit nilai
			if ($pesan){
				
				if (($row->st_feeder == 3) or ($row->st_feeder == 4)){
					$string .= "<div class='form-group row'>
						<input type='hidden' class='form-control' id='nim".$nopeserta."' value='".$row->NIM."' readOnly>
						<label for='name' class='col-md-3 col-form-label'>".$row->NIM."<br>".$row->Name."<br>Nilai : ".$row->GradeNilai." ( ".$row->Bobot." )<br>".$row->useredt."</label>
						<div class='col-md-2'>
								<button type='button' class='btn btn-info btn-flat'>".$row->GradeNilai." (".$row->Bobot.")</button>
						</div>
						<div class='col-md-5'>
							<button type='button' onClick='batalvalidasi(11,".$nopeserta.",this)' class='btn btn-block btn-social btn-flickr'><i class='fa fa-flickr'></i> Batal Validasi dan Update Nilai</button>
						</div>
					</div>";
				} else {

						$nil_options = 1;
						$buttonoptions = "";
						foreach ($resultnilai as $value) {

							if ($value->Nilai == $row->GradeNilai){
								$cssoptions = "danger";
							} else {
								$cssoptions = "bitbucket";
							}

							$buttonoptions .= "<div class='col-md-2'> <button type='button' class='btn btn-flat btn-".$cssoptions."' data-nim='".$row->NIM."'  onClick='nilai(".$value->ID.",".$nopeserta.",this)'>".$value->Nilai." (".$value->Bobot.")</button></div>";
							$nil_options++;
						}

						$string .= "<div class='form-group row'>
							<input type='hidden' class='form-control' id='nim".$nopeserta."' value='".$row->NIM."' readOnly>
							<div class='col-md-3'>
									<label for='name' class='col-md-3 col-form-label'>".$row->NIM."<br>".$row->Name."</label>
							</div>
							<div class='col-md-9 row' id='".$row->NIM."'>
								$buttonoptions
							</div>
						</div>";

				}

				$nopeserta++;
				
			} else {
				$string .= "<div class='form-group row'>
					<label for='name' class='col-md-3 col-form-label'>".$row->NIM."<br>".$row->Name."<br>Nilai : ".$row->GradeNilai." ( ".$row->Bobot." )<br>".$row->useredt."</label>
					<div class='col-md-2'>
							<button type='button' class='btn btn-info btn-flat'>".$row->GradeNilai." (".$row->Bobot.")</button>
					</div>
					<div class='col-md-5'>
						$message
					</div>
				</div>";
			}

		}

		$result = array(
			"ket" => "sukses",
			"pesan" => "Berhasil Mengambil Jadwal",
			"daftarnil" => $string
		);

		echo json_encode($result);
	}

	// fungsi untuk mengetahui mahasiswa
	public function daftar_mhsw($jid,$thn,$angkatan) {
		//$s = "select m.NIM, Name, GradeNilai from _v2_krs k, _v2_mhsw m where IDJadwal='$jid' and Tahun='$thn' and k.NIM=m.NIM";
		//if($thn!='20161'){
			// fandu matikan $s = "select m.NIM, Name, GradeNilai from _v2_krs$thn k, _v2_mhsw m where IDJadwal='$jid' and Tahun='$thn' and k.NIM=m.NIM";
			if (!empty($angkatan)){
				$angkatan = "and m.TahunAkademik='$angkatan'";
			} else {
				$angkatan = "";
			}
			$s = "select m.NIM, m.Name, k.GradeNilai, k.st_feeder, k.Bobot, k.useredt, m.TahunAkademik, m.KodeJurusan, j.Ket_Jenjang from _v2_krs$thn k, _v2_mhsw m, _v2_jurusan j where IDJadwal='$jid' and Tahun='$thn' and k.NIM=m.NIM and m.KodeJurusan = j.Kode $angkatan ORDER BY k.NIM ASC";
		//}

		$r = $this->db->query($s)->result();
		return $r;
	}

	// fungsi untuk mengetahui angkatan mahasiswa yang mengikuti matakuliah tersebut
	public function daftar_angkatan_mhsw($jid, $thn) {
		//$s = "select m.NIM, Name, GradeNilai from _v2_krs k, _v2_mhsw m where IDJadwal='$jid' and Tahun='$thn' and k.NIM=m.NIM";
		//if($thn!='20161'){
			$s = "select m.TahunAkademik from _v2_krs$thn k, _v2_mhsw m where k.IDJadwal='$jid' and k.Tahun='$thn' and k.NIM=m.NIM group by m.TahunAkademik";
		//}

		$r = $this->db->query($s)->result();
		return $r;
	}

	function innilai() {
		//$idjadwal = "F55120171F09171011REGD";
		$ulevel = $this->session->userdata("ulevel");
		$unip = $this->session->userdata("unip");
		$uname = $this->session->userdata("uname");
		$idjadwal = $this->input->post('idjadwal');
		//$thn = "20171";
		$thn = $this->input->post('tahun');
		$nim = $this->input->post('nim');
		$nil = $this->input->post('nil');
    $thnkrs = $thn;
    $typedosen = $this->input->post('type');


		if ($ulevel == 1){
			//$result = $this->input_nilai($thnkrs, $uname, $nim, $thn, $idjadwal, $ulevel, $nil);
			$result = array(
				"ket" => "error",
				"pesan" => "Maaf nilai tidak dapat di input admin super user",
				"detailnil" => "error"
			);
		} else if ($ulevel == 3){
	      	if ( $typedosen == "dosenUtama"){
	        	$optmk1 = $this->app->two_val("_v2_jadwal", "IDJADWAL", $idjadwal, "NotActive", "N")->row();
	      	} else if ( $typedosen == "asstDosen") {
	        	$optmk1 = $this->app->two_val("_v2_jadwalassdsn", "IDJadwal", $idjadwal, "NotActive", "N")->row();
	      	}
	      	// print_r($optmk1);
			$iddosen = $optmk1->IDDosen;
			if ($iddosen == $unip){
				$result = $this->input_nilai($thnkrs, $uname, $nim, $thn, $idjadwal, $ulevel, $nil);
			}
		} else if ($ulevel == 5){
			/*$optmk1 = $this->app->two_val("_v2_jadwal", "IDJADWAL", $idjadwal, "NotActive", "N")->row();
			$kodefakultas = $optmk1->KodeFakultas;
			if($kodefakultas == $this->session->userdata('kdf')){
				$result = $this->input_nilai($thnkrs, $uname, $nim, $thn, $idjadwal, $ulevel, $nil);
			}*/
			$result = array(
				"ket" => "error",
				"pesan" => "Maaf nilai tidak dapat di input admin fakultas",
				"detailnil" => "error"
			);
		}

		echo json_encode($result);

	}

	private function input_nilai($thnkrs, $uname, $nim, $thn, $idjadwal, $ulevel, $nil) {

		$rowsnil = $this->app->GetField("Nilai, Bobot, AngkatanKebawah, AngkatanKeatas", "_v2_nilai", "ID = '$nil'", "")->row();

		if (!empty($rowsnil->Nilai)){
			$gradenilai = $rowsnil->Nilai;
			$bobot = $rowsnil->Bobot;
		} else {
			$gradenilai = "";
			$bobot = "0.00";
		}

		if (!empty($uname)){
			$dataEncrypt = $this->encryption->encrypt($nim."|".$idjadwal."|".$thn."|".$gradenilai."|".$bobot);

			$upnilai = "update _v2_krs$thnkrs set GradeNilai='$gradenilai', Bobot='$bobot', useredt='$uname', tgledt=NOW(), enkripsi='$dataEncrypt' where NIM='$nim' and Tahun='$thn' and IDJadwal='$idjadwal'";
			$upnilai_krs = $this->db->query($upnilai);

			if ($upnilai_krs) {
				$ins_log_nilai = "INSERT INTO _v2_log_nilai (id, NIM, IDJadwal, GradeNilai, Form_input, Action_form, Datetime, User_input, Level) VALUES (NULL, '$nim', '$idjadwal', '$gradenilai', 'Penjadwalan', 'Input', NOW(), '$uname', '$ulevel');";
				$this->db->query($ins_log_nilai);
				$result = array(
					"ket" => "sukses",
					"pesan" => "Berhasil Mengambil Jadwal",
					"detailnil" => $idjadwal.$thn.$nim.$nil
				);
			}
		} else {
			$result = array(
				"ket" => "error",
				"pesan" => "Maaf nilai tidak dapat di input, user anda tidak diketahui",
				"detailnil" => "error"
			);
		}

		return $result;
	}

	function batalvalidasi() {
		//$idjadwal = "F55120171F09171011REGD";
		$ulevel = $this->session->userdata("ulevel");
		$uname = $this->session->userdata("uname");

		$idjadwal = $this->input->post('idjadwal');
		$thn = $this->input->post('tahun');
		$nim = $this->input->post('nim');

		$upnilai = "update _v2_krs$thn set st_feeder='5' where NIM='$nim' and Tahun='$thn' and IDJadwal='$idjadwal'";
		$upnilai_krs = $this->db->query($upnilai);

		if ($upnilai_krs) {
			$result = array(
				"ket" => "sukses",
			);
		}

		echo json_encode($result);
	}

	public function kirimnilaidikti(){
		$sessionunip = $this->session->userdata('unip');
		$ulevel = $this->session->userdata('ulevel');

		$idjadwal = $this->input->post("idjadwalinnilai");
		$tahun = $this->input->post("tahunnilai");
		$iddosnilai = $this->input->post("iddosnilai");
		$angkatan = $this->input->post("angkatan");

		$hasil = "";
		$pesan = "Error";

		if ($ulevel == 1){
			$message = "maaf admin superuser tidak di berikan akses untuk memvalidasi nilai";
		} else if ($ulevel == 3){
			if ($iddosnilai == $sessionunip){
				$this->proses_kirimnilaidikti($idjadwal, $tahun, $iddosnilai, $angkatan);
				$pesan = "Success";
			} else {
				$message = "di larang merubah jadwal dari dosen lain";
			}
			
		} else if ($ulevel == 7){
			$message = "maaf admin Jurusan tidak di berikan akses untuk memvalidasi nilai";
		} else if ($ulevel == 5 or $ulevel == 1){
			$message = "maaf admin Fakultas tidak di berikan akses untuk memvalidasi nilai";
		}
		
		if ($pesan == "Error"){
			$result = array(
				"ket" => "Error",
				"pesan" => $message,
			);
			echo json_encode($result);
		}

	}

	public function proses_kirimnilaidikti($idjadwal, $tahun, $iddosnilai, $angkatan){
		$ulevel = $this->session->userdata('ulevel');
		$sessionjurusan = $this->session->userdata('kdj');
		$sessionfakultas = $this->session->userdata('kdf');
		$sessionunip = $this->session->userdata('unip');

		$tbl = "_v2_krs$tahun";

		$feeder = $this->feeder->getToken_feeder();
		$temp_token = $feeder['temp_token'];
		$temp_proxy = $feeder['temp_proxy'];

		//echo $idjadwal;

		$message = "";

		$hasil = $this->db->query("SELECT n.ID, n.NIM, n.Tahun, n.nilai, n.GradeNilai, n.Bobot, n.KodeMK, n.enkripsi, j.id_kelas_kuliah, j.IDJADWAL, m.id_reg_pd, m.KodeFakultas FROM $tbl n left join _v2_jadwal j on n.IDJadwal=j.IDJADWAL left join _v2_mhsw m on n.NIM=m.NIM  WHERE n.Tahun = '$tahun' AND (n.st_feeder = 0 or n.st_feeder = 5 or n.st_feeder = -3) AND n.IDJadwal LIKE '$idjadwal' AND n.GradeNilai != '' and j.IDDosen = '$iddosnilai' and m.TahunAkademik = '$angkatan'");

		foreach ($hasil->result() as $show) {
			$IDKRS = $show->ID; // n.ID
			$id_kls = $show->id_kelas_kuliah; // j.id_kelas_kuliah
			$id_reg_pd = $show->id_reg_pd; // m.id_reg_pd
			$NIM = $show->NIM;
			$nil_ang = $show->nilai; // n.nilai ?
			$nil_huruf = $show->GradeNilai; //GradeNilai
			$nil_indeks = $show->Bobot; // n.Bobot
			$kode_mk = $show->KodeMK; //
			$idjadwal = $show->IDJADWAL; // j.IDJADWAL
			$tahun = $show->Tahun; // n.Tahun
			$nilai_huruf = $show->GradeNilai; // n.GradeNilai
			$kdf = $show->KodeFakultas; // m.kode fakultas

			if($tahun >= 20182){
				$krsEncrypt = $show->enkripsi;
				$dataDecrypt = $this->encryption->decrypt($krsEncrypt);

				$decrypt=explode('|', $dataDecrypt);
			}

			if((($kdf == "D" or $kdf == "F" or $kdf == "A" or $kdf == "H") and $tahun == 20182) or ($tahun <= 20181) or (strtoupper($decrypt[0])==strtoupper($NIM) AND $decrypt[1]==$idjadwal AND $decrypt[2]==$tahun AND $decrypt[3]==$nilai_huruf AND $decrypt[4]==$nil_indeks)){

				if(!($kdf == "D" or $kdf == "F" or $kdf == "H" or $kdf == "A") and $tahun >= 20182){
					$encrypt = $this->encryption->encrypt($decrypt[0]."|".$decrypt[1]."|".$decrypt[2]."|".$decrypt[3]."|".$decrypt[4]);
					$this->krs_model->save_encrypt($NIM,$tahun,$kode_mk,$encrypt,$tbl);
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

				// fandu matikan karena salah
				//$resultb = $this->feeder->action_feeder($temp_token,$temp_proxy,$action,$table,$record);
				//$datb = $resultb['result'];
				//echo "resultb "; print_r($resultb);
				//echo "<br>datb "; print_r($datb);
				//echo "<br>error_code "; print_r($datb['error_desc']);
				//echo "<br>error_code fandu "; print_r($resultb['error_desc']);

				//echo "$datb<br>";

				$error_code = $datb['error_code'];
				$error_desc = $datb['error_desc'];

				if($error_code == 0){
					$sql = $this->krs_model->updateKrsFeeder($IDKRS, $tbl, "3");
					if($sql){
						/*$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$tahun,$tbl);
						$data['nim'] = $NIM;
						$data['thn'] = $tahun;
						$data['kategori'] = "krs";
						$data['controller'] = $this;
						$data['status']="feeder";
						$data['msg']="Data Berhasil di input";
						$this->load->view('temp/head');
						$this->load->view('ademik/cek_feeder',$data);
						$this->load->view('temp/footers');*/
						$message .= "Data Berhasil di input stambuk $NIM <br>";
					}else{
						/*$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$tahun,$tbl);
						$data['nim'] = $NIM;
						$data['thn'] = $tahun;
						$data['kategori'] = "krs";
						$data['controller'] = $this;
						$data['status']="error_feeder";
						$data['msg']="Data Gagal di input";
						$this->load->view('temp/head');
						$this->load->view('ademik/cek_feeder',$data);
						$this->load->view('temp/footers');*/
						$message .= "Data Gagal di input stambuk $NIM <br>";
					}
				}else if($error_code == 800){ // error 800 data sudah ada di feeder
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
						$sql = $this->krs_model->updateKrsFeeder($IDKRS, $tbl, "4");
						if($sql){
							/*$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$tahun,$tbl);
							$data['nim'] = $NIM;
							$data['thn'] = $tahun;
							$data['kategori'] = "krs";
							$data['controller'] = $this;
							$data['status']="feeder";
							$data['msg']="Data Berhasil di Rubah";
							$this->load->view('temp/head');
							$this->load->view('ademik/cek_feeder',$data);
							$this->load->view('temp/footers');*/
							$message .= "Update - Data Berhasil di input stambuk $NIM <br>";
						}else{
							/*$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$tahun,$tbl);
							$data['nim'] = $NIM;
							$data['thn'] = $tahun;
							$data['kategori'] = "krs";
							$data['controller'] = $this;
							$data['status']="error_feeder";
							$data['msg']="Data Gagal di Rubah";
							$this->load->view('temp/head');
							$this->load->view('ademik/cek_feeder',$data);
							$this->load->view('temp/footers');*/
							$message .= "Update - Data Gagal di input stambuk $NIM <br>";
						}
					}else{
						/*$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$tahun,$tbl);
						$data['nim'] = $NIM;
						$data['thn'] = $tahun;
						$data['kategori'] = "krs";
						$data['controller'] = $this;
						$data['status']="error_feeder";
						$data['msg']="Data gagal Update ".$error_code1." ".$error_desc1;
						$this->load->view('temp/head');
						$this->load->view('ademik/cek_feeder',$data);
						$this->load->view('temp/footers');*/
						$message .= "Update - Data gagal Update ".$error_code1." ".$error_desc1 ."<br>";
					}


				} else{
					$message .= "Tidak Ada Data yang di Rubah ".$error_code." ".$error_desc ."<br>";
					/* fandu matikan 13 2019  $sql = $this->krs_model->updateKrsFeeder($IDKRS, $tbl, "-3");
					if($sql){
						/-*$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$tahun,$tbl);
						$data['nim'] = $NIM;
						$data['thn'] = $tahun;
						$data['kategori'] = "krs";
						$data['controller'] = $this;
						$data['status']="error_feeder";
						$data['msg']="Proses Gagal ".$error_code."-".$error_desc;
						$this->load->view('temp/head');
						$this->load->view('ademik/cek_feeder',$data);
						$this->load->view('temp/footers');*-/
						echo "Update - Proses Gagal ".$error_code."-".$error_desc;
					}else{
						/-*$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$tahun,$tbl);
						$data['nim'] = $NIM;
						$data['thn'] = $tahun;
						$data['kategori'] = "krs";
						$data['controller'] = $this;
						$data['status']="error_feeder";
						$data['msg']="Data Gagal di input";
						$this->load->view('temp/head');
						$this->load->view('ademik/cek_feeder',$data);
						$this->load->view('temp/footers');*-/
						echo "Update - Proses Gagal ".$error_code."-".$error_desc;
					}*/
				}
			}else{
				//$data['msgDecrypt'] = "Data bermasalah hubungi UPT TIK";
				//$encrypt = "Data bermasalah";
				/*$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$tahun,$tbl);
				$data['nim'] = $NIM;
				$data['thn'] = $tahun;
				$data['kategori'] = "krs";
				$data['controller'] = $this;
				$data['status']="error_feeder";
				$data['msg']="Data bermasalah hubungi UPT TIK";
				$this->load->view('temp/head');
				$this->load->view('ademik/cek_feeder',$data);
				$this->load->view('temp/footers');*/
				//echo "";
				$message .= "Update - Data bermasalah hubungi UPT TIK Stambuk ".$NIM."<br>";
			}

			//echo $msgDecrypt.$encrypt;

		}

		$result = array(
			"ket" => "sukses",
			"pesan" => $message
		);

		echo json_encode($result);

	}


	function innilai2() {
		//$idjadwal = "F55120171F09171011REGD";
		$ulevel = $this->session->userdata("ulevel");
		$unip = $this->session->userdata("unip");
		$uname = $this->session->userdata("uname");
		$idjadwal = 'A32120192A06171002REGA';
		//$thn = "20171";
		$thn = 20192;
		$nim = 'A32114028';
		$nil = 1121;
    $thnkrs = $thn;
    $typedosen = 'asstDosen';


		if ($ulevel == 1){
			//$result = $this->input_nilai($thnkrs, $uname, $nim, $thn, $idjadwal, $ulevel, $nil);
			$result = array(
				"ket" => "error",
				"pesan" => "Maaf nilai tidak dapat di input admin super user",
				"detailnil" => "error"
			);
		} else if ($ulevel == 3){
	      	if ( $typedosen == "dosenUtama"){
	        	$optmk1 = $this->app->two_val("_v2_jadwal", "IDJADWAL", $idjadwal, "NotActive", "N")->row();
	      	} else if ( $typedosen == "asstDosen") {
	        	$optmk1 = $this->app->two_val("_v2_jadwalassdsn", "IDJadwal", $idjadwal, "NotActive", "N")->row();
	      	}
	      	//print_r($optmk1);
			$iddosen = $optmk1->IDDosen;
			if ($iddosen == $unip){
				$result = $this->input_nilai($thnkrs, $uname, $nim, $thn, $idjadwal, $ulevel, $nil);
			}
			print_r($result);
			echo $iddosen.'-'.$unip;
		} else if ($ulevel == 5){
			/*$optmk1 = $this->app->two_val("_v2_jadwal", "IDJADWAL", $idjadwal, "NotActive", "N")->row();
			$kodefakultas = $optmk1->KodeFakultas;
			if($kodefakultas == $this->session->userdata('kdf')){
				$result = $this->input_nilai($thnkrs, $uname, $nim, $thn, $idjadwal, $ulevel, $nil);
			}*/
			$result = array(
				"ket" => "error",
				"pesan" => "Maaf nilai tidak dapat di input admin fakultas",
				"detailnil" => "error"
			);
		}

		echo json_encode($result);

	}

}
