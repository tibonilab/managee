<?php if(is_object($showcase)): ?>
<section id="carousel-home">
	<div id="carousel-slider">
	<?php if($showcase->is_featured()): ?>
		<?php foreach($showcase->get_images() as $product): ?>
			<a href="<?php echo $product->get_route() ?>" class="carousel-image-wrap">
				<img class="carousel-image" src="<?php echo $product->get_default_image()->get_big() ?>" alt="">
			</a>
		<?php endforeach ?>
	<?php else: ?>
		<?php foreach($showcase->get_images() as $image): ?>
			<div class="carousel-image-wrap">
			<img class="carousel-image" src="<?php echo $image->get_big() ?>" alt="">

			<?php if($image->get_content('description') != ''): ?>
			<div class="slogan"><?php echo $image->get_content('description') ?></div>
			<?php endif ?>

			</div>
		<?php endforeach ?>
	<?php endif ?>
	</div>
	
	<div class="container container-no-padding text-center">
		<div id="pagination"></div>
	</div>
	<div class="shadow shadow-right"></div>
	<div class="shadow shadow-left"></div>
	
	<div class="arrows arrow-right"></div>
	<div class="arrows arrow-left"></div>
</section>
<?php endif ?>


<script>
var params	= {}
var objects = {}
$().ready(function () {
	init_slider();
})

$(window).load(function () {
	show_slider();
})

function show_slider()
{
	objects.images.fadeIn()
	
	start_slider()
}

function init_slider()
{	
	params = {
		itemW		: $('.carousel-image-wrap').eq(0).outerWidth(true),
		left		: 0,
		n_items		: $('.carousel-image').length,
		min_left	: 0,
		max_left	: 0,
		//timer		: 0,
		finished	: false
	}
	
	objects = {
		carousel	: $('#carousel-home'),
		slider		: $('#carousel-slider'),
		arrows		: $('.arrows'),
		arrow_left	: $('.arrow-left'),
		arrow_right	: $('.arrow-right'),
		images		: $('.carousel-image')
	}
	
	var init_left = ($(window).width() - params.itemW) / 2;
	var left;
	params.left = init_left;
	params.min_left = (-1) * parseInt(params.itemW) * (parseInt(params.n_items) - 1) + init_left;
	params.max_left = init_left;
	
	objects.slider.css({'left' : init_left})
	
	objects.arrow_left.hide();
	
	objects.arrows.on('click', function () {
		
		stop_slider()
		
		if($(this).hasClass('arrow-right'))
		{
			params.left = params.left - params.itemW;
			if (params.left <= params.min_left) 
			{
				params.finished = true;
				params.left = params.min_left
				objects.arrow_right.fadeOut();
			}
			objects.arrow_left.fadeIn();
		}	
		else
		{
			params.left = params.left + params.itemW;
			if (params.left >= params.max_left) 
			{
				params.finished = false;
				params.left = params.max_left
				objects.arrow_left.fadeOut();
			}
			objects.arrow_right.fadeIn();
		}
		
		objects.slider.stop().animate({'left' : params.left}, 1000, 'easeInOutCubic')
	})
	
	/*objects.carousel.on('mousewheel', function (e, d) {
		stop_slider()
		
		left = left + (d * params.itemW);

		if (left <= params.min_left) 
		{
			params.finished = true;
			left = params.min_left
			objects.arrow_right.fadeOut();
		}
		else
		{
			objects.arrow_right.fadeIn();
		}
		if (left >= params.max_left) 
		{
			params.finished = false;
			left = params.max_left
			objects.arrow_left.fadeOut();
		}
		else
		{
			objects.arrow_left.fadeIn();
		}
		objects.slider.stop().animate({'left' : left}, 1000, 'easeInOutCubic')
	})*/
	
	objects.carousel.hover(function () {
		stop_slider()
	}, function () {
		start_slider()
	})
}

function start_slider()
{
	do_slider('continuous')
	//params.timer = setInterval( function () { do_slider('continuous') } , 3500);
}

function stop_slider()
{
	clearInterval(params.timer);
}

function do_slider(type)
{
	
	switch(type)
	{
		case 'continuous':
			clearInterval(params.timer);
			params.timer = setInterval(function () { 
				params.left = params.left - 1
				if(params.left <= params.min_left)
				{
					objects.arrow_right.fadeOut();
					objects.arrow_left.fadeIn();
				}
				else
				{
					if(params.left < params.max_left)
					{
						objects.arrow_left.fadeIn();
					}

					objects.slider.css({'left' : params.left}) 
				}
			}, 12)
		break;

		case 'step':
			if(params.finished != true)
			{
				objects.arrow_right.trigger('click');
			}
			else
			{
				params.left = params.max_left
				objects.slider.stop().animate({'left' : params.left}, 1000, 'easeInOutCubic')
				params.finished = false;
				objects.arrow_right.fadeIn();
				objects.arrow_left.fadeOut();
			}
		break;
	}

}

</script>


<style>
	/*body * { transition:all .5s; -webkit-transition:all .5s; -moz-transition:all .5s; }*/
</style>