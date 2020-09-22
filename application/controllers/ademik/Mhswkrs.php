<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mhswkrs extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('encryption');
		$this->load->model('krs_model');
		date_default_timezone_set("Asia/Makassar");

		// Mengatur sesession jika belum login
		if ($this->session->userdata("unip") == null) {
			redirect("https://siakad2.untad.ac.id");
		}
	}

	public function index(){
	// cara pertama
		//	$content = $this->session->userdata('sess_tamplate');
		//	$this->load->view('temp/head');
		//	$this->load->view($content);
		//	$this->load->view('temp/footers');

	// cara kedua
		$a['tab'] = $this->app->all_val('groupmodul')->result();
		$this->load->view('dashbord',$a);

	// cara ke tiga
		//$this->load->view('dashbord');
	}

	public function search(){
		$config = array(
				array(
						'field' => 'semesterAkademik',
						'label' => 'Semester Akademik',
						'rules' => array(
								'required',
								'numeric',
								'max_length[5]'
						),
						'errors' => array(
								'required' => '%s Harus diisi.',
								'numeric' => '%s Harus Angka.',
								'max_length' => '%s Tidak boleh melebihi 5.'
						)
				),array(
						'field' => 'nim',
						'label' => 'NIM',
						'rules' => array(
								'required'
						),
						'errors' => array(
								'required' => '%s Harus diisi.'
						)
				)
		);
		$this->form_validation->set_rules($config);

		$data= "";
		if ($this->form_validation->run() === FALSE)
		{
			$data = array(
					'semesterAkademik' => form_error('semesterAkademik'),
					'nim' => form_error('nim')
			);
			echo json_encode($data);
		}
		else
		{
			if($_SESSION['ulevel']==4){
				$nim=$_SESSION['unip'];
			}else{
				$nim = $this->input->post('nim');
			}


			$semesterAkademik = $this->input->post('semesterAkademik');

			// Memvalidasi NIM agar tidak error (10-12-2018)
			$dataMhsw = $this->krs_model->getMhsw($nim);
			$tahun_akademik = 0;
			if($dataMhsw==false){
				$dataErr = array(
					'error' => 'Data tidak ditemukan',
				);
				echo json_encode($dataErr);
			}else{
				$data = $this->krs_model->getMhswKhs($nim,$semesterAkademik); //Mengambil Data sebagai Parameter
				$mhswBaru = $this->krs_model->cekMhswAkademik($nim);

				$tahun_akademik=$mhswBaru->TahunAkademik;
				$status_mhsw=$mhswBaru->Status;
				$periode=substr($semesterAkademik, 4);
				
			}

			$point_1 = 0;
			$point_2 = 0;
			$point_3 = 0;
			$point_4 = 0;
			$point_5 = 0;
			$point_6 = 0;
			$point_7 = 0;
			$point_8 = 0;
			$point_9 = 0;

			$dataKodeMhsw= $this->krs_model->getMhswKode($nim);
			$kdfMhsw=$dataKodeMhsw->KodeFakultas;
			$kdjMhsw=$dataKodeMhsw->KodeJurusan;
			$kdp=$dataKodeMhsw->KodeProgram;
			/*$kdfMhsw=substr($nim, 0, 1);
			$kdjMhsw=substr($nim, 0, 4);*/
			//if($data!=false){
					if($_SESSION['kdj']!=""){
						$kdj = $_SESSION['kdj'];
					}else{
						$kdj = $kdjMhsw;
					}

					$cekRule = $this->krs_model->cekRule($nim,$semesterAkademik);
					//Cek Rule
					if($cekRule==false){
						$insertRuleSemester = $this->krs_model->insertRuleSemester($nim,$semesterAkademik);

						$cekRule = $this->krs_model->cekRule($nim,$semesterAkademik);

					}
					//selesai cek rule

					//Cek semester akademik yang berada pada tabel _v2_tahun
					if($cekRule->point_1!=1){
						$dataTahun = $this->krs_model->getTahun($kdj,$semesterAkademik,$kdp);

						if($dataTahun==false){
							$dataErr = array(
								'error' => 'Semester Akademik belum dibuka',
							);
							echo json_encode($dataErr);
							$point_1=0;
						}else{
							$updateRuleSemester = $this->krs_model->updateRuleSemester($nim,$semesterAkademik);
							$point_1 = 1;
						}
					}else{
						$point_1 = 1;
					}
					//selesai cek


					//cek point 2 biodata
					if($point_1==1){
						if($cekRule->point_2!=1){
							//Cek biodata
							$dataMhsw = $this->krs_model->getMhsw($nim);
							if($dataMhsw==false){
								$dataErr = array(
									'error' => 'Data tidak ditemukan',
								);
								echo json_encode($dataErr);
								$point_2=0;
							}else{
								$updateRuleBiodata = $this->krs_model->updateRuleBiodata($nim,$semesterAkademik);
								$point_2 = 1;
							}
						}else{
							$point_2 = 1;
						}
					}
					//selesai cek


					//cek point 3 hutang di _v2_spp2
					if($point_2==1){
						//cek hutang
						if($cekRule->point_3!=1){
							$cekHutang = $this->cekHutang($nim,$semesterAkademik);
							if($cekHutang){
								$updateRuleHutang = $this->krs_model->updateRuleHutang($nim,$semesterAkademik);
								$point_3 = 1;
							}else{
								if($semesterAkademik==$tahun_akademik.'1') {
									$updateRuleHutang = $this->krs_model->updateRuleHutang($nim,$semesterAkademik);
									$point_3 = 1;
								} else {
									$dataErr = array(
										'error' => 'Anda Belum Bayar SPP semester '.$semesterAkademik.'<br><b>Hubungi Admin di Fakultas Anda !</b><br><a href="'.base_url("ademik/mhswkrs/prcspc/").$nim."/".$semesterAkademik.'" class="btn btn-primary rounded" style="margin-top:15px; padding: 12px;">Proses Pembayaran</a>',
									);
									//  $dataErr = array(
									// 	'error' => 'Transaksi belum dapat dilakukan, dikarenakan SPC masih dalam tahap perbaikan (Anda belum bayar SPP)',
									// ); 

									//  $dataErr = array(
									// 	'error' => 'Transaksi belum dapat dilakukan, dikarenakan system sementara melakukan load otomatis pembayaran ke siakad 2, mohon menunggu sampai pukul 16.30 WITA',
									// ); 
									echo json_encode($dataErr);
									$point_3 = 0;
								}
							}
						}else{
							$point_3 = 1;
						}
					}
					//selesai cek Hutang

					//cek Point 4 cuti tabel riwayat cuti berdasarkan smt_mulai cuti dan akhir cuti
					if($point_3==1){
						//cek cuti
						if($cekRule->point_4!=1){
							$cekCuti = $this->cekCuti($nim,$semesterAkademik);
							if($cekCuti){
								$updateRuleCuti = $this->krs_model->updateRuleCuti($nim,$semesterAkademik);
								$point_4 = 1;
							}else{
								$dataErr = array(
									'error' => 'Anda Masih Terdaftar Cuti',
								);
								echo json_encode($dataErr);
								$point_4 = 0;
							}
						}else{
							$point_4 = 1;
						}

					}
					//selseai cek Cuti

					//cek nama ibu dan tempat lahir di mhsw
					if($point_4==1){
						if($cekRule->point_5!=1){ //Cek nama ibu dan tempat dan tgl lahir
							$cekBiodata = $this->cekBiodata($nim,$semesterAkademik);
							if($cekBiodata){
								$updateRuleBiodataIbu = $this->krs_model->updateRuleBiodataIbu($nim,$semesterAkademik);
								$point_5 = 1;
							}else{
								$dataErr = array(
									'error' => 'Silahkan Isi/Cek Terlebih dahulu Biodata <b>Nama ibu, Tempat/tanggal lahir </b><a style="color:blue;" href="'.base_url("ademik/Profil").'">Isi Biodata</a>',
								);
								echo json_encode($dataErr);
								$point_5 = 0;
							}
						}else{
							$point_5 = 1;
						}
					}
					//selesai cek

					//cek mahasiswa aktif untuk di masukkan di rule dari tabel mhsw
					if($point_5==1){
						if($cekRule->point_6!=1){ //Cek mahasiswa Aktif
							$cekMhswAktif = $this->cekMhswAktif($nim,$semesterAkademik);
							if($cekMhswAktif['status']!=false){
								$updateRuleMahasiswaAktif = $this->krs_model->updateRuleMahasiswaAktif($nim,$semesterAkademik);
								$point_6 = 1;
							}else{
								$dataErr = array(
									'error' => $cekMhswAktif['msgError'],
								);
								echo json_encode($dataErr);
								$point_6 = 0;
							}
						}else{
							$point_6=1;
						}
					}
					//selsai cek

					//cek periode aktif jika tahun semester tidak sama dengan tahun periode aktif maka diluluskan karena telah melewati periode aktif didikti tersebut jika tidak maka dilakukan pengecekkan selanjutnya
					if($point_6==1){
						if($cekRule->point_7!=1){ //Cek periode Aktif
							$qSemesterAkademikAktif= $this->krs_model->getSemesterAkademikAktif();
							$semesterAkademikAktif = $qSemesterAkademikAktif->periode_aktif;
							if($semesterAkademik==$semesterAkademikAktif){
								$updateRulePeriodeAktif = $this->krs_model->updateRulePeriodeAktif($nim,$semesterAkademik);
								$point_7 = 1;
							}else{
								$mhswBaru = $this->krs_model->cekMhswAkademik($nim);
								$tahun_akademik=$mhswBaru->TahunAkademik;
								$semesterMhsw = $mhswBaru->Semester;

								
								if($tahun_akademik==substr($semesterAkademik,0,4)){
									$maxsks = 24;
								}else{
									$cekSks = $this->krs_model->getMaxSks($nim,$semesterAkademik);
									$maxsks = $cekSks->MaxSKS;
								}
		
								if(substr($semesterAkademik,4,1)==3 || substr($semesterAkademik,4,1)==4) {
									if($kdfMhsw=='P'){
										$maxsks=10;
									}else{
										$maxsks=9;
									}
								}
								/*$cekSks = $this->krs_model->getMaxSks($nim,$semesterAkademik);
								$maxsks = $cekSks->MaxSKS;*/
								$tahunx = "";
								if(substr($semesterAkademik,4,1)==1){
									$tahunx=$semesterAkademik-9;
								}else if(substr($semesterAkademik,4,1)==2){
									$tahunx = $semesterAkademik-1;
								}

								if($tahun_akademik!=substr($semesterAkademik,0,4)){
									if($semesterMhsw!=$semesterAkademikAktif){
										if($status_mhsw!='P'){
											if(substr($semesterAkademik,4,1)==3 OR substr($semesterAkademik,4,1)==4){
												$ips = 0;
											}else{
												$getIps = $this->krs_model->getIps($nim,$tahunx);
												$ips = $getIps->IPS;
											}
										}else{
											$ips=0;
										}	
									}else{
										$ips=0;
									}									
								}else{
									$ips = 0;
								}

								if($this->session->ulevel==5){
									if($this->session->kdf!=$kdfMhsw){
										$dataErr = array(
											'error' => 'Admin tidak dapat menginput Mahasiswa Fakultas lain',
										);
										echo json_encode($dataErr);
									}else{
										$sksBolehDiAmbil = "SKS yang boleh diambil = ".$maxsks."<br /> IPS Tahun ".$tahunx." yaitu ".$ips."<br/><br/><b>Apakah SKS sudah sesuai?</b>";
										$tampil = $this->tampilKrs($nim,$semesterAkademik);
										$dataView = array(
											'view' => $tampil,
											'data' => $data,
											'message' => $sksBolehDiAmbil
										);
										echo json_encode($dataView);
									}
								}elseif($this->session->ulevel==7){
									if($this->session->kdj!=$kdjMhsw){
										$dataErr = array(
											'error' => 'Admin tidak dapat menginput mahasiswa Jurusan lain',
										);
										echo json_encode($dataErr);
									}else{
										$sksBolehDiAmbil = "SKS yang boleh diambil = ".$maxsks."<br /> IPS Tahun ".$tahunx." yaitu ".$ips."<br/><br/><b>Apakah SKS sudah sesuai?</b>";
										$tampil = $this->tampilKrs($nim,$semesterAkademik);
										$dataView = array(
											'view' => $tampil,
											'data' => $data,
											'message' => $sksBolehDiAmbil
										);
										echo json_encode($dataView);
									}
								}else{
									$sksBolehDiAmbil = "SKS yang boleh diambil = ".$maxsks."<br /> IPS Tahun ".$tahunx." yaitu ".$ips."<br/><br/><b>Apakah SKS sudah sesuai?</b>";
									$tampil = $this->tampilKrs($nim,$semesterAkademik);
									$dataView = array(
										'view' => $tampil,
										'data' => $data,
										'message' => $sksBolehDiAmbil
									);
									echo json_encode($dataView);
								}
								$point_7 = 0;
							}
						}else{
							$point_7=1;
						}
					}
					//selesai cek

					//cek mahasiswa PDPT
					if($point_7==1){
						if($cekRule->point_8!=1){ //Cek mahasiswa PDPT
							$cekMhswDikti = $this->mhsw_pdpt($nim,$semesterAkademik);

							$qSemesterAkademikAktif= $this->krs_model->getSemesterAkademikAktif();
							$semesterAkademikAktif = $qSemesterAkademikAktif->periode_aktif;
							if($cekMhswDikti==0){
								$updateRuleMahasiswaPdpt = $this->krs_model->updateRuleMahasiswaPdpt($nim,$semesterAkademik);
								$point_8 = 1;
							}else{
								$mhswBaru = $this->krs_model->cekMhswAkademik($nim);
								$tahun_akademik=$mhswBaru->TahunAkademik;
								$semesterMhsw = $mhswBaru->Semester;

								
								if($tahun_akademik==substr($semesterAkademik,0,4)){
									$maxsks = 24;
								}else{
									$cekSks = $this->krs_model->getMaxSks($nim,$semesterAkademik);
									$maxsks = $cekSks->MaxSKS;
								}

								if(substr($semesterAkademik,4,1)==3 || substr($semesterAkademik,4,1)==4) {
									if($kdfMhsw=='P'){
										$maxsks=10;
									}else{
										$maxsks=9;
									}
								}
								
								/*$cekSks = $this->krs_model->getMaxSks($nim,$semesterAkademik);
								$maxsks = $cekSks->MaxSKS;*/
								$tahunx = "";
								if(substr($semesterAkademik,4,1)==1){
									$tahunx=$semesterAkademik-9;
								}else if(substr($semesterAkademik,4,1)==2){
									$tahunx = $semesterAkademik-1;
								}
								if($tahun_akademik!=substr($semesterAkademik,0,4)){
									if($semesterMhsw!=$semesterAkademikAktif){ // Jika semester (semester awal mahasiswa Baru sama dengan periode aktif maka dilewatkan)
										if($status_mhsw!='P'){
											$getIps = $this->krs_model->getIps($nim,$tahunx);
											$ips = $getIps->IPS;
										}else{
											$ips=0;
										}
									}else{
										$ips = 0;
									}
								}else{
									$ips = 0;
								}

								if($this->session->ulevel==5){
									if($this->session->kdf!=$kdfMhsw){
										$dataErr = array(
											'error' => 'Admin tidak dapat menginput Mahasiswa Fakultas lain',
										);
										echo json_encode($dataErr);
									}else{
										$sksBolehDiAmbil = "SKS yang boleh diambil = ".$maxsks."<br /> IPS Tahun ".$tahunx." yaitu ".$ips."<br/><br/><b>Apakah SKS sudah sesuai?</b>";
										$tampil = $this->tampilKrs($nim,$semesterAkademik);
										$dataView = array(
											'view' => $tampil,
											'data' => $data,
											'message' => $sksBolehDiAmbil
										);
										echo json_encode($dataView);
									}
								}elseif($this->session->ulevel==7){
									if($this->session->kdj!=$kdjMhsw){
										$dataErr = array(
											'error' => 'Admin tidak dapat menginput mahasiswa Jurusan lain',
										);
										echo json_encode($dataErr);
									}else{
										$sksBolehDiAmbil = "SKS yang boleh diambil = ".$maxsks."<br /> IPS Tahun ".$tahunx." yaitu ".$ips."<br/><br/><b>Apakah SKS sudah sesuai?</b>";
										$tampil = $this->tampilKrs($nim,$semesterAkademik);
										$dataView = array(
											'view' => $tampil,
											'data' => $data,
											'message' => $sksBolehDiAmbil
										);
										echo json_encode($dataView);
									}
								}else{
									$sksBolehDiAmbil = "SKS yang boleh diambil = ".$maxsks."<br /> IPS Tahun ".$tahunx." yaitu ".$ips."<br/><br/><b>Apakah SKS sudah sesuai?</b>";
									$tampil = $this->tampilKrs($nim,$semesterAkademik);
									$dataView = array(
										'view' => $tampil,
										'data' => $data,
										'message' => $sksBolehDiAmbil
									);
									echo json_encode($dataView);
								}
								$point_8 = 0;
							}
						}else{
							$point_8=1;
						}
					}//selesai cek

					//Cek abaikan PDPT
					if($point_8==1){
						if($cekRule->point_9!=1){ //Cek mahasiswa Aktif
							$qSemesterAkademikAktif= $this->krs_model->getSemesterAkademikAktif();
							$semesterAkademikAktif = $qSemesterAkademikAktif->periode_aktif;

							$mhswBaru = $this->krs_model->cekMhswAkademik($nim);
							$tahun_akademik=$mhswBaru->TahunAkademik;
							$semesterMhsw = $mhswBaru->Semester;
							if($semesterMhsw!=$semesterAkademikAktif){ // Jika semester (semester awal mahasiswa Baru sama dengan periode aktif maka dilewatkan)
								if($periode=="1"){
									if($tahun_akademik!=substr($semesterAkademik,0,4)){
										if($status_mhsw!='P'){
											$abaikan = $this->abaikan($nim,$semesterAkademik);
										}else{
											$abaikan= 1;
										}
									}else{
										$abaikan = 1;
									}
								}else{
									$abaikan = $this->abaikan($nim,$semesterAkademik);
								}
							} else {
								$abaikan = 1;	
							}

							if($abaikan==0){
								if($this->session->ulevel==5 AND $this->session->kdf!=$kdfMhsw){
									$dataErr = array(
										'error' => 'Admin tidak dapat menginput Mahasiswa Fakultas lain',
									);
									echo json_encode($dataErr);
								}elseif($this->session->ulevel==7 AND $this->session->kdj!=$kdjMhsw){
									$dataErr = array(
										'error' => 'Admin tidak dapat menginput mahasiswa Jurusan lain',
									);
									echo json_encode($dataErr);
								}else{
									$tampil = $this->tabel_error($nim,$semesterAkademik);
									$dataView = array(
										'view' => $tampil,
										'data' => $data
									);
									echo json_encode($dataView);
								}
								$point_9 = 0;
							}else{
								$updateRuleAbaikanDikti = $this->krs_model->updateRuleAbaikanDikti($nim,$semesterAkademik);
								$point_9 = 1;
							}
						}else{
							$point_9=1;
						}
					}
					//selsai cek

					//cek sdah ada point 9 abaikan atau belum kalau sdah tampilkan
					if($point_9==1){
						//cek abaikan
						$qSemesterAkademikAktif= $this->krs_model->getSemesterAkademikAktif();
						$semesterAkademikAktif = $qSemesterAkademikAktif->periode_aktif;

						$mhswBaru = $this->krs_model->cekMhswAkademik($nim);
						$tahun_akademik=$mhswBaru->TahunAkademik;
						$semesterMhsw = $mhswBaru->Semester;
						
						if($tahun_akademik==substr($semesterAkademik,0,4)){
							$maxsks = 24;
						}else{
							$cekSks = $this->krs_model->getMaxSks($nim,$semesterAkademik);
							$maxsks = $cekSks->MaxSKS;
						}

						if(substr($semesterAkademik,4,1)==3 || substr($semesterAkademik,4,1)==4) {
							if($kdfMhsw=='P'){
								$maxsks=10;
							}else{
								$maxsks=9;
							}
						}
						
						/*$cekSks = $this->krs_model->getMaxSks($nim,$semesterAkademik);
						$maxsks = $cekSks->MaxSKS;*/
						$tahunx = "";
						if(substr($semesterAkademik,4,1)==1){
							$tahunx=$semesterAkademik-9;
						}else if(substr($semesterAkademik,4,1)==2){
							$tahunx = $semesterAkademik-1;
						}
						if($tahun_akademik!=substr($semesterAkademik,0,4)){
							if($semesterMhsw!=$semesterAkademikAktif){ // Jika semester (semester awal mahasiswa Baru sama dengan periode aktif maka dilewatkan)
								if($status_mhsw!='P'){
									$getIps = $this->krs_model->getIps($nim,$tahunx);
									$ips = $getIps->IPS;
								}else{
									$ips=0;
								}
							} else {
								$ips=0;
							}
						}else{
							$ips = 0;
						}

						if($this->session->ulevel==5){
							if($this->session->kdf!=$kdfMhsw){
								$dataErr = array(
									'error' => 'Admin tidak dapat menginput Mahasiswa Fakultas lain',
								);
								echo json_encode($dataErr);
							}else{
								$sksBolehDiAmbil = "SKS yang boleh diambil = ".$maxsks."<br /> IPS Tahun ".$tahunx." yaitu ".$ips."<br/><br/><b>Apakah SKS sudah sesuai?</b>";
								$tampil = $this->tampilKrs($nim,$semesterAkademik);
								$dataView = array(
									'view' => $tampil,
									'data' => $data,
									'message' => $sksBolehDiAmbil
								);
								echo json_encode($dataView);
							}
						}elseif($this->session->ulevel==7){
							if($this->session->kdj!=$kdjMhsw){
								$dataErr = array(
									'error' => 'Admin tidak dapat menginput mahasiswa Jurusan lain',
								);
								echo json_encode($dataErr);
							}else{
								$sksBolehDiAmbil = "SKS yang boleh diambil = ".$maxsks."<br /> IPS Tahun ".$tahunx." yaitu ".$ips."<br/><br/><b>Apakah SKS sudah sesuai?</b>";
								$tampil = $this->tampilKrs($nim,$semesterAkademik);
								$dataView = array(
									'view' => $tampil,
									'data' => $data,
									'message' => $sksBolehDiAmbil
								);
								echo json_encode($dataView);
							}
						}else{
							$sksBolehDiAmbil = "SKS yang boleh diambil = ".$maxsks."<br /> IPS Tahun ".$tahunx." yaitu ".$ips."<br/><br/><b>Apakah SKS sudah sesuai?</b>";
							$tampil = $this->tampilKrs($nim,$semesterAkademik);
							$dataView = array(
								'view' => $tampil,
								'data' => $data,
								'message' => $sksBolehDiAmbil
							);
							echo json_encode($dataView);
						}
					}


			/*
		// cekHutang == point1
		// cekCuti == point2
		// cekBiodata == point3

		$point1 = 0;
		$point2 = 0;
		$point3 = 0;

//////////////
		$cekRule = $this->krs_model->cekRule($nim,$semesterAkademik);
		$point1 = $cekRule->point_1; // 1
		$point2 = $cekRule->point_2; // 0
		$point3 = $cekRule->point_3; // 0
/////////////////

==================
		if ($point1 == 0){
			$point1 = $this->cekHutang($nim,$semesterAkademik);
		} else {
			$point1 = $point1 // true
		}

		if ($point2 == 0){
			$point2 = $this->cekCuti($nim,$semesterAkademik); // true
			update (true(1), false(0))
		} else {
			$point2 = $point2
		}

		if ($point3 == 0){
			$point3 = $this->cekBiodata($nim,$semesterAkademik);
			update (true(1), false(0))
		} else {
			$point3 = $point3
		}

=====================

		if($point1){ cekHutang

			if($point2){

				if($point3){

				}

			}

		}




		}else{
				$cekHutang = $this->cekHutang($nim,$semesterAkademik);
				if($cekHutang){
					$cekCuti = $this->cekCuti($nim,$semesterAkademik);
					if($cekCuti){
						$cekBiodata = $this->cekBiodata($nim,$semesterAkademik);
						if($cekBiodata){
							$cekMhswAktif = $this->cekMhswAktif($nim,$semesterAkademik);
							if($cekMhswAktif['status']!=false){
								$qSemesterAkademikAktif= $this->krs_model->getSemesterAkademikAktif();
								$semesterAkademikAktif = $qSemesterAkademikAktif->periode_aktif;
								if($semesterAkademik==$semesterAkademikAktif){
									$cekMhswDikti = $this->mhsw_pdpt($nim,$semesterAkademik);
									if($cekMhswDikti==0){
										$abaikan = $this->abaikan($nim,$semesterAkademik);
										if($abaikan==0){
											$tampil = $this->tabel_error($nim,$semesterAkademik);
											$dataView = array(
												'view' => $tampil,
												'data' => $data
											);
											echo json_encode($dataView);
										}else{
											$tampil = $this->tampilKrs($nim,$semesterAkademik);
											$dataView = array(
												'view' => $tampil,
												'data' => $data
											);
											echo json_encode($dataView);
										}
									}else{
										$tampil = $this->tampilKrs($nim,$semesterAkademik);
										$dataView = array(
											'view' => $tampil,
											'data' => $data
										);
										echo json_encode($dataView);
									}
								}else{
									$tampil = $this->tampilKrs($nim,$semesterAkademik);
									$dataView = array(
										'view' => $tampil,
										'data' => $data
									);
									echo json_encode($dataView);
								}
							}else{
								$dataErr = array(
									'error' => $cekMhswAktif['msgError'],
								);
								echo json_encode($dataErr);
							}
						}else{
							$dataErr = array(
								'error' => 'Silahkan Isi/Cek Terlebih dahulu Biodata <b>Nama ibu, Tempat/tanggal lahir </b><a style="color:blue;" href="#">Isi Biodata</a>',
							);
							echo json_encode($dataErr);
						}
					}else{
						$dataErr = array(
							'error' => 'Anda Masih Terdaftar Cuti',
						);
						echo json_encode($dataErr);
					}
				}else{
					$dataErr = array(
						'error' => 'Anda Belum Bayar SPP semester '.$semesterAkademik.'<br><b>Hubungi Admin di Fakultas Anda !</b>',
					);
					echo json_encode($dataErr);
				}
			}*/
			/*$url = base_url('api/ademik/mhswkrs/search');
			$semesterAkademik = $this->input->post('semesterAkademik');
			$nim = $this->input->post('nim');

			$params = array(
				'semesterAkademik' => $semesterAkademik,
				'nim' => $nim
			);

			$options = array(
				'https' => array(
					'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					'method'  => 'POST',
					'content' => http_build_query($params)
				),
				"ssl"=>array(
					"verify_peer"		=>false,
					"verify_peer_name"	=>false,
				)
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			if ($result === FALSE) {
				echo "Inputan Salah";
			}

			echo "<script>console.log(".$result.")</script>";
			$json = json_decode($result);

			if($json->stats==false){
				$data['error']=$json->message;
			}else{
				$data['success']=$json->message;
			}
			$this->load->view('templates/header');
			$this->load->view('modules/stocks/orders/new',$data);
			$this->load->view('templates/footer');	*/
		}
	}

	public function validasiSpc($nim,$semesterAkademik)
	{
		$result = $this->krs_model->sinkronspp($nim,$semesterAkademik);
		// print_r($result);
		echo json_encode($result['status']);
	}

	public function prcspc($nim,$semesterAkademik){
		$result = $this->krs_model->sinkronspp($nim,$semesterAkademik);
		if ($result['status']){
			$data['success']="Data berhasil di proses";
		} else {
			$data['error']="$nim SPP Belum di Bayar untuk Tahun Akademik $semesterAkademik,";
		}
		$this->load->view('temp/head');
		$this->load->view('ademik/mhswkrs',$data);
		$this->load->view('temp/footers');
	}

	public function cekHutang($nim,$semesterAkademik){
		$cekBayar = $this->krs_model->getBayar($nim,$semesterAkademik);
		if($cekBayar==false){
			return false;
		}else{
			$bayar = $cekBayar->bayar;
			if($bayar==1 || $bayar==2 || $bayar==3 || $semesterAkademik=='20164' || $semesterAkademik=='20163' ||  $semesterAkademik<='20152' || $semesterAkademik=='20153' ){
				return true;
			}else{
				return false;
			}
		}
		return false;
	}

	public function cekCuti($nim,$semesterAkademik){
		$cekCuti = $this->krs_model->getCuti($nim,$semesterAkademik);

		if($cekCuti){
			$smt_mulai_cuti = $cekCuti->smt_mulai_cuti;
			$smt_akhir_cuti = $cekCuti->smt_akhir_cuti;
			$sekarang = date('Y-m-d');
			if (($smt_mulai_cuti <= $sekarang) and ($sekarang <= $smt_akhir_cuti)){
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}

		return false;
	}

	public function cekBiodata($nim,$semesterAkademik){
		$cekBiodata = $this->krs_model->getBiodata($nim,$semesterAkademik);

		if($cekBiodata){
			return true;
		} else{
			return false;
		}
		return false;
	}

	public function cekMhswAktif($nim, $semesterAkademik) {
		$cekMhswAktif  = $this->krs_model->getMhswAktif($nim,$semesterAkademik);
		if ($cekMhswAktif->Keluar == 0) {
			$cekMhswAktifSemester = $this->krs_model->getMhswAktifSemester($nim,$semesterAkademik);
			/*$s = "select s.Nilai, s.Nama
			from khs h left outer join statusmhsw s on h.Status=s.Kode
			where h.Tahun='$thn' and h.NIM='$nim' limit 1	";
			$r = mysql_query($s) or die ("$strCantQuery: $s");*/
			if ($cekMhswAktifSemester == false) {
				$cekKodeFakultas = $this->krs_model->getKodeFakultas($nim);
				//$kdf = $cekKodeFakultas->KodeFakultas;
				$ulevel = $_SESSION['ulevel'];
				if($cekMhswAktif->Kode=='C'){
					$dataMsg['msgError'] = "Mahasiswa <b>$nim</b> tidak aktif untuk tahun ajaran <b>$semesterAkademik</b>.<br>Status: <b>".$cekMhswAktif->Nama."</b>";
				}/*elseif($semesterAkademik=='20163' && $ulevel=='4' && $kdf !='A' && $kdf !='F' && $kdf !='F'){
					$dataMsg['msgError'] = "Mahasiswa <b>$nim</b> tidak aktif untuk tahun ajaran <b>$semesterAkademik</b>.<br>Status: <b>".$cekMhswAktif->Nama."</b><br>Jika belum registrasi ulang, silakan hubungi admin di fakultas Anda !";
				}*/else{
					$dataMsg['msgError'] = "Mahasiswa <b>".$nim."</b> tidak aktif untuk tahun ajaran <b>".$semesterAkademik."</b>.<br>Status: <b>".$cekMhswAktif->Nama."</b><br>Jika belum registrasi ulang, silakan registrasi ulang dahulu.<hr size=1 color=silver>Pilihan : <button type='button' class='btn btn-block btn-info' data-toggle='modal' data-nim='".$nim."' data-semester-akademik='".$semesterAkademik."' data-target='#modal-registrasiUlang' id='openModalRegistrasiUlang'>Registrasi Ulang</button>";
				}
				$dataMsg['status'] = false;

				return $dataMsg;
			}
			else {
				if ($cekMhswAktifSemester->Nilai == 1) {
					$dataMsg['status'] = true;

					return $dataMsg;
				}else {
					if($cekMhswAktifSemester->Kode=='C'){
						$dataMsg['msgError'] = "Mahasiswa <b>".$nim."</b> tidak aktif untuk tahun ajaran <b>".$semesterAkademik."</b>.<br>Status: <b>".$cekMhswAktifSemester->Nama."</b>";
					}else{
						$dataMsg['msgError'] = "Mahasiswa <b>".$nim."</b> tidak aktif untuk tahun ajaran <b>".$semesterAkademik."</b>.<br>Status: <b>".$cekMhswAktifSemester->Nama."</b><br>Jika belum registrasi ulang, silakan registrasi ulang dahulu.<hr size=1 color=silver>Pilihan : <button type='button' class='btn btn-block btn-info' data-toggle='modal' data-nim='".$nim."' data-semester-akademik='".$semesterAkademik."' data-target='#modal-registrasiUlang' id='openModalRegistrasiUlang'>Registrasi Ulang</button>";
					}
					$dataMsg['status'] = false;

					return $dataMsg;
				}
			}
		}
		else {
			$dataMsg['msgError'] = "Mahasiswa berstatus: <b>".$cekMhswAktif->Nama."</b>.<br>Tidak dapat mengisi KRS.";
			$dataMsg['status'] = false;

			return $dataMsg;
		}
	}

	public function tampilKrs($nim, $semesterAkademik) {
		$cekKodeFakultas = $this->krs_model->getKodeFakultas($nim);
		$kdf = $cekKodeFakultas->KodeFakultas;

		$snm = session_name(); $sid = session_id();

		/*$cekVal = $this->krs_model->getVal($nim, $semesterAkademik);
		$st_val = $cekVal->st_val;
		$tgl_val = $cekVal->tgl_val;*/
		$btnAdd = '';
		$btnPackage = '';

		$container = "<div class='col-md-12'><div class='row'>";

		/*if($st_val==1){
			$valkrs ="KRS ini sudah divalidasi tanggal $tgl_val";
		}else {
			$valkrs ="<div class='col-md-2'><button class='btn btn-block btn-warning' style='color:white;' type=submit name='prcvalkrs'>Validasi</button></div>";

			
		}*/

		//didalam else st_val
		$sid = $_SESSION['id'];
		$snm = $_SESSION['uname'];
		$cekKode = $this->krs_model->getKode($nim);
		$kdj = $cekKode->KodeJurusan;
		$kdp = $cekKode->KodeProgram;

		$bataskrs = $this->batasKrsNim1($semesterAkademik, $nim);
		if($bataskrs==1){
			$btnAdd = "<div class='col-md-2'><button type='button' class='btn btn-block btn-info' data-toggle='modal' data-id='".$sid."' data-name='".$snm."' data-kdj='".$kdj."' data-kdp='".$kdp."' data-nim='".$nim."' data-semester-akademik='".$semesterAkademik."' data-target='#modal-addKrs' id='openModalKrs'>Tambah KRS</button></div>"; //1
		}
		//selesainya


		$btnPrint = "<div class='col-md-2'><a href='".base_url('ademik/report/report/cetak_krs/'.$semesterAkademik.'/'.$nim)."' class='btn btn-block btn-success'>Cetak KRS</a></div>"; //2
		$btnPrintCard = "<div class='col-md-2'><button type='button' class='btn btn-block btn-success'>Cetak Kartu Ujian</button></div>"; //3


		$lev = $_SESSION['ulevel'];

		if($kdf=="N"||$lev=="1"){
			$btnPackage = "<div class='col-md-2'><button type='button' class='btn btn-block btn-info' data-toggle='modal' data-id='".$sid."' data-name='".$snm."' data-kdj='".$kdj."' data-kdp='".$kdp."' data-nim='".$nim."' data-semester-akademik='".$semesterAkademik."' data-target='#modal-addPaket' id='openModalPaket'>Tambah Paket</button></div>"; //4
		}

		if($lev=="4"){
			$btnTranskip = "<div class='col-md-2'><button type='button' class='btn btn-block btn-primary'>Cetak Transkip</button></div>"; //3
		}else{
			$btnTranskip ="";
		}

		$closeContainer = "</div></div>";

		$hdrHapus = '<th><b>Hapus</b></th>';

		$tbl = "_v2_krs$semesterAkademik";
		

		$getDataKrs = $this->krs_model->getDataKrs($tbl,$nim,$semesterAkademik);

		//echo $valkrs; //5
		$headTable= "<br /><table id='tableKrs' class='table table-bordered table-responsive'>";
		$cnt = 0; $prg = ''; $sumsks=0;
		$header = '';
		$tableContent = '';

		foreach ($getDataKrs as $show) {
			$kelas=$show->Keterangan;
			$cnt++;
			if ($prg != $show->Program) {
				$prg = $show->Program;
				if($this->session->ulevel==4){
					$bataskrs = $this->batasKrsNim2($semesterAkademik, $nim);
					if($bataskrs<1){
						$hdrHapus = "";
					}
				}

				if($this->session->ulevel==5 OR $this->session->ulevel==7){
					$bataskrs = $this->batasKrsNim2($semesterAkademik, $nim);
					if($bataskrs<1){
						$hdrHapus = "";
					}
				}
				$validaiDosen = '';
				$colspan = 14;
				if($semesterAkademik>=20191) {
					$colspan = 15;
					$validaiDosen = '<th><b>Validasi Dosen Wali</b></th>';
				}
				$header =  "<tr><td colspan=$colspan ><b>".$show->PRG."</b></td></tr>
				<tr>
					<th><b>#</b></th>
					<th><b>KodeMK</b></th>
					<th><b>Mata Kuliah</b></th>
					<th><b>SKS</b></th>
					<th><b>Dosen</b></th>
					<th><b>Hari</b></th>
					<th><b>Mulai</b></th>
					<th><b>Selesai</b></th>
					<th><b>Ruang</b></th>
					<th><b>Kelas</b></th>
					<th><b>Pernah diambil</b></th>
					<th><b>Kehadiran(%)</b></th>
					<th><b>Tgl Input</b></th>
					$validaiDosen
					$hdrHapus
				</tr>";	//6
			}
			$pernah = $this->cekPernahAmbil($nim, $semesterAkademik, $show->KodeMK);

			//<a href='ademik.php?syxec=mhswkrs&prcdel=".$show->ID."'><img src='image/del.gif' border=0 title='Hapus: ".$show->KodeMK."'></a>
			//if ($prn == 0) {
				$strHapus = "
				<button class='btn btn-social-icon btn-danger deleteButton' data-id='".$show->ID."' data-nim='".$nim."' data-thn='".$semesterAkademik."'><i class='fa fa-trash' style='color:white;'></i></button>";
			/*}
			else {
				$strHapus = '';
			}*/
			$sks=$show->SKS;
			$sumsks=$sumsks+$sks;


			$tdHapus = "<td align=center>$strHapus</td>";
			if($this->session->ulevel==4){
				$bataskrs = $this->batasKrsNim2($semesterAkademik, $nim);
				if($bataskrs==1){
					$tdHapus = "<td align=center>$strHapus</td>";
				}else{
					$tdHapus = "";
				}
			}

			if($this->session->ulevel==5 OR $this->session->ulevel==7){
				$bataskrs = $this->batasKrsNim2($semesterAkademik, $nim);
				if($bataskrs==1){
					$tdHapus = "<td align=center>$strHapus</td>";
				}else{
					$tdHapus = "";
				}
			}

			$dataWali = '';
			if($semesterAkademik>=20191) {
				if($show->st_wali == 0){
					$setujui = "<p style='color:red;'>Matakuliah belum disetujui</p>";
				}else{
					$setujui = "<p style='color:green;'>MataKuliah telah disetuju</p>";
				}
				$dataWali = '<td align=center>'.$setujui.'</td>';
			}

			$tableContent = $tableContent."<tr id='row_".$show->ID."'>
			<td>$cnt</td>
			<td>".$show->KodeMK."</td>
			<td>".$show->MK."</td>
			<td align=right>$sks</td>
			<td>".$show->Dosen."&nbsp;</td>
			<td>".$show->HR."</td>
			<td>".$show->jm."</td>
			<td>".$show->js."</td>
			<td>".$show->KodeRuang."&nbsp;</td>
			<td>".$show->Keterangan."&nbsp;</td>

			<td align=center>".$pernah."</td>
			<td align=center><font color='FF0000'>".$show->Hadir."</font></td>
			<td align=center>".$show->Tanggal."</td>
			$dataWali

			$tdHapus
			</tr> "; //7
		}
		$footTable = "</table><br>"; //8
		$mhswBaru = $this->krs_model->cekMhswAkademik($nim);
		$tahun_akademik=$mhswBaru->TahunAkademik;
		
		if($tahun_akademik==substr($semesterAkademik,0,4)){
			$maxsks = 24;
		}else{
			$cekSks = $this->krs_model->getMaxSks($nim,$semesterAkademik);
			$maxsks = $cekSks->MaxSKS;
		}
		if(substr($semesterAkademik,4,1)==3 || substr($semesterAkademik,4,1)==4) {
			if($kdf=='P'){
				$maxsks=10;
			}else{
				$maxsks=9;
			}
		}
		
		if ($sumsks > $maxsks) {
			$errsks = "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
		} else {
			$errsks = "";
		}
		$footerTable = "<table class=box cellspacing=0 cellpadding=4>
		<small class='text-danger'><b>*Jika status matakuliah belum disetujui silahkan menghadap ke dosen wali untuk persetujuan </b></small>
		<tr><td class=lst>Total SKS yang diambil : </td><th class=ttl>$sumsks</th>
		<td class=basic rowspan=2>$errsks</td></tr>
		<tr>
			<td class=lst>Maximum SKS yg boleh diambil :</td>
			<th class=ttl>$maxsks</th>
			<th>
				<button id='refreshIPK' data-thn='".$semesterAkademik."' data-nim='".$nim."'>Refresh SKS MAX</button>
			</th>
		</tr>
		<tr><td height=2></td></tr></table>
		"; //9


		/*
		$showGetKrs = $this->krs_model->daftarKrs($nim,$semesterAkademik,$kdj,$kdp);*/

		//.$valkrs
		return $container.$btnAdd.$btnPrint.$btnPrintCard.$btnTranskip.$btnPackage.$closeContainer.$headTable.$header.$tableContent.$footTable.$footerTable;
	}

	function tabel_error($nim, $thn){
		$headTable = "<table class='box' cellspacing='1' cellpadding='2' align='center'>
			<thead>
				<tr>
					<th colspan=2 class=ttl style='background:#f9a927; width:80%;'>Terdapat Error</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
			";

		$nim=str_replace(" ","",$nim);
		$thn1=substr($thn, 0,4);
		$thn2=substr($thn, 4,1);

		if($thn2==2){
			$thn2=$thn2-1;
			$thn=$thn1.$thn2;
		}elseif($thn2==1){
			$thn1=$thn1-1;
			$thn=$thn1.'2';
		}

		$qMhs= $this->krs_model->getIdRegMhsw($nim);
		$id_reg_pd=$qMhs->id_reg_pd;

		if($id_reg_pd=="" or $id_reg_pd==null){
			$mhs_pdpt=0;
		}else{
			$mhs_pdpt=1;
		}

		if($id_reg_pd=="0"){
			$mhs_pdpt=0;
		}


		$rowRegMhsw = "";
		if($mhs_pdpt==1){
			$rowRegMhsw = "<span class='glyphicon glyphicon-ok'> Mahasiswa Terdaftar di PDPT</span>";
		}elseif($mhs_pdpt==0){
			$rowRegMhsw= "<form method='POST' target='_blank' action='".base_url('ademik/mhswkrs/cekDataMhsw')."'><input type='hidden' name='nim' readonly value='".$nim."'><input type='hidden' name='thn' readonly value='".$thn."'><span class='glyphicon glyphicon-remove' aria-hidden='true'> Mahasiswa Tidak Terdaftar di PDPT&nbsp;</span><input type='submit' name='cek' value='Cek Data' class='btn btn-warning'></form>";
		}

		$closeRow= "
					</td>
				</tr>
				<tr>
					<td>
		";

		$thnkrs=$thn;
		
		$tbl= "_v2_krs".$thnkrs;

		$qKrs=$this->krs_model->getStFeederKrs($tbl,$nim);
		//$data_krs=mysql_fetch_array($query_krs);
		$count_krs=0;

		foreach ($qKrs as $show) {
			if(/*( $show->NamaMK=='Seminar'  || $show->NamaMK=='Seminar Proposal'  || $show->NamaMK=='PROPOSAL SKRIPSI' || $show->NamaMK=='Skripsi' || $show->NamaMK=="Praktik Lapangan (Magang)" || $show->NamaMK=="SKRIPSI" || $show->NamaMK=="Ko-Kurikuler" || $show->NamaMK=="Kuliah Kerja Profesi (KKP) / KKN") || $show->NamaMK=="SEMINAR HASIL" || $show->NamaMK=="SEMINAR PROPOSAL" && */$show->Bobot=='-1'){
			}else{
				if($show->st_feeder<=0){
					$count_krs++;
				}
			}
		}

		$rowKrs = "";
		if($count_krs==0){
			$rowKrs= "<span class='glyphicon glyphicon-ok'> KRS Periode $thn telah terdaftar di pdpt</span>";
		}elseif($count_krs>0){
			$rowKrs= "<form method='POST' target='_blank' action='".base_url('ademik/mhswkrs/cekDataKrs')."'><input type='hidden' name='nim' readonly value='".$nim."'><input type='hidden' name='thn' readonly value='".$thn."'><span class='glyphicon glyphicon-remove' aria-hidden='true'> $count_krs Mata Kuliah pada KRS Periode $thn belum terdaftar di pdpt&nbsp;</span><input type='submit' name='cek' value='Cek Data' class='btn btn-warning'></form>";
		}
		/*echo "
					</td>
				</tr>
				<tr>
					<td>
		";*/

		$query_khs=$this->krs_model->getStFeederKhs($nim,$thn);
		$st_feeder_khs=$query_khs->st_feeder;


		if($st_feeder_khs=="" or $st_feeder_khs==null or $st_feeder_khs<=0){
			$khs_feeder=0;
		}else{
			$khs_feeder=1;
		}

		$rowKhs= "";
		if($khs_feeder==1){
			$rowKhs= "<span class='glyphicon glyphicon-ok'> KHS Periode $thn telah terdaftar di pdpt</span>";
		}elseif($khs_feeder==0){
			$rowKhs= "<form method='POST' target='_blank' action='".base_url('ademik/mhswkrs/cekDataKhs')."'><input type='hidden' name='nim' readonly value='".$nim."'><input type='hidden' name='thn' readonly value='".$thn."'><span class='glyphicon glyphicon-remove' aria-hidden='true'> KHS Periode $thn belum terdaftar di pdpt&nbsp;</span><input type='submit' name='cek' value='Cek Data' class='btn btn-warning'></form>";
		}

		$closeTable= "
					</td>
				</tr>
			</tbody>
		</table>";

		return $headTable.$rowRegMhsw.$closeRow.$rowKrs.$closeRow.$rowKhs.$closeTable;
	}

	public function cekDataMhsw(){
		$nim = $this->input->post('nim');
		$thn = $this->input->post('thn');

		$data['cekMhsw']=$this->krs_model->getCekMhsw($nim);
		$data['nim'] = $nim;
		$data['kategori'] = "mhsw";
		$data['controller'] = $this;
		$this->load->view('temp/head');
		$this->load->view('ademik/cek_feeder',$data);
		$this->load->view('temp/footers');
	}

	public function getAgama(){
		$data = $this->krs_model->getAgama();
		return $data;
	}

	public function cekDataKhs(){
		$nim = $this->input->post('nim');
		$thn = $this->input->post('thn');

		$data['cekKhs']=$this->krs_model->getCekKhs($nim,$thn);
		$data['nim'] = $nim;
		$data['thn'] = $thn;
		$data['kategori'] = "khs";
		$this->load->view('temp/head');
		$this->load->view('ademik/cek_feeder',$data);
		$this->load->view('temp/footers');
	}

	public function cekDataKrs(){
		$nim = $this->input->post('nim');
		$thn = $this->input->post('thn');

		$tbl = "_v2_krs$thn";
		

		$data['cekKrs']=$this->krs_model->getCekKrs($nim,$thn,$tbl);
		$data['nim'] = $nim;
		$data['thn'] = $thn;
		$data['kategori'] = "krs";
		$data['controller'] = $this;
		$this->load->view('temp/head');
		$this->load->view('ademik/cek_feeder',$data);
		$this->load->view('temp/footers');
	}

	public function action_feeder(){
		$import_mhs = $this->input->post('import_mhs');
		$import_khs = $this->input->post('import_khs');
		$import_krs = $this->input->post('import_krs');
		$save_mhs = $this->input->post('save_mhs');
		$save_khs = $this->input->post('save_khs');
		$abaikan_krs = $this->input->post('abaikan_krs');
		$abaikan_khs = $this->input->post('abaikan_khs');
		if(isset($import_mhs)){
			$this->import_mhsw_feeder($this->input->post('nim'));
		}
		if(isset($save_mhs)){
			$this->save_mhs_db();
		}
		if(isset($save_khs)){
			$this->save_khs_db();
		}
		if(isset($import_khs)){
			$this->import_khs_feeder();
		}
		if(isset($import_krs)){
			$this->import_krs_feeder();
		}
		if(isset($abaikan_krs)){
			$this->abaikan_krs($this->input->post('id_KRS'),$this->input->post('nim'),$this->input->post('thn'));
		}
		if(isset($abaikan_khs)){
			$this->abaikan_khs($this->input->post('nim_khs'),$this->input->post('tahun_khs'));
		}
	}

	public function save_mhs_db(){
		$NamaOT = $this->input->post('NamaOT');
		$NamaIbu = $this->input->post('NamaIbu');
		$jk = $this->input->post('jk');
		$tempat = $this->input->post('TempatLahir');
		$tgl_lhr = $this->input->post('TglLahir');

		$agama = $this->input->post('Agama');
		$NIK = $this->input->post('NIK');
		$nimd = $this->input->post('nim');

		$data = array('NamaOT' => $NamaOT, 'NamaIbu' => $NamaIbu, 'jk' => $jk, 'tempat' => $tempat, 'tgl_lhr' => $tgl_lhr, 'agama' => $agama, 'NIK' => $NIK, 'nimd' => $nimd);
		$update_mhsw=$this->krs_model->save_mhsw_db($data);

		if($update_mhsw){
			$data['status']="sukses";
			$data['cekMhsw']=$this->krs_model->getCekMhsw($nimd);
			$data['nim'] = $nim;
			$data['kategori'] = "mhsw";
			$data['controller'] = $this;
			$this->load->view('temp/head');
			$this->load->view('ademik/cek_feeder',$data);
			$this->load->view('temp/footers');
		}
	}

	public function import_mhsw_feeder(){
		$feeder = $this->feeder->getToken_feeder();
		$temp_token = $feeder['temp_token'];
		$temp_proxy = $feeder['temp_proxy'];

		$nim=$this->input->post('nim');
		$NIM=str_replace(" ","",$nim);

		$dataFeeder = $this->krs_model->getMhswFeeder($NIM);
		$usrid = $dataFeeder->ID;

		$nama = $dataFeeder->Name;
		$NIK = $dataFeeder->NIK;

		$jenis_pendaftaran = $dataFeeder->StatusAwal;
		if($jenis_pendaftaran=="P") $jenis_pendaftaran=2;
		else $jenis_pendaftaran=1;

		$tgl_daftar = $dataFeeder->Tanggal;
		$prodi = $dataFeeder->id_sms;
		$periode_daftar = $dataFeeder->Semester;
		$Status = $dataFeeder->Status;
		if($Status=="U") $Status="A";

		$SKSditerima = round($dataFeeder->SKSditerima);

		$ProdiAsal = $dataFeeder->ProdiAsal;
		$UniversitasAsal = $dataFeeder->UniversitasAsal;
		$StatusAwal = $dataFeeder->StatusAwal;
		$id_sms = $dataFeeder->id_sms;

		$NamaOT = $this->input->post('NamaOT');
		$NamaIbu = $this->input->post('NamaIbu');
		$jk = $this->input->post('jk');
		$tempat = $this->input->post('TempatLahir');
		$tgl_lhr = $this->input->post('TglLahir');

		$agama = $this->input->post('Agama');
		$nimd = $NIM;

		$record = new stdClass();
		$record->nm_pd = $nama;
		$record->jk = $jk;
		$record->tmpt_lahir = $tempat;
		$record->tgl_lahir = $tgl_lhr;
		$record->nik = $NIK;
		$record->id_wil = "186000";
		$record->ds_kel = "Tondo";
		$record->nm_ibu_kandung = $NamaIbu;
		$record->nm_ayah = $NamaOT;
		$record->id_agama = $agama;
		$record->id_kk = 0;
		$record->id_sp = "8e5d195a-0035-41aa-afef-db715a37b8da";
		$record->id_wil = "186000";
		$record->a_terima_kps = "0";
		$record->stat_pd = $Status;
		$record->id_kebutuhan_khusus_ayah = "0";
		$record->id_kebutuhan_khusus_ibu = "0";
		$record->kewarganegaraan = "ID";

		$table = 'mahasiswa';

		// action insert ke feeder
		$action = 'InsertRecord';

		// insert tabel mahasiswa ke feeder
		$resultb = $this->feeder->action_feeder($temp_token,$temp_proxy,$action,$table,$record);

		$id_pd = null;
		$datb = $resultb['result'];
		$id_pd = $datb['id_pd'];
		$error_code = $datb['error_code'];
		$error_desc = $datb['error_desc'];
		if ($id_pd != null) {
			$this->krs_model->updateIdPd($id_pd, $nim);

			if ($periode_daftar < '20091') $periode_daftar = '20161';

			// Mahasiswa PT

			$record_pt = new stdClass();
			$record_pt->nipd = $nim;
			$record_pt->id_pd = $id_pd;
			$record_pt->tgl_masuk_sp = $tgl_daftar;
			$record_pt->id_jns_daftar = $jenis_pendaftaran;
			$record_pt->mulai_smt = $periode_daftar;
			$record_pt->id_sp = "8e5d195a-0035-41aa-afef-db715a37b8da";
			$record_pt->id_sms = $id_sms;
			$record_pt->a_pernah_paud = 0;
			$record_pt->a_pernah_tk = 0;

			$table1 = 'mahasiswa_pt';

			// action insert ke feeder
			$action1 = 'InsertRecord';

			// insert tabel mahasiswa ke feeder
			$resultb_pt = $this->feeder->action_feeder($temp_token,$temp_proxy,$action1,$table1,$record_pt);

			$datb_pt = $resultb_pt['result'];
			$id_reg_pd = $datb_pt['id_reg_pd'];
			if ($id_reg_pd != null) {
				$data = array('id_reg_pd' => $id_reg_pd, 'st_feeder' => "1", 'nimd' => $nimd);
				$update_mhsw=$this->krs_model->save_mhsw_reg_pd($data);

				if($update_mhsw){
					$data['status']="feeder";
					$data['msg']="Data Berhasil di update";
					$data['cekMhsw']=$this->krs_model->getCekMhsw($nimd);
					$data['nim'] = $nim;
					$data['kategori'] = "mhsw";
					$data['controller'] = $this;
					$this->load->view('temp/head');
					$this->load->view('ademik/cek_feeder',$data);
					$this->load->view('temp/footers');
				}
			}else{
				$data['status']="error_feeder";
				$data['msg']="Belum ada REG PD";
				$data['cekMhsw']=$this->krs_model->getCekMhsw($nimd);
				$data['nim'] = $nim;
				$data['kategori'] = "mhsw";
				$data['controller'] = $this;
				$this->load->view('temp/head');
				$this->load->view('ademik/cek_feeder',$data);
				$this->load->view('temp/footers');
			}
		}elseif ($error_code == '200'){
			$record_pt = new stdClass();
			$record_pt->nipd = $nimd;

			$qId_pd = $this->krs_model->getIdPd($NIM);

			$record_pt->id_pd = $qId_pd->id_pd;

			$record_pt->tgl_masuk_sp = $tgl_daftar;
			$record_pt->id_jns_daftar = $jenis_pendaftaran;
			$record_pt->mulai_smt = $periode_daftar;
			$record_pt->id_sp = "8e5d195a-0035-41aa-afef-db715a37b8da";
			$record_pt->id_sms = $id_sms;
			$record_pt->a_pernah_paud = 0;
			$record_pt->a_pernah_tk = 0;

			//echo json_encode($record_pt);

			$table = 'mahasiswa_pt';

			// action insert ke feeder
			$action = 'InsertRecord';

			// insert tabel mahasiswa ke feeder
			$datb_pt = $this->feeder->action_feeder($temp_token,$temp_proxy,$action,$table,$record_pt);

			$error_code1 = $datb_pt['error_code'];
			$error_desc1 = $datb_pt['error_desc'];

			$id_reg_pd = null;

			// error 211 desc : Mahasiswa ini sudah terdaftar (panjang string 29)
			if ($error_code1 != 211) $id_reg_pd = $datb_pt['id_reg_pd'];

			if ($id_reg_pd != null)
			{
				$data = array('id_reg_pd' => $id_reg_pd, 'st_feeder' => "1", 'nimd' => $nimd);
				$update_mhsw=$this->krs_model->save_mhsw_reg_pd($data);

				if($update_mhsw){
					$data['status']="feeder";
					$data['msg']="Data Berhasil di update";
					$data['cekMhsw']=$this->krs_model->getCekMhsw($nimd);
					$data['nim'] = $nim;
					$data['kategori'] = "mhsw";
					$data['controller'] = $this;
					$this->load->view('temp/head');
					$this->load->view('ademik/cek_feeder',$data);
					$this->load->view('temp/footers');
				}
			} else {
				$data['status']="error_feeder";
				$data['msg']="Belum ada REG PD";
				$data['cekMhsw']=$this->krs_model->getCekMhsw($nimd);
				$data['nim'] = $nim;
				$data['kategori'] = "mhsw";
				$data['controller'] = $this;
				$this->load->view('temp/head');
				$this->load->view('ademik/cek_feeder',$data);
				$this->load->view('temp/footers');
			}
		}else{
			$data['status']="error_feeder";
			$data['msg']="Data Error ".$error_code." ".$error_desc;
			$data['cekMhsw']=$this->krs_model->getCekMhsw($nimd);
			$data['nim'] = $nim;
			$data['kategori'] = "mhsw";
			$data['controller'] = $this;
			$this->load->view('temp/head');
			$this->load->view('ademik/cek_feeder',$data);
			$this->load->view('temp/footers');
		}

	}


	public function import_krs_feeder(){
		$thn = $this->input->post('thn');

		$feeder = $this->feeder->getToken_feeder();
		$temp_token = $feeder['temp_token'];
		$temp_proxy = $feeder['temp_proxy'];

		$ID_KRS=$this->input->post('id_KRS');
		$tbl = "_v2_krs$thn";
		
		$qKrsFeeder=$this->krs_model->get_krs_feeder($tbl, $ID_KRS);

		foreach ($qKrsFeeder as $show) {
			$IDKRS = $show->IDKRS;
			$id_kls = $show->id_kls;
			$id_reg_pd = $show->id_reg_pd;
			$NIM = $show->NIM;
			$nil_ang = $show->nilai_angka;
			$nil_huruf = $show->nilai_huruf;
			$nil_indeks = $show->nilai_indeks;
			$kode_mk = $show->KodeMK;
			$idjadwal = $show->IDJADWAL;
			$tahun = $show->Tahun;
			$nilai_huruf = $show->nilai_huruf;
			$kodefakultas = $show->KodeFakultas;

			/*$dataEncrypt = $this->encryption->encrypt($NIM."|".$kode_mk."|".$tahun."|".$nilai_huruf);
			$encrypt=$this->krs_model->create_encrypt($dataEncrypt,$IDKRS,$tbl);

			if($encrypt==true){
				echo $dataEncrypt;
			}*/

			if($tahun >= 20182 AND ($kodefakultas == "A" OR $kodefakultas == "F" OR $kodefakultas == "H")){
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
						$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$thn,$tbl);
						$data['nim'] = $NIM;
						$data['thn'] = $thn;
						$data['kategori'] = "krs";
						$data['controller'] = $this;
						$data['status']="feeder";
						$data['msg']="Data Berhasil di input";
						$this->load->view('temp/head');
						$this->load->view('ademik/cek_feeder',$data);
						$this->load->view('temp/footers');
					}else{
						$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$thn,$tbl);
						$data['nim'] = $NIM;
						$data['thn'] = $thn;
						$data['kategori'] = "krs";
						$data['controller'] = $this;
						$data['status']="error_feeder";
						$data['msg']="Data Gagal di input";
						$this->load->view('temp/head');
						$this->load->view('ademik/cek_feeder',$data);
						$this->load->view('temp/footers');
					}
				}else if($error_code == 800 or $error_code == 103){
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
							$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$thn,$tbl);
							$data['nim'] = $NIM;
							$data['thn'] = $thn;
							$data['kategori'] = "krs";
							$data['controller'] = $this;
							$data['status']="feeder";
							$data['msg']="Data Berhasil di input";
							$this->load->view('temp/head');
							$this->load->view('ademik/cek_feeder',$data);
							$this->load->view('temp/footers');
						}else{
							$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$thn,$tbl);
							$data['nim'] = $NIM;
							$data['thn'] = $thn;
							$data['kategori'] = "krs";
							$data['controller'] = $this;
							$data['status']="error_feeder";
							$data['msg']="Data Gagal di input";
							$this->load->view('temp/head');
							$this->load->view('ademik/cek_feeder',$data);
							$this->load->view('temp/footers');
						}
					}else{
						$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$thn,$tbl);
						$data['nim'] = $NIM;
						$data['thn'] = $thn;
						$data['kategori'] = "krs";
						$data['controller'] = $this;
						$data['status']="error_feeder";
						$data['msg']="Data gagal Update ".$error_code1." ".$error_desc1;
						$this->load->view('temp/head');
						$this->load->view('ademik/cek_feeder',$data);
						$this->load->view('temp/footers');
					}


				}else{
					$sql = $this->krs_model->updateKrsFeeder($IDKRS, $tbl, "-3");
					if($sql){
						$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$thn,$tbl);
						$data['nim'] = $NIM;
						$data['thn'] = $thn;
						$data['kategori'] = "krs";
						$data['controller'] = $this;
						$data['status']="error_feeder";
						$data['msg']="Proses Gagal ".$error_code."-".$error_desc;
						$data['error']=$record;
						$this->load->view('temp/head');
						$this->load->view('ademik/cek_feeder',$data);
						$this->load->view('temp/footers');
					}else{
						$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$thn,$tbl);
						$data['nim'] = $NIM;
						$data['thn'] = $thn;
						$data['kategori'] = "krs";
						$data['controller'] = $this;
						$data['status']="error_feeder";
						$data['msg']="Data Gagal di input";
						$this->load->view('temp/head');
						$this->load->view('ademik/cek_feeder',$data);
						$this->load->view('temp/footers');
					}
				}
			}else{
				$getEncrypt = $this->krs_model->get_encrypt($IDKRS,$tbl);
				$krsEncrypt = $getEncrypt->enkripsi;
				$dataDecrypt = $this->encryption->decrypt($krsEncrypt);

				//echo $krsEncrypt."<br>";
				//echo $dataDecrypt."<br>";
				$decrypt=explode('|', $dataDecrypt);
				//echo $decrypt[0].$decrypt[1].$decrypt[2].$decrypt[3]."<br>";

				if($decrypt[0]==$NIM AND $decrypt[1]==$idjadwal AND $decrypt[2]==$tahun AND $decrypt[3]==$nilai_huruf AND $decrypt[4]==$nil_indeks){
					if($tahun >= 20182){
						$msgDecrypt = "Data Benar"."<br>";
						$encrypt = $this->encryption->encrypt($decrypt[0]."|".$decrypt[1]."|".$decrypt[2]."|".$decrypt[3]."|".$decrypt[4]);

						$this->krs_model->save_encrypt($NIM,$thn,$kode_mk,$encrypt,$tbl);
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
							$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$thn,$tbl);
							$data['nim'] = $NIM;
							$data['thn'] = $thn;
							$data['kategori'] = "krs";
							$data['controller'] = $this;
							$data['status']="feeder";
							$data['msg']="Data Berhasil di input";
							$this->load->view('temp/head');
							$this->load->view('ademik/cek_feeder',$data);
							$this->load->view('temp/footers');
						}else{
							$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$thn,$tbl);
							$data['nim'] = $NIM;
							$data['thn'] = $thn;
							$data['kategori'] = "krs";
							$data['controller'] = $this;
							$data['status']="error_feeder";
							$data['msg']="Data Gagal di input";
							$this->load->view('temp/head');
							$this->load->view('ademik/cek_feeder',$data);
							$this->load->view('temp/footers');
						}
					}else if($error_code == 800 or $error_code == 103){
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
								$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$thn,$tbl);
								$data['nim'] = $NIM;
								$data['thn'] = $thn;
								$data['kategori'] = "krs";
								$data['controller'] = $this;
								$data['status']="feeder";
								$data['msg']="Data Berhasil di input";
								$this->load->view('temp/head');
								$this->load->view('ademik/cek_feeder',$data);
								$this->load->view('temp/footers');
							}else{
								$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$thn,$tbl);
								$data['nim'] = $NIM;
								$data['thn'] = $thn;
								$data['kategori'] = "krs";
								$data['controller'] = $this;
								$data['status']="error_feeder";
								$data['msg']="Data Gagal di input";
								$this->load->view('temp/head');
								$this->load->view('ademik/cek_feeder',$data);
								$this->load->view('temp/footers');
							}
						}else{
							$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$thn,$tbl);
							$data['nim'] = $NIM;
							$data['thn'] = $thn;
							$data['kategori'] = "krs";
							$data['controller'] = $this;
							$data['status']="error_feeder";
							$data['msg']="Data gagal Update ".$error_code1." ".$error_desc1;
							$this->load->view('temp/head');
							$this->load->view('ademik/cek_feeder',$data);
							$this->load->view('temp/footers');
						}


					}else{
						$sql = $this->krs_model->updateKrsFeeder($IDKRS, $tbl, "-3");
						if($sql){
							$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$thn,$tbl);
							$data['nim'] = $NIM;
							$data['thn'] = $thn;
							$data['kategori'] = "krs";
							$data['controller'] = $this;
							$data['status']="error_feeder";
							$data['msg']="Proses Gagal ".$error_code."-".$error_desc;
							$this->load->view('temp/head');
							$this->load->view('ademik/cek_feeder',$data);
							$this->load->view('temp/footers');
						}else{
							$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$thn,$tbl);
							$data['nim'] = $NIM;
							$data['thn'] = $thn;
							$data['kategori'] = "krs";
							$data['controller'] = $this;
							$data['status']="error_feeder";
							$data['msg']="Data Gagal di input";
							$this->load->view('temp/head');
							$this->load->view('ademik/cek_feeder',$data);
							$this->load->view('temp/footers');
						}
					}
				}else{
					//$data['msgDecrypt'] = "Data bermasalah hubungi UPT TIK";
					//$encrypt = "Data bermasalah";
					$data['cekKrs']=$this->krs_model->getCekKrs($NIM,$thn,$tbl);
					$data['nim'] = $NIM;
					$data['thn'] = $thn;
					$data['kategori'] = "krs";
					$data['controller'] = $this;
					$data['status']="error_feeder";
					$data['msg']="Data bermasalah hubungi UPT TIK";
					$this->load->view('temp/head');
					$this->load->view('ademik/cek_feeder',$data);
					$this->load->view('temp/footers');
				}
			}

			

			//echo $msgDecrypt.$encrypt;

			/**/
		}
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
		$nim = $this->input->post('nim_khs');
		$tahun = $this->input->post('tahun_khs');

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
					$data1['status']="feeder";
					$data1['msg']="Data Berhasil Di import";
					$data1['cekKhs']=$this->krs_model->getCekKhs($nim,$tahun);
					$data1['nim'] = $nim;
					$data1['thn'] = $tahun;
					$data1['kategori'] = "khs";
					$this->load->view('temp/head');
					$this->load->view('ademik/cek_feeder',$data1);
					$this->load->view('temp/footers');
				}else{
					$data1['status']="feeder";
					$data1['msg']="Data Berhasil di import tapi st_feeder gagal diupdate di khs";
					$data1['cekKhs']=$this->krs_model->getCekKhs($nim,$tahun);
					$data1['nim'] = $nim;
					$data1['thn'] = $tahun;
					$data1['kategori'] = "khs";
					$this->load->view('temp/head');
					$this->load->view('ademik/cek_feeder',$data1);
					$this->load->view('temp/footers');
				}
			} elseif ($error_code!=0){
				$error_desc = $rdikti['error_desc'];

				$data1['status']="error_feeder";
				$data1['msg']=$error_code."-".$error_desc." - ".json_encode($record);
				$data1['cekKhs']=$this->krs_model->getCekKhs($nim,$tahun);
				$data1['nim'] = $nim;
				$data1['thn'] = $tahun;
				$data1['kategori'] = "khs";
				$this->load->view('temp/head');
				$this->load->view('ademik/cek_feeder',$data1);
				$this->load->view('temp/footers');
			}else{
				$sql = $this->krs_model->updateKhsFeeder($ID);
				if($sql){
					$data1['status']="feeder";
					$data1['msg']="Data Berhasil di import";
					$data1['cekKhs']=$this->krs_model->getCekKhs($nim,$tahun);
					$data1['nim'] = $nim;
					$data1['thn'] = $tahun;
					$data1['kategori'] = "khs";
					$this->load->view('temp/head');
					$this->load->view('ademik/cek_feeder',$data1);
					$this->load->view('temp/footers');
					//echo "Data1 Berhasil Di import";
				}else{
					$data1['status']="feeder";
					$data1['msg']="Data Berhasil di import tapi st_feeder gagal diupdate di khs";
					$data1['cekKhs']=$this->krs_model->getCekKhs($nim,$tahun);
					$data1['nim'] = $nim;
					$data1['thn'] = $tahun;
					$data1['kategori'] = "khs";
					$this->load->view('temp/head');
					$this->load->view('ademik/cek_feeder',$data1);
					$this->load->view('temp/footers');
					//echo "Data Berhasil di import tapi st_feeder gagal diupdate di khs";
				}
			}
		}else{
			$data1['status']="error_feeder";
			$data1['msg']="IPK bernilai 0 tidak dapat di import ke feeder";
			$data1['cekKhs']=$this->krs_model->getCekKhs($nim,$tahun);
			$data1['nim'] = $nim;
			$data1['thn'] = $tahun;
			$data1['kategori'] = "khs";
			$this->load->view('temp/head');
			$this->load->view('ademik/cek_feeder',$data1);
			$this->load->view('temp/footers');
		}
	}

	public function prcips($nim, $kdf, $kdj, $thn){
		$tbl = "_v2_krs$thn";

		$n = 0;
		$TSKS = 0; $TNK = 0;
		$TSKSLulus = 0;
		$getKrs = $this->krs_model->getKrsPrcIps($tbl, $nim, $thn);
		foreach ($getKrs as $show) {
			$n++;
			$bobot = 0;

			$bobot = $show->Bobot;

			$NK = $bobot * $show->SKS;
		 	if($show->GradeNilai=="A"||$show->GradeNilai=="A-" ||$show->GradeNilai=="B+" ||$show->GradeNilai=="B" ||$show->GradeNilai=="B-"||$show->GradeNilai=="C+" ||$show->GradeNilai=="C"||$show->GradeNilai=="C-"||$show->GradeNilai=="D"||$show->GradeNilai=="E"||$show->GradeNilai=="K"||$show->GradeNilai=="T" ||$show->GradeNilai=="" ||$show->GradeNilai==" "){
		    		if(/*($show->NamaMK=="Seminar Proposal" || $show->NamaMK=="Praktik Lapangan (Magang)" || $show->NamaMK=="PROPOSAL SKRIPSI"  || $show->NamaMK=="SKRIPSI"  || $show->NamaMK=="Skripsi" || $show->NamaMK=="Ko-Kurikuler" || $show->NamaMK=="Kuliah Kerja Profesi (KKP) / KKN") || $show->NamaMK=="SEMINAR HASIL" || $show->NamaMK=="SEMINAR PROPOSAL" && */$show->Bobot==-1){
			    		//$TSKS += $show->SKS; tidak dihitung karena bobot 0 untuk mata kuliah tertentu
		    		}
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

		$qMaxsks = $this->krs_model->getSksMaxPrcIps($IPS, $nim);

		$maxsks = $qMaxsks->SKSMax;

		$data = array('SKS' => $TSKS, 'SKSLulus' => $TSKSLulus, 'IPS' => $IPS, 'MaxSKS2' => $maxsks, 'nim' => $nim, 'tahun' => $thn);
		$update_khs=$this->krs_model->prcips($data);

		/*if($update_khs){
			echo "berhasil proses IPS <form method='POST' action='".base_url('ademik/mhswkrs/cekDataKhs')."'><input type='hidden' name='nim' readonly value='".$nim."'><input type='hidden' name='thn' readonly value='".$thn."'><input type='submit' name='cek' value='Kembali' class='btn btn-warning'></form>";
		}*/
		if($update_khs){
			$data['status']="sukses_ips";
			$data['cekKhs']=$this->krs_model->getCekKhs($nim,$thn);
			$data['nim'] = $nim;
			$data['thn'] = $thn;
			$data['kategori'] = "khs";
			$this->load->view('temp/head');
			$this->load->view('ademik/cek_feeder',$data);
			$this->load->view('temp/footers');

		}
	}

	public function prcipk($nim, $kdf, $kdj, $thn){
		$qAngkatan = $this->krs_model->getMhswTahunAkademik($nim);
		$angkatan = $qAngkatan->TahunAkademik;
		$ang = substr($thn,0,4);
		$semesterAwal = 0;
		if($angkatan==$ang){
			$semesterAwal = 1;

		}

		$TotSKS=0;
		$TotSKSLulus=0;
		$TotNil=0;

		$qKhs = $this->krs_model->getKhsPeriode($nim);

		foreach ($qKhs as $show1) {
			$tabel = '_v2_krs'.$show1->Tahun;
			if($semesterAwal==0){
				$qw = $this->krs_model->getKrsFak($kdf,$nim, $thn, $tabel);
			}else{
				$qw = $this->krs_model->getKrsFakSama($kdf,$nim, $thn, $tabel);
			}

			foreach ($qw as $show) {
				$bobot = $show->bbt;

				if($show->GdNilai=="A" || $show->GdNilai=="B" || $show->GdNilai=="C" || $show->GdNilai=="D" || $show->GdNilai=="E" || $show->GdNilai=="A-" || $show->GdNilai=="B+" || $show->GdNilai=="B-" || $show->GdNilai=="C+"|| $show->GdNilai=="C-"|| $show->GdNilai=="K" || $show->GdNilai=="T" || $show->GdNilai=="" || $show->GdNilai==" ") {
						$TotSKS +=$show->nSks;
						$TotNil +=$show->bbt*$show->nSks;
						$bobot = $show->bbt;
						if($bobot>0){
							$TotSKSLulus+=$show->nSks;
						}
				}
			}

		}

		$TotIPK = round($TotNil/$TotSKS,2);
		$TotIPK = number_format($TotNil/$TotSKS, 2, ',', '.');

		$TotIPK = str_replace(',','.',$TotIPK);

		$tgl = date('d-m-Y');

		$data = array("IPK"=>$TotIPK, "TotalSKS"=>$TotSKS, "TotalSKSLulus"=>$TotSKSLulus, "NIM"=>$nim, "Tahun"=>$thn);

		$update_khs = $this->krs_model->updateKhsIPK($data);

		if($update_khs){
			$data['status']="sukses_ipk";
			$data['cekKhs']=$this->krs_model->getCekKhs($nim,$thn);
			$data['nim'] = $nim;
			$data['thn'] = $thn;
			$data['kategori'] = "khs";
			$this->load->view('temp/head');
			$this->load->view('ademik/cek_feeder',$data);
			$this->load->view('temp/footers');

		}
	}



	public function abaikan_krs($id,$nim,$tahun){
		$tbl = "_v2_krs$tahun";
		$unip = $_SESSION['unip'];
		$update_krs=$this->krs_model->abaikan_krs($id, $tahun, $tbl, $unip);

		if($update_krs){
			$data['status']="sukses";
			$data['cekKrs']=$this->krs_model->getCekKrs($nim,$tahun,$tbl);
			$data['nim'] = $nim;
			$data['thn'] = $tahun;
			$data['kategori'] = "krs";
			$data['controller'] = $this;
			$this->load->view('temp/head');
			$this->load->view('ademik/cek_feeder',$data);
			$this->load->view('temp/footers');

			//echo "Data berhasil dirubah <form method='POST' action='".base_url('ademik/mhswkrs/cekDataKhs')."'><input type='hidden' name='nim' readonly value='".$nim."'><input type='hidden' name='thn' readonly value='".$tahun."'><input type='submit' name='cek' value='Kembali' class='btn btn-warning'></form>";
		}
	}


	public function abaikan_khs($nim,$tahun){
		$update_khs=$this->krs_model->abaikan_khs($nim, $tahun);

		if($update_khs){
			$data['status']="sukses";
			$data['cekKhs']=$this->krs_model->getCekKhs($nim,$tahun);
			$data['nim'] = $nim;
			$data['thn'] = $tahun;
			$data['kategori'] = "khs";
			$this->load->view('temp/head');
			$this->load->view('ademik/cek_feeder',$data);
			$this->load->view('temp/footers');

			//echo "Data berhasil dirubah <form method='POST' action='".base_url('ademik/mhswkrs/cekDataKhs')."'><input type='hidden' name='nim' readonly value='".$nim."'><input type='hidden' name='thn' readonly value='".$tahun."'><input type='submit' name='cek' value='Kembali' class='btn btn-warning'></form>";
		}
	}


	public function save_khs_db(){
		$SKS = $this->input->post('sks_khs');
		$SKSLulus = $this->input->post('skslulus_khs');
		$IPS = $this->input->post('ips_khs');
		$TotalSKS = $this->input->post('totalsks_khs');
		$TotalSKSLulus = $this->input->post('totalskslulus_khs');
		$IPK = $this->input->post('ipk_khs');
		$nim = $this->input->post('nim_khs');
		$tahun = $this->input->post('tahun_khs');
		$data = array('SKS' => $SKS, 'SKSLulus' => $SKSLulus, 'IPS' => $IPS, 'TotalSKS' => $TotalSKS, 'TotalSKSLulus' => $TotalSKSLulus, 'IPK' => $IPK, 'nim' => $nim, 'tahun' => $tahun);
		$update_khs=$this->krs_model->save_khs_db($data);

		if($update_khs){
			$data['status']="sukses";
			$data['cekKhs']=$this->krs_model->getCekKhs($nim,$tahun);
			$data['nim'] = $nim;
			$data['thn'] = $tahun;
			$data['kategori'] = "khs";
			$this->load->view('temp/head');
			$this->load->view('ademik/cek_feeder',$data);
			$this->load->view('temp/footers');

			//echo "Data berhasil dirubah <form method='POST' action='".base_url('ademik/mhswkrs/cekDataKhs')."'><input type='hidden' name='nim' readonly value='".$nim."'><input type='hidden' name='thn' readonly value='".$tahun."'><input type='submit' name='cek' value='Kembali' class='btn btn-warning'></form>";
		}
	}

	public function abaikan($nim, $thn){
		$nim=str_replace(" ","",$nim);

		$query_mhs=$this->krs_model->getIdRegMhsw($nim);
		$id_reg_pd=$query_mhs->id_reg_pd;


		$thn1=substr($thn, 0,4);
		$thn2=substr($thn, 4,1);

		if($thn2==2){
			$thn2=$thn2-1;
			$thn3=$thn1.$thn2;
		}elseif($thn2==1){
			$thn1=$thn1-1;
			$thn3=$thn1.'2';
		}

		/*$query_khs=mysql_query("select st_abaikan from khs where NIM='$nim' and Tahun='$thn'");
		$data_khs=mysql_fetch_array($query_khs);
		$st_abaikan_khs=$data_khs['st_abaikan'];*/
		//echo $thn3,$nim;
		$query_khs=$this->krs_model->getStAbaikanKhs($nim,$thn3);
		if($query_khs->st_feeder==1){
			$st_abaikan_khs=1;
		}else{
			if($query_khs->st_abaikan==0){
				$st_abaikan_khs=0;
			}else{
				$st_abaikan_khs=1;
			}
		}

		$thnkrs=$thn3;
		$tbl= "_v2_krs".$thnkrs;

		$qKrs1= $this->krs_model->getCountStAbaikanKrs($tbl,$nim);
		if($qKrs1){
			$jmlAbaikan=$qKrs1->jmlAbaikan;
		}else{
			$jmlAbaikan=0;
		}
		
		$qKrs= $this->krs_model->getStAbaikanKrs($tbl,$nim);
		$count_krs=0;
		foreach ($qKrs as $show) {
			if(( $show->NamaMK=='Seminar' || $show->NamaMK=='Seminar Proposal' || $show->NamaMK=='PROPOSAL SKRIPSI' || $show->NamaMK=='Skripsi' || $show->NamaMK=="Praktik Lapangan (Magang)" || $show->NamaMK=="SKRIPSI" || $show->NamaMK=="Ko-Kurikuler" || $show->NamaMK=="Kuliah Kerja Profesi (KKP) / KKN") || $show->NamaMK=="SEMINAR HASIL" || $show->NamaMK=="SEMINAR PROPOSAL" && $show->Bobot=='0'){
			}else{
				if($show->st_abaikan>0){
					$count_krs++;
				}
			}
		}

		//echo $count_krs." ".$jmlAbaikan;
		//echo $st_abaikan_khs;

		if(($id_reg_pd=="" or $id_reg_pd==null or $id_reg_pd=="0") or ($st_abaikan_khs==0) or ($count_krs!=$jmlAbaikan)){
			return 0;
			//echo 0;
		}else{
			return 1;
			//echo 1;
		}

	}

	public function mhsw_pdpt($nim, $thn){
		$nim=str_replace(" ","",$nim);

		$query_mhs=$this->krs_model->getIdRegMhsw($nim);
		$id_reg_pd=$query_mhs->id_reg_pd;

		$thn1=substr($thn, 0,4);
		$thn2=substr($thn, 4,1);

		if($thn2==2){
			$thn2=$thn2-1;
			$thn=$thn1.$thn2;
		}elseif($thn2==1){
			$thn1=$thn1-1;
			$thn=$thn1.'2';
		}

		$query_khs=$this->krs_model->getStFeederKhs($nim,$thn);
		if($query_khs==false){
			$st_feeder_khs="";
		}else{
			$st_feeder_khs=$query_khs->st_feeder;
		}

		$thnkrs=$thn;
		
		$tbl= "_v2_krs".$thnkrs;

		$qKrs=$this->krs_model->getStFeederKrs($tbl,$nim);
		//$data_krs=mysql_fetch_array($query_krs);
		$count_krs=0;

		foreach ($qKrs as $show) {
			if($show->st_feeder==0){
				$count_krs++;
			}
		}


		if(($id_reg_pd=="" or $id_reg_pd==null) or ($st_feeder_khs=="" or $st_feeder_khs==null or $st_feeder_khs==0) or ($count_krs>0)){
			return 0;
		}else{
			return 1;
		}
	}


	function PrcDel() {
		$id = $this->input->post('ID');
		$nim = $this->input->post('nim');
		$thn = $this->input->post('thn');
		$unip = $_SESSION['unip'];
		$tbl = "_v2_krs$thn";
		
		$qArr = $this->krs_model->getKrsData($tbl,$nim,$id);
		$KodeMK = $qArr->KodeMK;
		$NamaMK = $qArr->KodeMK;
		$IDJadwal = $qArr->IDJadwal;
		$SKS = $qArr->SKS;

		$deleteKrs = $this->krs_model->deleteKrs($tbl,$id,$nim,$thn);

		$updateKhsDelete = $this->krs_model->updateKhsDelete($nim,$thn);

		$data = array('NIM' => $nim, 'Tahun' => $thn, 'KodeMK' => $KodeMK, 'NamaMK' => $NamaMK, 'IDJadwal' => $IDJadwal, 'SKS' => $SKS, 'unip' => $unip);
		$insertLogKrsDel = $this->krs_model->insertLogKrsDel($data);

		if($deleteKrs){
			$msg = "Data Berhasil dihapus";
		}else{
			$msg = "Data gagal dihapus";
		}

		$this->UpdateSKSKHS($nim, $thn,$tbl);
		$dataDelete = array(
			'message' => $msg,
			'id' => $id
		);
		echo json_encode($dataDelete);
	}

	public function refreshIpk(){
		$error = false;
		if($_SESSION['ulevel'] == 4) {
			if($this->input->post('nim')!=$_SESSION['unip']) {
				$dataRefresh = array(
					'message' => 'Harap Screenshot dan Segera Melapor ke UPT. TIK atau USER kalian di blok dan dilaporkan ke rektor',
					'tampil' => ''
				);
				$error = true;
				echo json_encode($dataRefresh); 
			}else{
				$nim = $_SESSION['unip'];
			}
		} else {
			$nim = $this->input->post('nim');
		}

		if($error===false){
			$tahun = $this->input->post('semesterAkademik');

			$tahunx = "";
			if(substr($tahun,4,1)==1){
				$tahunx=$tahun-9;
			}else if(substr($tahun,4,1)==2){
				$tahunx = $tahun-1;
			}

			$qAngkatan = $this->krs_model->getAngkatan($nim);
			$angkatan = $qAngkatan->TahunAkademik;
			$qKode = $this->krs_model->getKode($nim);
			$prog = $qKode->KodeProgram;
			$kdj = $qKode->KodeJurusan;

			$mhswBaru = $this->krs_model->cekMhswAkademik($nim);
			$tahun_akademik=$mhswBaru->TahunAkademik;
			
			if($tahun_akademik==substr($tahun,0,4)){
				$ips= 0;
			}elseif(substr($tahun,4,1)==3 || substr($tahun,4,1)==4){
				$ips= 0;
			}else{
				$qIpsKhs = $this->krs_model->getIpsKhs($nim,$tahunx);
				$ips = $qIpsKhs->IPS;
			}


			$nimx=substr($nim,0,6);

			$qMaxsks = $this->krs_model->getSksMax($ips,$nim);

			$maxsks = $qMaxsks->SKSMax;

			if($nimx=="O12115" & $tahun=="20152") {
				$maxsks=22;
			}
			if($nimx=="O27115" & $tahun=="20152") {
				$maxsks=24;
			}
			if(($kdj=="D10115" || $kdj=="D10114") & $prog=="RESO") {
				$maxsks=20;
			}
			if(($kdj=="D10112" || $kdj=="D10113") & $prog=="RESO") {
				$maxsks=24;
			}
			if($angkatan=="2017"){
				$maxsks=24;
			}

			$dataKodeMhsw= $this->krs_model->getMhswKode($nim);
			$kdfMhsw=$dataKodeMhsw->KodeFakultas;
			$kdjMhsw=$dataKodeMhsw->KodeJurusan;
			$kdp=$dataKodeMhsw->KodeProgram;
			
			if(substr($tahun,4,1)==3 || substr($tahun,4,1)==4) {
				if($kdfMhsw=='P'){
					$maxsks=10;
				}else{
					$maxsks=9;
				}
			}

			$data = array("NIM"=>$nim, "Tahun"=>$tahun, "MaxSKS"=>$maxsks);

			$updateKhs = $this->krs_model->updateMaxKhs($data);
			if($updateKhs) {
				$msg = "Refresh SKS MAX Berhasil";
			}else{
				$msg = "Refresh SKS MAX Gagal";
			}

			$tampil = $this->tampilKrs($nim,$tahun);

			$dataRefresh = array(
				'message' => $msg,
				'tampil' => $tampil
			);
			echo json_encode($dataRefresh);
		}
	}

	public function cekPernahAmbil($nim, $semesterAkademik, $kd_mk) {
		$tbl = "_v2_krs".$semesterAkademik;
		
		$cekGradeNilai = $this->krs_model->cekGradeNilai($nim,$semesterAkademik,$kd_mk,$tbl);

		$res = '';
		$cnt = 0;

		foreach ($cekGradeNilai as $show) {
			$cnt++;
			$res .= $cnt." Semester: ".$show->Tahun.", Nilai: ".$show->GradeNilai."\n";
		}
		if (empty($res)) {
			return '&nbsp;';
		} else {
			return "<img src='".base_url('assets')."/images/check.gif' border=0 alt='Pernah Diambil' title='Mata kuliah ini pernah diambil:\n$res'";
		}
	}

	public function addKrs() {
		$nim = $this->input->post('nim');
		$name = $this->input->post('name');
		$kdj = $this->input->post('kdj');
		$kdp = $this->input->post('kdp');
		$lev = $_SESSION['ulevel'];
		$semesterAkademik = $this->input->post('semesterAkademik');
		$data = array('name' => $name, 'kdj' => $kdj, 'kdp' => $kdp, 'lev' => $lev, 'semesterAkademik' => $semesterAkademik);
		$showAddKrs = $this->krs_model->daftarKrs($nim, $data);

		// $showAddKrs1 = $this->krs_model->daftarKrs1($nim, $data);
		// echo $showAddKrs1;
		$nimf=substr($nim,0,1);

		/*$dataErr = array(
			'data' => $nim.' '.$name.' '.$kdj.' '.$kdp.' '.$lev.' '.$nims.' '.$nimx.' '.$nimf.' '.$semesterAkademik,
		);*/

		$headTable = '
		<form method="POST" id="formPrcKrs">
		<input type="hidden" name="nim" value="'.$nim.'">
		<input type="hidden" name="semesterAkademik" value="'.$semesterAkademik.'">
		<table class="table table-bordered table-responsive">
			<thead style="background-color: #D4D0C8;">
				<tr>
					<th>Ambil</th>
					<th>KodeMK</th>
					<th>Mata Kuliah</th>
					<th>SKS</th>
					<th>SMTR</th>
					<th>Dosen</th>
					<th>Hari</th>
					<th>Mulai</th>
					<th>Selesai</th>
					<th>Ruang</th>
					<th>Kelas</th>
					<th>Pernah diambil</th>
				</tr>
			</thead>
			<tbody>';

		$bodyTable = '';
		foreach ($showAddKrs as $show) {
			$MK = $show->MataKuliah;
			$KodeMK = $show->KodeMK;
			if (empty($MK) OR $MK=="") {
				$qMK = $this->krs_model->getMataKuliah($KodeMK,$kdj);
				if($qMK == false) {
					$MK = $show->MataKuliahJadwal;
				}else{
					$MK = $qMK->Nama_Indonesia;
				}
			}
			$pernah = $this->cekPernahAmbil($nim, $semesterAkademik, $KodeMK);
			/*
			if( $semesterAkademik=='20153' && $nimf =='D'){
				$res_mhs  = $this->hitungMhsw($show->IDJADWAL);
				$res_kaps = $this->cekKapasitas($show->IDJADWAL);
				if($res_mhs < $res_kaps){
					$checkAmbil = "<div class='checkbox'>
						<input type=checkbox name='ambil[]' value='".$show->IDJADWAL."'>
						<label></label>
					</div>";

				}else{
					$checkAmbil = "<b style='color:red;'>Kelas Sudah Penuh</b>";
				}

				$bodyTable = $bodyTable.'<tr>
				<td>'.$checkAmbil.'</td>
				<td>'.$KodeMK.'</td>
				<td>'.$MK.'</td>
				<td>'.$show->SKS.'</td>
				<td>'.$show->Sesi.'</td>
				<td>'.$show->Dsn.'</td>
				<td>'.$show->HR.'</td>
				<td>'.$show->jm.'</td>
				<td>'.$show->js.'</td>
				<td>'.$show->kr.'</td>
				<td>'.$show->kt.'</td>
				<td>'.$pernah.'</td>
				</tr>';
			}
			*/
			$res_mhs  = $this->hitungMhsw($show->IDJADWAL);
			$res_kaps = $this->cekKapasitas($show->IDJADWAL);
			if($res_mhs < $res_kaps){
				$checkAmbil = "<div class='checkbox'>
						<input id='".$show->IDJADWAL."' type=checkbox name='ambil[]' value='".$show->IDJADWAL."'>
						<label for='".$show->IDJADWAL."'></label>
					</div>";
			}else{
				$checkAmbil = "<b style='color:red;'>Kelas Sudah Penuh</b>";
			}

			$bodyTable = $bodyTable.'<tr>
			<td>'.$checkAmbil.'</td>
			<td>'.$KodeMK.'</td>
			<td>'.$MK.'</td>
			<td>'.$show->SKS.'</td>
			<td>'.$show->Sesi.'</td>
			<td>'.$show->Dsn.'</td>
			<td>'.$show->HR.'</td>
			<td>'.$show->jm.'</td>
			<td>'.$show->js.'</td>
			<td>'.$show->kr.'</td>
			<td>'.$show->kt.'</td>
			<td>'.$pernah.'</td>
			</tr>';
		}
		/*onClick=\"location='ademik.php?syxec=mhswkrs&md=-1&$snm=$sid'\"*/
		$footTable = '
		<tr>
			<td colspan=12>
				<input type=button id="prckrs" name="prckrs" value="Ambil Kuliah">&nbsp;
				<input type=reset name=reset value="Reset">&nbsp;
				<input type=button name="batal" id="batalKrs" value="Batal" data-dismiss="modal">
			</td>
		</tr>
		</tbody>
		</table>
		</form>';
		$dataTable = array(
			'isi' => $headTable.$bodyTable.$footTable,
		);
		echo json_encode($dataTable);
	}

	public function registrasiUlang() {
		$nim = $this->input->post('nim');
		$thn = $this->input->post('semesterAkademik');

		$ulevel = $_SESSION['ulevel'];
		$uname = $_SESSION['uname'];
		$unip = $_SESSION['unip'];
		$user = $this->GetUser($ulevel);
		$kd1 = "1";
		$kdf = "1";
		$formAddSesi = "";
		$msg = "";

		if($ulevel==5){
			$qKd1= $this->krs_model->getKodeFakultasTable($unip,$user);
			$kd1= $qKd1->KodeFakultas;
			$qKdf= $this->krs_model->getKodeFakultas($nim);
			$kdf = $qKdf->KodeFakultas;
		}else if($ulevel==7){
			$qKd2 = $this->krs_model->getKodeJurusanTable($unip,$user);
			$kd2 = $qKd2->KodeJurusan;
			$qKdj = $this->krs_model->getKode($nim);
			$kdj = $qKdj->KodeJurusan;
		}

		if ($_SESSION['ulevel'] == 4) {
			$nim = $_SESSION['unip'];
		}
		//$valid = GetMhsw($thn, $nim, 'mhswherreg');
		$valid = $this->krs_model->getMhsw($nim);
		if($kdf == $kd1 || $kdj == $kd2 || $ulevel==1 || ($nim==$unip) ){
			$formAddSesi = $this->formAddSesi($nim,$thn);
			/*if ($valid!=false) {
				if (isset($_REQUEST['prcaddssi'])) {
					PrcAddSesi();
				}
				if (isset($_REQUEST['prcrege'])) {
					PrcRegistrasiMhsw($thn, $nim);
				}
				if (isset($_REQUEST['prcreg'])) {
					DispConfirmReg($thn, $nim);
				}else{
					DispMhswKHS($thn, $nim);
				}
			}*/
			$containerDisplay = "<div id='displayMhsw'>";
			$displayMhs = $this->DispMhswKHS($thn,$nim);
			$closeContainerDisplay = "</div>";
		}else {
			$msg = "Maaf, Anda tidak berhak mengakses NIM ini !!!..";
			//die(DisplayHeader($fmtErrorMsg, "Maaf, Anda tidak berhak mengakss NIM ini !!!..", 0));
		}

		$dataReg = array(
			'isi' => $formAddSesi.$containerDisplay.$displayMhs.$closeContainerDisplay,
			'error' => $msg
		);
		echo json_encode($dataReg);
	}

	public function formAddSesi($nim,$thn){
		if ($_SESSION['ulevel']==1 || $_SESSION['ulevel']==5 || $_SESSION['ulevel']==4 || $_SESSION['ulevel']==7) {
			$qSsi = $this->krs_model->getSesiMax($nim);
			$ssi = $qSsi->ssi + 1;
			$qThnNext = $this->krs_model->getTahunNextMax($nim);
			$ThnNext = $qThnNext->ThnNext + 1;


			//$kdf=substr("$nim",0,1);
			$dataKodeMhsw= $this->krs_model->getMhswKode($nim);
			$kdf=$dataKodeMhsw->KodeFakultas;
			$kdj=$dataKodeMhsw->KodeJurusan;
			if($kdf=='C') {
				$maxsks=24; //2007 , Sesuai permintaan Kedokteran
			} else {
				$maxsks = $this->getMaxSKSMhsw($nim);
			}
			if ($_SESSION['ulevel']==4){ //untuk mhs
				$angkatan = substr($nim,4,2);
				
				$sksmax = 11;
				
				if($angkatan==15){
					$sksmax= 24;
				} else {
					$sksmax= 11;
				}
				if(substr($thn,4,1)==3 || substr($thn,4,1)==4) {
					if($kdf=='P'){
						$sksmax=10;
					}else{
						$sksmax=9;
					}
				}

				if (!empty($thn)) {
				  $qAda = $this->krs_model->getSksTahun($nim,$thn);
				  if($qAda==false){
					$ada=false;
				  }else{
					$ada = $qAda->Tahun;
				  }
				  if($ada!=false){
					$msg = "Tahun ajaran $thn dan Sesi/Semester $ssi sudah ada.";
				  }
				  else {
					$data = array("NIM"=>$nim, "Tahun"=>$thn, "Sesi"=>$ssi, "Status"=>"A", "MaxSKS"=>$sksmax);

					$simpan = $this->krs_model->insertKhs($data);

					if($simpan){
						$msg = "Data berhasil ditambahkan";
					}else{
						$msg = "Data gagal tersimpan";
					}
				  }
				}else{
					$msg = "Tahun Belum Diisi";
				}


				$form = "";
				/*$form = "
					<form method='POST' id='formRegUlang'>
						<table class=basic cellspacing=1 cellpadding=2>
							<input type=hidden name='syxec' value='mhswherreg'>
							<input type=hidden name='nim' value='$nim'>
							<input type=hidden name='maxsks' value='11'>
							<tr>
								<th class=ttl colspan=6>Tambah Semester Baru</th>
								<td class=basic></td>
							</tr>
							<td class=ttl>Tahun Ajaran</td>
							<td class=lst><input type=text name='thn' value='".$thn."' readonly size=5 maxlength=5></td>
							<td class=ttl>Sesi/Semester</td>
							<td width=5>$ssi</td>
							<td class=ttl>Max SKS</td>
							<td width=5>$sksmax</td>
							<td class=basic rowspan=2>
								<input type=button id='prcaddssi' name='prcaddssi' value='Tambah'>
							</td>
							</tr>
						</table>
					</form>
				";*/
			}else{
				$form = "
					<form method='POST' id='formRegUlang'>
						<table class=basic cellspacing=1 cellpadding=2>
							<input type=hidden name='syxec' value='mhswherreg'>
							<input type=hidden name='nim' value='$nim'>
							<tr>
								<th class=ttl colspan=6>Tambah Semester Baru</th>
								<td class=basic></td>
							</tr>
							<td class=ttl>Tahun Ajaran</td>
							<td class=lst>
								<input type=text name='thn' value='$ThnNext' size=5 maxlength=5>
							</td>
							<td class=ttl>Sesi/Semester</td>
							<td class=lst>
								<input type=text name='ssi' value='$ssi' size=5 maxlength=5>
							</td>
							<td class=ttl>Max SKS</td>
							<td class=lst>
								<input type=text name='maxsks' value='$maxsks' size=5 maxlength=5>
							</td>
							<td class=basic rowspan=2>
								<input type=button id='prcaddssi' name='prcaddssi' value='Tambah'>
							</td>
							</tr>
						</table>
					</form>
				";
			}
		}
		return $form;
	}

	public function prcAddSsi(){
		$thn = $this->input->post('thn');
		$nim = $this->input->post('nim');
		$ssi = $this->input->post('ssi');
		$sksmax = $this->input->post('maxsks');
		if (!empty($thn)) {
		  $qAda = $this->krs_model->getSksTahun($nim,$thn);
		  if($qAda==false){
			$ada=false;
		  }else{
			$ada = $qAda->Tahun;
		  }
		  if($ada!=false){
			$msg = "Tahun ajaran $thn dan Sesi/Semester $ssi sudah ada.";
		  }
		  else {
			$data = array("NIM"=>$nim, "Tahun"=>$thn, "Sesi"=>$ssi, "Status"=>"A", "MaxSKS"=>$sksmax);

			$simpan = $this->krs_model->insertKhs($data);

			if($simpan){
				$msg = "Data berhasil ditambahkan";
			}else{
				$msg = "Data gagal tersimpan";
			}
		  }
		}else{
			$msg = "Tahun Belum Diisi";
		}
		$displayMhs = $this->DispMhswKHS($thn, $nim);
		$dataReg = array(
			'message' => $msg,
			'displayMhs' => $displayMhs
		);
		echo json_encode($dataReg);
	}

	public function DispMhswKHS($thn, $nim) {
		$qKdj = $this->krs_model->getKode($nim);
		$kdj = $qKdj->KodeJurusan;
		$qStrsesi = $this->krs_model->getSesiJurusan($kdj);
		$strsesi = $qStrsesi->Sesi;
		$qDispMhswKHS = $this->krs_model->getDispMhswKHS($nim);
		$header = "
		<table class='table table-bordered table-responsive'>
			<thead style='background-color: #D4D0C8;'>
				<th class=ttl>$strsesi</th>
				<th class=ttl>Tahun</th>
				<th class=ttl>Status</th>
				<th class=ttl># Registrasi</th>
				<th class=ttl>Tgl Reg.</th>
			</thead>
			<tbody>
		";
		//<th class=ttl>Registrasi</th>
		$isi= '';
		if (is_array($qDispMhswKHS) || is_object($qDispMhswKHS))
		{
			foreach ($qDispMhswKHS as $show) {
				if ($show->Registrasi == 'Y') {
					$cls = 'style="background-color:gray"';
					$tglreg = $show->TGL;
					$nmrreg = $show->ID;
					$strreg = "<span class='glyphicon glyphicon-ok'></span>";
				} else {
					$cls = '';
					$tglreg = '&nbsp;';
					$nmrreg = '&nbsp;';
					//$strreg = "<a href='ademik.php?syxec=mhswherreg&prcreg=1&nim=$nim&thn=$show->Tahun' title='Registrasi Ulang'><img src='image/check.gif' border=0></a>";
					$strreg = "<button title='Registrasi Ulang' id='displayConfirmReg' data-thn='".$show->Tahun."' data-nim='".$nim."'><span class='glyphicon glyphicon-list-alt'></span> Registrasi Ulang</button>";
				}
				$isi = $isi."
				<tr>
					<td $cls>".$show->Sesi."</td>
					<td $cls>".$show->Tahun."</td>
					<td $cls>".$show->STA."</td>
					<td  $cls>$nmrreg</td>
					<td $cls>$tglreg</td>
				</tr>";
				//<td class=lst align=center>$strreg</td>
			}
		}
		$footer = "
			</tbody>
		</table>";

		return $header.$isi.$footer;
	}

	public function DispConfirmReg() {
		$thn = $this->input->post('thn');
		$nim = $this->input->post('nim');
		$snm = $_SESSION['uname'];
		$sid = $_SESSION['id'];

		$arrmhsw = $this->krs_model->getMhs3($nim);
		$title = "Konfirmasi Registrasi Ulang";
		$msg = "Hallo <b>".$arrmhsw->Name." - ".$arrmhsw->NIM."</b>.<br />Anda akan melakukan Registrasi Ulang untuk Tahun Ajaran <b>".$thn."</b>.<br />Setelah melakukan Registrasi Ulang, status anda akan menjadi <b>AKTIF</b>.<br />Dengan status AKTIF, anda dapat mengisi, mengubah atau menghapus KRS pada tahun ajaran yang AKTIF.";
		/*$arrmhsw = GetFields('mhsw', 'NIM', $nim, 'NIM,Name,KodeJurusan');
		DisplayDetail($fmtMessage, "Konfirmasi Registrasi Ulang",
		"Hallo <b>$arrmhsw[Name] - $arrmhsw[NIM]</b>.<br>
		Anda akan melakukan Registrasi Ulang untuk tahun ajaran <b>$thn</b>.<br>
		Setelah melakukan Registrasi Ulang, status Anda akan menjadi <b>AKTIF</b>.<br>
		Dengan status AKTIF, Anda dapat mengisi, mengubah atau menghapus KRS pada tahun ajaran yang AKTIF.<hr>
		Pilihan: <a href='ademik.php?syxec=mhswherreg&$snm=$sid&prcrege=1&nim=$nim&thn=$thn'>Registrasi Ulang</a> |
		<a href='ademik.php?syxec=mhswherreg&thn=$thn&nim=$nim'>Batalkan</a>");*/

		$dataReg = array(
			'message' => $msg,
			'title' => $title
		);
		echo json_encode($dataReg);
	}

	public function prcRegUlang() {
		$thn = $this->input->post('thn');
		$nim = $this->input->post('nim');

		$regUlang = $this->krs_model->updateKhsRegUlang($thn, $nim);

		$arrmhsw = $this->krs_model->getMhs3($nim);

		if($regUlang){
			$msg = "Hallo <b>".$arrmhsw->Name." - ".$nim."</b>, proses Registrasi Ulang telah berhasil.<br>Status Anda telah <b>AKTIF</b>. Anda dapat mulai untuk mengisi KRS.<hr><b>Selamat Belajar</b>";
		}else{
			$msg = "Proses Registrasi Ulang Gagal, Terjadi masalah";
		}

		$displayMhs = $this->DispMhswKHS($thn, $nim);
		$dataReg = array(
			'success' => $msg,
			'displayMhs' => $displayMhs
		);
		echo json_encode($dataReg);
	}

	public function GetUser($Lvl){
		switch($Lvl){
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

	public function KRSForm2() {
		$nim = $this->input->post('nim');
		$snm = $this->input->post('name');
		$kdj = $this->input->post('kdj');
		$kdp = $this->input->post('kdp');
		$lev = $_SESSION['ulevel'];
		$semesterAkademik = $this->input->post('semesterAkademik');
		$sid = $this->input->post('id');;

		$qKd = $this->krs_model->getKode($nim);
		$kdj = $qKd->KodeJurusan;
		$kdp = '';

		$qGetPaket = $this->krs_model->getPaket($semesterAkademik,$kdj);
		//$s = "select jd.IDPAKET,p.KodePaket, p.NamaPaket from jadwal jd left outer join paket p on jd.IDPAKET=p.IDPAKET	where jd.Tahun='$thn' and jd.KodeJurusan='$kdj' $strprg $tjdwl and jd.KodeRuang <> '' group by jd.IDPAKET order by jd.IDPAKET";
		//echo $s;
		// Khusus MHS
		$nims=substr($nim,0,6);

		//echo $s;


		//echo "106 : $s"; //k.ID is null

		//Cek sudah pernah ambil paket
		$pernah = $this->CekPernahAmbilPkt($nim, $semesterAkademik);

		//2007 j.IDMK=mk.ID -> j.IDMK=mk.IDMK ; k.IDJadwal=j.ID ->k.IDJadwal=j.IDJADWAL

		$headTable = "<form action='ademik.php' method='POST' id='formPrcPaket'>
		<input type=hidden name='nim' value='$nim'>
		<input type=hidden name='pkt' value='Y'>
		<input type=hidden name='semesterAkademik' value='$semesterAkademik'>
			<table class='table table-bordered table-responsive'>
				<thead style='background-color: #D4D0C8;'>
					<tr>
						<th>Ambil</th>
						<th>Kode Paket</th>
						<th>Nama Paket</th>
					</tr>
				</thead>
				<tbody>";
		//echo "KKKKKKKKKKKKK-$pernah";
		$programTable="";
		$isiTable="";
		$footTable="";

		if($pernah==0){
			$no = 0;
			foreach ($qGetPaket as $show) {
				$no++;
				/*if ($kdp != $show->Program) {
					$kdp = $show->Program;
					$programTable = $programTable."<tr><td height=4></td></tr>
					<tr><td colspan=9>Program : <b class=ttl>&nbsp;".$show->PRG."&nbsp;</b></td></tr>";
				}*/


				$MK = $show->NamaPaket;
				$KodeMK = $show->KodePaket;
				$ID = $show->IDPAKET;

				if (empty($MK)) {
					$qMk = $this->krs_model->getMataKuliah($KodeMK,$kdj);
					if($qMk!=false){
						$MK = $qMk->Nama_Indonesia;
					}
				}
				//if( $thn=='20152' ){
				$isiTable = $isiTable."<tr>
				<td class=lst><input type=radio name='ambilID' value='$ID'></td>
				<td class=lst>$KodeMK</td><td class=lst>$MK</td>
				</tr>";
				// }
			}
			if($no>0){
				$footTable = "<tr><td class=lst colspan=10>
				<input type=button id='prcPaket' name='prcPaket' value='Ambil Paket'>&nbsp;
				<input type=reset name=reset value='Reset'>&nbsp;
				<input type=button name='batal' value='Kembali' data-dismiss='modal'>
				</td></tr>";
			}else{
				$footTable = "<td class=lst colspan=3>Tidak ada Paket Matakuliah semester ini</td>";
			}
		}else{
			$isiTable = "<tr>
			<td class=lst colspan=3>Anda Sudah pernah memilih paket di semester ini<br>Silahkan Hapus semua matakuliah jika ingin memilih paket lagi !</td>

			</tr><tr><input type=button name='batal' value='Kembali'data-dismiss='modal'></tr>";
		}
		$footer= "</table></form>";

		$dataTable = array(
			'isi' => $headTable.$programTable.$isiTable.$footTable.$footer,
		);
		echo json_encode($dataTable);
	}

	public function CekPernahAmbilPkt($nim, $thn) {
		$tbl = "_v2_krs$thn";
		
		//echo $s;
		$res = '';
		$cnt = 0;
		$qCekPaket = $this->krs_model->getCekPaket($nim,$thn,$tbl);
		if($qCekPaket){
			$cnt++;
		}
		return $cnt;
	}

	public function hitungMhsw($jid) {
		$getThn =  $this->krs_model->getTahunJadwal($jid);
		$thn = $getThn->Tahun;
		$tbl = "_v2_krs$thn";
		$getJmlMhsw = $this->krs_model->getJmlMhsw($tbl,$jid);
		$jmlMhsw = $getJmlMhsw->JML;
		return $jmlMhsw;
	}

	public function cekKapasitas($jid) {
		$getKap = $this->krs_model->getKap($jid);
		$kap = $getKap->Kap;
		return $kap;
	}

	public function saveKrs() {
		$ambil = $this->input->post('ambil');
		$nim = $this->input->post('nim');
		$pkt = $this->input->post('pkt');
		$semesterAkademik = $this->input->post('semesterAkademik');
		$value = '';
		/*foreach ($ambil as $show){
			$value=$value." ".$show;
		}*/
		$strExplode = explode("|",$this->batasKrsNim($semesterAkademik, $nim));
		//echo $this->batasKrsNim($semesterAkademik, $nim);
		/*if ($this->batasKrsNim($semesterAkademik, $nim)) {
			//PrcKrs();
			$dataKrs = array(
				'isi' => $value,
				'nim' => $nim,
				'semesterAkademik' => $semesterAkademik
			);
			echo json_encode($dataKrs);
		}*/
		if($strExplode[0]==1){
			$this->prcKrs($semesterAkademik, $nim, $ambil, $pkt);
		}else{
			$dataKrs = array(
				'error' => $strExplode[1],
				'stats' => $strExplode[0]
			);
			echo json_encode($dataKrs);
		}
	}

	public function prcKrs($thn, $nim, $krsArray, $pkt) {
		$krs = array();

		$tbl = "_v2_krs$thn";
		

		//$ssi = GetaField('khs', 'Tahun', $thn, 'Sesi');
		$Qssi = $this->krs_model->getSesi($thn);
		$ssi = $Qssi->Sesi;

		if (empty($ssi)) $ssi = 0;

		$unip = $_SESSION['unip'];

		if (isset($krsArray)) $krs = $krsArray;
		if ($this->EmptyArray($krs) && $pkt != 'Y'){
			$dataKrs = array(
				'error' => 'Tidak ada mata Kuliah yang dipilih',
				'stats' => 0
			);
			echo json_encode($dataKrs);
		} else if($pkt == 'Y'){
			$IDPAKET = $_REQUEST['ambilID'];
			$arrm = GetFields('mhsw', 'NIM', "$nim", 'KodeJurusan,KodeProgram');
			$kdj = $arrm['KodeJurusan'];
			$prg = $arrm['KodeProgram'];

			//echo "INPUT PAKET-$IDPAKET";
			$qwr = "select IDJADWAL,IDMK,KodeMK,NamaMK,SKS,IDDosen,Program from jadwal where KodeJurusan='$kdj' and Tahun='$thn' and Program='$prg' and IDPAKET='$IDPAKET'";
			//echo $qwr;
			$w = mysql_query($qwr);
			while($row=mysql_fetch_array($w)){
				$NamaMK = $row['NamaMK'];//2007
				$KodeMK = $row['KodeMK'];
				$IDMK = $row['IDMK'];

				$jid = $row['IDJADWAL'];

				$IDDosen = $row['IDDosen'];
				$SKS = $row['SKS'];
				$PRG = $row['Program'];

				//fandu 06-01-2017

				$sp = "insert into ".$tbl." (NIM, Tahun, Sesi, IDJadwal,IDPAKET, IDMK, KodeMK, NamaMK, SKS, IDDosen, unip, Tanggal, Program) values ('$nim', '$thn', $ssi, '$jid','$IDPAKET', '$IDMK', '$KodeMK', '$NamaMK', $SKS, '$IDDosen', '$unip', now(), '$PRG' )";
				mysql_query($sp);
			}
		}else {
			$msg = ''; $boleh = ''; $error = 0; $msg1=''; //$stats=0;
			for ($i=0; $i < sizeof($krs); $i++) {
				$jid = $krs[$i];

				//$arrj = GetFields('jadwal', 'ID', $jid, '*');
				//$arrj = GetFields('jadwal', 'IDJADWAL', "$jid", '*');//2007
				$arrj = $this->krs_model->getAllJadwal($jid);
				$IDMK = $arrj->IDMK;

				$boleh = $this->cekMaxSKS($nim, $thn, $arrj, $thn);
				$tahunx = "";
				if(substr($thn,4,1)==1){
					$tahunx=$thn-9;
				}else if(substr($thn,4,1)==2){
					$tahunx = $thn-1;
				}
				if (empty($boleh)) $boleh = $this->CekKecukupanSKS($nim, $tahunx, $arrj);
				if (empty($boleh)) $boleh = $this->CekPrasyaratMK($nim, $tahunx, $arrj);
				$msg = $msg . $boleh;


				if (empty($boleh) && $pkt != 'Y') {
					// $bentrok = (empty($_REQUEST['GabungBentrok']))? CekBentrokJdwlMhsw($nim, $thn, $arrj) : '';

					//die($bentrok);

					if (empty($bentrok)){
						//$NamaMK = GetaField('matakuliah','ID', $IDMK, 'Nama_Indonesia');
						//$NamaMK = GetaField('matakuliah', 'IDMK', "$IDMK", 'Nama_Indonesia');//2007

						$qNamaMK = $this->krs_model->getMataKuliahIdMk($IDMK);
						$NamaMK= $qNamaMK->Nama_Indonesia;
						$KodeMK = $arrj->KodeMK;
						$IDDosen = $arrj->IDDosen;
						$SKS = $arrj->SKS;
						$PRG = $arrj->Program;

						//$sck = "select ID from $tbl where IDMK='$IDMK' and NIM='$nim' and Tahun='$thn'";
						$sck = $this->krs_model->cekIdKrs($IDMK,$nim,$thn,$tbl);

						//$rck = mysql_query($sck) or die("$strCantQuery: $sck");
						if($sck == false){
							// Insert di KRS
							$a = $this->hitungMhsw($jid);
							$b = $this->cekKapasitas($jid);
							//echo "KKKKKKKKKKKK-$a-$b";
							if( $a < $b ){  //|| CekTerjadwal($jid)=="N"

								//$kdj = GetaField('mhsw', 'nim', $nim,  'KodeJurusan');
								$qKdj = $this->krs_model->getKode($nim);
								$kdj = $qKdj->KodeJurusan;
								//$kdf = GetaField('mhsw', 'nim', $nim, 'KodeFakultas');
								$qKdf = $this->krs_model->getKodeFakultas($nim);
								$kdf = $qKdf->KodeFakultas;
								//$nm_mhs = GetaField('mhsw', 'nim', $nim, 'Name');
								$qNmMhs = $this->krs_model->getNameMahasiswa($nim);
								$nm_mhs = $qNmMhs->Name;

								// fandu 06-01-2017
								$tbl = "_v2_krs$thn";
								//echo "masuk kategori 2016";
								

								//include "connectdb.php";
								/*$s = "insert into ".$tbl." (NIM, Tahun, Sesi, IDJadwal, IDMK, KodeMK, NamaMK, SKS, IDDosen, unip, Tanggal, Program)
								values ('$nim', '$thn', $ssi, '$jid', '$IDMK', '$KodeMK', '$NamaMK', $SKS, '$IDDosen', '$unip', now(), '$PRG' )";*/
								$dataKrsArray = array(
													"nim" => $nim,
													"tahun" => $thn,
													"sesi" => $ssi,
													"idJadwal" => $jid,
													"idMk" => $IDMK,
													"kodeMk" => $KodeMK,
													"namaMk" => $NamaMK,
													"sks" => $SKS,
													"idDosen" => $IDDosen,
													"unip" => $unip,
													"tanggal" => date("Y-m-d H:i:s"),
													"program" => $PRG
												);
								
								//$cekKrs = $this->krs_model->cekCariKrsNIM($nim,$thn);
								$cariKrsNIM = $this->krs_model->cariKrsNIM($nim,$thn);
								$tanggalLain = 0;
								foreach ($cariKrsNIM as $show) {
									if($show->tanggal != date("Y-m-d H:i:s")){
										$tanggalLain++;
									}
								}
								if($tanggalLain>0){
									$s = $this->krs_model->saveKrs($dataKrsArray, $tbl, 0);
								}else{
									$s = $this->krs_model->saveKrs($dataKrsArray, $tbl, 1);
								}



								if($s==1){
									$this->krs_model->statusKRS($nim);
									//$status_simpan="Sukses";
									/*$dataKrs = array(
										'msg' => "Data KRS dengan NIM ".$nim." dan Semester Akademik ".$thn." berhasil disimpan",
										'stats' => 1
									);
									echo json_encode($dataKrs);*/
									//$stats = 1;
								}else{
									//$status_simpan="Gagal";
									/*$dataKrs = array(
										'error' => "Data KRS dengan NIM ".$nim." dan Semester Akademik ".$thn." gagal untuk disimpan",
										'stats' => 0
									);
									echo json_encode($dataKrs);*/
									$msg1=$msg1."<br>- ".$NamaMK." gagal untuk disimpan";
									$error++;
								}

								/*
								if($NamaMK=="KKN-MP"){
								include "connectdbkkn.php";
								$s = "insert into kkn (nstbk, tahun, nama_mhs, kodefakultas, kodejurusan)
								values ('$nim', '$thn','$nm_mhs','$kdf','$kdj')";

								$r = mysql_query($s) or die("$strCantQuery: $s");

								mysql_close();
								include "connectdb.php";

								} else{
								include "connectdb.php";

								}
								*/

							}else {
								$qCariRuang = $this->krs_model->cariRuang($jid);
								$CariRuang = $qCariRuang->Kode;
								/*$dataKrs = array(
									'error' => "Matakuliah <b>".$NamaMK."</b> tidak dapat diinput !<br>Kelas ".$CariRuang." Penuh.  Silahkan Pilih Kelas Lain !",
									'stats' => 0
								);
								echo json_encode($dataKrs);*/
								$msg1=$msg1."<br>- ".$NamaMK." tidak dapat diinput !<br>Kelas ".$CariRuang." Penuh.  Silahkan Pilih Kelas Lain !";
								$error++;
							}
						}else{
							/*$dataKrs = array(
									'error' => "Mata kuliah <b>$KodeMK : $NamaMK</b> sudah didaftarkan.",
									'stats' => 0
								);
							echo json_encode($dataKrs);*/
							$msg1=$msg1."<br>- ".$NamaMK." sudah didaftarkan.";
							$error++;
						}
					}
					else{
						/*$dataKrs = array(
							'error' => "Bentrok ".$bentrok,
							'stats' => 0
						);
						echo json_encode($dataKrs);*/
						$msg1=$msg1."<br>- Bentrok ".$NamaMK;
						$error++;
					}
					//  else DisplayHeader($fmtErrorMsg, $bentrok ."<hr size=1 color=silver>
					//    Opsi : <a href='ademik.php?syxec=mhswkrs&nim=$nim&thn=$thn&ssi=$ssi&ambil[]=$jid&GabungBentrok=1&prckrs=Ambil+Kuliah'>Gabungkan Mata Kuliah</a>");
				}else{
					$msg1=$msg;
					$error++;
				}

			}
			$this->UpdateSKSKHS($nim, $thn, $tbl);
			if($error==0) {
				$dataKrs = array(
					'msg' => "Data KRS dengan NIM ".$nim." dan Semester Akademik ".$thn." berhasil disimpan",
					'stats' => 1
				);
				echo json_encode($dataKrs);
			}elseif($error>=1) {
				$dataKrs = array(
					'error' => "Terdapat Error : ".$msg1,
					'stats' => 0
				);
				echo json_encode($dataKrs);
			}


		}
	}


	public function UpdateSKSKHS($nim, $thn, $tbl) {
		//$jml = GetaField('krs', "NIM='$nim' and Tahun", $thn, 'sum(SKS)') + 0;
		$qJml = $this->krs_model->getSumSks($nim,$thn,$tbl);
		$jml = $qJml->jmlSks + 0;
		$this->krs_model->updateSksKhs($jml,$nim,$thn);
		//$s = "update khs set SKS=$jml where NIM='$nim' and Tahun='$thn'";s
		//$r = mysql_query($s) or die("$strCantQuery: $s");
	}

	public function CekPrasyaratMK($nim, $thn, $arrj) {
		//$kdf = GetaField('mhsw', 'nim', $nim, 'KodeFakultas');
		$qKdf = $this->krs_model->getKodeFakultas($nim);
		$kdf = $qKdf->KodeFakultas;
		//$s = "select pmk.PraKodeMK, mk.Nama_Indonesia as NamaMK from prasyaratmk pmk left outer join matakuliah mk on pmk.PraKodeMK=mk.Kode and mk.KodeJurusan='$arrj[KodeJurusan]' where pmk.IDMK='$arrj[IDMK]' order by pmk.PraKodeMK";

		$s = $this->krs_model->getPrasyaratMk($arrj->KodeJurusan,$arrj->IDMK);

		//$r = mysql_query($s) or die("Gagal: $s<br>".mysql_error());
		$blm = '';
		$tahun = substr($thn,0,4);

		if($s!=false){
			foreach ($s as $show) {
				$sdh="";

				$qKhs = $this->krs_model->getKhsPeriode($nim);
				foreach ($qKhs as $show1) {
					$qSdh =  $this->krs_model->getIdKrs($nim,$show->PraKodeMK,"_v2_krs".$show1->Tahun);
					
					if($qSdh!=false){
						$sdh = $qSdh->ID;
					}
				}
				$blm .= (empty($sdh)||$sdh=="") ? "<li>".$show->PraKodeMK." - ".$show->NamaMK."</li>" : '';
			}
		}
		if (!empty($blm)) {
			return "<li>Error : <b>".$arrj->NamaMK."</b><br>
			Mata kuliah tidak dapat diambil karena Anda belum mengambil mata kuliah prasyarat di bawah ini:
			<ol>$blm</ol></li>";
		}
		else return '';
	}

	public function cekKecukupanSKS($nim, $thn, $arrj) {
		//$tot = GetaField("mhsw", "NIM", $nim, 'TotalSKS');
		$qTot = $this->krs_model->getTotalSks($nim);
		$tot = $qTot->TotalSKS;
		//$min = GetaField("matakuliah", "ID", $arrj['IDMK'], 'SKSMin')+0;
		//$min = GetaField("matakuliah", "IDMK", $arrj['IDMK'], 'SKSMin')+0; //2007
		$qMin = $this->krs_model->getSksMin($arrj->IDMK);
		$min = $qMin->SKSMin;
		if ($tot < $min){
			return "<li>Error:<br>
			Syarat pengambilan <b>".$arrj->NamaMK."</b> adalah <b>$min</b> SKS.<br>SKS yang anda miliki baru <b>$tot</b> SKS.";
		
		}else{
			return '';
		}
	}

	public function cekMaxSKS($nim, $thn, $arrj, $semesterAkademik) {
		$mhswBaru = $this->krs_model->cekMhswAkademik($nim);
		$tahun_akademik=$mhswBaru->TahunAkademik;
		
		if($tahun_akademik==substr($semesterAkademik, 0,4)){
			$max = 24;
		}else{
			$cekSks = $this->krs_model->getMaxSks($nim,$thn);
			$max = $cekSks->MaxSKS;
		}
		$dataKodeMhsw= $this->krs_model->getMhswKode($nim);
		$kdf=$dataKodeMhsw->KodeFakultas;
		if(substr($thn,4,1)==3 || substr($thn,4,1)==4) {
			if($kdf=='P'){
				$max=10;
			}else{
				$max=9;
			}
		}
		/*$qMax = $this->krs_model->getMaxSks($nim,$thn);
		$max = $qMax->MaxSKS;*/
		$tbl = "_v2_krs$thn";
		/*$jml = GetaField("$tbl", "NIM='$nim' and Tahun", $thn, 'sum(SKS)');*/
		$qJml = $this->krs_model->getJmlSks($nim,$thn,$tbl);
		$jml = $qJml->jml_sks;
		if ($jml+$arrj->SKS > $max){
			return "<li>Error: <b>".$arrj->NamaMK."</b><br>
			Mata kuliah tidak dpt diambil karena SKS akan melebihi batas. <br>
			Max SKS: <b>$max</b>, yg telah diambil saat ini: <b>$jml</b>, yg akan diambil <b>".$arrj->SKS."</b>.<br>&nbsp;</li>";
		}else{
			return '';
		}
	}

	public function getMaxSKSMhsw($nim) {
		$defSKS = 24;
		$qKdj = $this->krs_model->getKode($nim);
		$kdj = $qKdj->KodeJurusan;

		$sesiBobot = $this->krs_model->getSesiBobot($nim);
		if($sesiBobot==false){
			$sesi = 0;
			$bbt = 0;
		}else{
			$sesi = $sesiBobot->Sesi;
			$bbt = $sesiBobot->bbt;
		}

		$bbt=sprintf("%.1f",$bbt);
		$qMax = $this->krs_model->getMaxSksRange($bbt,$kdj);
		$max = $qMax->SKSMax;
		return $max;
	}


	public function batasKrsNim($thn, $nim) {

		$ulevel=$_SESSION['ulevel'];

		$getKode = $this->krs_model->getKode($nim);
		$kdp = $getKode->KodeProgram;
		$kdfv = $getKode->KodeJurusan;
		//Khusus Tahun 20141 di batasi KRS dan user mhs

		// $ark = GetFields('bataskrs', "Tahun='$thn' and KodeProgram='$kdp' and KodeJurusan='$kdfv' and NotActive", 'N', 'krsm,krss,ukrsm,ukrss,Tahun');
		$ark = true;
		//CATATAN ulevel 1 hanya untuk testing
		if($ulevel==4||$ulevel==1){
			/*$ark = GetFields('bataskrs', "Tahun='$thn' and KodeProgram='$kdp' and KodeJurusan='$kdfv' and NotActive", 'N', 'krsm,krss,ukrsm,ukrss,Tahun');*/
			$ark = $this->krs_model->batasKrs($thn,$kdp,$kdfv);
		}
		$skrg = date('Ymd');
		$msg='';
		if ($ark) {

			// fandu mofifikasi 08 september 2019
			$res = true;
			$pesanError = '';

			if($ulevel==4){
				$Tahun = $ark->Tahun;
				//echo "$Tahun-$thn";

				$t1 = (int)str_replace('-', '', $ark->krsm);
				$t2 = (int)str_replace('-', '', $ark->krss);
				$u1 = (int)str_replace('-', '', $ark->ukrsm);
				$u2 = (int)str_replace('-', '', $ark->ukrss);
			}else{
				$Tahun = $thn;
				$t1 = $skrg;
				$t2 = $skrg;
				$u1 = $skrg;
				$u2 = $skrg;

				// khusus admin fakultas dan admin jurusan
				if($ulevel==7 || $ulevel==5){
					
					$cekBatasKrs = $this->krs_model->cekLevel($ulevel,$this->session->unip);
					//Pengecekan Ulevel bagi admin yang ada pada rule saja di Admin Fakultas dan Jurusan
					if($cekBatasKrs){
						// fandu tambahakan
						if($cekBatasKrs->point_1 == 1){
							$res = 1;
						} else {
							$res = 0;
							$pesanError = "admin fakultas dan admin jurusan tidak di berikan menginputkan krs mahasiswa<br>";
							// admin fakultas dan admin jurusan tidak di berikan menginputkan krs mahasiswa
						}

						if($cekBatasKrs->point_2 == 1){
							$res = 1;
						} else {
							$ark = $this->krs_model->batasKrs($thn,$kdp,$kdfv);
							
							$Tahun = $ark->Tahun;
							$t1 = (int)str_replace('-', '', $ark->krsm);
							$t2 = (int)str_replace('-', '', $ark->krss);
							$u1 = (int)str_replace('-', '', $ark->ukrsm);
							$u2 = (int)str_replace('-', '', $ark->ukrss);

							$res = ((($t1 <= $skrg && $skrg <= $t2) ) && $thn == $Tahun);
							if($res){
								$res=1;
							}else{
								$res=0;
								if (empty($pesanError)){
									$pesanError = "admin fakultas dan admin jurusan tidak di berikan input krs lambat mahasiswa<br>";
								} else {
									$pesanError = "admin fakultas dan admin jurusan tidak di berikan menginputkan krs dan input krs lambat mahasiswa<br>";
								}
								// admin fakultas dan admin jurusan tidak di berikan input krs lambat mahasiswa
							}
						}
					}
				}
			}
			//CATATAN ulevel 1 hanya untuk testing
			if($ulevel==4||$ulevel==1){
				$res = ((($t1 <= $skrg && $skrg <= $t2) || ($u1 <= $skrg && $skrg <= $u2)) && $thn == $Tahun);
			}
			if (!$res){
				/*DisplayHeader($fmtErrorMsg, "KRS sudah tidak dapat diubah.<hr>
				Tahun Akademik: <b>$Tahun</b><br>
				Batas pengisian : <b>".$ark->krsm. ' </b>s/d<b> '.$ark->krss. '</b><br>'.
				"Batas perubahan : <b>".$ark->ukrsm. ' </b>s/d<b> '.$ark->ukrss.'</b>'.
				'<hr>Perubahan tidak akan diproses.');*/
				$res = 0;
				$msg = "$pesanError KRS sudah tidak dapat diubah.<hr>
				Tahun Akademik: <b>$Tahun</b><br>
				Batas pengisian : <b>".$ark->krsm. ' </b>s/d<b> '.$ark->krss . '</b><br>'.
				"Batas perubahan : <b>".$ark->ukrsm. ' </b>s/d<b> '.$ark->ukrss.'</b>'.
				'<hr>Perubahan tidak akan diproses.';
			}
		}else {
			/*DisplayHeader($fmtErrorMsg, "Data batas input/koreksi KRS tidak ada.
			Kesalahan ini mungkin terjadi karena:
			<ul>
			<li>Rentang waktu input/koreksi KRS belum ditentukan.</li>
			<li>Tahun ajaran yang dimasukkan tidak valid.</li>
			</ul>
			Data tidak dapat disimpan.");*/
			$msg="Data batas input/koreksi KRS tidak ada.
			Kesalahan ini mungkin terjadi karena:
			<ul>
			<li>Rentang waktu input/koreksi KRS belum ditentukan.</li>
			<li>Tahun ajaran yang dimasukkan tidak valid.</li>
			</ul>
			Data tidak dapat disimpan.";
			$res = 0;
		}

		return $res."|".$msg;
	}

	public function batasKrsNim1($thn, $nim) {

		$ulevel=$_SESSION['ulevel'];

		$getKode = $this->krs_model->getKode($nim);
		$kdp = $getKode->KodeProgram;
		$kdfv = $getKode->KodeJurusan;
		//Khusus Tahun 20141 di batasi KRS dan user mhs

		// $ark = GetFields('bataskrs', "Tahun='$thn' and KodeProgram='$kdp' and KodeJurusan='$kdfv' and NotActive", 'N', 'krsm,krss,ukrsm,ukrss,Tahun');
		if($ulevel==1 || $ulevel==5 || $ulevel==7){
			//$ark = $this->krs_model->batasKrs($thn,$kdp,$kdfv);
			$ark = true;
			//$tabel="";
			/*if($ulevel=='5'){
				$tabel="_v2_adm_fak";
			}elseif($ulevel=='7'){
				$tabel="_v2_adm_jur";
			}*/
			/*$cekBatasKrs = $this->krs_model->cekLevel($ulevel,$this->session->unip);
			if($cekBatasKrs==true){
				$ark = true;
			}*/
		}
		//CATATAN ulevel 1 hanya untuk testing
		if($ulevel==4){
			/*$ark = GetFields('bataskrs', "Tahun='$thn' and KodeProgram='$kdp' and KodeJurusan='$kdfv' and NotActive", 'N', 'krsm,krss,ukrsm,ukrss,Tahun');*/
			$ark = $this->krs_model->batasKrs($thn,$kdp,$kdfv);
		}
		$skrg = date('Ymd');
		$msg='';
		if ($ark) {
			if($ulevel==4){
				$Tahun = $ark->Tahun;

				$t1 = (int)str_replace('-', '', $ark->krsm);
				$t2 = (int)str_replace('-', '', $ark->krss);
				$u1 = (int)str_replace('-', '', $ark->ukrsm);
				$u2 = (int)str_replace('-', '', $ark->ukrss);
			}else{

				/*$Tahun = $ark->Tahun;

				$t1 = (int)str_replace('-', '', $ark->krsm);
				$t2 = (int)str_replace('-', '', $ark->krss);
				$u1 = (int)str_replace('-', '', $ark->ukrsm);
				$u2 = (int)str_replace('-', '', $ark->ukrss);*/
				$Tahun = $thn;
				$t1 = $skrg;
				$t2 = $skrg;
				$u1 = $skrg;
				$u2 = $skrg;
			}
			//echo "$Tahun-$thn";

			//$res = ((($t1 <= $skrg && $skrg <= $t2) || ($u1 <= $skrg && $skrg <= $u2)) && $thn == $Tahun);
			$res = true;
			//CATATAN ulevel 1 hanya untuk testing
			if($ulevel==4){
				$res = ((($t1 <= $skrg && $skrg <= $t2) ) && $thn == $Tahun);
				//|| ($u1 <= $skrg && $skrg <= $u2)
			}
			if($ulevel==7 || $ulevel==5){
				$cekBatasKrs = $this->krs_model->cekLevel($ulevel,$this->session->unip);
				//Pengecekan Ulevel pada Admin Fakultas dan Jurusan
				if($cekBatasKrs){
					if($cekBatasKrs->point_1==1){
						$point1=1;
					}else{
						$point1=0;
					}
					if($cekBatasKrs->point_2==1){
						$point2=1;
					}else{
						$point2=0;
					}

					if($point1==1 && $point2==1){
						$res=1;
					}
					if($point1==1 && $point2==0){
						$res = ((($t1 <= $skrg && $skrg <= $t2) ) && $thn == $Tahun);
					}
					if($point1==0 && $point2==1){
						$res = ((($t1 <= $skrg && $skrg <= $t2) ) && $thn == $Tahun);
						if($res){
							$res=0;
						}else{
							$res=1;
						}
					}
					if($point1==0 && $point2==0){
						$res=0;
					}
				}else{
					// fandu matikan tanggal 18-12-2018 $res=0;
					if($ulevel==7){
						$res=1;	
					}else{
						$res=0;	
					} // untuk mengatur default krs di fakultas dan jurusan, karena defaultnya fakultas dan prodi bisa tambah krs
				}


				/*$res = ((($t1 <= $skrg && $skrg <= $t2) ) && $thn == $Tahun);
				if($res){
					$res=0;
				}else{
					$cekBatasKrs = $this->krs_model->cekLevel($ulevel,$this->session->unip);
					if($cekBatasKrs==true){
						$res=1;	
					}else{
						if($this->session->kdj==''){

						}else{
							$res=0;
						}
					}
				}*/
			}
			if (!$res){
				/*DisplayHeader($fmtErrorMsg, "KRS sudah tidak dapat diubah.<hr>
				Tahun Akademik: <b>$Tahun</b><br>
				Batas pengisian : <b>".$ark->krsm. ' </b>s/d<b> '.$ark->krss. '</b><br>'.
				"Batas perubahan : <b>".$ark->ukrsm. ' </b>s/d<b> '.$ark->ukrss.'</b>'.
				'<hr>Perubahan tidak akan diproses.');*/
				$res = 0;
				$msg = "KRS sudah tidak dapat diubah.<hr>
				Tahun Akademik: <b>$Tahun</b><br>
				Batas pengisian : <b>".$t1. ' </b>s/d<b> '.$t2 . '</b><br>';

				//"Batas perubahan : <b>".$ark->ukrsm. ' </b>s/d<b> '.$ark->ukrss.'</b>'.
			}
		}else {
			/*DisplayHeader($fmtErrorMsg, "Data batas input/koreksi KRS tidak ada.
			Kesalahan ini mungkin terjadi karena:
			<ul>
			<li>Rentang waktu input/koreksi KRS belum ditentukan.</li>
			<li>Tahun ajaran yang dimasukkan tidak valid.</li>
			</ul>
			Data tidak dapat disimpan.");*/
			$msg="Data batas input/koreksi KRS tidak ada.
			Kesalahan ini mungkin terjadi karena:
			<ul>
			<li>Rentang waktu input/koreksi KRS belum ditentukan.</li>
			<li>Tahun ajaran yang dimasukkan tidak valid.</li>
			</ul>
			Data tidak dapat disimpan.";
			$res = 0;
		}

		return $res;
	}

	public function batasKrsNim2($thn, $nim) {

		$ulevel=$_SESSION['ulevel'];

		$getKode = $this->krs_model->getKode($nim);
		$kdp = $getKode->KodeProgram;
		$kdfv = $getKode->KodeJurusan;
		//Khusus Tahun 20141 di batasi KRS dan user mhs

		// $ark = GetFields('bataskrs', "Tahun='$thn' and KodeProgram='$kdp' and KodeJurusan='$kdfv' and NotActive", 'N', 'krsm,krss,ukrsm,ukrss,Tahun');
		$ark = true;
		if($ulevel==1 || $ulevel==5 || $ulevel==7){
			//$ark = $this->krs_model->batasKrs($thn,$kdp,$kdfv);
			$ark = true;
		}
		//CATATAN ulevel 1 hanya untuk testing
		if($ulevel==4){
			/*$ark = GetFields('bataskrs', "Tahun='$thn' and KodeProgram='$kdp' and KodeJurusan='$kdfv' and NotActive", 'N', 'krsm,krss,ukrsm,ukrss,Tahun');*/
			$ark = $this->krs_model->batasKrs($thn,$kdp,$kdfv);
		}
		$skrg = date('Ymd');
		$msg='';
		if ($ark) {
			if($ulevel==4){
				$Tahun = $ark->Tahun;

				$t1 = (int)str_replace('-', '', $ark->krsm);
				$t2 = (int)str_replace('-', '', $ark->krss);
				$u1 = (int)str_replace('-', '', $ark->ukrsm);
				$u2 = (int)str_replace('-', '', $ark->ukrss);
			}else{

				/*$Tahun = $ark->Tahun;

				$t1 = (int)str_replace('-', '', $ark->krsm);
				$t2 = (int)str_replace('-', '', $ark->krss);
				$u1 = (int)str_replace('-', '', $ark->ukrsm);
				$u2 = (int)str_replace('-', '', $ark->ukrss);*/
				$Tahun = $thn;
				$t1 = $skrg;
				$t2 = $skrg;
				$u1 = $skrg;
				$u2 = $skrg;
			}
			//$res = ((($t1 <= $skrg && $skrg <= $t2) || ($u1 <= $skrg && $skrg <= $u2)) && $thn == $Tahun);
			$res = true;
			//CATATAN ulevel 1 hanya untuk testing
			if($ulevel==4||$ulevel==1){
				$res = ((($u1 <= $skrg && $skrg <= $u2) ) && $thn == $Tahun);
				//||
			}
			if($ulevel==7 || $ulevel==5){
				$cekBatasKrs = $this->krs_model->cekLevel($ulevel,$this->session->unip);
				//Pengecekan Ulevel pada Admin Fakultas dan Jurusan
				if($cekBatasKrs){
					if($cekBatasKrs->point_2==1){
						$point2=1;
					}else{
						$point2=0;
					}

					if($point2==1){
						$res=1;
					}
					if($point2==0){
						$res=0;
					}
				}else{
					// fandu matikan tanggal 18-12-2018 $res=0;
					$res=1; // untuk mengatur default krs di fakultas dan jurusan, karena defaultnya fakultas dan prodi bisa tambah krs
				}


				/*$res = ((($t1 <= $skrg && $skrg <= $t2) ) && $thn == $Tahun);
				if($res){
					$res=0;
				}else{
					$cekBatasKrs = $this->krs_model->cekLevel($ulevel,$this->session->unip);
					if($cekBatasKrs==true){
						$res=1;	
					}else{
						if($this->session->kdj==''){

						}else{
							$res=0;
						}
					}
				}*/
			}
			if (!$res){
				/*DisplayHeader($fmtErrorMsg, "KRS sudah tidak dapat diubah.<hr>
				Tahun Akademik: <b>$Tahun</b><br>
				Batas pengisian : <b>".$ark->krsm. ' </b>s/d<b> '.$ark->krss. '</b><br>'.
				"Batas perubahan : <b>".$ark->ukrsm. ' </b>s/d<b> '.$ark->ukrss.'</b>'.
				'<hr>Perubahan tidak akan diproses.');*/
				$res = 0;
				if($ulevel==7 || $ulevel==5){
					$msg = "";
				}else{
					$msg = "KRS sudah tidak dapat diubah.<hr>
					Tahun Akademik: <b>$Tahun</b><br>".
					"Batas perubahan : <b>".$ark->ukrsm. ' </b>s/d<b> '.$ark->ukrss.'</b>'.
					'<hr>Perubahan tidak akan diproses.';	
				}
				
				//"Batas perubahan : <b>".$ark->ukrsm. ' </b>s/d<b> '.$ark->ukrss.'</b>'.
			}
		}else {
			/*DisplayHeader($fmtErrorMsg, "Data batas input/koreksi KRS tidak ada.
			Kesalahan ini mungkin terjadi karena:
			<ul>
			<li>Rentang waktu input/koreksi KRS belum ditentukan.</li>
			<li>Tahun ajaran yang dimasukkan tidak valid.</li>
			</ul>
			Data tidak dapat disimpan.");*/
			$msg="Data batas input/koreksi KRS tidak ada.
			Kesalahan ini mungkin terjadi karena:
			<ul>
			<li>Rentang waktu input/koreksi KRS belum ditentukan.</li>
			<li>Tahun ajaran yang dimasukkan tidak valid.</li>
			</ul>
			Data tidak dapat disimpan.";
			$res = 0;
		}

		return $res;
	}

	public function EmptyArray($arr) {
		$jml = count($arr);
		$tmp = "";
		for ($i=0; $i < $jml; $i++) {
			if (!empty($arr[$i])) $tmp = $tmp . $arr[$i];
		}
		return empty($tmp);
	}

	public function tes(){
		echo "tes";
		$result = $this->krs_model->sinkronspp1('N11118029','20182');
		echo $result;
	}
}
