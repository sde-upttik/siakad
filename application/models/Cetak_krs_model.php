<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak_krs_model extends CI_Model{
    
    private $db2;    


    public function __construct(){
        parent::__construct();
        $this->db2 = $this->load->database('spc', TRUE);
    }

    public function getJurusan() {
        $query = $this->db->query("SELECT Kode, Nama_Indonesia FROM _v2_jurusan");

        return $query->result();
    }

    public function getKodeFakultas($table,$unip) {
        $query = $this->db->query("SELECT KodeFakultas FROM $table WHERE Login='$unip' LIMIT 1");

        return $query->row()->KodeFakultas;
    }    

    public function getKodeFakultas1($table,$unip) {
        $query = $this->db->query("SELECT KodeFakultas FROM $table WHERE NIM='$unip' LIMIT 1");

        return $query->row()->KodeFakultas;
    }   

    public function getKodeJurusan($table,$unip) {
        $query = $this->db->query("SELECT KodeJurusan FROM $table WHERE Login='$unip' LIMIT 1");

        return $query->row()->KodeJurusan;
    }    

    public function getKodeJurusan1($table,$unip) {
        $query = $this->db->query("SELECT KodeJurusan FROM $table WHERE NIM='$unip' LIMIT 1");

        return $query->row()->KodeJurusan;
    }     

    public function getDataMhsw($nim) {
        $query = $this->db->query("SELECT m.Name,m.KodeFakultas,m.KodeJurusan,m.KodeProgram,DosenID,d.Name as DName FROM _v2_mhsw m left outer join _v2_dosen d on m.DosenID=d.Login WHERE m.NIM='$nim' LIMIT 1");

        return $query->row();
    }

    public function getFakultas($KodeFakultas) {
        $query = $this->db->query("SELECT Nama_Indonesia FROM fakultas WHERE Kode='$KodeFakultas' LIMIT 1");

        return $query->row()->Nama_Indonesia;
    }

    public function getQueryJurusan($KodeJurusan) {
        $query = $this->db->query("SELECT j.Nama_Indonesia as JUR, j.Sesi, jp.Nama as JEN FROM _v2_jurusan j left outer join _v2_jenjangps jp on j.Jenjang=jp.Kode WHERE j.Kode='$KodeJurusan' LIMIT 1");

        return $query->row();
    }

    public function getDetailKrs($nim,$thn,$tbl) {
        $query = $this->db->query("SELECT k.KodeMK,k.NamaMK,k.SKS,j.KodeRuang,j.Keterangan,k.Hadir from $tbl k left join _v2_jadwal j on k.IDJADWAL=j.IDJADWAL where NIM='$nim' and k.tahun='$thn' and k.st_wali='1' order by KodeMK");

        return $query->result();
    }

    public function getTtd($kdj,$kdp){
    	if ($kdp=='NONREG') {
    		$kdp="RESO";
    	}elseif($kdp=='S2') {
    		$kdp="REG";
    	}
    	$query = $this->db->query("SELECT * from _v2_jurusan_ttd j where j.Kode='$kdj' and j.jenis_program='$kdp' LIMIT 1");

        return $query->row();
    }

    
}