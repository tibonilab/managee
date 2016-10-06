<?php $products = $this->db->where('published', 1)->get('products')->result() ?>
<?php $news = $this->db->where('published', 1)->get('news')->result() ?>
<?php $pages = $this->db->where('published', 1)->get('pages')->result() ?>
<?php $offers = $this->db->where('published', 1)->get('offers')->result() ?>
<?php $images = $this->db->get('images')->result() ?>
<?php $professionals = $this->db->where('published', 1)->get('professionals')->result() ?>

<div class="row-fluid">
	<div class="span4 text-center">
		<h1>Luoghi</h1>
		<span class="round-number" data-placement="bottom" data-toggle="tooltip" title="Luoghi"><?php echo count($products) ?></span>
	</div>
	<div class="span4 text-center">
		<h1>News</h1>
		<span class="round-number" data-placement="bottom" data-toggle="tooltip" title="News"><?php echo count($news) ?></span>
	</div>
	<div class="span4 text-center">
		<h1>Pagine</h1>
		<span class="round-number" data-placement="bottom" data-toggle="tooltip" title="Pagine"><?php echo count($pages) ?></span>
	</div>
</div>
<br><br>
<div class="row-fluid">	
	<div class="span4 text-center">
		<h1>Membri Team</h1>
		<span class="round-number" data-placement="bottom" data-toggle="tooltip" title="Membri Team"><?php echo count($professionals) ?></span>
	</div>
	<div class="span4 text-center">
		<h1>Offerte</h1>
		<span class="round-number" data-placement="bottom" data-toggle="tooltip" title="Offerte"><?php echo count($offers) ?></span>
	</div>
	<div class="span4 text-center">
		<h1>Immagini</h1>
		<span class="round-number" data-placement="bottom" data-toggle="tooltip" title="Immagini"><?php echo count($images) ?></span>
	</div>
</div>

<style>
	.round-number { display: inline-block; border-radius:180px; text-align: center; width: 180px; height: 180px; line-height: 180px; font-size:80px; color:#fff; background: #05B2D2; letter-spacing: -4pt; font-family:impact }
</style>


<script>
$().ready(function () {
	$('.round-number').tooltip();
})
</script>