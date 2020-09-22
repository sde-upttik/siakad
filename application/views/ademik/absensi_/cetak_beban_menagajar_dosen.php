<?php
    //Setup Data
    $semester_          = substr($tahun, -1 );
    $tahun_semester_1   = substr($tahun, 0, 4); 
    $tahun_semester_2   = $tahun_semester_1 + 1; 

    if ($semester_ == '1') {
        $semester       = "GANJIL ".$tahun_semester_1." - ".$tahun_semester_2;
    }
    elseif(semester_ == '2'){
        $semester       = "GENAP ".$tahun_semester_1." - ".$tahun_semester_2;
    }
    else{
        $semester       = "ANTARA ".$tahun_semester_1." - ".$tahun_semester_2;
    }

$month = array(
                "Januari",        
                "Februari",        
                "Maret",        
                "April", 
                "Mei",                       
                "Juni",        
                "Juli",        
                "Agustus",        
                "September",        
                "Oktober",        
                "November",        
                "Desember",        
        );

?>


<!DOCTYPE html>
<html>
    <head>
        <title>BEBAN MENGAJAR DOSEN</title>
        <!-- <link rel="stylesheet" type="text/css" href="<?= base_url('assets/components/bootstrap/dist/css/bootstrap.min.css'); ?>"> -->
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

            @media print {
			    .pagebreak { page-break-before: always; } /* page-break-after works, as well */
			}
        </style>
    </head>
    <body>
        <?php 
            if (empty($matakuliah_pengampuh)) {
                $matakuliah_pengampuh[0]['Name'] ='';
                $matakuliah_pengampuh[0]['nip'] ='';
                $matakuliah_pengampuh[0]['KodeMK'] ='';
                $matakuliah_pengampuh[0]['Nama_Indonesia'] ='';
                $matakuliah_pengampuh[0]['SKS'] ='';
                $matakuliah_pengampuh[0]['keterangan'] ='';
                $matakuliah_pengampuh[0]['Jumlah_mhs'] ='';
                $matakuliah_pengampuh[0]['Jumlah_dosen'] ='';
                $matakuliah_pengampuh[0]['Jumlah_pertemuan'] ='';
                $matakuliah_pengampuh[0]['Keterangan'] ='';
                $matakuliah_pengampuh[0]['KodeJurusan'] ='';
            }

            if (empty($matakuliah_pendamping)) {
                $matakuliah_pendamping[0]['Name'] ='';
                $matakuliah_pendamping[0]['nip'] ='';
                $matakuliah_pendamping[0]['KodeMK'] ='';
                $matakuliah_pendamping[0]['Nama_Indonesia'] ='';
                $matakuliah_pendamping[0]['SKS'] ='';
                $matakuliah_pendamping[0]['keterangan'] ='';
                $matakuliah_pendamping[0]['Jumlah_mhs'] ='';
                $matakuliah_pendamping[0]['Jumlah_dosen'] ='';
                $matakuliah_pendamping[0]['Jumlah_pertemuan'] ='';
                $matakuliah_pendamping[0]['Keterangan'] ='';
                $matakuliah_pendamping[0]['KodeJurusan'] ='';
            }

            // echo "<pre>";
            // print_r($matakuliah_pengampuh);
            // echo "</pre>";
            
            // print_r($this->db->last_query());

         ?>
        <div class="col-md-12">
            <div class="row">
                    <img src="./assets/images/Logo_untad.png" width="80px" style="float: left;" align="center">
                    <div>
                        <table width="100%">
                            <tr>
                                <th align="center"><h4>KEMENTRIAN RISET, TEKNOLOGI, DAN PENDIDIKAN TINGGI</h4></th>
                            </tr>
                            <tr>
                                <th align="center"><h4>UNIVERSITAS TADULAKO</h4></th>
                            </tr>
                            <tr>
                                <th align="center"><h4>FAKULTAS HUKUM</h4></th>
                            </tr>
                        </table>            
                    </div>          
            </div>
        </div>
        <hr>

        <h3 align="center" style="margin: 0;padding: 0"><u>SURAT KETERANGAN</u></h3>
        <h6 align="center" style="margin: 0;">No............../UN28.1.11/PP/<?= date("Y"); ?></h6>
        <br>
        Dekan Fakultas Hukum Universitas Tadulako, dengan ini menerangkan bahwa :
        <table>
            <tr>
                <td>Nama</td>
                <td>: <?php 
                		if (empty($matakuliah_pengampuh[0]['Name'] )) {
                			echo $matakuliah_pendamping[0]['Name'];
                		}else{
                			echo $matakuliah_pengampuh[0]['Name'];
                		}
                	?></td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>: <?php 
                		if (empty($matakuliah_pengampuh[0]['nip'] )) {
                			echo $matakuliah_pendamping[0]['nip'];
                		}else{
                			echo $matakuliah_pengampuh[0]['nip'];
                		}
                	?></td>
            </tr>
            <tr>
                <td>Pangkat/Golongan</td>
                <td>:<?= $pangkat ?></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:<?= $jabatan ?></td>
            </tr>
            <tr>
                <td>Prodi/Bagian</td>
                <td>: <?php 
            		if (empty($matakuliah_pengampuh[0]['nama_jurusan'] )) {
            			echo $matakuliah_pendamping[0]['nama_jurusan'];
            		}else{
            			echo $matakuliah_pengampuh[0]['nama_jurusan'];
            		}
            	?></td>
            </tr>
        </table>
        <p align="justify">
            Telah melaksanakan beban tugas mengajar berdasarkan surat keputusan Dekan Fakultas Hukum Universitas Tadulako Nomor 7497/UN28.1.11/PP/2019 tentang Pengangkatan Tim Pengampu Matakuliah Semester <?= $semester?>
            tanggal 14 Agustus 2019, dengan mata kuliah masing-masing sebagai berikut :
        </p>

        <table width="100%" border="1" class="table-absen" style="margin-top: 5px; margin-bottom: 5px;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode MK</th>
                    <th>Nama MK</th>
                    <th>Jumlah SKS</th>
                    <th>Kelas</th>
                    <th>Jumlah Mahasiswa</th>
                    <th>Jumlah Pertemuan yang dilakukan</th>
                    <th>Total Pertemuan</th>
                    <th>Ket</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                	$no=1;
            		if (!empty($matakuliah_pengampuh[0]['nama_jurusan'] )) {
               			foreach ($matakuliah_pengampuh as $beban) { 
               	?>
                    <tr>
                        <td><?= $no?></td>
                        <td><?= $beban['KodeMK'] ?></td>
                        <td><?= $beban['Nama_Indonesia'] ?></td>
                        <td align="center"><?= $beban['SKS'] ?></td>
                        <td align="center"><?= $beban['Keterangan'] ?></td>
                        <td align="center"><?= $beban['Jumlah_mhs'] ?></td>
                        <td align="center"><?= $beban['Jumlah_dosen'] ?></td>
                        <td align="center"><?= $beban['Jumlah_pertemuan'] ?></td>
                        <td align="center"><?= $beban['Program'] ?></td>
                    </tr>
                <?php 
                	$no++;}}
                	 foreach ($matakuliah_pendamping as $beban) { 
                ?>
                    <tr>
                        <td><?= $no?></td>
                        <td><?= $beban['KodeMK'] ?></td>
                        <td><?= $beban['Nama_Indonesia'] ?></td>
                        <td align="center"><?= $beban['SKS'] ?></td>
                        <td align="center"><?= $beban['Keterangan'] ?></td>
                        <td align="center"><?= $beban['Jumlah_mhs'] ?></td>
                        <td align="center"><?= $beban['Jumlah_dosen'] ?></td>
                        <td align="center"><?= $beban['Jumlah_pertemuan'] ?></td>
                        <td align="center"><?= $beban['Program'] ?></td>
                    </tr>
                <?php $no++;} ?>
            </tbody>
        </table>

        <?php if ($no == 13 || $no == 11) {
        	echo "<pagebreak>";
        }?>

        Demikian surat keterangan ini dibuat di pergunakan sebagaimana mestinya.
        <div class="row" style="padding-left: 55%">
            <dl>
                <dt>Palu, <?php echo date("d")." ".$month[date("m")-1]." ".date("Y"); ?></dt>
                <dt>An. Dekan,</dt>
                <dt>Wakil Dekan Bidang Akademik </dt>
                <br><br><br>
                <dt><u>Dr. LEMBANG PALIPADANG, S.H, M.H.</u></dt>
                <dt>NIP. 19630526 198903 1 002</dt>
            </dl>
        </div>
    <body>
</html>