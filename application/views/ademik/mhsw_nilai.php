<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Input Nilai
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="#">Dosen</a></li>
        <li class="breadcrumb-item active">Nilai Mahasiswa</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
		<form action="<?=base_url()?>ademik/mhsw_nilai/jadwaldosen" method="POST">
        <div class="box-body">
          <div class="row">
            <div class="col-md-3 col-12">
              <div class="form-group">
                <label>TahunAkademik</label>
					      <input style="width: 100%;" type="text" class="form-control" id="tahunakademik" name="tahunakademik" placeholder="Tahun Akademik" value="<?php if (!empty($tahunakademik)) echo $tahunakademik; ?>" />
                <!--<select class="form-control select1" style="width: 100%;">
                  <option selected="selected">Alabama</option>
                  <option>Alaska</option>
                  <option>California</option>
                  <option>Delaware</option>
                  <option>Tennessee</option>
                  <option>Texas</option>
                  <option>Washington</option>
                </select>-->
              </div>
              <!-- /.form-group -->
            </div>
			      <div class="col-md-3 col-12">
              <div class="form-group">
                <label>Sebagai Dosen</label>
                <select class="form-control select2" style="width: 100%;" id="typedosen" name="typedosen" style="width: 100%;">
                  <option value="dosenUtama" <?php if ($typedosen == "utama" || $typedosen == "default") echo "selected='selected'" ?> >Penanggung Jawab</option>
                  <option value="asstDosen" <?php if ($typedosen == "assisten") echo "selected='selected'" ?> >Asisten Dosen</option>
                </select>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
			      <div class="col-md-3 col-12">
              <div class="form-group">
                <label>Nama - NIP Dosen</label>
                <select class="form-control select2" style="width: 100%;" id="nipdosen" name="nipdosen">
					      <!--<option selected="selected"></option>-->
                <?php
                  foreach ($dsn as $dosen) {
                    echo "<option value=".$dosen[NIP].">".$dosen[nm_dosen]."</option>";
                  }
                ?>
                <!--
                  <option selected="selected">Alabama</option>
                  <option>Alaska</option>
                  <option>Delaware</option>
                  <option>Tennessee</option>
                  <option>Texas</option>
                  <option>Washington</option>-->
                </select>
              </div>
            </div>
            <div class="col-md-3 col-12">
              <div class="form-group">
                <label>Tekan Tombol Go Merefresh</label>
                <span class="input-group-btn">
                      <input type="submit" class="btn btn-info btn-flat" value="Go!" />
                </span>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
		</form>
        <!-- /.box-body -->
      </div>

	  <div class='col-md-12'>
		<div class='row'>
			<!--<div class='col-md-2'><button type='button' onClick="action()" class='btn btn-block btn-info' data-toggle='modal'data-target='#modal-add-jadwal'>Tambah Jadwal</button></div>
			<div class='col-md-2'><button type='button' class='btn btn-block btn-warning' data-toggle='modal'data-target='#modal-add-jadwal'>Cetak Jadwal</button></div>-->
			<!--<div class='col-md-2'><button type='button' class='btn btn-block btn-success' data-toggle='modal'data-target='#modal-add-jadwal'>Tambah Jadwal</button></div>-->
		</div>
	  </div>

	  <!-- Awal Table -->
	  <div class="box">
            <!-- Jadwal Mengajar -->
            <div class="box-header">
              <h3 class="box-title">Jadwal Mengajar Dosen</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <table style="font-size:10px" id="example1" class="table table-bordered table-striped table-responsive">
                <thead>
					<tr>
						<th>Jam</th>
						<th>Ruang</th>
						<th>KodeMK<br>Mata Kuliah</th>
						<th>SKS</th>
						<th>Hari</th>
						<th>Prodi</th>
						<th>Program</th>
						<th>Kelas</th>
						<th>Mhsw</th>
						<th>Input Nilai</th>
						<th>KRS/ Nilai</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Jam</th>
						<th>Ruang</th>
						<th>KodeMK<br>Mata Kuliah</th>
						<th>SKS</th>
						<th>Hari</th>
						<th>Prodi</th>
						<th>Program</th>
						<th>Kelas</th>
						<th>Mhsw</th>
						<th>Input Nilai</th>
						<th>KRS/ Nilai</th>
					</tr>
				</tfoot>
				<tbody>
				<?php
					if (!empty($ajardosen)){
						foreach($ajardosen as $row){
							$jm  = $row->jm;
							$js = $row->js;
							$rng = $row->KodeRuang;
							$kmk = $row->KodeMK;
							$mk  = $row->MK;
							$sks = $row->SKS;
							$hr  = $row->HR;
							$prodi = $row->KodeJurusan;
							$program  = $row->PRG;
							$kmps = $row->Keterangan;
							$ket =  $row->Kelas;
							//$mhsw = $this->HitungMhsw($IDJADWAL,$thn,$kdj);
							$mhsw = $row->jummhs;

							$jid = $row->IDJADWAL;
							$tahun = $row->Tahun;
              $iddos = $row->IDDosen;

							//$strnil2 ="<a data-toggle='modal' data-target='#modal-primary-jadwal' target=_blank title='Input Nilai' onClick='daftarmhsnil_dosen('$jid')'><img src='".base_url()."assets/images/btn_clc_16.png' border=0></a>";
							$strnil = 0;
						?>

							<tr><td><?=$jm." - ".$js?></td>
							<td><?=$rng?></td>
							<td><?=$kmk?><br><?=$mk?></td>
							<td><?=$sks?></td>
							<td><?=$hr?></td>
							<td><?=$prodi?></td>
							<td><?=$program?></td>
							<td><?=$kmps." ".$ket?></td>
							<td><?=$mhsw?></td>
							<td><a data-toggle="modal" data-target="#modal-primary-jadwal" target=_blank title="Input Nilai" onClick="daftarmhsnil('<?=$jid?>','<?=$tahun?>','<?=$iddos?>')"><img src="<?=base_url()?>assets/images/btn_input_nilai.png" border=0></a></td>
							<td><?=$strnil?></td><tr>
					<?php
						}
					}
				?>
				</tbody>
			</table>
            </div>

            <!-- /.box-body -->
      </div>
	  <!-- Akhir Table -->

      <!-- /.box -->
    </section>
    <!-- /.content -->
