<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matakuliah_jns_model extends CI_Model {


	
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

		} elseif ( $lvl == 2 || $lvl == 7 ) {

			$this->db->select('Kode, Nama_Indonesia');
		    $this->db->from('_v2_jurusan');
		    $this->db->where('Kode', $user);

		    return $this->db->get()->result_array();

		}

	}

	public function get_dataJenisMK($kodeFakul) {

		$this->db->select('Kode, Nama');
		$this->db->from('_v2_jenismatakuliah');
		$this->db->where('KodeFakultas', $kodeFakul);
		$this->db->order_by('Kode','asc');

		return $this->db->get()->result_array();

	}

	public function get_dataKurikulum() {

		$this->db->select('IdKurikulum, Nama');
		$this->db->from('_v2_kurikulum');

		return $this->db->get()->result_array();

	}

	public function getDetailKurikulum($kode,$active) {

		$this->db->select('IdKurikulum, Nama, Tahun, Sesi, JmlSesi, KodeJurusan');
		$this->db->from('_v2_kurikulum');
		$this->db->where('KodeJurusan',$kode);
		$this->db->where('NotActive',$active);

		return $this->db->get()->row();

	}

	public function getDetailTabel($kodeJur) {

		$this->db->select('mk.ID, mk.Kode, mk.Nama_Indonesia, mk.Nama_English, mk.SKS, mk.NotActive, mk.id_mk, mk.KodeJenisMK, k.Nama, k.id_kurikulum');
		$this->db->from('_v2_matakuliah mk');
		$this->db->join('_v2_kurikulum k', 'k.IdKurikulum = mk.KurikulumID', 'LEFT');
		$this->db->where('mk.KodeJurusan',$kodeJur);
		$this->db->order_by('mk.Kode','asc');

		return $this->db->get()->result();
		
	}

	public function getDataEdit($id) {

		$this->db->select('*');
		$this->db->from('_v2_matakuliah');
		$this->db->where('ID',$id);

		return $this->db->get()->row();

	}

	public function getId_sms($kodeJurusan) {

		$this->db->select('id_sms');
		$this->db->from('_v2_jurusan');
		$this->db->where('Kode',$kodeJurusan);

		return $this->db->get()->row();

	}

	public function get_kodefakul($kodeJur) {

		$this->db->select('KodeFakultas');
		$this->db->from('_v2_jurusan');
		$this->db->where('Kode',$kodeJur);

		return $this->db->get()->row();

	}

	public function checkData($idMK) {

		$this->db->select('Kode');
		$this->db->from('_v2_matakuliah');
		$this->db->where('IDMK',$idMK);

		return $this->db->get()->result();

	}

	public function insertData($data,$idMK) {

		$arrayJurusan = explode('-', $data['jurusan']);
		$kodeJur = $arrayJurusan[0];
		$kodeFakul = substr($kodeJur, 0, 1);

		if ( empty($data['tgl_mulai']) ) {

			$date_mulai = 0000-00-00;

		} else {

			$date_mulai = date('Y-m-d', strtotime($data['tgl_mulai']));

		}

		if ( empty($data['tgl_akhir']) ) {

			$date_akhir = 0000-00-00;

		} else {

			$date_akhir = date('Y-m-d', strtotime($data['tgl_akhir']));

		}

		$dataMatakuliah = array (
			'Kode' => $this->db->escape_str($data['kodeMK']),
			'Nama_Indonesia' => $this->db->escape_str($data['namaIndo']),
			'Nama_English' => $this->db->escape_str($data['namaEng']),
			'KodeFakultas' => $this->db->escape_str($kodeFakul),
			'KodeJurusan' => $this->db->escape_str($kodeJur),
			'IDMK' => $this->db->escape_str($idMK),
			'SKS' => $data['sksMK'],
			'SKSTatapMuka' => intval($data['sksTM']),
			'SKSPraktikum' => intval($data['sksP']),
			'SKSPraktekLap' => intval($data['sksPL']),
			'SKSSimulasi' => intval($data['sksS']),
			'KodeJenisMK' => $this->db->escape_str($data['jenisMK']),
			'KodeKelompokMK' => $this->db->escape_str($data['kelompokMK']),
			'metode_belajar' => $this->db->escape_str($data['metode_belajar']),
			'tgl_mulai' => $this->db->escape_str($date_mulai),
			'tgl_akhir' => $this->db->escape_str($date_akhir),
			'Login' => $this->db->escape_str($data['user']),
			'Tgl' => $data['tglnow'],
			'NotActive' => $this->db->escape_str($data['notactive']),
			'id_mk' => $this->db->escape_str($data['id_matkul']),
			'st_feeder' => 1			
		);

		$this->db->insert('_v2_matakuliah',$dataMatakuliah);

	}

	public function updateData($data) {

		$kodeFakul = substr($data['jurusan'], 0, 1);
		$idMK= $data['kodeMK'].$data['jurusan'];

		if ( empty($data['tgl_mulai']) ) {

			$date_mulai = 0000-00-00;

		} else {

			$date_mulai = date('Y-m-d', strtotime($data['tgl_mulai']));

		}

		if ( empty($data['tgl_akhir']) ) {

			$date_akhir = 0000-00-00;

		} else {

			$date_akhir = date('Y-m-d', strtotime($data['tgl_akhir']));

		}

		$dataMatakuliah = array (
			'Kode' => $this->db->escape_str($data['kodeMK']),
			'Nama_Indonesia' => $this->db->escape_str($data['namaIndo']),
			'Nama_English' => $this->db->escape_str($data['namaEng']),
			'KodeFakultas' => $this->db->escape_str($kodeFakul),
			'KodeJurusan' => $this->db->escape_str($data['jurusan']),
			'IDMK' => $this->db->escape_str($idMK),
			'SKS' => $data['sksMK'],
			'SKSTatapMuka' => intval($data['sksTM']),
			'SKSPraktikum' => intval($data['sksP']),
			'SKSPraktekLap' => intval($data['sksPL']),
			'SKSSimulasi' => intval($data['sksS']),
			'KodeJenisMK' => $this->db->escape_str($data['jenisMK']),
			'KodeKelompokMK' => $this->db->escape_str($data['kelompokMK']),
			'metode_belajar' => $this->db->escape_str($data['metode_belajar']),
			'tgl_mulai' => $this->db->escape_str($date_mulai),
			'tgl_akhir' => $this->db->escape_str($date_akhir),
			'Login' => $this->db->escape_str($data['user']),
			'Tgl' => $data['tglnow'],
			'NotActive' => $this->db->escape_str($data['notactive']),
			'id_mk' => $this->db->escape_str($data['id_mk']),
			'st_feeder' => $this->db->escape_str($data['feeder'])	
		);

		$this->db->where('ID',$data['id']);
		return $this->db->update('_v2_matakuliah',$dataMatakuliah);

	}

	public function updateData2($data) {

		$kodeFakul = substr($data['jurusan'], 0, 1);
		$idMK= $data['kodeMK'].$data['jurusan'];

		if ( empty($data['tgl_mulai']) ) {

			$date_mulai = 0000-00-00;

		} else {

			$date_mulai = date('Y-m-d', strtotime($data['tgl_mulai']));

		}

		if ( empty($data['tgl_akhir']) ) {

			$date_akhir = 0000-00-00;

		} else {

			$date_akhir = date('Y-m-d', strtotime($data['tgl_akhir']));

		}

		$dataMatakuliah = array (
			'Kode' => $this->db->escape_str($data['kodeMK']),
			'Nama_Indonesia' => $this->db->escape_str($data['namaIndo']),
			'Nama_English' => $this->db->escape_str($data['namaEng']),
			'KodeFakultas' => $this->db->escape_str($kodeFakul),
			'KodeJurusan' => $this->db->escape_str($data['jurusan']),
			'IDMK' => $this->db->escape_str($idMK),
			'SKS' => $data['sksMK'],
			'SKSTatapMuka' => intval($data['sksTM']),
			'SKSPraktikum' => intval($data['sksP']),
			'SKSPraktekLap' => intval($data['sksPL']),
			'SKSSimulasi' => intval($data['sksS']),
			'KodeJenisMK' => $this->db->escape_str($data['jenisMK']),
			'KodeKelompokMK' => $this->db->escape_str($data['kelompokMK']),
			'metode_belajar' => $this->db->escape_str($data['metode_belajar']),
			'tgl_mulai' => $this->db->escape_str($date_mulai),
			'tgl_akhir' => $this->db->escape_str($date_akhir),
			'Login' => $this->db->escape_str($data['user']),
			'Tgl' => $data['tglnow'],
			'NotActive' => $this->db->escape_str($data['notactive']),
			'id_mk' => $this->db->escape_str($data['id_mk'])
		);

		$this->db->where('ID',$data['id']);
		return $this->db->update('_v2_matakuliah',$dataMatakuliah);

	}

	public function deleteData($id) {

		$this->db->where('ID',$id);
		$this->db->delete('_v2_matakuliah');

	}

}