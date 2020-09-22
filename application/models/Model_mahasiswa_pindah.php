<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_mahasiswa_pindah extends CI_Model {
	
// Crud Mode____________________________________________
	public function select_fields($fields, $table)
	{
		$this->db->select($fields);
		$result = $this->db->get($table);
		return $result->result_array();
	}

	public function select_fields_where($table, $fields, $where)
	{
		$this->db->select($fields);
		$this->db->where($where);
		$result = $this->db->get($table);
		return $result->result_array();
	}		

	public function count_nim($nim)
	{
		return $this->db->get_where('_v2_mhsw',['NIM like' => $nim])->num_rows();

	}

	public function select_nim_akhir($table, $fields, $nims, $order)
	{
		$this->db->select($fields);

		$this->db->like('NIM',$nims,'after');
		$this->db->order_by($order,'DESC');

		$result = $this->db->get($table);
		return $result->result_array();
	}

	public function select_fields_where_order($table, $fields, $where, $order)
	{
		$jur = $where["KodeJurusan"];
		$thn = $where["TahunAkademik"];

		$this->db->select($fields);
		$this->db->like('KodeJurusan',$jur,'before');
		$this->db->where('TahunAkademik',$thn);
		$this->db->order_by($order,'DESC');
		$this->db->limit(1);

		$result = $this->db->get($table);
		return $result->result_array();
	}

	public function getDataMhswKeluar($nim) {

		$this->db->select('m.NIM, m.Name, m.Alamat, m.AlamatSP, m.AlasanPindah, m.UniversitasPindah, f.Singkatan, j.Nama_Indonesia');
		$this->db->from('_v2_mhsw m');
		$this->db->join('_v2_jurusan j','m.KodeJurusan=j.Kode');
		$this->db->join('fakultas f','m.KodeFakultas=f.Kode');
		$this->db->where('NIM',$nim);

		return $this->db->get()->row();

	}

	public function getProsesDataMhswKeluar($nim) {

		$this->db->select('m.NIM, m.Name, m.Alamat, m.AlamatSP, m.AlasanPindah, m.UniversitasPindah, f.Singkatan, j.Nama_Indonesia');
		$this->db->from('_v2_mhsw m');
		$this->db->join('_v2_jurusan j','m.KodeJurusan=j.Kode');
		$this->db->join('fakultas f','m.KodeFakultas=f.Kode');
		$this->db->where('NIM',$nim);

		return $this->db->get()->row_array();

	}

	public function insert($table, $data)
	{
		$result = $this->db->insert($table, $data);
		if ($result) {
			return 1;
		}else{
			return 0;
		}
	}

	public function update($table, $data, $where)
	{
		$this->db->where($where);
		$result = $this->db->update($table, $data);

		if ($result) {
			return 1;
		}else{
			return 0;
		}
	}

// get data____________________________________________

	public function insertPindahUntad($data)
	{
	}

	public function jurusan($where=null){
		$fields = array(
			  	  'Kode',
				  'Nama_Indonesia' 
		   	     );

		$table 	= "_v2_jurusan";

		if ($where != null) {
			array_push($fields, 'KodeFakultas');
			$data_jurusan = $this->select_fields_where($table, $fields, $where);	
		}
		else{
			$data_jurusan = $this->select_fields($fields, $table);	

		}
		return $data_jurusan;
	}	

	public function fakultas($where=null){
		$fields = array(
			  	  'Kode',
				  'Nama_Indonesia' 
		   	     );

		$table 	= "fakultas";

		if ($where != null) {
			$data_fakultas = $this->select_fields_where($fields, $table, $where);	
		}
		else{
			$data_fakultas = $this->select_fields($fields, $table);	

		}
		return $data_fakultas;
	}

	public function getMahasiswaPindahUntad($where)
	{
		$fields 	= array(
						'NIM',
						'Name',
						'NamaIbu',
						'TempatLahir',
						'TglLahir',
						'TahunStatus',
						'TahunAkademik',
						'Login',
						'Password',
						'KodeJurusan',
						'KodeFakultas',
						'AlasanPindah'
						);

		$table	= '_v2_mhsw';

		$data_result = $this->select_fields_where($table, $fields, $where);

		return $data_result;
	}

	public function getIdJurusan($jurusan='')
	{
		// if ($nim) {
		// 	$data = $this->db->select("_v2_jurusan.id_sms");
		// 					$this->db->join("_v2_jurusan","_v2_jurusan.kode=_v2_mhsw.KodeJurusan","inner");
		// 					$this->db->where('nim',$nim);
		// 					$this->db->get("_v2_mhsw")->result();
		// }elseif ($jurusan) {
							$this->db->select("_v2_jurusan.id_sms");
							$this->db->where('kode',$jurusan);
			$data = $this->db->get("_v2_jurusan")->row();
		// }else {
		// 	$data = '';
		// }
						
		// echo $data->id_sms;
		return $data->id_sms;
	}

}
	