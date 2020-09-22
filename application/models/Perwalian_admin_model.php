<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perwalian_admin_model extends CI_Model{


	public function getJurusan()
	{
		$this->db->select('kode,Nama_Indonesia');
		$this->db->where('Kode', $this->session->userdata("kdj"));
		return $this->db->get('_v2_jurusan')->result_array();
	}

	public function getMahasiswaWali($semester, $dosen)
	{
		// $dosenWali  = $this->session->userdata('unip');

    	$fields 	= array(
							'_v2_krs'.$semester.'.NIM', 
							'_v2_krs'.$semester.'.Tahun',
							'_v2_krs'.$semester.'.Program',
							'_v2_krs'.$semester.'.unip_wali',
							'_v2_mhsw.Status',
							'_v2_mhsw.Name',
							'_v2_mhsw.TahunAkademik',
							"(select sum(SKS)  from _v2_krs{$semester} where _v2_krs{$semester}.NIM = _v2_mhsw.NIM ) as sks",
							"(select count(NIM)  from _v2_krs{$semester} where st_wali = 1 and _v2_krs{$semester}.NIM = _v2_mhsw.NIM  ) as mk_diterima ",
							"(select count(NIM)  from _v2_krs{$semester} where st_wali = 0 and _v2_krs{$semester}.NIM = _v2_mhsw.NIM) as mk_ditolak"
    						);

    	$table  	= array(
    					'_v2_krs'.$semester,
    					'_v2_mhsw'
    					);

    	$where 		= array(
    						'_v2_krs'.$semester.'.Tahun'	 => $semester,
							'_v2_mhsw.DosenID'		 		 => $dosen
    						);

    	$on			= '_v2_krs'.$semester.'.NIM = _v2_mhsw.NIM';

    	$group 		= '_v2_krs'.$semester.'.NIM';

    	$this->db->select($fields);
		$this->db->where($where);
		$this->db->from($table[0]);
		$this->db->group_by($group); 
		$this->db->join($table[1],  $on, 'left');

		return $this->db->get()->result_array();
	}

	// Mengambil data KHS
	public function getKhs($nim, $tahun)
	{
		$table 		= '_v2_khs';

		$fields 	= array(
							'IPS',
							'SKSLulus',
							'IPK',
							'TotalSKSLulus'
							);

		$where  	= array(
							 'NIM' 		=> $nim, 
							 'Tahun' 	=> $tahun, 
							);

		$this->db->select($fields);
		$this->db->where($where);
		return $this->db->get($table)->result_array();
	}

// Mengambil data KRS
	public function getKrs($nim, $tahun)
	{
		$table 	= '_v2_krs'.$tahun;

		$fields = array(
						'KodeMK',
						'IDJadwal',
						'NamaMK',
						'SKS',
						'st_wali',
						'NIM',
						);

		$where  = array(
						'NIM' 	=> $nim,
						'Tahun' => $tahun
						);

		$this->db->select($fields);
		$this->db->where($where);
		return $this->db->get($table)->result_array();
	}

	public function validasiMK($tahun, $nim, $KodeMK, $st_wali, $unip_wali)
	{
		
		$data 		= array(
					   		'st_wali' 	=> $st_wali,
					   		'unip_wali' => $unip_wali,
					  		);

		$table 		= "_v2_krs".$tahun;

		$where 		= array(
							"NIM" 		=> $nim,
							"KodeMK" 	=> $KodeMK,
						);

		return $this->db->update($table, $data, $where);
	}

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

	public function select_fields_where_row($table, $fields, $where)
	{
		$this->db->select($fields);
		$this->db->where($where);
		$result = $this->db->get($table);		
		$row    = $result->row_array();
		return $row;
	}	
	public function select_sum_where($field, $where, $table)
	{
		$this->db->select_sum($field);
		$this->db->where($where);

		$sum 	= $this->db->get($table);
		$row    = $sum->row_array();

		return $row;
	}	

	public function select_count_where($where, $table)
	{
		$this->db->where($where);

		$count = $this->db->count_all_results($table); 

		return $count;
	}

	public function select_fields_where_c($table, $fields, $where)
	{
		$this->db->select($fields);
		$this->db->where($where);
		$result = $this->db->get($table);
		$row    = $result->row_array();
		return $row['Name'];
	}	


	public function select_fields_where_join($table, $fields, $where, $on)
	{
		$this->db->select($fields);
		$this->db->where($where);
		$this->db->from($table[0]);
		$this->db->join($table[1],  $on[0], 'left');
		$this->db->join($table[2],  $on[1] );
		$result = $this->db->get();
		return $result->result_array();
	}	

	public function select_fields_where_join_2($table, $fields, $on, $group, $where)
	{	
		$this->db->select($fields);
		$this->db->where($where);
		$this->db->from($table[0]);
		$this->db->group_by($group); 
		$this->db->join($table[1],  $on, 'left');
	}

	public function update_where($table,$data, $where)
	{
		$this->db->where($where);
		$update = $this->db->update($table,$data);
		if ($update) {
			return 1;
		}
		else {
			return 0;
		}
	}

	public function update($table,$data)
	{

		$update = $this->db->update($table,$data);
		
		if ($update) {
			return 1;
		}
		else {
			return 0;
		}
	}

	public function insert($table, $data)
	{
		$insert = $this->db->insert($table, $data);
		if ($insert) {
			return 1;
		}
		else {
			return 0;
		}
	}

	public function count_row($table, $where)
	{
		$this->db->select($fields);
		$this->db->where($where);
		$result = $this->db->get($table);
		return $result->num_rows();
	}

	public function replace($table, $data)
	{
		$replace = $this->db->replace($table, $data);
		if ($replace) {
			return 1;
		}
		else {
			return 0;
		}
	}
	
//***********************************Data Tables model ***********************************

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query($semester, $program, $jurusan, $angkatan)
    {

    	$fields 	= array(
							'_v2_krs'.$semester.'.NIM', 
							'_v2_krs'.$semester.'.Tahun',
							'_v2_krs'.$semester.'.Program',
							'_v2_krs'.$semester.'.unip_wali',
							'_v2_mhsw.Status',
							'_v2_mhsw.Name'
    						);

    	$table  	= array(
    					'_v2_krs'.$semester,
    					'_v2_mhsw'
    					);

    	$where 		=array(
    						'_v2_krs'.$semester.'.Tahun'	 => $semester,
							'_v2_krs'.$semester.'.Program'	 => $program,
							'_v2_mhsw.KodeJurusan'			 => $jurusan,
							'_v2_mhsw.TahunAkademik'		 => $angkatan
    						);

    	$on			= '_v2_krs'.$semester.'.NIM = _v2_mhsw.NIM';

    	$group 		= '_v2_krs'.$semester.'.NIM';

    	$this->select_fields_where_join_2($table, $fields, $on, $group, $where);
 
    	$column_order 	= array(
    							null, 
								'_v2_krs'.$semester.'.NIM', 
								'_v2_krs'.$semester.'.Tahun',
								'_v2_krs'.$semester.'.Program',
								'_v2_krs'.$semester.'.unip_wali',
								'_v2_mhsw.Status',
								'_v2_mhsw.Name'
    							); 	

    	$column_search 	= array(
								'_v2_krs'.$semester.'.NIM',
								); 	

		$order 			= array('_v2_krs'.$semester.'.NIM' => 'asc'); 	
        
        $i = 0;
     
        foreach ($column_search as $item) 						// looping awal
        {
            if($_POST['search']['value'])								// jika datatable mengirimkan pencarian dengan metode POST
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
 
                if(count($column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($order))
        {
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables($semester, $program, $jurusan, $angkatan)
    {
        $this->_get_datatables_query($semester, $program, $jurusan, $angkatan);

        if($_POST['length'] != -1){
	        $this->db->limit($_POST['length'], $_POST['start']);
	        $query = $this->db->get();
	        return $query->result();        	
        }
    }
 
    function count_filtered($semester, $program, $jurusan, $angkatan)
    {
        $this->_get_datatables_query($semester, $program, $jurusan, $angkatan);
        $query = $this->db->get();

        return $query->num_rows();
    }
 
    public function count_all($semester)
    {
    	$table = '_v2_krs'.$semester; 	
        
        $this->db->from($table);
        return $this->db->count_all_results();
    }


}