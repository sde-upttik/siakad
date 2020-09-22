<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mhswkrs extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
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
	    	$data = $this->krs_model->getMhswKhs($nim,$semesterAkademik); //Mengambil Data sebagai Parameter

			//if($data!=false){
				if($_SESSION['kdj']!=""){
					$dataTahun = $this->krs_model->getTahun($_SESSION['kdj'],$semesterAkademik);
					
					if($dataTahun==false){
						$dataErr = array(
							'error' => 'Semester Akademik Tidak Ada', 
						);
						echo json_encode($dataErr);
					}else{
						$dataMhsw = $this->krs_model->getMhsw($nim);
						if($dataMhsw==false){
							$dataErr = array(
								'error' => 'Data tidak ditemukan', 
							);
							echo json_encode($dataErr);
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
											'error' => 'Silahkan Isi/Cek Terlebih dahulu Biodata <b>Nama ibu, Tempat/tanggal lahir </b><a href="#">Isi Biodata</a>', 
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
						}
					}
				}else{
					$dataTahun = $this->krs_model->getTahunOne($semesterAkademik);
					
					if($dataTahun==false){
						$dataErr = array(
							'error' => 'Semester Akademik Tidak Ada', 
						);
						echo json_encode($dataErr);
					}else{
						$dataMhsw = $this->krs_model->getMhsw($nim);
						if($dataMhsw==false){
							$dataErr = array(
								'error' => 'Data tidak ditemukan', 
							);
							echo json_encode($dataErr);
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
						}
					}
				}
			/*}else{
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

	public function cekHutang($nim,$semesterAkademik){
		$cekBayar = $this->krs_model->getBayar($nim,$semesterAkademik);
		if($cekBayar==false){
			return false;
		}else{
			$bayar = $cekBayar->bayar;
			if($bayar==1 || $bayar==2 || $semesterAkademik=='20164' || $semesterAkademik=='20163' ||  $semesterAkademik<='20152' || $semesterAkademik=='20153' ){  
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
				$kdf = $cekKodeFakultas->KodeFakultas;
				$ulevel = $_SESSION['ulevel'];
				if($semesterAkademik=='20163' && $ulevel=='4' && $kdf !='A' && $kdf !='F' ){
					$dataMsg['msgError'] = "Mahasiswa <b>$nim</b> tidak aktif untuk tahun ajaran <b>$semesterAkademik</b>.<br>Status: <b>".$cekMhswAktif->Nama."</b><br>Jika belum registrasi ulang, silakan hubungi admin di fakultas Anda !";
				}else{
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
					$dataMsg['msgError'] = "Mahasiswa <b>".$nim."</b> tidak aktif untuk tahun ajaran <b>".$semesterAkademik."</b>.<br>Status: <b>".$cekMhswAktifSemester->Nama."</b><br>Jika belum registrasi ulang, silakan registrasi ulang dahulu.<hr size=1 color=silver>Pilihan : <button type='button' class='btn btn-block btn-info' data-toggle='modal' data-nim='".$nim."' data-semester-akademik='".$semesterAkademik."' data-target='#modal-registrasiUlang' id='openModalRegistrasiUlang'>Registrasi Ulang</button>";
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

		//$snm = session_name(); $sid = session_id();

		$cekVal = $this->krs_model->getVal($nim, $semesterAkademik);
		$st_val = $cekVal->st_val;
		$tgl_val = $cekVal->tgl_val;
		$btnAdd = '';
		$btnPackage = '';

		$container = "<div class='col-md-12'><div class='row'>";

		if($st_val==1){
			$valkrs ="KRS ini sudah divalidasi tanggal $tgl_val";
		}else {
			$valkrs ="<div class='col-md-2'><button class='btn btn-block btn-warning' style='color:white;' type=submit name='prcvalkrs'>Validasi</button></div>";

			$sid = $_SESSION['id'];
			$snm = $_SESSION['uname'];
			$cekKode = $this->krs_model->getKode($nim);
			$kdj = $cekKode->KodeJurusan;
			$kdp = $cekKode->KodeProgram;

			$btnAdd = "<div class='col-md-2'><button type='button' class='btn btn-block btn-info' data-toggle='modal' data-id='".$sid."' data-name='".$snm."' data-kdj='".$kdj."' data-kdp='".$kdp."' data-nim='".$nim."' data-semester-akademik='".$semesterAkademik."' data-target='#modal-addKrs' id='openModalKrs'>Tambah KRS</button></div>"; //1
		}
		$btnPrint = "<div class='col-md-2'><button type='button' class='btn btn-block btn-success'>Cetak KRS</button></div>"; //2
		$btnPrintCard = "<div class='col-md-2'><button type='button' class='btn btn-block btn-success'>Cetak Kartu Ujian</button></div>"; //3


		$lev = $_SESSION['ulevel'];

		if($kdf=="N"||$lev=="1"){  
			$btnPackage = "<div class='col-md-2'><button type='button' class='btn btn-block btn-info' data-toggle='modal' data-id='".$sid."' data-name='".$snm."' data-kdj='".$kdj."' data-kdp='".$kdp."' data-nim='".$nim."' data-semester-akademik='".$semesterAkademik."' data-target='#modal-addPaket' id='openModalPaket'>Tambah Paket</button></div>"; //4
		}

		$closeContainer = "</div></div>";

		$hdrHapus = '<th><b>Hapus</b></th>';

		if($semesterAkademik!='20161'){
			$tbl = "_v2_krs$semesterAkademik";
		} else {
			$tbl = "_v2_krs";
		}

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
				$header =  "<tr><td colspan=14 ><b>".$show->PRG."</b></td></tr>
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
			<td align=center>$strHapus</td>
			</tr> "; //7
		}
		$footTable = "</table><br>"; //8

		$cekSks = $this->krs_model->getMaxSks($nim,$semesterAkademik);
		$maxsks = $cekSks->MaxSKS;
		if ($sumsks > $maxsks) {
			$errsks = "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>"; 
		} else {
			$errsks = "";
		}
		$footerTable = "<table class=box cellspacing=0 cellpadding=4>
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

		return $container.$btnAdd.$btnPrint.$btnPrintCard.$btnPackage.$valkrs.$closeContainer.$headTable.$header.$tableContent.$footTable.$footerTable;
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
			$rowRegMhsw= "<span class='glyphicon glyphicon-remove' aria-hidden='true'> Mahasiswa Tidak Terdaftar di PDPT <a class='btn btn-primary' href=#>Cek Data</a></span>";
		}

		$closeRow= "
					</td>
				</tr>
				<tr>
					<td>
		";	

		$thnkrs=$thn;
		if($thnkrs=='20161'){
			$thnkrs='';
		}

		$tbl= "_v2_krs".$thnkrs;

		$qKrs=$this->krs_model->getStFeederKrs($tbl,$nim);
		//$data_krs=mysql_fetch_array($query_krs);
		$count_krs=0;
		
		foreach ($qKrs as $show) {
			if($show->st_feeder<=0){
				$count_krs++;
			}
		}

		$rowKrs = "";
		if($count_krs==0){
			$rowKrs= "<span class='glyphicon glyphicon-ok'> KRS Periode $thn telah terdaftar di pdpt</span>";
		}elseif($count_krs>0){
			$rowKrs= "<span class='glyphicon glyphicon-remove' aria-hidden='true'> $count_krs Mata Kuliah pada KRS Periode $thn belum terdaftar di pdpt <a class='btn btn-primary' href=#>Cek Data</a></span>";
		}
		/*echo "
					</td>
				</tr>
				<tr>
					<td>
		";*/

		$query_khs=$this->krs_model->getStFeederKhs($nim,$thn);
		$st_feeder_khs=$query_khs->st_feeder;


		if($st_feeder_khs=="" or $st_feeder_khs==null or $st_feeder_khs==0){
			$khs_feeder=0;
		}else{
			$khs_feeder=1;
		}	

		$rowKhs= "";
		if($khs_feeder==1){
			$rowKhs= "<span class='glyphicon glyphicon-ok'> KHS Periode $thn telah terdaftar di pdpt</span>";
		}elseif($khs_feeder==0){
			$rowKhs= "<span class='glyphicon glyphicon-remove' aria-hidden='true'> KHS Periode $thn belum terdaftar di pdpt <a class='btn btn-primary' href=#>Cek Data</a></span>";
		}

		$closeTable= "
					</td>
				</tr>
			</tbody>
		</table>";

		return $headTable.$rowRegMhsw.$closeRow.$rowKrs.$closeRow.$rowKhs.$closeTable;
	}

	public function abaikan($nim, $thn){
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

		/*$query_khs=mysql_query("select st_abaikan from khs where NIM='$nim' and Tahun='$thn'");
		$data_khs=mysql_fetch_array($query_khs);
		$st_abaikan_khs=$data_khs['st_abaikan'];*/

		$query_khs=$this->krs_model->getStAbaikanKhs($nim,$thn);
		if($query_khs->st_feeder==1){
			$st_abaikan_khs=1;
		}else{
			if($query_khs->st_abaikan==0){
				$st_abaikan_khs=0;
			}else{
				$st_abaikan_khs=1;
			}
		}

		$thnkrs=$thn;
		if($thnkrs=='20161'){
			$thnkrs='';
		}

		$tbl= "_v2_krs".$thnkrs;

		$qKrs1= $this->krs_model->getCountStAbaikanKrs($tbl,$nim);
		$jmlAbaikan=$qKrs1->jmlAbaikan;

		$qKrs= $this->krs_model->getStAbaikanKrs($tbl,$nim);
		$count_krs=0;
		foreach ($qKrs as $show) {
			if($show->st_abaikan>0){
				$count_krs++;
			}
		}

		if(($id_reg_pd=="" or $id_reg_pd==null or $id_reg_pd=="0") or ($st_abaikan_khs==0) or ($count_krs!=$jmlAbaikan)){
			return 0;
		}else{
			return 1;
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
		if($thnkrs=='20161'){
			$thnkrs='';
		}

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
		$tbl='';
		if ($thn != "20161") {
			$tbl = "_v2_krs$thn";
		} else {
			$tbl = "_v2_krs";
		}
		
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
		$nim = $this->input->post('nim');
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

		$qIpsKhs = $this->krs_model->getIpsKhs($nim,$tahunx);
		$ips = $qIpsKhs->IPS;

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

	public function cekPernahAmbil($nim, $semesterAkademik, $kd_mk) {
		if($semesterAkademik!='20161'){
			$tbl = "_v2_krs".$semesterAkademik;
		} else {
			$tbl = "_v2_krs";
		}

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
			return "<img src='image/check.gif' border=0 alt='Pernah Diambil' title='Mata kuliah ini pernah diambil:\n$res'";
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
			if (empty($MK)) {
				$MK = $this->krs_model->getMataKuliah($KodeMK,$kdj);
			}
			$pernah = $this->cekPernahAmbil($nim, $semesterAkademik, $KodeMK);

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
			$formAddSesi = $this->formAddSesi($nim);
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

	public function formAddSesi($nim){
		if ($_SESSION['ulevel']==1 || $_SESSION['ulevel']==5 || $_SESSION['ulevel']==4 || $_SESSION['ulevel']==7) {
			$qSsi = $this->krs_model->getSesiMax($nim);
			$ssi = $qSsi->ssi + 1;
			$qThnNext = $this->krs_model->getTahunNextMax($nim);
			$ThnNext = $qThnNext->ThnNext + 1;

			$kdf=substr("$nim",0,1);
			if($kdf=='C') {
				$maxsks=24; //2007 , Sesuai permintaan Kedokteran	
			} else {
				$maxsks = $this->getMaxSKSMhsw($nim);
			}
			if ($_SESSION['ulevel']==4){ //untuk mhs
				$angkatan = substr($nim,4,2);
				if($angkatan==15){
					$sksmax= 24;	
				} else {
					$sksmax= 11;
				}
				$form = "
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
							<td class=lst><input type=text name='thn' value='' size=5 maxlength=5></td>
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
				";
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
		  	$qBea = $this->krs_model->getKodeBiaya($nim);
		 	$bea = $qBea->KodeBiaya;
		 	$data = array("NIM"=>$nim, "Tahun"=>$thn, "KodeBiaya"=>$bea, "KodeBiaya"=>$bea, "Sesi"=>$ssi, "Status"=>"A", "MaxSKS"=>$sksmax);

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
				<th class=ttl>Registrasi</th>
			</thead>
			<tbody>
		";
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
					<td class=lst align=center>$strreg</td>
				</tr>";
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
		if($thn!='20161'){
			$tbl = "_v2_krs$thn";
			//echo "masuk kategori 2016";
		} else {
			$tbl = "_v2_krs";
			//echo "tidak masuk kategori 2016";
		}
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
		if($thn=="20161") {
			$tbl = "_v2_krs";
		}else{
			$tbl = "_v2_krs$thn";	
		} 
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
		
		if($thn != "20161"){
			$tbl = "_v2_krs$thn";
			//echo "masuk kategori 2016";
		} else {
			$tbl = "_v2_krs";
			//echo "tidak masuk kategori 2016";
		}

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
			$msg = ''; $boleh = '';
			for ($i=0; $i < sizeof($krs); $i++) {
				$jid = $krs[$i];

				//$arrj = GetFields('jadwal', 'ID', $jid, '*');
				//$arrj = GetFields('jadwal', 'IDJADWAL', "$jid", '*');//2007
				$arrj = $this->krs_model->getAllJadwal($jid);
				$IDMK = $arrj->IDMK;

				$boleh = $this->cekMaxSKS($nim, $thn, $arrj);
				if (empty($boleh)) $boleh = $this->CekKecukupanSKS($nim, $thn, $arrj);
				if (empty($boleh)) $boleh = $this->CekPrasyaratMK($nim, $thn, $arrj);
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
								if($thn!=20161){
									$tbl = "_v2_krs$thn";
									//echo "masuk kategori 2016";
								} else {
									$tbl = "_v2_krs";
									//echo "tidak masuk kategori 2016";
								}

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
								$s = $this->krs_model->saveKrs($dataKrsArray, $tbl);

								if($s==1){
						        	//$status_simpan="Sukses";        	
									$dataKrs = array(
										'msg' => "Data KRS dengan NIM ".$nim." dan Semester Akademik ".$thn." berhasil disimpan", 
										'stats' => 1
									);
									echo json_encode($dataKrs);
						        }else{
						        	//$status_simpan="Gagal";
						        	$dataKrs = array(
										'error' => "Data KRS dengan NIM ".$nim." dan Semester Akademik ".$thn." gagal untuk disimpan", 
										'stats' => 0
									);
									echo json_encode($dataKrs);
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
								$dataKrs = array(
									'error' => "Matakuliah <b>".$NamaMK."</b> tidak dapat diinput !<br>Kelas ".$CariRuang." Penuh.  Silahkan Pilih Kelas Lain !", 
									'stats' => 0
								);
								echo json_encode($dataKrs);
							}
						}else{
							$dataKrs = array(
									'error' => "Mata kuliah <b>$KodeMK : $NamaMK</b> sudah didaftarkan.", 
									'stats' => 0
								);
							echo json_encode($dataKrs);
						}
					}
					else{
						$dataKrs = array(
							'error' => "Bentrok ".$bentrok, 
							'stats' => 0
						);
						echo json_encode($dataKrs);
					}
					//  else DisplayHeader($fmtErrorMsg, $bentrok ."<hr size=1 color=silver>
					//    Opsi : <a href='ademik.php?syxec=mhswkrs&nim=$nim&thn=$thn&ssi=$ssi&ambil[]=$jid&GabungBentrok=1&prckrs=Ambil+Kuliah'>Gabungkan Mata Kuliah</a>");
				}

			}
			$this->UpdateSKSKHS($nim, $thn, $tbl);
			if (!empty($msg)) {				
				$dataKrs = array(
					'error' => "<ul>$msg</ul>", 
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
		
		if($s!=false){
			foreach ($s as $show) {
				//$sdh = GetaField("krs$kdf", "NIM='$nim' and KodeMK", $w['PraKodeMK'], 'ID');
				$qSdh =  $this->krs_model->getIdKrs($nim,$show->PraKodeMK,"_v2_krs".$thn);
				$sdh="";
				if($qSdh!=false){
					$sdh = $qSdh->ID;
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
			return "<li>Error: <b>".$arrj->NamaMK."</b><br>
			Mata kuliah tidak dapat diambil karena membutuhkan SKS kumulatif yg telah diambil: <b>$min</b> SKS, dan
			Anda baru mengambil <b>$tot</b> SKS.";
		}else{
			return '';
		}			
	}

	public function cekMaxSKS($nim, $thn, $arrj) {
		$qMax = $this->krs_model->getMaxSks($nim,$thn);
		$max = $qMax->MaxSKS;
		if($thn=="20161"){
			$tbl = "_v2_krs";
		}else{
			$tbl = "_v2_krs$thn";
		} 
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
			$Tahun = $ark->Tahun;
			//echo "$Tahun-$thn";

			$t1 = (int)str_replace('-', '', $ark->krsm);
			$t2 = (int)str_replace('-', '', $ark->krss);
			$u1 = (int)str_replace('-', '', $ark->ukrsm);
			$u2 = (int)str_replace('-', '', $ark->ukrss);
			//$res = ((($t1 <= $skrg && $skrg <= $t2) || ($u1 <= $skrg && $skrg <= $u2)) && $thn == $Tahun);
			$res = true;
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
				$msg = "KRS sudah tidak dapat diubah.<hr>
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


	public function EmptyArray($arr) {
		$jml = count($arr);
		$tmp = "";
		for ($i=0; $i < $jml; $i++) {
			if (!empty($arr[$i])) $tmp = $tmp . $arr[$i];
		}
		return empty($tmp);
	}
}