<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Helpdesk_model extends CI_Model {

	public function get_helpdesk() {

		$ulevel = $this->session->userdata("ulevel");
		$unip = $this->session->userdata("unip");

		$this->db->from('_v2_helpdesk');
		
		if ($ulevel == 5){
			$this->db->where('user_pengirim',$unip);
		}
		$this->db->where('NotActive','N');
		
		$this->db->order_by("id", "desc");

		return $this->db->get()->result();

	}

	public function get_user_helpdesk($act) {

		$uname = $this->session->userdata("unip");

	  $this->db->from('_v2_helpdesk');
		$this->db->where('id',$act);
		$this->db->where('NotActive','N');

	  return $this->db->get()->row();

	}

	public function getdetail_helpdesk($act) {

		$this->db->from('_v2_helpdesk_detail');
		$this->db->where('id_helpdesk',$act);
		$this->db->where('NotActive','N');

	  return $this->db->get()->result();

	}

	public function getDataMhsw($nim){

		$this->db->select('m.Name, m.Sex, s.Nama, s.Kode, j.Nama_Indonesia');
		$this->db->from('_v2_mhsw m');
		$this->db->join('_v2_jurusan j','m.KodeJurusan=j.Kode');
		$this->db->join('_v2_statusmhsw s','m.Status=s.Kode');
		$this->db->where('NIM',$nim);

		return $this->db->get()->row();

	}

	public function getCheckMhswSPP2($nim,$tahun) {

		$this->db->select('id');
		$this->db->from('_v2_spp2');
		$this->db->where('nim',$nim);
		$this->db->where('tahun',$tahun);

		return $this->db->get()->row();

	}

	public function getCheckPeriodeAktifSPP2() {

		$this->db->select('periode_aktif');
		$this->db->from('_v2_periode_aktif');
		$this->db->where('status','aktif');

		return $this->db->get()->row();

	}

	public function insertDataSPP2($data) {

		$dataSPP2 = array (
			'tahun' => intval($data['tahun']),
			'nim' => $this->db->escape_str($data['nim']),
			'Sex' => $this->db->escape_str($data['sex']),
			'bayar' => intval($data['bayar']),
			'StatusMhs' => $data['kodeStatus'],
			'KodeFakultas' => $this->db->escape_str($data['kodeFakultas']),
			'KodeJurusan' => $this->db->escape_str($data['kodeJurusan']),
			'beasiswa' => $this->db->escape_str($data['beasiswa']),
			'TotalBayar' => $data['rp'],
			'tgl' => $data['tgl']
		);

		$status = intval($data['status']);
		$periode = intval($data['tahun']);
		$nim = $this->db->escape_str($data['nim']);

		if ( $status == 1 ) {

			$this->db->insert('_v2_spp2',$dataSPP2);

			return $this->db->query(" UPDATE _v2_mhsw SET Status = 'A', StatusBayar = '$status', TahunStatus = '$periode'  WHERE NIM ='$nim' ");

		} elseif ( $status == 0 ) {

			return $this->db->insert('_v2_spp2',$dataSPP2);

		}

	}

	public function getBatasKRSAktif($kodeJurusan,$status,$program) {

		$this->db->select('ID, Tahun, KodeProgram, krsm, krss, ukrsm, ukrss');
		$this->db->from('_v2_bataskrs');
		$this->db->where('KodeJurusan',$kodeJurusan);
		$this->db->where('NotActive',$status);
		$this->db->where('KodeProgram',$program);

		return $this->db->get()->row();

	}

	public function getEditBatasKRS($id) {

		$this->db->select('*');
		$this->db->from('_v2_bataskrs');
		$this->db->where('ID',$id);

		return $this->db->get()->row();

	}

	public function getCheckKRSAktif($kodeJurusan,$tahun,$program) {

		$this->db->select('ID');
		$this->db->from('_v2_bataskrs');
		$this->db->where('KodeJurusan',$kodeJurusan);
		$this->db->where('Tahun',$tahun);
		$this->db->where('KodeProgram',$program);

		return $this->db->get()->row();

	}

	public function getListBerita() {

		$this->db->select('ID,Judul,Kategori,TglExp,Tgl,foto_berita');
		$this->db->from('_v2_berita');

		return $this->db->get()->result();

	}

	public function getTampilBerita() {

		$this->db->select('ID,Judul,Kategori,Konten,Author,TglExp,Tgl,foto_berita');
		$this->db->from('_v2_berita');
		$this->db->order_by('Tgl','desc');
		$this->db->limit(5);

		return $this->db->get()->result();

	}

	public function getBacaBerita($id) {

		$this->db->select('Judul,Kategori,Konten,Author,TglExp,Tgl,foto_berita');
		$this->db->from('_v2_berita');
		$this->db->where('ID', $id);

		return $this->db->get()->row();

	}

	public function getNamaFotoBerita($id) {

		$this->db->select('foto_berita');
		$this->db->from('_v2_berita');
		$this->db->where('ID',$id);

		return $this->db->get()->row();

	}

	public function getEditDataBerita($id) {

		$this->db->select('*');
		$this->db->from('_v2_berita');
		$this->db->where('ID',$id);

		return $this->db->get()->row();

	}

	public function getListBeritaKategori() {

		$this->db->select('Kategori');
		$this->db->from('_v2_beritaKategori');

		return $this->db->get()->result();

	}

	public function insertDataKRS($data) {

		if ( empty($data['id']) ) {

			$dataKRS = array(
				'Tahun' => intval($data['tahun']),
				'KodeJurusan' => $this->db->escape_str($data['jurusan']),
				'KodeProgram' => $this->db->escape_str($data['kodeProgram']),
				'krsm' => $data['krsm'],
				'krss' => $data['krss'],
				'ukrsm' => $data['ukrsm'],
				'ukrss' => $data['ukrss'],
				'MulaiBayar1' => $data['mulaiBayar1'],
				'AkhirBayar1' => $data['akhirBayar1'],
				'MulaiBayar2' => $data['mulaiBayar2'],
				'AkhirBayar2' => $data['akhirBayar2'],
				'Denda' => $this->db->escape_str($data['denda']),
				'HargaDenda' => intval($data['hargaDenda']),
				'NotActive' => $this->db->escape_str($data['notactive']),
				'Absen' => $data['absen'],
				'Tugas' => $data['tugas'],
				'UTS' => $data['uts'],
				'UAS' => $data['uas'],
				'SS' => $data['ss'],
				'Login' => $data['login']
			);

			return $this->db->insert('_v2_bataskrs',$dataKRS);

		} else {

			$dataKRS = array(
				'Tahun' => intval($data['tahun']),
				'KodeJurusan' => $this->db->escape_str($data['jurusan']),
				'KodeProgram' => $this->db->escape_str($data['kodeProgram']),
				'krsm' => $data['krsm'],
				'krss' => $data['krss'],
				'ukrsm' => $data['ukrsm'],
				'ukrss' => $data['ukrss'],
				'MulaiBayar1' => $data['mulaiBayar1'],
				'AkhirBayar1' => $data['akhirBayar1'],
				'MulaiBayar2' => $data['mulaiBayar2'],
				'AkhirBayar2' => $data['akhirBayar2'],
				'Denda' => $this->db->escape_str($data['denda']),
				'HargaDenda' => intval($data['hargaDenda']),
				'NotActive' => $this->db->escape_str($data['notactive']),
				'Absen' => $data['absen'],
				'Tugas' => $data['tugas'],
				'UTS' => $data['uts'],
				'UAS' => $data['uas'],
				'SS' => $data['ss'],
				'Login' => $data['login']
			);

			$id = $data['id'];

			$this->db->insert('_v2_bataskrs',$dataKRS);

			return $this->db->query(" UPDATE _v2_bataskrs SET NotActive = 'Y' WHERE ID ='$id' ");

		}


	}

	public function updateDataKRS($data,$id) {

		$dataKRS = array(
			'Tahun' => intval($data['tahun']),
			'KodeJurusan' => $this->db->escape_str($data['jurusan']),
			'KodeProgram' => $this->db->escape_str($data['kodeProgram']),
			'krsm' => $data['krsm'],
			'krss' => $data['krss'],
			'ukrsm' => $data['ukrsm'],
			'ukrss' => $data['ukrss'],
			'MulaiBayar1' => $data['mulaiBayar1'],
			'AkhirBayar1' => $data['akhirBayar1'],
			'MulaiBayar2' => $data['mulaiBayar2'],
			'AkhirBayar2' => $data['akhirBayar2'],
			'Denda' => $this->db->escape_str($data['denda']),
			'HargaDenda' => intval($data['hargaDenda']),
			'NotActive' => $this->db->escape_str($data['notactive']),
			'Absen' => $data['absen'],
			'Tugas' => $data['tugas'],
			'UTS' => $data['uts'],
			'UAS' => $data['uas'],
			'SS' => $data['ss'],
			'Login' => $data['login']
		);

		$this->db->where('ID',$id);
		return $this->db->update('_v2_bataskrs',$dataKRS);

	}

	public function insertBerita($data) {

		return $this->db->insert('_v2_berita',$data);

	}

	public function updateBerita($data,$id) {

		$this->db->where('ID', $id);
		return $this->db->update('_v2_berita',$data);

	}

	public function hapusDataBerita($id) {

		$this->db->where('ID',$id);
		return $this->db->delete('_v2_berita');

	}

}
