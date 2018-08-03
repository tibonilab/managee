<?php echo $item->get_content('content') ?>

<?php if(count($item->get_attachments())): ?>
<div class="green" style="margin-top:22px">
	<h5>Download</h5>
	<ul>
		<?php foreach($item->get_attachments() as $file): ?>
		<li>
			<a href="<?php echo $file->get_url() ?>">
				<i class="fa fa-file-pdf-o"></i>
				<?php echo $file->get_content('text') ?>
			</a>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif ?>