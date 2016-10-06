<legend>Versioni prodotto</legend>

<?php if( ! $product->id ): ?>

	<div class="alert alert-info">
		<?php echo form_submit('return', 'Salva e aggiungi versione', 'class="btn btn-inverse pull-right" style="margin-top:6px"') ?>
		<b>ATTENZIONE:</b><br>Per poter inserire una Versione è necessario prima creare il prodotto salvandolo.
		<br class="clear">
	</div>

<?php else: ?>

	<a href="admin/luoghi/inventario/aggiungi-versione/<?php echo $product->id?>" class="btn pull-right">Aggiungi Versione <i class="icon-plus-sign"></i></a>

	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th width="10%"></th>
				<th width="75%">Nome</th>
				<th width="10%">Pubbilcata</th>
				<th width="5%">Azioni</th>
			</tr>
		</thead>

		<tbody>
			<?php if(count($versions) > 0): ?>
			<?php foreach($versions as $version): ?>
			<tr>
				<td width="10%">
					<div class="image-wrap">
						<img src="<?php echo base_url($version->get_default_image()->get_thumb()) ?>" width="50">
						<?php /*if($version->is_new()): ?>
						<img class="hover" src="<?php echo base_url('assets/admin/images/new-product.png') ?>" alt="new">
						<?php endif */ ?>
					</div>
				</td>
				<td><?php echo $version->name ?></td>
				<td><?php echo $this->layout->load_view('layouts/snippets/is_published', array('item' => $version), TRUE) ?></td>
				<td>
					<div class="btn-group">
						<a href="admin/luoghi/inventario/modifica-versione/<?php echo $product->id ?>/<?php echo $version->id ?>" class="btn"><i class="icon-wrench"></i></a>
						<a href="admin/versions/delete/<?php echo $version->id ?>" class="btn btn-danger"><i class="icon-trash"></i></a>
					</div>
				</td>
			</tr>
			<?php endforeach ?>
			<?php else: ?>
			<tr>
				<td colspan="3">
					Nessuna Versione attualmente inserita. <a href="admin/luoghi/inventario/aggiungi-versione/<?php echo $product->id?>">Inserisci una Versione.</a>
				</td>
			</tr>
			<?php endif ?>
		</tbody>

	</table>

<?php endif ?>