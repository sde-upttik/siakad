<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_model extends CI_Model{
	
	private $db2;

	public function __construct(){
		parent::__construct();
		$this->db2 = $this->load->database('siakad', TRUE);
	}

	public function getRekapJmlMhs($fak)
	{
		$fak=$this->db2->escape_str($fak);
		$query = $this->db2->query("SELECT f.Singkatan, f.Kode, count(m.KodeFakultas) as jml,sum(if(m.TahunAkademik='2015',1,0)) as j1,sum(if(m.TahunAkademik='2015' AND m.Sex='P',1,0)) as jp1,sum(if(m.TahunAkademik='2016',1,0)) as j2,sum(if(m.TahunAkademik='2016' AND m.Sex='P',1,0)) as jp2,sum(if(m.TahunAkademik='2010',1,0)) as j4,sum(if(m.TahunAkademik='2010' AND m.Sex='P',1,0)) as jp4,sum(if(m.TahunAkademik='2011',1,0)) as j5,sum(if(m.TahunAkademik='2011' AND m.Sex='P',1,0)) as jp5,sum(if(m.TahunAkademik='2012',1,0)) as j6,sum(if(m.TahunAkademik='2012' AND m.Sex='P',1,0)) as jp6,sum(if(m.TahunAkademik='2013',1,0)) as j7,sum(if(m.TahunAkademik='2013' AND m.Sex='P',1,0)) as jp7,sum(if(m.TahunAkademik='2014',1,0)) as j8,sum(if(m.TahunAkademik='2014' AND m.Sex='P',1,0)) as jp8,sum(if(m.TahunAkademik='2017',1,0)) as j9,sum(if(m.TahunAkademik='2017' AND m.Sex='P',1,0)) as jp9 from mhsw m LEFT JOIN fakultas f on m.KodeFakultas=f.Kode where m.KodeFakultas='$fak' and m.TahunAkademik >='2010' and ( (m.Status!='P' and m.Status!='L' and m.Status!='D') or (m.Status='L' and m.StatusBayar='1'))");
		return $query->row();
	}

	public function getDetailRekap($fak)
	{
		$fak=$this->db2->escape_str($fak);
		$query = $this->db2->query("SELECT j.Nama_Indonesia,m.KodeJurusan, m.TahunAkademik, count(m.KodeJurusan) as jml ,sum(if(m.TahunAkademik='2015',1,0)) as j1,sum(if(m.TahunAkademik='2015' AND m.Sex='P',1,0)) as jp1,sum(if(m.TahunAkademik='2008',1,0)) as j2,sum(if(m.TahunAkademik='2008' AND m.Sex='P',1,0)) as jp2,sum(if(m.TahunAkademik='2009',1,0)) as j3,sum(if(m.TahunAkademik='2009' AND m.Sex='P',1,0)) as jp3,sum(if(m.TahunAkademik='2010',1,0)) as j4,sum(if(m.TahunAkademik='2010' AND m.Sex='P',1,0)) as jp4,sum(if(m.TahunAkademik='2011',1,0)) as j5,sum(if(m.TahunAkademik='2011' AND m.Sex='P',1,0)) as jp5,sum(if(m.TahunAkademik='2012',1,0)) as j6,sum(if(m.TahunAkademik='2012' AND m.Sex='P',1,0)) as jp6,sum(if(m.TahunAkademik='2013',1,0)) as j7,sum(if(m.TahunAkademik='2013' AND m.Sex='P',1,0)) as jp7,sum(if(m.TahunAkademik='2014',1,0)) as j8,sum(if(m.TahunAkademik='2014' AND m.Sex='P',1,0)) as jp8,sum(if(m.TahunAkademik='2016',1,0)) as j9,sum(if(m.TahunAkademik='2016' AND m.Sex='P',1,0)) as jp9,sum(if(m.TahunAkademik='2017',1,0)) as j10,sum(if(m.TahunAkademik='2017' AND m.Sex='P',1,0)) as jp10 from mhsw m LEFT JOIN jurusan j on j.Kode=m.KodeJurusan where m.TahunAkademik >='2010' and ( (m.Status!='P' and m.Status!='L' and m.Status!='D') or (m.Status='L' and m.StatusBayar='1')) and m.KodeFakultas='$fak' group by m.KodeJurusan order by m.KodeJurusan");
		return $query->result();
	}

	public function getRekapMhsTahun10()
	{
		$query = $this->db->query("SELECT TahunAkademik FROM _v2_mhsw GROUP BY TahunAkademik ORDER BY TahunAkademik DESC limit 10");
		return $query->result();
	}

	public function getRekapMhsAktif($fak)
	{
		$fak=$this->db->escape_str($fak);
		$query = $this->db->query("SELECT Singkatan, Kode from fakultas WHERE Kode='$fak'");
		return $query->row();
	}

	public function getRekapMhsAktifJurusan($fak)
	{
		$fak=$this->db->escape_str($fak);
		$query = $this->db->query("SELECT Kode, Nama_Indonesia from _v2_jurusan WHERE KodeFakultas='$fak'");
		return $query->result();
	}

	public function getJmlMhsAktif($fak,$thnAkhir)
	{
		$fak=$this->db->escape_str($fak);
		$query = $this->db->query("SELECT count(KodeFakultas) as jml FROM _v2_mhsw where KodeFakultas='$fak' and TahunAkademik >='$thnAkhir' and StatusBayar='1'");
		return $query->row();
	}

	public function getJmlMhsAktifJurusan($jur,$thnAkhir)
	{
		$fak=$this->db->escape_str($fak);
		$query = $this->db->query("SELECT count(KodeJurusan) as jml FROM _v2_mhsw where KodeJurusan='$jur' and TahunAkademik >='$thnAkhir' and StatusBayar='1'");
		return $query->row();
	}

	public function getMhswP($fak,$thnAkhir,$thnAkademik)
	{
		$fak=$this->db->escape_str($fak);
		$query = $this->db->query("SELECT sum(if(m.TahunAkademik='$thnAkademik' AND m.Sex='P',1,0)) as jp from _v2_mhsw m LEFT JOIN fakultas f on m.KodeFakultas=f.Kode where m.KodeFakultas='$fak' and m.TahunAkademik >='$thnAkhir' and m.StatusBayar='1'");
		return $query->row();
	}

	public function getMhswPJurusan($jur,$thnAkhir,$thnAkademik)
	{
		$jur=$this->db->escape_str($jur);
		$query = $this->db->query("SELECT sum(if(m.TahunAkademik='$thnAkademik' AND m.Sex='P',1,0)) as jp from _v2_mhsw m LEFT JOIN _v2_jurusan j on m.KodeJurusan=j.Kode where m.KodeJurusan='$jur' and m.TahunAkademik >='$thnAkhir' and m.StatusBayar='1'");
		return $query->row();
	}

	public function getMhswLP($fak,$thnAkhir,$thnAkademik)
	{
		$fak=$this->db->escape_str($fak);
		$query = $this->db->query("SELECT sum(if(m.TahunAkademik='$thnAkademik',1,0)) as j from _v2_mhsw m LEFT JOIN fakultas f on m.KodeFakultas=f.Kode where m.KodeFakultas='$fak' and m.TahunAkademik >='$thnAkhir' and m.StatusBayar='1'");
		return $query->row();
	}

	public function getMhswLPJurusan($jur,$thnAkhir,$thnAkademik)
	{
		$jur=$this->db->escape_str($jur);
		$query = $this->db->query("SELECT sum(if(m.TahunAkademik='$thnAkademik',1,0)) as j from _v2_mhsw m LEFT JOIN _v2_jurusan j on m.KodeJurusan=j.Kode where m.KodeJurusan='$jur' and m.TahunAkademik >='$thnAkhir' and m.StatusBayar='1'");
		return $query->row();
	}

	public function getDetailRekapAktif($fak)
	{
		$fak=$this->db->escape_str($fak);
		$query = $this->db->query("SELECT j.Nama_Indonesia, m.KodeJurusan,m.TahunAkademik, count(m.KodeJurusan) as Jml ,sum(if(m.TahunAkademik='2015',1,0)) as j1,sum(if(m.TahunAkademik='2015' AND m.Sex='P',1,0)) as jp1,sum(if(m.TahunAkademik='2016',1,0)) as j2,sum(if(m.TahunAkademik='2016' AND m.Sex='P',1,0)) as jp2,sum(if(m.TahunAkademik='2017',1,0)) as j3,sum(if(m.TahunAkademik='2017' AND m.Sex='P',1,0)) as jp3,sum(if(m.TahunAkademik='2010',1,0)) as j4,sum(if(m.TahunAkademik='2010' AND m.Sex='P',1,0)) as jp4,sum(if(m.TahunAkademik='2011',1,0)) as j5,sum(if(m.TahunAkademik='2011' AND m.Sex='P',1,0)) as jp5,sum(if(m.TahunAkademik='2012',1,0)) as j6,sum(if(m.TahunAkademik='2012' AND m.Sex='P',1,0)) as jp6,sum(if(m.TahunAkademik='2013',1,0)) as j7,sum(if(m.TahunAkademik='2013' AND m.Sex='P',1,0)) as jp7,sum(if(m.TahunAkademik='2014',1,0)) as j8,sum(if(m.TahunAkademik='2014' AND m.Sex='P',1,0)) as jp8,sum(if(m.TahunAkademik='2015',1,0)) as j9,sum(if(m.TahunAkademik='2015' AND m.Sex='P',1,0)) as jp9 from mhsw m LEFT JOIN jurusan j on j.Kode=m.KodeJurusan where m.TahunAkademik >='2010' and m.StatusBayar='1' and m.KodeFakultas='$fak' group by m.KodeJurusan order by m.KodeJurusan");
		return $query->result();
	}

	public function getRekapFeederBelum($thn)
	{
		$thn=$this->db->escape_str($thn);
		$tabel = "_v2_krs".$thn;
		$query = $this->db->query("SELECT SUBSTR(k.NIM, 1, 1) as KodeFakultas,f.Singkatan,COUNT(IF(k.st_feeder<=0,1,NULL)) as belumKirim,COUNT(IF(s.st_feeder<=0,1,NULL)) as belumKrs FROM _v2_khs k LEFT JOIn $tabel s ON k.NIM=s.NIM LEFT JOIN fakultas f ON SUBSTR(k.NIM, 1, 1)=f.Kode WHERE k.Tahun='$thn' group by SUBSTR(k.NIM, 1, 1)");
		return $query->result();
	}

	public function getRekapFeederSudah($thn)
	{
		$thn=$this->db->escape_str($thn);
		$tabel = "_v2_krs".$thn;
		$query = $this->db->query("SELECT SUBSTR(k.NIM, 1, 1) as KodeFakultas,f.Singkatan,COUNT(IF(k.st_feeder>0,1,NULL)) as sudahKirim,COUNT(IF(s.st_feeder>0,1,NULL)) as sudahKrs FROM _v2_khs k LEFT JOIn $tabel s ON k.NIM=s.NIM LEFT JOIN fakultas f ON SUBSTR(k.NIM, 1, 1)=f.Kode WHERE k.Tahun='$thn' group by SUBSTR(k.NIM, 1, 1)");
		return $query->result();
	}

	public function getRekapFeederBelumJur($thn,$kdf)
	{
		$thn=$this->db->escape_str($thn);
		$tabel = "_v2_krs".$thn;
		$query = $this->db->query("SELECT SUBSTR(k.NIM, 1, 4) as KodeJurusan,j.Nama_Indonesia,COUNT(IF(k.st_feeder<=0,1,NULL)) as belumKirim,COUNT(IF(s.st_feeder<=0,1,NULL)) as belumKrs FROM _v2_khs k LEFT JOIn $tabel s ON k.NIM=s.NIM LEFT JOIN _v2_jurusan j ON SUBSTR(k.NIM, 1, 4)=j.Kode WHERE k.Tahun='$thn' AND j.KodeFakultas='$kdf' group by SUBSTR(k.NIM, 1, 4)");
		return $query->result();
	}

	public function getRekapFeederSudahJur($thn,$kdf)
	{
		$thn=$this->db->escape_str($thn);
		$tabel = "_v2_krs".$thn;
		$query = $this->db->query("SELECT SUBSTR(k.NIM, 1, 4) as KodeJurusan,j.Nama_Indonesia,COUNT(IF(k.st_feeder>0,1,NULL)) as sudahKirim,COUNT(IF(s.st_feeder>0,1,NULL)) as sudahKrs FROM _v2_khs k LEFT JOIn $tabel s ON k.NIM=s.NIM LEFT JOIN _v2_jurusan j ON SUBSTR(k.NIM, 1, 4)=j.Kode WHERE k.Tahun='$thn' AND j.KodeFakultas='$kdf' group by SUBSTR(k.NIM, 1, 4)");
		return $query->result();
	}

	public function getRekapFeederBelumMhsw($thn,$kdj)
	{
		$thn=$this->db->escape_str($thn);
		$tabel = "_v2_krs".$thn;
		$query = $this->db->query("SELECT m.Name,IF(k.st_feeder<=0,1,0) as belumKirim,IF(s.st_feeder<=0,1,0) as belumKrs FROM _v2_khs k LEFT JOIn $tabel s ON k.NIM=s.NIM LEFT JOIN _v2_mhsw m ON k.NIM=m.NIM WHERE k.Tahun='$thn' AND m.KodeJurusan='$kdj'");
		return $query->result();
	}

	public function getRekapFeederSudahMhsw($thn,$kdj)
	{
		$thn=$this->db->escape_str($thn);
		$tabel = "_v2_krs".$thn;
		$query = $this->db->query("SELECT m.Name,IF(k.st_feeder>0,1,0) as sudahKirim,IF(s.st_feeder>0,1,0) as sudahKrs FROM _v2_khs k LEFT JOIn $tabel s ON k.NIM=s.NIM LEFT JOIN _v2_mhsw m ON k.NIM=m.NIM WHERE k.Tahun='$thn' AND m.KodeJurusan='$kdj'");
		return $query->result();
	}

	public function getTahun8()
	{
		$query= $this->db->query("SELECT TahunAkademik FROM _v2_mhsw GROUP BY TahunAkademik ORDER BY TahunAkademik DESC LIMIT 8");
		return $query->result();
	}

	public function getRowTahun8()
	{
		$query= $this->db->query("SELECT max(TahunAkademik) as TahunAkademik FROM _v2_mhsw ORDER BY TahunAkademik");
		return $query->row();
	}

	public function getMhsw($jur, $tahun, $jk)
	{
		if($jk=='lp') {
			$Sex = "";
		}else{
			$Sex = "AND Sex='$jk'";
		}
		$query= $this->db->query("SELECT NIM, Name, TahunAkademik, StatusBayar FROM _v2_mhsw WHERE KodeJurusan='$jur' AND TahunAkademik='$tahun' and StatusBayar='1' $Sex");
		return $query->result();
	}

}