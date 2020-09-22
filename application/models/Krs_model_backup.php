<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Krs_model extends CI_Model{
	
	private $db2;

	public function __construct(){
		parent::__construct();
		$this->db2 = $this->load->database('spc', TRUE);
	}

	public function getMhswKhs($nim,$semesterAkademik) {
		$nim=$this->db->escape_str($nim);
		$semesterAkademik=intval($semesterAkademik);
		$query = $this->db->query("SELECT k.NIM,k.Tahun,m.Name,m.KodeJurusan,concat(m.KodeJurusan,' - ',j.Nama_Indonesia) as nama_jurusan,m.KodeProgram,ds.Name as nama_dosen FROM _v2_khs k left join _v2_mhsw m on k.NIM=m.NIM left join jurusan j on m.KodeJurusan=j.Kode left join _v2_dosen ds on m.DosenID=ds.nip WHERE k.NIM = '$nim' and k.Tahun = '$semesterAkademik' ORDER BY k.ID");

	    return $query->result();

	}

	public function getAngkatan($nim) {
		$nim=$this->db->escape_str($nim);

		$query = $this->db->query("select TahunAkademik from _v2_mhsw where NIM='$nim' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getIdRegMhsw($nim) {
		$nim=$this->db->escape_str($nim);

		$query = $this->db->query("select id_reg_pd from _v2_mhsw where NIM='$nim' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getStFeederKhs($nim,$thn) {
		$nim=$this->db->escape_str($nim);
		$thn=intval($thn);

		$query = $this->db->query("select st_feeder from _v2_khs where NIM='$nim' and Tahun='$thn' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getStAbaikanKhs($nim,$thn){
		$nim=$this->db->escape_str($nim);
		$thn=intval($thn);

		$query = $this->db->query("SELECT st_abaikan, st_feeder from _v2_khs where NIM='$nim' and Tahun='$thn' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getCountStAbaikanKrs($tbl,$nim) {
		$tbl=$this->db->escape_str($tbl);
		$nim=$this->db->escape_str($nim);
		
		$query = $this->db->query("SELECT count(st_abaikan) as jmlAbaikan from ".$tbl." where NIM='$nim' and st_feeder=0");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}	
	}

	public function getStFeederKrs($tbl,$nim) {
		$tbl=$this->db->escape_str($tbl);
		$nim=$this->db->escape_str($nim);
		
		$query = $this->db->query("SELECT st_feeder from ".$tbl." where NIM='$nim'");

		return $query->result();
	}

	public function getStAbaikanKrs($tbl,$nim) {
		$tbl=$this->db->escape_str($tbl);
		$nim=$this->db->escape_str($nim);
		
		$query = $this->db->query("SELECT st_abaikan from ".$tbl." where NIM='$nim' and st_feeder=0");

		return $query->result();
	}

	public function getIpsKhs($nim,$thn) {
		$nim=$this->db->escape_str($nim);
		$thn=intval($thn);

		$query = $this->db->query("SELECT IPS from _v2_khs where NIM='$nim' and Tahun='$thn' limit 1");

		if($query->num_rows() == 0)	{
			return false;
		}else {
			return $query->row();
		}
	}

	public function getDispMhswKHS($nim) {
		$nim=$this->db->escape_str($nim);
		$query = $this->db->query("SELECT k.*, date_format(TglRegistrasi, '%d %M %Y') as TGL, sm.Nama as STA from _v2_khs k left outer join _v2_statusmhsw sm on k.Status=sm.Kode where k.NIM='$nim' order by k.Sesi");

		if($query->num_rows() == 0)
	    {
	        return false;
	    }
	    else
	    {
	        return $query->result();
	    }
	}

	public function cekIdKrs($idMk,$nim,$semesterAkademik,$tbl) {
		$nim=$this->db->escape_str($nim);
		$idMk=$this->db->escape_str($idMk);
		$tbl=$this->db->escape_str($tbl);
		$semesterAkademik=intval($semesterAkademik);
		$query = $this->db->query("SELECT ID FROM $tbl WHERE IDMK='$idMk' and NIM='$nim' and Tahun='$semesterAkademik'");

		if($query->num_rows() == 0)
	    {
	        return false;
	    }
	    else
	    {
	        return true;
	    }
	}

	public function getTahun($kdj,$semesterAkademik) {
		$kdj=$this->db->escape_str($kdj);
		$semesterAkademik=intval($semesterAkademik);
		$query = $this->db->query("SELECT Nama FROM _v2_tahun WHERE KodeJurusan = '$kdj' and Kode = '$semesterAkademik'");

		if($query->num_rows() == 0)
	    {
	        return false;
	    }
	    else
	    {
	        return $query->result();
	    }
	}

	public function getTahunOne($semesterAkademik) {
		$semesterAkademik=intval($semesterAkademik);
		$query = $this->db->query("SELECT Nama FROM _v2_tahun WHERE Kode = '$semesterAkademik' limit 1");

		if($query->num_rows() == 0)
	    {
	        return false;
	    }
	    else
	    {
	        return $query->result();
	    }
	}

	public function getMhsw($nim) {
		$nim=$this->db->escape_str($nim);
		$query = $this->db->query("SELECT NIM FROM _v2_mhsw WHERE NIM = '$nim'");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->result();
		}
	}

	public function getPaket($semesterAkademik,$kdj) {
		$kdj = $this->db->escape_str($kdj);
		$thn = intval($semesterAkademik);
		$query = $this->db->query("select jd.IDPAKET,p.KodePaket, p.NamaPaket from _v2_jadwal jd left outer join _v2_paket p on jd.IDPAKET=p.IDPAKET where jd.Tahun='$semesterAkademik' and jd.KodeJurusan='$kdj' and jd.KodeRuang <> '' group by jd.IDPAKET order by jd.IDPAKET");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->result();
		}
	}

	public function getCekPaket($nim,$thn,$tbl) {
		$nim = $this->db->escape_str($nim);
		$thn = intval($thn);
		$tbl = $this->db->escape_str($tbl);
		$query = $this->db->query("select Tahun, GradeNilai from $tbl where NIM='$nim' and Tahun ='$thn' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getMhs3($nim) {
		$nim = $this->db->escape_str($nim);
		$query = $this->db->query("select NIM, Name, KodeJurusan from _v2_mhsw where NIM='$nim' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getMhswData($nim) {
		$nim = $this->db->escape_str($nim);
		$query = $this->db->query("select NIM, Name, KodeJurusan from _v2_mhsw where NIM='$nim' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getBayar($nim,$semesterAkademik) {
		$nim=$this->db->escape_str($nim);
		$semesterAkademik=intval($semesterAkademik);
		$query = $this->db->query("SELECT bayar FROM _v2_spp2 WHERE nim = '$nim' and tahun = '$semesterAkademik'");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}
	
	public function getCuti($nim,$semesterAkademik) {
		$nim=$this->db->escape_str($nim);
		$semesterAkademik=intval($semesterAkademik);

		$query = $this->db->query("SELECT smt_mulai_cuti,smt_akhir_cuti FROM _v2_riwayat_cuti WHERE nim = '$nim' and periode = '$semesterAkademik'");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}
	
	public function getBiodata($nim,$semesterAkademik) {
		$nim=$this->db->escape_str($nim);
		$semesterAkademik=intval($semesterAkademik);

		$query = $this->db->query("SELECT NIM FROM _v2_mhsw WHERE NIM = '$nim' and NamaIbu not in ('IBU','') and TempatLahir != '' and TglLahir != '0000-00-00'");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}
	
	public function getMhswAktif($nim,$semesterAkademik) {
		$nim=$this->db->escape_str($nim);
		$semesterAkademik=intval($semesterAkademik);

		$query = $this->db->query("SELECT sm.* FROM _v2_mhsw m left outer join _v2_statusmhsw sm on m.Status=sm.Kode WHERE m.NIM = '$nim'");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getMhswAktifSemester($nim,$semesterAkademik) {
		$nim=$this->db->escape_str($nim);
		$semesterAkademik=intval($semesterAkademik);

		$query = $this->db->query("SELECT s.Nilai, s.Nama FROM _v2_khs h left outer join _v2_statusmhsw s on h.Status=s.Kode WHERE h.Tahun='$semesterAkademik' and h.NIM = '$nim' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getSemesterAkademikAktif() {
		$query = $this->db->query("SELECT periode_aktif, nama_periode FROM _v2_periode_aktif WHERE status='aktif' limit 1");

		return $query->row();
	}

	public function getKodeFakultas($nim) {
		$nim=$this->db->escape_str($nim);

		$query = $this->db->query("SELECT KodeFakultas FROM _v2_mhsw WHERE NIM = '$nim' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getKode($nim) {
		$nim=$this->db->escape_str($nim);

		$query = $this->db->query("SELECT KodeProgram, KodeJurusan FROM _v2_mhsw WHERE NIM = '$nim' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getSesiBobot($nim) {
		$nim=$this->db->escape_str($nim);

		$query = $this->db->query("SELECT Sesi, (Bobot / SKS) as bbt from _v2_khs where NIM='$nim' order by Sesi desc limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getMaxSksRange($bbt,$kdj) {
		$kdj=$this->db->escape_str($kdj);

		$query = $this->db->query("SELECT SKSMax from _v2_max_sks where IPSMin <= ".$bbt." and ".$bbt." <= IPSMax and KodeJurusan='$kdj' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getSksMax($ips,$nim) {
		$nim=$this->db->escape_str($nim);

		$query = $this->db->query("SELECT SKSMax FROM _v2_mhsw m,_v2_max_sks mx where m.KodeJurusan=mx.KodeJurusan and IPSMin <= ".$ips." and IPSmax >= ".$ips."  and mx.NotActive='N' and m.nim='$nim' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getNameMahasiswa($nim) {
		$nim=$this->db->escape_str($nim);

		$query = $this->db->query("SELECT Name FROM _v2_mhsw WHERE NIM = '$nim' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getSumSks($nim,$thn,$tbl) {
		$nim=$this->db->escape_str($nim);
		$thn=$this->db->escape_str($thn);

		$query = $this->db->query("SELECT sum(SKS) as jmlSks FROM ".$tbl." WHERE NIM='$nim' and Tahun='$thn' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function saveKrs($dataKrs, $tbl) {
		$tbl=$this->db->escape_str($tbl);
		$data = array (
					'NIM'		=> $this->db->escape_str($dataKrs['nim']),
					'Tahun'		=> $this->db->escape_str($dataKrs['tahun']),
					'Sesi'		=> $this->db->escape_str($dataKrs['sesi']),
					'IDJadwal'	=> $this->db->escape_str($dataKrs['idJadwal']),
					'IDMK'		=> $this->db->escape_str($dataKrs['idMk']),
					'KodeMK'	=> $this->db->escape_str($dataKrs['kodeMk']),
					'NamaMK'	=> $this->db->escape_str($dataKrs['namaMk']),
					'SKS'		=> $this->db->escape_str($dataKrs['sks']),
					'IDDosen'	=> $this->db->escape_str($dataKrs['idDosen']),
					'unip'		=> $this->db->escape_str($dataKrs['unip']),
					'Tanggal'	=> $dataKrs['tanggal'],
					'Program'	=> $this->db->escape_str($dataKrs['program'])
				);

		return $this->db->insert($tbl, $data);
	}

	public function cariRuang($jid) {
		$jid=$this->db->escape_str($jid);

		$query = $this->db->query("SELECT _v2_ruang.Kode FROM _v2_jadwal,_v2_ruang WHERE IDJadwal = '$jid' and _v2_jadwal.KodeRuang = _v2_ruang.Kode limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
    }

	public function getVal($nim,$semesterAkademik) {
		$nim=$this->db->escape_str($nim);
		$semesterAkademik=intval($semesterAkademik);

		$query = $this->db->query("SELECT st_val,tgl_val FROM _v2_khs WHERE NIM = '$nim' and Tahun='$semesterAkademik' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getDataKrs($tbl,$nim,$semesterAkademik) {
		$tbl=$this->db->escape_str($tbl);
		$nim=$this->db->escape_str($nim);
		$semesterAkademik=intval($semesterAkademik);
		$query = $this->db->query("SELECT k.ID, k.KodeMK, k.SKS, k.NamaMK as MK, k.Hadir, k.Tanggal, k.Program, concat(d.Name, ', ', d.Gelar) as Dosen, h.Nama as HR, TIME_FORMAT(jd.JamMulai, '%H:%i') as jm, TIME_FORMAT(jd.JamSelesai, '%H:%i') as js, jd.Hari, jd.KodeRuang, jd.Keterangan, pr.Nama_Indonesia as PRG FROM ".$tbl." k left outer join _v2_mata_kuliah mk on k.IDMK=mk.IDMK left outer join _v2_dosen d on k.IDDosen=d.nip left outer join _v2_jadwal jd on k.IDJadwal=jd.IDJADWAL left outer join _v2_hari h on jd.Hari=h.ID left outer join _v2_program pr on jd.Program=pr.Kode WHERE k.NIM = '$nim' and k.Tahun = '$semesterAkademik' group by k.ID order by jd.Hari,k.Program,h.Nama,jd.JamMulai");

        return $query->result();
	}

	public function getKrsData($tbl,$nim,$id) {
		$tbl=$this->db->escape_str($tbl);
		$nim=$this->db->escape_str($nim);
		$id=$this->db->escape_str($id);

		$query = $this->db->query("SELECT KodeMK,NamaMK,IDJadwal,SKS FROM ".$tbl." WHERE ID='$id' and NIM='$nim' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getPrasyaratMk($kodeJurusan,$idMk) {
		$kodeJurusan=$this->db->escape_str($kodeJurusan);
		$idMk=$this->db->escape_str($idMk);
		$query = $this->db->query("select pmk.PraKodeMK, mk.Nama_Indonesia as NamaMK from _v2_prasyaratmk pmk left outer join _v2_matakuliah mk on pmk.PraKodeMK=mk.Kode and mk.KodeJurusan='$kodeJurusan' where pmk.IDMK='$idMk' order by pmk.PraKodeMK");

        if($query->num_rows() == 0)
	    {
	        return false;
	    }
	    else
	    {
			return $query->result();
        }
	}


	public function getMaxSks($nim,$semesterAkademik) {
		$nim=$this->db->escape_str($nim);
		$semesterAkademik=intval($semesterAkademik);

		$query = $this->db->query("SELECT MaxSKS FROM _v2_khs WHERE Tahun = '$semesterAkademik' and NIM = '$nim'");

		if($query->num_rows() == 0)
	    {
	        return false;
	    }
	    else
	    {
			return $query->row();
	    }
	}

	public function getIdKrs($nim, $kodeMk, $tbl) {
		$nim=$this->db->escape_str($nim);
		$kodeMk=$this->db->escape_str($kodeMk);
		$tbl=$this->db->escape_str($tbl);

		$query = $this->db->query("SELECT ID FROM ".$tbl." WHERE NIM='$nim' and KodeMK='$kodeMk'");

		if($query->num_rows() == 0)
	    {
	        return false;
	    }
	    else
	    {
			return $query->row();
	    }
	}

	public function getTotalSks($nim) {
		$nim=$this->db->escape_str($nim);

		$query = $this->db->query("SELECT TotalSKS FROM _v2_mhsw WHERE NIM = '$nim'");

		if($query->num_rows() == 0)
	    {
	        return false;
	    }
	    else
	    {
			return $query->row();
	    }
	}

	public function getSksMin($IDMK) {
		$IDMK=$this->db->escape_str($IDMK);

		$query = $this->db->query("SELECT SKSMin FROM _v2_matakuliah WHERE IDMK = '$IDMK'");

		if($query->num_rows() == 0)
	    {
	        return false;
	    }
	    else
	    {
			return $query->row();
	    }
	}

	public function getJmlSks($nim,$semesterAkademik,$tabel) {
		$nim=$this->db->escape_str($nim);
		$tabel=$this->db->escape_str($tabel);
		$semesterAkademik=intval($semesterAkademik);

		$query = $this->db->query("SELECT sum(SKS) as jml_sks FROM ".$tabel." WHERE Tahun = '$semesterAkademik' and NIM = '$nim'");

		if($query->num_rows() == 0)
	    {
	        return false;
	    }
	    else
	    {
			return $query->row();
	    }
	}

	public function cekGradeNilai($nim,$semesterAkademik,$kd_mk,$tbl) {
		$nim=$this->db->escape_str($nim);
		$kd_mk=$this->db->escape_str($kd_mk);
		$tbl=$this->db->escape_str($tbl);
		$semesterAkademik=intval($semesterAkademik);

		$query = $this->db->query("SELECT Tahun,GradeNilai FROM ".$tbl." WHERE NIM='".$nim."' and KodeMK='".$kd_mk."' and Tahun <> '".$semesterAkademik."' and NotActive='N' order by Tahun desc");

        return $query->result();
	}

	public function daftarKrs($nim,$data) {
		$nim=$this->db->escape_str($nim);
		$name=$this->db->escape_str($data['name']);
		$semesterAkademik=intval($data['semesterAkademik']);
		$kdj=$this->db->escape_str($data['kdj']);
		$kdp=$this->db->escape_str($data['kdp']);
		$lev=$this->db->escape_str($data['lev']);
		$nims=substr($nim,0,6);
		$nimx=substr($nim,6,3);
		$nimf=substr($nim,0,1);

		$condition = "(j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and j.Program like '%$kdp%' order by j.Program, j.Hari, j.JamMulai";

		if($lev == 4 and $semesterAkademik=='20171'){
			//nim dengan tahun 2014
			$kelas="%%";

			//echo "angkatan2016";
			if($nims == "E28115A"){
				//cari kelas	
				if($nimx <= 30){
					$kelas="A";
				}else if($nimx >= 31 && $nimx <= 60){
					$kelas="B";
				}else if($nimx >= 61 && $nimx <= 90){
					$kelas="C";
				}else if($nimx >= 91 && $nimx <= 120){
					$kelas="D";
				}else if($nimx >= 121 && $nimx <= 150){
					$kelas="E";
				}else if($nimx >= 151 && $nimx <= 180){
					$kelas="F";
				}else if($nimx >= 181 && $nimx <= 210){
					$kelas="G";
				}else if($nimx >= 211 && $nimx <= 240){
					$kelas="H";
				}else if($nimx >= 241 && $nimx <= 270){
					$kelas="I";
				}else if($nimx >= 271 && $nimx <= 300){
					$kelas="J";
				}else if($nimx >= 301 && $nimx <= 330){
					$kelas="K";
				}else if($nimx >= 331 && $nimx <= 360){
					$kelas="L";
				}else if($nimx >= 361){
					$kelas="M";
				}

				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and j.Keterangan='$kelas' and mk.Sesi=1 and j.Program like '%$kdp%' group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai";
			}else if($nims == "E32115A"){
				//cari kelas	
				if($nimx <= 30){
					$kelas="M";
				}else if($nimx >= 31 && $nimx <= 60){
					$kelas="L";
				}else if($nimx >= 61 && $nimx <= 90){
					$kelas="K";
				}else if($nimx >= 91 && $nimx <= 120){
					$kelas="J";
				}else if($nimx >= 121 && $nimx <= 150){
					$kelas="I";
				}else if($nimx >= 151 && $nimx <= 180){
					$kelas="H";
				}else if($nimx >= 181 && $nimx <= 210){
					$kelas="G";
				}else if($nimx >= 211 && $nimx <= 240){
					$kelas="F";
				}else if($nimx >= 241 && $nimx <= 270){
					$kelas="E";
				}else if($nimx >= 271 && $nimx <= 300){
					$kelas="D";
				}else if($nimx >= 301 && $nimx <= 330){
					$kelas="C";
				}else if($nimx >= 331 && $nimx <= 360){
					$kelas="B";
				}else if($nimx >= 361){
					$kelas="A";
				}

				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and j.Keterangan='$kelas' and mk.Sesi=1 and j.Program like '%$kdp%' group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai";
			}else if($nims == "D10115" && $kdp=="RESO"){
				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and mk.Sesi<=5 and j.Program like '%$kdp%' group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai";
			}else if($nims == "D10114" && $kdp=="RESO"){
				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and mk.Sesi<=7 and j.Program like '%$kdp%' group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai";
			}
			else if($nims == "D10116" && $kdp=="RESO"){
				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and mk.Sesi<=3 and j.Program like '%$kdp%' group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai";
			}else if($nims == "D10114" && $kdp=='REG'){
				//cari kelas	
				if($nimx <= 59){
					$kelas="A";
				}else if($nimx >= 72 && $nimx <= 134){
					$kelas="B";
				}else if($nimx >= 164 && $nimx <= 221){
					$kelas="C";
				}else if($nimx >= 333 && $nimx <= 379){
					$kelas="E";
				}else if($nimx >= 449 && $nimx <= 483){
					$kelas="F";
				}else if($nimx >= 568 && $nimx <= 587){
					$kelas="G";
				}else if($nimx >= 588){
					$kelas="H";
				}
	      
       			$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and (j.Keterangan='$kelas' or mk.Wajib='N' or j.KodeMK='DK13048') and mk.Sesi<=7 and j.Program like '%$kdp%' group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai  ";

				if($nimx >= 60 && $nimx <= 71){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 and j.Program like '%$kdp%' union  select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js,	h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='A' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or  j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='B' and  (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 and j.Program like '%$kdp%'";
						//group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai 
				}else  if($nimx >= 135 && $nimx <= 163){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 and j.Program like '%$kdp%' union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='B' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or  j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='C' and  (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 and j.Program like '%$kdp%'";
        		}else if($nimx >= 222 && $nimx <= 247){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 and j.Program like '%$kdp%' union  select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='C' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='D' and  (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 and j.Program like '%$kdp%'";
				}else if($nimx >= 286 && $nimx <= 332){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 and j.Program like '%$kdp%' union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='D' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or  j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='E' and  (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 and j.Program like '%$kdp%'";
				}else if($nimx >= 380 && $nimx <= 448){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 and j.Program like '%$kdp%' union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='E' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or  j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='F' and  (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 and j.Program like '%$kdp%'";
				}else if($nimx >= 484 && $nimx <= 567){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 and j.Program like '%$kdp%' union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='F' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or  j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='G' and (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 and j.Program like '%$kdp%'";
				}else if($nimx >= 588){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 and j.Program like '%$kdp%' union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='G' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or  j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='H' and  (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 and j.Program like '%$kdp%'";
				}
			}else if($nims == "D10115" && $kdp=='REG'){
				if($nimx <= 58){
					$kelas="A";
				}else if($nimx >= 77 && $nimx <= 121){
					$kelas="B";
				}else if($nimx >= 167 && $nimx <= 199){
					$kelas="C";
				}else if($nimx >= 260 && $nimx <= 262){
					$kelas="D";
				}

				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and (j.Keterangan='$kelas' or mk.Wajib='N') and mk.Sesi<=5 and j.Program like '%$kdp%' group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai";

				if($nimx >= 59 && $nimx <= 76){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 and j.Program like '%$kdp%' union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='A' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='B' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 and j.Program like '%$kdp%'";
				}else if($nimx >= 112 && $nimx <= 137){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 and j.Program like '%$kdp%' union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='B' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='C' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 and j.Program like '%$kdp%'";
				}else if($nimx >= 200 && $nimx <= 259){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 and j.Program like '%$kdp%' union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='C' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='D' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 and j.Program like '%$kdp%'";
				}else if($nimx >= 263 && $nimx <= 361){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 and j.Program like '%$kdp%' union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='D' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='E' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 and j.Program like '%$kdp%'";
				}else if($nimx >= 362 && $nimx <= 426){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 and j.Program like '%$kdp%' union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='E' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='F' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 and j.Program like '%$kdp%'";
				}else if($nimx >= 427 && $nimx <= 472){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 and j.Program like '%$kdp%' union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='E' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='G' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 and j.Program like '%$kdp%'";
				}else if($nimx >= 478 && $nimx <= 519){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 and j.Program like '%$kdp%' union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='F' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='G' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 and j.Program like '%$kdp%'";
				}else if($nimx >= 520 ){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 and j.Program like '%$kdp%' union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='F' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='H' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 and j.Program like '%$kdp%'";
				}
			}else if($nims == "D10116" && $kdp=='REG'){
				//Angkatan 2015
				if($nimx <= 85){
					$kelas="A";
				}else if($nimx >= 86 && $nimx <= 166){
					$kelas="B";
				}else if($nimx >= 167 && $nimx <= 256){
					$kelas="C";
				}else if($nimx >= 257 && $nimx <= 360){
					$kelas="D";
				}else if($nimx >= 361 && $nimx <= 469){
					$kelas="E";
				}else if($nimx >= 470 && $nimx <= 570 ){
					$kelas="F";
				}else if($nimx >= 571 && $nimx <= 672 ){
					$kelas="G";
				}else if($nimx >= 673) {
					$kelas="H";
				}

				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik'
				and j.NotActive='N' and j.Keterangan='$kelas' and mk.Sesi<=3 and j.Program like '%$kdp%' group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai ";
			
			}else if($nims == "D10117" && $kdp=='REG'){
				//Angkatan 2017 

				if($nimx <= 82){
					$kelas="A";
				}else if($nimx >= 83 && $nimx <= 164){
					$kelas="B";
				}else if($nimx >= 165 && $nimx <= 246){
					$kelas="C";
				}else if($nimx >= 247 && $nimx <= 328){
					$kelas="D";
				}else if($nimx >= 329 && $nimx <= 410){
					$kelas="E";
				}else if($nimx >= 411 && $nimx <= 492 ){
					$kelas="F";
				}else if($nimx >= 493 && $nimx <= 574 ){
					$kelas="G";
				}else if($nimx >= 575 && $nimx <= 656 ){
					$kelas="H";
				}else if($nimx >= 657 && $nimx <= 755 ){
					$kelas="I";
				}else if($nimx >= 756 ){
					$kelas="J";
				}

				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and j.Keterangan='$kelas' and mk.Sesi<=1 and j.Program like '%$kdp%' group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai ";
			}//nim dengan tahun 2013
			else if($nims == "D10113" && $kdp=='REG'){
				//Angkatan 2013 
				//cari kelas
			}else if($nims == "D10112A" && $kdp=='REG'){
				//cari kelas
				if($nimx <= 50){
					$kelas="A";
				}else if($nimx >= 59 && $nimx <= 101){
					$kelas="B";
				}else if($nimx >= 118 && $nimx <= 152){
					$kelas="C";
				}else if($nimx >= 177 && $nimx <= 225){
					$kelas="D";
				}else if($nimx >= 225 && $nimx <= 305){
					$kelas="F";
				}else if($nimx >= 306 && $nimx <= 356){
					$kelas="G";
				}else if($nimx >= 357){
					$kelas="H";
				}	

				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and (j.Keterangan='$kelas' or mk.Wajib='N' or j.KodeMK='DK13048') and mk.Sesi<=7 group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai  ";
			}

		}

		$query = $this->db->query("SELECT j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK, j.KodeRuang as kr, j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG, mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where ".$condition);

		return $query->result();
	}

	public function getMataKuliah($KodeMK,$kdj) {
		$KodeMK=$this->db->escape_str($KodeMK);
		$kdj=$this->db->escape_str($kdj);

		$query = $this->db->query("SELECT Nama_Indonesia FROM _v2_matakuliah WHERE Kode='".$KodeMK."' and KodeJurusan='".$kdj."'");

		if($query->num_rows() == 0)
	    {
	        return false;
	    }
	    else
	    {
			return $query->row();
	    }
	}

	public function getMataKuliahIdMk($idMk) {
		$idMk=$this->db->escape_str($idMk);

		$query = $this->db->query("SELECT Nama_Indonesia FROM _v2_matakuliah WHERE IDMK='".$idMk."'");

		return $query->row();
	}

	public function getTahunJadwal($jid) {
		$jid=$this->db->escape_str($jid);
		$query = $this->db->query("SELECT Tahun FROM _v2_jadwal WHERE IDJadwal = '$jid' limit 1");

		return $query->row();
	}

	public function getJmlMhsw($tbl,$jid) {
		$tbl=$this->db->escape_str($tbl);
		$jid=$this->db->escape_str($jid);

		$query = $this->db->query("SELECT count(*) as JML FROM $tbl WHERE IDJadwal = '$jid' limit 1");

		return $query->row();
	}

	public function getKap($jid) {
		$jid=$this->db->escape_str($jid);

		$query = $this->db->query("SELECT Kap FROM _v2_jadwal WHERE IDJadwal = '$jid' limit 1");

		return $query->row();
	}

	public function batasKrs($thn,$kdp,$kdfv) {
		$thn=$this->db->escape_str($thn);
		$kdp=$this->db->escape_str($kdp);
		$kdfv=$this->db->escape_str($kdfv);

		$query = $this->db->query("SELECT krsm, krss, ukrsm, ukrss, Tahun FROM _v2_bataskrs WHERE Tahun='$thn' and KodeProgram='$kdp' and KodeJurusan='$kdfv' and NotActive='N'");
		
		return $query->row();
	}

	public function getSesi($thn) {
		$thn=$this->db->escape_str($thn);

		$query = $this->db->query("SELECT Sesi FROM _v2_khs WHERE Tahun='".$thn."'");

		return $query->row();
	}

	public function getSesiMax($nim) {
		$nim=$this->db->escape_str($nim);

		$query = $this->db->query("SELECT max(Sesi) as ssi FROM _v2_khs WHERE NIM='$nim' limit 1");

		return $query->row();
	}

	public function getTahunNextMax($nim) {
		$nim=$this->db->escape_str($nim);

		$query = $this->db->query("SELECT max(Tahun) as ThnNext from _v2_khs where NIM='$nim' limit 1");

		return $query->row();
	}

	public function getKodeFakultasTable($unip,$table) {
		$unip=$this->db->escape_str($unip);
		$table=$this->db->escape_str($table);

		$query = $this->db->query("SELECT KodeFakultas from ".$table." WHERE Login='$unip' limit 1");

		return $query->row();
	}
	
	public function getKodeJurusanTable($unip,$table) {
		$unip=$this->db->escape_str($unip);
		$table=$this->db->escape_str($table);

		$query = $this->db->query("SELECT KodeJurusan from ".$table." WHERE Login='$unip' limit 1");

		return $query->row();
	}

	public function getAllJadwal($jid){
		$jid=$this->db->escape_str($jid);

		$query = $this->db->query("SELECT * FROM _v2_jadwal WHERE IDJADWAL='".$jid."'");

		return $query->row();		
	}

	public function updateSksKhs($jml,$nim,$thn) {
		$jml=$this->db->escape_str($jml);
		$nim=$this->db->escape_str($nim);
		$thn=intval($thn);

		$this->db->query("UPDATE _v2_khs SET SKS = '$jml' WHERE NIM = '$nim' and Tahun='$thn'");

	}

	public function deleteKrs($tbl,$id,$nim,$thn) {
		$tbl=$this->db->escape_str($tbl);
		$id=$this->db->escape_str($id);
		$nim=$this->db->escape_str($nim);
		$thn=$this->db->escape_str($thn);

		$delete = $this->db->query("DELETE from ".$tbl." WHERE ID='$id' and NIM='$nim' and Tahun='$thn'");

		if($delete){
			return true;
		}else{
			return false;
		}
	}

	public function updateKhsDelete($nim,$thn) {
		$nim=$this->db->escape_str($nim);
		$thn=$this->db->escape_str($thn);

		$update = $this->db->query("UPDATE _v2_khs set TglUbah=now(), CekUbah='N' where Tahun='$thn' and NIM='$nim'");

		if($update){
			return true;
		}else{
			return false;
		}
	}

	public function insertLogKrsDel($data){
		$NIM = $data['NIM'];
		$Tahun = $data['Tahun'];
		$KodeMK = $data['KodeMK'];
		$NamaMK = $data['NamaMK'];
		$IDJadwal = $data['IDJadwal'];
		$SKS = $data['SKS'];
		$unip = $data['unip'];

		$insert = $this->db->query("INSERT into _v2_log_krs_del (tgl,NIM,Tahun,KodeMK,NamaMK,IDJadwal,SKS,unip) values (now(),'$NIM','$Tahun','$KodeMK','$NamaMK','$IDJadwal','$SKS','$unip')");

		if($insert){
			return true;
		}else{
			return false;
		}
	}

	public function updateMaxKhs($data) {
		$NIM = $data['NIM'];
		$Tahun = $data['Tahun'];
		$MaxSKS = $data['MaxSKS'];

		$update = $this->db->query("UPDATE _v2_khs set MaxSKS=$MaxSKS where NIM='$NIM' and Tahun='$Tahun'");

		if($update){
			return true;
		}else{
			return false;
		}
	}

	public function updateKhsRegUlang($thn, $nim) {
		$nim=$this->db->escape_str($nim);
		$thn=intval($thn);

		$update = $this->db->query("UPDATE _v2_khs set Status='A', Registrasi='Y', TglRegistrasi=now() where Tahun='$thn' and NIM='$nim'");

		if($update){
			return true;
		}else{
			return false;
		}
	}

	public function getSksTahun($nim,$thn){
		$nim=$this->db->escape_str($nim);
		$thn=intval($thn);
		
		$query = $this->db->query("SELECT Tahun FROM _v2_khs WHERE NIM='".$nim."' and Tahun='".$thn."'");

		if($query->num_rows() == 0)
	    {
	        return false;
	    }
	    else
	    {
			return $query->row();
	    }
	}

	public function getKodeBiaya($nim){
		$nim=$this->db->escape_str($nim);
		
		$query = $this->db->query("SELECT KodeBiaya FROM _v2_mhsw WHERE NIM='".$nim."'");

		if($query->num_rows() == 0)
	    {
	        return false;
	    }
	    else
	    {
			return $query->row();
	    }
	}

	public function getSesiJurusan($kdj){
		$kdj=$this->db->escape_str($kdj);		
		
		$query = $this->db->query("SELECT Sesi FROM jurusan WHERE Kode='".$kdj."'");

		if($query->num_rows() == 0)
	    {
	        return false;
	    }
	    else
	    {
			return $query->row();
	    }
	}

	public function insertKhs($data) {
		$NIM = $data['NIM'];
		$Tahun = $data['Tahun'];
		$KodeBiaya = $data['KodeBiaya'];
		$Sesi = $data['Sesi'];
		$Status = $data['Status'];
		$MaxSKS = $data['MaxSKS'];

		$save =	$this->db->query("INSERT INTO _v2_khs (NIM, Tahun, KodeBiaya, Sesi, Status, MaxSKS) values ('$NIM', '$Tahun', '$KodeBiaya', '$Sesi', '$Status', '$MaxSKS')");
		if($save){
			return true;
		}else{
			return false;
		}
	}
}