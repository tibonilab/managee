<?php echo form_open() ?>

	<fieldset>
		<legend>Info</legend>
		<?php echo form_label('Nome Vetrina', 'showcase[name]') ?>
		<?php echo form_input('showcase[name]', set_value('showcase[name]', $showcase->name), 'id="showcase[name]" class="span12"') ?>
	</fieldset>

	<fieldset>
		<legend>Fotografie</legend>

		<?php if(count($showcase->get_images()) > 0): ?>
			<div id="list">
			<?php foreach($showcase->get_images() as $product): ?>
				<div class="pull-left">
					<img class="img-polaroid" src="<?php echo media_url($product->get_default_image()->src, 'small') ?>" alt="">
					<?php echo form_hidden('products[]', $product->id) ?>
				</div>
			<?php endforeach ?>
			</div>

		<?php else: ?>
		<p class="text-center">Nessuna immagine in questa lista.</p>
		<?php endif ?>
	</fieldset>

	<div class="form-actions">
		<?php echo form_submit('', 'Salva', 'class="btn btn-primary"') ?>
	</div>

<?php echo form_close() ?>

<script>
$().ready(function () {
	$('#list').sortable();
})
</script>
	