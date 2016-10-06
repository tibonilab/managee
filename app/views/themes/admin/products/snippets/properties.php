<legend>Proprietà prodotto</legend>
<?php foreach($properties as $property): ?>
	
<label class="checkbox">
	<?php echo form_checkbox('properties['.$property->id.']', 1, set_checkbox('properties['.$property->id.']', 1, $property->is_product_property())) ?>
	<?php echo $property->name ?>
</label>

<?php endforeach ?>