<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Model{

	public function checksession(){
		$uname=$this->session->userdata('uname');
		$ulevel=$this->session->userdata('ulevel');
		if (!empty($uname) and !empty($ulevel)){
			$this->load->view('dashbord');
		} else {
			redirect(base_url('menu'));
		}
	}

	public function checksession_ajax(){
		$uname=$this->session->userdata('uname');
		$ulevel=$this->session->userdata('ulevel');
		if (!empty($uname) and !empty($ulevel)){
			return true;
		} else {
			redirect(base_url('menu'));
		}
	}

	public function checksession_2(){
		$uname=$this->session->userdata('uname');
		$ulevel=$this->session->userdata('ulevel');
		if (!empty($uname) and !empty($ulevel)){
			$this->load->view('dashbord');
		} else {
			$this->load->view('login');
		}
	}

	public function check_modul() {
		$ulevel = $this->session->userdata('ulevel');
		$template = $this->session->userdata('tamplate');

		$cek = $this->db->query("select * from modul WHERE Link = '$template' and Level like '%-$ulevel-%'")->num_rows();

		if ($cek){
			return true;
		} else {
			redirect(base_url("menu"));
		}
	}

	function tanggal_inggris($formattes){
		// fandu function tanggal inggris
		$id=array("January","February","March","April","May","June","July","August","September","October","November","December");
		$tgl = substr($formattes, 0, 2); // memisahkan format tahun menggunakan substring
		$kd = substr($formattes, 2, 2); // memisahkan format tahun menggunakan substring
		$bulan = substr($formattes, 5, 6); // memisahkan format bulan menggunakan substring
		$tahun   = substr($formattes, 8, 11); // memisahkan format tanggal menggunakan substring
		if($tgl=="01")  $tgl="1";
		else if($tgl=="02")  $tgl="2";
		else if($tgl=="03")  $tgl="3";
		else if($tgl=="04")  $tgl="4";
		else if($tgl=="05")  $tgl="5";
		else if($tgl=="06")  $tgl="6";
		else if($tgl=="07")  $tgl="7";
		else if($tgl=="08")  $tgl="8";
		else if($tgl=="09")  $tgl="9";

		$result = $id[(int)$bulan-1]." ". $tgl."<sup>".$kd."</sup> ".$tahun;

		return($result);
	}

	function tanggal_indonesia($formattes){
		// fandu function tanggal indonesia

		$id=array("Januari","Pebruari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

		$tgl = substr($formattes, 0, 2); // memisahkan format tahun menggunakan substring
		$i = substr($formattes, 0, 1);
		if($i=='0') $tgl = substr($formattes, 1, 1);

		$bulan = substr($formattes, 3, 4); // memisahkan format bulan menggunakan substring
		$tahun   = substr($formattes, 6, 9); // memisahkan format tanggal menggunakan substring

		$result = $tgl." ".$id[(int)$bulan-1]." ".$tahun;
		return($result);
	}

	public function all_val($table){
		$menu = $this->db->get_where($table);
		return $menu;
	}

	public function one_val($table, $par1, $val1){
		$menu = $this->db->get_where($table, array($par1 => $val1));
		return $menu;
	}

	public function two_val_option($par1, $par2, $table, $val1, $val2){
		if (!empty($val2)) $val2 = "and $val2";
		$option ="";
		$s = "select $par1 as par1, $par2 as par2 from $table where $val1 $val2";
		$r = $this->db->query($s);
		foreach ($r->result() as $row) {
			$option .= "<option value='".$row->par2."'>".$row->par1."</option>";
		}
		return $option;
	}

	public function two_val($table, $par1, $val1, $par2, $val2){
		$menu = $this->db->get_where($table, array($par1 => $val1, $par2 => $val2));
		return $menu;
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

	function GetFields($_results, $_tbl, $_key, $_value) {
		$s = "select $_results from $_tbl where $_key='$_value' limit 1";
		$r = $this->db->query($s);
		return $r;
	}

	function GetField ($_results, $_tbl, $value, $value1) {
		if (!empty($value1)) $value1 = "and $value1";
		$s = "select $_results from $_tbl where $value $value1";
		$r = $this->db->query($s);
		return $r;
	}

	public function getOnRow($select, $tabel, $kondisi) {
		$query = "select $select from $tabel where $kondisi"; // Modif 08 - 2006 and Tahun='$thn'
		$row = $this->db->query($query)->row();
		return $row;
	}
}
