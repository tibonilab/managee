<?php foreach($languages as $language): ?>
    <?php $type = ($language->is_active()) ? 'success' : 'important' ?>
	<?php $title = ($language->is_active()) ? 'Attiva' : 'Non attiva' ?>
    <span title="<?php echo $title ?>" data-placement="top" data-origina-title="test" data-animation="true" data-toggle="tooltip" class="label label-<?php echo $type ?>"><?php echo $language->iso ?></span>
<?php endforeach ?>