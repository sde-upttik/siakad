<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil_model extends CI_Model {

	public function getDataAgama() {

		$this->db->select('AgamaID, Agama');
		$this->db->from('_v2_agama');
		$this->db->where('NotActive', 'N');

		return $this->db->get()->result();

	}

	public function getDataNegara() {

		$this->db->select('Kode_Negara, Nama_Negara');
		$this->db->from('_v2_dikti_negara');

		return $this->db->get()->result();

	}

	public function getDataTabel($tabel,$login) {

		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where('Login',$login);

		return $this->db->get()->row();

	}

	public function getDataWilayah($kode_negara) {
		
		$this->db->select('id, nama_wilayah');
		$this->db->from('_v2_dikti_wilayah');
		$this->db->where('kode_negara', $kode_negara);

		return $this->db->get()->result();

	}

	public function getDataAlat() {
		
		$this->db->select('id, nama_transportasi');
		$this->db->from('_v2_dikti_alat_transportasi');

		return $this->db->get()->result();

	}	

	public function getDataTinggal() {
		
		$this->db->select('id, nama_jenis_tinggal');
		$this->db->from('_v2_dikti_jenis_tinggal');

		return $this->db->get()->result();

	}

	public function getDataDosen($field,$jurusan) {

		$this->db->select('nip, Name');
		$this->db->from('_v2_dosen');
		$this->db->where($field, $jurusan);
		$this->db->where('NotActive', 'N');

		return $this->db->get()->result();

	}

	public function getDataTabelJoinMhsw($tabel,$login) {

		$this->db->select('aj.*, a.Agama, n.Nama_Negara, w.nama_wilayah, jt.nama_jenis_tinggal, at.nama_transportasi, j.Nama_Indonesia as jurusan, f.Nama_Indonesia as fakultas, d.nip, d.Name as dosen');
		$this->db->from($tabel.' as aj');
		$this->db->join('_v2_agama a','aj.AgamaID=a.AgamaID','LEFT');
		$this->db->join('_v2_jurusan j','aj.KodeJurusan=j.Kode','LEFT');
		$this->db->join('fakultas f','aj.KodeFakultas=f.Kode','LEFT');
		$this->db->join('_v2_dikti_negara n','aj.Kewarganegaraan=n.Kode_Negara','LEFT');
		$this->db->join('_v2_dikti_wilayah w','aj.Kecamatan=w.id','LEFT');
		$this->db->join('_v2_dikti_jenis_tinggal jt','aj.JenisTinggal=jt.id','LEFT');
		$this->db->join('_v2_dikti_alat_transportasi at','aj.AlatTransportasi=at.id','LEFT');
		$this->db->join('_v2_dosen d','aj.DosenID=d.nip','LEFT');
		$this->db->where('aj.Login',$login);

		return $this->db->get()->row();

	}

	public function getDataTabelJoinAdm($tabel,$login) {

		$this->db->select('aj.*, a.Agama, j.Nama_Indonesia as jurusan, f.Nama_Indonesia as fakultas');
		$this->db->from($tabel.' as aj');
		$this->db->join('_v2_agama a','aj.AgamaID=a.AgamaID','LEFT');
		$this->db->join('_v2_jurusan j','aj.KodeJurusan=j.Kode','LEFT');
		$this->db->join('fakultas f','aj.KodeFakultas=f.Kode','LEFT');
		$this->db->where('aj.Login',$login);

		return $this->db->get()->row();

	}

	public function getDataNIM($id) {

		$this->db->select('m.NIM, m.Tanggal, m.StatusAwal, m.Semester, j.id_sms');
		$this->db->from('_v2_mhsw m');
		$this->db->join('_v2_jurusan j','m.KodeJurusan=j.Kode','LEFT');
		$this->db->where('m.ID',$id);

		return $this->db->get()->row();

	}

	public function updateIdPD ($id,$id_pd,$tabel) {

		$dataUpdate = array(
			'id_pd' => $id_pd
		);

		$this->db->where('ID',$id);
		return $this->db->update($tabel,$dataUpdate);

	}

	public function get_idpd_siakad($nama,$sex,$tmp,$tgl,$ibu,$agama){

		$Nama = $this->db->escape_str($nama);
		$Ibu = $this->db->escape_str($ibu);

		$data = $this->db->query(" SELECT id_pd FROM _v2_mhsw WHERE Name='$Nama' AND Sex='$sex' AND TempatLahir='$tmp' AND TglLahir='$tgl' AND AgamaID='$agama' AND NamaIbu='$Ibu' AND id_pd!='' ");

		return $data->row();

	}

	public function updateIdREG ($id,$id_reg,$tabel) {

		$dataUpdate = array(
			'id_reg_pd' => $id_reg,
			'st_feeder' => 1
		);

		$this->db->where('ID',$id);
		$this->db->update($tabel,$dataUpdate);

	}

	public function updateData($data, $act, $tabel) {

		$id = intval($data['id']);

		if ( $act == 'dataMhsw' ) {

			$dataUpdate = array (
				'Name' => $this->db->escape_str($data['nama']),
				'TempatLahir' => $this->db->escape_str($data['tmpLahir']),
				'TglLahir' => $data['tglLahir'],
				'Sex' => $data['sex'],
				'AgamaID' => intval($data['agama']),
				'NamaIbu' => $this->db->escape_str($data['ibu']),
				'NIK' => intval($data['nik']),
				'NISN' => $this->db->escape_str($data['nisn']),
				'NPWP' => $this->db->escape_str($data['npwp']),
				'Alamat' => $this->db->escape_str($data['alamat']),
				'Kewarganegaraan' => $this->db->escape_str($data['negara']),
				'Dusun' => $this->db->escape_str($data['dusun']),
				'RT' => $this->db->escape_str($data['rt']),
				'RW' => $this->db->escape_str($data['rw']),
				'KodePos' => $this->db->escape_str($data['kodepos']),
				'Kelurahan' => $this->db->escape_str($data['kelurahan']),
				'Kecamatan' => $this->db->escape_str($data['kecamatan']),
				'JenisTinggal' => intval($data['jnsTinggal']),
				'AlatTransportasi' => intval($data['alatTrans']),
				'Phone' => $this->db->escape_str($data['telepon']),
				'HP' => $this->db->escape_str($data['hp']),
				'Email' => $this->db->escape_str($data['email']),
				'penerimaKPS' => intval($data['kps']),
				'nomorKPS' => $this->db->escape_str($data['noKPS']),
				'Semester' => intval($data['awalMasuk']),
				'TipePembayaran' => $this->db->escape_str($data['bayarSPP']),
				'KetPembayaran' => $this->db->escape_str($data['ketSPP']),
				'count_edit_password' => 1
			);

		} elseif ( $act == 'dataOrtuMhsw' ) {

			$dataUpdate = array (
				'NamaOT' => $this->db->escape_str($data['bapak'])		
			);

		} elseif ( $act == 'dataAkademik' ) {

			$dataUpdate = array (
				'DosenID' => $data['dosenWali']		
			);

		} elseif ( $act == 'dataDosen') {

			if ( empty($data['gelarDpn']) ) {

				$gelarDpn = "";

			} else {
				if ( stristr($data['gelarDpn'], '.') == FALSE ) {

					$gelarDpn = $data['gelarDpn'].".";

				} else {

					$gelarDpn = $data['gelarDpn'];

				}
			}

			if ( empty($data['gelarBlk']) ) {

				$gelarBlk = "";
				$namaAsli = $data['namaAsli'];

			} else {
				if ( (stristr($data['gelarBlk'], ',') == FALSE) && (stristr($data['namaAsli'], ',') == FALSE) ) {

					$namaAsli = $data['namaAsli'].",";

				} else {

					$namaAsli = $data['namaAsli'];

				}
			}


			$namaLengkap = $gelarDpn." ".$namaAsli. " ".$data['gelarBlk'];



			$dataUpdate = array (
				'NIK' => intval($data['nik']),
				'NPWP' => intval($data['npwp']),
				'Name' => $namaLengkap,
				'nama_asli' => $this->db->escape_str($data['namaAsli']),
				'glr_depan' => $this->db->escape_str($data['gelarDpn']),
				'glr_belakang' => $this->db->escape_str($data['gelarBlk']),
				'TempatLahir' => $this->db->escape_str($data['tmpLahir']),
				'TglLahir' => $data['tglLahir'],
				'AgamaID' => intval($data['agama']),
				'Alamat' => $this->db->escape_str($data['alamat']),
				'RT' => $this->db->escape_str($data['rt']),
				'RW' => $this->db->escape_str($data['rw']),
				'Kelurahan' => $this->db->escape_str($data['kelurahan']),
				'Kecamatan' => $this->db->escape_str($data['kecamatan']),
				'Phone' => $this->db->escape_str($data['telepon']),
				'Hp' => $this->db->escape_str($data['hp']),
				'Email' => $this->db->escape_str($data['email']),
				'Sex' => $data['sex']			
			);

		} elseif ( $act == 'dataDosenPegawai' ) {

			$dataUpdate = array (
				'nip' => intval($data['nip']),
				'NIDN_NUP_NIDK' => intval($data['nidn'])		
			);

		} elseif ( $act == 'dataOrtuDosen' ) {

			$dataUpdate = array (
				'NamaBapak' => $this->db->escape_str($data['bapak']),
				'NamaIbu' => $this->db->escape_str($data['ibu'])		
			);

		} elseif ( $act == 'dataAdmJurusan' ) {

			$dataUpdate = array (
				'Name' => $this->db->escape_str($data['nama']),
				'TempatLahir' => $this->db->escape_str($data['tmpLahir']),
				'TglLahir' => $data['tglLahir'],
				'AgamaID' => intval($data['agama']),
				'Alamat' => $this->db->escape_str($data['alamat']),
				'Phone' => $this->db->escape_str($data['telepon']),
				'HP' => $this->db->escape_str($data['hp']),
				'Email' => $this->db->escape_str($data['email']),
				'Sex' => $data['sex']			
			);

		} elseif ( $act == 'dataAdmFakultas' ) {

			$dataUpdate = array (
				'Name' => $this->db->escape_str($data['nama']),
				'TempatLahir' => $this->db->escape_str($data['tmpLahir']),
				'TglLahir' => $data['tglLahir'],
				'AgamaID' => intval($data['agama']),
				'Alamat' => $this->db->escape_str($data['alamat']),
				'Phone' => $this->db->escape_str($data['telepon']),
				'HP' => $this->db->escape_str($data['hp']),
				'Email' => $this->db->escape_str($data['email']),
				'Sex' => $data['sex']			
			);

		} elseif ( $act == 'dataAdmSuperuser' ) {

			$dataUpdate = array (
				'Name' => $this->db->escape_str($data['nama']),
				'Phone' => $this->db->escape_str($data['telepon']),
				'Email' => $this->db->escape_str($data['email']),
				'Sex' => $data['sex'],
				'count_edit_password' => 1
			);

		}

		$this->db->where('ID',$id);
		return $this->db->update($tabel,$dataUpdate);

	}
	
	public function cekpass($id,$pass,$tabel) {

		$this->db->select('Password');
		$this->db->from($tabel);
		$this->db->where('ID', $id);
		$this->db->where('Password','LEFT(PASSWORD("'.$pass.'"),10)',FALSE);

		return $this->db->get()->num_rows();

	}

	public function updatePass($data, $tabel) {

		$this->db->where('ID', $data['id']);
		$this->db->set('Password','LEFT(PASSWORD("'.$data['passBaru'].'"),10)',FALSE);
		$this->db->set('count_edit_password', 1);

		return $this->db->update($tabel);

	}

}