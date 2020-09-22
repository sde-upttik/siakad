<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai_transfer_model extends CI_Model {


	
	public function get_dataSearch($nim) {

		$this->db->select('m.id_pd, m.id_reg_pd, m.NIM, m.Name, m.KodeJurusan, m.SKSditerima, m.StatusAwal, m.TahunAkademik, m.KodeProgram, j.Nama_Indonesia, j.Ket_Jenjang ');
		$this->db->from('_v2_mhsw m');
		$this->db->join('_v2_jurusan j', 'j.Kode = m.KodeJurusan', 'LEFT');
		$this->db->where('m.NIM',$nim);

		return $this->db->get()->row();

	}

	public function get_NilaiTransfer($nim) {

		$this->db->select('ID, KodeMK_asal, NamaMK_asal, SKS_asal, GradeNilai_asal, KodeMK, NamaMK, SKS, GradeNilai, Bobot, Nilai, id_transfer');
		$this->db->from('_v2_krsTR');
		$this->db->where('NIM', $nim);

		return $this->db->get()->result();
		//return $this->db->last_query();

	}

	public function getNilaiByID($id) {
		
		$this->db->select('tr.ID, KodeMK_asal, NamaMK_asal, SKS_asal, GradeNilai_asal, KodeMK, NamaMK, tr.SKS, GradeNilai, Bobot, Nilai, id_transfer, concat(KodeMK, " -- ", NamaMK, " -- ", tr.SKS) AS mk_tampil, concat(m.id_mk," - ",tr.SKS," - ",KodeMK, " - ", NamaMK, " - ", m.IDMK) AS mk_value, concat(GradeNilai, " (",Bobot,")") AS nilaitampil, concat(GradeNilai," - ",Bobot) AS nilaivalue');
		$this->db->from('_v2_krsTR tr');
		$this->db->join('_v2_matakuliah m', 'tr.KodeMK = m.Kode', 'LEFT');
		$this->db->where('tr.ID', $id);

		return $this->db->get()->row();
		//return $this->db->last_query();
	}

	public function get_matakuliah($kodeJur) {
		
		$data = $this->db->query(" SELECT id_mk, IDMK, Kode, Nama_Indonesia, concat(Kode, ' -- ', Nama_Indonesia, ' -- ', SKS) AS mk, SKS FROM _v2_matakuliah m LEFT JOIN _v2_kurikulum k ON k.IdKurikulum=m.KurikulumID WHERE Kode != '' AND m.KodeJurusan LIKE '$kodeJur%' AND k.NotActive='N' AND m.id_mk !=''");

		return $data->result();

	}

	public function get_rule_nilai($ket,$kodeJur,$angkatan) {
		
		$data = $this->db->query(" SELECT concat(Nilai, ' (',Bobot,')') AS nilaitampil , AngkatanKebawah, AngkatanKeatas, Nilai, Bobot FROM _v2_nilai WHERE Kode LIKE '$ket' AND KodeJurusan = '$kodeJur' HAVING ($angkatan >= AngkatanKebawah AND $angkatan <= AngkatanKeatas) ORDER by Nilai Asc");

		return $data->result();

	}

	public function insertData($data) {

		$dataTransfer = array(
			'NIM' => $this->db->escape_str($data['nim']),
			'st_feeder' => 3,
			'Tahun' => 'TR',
			'IDMK' => $this->db->escape_str($data['IDMK']),
			'KodeMK' => $this->db->escape_str($data['kodeMK']),
			'NamaMK' => $this->db->escape_str($data['namaMK']),
			'SKS' => $data['sks'],
			'Program' => $this->db->escape_str($data['program']),
			'Tanggal' => $data['tglnow'],
			'GradeNilai' => $this->db->escape_str($data['grade']),
			'Bobot' => $data['bobot'],
			'unip' => $this->db->escape_str($data['user']),
			'NotActive' => $this->db->escape_str($data['notactive']),
			'useredt' => '',
			'tgledt' => NULL,
			'KodeMK_asal' => $this->db->escape_str($data['kodeMKasal']),
			'NamaMK_asal' => $this->db->escape_str($data['namaMKasal']),
			'SKS_asal' => intval($data['SKSasal']),
			'GradeNilai_asal' => $this->db->escape_str($data['grade_asal']),
			'id_transfer' => $this->db->escape_str($data['id_transfer'])
		);
		$this->db->insert('_v2_krsTR',$dataTransfer);
		return $this->db->error();
		
	}

	public function updateData($data) {

		$dataTransfer = array(
			'NIM' => $this->db->escape_str($data['nim']),
			'st_feeder' => 3,
			'Tahun' => 'TR',
			'IDMK' => $this->db->escape_str($data['IDMK']),
			'KodeMK' => $this->db->escape_str($data['kodeMK']),
			'NamaMK' => $this->db->escape_str($data['namaMK']),
			'SKS' => $data['sks'],
			'Program' => $this->db->escape_str($data['program']),
			'GradeNilai' => $this->db->escape_str($data['grade']),
			'Bobot' => $data['bobot'],
			'NotActive' => $this->db->escape_str($data['notactive']),
			'useredt' => $this->db->escape_str($data['user']),
			'tgledt' => $data['tglnow'],
			'KodeMK_asal' => $this->db->escape_str($data['kodeMKasal']),
			'NamaMK_asal' => $this->db->escape_str($data['namaMKasal']),
			'SKS_asal' => intval($data['SKSasal']),
			'GradeNilai_asal' => $this->db->escape_str($data['grade_asal'])
		);

		$this->db->where('id_transfer',$data['id_reg']);
		return $this->db->update('_v2_krsTR',$dataTransfer);
		
	}

	public function updateData2($data) {

		$dataTransfer = array(
			'NIM' => $this->db->escape_str($data['nim']),
			'st_feeder' => 3,
			'Tahun' => 'TR',
			'IDMK' => $this->db->escape_str($data['IDMK']),
			'KodeMK' => $this->db->escape_str($data['kodeMK']),
			'NamaMK' => $this->db->escape_str($data['namaMK']),
			'SKS' => $data['sks'],
			'Program' => $this->db->escape_str($data['program']),
			'GradeNilai' => $this->db->escape_str($data['grade']),
			'Bobot' => $data['bobot'],
			'NotActive' => $this->db->escape_str($data['notactive']),
			'useredt' => $this->db->escape_str($data['user']),
			'tgledt' => $data['tglnow'],
			'KodeMK_asal' => $this->db->escape_str($data['kodeMKasal']),
			'NamaMK_asal' => $this->db->escape_str($data['namaMKasal']),
			'SKS_asal' => intval($data['SKSasal']),
			'GradeNilai_asal' => $this->db->escape_str($data['grade_asal']),
			'id_transfer' => $this->db->escape_str($data['id_transfer'])
		);

		$this->db->where('ID', $data['id']);
		return $this->db->update('_v2_krsTR',$dataTransfer);
		
	}

	public function deleteData($id) {

		$this->db->where('ID',$id);
		return $this->db->delete('_v2_krsTR');

	}

}