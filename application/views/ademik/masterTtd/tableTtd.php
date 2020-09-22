<div class="content-wrapper">
    <section class="content-header">
        <h3>
            Master Tanda Tangan
        </h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('/menu/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="#">Utility</a></li>
            <li class="breadcrumb-item active">Master Tanda Tangan</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-default">
            <div class="box-body">
                <table class="table table-hover" id="tabelJurusan">
                    <thead class="dark">
                        <tr> 
                            <th align="center">#</th>
                            <th align="center">Kode</th>
                            <th align="center">Jurusan</th>
                            <th align="center">Jenjang</th>
                            <th align="center">Proses</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no=1;
                            foreach ($dataTtd as $ttd ) {
                        ?>
                        <tr>
                            <td><?= $no?></td>
                            <td><?= $ttd['Kode']?></td>
                            <td><?= $ttd['Nama_Indonesia']?></td>
                            <td><?= $ttd['Ket_Jenjang'] == 'Umum' ? 'S1' : $ttd['Ket_Jenjang'];?></td>
                            <td>
                                <button class="btn btn-warning btn-circle" data-toggle="modal" data-target="#modalEdit" onclick='modalEditTtd("<?= $ttd['Kode']?>")'>
                                    <i class="fa fa-pencil"></i>
                                </button>
                            </td>
                        </tr>
                        <?php $no++; }?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <form id="formTtd">
        <div class="modal fade" id="modalEdit">
            <div class="modal-dialog modal-full">
                <div id="content"></div>
            </div>
        </div>
    </form>


</div>