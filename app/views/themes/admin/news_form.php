<?php echo form_open('') ?>
    <fieldset>
        <?php echo form_label('Nome News', 'news[name]') ?>
        <?php echo form_input('news[name]', set_value('news[name]', $news->name), 'class="span12" id="news[name]" placeholder="Nome di riferimento alla news.."') ?>
        
		<?php echo form_label('Data News', 'news[date]') ?>
        <?php echo form_input('news[date]', set_value('news[date]', $news->date), 'class="span2 datepicker" id="news[date]" readonly') ?>		
		
        <label class="checkbox">
            <?php echo form_checkbox('news[published]', '1', set_checkbox('news[published]', '1', $news->is_published()), 'id="news[published]"') ?>
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

                <fieldset class="span8">
                    <legend>Contenuti</legend>
                    <?php echo form_label('Titolo', 'content['.$iso.'][title]') ?>
                    <?php echo form_input('content['.$iso.'][title]', set_value('content['.$iso.'][title]', $content->title), 'class="span12" id="'.'content['.$iso.'][title]" placeholder="Titolo della news"') ?>

                    <?php echo form_label('Contenuto', 'content['.$iso.'][content]') ?>
                    <?php echo form_textarea('content['.$iso.'][content]', set_value('content['.$iso.'][content]', $content->content), 'class="ckeditor span12" id="'.'content['.$iso.'][content]" placeholder="Testo della news"') ?>            
                </fieldset>
                    
                <fieldset class="span4">
                    <legend>Dati tecnici</legend>
                    <?php echo form_label('URL', 'content['.$iso.'][slug]') ?>
                    <?php echo form_input('content['.$iso.'][slug]', set_value('content['.$iso.'][slug]', $content->get_slug()), 'class="span12" id="'.'content['.$iso.'][slug]" placeholder="Indirizzo news.."') ?>    
                    
                    <?php echo form_label('Titolo SEO', 'content['.$iso.'][meta_title]') ?>
                    <?php echo form_input('content['.$iso.'][meta_title]', set_value('content['.$iso.'][meta_title]', $content->meta_title), 'class="span12" id="'.'content['.$iso.'][meta_title]" placeholder="Titolo SEO della news.."') ?>    
                    
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
	
	$('.datepicker').datepicker({dateFormat:'yy-mm-dd'});
})
</script>