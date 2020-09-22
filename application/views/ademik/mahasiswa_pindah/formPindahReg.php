<div class="container">
  <br>
  <div class="row">
    <div class="col-8">
        <div class="form-group row">
          <label for="example-text-input" class="col-sm-2 col-form-label">NIM</label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" class="form-control nim" placeholder="Nim" required="TRUE" aria-invalid="false">
              <span class="input-group-btn">
                <button class="btn btn-info" type="button" id="cariNim">Cari!</button>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="nama" class="col-sm-2 col-form-label">Nama</label>
          <div class="col-sm-10">
            <p class="form-control"  id="nama">Disini nama</p>
          </div>
        </div>
        <div class="form-group row">
          <label for="prodi" class="col-sm-2 col-form-label">Prodi</label>
          <div class="col-sm-10">
            <p class="form-control"  id="prodi">Disini prodi</p>
          </div>
        </div>
        <div class="form-group row">
          <label for="status" class="col-sm-2 col-form-label">Status</label>
          <div class="col-sm-10">
            <p class="form-control"  id="status">Disini status</p>
          </div>
        </div>
        <div class="form-group row">
          <label for="program" class="col-sm-2 col-form-label">Program</label>
          <div class="col-sm-10">
            <select name="program" id="program" class="form-control" style="display:none;">
              <option value="REG">Reg</option>
              <option value="RESO">Non Reg</option>
            </select>
          </div>
        </div>
        <!-- <div class="box-footer">
          <button type="submit" class="btn btn-block btn-danger">Proses Pindah</button>
        </div> -->
    </div>
    <!-- /.col --> 
  </div>
</div>