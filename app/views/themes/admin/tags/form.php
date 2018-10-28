<?php echo form_open('') ?>
    <fieldset>
        <?php echo form_label('Nome Tag', 'tag[name]') ?>
        <?php echo form_input('tag[name]', set_value('tag[name]', $item->name), 'class="span12" id="tag[name]" placeholder="Nome di riferimento al tag.."') ?>
		
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

                <fieldset class="span12">
                    <?php echo form_label('Etichetta', 'content['.$iso.'][label]') ?>
                    <?php echo form_input('content['.$iso.'][label]', set_value('content['.$iso.'][label]', $content->label), 'class="span12" id="'.'content['.$iso.'][label]" placeholder="Etichetta del Tag"') ?>
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