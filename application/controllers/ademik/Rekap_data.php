<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_data extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->library('datatables');
	    $this->load->model('rekap_model');
		date_default_timezone_set("Asia/Makassar");
	}

	public function index(){
		//echo "fandu 12344 fandu ini<br>";
		//echo $this->uri->segment(4);
	// cara pertama
			/*$content = $this->session->userdata('sess_tamplate');
			$this->load->view('temp/head');
			$this->load->view($content);
			$this->load->view('temp/footers');*/
	
	// cara kedua
		$a['tab'] = $this->app->all_val('groupmodul')->result();
		$this->load->view('dashbord',$a);
		
	// cara ke tiga
		//$this->load->view('dashbord');
	}



	public function detail_jumlah_mhsw($fak){
		$i = 1;
		$total = 0;
		$dataBody = '';
		$sum = 0;
		$s1 = 0;
		$s2 = 0;
		$s3 = 0;
		$s4 = 0;
		$s5 = 0;
		$s6 = 0;
		$s7 = 0;
		$s8 = 0;
		$s9 = 0;
		$s10 = 0;
		$sp1 = 0;
		$sp2 = 0;
		$sp3 = 0;
		$sp4 = 0;
		$sp5 = 0;
		$sp6 = 0;
		$sp7 = 0;
		$sp8 = 0;
		$sp9 = 0;
		$sp10 = 0;
		$datatable = $this->rekap_model->getDetailRekap($fak);
		foreach ($datatable as $show) {
			$body = "<tr>
				<td width=10>".$i."</td>
				<td width=350>".$show->Nama_Indonesia."</a></td>
				<td width=70>".$show->jml."</td>
				<td width=70>".$show->j4."</td>
				<td width=70>".$show->jp4."</td>
				<td width=70>".$show->j5."</td>
				<td width=70>".$show->jp5."</td>
				<td width=70>".$show->j6."</td>
				<td width=70>".$show->jp6."</td>
				<td width=70>".$show->j7."</td>
				<td width=70>".$show->jp7."</td>
				<td width=70>".$show->j8."</td>
				<td width=70>".$show->jp8."</td>
				<td width=70>".$show->j1."</td>
				<td width=70>".$show->jp1."</td>
				<td width=70>".$show->j9."</td>
				<td width=70>".$show->jp9."</td>
				<td width=70>".$show->j10."</td>
				<td width=70>".$show->jp10."</td>
			</tr>";

			$sum = $sum + $show->jml;
			$s1 = $s1 + $show->j1;
			$s2 = $s2 + $show->j2;
			//$s3 = $s3 + $show->j3;
			$s4 = $s4 + $show->j4;
			$s5 = $s5 + $show->j5;
			$s6 = $s6 + $show->j6;
			$s7 = $s7 + $show->j7;
			$s8 = $s8 + $show->j8;
			$s9 = $s9 + $show->j9;
			$s10 = $s10 + $show->j10;

			$sp1 = $sp1 + $show->jp1;
			$sp2 = $sp2 + $show->jp2;
			//$sp3 = $sp3 + $show->jp3;
			$sp4 = $sp4 + $show->jp4;
			$sp5 = $sp5 + $show->jp5;
			$sp6 = $sp6 + $show->jp6;
			$sp7 = $sp7 + $show->jp7;
			$sp8 = $sp8 + $show->jp8;
			$sp9 = $sp9 + $show->jp9;
			$sp10 = $sp10 + $show->jp10;

			$dataBody = $dataBody.$body;

			$i++;
		}
		$foot = "
			</tbody>
			<tfoot>
				<tr>
					<td colspan=2><b>J U M L A H</b></td>
					<td><b>$sum</b></td>
					<td><b>$s4</b></td>
					<td><b>$sp4</b></td>
					<td><b>$s5</b></td>
					<td><b>$sp5</b></td>
					<td><b>$s6</b></td>
					<td><b>$sp6</b></td>
					<td><b>$s7</b></td>
					<td><b>$sp7</b></td>
					<td><b>$s8</b></td>
					<td><b>$sp8</b></td>
					<td><b>$s1</b></td>
					<td><b>$sp1</b></td>
					<td><b>$s9</b></td>
					<td><b>$sp9</b></td>
					<td><b>$s10</b></td>
					<td><b>$sp10</b></td>					
				</tr>
			</tfoot>
		";

		$dataBody = $dataBody.$foot;
		$send['body'] = $dataBody;
		$this->load->view('temp/head');
		$this->load->view('ademik/rekap/detail_jumlah_mahasiswa', $send);
		$this->load->view('temp/footers');
	}

	public function rekapFeeder(){
		$this->load->view('temp/head');
		$this->load->view('ademik/rekap/rekap_feeder');
		$this->load->view('temp/footers');
	}

	public function rekapFeederJur($thn,$kdf){
		$data['tahun'] = $thn;
		$data['dataTable'] = $this->rekap_model->getRekapFeederBelumJur($thn,$kdf);
		$data['dataTable2'] = $this->rekap_model->getRekapFeederSudahJur($thn,$kdf);
		$data['footerSection'] = "<script type='text/javascript'> 
            $(document).ready(function() {
                //datatables
                $('#table_feeder').DataTable();
                $('#table_feeder2').DataTable();
			});
        </script>"; 
		$this->load->view('temp/head');
		$this->load->view('ademik/rekap/rekap_feederJur',$data);
		$this->load->view('temp/footers',$data);
	}

	public function rekapFeederMhsw($thn,$kdj){
		$data['tahun'] = $thn;
		$data['dataTable'] = $this->rekap_model->getRekapFeederBelumMhsw($thn,$kdj);
		$data['dataTable2'] = $this->rekap_model->getRekapFeederSudahMhsw($thn,$kdj);
		$data['footerSection'] = "<script type='text/javascript'> 
            $(document).ready(function() {
                //datatables
                $('#table_feeder').DataTable();
                $('#table_feeder2').DataTable();
			});
        </script>"; 
		$this->load->view('temp/head');
		$this->load->view('ademik/rekap/rekap_feederMhsw',$data);
		$this->load->view('temp/footers',$data);
	}

	public function searchFeeder(){
		$thn=$this->input->post('semesterAkademik');
		$data['tahun'] = $thn;
		$data['dataTable'] = $this->rekap_model->getRekapFeederBelum($thn);
		$data['dataTable2'] = $this->rekap_model->getRekapFeederSudah($thn);
		$data['footerSection'] = "<script type='text/javascript'> 
            $(document).ready(function() {
                //datatables
                $('#table_feeder').DataTable();
                $('#table_feeder2').DataTable();
			});
        </script>"; 
		$this->load->view('temp/head');
		$this->load->view('ademik/rekap/rekap_feeder',$data);
		$this->load->view('temp/footers',$data);
	}

	public function rekapJumlahMahasiswa(){
		$fk=array("A","B","C","D","E","F","G","L","N","O","P","K2M","K2T","H"); 
		$i = 1;
		$total = 0;
		$dataBody = '';
		$sum = 0;
		$s1 = 0;
		$s2 = 0;
		$s3 = 0;
		$s4 = 0;
		$s5 = 0;
		$s6 = 0;
		$s7 = 0;
		$s8 = 0;
		$s9 = 0;
		$sp1 = 0;
		$sp2 = 0;
		$sp3 = 0;
		$sp4 = 0;
		$sp5 = 0;
		$sp6 = 0;
		$sp7 = 0;
		$sp8 = 0;
		$sp9 = 0;
		for($j=0;$j<=13;$j++){
			$data = $this->rekap_model->getRekapJmlMhs($fk[$j]);
			$body = "<tr>
				<td width=10>".$i."</td>
				<td width=350><a href='".base_url('ademik/rekap_data/detail_jumlah_mhsw/').$data->Kode."'>".$data->Singkatan."</a></td>
				<td width=70>".$data->jml."</td>
				<td width=70>".$data->j4."</td>
				<td width=70>".$data->jp4."</td>
				<td width=70>".$data->j5."</td>
				<td width=70>".$data->jp5."</td>
				<td width=70>".$data->j6."</td>
				<td width=70>".$data->jp6."</td>
				<td width=70>".$data->j7."</td>
				<td width=70>".$data->jp7."</td>
				<td width=70>".$data->j8."</td>
				<td width=70>".$data->jp8."</td>
				<td width=70>".$data->j1."</td>
				<td width=70>".$data->jp1."</td>
				<td width=70>".$data->j2."</td>
				<td width=70>".$data->jp2."</td>
				<td width=70>".$data->j9."</td>
				<td width=70>".$data->jp9."</td>
			</tr>";

			$sum = $sum + $data->jml;
			$s1 = $s1 + $data->j1;
			$s2 = $s2 + $data->j2;
			//$s3 = $s3 + $data->j3;
			$s4 = $s4 + $data->j4;
			$s5 = $s5 + $data->j5;
			$s6 = $s6 + $data->j6;
			$s7 = $s7 + $data->j7;
			$s8 = $s8 + $data->j8;
			$s9 = $s9 + $data->j9;

			$sp1 = $sp1 + $data->jp1;
			$sp2 = $sp2 + $data->jp2;
			//$sp3 = $sp3 + $data->jp3;
			$sp4 = $sp4 + $data->jp4;
			$sp5 = $sp5 + $data->jp5;
			$sp6 = $sp6 + $data->jp6;
			$sp7 = $sp7 + $data->jp7;
			$sp8 = $sp8 + $data->jp8;
			$sp9 = $sp9 + $data->jp9;

			$dataBody = $dataBody.$body;

			$i++;
		}
		$foot = "
			</tbody>
			<tfoot>
				<tr>
					<td colspan=2><b>J U M L A H</b></td>
					<td><b>$sum</b></td>
					<td><b>$s4</b></td>
					<td><b>$sp4</b></td>
					<td><b>$s5</b></td>
					<td><b>$sp5</b></td>
					<td><b>$s6</b></td>
					<td><b>$sp6</b></td>
					<td><b>$s7</b></td>
					<td><b>$sp7</b></td>
					<td><b>$s8</b></td>
					<td><b>$sp8</b></td>
					<td><b>$s1</b></td>
					<td><b>$sp1</b></td>
					<td><b>$s2</b></td>
					<td><b>$sp2</b></td>
					<td><b>$s9</b></td>
					<td><b>$sp9</b></td>					
				</tr>
			</tfoot>
		";

		$dataBody = $dataBody.$foot;
		$send['body'] = $dataBody;
		$this->load->view('temp/head');
		$this->load->view('ademik/rekap/rekap_jumlah_mahasiswa', $send);
		$this->load->view('temp/footers');
	}

	public function detailRekapAktifBayar($fak){
		$dataTahun= $this->rekap_model->getTahun8();
		$dataRowTahun = $this->rekap_model->getRowTahun8();
		$dataRekap = $this->rekap_model->getRekapMhsAktifJurusan($fak); 
		$i = 1;
		$total = 0;
		$dataBody = '';
		$sum = 0;
		error_reporting(E_ALL ^ E_NOTICE);
		foreach($dataRekap as $data) {
			$tahunTerakhir = $dataRowTahun->TahunAkademik - 7;
			$data1 = $this->rekap_model->getJmlMhsAktifJurusan($data->Kode,$tahunTerakhir);
			$body = "<tr>
				<td width=10>".$i."</td>
				<td width=350>".$data->Nama_Indonesia."</td>
				<td width=70>".$data1->jml."</td>";
			
			foreach($dataTahun as $showTahun){
				$dataPerempuan = $this->rekap_model->getMhswPJurusan($data->Kode,$tahunTerakhir,$showTahun->TahunAkademik);
				$dataCampur = $this->rekap_model->getMhswLPJurusan($data->Kode,$tahunTerakhir,$showTahun->TahunAkademik);
				$body = $body."<td><a href='".base_url('ademik/rekap_data/detailRekapAktifBayarMhsw/').$data->Kode."/".$showTahun->TahunAkademik."/p'>".$dataPerempuan->jp."</a></td>";
				$body = $body."<td><a href='".base_url('ademik/rekap_data/detailRekapAktifBayarMhsw/').$data->Kode."/".$showTahun->TahunAkademik."/lp'>".$dataCampur->j."</a></td>";

				$sp[$showTahun->TahunAkademik] = $sp[$showTahun->TahunAkademik]+$dataPerempuan->jp;
				$s[$showTahun->TahunAkademik]= $s[$showTahun->TahunAkademik]+$dataCampur->j;
			}

			$body = $body."</tr>";

			$dataBody = $dataBody.$body;
			$sum=$sum+$data1->jml;


			$i++;
		}
		$foot = "
			</tbody>
			<tfoot>
				<tr>
					<td colspan=2><b>J U M L A H</b></td>
					<td><b>$sum</b></td>";
					
		foreach($dataTahun as $showTahun){
			$foot = $foot."<td><b>".$sp[$showTahun->TahunAkademik]."</b></td>
							<td><b>".$s[$showTahun->TahunAkademik]."</b></td>";				
		}
		$foot = $foot."</tr>
			</tfoot>
		";

		$dataBody = $dataBody.$foot;
		$send['body'] = $dataBody;
		$send['dataTahun'] = $dataTahun;
		$this->load->view('temp/head');
		$this->load->view('ademik/rekap/detail_aktif_bayar', $send);
		$this->load->view('temp/footers');
	}

	public function detailRekapAktifBayarMhsw($jur, $tahun, $jk) {
		$dataRekap = $this->rekap_model->getMhsw($jur, $tahun, $jk);
		$i = 1;
		$dataBody = '';
		foreach($dataRekap as $data) {
			$status = 'Belum bayar';
			if($data->StatusBayar=='1'){
				$status = 'Sudah bayar';
			}
			$body = "<tr>
				<td width=10>".$i."</td>
				<td>".$data->NIM."</td>
				<td>".$data->Name."</td>
				<td>".$data->TahunAkademik."</td>
				<td>".$status."</td></tr>";
			
			$dataBody = $dataBody.$body;

			$i++;
		}

		$send['body'] = $dataBody;
		$this->load->view('temp/head');
		$this->load->view('ademik/rekap/detail_rekap_bayar_mahasiswa', $send);
		$this->load->view('temp/footers');
	} 

	public function rekapAktifBayar(){
		$dataTahun= $this->rekap_model->getTahun8();
		$dataRowTahun = $this->rekap_model->getRowTahun8();
		$fk=array("A","B","C","D","E","F","G","L","N","O","P","K2M","K2T","H"); 
		$i = 1;
		$total = 0;
		$dataBody = '';
		$sum = 0;
		error_reporting(E_ALL ^ E_NOTICE);
		for($j=0;$j<=13;$j++){
			$data = $this->rekap_model->getRekapMhsAktif($fk[$j]);
			$tahunTerakhir = $dataRowTahun->TahunAkademik - 7;
			$data1 = $this->rekap_model->getJmlMhsAktif($fk[$j],$tahunTerakhir);
			$body = "<tr>
				<td width=10>".$i."</td>
				<td width=350><a href='".base_url('ademik/rekap_data/detailRekapAktifBayar/').$data->Kode."'>".$data->Singkatan."</a></td>
				<td width=70>".$data1->jml."</td>";
			
			foreach($dataTahun as $showTahun){
				$dataPerempuan = $this->rekap_model->getMhswP($fk[$j],$tahunTerakhir,$showTahun->TahunAkademik);
				$dataCampur = $this->rekap_model->getMhswLP($fk[$j],$tahunTerakhir,$showTahun->TahunAkademik);
				$body = $body."<td>".$dataPerempuan->jp."</td>";
				$body = $body."<td>".$dataCampur->j."</td>";

				$sp[$showTahun->TahunAkademik] = $sp[$showTahun->TahunAkademik]+$dataPerempuan->jp;
				$s[$showTahun->TahunAkademik]= $s[$showTahun->TahunAkademik]+$dataCampur->j;
			}

			$body = $body."</tr>";

			$dataBody = $dataBody.$body;
			$sum=$sum+$data1->jml;


			$i++;
		}
		$foot = "
			</tbody>
			<tfoot>
				<tr>
					<td colspan=2><b>J U M L A H</b></td>
					<td><b>$sum</b></td>";
					
		foreach($dataTahun as $showTahun){
			$foot = $foot."<td><b>".$sp[$showTahun->TahunAkademik]."</b></td>
							<td><b>".$s[$showTahun->TahunAkademik]."</b></td>";				
		}
		$foot = $foot."</tr>
			</tfoot>
		";

		$dataBody = $dataBody.$foot;
		$send['body'] = $dataBody;
		$send['dataTahun'] = $dataTahun;
		$this->load->view('temp/head');
		$this->load->view('ademik/rekap/rekap_aktif_bayar', $send);
		$this->load->view('temp/footers');
	}


	public function RekapPelaksanaanKuliah(){

		$this->load->view('temp/head');
		$this->load->view('ademik/rekap/rekap_pelaksanaan_kuliah');
		$this->load->view('temp/footers');
	}

	public function RangkumanIpk(){

		$this->load->view('temp/head');
		$this->load->view('ademik/rangkuman_ipk');
		$this->load->view('temp/footers');
	}
}