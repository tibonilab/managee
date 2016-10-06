<?php 

$suffix = isset($suffix) ? $suffix : NULL;
$label	= isset($label)	? $label : 'Vetrina';

?>
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th width="30">#</th>
			<th width="80%">Nome</th>
			<th width="10%">Foto</th>
			<th width="10%">Azioni</th>
		</tr>
	</thead>
	<tbody>
		<?php if(count($showcases) > 0): ?>
		<?php foreach($showcases as $item): ?>
		<tr>
			<td><?php echo form_radio('default', $item->id, $item->is_default()) ?></td>
			<td><?php echo $item->name ?></td>
			<td><?php echo $item->count_all_images() ?></td>
			<td>
				<div class="btn-group">
					<a href="<?php echo uri_string() ?>/modifica<?php echo $suffix ?>/<?php echo $item->id ?>" class="btn"><i class="icon icon-wrench"></i></a>
					<a href="<?php echo uri_string() ?>/elimina<?php echo $suffix ?>/<?php echo $item->id ?>" class="btn btn-danger"><i class="icon icon-trash"></i></a>
				</div>
			</td>
		</tr>
		<?php endforeach ?>
		<?php else: ?>
		<tr>
			<td colspan="2">
				Nessuna <?php echo $label ?> attualmente inserita. <a href="<?php echo uri_string()?>/inserisci<?php echo $suffix ?>">Inserisci una <?php echo $label ?></a>
			</td>
		</tr>
		<?php endif ?>
	</tbody>
</table>