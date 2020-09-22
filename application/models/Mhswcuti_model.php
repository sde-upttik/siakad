<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mhswcuti_model extends CI_Model {

	//mengambil data dari database untuk search
	public function caridata($nim){
		$query = $this->db->query("SELECT m.*, 
										  f.Nama_Indonesia as FAK, 
										  j.Nama_Indonesia as JUR, 
										  jj.Nama as JEN, concat(d.Name, ', ', d.Gelar) as DSN from _v2_mhsw m left outer join fakultas f on 
	  							   		  m.KodeFakultas=f.Kode left outer join _v2_jurusan j on 
	  							   		  m.KodeJurusan=j.Kode left outer join jenjangps jj on 
	  							   		  j.Jenjang=jj.Kode left outer join _v2_dosen d on 
	  							   		  m.DosenID=d.nip where m.NIM='$nim' ");
		
		return $query->result_array();
	} 

	// mengambil data dari database untuk menampilkan ke tabel 
	public function get_mhsw_cuti(){
		$data = $this->db->query("SELECT r.NIM, 
										 m.Name, 
										 m.KodeProgram, 
										 f.Nama_Indonesia as nmf, 
										 j.Nama_Indonesia as nmj, 
										 r.periode from _v2_riwayat_cuti r left join _v2_mhsw m on 
										 r.NIM=m.NIM left join fakultas f on 
										 m.KodeFakultas=f.Kode left join _v2_jurusan j on 
										 m.KodeJurusan=j.Kode");
		
		return $data->result_array();

	}

	public function datadaftar($nim){
		$data = $this->db->query("SELECT   m.LamaStudiThn,
										   m.LamaStudiBln,
										   m.Predikat,
										   m.Tanggal,
										   m.TglIjazah,
										   m.ipk,
										   m.LamaStudiHari,
										   m.TotalSKS,
										   m.NomerIjazah,
										   m.TglSKYudisium,
										   m.NomorSKYudisium,
										   m.TahunStatus,
										   m.NIM, 
										   m.Name, 
										   m.TotalSKS, 
										   m.TA, 
										   m.TglTA,
										   m.Proposal,
										   m.TglProposal,
										   m.Skripsi,
										   m.TglSkripsi,
										   m.JudulTA,
										   m.JudulTA2, 
										   sm.Nama as STA, 
										   m.Lulus,
										   m.PengujiTA1 as DSN1,
										   m.PengujiTA2 as DSN2,
										   m.PengujiTA3 as DSN3,
										   m.PengujiTA4 as DSN4,
										   m.PengujiTA5 as DSN5,
										   m.PengujiTA6 as DSN6,
										   m.PengujiTA7 as DSN7,
										   m.PembimbingTA as PTA,
										   m.PembimbingTA2 as PTA2 from _v2_mhsw m left outer join _v2_statusmhsw sm on m.Status=sm.Kode
								  where m.NIM='$nim' Limit 1");

		return $data->result_array();
	}  

	public function datadosen(){
		$dt_dosen = $this->db->query("SELECT Name from _v2_dosen");
		return $dt_dosen->result_array();

	}

	public function getNumRows($query){
		$data = $this->db->query($query);
		return $data->num_rows();
	}

	public function insertquery($qInsert){
		$query = $this->db->query($qInsert);

		if($query){
			return TRUE;
		}else{
			return FALSE;
		}
	}

}	