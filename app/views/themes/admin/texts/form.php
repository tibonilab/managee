<?php echo form_open('') ?>

	<ul class="nav nav-tabs" id="mainTab">
		  <li class="active"><a href="#text" data-toggle="tab">Info</a></li>
		  <li><a href="#contents" data-toggle="tab">Contenuti</a></li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="text">

			<fieldset>
				<?php echo form_label('Chiave', 'text[key]') ?>
				<?php echo form_input('text[key]', set_value('text[key]', $item->key), 'class="span12" id="text[key]" placeholder="ID di riferimento al campo testo"') ?>

				<?php echo form_label('Promemoria', 'text[memo]') ?>
				<?php echo form_input('text[memo]', set_value('text[memo]', $item->memo), 'class="span5" id="text[memo]" placeholder="Promemoria posizione testo"') ?>

				<?php echo form_label('Tipo', 'text[type]') ?>
				<?php echo form_dropdown('text[type]', array('label' => 'Etichetta', 'editor' => 'Campo testo'), set_value('text[type]', $item->type), 'class="span3" id="type"') ?>

			</fieldset>
		</div>

		<div class="tab-pane" id="contents">
			<fieldset>

				<?php if(count($item->get_contents()) >= 1):?>
				<div class="navbar">
					<div class="navbar-inner">
						<span class="brand">Lingua</span>
						<ul class="nav" id="contentTab">
							<?php foreach($item->get_contents() as $iso => $content): ?>
							<li><a href="#<?php echo $iso ?>" data-toggle="tab"><?php echo $iso ?></a></li>
							<?php endforeach ?>
						</ul>
					</div>
				</div>
				<?php endif ?>

				<div class="tab-content">
				<?php foreach($item->get_contents() as $iso => $content): ?>
					<div class="tab-pane" id="<?php echo $iso ?>">

						<fieldset class="span8">
							<legend>Contenuti</legend>
							
							<?php echo form_label('Testo', 'content['.$iso.'][value]') ?>
							
							<div class="value value-label">
								<?php echo form_input('content['.$iso.'][value]', set_value('content['.$iso.'][value]', $content->value), 'class="span12" id="'.'content['.$iso.'][value]" placeholder="Testo visualizzato" disabled') ?>
							</div>
							
							<div class="value value-editor">
								<?php echo form_textarea('content['.$iso.'][value]', set_value('content['.$iso.'][value]', $content->value), 'class="ckeditor span12" id="'.'content['.$iso.'][value]" placeholder="Testo visualizzato" disabled')?>
							</div>
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
		</div>
	</div>

    <div class="form-actions">
    <?php echo form_submit('', 'Salva', 'class="btn btn-primary"') ?>
    </div>
        
<?php echo form_close() ?>

<script>
var input_html;
var textarea_html;

$().ready(function () {
    $('#contentTab a:first').tab('show'); 
	
	init_field_types();
	
	select_field_type($('#type').val());	
	
	$('#type').on('change', function () {
		var to_show =  $(this).val();
		
		select_field_type(to_show);
	})
})

function init_field_types()
{

	
}


function select_field_type(type)
{
	type = '.value-' + type;
	
	$('.value').hide().find('input, textarea').prop('disabled', 'disabled');
	$(type).show().find('textarea').prop('disabled', false);
	$(type).show().find('input').removeAttr('disabled');
}
</script>