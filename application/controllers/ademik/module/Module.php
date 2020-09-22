<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Module extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('encryption');
	}

	public function index(){
	//echo "b";
	//	$this->load->view('temp/head',$a);
	//	$this->load->view('temp/head');
	//	$this->load->view($content);
	//	$this->load->view('temp/footers');
		$a['tab'] = $this->app->all_val('groupmodul')->result();
	//	$a['tab'] = $this->app->select_all_val('modul','')->result();
		$this->load->view('dashbord',$a);
	}
	
	 public function en_des()
    {
        $string = "Fandu Coba";
        $encript =  $this->encryption->encrypt($string);
        $decript = $this->encryption->decrypt($encript);
 
        echo $encript."<br>";
        echo $decript;
    }

	public function addgroup(){
		$gropmod = $this->input->post('gropmod');
		if ($this->input->post('NotActive') == 'on') $on = 'N';
		else $on = 'Y';
		$string = "";
		$values = $this->input->post('multi_array');
		foreach ($values as $a){
			$string .= $a."-";
		}
		$string = "-".$string;
		$this->db->query("Insert into groupmodul (GroupModulID,GroupModul,Level,NotActive) values ('','$gropmod','$string','$on')");
		redirect(base_url($this->session->userdata('sess_tamplate')));
	}
	
	public function addmodul(){
		//if(isset($this->input->post('addmodul_btn'))){
		$groupmodulid = $this->input->post('groupmodulid');
		$modul = $this->input->post('modul');
		$modullink = $this->input->post('modullink');
		$modulimg = $this->input->post('modulimg');
		$moduldesc = $this->input->post('moduldesc');
		$modulaut = $this->input->post('modulaut');		
		
		if ($this->input->post('modulnot') == 'on') $on = 'N';
		else $on = 'Y';
		
		if ($this->input->post('modulajax') == 'on') $on_ajax = 'Y';
		else $on_ajax = 'N';
		
		$string = "";
		$values = $this->input->post('modullev');
		foreach ($values as $a){
			$string .= $a."-";
		}
		$string = "-".$string;
		$this->db->query("INSERT INTO  `modul` (ModulID,GroupModul,Modul,Author,EmailAuthor,Description,Link,ImgLink,NotActive,Level,ajx) VALUES ('',  '$groupmodulid',  '$modul',  '$modulaut',  '$modulaut',  '$moduldesc',  '$modullink',  '',  '$on',  '$string',  '$on_ajax')");
		//}
		redirect(base_url($this->session->userdata('sess_tamplate')));
	}
	
	public function detail(){
		$id = $this->input->post('id');
		$query = $this->app->one_val('modul','GroupModul',$id)->result();
		$string = "";
		foreach ($query as $s) {
			/*$result[] = array(
				'Modul' => $s->Modul,
				'Description' => $s->Description,
			);*/
			$string .= "<tr><td>".$s->Modul."</td>
						<td>".$s->Link."</td>
						<td>".$s->Level."</td>
						<td>".$s->NotActive."</td></tr>";
		}
		//echo json_encode($result);
		
		echo $string;
	}
	
}