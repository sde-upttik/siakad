<?php


/**
 * function 		: debug()
 * @author 			Mohamad Fadli
 * @param array 	$data (variable parse data)
**/
function debug($data)
{
	$CI =& get_instance();

	echo "<pre>";
	print_r($data);
	echo "</pre>";

	echo "<pre>";
	print_r($CI->db->last_query());
	echo "</pre>";
}


/**
 * function 		: call_view()
 * @author 			Mohamad Fadli
 * @param array 	$data (variable parse data to view)
 * @param string 	$page (name of Page to call)
 * @param bool 		$debug (for show data parse and last query)
 * @param bool 		$js (to call additional page js)
**/
function call_view($debug = False, $page="", $data="", $js=False)
{
	$CI =& get_instance();

	if($debug){
		debug($data);
	}
	else{
		$CI->load->view('temp/head');
		$CI->load->view($page, $data);
		$CI->load->view('temp/footers');
		if($js){
			$CI->load->view($page.'_js', $data);
		}
	}
}

function semester_aktif(){
	$CI =& get_instance();
	$CI->db->select();
	$semester_aktif = $CI->db->select('Kode,Nama')->group_by('Kode')->order_by('Kode', 'DESC')->limit(1)->get('_v2_tahun')->result_array();
	return  $semester_aktif[0]['Kode'];
}

function status($status)
{
	if($status == "A"){
		echo "Aktif";
	}
	elseif ($status == "L") {
		echo "Lulus";
	}
	elseif ($status == "C") {
		echo "Cuti";
	}
	elseif ($status == "U") {
		echo "Unregist";
	}
	elseif ($status == "DO") {
		echo "DropOut";
	}
	else{
		echo "Status tidak terdaftar";
	}
}




function encode($plaintext = "")
{
	$CI =& get_instance();
	return str_replace(array('+', '/', '='), array('-', '_', '~'), $plaintext);
}

function decode($chipertext = "")
{
	$CI =& get_instance();
	return str_replace(array('_', '~'), array('/', '='), $chipertext);
	// return str_replace(array('-', '_', '~'), array('+', '/', '='), $chipertext); // fikri hapus setelah berdebat dengan fandu
}

function limitKrs($kodeJurusan, $semester_aktif = "" )
{
	$CI =& get_instance();

	$where['KodeJurusan']	= $kodeJurusan;
	$where['Tahun']			= $semester_aktif;

	return $CI->db->select('krsm,krss,ukrsm,ukrss')->limit(1)->get_where('_v2_bataskrs',$where)->result_array();
}

function checkLimitKrs($kodeJurusan="")
{
	$limitKrs = limitKrs($kodeJurusan, semester_aktif());
	
	if(!empty($limitKrs)){
		if(strtotime($limitKrs[0]['krsm']) <= strtotime(date('Y-m-d')) && strtotime(date('Y-m-d')) <= strtotime($limitKrs[0]['krss'])){
			return true;
		}
		elseif(strtotime($limitKrs[0]['ukrsm']) >= strtotime(date('Y-m-d')) && strtotime(date('Y-m-d')) <= strtotime($limitKrs[0]['ukrss'])){
			return true;
		}
	}

	return false;
}

function getMajorCollege($nim)
{
	$CI =& get_instance();

	$where['NIM'] = $nim;
	return $CI->db->get_where('_v2_mhsw', $where)->row()->KodeJurusan;
}


?>