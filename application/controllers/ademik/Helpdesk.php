<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

class Helpdesk extends CI_Controller {

	function __construct() {
		parent::__construct();
		//$this->load->library('form_validation');
		$this->load->library('encryption');
		//$this->load->helper('security');
		$this->load->model('helpdesk_model');
		$this->load->model('telegram');
		//$this->load->helper('file');
	}

	public function index() {
		
		$ulevel = $this->session->userdata('ulevel');
		
		if($ulevel == 1){
			
			$body = $this->inbox_awal();
			
			$data['subjecthelpdesk'] = $body;
			
		} else if($ulevel == 5){
			$data['subjecthelpdesk'] = $this->helpdesk_model->get_helpdesk();
			
			$unip = $this->session->userdata("unip");

			$this->db->from('_v2_adm_fak');
			
			$this->db->where('Login',$unip);
			
			$this->db->where('NotActive','N');
			
			$this->db->where('id_telegram !=','');

			$data['id_telegram'] = $this->db->get()->result();
		}

		$this->load->view('dashbord',$data);

		/*$data['berita'] = $this->additional_model->getListBerita();
		$data['kategori'] = $this->additional_model->getListBeritaKategori();
		$data['footerSection'] = "<script type='text/javascript'>
 				$('#berita').dataTable( {
    				'order': [2,'desc']
				} );
		    </script>";

		$this->load->view('dashbord',$data);*/

	}

	public function inbox_awal() {
		$data = $this->helpdesk_model->get_helpdesk();

		$string = "";

		foreach ($data as $key) {
			$string .= "<tr>
				<td><input type='checkbox'></td>
				<td class='mailbox-star'><a onClick='readmessage(".$key->id.")' href='#'><i class='fa fa-star text-yellow'></i></a></td>
				<td class='mailbox-name'>".$key->user_pengirim."</td>
				<td class='mailbox-subject'><a onClick='readmessage(".$key->id.")' href='#'><b>".substr($key->pesan,0,20)."...</b></a>
				</td>
				<td class='mailbox-attachment'></td>
				<td class='mailbox-date'>".$key->tgl_laporan."</td>
			</tr>";
		}

		return "<div class='box box-primary'>
			<div class='box-header with-border'>
				<h3 class='box-title'>Inbox</h3>

				<div class='box-tools pull-right'>
					<div class='has-feedback'>
						<input type='text' class='form-control input-sm' placeholder='Search'>
					</div>
				</div>
				<!-- /.box-tools -->
			</div>
			<!-- /.box-header -->
			<div class='box-body no-padding'>
				<div class='mailbox-controls'>
					<!-- Check all button -->
					<button type='button' class='btn btn-default btn-outline btn-sm checkbox-toggle'><i class='ion ion-android-checkbox-outline-blank'></i>
					</button>
					<div class='btn-group'>
						<button type='button' class='btn btn-default btn-outline btn-sm'><i class='ion ion-trash-a'></i></button>
						<button type='button' class='btn btn-default btn-outline btn-sm'><i class='ion ion-reply'></i></button>
						<button type='button' class='btn btn-default btn-outline btn-sm'><i class='ion ion-share'></i></button>
					</div>
					<!-- /.btn-group -->
					<div class='btn-group'>
		<div class='btn-group'>
		<button type='button' class='btn btn-default btn-outline btn-sm dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
				<i class='ion ion-flag margin-r-5'></i>
			<span class='caret'></span>
		</button>
		<div class='dropdown-menu'>
				<a class='dropdown-item' href='#'>Action</a>
			<a class='dropdown-item' href='#'>Another action</a>
			<a class='dropdown-item' href='#'>Something else here</a>
		</div>
		</div>
		<div class='btn-group'>
		<button type='button' class='btn btn-default btn-outline btn-sm dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
				<i class='ion ion-folder margin-r-5'></i>
			<span class='caret'></span>
		</button>
		<div class='dropdown-menu'>
				<a class='dropdown-item' href='#'>Action</a>
			<a class='dropdown-item' href='#'>Another action</a>
			<a class='dropdown-item' href='#'>Something else here</a>
		</div>
		</div>
	</div>
					<!-- /.btn-group -->
					<button type='button' class='btn btn-default btn-outline btn-sm'><i class='fa fa-refresh'></i></button>
					<div class='pull-right'>
						1-50/200
						<div class='btn-group'>
							<button type='button' class='btn btn-default btn-outline btn-sm'><i class='fa fa-chevron-left'></i></button>
							<button type='button' class='btn btn-default btn-outline btn-sm'><i class='fa fa-chevron-right'></i></button>
						</div>
						<!-- /.btn-group -->
					</div>
					<!-- /.pull-right -->
				</div>
				<div class='mailbox-messages'>
					<table class='table table-hover table-striped table-responsive'>
						<tbody>
						$string
					</table>
					<!-- /.table -->
				</div>
				<!-- /.mail-box-messages -->
			</div>
			<!-- /.box-body -->
			<div class='box-footer no-padding'>
				<div class='mailbox-controls'>
					<!-- Check all button -->
					<button type='button' class='btn btn-default btn-outline btn-sm checkbox-toggle'><i class='ion ion-android-checkbox-outline-blank'></i>
					</button>
					<div class='btn-group'>
						<button type='button' class='btn btn-default btn-outline btn-sm'><i class='ion ion-trash-a'></i></button>
						<button type='button' class='btn btn-default btn-outline btn-sm'><i class='ion ion-reply'></i></button>
						<button type='button' class='btn btn-default btn-outline btn-sm'><i class='ion ion-share'></i></button>
					</div>
					<!-- /.btn-group -->
					<div class='btn-group'>
						<div class='btn-group'>
							<button type='button' class='btn btn-default btn-outline btn-sm dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
									<i class='ion ion-flag margin-r-5'></i>
								<span class='caret'></span>
							</button>
							<div class='dropdown-menu'>
									<a class='dropdown-item' href='#'>Action</a>
								<a class='dropdown-item' href='#'>Another action</a>
								<a class='dropdown-item' href='#'>Something else here</a>
							</div>
							</div>
							<div class='btn-group'>
							<button type='button' class='btn btn-default btn-outline btn-sm dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
									<i class='ion ion-folder margin-r-5'></i>
								<span class='caret'></span>
							</button>
							<div class='dropdown-menu'>
									<a class='dropdown-item' href='#'>Action</a>
								<a class='dropdown-item' href='#'>Another action</a>
								<a class='dropdown-item' href='#'>Something else here</a>
							</div>
						</div>
					</div>
					<!-- /.btn-group -->
					<button type='button' class='btn btn-default btn-outline btn-sm'><i class='fa fa-refresh'></i></button>
					<div class='pull-right'>
						1-50/200
						<div class='btn-group'>
							<button type='button' class='btn btn-default btn-outline btn-sm'><i class='fa fa-chevron-left'></i></button>
							<button type='button' class='btn btn-default btn-outline btn-sm'><i class='fa fa-chevron-right'></i></button>
						</div>
						<!-- /.btn-group -->
					</div>
					<!-- /.pull-right -->
				</div>
			</div>
		</div>";
	}
	
