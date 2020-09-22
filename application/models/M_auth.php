<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model{

	public function getLevelModul($key)
	{
		$where['Link'] 	= $key;
        $fields			= "Link, Level";
        
        return $this->db->select($fields)->get_where('modul',$where);
    }
}