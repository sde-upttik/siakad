<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftarppl extends CI_Controller {

	function __construct(){
		parent::__construct();
	    $this->load->model('Ppl_model');
	    date_default_timezone_set("Asia/Makassar");
	}

	public function index(){
		$a['tab'] = $this->app->all_val('groupmodul')->result();
		$this->load->view('dashbord',$a);
		
	}

	public function prcmk(){

		$ulevel		= $this->session->ulevel;
		$unip		= $this->session->unip;
		$tahunaktif = "20192";
		
		$tgllahir 	= $this->input->post('tgllahir');
		$simnim 	= $this->input->post('simnim');	
		$dasal 		= $this->input->post('dasal');
		$alamat 	= $this->input->post('alamat');
		$phone 		= $this->input->post('phone');	
		$ayah 		= $this->input->post('ayah');
		$ibu 		= $this->input->post('ibu');
		$alamatot1 	= $this->input->post('alamatot');	
		$phoneot 	= $this->input->post('phoneot');
		$kendaraan 	= $this->input->post('kendaraan');	
		$tahun 		= $tahunaktif;
			
	    			  $this->Ppl_model->updateMhsw($tgllahir, $alamat, $phone, $ayah, $ibu, $alamatot1, $phoneot, $simnim);
	    	   $cek = $this->Ppl_model->selectprcmk($simnim, $tahun);

	    if($cek==0) { 
	        
	        $s2 	= $this->Ppl_model->insertppl($simnim, $tahun, $dasal, $kendaraan, $unip); 
		
			$msg 	= "<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>×</button>
						<strong>Sukses!</strong> Data Tersimpan.
					   </div>";

					$data['alert']=$msg;

					$this->load->view('temp/head');
					$this->load->view('ademik/daftarppl/daftarppl', $data);
					$this->load->view('temp/footers',$data);
	    }else{
	        
	        $s2 	= $this->Ppl_model->updateppl($dasal, $kendaraan, $simnim, $tahun);
			$msg 	="<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>×</button>
						<strong>Sukses!</strong> Data Terupdate.
						</div>";

					$data['alert']=$msg;

					$this->load->view('temp/head');
					$this->load->view('ademik/daftarppl/daftarppl', $data);
					$this->load->view('temp/footers',$data);
		}		
	}

	//_______________________________________________________________________//

	public function search_data(){

		$ulevel		= $this->session->ulevel;
		$tahunaktif = "20192";
		$unip		= $this->session->unip;
		$nim 		= $this->input->post('nim');

		 $kdf="";
		 $cekppl=0;

		 if($ulevel!="1"){
			
		 	$qKdf 	= $this->Ppl_model->getKodeFak($unip);
		 	$kdf 	= $qKdf->KodeFakultas;
		 	$cekppl = $this->Ppl_model->cekppl($unip,$tahunaktif);
		 }

		if (($kdf=="A" and $ulevel=="4") or $ulevel=="1") {
			
			$qDetail    = $this->Ppl_model->getDetail($nim);

			if ($qDetail == TRUE ) {

				$kdf 		= $qDetail->KodeFakultas;
				$t 			= $qDetail->TotalSKSLulus;
				$name 		= $qDetail->Name;
				$kdprog 	= $qDetail->KodeProgram;
				$kdjurusan 	= $qDetail->kodejurusan;
				$namaj 		= $qDetail->nmj;
				$skslulus 	= $t;
				$tahun  	= $tahunaktif;
					 	
				$cekkrs 	= $this->Ppl_model->cekkrs($nim,$tahunaktif);

				$stat=0;
					if($cekkrs>0){
						 $stat = $cekkrs;
					} else {
						$stat = "Silahkan Input Terlebih Dahulu KRS Matakuliah (PPL Terpadu)";
					}

					$pplcek = $this->Ppl_model->pplcek($nim);    
					$nilai 	= $pplcek['GradeNilai'];
					
					if ($stat>0){
						//echo "1111111111111111111111 <br>";
						$cekppl = $this->Ppl_model->pplcek($nim, $tahunaktif);
						$nilai 	= $pplcek['GradeNilai'];
						//echo $cekppl." - ".$unip." - ".$tahunaktif;
						//if($skslulus >= 110 && ($ulevel=='4' && $kdf=='A') || ($ulevel=='1')){
						if($skslulus >= 110 && ($ulevel=='4' || $ulevel=='1') && $kdf=='A' && ($nilai=='A' || $nilai=='A-' || $nilai=='B' || $nilai=='B-' || $nilai=='B+')){
							if ($cekppl==1){
								$data['alert']=

									"<div class='alert alert-success'>
										<strong style='font-size:20px;'><u>Success, Silahkan Print Formulir PPL !!!</u></strong><br><br>
											<table class='table table-striped'>
												<tr>
													<td>NIM</td> <td>: $nim</td>
												</tr>
												<tr>
													<td>Nama</td> <td>: $name </td>
												</tr>
												<tr>
													<td>Kode Program</td> <td>: $kdprog</td>
												</tr>
												<tr>
													<td>Kode Jurusan</td> <td>: $kdjurusan - $namaj</td>
												</tr>							
												<tr>
													<td>SKS Lulus</td> <td>: $skslulus</td>
												</tr>
												<tr>
													<td>Nilai Microteaching/PPL/Latihan Mengajar</td> <td>: $nilai</td>
												</tr>
											</table> 
											<img src='assets/image/printer.gif' width='20' height='20' ALIGN='left'>
												<a target='blank_' href='".base_url('ademik/report/report2/print_formulir_ppl/'.$nim)."' >Print Formulir Pendaftaran
												</a>
									</div>";

							} else {
								//echo "3 <br>";
								$qDaftarPpl = $this->Ppl_model->daftarPpl($nim); //table Jurusan 2 hilang
								
								$tgllahir 	= $qDaftarPpl->TglLahir;
								//$nmp 		= $qDaftarPpl->nmp;
								$nmj 		= $namaj;
								$kdjur 		= $kdjurusan;
								$fakultas 	= $qDaftarPpl->singfak;
								$nama 		= $name;
								$date 		= date('Y-m-d');
								$kdprog 	= $kdprog;
								$sex1 		= $qDaftarPpl->sex;

								if ($sex1 == "L"){
									$sex = "Laki-Laki";
								} else if ($sex1 == "P") {
									$sex = "Perempuan";
								}
								$agama 		= $qDaftarPpl->agama;
								$alamat 	= strtoupper($qDaftarPpl->Alamat);
								$phone 		= $qDaftarPpl->Phone;
								$nmayah 	= $qDaftarPpl->NamaOT;
								$nmibu 		= $qDaftarPpl->NamaIbu;
								$alamatot1 	= strtoupper($qDaftarPpl->AlamatOT1);
								$alamatot2 	= $qDaftarPpl->AlamatOT2;
								$phoneot 	= $qDaftarPpl->TelpOT;
								$totsks 	= $skslulus;
								$nmf 		= $qDaftarPpl->nmf;


								$T1="<table class='table table-striped table-bordered' cellspacing=0 cellpadding=2>
										<form action='".base_url('ademik/daftarppl/daftarppl/prcmk')."' method=POST>
										<tr>
											<th style='text-align:center' colspan=2 >FORMULIR PPL</th></tr>";
									
										$T2="<tr>
												<td class=lst>NIM</td> <td class=lst>$nim</td> <input type='hidden' name='simnim' value='$nim'>
											 </tr>

											 <tr>
											 	<td class=lst>Nama Lengkap</td> <td class=lst>$nama</td>
											 </tr>

											 <tr>
											 	<td class=lst>Tanggal Lahir</td> <td class=lst>
											 
											 <table>
												 <tr>
												 	<td> <input type='text' id='tanggal' name='tgllahir' value='$tgllahir' readOnly></td>
												 	<td> <input type='checkbox' onClick='show(7)'/> <font size=1>tandai untuk mengaktifkan</font></td>
												 </tr>
											 </table>

											 </td>
											 </tr>
											<tr>
												<td class=lst>Program Studi</td><td class=lst>$kdjur - $nmj</td>
											</tr>
											<tr>
												<td class=lst>Program</td><td class=lst>$kdprog</td>
											</tr>
											<tr>
												<td class=lst>Jenis Kelamin</td><td class=lst>$sex</td>
											</tr>
											<tr>
												<td class=lst>Agama</td><td class=lst>$agama</td>
											</tr>
											<tr>
												<td class=lst>Alamat di Palu</td><td class=lst>
													<table>
														<tr>
															<td><input type='text' value='$alamat' name='alamat' id='s1' readonly/></td>
															<td><input type='checkbox' onClick='show(1)' id='cb2'/> <font size=1>tandai untuk mengaktifkan</font></td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td class=lst>Nomor Telp / HP</td>
													<td class=lst>
														<table>
															<tr>
																<td><input type='text' value='$phone' name='phone' id='s2' readonly/></td>
																<td><input type='checkbox' onClick='show(2)' id='cb2'/> <font size=1>tandai untuk mengaktifkan</font></td>
															</tr>
														</table>
													</td>
											</tr>
											<tr>
												<td class=lst>Daerah Asal</td> 
												<td class=lst><input type='text' name='dasal' required></td>
											</tr>
											<tr>
												<td class=lst>Jumlah SKS Lulus</td>
												<td class=lst>$totsks SKS</td>
											</tr>
											<tr>
												<td class=lst>Nilai PPL I<br>(Microteaching)/Latihan Mengajar</td>
												<td class=lst> $nilai </td>
											</tr>
											<tr>
												<td class=lst>Ke Kampus <br>dengan Kendaraan</td>
												<td class=lst><input type='text' name='kendaraan' required></td>
											</tr>
											<tr>
												<td class=lst>Nama Orang Tua/Wali<br>yang dapat di hubungi</td>
												<td class=lst>
													<table>
													<tr>
														<td><label>Nama Ayah</label></td>
														<td><input type='text' name='ayah' value='$nmayah' id='s3' readonly /></td>
														<td><input type='checkbox' onClick='show(3)'/> <font size=1>tandai untuk mengaktifkan</font></td>
													</tr>
													<tr>
														<td>
															<label>Nama Ibu</label></td>
																<td><input type='text' value='$nmibu' name='ibu' id='s4' readonly /></td>
													</table>
											<tr>
												<td class=lst>Alamat Orang Tua/Wali<br>yang dapat di hubungi</td>
												<td class=lst>
													<table>
														<tr>
															<td><input type='text' value='$alamatot1' name='alamatot' id='s5' readonly /></td>
															<td><input type='checkbox' onClick='show(5)'/> <font size=1>tandai untuk mengaktifkan</font></td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td class=lst>No.HP Orang Tua/Wali<br>yang dapat di hubungi</td>
												<td class=lst>
													<table>
														<tr>
															<td><input type='text' value='$phoneot' name='phoneot' id='s6' readonly /></td>
															<td><input type='checkbox' onClick='show(6)'/> <font size=1>tandai untuk mengaktifkan</font></td>
														</tr>
													</table>
												</td>
											</tr>
											
											<tr>
												<td class=lst colspan=2><input type=submit value='Simpan'>&nbsp;</td>
											</tr>
											<tr>
												<td class=lst colspan=2>Catatan : Jika terdapat biodata yang belum lengkap, silahkan isi terlebih dahulu. (Menu : mahasiswa --> Biodata)</td>
											</tr>
										</form></table>";

								$data['alert']="$T1$T2";

						}
								
						}else{
							//echo "4 <br>";
							$data['alert']="
											<div class='alert alert-danger'>
												<strong style='font-size:20px;'><u>Peringatan !!!</u></strong>
												<br><br><table class='table table-striped'>
													<tr>
														<td>NIM</td>
														<td>: $nim</td>
													</tr>
													<tr>
														<td>Nama</td>
														<td>: $name </td>
													</tr>
													<tr>
														<td>Kode Program</td>
														<td>: $kdprog</td>
													</tr>
													<tr>
														<td>Kode Jurusan</td>
														<td>: $kdjurusan - $namaj</td>
													</tr>
													<tr>
														<td>SKS Lulus</td>
														<td>: $skslulus</td></tr>
													<tr>
														<td>Nilai Microteachig/PPL/Latihan Mengajar</td>
														<td>: $nilai</td>
													</tr>
												</table>
												Kriteria Untuk Mengisi Formulir PPL : SKS LULUS Minimal 110 SKS, Nilai Microteachig/PPL Minimal Grade B
											</div>";

						}
						 $this->load->view('temp/head');
						 $this->load->view('ademik/daftarppl/daftarppl', $data);
						 $this->load->view('temp/footers',$data);

					}else {
						$data['alert']="
										<div class='alert alert-danger'>
											<strong style='font-size:20px;'><u>Peringatan !!!  </u><font size=3><b>$stat</b></font></strong>
											<br><br>
											<table class='table table-striped'>
												<tr>
													<td>NIM</td><td>: $nim</td></tr>
												<tr>
													<td>Nama</td><td>: $name </td></tr>
												<tr>
													<td>Kode Program</td><td>: $kdprog</td></tr>
												<tr>
													<td>Kode Jurusan</td><td>: $kdjurusan - $namaj</td></tr>
												<tr>
													<td>SKS Lulus</td><td>: $skslulus</td></tr>
												<tr>
													<td>Nilai Microteachig/PPL/Latihan Mengajar</td><td>: $nilai</td></tr>
											</table>
										</div>";

						$this->load->view('temp/head');
						$this->load->view('ademik/daftarppl/daftarppl', $data);
						$this->load->view('temp/footers',$data);

					}

			}else{
				$qDetail['footerSection'] = "<script type='text/javascript'>
		          swal({   
		            title: 'Pemberitahuan',   
		            type: 'warning',    
		            html: true, 
		            text: 'Data Mahasiswa Tidak DiTemukan',
		            confirmButtonColor: '#f7cb3b',   
		          });
		          </script>";

        		$this->load->view('dashbord',$qDetail);
			}	
		
		}else{
			$data['alert']="
			<div class='alert alert-danger'>
				<strong style='font-size:20px;'><u>Peringatan !!!</u></strong>
				<br><br>
					<table class='table table-striped'>
						<tr>
							<td>NIM</td><td>: $nim</td></tr>
						<tr>
							<td>Nama</td><td>: $name </td></tr>
						<tr>
							<td>Kode Program</td><td>: $kdprog</td></tr>
						<tr>
							<td>Kode Jurusan</td><td>: $kdjurusan - $namaj</td></tr>
						<tr>
							<td>SKS Lulus</td><td>: $skslulus</td></tr>
						<tr>
							<td>Nilai Microteachig/PPL/Latihan Mengajar</td><td>: $nilai</td></tr>
					</table>
				Kriteria Untuk Mengisi Formulir PPL : SKS LULUS Minimal 110 SKS, Nilai Microteachig/PPL Minimal Grade B
			</div>";

			$this->load->view('temp/head');
			$this->load->view('ademik/daftarppl/daftarppl', $data);
			$this->load->view('temp/footers',$data);
		
		}

	}
	


}