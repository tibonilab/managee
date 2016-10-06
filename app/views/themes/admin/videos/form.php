<?php echo form_open('') ?>
    <fieldset>
        <?php echo form_label('Nome Video', 'video[name]') ?>
        <?php echo form_input('video[name]', set_value('video[name]', $item->name), 'class="span12" id="video[name]" placeholder="Nome di riferimento al video.."') ?>
        
		<?php echo form_label('Autore', 'video[partner_id]') ?>
        <?php echo form_dropdown('video[partner_id]', array(0 => 'BorghInTour') + dropize_me($this->partner_model->get_all(), 'label', 'id'), set_value('video[partner_id]', $item->partner_id), 'class="span12" id="video[partner_id]"') ?>
        
		
		
		<?php echo form_label('URL Video', 'video[url]') ?>
        <?php echo form_input('video[url]', set_value('video[url]', $item->url), 'class="span12" id="video_url" placeholder="URL del video.."') ?>
		
		<?php echo form_label('Canale', 'video[channel]') ?>
        <?php echo form_dropdown('video[channel]', $item->get_channels(), set_value('video[channel]', $item->channel), 'class="span3" id="video[channel]"') ?>
		
        <label class="checkbox">
            <?php echo form_checkbox('video[published]', '1', set_checkbox('video[published]', '1', $item->is_published()), 'id="video[published]"') ?>
            Pubblicato
        </label>
		
    </fieldset>
	
	<div id="embedded"><!-- AJAX content --></div>

    <fieldset style="margin-top:40px">
        
        <?php if(count($item->get_contents()) >= 1):?>
        <div class="navbar">
            <div class="navbar-inner">
                <span class="brand">Lingua</span>
                <ul class="nav" id="contentTab">
                    <?php foreach($item->get_contents() as $iso => $content): ?>
                    <li><a href="#<?php echo $iso ?>" data-toggle="tab"><?php echo $iso ?></a></li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
        <?php endif ?>
        
        <div class="tab-content">
        <?php foreach($item->get_contents() as $iso => $content): ?>
            <div class="tab-pane" id="<?php echo $iso ?>">

                <fieldset class="span8">
                    <legend>Contenuti</legend>
                    <?php echo form_label('Titolo', 'content['.$iso.'][title]') ?>
                    <?php echo form_input('content['.$iso.'][title]', set_value('content['.$iso.'][title]', $content->title), 'class="span12" id="'.'content['.$iso.'][title]" placeholder="Titolo del video"') ?>

                    <?php echo form_label('Contenuto', 'content['.$iso.'][content]') ?>
                    <?php echo form_textarea('content['.$iso.'][content]', set_value('content['.$iso.'][content]', $content->content), 'class="ckeditor span12" id="'.'content['.$iso.'][content]" placeholder="Testo del video"') ?>            
                </fieldset>
                    
                <fieldset class="span4">
                    <legend>Dati tecnici</legend>
                    <?php echo form_label('URL', 'content['.$iso.'][slug]') ?>
                    <?php echo form_input('content['.$iso.'][slug]', set_value('content['.$iso.'][slug]', $content->get_route()), 'class="span12" id="'.'content['.$iso.'][slug]" placeholder="Indirizzo video.."') ?>    
                    
                    <?php echo form_label('Titolo SEO', 'content['.$iso.'][meta_title]') ?>
                    <?php echo form_input('content['.$iso.'][meta_title]', set_value('content['.$iso.'][meta_title]', $content->meta_title), 'class="span12" id="'.'content['.$iso.'][meta_title]" placeholder="Titolo SEO del video.."') ?>    
                    
                    <?php echo form_label('Keywords', 'content['.$iso.'][meta_key]') ?>
                    <?php echo form_textarea('content['.$iso.'][meta_key]', set_value('content['.$iso.'][meta_key]', $content->meta_key), 'class="span12" style="height:60px" id="'.'content['.$iso.'][meta_key]" placeholder="Lista keywords"') ?>    
                    
                    <?php echo form_label('Description', 'content['.$iso.'][meta_descr]') ?>
                    <?php echo form_textarea('content['.$iso.'][meta_descr]', set_value('content['.$iso.'][meta_descr]', $content->meta_descr), 'class="span12" style="height:60px" id="'.'content['.$iso.'][meta_descr]" placeholder="Description"') ?>    
                    
                    <label class="checkbox">
                        <?php echo form_checkbox('content['.$iso.'][active]', '1', set_checkbox('content['.$iso.'][active]', '1', $content->is_active())) ?>
                        Attivo
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
	
	$('#video_url').trigger('blur')
	
	$('#video_url').on('blur', function () {
		var url = $(this).val();
		
		var video_data	= url.match("[\?&]v=([^&#]*)");
		var video_id	= (video_data != null) ? video_data[1] : null;
		var embedded	= 'http://www.youtube.com/embed/' + video_id;
		
		var html = (video_id != null) ? '<iframe width="560" height="315" src="'+embedded+'" frameborder="0" allowfullscreen></iframe>' : ''; 
		
		$('#embedded').html(html)
	})
})
</script>