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
		
		<link href="<?php echo assets_url('owl.carousel.min.css', 'js/OwlCarousel2-2.1.4/dist/assets') ?>" rel="stylesheet" type="text/css">
		<link href="<?php echo assets_url('owl.theme.default.min.css', 'js/OwlCarousel2-2.1.4/dist/assets') ?>" rel="stylesheet" type="text/css">
		<link href="<?php echo assets_url('default.css', 'css') ?>" rel="stylesheet" type="text/css">
		
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body data-spy="scroll" data-target="#navbar" id="top">
		
		
		
		<header>
			<nav class="navbar navbar-fixed-top on-top" id="navbar">

				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" aria-controls="navbar" data-target="#my-navbar" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand scrollTo" href="#top">
							<img src="<?php echo assets_url('AgriRio_logo_def.png',   'img') ?>" alt="" class="img-responsive">
						</a>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="my-navbar">
						<ul class="nav navbar-nav navbar-right">
							<li>
								<a href="tel:0721478239"><i class="fa fa-phone"></i> 0721 478239</a>
							</li>
							<!-- the menu -->
							<?php foreach($this->front_page_model->get_all(array('is_homepage' => 1)) as $page): ?>
							<li>
								<a href="#<?php echo url_title($page->get_content('title'), '-', TRUE) ?>" class="scrollTo"><?php echo $page->get_content('title') ?></a>
							</li>
							<?php endforeach ?>
							<li>
								<a href="#offerte" class="scrollTo"><?php echo $this->texts->item('offers-title') ?></a>
							</li>
							<li>
								<a href="#dintorni" class="scrollTo"><?php echo $this->texts->item('places-title') ?></a>
							</li>
							<li>
								<a href="#contatti" class="btn btn-primary scrollTo"><?php echo $this->texts->item('contacts-title') ?></a>
							</li>
							<li>
								<a href="#local" class="scrollTo"><i class="fa fa-map-marker"></i></a>
							</li>
							<!-- /the menu -->
						</ul>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>
		</header>
		
		
		<section id="main-gallery">
			<h1 class="coursive main-title"><?php echo $this->texts->item('head-main-title') ?></h1>
			<img src="<?php echo assets_url('logo-complete.png', 'img') ?>" alt="" id="main-gallery-logo">
		</section>
		
		<div class="clearfix"></div>
		
		<!-- pages -->
		<?php $count = 0; foreach($this->front_page_model->get_all(['is_homepage' => 1]) as $page): $count++; ?>
		
			<div id="<?php echo url_title($page->get_content('title'), '-', TRUE) ?>">
				<?php echo $this->layout->snippet('pages/single-item-' . $count % 2, array('item' => $page)) ?>
			</div>
		
		<?php endforeach ?>
		<!-- / pages -->
		
		<!-- offers -->
		<section class="mixed-content mixed-highlight" id="offerte">
			<div class="container">
				
				<h2 class="coursive text-center"><?php echo $this->texts->item('offers-title') ?></h2>
				<p class="text-center col-md-6 col-md-offset-3"><?php echo $this->texts->item('offers-incipit') ?></p>
				
				<div class="clearfix"></div>
								
				<div class="row">

					<?php foreach($this->db->where('published', 1)->get('offers')->result('offer') as $offer): $offer->set_content(); ?>

					<div class="col-md-4">
						<div class="highlight-box">
							<div class="highlight-head">
								<h2 class="courisve"><?php echo $offer->get_content('title') ?></h2>
							</div>
							<div class="highlight-content">

								<p class="text-center">
								<span class="price-off"><?php echo $offer->full_price ?></span>
								<span class="price"><?php echo $offer->discounted ?></span>
								</p>

								<ul>
									<?php foreach (explode(',', $offer->get_content('list')) as $item_list): ?>
									<li>
										<i class="fa fa-circle"></i> <?php echo $item_list ?>
									</li>
									<?php endforeach ?>
								</ul>
								<a href="<?php echo $offer->get_route() ?>" class="ajax-content">Vedi offerta completa</a>
							</div>
						</div>
					</div>

					<?php endforeach ?>

				</div>
			</div>
		</section>
		<!-- / offers -->
		
		<!-- places -->
		<section class="mixed-content" id="dintorni">
			<div class="container">
				<h2 class="coursive text-center"><?php echo $this->texts->item('places-title') ?></h2>
				<p class="text-center col-md-6 col-md-offset-3"><?php echo $this->texts->item('places-incipit') ?></p>

				<div class="clearfix"></div>
				
				<div class="owl-carousel owl-theme owl-places">
				<?php foreach($this->db->where('published', 1)->get('products')->result('product') as $product): ?>
				<article class="place">
					<div class="row">
						<div class="col-md-6">
                            <a href="<?php echo $product->get_default_image()->get_big() ?>" class="fancybox" title="<?php echo $product->get_content('name') ?>"><img src="<?php echo $product->get_default_image()->get_big() ?>" class="img-responsive"></a>
						</div>
						<div class="col-md-6 content">
							<h3 class="brown"><?php echo $product->get_content('name') ?> <span class="pull-right"><?php echo $product->distance ?></span></h3>
							<?php echo $product->get_content('description') ?>
						</div>
					</div>
				</article>
				<?php endforeach ?>
				</div>
			</div>
			
		</section>
		<!-- / places -->
		
		<!-- contacts -->
		<section class="mixed-content mixed-highlight" id="contatti">
			<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<h2 class="coursive text-center"><?php echo $this->texts->item('contacts-title') ?></h2>
					<p class="text-center"><?php echo $this->texts->item('contacts-incipit') ?></p>
					
					<?php echo form_open() ?>
					
						<?php echo form_input('contacts[name]', set_value(), 'class="form-control" placeholder="Il tuo nome"') ?>
					
						<?php echo form_input('contacts[phone]', set_value(), 'class="form-control" placeholder="Il tuo numero di telefono"') ?>
					
						<?php echo form_input('contacts[email]', set_value(), 'class="form-control" placeholder="La tua email"') ?>
					
						<?php echo form_textarea('contacts[msg]', set_value(), 'class="form-control" placeholder="Scrivi un messaggio ..."') ?>
						
						<label class="">
						<?php echo form_checkbox('contacts[privacy]', 1, set_checkbox('contacts[privacy]', 1, TRUE)) ?> Accetto l'<a href="<?php echo site_url('privacy-policy') ?>" class="ajax-content">informativa sulla privacy</a>
						</label>
                        
                        <div class="response"><!-- AJAX --></div>
                    
						<div class="text-center">
							<?php echo form_submit('submit', 'Invia richiesta', 'class="btn btn-primary btn-lg"') ?>
						</div>
					
					<?php echo form_close() ?>
                    
				</div>
			</div>
				</div>
			
		</section>
		<!-- /contacts -->
		
		
		<!-- info -->
		<section class="mixed-content" id="local">
			<div class="container">
				<div class="row">
					<div class="col-md-12 visible-lg">
						
						<div class="pull-right" style="width:300px">
							<h3 class="green">Trovaci su Facebook</h3>

							<div class="cookie-law-confirmed-load">
                                <!-- AJAX CONTENT LOAD AFTER COOKIE LAW CONFIRM -->
                            </div>

						</div>
						
						<div class="pull-left" style="min-width:60%">
						
							<h3 class="green">Dove siamo</h3>
						<div id="map"></div>
						<p class="localize">
							<i class="fa fa-map-marker"></i> Via Ofanto, 4 - 61010 - Rio Salso di Tavullia (PU)<br>
							<i class="fa fa-phone"></i> +39 0721 478239<br>
							<i class="fa fa-envelope"></i> <a href="#contatti" class="scrollTo">mattia.agririo@gmail.com</a>
						</p>
						
						</div>
					</div>
                    
                    
                    <div class="col-md-12 hidden-lg">
						
                        <div >
                            <h3 class="green">Dove siamo</h3>
                            <div id="map-mobile"></div>
                            <p class="localize">
                                <i class="fa fa-map-marker"></i> Via Ofanto, 4 - 61010 - Rio Salso di Tavullia (PU)<br>
                                <i class="fa fa-phone"></i> +39 0721 478239<br>
                                <i class="fa fa-envelope"></i> <a href="#contatti" class="scrollTo">mattia.agririo@gmail.com</a>
                            </p>

                        </div>

                        <div class="text-center">
                            <h3 class="green">Trovaci su Facebook</h3>
                            
                            <div class="cookie-law-confirmed-load">
                                <!-- AJAX CONTENT LOAD AFTER COOKIE LAW CONFIRM -->
                            </div>

                        </div>
					</div>
					
				</div>
			</div>
		</section>		
		<!-- / info -->
		
		<footer>
			<div class="mixed-content mixed-highlight" style="padding:20px 0 10px 0 ">
				<p class="text-center">
					Agriturismo Agririo - P.I. 02002050413 - &copy; 2016 All rights reserved - <a href="<?php echo site_url('privacy-policy') ?>" class="ajax-content">Privacy Policy</a> - <a href="<?php echo site_url('cookie-policy') ?>" class="ajax-content">Cookie Policy</a> 
                    <br><br>
                    Made with <i class="fa fa-heart" style="color:#c10"></i> by<a href="http://www.tibonilab.com" target="_blank">
                        <img src="http://www.tibonilab.com/assets/tibonilab/images/logo2.png" alt="" style="margin:-10px 0 0 -6px; width:26px">
                        </a>
                    </p>
				</p>
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