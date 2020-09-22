<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_counter extends CI_Model{

	public function countMhsOnClass($tahun, $idjadwal)
	{
		$where['Tahun']     = $tahun;
        $where['IDJadwal']  = $idjadwal;
        
        $fields			    = "NIM, tahun, IDJadwal";
        
        return $this->db->select($fields)->get_where->('_v2_krs'.$tahun,$where);
    }
}