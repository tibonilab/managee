<?php echo form_open_multipart() ?>

    <ul class="nav nav-tabs" id="mainTab">
		<li class="active"><a href="#version" data-toggle="tab">Prodotto</a></li>
		<li><a href="#contents" data-toggle="tab">Contenuti</a></li>
		<li><a href="#features" data-toggle="tab" style="display:none">Caratteristiche</a></li>
		<li><a href="#images" data-toggle="tab">Immagini</a></li>
		<li><a href="#links" data-toggle="tab" style="display:none">Links</a></li>
    </ul>


    <div class="tab-content">
        <div class="tab-pane active" id="version">
            <fieldset>
                <legend>Informazioni versione</legend>
                <?php echo form_label('Nome Versione', 'version[name]') ?>
                <?php echo form_input('version[name]', set_value('version[name]', $version->name), 'class="span12" id="version[name]" placeholder=""') ?>
                
				<?php echo form_label('Codice Versione', 'version[code]') ?>
                <?php echo form_input('version[code]', set_value('version[code]', $version->code), 'class="span3" id="version[code]" placeholder=""') ?>

                <label class="checkbox">
                    <?php echo form_checkbox('version[published]', '1', set_checkbox('version[published]', '1', $version->is_published()), 'id="version[published]"') ?>
                    Pubblicato
                </label>
            </fieldset>
		</div>
		<div class="tab-pane" id="contents">
            <fieldset>

                <?php if(count($version->get_contents()) >= 1):?>
                <div class="navbar">
                    <div class="navbar-inner">
                        <span class="brand">Lingua</span>
                        <ul class="nav" id="contentTab">
                            <?php foreach($version->get_contents() as $iso => $content): ?>
                            <li><a href="#<?php echo $iso ?>" data-toggle="tab"><?php echo $iso ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
                <?php endif ?>

                <div class="tab-content">
                <?php foreach($version->get_contents() as $iso => $content): ?>
                    <div class="tab-pane" id="<?php echo $iso ?>">

                        <fieldset class="span12">
                            <legend>Contenuti</legend>
                            <?php echo form_label('Nome', 'content['.$iso.'][name]') ?>
                            <?php echo form_input('content['.$iso.'][name]', set_value('content['.$iso.'][name]', $content->name), 'class="span12" id="'.'content['.$iso.'][name]" placeholder=""') ?>

                            <?php echo form_label('Descrizione', 'content['.$iso.'][description]') ?>
                            <?php echo form_textarea('content['.$iso.'][description]', set_value('content['.$iso.'][description]', $content->description), 'class="ckeditor span12" id="'.'content['.$iso.'][description]" placeholder=""') ?>            
                        </fieldset>
<?php /*
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
                                Attivo
                            </label>

                        </fieldset> */ ?>
                    </div>
                <?php endforeach ?>
                </div>
            </fieldset>

            <script>
            $().ready(function () {
                $('#contentTab a:first').tab('show'); 
            })
            </script>
        </div>
    
        <div class="tab-pane" id="images">
            <fieldset>
                <legend>Carica immagini</legend>
                
                <iframe src="<?php echo base_url('admin/images/iframe_upload/versions') ?>" style="border: 0; width:100%; height: 50px; overflow: hidden"></iframe>
                
              </fieldset>
            
            <fieldset>
                <legend>Immagini caricate</legend>
 
                <div id="uploaded">
                    <?php 
                        if(isset($uploaded)) echo $uploaded;
                        
                        foreach($images as $image)
                        {
                            echo $this->layout->load_view('versions/snippets/image', array('image' => $image), TRUE);
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
							console.log('mh')
                            $('.hide').show().removeClass('hide');
                            $(this).parent().parent().children('.ajax-delete').addClass('hide').hide();
                        })
                        
                        $('#uploaded').sortable();
                        $('.hide').hide();
                    })
                </script>
            </fieldset>
        </div>
        
        <div class="tab-pane" id="features">
            <?php echo $this->layout->load_view('versions/snippets/features', array('version' => $version), TRUE) ?> 
        </div>
        <script>
            $().ready(function () {
                $(document).on('dblclick', '.nav a', function () {
                    var iso = $(this).attr('rel');
                    
                    $('.nav a[rel='+iso+']').trigger('click');
                })
				
				// set active first tab
				$.each($('.featuresTab'), function () {
					$(this).find('a:first').tab('show');
				})
            })
        </script>		
		
		<div class="tab-pane" id="links">
            	<fieldset>
				<legend>Collegamenti</legend>
				
				<ul style="list-style: none; margin:0; padding: 0">	
				<?php foreach($links_list as $link): ?>
					<li style="padding:4px 0;">
						
						<label class="checkbox">
							<?php echo form_checkbox('links[]', $link->id ,  set_checkbox('links[]', $link->id, $link->is_version_link()), 'class="checkbox-link"') ?>
							<img src="<?php echo $link->get_icon() ?>" width="30" height="30">
							<?php echo $link->name ?>
						</label>
						
						<!-- .toggle -->
						<div class="toggle">
							
							<ul class="nav nav-pills" id="linkTab_<?php echo $link->id ?>" style="margin-bottom:10px; float:right;">
								<?php $active = 'active';foreach($link->get_contents() as $iso => $content): ?>
									<li class="<?php echo $active ?>"><a href="#link_<?php echo $link->id ?>_<?php echo $iso ?>" data-toggle="tab" rel="<?php echo $iso ?>"><?php echo $iso ?></a></li>
								<?php $active = ''; endforeach ?>
							</ul>
							
							<div class="tab-content">
							<?php $active = 'active'; foreach($link->get_contents() as $iso => $link_content): ?>
								<div class="tab-pane <?php echo $active; ?>" id="link_<?php echo $link->id ?>_<?php echo $iso ?>">
									<?php echo form_label('Testo visualizzato', 'link_contents['.$link->id.']['.$iso.'][label]') ?>
									<?php echo form_input('link_contents['.$link->id.']['.$iso.'][label]', set_value('link_contents['.$link->id.']['.$iso.'][label]', $link_content->get_label())) ?>

									<?php echo form_label('URL di destinazione', 'link_contents['.$link->id.']['.$iso.'][href]') ?>
									<?php echo form_input('link_contents['.$link->id.']['.$iso.'][href]', set_value('link_contents['.$link->id.']['.$iso.'][href]', $link_content->get_href())) ?>
								</div>
							<?php $active = ''; endforeach ?>
							</div>
							
						</div>
						<!-- /.toggle -->
						
					</li>
				<?php endforeach ?>
				</ul>
				
			</fieldset>
			
			<script>
			$().ready(function () {
				
				
				$('.checkbox-link').each(function () {
					if( ! $(this).prop('checked'))
					{
						$(this).parent().parent().children('.toggle').toggle()
					}
				}).on('change', function () {
					$(this).parent().parent().children('.toggle').stop().slideToggle(500)
					console.log($(this).prop('checked'))
				})
			})
			</script>
        </div>
		
    </div>
    
	<?php echo form_hidden('version[product_id]', $product->id) ?>

    <div class="form-actions">
		<a href="admin/prodotti/inventario/modifica/<?php echo $product->id ?>#versions" class="btn btn-inverse pull-right">Torna al prodotto</a>
        <?php echo form_submit('', 'Salva versione', 'class="btn btn-primary"') ?>
    </div>

<?php echo form_close() ?>

