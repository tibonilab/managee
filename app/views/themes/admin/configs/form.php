<?php echo form_open('') ?>

	<fieldset>
		<legend>Parametro di configurazione</legend>
		
		<?php echo form_label('Chiave', 'param[key]') ?>
		<?php echo form_input('param[key]', set_value('param[key]', $param->key), 'class="span12" id="param[key]" placeholder="Chiave della prorpietà"') ?>

		<?php echo form_label('Valore', 'param[value]') ?>
		<?php echo form_input('param[value]', set_value('param[value]', $param->value), 'class="span12" id="param[value]" placeholder="Valore della proprietà"') ?>

		<?php if($param->key == 'maintenance_access_ip'): ?>
			IP Attuale: <b><?php echo $_SERVER['REMOTE_ADDR'] ?></b>
			<br><br>
		<?php endif ?>

		
		<?php echo form_label('Descrizione', 'param[memo]') ?>
		<?php echo form_input('param[memo]', set_value('param[memo]', $param->memo), 'class="span12" id="param[memo]" placeholder="Descrizione"') ?>
	</fieldset>

    <div class="form-actions">
    <?php echo form_submit('', 'Salva', 'class="btn btn-primary"') ?>
    </div>
        
<?php echo form_close() ?>
