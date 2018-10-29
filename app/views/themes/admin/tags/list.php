<a href="<?php echo uri_string() ?>/inserisci" class="btn pull-right">Aggiungi Tag <i class="icon-plus-sign"></i></a>
<?php echo form_open('', 'class="form-search pull-right" style="margin-right:20px"') ?>
    <div class="input-append">
        <?php echo form_input('', set_value(), 'placeholder="Cerca Tag" class="input-large search-query"') ?>
        <a href="" class="btn"><i class="icon-search"></i></a> 
    </div>
<?php echo form_close() ?>



<?php echo form_open() ?>

	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th width="75%">Nome</th>
				<th width="10%">Lingue</th>
				<th width="5%">Azioni</th>
			</tr>
		</thead>

		<tbody class="sortable-list">
			<?php if(count($list) > 0): ?>
			<?php foreach($list as $item): ?>
			<tr>
				<td width="75%"><?php echo $item->name ?></td>
				<td width="10%"><?php echo $this->layout->load_view('layouts/snippets/language/active_languages', array('languages' => $item->get_contents()), TRUE) ?></td>
				<td width="5%">
					<div class="btn-group">
						<a href="<?php echo uri_string() ?>/modifica/<?php echo $item->id ?>" class="btn"><i class="icon-wrench"></i></a>
						<a href="<?php echo uri_string() ?>/elimina/<?php echo $item->id ?>" class="btn btn-danger"><i class="icon-trash"></i></a>
					</div>
					<?php echo form_hidden('video[]', $item->id)?>
				</td>
			</tr>
			<?php endforeach ?>
			<?php else: ?>
			<tr>
				<td colspan="4">
					Nessun Tag trovato. <a href="<?php echo uri_string() ?>/inserisci">Inserisci un Tag.</a>
				</td>
			</tr>
			<?php endif ?>
		</tbody>

	</table>


<?php if(count($list) > 0): ?>
	<div class="form-actions">
		<?php echo form_submit('', 'Salva ordinamento', 'class="btn btn-primary"') ?>
	</div>
<?php endif ?>
<?php echo form_close() ?>


<script>
$().ready(function() {

	$('.sortable-list').sortable();

})
</script>