</div>

				<!-- UNTUK TAMBAH JADWAL-->
				<div class="modal fade" id="modal-add-jadwal">
				<form action="<?=base_url()?>ademik/Jdwlkuliah1/PrcJdwl" method="POST">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<h4 class="modal-title" id="modul-title">Tambah Jadwal</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span></button>
					  </div>
					  <div class="modal-body">
						<div class="form-group">
							<input type="hidden" class="form-control" style="width: 100%;" id="tahun" name="tahun" readonly />
						</div>
						<div class="form-group">
							<input type="hidden" class="form-control" style="width: 100%;" id="kdj" name="kdj" readonly />
						</div>
						<div class="form-group">
							<input type="hidden" class="form-control" style="width: 100%;" id="md" name="md" readonly />
						</div>
						<div class="form-group">
							<input type="hidden" class="form-control" style="width: 100%;" id="IDJADWAL" name="IDJADWAL" readonly />
						</div>

						<div class="form-group">
							Mata Kuliah
							<select class="form-control select2" style="width: 100%;" id="idmk" name="IDMK"><option> - </option></select>
						</div>

						<div class="demo-checkbox">
							Terjadwal
							<input type="checkbox" id="basic_checkbox_2" name="Terjadwal" value='Y' checked />
							<label for="basic_checkbox_2">Dijadwalkan untuk kuliah. Kosongkan jika tidak dijadwalkan</label>
						</div>

						<div class="form-group">
							Kapasitas Kelas
							<input class="form-control" id='kaps' name='kaps'  placeholder="Kapasitas Kelas">
						</div>

						<div class="form-group">
							Ruang
							<select class="form-control select2" style="width: 100%;" id="ruang" name="KodeRuang"><option value=""> - </option></select>
						</div>

						<div class="form-group">
							Program
							<select class="form-control select2" style="width: 100%;" id="program" name="Program">
								<option selected="selected" value="REG">REG - Progragram Reguler</option>
								<option value="NONREG">RESO - Program Non Reguler</option>>
							</select>
						</div>

						<div class="form-group">
							Hari
							<select class="form-control select2" style="width: 100%;" id="hari" name="Hari"><option> - </option></select>
						</div>

						<div class="form-group">
							Jam Mulai
							<input class="form-control"  id='jammulai' name='JamMulai' size=6 maxlength=5 placeholder="Jam : Menit Exp. (08:00)">
						</div>

						<div class="form-group">
							Jam Selesai
							<input class="form-control" id='jamselesai' name='JamSelesai' size=6 maxlength=5 placeholder="Jam : Menit Exp. (08:40)">
						</div>

						<div class="form-group">
							Rencana Tatap Muka
							<input class="form-control" id='rencana' name='Rencana' size=3 maxlength=3>
						</div>

						<div class="form-group">
							Realisasi Tatap Muka
							<input class="form-control" id='realisasi' name='Realisasi' size=3 maxlength=3>
						</div>

						<div class="form-group">
							<label>Kelas</label>
							<select class="form-control select2" style="width: 100%;" id="keterangan" name="Keterangan"></select>
						</div>

						<div class="form-group">
							<label>Keterangan</label>
							<input type="text" class="form-control" id="ket" name="ket" size=20 maxlength=19>
						</div>

						<div class="form-group">
							<label>PAKET</label>
							<select class="form-control select2" style="width: 100%;" id="idpaket" name="IDPAKET">
								<option></option>
							</select>
						</div>

						<div class="form-group">
							<label>Dosen Pengampu</label>
							<select class="form-control select2" style="width: 100%;" id="dosenpengampu" name="dosenpengampu">
								<option></option>
								<?php
								foreach ($dsn as $dosen) {
									echo "<option value=".$dosen[NIP].">".$dosen[nm_dosen]."</option>";
								}
								?>
							</select>
						</div>

						<div class="form-group">
							<label>Dosen lainnya</label>
							<select class="form-control select2" style="width: 100%;" id="dosenlainnya" name="dosenlainnya[]">
								<option></option>
								<?php
								foreach ($dsn as $dosen) {
									echo "<option value=".$dosen[NIP].">".$dosen[nm_dosen]."</option>";
								}
								?>
							</select>
							<button type="button" class="btn btn-success" onClick="adddosen()"> + </button> Tambah Dosen Lainnya
						</div>

						<div class="form-group" id="assdsn">

						</div>

					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
						<input type="submit" class="btn btn-info" value="Save changes">
					  </div>
					</div>
					<!-- /.modal-content -->
				  </div>
				</form>
				  <!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->

				<!--
				<div class="modal modal-primary fade" id="modal-primary-jadwal">
				  <div class="modal-dialog">
				  <form action="ademik/module/module/addmodul" method="POST"/>
					<div class="modal-content">
					  <div class="modal-header">
						<h4 class="modal-title">Input Nilai</h4><input id="groupmodulid" type="hidden" name="groupmodulid" readonly="readonly"/>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span></button>
					  </div>
					  <div class="modal-body">
				-->

				<!-- Input Nilai -->
				<div class="modal fade" id="modal-primary-jadwal">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" id="myLargeModalLabel">Input Nilai Mahasiswa</h4>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							</div>
							<div class="modal-body">
								<!-- Main content untuk isi data kliring -->
									<section class="content">
										<div class="row">
											<div class="col-12">
												<div class="box">
													<div class="box-header">
														<h3 class="box-title">Pastikan Nilai Mahasiswa Sudah Benar</h3>
													</div>
													<!-- /.box-header -->
													<div class="box-body">
														<form id="form-kirimnilaidikti">
															<input type="hidden" class="form-control" id="idjadwalinnilai" name="idjadwalinnilai" readOnly>
															<input type="hidden" class="form-control" id="tahunnilai" name="tahunnilai" readOnly>
															<input type="hidden" class="form-control" id="iddosnilai" name="iddosnilai" readOnly>
															<!--<div id="divdaftarnil"></div>-->
																<div class="form-group row">
                                  <div class="col-md-9">

																		<select class="form-control select2" style="width: 100%;" id="angkatan" name="angkatan">
																		</select>

                                  </div>
  																<div class="col-md-3">
                                    <Button type="button" onclick='daftarmhsnil_dosen()' class='btn btn-info btn-flat'>Go Angkatan</Button>
                                  </div>
  															</div>
                                <div id="tampilnilai" hidden="true" >
                                  <div id="divdaftarnil"></div>
                                  <div class="form-group row">
    																<div class="col-md-12" style="text-align: center;">
    																	<Button type="button" onclick='kirimnilaidikti()' class='btn bg-olive'>Validasi Nilai dan Kirim ke DIKTI</Button>
                                    </div>
    															</div>
                                </div>
															<!--<div class="form-group row">
																<div class="col-md-12" style="text-align: center;">
																	<input type="submit" name="simpan" id="usulwisuda" value="Usul Kliring Wisuda" class="btn bg-olive">
																</div>
															</div>-->
														</form>
													</div>
													<!-- /.box-body -->
												</div>
												<!-- /.box -->
											</div>
											<!-- /.col -->
										</div>
										<!-- /.row -->
									</section>
									<!-- /.content -->
							</div>
							<div class="modal-footer">
									<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->

