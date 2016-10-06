<?php echo form_open_multipart(uri_string()) ?>

    <ul class="nav nav-tabs" id="mainTab">
      <li class="active"><a href="#product" data-toggle="tab">Prodotto</a></li>
	  <li><a href="#contents" data-toggle="tab">Informazioni</a></li>
      <li><a href="#images" data-toggle="tab">Immagini</a></li>
	  <li><a href="#videos" data-toggle="tab" id="products-videos-tab">Video</a></li>
	  <li><a href="#links" data-toggle="tab" id="products-links-tab">Links</a></li>
      <li><a href="#features" data-toggle="tab" id="products-features-tab">Caratteristiche</a></li>
	  <li><a href="#properties" data-toggle="tab" id="products-properties-tab">Proprietà</a></li>
	  <li><a href="#versions" data-toggle="tab" id="products-versions-tab">Versioni</a></li>
    </ul>


    <div class="tab-content">
        <div class="tab-pane active" id="product">

            <fieldset>
                <legend>Informazioni luogo</legend>
                <?php echo form_label('Nome Prodotto', 'product[name]') ?>
                <?php echo form_input('product[name]', set_value('product[name]', $product->name), 'class="span12" id="product[name]" placeholder=""') ?>
                
                <?php echo form_label('Distanza', 'product[distance]') ?>
                <?php echo form_input('product[distance]', set_value('product[distance]', $product->distance), 'class="span3" id="product[distance]" placeholder="Distanza"') ?>
<!--					
                <?php echo form_label('Categoria di appartenenza', 'product[category_id]') ?>
                <?php $categories[0] = 'Seleziona categoria' ?>
                <?php echo form_dropdown('product[category_id]', $categories, set_value('product[category_id]', $product->category_id), 'class="span12" id="product[category_id]"') ?>
    
				<?php echo form_label('Codice Prodotto', 'product[code]') ?>
                <?php echo form_input('product[code]', set_value('product[code]', $product->code), 'class="span3" id="product[code]" placeholder=""') ?>

				
                <?php echo form_label('Tipologia luogo', 'product[type_products_id]') ?>
                <?php echo form_dropdown('product[type_products_id]', $types_products, set_value('product[type_products_id]', $product->type_products_id), 'id="type-product" class="span3"') ?>

				<label class="checkbox">
                    <?php echo form_checkbox('product[is_new]', '1', set_checkbox('product[is_new]', '1', $product->is_new()), 'id="product[is_new]"') ?>
                    Novità
                </label>
