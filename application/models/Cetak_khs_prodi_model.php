<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak_khs_prodi_model extends CI_Model{
    
    private $db2;    


    public function __construct(){
        parent::__construct();
        $this->db2 = $this->load->database('spc', TRUE);
    }

    public function getJurusan() {
        $query = $this->db->query("SELECT Kode, Nama_Indonesia FROM _v2_jurusan");

        return $query->result();
    }

    public function getJurusanKdj($kdj) {
        $query = $this->db->query("SELECT Kode, Nama_Indonesia FROM _v2_jurusan WHERE Kode='$kdj'");

        return $query->result();
    }


    public function getJurusanKdf($kdf) {
        $query = $this->db->query("SELECT Kode, Nama_Indonesia FROM _v2_jurusan WHERE KodeFakultas='$kdf'");

        return $query->result();
    }

    public function getTahunNextMax($nim) {
        $nim=$this->db->escape_str($nim);

        $query = $this->db->query("SELECT max(Tahun) as ThnNext from _v2_khs where NIM='$nim' limit 1");

        return $query->row();
    }

    public function getMhswKhs($semester,$program,$jurusan,$angkatan){
        $semester=$this->db->escape_str($semester);
        $jurusan=$this->db->escape_str($jurusan);
        $program=$this->db->escape_str($program);
        $angkatan=$this->db->escape_str($angkatan);

        $query = $this->db->query("SELECT k.NIM,m.Name,k.st_feeder,k.Tahun from _v2_khs k, _v2_mhsw m where k.NIM=m.NIM and m.KodeJurusan='$jurusan' and k.Tahun='$semester' and m.KodeProgram like '%$program%' and m.TahunAkademik like '%$angkatan%' group by k.NIM order by k.NIM,m.TahunAkademik DESC");

        return $query->result();
    }

    public function getMhswKhs1($semester,$program,$jurusan,$angkatan,$nim){
        $semester=$this->db->escape_str($semester);
        $jurusan=$this->db->escape_str($jurusan);
        $program=$this->db->escape_str($program);
        $angkatan=$this->db->escape_str($angkatan);
        $nim=$this->db->escape_str($nim);

        $query = $this->db->query("SELECT k.NIM,m.Name from _v2_khs k, _v2_mhsw m where k.NIM=m.NIM and m.KodeJurusan='$jurusan' and k.Tahun='$semester' and m.KodeProgram like '%$program%' and m.TahunAkademik like '%$angkatan%' and k.NIM='$nim' group by k.NIM order by k.NIM,m.TahunAkademik DESC");

        return $query->result();
    }


    public function getMhswFak($nim){
        $nim=$this->db->escape_str($nim);

        $query = $this->db->query("SELECT Name,KodeFakultas,KodeJurusan,KodeProgram from _v2_mhsw where NIM='$nim' limit 1");

        return $query->row();
    }


    public function cekFeederKrs($nim,$thn) {
        $nim=$this->db->escape_str($nim);
        $thn=$this->db->escape_str($thn);
        $tabel = "_v2_krs".$thn;

        $query = $this->db->query("SELECT st_feeder from $tabel where NIM='$nim' limit 1");

        if($query){
            return $query->row();
        }else{
            return false;
        }
    }

    public function getFak($fak){
        $fak=$this->db->escape_str($fak);

        $query = $this->db->query("SELECT Nama_Indonesia, Kode from fakultas where Kode='$fak' limit 1");

        return $query->row();
    }

    public function getTahun($jur,$tahun){
        $jur=$this->db->escape_str($jur);
        $tahun=$this->db->escape_str($tahun);

        $query = $this->db->query("SELECT Nama from _v2_tahun where KodeJurusan='$jur' and Kode='$tahun' limit 1");

        return $query->row();
    }

    public function getJur($jur){
        $jur=$this->db->escape_str($jur);

        $query = $this->db->query("SELECT j.Nama_Indonesia as JUR, jp.Nama as JEN from _v2_jurusan j left outer join _v2_jenjangps jp on j.Jenjang=jp.Kode where j.Kode='$jur' limit 1");

        return $query->row();
    }

    public function getMatakuliah($KodeMK,$kdj){
        $KodeMK=$this->db->escape_str($KodeMK);
        $kdj=$this->db->escape_str($kdj);

        $query = $this->db->query("SELECT Nama_Indonesia from _v2_matakuliah where Kode='$KodeMK' and KodeJurusan='$kdj' limit 1");

        return $query->row();
    }

    public function getMatakuliahQuery($KodeMK,$kdj){
        $KodeMK=$this->db->escape_str($KodeMK);
        $kdj=$this->db->escape_str($kdj);

        $query = $this->db->query("SELECT Nama_Indonesia from _v2_matakuliah where Kode='$KodeMK' and KodeJurusan='$kdj' limit 1");

        // return $query->row();
        return $this->db->last_query();
    }


    public function getDatakrsCetak($semesterAkademik,$nim){
        $semesterAkademik=$this->db->escape_str($semesterAkademik);
        $nim=$this->db->escape_str($nim);

        $query = $this->db->query("SELECT * from _v2_krs$semesterAkademik where NIM='$nim' and Tahun='$semesterAkademik' AND NotActive_KRS='N' order by KodeMK");

        return $query->result();
    }

    public function getTotal($nim,$jurusan,$semester,$fakultas){
        $semester=$this->db->escape_str($semester);
        $nim=$this->db->escape_str($nim);
        $jurusan=$this->db->escape_str($jurusan);

        $query = $this->db->query("SELECT m.Name, k.NIM, k.IPS, k.SKSLulus, k.IPK, k.TotalSKS, k.MaxSKS2, k.TotalSKSLulus FROM _v2_khs k INNER JOIN _v2_mhsw m ON m.nim = k.nim WHERE k.tahun ='$semester' AND m.KodeJurusan = '$jurusan' AND m.nim = '$nim'");

        return $query->row();
    }

    public function getTtd($jurusan){
        $jurusan=$this->db->escape_str($jurusan);

        $query = $this->db->query("SELECT TTJabatan1,TTJabatan2,TTJabatan3,TTPejabat1,TTPejabat2,TTPejabat3,TTnippejabat1,TTnippejabat2,TTnippejabat3,TTJabatanKHS,TTPejabatKHS,TTnippejabatKHS,TTJabatanKHS2,TTPejabatKHS2,TTnippejabatKHS2 FROM _v2_jurusan WHERE Kode = '$jurusan'");

        return $query->row();
    }



    var $table = '_v2_khs k'; //nama tabel dari database
    var $column_order = array('k.ID', 'k.NIM', 'm.Name', 'm.KodeProgram', 'k.Tahun', 'k.Status', 'k.SKS', 'k.SKSLulus', 'k.IPS', 'k.TotalSKS', 'k.TotalSKSLulus', 'k.IPK', 'k.stprc', 'k.st_feeder'); //field yang ada di table user
    var $column_search = array('k.NIM', 'm.Name', 'm.KodeProgram', 'k.Tahun', 'k.Status', 'k.SKS', 'k.SKSLulus', 'k.IPS', 'k.TotalSKS', 'k.TotalSKSLulus', 'k.IPK', 'k.stprc', 'k.st_feeder'); //field yang diizin untuk pencarian 
    var $order = array('k.NIM' => 'asc'); // default order 

    private function _get_datatables_query($semesterAkademik,$jurusan,$program,$angkatan)
    {
        $this->db->select('k.ID,k.NIM, m.Name, m.KodeProgram, k.Tahun, k.Status, k.SKS, k.SKSLulus, k.IPS, k.TotalSKS, k.TotalSKSLulus, k.IPK, k.stprc, k.st_feeder');
        $this->db->from($this->table);
        $this->db->join('_v2_mhsw m', 'k.NIM = m.NIM', 'left');
        $this->db->where('k.Tahun', $semesterAkademik);
        $this->db->where('m.KodeJurusan', $jurusan);
        $this->db->like('m.KodeProgram', $program);

        if($angkatan!="All"){
            $this->db->like('m.TahunAkademik', $angkatan);
        }
        $semesterAkademik1 = substr($semesterAkademik, 0, 4);
        $this->db->where('m.TahunAkademik <=',$semesterAkademik1);
        $this->db->where('k.Status !=','L');
 
        $i = 0;
     
        foreach ($this->column_search as $item) // looping awal
        {
            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {
                 
                if($i===0) // looping awal
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables($semesterAkademik,$jurusan,$program,$angkatan)
    {
        $this->_get_datatables_query($semesterAkademik,$jurusan,$program,$angkatan);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($semesterAkademik,$jurusan,$program,$angkatan)
    {
        $this->_get_datatables_query($semesterAkademik,$jurusan,$program,$angkatan);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($semesterAkademik,$jurusan,$program,$angkatan)
    {
        $this->db->from($this->table);
        $this->db->join('_v2_mhsw m', 'k.NIM = m.NIM', 'left');
        $this->db->where('k.Tahun', $semesterAkademik);
        $this->db->where('m.KodeJurusan', $jurusan);
        $this->db->like('m.KodeProgram', $program);

        if($angkatan!="All"){
            $this->db->like('m.TahunAkademik', $angkatan);
        }
        $semesterAkademik1 = substr($semesterAkademik, 0, 4);
        $this->db->where('m.TahunAkademik <=',$semesterAkademik1);
        $this->db->where('k.Status !=','L');
        return $this->db->count_all_results();
    }

    public function getDataIps($semesterAkademik,$jurusan,$program,$angkatan,$str){
        $semesterAkademik=$this->db->escape_str($semesterAkademik);
        $jurusan=$this->db->escape_str($jurusan);
        $program=$this->db->escape_str($program);
        $angkatan=$this->db->escape_str($angkatan);

        $query = $this->db->query("SELECT k.Tahun,k.NIM,m.Name,m.KodeProgram,m.KodeFakultas,k.SKS,k.SKSLulus,k.IPS,k.IPK,k.TotalSKS,k.TotalSKSLulus from _v2_khs k,_v2_mhsw m where k.NIM=m.NIM and k.Tahun='$semesterAkademik' and m.KodeJurusan='$jurusan' and m.KodeProgram like '%$program%' and m.TahunAkademik like '%$angkatan%' $str");

        return $query->result();
    }

    public function getDatakrs($semesterAkademik,$nim){
        $semesterAkademik=$this->db->escape_str($semesterAkademik);
        $nim=$this->db->escape_str($nim);

        $query = $this->db->query("SELECT * from _v2_krs$semesterAkademik where NIM='$nim' and tahun='$semesterAkademik' group by NamaMK");

        return $query->result();
    }

    public function getSksMax($IPS,$nim){
        $IPS=$this->db->escape_str($IPS);
        $nim=$this->db->escape_str($nim);

        $query = $this->db->query("SELECT SKSMax from _v2_mhsw m, _v2_max_sks mx where m.KodeJurusan=mx.KodeJurusan and IPSMin <= $IPS and IPSmax >= $IPS and mx.NotActive='N' and m.nim='$nim' limit 1");

        return $query->row();
    }

    public function updateKhs($IPS,$TSKSLulus,$TSKS,$maxsks,$nim,$thn) {
        $IPS = $this->db->escape_str($IPS); 
        $TSKSLulus = $this->db->escape_str($TSKSLulus); 
        $TSKS = $this->db->escape_str($TSKS); 
        $maxsks = $this->db->escape_str($maxsks); 
        $nim = $this->db->escape_str($nim); 
        $thn = $this->db->escape_str($thn);

        $this->db->query("UPDATE _v2_khs set stprc='1',IPS=$IPS,SKSLulus=$TSKSLulus, SKS='$TSKS', MaxSKS2='$maxsks' where NIM='$nim' and Tahun='$thn'");
    }

    public function getDataIpk($semesterAkademik,$jurusan,$program,$angkatan,$str){
        $semesterAkademik=$this->db->escape_str($semesterAkademik);
        $jurusan=$this->db->escape_str($jurusan);
        $program=$this->db->escape_str($program);
        $angkatan=$this->db->escape_str($angkatan);

        $query = $this->db->query("SELECT k.Tahun,k.NIM,m.Name,m.KodeProgram,m.KodeFakultas,k.SKS,k.SKSLulus,k.IPS,k.IPK,k.TotalSKS,k.TotalSKSLulus from _v2_khs k, _v2_mhsw m where k.NIM=m.NIM and k.Tahun='$semesterAkademik' and m.KodeJurusan='$jurusan' and m.KodeProgram like '%$program%' and m.TahunAkademik like '%$angkatan%' $str");

        return $query->result();
    }

    public function getDataKrsIpk($nim,$thn,$status){
        $nim=$this->db->escape_str($nim);
        $thn=$this->db->escape_str($thn);
        $status=$this->db->escape_str($status);

        if($status=='baru'){
            $query = $this->db->query("SELECT GradeNilai as Grade,SKS,Bobot as Bbt, NamaMK from _v2_krs$thn where NIM='$nim' and Tahun<='$thn' and NotActive='N' group by NamaMK");    
        }else{
            $query = $this->db->query("SELECT Min(GradeNilai) as Grade,SKS,Max(Bobot) as Bbt, NamaMK from _v2_krs$thn where NIM='$nim' and Tahun<='$thn' and GradeNilai!='K' and NotActive='N' group by NamaMK");
        }        

        return $query->result();
    }
    
    public function updateKhsIpk($TotIPK,$TotSKS,$TotSKSLulus,$nim,$thn) {
        $TotIPK = $this->db->escape_str($TotIPK); 
        $TotSKS = $this->db->escape_str($TotSKS); 
        $TotSKSLulus = $this->db->escape_str($TotSKSLulus); 
        $nim = $this->db->escape_str($nim); 
        $thn = $this->db->escape_str($thn);

        $this->db->query("UPDATE _v2_khs k,_v2_mhsw m set stprc='2', k.IPK=$TotIPK, k.TotalSKS=$TotSKS, k.TotalSKSLulus=$TotSKSLulus, m.IPK=$TotIPK, m.TotalSKS=$TotSKS, m.TotalSKSLulus=$TotSKSLulus where k.NIM=m.NIM and k.NIM='$nim' and Tahun='$thn'");
    }

    public function getDataReset($semesterAkademik,$jurusan,$program,$angkatan){
        $semesterAkademik=$this->db->escape_str($semesterAkademik);
        $jurusan=$this->db->escape_str($jurusan);
        $program=$this->db->escape_str($program);
        $angkatan=$this->db->escape_str($angkatan);

        $query = $this->db->query("SELECT k.Tahun,k.NIM,m.Name,m.KodeProgram,m.KodeFakultas,k.SKS,k.SKSLulus,k.IPS,k.IPK,k.TotalSKS,k.TotalSKSLulus from _v2_khs k, _v2_mhsw m where k.NIM=m.NIM and k.Tahun='$semesterAkademik' and m.KodeJurusan='$jurusan' and m.KodeProgram like '%$program%' and m.TahunAkademik like '%$angkatan%' and  IPS='0.00' limit 50");

        return $query->result();
    }

    public function updateResetPrc($nim,$thn) {
        $nim = $this->db->escape_str($nim); 
        $thn = $this->db->escape_str($thn);

        $this->db->query("UPDATE _v2_khs set stprc='0' where NIM='$nim' and Tahun='$thn'");
    }

    public function deleteKhs($id) {
        $id = $this->db->escape_str($id); 

        $delete = $this->db->query("DELETE FROM _v2_khs WHERE ID='$id'");

        if($delete){
            return true;
        }else{
            return false;
        }
    }
}