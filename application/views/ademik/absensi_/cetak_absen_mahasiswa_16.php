<?php
    //Setup Data

    $tahun              = $data_jadwal[0]['Tahun'];
    $semester_          = substr($tahun, -1 );
    $tahun_semester_1   = substr($tahun, 0, 4); 
    $tahun_semester_2   = $tahun_semester_1 + 1; 

    if ($semester_ == '1') {
        $semester = "GASAL ".$tahun_semester_1." - ".$tahun_semester_2;
    }
    else{
        $semester = "GENAP ".$tahun_semester_1." - ".$tahun_semester_2;
    }

    if(count($data_asisten_dosen) == 0){
        $data_asisten_dosen = "";
    }else{
        $data_asisten_dosen = $data_asisten_dosen;
    }

?>

<?php 
    if ($this->session->userdata('ulevel')== 1) {
        print_r($data_asisten_dosen);
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Absensi Mahasiswa Pertemun 1-16</title>
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/components/bootstrap/dist/css/bootstrap.min.css'); ?>">
        <style type="text/css">
            #logo_untad{
                position: absolute;
                left: 0px;
                top: 0px;
                z-index: -1;
                float: left;
            }

            .table-absen{
                width: 100%; 
                margin-bottom: 10px;" 
                style="font-size: 10px; 
                width: 100%; 
                margin-bottom: 10px; 
                border:1px solid black; 
                border-collapse: collapse; 
            }
            
            .text {
                display: block;
                width: 200px;
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
            }
        </style>
    </head>
    <body>

        <!-- Sampul untuk fakultas ekonomi -->
            <div class="cover" align="center" style="padding-top: 30px;">
                <h2 align="center"><b>DAFTAR HADIR KULIAH</b></h2>
                <h3 align="center" style="margin-bottom: 2px;"><b>SEMESTER <?= $semester; ?></b></h3>
                <br>
                <img src="./assets/images/Logo_untad.png" width="80px" style="margin-bottom: 30px;" align="center">
                <br>
                <?php 
                    if ($this->session->userdata('kdf') == 'C') {
                        echo '<h5 align="center">FAKULTAS EKONOMI DAN BISNIS</h5>' ;
                    }
                    elseif($this->session->userdata('kdf') == 'D'){
                        echo '<h5 align="center">FAKULTAS HUKUM</h5>' ;
                    }                   
                     elseif($this->session->userdata('kdf') == 'F'){
                        echo '<h5 align="center">FAKULTAS TEKNIK</h5>' ;
                    }
                    else{
                        echo '' ;
                    }
                 ?>
                
                <h5 align="center">Jurusan/Prodi : <?= $data_jadwal[0]['nama_jurusan']; ?> </h5>
                <h5 align="center" style="margin-bottom: 30px;">Mata Kuliah : <?= $data_jadwal[0]['NamaMK']; ?></h5>
                <br>
                <h4 align="center">Dosen :</h4>
                    <?php 
                        echo $data_jadwal[0]['nama_dosen']."<br>";
                        if (is_array($data_asisten_dosen) || is_object($data_asisten_dosen)){
                            foreach( $data_asisten_dosen as $asdos){
                                echo $asdos['nama_assdosen']."<br>"; 
                            }
                        }
                        else{ 
                            echo $data_asisten_dosen; 
                        } 
                    ?>
                <br>
                <h4 align="center" style="margin-top: 30px;">Hari    : <?= $data_jadwal[0]['Hari']; ?></h4>
                <h4 align="center">Jam     : <?= $data_jadwal[0]['JamMulai'].'-'.$data_jadwal[0]['JamSelesai']?></h4>
                <h4 align="center">Ruang   : <?= $data_jadwal[0]['KodeRuang']; ?></h4>
                <h4 align="center">Kelas   : <?= $data_jadwal[0]['Keterangan']; ?></h4>
            </div>
        <pagebreak></pagebreak>
        <div id="pdf">
            <div class="col-md-12">
                <div class="row">
                        <img src="./assets/images/Logo_untad.png" width="80px" style="float: left;" align="center">
                        <div>
                            <table width="100%">
                                <tr>
                                    <th align="center"><h4>KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN</h4></th>
                                </tr>
                                <tr>
                                    <th align="center"><h4>UNIVERSITAS TADULAKO</h4></th>
                                </tr>
                                <tr>
                                    <th align="center"><h4>DAFTAR HADIR MAHASISWA</h4></th>
                                </tr>
                            </table>            
                        </div>          
                </div>
            </div>
            
            <hr style="margin-top: 5px; background-color: black; height: 5px;">
                <table style="margin-bottom: 10px">
                    <tr>
                        <th align="left" width="100px">Program</th>
                        <td width="2px">:</td>
                        <td style="width: 300px" align="left"><?php echo $data_jadwal[0]['Program']; ?></td>
                        <th align="left" width="150px">Hari</th>
                        <td>:</td>
                        <td><?= $data_jadwal[0]['Hari']; ?></td>
                    </tr>
                    <tr>
                        <th align="left" >Semester</th>
                        <td width="2px">:</td>
                        <td>
                            <?= $semester; ?>
                        </td>
                        <th align="left" >Waktu</th>
                        <td>:</td>
                        <td><?= $data_jadwal[0]['JamMulai'].'-'.$data_jadwal[0]['JamSelesai']?></td>
                    </tr>
                    <tr>
                        <th align="left" >Jurusan</th>
                        <td>:</td>
                        <td><?= $data_jadwal[0]['nama_jurusan']; ?></td>
                        <th align="left" >Ruang</th>
                        <td>:</td>
                        <td><?= $data_jadwal[0]['KodeRuang']; ?></td>
                    </tr>
                    <tr>
                        <th align="left" >Mata Kuliah</th>
                        <td>:</td>
                        <td style="width: 500px" align="left">
                            <?= $data_jadwal[0]['KodeMK'].'-'.$data_jadwal[0]['NamaMK']; ?>
                        </td>
                        <th align="left" >Dosen Penanggung Jawab</th>
                        <td>:</td>
                        <td><?= $data_jadwal[0]['nama_dosen']; ?></td>
                    </tr>
                    <tr>
                        <th></th>
                        <td></td>
                        <td style="width: 450px" align="left"></td>
                        <th align="left">Dosen</th>
                        <td>:</td>
                        <td>
                            <table>
                                <?php 
                                    if (is_array($data_asisten_dosen) || is_object($data_asisten_dosen)){
                                        foreach( $data_asisten_dosen as $asdos){?>
                                <tr>
                                    <td><?= $asdos['nama_assdosen'] ?></td>
                                </tr>
                                <?php }}else{ echo $data_asisten_dosen; } ?>
                            </table>
                        </td>
                    </tr>

                </table>    

            <table class="table-absen" border="1">
                <thead>
                    <tr >
                        <th align="center" rowspan="2">No.</th>
                        <th align="center" rowspan="2">NIM</th>
                        <th align="center" rowspan="2">Nama Mahasiswa</th>
                        <th align="center" colspan="16">Pertemuan ke </th>
                        <th align="center" rowspan="2">Ket</th>
                    </tr>
                    <tr>
                        <?php for ($i=1; $i <=16 ; $i++) { ?>
                            <th align="center"><?php echo $i; ?></th>
                        <?php }; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach ($data_jadwal as $mahasiswa) { ?>
                    <tr>
                        <td align="center"><?= $no ?></td>
                        <td><?= $mahasiswa['NIM'] ?></td>
                        <td class="text"><?= $mahasiswa['nama_mahasiswa'] ?></td>
                        <?php for ($i=1; $i <=16 ; $i++) { ?>
                            <td align="center" height="35px;" width="50px;"></td>
                        <?php }; ?>
                        <td> </td>
                    </tr>
                    <?php
                        if(count($data_jadwal) < 15 && $no == 13 ){
                            echo '
                                        </tbody>
                                    </table>
                                    <pagebreak>
                                    <table border="1" class="table-absen">
                                        <tbody>
                                ';
                        }
                
                    $no++; } 
                
                    if($this->session->userdata('kdf')=="C" or $this->session->userdata('ulevel')== 1 ){
                ?>
                    <tr>
                        <td colspan="3" align="center">Tanggal</td>
                        <?php for ($i=1; $i <=16 ; $i++) { ?>
                            <td align="center" height="35px;" width="50px;"></td>
                        <?php }; ?>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center"><?= $data_jadwal[0]['nama_dosen']; ?></td>
                        <?php for ($i=1; $i <=16 ; $i++) { ?>
                            <td align="center" height="35px;" width="50px;"></td>
                        <?php }; ?>
                        <td></td>
                    </tr>
                    <?php foreach( $data_asisten_dosen as $asdos){?>
                    <tr>
                        <td colspan="3" align="center"><?= $asdos['nama_assdosen'] ?></td>
                        <?php for ($i=1; $i <=16 ; $i++) { ?>
                            <td align="center" height="35px;" width="50px;"></td>
                        <?php }; ?>
                        <td></td>
                    </tr>
                    <?php }?>

                <?php } ?>

                </tbody>
            </table>
            <div class="row" style="padding-left: 74%">
                <dl>
                    <dt>Palu, <?php echo date("d-m-Y"); ?></dt>
                    <dt>Dosen Penanggung Jawab,</dt>
                    <br><br><br>
                    <dt><u><?php echo $data_jadwal[0]['nama_dosen']; ?></u></dt>
                    <dt>NIP.<?php echo $data_jadwal[0]['IDDosen']; ?></dt>
                </dl>
            </div>
        </div>
    <body>
</html>