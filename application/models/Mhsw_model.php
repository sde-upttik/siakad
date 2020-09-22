<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mhsw_model extends CI_Model {
	
	public function get_dataSearch($lvl, $user) {

		if ( $lvl == 1 or $lvl == 6 ) {

			$this->db->select('Kode, Nama_Indonesia');
		    $this->db->from('_v2_jurusan');

		    return $this->db->get()->result_array();

		} elseif ( $lvl == 5 ) {

			$this->db->select('Kode, Nama_Indonesia');
		    $this->db->from('_v2_jurusan');
		    $this->db->where('KodeFakultas', $user);

		    return $this->db->get()->result_array();

		} elseif ( $lvl == 7 ) {

			$this->db->select('Kode, Nama_Indonesia');
		    $this->db->from('_v2_jurusan');
		    $this->db->where('Kode', $user);

		    return $this->db->get()->result_array();

		}

	}

	public function getMhswFeeder($NIM) {
		$NIM = $this->db->escape_str($NIM);

		$query = $this->db->query("SELECT m.*,p.id_sms from _v2_mhsw m,_v2_jurusan p where m.KodeJurusan=p.Kode and m.NIM='$NIM'");

        return $query->row();
	}

	public function updateIdPd($id_pd, $nim) {
		$this->db->query("UPDATE _v2_mhsw set id_pd='$id_pd' where NIM='$nim'");
	}

	public function save_mhsw_reg_pd($data) {
		$id_reg_pd = $this->db->escape_str($data['id_reg_pd']);
		$st_feeder = $this->db->escape_str($data['st_feeder']);
		$nimd = $this->db->escape_str($data['nimd']);
		$update = $this->db->query("UPDATE _v2_mhsw set id_reg_pd='$id_reg_pd',st_feeder='$st_feeder' where NIM='$nimd'");
		if($update){
			return true;
		}else{
			return false;
		}
	}

	public function getIdPd($NIM) {
		$NIM = $this->db->escape_str($NIM);

		$query = $this->db->query("SELECT id_pd from _v2_mhsw where NIM='$NIM'");

        return $query->row();
	}


	public function get_dataTabelMhsw($KodeJurusan,$tahunAkademik){

		$kodeJur = $this->db->escape_str($KodeJurusan);
		$tahun = $this->db->escape_str($tahunAkademik);

		$this->db->select('m.NIM, m.Name, m.TglLahir, m.NamaIbu, m.id_reg_pd, m.TempatLahir, d.Name as dosen, sm.Nama as statusMhsw, p.Nama_Indonesia as namaProgram, j.Nama_Indonesia as namaJurusan, j.id_sms, m.sex, m.AgamaID, m.nik ');
		$this->db->from('_v2_mhsw m');
		$this->db->join('_v2_jurusan j','m.KodeJurusan=j.Kode','LEFT');
		$this->db->join('_v2_program p','m.KodeProgram=p.Kode','LEFT');
		$this->db->join('_v2_statusmhsw sm','m.Status=sm.Kode','LEFT');
		$this->db->join('_v2_dosen d','m.DosenID=d.nip','LEFT');
		$this->db->where('m.KodeJurusan',$kodeJur);
		$this->db->where('m.TahunAkademik',$tahun);

		return $this->db->get()->result();

	}
	
}