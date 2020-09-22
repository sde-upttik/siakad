<div class="container">
	<h3>Data Mahasiswa Pindahan Keluar Universitas Tadulako</h3>
	<p><i>* Data mahasiswa berhasil tersimpan, berikut hasil data yang rekem oleh server :</i></p>
	<table>
		<tr>
			<th style="width: 200px">NIM</th>
			<td>:</td>
			<td><?php echo $data_mahasiswa_pindahan['NIM']; ?></td>
		</tr>		
		<tr>
			<th>Nama Lengkap</th>
			<td>:</td>
			<td><?php echo $data_mahasiswa_pindahan['Name']; ?></td>
		</tr>		
		<tr>
			<th>Fakultas</th>
			<td>:</td>
			<td><?php echo $data_mahasiswa_pindahan['Singkatan']; ?></td>
		</tr>		
		<tr>
			<th>Jurusan</th>
			<td>:</td>
			<td><?php echo $data_mahasiswa_pindahan['Nama_Indonesia']; ?></td>
		</tr>		
		<tr>
			<th>Alamat </th>
			<td>:</td>
			<td><?php echo $data_mahasiswa_pindahan['Alamat']; ?></td>
		</tr>		
		<tr>
			<th>Alamat Setelah Pindah </th>
			<td>:</td>
			<td><?php echo $data_mahasiswa_pindahan['AlamatSP']; ?></td>
		</tr>
		<tr>
			<th>Universitas Pindah </th>
			<td>:</td>
			<td><?php echo $data_mahasiswa_pindahan['UniversitasPindah']; ?></td>
		</tr>		
		<tr>
			<th>Alasan Pindah</th>
			<td>:</td>
			<td><?php echo $data_mahasiswa_pindahan['AlasanPindah']; ?></td>
		</tr>		
	</table>
	<hr>
	<div class="row" align="center">
		<button class="btn btn-primary btn-flat float-right" onclick="btn_back()">Kembali Ke Form Input</button>	
	</div>
</div>