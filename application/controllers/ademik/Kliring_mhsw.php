<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

class Kliring_mhsw extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->helper('security');
	    $this->load->model('matakuliah_smtr_model');
	    $this->load->model('sinkron_db');
	}

	public function index() {

		//$data['jurusan'] = $this->matakuliah_smtr_model->get_dataSearch();
		$this->app->checksession(); // untuk pengecekan session
	}

	function tanggal_inggris($formattes){

		$id=array("JANUARY","FEBRUARY","MARCH","APRIL","MAY","JUNE","JULY","AUGUST","SEPTEMBER","OCTOBER","NOVEMBER","DECEMBER");
		$tgl = substr($formattes, 0, 2); // memisahkan format tahun menggunakan substring
		$kd = substr($formattes, 2, 2); // memisahkan format tahun menggunakan substring
		$bulan = substr($formattes, 5, 6); // memisahkan format bulan menggunakan substring
		$tahun   = substr($formattes, 8, 11); // memisahkan format tanggal menggunakan substring
		if($tgl=="01")  $tgl="1";
		else if($tgl=="02")  $tgl="2";
		else if($tgl=="03")  $tgl="3";
		else if($tgl=="04")  $tgl="4";
		else if($tgl=="05")  $tgl="5";
		else if($tgl=="06")  $tgl="6";
		else if($tgl=="07")  $tgl="7";
		else if($tgl=="08")  $tgl="8";
		else if($tgl=="09")  $tgl="9";

		$result = $id[(int)$bulan-1]." ". $tgl."<sup>".$kd."</sup> ".$tahun;

		return($result);
	}

	function tanggal_indonesia($formattes){
		$id=array("JANUARI","FEBRUARI","MARET","APRIL","MEI","JUNI","JULI","AGUSTUS","SEPTEMBER","OKTOBER","NOVEMBER","DESEMBER");

		$tgl = substr($formattes, 0, 2); // memisahkan format tahun menggunakan substring
		$i = substr($formattes, 0, 1);
		if($i=='0') $tgl = substr($formattes, 1, 1);

		$bulan = substr($formattes, 3, 4); // memisahkan format bulan menggunakan substring
		$tahun   = substr($formattes, 6, 9); // memisahkan format tanggal menggunakan substring

		$result = $tgl." ".$id[(int)$bulan-1]." ".$tahun;
		return($result);
	}

	public function getDataMahasiswa() { // fungsi untuk mecari semua nilai dari search

		$dataSearch = $this->security->xss_clean($this->input->post('dataSearch'));

		if (empty($dataSearch)) {

			$data['footerSection'] = "<script type='text/javascript'>
 				swal({
					title: 'Pemberitahuan',
					type: 'warning',
					html: true,
					text: 'Silahkan mengisi terlebih dahulu NIM pada Text Input',
					confirmButtonColor: '#f7cb3b',
				});
		    </script>";

			$this->load->view('dashbord',$data);

		} else {

			$GetField = $this->app->GetFields("kli_wisuda.st_kliring, m.NIM, m.Name, m.id_reg_pd, m.TotalSKS, m.TotalSKSLulus, m.IPK, j.Kode kdj, j.Nama_Indonesia as nmj, f.Kode kdf, f.Nama_Indonesia as nmf, jp.Nama as jenjang, st_mhsw.Nama as status, m.StatusAwal", "_v2_mhsw m left join _v2_jurusan j on m.KodeJurusan=j.Kode left join fakultas f on j.KodeFakultas=f.Kode left join _v2_jenjangps jp on j.Jenjang=jp.Kode left join _v2_statusmhsw st_mhsw on m.status=st_mhsw.Kode left join _v2_kliring_wisuda kli_wisuda on m.NIM=kli_wisuda.NIM", "m.NIM", "$dataSearch")->result(); // untuk dosen pengampu dan asisten dosen
			$data['detailmhsw'] = $GetField;

			$tahun_khs = $this->app->GetField("NIM, Tahun", "_v2_khs", "NIM='$dataSearch'", "")->result(); // untuk pengecekan tahun di tabel _v2_khs
			//$data['detail_tahun'] = $tahun_khs;

			$i = 0;

			foreach ($tahun_khs as $khs){
				$nim = $khs->NIM;
				$tahun = $khs->Tahun;
				$tahun_krs = $khs->Tahun;

				/*if ($tahun == "20161"){
					$tahun = "";
				}*/

				$tahun_khs_baru = $this->app->GetField("ID,IDJadwal ,KodeMK, NamaMK, SKS, GradeNilai, Bobot, Tahun, Sesi, NotActive, NotActive_KRS, '$tahun' as tahun_tabel", "_v2_krs$tahun", "NIM='$dataSearch'", "(Tahun='$tahun_krs' or Tahun='TR')")->result(); // untuk pengecekan tahun di tabel _v2_khs
				$data['detail_tahun'][$i] = $tahun_khs_baru;
				$i++;
			}

			// atas nilai transfer mahasiswa
			$tahun_khs_baru = $this->app->GetField("ID,IDJadwal ,KodeMK, NamaMK, SKS, GradeNilai, Bobot, Tahun, Sesi, NotActive, NotActive_KRS, 'TR' as tahun_tabel", "_v2_krsTR", "NIM='$dataSearch'", "(Tahun='TR' or Tahun='TR')")->result(); // untuk pengecekan tahun di tabel _v2_khs
			$data['detail_tahun'][$i] = $tahun_khs_baru;
			$i++;
			// bawah nilai transfer mahasiswa

			$data['jumlah_array'] = $i;

			$data['nim'] = $dataSearch;

			$data['tambahnilai'] = $this->app->GetFields("*", "_v2_tambah_nilai_kliring", "NIM", "$dataSearch")->row();

			$data['footerSection'] = "<script type='text/javascript'>
 				$('#matakuliah').DataTable();
		    </script>";

			$this->load->view('dashbord',$data);

		}

	}

	private function getDataMahasiswa_data($dataSearch, $status) { // fungsi untuk mecari semua nilai, guna mengembalikan nilai ke dashboard, tipe private

		if (empty($dataSearch)) {

			$data['footerSection'] = "<script type='text/javascript'>
 				swal({
					title: 'Pemberitahuan',
					type: 'warning',
					html: true,
					text: 'Silahkan mengisi terlebih dahulu NIM pada Text Input',
					confirmButtonColor: '#f7cb3b',
				});
		    </script>";

			$this->load->view('dashbord',$data);

		} else {

			$GetField = $this->app->GetFields("kli_wisuda.st_kliring, m.NIM, m.Name, m.id_reg_pd, m.TotalSKS, m.TotalSKSLulus, m.IPK, j.Kode kdj, j.Nama_Indonesia as nmj, f.Kode kdf, f.Nama_Indonesia as nmf, jp.Nama as jenjang, st_mhsw.Nama as status, m.StatusAwal", "_v2_mhsw m left join _v2_jurusan j on m.KodeJurusan=j.Kode left join fakultas f on j.KodeFakultas=f.Kode left join _v2_jenjangps jp on j.Jenjang=jp.Kode left join _v2_statusmhsw st_mhsw on m.status=st_mhsw.Kode left join _v2_kliring_wisuda kli_wisuda on m.NIM=kli_wisuda.NIM", "m.NIM", "$dataSearch")->result(); // untuk dosen pengampu dan asisten dosen
			$data['detailmhsw'] = $GetField;

			$tahun_khs = $this->app->GetField("NIM, Tahun", "_v2_khs", "NIM='$dataSearch'", "")->result(); // untuk pengecekan tahun di tabel _v2_khs
			//$data['detail_tahun'] = $tahun_khs;

			$i = 0;

			foreach ($tahun_khs as $khs){
				$nim = $khs->NIM;
				$tahun = $khs->Tahun;
				$tahun_krs = $khs->Tahun;

				/*if ($tahun == "20161"){
					$tahun = "";
				}*/

				$tahun_khs_baru = $this->app->GetField("ID,IDJadwal ,KodeMK, NamaMK, SKS, GradeNilai, Bobot, Tahun, Sesi, NotActive, NotActive_KRS, '$tahun' as tahun_tabel", "_v2_krs$tahun", "NIM='$dataSearch'", "(Tahun='$tahun_krs' or Tahun='TR')")->result(); // untuk pengecekan tahun di tabel _v2_khs
				$data['detail_tahun'][$i] = $tahun_khs_baru;
				$i++;
			}

			// atas nilai transfer mahasiswa
			$tahun_khs_baru = $this->app->GetField("ID,IDJadwal ,KodeMK, NamaMK, SKS, GradeNilai, Bobot, Tahun, Sesi, NotActive, NotActive_KRS, 'TR' as tahun_tabel", "_v2_krsTR", "NIM='$dataSearch'", "(Tahun='TR' or Tahun='TR')")->result(); // untuk pengecekan tahun di tabel _v2_khs
			$data['detail_tahun'][$i] = $tahun_khs_baru;
			$i++;
			// bawah nilai transfer mahasiswa

			$data['jumlah_array'] = $i;

			$data['nim'] = $dataSearch;

			if (!empty($status)){
				$status = "<script type='text/javascript'>
	 				swal({
						title: 'Pemberitahuan',
						type: 'success',
						html: true,
						text: 'Berhasil',
						confirmButtonColor: '#f7cb3b',
					});
			    </script>";
			}

			$data['footerSection'] = "<script type='text/javascript'>
 				$('#matakuliah').DataTable();
		    </script>$status";

			$this->load->view('dashbord',$data);

		}

	}

	public function changestatus() {
		$act = $this->input->post('act');
		$nim = $this->input->post('nim');
		$tahun = $this->input->post('tahun');
		$id = $this->input->post('id');

		$data = $this->delete_spaces($nim);

		if ( $data == FALSE ) {
			$dataError = array(
				'ket' => 'error',
				'pesan' => 'Kode Mata Kuliah Tidak Boleh Menggunakan Spasi'
			);

			echo json_encode($dataError);

		} else {

			$config = array(
				array(
					'field' => 'nim',
					'label' => 'NIM',
					'rules' => 'required|max_length[100]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maksimal 100 Karakter',
					)
				),
			);

			$this->form_validation->set_rules($config);

			if ( $this->form_validation->run() == FALSE ) {

				$dataError = array(
					'ket' => 'error',
					'pesan' => validation_errors()
				);

				echo json_encode($dataError);

			} else {

				$dataSukses = array(
					'nim' => $nim,
					'tahun' => $tahun,
					'id' => $id,
				);

				$dataClean = $this->security->xss_clean($dataSukses);

				if ( $act == '1') { // merubah status nilai dari Active Ke Not Active
					$status = "Y";
				} else if ( $act == '2') { // merubah status nilai dari Not Active Ke Active
					$status = "N";
				}

				$value = array(
					'NotActive' => $status,
				);

				$kondisi = array(
					'NIM' => $this->db->escape_str($nim),
					'ID' => $this->db->escape_str($id),
				);

				// maksudnya where ($kondisi) or (or_where)
				/*$kondisi = array(
					'Tahun' => intval($tahun),
					'NIM' => $this->db->escape_str($nim),
					'ID' => $this->db->escape_str($id),
				);*/

				//$this->db->where($kondisi);
				//$this->db->or_where('Tahun', 'TR');


				// maksudnya where $kondisi and (Tahun='$tahun' or Tahun = 'TR')


				$this->db->where($kondisi);
				$where = "(Tahun='$tahun' or Tahun = 'TR')";
				$this->db->where($where);

				//if ($tahun == "20161") $tahun = ""; // tahun untuk memnentukan krs yang di tuju

				$this->db->update("_v2_krs$tahun", $value);

				$Statusupdate= array(
					'ket' => 'sukses',
					'pesan' => 'Matakuliah Berhasil Diupdate'
				);

				echo json_encode($Statusupdate);


			}
		}
	}

	public function changestatus_krs() {
		$act = $this->input->post('act');
		$nim = $this->input->post('nim');
		$tahun = $this->input->post('tahun');
		$id = $this->input->post('id');

		$data = $this->delete_spaces($nim);

		if ( $data == FALSE ) {
			$dataError = array(
				'ket' => 'error',
				'pesan' => 'Kode Mata Kuliah Tidak Boleh Menggunakan Spasi'
			);

			echo json_encode($dataError);

		} else {

			$config = array(
				array(
					'field' => 'nim',
					'label' => 'NIM',
					'rules' => 'required|max_length[100]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maksimal 100 Karakter',
					)
				),
			);

			$this->form_validation->set_rules($config);

			if ( $this->form_validation->run() == FALSE ) {

				$dataError = array(
					'ket' => 'error',
					'pesan' => validation_errors()
				);

				echo json_encode($dataError);

			} else {

				$dataSukses = array(
					'nim' => $nim,
					'tahun' => $tahun,
					'id' => $id,
				);

				$dataClean = $this->security->xss_clean($dataSukses);

				if ( $act == '1') { // merubah status nilai dari Active Ke Not Active
					$status = "Y";
				} else if ( $act == '2') { // merubah status nilai dari Not Active Ke Active
					$status = "N";
				}

				$value = array(
					'NotActive_KRS' => $status,
				);

				$kondisi = array(
					'NIM' => $this->db->escape_str($nim),
					'ID' => $this->db->escape_str($id),
				);

				// maksudnya where ($kondisi) or (or_where)
				/*$kondisi = array(
					'Tahun' => intval($tahun),
					'NIM' => $this->db->escape_str($nim),
					'ID' => $this->db->escape_str($id),
				);*/

				//$this->db->where($kondisi);
				//$this->db->or_where('Tahun', 'TR');


				// maksudnya where $kondisi and (Tahun='$tahun' or Tahun = 'TR')


				$this->db->where($kondisi);
				$where = "(Tahun='$tahun' or Tahun = 'TR')";
				$this->db->where($where);

				//if ($tahun == "20161") $tahun = ""; // tahun untuk memnentukan krs yang di tuju

				$this->db->update("_v2_krs$tahun", $value);

				$Statusupdate= array(
					'ket' => 'sukses',
					'pesan' => 'Matakuliah Berhasil Diupdate'
				);

				echo json_encode($Statusupdate);

			}
		}
	}

	private function delete_spaces($data) {

		return ( ! preg_match("~\s~", $data)) ? TRUE : FALSE;

	}

	public function nonactive_nol_e() {

		// fungsi ini akan meng Non Aktifkan semua Nilai 0 dan E pada Nilai Mahasiswa

		$this->app->check_modul(); // untuk pengecekan modul

		$dataSearch = $this->uri->segment(4);

		$GetField = $this->app->GetFields("m.NIM, m.Name, j.Kode kdj, j.Nama_Indonesia as nmj, f.Kode kdf, f.Nama_Indonesia as nmf, jp.Nama as jenjang, st_mhsw.Nama as status, m.StatusAwal", "_v2_mhsw m left join _v2_jurusan j on m.KodeJurusan=j.Kode left join fakultas f on j.KodeFakultas=f.Kode left join _v2_jenjangps jp on j.Jenjang=jp.Kode left join _v2_statusmhsw st_mhsw on m.status=st_mhsw.Kode", "NIM", "$dataSearch")->result(); // untuk dosen pengampu dan asisten dosen

		$tahun_khs = $this->app->GetField("NIM, Tahun", "_v2_khs", "NIM='$dataSearch'", "")->result(); // untuk pengecekan tahun di tabel _v2_khs

		foreach ($tahun_khs as $khs){
			$nim = $khs->NIM;
			$tahun = $khs->Tahun;
			$tahun_krs = $khs->Tahun;

			/*if ($tahun == "20161"){
				$tahun = "";
			}*/

			$this->db->query("update _v2_krs$tahun set NotActive='Y' where NIM='$nim' and (GradeNilai IS NULL or GradeNilai='' or GradeNilai='E')");
		}

		$this->getDataMahasiswa_data($dataSearch, "");
	}

	/*public function Sinkron_sapta() {
		$this->app->check_modul(); // untuk pengecekan modul
		$nim = "F55116123";
		$this->sinkron_db->Sinkron_sapta($nim);
	}

	public function Sinkron_wisuda() {
		$this->app->check_modul(); // untuk pengecekan modul
		$nim = "F55116123";
		$this->sinkron_db->Sinkron_wisuda($nim);
	}

	public function Sinkron_kkn() {
		$this->app->check_modul(); // untuk pengecekan modul
		$nim = "F55116123";
		$this->sinkron_db->Sinkron_kkn($nim);
	}

	public function Sinkron_siakad_lama() {
		$this->app->check_modul(); // untuk pengecekan modul
		$value = "1";
		$GetField = $this->sinkron_db->GetFields_siakad_lama("*", "aktivitas_mahasiswa", "id_akt_mhs", "$value")->result();
		foreach ($GetField as $a){
			echo $a->id_akt_mhs." - ".$a->judul_akt_mhs;
		}
	}*/

	public function isikliring() {

		$this->app->checksession_ajax();

		$this->app->check_modul(); // untuk pengecekan modul

		$nim = $this->input->post('nim');

		$data = $this->delete_spaces($nim);

		if ( $data == FALSE ) {
			$dataError = array(
				'ket' => 'error',
				'pesan' => 'NIM Tidak Boleh Menggunakan Spasi'
			);

			echo json_encode($dataError);

		} else {

			$config = array(
				array(
					'field' => 'nim',
					'label' => 'NIM',
					'rules' => 'required|max_length[100]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maksimal 100 Karakter',
					)
				),
			);

			$this->form_validation->set_rules($config);

			if ( $this->form_validation->run() == FALSE ) {

				$dataError = array(
					'ket' => 'error',
					'pesan' => validation_errors()
				);

				echo json_encode($dataError);

			} else {

				$dataSukses = array(
					'nim' => $nim,
				);

				$dataClean = $this->security->xss_clean($dataSukses);

				$row = $this->app->GetFields("`NIM`,`Name`,`TglLahir`,TahunStatus,`IPK`,`TotalSKS`,`NomorSKYudisium`,`TglSKYudisium`,`Predikat`,`LamaStudiThn`,
				`LamaStudiBln`,`LamaStudiHari`,`PengujiTA1`,`PengujiTA2`,`PengujiTA3`,`PengujiTA4`,`PengujiTA5`,`PengujiTA6`,`PengujiTA7`,
				`JudulTA`,`JudulTA2`", "_v2_mhsw", "NIM", "$nim")->row();

				$kondisi = "NotActive='N'";

				$GetField = $this->app->GetField("NIP, concat(Name, ' ' , Gelar, ' - ', NIP) as nm_dosen", "_v2_dosen", "$kondisi", "")->result_array(); // untuk dosen pengampu dan asisten dosen

				$options = "";

				foreach ($GetField as $dosen) {
					$options .= "<option value=".$dosen['NIP'].">".$dosen['nm_dosen']."</option>";
				}

				if ($row->Predikat == "") {
					$Predikat = '<option value="" selected>No Predikat</option>';
				} else {
					$Predikat = '<option value="'.$row->Predikat.'" selected>'.$row->Predikat.'</option>';
				}

				$PengujiTA1 = '<option value="'.$row->PengujiTA1.'">'.$row->PengujiTA1.'</option>'.$options;
				$PengujiTA2 = '<option value="'.$row->PengujiTA2.'">'.$row->PengujiTA2.'</option>'.$options;
				$PengujiTA3 = '<option value="'.$row->PengujiTA3.'">'.$row->PengujiTA3.'</option>'.$options;
				$PengujiTA4 = '<option value="'.$row->PengujiTA4.'">'.$row->PengujiTA4.'</option>'.$options;
				$PengujiTA5 = '<option value="'.$row->PengujiTA5.'">'.$row->PengujiTA5.'</option>'.$options;
				$PengujiTA6 = '<option value="'.$row->PengujiTA6.'">'.$row->PengujiTA6.'</option>'.$options;
				$PengujiTA7 = '<option value="'.$row->PengujiTA7.'">'.$row->PengujiTA7.'</option>'.$options;

				$updatekliring= array(
					'ket' => 'sukses',
					'pesan' => 'Matakuliah Berhasil Diupdate',
					'NIM' =>$row->NIM,
					'Name' =>  str_replace("\'", "'", $row->Name),
					'TglLahir' => $row->TglLahir,
					'TahunStatus' => $row->TahunStatus,
					'IPK' => $row->IPK,
					'TotalSKS' => $row->TotalSKS,
					'NomorSKYudisium' => $row->NomorSKYudisium,
					'TglSKYudisium' => $row->TglSKYudisium,
					'Predikat' => $Predikat,
					'LamaStudiThn' => $row->LamaStudiThn,
					'LamaStudiBln' => $row->LamaStudiBln,
					'LamaStudiHari' => $row->LamaStudiHari,
					'PengujiTA1' => $PengujiTA1,
					'PengujiTA2' => $PengujiTA2,
					'PengujiTA3' => $PengujiTA3,
					'PengujiTA4' => $PengujiTA4,
					'PengujiTA5' => $PengujiTA5,
					'PengujiTA6' => $PengujiTA6,
					'PengujiTA7' => $PengujiTA7,
					'JudulTA' => $row->JudulTA,
					'JudulTA2' => $row->JudulTA2
				);

				echo json_encode($updatekliring);

			}
		}
	}

	public function simpan_isikliring() {

		$predikat_sing = $this->input->post('predikat');
		$nim = $this->input->post('nim');

		if($predikat_sing == "M"){
			$predikat = "Memuaskan";
			$predikaten="Satisfactory";
		}else if($predikat_sing == "SM"){
			$predikat = "Sangat Memuaskan";
			$predikaten="Very Satisfactory";
		}else if($predikat_sing == "P"){
			$predikat = "Pujian";
			$predikaten="Cum Laude";
		}else if($predikat_sing == ""){
			$predikat = "";
			$predikaten="";
		}

		if($predikat_sing == "Sangat Memuaskan"){
			$predikat = $predikat_sing;
			$predikaten="Very Satisfactory";
		}else if($predikat_sing == "Memuaskan"){
			$predikat = $predikat_sing;
			$predikaten="Satisfactory";
		}else if($predikat_sing == "Pujian"){
			$predikat = $predikat_sing;
			$predikaten="Cum Laude";
		}

		$kondisi = array(
			'NIM' => $nim
		);

		$value = array(
			'Name' => $this->db->escape_str($this->input->post('name')),
			'TglLahir' => $this->input->post('tgllahir'),
			//'semester' => $this->input->post('semester'),
			'IPK' => $this->input->post('ipk'),
			'TotalSKS' => $this->input->post('totsks'),
			'NomorSKYudisium' => $this->input->post('skyudisium'),
			'TglSKYudisium' => $this->input->post('tglyudisium'),
			'Predikat' => $predikat,
			'PredikatLulus' => $predikaten,
			'LamaStudiThn' => $this->input->post('masastudi_tahun'),
			'LamaStudiBln' => $this->input->post('masastudi_bulan'),
			'LamaStudiHari' => $this->input->post('masastudi_hari'),
			'PengujiTA1' => $this->input->post('tugasakhir1'),
			'PengujiTA2' => $this->input->post('tugasakhir2'),
			'PengujiTA3' => $this->input->post('tugasakhir3'),
			'PengujiTA4' => $this->input->post('tugasakhir4'),
			'PengujiTA5' => $this->input->post('tugasakhir5'),
			'PengujiTA6' => $this->input->post('tugasakhir6'),
			'PengujiTA7' => $this->input->post('tugasakhir7'),
			'JudulTA' =>  str_replace("'","\'", $this->input->post('jdlskripsi_indonesi')),
			'JudulTA2' => str_replace("'","\'", $this->input->post('jdlskripsi_inggris'))
		);

		$this->db->where($kondisi);
		$this->db->update("_v2_mhsw", $value);

		$rows = $this->db->query("select * from _v2_kliring_wisuda where NIM='$nim'")->row();  // and st_kliring='0'
		if (empty($rows)){
			$this->db->query("insert into _v2_kliring_wisuda (NIM, st_kliring) values ('$nim', '1')");
		} else {
			if ($rows->st_kliring == 0) $this->db->query("update _v2_kliring_wisuda set st_kliring='1' where NIM='$nim' and st_kliring='0'");
		}

		/*$Statusupdate= array(
			'ket' => 'sukses',
			'pesan' => 'Matakuliah Berhasil Diupdate'
		);

		echo json_encode($Statusupdate);*/

		$this->getDataMahasiswa_data($this->input->post('nim'), "");

	}

	public function daftarnilai() {

		$this->app->check_modul(); // untuk pengecekan modul

		$nim = $this->input->post('nimkliring');
		//$nim = "F55116123";
		$act = $this->input->post('act');
		//$act = "1";

		$data = $this->delete_spaces($nim);

		if ( $data == FALSE ) {
			$dataError = array(
				'ket' => 'error',
				'pesan' => 'NIM Tidak Boleh Menggunakan Spasi'
			);

			echo json_encode($dataError);

		} else {

			$config = array(
				array(
					'field' => 'nimkliring',
					'label' => 'NIM',
					'rules' => 'required|max_length[100]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maksimal 100 Karakter',
					)
				),
			);

			$this->form_validation->set_rules($config);

			if ( $this->form_validation->run() == FALSE ) {

				$dataError = array(
					'ket' => 'error',
					'pesan' => validation_errors()
				);

				echo json_encode($dataError);

			} else {

				$dataSukses = array(
					'nim' => $nim,
				);

				$dataClean = $this->security->xss_clean($dataSukses);

				$row = $this->app->GetFields("id_reg_pd, Password, Name, TempatLahir, TglLahir, m.KodeFakultas, m.KodeJurusan, TahunAkademik, IPK, TotalSKS,
				j.Jenjang, PredikatLulus, JudulTA, JudulTA2, LamaStudiThn, LamaStudiBln, LamaStudiHari, TglSKYudisium,
				date_format(TglLahir, '%d %M %Y') as TglLahir_format", "_v2_mhsw m join _v2_jurusan j on m.KodeJurusan=j.Kode", "NIM", "$nim")->row();

				$name = $row->Name;
				$ttl = ucwords(strtolower($row->TempatLahir)).", ".$row->TglLahir_format;
				$judulTA = $row->JudulTA;
				$judulTA2 = $row->JudulTA2;
				$totsks = $row->TotalSKS;
				$ipk = $row->IPK;
				$kode_fak = $row->KodeFakultas;
				$kode_prodi = $row->KodeJurusan;

				$tahun_khs = $this->app->GetField("Tahun", "_v2_khs", "NIM='$nim'", "")->result(); // untuk pengecekan tahun di tabel _v2_khs

				if ($act == 1){

					$a = 1;
					$daftarnilai = "";

					foreach ($tahun_khs as $khs){
						$tahun = $khs->Tahun;

						$kondisi = "k.NIM='$nim' and k.Tahun='$tahun' and k.NotActive='N' and bobot>0 group by k.NamaMK order by mk.urutan,mk.KodeJenisMK,k.NamaMK, k.KodeMK desc, k.Tahun asc";

						/*if ($tahun == "20161"){
							$tahun = "";
						}*/

						$GetField = $this->app->GetField("k.IDJadwal, k.KodeMK, k.NamaMK, k.GradeNilai, k.Bobot, k.SKS, k.Tahun, mk.KodeJenisMK as KJMK, mk.Nama_English as MKE, mk.urutan", "_v2_krs$tahun k left outer join _v2_matakuliah mk on k.IDMK=mk.IDMK", "$kondisi", "")->result_array(); // untuk daftar matakuliah

						foreach ($GetField as $rownilai) {
							$daftarnilai .= "<div class='form-group row'>
												<div class='col-md-1'>".$a++."</div>
												<div class='col-md-3'>".$rownilai['NamaMK']."</div>
												<div class='col-md-3'>".$rownilai['MKE']."</div>
												<div class='col-md-1'>".$rownilai['SKS']."</div>
												<div class='col-md-1'>".$rownilai['GradeNilai']."</div>
												<div class='col-md-1'>".$rownilai['Bobot']."</div>
												<div class='col-md-2'>".$rownilai['Tahun']."</div>
											</div>";
						}
					}

					// atas nilai transfer mahasiswa
					$kondisitr = "k.NIM='$nim' and k.Tahun='TR' and k.NotActive='N' and bobot>0 group by k.NamaMK order by mk.urutan,mk.KodeJenisMK,k.NamaMK, k.KodeMK desc, k.Tahun asc";
					$tahun_khs_tr = $this->app->GetField("k.IDJadwal, k.KodeMK, k.NamaMK, k.GradeNilai, k.Bobot, k.SKS, k.Tahun, mk.KodeJenisMK as KJMK, mk.Nama_English as MKE, mk.urutan", "_v2_krsTR k left outer join _v2_matakuliah mk on k.IDMK=mk.IDMK", "$kondisitr", "")->result_array(); // untuk pengecekan tahun di tabel _v2_khs
					foreach ($tahun_khs_tr as $rownilai_tr) {
						$daftarnilai .= "<div class='form-group row'>
											<div class='col-md-1'>".$a++."</div>
											<div class='col-md-3'>".$rownilai_tr['NamaMK']."</div>
											<div class='col-md-3'>".$rownilai_tr['MKE']."</div>
											<div class='col-md-1'>".$rownilai_tr['SKS']."</div>
											<div class='col-md-1'>".$rownilai_tr['GradeNilai']."</div>
											<div class='col-md-1'>".$rownilai_tr['Bobot']."</div>
											<div class='col-md-2'>".$rownilai_tr['Tahun']."</div>
										</div>";
					}
					// bawah nilai transfer mahasiswa


					//echo "$judulTA != '' || $kode_prodi == 'A121') && $judulTA2 != '' || $kode_prodi == 'N111') && ".$row->TempatLahir." != '' && ".$row->TglLahir." != '0000-00-00'";
					if((($judulTA != "" || $kode_prodi == "A121") && $judulTA2 != "" || $kode_prodi == "N111") && $row->TempatLahir != "" && $row->TglLahir != "0000-00-00" ){
						$showdetail= array(
							'ket' => 'sukses',
							'pesan' => 'Matakuliah Berhasil Diupdate',
							'nim' => $nim,
							'name' => str_replace("\'", "'", $name),
							'ttl' => $ttl,
							'judulTA' => $judulTA,
							'judulTA2' =>  $judulTA2,
							'totsks' =>  $totsks,
							'ipk' =>  $ipk,
							'daftarnilai' => $daftarnilai
						);

						echo json_encode($showdetail);
					} else {
						$message_error = "";

						if($judulTA == ""){
							$message_error .= "Judul TA Indonesia ";
						}

						if($judulTA2 == ""){
							$message_error .= "Judul TA Inggris ";
						}

						if($row->TempatLahir == ""){
							$message_error .= "Tempat Lahir ";
						}

						if($row->TglLahir == "0000-00-00"){
							$message_error .= "Tanggal Lahir ";
						}

						$dataError = array(
							'ket' => 'error',
							'pesan' => 'Data belum lengkap, Silahkan perbaiki terlebih dahulu '.$message_error.' dan pastikan data sudah terisi'
						);

						echo json_encode($dataError);
					}

				} if ($act == 2) {
					$user = $this->session->userdata('unip');

					// insert biodata mahasiswa ke wisuda
					$password = $row->Password;
					$tgl = $row->TglLahir;
					$tgl_en = $this->tanggal_inggris(date('dS-m-Y', strtotime($row->TglLahir)));
					$tempat_ttl = $this->db->escape($row->TempatLahir);

					// kondisi untuk mengirim ke wisuda pada program pasca sarjana, karena ada beberapa prodi di pasca di ttd oleh dekan fakultas
					if($kode_prodi=="A112" || $kode_prodi=="A122" || $kode_prodi=="A232" || $kode_prodi=="A312"){
						$kode_fak="A";
					}else if($kode_prodi=="B102"){
						 $kode_fak="B";
					}else if($kode_prodi=="C202" || $kode_prodi=="C302"){
						 $kode_fak="C";
					}else if($kode_prodi=="E322"){
						 $kode_fak="E";
					}else if($kode_prodi=="D102"){
						 $kode_fak="D";
					}else if($kode_prodi=="F112"){
						 $kode_fak="F";
					}

					$angkatan = $row->TahunAkademik;
					$strata = $row->Jenjang;
					$stat_kliring=1;
					$lama_studi_bulan = $row->LamaStudiThn;
					$lama_studi_tahun = $row->LamaStudiBln;
					$lama_studi_hari = $row->LamaStudiHari;
					$id_reg_pd = $row->id_reg_pd;
					$tgl_yudisium = $row->TglSKYudisium;

					$biodata = "INSERT INTO mhs (nim, nama, password, ttl, tempat_en_ttl, tanggal_en_ttl, kode_fak, kode_prodi, angkatan, ipk, strata, sks_total,
							judul_skripsi, judul_skripsi2, stat_kliring, lama_studi_bulan, lama_studi_tahun, lama_studi_hari, id_reg_pd, tgl_yudisium) VALUES
							('$nim', ".$this->db->escape($name).", '$password', '$tgl', $tempat_ttl, '$tgl_en', '$kode_fak', '$kode_prodi', '$angkatan', '$ipk', '$strata', '$totsks',
							".$this->db->escape($judulTA).", ".$this->db->escape($judulTA2).", '$stat_kliring', '$lama_studi_bulan', '$lama_studi_tahun', '$lama_studi_hari', '$id_reg_pd', '$tgl_yudisium');";

					// insert Nilai ke wisuda
					$insert = "insert into nilai_akhir(NIM,IDJadwal,KodeMK,NamaMK,NamaMK2,GradeNilai,Bobot,Tahun,SKS,user,urutan) values ";
					$insertvalues = "";

					foreach ($tahun_khs as $khs){
						$tahun = $khs->Tahun;

						$kondisi = "k.NIM='$nim' and k.Tahun='$tahun' and k.NotActive='N' and bobot>0 group by k.NamaMK order by mk.urutan,mk.KodeJenisMK,k.NamaMK, k.KodeMK desc, k.Tahun asc";

						/*if ($tahun == "20161"){
							$tahun = "";
						}*/

						$GetField = $this->app->GetField("k.IDJadwal, k.KodeMK, k.NamaMK, k.GradeNilai, k.Bobot, k.SKS, k.Tahun, mk.KodeJenisMK as KJMK, mk.Nama_English as MKE, mk.urutan", "_v2_krs$tahun k left outer join _v2_matakuliah mk on k.IDMK=mk.IDMK", "$kondisi", "")->result_array(); // untuk dosen pengampu dan asisten dosen

						foreach ($GetField as $rownilai) {
							$insertvalues .= "('".$nim."','".$rownilai['IDJadwal']."','".$rownilai['KodeMK']."','".strtoupper($rownilai['NamaMK'])."','".strtoupper($rownilai['MKE'])."','".$rownilai['GradeNilai']."','".$rownilai['Bobot']."','".$rownilai['Tahun']."','".$rownilai['SKS']."','".$user."','".$rownilai['urutan']."'),";
						}
					}

					// atas nilai transfer mahasiswa
					$kondisitr = "k.NIM='$nim' and k.Tahun='TR' and k.NotActive='N' and bobot>0 group by k.NamaMK order by mk.urutan,mk.KodeJenisMK,k.NamaMK, k.KodeMK desc, k.Tahun asc";
					$GetFieldtr = $this->app->GetField("k.IDJadwal, k.KodeMK, k.NamaMK, k.GradeNilai, k.Bobot, k.SKS, k.Tahun, mk.KodeJenisMK as KJMK, mk.Nama_English as MKE, mk.urutan", "_v2_krsTR k left outer join _v2_matakuliah mk on k.IDMK=mk.IDMK", "$kondisitr", "")->result_array(); // untuk dosen pengampu dan asisten dosen
					foreach ($GetFieldtr as $rownilaitr) {
						$insertvalues .= "('".$nim."','".$rownilaitr['IDJadwal']."','".$rownilaitr['KodeMK']."','".strtoupper($rownilaitr['NamaMK'])."','".strtoupper($rownilaitr['MKE'])."','".$rownilaitr['GradeNilai']."','".$rownilaitr['Bobot']."','".$rownilaitr['Tahun']."','".$rownilaitr['SKS']."','".$user."','".$rownilaitr['urutan']."'),";
					}

					$update_kliring = "update _v2_kliring_wisuda set st_kliring='2', tgl_kliring1=now() ,user_kliring1='$user' where nim='$nim'";

					//echo $insert.substr($insertvalues, 0, -1)."<br>".$biodata."<br>".$update_kliring;

					$insertbiodata_wisuda = $biodata;
					$insertnilai_wisuda = $insert.substr($insertvalues, 0, -1);

					$this->sinkron_db->Sinkron_wisuda_insert_query($insertbiodata_wisuda);
					$this->sinkron_db->Sinkron_wisuda_insert_query($insertnilai_wisuda);
					$this->db->query($update_kliring);

					$this->getDataMahasiswa_data($nim, "");

				}

			}
		}
	}

	public function daftarnilai_wisuda() {

		$this->app->check_modul(); // untuk pengecekan modul

		$nim = $this->input->post('nimwisuda');
		//$nim = "F55116123";
		$act = $this->input->post('act');
		//$act = "1";

		$data = $this->delete_spaces($nim);

		if ( $data == FALSE ) {
			$dataError = array(
				'ket' => 'error',
				'pesan' => 'NIM Tidak Boleh Menggunakan Spasi'
			);

			echo json_encode($dataError);

		} else {

			$config = array(
				array(
					'field' => 'nimwisuda',
					'label' => 'NIM',
					'rules' => 'required|max_length[100]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maksimal 100 Karakter',
					)
				),
			);

			$this->form_validation->set_rules($config);

			if ( $this->form_validation->run() == FALSE ) {

				$dataError = array(
					'ket' => 'error',
					'pesan' => validation_errors()
				);

				echo json_encode($dataError);

			} else {

				$dataSukses = array(
					'nim' => $nim,
				);

				$dataClean = $this->security->xss_clean($dataSukses);

				$row = $this->app->GetFields("id_reg_pd, Password, Name, TempatLahir, TglLahir, m.KodeFakultas, m.KodeJurusan, TahunAkademik, IPK, TotalSKS,
				j.Jenjang, PredikatLulus, JudulTA, JudulTA2, LamaStudiThn, LamaStudiBln, LamaStudiHari,
				date_format(TglLahir, '%d %M %Y') as TglLahir_format, NomorSKYudisium, TglSKYudisium", "_v2_mhsw m join _v2_jurusan j on m.KodeJurusan=j.Kode", "NIM", "$nim")->row();

				$name = $row->Name;
				$ttl = $row->TempatLahir.", ".$row->TglLahir_format;
				$judulTA = $row->JudulTA;
				$judulTA2 = $row->JudulTA2;
				$totsks = $row->TotalSKS;
				$ipk = $row->IPK;
				$noskyudisium = $row->NomorSKYudisium;
				$tglskyudisium = $this->tanggal_indonesia(date('d-m-Y',strtotime($row->TglSKYudisium)));
				$kode_fak = $row->KodeFakultas;
				$kode_prodi = $row->KodeJurusan;

				$tahun_khs = $this->app->GetField("Tahun", "_v2_khs", "NIM='$nim'", "")->result(); // untuk pengecekan tahun di tabel _v2_khs
				$kondisi = "k.NIM='$nim' and k.NotActive='N' and bobot>0 and (k.NamaMK like 'SKRIPSI' or k.NamaMK like 'TESIS' or k.NamaMK like 'DISERTASI' or k.NamaMK like 'Tugas Akhir' or k.NamaMK like 'Karya Tulis Ilmiah' ) group by k.NamaMK order by mk.urutan,mk.KodeJenisMK,k.NamaMK, k.KodeMK desc, k.Tahun asc";

				if ($act == 1){

					$a = 1;
					$daftarnilai = "";

					foreach ($tahun_khs as $khs){
						$tahun = $khs->Tahun;

						/*if ($tahun == "20161"){
							$tahun = "";
						}*/

						$GetField = $this->app->GetField("k.IDJadwal, k.KodeMK, k.NamaMK, k.GradeNilai, k.Bobot, k.SKS, k.Tahun, mk.KodeJenisMK as KJMK, mk.Nama_English as MKE, mk.urutan", "_v2_krs$tahun k left outer join _v2_matakuliah mk on k.IDMK=mk.IDMK", "$kondisi", "")->result_array(); // untuk dosen pengampu dan asisten dosen

						foreach ($GetField as $rownilai) {
							$daftarnilai .= "<div class='form-group row'>
												<div class='col-md-1'>".$a++."</div>
												<div class='col-md-3'>".$rownilai['NamaMK']."</div>
												<div class='col-md-3'>".$rownilai['MKE']."</div>
												<div class='col-md-1'>".$rownilai['SKS']."</div>
												<div class='col-md-1'>".$rownilai['GradeNilai']."</div>
												<div class='col-md-1'>".$rownilai['Bobot']."</div>
												<div class='col-md-2'>".$rownilai['Tahun']."</div>
											</div>";
						}
					}

					//echo "$judulTA != '' || $kode_prodi == 'A121') && $judulTA2 != '' || $kode_prodi == 'N111') && ".$row->TempatLahir." != '' && ".$row->TglLahir." != '0000-00-00'";
					if((($judulTA != "" || $kode_prodi == "A121") && $judulTA2 != "" || $kode_prodi == "N111") && $row->TempatLahir != "" && $row->TglLahir != "0000-00-00" && $row->NomorSKYudisium != "" && $row->TglSKYudisium != "" ){
						$showdetail= array(
							'ket' => 'sukses',
							'pesan' => 'Matakuliah Berhasil Diupdate',
							'nim' => $nim,
							'name' => $name,
							'ttl' => $ttl,
							'judulTA' => $judulTA,
							'judulTA2' =>  $judulTA2,
							'totsks' =>  $totsks,
							'ipk' =>  $ipk,
							'noskyudisium' =>  $noskyudisium,
							'tglskyudisium' =>  $tglskyudisium,
							'daftarnilai' => $daftarnilai
						);

						echo json_encode($showdetail);
					} else {
						$message_error = "";

						if($judulTA == ""){
							$message_error .= "Judul TA Indonesia ";
						}

						if($judulTA2 == ""){
							$message_error .= "Judul TA Inggris ";
						}

						if($row->TempatLahir == ""){
							$message_error .= "Tempat Lahir ";
						}

						if($row->TglLahir == "0000-00-00"){
							$message_error .= "Tanggal Lahir ";
						}

						if($row->NomorSKYudisium == ""){
							$message_error .= "Nomor SK Yudisium ";
						}

						if($row->TglSKYudisium == ""){
							$message_error .= "Tanggal SK Yudisium ";
						}

						$dataError = array(
							'ket' => 'error',
							'pesan' => 'Data belum lengkap, Silahkan perbaiki terlebih dahulu '.$message_error.' dan pastikan data sudah terisi'
						);

						echo json_encode($dataError);
					}

				} if ($act == 2) {
					$user = $this->session->userdata('unip');

					// insert biodata mahasiswa ke wisuda
					$password = $row->Password;
					$tgl = $row->TglLahir;
					$tgl_en = $this->tanggal_inggris(date('dS-m-Y', strtotime($row->TglLahir)));
					$tempat_ttl = $this->db->escape($row->TempatLahir);

					// kondisi untuk mengirim ke wisuda pada program pasca sarjana, karena ada beberapa prodi di pasca di ttd oleh dekan fakultas
					if($kode_prodi=="A112" || $kode_prodi=="A122" || $kode_prodi=="A232" || $kode_prodi=="A312"){
						$kode_fak="A";
					}else if($kode_prodi=="B102"){
						 $kode_fak="B";
					}else if($kode_prodi=="C202" || $kode_prodi=="C302"){
						 $kode_fak="C";
					}else if($kode_prodi=="E322"){
						 $kode_fak="E";
					}else if($kode_prodi=="D102"){
						 $kode_fak="D";
					}else if($kode_prodi=="F112"){
						 $kode_fak="F";
					}

					$angkatan = $row->TahunAkademik;
					$strata = $row->Jenjang;
					$stat_wisuda=3;
					$lama_studi_bulan = $row->LamaStudiThn;
					$lama_studi_tahun = $row->LamaStudiBln;
					$lama_studi_hari = $row->LamaStudiHari;
					$id_reg_pd = $row->id_reg_pd;
					$TglYud = $row->TglSKYudisium;

					$TglYudEn = $this->tanggal_inggris(date('dS-m-Y', strtotime($row->TglSKYudisium)));

					// insert Nilai ke wisuda
					$insert = "insert into nilai_akhir(NIM,IDJadwal,KodeMK,NamaMK,NamaMK2,GradeNilai,Bobot,Tahun,SKS,user,urutan) values ";
					$insertvalues = "";
					$jumlahmatakuliah = 0;

					foreach ($tahun_khs as $khs){
						$tahun = $khs->Tahun;

						/*if ($tahun == "20161"){
							$tahun = "";
						}*/
						// menghitung jumlah matakuliah
						$jumlahmatakuliah = $this->db->query("select count(nim) from _v2_krs$tahun where NIM='$nim' and NotActive='N' and bobot>0 group by NamaMK")->num_rows();

						$GetField = $this->app->GetField("k.IDJadwal, k.KodeMK, k.NamaMK, k.GradeNilai, k.Bobot, k.SKS, k.Tahun, mk.KodeJenisMK as KJMK, mk.Nama_English as MKE, mk.urutan", "_v2_krs$tahun k left outer join _v2_matakuliah mk on k.IDMK=mk.IDMK", "$kondisi", "")->result_array();

						foreach ($GetField as $rownilai) {
							$insertvalues .= "('".$nim."','".$rownilai['IDJadwal']."','".$rownilai['KodeMK']."','".strtoupper($rownilai['NamaMK'])."','".strtoupper($rownilai['MKE'])."','".$rownilai['GradeNilai']."','".$rownilai['Bobot']."','".$rownilai['Tahun']."','".$rownilai['SKS']."','".$user."','".$rownilai['urutan']."'),";
						}
					}

					$biodata = "UPDATE mhs set jmatakuliah='$jumlahmatakuliah',ipk='$ipk',sks_total='$totsks',judul_skripsi=".$this->db->escape($judulTA).",judul_skripsi2=".$this->db->escape($judulTA2).",
					lama_studi_hari='$lama_studi_hari',lama_studi_bulan='$lama_studi_bulan',lama_studi_tahun='$lama_studi_tahun',stat_kliring=$stat_wisuda,
					tgl_yudisium='$TglYud',tgl_yudisium2='$TglYudEn',sk_yudisium='$noskyudisium' where NIM='$nim';";

					$update_kliring = "UPDATE _v2_kliring_wisuda k, _v2_mhsw m set m.Status='L', m.Lulus='Y', m.Proposal='Y', m.TA='Y', m.Skripsi='Y', k.st_kliring=3, k.tgl_kliring2=now(), k.user_kliring2='$user' where k.NIM='$nim' and k.NIM=m.NIM";
					$this->db->query($update_kliring);

					//echo $insert.substr($insertvalues, 0, -1)."<br>".$biodata."<br>".$update_kliring;

					$insertbiodata_wisuda = $biodata;
					$insertnilai_wisuda = $insert.substr($insertvalues, 0, -1);

					$this->sinkron_db->Sinkron_wisuda_insert_query($insertbiodata_wisuda);

					$ceknilaiwisuda = $this->sinkron_db->Sinkron_wisuda_query("select * from nilai_akhir where NIM='$nim' and (NamaMK like 'SKRIPSI' or NamaMK like 'TESIS' or NamaMK like 'DISERTASI' or NamaMK like 'Tugas Akhir' or NamaMK like 'Karya Tulis Ilmiah')")->num_rows();

					if ($ceknilaiwisuda == 0 and $kode_prodi != "N111"){ // untuk mengecek apakah nilai skrisi sudah ada atau belum dan untuk profesi kedokteran tidak melakukan insert
							$this->sinkron_db->Sinkron_wisuda_insert_query($insertnilai_wisuda);
					}

					$this->db->query($update_kliring);

					//echo $insert.substr($insertvalues, 0, -1)."<br>".$biodata."<br>".$update_kliring; // orcinus cloud

					$this->getDataMahasiswa_data($nim, "");
				}

			}
		}
	}

	public function batal_valwis() {

		// fungsi ini akan Membatalkan semua validasi pada wisuda

		$this->app->check_modul(); // untuk pengecekan modul

		$dataSearch = $this->uri->segment(4);

		$this->sinkron_db->Sinkron_wisuda_delete("nilai_akhir", "NIM='$dataSearch'", "");
		$this->sinkron_db->Sinkron_wisuda_delete("mhs", "NIM='$dataSearch'", "");
		$this->db->query("UPDATE _v2_kliring_wisuda set st_kliring=1 and NIM='$dataSearch'");

		$this->getDataMahasiswa_data($dataSearch, "");
	}

	/*public function fandu_wisuda() {
		$this->sinkron_db->Sinkron_wisuda("F55116123");
	}*/

	public function tambahnilai() {

		$this->app->check_modul();

		$nim = $this->input->post('nim');

		$data = $this->delete_spaces($nim);

		if ( $data == FALSE ) {
			$dataError = array(
				'ket' => 'error',
				'pesan' => 'NIM Tidak Boleh Menggunakan Spasi'
			);

			echo json_encode($dataError);

		} else {

			$config = array(
				array(
					'field' => 'nim',
					'label' => 'NIM',
					'rules' => 'required|max_length[100]',
					'errors' => array(
						'required' => '%s Tidak Boleh Kosong',
						'max_length' => '%s Maksimal 100 Karakter',
					)
				),
			);

			$this->form_validation->set_rules($config);

			if ( $this->form_validation->run() == FALSE ) {

				$dataError = array(
					'ket' => 'error',
					'pesan' => validation_errors()
				);

				echo json_encode($dataError);

			} else {

				$dataSukses = array(
					'nim' => $nim,
				);

				$dataClean = $this->security->xss_clean($dataSukses);

				$row = $this->app->GetFields("m.NIM, m.Name, m.KodeJurusan, m.TahunAkademik, tn.Total_SKS", "_v2_mhsw m left join _v2_tambah_nilai_kliring tn on tn.NIM=m.NIM", "tn.Setujui_admin='Setujui' and tn.NIM", "$nim")->row();
				if ($row){
					$kdj = $row->KodeJurusan;
					$angkatan = $row->TahunAkademik;
					$totalsksp3s = $row->Total_SKS; // total sks yang di perbolehkan untuk menambah nilai

					$kondisi = "Kode != '' and m.KodeJurusan like '$kdj%' and k.NotActive='N'";

					$GetField = $this->app->GetField("IDMK, concat(Kode, ' -- ', Nama_Indonesia, ' -- ', SKS) as mk", "_v2_matakuliah m left join _v2_kurikulum k on k.IdKurikulum=m.KurikulumID", "$kondisi", "")->result_array(); // untuk dosen pengampu dan asisten dosen

					$options = "";

					foreach ($GetField as $rows) {
						$options .= "<option value=".$rows['IDMK'].">".$rows['mk']."</option>";
					}

					$tahun = $this->app->two_val_option("Tahun", "Tahun" ,"_v2_khs" ,"NIM='$nim'", "");

					$jurusan  = $this->app->two_val("_v2_jurusan", "Kode", $kdj, "NotActive", "N")->row();
					$ket_jenjang = $jurusan->Ket_Jenjang;

					if ($kdj == "N210" or $kdj == "N101" or $kdj == "N111" or 
						$kdj == "P101" or
						$kdj == "K2MF111" or 
						$kdj == "E321" or $kdj == "E281" or 
						$kdj == "D101" or
						$kdj == "C101" or $kdj == "C200" or $kdj == "C201" or $kdj == "C300" or $kdj == "C301" or
						$kdj == "F111" or $kdj == "F121" or $kdj == "F210" or $kdj == "F221" or $kdj == "F230" or $kdj == "F231" or $kdj == "F240" or $kdj == "F331" or $kdj == "F441" or $kdj == "F551"
					){
						$jurusan  = $this->app->two_val("_v2_jurusan", "Kode", $kdj, "NotActive", "N")->row();
						$ket_jenjang = $jurusan->Ket_Jenjang;
					} else {
						$ket_jenjang = "Umum";
						$kdj = "All";
					}

					//$grade = $this->app->two_val_option("concat(Nilai, ' -- ',Bobot)" , "Nilai" ,"_v2_nilai" ,"Kode='$KodeNilai' and angkatan='' order by Nilai Asc", "");
					$grade = $this->app->two_val_option("concat(Nilai, ' (',Bobot,')')" , "AngkatanKebawah, AngkatanKeatas, Nilai", "_v2_nilai", "Kode like '$ket_jenjang' and KodeJurusan = '$kdj' HAVING ($angkatan >= AngkatanKebawah and $angkatan <= AngkatanKeatas) order by Nilai Asc", "");
					// hasil nya 23-04-2019 $grade = $this->app->two_val_option("concat(Nilai, ' -- ',Bobot)" , "AngkatanKebawah, AngkatanKeatas, Nilai" ,"_v2_nilai" ,"Kode like '$ket_jenjang' and KodeFakultas ='All' and KodeJurusan = 'All' HAVING ($angkatan >= AngkatanKebawah and $angkatan <= AngkatanKeatas) order by Nilai Asc", "");
					// SELECT * FROM `_v2_nilai` WHERE Kode like 'Umum' and KodeFakultas ='All' and KodeJurusan = 'All' HAVING (2015 >= AngkatanKebawah and 2015 <= AngkatanKeatas)

					$updatekliring= array(
						'ket' => 'sukses',
						'pesan' => 'Matakuliah Berhasil Diupdate',
						'NIM' => $row->NIM,
						'Name' => $row->Name,
						'options' => $options,
						'grade' => $grade,
						'tahun' => $tahun,
						'totalsksp3s' => $totalsksp3s
					);

				} else {
					$updatekliring= array(
						'ket' => 'sukses',
						'pesan' => 'Matakuliah Berhasil Diupdate',
						'NIM' => "",
						'Name' => "",
						'options' => "",
						'grade' => "",
						'tahun' => "",
						'totalsksp3s' => ""
					);
				}


				echo json_encode($updatekliring);

			}
		}
	}

	public function nilaip3s(){

		$unip = $this->session->userdata('unip');

		$nim = $this->input->post('nim');

		$kdfakultas  = $this->app->two_val("_v2_mhsw", "NIM", $nim, "NotActive", "N")->row();
		$kdf = $kdfakultas->KodeFakultas;
		$kdj = $kdfakultas->KodeJurusan;
		$KodeProgram = $kdfakultas->KodeProgram;
		$angkatan = $kdfakultas->TahunAkademik;

		$kodemk = $this->input->post('kodemk');
		$gradenilai = $this->input->post('gradenilai');
		$bobot = $this->input->post('bobot');
		$namamk = $this->input->post('namamk');
		$sksmk = $this->input->post('sksmk');

		//echo $namamk;

 		$arraykdmk = explode(",", $kodemk);
		$arraygrade = explode(",", $gradenilai);
		$arraybobot = explode(",", $bobot);
		$arraynamamk = explode(",", $namamk);
		$arraysks = explode(",", $sksmk);

		$arraynamamk = str_replace('/', ',', $arraynamamk);

		//print_r($arraynamamk);

		// tahun akademik berlaku 20184 jika pindah tahun akademik, silahkan ganti tahun 20194
		$tahuntr = "20184";

		$NA = "N";

		// data: 'nim='+nim+'&kodemk='+kodemk+'&gradenilai='+gradenilai+'&bobot='+bobot,

		$s = "";

		for ($a = 0; $a < count($arraykdmk); $a++){

			$IDMK = $arraykdmk[$a].$kdj;

			$s = "insert into _v2_krs$tahuntr (NIM, Tahun, IDMK, KodeMK, NamaMK, SKS, Program, Tanggal, GradeNilai, Bobot, unip, NotActive_KRS, NotActive, useredt, tgledt) values ('$nim', '$tahuntr', '$IDMK', '".$arraykdmk[$a]."', '".$arraynamamk[$a]."', '".$arraysks[$a]."','$KodeProgram',now(),'".$arraygrade[$a]."','".$arraybobot[$a]."','$unip', '$NA', '$NA','$unip', NOW());";

			$r = $this->db->query($s);

		}

		// echo $result." dan ".$arraykdmk[0];

		if(!$r) {
			$result= array(
				'ket' => 'error',
				'pesan' => 'Gagal Input Matakuliah'
			);
		} else {

			$khs = "insert into _v2_khs (NIM, Tahun, Sesi, Status) values ('$nim', '$tahuntr', '0', 'A');";

			$this->db->query($khs);

			$upd_status = "update _v2_tambah_nilai_kliring set Setujui_admin = 'Selesai' WHERE NIM='$nim'";

			$this->db->query($upd_status);

			$result= array(
				'ket' => 'sukses',
				'pesan' => 'Berhasil Input Matakuliah, Silahkan Reload Kembali'
			);
		}

		echo json_encode($result);

	}

	public function kirim_sapta($nim) {

		$data_mhsw = $this->app->GetField("Login,Password,Description,NIM,Name,Email,TempatLahir,TglLahir,Alamat,Phone,KodeFakultas,KodeJurusan,Status,NotActive", "_v2_mhsw", "NIM='$nim'","")->row();

		$data_array_mhsw = array(
			'Login' => $data_mhsw->Login,
			'Password' => $data_mhsw->Password,
			'Description' => $data_mhsw->Description,
			'NIM' => $data_mhsw->NIM,
			'Name' => $data_mhsw->Name,
			'Email' => $data_mhsw->Email,
			'TempatLahir' => $data_mhsw->TempatLahir,
			'TglLahir' => $data_mhsw->TglLahir, 
			'Alamat1' => $data_mhsw->Alamat,
			'Phone' => $data_mhsw->Phone,
			'KodeFakultas' => $data_mhsw->KodeFakultas,
			'KodeJurusan' => $data_mhsw->KodeJurusan,
			'Status' => $data_mhsw->Status,
			'NotActive' => $data_mhsw->NotActive
		);

		//print_r($data_array_mhsw);

		$cek = $this->sinkron_db->cek_mhsw_sapta($nim);

		if ($cek == TRUE){

			$dataError = array(
				'ket' => 'error',
				'pesan' => 'Data Mahasiswa dengan NIM '.$cek->NIM.' Sudah Ada di Aplikasi SAPTA'
			);

			echo json_encode($dataError);
			
		} else {
			
			$cek = $this->sinkron_db->insert_mhsw_sapta($data_array_mhsw);

			if ($cek == TRUE) {

				$dataError = array(
					'ket' => 'sukses',
					'pesan' => 'Data Mahasiswa dengan NIM '.$cek->NIM.' Berhasil Terkirim di Aplikasi SAPTA'
				);

				echo json_encode($dataError);

			} else {

				$dataError = array(
					'ket' => 'error',
					'pesan' => 'Data Mahasiswa dengan NIM '.$cek->NIM.' Gagal Terkirim di Aplikasi SAPTA'
				);

				echo json_encode($dataError);

			}

		}
		
	}

}
