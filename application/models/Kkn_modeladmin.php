<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kkn_modeladmin extends CI_Model {

	private $db2;
	private $db3;

	public function __construct(){	
		parent::__construct();
		$this->db2 = $this->load->database('kkn', TRUE);
		$this->db3 = $this->load->database('spc', TRUE);

	}

	public function search($searchData){

		 
		$thn = "20201";
	    $nim = $searchData;


		$data = $this->db->query(" SELECT k.prckkn, k.ID, m.TahunAkademik , m.NIM as nim, m.Name as nm, m.Login, m.Password, k.NamaMK, f.Nama_Indonesia as nmindo, m.KodeFakultas AS kdfak, m.KodeJurusan AS kdjur , m.Sex as sex, m.Phone as p, m.KodeProgram as k, j.Nama_Indonesia as j, m.TotalSKS as totsksl, m.TempatLahir as tmp from _v2_krs20201 k left join _v2_mhsw m on k.NIM=m.NIM left outer join fakultas f on m.KodeFakultas=f.Kode left outer join _v2_jurusan j on m.KodeJurusan=j.Kode where (k.NamaMK like '%KKN%' or k.NamaMK like '%KULIAH KERJA NYATA / STRATEGI PENGEMBANGAN KEPRIBADIAN DAN KEMASYARAKATAN (SPKK)%' or k.NamaMK like '%PPLT%' or k.NamaMK='PPL Terpadu' or k.NamaMK='Prakter Pengalaman Lapangan Terpadu' or k.NamaMK like '%PPL- Terpadu%' or k.NamaMK like '%PPL-Terpadu%') and k.Tahun='$thn' and m.NIM='$nim' ");
			
			if($data){
				return $data->row();	
			}else{
				return FALSE;
			}

			

			//D10113025
			/*$thn = "20171";
			$nim = $searchData;
			$where = "k.NamaMK='PPL-Terpadu' or k.NamaMK='PPL- Terpadu' and k.Tahun='$thn' and m.NIM='$nim'";
			$this->db->select('k.ID, m.TahunAkademik , m.NIM as nim, m.Name as nm, m.Login, m.Password, k.NamaMK, f.Nama_Indonesia as nmindo, m.KodeFakultas as kdfak, m.KodeJurusan as kdjur , m.Sex as sex, m.Phone as p, m.KodeProgram as k, j.Nama_Indonesia as j, m.TotalSKS as totsksl, m.TempatLahir as tmp');
			$this->db->from('_v2_krs20181 k');
			$this->db->join('_v2_mhsw m','k.NIM=m.NIM','left' );
			$this->db->join('_v2_jurusan j','m.KodeJurusan=j.Kode','left outer');
			//$this->db->join('_v2_program p','m.KodeProgram=p.Kode','left outer');
			$this->db->join('fakultas f','m.KodeFakultas=f.Kode','left outer');
			$this->db->where($where);
			$this->db->like('k.NamaMK','%KKN%');
			$this->db->or_like('k.NamaMK','%PPLT%');
			$this->db->or_like('k.NamaMK','%KULIAH KERJA NYATA / STRATEGI PENGEMBANGAN KEPRIBADIAN DAN KEMASYARAKATAN (SPKK)%');
			$this->db->or_like('k.NamaMK','%PPL-Terpadu%');
			$this->db->or_like('k.NamaMK','%PPL- Terpadu%');
			return $this->db->get()->result_array();*/
			
			/*$this->db->where("(k.NamaMK like '%KKN%' or k.NamaMK like '%KULIAH KERJA NYATA / STRATEGI PENGEMBANGAN KEPRIBADIAN DAN KEMASYARAKATAN (SPKK)%' or k.NamaMK like '%PPLT%' or k.NamaMK='PPL Terpadu' or k.NamaMK='Prakter Pengalaman Lapangan Terpadu' or k.NamaMK like '%PPL- Terpadu%' or k.NamaMK like '%PPL-Terpadu%') and k.Tahun='$thn' and m.NIM='$nim'");*/
	}

	public function getJadwal($query){
		$data = $this->db->query($query);
		return $data->row();
	}

	public function getQuery($query){
		$data = $this->db->query($query);
		return $data->row();
	}

	public function getNumRows($query){
		$data = $this->db->query($query);
		return $data->num_rows();
	}

	public function insertKrs($qInsert){
		$query = $this->db->query($qInsert);

		if($query){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function getMhswKkn($nim){
		$nim = $this->db->escape_str($nim);
		$thn = "20201";
		$data = $this->db->query("SELECT m.Name as nm, m.TahunAkademik , m.IPK, m.Login, m.Password, f.Singkatan, f.Nama_Indonesia as nmindo, m.KodeFakultas AS kdfak, m.KodeJurusan AS kdjur, m.Sex as sex, m.Phone as p, m.KodeProgram as k, j.Nama_Indonesia as j, m.TotalSKS as t, m.TempatLahir as tmp, m.Alamat as almt1 from _v2_mhsw m left outer join fakultas f on m.KodeFakultas=f.Kode left outer join _v2_jurusan j on m.KodeJurusan=j.Kode where m.NIM='$nim'");
		return $data->row();
	}

	public function cektabkkn($nim,$nama){
		$data = $this->db2->query("SELECT * from tb_mahasiswa_kkn where nim='$nim' and nama='$nama'");
		return $data->num_rows();
	}

	public function updatePrcKkn($upt){
		$query = $this->db->query($upt);

		if($query){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function insertKkn($ins){
		$query = $this->db2->query($ins);

		if($query){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public function insertTagihan($querytagihan){
		$query = $this->db3->query($querytagihan);

		if($query){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public function insertDetilTagihan($querydetil_tagihan){
		$query = $this->db3->query($querydetil_tagihan);

		if($query){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	// public function tester()
	// {
	// 	$this->db2->insert();
		
	// }
}
			