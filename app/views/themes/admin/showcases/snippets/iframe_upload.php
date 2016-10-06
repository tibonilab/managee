<?php echo form_open_multipart() ?>
<?php echo form_upload('images[]', '', 'multiple="multiple" id="files"') ?>

    
    
    
<?php echo form_submit('', 'Carica Immagini', 'class="btn btn-primary" id="upload-button" data-loading-text="Caricamento in corso..."') ?>

<div id="uploaded" style="display:none">
<?php echo ($uploaded)?>
</div>


<script>
    $().ready(function () {
        window.parent.show_uploads($('#uploaded').html())
        
        $('#upload-button').button();
        $('#upload-button').on('click', function () {
            $(this).button('loading')
        })
    })
</script>

