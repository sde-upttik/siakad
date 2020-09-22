<?php
class Tools extends CI_Controller
{
  function __construct(){    
    parent::__construct();
    $this->db1 = $this->load->database('siakad',true);
    $this->load->helper('form');
    $this->load->helper('fikri');
    $this->app->checksession_ajax();
  }

  public function index()
  {
    echo "<h1>=:: mini tools Siakad2 ::=</h1>";
  }

  public function migrasiKrsMhs($nim='')
  {
    echo form_open("Tools/migrasiKrsMhs/");
  }
  public function migrasiKrs($krss= "fak")
  {
    echo form_open("Tools/migrasiKrs/$krss");
    if ($krss=='fak') {
      $this->v_selectFakultas($this->input->post('fakultas'));
    }elseif ($krss=='thn') {
      $this->v_selectTahun($this->input->post('tahun'));
    }
    $this->V_inputNim($this->input->post('nim'));
    $this->v_buttonGo();
    echo '<hr/>';

    if ($this->input->post()) {
      $fildkrs = " `ID`, `st_feeder`, `NIM`, `Tahun`, `SMT`, `Sesi`, `IDJadwal`, `IDPAKET`, `IDMK00`, `IDMK`, `KodeMK`, `NamaMK`,'' `NamaMK_Inggris`, `SKS`, `Status`, `Program`, `IDDosen`, `unip`, `Tanggal`, `hr_1`, `hr_2`, `hr_3`, `hr_4`, `hr_5`, `hr_6`, `hr_7`, `hr_8`, `hr_9`, `hr_10`, `hr_11`, `hr_12`, `hr_13`, `hr_14`, `hr_15`, `hr_16`, `hr_17`, `hr_18`, `hr_19`, `hr_20`, `hr_21`, `hr_22`, `hr_23`, `hr_24`, `hr_25`, `hr_26`, `hr_27`, `hr_28`, `hr_29`, `hr_30`, `hr_31`, `hr_32`, `hr_33`, `hr_34`, `hr_35`, `hr_36`, `jmlHadir`, `Hadir`, `Tugas1`, `Tugas2`, `Tugas3`, `Tugas4`, `Tugas5`, `NilaiPraktek`, `NilaiMID`, `NilaiUjian`, `Nilai`, `GradeNilai`, `Bobot`, `useredt`, `tgledt`, `rowedt`, `Tunda`, `AlasanTunda`, `Setara`, `MKSetara`, `KodeSetara`, `SKSSetara`, `GradeSetara`, 'N' `NotActive`,'N' `NotActive_KRS`, `NotActive`, `unipupd`, `angkatan`, `prckkn`";
      $kd_fak = $this->input->post('fakultas');
      $tahun = $this->input->post('tahun');
      if ($krss=='fak') {
        $tabel = 'krs'.$kd_fak;
        $where = array('pindah_siakad_baru' => '','NIM LIKE'=>"$kd_fak%",'Tahun >='=>'20101','Tahun ='=>'TR');
        $this->db1->where($where);
      }elseif ($krss=='thn') {
        $tabel = 'krs'.$tahun;
        // $where = array('pindah_siakad_baru' => '',);$this->db1->where($where);
      }
      // $tabel = 'krs'.$kd_fak;
      // $where = array('pindah_siakad_baru' => '','NIM LIKE'=>"$kd_fak%",'Tahun ='=>'TR');
             $this->db1->select($fildkrs);
             $this->db1->where_not_in("Tahun",['*',201,2011,2012,2013,2014,2015,2016,2017,2018,2019,2022,2041,2043,20155,'Tahun']);
            //  $this->db1->where($where);
      if ($this->input->post('nim')) {
        $nim = explode(',',$this->input->post('nim'));
            $this->db1->where_in('nim',$nim);
      }
                      // ->limit("500");
      $res = $this->db1->get($tabel);
      $krs= $res->result();
      // print_r($this->db1->last_query());
      // echo '<hr/>';
      // print_r($this->db->last_query());
      // echo '<hr/>';
      // print_r($krs);
      // die;
      $n =1;
      foreach ($krs as $mk) {
        $id = $mk->ID;
        $thn = str_replace('A','3',$mk->Tahun);
        $tbl = "_v2_krs$thn";
        $wheres = array(
          'NIM' => $mk->NIM,
          'IDJadwal'  =>$mk->IDJadwal,
          'IDMK'  =>$mk->IDMK,
          'KodeMK'  =>$mk->KodeMK,
          'SKS' =>$mk->SKS
        );
        
          $jmlah = $this->db->where($wheres)->get($tbl)->num_rows();
          // echo $n.'=> '.$jmlah.' ';
          if ($jmlah==0) {
            $data = $mk;
            $data->ID = '';
          echo $n.'=> '.$jmlah.' ';

            echo 'Tabel : '.$tbl.' ID : '. $id.' data :<br>';
            print_r($data);
            // $this->db->insert($tbl,$data);
          }else{
            echo 'data sdh ada.ID='.$id;
          }
          $set = array('pindah_siakad_baru'=>1);
          // $this->db1->where('ID',$id)->Update($tabel,$set);
          
        echo '<br>';
        $n++;
      }
      
    }

  }

