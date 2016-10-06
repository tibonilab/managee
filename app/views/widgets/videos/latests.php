<?php


$limit		= (isset($limit)) ? $limit : 6;
$videos	= $this->front_video_model->get_latests($limit);

//var_dump($videos);

?>
<div class="video-list">
<?php foreach($videos as $video): ?>
<div class="video-item">
	<a href="<?php echo $video->get_route() ?>">
		<div class="embedded" data-url="<?php echo $video->url ?>"></div>
		<h3><a href="<?php echo $video->get_route() ?>"><?php echo $video->get_content('title', 30) ?></a></h3>
		<p><?php //echo $video->get_content('content') ?></p>
	</a>
</div>
<?php endforeach ?>
</div>

<script>
$().ready(function () {
	
	
	$.each($('.embedded'), function () {
		var url = $(this).data('url');
		
		var video_data	= url.match("[\?&]v=([^&#]*)");
		var video_id	= (video_data != null) ? video_data[1] : null;
		var embedded	= 'http://www.youtube.com/embed/' + video_id;
		
		var html = (video_id != null) ? '<iframe width="100%" height="280" src="'+embedded+'" frameborder="0" allowfullscreen></iframe>' : ''; 
		
		$(this).html(html)
	})
})
</script>