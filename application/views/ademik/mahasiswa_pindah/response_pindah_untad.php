<div class="container">
	<h3>Data Mahasiswa Pindahan Ke Universitas Tadulako</h3>
	<p><i>* Data mahasiswa berhasil tersimpan, berikut hasil data yang rekem oleh server :</i></p>
	<table>
		<tr>
			<th style="width: 200px">NIM</th>
			<td>:</td>
			<td><?php echo $data_mahasiswa_pindahan[0]['NIM']; ?></td>
		</tr>		
		<tr>
			<th>Nama Lengkap</th>
			<td>:</td>
			<td><?php echo $data_mahasiswa_pindahan[0]['Name']; ?></td>
		</tr>		
		<tr>
			<th>Nama Ibu kandung</th>
			<td>:</td>
			<td><?php echo $data_mahasiswa_pindahan[0]['NamaIbu']; ?></td>
		</tr>		
		<tr>
			<th>Tempat Lair </th>
			<td>:</td>
			<td><?php echo $data_mahasiswa_pindahan[0]['TempatLahir']; ?></td>
		</tr>		
		<tr>
			<th>Tahun Masuk </th>
			<td>:</td>
			<td><?php echo $data_mahasiswa_pindahan[0]['TahunStatus']; ?></td>
		</tr>		
		<tr>
			<th>Tahun Angkatan</th>
			<td>:</td>
			<td><?php echo $data_mahasiswa_pindahan[0]['TahunAkademik']; ?></td>
		</tr>		
		<tr>
			<th>Fakultas</th>
			<td>:</td>
			<td><?php echo $data_mahasiswa_pindahan[0]['KodeFakultas']; ?></td>
		</tr>		
		<tr>
			<th>Jurusan</th>
			<td>:</td>
			<td><?php echo $data_mahasiswa_pindahan[0]['KodeJurusan']; ?></td>
		</tr>		
		<tr>
			<th>Username</th>
			<td>:</td>
			<td><?php echo $data_mahasiswa_pindahan[0]['Login']; ?></td>
		</tr>		
		<tr>
			<th>Password</th>
			<td>:</td>
			<td><?php echo $data_mahasiswa_pindahan[0]['Password']; ?></td>
		</tr>
	</table>
	<hr>
	<div class="row" align="center">
		<button class="btn btn-primary btn-flat float-right" onclick="btn_back()">Kembali Ke Form Input</button>	
	</div>
</div>