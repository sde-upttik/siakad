<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Master Tanda Tangan </h5>
        <button type="button" class="close " data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item"> 
                <a class="nav-link active show" data-toggle="tab" href="#tab1" role="tab" aria-selected="true">
                    <span class="hidden-sm-up">
                        <i class="ion-person"></i>
                    </span> 
                    <span class="hidden-xs-down">Pejabat Prodi</span>
                </a> 
            </li>
            <li class="nav-item"> 
                <a class="nav-link" data-toggle="tab" href="#tab2" role="tab" aria-selected="true">
                    <span class="hidden-sm-up">
                        <i class="ion-briefcase"></i>
                    </span> 
                    <span class="hidden-xs-down">Pejabat Jurusan</span>
                </a> 
            </li>
            <li class="nav-item"> 
                <a class="nav-link" data-toggle="tab" href="#tab3" role="tab" aria-selected="true">
                    <span class="hidden-sm-up">
                        <i class="ion-calendar"></i>
                    </span> 
                    <span class="hidden-xs-down">Wadek Bid. Akd</span>
                </a> 
            </li>
            <li class="nav-item"> 
                <a class="nav-link" data-toggle="tab" href="#tab4" role="tab" aria-selected="true">
                    <span class="hidden-sm-up"> 
                        <i class="ion-podium"></i>
                    </span> 
                    <span class="hidden-xs-down">Kartu Ujian</span>
                </a> 
            </li>
            <li class="nav-item"> 
                <a class="nav-link" data-toggle="tab" href="#tab5" role="tab" aria-selected="true">
                    <span class="hidden-sm-up">
                        <i class="ion-card"></i>
                    </span> 
                    <span class="hidden-xs-down">KHS</span>
                </a> 
            </li>
            <li class="nav-item"> 
                <a class="nav-link" data-toggle="tab" href="#tab6" role="tab" aria-selected="true">
                    <span class="hidden-sm-up">
                        <i class="ion-clipboard"></i>
                    </span> 
                    <span class="hidden-xs-down">Transkrip Nilai</span>
                </a> 
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active show" id="tab1" role="tabpanel">
                <br>
                <div class="form-group">
                    <label for="TTJabatan1">Jabatan Program Studi :</label>
                    <input type="TTJabatan1" class="form-control " id="TTJabatan1"  name="TTJabatan1"  value="<?= $dataTtd[0]['TTJabatan1']?>">
                </div>
                <div class="form-group">
                    <label for="TTPejabat1">Nama Pejabat Program Studi :</label>
                    <input type="TTPejabat1" class="form-control " id="TTPejabat1" name="TTPejabat1" value="<?= $dataTtd[0]['TTPejabat1']?>">
                </div>
                <div class="form-group">
                    <label for="TTnippejabat1">NIP Pejabat Program Studi :</label>
                    <input type="TTnippejabat1" class="form-control " id="TTnippejabat1" name="TTnippejabat1" value="<?= $dataTtd[0]['TTnippejabat1']?>">
                </div>
            </div>
            <div class="tab-pane" id="tab2" role="tabpanel">
                <br>
                <div class="form-group ">
                    <label for="TTJabatan2">Jabatan jurusan :</label>
                    <input type="TTJabatan2" class="form-control" id="TTJabatan2" name="TTJabatan2" value="<?= $dataTtd[0]['TTJabatan2']?>">
                </div>
                <div class="form-group ">
                    <label for="TTPejabat2">Nama Pejabat jurusan :</label>
                    <input type="TTPejabat2" class="form-control" id="TTPejabat2" name="TTPejabat2" value="<?= $dataTtd[0]['TTPejabat2']?>">
                </div>
                <div class="form-group ">
                    <label for="TTnippejabat2">NIP Pejabat jurusan :</label>
                    <input type="TTnippejabat2" class="form-control" id="TTnippejabat2" name="TTnippejabat2" value="<?= $dataTtd[0]['TTnippejabat2']?>">
                </div>
            </div>
            <div class="tab-pane" id="tab3" role="tabpanel">
                <br>
                <div class="form-group ">
                    <label for="TTJabatan3">Jabatan Bid.Akademik :</label>
                    <input type="TTJabatan3" class="form-control" id="TTJabatan3" name="TTJabatan3" value="<?= $dataTtd[0]['TTJabatan3']?>">
                </div>
                <div class="form-group ">
                    <label for="TTPejabat3">Nama Pejabat Bid.Akademik :</label>
                    <input type="TTPejabat3" class="form-control" id="TTPejabat3" name="TTPejabat3" value="<?= $dataTtd[0]['TTPejabat3']?>">
                </div>
                <div class="form-group ">
                    <label for="TTnippejabat3">NIP Pejabat Bid.Akademik :</label>
                    <input type="TTnippejabat3" class="form-control" id="TTnippejabat3" name="TTnippejabat3" value="<?= $dataTtd[0]['TTnippejabat3']?>">
                </div>
            </div>
            <div class="tab-pane" id="tab4" role="tabpanel">
                <br>
                <div class="form-group ">
                    <label for="TTJabatanKUjian">Jabatan Kartu Ujian :</label>
                    <input type="TTJabatanKUjian" class="form-control" id="TTJabatanKUjian" name="TTJabatanKUjian" value="<?= $dataTtd[0]['TTJabatanKUjian']?>">
                </div>
                <div class="form-group ">
                    <label for="TTPejabatKUjian">Nama Pejabat Kartu Ujian :</label>
                    <input type="TTPejabatKUjian" class="form-control" id="TTPejabatKUjian" name="TTPejabatKUjian" value="<?= $dataTtd[0]['TTPejabatKUjian']?>">
                </div>
                <div class="form-group ">
                    <label for="TTnippejabatKUjian">NIP Pejabat Kartu Ujian :</label>
                    <input type="TTnippejabatKUjian" class="form-control" id="TTnippejabatKUjian" name="TTnippejabatKUjian" value="<?= $dataTtd[0]['TTnippejabatKUjian']?>">
                </div>
                <input type="hidden" name="Kode" value="<?= $dataTtd[0]['Kode']?>">
            </div>
            <div class="tab-pane" id="tab5" role="tabpanel">
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="TTJabatanKHS">Jabatan KHS :</label>
                            <input type="TTJabatanKHS" class="form-control " id="TTJabatanKHS"  name="TTJabatanKHS"  value="<?= $dataTtd[0]['TTJabatanKHS']?>">
                        </div>
                        <div class="form-group">
                            <label for="TTPejabatKHS">Nama Pejabat KHS :</label>
                            <input type="TTPejabatKHS" class="form-control " id="TTPejabatKHS" name="TTPejabatKHS" value="<?= $dataTtd[0]['TTPejabatKHS']?>">
                        </div>
                        <div class="form-group">
                            <label for="TTnippejabatKHS">NIP Pejabat KHS :</label>
                            <input type="TTnippejabatKHS" class="form-control " id="TTnippejabatKHS" name="TTnippejabatKHS" value="<?= $dataTtd[0]['TTnippejabatKHS']?>">
                        </div>
                    </div>
                    <div class="col-md-6 left-border">
                        <div class="form-group">
                            <label for="TTJabatanKHS2">Jabatan KHS 2:</label>
                            <input type="TTJabatanKHS2" class="form-control " id="TTJabatanKHS2"  name="TTJabatanKHS2"  value="<?= $dataTtd[0]['TTJabatanKHS2']?>">
                        </div>
                        <div class="form-group">
                            <label for="TTPejabatKHS2">Nama Pejabat KHS 2:</label>
                            <input type="TTPejabatKHS2" class="form-control " id="TTPejabatKHS2" name="TTPejabatKHS2" value="<?= $dataTtd[0]['TTPejabatKHS2']?>">
                        </div>
                        <div class="form-group">
                            <label for="TTnippejabatKHS2">NIP Pejabat KHS 2:</label>
                            <input type="TTnippejabatKHS2" class="form-control " id="TTnippejabatKHS2" name="TTnippejabatKHS2" value="<?= $dataTtd[0]['TTnippejabatKHS2']?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab6" role="tabpanel">
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="TTJabatanTn1">Jabatan Transkrip 1 :</label>
                            <input type="TTJabatanTn1" class="form-control " id="TTJabatanTn1"  name="TTJabatanTn1"  value="<?= $dataTtd[0]['TTJabatanTn1']?>">
                        </div>
                        <div class="form-group">
                            <label for="TTPejabatTn1">Nama Pejabat Transkrip 1 :</label>
                            <input type="TTPejabatTn1" class="form-control " id="TTPejabatTn1" name="TTPejabatTn1" value="<?= $dataTtd[0]['TTPejabatTn1']?>">
                        </div>
                        <div class="form-group">
                            <label for="TTnippejabatTn1">NIP Pejabat Transkrip 1 :</label>
                            <input type="TTnippejabatTn1" class="form-control " id="TTnippejabatTn1" name="TTnippejabatTn1" value="<?= $dataTtd[0]['TTnippejabatTn1']?>">
                        </div>
                    </div>
                    <div class="col-md-4 left-border">
                        <div class="form-group">
                            <label for="TTJabatanTn2">Jabatan Transkrip 2 :</label>
                            <input type="TTJabatanTn2" class="form-control " id="TTJabatanTn2"  name="TTJabatanTn2"  value="<?= $dataTtd[0]['TTJabatanTn2']?>">
                        </div> 
                        <div class="form-group">
                            <label for="TTPejabatTn2">Nama Pejabat Transkrip 2 :</label>
                            <input type="TTPejabatTn2" class="form-control " id="TTPejabatTn2" name="TTPejabatTn2" value="<?= $dataTtd[0]['TTPejabatTn2']?>">
                        </div>
                        <div class="form-group">
                            <label for="TTnippejabatTn2">NIP Pejabat Transkrip 2 :</label>
                            <input type="TTnippejabatTn2" class="form-control " id="TTnippejabatTn2" name="TTnippejabatTn2" value="<?= $dataTtd[0]['TTnippejabatTn2']?>">
                        </div>
                    </div>
                    <div class="col-md-4 left-border">
                        <div class="form-group">
                            <label for="TTJabatanTn3">Jabatan Transkrip 3  :</label>
                            <input type="TTJabatanTn3" class="form-control " id="TTJabatanTn3"  name="TTJabatanTn3"  value="<?= $dataTtd[0]['TTJabatanTn3']?>">
                        </div>
                        <div class="form-group">
                            <label for="TTPejabatTn3">Nama Pejabat Transkrip 3  :</label>
                            <input type="TTPejabatTn3" class="form-control " id="TTPejabatTn3" name="TTPejabatTn3" value="<?= $dataTtd[0]['TTPejabatTn3']?>">
                        </div>
                        <div class="form-group">
                            <label for="TTnippejabatTn3">NIP Pejabat Transkrip 3 :</label>
                            <input type="TTnippejabatTn3" class="form-control " id="TTnippejabatTn3" name="TTnippejabatTn3" value="<?= $dataTtd[0]['TTnippejabatTn3']?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary float-right">Save</button>
        <button type="reset" class="btn btn-warning">Reset</button>
    </div>
</div>