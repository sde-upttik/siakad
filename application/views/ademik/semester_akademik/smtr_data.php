<div class="box">
  <div class="box-header">
    <h3 class="box-title">Daftar Semester Akademik</h3>
  </div>
  <div class="box-body">

    <div class="row" style="padding-left: 13px;">
      <button class="btn btn-primary" id="tambah_semster">
        <i class="fa fa-plus"></i>
        Tambah semester
      </button>
    </div>

    <table id="tabel_semster_akademik" class="table table-bordered table-striped table-responsive nowrap">
      <thead>
           <tr>
              <th class="fixed-column">No</th>
              <th class="fixed-column">Tahun Akademik</th>
              <th class="fixed-column">Nama Semester Akademik</th>
              <th class="fixed-column">Jurusan</th>
              <th class="fixed-column">Program</th>
              <th class="fixed-column">Action</th>
           </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
  </div>
</div>

  <!-- Modal -->
  <div class="modal fade" id="modal_tambah_semester" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <form class="form" id="form_tambah_validasi">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tambah Semester Akademik</h4>
          </div>
          <div class="modal-body">
            <div id="load_form"></div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-default" data-dismiss="modal">Batal</button>
            <div class="pull-right">
              <button type="submit" class="btn btn-primary" id="btn_simpan" >Simpan</button>
            </div>

          </div>
        </form>
      </div>

    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="modal_edit_semester" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <form class="form" id="form_edit_validasi" >
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Semester Akademik</h4>
          </div>
          <div class="modal-body">
            <div id="load_form_2"></div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-default" data-dismiss="modal">Batal</button>
            <div class="pull-right">
              <button type="submit" class="btn btn-primary" id="btn_simpan_perubahan" >Simpan</button>
            </div>

          </div>
        </form>
      </div>

    </div>
  </div>

  <div id="delet_semster"></div>

<script src="/assets/plugins/jquery_validation/jquery.form.js"></script>
<script src="/assets/plugins/jquery_validation/jquery.validate.js"></script>
<script type="text/javascript">

  $("#tambah_semster").click(function () {
    $("#modal_tambah_semester").modal("toggle");
    $("#load_form").load("<?php echo base_url('index.php/ademik/Smtr_akademik/modal_tambah_semster')?>");
  });

  function edit_semester(kode, jurusan, program) {
    $("#modal_edit_semester").modal("toggle");
    $("#load_form_2").load("<?php echo base_url('index.php/ademik/Smtr_akademik/modal_edit_semster/')?>"+ jurusan +'/'+ program +'/'+ kode);
  }

  function hapus_semster(kode, jurusan, program) {
    $("#delet_semster").load("<?php echo base_url('index.php/ademik/Smtr_akademik/delete_data/')?>"+jurusan+"/"+program+"/"+kode, function (response, status, xhr) {
      if ( status == "error" ) {
        //alert(jurusan+" "+program+" "+kode);
        alert("gagal menghapus");
      }
      else{
        //alert(jurusan+" "+program+" "+kode+" "+nama+" "+status_semester);
        alert("Data Berhasil Dihapus");
        load_tabel_semster();
      }
    });
  }

  function tambah_semster_baru(){
    var Jurusan             = $("select[name=Jurusan]").val();
    var Program             = $("select[name=Program]").val();
    var kode                = $("#kode").val();
    var nama                = $("#nama").val();

    if ($('#status_semester_1').is(":checked"))
    {
      var status_semester   = $("#status_semester_1").val();
    }
    else{
      var status_semester   = "N";
    }

    //alert(Jurusan+" "+Program+" "+kode+" "+nama+" "+status_semester);

    $.post(
            "<?php echo base_url('ademik/smtr_akademik/simpan_data') ?>",
            {
              Jurusan   : Jurusan,
              Program   : Program,
              kode      : kode,
              nama      : nama,
              NotActive : status_semester
            }
          ).done(function () {
            swal({
            title: 'Pesan',
            type: 'success',
            html: true,
            text: 'Berhasil Tersimpan',
            confirmButtonColor: 'green',
          });
            load_tabel_semster();
            $("#modal_tambah_semester").modal("toggle");
          }).fail(function () {
            swal({
            title: 'Peringatan',
            type: 'warning',
            html: true,
            text: 'Gagal Tersimpan Atau Data Sudah Terdaftar',
            confirmButtonColor: '#f7cb3b',
          });
          })

  };

  function edit_semester_akademik() {
    var Jurusan             = $("#Jurusan").val();
    var Program             = $("#Program").val();
    var kode                = $("#kode_edit").val();
    var nama                = $("#nama_edit").val();

    if ($('#status_semester_1_edit').is(":checked"))
    {
      var status_semester   = $("#status_semester_1_edit").val();
    }
    else{
      var status_semester   = "N";
    }

    //alert(Jurusan+" "+Program+" "+kode+" "+nama+" "+status_semester);

    $.post(
            "<?php echo base_url('ademik/smtr_akademik/update_data') ?>",
            {
              Jurusan   : Jurusan,
              Program   : Program,
              kode      : kode,
              nama      : nama,
              NotActive : status_semester
            }
          ).done(function () {
           swal({
                title: 'Pesan',
                type: 'success',
                html: true,
                text: 'Data Berhasil DiUpdate',
                confirmButtonColor: 'green',
            });
            $("#modal_edit_semester").modal("toggle");
            load_tabel_semster();

          }).fail(function () {
            swal({
                  title: 'Peringatan',
                  type: 'warning',
                  html: true,
                  text: 'Gagal Terupdate',
                  confirmButtonColor: '#f7cb3b',
            });
          })
  };

  var table;
  $(document).ready(function() {
     table =  $('#tabel_semster_akademik').DataTable({

          "processing"  : true,
          "serverSide"  : true,
          "order"       : [],

          "ajax"        : {
              "url"   : "<?php echo base_url('index.php/ademik/Smtr_akademik/serverside_data_semester/'
                              .$data_semester[0]['KodeProgram']
                              .'/'
                              .$data_semester[0]['KodeJurusan'])
                          ?>",
              "type"  : "POST"
          },

          "columnDefs": [
                    {
                        "targets": 5,
                        "data": null,
                        "defaultContent":
                          "<button class='btn btn-warning' id='edit'><i class='fa fa-pencil-square-o'></i> </button> <button class='btn btn-danger' id='hapus'><i class='fa fa-trash-o'></i> </button>"
                    },
          ]
      });

      $('#tabel_semster_akademik tbody').on( 'click', '#edit', function () {
          var data = table.row( $(this).parents('tr') ).data();

          //alert(data[1]+" "+data[3]+" "+data[4] );
          edit_semester(data[1], data[3], data[4]);

      } );

      $('#tabel_semster_akademik tbody').on( 'click', '#hapus', function () {
          var data = table.row( $(this).parents('tr') ).data();

          //alert(data[1]+" "+data[3]+" "+data[4] );
          tanya = confirm("Anda Yakin Ingin Menghapus Data ?");
          if (tanya == true){
            hapus_semster(data[1], data[3], data[4]);
            //return true;
          }else{
            return false;
          }

         // hapus_semster(data[1], data[3], data[4]);
          //}


      } );


  });

  jQuery.extend(jQuery.validator.messages, {
    required: "<b>Mohon isi dulu kolom yang disediakan <b>"
  });

  $("#form_tambah_validasi").validate({
    submitHandler: function(form){
      tambah_semster_baru();
    }
  });

   $("#form_edit_validasi").validate({
    submitHandler: function(form){
      edit_semester_akademik();
    }
  });

  function load_tabel_semster() {
    table.ajax.reload();
  }

</script>
