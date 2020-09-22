<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_function extends CI_Controller {

  var $CI;

  function __construct() {
    $CI =& get_instance();
    $uname=$CI->session->userdata('uname');
    $ulevel=$CI->session->userdata('ulevel');
    //$CI->load->model('App');
    //$CI->App->checksession();
    if (!empty($uname) and !empty($ulevel)){
      //redirect(base_url('menu'));
      //echo "maintenance";
      return TRUE;
    } else {
      //echo "maintenance 1";
      $CI->load->view('login');
    }
  }
}
?>
