<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sync_spp extends CI_Model{
	
	private $db2;
	public function __construct(){
		parent::__construct();
		$this->db2 = $this->load->database('siakad', TRUE);
	}
	
	public function sppLama() {
		$data = $this->db2->query("SELECT * from spp2 WHERE (tahun!='0' OR bayar!='0') AND pindah_siakad_baru='0' LIMIT 30000");
		return $data->result();
	}

	public function sppBaru() {
		$data = $this->db->query("SELECT * from _v2_spp2");
		return $data->result();
	}

	function addData($data,$table)
	{
		//untuk insert data ke database
		return $this->db->insert($table, $data);
	}

	function updateData($id,$data,$table)
	{
		//update produk berdasarkan id
		$this->db2->where('id', $id);
		return $this->db2->update($table, $data);
	}

	public function krsLama($tahun = '') {
		$data = $this->db2->query("SELECT * from krs".$tahun." WHERE pindah_siakad='1'");
		return $data->result();
	}









	//_____________________________________Model AKTIVASI MAHASISWA____________________________________//
	
}