<link href="<?=base_url()?>assets/plugins/sweetalert2/dist/sweetalert2.min.css">
<script src="<?=base_url()?>assets/plugins/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?=base_url()?>assets/plugins/sweetalert2/dist/sweetalert2.min.js"></script>

<script>
    $('#tabelJurusan').DataTable();
    
    function swAlert(title,text,type) {
        Swal.fire({
            type: type,
            title: title,
            text : text,
            showConfirmButton: false,
            timer: 1500
        })
    }

    function modalEditTtd(kode) {
        $.post(
            '<?= base_url("ademik/master_ttd/formEditTtd")?>', 
            {
                Kode : kode
            },
            function( data ) {
                $( "#content" ).html( data );
            }
        );        
    }
    
    $('#formTtd').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type	    : "POST",
            url	        : "<?= base_url("ademik/master_ttd/updateTtd")?>",
            data	    : $("#formTtd").serialize(),
            datatype    : 'html',
            success     : function(data) {			
                if(data==1){
                    $('#modalEdit').modal('toggle');
                    swAlert('Success !', 'Data saved', 'success');
                }
                else{
                    swAlert('Error !', 'Data not saved', 'error');

                }
            }
        });    
    });

</script>