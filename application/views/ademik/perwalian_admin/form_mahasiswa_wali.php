<?php 
	$nim 	= $data_krs[0]['NIM'];
	$KodeMK = $data_krs[0]['KodeMK'];
 ?>

<table style="margin-bottom: 20px;">
	<tr>
		<th style="width: 200px;">Nama Mahasiswa</th>
		<th style="width: 10px;"> : </th>
		<td><?php echo $data_nama_mahasiswa; ?></td>
	</tr>	
	<tr>
		<th>NIM</th>
		<th> : </th>
		<td><?php echo $data_krs[0]['NIM']; ?></td>
	</tr>	
	<tr>
		<th>IP Semester </th>
		<th> : </th>
		<td><?php echo $data_khs[0]['IPS']; ?></td>
	</tr>
	<tr>
		<th>SKS Lulus </th>
		<th> : </th>
		<td><?php echo $data_khs[0]['SKSLulus']; ?></td>
	</tr>
	<tr>
		<th>IP Kumulatif </th>
		<th> : </th>
		<td><?php echo $data_khs[0]['IPK']; ?></td>
	</tr>
	<tr>
		<th>Jumlah SKS Kumulatif </th>
		<th> : </th>
		<td><?php echo $data_khs[0]['TotalSKSLulus']; ?></td>
	</tr>	
	<tr>
		<th>Semester Akademik </th>
		<th> : </th>
		<td><?= $Tahun; ?></td>
	</tr>
</table>
<hr>
<dl class="row mt-2 mb-0">
	<dt class="col-sm-3">Batas Ber-KRS</dt>
	<dd class="col-sm-9">
	: <?= $batas_krs ?>
	</dd>
	<dt class="col-sm-3">Batas Ubah KRS</dt>
	<dd class="col-sm-9">
	: <?= $batas_ubah_krs?>
	</dd>
</dl>

<?php if(!checkLimitKrs(getMajorCollege($data_krs[0]['NIM']))){?>
	<small class="text-danger text-small">*Batas Perubahan KRS sudah tutup, silahkan hubungi admin fakultas untuk pembukaan batas KRS</small>
<?php } ?>

<table class="table table-bordered table-striped table-responsive nowrap dt-head-right" id="form_mahasiswa_wali">
	<thead>
		<tr>
			<th>Kode MK</th>
			<th>Mata kuliah</th>
			<th>SKS</th>
			<?php if(checkLimitKrs(getMajorCollege($data_krs[0]['NIM']))){?>
				<th>Terima</th>							
				<th>Tolak</th>	
			<?php } ?>
			<th>Status Matakuliah</th>			
		</tr>
	</thead>
	<tbody>
		<?php $radio = 0; $i = 1; foreach ($data_krs as $krs) {?>
		<tr>
			<td><?php echo $krs['KodeMK']; ?></td>
			<td><?php echo $krs['NamaMK']; ?></td>
			<td><?php echo $krs['SKS']; ?></td>
			<?php if(checkLimitKrs(getMajorCollege($data_krs[0]['NIM']))){?>
				<td>
					<div class="radio">
						<input name="<?= $krs['KodeMK']."_group_"?>" type="radio" id="<?= $krs['KodeMK']?>_Option_1" required <?php if ($krs ['st_wali'] == '1'){ echo "checked";} ?> onclick="validasi_mk('<?= $nim;?>', '<?= $krs['KodeMK'] ; ?>','<?= $krs['IDJadwal'] ; ?>', 1)" >
						<label for="<?php echo $krs['KodeMK']?>_Option_1">Terima</label>
					</div>
				</td>
				<td>
					<div class="radio">
						<input name="<?= $krs['KodeMK']."_group_"?>" type="radio" id="<?php echo $krs['KodeMK']?>_Option_2" required <?php if ($krs ['st_wali'] == '0'){ echo "checked";} ?> onclick="validasi_mk('<?= $nim;?>', '<?= $krs['KodeMK']  ; ?>', '<?= $krs['IDJadwal'] ; ?>', '0')" style="width: 30px;">
						<label for="<?php echo $krs['KodeMK']?>_Option_2">Tolak</label>
					</div>
				</td>
			<?php } ?>
			
			<td>
				<?php if ($krs ['st_wali'] == '1') {?>
				diterima
				<?php }else{ ?>
				ditolak
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>


<?php if(!checkLimitKrs(getMajorCollege($data_krs[0]['NIM']))){?>
	<small class="text-danger text-small">*Tekan Tombol simpan untuk menutup</small>
<?php }else{ ?>
	<small class="text-danger text-small">*Status matakulaih akan berubah setelah menekan tombol simpan</small>
<?php }?>

<script type="text/javascript">
    $('#form_mahasiswa_wali').DataTable({
    	"lengthMenu": [[5, 10, -1], [5, 10,"All"]]
    });


	function validasi_mk(nim, KodeMK, IDjadwal, st_wali) {

		$.post(
			"<?= base_url('ademik/Perwalian_admin/validasi_mk'); ?>",
			{
				nim 		: nim, 
				KodeMK		: KodeMK, 
				idjadwal	: IDjadwal, 
				st_wali		: st_wali,
				tahun 		: "<?= $Tahun?>",
				name 		: "<?= $data_nama_mahasiswa?>"
			})
		.done(function (response) {
			if(response == "full"){
				error_alert("Mohon maaf", "Kelas sudah full");
			}
		})
		.fail(function () {
			error_alert();
		});
	}

	function load_tabel_mahasiswa_wali() {
		loading_alert();
		location.reload();
 	}

</script>