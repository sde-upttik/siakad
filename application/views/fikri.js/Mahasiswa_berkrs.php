
<script>

$body = $("body");

const base_url = "<?= base_url('ademik/Mahasiswa_berkrs/')?>"
const allProdi = JSON.parse('<?= json_encode($select['kodeProdi']) ?>');
var all;
const defSelct2 = '<li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" role="textbox" aria-autocomplete="list" placeholder="Pilih Prodi" style="width: 492.156px;"></li>'
function pilihAll() {
 all = document.getElementById("all").checked;
 if (all) {
  $('#selectProdi > span > span > span > ul').html('');
  for (let i = 0; i < allProdi.length; i++) {
   let kode = allProdi[i];
   $('#selectProdi > span > span > span > ul').append('<li class="select2-selection__choice" title="'+kode+'"><span class="select2-selection__choice__remove" role="presentation">×</span>'+kode+'</li>')
  }
  $('#prodi').val(allProdi);
 }else{
  $('#prodi').val('');
  $('#selectProdi > span > span > span > ul').html(defSelct2);
 }
}


var recent=[];
var riwayat = $('#history');
var tabel = $('#tabel');
var db = [];
var btnPrint = '';
function cari() {

     $body.addClass("loading");
     var prodi = $('#prodi').val();
     var tahun = $('#tahun').val();
     var post = {'prodi':prodi,'tahun':tahun};
     var title = prodi.toString()+' - '+tahun;
     if (all) {
          title = 'Pilih Semua - '+tahun;
     }else if (prodi.length>=5) {
          let key =  prodi.toString();
          title = key.split(",", 5)+',... - '+tahun;
     }
     var id = makeid(5);
     var li = {'id':id,'title':title};
     recent.push(li);
     makeTabel(id);
     makeRiwayat();
     
     
     $.post(base_url+'cari',post,function(respons) {
          let res = JSON.parse(respons);
          // console.log(db[id])
          $body.removeClass("loading");
          let rows = {
               // dom: 'Bfrtip',
               data : res.data,
               columns : [
                    {"data":"nFakultas"},
                    {"data":"nProdi"},
                    {"data":"NIM"},
                    {"data":"Nama"}
               ],
               // buttons : [
               //      { extend: 'create', editor: editor },
               //      { extend: 'edit',   editor: editor },
               //      { extend: 'remove', editor: editor },
               //      {
               //           extend: 'collection',
               //           text: 'Export',
               //           buttons: [
               //                'copy',
               //                'excel',
               //                'csv',
               //                'pdf',
               //                'print'
               //           ]
               //      }
               // ]
          }
          db[id] = rows ;
          $('#'+id).DataTable(rows);
     $('.dataTables_paginate').append(btnPrint);
     })
     
}
function makeTabel(id) {
     btnPrint = `<a class='paginate_button' id='btn' onclick='printDiv("`+id+`");'>Print</a>`;
     tabel.html(`
     <table id="`+id+`" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive" cellspacing="0" width="100%">
          <thead>
               <tr>
                    <th>Fakultas</th>
                    <th>Prodi</th>
                    <th>Nim</th>
                    <th>Nama</th>
               </tr>
          </thead>
          <tbody class="tbody">

          </tbody>
     </table>
     `);
}
function makeRiwayat() {
     riwayat.html(`
     <div class="box box-solid">
          <div class="box-header with-border">
               <h6>Riwayat</h6>
          </div>
          <ul id="riwayatli">
          </ul>
     </div>
     `);
     for (let i = 0; i < recent.length; i++) {
          const li = recent[i];
          const link = {'id':li.id}
          $('#riwayatli').append("<li><a href='#' onclick='recenttable("+JSON.stringify(link)+")'>"+li.title+"</a></li>");
     }
}
function recenttable(link) {
     // console.log(link.id)
     // const id = JSON.parse(link).id;
     let rows = db[link.id];
     // console.log(html);
     tabel.html(makeTabel(link.id));
     $('#'+link.id).DataTable(rows)
     $('.dataTables_paginate').append(btnPrint);
}
function makeid(length) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}
function printDiv(id) 
{
     var data = db[id].data;
     // var divToPrint=document.getElementById(id);
     // console.log(data);
  var newWin=window.open('','Print-Window');
     var tr='';
     for (let i = 0; i < data.length; i++) {
          const row = data[i];
          tr=tr+'<tr><td>'+row.nFakultas+'</td><td>'+row.nProdi+'</td><td>Nim'+row.NIM+'</td><td>'+row.Nama+'</td></tr>'
     }
  newWin.document.open();
     var style =`
          <style>
          #data {
          font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
          }

          #data td, #data th {
          border: 1px solid #ddd;
          padding: 8px;
          }

          #data tr:nth-child(even){background-color: #f2f2f2;}

          #data tr:hover {background-color: #ddd;}

          #data th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #4CAF50;
          color: white;
          }
          </style>`;
     // newWin.document.write('<html>'+style+'<body onload="window.print()"><table id="data">'+divToPrint.innerHTML+'</table></body></html>');
  newWin.document.write('<html>'+style+'<body onload="window.print()"><table id="data"><thead><tr><th>Fakultas</th><th>Prodi</th><th>Nim</th><th>Nama</th></tr></thead><tbody>'+tr+'</tbody></table></body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}
</script>