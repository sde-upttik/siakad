<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sinkron_db extends CI_Model{

	private $db2;
	private $db3;
	private $db4;
	private $db5;

	public function __construct(){
		parent::__construct();
		$this->db2 = $this->load->database('siakad', TRUE);
		$this->db3 = $this->load->database('wisuda', TRUE);
		$this->db4 = $this->load->database('sapta', TRUE);
		$this->db5 = $this->load->database('kkn', TRUE);
	}

	/* sapta bermasalah koneksi database public function Sinkron_sapta($nim) {
		$row = $this->db->query("select Login,Password,Description,NIM,Name,Email,TempatLahir,TglLahir,Alamat1,Phone,KodeFakultas,KodeJurusan,Status,NotActive from _v2_mhsw where NIM='$nim'")->row();

		$login = $row->Login;
		$password = $row->Password;
		$description = $row->Description;
		$name = $row->Name;
		$email = $row->Email;
		$tempatLahir = $row->TempatLahir;
		$tglLahir = $row->TglLahir;
		$alamat = $row->Alamat1;
		$phone = $row->Phone;
		$kodeFakultas = $row->KodeFakultas;
		$kodeJurusan = $row->KodeJurusan;
		$status = $row->Status;
		$notActive = $row->NotActive;

		$cek = $this->db4->query("select NIM from mhsw where NIM='$nim'")->num_rows();
		echo "fandu sapta 123 $cek";
		/*if($cek==0) {
			$stat = $this->db4->query("insert into mhsw (Login,Password,Description,NIM,Name,Email,TempatLahir,TglLahir,Alamat1,Phone,KodeFakultas,KodeJurusan,Status,NotActive)
			values ('$login','$password','$description','$login','$name','$email','$tempatLahir','$tglLahir','$alamat','$phone','$kodeFakultas','$kodeJurusan','$status','$notActive')");


			if ($stat) echo "<div class='alert alert-success'><button class='close' data-dismiss='alert'>×</button><strong>Sukses!</strong> Berhasil.</div>";
			else echo "<div class='alert alert-danger'><button class='close' data-dismiss='alert'>×</button><strong>Error!</strong> Gagal Validasi.</div>";
		}else{

			echo "<div class='alert alert-danger'>
						<button class='close' data-dismiss='alert'>×</button>
				<strong>Error!</strong> Data Sudah Terdapat di Aplikasi SAPTA.</div>";
		}*---/
	}*/

	public function Sinkron_wisuda($nim) {
		$cek = $this->db3->query("select * from mhs where nim='$nim'")->num_rows();
		echo "fandu wisuda $cek";
	}

	function Sinkron_wisuda_insert ($_results, $_tbl, $value, $value1) {
		if (!empty($value1)) $value1 = "and $value1";
		$s = "INSERT INTO $_tbl $_results where $value $value1";
		$r = $this->db3->query($s);
		return $r;
	}

	public function Sinkron_wisuda_insert_query($query) {
		$r = $this->db3->query($query);
		return $r;
	}

	public function Sinkron_wisuda_query($query) {
		$r = $this->db3->query($query);
		return $r;
	}

	function Sinkron_wisuda_delete ($_tbl, $value, $value1) {
		if (!empty($value1)) $value1 = "and $value1";
		$s = "DELETE FROM $_tbl where $value $value1";
		$r = $this->db3->query($s);
		return $r;
	}

	/* kkn bermasalah koneksi database public function Sinkron_kkn($nim) {
		$cek = $this->db5->query("select * from tb_mahasiswa_kkn where nim='$nim'")->num_rows();
		echo "fandu kkn $cek";
	} */

	public function Sinkron_siakad_lama($nim) {
		$cek = $this->db2->query("select * from mhsw where nim='$nim'")->num_rows();
		echo "fandu siakad lama $cek";
	}

	function GetFields_siakad_lama($_results, $_tbl, $_key, $_value) {
		$s = "select $_results from $_tbl where $_key='$_value' limit 1";
		$r = $this->db2->query($s);
		return $r;
	}

	function GetField_siakad_lama ($_results, $_tbl, $value, $value1) {
		if (!empty($value1)) $value1 = "and $value1";
		$s = "select $_results from $_tbl where $value $value1";
		$r = $this->db2->query($s);
		return $r;
	}


	public function cek_mhsw_sapta($nim) {

		$this->db4->select('NIM');
		$this->db4->from('mhsw');
		$this->db4->where('NIM',$nim);
		return $this->db4->get()->row();

	}

	public function insert_mhsw_sapta($data) {

		return $this->db4->insert('mhsw',$data);

	}


	//_____________________________________Model AKTIVASI MAHASISWA____________________________________//


	public function sykn_siakad_lama() {
		$data = $this->db2->query("select * from aktivitas_mahasiswa");
		return $data->result_array();
	}

	public function simpan_data($tabelName,$data){
		$res = $this->db2->insert($tabelName,$data);
		return $res;
	}









	//_____________________________________Model AKTIVASI MAHASISWA____________________________________//

}
