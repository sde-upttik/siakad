<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kurikulum_model extends CI_Model {


	
	public function getKurikulum($kodeJur) {

		$kode = $this->db->escape_str($kodeJur);

		$data = $this->db->query(" SELECT k.ID, k.IdKurikulum, k.JmlSesi, k.Sesi, k.Nama, k.Tahun, k.KodeJurusan ,j.Nama_Indonesia, k.id_kurikulum, k.NotActive  FROM _v2_kurikulum k LEFT JOIN _v2_jurusan j ON k.KodeJurusan=j.Kode WHERE k.KodeJurusan = '$kode' AND k.NotActive='N' ");

		return $data->row();

	}

	public function getTabelKurikulum($kodeJur) {

		$kode = $this->db->escape_str($kodeJur);

		$data = $this->db->query(" SELECT ID, Nama, Tahun, NotActive, KodeJurusan, id_kurikulum FROM _v2_kurikulum WHERE KodeJurusan = '$kode' ");

		return $data->result();

	}

	public function getKurikulumActive($kodeJur,$active) {

		$kode = $this->db->escape_str($kodeJur);
		$active = $this->db->escape_str($active);

		$data = $this->db->query(" SELECT ID, NotActive FROM _v2_kurikulum WHERE KodeJurusan = '$kode' AND NotActive = '$active' ");

		return $data->row();

	}

	public function getKurikulumById($id) {

		$id = intval($id);

		$data = $this->db->query(" SELECT * FROM _v2_kurikulum WHERE ID = '$id' ");

		return $data->row();

	}

	public function getMaxIdKurikulum($kodeFakul) {

		$kode = $this->db->escape_str($kodeFakul);

		$data = $this->db->query(" SELECT max(IdKurikulum) FROM _v2_kurikulum WHERE KodeJurusan LIKE '$kode%' ");

		return $data->result();

	}

	public function getIdKurikulum($kodeJur,$tahun) {

		$kode = $this->db->escape_str($kodeJur);
		$tahun = intval($tahun);

		$data = $this->db->query(" SELECT IdKurikulum, Nama FROM _v2_kurikulum WHERE KodeJurusan = '$kode' AND Tahun = '$tahun' ");

		return $data->row();

	}

	public function getTabelJurusan($kode,$like) {

		if ( empty($like) ) {

			$data = $this->db->query(" SELECT ju.Kode, ju.Nama_Indonesia, ju.Ket_Jenjang, ju.NotActive, je.Nama AS JenjangPS FROM _v2_jurusan ju LEFT OUTER JOIN _v2_jenjangps je ON ju.Jenjang = je.Kode WHERE ju.KodeFakultas LIKE '$kode%' ORDER BY ju.Jenjang, ju.kode ");
			return $data->result();

		} else {

			$data = $this->db->query(" SELECT ju.Kode, ju.Nama_Indonesia, ju.Ket_Jenjang, ju.NotActive, je.Nama AS JenjangPS FROM _v2_jurusan ju LEFT OUTER JOIN _v2_jenjangps je ON ju.Jenjang = je.Kode WHERE ju.KodeFakultas LIKE '$kode%' AND ju.Kode <= '$like%' ORDER BY ju.Jenjang, ju.kode ");
			return $data->result();

		}

	}

	public function getJurusanUser($tabel,$login) {

		$data = $this->db->query(" SELECT kodeJurusan FROM $tabel WHERE Login = '$login' ");

		return $data->row();

	}

	public function getDetailJurusan($kodeJurusan) {

		$this->db->select('Kode,id_sms,Jenjang,JmlSesi,Nama_Indonesia');
		$this->db->from('_v2_jurusan');
		$this->db->where('Kode',$this->db->escape_str($kodeJurusan));

		return $this->db->get()->row();

	}

	public function getFakultasUser($tabel,$login) {

		$data = $this->db->query(" SELECT kodeFakultas FROM $tabel WHERE Login = '$login' ");

		return $data->row();

	}

	public function insertData($dataInsert,$idaktif) {

		$id = intval($dataInsert['id']);
		$kode = $this->db->escape_str($dataInsert['kode'][0]);
		$jmlsesi = $this->db->escape_str($dataInsert['jmlsesi']);
		$tglnow = $this->db->escape_str($dataInsert['tglnow']);

		$dataKurikulum = array(
			'Tahun' => intval($dataInsert['tahun']),
			'IdKurikulum' => $this->db->escape_str($dataInsert['idKurikulum']),
			'KodeJurusan' => $this->db->escape_str($dataInsert['kode'][0]),
			'NotActive' => $this->db->escape_str($dataInsert['notactive']),
			'Nama' => $this->db->escape_str($dataInsert['nama']),
			'Sesi' => $this->db->escape_str($dataInsert['sesi']),
			'JmlSesi' => $this->db->escape_str($dataInsert['jmlsesi']),
			'jml_sks_lulus' => intval($dataInsert['skslulus']),
			'jml_sks_wajib' => intval($dataInsert['skswajib']),
			'jml_sks_pilihan' => intval($dataInsert['skspilihan']),
			'id_smt_berlaku' => intval($dataInsert['smtberlaku']),
			'Login' => $this->db->escape_str($dataInsert['user']),
			'Tgl' => $dataInsert['tglnow'],
			'id_kurikulum' => $dataInsert['id_kurikulum']
		);

		$dataKurikulumAktif = array(
			'Tahun' => intval($dataInsert['tahun']),
			'IdKurikulum' => $this->db->escape_str($dataInsert['idKurikulum']),
			'KodeJurusan' => $this->db->escape_str($dataInsert['kode'][0]),
			'NotActive' => 'N',
			'Nama' => $this->db->escape_str($dataInsert['nama']),
			'Sesi' => $this->db->escape_str($dataInsert['sesi']),
			'JmlSesi' => $this->db->escape_str($dataInsert['jmlsesi']),
			'jml_sks_lulus' => intval($dataInsert['skslulus']),
			'jml_sks_wajib' => intval($dataInsert['skswajib']),
			'jml_sks_pilihan' => intval($dataInsert['skspilihan']),
			'id_smt_berlaku' => intval($dataInsert['smtberlaku']),
			'Login' => $this->db->escape_str($dataInsert['user']),
			'Tgl' => $dataInsert['tglnow'],
			'id_kurikulum' => $dataInsert['id_kurikulum']
		);

		if ( empty($idaktif) ) {

			if ( $dataInsert['notactive'] == 'Y' ) {

				$this->db->insert('_v2_kurikulum', $dataKurikulum);

			} else {

				$this->db->insert('_v2_kurikulum', $dataKurikulum);
				$this->db->query(" UPDATE _v2_jurusan SET JmlSesi = '$jmlsesi' WHERE Kode ='$kode' ");

			}

		} elseif ( $idaktif == 'aktif' ) {

			$this->db->insert('_v2_kurikulum', $dataKurikulumAktif);
			$this->db->query(" UPDATE _v2_jurusan SET JmlSesi = '$jmlsesi' WHERE Kode ='$kode' ");

		} else {

			$this->db->insert('_v2_kurikulum', $dataKurikulum);
			$this->db->query(" UPDATE _v2_jurusan SET JmlSesi = '$jmlsesi' WHERE Kode ='$kode' ");
			$this->db->query(" UPDATE _v2_kurikulum SET NotActive = 'Y', TglNA = '$tglnow' WHERE ID ='$idaktif' ");
			
		}

	}

	public function updateData($dataUpdate,$idaktif) {

		$id = intval($dataUpdate['id']);
		$tahun = intval($dataUpdate['tahun']);
		$kode = $this->db->escape_str($dataUpdate['kode'][0]);
		$notactive = $this->db->escape_str($dataUpdate['notactive']);
		$jmlsesi = $this->db->escape_str($dataUpdate['jmlsesi']);
		$tglnow = $this->db->escape_str($dataUpdate['tglnow']);

		if ( empty($dataUpdate['id_kurikulum']) ) {

			if ( empty($idaktif) ) {

				if ( $notactive == 'Y' ) {

					$dataKurikulumNotActive = array(
						'Tahun' => intval($dataUpdate['tahun']),
						'KodeJurusan' => $this->db->escape_str($dataUpdate['kode'][0]),
						'NotActive' => $this->db->escape_str($dataUpdate['notactive']),
						'Nama' => $this->db->escape_str($dataUpdate['nama']),
						'Sesi' => $this->db->escape_str($dataUpdate['sesi']),
						'JmlSesi' => $this->db->escape_str($dataUpdate['jmlsesi']),
						'jml_sks_lulus' => intval($dataUpdate['skslulus']),
						'jml_sks_wajib' => intval($dataUpdate['skswajib']),
						'jml_sks_pilihan' => intval($dataUpdate['skspilihan']),
						'id_smt_berlaku' => intval($dataUpdate['smtberlaku']),
						'Login' => $this->db->escape_str($dataUpdate['user'])
					);


					$this->db->where('ID',$id);
					$this->db->update('_v2_kurikulum', $dataKurikulumNotActive);

				} else {

					$dataKurikulum = array(
						'Tahun' => intval($dataUpdate['tahun']),
						'KodeJurusan' => $this->db->escape_str($dataUpdate['kode'][0]),
						'NotActive' => $this->db->escape_str($dataUpdate['notactive']),
						'Nama' => $this->db->escape_str($dataUpdate['nama']),
						'Sesi' => $this->db->escape_str($dataUpdate['sesi']),
						'JmlSesi' => $this->db->escape_str($dataUpdate['jmlsesi']),
						'jml_sks_lulus' => intval($dataUpdate['skslulus']),
						'jml_sks_wajib' => intval($dataUpdate['skswajib']),
						'jml_sks_pilihan' => intval($dataUpdate['skspilihan']),
						'id_smt_berlaku' => intval($dataUpdate['smtberlaku']),
						'Login' => $this->db->escape_str($dataUpdate['user']),
						'TglNA' => $dataUpdate['tglnow']
					);

					$this->db->where('ID',$id);
					$this->db->update('_v2_kurikulum', $dataKurikulum);
					$this->db->query(" UPDATE _v2_jurusan SET JmlSesi = '$jmlsesi' WHERE Kode ='$kode' ");

				}

			} elseif ( $idaktif == 'aktif' ) {

				$dataKurikulumActive = array(
					'Tahun' => intval($dataUpdate['tahun']),
					'KodeJurusan' => $this->db->escape_str($dataUpdate['kode'][0]),
					'NotActive' => 'N',
					'Nama' => $this->db->escape_str($dataUpdate['nama']),
					'Sesi' => $this->db->escape_str($dataUpdate['sesi']),
					'JmlSesi' => $this->db->escape_str($dataUpdate['jmlsesi']),
					'jml_sks_lulus' => intval($dataUpdate['skslulus']),
					'jml_sks_wajib' => intval($dataUpdate['skswajib']),
					'jml_sks_pilihan' => intval($dataUpdate['skspilihan']),
					'id_smt_berlaku' => intval($dataUpdate['smtberlaku']),
					'Login' => $this->db->escape_str($dataUpdate['user'])
				);

				$this->db->where('ID',$id);
				$this->db->update('_v2_kurikulum', $dataKurikulumActive);
				$this->db->query(" UPDATE _v2_jurusan SET JmlSesi = '$jmlsesi' WHERE Kode ='$kode' ");

			} else {

				$dataKurikulum = array(
					'Tahun' => intval($dataUpdate['tahun']),
					'KodeJurusan' => $this->db->escape_str($dataUpdate['kode'][0]),
					'NotActive' => $this->db->escape_str($dataUpdate['notactive']),
					'Nama' => $this->db->escape_str($dataUpdate['nama']),
					'Sesi' => $this->db->escape_str($dataUpdate['sesi']),
					'JmlSesi' => $this->db->escape_str($dataUpdate['jmlsesi']),
					'jml_sks_lulus' => intval($dataUpdate['skslulus']),
					'jml_sks_wajib' => intval($dataUpdate['skswajib']),
					'jml_sks_pilihan' => intval($dataUpdate['skspilihan']),
					'id_smt_berlaku' => intval($dataUpdate['smtberlaku']),
					'Login' => $this->db->escape_str($dataUpdate['user']),
					'TglNA' => $dataUpdate['tglnow']
				);

				$this->db->where('ID',$id);
				$this->db->update('_v2_kurikulum', $dataKurikulum);
				$this->db->query(" UPDATE _v2_jurusan SET JmlSesi = '$jmlsesi' WHERE Kode ='$kode' ");
				$this->db->query(" UPDATE _v2_kurikulum SET NotActive = 'Y', TglNA = '$tglnow' WHERE ID ='$idaktif' ");
				
			}

		} else {

			if ( empty($idaktif) ) {

				if ( $notactive == 'Y' ) {

					$dataKurikulumNotActive = array(
						'Tahun' => intval($dataUpdate['tahun']),
						'KodeJurusan' => $this->db->escape_str($dataUpdate['kode'][0]),
						'NotActive' => $this->db->escape_str($dataUpdate['notactive']),
						'Nama' => $this->db->escape_str($dataUpdate['nama']),
						'Sesi' => $this->db->escape_str($dataUpdate['sesi']),
						'JmlSesi' => $this->db->escape_str($dataUpdate['jmlsesi']),
						'jml_sks_lulus' => intval($dataUpdate['skslulus']),
						'jml_sks_wajib' => intval($dataUpdate['skswajib']),
						'jml_sks_pilihan' => intval($dataUpdate['skspilihan']),
						'id_smt_berlaku' => intval($dataUpdate['smtberlaku']),
						'Login' => $this->db->escape_str($dataUpdate['user']),
						'id_kurikulum' => $dataUpdate['id_kurikulum']
					);


					$this->db->where('ID',$id);
					$this->db->update('_v2_kurikulum', $dataKurikulumNotActive);

				} else {

					$dataKurikulum = array(
						'Tahun' => intval($dataUpdate['tahun']),
						'KodeJurusan' => $this->db->escape_str($dataUpdate['kode'][0]),
						'NotActive' => $this->db->escape_str($dataUpdate['notactive']),
						'Nama' => $this->db->escape_str($dataUpdate['nama']),
						'Sesi' => $this->db->escape_str($dataUpdate['sesi']),
						'JmlSesi' => $this->db->escape_str($dataUpdate['jmlsesi']),
						'jml_sks_lulus' => intval($dataUpdate['skslulus']),
						'jml_sks_wajib' => intval($dataUpdate['skswajib']),
						'jml_sks_pilihan' => intval($dataUpdate['skspilihan']),
						'id_smt_berlaku' => intval($dataUpdate['smtberlaku']),
						'Login' => $this->db->escape_str($dataUpdate['user']),
						'TglNA' => $dataUpdate['tglnow'],
						'id_kurikulum' => $dataUpdate['id_kurikulum']
					);

					$this->db->where('ID',$id);
					$this->db->update('_v2_kurikulum', $dataKurikulum);
					$this->db->query(" UPDATE _v2_jurusan SET JmlSesi = '$jmlsesi' WHERE Kode ='$kode' ");

				}

			} elseif ( $idaktif == 'aktif' ) {

				$dataKurikulumActive = array(
					'Tahun' => intval($dataUpdate['tahun']),
					'KodeJurusan' => $this->db->escape_str($dataUpdate['kode'][0]),
					'NotActive' => 'N',
					'Nama' => $this->db->escape_str($dataUpdate['nama']),
					'Sesi' => $this->db->escape_str($dataUpdate['sesi']),
					'JmlSesi' => $this->db->escape_str($dataUpdate['jmlsesi']),
					'jml_sks_lulus' => intval($dataUpdate['skslulus']),
					'jml_sks_wajib' => intval($dataUpdate['skswajib']),
					'jml_sks_pilihan' => intval($dataUpdate['skspilihan']),
					'id_smt_berlaku' => intval($dataUpdate['smtberlaku']),
					'Login' => $this->db->escape_str($dataUpdate['user']),
					'id_kurikulum' => $dataUpdate['id_kurikulum']
				);

				$this->db->where('ID',$id);
				$this->db->update('_v2_kurikulum', $dataKurikulumActive);
				$this->db->query(" UPDATE _v2_jurusan SET JmlSesi = '$jmlsesi' WHERE Kode ='$kode' ");

			} else {

				$dataKurikulum = array(
					'Tahun' => intval($dataUpdate['tahun']),
					'KodeJurusan' => $this->db->escape_str($dataUpdate['kode'][0]),
					'NotActive' => $this->db->escape_str($dataUpdate['notactive']),
					'Nama' => $this->db->escape_str($dataUpdate['nama']),
					'Sesi' => $this->db->escape_str($dataUpdate['sesi']),
					'JmlSesi' => $this->db->escape_str($dataUpdate['jmlsesi']),
					'jml_sks_lulus' => intval($dataUpdate['skslulus']),
					'jml_sks_wajib' => intval($dataUpdate['skswajib']),
					'jml_sks_pilihan' => intval($dataUpdate['skspilihan']),
					'id_smt_berlaku' => intval($dataUpdate['smtberlaku']),
					'Login' => $this->db->escape_str($dataUpdate['user']),
					'TglNA' => $dataUpdate['tglnow'],
					'id_kurikulum' => $dataUpdate['id_kurikulum']
				);

				$this->db->where('ID',$id);
				$this->db->update('_v2_kurikulum', $dataKurikulum);
				$this->db->query(" UPDATE _v2_jurusan SET JmlSesi = '$jmlsesi' WHERE Kode ='$kode' ");
				$this->db->query(" UPDATE _v2_kurikulum SET NotActive = 'Y', TglNA = '$tglnow' WHERE ID ='$idaktif' ");
				
			}

		}
		
	}

	public function hapusData($id) {
		$this->db->where('ID',$id);
		$this->db->delete('_v2_kurikulum');
	}
	
}