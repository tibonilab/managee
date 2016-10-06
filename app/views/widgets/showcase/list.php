<?php

if( ! isset($list))
{
	$this->db->where('gallery', 1);
	$list = $this->db->get('showcases')->result('showcase');
}

?> 

<?php foreach($list as $showcase): ?>
<div class="row">
	<div class="col-md-3">
		<a href="<?php echo $showcase->get_route() ?>">
		<img src="<?php echo $showcase->get_default_image()->get_squared() ?>" alt="" class="img-responsive img-circle" style="margin-top: 40px">
		</a>
	</div>
	<div class="col-md-9">
		<h3>
			<?php echo $showcase->get_content('title') ?>
			<span>
				<?php echo count($showcase->get_images()) ?>
			</span>
		</h3>
		<div class="text_field">
			<?php echo $showcase->get_content('content') ?>
		</div>
		<a href="<?php echo $showcase->get_route() ?>" class="pull-right btn btn-primary">Guarda le foto</a>	
		<br class="clear">
	</div>
</div>
<?php endforeach ?>
