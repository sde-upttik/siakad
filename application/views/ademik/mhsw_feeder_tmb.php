<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span> 
    <link rel="shortcut icon" href="" />
  </button>
	  <h4 class="modal-title">Tambah Aktivitas Mahasiswa</h4>
</div>

	<div class="modal-body">
	<form action="<?php echo base_url().'ademik/mhsw_feeder/insert_data' ?>" method="POST">	   
		<label style="margin-bottom: 0px;">ID AKTIVITAS MAHASISWA</label>
	    <div class="form-group">
	      	<input class="form-control" name="id_akt_mhs" value="" placeholder="Id Aktivitas Mahasiswa">
	    </div>

	    <label style="margin-bottom: 0px;">ID SEMESTER</label>
	    <div class="form-group">
	      	<input class="form-control" name="id_smt" value="" placeholder="Id Semester">
	    </div>

	    <label style="margin-bottom: 0px;">JUDUL AKTIVITAS MAHASISWA</label>
	    <div class="form-group">
	      	<input class="form-control" name="jdl_akt_mhs" value="" placeholder="Judul Aktivasi Mahasiswa">
	    </div>

	    <label style="margin-bottom: 0px;">LOKASI KEGIATAN</label>
	    <div class="form-group">
	      	<input class="form-control" name="lks_kgt" value="" placeholder="Lokasi Kegiatan">
	    </div>

	    <label style="margin-bottom: 0px;">SK TUGAS</label>
	    <div class="form-group">
	      	<input class="form-control" name="sk_tgs" value="" placeholder="SK Tugas">
	    </div>

	    <label style="margin-bottom: 0px;">TGL SK TUGAS</label>
	    <div class="form-group">
	      	<input class="form-control" type="date" name="tgl_sk_tgs" value="" placeholder="Tgl SK Tugas">
	    </div>

	    <label style="margin-bottom: 0px;">KETERANGAN AKTIVITAS</label>
	    <div class="form-group">
	      	<input class="form-control" name="ket_akt" value="" placeholder="Ket Aktivitas">
	    </div>

	    <label style="margin-bottom: 0px;">A KOMUNAL</label>
	    <div class="form-group">
	      	<input class="form-control" name="a_komunal" value="" placeholder="A Komunal">
	    </div>

	    <label style="margin-bottom: 0px;">ID JENIS AKTIVITAS MAHASISWA</label>
	    <div class="form-group">
	      	<input class="form-control" name="id_jns_akt_mhs" value="" placeholder="Id Jenis Aktivitas Mahasiswa">
	    </div>

	    <label style="margin-bottom: 0px;">ID SMS</label>
	    <div class="form-group">
	      	<input class="form-control" name="id_sms" value="" placeholder="Id Sms">
	    </div>
	

		<div class="modal-footer">
			<input type="submit" name="" value="simpan" class="btn btn-info btn-flat">
        	<button type="button" data-dismiss="modal" name="" class="btn btn-info btn-flat">Batallll</button>
    	</div>
    </form>
    </div>