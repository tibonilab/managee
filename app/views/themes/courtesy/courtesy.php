<div class="container-fluid">
	<!--<nav class="navbar navbar-default">-->
	
	
	<a href="https://app.taskom.at/login" class="btn btn-default pull-right" style="margin-top:12px">LOGIN</a>
	
		<div class="container text-center">
			
			
		<img src="<?php echo assets_url('taskomat-logo-color.png', 'img') ?>" alt="Taskomat" class="img-responsive" style="margin:18px auto; max-width: 320px" >
		
        </div><!--/.nav-collapse -->
		
		
      </div>
    <!--</nav>-->
</div>


<div style="background: #72e0bb;padding-top:40px; padding-bottom:40px; color:#fff" class="text-center">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h1 style="color:#fff">Work smart, live more</h1>
				<h2>
					The easiest way to freelance is now available!<br>
					<!--You have <b class="remaining">2'</b> to register for beta access.-->
				</h2>
				
				<h3>Be part of our first 50 beta users and get <u>unlimited free access</u>!</h3>
				
				<!--
				
				<div class="progress" style="height:44px; margin: 30px auto 70px auto">
					<div class="progress-bar" role="progressbar" aria-valuenow="0"	aria-valuemin="0" aria-valuemax="100" style="width:0%; background: #2dbcfe">
					</div>
				</div>
				
				
				<?php echo form_open(base_url('ajax/subscribe')) ?>
				
				<div class="row">
					<div class="col-md-8">
						<?php echo form_input('email', '', 'class="form-control text-center" placeholder="Your email here"') ?>
					</div>
					<div class="col-md-4">
						<?php echo form_submit('submit', 'Sign up now', 'class="btn btn-primary btn-lg btn-block" style="cursor:pointer"') ?>
					</div>
				</div>
				
				<div class="error"></div>
				<div class="warning"></div>
				<div class="success"></div>
				
				<?php echo form_close() ?>
				-->
				
				<a href="https://app.taskom.at/register" class="btn btn-primary btn-lg" style="padding:25px 60px; margin-top:25px;">Sign up for beta access</a>
				
				
			
			</div>
		</div>
	</div>
</div>


<div class="container-fluid" style="padding-top:80px; padding-bottom:80px">
	<div class="col-md-6 hidden-sm hidden-xs">
		<img src="<?php echo assets_url('taskomat-screenshot.jpg', 'img') ?>" alt="" class="img-responsive" style="left:-36%; position: relative; opacity:.6">
	</div>
	<div class="col-md-5 abstract" style="color:#909090">
		<img src="<?php echo assets_url('taskomat-logo-color.png', 'img') ?>" alt="Taskomat" class="img-responsive" style="margin:18px auto; max-width: 220px" >
		<?php echo $this->texts->item('taskomat-abstract') ?>
	</div>
</div>

<hr>

<div class="container">
	
	<h2 class="text-center" style="color:#909090">Main features</h2>
	
	<div class="row text-center featured-grid">
		<div class="col-md-4 featured-grid-item">
			<div class="featured-grid-icon-wp">
				<img src="<?php echo assets_url('icona1color2.png', 'img') ?>" alt="" class="img-responsive featured-grid-icon">
			</div>
			<?php echo $this->texts->item('courtesy-item1') ?>
		</div>
		<div class="col-md-4 featured-grid-item">
			<div class="featured-grid-icon-wp">
				<img src="<?php echo assets_url('icona2color2.png', 'img') ?>" alt="" class="img-responsive featured-grid-icon">
			</div>
			<?php echo $this->texts->item('courtesy-item2') ?>
		</div>
		<div class="col-md-4 featured-grid-item">
			<div class="featured-grid-icon-wp">
				<img src="<?php echo assets_url('icona3color3.png', 'img') ?>" alt="" class="img-responsive featured-grid-icon">
			</div>
			<?php echo $this->texts->item('courtesy-item3') ?>
		</div>
		
		<div class="clearfix"></div>
		
		<div class="col-md-4 featured-grid-item">
			<div class="featured-grid-icon-wp">
				<img src="<?php echo assets_url('icona4color2.png', 'img') ?>" alt="" class="img-responsive featured-grid-icon">
			</div>
			<?php echo $this->texts->item('courtesy-item4') ?>
		</div>
		<div class="col-md-4 featured-grid-item">
			<div class="featured-grid-icon-wp">
				<img src="<?php echo assets_url('icona5color2.png', 'img') ?>" alt="" class="img-responsive featured-grid-icon">
			</div>
			<?php echo $this->texts->item('courtesy-item5') ?>
			
		</div>
		<div class="col-md-4 featured-grid-item">
			<div class="featured-grid-icon-wp">
				<img src="<?php echo assets_url('icona6color2.png', 'img') ?>" alt="" class="img-responsive featured-grid-icon">
			</div>
			<?php echo $this->texts->item('courtesy-item6') ?>
			
		</div>
	</div>
</div>



<div style="background: #72e0bb;padding-top:40px; padding-bottom:40px; color:#fff" class="text-center">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				
				<h2>
					The easiest way to freelance is now available!<br>
					<!--You have <b class="remaining">2'</b> to register for beta access.-->
				</h2>
				
				<h3>Be part of our first 50 beta users and get <u>unlimited free access</u>!</h3>
				<a href="https://app.taskom.at/register" class="btn btn-primary btn-lg" style="padding:25px 60px; margin-top:25px;">Sign up for beta access</a>
				
				<!--
				<div class="progress" style="height:44px; margin: 30px auto 70px auto">
					<div class="progress-bar" role="progressbar" aria-valuenow="0"	aria-valuemin="0" aria-valuemax="100" style="width:0%; background: #2dbcfe">
			  
					</div>
				</div>
				
				<?php echo form_open(base_url('ajax/subscribe')) ?>
				
				<div class="row">
					<div class="col-md-8">
						<?php echo form_input('email', '', 'class="form-control text-center" placeholder="Your email here"') ?>
					</div>
					<div class="col-md-4">
						<?php echo form_submit('submit', 'Sign up now', 'class="btn btn-primary btn-lg btn-block" style="cursor:pointer"') ?>
					</div>
				</div>
				
				<div class="error"></div>
				<div class="warning"></div>
				<div class="success"></div>
				
				<?php echo form_close() ?>
				
				<h3><?php echo $open_slots ?> slots left</h3>
				-->
			</div>
		</div>
	</div>
</div>