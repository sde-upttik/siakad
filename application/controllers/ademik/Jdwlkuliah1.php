<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jdwlkuliah1 extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('App');
		$this->load->model('Jadwal');
		$this->load->library('encryption');
		$this->load->library("PHPExcel");
		
		$this->load->model("jadwal_phpexcel_model");
		$this->load->model('krs_model');
		$this->load->model('feeder');
		date_default_timezone_set("Asia/Makassar");

		//Load helper auditional (fadli)
		$this->load->helper('addtional');

		if ($this->session->userdata("unip") == null) {
			redirect("https://siakad2.untad.ac.id");
		}
		//$this->app->checksession(); // untuk check session
		$this->app->check_modul(); // untuk pengecekan modul
	}

	public function index(){
		//echo "fandu";
		$ulevel = $this->session->userdata("ulevel");
		$kdf = $this->session->userdata("kdf");
		$kdj = $this->session->userdata("kdj");
		echo '<script> console.log('.json_encode($this->session->userdata()).')</script>';
		if ($ulevel == 1){
			$kondisi = "where NotActive='N'";
			//$kondisi_dosen = "NotActive='N'";
		} else if ($ulevel == 5){
			$kondisi = "where KodeFakultas='$kdf' and NotActive='N'";
			//$kondisi_dosen = "KodeFakultas='$kdf' and NotActive='N'";
		} else if ($ulevel == 7) {
			$kondisi = "where Kode='$kdj' and NotActive='N'";
			//$kondisi_dosen = "KodeJurusan='$kdj' and NotActive='N'";
		}

		$kondisi_dosen = "NotActive='N'";
		
		$GetField = $this->app->GetField("NIP, concat(Name, ' ' , Gelar, ' - ', NIP) as nm_dosen", "_v2_dosen", "$kondisi_dosen", "")->result_array(); // untuk dosen pengampu dan asisten dosen

		// echo '<script> console.log('.json_encode($this->db->last_query()).')</script>';

		$s = "select Kode, Nama_Indonesia from _v2_jurusan $kondisi";
		$r = $this->db->query($s)->result_array();
		$res['r'] = $r;
		$res['dsn'] = $GetField;

		/*if ($ulevel == 1){
			$this->load->view('temp/head');
			$this->load->view('ademik/jdwlkuliah2', $res);
			$this->load->view('temp/footers');
		} else {*/
			$this->load->view('dashbord',$res);
			$this->load->view('fikri.js/jdwlkuliah1');
		//}
	}

	/*public function tes(){
		//echo "fandu1111111 ".$this->input->post('test') ;
		$thn = "20181";
		$kdp = "REG";
		$kdj = "A231";

		$value = $this->redirtampiljadwal($thn, $kdp, $kdj);

		if (!empty($value)){
			echo "Minggu - ".$value[0]['minggu'];
		} else {
			echo "Kosong";
		}


		/*$res['footerSection'] = "<script type='text/javascript'>
 				swal({
					title: 'Pemberitahuan',
					type: 'warning',
					html: true,
					text: 'Silahkan mengisi terlebih dahulu NIM pada Text Input',
					confirmButtonColor: '#f7cb3b',
				});

				$('#menu').attr('hidden',false);
				$('#isitab').html(response.minggu);
				$('#isitab_senin').html(response.senin);
				$('#isitab_selasa').html(response.selasa);
				$('#isitab_rabu').html(response.rabu);
				$('#isitab_kamis').html(response.kamis);
				$('#isitab_jumat').html(response.jumat);
				$('#isitab_sabtu').html(response.sabtu);
		    </script>";

		$this->load->view('dashbord',$res);*-/
	}*/

	private function rediralert($type, $pesan, $list, $thn, $Program, $kdj){
		if (empty($list)){
			$data['footerSection'] = "<script type='text/javascript'>
				swal({
				title: 'Pemberitahuan',
				type: '$type',
				html: true,
				text: '$pesan',
				confirmButtonColor: '#f7cb3b',
			});
			</script>";
		} else {
			$hri = $this->session->userdata('hariSelect');
			$value = $this->redirtampiljadwal($thn, $Program, $kdj, $hri);

			$data['footerSection'] = "<script type='text/javascript'>
					swal({
					title: 'Pemberitahuan',
					type: '$type',
					html: true,
					text: '$pesan',
					confirmButtonColor: '#f7cb3b',
				});

				$('#menu').attr('hidden',false);
			</script>";

			$data['minggu'] = $value[0]['minggu'];
			$data['senin'] = $value[0]['senin'];
			$data['selasa'] = $value[0]['selasa'];
			$data['rabu'] = $value[0]['rabu'];
			$data['kamis'] = $value[0]['kamis'];
			$data['jumat'] = $value[0]['jumat'];
			$data['sabtu'] = $value[0]['sabtu'];

		}

				/*
				$('#isitab').html(".$value[0]['minggu'].");
				$('#isitab_senin').html(".$value[0]['senin'].");
				$('#isitab_selasa').html(".$value[0]['selasa'].");
				$('#isitab_rabu').html(".$value[0]['rabu'].");
				$('#isitab_kamis').html(".$value[0]['kamis'].");
				$('#isitab_jumat').html(".$value[0]['jumat'].");
				$('#isitab_sabtu').html(".$value[0]['sabtu'].");*/

		$ulevel = $this->session->userdata("ulevel");
		$kdf = $this->session->userdata("kdf");
		$kdjses = $this->session->userdata("kdj");

		if ($ulevel == 1){
			$kondisi = "where NotActive='N'";
			//$kondisi_dosen = "NotActive='N'";
		} else if ($ulevel == 5){
			$kondisi = "where KodeFakultas='$kdf' and NotActive='N'";
			//$kondisi_dosen = "KodeFakultas='$kdf' and NotActive='N'";
		} else if ($ulevel == 7) {
			$kondisi = "where Kode='$kdjses' and NotActive='N'";
			//$kondisi_dosen = "KodeJurusan='$kdjses' and NotActive='N'";
		}

		$kondisi_dosen = "NotActive='N'";

		$GetField = $this->app->GetField("NIP, concat(Name, ' ' , Gelar, ' - ', NIP) as nm_dosen", "_v2_dosen", "$kondisi_dosen", "")->result_array(); // untuk dosen pengampu dan asisten dosen

		$s = "select Kode, Nama_Indonesia from _v2_jurusan $kondisi";
		$r = $this->db->query($s)->result_array();
		$data['r'] = $r;
		$data['dsn'] = $GetField;
		$data['tahunakademik'] = $thn;
		$data['kodejurusan'] = $kdj;

		$this->load->view('dashbord',$data);
	}

	private function redirtampiljadwal($thn, $kdp, $kdj, $hri){
		$ulevel = $this->session->userdata('ulevel');
		$prn = 0; // fandu disable // Masuk ke kondisi tekan tombol refresh
		$sid = 1; // fandu disable // TIDAK BERGUNA/ HANYA UNTUK URL

		//cek rule siakad
		$sessionjurusan = $this->session->userdata('kdj');
		$sessionfakultas = $this->session->userdata('kdf');
		$sessionunip = $this->session->userdata('unip');

		//$thn = $this->input->post('tahunakademik');
		//$kdj = $this->input->post('jurusan');
		//$kdp = $this->input->post('program');
		//$id = $this->input->post("id");
		//$actval_idjadwal = $this->input->post("actval");

		$hasil = "";

		if ($ulevel == 7) {
			$this->db->from('_v2_rule_siakad');
			$this->db->where('ulevel',$ulevel);
			$this->db->where('user',$sessionunip);
			$this->db->where('Kodejurusan',$sessionjurusan);
			$this->db->where('Kodefakultas',$sessionfakultas);
			$this->db->where('form', 'jdwlkuliah1');
			$this->db->where('status_user', 'A');
			$hasil = $this->db->get();
			$status = $hasil->row();
		} else if ($ulevel == 5) {
			$this->db->from('_v2_rule_siakad');
			$this->db->where('ulevel',$ulevel);
			$this->db->where('user',$sessionunip);
			$this->db->where('Kodefakultas',$sessionfakultas);
			$this->db->where('form', 'jdwlkuliah1');
			$this->db->where('status_user', 'A');
			$hasil = $this->db->get();
			$status = $hasil->row();
		} else if ($ulevel == 1) {
			$this->db->from('_v2_rule_siakad');
			$this->db->where('ulevel',$ulevel);
			$this->db->where('user',$sessionunip);
			$this->db->where('form', 'jdwlkuliah1');
			$this->db->where('status_user', 'A');
			$hasil = $this->db->get();
			$status = $hasil->row();
		}

		//echo "---- ".$ulevel." ------";

		//$count = $hasil->num_rows();

		// kondisi untuk admin jurusan == point 2 untuk input nilai
		if(($hasil->num_rows() == 0) and ($ulevel == 7)) { //  jika kosong di tabel rule dan admin jurusan bisa input nilai
			// kondisi jika tidak ada di rule, maka akan tampil
			$result = true; // bisa menginput nilai
		} else if (($hasil->num_rows() > 0) and ($ulevel == 7 or $ulevel == 5)) {
			if ($status->user == $sessionunip and ($status->Kodefakultas == $sessionfakultas or $status->Kodejurusan == $sessionjurusan) and $status->point_2 == 1 and ($ulevel == 7 or $ulevel == 5)){
				// kondisi jika ada di rule, denagan kondisi di atas maka akan tampil
				$result = true; // bisa menginput nilai
			} else if ($status->user == $sessionunip and ($status->Kodefakultas == $sessionfakultas or $status->Kodejurusan == $sessionjurusan) and $status->point_2 == 0 and ($ulevel == 7 or $ulevel == 5)){
				// tidak tampil
				$result = false; // tidak bisa menginput nilai
			}
		} else if ($ulevel == 1) {
			$result = true; // bisa menginput nilai untuk adminsuperuser
		} else {
			$result =false; // tidak bisa menginput nilai
		}

		if (!empty($kdp)) {
				if ($kdp == "REG") {
					$strprg = "and jd.Program='$kdp'";
				} else {
					$strprg = "and (jd.Program='NONREG' or jd.Program='RESO')";
				}
		}	else $strprg = '';

		$priodeaktif = false;

		$cek_periode = $this->db->query("SELECT * FROM `_v2_periode_aktif` ORDER BY `_v2_periode_aktif`.`id` DESC Limit 2")->result();

		foreach ($cek_periode as $cekpriode) {
				if ($cekpriode->periode_aktif == $thn){
					$priodeaktif = true;
				}
		}

		$h ='';
		// foreach ($hri as $hrii) {
		// 	$h =$h."'".$hrii."',"; 
		// }
		$harii = "jd.Hari = $hri";
		
		$tjdwl = ' and jd.Terjadwal="Y" ';

		$s = "select jd.IDDosen, jd.id_kelas_kuliah, jd.ID, jd.kap, jd.IDJADWAL, jd.KodeRuang, jd.Kelas, jd.Tahun, jd.Terjadwal, jd.KodeFakultas, jd.KodeJurusan,
		jd.IDMK, jd.KodeMK, jd.SKS, jd.Program, jd.JamMulai, jd.JamSelesai, jd.KodeKampus, jd.KodeRuang, TIME_FORMAT(JamMulai, '%H:%i') as jm,
		TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, jd.IDMK as MKID, jd.KodeMK as KodeMK, jd.NamaMK as MK, jd.SKS, concat(d.Name, ', ', d.Gelar) as Dosen, d.id_ptk, d.id_reg_ptk, jd.id_ajar_p,
		pr.Nama_Indonesia as PRG, jd.Keterangan, r.Kapasitas, jd.StatusVal as stv, mkh.Sesi from _v2_jadwal jd left outer join _v2_matakuliah mkh on jd.IDMK=mkh.IDMK left outer join _v2_hari h on jd.Hari=h.ID left outer join _v2_dosen d on jd.IDDosen=d.nip
		left outer join _v2_program pr on jd.Program=pr.Kode left outer join _v2_ruang r on jd.KodeRuang=r.Kode where $harii and jd.Tahun='$thn' and jd.KodeJurusan='$kdj' $strprg $tjdwl and jd.KodeRuang <> ''
		group by jd.IDJADWAL order by jd.Terjadwal, jd.Hari, jd.JamMulai,jd.NamaMK,jd.Keterangan";

		$r = $this->db->query($s)->result_array();

		// hari
		$senin = "";
		$selasa = "";
		$rabu = "";
		$kamis = "";
		$jumat = "";
		$sabtu = "";
		$minggu = "";

		$_hr = -1;
		$terjadwal = '';
		$arrterjadwal = array('Y'=>'Terjadwal', 'N'=>'Tidak Terjadwal');
		$int = 1;
		foreach ($r as $row) {
			$stval = $row['stv'];

			// kondisi pendeklarasian image
			if($stval =='S') $ic = base_url()."assets/images/btn_alert_16.png";
			else if($stval =='V') $ic = base_url()."assets/images/btn_ok_16.png";
			else $ic = base_url()."assets/images/btn_input_nilai.png";

			$stjdw    = $row['id_kelas_kuliah'];
			$IDJADWAL = $row['IDJADWAL'];
			$thn      = $row['Tahun'];

			// kondisi pengecekan id kelas kuliah
			if($stjdw != ''){
				$icjdw = "primary";
				$detailajardosen = '
					<a href="'.base_url('ademik/jdwlkuliah1/report_cekdatafeeder/'.$IDJADWAL.'/'.$thn).'" target=_blank ><button class="btn btn-block btn-social btn-facebook">
          	<i class="fa fa-play"></i> Detail di Feeder
          </button></a>';
			} else {
				$icjdw = "warning";
				$detailajardosen = "Silahkan Kirim<br>Terlebih Dahulu Jadwal<br>ke Feeder";
			}

			$hr  = $row['HR'];
			$rng = $row['KodeRuang'];
			$jm  = $row['jm'];
			$js = $row['js'];
			$jid = $row['IDJADWAL'];
			$idjid = $row['ID']; // id pada jadwal
			$prodi = $row['KodeJurusan'];
			$kmk = $row['KodeMK'];
			$mk  = $row['MK']; //  Nama Matakuliah
			$kl  = $row['PRG']; // nama indonesia kode program REG/RESO

			// kondisi jika kode program kosong
			if (empty($kl)) $kl = '&nbsp;';

			$sks = $row['SKS'];
			$namadosen = $row['Dosen'];

			$id_ptk  = $row['id_ptk'];
			$id_reg_ptk  = $row['id_reg_ptk'];
			$id_ajar_p  = $row['id_ajar_p'];

			// untuk mengecek id ptk dosen di feeder
			if ($id_ptk != NULL or $id_ptk != ""){
				$cekidptk = "ID PTK | ";
			} else {
				$cekidptk = "<del>ID PTK</del> | ";
			}

			// untuk mengecek id registrasi penugasan dosen di feeder
			if ($id_reg_ptk != NULL or $id_reg_ptk != ""){
				$cekidregptk = "ID REG PTK | ";
			} else {
				$cekidregptk = "<del>ID REG PTK</del> | ";
			}

			// untuk mengecek ajar dosen di feeder
			if ($id_ajar_p != NULL or $id_ajar_p != ""){
				$cekajardosen = "Kirim ID Ajar | Lihat ID Ajar ";
			} else {
				$cekajardosen = "<a href='javascript:void(0)' onclick='kirimidajar(this,$int,1)'><del>Kirim ID Ajar</del></a> | ";
			}

			/*
			<div class='col-12 col-md-12'>
				<div class='row'>
					<div class='col-6 col-xl-6'>
						<a class='btn btn-primary bg-blue'>
							<i class='fa fa-save'> Save Ajar Dosen</i>
						</a>
					</div>
					<div class='col-6 col-xl-6'>
						<a class='btn bg-red bg-blue'>
							<i class='fa fa-edit'> Lihat Ajar Dosen</i>
						</a>
					</div>
				</div>
			</div>
			*/

			$dsn = $namadosen."<br><b>".$cekidptk.$cekidregptk.$cekajardosen."</b>";

			$iddsn = $row['IDDosen'];

			// kondisi jika kode prodi HUKUM, untuk melihat beban kerja dosen
			if($prodi=="D101"){
				$dsn = "<a href='print.php?print=ademik/bebankerjadosen.php&iddsn=$iddsn&thn=$thn&kdj=$prodi' target=_blank >$dsn</a>";
			}

			$kmps = $row['Keterangan'];
			$ket =  $row['Kelas'];
			$kps = $row['kap'];
			$semester = $row['Sesi'];
			$mhsw = $this->HitungMhsw($IDJADWAL,$thn,$kdj); // FIKRI Komentari
			// $mhsw = 0; // FIKRI tambahkan
			// $mhsw2 = 0; // FIKRI TAMBAHKAN
			$mhsw2 = $this->HitungMhsw_fd($IDJADWAL,$thn,$kdj); // FIKRI komentari

			$cnt = 0;

			// fandu matikan sementara mysql_query("update jadwal set jml_mhs='$mhsw',jml_mhs_fd='$mhsw2',jml_dsn='$jmldsn',jml_dsn_fd='$jmldsn2' where IDJadwal='$IDJADWAL'");

			$ass = "<br><br><b>Dosen Lainnya : </b>".$this->GetAssDsn($row['IDJADWAL'],1,$int); // 1 untuk print asisten dosen
			//$ass2 = "";
			//$ass2 = $this->GetAssDsnPrint($row['IDJADWAL']);

			if (($prn == 0) && ($terjadwal != $row['Terjadwal'])) {
				$terjadwal = $row['Terjadwal'];
				$str = $arrterjadwal[$terjadwal];
				//echo "<tr><td class=uline colspan=17><h3>$str</td></tr>";
				$cnt++;
			}

			if ($prn == 0) {
				/* Fandu matikan 04/11/2018
				$strkaps = "<a href='ademik.php?syxec=jdwlkuliah&md1=122&ekap=0&jid=$row[IDJADWAL]&kap=$kps'>$kps</a>";
				$strmhs = "<a href='ademik.php?syxec=jdwlkuliah&md1=0&jid=$row[IDJADWAL]&IDJADWAL=$row[IDJADWAL]&mkid=$row[MKID]'>$mhsw</a>"; */
				$strkaps = "$kps";
				$_jadwal = json_encode($jid);
				$strmhs = '<td></td>';
				if ($mhsw==0) {
					// $strmhs = "<td id='mhsw$int'><button class='btn btn-block btn-warning btn-xs' onClick='cariMhsw($_jadwal)'><i class='fa fa-refreshs'></i>$mhsw</button></td>";
				}else{
					$strmhs = "<td id='mhsw$int'>$mhsw</td>";
				}

				/*if($ulevel==6){
					$strmhs = "$mhsw";
				}*/

				// untuk isi tabel cetak dan sebagainya untuk level
				if($ulevel==1||$ulevel==5){
					/* Fandu matikan 04/11/2018
					$strnil = "<td class=lst align=center><a href='print.php?print=ademik/cetakkehadiranmhsw2.php&prn=1&jid=$jid&PHPSESSID=$sid&ujn=Absen&$ass2' target=_blank title='Cetak Absen'><img src='".base_url()."assets/images/printer.png' border=0></a></td>
					<td class=lst align=center><a href='cetakabsentambahan.php?print=absentambahan&jid=$jid&jidthn=$thn' target=_blank title='Cetak Absen Tambahan'><img src='".base_url()."assets/images/printer.png' border=0></a></td>
					<td class=lst align=center><a href='inputabsen.php?KodeMKLama=$row[IDJADWAL]&tahunLama=$thn' target=_blank title='Input Absen'>absen</a></td>
					<td class=lst align=center><a href='print.php?print=ademik/cetakdpna.php&prn=1&jid=$jid&PHPSESSID=$sid&ujn=Absen&$ass2' target=_blank title='Cetak DPNA'><img src='".base_url()."assets/images/printer.png' border=0></a></td>
					<td class=lst align=center><a href='print.php?print=ademik/cetakkehadiranmhsw3.php&prn=1&jid=$jid&PHPSESSID=$sid&ujn=Absen&$ass2' target=_blank title='Cetak Rekap Absen'><img src='".base_url()."assets/images/printer.png' border=0></a></td>";
					<td class=lst align=center><a href='tambah2' target=_blank title='Cetak Absen Tambahan'><img src='".base_url()."assets/images/printer.png' border=0></a></td>
					<td class=lst align=center><a href='tambah5' target=_blank title='Cetak Rekap Absen'><img src='".base_url()."assets/images/printer.png' border=0></a></td>*/
					$strnil = "<td class=lst align=center><a href='".base_url('ademik/report/report2/cetak_daftar_hadir/'.$idjid.'/'.$thn)."' target=_blank title='Cetak Absen'><img src='".base_url()."assets/images/printer.png' border=0></a></td>
					<td class=lst align=center><a href='".base_url('ademik/absensi')."' target=_blank title='Input Absen'><img src='".base_url()."assets/images/printer.png' border=0></a></td>
					<td class=lst align=center><a href='".base_url('ademik/report/report2/cetak_daftar_nilai/'.$idjid.'/'.$thn)."' target=_blank title='Cetak Daftar Nilai'><img src='".base_url()."assets/images/printer.png' border=0></a></td>
					";
					// cetak dpna <td class=lst align=center><a href='".base_url('ademik/report/report2/cetak_dpna/'.$idjid.'/'.$thn)."' target=_blank title='Cetak DPNA'><img src='".base_url()."assets/images/printer.png' border=0></a></td>
					// <a href='#' target=_blank title='Input Absen'>absen</a>
				} /* fandu matikan 08/06/2018 else{
					$strnil = "<td class=lst align=center><a href='print.php?print=ademik/cetakkehadiranmhsw2.php&prn=1&jid=$jid&PHPSESSID=$sid&ujn=Absen&$ass2' target=_blank title='Cetak Absen'><img src='".base_url()."assets/images/printer.png' border=0></a></td>
					<td class=lst align=center><a href='cetakabsentambahan.php?print=absentambahan&jid=$jid&jidthn=$thn' target=_blank title='Cetak Absen Tambahan'><img src='".base_url()."assets/images/printer.png' border=0></a></td>
					<td class=lst align=center>absen</td>
					<td class=lst align=center><a href='print.php?print=ademik/cetakdpna.php&prn=1&jid=$jid&PHPSESSID=$sid&ujn=Absen&$ass2' target=_blank title='Cetak DPNA'><img src='".base_url()."assets/images/printer.png' border=0></a></td>
					<td class=lst align=center><a href='print.php?print=ademik/cetakkehadiranmhsw3.php&prn=1&jid=$jid&PHPSESSID=$sid&ujn=Absen&$ass2' target=_blank title='Cetak Rekap Absen'><img src='".base_url()."assets/images/printer.png' border=0></a></td>";
				}*/ else {
					$strnil = "<td class=lst align=center><a href='".base_url('ademik/report/report2/cetak_daftar_hadir/'.$idjid.'/'.$thn)."' target=_blank title='Cetak Absen'><img src='".base_url()."assets/images/printer.png' border=0></a></td>
					<td class=lst align=center><a href='".base_url('ademik/absensi')."' target=_blank title='Absen'><img src='".base_url()."assets/images/printer.png' border=0></a></td>
					<td class=lst align=center><a href='".base_url('ademik/report/report2/cetak_daftar_nilai/'.$idjid.'/'.$thn)."' target=_blank title='Cetak Daftar Nilai'><img src='".base_url()."assets/images/printer.png' border=0></a></td>";
					// cetak dpna <td class=lst align=center><a href='".base_url('ademik/report/report2/cetak_dpna/'.$idjid.'/'.$thn)."' target=_blank title='Cetak DPNA'><img src='".base_url()."assets/images/printer.png' border=0></a></td>
				}

				// cek periode aktif di siakad, agar mengikuti periode buka tutup di feeder
				// fandu modifikasi pada tahun or substr($thn,4,1) == 3 or 4 untuk menambahkan SP dan Antara 08 september 2019
				if ($priodeaktif or $ulevel == 1 or $ulevel == 5 or substr($thn,4,1) == '3' or substr($thn,4,1) == '4'){
					// untuk isi tabel cetak dan sebagainya	untuk yang sudah V sudah bisa di input nilai
					if($stval=='V') {
						//$strnil2 ="<a href='tabelnilaicek.php?KodeMKLama=$row[IDJADWAL]&tahunLama=$thn' target=_blank title='Input Nilai'><img src='$ic' border=0></a><br><a href='print.php?print=ademik/cetakdpnahasil.php&prn=1&jid=$jid&PHPSESSID=$sid&ujn=Absen&$ass2' target=_blank title='Cetak DPNA'><img src='".base_url()."assets/images/printer.png' border=0></a>";
						// fandu matikan 19-02-2019 $strnil2 ="<a data-toggle='modal' data-target='#modal-primary-dikti' target=_blank title='Kirim Nilai Dikti' onClick='daftarmhsdikti($int)'><img src='$ic' border=0></a><br><a href='print.php?print=ademik/cetakdpnahasil.php&prn=1&jid=$jid&PHPSESSID=$sid&ujn=Absen&$ass2' target=_blank title='Cetak DPNA'><img src='".base_url()."assets/images/printer.png' border=0></a>";
						if ($result){ // jika kondisi pada point 2 pada rule siakad bernilai true
							$strnil2 ="<a data-toggle='modal' data-target='#modal-primary-jadwal' target=_blank title='Input Nilai' onClick='getdaftarmhsnil($int)'><img src='$ic' border=0></a>";
						} else {
							$strnil2 = "No Access Input Nilai";
						}
					} else {
						//$strnil2 ="<a href='tabelnilaicek.php?KodeMKLama=$row[IDJADWAL]&tahunLama=$thn' target=_blank title='Input Nilai'><img src='$ic' border=0></a>";
						if ($result){ // jika kondisi pada point 2 pada rule siakad bernilai true
							$strnil2 ="<a data-toggle='modal' data-target='#modal-primary-jadwal' target=_blank title='Input Nilai' onClick='getdaftarmhsnil($int)'><img src='$ic' border=0></a>";
						} else {
							$strnil2 = "No Access Input Nilai";
						}
					}
				} else if ($priodeaktif or $ulevel == 7){
					$strnil2 = "No Access Input Nilai";
				} else {
					$strnil2 = "Periode Akademik Tahun $thn Sudah Tutup";
				}


				// st feeder dikembalikan jadi 1 di tabel krs mahasiswa // 3 berhasil terkirim , 0 jika ada perubahan nilai, -1 gagal id pd
				// $id_reg_pd!="" and $id_kelas_kuliah !="" maka insert
				// $id_kelas_kuliah =="" jadwal belum di kirim
				// $id_reg_pd =="" mahasiswa belum terkirim

				// Edit KodeMK = $streditmk;
				// Edit Dosen = $streditdsn;
				if($stjdw==''){
					$streditmk = "<button type='button' onClick='action($int)' class='btn btn-$icjdw' data-toggle='modal' data-target='#modal-add-jadwal'><img src='".base_url()."assets/images/edit.png' border=0></button><input id='act_name$int' value='$mk' hidden=true readonly /><input id='act_value$int' value='".$jid."' hidden=true readonly />";
					$streditdsn = "<b>Dosen Pengampu : </b>";
					//$streditdsn = "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modal-primary-dosen'><img src='".base_url()."assets/images/edit.png' border=0></button>"; 
				}else{
					$streditmk = "<button type='button' onClick='action($int)' class='btn btn-$icjdw' data-toggle='modal' data-target='#modal-add-jadwal'><img src='".base_url()."assets/images/edit.png' border=0></button><input id='act_name$int' value='$mk' hidden=true readonly /><input id='act_value$int' value='".$jid."' hidden=true readonly />";
					$streditdsn = "<b>Dosen Pengampu : </b>";
					//$streditdsn = "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modal-primary-dosen'><img src='".base_url()."assets/images/edit.png' border=0></button>";
				}

				$int++; // digunakan untuk mengambil id jadwal pada tombol edit

				if($mhsw==$mhsw2){
					$icnilai = base_url()."assets/images/btn_ok_16.png";
				} else {
					$icnilai = base_url()."assets/images/ristekdikti.png";
				}

				$strnilai="$mhsw  <img src='$icnilai' border=0>  $mhsw2";
			} else {
				$strkaps = '';
				$streditdsn = '';
				$streditmk = '';
				$detailajardosen = '';
			}

			if ($hr == "Senin"){
				$senin = $senin."<tr><td>$jm-$js</td>
					<td>$rng</td>
					<td>$streditmk<br>$kmk<br>$mk ($sks)</td>
					<td>$kl</td>
					<td>$semester</td>
					<td>$streditdsn <br>$dsn $ass</td>
					<td>$kmps $ket</td>
					<td>$strkaps</td>
					$strmhs
					$strnil
					<td>$strnil2</td>
					<td>$strnilai</td><td>$detailajardosen</td><tr>";
			} else if ($hr == "Selasa"){
				$selasa = $selasa."<tr><td>$jm-$js</td>
					<td>$rng</td>
					<td>$streditmk<br>$kmk<br>$mk ($sks)</td>
					<td>$kl</td>
					<td>$semester</td>
					<td>$streditdsn <br>$dsn $ass</td>
					<td>$kmps $ket</td>
					<td>$strkaps</td>
					$strmhs
					$strnil
					<td>$strnil2</td>
					<td>$strnilai</td><td>$detailajardosen</td><tr>";
			} else if ($hr == "Rabu"){
				$rabu = $rabu."<tr><td>$jm-$js </td>
					<td>$rng</td>
					<td>$streditmk<br>$kmk<br>$mk ($sks)</td>
					<td>$kl</td>
					<td>$semester</td>
					<td>$streditdsn <br>$dsn $ass</td>
					<td>$kmps $ket</td>
					<td>$strkaps</td>
					$strmhs
					$strnil
					<td>$strnil2</td>
					<td>$strnilai</td><td>$detailajardosen</td><tr>";
			} else if ($hr == "Kamis"){
				$kamis = $kamis."<tr><td>$jm-$js</td>
					<td>$rng</td>
					<td>$streditmk<br>$kmk<br>$mk ($sks)</td>
					<td>$kl</td>
					<td>$semester</td>
					<td>$streditdsn <br>$dsn $ass</td>
					<td>$kmps $ket</td>
					<td>$strkaps</td>
					$strmhs
					$strnil
					<td>$strnil2</td>
					<td>$strnilai</td><td>$detailajardosen</td><tr>";
			} else if ($hr == "Jumat"){
				$jumat = $jumat."<tr><td>$jm-$js</td>
					<td>$rng</td>
					<td>$streditmk<br>$kmk<br>$mk ($sks)</td>
					<td>$kl</td>
					<td>$semester</td>
					<td>$streditdsn <br>$dsn $ass</td>
					<td>$kmps $ket</td>
					<td>$strkaps</td>
					$strmhs
					$strnil
					<td>$strnil2</td>
					<td>$strnilai</td><td>$detailajardosen</td><tr>";
			} else if ($hr == "Sabtu"){
				$sabtu = $sabtu."<tr><td>$jm-$js</td>
					<td>$rng</td>
					<td>$streditmk<br>$kmk<br>$mk ($sks)</td>
					<td>$kl</td>
					<td>$semester</td>
					<td>$streditdsn <br>$dsn $ass</td>
					<td>$kmps $ket</td>
					<td>$strkaps</td>
					$strmhs
					$strnil
					<td>$strnil2</td>
					<td>$strnilai</td><td>$detailajardosen</td><tr>";
			} else if ($hr == "Minggu"){
				$minggu = $minggu."<tr><td>$jm-$js</td>
					<td>$rng</td>
					<td>$streditmk<br>$kmk<br>$mk ($sks)</td>
					<td>$kl</td>
					<td>$semester</td>
					<td>$streditdsn <br>$dsn $ass</td>
					<td>$kmps $ket</td>
					<td>$strkaps</td>
					$strmhs
					$strnil
					<td>$strnil2</td>
					<td>$strnilai</td><td>$detailajardosen</td><tr>";
			}
		}

		$data=array();
		array_push($data, array(
				"senin"=>$senin,
				"selasa"=>$selasa,
				"rabu"=>$rabu,
				"kamis"=>$kamis,
				"jumat"=>$jumat,
				"sabtu"=>$sabtu,
				"minggu"=>$minggu
			));
		return $data;
	}

	// untuk mengambil data saat melakukan tambah jadwal
	public function action(){
		$ulevel = $this->session->userdata('ulevel');
		$sessionjurusan = $this->session->userdata('kdj');
		$sessionfakultas = $this->session->userdata('kdf');
		$sessionunip = $this->session->userdata('unip');

		// cek rule siakad
		$thn = $this->input->post('tahunakademik');
		$kdj = $this->input->post('jurusan');
		$kdp = $this->input->post('program');
		$id = $this->input->post("id");
		$actval_idjadwal = $this->input->post("actval");

		// mengganti tanda baca - ke +, karena pada pengiriman dari ajax terbaca kalau tanda baca + itu sama dengan "spasi"
		$actval_idjadwal = str_replace("_", "+", $actval_idjadwal);

		$hasil = "";

		if ($ulevel == 7){
			$this->db->from('_v2_rule_siakad');
			$this->db->where('ulevel',$ulevel);
			$this->db->where('user',$sessionunip);
			$this->db->where('Kodejurusan',$sessionjurusan);
			$this->db->where('Kodefakultas',$sessionfakultas);
			$this->db->where('form', 'jdwlkuliah1');
			$this->db->where('status_user', 'A');
			$hasil = $this->db->get();
			$status = $hasil->row();
		} else if ($ulevel == 5 or $ulevel == 1){
			$this->db->from('_v2_rule_siakad');
			$this->db->where('ulevel',$ulevel);
			$this->db->where('user',$sessionunip);
			$this->db->where('Kodefakultas',$sessionfakultas);
			$this->db->where('form', 'jdwlkuliah1');
			$this->db->where('status_user', 'A');
			$hasil = $this->db->get();
			$status = $hasil->row();
		}

		//echo "---- ".$ulevel." ------";

		//$count = $hasil->num_rows();

		// kondisi untuk admin jurusan
		if(($hasil->num_rows() == 0) and $ulevel == 7){
			// kondisi jika tidak ada di rule, maka akan tampil
			$result[] = $this->func_tampiljadwal($ulevel,$thn,$kdj,$kdp,$id,$actval_idjadwal);
		} else if (($hasil->num_rows() > 0) and $ulevel == 7) {
			if ($status->user == $sessionunip and $status->Kodejurusan == $sessionjurusan and $status->point_1 == 1 and $ulevel == 7){
				// kondisi jika ada di rule, denagan kondisi di atas maka akan tampil
				$result[] = $this->func_tampiljadwal($ulevel,$thn,$kdj,$kdp,$id,$actval_idjadwal);
			} else if ($status->user == $sessionunip and $status->Kodejurusan == $sessionjurusan and $status->point_1 == 0 and $ulevel == 7){
				// tidak tampil
				$result[] = array(
				"tahun" => '',
				"kdj" => '',
				"md" => '',
				"idmk" => '',
				"ruang" => '',
				"hari" => '',
				"kelas" => '',
				"paket" => '',
				"jmmulai" => '',
				"jamselesai" => '',
				"rencana" => '',
				"realisasi" => '',
				"kaps" => '',
				"keterangan" => '',
				"dosen" => '',
				"ass" => '');
			}
		}
		// kondisi untuk admin fakultas
		if(($hasil->num_rows() == 0) and $ulevel == 5){
			// kondisi jika tidak ada di rule, maka tidak akan tampil
			$result[] = array(
				"tahun" => '',
				"kdj" => '',
				"md" => '',
				"idmk" => '',
				"ruang" => '',
				"hari" => '',
				"kelas" => '',
				"paket" => '',
				"jmmulai" => '',
				"jamselesai" => '',
				"rencana" => '',
				"realisasi" => '',
				"kaps" => '',
				"keterangan" => '',
				"dosen" => '',
				"ass" => ''
			);
		} else if (($hasil->num_rows() > 0) and $ulevel == 5){
			if ($status->user == $sessionunip and $status->Kodefakultas == $sessionfakultas and $status->point_1 == 1 and $ulevel == 5){
				// kondisi jika ada di rule, denagan kondisi di atas maka akan tampil
				$result[] = $this->func_tampiljadwal($ulevel,$thn,$kdj,$kdp,$id,$actval_idjadwal);
			} else if ($status->user == $sessionunip and $status->Kodefakultas == $sessionfakultas and $status->point_1 == 0 and $ulevel == 5){
				// tidak tampil
				$result[] = array(
					"tahun" => '',
					"kdj" => '',
					"md" => '',
					"idmk" => '',
					"ruang" => '',
					"hari" => '',
					"kelas" => '',
					"paket" => '',
					"jmmulai" => '',
					"jamselesai" => '',
					"rencana" => '',
					"realisasi" => '',
					"kaps" => '',
					"keterangan" => '',
					"dosen" => '',
					"ass" => ''
				);
			}
		}

		// kondisi untuk admin superuser
		if($ulevel == 1){
			// kondisi jika tidak ada di rule, maka akan tampil
			$result[] = $this->func_tampiljadwal($ulevel,$thn,$kdj,$kdp,$id,$actval_idjadwal);
			/*$result[] = array(
				"tahun" => '',
				"kdj" => '',
				"md" => '',
				"idmk" => '',
				"ruang" => '',
				"hari" => '',
				"kelas" => '',
				"paket" => '',
				"jmmulai" => '',
				"jamselesai" => '',
				"rencana" => '',
				"realisasi" => '',
				"kaps" => '',
				"keterangan" => '',
				"dosen" => '',
				"ass" => ''
			);*/
		}

		//$string = $status->user." == $sessionunip == ".$status->Kodefakultas." == $sessionfakultas == ".$status->point_1." == $ulevel";

		//"admA == admA == A == A == 1 == 5"

		echo json_encode($result);
	}

	// mengambil data untuk tambah atau edit mk di penjadwalan
	private function func_tampiljadwal($ulevel,$thn,$kdj,$kdp,$id,$actval_idjadwal){

		if ($id == "undefined") $action = 1;
		else $action = 2;

		// buka untuk pada menu tambah jadwal //
		$optmk1  = $this->app->two_val("_v2_kurikulum", "KodeJurusan", $kdj, "NotActive", "N")->row();
		$kurid = $optmk1->IdKurikulum;

		$kdfakultas  = $this->app->two_val("_v2_jurusan", "Kode", $kdj, "NotActive", "N")->row();
		$kodefakul = $kdfakultas->KodeFakultas;

		// meng identifikasi kurikulum yang aktif dan ter kirim ke dikti
		$idmk  = $this->app->two_val_option("concat(Kode, ' -- ', Nama_Indonesia, ' -- ',SKS)", "IDMK" ,"_v2_matakuliah", "KurikulumID='$kurid' and id_mk != ''", "");

		$ruang = $this->app->two_val_option("concat(KodeKampus, ' -- ',Kode)" , "Kode" ,"_v2_ruang" ,"KodeKampus like '$kodefakul%'", "Kode != ''");

		$hari = $this->app->two_val_option("Nama" , "ID" ,"_v2_hari" ,"ID != ''", "");


		$opfkip = "";
		$s = "select Kode,Kelas from _v2_kelas where KodeFakultas='$kodefakul'";
		$r = $this->db->query($s);
		foreach ($r->result() as $rw){
			$id = $rw->Kode;
			$kls = $rw->Kelas;
			$opfkip .= "<option name=$id value='$kls'>$kls</option>";
		}

		if($kdfakultas == "A"){
			$opfkip .= "<option name=P3S value=P3S>Kelas P3S</option>";
		}

		$kelas = "<option name=A value=A>Kelas A</option>
		<option name=B value=B>Kelas B</option>
		<option name=C value=C>Kelas C</option>
		<option name=D value=D>Kelas D</option>
		<option name=E value=E>Kelas E</option>
		<option name=F value=F>Kelas F</option>
		<option name=G value=G>Kelas G</option>
		<option name=H value=H>Kelas H</option>
		<option name=I value=I>Kelas I </option>
		<option name=J value=J>Kelas J</option>
		<option name=K value=K>Kelas K</option>
		<option name=L value=L>Kelas L</option>
		<option name=M value=M>Kelas M</option>
		<option name=N value=N>Kelas N</option>
		<option name=O value=O>Kelas O</option>
		<option name=P value=P>Kelas P</option>
		<option name=P value=Q>Kelas Q</option>
		<option name=P value=R>Kelas R</option>
		$opfkip
		<option name=Gabungan value=Gabungan>Kelas Gabungan</option>
		<option name=Int-Class value=Int-Class>Kelas Internasional</option>
		<option name=Int-Class value=Konsentrasi>Konsentrasi</option>";

		if ($ulevel == 1 or $ulevel == 5 or $ulevel == 7) {
			$paket  = $this->app->two_val_option("concat(KodePaket, ' -- ',NamaPaket)", "KodePaket" ,"_v2_paket", "KodeJurusan like '$kdj%'", "");
		}
		// tutup untuk pada menu tambah jadwal //

		// untuk edit jadwal
		$idmk1 = "";
		$ruang1 = "";
		$kelas1 = "";
		$hari1 = "";
		$jammulai1 = "";
		$jamselesai1 = "";
		$rencana1 = "";
		$realisasi1 = "";
		$kaps = "";
		$keterangan1 = "";
		$dosen = "";
		$ass = "";

		if ($actval_idjadwal != "undefined") {
			// buka untuk pada menu tambah jadwal //
			$idjadwal_edit  = $this->app->two_val("_v2_jadwal", "IDJADWAL", $actval_idjadwal, "NotActive", "N")->row();

			$idmk1 = "<option value='".$idjadwal_edit->IDMK."' selected>".$idjadwal_edit->KodeMK." - ".$idjadwal_edit->NamaMK."</option>";
			$ruang1 = "<option value='".$idjadwal_edit->KodeRuang."'>".$idjadwal_edit->KodeRuang."</option>";
			$kelas1 = "<option value='".$idjadwal_edit->Keterangan."'>Kelas ".$idjadwal_edit->Keterangan."</option>";
			$hari1 = $this->app->two_val_option("Nama" , "ID" ,"_v2_hari" ,"ID = '".$idjadwal_edit->Hari."'", "");
			$jammulai1 = $idjadwal_edit->JamMulai;
			$jamselesai1 = $idjadwal_edit->JamSelesai;
			$rencana1 = $idjadwal_edit->Rencana;
			$realisasi1 = $idjadwal_edit->Realisasi;
			$kaps = $idjadwal_edit->kap;
			$keterangan1 = $idjadwal_edit->Kelas;

			$GetField = $this->app->GetField("nip, concat(Name, ' ' , Gelar, ' - ', NIP) as nm_dosen", "_v2_dosen", "nip='".$idjadwal_edit->IDDosen."'", "")->row();
			if (!empty($GetField->nip)){
				$dosen = "<option value='".$GetField->nip."' selected>".$GetField->nm_dosen."</option>";
			} else {
				$dosen = "<option value='' selected></option>";
			}

			$ass = $this->GetAssDsn($idjadwal_edit->IDJADWAL,2,""); // untuk select option
		}

		return $result = array(
			"tahun" => $thn,
			"kdj" => $kdj,
			"md" => $action,
			"idmk" => $idmk1.$idmk,
			"ruang" => $ruang1.$ruang,
			"hari" => $hari1.$hari,
			"kelas" => $kelas1.$kelas,
			"paket" => $paket,
			"jmmulai" => $jammulai1,
			"jamselesai" => $jamselesai1,
			"rencana" => $rencana1,
			"realisasi" => $realisasi1,
			"kaps" => $kaps,
			"keterangan" => $keterangan1,
			"dosen" => $dosen,
			"ass" => $ass);
	}

	// untuk delete jadwal di penjadwalan
	public function deleteJadwal(){
		$ulevel = $this->session->userdata('ulevel');
		$sessionjurusan = $this->session->userdata('kdj');
		$sessionfakultas = $this->session->userdata('kdf');
		$sessionunip = $this->session->userdata('unip');

		// cek rule siakad
		$IDJadwal = $this->uri->segment(4);

		$hasil = "";
		$messageFeeder = "";

		if ($ulevel == 7){
			$this->db->from('_v2_rule_siakad');
			$this->db->where('ulevel',$ulevel);
			$this->db->where('user',$sessionunip);
			$this->db->where('Kodejurusan',$sessionjurusan);
			$this->db->where('Kodefakultas',$sessionfakultas);
			$this->db->where('form', 'jdwlkuliah1');
			$this->db->where('status_user', 'A');
			$hasil = $this->db->get();
			$status = $hasil->row();
		} else if ($ulevel == 5 or $ulevel == 1){
			$this->db->from('_v2_rule_siakad');
			$this->db->where('ulevel',$ulevel);
			$this->db->where('user',$sessionunip);
			$this->db->where('Kodefakultas',$sessionfakultas);
			$this->db->where('form', 'jdwlkuliah1');
			$this->db->where('status_user', 'A');
			$hasil = $this->db->get();
			$status = $hasil->row();
		}

		// kondisi untuk admin jurusan
		if(($hasil->num_rows() == 0) and $ulevel == 7){
			// kondisi jika tidak ada di rule, maka jadwal akan di hapus
			$result = $this->db->query("DELETE FROM _v2_jadwal WHERE IDJADWAL='$IDJadwal'");
			// if($result){
			// 	$messageFeeder = $this->deleteJadwalFeeder($IDJadwal);
			// }
			$this->rediralert("success", "Berhasil Menghapus Jadwal $messageFeeder", "", "", "", "");
		} else if (($hasil->num_rows() > 0) and $ulevel == 7) {
			if ($status->user == $sessionunip and $status->Kodejurusan == $sessionjurusan and $status->point_1 == 1 and $ulevel == 7){
				// kondisi jika ada di rule, denagan kondisi di atas maka jadwal akan di hapus
				$result = $this->db->query("DELETE FROM _v2_jadwal WHERE IDJADWAL='$IDJadwal'");
				// if($result){
				// 	$messageFeeder = $this->deleteJadwalFeeder($IDJadwal);
				// }
				$this->rediralert("success", "Berhasil Menghapus Jadwal $messageFeeder", "", "", "", "");
			} else if ($status->user == $sessionunip and $status->Kodejurusan == $sessionjurusan and $status->point_1 == 0 and $ulevel == 7){
				// tidak di berikan akses untuk menghapus jadwal
				$this->rediralert("warning", "Anda tidak di berikan akses untuk hapus jadwal", "", "", "", "");
			}
		}

		// kondisi untuk admin fakultas
		if(($hasil->num_rows() == 0) and $ulevel == 5){
			// tidak di berikan akses untuk menghapus jadwal
			$this->rediralert("warning", "Anda tidak di berikan akses untuk hapus jadwal", "", "", "", "");
		} else if (($hasil->num_rows() > 0) and $ulevel == 5){
			if ($status->user == $sessionunip and $status->Kodefakultas == $sessionfakultas and $status->point_1 == 1 and $ulevel == 5){
				// kondisi jika ada di rule, denagan kondisi di atas maka jadwal akan di hapus
				$result = $this->db->query("DELETE FROM _v2_jadwal WHERE IDJADWAL='$IDJadwal'");
				// if($result){
				// 	$messageFeeder = $this->deleteJadwalFeeder($IDJadwal);
				// }
				$this->rediralert("success", "Berhasil Menghapus Jadwal $messageFeeder", "", "", "", "");
			} else if ($status->user == $sessionunip and $status->Kodefakultas == $sessionfakultas and $status->point_1 == 0 and $ulevel == 5){
				// tidak di berikan akses untuk menghapus jadwal
				$this->rediralert("warning", "Anda tidak di berikan akses untuk hapus jadwal", "", "", "", "");
			}
		}

		// kondisi untuk admin superuser
		if($ulevel == 1){
			// tidak di berikan akses untuk menghapus jadwal
			//$this->rediralert("warning", "Anda tidak di berikan akses untuk hapus jadwal", "", "", "", "");
			$messageFeeder = $this->deleteJadwalFeeder($IDJadwal);
			$result = $this->db->query("DELETE FROM _v2_jadwal WHERE IDJADWAL='$IDJadwal'");
			$this->rediralert("success", "Berhasil Menghapus Jadwal $messageFeeder", "", "", "", "");
		}

	}

	// fungsi untuk hapus jadwal di feeder 
	private function deleteJadwalFeeder($IDJadwal){
		$message = "";

		$s = "SELECT id_kelas_kuliah FROM _v2_jadwal WHERE IDJADWAL = '$IDJadwal'";

		$r = $this->db->query($s)->result();

		foreach ($r as $val){

			$record['id_kelas_kuliah'] = $val->id_kelas_kuliah;

			$result = $this->feeder->deletefeeder("DeleteKelasKuliah", $record);
			$obj = json_decode($result);

			$error_code = $obj->{'error_code'}; // mendapatkan error code

			if ($error_code == 0){
				$resultData = $obj->{'data'}; // mengambil object
				$result = explode("=",$resultData); // memotong string
				$key_kelas_kuliah = $result[0];
				$id_kelas_kuliah = $result[1];

				if(!empty($id_kelas_kuliah) and $key_kelas_kuliah == "id_kelas_kuliah"){
					$message = "dan Jadwal di Feeder Berhasil di Hapus";
				} else {
					$message = "dan Jadwal di Feeder Gagal di Hapus";
				}
			} else {
				$message = "dan Jadwal di Feeder Gagal di Hapus";
			}
		}

		if(!empty($message)) {
			return $message;
		} else {
			return "dan Jadwal di Feeder Gagal di Hapus";
		}
	}

	// fungsi untuk mengetahui mahasiswa
	public function daftar_mhsw($jid,$thn,$angkatan) {
		// fandu matikan $s = "select m.NIM, Name, GradeNilai from _v2_krs k, _v2_mhsw m where IDJadwal='$jid' and Tahun='$thn' and k.NIM=m.NIM"; // Modif 08 - 2006 and Tahun='$thn'
		//if($thn!='20161'){
		if (!empty($angkatan)){
			$angkatan = "and m.TahunAkademik='$angkatan'";
		} else {
			$angkatan = "";
		}
		$s = "select m.NIM, m.Name, k.GradeNilai, k.st_feeder, k.Bobot, k.useredt, m.TahunAkademik, m.KodeJurusan, j.Ket_Jenjang from _v2_krs$thn k, _v2_mhsw m, _v2_jurusan j where IDJadwal='$jid' and Tahun='$thn' and k.NIM=m.NIM and k.st_wali='1' and m.KodeJurusan = j.Kode $angkatan ORDER BY k.NIM ASC";
		//}

		$r = $this->db->query($s)->result();
		return $r;
	}

	// fungsi untuk mengetahui mahasiswa
	public function HitungMhsw($jid,$thn,$kdj) {
		/*$s = "select count(*) as JML from _v2_krs where IDJadwal='$jid' and Tahun='$thn'"; // Modif 08 - 2006 and Tahun='$thn'
		if($thn!='20161'){*/
			$s = "select count(*) as JML from _v2_krs$thn where IDJadwal='$jid' and Tahun='$thn'"; // Modif 08 - 2006 and Tahun='$thn'
		//}

		$r = $this->db->query($s)->row();
		return $r->JML;
	}

	// fungsi untuk mengetahui mahasiswa yang sudah terupload ke feeder
	public function HitungMhsw_fd($jid,$thn,$kdj) {
		/*if($thn=='20161') $s = "select count(*) as JML from _v2_krs where IDJadwal='$jid' and Tahun='$thn' and st_feeder>0"; // Modif 08 - 2006 and Tahun='$thn'
		else */
		$s = "select count(*) as JML from _v2_krs$thn where IDJadwal='$jid' and Tahun='$thn' and st_wali='1' and st_feeder>0";

		$r = $this->db->query($s)->row();
		return $r->JML;
	}

	public function GetAssDsn($jid,$action,$int) {
		$str = '';
		$s = "select jad.*, concat(dsn.Name, ', ', dsn.Gelar) as nm_dosen, dsn.id_ptk, dsn.id_reg_ptk from _v2_jadwalassdsn jad left outer join _v2_dosen dsn on jad.IDDosen=dsn.nip where jad.IDJadwal='$jid' and jad.NotActive='N'";
		$r = $this->db->query($s)->result_array();
		$n = 0;
		// fandu tutup sementara
		foreach ($r as $w) {
			if ($action == 1){ // untuk detail daftar dosen pada jadwal tampil

				$id_ptk  = $w['id_ptk'];
				$id_reg_ptk  = $w['id_reg_ptk'];
				$id_ajar_p  = $w['id_ajar'];

				// untuk mengecek id ptk dosen di feeder
				if ($id_ptk != NULL or $id_ptk != ""){
					$cekidptk = "ID PTK | ";
				} else {
					$cekidptk = "<del>ID PTK</del> | ";
				}

				// untuk mengecek id registrasi penugasan dosen di feeder
				if ($id_reg_ptk != NULL or $id_reg_ptk != ""){
					$cekidregptk = "ID REG PTK | ";
				} else {
					$cekidregptk = "<del>ID REG PTK</del> | ";
				}

				// untuk mengecek ajar dosen di feeder
				if ($id_ajar_p != NULL or $id_ajar_p != ""){
					$cekajardosen = "Kirim ID Ajar | Lihat ID Ajar ";
				} else {
					$cekajardosen = "<a href='javascript:void(0)' onclick='kirimidajar(this,$int,2)'><del>Kirim ID Ajar</del></a> |";
				}

				$str .= "<br>- ".$w['nm_dosen']."<br><b>".$cekidptk.$cekidregptk.$cekajardosen."</b>";
			} else if ($action == 2) { // untuk options pada tambah jadwal pada status 2
				$str .= '<div class="form-group" id="'.$w['ID'].'">
							<label>Dosen lainnya</label>
							<select class="form-control select2" style="width: 100%;" id="dosenlainnya" name="dosenlainnya[]" readonly>
								<option value='.$w['IDDosen'].'>'.$w['nm_dosen'].' - '.$w['IDDosen'].'</option>
							</select>
							<button type="button" onClick="deldosen('.$w['ID'].')" class="btn btn-default"><img src="'.base_url().'assets/images/Delete_Icon.png" border=0></button>
					</div>';
			}
		}
		return $str;
	}

	function GetAssDsnPrint($jid) {
		$str = '';
		$s = "select jad.*, concat(dsn.Name, ', ', dsn.Gelar) as DSN from _v2_jadwalassdsn jad left outer join _v2_dosen dsn on jad.IDDosen=dsn.nip where jad.IDJadwal='$jid' and jad.NotActive='N' order by dsn.Name";
		$r = $this->db->query($s)->result_array();
		$n = 0;
		// fandu tutup sementara
		foreach ($r as $w) {
			$asd1[n] =$w['DSN'];
			$n++;
			// hanya untuk link $str .= "&asd$n=$w[DSN]";
		}
		return $str;
	}

	// menampilkan daftar jadwal yang sudah di jadwalkan
	public function jadwal(){
		$thn = $this->input->post('tahunakademik');
		$kdj = $this->input->post('jurusan');
		$kdp = $this->input->post('program');

		if ($this->input->post('hari')) {
			$this->session->set_userdata('hariSelect',$this->input->post('hari'));
			$hri = $this->input->post('hari');
		}else {
			$hri = $this->session->userdata('hariSelect');
		}

		/*$thn = "20181";
		$kdj = "F551";
		$kdp = "REG";*/

		$config = array(
			array(
				'field' => 'tahunakademik',
				'label' => 'Tahun Akademi',
				'rules' => 'required|max_length[8]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maksimal 8 Karakter',
				)
			),
		);

		$this->form_validation->set_rules($config);

		if ( $this->form_validation->run() == FALSE ) {

			$dataError = array(
				'ket' => 'error',
				'pesan' => validation_errors()
			);

			echo json_encode($dataError);

		} else {

			$value = $this->redirtampiljadwal($thn, $kdp, $kdj, $hri);

			if(!empty($value)){
				$result = array(
					"ket" => "sukses",
					"pesan" => "Berhasil Mengambil Jadwal",
					"senin" => $value[0]['senin'],
					"selasa" => $value[0]['selasa'],
					"rabu" => $value[0]['rabu'],
					"kamis" => $value[0]['kamis'],
					"jumat" => $value[0]['jumat'],
					"sabtu" => $value[0]['sabtu'],
					"minggu" => $value[0]['minggu']
				);
			} else {
				$result = array(
					"ket" => "sukses",
					"pesan" => "Berhasil Mengambil Jadwal",
					"senin" => "",
					"selasa" => "",
					"rabu" => "",
					"kamis" => "",
					"jumat" => "",
					"sabtu" => "",
					"minggu" => "",
				);
			}

			echo json_encode($result);
		}
	}

	function PrcJdwl() {
		if (isset($_POST['submitPrcJdwl'])){
			$thn = $this->input->post('tahun');
			$kdj = $this->input->post('kdj');
			$md = $this->input->post('md'); // test insert
			//echo $this->Jadwal->isTahunAktif($thn, $kdj);
			if (!$this->Jadwal->isTahunAktif($thn, $kdj)) {
				//DisplayHeader($fmtErrorMsg, $strTahunNotActive);
				//$md = -1;
				//echo "Tidak Terdaftar Tahun Akademik";
				$this->rediralert("warning", "Semester Akademik Tidak Terdaftar Silahkan Hubungi Fakultas Anda Untuk Pembukaan Semester Akademik", "", "", "", "");
			} else {
				$kdf = $this->Jadwal->GetaField('KodeFakultas','_v2_jurusan', 'Kode', $kdj);

				$Terjadwal = (!empty($_POST['Terjadwal']) && ($_POST['Terjadwal'] == 'Y')) ? 'Y' : 'N';

				$IDMK = $this->input->post('IDMK');

				$arrmk1 = $this->app->GetFields('Kode, SKS, Nama_Indonesia, id_mk', '_v2_matakuliah', 'IDMK', $IDMK);

				foreach ($arrmk1->result() as $arrmk){
					$KDMK = $arrmk->Kode;
					$id_mk =  $arrmk->id_mk;
					$SKS = $arrmk->SKS;
					$Nama_Indonesia = $arrmk->Nama_Indonesia;
				}

				$Program = $this->input->post('Program');
				$KodeRuang = $this->input->post('KodeRuang');

				$KodeKampus = $this->Jadwal->GetaField('KodeKampus' ,'_v2_ruang', 'Kode', $KodeRuang);

				$Hari = $this->input->post('Hari');
				$jm = $this->input->post('JamMulai');
				$jam2awal=substr("$jm",0,2);

				$js = $this->input->post('JamSelesai');

				$unip = $this->session->userdata('unip');

				$Rencana = $this->input->post('Rencana');
				$Realisasi = $this->input->post('Realisasi');
				$Keterangan = $this->input->post('Keterangan');
				$Ket = $this->input->post('ket'); // ket -- terimput di field kelas
				$IDPAKET = $this->input->post('IDPAKET');
				$IDJADWAL = $this->input->post('IDJADWAL');
				$IDDosen = $this->input->post('dosenpengampu');
				$kaps = $this->input->post('kaps');

				$jid = $IDJADWAL;

				$Tanggalskrg=date("Y-m-d H:i:s");
				$TmStamp=strtotime($Tanggalskrg);

				if (empty($IDJADWAL)) { // kondisi saat penginputan baru jadwal
					$SqIdJd = "select max(right(IDJADWAL,10)) as maxid from _v2_jadwal where KodeJurusan like '$kdf%'";
					$IdJdMax = $this->db->query($SqIdJd)->row()->maxid;

					if(empty($IdJdMax)) {
						$IdTstamp=$TmStamp;
					} else {
						$IdTstamp=$KDMK.$Program.$Keterangan.str_replace(' ', '', $Ket);
					}

					$IDJADWALBr = "$kdj"."$thn"."$IdTstamp";
				} else { // kondisi saat mengedit jadwal
					$equalsIDJadwal = $kdj.$thn.$KDMK.$Program.$Keterangan.str_replace(' ', '', $Ket);

					if ($IDJADWAL == $equalsIDJadwal){
						$IDJADWALBr = $IDJADWAL;
					} else {
						$IDJADWALBr = $equalsIDJadwal;
					}
						
				}

				// maksudnya apa if (isset($_REQUEST['glob'])) $glob = $_REQUEST['glob']; else $glob = 'N';
				// Apakah gabungan?
				// fandu hapus field Global='$glob'

				$cekidjadwal = "select IDJADWAL from _v2_jadwal where IDJadwal='$IDJADWALBr'";

				$residjadwal = $this->db->query($cekidjadwal)->num_rows();
				if ($residjadwal == 0 or $md == 2) { // apakah IDJADWAL sudah pernah terinput
					$cekruangan = $this->jadwal_phpexcel_model->CheckRuang($thn, $jid, $KodeKampus, $KodeRuang, $Hari, $jm, $js);
					$oke = $cekruangan['status'];
					if ($oke) { //  or $md == 2 // pengecekan walau edit jadwal
						if ($md == 2) { // edit
							$s = "update _v2_jadwal set IDJADWAL='$IDJADWALBr',IDMK='$IDMK', KodeMK='$KDMK', SKS='$SKS',NamaMK='$Nama_Indonesia', Terjadwal='$Terjadwal',
							  Program='$Program', Hari='$Hari', JamMulai='$jm', JamSelesai='$js',
							  KodeKampus='$KodeKampus', KodeRuang='$KodeRuang', Rencana='$Rencana', Realisasi='$Realisasi',Keterangan='$Keterangan',Kelas='$Ket',IDPAKET='$IDPAKET', IDDosen='$IDDosen', kap='$kaps'
							  where IDJADWAL='$jid'";
							$stat = "Berhasil di Rubah";
						} elseif ($md == 1) { // tambah baru

							$kaps = $this->jadwal_phpexcel_model->CekKapasitas($KodeRuang);

							if($kaps<=0) $kaps=30;

							$s = "insert into _v2_jadwal (id_mk,IDJADWAL,Tahun, Terjadwal, KodeFakultas, KodeJurusan, IDMK, KodeMK, NamaMK,
							  SKS, Program, Hari,
							  JamMulai, JamSelesai, KodeKampus, KodeRuang,kap, unip, Tanggal, Rencana, Realisasi,Keterangan,Kelas,IDPAKET,IDDosen)
							  values ('$id_mk','$IDJADWALBr', '$thn', '$Terjadwal', '$kdf', '$kdj', '$IDMK', '$KDMK', '$Nama_Indonesia',
							  '$SKS', '$Program', '$Hari', '$jm',
							  '$js', '$KodeKampus', '$KodeRuang',$kaps, '$unip', '$Tanggalskrg', '$Rencana', '$Realisasi','$Keterangan','$Ket','$IDPAKET','$IDDosen')";

							$stat = "Berhasil Terinput";
						}
						//echo $s;
						$r = $this->db->query($s);

						// insert assisten dosen
						$dosenlainnya = $this->input->post('dosenlainnya');

						foreach( $dosenlainnya as $n ){
							if (!empty($n)){
								$cek = "select * from _v2_jadwalassdsn where IDJadwal='$IDJADWALBr' and IDDosen='$n'";

								$hm = $this->db->query($cek)->num_rows();
								if ($hm == 0) {
									$ins_assdsn = "insert into _v2_jadwalassdsn (IDJadwal, IDDosen, NotActive) values('$IDJADWALBr', '$n', 'N')";
									$this->db->query($ins_assdsn);
								}
							}
						}

						$messagefeeder = $this->update_jadwal_feeder($IDJADWALBr, $thn); // proses ke feeder

						$statalert = "success";
					} else {
						$stat = $cekruangan['display'];
						$statalert = "error";
						$messagefeeder = "";
					}
					// fandu tutup 09-08-2018 fungsi mengembalikan redirect(base_url($this->session->userdata('sess_tamplate')));

					$this->rediralert("$statalert", "Matakuliah $Nama_Indonesia $stat $messagefeeder", "list", $thn, $Program, $kdj);

					//echo "Matakuliah $Nama_Indonesia - $s - $stat - $md, $thn, $Program, $kdj";

				} else {

					$this->rediralert("error", "Matakuliah $Nama_Indonesia Sudah Pernah di Input", "list", $thn, $Program, $kdj); // list pada parameter ke tiga untuk mengembalikan nilai balik pada list jadwal

				}
			}
		} else {
			redirect(base_url($this->session->userdata('sess_tamplate')));
		}
	}

	/*function CheckRuang ($thn, $jid, $kdk, $kdr, $hr, $jm, $js) {
		$sm = "select * from _v2_jadwal where KodeKampus='$kdk' and KodeRuang='$kdr' and Hari='$hr' and
		JamMulai <= '$jm:00' and '$jm:00' <= JamSelesai and IDJADWAL<>'$jid' and Tahun='$thn'";

		$rm = $this->db->query($sm);
		$hm = $rm->num_rows();
		if ($hm > 0) {
			$detailjadwals = $rm->row();
			$str1 =  $str2 = '<b>'.$detailjadwals->NamaMK.' Jam Mulai Bentrok : Mulai '.$detailjadwals->JamMulai.' - Selesai '.$detailjadwals->JamSelesai.'.</b>';
		}
		else $str1 = '';

		$ss = "select * from _v2_jadwal where KodeKampus='$kdk' and KodeRuang='$kdr' and Hari=$hr and
			JamMulai <= '$js' and '$js' <= JamSelesai and IDJADWAL<>'$jid' and Tahun='$thn' ";
		$rs = $this->db->query($ss);
		$hs = $rs->num_rows();

		if ($hs > 0) {
			$detailjadwals = $rs->row();
			$str2 = '<b>'.$detailjadwals->NamaMK.'<br>Jam Mulai Bentrok : <br>Mulai '.$detailjadwals->JamMulai.' - Selesai '.$detailjadwals->JamSelesai.'.</b>';
		}
		else $str2 = '';

		$bol = (($hm == 0) && ($hs == 0));
		if (!($bol)) {
			$displayheader = "Tidak dapat dijadwalkan di <b>$kdk - $kdr</b>.<br>Ruang telah dipakai oleh : <br><ul> $str1 $str2 </ul>";
		} else {
			$displayheader = "";
		}

		return array(
			"status" => $bol,
			"display" => $displayheader
		);
		// echo "$sm dan fandu $ss";
	} */

	/*function CekKapasitas($idr) {
      $s = "select Kapasitas from _v2_ruang where Kode='$idr';";
	  $r = $this->db->query($s)->row();
	  return $r->Kapasitas;
	}*/

	function addassdosen() {
		$ulevel = $this->session->userdata("ulevel");
		$kdf = $this->session->userdata("kdf");
		$kdj = $this->session->userdata("kdj");

		$options = "";

		/*if ($ulevel == 1){
			$kondisi_dosen = "NotActive='N'";
		} else if ($ulevel == 5){
			$kondisi_dosen = "KodeFakultas='$kdf' and NotActive='N'";
		} else if ($ulevel == 7) {
			$kondisi_dosen = "KodeJurusan='$kdj' and NotActive='N'";
		}*/

		$kondisi_dosen = "NotActive='N'";

		$GetField = $this->app->GetField("NIP, concat(Name, ' ' , Gelar, ' - ', NIP) as nm_dosen", "_v2_dosen", "$kondisi_dosen", "")->result_array(); // untuk dosen pengampu dan asisten dosen

		foreach ($GetField as $dosen) {
			$options .= "<option value=".$dosen['NIP'].">".$dosen['nm_dosen']."</option>";
		}

		$add = '<div class="form-group">
								<label>Dosen lainnya</label>
								<select class="form-control select2" style="width: 100%;" id="dosenlainnya" name="dosenlainnya[]">
									<option></option>'.$options.'
								</select>
							</div>';
							//<button type="button" onClick="hapus(event)" class="btn btn-default"><img src="'.base_url().'assets/images/Delete_Icon.png" border=0></button>

		echo $add;
	}

	function deldosen() {
		$idjadwal = $this->input->post('idjadwal');
		$iddosen = $this->input->post('iddosen');

		//$s = "Delete From _v2_jadwalassdsn where IDJadwal='$idjadwal' and IDDosen='$iddosen'";
		$s = "Delete From _v2_jadwalassdsn where ID='$iddosen'";
		$r = $this->db->query($s);
		if ($r) {
			echo "Success";
		} else {
			echo "Error";
		}
	}

	function daftarmhsnil() {
		//$idjadwal = "C30120181EKA5802REGAAk";
		//$thn = "20181";

		

		$idjadwal 		= decode($this->input->post('idjadwal'));
		$thn 			= $this->input->post('tahun');
		$angkatan 		= $this->input->post('angkatan');
		$daftar 		= $this->daftar_mhsw($idjadwal,$thn,$angkatan);
		
		// var for checking query get data mahasiswa 
		// $cek  			= "";
		
		$string 		= "";
		$nopeserta 		= 1;
		$tahunakademik 	= 1;
		$pesan 			= false;

		/*$css = "bitbucket";
		$css1 = "bitbucket";
		$css2 = "bitbucket";
		$css3 = "bitbucket";
		$css4 = "bitbucket";
		$css5 = "bitbucket";
		$css6 = "bitbucket";
		$css7 = "bitbucket";
		$css8 = "bitbucket";
		$css9 = "bitbucket";
		$css10 = "bitbucket";
		$css11 = "bitbucket";
		$css12 = "bitbucket";

		if ($row->GradeNilai == "A") {
			$css = "danger";
		} else if ($row->GradeNilai == "A-") {
			$css1 = "danger";
		} else if ($row->GradeNilai == "B+") {
			$css2 = "danger";
		} else if ($row->GradeNilai == "B") {
			$css3 = "danger";
		} else if ($row->GradeNilai == "B-") {
			$css4 = "danger";
		} else if ($row->GradeNilai == "C+") {
			$css5 = "danger";
		} else if ($row->GradeNilai == "C") {
			$css6 = "danger";
		} else if ($row->GradeNilai == "C-") {
			$css7 = "danger";
		} else if ($row->GradeNilai == "D") {
			$css8 = "danger";
		} else if ($row->GradeNilai == "E") {
			$css9 = "danger";
		} else if ($row->GradeNilai == "K") {
			$css10 = "danger";
		} else if ($row->GradeNilai == "T") {
			$css11 = "danger";
		} else if ($row->GradeNilai == "AB") {
			$css12 = "danger";
		}*/
		
		$ulevel = $this->session->userdata('ulevel');
		$sessionjurusan = $this->session->userdata('kdj');
		$sessionfakultas = $this->session->userdata('kdf');
		$sessionunip = $this->session->userdata('unip');
		
		if ($ulevel == 7){
			$this->db->from('_v2_rule_siakad');
			$this->db->where('ulevel',$ulevel);
			$this->db->where('user',$sessionunip);
			$this->db->where('Kodejurusan',$sessionjurusan);
			$this->db->where('Kodefakultas',$sessionfakultas);
			$this->db->where('form', 'jdwlkuliah1');
			$this->db->where('status_user', 'A');
			$hasil = $this->db->get();
			$status = $hasil->row();
		} else if ($ulevel == 5 or $ulevel == 1){
			$this->db->from('_v2_rule_siakad');
			$this->db->where('ulevel',$ulevel);
			$this->db->where('user',$sessionunip);
			$this->db->where('Kodefakultas',$sessionfakultas);
			$this->db->where('form', 'jdwlkuliah1');
			$this->db->where('status_user', 'A');
			$hasil = $this->db->get();
			$status = $hasil->row();
		}
			
		// kondisi untuk admin jurusan
		if(($hasil->num_rows() == 0) and $ulevel == 7){
			// kondisi jika tidak ada di rule, maka tidak bisa akan memvalidasi
			// maaf anda tidak di berikan akses untuk memvalidasi nilai
			$message = "maaf anda tidak di berikan akses untuk input/edit nilai";
		} else if (($hasil->num_rows() > 0) and $ulevel == 7) {
			if ($status->user == $sessionunip and $status->Kodejurusan == $sessionjurusan and $status->point_4 == 1 and $ulevel == 7){
				// kondisi jika ada di rule, denagan kondisi di atas maka akan divalidasi				
				//bisa melakukan validasi nilai
				$pesan = true;
			} else if ($status->user == $sessionunip and $status->Kodejurusan == $sessionjurusan and $status->point_4 == 0 and $ulevel == 7){
				// tidak akan divalidasi
				// maaf anda tidak di berikan akses untuk memvalidasi nilai
				$message = "maaf anda tidak di berikan akses untuk input/edit nilai";
			}
		} 

		// kondisi untuk admin fakultas
		if(($hasil->num_rows() == 0) and $ulevel == 5){
			// kondisi jika tidak ada di rule, maka akan divalidasi
			$pesan = true;
		} else if (($hasil->num_rows() > 0) and $ulevel == 5){
			if ($status->user == $sessionunip and $status->Kodefakultas == $sessionfakultas and $status->point_4 == 1 and $ulevel == 5){
				// kondisi jika ada di rule, denagan kondisi di atas maka akan divalidasi
				$pesan = true;
			} else if ($status->user == $sessionunip and $status->Kodefakultas == $sessionfakultas and $status->point_4 == 0 and $ulevel == 5){
				// tidak tampil dan tidak akan di validasi
				// maaf anda tidak di berikan akses untuk memvalidasi nilai
				$message = "maaf anda tidak di berikan akses untuk input/edit nilai";
			}
		}

		if($ulevel == 1){
			// maaf adminsuperuser tidak di berikan akses untuk memvalidasi nilai
			$message = "maaf admin superuser tidak di berikan akses untuk input/edit nilai";
		}
			

		// kondisi jika user di berikan akses untuk input/edit nilai
		if ($pesan){

			// $jadId = encode($idjadwal);
			$jadId = $idjadwal;
		
			$jur = "select jad.KodeJurusan, j.Ket_Jenjang from _v2_jadwal jad, _v2_jurusan j where IDJADWAL='$jadId' and Tahun='$thn' and jad.KodeJurusan=j.Kode";
			$row_jur = $this->db->query($jur)->row();

			// penyebab di berikan kondisi i kedok karena hanya untuk kedokteran yang kriteria penilaiannya yang ada di tabel _v2_nilai, dan yang lainnya itu masi umum kriteria penilaian gradenilai dan bobot
			$jur = $row_jur->KodeJurusan;

			if ($jur == "N210" or $jur == "N101" or $jur == "N111" or 
			$jur == "P101" or
			$jur == "K2MF111" or
			$jur == "K2MC201" or
			$jur == "K2ME281" or 
			$jur == "E321" or $jur == "E281" or 
			$jur == "D101" or
			$jur == "C101" or $jur == "C200" or $jur == "C201" or $jur == "C300" or $jur == "C301" or
			$jur == "F111" or $jur == "F121" or $jur == "F210" or $jur == "F221" or $jur == "F230" or $jur == "F231" or $jur == "F240" or $jur == "F331" or $jur == "F441" or $jur == "F551" or
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

							$buttonoptions .= "<div class='col-md-2'> <button type='button' class='btn btn-flat btn-".$cssoptions."' onClick='nilai(".$value->ID.",".$nopeserta.",this)'>".$value->Nilai." (".$value->Bobot.")</button></div>";
							$nil_options++;
						}

						$string .= "<div class='form-group row'>
							<input type='hidden' class='form-control' id='nim".$nopeserta."' value='".$row->NIM."' readOnly>
							<div class='col-md-3'>
									<label for='name' class='col-md-3 col-form-label'>".$row->NIM."<br>".$row->Name."<br>".$row->useredt."</label>
							</div>
							<div class='col-md-9 row'>
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
			"daftarnil" => $string,
		);

		echo json_encode($result);
	}

	// fandu matikan untuk  daftar mahasiswa yang di kirim ke dikti
	/*function daftardikti() {
		//$idjadwal = "F55120171F09171011REGD";
		$idjadwal = $this->input->post('idjadwal');
		//$thn = "20171";
		$thn = $this->input->post('tahun');

		$daftar = $this->daftar_mhsw($idjadwal,$thn);

		$string = "";
		$int = 1;
		$nila="1";

		foreach ($daftar as $row){

			$string .= "<div class='form-group row'>
				<input type='hidden' class='form-control' id='nim".$int."' value='".$row->NIM."' readOnly>
				<label for='name' class='col-md-6 col-form-label'>".$row->NIM."<br>".$row->Name."</label>
				<div class='col-md-6'>
						<button onClick='nilaidikti(1,".$int.",this)' class='btn btn-block btn-social btn-flickr'><i class='fa fa-flickr'></i> Kirim Ke Dikti</button>
				</div>
			</div>";
			$int++;

		}

		$result = array(
			"ket" => "sukses",
			"pesan" => "Berhasil Mengambil Daftar Mahasiswa",
			"daftarnil" => $string
		);

		echo json_encode($result);
	}*/

	function innilai() {

		//6 - C30120181C3015139REGAAk - C30115006 - 20181
		//$idjadwal = "F55120171F09171011REGD";
		$ulevel = $this->session->userdata("ulevel");
		$uname = $this->session->userdata("uname");
		$idjadwal = $this->input->post('idjadwal');
		//$thn = "20171";
		$thn = $this->input->post('tahun');
		$nim = $this->input->post('nim');
		$nil = $this->input->post('nil');
		$thnkrs = $thn;

		/*if($thn == '20161'){
			$thnkrs = "";
		}*/

		/*
			1=A
			2=A-
			3=B+
			4=B
			5=B-
			6=C+
			7=C
			8=C-
			9=D
			10=E
		*/

		/*if ($nil == 1) {
			$gradenilai = "A";
			$bobot = "4.00";
		}
		else if ($nil == 2) {
			$gradenilai = "A-";
			$bobot = "3.75";
		}
		else if ($nil == 3) {
			$gradenilai = "B+";
			$bobot = "3.50";
		}
		else if ($nil == 4) {
			$gradenilai = "B";
			$bobot = "3.00";
		}
		else if ($nil == 5) {
			$gradenilai = "B-";
			$bobot = "2.75";
		}
		else if ($nil == 6) {
			$gradenilai = "C+";
			$bobot = "2.50";
		}
		else if ($nil == 7) {
			$gradenilai = "C";
			$bobot = "2.00";
		}
		else if ($nil == 8) {
			$gradenilai = "C-";
			$bobot = "1.75";
		}
		else if ($nil == 9) {
			$gradenilai = "D";
			$bobot = "1.00";
		}
		else if ($nil == 10) {
			$gradenilai = "E";
			$bobot = "0.00";
		}*/

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

		echo json_encode($result);
	}

	/*function validasinilai() { fandu matikan 15/06/2019 karena sudah tidak di gunakan
		if (isset($_POST['simpan'])){

			// batas atas cek rule siakad
			$ulevel = $this->session->userdata('ulevel');
			$sessionjurusan = $this->session->userdata('kdj');
			$sessionfakultas = $this->session->userdata('kdf');
			$sessionunip = $this->session->userdata('unip');

			$hasil = "";

			if ($ulevel == 7){
				$this->db->from('_v2_rule_siakad');
				$this->db->where('ulevel',$ulevel);
				$this->db->where('user',$sessionunip);
				$this->db->where('Kodejurusan',$sessionjurusan);
				$this->db->where('Kodefakultas',$sessionfakultas);
				$this->db->where('form', 'jdwlkuliah1');
				$this->db->where('status_user', 'A');
				$hasil = $this->db->get();
				$status = $hasil->row();
			} else if ($ulevel == 5 or $ulevel == 1){
				$this->db->from('_v2_rule_siakad');
				$this->db->where('ulevel',$ulevel);
				$this->db->where('user',$sessionunip);
				$this->db->where('Kodefakultas',$sessionfakultas);
				$this->db->where('form', 'jdwlkuliah1');
				$this->db->where('status_user', 'A');
				$hasil = $this->db->get();
				$status = $hasil->row();
			}

			$uname = $this->session->userdata("uname");
			$idjadwalinnilai = $this->input->post('idjadwalinnilai');
			$thn = $this->input->post('tahunvalidasi');
			$program = $this->input->post('programvalidasi');
			$kdj = $this->input->post('kdjvalidasi');

			// kondisi untuk admin jurusan
			if(($hasil->num_rows() == 0) and $ulevel == 7){
				// kondisi jika tidak ada di rule, maka tidak akan memvalidasi
				//$result[] = $this->func_tampiljadwal($ulevel,$thn,$kdj,$kdp,$id,$actval_idjadwal);
				// maaf anda tidak di berikan akses untuk memvalidasi nilai
				$this->rediralert("warning", "maaf anda tidak di berikan akses untuk memvalidasi nilai", "", "$thn", "$program", "$kdj");
			} else if (($hasil->num_rows() > 0) and $ulevel == 7) {
				if ($status->user == $sessionunip and $status->Kodejurusan == $sessionjurusan and $status->point_3 == 1 and $ulevel == 7){
					// kondisi jika ada di rule, denagan kondisi di atas maka akan divalidasi					//$result[] = $this->func_tampiljadwal($ulevel,$thn,$kdj,$kdp,$id,$actval_idjadwal);
					$this->func_validasi($uname, $idjadwalinnilai, $thn, $program, $kdj);
				} else if ($status->user == $sessionunip and $status->Kodejurusan == $sessionjurusan and $status->point_3 == 0 and $ulevel == 7){
					// tidak akan divalidasi
					// maaf anda tidak di berikan akses untuk memvalidasi nilai
					$this->rediralert("warning", "maaf anda tidak di berikan akses untuk memvalidasi nilai", "", "$thn", "$program", "$kdj");
				}
			}

			// kondisi untuk admin fakultas
			if(($hasil->num_rows() == 0) and $ulevel == 5){
				// kondisi jika tidak ada di rule, maka akan divalidasi
				$this->func_validasi($uname, $idjadwalinnilai, $thn, $program, $kdj);
			} else if (($hasil->num_rows() > 0) and $ulevel == 5){
				if ($status->user == $sessionunip and $status->Kodefakultas == $sessionfakultas and $status->point_3 == 1 and $ulevel == 5){
					// kondisi jika ada di rule, denagan kondisi di atas maka akan divalidasi
					//$result[] = $this->func_tampiljadwal($ulevel,$thn,$kdj,$kdp,$id,$actval_idjadwal);
					$this->func_validasi($uname, $idjadwalinnilai, $thn, $program, $kdj);
				} else if ($status->user == $sessionunip and $status->Kodefakultas == $sessionfakultas and $status->point_3 == 0 and $ulevel == 5){
					// tidak tampil dan tidak akan di validasi
					// maaf anda tidak di berikan akses untuk memvalidasi nilai
					$this->rediralert("warning", "maaf anda tidak di berikan akses untuk memvalidasi nilai", "", "$thn", "$program", "$kdj");
				}
			}

			if($ulevel == 1){
				// maaf adminsuperuser tidak di berikan akses untuk memvalidasi nilai
				$this->rediralert("warning", "maaf adminsuperuser tidak di berikan akses untuk memvalidasi nilai", "", "$thn", "$program", "$kdj");
			}
		} else {
			$this->rediralert("warning", "Anda Melanggar Hak Akses", "", "$thn", "$program", "$kdj");
		}
	}*/

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

	/*public function kirimnilaidiktifandu (){
		$idjadwal = $this->input->post("idjadwalinnilai");
		$tahun = $this->input->post("tahunvalidasi");
		$program = $this->input->post("programvalidasi");
		$kdj = $this->input->post("kdjvalidasi");

		$tbl = "_v2_krs$tahun";

		$hasil = $this->db->query("SELECT n.ID, n.NIM, n.Tahun, n.nilai, n.GradeNilai, n.Bobot, n.KodeMK, n.enkripsi, j.id_kelas_kuliah, j.IDJADWAL, m.id_reg_pd FROM $tbl n left join _v2_jadwal j on n.IDJadwal=j.IDJADWAL left join _v2_mhsw m on n.NIM=m.NIM  WHERE n.Tahun = '$tahun' AND n.IDJadwal LIKE '$idjadwal' AND n.GradeNilai != ''");

		$daftarmhs = "";

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

			$daftarmhs .= "Data Berhasil di input stambuk $NIM<br>";
			//echo $msgDecrypt.$encrypt;
		}

		$result = array(
			"ket" => "sukses",
			"pesan" => $daftarmhs,
		);

		echo json_encode($result);

	}*/

	public function kirimnilaidikti(){

			// batas atas cek rule siakad
			$ulevel = $this->session->userdata('ulevel');
			$sessionjurusan = $this->session->userdata('kdj');
			$sessionfakultas = $this->session->userdata('kdf');
			$sessionunip = $this->session->userdata('unip');
			
			$idjadwal = $this->input->post("idjadwalinnilai");
			$tahun = $this->input->post("tahunvalidasi");
			$program = $this->input->post("programvalidasi");
			$kdj = $this->input->post("kdjvalidasi");

			$hasil = "";
			$pesan = "Error";

			if ($ulevel == 7){
				$this->db->from('_v2_rule_siakad');
				$this->db->where('ulevel',$ulevel);
				$this->db->where('user',$sessionunip);
				$this->db->where('Kodejurusan',$sessionjurusan);
				$this->db->where('Kodefakultas',$sessionfakultas);
				$this->db->where('form', 'jdwlkuliah1');
				$this->db->where('status_user', 'A');
				$hasil = $this->db->get();
				$status = $hasil->row();
			} else if ($ulevel == 5 or $ulevel == 1){
				$this->db->from('_v2_rule_siakad');
				$this->db->where('ulevel',$ulevel);
				$this->db->where('user',$sessionunip);
				$this->db->where('Kodefakultas',$sessionfakultas);
				$this->db->where('form', 'jdwlkuliah1');
				$this->db->where('status_user', 'A');
				$hasil = $this->db->get();
				$status = $hasil->row();
			}

			// kondisi untuk admin jurusan
			if(($hasil->num_rows() == 0) and $ulevel == 7){
				// kondisi jika tidak ada di rule, maka tidak bisa akan memvalidasi
				// maaf anda tidak di berikan akses untuk memvalidasi nilai
				$message = "maaf anda tidak di berikan akses untuk memvalidasi nilai";
			} else if (($hasil->num_rows() > 0) and $ulevel == 7) {
				if ($status->user == $sessionunip and $status->Kodejurusan == $sessionjurusan and $status->point_3 == 1 and $ulevel == 7){
					// kondisi jika ada di rule, denagan kondisi di atas maka akan divalidasi				
					//bisa melakukan validasi nilai
					$this->proses_kirimnilaidikti($idjadwal, $tahun, $program, $kdj);
					$pesan = "Success";
				} else if ($status->user == $sessionunip and $status->Kodejurusan == $sessionjurusan and $status->point_3 == 0 and $ulevel == 7){
					// tidak akan divalidasi
					// maaf anda tidak di berikan akses untuk memvalidasi nilai
					$message = "maaf anda tidak di berikan akses untuk memvalidasi nilai";
				}
			}

			// kondisi untuk admin fakultas
			if(($hasil->num_rows() == 0) and $ulevel == 5){
				// kondisi jika tidak ada di rule, maka akan divalidasi
				$this->proses_kirimnilaidikti($idjadwal, $tahun, $program, $kdj);
				$pesan = "Success";
			} else if (($hasil->num_rows() > 0) and $ulevel == 5){
				if ($status->user == $sessionunip and $status->Kodefakultas == $sessionfakultas and $status->point_3 == 1 and $ulevel == 5){
					// kondisi jika ada di rule, denagan kondisi di atas maka akan divalidasi
					$this->proses_kirimnilaidikti($idjadwal, $tahun, $program, $kdj);
					$pesan = "Success";
				} else if ($status->user == $sessionunip and $status->Kodefakultas == $sessionfakultas and $status->point_3 == 0 and $ulevel == 5){
					// tidak tampil dan tidak akan di validasi
					// maaf anda tidak di berikan akses untuk memvalidasi nilai
					$message = "maaf anda tidak di berikan akses untuk memvalidasi nilai";
				}
			}

			if($ulevel == 1){
				// maaf adminsuperuser tidak di berikan akses untuk memvalidasi nilai
				$message = "maaf admin superuser tidak di berikan akses untuk memvalidasi nilai";
			}
			
			if ($pesan == "Error"){
				$result = array(
					"ket" => "Error",
					"pesan" => $message,
				);
				echo json_encode($result);
			}
	
	}

	private function proses_kirimnilaidikti($idjadwal, $tahun, $program, $kdj){
		/*$idjadwal = $this->input->post("idjadwalinnilai");
		$tahun = $this->input->post("tahunvalidasi");
		$program = $this->input->post("programvalidasi");
		$kdj = $this->input->post("kdjvalidasi");*/

		$tbl = "_v2_krs$tahun";

		/*$this->db->from('_v2_krs'.$tahun);
		$this->db->where('IDJadwal', $idjadwal);
		$this->db->where('(st_feeder = 0 or st_feeder = 5)');
		$this->db->where('GradeNilai !=', '');
		$hasil = $this->db->get();
		$status = $hasil->num_rows();
		echo $status;*/

		$feeder = $this->feeder->getToken_feeder();
		$temp_token = $feeder['temp_token'];
		$temp_proxy = $feeder['temp_proxy'];

		//echo $idjadwal;

		$message = "";

		$hasil = $this->db->query("SELECT n.ID, n.NIM, n.Tahun, n.nilai, n.GradeNilai, n.Bobot, n.KodeMK, n.enkripsi, j.id_kelas_kuliah, j.IDJADWAL, m.id_reg_pd, m.KodeFakultas FROM $tbl n left join _v2_jadwal j on n.IDJadwal=j.IDJADWAL left join _v2_mhsw m on n.NIM=m.NIM  WHERE n.Tahun = '$tahun' AND (n.st_feeder = 0 or n.st_feeder = 5 or n.st_feeder = -3) AND n.IDJadwal LIKE '$idjadwal' AND n.GradeNilai != ''");

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
			"pesan" => $message,
		);

		echo json_encode($result);

	}

	/*private function func_validasi($uname, $idjadwalinnilai, $thn, $program, $kdj){ fandu matikan 15/06/2019 karena sudah tidak di gunakan
		/*$uname = $this->session->userdata("uname");
		$idjadwalinnilai = $this->input->post('idjadwalinnilai');
		$thn = $this->input->post('tahunvalidasi');
		$program = $this->input->post('programvalidasi');
		$kdj = $this->input->post('kdjvalidasi');*--/
		$s = "update _v2_jadwal set StatusVal='V', UserVal='$uname', TglVal=now() where IDJADWAL='$idjadwalinnilai' and Tahun='$thn'";
		$res = $this->db->query($s);
		if ($res){
			$this->rediralert("success", "Matakuliah berhasil di validasi", "success", "$thn", "$program", "$kdj");
		} else {
			$this->rediralert("error", "Matakuliah gagal di validasi", "", "$thn", "$program", "$kdj");
		}
	}*/

	function diktipermhsw() {
		// function table di rest full GetRiwayatNilaiMahasiswa()

		//$error_status['800'] Data nilai dari id_kelas_kuliah dan id_registrasi_mahasiswa ini sudah ada

		$id_reg_pd = $_POST['id_reg_pd'];
		$id_kelas_kuliah = $_POST['id_kelas_kuliah'];
		$gradenilai = $_POST['gradenilai'];
		$bobot = $_POST['bobot'];
		$thnx = $_POST['thn'];
		$IDKRS = $_POST['ID'];

		include 'ws/nusoap/nusoap.php';
		include 'ws/nusoap/class.wsdlcache.php';

		$wsdl = 'http://103.245.72.97:8082/ws/live.php?wsdl';

		$client = new nusoap_client($wsdl, true);
		$proxy = $client->getProxy();
		$nim = $_POST['user'];
		$password = $_POST['pass'];
		//echo $username.$password;
		$result = $proxy->GetToken("001028e1", "az18^^");
		$token = $result;
		echo "Token = ".$token."<br>";

		$record = array();
		$record['id_kls']= $id_kelas_kuliah;
		$record['id_reg_pd']= $id_reg_pd;
		$record['asal_data']="9";
		$record['nilai_angka']=0;
		$record['nilai_huruf']=$gradenilai;
		$record['nilai_indeks']=$bobot;

		echo json_encode($record);
		echo "<br>";

		//insert tabel mahasiswa
		$resultb = $proxy->InsertRecord($token, "nilai", json_encode($record));
		//var_dump($resultb);

		$datb = $resultb['result'];

		//$id_kls = $datb['id_kls'];
		$error_code = $datb['error_code'];
		$error_desc = $datb['error_desc'];
		//$id_reg_pd = $datb['id_reg_pd'];
		//echo "<td>".$id_reg_pd."</td>";

		/// var_dump($result2);
		if($error_code == 0){
			$qupdate = "update krs$thnx set st_feeder=3 where ID='$IDKRS'";
			echo "<td>$qupdate---$id_pd</td>";
			mysql_query($qupdate);

		}else if($error_code == 800){
			$qupdate = "update krs$thnx set st_feeder=3 where ID='$IDKRS'";
			echo "<td>$qupdate---$id_pd</td>";
			mysql_query($qupdate);
		}else{
			echo "<td>$error_code-$error_desc</td>";
			echo "<td>Proses ID PD Gagal JJ-$id_kls -JJ- $id_reg_pd</td></tr>";
			$qupdate = "update krs$thn set st_feeder=-1 where ID='$IDKRS'";
			mysql_query($qupdate);
		}
	}

	 public function import_excel(){

		if(!isset($_POST['runimport'])) {
			redirect(base_url($this->session->userdata('sess_tamplate')));
		}

        $config['upload_path'] = './assets/uploads/';
        $config['allowed_types'] = 'xlsx|xls';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload()){

            $error = array('error' => $this->upload->display_errors());
			echo var_dump($error);
        }
        else{
			//echo "masuk";
            $data = array('upload_data' => $this->upload->data());
            $upload_data = $this->upload->data(); //Mengambil detail data yang di upload
            $filename = $upload_data['file_name'];//Nama File
            $detail = $this->jadwal_phpexcel_model->upload_data_jadwal($filename, "20172", "A231");
            unlink('./assets/uploads/'.$filename);

			$messagestatus = $detail['messagestatus'];
			$message = $detail['message'];
			$parameter1 = $detail['parameter1'];
			$parameter2 = $detail['parameter2'];
			$parameter3 = $detail['parameter3'];
			$parameter4 = $detail['parameter4'];

			if ($messagestatus == "detail"){
				//echo $message;
				$data['message'] = $message;
				$this->load->view('temp/head');
				$this->load->view('ademik/report_aplikasi/report_excel', $data);
				$this->load->view('temp/footers');
			} else {
				$this->rediralert($messagestatus, $message, $parameter1, $parameter2, $parameter3, $parameter4);
			}

            //redirect('php_excel/import/success','refresh');
        }
    }

	public function export_excel(){
        //membuat objek
        $objPHPExcel = new PHPExcel();
        $data = $this->db->get($this->nama_tabel);

        // Nama Field Baris Pertama
        $fields = $data->list_fields();
        $col = 0;
		foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }

        // Mengambil Data
        $row = 2;
        foreach($data->result() as $data)
        {
            $col = 0;
            foreach ($fields as $field)
			{
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }

            $row++;
        }
        $objPHPExcel->setActiveSheetIndex(0);

        //Set Title
        $objPHPExcel->getActiveSheet()->setTitle('Data Absen');

        //Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        //Header
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        //Nama File
        header('Content-Disposition: attachment;filename="absen.xlsx"');

       //Download
        $objWriter->save("php://output");

    }

	private function update_jadwal_feeder($IDJadwal, $tbl){ // proses sendiri

		$feeder = $this->feeder->getToken_feeder();
		$temp_token = $feeder['temp_token'];
		$temp_proxy = $feeder['temp_proxy'];

		$qkm = $this->db->query("select jr.id_sms, j.Tahun as id_smt, m.id_mk, left(j.Keterangan,4) as nm_kls, j.SKS as sks_mk, j.IDJADWAL from _v2_jadwal j, _v2_jurusan jr, _v2_matakuliah m where m.IDMK=j.IDMK and j.KodeJurusan= jr.Kode and j.IDJadwal like '$IDJadwal' limit 1")->row();

		$IDJADWAL = $qkm->IDJADWAL;
		$prodi = $qkm->id_sms;
		$id_mk = $qkm->id_mk;
		$tahun = $qkm->id_smt;
		$nm_kls = $qkm->nm_kls;
		$SKS = $qkm->sks_mk;

		if($SKS =='2.0') $SKS  = "2";
		else if($SKS =='3.0') $SKS  = "3";
		else if($SKS =='4.0') $SKS  = "4";
		else if($SKS =='5.0') $SKS  = "5";
		else if($SKS =='6.0') $SKS  = "6";
		else if($SKS =='1.0') $SKS  = "1";
		else if($SKS =='1.5') $SKS  = "2";
		else if($SKS =='2.5') $SKS  = "3";
		else if($SKS =='3.5') $SKS  = "4";

		$record = new stdClass();
		$record->id_sms = $prodi;
		$record->id_smt = $tahun;
		$record->id_mk = $id_mk;
		$record->nm_kls = $nm_kls;
		$record->sks_mk = $SKS;
		$record->sks_tm = "0";
		$record->sks_prak = "0";

		$record->sks_prak_lap = "0";
		$record->sks_sim = "0";

		$record->a_selenggara_pditt = "0";
		$record->kuota_pditt = "0";
		$record->a_pengguna_pditt = "0";

		$table = 'kelas_kuliah';

		$action = 'InsertRecord';

		$datb = $this->feeder->action_feeder($temp_token,$temp_proxy,$action,$table,$record);

		$id_kls = $datb['id_kls'];
		$error_code = $datb['error_code'];
		$error_desc = $datb['error_desc'];

		if($id_kls != null){
			$qupdate = "update _v2_jadwal set id_kelas_kuliah='$id_kls',st_feeder=2 where IDJADWAL='$IDJADWAL'";
			$this->db->query($qupdate);
			return "dan Jadwal Berhasil di Kirim Ke Feeder";
		}else if($error_code=='700'){ // Data kelas ini sudah ada == $error_status['700']
			$action = "GetRecord";
			$table = "kelas_kuliah.raw";
			$record = "id_smt ilike '$tahun' and id_sms='$prodi' and id_mk='$id_mk' and nm_kls='$nm_kls'";
			$datb = $this->feeder->action_feeder_getRecord($temp_token,$temp_proxy,$action,$table,$record);
			//var_dump($resultup);
			$id_kls = $datb['id_kls'];
			$qupdate = "update _v2_jadwal set id_kelas_kuliah='$id_kls' ,st_feeder=-2 where IDJADWAL='$IDJADWAL'";
			$this->db->query($qupdate);
			return "dan Jadwal di Feeder Berhasil di Update";
		} else {
			return "dan Gagal ke Feeder : Message $id_kls - $error_code - $error_desc";
		}
	}

	public function update_jadwal_feeder_lewat_proses(){ // proses sendiri

		$a = $this->db->query("select * from _v2_jadwal where Tahun='20182' and KodeFakultas NOT IN ('B','G','L','O','N') and id_kelas_kuliah is NULL limit 100")->result();

		foreach($a as $val){
			$IDJadwal = $val->IDJADWAL;

			//$IDJadwal = "K2MF11120182F02171053REGA";

			// mendapatkan token
			$feeder = $this->feeder->getToken_feeder();
			$temp_token = $feeder['temp_token'];
			$temp_proxy = $feeder['temp_proxy'];

			// tabel krs siakad
			$tbl = '_v2_krs20182';

			//query jadwal,mahasiswa,krs di siakad
			$qkm = $this->db->query("select jr.id_sms, j.Tahun as id_smt, m.id_mk, left(j.Keterangan,4) as nm_kls, j.SKS as sks_mk, j.IDJADWAL from _v2_jadwal j, _v2_jurusan jr, _v2_matakuliah m where m.IDMK=j.IDMK and j.KodeJurusan= jr.Kode and j.IDJadwal like '$IDJadwal' limit 1")->row();

			if ($qkm){

				// pendeklarasian variabel

				$IDJADWAL = $qkm->IDJADWAL;
				$prodi = $qkm->id_sms;
				$id_mk = $qkm->id_mk;
				$tahun = $qkm->id_smt;
				$nm_kls = $qkm->nm_kls;
				$SKS = $qkm->sks_mk;

				if($SKS =='2.0') $SKS  = "2";
				else if($SKS =='3.0') $SKS  = "3";
				else if($SKS =='4.0') $SKS  = "4";
				else if($SKS =='5.0') $SKS  = "5";
				else if($SKS =='6.0') $SKS  = "6";
				else if($SKS =='1.0') $SKS  = "1";
				else if($SKS =='1.5') $SKS  = "2";
				else if($SKS =='2.5') $SKS  = "3";
				else if($SKS =='3.5') $SKS  = "4";

				// pendeklarasi variabel class
				$record = new stdClass();
				$record->id_sms = $prodi;
				$record->id_smt = $tahun;
				$record->id_mk = $id_mk;
				$record->nm_kls = $nm_kls;
				$record->sks_mk = $SKS;
				$record->sks_tm = "0";
				$record->sks_prak = "0";

				$record->sks_prak_lap = "0";  //$w['sks_prak_lap'];
				$record->sks_sim = "0";  //$w['sks_sim'];

				$record->a_selenggara_pditt = "0";
				$record->kuota_pditt = "0";
				$record->a_pengguna_pditt = "0";

				// tabel pada feeder
				$table = 'kelas_kuliah';

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

				echo json_encode($datb)." - ".$IDJADWAL."<br>";

				$id_kls = $datb['id_kls'];
				$error_code = $datb['error_code'];
				$error_desc = $datb['error_desc'];

				if($id_kls != null){
					$qupdate = "update _v2_jadwal set id_kelas_kuliah='$id_kls',st_feeder=2 where IDJADWAL='$IDJADWAL'";
					$this->db->query($qupdate);
					echo $qupdate;
				}else if($error_code=='700'){ // Data kelas ini sudah ada == $error_status['700']
					$action = "GetRecord";
					$table = "kelas_kuliah.raw";
					$record = "id_smt ilike '$tahun' and id_sms='$prodi' and id_mk='$id_mk' and nm_kls='$nm_kls'";
					$datb = $this->feeder->action_feeder_getRecord($temp_token,$temp_proxy,$action,$table,$record);
					//var_dump($resultup);
					$id_kls = $datb['id_kls'];
					$qupdate = "update _v2_jadwal set id_kelas_kuliah='$id_kls' ,st_feeder=-2 where IDJADWAL='$IDJADWAL'";
					$this->db->query($qupdate);
				} else{
					$id_kls = "id kelas kosong";
				}

				echo "$id_kls - $error_code - $error_desc";

			} else {
				echo "data kosong - $IDJadwal";
			}
			
		}



	}

	/*function Fandu1 () {

			//$thn = $this->input->post('tahun');
			$thn = "20172";

			//$kdj = $this->input->post('kdj');
			$kdj = "A231";

			$md = 1; // insert jadwal

			$IDMK = $this->input->post('IDMK'); //
			$Program = $this->input->post('Program');
			$KodeRuang = $this->input->post('KodeRuang');
			$Hari = $this->input->post('Hari');
			$jm = $this->input->post('JamMulai');
			$js = $this->input->post('JamSelesai');
			$Rencana = $this->input->post('Rencana');
			$Realisasi = $this->input->post('Realisasi');
			$Keterangan = $this->input->post('Keterangan');
			$Ket = $this->input->post('ket'); // ket -- terimput di field kelas
			$IDPAKET = $this->input->post('IDPAKET');
			$IDJADWAL = $this->input->post('IDJADWAL');
			$IDDosen = $this->input->post('dosenpengampu');
			$kaps = $this->input->post('kaps');

			// buka untuk pada menu tambah jadwal //
			$optmk1  = $this->app->two_val("_v2_kurikulum", "KodeJurusan", $kdj, "NotActive", "N")->row(); // mengambil kurikulum id
			$kurid = $optmk1->IdKurikulum; // hasil kurikulum id

			$kdfakultas  = $this->app->two_val("_v2_jurusan", "Kode", $kdj, "NotActive", "N")->row();
			$kodefakul = $kdfakultas->KodeFakultas;
			// tes

			$thnaktif = $this->Jadwal->isTahunAktif($thn, $kdj);

			if (!$thnaktif) {
				$this->rediralert("warning", "Semester Akademik Tidak Terdaftar Silahkan Hubungi Fakultas Anda Untuk Pembukaan Semester Akademik", "", "", "", "");
			} else {
				$kdf = $this->Jadwal->GetaField('KodeFakultas','_v2_jurusan', 'Kode', $kdj);

				$Terjadwal = 'Y';

				$arrmk1  = $this->app->GetField("*", "_v2_matakuliah", "KurikulumID='$kurid' and id_mk != ''", "and IDMK='$IDMK'");

				foreach ($arrmk1->result() as $arrmk){
					$KDMK = $arrmk->Kode;
					$id_mk =  $arrmk->id_mk;
					$SKS = $arrmk->SKS;
					$Nama_Indonesia = $arrmk->Nama_Indonesia;
				}

				//$KodeKampus  = $this->app->two_val_option("KodeKampus", "_v2_ruang", "KodeKampus like '$kodefakul' and Kode='fdsfds' ");
				$KodeKampus1  = $this->app->two_val("_v2_ruang", "KodeKampus", $kodefakul, "Kode", $KodeRuang)->row();
				$KodeKampus = $KodeKampus1->KodeFakultas;

				$jam2awal=substr("$jm",0,2);

				$unip = $this->session->userdata('unip');

				$jid = $IDJADWAL;

				$Tanggalskrg=date("Y-m-d H:i:s");
				$TmStamp=strtotime($Tanggalskrg);

				if (empty($IDJADWAL)) { // kondisi saat penginputan baru jadwal
					$SqIdJd = "select max(right(IDJADWAL,10)) as maxid from _v2_jadwal where KodeJurusan like '$kdf%'";
					$IdJdMax = $this->db->query($SqIdJd)->row()->maxid;

					if(empty($IdJdMax)) {
						$IdTstamp=$TmStamp;
					} else {
						$IdTstamp=$KDMK.$Program.$Keterangan.str_replace(' ', '', $Ket);
					}

					$IDJADWALBr = "$kdj"."$thn"."$IdTstamp";
				} else { // kondisi saat mengedit jadwal
					$IDJADWALBr = "$IDJADWAL";
				}

				$cekidjadwal = "select IDJADWAL from _v2_jadwal where IDJadwal='$IDJADWALBr'";

				$residjadwal = $this->db->query($cekidjadwal)->num_rows();
				if ($residjadwal == 0 or $md == 2) { // apakah IDJADWAL sudah pernah terinput
					$cekruangan = $this->jadwal_phpexcel_model->CheckRuang($thn, $jid, $KodeKampus, $KodeRuang, $Hari, $jm, $js);
					$oke = $cekruangan['status'];
					if ($oke) {
						if ($md == 2) { // edit
							$s = "update _v2_jadwal set IDMK='$IDMK', KodeMK='$KDMK', SKS='$SKS',NamaMK='$Nama_Indonesia', Terjadwal='$Terjadwal',
							  Program='$Program', Hari='$Hari', JamMulai='$jm', JamSelesai='$js',
							  KodeKampus='$KodeKampus', KodeRuang='$KodeRuang', Rencana='$Rencana', Realisasi='$Realisasi',Keterangan='$Keterangan',Kelas='$Ket',IDPAKET='$IDPAKET', IDDosen='$IDDosen', kap='$kaps'
							  where IDJADWAL='$jid'";
							$stat = "Berhasil di Rubah";
						} elseif ($md == 1) { // tambah baru

							$kaps = $this->jadwal_phpexcel_model->CekKapasitas($KodeRuang);

							if($kaps<=0) $kaps=30;

							$s = "insert into _v2_jadwal (id_mk,IDJADWAL,Tahun, Terjadwal, KodeFakultas, KodeJurusan, IDMK, KodeMK, NamaMK,
							  SKS, Program, Hari,
							  JamMulai, JamSelesai, KodeKampus, KodeRuang,kap, unip, Tanggal, Rencana, Realisasi,Keterangan,Kelas,IDPAKET,IDDosen)
							  values ('$id_mk','$IDJADWALBr', '$thn', '$Terjadwal', '$kdf', '$kdj', '$IDMK', '$KDMK', '$Nama_Indonesia',
							  '$SKS', '$Program', '$Hari', '$jm',
							  '$js', '$KodeKampus', '$KodeRuang',$kaps, '$unip', '$Tanggalskrg', '$Rencana', '$Realisasi','$Keterangan','$Ket','$IDPAKET','$IDDosen')";

							$stat = "Berhasil Terinput";
						}
						echo $s;
						//$r = $this->db->query($s);

						// insert assisten dosen
						/-*$dosenlainnya = $this->input->post('dosenlainnya');

						foreach( $dosenlainnya as $n ){
							if (!empty($n)){
								$cek = "select * from _v2_jadwalassdsn where IDJadwal='$IDJADWALBr' and IDDosen='$n'";

								$hm = $this->db->query($cek)->num_rows();
								if ($hm == 0) {
									$ins_assdsn = "insert into _v2_jadwalassdsn (IDJadwal, IDDosen, NotActive) values('$IDJADWALBr', '$n', 'N')";
									$this->db->query($ins_assdsn);
								}
							}
						}
						$statalert = "success";*-/
					} else {
						$stat = $cekruangan['display'];
						$statalert = "error";
					}

					$this->rediralert("$statalert", "Matakuliah $Nama_Indonesia $stat", "list", $thn, $Program, $kdj);

				} else {

					$this->rediralert("error", "Matakuliah $Nama_Indonesia Sudah Pernah di Input", "list", $thn, $Program, $kdj); // list pada parameter ke tiga untuk mengembalikan nilai balik pada list jadwal

				}
			}
	}*/

	/*function Fandu () {
		return array(
			"status" => "true",
			"display" => "cek tes 1"
		);
	}*/

	private function fandu_jadwal(){
		$thn = "20181";
		$kdp = "REG";
		$kdj = "C101";

		$ulevel = $this->session->userdata('ulevel');
		$prn = 0; // fandu disable // Masuk ke kondisi tekan tombol refresh
		$sid = 1; // fandu disable // TIDAK BERGUNA/ HANYA UNTUK URL

		//cek rule siakad
		$sessionjurusan = $this->session->userdata('kdj');
		$sessionfakultas = $this->session->userdata('kdf');
		$sessionunip = $this->session->userdata('unip');

		if ($ulevel == 7){
			$this->db->from('_v2_rule_siakad');
			$this->db->where('ulevel',$ulevel);
			$this->db->where('user',$sessionunip);
			$this->db->where('Kodejurusan',$sessionjurusan);
			$this->db->where('Kodefakultas',$sessionfakultas);
			$this->db->where('form', 'jdwlkuliah1');
			$this->db->where('status_user', 'A');
			$hasil = $this->db->get();
			$status = $hasil->row();
		} else if ($ulevel == 5) {
			$this->db->from('_v2_rule_siakad');
			$this->db->where('ulevel',$ulevel);
			$this->db->where('user',$sessionunip);
			$this->db->where('Kodefakultas',$sessionfakultas);
			$this->db->where('form', 'jdwlkuliah1');
			$this->db->where('status_user', 'A');
			$hasil = $this->db->get();
			$status = $hasil->row();
		}

		//echo "---- ".$ulevel." ------";

		//$count = $hasil->num_rows();

		// kondisi untuk admin jurusan == point 2 untuk input nilai
		if(($hasil->num_rows() == 0) and ($ulevel == 7)){ //  or $ulevel == 5
			// kondisi jika tidak ada di rule, maka akan tampil
			$result = true; // bisa menginput nilai
		} else if (($hasil->num_rows() > 0) and ($ulevel == 7 or $ulevel == 5)) {
			if ($status->user == $sessionunip and ($status->Kodefakultas == $sessionfakultas or $status->Kodejurusan == $sessionjurusan) and $status->point_2 == 1 and ($ulevel == 7 or $ulevel == 5)){
				// kondisi jika ada di rule, denagan kondisi di atas maka akan tampil
				$result = true; // bisa menginput nilai
			} else if ($status->user == $sessionunip and ($status->Kodefakultas == $sessionfakultas or $status->Kodejurusan == $sessionjurusan) and $status->point_2 == 0 and ($ulevel == 7 or $ulevel == 5)){
				// tidak tampil
				$result =false; // tidak bisa menginput nilai
			}
		} else if ($ulevel == 1) {
			$result = true; // bisa menginput nilai untuk adminsuperuser
		} else {
			$result =false; // tidak bisa menginput nilai
		}

		echo $result;
		echo "<br> (".$status->user."== $sessionunip and (".$status->Kodefakultas." == $sessionfakultas or ".$status->Kodejurusan." == $sessionjurusan) and ".$status->point_2." == 0 and ($ulevel == 7 or $ulevel == 5)) result fandu tes $ulevel - $sessionunip - $sessionjurusan - $sessionfakultas = ".$hasil->num_rows()."<br>";
		//echo ($status->user == $sessionunip and ($status->Kodefakultas == $sessionfakultas or $status->Kodejurusan == $sessionjurusan) and $status->point_2 == 1 and ($ulevel == 7 or $ulevel == 5));
		//echo ($status->user == $sessionunip and ($status->Kodefakultas == $sessionfakultas or $status->Kodejurusan == $sessionjurusan) and $status->point_2 == 0 and ($ulevel == 7 or $ulevel == 5));
	}

	/*function daftarmhsnil_fandu() {
		$idjadwal = "C30120181EKA5802REGAAk";
		$thn = "20181";

		$daftar = $this->daftar_mhsw($idjadwal,$thn,"");

		$string = "";
		$nopeserta = 1;
		$tahunakademik = 1;
		$buttonoptions = "";

		foreach ($daftar as $row){

			if (($row->st_feeder == 3) or ($row->st_feeder == 4)){
				echo $row->NIM." row ".$nopeserta."<br>";
			} else {

					if (($tahunakademik == 1) or ($tahunakademik != $row->TahunAkademik)){
						$buttonoptions = "";

						$buttonoptions = "tes 123 $nopeserta <br>"; // 1 // 1

					} else {
						$buttonoptions = "tes 123 $nopeserta <br>";
					}

					$tahunakademik = $row->TahunAkademik;


			}

			$nopeserta++; // 2

			echo $row->NIM." options ".$buttonoptions."<br>"; // 1  // 1

		}
	}*/

	//mendapatkan detail biodata dosen dengan id_dosen
	public function id_reg_dosen_detailbiodatadosen(){

		$Filter = "id_dosen='bae06faf-c9bf-44ab-a3fe-e830feec1c16'";

		$result = $this->feeder->id_reg_dosen_detailbiodatadosen($Filter);

		echo "$result<br>";

	}

	//Insert Pengajar Dosen Kelas Kuliah di feeder
	public function InsertDosenPengajarKelasKuliah(){

		$thn = $this->input->post('tahunakademik');
		$kdj = $this->input->post('jurusan');
		$kdp = $this->input->post('program');
		$actval_idjadwal = $this->input->post("actval");
		$jenis_dosen = $this->input->post("jenis_dosen");

		if($jenis_dosen == 1){ // untuk dosen pengampu
			$join = "left join _v2_dosen d on jd.IDDosen=d.nip";
		} else if ($jenis_dosen == 2) { // untuk dosen lainnya
			$join = "inner join _v2_jadwalassdsn jds on jd.IDJADWAL=jds.IDJadwal left join _v2_dosen d on jds.IDDosen=d.nip";
		}

		$s = "SELECT d.id_reg_ptk, d.nip, jd.id_kelas_kuliah, jd.SKS, jd.Rencana, jd.Realisasi
		FROM _v2_jadwal jd $join
		WHERE jd.IDJADWAL = '$actval_idjadwal' AND jd.Tahun = '$thn' AND
		jd.KodeJurusan = '$kdj' AND jd.Program = '$kdp'";

		$r = $this->db->query($s)->result();

		foreach ($r as $val){

			$filter = array(
				'id_registrasi_dosen' => $val->id_reg_ptk,
				'id_kelas_kuliah' => $val->id_kelas_kuliah,
				'sks_substansi_total' => substr($val->SKS, 0, -2),
				'rencana_tatap_muka' => $val->Rencana,
				'realisasi_tatap_muka' => $val->Realisasi,
				'id_jenis_evaluasi' => '1'
			);

			$result = $this->feeder->insertfeeder("InsertDosenPengajarKelasKuliah", $filter);
			//echo "$result<br>";
			$obj = json_decode($result);

			$error_code = $obj->{'error_code'}; // mendapatkan error code

			if ($error_code == 0){

				$id_aktivitas_mengajar = $obj->{'data'}->{'id_aktivitas_mengajar'};

				if($jenis_dosen == 1){ // untuk dosen pengampu

					$table = "_v2_jadwal";

					$data = array(
						'id_ajar_p' => $id_aktivitas_mengajar
					);

					$where = array(
						'IDJADWAL' => $actval_idjadwal,
						'Tahun' => $thn,
						'KodeJurusan' => $kdj,
						'Program' => $kdp,
					);

				} else if ($jenis_dosen == 2) { // untuk dosen lainnya

					$table = "_v2_jadwalassdsn";

					$data = array(
						'id_ajar' => $id_aktivitas_mengajar
					);

					$where = array(
						'IDJADWAL' => $actval_idjadwal,
						'IDDosen' => $val->nip
					);

				}

				$this->db->where($where);
				$this->db->update($table,$data);

				echo $result;

			} else {
				echo $result;
			}

		}

		//{error_code: 920, error_desc: "Dosen mengajar dari id_registrasi_dosen dan id_kelas_kuliah ini sudah ada", data: ""}
		//{error_code: "0", error_desc: "", data: { id_aktivitas_mengajar: "e8788db6-f6a5-4b08-84a0-21ed4c1c218d" }}


		/*id_registrasi_dosen=3e8cfad7-1f3c-4f2a-b8d7-0fe0c86f98d1
		id_kelas_kuliah=85181c97-b4e3-41ff-9c1f-3364c7bcfa0d
		id_substansi
		sks_total=20
		rencana_tatap_muka=16
		realisasi_tatap_muka=16
		id_jenis_evaluasi=1

		$filter = array(
			'id_registrasi_dosen' => 'bbe897c1-3997-4008-8c98-90ba40110a38',
			'id_kelas_kuliah' => 'ea43f5af-b0d8-4228-a473-7b93df63c87f',
			'sks_substansi_total' => '2',
			'rencana_tatap_muka' => '15',
			'realisasi_tatap_muka' => '13',
			'id_jenis_evaluasi' => '1'
		);

		$result = $this->feeder->insertfeeder("InsertDosenPengajarKelasKuliah", $filter);
		//echo "$result<br>";
		echo json_encode($result);

		*/

	}

	//Cek ID AKtivitas Mengajar Dosen Kelas Kuliah di feeder
	public function cekdatafeeder(){

		//$filter = "id_aktivitas_mengajar='3cab95c6-3e0b-4ca6-9607-af043126da3a'";
		$filter = "id_kelas_kuliah='d2838ff4-650f-4191-a2eb-4ae4a7a0a79c'";

		// $filter = array (
		//  	'id_kelas_kuliah' => 'd2838ff4-650f-4191-a2eb-4ae4a7a0a79c'
		// );

		//$filter = "id_kelas_kuliah='d2838ff4-650f-4191-a2eb-4ae4a7a0a79c'&id_registrasi_dosen='0939b3e6-e68b-4c45-9a8b-bc92fa05a451'";

		$result = $this->feeder->cekdatafeeder("GetDosenPengajarKelasKuliah", $filter);

		echo $result;

	}

	// Cek Ke Feeder ID Kelas Kuliah yang Terkirim ke Feeder
	public function report_cekdatafeeder($idjadwal, $tahun){

		//$idjadwal = "L13120182L01161018REGC";
		//$tahun = "20182";

		/*$this->db->select("IDJADWAL, IDDosen, id_ajar_p as id_ajar");
    $this->db->distinct();
    $this->db->from("_v2_jadwal");
    $this->db->where_in("IDJADWAL",$idjadwal);
    $this->db->get();
    $query1 = $this->db->last_query();

    $this->db->select("IDJadwal, IDDosen, id_ajar");
    $this->db->distinct();
    $this->db->from("_v2_jadwalassdsn");
    $this->db->where_in("IDJadwal",$idjadwal);

    $this->db->get();
    $query2 =  $this->db->last_query();
    $query = $this->db->query($query1." UNION ".$query2);

    foreach ($query->result() as $row){
			//echo "<br>".$row->IDJADWAL." - ".$row->IDDosen." - ".$row->id_ajar;
			$filter = "id_aktivitas_mengajar='".$row->id_ajar."'";

			$result = $this->feeder->cekdatafeeder("GetDosenPengajarKelasKuliah", $filter);

			echo $result;
		}*/

		$this->db->from('_v2_jadwal');
		$this->db->where('IDJADWAL', $idjadwal);
		$this->db->where('Tahun', $tahun);
		$hasil = $this->db->get();
		$status = $hasil->row();

		$filter = "id_kelas_kuliah='".$status->id_kelas_kuliah."'";

		$result = $this->feeder->cekdatafeeder("GetListKelasKuliah", $filter);

		//echo "$result<br>";
		$obj = json_decode($result);

		$error_code = $obj->{'error_code'}; // mendapatkan error code

		if ($error_code == 0){

			$nama_dosen = $obj->{'data'};

			foreach ($nama_dosen as $row){

				$data['nama_program_studi'] = $row->nama_program_studi;
				$data['id_semester'] = $row->id_semester;
				$data['nama_semester'] = $row->nama_semester;
				$data['kode_mata_kuliah'] = $row->kode_mata_kuliah;
				$data['nama_mata_kuliah'] = $row->nama_mata_kuliah;
				$data['nama_kelas_kuliah'] = $row->nama_kelas_kuliah;
				$data['sks'] = $row->sks;
				$data['nama_dosen'] = explode(",", substr($row->nama_dosen, 0, -1));
				$data['jumlah_mahasiswa'] = $row->jumlah_mahasiswa;

			}

			$this->load->view('temp/head');
			$this->load->view('ademik/report_aplikasi/report_feeder', $data);
			$this->load->view('temp/footers');

		} else {
			echo $result;
		}


		/*$filter = "id_kelas_kuliah='d2838ff4-650f-4191-a2eb-4ae4a7a0a79c'";

		$result = $this->feeder->cekdatafeeder("GetListKelasKuliah", $filter);

		echo $result;*/

	 // if(!isset($_POST['runimport'])) {
		//  redirect(base_url($this->session->userdata('sess_tamplate')));
	 // }
	 //
		// 	 $config['upload_path'] = './assets/uploads/';
		// 	 $config['allowed_types'] = 'xlsx|xls';
	 //
		// 	 $this->load->library('upload', $config);
	 //
		// 	 if ( ! $this->upload->do_upload()){
	 //
		// 			 $error = array('error' => $this->upload->display_errors());
		//  		 	echo var_dump($error);
		// 	 } else {
		// 			 $data = array('upload_data' => $this->upload->data());
		// 			 $upload_data = $this->upload->data(); //Mengambil detail data yang di upload
		// 			 $filename = $upload_data['file_name'];//Nama File
		// 			 $detail = $this->jadwal_phpexcel_model->upload_data_jadwal($filename, "20172", "A231");
		// 			 unlink('./assets/uploads/'.$filename);
	 //
		// 			 $messagestatus = $detail['messagestatus'];
		// 			 $message = $detail['message'];
		// 			 $parameter1 = $detail['parameter1'];
		// 			 $parameter2 = $detail['parameter2'];
		// 			 $parameter3 = $detail['parameter3'];
		// 			 $parameter4 = $detail['parameter4'];
	 //
		// 			 if ($messagestatus == "detail"){
		// 				 //echo $message;
		// 				 $data['message'] = $message;
		// 				 $this->load->view('temp/head');
		// 				 $this->load->view('ademik/report_aplikasi/report_feeder', $data);
		// 				 $this->load->view('temp/footers');
		// 			 } else {
		// 				 $this->rediralert($messagestatus, $message, $parameter1, $parameter2, $parameter3, $parameter4);
		// 			 }
	 //
		// 	 }
	 }

	 function cek_enkripsi(){

		/*$krsEncrypt = "165dde225327aa1f701e29e0cd708d63a323e908c5cf647b6f9d628655512539d44087e13d249c03921593a45ce5b4004e10d2e6876f029a1371d25a6a9ed056URaa4RhvY9PL5KNugwjfJCc27aVpZURN8N+6iop1NG8GZlz8m58gL8h0taHTW6eFyzopZgkVsl/8izytdOTMaw==";
		$dataDecrypt = $this->encryption->decrypt($krsEncrypt);

		$decrypt=explode('|', $dataDecrypt);
	
		echo $decrypt[0]." - ".$decrypt[1]." - ".$decrypt[2]." - ".$decrypt[3]." - ".$decrypt[4];*/

		$tahun = "20182";
		$idjadwal = "D10120182U00131007REGG";

		$hasil = $this->db->query("SELECT n.ID, n.NIM, n.Tahun, n.nilai, n.GradeNilai, n.Bobot, n.KodeMK, n.enkripsi, j.id_kelas_kuliah, j.IDJADWAL, m.id_reg_pd FROM _v2_krs$tahun n left join _v2_jadwal j on n.IDJadwal=j.IDJADWAL left join _v2_mhsw m on n.NIM=m.NIM  WHERE n.Tahun = '$tahun' AND (n.st_feeder = 0 or n.st_feeder = 5 or n.st_feeder = -3) AND n.IDJadwal LIKE '$idjadwal' AND n.GradeNilai != ''");

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

			if($tahun >= 20182){
				$krsEncrypt = $show->enkripsi;
				$dataDecrypt = $this->encryption->decrypt($krsEncrypt);

				$decrypt=explode('|', $dataDecrypt);
			}

			if(($tahun <= 20181) or ($decrypt[0]==strtoupper($NIM) AND $decrypt[1]==$idjadwal AND $decrypt[2]==$tahun AND $decrypt[3]==$nilai_huruf AND $decrypt[4]==$nil_indeks)){
				echo "masuk - ".$decrypt[0]." - ".$decrypt[1]." - ".$decrypt[2]." - ".$decrypt[3]." - ".$decrypt[4];
			} else {
				echo "gagal - ($tahun <= 20181) or (".$decrypt[0]."==$NIM AND ".$decrypt[1]."==$idjadwal AND ".$decrypt[2]."==$tahun AND ".$decrypt[3]."==$nilai_huruf AND ".$decrypt[4]."==$nil_indeks))";
			}
		}
	
	 }

	public function GetMhsw($IDJADWAL='')
	{
		if ($this->input->post('IDJADWAL')) {
			$IDJADWAL = $this->input->post('IDJADWAL');
		}
		if ($IDJADWAL) {
			# code...
			$wjadwal2 = array('IDJADWAL'=>$IDJADWAL);

			$jadwal2 = $this->db->select("Tahun,IDJadwal,Program,KodeJurusan,KodeMK,IDMK,NamaMK,Keterangan")
													->get_where('_v2_jadwal',$wjadwal2)
													->result_array();

			$res['data']['siakad2'] = $jadwal2;
			// $jadwal1[1] = 'oke';
			$res=array();
			if (count($jadwal2)==1) {
				if ($this->input->post('jdwlold')) {
					$jadwal1[0] = array(
						'Tahun'	=> $this->input->post('thnakdmk'),
						'IDJadwal'	=> $this->input->post('jdwlold')
					);
				}else{
					$jadwal1 = $this->getFromSiakad1($jadwal2[0]);
				}

				$res['data']['siakad1'] = $jadwal1;

				if (count($jadwal1)==1) {
					$res['update'] = $this->upKrsMhsw(
						$jadwal1[0]['Tahun'],
						array(
							'IDJadwal'=>$jadwal2[0]['IDJadwal'],
							'KodeMK'=>$jadwal2[0]['KodeMK'],
							'IDMK'=>$jadwal2[0]['IDMK']),
						array('IDJadwal'=>$jadwal1[0]['IDJadwal'],'Tahun'=>$jadwal2[0]['Tahun'])
					);
					$res['dump']['set']		=array('IDJadwal'=>$jadwal2[0]['IDJadwal'],'KodeMK'=>$jadwal2[0]['KodeMK'],'IDMK'=>$jadwal2[0]['IDMK']);
					$res['dump']['where']	=array('IDJadwal'=>$jadwal1[0]['IDJadwal'],'Tahun'=>$jadwal2[0]['Tahun']);
				}elseif (count($jadwal1)>=2) {
					$res['update'] = 0;
				}else{
					$res['data']['siakad2'] = $jadwal2;
					$res['update'] = 0;
				}
			}elseif (count($jadwal2)>=2) {
				$res['data']['siakad1'] = array();
				$res['data']['siakad2'] = array();
				$res['update'] = 0;
			}else{
				$res['data']['siakad1'] = array();
				$res['data']['siakad2'] = array();
				$res['update'] = 0;
			}
			echo json_encode($res);
		}
	}
	private function getFromSiakad1($wjadwal)
	{
		$wjadwal1 = array(
			'Tahun' => $wjadwal['Tahun'],
			'KodeJurusan' => $wjadwal['KodeJurusan'],
			'NamaMK' => $wjadwal['NamaMK'],
			'Keterangan' => $wjadwal['Keterangan'] );

		if ($wjadwal['Program']=='NONREG') {
			$wjadwal1['Program']='RESO';
		}elseif ($wjadwal['Program']=='REG') {
			$wjadwal1['Program']='REG';
		}else{
		}
		$this->db1 = $this->load->database('siakad', TRUE);;
		return $this->db1->select("Tahun,IDJadwal,Program,KodeJurusan,KodeMK,IDMK,NamaMK,Keterangan")->where($wjadwal1)->get('jadwal')->result_array();
		// return $wjadwal1;
	}
	private function upKrsMhsw($tahunakademik,$set,$where)
	{
		$tabel = '_v2_krs'.$tahunakademik;
		return $this->db->set($set)->where($where)->update($tabel);
	}
	public function getMkKrs()
	{
		$nim = $this->input->post('NIM');
		$tahunakademik = $this->input->post('tahunakademik');
		$tabel = '_v2_krs'.$tahunakademik;
		$krs	= array();
		if ($tahunakademik && $nim ) {
			$where = array(
				'NIM'		=> $nim,
				'Tahun'	=> $tahunakademik
			);
			$krs = $this->db->select("`IDJadwal`,`KodeMK`,`IDMK`,`SKS`,`NamaMK`")
											->where($where)
											->get($tabel)->result();
			
		}
		echo json_encode($krs);
	}

	

	function coba() {
		//$idjadwal = "C30120181EKA5802REGAAk";
		//$thn = "20181";

		

		$idjadwal 		= decode('O12120192O01171004REGInt-Class');
		echo encode($idjadwal);
	}

}
