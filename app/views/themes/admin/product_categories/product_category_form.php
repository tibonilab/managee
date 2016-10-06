<?php echo form_open_multipart('') ?>
    <fieldset>
        <?php echo form_label('Nome Categoria', 'category[name]') ?>
        <?php echo form_input('category[name]', set_value('category[name]', $category->name), 'class="span12" id="category[name]" placeholder="Nome di riferimento alla categoria.."') ?>
        
        <?php echo form_label('Inserita in', 'category[parent_id]') ?>
        <?php echo form_dropdown('category[parent_id]', $categories, set_value('category[parent_id]', $category->parent_id), 'class="span12" id="category[parent_id]"') ?>
        
        
		<?php echo form_label('Immagine', 'category[image]') ?>
		<?php echo form_upload('category[image]')?>
		
        <label class="checkbox">
            <?php echo form_checkbox('category[published]', '1', set_checkbox('category[published]', '1', $category->is_published()), 'id="category[published]"') ?>
            Pubblicata
        </label>
    </fieldset>

    <fieldset style="margin-top:40px">
        
        <?php if(count($contents) >= 1):?>
        <div class="navbar">
            <div class="navbar-inner">
                <span class="brand">Lingua</span>
                <ul class="nav" id="contentTab">
                    <?php foreach($contents as $iso => $content): ?>
                    <li><a href="#<?php echo $iso ?>" data-toggle="tab"><?php echo $iso ?></a></li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
        <?php endif ?>
        
        <div class="tab-content">
        <?php foreach($contents as $iso => $content): ?>
            <div class="tab-pane" id="<?php echo $iso ?>">

                <fieldset class="span12">
                    <legend>Contenuti</legend>
                    <?php echo form_label('Nome', 'content['.$iso.'][name]') ?>
                    <?php echo form_input('content['.$iso.'][name]', set_value('content['.$iso.'][name]', $content->name), 'class="span12" id="'.'content['.$iso.'][name]" placeholder="Nome della categoria"') ?>
                
                    <legend>Dati tecnici</legend>
                    <?php echo form_label('URL', 'content['.$iso.'][slug]') ?>
                    <?php echo form_input('content['.$iso.'][slug]', set_value('content['.$iso.'][slug]', $content->get_slug()), 'class="span12" id="'.'content['.$iso.'][slug]" placeholder="Indirizzo categoria.."') ?>    
                    
                    <?php echo form_label('Titolo SEO', 'content['.$iso.'][meta_title]') ?>
                    <?php echo form_input('content['.$iso.'][meta_title]', set_value('content['.$iso.'][meta_title]', $content->meta_title), 'class="span12" id="'.'content['.$iso.'][meta_title]" placeholder="Titolo SEO della categoria.."') ?>    
                    
                    <?php echo form_label('Keywords', 'content['.$iso.'][meta_key]') ?>
                    <?php echo form_textarea('content['.$iso.'][meta_key]', set_value('content['.$iso.'][meta_key]', $content->meta_key), 'class="span12" style="height:60px" id="'.'content['.$iso.'][meta_key]" placeholder="Lista keywords"') ?>    
                    
                    <?php echo form_label('Description', 'content['.$iso.'][meta_descr]') ?>
                    <?php echo form_textarea('content['.$iso.'][meta_descr]', set_value('content['.$iso.'][meta_descr]', $content->meta_descr), 'class="span12" style="height:60px" id="'.'content['.$iso.'][meta_descr]" placeholder="Description"') ?>    
                    
                    <label class="checkbox">
                        <?php echo form_checkbox('content['.$iso.'][active]', '1', set_checkbox('content['.$iso.'][active]', '1', $content->is_active())) ?>
                        Attiva
                    </label>
                    
                </fieldset>
            </div>
        <?php endforeach ?>
        </div>
    </fieldset>

    <div class="form-actions">
    <?php echo form_submit('', 'Salva', 'class="btn btn-primary"') ?>
    </div>
        
<?php echo form_close() ?>

<script>
$().ready(function () {
    $('#contentTab a:first').tab('show'); 
})
</script>