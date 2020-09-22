<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Takterjadwal extends CI_Controller
{
	function __construct(){
    parent::__construct();
    // $this->app->checksession();
    
		$uname=$this->session->userdata('uname');
    $ulevel=$this->session->userdata('ulevel');
    
    if (empty($uname) and empty($ulevel)) {
      $this->session->sess_destroy();
      redirect(base_url('menu'));
    }
  }
// /*
  function index()
  {
    $this->load->helper('string');
    $this->session->set_userdata('apiKey',random_string('sha1'));
    $fak = $this->session->userdata('kdf');
    $jur = $this->session->userdata('kdj');
    $lvl = $this->session->userdata('ulevel');
    if ($lvl=='5') {
      $where=array('j.kodeFakultas'=>$fak);
    }elseif ($lvl=='7') {
      $where=array('j.kode'=>$jur);
    }else {
      $where=FALSE;
    }
    $data['tab'] = $this->app->all_val('groupmodul')->result();
    $data['select']['tahun'] = $this->getTahun($where);
    $data['select']['prodi'] = $this->getProdi($where);
    $data['apiKey']=$this->session->userdata('apiKey');

    $this->load->view('dashbord',$data);
    $this->load->view('fikri.js/takterjadwal');
    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";
  }

  public function cari()
  {
    $res=array('status'=>FALSE,'ket'=>'Tahun dan fakultas tidak boleh kosong','data'=>array());
    // $_POST=array('prodi'=>'A111','tahun'=>'20191');
    if ($this->input->post()) {
      $prodi = $this->input->post('prodi');
      $tahun = $this->input->post('tahun');
      $prog = $this->input->post('program');
      if ($prog =='RESO') {
        $program = ['RESO','NONREG'];
      }elseif ($prog == 'REG') {
        $program = ['REG'];
      }else{
        $program = [$prog];
      }
      $tabel = '_v2_krs'.$tahun.' k';

      if ($tahun) {
        $res['status']=true;
        $res['ket']='';
        $this->db->select("GROUP_CONCAT(k.ID) selected,jr.Kode,k.Tahun,k.IDJadwal,k.IDMK,k.KodeMK,k.NamaMK,k.SKS, COUNT(k.NIM) jumlah");
        $this->db->join('_v2_jadwal j','j.IDJADWAL=k.IDJadwal','LEFT');
        $this->db->join('_v2_mhsw m','m.NIM=k.NIM','LEFT');
        $this->db->join('_v2_jurusan jr','jr.Kode=m.KodeJurusan','LEFT');
        $this->db->where('j.id is null');
        $this->db->where('k.IDJadwal != ','0');
        $this->db->where_in('m.KodeProgram',$program);
        if ($prodi) {
          $this->db->where_in('jr.kode',$prodi);
        }
        $this->db->group_by("k.IDJadwal,k.IDMK,k.KodeMK,jr.Kode");
        $this->db->order_by("jr.Kode","ASC");
        $res['data'] = $this->db->get($tabel)->result();
      }else{

      }

    }

    echo json_encode($res);
  }
  public function simpan($apiKey)
  {
    if ($apiKey === $this->session->userdata('apiKey')) {
      if ($this->input->post()) {
        $tahun = $this->input->post('tahun');
        $table = '_v2_krs'.$tahun;
        $set = $this->input->post('set');
        $where = $this->input->post('where');

        $this->db->where_in('ID',$where);
        $res = $this->db->update($table, $set);
        // $res = $this->db->get($table);
        // $this->db->where($where);
        // $res = $this->db->update_sting($table,$set);
        $affected_rows = $this->db->affected_rows();
        // echo json_encode(['affected_rows'=>$affected_rows]);
        // $query = $this->db->last_query();

        $data = ['res'=> $res, 'affected_rows'=>$affected_rows];
        echo json_encode($data);
      }else{

      }
    }else{
      echo json_encode(['error'=>'403','message'=>"Forbidden – you don't have permission to access 'ademik/Takterjadwal/simpan' on this server"]);
    }
  }
  public function peserta()
  {
    $data = array();
    if ($this->input->post()) {
      $where = $this->input->post('id');
      $tabel = '_v2_krs'.$this->input->post('Tahun').' k';
      
      $data = $this->db->select("m.NIM,m.Name")->join('_v2_mhsw m','m.NIM=k.NIM','INNER')->where_in('k.ID',$where)->get($tabel)->result_array();
    }
    echo json_encode($data);
  }
  public function jadwal()
  {
    $tahun = $this->input->post('Tahun'); 
    $prodi = $this->input->post('KodeJurusan');
    $program = $this->input->post('program');
    $query = "SELECT j.IDJADWAL,j.IDMK,j.KodeMK,j.NamaMK,j.SKS,j.Keterangan kelas, j.kap kapasitas,(SELECT COUNT(k.NIM) FROM _v2_krs".$tahun." k WHERE k.IDJadwal=j.IDJadwal ) Peserta, j.kap - (SELECT COUNT(k.NIM) FROM _v2_krs".$tahun." k WHERE k.IDJadwal=j.IDJadwal ) sisa
    FROM _v2_jadwal j
    LEFT JOIN _v2_matakuliah m on m.Kode=j.KodeMK
    WHERE j.Tahun LIKE '".$tahun."' AND j.Terjadwal = 'Y' AND j.KodeJurusan LIKE '".$prodi."' AND j.Program LIKE '".$program."'
    GROUP by j.IDJadwal";
    $jadwal['jadwal'] = $this->db->query($query)->result();
    $jadwal['query']=$this->db->last_query();

    echo json_encode($jadwal);
  }
  private function getTahun($where='')
  {
    $this->db->distinct();
    $this->db->select("t.kode,t.Nama");
    if ($where) {
      $this->db->where($where);
    }else {
      $this->db->group_by('t.kode');
    }
    $this->db->join('_v2_jurusan j','j.kode=t.KodeJurusan','inner');
    $this->db->order_by('t.kode','desc');
    return $this->db->get('_v2_tahun t')->result();
  }
  private function getProdi($where='')
  {
    $this->db->select("j.kode,j.Nama_indonesia nama");
    $this->db->join('fakultas f','f.kode=j.KodeFakultas','inner');
    if ($where) {
      $this->db->where($where);
    }
    return $this->db->get('_v2_jurusan j')->result();
  }

}
