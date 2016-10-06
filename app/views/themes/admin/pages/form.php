<?php echo form_open_multipart('') ?>

	<ul class="nav nav-tabs" id="mainTab">
		<li class="active"><a href="#item" data-toggle="tab">Pagina</a></li>
		<li><a href="#contents" data-toggle="tab">Contenuti</a></li>
		<li><a href="#images" data-toggle="tab">Immagini</a></li>
		<li><a href="#attachments" data-toggle="tab">Allegati</a></li>
	</ul>

	 <div class="tab-content">
        <div class="tab-pane active" id="item">

			<fieldset>
				<?php echo form_label('Nome Pagina', 'page[name]') ?>
				<?php echo form_input('page[name]', set_value('page[name]', $page->name), 'class="span12" id="page[name]" placeholder="Nome di riferimento alla pagina.."') ?>
				
                <!--
				<?php if($page->id): ?>
				<?php echo form_label('Creata il', 'page[created]') ?>
				<?php echo form_input('page[created]', set_value('page[created]', $page->created), 'class="span2 datepicker" id="page[created]" readonly') ?>		
				<?php endif ?>
				-->
                
				<?php echo form_label('Categoria', 'page[category_id]') ?>
				<?php echo form_dropdown('page[category_id]', $categories, set_value('page[category_id]', $page->category_id), 'class="span3" id="page[category_id]"') ?>
                
                <!--
				<?php echo form_label('Vetrina', 'page[showcase_id]') ?>
				<?php echo form_dropdown('page[showcase_id]', $showcases, set_value('page[showcase_id]', $page->showcase_id), 'class="span3" id="page[showcase_id]"') ?>

				<?php echo form_label('Modulo contatti', 'page[form]') ?>
				<?php echo form_dropdown('page[form]', array(NULL => 'Nessun form', 'info' => 'Form Info Generico', 'partner' => 'Form Collaborazione'), set_value('page[form]', $page->form), 'class="span3" id="page[form]"') ?>
				-->
				<label class="checkbox">
					<?php echo form_checkbox('page[published]', '1', set_checkbox('page[published]', '1', $page->is_published()), 'id="page[published]"') ?>
					Pubblicata
				</label>
                
				<label class="checkbox">
					<?php echo form_checkbox('page[is_homepage]', '1', set_checkbox('page[is_homepage]', '1', $page->is_homepage()), 'id="page[is_homepage]"') ?>
					Pagina visibile nel layout One Page
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
                
                <iframe src="<?php echo base_url('admin/images/iframe_upload/pages') ?>" style="border: 0; width:100%; height: 50px; overflow: hidden"></iframe>
                
              </fieldset>
            
            <fieldset>
                <legend>Immagini caricate</legend>
 
                <div id="uploaded">
                    <?php 
                        if(isset($uploaded)) echo $uploaded;
                        
                        foreach($page->get_images() as $image)
                        {
                            echo $this->layout->load_view('pages/snippets/image', array('image' => $image));
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
		 
		 		 
		<div class="tab-pane" id="attachments">
            <fieldset>
                <legend>Carica allegati</legend>
                
                <iframe src="<?php echo base_url('admin/attachments/iframe_upload/pages') ?>" style="border: 0; width:100%; height: 50px; overflow: hidden"></iframe>
                
              </fieldset>
            
            <fieldset>
                <legend>Allegati già associati</legend>
 
                <div id="uploaded_attachments">
                    <?php 
                        if(isset($uploaded['attachments'])) echo $uploaded['attachments'];
                        
                        foreach($page->get_attachments() as $attachment)
                        {
                            echo $this->layout->load_view('pages/snippets/attachment', array('attachment' => $attachment));
                        }
                    ?>
                </div>
                
                <script>
                    // grab data from iframe uploader
                    function show_uploads_m(DOM)
                    {
                        $('#uploaded_attachments').prepend(DOM);
                        $('#uploaded_attachments').sortable({placeholder: "sortable-placeholder"});
                    }
                    
                    $().ready(function () {
                        $('#uploaded_attachments').on('click', '.ajax-delete', function (e) {
                            e.preventDefault();
                            
                            var me      = $(this);
                            var url     = me.attr('href');
                            var block   = me.parent().parent('.ajax_attachment');
                            
                            
                            $.ajax({url : url}).done(function () { block.slideToggle(500, function () { block.remove() }) })
                        })
                        
                        
                        $('#uploaded_attachments').sortable({placeholder: "sortable-placeholder"});
						
						$(document).on('click', '.ajax_attachment .edit', function (e) {
							e.preventDefault();
							var rel = $(this).attr('href');
							$(rel).slideToggle();
						})
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
	
	$('.datepicker').datepicker({dateFormat:'yy-mm-dd'});
})
</script>