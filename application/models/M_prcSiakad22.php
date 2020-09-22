<?php
//session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class M_prcSiakad22 extends CI_Model {
	private $ulangtosiakad2="";

	public function getDataMhsw()
	{
		$this->ulangtosiakad2 = $this->load->database('ulangtosiakad2', TRUE);

		$where['lulus_pcmb.st_siakad'] = "0";
		$where['lulus_pcmb.st_bayar' ]  = "1";
		$where['lulus_pcmb.st_nim !='] = "0";

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
		$this->ulangtosiakad2->like('lulus_pcmb.st_nim', 'E');

		// $this->ulangtosiakad2->group_start();
		// $this->ulangtosiakad2->like('lulus_pcmb.st_nim', 'B');
		// $this->ulangtosiakad2->like('lulus_pcmb.st_nim', 'C');
		// $this->ulangtosiakad2->or_like('lulus_pcmb.st_nim', 'D');
		// $this->ulangtosiakad2->or_like('lulus_pcmb.st_nim', 'E');
		// $this->ulangtosiakad2->or_like('lulus_pcmb.st_nim', 'F');
		// $this->ulangtosiakad2->group_end();	

		// $this->ulangtosiakad2->group_by('lulus_pcmb.st_nim');
		$this->ulangtosiakad2->limit(500);
		// $this->ulangtosiakad2->limit(1);
		return $this->ulangtosiakad2->get()->result_array();
		 // $this->ulangtosiakad2->get()->result_array();
		// return $this->ulangtosiakad2->last_query();
	}	


	public function getDataMhsWhere($nim)
	{
		$this->ulangtosiakad2 = $this->load->database('ulangtosiakad2', TRUE);
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
		$this->ulangtosiakad2->where(array('st_nim',$nim));
		return $this->ulangtosiakad2->get()->result_array();

	}

	public function updateStSiakadInDaftarUlang($data)
	{
		$this->ulangtosiakad2 = $this->load->database('ulangtosiakad2', TRUE);

		$this->ulangtosiakad2->where('st_nim', $data['data']['stambuk']);
		$response = $this->ulangtosiakad2->update('lulus_pcmb', array('st_siakad' => '1'));
	}

	public function getDataBayar($noujian)
	{
		$this->ulangtosiakad2 = $this->load->database('ulangtosiakad2', TRUE);

		$where['noujian'] = $noujian;
		return $this->ulangtosiakad2->get_where('bayar',$where)->result_array();
	}

	public function getKodeFakultas($kodeJurusan)
	{
		$where['Kode'] = $kodeJurusan;
		$this->db->select('KodeFakultas');
		return $this->db->get_where('_v2_jurusan',$where)->result_array();

	}
}