  public function upNilai()
{
  echo form_open('Tools/upNilai');
  $this->v_selectFakultas($this->input->post('fakultas'));
  $this->v_buttonGo();
  echo '<hr/>';

  if ($this->input->post()) {
    // $fildkrs = " `ID`, `st_feeder`, `NIM`, `Tahun`, `SMT`, `Sesi`, `IDJadwal`, `IDPAKET`, `IDMK00`, `IDMK`, `KodeMK`, `NamaMK`,'' `NamaMK_Inggris`, `SKS`, `Status`, `Program`, `IDDosen`, `unip`, `Tanggal`, `hr_1`, `hr_2`, `hr_3`, `hr_4`, `hr_5`, `hr_6`, `hr_7`, `hr_8`, `hr_9`, `hr_10`, `hr_11`, `hr_12`, `hr_13`, `hr_14`, `hr_15`, `hr_16`, `hr_17`, `hr_18`, `hr_19`, `hr_20`, `hr_21`, `hr_22`, `hr_23`, `hr_24`, `hr_25`, `hr_26`, `hr_27`, `hr_28`, `hr_29`, `hr_30`, `hr_31`, `hr_32`, `hr_33`, `hr_34`, `hr_35`, `hr_36`, `jmlHadir`, `Hadir`, `Tugas1`, `Tugas2`, `Tugas3`, `Tugas4`, `Tugas5`, `NilaiPraktek`, `NilaiMID`, `NilaiUjian`, `Nilai`, `GradeNilai`, `Bobot`, `useredt`, `tgledt`, `rowedt`, `Tunda`, `AlasanTunda`, `Setara`, `MKSetara`, `KodeSetara`, `SKSSetara`, `GradeSetara`,`NotActive` `NotActive_KRS`, `NotActive`, `unipupd`, `angkatan`, `prckkn`";
    // $this->db->
    $tabel2  = '_v2_krs20191';
    $tabel1  = 'krsL';
    $where = array(
      'Nilai' => '0',
      'GradeNilai'  => null,
      'Bobot' => '0',
      'NIM LIKE' => $this->input->post('fakultas').'%'
    );
    
    $lst = $this->db->select("NIM,IDJadwal,Tahun")->where($where)->get($tabel2)->result_array();
    
    foreach ($lst as $mhs) {
      $hsl = $this->db1->select("NIM,IDJadwal,Tahun,Nilai, GradeNilai, Bobot")->get_where($tabel1,$mhs)->result_array();
      if (count($hsl)==1) {
        // $where=array(
        //   'NIM' => $hsl[0]['NIM'],
        //   'IDJadwal'  => $hsl[0]['IDJadwal'],
        //   'Tahun'  => $hsl[0]['Tahun']
        // );
        // $set = array(
        //   'Nilai' => $hsl[0]['Nilai'],
        //   'GradeNilai'  => $hsl[0]['GradeNilai'],
        //   'Bobot' => $hsl[0]['Bobot']
        // );
        // $this->db->set($set)->where($where)->update($tabel2);
        $data[] = $hsl[0];
      }else{
        $data[] = $hsl;
      }
    }
    print_r(json_encode($data));
  }
}

public function NamaMK_bi()
{
  echo form_open("Tools/NamaMK_bi");
  $this->V_inputNim($this->input->post('nim'));
  $this->v_buttonGo();
  echo '<hr/>';

  if ($this->input->post('nim')) {
    $nim =$this->input->post('nim');
    
    $khss = $this->db->select('tahun')->get_where('_v2_khs',array('nim'=>$this->input->post('nim')))->result();
    // echo '<pre>';
    // print_r($khss);
    // echo '</pre>';
    // echo '<hr/>';
    foreach ($khss as $khs) {
      $krsTabel = '_v2_krs'.$khs->tahun;
      // $q = "UPDATE `$krsTabel` INNER JOIN _v2_jadwal ON _v2_jadwal.IDJADWAL=$krsTabel.IDJadwal INNER JOIN _v2_matakuliah on _v2_matakuliah.Kode=_v2_jadwal.KodeMK SET $krsTabel.NamaMK_Inggris = _v2_matakuliah.Nama_English WHERE `NIM` LIKE '$nim'";
      $q = "UPDATE `$krsTabel` INNER JOIN _v2_jadwal ON _v2_jadwal.IDJADWAL=$krsTabel.IDJadwal INNER JOIN _v2_matakuliah on REPLACE(_v2_matakuliah.Kode,')','')=REPLACE(_v2_jadwal.KodeMK,')','') or REPLACE(_v2_matakuliah.Kode,'*','')=REPLACE(_v2_jadwal.KodeMK,'*','') SET $krsTabel.NamaMK_Inggris = _v2_matakuliah.Nama_English,$krsTabel.IDMK=_v2_matakuliah.IDMK,$krsTabel.KodeMK=_v2_matakuliah.kode WHERE `NIM` LIKE '$nim'";
      $this->db->query($q);
      echo $krsTabel.' - affected rows : '.$this->db->affected_rows();
      echo '<br>';
    }
  }
}
  // mini View ====================================================================

