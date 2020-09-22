<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matakuliah_smtr_model extends CI_Model {


	
	public function get_dataSearch($lvl, $user) {

		if ( $lvl == 1 ) {

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

	public function get_dataKurikulum($kodeJur) {

		$this->db->select('IdKurikulum, Nama, id_kurikulum');
		$this->db->from('_v2_kurikulum');
		$this->db->where('KodeJurusan', $kodeJur);

		return $this->db->get()->result_array();

	}

	public function get_matakuliah($kodeJur) {

		$this->db->select('ID, Kode, Nama_Indonesia, SKS, id_mk, st_feeder');
		$this->db->from('_v2_matakuliah');
		$this->db->where('KodeJurusan',$kodeJur);
		$this->db->where('NotActive', 'N');
		$this->db->where('id_mk IS NOT NULL');

		return $this->db->get()->result_array();

	}

	public function getDetailKurikulum($kode,$active) {

		$this->db->select('IdKurikulum, Nama, Tahun, Sesi, JmlSesi, KodeJurusan, id_kurikulum');
		$this->db->from('_v2_kurikulum');
		$this->db->where('KodeJurusan',$kode);
		$this->db->where('NotActive',$active);

		return $this->db->get()->row();

	}

	public function getMaxTabel($idKurikulum) {

		$this->db->select('max(Sesi) as JmlTabel');
		$this->db->from('_v2_matakuliah');
		$this->db->where('KurikulumID',$idKurikulum);

		return $this->db->get()->row();

	}

	public function getDetailTabel($idKurikulum,$i) {

		$this->db->select('Kode, Nama_Indonesia, SKS, NotActive, Wajib, IDMK, ID, st_feeder');
		$this->db->from('_v2_matakuliah');
		$this->db->where('KurikulumID',$idKurikulum);
		$this->db->where('Sesi',$i);
		$this->db->order_by('Kode','asc');

		return $this->db->get()->result();

	}

	public function getdataUpdate($id) {

		$this->db->select('mk.ID, mk.id_mk, mk.Wajib, mk.Sesi, k.id_kurikulum');
		$this->db->from('_v2_matakuliah mk');
		$this->db->join('_v2_kurikulum k', 'k.IdKurikulum = mk.KurikulumID', 'LEFT');
		$this->db->where('mk.ID',$id);

		return $this->db->get()->result_array();

	}
	
	public function updateData($data) {

		$matakuliah = explode(" ", $data['id']);
		$kurikulum = explode(" ", $data['kurikulum']);

		$dataMatakuliah = array (
			'urutan' => intval($data['urutan']),
			'KurikulumID' => $this->db->escape_str($kurikulum[0]),
			'Wajib' => $this->db->escape_str($data['wajib']),
			'Sesi' => intval($data['semester']),
			'st_feeder' => 3			
		);

		$this->db->where('ID',$matakuliah[0]);
		return $this->db->update('_v2_matakuliah',$dataMatakuliah);

	}

	public function updateDatast_feeder($data) {

		$dataMatakuliah = array (
			'st_feeder' => 3			
		);

		$this->db->where('ID',$data[0]['ID']);
		return $this->db->update('_v2_matakuliah',$dataMatakuliah);

	}

	public function deleteData($id) {

		$dataMatakuliah = array (
			'st_feeder' => 1,
			'urutan' => 0,
			'KurikulumID' => ''		
		);

		$this->db->where('ID',$id);
		return $this->db->update('_v2_matakuliah',$dataMatakuliah);

	}

}