<?php

	$products = (isset($products)) ? $products : $this->front_category_model->get_category_products($category->id);
	
?>
<div class="list">
<?php if(count($products) > 0): ?>
	<?php 
	$count = 1; 
	foreach($products as $product):?>
	<article class="item-list text-field text-field-dark">
		<a class="image-wrap" href="<?php echo $product->get_route() ?>">
			<img class="image" src="<?php echo $product->get_default_image()->get_medium() ?>" alt="<?php echo $product->get_content('name') ?>">
	<!--
			<?php if(method_exists($product, 'is_new') AND $product->is_new()): ?>
			<img class="new-product" src="<?php echo base_url('assets/front/images/layout/new_product/' .$this->lang->lang(). '.png') ?>" alt="new">
			<?php endif ?>
			<div class="hover"></div>
	-->
			<span class="hover">
				<h3><?php echo $product->get_content('name') ?> <i class="fa fa-inverse fa-camera fa-1"></i></h3>
			</span>
			
		</a>
	</article>
	<?php if($count % 3 == 0): ?>
	<!--<br class="clear">-->
	<?php endif ?>
	<?php 
	$count++;
	endforeach 
	?>
	<br class="clear">
<?php else: ?>
	<div class="container">
		<p class="text-field text-center">
			Nessun prodotto inserito.
		</p>
	</div>
<?php endif ?>
</div>

<style>
	.image-wrap { position: relative; overflow: hidden}
	.hover { background: rgba(0,0,0,.6); position: absolute; width:100%; bottom:10px; left:0;  }
	.hover h3 { color:#fff; padding:10px 12px; font-size:14px }
	
	.image { position:relative; top:0; left:0; -webkit-animation: all .8s ease}
</style>

<script>
	$().ready(function () {
		$('.image-wrap').hover(
			function () {
				var wrap	= $(this);		
				var img		= wrap.children('img');
				var hover	= wrap.children('.hover');
				
				img.stop().transition({scale:1.1})
				
				//hover.stop().fadeIn(600);
				
			}, function () {
				var wrap	= $(this);
				var img		= wrap.children('img');
				var hover	= wrap.children('.hover');
				
				img.stop().transition({scale:1})
				
				//hover.fadeOut(600);
		});
	})
	
</script>