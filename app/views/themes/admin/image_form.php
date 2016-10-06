<?php echo form_open_multipart('') ?>
    <fieldset>
        <?php echo form_label('Nome Immagine', 'image[name]') ?>
        <?php echo form_input('image[name]', set_value('image[name]', $image->name), 'class="span12" id="image[name]" placeholder="Nome di riferimento all\'immagine"') ?>
        
        <?php if(empty($image->name)): ?>
            <?php echo form_label('Immagine') ?>
            <?php echo form_upload('filename') ?>
        <?php else: ?>
            <img src="<?php echo $image->get_thumb() ?>" alt="<?php echo $image->name ?>">
        
			<h3>Url alle immagini</h3>
			<table class="table table-striped">
				<tbody>
					<tr>
						<td>Thumb</td>
						<td><?php echo base_url($image->get_thumb()) ?></td>
					</tr>
					<tr>
						<td>Small</td>
						<td><?php echo base_url($image->get_small()) ?></td>
					</tr>
					<tr>
						<td>Medium</td>
						<td><?php echo base_url($image->get_medium()) ?></td>
					</tr>
					<tr>
						<td>Squared</td>
						<td><?php echo base_url($image->get_squared()) ?></td>
					</tr>
					<tr>
						<td>Big</td>
						<td><?php echo base_url($image->get_big()) ?></td>
					</tr>
					<tr>
						<td>Wide</td>
						<td><?php echo base_url($image->get_showcase()) ?></td>
					</tr>
					<tr>
						<td>Upload</td>
						<td><?php echo base_url($image->get_upload()) ?></td>
					</tr>
				</tbody>
			</table>
		<?php endif ?>
			
    </fieldset>

    <fieldset style="margin-top:40px">
        
        <?php if(count($contents) >= 1):?>
        <div class="navbar">
            <div class="navbar-inner">
                <span class="brand">Lingua</span>
                <ul class="nav" id="contentTab">
                    <?php foreach($contents as $iso => $content): ?>
                    <li><a href="#<?php echo $iso ?>" data-toggle="tab"><?php echo $iso ?></a></li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
        <?php endif ?>
        
        <div class="tab-content">
        <?php foreach($contents as $iso => $content): ?>
            <div class="tab-pane" id="<?php echo $iso ?>">

                <fieldset class="span12">
                    <?php echo form_label('Titolo', 'content['.$iso.'][title]') ?>
                    <?php echo form_input('content['.$iso.'][title]', set_value('content['.$iso.'][title]', $content->title), 'class="span12" id="'.'content['.$iso.'][title]" placeholder="Titolo immagine"') ?>

                    <?php echo form_label('Descrizione', 'content['.$iso.'][description]') ?>
                    <?php echo form_input('content['.$iso.'][description]', set_value('content['.$iso.'][description]', $content->description), 'class="ckeditor span12" id="'.'content['.$iso.'][description]" placeholder="Descrizione immagine"') ?>            
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