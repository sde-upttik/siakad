<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tambah_nilai_kliringmodel extends CI_Model {

	public function __construct(){	
		parent::__construct();

	}

	public function search($searchData){

		 
		$nim = $searchData;

		$data = $this->db->query("SELECT NIM, Name from _v2_mhsw where NIM='$nim'");	
			
			if($data){
				return $data->row();	
			}else{
				return FALSE;
			}
	}
	
	public function getQuery($query){
		$data = $this->db->query($query);
		return $data->row();
	}

	public function simpanan($simpan){
		
		$data = $this->db->insert('_v2_tambah_nilai_kliring',$simpan);

		if($data){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function getNama($nim){
		$data = $this->db->query("SELECT NIM, Name from _v2_mhsw where NIM='$nim' limit 1");
		return $data->row()->Name;
	}

	public function getDosen(){

		$this->db->select('nip, Name');
		$this->db->from('_v2_dosen');
		return $this->db->get()->result();		
	}

	public function getBelum(){

		$this->db->select('ID, NIM, Nama, Total_SKS, pimpinan_penanggung_jawab, Nomor_surat, Alasan, User_usulkan');
		$this->db->from('_v2_tambah_nilai_kliring');
		$this->db->where('Setujui_admin', 'Belum');
		return $this->db->get()->result();		
	}

	public function accept($id){

		$this->db->set('Setujui_admin', 'Setujui');
		$this->db->where('id', $id);
		$this->db->update('_v2_tambah_nilai_kliring');
		
		// return $this->db->get()->result();		
	}
}
			