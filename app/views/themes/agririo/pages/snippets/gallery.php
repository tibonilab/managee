<div class="owl-carousel owl-theme">
	<?php foreach($item->get_images('default') as $image): ?>
	
	<a href="<?php echo $image->get_big() ?>" class="fancybox" rel="item_<?php echo $item->id ?>" title="<?php echo $image->get_content('description') ?>">
		<img src="<?php echo $image->get_big() ?>" class="img-responsive img-thumbnail" alt="<?php echo $image->get_content('title')?>">
	</a>
	
	<?php endforeach ?>
</div>