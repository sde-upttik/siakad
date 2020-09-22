<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_siakad extends CI_Model{

	public function log_menu($content){
		$uname = $this->db->escape($this->session->userdata('uname'));
		$ulevel = $this->session->userdata('ulevel');
		//$content = $this->session->userdata('sess_tamplate');
		$this->db->query("INSERT INTO _v2_log_menu (id, log_user, log_level, log_menu, time, str) VALUES ('', $uname, '$ulevel', '$content', NOW(), UNIX_TIMESTAMP(NOW()));");
	}
}
