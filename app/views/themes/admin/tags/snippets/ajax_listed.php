<div class="item" id="video_<?php echo $item->id ?>" style="padding: 8px 12px; margin-bottom:2px; background: #efefef">
	
	<label class="radio">
		<?php echo form_radio('default_video', $item->id, set_radio('defult_video', $item->id, $item->is_default($product_id))) ?>
		
		<?php echo $item->name ?>
		<a href="<?php echo $item->url ?>" target="blank" class="pull-right"><?php echo $item->url ?></a>
	</label>
	
	<?php echo form_hidden('video_list[]', $item->id) ?>
</div>