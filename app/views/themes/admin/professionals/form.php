<?php echo form_open_multipart('') ?>

	<ul class="nav nav-tabs" id="mainTab">
		<li class="active"><a href="#item" data-toggle="tab">Pagina</a></li>
		<li><a href="#contents" data-toggle="tab">Contenuti</a></li>
		<li><a href="#images" data-toggle="tab">Immagini</a></li>
	</ul>

	 <div class="tab-content">
        <div class="tab-pane active" id="item">

			<fieldset>
				<?php echo form_label('Nome Pagina', 'professional[name]') ?>
				<?php echo form_input('professional[name]', set_value('professional[name]', $professional->name), 'class="span12" id="professional[name]" placeholder="Nome di riferimento alla pagina.."') ?>

				<?php echo form_label('Vetrina', 'professional[showcase_id]') ?>
				<?php echo form_dropdown('professional[showcase_id]', $showcases, set_value('professional[showcase_id]', $professional->showcase_id), 'class="span3" id="professional[showcase_id]"') ?>

				<?php echo form_label('Modulo contatti', 'professional[form]') ?>
				<?php echo form_dropdown('professional[form]', array(NULL => 'Nessun form', 'generic' => 'Form Generico', 'book' => 'Form Prenotazione'), set_value('professional[form]', $professional->form), 'class="span3" id="professional[form]"') ?>
				
				<label class="checkbox">
					<?php echo form_checkbox('professional[published]', '1', set_checkbox('professional[published]', '1', $professional->is_published()), 'id="professional[published]"') ?>
					Pubblicata
				</label>

				<label class="checkbox">
					<?php echo form_checkbox('professional[is_homepage]', '1', set_checkbox('professional[is_homepage]', '1', $professional->is_homepage()), 'id="professional[is_homepage]"') ?>
					Homepage
				</label>
			</fieldset>
		</div>
		 
		 <div class="tab-pane" id="contents">
			<fieldset>

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
							<?php echo form_input('content['.$iso.'][title]', set_value('content['.$iso.'][title]', $content->title), 'class="span12" id="'.'content['.$iso.'][title]" placeholder="Titolo della pagina"') ?>

							<?php echo form_label('Sottotitolo', 'content['.$iso.'][subtitle]') ?>
							<?php echo form_input('content['.$iso.'][subtitle]', set_value('content['.$iso.'][subtitle]', $content->subtitle), 'class="span12" id="'.'content['.$iso.'][subtitle]" placeholder="Sottotitolo della pagina"') ?>
							
							<?php echo form_label('Lista in evidenza', 'content['.$iso.'][list]') ?>
							<?php echo form_input('content['.$iso.'][list]', set_value('content['.$iso.'][list]', $content->list), 'class="span12" id="'.'content['.$iso.'][list]" placeholder="Lista elementi in evidenza, saparati da virgola"') ?>
							
							<?php echo form_label('Contenuto', 'content['.$iso.'][content]') ?>
							<?php echo form_textarea('content['.$iso.'][content]', set_value('content['.$iso.'][content]', $content->content), 'class="ckeditor span12" id="'.'content['.$iso.'][content]" placeholder="Testo della pagina"') ?>            
						</fieldset>

						<fieldset class="span4">
							<legend>Dati tecnici</legend>
							<?php echo form_label('URL', 'content['.$iso.'][slug]') ?>
							<?php echo form_input('content['.$iso.'][slug]', set_value('content['.$iso.'][slug]', $content->get_slug()), 'class="span12" id="'.'content['.$iso.'][slug]" placeholder="Indirizzo pagina.."') ?>    

							<?php echo form_label('Titolo SEO', 'content['.$iso.'][meta_title]') ?>
							<?php echo form_input('content['.$iso.'][meta_title]', set_value('content['.$iso.'][meta_title]', $content->meta_title), 'class="span12" id="'.'content['.$iso.'][meta_title]" placeholder="Titolo SEO della pagina.."') ?>    

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
		 </div>
		 
		 <div class="tab-pane" id="images">
			<fieldset>
                <legend>Carica immagini</legend>
                
                <iframe src="<?php echo base_url('admin/images/iframe_upload/professionals') ?>" style="border: 0; width:100%; height: 50px; overflow: hidden"></iframe>
                
              </fieldset>
            
            <fieldset>
                <legend>Immagini caricate</legend>
 
                <div id="uploaded">
                    <?php 
                        if(isset($uploaded)) echo $uploaded;
                        
                        foreach($professional->get_images() as $image)
                        {
                            echo $this->layout->load_view('professionals/snippets/image', array('image' => $image));
                        }
                    ?>
                </div>
                
                <script>
                    // grab data from iframe uploader
                    function show_uploads(DOM)
                    {
                        $('#uploaded').prepend(DOM);
                        $('#uploaded').sortable();
                    }
                    
                    $().ready(function () {
                        $('#uploaded').on('click', '.ajax-delete', function (e) {
                            e.preventDefault();
                            
                            var me      = $(this);
                            var url     = me.attr('href');
                            var block   = me.parent().parent('.ajax_image');
                            
                            
                            $.ajax({url : url}).done(function () { block.slideToggle(500, function () { block.remove() }) })
                        })
                        
                        $('#uploaded').on('change', '.default_image', function () {
                            $('.hide').show().removeClass('hide');
                            $(this).parent().parent().children('.ajax-delete').addClass('hide').hide();
                        })
                        
                        $('#uploaded').sortable();
                        $('.hide').hide();
                    })
                </script>
            </fieldset>
		 </div>
		 
	 </div>
	
	<div class="form-actions">
		<?php echo form_submit('', 'Salva', 'class="btn btn-primary"') ?>
	</div>
        
<?php echo form_close() ?>

<script>
$(document).ready(function () {
    $('#contentTab a:first').tab('show'); 
})
</script>