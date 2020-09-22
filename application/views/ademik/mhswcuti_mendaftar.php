  <div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	     <span aria-hidden="true">&times;</span> 
	    <link rel="shortcut icon" href="" />
	  </button>
  	  <h4 class="modal-title">DAFTAR CUTIii</h4>
  </div>

	<div class="modal-body">
	<form action="<?php echo base_url().'ademik/Mhswcuti/simpan' ?>" method="POST">	   
		<label style="margin-bottom: 0px;">NIM</label>
	    <div class="form-group">
	      	<input class="form-control" name="nim" value="<?php if(isset($data1[0])){ echo $data1[0]['NIM'];}  ?>" readonly placeholder="NIM">
	    </div>

	    <label style="margin-bottom: 0px;">Nama</label>
	    <div class="form-group">
	      	<input class="form-control" name="nama" value="<?php if(isset($data1[0])){ echo $data1[0]['Name'];}  ?>" readonly placeholder="Nama">
	    </div>

	    <label style="margin-bottom: 0px;">Periode Cuti</label>
	    <div class="form-group">
	  	   <SELECT name="priode_cuti" id="" class="form-control select2" readonly>  
	  	   		<option value='20212'>20212</option>
	  	   		<option value='20211'>20211</option>
	  	   		<option value='20202'>20202</option>
	  	   		<option value='20201'>20201</option>
	  	   		<option value='20192'>20192</option>
	  	   		<option value='20191'>20191</option>
	  	   		<option value='20182'>20182</option>
	  	   		<option value='20181'>20181</option>    
		        <option value='20172'>20172</option>
		        <option value='20171'>20171</option>
		        <option value='20162'>20162</option>
		        <option value='20161'>20161</option>
		        <option value='20152'>20152</option>
			</SELECT>
		</div>

	    <label style="margin-bottom: 0px;">Jumlah Cuti</label>
	    <div class="form-group">
	      	<input class="form-control" name="jml_smtr_cuti" value="" placeholder="Jumlah Semester Cuti">
	    </div>

	    <label style="margin-bottom: 0px;">Tanggal Mulai Cuti</label>
	    <div class="form-group">
	      	<input class="form-control" type="date" name="tgl_mulai_cuti" value="" >
	    </div>

	    <label style="margin-bottom: 0px;">Tanggal Selesai Cuti</label>
	    <div class="form-group">
	      	<input class="form-control" type="date" name="tgl_selesai_cuti" value="" >
	    </div>

	    <label style="margin-bottom: 0px;">Pejabat Tetap</label>
	    <div class="form-group">
	      	<select name="pejabat_ttp" id="pejabat_ttp" class="form-control select2" style="width: 100%;">
	      		<option value=""></option>
	    		<?php foreach ($dosen as $d) { ?>
	    		<option>
	    			<?php echo "<b>".$d['Name'];  ?>
	    		</option>
	    		 <?php } ?>
	    	</select>
	    </div>

	    <label style="margin-bottom: 0px;">Alasan</label>
	    <div class="form-group">
	      	<input class="form-control" type="textarea" name="alasan" value="" placeholder="Alasan">
	    </div>

	    <label style="margin-bottom: 0px;">Penanggung Jawab Akademik</label>
	    <div class="form-group">
	      	<select name="pngung_jwb_akdmik" id=pngung_jwb class="form-control select2" style="width: 100%;">
	    		<option value=""></option>
	    		<?php foreach ($dosen as $d) { ?>
	    		<option>
	    			<?php echo "<b>".$d['Name'];  ?>
	    		</option>
	    		 <?php } ?>
	    	</select>  
	    </div>

		<div class="modal-footer">
			<input type="submit" name="" value="simpan" class="btn btn-primary pull-right">
        	<input type="button" name="" value="Hapus" class="btn btn-primary pull-right">
        	<button type="button" data-dismiss="modal" name="" class="btn btn-primary pull-right">Batal</button>
    	</div>
    </form>
    </div>