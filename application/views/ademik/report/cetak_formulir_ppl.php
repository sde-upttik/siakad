<!DOCTYPE html>
<html>
<head>
	<title>Formulir Pendaftaran PPL</title>
	<link rel="stylesheet" type="text/css" href="./assets/components/bootstrap/dist/css/bootstrap.min.css">
	<style type="text/css">
		body{
			background-image: url(assets/images/logo-untad4.png);
			background-repeat: no-repeat;
			background-position: center center;
			font-family: times;
		}
		h2, h3{
			margin: 0px;
			padding: 0px;
		}
	</style>
</head>
<body>

<table style='margin-left:100px; margin-top:30px; font-family: Times-Roman;' class=basic cellspacing=1 cellpadding=2 width=100%>
  	<tr>
  		<td rowspan=6>
  			<img src='assets/images/TUT_WURI_HANDAYANI.jpg' width='110' height='110' ALIGN='left'></td></tr>
			  <tr align=center style='font-size:25px;'>
			  	<td>
			  		<b>KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN R.I</b></td></tr>
			  <tr align=center style='font-size:40px;'>
			  	<td>
			  		<b>UNIVERSITAS TADULAKO</b></td></tr>
			  <tr align=center style='font-size:25px;'>
			  	<td>
			  		<b>FAKULTAS KEGURUAN DAN ILMU PENDIDIKAN</b></td></tr>
			  <tr align=center style='font-size:18px;'>
			  	<td>
			  		<b>KAMPUS BUMI TADULAKO TONDO TELP. 429743 Pst. 246-247-248-29-250</b></td></tr>
			  <tr align=center style='font-size:20px;'>
			  	<td>
			  		<b>PALU - SULAWESI TENGAH</b></td></tr>
</table><hr style='margin-left:100px' color='#000000' size='12px' width='100%'><hr style='margin-left:100px' size='5' width='100%'>


 <table style='margin-top:10px; margin-left:100px; font-size:20px; font-family: Times-Roman;' class=basic cellspacing=1 cellpadding=2 width=100%>
	<tr>
		<td align=center>
			<b>FORMULIR PENDAFTARAN MAHASISWA ".$plp."<b>
		</td>
	</tr>
</table>


	
	  <table class=basic cellspacing=1 cellpadding=2 width=600 style='font-size:20px; margin-left:100px; font-family: Times-Roman;'>
	  	<?php
		if (isset($data)) {

		 	foreach ($data as $row) {
		?>
  	<br>
			<tr valign=top height='30px'><td width=20>1. </td>
				<td width=230>Nama Lengkap</td>
				<td width=350>: $nama</td>
			</tr>
			<tr valign=top height='30px'><td>2. </td>
				<td>Tempat dan Tanggal Lahir</td>
				<td>: $tmplahir, $tgllahir</td>
			</tr>
			<tr valign=top height='30px'><td>3. </td>
				<td>No. Stambuk</td>
				<td>: $nim</td>
			</tr>
			<tr valign=top height='30px'><td>4. </td>
				<td>Program Studi</td>
				<td>: $kdjur - $nmj</td>
			</tr>
			<tr valign=top height='30px'><td>5. </td>
				<td>Jurusan</td>
				<td>: $nmp</td>
			</tr>
			<tr valign=top height='30px'><td>6. </td>
				<td>Reguler / Non-Reguler</td>
				<td>: $kdprog</td>
			</tr>
			<tr valign=top height='30px'><td>7. </td>
				<td>Jenis Kelamin</td>
				<td>: $sex</td>
			</tr>
			<tr valign=top height='30px'><td>8. </td>
				<td>Agama</td>
				<td>: $agama</td>
			</tr>
			<tr valign=top height='30px'><td>9. </td>
				<td>Alamat di Palu</td>
				<td>: $alamat</td>
			</tr>
			<tr valign=top height='30px'><td>10. </td>
				<td>Nomor Telp/HP</td>
				<td>: $phone</td>
			</tr>
			<tr valign=top height='30px'><td>11. </td>
				<td>Daerah Asal</td>
				<td>: $da </td>
			</tr>
			<tr valign=top height='30px'><td>12. </td>
				<td>Jumlah SKS dilulus</td>
				<td>: $totsks</td>
			</tr>
			<tr valign=top height='45px'><td>13. </td>
				<td>Nilai PPL I
					<br>(Microteaching)</td>
				<td>: $nilai </td>
			</tr>
			<tr valign=top height='45px'><td>14. </td>
				<td>Ke Kampus 
					<br>dengan Kendaraan</td>
				<td>: $kendaraan </td>
			</tr>
			<tr valign=top height='45px'><td>15. </td>
				<td>Nama Orang Tua/Wali
					<br>yang dapat di hubungi</td>
				<td>: $nmayah </td>
			</tr>
			<tr valign=top height='45px'><td>16. </td>
				<td>Alamat Orang Tua/Wali
					<br>yang dapat di hubungi</td>
				<td>: $alamatot1 
			</tr>
			<tr valign=top height='45px'><td>17. </td>
				<td>No.HP Orang Tua/Wali
					<br>yang dapat di hubungi</td>
				<td>: $phoneot </td>
			</tr>
			
			<?php }
		 }  ?>

	  </table>


	  
  		<table style='margin-left:140px; font-size:18px; margin-top:15px;' width=100%>
  		<tr><td></td></tr>
  		</table>";
	
  		<table style='margin-left:100px; font-size:18px; margin-top:15px;' width=100%>
	  		<tr>
	  			<td colspan=3>
	  				<p>Dengan ini mendaftarkan diri sebagai peserta PPL Terpadu dan bersedia ditempatkan di lokasi/tempat PPL Terpadu yang ditentukan oleh panitia</p></td></tr>
			<tr>
				<td colspan=3>&nbsp</td></tr>
			<tr>
				<td colspan=3>&nbsp</td></tr>
			<tr>
				<td align='center' width='20%'>
					<div style='border: 2px #000000 solid; height: 180px; width: 80%;'><br>
						<br>
						<br>Pas Foto
						<br>3 x 4 
					</div>
				</td>
				<td width='50%'>&nbsp</td>
				<td width='40%'>
					<p>Palu, $tglnow<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>$nama
					</p>
				</td>
			</tr>
  		</table>";


	</html>
</body>  		
  