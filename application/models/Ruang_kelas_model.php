<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruang_kelas_model extends CI_Model {

	// public function get_data(){
	
	// 	$data = $this->db->query("SELECT * FROM _v2_ruang LIMIT 60, 70");
		    
 //        return $data->result_array();

	// }

	public function get_data($lvl, $user){
		if ($lvl == 1) {

			$this->db->select('r.Kode, r.Nama, r.KodeKampus, r.Lantai, r.Kapasitas, r.KapasitasUjian, r.Keterangan, r.NotActive, f.Nama_Indonesia, f.Kode, r.Kode as Kode ' );
			$this->db->from('_v2_ruang r');
			$this->db->join('fakultas f', 'r.KodeKampus=f.Kode');
			$this->db->order_by('r.Kode','DESC');


			return $this->db->get()->result_array();
		
		} elseif ( $lvl == 5 ) {
			//$user = substr($user, 0, 1);

			$this->db->select('r.Kode, r.Nama, r.KodeKampus, r.Lantai, r.Kapasitas, r.KapasitasUjian, r.Keterangan, r.NotActive, f.Nama_Indonesia, f.Kode, r.Kode as Kode ' );
			$this->db->from('_v2_ruang r');
			$this->db->join('fakultas f', 'r.KodeKampus=f.Kode');
			$this->db->where('r.KodeKampus', $user);
			$this->db->order_by('r.Kode','DESC');

		    return $this->db->get()->result_array();

		} 
	   

	}

	public function get_jufak($lvl, $user){

		if ($lvl == 1) {
			
			$this->db->select('*');
			$this->db->from('fakultas');
			$this->db->order_by('Kode','ASC');

			return $this->db->get()->result_array();
		
		}elseif ($lvl == 5){   
		   $this->db->select('Kode, Nama_Indonesia');
		   $this->db->from('fakultas');
		   $this->db->where('Kode', $user);
		   $this->db->order_by('Kode','ASC');

		   return $this->db->get()->result_array();

		} 
	}

	public function get_edit($tabelName, $where){
		return $this->db->get_where($tabelName,$where);
	}

	public function updateData($tabelName,$where,$data){
		$this->db->where($where);
		$this->db->update($tabelName,$data);
	}

	public function save_data(){

	}
}