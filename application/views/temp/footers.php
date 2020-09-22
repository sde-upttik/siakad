
<?php
function activeServer()
{
	
	switch ($_SERVER['REMOTE_ADDR']) {
		case '103.245.72.116':
			$server = 'cluster1';
			break;
		case '103.245.72.117':
			$server = 'cluster2';
			break;
		case '103.245.72.119':
			$server = 'cluster3';
			break;
		case '103.245.72.112':
			$server = 'cluster4';
			break;
		case '103.245.72.113':
			$server = 'cluster5';
			break;
		default :
			$server = $_SERVER['REMOTE_ADDR'];
		break;
	}	

	return $server;
}
?>
</div>
<div class="modal_loading">Loading..!!! Mohon menunggu </div> <!-- wawan -->
<footer class="main-footer">
    <div class="pull-right d-none d-sm-inline-block">
     <!-- <b>Version</b> 1.2.0 -->
    </div>Copyright &copy; 2017 <a href="<?=base_url()?>https://siakad.untad.ac.id">UPT. TIK</a>. Universitas Tadulako. </div>
		</div>
  </footer>
	<?php $this->load->view('temp/footers_js'); ?>
	<script>
	function tampilkan(halaman){
	//alert('masuk fandu '+halaman);
	//$('#loader').fadeIn('slow');
	$.ajax({
		//Note Fandu : Alamat disesuaikan dengan lokasi script
		url	     : '<?=base_url()?>menu/cm',
		type     : 'POST',
		dataType : 'html',
		data     : 'content='+halaman,
		success  : function(jawaban){
		//	alert('fandu masuk');
		//	alert(jawaban);
			$('#template').html(jawaban);
		//	alert(jawaban);
		},
	})
	}
	
	</script>
</body>
</html>
