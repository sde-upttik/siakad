<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Krsf_model extends CI_Model {
	private $siakadOld;

	public function getDataNimMahasiswa($tahun)
	{
		$this->db->where('KodeFakultas','F');
		$this->db->where('TahunAkademik >=','2013');
		$this->db->where('TahunAkademik <=',$tahun);
		$this->db->where('update_krsf','0');
		$this->db->select("_v2_mhsw.NIM");
		$this->db->from('_v2_mhsw');
		// $this->db->limit(1); 
		return $this->db->get()->result_array();
	}

	public function getDatakrsf($fields="", $where="")
	{
		$this->siakadOld = $this->load->database('siakad', TRUE);

		$this->siakadOld->select($fields);
		
		$this->siakadOld->where($where);
		$this->siakadOld->where('pindah_siakad_baru !=', '1');
		
		$this->siakadOld->order_by('NIM', 'ASC');
		$this->siakadOld->order_by('Tahun', 'ASC');
		// $this->siakadOld->limit(3);
		return $this->siakadOld->get('krsF')->result_array();
	}

	public function getListFieldkrs($siakad)
	{
		$this->siakadOld = $this->load->database('siakad', TRUE);
		if ($siakad == 1) {
			return $this->siakadOld->list_fields('krsF');
		}
		elseif($siakad == 2){
			return $this->db->list_fields('_v2_krs20101');
		}
		else{
			return null;
		}
	}

	public function checkAvailabelkrs($where, $tahun)
	{
		$this->db->where($where);
		return $this->db->get('_v2_krs'.$tahun)->num_rows();
	}
		
	public function getDataKrsSiakad2($where, $tahun)
	{
		$this->db->where($where);
		$this->db->select('KodeMk');
		return $this->db->get('_v2_krs'.$tahun)->result_array();
	}

	public function getDataKrsSiakad1($where, $tahun)
	{
		$this->siakadOld = $this->load->database('siakad', TRUE);

		$this->siakadOld->where($where);
		$this->siakadOld->select('KodeMk');
		return $this->siakadOld->get('krsF')->result_array();
	}

	public function insertDataKrsToSiakad2($where, $data, $tahun)
	{
		$this->db->where($where);
		return $this->db->insert('_v2_krs'.$tahun, $data);
	}

	public function updateKrsf($where)
	{
		$this->siakadOld = $this->load->database('siakad', TRUE);
		
		$data['pindah_siakad_baru'] = '1';

		$this->siakadOld->where($where);
		return $this->siakadOld->update('krsF', $data);
	}

	public function updateMhswF($where)
	{
		
		$data['update_krsf'] = '1';

		$this->db->where($where);
		return $this->db->update('_v2_mhsw', $data);
	}

	public function updateMhswFReset()
	{
		$data['update_krsf'] = '0';

		$this->db->where('KodeFakultas','F');
		return $this->db->update('_v2_mhsw', $data);
	}
}
