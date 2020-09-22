<script>
  // $('#data').DataTable();
  
  $body = $("body");
  var where = '';

  const base_url = "<?= base_url() ?>";

  $('#simpan').click(function(){
    var set = JSON.parse($("input[name='pilih']:checked").val());
    
    let url=base_url+'ademik/Takterjadwal/simpan/<?= $apiKey ?>';
    let selected = where.split(",");
    let data={
      "where":selected,
      "tahun":$('#tahun').val(),
      "set":set
    }
    // console.log(data);
    let config = {
      method  : "POST",
      url     : url,
      data    : data
    }
    console.log(data);
    let simpan = $.ajax(config);
    simpan.done(function(res){
      let respons = JSON.parse(res);
      console.log(respons);
      alert("Sukses. "+ respons.affected_rows +" data telah diupdate");
      cari();
    });
    // simpan.fail(function( jqXHR, textStatus x){
    //   alert( "Request failed: " + textStatus );
    // });
  })

  function peserta(params) {
    // console.log(params);

    let list = $('.mhsw');
    $body.addClass("loading");
    let url = base_url+'ademik/Takterjadwal/peserta';
    let where = {'id':params.split(","),'Tahun':$('#tahun').val()}
    $.post(url,where,function(res) {
      let data = JSON.parse(res);
      list.html('');
      for (let i = 0; i < data.length; i++) {
        const mhsw = data[i];
        list.append(mhsw.NIM+' - '+mhsw.Name+'<br>');
      }
      $('#peserta').modal("show");
      $body.removeClass("loading");
      console.log(data);
    })
  }

  function pindahkan(params) {
    // console.log(params);
    where = params;
    jadwal();
    $('#pindahkan').modal("show");
  }

 function cari() {
  $body.addClass("loading");
  $("#data").dataTable().fnDestroy()
  var url = base_url+'ademik/Takterjadwal/cari';
  var prodi = $('#prodi').val();
  var tahun = $('#tahun').val();
  var program = $('#program').val();
  var send = {
   'prodi' : prodi,
   'tahun' : tahun,
   'program': program
  };
  $.post(url,send,function(res){
   var respons=JSON.parse(res);
   var rows = respons.data;
   const r='';
   $('.tbody').html('');
  //  $('#data').addClass();
    for (let i = 0; i < rows.length; i++) {
      const row = rows[i];
      // const where = JSON.stringify({'IDJadwal':row.IDJadwal,'IDMK':row.IDMK,'KodeMK':row.KodeMK,'Tahun':row.Tahun});
      const where = JSON.stringify(row.selected);
      $('.tbody').append("<tr><td>"+(i+1)+"</td><td>"+row.Kode+"</td><td>"+row.Tahun+"</td><td>"+row.IDJadwal+"</td><td>"+row.NamaMK+"</td><td>"+row.KodeMK+"</td><td> <a href='#' onclick='peserta("+where+")'>"+row.jumlah+" orang</a></td><td> <a class='btn btn-primary' onclick='pindahkan("+where+")'> Pindahkan</a></td></tr>");
      // $('#data').DataTable();
    }

    
    $('#data').DataTable();
    $body.removeClass("loading");
  })

 }

 function jadwal(params) {
   let url = base_url+'ademik/Takterjadwal/jadwal';
   let tahun = $('#tahun').val()
   let program = $('#program').val()
   let prodi = $('#prodi').val()
   let data ={
     'Tahun':tahun,
     'program':program,
     'KodeJurusan': prodi
   }
    // console.log(data);
    $.post(url,data,function(rest) {
      let res = JSON.parse(rest);
      var respons=res.jadwal;
      // console.log(rest);
      let divTable = $('#tabelJadwal');
      let thead = '<thead> <tr> <th>Id Jadwal</th> <th>Kode MK</th> <th>Nama MK</th> <th>SKS</th> <th>Kelas</th> </tr> </thead>';
      var trow = '';
      for (let i = 0; i < respons.length; i++) {
        let row = respons[i];
        let set = {
          "IDJadwal": row.IDJADWAL,
          "Tahun" : row.Tahun,
          "IDMK": row.IDMK,
          "KodeMK": row.KodeMK,
          "NamaMK": row.NamaMK
        }

        let tr = ` <tr> <td><input type="radio" id="`+row.IDJADWAL+`" name="pilih" value='`+JSON.stringify(set)+`'><label for="`+row.IDJADWAL+`">`+row.IDJADWAL+`</label></td> <td>`+row.KodeMK+`</td> <td>`+row.NamaMK+`</td> <td>`+row.SKS+`</td> <td>`+row.kelas+`<br>`+row.Peserta+` org </td> </tr> `;
        trow = trow + tr ;
      }
      var tbody = '<tbody>'+ trow +'</tbody>';
      var table = '<table id="jadwal" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive" cellspacing="0" width="100%">' + thead + tbody + '</table>';
      divTable.html(table);
      $('#jadwal').DataTable();
    });
 }
</script>