  private function v_selectFakultas($fk='')
  {
    $fak = $this->db1->select("Kode,Singkatan")->where("Singkatan !=",'0')->where("Singkatan !=",'')->get("fakultas")->result();
    
    echo '<select name="fakultas" id="fakultas">';
    foreach ($fak as $select) {
      if ($select->Kode==$fk) {
        echo "<option value='$select->Kode' selected>$select->Singkatan</option>";
      }else{
        echo "<option value='$select->Kode'>$select->Singkatan</option>";
      }
    };
    echo '</select>';
  }
  private function v_selectJurusan($jr='')
  {
    // $fak = $this->db1->select("Kode,Nama_indonesia jurusan")->where("Singkatan !=",'0')->where("Singkatan !=",'')->get("fakultas")->result();
    $fak = $this->db->select("Kode,Nama_indonesia jurusan")->get("_v2_jurusan")->result();
    
    echo '<select name="jurusan" id="fakultas">';
    foreach ($fak as $select) {
      if ($select->Kode==$jr OR $select->Kode==$this->input->post('jurusan')) {
        echo "<option value='$select->Kode' selected>$select->jurusan</option>";
      }else{
        echo "<option value='$select->Kode'>$select->Kode - $select->jurusan</option>";
      }
    };
    echo '</select>';
  }
  private function v_buttonGo()
  {
    echo "<input type='submit' value='go'>";
  }
  private function V_inputNim($nim='')
  {
    echo "<input type='text' placeholder='NIM' name='nim' value='$nim'>";
  }
  private function v_selectTahun($thn='')
  {
    echo "<input type='text'placeholder='Tahun Akademik' name='tahun' value='$thn'>";
  }
  // END mini View //

  // BackEnd =======================================================================

  function getDataMhsw()
  {
    $data = array(
      'res' => 'error',
      'ket'  => 'Tidak ada inputan',
      'data'  => []
    );
    if ($this->input->post('nim')) {
      $nim = $this->input->post('nim');

      $params = array(
        'act'     => 'GetDataLengkapMahasiswaProdi',
        'token'   => token(),
        'filter'  => "nim='$nim'"
      );
      $res = runWS($params);
      $obj = json_decode($res);
      
      if (count($obj->data)==1) {
        $data['ket']='data sudah ada di feeder. ';
        $data['data']=$obj->data;
        $where = array('NIM' =>$nim, );
        $set = array(
          'st_feeder' => '1',
          'id_pd'     => $obj->data[0]->id_mahasiswa,
          'id_reg_pd' => $obj->data[0]->id_registrasi_mahasiswa
        );
        $jmlah = $this->db->where($where)->get('_v2_mhsw')->num_rows();
        if ($jmlah==1) {
          $this->db->set($set);
          $this->db->where($where);
          $this->db->update('_v2_mhsw');
          $data['res']='sukses';
          $data['ket'].='Berhasil megambil id feeder. ';
          $data['data']=$set;
        }elseif($jmlah>=2) {

          $data['ket'].='Duplikat data di siakad ';
        }else {
          $data['ket'].='Gagal megambil id feeder.';
        }
      }elseif (count($obj->data)>=2) {
        $data['ket']='data lebih dari satu di feeder';
        $data['data']=$obj->data;
      }else {
        $data['ket']='data tidak ditemukan di feeder';
      }
    }

    echo json_encode($data);
  }


