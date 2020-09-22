<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class form_dispensasi_ukt extends CI_Controller
{
  
	function __construct(){
		parent::__construct();
  }

  public function index()
  {
    // if ($this->session->userdata('ulevel')==4) {
      // $id = $this->session->userdata('id');
      // $fild = "`NIM`,`Name`,`Alamat`,`TahunAkademik`,`NamaOT`,`PekerjaanOT`,`AlamatOT1`";
      // $data['mhsw'] = $this->db->get_where('_v2_mhsw',['id'=>$id])->result();
    // }

    // $data['tab'] = $this->app->all_val('groupmodul')->result();
    
    // echo json_encode($data);
    // $this->load->view('dashbord',$data);    
  }

  public function getData()
  {
    $data['mhsw']=array();
    if ($this->session->userdata('ulevel')==4) {
      $id = $this->session->userdata('id');
      $fild = "`NIM`,`Name`,`Alamat`,`TahunAkademik`,`NamaOT`,`PekerjaanOT`,`AlamatOT1`";
      $data['mhsw'] = $this->db->get_where('_v2_mhsw',['id'=>$id])->result();
    }
    echo json_encode($data);
  }
  
}

?>