<?php

if( ! isset($list))
{
	$list = array();//$this->front_news_model->get_all();
}

?> 

<?php foreach($list as $item): ?>
<div class="row">
	<div class="col-sm-3">
		<img src="<?php echo $item->get_default_image()->get_squared() ?>" class="img-responsive img-circle" style="margin-top: 40px">
	</div>
	<div class="col-sm-9">
		<article class="news-list text-field text-field-dark">
			<img src="" alt="">
			<h3>
				<?php echo $item->get_content('title') ?>
				<!--
				<span><?php echo $item->get_date() ?></span>
				-->
			</h3>
			<p><?php echo $item->get_content('content', 500) ?></p>
			<br class="clear">
			<a class="more btn btn-primary" href="<?php echo $item->get_route() ?>">Vai all'offerta</a>
			<br class="clear">
		</article>
	</div>
</div>
<br class="clear">
<?php endforeach ?>
