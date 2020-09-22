<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends CI_Model{
	
	public function all_val($table){
		$menu = $this->db->get_where($table);
		return $menu;	
	}
	
	public function one_val($table, $par1, $val1){
		$menu = $this->db->get_where($table, array($par1 => $val1));
		return $menu;	
	}
	
	public function two_val($table, $par1, $val1, $par2, $val2){
		$menu = $this->db->get_where($table, array($par1 => $val1, $par2 => $val2));
		return $menu;	
	}
	
	public function two_val_option($par1, $table, $val1){
		$option ="";
		$s = "select $par1 from $table where $val1";	 
		$r = $this->db->query($s);
		foreach ($r->result() as $row) {
			$option .= "<option value=".$row->Kode.">".$row->Kode."</option>";
		}
		return $option;	
	}
	
	public function select_all_val($table,$select){
		$this->db->select($select);
		$this->db->from($table);
		
		return $this->db->get();
	}
	
	public function check($uri3){
		$break = $this->session->userdata('menu');
		if (in_array($uri3, $break)) {
			$key = array_search($uri3, $break);
			$module=$this->session->userdata($key.'T');
			return $module;
		} else {
			return false;
		}
	}
	
	function isTahunAktif($thn, $kdj) {
		return $this->GetaField('NotActive', '_v2_tahun', "KodeJurusan='$kdj' and Kode", $thn);
	}
	
	function GetaField($_result,$_tbl,$_key,$_value) {
		$_sql = "select $_result from $_tbl where $_key='$_value' limit 1";
		$_res = $this->db->query($_sql);
		if ($_res->num_rows() == 0) return '';
		else return $_res->row()->$_result;
	}
	
}