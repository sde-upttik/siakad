<?php /**
 * 
 */
class Daftar_cuti extends CI_Controller
{
	
	private $limit;

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->helper('security');
	    $this->load->model('mhsw_model');
	    $this->load->model('profil_model');
	}
	public function index()
	{

		$this->load->view('dashbord');

	}
} ?>