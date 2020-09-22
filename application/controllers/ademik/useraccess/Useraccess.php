<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class useraccess extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->model('ipk_model');
		date_default_timezone_set("Asia/Makassar");
	}

	public function index(){
		//echo "fandu 12344 fandu ini<br>";
		//echo $this->uri->segment(4);
	// cara pertama
		//	$content = $this->session->userdata('sess_tamplate');
		//	$this->load->view('temp/head');
		//	$this->load->view($content);
		//	$this->load->view('temp/footers');
	
	// cara kedua
		//$a['tab'] = $this->app->all_val('groupmodul')->result();
		//$this->load->view('dashbord',$a);
		
	// cara ke tiga
		//$this->load->view('dashbord');
	}

	public function adminpage(){ // nama controllernya adminpage harus sama dengan nama viewnya untuk memudahkan
		$content = "ademik/useraccess/useraccess/adminpage";
		$this->load->view('temp/head');
		$this->load->view($content);
		$this->load->view('temp/footers');
		//echo "123";
		//$a['tab'] = $this->app->all_val('groupmodul')->result();
		//$this->load->view('dashbord',$a);
	}
	
	public function adminmahasiswa() { // nama controllernya adminmahasiswa harus sama dengan nama viewnya untuk memudahkan
		$content = "ademik/useraccess/useraccess/adminmahasiswa";
		$this->load->view('temp/head');
		$this->load->view($content);
		$this->load->view('temp/footers');
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
		$ipk = $this->GoIPK($nim);

		return $rekapKhs.$ipk;
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
					<th style='text-alignment:center; font-weight:bold;'>Juml.<br>MK</th>
					<th style='text-alignment:center; font-weight:bold;'>Juml.<br>SKS</th>
					<th style='text-alignment:center; font-weight:bold;'>IPS</th>
					<th style='text-alignment:center; font-weight:bold;'>AKSI</th>
				</tr>
		";

		$getDataKhs = $this->ipk_model->getDataKhs($nim);

		$tableContent = '';
		$uniqueId=0;
		foreach ($getDataKhs as $show) {
			$thn = $show->Tahun;
			$KHSId = $show->KHSId;
			$ssi = $show->Sesi;
			$sta = $show->Status;

			$nil = $show->Nilai;
			$grd = $show->GradeNilai;
			$bbt = $show->Bobot;
			$_bbt = number_format($bbt, 2, ',', '');
			$sks = $show->SKS;
			$jml = $show->JmlMK;
			$ips = number_format($show->IPS, 2, ',', '');
			$did = $show->DosenID;
			$maxsks = $show->MaxSKS;
			$sta = $show->STA;

			$ntbl = "Cuti";
			if($sta=='Cuti')  $ntbl = "Aktifkan";        

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
			
			if($ulevel==1) $StrLink="/<a href='ademik.php?syxec=mhswedtkhs&thn=$thn&nim=$nim&KhsId=$KHSId' title='Klik di sini untuk mengedit Tahun akademik'>Edit Thn</a>";
			else $StrLink='';
			//echo "<a href='ademik.php?syxec=mhswipk&KHSId=$KHSId&nim=$nim&thn=$thn&hapusKHS=1'><input type='button' value='hapus'></a>";
			$content = "<tr id='row_".$KHSId."'>
			<td align=center><a href='ademik.php?syxec=mhswkhs&thn=$thn&nim=$nim&StrBack=mhswipk'>$thn</a>$StrLink</td>
			$strssi
			<td align=center>$sta</td>
			<td align=center>$jml</td>
			<td align=center>$sks</td>

			<td align=center>$ips</td>      
			<td align=center>";
			//if($sta=='Aktif')  echo "<a href='ademik.php?syxec=mhswipk&nim=$nim&thn=$thn&refreshipk=refresh'><input type='button' value='Refresh Data'></a>";
			if($ulevel==1 || $ulevel==5 || $ulevel==7) {
				$btnCuti = "<button type='button' data-nim='$nim' data-thn='$thn' data-cuti='$ntbl' class='cuti'>$ntbl</button>";
			}else{
				$btnCuti = "";
			}
			if($ulevel==1 || $ulevel==5 || $ulevel==7 || $ulevel==4){  
				$btn = "
					<button type='button' data-nim='$nim' data-thn='$thn' data-kdf='$kdf' data-kdj='$kdj' class='sks_max'>Prc SKS Max</button>
					<button type='button' data-nim='$nim' data-thn='$thn' data-kdf='$kdf' data-kdj='$kdj' class='prc_ips'>Prc IPS</button>
					<button type='button' data-nim='$nim' data-thn='$thn' data-kdf='$kdf' data-kdj='$kdj' class='prc_ipk'>Prc IPK</button>
					<a href='print.php?print=ademik/rpt/cetakkhs.php&PerTahun=$thn&PerMhsw=$nim&ctkhdr=ctkhdr' target='_blank'><input type='button' value='Cetak KHS'></a>
					<button type='button' data-khsid='$KHSId' data-nim='$nim' data-thn='$thn' class='hps_ipk'>Hapus</button>
				";
			}else{
				$btn = "";
			}
			$closetd = "</td></tr>";

			$tableContent = $tableContent.$content.$btnCuti.$btn.$closetd;
			$uniqueId++;
		}
		$footer = "</table>
			</div>
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

	public function FormAddSesi($nim) {
		$qSsi = $this->ipk_model->getSesiMax($nim);
		$ssi = $qSsi->ssi+1;
		$qThnNext = $this->ipk_model->getTahunNextMax($nim);
		$ThnNext = $qThnNext->ThnNext+1;
		
		$kdf=substr("$nim",0,1);
		if($kdf=='C') $maxsks=24; //2007 , Sesuai permintaan Kedokteran
		else $maxsks = $this->getMaxSKSMhsw($nim);

		if($_SESSION['ulevel']==4){
			$form = "
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
			";
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
		return $form;
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
			$sesi = $sesiBobot->Sesi;
			$bbt = $sesiBobot->bbt;
		}

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
			$update = $this->ipk_model->updateIpkMhsw($sks,$ipk,$nim);
			
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
				$qBea = $this->ipk_model->getKodeBiayaMhsw($nim);
				$bea = $qBea->KodeBiaya;				
			 	$data = array("NIM"=>$nim, "Tahun"=>$thn, "KodeBiaya"=>$bea, "Sesi"=>$ssi, "Status"=>"A", "MaxSKS"=>$sksmax);

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
		
		/*if($qw==false){
			$maxsks = 0;
		}else{*/
			$maxsks = $qw->MaxSKS2;
		//}

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

		if($thn=='20161') {
			$tbl="_v2_krs";
		}else{
			$tbl="_v2_krs".$thn;
		}

		$qKhs = $this->ipk_model->getKhsPeriode($nim);

		$n = 0;
		$TSKS = 0; $TNK = 0;
		$TSKSLulus = 0;
		foreach ($qKhs as $show) {
			$tabel = '';
			if($show->Tahun=='20161'){
				$tabel = '_v2_krs';
			}else{
				$tabel = '_v2_krs'.$show->Tahun;
			}

			$qKrs = $this->ipk_model->getDataKrsPeriode($nim,$thn,$tabel);

			foreach ($qKrs as $show1) {
				$n++;

				$bobot = 0;

				$bobot = $show1->Bobot;

				//$bobot = str_replace('.',',',$bobot);

				$NK = $bobot * $show1->SKS;
				//echo "===$bobot-$NK-=="; 
				if($show1->GradeNilai=="A"||$show1->GradeNilai=="A-" ||$show1->GradeNilai=="B+" ||$show1->GradeNilai=="B" ||$show1->GradeNilai=="B-"||$show1->GradeNilai=="C+" ||$show1->GradeNilai=="C"||$show1->GradeNilai=="C-"||$show1->GradeNilai=="D"||$show1->GradeNilai=="E"||$show1->GradeNilai=="K"||$show1->GradeNilai=="T" ||$show1->GradeNilai=="" ||$show1->GradeNilai==" "){
					if(($show1->NamaMK=="Seminar Proposal" || $show1->NamaMK=="Praktik Lapangan (Magang)" || $show1->NamaMK=="Skripsi" || $show1->NamaMK=="Ko-Kurikuler" || $show1->NamaMK=="Kuliah Kerja Profesi (KKP) / KKN") && $show1->Bobot==0){ 
					}else{ 
						$TNK += $NK;
						$TSKS += $show1->SKS;
						if($bobot>0) $TSKSLulus += $show1->SKS;
					}
				}
			}
		}
	
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

		$qKhs = $this->ipk_model->getKhsPeriode($nim);	

		foreach ($qKhs as $show1) {
			$tabel = '';
			if($show1->Tahun=='20161'){
				$tabel = '_v2_krs';
			}else{
				$tabel = '_v2_krs'.$show1->Tahun;
			}
			if($semesterAwal==0){
				$qw = $this->ipk_model->getKrsFak($kdf,$nim, $thn, $tabel);
			}else{
				$qw = $this->ipk_model->getKrsFakSama($kdf,$nim, $thn, $tabel);
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

		$TotIPK = round($TotNil/$TotSKS,2);
		$TotIPK = number_format($TotNil/$TotSKS, 2, ',', '.');

		$TotIPK = str_replace(',','.',$TotIPK);

		$tgl = date('d-m-Y');

		$data = array("IPK"=>$TotIPK, "TotalSKS"=>$TotSKS, "TotalSKSLulus"=>$TotSKSLulus, "NIM"=>$nim, "Tahun"=>$thn);

		$qwupdtkhsipk = $this->ipk_model->updateKhsIPK($data);

		if($qwupdtkhsipk){
	 		$msg = "PRC IPK berhasil";
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
}