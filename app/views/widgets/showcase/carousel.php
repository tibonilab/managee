<?php 

$type = (isset($type)) ? $type : NULL;
		
?>
<?php if(is_object($showcase)): ?>
<section id="carousel-home">
	<div id="carousel-slider">
	<?php foreach($showcase->get_images($type) as $image): ?>
		<div class="carousel-image-wrap">
		<img class="carousel-image" src="<?php echo $image->get_showcase() ?>" alt="">
		
		<?php if($image->get_content('description') != ''): ?>
		<div class="slogan"><?php echo $image->get_content('description') ?></div>
		<?php endif ?>
		
		</div>
	<?php endforeach ?>
	</div>
	
	<div class="container container-no-padding text-center">
		<div id="pagination"></div>
	</div>
</section>

<script src="http://malsup.github.io/jquery.cycle.all.js" type="text/javascript"></script>

	
<script>
$(document).ready(function () {
	set_carousel_proportions()
	
	$('.carousel-image-wrap').hide();
})

$(window).resize(function () {
	set_carousel_proportions()
})

$(window).load(function () {
	$('.carousel-image-wrap').first().fadeIn({
			duration		: 1000, 
			complete		: function () { 
								start_carousel() 
							} 
	})
})

function start_carousel()
{
	$('#carousel-slider').cycle(
	{
		pager				:  '#pagination',
		pagerAnchorBuilder	: function(idx, slide) { 
								return '<i class="carousel-pointer"></i>'; 
							},
		prev				: '.carousel-arrow-left',
		next				: '.carousel-arrow-right',
		pause				: 0	,
		pauseOnPagerHover	: 1,
		slideResize			: false,
		containerResize		: false,
		width				: '100%',	
		fit					: 1,
		easing				: 'easeOutCubic',
		fx					: 'fadeout'
	})
	
}

function set_carousel_proportions()
{
	var winW = $(window).width();
	var ratio = 1600/690;
	
	var height = winW/ratio;
	$('#carousel-slider, .carousel-image-wrap, .carousel-image').height(height);
	
	//console.log(height)
	
}


function set_pagination()
{
	for(n=0; n<$('#carousel-slider img').length; n++)
	{
		$('#pagination').append('<i class="carousel-pointer"></i>');
	}
	
	$('#pagination .carousel-pointer').first().addClass('active');
	
}
</script>
<?php endif ?>