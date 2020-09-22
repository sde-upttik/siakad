<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report2 extends CI_Controller {
	// Report 2 ini merupakan Teknik ke 2 untuk membuat pdf

	function __construct() {
	    parent::__construct();
	    $this->load->helper('security');
		date_default_timezone_set('Asia/Makassar');
		if ($this->session->userdata("unip") == null) {
			redirect("https://siakad2.untad.ac.id");
		}
		$this->app->checksession(); // untuk check session
		$this->app->check_modul(); // untuk pengecekan modul
		$this->load->library('encryption');
		$this->load->library('ciqrcode'); //pemanggilan library QR CODE
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	// Wawan Report
	public function cetak_khs(){
		$data['page_title'] = '';
		$html = $this->load->view('ademik/report/cetak_khs', $data,TRUE);

        $pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('P');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Cetak KRS.pdf', "D");

        exit();
	}

	// Wawan Report
	/*public function cetak_krs(){
		//example $data['rata'] = $this->db->query("SELECT t.NIM,m.Name,sum(IF(id_tes='1',nilai,0)) as Nilai_I,sum(IF(id_tes='2',nilai,0)) as Nilai_II,sum(IF(id_tes='3',nilai,0)) as Nilai_III,sum(nilai) as total,(sum(nilai)/3) as Rata_rata FROM tr_ikut_ujian t,mhsw m WHERE t.NIM=m.NIM group by t.NIM");
		//example$data['kategori'] = $this->db->query("select * from kategori_soal where id = '".$id_tes."'");

		// example $data['ujian'] = $ketgori;
		$data['page_title'] = '';

		$html = $this->load->view('ademik/report/cetak_krs', $data,TRUE);

        $pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('P');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Cetak KRS.pdf', "D");

        exit();
	}
*/
	// Fandu Report
	public function cetak_transkrip_nilai_kliring(){

		// $this->app->checksession();
		$this->app->check_modul();

		$ulevel=$this->session->userdata('ulevel');
		$kdf=$this->session->userdata('kdf');
		$kdj=$this->session->userdata('kdj');
		$unip=$this->session->userdata('unip');

		$dataSearch = $this->uri->segment(5);

		if ($ulevel == 1 or $ulevel == 5 or $ulevel == 7 || $ulevel == 6 ){
			$this->detail_kliring($dataSearch);
		} else if ($ulevel == 4 and $dataSearch == $unip){
			$this->detail_kliring($dataSearch);
		} /*else {
			$data['title'] = "Peringatan";
			$data['text'] = "Anda Tidak Bisa Print Transkrip Anda";

			$this->load->view('temp/head');
			$this->load->view('error_page/message_error', $data);
			$this->load->view('temp/footers');
		}*/

	}

	private function detail_kliring($dataSearch){
		if (empty($dataSearch)) {

			$data['footerSection'] = "<script type='text/javascript'>
 				swal({
					title: 'Pemberitahuan',
					type: 'warning',
					html: true,
					text: 'Silahkan mengisi terlebih dahulu NIM pada Text Input',
					confirmButtonColor: '#f7cb3b',
				});
		    </script>";

			$this->load->view('dashbord',$data);

		} else {
			//$GetField = $this->app->GetFields("kli_wisuda.st_kliring,m.NIM, m.Name, m.id_reg_pd, j.Kode kdj, j.Nama_Indonesia as nmj, f.Kode kdf, f.Nama_Indonesia as nmf, jp.Nama as jenjang, st_mhsw.Nama as status, m.StatusAwal", "_v2_mhsw m left join _v2_jurusan j on m.KodeJurusan=j.Kode left join fakultas f on j.KodeFakultas=f.Kode left join _v2_jenjangps jp on j.Jenjang=jp.Kode left join _v2_statusmhsw st_mhsw on m.status=st_mhsw.Kode left join _v2_kliring_wisuda kli_wisuda on m.NIM=kli_wisuda.NIM", "m.NIM", "$dataSearch")->row(); // untuk dosen pengampu dan asisten dosen

			$detailmhsw = $this->app->GetFields("Name, TempatLahir, TglLahir, m.KodeFakultas, m.KodeJurusan, m.TahunAkademik, IPK, TotalSKS, m.Predikat, m.TglSKYudisium, PredikatLulus,
			j.Nama_Indonesia as nmj, f.Nama_Indonesia as nmf, j.Nama_English as nmj_ing, f.Nama_English as nmf_ing,
			j.TTPejabat1, j.TTPejabat2, j.TTPejabat3, j.TTJabatan1, j.TTJabatan2, j.TTJabatan3, j.TTnippejabat1, j.TTnippejabat2, j.TTnippejabat3,
			j.TTJabatanTn1, j.TTJabatanTn2, j.TTJabatanTn3, j.TTPejabatTn1, j.TTPejabatTn2, j.TTPejabatTn3, j.TTnippejabatTn1, j.TTnippejabatTn2, j.TTnippejabatTn3,
			JudulTA, JudulTA2", "_v2_mhsw m join _v2_jurusan j on m.KodeJurusan=j.Kode left join fakultas f on j.KodeFakultas=f.Kode", "NIM", "$dataSearch")->row();

			$name = $detailmhsw->Name;
			$tmptlahir = $detailmhsw->TempatLahir;
			$tgllahir = $this->app->tanggal_indonesia(date('d-m-Y',strtotime($detailmhsw->TglLahir)));
			$tgllahir_ing = $this->app->tanggal_inggris(date('dS-m-Y',strtotime($detailmhsw->TglLahir)));
			$judulTA = $detailmhsw->JudulTA;
			$judulTA2 = $detailmhsw->JudulTA2;
			$totsks = $detailmhsw->TotalSKS;
			$ipk = $detailmhsw->IPK;
			$kode_fak = $detailmhsw->KodeFakultas;
			$kode_prodi = $detailmhsw->KodeJurusan;
			$nama_fak = $detailmhsw->nmf;
			$nama_fak_ing = $detailmhsw->nmf_ing;
			
			// Update k2m morowalia c201
			if($kode_prodi == 'K2MC201' && $detailmhsw->TahunAkademik >= '2015' ){
				$nama_prodi = 'Manajemen (Kampus Kab.Morowali)';
			}else{
				$nama_prodi = $detailmhsw->nmj;				
			}
			
			
			$nama_prodi_ing = $detailmhsw->nmj_ing;
			$nmJabatan1 = $detailmhsw->TTJabatan1;
			$nmJabatan2 = $detailmhsw->TTJabatan2;
			$nmJabatan3 = $detailmhsw->TTJabatan3;
			$TTJabatan1 = $detailmhsw->TTPejabat1;
			$TTJabatan2 = $detailmhsw->TTPejabat2;
			$TTJabatan3 = $detailmhsw->TTPejabat3;
			$TTnippejabat1 = $detailmhsw->TTnippejabat1;
			$TTnippejabat2 = $detailmhsw->TTnippejabat2;
			$TTnippejabat3 = $detailmhsw->TTnippejabat3;
			$tgllulus = $detailmhsw->TglSKYudisium;
			$tgllulus_ing = $detailmhsw->TglSKYudisium;

			$predikat = $detailmhsw->Predikat;

			if($predikat=='U' or $predikat==''){
         	/*if ($ipk>=2.00 && $ipk<=2.75) {
				 			$keterangan = "MEMUASKAN";
				 			$keterangane = "Satisfy";
				 	} else if ($ipk>=2.76 && $ipk<=3.50) {
				 			$keterangan = "SANGAT MEMUASKAN";
				 			$keterangane = "Very Satisfactory";
				 	} else if ($ipk>=3.51 && $ipk<=4.00) {
				 			$keterangan = "PUJIAN";
				 			$keterangane = "Cum Laude";
				 	} else {
				 			$keterangan = "TIDAK DIKETAHUI";
				 			$keterangane = "Not Known";
				 	}*/
					$keterangan = "";
					$keterangane = "";
		    } else {
		        $keterangan = $predikat;
		        $keterangane = $detailmhsw->PredikatLulus;
		    }

			$tahun_khs = $this->app->GetField("Tahun", "_v2_khs", "NIM='$dataSearch'", "")->result(); // untuk pengecekan tahun di tabel _v2_khs

			$resultarray = array();

			$tskslulus = 0;
			$t_k_n = 0;

			foreach ($tahun_khs as $khs){
				$tahun = $khs->Tahun;

				$kondisi = "k.NIM='$dataSearch' and k.Tahun='$tahun' and k.NotActive='N' and bobot>0 group by k.NamaMK order by mk.urutan,mk.KodeJenisMK,k.NamaMK, k.KodeMK desc, k.Tahun asc";

				/*if ($tahun == "20161"){
					$tahun = "";
				}*/

				$tahun_khs_baru = $this->app->GetField("k.IDMK, k.NamaMK, k.GradeNilai, k.Bobot, k.SKS, mk.Nama_English as MKE, mk.urutan", "_v2_krs$tahun k left outer join _v2_matakuliah mk on k.IDMK=mk.IDMK", "$kondisi", "")->result(); // untuk daftar matakuliah

				foreach ($tahun_khs_baru as $row){

					$tskslulus = $tskslulus + $row->SKS; // Total sks
					$k_n = $row->SKS * $row->Bobot; // Bobot x SKS
					$t_k_n = $t_k_n + $k_n; // Total K x N

					// echo $row->IDMK." - ".$row->urutan." -  - ".$row->SKS." - ".$row->Bobot." - ".$row->GradeNilai." - ".$row->SKS * $row->Bobot." - Keterangan<br>";
					$table = "<td style='border-bottom: 0px;border-top: 0px;'>".$row->NamaMK." / <i>".$row->MKE."</i></td>
						<td align='center' style='border-bottom: 0px;border-top: 0px;'>".$row->SKS."</td>
						<td align='center' style='border-bottom: 0px;border-top: 0px;'>".$row->Bobot."</td>
						<td align='center' style='border-bottom: 0px;border-top: 0px;'>".$row->GradeNilai."</td>
						<td align='center' style='border-bottom: 0px;border-top: 0px;'>".$k_n."</td>";
					$resultarray = array_merge($resultarray, array($table => $row->urutan));
				}
			}

			$kondisi = "k.NIM='$dataSearch' and k.NotActive='N' and bobot>0 group by k.NamaMK order by mk.urutan,mk.KodeJenisMK,k.NamaMK, k.KodeMK desc, k.Tahun asc";

			// atas nilai transfer mahasiswa
			$tahun_khs_baru = $this->app->GetField("k.IDMK, k.NamaMK, k.GradeNilai, k.Bobot, k.SKS, mk.Nama_English as MKE, mk.urutan", "_v2_krsTR k left outer join _v2_matakuliah mk on k.IDMK=mk.IDMK", "$kondisi", "")->result(); // untuk daftar matakuliah

			foreach ($tahun_khs_baru as $row){

				$tskslulus = $tskslulus + $row->SKS; // Total sks
				$k_n = $row->SKS * $row->Bobot; // Bobot x SKS
				$t_k_n = $t_k_n + $k_n; // Total K x N

				//echo $row->IDMK." - ".$row->urutan." -  - ".$row->countRow." - ".$row->Bobot." - ".$row->GradeNilai." - ".$row->SKS * $row->Bobot." - Keterangan<br>";
				$table = "<td style='border-bottom: 0px;border-top: 0px;'>".$row->NamaMK." / <i>".$row->MKE."</i></td>
					<td align='center' style='border-bottom: 0px;border-top: 0px;'>".$row->SKS."</td>
					<td align='center' style='border-bottom: 0px;border-top: 0px;'>".$row->Bobot."</td>
					<td align='center' style='border-bottom: 0px;border-top: 0px;'>".$row->GradeNilai."</td>
					<td align='center' style='border-bottom: 0px;border-top: 0px;'>".$k_n."</td>";

				if($row->urutan == 40){
					$table .= '<div class="page-break"></div>';
				}

				$resultarray = array_merge($resultarray, array($table => $row->urutan));
			}
			// bawah nilai transfer mahasiswa

			asort($resultarray); // ascending berasarjkan value
			//ksort($resultarray); // ascending berasarjkan key

			$i = 1;
			$detailnilai = "";
			$detailnilai1 = "";
			foreach($resultarray as $x => $x_value) {
				//echo "Key=" . $x . ", Value=" . $x_value."<br>";
				if ($i <= 40){
					$detailnilai .= "<tr>
							<td align='center' style='border-bottom: 0px;border-top: 0px;'>$i</td>".$x."<td style='border-bottom: 0px;border-top: 0px;'></td>
						</tr>";
				} else if (41<= $i){
					$detailnilai1 .= "<tr>
							<td align='center' style='border-bottom: 0px;border-top: 0px;'>$i</td>".$x."<td style='border-bottom: 0px;border-top: 0px;'></td>
						</tr>";
				}

				$i++;
			}


			//$data['jumlah_array'] = $i;

			//$data['nim'] = $dataSearch;

			$data['footerSection'] = "<script type='text/javascript'>
 				$('#matakuliah').DataTable();
		    </script>";
		}

		$a['nim'] = $dataSearch;
		$a['name'] = $name;
		$a['tmptlahir'] = $tmptlahir;
		$a['tgllahir'] = $tgllahir;
		$a['tgllahir_ing'] = $tgllahir_ing;
		$a['judulTA'] = $judulTA;
		$a['judulTA2'] = $judulTA2;
		$a['nama_fak'] = $nama_fak;
		$a['nama_prodi'] = $nama_prodi;
		$a['nama_fak_ing'] = $nama_fak_ing;
		$a['nama_prodi_ing'] = $nama_prodi_ing;
		$a['ipk'] = $ipk;
		$a['detailnilai'] = $detailnilai;
		$a['detailnilai1'] = $detailnilai1;
		$a['nmpejabat1'] = $nmJabatan1;
		$a['nmpejabat2'] = $nmJabatan2;
		$a['nmpejabat3'] = $nmJabatan3;
		$a['ttjabatan1'] = $TTJabatan1;
		$a['ttjabatan2'] = $TTJabatan2;
		$a['ttjabatan3'] = $TTJabatan3;
		$a['nippejabat1'] = $TTnippejabat1;
		$a['nippejabat2'] = $TTnippejabat2;
		$a['nippejabat3'] = $TTnippejabat3;

		$a['TTJabatanTn1'] = $detailmhsw->TTJabatanTn1;
		$a['TTJabatanTn2'] = $detailmhsw->TTJabatanTn2;
		$a['TTJabatanTn3'] = $detailmhsw->TTJabatanTn3;
		$a['TTPejabatTn1'] = $detailmhsw->TTPejabatTn1;
		$a['TTPejabatTn2'] = $detailmhsw->TTPejabatTn2;
		$a['TTPejabatTn3'] = $detailmhsw->TTPejabatTn3;
		$a['TTnippejabatTn1'] = $detailmhsw->TTnippejabatTn1;
		$a['TTnippejabatTn2'] = $detailmhsw->TTnippejabatTn2;
		$a['TTnippejabatTn3'] = $detailmhsw->TTnippejabatTn3;
		$a['kode_fak'] = $kode_fak;

		$a['tglnow'] = $this->app->tanggal_indonesia(date('d m Y'));
		$a['tskslulus'] = $tskslulus;

		if ( $tgllulus == '0000-00-00' ) {
			$a['tgllulus'] = '';
		} else {
			$a['tgllulus'] = $this->app->tanggal_indonesia(date('d-m-Y',strtotime($tgllulus)));
			$a['tgllulus_ing'] = $this->app->tanggal_inggris(date('dS-m-Y',strtotime($tgllulus_ing)));
		}

		/*$a['tgllulus_ing'] = $this->app->tanggal_inggris(date('d-m-Y',strtotime($tgllulus_ing)));*/

 
		$config['cacheable']    = true; //boolean, the default is true
		$config['cachedir']     = ''; //string, the default is application/cache/
		$config['errorlog']     = ''; //string, the default is application/logs/
		$config['quality']      = true; //boolean, the default is true
		$config['size']         = '4'; //interger, the default is 1024
		$config['black']        = array(224,255,255); // array, default is array(255,255,255)
		$config['white']        = array(70,130,180); // array, default is array(0,0,0)
		$this->ciqrcode->initialize($config);

		$image_name=$dataSearch.'.png'; //buat name dari qr code sesuai dengan nim

		$params['data'] = $this->encryption->encrypt("NIM:".$dataSearch."-Nama:".$name."-totalskslulus:".$tskslulus."-totalnilai:".$t_k_n."-ipk:".$ipk); //data yang akan di jadikan QR CODE
		$params['level'] = 'H'; //H=High
		$params['size'] = 10;
		$params['savename'] = FCPATH.'assets/images/qrcode/'.$image_name; //simpan image QR CODE ke folder assets/images/
		$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

		$a['t_k_n'] = $t_k_n;
		$a['keterangan'] = $keterangan;
		$a['keterangane'] = $keterangane;
		$a['enkripsi'] = $this->encryption->encrypt("NIM:".$dataSearch."-Nama:".$name."-totalskslulus:".$tskslulus."-totalnilai:".$t_k_n."-ipk:".$ipk);

		$a['countRow'] = count($resultarray);
		
		$this->load->library('pdf');

		$html=$this->load->view('ademik/report/cetak_transkrip_kliring', $a, TRUE);
		$filename = "Transkrip Nilai $dataSearch";
		// $this->pdf->create($html, $filename, 'potrait');
		$this->pdf->create_costum($html, $filename, 'potrait', 'legal');
	}

	// Fandu Report
	public function cetak_kujian(){

		// $this->app->checksession();
		$this->app->check_modul();

		$nim = $this->uri->segment(5);
		$a['identitas'] = $nim;
	  	$this->load->library('pdf');

	  	$html=$this->load->view('ademik/report/cetak_kujian', "", TRUE);
	  	$filename = "Kartu Ujian $nim";
        $this->pdf->create($html, $filename, 'lendscape');

	}

	public function daftar_mhsw($jid,$thn) {
		/*$query = "select IDJADWAL from _v2_jadwal where ID='$idjadwal'"; // Modif 08 - 2006 and Tahun='$thn'
		$row = $this->db->query($query)->row();

		$jid = $row->IDJADWAL;*/
		/*$s = "select m.NIM, Name, GradeNilai, Bobot from _v2_krs k, _v2_mhsw m where IDJadwal='$jid' and Tahun='$thn' and k.NIM=m.NIM"; // Modif 08 - 2006 and Tahun='$thn'
		if($thn!='20161'){*/
			$s = "select m.NIM, Name, GradeNilai, Bobot, hr_1, hr_2, hr_3, hr_4, hr_5, hr_6, hr_7, hr_8, hr_9, hr_10, hr_11, hr_12, hr_13, hr_14, hr_15, hr_16 from _v2_krs$thn k, _v2_mhsw m where IDJadwal='$jid' and Tahun='$thn' and k.st_wali='1' and k.NIM=m.NIM ORDER BY m.NIM ASC"; // Modif 08 - 2006 and Tahun='$thn'
		//}

		$r = $this->db->query($s)->result();
		return $r;
	}

	// Fandu Report
	public function cetak_daftar_hadir(){

		// $this->app->checksession();
		$this->app->check_modul();

		$idjad = $this->uri->segment(5);
		$thn = $this->uri->segment(6);

		$getone = $this->app->getOnRow("IDJadwal", "_v2_jadwal", "ID='$idjad'");
		$idjadwal = $getone->IDJadwal;

		$detailJadwal = $this->db->query("select jd.IDJADWAL, jd.KodeMK, jd.Tahun, jd.KodeFakultas, f.Nama_Indonesia as nmf, jd.KodeJurusan, j.Nama_Indonesia as nmj, jd.SKS, jd.Program, jd.KodeKampus,
		jd.KodeRuang, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, jd.NamaMK as MK, concat(d.Name, ', ', d.Gelar) as Dosen,
		pr.Nama_Indonesia as PRG, jd.Keterangan from _v2_jadwal jd left outer join _v2_hari h on jd.Hari=h.ID left outer join _v2_dosen d on jd.IDDosen=d.nip left outer join
		_v2_program pr on jd.Program=pr.Kode left outer join _v2_ruang r on jd.KodeRuang=r.Kode left outer join fakultas f on jd.KodeFakultas=f.Kode left outer join _v2_jurusan j
		on jd.KodeJurusan=j.Kode where jd.Tahun='$thn' and jd.id='$idjad' and jd.IDJadwal='$idjadwal' and jd.Terjadwal='Y'")->row(); // mematikan search berdasarkan idjadwal "and jd.IDJADWAL='$idjadwal'" dan menggunakan id pada jadwal
		
		$getAssDsn = $this->db->query(" select d.glr_depan, d.nama_asli, d.glr_belakang from _v2_jadwalassdsn ja left join _v2_dosen d on ja.IDDosen = d.nip where ja.IDJadwal='$idjadwal' ");
		$dosen[] = $detailJadwal->Dosen;
		foreach ($getAssDsn->result_array() as $dsnlain) {
			$glr_dpn = str_replace(',','', $dsnlain['glr_depan']);
			$nmasli = str_replace(',','', $dsnlain['nama_asli']);
			$glr_blkng = str_replace(' ',', ',str_replace(',','', $dsnlain['glr_belakang']));

			$nm = ( $glr_dpn ?  $glr_dpn.', ' : '' ) .$nmasli. ($glr_blkng ? ', '.$glr_blkng : '' );

			array_push($dosen,$nm);
		}
		$data['dosen']=$dosen;

		$data['detailJadwal'] = $detailJadwal;

		$daftar = $this->daftar_mhsw($idjadwal,$thn);

		$data['detailMahasiswa'] = $daftar;

		$data['tglnow'] = $this->app->tanggal_indonesia(date('d m Y'));

		$this->load->library('pdf'); 

	  	$html=$this->load->view('ademik/report/cetak_daftar_hadir', $data,TRUE);

	  	$filename = "Daftar_Hadir";

        $this->pdf->create($html, $filename, 'potrait');
	}

	// Fandu Report
	// public function cetak_jadwal(){

	// 	$thn = $this->uri->segment(5);
	// 	$kdp = $this->uri->segment(6);
	// 	$kdj = $this->uri->segment(7);

	// 	/*$thn = "20172";
	// 	$kdp = "REG";
	// 	$kdj = "A321";*/

	// 	//echo "$thn - $kdp - $kdj";

	// 	$detJad = $this->db->query("SELECT t.Kode as kodetahun, t.Nama, t.KodeProgram, j.Kode as kodejurusan, j.Nama_Indonesia FROM _v2_tahun t left join _v2_jurusan j on t.KodeJurusan=j.Kode WHERE t.Kode = '$thn' AND t.KodeProgram = '$kdp' AND t.KodeJurusan = '$kdj'")->row();
	// 	$data['kodetahun'] = $detJad->kodetahun;
	// 	$data['nama'] = $detJad->Nama;
	// 	$data['kdprogram'] = $detJad->KodeProgram;
	// 	$data['kodejurusan'] = $detJad->kodejurusan;
	// 	$data['namajurusan'] = $detJad->Nama_Indonesia;

	// 	//$kondisi_dosen = "KodeJurusan='$kdj' and NotActive='N'";

	// 	//$GetField = $this->app->GetField("NIP, concat(Name, ' ' , Gelar, ' - ', NIP) as nm_dosen", "_v2_dosen", "$kondisi_dosen", "")->result(); // untuk dosen pengampu dan asisten dosen

	// 	if (!empty($kdp)) $strprg = "and jd.Program='$kdp'";
	// 	else $strprg = '';

	// 	$tjdwl = ' and jd.Terjadwal="Y" ';

	// 	$detailJadwal = $this->db->query("SELECT jd.IDDosen, jd.KodeFakultas, jd.KodeJurusan, jd.KodeMK, jd.SKS, jd.Program, jd.KodeKampus, jd.KodeRuang, TIME_FORMAT(JamMulai, '%H:%i') as jm,
	// 	TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, jd.NamaMK as MK, jd.SKS, concat(d.Name, ', ', d.Gelar) as Dosen, pr.Nama_Indonesia as PRG, jd.Keterangan, r.Kapasitas, mkh.Sesi
	// 	from _v2_jadwal jd left outer join _v2_matakuliah mkh on jd.IDMK=mkh.IDMK left outer join _v2_hari h on jd.Hari=h.ID left outer join _v2_dosen d on jd.IDDosen=d.nip
	// 	left outer join _v2_program pr on jd.Program=pr.Kode left outer join _v2_ruang r on jd.KodeRuang=r.Kode where jd.Tahun='$thn' and jd.KodeJurusan='$kdj' $strprg $tjdwl and jd.KodeRuang <> ''
	// 	group by jd.IDJADWAL order by jd.Hari, jd.JamMulai limit 280")->result();

	// 	$data['detailJadwal'] = $detailJadwal;

	// 	$this->load->library('pdf');

	// 	$html = $this->load->view('ademik/report/cetak_jadwal', $data, TRUE);
	// 	//$html=$this->load->view('ademik/report/cetak_jadwal', $data);

	//   	$filename = "Cetak Jadwal";

	//     // untuk potrait $this->pdf->create($html, $filename, 'potrait');
	//     $this->pdf->create_costum($html, $filename, 'landscape', 'A4');

	//     //$this->load->view('ademik/report/cetak_jadwal');
	// }

	// Report Inal  
	public function cetak_jadwal(){
		$this->load->library('m_pdf');
		$thn = $this->uri->segment(5);
		$kdp = $this->uri->segment(6);
		$kdj = $this->uri->segment(7);

		$detJad = $this->db->query("SELECT t.Kode as kodetahun, t.Nama, t.KodeProgram, j.Kode as kodejurusan, j.Nama_Indonesia FROM _v2_tahun t left join _v2_jurusan j on t.KodeJurusan=j.Kode WHERE t.Kode = '$thn' AND t.KodeProgram = '$kdp' AND t.KodeJurusan = '$kdj'")->row();
		$data['kodetahun'] = $detJad->kodetahun;
		$data['nama'] = $detJad->Nama;
		$data['kdprogram'] = $detJad->KodeProgram;
		$data['kodejurusan'] = $detJad->kodejurusan;
		$data['namajurusan'] = $detJad->Nama_Indonesia;

		if (!empty($kdp)) $strprg = "and jd.Program='$kdp'";
		else $strprg = '';

		$tjdwl = ' and jd.Terjadwal="Y" ';

		$detailJadwal = $this->db->query("SELECT jd.IDDosen, jd.KodeFakultas, jd.KodeJurusan, jd.KodeMK, jd.SKS, jd.Program, jd.KodeKampus, jd.KodeRuang, TIME_FORMAT(JamMulai, '%H:%i') as jm, (select count(NIM) from _v2_krs$thn where _v2_krs$thn.IDJadwal = jd.IDJADWAL ) as jml_mhsw,
		TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, jd.NamaMK as MK, jd.SKS, concat(d.Name, ', ', d.Gelar) as Dosen, pr.Nama_Indonesia as PRG, jd.Keterangan, r.Kapasitas, mkh.Sesi
		from _v2_jadwal jd left outer join _v2_matakuliah mkh on jd.IDMK=mkh.IDMK left outer join _v2_hari h on jd.Hari=h.ID left outer join _v2_dosen d on jd.IDDosen=d.nip
		left outer join _v2_program pr on jd.Program=pr.Kode left outer join _v2_ruang r on jd.KodeRuang=r.Kode where jd.Tahun='$thn' and jd.KodeJurusan='$kdj' $strprg $tjdwl and jd.KodeRuang <> ''
		group by jd.IDJADWAL order by jd.Hari, jd.JamMulai")->result();

		$data['detailJadwal'] = $detailJadwal;

		$html = $this->load->view('ademik/report/cetak_jadwal', $data, TRUE);
		$pdf = $this->m_pdf->exp_pdf();

		$pdf->AddPage('P');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Cetak jadwal.pdf', "D");

        exit();
	}

	// Fandu Report
	public function cetak_kartu_ujian(){

		$this->load->model('cetak_krs_model');

		// $this->app->checksession();
		$this->app->check_modul();

		/*$thn = $this->uri->segment(5);
		$kdp = $this->uri->segment(6);
		$kdj = $this->uri->segment(7);*/

		$thn = $this->uri->segment(5);
		$kdp = $this->uri->segment(6);
		$kdj = $this->uri->segment(7);
		$nim = $this->uri->segment(8);

		$detJad = $this->db->query("SELECT t.Kode as kodetahun, t.Nama, t.KodeProgram, j.Kode as kodejurusan, j.Nama_Indonesia, f.Kode as kdf, f.Nama_Indonesia as nmf FROM _v2_tahun t left join _v2_jurusan j on t.KodeJurusan=j.Kode left join fakultas f on j.KodeFakultas=f.Kode WHERE t.Kode = '$thn' AND t.KodeProgram = '$kdp' AND t.KodeJurusan = '$kdj'")->row();
		$data['kodetahun'] = $detJad->kodetahun;
		$data['nama'] = $detJad->Nama;
		$data['kdprogram'] = $detJad->KodeProgram;
		$data['kodejurusan'] = $detJad->kodejurusan;
		$data['namajurusan'] = $detJad->Nama_Indonesia;
		$data['kodefakultas'] = $detJad->kdf;
		$data['namafakultas'] = $detJad->nmf;

		//$kondisi_dosen = "KodeJurusan='$kdj' and NotActive='N'";

		//$GetField = $this->app->GetField("NIP, concat(Name, ' ' , Gelar, ' - ', NIP) as nm_dosen", "_v2_dosen", "$kondisi_dosen", "")->result(); // untuk dosen pengampu dan asisten dosen

		$detailmhsw = $this->db->query("select k.nim,m.Name,k.Tahun from _v2_krs$thn k, _v2_mhsw m where k.nim='$nim' AND k.nim=m.NIM and k.Tahun=$thn and m.KodeJurusan='$kdj' and m.KodeProgram='$kdp' group by k.nim limit 1")->result();

		$data['detailmhsw'] = $detailmhsw;

		$tbl = "_v2_krs$thn";

		$data['detailKrs'] = $this->cetak_krs_model->getDetailKrs($nim,$thn,$tbl);

		$data['tglnow'] = $this->app->tanggal_indonesia(date('d m Y'));
		$data['controller'] = $this;

		$this->load->library('pdf');

	  $html=$this->load->view('ademik/report/cetak_kartu_ujian', $data,TRUE);
	  //$this->load->view('ademik/report/cetak_jadwal', $data);

	  $filename = "Cetak Kartu Ujian";

    // untuk potrait $this->pdf->create($html, $filename, 'potrait');
    $this->pdf->create_costum($html, $filename, 'landscape', 'A4');

	}

	public function cekPersentase($nim, $thn, $kodeMk) {
		$this->load->model('ipk_model');
		$persentase = $this->ipk_model->getHadir($thn,$nim,$kodeMk);
	}

	// Wawan Report
	public function cetak_krs(){
		//example $data['rata'] = $this->db->query("SELECT t.NIM,m.Name,sum(IF(id_tes='1',nilai,0)) as Nilai_I,sum(IF(id_tes='2',nilai,0)) as Nilai_II,sum(IF(id_tes='3',nilai,0)) as Nilai_III,sum(nilai) as total,(sum(nilai)/3) as Rata_rata FROM tr_ikut_ujian t,mhsw m WHERE t.NIM=m.NIM group by t.NIM");
		//example$data['kategori'] = $this->db->query("select * from kategori_soal where id = '".$id_tes."'");

		// example $data['ujian'] = $ketgori;
		$data['page_title'] = '';

		$this->load->library('pdf');
		$html = $this->load->view('ademik/report/cetak_krs', $data,TRUE);

        $filename = "KRS";

        $this->pdf->create($html, $filename, 'potrait');

        $this->load->view('ademik/report/cetak_krs');
	}

	// Fandu Report
	public function cetak_dpna(){

		// $this->app->checksession();
		$this->app->check_modul();

		$idjad = $this->uri->segment(5);
		$thn = $this->uri->segment(6);

		$getone = $this->app->getOnRow("IDJadwal", "_v2_jadwal", "ID='$idjad'");
		$idjadwal = $getone->IDJadwal;

		$getAssDsn = $this->app->GetField("d.Name", "_v2_jadwalassdsn ja left join _v2_dosen d on ja.IDDosen = d.nip", "ja.IDJadwal='$idjadwal'", "");

		$detailJadwal = $this->db->query("select jd.IDJADWAL, jd.KodeMK, jd.Tahun, jd.KodeFakultas, f.Nama_Indonesia as nmf, jd.KodeJurusan, j.Nama_Indonesia as nmj, jd.SKS, jd.Program, jd.KodeKampus,
		jd.KodeRuang, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, jd.NamaMK as MK, concat(d.Name, ', ', d.Gelar) as Dosen, d.nip as nipdosen,
		pr.Nama_Indonesia as PRG, jd.Keterangan, thn.Nama as namatahun from _v2_jadwal jd left outer join _v2_hari h on jd.Hari=h.ID left outer join _v2_dosen d on jd.IDDosen=d.nip left outer join
		_v2_program pr on jd.Program=pr.Kode left outer join _v2_ruang r on jd.KodeRuang=r.Kode left outer join fakultas f on jd.KodeFakultas=f.Kode left outer join _v2_jurusan j
		on jd.KodeJurusan=j.Kode left join _v2_tahun thn on thn.Kode = jd.Tahun and thn.KodeJurusan = jd.KodeJurusan  where jd.Tahun='$thn' and jd.ID='$idjad' and jd.IDJadwal='$idjadwal' and jd.Terjadwal='Y'")->row(); // mematikan search berdasarkan idjadwal "and jd.IDJADWAL='$idjadwal'" dan menggunakan id pada jadwal

		/*$detailJadwal = $this->db->query("select jd.IDJADWAL, jd.KodeMK, jd.Tahun, jd.KodeFakultas, f.Nama_Indonesia as nmf, jd.KodeJurusan, j.Nama_Indonesia as nmj, jd.SKS, jd.Program, jd.KodeKampus,
		jd.KodeRuang, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, jd.NamaMK as MK, concat(d.Name, ', ', d.Gelar) as Dosen,
		pr.Nama_Indonesia as PRG, jd.Keterangan from _v2_jadwal jd left outer join _v2_hari h on jd.Hari=h.ID left outer join _v2_dosen d on jd.IDDosen=d.nip left outer join
		_v2_program pr on jd.Program=pr.Kode left outer join _v2_ruang r on jd.KodeRuang=r.Kode left outer join fakultas f on jd.KodeFakultas=f.Kode left outer join _v2_jurusan j
		on jd.KodeJurusan=j.Kode where jd.Tahun='$thn' and jd.IDJADWAL='$idjadwal' and jd.Terjadwal='Y'")->row();*/

		if ($this->session->userdata("kdf") == "K2M"){
			$data['tempat'] = "Bungku";
		} else {
			$data['tempat'] = "Palu";
		}

		$data['detailJadwal'] = $detailJadwal;

		$daftar = $this->daftar_mhsw($idjadwal,$thn);

		$data['detailMahasiswa'] = $daftar;

		$data['getAssDsn'] = $getAssDsn;

		$data['tglnow'] = $this->app->tanggal_indonesia(date('d m Y'));

		$this->load->library('pdf');

	  $html=$this->load->view('ademik/report/cetak_dpna', $data,TRUE);

	  $filename = "DPNA";

    //$this->pdf->create($html, $filename, 'potrait');
		$this->pdf->create_costum($html, $filename, 'potrait', 'A4');

		$this->load->view('cetak_dpna');
	}

	// fandu report
	public function cetak_daftar_nilai(){

		// $this->app->checksession();
		$this->app->check_modul();

		$idjad = $this->uri->segment(5);
		$thn = $this->uri->segment(6);

		$getone = $this->app->getOnRow("IDJadwal", "_v2_jadwal", "ID='$idjad'");
		$idjadwal = $getone->IDJadwal;

		$getAssDsn = $this->app->GetField("d.Name", "_v2_jadwalassdsn ja left join _v2_dosen d on ja.IDDosen = d.nip", "ja.IDJadwal='$idjadwal'", "");

		$detailJadwal = $this->db->query("select jd.IDJADWAL, jd.KodeMK, jd.Tahun, jd.KodeFakultas, f.Nama_Indonesia as nmf, jd.KodeJurusan, j.Nama_Indonesia as nmj, jd.SKS, jd.Program, jd.KodeKampus,
		jd.KodeRuang, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, jd.NamaMK as MK, concat(d.Name, ', ', d.Gelar) as Dosen, d.nip as nipdosen,
		pr.Nama_Indonesia as PRG, jd.Keterangan, thn.Nama as namatahun from _v2_jadwal jd left outer join _v2_hari h on jd.Hari=h.ID left outer join _v2_dosen d on jd.IDDosen=d.nip left outer join
		_v2_program pr on jd.Program=pr.Kode left outer join _v2_ruang r on jd.KodeRuang=r.Kode left outer join fakultas f on jd.KodeFakultas=f.Kode left outer join _v2_jurusan j
		on jd.KodeJurusan=j.Kode left join _v2_tahun thn on thn.Kode = jd.Tahun and thn.KodeJurusan = jd.KodeJurusan  where jd.Tahun='$thn' and jd.ID='$idjad' and jd.IDJadwal='$idjadwal' and jd.Terjadwal='Y'")->row(); // mematikan search berdasarkan idjadwal "and jd.IDJADWAL='$idjadwal'" dan menggunakan id pada jadwal

		if ($this->session->userdata("kdf") == "K2M"){
			$data['tempat'] = "Bungku";
		} else {
			$data['tempat'] = "Palu";
		}

		$data['detailJadwal'] = $detailJadwal;

		$daftar = $this->daftar_mhsw($idjadwal,$thn);

		$data['detailMahasiswa'] = $daftar;

		$data['getAssDsn'] = $getAssDsn;

		$data['tglnow'] = $this->app->tanggal_indonesia(date('d m Y'));

		$this->load->library('pdf');

		$html=$this->load->view('ademik/report/cetak_daftar_nilai', $data,TRUE);

		// echo $html;
		// die;

		$filename = "Daftar Nilai Mahasiswa";

		$this->pdf->create_costum($html, $filename, 'potrait', 'A4');

		$this->load->view('cetak_daftar_nilai');
		//$this->load->view('ademik/report/cetak_daftar_nilai', $data);
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
	public function cetak_absensi_harian_mahasiswa()
	{
		$html = $this->load->view('ademik/absensi_/cetak_absen_harian_mahasiswa','',TRUE);

		$pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('P');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Absen mahasiswa.pdf', "D");

        exit();

	}


	// Fadli Report
	public function cetak_absensi_mahasiswa_1_5()
	{
		$html = $this->load->view('ademik/absensi_/cetak_absen_mahasiswa_1_5','',TRUE);

		$pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('P');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Absen mahasiswa.pdf', "D");

        exit();

    }

    public function cetak_absensi_mahasiswa_16()
	{
		$html = $this->load->view('ademik/absensi_/cetak_absen_mahasiswa_16','',TRUE);

		$pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('P');
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
		$html = $this->load->view('ademik/absensi_/cetak_absen_dosen','',TRUE);

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
		$html = $this->load->view('ademik/absensi_/cetak_rekap_absen_dosen','',TRUE);

		$pdf = $this->m_pdf->exp_pdf();

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
		$html = $this->load->view('ademik/absensi_/cetak_rekap_absen_mahasiswa','',TRUE);

		$pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('L');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('Rekap Absen mahasiswa.pdf', "D");

        exit();
	}

	// Fadli Report
	public function cetak_cpna()
	{
		$html = $this->load->view('ademik/absensi_/cetak_cpna','',TRUE);

		$pdf = $this->m_pdf->exp_pdf();

        $pdf->AddPage('L');
        $pdf->pagenumPrefix = 'Halaman ';
		$pdf->nbpgPrefix = ' dari ';
        $pdf->setFooter('{PAGENO}{nbpg}');
        $pdf->WriteHTML($html);

        $pdf->Output('CPNA.pdf', "D");

        exit();
	}


	//$this->load->view('ademik/report/cetak_formulir_ppl',$biodata);

		//	$this->load->library('pdf');

	 	//  $html=$this->load->view('ademik/report/cetak_formulir_ppl','', TRUE);
	 	//  $filename = "Formulir Pendaftaran PPL";
  		//	$this->pdf->create($html, $filename, 'lendscape');


	public function print_formulir_ppl($nim){

		$ulevel		= $this->session->ulevel;
		$unip		= $this->session->unip;
		//$kdl = "";
		$kdf = "";

		if($ulevel!="1"){

			echo "tes 1";
		 	$qKdf 	= $this->Ppl_model->getKodeFak($unip);
		 	$kdf 	= $qKdf->KodeFakultas;
		 }

		if($kdf == "A" || $ulevel==4 ){

			echo "tes 2";

			$nimt = $_REQUEST[nim];
			$tahunaktif = "20181";

			$kdf 		= GetField('mhsw', 'nim', $nimt, 'KodeFakultas');
			$cekppl 	= $this->Ppl_model->pplcek($nimt, $tahunaktif);
			$nilai 		= $pplcek['GradeNilai'];

			$val1 		= $this->Ppl_model->cekppl($nimt, $tahunaktif);
			$da 		= $val1['daerah_asal'];
			$kendaraan 	= $val1['kendaraan'];
			$kategori 	= $val1['kategory'];

						$tmplahir 	= $this->input->post('tmplahir');
						$tgllahir 	= $this->input->post('tgllahir');
						$nmp 		= $this->input->post('nmp');
						$nmj 		= $this->input->post('nmp');
						$kdjur 		= $this->input->post('kdjur');
						$fakultas 	= $this->input->post('fakultas');
						$name 		= $this->input->post('name');
						$date 		= $this->input->post(date('d m Y'));
						$kdprog 	= $this->input->post('kdprog');
						$sex1 		= $this->input->post('sex1');
						$agama 		= $this->input->post('agama');
						$alamat 	= $this->input->post('alamat');
						$phone 		= $this->input->post('phone');
						$nmayah 	= $this->input->post('nmayah');
						$nmibu 		= $this->input->post('nmibu');
						$alamatot1 	= $this->input->post('alamatot1');
						$alamatot2	= $this->input->post('alamatot2');
						$phoneot	= $this->input->post('phoneot');
						$totsks 	= $this->input->post('totsks');
						$nmf 		= $this->input->post('nmf');

			$biodata 	= $this->Ppl_model->daftar_bio($nim);
						  //$this->load->view('ademik/report/cetak_formulir_ppl',$biodata);
		}
	}

	public function cetak_formulir($nim){

			$data = $this->print_formulir_ppl($nim);
					$this->load->view('ademik/report/cetak_formulir_ppl',$data);

			// echo "<pre>";
			// print_r($data);
			// echo "</pre>";

	}

}





			// if ( $this->session->userdata('ulevel') == 5 ) {
			// 	//return $dataKode = $this->session->userdata("kdf");
			// 	$kdl = GetField($user, 'Login', $unip, 'KodeFakultas');
			// 	$kdf = GetField('mhsw', 'nim', $nim, 'KodeFakultas');

			// } elseif ( $this->session->userdata('ulevel') == 7 ) {
			// 	//return $dataKode = $this->session->userdata("kdj");
			// 	$kdl = GetField($user, 'Login', $unip, 'KodeFakultas');
			// 	$kdf = GetField('mhsw', 'nim', $nim, 'KodeFakultas');
			// }
