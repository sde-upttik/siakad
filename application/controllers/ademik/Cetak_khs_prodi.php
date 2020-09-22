<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak_khs_prodi extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->library('datatables');
	    $this->load->model('cetak_khs_prodi_model');
	    $this->load->model('ipk_model');
	    $this->load->model('krs_model');
		date_default_timezone_set("Asia/Makassar");
	}

	public function index(){
	// cara pertama
		//	$content = $this->session->userdata('sess_tamplate');
		//	$this->load->view('temp/head');
		//	$this->load->view($content);
		//	$this->load->view('temp/footers');
	
	// cara kedua
		$a['tab'] = $this->app->all_val('groupmodul')->result();
		if($this->session->ulevel=="7"){
			$kdj=$this->session->kdj;
			$a['jurusan'] = $this->cetak_khs_prodi_model->getJurusanKdj($kdj);
		}elseif($this->session->ulevel=="5"){
			$kdf=$this->session->kdf;
			$a['jurusan'] = $this->cetak_khs_prodi_model->getJurusanKdf($kdf);
		}else{
			$a['jurusan'] = $this->cetak_khs_prodi_model->getJurusan();	
		}
		
		$this->load->view('dashbord',$a);
		
	// cara ke tiga
		//$this->load->view('dashbord');
	}

	public function search(){
    	$semesterAkademik = $this->input->post('semesterAkademik');
    	$program = $this->input->post('program');
    	$jurusan = $this->input->post('jurusan');
    	$angkatan = $this->input->post('angkatan');

    	//$data['data']=$semesterAkademik." - ".$program." - ".$jurusan." - ".$angkatan;
    	$data['semester']=$semesterAkademik;
    	$data['program']=$program;
    	$data['jur']=$jurusan;
    	$data['angkatan']=$angkatan;
		$data['fakultas'] = $this->ipk_model->getKdf($jurusan);
		
		if($this->session->ulevel=="7"){
			$kdj=$this->session->kdj;
			$data['jurusan'] = $this->cetak_khs_prodi_model->getJurusanKdj($kdj);
		}elseif($this->session->ulevel=="5"){
			$kdf=$this->session->kdf;
			$data['jurusan'] = $this->cetak_khs_prodi_model->getJurusanKdf($kdf);
		}else{
			$data['jurusan'] = $this->cetak_khs_prodi_model->getJurusan();	
		}
		
		$data['footerSection'] = "
		    <script type='text/javascript'>
 
            var save_method; //for save method string
            var table;
 
            $(document).ready(function() {
				var dataku = 'semesterAkademik=".$semesterAkademik."&jurusan=".$jurusan."&program=".$program."&angkatan=".$angkatan."';
            	var oTable = $('#tabel_cetak_khs').dataTable({
		            'processing': true, 
			            'serverSide': true, 
			            'order': [], 
			             
			            'ajax': {
			                'url': '".base_url('ademik/cetak_khs_prodi/dataMahasiswa/'.$semesterAkademik.'/'.$jurusan.'/'.$program.'/'.$angkatan)."',
			                'type': 'POST'
			            },
			 
			             
			            'columnDefs': [
			            { 
			                'targets': [ 0 ], 
			                'orderable': false, 
			            },
			            ]
		       });
            });
        </script>"; 

		$this->load->view('temp/head');
		$this->load->view('ademik/cetak_khs_prodi', $data);
		$this->load->view('temp/footers',$data);    	
	}

	public function prcIps($semesterAkademik,$program,$jurusan,$angkatan,$nim=''){
		if ($nim!=''){$str="and m.nim='$nim'";}else{$str="and  stprc='0' order by k.NIM asc limit 50";} 

 		$getDataIps = $this->cetak_khs_prodi_model->getDataIps($semesterAkademik,$jurusan,$program,$angkatan,$str);
 		//echo $str;
 		//print_r($getDataIps);
 		foreach ($getDataIps as $show) {
 			$nim1 = $show->NIM;
		    $kdf = $show->KodeFakultas;
			$this->proses($semesterAkademik, $nim1, $kdf, $jurusan);
 		}

 		$data['semester']=$semesterAkademik;
    	$data['program']=$program;
    	$data['jur']=$jurusan;
    	$data['angkatan']=$angkatan;
		$data['fakultas'] = $this->ipk_model->getKdf($jurusan);
		
		if($this->session->ulevel=="7"){
			$kdj=$this->session->kdj;
			$data['jurusan'] = $this->cetak_khs_prodi_model->getJurusanKdj($kdj);
		}elseif($this->session->ulevel=="5"){
			$kdf=$this->session->kdf;
			$data['jurusan'] = $this->cetak_khs_prodi_model->getJurusanKdf($kdf);
		}else{
			$data['jurusan'] = $this->cetak_khs_prodi_model->getJurusan();	
		}
		
		$data['footerSection'] = "
		    <script type='text/javascript'>
 
            var save_method; //for save method string
            var table;
 
            $(document).ready(function() {
				var dataku = 'semesterAkademik=".$semesterAkademik."&jurusan=".$jurusan."&program=".$program."&angkatan=".$angkatan."';
            	var oTable = $('#tabel_cetak_khs').dataTable({
		            'processing': true, 
			            'serverSide': true, 
			            'order': [], 
			             
			            'ajax': {
			                'url': '".base_url('ademik/cetak_khs_prodi/dataMahasiswa/'.$semesterAkademik.'/'.$jurusan.'/'.$program.'/'.$angkatan)."',
			                'type': 'POST'
			            },
			 
			             
			            'columnDefs': [
			            { 
			                'targets': [ 0 ], 
			                'orderable': false, 
			            },
			            ]
		       });
            });
        </script>"; 

		$this->load->view('temp/head');
		$this->load->view('ademik/cetak_khs_prodi', $data);
		$this->load->view('temp/footers',$data);    
	}

	public function proses($thn, $nim, $kdf, $kdj) {

		$tbl="_v2_krs".$thn;

		//$qKhs = $this->ipk_model->getKhsPeriode($nim,$thn);

		$n = 0;
		$TSKS = 0; $TNK = 0;
		$TSKSLulus = 0;
		//foreach ($qKhs as $show) {
			$tabel = "_v2_krs".$thn;

			$qKrs = $this->ipk_model->getDataKrsPeriode($nim,$thn,$tabel);

			foreach ($qKrs as $show1) {
				$n++;

				$bobot = 0;

				$bobot = $show1->Bobot;

				//$bobot = str_replace('.',',',$bobot);

				$NK = $bobot * $show1->SKS;
				//echo "===$bobot-$NK-=="; 
				if($show1->GradeNilai=="A"||$show1->GradeNilai=="A-" ||$show1->GradeNilai=="B+" ||$show1->GradeNilai=="B" ||$show1->GradeNilai=="B-"||$show1->GradeNilai=="C+" ||$show1->GradeNilai=="C"||$show1->GradeNilai=="C-"||$show1->GradeNilai=="D"||$show1->GradeNilai=="E"||$show1->GradeNilai=="K"||$show1->GradeNilai=="T" ||$show1->GradeNilai=="" ||$show1->GradeNilai==" "){
					if(($show1->NamaMK=="Seminar Proposal" || $show1->NamaMK=="Praktik Lapangan (Magang)" || $show1->NamaMK=="Skripsi" || $show1->NamaMK=="Ko-Kurikuler" || $show1->NamaMK=="Kuliah Kerja Profesi (KKP) / KKN") && $show1->Bobot<0){ 
					}else{ 
						$TNK += $NK;
						$TSKS += $show1->SKS;
						if($bobot>0) $TSKSLulus += $show1->SKS;
					}
				}
			}
		//}
	
		if ($TSKS == 0) $IPS = 0;
		else $IPS = number_format($TNK/$TSKS, 2, ',', '.');

		$IPS = str_replace(',','.',$IPS);

		$qwsks = $this->ipk_model->getMaxSksMax($IPS,$nim);

		$maxsks = $qwsks->SKSMax;

		$data = array("IPS"=>$IPS, "SKSLulus"=>$TSKSLulus, "SKS"=>$TSKS, "MaxSKS2"=>$maxsks, "NIM"=>$nim, "Tahun"=>$thn);

		$qwupdtkhs = $this->ipk_model->updateKhsMax($data);

		if($qwupdtkhs){
	 		$msg = "PRC IPS berhasil";
	 	}else{
	 		$msg = "PRC IPS gagal";
	 	}

	}

	/*public function proses($thn, $nim, $kdf, $kdj) {
		$n = 0;
		$TSKS = 0; $TNK = 0;
		$TSKSLulus = 0;

		$getDataKrs = $this->cetak_khs_prodi_model->getDatakrs($thn, $nim);
		foreach ($getDataKrs as $show) {
			$n++;
			if ($show->Tunda == 'Y') $strtnd = "T : ".$show->AlasanTunda; else $strtnd = '&nbsp;';
			$bobot = 0;

			$bobot = $show->Bobot;
			$NK = $bobot * $show->SKS;

			if($show->GradeNilai=="A"||$show->GradeNilai=="A-" ||$show->GradeNilai=="B+" ||$show->GradeNilai=="B" ||$show->GradeNilai=="B-"||$show->GradeNilai=="C+" ||$show->GradeNilai=="C"||$show->GradeNilai=="C-"||$show->GradeNilai=="D"||$show->GradeNilai=="E"||$show->GradeNilai=="K"||$show->GradeNilai=="T" ||$show->GradeNilai=="" ||$show->GradeNilai==" "){
				if(($show->NamaMK=="Seminar Proposal" || $show->NamaMK=="Praktik Lapangan (Magang)" || $show->NamaMK=="Skripsi" || $show->NamaMK=="Ko-Kurikuler" || $show->NamaMK=="Kuliah Kerja Profesi (KKP) / KKN") && $show->Bobot==0){ }
				else{ 
					$TNK += $NK;
					$TSKS += $show->SKS;
				if($bobot>0) $TSKSLulus += $show->SKS;
				}
			}
		}
		if ($TSKS == 0) $IPS = 0;
		else $IPS = number_format($TNK/$TSKS, 2, ',', '.');

		$IPS = str_replace(',','.',$IPS);

		$getSksMax = $this->cetak_khs_prodi_model->getSksMax($IPS,$nim);
		$maxsks= $getSksMax->SKSMax;
		//echo "$n,$IPS,$TSKSLulus,$TSKS,$maxsks,$nim,$thn";
		if ($n != 0) {
			$updateKhs = $this->cetak_khs_prodi_model->updateKhs($IPS,$TSKSLulus,$TSKS,$maxsks,$nim,$thn);

		}
	}*/

	public function prcIpk($semesterAkademik,$program,$jurusan,$angkatan,$nim=''){
		if ($nim!=''){$str="and m.nim='$nim'";}else{$str="and  stprc='1' limit 50";}
		
 		$getDataIpk = $this->ipk_model->getDataIpk($semesterAkademik,$jurusan,$program,$angkatan,$str);
 		foreach ($getDataIpk as $show) {
 			$nim1 = $show->NIM;
		    $kdf = $show->KodeFakultas;
		    $kdj = $show->KodeJurusan;
			$this->prosesipk($semesterAkademik, $nim1, $kdf,$kdj);
 		}

 		$data['semester']=$semesterAkademik;
    	$data['program']=$program;
    	$data['jur']=$jurusan;
    	$data['angkatan']=$angkatan;    	
		$data['fakultas'] = $this->ipk_model->getKdf($jurusan);
		
		if($this->session->ulevel=="7"){
			$kdj=$this->session->kdj;
			$data['jurusan'] = $this->cetak_khs_prodi_model->getJurusanKdj($kdj);
		}elseif($this->session->ulevel=="5"){
			$kdf=$this->session->kdf;
			$data['jurusan'] = $this->cetak_khs_prodi_model->getJurusanKdf($kdf);
		}else{
			$data['jurusan'] = $this->cetak_khs_prodi_model->getJurusan();	
		}
		
		$data['footerSection'] = "
		    <script type='text/javascript'>
 
            var save_method; //for save method string
            var table;
 
            $(document).ready(function() {
				var dataku = 'semesterAkademik=".$semesterAkademik."&jurusan=".$jurusan."&program=".$program."&angkatan=".$angkatan."';
            	var oTable = $('#tabel_cetak_khs').dataTable({
		            'processing': true, 
			            'serverSide': true, 
			            'order': [], 
			             
			            'ajax': {
			                'url': '".base_url('ademik/cetak_khs_prodi/dataMahasiswa/'.$semesterAkademik.'/'.$jurusan.'/'.$program.'/'.$angkatan)."',
			                'type': 'POST'
			            },
			 
			             
			            'columnDefs': [
			            { 
			                'targets': [ 0 ], 
			                'orderable': false, 
			            },
			            ]
		       });
            });
        </script>"; 

		$this->load->view('temp/head');
		$this->load->view('ademik/cetak_khs_prodi', $data);
		$this->load->view('temp/footers',$data);    
	}

	public function prosesipk($thn, $nim, $kdf, $kdj){
		/*$thn = $this->input->post('thn');
		$nim = $this->input->post('nim');
		$kdf = $this->input->post('kdf');
		$kdj = $this->input->post('kdj');*/

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
				$qw = $this->ipk_model->getKrsFak($kdf,$nim, $show1->Tahun, $tabel);
			}else{
				$qw = $this->ipk_model->getKrsFakSama($kdf,$nim, $show1->Tahun, $tabel);
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
		
		$tgl = date('d-m-Y');

		$data = array("IPK"=>$TotIPK, "TotalSKS"=>$TotSKS, "TotalSKSLulus"=>$TotSKSLulus, "NIM"=>$nim, "Tahun"=>$thn);

		$qwupdtkhsipk = $this->ipk_model->updateKhsIPK($data);

		$qwupdtkhsipkmhsw = $this->ipk_model->updateIpkMhsw($TotSKS,$TotIPK,$nim,$TotSKSLulus);

		if($qwupdtkhsipk){
	 		$msg = "PRC IPK berhasil";
	 	}else{
	 		$msg = "PRC IPK gagal";
	 	}
	}

	/*public function prosesipk($thn, $nim, $kdf, $angkatan) {
		$ang = substr($thn,0,4);
		$TotSKS=0;
		$TotSKSLulus=0;
		$TotNil=0;
		
		$status='';
		if($angkatan==$ang){
			$status='baru';
		}

		$getDataKrsIpk = $this->cetak_khs_prodi_model->getDataKrsIpk($nim,$thn,$status);

		foreach ($getDataKrsIpk as $show) {
			$bobot = $show->Bbt;

			if($show->Grade=="A" || $show->Grade=="B" || $show->Grade=="C" || $show->Grade=="D" || $show->Grade=="E" || $show->Grade=="A-" || $show->Grade=="B+" || $show->Grade=="B-" || $show->Grade=="C+"|| $show->Grade=="C-"|| $show->Grade=="K" || $show->Grade=="T" || $show->Grade=="" || $show->Grade==" "){

				if(($show->NamaMK=="Seminar Proposal" || $show->NamaMK=="Praktik Lapangan (Magang)" || $show->NamaMK=="Skripsi" || $show->NamaMK=="Ko-Kurikuler" || $show->NamaMK=="Kuliah Kerja Profesi (KKP) / KKN") && $show->Bbt==0){ }
				else{ 
					$TotSKS +=$show->SKS;
					$TotNil +=$show->Bbt*$show->SKS;
					$bobot = $show->Bbt;
					if($bobot>0){ $TotSKSLulus+=$show->SKS;}

				}
			}
		}

		$TotIPK = round($TotNil/$TotSKS,2);
		$TotIPK = number_format($TotNil/$TotSKS, 2, ',', '.');

		$TotIPK = str_replace(',','.',$TotIPK);

		$tgl = date('d-m-Y');

		$updateKhsIpk = $this->cetak_khs_prodi_model->updateKhsIpk($TotIPK,$TotSKS,$TotSKSLulus,$nim,$thn);
	}*/

	public function resetIps($semesterAkademik,$program,$jurusan,$angkatan){
		$getDataReset = $this->cetak_khs_prodi_model->getDataReset($semesterAkademik,$jurusan,$program,$angkatan);
 		foreach ($getDataReset as $show) {
 			$nim1 = $show->NIM;
		    $kdf = $show->KodeFakultas;
			$this->resetst_prc($semesterAkademik, $nim1);
 		}

 		$data['semester']=$semesterAkademik;
    	$data['program']=$program;
    	$data['jur']=$jurusan;
    	$data['angkatan']=$angkatan;
    	
		$data['fakultas'] = $this->ipk_model->getKdf($jurusan);
		
		if($this->session->ulevel=="7"){
			$kdj=$this->session->kdj;
			$data['jurusan'] = $this->cetak_khs_prodi_model->getJurusanKdj($kdj);
		}elseif($this->session->ulevel=="5"){
			$kdf=$this->session->kdf;
			$data['jurusan'] = $this->cetak_khs_prodi_model->getJurusanKdf($kdf);
		}else{
			$data['jurusan'] = $this->cetak_khs_prodi_model->getJurusan();	
		}
		
		$data['footerSection'] = "
		    <script type='text/javascript'>
 
            var save_method; //for save method string
            var table;
 
            $(document).ready(function() {
				var dataku = 'semesterAkademik=".$semesterAkademik."&jurusan=".$jurusan."&program=".$program."&angkatan=".$angkatan."';
            	var oTable = $('#tabel_cetak_khs').dataTable({
		            'processing': true, 
			            'serverSide': true, 
			            'order': [], 
			             
			            'ajax': {
			                'url': '".base_url('ademik/cetak_khs_prodi/dataMahasiswa/'.$semesterAkademik.'/'.$jurusan.'/'.$program.'/'.$angkatan)."',
			                'type': 'POST'
			            },
			 
			             
			            'columnDefs': [
			            { 
			                'targets': [ 0 ], 
			                'orderable': false, 
			            },
			            ]
		       });
            });
        </script>"; 

		$this->load->view('temp/head');
		$this->load->view('ademik/cetak_khs_prodi', $data);
		$this->load->view('temp/footers',$data);    
	}

	public function resetst_prc($thn, $nim) {
		$updateResetPrc = $this->cetak_khs_prodi_model->updateResetPrc($nim,$thn);
	}

	public function hapus_khs_mhs(){
		$id =$this->input->post('id');

		$deleteKhs = $this->cetak_khs_prodi_model->deleteKhs($id);
		if($deleteKhs){
			//echo "Data Berhasil di hapus"; 
			$data['semester']=$this->input->post('semesterAkademik');
	    	$data['program']=$this->input->post('program');
	    	$data['jur']=$this->input->post('jurusan');
	    	$data['angkatan']=$this->input->post('angkatan');

			$semester=$this->input->post('semesterAkademik');
	    	$program=$this->input->post('program');
	    	$jur=$this->input->post('jurusan');
	    	$angkatan=$this->input->post('angkatan');

			
			if($this->session->ulevel=="7"){
				$kdj=$this->session->kdj;
				$data['jurusan'] = $this->cetak_khs_prodi_model->getJurusanKdj($kdj);
			}elseif($this->session->ulevel=="5"){
				$kdf=$this->session->kdf;
				$data['jurusan'] = $this->cetak_khs_prodi_model->getJurusanKdf($kdf);
			}else{
				$data['jurusan'] = $this->cetak_khs_prodi_model->getJurusan();	
			}
			
			$data['footerSection'] = "
			    <script type='text/javascript'>
	 
	            var save_method; //for save method string
	            var table;
	 
	            $(document).ready(function() {
	            	var oTable = $('#tabel_cetak_khs').dataTable({
			            'processing': true, 
				            'serverSide': true, 
				            'order': [], 
				             
				            'ajax': {
				                'url': '".base_url('ademik/cetak_khs_prodi/dataMahasiswa/'.$semester.'/'.$jur.'/'.$program.'/'.$angkatan)."',
				                'type': 'POST'
				            },
				 
				             
				            'columnDefs': [
				            { 
				                'targets': [ 0 ], 
				                'orderable': false, 
				            },
				            ]
			       });
	            });
	        </script>"; 

			$this->load->view('temp/head');
			$this->load->view('ademik/cetak_khs_prodi', $data);
			$this->load->view('temp/footers',$data);    
		}else{
			echo "Data Gagal di hapus"; 
		}

	}

	public function import_khs_feeder1(){
		$nim = $this->input->post('nim');
		$tahun = $this->input->post('thn');

		echo json_encode('Data Berhasil Di import');
	}

	public function spp_default($kdj) {

		switch ($kdj) {
			case $kdj == 'A111':
					$ukt = '3000000';
				break;
			case $kdj == 'A121':
					$ukt = '3000000';
				break;
			case $kdj == 'A231':
					$ukt = '3000000';
				break;
			case $kdj == 'A221':
					$ukt = '3000000';
				break;
			case $kdj == 'A251':
					$ukt = '3000000';
				break;
			case $kdj == 'A241':
					$ukt = '3000000';
				break;
			case $kdj == 'A311':
					$ukt = '3000000';
				break;
			case $kdj == 'A321':
					$ukt = '3000000';
				break;
			case $kdj == 'A351':
					$ukt = '3000000';
				break;
			case $kdj == 'A401':
					$ukt = '3000000';
				break;
			case $kdj == 'A421':
					$ukt = '3000000';
				break;
			case $kdj == 'A411':
					$ukt = '3000000';
				break;
			case $kdj == 'A501':
					$ukt = '3000000';
				break;
			case $kdj == 'B201':
					$ukt = '1600000';
				break;
			case $kdj == 'B301':
					$ukt = '1600000';
				break;
			case $kdj == 'B101':
					$ukt = '2500000';
				break;
			case $kdj == 'B401':
					$ukt = '2500000';
				break;
			case $kdj == 'B501':
					$ukt = '2500000';
				break;
			case $kdj == 'C301':
					$ukt = '2500000';
				break;
			case $kdj == 'C201':
					$ukt = '2500000';
				break;
			case $kdj == 'C101':
					$ukt = '2500000';
				break;
			case $kdj == 'C300':
					$ukt = '2500000';
				break;
			case $kdj == 'C200':
					$ukt = '2500000';
				break;
			case $kdj == 'D101':
					$ukt = '2500000';
				break;
			case $kdj == 'E321':
					$ukt = '1750000';
				break;
			case $kdj == 'E281':
					$ukt = '1750000';
				break;
			case $kdj == 'K2MC201':
					$ukt = '1600000';
				break;
			case $kdj == 'K2ME281':
					$ukt = '1750000';
				break;
			case $kdj == 'K2MF111':
					$ukt = '1750000';
				break;
			case $kdj == 'K2TF111':
					$ukt = '1750000';
				break;
			case $kdj == 'K2TE281':
					$ukt = '1750000';
				break;
			case $kdj == 'K2TC201':
					$ukt = '1600000';
				break;
			case $kdj == 'F441':
					$ukt = '3000000';
				break;
			case $kdj == 'F331':
					$ukt = '3000000';
				break;
			case $kdj == 'F240':
					$ukt = '1750000';
				break;
			case $kdj == 'F111':
					$ukt = '4000000';
				break;
			case $kdj == 'F210':
					$ukt = '1750000';
				break;
			case $kdj == 'F551':
					$ukt = '4000000';
				break;
			case $kdj == 'F221':
					$ukt = '4000000';
				break;
			case $kdj == 'F121':
					$ukt = '3000000';
				break;
			case $kdj == 'F131':
					$ukt = '3000000';
				break;
			case $kdj == 'F230':
					$ukt = '1750000';
				break;
			case $kdj == 'F231':
					$ukt = '3000000';
				break;
			case $kdj == 'A112':
					$ukt = '7000000';
				break;
			case $kdj == 'A122':
					$ukt = '7000000';
				break;
			case $kdj == 'A202':
					$ukt = '7000000';
				break;
			case $kdj == 'A232':
					$ukt = '7000000';
				break;
			case $kdj == 'A312':
					$ukt = '7000000';
				break;
			case $kdj == 'A322':
					$ukt = '7000000';
				break;
			case $kdj == 'B102':
					$ukt = '7000000';
				break;
			case $kdj == 'C102':
					$ukt = '7000000';
				break;
			case $kdj == 'C202':
					$ukt = '7000000';
				break;
			case $kdj == 'C302':
					$ukt = '7000000';
				break;
			case $kdj == 'D102':
					$ukt = '7000000';
				break;
			case $kdj == 'E202':
					$ukt = '7000000';
				break;
			case $kdj == 'E322':
					$ukt = '7000000';
				break;
			case $kdj == 'F112':
					$ukt = '7000000';
				break;
			case $kdj == 'A203':
					$ukt = '12000000';
				break;
			case $kdj == 'B103':
					$ukt = '12000000';
				break;
			case $kdj == 'C203':
					$ukt = '12000000';
				break;
			case $kdj == 'E203':
					$ukt = '12000000';
				break;
			case $kdj == 'L131':
					$ukt = '1750000';
				break;
			case $kdj == 'L140':
					$ukt = '1750000';
				break;
			case $kdj == 'N':
					$ukt = '';
				break;
			case $kdj == 'O271':
					$ukt = '1750000';
				break;
			case $kdj == 'O121':
					$ukt = '1750000';
				break;
			case $kdj == 'P101':
					$ukt = '5000000';
				break;
			case $kdj == 'P211':
					$ukt = '7000000';
				break;
			case $kdj == 'N201':
					$ukt = '5000000';
				break;
			
			default:
					$ukt = '';
				break;
		}

		return $ukt;
	}

	public function import_khs_feeder(){
		$nim = $this->input->post('nim');
		$tahun = $this->input->post('thn');

		$tahun_akademik = $this->krs_model->tahun_akademik($nim);
		$spp_db = $this->krs_model->pembayaran($nim, $tahun);
		$data = $this->krs_model->getDataKhsFeeder($nim, $tahun);

		//print_r($tahun_akademik);
		if ($data->Status == 'C' ) {
			$spp = 0;
		} else {

			if ( empty($spp_db[0]->KodeFakultas) ) {
				$kdf = substr($nim, 0,1);
				$kdj = substr($nim, 0,4);
			} else {
				$kdf = $spp_db[0]->KodeFakultas;
				$kdj = $spp_db[0]->KodeJurusan;
			}

			if ( $spp_db[0]->TotalBayar == NULL OR $spp_db[0]->TotalBayar == 0 ) {
				$spp = $this->spp_default($kdj);
			} elseif ( $tahun == $tahun_akademik->Semester ) {
				$spp = $this->spp_default($tahun_akademik->KodeJurusan);
			} else {
				$spp = $spp_db[0]->TotalBayar;
			}

		}

		$feeder = $this->feeder->getToken_feeder();
		$temp_token = $feeder['temp_token'];
		$temp_proxy = $feeder['temp_proxy'];

		if($data->IPK != -1){
			$NIM = ucfirst($data->NIM);

			$record = new stdClass();
			$record->id_smt = $data->Tahun;
			$record->id_reg_pd = $data->id_reg_pd;
			$record->id_stat_mhs = $data->Status;
			$record->ips = $data->IPS;
			$record->sks_smt = $data->SKS;
			$record->ipk = $data->IPK;
			$record->sks_total = $data->TotalSKS;
			$record->biaya_smt = $spp;

			$ID = $data->ID;

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
					'data' => array('ips' => $data->SKS,'sks_smt' => $data->SKS,'ipk' => $data->IPK,'sks_total' => $data->TotalSKS, 'biaya_smt' => $spp)
				);

				$table = 'kelas_kuliah';

				// action insert ke feeder
				$action = 'UpdateRecord';

				// insert tabel mahasiswa ke feeder
				$rdiktiup = $this->feeder->action_feeder($temp_token,$temp_proxy,$action,$table,$recordup);

				$sql = $this->krs_model->updateKhsFeeder($ID);
				if($sql){
	    			$this->session->set_flashdata('msg', 'Data Berhasil Di import');
					redirect('ademik/cetak_khs_prodi');
					echo json_encode('Data Berhasil di import');
				}else{
					/*$this->session->set_flashdata('msg', 'Data Berhasil di import tapi st_feeder gagal diupdate di khs');
					redirect('ademik/cetak_khs_prodi');*/
					echo json_encode('Data Berhasil di import tapi st_feeder gagal diupdate di khs');
				}
			} elseif ($error_code!=0){
				/*$this->session->set_flashdata('msg', $error_code."-".$error_desc." - ".json_encode($record));
				redirect('ademik/cetak_khs_prodi');*/
				echo json_encode($error_code."-".$error_desc." - ".json_encode($record));
			}else{
				$sql = $this->krs_model->updateKhsFeeder($ID);
				if($sql){
					/*$this->session->set_flashdata('msg', "Data Berhasil di import");
					redirect('ademik/cetak_khs_prodi');*/
					//echo "Data Berhasil Di import";
					echo json_encode('Data Berhasil di import');
				}else{
					/*$this->session->set_flashdata('msg', "Data Berhasil di import tapi st_feeder gagal diupdate di khs");
					redirect('ademik/cetak_khs_prodi');*/

					echo json_encode('Data Berhasil di import tapi st_feeder gagal diupdate di khs');
					//echo "Data Berhasil di import tapi st_feeder gagal diupdate di khs";
				}
			}
		}else{
			/*$this->session->set_flashdata('msg', "IPK bernilai 0 tidak dapat di import ke feeder");
			redirect('ademik/cetak_khs_prodi');*/
			echo json_encode('IPK bernilai 0 tidak dapat di import ke feeder');
		}
	}

	public function dataMahasiswa($semesterAkademik,$jurusan,$program,$angkatan)
	{
		$semesterAkademik = $this->cetak_khs_prodi_model->db->escape_str($semesterAkademik);
		$jurusan = $this->cetak_khs_prodi_model->db->escape_str($jurusan);
		$program = $this->cetak_khs_prodi_model->db->escape_str($program);
		$angkatan = $this->cetak_khs_prodi_model->db->escape_str($angkatan);
        $list = $this->cetak_khs_prodi_model->get_datatables($semesterAkademik,$jurusan,$program,$angkatan);
        $data = array();
        $no = $_POST['start']+1;
        foreach ($list as $field) {
        	$cekFeederKrs = $this->cetak_khs_prodi_model->cekFeederKrs($field->NIM,$field->Tahun);
        	if ($this->session->ulevel == 6 ) {
        		$hapus_khs_mhs = '';
        	} else {
	        	$hapus_khs_mhs= "
			   	  <form action='".base_url('ademik/cetak_khs_prodi/hapus_khs_mhs')."' method='post'>
			          <input type='hidden' name='id' value='".$field->ID."' readonly>
			          <input type='hidden' name='semesterAkademik' value='".$semesterAkademik."' readonly>
			          <input type='hidden' name='jurusan' value='".$jurusan."' readonly>
			          <input type='hidden' name='program' value='".$program."' readonly>
			          <input type='hidden' name='angkatan' value='".$angkatan."' readonly>
			          <input style='float:left; margin-right:5px;' type='submit' name='hapus_khs_mhs' value='Hapus'>
			      </form>";
			}

		    $ips = "<a href='".base_url('ademik/cetak_khs_prodi/prcIps/'.$semesterAkademik.'/'.$program.'/'.$jurusan.'/'.$angkatan.'/'.$field->NIM)."' style='color:red;'>".$field->IPS."</a>";

		    $ipk = "<a href='".base_url('ademik/cetak_khs_prodi/prcipk/'.$semesterAkademik.'/'.$program.'/'.$jurusan.'/'.$angkatan.'/'.$field->NIM)."' style='color:red;'>".$field->IPK."</a>";
   
   			$icst = "";  
		    $st = "<img src='".base_url('assets/images/btn_ok_16.png')."' border=0>";

		    if($field->stprc==1) $icst = $st;
		    else if($field->stprc==2) $icst = "$st$st";
		    else $icst = "<img src='".base_url('assets/images/btn_clc_16.png')."' border=0>";


		    if($field->Status=='C'){
			  $Status="Cuti";
			}else{
			  $Status="Aktif";
			}


			if($field->stprc==2 || $Status =="Cuti"){
				if($field->st_feeder > 0){
					$act_feeder = "<span style='color:green;'>Data Terkirim</span>";
				} else if($field->st_feeder == -1){
					$NIM=$field->NIM;
					$thn=$field->Tahun;
					$act_feeder = "<div id='feeder-".$NIM."'><span style='color:orange;'><a href='ademik.php?syxec=mhswkrs_form&act=krs&NIM=$NIM&thn=$thn'>Data Gagal Dikirim Ke DIKTI<br>Kerena Data sks semester tidak sesuai<br>dengan jumlah sks KRS yang di tempuh mahasiswa</a></span>
					<button class='btn btn-primary' onclick='kirimDikti(\"".$NIM."\",\"".$thn."\")'>Kirim Dikti</button>
					</div>";
					/*<form action='".base_url('ademik/cetak_khs_prodi/import_khs_feeder')."' method='post'>
				      <input type='hidden' name='nim' value='$NIM' readonly>
				      <input type='hidden' name='thn' value='$thn' readonly>
				      <input style='float:left; margin-right:5px;' type='submit' name='import_khs' value='Kirim Ke dikti'>
					</form>*/
				} else if($field->st_feeder == -2){
					$act_feeder = "<span style='color:red;'>IPS atau IPK Mahasiswa<br>Kosong (00.00)</span>";
				} else {
			  $act_feeder = "<div id='feeder-".$field->NIM."'>
			  <button class='btn btn-primary' onclick='kirimDikti(\"".$field->NIM."\",\"".$field->Tahun."\")'>Kirim Dikti</button>
			  </div>";
			  /*<form action='".base_url('ademik/cetak_khs_prodi/import_khs_feeder')."' method='post'>
			      <input type='hidden' name='nim' value='$field->NIM' readonly>
			      <input type='hidden' name='thn' value='$field->Tahun' readonly>
			      <input style='float:left; margin-right:5px;' type='submit' name='import_khs' value='Kirim Ke dikti'>
			  </form>*/
				}
			}else{
			  $act_feeder = "<span style='color:orange;'>IPK/IPS/blum di prc masih kosong</span>";
			}

            $row = array();
            $row[] = $no;
            $row[] = $field->NIM;
            $row[] = $field->Name.$hapus_khs_mhs;
            $row[] = $field->KodeProgram;
            $row[] = $field->Tahun;
            $row[] = $field->Status;
            $row[] = $field->SKS;
            $row[] = $field->SKSLulus;
            $row[] = $ips;
            $row[] = $field->TotalSKS;
            $row[] = $field->TotalSKSLulus;
            $row[] = $ipk;
            $row[] = $icst;
            if($field->st_feeder>0){
            	$st_khs = "Sudah";
            }else{
            	$st_khs = "belum";
            }
            $row[] = $st_khs;
            if($cekFeederKrs==true){
            	if($cekFeederKrs->st_feeder>0){
            		$st_krs = "Sudah";
	            }else{
	            	$st_krs = "belum";
	            }	
            }else{
            	$st_krs = "belum";
	        }
            
            $row[] = $st_krs;
            $row[] = $act_feeder;
            $no++;

			$data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cetak_khs_prodi_model->count_all($semesterAkademik,$jurusan,$program,$angkatan),
            "recordsFiltered" => $this->cetak_khs_prodi_model->count_filtered($semesterAkademik,$jurusan,$program,$angkatan),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}
	
}