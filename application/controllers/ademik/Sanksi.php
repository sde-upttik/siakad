<?php 
/**
  * 
  */
 class Sanksi extends CI_Controller
 {
 	
 	function __construct()
 	{
		parent::__construct();
		date_default_timezone_set("Asia/Makassar");
 	}

 	function index($value='')
 	{
 		$this->load->view('dashbord');
 		$this->load->view('fikri.js/sanksi');
 	}
 	function coba($value='')
 	{
 		$this->load->view('fikri.js/sanksi');
 	}
 	function cabut()
 	{
 		if ($this->input->post('NIM')) {
 			$set = array('Status'=> 'A');
 			$where = array('NIM'=> $this->input->post('NIM'));
 			$this->db->set($set);
 			$this->db->where($where);
 			$res['status'] = $this->db->update('_v2_mhsw');
 			$res['data'] = $this->input->post('NIM');

 		}else{
 			$res['status'] = 0;
 			$res['data'] = $this->input->post('NIM');
 		}

 		echo json_encode($res);
 	}
 	function daftar()
 	{
 		$return['status'] = FALSE;
 		$return['ket'] = 'Tidak ditemukan mahasiswa dengan status Blok';
 		$return['data'] = array();

 		$query = "SELECT NIM,Name,KodeJurusan,TahunAkademik,'xxx' AS kasus,'2019-10-25 00:00:00' as tgl_sanksi FROM `_v2_mhsw` WHERE Status='B'";
 		$return['data'] = $this->db->query($query)->result_array();
 		if (count($return['data'])!=0) {
	 		$return['status'] = TRUE;
	 		$return['ket'] = count($return['data']);
 		}
 		echo json_encode($return);
 	}
 	function getMhsw($value='')
 	{
 		$return['status'] = FALSE;
 		$return['ket'] = 'Tidak ditemukan';
 		$return['data'] = array();

 		if ($this->input->post('mhsw')) {
 			$nims = explode(',', str_replace(' ', '', $this->input->post('mhsw')));
 												$this->db->select("NIM,Name,KodeJurusan,TahunAkademik");
 												$this->db->where_in('NIM',$nims);
	 		$return['data'] = $this->db->get("_v2_mhsw")->result_array();
	 		// if (count($return['data'])!=0) {
		 		$return['status'] = TRUE;
		 		$return['ket'] = count($return['data']);
		 		// $return['query'] = $this->db->last_query();
	 		// }
 		}
 		echo json_encode($return);
	}
	
	public function proses()
	{
		$list = $this->input->post('NIM');
		$data = $this->input->post();
		$bin_data=array();
		$i = 0; 
		foreach ($list as $mhsw) {
			$bin_data[$i] = $data;
			$bin_data[$i]['NIM'] = $mhsw['NIM'];
			$i++;
		}

		$this->db->insert_batch('_v2_riwayat_blokir',$bin_data);
		
		echo json_encode($bin_data);

	}
 } ?>