<?php if(count($feature->get_contents()) >= 1):?>
        
	<ul class="nav nav-pills featuresTab pull-right">
		<?php foreach($feature->get_contents() as $iso => $content): ?>
		<li><a href="#<?php echo $iso ?>_<?php echo $feature->feature_id?>" data-toggle="tab" rel="<?php echo $iso ?>"><?php echo $iso ?></a></li>
		<?php endforeach ?>
	</ul>
	<?php echo form_label($feature->name) ?>


	<div class="tab-content">
		<?php foreach($feature->get_contents() as $iso => $content): ?>
		<div class="tab-pane" id="<?php echo $iso ?>_<?php echo $feature->feature_id?>">
			<?php echo form_input('features['.$iso.']['.$feature->feature_id.'][value]', set_value('features['.$iso.']['.$feature->feature_id.'][value]', $content->value)) ?> <?php echo $content->extra ?>
			<?php echo form_hidden('features['.$iso.']['.$feature->feature_id.'][group_features_id]', $group_id) ?>
		</div> 
		<?php endforeach ?>
	</div>
	
<?php endif ?>