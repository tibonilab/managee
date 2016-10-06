<div class="carousel-wrap">
	<div id="myCarousel" class="top-carousel">
		<?php foreach($showcase->get_images() as $image): ?>
			<img src="<?php echo $image->get_showcase() ?>">
		<?php endforeach ?>
	</div>
</div>

<script>
$(document).ready(function () {
	$('.top-carousel').owlCarousel({
		items			: 1,
		loop			: true,
		autoplay		: true,
		nav				: true,
		navText			: ['<i class="glyphicon glyphicon-chevron-left"></i>','<i class="glyphicon glyphicon-chevron-right"></i>'],
		dots			: true,
		lazyLoad		: true,
	});
})
</script>