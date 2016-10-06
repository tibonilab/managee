<?php echo form_open_multipart() ?>

	<div class="row-fluid">
		<div class="span8">

			<fieldset>
				<legend>Dati voce di menù</legend>
				<?php echo form_label('Nome voce di menù', 'item[name]') ?>
				<?php echo form_input('item[name]', set_value('item[name]', $menu_item->name), 'class="span12"') ?>
				
				<div class="row-fluid">
					<div class="span4">
						<?php echo form_label('Sottomenù di', 'item[parent_id]') ?>
						<?php echo form_dropdown('item[parent_id]', $menu_item->get_parent_menu_item_list(), set_value('item[parent_id]', $menu_item->parent_id), 'class="span12"') ?>
					</div>
					<div class="span4">
						<?php echo form_label('Link verso', 'item[entity]') ?>
						<?php echo form_dropdown('item[entity]', array('URL','pages' => 'Pagina', 'categories' => 'Categoria Luoghi','news' => 'News', 'showcases' => 'Galleria fotografica'), set_value('item[entity]', $menu_item->entity), 'class="span12" id="entity"') ?>
					</div>
					<div class="span4">
						<?php echo form_label('Target', 'item[target]') ?>
						<?php echo form_dropdown('item[target]', array('_self' => '_self', '_blank' => '_blank', '_parent' => '_parent', '_top' => '_top'), set_value('item[target]', $menu_item->target), 'class="span12"') ?>

					</div>
				</div>

				<div id="entity_id-wrap" class="<?php if( ! $menu_item->entity) echo 'hide'  ?>">
					<?php echo form_label('Entità da raggiungere', 'item[entity_id]') ?>
					<?php echo form_dropdown('item[entity_id]', array(), set_value('item[entity_id]', $menu_item->entity_id), 'class="span12" id="entity_id"') ?>
				</div>


				<br>

				<div class="navbar">
					<div class="navbar-inner">
						<span class="brand">Lingua</span>
						<ul class="nav" id="contentTab">
						<?php foreach($languages as $lang): ?>
							<li><a href="#<?php echo $lang->iso ?>" data-toggle="tab"><?php echo $lang->iso ?></a></li>
						<?php endforeach ?>
						</ul>
					</div>
				</div>


				<div class="tab-content">
				<?php foreach($languages as $lang): ?>
					<div class="tab-pane" id="<?php echo $lang->iso ?>">
						<?php echo form_label('Etichetta voce di menù', 'contents['.$lang->iso.'][label]') ?>
						<?php echo form_input('contents['.$lang->iso.'][label]', set_value('contents['.$lang->iso.'][label]', $menu_item->get('label', $lang->iso)), 'class="span4"') ?>
						
						<?php echo form_label('Eventuale sottotitolo', 'contents['.$lang->iso.'][label]') ?>
						<?php echo form_input('contents['.$lang->iso.'][extra]', set_value('contents['.$lang->iso.'][extra]', $menu_item->get('extra', $lang->iso)), 'class="span12"') ?>
						
						<div class="url-wrap <?php if($menu_item->entity) echo 'hide'  ?>">
							<?php echo form_label('URL di destinazione') ?>
							<?php echo form_input('contents['.$lang->iso.'][url]', set_value('contents['.$lang->iso.'][url]', $menu_item->get('url', $lang->iso)), 'class="span12"') ?>
						</div>
						
						<?php echo form_label('Ancora (Hash: #example)', 'contents['.$lang->iso.'][hash]') ?>
						<?php echo form_input('contents['.$lang->iso.'][hash]', set_value('contents['.$lang->iso.'][hash]', $menu_item->get('hash', $lang->iso)), 'class="span6"') ?>
					</div>
				<?php endforeach ?>
				</div>
			</fieldset>

		</div>
		<div class="span4">

			<fieldset>
				<legend>Immagine</legend>
				
				<?php if($menu_item->icon): ?>
				<div class="img-wrap">
					<img src="<?php echo $menu_item->get_icon() ?>">
					<a href="<?php echo base_url('admin/menus/remove_item_image/' . $menu_item->menu_id . '/' . $menu_item->id) ?>" class="btn btn-danger pull-right remove-image"><i class="icon icon-trash icon-white"></i></a>
				</div>
				<?php endif ?>
					
				<?php echo form_upload('image') ?>
			</fieldset>

		</div>
	</div>



	<div class="form-actions">
		<?php echo form_hidden('item[menu_id]', $menu_item->menu_id) ?>
		<?php echo form_submit('', 'Salva', 'class="btn btn-primary"') ?>
		<a href="<?php echo base_url('admin/contenuti/menu/modifica/' . $menu_item->menu_id) ?>" class="btn btn-inverse">Torna indietro</a>
	</div>

<?php echo form_close() ?>


<script>
$(document).ready(function () {
    $('#contentTab a:first').tab('show'); 
	
	
	
	
	
	$(this).on('change', '#entity', function () {
		var val = $(this).val()
		
		if(val != 0)
		{
			$('#entity_id-wrap').show();
			$('.url-wrap').hide();
			
			$.ajax({
				url			: '<?php echo base_url('admin/menus/ajax_entity_list') ?>/' + val + '/<?php echo $menu_item->entity_id ?>',
			}).done(function (r) {
				$('#entity_id').replaceWith(r);
			})
		}
		else
		{
			$('#entity_id-wrap').hide();
			$('.url-wrap').show();
		}
		
	})
	
	
	$('#entity').trigger('change')
	
	$(this).on('click', '.remove-image', function (e) {
		e.preventDefault()
		
		var me				= $(this);
		var url				= me.prop('href');
		var elem_to_remove	= me.parent('.img-wrap');
		
		$.ajax({url : url}).done(function() { elem_to_remove.slideToggle() })
	})
})
</script>