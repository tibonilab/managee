<!doctype html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $title_for_layout ?></title>
		<?php echo $metadata ?>
		
		<base href="<?php echo base_url() ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="google-site-verification" content="zsx3-gj34kF8FyAxJ-NVfu3T8me-YtazxmU9ysqJzIw" />
		
		<!-- Favicon -->
		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo assets_url('apple-icon-57x57.png', 'images/layout/favicon') ?>">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php echo assets_url('apple-icon-60x60.png', 'images/layout/favicon') ?>">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo assets_url('apple-icon-72x72.png', 'images/layout/favicon') ?>">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo assets_url('apple-icon-76x76.png', 'images/layout/favicon') ?>">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo assets_url('apple-icon-114x114.png', 'images/layout/favicon') ?>">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo assets_url('apple-icon-120x120.png', 'images/layout/favicon') ?>">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo assets_url('apple-icon-144x144.png', 'images/layout/favicon') ?>">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo assets_url('apple-icon-152x152.png', 'images/layout/favicon') ?>">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo assets_url('apple-icon-180x180.png', 'images/layout/favicon') ?>">
		<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo assets_url('android-icon-192x192.png', 'images/layout/favicon') ?>">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo assets_url('favicon-32x32.png', 'images/layout/favicon') ?>">
		<link rel="icon" type="image/png" sizes="96x96" href="<?php echo assets_url('favicon-96x96.png', 'images/layout/favicon') ?>">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo assets_url('favicon-16x16.png', 'images/layout/favicon') ?>">
		<link rel="manifest" href="manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="<?php echo assets_url('ms-icon-144x144.png', 'images/layout/favicon') ?>">
		<meta name="theme-color" content="#ffffff">

		<!-- Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Lato:400,300,100' rel='stylesheet' type='text/css'>
		
		<!-- CSS and JS -->
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo assets_url('courtesy.css', 'css') ?>" rel="stylesheet" media="screen">
		<?php echo $css_for_layout ?>
		
	</head>
	<body>
		
		<div id="<?php echo $this->router->fetch_class() ?>" class="main-section">
			
			<?php echo $content_for_layout ?>
			
		</div>
		
		<footer class="footer">
			<div class="container">
				
				<div class="row">
					<div class="col-md-12 text-center">
						<p>Taskomat &copy; 2016 - All rights reserved</p>
						<p style="font-size:22px">
							<a class="social-link" href="https://www.facebook.com/taskomat/" target="_blank"><i class="fa fa-facebook"></i></a> 
							<a class="social-link" href="https://twitter.com/taskomat" target="_blank"><i class="fa fa-twitter"></i></a> 
						</p>
				</div>
			</div>
			 
		</footer>
		
		<!-- JS -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="<?php echo assets_url('jquery.backstretch.min.js', 'js') ?>"></script>
		<script src="<?php echo assets_url('jquery.cookie.js', 'js') ?>"></script>
		<script src="<?php echo assets_url('main.js', 'js') ?>"></script>
		<?php echo $js_for_layout ?><script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-72032256-1', 'auto');
			ga('send', 'pageview');
			ga('set', 'anonymizeIp', true)

		</script>
		
	</body>
</html>