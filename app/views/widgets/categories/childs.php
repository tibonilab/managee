<?php 

$list = (isset($list)) ? $list : $this->front_category_model->get_categories();

?>

<div class="list">
<?php foreach($list as $category): ?>
<article class="item-list">
	<a class="image-wrap" href="<?php echo $category->get_route() ?>">
		<?php if(isset($cols) AND $cols == 2): ?>
		<img class="image" src="<?php echo $category->get_default_image()->get_big() ?>">
		<?php else: ?>
		<img class="image" src="<?php echo $category->get_default_image()->get_medium() ?>">
		<?php endif ?>
		<div class="hover title-line">
			<h3><?php echo $category->get_content('name') ?><i class="fa fa-inverse fa-list fa-1"></i></h3>
		</div>
	</a>
</article>
<?php endforeach ?>
</div>


<?php if(isset($cols) AND $cols == 2): ?>
<style>
	.item-list { width:49%; max-height: 600px }
	.item-list .image { max-height: 600px } 
	.item-list:nth-child(3n + 2) { margin:0; }
	.item-list:nth-child(2n + 1) { margin:0 0 35px 0 !important; }
	.item-list:nth-child(2n) { margin:0 0 35px 1.5% !important; }
</style>
<?php endif ?>


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
				
				//hover.fadeIn(600);
				
				
			}, function () {
				var wrap	= $(this);
				var img		= wrap.children('img');
				var hover	= wrap.children('.hover');

				img.stop().transition({scale:1})
				
				//hover.fadeOut(600);
		});
	})
	
</script>