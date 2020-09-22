<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruang_kelas extends CI_Controller {

	function __construct(){
		parent::__construct();
	    $this->load->model('Ruang_kelas_model');
	    date_default_timezone_set("Asia/Makassar");
	}

	public function index(){
		$datakode	  = $this->userKode();
		$ulevel		  = $this->session->userdata('ulevel');
		$unip		  = $this->session->unip;
		
		$data         = $this->Ruang_kelas_model->get_data($ulevel, $datakode);
		$data_jurusan = $this->get_field_jurusan();

		$paket		  = array('data'=>$data,
							  'data_jurusan' =>$data_jurusan);
		// echo $ulevel;
		// echo $datakode;
		// echo "<pre>";
		// echo "ADA YANG KORE KAH ? ";
		// print_r($paket);
		// echo "</pre>";

		$this->load->view('dashbord',$paket);
	}

	public function userKode(){
		if ($this->session->userdata('ulevel') == 1){
				return $dataKode = $this->session->userdata();
			
			}elseif ($this->session->userdata('ulevel') == 5){
					   $dataKode = $this->session->userdata("kdf");
				return $datakode = substr($dataKode, 0, 1);			
			
			}else {
				return $dataKode = 0;
		}
		
	}

	// mengambil data dari database untuk menampilkan di select Bar 
	public function get_field_jurusan(){
		$datakode	  = $this->userKode();
		$ulevel		  = $this->session->userdata('ulevel');
		$data_jurusan = $this->Ruang_kelas_model->get_jufak($ulevel, $datakode);
		return $data_jurusan;
		
	}

	public function tambah_ruang_kelas(){

		$level		    = $this->session->userdata('ulevel');
		$unip			= $this->session->unip;
		$datakode	  	= $this->userKode();

		$Kode 			= $this->input->post('kode');
		$Nama 			= $this->input->post('nama_ruang');
		$KodeKampus 	= $this->input->post('kodekampus');
		$Lantai			= $this->input->post('lantai');
		$Kapasitas		= $this->input->post('kapasitas');
		$KapasitasUjian = $this->input->post('kapasitas_ujian');
		$Keterangan		= $this->input->post('ket');
		$NotActive 		= $this->input->post('notactive');
		
		if ($NotActive=='Y') {
			
		}else{
			$NotActive ='N';
		}

		
		$data 			= array('Kode' 			 => $Kode , 
								'Nama' 			 => $Nama ,
								'KodeKampus' 	 => substr($KodeKampus, 0, 1),
								'Lantai' 		 => $Lantai ,
								'Kapasitas' 	 => $Kapasitas ,
								'KapasitasUjian' => $KapasitasUjian,
								'Keterangan' 	 => $Keterangan,
								'NotActive' 	 => $NotActive ,
								'Login' 		 => $this->session->userdata('uname'),
								'tgl'         	 => date('Y-m-d H:i:s')
								);

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";

		$res = $this->db->insert('_v2_ruang',$data);
		if ($res==TRUE) {

			echo "Berhasil";
			 $this->index();
		}else{

			$res['footerSection'] = "<script type='text/javascript'>
		          swal({   
		            title: 'Pemberitahuan',   
		            type: 'warning',    
		            html: true, 
		            text: 'Data Gagal Tersimpan',
		            confirmButtonColor: '#f7cb3b',   
		          });
		          </script>";

        		$this->load->view('dashbord',$res);
		}
	}

	public function edit_ruang_kelas(){

		$level		= $this->session->userdata('ulevel');
		$datakode	= $this->userKode();

		$Kode 		= $this->input->post('Kode');
		$Kode   	= str_replace("%20", " ", $Kode);
		$where 		= array('Kode' => $Kode);

		$data_edit  = $this->Ruang_kelas_model->get_edit('_v2_ruang', $where)->result();

		echo json_encode($data_edit);

		// echo "<pre>";
		// print_r($where);
		// echo "</pre>";
	}

	public function update_ruang_kelas(){

		$ulevel		    = $this->session->userdata('ulevel');
		$unip			= $this->session->unip;
		$datakode	 	= $this->userKode();

		$Kode 			= $this->input->post('add_kode');
		$Nama 			= $this->input->post('add_nama_ruang');
		$KodeKampus 	= $this->input->post('add_kodekampus');
		$Lantai			= $this->input->post('add_lantai');
		$Kapasitas		= $this->input->post('add_kapasitas');
		$KapasitasUjian = $this->input->post('add_kapasitas_ujian');
		$Keterangan		= $this->input->post('add_ket');
		$NotActive 		= $this->input->post('notactivee');

		if ($NotActive=='Y') {
			//$NotActive ='Y';
		}else{
			$NotActive ='N';
		}
			$where  = array('Kode' => $Kode);
			$data 	= array('Nama' 			 => $Nama,
							'KodeKampus' 	 => substr($KodeKampus, 0, 1),
							'Lantai' 		 => $Lantai ,
							'Kapasitas' 	 => $Kapasitas ,
							'KapasitasUjian' => $KapasitasUjian,
							'Keterangan' 	 => $Keterangan,
							'NotActive' 	 => $NotActive,
							'Login' 		 => $this->session->userdata('uname'),
							'tgl'         	 => date('Y-m-d H:i:s')
							);

			

			$dataUpdate = $this->Ruang_kelas_model->updateData('_v2_ruang',$where, $data);
		
		if ($dataUpdate=true) {
			$this->index();
			//echo "Berhasil";
				
			}else{
				echo "Gagal";
			}	
			
			//echo json_encode($dataUpdate);
			//$this->index();

			// echo "<pre> data Where ";
			// print_r($where);
			// echo "</pre>";

			// echo "<pre> data Update ";
			// print_r($data);
			// echo "</pre>";

	}


}