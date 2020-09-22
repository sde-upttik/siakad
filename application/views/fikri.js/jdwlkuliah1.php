<div id="listKrs" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">KRS Mahasiswa</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<h4>Pilih matakuliah yang sesuai dengan jadwal yang hilang mahasiswanya</h4>
				<input type="text" class="form-control col-md-10" id="idjadwalold" list="suggestions" name="idjadwalold">
				<datalist id="suggestions">
				</datalist>
			</div>
			<div class="modal-footer" id="mdlfooter">
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<script>
	if (getCookie('history')==1) {
		console.log('cookie history found.');
		$('#tahunakademik').val(getCookie('ta'));
		$('#program').val(getCookie('kp')).select2();
		$('#jurusan').val(getCookie('kj')).select2();
		$('#haris').val(getCookie('kh')).select2();
		go()
	}

	function cariMhsw(_jadwal) {
		
		$("#idjadwalold").prop( "disabled", false );
		$("#idjadwalold").val('');
		$( "#suggestions" ).html('');
		$("#mdlfooter").html('');
		var tahunakademik = $("#tahunakademik").val();
		var NIM = prompt("NIM : ");
		var url = "<?=base_url('ademik/jdwlkuliah1/getMkKrs') ?>";
		var post = {'NIM':NIM,'tahunakademik':tahunakademik};
		if (NIM) {
			$.post(url,post,function(respos) {
				var res = JSON.parse(respos);
				for (let i = 0; i < res.length; i++) {
					const mk = res[i]
					$( "#suggestions" ).append( "<option value='"+mk.IDJadwal+"'>"+mk.NamaMK+"</option>" );
				} 

				$("#listKrs").modal('show');
				$("#idjadwalold").change(function(){
					$("#idjadwalold").prop( "disabled", true );
					$("#mdlfooter").html("<button type='button' class='btn btn-danger waves-effect' onclick='GetMhsw(`"+_jadwal+"`)'>Kembalikan</button>")
				});
			})
		}else{
			GetMhsw(_jadwal);
		}
	}
		
	function GetMhsw(_jadwal) {
		$("#listKrs").modal('hide');
		var jdwlold = $("#idjadwalold").val();
		var tahunakademik = $("#tahunakademik").val();

		$('.modal_loading').html('Mencari...!<br>Mohon bersabar.');
		$body.addClass("loading");
	
		// console.log(_jadwal);
		var url = "<?=base_url('ademik/jdwlkuliah1/GetMhsw') ?>";
		if (jdwlold) {
			var post = {'IDJADWAL':_jadwal,'thnakdmk':tahunakademik,'jdwlold':jdwlold};
		}else{
			var post = {'IDJADWAL':_jadwal,'thnakdmk':tahunakademik};
		}

		$.post(url,post, function(respons){
			var res = JSON.parse(respons);
			$("#idjadwalold").val('')
			$body.removeClass("loading");
			$(".modal_loading").html("Loading..!!! Mohon menunggu ");
			// console.log(res.update);
				console.log(res);
			if (res.update) {
				go();
			}else{
				alert("mahasiswa tidak ditemukan");
				// console.log('else');
				// Swal.fire({
				//   icon: 'Gagal',
				//   title: 'Oops...',
				//   text: 'Mahasiswa Tidak ditemukan!',
				//   // footer: '<a href>Why do I have this issue?</a>'
				// })				
			}
		});

	}

</script>