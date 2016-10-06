<div class="container breadcrumbs">
	<a href="<?php echo home_url() ?>"><i class="icon-step"></i> <?php echo lang('menu-home') ?></a> <span class="spacer">/</span>
	<?php if( ! isset($breadcrumbs['list'])): ?>
		<b><i class="icon-step"></i> <?php echo $breadcrumbs['first_item']['label'] ?></b>
	<?php else: ?>
		<a href="<?php echo $breadcrumbs['first_item']['url'] ?>"><i class="icon-step"></i> <?php echo $breadcrumbs['first_item']['label'] ?></a> <span class="spacer">/</span>

		<?php 
		$count = 1;
		foreach($breadcrumbs['list'] as $item): ?>
		<?php if($count < count($breadcrumbs['list'])): ?>
			<a href="<?php echo $item->get_route() ?>">
				<i class="icon-step"></i>
				<?php echo $item->get_content('name') ?>
			</a> 
			<span class="spacer">/</span>
			<?php else: ?>
			<b>
				<i class="icon-step"></i>
				<?php echo $item->get_content('name') ?>
			</b>
			<?php endif ?>
<?php $count++; endforeach ?>
	<?php endif ?>
</div>