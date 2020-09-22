<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ipk_model extends CI_Model{
	
	private $db2;

	public function __construct(){
		parent::__construct();
		$this->db2 = $this->load->database('spc', TRUE);
	}

	//WAWAN CETAK KHS PRODI
	public function getKdf($kdj){
		$kdj=$this->db->escape_str($kdj);

		$query = $this->db->query("SELECT KodeFakultas FROM _v2_jurusan WHERE Kode='$kdj' limit 1");

		return $query->row()->KodeFakultas;
	}

	public function getDataIpk($semesterAkademik,$jurusan,$program,$angkatan,$str){
        $semesterAkademik=$this->db->escape_str($semesterAkademik);
        $jurusan=$this->db->escape_str($jurusan);
        $program=$this->db->escape_str($program);
        $angkatan=$this->db->escape_str($angkatan);

        $query = $this->db->query("SELECT k.Tahun,k.NIM,m.Name,m.KodeProgram,m.KodeFakultas,m.KodeJurusan,k.SKS,k.SKSLulus,k.IPS,k.IPK,k.TotalSKS,k.TotalSKSLulus from _v2_khs k, _v2_mhsw m where k.NIM=m.NIM and k.Tahun='$semesterAkademik' and m.KodeJurusan='$jurusan' and m.KodeProgram like '%$program%' and m.TahunAkademik like '%$angkatan%' $str");

        return $query->result();
    }
    public function getDatakrsCetak($semesterAkademik,$nim){
        $semesterAkademik=$this->db->escape_str($semesterAkademik);
        $nim=$this->db->escape_str($nim);

        $query = $this->db->query("SELECT * from _v2_krs$semesterAkademik where NIM='$nim' and Tahun='$semesterAkademik' AND NotActive_KRS='N' order by KodeMK");

        return $query->result();
    }

    public function getTtd($kdj,$kdp){
    	if ($kdp=='NONREG') {
    		$kdp="RESO";
    	}elseif($kdp=='S2') {
    		$kdp="REG";
    	}
        // and j.jenis_program='$kdp'
    	$query = $this->db->query("SELECT * from _v2_jurusan j where j.Kode='$kdj' LIMIT 1");

        return $query->row();
    }

	//

	public function getMhswIpk($nim) {
		$nim=$this->db->escape_str($nim);
		$query = $this->db->query("SELECT m.*, f.Nama_Indonesia as FAK, j.Nama_Indonesia as JUR, jj.Nama as JEN, concat(d.Name, ', ', d.Gelar) as DSN from _v2_mhsw m left outer join fakultas f on m.KodeFakultas=f.Kode left outer join _v2_jurusan j on m.KodeJurusan=j.Kode left outer join _v2_jenjangps jj on j.Jenjang=jj.Kode left outer join _v2_dosen d on m.DosenID=d.nip where m.NIM='$nim'");

		return $query->result();
	}

	public function getSesiMax($nim) {
		$nim=$this->db->escape_str($nim);

		$query = $this->db->query("SELECT max(Sesi) as ssi FROM _v2_khs WHERE NIM='$nim' limit 1");

		return $query->row();
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

		$query = $this->db->query("SELECT Sesi, (Bobot / SKS) as bbt, Bobot, SKS from _v2_khs where NIM='$nim' order by Sesi desc limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getMhswKode($nim){
		$nim=$this->db->escape_str($nim);
		
		$query = $this->db->query("select KodeFakultas,KodeJurusan from _v2_mhsw where NIM='$nim' limit 1");

		return $query->row();
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

	public function updatetahunakademik($id,$semester){
		$id=$this->db->escape_str($id);
		$semester=$this->db->escape_str($semester);

		return $this->db->query("UPDATE _v2_khs set Tahun='$semester' where ID='$id'");
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

	public function getDataKhs($nim) {
		$nim=$this->db->escape_str($nim);
		$query = $this->db->query("SELECT k.*, k.ID as KHSId, m.DosenID, m.KodeProgram,m.TahunAkademik, sm.Nama as STA, sm.Nilai as ACTIVE FROM _v2_khs k inner join _v2_mhsw m on k.NIM=m.NIM left outer join _v2_statusmhsw sm on k.Status=sm.Kode where k.NIM='$nim' order by k.Tahun");

		return $query->result();
	}

	public function getCountKrs($nim,$thn) {
		$nim=$this->db->escape_str($nim);
		$thn=$this->db->escape_str($thn);
		$tabel = "_v2_krs".$thn;
		if ($this->db->table_exists($tabel) )
		{
			$query = $this->db->query("SELECT count(st_feeder) as jmlKrs FROM $tabel WHERE NIM = '$nim'");
			return $query->row();
		}else{
			return 0;
		}
	}

	public function getCekFeederKrs($nim,$thn) {
		$nim=$this->db->escape_str($nim);
		$thn=$this->db->escape_str($thn);
		$tabel = "_v2_krs".$thn;

		if ($this->db->table_exists($tabel) )
		{
			$query = $this->db->query("SELECT st_feeder, st_abaikan FROM $tabel WHERE NIM = '$nim'");
			return $query->row();
		}else{
			return 0;
		}
	}

	public function getFeederKrs($nim,$thn) {
		$nim=$this->db->escape_str($nim);
		$thn=$this->db->escape_str($thn);
		$tabel = "_v2_krs".$thn;

		if ($this->db->table_exists($tabel) )
		{
			$query = $this->db->query("SELECT st_feeder, st_abaikan, NotActive_KRS FROM $tabel WHERE NIM = '$nim'");
			if($query->num_rows() == 0)
			{
				return false;
			}else{
				return $query->result();
			}
		}else{
			return false;
		}
	}

	public function getKhsPeriode($nim, $thn) {
		$nim=$this->db->escape_str($nim);
		$query = $this->db->query("SELECT Tahun FROM _v2_khs where NIM='$nim' AND Tahun<='$thn' order by Tahun");

		return $query->result();
	}



	public function getSql($sql) {
		$query = $this->db->query($sql);

		return $query->result();
	}

	public function getPeriodeAktif() {
		$query = $this->db->query("SELECT periode_aktif FROM _v2_periode_aktif where status='aktif' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function getSksBbt($nim) {
		$nim=$this->db->escape_str($nim);
		$query = $this->db->query("SELECT sum(Bobot) as BBT, sum(SKS) as SKS FROM _v2_khs where NIM='$nim'");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function updateIpkMhsw($TotSKS,$ipk,$nim,$TotSKSLulus) {
		$TotSKS=$this->db->escape_str($TotSKS);
		$ipk=$this->db->escape_str($ipk);
		$nim=$this->db->escape_str($nim);
		$TotSKSLulus=$this->db->escape_str($TotSKSLulus);

		return $this->db->query("UPDATE _v2_mhsw set IPK='$ipk', TotalSKS='$TotSKS', TotalSKSLulus='$TotSKSLulus' where NIM='$nim'");
	}

	public function getTahunKhs($nim,$tahun) {
		$nim=$this->db->escape_str($nim);
		$tahun=intval($tahun);
		$query = $this->db->query("SELECT Tahun FROM _v2_khs where NIM='$nim' and Tahun='$tahun'");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return true;
		}
	}
	public function insertKhs($data) {
		$NIM = $data['NIM'];
		$Tahun = $data['Tahun'];
		$Sesi = $data['Sesi'];
		$Status = $data['Status'];
		$MaxSKS = $data['MaxSKS'];

		$save =	$this->db->query("INSERT INTO _v2_khs (NIM, Tahun, Sesi, Status, MaxSKS) values ('$NIM', '$Tahun', '$Sesi', '$Status', '$MaxSKS')");
		if($save){
			return true;
		}else{
			return false;
		}
	}

	public function updateMhsw($status,$thn,$nim) {
		$nim=$this->db->escape_str($nim);
		$thn=intval($thn);

		$save =	$this->db->query("UPDATE _v2_mhsw SET STATUS = '$status', TahunStatus = '$thn' WHERE NIM = '$nim'");
		if($save){
			return true;
		}else{
			return false;
		}
	}

	public function updateKhs($data) {
		$NIM = $data['NIM'];
		$Tahun = $data['Tahun'];
		$MaxSKS = $data['MaxSKS'];
		$Sesi = $data['Sesi'];
		
		$update =	$this->db->query("UPDATE _v2_khs set MaxSKS='$MaxSKS', Sesi='$Sesi' where NIM='$NIM' and Tahun='$Tahun'");
		if($update){
			return true;
		}else{
			return false;
		}
	}

	public function updateKhsCuti($data) {
		$NIM = $data['NIM'];
		$Tahun = $data['Tahun'];
		$Status = $data['Status'];
		
		$update =	$this->db->query("UPDATE _v2_khs set Status='$Status' where NIM='$NIM' and Tahun='$Tahun'");
		if($update){
			return true;
		}else{
			return false;
		}
	}

	public function updateKhsUnregist($data) {
		$NIM = $data['NIM'];
		$Tahun = $data['Tahun'];
		$Status = $data['Status'];
		
		$update =	$this->db->query("UPDATE _v2_khs set Status='$Status' where NIM='$NIM' and Tahun='$Tahun'");
		if($update){
			return true;
		}else{
			return false;
		}
	}

	public function updateMhsCuti($data) {
		$NIM = $data['NIM'];
		$Tahun = $data['Tahun'];
		$Status = $data['Status'];
		
		$update =	$this->db->query("UPDATE _v2_mhsw set Status='$Status',TahunStatus='$Tahun' where NIM='$NIM'");
		if($update){
			return true;
		}else{
			return false;
		}
	}

	public function getMaxSKS2($tahun,$nim) {
		$nim = $this->db->escape_str($nim);
		$tahun = intval($tahun);
		/*$nim='F55116123';
		$tahun = '20162';*/

		$query = $this->db->query("SELECT MaxSKS2 from _v2_khs where Tahun='$tahun' and NIM='$nim' limit 1");

        if($query){
			return $query->row();
        }else{
			return false;
		}
	}

	public function updateMaxSks($maxsks,$nim,$thnc) {
		$NIM = $this->db->escape_str($nim);
		$Tahun = $this->db->escape_str($thnc);
		$MaxSKS = $this->db->escape_str($maxsks);
		
		$update =	$this->db->query("UPDATE _v2_khs set MaxSKS='$MaxSKS' where NIM='$NIM' and Tahun='$Tahun'");
		if($update){
			return true;
		}else{
			return false;
		}
	}

	/*public function getDataKrs($nim,$thn,$tbl) {
		$tbl=$this->db->escape_str($tbl);
		$nim=$this->db->escape_str($nim);
		$thn=intval($thn);
		$query = $this->db->query("SELECT * from ".$tbl." WHERE NIM='$nim' and tahun='$thn' and Notactive='N' order by KodeMK");

        return $query->result();
	}*/

	public function getDataKrsPeriode($nim,$thn,$tbl) {
		$tbl=$this->db->escape_str($tbl);
		$nim=$this->db->escape_str($nim);
		$thn=intval($thn);
		$query = $this->db->query("SELECT * from ".$tbl." WHERE NIM='$nim' and Tahun='$thn' and Notactive_KRS='N'");

        return $query->result();
	}

	public function getMaxSksMax($IPS,$nim) {
		$IPS = $this->db->escape_str($IPS);
		$nim = $this->db->escape_str($nim);

		$query = $this->db->query("SELECT SKSMax from _v2_mhsw m, _v2_max_sks mx where m.KodeJurusan=mx.KodeJurusan and IPSMin <= $IPS and IPSmax >= $IPS  and mx.NotActive='N' and m.nim='$nim' limit 1");
		
		return $query->row();
	}

	public function updateKhsMax($data) {
		$IPS = $data['IPS'];
		$SKSLulus = $data['SKSLulus'];
		$SKS = $data['SKS'];
		$MaxSKS2 = $data['MaxSKS2'];
		$NIM = $data['NIM'];
		$Tahun = $data['Tahun'];
		
		$update =	$this->db->query("UPDATE _v2_khs set stprc='1',IPS='$IPS',SKSLulus='$SKSLulus', SKS='$SKS', MaxSKS2='$MaxSKS2' where NIM='$NIM' and Tahun='$Tahun'");
		if($update){
			return true;
		}else{
			return false;
		}
	}

	public function getMhswTahunAkademik($nim) {
		$nim = $this->db->escape_str($nim);

		$query = $this->db->query("SELECT TahunAkademik from _v2_mhsw WHERE Login='$nim'");
		
		return $query->row();
	}

	public function getKrsFak($kdf,$nim, $thn, $tabel) {
		$nim = $this->db->escape_str($nim);
		$kdf = $this->db->escape_str($kdf);
		$thn = intval($thn);

		$query = $this->db->query("SELECT Min(GradeNilai) as GdNilai,SKS as nSks,Max(Bobot) as bbt from ".$tabel." where NIM='$nim' and Tahun<='$thn' and GradeNilai!='K' and NotActive='N' group by NamaMK");

        return $query->result();		
	}

	public function getKrsFakTR($nim) {
		$nim = $this->db->escape_str($nim);

		$query = $this->db->query("SELECT Min(GradeNilai) as GdNilai,SKS as nSks,Max(Bobot) as bbt from _v2_krsTR where NIM='$nim' and Tahun='TR' and GradeNilai!='K' and NotActive='N' group by NamaMK");

        return $query->result();
	}

	public function getKrsFakSama($kdf,$nim, $thn, $tabel) {
		$nim = $this->db->escape_str($nim);
		$kdf = $this->db->escape_str($kdf);
		$thn = intval($thn);

		$query = $this->db->query("SELECT GradeNilai as GdNilai,SKS as nSks,Bobot as bbt from ".$tabel." where NIM='$nim' and Tahun<='$thn' and NotActive='N' group by NamaMK");

        return $query->result();
	}

	/*public function getKrsFak($kdf,$nim, $thn) {
		$nim = $this->db->escape_str($nim);
		$kdf = $this->db->escape_str($kdf);
		$thn = intval($thn);

		$query = $this->db->query("SELECT Min(GradeNilai) as GdNilai,SKS as nSks,Max(Bobot) as bbt from _v2_krs".$kdf." where NIM='$nim' and Tahun<='$thn' and GradeNilai!='K' and NotActive='N' group by NamaMK");

        return $query->result();		
	}

	public function getKrsFakSama($kdf,$nim, $thn) {
		$nim = $this->db->escape_str($nim);
		$kdf = $this->db->escape_str($kdf);
		$thn = intval($thn);

		$query = $this->db->query("SELECT GradeNilai as GdNilai,SKS as nSks,Bobot as bbt from _v2_krs".$kdf." where NIM='$nim' and Tahun<='$thn' and NotActive='N' group by NamaMK");

        return $query->result();
	}*/

	public function updateKhsIPK($data) {
		$NIM = $data['NIM'];
		$Tahun = $data['Tahun'];
		$IPK = $data['IPK'];
		$TotalSKS = $data['TotalSKS'];
		$TotalSKSLulus = $data['TotalSKSLulus'];
		
		$update =	$this->db->query("UPDATE _v2_khs k,_v2_mhsw m set stprc='2', k.IPK='$IPK',k.TotalSKS='$TotalSKS',k.TotalSKSLulus='$TotalSKSLulus',m.IPK='$IPK',m.TotalSKS='$TotalSKS',m.TotalSKSLulus='$TotalSKSLulus' where k.NIM=m.NIM and k.NIM='$NIM' and k.Tahun='$Tahun'");
		if($update){
			return true;
		}else{
			return false;
		}
	}

	public function deleteIpk($KHSId,$nim,$thn) {
		$KHSId=$this->db->escape_str($KHSId);
		$nim=$this->db->escape_str($nim);
		$thn=intval($thn);

		$delete = $this->db->query("DELETE FROM _v2_khs WHERE ID='$KHSId' AND NIM='$nim' AND Tahun='$thn'");

		if($delete){
			return true;
		}else{
			return false;
		}
	}	

	public function getTahunNextMax($nim) {
		$nim=$this->db->escape_str($nim);

		$query = $this->db->query("SELECT max(Tahun) as ThnNext from _v2_khs where NIM='$nim' limit 1");

		return $query->row();
	}

	public function getKhs($nim) {
		$nim = $this->db->escape_str($nim);
		
		$query = $this->db->query("SELECT Tahun from _v2_khs where NIM='$nim' ORDER BY Tahun");

        return $query->result();
	}

	public function getKhsThis ($nim, $thn) {
		$nim = $this->db->escape_str($nim);
		$thn = $this->db->escape_str($thn);
		
		$query = $this->db->query("SELECT IPS,Tahun,SKS,Bobot as bbt, GradeNilai as GdNilai from _v2_khs where NIM='$nim' AND Tahun<='$thn' AND Status='A' ORDER BY Tahun");

        return $query->result();
	}

	public function getJmlJadwal($table, $nim, $thn) {
		$nim = $this->db->escape_str($nim);
		$thn = $this->db->escape_str($thn);
		$table = $this->db->escape_str($table);

		$query = $this->db->query("SELECT IDJadwal FROM $table WHERE NIM= '$nim' and Tahun= '$thn'");

        return $query->result();
	}

	public function cekJmlDosen($IDJadwal) {
		$IDJadwal = $this->db->escape_str($IDJadwal);

		$query = $this->db->query("SELECT j.IDDosen from _v2_jadwal j, _v2_dosen d where j.IDDosen=d.NIP and j.IDJadwal='$IDJadwal'");

        return $query->result();
	}

	public function cekJmlAssDosen($IDJadwal) {
		$IDJadwal = $this->db->escape_str($IDJadwal);

		$query = $this->db->query("SELECT j.IDDosen from _v2_jadwal j, _v2_jadwalassdsn d where j.IDDosen=d.IDDosen and j.IDJadwal='$IDJadwal'");

        return $query->result();
	}

	public function cekPjMutu($IDJadwal, $nim) {
		$IDJadwal = $this->db->escape_str($IDJadwal);
		$nim = $this->db->escape_str($nim);

		$query = $this->db->query("SELECT NIM from _v2_pjamin_mutu where IDJadwal='$IDJadwal' and NIM='$nim'");

        return $query->result();

	}

	public function getHadir($thn,$nim,$kodeMk) {
		$thn = $this->db->escape_str($thn);
		$nim = $this->db->escape_str($nim);
		$kodeMk = $this->db->escape_str($kodeMk);
		$tabel = "_v2_krs".$thn;

		$query = $this->db->query("SELECT Hadir from $tabel where KodeMK='$kodeMk' and NIM='$nim' and Tahun='$thn' limit 1");

        return $query->row();	
	}

	public function cekBayar($thn,$nim) {
		$thn = $this->db->escape_str($thn);
		$nim = $this->db->escape_str($nim);
		
		$query = $this->db->query("SELECT bayar from _v2_spp2 where tahun='$thn' and nim='$nim'");

        return $query->row();
	}
}