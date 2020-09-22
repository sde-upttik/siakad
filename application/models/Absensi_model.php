<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi_model extends CI_Model{

	public function select_fields($fields, $table)
	{
		$this->db->select($fields);
		$result = $this->db->get($table);
		return $result->result_array();
	}

	public function select_fields_where($table, $fields, $where, $order=null)
	{
		$this->db->select($fields);
		$this->db->where($where);
		if($order != null){
			$this->db->order_by($order, 'ASC');
		}

		$result = $this->db->get($table);
		return $result->result_array();
	}	

	public function select_fields_where_join($table, $fields, $where, $on, $where2=null)
	{
		$this->db->select($fields);
        $this->db->where($where);
        
        if($where2 != null){
            $this->db->or_where($where2);
        }
        
		$this->db->from($table[0]);
		$this->db->join($table[1],  $on[0], 'left');

		$query = $this->db->get();

		$data = array();
		if($query !== FALSE && $query->num_rows() > 0){
		    $data = $query->result_array();
		}

		return $data;
	}	

	public function select_fields_where_join2($table, $fields, $where, $on, $order=null)
	{

		$this->db->select($fields);
		$this->db->where($where);
		$this->db->from($table[0]);
		$this->db->join($table[1],  $on[0], 'left');
		if($order !== null){
			$this->db->order_by($order, 'ASC');
		}
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function update_where($table,$data, $where)
	{
		$this->db->where($where);
		$update = $this->db->update($table,$data);
		if ($update) {
			return 1;
		}
		else {
			return 0;
		}
	}

	public function update($table,$data, $where)
	{

		$update = $this->db->update($table,$data);
		
		if ($update) {
			return 1;
		}
		else {
			return 0;
		}
	}

	public function insert($table, $data)
	{
		$insert = $this->db->insert($table, $data);
		if ($insert) {
			return 1;
		}
		else {
			return 0;
		}
	}

	public function count_row($table, $where)
	{
		$this->db->where($where);
		$result = $this->db->get($table);
		return $result->num_rows();
	}

	public function replace($table, $data)
	{
		$replace = $this->db->replace($table, $data);
		if ($replace) {
			return 1;
		}
		else {
			return 0;
		}
	}

	public function delete($table, $where)
	{
		$this->db->where($where);
		$result = $this->db->delete($table);
		if ($result) {
			return 1;
		}
		else {
			return 0;
		}
	}


    //Get data mahasiswa on absen
    public function getDataAbsenMahasiswa($IDjawal, $semester)
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

        $where 	= array('_v2_krs'.$semester.'.IDJadwal' => $IDjawal);
        $table 	= array('_v2_krs'.$semester);
       	$order  = "NIM"; 
		$response 	= $this->Absensi_model->select_fields_where($table, $fields, $where, $order);
		
        return $response;
    } 


// Get Data From Server
	public function getJadwalAbsensi($semester, $program, $jurusan)
	{
		$where = array(
						'_v2_jadwal.Tahun' 		 => $semester,
						'_v2_jadwal.Program' 	 => $program,
						'_v2_jadwal.KodeJurusan' => $jurusan
                     );
                     
        if($program == "NONREG"){
            $where = "
                        `_v2_jadwal`.`Tahun` = '".$semester."'
                        AND (`_v2_jadwal`.`Program` = 'RESO' OR `_v2_jadwal`.`Program` = 'NONREG') 
                        AND `_v2_jadwal`.`KodeJurusan` = '".$jurusan."'
                    ";
        }

		$fields = array(
						'_v2_jadwal.KodeMK',
						'_v2_jadwal.IDJADWAL',
						'_v2_jadwal.NamaMK',
						'_v2_jadwal.keterangan',
						'_v2_jadwal.Tahun',
						'_v2_jadwal.Program',
						'_v2_jadwal.KodeJurusan',
						'_v2_jadwal.TglVal',
						'_v2_jadwal.validasi',
						'(select COUNT(_v2_krs'.$semester.'.NIM) FROM _v2_krs'.$semester.' WHERE `_v2_jadwal`.`IDJADWAL` = _v2_krs'.$semester.'.`IDJadwal` and st_wali = 1) as jumlah_mahasiswa',
						'_v2_jadwal.IDDosen',
						'_v2_dosen.nip',
						'_v2_dosen.glr_depan',
						'_v2_dosen.Name',
						'_v2_dosen.glr_belakang',
						'_v2_dosen.gelar',
						'_v2_dosen.gelarS2',
						'_v2_dosen.gelarS3',
						'_v2_dosen.gelarGB' 
						);

		$table	= array(
						'_v2_jadwal',
						'_v2_dosen',
						'_v2_krs'.$semester
					    );

		$on 	= array(
                        '_v2_jadwal.IDDosen  = _v2_dosen.nip'
					   	);

        $data_jadwal	= $this->select_fields_where_join($table, $fields, $where, $on);

		return $data_jadwal;
	}


	//Update Absen Dosen
	public function updateAbsenDosen($data, $id_jadwal)
	{
		
		$table		= "_v2_jadwal";

		$result  	= $this->update_where($table, $data, $id_jadwal);

		return $result;
	}

	//Delete Absen Dosen
	public function deleteJadwalDosen($where)
	{
		$count = $this->count_row('_v2_jadwal_absen_dosen', $where);
		if ($count >= 1) {
			$this->db->where($where);
			// $this->db->where_in($where_in);
			$reuslt = $this->db->delete('_v2_jadwal_absen_dosen');
			return $this->db->last_query();			
		}
		else{
			return 0;
			// return $this->db->last_query();			

		}

	}

	// Insert data dosen ke tabel jadwal absen dosen
	public function insertJadwalDosen($data, $where)
	{		
		$cek_absen 	= $this->count_row('_v2_jadwal_absen_dosen', $where);

		if ($cek_absen >= 1) {

			$insert_data_absen_dosen 	= $this->update_where('_v2_jadwal_absen_dosen', $data, $where); 
			
		}
		else{

			$insert_data_absen_dosen 	= $this->insert('_v2_jadwal_absen_dosen', $data);	

		}

		if ($insert_data_absen_dosen) {
			return 1;
		}
		else{
			return 0;
		}
	}


	public function jumlah_tatap_muka($IDJADWAL)
	{
		$tabel = "_v2_jadwal";

		$fields= array();

		for ($i=1; $i <= 20 ; $i++) { 
			array_push($fields, 'hr_'.$i);
		}

		$where = array(
						'IDJADWAL' => $IDJADWAL, 
						);

		$respon = $this->select_fields_where($tabel, $fields, $where);

		$tatap_muka=0;

		for ($i=1; $i <= 20 ; $i++) { 
			if ($respon[0]['hr_'.$i] != "0000-00-00" ) {
				$tatap_muka = $tatap_muka + 1;
			}
		}


		return $tatap_muka;

	}

	//Get Range Nilai
	public function getRangeNilai($KodeFakultas, $KodeJurusan)
	{
		$table 					= "_v2_nilai";
		$where['NotActive'] 	= "N";
		$kdf 					= $this->session->userdata("kdf");
		

		$this->db->where($where);

		if ($kdf == 'D' || $kdf == 'C' || $kdf == 'F' || $kdf == 'K2M' || $kdf == 'O'  ) {
			$this->db->where("KodeFakultas",$KodeFakultas);
		}else{
			$this->db->where("(KodeFakultas = '".$KodeFakultas."' OR KodeFakultas = 'All')");
		}
		
		$this->db->where("KodeJurusan",$KodeJurusan);

		return $this->db->get($table)->result_array();
	}

	//Get Range Nilai
	public function getRangeNilaiTester($KodeFakultas, $KodeJurusan)
	{
		$table 					= "_v2_nilai";
		$where['NotActive'] 	= "N";
		$kdf 					= $this->session->userdata("kdf");
		

		$this->db->where($where); 

		if ($kdf == 'D' || $kdf == 'C' || $kdf =='A' || $kdf == 'F') {
			$this->db->where("KodeFakultas",$KodeFakultas);
			$this->db->where("KodeJurusan",$KodeJurusan);
		}
		elseif ($kdf == 'K2M' || $kdf == 'K2T' || $kdf == 'P' || $kdf == 'E' || $kdf == 'O') {
			$this->db->where("KodeFakultas",$KodeFakultas);
			$this->db->where("KodeJurusan",$KodeJurusan);
		}
		else{
			$this->db->where("(KodeFakultas = '".$KodeFakultas."' OR KodeFakultas = 'All')");
		}
		
		return $this->db->get($table)->result_array();
		// $this->db->get($table)->result_array();
		// return $this->db->last_query(); 
	}

	public function cetak_cpna($Tahun, $IDJADWAL)
	{

		$tabel_krs	= '_v2_krs'.$Tahun;		
		
		$tabel 	 	= array(
								'_v2_jadwal',
								$tabel_krs,
							);

		$fields 	= array(
							'_v2_jadwal.IDJADWAL',
							'_v2_jadwal.NamaMK',
							'_v2_jadwal.KodeMK',
							'_v2_jadwal.IDDosen',
							'_v2_jadwal.Tahun',
							'_v2_jadwal.Program',
							'_v2_jadwal.Keterangan',
							'(SELECT _v2_jurusan.Nama_Indonesia FROM _v2_jurusan WHERE _v2_jadwal.KodeJurusan = _v2_jurusan.Kode) AS nama_jurusan',
							'(SELECT _v2_dosen.Name FROM _v2_dosen WHERE _v2_dosen.nip = _v2_jadwal.IDDosen) AS nama_dosen',
							'_v2_jadwal.Kelas',
							'_v2_jadwal.KodeRuang',
							$tabel_krs.'.NIM',
							'(SELECT _v2_mhsw.Name FROM _v2_mhsw WHERE _v2_mhsw.NIM = '.$tabel_krs.'.NIM) AS nama_mahasiswa',
							'(SELECT _v2_mhsw.TahunAkademik FROM _v2_mhsw WHERE _v2_mhsw.NIM = '.$tabel_krs.'.NIM) AS TahunAkademik',
							$tabel_krs.'.Hadir',
							$tabel_krs.'.Tugas1',
							$tabel_krs.'.NilaiPraktek',
							$tabel_krs.'.NilaiMID',
							$tabel_krs.'.NilaiUjian',
							$tabel_krs.'.Nilai',
							$tabel_krs.'.GradeNIlai',
                            );
        for ($i=1; $i <= 36 ; $i++) { 
            array_push($fields, $tabel_krs.'.hr_'.$i);
        }        
        for ($i=1; $i <= 36 ; $i++) { 
            array_push($fields, '_v2_jadwal.hr_'.$i.' AS abd_'.$i);            
        }

		$where 		= array(
							'_v2_jadwal.IDJADWAL' => $IDJADWAL,
							'_v2_jadwal.NotActive'=> "N",
							$tabel_krs.".st_wali" => "1",
							);

		$on 		= array(
							'_v2_jadwal.IDJADWAL  = '.$tabel_krs.'.IDJadwal'
						   	);

		$order		= $tabel_krs.'.NIM';

		$respon 	= $this->select_fields_where_join2($tabel, $fields, $where, $on, $order);

		return $respon;
    }	
    
	public function cetak_rekap_mahasiswa($Tahun, $IDJADWAL)
	{

		$tabel_krs	= '_v2_krs'.$Tahun;		
		
		$tabel 	 	= array(
								'_v2_jadwal',
								$tabel_krs,
							);

		$fields 	= array(
							'_v2_jadwal.IDJADWAL',
							'_v2_jadwal.NamaMK',
							'_v2_jadwal.KodeMK',
							'_v2_jadwal.IDDosen',
							'_v2_jadwal.Tahun',
							'(SELECT _v2_jurusan.Nama_Indonesia FROM _v2_jurusan WHERE _v2_jadwal.KodeJurusan = _v2_jurusan.Kode) AS nama_jurusan',
							'(SELECT _v2_dosen.Name FROM _v2_dosen WHERE _v2_dosen.nip = _v2_jadwal.IDDosen) AS nama_dosen',
							'_v2_jadwal.Kelas',
							'_v2_jadwal.KodeRuang',
							$tabel_krs.'.NIM',
							'(SELECT _v2_mhsw.Name FROM _v2_mhsw WHERE _v2_mhsw.NIM = '.$tabel_krs.'.NIM) AS nama_mahasiswa',
							$tabel_krs.'.Hadir',
							);

		$where 		= array(
							'_v2_jadwal.IDJADWAL'   => $IDJADWAL,
							'_v2_jadwal.NotActive'  => "N",
							$tabel_krs.'.st_wali'   => "1",
							);

		$on 		= array(
							'_v2_jadwal.IDJADWAL  = '.$tabel_krs.'.IDJadwal'
						   	);

		$respon 	= $this->select_fields_where_join2($tabel, $fields, $where, $on);

		return $respon;
	}

	public function data_asisten_dosen($IDJadwal)
	{
		$tabel		= '_v2_jadwalassdsn';

		$fields 	= array(
							'IDJadwal',
							'IDDosen',
							'(SELECT _v2_dosen.Name FROM _v2_dosen WHERE _v2_dosen.nip = _v2_jadwalassdsn.IDDosen) AS nama_assdosen',
							);

		$where 		= array(
							'IDJadwal'	 => $IDJadwal,
							'NotActive'  => "N",
							);

		$respon 	= $this->select_fields_where($tabel, $fields, $where);

		return $respon;
	}

	public function cetak_rekap_dosen($IDJADWAL)
	{
		$tabel 	 	= array(
								'_v2_jadwal',
							);

		$fields 	= array(
							'_v2_jadwal.IDJADWAL',
							'_v2_jadwal.NamaMK',
							'_v2_jadwal.KodeMK',
							'_v2_jadwal.SKS',
							'(SELECT _v2_hari.Nama FROM _v2_hari WHERE _v2_hari.ID = _v2_jadwal.Hari ) AS Hari',
							'_v2_jadwal.IDDosen',
							'_v2_jadwal.Tahun',
							'(SELECT _v2_jurusan.Nama_Indonesia FROM _v2_jurusan WHERE _v2_jadwal.KodeJurusan = _v2_jurusan.Kode) AS nama_jurusan',
							'(SELECT _v2_dosen.Name FROM _v2_dosen WHERE _v2_dosen.nip = _v2_jadwal.IDDosen) AS nama_dosen',
							'_v2_jadwal.Kelas',
							'_v2_jadwal.KodeRuang',
							'_v2_jadwal.Program',
							'_v2_jadwal.JamMulai',
							'_v2_jadwal.JamSelesai',
							);

		for ($i=1; $i <= 36 ; $i++) { 
			array_push($fields, 'hr_'.$i);
		}

		$where 		= array(
							'_v2_jadwal.IDJADWAL' => $IDJADWAL,
							'NotActive'  => "N",
							);

		$respon 	= $this->select_fields_where($tabel, $fields, $where);

		return $respon;
	}	

	public function cetak_absen_dosen_harian($IDJADWAL)
	{
		$tabel 	 	= array(
								'_v2_jadwal',
							);

		$fields 	= array(
							'_v2_jadwal.IDJADWAL',
							'_v2_jadwal.NamaMK',
							'_v2_jadwal.KodeMK',
							'_v2_jadwal.SKS',
							'(SELECT _v2_hari.Nama FROM _v2_hari WHERE _v2_hari.ID = _v2_jadwal.Hari ) AS Hari',
							'_v2_jadwal.IDDosen',
							'_v2_jadwal.Tahun',
							'(SELECT _v2_jurusan.Nama_Indonesia FROM _v2_jurusan WHERE _v2_jadwal.KodeJurusan = _v2_jurusan.Kode) AS nama_jurusan',
							'(SELECT _v2_dosen.Name FROM _v2_dosen WHERE _v2_dosen.nip = _v2_jadwal.IDDosen) AS nama_dosen',
							'_v2_jadwal.Kelas',
							'_v2_jadwal.KodeRuang',
							'_v2_jadwal.Program',
							'_v2_jadwal.JamMulai',
							'_v2_jadwal.JamSelesai',
							);

		$where 		= array(
							'_v2_jadwal.IDJADWAL' => $IDJADWAL,
							'NotActive'  		  => 'N',
							);

		$respon 	= $this->select_fields_where($tabel, $fields, $where);

		return $respon;
	}

	public function data_absen_dosen($IDJadwal, $tahun)
	{
		$tabel 	 	= array(
								'_v2_jadwal_absen_dosen',
							);

		$fields 	= array(
							'_v2_jadwal_absen_dosen.IDJadwal',
							'_v2_jadwal_absen_dosen.IDDosen',
							'(SELECT _v2_dosen.Name FROM _v2_dosen WHERE _v2_dosen.nip = _v2_jadwal_absen_dosen.IDDosen) AS nama_dosen',
							'_v2_jadwal_absen_dosen.Pertemuan',
							'_v2_jadwal_absen_dosen.Tahun',
							'_v2_jadwal_absen_dosen.status_absen',
							);

		$where 		= array(
							'_v2_jadwal_absen_dosen.IDJadwal' 	=> $IDJadwal,
							'_v2_jadwal_absen_dosen.Tahun' 		=> $tahun,
							);

		$this->db->order_by('_v2_jadwal_absen_dosen.Pertemuan', 'ASC');

		$respon 	= $this->select_fields_where($tabel, $fields, $where);

		return $respon;
	}

	public function cetak_absen_harian_mahasiswa($Tahun, $IDJADWAL)
	{

		$tabel_krs	= '_v2_krs'.$Tahun;		
		
		$tabel 	 	= array(
								'_v2_jadwal',
								$tabel_krs,
							);

		$fields 	= array(
							'_v2_jadwal.IDJADWAL',
							'_v2_jadwal.NamaMK',
							'_v2_jadwal.KodeMK',
							'_v2_jadwal.IDDosen',
							'_v2_jadwal.Tahun',
							'(SELECT _v2_jurusan.Nama_Indonesia FROM _v2_jurusan WHERE _v2_jadwal.KodeJurusan = _v2_jurusan.Kode) AS nama_jurusan',
							'(SELECT _v2_dosen.Name FROM _v2_dosen WHERE _v2_dosen.nip = _v2_jadwal.IDDosen) AS nama_dosen',
							'(SELECT _v2_kelas.Kelas FROM _v2_kelas WHERE _v2_jadwal.kelas = _v2_kelas.ID) AS Kelas',
							'(SELECT fakultas.Singkatan FROM fakultas WHERE _v2_jadwal.KodeFakultas = fakultas.Kode) AS fakultas',
							'_v2_jadwal.Kelas',
							'_v2_jadwal.KodeRuang',
							$tabel_krs.'.NIM',
							'(SELECT _v2_mhsw.Name FROM _v2_mhsw WHERE _v2_mhsw.NIM = '.$tabel_krs.'.NIM) AS nama_mahasiswa',
							);

		$where 		= array(
							'_v2_jadwal.IDJADWAL' 	=> $IDJADWAL,
							'_v2_jadwal.NotActive'  => 'N',
							$tabel_krs.'.st_wali' 	=> '1'
							);

		$on 		= array(
							'_v2_jadwal.IDJADWAL  = '.$tabel_krs.'.IDJadwal'
						   	);

		$respon 	= $this->select_fields_where_join2($tabel, $fields, $where, $on);

		return $respon;
	}	
	
	public function cetak_absen_mahasiswa_5($Tahun, $IDJADWAL)
	{

		$tabel_krs	= '_v2_krs'.$Tahun;		
		
		$tabel 	 	= array(
								'_v2_jadwal',
								$tabel_krs,
							);

		$fields 	= array(
							'_v2_jadwal.IDJADWAL',
							'_v2_jadwal.NamaMK',
							'_v2_jadwal.Keterangan',
							'_v2_jadwal.KodeMK',
							'_v2_jadwal.IDDosen',
							'_v2_jadwal.Tahun',
							'(SELECT _v2_jurusan.Nama_Indonesia FROM _v2_jurusan WHERE _v2_jadwal.KodeJurusan = _v2_jurusan.Kode) AS nama_jurusan',
							'(SELECT fakultas.Singkatan FROM fakultas WHERE _v2_jadwal.KodeFakultas = fakultas.Kode) AS fakultas',
							'(SELECT fakultas.Nama_Indonesia FROM fakultas WHERE _v2_jadwal.KodeFakultas = fakultas.Kode) AS nama_fakultas',
							'(SELECT _v2_dosen.Name FROM _v2_dosen WHERE _v2_dosen.nip = _v2_jadwal.IDDosen) AS nama_dosen',
							'_v2_jadwal.Kelas',
							$tabel_krs.'.NIM',
							'(SELECT _v2_mhsw.Name FROM _v2_mhsw WHERE _v2_mhsw.NIM = '.$tabel_krs.'.NIM) AS nama_mahasiswa',
							'(SELECT _v2_hari.Nama FROM _v2_hari WHERE _v2_hari.ID = _v2_jadwal.Hari ) AS Hari',
							'_v2_jadwal.Kelas',
							'_v2_jadwal.KodeRuang',
							'_v2_jadwal.Program',
							'_v2_jadwal.JamMulai',
							'_v2_jadwal.JamSelesai',
							);

		$where 		= array(
							'_v2_jadwal.IDJADWAL' 	=> $IDJADWAL,
							'_v2_jadwal.NotActive'  => "N",
							"$tabel_krs.st_wali"  	=> "1",
							);

		$on 		= array(
							'_v2_jadwal.IDJADWAL  = '.$tabel_krs.'.IDJadwal'
						   	);

		$respon 	= $this->select_fields_where_join2($tabel, $fields, $where, $on, $tabel_krs.'.NIM');

		return $respon;
	}

	public function getDataBebanMengajarDosen1($idjadwal, $IDDosen, $tahun, $KodeMK)
	{ 

		$this->db->select("
							_v2_dosen.Name,
							_v2_dosen.nip,
							(select _v2_jadwal.NamaMK FROM _v2_jadwal where _v2_jadwal.IDJADWAL = _v2_jadwal_absen_dosen.IDJadwal ) as id2,
							_v2_jadwal.KodeJurusan,
							_v2_jadwal.KodeMK,
							_v2_jadwal.Program,
							_v2_matakuliah.Nama_Indonesia,
							_v2_matakuliah.SKS,
							_v2_jadwal.Keterangan,
							(select Nama_Indonesia from _v2_jurusan where _v2_jurusan.Kode = _v2_dosen.KodeJurusan) as nama_jurusan,
							(select COUNT(NIM) from _v2_krs$tahun where _v2_krs$tahun.IDJadwal = _v2_jadwal.IDJADWAL) as Jumlah_mhs,
							(select COUNT(IDJadwal) from _v2_jadwal_absen_dosen where _v2_jadwal_absen_dosen.IDJadwal = _v2_jadwal.IDJadwal ) as Jumlah_pertemuan,
							(select COUNT(IDJadwal) from _v2_jadwal_absen_dosen where _v2_jadwal_absen_dosen.IDJadwal = _v2_jadwal.IDJADWAL and _v2_jadwal_absen_dosen.IDDosen = '$IDDosen' ) as Jumlah_dosen
						");
		$this->db->from('_v2_dosen');
		$this->db->join('_v2_jadwal_absen_dosen', '_v2_jadwal_absen_dosen.IDDosen = _v2_dosen.nip', 'LEFT');
		$this->db->join('_v2_jadwal', "_v2_jadwal.IDDosen = _v2_dosen.nip");
		$this->db->join('_v2_matakuliah', '_v2_matakuliah.Kode = _v2_jadwal.KodeMK');
		$this->db->where(
						  array(
						  			'_v2_dosen.nip' 			=> $IDDosen,
						  			'_v2_jadwal.IDDosen' 		=> $IDDosen,
						  			'_v2_jadwal.Tahun' 			=> $tahun,
						  			'_v2_jadwal.KodeJurusan'	=> "D101",
						  			'_v2_matakuliah.KodeJurusan'=> "D101",
						  		 )
						);
		$this->db->group_by("_v2_jadwal.IDJADWAL");

		return $this->db->get()->result_array();
	}

	public function getDataBebanMengajarDosen2($idjadwal, $IDDosen, $tahun, $KodeMK)
	{ 

		$this->db->select("
							_v2_dosen.Name,
							_v2_dosen.nip,
							(select _v2_jadwal.NamaMK FROM _v2_jadwal where _v2_jadwal.IDJADWAL = _v2_jadwalassdsn.IDJadwal ) as id2,
							_v2_jadwal.KodeJurusan,
							_v2_jadwal.KodeMK,
							_v2_jadwal.Program,
							_v2_matakuliah.Nama_Indonesia,
							_v2_matakuliah.SKS,
							_v2_jadwal.Keterangan,
							(select Nama_Indonesia from _v2_jurusan where _v2_jurusan.Kode = _v2_dosen.KodeJurusan) as nama_jurusan,
							(select COUNT(NIM) from _v2_krs$tahun where _v2_krs$tahun.IDJadwal = _v2_jadwal.IDJADWAL) as Jumlah_mhs,
							(select COUNT(IDJadwal) from _v2_jadwal_absen_dosen where _v2_jadwal_absen_dosen.IDJadwal = _v2_jadwal.IDJadwal ) as Jumlah_pertemuan,
							(select COUNT(IDJadwal) from _v2_jadwal_absen_dosen where _v2_jadwal_absen_dosen.IDJadwal = _v2_jadwal.IDJADWAL and _v2_jadwal_absen_dosen.IDDosen = '$IDDosen' ) as Jumlah_dosen
						");
		$this->db->from('_v2_dosen');
		$this->db->join('_v2_jadwalassdsn', '_v2_jadwalassdsn.IDDosen = _v2_dosen.nip', 'LEFT');
		$this->db->join('_v2_jadwal', '_v2_jadwal.IDJADWAL = _v2_jadwalassdsn.IDJadwal');
		$this->db->join('_v2_matakuliah', '_v2_matakuliah.Kode = _v2_jadwal.KodeMK');
		$this->db->where(
						  array(
						  			'_v2_dosen.nip' 			=> $IDDosen,
						  			'_v2_jadwal.Tahun' 			=> $tahun,
						  			'_v2_jadwal.KodeJurusan'	=> "D101",
						  			'_v2_matakuliah.KodeJurusan'=> "D101",
						  		 )
						);
		$this->db->group_by("_v2_jadwal.IDJADWAL");

		return $this->db->get()->result_array();

	}

	public function getDataMeetLectureMax($idJadwal="")
	{
		$where['IDJadwal'] = $idJadwal;

		$fields = array();

		for ($i=1; $i <= 36 ; $i++) { 
			array_push($fields, "hr_".$i);
		}
		
		$result  		= $this->db->select($fields)->get_where('_v2_jadwal', $where)->result_array();
		$result_clean 	= array_replace($result[0],array_fill_keys(array_keys($result[0], null),''));
		$count   		= array_count_values($result_clean);

		if (array_key_exists('0000-00-00', $count)) {
			$maxMeet = 36-$count['0000-00-00'] ;
		}
		elseif(array_key_exists('', $count)){
			$maxMeet = 36-$count[''] ;
		}else{
			$maxMeet = 0;
		}

		return $maxMeet;
	}

	public function getDataMeetCollegeMax($nim="", $semester="", $idjadwal="")
	{
		$where['NIM'] 		= $nim;
		$where['idJadwal'] 	= $idjadwal;

		$fields = array();

		for ($i=1; $i <= 36 ; $i++) { 
			array_push($fields, "hr_".$i);
		}
		
		$result  		= $this->db->select($fields)->get_where('_v2_krs'.$semester, $where)->result_array();
		$result_clean 	= array_replace($result[0],array_fill_keys(array_keys($result[0], null),''));
		$count   		= array_count_values($result_clean);
		if (array_key_exists('H', $count)) {
			$maxMeet = $count['H'] ;
		}else{
			$maxMeet = 0;
		}

		return $maxMeet;
	}

	public function updatePercentationAbsensi($nim="", $semester="", $idjadwal="", $precent="")
	{
		$where['NIM'] 		= $nim;
		$where['idJadwal'] 	= $idjadwal;

		$data['Hadir'] 		= $precent;
		$data['prcAbsen'] 	= 1;
		return $this->db->update('_v2_krs'.$semester, $data, $where);
	}


	public function getDataKrs($semester)
	{
		$where['prcAbsen'] = 0;
		$this->db->like('NIM', 'D');  
		return $this->db->get_where('_v2_krs'.$semester,$where, 2000)->result_array();
	}


}