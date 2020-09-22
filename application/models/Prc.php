<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prc extends CI_Model{
	
	private $db2;
	public function __construct(){
		parent::__construct();
		$this->db2 = $this->load->database('siakad', TRUE);
	}

	public function krsGroup($tahun) {
		$data = $this->db->query("SELECT NIM,Tahun from _v2_krs".$tahun." WHERE Tahun='$tahun' GROUP BY NIM");
		return $data->result();
	}

	public function cek_khs($nim,$tahun) {
		$data = $this->db->query("SELECT NIM,Tahun from _v2_khs WHERE NIM='$nim' AND Tahun='$tahun' limit 1");
		return $data->num_rows();
	}

	function addData($data,$tahun)
	{
		$tabel='_v2_krs'.$tahun;
		
		if ($this->db->table_exists($tabel) )
		{
			return $this->db->insert($tabel, $data);
		}else{
			return "0";
		}
		
	}

	function addDataTR($data,$tahun)
	{
		
		$tabel='_v2_krsTR';
		
		if ($this->db->table_exists($tabel) )
		{
			return $this->db->insert($tabel, $data);
		}else{
			return "0";
		}
		
	}

	function addData1($data,$tabel)
	{
		return $this->db->insert($tabel, $data);
	}

	function updateData($id,$data,$tahun)
	{
		if($tahun=='20161'){
			$tabel='krs';
		}else{
			$tabel='krs'.$tahun;
		}
		//update produk berdasarkan id
		$this->db2->where('id', $id);
		return $this->db2->update($tabel, $data);
	}

	function updateDataFak($id,$data,$fakultas)
	{
		$tabel='krs'.$fakultas;
		//update produk berdasarkan id
		$this->db2->where('ID', $id);
		return $this->db2->update($tabel, $data);
	}

	public function krsLama($tahun,$fak) {
		if($tahun=='20161'){
			$tabel='krs';
		}else{
			$tabel = 'krs'.$tahun;
		}
		$data = $this->db2->query("SELECT k.* from ".$tabel." k LEFT JOIN mhsw m ON k.NIM=m.NIM WHERE m.KodeFakultas='".$fak."' AND k.pindah_siakad_baru='0' AND k.Tahun='".$tahun."' LIMIT 40000");
		return $data->result();
	}

	public function krsLamaTR($tahun,$fak) {
		if($tahun=='20161'){
			$tahun='';
		}
		$data = $this->db2->query("SELECT k.* from krs".$tahun." k LEFT JOIN mhsw m ON k.NIM=m.NIM WHERE m.KodeFakultas='".$fak."' AND k.pindah_siakad_baru='0' AND (k.Tahun='TR' or k.Tahun='tr') LIMIT 40000");
		return $data->result();
	}

	public function khsLama($fak) {
		$data = $this->db2->query("SELECT k . * FROM  khs k LEFT JOIN mhsw m ON k.NIM = m.NIM WHERE m.KodeFakultas =  '$fak' AND k.pindah_siakad_baru='0' LIMIT 5000");
		return $data->result();
	}

	public function khsStPindah($where)
	{
		$set['pindah_siakad_baru'] = 1;
		$this->db2->set($set);
		$this->db2->where($where);
		return $this->db2->update('khs');

	}

	public function krsLamaFak($fak) {
		//AND SUBSTRING(k.NIM, 1, 1)='".$fak."'
		$data = $this->db2->query("SELECT k.* from krs".$fak." k WHERE k.pindah_siakad_baru='0' AND k.Tahun>='20101' AND k.IDMK!='' AND k.Tahun!='20183' AND k.Tahun!='20184' AND k.Tahun!='20191' AND k.Tahun!='Nilai' AND k.Tahun!='T' AND k.Tahun!='tr' AND k.Tahun!='20116' AND k.Tahun!='2011A' AND k.Tahun!='20192' AND k.Tahun!='Tahun' AND k.Tahun!='20125' LIMIT 50000");
		return $data->result();
	}

	public function krsLamaFakTR($fak) {
		//AND SUBSTRING(k.NIM, 1, 1)='".$fak."'
		$data = $this->db2->query("SELECT k.* from krs".$fak." k WHERE k.pindah_siakad_baru='0' AND (k.Tahun='TR' OR k.Tahun='tr') AND k.Tahun!='2011A' AND k.Tahun!='20192' AND k.Tahun!='Tahun' AND k.Tahun!='Nilai' AND k.Tahun!='T' AND k.Tahun!='20191' AND k.Tahun!='20183' AND k.Tahun!='20184' LIMIT 50000");
		return $data->result();
	}

	public function check_krs($nim,$tahun,$idjadwal,$kodemk) {
		$tabel='_v2_krs'.$tahun;
		$data = $this->db->query("SELECT NIM FROM ".$tabel." WHERE NIM='$nim' AND IDJadwal='$idjadwal' AND KodeMK='$kodemk'");
		return $data->num_rows();
	}

	public function check_krstr($nim,$tahun,$idjadwal,$kodemk) {
		$tabel='_v2_krsTR';
		$data = $this->db->query("SELECT NIM FROM ".$tabel." WHERE NIM='$nim' AND IDJadwal='$idjadwal' AND KodeMK='$kodemk'");
		return $data->num_rows();
	}



	public function checkKembarKrs($tahun) {
		$tabel='_v2_krs'.$tahun;
		$data = $this->db->query("SELECT IDJadwal,NIM,NamaMK, COUNT(IDJadwal) as Jml_Kembar FROM ".$tabel." GROUP BY IDJadwal,NamaMK,NIM HAVING COUNT(IDJadwal) > 1 AND COUNT(NamaMK) > 1");
		return $data->result();	
	}

	public function checkKembarNilaiKrs($IDJadwal,$NIM,$NamaMK,$tahun,$na) {
		$tabel='_v2_krs'.$tahun;
		$data = $this->db->query("SELECT ID,IDJadwal,NIM,NamaMK,GradeNilai,Bobot FROM ".$tabel." WHERE IDJadwal='$IDJadwal' AND NIM='$NIM' AND NamaMK='$NamaMK' AND NotActive='$na' ORDER BY ID DESC LIMIT 1");
		//AND NotActive='Y' 
		return $data->result();	
	}

	public function deleteData($ID,$tahun) {
		$tabel='_v2_krs'.$tahun;
		$this->db->where('ID', $ID);
		return $this->db->delete($tabel);
	}

	public function checkTahunKrs($tahun) {
		$tabel='_v2_krs'.$tahun;
		$data = $this->db->query("SELECT ID, NIM, Tahun FROM ".$tabel." WHERE Tahun!='$tahun'");
		return $data->result();	
	}


	public function cek_duplikat_khs($fak) {
		$data = $this->db->query("SELECT k.ID, k.NIM, COUNT(k.NIM) as Jml_Kembar, k.Tahun, m.KodeFakultas, m.KodeJurusan FROM _v2_khs k LEFT JOIN _v2_mhsw m ON k.NIM=m.NIM WHERE m.KodeFakultas = '$fak' GROUP BY k.NIM, k.Tahun having COUNT(k.NIM) > 1");
		return $data->result();	
	}

	public function limit_desc_nim($nim, $tahun) {
		$data = $this->db->query("SELECT ID, NIM, Tahun FROM _v2_khs WHERE NIM = '$nim' and Tahun = '$tahun' ORDER by ID DESC LIMIT 1");
		return $data->result();	
	}

	public function deleteData1($ID) {
		$tabel='_v2_khs';
		$this->db->where('ID', $ID);
		return $this->db->delete($tabel);
	}


	//_____________________________________Model AKTIVASI MAHASISWA____________________________________//
	
}