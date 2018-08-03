<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title><?php echo $title_for_layout ?></title>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		
		<!-- Font Awesome -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
		
		<!-- FancyBox -->
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css">
		
		<!-- Web Fonts -->
		<link href='https://fonts.googleapis.com/css?family=Alex+Brush' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Arimo' rel='stylesheet' type='text/css'>
		
		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo assets_url('apple-icon-57x57.png', 'img') ?>">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php echo assets_url('apple-icon-60x60.png', 'img') ?>">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo assets_url('apple-icon-72x72.png', 'img') ?>">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo assets_url('apple-icon-76x76.png', 'img') ?>">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo assets_url('apple-icon-114x114.png', 'img') ?>">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo assets_url('apple-icon-120x120.png', 'img') ?>">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo assets_url('apple-icon-144x144.png', 'img') ?>">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo assets_url('apple-icon-152x152.png', 'img') ?>">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo assets_url('apple-icon-180x180.png', 'img') ?>">
		<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo assets_url('android-icon-192x192.png', 'img') ?>">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo assets_url('favicon-32x32.png', 'img') ?>">
		<link rel="icon" type="image/png" sizes="96x96" href="<?php echo assets_url('favicon-96x96.png', 'img') ?>">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo assets_url('favicon-16x16.png', 'img') ?>">
		<link rel="manifest" href="/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="<?php echo assets_url('ms-icon-144x144.png', 'img') ?>">
		<meta name="theme-color" content="#ffffff">
		
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400" rel="stylesheet">

		<link href="<?php echo assets_url('owl.carousel.min.css', 'js/OwlCarousel2-2.1.4/dist/assets') ?>" rel="stylesheet" type="text/css">
		<link href="<?php echo assets_url('owl.theme.default.min.css', 'js/OwlCarousel2-2.1.4/dist/assets') ?>" rel="stylesheet" type="text/css">
		<link href="<?php echo assets_url('main.css', 'css') ?>" rel="stylesheet" type="text/css">
		
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		
		<?php echo $content_for_layout ?>
		
		<footer>
			<div class="mixed-content mixed-highlight" style="padding:120px 0 10px 0 ">
				<!-- <p class="text-center">
                    Made with <i class="fa fa-heart" style="color:#c10"></i> by<a href="http://www.tibonilab.com" target="_blank">
                        <img src="http://www.tibonilab.com/assets/tibonilab/images/logo2.png" alt="" style="margin:-10px 0 0 -6px; width:26px">
                        </a>
                    </p>
				</p> -->
			</div>
		</footer>
        
        <div id="cookie-bar" class="hide">
			Questo sito web fa utilizzo di cookies per erogare servizi di qualità. Proseguendo con la navigazione accetti le nostre modalità d'uso dei cookie. <a href="<?php echo site_url('cookie-policy') ?>" class="ajax-content">Ulteriori informazioni</a> <a href="#" id="accept-cookie-statement">OK</a>
		</div>
	  
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        
        <!-- jQuery Cookie & Easing -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
        
		<!-- Latest compiled and minified JavaScript -->
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		
		<!-- Backstretch -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js"></script>
		
		<!-- Google Map API -->
		<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyCRngKslUGJTlibkQ3FkfTxj3Xss1UlZDA"></script>
		
		<!-- FancyBox -->
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
		
		<!-- Owl Carousel -->
		<script src="<?php echo assets_url('owl.carousel.min.js', 'js/OwlCarousel2-2.1.4/dist') ?>"></script>
		
		<!-- App -->
		<script src="<?php echo assets_url('app.js', 'js') ?>"></script>
	</body>
</html>