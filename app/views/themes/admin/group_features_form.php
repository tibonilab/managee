<?php echo form_open('') ?>
    <fieldset>
        <?php echo form_label('Nome Gruppo', 'group_features[name]') ?>
        <?php echo form_input('group_features[name]', set_value('group_features[name]', $group_features->name), 'class="span12" id="group_features[name]" placeholder="Nome di riferimento al gruppo di caratteristiche.."') ?>
        
        <!--
            
        <?php /*echo form_label('Visibile per i gruppi', 'group_features[parent_id]') ?>
        <?php echo form_multiselect('related[groups][]', $groups, set_value('related[groups][]', $related_groups), 'class="span12" id="related[groups][]"') ?>
        
		<?php echo form_label('Tipo Caratteristica', 'group_features[type]') ?>
		<?php $types = array('numeric'=>'Numerica', 'string'=>'Testuale') ?>
		<?php echo form_dropdown('group_features[type]', $types, set_value('group_features[type]', $group_features->type)) ?>
        
        <label class="checkbox">
            <?php echo form_checkbox('group_features[visible]', '1', set_checkbox('group_features[visible]', '1', $group_features->is_visible()), 'id="group_features[visible]"') ?>
            Visibile
        </label>
        <?php */ ?>
        -->
        
    </fieldset>

    <fieldset style="margin-top:40px">
        
        <?php if(count($this->languages) >= 1):?>
        <div class="navbar">
            <div class="navbar-inner">
                <span class="brand">Lingua</span>
                <ul class="nav" id="contentTab">
                    <?php foreach($this->languages as $content): $iso = $content->iso ?>
                    <li><a href="#<?php echo $iso ?>" data-toggle="tab"><?php echo $iso ?></a></li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
        <?php endif ?>
        
        <div class="tab-content">
        <?php foreach($this->languages as $content): $iso = $content->iso  ?>
            <div class="tab-pane" id="<?php echo $iso ?>">

                <fieldset class="span12">
                    <legend>Contenuti in lingua</legend>
                    <?php echo form_label('Etichetta', 'content['.$iso.'][label]') ?>
                    <?php echo form_input('content['.$iso.'][label]', set_value('content['.$iso.'][label]', $group_features->get_contents($iso, 'label')), 'class="span12" id="'.'content['.$iso.'][label]" placeholder="Nome visualizzato del gruppo caratteristiche"') ?>
					
					<label class="checkbox">
                        <?php echo form_checkbox('content['.$iso.'][active]', '1', set_checkbox('content['.$iso.'][active]', '1', $group_features->get_contents($iso)->is_active())) ?>
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