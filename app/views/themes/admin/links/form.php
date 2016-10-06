<?php echo form_open_multipart('') ?>
    <fieldset>
        <?php echo form_label('Nome Link', 'link[name]') ?>
        <?php echo form_input('link[name]', set_value('link[name]', $item->name), 'class="span12" id="link[name]" placeholder="Nome di riferimento al link.."') ?>
        
		<?php echo form_label('Target', 'link[target]') ?>
		<?php echo form_dropdown('link[target]', array('_self' => 'Pagine corrente', '_blank' => 'Nuova scheda'), set_value('link[target]', $item->target), 'class="span3" id="link[target]"') ?>
		
		<br class="clear">
		
		<?php if(empty($item->icon)): ?>
            <?php echo form_label('Immagine') ?>
            <?php echo form_upload('filename') ?>
        <?php else: ?>
            <img src="<?php echo $item->get_icon() ?>" style="margin-bottom:10px">
			<?php echo form_label('Sostituisci immagine con') ?>
            <?php echo form_upload('filename') ?>
        <?php endif ?>
		
    </fieldset>

	<fieldset style="margin-top:40px">

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
					<?php echo form_label('Testo visualizzato', 'content['.$iso.'][default_label]') ?>
					<?php echo form_input('content['.$iso.'][default_label]', set_value('content['.$iso.'][default_label]', $content->default_label), 'class="span12" id="'.'content['.$iso.'][default_label]" placeholder="Testo default del link (modificabile nel form prodotto)"') ?>
					
					<?php echo form_label('Collegamento', 'content['.$iso.'][default_href]') ?>
					<?php echo form_input('content['.$iso.'][default_href]', set_value('content['.$iso.'][default_href]', $content->default_href), 'class="span12" id="'.'content['.$iso.'][default_href]" placeholder="Pagina di destinazione di default del link (modificabile nel form prodotto)"') ?>
					
					<div class="alert alert-info">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<b>NOTA:</b><br> i campi <b>Testo visualizzato</b> e <b>Collegamento</b> sono valori standard per il link che possono essere modificati per ogni prodotto nel form prodotti, all'interno della tab "Links".
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

    <div class="form-actions">
    <?php echo form_submit('', 'Salva', 'class="btn btn-primary"') ?>
    </div>
        
<?php echo form_close() ?>

<script>
$().ready(function () {
    $('#contentTab a:first').tab('show'); 
})
</script>