	Function date_to_smt($tgl)
	{
		$date=date_create("$tgl");
		$bln = date_format($date,"m");
		$thn = date_format($date,"Y");

		$smt = '';
		if($bln<=6){
			$smt = 2;
		}Elseif($bln>=12 && $bln >= 7){
			$smt = 1;
		}

		$thn_smt =$thn.$smt;

		echo $thn_smt;
	}

  public function coba()
  {

    $this->load->library('feeder_untad');
    
    $res = $this->feeder_untad->get('GetProfilPT');

    print_r($res);
  }
  // END BackEnd

  public function sync_biodata_feeder()
  {
    
    echo form_open();
    $this->v_selectJurusan($this->input->post('jurusan'));
    $this->v_selectTahun($this->input->post('tahun'));
    $this->v_buttonGo();
    echo "<hr/>";
    $jur = $this->input->post('jurusan') ; $thn = $this->input->post('tahun');

    if ($jur && $thn ) {
      // print_r($this->input->post());
      
      $this->load->library('feeder_untad');
      $fild = "ID,id_pd,id_reg_pd,NIM,TempatLahir,TglLahir,NamaIbu";

      $res = $this->db->select($fild)->get_where('_v2_mhsw',['KodeJurusan'=>$jur, 'TahunAkademik'=>$thn])->result();
      
      foreach ($res as $data ) {
        $ibu = $data->NamaIbu;
        $tmpt = $data->TempatLahir;
        $tgl = $data->TglLahir;

        if (!$ibu || !$tmpt || !$tgl) {
          $filter = "nim = '$data->NIM'";
          $fdr = $this->feeder_untad->get('GetDataLengkapMahasiswaProdi',$filter)->data[0];
          $where = ['ID' => $data->ID];
          $set = array(
            'NamaIbu' => $fdr->nama_ibu,
            'TglLahir'  => $fdr->tanggal_lahir,
            'TempatLahir' => $fdr->tempat_lahir
          );
          $this->db->where($where)->set($set)->update('_v2_mhsw');
          echo json_encode($where); echo "<br>";
          echo json_encode($set); echo "<hr/>";
          
        }
      }
    }

  }

  public function update_id_feeder($reset=false,$stp = false)
  {
    if ($stp) {
      exit(200);
    }
    if ($reset) {    
      $this->session->set_userdata('offset',0);
    }
    header( "Refresh:5; url=https://siakad2.untad.ac.id/Tools/update_id_feeder", true, 303);

    $num = $this->session->userdata('offset')+0;
    $this->load->library('feeder_untad');
    echo $num.'<br>';
    $bin = $this->db->query("SELECT `id`,`login` FROM `_v2_mhsw` WHERE `st_feeder` = 0 /* AND `Status` = 'D' */ limit $num,10")->result();
    // print_r($bin);
    foreach ($bin as $row) {
      $filter =  "nim = '$row->login'";
      $fdr = $this->feeder_untad->get('GetDataLengkapMahasiswaProdi',$filter);

      // echo json_encode($fdr->data).'<br>';
      if (!empty($fdr->data)) {
        $fdrdata = $fdr->data[0];
        $set = array(
          "st_feeder" => "1",
          "id_pd"  => $fdrdata->id_mahasiswa ,
          "id_reg_pd" => $fdrdata->id_registrasi_mahasiswa
        );
        $this->db->set($set)->where('ID',$row->id)->update('_v2_mhsw');
        echo $row->id.' '.json_encode($set);
        echo '<hr/>';
      }else {
        echo $row->id.' '.$row->login.' belum ada<hr/>';
      }

    }
    $this->session->set_userdata('offset',$num + 10);
  }

  public function Upate_nomor_hp()
  {
    # code...
  }
}
//  END of Controller Tools
