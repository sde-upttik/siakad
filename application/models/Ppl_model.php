<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ppl_model extends CI_Model {

	// public function search($dataSearch){
 //        $this->db->select('_v2_mhsw.NIM, 
 //        				   _v2_mhsw.KodeFakultas, 
 //        				   _v2_mhsw.Name, 
 //        				   _v2_mhsw.TotalSKSLulus, 
 //        				   _v2_mhsw.KodeProgram, 
 //        				   _v2_mhsw.KodeJurusan, 
 //        				   _v2_jurusan.Kode, 
 //        				   _v2_jurusan.nama_indonesia');

	// 	$this->db->from('_v2_mhsw');
	// 	$this->db->join('_v2_jurusan', '_v2_mhsw.kodejurusan = _v2_jurusan.kode','left');
	// 	$this->db->like('NIM',$dataSearch);
        
 //        return $this->db->get()->result_array();
       
	// }

	public function getDetail($nim){
		$nim=$this->db->escape_str($nim);

		$query = $this->db->query("SELECT m.NIM, m.KodeFakultas, m.Name, m.TotalSKSLulus, m.KodeProgram, m.kodejurusan, j.nama_indonesia as nmj from _v2_mhsw m left outer join _v2_jurusan j on m.kodejurusan=j.kode where m.NIM='$nim' Limit 1");

		return $query->row();

	}	

	public function cekkrs($nim,$tahunaktif){
		$nim 		= $this->db->escape_str($nim);
		$tahunaktif	= $this->db->escape_str($tahunaktif);
		$use	 	= array('_v2_krs20192');

		for ($a=0; $a<count($use); $a++){

			$query = $this->db->query("SELECT k.NIM, k.GradeNilai from $use[$a] k where (k.NamaMK like '%Pengenalan Lapangan Persekolahan%' or k.NamaMK like '%Pengenalan Lingkungan Persekolahan (PLP)%' or k.NamaMK like '%KKN-PPL%' or k.NamaMK like '%PPL-Terpadu%' or k.NamaMK like '%PPL- Terpadu%' or k.NamaMK like '%PPLT%' or k.NamaMK='PPL Terpadu') and NIM='$nim' and Tahun='$tahunaktif' and NotActive='N'");
		}

		return $query->num_rows();

	}

	//SELECT * from _v2_ppl where NIM='A42116061' and Tahun='20191'
	public function cekppl($unip,$tahunaktif){
		$unip=$this->db->escape_str($unip);
		$tahunaktif=$this->db->escape_str($tahunaktif);
		$query = $this->db->query("SELECT * from _v2_ppl where NIM='$unip' and Tahun='$tahunaktif'");

		return $query->num_rows();

	}

	public function pplcek($nim){
		$query = $this->db->query("SELECT k.NIM, k.GradeNilai from _v2_krs20192 k where (k.NamaMK='Microteaching' or k.NamaMK='Mikroteaching' or k.NamaMK='Micro Teaching B3' or k.NamaMK='Pembelajaran mikro' or k.NamaMK='Micro Teaching' or k.NamaMK='Micro Teaching/PPL I' or k.NamaMK='Microteachig (PPL I)' or k.NamaMK='Microteaching' or k.NamaMK='Microteaching (PPL I)' or k.NamaMK='Microteaching/PPL1' or k.NamaMK='PPL (Microteaching)' or k.NamaMK like 'Latihan Mengajar%' or k.NamaMK='Pengajaran Mikro Penjaskesrek' or k.NamaMK='PPL I' or k.NamaMK='Teknik dan Laboratorium Konseling II' or k.NamaMK='Praktikum Bimbingan dan Konseling II') and NIM='$nim' and NotActive='N'");

		return $query->row();
	}

	public function getKodeFak($unip){
		$unip	= $this->db->escape_str($unip);

		$query 	= $this->db->query("SELECT KodeFakultas FROM _v2_mhsw where Login='$unip'");

		return $query->row();
	}

	public function daftarPpl($nim){
		$nim=$this->db->escape_str($nim);

		$query = $this->db->query("SELECT m.NIM, m.TglLahir, m.sex, a.agama, m.Alamat, m.Phone, m.NamaOT, m.NamaIbu, m.AlamatOT1, m.AlamatOT2, m.TelpOT, f.nama_indonesia as nmf, f.singkatan as singfak from _v2_mhsw m left outer join fakultas f on m.kodefakultas=f.kode left outer join _v2_jurusan j on m.kodejurusan=j.kode left join _v2_agama a on m.AgamaID=a.agamaID where m.NIM='$nim' Limit 1");

		return $query->row();		
	}


	//  PRCMK
	public function updateMhsw($tgllahir, $alamat, $phone, $ayah, $ibu, $alamatot1, $phoneot, $simnim){
		$query = $this->db->query("UPDATE _v2_mhsw set TglLahir='$tgllahir',alamat='$alamat',phone='$phone',NamaOT='$ayah',namaibu='$ibu',alamatot1='$alamatot1',TelpOT='$phoneot' where Login='$simnim'");

	}

	public function selectprcmk($simnim, $tahun){
		$query = $this->db->query("SELECT NIM from _v2_ppl where NIM='$simnim' and Tahun='$tahun'");

		return $query->num_rows();
	}

	public function insertppl($simnim, $tahun, $dasal, $kendaraan, $unip){
		$query = $this->db->query(" insert into _v2_ppl (id,NIM,tahun,daerah_asal,kendaraan,usppl,tglusppl) values (NULL,'$simnim','$tahun','$dasal','$kendaraan','$unip',NOW() ) ");

	}

	public function updateppl($dasal, $kendaraan, $simnim, $tahun){
		$query = $this->db->query("update _v2_ppl set daerah_asal='$dasal',kendaraan='$kendaraan' where NIM='$simnim' and Tahun='$tahun'");
	}


	//prin A23112092 a.agama, m.Alamat,
	public function daftar_bio($nim){
		$query = $this->db->query("SELECT m.NIM, m.Name, m.TempatLahir, m.TglLahir, m.TotalSKSLulus, m.KodeProgram, m.sex, m.Alamat1, m.Phone, m.NamaOT, m.NamaIbu, m.AlamatOT1, m.AlamatOT2, m.TelpOT, f.nama_indonesia as nmf, f.singkatan as singfak, m.KodeJurusan, j.nama_indonesia as nmj, agm.agama from _v2_mhsw m left outer join fakultas f on m.kodefakultas=f.kode left outer join _v2_jurusan j on m.kodejurusan=j.kode left outer join _v2_agama a on m.AgamaID=a.agamaID where m.NIM='$nimt' Limit 1");
	}

	public function report_ppl($tahunppl){
		$query = $this->db->query("SELECT 
		m.NIM, 
		m.Name, 
		m.TglLahir, 
		m.TotalSKS, 
		m.KodeProgram, 
		m.sex, 
		m.AgamaID, 
		m.Alamat, 
		m.Phone, 
		m.NamaOT, 
		m.NamaIbu, 
		m.AlamatOT1, 
		m.AlamatOT2, 
		m.TelpOT, 
		f.nama_indonesia AS nmf, 
		f.singkatan AS singfak, 
		m.kodejurusan, 
		j.nama_indonesia AS nmj,
		p.kategori,
		p.Tahun   
		FROM _v2_ppl p 
		LEFT JOIN _v2_mhsw m ON p.NIM=m.NIM 
		LEFT OUTER JOIN fakultas f ON m.kodefakultas=f.kode 
		LEFT OUTER JOIN _v2_jurusan j ON m.kodejurusan=j.kode 
		WHERE p.Tahun=$tahunppl 
		ORDER BY m.NIM ASC");

		return $query->result_array();
		
	}

}	