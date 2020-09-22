<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Myclass
{
	var $CI;

    public function Myfunction()
    {
		$CI =& get_instance();
		$CI->load->model('App');
		$CI->App->checksession_2();
    }

		/*
		$CI =& get_instance();
		$uname=$CI->session->userdata('uname');
		$ulevel=$CI->session->userdata('ulevel');
		//$CI->load->model('App');
		//$CI->App->checksession();
		if (!empty($uname) and !empty($ulevel)){
			//redirect(base_url('menu'));
			echo "maintenance";
		} else {
			echo "maintenance 1";
			//redirect(base_url('menu'));
		}
		*/
}
?>