	public function kirim_text() {

		$kategori = $this->input->post('kategori');
		$subject = $this->input->post('subject');
		$uraian = $this->input->post('uraian');
		$foto = $_FILES['foto']['tmp_name'];

		$TOKEN  = "650017496:AAGQ2b6vZuvgQDglfSF5cIeexVMglqOHPQQ";  // ganti token ini dengan token bot mu
		$chatid = "653194938"; // ini id saya di telegram fandu silakan diganti dan disesuaikan
		//$pesan 	= "Helo fandu siakad baru tes 12345";
		$pesan 	= $uraian;
		// ----------- code -------------
		$method	= "sendMessage";
		$url    = "https://api.telegram.org/bot" . $TOKEN . "/". $method;
		$post = [
		 'chat_id' => $chatid,
		 // 'parse_mode' => 'HTML', // aktifkan ini jika ingin menggunakan format type HTML, bisa juga diganti menjadi Markdown
		 'text' => $pesan
		];
		$header = [
		 "X-Requested-With: XMLHttpRequest",
		 "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36"
		];
		// hapus 1 baris ini:
		//die('Hapus baris ini sebelum bisa berjalan, terimakasih.');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_REFERER, $refer);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$datas = curl_exec($ch);
		$error = curl_error($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$debug['text'] = $pesan;
		$debug['code'] = $status;
		$debug['status'] = $error;
		$debug['respon'] = json_decode($datas, true);
		//print_r($debug);
		/* output debug send text
			Array (
				[text] => bbbbbbbbbbb
				[code] => 200
				[status] =>
				[respon] => Array (
							[ok] => 1
							[result] => Array (
								[message_id] => 39
								[from] => Array (
									[id] => 650017496
									[is_bot] => 1
									[first_name] => SIAKAD UNTAD
									[username] => siakaduntadbot
								)
								[chat] => Array (
									[id] => 653194938
									[first_name] => Fandu
									[last_name] => Pratama
									[type] => private
								)
								[date] => 1544625472
								[text] => bbbbbbbbbbb
							)
				)
			)
		*/
		$this->session->set_flashdata('message_text',"Pesan Berhasil di Kirim");

		if (!empty($foto)){
			$this->kirim_foto($TOKEN, $foto, $chatid);
		}
		
		$unip = $this->session->userdata('unip');
		$dataSukses = array(
			'user_pengirim' => $unip,
			'subject' => $subject,
			'pesan' => $pesan,
			'id_reg_pesan' => $this->encryption->encrypt($unip." - ".$subject." - ".$pesan)
		);

		$dataClean = $this->security->xss_clean($dataSukses);
		$this->db->set('tgl_laporan', 'NOW()', FALSE);
		$this->db->insert('_v2_helpdesk',$dataClean);

		redirect(base_url($this->session->userdata('sess_tamplate')));

	}

	private function kirim_foto($TOKEN, $foto, $chatid) {
		/*
		KALAU SUKSESS
		Array
		(
			[text] => /tmp/phpMQqm6b
			[code] => 400
			[status] =>
			[respon] => Array
				(
					[ok] =>
					[error_code] => 400
					[description] => Bad Request: wrong remote file id specified: Wrong character in the string
				)

		)

		KALAU TIDAK SUKSESS
		Array
		(
			[text] =>
			[code] => 400
			[status] =>
			[respon] => Array
				(
					[ok] =>
					[error_code] => 400
					[description] => Bad Request: there is no photo in the request
				)
		)
		*/

		$bottoken_image = "650017496:AAGQ2b6vZuvgQDglfSF5cIeexVMglqOHPQQ/sendPhoto?chat_id=653194938";
		$website_image = "https://api.telegram.org/bot".$bottoken_image;

		$TOKEN  = "650017496:AAGQ2b6vZuvgQDglfSF5cIeexVMglqOHPQQ";  // ganti token ini dengan token bot mu
		$chatid = "653194938"; // ini id saya di telegram fandu silakan diganti dan disesuaikan


		$bot_url    = "https://api.telegram.org/bot$TOKEN/";
		$url        = $bot_url . "sendPhoto" ;

		$post_fields = array(
			'chat_id'   => $chatid,
			'photo'     => new CURLFile(realpath($foto))
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Content-Type:multipart/form-data"
		));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
		$output = curl_exec($ch);
		//print($output);
		$this->session->set_flashdata('message_foto',"Foto Berhasil di Kirim");
	}

