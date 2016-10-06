<a href="admin/multimedia/immagini/inserisci" class="btn pull-right">Carica Immagine <i class="icon-plus-sign"></i></a>
<?php echo form_open('', 'class="form-search pull-right" style="margin-right:20px"') ?>
    <div class="input-append">
        <?php echo form_input('', set_value(), 'placeholder="Cerca immagine" class="input-large search-query"') ?>
        <a href="" class="btn"><i class="icon-search"></i></a> 
    </div>
<?php echo form_close() ?>

<br class="clear">

<ul class="image-list">
<?php foreach($images as $image): ?>
    <li class="pull-left">
        <img class="img-polaroid" src="<?php echo base_url($image->get_thumb()) ?>" alt="<?php echo $image->name ?>">
        <div class="actions btn-group">
            <a href="<?php echo base_url('admin/multimedia/immagini/modifica/' . $image->id) ?>" class="btn btn-small"><i class="icon-wrench"></i></a>
            <a href="<?php echo base_url('admin/multimedia/immagini/elimina/' . $image->id) ?>" class="btn btn-small btn-danger"><i class="icon-trash"></i></a>
         </div>
    </li>   
<?php endforeach ?>
</ul>