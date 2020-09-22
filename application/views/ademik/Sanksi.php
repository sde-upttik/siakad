<style>
  /* #listBlok{
    cursor:pointer;
  } */
  /* Center the loader */
  #loader {
    position: absolute;
    left: 50%;
    top: 50%;
    z-index: 1;
    width: 150px;
    height: 150px;
    margin: -75px 0 0 -75px;
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
    background-color: blue;
  }

  @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  /* Add animation to "page content" */
  .animate-bottom {
    position: relative;
    -webkit-animation-name: animatebottom;
    -webkit-animation-duration: 1s;
    animation-name: animatebottom;
    animation-duration: 1s
  }

  @-webkit-keyframes animatebottom {
    from { bottom:-100px; opacity:0 } 
    to { bottom:0px; opacity:1 }
  }

  @keyframes animatebottom { 
    from{ bottom:-100px; opacity:0 } 
    to{ bottom:0; opacity:1 }
  }
  /* loading list */
    .center{
      margin: auto;
      width: 60%;
      padding: 10px;
    }
    .lds-ellipsis {
      display: inline-block;
      position: relative;
      width: 80px;
      height: 80px;
    }
    .lds-ellipsis div {
      position: absolute;
      top: 33px;
      width: 13px;
      height: 13px;
      border-radius: 50%;
      background: #cef;
      animation-timing-function: cubic-bezier(0, 1, 1, 0);
    }
    .lds-ellipsis div:nth-child(1) {
      left: 8px;
      animation: lds-ellipsis1 0.6s infinite;
    }
    .lds-ellipsis div:nth-child(2) {
      left: 8px;
      animation: lds-ellipsis2 0.6s infinite;
    }
    .lds-ellipsis div:nth-child(3) {
      left: 32px;
      animation: lds-ellipsis2 0.6s infinite;
    }
    .lds-ellipsis div:nth-child(4) {
      left: 56px;
      animation: lds-ellipsis3 0.6s infinite;
    }
    @keyframes lds-ellipsis1 {
      0% {
        transform: scale(0);
      }
      100% {
        transform: scale(1);
      }
    }
    @keyframes lds-ellipsis3 {
      0% {
        transform: scale(1);
      }
      100% {
        transform: scale(0);
      }
    }
    @keyframes lds-ellipsis2 {
      0% {
        transform: translate(0, 0);
      }
      100% {
        transform: translate(24px, 0);
      }
    }

  /* end loading list */
  /* list style */
    ol {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    ol li {
      border: 1px solid #ddd;
      margin-top: -1px; /* Prevent double borders */
      background-color: #f6f6f6;
      padding: 12px;
      text-decoration: none;
      font-size: 18px;
      color: black;
      display: block;
      position: relative;
    }

    ol li:hover {
      background-color: #eee;
    }

    .close {
      cursor: pointer;
      position: absolute;
      top: 50%;
      right: 0%;
      padding: 12px 16px;
      transform: translate(0%, -50%);
    }

    .close:hover {background: #bbb;}
  /* end list style */
</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Sanksi
    </h1>
    <!-- <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="breadcrumb-item"><a href="<?= 'ademik/'.$_SESSION['tamplate'] ?>">Sanksi</a></li>
    </ol> -->
  </section>
  <section id="content" class="content">
        
        <div class="col-md-12 col-lg-12">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 id="card-title" class="card-title">Sanksi Mahasiswa</h3>
              <!-- <h6 class="card-subtitle">Use default tab with class <code>vtabs & tabs-vertical</code></h6> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- Nav tabs -->
              <div class="vtabs">
                <ul class="nav nav-tabs tabs-vertical" role="tablist">
                  <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile4" role="tab"><span class="hidden-sm-up"><i class="ion-person"></i></span> <span class="hidden-xs-down">Sanksi</span></a> </li>
                  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#home4" role="tab"><span class="hidden-sm-up"><i class="ion-home"></i></span> <span class="hidden-xs-down">Daftar Mahasiswa</span> </a> </li>
                  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages4" role="tab"><span class="hidden-sm-up"><i class="ion-email"></i></span> <span class="hidden-xs-down">Messages</span></a> </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                  <div class="tab-pane pad" id="home4" role="tabpanel">
                    <div id="list" class="pad">
                      
                    </div>
                  </div>
                  <div class="tab-pane active" id="profile4" role="tabpanel">
                    <div class="pad">
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group row">
                            <label for="mhsw" class="col-sm-3 col-form-label">NIM</label>
                            <div class="col-sm-9">
                              <div class="input-group margin">
                                <input class="form-control" type="text" id="mhsw" name="nim">
                                  <span class="input-group-btn">
                                    <button type="button" id="add" onclick="addListBlok()" class="btn btn-info btn-flat">add</button>
                                  </span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="penanggungJawab" class="col-sm-3 col-form-label">Penanggung jawab</label>
                            <div class="col-sm-9">
                            <input class="form-control" type="text" id="penanggungJawab">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="kasus" class="col-sm-3 col-form-label">Kasus</label>
                            <div class="col-sm-9">
                            <input class="form-control" type="text" id="kasus">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="ket" class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-9">
                            <input class="form-control" type="text" id="ket">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="skSanksi" class="col-sm-3 col-form-label">SK-Sanksi</label>
                            <div class="col-sm-9">
                            <input class="form-control" type="text" id="skSanksi">
                            </div>
                          </div>
                          <!-- <div class="form-group row">
                            <label for="tglSanksi" class="col-sm-3 col-form-label">Tanggal Sanksi</label>
                            <div class="col-sm-9">
                            <input class="form-control" type="date" id="tglSanksi">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="example-url-input" class="col-sm-3 col-form-label">Upload SK</label>
                            <div class="col-sm-9">
                            <input class="form-control" type="file"  id="example-url-input">
                            </div>
                          </div> -->
                          <div class="row">
                            <button class="btn btn-warning" onclick="proc()">Proses</button>
                          </div>
                        </div>
                        <div class="col-6">
                          <h5 style="text-align:center;" >List Blok</h5>
                          <ol id="listBlok">
                          </ol>
                          <div id="loading" class="row" style="display:none;">
                            <div class="lds-ellipsis center" ><div></div><div></div><div></div><div></div></div>
                          </div>
                        </div>
                        <!-- /.col -->
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane pad" id="messages4" role="tabpanel">
                    <div class="pad">

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div> 
  </section>
</div>
<div class="modal modal-danger fade" id="modal-danger">
  <div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
    <h4 class="modal-title">Danger Modal</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">
    <p id="msg"></p>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
    <button onclick="cabutSanksi()" type="button" class="btn btn-outline float-right">Cabut Sanksi</button>
    </div>
  </div>
  <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