	public function detailpesan(){

		$act = $this->input->post('act');

		$getdetail_helpdesk = $this->helpdesk_model->getdetail_helpdesk($act);
		$get_user_helpdesk = $this->helpdesk_model->get_user_helpdesk($act);

		$foto = base_url()."/assets/images/laki.png";
		$isipesan = "";

		foreach ($getdetail_helpdesk as $isi) {
			$isipesan .= "
			<!-- /.box-comment -->
			<div class='box-comment'>
				<!-- User image -->
				<img class='rounded img-sm' src='$foto' alt='User Image'>

				<div class='comment-text'>
							<span class='username'>
								".$isi->id_user_balas."
								<span class='text-muted pull-right'>-</span>
							</span><!-- /.username -->
					".$isi->pesan."
				</div>
				<!-- /.comment-text -->
			</div>";
		}
		
		// untuk mengecek apakah ada komentar atau tidak
		$isitext = "";
		if (!empty($isipesan)){
			$isitext = "<div class='box-footer box-comments'>
					$isipesan
				</div>";
		}

		$user = $get_user_helpdesk->user_pengirim;
		$pesan = $get_user_helpdesk->pesan;

		$image = "";
		if(!empty($get_user_helpdesk->image)){
			$image = "
			<div class='attachment-block clearfix'>
				<img class='attachment-img' src='$foto' alt='Attachment Image'>

				<div class='attachment-pushed'>
					<h5 class='attachment-heading'><a href='#'>Featured Hydroflora Pots Garden & Outdoors</a></h5>

					<div class='attachment-text'>
						Lorem Ipsum is simply dummy text of the printing & type setting industry... <a href='#'>more</a>
					</div>
					<!-- /.attachment-text -->
				</div>
				<!-- /.attachment-pushed -->
			</div>";
		}

		$social = "";
		/*
		$social = "<button type='button' class='btn btn-default btn-sm bg-blue-active'><i class='fa fa-share'></i> Share</button>
		<button type='button' class='btn btn-default btn-sm bg-green-active'><i class='fa fa-thumbs-o-up'></i> Like</button>
		<span class='pull-right text-muted'>84 likes - 2 comments</span>"
		*/

		/*echo "<!-- /.box-header -->
			<div class='box-body'>
					<table id='example2' class='table table-bordered table-striped table-responsive'>
						<thead>
							<tr>
									<th>User</th>
									<th>Pesan</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>User</th>
								<th>Pesan</th>
							</tr>
						</tfoot>
						<tbody>
							$isipesan
						</tbody>
					</table>
			</div>
		<!-- /.box-body -->";*/

		echo "
				<div class='box-header with-border'>
					<div class='user-block'>
						<img class='rounded' src='$foto' alt='User Image'>
						<span class='username'><a href='#'>$user</a></span>
						<span class='description'> - </span>
					</div>
					<!-- /.user-block -->
					<div class='box-tools'>
						<button type='button' class='btn btn-box-tool' data-toggle='tooltip' title='Mark as read'>
							<i class='fa fa-comments-o'></i></button>
						<button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i>
						</button>
						<button type='button' class='btn btn-box-tool' data-widget='remove'><i class='fa fa-times'></i></button>
					</div>
					<!-- /.box-tools -->
				</div>
				<!-- /.box-header -->
				<div class='box-body'>
					<!-- post text -->
					<p>$pesan</p>
					<!-- Attachment -->
					$image
					<!-- /.attachment-block -->

					<!-- Social sharing buttons -->
					$social
				</div>
				<!-- /.box-body -->
				$isitext
				<!-- /.box-footer -->
				<div class='box-footer'>
					<form action='".base_url()."ademik/helpdesk/komentarfakultas' method='post'>
						<img class='img-fluid rounded img-sm' src='$foto' alt='Alt Text'>
						<!-- .img-push is used to add margin to elements next to floating images -->
						<div class='img-push'>
							<input type='hidden' value='".$get_user_helpdesk->id."' name='id_helpdesk' readonly>
							<input type='text' name='komentar' class='form-control input-sm' placeholder='Press enter to post comment'>
						</div>
					</form>
				</div>
				<!-- /.box-footer -->
			";

	}

