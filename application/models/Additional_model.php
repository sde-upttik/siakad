<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Additional_model extends CI_Model {
	
	public function get_dataSearch() {

		$this->db->select('Kode, Nama_Indonesia');
	    $this->db->from('_v2_jurusan');

	    return $this->db->get()->result_array();

	}

	public function get_dataSearchBatas($lvl, $user) {

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

	//function SPP2

	public function getDataMhsw($nim){
		
		$this->db->select('m.id_reg_pd, m.Name, m.Sex, s.Nama, s.Kode, j.Nama_Indonesia, m.IPK, m.TglLulus, m.TglSKYudisium, m.NomorSKYudisium, m.NomerIjazah');
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
			'keterangan' => $this->db->escape_str($data['keterangan']),
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


	// function Batas KRS

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

	public function getListBatasKRS($kodeJurusan,$limit) {

		$this->db->select('*');
		$this->db->from('_v2_bataskrs');
		$this->db->where('KodeJurusan',$kodeJurusan);
		$this->db->order_by('Tahun','Desc');
		$this->db->limit($limit);

		return $this->db->get()->result();

	}

	public function aktifkanBatasKRS($id,$data){
		
		$this->db->where('ID',$id);
		return $this->db->update('_v2_bataskrs',$data);
	
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
				'user_add' => $data['user'],
				'tgl_add' => $data['tglnow'],
				/*'MulaiBayar1' => $data['mulaiBayar1'],
				'AkhirBayar1' => $data['akhirBayar1'],
				'MulaiBayar2' => $data['mulaiBayar2'],
				'AkhirBayar2' => $data['akhirBayar2'],
				'Denda' => $this->db->escape_str($data['denda']),
				'HargaDenda' => intval($data['hargaDenda']),*/
				'NotActive' => $this->db->escape_str($data['notactive'])/*,
				'Absen' => $data['absen'],
				'Tugas' => $data['tugas'],
				'UTS' => $data['uts'],
				'UAS' => $data['uas'],
				'SS' => $data['ss'],
				'Login' => $data['login']*/
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
				'user_add' => $data['user'],
				'tgl_add' => $data['tglnow'],
				/*'MulaiBayar1' => $data['mulaiBayar1'],
				'AkhirBayar1' => $data['akhirBayar1'],
				'MulaiBayar2' => $data['mulaiBayar2'],
				'AkhirBayar2' => $data['akhirBayar2'],
				'Denda' => $this->db->escape_str($data['denda']),
				'HargaDenda' => intval($data['hargaDenda']),*/
				'NotActive' => $this->db->escape_str($data['notactive'])/*,
				'Absen' => $data['absen'],
				'Tugas' => $data['tugas'],
				'UTS' => $data['uts'],
				'UAS' => $data['uas'],
				'SS' => $data['ss'],
				'Login' => $data['login']*/
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
			'user_update' => $data['user'],
			'tgl_update' => $data['tglnow'],
			/*'MulaiBayar1' => $data['mulaiBayar1'],
			'AkhirBayar1' => $data['akhirBayar1'],
			'MulaiBayar2' => $data['mulaiBayar2'],
			'AkhirBayar2' => $data['akhirBayar2'],
			'Denda' => $this->db->escape_str($data['denda']),
			'HargaDenda' => intval($data['hargaDenda']),*/
			'NotActive' => $this->db->escape_str($data['notactive'])/*,
			'Absen' => $data['absen'],
			'Tugas' => $data['tugas'],
			'UTS' => $data['uts'],
			'UAS' => $data['uas'],
			'SS' => $data['ss'],
			'Login' => $data['login']*/
		);

		$this->db->where('ID',$id);
		return $this->db->update('_v2_bataskrs',$dataKRS);

	}


	// function Berita

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



	//function Daftar Lulus

	public function getListMhswLulus($lvl, $user) {

		if ( $lvl == 1 ) {

			$this->db->select('dl.st_feeder, dl.NIM, Name, TahunAkademik, ket_jenis_keluar, tgl_keluar, ket, dl.error_desc');
		    $this->db->from('_v2_daftarlulus_DO dl');
			$this->db->join('_v2_mhsw m', 'dl.NIM = m.NIM');
			$this->db->join('_v2_dikti_jenis_keluar jk', 'dl.id_jenis_keluar = jk.ID');

		    return $this->db->get()->result();

		} elseif ( $lvl == 5 ) {

			$this->db->select('ID, NIM, Name, TahunAkademik, TglLulus, NomorSKYudisium, TglSKYudisium');
		    $this->db->from('_v2_mhsw');
		    $this->db->where('Status', 'L');
		    $this->db->where('KodeFakultas', $user);

		    return $this->db->get()->result();

		} elseif ( $lvl == 7 ) {

			$this->db->select('ID, NIM, Name, TahunAkademik, TglLulus, NomorSKYudisium, TglSKYudisium');
		    $this->db->from('_v2_mhsw');
		    $this->db->where('Status', 'L');
		    $this->db->where('KodeJurusan', $user);

		    return $this->db->get()->result();

		}

	}

	public function getMhswKeluar($nim) {

		$this->db->select('m.id_reg_pd, do.NIM, m.Name, j.Nama_Indonesia, jk.ket_jenis_keluar, do.ket, do.id_jenis_keluar, do.ipk, do.tgl_keluar, do.tgl_sk_yudisium, do.no_sk_yudisium, do.nomor_ijazah');
		$this->db->from('_v2_daftarlulus_DO do');
		$this->db->join('_v2_mhsw m','do.NIM=m.NIM');
		$this->db->join('_v2_jurusan j','m.KodeJurusan=j.Kode');
		$this->db->join('_v2_dikti_jenis_keluar jk', 'do.id_jenis_keluar = jk.ID');
		$this->db->where('do.NIM',$nim);

		return $this->db->get()->row();		

	}

	public function getListJenisKeluar() {

		$this->db->select('*');
		$this->db->from('_v2_dikti_jenis_keluar');

		return $this->db->get()->result();

	}

	public function insertDataMhswKeluar($data) {

		$dataMhswKeluar = array(
			'NIM' => $this->db->escape_str($data['NIM']),
			'st_feeder' => 1,
			'id_jenis_keluar' => intval($data['id_jenis_keluar']),
			'tgl_keluar' => $data['tgl_keluar'],
			'ket' => $this->db->escape_str($data['ket']),
			'no_sk_yudisium' => $this->db->escape_str($data['no_sk_yudisium']),
			'tgl_sk_yudisium' => $data['tgl_sk_yudisium'],
			'ipk' => $data['ipk'],
			'nomor_ijazah' => $this->db->escape_str($data['nomor_ijazah'])
		);

		return $this->db->insert('_v2_daftarlulus_DO',$dataMhswKeluar);

	}

	public function updateDataMhswKeluar($data) {

		$dataMhswKeluar = array(
			'st_feeder' => 1,
			'id_jenis_keluar' => intval($data['keluar']),
			'tgl_keluar' => $data['tgl_keluar'],
			'ket' => $this->db->escape_str($data['ket']),
			'no_sk_yudisium' => $this->db->escape_str($data['no_sk']),
			'tgl_sk_yudisium' => $data['tgl_sk'],
			'ipk' => $data['ipk'],
			'nomor_ijazah' => $this->db->escape_str($data['no_ijazah'])
		);

		$this->db->where('NIM', $data['nim']);
		return $this->db->update('_v2_daftarlulus_DO',$dataMhswKeluar);

	}

	public function updateDataMhswKeluarPrc($data) {

		$dataMhswKeluar = array(
			'st_feeder' => 1
		);

		$this->db->where('NIM', $data);
		return $this->db->update('_v2_daftarlulus_DO',$dataMhswKeluar);

	}

	public function updateDataMhswKeluarPrc2($data) {

		$dataMhswKeluar = array(
			'st_feeder' => 2
		);

		$this->db->where('NIM', $data);
		return $this->db->update('_v2_daftarlulus_DO',$dataMhswKeluar);

	}

	public function updateErrorMhswKeluar($nim,$error_code,$error_desc) {

		$dataMhswKeluar = array(
			'error_code' => $this->db->escape_str($error_code),
			'error_desc' => $this->db->escape_str($error_desc)
		);

		$this->db->where('NIM', $nim);
		return $this->db->update('_v2_daftarlulus_DO',$dataMhswKeluar);

	}

	public function cekMhswKeluar($nim) {

		$this->db->select('NIM, st_feeder');
		$this->db->from('_v2_daftarlulus_DO');
		$this->db->where('NIM', $nim);

		return $this->db->get()->row();

	}

	public function getListKeluarPrc() {

		$this->db->select('m.id_reg_pd, do.st_feeder, m.TahunAkademik, do.NIM, m.Name, jk.ket_jenis_keluar, do.ket, do.id_jenis_keluar, do.ipk, do.tgl_keluar, do.tgl_sk_yudisium, do.no_sk_yudisium, do.nomor_ijazah, do.error_code, do.error_desc');
		$this->db->from('_v2_daftarlulus_DO do');
		$this->db->join('_v2_mhsw m','do.NIM=m.NIM','LEFT');
		$this->db->join('_v2_dikti_jenis_keluar jk', 'do.id_jenis_keluar = jk.ID');
		$this->db->where('m.id_reg_pd !=', '');
		$this->db->where('do.st_feeder', '0');
		$this->db->where('do.error_code', '');
		$this->db->limit(1000);

		return $this->db->get()->result_array();

	}

	public function getListKeluarUpdatePrc() {
		$this->db->select('m.id_reg_pd, do.st_feeder, m.TahunAkademik, do.NIM, m.Name, jk.ket_jenis_keluar, do.ket, do.id_jenis_keluar, do.ipk, do.tgl_keluar, do.tgl_sk_yudisium, do.no_sk_yudisium, do.nomor_ijazah, do.error_code, do.error_desc');
		$this->db->from('_v2_daftarlulus_DO do');
		$this->db->join('_v2_mhsw m','do.NIM=m.NIM','LEFT');
		$this->db->join('_v2_dikti_jenis_keluar jk', 'do.id_jenis_keluar = jk.ID');
		$this->db->where('m.id_reg_pd !=', '');
		$this->db->where('do.st_feeder', '1');
		$this->db->where('do.error_code', '');
		$this->db->limit(2000);

		return $this->db->get()->result_array();
	}

	public function get_pd($nim) {

		$this->db->select('id_pd');
		$this->db->from('_v2_mhsw');
		$this->db->where('NIM', $nim);

		return $this->db->get()->row();

	}

}