<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_phpexcel_model extends CI_Model {

    public function upload_data($filename){
        ini_set('memory_limit', '-1');
        $inputFileName = './assets/uploads/'.$filename;
        try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }

        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);

        for ($i=2; $i < ($numRows+1) ; $i++) {

            $ins = array(
                    "nama"          => $worksheet[$i]["A"],
                    "waktu_absen"   => $worksheet[$i]["B"],
                   );

            $this->db->insert('data', $ins);
        }
    }

	public function upload_data_jadwal($filename, $thn, $kdj){

		$messageawal = "";

		$thnaktif = $this->Jadwal->isTahunAktif($thn, $kdj);

		if (!$thnaktif) {
				//$this->rediralert("warning", "Semester Akademik Tidak Terdaftar Silahkan Hubungi Fakultas Anda Untuk Pembukaan Semester Akademik", "", "", "", "");
				return array(
					"messagestatus" => "warning",
					"message" => "Semester Akademik Tidak Terdaftar Silahkan Hubungi Fakultas Anda Untuk Pembukaan Semester Akademik",
					"parameter1" => "",
					"parameter2" => "",
					"parameter3" => "",
					"parameter4" => "",
				);
		} else {
			ini_set('memory_limit', '-1');
			$inputFileName = './assets/uploads/'.$filename;
			try {
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file :' . $e->getMessage());
			}

			$worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$numRows = count($worksheet);

			for ($i=2; $i < ($numRows+1) ; $i++) {

				/*$ins = array(
						"nama"          => $worksheet[$i]["A"],
						"waktu_absen"   => $worksheet[$i]["B"],
					   );

				$this->db->insert('data', $ins);*/

				$md = 1; // insert jadwal

				$IDMK = $worksheet[$i]["A"].$kdj; // kode matakuliah
				$kaps = $worksheet[$i]["B"];
				$KodeRuang = $worksheet[$i]["C"];
				$Program = $worksheet[$i]["D"];
				$Hari = $worksheet[$i]["E"];
				$jm = $worksheet[$i]["F"];
				$js = $worksheet[$i]["G"];
				$Rencana = $worksheet[$i]["H"];
				$Realisasi = $worksheet[$i]["I"];
				$Keterangan = $worksheet[$i]["J"];
				$Ket = $worksheet[$i]["K"];
				$IDDosen = $worksheet[$i]["L"];

				$IDPAKET = "";
				$IDJADWAL = "";

				// buka untuk pada menu tambah jadwal //
				$optmk1  = $this->app->two_val("_v2_kurikulum", "KodeJurusan", $kdj, "NotActive", "N")->row(); // mengambil kurikulum id
				$kurid = $optmk1->IdKurikulum; // hasil kurikulum id

				$kdfakultas  = $this->app->two_val("_v2_jurusan", "Kode", $kdj, "NotActive", "N")->row();
				$kodefakul = $kdfakultas->KodeFakultas;
				// tes

				$kdf = $this->Jadwal->GetaField('KodeFakultas','_v2_jurusan', 'Kode', $kdj);

				$Terjadwal = 'Y';

				$arrmk1  = $this->app->GetField("*", "_v2_matakuliah", "KurikulumID='$kurid' and id_mk != ''", "IDMK='$IDMK'");

				foreach ($arrmk1->result() as $arrmk){
					$KDMK = $arrmk->Kode;
					$id_mk =  $arrmk->id_mk;
					$SKS = $arrmk->SKS;
					$Nama_Indonesia = $arrmk->Nama_Indonesia;
				}

				$KodeKampus1  = $this->app->two_val("_v2_ruang", "KodeKampus", $kodefakul, "Kode", $KodeRuang)->row();
				$KodeKampus = $KodeKampus1->KodeKampus;

				$jam2awal=substr("$jm",0,2);

				$unip = $this->session->userdata('unip');

				$jid = $IDJADWAL;

				$Tanggalskrg=date("Y-m-d H:i:s");
				$TmStamp=strtotime($Tanggalskrg);

				$IdTstamp=$KDMK.$Program.$Keterangan.str_replace(' ', '', $Ket);
				$IDJADWALBr = "$kdj"."$thn"."$IdTstamp";

				$cekidjadwal = "select IDJADWAL from _v2_jadwal where IDJadwal='$IDJADWALBr'";

				$residjadwal = $this->db->query($cekidjadwal)->num_rows();
				if ($residjadwal == 0 or $md == 2) { // apakah IDJADWAL sudah pernah terinput
					$cekruangan = $this->CheckRuang($thn, $jid, $KodeKampus, $KodeRuang, $Hari, $jm, $js);
					$oke = $cekruangan['status'];
					if ($oke) {
						if ($md == 2) { // edit
							$s = "update _v2_jadwal set IDMK='$IDMK', KodeMK='$KDMK', SKS='$SKS',NamaMK='$Nama_Indonesia', Terjadwal='$Terjadwal',
							  Program='$Program', Hari='$Hari', JamMulai='$jm', JamSelesai='$js',
							  KodeKampus='$KodeKampus', KodeRuang='$KodeRuang', Rencana='$Rencana', Realisasi='$Realisasi',Keterangan='$Keterangan',Kelas='$Ket',IDPAKET='$IDPAKET', IDDosen='$IDDosen', kap='$kaps'
							  where IDJADWAL='$jid'";
							$stat = "Berhasil di Rubah";
						} elseif ($md == 1) { // tambah baru

							$kaps = $this->CekKapasitas($KodeRuang);

							if($kaps<=0) $kaps=30;

							$s = "insert into _v2_jadwal (id_mk,IDJADWAL,Tahun, Terjadwal, KodeFakultas, KodeJurusan, IDMK, KodeMK, NamaMK,
							  SKS, Program, Hari,
							  JamMulai, JamSelesai, KodeKampus, KodeRuang,kap, unip, Tanggal, Rencana, Realisasi,Keterangan,Kelas,IDPAKET,IDDosen)
							  values ('$id_mk','$IDJADWALBr', '$thn', '$Terjadwal', '$kdf', '$kdj', '$IDMK', '$KDMK', '$Nama_Indonesia',
							  '$SKS', '$Program', '$Hari', '$jm',
							  '$js', '$KodeKampus', '$KodeRuang',$kaps, '$unip', '$Tanggalskrg', '$Rencana', '$Realisasi','$Keterangan','$Ket','$IDPAKET','$IDDosen')";

							$stat = "Berhasil Terinput";
						}
						//echo $s;
						$r = $this->db->query($s);

						// insert assisten dosen
						/*$dosenlainnya = $this->input->post('dosenlainnya');

						foreach( $dosenlainnya as $n ){
							if (!empty($n)){
								$cek = "select * from _v2_jadwalassdsn where IDJadwal='$IDJADWALBr' and IDDosen='$n'";

								$hm = $this->db->query($cek)->num_rows();
								if ($hm == 0) {
									$ins_assdsn = "insert into _v2_jadwalassdsn (IDJadwal, IDDosen, NotActive) values('$IDJADWALBr', '$n', 'N')";
									$this->db->query($ins_assdsn);
								}
							}
						}*/
						$statalert = "success";
					} else {
						$stat = $cekruangan['display'];
						$statalert = "error";
					}

					$messageawal .= "$statalert - Matakuliah $Nama_Indonesia $stat<br>";

					//$this->rediralert("$statalert", "Matakuliah $Nama_Indonesia $stat", "list", $thn, $Program, $kdj);
					/* return array(
						"messagestatus" => $statalert,
						"message" => "Matakuliah $Nama_Indonesia $stat",
						"parameter1" => "list",
						"parameter2" => $thn,
						"parameter3" => $Program,
						"parameter4" => $kdj,
					); */

				} else {

					$messageawal .= "error - Matakuliah $Nama_Indonesia Sudah Pernah di Input<br>";

					//$this->rediralert("error", "Matakuliah $Nama_Indonesia Sudah Pernah di Input", "list", $thn, $Program, $kdj); // list pada parameter ke tiga untuk mengembalikan nilai balik pada list jadwal
					/* return array(
						"messagestatus" => "error",
						"message" => "Matakuliah $Nama_Indonesia Sudah Pernah di Input",
						"parameter1" => "list",
						"parameter2" => $thn,
						"parameter3" => $Program,
						"parameter4" => $kdj,
					); */

				}
			}
			return array(
				"messagestatus" => "detail",
				"message" => $messageawal,
				"parameter1" => "",
				"parameter2" => "",
				"parameter3" => "",
				"parameter4" => "",
			);
		}

    }

	function CheckRuang ($thn, $jid, $kdk, $kdr, $hr, $jm, $js) {
		$sm = "select j.*, h.Nama as namaHari from _v2_jadwal j left join _v2_hari h on j.Hari=h.ID where KodeKampus='$kdk' and KodeRuang='$kdr' and Hari='$hr' and
		JamMulai <= '$jm:00' and '$jm:00' <= JamSelesai and IDJADWAL<>'$jid' and Tahun='$thn'";

		$rm = $this->db->query($sm);
		$hm = $rm->num_rows();
		if ($hm > 0) {
			$detailjadwals = $rm->row();
			$str1 =  $str2 = '<b>'.$detailjadwals->NamaMK.' <br>Hari / Jam Mulai Bentrok : '.$detailjadwals->namaHari.', Mulai '.$detailjadwals->JamMulai.' - Selesai '.$detailjadwals->JamSelesai.'.</b>';
		}
		else $str1 = '';

		// untuk query <= fandu ganti jadi < karena menyebabkan jam bentrok dengan jadwal yang akan di input, example MK 1 kode Selesainya 09:00:00 dan kode MK 2 Mulai nya 09:00:00 
		$ss = "select j.*, h.Nama as namaHari from _v2_jadwal j left join _v2_hari h on j.Hari=h.ID where KodeKampus='$kdk' and KodeRuang='$kdr' and Hari=$hr and
			JamMulai < '$js' and '$js' < JamSelesai and IDJADWAL<>'$jid' and Tahun='$thn' ";
		$rs = $this->db->query($ss);
		$hs = $rs->num_rows();

		if ($hs > 0) {
			$detailjadwals = $rs->row();
			$str2 = '<b>'.$detailjadwals->NamaMK.' <br>Hari / Jam Mulai Bentrok : '.$detailjadwals->namaHari.', Mulai '.$detailjadwals->JamMulai.' - Selesai '.$detailjadwals->JamSelesai.'.</b>';
		}
		else $str2 = '';

		$bol = (($hm == 0) && ($hs == 0));
		if (!($bol)) {
			$displayheader = "Tidak dapat dijadwalkan di <b>$kdk - $kdr</b>.<br>Ruang telah dipakai oleh : <br><ul> $str1<br>$str2 </ul>";
		} else {
			$displayheader = "";
		}

		return array(
			"status" => $bol,
			"display" => $displayheader
		);
		// echo "$sm dan fandu $ss";
	}

	function CekKapasitas($idr) {
      $s = "select Kapasitas from _v2_ruang where Kode='$idr';";
	  $r = $this->db->query($s)->row();
	  return $r->Kapasitas;
	}

}