-->				
                <label class="checkbox">
                    <?php echo form_checkbox('product[published]', '1', set_checkbox('product[published]', '1', $product->is_published()), 'id="product[published]"') ?>
                    Pubblicato
                </label>

			</fieldset>
			
			<fieldset>
				<legend>Posizione</legend>
				
				<div class="row-fluid">
					
				<div class="span4">
					<?php echo form_label('Città') ?>
					<?php echo form_input('product[city]', set_value('product[city]', $product->city), 'class="" id="city"'); ?>
					<br>
					<a href="#" onclick="codeAddress(); return false;" class="btn btn-primary"><i class="icon icon-map-marker icon-white"></i> Trova luogo</a>

					<?php echo form_label('Latitudine') ?>
					<?php echo form_input('product[lat]', set_value('product[lat]', $product->lat), 'class="" readonly="readonly" id="lat"'); ?>

					<?php echo form_label('Longitudine') ?>
					<?php echo form_input('product[lng]', set_value('product[lng]', $product->lng), 'class="" readonly="readonly" id="lng"'); ?>
				</div>
				
				<div class="span8">
					<div id="map-canvas" style="width:100%; height:350px"></div>
				</div>
				</div>
				<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
				<script>
				var geocoder;
				var map;
				function initialize() {
					geocoder = new google.maps.Geocoder();
					var latlng = new google.maps.LatLng(<?php echo $product->lat ?>, <?php echo $product->lng ?>);
					var mapOptions = {
						zoom: 15,
						center: latlng
					}
					map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
					
					<?php if($product->lat AND $product->lng): ?>
					var marker = new google.maps.Marker({
						map: map,
						position: map.getCenter(),
						draggable : true
					});

					google.maps.event.addListener(marker, 'dragend', function (event) {
						$('#lat').val(this.getPosition().lat());
						$('#lng').val(this.getPosition().lng());
					})
					<?php endif ?>
				}

				function codeAddress() {
					var address = document.getElementById('city').value;
					geocoder.geocode( { 'address': address}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							map.setCenter(results[0].geometry.location);
							var marker = new google.maps.Marker({
								map: map,
								position: results[0].geometry.location,
								draggable : true
							});
							
							var latitude = results[0].geometry.location.lat();
							var longitude = results[0].geometry.location.lng();
							
							$('#lat').val(latitude);
							$('#lng').val(longitude);
							
							google.maps.event.addListener(marker, 'dragend', function (event) {
								$('#lat').val(this.getPosition().lat());
								$('#lng').val(this.getPosition().lng());
							})
							
						} else {
							alert('Geocode was not successful for the following reason: ' + status);
						}
					});
				}
				
				initialize()
				
				/*
				google.maps.event.addDomListener(window, 'load', initialize);*/
				</script>
			</fieldset>
			
			<?php 
			
			$showcases = $this->db->get_where('showcases', array('featured' => 1))->result();
			
			if ($showcases): 
			?>
			<br>
			<fieldset>
				<legend>Mostra luogo nelle vetrine</legend>
				<?php foreach($showcases as $showcase): ?>
					<label class="checkbox">
						<?php echo form_checkbox('showcases[]', $showcase->id, set_checkbox('showcases[]', $showcase->id, $product->is_in_showcase($showcase->id)), 'id="showcases[]"') ?>
						<?php echo $showcase->name ?>
					</label>
				<?php endforeach ?>
            </fieldset>
			<?php
			endif
			?>
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
														
                            <?php echo form_label('Nome', 'content['.$iso.'][name]') ?>
                            <?php echo form_input('content['.$iso.'][name]', set_value('content['.$iso.'][name]', $content->name), 'class="span12" id="'.'content['.$iso.'][name]" placeholder=""') ?>

                            <?php echo form_label('Descrizione', 'content['.$iso.'][description]') ?>
                            <?php echo form_textarea('content['.$iso.'][description]', set_value('content['.$iso.'][description]', $content->description), 'class="ckeditor span12" id="'.'content['.$iso.'][description]" placeholder=""') ?>            
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
                                Attivo
                            </label>

							<?php if($product->id): ?>
							<a href="<?php echo base_url($iso .'/'. $content->get_slug())?>" target="_blank" class="btn btn-inverse pull-right">Vai al Prodotto</a>
							<?php endif ?>
                        </fieldset>
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
                
                <iframe src="<?php echo base_url('admin/images/iframe_upload') ?>" style="border: 0; width:100%; height: 50px; overflow: hidden"></iframe>
                
              </fieldset>
            
            <fieldset>
                <legend>Immagini caricate</legend>
 
                <div id="uploaded">
                    <?php 
                        if(isset($uploaded)) echo $uploaded;
                        
                        foreach($images as $image)
                        {
                            echo $this->layout->load_view('products/snippets/image', array('image' => $image));
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
        
		
		<div class="tab-pane" id="videos">
			<fieldset>
				<legend>Video</legend>
				
				<?php echo form_dropdown('video[]', dropize_me($this->video_model->get_all(), 'name', 'id') , set_value('video[]', $this->video_model->get_all_related_id($product->id)), 'multiple="multiple" id="video-select" class="span12"') ?>
				
				
				<legend>Ordina gli elementi</legend>
				
				<div id="video-list" class="sortable-list">
					<?php 
					foreach($product->get_videos() as $video) 
					{
						echo $this->layout->load_view('videos/snippets/ajax_listed', array('item' => $video, 'product_id' => $product->id));
					}
					?>
				</div>
				
				<script>
				
				var DOM	= $(document)
				
				var change_event_fired = function () {
					
					var my_data		= $(this).val()
					var ajax_done	= function (r) {
						$('#video-list').html(r)
					}
					
					$.ajax({
						url		: '<?php echo base_url('admin/videos/ajax_get') ?>',
						data	: {list : my_data, product_id : '<?php echo $product->id ?>'},
					}).done(ajax_done);
				}
				
				var video_control	= function () { 
					DOM.on('change', '#video-select', change_event_fired)
				}
				
				DOM.ready(video_control)
				
				</script>
			</fieldset>
		</div>
		
		
		
        <div class="tab-pane" id="links">
			<fieldset>
				<legend>Collegamenti</legend>
				
				<ul style="list-style: none; margin:0; padding: 0">	
				<?php foreach($links_list as $link): ?>
					<li style="padding:4px 0;">
						
						<label class="checkbox">
							<?php echo form_checkbox('links[]', $link->id ,  set_checkbox('links[]', $link->id, $link->is_product_link()), 'class="checkbox-link"') ?>
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
				})
			})
			</script>
		</div>
        
		
		
		
        <div class="tab-pane" id="features">
            <?php echo $this->layout->load_view('products/snippets/features', array('product' => $product)) ?> 
        </div>
        <script>
            $().ready(function () {
                $('#type-product').on('change', function() {
                    var id = $(this).val();
                    
                    $.ajax({
                        url : '<?php echo base_url('admin/products/get_features_by_type_product_id') ?>/' + id
                    }).done(function (response) {
                        $('#features').html(response);
                        
                        // set active first tab
                        $.each($('.featuresTab'), function () {
                            $(this).find('a:first').tab('show');
                        })
                    })
                })
                
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
		
		<div class="tab-pane" id="properties">
            <?php echo $this->layout->load_view('products/snippets/properties', array('product' => $product)) ?> 
        </div>
		
		<div class="tab-pane" id="versions">
            <?php echo $this->layout->load_view('versions/list', array('product' => $product, 'versions' => $versions)) ?> 
        </div>
		
		
    </div>
    
    <div class="form-actions">
        <?php echo form_submit('', 'Salva luogo', 'class="btn btn-primary"') ?>
    </div>

<?php echo form_close() ?>

<script>
function getHash() {
  var hash = window.location.hash;
  return hash
}

$().ready(function () {
	$('a[href='+getHash()+']').tab('show')
})
</script>