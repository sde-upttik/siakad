<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	function __construct() {
	    parent::__construct();
	    $this->load->library('m_pdf');
	    $this->load->helper('security');
			date_default_timezone_set('Asia/Makassar');
			if ($this->session->userdata("unip") == null) {
				redirect("https://siakad2.untad.ac.id");
			}
			$this->app->checksession(); // untuk check session
			//$this->app->check_modul(); // untuk pengecekan modul
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}


	// Wawan Report
	public function cekFeederKrs($nim,$thn){
		$cekFeederKrs = $this->cetak_khs_prodi_model->cekFeederKrs($nim,$thn);
		if($cekFeederKrs!=false){
        	if($cekFeederKrs->st_feeder>0){
        		$st_krs = 1;
            }else{
            	$st_krs = 0;
            }
        }else{
        	$st_krs = 0;
        }
        return $st_krs;
	}

	public function cetak_khs_prodi($semester,$program,$jurusan,$angkatan,$fak){
		$data['page_title'] = '';

		$this->load->model('cetak_khs_prodi_model');

		$data['mhsw'] = $this->cetak_khs_prodi_model->getMhswKhs($semester,$program,$jurusan,$angkatan);
		$data['controller']=$this;
		$data['semester']=$semester;
		$data['jurusan']=$jurusan;
		$data['fakultas']=$fak;
		$html = $this->load->view('ademik/report/cetak_khs_prodi', $data,TRUE);

        $pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('P');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Cetak KHS.pdf', "D");

        exit();
	}

	// Wawan Report
	public function cetak_khs($semester,$program,$jurusan,$angkatan, $nim, $fak){
		$data['page_title'] = '';

		$this->load->model('cetak_khs_prodi_model');

		$data['mhsw'] = $this->cetak_khs_prodi_model->getMhswKhs1($semester,$program,$jurusan,$angkatan,$nim);
		$data['controller']=$this;
		$data['semester']=$semester;
		$data['jurusan']=$jurusan;
		$data['fakultas']=$fak;
		$html = $this->load->view('ademik/report/cetak_khs', $data,TRUE);

        $pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('P');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Cetak KHS.pdf', "D");

        exit();
	}

	public function pageBreak(){
		$pdf = $this->m_pdf->exp_pdf();

		$pdf->AddPage();
	}
	
	public function getFak($nim){
		$this->load->model('cetak_khs_prodi_model');
		$mhswFak = $this->cetak_khs_prodi_model->getMhswFak($nim);
		$qFak = $this->cetak_khs_prodi_model->getFak($mhswFak->KodeFakultas);
		$Fak = $qFak->Kode;
		if($Fak=="K2M"){
		       $Fak = "PROGRAM STUDI DI LUAR KAMPUS UTAMA<br>UNTAD MOROWALI";
		}elseif ($Fak=="K2T") {
			$Fak = "PROGRAM STUDI DI LUAR KAMPUS UTAMA<br>UNTAD TOJO UNA-UNA";
		}else{
			$Fak = "FAKULTAS ".strtoupper($qFak->Nama_Indonesia);
		}
		return $Fak;
	}

	public function getTahun($nim,$semester){
		$this->load->model('cetak_khs_prodi_model');
		$mhswFak = $this->cetak_khs_prodi_model->getMhswFak($nim);
		$qTahun = $this->cetak_khs_prodi_model->getTahun($mhswFak->KodeJurusan,$semester);
		$tahun = $qTahun->Nama;
		return $tahun;
	}

	public function getJur($jurusan){
		$this->load->model('cetak_khs_prodi_model');
		$qJur = $this->cetak_khs_prodi_model->getJur($jurusan);
		return $qJur;
	}

	public function getMatakuliah($KodeMK,$kdj){
		$this->load->model('cetak_khs_prodi_model');
		$matakuliah = $this->cetak_khs_prodi_model->getMatakuliah($KodeMK,$kdj);
		return $matakuliah->Nama_Indonesia;
	}

	public function detailKhs($semester,$nim){
		$this->load->model('cetak_khs_prodi_model');
		$detail = $this->cetak_khs_prodi_model->getDatakrsCetak($semester,$nim);
		return $detail;
	}

	public function getTotal($nim,$jurusan,$semester,$fakultas){
		$this->load->model('cetak_khs_prodi_model');
		$qTotal = $this->cetak_khs_prodi_model->getTotal($nim,$jurusan,$semester,$fakultas);
		return $qTotal;
	}

	public function getTtd($jurusan){
		$this->load->model('cetak_khs_prodi_model');
		$qTtd = $this->cetak_khs_prodi_model->getTtd($jurusan);
		return $qTtd;
	}

	// Wawan Report
	/*public function cetak_khs($semester,$program,$jurusan,$angkatan){
		$data['page_title'] = '';

		$html = $this->load->view('ademik/report/cetak_khs', $data,TRUE);

        $pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('P');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Cetak KHS.pdf', "D");

        exit();
	}*/

	// Wawan Report
	public function cetak_krs($thn,$nim){
		//example $data['rata'] = $this->db->query("SELECT t.NIM,m.Name,sum(IF(id_tes='1',nilai,0)) as Nilai_I,sum(IF(id_tes='2',nilai,0)) as Nilai_II,sum(IF(id_tes='3',nilai,0)) as Nilai_III,sum(nilai) as total,(sum(nilai)/3) as Rata_rata FROM tr_ikut_ujian t,mhsw m WHERE t.NIM=m.NIM group by t.NIM");
		//example$data['kategori'] = $this->db->query("select * from kategori_soal where id = '".$id_tes."'");

		// example $data['ujian'] = $ketgori;
		/*$data['page_title'] = '';

		$html = $this->load->view('ademik/report/cetak_krs', $data,TRUE);

        $pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('P');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Cetak KRS.pdf', "D");

        exit(); */


		$this->load->model('cetak_krs_model');
		$this->load->model('ipk_model');

       	$ulevel=$this->session->ulevel;
		$uname=$this->session->uname;
		$unip=$this->session->unip;
		$kd1 = "";
		$kdf = "";
		if($ulevel==5){
		  	$kd1 = $this->cetak_krs_model->getKodeFakultas('_v2_adm_fak',$unip);
		  	$kdf = $this->cetak_krs_model->getKodeFakultas1('_v2_mhsw',$nim);
		}else if($ulevel==7){
		  	$kd1 = $this->cetak_krs_model->getKodeJurusan('_v2_adm_jur',$unip);
		  	$kdf = $this->cetak_krs_model->getKodeJurusan1('_v2_mhsw',$nim);
		}

		if($kd1 == $kdf || $ulevel==1 || $ulevel==6 || ($nim==$unip) ){
			$data['amhsw']=  $this->cetak_krs_model->getDataMhsw($nim);
			$data['Fak']=  $this->cetak_krs_model->getFakultas($data['amhsw']->KodeFakultas);
			$data['ajur']=  $this->cetak_krs_model->getQueryJurusan($data['amhsw']->KodeJurusan);
			//$data['afak']=  $this->cetak_krs_model->getQueryFakultas($data['amhsw']->KodeFakultas);

			$tbl = "_v2_krs$thn";

			$data['detailKrs'] = $this->cetak_krs_model->getDetailKrs($nim,$thn,$tbl);

			$data['ttd'] = $this->ipk_model->getTtd($data['amhsw']->KodeJurusan,$data['amhsw']->KodeProgram);
			//$q=mysql_query("select * from jurusan j, mhsw m where j.Kode='$kdj'");

			$data['page_title'] = '';
	        $data['nim'] = $nim;
	        $data['semesterAkademik'] = $thn;
	        $data['controller']=$this;
			$this->load->library('pdf');
			$html = $this->load->view('ademik/report/cetak_krs', $data,TRUE);

	        $filename = "KRS";
 
	        $this->pdf->create($html, $filename, 'potrait');

	        $this->load->view('ademik/report/cetak_krs');
		}else{
			$data['error']="Maaf, Anda tidak diperkenangkan Mengakses KRS ini.";

			$this->load->view('temp/head');
			$this->load->view('ademik/mhswkrs',$data);
			$this->load->view('temp/footers');
		}
	}



	// Fandu Report
	public function cetak_transkrip_nilai_kliring(){
		$data['page_title'] = '';
		$html = $this->load->view('ademik/report/cetak_transkrip_kliring', $data,TRUE);

        $pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('P');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Cetak Transkrip Nilai.pdf', "D");

        exit();
	}

	// Fandu Report
	public function cetak_kujian(){
		$data['page_title'] = '';
		$html = $this->load->view('ademik/report/cetak_kujian', $data,TRUE);

        $pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('P');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Cetak KRS.pdf', "D");

        exit();
	}

	// Fandu Report
	public function cetak_daftar_hadir(){
		$data['page_title'] = '';
		$html = $this->load->view('ademik/report/cetak_daftar_hadir', $data,TRUE);

        $pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('P');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Cetak KRS.pdf', "D");

        exit();
	}

	// Rocky Report
	public function cetak_matkul_per_jenis(){

		$idKurikulum = $this->security->xss_clean($this->input->post('idKurikulum'));
		$nmJurusan = $this->security->xss_clean($this->input->post('namaJurusan'));

		$this->load->model('matakuliah_jns_model');

		$data['namaJurusan'] = $nmJurusan;
		$data['kurikulum'] = $this->matakuliah_jns_model->getDetailKurikulumById($idKurikulum);
		$data['tabel'] = $this->matakuliah_jns_model->getDetailTabel($idKurikulum);

		$html = $this->load->view('ademik/report/cetak_matkul_per_jenis', $data,TRUE);

        $pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('P');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Cetak Mata Kuliah Perjenis.pdf', "D");

        exit();

	}

	// Rocky Report
	public function cetak_matkul_per_semester(){

		$idKurikulum = $this->security->xss_clean($this->input->post('idKurikulum'));
		$nmJurusan = $this->security->xss_clean($this->input->post('namaJurusan'));

		$this->load->model('matakuliah_smtr_model');

		$data['namaJurusan'] = $nmJurusan;
		$data['kurikulum'] = $this->matakuliah_smtr_model->getDetailKurikulumById($idKurikulum);
		$data['tabel'] = $this->matakuliah_smtr_model->getMaxTabel($idKurikulum);

		$urutan = 1;

		for ($i=1; $i<=$data['tabel']->JmlTabel; $i++){
			$data['detailTabel'][$urutan++] = $this->matakuliah_smtr_model->getDetailTabel($idKurikulum,$i);
		}

		$html = $this->load->view('ademik/report/cetak_matkul_per_semester', $data,TRUE);

        $pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('P');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Cetak Mata Kuliah Persemester.pdf', "D");

        exit();

	}

	// Fadli Report
	public function cetak_beban_menagajar()
	{
		$this->load->model('Absensi_model');

		$IDJADWAL	= $this->security->xss_clean($this->input->post('IDJADWAL'));
		$KodeMK		= $this->security->xss_clean($this->input->post('KodeMK'));
		$Tahun		= $this->security->xss_clean($this->input->post('Tahun'));
		$IDDosen	= $this->security->xss_clean($this->input->post('IDDosen'));
		$pangkat	= $this->security->xss_clean($this->input->post('pangkat'));
		$jabatan	= $this->security->xss_clean($this->input->post('jabatan'));
 
		$matakuliah_pendamping		= $this->Absensi_model->getDataBebanMengajarDosen2($IDJADWAL, $IDDosen, $Tahun, $KodeMK);
		$matakuliah_pengampuh		= $this->Absensi_model->getDataBebanMengajarDosen1($IDJADWAL, $IDDosen, $Tahun, $KodeMK);
 
		$data_bind 	= array(
							'matakuliah_pengampuh' 	=> $matakuliah_pengampuh,
							'matakuliah_pendamping' => $matakuliah_pendamping,
							'tahun' 				=> $Tahun,
							 'pangkat' 				=> $pangkat, 
							 'jabatan' 				=> $jabatan
							);

		$html 		= $this->load->view('ademik/absensi_/cetak_beban_menagajar_dosen', $data_bind, TRUE);

		$pdf 		= $this->m_pdf->exp_pdf();

        $pdf->AddPage('P');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Beban_mengajar_dosen.pdf', "D");

        exit();

	}

	public function cetak_absensi_harian_mahasiswa()
	{
		$this->load->model('Absensi_model');

		$IDJADWAL	= $this->security->xss_clean($this->input->post('IDJADWAL'));

		$Tahun		= $this->security->xss_clean($this->input->post('Tahun'));

		$respon		= $this->Absensi_model->cetak_absen_harian_mahasiswa($Tahun, $IDJADWAL);
        $data_asdos	= $this->Absensi_model->data_asisten_dosen($IDJADWAL);

		$data_bind 	= array(
							'data_absen' => $respon,
							'data_asdos' => $data_asdos,
							);

		$html 		= $this->load->view('ademik/absensi_/cetak_absen_harian_mahasiswa', $data_bind, TRUE);

		$pdf 		= $this->m_pdf->exp_pdf();

        $pdf->AddPage('P');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Absen mahasiswa.pdf', "D");

        exit();

	}

	// Fadli Report
	public function cetak_absensi_mahasiswa_5()
	{
		$this->load->model('Absensi_model');

		$start		= $this->security->xss_clean($this->input->post('start'));

		$end		= $this->security->xss_clean($this->input->post('end'));

		$IDJADWAL	= $this->security->xss_clean($this->input->post('IDJADWAL'));

		$Tahun		= $this->security->xss_clean($this->input->post('Tahun'));

		$respon_1	= $this->Absensi_model->cetak_absen_mahasiswa_5($Tahun, $IDJADWAL);

		$respon_2	= $this->Absensi_model->data_asisten_dosen($IDJADWAL);

		$data_bind 	= array(
							'data_jadwal'	 	 => $respon_1,
							'data_asisten_dosen' => $respon_2,
							'start' 			 => $start,
							'end'				 => $end,
							);

		$html 		= $this->load->view('ademik/absensi_/cetak_absen_mahasiswa_1_5', $data_bind, TRUE);

		$pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('L');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Absen Mahasiswa Pertemuan'.$start.'-'.$end.'.pdf', "D");

        exit();

	}

    public function cetak_absensi_mahasiswa_16()
	{
		$this->load->model('Absensi_model');

		$IDJADWAL	= $this->security->xss_clean($this->input->post('IDJADWAL'));
        $Tahun		= $this->security->xss_clean($this->input->post('Tahun'));

		$respon_1	= $this->Absensi_model->cetak_absen_mahasiswa_5($Tahun, $IDJADWAL);
		$respon_2	= $this->Absensi_model->data_asisten_dosen($IDJADWAL);

		$data_bind 	= array(
							'data_jadwal'	 	 => $respon_1,
							'data_asisten_dosen' => $respon_2,
							);

		$html = $this->load->view('ademik/absensi_/cetak_absen_mahasiswa_16',$data_bind,TRUE);

		$pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('L');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Absen mahasiswa 1-16.pdf', "D");

        exit();
	}


	// Fadli Report
	public function cetak_absensi_dosen()
	{
		$this->load->model('Absensi_model');

		$IDJADWAL	= $this->security->xss_clean($this->input->post('IDJADWAL'));

		$Tahun		= $this->security->xss_clean($this->input->post('Tahun'));

		$respon_1	= $this->Absensi_model->cetak_absen_dosen_harian($IDJADWAL);

		$respon_2	= $this->Absensi_model->data_asisten_dosen($IDJADWAL);

		$data_bind 	= array(
							'data_jadwal'	 	 => $respon_1,
							'data_asisten_dosen' => $respon_2,
							);

		$html 		= $this->load->view('ademik/absensi_/cetak_absen_dosen', $data_bind, TRUE);

		$pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('L');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Absen Dosen.pdf', "D");

        exit();
	}

	// Fadli Report
	public function cetak_rekap_absensi_dosen()
	{
		$this->load->model('Absensi_model');

		$IDJADWAL	= $this->security->xss_clean($this->input->post('IDJADWAL'));

		$Tahun		= $this->security->xss_clean($this->input->post('Tahun'));

		$respon_1	= $this->Absensi_model->cetak_rekap_dosen($IDJADWAL);

		$respon_2	= $this->Absensi_model->data_asisten_dosen($IDJADWAL);

		$respon_3	= $this->Absensi_model->data_absen_dosen($IDJADWAL, $Tahun);

		$data_bind 	= array(
							'data_jadwal' 		 => $respon_1,
							'data_asisten_dosen' => $respon_2,
							'data_absen_dosen' 	 => $respon_3,
							);

		$html 		= $this->load->view('ademik/absensi_/cetak_rekap_absen_dosen', $data_bind, TRUE);

		$pdf 		= $this->m_pdf->exp_pdf();

        $pdf->AddPage('L');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Rekap Absen Dosen.pdf', "D");

        exit();
	}

	// Fadli Report
	public function cetak_rekap_absensi_mahasiswa()
	{
		$this->load->model('Absensi_model');

		$IDJADWAL	= $this->security->xss_clean($this->input->post('IDJADWAL'));

		$Tahun		= $this->security->xss_clean($this->input->post('Tahun'));

		$respon		= $this->Absensi_model->cetak_rekap_mahasiswa($Tahun, $IDJADWAL);

		$tatap_muka = $this->Absensi_model->jumlah_tatap_muka($IDJADWAL);

		$data_asdos	= $this->Absensi_model->data_asisten_dosen($IDJADWAL);

		$data_bind 	= array(
							'data_rekap' => $respon,
							'tatap_muka' => $tatap_muka,
							'data_asdos' => $data_asdos,
							);

		$html 		= $this->load->view('ademik/absensi_/cetak_rekap_absen_mahasiswa', $data_bind, TRUE);

		$pdf 		= $this->m_pdf->exp_pdf();

        $pdf->AddPage('L');
        $pdf->pagenumPrefix 	= 'Halaman ';
		$pdf->nbpgPrefix 		= ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Rekap Absen mahasiswa.pdf', "D");

        exit();
	}

	// Fadli Report
	public function cetak_cpna()
	{
		$this->load->model('Absensi_model');

		$IDJADWAL 	= $this->security->xss_clean($this->input->post('IDJADWAL'));
        $Tahun 	 	= $this->security->xss_clean($this->input->post('Tahun'));

		$respon 	= $this->Absensi_model->cetak_cpna($Tahun, $IDJADWAL);
        $data_asdos	= $this->Absensi_model->data_asisten_dosen($IDJADWAL);

        $data_bind 	= [
                        'data_cpna'     => $respon,
                        'data_asdos'    => $data_asdos,
                      ];

		$html 		= $this->load->view('ademik/absensi_/cetak_cpna', $data_bind, TRUE);
		// $pdf 		= $this->m_pdf->exp_pdf();
		$pdf 		= $this->m_pdf->exp_pdf();

        $pdf->AddPage('L');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('CPNA.pdf', "D");

        exit();
	}

	// Fadli Report
	public function new_cetak_cpna()
	{
		$this->load->model('Absensi_model');
		$kdf 			= $this->session->userdata("kdf");

		$IDJADWAL 		= $this->security->xss_clean($this->input->post('IDJADWAL'));
        $Tahun 	 		= $this->security->xss_clean($this->input->post('Tahun'));
        $Kodejurusan 	= $this->security->xss_clean($this->input->post('kdj'));

        $dtDpna 		= $this->Absensi_model->cetak_cpna($Tahun, $IDJADWAL); 	
        $dtRange		= $this->Absensi_model->getRangeNilaiTester($kdf, $Kodejurusan);
        $dtAsdos		= $this->Absensi_model->data_asisten_dosen($IDJADWAL);

        $data_bind 		= [
                        	'data_cpna'     => $dtDpna,
                        	'data_asdos'    => $dtAsdos,
                        	'data_range'	=> $dtRange
                      	  ];

		$html 			= $this->load->view('ademik/absensi_/new_cetak_dpna', $data_bind, TRUE);
		
		$this->load->view('ademik/absensi_/new_cetak_dpna');
		
		$page_size		= array(218,279);
		$pdf 			= $this->m_pdf->exp_pdf($page_size);

        $pdf->AddPage('L');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix 	= ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('DPNA.pdf', "D");

        exit();
	}

	public function new_cetak_cpna_tester()
	{
		$this->load->model('Absensi_model');
		$kdf 			= $this->session->userdata("kdf");

		$IDJADWAL 		= $this->security->xss_clean($this->input->post('IDJADWAL'));
        $Tahun 	 		= $this->security->xss_clean($this->input->post('Tahun'));
        $Kodejurusan 	= $this->security->xss_clean($this->input->post('kdj'));

        $dtDpna 		= $this->Absensi_model->cetak_cpna($Tahun, $IDJADWAL); 	
        $dtRange		= $this->Absensi_model->getRangeNilaiTester($kdf, $Kodejurusan);
        $dtAsdos		= $this->Absensi_model->data_asisten_dosen($IDJADWAL);

        $data_bind 		= [
                        	'data_cpna'     => $dtDpna,
                        	'data_asdos'    => $dtAsdos,
                        	'data_range'	=> $dtRange
                      	  ];

		$html 			= $this->load->view('ademik/absensi_/new_cetak_dpna_tester', $data_bind, TRUE);
		
		$this->load->view('ademik/absensi_/new_cetak_dpna');
		
		$page_size		= array(218,279);
		$pdf 			= $this->m_pdf->exp_pdf($page_size);

        $pdf->AddPage('L');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix 	= ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('DPNA.pdf', "D");

        exit();
	}



		public function cetaktest()
	{

        $data_bind 	= "";
		$html 		= $this->load->view('ademik/absensi_/helloworld',$data_bind, TRUE);
		$page_size	= array(218,279);
		$pdf 		= $this->m_pdf->exp_pdf($page_size);

        $pdf->AddPage('L');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix 	= ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('cek.pdf', "D");

        exit();
	}


	//Mekel riport
	public function cetak_bayar_kkn(){

		$this->load->model('kkn_modeladmin');


//		$data['angkatan'] = "84";

		$data['nama'] = $this->security->xss_clean($this->input->post('nama'));
		$data['nim'] = $this->security->xss_clean($this->input->post('nim'));


		$html = $this->load->view('ademik/report/cetak_bukti_kkn', $data,TRUE);

        $pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('P');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Bukti Pembayaran KKN.pdf', "D");

        exit();

	}

}
