<div class="container-fluid">
	<!--<nav class="navbar navbar-default">-->
		<div class="container text-center">
		<img src="<?php echo assets_url('taskomat-logo-color.png', 'img') ?>" alt="Taskomat" class="img-responsive" style="margin:18px auto; max-width: 320px" >
		
        </div><!--/.nav-collapse -->
      </div>
    <!--</nav>-->
</div>




	
<div id="background">

	<div class="courtesy-line">
		
		<div class="container">

			<div class="row">
				<div class="col-md-6" style="padding-right:60px">
					<?php echo $this->texts->item('courtesy-intro') ?>
				</div>
				
				<div class="col-md-6">
					<div class="form">
						<?php echo form_open(base_url('ajax/subscribe'), 'id="subscribe"') ?>
							
							<?php echo form_input('email', '', 'class="form-control" placeholder="E-mail address (this is mandatory)"') ?>
							<?php echo form_input('name', '', 'class="form-control" placeholder="Insert your Name"') ?>
							<?php echo form_textarea('message', '', 'class="form-control" placeholder="Tell us what you\'d love to hear every morning before starting your work..." style="max-height:200px"') ?>

							

							<div class="error"></div>
							<div class="warning"></div>
							<div class="success"></div>


							<br>

							<?php echo form_submit('submit', 'Keep me updated', 'class="btn btn-primary btn-lg" style="cursor:pointer"') ?>
							
							<p class="small" style="padding:10px 0 0 0;">
								By clicking this button you accept our <a style="color:#fff; font-weight: 800" role="button" data-placement="top" data-toggle="popover" title="Privacy Policy" data-content="In accordance with Italian law 196/03 regarding the protection of personal information, Taskomat guarantees the maximum protection of all data it has been provided with.<br><br>In particular, they guarantee that all personal data transmitted to them will not be publicized nor ceded to any other person or business.<br>In any case, the furnisher may, at any moment add to, correct or erase his or her data by writing to:<br><a href='mailto:info@taskom.at'>info@taskom.at</a><br><br> With respect to the treatment of the above described personal data, the furnisher freely expresses his or her fully informed consent in the legal sense in accordance with the law.
">Privacy Policy</a>. Don't worry, we won't spam you anything!
							</p>						
						

						
						<?php echo form_close() ?>
					</div>
				</div>
			</div>

		</div>
		
	</div>
	
</div>


<div class="container">
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