	public function inbox(){
		echo $this->inbox_awal();
	}
	
	public function readmessage(){
		
		$act = $this->input->post('act');
		
		$get_user_helpdesk = $this->helpdesk_model->get_user_helpdesk($act);
		
		$foto = base_url()."/assets/images/laki.png";
		
		$getdetail_helpdesk = $this->helpdesk_model->getdetail_helpdesk($act);

		$isipesan = "";

		foreach ($getdetail_helpdesk as $isi) {
			$isipesan .= "
			<!-- /.box-comment -->
			<div class='box-comment'>
				<!-- User image -->
				<img class='rounded img-sm' src='$foto' alt='User Image'>

				<div class='comment-text'>
							<span class='username'>
								".$isi->id_user_balas."
								<span class='text-muted pull-right'>-</span>
							</span><!-- /.username -->
					".$isi->pesan."
				</div>
				<!-- /.comment-text -->
			</div>";
		}
		
		$isikomentar = "";
		if (!empty($isipesan)){
			$isikomentar = "<div class='box-footer box-comments'>
					$isipesan
				</div>";
		}
		
		$getidtelegram = $this->db->query("select * from _v2_adm_fak where Login = '".$get_user_helpdesk->user_pengirim."' and NotActive='N'")->row();
		
		echo "<div class='box box-primary'>
            <div class='box-header with-border'>
              <h3 class='box-title'>Read Mail</h3>

              <div class='box-tools pull-right'>
                <a href='#' class='btn btn-box-tool' data-toggle='tooltip' title='Previous'><i class='fa fa-chevron-left'></i></a>
                <a href='#' class='btn btn-box-tool' data-toggle='tooltip' title='Next'><i class='fa fa-chevron-right'></i></a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class='box-body no-padding'>
              <div class='mailbox-read-info'>
                <h3>Your message title goes here</h3>
              </div>
              <div class='mailbox-read-info clearfix'>
				<div class='left-float margin-r-5'><a href='#'><img src='$foto' alt='user' width='40' class='rounded-circle'></a></div>
                <h5 class='no-margin'>".$get_user_helpdesk->user_pengirim."<br>
                     <!--<small>From: jonathan@domain.com</small>-->
                  <span class='mailbox-read-time pull-right'> - </span></h5>
              </div>
              <!-- /.mailbox-read-info -->
              <!--<div class='mailbox-controls with-border clearfix'>                
                <div class='left-float'>
                  <button type='button' class='btn btn-default btn-outline btn-sm' data-toggle='tooltip' title='Print'>
                  <i class='fa fa-print'></i></button>
                </div>
                <div class='right-float'>
                <div class='btn-group'>
                  <button type='button' class='btn btn-default btn-outline btn-sm' data-toggle='tooltip' data-container='body' title='Delete'>
                    <i class='fa fa-trash-o'></i></button>
                  <button type='button' class='btn btn-default btn-outline btn-sm' data-toggle='tooltip' data-container='body' title='Reply'>
                    <i class='fa fa-reply'></i></button>
                  <button type='button' class='btn btn-default btn-outline btn-sm' data-toggle='tooltip' data-container='body' title='Forward'>
                    <i class='fa fa-share'></i></button>
                </div>
                </div>
                <!-- /.btn-group -1->
                
              </div>-->
              <!-- /.mailbox-controls -->
              <div class='mailbox-read-message'>
                ".$get_user_helpdesk->pesan."
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.box-body -->
            <div class='box-footer'>
             	<h5><i class='fa fa-paperclip m-r-10 m-b-10'></i> Komentar <span></span></h5>
              <ul class='mailbox-attachments clearfix'>
			  
				$isikomentar
				
				<div class='box-footer'>
					<form action='".base_url()."ademik/helpdesk/komentarsuperuser' method='post'>
						<img class='img-fluid rounded img-sm' src='$foto' alt='Alt Text'>
						<!-- .img-push is used to add margin to elements next to floating images -->
						<div class='img-push'>
							<input type='hidden' value='".$getidtelegram->id_telegram."' name='idtel' readonly>
							<input type='hidden' value='".$get_user_helpdesk->id."' name='id_helpdesk' readonly>
							<input type='text' name='komentar' class='form-control input-sm' placeholder='Press enter to post comment'>
						</div>
					</form>
				</div>
              </ul>
            </div>
            <!-- /.box-footer -1->
            <div class='box-footer'>
              <div class='pull-right'>
                <button type='button' class='btn btn-success'><i class='fa fa-reply'></i> Reply</button>
                <button type='button' class='btn btn-info'><i class='fa fa-share'></i> Forward</button>
              </div>
              <button type='button' class='btn btn-danger'><i class='fa fa-trash-o'></i> Delete</button>
              <button type='button' class='btn btn-warning'><i class='fa fa-print'></i> Print</button>
            </div>
            <!-- /.box-footer -1->
          </div>
          <!-- /. box -->";
	}
	
