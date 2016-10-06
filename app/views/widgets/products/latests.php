<?php


$limit		= (isset($limit)) ? $limit : 6;
$products	= isset($products) ? $products : $this->front_product_model->get_latests($limit);

//var_dump($products);

?>
<h3><?php echo $this->texts->get('layout-footer-title-featured_products') ?></h3>
<br>
<?php foreach($products as $item): ?>
<a href="<?php echo $item->get_route() ?>">
	<img src="<?php echo $item->get_default_image()->get_thumb() ?>" alt="">
</a>
<?php endforeach ?>