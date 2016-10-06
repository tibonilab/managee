<!--<?php if(!$this->input->get('key')): ?>
<div class="alert alert-info">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>NOTA: </strong> Puoi ordinare gli elemanti trascinandoli.
</div>
<?php endif ?>-->

<a href="<?php echo uri_string() ?>/inserisci" class="btn pull-right">Aggiungi <i class="icon-plus-sign"></i></a>
<?php echo form_open('', 'class="form-search pull-right" style="margin-right:20px" method="get"') ?>
    <div class="input-append">
        <?php echo form_input('key', $this->input->get('key'), 'placeholder="Cerca" class="input-large search-query"') ?>
        <button type="submit" class="btn"><i class="icon-search"></i></button> 
    </div>
<?php echo form_close() ?>



<?php echo form_open() ?>

	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th width="95%">ID</th>
				<th width="5%">Azioni</th>
			</tr>
		</thead>

		<tbody class="sortable-list">
			<?php if(count($partners) > 0): ?>
			<?php foreach($partners as $partner): ?>
			<tr>
				<td width="95%"><?php echo $partner->label ?></td>
				<td width="5%">
					<div class="btn-group">
						<a href="<?php echo uri_string() ?>/modifica/<?php echo $partner->id ?>" class="btn"><i class="icon-wrench"></i></a>
						<a href="<?php echo uri_string() ?>/elimina/<?php echo $partner->id ?>" class="btn btn-danger"><i class="icon-trash"></i></a>
					</div>
					<?php echo form_hidden('item[]', $partner->id)?>
				</td>
			</tr>
			<?php endforeach ?>
			<?php else: ?>
			<tr>
				<td colspan="5">
					<p class="text-center">
					Nessun elemento trovato. <a href="<?php echo uri_string() ?>/inserisci">Inserisci</a>
					</p>
				</td>
			</tr>
			<?php endif ?>
		</tbody>

	</table>

<!--
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
	-->
	
<?php echo form_close() ?>


