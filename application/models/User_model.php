<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model{
	

	public function __construct(){
		parent::__construct();
	}

	function insert($data,$table)
	{
		$this->db->query("INSERT ".$table." (Login, Password, Description, Name, Email, Phone, NotActive) VALUES ('".$data['Login']."',Password('".$data['Password']."'),'".$data['Description']."','".$data['Name']."','".$data['Email']."','".$data['Phone']."','N')");
	}

    function insertLog($data,$table)
    {
        $this->db->query("INSERT ".$table." (username, user_category, user_created, date_created, ip_address, status) VALUES ('".$data['username']."','".$data['user_category']."','".$data['user_created']."','".$data['date_created']."','".$data['ip_address']."','".$data['status']."')");
    }


	function insertDosen($data,$table)
	{
		$this->db->query("INSERT ".$table." (Login, nip, Password, Description, Name, Email, Phone, NotActive) VALUES ('".$data['Login']."','".$data['nip']."',Password('".$data['Password']."'),'".$data['Description']."','".$data['Name']."','".$data['Email']."','".$data['Phone']."','N')");
	}

	function insertMhsw($data,$table)
	{
		$this->db->query("INSERT ".$table." (Login, NIM, Password, Description, Name, Email, Phone, NotActive) VALUES ('".$data['Login']."','".$data['NIM']."',Password('".$data['Password']."'),'".$data['Description']."','".$data['Name']."','".$data['Email']."','".$data['Phone']."','N')");
	}

	function insertFakultas($data,$table)
	{
		$this->db->query("INSERT ".$table." (Login, Password, Description, Name, Email, Phone, NotActive, KodeFakultas) VALUES ('".$data['Login']."',Password('".$data['Password']."'),'".$data['Description']."','".$data['Name']."','".$data['Email']."','".$data['Phone']."','N', '".$data['KodeFakultas']."')");
	}

    function insertJurusan($data,$table)
    {
        $this->db->query("INSERT ".$table." (Login, Password, Description, Name, Email, Phone, NotActive, KodeFakultas, KodeJurusan) VALUES ('".$data['Login']."',Password('".$data['Password']."'),'".$data['Description']."','".$data['Name']."','".$data['Email']."','".$data['Phone']."','N', '".$data['KodeFakultas']."', '".$data['KodeJurusan']."')");
    }

	function update($data,$table)
	{
		$this->db->query("UPDATE ".$table." SET Description='".$data['Description']."',Name='".$data['Name']."',Email='".$data['Email']."',Phone='".$data['Phone']."',NotActive='".$data['NotActive']."' WHERE ID='".$data['ID']."'");
	}

	function updateFakultas($data,$table)
	{
		$this->db->query("UPDATE ".$table." SET Description='".$data['Description']."',Name='".$data['Name']."',Email='".$data['Email']."',Phone='".$data['Phone']."',NotActive='".$data['NotActive']."',KodeFakultas='".$data['KodeFakultas']."' WHERE ID='".$data['ID']."'");
	}

    function updateJurusan($data,$table)
    {
        $this->db->query("UPDATE ".$table." SET Description='".$data['Description']."',Name='".$data['Name']."',Email='".$data['Email']."',Phone='".$data['Phone']."',NotActive='".$data['NotActive']."',KodeFakultas='".$data['KodeFakultas']."',KodeJurusan='".$data['KodeJurusan']."' WHERE ID='".$data['ID']."'");
    }

	function updatePassword($data,$table)
	{
		$this->db->query("UPDATE ".$table." SET Description='".$data['Description']."',Password=Password('".$data['Password']."'),Name='".$data['Name']."',Email='".$data['Email']."',Phone='".$data['Phone']."',NotActive='".$data['NotActive']."' WHERE ID='".$data['ID']."'");
	}

	function updatePasswordFakultas($data,$table)
	{
		$this->db->query("UPDATE ".$table." SET Description='".$data['Description']."',Password=Password('".$data['Password']."'),Name='".$data['Name']."',Email='".$data['Email']."',Phone='".$data['Phone']."',NotActive='".$data['NotActive']."',KodeFakultas='".$data['KodeFakultas']."' WHERE ID='".$data['ID']."'");
	}

	function deleteData($id,$table)
	{
		$this->db->where('Login', $id);
		return $this->db->delete($table);
	}

	public function updateSksKhs($jml,$nim,$thn) {
		$jml=$this->db->escape_str($jml);
		$nim=$this->db->escape_str($nim);
		$thn=intval($thn);

		$this->db->query("UPDATE _v2_khs SET SKS = '$jml' WHERE NIM = '$nim' and Tahun='$thn'");

	}

	public function deleteKrs($tbl,$id,$nim,$thn) {
		$tbl=$this->db->escape_str($tbl);
		$id=$this->db->escape_str($id);
		$nim=$this->db->escape_str($nim);
		$thn=$this->db->escape_str($thn);

		$delete = $this->db->query("DELETE from ".$tbl." WHERE ID='$id' and NIM='$nim' and Tahun='$thn'");

		if($delete){
			return true;
		}else{
			return false;
		}
	}

	public function getAdmin($id, $table)
	{
		$id=$this->db->escape_str($id);
		$query = $this->db->query("SELECT * FROM ".$table." WHERE ID='$id'");
		return $query;
	}

	public function getFakultas()
	{
		$query = $this->db->query("SELECT * FROM fakultas");
		return $query->result();
	}

    public function getJurusan($kdf)
    {
        $query = $this->db->query("SELECT * FROM _v2_jurusan WHERE KodeFakultas='$kdf'");
        return $query->result();
    }

	var $table = '_v2_dosen'; //nama tabel dari database
    var $column_order = array('ID', 'Name', 'Login', 'Email', 'Phone', 'NotActive', 'KodeFakultas'); //field yang ada di table user
    var $column_search = array('ID', 'Name', 'Login', 'Email', 'Phone', 'NotActive'); //field yang diizin untuk pencarian 
    var $order = array('Name' => 'asc'); // default order 

    function _get_datatables_query_dosen($kode_fak = '')
    {
        $this->db->from($this->table);
        if($kode_fak!='') {
            $this->db->where('KodeFakultas', $kode_fak);
        }
        
        $i = 0;
     
        foreach ($this->column_search as $item) // looping awal
        {
            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {
                 
                if($i===0) // looping awal
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatablesdosen($kode_fak = '')
    {
        $this->_get_datatables_query_dosen($kode_fak);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtereddosen($kode_fak = '')
    {
        $this->_get_datatables_query_dosen($kode_fak);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_alldosen($kode_fak = '')
    {
        $this->db->where('KodeFakultas', $kode_fak);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }


    var $table_mhs = '_v2_mhsw'; //nama tabel dari database
    
    private function _get_datatables_query_mahasiswa($kode_fak = '')
    {
        $this->db->from($this->table_mhs);
        if($kode_fak!='') {
            $this->db->where('KodeFakultas', $kode_fak);
        }
        $i = 0;
     
        foreach ($this->column_search as $item) // looping awal
        {
            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {
                 
                if($i===0) // looping awal
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatablesmahasiswa($kode_fak = '')
    {
        $this->_get_datatables_query_mahasiswa($kode_fak);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filteredmahasiswa($kode_fak = '')
    {
        $this->_get_datatables_query_mahasiswa($kode_fak);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_allmahasiswa($kode_fak = '')
    {
        $this->db->where('KodeFakultas', $kode_fak);
        $this->db->from($this->table_mhs);
        return $this->db->count_all_results();
    }
}