<script>

function nilai(nil, i, e){
	var idjad = $('#idjadwalinnilai').val();
	var nim = $('#nim'+i).val();
	var tahunakademik = $('#tahunakademik').val();
  var type = $('#typedosen').val();
	//alert(nil + " - "+ idjad + " - "+ nim  + " - "+ tahunakademik + " - " + type);
	$('#'+nim+' div button').attr("class","btn btn-flat btn-bitbucket")
	$.ajax({
		type: 'POST',
		url: '<?=base_url()?>ademik/mhsw_nilai/innilai',
		data: 'idjadwal=' + idjad + '&tahun='+ tahunakademik + '&nim='+ nim + '&nil='+ nil + '&type='+ type,
		dataType: "JSON",
		success: function(response){
			//alert(response.detailnil);
			// console.log(response);
      if (response.ket == "sukses"){
        $(e).attr("class","btn btn-flat btn-danger");
      } else {
        alert(response.pesan);
      }
		}
	})
	// .always(function(){
	// 	// console.log('run')
	// })
	.fail(function(error){
		alert(error)
	})
	// .done(function( data ) {
	// 	// console.log(data)
  // });
}

function daftarmhsnil(id, tahun, iddos){
	var actval = id;
	var tahunakademik = tahun;
	$('#divdaftarnil').html("");
  $('#tampilnilai').attr("hidden",true);
	// alert(actval+" - "+tahunakademik+' - '+iddos+' - '+type);

	$.ajax({
		type: 'POST',
		url: '<?=base_url()?>ademik/mhsw_nilai/daftarmhsnil',
		data: 'idjadwal=' + actval + '&tahun='+ tahunakademik + '&iddos='+ iddos,
		dataType: "JSON",
		success: function(response){
			// alert(response.daftarnil);
			//$('#divdaftarnil').html(response.daftarnil);

			$('#idjadwalinnilai').val(actval);
			$('#tahunnilai').val(tahunakademik);
			$('#iddosnilai').val(iddos);
			$('#angkatan').html(response.daftarnil);
		}
	});
}

