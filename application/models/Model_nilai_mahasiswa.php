<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_nilai_mahasiswa extends CI_Model {
	
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

	public function select_fields_where_order($table, $fields, $where, $order)
	{
		$this->db->select($fields);
		$this->db->where($where);
		$this->db->order_by($order,'DESC');
		$this->db->limit(1);

		$result = $this->db->get($table);
		return $result->result_array();
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
}
	