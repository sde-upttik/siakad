<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Ruang Kelas
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="">Tables</a></li>
        <li class="breadcrumb-item active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
         
         <div class="box">
            <div class="box-header">
              <h3 class="box-title">Table Data Ruang Kelas</h3>
            </div>

          	<div class="box-header">
            	<a href="" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#form" >
                <i class="fa fa-plus-circle"></i> Tambah Ruangan </a>
          	</div>
            
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped table-responsive" style="text-align: center;">
                <thead>
        					<tr>
                    <th style="text-align: center;">No.</th>
        						<th style="text-align: center;">Kode</th>
        						<th style="text-align: center;">Nama Ruang</th>
        						<th style="text-align: center;">Fakultas</th>
        						<th style="text-align: center;">Lantai</th>
        						<th style="text-align: center;">Kapasitas</th>
        						<th style="text-align: center;">Kapasitas Ujian</th>
        						<th style="text-align: center;">NA</th>
        						<th style="text-align: center;">Keterangan</th>
        					</tr>
        				</thead>
        				<tbody>
        					<?php 
                  $no=1;
                  foreach ($data as $d) { ?>
                    <tr>  
          						<td><?php echo $no++; ?></td>
          						<td>
                        <a onclick="edit_ruang_kelas('<?php echo $d['Kode']; ?>')" href="#form_edit" style="color: red;" data_target="" data-toggle="modal"><?php echo $d['Kode']; ?></a>
                      </td>
          						<td><?php echo $d['Nama']; ?></td>
          						<td><?php echo $d['KodeKampus']." - ".$d['Nama_Indonesia']; ?></td>
          						<td><?php echo $d['Lantai']; ?></td>
          						<td><?php echo $d['Kapasitas']; ?></td>
          						<td><?php echo $d['KapasitasUjian']; ?></td>
          						<td><?php echo $d['NotActive']; ?></td>
          						<td><?php echo $d['Keterangan']; ?></td>
          					</tr>
                  <?php } ?>
        				</tbody>
              </table>
            </div>

          </div>         
        </div>
      </div>
    </section>

<!-- MODAL TAMBAH -->
  <div class="modal fade" id="form" aria-hidden="true" aria-labelledby="myModalLabel" role="document" tabindex="-1" >
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Tambah Ruang Kelas</h4>
        </div>

        <form action="<?php echo base_url().'ademik/ruang_kelas/tambah_ruang_kelas' ?>" method="post">
          <div class="modal-body">    
          <label style="margin-bottom: 0px;">Kode Ruang Kelas</label>
            <div class="form-group">
                <input class="form-control" id="kode" name="kode" value="" placeholder="Kode" required>
                <label id="lblkode" style="color: red"></label>
            </div>

            <label style="margin-bottom: 0px;">Nama Ruang Kelas</label>
            <div class="form-group">
                <input class="form-control" id="nama_ruang" name="nama_ruang" placeholder="Nama Ruang Kelas" required>
                <label id="lblnama" style="color: red"></label>
            </div>

            <label style="margin-bottom: 0px;">Fakultas</label>
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" id="kodekampus" name="kodekampus" required >
                    <option></option>
                      <?php foreach ($data_jurusan as $d) { ?>
                          <option class="form-control" type="input">
                            <?php echo "<b>".$d['Kode']." - ".$d['Nama_Indonesia'] ?>
                          </option>
                      <?php } ?>
                </select>
            </div>

            <label style="margin-bottom: 0px;">Lantai</label>
            <div class="form-group">
                <input class="form-control" id="lantai" name="lantai" type="number" value="" placeholder="Lantai" required>
                <label id="lbllnt" style="color: red"></label>
            </div>

            <label style="margin-bottom: 0px;">Kapasitas</label>
            <div class="form-group">
                <input class="form-control" id="kapasitas" name="kapasitas" type="number" value="" placeholder="Kapasitas" required>
                <label id="lblkpsitas" style="color: red"></label>
            </div>

            <label style="margin-bottom: 0px;">Kapasitas Ujian</label>
            <div class="form-group">
                <input class="form-control" id="kapasitas_ujian" name="kapasitas_ujian" type="number" value="" placeholder="Kapasitas Ujian" required>
                <label id="lblkpstasujian" style="color: red"></label>
            </div>

            <label style="margin-bottom: 0px;">Keterangan</label>
            <div class="form-group">
                <input class="form-control" id="ket" name="ket" value="" placeholder="Keterangan" required>
                <label id="lblket" style="color: red"></label>
            </div>

            
            <div class="form-group">
              <div class="demo-checkbox">
                <input type="checkbox" id="cb_aktif" class="filled-in chk-col-red" name="notactive" checked="checked" value="Y">
                <label for="cb_aktif" style="margin-bottom: 0px;">Aktif</label>

                <!-- <input type="checkbox" id="cb_tdk_aktif" class="filled-in chk-col-red" name="notactive" value="N" >
                <label for="cb_tdk_aktif" style="margin-bottom: 0px;"> Tidak Aktif</label> -->
              </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-warning btn-sm" type="submit"> Simpan</button>
                <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal"> Batal</button>
            </div>
          </div>  
        </form>
      </div>
    </div>
  </div>