	public function setbot(){
		//$this->telegram->send->chat("653194938")->text("Hello world 12345234 !")->send();
		
		if($this->telegram->text_has("12")){
		  $this->telegram->send
			->text("Yes!")
		  ->send();
		}
		
	}
	
	public function komentarfakultas(){
		$idtel = "653194938";
		$id_helpdesk = $this->input->post('id_helpdesk');
		$komentar = $this->input->post('komentar');
		$unip = $this->session->userdata('unip');
		
		$dataSukses = array(
			'id_helpdesk' => $id_helpdesk,
			'pesan' => $komentar,
			'id_user_balas' => $unip
		);

		$dataClean = $this->security->xss_clean($dataSukses);
		$this->db->insert('_v2_helpdesk_detail',$dataClean);
		
		$this->kirim_pesan_fakultas($idtel, $komentar);
		
		redirect(base_url('ademik/helpdesk'));
	}
	
	public function komentarsuperuser(){
		$idtel = $this->input->post('idtel');
		$id_helpdesk = $this->input->post('id_helpdesk');
		$komentar = $this->input->post('komentar');
		$unip = $this->session->userdata('unip');
		
		$dataSukses = array(
			'id_helpdesk' => $id_helpdesk,
			'pesan' => $komentar,
			'id_user_balas' => $unip
		);

		$dataClean = $this->security->xss_clean($dataSukses);
		$this->db->insert('_v2_helpdesk_detail',$dataClean);
		
		$data = array(
			'user_balasan' => $unip,
			'status_error' => 'proses'
		);

		$dataupdate = $this->security->xss_clean($data);
		$this->db->where('ID',$id_helpdesk);
		$this->db->update('_v2_helpdesk',$dataupdate);
		
		$this->kirim_pesan_fakultas($idtel, $komentar);
		
		redirect(base_url('ademik/helpdesk'));
	}
	
