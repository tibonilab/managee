<?php echo form_open_multipart('') ?>
    <fieldset>
        <?php echo form_label('Descrizione', 'item[description]') ?>
        <?php echo form_input('item[description]', set_value('item[description]', $item->description), 'class="span4" id="item[description]" placeholder="Nome cartella file in lingua (es: english)"') ?>
        
        <?php echo form_label('ISO', 'item[iso]') ?>
        <?php echo form_input('item[iso]', set_value('item[iso]', $item->iso), 'class="span3" id="item[iso]" placeholder="Sigla lingua URLs (es: en)"') ?>
		
		<?php echo form_label('Sigla stato', 'item[state]') ?>
        <?php echo form_input('item[state]', set_value('item[state]', $item->state), 'class="span3" id="item[state]" placeholder="Sigla linga-stato (es: en-US)"') ?>
		
		<?php echo form_label('Sigla visualizzata', 'item[sign]') ?>
        <?php echo form_input('item[sign]', set_value('item[sign]', $item->sign), 'class="span3" id="item[sign]" placeholder="Sigla visualizzata nel front (es: ENG)"') ?>
		
		
		<?php if( ! isset($iso)): ?>
			<?php echo form_label('Copia contenuti da', 'copy_from') ?>
			<?php echo form_dropdown('copy_from', $langs_list, set_value(), 'class="span3"') ?>
		<?php endif ?>
		
		<label class="checkbox">
			<?php echo form_checkbox('item[default]', '1', set_checkbox('item[default]', '1', $item->is_default()), 'id="item[default]"') ?>
			Default
		</label>

		<label class="checkbox">
			<?php echo form_checkbox('item[active]', '1', set_checkbox('item[active]', '1', $item->is_active()), 'id="item[active]"') ?>
			Attiva
		</label>
		
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