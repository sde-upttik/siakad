<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

class Kliring_nilaitransfer extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->helper('security');
	    $this->load->model('nilai_transfer_model');
	}

	private function check_modul() {

		$ulevel = $this->session->userdata('ulevel');
		$template = $this->session->userdata('tamplate');

		$cek = $this->db->query("select * from modul WHERE Link = '$template' and Level like '%-$ulevel-%'")->num_rows();

		if ($cek){
			return true;
		} else {
			echo "melewati hak akses";
		}

	}

	private function runWS($data){

		$url = 'http://103.245.72.97:8082/ws/live2.php';
		$ch = curl_init();
			
		curl_setopt($ch, CURLOPT_POST, 1);
		
		$headers = array();
		
		$headers[] = 'Content-Type: application/json';
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$data = json_encode($data);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}

	public function getDataMahasiswa() { // fungsi untuk mecari semua nilai dari search

		$this->check_modul();

		$dataSearch = $this->security->xss_clean($this->input->post('dataSearch'));

		if (empty($dataSearch)) {

			$data['footerSection'] = "<script type='text/javascript'>
 				swal({
					title: 'Pemberitahuan',
					type: 'warning',
					html: true,
					text: 'Silahkan mengisi terlebih dahulu NIM yang ingin dicari',
					confirmButtonColor: '#f7cb3b',
				});
		    </script>";

			$this->load->view('dashbord',$data);

		} else {

			
			$dataMhsw = $this->nilai_transfer_model->get_dataSearch($dataSearch);

			//print_r($dataMhsw);

			if ( $dataMhsw == TRUE ) {

				$data['detailmhsw'] = $dataMhsw;
				$data['record'] = $this->nilai_transfer_model->get_NilaiTransfer($dataSearch);
				$data['matakuliah'] = $this->nilai_transfer_model->get_matakuliah($data['detailmhsw']->KodeJurusan);

				$kdj = $data['detailmhsw']->KodeJurusan;

				if ($kdj == "N210" or $kdj == "N101" or $kdj == "N111" or 
					$kdj == "P101" or
					$kdj == "K2MF111" or $kdj == "K2MC201" or $kdj == "K2ME281" or 
					$kdj == "E321" or $kdj == "E281" or 
					$kdj == "D101" or
					$kdj == "C101" or $kdj == "C200" or $kdj == "C201" or $kdj == "C300" or $kdj == "C301" or
					$kdj == "F111" or $kdj == "F121" or $kdj == "F210" or $kdj == "F221" or $kdj == "F230" or $kdj == "F231" or $kdj == "F240" or $kdj == "F331" or $kdj == "F441" or $kdj == "F551" or $kdj == "F131" or
					$kdj == "A111" or
					$kdj == "A121" or
					$kdj == "A221" or
					$kdj == "A231" or
					$kdj == "A241" or
					$kdj == "A251" or
					$kdj == "A311" or
					$kdj == "A321" or
					$kdj == "A351" or
					$kdj == "A401" or
					$kdj == "A411" or
					$kdj == "A421" or
					$kdj == "A441" or
					$kdj == "A451" or
					$kdj == "A461" or
					$kdj == "A471" or
					$kdj == "A481" or
					$kdj == "A491" or
					$kdj == "A501" or
					$kdj == "A611" or
					$kdj == "B101" or
					$kdj == "B201" or
					$kdj == "B301" or
					$kdj == "B401" or
					$kdj == "B501" or
					$kdj == "L131"
				){
					$data['nilai'] = $this->nilai_transfer_model->get_rule_nilai($data['detailmhsw']->Ket_Jenjang, $kdj, $data['detailmhsw']->TahunAkademik);
				} else {
					$data['nilai'] = $this->nilai_transfer_model->get_rule_nilai('Umum','All',$data['detailmhsw']->TahunAkademik);
				}

				$data['footerSection'] = "<script type='text/javascript'>
	 				$('#matakuliah').DataTable();
			    </script>";

				$this->load->view('dashbord',$data);



			} else {

				$data['footerSection'] = "<script type='text/javascript'>
	 				swal({
						title: 'Pemberitahuan',
						type: 'warning',
						html: true,
						text: 'NIM yang Anda Masukan Salah',
						confirmButtonColor: '#f7cb3b',
					});
			    </script>";

				$this->load->view('dashbord',$data);

			}

		}

	}

	public function getDataEdit($id) {

		$data = $this->nilai_transfer_model->getNilaiByID($id);

		echo json_encode($data);

	}


	public function setHapusData() {

		if( empty( $this->input->post('id_transfer') ) || $this->input->post('id_transfer') == "undefined") {

			$hapus = $this->nilai_transfer_model->deleteData($this->input->post('id'));

			if ($hapus) {

				$dataSukses = array(
					'ket' => 'sukses',
					'pesan' => 'Data Berhasil dihapus dari SIAKAD'
				);

				echo json_encode($dataSukses);

			} else {

				$dataError = array(
					'ket' => 'error',
					'pesan' => 'Data Gagal Terhapus di SIAKAD'
				);

				echo json_encode($dataError);

			}

		} else {
			$this->kirimPDDIKTI($this->input->post('id_transfer'),'delete',$this->input->post('id'));
		}

	}

	public function validasiform() {

		$config = array(
			array(
				'field' => 'id_reg',
				'label' => 'Mahasiswa',
				'rules' => 'required',
				'errors' => array(
					'required' => '%s Tidak Terdaftar Di DIKTI',
				)
			),
			array(
				'field' => 'kodeMKasal',
				'label' => 'Kode MK Asal',
				'rules' => 'required|max_length[50]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 50 Karakter',
				)
			),
			array(
				'field' => 'namaMKasal',
				'label' => 'Nama MK Asal',
				'rules' => 'required|max_length[150]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 150 Karakter',
				)
			),
			array(
				'field' => 'SKSasal',
				'label' => 'SKS Asal',
				'rules' => 'required|max_length[5]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 5 Angka',
				)
			),
			array(
				'field' => 'grade_asal',
				'label' => 'Nilai Huruf Asal',
				'rules' => 'required|max_length[2]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'max_length' => '%s Maxsimal 2 Huruf',				)
			),
			array(
				'field' => 'id_mk',
				'label' => 'Mata Kuliah',
				'rules' => 'required',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
				)
			),
			array(
				'field' => 'grade',
				'label' => 'Nilai Huruf diakui',
				'rules' => 'required',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
				)
			),
			array(
				'field' => 'program',
				'label' => 'Program Studi',
				'rules' => 'required|max_length[10]',
				'errors' => array(
					'required' => '%s Tidak Boleh Kosong',
					'exact_length' => '%s Maxsimal 10 Karakter ',
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

			$nilai = explode(' - ', $this->input->post('grade') );
			$mk = explode(' - ', $this->input->post('id_mk') );
			$grade = str_replace(' ', '+', $nilai[0]);

			$dataSukses = array(
				'id' => $this->input->post('id'),
				'nim' => $this->input->post('nim'),
				'id_reg' => $this->input->post('id_reg'),
				'id_transfer' => $this->input->post('id_transfer'),
				'kodeMKasal' => $this->input->post('kodeMKasal'),
				'namaMKasal' => $this->input->post('namaMKasal'),
				'SKSasal' => intval($this->input->post('SKSasal')),
				'grade_asal' => $this->input->post('grade_asal'),
				'id_mk' => $mk[0],
				'IDMK' => $mk[4],
				'kodeMK' => $mk[2],
				'namaMK' => $mk[3],
				'program' => $this->input->post('program'),
				'sks' => intval($mk[1]),
				'grade' => $grade,
				'bobot' => $nilai[1],
				'notactive' => $this->input->post('notactive'),
				'user' => $this->session->userdata('uname'),
				'tglnow' => date('Y-m-d H:i:s')
			);			

			$dataClean = $this->security->xss_clean($dataSukses);

			if ( ($this->input->post('act') == 'add') ) {

				$this->kirimPDDIKTI($dataClean,'insert',$this->input->post('notactive'));

			} elseif ( ($this->input->post('act') == 'update') ) {
 
				if ( empty( $this->input->post('id_transfer') ) ) {

					$this->kirimPDDIKTI($dataClean,'inandup',$this->input->post('notactive'));

				} else {

					$this->kirimPDDIKTI($dataClean,'update',$this->input->post('notactive'));

				}

			}
			
		}

	}

	private function kirimPDDIKTI ($data,$act,$active) {

		$dataToken = array (
			'act' => 'GetToken',
			'username' => '001028e1',
			'password' => 'az18^^'
		);

		$tokenFeeder = $this->runWS($dataToken);
		$obj = json_decode($tokenFeeder);
		$token = $obj->data->token;

		if ( $act == 'insert' ) {

			$dataTransfer = array();
			$dataTransfer['id_registrasi_mahasiswa'] = $data['id_reg'];
			$dataTransfer['kode_mata_kuliah_asal'] = $data['kodeMKasal'];
			$dataTransfer['nama_mata_kuliah_asal'] = $data['namaMKasal'];
			$dataTransfer['sks_mata_kuliah_asal'] = $data['SKSasal'];
			$dataTransfer['nilai_huruf_asal'] = $data['grade_asal'];
			$dataTransfer['id_matkul'] = $data['id_mk'];
			$dataTransfer['sks_mata_kuliah_diakui'] = $data['sks'];
			$dataTransfer['nilai_huruf_diakui'] = $data['grade'];
			$dataTransfer['nilai_angka_diakui'] = $data['bobot'];

			$dataInsertTransfer = array(
				'act' => 'InsertNilaiTransferPendidikanMahasiswa',
				'token' => $token,
	 			'record'=> $dataTransfer

	 		);

	 		$dataTransferFeeder = $this->runWS($dataInsertTransfer);
		 	$objTransfer = json_decode($dataTransferFeeder);
		 	$error_codeTransfer = $objTransfer->{'error_code'};
		 	$error_descTransfer = $objTransfer->{'error_desc'};

		 	//print_r($objTransfer);

		 	if ($error_codeTransfer == 0) {

		 		$id_transfer = $objTransfer->{'data'}->{'id_transfer'};

		 		$data['id_transfer'] = $id_transfer;
		 		
		 		$simpan = $this->nilai_transfer_model->insertData($data);

		 		if ( $simpan == TRUE ) {

		 			$dataSukses = array(
						'ket' => 'sukses',
						'pesan' => 'Data Berhasil Tersimpan di SIAKAD dan di PDDIKTI'
					);

					echo json_encode($dataSukses);

		 		} else {

		 			$dataError = array(
						'ket' => 'error',
						'pesan' => 'Data Gagal Tersimpan Ke SIAKAD',
						'error' => $simpan
					);

					echo json_encode($dataError);

		 		}

		 	} elseif ( $error_codeTransfer == 118 ) {

		 		$simpan = $this->nilai_transfer_model->insertData($data);

		 		if ( $simpan == TRUE ) {

		 			$dataSukses = array(
						'ket' => 'sukses',
						'pesan' => 'Mahasiswa Belum terdaftar Pindah di PDDIKTI, data sudah tersimpan di SIAKAD'
					);

					echo json_encode($dataSukses);

		 		} else {

		 			$dataError = array(
						'ket' => 'error',
						'pesan' => 'Data Gagal Tersimpan Ke SIAKAD'
					);

					echo json_encode($dataError);

		 		}

		 	} else {

		 		$dataError = array(
					'ket' => 'error',
					'pesan' => $error_codeTransfer."-".$error_descTransfer
				);

				echo json_encode($dataError);

		 	}

		} elseif ( $act == 'update' ) {

			$dataTransfer = array();
			$dataTransfer['kode_mata_kuliah_asal'] = $data['kodeMKasal'];
			$dataTransfer['nama_mata_kuliah_asal'] = $data['namaMKasal'];
			$dataTransfer['sks_mata_kuliah_asal'] = $data['SKSasal'];
			$dataTransfer['nilai_huruf_asal'] = $data['grade_asal'];
			$dataTransfer['id_matkul'] = $data['id_mk'];
			$dataTransfer['sks_mata_kuliah_diakui'] = $data['sks'];
			$dataTransfer['nilai_huruf_diakui'] = $data['grade'];
			$dataTransfer['nilai_angka_diakui'] = $data['bobot'];

			//print_r($dataTransfer);

			$key = array(
				'id_transfer' => $data['id_transfer'] 
			);
			
			$dataUpdateTransfer = array(
				'act' => 'UpdateNilaiTransferPendidikanMahasiswa',
				'token' => $token,
				'key' => $key,
	 			'record' => $dataTransfer
	 		);


	 		$dataTransferFeeder = $this->runWS($dataUpdateTransfer);
		 	$objTransfer = json_decode($dataTransferFeeder);
		 	$error_codeTransfer = $objTransfer->{'error_code'};
		 	$error_descTransfer = $objTransfer->{'error_desc'};

		 	if ( $error_codeTransfer == 0 ) {

		 		$simpan = $this->nilai_transfer_model->updateData($data);

		 		if ( $simpan == TRUE ) {

		 			$dataSukses = array(
						'ket' => 'sukses',
						'pesan' => 'Data Berhasil Tersimpan di SIAKAD dan di PDDIKTI'
					);

					echo json_encode($dataSukses);

		 		} else {

		 			$dataError = array(
						'ket' => 'error',
						'pesan' => 'Data Gagal Tersimpan Ke SIAKAD'
					);

					echo json_encode($dataError);

		 		}

		 	} elseif ( $error_codeTransfer == 118 ) {

		 		$simpan = $this->nilai_transfer_model->updateData($data);

		 		if ( $simpan == TRUE ) {

		 			$dataSukses = array(
						'ket' => 'sukses',
						'pesan' => 'Mahasiswa Belum terdaftar Pindah di PDDIKTI, data sudah tersimpan di SIAKAD'
					);

					echo json_encode($dataSukses);

		 		} else {

		 			$dataError = array(
						'ket' => 'error',
						'pesan' => 'Data Gagal Tersimpan Ke SIAKAD'
					);

					echo json_encode($dataError);

		 		}

		 	} else {

		 		$dataError = array(
					'ket' => 'error',
					'pesan' => $error_codeTransfer."-".$error_descTransfer
				);

				echo json_encode($dataError);

		 	}

		} elseif ( $act == 'delete' ) {
			
			$key = array(
				'id_transfer' => $data
			);
			
			$dataDeleteTransfer = array(
				'act' => 'DeleteNilaiTransferPendidikanMahasiswa',
				'token' => $token,
				'key' => $key
	 		);


	 		$dataTransferFeeder = $this->runWS($dataDeleteTransfer);
		 	$objTransfer = json_decode($dataTransferFeeder);
		 	$error_codeTransfer = $objTransfer->{'error_code'};
		 	$error_descTransfer = $objTransfer->{'error_desc'};

		 	if ($error_codeTransfer == 0) {

		 		if ( empty($active) ) {

		 			$dataError = array(
						'ket' => 'error',
						'pesan' => 'Data Tidak Dapat di temukan untuk di hapus'
					);

					echo json_encode($dataError);

		 		} else {
		 		
			 		$hapus = $this->nilai_transfer_model->deleteData($active);

					if ( $hapus == TRUE ) {

			 			$dataSukses = array(
							'ket' => 'sukses',
							'pesan' => 'Data Berhasil Di Hapus dari SIAKAD dan FEEDER'
						);

						echo json_encode($dataSukses);

			 		} else {

			 			$dataError = array(
							'ket' => 'error',
							'pesan' => 'Data Gagal Terhapus di SIAKAD'
						);

						echo json_encode($dataError);

			 		}

				}

		 	} else {

		 		$dataError = array(
					'ket' => 'error',
					'pesan' => $error_codeTransfer."-".$error_descTransfer
				);

				echo json_encode($dataError);

		 	}

		} elseif ( $act == 'inandup' ) {

			$dataTransfer = array();
			$dataTransfer['id_registrasi_mahasiswa'] = $data['id_reg'];
			$dataTransfer['kode_mata_kuliah_asal'] = $data['kodeMKasal'];
			$dataTransfer['nama_mata_kuliah_asal'] = $data['namaMKasal'];
			$dataTransfer['sks_mata_kuliah_asal'] = $data['SKSasal'];
			$dataTransfer['nilai_huruf_asal'] = $data['grade_asal'];
			$dataTransfer['id_matkul'] = $data['id_mk'];
			$dataTransfer['sks_mata_kuliah_diakui'] = $data['sks'];
			$dataTransfer['nilai_huruf_diakui'] = $data['grade'];
			$dataTransfer['nilai_angka_diakui'] = $data['bobot'];

			$dataInsertTransfer = array(
				'act' => 'InsertNilaiTransferPendidikanMahasiswa',
				'token' => $token,
	 			'record'=> $dataTransfer

	 		);

	 		$dataTransferFeeder = $this->runWS($dataInsertTransfer);
		 	$objTransfer = json_decode($dataTransferFeeder);
		 	$error_codeTransfer = $objTransfer->{'error_code'};
		 	$error_descTransfer = $objTransfer->{'error_desc'};

		 	//print_r($objTransfer);

		 	if ($error_codeTransfer == 0) {

		 		$id_transfer = $objTransfer->{'data'}->{'id_transfer'};

		 		$data['id_transfer'] = $id_transfer;
		 		
		 		$simpan = $this->nilai_transfer_model->updateData2($data);

		 		if ( $simpan == TRUE ) {

		 			$dataSukses = array(
						'ket' => 'sukses',
						'pesan' => 'Data Berhasil Tersimpan di SIAKAD dan di PDDIKTI'
					);

					echo json_encode($dataSukses);

		 		} else {

		 			$dataError = array(
						'ket' => 'error',
						'pesan' => 'Data Gagal Tersimpan Ke SIAKAD'
					);

					echo json_encode($dataError);

		 		}

		 	} else {

		 		$dataError = array(
					'ket' => 'error',
					'pesan' => $error_codeTransfer."-".$error_descTransfer
				);

				echo json_encode($dataError);

		 	}

		}

	}






















	public function changestatus() {
		$act = $this->input->post('act');
		$nim = $this->input->post('nim');
		$tahun = "TR";
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
					'NotActive' => $status,
				);

				$kondisi = array(
					'NIM' => $this->db->escape_str($nim),
					'ID' => $this->db->escape_str($id),
				);

				$this->db->where($kondisi);
				$where = "Tahun = 'TR'";
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

	public function nilaitransfer() {

		$this->check_modul();

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

				$row = $this->app->GetFields("NIM, Name, KodeJurusan, TahunAkademik", "_v2_mhsw", "NIM", "$nim")->row();
				$kdj = $row->KodeJurusan;
				$angkatan = $row->TahunAkademik;

				$kondisi = "Kode != '' and m.KodeJurusan like '$kdj%' and k.NotActive='N'";

				$GetField = $this->app->GetField("IDMK, concat(Kode, ' -- ', Nama_Indonesia, ' -- ', SKS) as mk", "_v2_matakuliah m left join _v2_kurikulum k on k.IdKurikulum=m.KurikulumID", "$kondisi", "")->result_array(); // untuk dosen pengampu dan asisten dosen

				$options = "";

				foreach ($GetField as $rows) {
					$options .= "<option value=".$rows['IDMK'].">".$rows['mk']."</option>";
				}

				$tahun = $this->app->two_val_option("Tahun", "Tahun" ,"_v2_khs" ,"NIM='$nim'", "");

				if ($kdj == "N210" or $kdj == "N101" or $kdj == "N111" or 
					$kdj == "P101" or
					$kdj == "K2MF111" or $kdj == "K2MC201" or $kdj == "K2ME281" or 
					$kdj == "E321" or $kdj == "E281" or 
					$kdj == "D101" or
					$kdj == "C101" or $kdj == "C200" or $kdj == "C201" or $kdj == "C300" or $kdj == "C301" or
					$kdj == "F111" or $kdj == "F121" or $kdj == "F210" or $kdj == "F221" or $kdj == "F230" or $kdj == "F231" or $kdj == "F240" or $kdj == "F331" or $kdj == "F441" or $kdj == "F551" or $kdj == "F131" or $kdj == "B101" or $kdj == "B201" or $kdj == "B301" or $kdj == "B401" or $kdj == "B501" or $kdj == "L131"
				){
					$jurusan  = $this->app->two_val("_v2_jurusan", "Kode", $kdj, "NotActive", "N")->row();
					$ket_jenjang = $jurusan->Ket_Jenjang;
				} else {
					$ket_jenjang = "Umum";
					$kdj = "All";
				}

				//$grade = $this->app->two_val_option("concat(Nilai, ' -- ',Bobot)" , "Nilai" ,"_v2_nilai" ,"Kode='$KodeNilai' and angkatan='' order by Nilai Asc", "");
				$grade = $this->app->two_val_option("concat(Nilai, ' (',Bobot,')')" , "AngkatanKebawah, AngkatanKeatas, Nilai", "_v2_nilai", "Kode like '$ket_jenjang' and KodeJurusan = '$kdj' HAVING ($angkatan >= AngkatanKebawah and $angkatan <= AngkatanKeatas) order by Nilai Asc", "");
				// SELECT * FROM `_v2_nilai` WHERE Kode like 'Umum' and KodeFakultas ='All' and KodeJurusan = 'All' HAVING (2015 >= AngkatanKebawah and 2015 <= AngkatanKeatas)

				$updatekliring= array(
					'ket' => 'sukses',
					'pesan' => 'Matakuliah Berhasil Diupdate',
					'NIM' => $row->NIM,
					'Name' => $row->Name,
					'options' => $options,
					'grade' => $grade,
					'tahun' => $tahun
				);

				echo json_encode($updatekliring);

			}
		}
	}

	public function simpan_transfernilai() {

		$unip = $this->session->userdata('unip');

		$nim = $this->input->post('nim');
		$IDMK = $this->input->post('daftarmatakuliah');
		$Grade = $this->input->post('grade');
		$NotActive = $this->input->post('NA');
		//$tahuntr = $this->input->post('tahuntr');
		$tahuntr = "TR";

		//$kondisi = "m.NIM = '$nim' and m.NotActive = 'N'";
		$kondisi = "m.NIM = '$nim'";

		$GetField = $this->app->GetField("j.Ket_Jenjang,m.KodeFakultas, m.KodeJurusan, m.KodeProgram", "_v2_mhsw m left join _v2_jurusan j on m.KodeJurusan=j.Kode", "$kondisi", "")->row(); // untuk dosen pengampu dan asisten dosen
		$kdf = $GetField->KodeFakultas;
		$kdj = $GetField->KodeJurusan;
		$KodeProgram = $GetField->KodeProgram;
		$ket_jenjang = $GetField->Ket_Jenjang;

		$kdfakultas  = $this->app->two_val("_v2_mhsw", "NIM", $nim, "NotActive", "N")->row();
		$kdf = $kdfakultas->KodeFakultas;
		$kdj = $kdfakultas->KodeJurusan;
		$KodeProgram = $kdfakultas->KodeProgram;
		$angkatan = $kdfakultas->TahunAkademik;

		$sksfakultas  = $this->app->two_val("_v2_matakuliah", "IDMK", $IDMK, "NotActive", "N")->row();
		$SKS = $sksfakultas->SKS;

		// penyebab di berikan kondisi i kedok karena hanya untuk kedokteran yang kriteria penilaiannya yang ada di tabel _v2_nilai, dan yang lainnya itu masi umum kriteria penilaian gradenilai dan bobot
		if ($GetField->KodeJurusan == "N210" or $GetField->KodeJurusan == "N101" or $GetField->KodeJurusan == "N111" or 
			$GetField->KodeJurusan == "P101" or
			$GetField->KodeJurusan == "K2MF111" or $GetField->KodeJurusan == "K2MC201" or $GetField->KodeJurusan == "K2ME281" or 
			$GetField->KodeJurusan == "E321" or $GetField->KodeJurusan == "E281" or 
			$GetField->KodeJurusan == "D101" or
			$GetField->KodeJurusan == "C101" or $GetField->KodeJurusan == "C200" or $GetField->KodeJurusan == "C201" or $GetField->KodeJurusan == "C300" or $GetField->KodeJurusan == "C301" or
			$GetField->KodeJurusan == "F111" or $GetField->KodeJurusan == "F121" or $GetField->KodeJurusan == "F210" or $GetField->KodeJurusan == "F221" or $GetField->KodeJurusan == "F230" or $GetField->KodeJurusan == "F231" or $GetField->KodeJurusan == "F240" or $GetField->KodeJurusan == "F331" or $GetField->KodeJurusan == "F441" or $GetField->KodeJurusan == "F551" or $GetField->KodeJurusan == "F131"
		){
			$ket_jenjang = $GetField->Ket_Jenjang;
			$kdj = $GetField->KodeJurusan;
		} else {
			$ket_jenjang = "Umum";
			$kdj = "All";
		}

		$searchbobobt = $this->app->GetField("Bobot, AngkatanKebawah, AngkatanKeatas", "_v2_nilai", "Nilai = '$Grade' and Kode = '$ket_jenjang' and KodeJurusan='$kdj' HAVING ($angkatan >= AngkatanKebawah and $angkatan <= AngkatanKeatas)", "")->row(); // untuk dosen pengampu dan asisten dosen
		$Bobot = $searchbobobt->Bobot;

		if (isset($NotActive)) $NA = $NotActive; else $NA = 'N';

		//echo "fandu -- $IDMK -- _v2_nilai, Nilai, $Grade, Kode, $KodeNilai";

		$row = $this->app->GetFields("Kode,Nama_Indonesia,SKS", "_v2_matakuliah", "IDMK", "$IDMK")->row();
		$KodeMK = $row->Kode;
		$NamaMK = $row->Nama_Indonesia;
		$SKS = $row->SKS;

		/*if ($tahuntr == "20161"){
			$tahuntr = "";
		}*/

		$s= "insert into _v2_krs$tahuntr (NIM, Tahun, IDMK, KodeMK, NamaMK, SKS, Program, Tanggal, GradeNilai, Bobot, unip, NotActive, useredt, tgledt) values
		('$nim', 'TR', '$IDMK', '$KodeMK', '$NamaMK', $SKS,'$KodeProgram',now(),'$Grade','$Bobot','$unip', '$NA','$unip', NOW())";
		//echo $s;
		$r = $this->db->query($s);

		if(!$r) {
			echo "<center><font size=3 color=red><b>Masih ada kolom yang belum terisi.</b></font></center>";
		}

		$this->getDataMahasiswa_data($this->input->post('nim'));

	}

}
