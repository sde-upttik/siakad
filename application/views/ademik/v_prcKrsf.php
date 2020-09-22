<!DOCTYPE html>
<html>
<head>
	<title>Proses KRSF</title>
</head>
<body>
	<form action="<?= base_url('ademik/Prc_krsf_siakadOld/prcRun')?>" method="post">
		<select name="tahun" style="width: 200px;">
			<?php 
				for ($i=2013; $i <= date("Y") ; $i++) { 
					for ($j= 1; $j <= 4 ; $j++) {
						$tahun_akademik = $i.$j; 
			 			echo "<option value={$tahun_akademik}>{$tahun_akademik}</option>";
					}
				}
			 ?>
		</select>
		<button type="submit">Proses</button>
	</form>
</body>
</html>