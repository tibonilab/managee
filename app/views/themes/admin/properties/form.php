<?php echo form_open_multipart('') ?>
    <fieldset>
        <?php echo form_label('Nome Prorpietà', 'property[name]') ?>
        <?php echo form_input('property[name]', set_value('property[name]', $property->name), 'class="span12" id="property[name]" placeholder="Nome di riferimento alla proprietà.."') ?>
        
		<?php if(empty($property->icon)): ?>
            <?php echo form_label('Immagine') ?>
            <?php echo form_upload('filename') ?>
        <?php else: ?>
            <img src="<?php echo $property->get_icon() ?>" style="margin-bottom:10px">
			<?php echo form_label('Sostituisci immagine con') ?>
            <?php echo form_upload('filename') ?>
        <?php endif ?>
		
    </fieldset>

	<fieldset style="margin-top:40px">

		<?php if(count($property->get_contents()) >= 1):?>
		<div class="navbar">
			<div class="navbar-inner">
				<span class="brand">Lingua</span>
				<ul class="nav" id="contentTab">
					<?php foreach($property->get_contents() as $iso => $content): ?>
					<li><a href="#<?php echo $iso ?>" data-toggle="tab"><?php echo $iso ?></a></li>
					<?php endforeach ?>
				</ul>
			</div>
		</div>
		<?php endif ?>

		<div class="tab-content">
		<?php foreach($property->get_contents() as $iso => $content): ?>
			<div class="tab-pane" id="<?php echo $iso ?>">

				<fieldset class="span8">
					<legend>Contenuti</legend>
					<?php echo form_label('Etichetta', 'content['.$iso.'][label]') ?>
					<?php echo form_input('content['.$iso.'][label]', set_value('content['.$iso.'][label]', $content->label), 'class="span12" id="'.'content['.$iso.'][label]" placeholder=""') ?>
				</fieldset>

				<fieldset class="span4">
					<legend>Dati tecnici</legend>

					<label class="checkbox">
						<?php echo form_checkbox('content['.$iso.'][active]', '1', set_checkbox('content['.$iso.'][active]', '1', $content->is_active())) ?>
						Attivo
					</label>

				</fieldset>
			</div>
		<?php endforeach ?>
		</div>
	</fieldset>

    <div class="form-actions">
    <?php echo form_submit('', 'Salva', 'class="btn btn-primary"') ?>
    </div>
        
<?php echo form_close() ?>

<script>
$().ready(function () {
    $('#contentTab a:first').tab('show'); 
})
</script>