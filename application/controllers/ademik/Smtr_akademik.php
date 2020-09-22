<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Smtr_akademik extends CI_Controller {

	function __construct(){
		parent::__construct();
	    $this->load->model('Smesterakademik_model');
	}

	public function index(){
		$this->form_pencarian();
	}

	//_________________________________________SEMESTER AKADEMIK_____________________________________________


	// 
	private function userKode() {

		if ( $this->session->userdata('ulevel') == 5 ) {
			return $dataKode = $this->session->userdata("kdf");
		} elseif ( $this->session->userdata('ulevel') == 7 ) {
			return $dataKode = $this->session->userdata("kdj");
		} else {
			return $dataKode = 0;
		}

	}

	// mengambil data dari data base untuk di table
	public function get_data_semester($tabel, $fields, $where){
		$data = $this->Smesterakademik_model->select_fields_where($tabel, $fields, $where);
		return $data;
	}

	// mengambil data dari database untuk menampilkan di select Bar
	public function get_field_jurusan(){
		//$kdf 		  = $this->session->userdata('kdf');
		$data_jurusan = $this->Smesterakademik_model->select_field_from();
		return $data_jurusan;
	}

	// penampilkan data pada tampilan view
	public function form_pencarian(){

		$level 				= $this->session->userdata('ulevel');
		$dataKode 			= $this->userKode();

		$terserah_jurusan 	= $this->Smesterakademik_model->get_dataSearch($level, $dataKode);
		$data 				= array('terserah_jurusan' => $terserah_jurusan);
		
		$this->load->view('temp/head');
		$this->load->view('ademik/semester_akademik/smtr_akademik', $data);
		$this->load->view('temp/footers');
		$this->load->view('ademik/semester_akademik/smtr_akademik_js');

	}

	public function get_semester_akademik($program, $jurusan)
	{
		$tabel 				= "_v2_tahun";

		$fields 			= array(
									'kode',
									'Nama',
									'KodeJurusan',
									'KodeProgram'
									);

		$where				= array(
									'KodeProgram' => $program,
									'KodeJurusan' => $jurusan,
									);

		$data_semester 		= $this->get_data_semester($tabel, $fields, $where);
		$data 				= array('data_semester' => $data_semester);

		$this->load->view("ademik/semester_akademik/smtr_data", $data);
	}	

	public function get_semester_akademik_edit($program, $jurusan, $kode)
	{
		//echo "get_semester_akademik_edit";
		$tabel 				= "_v2_tahun";

		$fields 			= array(
									'kode',
									'Nama',
									'KodeJurusan',
									'KodeProgram'
									);

		$where				= array(
									'KodeProgram' 	=> $program,
									'KodeJurusan' 	=> $jurusan,
									'kode'			=> $kode
									);

		$data_semester 		= $this->get_data_semester($tabel, $fields, $where);

		return $data_semester;
	}

	public function modal_tambah_semster()
	{
		$level 				= $this->session->userdata('ulevel');
		$dataKode 			= $this->userKode();
		
		$data_jurusan 		= $this->Smesterakademik_model->get_dataSearch($level, $dataKode);

		$this->load->view('ademik/semester_akademik/form_tambah_semster', array('data_jurusan'=>$data_jurusan));
	}

	public function modal_edit_semster($jurusan, $program, $kode)
	{
		//echo "modal_edit_semster";
		$data_jurusan 	= $this->get_field_jurusan($jurusan, $program, $kode);
		$data_semester 	= $this->get_semester_akademik_edit($program, $jurusan, $kode);

        $this->load->view('ademik/semester_akademik/form_edit_semester', array('data_jurusan'=>$data_jurusan, 'data_semester'=>$data_semester));
	}

	public function simpan_data(){
		
			$unip			= $this->session->unip;
			$datakode	  	= $this->userKode();
		
			$KodeJurusan 	= $_POST['Jurusan'];
			$KodeProgram 	= $_POST['Program'];
			$Kode 			= $_POST['kode'];
			$Nama 			= $_POST['nama'];
			$NotActive 		= $_POST['NotActive'];

			$data_insert = array(
								'KodeJurusan'		=> $KodeJurusan,
								'KodeProgram'		=> $KodeProgram,
								'Kode'	  			=> $Kode,
								'Nama' 				=> $Nama,
								'NotActive' 		=> $NotActive,
								'unip' 		 		=> $this->session->userdata('uname'),
								'tgl'         	 	=> date('Y-m-d H:i:s')
			);

			$res = $this->db->insert('_v2_tahun',$data_insert);

			if($res==1){
				echo 1;
			}else{
				echo 0;
			}
			
		}	

		public function update_data(){
		
			$KodeJurusan 	= $_POST['Jurusan'];
			$KodeProgram 	= $_POST['Program'];
			$Kode 			= $_POST['kode'];
			$Nama 			= $_POST['nama'];
			$NotActive 		= $_POST['NotActive'];

			$table = "_v2_tahun";

			$data = array(
								'Nama' 				=> $Nama,
								'NotActive' 		=> $NotActive
			);

			$where = array(
							'KodeJurusan'	=> $KodeJurusan,
							'KodeProgram'	=> $KodeProgram,
							'Kode'	  		=> $Kode
							);

			$res = $this->Smesterakademik_model->update_where($table, $data, $where);

			if($res==1){
				echo 1;
			}else{
				echo 0;
			}
			
		}

	public function delete_data($jurusan, $program, $kode){
		$where = array(
						'KodeJurusan' => $jurusan,
						'KodeProgram' => $program,
						'Kode' 		  => $kode
					);

		$res = $this->Smesterakademik_model->DeleteData('_v2_tahun',$where);
		if ($res==1){
			echo 1;
		}else{
			echo 0;
		}
	}

 	public function serverside_data_semester($program, $jurusan )
    {
    	
        $list 		= $this->Smesterakademik_model->get_datatables($program, $jurusan);

        $data 		= array();
        
        $no 		= $_POST['start'];
        
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->Kode;
            $row[] = $field->Nama;
            $row[] = $field->KodeJurusan;
            $row[] = $field->KodeProgram;
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" 				=> $_POST['draw'],
            "recordsTotal"		=> $this->Smesterakademik_model->count_all(),
            "recordsFiltered" 	=> $this->Smesterakademik_model->count_filtered($program, $jurusan),
            "data" 				=> $data,
        );

        echo json_encode($output);
    }


}