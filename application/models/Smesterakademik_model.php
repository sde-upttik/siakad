<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Smesterakademik_model extends CI_Model {

	public function get_dataSearch($lvl, $user) {

        if ( $lvl == 1 ) {

            $this->db->select('Kode, Nama_Indonesia');
            $this->db->from('_v2_jurusan');

            return $this->db->get()->result_array();

        } elseif ( $lvl == 5 ) {

            $this->db->select('Kode, Nama_Indonesia');
            $this->db->from('_v2_jurusan');
            $this->db->where('KodeFakultas', $user);

            return $this->db->get()->result_array();

        } elseif ( $lvl == 2 || $lvl == 7 ) {

            $this->db->select('Kode, Nama_Indonesia');
            $this->db->from('_v2_jurusan');
            $this->db->where('Kode', $user);

            return $this->db->get()->result_array();

        }

    }

    public function select($Kode){
		return $this->db->query("select * from _v2_tahun WHERE Kode = '$Kode'");
		return $data->result_array();
	}

	public function select_data($tabelName){
		$result = $this->db->get($tabelName);
		return $result->result_array();
	}

	//Kode,Nama,KodeProgram,KodeJurusan
	public function getdata($where) {
		
		$this->db->where($where);

		$data = $this->db->query('select * from _v2_tahun LIMIT 56, 100');
		return $data->result_array();
	}

	public function select_field_from(){
		$data = $this->db->query("select Kode,Nama_Indonesia from _v2_jurusan");
		return $data->result_array();
	}

	public function insert_data($tabelName,$data){
		$res = $this->db->insert($tabelName,$data);
		return $res;
	}

	public function UpdataData($tabelName,$data,$where){
		$res = $this->db->update($tabelName,$data,$where);
		return $res;
	}

	public function update_where($table, $data, $where)
	{
		$this->db->where($where);
		$update = $this->db->update($table, $data, $where);
		if ($update) {
			return 1;
		}
		else {
			return 0;
		}
	}

	public function DeleteData($tabelName, $where){
		       $this->db->where($where);
		$res = $this->db->delete($tabelName);
		return $this->db->last_query();
	}

	public function select_fields_where($table, $fields, $where)
	{
		$this->db->select($fields);
		$this->db->where($where);
		$result = $this->db->get($table);
		return $result->result_array();
	}	

//Model datatable server side****************************************

	var $table 			= '_v2_tahun';

    var $column_order 	= array(
								null,
								'Kode',
								'Nama',
								'KodeProgram',
								'KodeJurusan'
    							); 

    var $column_search 	= array(
								'_v2_tahun.Kode'
    							);
    
    var $order 			= array('Kode' => 'asc'); 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query($program, $jurusan)
    {
    	$where = array(
    					'KodeProgram' => $program,
    					'KodeJurusan' => $jurusan
    					);

        $this->db->where($where);
        
        $this->db->from($this->table);
 
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
 
    function get_datatables($program, $jurusan)
    {
        $this->_get_datatables_query($program, $jurusan);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($program, $jurusan)
    {
        $this->_get_datatables_query($program, $jurusan);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
	

}	