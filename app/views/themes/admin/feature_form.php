<?php echo form_open('') ?>
    <fieldset>
        <?php echo form_label('Nome Caratteristica', 'feature[name]') ?>
        <?php echo form_input('feature[name]', set_value('feature[name]', $feature->name), 'class="span12" id="feature[name]" placeholder="Nome di riferimento alla caratteristica.."') ?>
        
        <?php echo form_label('Visibile per i gruppi', 'feature[parent_id]') ?>
        <?php echo form_multiselect('related[groups][]', $groups, set_value('related[groups][]', $related_groups), 'class="span12" id="related[groups][]"') ?>
        
		<?php echo form_label('Tipo Caratteristica', 'feature[type]') ?>
		<?php $types = array('numeric'=>'Numerica', 'string'=>'Testuale') ?>
		<?php echo form_dropdown('feature[type]', $types, set_value('feature[type]', $feature->type)) ?>
        
        <label class="checkbox">
            <?php echo form_checkbox('feature[visible]', '1', set_checkbox('feature[visible]', '1', $feature->is_visible()), 'id="feature[visible]"') ?>
            Visibile
        </label>
    </fieldset>

    <fieldset style="margin-top:40px">
        
        <?php if(count($this->languages) >= 1):?>
        <div class="navbar">
            <div class="navbar-inner">
                <span class="brand">Lingua</span>
                <ul class="nav" id="contentTab">
                    <?php foreach($this->languages as $content): $iso = $content->iso; ?>
                    <li><a href="#<?php echo $iso ?>" data-toggle="tab"><?php echo $iso ?></a></li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
        <?php endif ?>
        
        <div class="tab-content">
        <?php foreach($this->languages as $content): $iso = $content->iso; ?>
            <div class="tab-pane" id="<?php echo $iso ?>">

                <fieldset class="span12">
                    <legend>Contenuti in lingua</legend>
                    <?php echo form_label('Etichetta', 'content['.$iso.'][label]') ?>
                    <?php echo form_input('content['.$iso.'][label]', set_value('content['.$iso.'][label]', $feature->get_contents($iso, 'label')), 'class="span12" id="'.'content['.$iso.'][label]" placeholder="Nome visualizzato della caratteristica"') ?>
                    
                    <?php echo form_label('Extra', 'content['.$iso.'][extra]') ?>
                    <?php echo form_input('content['.$iso.'][extra]', set_value('content['.$iso.'][extra]', $feature->get_contents($iso, 'extra')), 'class="span2" id="'.'content['.$iso.'][extra]"') ?>
					
					<label class="checkbox">
                        <?php echo form_checkbox('content['.$iso.'][active]', '1', set_checkbox('content['.$iso.'][active]', '1', $feature->get_contents($iso)->is_active())) ?>
                        Attiva
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