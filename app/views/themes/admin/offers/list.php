<?php if(!$this->input->get('key')): ?>
<div class="alert alert-info">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>NOTA: </strong> Puoi ordinare gli elemanti trascinandoli.
</div>
<?php endif ?>

<a href="<?php echo uri_string() ?>/inserisci" class="btn pull-right">Aggiungi Offerta <i class="icon-plus-sign"></i></a>
<?php echo form_open('', 'class="form-search pull-right" style="margin-right:20px" method="get"') ?>
    <div class="input-append">
        <?php echo form_input('key', $this->input->get('key'), 'placeholder="Cerca Offerta" class="input-large search-query"') ?>
        <button type="submit" class="btn"><i class="icon-search"></i></button> 
    </div>
<?php echo form_close() ?>


<?php echo form_open() ?>

	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th width="50"></th>
				<th width="70%">Nome</th>
				<th width="10%">Pubbilcata</th>
				<th width="10%">Lingue</th>
				<th width="5%">Azioni</th>
			</tr>
		</thead>

		<tbody class="sortable-list">
			<?php if(count($offers) > 0): ?>
			<?php foreach($offers as $offer): ?>
			<tr>
				<td width="50">
					<?php if($offer->has_default_image()): ?>
						<img src="<?php echo $offer->get_default_image()->get_thumb() ?>" style="width:40px; max-width: none">
					<?php endif ?>
				</td>
				<td width="70%"><?php echo $offer->name ?></td>
				<td width="10%"><?php echo $this->layout->load_view('layouts/snippets/is_published', array('item' => $offer), TRUE) ?></td>
				<td width="10%"><?php echo $this->layout->load_view('layouts/snippets/language/active_languages', array('languages' => $offer->get_contents()), TRUE) ?></td>
				<td width="5%">
					<div class="btn-group">
						<a href="<?php echo uri_string() ?>/modifica/<?php echo $offer->id ?>" class="btn"><i class="icon-wrench"></i></a>
						<a href="<?php echo uri_string() ?>/elimina/<?php echo $offer->id ?>" class="btn btn-danger"><i class="icon-trash"></i></a>
					</div>
					<?php echo form_hidden('item[]', $offer->id)?>
				</td>
			</tr>
			<?php endforeach ?>
			<?php else: ?>
			<tr>
				<td colspan="5">
					Nessuna offerta attualmente inserita. <a href="<?php echo uri_string() ?>/inserisci">Inserisci una Offerta.</a>
				</td>
			</tr>
			<?php endif ?>
		</tbody>

	</table>
	
	<?php if(!$this->input->get('key')): ?>
	<div class="form-actions">
		<?php echo form_submit('', 'Salva ordinamento', 'class="btn btn-primary"') ?>
	</div>

	<script>
	$().ready(function() {

		$('.sortable-list').sortable();

	})
	</script>
	<?php endif ?>
	
<?php echo form_close() ?>
