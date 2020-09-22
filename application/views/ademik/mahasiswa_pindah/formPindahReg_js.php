<script>
  let token = "<?= $this->csrf->ajax_token('token') ?>";
  let base_url = "<?= base_url() ?>";
  $('#cariNim').click(function() {
    let nim = $('.nim').val()
    let url = base_url+'ademik/mhswpindah/cariMahasiswa'
    let data = {"nim":nim,"<?= $this->csrf->ajax_token('name') ?>": token}
    $.post(url , data)
    .done(function(response) {
      $('#program').show();
      console.log(response);
      alert( "success" );
    })
    .fail(function(error) {
      console.log(error);
      alert( "error" );
    })
    .always(function() {
      // alert( "finished" );
    });
  });

  $('#program').change(function() {
    let prog = $( "#program option:selected" ).val()
    alert( "cari mahasiswa... " + prog );
  });
</script>