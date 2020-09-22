<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi extends CI_Controller {

//Memanggil model dan library tambahan
	function __construct(){
		parent::__construct();
	    
	    // Mengambil Absensi Model
		$this->load->model('Absensi_model');
		
		// Mengambil App Model 
	    $this->load->model('app');
		
		//Mengambil Library tambahan
		$this->load->library('form_validation');
		
	    // Mengatur Time Zone ke area Asian atau Bangkok
	    date_default_timezone_set("Asia/Bangkok");

	    // Mengatur sesession jika belum login
		$unip 	= $this->session->userdata("unip");
		$uname	= $this->session->userdata('uname');
		$ulevel	= $this->session->userdata('ulevel');
		if (empty($uname) and empty($ulevel) and empty($unip) ){
	    	redirect("https://siakad2.untad.ac.id");			
		}
	}

//Prc Presentasi Kehadiran Berdasarkan tahun KRS
	public function prcAbsen($nim="")
	{

		header( "refresh:5;url=".base_url('ademik/absensi/prcAbsen'));
		
		$semester 		= "20191";
		$dataKrs  		= $this->Absensi_model->getDataKrs($semester);

		// echo $this->db->last_query();

		// print_r($dataKrs);

		foreach ($dataKrs as $krs) {
		// 	//Rumus = JUmlah Pertemuan Hadir Dosen dibahagi dengan pertemuan mahasiswa
			$maxMeetLecture 	= $this->Absensi_model->getDataMeetLectureMax($krs['IDJadwal']);
			$maxMeetCollege 	= $this->Absensi_model->getDataMeetCollegeMax($krs['NIM'], $semester, $krs['IDJadwal']);
			$percentation   	= @($maxMeetCollege / $maxMeetLecture) * 100;

			// print_r($maxMeetLecture);
			$updatePercentation =  $this->Absensi_model->updatePercentationAbsensi($krs['NIM'], $semester, $krs['IDJadwal'], number_format($percentation, 2, '.', ''));

			if ($updatePercentation) {
				echo "idJadwal : ".$krs['IDJadwal']." NIM : ".$krs['NIM']." kehadiran dosen : $maxMeetLecture dan kehadiran mahasiswa : $maxMeetCollege maka persentase kehadiran adalah $percentation <b>Successfully</b><br>";
			}
			else{
				echo "idJadwal : ".$krs['IDJadwal']." NIM : ".$krs['NIM']."<b>Failed</b><br>";
			}
		}
	}

//controler untuk halaman utama absen
	public function index($data_jadwal='null'){
		$data_jurusan = $this->data_jurusan();

		$data_bind = array( 
							'data_jurusan' => $data_jurusan,
							'data_jadwal'  => $data_jadwal
							);

		$this->load->view('temp/head');
		$this->load->view('ademik/absensi_/absensi', $data_bind);
		$this->load->view('temp/footers');
		$this->load->view('ademik/absensi_/absensi_js');
    }

// Mengambil data jurusan
	public function data_jurusan()
	{
        $kd_fakultas  = $this->session->userdata("kdf");
        $kd_jurusan   = $this->session->userdata("kdj");

		$fields 	  = array('kode','Nama_Indonesia');
		$table 		  = '_v2_jurusan';

		if ($kd_fakultas != null && $kd_jurusan != null) {
			$where 		= array(
								'KodeFakultas'	=>  $kd_fakultas,
								'Kode'			=>  $kd_jurusan,
								);
			$data_jurusan 	= $this->Absensi_model->select_fields_where($table, $fields, $where);

		}
		elseif($kd_fakultas != null) {
			$where 		= array(
								'KodeFakultas'	=>  $kd_fakultas
								);
			$data_jurusan 	= $this->Absensi_model->select_fields_where($table, $fields, $where);

		}
		else{
			$data_jurusan 	= $this->Absensi_model->select_fields($fields, $table);	 
		}

		return $data_jurusan;
	}

// Mengambil data Jadwal
	public function data_jadwal()
	{
		$semester 	= $this->input->post('semester');
		$program 	= $this->input->post('program');
		$jurusan 	= $this->input->post('jurusan');

		$dataJadwal = $this->Absensi_model->getJadwalAbsensi($semester, $program, $jurusan);

		// print_r($dataJadwal);

		$data_bind 	= array(
                            'data_jadwal' => $dataJadwal
                            );

		// print_r($data_bind);
		$html = $this->load->view('ademik/absensi_/absensi_jadwal', $data_bind, TRUE);

		echo $html;
	}

// ******************************* Controler Filter *******************************
    public function selector()
    {
        $IDJadwal 		= htmlspecialchars($this->input->post('IDJadwal',true));
        $semester 		= htmlspecialchars($this->input->post('semester',true));
        $kodeFakultas	= $this->session->userdata('kdf');
        $unip 			= $this->session->userdata('unip');
        
        if(($kodeFakultas == "B") && ($unip == "fadlifak") ) {
            $this->absenKumulatifMahasiswa($IDJadwal, $semester);
        }
        else{
            $this->absen_dosen($IDJadwal);
        }
    }

// ******************************* Controler Mahasiswa *******************************
// Absen Mahasiswa

    public function absenKumulatifMahasiswa()
    {
        $IDJadwal 		= htmlspecialchars($this->input->post('IDJadwal',true));
        $semester 		= htmlspecialchars($this->input->post('semester',true));
        
        $data_absen_mahasiswa = $this->Absensi_model->getDataAbsenMahasiswa($IDJadwal, $semester);

		$data_bind				= array(
										'data_absen_mahasiswa' 	=> $data_absen_mahasiswa,
										'semester'				=> $semester,
										);

        $data = $this->load->view('ademik/absensi_/absensiKumulatifMahasiswa', $data_bind, TRUE);
        
		$this->output->set_output($data); 
	}
	
	public function sendDataAbsenKumulatif()
	{
		$id_jadwal 		 = htmlspecialchars($this->input->post('IDJadwal',true));
		$semester 		 = htmlspecialchars($this->input->post('semester',true));
		$jumlahPertemuan = htmlspecialchars($this->input->post('jumlahPertemuan',true));
		$dateAbsen		 = htmlspecialchars($this->input->post('dateAbsen',true));
		$IDDosen		 = htmlspecialchars($this->input->post('IDDosen',true));
		$tableMhs 		 = "_v2_krs".$semester;
		$tableDsn 		 = "_v2_jadwal";
		
		unset($_POST['IDJadwal']);
		unset($_POST['semester']);
		unset($_POST['dateAbsen']);
		unset($_POST['jumlahPertemuan']);
		
		$dataAbsen = array_keys($this->input->post());
		foreach ($dataAbsen as $absen) {
			$data['jmlHadir'] 	= htmlspecialchars($this->input->post($absen,true));
			if ($data['jmlHadir'] >= 1) {
				for ($i=1; $i <= 36 ; $i++) { 
					if($i <= $data['jmlHadir']){
						$data["hr_".$i] = 'H';
					}
					else{
						$data["hr_".$i] = NULL; 
					}

					if($i <= $jumlahPertemuan ){
						$dataDosen['hr_'.$i] = $dateAbsen;
					}
					else{
						$dataDosen["hr_".$i] = NULL; 
					}
				}
				
				$data['Hadir'] 		= 0;
				$whereMhs 			= array('NIM' => $absen, 'IDJadwal' => $id_jadwal );
				$whereDsn 			= array('IDJadwal' => $id_jadwal );

				$this->Absensi_model->update_where($tableMhs, $data, $whereMhs);
			}
		}
		$this->Absensi_model->update_where($tableDsn, $dataDosen, $whereDsn);
		
        for ($i=1; $i <= 36; $i++) { 
			$whereIDDosen['IDJadwal']   = $id_jadwal;
			$fieldsIDDosen[]   				=  'IDDosen';
			$IDDosen = $this->Absensi_model->select_fields_where($tableDsn, $fieldsIDDosen, $whereIDDosen );

            $drDsn['IDJadwal']          =  $id_jadwal;
            $drDsn['IDDosen']           =  $IDDosen[0]['IDDosen'];
            $drDsn['Pertemuan']         =  $i;
            $drDsn['Tahun']             =  $semester;
			$drDsn['status_absen']      =  1;
			
			$whereCek['IDJadwal'] 	= $id_jadwal;
			$whereCek['Tahun'] 		= $semester;
			$whereCek['Pertemuan'] 	= $i;
			
			$cekDataRiwayatDosen = $this->Absensi_model->count_row('_v2_jadwal_absen_dosen', $whereCek);
			if($cekDataRiwayatDosen >=1){
				$this->Absensi_model->delete('_v2_jadwal_absen_dosen', $whereCek);
			}

			if($i <= $jumlahPertemuan){				
				$this->Absensi_model->insert('_v2_jadwal_absen_dosen', $drDsn);
			}
        }

        echo 1;
	}

	public function absen_mahasiswa()
	{
		$IDJadwal 	= $_POST['id_jadwal'];
		
		$pertemuan 	= $_POST['pertemuan'];

		$semester 	= $_POST['semester'];

		$fields 	= array(
							'_v2_krs'.$semester.'.NIM',
							'_v2_krs'.$semester.'.Tahun',
							'_v2_krs'.$semester.'.IDJadwal',
							'_v2_krs'.$semester.'.KodeMK',
							'_v2_krs'.$semester.'.NamaMK',
							'_v2_krs'.$semester.'.IDDosen',
							'(select Name FROM _v2_mhsw where _v2_krs'.$semester.'.NIM = _v2_mhsw.NIM) as nama_mahasiswa'
							);

		//Menambahkan fields hr_1 sampai hr_20
		for ($i=1; $i <= 36 ; $i++) { 
			array_push($fields, "_v2_krs".$semester.".hr_".$i);
		}

		$where 					= array('_v2_krs'.$semester.'.IDJadwal' => $IDJadwal);

		$table 					= array('_v2_krs'.$semester);

		$data_absen_mahasiswa 	= $this->Absensi_model->select_fields_where($table, $fields, $where);

		$data_bind				= array(
										'data_absen_mahasiswa' 	=> $data_absen_mahasiswa,
										'pertemuan'				=> $pertemuan,
										'semester'				=> $semester,
										);

		$data = $this->load->view('ademik/absensi_/absensi_mahasiswa', $data_bind, TRUE);

		
		$this->output->set_output($data); 
	}	

	public function validasi_jadwal()
	{
		$IDJADWAL 			= $_POST['IDJADWAL'];
		$semester			= $_POST['Tahun']; 
		$program 			= $_POST['Program'];
		$jurusan 			= $_POST['KodeJurusan'];
		$tanggal_validasi 	= date("Y-m-d h:i:s ");

		$UserVal			= $this->session->userdata("unip");

		$table		= "_v2_jadwal";

		$data 	 	= array(
							'validasi' 	=> '1',
							'TglVal' 	=> $tanggal_validasi,
							'USerVal' 	=> $UserVal,
							);

		$where 		= array('IDJADWAL' => $IDJADWAL );

		$update_validasi = $this->Absensi_model->update_where($table, $data, $where);

		$last_query = $this->db->last_query();
		if ($update_validasi == 1) {
			$data_jadwal 	= $this->data_jadwal_2($semester, $program, $jurusan);

			$data_bind 		= array('data_jadwal' => $data_jadwal);

			$data = $this->load->view('ademik/absensi_/absensi_jadwal', $data_bind, TRUE);	

			$this->output->set_output($data);
		}
		else{
			echo 0;
		}

	}

	public function absen_mahasiswa_view()
	{
		$IDJadwal 	= $_POST['id_jadwal'];
		
		$pertemuan 	= $_POST['pertemuan'];

		$semester 	= $_POST['semester'];

		$fields 	= array(
							'_v2_krs'.$semester.'.NIM',
							'_v2_krs'.$semester.'.Tahun',
							'_v2_krs'.$semester.'.IDJadwal',
							'_v2_krs'.$semester.'.KodeMK',
							'_v2_krs'.$semester.'.NamaMK',
							'_v2_krs'.$semester.'.IDDosen',
							'(select Name FROM _v2_mhsw where _v2_krs'.$semester.'.NIM = _v2_mhsw.NIM) as nama_mahasiswa'
							);

		//Menambahkan fields hr_1 sampai hr_20
		for ($i=1; $i <= 36 ; $i++) { 
			array_push($fields, "_v2_krs".$semester.".hr_".$i);
		}

		$where 					= array('_v2_krs'.$semester.'.IDJadwal' => $IDJadwal);

		$table 					= array('_v2_krs'.$semester);

		$data_absen_mahasiswa 	= $this->Absensi_model->select_fields_where($table, $fields, $where);

		$data_bind				= array(
										'data_absen_mahasiswa' 	=> $data_absen_mahasiswa,
										'pertemuan'				=> $pertemuan,
										'semester'				=> $semester,
										);

		$data = $this->load->view('ademik/absensi_/absen_mahasiswa_view', $data_bind, TRUE);

		
		$this->output->set_output($data); 
	}

//Update Absen Satu Mahasiswa
	public function update_absen_mahasiswa()
	{
		$status_absen 			= $_POST['status_absen'];

		$nim 					= $_POST['nim'];
		
		$pertemuan 				= $_POST['pertemuan'];
		
		$id_jadwal 				= $_POST['id_jadwal'];

		$semester 				= $_POST['semester'];

		$table 					= "_v2_krs".$semester;

		$where 					= array('NIM' => $nim, 'IDJadwal' => $id_jadwal );
		
		$data 					= array("hr_".$pertemuan => $status_absen);
		
		$update_absen_mahasiswa = $this->Absensi_model->update_where($table, $data, $where);
		
		if ($update_absen_mahasiswa) {
			// echo $this->db->last_query();
			echo 1;
		}else{
			echo 0;
		}
	}

//Update semua Absen Mahasiswa
	public function update_semua_absen_mahasiswa()
	{
		$semester 					= $_POST['semester'];

		$status_absen 				= $_POST['status_absen'];

		$pertemuan 					= $_POST['pertemuan'];

		$id_jadwal					= $_POST['id_jadwal'];

		$table						= "_v2_krs".$semester;

		$where 						= array('IDJadwal' => $id_jadwal );		

		$data 						= array("hr_".$pertemuan => $status_absen);

		$update_absen_mahasiswa 	= $this->Absensi_model->update_where($table, $data, $where);                                                     
		if ($update_absen_mahasiswa) {
			$this->reload($id_jadwal, $pertemuan, $semester);
		}
		else{
			echo 0;
		}
	}

	public function reload($IDJadwal, $pertemuan, $semester)
	{
		$fields 	= array(
							'_v2_krs'.$semester.'.NIM',
							'_v2_krs'.$semester.'.Tahun',
							'_v2_krs'.$semester.'.IDJadwal',
							'_v2_krs'.$semester.'.KodeMK',
							'_v2_krs'.$semester.'.NamaMK',
							'_v2_krs'.$semester.'.IDDosen',
							'(select Name FROM _v2_mhsw where _v2_krs'.$semester.'.NIM = _v2_mhsw.NIM) as nama_mahasiswa'
							);

		//Menambahkan fields hr_1 sampai hr_20
		for ($i=1; $i <= 36 ; $i++) { 
			array_push($fields, "_v2_krs".$semester.".hr_".$i);
		}

		$where 					= array('_v2_krs'.$semester.'.IDJadwal' => $IDJadwal);

		$table 					= array('_v2_krs'.$semester);

		$data_absen_mahasiswa 	= $this->Absensi_model->select_fields_where($table, $fields, $where);

		$data_bind				= array(
										'data_absen_mahasiswa' 	=> $data_absen_mahasiswa,
										'pertemuan'				=> $pertemuan,
										'semester'				=> $semester,
										);

		$data = $this->load->view('ademik/absensi_/absensi_mahasiswa', $data_bind, TRUE);

		
		$this->output->set_output($data); 
	}	

// ******************************* Controler Dosen *******************************

// Absen Dosen
	public function absen_dosen()
	{
		$IDJadwal 	= htmlspecialchars($this->input->post('IDJadwal',true));

		$fields 	= array(
							'KodeMK',
							'NamaMK',
							'Program',
							'KodeJurusan',
							'Tahun',
							'IDDosen',
							'validasi',
							'_v2_jadwal.IDJADWAL',
							'(select Name FROM _v2_dosen where _v2_jadwal.IDDosen = nip) as nama_dosen'
							);

		//Menambahkan fields hr_1 sampai hr_20
		for ($i=1; $i <= 36 ; $i++) { 
			array_push($fields, "hr_".$i);
		}

		$where 				= array('IDJADWAL' => $IDJadwal);

		$table				= '_v2_jadwal';

		$data_absen_dosen 	= $this->Absensi_model->select_fields_where($table, $fields, $where);

		$data_asisten_dosen = $this->data_asisten_dosen($IDJadwal);

		$data_riwayat_dosen = $this->riwayat_absen_dosen($IDJadwal);

		$data_bind 			= array(
									'data_absen_dosen'   => $data_absen_dosen,
									'data_asisten_dosen' => $data_asisten_dosen,
									'data_riwayat_dosen' => $data_riwayat_dosen
									);

		$data = $this->load->view('ademik/absensi_/absensi_dosen', $data_bind, TRUE);

		$this->output->set_output($data); 
	}

// Mengambil data riwayat absen dosen
	public function riwayat_absen_dosen($IDJadwal)
	{
		$fields 				= array(
										'_v2_jadwal_absen_dosen.IDJadwal',
										'_v2_jadwal_absen_dosen.IDDosen',
										'_v2_jadwal_absen_dosen.Pertemuan',
										'_v2_jadwal_absen_dosen.status_absen',
										'(SELECT _v2_dosen.Name FROM _v2_dosen WHERE _v2_jadwal_absen_dosen.IDDosen = _v2_dosen.nip) As nama_dosen'
										);

		$where 					= array('IDJadwal' => $IDJadwal);

		$table					= '_v2_jadwal_absen_dosen';

		$data_riwayat_dosen 	= $this->Absensi_model->select_fields_where($table, $fields, $where);

		return $data_riwayat_dosen;
	}

//validasi Riwayat Absen Dosen
	public function validasi_absen_dosen($data)
	{
		$cek_absen 	= $this->Absensi_model->count_row('_v2_jadwal_absen_dosen', $where);

		if ($cek_absen >= 1) {

			$insert_data_absen_dosen 	= $this->Absensi_model->update_where('_v2_jadwal_absen_dosen', $data_bind, $where); 
			
		}
		else{

			$insert_data_absen_dosen 	= $this->Absensi_model->insert('_v2_jadwal_absen_dosen', $data_bind);	

		}

		if ($insert_data_absen_dosen) {
			return 1;
		}
		else{
			return 0;
		}
	}

//Update Absen Dosen
	public function update_absen_dosen()
	{
		$post = $this->input->post();

		// print_r($post);
		$data = [];

		for ($i=1; $i <= 36 ; $i++) {
			if ($this->input->post('status_absen_dosen'.$i) != 0 ) {
				$this->form_validation->set_rules('id_dosen_penanggungjawab'.$i, 'nama_dosen'.$i, 'required');
        		$this->form_validation->set_rules('hr_'.$i, 'tanggal', 'required');
				$data['hr_'.$i] = $this->input->post('hr_'.$i);
			}
			else{
				$data['hr_'.$i] = "0000-00-00";
			}
		}

		if ($this->form_validation->run() == FALSE)
        {
			if (validation_errors() != null) {
	        	echo validation_errors();
			}
			else{
				$this->proses_data($data, $post);
			}
        }
        else{
			$this->proses_data($data, $post);
        }

	}

	public function proses_data($data, $post)
	{
		$where_query_1['IDJADWAL']  = $post['IDJADWAL'];
		$wherein = [];

		$result = $this->Absensi_model->updateAbsenDosen($data, $where_query_1);



        if ($result == 1) {
        	for ($i=1; $i <= 36 ; $i++) { 
        		if ($this->input->post('status_absen_dosen'.$i) != 0 ) {
        			
        			if ($this->input->post('status_absen_dosen'.$i) == 2){
	        			$data2['IDDosen']   			= $post['id_asisten_dosen'.$i];    				
        			}else{
	        			$data2['IDDosen']   			= $post['id_dosen_penanggungjawab'.$i];    		
        			}

        			$data2['Pertemuan'] 			= $i;
        			$data2['IDJadwal']  			= $post['IDJADWAL'];
        			$data2['Status_absen']     		= $post['status_absen_dosen'.$i];
        			$data2['Tahun']     			= $post['Tahun'];

					$where2 = array(
									'IDJadwal'  => $data2['IDJadwal'],
									'Pertemuan' => $data2['Pertemuan'],
									'Tahun' 	=> $data2['Tahun']
									); 
					
					$result = $this->Absensi_model->insertJadwalDosen($data2, $where2);
				}
				else{
					$where_query_3['IDJadwal'] 	= $post['IDJADWAL'];
					$where_query_3['Tahun'] 	= $post['Tahun'];
					$where_query_3['Pertemuan'] = $i;
					$result = $this->Absensi_model->deleteJadwalDosen($where_query_3);
				}
        	}
        }

        echo 1;
	}

// Ambil data asisten dosen
	public function data_asisten_dosen($id_jadwal)
	{
		$fields = array(
						'_v2_jadwalassdsn.IDDosen',
						'_v2_dosen.name'
						);
		
		$where = "_v2_jadwalassdsn.IDJadwal = '".$id_jadwal."' AND _v2_jadwalassdsn.IDDosen = _v2_dosen.nip";
		
		$table = array(
						'_v2_jadwalassdsn',
						'_v2_dosen'
						);

		$data_asisten_dosen = $this->Absensi_model->select_fields_where($table, $fields, $where);

		return $data_asisten_dosen;
	}

//cetak view
    public function dpnaView()
    {
		$this->load->model('Absensi_model');
		$kdf 		= $this->session->userdata("kdf");

		$IDJADWAL 	= $this->security->xss_clean($this->input->post('IDJADWAL'));
        $Tahun 	 	= $this->security->xss_clean($this->input->post('Tahun'));

        $dtDpna 	= $this->Absensi_model->cetak_cpna($Tahun, $IDJADWAL); 	
        $dtRange	= $this->Absensi_model->getRangeNilai($kdf);
        $dtAsdos	= $this->Absensi_model->data_asisten_dosen($IDJADWAL);

        $data_bind 	= [
                        'data_cpna'     => $dtDpna,
                        'data_asdos'    => $dtAsdos,
                        'data_range'	=> $dtRange
                      ];

        echo "<pre>";
        print_r($data_bind['data_range']);
        echo "</pre>";
    }


}