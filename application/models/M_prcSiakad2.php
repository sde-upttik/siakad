<?php
//session_start();
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

class M_prcSiakad2 extends CI_Model {
	private $ulangtosiakad2="";
	// private $daftarulang="";

	
	public function __construct(){
		parent::__construct();
	}

	public function getDataMhsw()
	{
		$this->ulangtosiakad2 = $this->load->database('ulangtosiakad2', TRUE);

		$where['lulus_pcmb.st_siakad'] = "0";

		$this->ulangtosiakad2->select(
			'lulus_pcmb.st_nim,
		    lulus_pcmb.Jalur,
		    lulus_pcmb.jurusan,
		    lulus_pcmb.nama,
		    lulus_pcmb.strata,
		    lulus_pcmb.noujian,
		    lulus_pcmb.ket,
		    daftar.EMail,
		    daftar.JK,
		    daftar.TmptLhr,
		    daftar.TglLhr,
		    daftar.Alamat1,
		    daftar.Telp,
		    daftar.nik,
		    daftar.Agama,
		    daftar.NmAyah,
		    daftar.NmIbu'
		);
		$this->ulangtosiakad2->from('lulus_pcmb');
		$this->ulangtosiakad2->join('jurusan', 'jurusan.KodePs = lulus_pcmb.jurusan', 'left');
		$this->ulangtosiakad2->join('daftar', 'daftar.KAP = lulus_pcmb.noujian', 'left');
		$this->ulangtosiakad2->where($where);
		$this->ulangtosiakad2->group_by('lulus_pcmb.st_nim');
		$this->ulangtosiakad2->limit(1);
		return $this->ulangtosiakad2->get()->result_array();
	}	

	public function getDaftarulang()
	{

		$daftarulang = $this->load->database('daftarulang',TRUE);
		$query = "SELECT 	
			null as ID, 
			0 as st_feeder, 
			null as id_pd, 
			null as id_reg_pd, 
			lulus_pcmb.st_nim as SID, 
			lulus_pcmb.st_nim as Login, 
			LEFT(PASSWORD(lulus_pcmb.st_nim),10) as Password, 
			'MAHASISWA' as Description, 
			lulus_pcmb.st_nim as NIM, 
			NISN, 
			lulus_pcmb.noujian as PMBID, 
			lulus_pcmb.st_nim as NIRM, 
			now() as Tanggal, 
			lulus_pcmb.nama as Name, 
			daftar.EMail as Email, 
			daftar.JK as Sex, 
			daftar.TmptLhr as TempatLahir, 
			daftar.TglLhr as TglLahir, 
			daftar.Alamat1 as Alamat, 
			Kelurahan, 
			Kecamatan,
			daftar.kabupaten as Kota, 
			Provinsi, 
			daftar.Telp as HP, 
			daftar.Telp as Phone, 
			NIK, 
			(
			CASE
					WHEN daftar.Agama='Islam' THEN '1'
					WHEN daftar.Agama='Kristen Protestan' THEN '2'
					WHEN daftar.Agama='Kristen' THEN '2'
					WHEN daftar.Agama='Katolik' THEN '3'
					WHEN daftar.Agama='Katholik' THEN '3'
					WHEN daftar.Agama='Khatolik' THEN '3'
					WHEN daftar.Agama='Hindu' THEN '4'
					WHEN daftar.Agama='Buddha' THEN '5'
					WHEN daftar.Agama='Budhha' THEN '5'
					WHEN daftar.Agama='Konghuchu' THEN '6'
					ELSE daftar.Agama
			END
			) as AgamaID, 
			daftar.NmAyah as NamaOT, 
			daftar.NmIbu as NamaIbu, 
			daftar.alamat_ortu as AlamatOT1, 
			daftar.notlp_ortu as TelpOT, 
			jurusan.KodeFakultas as KodeFakultas, 
			lulus_pcmb.kprodi as KodeJurusan, 
			'A' as Status, 
			(CASE WHEN lulus_pcmb.Jalur='NONREG' THEN 'RESO' WHEN lulus_pcmb.Jalur='NONREGULER' THEN 'RESO' ELSE 'REG' END) as KodeProgram, 
			(case WHEN Seleksi = 'AJENJANG' THEN 'J' else 'B' end ) as StatusAwal, 
			'20201' as Semester, 
			'2020' as TahunAkademik
			FROM lulus_pcmb 
			inner JOIN daftar on daftar.noujian=lulus_pcmb.noujian
			INNER JOIN jurusan ON jurusan.Kode=lulus_pcmb.kprodi
			WHERE lulus_pcmb.st_biodata = 1 and lulus_pcmb.st_siakad = 0
			GROUP by st_nim"
		;
		
			$res = $daftarulang->query($query);

		return $res;

	}