<!-- MODAL EDIT -->

  <div class="modal fade" id="form_edit" aria-hidden="true" aria-labelledby="myModalLabel" role="document" tabindex="-1" >
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Edit Ruang Kelas</h4>
        </div>

        <form action="<?php echo base_url().'ademik/ruang_kelas/update_ruang_kelas' ?>" method="post">
          <div class="modal-body">    
          <label style="margin-bottom: 0px;">Kode Ruang Kelas</label>
            <div class="form-group">
                <input class="form-control" id="add_kode" name="add_kode" readonly required>
                <label id="lblkode" style="color: red"></label>
            </div>

            <label style="margin-bottom: 0px;">Nama Ruang Kelas</label>
            <div class="form-group">
                <input class="form-control" id="add_nama_ruang" name="add_nama_ruang" placeholder="Nama Ruang Kelas" required>
                <label id="lblnama" style="color: red"></label>
            </div>

            <label style="margin-bottom: 0px;">Fakultas</label>
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" id="add_kodekampus" name="add_kodekampus" required >
                    <option value=""></option>
                      <?php foreach ($data_jurusan as $d) { ?>
                          <option value="<?php echo $d['Kode']." - ".$d['Nama_Indonesia'] ?>">
                            <?php echo "<b>".$d['Kode']." - ".$d['Nama_Indonesia']?>
                          </option>
                      <?php } ?>
                </select>
            </div>

            <label style="margin-bottom: 0px;">Lantai</label>
            <div class="form-group">
                <input class="form-control" id="add_lantai" name="add_lantai" value="" type="number" placeholder="Lantai" required>
                <label id="lbllnt" style="color: red"></label>
            </div>

            <label style="margin-bottom: 0px;">Kapasitas</label>
            <div class="form-group">
                <input class="form-control" id="add_kapasitas" name="add_kapasitas" type="number" value="" placeholder="Kapasitas" required>
                <label id="lblkpsitas" style="color: red"></label>
            </div>

            <label style="margin-bottom: 0px;">Kapasitas Ujian</label>
            <div class="form-group">
                <input class="form-control" id="add_kapasitas_ujian" name="add_kapasitas_ujian" value="" type="number" placeholder="Kapasitas Ujian" required>
                <label id="lblkpstasujian" style="color: red"></label>
            </div>

            <label style="margin-bottom: 0px;">Keterangan</label>
            <div class="form-group">
                <input class="form-control" id="add_ket" name="add_ket" value="" placeholder="Keterangan" required>
                <label id="lblket" style="color: red"></label>
            </div>

            
            <div class="form-group">
              <div class="demo-checkbox">
                <input type="checkbox" name="notactivee" id="add_cb_aktif" class="filled-in chk-col-red" value="Y">
                <label for="add_cb_aktif" style="margin-bottom: 0px;">Aktif</label>
              </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-warning btn-sm" type="submit"> Simpan</button>
                <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal"> Batal</button>
            </div>
          </div>  
        </form>
      </div>
    </div>
  </div>

</div>  
  
  
  
<script type="text/javascript">

function edit_ruang_kelas(Kode) {
  var data= 'Kode='+Kode;

    $body = $("body");
    $body.addClass("loading");

  $.ajax({
      url :'<?php echo base_url()."ademik/ruang_kelas/edit_ruang_kelas/" ?>',
      data : data,
      type :'POST',          
      dataType:'json',
      success:function(data){
        $body.removeClass("loading");
          console.log(data);
            $('[name="add_kode"]').val(data[0].Kode);
            $('[name="add_nama_ruang"]').val(data[0].Nama);
            $('[name="add_kodekampus"]').val(data[0].KodeKampus);
            $('[name="add_lantai"]').val(data[0].Lantai);
            $('[name="add_kapasitas"]').val(data[0].Kapasitas);
            $('[name="add_kapasitas_ujian"]').val(data[0].KapasitasUjian);
            $('[name="add_ket"]').val(data[0].Keterangan);
      }, 
      error:function(err){
        console.log(err);
      }       
  });
}

// function update_data(){

//   var Kode, Nama, KodeKampus, Lantai, Kapasitas, KapasitasUjian, Keterangan;

//   Kode            = $('#add_kode').val();
//   Nama            = $('#add_nama_ruang').val();
//   KodeKampus      = $('#add_kodekampus').val(); 
//   Lantai          = $('#add_lantai').val();
//   Kapasitas       = $('#add_kapasitas').val(); 
//   KapasitasUjian  = $('#add_kapasitas_ujian').val();
//   Keterangan      = $('#add_ket').val();

//   var data = 'add_kode='+Kode+'&add_nama_ruang='+Nama+'&add_kodekampus='+KodeKampus+'&add_lantai='+Lantai+'&add_kapasitas='+Kapasitas+'&add_kapasitas_ujian='+KapasitasUjian+'&add_ket='+Keterangan;

//     $.ajax({
//           url: "",
//           data:data,
//           type:'POST',
//           dataType:'json',
//           success:function(hasil){
//             console.log(hasil);
//           }
//     });        
//}  
    

</script>