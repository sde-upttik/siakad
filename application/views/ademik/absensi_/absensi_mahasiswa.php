
        <table id="tabel_mahasiswa<?php echo $pertemuan?>" class="table_absen_mahasiswa table table-bordered table-hover display nowrap margin-top-10 table-responsive" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th rowspan="2">No</th>
              <th rowspan="2">NIM</th>
              <th rowspan="2">Nama Mahasiwa</th>
              <th colspan="4">Absen pertemuan</th>
              <th rowspan="2">Status</th>
            </tr>
            <tr>
              <th>
                <div class="radio">
                  <input name="<?php echo $pertemuan?>group_zero" type="radio" id="<?php echo $pertemuan ?>Option_x1" onclick="absen_semua('H', '<?php echo $pertemuan; ?>')">
                  <label for="<?php echo $pertemuan?>Option_x1">Hadir Semua</label>
                </div>
              </th>
              <th>
                <div class="radio">
                  <input name="<?php echo $pertemuan?>group_zero" type="radio" id="<?php echo $pertemuan ?>Option_x2"  onclick="absen_semua('I', '<?php echo $pertemuan; ?>')">
                  <label for="<?php echo $pertemuan?>Option_x2">Izin Semua</label>
                </div>
              </th>
              <th>
                <div class="radio">
                  <input name="<?php echo $pertemuan?>group_zero" type="radio" id="<?php echo $pertemuan ?>Option_x4"  onclick="absen_semua('A', '<?php echo $pertemuan; ?>')">
                  <label for="<?php echo $pertemuan?>Option_x4">Alpa Semua</label>
                </div>
              </th>
              <th>
                <div class="radio">
                  <input name="<?php echo $pertemuan?>group_zero" type="radio" id="<?php echo $pertemuan ?>Option_x3"  onclick="absen_semua('S', '<?php echo $pertemuan; ?>')">
                  <label for="<?php echo $pertemuan?>Option_x3">Sakit Semua</label>
                </div>
              </th>
            </tr>

          </thead>
          <tbody>
            <?php $radio = 0; $no=1; foreach ($data_absen_mahasiswa as $mahasiswa ) {   ?>
            <tr>
              <td><?php echo $no?></td>
              <td><?php echo $mahasiswa['NIM']?></td>
              <td><?php echo $mahasiswa['nama_mahasiswa']?></td>

              <div class="form-group">
                <td>
                  <div class="radio">
                    <input name="<?php echo $pertemuan."_group_".$mahasiswa['NIM']?>" type="radio" id="<?php echo $pertemuan?>_Option_<?php echo $radio = $radio+1?>" <?php if ($mahasiswa['hr_'.$pertemuan]=='H') { echo "checked"; } ?> onclick="update_absen('H', '<?php echo $mahasiswa['NIM'];?>','<?php echo $pertemuan; ?>')" >
                    <label for="<?php echo $pertemuan?>_Option_<?php echo $radio ?>">Hadir</label>
                  </div>
                </td>                            
                <td>
                  <div class="radio">
                    <input name="<?php echo $pertemuan."_group_".$mahasiswa['NIM']?>" type="radio" id="<?php echo $pertemuan?>_Option_<?php echo $radio = $radio+1?>" <?php if ($mahasiswa['hr_'.$pertemuan]=="I") { echo "checked"; } ?> onclick="update_absen('I', '<?php echo $mahasiswa['NIM'];?>','<?php echo $pertemuan; ?>'  )" >
                    <label for="<?php echo $pertemuan?>_Option_<?php echo $radio?>">Izin</label>
                  </div>
                </td>                            
                <td>
                  <div class="radio">
                    <input name="<?php echo $pertemuan."_group_".$mahasiswa['NIM']?>" type="radio" id="<?php echo $pertemuan?>_Option_<?php echo $radio = $radio+1?>" <?php if ($mahasiswa['hr_'.$pertemuan]=="A") { echo "checked"; } ?> onclick="update_absen('A', '<?php echo $mahasiswa['NIM'];?>','<?php echo $pertemuan; ?>'  )" >
                    <label for="<?php echo $pertemuan?>_Option_<?php echo $radio?>">Alpa</label>
                  </div>
                </td>                            
                <td>
                  <div class="radio">
                    <input name="<?php echo $pertemuan?>_group_<?php echo $mahasiswa['NIM'] ?>" type="radio" id="<?php echo $pertemuan?>_Option_<?php echo $radio = $radio+1?>" <?php if ($mahasiswa['hr_'.$pertemuan]=="S") { echo "checked"; } ?> onclick="update_absen('S', '<?php echo $mahasiswa['NIM'];?>','<?php echo $pertemuan; ?>'  )" >
                    <label for="<?php echo $pertemuan?>_Option_<?php echo $radio?>">Sakit</label>
                  </div>
                </td>
              </div>
              <?php if ($mahasiswa['hr_'.$pertemuan]!=null){?>
              	<td>Absen Tersimpan</td>
              <?php }else{ ?>
              	<td>Belum Terisi</td>
          	  <?php } ?>
            </tr>
            <?php $no++; } ?>
          </tbody>
        </table>	

    <script type="text/javascript">
    	
    	$("#tabel_mahasiswa"+"<?php echo $pertemuan?>").DataTable();

    	function absen_semua(status_absen, hari) {
    		// alert(
      //           	"status absen :"+status_absen+
      //           	" pertemuan:"+hari+
      //           	" id_jadwal:"+"<?php  echo $data_absen_mahasiswa[0]['IDJadwal']?>"
      //           );
    		loading_alert();
        	$.post(
              "<?php echo base_url('index.php/ademik/Absensi/update_semua_absen_mahasiswa'); ?>",
              {
                status_absen  : status_absen,
                pertemuan     : hari,
                id_jadwal     : "<?php  echo $data_absen_mahasiswa[0]['IDJadwal']?>",
                semester      : "<?php  echo $semester ?>"
              },
              function(data) {
                swal.closeModal();
                $('#modal_absen_mahasiswa').html(data)
              }
            ).done(function () {
              // alert("data berhasil dikirim");
            }).fail(function () {
              alert("data gagal dikirim");
            });

    	}

      function update_absen(status_absen, nim, hari) {
        $.post(
          "<?php echo base_url('index.php/ademik/Absensi/update_absen_mahasiswa'); ?>",
          {
            status_absen	:status_absen,
            nim 			    :nim,
            pertemuan 		: hari,
            id_jadwal 		: "<?php  echo $data_absen_mahasiswa[0]['IDJadwal']?>",
            semester 		  : "<?php  echo $semester ?>"
          }
        ).done(function () {
       		// success_alert();
        }).fail(function () {
          alert("data gagal dikirim");
        });
      }


    </script>