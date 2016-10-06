<div class="ajax_image">
    <div class="span2">
    <img class="img-thumbnail" src="<?php echo media_url($image->src, 'squared')?>">
    <?php echo form_hidden('image[id][]', $image->id) ?>
    </div>
    
    <div class="span10">
        <ul class="nav nav-pills" id="imageTab_<?php echo $image->id ?>" style="margin-bottom:10px">
            <?php $active = 'active';foreach($image->get_contents() as $iso => $content): ?>
                <li class="<?php echo $active ?>"><a href="#image_<?php echo $image->id ?>_<?php echo $iso ?>" data-toggle="tab" rel="<?php echo $iso ?>"><?php echo $iso ?></a></li>
            <?php $active = ''; endforeach ?>
        </ul>

        <div class="tab-content">
            <?php $active = 'active'; foreach($image->get_contents() as $iso => $content): ?>
            <div class="tab-pane <?php echo $active ?>" id="image_<?php echo $image->id ?>_<?php echo $iso ?>">
                <?php echo form_label('Didascalia') ?>
                <?php echo form_input('image[content]['.$image->id.']['.$iso.'][description]', set_value('image[content]['.$image->id.']['.$iso.'][description]', $image->get_contents($iso)->description), 'class="span12"') ?>
                
                <?php echo form_label('Testo alternativo') ?>
                <?php echo form_input('image[content]['.$image->id.']['.$iso.'][title]', set_value('image[content]['.$image->id.']['.$iso.'][title]', $image->get_contents($iso)->title)) ?>
            </div>
            <?php $active = '';endforeach ?>
        </div>
        
        <br>
        
        <?php $hide = (isset($category) AND $category->is_default_image($image->id)) ? 'hide' : ''; ?>
        <a class="btn btn-danger areyousure ajax-delete pull-right <?php echo $hide ?>" href="<?php echo base_url('admin/images/delete/'. $image->id) ?>"><i class="icon-trash icon-white"></i> Elimina</a>
        
        <label class="radio">
            <?php echo form_radio('category[default_image_id]', $image->id, set_radio('category[default_image_id]', $image->id, (isset($category)) ? $category->is_default_image($image->id) : TRUE), 'class="default_image"') ?> Immagine prefefinita
        </label>
        
        <br class="clear">
    </div>
    
    <br class="clear">
    <hr>
</div>

