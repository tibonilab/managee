<fieldset>
	<div class="alert alert-info">
	Seleziona le caratteristiche che variano per le versioni di questa tipologia di prodotti.
	</div>
	
	<?php foreach($versions_groups as $group): ?>
	<fieldset>
		<legend><?php echo $group->name ?></legend>
		<ul>
		<?php foreach($group->get_features() as $feature): ?>
			<li>
				<label class="checkbox">
					<?php echo form_checkbox('version_features['.$group->id.'][]', $feature->id, $feature->is_versionable) ?>
					<?php echo $feature->name ?>
				</label>
			</li>
		<?php endforeach ?>
		</ul>
	</fieldset>
	<?php endforeach ?>
</fieldset>