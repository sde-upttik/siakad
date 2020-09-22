<?php
class Mahasiswa_berkrs extends CI_Controller
{
 public function __construct(Type $var = null)
 {
  parent::__construct();
 }

 public function index()
 {
  
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
  foreach ($data['select']['prodi'] as $prodi) {
    $data['select']['kodeProdi'][] = $prodi->kode;
  }
  $this->load->view('dashbord',$data);
  $this->load->view('fikri.js/Mahasiswa_berkrs');

 }

public function cari()
{
  // $_POST = array('tahun'=>20191,'prodi'=> ['A111']);
  $res = array('data'=>array(),'status'=>FALSE);
  if ($this->input->post()) {
    $tahun = $this->input->post('tahun');
    $prodi = $this->input->post('prodi');
    $tblkrs = '_v2_krs'.$tahun.' k';
    $res['data'] = $this->db->select("f.kode 'kFakultas', f.Nama_Indonesia 'nFakultas',j.kode 'kProdi', j.Nama_Indonesia 'nProdi', m.NIM, m.Name Nama")
            ->join($tblkrs,'k.nim=m.NIM','LEFT')
            ->join('_v2_jurusan j','j.Kode=m.KodeJurusan','LEFT')
            ->join('fakultas f','f.Kode=j.KodeFakultas','LEFT')
            ->where_in('j.kode', $prodi)
            ->where("k.ID is not null AND f.Kode !='G'")
            ->group_by('m.NIM')
            ->get('_v2_mhsw m')->result();
    $res['status']=true;
    // $res['query'] = $this->db->last_query();
  }
  echo json_encode($res);
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
