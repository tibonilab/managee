<section class="mixed-content mixed-highlight hidden-sm hidden-xs">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
                <h2 class="coursive"><?php echo $item->get_content('title') ?></h2>
				<?php echo $this->layout->snippet('pages/info', array('item' => $item)) ?>
			</div>
			<div class="col-md-6">
				<?php echo $this->layout->snippet('pages/gallery', array('item' => $item)) ?>
			</div>
		</div>
	</div>
</section>

<section class="mixed-content mixed-highlight hidden-lg hidden-md">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
                <h2 class="coursive"><?php echo $item->get_content('title') ?></h2>
                <div class="clearfix"></div>
				<?php echo $this->layout->snippet('pages/gallery', array('item' => $item)) ?>
                <div class="clearfix"></div>
				<?php echo $this->layout->snippet('pages/info', array('item' => $item)) ?>
			</div>
		</div>
	</div>
</section>