	public function getverivikasicode(){
		$id_telegram = $this->input->post('idtelegram');
		$random = rand(100,99999);
		$uraian = "Kode Verivikasi Anda $random";
		
		$this->kirim_pesan_fakultas($id_telegram, $uraian);
		
		$this->session->set_flashdata('codeverivikasi',"$id_telegram");
		
		////////////////////////////
		$unip = $this->session->userdata("unip");
		
		$telegram = array(
			'verivikasi_telegram' => $random
		);

		$this->db->where('Login', $unip);
		
		$this->db->update('_v2_adm_fak',$telegram);
		////////////////////////////
		
		redirect(base_url()."ademik/helpdesk");
	}
	
	public function verivikasicode(){
		$id_telegram = $this->input->post('idtelegram');
		$codeverivikasi = $this->input->post('codeverivikasi');
		
		///////////////////////////////////////
		$unip = $this->session->userdata("unip");

		$this->db->from('_v2_adm_fak');
		
		$this->db->where('Login', $unip);
		
		$this->db->where('NotActive','N');
		
		$this->db->where('verivikasi_telegram', $codeverivikasi);

		$result = $this->db->get()->num_rows();
		/////////////////////////////////////////
		
		if($result){
			$uraian = "ID Anda berhasi Terverivikasi";
			$telegram = array(
				'id_telegram' => $id_telegram
			);

			$this->db->where('Login', $unip);
			$this->db->where('verivikasi_telegram', $codeverivikasi);
			
			$this->db->update('_v2_adm_fak',$telegram);
		} else {
			$uraian = "Kode Verivikasi Anda Salah, Silahkan Ulangi Kembali";
		}
		
		$this->kirim_pesan_fakultas($id_telegram, $uraian);
		
		redirect(base_url()."ademik/helpdesk");
	}
	
	public function kirim_pesan_fakultas($chatid, $uraian) {

		$TOKEN  = "650017496:AAGQ2b6vZuvgQDglfSF5cIeexVMglqOHPQQ";  // ganti token ini dengan token bot mu
		//$pesan 	= "Helo fandu siakad baru tes 12345";
		$pesan 	= $uraian;
		// ----------- code -------------
		$method	= "sendMessage";
		$url    = "https://api.telegram.org/bot" . $TOKEN . "/". $method;
		$post = [
		 'chat_id' => $chatid,
		 // 'parse_mode' => 'HTML', // aktifkan ini jika ingin menggunakan format type HTML, bisa juga diganti menjadi Markdown
		 'text' => $pesan
		];
		$header = [
		 "X-Requested-With: XMLHttpRequest",
		 "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36"
		];
		// hapus 1 baris ini:
		//die('Hapus baris ini sebelum bisa berjalan, terimakasih.');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_REFERER, $refer);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$datas = curl_exec($ch);
		$error = curl_error($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$debug['text'] = $pesan;
		$debug['code'] = $status;
		$debug['status'] = $error;
		$debug['respon'] = json_decode($datas, true);
	}

}

/*
<?php
	$no=1;
	foreach ($tabel_kurikulum as $data) { ?>
	<tr>
			<td><?=$no++?></td>
			<td><a href='javascript:;' onclick='edit('<?=$data->ID?>')'><?=$data->Nama?></a></td>
			<td><?=$data->Tahun?></td>
			<td>

				<?php if ( $data->NotActive == 'N' ) {
					echo '<span style='color:blue; font-weight:bold;'>Aktif</span>';
				} else {
					echo 'Tidak Aktif';
				} ?>

			</td>
	</tr>
<?php } ?>
*/
