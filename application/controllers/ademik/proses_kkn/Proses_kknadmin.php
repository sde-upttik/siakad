<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proses_kknadmin extends CI_Controller {

	function __construct(){
		parent::__construct();
	    $this->load->model('Kkn_modeladmin');
	    if ($this->session->userdata("unip") == null) {
				redirect("https://siakad2.untad.ac.id");
			}
	}

	public function index(){

		$a['tab'] = $this->app->all_val('groupmodul')->result();
		$this->load->view('dashbord',$a);
	}

/*	public function tes(){
		$tes=$this->Kkn_modeladmin->tes('')
	}*/

	public function prckkn()
	{
		$ulevel 		= $this->session->ulevel;
		$nim 			= $_SESSION['nim']= $this->input->post('nimkkn');
		$thn 			= $_SESSION['thn']= "20201";
		$tbl 			= $_SESSION['tbl']= "_v2_krs20201";
		$angkatan_kkn 	= $_SESSION['angkatan_kkn']= "91";

		$qMhswKkn		= $_SESSION['qMhswKkn']= $this->Kkn_modeladmin->getMhswKkn($nim);

		//$id = $qMhswKkn->ID;
		$nama = $qMhswKkn->nm;
		$login = $qMhswKkn->Login;
		$password = $qMhswKkn->Password;
		//$namamk = $qMhswKkn->NamaMK;
		$kdfak = $qMhswKkn->kdfak;
		$fak = $qMhswKkn->nmindo;	
		$singkatan = $qMhswKkn->Singkatan;	
		$kdprodi = $qMhswKkn->kdjur;	
		$j = $qMhswKkn->j;
		$sex = $qMhswKkn->sex;
		$phone = $qMhswKkn->p;
		$prog = $qMhswKkn->k;
		$t = $qMhswKkn->t;
		$ipk = $qMhswKkn->IPK;
		$tmp = $qMhswKkn->tmp;
		$almt1 = $qMhswKkn->almt1;
		$tahunakademik = $qMhswKkn->TahunAkademik;
		 
		 if ($kdfak == 'A') {
			$kodefakultas = "1";
		 } else if ($kdfak == 'B') {
			$kodefakultas = "2";
		 } else if ($kdfak == 'C') {
			$kodefakultas = "3";
		 } else if ($kdfak == 'D') {
			$kodefakultas = "4";
		 } else if ($kdfak == 'E') {
			$kodefakultas = "5";
		 } else if ($kdfak == 'F') {
			$kodefakultas = "6";
		 } else if ($kdfak == 'G') {
			$kodefakultas = "7";
		 } else if ($kdfak == 'H') {
			$kodefakultas = "8";
		 } else if ($kdfak == 'L') {
			$kodefakultas = "12";
		 } else if ($kdfak == 'N') {
			$kodefakultas = "14";
		 } else if ($kdfak == 'O') {
			$kodefakultas = "15";
		 } else if ($kdfak == 'P') {
			$kodefakultas = "16";
		 } else if ($kdfak == 'K2M') {
		 	if 		($kdprodi == 'K2MC201') {
		 		$kodefakultas = "3";
		 	}elseif ($kdprodi == 'K2ME281') {
		 		$kodefakultas = "5";
		 	}elseif ($kdprodi == 'K2MF111') {
		 		$kodefakultas = "6";
		 	}
			
		 } else if ($kdfak == 'K2T') {
			if 		($kdprodi == 'K2TC201') {
		 		$kodefakultas = "3";
		 	}elseif ($kdprodi == 'K2TE281') {
		 		$kodefakultas = "5";
		 	}elseif ($kdprodi == 'K2TF111') {
		 		$kodefakultas = "6";
		 	}

		 } else {
			$kodefakultas = "0";
		 }
		 
		 $nomorpembayaran = "$kodefakultas".substr($nim,1);
		 //pengecualian untuk thn akademik 2011-2013
		 // if(($t >= 100 or $tahunakademik == '2011' or $tahunakademik == '2012' or $tahunakademik == '2013') and ($ulevel=='4' or $ulevel=='1'))
		 if(($ulevel=='5' or $ulevel=='1'))
		 {
			$cektabkkn = $this->Kkn_modeladmin->cektabkkn($nim,$nama);

			$msg = "";
			if ($cektabkkn == 0){
				$nim = $this->Kkn_modeladmin->db->escape_str($nim);
				$ins="INSERT into tb_mahasiswa_kkn (id_mhs_kkn, nim, nama, alamat, jk, no_hp, kd_fakultas, kd_jurusan, kode_program, sks_lulus, IPK, user_name, password,id_group,periode_kkn,tahun_kkn,status_nikah,status,id_record_tagihan) values (null,'$nim','$nama','$almt1','$sex','$phone','$kdfak','$kdprodi','$prog','$t','$ipk','$login','$password','3','$angkatan_kkn','$thn','N','N','".$nim."KKN".$angkatan_kkn."')"; 
				
				$querytagihan = "INSERT INTO `tagihan` (`id_record_tagihan`, `kode_periode`, `nama_periode`, `is_tagihan_aktif`, `total_nilai_tagihan`, `nomor_pembayaran`, `kode_prodi`, `nama_prodi`, `strata`, `angkatan`, `waktu_berlaku`, `waktu_berakhir`, `nama`, `kode_fakultas`, `nama_fakultas`, `urutan_antrian`, `kode_bank`, `nomor_induk`) VALUES ('".$nim."KKN".$angkatan_kkn."', 'KKN', 'KKN Semester $thn', '1', '630000', '$nomorpembayaran', '$kdprodi', '$fak S1', 'S1', '$tahunakademik', '2020-08-03', '2020-09-08', '$nama', '$singkatan', '$singkatan', '1', 'BNI', '$nim')";

				$ins_querytagihan = $this->Kkn_modeladmin->insertTagihan($querytagihan);
				//$ins_querytagihan = true;
				
				$querydetil_tagihan = "INSERT INTO `detil_tagihan` (`id_record_detil_tagihan`, `id_record_tagihan`, `kode_jenis_biaya`, `label_jenis_biaya`, `urutan_detil_tagihan`, `label_jenis_biaya_panjang`, `nilai_tagihan`) VALUES ('".$nim."KKN".$angkatan_kkn."', '".$nim."KKN".$angkatan_kkn."', 'KKN', 'KKN', 1, 'KKN', '630000')";
				
				$ins_querydetil_tagihan = $this->Kkn_modeladmin->insertDetilTagihan($querydetil_tagihan);
				//$ins_querydetil_tagihan = true;
				
				if (($ins_querytagihan == true) and ($ins_querydetil_tagihan == true)){
							
							$msg 	= 	"Melakukan Pembayaran KKN ke Bank BNI Senilai Rp. 630.000. Silahkan download Pengantar ke BANK disini
										<form method='POST' action='".base_url()."ademik/report/Report/cetak_bayar_kkn'>
											<input type='hidden' name='nama' value='$nama'>
											<input type='hidden' name='nim' value='$nim'>
											<button style='margin-right: 5px;' type='submit' class='btn btn btn-default fa fa-print'> Cetak Bukti Pembayaran</button>
										</form>";
				}
			} else {
				$ins="UPDATE tb_mahasiswa_kkn set sks_lulus='$t',id_group='3', status_nikah='N',status='N' where nim='$nim'and nama='$nama'";
			}

			$insertKkn= $this->Kkn_modeladmin->insertKkn($ins);
			if ($insertKkn){
				$pesan =  "<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>~</button>
						<strong>Sukses!</strong> Data Berhasil Terkirim, Silahkan <br> $msg <br>Kemudian Login Ke Aplikasi kkn.untad.ac.id
						</div>";

				$getJadwal = "select * from _v2_jadwal where Tahun='$thn' and KodeJurusan='$kdprodi' and (NamaMK like '%KKN%' or NamaMK like '%Kuliah Kerja Nyata%' or NamaMK like '%PPLT%' or NamaMK='PPL Terpadu' or NamaMK='Prakter Pengalaman Lapangan Terpadu' or NamaMK like '%PPL- Terpadu%' or NamaMK like '%PPL-Terpadu%' or NamaMK like '%KULIAH KERJA NYATA / STRATEGI PENGEMBANGAN KEPRIBADIAN DAN KEMASYARAKATAN (SPKK)%')";
				$jadwal = $this->Kkn_modeladmin->getJadwal($getJadwal);

				$jid = $jadwal->IDJADWAL;
				$IDMK = $jadwal->IDMK;
				$KodeMK = $jadwal->KodeMK;
				$NamaMK = $jadwal->NamaMK;
				$SKS = $jadwal->SKS;
				$IDDosen = $jadwal->IDDosen;
				$unip = $this->session->unip;
				$PRG = $jadwal->Program;

				//Siakad
				$upt 	 = "update _v2_krs20201 set prckkn='1' where NIM='$nim' and tahun='$thn' and NamaMK='$NamaMK'";
				$this->Kkn_modeladmin->updatePrcKkn($upt);

				//insert Krs 
				$qInsert = "insert into ".$tbl." (NIM, Tahun, IDJadwal, IDMK, KodeMK, NamaMK, SKS, IDDosen, unip, Tanggal, Program, prckkn)
		            values ('$nim', '$thn', '$jid', '$IDMK', '$KodeMK', '$NamaMK', $SKS, '$IDDosen', '$unip', now(), '$PRG', '1')";
		        $this->Kkn_modeladmin->insertKrs($qInsert);


				$data1['data'] = $pesan;

				$this->load->view('temp/head');
				$this->load->view('ademik/proses_kkn/proses_kknadmin', $data1);
				$this->load->view('temp/footers');  
			} else {
				$pesan = "<div class='alert alert-danger'>
						<button class='close' data-dismiss='alert'>~</button>
						<strong>Warning!</strong> Data Gagal Terkirim!!
						</div>";
				$data1['data'] = $pesan;

				$this->load->view('temp/head');
				$this->load->view('ademik/proses_kkn/proses_kknadmin', $data1);
				$this->load->view('temp/footers');  

			}
		 } else {
			$pesan = "SKS Tidak Mencukupi untuk NIM : $nim";
			$data1['data'] = $pesan;

			$this->load->view('temp/head');
			$this->load->view('ademik/proses_kkn/proses_kknadmin', $data1);
			$this->load->view('temp/footers');  

		 }
	    
	}
	
	public function daftar(){

		$thn 			= "20201";
		$tbl 			= "_v2_krs20201";
		$angkatan_kkn 	= "91";
		// $nim 			= $this->input->post('nimkkn');

    	//$nim = 'D10113025';
        //$data['result']	= $this->Kkn_modeladmin->search($nim);
  		
  		$nim 			= strtoupper($this->input->post('searchData'));
  		
  		if($nim == ''){
      		$pesan = "Nim Tidak boleh kosong";
			$data1['data'] = $pesan;

			$this->load->view('temp/head');
			$this->load->view('ademik/proses_kkn/proses_kknadmin', $data1);
			$this->load->view('temp/footers');  
      	}
      	else{
	  		$qNmMhsw 	= "select * from _v2_mhsw where NIM='$nim'";
	  		$nmMhsw 	= $this->Kkn_modeladmin->getQuery($qNmMhsw);
	  		$namamhsw 	= $nmMhsw->Name;

	  		// cek krs sudah terinput atau belum matakuliah kkn
			$qcekkrs = "select * from $tbl where Tahun='$thn' and NIM='$nim' and (NamaMK like '%KKN%' or NamaMK like '%Kuliah Kerja Nyata%' or NamaMK like '%PPLT%' or NamaMK='PPL Terpadu' or NamaMK='Prakter Pengalaman Lapangan Terpadu' or NamaMK like '%PPL- Terpadu%' or NamaMK like '%PPL-Terpadu%' or NamaMK like '%KULIAH KERJA NYATA / STRATEGI PENGEMBANGAN KEPRIBADIAN DAN KEMASYARAKATAN (SPKK)%')";

			$cekkrs = $this->Kkn_modeladmin->getNumRows($qcekkrs);
		    
			if ($cekkrs == 0){
			
				$qr="select m.TahunAkademik, m.Name as nm, f.Nama_Indonesia as nmindo, m.KodeFakultas AS kdfak, m.KodeJurusan AS kdjur, j.Nama_Indonesia as j, m.TotalSKS as totsksl, m.TempatLahir as tmp from _v2_mhsw m left outer join fakultas f on m.KodeFakultas=f.Kode left outer join _v2_jurusan j on m.KodeJurusan=j.Kode where m.NIM='$nim'";

				
				$d = $this->Kkn_modeladmin->getQuery($qr);
				$nama = $this->Kkn_modeladmin->db->escape_str($d->nm);
				$kdfak = $d->kdfak;
				$fak = $d->nmindo;
				$kdprodi = $d->kdjur;
				$j = $d->j;
				$t = $d->totsksl;
				$tahunakademik = $d->TahunAkademik;
				
				// cek jadwal matakuliah
				$qCekjadwal = "select * from _v2_jadwal where Tahun='$thn' and KodeJurusan='$kdprodi' and (NamaMK like '%KKN%' or NamaMK like '%Kuliah Kerja Nyata%' or NamaMK like '%PPLT%' or NamaMK='PPL Terpadu' or NamaMK='Prakter Pengalaman Lapangan Terpadu' or NamaMK like '%PPL- Terpadu%' or NamaMK like '%PPL-Terpadu%' or NamaMK like '%KULIAH KERJA NYATA / STRATEGI PENGEMBANGAN KEPRIBADIAN DAN KEMASYARAKATAN (SPKK)%')";

				$cekjadwal = $this->Kkn_modeladmin->getNumRows($qCekjadwal);
				
				if ($cekjadwal > 0){
					
					if(($t >= 100 or $tahunakademik == '2011' or $tahunakademik == '2012' or $tahunakademik == '2013'/* or $nim == 'F55119014'*/)){
					// DETAIL DATA MAHASISWA
						$T1="<table class='table table-striped table-bordered' cellspacing=0 cellpadding=2>
							<form action='".base_url('ademik/proses_kkn/proses_kknadmin/prckkn')."' method=POST>
							<tr><th style='text-align:center' colspan=2 >IDENTITAS MAHASISWA</th></tr>";
							
						$T2="<tr>
								<td class=lst>NIM</td>
								<td class=lst>$nim</td>
								<input type='hidden' name='nimkkn' value='$nim' readOnly>
							</tr>
							<tr>
								<td class=lst>Nama Lengkap</td>
								<td class=lst>$nama</td>
							</tr>
							<tr>
								<td class=lst>Fakultas</td>
								<td class=lst>$kdfak - $fak</td>
							</tr>
							<tr>
								<td class=lst>Jurusan</td>
								<td class=lst>$kdprodi - $j</td>
							</tr>
							<tr>
								<td class=lst>Total SKS</td>
								<td class=lst>$t</td>
							</tr>
							<tr>
								<td class=lst colspan=2><input type=submit value='Kirim ke KKN'>&nbsp;</td>
							</tr>
							<tr>
								<td class=lst colspan=2>Catatan : Jika terdapat biodata yang belum lengkap, silahkan isi terlebih dahulu. (Menu : mahasiswa --> Biodata)</td>
							</tr>
							</form></table>";


						$data1['data'] = "$T1$T2";

						$this->load->view('temp/head');
						$this->load->view('ademik/proses_kkn/proses_kknadmin', $data1);
						$this->load->view('temp/footers');  

						// BATAS DETAIL DATA MAHASISWA
					} else {
						if (($t>=100 or $tahunakademik == '2011' or $tahunakademik == '2012' or $tahunakademik == '2013'/* or $nim == 'F55119014'*/)) $kriteria=""; 
						
						else $kriteria="Kriteria Untuk Melakukan Proses KKN : SKS LULUS Minimal 100 SKS dan Program Matakuliah KRS. <b>Silahkan Masuk ke report->cetak khs 2, kemudian klik tombol 'search' dan lakukan prc IPK mahasiswa</b>";
						
						/*if($skslulus<=99 || $ulevel=='5') $ketdaftar="SKS Lulus tidak mencapai persyaratan ikut KKN 100 SKS <a href='http://localhost/siakad/print.php?print=ademik/rpt/transkripnilai.php&PerMhsw=$nim&param=x&PHPSESSID=d22a68db64e488b1eac680e288f839aa&ctkhdr='>Cetak Transkrip Untuk Refresh KRS Lulus </a>";
						else if($pplcek==0 ||  $kdf=='C') $ketdaftar="KRS KKN tidak ada, Silahkan Isi KRS Dulu";*/
						

						$data1['data']="<div class='alert alert-danger'>
							<strong style='font-size:20px;'><u>Peringatan !!!</u></strong>
							<br><br><table class='table table-striped'>
							<tr>
								<td class=lst>NIM</td>
								<td class=lst>$nim</td>
							</tr>

							<tr>
								<td class=lst>Nama Lengkap</td>
								<td class=lst>$nama</td>
							</tr>
							<tr>
								<td class=lst>Fakultas</td>
								<td class=lst>$kdfak - $fak</td>
							</tr>
							<tr>
								<td class=lst>Jurusan</td>
								<td class=lst>$kdprodi - $j</td>
							</tr>
							<tr>
								<td class=lst>Total SKS</td>
								<td class=lst>$t</td>
							</tr>
							</table>
							$kriteria
							</div>";

						$this->load->view('temp/head');
						$this->load->view('ademik/proses_kkn/proses_kknadmin', $data1);
						$this->load->view('temp/footers'); 
						
						//echo "fandu pratama lakuana ";
						//echo $skslulus." - ".$ulevel." - ".$pplcek." - ".$kdf;
						
					}
					// batas tombol search
					
				} else {
					$pesan = "<div class='alert alert-danger'>
					<strong style='font-size:20px;'><u>Peringatan !!!</u></strong>
					<br><br><table class='table table-striped'>
					<tr><td class=lst>Maaf anda tidak dapat memproses kkn mahasiswa, pastikan anda sudah menjadwalkan matakuliah pada menu AdmAkd --> Penjadwalan Kuliah</td></tr>
					</table>
					</div>";
					$data1['data'] = $pesan;

					$this->load->view('temp/head');
					$this->load->view('ademik/proses_kkn/proses_kknadmin', $data1);
					$this->load->view('temp/footers');  
				}
			
			} else {

				$nim 			= $_SESSION['qMhswKkn']= $this->Kkn_modeladmin->getMhswKkn($nim)->Login;
				$nama  			= $_SESSION['qMhswKkn']= $this->Kkn_modeladmin->getMhswKkn($nim)->nm;
				$cektabkkn = $this->Kkn_modeladmin->cektabkkn($nim,$nama);


				if ($cektabkkn == 0) {

					$this->kirimkkn($nim);					
				}

				$msg 	= 	"Melakukan Pembayaran KKN ke Bank BNI Senilai Rp. 630.000. Silahkan download Pengantar ke BANK disini
							<form method='POST' action='".base_url()."ademik/report/Report/cetak_bayar_kkn'>
											<input type='hidden' name='nama' value='$namamhsw'>
											<input type='hidden' name='nim' value='$nim'>
											<button style='margin-right: 5px;' type='submit' class='btn btn btn-default fa fa-print'> Cetak Bukti Pembayaran</button>
										</form>";
							/*<a href='print.php?print=ademik/report/cetak_bukti_kkn.php&tahun=$thn&nim=$nim&nama=$namamhsw' target='_blank'>
							<input type='button' value='Cetak Bukti Pendaftaran'></a>*/
				$pesan 	= 	"<div class='alert alert-success'>
							<button class='close' data-dismiss='alert'>×</button>
							<strong>Sukses!</strong> KRS sudah terinput pada Tahun $thn dan Data Berhasil Terkirim, Silahkan <br> $msg <br>Kemudian Login Ke Aplikasi kkn.untad.ac.id
							</div>";
				$data1['data'] = $pesan;

				$this->load->view('temp/head');
				$this->load->view('ademik/proses_kkn/proses_kknadmin', $data1);
				$this->load->view('temp/footers');  
			}
		}


       
	}
	
	private function kirimkkn($nim){

		//$nim 			= $_SESSION['nim']= $this->input->post('nimkkn');
		$thn 			= $_SESSION['thn']= "20201";
		$tbl 			= $_SESSION['tbl']= "_v2_krs20201";
		$angkatan_kkn 	= $_SESSION['angkatan_kkn']= "91";

		$qMhswKkn		= $_SESSION['qMhswKkn']= $this->Kkn_modeladmin->getMhswKkn($nim);

		//$id = $qMhswKkn->ID;
		$nama = $qMhswKkn->nm;
		$login = $qMhswKkn->Login;
		$password = $qMhswKkn->Password;
		//$namamk = $qMhswKkn->NamaMK;
		$kdfak = $qMhswKkn->kdfak;
		$fak = $qMhswKkn->nmindo;	
		$singkatan = $qMhswKkn->Singkatan;	
		$kdprodi = $qMhswKkn->kdjur;	
		$j = $qMhswKkn->j;
		$sex = $qMhswKkn->sex;
		$phone = $qMhswKkn->p;
		$prog = $qMhswKkn->k;
		$t = $qMhswKkn->t;
		$ipk = $qMhswKkn->IPK;
		$tmp = $qMhswKkn->tmp;
		$almt1 = $qMhswKkn->almt1;
		$tahunakademik = $qMhswKkn->TahunAkademik;
		 
		 if ($kdfak == 'A') {
			$kodefakultas = "1";
		 } else if ($kdfak == 'B') {
			$kodefakultas = "2";
		 } else if ($kdfak == 'C') {
			$kodefakultas = "3";
		 } else if ($kdfak == 'D') {
			$kodefakultas = "4";
		 } else if ($kdfak == 'E') {
			$kodefakultas = "5";
		 } else if ($kdfak == 'F') {
			$kodefakultas = "6";
		 } else if ($kdfak == 'G') {
			$kodefakultas = "7";
		 } else if ($kdfak == 'H') {
			$kodefakultas = "8";
		 } else if ($kdfak == 'L') {
			$kodefakultas = "12";
		 } else if ($kdfak == 'N') {
			$kodefakultas = "14";
		 } else if ($kdfak == 'O') {
			$kodefakultas = "15";
		 } else if ($kdfak == 'P') {
			$kodefakultas = "16";
		 } else if ($kdfak == 'K2M') {
		 	if 		($kdprodi == 'K2MC201') {
		 		$kodefakultas = "3";
		 	}elseif ($kdprodi == 'K2ME281') {
		 		$kodefakultas = "5";
		 	}elseif ($kdprodi == 'K2MF111') {
		 		$kodefakultas = "6";
		 	}
			
		 } else if ($kdfak == 'K2T') {
			if 		($kdprodi == 'K2TC201') {
		 		$kodefakultas = "3";
		 	}elseif ($kdprodi == 'K2TE281') {
		 		$kodefakultas = "5";
		 	}elseif ($kdprodi == 'K2TF111') {
		 		$kodefakultas = "6";
		 	}

		 } else {
			$kodefakultas = "0";
		 }  
		 
		 $nomorpembayaran = "$kodefakultas".substr($nim,1);

		 	$nim = $this->Kkn_modeladmin->db->escape_str($nim);
			$ins="INSERT into tb_mahasiswa_kkn (id_mhs_kkn, nim, nama, alamat, jk, no_hp, kd_fakultas, kd_jurusan, kode_program, sks_lulus, IPK, user_name, password,id_group,periode_kkn,tahun_kkn,status_nikah,status,id_record_tagihan) values (null,'$nim','$nama','$almt1','$sex','$phone','$kdfak','$kdprodi','$prog','$t','$ipk','$login','$password','3','$angkatan_kkn','$thn','N','N','".$nim."KKN".$angkatan_kkn."')"; 
			$this->Kkn_modeladmin->insertKkn($ins);

			$querytagihan = "INSERT INTO `tagihan` (`id_record_tagihan`, `kode_periode`, `nama_periode`, `is_tagihan_aktif`, `total_nilai_tagihan`, `nomor_pembayaran`, `kode_prodi`, `nama_prodi`, `strata`, `angkatan`, `waktu_berlaku`, `waktu_berakhir`, `nama`, `kode_fakultas`, `nama_fakultas`, `urutan_antrian`, `kode_bank`, `nomor_induk`) VALUES ('".$nim."KKN".$angkatan_kkn."', 'KKN', 'KKN Semester $thn', '1', '630000', '$nomorpembayaran', '$kdprodi', '$fak S1', 'S1', '$tahunakademik', '2020-08-03', '2020-09-08', '$nama', '$singkatan', '$singkatan', '1', 'BNI', '$nim')";

			$ins_querytagihan = $this->Kkn_modeladmin->insertTagihan($querytagihan);
			//$ins_querytagihan = true;
			
			$querydetil_tagihan = "INSERT INTO `detil_tagihan` (`id_record_detil_tagihan`, `id_record_tagihan`, `kode_jenis_biaya`, `label_jenis_biaya`, `urutan_detil_tagihan`, `label_jenis_biaya_panjang`, `nilai_tagihan`) VALUES ('".$nim."KKN".$angkatan_kkn."', '".$nim."KKN".$angkatan_kkn."', 'KKN', 'KKN', 1, 'KKN', '630000')";
			
			$ins_querydetil_tagihan = $this->Kkn_modeladmin->insertDetilTagihan($querydetil_tagihan);
	}

	public function kirimKknAll($value='') {
		$nims = explode('-', $value);
		$res = 0;
		foreach ($nims as $nim) {
			$res = $this->kirimkkn($nim);
			echo "nim : ".$nim.' || res : '.$res;
			echo "<hr/>";
		}
	}

}