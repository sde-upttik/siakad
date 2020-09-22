<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Krs_model extends CI_Model{

	private $db1;
	private $db2;
	
	public function __construct(){
		parent::__construct();
		$this->db1 = $this->load->database('spc', TRUE);
		$this->db2 = $this->load->database('siakad', TRUE);
	}

	//PRC WAWAN PRC KHS
	

	//PRC WAWAN PRC KRS
	public function getTtd($kdj,$kdp){
    	if ($kdp=='NONREG') {
    		$kdp="RESO";
    	}elseif($kdp=='S2') {
    		$kdp="REG";
    	}
    	$query = $this->db->query("SELECT * from _v2_jurusan j where j.Kode='$kdj' LIMIT 1");

        return $query->row();
    }


	public function krsFak() {
		$data = $this->db2->query("SELECT k.* from krsK2M k LEFT JOIN mhsw m ON k.NIM=m.NIM WHERE k.Tahun='TR' AND k.pindah_siakad='0' AND m.KodeFakultas='K2M'");
		return $data->result();
	}

	public function krsFakCek($nim,$id_jadwal,$id_mk,$thn) {
		$tabel = '_v2_krs'.$thn;
		$data = $this->db->query("SELECT NIM,IDJadwal FROM $tabel WHERE NIM='$nim' AND IDJadwal='$id_jadwal' AND IDMK='$id_mk'");
		return $data->num_rows();
	}

	public function krsNotFak($tahun) {
		$tabel = '_v2_krs'.$tahun;
		$data = $this->db->query("SELECT MAX(ID) AS ID,NIM,IDJadwal,COUNT(IDJadwal) FROM $tabel WHERE IDJadwal!='0' GROUP BY NIM,IDJadwal HAVING COUNT(IDJadwal)>1");
		return $data->result();
	}

	function deleteData($ID,$tahun)
	{
		$table='_v2_krs'.$tahun;
		$this->db->where('ID', $ID);
		/*$this->db->where('IDJadwal', $idjadwal);
		$this->db->where('st_feeder', $st);*/
		return $this->db->delete($table);
	}

	function addData($data)
	{
		//untuk insert data ke database
		return $this->db->insert("_v2_krsTR", $data);
	}

	/*function addData($data,$tahun)
	{
		//untuk insert data ke database
		return $this->db->insert("_v2_krs".$tahun, $data);
	}*/

	function updateData($id,$data,$table)
	{
		//update produk berdasarkan id
		$this->db2->where('ID', $id);
		return $this->db2->update($table, $data);
	}

	function cekCariKrsNIM($nim,$tahun)
	{
		$tabel = '_v2_krs'.$tahun;
		if ($this->db->table_exists($tabel) )
		{
			$data = $this->db->query("SELECT NIM,IDJadwal,KodeMK,NamaMK FROM $tabel WHERE NIM='$nim'");
			return $data->num_rows();	
		}else{
			//echo $tabel;
		}
		
	}

	function cariKrsNIM($nim,$tahun)
	{
		$tabel = '_v2_krs'.$tahun;
		if ($this->db->table_exists($tabel) )
		{
			$data = $this->db->query("SELECT NIM,IDJadwal,KodeMK,NamaMK,tanggal FROM $tabel WHERE NIM='$nim'");
			return $data->result();
		}
	}

	function updateDataKrs($nim,$nilaiGradeChange,$bobot,$tahun)
	{
		$tabel = '_v2_krs'.$tahun;
		if ($this->db->table_exists($tabel) )
		{
			//update produk berdasarkan id
			/*$this->db->where('NIM LIKE ', '%$nim%'); 
			$this->db->where('GradeNilai', '$nilaiGradeChange'); 
			$update=$this->db->update($tabel, $data);*/
			$update = $this->db->query("UPDATE $tabel SET Bobot='$bobot' WHERE NIM LIKE '%$nim%' AND GradeNilai='$nilaiGradeChange'");
			
			if($update){
				return 'berhasil';
			}else{
				return 'gagal';
			}
		}
	}




	// TIDAK UNTUK MHSW KRS



	public function getMhswKode($nim){
		$nim=$this->db->escape_str($nim);
		
		$query = $this->db->query("select KodeFakultas,KodeJurusan,KodeProgram from _v2_mhsw where NIM='$nim' limit 1");

		return $query->row();
	}

	public function getMhswKhs($nim,$semesterAkademik) {
		$nim=$this->db->escape_str($nim);
		$semesterAkademik=intval($semesterAkademik);
		$query = $this->db->query("SELECT k.NIM,k.Tahun,m.Name,m.KodeJurusan,concat(m.KodeJurusan,' - ',j.Nama_Indonesia) as nama_jurusan,m.KodeProgram,ds.Name as nama_dosen FROM _v2_khs k left join _v2_mhsw m on k.NIM=m.NIM left join _v2_jurusan j on m.KodeJurusan=j.Kode left join _v2_dosen ds on m.DosenID=ds.nip WHERE k.NIM = '$nim' and k.Tahun = '$semesterAkademik' ORDER BY k.ID");

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

		$query = $this->db->query("SELECT st_feeder from _v2_khs where NIM='$nim' and Tahun='$thn' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}

	public function cekMhswAkademik($nim) {
		$nim=$this->db->escape_str($nim);

		$query = $this->db->query("SELECT TahunAkademik, Status, Semester from _v2_mhsw where NIM='$nim' limit 1");

		return $query->row();
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

		$query = $this->db->query("SELECT count(st_abaikan) as jmlAbaikan from ".$tbl." where NIM='$nim' and st_abaikan>0 AND ((NamaMK!='Seminar Proposal' OR NamaMK!='Skripsi' OR NamaMK!='Praktik Lapangan (Magang)' OR NamaMK!='SKRIPSI' OR NamaMK!='Ko-Kurikuler' OR NamaMK!='Kuliah Kerja Profesi (KKP) / KKN') AND Bobot!='0') group by NIM");

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

		$query = $this->db->query("SELECT st_feeder,NamaMK,Bobot from ".$tbl." where NIM='$nim'");

		return $query->result();
	}

	public function getStAbaikanKrs($tbl,$nim) {
		$tbl=$this->db->escape_str($tbl);
		$nim=$this->db->escape_str($nim);

		$query = $this->db->query("SELECT st_abaikan,NamaMK,Bobot from ".$tbl." where NIM='$nim' and st_feeder<=0");

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

	public function cekRule($nim,$semesterAkademik) {
		$nim=$this->db->escape_str($nim);
		$semesterAkademik=intval($semesterAkademik);
		$query = $this->db->query("SELECT * FROM _v2_rule_siakad WHERE user = '$nim' and tahun = '$semesterAkademik' and form='krsmhsw' limit 1");

		if($query->num_rows() == 0)
	    {
	        return false;
	    }
	    else
	    {
	        return $query->row();
	    }
	}

	public function getTahun($kdj,$semesterAkademik,$kdp) {
		$kdj=$this->db->escape_str($kdj);
		$semesterAkademik=intval($semesterAkademik);
		$query = $this->db->query("SELECT Nama FROM _v2_tahun WHERE KodeJurusan = '$kdj' and Kode = '$semesterAkademik' and KodeProgram='$kdp'");

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

		$query = $this->db->query("SELECT s.Kode,s.Nilai, s.Nama FROM _v2_khs h left outer join _v2_statusmhsw s on h.Status=s.Kode WHERE h.Tahun='$semesterAkademik' and h.NIM = '$nim' limit 1");

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

	public function cekLevel($ulevel,$unip) {
		$ulevel=$this->db->escape_str($ulevel);
		$unip=$this->db->escape_str($unip);
	
		$query = $this->db->query("SELECT * from _v2_rule_siakad where user='$unip' and ulevel='$ulevel' AND form='krsmhsw' limit 1");

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

	public function saveKrs($dataKrs, $tbl, $st_wali) {
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
					//'st_wali'   => $st_wali

		return $this->db->insert($tbl, $data);
	}

	public function insertRuleSemester($nim,$semesterAkademik) {
		$data = array (
					'user'					=> $this->db->escape_str($nim),
					'ulevel'				=> '4',
					'tahun'					=> $this->db->escape_str($semesterAkademik),
					'KodeFakultas'			=> substr($this->db->escape_str($nim), 0,1),
					'KodeJurusan'			=> substr($this->db->escape_str($nim), 0,4),
					'status_user'			=> 'A',
					'form'					=> 'krsmhsw',
					'point_1'				=> 0,
					'point_1_keterangan'	=> 'semester akademik',
					'point_2'				=> 0,
					'point_2_keterangan'	=> 'biodata',
					'point_3'				=> 0,
					'point_3_keterangan'	=> 'hutang',
					'point_4'				=> 0,
					'point_4_keterangan'	=> 'cuti',
					'point_5'				=> 0,
					'point_5_keterangan'	=> 'nama ibu dan tanggal lahir',
					'point_6'				=> 0,
					'point_6_keterangan'	=> 'mahasiswa aktif',
					'point_7'				=> 0,
					'point_7_keterangan'	=> 'periode aktif',
					'point_8'				=> 0,
					'point_8_keterangan'	=> 'mahasiswa pdpt',
					'point_9'				=> 0,
					'point_9_keterangan'	=> 'abaikan pdpt',

				);

		return $this->db->insert('_v2_rule_siakad', $data);
	}

	public function updateRuleSemester($nim,$semesterAkademik) {

		$this->db->query("UPDATE _v2_rule_siakad SET point_1 = '1' WHERE user = '$nim' and tahun='$semesterAkademik' and form='krsmhsw'");

	}

	public function updateRuleBiodata($nim,$semesterAkademik) {

		$this->db->query("UPDATE _v2_rule_siakad SET point_2 = '1' WHERE user = '$nim' and tahun='$semesterAkademik' and form='krsmhsw'");

	}

	public function updateRuleHutang($nim,$semesterAkademik) {

		$this->db->query("UPDATE _v2_rule_siakad SET point_3 = '1' WHERE user = '$nim' and tahun='$semesterAkademik' and form='krsmhsw'");

	}

	public function updateRuleCuti($nim,$semesterAkademik) {

		$this->db->query("UPDATE _v2_rule_siakad SET point_4 = '1' WHERE user = '$nim' and tahun='$semesterAkademik' and form='krsmhsw'");

	}

	public function updateRuleBiodataIbu($nim,$semesterAkademik) {

		$this->db->query("UPDATE _v2_rule_siakad SET point_5 = '1' WHERE user = '$nim' and tahun='$semesterAkademik' and form='krsmhsw'");

	}

	public function updateRuleMahasiswaAktif($nim,$semesterAkademik) {

		$this->db->query("UPDATE _v2_rule_siakad SET point_6 = '1' WHERE user = '$nim' and tahun='$semesterAkademik' and form='krsmhsw'");

	}

	public function updateRulePeriodeAktif($nim,$semesterAkademik) {

		$this->db->query("UPDATE _v2_rule_siakad SET point_7 = '1' WHERE user = '$nim' and tahun='$semesterAkademik' and form='krsmhsw'");

	}

	public function updateRuleMahasiswaPdpt($nim,$semesterAkademik) {

		$this->db->query("UPDATE _v2_rule_siakad SET point_8 = '1' WHERE user = '$nim' and tahun='$semesterAkademik' and form='krsmhsw'");

	}

	public function updateRuleAbaikanDikti($nim,$semesterAkademik) {

		$this->db->query("UPDATE _v2_rule_siakad SET point_9 = '1' WHERE user = '$nim' and tahun='$semesterAkademik' and form='krsmhsw'");

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

	/*public function getVal($nim,$semesterAkademik) {
		$nim=$this->db->escape_str($nim);
		$semesterAkademik=intval($semesterAkademik);

		$query = $this->db->query("SELECT st_val,tgl_val FROM _v2_khs WHERE NIM = '$nim' and Tahun='$semesterAkademik' limit 1");

		if($query->num_rows() == 0)
		{
			return false;
		}else{
			return $query->row();
		}
	}*/

	public function getDataKrs($tbl,$nim,$semesterAkademik) {
		$tbl=$this->db->escape_str($tbl);
		$nim=$this->db->escape_str($nim);
		$semesterAkademik=intval($semesterAkademik);
		if($semesterAkademik>='20191') {
			$query = $this->db->query("SELECT k.ID, k.KodeMK, k.SKS, k.NamaMK as MK, k.Hadir, k.Tanggal, k.Program, concat(d.Name, ', ', d.Gelar) as Dosen, h.Nama as HR, TIME_FORMAT(jd.JamMulai, '%H:%i') as jm, TIME_FORMAT(jd.JamSelesai, '%H:%i') as js, jd.Hari, jd.KodeRuang, jd.Keterangan, pr.Nama_Indonesia as PRG, k.st_wali FROM ".$tbl." k left outer join _v2_mata_kuliah mk on k.IDMK=mk.IDMK left outer join _v2_dosen d on k.IDDosen=d.nip left outer join _v2_jadwal jd on k.IDJadwal=jd.IDJADWAL left outer join _v2_hari h on jd.Hari=h.ID left outer join _v2_program pr on jd.Program=pr.Kode WHERE k.NIM = '$nim' and k.Tahun = '$semesterAkademik' group by k.ID order by jd.Hari,k.Program,h.Nama,jd.JamMulai");
		}else{
			$query = $this->db->query("SELECT k.ID, k.KodeMK, k.SKS, k.NamaMK as MK, k.Hadir, k.Tanggal, k.Program, concat(d.Name, ', ', d.Gelar) as Dosen, h.Nama as HR, TIME_FORMAT(jd.JamMulai, '%H:%i') as jm, TIME_FORMAT(jd.JamSelesai, '%H:%i') as js, jd.Hari, jd.KodeRuang, jd.Keterangan, pr.Nama_Indonesia as PRG FROM ".$tbl." k left outer join _v2_mata_kuliah mk on k.IDMK=mk.IDMK left outer join _v2_dosen d on k.IDDosen=d.nip left outer join _v2_jadwal jd on k.IDJadwal=jd.IDJADWAL left outer join _v2_hari h on jd.Hari=h.ID left outer join _v2_program pr on jd.Program=pr.Kode WHERE k.NIM = '$nim' and k.Tahun = '$semesterAkademik' group by k.ID order by jd.Hari,k.Program,h.Nama,jd.JamMulai");			
		}


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

	public function daftarKrs1($nim,$data) {
		$nim=$this->db->escape_str($nim);
		$name=$this->db->escape_str($data['name']);
		$semesterAkademik=intval($data['semesterAkademik']);
		$kdj=$this->db->escape_str($data['kdj']);
		$kdp=$this->db->escape_str($data['kdp']);
		$lev=$this->db->escape_str($data['lev']);
		$nims=substr($nim,0,6);
		$nimx=substr($nim,6,3);
		$nimf=substr($nim,0,1);

		if($kdp=="NONREG" OR $kdp=="RESO"){
			$qkdp="AND j.Program like '%RESO%' OR j.Program like '%NONREG%'";
		}else{
			$qkdp="AND j.Program like '%REG%'";
		}

		$condition = "(j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' $qkdp order by j.Program, j.Hari, j.JamMulai";

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

				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and j.Keterangan='$kelas' and mk.Sesi=1 $qkdp group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai";
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

				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and j.Keterangan='$kelas' and mk.Sesi=1 $qkdp group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai";
			}else if($nims == "D10115" && $kdp=="RESO"){
				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and mk.Sesi<=5 $qkdp group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai";
			}else if($nims == "D10114" && $kdp=="RESO"){
				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and mk.Sesi<=7 $qkdp group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai";
			}
			else if($nims == "D10116" && $kdp=="RESO"){
				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and mk.Sesi<=3 $qkdp group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai";
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

       			$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and (j.Keterangan='$kelas' or mk.Wajib='N' or j.KodeMK='DK13048') and mk.Sesi<=7 $qkdp group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai  ";

				if($nimx >= 60 && $nimx <= 71){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 $qkdp union  select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js,	h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='A' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or  j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='B' and  (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 $qkdp";
						//group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai
				}else  if($nimx >= 135 && $nimx <= 163){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='B' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or  j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='C' and  (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 $qkdp";
        		}else if($nimx >= 222 && $nimx <= 247){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 $qkdp union  select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='C' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='D' and  (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 $qkdp";
				}else if($nimx >= 286 && $nimx <= 332){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='D' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or  j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='E' and  (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 $qkdp";
				}else if($nimx >= 380 && $nimx <= 448){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='E' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or  j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='F' and  (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 $qkdp";
				}else if($nimx >= 484 && $nimx <= 567){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='F' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or  j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='G' and (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 $qkdp";
				}else if($nimx >= 588){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='G' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or  j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='H' and  (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 $qkdp";
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

				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and (j.Keterangan='$kelas' or mk.Wajib='N') and mk.Sesi<=5 $qkdp group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai";

				if($nimx >= 59 && $nimx <= 76){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='A' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='B' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 $qkdp";
				}else if($nimx >= 112 && $nimx <= 137){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='B' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='C' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 $qkdp";
				}else if($nimx >= 200 && $nimx <= 259){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='C' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='D' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 $qkdp";
				}else if($nimx >= 263 && $nimx <= 361){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='D' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='E' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 $qkdp";
				}else if($nimx >= 362 && $nimx <= 426){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='E' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='F' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 $qkdp";
				}else if($nimx >= 427 && $nimx <= 472){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='E' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='G' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 $qkdp";
				}else if($nimx >= 478 && $nimx <= 519){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='F' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='G' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 $qkdp";
				}else if($nimx >= 520 ){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='F' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='H' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 $qkdp";
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
				and j.NotActive='N' and j.Keterangan='$kelas' and mk.Sesi<=3 $qkdp group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai ";

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

				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and j.Keterangan='$kelas' and mk.Sesi<=1 $qkdp group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai ";
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

		$query ="SELECT j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK, j.KodeRuang as kr, j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG, mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs20161 k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where ".$condition;

		return $query;
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

		if($kdp=="NONREG" OR $kdp=="RESO"){
			$qkdp="AND (j.Program like '%RESO%' OR j.Program like '%NONREG%')";
		}else{
			$qkdp="AND j.Program like 'REG'";
		}

		$condition = "(j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' $qkdp order by j.Program, j.Hari, j.JamMulai";

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

				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and j.Keterangan='$kelas' and mk.Sesi=1 $qkdp group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai";
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

				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and j.Keterangan='$kelas' and mk.Sesi=1 $qkdp group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai";
			}else if($nims == "D10115" && $kdp=="RESO"){
				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and mk.Sesi<=5 $qkdp group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai";
			}else if($nims == "D10114" && $kdp=="RESO"){
				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and mk.Sesi<=7 $qkdp group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai";
			}
			else if($nims == "D10116" && $kdp=="RESO"){
				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and mk.Sesi<=3 $qkdp group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai";
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

       			$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and (j.Keterangan='$kelas' or mk.Wajib='N' or j.KodeMK='DK13048') and mk.Sesi<=7 $qkdp group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai  ";

				if($nimx >= 60 && $nimx <= 71){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 $qkdp union  select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js,	h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='A' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or  j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='B' and  (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 $qkdp";
						//group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai
				}else  if($nimx >= 135 && $nimx <= 163){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='B' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or  j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='C' and  (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 $qkdp";
        		}else if($nimx >= 222 && $nimx <= 247){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 $qkdp union  select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='C' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='D' and  (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 $qkdp";
				}else if($nimx >= 286 && $nimx <= 332){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='D' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or  j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='E' and  (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 $qkdp";
				}else if($nimx >= 380 && $nimx <= 448){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='E' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or  j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='F' and  (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 $qkdp";
				}else if($nimx >= 484 && $nimx <= 567){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='F' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or  j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='G' and (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 $qkdp";
				}else if($nimx >= 588){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and  j.KodeMK!='DK13019' and  j.KodeMK!='DK13017' and  j.KodeMK!='DK13032' and  j.KodeMK!='DK13020' and  j.KodeMK!='DK13018' and  j.KodeMK!='DK13025' and  j.KodeMK!='DK13047') and mk.Sesi<=7 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='G' and  (j.KodeMK='DK13019' or  j.KodeMK='DK13017' or  j.KodeMK='DK13032' or  j.KodeMK='DK13020')) or (j.Keterangan='H' and  (j.KodeMK='DK13018' or  j.KodeMK='DK13025' or  j.KodeMK='DK13047'))) and mk.Sesi<=7 $qkdp";
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

				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and (j.Keterangan='$kelas' or mk.Wajib='N') and mk.Sesi<=5 $qkdp group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai";

				if($nimx >= 59 && $nimx <= 76){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='A' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='B' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 $qkdp";
				}else if($nimx >= 112 && $nimx <= 137){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='B' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='C' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 $qkdp";
				}else if($nimx >= 200 && $nimx <= 259){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='C' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='D' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 $qkdp";
				}else if($nimx >= 263 && $nimx <= 361){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='D' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='E' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 $qkdp";
				}else if($nimx >= 362 && $nimx <= 426){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='E' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='F' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 $qkdp";
				}else if($nimx >= 427 && $nimx <= 472){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='E' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='G' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 $qkdp";
				}else if($nimx >= 478 && $nimx <= 519){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='F' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='G' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 $qkdp";
				}else if($nimx >= 520 ){
					$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan = 'A' or j.Keterangan = 'B' or j.Keterangan = 'C' or j.Keterangan = 'D'  or j.Keterangan = 'E' ) and j.KodeMK!='DK13031' and j.KodeMK!='DK13030' and j.KodeMK!='DK13035' and j.KodeMK!='DK13034' and j.KodeMK!='DK13041' and j.KodeMK!='DK13042' and j.KodeMK!='DK13043' and j.KodeMK!='DK13044' and j.KodeMK!='DK13045' and j.KodeMK!='DK13046' ) and mk.Sesi<=5 $qkdp union select j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK,j.KodeRuang as kr,j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG,mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode where k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and ((j.Keterangan='F' and (j.KodeMK='DK13031' or j.KodeMK='DK13030' )) or (j.Keterangan='H' and (j.KodeMK='DK13035' or j.KodeMK='DK13034' or j.KodeMK='DK13041' or j.KodeMK='DK13042' or j.KodeMK='DK13043' or j.KodeMK='DK13044' or j.KodeMK='DK13045' or j.KodeMK='DK13046' ))) and mk.Sesi<=5 $qkdp";
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
				and j.NotActive='N' and j.Keterangan='$kelas' and mk.Sesi<=3 $qkdp group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai ";

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

				$condition = "k.ID is null and (j.KodeJurusan='$kdj') and j.Tahun='$semesterAkademik' and j.NotActive='N' and j.Keterangan='$kelas' and mk.Sesi<=1 $qkdp group by j.IDJADWAL order by j.Program, j.Hari, j.JamMulai ";
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

		$query = $this->db->query("SELECT j.Program, j.IDJADWAL, j.SKS, mk.Kode as KodeMK, j.KodeRuang as kr, j.Keterangan as kt, mk.Nama_Indonesia as MataKuliah, j.NamaMK AS MataKuliahJadwal, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js, h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG, mk.Sesi from _v2_jadwal j left outer join _v2_matakuliah mk on j.IDMK=mk.IDMK left outer join _v2_hari h on j.Hari=h.ID left outer join _v2_dosen d on j.IDDosen=d.nip left join _v2_krs20161 k on k.IDJadwal=j.IDJADWAL and k.NIM='$nim' left outer join _v2_program pr on j.Program=pr.Kode LEFT JOIN _v2_kurikulum ku On ku.IdKurikulum=mk.KurikulumID where ku.KodeJurusan='$kdj' ANd ".$condition);

		return $query->result();
	}

	public function getMataKuliah($KodeMK,$kdj) {
		$KodeMK=$this->db->escape_str($KodeMK);
		$kdj=$this->db->escape_str($kdj);

		$query = $this->db->query("SELECT Nama_Indonesia FROM _v2_matakuliah WHERE Kode='".$KodeMK."' and KodeJurusan='".$kdj."' limit 1");

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

	public function getSesiJurusan($kdj){
		$kdj=$this->db->escape_str($kdj);

		$query = $this->db->query("SELECT Sesi FROM _v2_jurusan WHERE Kode='".$kdj."'");

		if($query->num_rows() == 0)
	    {
	        return false;
	    }
	    else
	    {
			return $query->row();
	    }
	}

	public function statusKRS($nim){
		$nim=$this->db->escape_str($nim);

		$query = $this->db->query("UPDATE _v2_mhsw set StatusKRS='1' where NIM='$nim'");

		if($query){
			return true;
		}else{
			return false;
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

	public function getIps($nim,$semesterAkademik) {
		$nim=$this->db->escape_str($nim);
		$tahun=intval($semesterAkademik);
		$query = $this->db->query("SELECT IPS FROM _v2_khs where NIM='$nim' and Tahun='$tahun'");

		if($query){
			return $query->row();
		}else{
			return 0;
		}
	}

	public function getCekKhs($nim,$semesterAkademik) {
		$nim=$this->db->escape_str($nim);
		$thn=intval($semesterAkademik);
		$query = $this->db->query("SELECT k.NIM, k.Tahun, k.Sesi, m.KodeFakultas, m.KodeJurusan, m.KodeProgram, m.TahunAkademik, k.SKS, k.IPS, k.IPK, k.TotalSKS, k.Status, k.stprc, m.Name, m.id_reg_pd, k.SKSLulus, k.TotalSKSLulus from _v2_khs k, _v2_mhsw m where k.NIM=m.NIM and k.NIM='$nim' and k.Tahun='$thn' limit 1");

		return $query->row();
	}

	public function save_khs_db($data) {
		$SKS=$this->db->escape_str($data['SKS']);
		$SKSLulus=$this->db->escape_str($data['SKSLulus']);
		$IPS=$this->db->escape_str($data['IPS']);
		$TotalSKS=$this->db->escape_str($data['TotalSKS']);
		$TotalSKSLulus=$this->db->escape_str($data['TotalSKSLulus']);
		$IPK=$this->db->escape_str($data['IPK']);
		$nim=$this->db->escape_str($data['nim']);
		$tahun=$this->db->escape_str($data['tahun']);

		$query = $this->db->query("UPDATE _v2_khs set SKS='$SKS', SKSLulus='$SKSLulus', IPS='$IPS', TotalSKS='$TotalSKS', TotalSKSLulus='$TotalSKSLulus', IPK='$IPK' where NIM='$nim' and Tahun='$tahun'");

		if($query){
			return true;
		}else{
			return false;
		}
	}

	public function abaikan_khs($nim,$tahun) {
		$nim=$this->db->escape_str($nim);
		$tahun=$this->db->escape_str($tahun);

		$query = $this->db->query("UPDATE _v2_khs set st_abaikan='1' where NIM='$nim' and Tahun='$tahun'");

		if($query){
			return true;
		}else{
			return false;
		}
	}


	public function abaikan_krs($id, $tahun, $tbl, $unip) {
		$id=$this->db->escape_str($id);
		$tbl=$this->db->escape_str($tbl);

		$query = $this->db->query("UPDATE $tbl set st_abaikan='1', user_abaikan='$unip' where ID='$id'");

		if($query){
			return true;
		}else{
			return false;
		}
	}

	public function getKrsPrcIps($tbl, $nim, $thn) {
		$nim=$this->db->escape_str($nim);
		$tbl=$this->db->escape_str($tbl);
		$thn=intval($thn);
		$query = $this->db->query("SELECT * from ".$tbl." where NIM='$nim' and tahun='$thn' order by KodeMK");

	    return $query->result();
	}

	public function getSksMaxPrcIps($IPS, $nim) {
		$nim=$this->db->escape_str($nim);
		$IPS=$this->db->escape_str($IPS);
		$query = $this->db->query("SELECT SKSMax from _v2_mhsw m,_v2_max_sks mx where m.KodeJurusan=mx.KodeJurusan and IPSMin <= $IPS and IPSmax >= $IPS  and mx.NotActive='N' and m.nim='$nim' limit 1");

		return $query->row();
	}

	public function prcips($data){
		$SKS=$this->db->escape_str($data['SKS']);
		$SKSLulus=$this->db->escape_str($data['SKSLulus']);
		$IPS=$this->db->escape_str($data['IPS']);
		$MaxSKS2=$this->db->escape_str($data['MaxSKS2']);
		$nim=$this->db->escape_str($data['nim']);
		$tahun=$this->db->escape_str($data['tahun']);

		$query = $this->db->query("UPDATE _v2_khs set stprc='1',IPS='$IPS',SKSLulus='$SKSLulus', SKS='$SKS', MaxSKS2='$MaxSKS2' where NIM='$nim' and Tahun='$tahun'");

		if($query){
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

	public function getKhsPeriode($nim) {
		$nim=$this->db->escape_str($nim);
		$query = $this->db->query("SELECT Tahun FROM _v2_khs where NIM='$nim' order by Tahun");

		return $query->result();
	}

	public function getKrsFak($kdf,$nim, $thn, $tabel) {
		$nim = $this->db->escape_str($nim);
		$kdf = $this->db->escape_str($kdf);
		$thn = intval($thn);

		$query = $this->db->query("SELECT Min(GradeNilai) as GdNilai,SKS as nSks,Max(Bobot) as bbt from ".$tabel." where NIM='$nim' and Tahun<='$thn' and GradeNilai!='K' and NotActive='N' group by NamaMK");

        return $query->result();
	}

	public function getKrsFakSama($kdf,$nim, $thn, $tabel) {
		$nim = $this->db->escape_str($nim);
		$kdf = $this->db->escape_str($kdf);
		$thn = intval($thn);

		$query = $this->db->query("SELECT GradeNilai as GdNilai,SKS as nSks,Bobot as bbt from ".$tabel." where NIM='$nim' and Tahun<='$thn' and NotActive='N' group by NamaMK");

        return $query->result();
	}

	public function updateKhsIPK($data) {
		$NIM = $data['NIM'];
		$Tahun = $data['Tahun'];
		$IPK = $data['IPK'];
		$TotalSKS = $data['TotalSKS'];
		$TotalSKSLulus = $data['TotalSKSLulus'];

		$update =	$this->db->query("UPDATE _v2_khs k,_v2_mhsw m set stprc='2', k.IPK='$IPK',k.TotalSKS='$TotalSKS',k.TotalSKSLulus='$TotalSKSLulus',m.IPK='$IPK',m.TotalSKS='$TotalSKS',m.TotalSKSLulus='$TotalSKSLulus' where k.NIM=m.NIM and k.NIM='$NIM' and Tahun='$Tahun'");
		if($update){
			return true;
		}else{
			return false;
		}
	}

	public function getDataKhsFeeder($nim, $tahun) {
		$nim = $this->db->escape_str($nim);
		$tahun = $this->db->escape_str($tahun);

		$query = $this->db->query("SELECT k.ID,k.Tahun,k.NIM,m.Name,m.id_reg_pd,k.Status,k.st_feeder,k.IPS,k.SKS,k.IPK,k.TotalSKS from _v2_khs k,_v2_mhsw m where k.NIM=m.NIM and k.NIM='$nim' and k.Tahun='$tahun' limit 1");

		return $query->row();
	}

	public function updateKhsFeeder($ID) {
		$ID = $this->db->escape_str($ID);
		$update =	$this->db->query("UPDATE _v2_khs SET st_feeder='1' WHERE ID='$ID'");
		if($update){
			return true;
		}else{
			return false;
		}
	}

	public function updateIPKMhsw($nim,$TotIPK) {
		$nim = $this->db->escape_str($nim);
		$ipk = $this->db->escape_str($TotIPK);
		$update =	$this->db->query("UPDATE _v2_mhsw SET IPK='$ipk' WHERE NIM='$nim'");
		if($update){
			return true;
		}else{
			return false;
		}
	}

	public function getCekKrs($nim,$thn,$tbl) {
		$nim = $this->db->escape_str($nim);
		$thn = intval($thn);

		$query = $this->db->query("SELECT k.*, k.NamaMK as MK, k.Program,
		  concat(d.Name, ', ', d.Gelar) as Dosen, h.Nama as HR,
		  TIME_FORMAT(jd.JamMulai, '%H:%i') as jm, TIME_FORMAT(jd.JamSelesai, '%H:%i') as js,jd.Hari,jd.KodeRuang,jd.Keterangan, pr.Nama_Indonesia as PRG
		  from ".$tbl." k left outer join _v2_matakuliah mk on k.IDMK=mk.IDMK
		  left outer join _v2_dosen d on k.IDDosen=d.nip
		  left outer join _v2_jadwal jd on k.IDJadwal=jd.IDJADWAL
		  left outer join _v2_hari h on jd.Hari=h.ID
		  left outer join _v2_program pr on jd.Program=pr.Kode
		  where k.NIM='$nim' and k.Tahun='$thn' group by k.NamaMK,k.IDJADWAL order by jd.Hari,k.Program, h.Nama, jd.JamMulai");

        return $query->result();
	}

	public function get_krs_feeder($tbl, $ID_KRS) {
		$ID_KRS = $this->db->escape_str($ID_KRS);

		$query = $this->db->query("SELECT j.id_kelas_kuliah as id_kls,j.IDJADWAL,m.id_reg_pd,m.NIM,n.ID as IDKRS,n.KodeMK,n.Tahun,n.nilai as nilai_angka,n.GradeNilai as nilai_huruf,n.Bobot as nilai_indeks, m.KodeFakultas from _v2_jadwal j,_v2_mhsw m,$tbl n where j.IDJADWAL=n.IDJADWAL and n.ID='$ID_KRS' and n.NIM=m.NIM order by n.NIM");

        return $query->result();
	}

	public function create_encrypt($dataEncrypt,$IDKRS,$tbl) {
		$IDKRS = $this->db->escape_str($IDKRS);
		$update = $this->db->query("UPDATE $tbl set enkripsi='$dataEncrypt' where ID='$IDKRS'");
		if($update){
			return true;
		}else{
			return false;
		}
	}

	public function get_encrypt($IDKRS,$tbl) {
		$IDKRS = $this->db->escape_str($IDKRS);

		$query = $this->db->query("SELECT enkripsi from $tbl where ID='$IDKRS'");

        return $query->row();
	}

	public function updateKrsFeeder($IDKRS, $tbl, $st_feeder) {
		$IDKRS = $this->db->escape_str($IDKRS);
		$update =	$this->db->query("UPDATE ".$tbl." set st_feeder='$st_feeder' where ID='$IDKRS'");
		if($update){
			return true;
		}else{
			return false;
		}
	}

	public function getCekMhsw($nim) {
		$nim = $this->db->escape_str($nim);

		$query = $this->db->query("SELECT m.NIM, m.Name, m.Sex, m.TempatLahir, m.TglLahir, m.NIK, m.NamaIbu, m.NamaOT, m.AgamaID, a.Agama, m.Status,m.NIM from _v2_mhsw m,_v2_agama a where m.NIM='$nim' and m.AgamaID=a.AgamaID");

        return $query->row();
	}

	public function getAgama() {
		$query = $this->db->query("SELECT AgamaID, Agama from _v2_agama where NotActive='N'");

		return $query->result();
	}

	public function save_mhsw_db($data) {
		$NamaOT = $data['NamaOT'];
		$NamaIbu = $data['NamaIbu'];
		$jk = $data['jk'];
		$tempat = $data['tempat'];
		$tgl_lhr = $data['tgl_lhr'];

		$agama = $data['agama'];
		$NIK = $data['NIK'];
		$nimd = $data['nimd'];
		$update = $this->db->query("UPDATE _v2_mhsw set NamaOT='$NamaOT', NamaIbu='$NamaIbu', Sex='$jk', TempatLahir='$tempat', TglLahir='$tgl_lhr', AgamaID='$agama',NIK='$NIK' where NIM='$nimd'");
		if($update){
			return true;
		}else{
			return false;
		}
	}

	public function getMhswFeeder($NIM) {
		$NIM = $this->db->escape_str($NIM);

		$query = $this->db->query("SELECT m.*,p.id_sms from _v2_mhsw m,_v2_jurusan p where m.KodeJurusan=p.Kode and m.NIM='$NIM'");

        return $query->row();
	}

	public function updateIdPd($id_pd, $nim) {
		$this->db->query("UPDATE _v2_mhsw set id_pd='$id_pd' where NIM='$nim'");
	}

	public function save_encrypt($NIM,$thn,$kode_mk,$encrypt,$tbl) {
		$this->db->query("UPDATE ".$tbl." set enkripsi_mhs='$encrypt' where NIM='$NIM' AND Tahun='$thn' AND KodeMK='$kode_mk'");
	}

	public function save_mhsw_reg_pd($data) {
		$id_reg_pd = $this->db->escape_str($data['id_reg_pd']);
		$st_feeder = $this->db->escape_str($data['st_feeder']);
		$nimd = $this->db->escape_str($data['nimd']);
		$update = $this->db->query("UPDATE _v2_mhsw set id_reg_pd='$id_reg_pd',st_feeder='$st_feeder' where NIM='$nimd'");
		if($update){
			return true;
		}else{
			return false;
		}
	}

	public function getIdPd($NIM) {
		$NIM = $this->db->escape_str($NIM);

		$query = $this->db->query("SELECT id_pd from _v2_mhsw where NIM='$NIM'");

        return $query->row();
	}

	public function sinkronspp($nim,$semesterAkademik) {
		$return['status']=FALSE;
		$return['data'] = [];
		$return['query'] = '';
		$prodi = $this->getProdiFakultas($nim)->KodeJurusan;
		$fakultas = $this->getProdiFakultas($nim)->KodeFakultas;
		/*
			$string = "SELECT t.kode_periode,p.id_record_pembayaran,dp.deskripsi,dp.nominal,t.id_record_tagihan, t.nomor_induk,t.nama,t.kode_fakultas,t.kode_prodi,t.nama_prodi,t.kode_periode,t.nama_periode,t.is_tagihan_aktif,t.waktu_berakhir,p.waktu_transaksi,dp.deskripsi,t.total_nilai_tagihan,t.angkatan FROM pembayaran AS p INNER JOIN detil_pembayaran AS dp ON p.id_record_pembayaran = dp.id_record_pembayaran INNER JOIN tagihan AS t ON t.id_record_tagihan = p.id_record_tagihan WHERE kode_periode = '$semesterAkademik' and ( dp.deskripsi like '%SPP%' or dp.deskripsi like '%UKT%' or dp.deskripsi like '%COA%' or dp.deskripsi like '%SP%' or dp.deskripsi like '%RMD%' or dp.deskripsi like '%REMEDIAL%' or dp.deskripsi like '%P3S%') and t.nomor_induk='$nim' order by p.waktu_transaksi ASC limit 1";
			$responseSpc_1 = $this->db1->query($string);
		*/
		$responseSpc = $this->getPaymentRecord($nim,$semesterAkademik);
		

		if ($responseSpc->num_rows() != 0){
			$res = $responseSpc->result();

			foreach ($res as $rows){
				$this->db->query("insert into _v2_spp2(tahun,nim,TotalBayar,id_record_tagihan,bayar,KodeFakultas,KodeJurusan,tgl,StatusMhs) values('".$rows->kode_periode."','".$rows->nomor_induk."','".$rows->nominal."','".$rows->id_record_tagihan."',1,'".$fakultas."','".$prodi."','".$rows->waktu_transaksi."','A')");
			}

			$qSemesterAkademikAktif= $this->getSemesterAkademikAktif();
			$semesterAkademikAktif = $qSemesterAkademikAktif->periode_aktif;

			if($semesterAkademikAktif == $semesterAkademik) {
				$this->db->query("UPDATE _v2_mhsw SET Status = 'A', StatusBayar = '1', TahunStatus = '$semesterAkademik'  WHERE NIM ='$nim'");
			}
			$return['status']=true;
		} else {
			$return['status']=false;
			$return['data']=$res;
			$return['query'] = $this->db1->last_query();
		}
		return $return;
	}

	public function getPaymentRecord($nim,$periode)
	{
		$this->db1->select("id_record_tagihan, key_val_2 as nomor_induk, key_val_5 as kode_periode, total_nilai_pembayaran as nominal,waktu_transaksi");
		$this->db1->where('key_val_2',$nim);
		$this->db1->where('key_val_5',$periode);
		$res = $this->db1->get('pembayaran');
		return $res;
	}
	public function getProdiFakultas($nim)
	{
		$this->db->select("KodeFakultas, KodeJurusan");
		$this->db->where('NIM', $nim);
		return $this->db->get('_v2_mhsw')->row();
	}

	public function sinkronspp1($nim,$semesterAkademik) {
		$string = "SELECT t.kode_periode,p.id_record_pembayaran,dp.deskripsi,dp.nominal,t.id_record_tagihan, t.nomor_induk,t.nama,t.kode_fakultas,t.kode_prodi,t.nama_prodi,t.kode_periode,t.nama_periode,t.is_tagihan_aktif,t.waktu_berakhir,p.waktu_transaksi,dp.deskripsi,t.total_nilai_tagihan,t.angkatan FROM pembayaran AS p INNER JOIN detil_pembayaran AS dp ON p.id_record_pembayaran = dp.id_record_pembayaran INNER JOIN tagihan AS t ON t.id_record_tagihan = p.id_record_tagihan WHERE kode_periode = '$semesterAkademik' and ( dp.deskripsi like '%SPP%' or dp.deskripsi like '%UKT%' or dp.deskripsi like '%COA%' or dp.deskripsi like '%SP%' or dp.deskripsi like '%REMEDIAL%' or dp.deskripsi like '%P3S%') and t.nomor_induk='$nim' order by p.waktu_transaksi ASC limit 1";
		echo $string;
		echo "<br>";
		if ($this->db1->query($string)->num_rows() != 0){
			$res = $this->db1->query($string)->result();
			foreach ($res as $rows){
				$this->db->query("insert into _v2_spp2(tahun,nim,TotalBayar,id_record_tagihan,bayar,KodeFakultas,KodeJurusan,tgl,StatusMhs) values('".$rows->kode_periode."','".$rows->nomor_induk."','".$rows->nominal."','".$rows->id_record_tagihan."',1,'".$rows->kode_fakultas."','".$rows->kode_prodi."','".$rows->waktu_transaksi."','A')");
			}
			$qSemesterAkademikAktif= $this->getSemesterAkademikAktif();
			$semesterAkademikAktif = $qSemesterAkademikAktif->periode_aktif;

			if($semesterAkademikAktif == $semesterAkademik) {
				/*$this->db->query("UPDATE _v2_mhsw SET Status = 'A', StatusBayar = '1', TahunStatus = '$semesterAkademik'  WHERE NIM ='$nim'");*/
				echo "UPDATE _v2_mhsw SET Status = 'A', StatusBayar = '1', TahunStatus = '$semesterAkademik'  WHERE NIM ='$nim'";
			}
			echo "true";
		} else {
			echo "false";
		}
	}

	public function showDataKrs($tabel) {
		$query = $this->db->query("SELECT NIM, IDJadwal, hr_1, hr_2, hr_3, hr_4, hr_5, hr_6, hr_7, hr_8, hr_9, hr_10, hr_11, hr_12, hr_13, hr_14, hr_15, hr_16 from $tabel");

        return $query->result();
	}

	public function updateHadir($nim, $idJadwal, $persentase, $tabel) {
		$update= $this->db->query("UPDATE $tabel SET Hadir= '$persentase'  WHERE NIM ='$nim' AND IDJadwal='$idJadwal'");
		if($update){
			return true;
		}else{
			return false;
		}
	}

	// code rocky

	public function pembayaran($nim, $tahun) {

		$query = $this->db->query("SELECT KodeFakultas, KodeJurusan, TotalBayar FROM _v2_spp2 WHERE nim= '$nim' AND tahun= '$tahun' AND `bayar` > 0 LIMIT 1");

		return $query->result();

	}

	public function tahun_akademik($nim) {

		$query = $this->db->query("SELECT Semester,KodeJurusan FROM _v2_mhsw WHERE nim= '$nim' AND StatusAwal= 'B' ");

		return $query->row();

	}

}