	public function updateStatusMigrasi($noujian)
	{
		$daftarulang = $this->load->database('daftarulang',TRUE);

		$daftarulang->set('st_siakad',1);
		$daftarulang->where_in('noujian',$noujian);
		$daftarulang->update('lulus_pcmb');

		return $daftarulang->affected_rows();
	}

	public function commitMigrasion()
	{
		$query = "START TRANSACTION;
		INSERT _v2_mhsw
		SELECT `ID`, `st_feeder`, `id_pd`, `id_reg_pd`, `SID`, `Login`, `Password`, `Description`, `NIM`, `NISN`, `PMBID`, `NIRM`, `Tanggal`, `Name`, `Email`, `Sex`, `TempatLahir`, `TglLahir`, `TglLahir2`, `TglLahir2_Eng`, `Alamat`, `Dusun`, `Kelurahan`, `Kecamatan`, `RT`, `RW`, `Kota`, `Provinsi`, `KodePos`, `HP`, `Phone`, `NIK`, `NPWP`, `AgamaID`, `Suku`, `Kewarganegaraan`, `JenisTinggal`, `AlatTransportasi`, `penerimaKPS`, `nomorKPS`, `TipePembayaran`, `KetPembayaran`, `SudahBekerja`, `NamaOT`, `NamaIbu`, `NamaWali`, `PekerjaanOT`, `HslAyah`, `PekerjaanIbu`, `HslIbu`, `PekerjaanW`, `HslW`, `PendidikanOT`, `PendidikanIbu`, `PendidikanW`, `AlamatOT1`, `AlamatOT2`, `AlamatW1`, `AlamatW2`, `RTOT`, `RTW`, `RWOT`, `RWW`, `KotaOT`, `KotaW`, `KodeTelpOT`, `TelpOT`, `TelpW`, `EmailOT`, `EmailW`, `KodePosOT`, `KodePosW`, `KodeFakultas`, `KodeJurusan`, `Status`, `StatusKRS`, `StatusBayar`, `TahunStatus`, `KodeProgram`, `StatusAwal`, `UniversitasAsal`, `ProdiAsal`, `SKSditerima`, `JalurMasuk`, `Semester`, `TahunAkademik`, `Lulus`, `TglLulus`, `TahunLulus`, `LamaStudi`, `LamaStudiThn`, `LamaStudiBln`, `LamaStudiHari`, `PredikatLulus`, `DosenID`, `Masuk`, `NotActive`, `TA`, `TglTA`, `Proposal`, `TglProposal`, `Skripsi`, `TglSkripsi`, `TotalSKS`, `TotalSKSLulus`, `IPK`, `JudulTA`, `JudulTA2`, `PengujiTA1`, `PengujiTA2`, `PengujiTA3`, `PengujiTA4`, `PengujiTA5`, `PengujiTA6`, `PengujiTA7`, `NoSKPembimbing`, `TglSKPembimbing`, `NoSKPenguji`, `TglSKPenguji`, `NomorSKYudisium`, `TglSKYudisium`, `Predikat`, `NomerIjazah`, `TglIjazah`, `log`, `logupd`, `nosk`, `fotoktm`, `count_edit_password`, `AlasanPindah`, `file_transkip`, `file_blangko_pindah`, `AlamatSP`, `UniversitasPindah`, `error_code`, `error_desc`, `no_induk_universitas`, `update_krsf`, `UjiProposalTgl`, `UjiHasilTgl`, `UjiAkhirTgl`, `UjiProposalJam`, `UjiHasilJam`, `UjiAkhirJam` FROM `_v2_tempMaba` WHERE on_siakad = 0 ;
		UPDATE _v2_tempMaba SET on_siakad = 1;
		COMMIT;";

		return $this->db->query($query)->affected_rows();
	}
	public function updateStSiakadInDaftarUlang($data)
	{

		$this->db->where('st_nim', $data);
		$response = $this->db->update('lulus_pcmb', array('st_siakad' => '1'));
		if ($response == 1) {
			return "Berhasil Mengupdate data di tabel lulus_pcmb - status <b>{$data} </b><br>";
		}else{
			return 'Gagal Mengupdate data di tabel lulus_pcmb<br>';
		}
	}

	public function insertMhswTable($data)
	{
		$result = $this->validationInsertMhsw($data['NIM']);
		
		if ($result >= 1) {
			return "data sudah ada";
		}else{
			return $this->db->insert('mhsw', $data);
		}
	}

	public function validationInsertMhsw($nim)
	{
		$where['NIM'] = $nim;

		$this->db->where($where);
		return $this->db->get('_v2_mhsw')->num_rows();
	}
}