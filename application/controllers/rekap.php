<?php
if(! defined("BASEPATH")) exit("Akses langsung tidak diperkenankan");

class rekap extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Makassar");
	}
	
	//Mahasiswa rekap
	public function rekap(){
		// query untuk mengambil semua mahasiswa yang aktif
		// SELECT NIM, tahunstatus, count(tahunstatus), KodeFakultas, KodeJurusan  FROM `mhsw` WHERE `TahunAkademik` LIKE '2016' group by tahunstatus, KodeFakultas, KodeJurusan ORDER BY KodeFakultas, tahunstatus ASC
	
		// query lebih detail untuk mahasiswa masi tidak aktif dan belum lulus
		// SELECT NIM, Status, tahunstatus, count(tahunstatus), KodeFakultas, KodeJurusan  FROM `mhsw` WHERE `TahunAkademik` LIKE '2016' and Status not in ('A','L')  group by tahunstatus, KodeFakultas, KodeJurusan ORDER BY KodeFakultas, tahunstatus ASC
	}
}
?>