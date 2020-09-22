<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mhswipk extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->model('ipk_model');
	    $this->load->model('Krs_model');
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
	    	$data = $this->ipk_model->getMhswIpk($nim);
	    	//$tampil = $this->tampilKrs($nim,20171);
	    	$tampil = $this->tampilKhs($nim);
	    	$dataView = array(
				'view' => $tampil,
				'data' => $data
			);
			echo json_encode($dataView);
	    }
	}

	public function tampilKhs($nim) {
		$rekapKhs = $this->GoRekapKHS($nim);
		//$ipk = $this->GoIPK($nim);

		return $rekapKhs;
	}

	public function survey() {
		echo '<form method="post" action="'.base_url("ademik/mhswipk/actionSurvey/").'">';

		$IDJadwalpj = $_GET['IDJadwalpj'];
		$stq = mysql_query("select StatusVal,UserVal,TglVal from jadwal where IDJADWAL='$kodeMK' and Tahun='$thn'");
			 $st = mysql_result($stq,0,'StatusVal');
		         $userval = mysql_result($stq,0,'UserVal');
			$tglval = mysql_result($stq,0,'TglVal');


		$NamaMK = "";
		$SKS = "";
		$NamaDS1 = "";
		$Dosen1 = "";
		$Dosenx2 = "";
		$Dosenx3 = "";
		$Dosenx4 = "";
		$Dosenx5 = "";
		$NamaDSx2 = "";
		$NamaDSx2 = "";
		$NamaDSx2 = "";
		$NamaDSx2 = "";




		$qee = "SELECT NamaMK,SKS,j.IDDosen,d.Name,j.Tahun from jadwal j,dosen d where j.IDDosen=d.NIP and j.IDJadwal='$IDJadwalpj '";
		//echo $qe;
		$hasx = mysql_query($qee);
		$jmldsn = 0;
		$thnpj = "";
		//$jumMhsw=mysql_num_rows($hasill);
		while($row=mysql_fetch_array($hasx)){
		   $head = $row[0]." - ".$row[1]." ( SKS = ".$row[2]." )";
		   	$NamaMK = $row[0];
			$SKS = $row[1];
			$NamaDS1 = $row[3];
			$Dosen1 = $row[2];
			if($Dosen1!='' || !empty($Dosen)){
				$jmldsn++;
			}
		   $thnpj = $row[4];
		}


		//

		$qeedet = "SELECT j.IDDosen,d.Name from jadwalassdsn j,dosen d where j.IDDosen=d.NIP and j.IDJadwal='$IDJadwalpj '";
		//echo $qe;
		$hasx2 = mysql_query($qeedet);
		//$jumMhsw=mysql_num_rows($hasill);
		$assdsnd = "";
		while($row2=mysql_fetch_array($hasx2)){
		   $assdsnd .= $row2[0].":".$row2[1]."-";
		   	$jmldsn++;
			
			
		}
		$assdsnd .= "#";
		$assdsnd = str_replace('-#','',$assdsnd);
		//echo "$assdsnd<br>";
		$assdsn1 = explode('-',$assdsnd);
		//
		$assdsn2 = explode(':',$assdsn1[0]);
		$Dosenx2 = $assdsn2[0];
		$NamaDSx2 = $assdsn2[1];

		$assdsn3 = explode(':',$assdsn1[1]);
		$Dosenx3 = $assdsn3[0];
		$NamaDSx3 = $assdsn3[1];

		$assdsn4 = explode(':',$assdsn1[2]);
		$Dosenx4 = $assdsn4[0];
		$NamaDSx4 = $assdsn4[1];

		$assdsn5 = explode(':',$assdsn1[3]);
		$Dosenx5 = $assdsn5[0];
		$NamaDSx5 = $assdsn5[1];
		//
		$jamc = date("G");
		echo "User : $unip<br>";
		$cekvalid = "true";

		$date=date("l, d F Y, H:i:s"); echo "Tanggal dan Waktu: $date <br>"; echo "Jumlah Record = $jumMhsw Mahasiswa<br>";

		$qemk = "SELECT krs.NamaMK,krs.KodeMK,SKS FROM krs where IDJADWAL='$kodeMK'";
		//echo $qemk;
		echo $KodeMK;

		$head="";
		$hasil=mysql_query($qemk);
		while($row=mysql_fetch_array($hasil)){
		   $head = $row[0]." - ".$row[1]." ( SKS = ".$row[2]." )";
		}

		$nimjpx =  $_SESSION['NIMJP'];
		echo "$NamaMK - ( $SKS )<br>";
		if($jmldsn>=1) echo "Dosen 1 : $NamaDS1-$Dosen1<br>";
		if($jmldsn>=2) echo "Dosen 2 : $NamaDSx2-$Dosenx2<br>";
		if($jmldsn>=3) echo "Dosen 3 : $NamaDSx3-$Dosenx3<br>";
		if($jmldsn>=4) echo "Dosen 4 : $NamaDSx4-$Dosenx4<br>";
		if($jmldsn>=5) echo "Dosen 5 : $NamaDSx5-$Dosenx5<br>";
		echo "$head<br>"; 
		echo "1 = Sangat Tidak Sesuai | 2 = Tidak Sesuai | 3 = Kurang Sesuai | 4 = Sesuai | 5 = Sangat Sesuai"; 

		echo "<input type='hidden' name='nimjpx' value='$nimjpx'/>";
		//echo "$nimjpx-$jmldsn<br>";
		//variabel hidden

		echo "<input type='hidden' name='jmldsn' value='$jmldsn'/>";
		echo "<input type='hidden' name='idjdw' value='$IDJadwalpj'/>";
		echo "<input type='hidden' name='thnpj' value='$thnpj'/>";

		echo "<input type='hidden' name='dosen1' value='$Dosen1'/>";
		echo "<input type='hidden' name='dosen2' value='$Dosenx2'/>";
		echo "<input type='hidden' name='dosen3' value='$Dosenx3'/>";
		echo "<input type='hidden' name='dosen4' value='$Dosenx4'/>";
		echo "<input type='hidden' name='dosen5' value='$Dosenx5'/>";


	}

	public function GoRekapKHS($nim) {
		$ulevel=$_SESSION['ulevel'];
		$addSesi = $this->FormAddSesi($nim);

		$cekKodeFakultas = $this->ipk_model->getKodeFakultas($nim);
		$kdf = $cekKodeFakultas->KodeFakultas;
		$cekKode = $this->ipk_model->getKode($nim);
		$kdj = $cekKode->KodeJurusan;
		
		$headTable = "
			<br>
			<table class='table table-bordered table-responsive' cellspacing=1 cellpadding=2>
				<tr>
					<th style='text-alignment:center; font-weight:bold;'>Tahun<br>Akademik</th>
					<th style='text-alignment:center; font-weight:bold;'>Sesi</th>
					<th style='text-alignment:center; font-weight:bold;'>Max SKS</th>
					<th style='text-alignment:center; font-weight:bold;'>Status Mhsw</th>
					<th style='text-alignment:center; font-weight:bold;'>Juml.<br>SKS diambil</th>
					<th style='text-alignment:center; font-weight:bold;'>IPS</th>
					<th style='text-alignment:center; font-weight:bold;'>Juml. SKS<br>Kumulatif</th>
					<th style='text-alignment:center; font-weight:bold;'>IPK</th>
					<th style='text-alignment:center; font-weight:bold;'>feeder KHS</th>
					<th style='text-alignment:center; font-weight:bold;'>feeder KRS</th>
					<th style='text-alignment:center; font-weight:bold;'>Abaikan feeder KRS</th>
					<th style='text-alignment:center; font-weight:bold;'>AKSI</th>
				</tr>
		";

		$getDataKhs = $this->ipk_model->getDataKhs($nim);

		$tableContent = '';
		$uniqueId=0;
		foreach ($getDataKhs as $show) {
			$thn = $show->Tahun;
			//echo $thn;
			$getFeederKrs = $this->ipk_model->getFeederKrs($nim,$thn);
			$getCountKrs = $this->ipk_model->getCountKrs($nim,$thn);
			if($getCountKrs){
				$jmlKrs = $getCountKrs->jmlKrs;
			}else{
				$jmlKrs = 0;
			}
			$st_feederKrs=0;
			$st_abaikanKrs=0;
			$cekKrs = $this->ipk_model->getCekFeederKrs($nim,$thn);
			if($cekKrs){
				if($getFeederKrs){
					foreach ($getFeederKrs as $show1) {
						if($show1->st_feeder>0 || $show1->NotActive_KRS == 'Y'){
							$st_feederKrs++;
						}elseif($show1->st_abaikan>0){
							$st_abaikanKrs++;
						}
					}
				}
			}
			$KHSId = $show->KHSId;
			$ssi = $show->Sesi;
			$sta = $show->Status;

			$nil = $show->Nilai;
			$grd = $show->GradeNilai;
			$bbt = $show->Bobot;
			$_bbt = number_format($bbt, 2, ',', '');
			$sks = $show->SKS;
			$ips = number_format($show->IPS, 2, ',', '');
			if ($kdf == "B") $TotalSKS = $show->TotalSKSLulus;
			else $TotalSKS = $show->TotalSKS;
			$ipk = number_format($show->IPK, 2, ',', '');
			$did = $show->DosenID;
			$maxsks = $show->MaxSKS;
			$sta = $show->STA;
			$kp = $show->KodeProgram;
			$thnAkademik = $show->TahunAkademik;

			$ntbl = "Cuti";
			if($sta=='Cuti')  $ntbl = "Aktifkan";   
			$ntbl1 = "Unregist";
			if($sta=='Unregist')  $ntbl1 = "Aktifkan";        

			$status = $show->Status;
			if ($_SESSION['ulevel']==3 || $_SESSION['ulevel']==5 || ( $_SESSION['ulevel']==7 ) || $_SESSION['id']==$did || $_SESSION['ulevel']==1) {
				$strssi = "
					<td align=center><input type=text name='ssi' value='$ssi' size=3 maxlength=3 id='ssi".$uniqueId."'></td>
					<td align=center>
						<input type=text name='maxsks' value='$maxsks' size=3 maxlength=3 id='maxsks".$uniqueId."'>
						<button type='button' data-unique='$uniqueId' data-nim='$nim' data-thn='$thn' class='ubah'>Ubah</button>
					</td>
				";
			}
			else $strssi = "<td align=center>$ssi</td><td  align=center>$maxsks</td>";
			
			if($ulevel==1 OR $ulevel==5 OR $ulevel==7) $StrLink="/<a href='mhswipk/editTahun/$KHSId/$thn/$nim' title='Klik di sini untuk mengedit Tahun akademik'>Edit Thn</a>";
			else $StrLink='';
			//echo "<a href='ademik.php?syxec=mhswipk&KHSId=$KHSId&nim=$nim&thn=$thn&hapusKHS=1'><input type='button' value='hapus'></a>";
			if($show->st_feeder>0){
				//$st_khs="sudah";
				$st_khs="<img src='https://siakad2.untad.ac.id/assets/images/btn_ok_16.png' border='0'>";
			}else{
				//$st_khs="belum";
				$st_khs="<img src='https://siakad2.untad.ac.id/assets/images/btn_clc_16.png' border='0'>";
			}

			if($getFeederKrs){
				if($st_feederKrs==$jmlKrs){
					$st_krs="<img src='https://siakad2.untad.ac.id/assets/images/btn_ok_16.png' border='0'>";
				}else{
					//$st_krs="belum";
					$st_krs="<img src='https://siakad2.untad.ac.id/assets/images/btn_clc_16.png' border='0'>";
				}	
			}else{
				$st_krs="<img src='https://siakad2.untad.ac.id/assets/images/btn_clc_16.png' border='0'>";
			}
			/*if($getFeederKrs!=false){
				if($st_feederKrs==$jmlKrs){
					$st_krs="sudah";
				}else{
					$st_krs="belum";
				}	
			}else{
				$st_krs="belum";
			}*/

			if($st_abaikanKrs==0){
				$st_abaikanKrs1 = 'Tidak ada data diabaikan';
			}else{
				$st_abaikanKrs1 = 'ada '.$st_abaikanKrs.' data yg diabaikan';
			}
			

			$content = "<tr id='row_".$KHSId."'>
			<td align=center><a href='ademik.php?syxec=mhswkhs&thn=$thn&nim=$nim&StrBack=mhswipk'>$thn</a>$StrLink</td>
			$strssi
			<td align=center>$sta</td>
			<td align=center>$sks</td>

			<td align=center>$ips</td>
			<td align=center>$TotalSKS</td>
			<td align=center>$ipk</td>
			<td align=center>".$st_khs."</td>
			<td align=center>".$st_krs."</td>    
			<td align=center>".$st_abaikanKrs1."</td>      
			<td align=center>";
			//if($sta=='Aktif')  echo "<a href='ademik.php?syxec=mhswipk&nim=$nim&thn=$thn&refreshipk=refresh'><input type='button' value='Refresh Data'></a>";

			if($ulevel==1 || $ulevel==5 || $ulevel==7) {
				$btnCuti = "<button type='button' style='margin-top: 5px;' class='btn btn-primary cuti' data-nim='$nim' data-thn='$thn' data-cuti='$ntbl'>$ntbl</button>";
				$btnUnregist = "&nbsp;<button type='button' style='margin-top: 5px;' class='btn btn-primary unregist' data-nim='$nim' data-thn='$thn' data-unregist='$ntbl1'>$ntbl1</button>";
			}else{
				$btnCuti = "";
				$btnUnregist = "";
			}
			if($ulevel==1 || $ulevel==5 || $ulevel==7 || $ulevel==4){  
				$hps = "<button type='button' style='margin-top: 5px;' class='btn btn-primary hps_ipk' data-khsid='$KHSId' data-nim='$nim' data-thn='$thn'>Hapus</button>";


				$getPeriodeAktif = $this->ipk_model->getPeriodeAktif();

				if($getPeriodeAktif->periode_aktif==$thn){
					if($this->session->unip=='wawan' && $this->session->ulevel=='1' && $this->cekpjn($nim, $thn)=='false' && $kdf=='D') {
						$btn = "
							<a href='".base_url('ademik/mhswipk/survey/').$nim.'/'.$thn."' target='_blank' class='btn btn-primary'>Survey kepuasan</a>
						";
					}else{
						$btn = "
							<button type='button' style='margin-top: 5px;' class='btn btn-primary sks_max' data-nim='$nim' data-thn='$thn' data-kdf='$kdf' data-kdj='$kdj'>Prc SKS Max</button>
							<button type='button' style='margin-top: 5px;' class='btn btn-primary prc_ips' data-nim='$nim' data-thn='$thn' data-kdf='$kdf' data-kdj='$kdj'>Prc IPS</button>
							<button type='button' style='margin-top: 5px;' class='btn btn-primary prc_ipk' data-nim='$nim' data-thn='$thn' data-kdf='$kdf' data-kdj='$kdj'>Prc IPK</button>
							<a href='".base_url('ademik/report/report/cetak_khs/').$thn.'/'.$kp.'/'.$kdj.'/'.$thnAkademik.'/'.$nim.'/'.$kdf."' target='_blank'><input type='button' style='margin-top: 5px;' class='btn btn-primary' value='Cetak KHS'></a>
						";	

						//$persentase = $this->ipk_model->getHadir($thn,$nim);
						$cekBayar = $this->ipk_model->cekBayar($thn,$nim);
						if($cekBayar && $cekBayar->bayar>0){
							$btnKartuUjian = "<a href='".base_url('ademik/report/report2/cetak_kartu_ujian/').$thn.'/'.$kp.'/'.$kdj.'/'.$nim."' target='_blank'><input type='button' style='margin-top: 5px;' class='btn btn-primary' value='Cetak Kartu Ujian'></a>";	
						}else{
							$btnKartuUjian = "";
						}
						
						$btn=$btn.$btnKartuUjian;
					}
				}else{
					if($show->st_feeder>0 AND $st_feederKrs==$jmlKrs){
						if($this->session->unip=='wawan' && $this->session->ulevel=='1' && $this->cekpjn($nim, $thn)=='false' && $kdf=='D') {
							$btn = "
								<a href='".base_url('ademik/mhswipk/survey/').$nim.'/'.$thn."' target='_blank' class='btn btn-primary'>Survey kepuasan</a>
							";
						}else{
							$btn = "
								<button class='btn btn-primary sks_max' style='margin-top: 5px;' type='button' data-nim='$nim' data-thn='$thn' data-kdf='$kdf' data-kdj='$kdj'>Prc SKS Max</button>
								<button class='btn btn-primary prc_ips' style='margin-top: 5px;' type='button' data-nim='$nim' data-thn='$thn' data-kdf='$kdf' data-kdj='$kdj'>Prc IPS</button>
								<button class='btn btn-primary prc_ipk' style='margin-top: 5px;' type='button' data-nim='$nim' data-thn='$thn' data-kdf='$kdf' data-kdj='$kdj'>Prc IPK</button>
								<a href='".base_url('ademik/report/report/cetak_khs/').$thn.'/'.$kp.'/'.$kdj.'/'.$thnAkademik.'/'.$nim.'/'.$kdf."' target='_blank'><input type='button' style='margin-top: 5px;' class='btn btn-primary' value='Cetak KHS'></a>
							";	

							$cekBayar = $this->ipk_model->cekBayar($thn,$nim);
							if($cekBayar && $cekBayar->bayar>0){
								$btnKartuUjian = "<a href='".base_url('ademik/report/report2/cetak_kartu_ujian/').$thn.'/'.$kp.'/'.$kdj.'/'.$nim."' target='_blank'><input type='button' style='margin-top: 5px;' class='btn btn-primary' value='Cetak Kartu Ujian'></a>";	
							}else{
								$btnKartuUjian = "";
							}

							$btn=$btn.$btnKartuUjian;
						}
					}else{
						if($thn>=20182 and ($thn!=20183 AND $thn!=20184)){
							$btn = "&nbsp;<button type='button' style='margin-top: 5px;' class='btn btn-primary sks_max' data-nim='$nim' data-thn='$thn' data-kdf='$kdf' data-kdj='$kdj'>Prc SKS Max</button>
								&nbsp; <b>DATA untuk KRS atau KHS belum Terkirim ke Feeder</b> &nbsp;";
						}else{
							if($this->session->unip=='wawan' && $this->session->ulevel=='1' && $this->cekpjn($nim, $thn)=='false' && $kdf=='D') {
								$btn = "
									<a href='".base_url('ademik/mhswipk/survey/').$nim.'/'.$thn."' target='_blank' class='btn btn-primary'>Survey kepuasan</a>
								";
							}else{
								$btn = "
									<button class='btn btn-primary sks_max' style='margin-top: 5px;' type='button' data-nim='$nim' data-thn='$thn' data-kdf='$kdf' data-kdj='$kdj'>Prc SKS Max</button>
									<button class='btn btn-primary prc_ips' style='margin-top: 5px;' type='button' data-nim='$nim' data-thn='$thn' data-kdf='$kdf' data-kdj='$kdj'>Prc IPS</button>
									<button class='btn btn-primary prc_ipk' style='margin-top: 5px;' type='button' data-nim='$nim' data-thn='$thn' data-kdf='$kdf' data-kdj='$kdj'>Prc IPK</button>
									<a href='".base_url('ademik/report/report/cetak_khs/').$thn.'/'.$kp.'/'.$kdj.'/'.$thnAkademik.'/'.$nim.'/'.$kdf."' target='_blank'><input type='button' style='margin-top: 5px;' class='btn btn-primary' value='Cetak KHS'></a>
								";
								$cekBayar = $this->ipk_model->cekBayar($thn,$nim);
								if($cekBayar && $cekBayar->bayar>0){
									$btnKartuUjian = "<a href='".base_url('ademik/report/report2/cetak_kartu_ujian/').$thn.'/'.$kp.'/'.$kdj.'/'.$nim."' target='_blank'><input type='button' style='margin-top: 5px;' class='btn btn-primary' value='Cetak Kartu Ujian'></a>";	
								}else{
									$btnKartuUjian = "";
								}
								
								$btn=$btn.$btnKartuUjian;
							}	
						}
					}	
				}
				
				

				if($ulevel!=4){
					$btn=$btn.$hps;
				}
			}else{
				$btn = "";
			}
			$closetd = "</td></tr>";

			$tableContent = $tableContent.$content.$btnCuti.$btnUnregist.$btn.$closetd;
			$uniqueId++;
		}
		$footer = "</table>
			</div>
			<script>
				var i = setInterval(function() {
					if ($) {
						clearInterval(i);

						$(function(){
							var nim = $('#nim').val();
							var dataku = 'nim='+nim;
							$.ajax({
								url: '".base_url('ademik/mhswipk/search')."',
								data: dataku,
								type: 'POST',
								dataType: 'json',
								cache : false,
								success: function(msg){ 
										$('#nim').val(msg.data[0].NIM);
										$('#nama').val(msg.data[0].Name);
										$('#fakultas').val(msg.data[0].KodeFakultas+' - '+msg.data[0].FAK);
										$('#jurusan').val(msg.data[0].KodeJurusan+' - '+msg.data[0].JUR);
										$('#jenjang').val(msg.data[0].JEN);
										$('#dosenPenasehat').val(msg.data[0].DSN);
										//console.log(msg.view);

										$('#isiContent').show();
										document.getElementById('boxContent').innerHTML = msg.view;

										/*var button = document.querySelectors('.ubah');
										display = $('#isiTable');
										button.addEventListener('click', function (event) {*/		
										
										$('.sks_max').click(function(event){		
											event.preventDefault();
											var thn = $(this).data('thn');
											var nim = $(this).data('nim');
											var kdf = $(this).data('kdf');
											var kdj = $(this).data('kdj');

											var dataku = 'thn='+thn+'&nim='+nim+'&kdf='+kdf+'&kdj='+kdj;
											var body = $('body');
											body.addClass('loading');
											//alert($('#formPrcKrs').serialize());
											$.ajax({
												url: '".base_url('ademik/mhswipk/RefreshMaxSks2')."',
												data: dataku,
												type: 'POST',
												dataType: 'json',
												cache : false,
												success: function(msg){ 
													body.removeClass('loading');
													//alert(msg.isi+' '+msg.nim+' '+msg.semesterAkademik);
													//alert(msg);	
													swal({   
														title: 'Informasi',   
														type: 'info',    
														html: true, 
														text: msg.message,
														confirmButtonColor: '#f7cb3b',   
													});		
													$(display).fadeOut(800, function(){
														display.html(msg.displayIpk).fadeIn().delay(2000);
													});
												},
												error: function(err){
													console.log(err);
												}
											});
										});

										$('.prc_ips').click(function(event){
											event.preventDefault();
											var thn = $(this).data('thn');
											var nim = $(this).data('nim');
											var kdf = $(this).data('kdf');
											var kdj = $(this).data('kdj');

											var dataku = 'thn='+thn+'&nim='+nim+'&kdf='+kdf+'&kdj='+kdj;
											var body = $('body');
											body.addClass('loading');
											//alert($('#formPrcKrs').serialize());
											$.ajax({
												url: '".base_url('ademik/mhswipk/prosesIps')."',
												data: dataku,
												type: 'POST',
												dataType: 'json',
												cache : false,
												success: function(msg){ 
													body.removeClass('loading');
													//alert(msg.isi+' '+msg.nim+' '+msg.semesterAkademik);
													//alert(msg);	
													swal({   
														title: 'Informasi',   
														type: 'info',    
														html: true, 
														text: msg.message,
														confirmButtonColor: '#f7cb3b',   
													});		
													$(display).fadeOut(800, function(){
														display.html(msg.displayIpk).fadeIn().delay(2000);
													});
												},
												error: function(err){
													console.log(err);
												}
											});
										})
										
										$('.prc_ipk').click(function(event){
											event.preventDefault();
											var thn = $(this).data('thn');
											var nim = $(this).data('nim');
											var kdf = $(this).data('kdf');
											var kdj = $(this).data('kdj');

											var dataku = 'thn='+thn+'&nim='+nim+'&kdf='+kdf+'&kdj='+kdj;
											var body = $('body');
											body.addClass('loading');
											//alert($('#formPrcKrs').serialize());
											$.ajax({
												url: '".base_url('ademik/mhswipk/prosesIpk')."',
												data: dataku,
												type: 'POST',
												dataType: 'json',
												cache : false,
												success: function(msg){ 
													body.removeClass('loading');
													//alert(msg.isi+' '+msg.nim+' '+msg.semesterAkademik);
													//alert(msg);	
													swal({   
														title: 'Informasi',   
														type: 'info',    
														html: true, 
														text: msg.message,
														confirmButtonColor: '#f7cb3b',   
													});		
													$(display).fadeOut(800, function(){
														display.html(msg.displayIpk).fadeIn().delay(2000);
													});
												},
												error: function(err){
													console.log(err);
												}
											});
										})

										var button = document.querySelector('#prcaddssi');
										var display = $('#isiTable');
										button.addEventListener('click', function (event) {
											event.preventDefault();
											var body = $('body');
											body.addClass('loading');
											//alert($('#formPrcKrs').serialize());
											$.ajax({
												url: '".base_url('ademik/mhswipk/PrcAddSesi')."',
												data: $('#formAddSesi').serialize(),
												type: 'POST',
												dataType: 'json',
												cache : false,
												success: function(msg){ 
													body.removeClass('loading');
													//alert(msg.isi+' '+msg.nim+' '+msg.semesterAkademik);
													//alert(msg);	
													swal({   
														title: 'Informasi',   
														type: 'info',    
														html: true, 
														text: msg.message,
														confirmButtonColor: '#f7cb3b',   
													});		
													$(display).fadeOut(800, function(){
														display.html(msg.displayIpk).fadeIn().delay(2000);
													});
												},
												error: function(err){
													console.log(err);
												}
											});
										});

										$('.ubah').click(function(event){		
											event.preventDefault();
											var thn = $(this).data('thn');
											var nim = $(this).data('nim');
											var uniqueId = $(this).data('unique');
											var ssi = $('#ssi'+uniqueId).val();
											var maxsks = $('#maxsks'+uniqueId).val();

											var dataku = 'thn='+thn+'&nim='+nim+'&ssi='+ssi+'&maxsks='+maxsks;
											var body = $('body');
											body.addClass('loading');
											//alert($('#formPrcKrs').serialize());
											$.ajax({
												url: '".base_url('ademik/mhswipk/PrcSesi')."',
												data: dataku,
												type: 'POST',
												dataType: 'json',
												cache : false,
												success: function(msg){ 
													body.removeClass('loading');
													//alert(msg.isi+' '+msg.nim+' '+msg.semesterAkademik);
													//alert(msg);	
													swal({   
														title: 'Informasi',   
														type: 'info',    
														html: true, 
														text: msg.message,
														confirmButtonColor: '#f7cb3b',   
													});		
													$(display).fadeOut(800, function(){
														display.html(msg.displayIpk).fadeIn().delay(2000);
													});
												},
												error: function(err){
													console.log(err);
												}
											});
										});

										$('.cuti').click(function(event){		
											event.preventDefault();
											var thn = $(this).data('thn');
											var nim = $(this).data('nim');
											var cuti = $(this).data('cuti');

											var dataku = 'thn='+thn+'&nim='+nim+'&cuti='+cuti;
											var body = $('body');
											body.addClass('loading');
											//alert($('#formPrcKrs').serialize());
											$.ajax({
												url: '".base_url('ademik/mhswipk/RefreshCuti')."',
												data: dataku,
												type: 'POST',
												dataType: 'json',
												cache : false,
												success: function(msg){ 
													body.removeClass('loading');
													//alert(msg.isi+' '+msg.nim+' '+msg.semesterAkademik);
													//alert(msg);	
													swal({   
														title: 'Informasi',   
														type: 'info',    
														html: true, 
														text: msg.message,
														confirmButtonColor: '#f7cb3b',   
													});		
													$(display).fadeOut(800, function(){
														display.html(msg.displayIpk).fadeIn().delay(2000);
													});
												},
												error: function(err){
													console.log(err);
												}
											});
										});

										/*$('.hps_ipk').click(function(event){
											event.preventDefault();
											var KHSId = $(this).data('KHSId');
											var nim = $(this).data('nim');
											var thn = $(this).data('thn');

											var dataku = 'thn='+thn+'&nim='+nim+'&KHSId='+KHSId;
											var body = $('body');
											body.addClass('loading');
											//alert($('#formPrcKrs').serialize());
											$.ajax({
												url: '".base_url('ademik/mhswipk/hapusIpk')."',
												data: dataku,
												type: 'POST',
												dataType: 'json',
												cache : false,
												success: function(msg){ 
													body.removeClass('loading');
													//alert(msg.isi+' '+msg.nim+' '+msg.semesterAkademik);
													//alert(msg);	
													swal({   
														title: 'Informasi',   
														type: 'info',    
														html: true, 
														text: msg.message,
														confirmButtonColor: '#f7cb3b',   
													});		
													$(display).fadeOut(800, function(){
														display.html(msg.displayIpk).fadeIn().delay(2000);
													});
												},
												error: function(err){
													console.log(err);
												}
											});
										})*/
										
								},
								error: function(err){
									console.log(err);
								}
							});
						});
					}
				}, 100);
			</script>
		";

		return $addSesi.$headTable.$tableContent.$footer;
	}

	/*public function GetOption2($_table, $_field, $_order='', $_default='', $_where='', $_value='', $not=0) {
		if (!empty($_order)) $str_order = " order by $_order ";
		else $str_order = "";
		if ($not==0) $strnot = "NotActive='N'"; else $strnot = '';
		if (!empty($_where)) {
			if (empty($strnot)) $_where = "$_where"; else $_where = "and $_where";
		}
		if (!empty($_value)) {
			$_fieldvalue = ", $_value";
			$fk = $_value;
		}
		else {
			$_fieldvalue = '';
			$fk = $_field;
		}
		$_tmp = "<option value=''></option>";
		$_sql = "select $_field $_fieldvalue from _v2_$_table where $strnot $_where $str_order";
		//echo "GetOption2 _sql =$_sql<br>";
		$q_sql = $this->ipk_model->getSql($_sql);

		foreach ($q_sql as $show) {
			if (!empty($_value)) $_v = "value='" . $show->$_value . "'";
			else $_v = '';
			if ($_default == $show->$fk){
				$_tmp = "$_tmp <option $_v selected>". $show->$_field ."</option>";
			}
			else{
				$_tmp = "$_tmp <option $_v>". $show->$_field ."</option>";
			}
		}
		return $_tmp;
	}*/
	public function updatetahunakademik(){
		$id=$this->input->post('id');
		$semester= $this->input->post('semester');

		$update = $this->ipk_model->updatetahunakademik($id,$semester);
		
		redirect('ademik/mhswipk');

	}

	public function editTahun($idkhs,$thn,$nim){
		$data['id'] = $idkhs;
		$data['semester'] = $thn;
		$data['nim'] = $nim;
		$this->load->view('temp/head');
		$this->load->view('ademik/edittahun',$data);
		$this->load->view('temp/footers');
	}


	public function FormAddSesi($nim) {
		$qSsi = $this->ipk_model->getSesiMax($nim);
		$ssi = $qSsi->ssi+1;
		$qThnNext = $this->ipk_model->getTahunNextMax($nim);
		$ThnNext = $qThnNext->ThnNext+1;
		
		$kdf=substr("$nim",0,1);
		if($kdf=='C') $maxsks=24; //2007 , Sesuai permintaan Kedokteran
		else $maxsks = $this->getMaxSKSMhsw($nim);

		if($_SESSION['ulevel']==4){
			$form="";
			/*$form = "
			<div id='isiTable'>
				<form method='POST' id='formAddSesi'>
					<table class=basic cellspacing=1 cellpadding=2>
						<input type=hidden name='syxec' value='mhswipk'>
						<input type=hidden name='nim' value='$nim'>
						<input type=hidden name='maxsks' value='maxsks'>
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
						<td class=lst>$maxsks</td>
						<td class=basic rowspan=2>
							<input type=submit name='prcaddssi' id='prcaddssi' value='Tambah'>
						</td>
						</tr>
					</table>
				</form>
			";*/
		}else{
			$form = "
			<div id='isiTable'>
				<form method='POST' id='formAddSesi'>
					<table class=basic cellspacing=1 cellpadding=2>
						<input type=hidden name='syxec' value='mhswipk'>
						<input type=hidden name='nim' value='$nim'>
						<tr>
							<th class=ttl colspan=6>Tambah Semester Baru</th>
							<td class=basic></td>
						</tr>
						<td class=ttl>Tahun Ajaran</td>
						<td class=lst><input type=text name='thn' value='$ThnNext' size=5 maxlength=5></td>
						<td class=ttl>Sesi/Semester</td>
						<td class=lst>
							<input type=text name='ssi' value='$ssi' size=5 maxlength=5>
						</td>
						<td class=ttl>Max SKS</td>
						<td class=lst>
							<input type=text name='maxsks' value='$maxsks' size=5 maxlength=5>
						</td>
						<td class=basic rowspan=2>
							<input type=submit name='prcaddssi' id='prcaddssi' value='Tambah'>
						</td>
						</tr>
					</table>
				</form>
			";
		}

		$prcAll = "
				<div style='margin-top:10px;'>
					<table class=basic cellspacing=1 cellpadding=2>
						<td class=basic>
							<button name='prcAllIps' onclick='prcAllIps(\"$nim\")'class='btn btn-primary'>Prc All IPS</button>
						</td>
						<td class=basic>
							<button name='prcAllIpk' onclick='prcAllIpk(\"$nim\")' class='btn btn-success'>Prc All IPK</button>
						</td>

						<td>
							<a href='".base_url()."ademik/report/report2/cetak_transkrip_nilai_kliring/".$nim."' class='btn btn btn-default fa fa-file-excel-o'> Cetak Transkrip Nilai</a>
						</td>
						</tr>
					</table>
				</div>";
		return $form." ".$prcAll;
	}

	public function getMaxSKSMhsw($nim) {
		$defSKS = 24;
		$qKdj = $this->ipk_model->getKode($nim);
		$kdj = $qKdj->KodeJurusan;
		
		$sesiBobot = $this->ipk_model->getSesiBobot($nim);
		if($sesiBobot==false){
			$sesi = 0; 
			$bbt = 0;
		}else{
			//$ada="asdas";
			$sesi = $sesiBobot->Sesi;
			if($sesiBobot->Bobot==0 AND $sesiBobot->SKS==0){
				$bbt = 0;
			}else{
				$bbt = $sesiBobot->bbt;	
			}
		}

		//echo $sesi." ".$bbt."|".$kdj;
		$bbt=sprintf("%.1f",$bbt);
		$qMax = $this->ipk_model->getMaxSksRange($bbt,$kdj);
		$max = $qMax->SKSMax;
		return $max;
	}

	public function GoIPK($nim) {
		$arr = $this->ipk_model->getSksBbt($nim);
		if ($arr!=false) {
			$sks = $arr->SKS; 
			$bbt = $arr->BBT;
			if ($sks == 0) $ipk = 0; else $ipk = $bbt/$sks;
			$ipkF = number_format($ipk, 2, ',', '');
			//$update = $this->ipk_model->updateIpkMhsw($TotSKS,$TotIPK,$nim,$TotSKSLulus);
			
			return "
				<br>
				<table cellspacing=0 cellpadding=2>
					<tr>
						<td width='200px'>Total SKS</td>
						<td align=right>$sks</td>
					</tr>
					<tr>
						<td>Index Prestasi Kumulatif</td>
						<td align=right>$ipkF</td>
					</tr>
				</table>
			";
		}
	}

	public function cekpjn($nim, $thn) {
		$cekpj = "false";

		$table = "_v2_krs".$thn;

		$getJadwal = $this->ipk_model->getJmlJadwal($table, $nim, $thn);

		$jmldsn= 0;
		$jmlpj= 0;
		foreach ($getJadwal as $show) {
			$cekDosen= $this->ipk_model->cekJmlDosen($show->IDJadwal);
			
			foreach ($cekDosen as $showDosen) {
				if($showDosen->IDDosen!= "" || !empty($showDosen->IDDosen)){
					$jmldsn++;
				}
			}
			
			$cekAssDosen= $this->ipk_model->cekJmlAssDosen($show->IDJadwal);
			
			foreach ($cekAssDosen as $showAssDosen) {
				//if($showDosen->IDDosen!= "" || !empty($showDosen->IDDosen)){
					$jmldsn++;
				//}
			}

			$cekPjMutu= $this->ipk_model->cekPjMutu($show->IDJadwal, $nim);

			foreach ($cekPjMutu as $showPjMutu) {
				$jmlpj++;
			}

		}

		if($jmlpj==$jmldsn){
			$cekpj = "true";
		}
		return $cekpj;
	}

	public function PrcAddSesi() {
		$thn = $this->input->post('thn');
		$nim = $this->input->post('nim');
		$ssi = $this->input->post('ssi');
		$sksmax = $this->input->post('maxsks');
		if (!empty($thn)) {
			$ada = $this->ipk_model->getTahunKhs($nim,$thn);
			if ($ada==true) {
				$msg = "Tahun ajaran $thn dan Sesi/Semester $ssi sudah ada.";
			} else {
			 	$data = array("NIM"=>$nim, "Tahun"=>$thn, "Sesi"=>$ssi, "Status"=>"A", "MaxSKS"=>$sksmax);

				$simpan = $this->ipk_model->insertKhs($data);

				if($simpan){
			 		$msg = "Data berhasil ditambahkan";
			 	}else{
			 		$msg = "Data gagal tersimpan";
			 	}

			 	$update = $this->ipk_model->updateMhsw("A",$thn,$nim);
			}
		}else{
			$msg = "Tahun Belum Diisi";			
		}

		$displayIpk = $this->GoRekapKHS($nim);

		$dataIpk = array(
			'message' => $msg,
			'displayIpk' => $displayIpk
		);
		echo json_encode($dataIpk);
	}

	public function PrcSesi() {
		$thn = $this->input->post('thn');
		$nim = $this->input->post('nim');
		$maxsks = $this->input->post('maxsks');
		$ssi = $this->input->post('ssi');

		//mysql_query("update krs set Sesi='$ssi' where NIM='$nim' and Tahun='$thn'");// Tambahan 2007

	 	$data = array("NIM"=>$nim, "Tahun"=>$thn, "MaxSKS"=>$maxsks, "Sesi"=>$ssi);

		$update = $this->ipk_model->updateKhs($data);

		if($update){
	 		$msg = "Data berhasil diubah";
	 	}else{
	 		$msg = "Data gagal dirubah";
	 	}

		$displayIpk = $this->GoRekapKHS($nim);

		$dataIpk = array(
			'message' => $msg,
			'displayIpk' => $displayIpk
		);
		echo json_encode($dataIpk);
	}

	public function RefreshCuti(){
		$thn = $this->input->post('thn');
		$nim = $this->input->post('nim');
		$cuti = $this->input->post('cuti');
		if($cuti=='Cuti')$stn = 'C';
		else if($cuti=='Aktifkan')$stn = 'A';
		
		$data = array("Status"=>$stn, "NIM"=>$nim, "Tahun"=>$thn);

		$update = $this->ipk_model->updateKhsCuti($data);
		$update1 = $this->ipk_model->updateMhsCuti($data);

		if($update){
	 		$msg = "Data berhasil diubah";
	 	}else{
	 		$msg = "Data gagal dirubah";
	 	}

		$displayIpk = $this->GoRekapKHS($nim);

		$dataIpk = array(
			'message' => $msg,
			'displayIpk' => $displayIpk
		);
		echo json_encode($dataIpk);
	}

	public function RefreshUnregist(){
		$thn = $this->input->post('thn');
		$nim = $this->input->post('nim');
		$unregist = $this->input->post('unregist');
		if($unregist=='Unregist')$stn = 'U';
		else if($unregist=='Aktifkan')$stn = 'A';
		
		$data = array("Status"=>$stn, "NIM"=>$nim, "Tahun"=>$thn);

		$update = $this->ipk_model->updateKhsUnregist($data);

		if($update){
	 		$msg = "Data berhasil diubah";
	 	}else{
	 		$msg = "Data gagal dirubah";
	 	}

		$displayIpk = $this->GoRekapKHS($nim);

		$dataIpk = array(
			'message' => $msg,
			'displayIpk' => $displayIpk
		);
		echo json_encode($dataIpk);
	}

	public function RefreshMaxSks2(){
		$tahun = $this->input->post('thn');
		$nim = $this->input->post('nim');
		$thnc = $tahun;
		
		if(substr($tahun,4,1)==2){
			$tahun=$tahun-1;
		}else if(substr($tahun,4,1)==1){
			$tahun = $tahun-9;
		}

		$qw = $this->ipk_model->getMaxSKS2($tahun,$nim);
		
		if($qw==false){
			$maxsks = 0;
		}else{
			$maxsks = $qw->MaxSKS2;
		}

		$qwu = $this->ipk_model->updateMaxSks($maxsks,$nim,$thnc);

		if($qwu){
	 		$msg = "PRC SKS MAX berhasil";
	 	}else{
	 		$msg = "PRC SKS MAX gagal";
	 	}

		$displayIpk = $this->GoRekapKHS($nim);

		$dataIpk = array(
			'message' => $msg,
			'displayIpk' => $displayIpk
		);
		echo json_encode($dataIpk);
	}

	public function prosesIps() {
		$thn = $this->input->post('thn');
		$nim = $this->input->post('nim');
		$kdf = $this->input->post('kdf');
		$kdj = $this->input->post('kdj');

		$tbl="_v2_krs".$thn;

		//$qKhs = $this->ipk_model->getKhsPeriode($nim);

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
					if(($show1->NamaMK=="Seminar" || $show1->NamaMK=="Seminar Proposal" || $show1->NamaMK=="Praktik Lapangan (Magang)" || $show1->NamaMK=="Skripsi" || $show1->NamaMK=="Ko-Kurikuler" || $show1->NamaMK=="Kuliah Kerja Profesi (KKP) / KKN") && $show1->Bobot==0){ 
					}else{ 
						$TNK += $NK;
						$TSKS += $show1->SKS;
						if($bobot>0) $TSKSLulus += $show1->SKS;
					}
			
				}
			}

			//echo $TSKSLulus;
		//}
	
		/*$qKrs = $this->ipk_model->getDataKrs($nim,$thn,$tbl);
	
		$n = 0;
		$TSKS = 0; $TNK = 0;
		$TSKSLulus = 0;
		foreach ($qKrs as $show) {
			$n++;

			$bobot = 0;

			$bobot = $show->Bobot;

			//$bobot = str_replace('.',',',$bobot);

			$NK = $bobot * $show->SKS;
			//echo "===$bobot-$NK-=="; 
			if($show->GradeNilai=="A"||$show->GradeNilai=="A-" ||$show->GradeNilai=="B+" ||$show->GradeNilai=="B" ||$show->GradeNilai=="B-"||$show->GradeNilai=="C+" ||$show->GradeNilai=="C"||$show->GradeNilai=="C-"||$show->GradeNilai=="D"||$show->GradeNilai=="E"||$show->GradeNilai=="K"||$show->GradeNilai=="T" ||$show->GradeNilai=="" ||$show->GradeNilai==" "){
				if(($show->NamaMK=="Seminar Proposal" || $show->NamaMK=="Praktik Lapangan (Magang)" || $show->NamaMK=="Skripsi" || $show->NamaMK=="Ko-Kurikuler" || $show->NamaMK=="Kuliah Kerja Profesi (KKP) / KKN") && $show->Bobot==0){ 
				}else{ 
					$TNK += $NK;
					$TSKS += $show->SKS;
					if($bobot>0) $TSKSLulus += $show->SKS;
				}
			}
		}*/

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

		$displayIpk = $this->GoRekapKHS($nim);

		$dataIpk = array(
			'message' => $msg,
			'displayIpk' => $displayIpk
		);
		echo json_encode($dataIpk);

	}

	public function prosesipk() {
		$thn = $this->input->post('thn');
		$nim = $this->input->post('nim');
		$kdf = $this->input->post('kdf');
		$kdj = $this->input->post('kdj');


		//$qw = "select Min(GradeNilai),SKS,Max(Bobot) from krs$kdf where NIM='$nim' and Tahun<='$thn' and GradeNilai!='K' and NotActive='N' group by NamaMK;";

		$qAngkatan = $this->ipk_model->getMhswTahunAkademik($nim);
		$angkatan = $qAngkatan->TahunAkademik;
		$ang = substr($thn,0,4);
		$semesterAwal = 0;
		if($angkatan==$ang){
			$semesterAwal = 1;
			//$qw = "select GradeNilai,SKS,Bobot from krs$kdf where NIM='$nim' and Tahun<='$thn' and NotActive='N' group by NamaMK;";
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

		/*while($row=mysql_fetch_row($hasil)){
			$bobot = $row[2];

			if($row[0]=="A" || $row[0]=="B" || $row[0]=="C" || $row[0]=="D" || $row[0]=="E" || $row[0]=="A-" || $row[0]=="B+" || $row[0]=="B-" || $row[0]=="C+"|| $row[0]=="C-"|| $row[0]=="K" || $row[0]=="T" || $row[0]=="" || $row[0]==" ") {

				if(($w['NamaMK']=="Seminar Proposal" || $w['NamaMK']=="Praktik Lapangan (Magang)" || $w['NamaMK']=="Skripsi" || $w['NamaMK']=="Ko-Kurikuler" || $w['NamaMK']=="Kuliah Kerja Profesi (KKP) / KKN") && $w['Bobot']==0) { 
				}else{ 
					$TotSKS +=$row[1];
					$TotNil +=$row[2]*$row[1];
					$bobot = $row[2];
					if($bobot>0){ 
						$TotSKSLulus+=$row[1];
					}
				}
			}
		}*/
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
	 		$msg = "PRC IPK berhasil ".$TotIPK;
	 	}else{
	 		$msg = "PRC IPK gagal";
	 	}

		$displayIpk = $this->GoRekapKHS($nim);

		$dataIpk = array(
			'message' => $msg,
			'displayIpk' => $displayIpk
		);
		echo json_encode($dataIpk);
	}

	public function hapusIpk(){
		$KHSId = $this->input->post('KHSId');
		$nim = $this->input->post('nim');
		$thn = $this->input->post('thn');

		$deleteIPK = $this->ipk_model->deleteIpk($KHSId,$nim,$thn);
		
		if($deleteIPK){
			$msg = "Data Berhasil dihapus";
		}else{
			$msg = "Data gagal dihapus";
		}

		$dataDelete = array(
			'message' => $msg,
			'id' => $KHSId
		);
		echo json_encode($dataDelete);
	}

	public function tesprosesipk() {
		$thn = '20182';
		$nim = 'N20115038';
		$kdf = 'P';
		$kdj = 'P101';


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

		$qKhs = $this->ipk_model->getKhsPeriode($nim);	

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
						echo $tabel." - ".$show->nSks." - ".$show->bbt*$show->nSks." - ";
						$TotSKS +=$show->nSks;
						$TotNil +=$show->bbt*$show->nSks;
						$bobot = $show->bbt;
						if($bobot>0){ 
							$TotSKSLulus+=$show->nSks;
							echo $show->nSks;
						}
						echo "<br><br>";
				}
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

		print_r($data);

		/*$qwupdtkhsipk = $this->ipk_model->updateKhsIPK($data);

		$qwupdtkhsipkmhsw = $this->ipk_model->updateIpkMhsw($TotSKS,$TotIPK,$nim);

		if($qwupdtkhsipk){
	 		$msg = "PRC IPK berhasil ".$TotIPK;
	 	}else{
	 		$msg = "PRC IPK gagal";
	 	}

		$displayIpk = $this->GoRekapKHS($nim);*/

		/*$dataIpk = array(
			'message' => $msg,
			'displayIpk' => $displayIpk
		);
		echo json_encode($dataIpk);*/
	}


	public function prcIpsAll() {
		$nim = $this->input->post('nim');
		
		$qGetKhsTahun = $this->ipk_model->getKhs($nim);

		foreach ($qGetKhsTahun as $show) {
			$tbl="_v2_krs".$show->Tahun;

			$n = 0;
			$TSKS = 0; $TNK = 0;
			$TSKSLulus = 0;
			
			$tabel = "_v2_krs".$show->Tahun;

			$qKrs = $this->ipk_model->getDataKrsPeriode($nim,$show->Tahun,$tabel);

			foreach ($qKrs as $show1) {
				$n++;

				$bobot = 0;

				$bobot = $show1->Bobot;

				//$bobot = str_replace('.',',',$bobot);

				$NK = $bobot * $show1->SKS;
				//echo "===$bobot-$NK-=="; 
				if($show1->GradeNilai=="A"||$show1->GradeNilai=="A-" ||$show1->GradeNilai=="B+" ||$show1->GradeNilai=="B" ||$show1->GradeNilai=="B-"||$show1->GradeNilai=="C+" ||$show1->GradeNilai=="C"||$show1->GradeNilai=="C-"||$show1->GradeNilai=="D"||$show1->GradeNilai=="E"||$show1->GradeNilai=="K"||$show1->GradeNilai=="T" ||$show1->GradeNilai=="" ||$show1->GradeNilai==" "){
					if(($show1->NamaMK=="Seminar" ||$show1->NamaMK=="Seminar Proposal" || $show1->NamaMK=="Praktik Lapangan (Magang)" || $show1->NamaMK=="Skripsi" || $show1->NamaMK=="Ko-Kurikuler" || $show1->NamaMK=="Kuliah Kerja Profesi (KKP) / KKN") && $show1->Bobot==0){ 
					}else{ 
						$TNK += $NK;
						$TSKS += $show1->SKS;
						if($bobot>0) $TSKSLulus += $show1->SKS;
					}
				}
			}

			if ($TSKS == 0) $IPS = 0;
			else $IPS = number_format($TNK/$TSKS, 2, ',', '.');

			$IPS = str_replace(',','.',$IPS);

			$qwsks = $this->ipk_model->getMaxSksMax($IPS,$nim);

			$maxsks = $qwsks->SKSMax;

			$data = array("IPS"=>$IPS, "SKSLulus"=>$TSKSLulus, "SKS"=>$TSKS, "MaxSKS2"=>$maxsks, "NIM"=>$nim, "Tahun"=>$show->Tahun);

			$qwupdtkhs = $this->ipk_model->updateKhsMax($data);

			if($qwupdtkhs){
		 		$msg = "PRC IPS berhasil";
		 	}else{
		 		$msg = "PRC IPS gagal";
		 	}

		}

		$displayIpk = $this->GoRekapKHS($nim);

		$dataIpk = array(
			'message' => $msg,
			'displayIpk' => $displayIpk
		);

		echo json_encode($dataIpk);
	}

	public function prcIpkAll() {
		$nim = $this->input->post('nim');
		
		$qGetKhsTahun = $this->ipk_model->getKhs($nim);
		$qPeriodeAktif = $this->ipk_model->getPeriodeAktif();

		foreach ($qGetKhsTahun as $show) {
			$TotSKS=0;
			$TotSKSLulus=0;
			$TotNil=0;

			if($qPeriodeAktif->periode_aktif!=$show->Tahun){
				$qGetThisKhsTahun = $this->ipk_model->getKhsThis($nim,$show->Tahun);
				$i=0;
				$ips = 0;
				foreach ($qGetThisKhsTahun as $show1) {
					//echo $show1->IPS;
					$ips = $ips +$show1->IPS;
					$periode = substr($show1->Tahun, 4, 1);
					//echo $periode;
					if($periode!='3' OR $periode!='4'){
						$i++;
					}
					if($show1->GdNilai=="A" || $show1->GdNilai=="B" || $show1->GdNilai=="C" || $show1->GdNilai=="D" || $show1->GdNilai=="E" || $show1->GdNilai=="A-" || $show1->GdNilai=="B+" || $show1->GdNilai=="B-" || $show1->GdNilai=="C+"|| $show1->GdNilai=="C-"|| $show1->GdNilai=="K" || $show1->GdNilai=="T" || $show1->GdNilai=="" || $show1->GdNilai==" ") {
							$TotSKS +=$show1->SKS;
							$bobot = $show1->bbt;
							if($bobot>0){ 
								$TotSKSLulus+=$show1->SKS;
							}
					}
				}

				$ipk = $ips/$i;		
				//echo $periode;
				//echo $show->Tahun." ".$ipk." ".$i." <br>";

				$qw = $this->ipk_model->getKrsFakTR($nim);
				
				foreach ($qw as $show2) {
					$bobot = $show2->bbt;

					if($show2->GdNilai=="A" || $show2->GdNilai=="B" || $show2->GdNilai=="C" || $show2->GdNilai=="D" || $show2->GdNilai=="E" || $show2->GdNilai=="A-" || $show2->GdNilai=="B+" || $show2->GdNilai=="B-" || $show2->GdNilai=="C+"|| $show2->GdNilai=="C-"|| $show2->GdNilai=="K" || $show2->GdNilai=="T" || $show2->GdNilai=="" || $show2->GdNilai==" ") {
							$TotSKS +=$show2->nSks;
							$TotNil +=$show2->bbt*$show2->nSks;
							$bobot = $show2->bbt;
							if($bobot>0){ 
								$TotSKSLulus+=$show2->nSks;
							}
					}
				}

				if($TotNil>0 or $TotSKS>0){
					$TotIPK = round($TotNil/$TotSKS,2);
					$TotIPK = number_format($TotNil/$TotSKS, 2, ',', '.');

					$TotIPK = str_replace(',','.',$TotIPK);
				}else{
					$TotIPK = 0;
				}
				
				$TotIPK = $ipk + $TotIPK;

				$tgl = date('d-m-Y');

				$data = array("IPK"=>$TotIPK, "TotalSKS"=>$TotSKS, "TotalSKSLulus"=>$TotSKSLulus, "NIM"=>$nim, "Tahun"=>$show->Tahun);

				$qwupdtkhsipk = $this->ipk_model->updateKhsIPK($data);

				$qwupdtkhsipkmhsw = $this->ipk_model->updateIpkMhsw($TotSKS,$TotIPK,$nim,$TotSKSLulus);

				if($qwupdtkhsipk){
			 		$msg = "PRC IPK berhasil";
			 	}else{
			 		$msg = "PRC IPK gagal";
			 	}
			}	
		}

		$displayIpk = $this->GoRekapKHS($nim);

		$dataIpk = array(
			'message' => $msg,
			'displayIpk' => $displayIpk
		);
		
		echo json_encode($dataIpk);
	}
}