function batalvalidasi(kode, i, e){
  var idjad = $('#idjadwalinnilai').val();
	var nim = $('#nim'+i).val();
	var tahunakademik = $('#tahunakademik').val();
  //alert(idjad + " - "+ nim  + " - "+ tahunakademik);

	$.ajax({
		type: 'POST',
		url: '<?=base_url()?>ademik/mhsw_nilai/batalvalidasi',
		data: 'idjadwal=' + idjad + '&tahun='+ tahunakademik + '&nim='+ nim,
		dataType: "JSON",
		success: function(response){
			//alert(response.detailnil);
			console.log(response);
			$(e).attr("class","btn btn-block btn-social").html('Proses Pembatalan Berhasil');
		}
	});
}

function daftarmhsnil_dosen(){ 
	$body = $("body");
  $body.addClass("loading");

	var actval = $('#idjadwalinnilai').val();
	var tahunakademik = $('#tahunnilai').val();
	var iddos = $('#iddosnilai').val();
	var angkatan = $('#angkatan').val();
	//alert(actval+" dan "+tahunakademik+" dan "+iddos);

	$.ajax({
		type: 'POST',
		url: '<?=base_url()?>ademik/mhsw_nilai/daftarmhsnil_dosen',
		data: 'idjadwal=' + actval + '&tahun='+ tahunakademik + '&iddos='+ iddos + '&angkatan='+ angkatan,
		dataType: "JSON",
		success: function(response){
			//alert(response.daftarnil);
			//console.log(response);
			$body.removeClass("loading");
			$('#tampilnilai').attr("hidden",false);
			$('#divdaftarnil').html(response.daftarnil);
		}
	});
}

function kirimnilaidikti(){
  //alert("masuk");
  var data = $('#form-kirimnilaidikti').serialize();
  //console.log(data);

	$.ajax({
		type: 'POST',
		url: '<?=base_url()?>ademik/mhsw_nilai/kirimnilaidikti',
		data: data,
		dataType: "JSON",
		success: function(response){
			//console.log(response)
			alert(response.ket);
			if ( response.ket == 'sukses' ) {
				//console.log(response.pesan);
				$('#divdaftarnil').html(response.pesan);
			} else {
				$('#divdaftarnil').html(response.pesan);
			}
			//console.log(response);
			//$(e).attr("class","btn btn-block btn-social").html('Proses Pembatalan Berhasil');
		}
	});
}
</script>

<!--  fandu export start - This is for export functionality only --A>
    <script src="<?=base_url()?>assets/plugins/DataTables-1.10.15/extensions/Buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.flash.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/DataTables-1.10.15/ex-js/jszip.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/DataTables-1.10.15/ex-js/pdfmake.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/DataTables-1.10.15/ex-js/vfs_fonts.js"></script>
    <script src="<?=base_url()?>assets/plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.html5.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.print.min.js"></script>
    <!!-- end - This is for export functionality only -->
