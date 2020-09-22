  <div class="box box-default">
    <div class="box-header with-border">
      <button class="btn btn-primary pull-right" id="btn_kembali"><i class="fa fa-replay"></i>Kembali</button>
      <h3 class="box-title">Absen Dosen</h3>
    </div>
    <div class="box-body">

      <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12">
          <table>
            <tr>
              <th>Kode MataKuliah</th>
              <td> : </td>
              <td><?php echo $data_absen_dosen[0]['KodeMK']?></td>
            </tr>      
            <tr>
              <th>MataKuliah</th>
              <td> : </td>
              <td><?php echo $data_absen_dosen[0]['NamaMK']?></td>
            </tr>
            <tr>
              <th>Program</th>
              <td> : </td>
              <td><?php echo $data_absen_dosen[0]['Program']?></td>
            </tr>
            <tr>
              <th>Semester</th>
              <td> : </td>
              <td><?php echo $data_absen_dosen[0]['Tahun']?></td>
            </tr>
            <tr>
              <th>Dosen</th>
              <td> : </td>
              <td><?php echo $data_absen_dosen[0]['nama_dosen']?></td>
            </tr>
            <tr>
              <th>NIP</th>
              <td> : </td>
              <td><?php echo $data_absen_dosen[0]['IDDosen']?></td>
            </tr>
          </table>
        </div>
      </div>
      <hr>
      <div class="row" style="margin-top: 10px; margin-bottom: 10px; justify-content: center;" >
          <form action="<?php echo base_url('ademik/report/Report/cetak_absensi_harian_mahasiswa') ?>" method="POST" style="margin-right:5px;">
            <input type="hidden" name="IDJADWAL" value="<?php echo $data_absen_dosen[0]['IDJADWAL']?>">
            <input type="hidden" name="Tahun" value="<?php echo $data_absen_dosen[0]['Tahun']?>">
            <button type="submit" class="btn btn-primary" >Cetak Absen Harian Mahasiswa</button>
          </form>           

          <form action="<?php echo base_url('ademik/report/Report/cetak_absensi_dosen') ?>" method="POST" style="margin-right:5px;">
            <input type="hidden" name="IDJADWAL" value="<?php echo $data_absen_dosen[0]['IDJADWAL']?>">
            <input type="hidden" name="Tahun" value="<?php echo $data_absen_dosen[0]['Tahun']?>">
            <button type="submit" class="btn btn-primary" >Cetak Absen Dosen</button>
          </form>            

          <form action="<?php echo base_url('ademik/report/Report/cetak_rekap_absensi_dosen') ?>" method="POST" style="margin-right:5px;">
            <input type="hidden" name="IDJADWAL" value="<?php echo $data_absen_dosen[0]['IDJADWAL']?>">
            <input type="hidden" name="Tahun" value="<?php echo $data_absen_dosen[0]['Tahun']?>">
            <button type="submit" class="btn btn-primary" >Cetak Rekap Absensi Dosen</button>
          </form>           

          <form action="<?php echo base_url('ademik/report/Report/cetak_rekap_absensi_mahasiswa') ?>" method="POST" style="margin-right:5px;">
            <input type="hidden" name="IDJADWAL" value="<?php echo $data_absen_dosen[0]['IDJADWAL']?>">
            <input type="hidden" name="Tahun" value="<?php echo $data_absen_dosen[0]['Tahun']?>">
            <button type="submit" class="btn btn-primary">Cetak Rekap Absensi Mahasiswa</button>
          </form> 
          

          <?php if($this->session->userdata('unip') == 'fadlifak' ){ ?>
          <form action="<?php echo base_url('ademik/report/Report/new_cetak_cpna_tester') ?>" method="POST" style="margin-right:5px;">
            <input type="hidden" name="IDJADWAL" value="<?php echo $data_absen_dosen[0]['IDJADWAL']?>">
            <input type="hidden" name="Tahun" value="<?php echo $data_absen_dosen[0]['Tahun']?>">
            <button type="submit" class="btn btn-primary">Cetak DPNA</button>
          </form>
          <?php } ?>      
          <form action="<?= base_url('ademik/report/Report/new_cetak_cpna') ?>" method="POST">
            <input type="hidden" name="IDJADWAL" value="<?php echo $data_absen_dosen[0]['IDJADWAL']?>">
            <input type="hidden" name="Tahun" value="<?php echo $data_absen_dosen[0]['Tahun']?>">
            <input type="hidden" name="kdj" value="<?php echo $data_absen_dosen[0]['KodeJurusan']?>">
            <button type="submit" class="btn btn-success">New Cetak DPNA</button>
          </form>

          <?php if($this->session->userdata('uname') == "mohamad fadli"){ ?>
            <form action="<?php echo base_url('ademik/Absensi/dpnaView') ?>" method="POST">
              <input type="hidden" name="IDJADWAL" value="<?php echo $data_absen_dosen[0]['IDJADWAL']?>">
              <input type="hidden" name="Tahun" value="<?php echo $data_absen_dosen[0]['Tahun']?>">
              <button type="submit" class="btn btn-danger">Tester Cetak DPNA</button>
            </form>
          <?php }?>
      </div>

      <div class="row" style="justify-content: center;">
        <form action="<?php echo base_url('ademik/report/Report/cetak_absensi_mahasiswa_5') ?>" method="POST" style="margin-right:5px;">
          <input type="hidden" name="IDJADWAL" value="<?php echo $data_absen_dosen[0]['IDJADWAL']?>">
          <input type="hidden" name="Tahun" value="<?php echo $data_absen_dosen[0]['Tahun']?>">
          <input type="hidden" name="start" value="1">
          <input type="hidden" name="end" value="5">
          <button type="submit" class="btn btn-primary">Absen Pertemuan 1 - 5</button>
        </form>

        <form action="<?php echo base_url('ademik/report/Report/cetak_absensi_mahasiswa_5') ?>" method="POST" style="margin-right:5px;">
          <input type="hidden" name="IDJADWAL" value="<?php echo $data_absen_dosen[0]['IDJADWAL']?>">
          <input type="hidden" name="Tahun" value="<?php echo $data_absen_dosen[0]['Tahun']?>">
          <input type="hidden" name="start" value="6">
          <input type="hidden" name="end" value="10">
          <button type="submit" class="btn btn-primary">Absen Pertemuan 6 - 10</button>
        </form>          

        <form action="<?php echo base_url('ademik/report/Report/cetak_absensi_mahasiswa_5') ?>" method="POST" >
          <input type="hidden" name="IDJADWAL" value="<?php echo $data_absen_dosen[0]['IDJADWAL']?>">
          <input type="hidden" name="Tahun" value="<?php echo $data_absen_dosen[0]['Tahun']?>">
          <input type="hidden" name="start" value="11">
          <input type="hidden" name="end" value="15">
          <button type="submit" class="btn btn-primary">Absen Pertemuan 11 - 15</button>
        </form>

        <form action="<?php echo base_url('ademik/report/Report/cetak_absensi_mahasiswa_16') ?>" method="POST" style="margin-left:5px;">
          <input type="hidden" name="IDJADWAL" value="<?php echo $data_absen_dosen[0]['IDJADWAL']?>">
          <input type="hidden" name="Tahun" value="<?php echo $data_absen_dosen[0]['Tahun']?>">
          <button type="submit" class="btn btn-primary">Absen Pertemuan 1 - 16 </button>
        </form>
      </div>

        <hr>  
        <div class="mt-5">
        <?php if($this->session->userdata('kdf') == 'C' or $this->session->userdata('ulevel') == '1' or $this->session->userdata('kdf') == 'D' or $this->session->userdata('kdf') == 'E'or $this->session->userdata('kdf') == 'B' ){ ?>      
            <button class="btn btn-success btn-circle" id="btn-kumlatif" onclick="showModalAbsenKumulatif()">
                <i class="fa fa-calculator"></i>
            </button>
            <label for="btn-kumlatif" class="mr-2">Input Absen Mahasiswa Secara kumulatif</label>
        <?php } if ($this->session->userdata('kdf') == 'D' or $this->session->userdata('ulevel') == '1' ) { ?>
          <form class="mt-3" action="<?= base_url('ademik/report/Report/cetak_beban_menagajar') ?>" method="post">
            <div class="form-group row">
              <label for="IDDosen" class="col-md-2">Surat Beban Mengajar</label>
              <select class="form-control col-md-3" name="IDDosen">
                <option value="<?= $data_absen_dosen[0]['IDDosen']?>"><?= $data_absen_dosen[0]['nama_dosen']?></option>
                <?php foreach ($data_asisten_dosen as $asisten) { ?>
                  <option value="<?=$asisten['IDDosen']?>" > <?=$asisten['name']?></option>
                <?php } ?>
              </select>
              <input type="text" name="pangkat" class="form-control col-md-3" placeholder="Pangkat/Golongan">
              <input type="text" name="jabatan" class="form-control col-md-3" placeholder="Jabatan">
              <input type="hidden" name="IDJADWAL" value="<?= $data_absen_dosen[0]['IDJADWAL']?>">
              <input type="hidden" name="KodeMK" value="<?= $data_absen_dosen[0]['KodeMK']?>"> 
              <input type="hidden" name="Tahun" value="<?= $data_absen_dosen[0]['Tahun']?>">
              
              <button class="btn btn-warning"><i class="fa fa-print"></i> Cetak</button>
            </div>
          </form>
        <?php } ?>
        </div>

      <div class="row" style="margin-top: 20px;">
        <div class="col-md-12 col-xs-12">
          <form id="absenDosenHarian">
              <table id="tableJadwal_2" class="table table-bordered table-hover display nowrap table-responsive" >
                <thead>
                  <tr>
                    <th>Pertemuan</th>
                    <th>Status Hadir</th>
                    <th>Nama Dosen</th>
                    <th>Tanggal</th>
                    <th >Absen Mahasiswa</th>   
                  </tr>
                </thead>
                <tbody>
                    <?php for($no=1;$no<=36;$no++){ ?>
                      <tr>
                        <td><?php echo " Ke-".$no; ?></td>
                        <td>
                          <?php 
                            if ($data_absen_dosen[0]['validasi'] == "1") {
                              echo $data_absen_dosen[0]['hr_'.$no];
                            }
                            elseif($data_absen_dosen[0]['hr_'.$no] != "0000-00-00" or null){ ?>
                            <select class="col-md-12 col-xs-12"  id="absen_hadir_dosen<?php echo $no ?>" onchange="pilih_dosen(<?php echo $no ?>)" name="status_absen_dosen<?php echo $no ?>">
                              <?php foreach ($data_riwayat_dosen as $riwayat_dosen) {
                                if ($riwayat_dosen['Pertemuan'] == $no ) {
                                  if ($riwayat_dosen["status_absen"] == "1") {
                                    echo "<option value='1' selected>Hadir</option>";
                                    echo "<option value='2' >Digantikan</option>";
                                    echo "<option value='0' >Tidak Hadir</option>";
                                  }
                                  elseif ($riwayat_dosen["status_absen"] == "2") {
                                    echo "<option value='1' >Hadir</option>";
                                    echo "<option value='2' selected>Digantikan</option>";
                                    echo "<option value='0' >Tidak Hadir</option>";
                                  }
                                  else{
                                    echo "<option value='1' >Hadir</option>";
                                    echo "<option value='2' >Digantikan</option>";
                                    echo "<option value='0' selected>Tidak Hadir</option>";
                                  }
                                }
                              }?>
                            </select>
                          <?php }else{ ?>
                            <select class="col-md-12 col-xs-12" id="absen_hadir_dosen<?php echo $no ?>" onchange="pilih_dosen(<?php echo $no ?>)" name="status_absen_dosen<?php echo $no ?>">
                              <option value='1' >Hadir</option>"
                              <option value='2' >Digantikan</option>"
                              <option value='0' selected >Tidak Hadir</option>"
                            </select>
                          <?php } ?>
                        </td>
                        <td>
                          <?php 

                            if ($data_absen_dosen[0]['validasi'] == "1") {
                              foreach ($data_riwayat_dosen as $riwayat_dosen) {
                                if ($riwayat_dosen['Pertemuan'] == $no) {
                                  if ($riwayat_dosen['status_absen'] == "1") { 
                                    echo $data_absen_dosen[0]['nama_dosen']; 
                                  }
                                  elseif ($riwayat_dosen['status_absen'] == "2") {
                                    echo $riwayat_dosen['nama_dosen'];
                                  }
                                  else{
                                    echo "Tidak Hadir";
                                  }
                                }
                              }
                            }

                            else {
                              if ($data_absen_dosen[0]['hr_'.$no] != "0000-00-00" or null) {
                                foreach ($data_riwayat_dosen as $riwayat_dosen) {
                                    if ($riwayat_dosen['Pertemuan'] == $no) {
                                        if ($riwayat_dosen['status_absen'] == "1") { ?>
                                                <div id="dosen_penanggungjawab<?php echo $no ?>" >
                                                    <select id="id_dosen_penanggungjawab<?php echo $no ?>" name="id_dosen_penanggungjawab<?php echo $no ?>" class="col-xs-12 col-md-12">
                                                        <option value="<?php echo $data_absen_dosen[0]['IDDosen']?>">
                                                        <?php echo $data_absen_dosen[0]['nama_dosen']; ?>
                                                        </option>
                                                    </select>
                                                </div>
                                                <div id="asisten_dosen<?php echo $no ?>" style="display: none;">
                                                    <select id="id_asisten_dosen<?php echo $no ?>" class="col-xs-12 col-md-12" name="id_asisten_dosen<?php echo $no ?>">
                                                        <?php foreach ($data_asisten_dosen as $asisten_dosen) {?>
                                                            <option value="<?php echo $asisten_dosen['IDDosen'] ?>" <?php if ($asisten_dosen['IDDosen'] == $riwayat_dosen['IDDosen']){ echo "selected";} ?>>
                                                            <?php echo $asisten_dosen['name'] ?>
                                                            </option>
                                                        <?php } ?>                                
                                                    </select>
                                                </div>
                                        <?php }
                                    elseif ($riwayat_dosen['status_absen'] == "2"){ ?>
                                        <div id="dosen_penanggungjawab<?php echo $no ?>" id="dosen_penanggungjawab<?php echo $no ?>" style="display: none;">
                                          <select id="id_dosen_penanggungjawab<?php echo $no ?>" class="col-xs-12 col-md-12" name="id_dosen_penanggungjawab<?php echo $no ?>">
                                            <option value="<?php echo $data_absen_dosen[0]['IDDosen']?>">
                                              <?php echo $data_absen_dosen[0]['nama_dosen']; ?>
                                            </option>
                                          </select>
                                        </div>
                                        <div id="asisten_dosen<?php echo $no ?>">
                                          <select id="id_asisten_dosen<?php echo $no ?>" name="id_asisten_dosen<?php echo $no ?>" class="col-xs-12 col-md-12">
                                            <?php foreach ($data_asisten_dosen as $asisten_dosen) {?>
                                                <option value="<?php echo $asisten_dosen['IDDosen'] ?>" <?php if ($asisten_dosen['IDDosen'] == $riwayat_dosen['IDDosen']){ echo "selected";} ?>>
                                                  <?php echo $asisten_dosen['name'] ?>
                                                </option>
                                            <?php } ?>                                
                                          </select>
                                        </div>
                                <?php }else{?>
                                        <div id="dosen_penanggungjawab<?php echo $no ?>" style="display: none;" >
                                        <select id="id_dosen_penanggungjawab<?php echo $no ?>" class="col-xs-12 col-md-12" name="id_dosen_penanggungjawab<?php echo $no ?>">
                                          <option value="<?php echo $data_absen_dosen[0]['IDDosen']?>">
                                            <?php echo $data_absen_dosen[0]['nama_dosen']; ?>
                                          </option>
                                        </select>
                                      </div>
                                      <div id="asisten_dosen<?php echo $no ?>" style="display: none;">
                                        <select id="id_asisten_dosen<?php echo $no ?>" class="col-xs-12 col-md-12">
                                          <?php foreach ($data_asisten_dosen as $asisten_dosen) {?>
                                              <!-- <option value="<?php echo $asisten_dosen['IDDosen'] ?>" <?php if ($asisten_dosen['IDDosen'] == $riwayat_dosen['IDDosen']){ echo "selected";} ?>> -->
                                              <option value="<?php echo $asisten_dosen['IDDosen'] ?>">
                                                <?php echo $asisten_dosen['name'] ?>
                                              </option>
                                          <?php } ?>                                
                                        </select>
                                      </div>
                                <?php }
                                  }
                                }
                              }
                              else{ ?>
                                <div id="dosen_penanggungjawab<?php echo $no ?>"  style="display: none;">
                                <select id="id_dosen_penanggungjawab<?php echo $no ?>" name="id_dosen_penanggungjawab<?php echo $no ?>" class="col-xs-12 col-md-12">
                                  <option value="<?php echo $data_absen_dosen[0]['IDDosen']?>">
                                    <?php echo $data_absen_dosen[0]['nama_dosen']; ?>
                                  </option>
                                </select>
                              </div>
                              <div id="asisten_dosen<?php echo $no ?>" style="display: none;">
                                <select id="id_asisten_dosen<?php echo $no ?>" name="id_asisten_dosen<?php echo $no ?>" class="col-xs-12 col-md-12">
                                  <?php foreach ($data_asisten_dosen as $asisten_dosen) {?>
                                      <option value="<?php echo $asisten_dosen['IDDosen'] ?>">
                                        <?php echo $asisten_dosen['name'] ?>
                                      </option>
                                  <?php } ?>                                
                                </select>
                              </div>
                          <?php  }
                            }
                          ?>

                        </td>
                        <td>
                          <?php 
                          if ($data_absen_dosen[0]['validasi'] == "1") {
                            if ($data_absen_dosen[0]['hr_'.$no]!= "0000-00-00") {
                              echo $data_absen_dosen[0]['hr_'.$no]; 
                            }
                            else{
                              echo "0000-00-00";
                            }
                          }else{
                            if ($data_absen_dosen[0]['hr_'.$no]!= "0000-00-00") {
                          ?>
                            <input id="tanggal<?php echo $no ?>" type="text" name="hr_<?php echo $no ?>" class="tanggal col-xs-12 col-md-12" value="<?php echo $data_absen_dosen[0]['hr_'.$no] ?>" >
                          <?php      
                              } else{
                          ?>
                            <input id="tanggal<?php echo $no ?>" type="text" name="hr_<?php echo $no ?>" class="tanggal col-xs-12 col-md-12"  style="display: none;" >
                          <?php      
                              } 
                          } ?>
                        </td>
                        <td align="center">
                          <?php if ($data_absen_dosen[0]['validasi'] == "1") { ?>
                            <?php if ($data_absen_dosen[0]['hr_'.$no]!= "0000-00-00") { ?>
                              <a class="btn btn-primary" id="absen_mahasiswa<?php echo $no ?>" onclick="show_modal(<?php echo $no?>)">
                                Lihat Absen Mahasiswa
                              </a>
                            <?php  } else{ ?>
                                Absen Dosen Belum terisi
                            <?php } ?>
                          <?php }else{ ?>
                            <?php if ($data_absen_dosen[0]['hr_'.$no]!= "0000-00-00") { ?>
                              <a class="btn btn-primary" id="absen_mahasiswa<?php echo $no ?>" onclick="show_modal(<?php echo $no?>)">
                                Isi Absen Mahasiswa
                              </a>
                            <?php  } else{ ?>
                                Absen Dosen Belum terisi
                            <?php } ?>
                          <?php } ?>
                        </td>
                      </tr>
                    <?php } ?>
                </tbody>
              </table>
              <input type="hidden" name="IDJADWAL" value="<?php echo $data_absen_dosen[0]['IDJADWAL']?>">
              <input type="hidden" name="Tahun" value="<?php echo $data_absen_dosen[0]['Tahun']?>">
              <input type="submit" class="btn  btn-success float-right" value="Simpan Absen">   
          </form>

      </div>
    </div>
  </div>

    <form id="myform">
      <div class="modal fade bs-example-modal-lg"  id="modal_absen" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none">
        <div class="modal-dialog" style="max-width: 90% !important;">
          <div class="modal-content">
            <div class="modal-header" style="margin: 0px">
              <h4 class="modal-title" id="myLargeModalLabel">Absen Mahasiswa</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" style="padding-top: 0px" >
              <div id="modal_absen_mahasiswa"></div>
            </div>
            <div class="modal-footer">
              <?php if ($data_absen_dosen[0]['validasi']== "1") { ?>
                <button type="button" class="btn btn-success waves-effect text-right pull-right" data-dismiss="modal">Tutup</button>
              <?php }else{ ?>
                <button type="button" class="btn btn-success waves-effect text-right pull-right" data-dismiss="modal" id="simpan_absen">Simpan</button>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </form>

    <form id="fromAbsenKumulatif">
      <div class="modal fade bs-example-modal-lg"  id="modalAbsenKumulatif" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none">
        <div class="modal-dialog" style="max-width: 70% !important;">
          <div class="modal-content">
            <div class="modal-header" style="margin: 0px">
              <h4 class="modal-title" id="myLargeModalLabel">Absen Mahasiswa (Kumulatif)</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" style="padding-top: 0px" >
              <div id="getPageAbsenKumulatif"></div>
            </div>
            <div class="modal-footer">
              <?php if ($data_absen_dosen[0]['validasi']== "1") { ?>
                <button type="button" class="btn btn-success waves-effect text-right pull-right" data-dismiss="modal">Tutup</button>
              <?php }else{ ?>
                <button type="submit" class="btn btn-success waves-effect text-right pull-right rounded" id="simpanAbsenKumulatif">Simpan</button>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </form>


    <form id="formBebanKerjaDosen">
      <div class="modal fade bs-example-modal-lg"  id="modalBebanKerjaDosen" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none">
        <div class="modal-dialog" style="max-width: 70% !important;">
          <div class="modal-content">
            <div class="modal-header" style="margin: 0px">
              <h4 class="modal-title" id="myLargeModalLabel"><i class="fa fa-users"></i> Beban Kerja Dosen</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" style="padding-top: 0px" >
              <form>
                <div class="form-group">
                  <label for="IDDosen">Dosen</label>
                  <select class="form-control col-xs-12">
                    <option value="<?= $data_absen_dosen[0]['IDDosen']?>"><?= $data_absen_dosen[0]['nama_dosen']?></option>
                    <?php foreach ($data_asisten_dosen as $asisten) { ?>
                      <option value="<?=$asisten['IDDosen']?>" > <?=$asisten['name']?></option>
                    <?php } ?>
                  </select>

                  <div id="previewBebanKerja"></div>

                </div>
              </form>
            </div>
            <div class="modal-footer">
              <?php if ($data_absen_dosen[0]['validasi']== "1") { ?>
                <button type="button" class="btn btn-success waves-effect text-right pull-right" data-dismiss="modal">Tutup</button>
              <?php }else{ ?>
                <button type="submit" class="btn btn-success waves-effect text-right pull-right rounded" id="simpanAbsenKumulatif">Simpan</button>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </form>





  <script type="text/javascript">

    $('#fromAbsenKumulatif').submit(function (event) {
        event.preventDefault();
    
        let url       = "<?= site_url('ademik/Absensi/sendDataAbsenKumulatif') ?>";
        let jp        = $('#jumlahPertemuan').val();
        let fields    = $('#fromAbsenKumulatif').serialize();
        let IDJadwal  = <?= '"'.$data_absen_dosen[0]['IDJADWAL'].'"' ?> 
        let semester  = <?= $data_absen_dosen[0]['Tahun'] ?> 

        $.ajax({
          method 	: "POST",
          url 	    : url,
          data 	    : fields
        })
        .done(function( dataResponse ) {
          if (dataResponse == null) {
            Swal.fire({
              type	: 'error',
              title	: 'Oops...',
              text	: 'Gagal Mengirim Data !',
            })		
          }{
              success_alert(); 
              $('#modalAbsenKumulatif').modal('toggle');
              $('.modal-backdrop').remove();
              absen_dosen_1(IDJadwal, semester);
          }
        })
    });

     $('#absenDosenHarian').submit(function (e) {
         e.preventDefault();

        let fields       = $("#absenDosenHarian").serializeArray();
        let c_url        = "<?php echo base_url('index.php/ademik/Absensi/update_absen_dosen');?>";
        let id_jadwal    = "<?php echo $data_absen_dosen[0]['IDJADWAL']?>" ;
          
          $.ajax({
            method  : "POST",
            url     : c_url,
            data    : fields
          })
          .done(function( dataResposnse ) {
            swal.closeModal();
            if ( dataResposnse == 2){
              Swal.fire({
                type  : 'error',
                title : 'Oops...',
                text  : '<?php  echo validation_errors() ?>',
              })
            }
            else if (dataResposnse == 1){
              Swal({
                type  : 'success',
                title : 'Data tersimpan'
              })
              absen_dosen_1(id_jadwal);
            }
            else{
              // Swal.fire({
              //   type  : 'error',
              //   title : 'Gagal Menyimpan',
              //   text  : dataResposnse,
              // })  
              console.log(dataResposnse)
            }
          })
          .fail(function ( dataResposnse) {
            Swal.fire({
              type  : 'error',
              title : 'Oops...',
              text  : 'Gagal menghubungkan ke server',
            })
          });
      })
    function cetak_anbsen_5 (start, end){
      alert(start+" "+end);
      var url = "<?php echo base_url('ademik/report/Report/cetak_absensi_mahasiswa_5') ?>";

      $.post(
        url,
        {
          start       : start,
          end         : end,
          IDJADWAL    : "<?php echo $data_absen_dosen[0]['IDJADWAL']?>",
          Tahun       : "<?php echo $data_absen_dosen[0]['Tahun']?>",
        }
      );
    }

    function showModalAbsenKumulatif() {
        $('#modalAbsenKumulatif').modal({
          'backdrop' : 'static'
        });

        loading_alert()

        var IDJadwal = "<?php echo $data_absen_dosen[0]['IDJADWAL'] ?>";
        var semester  = "<?php echo $data_absen_dosen[0]['Tahun'] ?>";

        if (<?= $data_absen_dosen[0]['validasi'];?> == "1") {
          var url = "<?php echo base_url('index.php/ademik/absensi/absen_mahasiswa_view') ?>";
        }
        else{
          var url = "<?php echo base_url('index.php/ademik/absensi/absenKumulatifMahasiswa') ?>";
        }

        $.post(
          url,
          {
             IDJadwal  : IDJadwal,
             semester   : semester         
          }
        )
        .done(function (data) {
          $("#getPageAbsenKumulatif").html(data);
		  swal.closeModal();

        })
        .fail(function () {
          alert('gagal update absen');
        });

    }

    function showModalrekapDosen() {
      $('#modalBebanKerjaDosen').modal({
        'backdrop' : 'static'
      });


      let url = "<?= base_url('') ?>"
      $.post(
        url,
        {
           IDJadwal  : IDJadwal,
           semester   : semester         
        }
      )
      .done(function (data) {
        $("#getPageAbsenKumulatif").html(data);
        swal.closeModal();
      })
      .fail(function () {
        alert('gagal update absen');
      });



      loading_alert()
      swal.closeModal();
    }




    function show_modal(no) {
      // alert('cek');
        $('#modal_absen').modal({
          'backdrop' : 'static'
        });

        var id_jadwal = "<?php echo $data_absen_dosen[0]['IDJADWAL'] ?>";
        var semester  = "<?php echo $data_absen_dosen[0]['Tahun'] ?>";

        if (<?php echo $data_absen_dosen[0]['validasi'];?> == "1") {
          var url = "<?php echo base_url('index.php/ademik/absensi/absen_mahasiswa_view') ?>";
        }
        else{
          var url = "<?php echo base_url('index.php/ademik/absensi/absen_mahasiswa') ?>";
        }

        $.post(
          url,
          {
             id_jadwal  : id_jadwal,
             pertemuan  : no,
             semester   : semester         
          }
        )
        .done(function (data) {
          $("#modal_absen_mahasiswa").html(data);
        })
        .fail(function () {
          alert('gagal update absen');
        });

    }

    function pilih_dosen (no) {
      var status_absen_dosen = $("#absen_hadir_dosen"+no).val();

      if (status_absen_dosen==2) {
        $("#asisten_dosen"+no).show();
        $("#dosen_penanggungjawab"+no).hide();
        $("#tanggal"+no).show();
      }
      else if (status_absen_dosen==1){
        $("#asisten_dosen"+no).hide();
        $("#dosen_penanggungjawab"+no).show();
        $("#tanggal"+no).show();

      }
      else{
        $("#asisten_dosen"+no).hide();
        $("#dosen_penanggungjawab"+no).hide();
        $("#tanggal"+no).hide();
      }
    }

    function absen_dosen_2(no) {
      var absen_hadir_dosen = $('#absen_hadir_dosen'+no).val();
      var id_dosen          = $('#id_dosen'+no).val();
      var date              = $('#tanggal'+no).datepicker("getDate");
      var tanggal           = $.datepicker.formatDate("yy-mm-dd", date);
      var id_jadwal         = "<?php echo $data_absen_dosen[0]['IDJADWAL']?>";
      var semester          = "<?php echo $data_absen_dosen[0]['Tahun']?>";

      if (date==null) {
        error_alert();
      }
      else{
        if (absen_hadir_dosen == 1) {
          var id_dosen          = $('#id_dosen_penanggungjawab'+no).val();
        }
        else if(absen_hadir_dosen == 2){
          var id_dosen          = $('#id_asisten_dosen'+no).val();
        }

        $.post(
          "<?php echo base_url('index.php/ademik/Absensi/Update_absen_dosen') ?>",
          {
             status_absen_dosen : absen_hadir_dosen,
             pertemuan_ke       : no,
             id_jadwal          : id_jadwal,
             id_dosen           : id_dosen,
             tanggal            : tanggal,
             semester           : semester 
          }
        )
        .done(function () {
          success_alert_load(id_jadwal);
        })
        .fail(function () {
          alert('gagal update absen');
        });
      }
    }

    $('#btn_kembali').click(function () {

      let c_url       = "<?php echo site_url('ademik/Absensi/data_jadwal');?>";
      let fields      = {
                          "semester" : "<?php echo $data_absen_dosen[0]['Tahun']; ?>",
                          "program"  : "<?php echo $data_absen_dosen[0]['Program']; ?>",
                          "jurusan"  : "<?php echo $data_absen_dosen[0]['KodeJurusan']; ?>",
                        };
      
      loading_alert();
      
      $.ajax({
        method  : "POST",
        url     : c_url,
        data    : fields
      })
      .done(function( dataResposnse ) {
        swal.closeModal();
        if (dataResposnse === null) {
          Swal.fire({
            type  : 'error',
            title : 'Oops...',
            text  : 'Data tidak ditemukan !',
          })    
        }
        $('#jadwal_matakuliah').html(dataResposnse);
      })
      .fail(function ( dataResposnse) {
        Swal.fire({
          type  : 'error',
          title : 'Oops...',
          text  : 'Gagal menghubungkan ke server',
        })
      });

    });          

    $('.table_absen_mahasiswa').DataTable({
      "ordering": false,
      "searching": false,
      "lengthMenu": [[5, 10, 20], [5, 10, 20]]
    });

    $(".tanggal" ).datepicker({
        format: "yyyy-mm-dd",
        language: "fr",
        changeMonth: true,
        changeYear: true
    });            

    $("#simpan_absen").click(function () {
      success_alert();
    })

  </script>