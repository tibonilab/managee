<?php echo form_open_multipart('') ?>

	<ul class="nav nav-tabs" id="mainTab">
		<li class="active"><a href="#item" data-toggle="tab">Partner</a></li>
	</ul>

	 <div class="tab-content">
        <div class="tab-pane active" id="item">

			<fieldset>
				<?php echo form_label('Identificativo', 'item[label]') ?>
				<?php echo form_input('item[label]', set_value('item[label]', $partner->label), 'class="span12" id="item[name]" placeholder="Nome identificativo partner.."') ?>

				<?php echo form_label('Nome', 'item[name]') ?>
				<?php echo form_input('item[name]', set_value('item[name]', $partner->name), 'class="span12" id="item[name]" placeholder="Nome del partner.."') ?>

				<?php echo form_label('Cognome', 'item[surname]') ?>
				<?php echo form_input('item[surname]', set_value('item[surname]', $partner->surname), 'class="span12" id="item[surname]" placeholder="Cognome del partner.."') ?>

				
			</fieldset>
		</div>

		 
	 </div>
	
	<div class="form-actions">
		<?php echo form_submit('', 'Salva', 'class="btn btn-primary"') ?>
	</div>
        
<?php echo form_close() ?>

<script>
$(document).ready(function () {
    $('#contentTab a:first').tab('show'); 
})
</script>