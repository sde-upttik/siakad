<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class useraccess extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	    $this->load->library('encryption');
	    $this->load->library('datatables');
	    $this->load->model('user_model');
		date_default_timezone_set("Asia/Makassar");
	}

	public function index(){
		//echo "fandu 12344 fandu ini<br>";
		//echo $this->uri->segment(4);
	// cara pertama
		//	$content = $this->session->userdata('sess_tamplate');
		//	$this->load->view('temp/head');
		//	$this->load->view($content);
		//	$this->load->view('temp/footers');
	
	// cara kedua
		$a['tab'] = $this->app->all_val('groupmodul')->result();
		$this->load->view('dashbord',$a);
		
	// cara ke tiga
		//$this->load->view('dashbord');
	}

	public function adminpage(){
		$data['footerSection'] = "<script type='text/javascript'>
 
            var save_method; //for save method string
            var table;
 
            $(document).ready(function() {
                //datatables
                table = $('#table_admin').DataTable({ 
                    'processing': true, //Feature control the processing indicator.
                    'serverSide': true, //Feature control DataTables' server-side processing mode. 
                    'order': [], //Initial no order.
                    // Load data for the table's content from an Ajax source
                    'sAjaxSource': '".base_url('ademik/useraccess/dataadmin')."',
            		//Set column definition initialisation properties.
		            'oLanguage': {
		                'sProcessing': '<img src=\"".base_url('assets/images/tenor.gif')."\" />'
		            },
                    'fnServerData': function (sSource, aoData, fnCallback) {
		                $.ajax
		                ({
		                    'dataType': 'json',
		                    'type': 'POST',
		                    'url': sSource,
		                    'data': aoData,
		                    'success': fnCallback
		                });
		            },
		            'fnDrawCallback': function (oSettings) {
						$('.hapus').on('click',function(e){
			                var currentBtn = $(this);

			                uri = currentBtn.attr('data-uri');
			                login = currentBtn.attr('data-login');
			                
			                swal({   
			                    title: 'Yakin data ingin dihapus?',   
			                    text: 'Data tidak dapat dikembalikan lagi',   
			                    type: 'warning',   
			                    showCancelButton: true,   
			                    confirmButtonColor: '#fcb03b',   
			                    confirmButtonText: 'Iya',   
			                    cancelButtonText: 'Tidak',   
			                    closeOnConfirm: false,   
			                    closeOnCancel: false 
			                }, function(isConfirm){   
			                    if (isConfirm) {     
			                         $.ajax({
			                            type: 'POST',
			                            data : 'login='+login,
			                            url: uri,
			                            success: function(data){
											window.location.reload(false); 
			                            }
			                        });
			                           
			                    } else {     
			                        swal('Batal', 'Data tidak jadi dihapus', 'error');   
			                    } 
			                });
			                return false;
			            });
					} 
                });            
 
            });
        </script>"; 
            
		$content = "ademik/useraccess/admin";
		$this->load->view('temp/head');
		$this->load->view('ademik/useraccess/admin');
		$this->load->view('temp/footers',$data);
	}

	public function adminpusat(){
		$data['footerSection'] = "<script type='text/javascript'>
 
            var save_method; //for save method string
            var table;
 
            $(document).ready(function() {
                //datatables
                table = $('#table_admin').DataTable({ 
                    'processing': true, //Feature control the processing indicator.
                    'serverSide': true, //Feature control DataTables' server-side processing mode. 
                    'order': [], //Initial no order.
                    // Load data for the table's content from an Ajax source
                    'sAjaxSource': '".base_url('ademik/useraccess/dataadminpusat')."',
            		//Set column definition initialisation properties.
		            'oLanguage': {
		                'sProcessing': '<img src=\"".base_url('assets/images/tenor.gif')."\" />'
		            },
                    'fnServerData': function (sSource, aoData, fnCallback) {
		                $.ajax
		                ({
		                    'dataType': 'json',
		                    'type': 'POST',
		                    'url': sSource,
		                    'data': aoData,
		                    'success': fnCallback
		                });
		            },
		            'fnDrawCallback': function (oSettings) {
						$('.hapus').on('click',function(e){
			                var currentBtn = $(this);

			                uri = currentBtn.attr('data-uri');
			                login = currentBtn.attr('data-login');
			                
			                swal({   
			                    title: 'Yakin data ingin dihapus?',   
			                    text: 'Data tidak dapat dikembalikan lagi',   
			                    type: 'warning',   
			                    showCancelButton: true,   
			                    confirmButtonColor: '#fcb03b',   
			                    confirmButtonText: 'Iya',   
			                    cancelButtonText: 'Tidak',   
			                    closeOnConfirm: false,   
			                    closeOnCancel: false 
			                }, function(isConfirm){   
			                    if (isConfirm) {     
			                         $.ajax({
			                            type: 'POST',
			                            data : 'login='+login,
			                            url: uri,
			                            success: function(data){
											window.location.reload(false); 
			                            }
			                        });
			                           
			                    } else {     
			                        swal('Batal', 'Data tidak jadi dihapus', 'error');   
			                    } 
			                });
			                return false;
			            });
					} 
                });            
 
            });
        </script>"; 
            
		$this->load->view('temp/head');
		$this->load->view('ademik/useraccess/adminpusat');
		$this->load->view('temp/footers',$data);
	}

	public function adminfak(){
		$data['footerSection'] = "<script type='text/javascript'>
 
            var save_method; //for save method string
            var table;
 
            $(document).ready(function() {
                //datatables
                table = $('#table_admin').DataTable({ 
                    'processing': true, //Feature control the processing indicator.
                    'serverSide': true, //Feature control DataTables' server-side processing mode. 
                    'order': [], //Initial no order.
                    // Load data for the table's content from an Ajax source
                    'sAjaxSource': '".base_url('ademik/useraccess/dataadminfak')."',
            		//Set column definition initialisation properties.
		            'oLanguage': {
		                'sProcessing': '<img src=\"".base_url('assets/images/tenor.gif')."\" />'
		            },
                    'fnServerData': function (sSource, aoData, fnCallback) {
		                $.ajax
		                ({
		                    'dataType': 'json',
		                    'type': 'POST',
		                    'url': sSource,
		                    'data': aoData,
		                    'success': fnCallback
		                });
		            },
		            'fnDrawCallback': function (oSettings) {
						$('.hapus').on('click',function(e){
			                var currentBtn = $(this);

			                uri = currentBtn.attr('data-uri');
			                login = currentBtn.attr('data-login');
			                
			                swal({   
			                    title: 'Yakin data ingin dihapus?',   
			                    text: 'Data tidak dapat dikembalikan lagi',   
			                    type: 'warning',   
			                    showCancelButton: true,   
			                    confirmButtonColor: '#fcb03b',   
			                    confirmButtonText: 'Iya',   
			                    cancelButtonText: 'Tidak',   
			                    closeOnConfirm: false,   
			                    closeOnCancel: false 
			                }, function(isConfirm){   
			                    if (isConfirm) {     
			                         $.ajax({
			                            type: 'POST',
			                            data : 'login='+login,
			                            url: uri,
			                            success: function(data){
											window.location.reload(false); 
			                            }
			                        });
			                           
			                    } else {     
			                        swal('Batal', 'Data tidak jadi dihapus', 'error');   
			                    } 
			                });
			                return false;
			            });
					} 
                });            
 
            });
        </script>"; 
            
		$this->load->view('temp/head');
		$this->load->view('ademik/useraccess/adminfak');
		$this->load->view('temp/footers',$data);
	}

	public function adminjur(){
		$data['footerSection'] = "<script type='text/javascript'>
 
            var save_method; //for save method string
            var table;
 
            $(document).ready(function() {
                //datatables
                table = $('#table_admin').DataTable({ 
                    'processing': true, //Feature control the processing indicator.
                    'serverSide': true, //Feature control DataTables' server-side processing mode. 
                    'order': [], //Initial no order.
                    // Load data for the table's content from an Ajax source
                    'sAjaxSource': '".base_url('ademik/useraccess/dataadminjur')."',
            		//Set column definition initialisation properties.
		            'oLanguage': {
		                'sProcessing': '<img src=\"".base_url('assets/images/tenor.gif')."\" />'
		            },
                    'fnServerData': function (sSource, aoData, fnCallback) {
		                $.ajax
		                ({
		                    'dataType': 'json',
		                    'type': 'POST',
		                    'url': sSource,
		                    'data': aoData,
		                    'success': fnCallback
		                });
		            },
		            'fnDrawCallback': function (oSettings) {
						$('.hapus').on('click',function(e){
			                var currentBtn = $(this);

			                uri = currentBtn.attr('data-uri');
			                login = currentBtn.attr('data-login');
			                
			                swal({   
			                    title: 'Yakin data ingin dihapus?',   
			                    text: 'Data tidak dapat dikembalikan lagi',   
			                    type: 'warning',   
			                    showCancelButton: true,   
			                    confirmButtonColor: '#fcb03b',   
			                    confirmButtonText: 'Iya',   
			                    cancelButtonText: 'Tidak',   
			                    closeOnConfirm: false,   
			                    closeOnCancel: false 
			                }, function(isConfirm){   
			                    if (isConfirm) {     
			                         $.ajax({
			                            type: 'POST',
			                            data : 'login='+login,
			                            url: uri,
			                            success: function(data){
											window.location.reload(false); 
			                            }
			                        });
			                           
			                    } else {     
			                        swal('Batal', 'Data tidak jadi dihapus', 'error');   
			                    } 
			                });
			                return false;
			            });
					} 
                });            
 
            });
        </script>"; 
            
		$this->load->view('temp/head');
		$this->load->view('ademik/useraccess/adminjur');
		$this->load->view('temp/footers',$data);
	}

	public function dosen(){
		$data['footerSection'] = "
		    <script type='text/javascript'>
 
            var save_method; //for save method string
            var table;
 
            $(document).ready(function() {
				var oTable = $('#table_admin').dataTable({
		            'processing': true, 
		            'serverSide': true, 
		            'order': [], 
		             
		            'ajax': {
		                'url': '".base_url('ademik/useraccess/datadosen')."',
		                'type': 'POST'
		            },
		 
		             
		            'columnDefs': [
		            { 
		                'targets': [ 0 ], 
		                'orderable': false, 
		            },
		            ],
					'drawCallback': function( settings ) {
				    	$('.hapus').on('click',function(e){
							var currentBtn = $(this);

							uri = currentBtn.attr('data-uri');
							login = currentBtn.attr('data-login');

							swal({   
							    title: 'Yakin data ingin dihapus?',   
							    text: 'Data tidak dapat dikembalikan lagi',   
							    type: 'warning',   
							    showCancelButton: true,   
							    confirmButtonColor: '#fcb03b',   
							    confirmButtonText: 'Iya',
							    cancelButtonText: 'Tidak',   
							    closeOnConfirm: false,   
							    closeOnCancel: false 
							}, function(isConfirm){   
							    if (isConfirm) {     
							         $.ajax({
							            type: 'POST',
							            data : 'login='+login,
							            url: uri,
							            success: function(data){
											window.location.reload(false); 
							            }
							        });
							           
							    } else {     
							        swal('Batal', 'Data tidak jadi dihapus', 'error');   
							    } 
							});
							return false;
						});
					}
			   });

			   	

            });
        </script>"; 

		$this->load->view('temp/head');
		$this->load->view('ademik/useraccess/admindosen');
		$this->load->view('temp/footers',$data);
	}

	public function mahasiswa(){
		$data['footerSection'] = "
		    <script type='text/javascript'>
 
            var save_method; //for save method string
            var table;
 
            $(document).ready(function() {
				var oTable = $('#table_admin').dataTable({
		            'processing': true, 
		            'serverSide': true, 
		            'order': [], 
		             
		            'ajax': {
		                'url': '".base_url('ademik/useraccess/datamahasiswa')."',
		                'type': 'POST'
		            },
		 
		             
		            'columnDefs': [
		            { 
		                'targets': [ 0 ], 
		                'orderable': false, 
		            },
		            ],
					'drawCallback': function( settings ) {
				    	$('.hapus').on('click',function(e){
							var currentBtn = $(this);

							uri = currentBtn.attr('data-uri');
							login = currentBtn.attr('data-login');

							swal({   
							    title: 'Yakin data ingin dihapus?',   
							    text: 'Data tidak dapat dikembalikan lagi',   
							    type: 'warning',   
							    showCancelButton: true,   
							    confirmButtonColor: '#fcb03b',   
							    confirmButtonText: 'Iya',
							    cancelButtonText: 'Tidak',   
							    closeOnConfirm: false,   
							    closeOnCancel: false 
							}, function(isConfirm){   
							    if (isConfirm) {     
							         $.ajax({
							            type: 'POST',
							            data : 'login='+login,
							            url: uri,
							            success: function(data){
											window.location.reload(false); 
							            }
							        });
							           
							    } else {     
							        swal('Batal', 'Data tidak jadi dihapus', 'error');   
							    } 
							});
							return false;
						});
					}
			   });

			   	

            });
        </script>"; 

		$this->load->view('temp/head');
		$this->load->view('ademik/useraccess/adminmahasiswa');
		$this->load->view('temp/footers',$data);
	}

	public function dataadmin(){
        $this->datatables->select('CONCAT("<a href=\"'.base_url("ademik/useraccess/editadmin").'/",ID,"\">",Name,"</a>"), Login, Email, Phone, NotActive, CONCAT("<button data-uri=\"'.base_url("ademik/useraccess/deleteadmin").'\" data-login=\"",Login,"\"  class=\"btn hapus btn-danger btn-icon-anim btn-square\"><i class=\"fa fa-trash-o\"></i></button>")');
        $this->datatables->from('_v2_adm');
        $this->db->order_by("Name", "ASC");
        return print_r($this->datatables->generate());
	}

	public function dataadminpusat(){
		if($this->session->ulevel==1){
			$this->datatables->select('CONCAT("<a href=\"'.base_url("ademik/useraccess/editadminpusat").'/",ID,"\">",Name,"</a>"), Login, Email, Phone, NotActive, CONCAT("<button data-uri=\"'.base_url("ademik/useraccess/deleteadminpusat").'\" data-login=\"",Login,"\" class=\"btn hapus btn-danger btn-icon-anim btn-square\"><i class=\"fa fa-trash-o\"></i></button>")');	
		}else{
			$this->datatables->select('CONCAT("<a href=\"'.base_url("ademik/useraccess/editadminpusat").'/",ID,"\">",Name,"</a>"), Login, Email, Phone, NotActive');
		}
        
        $this->datatables->from('_v2_adm_pusat');
        $this->db->order_by("Name", "ASC");
        return print_r($this->datatables->generate());
	}

	public function dataadminfak(){
		if($this->session->ulevel==1){
			$this->datatables->select('CONCAT("<a href=\"'.base_url("ademik/useraccess/editadminfak").'/",ID,"\">",Name,"</a>"), Login, KodeFakultas, Email, Phone, NotActive, CONCAT("<button data-uri=\"'.base_url("ademik/useraccess/deleteadminfak").'\" data-login=\"",Login,"\" class=\"btn hapus btn-danger btn-icon-anim btn-square\"><i class=\"fa fa-trash-o\"></i></button>")');	
		}else{
			$this->datatables->select('CONCAT("<a href=\"'.base_url("ademik/useraccess/editadminfak").'/",ID,"\">",Name,"</a>"), Login, KodeFakultas, Email, Phone, NotActive');
		}
        
        $this->datatables->from('_v2_adm_fak');
   		if($this->session->ulevel!=1){
   			$this->db->where('KodeFakultas', $this->session->kdf);
        }
        $this->db->order_by("Name", "ASC");
        return print_r($this->datatables->generate());
	}

	public function dataadminjur(){
		if($this->session->ulevel==1){
			$this->datatables->select('CONCAT("<a href=\"'.base_url("ademik/useraccess/editadminjur").'/",ID,"\">",Name,"</a>"), Login, KodeFakultas, KodeJurusan, Email, Phone, NotActive, CONCAT("<button data-uri=\"'.base_url("ademik/useraccess/deleteadminjur").'\" data-login=\"",Login,"\" class=\"btn hapus btn-danger btn-icon-anim btn-square\"><i class=\"fa fa-trash-o\"></i></button>")');	
		}else{
			$this->datatables->select('CONCAT("<a href=\"'.base_url("ademik/useraccess/editadminjur").'/",ID,"\">",Name,"</a>"), Login, KodeFakultas, KodeJurusan, Email, Phone, NotActive');
		}
        
        $this->datatables->from('_v2_adm_jur');
        if($this->session->ulevel!=1){
   			$this->db->where('KodeFakultas', $this->session->kdf);
        }
        $this->db->order_by("Name", "ASC");
        return print_r($this->datatables->generate());
	}

	public function datadosen(){
				if(isset($this->session->kdf)){
					$kode_fak = $this->session->kdf;
				}else{
					$kode_fak = '';
				}
				$list = $this->user_model->get_datatablesDosen($kode_fak);
        $data = array();
        $no = $_POST['start']+1;
        foreach ($list as $field) {

            $row = array();
            $row[] = "<a href='".base_url("ademik/useraccess/editadmindosen/".$field->ID)."'>".$field->Name."</a>";
            $row[] = $field->Login;
            $row[] = $field->Email;
            $row[] = $field->Phone;
            $row[] = $field->NotActive;
			if($this->session->ulevel==1){
				$row[] = "<button data-uri='".base_url("ademik/useraccess/deleteadmindosen")."' data-login='".$field->Login."' class='btn hapus btn-danger btn-icon-anim btn-square'><i class='fa fa-trash-o'></i></button>";
			}

            $no++;

			$data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->user_model->count_alldosen($kode_fak),
            "recordsFiltered" => $this->user_model->count_filtereddosen($kode_fak),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function datamahasiswa(){
				if(isset($this->session->kdf))
			{
				$kode_fak = $this->session->kdf;
			}	else{
				$kode_fak = '';
			}$list = $this->user_model->get_datatablesmahasiswa($kode_fak);
        $data = array();
        $no = $_POST['start']+1;
        foreach ($list as $field) {

            $row = array();
            $row[] = "<a href='".base_url("ademik/useraccess/editadminmahasiswa/".$field->ID)."'>".$field->Name."</a>";
            $row[] = $field->Login;
            $row[] = $field->Email;
            $row[] = $field->Phone;
            $row[] = $field->NotActive;
			if($this->session->ulevel==1){
				$row[] = "<button data-uri='".base_url("ademik/useraccess/deleteadminmahasiswa")."' data-login='".$field->Login."' class='btn hapus btn-danger btn-icon-anim btn-square'><i class='fa fa-trash-o'></i></button>";
			}

            $no++;

			$data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->user_model->count_allmahasiswa($kode_fak),
            "recordsFiltered" => $this->user_model->count_filteredmahasiswa($kode_fak),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function addadmin(){
		$this->load->view('temp/head');
		$this->load->view('ademik/useraccess/addadmin');
		$this->load->view('temp/footers');
	}

	public function addadminpusat(){
		$this->load->view('temp/head');
		$this->load->view('ademik/useraccess/addadminpusat');
		$this->load->view('temp/footers');
	}

	public function addadminfak(){
		$data['fakultas']=$this->user_model->getFakultas();
		
		$this->load->view('temp/head');
		$this->load->view('ademik/useraccess/addadminfak', $data);
		$this->load->view('temp/footers');
	}

	public function addadminjur(){
		$data['fakultas']=$this->user_model->getFakultas();
		
		$this->load->view('temp/head');
		$this->load->view('ademik/useraccess/addadminjur', $data);
		$this->load->view('temp/footers');
	}

	public function getJurusan(){
		$kdf = $this->input->post('KodeFakultas');

		$data = $this->user_model->getJurusan($kdf);

		$vData="";
		$count = 0;
		foreach ($data as $show) {
			$vData = $vData.$show->Kode."|".$show->Nama_Indonesia."=";	
			$count++;		
		}
		$count--;
		$dataView = array(
			'data' => $vData."+".$count
		);
		echo json_encode($dataView);
	}

	public function addadmindosen(){
		$this->load->view('temp/head');
		$this->load->view('ademik/useraccess/addadmindosen');
		$this->load->view('temp/footers');
	}

	/*public function addadminmahasiswa(){
		$this->load->view('temp/head');
		$this->load->view('ademik/useraccess/addadminmahasiswa');
		$this->load->view('temp/footers');
	}*/


	public function storeAdmin(){
		$config = array(
		        array(
		                'field' => 'Login',
		                'label' => 'Nama Login',
		                'rules' => array(
		                		'required',
		                		'is_unique[_v2_adm.Login]'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.',
		                        'is_unique' => '%s sudah ada.'    
		                )
		        ),array(
		                'field' => 'Password',
		                'label' => 'Password',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'full_name',
		                'label' => 'Nama Lengkap',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'Phone',
		                'label' => 'Phone',
		                'rules' => array(
		                	'required',
		                	'max_length[12]',
		                	'integer'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.',
		                        'max_length' => '%s tidak boleh lebih dari 12 karakter',
		                        'integer' => '%s harus angka'
		                )
		        ),
		        array(
		                'field' => 'Email',
		                'label' => 'Email',
		                'rules' => array(
		                		'required',
		                		'is_unique[_v2_adm.Email]'		                		
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        )
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable" style="margin:10px 20px;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="ti-alert pr-15"></i>', '</div>');

	    if ($this->form_validation->run() === FALSE)
	    {
	    	$this->session->set_flashdata('error', validation_errors());
	    	redirect('ademik/useraccess/addadmin');
	    }
	    else
	    {
			$data = array(
		        'Login' => $this->user_model->db->escape_str($this->input->post('Login')),
		        'Password' => $this->user_model->db->escape_str($this->input->post('Password')),
		        'Description' => $this->user_model->db->escape_str($this->input->post('Description')),
		       	'Name' => $this->user_model->db->escape_str($this->input->post('full_name')),
		       	'Email' => $this->user_model->db->escape_str($this->input->post('Email')),
		       	'Phone' => $this->user_model->db->escape_str($this->input->post('Phone'))
		    );
			
		 	$this->user_model->insert($data, '_v2_adm');

			$dataLog = array(
		        'username' => $this->user_model->db->escape_str($this->input->post('Login')),
		        'user_category' => 'Admin SU',
		       	'user_created' => $this->session->uname,
		       	'date_created' => date("Y-m-d H:i:s"),
		       	'ip_address' => $this->input->ip_address(),
		       	'status' => 'Add'
		    );
			
		 	$this->user_model->insertLog($dataLog, '_v2_log_user');
	        
	        redirect('ademik/useraccess/adminpage');
	    }		
	}

	public function storeAdminPusat(){
		$config = array(
		        array(
		                'field' => 'Login',
		                'label' => 'Nama Login',
		                'rules' => array(
		                		'required',
		                		'is_unique[_v2_adm_pusat.Login]'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.',
		                        'is_unique' => '%s sudah ada.'    
		                )
		        ),array(
		                'field' => 'Password',
		                'label' => 'Password',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'full_name',
		                'label' => 'Nama Lengkap',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'Phone',
		                'label' => 'Phone',
		                'rules' => array(
		                	'required',
		                	'max_length[12]',
		                	'integer'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.',
		                        'max_length' => '%s tidak boleh lebih dari 12 karakter',
		                        'integer' => '%s harus angka'
		                )
		        ),
		        array(
		                'field' => 'Email',
		                'label' => 'Email',
		                'rules' => array(
		                		'required',
		                		'is_unique[_v2_adm_pusat.Email]'		                		
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        )
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable" style="margin:10px 20px;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="ti-alert pr-15"></i>', '</div>');

	    if ($this->form_validation->run() === FALSE)
	    {
	    	$this->session->set_flashdata('error', validation_errors());
	    	redirect('ademik/useraccess/addadminpusat');
	    }
	    else
	    {
			$data = array(
		        'Login' => $this->user_model->db->escape_str($this->input->post('Login')),
		        'Password' => $this->user_model->db->escape_str($this->input->post('Password')),
		        'Description' => $this->user_model->db->escape_str($this->input->post('Description')),
		       	'Name' => $this->user_model->db->escape_str($this->input->post('full_name')),
		       	'Email' => $this->user_model->db->escape_str($this->input->post('Email')),
		       	'Phone' => $this->user_model->db->escape_str($this->input->post('Phone'))
		    );
			
		 	$this->user_model->insert($data, '_v2_adm_pusat');

		 	$dataLog = array(
		        'username' => $this->user_model->db->escape_str($this->input->post('Login')),
		        'user_category' => 'Admin Pusat',
		       	'user_created' => $this->session->uname,
		       	'date_created' => date("Y-m-d H:i:s"),
		       	'ip_address' => $this->input->ip_address(),
		       	'status' => 'Add'
		    );
			
		 	$this->user_model->insertLog($dataLog, '_v2_log_user');
	        
	        redirect('ademik/useraccess/adminpusat');
	    }		
	}

	public function storeAdminFak(){
		$config = array(
		        array(
		                'field' => 'Login',
		                'label' => 'Nama Login',
		                'rules' => array(
		                		'required',
		                		'is_unique[_v2_adm_fak.Login]'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.',
		                        'is_unique' => '%s sudah ada.'    
		                )
		        ),array(
		                'field' => 'Password',
		                'label' => 'Password',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'full_name',
		                'label' => 'Nama Lengkap',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'Phone',
		                'label' => 'Phone',
		                'rules' => array(
		                	'required',
		                	'max_length[12]',
		                	'integer'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.',
		                        'max_length' => '%s tidak boleh lebih dari 12 karakter',
		                        'integer' => '%s harus angka'
		                )
		        ),
		        array(
		                'field' => 'KodeFakultas',
		                'label' => 'Kode Fakultas',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'Email',
		                'label' => 'Email',
		                'rules' => array(
		                		'required',
		                		'is_unique[_v2_adm_fak.Email]'		                		
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        )
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable" style="margin:10px 20px;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="ti-alert pr-15"></i>', '</div>');

	    if ($this->form_validation->run() === FALSE)
	    {
	    	$this->session->set_flashdata('error', validation_errors());
	    	redirect('ademik/useraccess/addadminfak');
	    }
	    else
	    {
			$data = array(
		        'Login' => $this->user_model->db->escape_str($this->input->post('Login')),
		        'Password' => $this->user_model->db->escape_str($this->input->post('Password')),
		        'Description' => $this->user_model->db->escape_str($this->input->post('Description')),
		       	'Name' => $this->user_model->db->escape_str($this->input->post('full_name')),
		       	'Email' => $this->user_model->db->escape_str($this->input->post('Email')),
		       	'Phone' => $this->user_model->db->escape_str($this->input->post('Phone')),
		       	'KodeFakultas' => $this->user_model->db->escape_str($this->input->post('KodeFakultas'))
		    );
			
		 	$this->user_model->insertFakultas($data, '_v2_adm_fak');

		 	$dataLog = array(
		        'username' => $this->user_model->db->escape_str($this->input->post('Login')),
		        'user_category' => 'Fakultas',
		       	'user_created' => $this->session->uname,
		       	'date_created' => date("Y-m-d H:i:s"),
		       	'ip_address' => $this->input->ip_address(),
		       	'status' => 'Add'
		    );
			
		 	$this->user_model->insertLog($dataLog, '_v2_log_user');
	        
	        redirect('ademik/useraccess/adminfak');
	    }		
	}

	public function storeAdminJurusan(){
		$config = array(
		        array(
		                'field' => 'Login',
		                'label' => 'Nama Login',
		                'rules' => array(
		                		'required',
		                		'is_unique[_v2_adm_jur.Login]'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.',
		                        'is_unique' => '%s sudah ada.'    
		                )
		        ),array(
		                'field' => 'Password',
		                'label' => 'Password',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'full_name',
		                'label' => 'Nama Lengkap',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'Phone',
		                'label' => 'Phone',
		                'rules' => array(
		                	'required',
		                	'max_length[12]',
		                	'integer'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.',
		                        'max_length' => '%s tidak boleh lebih dari 12 karakter',
		                        'integer' => '%s harus angka'
		                )
		        ),
		        array(
		                'field' => 'KodeFakultas',
		                'label' => 'Kode Fakultas',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'KodeJurusan',
		                'label' => 'Kode Jurusan',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'Email',
		                'label' => 'Email',
		                'rules' => array(
		                		'required',
		                		'is_unique[_v2_adm_jur.Email]'		                		
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        )
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable" style="margin:10px 20px;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="ti-alert pr-15"></i>', '</div>');

	    if ($this->form_validation->run() === FALSE)
	    {
	    	$this->session->set_flashdata('error', validation_errors());
	    	redirect('ademik/useraccess/addadminjur');
	    }
	    else
	    {
			$data = array(
		        'Login' => $this->user_model->db->escape_str($this->input->post('Login')),
		        'Password' => $this->user_model->db->escape_str($this->input->post('Password')),
		        'Description' => $this->user_model->db->escape_str($this->input->post('Description')),
		       	'Name' => $this->user_model->db->escape_str($this->input->post('full_name')),
		       	'Email' => $this->user_model->db->escape_str($this->input->post('Email')),
		       	'Phone' => $this->user_model->db->escape_str($this->input->post('Phone')),
		       	'KodeFakultas' => $this->user_model->db->escape_str($this->input->post('KodeFakultas')),
		       	'KodeJurusan' => $this->user_model->db->escape_str($this->input->post('KodeJurusan'))
		    );
			
		 	$this->user_model->insertJurusan($data, '_v2_adm_jur');

		 	$dataLog = array(
		        'username' => $this->user_model->db->escape_str($this->input->post('Login')),
		        'user_category' => 'Jurusan',
		       	'user_created' => $this->session->uname,
		       	'date_created' => date("Y-m-d H:i:s"),
		       	'ip_address' => $this->input->ip_address(),
		       	'status' => 'Add'
		    );
			
		 	$this->user_model->insertLog($dataLog, '_v2_log_user');
	        
	        redirect('ademik/useraccess/adminjur');
	    }		
	}

	public function storeAdminDosen(){
		$config = array(
		        array(
		                'field' => 'Login',
		                'label' => 'Nama Login',
		                'rules' => array(
		                		'required',
		                		'is_unique[_v2_dosen.Login]'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.',
		                        'is_unique' => '%s sudah ada.'    
		                )
		        ),array(
		                'field' => 'nip',
		                'label' => 'NIP',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),array(
		                'field' => 'Password',
		                'label' => 'Password',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'full_name',
		                'label' => 'Nama Lengkap',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'Phone',
		                'label' => 'Phone',
		                'rules' => array(
		                	'required',
		                	'max_length[12]',
		                	'integer'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.',
		                        'max_length' => '%s tidak boleh lebih dari 12 karakter',
		                        'integer' => '%s harus angka'
		                )
		        ),
		        array(
		                'field' => 'Email',
		                'label' => 'Email',
		                'rules' => array(
		                		'required',
		                		'is_unique[_v2_dosen.Email]'		                		
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        )
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable" style="margin:10px 20px;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="ti-alert pr-15"></i>', '</div>');

	    if ($this->form_validation->run() === FALSE)
	    {
	    	$this->session->set_flashdata('error', validation_errors());
	    	redirect('ademik/useraccess/addadmindosen');
	    }
	    else
	    {
			$data = array(
		        'Login' => $this->user_model->db->escape_str($this->input->post('Login')),
		        'nip' => $this->user_model->db->escape_str($this->input->post('nip')),
		        'Password' => $this->user_model->db->escape_str($this->input->post('Password')),
		        'Description' => $this->user_model->db->escape_str($this->input->post('Description')),
		       	'Name' => $this->user_model->db->escape_str($this->input->post('full_name')),
		       	'Email' => $this->user_model->db->escape_str($this->input->post('Email')),
		       	'Phone' => $this->user_model->db->escape_str($this->input->post('Phone'))
		    );
			
		 	$this->user_model->insertDosen($data, '_v2_dosen');

		 	$dataLog = array(
		        'username' => $this->user_model->db->escape_str($this->input->post('Login')),
		        'user_category' => 'Dosen',
		       	'user_created' => $this->session->uname,
		       	'date_created' => date("Y-m-d H:i:s"),
		       	'ip_address' => $this->input->ip_address(),
		       	'status' => 'Add'
		    );
			
		 	$this->user_model->insertLog($dataLog, '_v2_log_user');
	        
	        redirect('ademik/useraccess/dosen');
	    }		
	}

	/*public function storeAdminMahasiswa(){
		$config = array(
		        array(
		                'field' => 'Login',
		                'label' => 'Nama Login',
		                'rules' => array(
		                		'required',
		                		'is_unique[_v2_mhsw.Login]'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.',
		                        'is_unique' => '%s sudah ada.'    
		                )
		        ),array(
		                'field' => 'NIM',
		                'label' => 'NIM',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),array(
		                'field' => 'Password',
		                'label' => 'Password',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'full_name',
		                'label' => 'Nama Lengkap',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'Phone',
		                'label' => 'Phone',
		                'rules' => array(
		                	'required',
		                	'max_length[12]',
		                	'integer'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.',
		                        'max_length' => '%s tidak boleh lebih dari 12 karakter',
		                        'integer' => '%s harus angka'
		                )
		        ),
		        array(
		                'field' => 'Email',
		                'label' => 'Email',
		                'rules' => array(
		                		'required',
		                		'is_unique[_v2_mhsw.Email]'		                		
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        )
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable" style="margin:10px 20px;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="ti-alert pr-15"></i>', '</div>');

	    if ($this->form_validation->run() === FALSE)
	    {
	    	$this->session->set_flashdata('error', validation_errors());
	    	redirect('ademik/useraccess/addadminmahasiswa');
	    }
	    else
	    {
			$data = array(
		        'Login' => $this->user_model->db->escape_str($this->input->post('Login')),
		        'NIM' => $this->user_model->db->escape_str($this->input->post('NIM')),
		        'Password' => $this->user_model->db->escape_str($this->input->post('Password')),
		        'Description' => $this->user_model->db->escape_str($this->input->post('Description')),
		       	'Name' => $this->user_model->db->escape_str($this->input->post('full_name')),
		       	'Email' => $this->user_model->db->escape_str($this->input->post('Email')),
		       	'Phone' => $this->user_model->db->escape_str($this->input->post('Phone'))
		    );
			
		 	$this->user_model->insertMhsw($data, '_v2_mhsw');

		 	$dataLog = array(
		        'username' => $this->user_model->db->escape_str($this->input->post('Login')),
		        'user_category' => 'Mahasiswa',
		       	'user_created' => $this->session->uname,
		       	'date_created' => date("Y-m-d H:i:s"),
		       	'ip_address' => $this->input->ip_address(),
		       	'status' => 'Add'
		    );
			
		 	$this->user_model->insertLog($dataLog, '_v2_log_user');
	        
	        redirect('ademik/useraccess/mahasiswa');
	    }		
	}*/

	public function editadmin($id){
		$data['edit'] = $this->user_model->getAdmin($id, "_v2_adm")->row();
		$this->load->view('temp/head');
		$this->load->view('ademik/useraccess/editadmin',$data);
		$this->load->view('temp/footers');
	}

	public function editadminpusat($id){
		if($this->session->ulevel==1){
			$data['edit'] = $this->user_model->getAdmin($id, "_v2_adm_pusat")->row();
			$this->load->view('temp/head');
			$this->load->view('ademik/useraccess/editadminpusat',$data);
			$this->load->view('temp/footers');	
		}else{
			if($this->session->id==$id){
				$data['edit'] = $this->user_model->getAdmin($id, "_v2_adm_pusat")->row();
				$this->load->view('temp/head');
				$this->load->view('ademik/useraccess/editadminpusat',$data);
				$this->load->view('temp/footers');	
			}else{
		        redirect('ademik/useraccess/adminpusat');			
			}
		}
	}

	public function editadminfak($id){
		if($this->session->ulevel==1 or $this->session->ulevel==6){
			$data['edit'] = $this->user_model->getAdmin($id, "_v2_adm_fak")->row();
			$data['fakultas']=$this->user_model->getFakultas();
			$this->load->view('temp/head');
			$this->load->view('ademik/useraccess/editadminfak',$data);
			$this->load->view('temp/footers');	
		}else{
			if($this->session->id==$id){
				$data['edit'] = $this->user_model->getAdmin($id, "_v2_adm_fak")->row();
				$data['fakultas']=$this->user_model->getFakultas();
				$this->load->view('temp/head');
				$this->load->view('ademik/useraccess/editadminfak',$data);
				$this->load->view('temp/footers');	
			}else{
		        redirect('ademik/useraccess/adminfak');			
			}	
		}
		
	}

	public function editadminjur($id){
		if($this->session->ulevel==1 or $this->session->ulevel==6 or $this->session->ulevel==5){
			$data['fakultas']=$this->user_model->getFakultas();
			$data['edit'] = $this->user_model->getAdmin($id, "_v2_adm_jur")->row();
			$this->load->view('temp/head');
			$this->load->view('ademik/useraccess/editadminjur',$data);
			$this->load->view('temp/footers');	
		}else{
			if($this->session->id==$id){
				$data['fakultas']=$this->user_model->getFakultas();
				$data['edit'] = $this->user_model->getAdmin($id, "_v2_adm_jur")->row();
				$this->load->view('temp/head');
				$this->load->view('ademik/useraccess/editadminjur',$data);
				$this->load->view('temp/footers');	
			}else{
		        redirect('ademik/useraccess/adminjur');			
			}	
		}
		
	}

	public function editadmindosen($id){
		if($this->session->ulevel==1 or $this->session->ulevel==6 or $this->session->ulevel==5 or $this->session->ulevel==7){
			$data['edit'] = $this->user_model->getAdmin($id, "_v2_dosen")->row();
			$this->load->view('temp/head');
			$this->load->view('ademik/useraccess/editadmindosen',$data);
			$this->load->view('temp/footers');	
		}else{
			if($this->session->id==$id){
				$data['edit'] = $this->user_model->getAdmin($id, "_v2_dosen")->row();
				$this->load->view('temp/head');
				$this->load->view('ademik/useraccess/editadmindosen',$data);
				$this->load->view('temp/footers');	
			}else{
		        redirect('ademik/useraccess/dosen');			
			}	
		}
		
	}

	public function editadminmahasiswa($id){
		if($this->session->ulevel==1 or $this->session->ulevel==6 or $this->session->ulevel==5 or $this->session->ulevel==7){
			$data['edit'] = $this->user_model->getAdmin($id, "_v2_mhsw")->row();
			$this->load->view('temp/head');
			$this->load->view('ademik/useraccess/editadminmahasiswa',$data);
			$this->load->view('temp/footers');	
		}else{
			if($this->session->id==$id){
				$data['edit'] = $this->user_model->getAdmin($id, "_v2_mhsw")->row();
				$this->load->view('temp/head');
				$this->load->view('ademik/useraccess/editadminmahasiswa',$data);
				$this->load->view('temp/footers');	
			}else{
		        redirect('ademik/useraccess/mahasiswa');			
			}	
		}
		
	}

	public function updateAdmin($id){
		$config = array(
		        array(
		                'field' => 'Login',
		                'label' => 'Nama Login',
		                'rules' => array(
		                		'required'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'full_name',
		                'label' => 'Nama Lengkap',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'Phone',
		                'label' => 'Phone',
		                'rules' => array(
		                	'required',
		                	'max_length[12]',
		                	'integer'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.',
		                        'max_length' => '%s tidak boleh lebih dari 12 karakter',
		                        'integer' => 'harus angka'
		                )
		        ),
		        array(
		                'field' => 'Email',
		                'label' => 'Email',
		                'rules' => array(
		                		'required'               		
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        )
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable" style="margin:10px 20px;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="ti-alert pr-15"></i>', '</div>');

	    if ($this->form_validation->run() === FALSE)
	    {
	    	$this->session->set_flashdata('error', validation_errors());
	    	redirect('ademik/useraccess/editadmin/'.$id);
	    }
	    else
	    {
	    	if($this->input->post('Password')==""){
	    		$data = array(
	    			'ID' => $id,
			        'Description' => $this->user_model->db->escape_str($this->input->post('Description')),
			       	'Name' => $this->user_model->db->escape_str($this->input->post('full_name')),
			       	'Email' => $this->user_model->db->escape_str($this->input->post('Email')),
			       	'Phone' => $this->user_model->db->escape_str($this->input->post('Phone')),
			       	'NotActive' => $this->user_model->db->escape_str($this->input->post('NotActive'))
			    );
				
			 	$this->user_model->update($data, '_v2_adm');   	
	    	}else{
	    		$data = array(
	    			'ID' => $id,
			        'Password' => $this->user_model->db->escape_str($this->input->post('Password')),
			        'Description' => $this->user_model->db->escape_str($this->input->post('Description')),
			       	'Name' => $this->user_model->db->escape_str($this->input->post('full_name')),
			       	'Email' => $this->user_model->db->escape_str($this->input->post('Email')),
			       	'Phone' => $this->user_model->db->escape_str($this->input->post('Phone')),
			       	'NotActive' => $this->user_model->db->escape_str($this->input->post('NotActive'))
			    );
				
			 	$this->user_model->updatePassword($data, '_v2_adm');
	    	}
			
			$dataLog = array(
		        'username' => $this->user_model->db->escape_str($this->input->post('Login')),
		        'user_category' => 'Admin SU',
		       	'user_created' => $this->session->uname,
		       	'date_created' => date("Y-m-d H:i:s"),
		       	'ip_address' => $this->input->ip_address(),
		       	'status' => 'Edit'
		    );
			
		 	$this->user_model->insertLog($dataLog, '_v2_log_user');
	        redirect('ademik/useraccess/adminpage');
	    }		
	}

	public function updateAdminPusat($id){
		$config = array(
		        array(
		                'field' => 'Login',
		                'label' => 'Nama Login',
		                'rules' => array(
		                		'required'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'full_name',
		                'label' => 'Nama Lengkap',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'Phone',
		                'label' => 'Phone',
		                'rules' => array(
		                	'required',
		                	'max_length[12]',
		                	'integer'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.',
		                        'max_length' => '%s tidak boleh lebih dari 12 karakter',
		                        'integer' => 'harus angka'
		                )
		        ),
		        array(
		                'field' => 'Email',
		                'label' => 'Email',
		                'rules' => array(
		                		'required'               		
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        )
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable" style="margin:10px 20px;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="ti-alert pr-15"></i>', '</div>');

	    if ($this->form_validation->run() === FALSE)
	    {
	    	$this->session->set_flashdata('error', validation_errors());
	    	redirect('ademik/useraccess/editadminpusat/'.$id);
	    }
	    else
	    {
	    	if($this->input->post('Password')==""){
	    		$data = array(
	    			'ID' => $id,
			        'Description' => $this->user_model->db->escape_str($this->input->post('Description')),
			       	'Name' => $this->user_model->db->escape_str($this->input->post('full_name')),
			       	'Email' => $this->user_model->db->escape_str($this->input->post('Email')),
			       	'Phone' => $this->user_model->db->escape_str($this->input->post('Phone')),
			       	'NotActive' => $this->user_model->db->escape_str($this->input->post('NotActive'))
			    );
				
			 	$this->user_model->update($data, '_v2_adm_pusat');   	
	    	}else{
	    		$data = array(
	    			'ID' => $id,
			        'Password' => $this->user_model->db->escape_str($this->input->post('Password')),
			        'Description' => $this->user_model->db->escape_str($this->input->post('Description')),
			       	'Name' => $this->user_model->db->escape_str($this->input->post('full_name')),
			       	'Email' => $this->user_model->db->escape_str($this->input->post('Email')),
			       	'Phone' => $this->user_model->db->escape_str($this->input->post('Phone')),
			       	'NotActive' => $this->user_model->db->escape_str($this->input->post('NotActive'))
			    );
				
			 	$this->user_model->updatePassword($data, '_v2_adm_pusat');
	    	}

	    	$dataLog = array(
		        'username' => $this->user_model->db->escape_str($this->input->post('Login')),
		        'user_category' => 'Admin Pusat',
		       	'user_created' => $this->session->uname,
		       	'date_created' => date("Y-m-d H:i:s"),
		       	'ip_address' => $this->input->ip_address(),
		       	'status' => 'Edit'
		    );
			
		 	$this->user_model->insertLog($dataLog, '_v2_log_user');
			
	        redirect('ademik/useraccess/adminpusat');
	    }		
	}

	public function updateAdminFak($id){
		$config = array(
		        array(
		                'field' => 'Login',
		                'label' => 'Nama Login',
		                'rules' => array(
		                		'required'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'full_name',
		                'label' => 'Nama Lengkap',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'Phone',
		                'label' => 'Phone',
		                'rules' => array(
		                	'required',
		                	'max_length[12]',
		                	'integer'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.',
		                        'max_length' => '%s tidak boleh lebih dari 12 karakter',
		                        'integer' => 'harus angka'
		                )
		        ),
		        array(
		                'field' => 'KodeFakultas',
		                'label' => 'Kode Fakultas',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'Email',
		                'label' => 'Email',
		                'rules' => array(
		                		'required'               		
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        )
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable" style="margin:10px 20px;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="ti-alert pr-15"></i>', '</div>');

	    if ($this->form_validation->run() === FALSE)
	    {
	    	$this->session->set_flashdata('error', validation_errors());
	    	redirect('ademik/useraccess/editadminfak/'.$id);
	    }
	    else
	    {
	    	if($this->input->post('Password')==""){
	    		$data = array(
	    			'ID' => $id,
			        'Description' => $this->user_model->db->escape_str($this->input->post('Description')),
			       	'Name' => $this->user_model->db->escape_str($this->input->post('full_name')),
			       	'Email' => $this->user_model->db->escape_str($this->input->post('Email')),
			       	'Phone' => $this->user_model->db->escape_str($this->input->post('Phone')),
			       	'KodeFakultas' => $this->user_model->db->escape_str($this->input->post('KodeFakultas')),
			       	'NotActive' => $this->user_model->db->escape_str($this->input->post('NotActive'))
			    );
				
			 	$this->user_model->updateFakultas($data, '_v2_adm_fak');   	
	    	}else{
	    		$data = array(
	    			'ID' => $id,
			        'Password' => $this->user_model->db->escape_str($this->input->post('Password')),
			        'Description' => $this->user_model->db->escape_str($this->input->post('Description')),
			       	'Name' => $this->user_model->db->escape_str($this->input->post('full_name')),
			       	'Email' => $this->user_model->db->escape_str($this->input->post('Email')),
			       	'Phone' => $this->user_model->db->escape_str($this->input->post('Phone')),
			       	'KodeFakultas' => $this->user_model->db->escape_str($this->input->post('KodeFakultas')),
			       	'NotActive' => $this->user_model->db->escape_str($this->input->post('NotActive'))
			    );
				
			 	$this->user_model->updatePasswordFakultas($data, '_v2_adm_fak');
	    	}

	    	$dataLog = array(
		        'username' => $this->user_model->db->escape_str($this->input->post('Login')),
		        'user_category' => 'Fakultas',
		       	'user_created' => $this->session->uname,
		       	'date_created' => date("Y-m-d H:i:s"),
		       	'ip_address' => $this->input->ip_address(),
		       	'status' => 'Edit'
		    );
			
		 	$this->user_model->insertLog($dataLog, '_v2_log_user');
			
	        redirect('ademik/useraccess/adminfak');
	    }		
	}

	public function updateAdminJurusan($id){
		$config = array(
		        array(
		                'field' => 'Login',
		                'label' => 'Nama Login',
		                'rules' => array(
		                		'required'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'full_name',
		                'label' => 'Nama Lengkap',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'Phone',
		                'label' => 'Phone',
		                'rules' => array(
		                	'required',
		                	'max_length[12]',
		                	'integer'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.',
		                        'max_length' => '%s tidak boleh lebih dari 12 karakter',
		                        'integer' => 'harus angka'
		                )
		        ),
		        array(
		                'field' => 'Email',
		                'label' => 'Email',
		                'rules' => array(
		                		'required'               		
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        )
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable" style="margin:10px 20px;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="ti-alert pr-15"></i>', '</div>');

	    if ($this->form_validation->run() === FALSE)
	    {
	    	$this->session->set_flashdata('error', validation_errors());
	    	redirect('ademik/useraccess/editadminjur/'.$id);
	    }
	    else
	    {
	    	if($this->input->post('Password')==""){
	    		$data = array(
	    			'ID' => $id,
			        'Description' => $this->user_model->db->escape_str($this->input->post('Description')),
			       	'Name' => $this->user_model->db->escape_str($this->input->post('full_name')),
			       	'Email' => $this->user_model->db->escape_str($this->input->post('Email')),
			       	'Phone' => $this->user_model->db->escape_str($this->input->post('Phone')),
			       	'NotActive' => $this->user_model->db->escape_str($this->input->post('NotActive')),
			       	'KodeFakultas' => $this->user_model->db->escape_str($this->input->post('KodeFakultas')),
			       	'KodeJurusan' => $this->user_model->db->escape_str($this->input->post('KodeJurusan'))
			    );
				
			 	$this->user_model->updateJurusan($data, '_v2_adm_jur');   	
	    	}else{
	    		$data = array(
	    			'ID' => $id,
			        'Password' => $this->user_model->db->escape_str($this->input->post('Password')),
			        'Description' => $this->user_model->db->escape_str($this->input->post('Description')),
			       	'Name' => $this->user_model->db->escape_str($this->input->post('full_name')),
			       	'Email' => $this->user_model->db->escape_str($this->input->post('Email')),
			       	'Phone' => $this->user_model->db->escape_str($this->input->post('Phone')),
			       	'NotActive' => $this->user_model->db->escape_str($this->input->post('NotActive')),
				    'KodeFakultas' => $this->user_model->db->escape_str($this->input->post('KodeFakultas')),
			       	'KodeJurusan' => $this->user_model->db->escape_str($this->input->post('KodeJurusan'))
			    );
				
			 	$this->user_model->updatePassword($data, '_v2_adm_jur');
	    	}
			
			$dataLog = array(
		        'username' => $this->user_model->db->escape_str($this->input->post('Login')),
		        'user_category' => 'Jurusan',
		       	'user_created' => $this->session->uname,
		       	'date_created' => date("Y-m-d H:i:s"),
		       	'ip_address' => $this->input->ip_address(),
		       	'status' => 'Edit'
		    );
			
		 	$this->user_model->insertLog($dataLog, '_v2_log_user');
	        redirect('ademik/useraccess/adminjur');
	    }		
	}

	public function updateAdminDosen($id){
		$config = array(
		        array(
		                'field' => 'Login',
		                'label' => 'Nama Login',
		                'rules' => array(
		                		'required'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'nip',
		                'label' => 'NIP',
		                'rules' => array(
		                		'required'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'full_name',
		                'label' => 'Nama Lengkap',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'Phone',
		                'label' => 'Phone',
		                'rules' => array(
		                	'required',
		                	'max_length[12]',
		                	'integer'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.',
		                        'max_length' => '%s tidak boleh lebih dari 12 karakter',
		                        'integer' => 'harus angka'
		                )
		        ),
		        array(
		                'field' => 'Email',
		                'label' => 'Email',
		                'rules' => array(
		                		'required'               		
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        )
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable" style="margin:10px 20px;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="ti-alert pr-15"></i>', '</div>');

	    if ($this->form_validation->run() === FALSE)
	    {
	    	$this->session->set_flashdata('error', validation_errors());
	    	redirect('ademik/useraccess/editadmindosen/'.$id);
	    }
	    else
	    {
	    	if($this->input->post('Password')==""){
	    		$data = array(
	    			'ID' => $id,
			        'Description' => $this->user_model->db->escape_str($this->input->post('Description')),
			       	'Name' => $this->user_model->db->escape_str($this->input->post('full_name')),
			       	'Email' => $this->user_model->db->escape_str($this->input->post('Email')),
			       	'Phone' => $this->user_model->db->escape_str($this->input->post('Phone')),
			       	'NotActive' => $this->user_model->db->escape_str($this->input->post('NotActive'))
			    );
				
			 	$this->user_model->update($data, '_v2_dosen');   	
	    	}else{
	    		$data = array(
	    			'ID' => $id,
			        'Password' => $this->user_model->db->escape_str($this->input->post('Password')),
			        'Description' => $this->user_model->db->escape_str($this->input->post('Description')),
			       	'Name' => $this->user_model->db->escape_str($this->input->post('full_name')),
			       	'Email' => $this->user_model->db->escape_str($this->input->post('Email')),
			       	'Phone' => $this->user_model->db->escape_str($this->input->post('Phone')),
			       	'NotActive' => $this->user_model->db->escape_str($this->input->post('NotActive')),
			       	'count_edit_password' => '0'
			    );
				
			 	$this->user_model->updatePassword($data, '_v2_dosen');
	    	}
			
			$dataLog = array(
		        'username' => $this->user_model->db->escape_str($this->input->post('Login')),
		        'user_category' => 'Dosen',
		       	'user_created' => $this->session->uname,
		       	'date_created' => date("Y-m-d H:i:s"),
		       	'ip_address' => $this->input->ip_address(),
		       	'status' => 'Edit'
		    );
			
		 	$this->user_model->insertLog($dataLog, '_v2_log_user');

	        redirect('ademik/useraccess/dosen');
	    }		
	}

	public function updateAdminMahasiswa($id){
		$config = array(
		        array(
		                'field' => 'Login',
		                'label' => 'Nama Login',
		                'rules' => array(
		                		'required'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'nim',
		                'label' => 'NIM',
		                'rules' => array(
		                		'required'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'full_name',
		                'label' => 'Nama Lengkap',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        ),
		        array(
		                'field' => 'Phone',
		                'label' => 'Phone',
		                'rules' => array(
		                	'required',
		                	'max_length[12]',
		                	'integer'
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.',
		                        'max_length' => '%s tidak boleh lebih dari 12 karakter',
		                        'integer' => 'harus angka'
		                )
		        ),
		        array(
		                'field' => 'Email',
		                'label' => 'Email',
		                'rules' => array(
		                		'required'               		
		                ),
		                'errors' => array(
		                        'required' => '%s Harus diisi.'
		                )
		        )
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable" style="margin:10px 20px;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="ti-alert pr-15"></i>', '</div>');

	    if ($this->form_validation->run() === FALSE)
	    {
	    	$this->session->set_flashdata('error', validation_errors());
	    	redirect('ademik/useraccess/editadminmahasiswa/'.$id);
	    }
	    else
	    {
	    	if($this->input->post('Password')==""){
	    		$data = array(
	    			'ID' => $id,
			        'Description' => $this->user_model->db->escape_str($this->input->post('Description')),
			       	'Name' => $this->user_model->db->escape_str($this->input->post('full_name')),
			       	'Email' => $this->user_model->db->escape_str($this->input->post('Email')),
			       	'Phone' => $this->user_model->db->escape_str($this->input->post('Phone')),
			       	'NotActive' => $this->user_model->db->escape_str($this->input->post('NotActive'))
			    );
				
			 	$this->user_model->update($data, '_v2_mhsw');   	
	    	}else{
	    		$data = array(
	    			'ID' => $id,
			        'Password' => $this->user_model->db->escape_str($this->input->post('Password')),
			        'Description' => $this->user_model->db->escape_str($this->input->post('Description')),
			       	'Name' => $this->user_model->db->escape_str($this->input->post('full_name')),
			       	'Email' => $this->user_model->db->escape_str($this->input->post('Email')),
			       	'Phone' => $this->user_model->db->escape_str($this->input->post('Phone')),
			       	'NotActive' => $this->user_model->db->escape_str($this->input->post('NotActive')),
			       	'count_edit_password' => '0'
			    );
				
			 	$this->user_model->updatePassword($data, '_v2_mhsw');
	    	}
			
			$dataLog = array(
		        'username' => $this->user_model->db->escape_str($this->input->post('Login')),
		        'user_category' => 'Mahasiswa',
		       	'user_created' => $this->session->uname,
		       	'date_created' => date("Y-m-d H:i:s"),
		       	'ip_address' => $this->input->ip_address(),
		       	'status' => 'Edit'
		    );
			
		 	$this->user_model->insertLog($dataLog, '_v2_log_user');

	        redirect('ademik/useraccess/mahasiswa');
	    }		
	}

	public function deleteadmin()
	{
		$id=$this->user_model->db->escape_str($this->input->post('login'));
		
		$this->user_model->deleteData($id,'_v2_adm');

		$dataLog = array(
	        'username' => $this->user_model->db->escape_str($this->input->post('login')),
	        'user_category' => 'Admin SU',
	       	'user_created' => $this->session->uname,
	       	'date_created' => date("Y-m-d H:i:s"),
	       	'ip_address' => $this->input->ip_address(),
	       	'status' => 'Delete'
	    );
		
	 	$this->user_model->insertLog($dataLog, '_v2_log_user');
    }	

	public function deleteadminpusat()
	{
		$id=$this->user_model->db->escape_str($this->input->post('login'));
		
		$this->user_model->deleteData($id,'_v2_adm_pusat');

		$dataLog = array(
	        'username' => $this->user_model->db->escape_str($this->input->post('login')),
	        'user_category' => 'Admin Pusat',
	       	'user_created' => $this->session->uname,
	       	'date_created' => date("Y-m-d H:i:s"),
	       	'ip_address' => $this->input->ip_address(),
	       	'status' => 'Delete'
	    );
		
	 	$this->user_model->insertLog($dataLog, '_v2_log_user');
    }	

	public function deleteadminfak()
	{
		$id=$this->user_model->db->escape_str($this->input->post('login'));
		
		$this->user_model->deleteData($id,'_v2_adm_fak');

		$dataLog = array(
	        'username' => $this->user_model->db->escape_str($this->input->post('login')),
	        'user_category' => 'Fakultas',
	       	'user_created' => $this->session->uname,
	       	'date_created' => date("Y-m-d H:i:s"),
	       	'ip_address' => $this->input->ip_address(),
	       	'status' => 'Delete'
	    );
		
	 	$this->user_model->insertLog($dataLog, '_v2_log_user');
    }	

	public function deleteadminjur()
	{
		$id=$this->user_model->db->escape_str($this->input->post('login'));
		
		$this->user_model->deleteData($id,'_v2_adm_jur');

		$dataLog = array(
	        'username' => $this->user_model->db->escape_str($this->input->post('login')),
	        'user_category' => 'Jurusan',
	       	'user_created' => $this->session->uname,
	       	'date_created' => date("Y-m-d H:i:s"),
	       	'ip_address' => $this->input->ip_address(),
	       	'status' => 'Delete'
	    );
		
	 	$this->user_model->insertLog($dataLog, '_v2_log_user');
    }	

	public function deleteadmindosen()
	{
		$id=$this->user_model->db->escape_str($this->input->post('login'));
		
		$this->user_model->deleteData($id,'_v2_dosen');

		$dataLog = array(
	        'username' => $this->user_model->db->escape_str($this->input->post('login')),
	        'user_category' => 'Dosen',
	       	'user_created' => $this->session->uname,
	       	'date_created' => date("Y-m-d H:i:s"),
	       	'ip_address' => $this->input->ip_address(),
	       	'status' => 'Delete'
	    );
		
	 	$this->user_model->insertLog($dataLog, '_v2_log_user');
    }	

	public function deleteadminmahasiswa()
	{
		$id=$this->user_model->db->escape_str($this->input->post('login'));
		
		$this->user_model->deleteData($id,'_v2_mhsw');

		$dataLog = array(
	        'username' => $this->user_model->db->escape_str($this->input->post('login')),
	        'user_category' => 'Mahasiswa',
	       	'user_created' => $this->session->uname,
	       	'date_created' => date("Y-m-d H:i:s"),
	       	'ip_address' => $this->input->ip_address(),
	       	'status' => 'Delete'
	    );
		
	 	$this->user_model->insertLog($dataLog, '_v2_log_user');
    }	





	
	public function adminmahasiswa() { // nama controllernya adminmahasiswa harus sama dengan nama viewnya untuk memudahkan
		$content = "ademik/useraccess/useraccess/adminmahasiswa";
		$this->load->view('temp/head');
		$this->load->view($content);
		$this->load->view('temp/footers');
	}

	
}