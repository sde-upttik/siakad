<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proses_kkn extends CI_Controller {

	function __construct(){
		parent::__construct();
	    $this->load->model('Kkn_model');
	}

	public function index(){

		$a['tab'] = $this->app->all_val('groupmodul')->result();
		$this->load->view('dashbord',$a);
	}
	
/*	public function mike(){
		$data = $this->Kkn_model->mike2()->result();
		foreach ($data as $a){
			echo $a->nama;
		}
	}*/

	public function prckkn()
	{
		$ulevel = $this->session->ulevel;
		$nim=$this->input->post('nimkkn');
		$thn = '20181';
		$angkatan_kkn = "80";
		$qMhswKkn=$this->Kkn_model->getMhswKkn($nim);

		$id = $qMhswKkn->ID;
		$nama = $qMhswKkn->nm;
		$login = $qMhswKkn->Login;
		$password = $qMhswKkn->Password;
		$namamk = $qMhswKkn->NamaMK;
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
			$kodefakultas = "11";
		 } else if ($kdfak == 'K2T') {
			$kodefakultas = "11";
		 } else {
			$kodefakultas = "0";
		 } 
		 
		 $nomorpembayaran = "$kodefakultas".substr($nim,1);
		 
		 if(($t >= 100 or $tahunakademik == '2011' or $tahunakademik == '2012' or $tahunakademik == '2013') and ($ulevel=='4' or $ulevel=='1')){
			$cektabkkn = $this->Kkn_model->cektabkkn($nim,$nama);

			$msg = "";
			if ($cektabkkn == 0){
				$nim = $this->Kkn_model->db->escape_str($nim);
				$ins="INSERT into tb_mahasiswa_kkn (id_mhs_kkn, nim, nama, alamat, jk, no_hp, kd_fakultas, kd_jurusan, kode_program, sks_lulus, IPK, user_name, password,id_group,periode_kkn,tahun_kkn,status_nikah,status,id_record_tagihan) values (null,'$nim','$nama','$almt1','$sex','$phone','$kdfak','$kdprodi','$prog','$t','$ipk','$login','$password','3','$angkatan_kkn','$thn','N','N','".$nim."KKN1APL')"; 
				
				$querytagihan = "INSERT INTO `tagihan` (`id_record_tagihan`, `kode_periode`, `nama_periode`, `is_tagihan_aktif`, `total_nilai_tagihan`, `nomor_pembayaran`, `kode_prodi`, `nama_prodi`, `strata`, `angkatan`, `waktu_berlaku`, `waktu_berakhir`, `nama`, `kode_fakultas`, `nama_fakultas`, `urutan_antrian`, `kode_bank`, `nomor_induk`) VALUES ('".$nim."KKN1APL', 'KKN', 'KKN $thn Ang. $angkatan_kkn', '1', '630000', '$nomorpembayaran', '$kdprodi', '$fak S1', 'S1', '$tahunakademik', '2018-03-31', '2018-04-04', '$nama', '$singkatan', '$singkatan', '1', 'BNI', '$nim')";

				//$ins_querytagihan = $this->Kkn_model->insertTagihan($querytagihan);
				
				$querydetil_tagihan = "INSERT INTO `detil_tagihan` (`id_record_detil_tagihan`, `id_record_tagihan`, `kode_jenis_biaya`, `label_jenis_biaya`, `urutan_detil_tagihan`, `label_jenis_biaya_panjang`, `nilai_tagihan`) VALUES ('".$nim."KKN', '".$nim."KKN1APL', 'KKN', 'KKN', 1, 'KKN', '630000')";
				
				//$ins_querydetil_tagihan = $this->Kkn_model->insertDetilTagihan($querydetil_tagihan);
				
				if (($ins_querytagihan == true) and ($ins_querydetil_tagihan == true)){
					$msg = "Melakukan Pembayaran KKN ke Bank BNI Senilai Rp. 630.000. Silahkan download Pengantar ke BANK disini <a href='print.php?print=ademik/rpt/buktibayarkkn.php&tahun=$thn&nim=$nim&nama=$nama' target='_blank'><input type='button' value='Cetak Bukti Pendaftaran'></a>";
				}
			} else {
				$ins="UPDATE tb_mahasiswa_kkn set sks_lulus='$t',id_group='3', status_nikah='N',status='N' where nim='$nim'and nama='$nama'";
			}
			$insertKkn=$this->Kkn_model->insertKkn($ins);
			if ($insertKkn){
				$pesan =  "<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>×</button>
						<strong>Sukses!</strong> Data Berhasil Terkirim, Silahkan <br> $msg <br>Kemudian Login Ke Aplikasi kkn.untad.ac.id
						</div>";

				$upt="update _v2_krs20181 set prckkn='1' where ID='$id' and NIM='$nim' and tahun='$thn' and NamaMK='$namamk'";
				$this->Kkn_model->updatePrcKkn($upt);

				$data1['data'] = $pesan;

				$this->load->view('temp/head');
				$this->load->view('ademik/proses_kkn/proses_kkn', $data1);
				$this->load->view('temp/footers');  
			} else {
				$pesan = "<div class='alert alert-danger'>
						<button class='close' data-dismiss='alert'>×</button>
						<strong>Warning!</strong> Data Gagal Terkirim!!
						</div>";
				$data1['data'] = $pesan;

				$this->load->view('temp/head');
				$this->load->view('ademik/proses_kkn/proses_kkn', $data1);
				$this->load->view('temp/footers');  

			}
		 } else {
			$pesan = "SKS Tidak Mencukupi untuk NIM : $nim";
			$data1['data'] = $pesan;

			$this->load->view('temp/head');
			$this->load->view('ademik/proses_kkn/proses_kkn', $data1);
			$this->load->view('temp/footers');  

		 }
	    
	}
	
	public function daftar(){
    	//$searchData = 'D10113025';
        //$data['result']	= $this->Kkn_model->search($searchData);
  		$searchData = $this->input->post('searchData');
        $data = $this->Kkn_model->search($searchData);
      	
      	if($searchData == ''){
      		$pesan = "Nim Tidak boleh kosong";
			$data1['data'] = $pesan;

			$this->load->view('temp/head');
			$this->load->view('ademik/proses_kkn/proses_kkn', $data1);
			$this->load->view('temp/footers');  
      	}else{

      	if ($data == False) {
      		$pesan = "Silahkan Mengisi KRS terlebih dahulu";
			$data1['data'] = $pesan;

			$this->load->view('temp/head');
			$this->load->view('ademik/proses_kkn/proses_kkn', $data1);
			$this->load->view('temp/footers');  
      	}else{

      		$login=$data->Login;
	       	$nim=$data->nim;
	       	$nama=$data->nm;
		    $password=$data->Password;
			$namamk=$data->NamaMK;
			$kdfak=$data->kdfak;
		    $fak=$data->nmindo;	
			$kdprodi=$data->kdjur;	
			$j=$data->j;
		    $sex=$data->sex;
		    $phone=$data->p;
		    $prog=$data->k;
		    $t=$data->totsksl;
		    $tmp=$data->tmp;
			$prckkn=$data->prckkn;
			$tahunakademik=$data->TahunAkademik;

			if(($t >= 100 or $tahunakademik == '2011' or $tahunakademik == '2012' or $tahunakademik == '2013') and $prckkn=="0"){
			 	$T1="<table class='table table-striped table-bordered' cellspacing=0 cellpadding=2>
					<form action='".base_url('ademik/proses_kkn/proses_kkn/prckkn')."' method=POST>
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
				$this->load->view('ademik/proses_kkn/proses_kkn', $data1);
				$this->load->view('temp/footers');  
		       	
	   		}else {
				if (($t>=100 or $tahunakademik == '2011' or $tahunakademik == '2012' or $tahunakademik == '2013') and $prckkn == "1"){
					$kriteria="Data Anda Sudah Terkirim.<br>Silahkan Lakukan Pembayaran ke Bank BNI Senilai Rp. 630.000 Menggunakan Nomor STAMBUK Anda<br>Kemudian Lakukan pendaftaran pada Aplikasi KKN<br>";
				}else{
					$kriteria="Kriteria Untuk Melakukan Proses KKN : SKS LULUS Minimal 100 SKS dan Program Matakuliah KRS.";	
				} 
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
				$this->load->view('ademik/proses_kkn/proses_kkn', $data1);
				$this->load->view('temp/footers');  
					
				}
     	 	}
      	    
      	}

       
	}
	
}